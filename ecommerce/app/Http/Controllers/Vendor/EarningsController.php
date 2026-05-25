<?php
namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\VendorWithdrawal;
use Illuminate\Http\Request;

class EarningsController extends Controller
{
    public function index()
    {
        $vendor      = auth()->user()->vendor;
        $withdrawals = $vendor->withdrawals()->latest()->get();
        return view('vendor.earnings', compact('vendor', 'withdrawals'));
    }

    public function requestWithdrawal(Request $request)
    {
        $request->validate(['amount' => 'required|numeric|min:10']);
        $vendor = auth()->user()->vendor;

        if ($request->amount > $vendor->pending_withdrawal) {
            return back()->with('error', 'Insufficient balance.');
        }

        VendorWithdrawal::create([
            'vendor_id'      => $vendor->id,
            'amount'         => $request->amount,
            'payment_method' => $request->payment_method ?? 'bank_transfer',
            'status'         => 'pending',
        ]);

        return back()->with('success', 'Withdrawal request submitted.');
    }
}
