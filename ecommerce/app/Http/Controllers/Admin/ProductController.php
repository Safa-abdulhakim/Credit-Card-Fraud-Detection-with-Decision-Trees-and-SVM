<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Vendor;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::with(['vendor', 'category', 'brand'])
            ->when($request->search, fn($q) => $q->where('name', 'like', "%{$request->search}%"))
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->vendor_id, fn($q) => $q->where('vendor_id', $request->vendor_id))
            ->latest()
            ->paginate(15);

        $vendors = Vendor::all();
        return view('admin.products.index', compact('products', 'vendors'));
    }

    public function show(Product $product)
    {
        $product->load('vendor', 'category', 'brand', 'images', 'variants');
        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::where('is_active', true)->get();
        $brands     = Brand::where('is_active', true)->get();
        $vendors    = Vendor::where('status', 'approved')->get();
        return view('admin.products.edit', compact('product', 'categories', 'brands', 'vendors'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'status'    => 'required|in:active,inactive,draft',
            'is_featured' => 'boolean',
        ]);
        $product->update($request->only(['status', 'is_featured', 'price', 'discount_price', 'quantity']));
        return back()->with('success', 'Product updated.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted.');
    }
}
