<?php
namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class VendorRegistrationController extends Controller
{
    public function create()
    {
        if (auth()->user()->vendor) {
            return redirect()->route('vendor.dashboard');
        }
        return view('vendor.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'store_name'  => 'required|string|max:255|unique:vendors',
            'description' => 'nullable|string',
        ]);

        $vendor = Vendor::create([
            'user_id'     => auth()->id(),
            'store_name'  => $request->store_name,
            'slug'        => Str::slug($request->store_name),
            'description' => $request->description,
            'status'      => 'pending',
        ]);

        $vendorRole = Role::where('name', 'vendor')->first();
        auth()->user()->update(['role_id' => $vendorRole->id]);

        return redirect()->route('vendor.pending')->with('success', 'Your store has been submitted for approval!');
    }

    public function pending()
    {
        $vendor = auth()->user()->vendor;
        if ($vendor?->status === 'approved') {
            return redirect()->route('vendor.dashboard');
        }
        return view('vendor.pending', compact('vendor'));
    }
}
