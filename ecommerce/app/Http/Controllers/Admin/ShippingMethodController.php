<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShippingMethod;
use Illuminate\Http\Request;

class ShippingMethodController extends Controller
{
    public function index()
    {
        $methods = ShippingMethod::all();
        return view('admin.shipping.index', compact('methods'));
    }

    public function create() { return view('admin.shipping.create'); }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required', 'base_cost' => 'required|numeric|min:0']);
        ShippingMethod::create($request->all());
        return redirect()->route('admin.shipping-methods.index')->with('success', 'Shipping method created.');
    }

    public function edit(ShippingMethod $shippingMethod) { return view('admin.shipping.edit', compact('shippingMethod')); }

    public function update(Request $request, ShippingMethod $shippingMethod)
    {
        $shippingMethod->update($request->all());
        return redirect()->route('admin.shipping-methods.index')->with('success', 'Updated.');
    }

    public function destroy(ShippingMethod $shippingMethod)
    {
        $shippingMethod->delete();
        return redirect()->route('admin.shipping-methods.index')->with('success', 'Deleted.');
    }
}
