<?php
namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Product;

class BrandController extends Controller
{
    public function show(string $slug)
    {
        $brand    = Brand::where('slug', $slug)->firstOrFail();
        $products = Product::with(['vendor', 'images'])
            ->where('brand_id', $brand->id)
            ->where('status', 'active')
            ->paginate(12);
        return view('store.brands.show', compact('brand', 'products'));
    }
}
