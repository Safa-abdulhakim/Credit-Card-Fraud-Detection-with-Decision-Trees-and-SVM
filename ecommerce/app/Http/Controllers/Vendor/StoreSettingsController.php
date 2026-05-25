<?php
namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StoreSettingsController extends Controller
{
    public function edit()
    {
        $vendor = auth()->user()->vendor;
        return view('vendor.settings', compact('vendor'));
    }

    public function update(Request $request)
    {
        $request->validate(['store_name' => 'required|string|max:255']);
        $vendor = auth()->user()->vendor;
        $vendor->update($request->only(['store_name', 'description', 'phone', 'address', 'city', 'country']));
        return back()->with('success', 'Store settings updated.');
    }
}
