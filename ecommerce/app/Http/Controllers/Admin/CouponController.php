<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::latest()->paginate(15);
        return view('admin.coupons.index', compact('coupons'));
    }

    public function create()
    {
        return view('admin.coupons.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code'           => 'required|unique:coupons',
            'type'           => 'required|in:percentage,fixed',
            'value'          => 'required|numeric|min:0',
            'minimum_amount' => 'nullable|numeric|min:0',
            'usage_limit'    => 'nullable|integer|min:1',
            'expires_at'     => 'nullable|date|after:today',
        ]);

        Coupon::create([
            'code'           => strtoupper($request->code),
            'type'           => $request->type,
            'value'          => $request->value,
            'minimum_amount' => $request->minimum_amount,
            'usage_limit'    => $request->usage_limit,
            'starts_at'      => $request->starts_at,
            'expires_at'     => $request->expires_at,
            'is_active'      => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.coupons.index')->with('success', 'Coupon created.');
    }

    public function edit(Coupon $coupon)
    {
        return view('admin.coupons.edit', compact('coupon'));
    }

    public function update(Request $request, Coupon $coupon)
    {
        $request->validate(['value' => 'required|numeric|min:0']);
        $coupon->update($request->only(['value', 'minimum_amount', 'usage_limit', 'expires_at', 'is_active']));
        return redirect()->route('admin.coupons.index')->with('success', 'Coupon updated.');
    }

    public function destroy(Coupon $coupon)
    {
        $coupon->delete();
        return redirect()->route('admin.coupons.index')->with('success', 'Coupon deleted.');
    }
}
