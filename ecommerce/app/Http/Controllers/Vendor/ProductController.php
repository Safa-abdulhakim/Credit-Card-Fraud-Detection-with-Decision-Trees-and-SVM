<?php
namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Services\ProductService;
use App\DTOs\ProductDTO;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(private ProductService $productService) {}

    public function index(Request $request)
    {
        $vendor   = auth()->user()->vendor;
        $products = $this->productService->getAll(['vendor_id' => $vendor->id]);
        return view('vendor.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->get();
        $brands     = Brand::where('is_active', true)->get();
        return view('vendor.products.create', compact('categories', 'brands'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price'       => 'required|numeric|min:0',
            'quantity'    => 'required|integer|min:0',
        ]);

        $vendor  = auth()->user()->vendor;
        $dto     = ProductDTO::fromRequest($request->all());
        $product = $this->productService->create($dto, $vendor->id);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $i => $image) {
                $path = $image->store('products', 'public');
                ProductImage::create(['product_id' => $product->id, 'image_path' => $path, 'sort_order' => $i, 'is_primary' => $i === 0]);
            }
        }

        return redirect()->route('vendor.products.index')->with('success', 'Product created successfully!');
    }

    public function edit(Product $product)
    {
        $this->authorize('update', $product);
        $categories = Category::where('is_active', true)->get();
        $brands     = Brand::where('is_active', true)->get();
        $product->load('images', 'variants');
        return view('vendor.products.edit', compact('product', 'categories', 'brands'));
    }

    public function update(Request $request, Product $product)
    {
        $this->authorize('update', $product);
        $request->validate(['name' => 'required', 'price' => 'required|numeric|min:0']);
        $dto = ProductDTO::fromRequest($request->all());
        $this->productService->update($product, $dto);
        return redirect()->route('vendor.products.index')->with('success', 'Product updated!');
    }

    public function destroy(Product $product)
    {
        $this->authorize('delete', $product);
        $this->productService->delete($product);
        return redirect()->route('vendor.products.index')->with('success', 'Product deleted.');
    }

    public function uploadImages(Request $request, Product $product)
    {
        $this->authorize('update', $product);
        $request->validate(['images.*' => 'image|max:2048']);
        $count = $product->images()->count();
        foreach ($request->file('images') as $i => $image) {
            $path = $image->store('products', 'public');
            ProductImage::create(['product_id' => $product->id, 'image_path' => $path, 'sort_order' => $count + $i]);
        }
        return back()->with('success', 'Images uploaded.');
    }

    public function deleteImage(Product $product, ProductImage $image)
    {
        $this->authorize('update', $product);
        \Storage::disk('public')->delete($image->image_path);
        $image->delete();
        return back()->with('success', 'Image deleted.');
    }
}
