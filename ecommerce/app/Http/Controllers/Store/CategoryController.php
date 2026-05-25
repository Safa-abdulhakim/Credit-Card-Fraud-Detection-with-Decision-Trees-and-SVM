<?php
namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;

class CategoryController extends Controller
{
    public function show(string $slug)
    {
        $category = Category::where('slug', $slug)->where('is_active', true)->firstOrFail();
        $childIds = $category->children->pluck('id')->push($category->id);

        $products = Product::with(['vendor', 'images'])
            ->whereIn('category_id', $childIds)
            ->where('status', 'active')
            ->paginate(12);

        return view('store.categories.show', compact('category', 'products'));
    }
}
