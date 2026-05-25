<?php
namespace App\Services;

use App\Models\Product;
use App\Models\InventoryLog;
use App\DTOs\ProductDTO;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ProductService
{
    public function getAll(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = Product::with(['vendor', 'category', 'brand', 'images'])
            ->when(isset($filters['status']), fn($q) => $q->where('status', $filters['status']))
            ->when(isset($filters['vendor_id']), fn($q) => $q->where('vendor_id', $filters['vendor_id']))
            ->when(isset($filters['category_id']), fn($q) => $q->where('category_id', $filters['category_id']))
            ->when(isset($filters['search']), fn($q) => $q->where('name', 'like', "%{$filters['search']}%"))
            ->when(isset($filters['min_price']), fn($q) => $q->where('price', '>=', $filters['min_price']))
            ->when(isset($filters['max_price']), fn($q) => $q->where('price', '<=', $filters['max_price']))
            ->when(isset($filters['is_featured']), fn($q) => $q->where('is_featured', true));

        $sortField = $filters['sort'] ?? 'created_at';
        $sortDir = $filters['direction'] ?? 'desc';
        $query->orderBy($sortField, $sortDir);

        return $query->paginate($perPage);
    }

    public function create(ProductDTO $dto, int $vendorId): Product
    {
        return DB::transaction(function () use ($dto, $vendorId) {
            $product = Product::create([
                'vendor_id'         => $vendorId,
                'category_id'       => $dto->categoryId,
                'brand_id'          => $dto->brandId,
                'name'              => $dto->name,
                'slug'              => $this->generateSlug($dto->name),
                'description'       => $dto->description,
                'short_description' => $dto->shortDescription,
                'sku'               => $dto->sku ?? $this->generateSku(),
                'price'             => $dto->price,
                'discount_price'    => $dto->discountPrice,
                'quantity'          => $dto->quantity,
                'status'            => $dto->status,
                'is_featured'       => $dto->isFeatured,
                'meta_title'        => $dto->metaTitle,
                'meta_description'  => $dto->metaDescription,
                'tags'              => $dto->tags,
            ]);

            $this->logInventoryChange($product, 0, $dto->quantity, 'initial_stock', 'Product created');

            return $product;
        });
    }

    public function update(Product $product, ProductDTO $dto): Product
    {
        return DB::transaction(function () use ($product, $dto) {
            $oldQty = $product->quantity;

            $product->update([
                'category_id'       => $dto->categoryId,
                'brand_id'          => $dto->brandId,
                'name'              => $dto->name,
                'slug'              => $product->slug !== Str::slug($dto->name)
                    ? $this->generateSlug($dto->name)
                    : $product->slug,
                'description'       => $dto->description,
                'short_description' => $dto->shortDescription,
                'sku'               => $dto->sku,
                'price'             => $dto->price,
                'discount_price'    => $dto->discountPrice,
                'quantity'          => $dto->quantity,
                'status'            => $dto->status,
                'is_featured'       => $dto->isFeatured,
                'meta_title'        => $dto->metaTitle,
                'meta_description'  => $dto->metaDescription,
                'tags'              => $dto->tags,
            ]);

            if ($oldQty !== $dto->quantity) {
                $this->logInventoryChange($product, $oldQty, $dto->quantity, 'manual_adjustment', 'Stock updated by vendor');
            }

            return $product->fresh();
        });
    }

    public function delete(Product $product): void
    {
        $product->delete();
    }

    public function adjustStock(Product $product, int $quantity, string $action, ?int $orderId = null, string $note = ''): void
    {
        DB::transaction(function () use ($product, $quantity, $action, $orderId, $note) {
            $before = $product->quantity;
            $product->increment('quantity', $quantity);
            $this->logInventoryChange($product, $before, $before + $quantity, $action, $note, $orderId);
        });
    }

    public function reserveStock(Product $product, int $quantity): bool
    {
        if ($product->available_quantity < $quantity) return false;
        $product->increment('reserved_quantity', $quantity);
        return true;
    }

    public function releaseReservedStock(Product $product, int $quantity): void
    {
        $product->decrement('reserved_quantity', min($quantity, $product->reserved_quantity));
    }

    private function logInventoryChange(Product $product, int $before, int $after, string $action, string $note, ?int $orderId = null): void
    {
        InventoryLog::create([
            'product_id'      => $product->id,
            'action'          => $action,
            'quantity_before' => $before,
            'quantity_change' => $after - $before,
            'quantity_after'  => $after,
            'order_id'        => $orderId,
            'note'            => $note,
        ]);
    }

    private function generateSlug(string $name): string
    {
        $slug = Str::slug($name);
        $count = Product::where('slug', 'like', "{$slug}%")->count();
        return $count > 0 ? "{$slug}-{$count}" : $slug;
    }

    private function generateSku(): string
    {
        return 'SKU-' . strtoupper(Str::random(8));
    }
}
