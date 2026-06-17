@extends('layouts.app')

@section('title', __('messages.store') . ' - ' . __('messages.store_name'))

@section('content')
    <!-- Store Banner Section -->
    <div class="relative bg-slate-950 rounded-[2rem] overflow-hidden mb-12 shadow-2xl border border-slate-900">
        <!-- Background Decorative Elements -->
        <div class="absolute inset-0 opacity-10 bg-[radial-gradient(ellipse_at_center,_var(--tw-gradient-stops))] from-emerald-500 via-transparent to-transparent"></div>
        <div class="absolute -top-12 -left-12 w-64 h-64 bg-emerald-500/10 rounded-full blur-3xl"></div>
        
        <div class="relative max-w-4xl mx-auto px-6 py-16 sm:px-12 sm:py-20 text-center space-y-6">
            <h1 class="text-3xl sm:text-5xl font-black text-white tracking-tight leading-tight">
                {{ __('messages.store_preview_title') }}
            </h1>
            <p class="text-base sm:text-lg text-slate-300 max-w-xl mx-auto leading-relaxed">
                {{ __('messages.store_preview_subtitle') }}
            </p>
            
            <!-- Search Bar inside Hero -->
            <form action="{{ route('store') }}" method="GET" class="max-w-2xl mx-auto bg-white/95 backdrop-blur-md p-2 rounded-2xl shadow-xl border border-slate-200/50 flex flex-col sm:flex-row gap-2">
                @if(request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif
                @if(request('brand'))
                    <input type="hidden" name="brand" value="{{ request('brand') }}">
                @endif
                
                <div class="relative flex-grow">
                    <i class="fa-solid fa-magnifying-glass absolute {{ app()->getLocale() == 'ar' ? 'right-4' : 'left-4' }} top-1/2 -translate-y-1/2 text-slate-400 text-base"></i>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="{{ __('messages.search_placeholder') }}" 
                           class="w-full {{ app()->getLocale() == 'ar' ? 'pl-4 pr-11' : 'pl-11 pr-4' }} py-3 bg-transparent text-slate-900 placeholder-slate-400 focus:outline-none text-sm font-semibold">
                </div>
                <button type="submit" class="bg-emerald-500 hover:bg-emerald-600 text-slate-950 font-black text-sm px-8 py-3.5 rounded-xl transition-all-300 shadow-md shadow-emerald-500/10">
                    {{ __('messages.search_btn') }}
                </button>
            </form>
        </div>
    </div>

    <!-- Mobile Filter Toggle Button -->
    <div class="flex lg:hidden mb-4">
        <button onclick="document.getElementById('filter-sidebar').classList.toggle('hidden')"
                class="flex items-center gap-2 bg-white border border-slate-200 text-slate-700 text-sm font-bold px-5 py-2.5 rounded-xl shadow-sm hover:bg-emerald-50 hover:border-emerald-200 hover:text-emerald-700 transition-all">
            <i class="fa-solid fa-sliders"></i>
            <span>{{ app()->getLocale() == 'ar' ? 'الفلاتر' : 'Filters' }}</span>
        </button>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        
        <!-- Filters Sidebar -->
        <div id="filter-sidebar" class="hidden lg:block space-y-8">
            
            <!-- Active Filters Panel -->
            @if(request('category') || request('brand') || request('search'))
                <div class="bg-emerald-50/50 border border-emerald-100 rounded-2xl p-5 shadow-xs">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="font-bold text-emerald-800 text-xs uppercase tracking-wider">{{ __('messages.active_filters') }}</h3>
                        <a href="{{ route('store') }}" class="text-xs font-bold text-rose-600 hover:underline">{{ __('messages.clear_all') }}</a>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        @if(request('search'))
                            <span class="inline-flex items-center gap-1.5 bg-white border border-emerald-100 text-emerald-800 text-xs px-3 py-1.5 rounded-xl font-bold shadow-xxs">
                                {{ __('messages.filter_search') }}: {{ request('search') }}
                            </span>
                        @endif
                        @if(request('category'))
                            <span class="inline-flex items-center gap-1.5 bg-white border border-emerald-100 text-emerald-800 text-xs px-3 py-1.5 rounded-xl font-bold shadow-xxs">
                                {{ __('messages.filter_category') }}: {{ $categories->firstWhere('slug', request('category'))->name ?? request('category') }}
                            </span>
                        @endif
                        @if(request('brand'))
                            <span class="inline-flex items-center gap-1.5 bg-white border border-emerald-100 text-emerald-800 text-xs px-3 py-1.5 rounded-xl font-bold shadow-xxs">
                                {{ __('messages.filter_brand') }}: {{ $brands->firstWhere('slug', request('brand'))->name ?? request('brand') }}
                            </span>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Categories Card -->
            <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-sm">
                <h3 class="font-bold text-slate-900 text-lg border-b border-slate-100 pb-4 mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-list-ul text-emerald-500 text-base"></i>
                    <span>{{ __('messages.categories_title') }}</span>
                </h3>
                <div class="space-y-1">
                    <a href="{{ route('store', request()->except('category')) }}" 
                       class="flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-semibold transition-all-300 {{ !request('category') ? 'bg-emerald-50 text-emerald-700 font-bold' : 'text-slate-600 hover:bg-slate-50' }}">
                        <span>{{ __('messages.all_categories') }}</span>
                        <span class="bg-slate-100 text-slate-600 text-xs px-2.5 py-1 rounded-full font-bold">{{ \App\Models\Product::count() }}</span>
                    </a>
                    @foreach($categories as $category)
                        <a href="{{ route('store', array_merge(request()->query(), ['category' => $category->slug])) }}" 
                           class="flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-semibold transition-all-300 {{ request('category') === $category->slug ? 'bg-emerald-50 text-emerald-700 font-bold' : 'text-slate-600 hover:bg-slate-50' }}">
                            <span>{{ $category->name }}</span>
                            <span class="bg-slate-100 text-slate-600 text-xs px-2.5 py-1 rounded-full font-bold">{{ $category->products_count }}</span>
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Brands Card -->
            <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-sm">
                <h3 class="font-bold text-slate-900 text-lg border-b border-slate-100 pb-4 mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-copyright text-emerald-500 text-base"></i>
                    <span>{{ __('messages.brands_title') }}</span>
                </h3>
                <div class="space-y-1">
                    <a href="{{ route('store', request()->except('brand')) }}" 
                       class="flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-semibold transition-all-300 {{ !request('brand') ? 'bg-emerald-50 text-emerald-700 font-bold' : 'text-slate-600 hover:bg-slate-50' }}">
                        <span>{{ __('messages.all_brands') }}</span>
                    </a>
                    @foreach($brands as $brand)
                        <a href="{{ route('store', array_merge(request()->query(), ['brand' => $brand->slug])) }}" 
                           class="flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-semibold transition-all-300 {{ request('brand') === $brand->slug ? 'bg-emerald-50 text-emerald-700 font-bold' : 'text-slate-600 hover:bg-slate-50' }}">
                            <span>{{ $brand->name }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
            
        </div>

        <!-- Products List Area -->
        <div class="lg:col-span-3 space-y-6">
            
            <!-- Products Header -->
            <div class="flex items-center justify-between bg-white border border-slate-200/80 p-5 rounded-2xl shadow-sm">
                <div class="text-sm font-bold text-slate-500">
                    {{ __('messages.found_products', ['count' => $products->total()]) }}
                </div>
                <div class="text-xs text-slate-400 font-semibold uppercase tracking-wider">
                    {{ __('messages.sorted_by_latest') }}
                </div>
            </div>

            <!-- Products Grid -->
            @if($products->isEmpty())
                <div class="bg-white border border-slate-200/80 rounded-3xl p-16 text-center shadow-sm">
                    <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-300">
                        <i class="fa-solid fa-box-open text-4xl animate-bounce"></i>
                    </div>
                    <h3 class="font-bold text-slate-900 text-lg mb-2">{{ __('messages.no_products_found') }}</h3>
                    <p class="text-slate-500 text-sm max-w-sm mx-auto mb-6">{{ __('messages.no_products_desc') }}</p>
                    <a href="{{ route('store') }}" class="inline-flex items-center gap-2 bg-emerald-500 hover:bg-emerald-600 text-slate-950 font-black text-sm px-6 py-3 rounded-xl transition-all-300 shadow-md">
                        {{ __('messages.show_all_products') }}
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($products as $product)
                        <div class="group bg-white border border-slate-200/80 rounded-3xl overflow-hidden shadow-xs hover:shadow-xl hover:border-emerald-200/80 transition-all-300 flex flex-col justify-between">
                            
                            <!-- Product Image Container -->
                            <div class="relative bg-slate-50/50 aspect-video overflow-hidden">
                                @if($product->image)
                                    <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-all-300">
                                @else
                                    <div class="w-full h-full flex flex-col items-center justify-center text-slate-300">
                                        <i class="fa-solid fa-briefcase-medical text-4xl"></i>
                                    </div>
                                @endif
                                
                                <span class="absolute top-3 {{ app()->getLocale() == 'ar' ? 'right-3' : 'left-3' }} bg-white/95 backdrop-blur-xs border border-slate-100 text-slate-700 text-xxs font-bold px-2.5 py-1.5 rounded-lg shadow-xxs">
                                    {{ $product->brand->name }}
                                </span>
                            </div>

                            <!-- Product Content -->
                            <div class="p-5 flex-grow flex flex-col justify-between">
                                <div class="space-y-2">
                                    <span class="text-xs font-bold text-emerald-600 block">
                                        {{ $product->category->name }}
                                    </span>
                                    
                                    <h3 class="font-bold text-slate-900 text-base leading-snug group-hover:text-emerald-600 transition-all-300">
                                        <a href="{{ route('product.show', $product->slug) }}">{{ $product->name }}</a>
                                    </h3>
                                    
                                    <p class="text-slate-500 text-xs line-clamp-2 leading-relaxed">
                                        {{ $product->description }}
                                    </p>
                                </div>

                                <!-- Rating & Price Section -->
                                <div class="mt-4 pt-4 border-t border-slate-100 flex items-center justify-between">
                                    <div>
                                        <div class="text-emerald-600 font-extrabold text-lg">
                                            {{ number_format($product->price, 2) }} <span class="text-xs font-semibold text-slate-500">{{ __('messages.currency') }}</span>
                                        </div>
                                    </div>

                                    <!-- Average Stars Rating -->
                                    <div class="flex items-center gap-1.5">
                                        <div class="flex items-center gap-0.5 text-amber-400">
                                            @php $avgRating = $product->averageRating(); @endphp
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fa-{{ $i <= $avgRating ? 'solid' : 'regular' }} fa-star text-xs"></i>
                                            @endfor
                                        </div>
                                        <span class="text-slate-400 text-xxs font-bold">({{ $product->approvedReviews->count() }})</span>
                                    </div>
                                </div>

                                <!-- Action button -->
                                <div class="mt-4">
                                    <a href="{{ route('product.show', $product->slug) }}" class="w-full flex items-center justify-center gap-2 bg-slate-50 hover:bg-emerald-500 hover:text-slate-950 border border-slate-200/60 hover:border-emerald-500 text-slate-700 font-bold text-xs py-3 rounded-xl transition-all-300">
                                        <span>{{ __('messages.view_details') }}</span>
                                        <i class="fa-solid {{ app()->getLocale() == 'ar' ? 'fa-arrow-left' : 'fa-arrow-right' }} text-xxs"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination Links -->
                <div class="mt-12 flex justify-center">
                    {{ $products->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
