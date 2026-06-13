@extends('layouts.admin')

@section('page_title', 'إدارة المنتجات الطبية')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <div class="text-sm font-medium text-slate-500">
            هنا يمكنك إضافة وتحديث وحذف الأجهزة والمعدات الطبية المعروضة في الكتالوج.
        </div>
        <a href="{{ route('admin.products.create') }}" class="flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm px-5 py-3 rounded-xl transition-all-300 shadow-md shadow-emerald-600/10">
            <i class="fa-solid fa-plus text-xs"></i>
            <span>إضافة منتج جديد</span>
        </a>
    </div>

    <!-- Filters Block -->
    <div class="bg-white border border-slate-100 rounded-2xl p-5 mb-6 shadow-xs animate-fade-in">
        <form action="{{ route('admin.products.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
            
            <!-- Search Text -->
            <div class="space-y-1">
                <label for="search" class="block text-xs font-bold text-slate-400">ابحث عن منتج</label>
                <div class="relative">
                    <i class="fa-solid fa-magnifying-glass absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    <input type="text" name="search" id="search" value="{{ request('search') }}" 
                           placeholder="اسم المنتج، الماركة، الوصف..." 
                           class="w-full bg-slate-50 border border-slate-100 focus:border-emerald-500 focus:bg-white rounded-xl pl-3 pr-9 py-2.5 text-slate-900 text-xs focus:outline-hidden transition-all-300">
                </div>
            </div>

            <!-- Category Filter -->
            <div class="space-y-1">
                <label for="category_id" class="block text-xs font-bold text-slate-400">القسم الطبي</label>
                <select name="category_id" id="category_id" 
                        class="w-full bg-slate-50 border border-slate-100 focus:border-emerald-500 focus:bg-white rounded-xl px-3 py-2.5 text-slate-900 text-xs focus:outline-hidden transition-all-300">
                    <option value="">جميع الأقسام</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Brand Filter -->
            <div class="space-y-1">
                <label for="brand_id" class="block text-xs font-bold text-slate-400">الماركة / العلامة التجارية</label>
                <select name="brand_id" id="brand_id" 
                        class="w-full bg-slate-50 border border-slate-100 focus:border-emerald-500 focus:bg-white rounded-xl px-3 py-2.5 text-slate-900 text-xs focus:outline-hidden transition-all-300">
                    <option value="">جميع الماركات</option>
                    @foreach($brands as $brand)
                        <option value="{{ $brand->id }}" {{ request('brand_id') == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Stock Filter -->
            <div class="space-y-1">
                <label for="in_stock" class="block text-xs font-bold text-slate-400">حالة التوفر</label>
                <select name="in_stock" id="in_stock" 
                        class="w-full bg-slate-50 border border-slate-100 focus:border-emerald-500 focus:bg-white rounded-xl px-3 py-2.5 text-slate-900 text-xs focus:outline-hidden transition-all-300">
                    <option value="">جميع الحالات</option>
                    <option value="1" {{ request('in_stock') === '1' ? 'selected' : '' }}>متوفر في المخزون</option>
                    <option value="0" {{ request('in_stock') === '0' ? 'selected' : '' }}>غير متوفر</option>
                </select>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-end gap-2">
                <button type="submit" class="flex-grow bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs py-3 rounded-xl transition-all-300 flex items-center justify-center gap-1 shadow-sm">
                    <i class="fa-solid fa-filter"></i>
                    <span>تصفية</span>
                </button>
                @if(request('search') || request('category_id') || request('brand_id') || request('in_stock') !== null)
                    <a href="{{ route('admin.products.index') }}" class="bg-rose-50 hover:bg-rose-100 text-rose-600 font-bold text-xs px-3 py-3 rounded-xl transition-all-300 border border-rose-100 flex items-center justify-center" title="إعادة تعيين">
                        <i class="fa-solid fa-arrows-rotate"></i>
                    </a>
                @endif
            </div>

        </form>
    </div>

    <!-- Products Table -->
    <div class="bg-white border border-slate-100 rounded-2xl shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-right border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-400 text-xxs font-bold uppercase tracking-wider border-b border-slate-100">
                        <th class="px-6 py-4">صورة المنتج</th>
                        <th class="px-6 py-4">اسم المنتج</th>
                        <th class="px-6 py-4">القسم</th>
                        <th class="px-6 py-4">الماركة</th>
                        <th class="px-6 py-4">السعر</th>
                        <th class="px-6 py-4">حالة التوفر</th>
                        <th class="px-6 py-4">متوسط التقييم</th>
                        <th class="px-6 py-4 text-center">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 text-sm">
                    @if($products->isEmpty())
                        <tr>
                            <td colspan="8" class="px-6 py-10 text-center text-slate-400">
                                <i class="fa-solid fa-briefcase-medical text-3xl mb-2 block"></i>
                                لا توجد منتجات مطابقة لخيارات التصفية حالياً.
                            </td>
                        </tr>
                    @else
                        @foreach($products as $product)
                            <tr class="hover:bg-slate-50/50 transition-all-300">
                                <td class="px-6 py-4">
                                    <div class="w-14 h-14 rounded-xl bg-slate-50 border border-slate-100 overflow-hidden flex items-center justify-center">
                                        @if($product->image)
                                            <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                        @else
                                            <i class="fa-solid fa-briefcase-medical text-slate-300 text-base"></i>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-bold text-slate-900 leading-snug">
                                        <a href="{{ route('product.show', $product->slug) }}" target="_blank" class="hover:text-emerald-600 transition-all-300">{{ $product->name }}</a>
                                    </div>
                                    <span class="text-slate-400 font-mono text-[10px] block mt-0.5" dir="ltr">{{ $product->slug }}</span>
                                </td>
                                <td class="px-6 py-4 text-slate-600 font-medium">{{ $product->category->name }}</td>
                                <td class="px-6 py-4 text-slate-600 font-medium">{{ $product->brand->name }}</td>
                                <td class="px-6 py-4 font-bold text-emerald-600">
                                    {{ number_format($product->price, 2) }} <span class="text-slate-400 text-xs font-semibold">ج.م</span>
                                </td>
                                <td class="px-6 py-4">
                                    @if($product->in_stock)
                                        <span class="inline-flex items-center gap-1.5 bg-emerald-50 text-emerald-800 text-xxs font-bold px-2.5 py-1 rounded-full border border-emerald-100">
                                            <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>
                                            <span>متوفر</span>
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 bg-rose-50 text-rose-800 text-xxs font-bold px-2.5 py-1 rounded-full border border-rose-100">
                                            <span class="w-1.5 h-1.5 bg-rose-500 rounded-full"></span>
                                            <span>غير متوفر</span>
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-1.5">
                                        <div class="flex items-center text-amber-400">
                                            <i class="fa-solid fa-star text-xs"></i>
                                        </div>
                                        <span class="font-bold text-slate-900">{{ $product->averageRating() }}</span>
                                        <span class="text-slate-400 text-xxs font-semibold">({{ $product->approvedReviews->count() }})</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('admin.products.edit', $product->id) }}" class="w-9 h-9 flex items-center justify-center bg-sky-50 text-sky-600 rounded-lg hover:bg-sky-100 border border-sky-100/50 transition-all-300" title="تعديل">
                                            <i class="fa-solid fa-pen text-xs"></i>
                                        </a>
                                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="inline" onsubmit="return confirm('هل أنت متأكد من حذف هذا المنتج؟')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-9 h-9 flex items-center justify-center bg-rose-50 text-rose-600 rounded-lg hover:bg-rose-100 border border-rose-100/50 transition-all-300" title="حذف">
                                                <i class="fa-solid fa-trash-can text-xs"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($products->hasPages())
            <div class="p-6 border-t border-slate-50">
                {{ $products->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
@endsection
