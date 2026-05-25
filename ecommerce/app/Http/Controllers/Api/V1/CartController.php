<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Services\CartService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(private CartService $cartService) {}

    public function index(Request $request): JsonResponse
    {
        $cart = $this->cartService->getOrCreateCart($request);
        $cart->load('items.product.images', 'items.variant');
        return response()->json(['cart' => $cart, 'total' => $cart->total, 'item_count' => $cart->item_count]);
    }

    public function add(Request $request): JsonResponse
    {
        $request->validate(['product_id' => 'required|exists:products,id', 'quantity' => 'integer|min:1']);
        $cart = $this->cartService->getOrCreateCart($request);
        $item = $this->cartService->addItem($cart, $request->product_id, $request->quantity ?? 1, $request->variant_id);
        return response()->json(['message' => 'Added to cart.', 'item' => $item], 201);
    }

    public function update(Request $request, CartItem $item): JsonResponse
    {
        $request->validate(['quantity' => 'required|integer|min:0']);
        $this->cartService->updateQuantity($item, $request->quantity);
        return response()->json(['message' => 'Cart updated.']);
    }

    public function remove(CartItem $item): JsonResponse
    {
        $this->cartService->removeItem($item);
        return response()->json(['message' => 'Item removed.']);
    }
}
