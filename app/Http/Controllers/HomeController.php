<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Setting;
use App\Models\Review;
use App\Models\ContactMessage;
use App\Http\Requests\StoreContactRequest;
use App\Http\Requests\StoreReviewRequest;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the home page with a focus on maintenance services and a featured store preview.
     */
    public function index(Request $request)
    {
        $featuredProducts = Product::where('in_stock', true)->with(['category', 'brand'])->latest()->limit(6)->get();
        return view('home', compact('featuredProducts'));
    }

    /**
     * Display the searchable and filterable store page.
     */
    public function store(Request $request)
    {
        $query = Product::query()->where('in_stock', true);

        // Search by name or description
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name->ar', 'like', "%{$search}%")
                  ->orWhere('name->en', 'like', "%{$search}%")
                  ->orWhere('description->ar', 'like', "%{$search}%")
                  ->orWhere('description->en', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($request->filled('category')) {
            $categorySlug = $request->input('category');
            $category = Category::where('slug', $categorySlug)->first();
            if ($category) {
                $query->where('category_id', $category->id);
            }
        }

        // Filter by brand
        if ($request->filled('brand')) {
            $brandSlug = $request->input('brand');
            $brand = Brand::where('slug', $brandSlug)->first();
            if ($brand) {
                $query->where('brand_id', $brand->id);
            }
        }

        $products = $query->with(['category', 'brand'])->latest()->paginate(12);
        
        $categories = Category::withCount('products')->get();
        $brands = Brand::withCount('products')->get();
        
        return view('store', compact('products', 'categories', 'brands'));
    }

    /**
     * Display product detail page.
     */
    public function product($slug)
    {
        $product = Product::where('slug', $slug)
            ->with(['category', 'brand', 'approvedReviews'])
            ->firstOrFail();
            
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->limit(4)
            ->get();

        return view('product', compact('product', 'relatedProducts'));
    }

    /**
     * Display the About Us page.
     */
    public function about()
    {
        $locale = app()->getLocale();
        $title = Setting::getValue('about_us_title_' . $locale, Setting::getValue('about_us_title_ar', 'من نحن - فيجن ميديكال'));
        $content = Setting::getValue('about_us_content_' . $locale, Setting::getValue('about_us_content_ar', 'نحن في فيجن ميديكال نوفر أفضل المستلزمات الطبية.'));
        
        return view('about', compact('title', 'content'));
    }

    /**
     * Display the Contact Us page.
     */
    public function contact()
    {
        $email = Setting::getValue('store_email', 'info@vision-medical.com');
        $phone = Setting::getValue('store_phone', '+20 100 123 4567');
        $whatsapp = Setting::getValue('whatsapp', '201001234567');
        $mapLink = Setting::getValue('company_map_link', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3624.471946808796!2d46.6713917!3d24.7135517!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3e2f03890d48939b%3A0xf64f7dfd3d4b68db!2sRiyadh%20Saudi%20Arabia!5e0!3m2!1sen!2ssa!4v1717540000000!5m2!1sen!2ssa');
        
        return view('contact', compact('email', 'phone', 'whatsapp', 'mapLink'));
    }

    /**
     * Handle submission of contact form.
     */
    public function submitContact(StoreContactRequest $request)
    {
        ContactMessage::create($request->validated());

        return back()->with('success', __('messages.contact_success'));
    }

    /**
     * Handle submission of product review.
     */
    public function submitReview(StoreReviewRequest $request, $productId)
    {
        Review::create([
            'product_id' => $productId,
            'reviewer_name' => $request->reviewer_name,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'is_approved' => false,
        ]);

        return back()->with('success', __('messages.review_success'));
    }
}
