<?php
namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use App\Models\Product;

class VendorController extends Controller
{
    public function index()
    {
        $vendors = Vendor::with('user')->where('status', 'approved')->paginate(12);
        return view('store.vendors.index', compact('vendors'));
    }

    public function show(string $slug)
    {
        $vendor   = Vendor::where('slug', $slug)->where('status', 'approved')->firstOrFail();
        $products = Product::with('images')
            ->where('vendor_id', $vendor->id)
            ->where('status', 'active')
            ->paginate(12);
        return view('store.vendors.show', compact('vendor', 'products'));
    }
}
