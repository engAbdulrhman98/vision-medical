@extends('layouts.app')

@section('title', $product->name . ' | ' . __('messages.vision_medical'))

@section('content')
    <!-- Breadcrumbs -->
    <nav class="flex mb-8 text-sm" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('home') }}" class="inline-flex items-center text-slate-500 hover:text-emerald-600 font-semibold transition-all-300">
                    <i class="fa-solid fa-house {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }} text-xs"></i>
                    {{ __('messages.home') }}
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <i class="fa-solid {{ app()->getLocale() == 'ar' ? 'fa-chevron-left' : 'fa-chevron-right' }} text-slate-300 text-xxs mx-2"></i>
                    <a href="{{ route('home', ['category' => $product->category->slug]) }}" class="text-slate-500 hover:text-emerald-600 font-semibold transition-all-300">
                        {{ $product->category->name }}
                    </a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <i class="fa-solid {{ app()->getLocale() == 'ar' ? 'fa-chevron-left' : 'fa-chevron-right' }} text-slate-300 text-xxs mx-2"></i>
                    <span class="text-slate-900 font-black line-clamp-1">{{ $product->name }}</span>
                </div>
            </li>
        </ol>
    </nav>

    <!-- Product Showcase Grid -->
    <div class="bg-white border border-slate-200/80 rounded-[2rem] overflow-hidden shadow-sm mb-12">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 p-6 sm:p-10">
            
            <!-- Right: Product Image -->
            <div class="relative bg-slate-50/50 rounded-2xl overflow-hidden aspect-square flex items-center justify-center border border-slate-200/50 group">
                @if($product->image)
                    @if($product->isVideo())
                        <video src="{{ $product->image }}" class="w-full h-full object-cover" autoplay loop muted playsinline controls></video>
                    @else
                        <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-102 transition-transform duration-500">
                    @endif
                @else
                    <div class="flex flex-col items-center justify-center text-slate-300">
                        <i class="fa-solid fa-briefcase-medical text-8xl"></i>
                        <span class="mt-4 text-xs font-semibold text-slate-400">Image not available</span>
                    </div>
                @endif
                
                @if(!$product->in_stock)
                    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-xs flex items-center justify-center">
                        <span class="bg-rose-600 text-white font-black text-sm px-6 py-3 rounded-xl shadow-lg">{{ __('messages.out_of_stock') }}</span>
                    </div>
                @endif
            </div>

            <!-- Left: Product Details -->
            <div class="flex flex-col justify-between space-y-6">
                <div class="space-y-4">
                    <!-- Badges -->
                    <div class="flex flex-wrap items-center gap-3">
                        <span class="bg-emerald-50 text-emerald-700 text-xs font-bold px-3 py-1.5 rounded-lg border border-emerald-100/50">
                            {{ $product->category->name }}
                        </span>
                        <span class="bg-slate-50 text-slate-700 text-xs font-bold px-3 py-1.5 rounded-lg border border-slate-200/60">
                            {{ __('messages.filter_brand') }}: {{ $product->brand->name }}
                        </span>
                    </div>

                    <!-- Title -->
                    <h1 class="text-2xl sm:text-3xl font-black text-slate-900 leading-tight">
                        {{ $product->name }}
                    </h1>

                    <!-- Rating Stars -->
                    <div class="flex items-center gap-2">
                        <div class="flex items-center gap-0.5 text-amber-400">
                            @php $avgRating = $product->averageRating(); @endphp
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fa-{{ $i <= $avgRating ? 'solid' : 'regular' }} fa-star text-sm"></i>
                            @endfor
                        </div>
                        <span class="text-sm font-black text-slate-950">{{ $avgRating }} / 5</span>
                        <span class="text-xs text-slate-400 font-semibold">({{ $product->approvedReviews->count() }} {{ __('messages.reviews_title') }})</span>
                    </div>

                    <!-- Price -->
                    <div class="text-emerald-600 font-extrabold text-3xl pt-2">
                        {{ number_format($product->price, 2) }} <span class="text-base font-semibold text-slate-500">{{ __('messages.currency') }}</span>
                    </div>

                    <hr class="border-slate-100 my-4">

                    <!-- Short Description -->
                    <div class="space-y-1.5">
                        <h3 class="font-bold text-slate-900 text-sm">{{ __('messages.product_overview') }}</h3>
                        <p class="text-slate-600 text-sm leading-relaxed">
                            {{ $product->description }}
                        </p>
                    </div>
                </div>

                <!-- Call to Actions (WhatsApp & Contact) -->
                <div class="space-y-3 pt-6">
                    @if($product->in_stock)
                        <!-- Primary Order WhatsApp -->
                        @php
                            $whatsNumber = \App\Models\Setting::getValue('whatsapp', '966501234567');
                            $whatsText = __('messages.whats_prefilled_text', [
                                'name' => $product->name,
                                'price' => number_format($product->price, 2),
                                'url' => request()->url()
                            ]);
                        @endphp
                        <a href="https://wa.me/{{ $whatsNumber }}?text={{ urlencode($whatsText) }}" 
                           target="_blank"
                           class="w-full flex items-center justify-center gap-3 bg-emerald-500 hover:bg-emerald-600 text-slate-950 font-black py-4 rounded-xl shadow-lg shadow-emerald-500/10 hover:shadow-emerald-500/20 hover:scale-101 transition-all duration-300 text-base animate-pulse-glow">
                            <i class="fa-brands fa-whatsapp text-2xl"></i>
                            <span>{{ __('messages.whatsapp_order') }}</span>
                        </a>
                    @endif

                    <!-- Secondary Contact Page Link -->
                    <a href="{{ route('contact') }}" 
                       class="w-full flex items-center justify-center gap-2 bg-slate-50 hover:bg-emerald-50 hover:text-emerald-700 hover:border-emerald-200 border border-slate-200/60 text-slate-700 font-bold py-3.5 rounded-xl transition-all-300 text-sm">
                        <i class="fa-solid fa-circle-info text-slate-400"></i>
                        <span>{{ __('messages.request_info') }}</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Product Specifications & Details -->
    @if($product->details)
        <div class="bg-white border border-slate-200/80 rounded-[2rem] p-6 sm:p-10 shadow-sm mb-12">
            <h2 class="text-xl font-bold text-slate-900 border-b border-slate-100 pb-4 mb-6 flex items-center gap-2">
                <i class="fa-solid fa-file-medical text-emerald-600 text-lg"></i>
                <span>{{ __('messages.specifications') }}</span>
            </h2>
            <div class="text-slate-700 text-sm leading-relaxed whitespace-pre-line space-y-2">
                {{ $product->details }}
            </div>
        </div>
    @endif

    <!-- Reviews Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left: Submit Review Form (1 Column) -->
        <div class="bg-white border border-slate-200/80 rounded-[2rem] p-6 sm:p-8 shadow-sm h-fit">
            <h3 class="font-bold text-slate-900 text-lg mb-6 flex items-center gap-2">
                <i class="fa-solid fa-pen-to-square text-emerald-500 text-base"></i>
                <span>{{ __('messages.add_review') }}</span>
            </h3>
            
            <form action="{{ route('review.submit', $product->id) }}" method="POST" class="space-y-4">
                @csrf
                
                <!-- Name -->
                <div>
                    <label for="reviewer_name" class="block text-xs font-bold text-slate-600 mb-1.5">{{ __('messages.reviewer_name') }}</label>
                    <input type="text" name="reviewer_name" id="reviewer_name" required 
                           placeholder="{{ __('messages.reviewer_name_placeholder') }}" 
                           class="w-full bg-slate-50 border border-slate-200 focus:border-emerald-500 focus:bg-white focus:ring-1 focus:ring-emerald-500/20 rounded-xl px-4 py-3 text-slate-900 text-sm focus:outline-none transition-all-300">
                </div>

                <!-- Rating -->
                <div>
                    <label class="block text-xs font-bold text-slate-600 mb-1.5">{{ __('messages.rating_label') }}</label>
                    <div class="flex items-center gap-2 bg-slate-50 border border-slate-200 rounded-xl p-3">
                        <select name="rating" id="rating" required class="bg-transparent border-0 focus:ring-0 text-amber-500 font-bold text-sm w-full focus:outline-none cursor-pointer">
                            <option value="5" class="text-amber-500 font-bold">⭐⭐⭐⭐⭐ 5/5</option>
                            <option value="4" class="text-amber-500 font-bold">⭐⭐⭐⭐ 4/5</option>
                            <option value="3" class="text-amber-500 font-bold">⭐⭐⭐ 3/5</option>
                            <option value="2" class="text-amber-500 font-bold">⭐⭐ 2/5</option>
                            <option value="1" class="text-amber-500 font-bold">⭐ 1/5</option>
                        </select>
                    </div>
                </div>

                <!-- Comment -->
                <div>
                    <label for="comment" class="block text-xs font-bold text-slate-600 mb-1.5">{{ __('messages.comment_label') }}</label>
                    <textarea name="comment" id="comment" rows="4" required 
                              placeholder="{{ __('messages.comment_placeholder') }}" 
                              class="w-full bg-slate-50 border border-slate-200 focus:border-emerald-500 focus:bg-white focus:ring-1 focus:ring-emerald-500/20 rounded-xl px-4 py-3 text-slate-900 text-sm focus:outline-none transition-all-300"></textarea>
                </div>

                <div class="bg-amber-50/50 border border-amber-100 text-amber-800 text-[10px] font-bold p-3 rounded-xl flex items-start gap-2 leading-relaxed">
                    <i class="fa-solid fa-triangle-exclamation text-amber-600 mt-0.5 shrink-0"></i>
                    <span>{{ __('messages.review_moderation_note') }}</span>
                </div>

                <button type="submit" class="w-full bg-slate-950 hover:bg-emerald-500 hover:text-slate-950 font-black py-4 rounded-xl shadow-md transition-all-300 text-sm">
                    {{ __('messages.submit_review') }}
                </button>
            </form>
        </div>

        <!-- Right: Approved Reviews List (2 Columns) -->
        <div class="lg:col-span-2 bg-white border border-slate-200/80 rounded-[2rem] p-6 sm:p-10 shadow-sm">
            <h3 class="font-bold text-slate-900 text-lg border-b border-slate-100 pb-4 mb-6 flex items-center gap-2">
                <i class="fa-solid fa-comments text-emerald-500 text-base"></i>
                <span>{{ __('messages.reviews_title') }}</span>
            </h3>

            @if($product->approvedReviews->isEmpty())
                <div class="text-center py-12">
                    <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-300">
                        <i class="fa-regular fa-comments text-3xl"></i>
                    </div>
                    <p class="text-slate-500 text-sm font-semibold">{{ __('messages.no_reviews') }}</p>
                </div>
            @else
                <div class="space-y-6">
                    @foreach($product->approvedReviews as $review)
                        <div class="bg-slate-50/50 border border-slate-100 rounded-2xl p-5 space-y-3">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-emerald-100/50 text-emerald-700 font-extrabold rounded-full flex items-center justify-center text-sm">
                                        {{ mb_substr($review->reviewer_name, 0, 1, 'utf-8') }}
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-slate-900 text-sm">{{ $review->reviewer_name }}</h4>
                                        <span class="text-slate-400 text-[10px] font-bold block">{{ $review->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>

                                <div class="flex items-center gap-0.5 text-amber-400">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fa-{{ $i <= $review->rating ? 'solid' : 'regular' }} fa-star text-xs"></i>
                                    @endfor
                                </div>
                            </div>
                            <p class="text-slate-700 text-sm leading-relaxed pl-1">
                                {{ $review->comment }}
                            </p>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <!-- Related Products -->
    @if(!$relatedProducts->isEmpty())
        <div class="mt-20 space-y-8">
            <h3 class="font-bold text-slate-900 text-xl flex items-center gap-2">
                <i class="fa-solid fa-cubes text-emerald-500 text-base"></i>
                <span>{{ __('messages.related_products') }}</span>
            </h3>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($relatedProducts as $rel)
                    <div class="group bg-white border border-slate-200/80 rounded-3xl overflow-hidden shadow-xs hover:shadow-xl transition-all-300 flex flex-col justify-between">
                        <div class="bg-slate-50/50 aspect-video overflow-hidden relative">
                            @if($rel->image)
                                @if($rel->isVideo())
                                    <video src="{{ $rel->image }}" class="w-full h-full object-cover" autoplay loop muted playsinline></video>
                                @else
                                    <img src="{{ $rel->image }}" alt="{{ $rel->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-all-300">
                                @endif
                            @else
                                <div class="w-full h-full flex items-center justify-center text-slate-300">
                                    <i class="fa-solid fa-briefcase-medical text-3xl"></i>
                                </div>
                            @endif
                        </div>
                        <div class="p-5 flex-grow flex flex-col justify-between space-y-4">
                            <h4 class="font-bold text-slate-900 text-sm line-clamp-2 leading-snug group-hover:text-emerald-600 transition-all-300">
                                <a href="{{ route('product.show', $rel->slug) }}">{{ $rel->name }}</a>
                            </h4>
                            <div class="flex items-center justify-between pt-3 border-t border-slate-100">
                                <span class="text-emerald-600 font-extrabold text-sm">{{ number_format($rel->price, 2) }} {{ __('messages.currency') }}</span>
                                <a href="{{ route('product.show', $rel->slug) }}" class="text-slate-400 hover:text-emerald-600 text-xs font-bold transition-all-300 flex items-center gap-1">
                                    <span>{{ __('messages.details_label') }}</span>
                                    <i class="fa-solid {{ app()->getLocale() == 'ar' ? 'fa-arrow-left' : 'fa-arrow-right' }} text-[10px]"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
@endsection
