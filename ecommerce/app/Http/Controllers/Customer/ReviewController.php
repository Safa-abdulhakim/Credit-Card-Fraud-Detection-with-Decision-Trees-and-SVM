<?php
namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating'     => 'required|integer|between:1,5',
            'title'      => 'nullable|string|max:255',
            'body'       => 'nullable|string',
        ]);

        $existing = Review::where('user_id', auth()->id())->where('product_id', $request->product_id)->first();
        if ($existing) {
            return back()->with('error', 'You have already reviewed this product.');
        }

        Review::create([
            'product_id'       => $request->product_id,
            'user_id'          => auth()->id(),
            'rating'           => $request->rating,
            'title'            => $request->title,
            'body'             => $request->body,
            'status'           => 'pending',
        ]);

        return back()->with('success', 'Review submitted for approval.');
    }

    public function destroy(Review $review)
    {
        $this->authorize('delete', $review);
        $review->delete();
        return back()->with('success', 'Review deleted.');
    }
}
