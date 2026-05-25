<?php
namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'                => $this->id,
            'name'              => $this->name,
            'slug'              => $this->slug,
            'short_description' => $this->short_description,
            'price'             => $this->price,
            'discount_price'    => $this->discount_price,
            'effective_price'   => $this->effective_price,
            'quantity'          => $this->available_quantity,
            'in_stock'          => $this->isInStock(),
            'is_featured'       => $this->is_featured,
            'rating_avg'        => $this->rating_avg,
            'rating_count'      => $this->rating_count,
            'sold_count'        => $this->sold_count,
            'thumbnail'         => $this->thumbnail ? asset('storage/' . $this->thumbnail) : null,
            'images'            => $this->whenLoaded('images', fn() => $this->images->map(fn($img) => asset('storage/' . $img->image_path))),
            'vendor'            => $this->whenLoaded('vendor', fn() => ['id' => $this->vendor->id, 'name' => $this->vendor->store_name, 'slug' => $this->vendor->slug]),
            'category'          => $this->whenLoaded('category', fn() => ['id' => $this->category->id, 'name' => $this->category->name]),
            'brand'             => $this->whenLoaded('brand', fn() => $this->brand ? ['id' => $this->brand->id, 'name' => $this->brand->name] : null),
            'variants'          => $this->whenLoaded('variants'),
            'reviews'           => $this->whenLoaded('reviews'),
            'created_at'        => $this->created_at->toISOString(),
        ];
    }
}
