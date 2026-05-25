<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VendorWithdrawal;
use Illuminate\Http\Request;

class WithdrawalController extends Controller
{
    public function index()
    {
        $withdrawals = VendorWithdrawal::with('vendor.user')->latest()->paginate(20);
        return view('admin.withdrawals.index', compact('withdrawals'));
    }

    public function approve(VendorWithdrawal $withdrawal)
    {
        $withdrawal->update(['status' => 'approved', 'processed_at' => now()]);
        $withdrawal->vendor->decrement('pending_withdrawal', $withdrawal->amount);
        return back()->with('success', 'Withdrawal approved.');
    }

    public function reject(VendorWithdrawal $withdrawal)
    {
        $withdrawal->update(['status' => 'rejected', 'processed_at' => now()]);
        return back()->with('success', 'Withdrawal rejected.');
    }
}
