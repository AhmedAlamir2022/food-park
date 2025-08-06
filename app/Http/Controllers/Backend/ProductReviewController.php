<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ProductRating;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductReviewController extends Controller
{
    function index()
    {
        $reviews = ProductRating::with('product', 'user')->latest()->paginate(10);
        // $reviews = ProductRating::latest()->paginate(10);
        return view('admin.product.product-review.index', compact('reviews'));
    }

    function updateStatus(Request $request): Response
    {
        $review = ProductRating::findOrFail($request->id);
        $review->status = $request->status;
        $review->save();
        return response(['status' => 'success', 'message' => 'updated successfully!']);
    }

    function destroy(string $id): Response
    {
        try {
            $review = ProductRating::findOrFail($id);
            $review->delete();
            return response(['status' => 'success', 'message' => 'Deleted Successfully!']);
        } catch (\Exception $e) {
            return response(['status' => 'error', 'message' => 'something went wrong!']);
        }
    }
}
