<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\CartService;
use App\Services\OrderService;
use App\DTOs\CheckoutDTO;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct(
        private OrderService $orderService,
        private CartService  $cartService,
    ) {}

    public function index(Request $request): JsonResponse
    {
        $orders = $request->user()->orders()->with('items')->latest()->paginate(10);
        return response()->json($orders);
    }

    public function show(Order $order): JsonResponse
    {
        $this->authorize('view', $order);
        $order->load('items.product', 'shippingAddress', 'payment', 'shipment');
        return response()->json($order);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'address_id'     => 'required|exists:shipping_addresses,id',
            'payment_method' => 'required|in:cod,stripe,paypal',
        ]);

        $cart = $this->cartService->getOrCreateCart($request);

        if ($cart->items->isEmpty()) {
            return response()->json(['message' => 'Cart is empty.'], 422);
        }

        $dto   = CheckoutDTO::fromRequest($request->all());
        $order = $this->orderService->createFromCart($cart, $dto, $request->user()->id);

        return response()->json(['message' => 'Order placed.', 'order' => $order], 201);
    }

    public function cancel(Order $order): JsonResponse
    {
        $this->authorize('cancel', $order);
        $this->orderService->updateStatus($order, 'cancelled');
        return response()->json(['message' => 'Order cancelled.']);
    }
}
