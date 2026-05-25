<?php
namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['vendor', 'category', 'brand', 'images'])
            ->where('status', 'active');

        if ($request->category) {
            $category = Category::where('slug', $request->category)->first();
            if ($category) $query->where('category_id', $category->id);
        }

        if ($request->brand) {
            $brand = Brand::where('slug', $request->brand)->first();
            if ($brand) $query->where('brand_id', $brand->id);
        }

        if ($request->search) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        if ($request->min_price) $query->where('price', '>=', $request->min_price);
        if ($request->max_price) $query->where('price', '<=', $request->max_price);
        if ($request->rating) $query->where('rating_avg', '>=', $request->rating);

        $sortMap = ['price_asc' => ['price', 'asc'], 'price_desc' => ['price', 'desc'], 'newest' => ['created_at', 'desc'], 'popular' => ['sold_count', 'desc'], 'rating' => ['rating_avg', 'desc']];
        [$field, $dir] = $sortMap[$request->sort] ?? ['created_at', 'desc'];
        $query->orderBy($field, $dir);

        $products   = $query->paginate(12);
        $categories = Category::where('is_active', true)->get();
        $brands     = Brand::where('is_active', true)->get();

        return view('store.products.index', compact('products', 'categories', 'brands'));
    }

    public function show(string $slug)
    {
        $product = Product::with(['vendor', 'category', 'brand', 'images', 'variants.attributes.attribute', 'variants.attributes.value', 'reviews' => fn($q) => $q->where('status', 'approved')->with('user')])
            ->where('slug', $slug)
            ->where('status', 'active')
            ->firstOrFail();

        $related = Product::with('images')
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('status', 'active')
            ->take(4)
            ->get();

        return view('store.products.show', compact('product', 'related'));
    }
}
