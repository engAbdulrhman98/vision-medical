<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ActivityLog;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(StoreCategoryRequest $request)
    {
        $slug = Str::slug($request->name_en);
        if (empty($slug) || $slug == '-') {
            $slug = str_replace(' ', '-', $request->name_en);
        }

        $imagePath = null;
        if ($request->hasFile('image_file')) {
            $imagePath = \App\Services\CloudinaryService::upload($request->file('image_file'), 'categories');
        } elseif ($request->filled('image_url')) {
            $imagePath = $request->image_url;
        }

        $category = new Category();
        $category->setTranslation('name', 'ar', $request->name_ar);
        $category->setTranslation('name', 'en', $request->name_en);
        $category->setTranslation('description', 'ar', $request->description_ar);
        $category->setTranslation('description', 'en', $request->description_en);
        $category->slug = $slug;
        $category->image = $imagePath;
        $category->save();

        ActivityLog::log('قام بإضافة قسم جديد: ' . $request->name_ar . ' / ' . $request->name_en);

        return redirect()->route('admin.categories.index')->with('success', __('messages.category_created'));
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $slug = Str::slug($request->name_en);
        if (empty($slug) || $slug == '-') {
            $slug = str_replace(' ', '-', $request->name_en);
        }

        $imagePath = $category->image;
        if ($request->hasFile('image_file')) {
            if ($category->image) {
                if (str_contains($category->image, 'res.cloudinary.com')) {
                    \App\Services\CloudinaryService::delete($category->image);
                } elseif (str_contains($category->image, 'storage/categories/')) {
                    $oldPath = Str::after($category->image, 'storage/');
                    Storage::disk('public')->delete($oldPath);
                }
            }
            $imagePath = \App\Services\CloudinaryService::upload($request->file('image_file'), 'categories');
        } elseif ($request->filled('image_url')) {
            $imagePath = $request->image_url;
        }

        $category->setTranslation('name', 'ar', $request->name_ar);
        $category->setTranslation('name', 'en', $request->name_en);
        $category->setTranslation('description', 'ar', $request->description_ar);
        $category->setTranslation('description', 'en', $request->description_en);
        $category->slug = $slug;
        $category->image = $imagePath;
        $category->save();

        ActivityLog::log('قام بتحديث القسم: ' . $request->name_ar);

        return redirect()->route('admin.categories.index')->with('success', __('messages.category_updated'));
    }

    public function destroy(Category $category)
    {
        if ($category->image) {
            if (str_contains($category->image, 'res.cloudinary.com')) {
                \App\Services\CloudinaryService::delete($category->image);
            } elseif (str_contains($category->image, 'storage/categories/')) {
                $oldPath = Str::after($category->image, 'storage/');
                Storage::disk('public')->delete($oldPath);
            }
        }

        $name = $category->getTranslation('name', 'ar');
        $category->delete();

        ActivityLog::log('قام بحذف القسم: ' . $name);

        return redirect()->route('admin.categories.index')->with('success', __('messages.category_deleted'));
    }
}
