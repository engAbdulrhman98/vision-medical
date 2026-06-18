<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\ActivityLog;
use App\Http\Requests\StoreBrandRequest;
use App\Http\Requests\UpdateBrandRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::latest()->paginate(10);
        return view('admin.brands.index', compact('brands'));
    }

    public function create()
    {
        return view('admin.brands.create');
    }

    public function store(StoreBrandRequest $request)
    {
        $slug = Str::slug($request->name_en);
        if (empty($slug) || $slug == '-') {
            $slug = str_replace(' ', '-', $request->name_en);
        }

        $imagePath = null;
        if ($request->hasFile('image_file')) {
            $imagePath = \App\Services\CloudinaryService::upload($request->file('image_file'), 'brands');
        } elseif ($request->filled('image_url')) {
            $imagePath = $request->image_url;
        }

        $brand = new Brand();
        $brand->setTranslation('name', 'ar', $request->name_ar);
        $brand->setTranslation('name', 'en', $request->name_en);
        $brand->setTranslation('description', 'ar', $request->description_ar);
        $brand->setTranslation('description', 'en', $request->description_en);
        $brand->slug = $slug;
        $brand->image = $imagePath;
        $brand->save();

        ActivityLog::log('قام بإضافة ماركة تجارية جديدة: ' . $request->name_ar);

        return redirect()->route('admin.brands.index')->with('success', __('messages.brand_created'));
    }

    public function edit(Brand $brand)
    {
        return view('admin.brands.edit', compact('brand'));
    }

    public function update(UpdateBrandRequest $request, Brand $brand)
    {
        $slug = Str::slug($request->name_en);
        if (empty($slug) || $slug == '-') {
            $slug = str_replace(' ', '-', $request->name_en);
        }

        $imagePath = $brand->image;
        if ($request->hasFile('image_file')) {
            if ($brand->image) {
                if (str_contains($brand->image, 'res.cloudinary.com')) {
                    \App\Services\CloudinaryService::delete($brand->image);
                } elseif (str_contains($brand->image, 'storage/brands/')) {
                    $oldPath = Str::after($brand->image, 'storage/');
                    Storage::disk('public')->delete($oldPath);
                }
            }
            $imagePath = \App\Services\CloudinaryService::upload($request->file('image_file'), 'brands');
        } elseif ($request->filled('image_url')) {
            $imagePath = $request->image_url;
        }

        $brand->setTranslation('name', 'ar', $request->name_ar);
        $brand->setTranslation('name', 'en', $request->name_en);
        $brand->setTranslation('description', 'ar', $request->description_ar);
        $brand->setTranslation('description', 'en', $request->description_en);
        $brand->slug = $slug;
        $brand->image = $imagePath;
        $brand->save();

        ActivityLog::log('قام بتحديث الماركة التجارية: ' . $request->name_ar);

        return redirect()->route('admin.brands.index')->with('success', __('messages.brand_updated'));
    }

    public function destroy(Brand $brand)
    {
        if ($brand->image) {
            if (str_contains($brand->image, 'res.cloudinary.com')) {
                \App\Services\CloudinaryService::delete($brand->image);
            } elseif (str_contains($brand->image, 'storage/brands/')) {
                $oldPath = Str::after($brand->image, 'storage/');
                Storage::disk('public')->delete($oldPath);
            }
        }

        $name = $brand->getTranslation('name', 'ar');
        $brand->delete();

        ActivityLog::log('قام بحذف الماركة التجارية: ' . $name);

        return redirect()->route('admin.brands.index')->with('success', __('messages.brand_deleted'));
    }
}
