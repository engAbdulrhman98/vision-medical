@extends('layouts.admin')

@section('page_title', 'إدارة المنتجات الطبية')

@section('content')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div class="text-sm font-medium text-slate-500">
            هنا يمكنك إضافة وتحديث وحذف الأجهزة والمعدات الطبية المعروضة في الكتالوج.
        </div>
        <a href="{{ route('admin.products.create') }}"
           class="flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm px-5 py-3 rounded-xl transition-all shadow-md shadow-emerald-600/10 w-full sm:w-auto shrink-0">
            <i class="fa-solid fa-plus text-xs"></i>
            <span>إضافة منتج جديد</span>
        </a>
    </div>

    {{-- Filters Block --}}
    <div class="bg-white border border-slate-100 rounded-2xl p-4 sm:p-5 mb-6 shadow-sm">
        <form action="{{ route('admin.products.index') }}" method="GET"
              class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">

            <div class="space-y-1 lg:col-span-2">
                <label for="search" class="block text-xs font-bold text-slate-400">ابحث عن منتج</label>
                <div class="relative">
                    <i class="fa-solid fa-magnifying-glass absolute end-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    <input type="text" name="search" id="search" value="{{ request('search') }}"
                           placeholder="اسم المنتج، الماركة، الوصف..."
                           class="w-full bg-slate-50 border border-slate-100 focus:border-emerald-500 focus:bg-white rounded-xl ps-3 pe-9 py-2.5 text-slate-900 text-xs focus:outline-none transition-all">
                </div>
            </div>

            <div class="space-y-1">
                <label for="category_id" class="block text-xs font-bold text-slate-400">القسم الطبي</label>
                <select name="category_id" id="category_id"
                        class="w-full bg-slate-50 border border-slate-100 focus:border-emerald-500 focus:bg-white rounded-xl px-3 py-2.5 text-slate-900 text-xs focus:outline-none transition-all">
                    <option value="">جميع الأقسام</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="space-y-1">
                <label for="brand_id" class="block text-xs font-bold text-slate-400">الماركة</label>
                <select name="brand_id" id="brand_id"
                        class="w-full bg-slate-50 border border-slate-100 focus:border-emerald-500 focus:bg-white rounded-xl px-3 py-2.5 text-slate-900 text-xs focus:outline-none transition-all">
                    <option value="">جميع الماركات</option>
                    @foreach($brands as $brand)
                        <option value="{{ $brand->id }}" {{ request('brand_id') == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex gap-2 items-end">
                <div class="space-y-1 flex-grow">
                    <label for="in_stock" class="block text-xs font-bold text-slate-400">التوفر</label>
                    <select name="in_stock" id="in_stock"
                            class="w-full bg-slate-50 border border-slate-100 focus:border-emerald-500 focus:bg-white rounded-xl px-3 py-2.5 text-slate-900 text-xs focus:outline-none transition-all">
                        <option value="">الكل</option>
                        <option value="1" {{ request('in_stock') === '1' ? 'selected' : '' }}>متوفر</option>
                        <option value="0" {{ request('in_stock') === '0' ? 'selected' : '' }}>غير متوفر</option>
                    </select>
                </div>
                <button type="submit"
                        class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs px-4 py-2.5 rounded-xl transition-all flex items-center gap-1 shadow-sm shrink-0 self-end">
                    <i class="fa-solid fa-filter text-[10px]"></i>
                    <span>تصفية</span>
                </button>
                @if(request('search') || request('category_id') || request('brand_id') || request('in_stock') !== null)
                    <a href="{{ route('admin.products.index') }}"
                       class="bg-rose-50 hover:bg-rose-100 text-rose-600 font-bold text-xs px-3 py-2.5 rounded-xl transition-all border border-rose-100 flex items-center justify-center shrink-0 self-end" title="إعادة تعيين">
                        <i class="fa-solid fa-arrows-rotate"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

    @if($products->isEmpty())
        <div class="bg-white border border-slate-100 rounded-2xl shadow-sm p-12 text-center text-slate-400">
            <i class="fa-solid fa-briefcase-medical text-4xl mb-3 block text-slate-300"></i>
            <p class="text-sm font-semibold">لا توجد منتجات مطابقة لخيارات التصفية حالياً.</p>
        </div>
    @else

        {{-- ═══ MOBILE Cards (below lg) ═══ --}}
        <div class="space-y-3 lg:hidden">
            @foreach($products as $product)
                <div class="bg-white border border-slate-100 rounded-2xl shadow-sm p-4">
                    <div class="flex gap-3">
                        {{-- Image/Video --}}
                        <div class="w-16 h-16 rounded-xl bg-slate-50 border border-slate-100 overflow-hidden flex items-center justify-center shrink-0">
                            @if($product->image)
                                @if($product->isVideo())
                                    <video src="{{ $product->image }}" class="w-full h-full object-cover" autoplay loop muted playsinline></video>
                                @else
                                    <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-full h-full object-cover" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                    <span class="hidden w-full h-full items-center justify-center bg-slate-50">
                                        <i class="fa-solid fa-briefcase-medical text-slate-300 text-lg"></i>
                                    </span>
                                @endif
                            @else
                                <i class="fa-solid fa-briefcase-medical text-slate-300 text-lg"></i>
                            @endif
                        </div>
                        {{-- Info --}}
                        <div class="min-w-0 flex-grow">
                            <a href="{{ route('product.show', $product->slug) }}" target="_blank"
                               class="text-sm font-black text-slate-900 hover:text-emerald-600 transition-all line-clamp-2 leading-snug">
                                {{ $product->name }}
                            </a>
                            <div class="flex flex-wrap gap-x-3 gap-y-1 mt-1.5 text-xs text-slate-500">
                                <span><i class="fa-solid fa-list-ul text-slate-300 me-1"></i>{{ $product->category->name }}</span>
                                <span><i class="fa-solid fa-copyright text-slate-300 me-1"></i>{{ $product->brand->name }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between mt-3 pt-3 border-t border-slate-100">
                        <div class="flex items-center gap-3">
                            <span class="font-black text-emerald-600 text-sm">{{ number_format($product->price, 2) }} <span class="text-slate-400 font-semibold text-xs">ج.م</span></span>
                            @if($product->in_stock)
                                <span class="inline-flex items-center gap-1 bg-emerald-50 text-emerald-800 text-[10px] font-bold px-2 py-0.5 rounded-full border border-emerald-100">
                                    <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span> متوفر
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 bg-rose-50 text-rose-800 text-[10px] font-bold px-2 py-0.5 rounded-full border border-rose-100">
                                    <span class="w-1.5 h-1.5 bg-rose-500 rounded-full"></span> غير متوفر
                                </span>
                            @endif
                            <span class="flex items-center gap-1 text-xs text-slate-500">
                                <i class="fa-solid fa-star text-amber-400 text-[10px]"></i>
                                {{ $product->averageRating() }} ({{ $product->approvedReviews->count() }})
                            </span>
                        </div>
                        <div class="flex gap-2">
                            <a href="{{ route('admin.products.edit', $product->id) }}"
                               class="w-9 h-9 flex items-center justify-center bg-sky-50 text-sky-600 rounded-lg hover:bg-sky-100 border border-sky-100/50 transition-all">
                                <i class="fa-solid fa-pen text-xs"></i>
                            </a>
                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST"
                                  onsubmit="return confirm('هل أنت متأكد من حذف هذا المنتج؟')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                        class="w-9 h-9 flex items-center justify-center bg-rose-50 text-rose-600 rounded-lg hover:bg-rose-100 border border-rose-100/50 transition-all">
                                    <i class="fa-solid fa-trash-can text-xs"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- ═══ DESKTOP Table (lg+) ═══ --}}
        <div class="hidden lg:block bg-white border border-slate-100 rounded-2xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-right border-collapse">
                    <thead>
                        <tr class="bg-slate-50 text-slate-400 text-[10px] font-bold uppercase tracking-wider border-b border-slate-100">
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
                        @foreach($products as $product)
                            <tr class="hover:bg-slate-50/50 transition-all">
                                <td class="px-6 py-4">
                                    <div class="w-14 h-14 rounded-xl bg-slate-50 border border-slate-100 overflow-hidden flex items-center justify-center">
                                        @if($product->image)
                                            @if($product->isVideo())
                                                <video src="{{ $product->image }}" class="w-full h-full object-cover" autoplay loop muted playsinline></video>
                                            @else
                                                <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-full h-full object-cover" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                                <span class="hidden w-full h-full items-center justify-center bg-slate-50">
                                                    <i class="fa-solid fa-briefcase-medical text-slate-300 text-base"></i>
                                                </span>
                                            @endif
                                        @else
                                            <i class="fa-solid fa-briefcase-medical text-slate-300 text-base"></i>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-bold text-slate-900 leading-snug">
                                        <a href="{{ route('product.show', $product->slug) }}" target="_blank" class="hover:text-emerald-600 transition-all">{{ $product->name }}</a>
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
                                        <span class="inline-flex items-center gap-1.5 bg-emerald-50 text-emerald-800 text-[10px] font-bold px-2.5 py-1 rounded-full border border-emerald-100">
                                            <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span> متوفر
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 bg-rose-50 text-rose-800 text-[10px] font-bold px-2.5 py-1 rounded-full border border-rose-100">
                                            <span class="w-1.5 h-1.5 bg-rose-500 rounded-full"></span> غير متوفر
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-1.5">
                                        <i class="fa-solid fa-star text-amber-400 text-xs"></i>
                                        <span class="font-bold text-slate-900">{{ $product->averageRating() }}</span>
                                        <span class="text-slate-400 text-[10px] font-semibold">({{ $product->approvedReviews->count() }})</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('admin.products.edit', $product->id) }}"
                                           class="w-9 h-9 flex items-center justify-center bg-sky-50 text-sky-600 rounded-lg hover:bg-sky-100 border border-sky-100/50 transition-all" title="تعديل">
                                            <i class="fa-solid fa-pen text-xs"></i>
                                        </a>
                                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST"
                                              class="inline" onsubmit="return confirm('هل أنت متأكد من حذف هذا المنتج؟')">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                    class="w-9 h-9 flex items-center justify-center bg-rose-50 text-rose-600 rounded-lg hover:bg-rose-100 border border-rose-100/50 transition-all" title="حذف">
                                                <i class="fa-solid fa-trash-can text-xs"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if($products->hasPages())
                <div class="p-6 border-t border-slate-50">
                    {{ $products->appends(request()->query())->links() }}
                </div>
            @endif
        </div>

        {{-- Pagination mobile --}}
        @if($products->hasPages())
            <div class="mt-4 lg:hidden">
                {{ $products->appends(request()->query())->links() }}
            </div>
        @endif

    @endif
@endsection
