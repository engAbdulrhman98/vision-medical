@extends('layouts.admin')

@section('page_title', 'تعديل بيانات المنتج | Edit Product')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.products.index') }}" class="text-xs font-bold text-slate-500 hover:text-emerald-600 transition-all-300 flex items-center gap-1.5 w-fit">
            <i class="fa-solid fa-arrow-right"></i>
            <span>العودة لجميع المنتجات / Back to Products</span>
        </a>
    </div>

    <!-- Form Container -->
    <div class="bg-white border border-slate-100 rounded-3xl p-6 sm:p-8 shadow-xs max-w-4xl">
        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Product Name Arabic -->
                <div class="space-y-1.5">
                    <label for="name_ar" class="block text-xs font-bold text-slate-600">اسم المنتج بالعربية (Product Name in Arabic) *</label>
                    <input type="text" name="name_ar" id="name_ar" required value="{{ old('name_ar', $product->getTranslation('name', 'ar')) }}"
                           placeholder="اسم المنتج..." 
                           class="w-full bg-slate-50 border border-slate-100 focus:border-emerald-500 focus:bg-white rounded-xl px-4 py-3.5 text-slate-900 text-sm focus:outline-hidden transition-all-300">
                    @error('name_ar')
                        <span class="text-rose-500 text-xxs font-semibold block mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Product Name English -->
                <div class="space-y-1.5" dir="ltr">
                    <label for="name_en" class="block text-xs font-bold text-slate-600 text-right">Product Name in English *</label>
                    <input type="text" name="name_en" id="name_en" required value="{{ old('name_en', $product->getTranslation('name', 'en')) }}"
                           placeholder="Product name in English..." 
                           class="w-full bg-slate-50 border border-slate-100 focus:border-emerald-500 focus:bg-white rounded-xl px-4 py-3.5 text-slate-900 text-sm focus:outline-hidden transition-all-300 text-left">
                    @error('name_en')
                        <span class="text-rose-500 text-xxs font-semibold block mt-1 text-right">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Category -->
                <div class="space-y-1.5">
                    <label for="category_id" class="block text-xs font-bold text-slate-600">القسم الطبي *</label>
                    <select name="category_id" id="category_id" required 
                            class="w-full bg-slate-50 border border-slate-100 focus:border-emerald-500 focus:bg-white rounded-xl px-4 py-3.5 text-slate-950 text-sm focus:outline-hidden transition-all-300">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <span class="text-rose-500 text-xxs font-semibold block mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Brand -->
                <div class="space-y-1.5">
                    <label for="brand_id" class="block text-xs font-bold text-slate-600">الماركة / المصنع *</label>
                    <select name="brand_id" id="brand_id" required 
                            class="w-full bg-slate-50 border border-slate-100 focus:border-emerald-500 focus:bg-white rounded-xl px-4 py-3.5 text-slate-950 text-sm focus:outline-hidden transition-all-300">
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}" {{ old('brand_id', $product->brand_id) == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                        @endforeach
                    </select>
                    @error('brand_id')
                        <span class="text-rose-500 text-xxs font-semibold block mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Price -->
                <div class="space-y-1.5">
                    <label for="price" class="block text-xs font-bold text-slate-600">سعر المنتج (ج.م) *</label>
                    <input type="number" name="price" id="price" required step="0.01" min="0" value="{{ old('price', $product->price) }}"
                           placeholder="0.00" 
                           class="w-full bg-slate-50 border border-slate-100 focus:border-emerald-500 focus:bg-white rounded-xl px-4 py-3.5 text-slate-900 text-sm focus:outline-hidden transition-all-300">
                    @error('price')
                        <span class="text-rose-500 text-xxs font-semibold block mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Availability -->
                <div class="space-y-1.5 flex flex-col justify-end pb-3">
                    <label class="flex items-center gap-3 cursor-pointer select-none">
                        <input type="hidden" name="in_stock" value="0">
                        <input type="checkbox" name="in_stock" value="1" {{ old('in_stock', $product->in_stock) ? 'checked' : '' }} 
                               class="accent-emerald-600 w-5 h-5 bg-slate-50 border-slate-100 rounded focus:ring-0">
                        <span class="text-xs font-bold text-slate-700">هذا المنتج متوفر في المخزون حالياً</span>
                    </label>
                </div>
            </div>

            <!-- Description Arabic (Short) -->
            <div class="space-y-1.5">
                <label for="description_ar" class="block text-xs font-bold text-slate-600">الوصف القصير بالعربية *</label>
                <textarea name="description_ar" id="description_ar" rows="2" required
                          placeholder="وصف مختصر يظهر في بطاقة المنتج بالعربية..." 
                          class="w-full bg-slate-50 border border-slate-100 focus:border-emerald-500 focus:bg-white rounded-xl px-4 py-3 text-slate-900 text-sm focus:outline-hidden transition-all-300">{{ old('description_ar', $product->getTranslation('description', 'ar')) }}</textarea>
                @error('description_ar')
                    <span class="text-rose-500 text-xxs font-semibold block mt-1">{{ $message }}</span>
                @enderror
            </div>

            <!-- Description English (Short) -->
            <div class="space-y-1.5" dir="ltr">
                <label for="description_en" class="block text-xs font-bold text-slate-600 text-right">Short Description in English *</label>
                <textarea name="description_en" id="description_en" rows="2" required
                          placeholder="Brief description in English..." 
                          class="w-full bg-slate-50 border border-slate-100 focus:border-emerald-500 focus:bg-white rounded-xl px-4 py-3 text-slate-900 text-sm focus:outline-hidden transition-all-300 text-left">{{ old('description_en', $product->getTranslation('description', 'en')) }}</textarea>
                @error('description_en')
                    <span class="text-rose-500 text-xxs font-semibold block mt-1 text-right">{{ $message }}</span>
                @enderror
            </div>

            <!-- Details Arabic (Long) -->
            <div class="space-y-1.5">
                <label for="details_ar" class="block text-xs font-bold text-slate-600">المواصفات والتفاصيل الطبية بالعربية</label>
                <textarea name="details_ar" id="details_ar" rows="4" 
                          placeholder="المواصفات الفنية باللغة العربية..." 
                          class="w-full bg-slate-50 border border-slate-100 focus:border-emerald-500 focus:bg-white rounded-xl px-4 py-3 text-slate-900 text-sm focus:outline-hidden transition-all-300">{{ old('details_ar', $product->getTranslation('details', 'ar')) }}</textarea>
                @error('details_ar')
                    <span class="text-rose-500 text-xxs font-semibold block mt-1">{{ $message }}</span>
                @enderror
            </div>

            <!-- Details English (Long) -->
            <div class="space-y-1.5" dir="ltr">
                <label for="details_en" class="block text-xs font-bold text-slate-600 text-right">Technical Details & Specifications in English</label>
                <textarea name="details_en" id="details_en" rows="4" 
                          placeholder="Technical details in English..." 
                          class="w-full bg-slate-50 border border-slate-100 focus:border-emerald-500 focus:bg-white rounded-xl px-4 py-3 text-slate-900 text-sm focus:outline-hidden transition-all-300 text-left">{{ old('details_en', $product->getTranslation('details', 'en')) }}</textarea>
                @error('details_en')
                    <span class="text-rose-500 text-xxs font-semibold block mt-1 text-right">{{ $message }}</span>
                @enderror
            </div>

            <!-- Current Image Preview -->
            @if($product->image)
                <div class="space-y-2">
                    <span class="block text-xs font-bold text-slate-600">صورة المنتج الحالية / Current Image</span>
                    <div class="w-32 h-20 rounded-xl overflow-hidden bg-slate-50 border border-slate-100">
                        <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                    </div>
                </div>
            @endif

            <!-- Image Upload Options -->
            <div class="space-y-4 bg-slate-50/50 border border-slate-100 p-5 rounded-2xl">
                <h3 class="font-bold text-slate-800 text-xs flex items-center gap-2">
                    <i class="fa-regular fa-image text-emerald-600 text-sm"></i>
                    <span>تحديث صورة المنتج / Update Image</span>
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- File upload -->
                    <div class="space-y-1.5">
                        <label for="image_file" class="block text-xxs font-semibold text-slate-500">رفع صورة جديدة من جهازك / Upload New Image</label>
                        <input type="file" name="image_file" id="image_file" accept="image/*"
                               class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 file:cursor-pointer transition-all-300">
                        @error('image_file')
                            <span class="text-rose-500 text-xxs font-semibold block mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Image URL -->
                    <div class="space-y-1.5">
                        <label for="image_url" class="block text-xxs font-semibold text-slate-500">تحديث عبر رابط صورة خارجي / Update by URL</label>
                        <input type="url" name="image_url" id="image_url" value="{{ old('image_url', $product->image) }}"
                               placeholder="https://images.unsplash.com/photo-..." 
                               class="w-full bg-slate-50 border border-slate-100 focus:border-emerald-500 focus:bg-white rounded-xl px-4 py-3 text-slate-900 text-sm focus:outline-hidden transition-all-300">
                        @error('image_url')
                            <span class="text-rose-500 text-xxs font-semibold block mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full sm:w-auto bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-8 py-3.5 rounded-xl shadow-md shadow-emerald-600/10 transition-all-300 text-sm">
                حفظ التعديلات / Save Changes
            </button>
        </form>
    </div>
@endsection
