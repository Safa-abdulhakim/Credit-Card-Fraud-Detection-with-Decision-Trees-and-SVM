<?php
namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\OrderService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct(private OrderService $orderService) {}

    public function index()
    {
        $orders = auth()->user()->orders()->with('items')->latest()->paginate(10);
        return view('customer.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $this->authorize('view', $order);
        $order->load('items.product', 'shippingAddress', 'payment', 'shipment');
        return view('customer.orders.show', compact('order'));
    }

    public function cancel(Order $order)
    {
        $this->authorize('cancel', $order);
        $this->orderService->updateStatus($order, 'cancelled');
        return back()->with('success', 'Order cancelled successfully.');
    }

    public function invoice(Order $order)
    {
        $this->authorize('view', $order);
        $order->load('user', 'items.product', 'shippingAddress');
        $pdf = Pdf::loadView('pdf.invoice', compact('order'));
        return $pdf->download("invoice-{$order->order_number}.pdf");
    }

    public function track(Order $order)
    {
        $this->authorize('view', $order);
        $order->load('shipment.shippingMethod', 'shipment.deliveryAgent.user');
        return view('customer.orders.track', compact('order'));
    }
}
