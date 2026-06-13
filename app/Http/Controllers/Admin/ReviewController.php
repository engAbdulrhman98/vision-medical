<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $query = Review::with('product');

        if ($request->filled('status')) {
            if ($request->status == 'approved') {
                $query->where('is_approved', true);
            } elseif ($request->status == 'pending') {
                $query->where('is_approved', false);
            }
        }

        $reviews = $query->latest()->paginate(15);
        return view('admin.reviews.index', compact('reviews'));
    }

    public function approve(Review $review)
    {
        $review->update(['is_approved' => true]);

        ActivityLog::log("وافق على تقييم العميل ({$review->reviewer_name}) على منتج ({$review->product->name})");

        return back()->with('success', __('messages.review_approved'));
    }

    public function destroy(Review $review)
    {
        $reviewer = $review->reviewer_name;
        $productName = $review->product->name;
        $review->delete();

        ActivityLog::log("حذف تقييم العميل ({$reviewer}) على منتج ({$productName})");

        return back()->with('success', __('messages.review_deleted'));
    }
}
