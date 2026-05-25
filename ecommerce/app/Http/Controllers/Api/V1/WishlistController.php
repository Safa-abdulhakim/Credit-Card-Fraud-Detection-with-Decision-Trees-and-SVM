<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $wishlists = $request->user()->wishlists()->with('product.images')->get();
        return response()->json($wishlists);
    }

    public function toggle(Request $request, Product $product): JsonResponse
    {
        $wishlist = Wishlist::where('user_id', $request->user()->id)->where('product_id', $product->id)->first();
        if ($wishlist) {
            $wishlist->delete();
            return response()->json(['status' => 'removed', 'message' => 'Removed from wishlist.']);
        }
        Wishlist::create(['user_id' => $request->user()->id, 'product_id' => $product->id]);
        return response()->json(['status' => 'added', 'message' => 'Added to wishlist.'], 201);
    }
}
