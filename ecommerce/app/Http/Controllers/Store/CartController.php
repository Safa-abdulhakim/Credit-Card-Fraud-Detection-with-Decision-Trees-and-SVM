<?php
namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Services\CartService;
use App\Services\CouponService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(
        private CartService   $cartService,
        private CouponService $couponService,
    ) {}

    public function index(Request $request)
    {
        $cart = $this->cartService->getOrCreateCart($request);
        $cart->load('items.product.images', 'items.variant');
        return view('store.cart.index', compact('cart'));
    }

    public function add(Request $request)
    {
        $request->validate(['product_id' => 'required|exists:products,id', 'quantity' => 'integer|min:1']);
        $cart = $this->cartService->getOrCreateCart($request);
        $this->cartService->addItem($cart, $request->product_id, $request->quantity ?? 1, $request->variant_id);

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Added to cart', 'count' => $cart->item_count]);
        }
        return back()->with('success', 'Product added to cart!');
    }

    public function update(Request $request, CartItem $item)
    {
        $request->validate(['quantity' => 'required|integer|min:0']);
        $this->cartService->updateQuantity($item, $request->quantity);
        return back()->with('success', 'Cart updated.');
    }

    public function remove(CartItem $item)
    {
        $this->cartService->removeItem($item);
        return back()->with('success', 'Item removed from cart.');
    }

    public function applyCoupon(Request $request)
    {
        $request->validate(['coupon_code' => 'required|string']);
        $cart   = $this->cartService->getOrCreateCart($request);
        $result = $this->couponService->validate($request->coupon_code, $cart->total, auth()->id() ?? 0);

        if ($result['valid']) {
            session(['coupon' => ['code' => $request->coupon_code, 'discount' => $result['discount']]]);
            return back()->with('success', $result['message']);
        }

        return back()->with('error', $result['message']);
    }
}
