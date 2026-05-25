<?php
namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function __construct(private OrderService $orderService) {}

    public function index(Request $request)
    {
        $vendor   = auth()->user()->vendor;
        $orderIds = DB::table('order_items')->where('vendor_id', $vendor->id)->distinct()->pluck('order_id');

        $orders = Order::with(['user', 'items'])
            ->whereIn('id', $orderIds)
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->latest()
            ->paginate(15);

        return view('vendor.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('user', 'items.product', 'shippingAddress', 'shipment');
        return view('vendor.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate(['status' => 'required|in:processing,shipped']);
        $this->orderService->updateStatus($order, $request->status);
        return back()->with('success', 'Order status updated.');
    }
}
