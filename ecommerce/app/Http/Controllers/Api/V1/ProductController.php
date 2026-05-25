<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\ProductResource;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductController extends Controller
{
    public function __construct(private ProductService $productService) {}

    public function index(Request $request): AnonymousResourceCollection
    {
        $products = $this->productService->getAll(
            filters: $request->only(['search', 'category_id', 'brand_id', 'min_price', 'max_price', 'sort', 'direction']),
            perPage: $request->get('per_page', 15)
        );

        return ProductResource::collection($products);
    }

    public function show(Product $product): ProductResource
    {
        $product->load(['vendor', 'category', 'brand', 'images', 'variants', 'reviews' => fn($q) => $q->where('status', 'approved')->with('user')]);
        return new ProductResource($product);
    }
}
