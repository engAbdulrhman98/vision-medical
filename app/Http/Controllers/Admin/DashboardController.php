<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Review;
use App\Models\ContactMessage;
use App\Models\Visit;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display the consolidated admin dashboard.
     */
    public function index()
    {
        // 1. Core counters
        $stats = [
            'products' => Product::count(),
            'categories' => Category::count(),
            'brands' => Brand::count(),
            'pending_reviews' => Review::where('is_approved', false)->count(),
            'unread_messages' => ContactMessage::where('is_read', false)->count(),
            'total_visits' => Visit::count(),
            'today_visits' => Visit::whereDate('visit_date', now()->toDateString())->count(),
        ];

        // 2. Visitors chart data (last 7 days)
        $chartData = Visit::select('visit_date', DB::raw('count(*) as count'))
            ->where('visit_date', '>=', now()->subDays(6)->toDateString())
            ->groupBy('visit_date')
            ->orderBy('visit_date', 'asc')
            ->get();

        $chartLabels = [];
        $chartValues = [];
        
        // Fill dates to ensure no gaps
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->toDateString();
            $chartLabels[] = now()->subDays($i)->isoFormat('dddd YYYY-MM-DD'); // Readable format
            
            $found = $chartData->firstWhere('visit_date', $date);
            $chartValues[] = $found ? $found->count : 0;
        }

        // 3. Activity Timeline
        $activities = ActivityLog::with('user')->latest()->limit(10)->get();

        // 4. Recent pending items for quick action
        $recentReviews = Review::with('product')->where('is_approved', false)->latest()->limit(5)->get();
        $recentMessages = ContactMessage::where('is_read', false)->latest()->limit(5)->get();

        return view('admin.dashboard', compact('stats', 'chartLabels', 'chartValues', 'activities', 'recentReviews', 'recentMessages'));
    }
}
