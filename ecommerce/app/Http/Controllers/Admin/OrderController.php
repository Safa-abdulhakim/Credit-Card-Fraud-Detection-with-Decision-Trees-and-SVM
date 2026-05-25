<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    public function __construct(private OrderService $orderService) {}

    public function index(Request $request)
    {
        $orders = Order::with(['user', 'items'])
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->search, fn($q) => $q->where('order_number', 'like', "%{$request->search}%"))
            ->latest()
            ->paginate(15);

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('user', 'items.product', 'items.vendor', 'shippingAddress', 'payment', 'shipment');
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate(['status' => 'required|in:pending,paid,processing,shipped,delivered,cancelled,refunded']);
        $this->orderService->updateStatus($order, $request->status);
        return back()->with('success', 'Order status updated.');
    }

    public function invoice(Order $order)
    {
        $order->load('user', 'items.product', 'shippingAddress', 'payment');
        $pdf = Pdf::loadView('pdf.invoice', compact('order'));
        return $pdf->download("invoice-{$order->order_number}.pdf");
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('admin.orders.index')->with('success', 'Order deleted.');
    }
}
