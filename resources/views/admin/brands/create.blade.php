@extends('layouts.admin')

@section('page_title', 'إضافة ماركة تجارية جديدة | Add New Brand')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.brands.index') }}" class="text-xs font-bold text-slate-500 hover:text-emerald-600 transition-all-300 flex items-center gap-1.5 w-fit">
            <i class="fa-solid fa-arrow-right"></i>
            <span>العودة لجميع الماركات / Back to Brands</span>
        </a>
    </div>

    <!-- Form Container -->
    <div class="bg-white border border-slate-100 rounded-3xl p-6 sm:p-8 shadow-xs max-w-2xl">
        <form action="{{ route('admin.brands.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Name Arabic -->
            <div class="space-y-1.5">
                <label for="name_ar" class="block text-xs font-bold text-slate-600">اسم الماركة التجارية بالعربية (Brand Name in Arabic) *</label>
                <input type="text" name="name_ar" id="name_ar" required value="{{ old('name_ar') }}"
                       placeholder="مثال: أومرون..." 
                       class="w-full bg-slate-50 border border-slate-100 focus:border-emerald-500 focus:bg-white rounded-xl px-4 py-3 text-slate-900 text-sm focus:outline-hidden transition-all-300">
                @error('name_ar')
                    <span class="text-rose-500 text-xxs font-semibold block mt-1">{{ $message }}</span>
                @enderror
            </div>

            <!-- Name English -->
            <div class="space-y-1.5" dir="ltr">
                <label for="name_en" class="block text-xs font-bold text-slate-600 text-right">Brand Name in English *</label>
                <input type="text" name="name_en" id="name_en" required value="{{ old('name_en') }}"
                       placeholder="Example: Omron..." 
                       class="w-full bg-slate-50 border border-slate-100 focus:border-emerald-500 focus:bg-white rounded-xl px-4 py-3 text-slate-900 text-sm focus:outline-hidden transition-all-300 text-left">
                @error('name_en')
                    <span class="text-rose-500 text-xxs font-semibold block mt-1 text-right">{{ $message }}</span>
                @enderror
            </div>

            <!-- Description Arabic -->
            <div class="space-y-1.5">
                <label for="description_ar" class="block text-xs font-bold text-slate-600">وصف الماركة بالعربية (Description in Arabic)</label>
                <textarea name="description_ar" id="description_ar" rows="3" 
                          placeholder="اكتب نبذة تعريفية باللغة العربية..." 
                          class="w-full bg-slate-50 border border-slate-100 focus:border-emerald-500 focus:bg-white rounded-xl px-4 py-3 text-slate-900 text-sm focus:outline-hidden transition-all-300">{{ old('description_ar') }}</textarea>
                @error('description_ar')
                    <span class="text-rose-500 text-xxs font-semibold block mt-1">{{ $message }}</span>
                @enderror
            </div>

            <!-- Description English -->
            <div class="space-y-1.5" dir="ltr">
                <label for="description_en" class="block text-xs font-bold text-slate-600 text-right">Brand Description in English</label>
                <textarea name="description_en" id="description_en" rows="3" 
                          placeholder="Write a brief brand description in English..." 
                          class="w-full bg-slate-50 border border-slate-100 focus:border-emerald-500 focus:bg-white rounded-xl px-4 py-3 text-slate-900 text-sm focus:outline-hidden transition-all-300 text-left">{{ old('description_en') }}</textarea>
                @error('description_en')
                    <span class="text-rose-500 text-xxs font-semibold block mt-1 text-right">{{ $message }}</span>
                @enderror
            </div>

            <!-- Image Upload Options -->
            <div class="space-y-4 bg-slate-50/50 border border-slate-100 p-5 rounded-2xl">
                <h3 class="font-bold text-slate-800 text-xs flex items-center gap-2">
                    <i class="fa-regular fa-image text-emerald-600 text-sm"></i>
                    <span>شعار / صورة الماركة (Brand Logo)</span>
                </h3>
                
                <!-- File upload -->
                <div class="space-y-1.5">
                    <label for="image_file" class="block text-xxs font-semibold text-slate-500">رفع شعار من جهازك / Upload Logo</label>
                    <input type="file" name="image_file" id="image_file" accept="image/*"
                           class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 file:cursor-pointer transition-all-300">
                    @error('image_file')
                        <span class="text-rose-500 text-xxs font-semibold block mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div class="relative flex py-2 items-center">
                    <div class="flex-grow border-t border-slate-100"></div>
                    <span class="flex-shrink mx-4 text-xxs font-bold text-slate-400">أو / Or</span>
                    <div class="flex-grow border-t border-slate-100"></div>
                </div>

                <!-- Image URL -->
                <div class="space-y-1.5">
                    <label for="image_url" class="block text-xxs font-semibold text-slate-500">رابط شعار خارجي / External Logo URL</label>
                    <input type="url" name="image_url" id="image_url" value="{{ old('image_url') }}"
                           placeholder="https://images.unsplash.com/photo-..." 
                           class="w-full bg-slate-50 border border-slate-100 focus:border-emerald-500 focus:bg-white rounded-xl px-4 py-3 text-slate-900 text-sm focus:outline-hidden transition-all-300">
                    @error('image_url')
                        <span class="text-rose-500 text-xxs font-semibold block mt-1">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full sm:w-auto bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-8 py-3.5 rounded-xl shadow-md shadow-emerald-600/10 transition-all-300 text-sm">
                حفظ وإضافة الماركة / Save Brand
            </button>
        </form>
    </div>
@endsection
