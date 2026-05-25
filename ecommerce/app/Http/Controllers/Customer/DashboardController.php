<?php
namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $user   = auth()->user();
        $orders = $user->orders()->latest()->take(5)->get();
        $stats  = [
            'total_orders'    => $user->orders()->count(),
            'pending_orders'  => $user->orders()->where('status', 'pending')->count(),
            'delivered_orders'=> $user->orders()->where('status', 'delivered')->count(),
            'wishlist_count'  => $user->wishlists()->count(),
        ];
        return view('customer.dashboard', compact('orders', 'stats'));
    }
}
