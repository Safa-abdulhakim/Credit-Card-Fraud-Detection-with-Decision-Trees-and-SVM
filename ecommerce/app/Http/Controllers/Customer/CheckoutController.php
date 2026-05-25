<?php
namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\ShippingMethod;
use App\Services\CartService;
use App\Services\OrderService;
use App\DTOs\CheckoutDTO;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function __construct(
        private CartService  $cartService,
        private OrderService $orderService,
    ) {}

    public function index(Request $request)
    {
        $cart = $this->cartService->getOrCreateCart($request);
        $cart->load('items.product', 'items.variant');

        if ($cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $addresses = auth()->user()->shippingAddresses()->get();
        $shippingMethods = ShippingMethod::where('is_active', true)->get();

        return view('customer.checkout.index', compact('cart', 'addresses', 'shippingMethods'));
    }

    public function placeOrder(Request $request)
    {
        $request->validate([
            'address_id'     => 'required|exists:shipping_addresses,id',
            'payment_method' => 'required|in:cod,stripe,paypal',
        ]);

        $cart = $this->cartService->getOrCreateCart($request);

        if ($cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $dto   = CheckoutDTO::fromRequest($request->all());
        $order = $this->orderService->createFromCart($cart, $dto, auth()->id());

        if ($request->payment_method === 'cod') {
            $this->orderService->processPayment($order, 'cod');
        }

        return redirect()->route('customer.checkout.success', $order)->with('success', 'Order placed successfully!');
    }

    public function success(Order $order)
    {
        return view('customer.checkout.success', compact('order'));
    }
}
