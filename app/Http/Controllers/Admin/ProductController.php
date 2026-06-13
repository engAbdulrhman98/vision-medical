<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\ActivityLog;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        // Search by name, description or details
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name->ar', 'like', "%{$search}%")
                  ->orWhere('name->en', 'like', "%{$search}%")
                  ->orWhere('description->ar', 'like', "%{$search}%")
                  ->orWhere('description->en', 'like', "%{$search}%")
                  ->orWhere('details->ar', 'like', "%{$search}%")
                  ->orWhere('details->en', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }

        // Filter by brand
        if ($request->filled('brand_id')) {
            $query->where('brand_id', $request->input('brand_id'));
        }

        // Filter by stock status
        if ($request->filled('in_stock')) {
            $query->where('in_stock', $request->input('in_stock') === '1');
        }

        $products = $query->with(['category', 'brand'])->latest()->paginate(10);
        
        $categories = Category::all();
        $brands = Brand::all();
        
        return view('admin.products.index', compact('products', 'categories', 'brands'));
    }

    public function create()
    {
        $categories = Category::all();
        $brands = Brand::all();
        return view('admin.products.create', compact('categories', 'brands'));
    }

    public function store(StoreProductRequest $request)
    {
        $slug = Str::slug($request->name_en);
        if (empty($slug) || $slug == '-') {
            $slug = str_replace(' ', '-', $request->name_en);
        }

        $imagePath = null;
        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('products', 'public');
            $imagePath = asset('storage/' . $path);
        } elseif ($request->filled('image_url')) {
            $imagePath = $request->image_url;
        }

        $product = new Product();
        $product->setTranslation('name', 'ar', $request->name_ar);
        $product->setTranslation('name', 'en', $request->name_en);
        $product->setTranslation('description', 'ar', $request->description_ar);
        $product->setTranslation('description', 'en', $request->description_en);
        $product->setTranslation('details', 'ar', $request->details_ar);
        $product->setTranslation('details', 'en', $request->details_en);
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;
        $product->price = $request->price;
        $product->image = $imagePath;
        $product->in_stock = $request->has('in_stock') ? $request->in_stock : true;
        $product->slug = $slug;
        $product->save();

        ActivityLog::log('قام بإضافة منتج جديد: ' . $request->name_ar);

        return redirect()->route('admin.products.index')->with('success', __('messages.product_created'));
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        $brands = Brand::all();
        return view('admin.products.edit', compact('product', 'categories', 'brands'));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $slug = Str::slug($request->name_en);
        if (empty($slug) || $slug == '-') {
            $slug = str_replace(' ', '-', $request->name_en);
        }

        $imagePath = $product->image;
        if ($request->hasFile('image_file')) {
            if ($product->image && str_contains($product->image, 'storage/products/')) {
                $oldPath = Str::after($product->image, 'storage/');
                Storage::disk('public')->delete($oldPath);
            }
            $path = $request->file('image_file')->store('products', 'public');
            $imagePath = asset('storage/' . $path);
        } elseif ($request->filled('image_url')) {
            $imagePath = $request->image_url;
        }

        $product->setTranslation('name', 'ar', $request->name_ar);
        $product->setTranslation('name', 'en', $request->name_en);
        $product->setTranslation('description', 'ar', $request->description_ar);
        $product->setTranslation('description', 'en', $request->description_en);
        $product->setTranslation('details', 'ar', $request->details_ar);
        $product->setTranslation('details', 'en', $request->details_en);
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;
        $product->price = $request->price;
        $product->image = $imagePath;
        $product->in_stock = $request->has('in_stock') ? $request->in_stock : true;
        $product->slug = $slug;
        $product->save();

        ActivityLog::log('قام بتحديث بيانات المنتج: ' . $request->name_ar);

        return redirect()->route('admin.products.index')->with('success', __('messages.product_updated'));
    }

    public function destroy(Product $product)
    {
        if ($product->image && str_contains($product->image, 'storage/products/')) {
            $oldPath = Str::after($product->image, 'storage/');
            Storage::disk('public')->delete($oldPath);
        }

        $name = $product->getTranslation('name', 'ar');
        $product->delete();

        ActivityLog::log('قام بحذف المنتج: ' . $name);

        return redirect()->route('admin.products.index')->with('success', __('messages.product_deleted'));
    }
}
