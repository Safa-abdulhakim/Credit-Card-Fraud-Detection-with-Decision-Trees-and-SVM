<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating'     => 'required|integer|between:1,5',
            'title'      => 'nullable|string|max:255',
            'body'       => 'nullable|string',
        ]);

        $existing = Review::where('user_id', $request->user()->id)->where('product_id', $request->product_id)->first();
        if ($existing) {
            return response()->json(['message' => 'Already reviewed.'], 422);
        }

        $review = Review::create([
            'product_id' => $request->product_id,
            'user_id'    => $request->user()->id,
            'rating'     => $request->rating,
            'title'      => $request->title,
            'body'       => $request->body,
            'status'     => 'pending',
        ]);

        return response()->json(['message' => 'Review submitted.', 'review' => $review], 201);
    }
}
