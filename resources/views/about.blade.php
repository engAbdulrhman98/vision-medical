@extends('layouts.app')

@section('title', __('messages.about_us') . ' - ' . __('messages.store_name'))

@section('content')
    <div class="max-w-4xl mx-auto space-y-12 py-6">
        
        <!-- Header banner -->
        <div class="text-center space-y-4 animate-fade-in-up">
            <span class="bg-emerald-50 text-emerald-700 text-xs font-bold px-4 py-2 rounded-full border border-emerald-100/50 uppercase tracking-wider">{{ __('messages.about_title') }}</span>
            <h1 class="text-3xl sm:text-4xl font-black text-slate-900 leading-tight">
                {{ $title }}
            </h1>
            <p class="text-slate-500 text-sm max-w-lg mx-auto leading-relaxed font-medium">
                {{ __('messages.about_subtitle') }}
            </p>
        </div>

        <!-- Content details (Story Block) -->
        <div class="bg-white border border-slate-200/80 rounded-[2rem] p-8 sm:p-12 shadow-sm animate-fade-in-up space-y-6">
            <h2 class="text-xl font-black text-slate-900 flex items-center gap-2">
                <i class="fa-solid fa-quote-right text-emerald-500 text-lg"></i>
                <span>{{ __('messages.about_content_title') }}</span>
            </h2>
            <div class="text-slate-600 text-sm leading-relaxed whitespace-pre-line font-medium">
                {{ $content }}
            </div>
        </div>

        <!-- Deco Card (رعايتكم أولويتنا) -->
        <div class="bg-gradient-to-br from-emerald-600 to-teal-800 rounded-[2rem] p-8 sm:p-10 text-white shadow-lg shadow-emerald-600/10 border border-emerald-500/20 relative overflow-hidden animate-fade-in-up">
            <!-- Decorative circle blur elements -->
            <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-white/5 rounded-full blur-2xl"></div>
            <div class="absolute -left-10 -top-10 w-40 h-40 bg-white/5 rounded-full blur-2xl"></div>
            
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-6 relative z-10">
                <div class="w-16 h-16 bg-white/10 rounded-2xl flex items-center justify-center text-3xl shrink-0">
                    <i class="fa-solid fa-star-of-life animate-spin-slow"></i>
                </div>
                <div class="space-y-2">
                    <h3 class="font-bold text-xl leading-snug">{{ __('messages.deco_title') }}</h3>
                    <p class="text-emerald-100 text-sm leading-relaxed font-semibold">
                        {{ __('messages.deco_desc') }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Quick highlights grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 text-center animate-fade-in-up">
            <!-- Card 1: Certified Devices -->
            <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-xs space-y-3 group hover:border-emerald-200/80 hover:-translate-y-1 transition-all-300">
                <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-full flex items-center justify-center mx-auto text-lg group-hover:bg-emerald-500 group-hover:text-white transition-all-300 shadow-xxs">
                    <i class="fa-solid fa-staff-aesculapius"></i>
                </div>
                <h3 class="font-bold text-slate-900 text-sm group-hover:text-emerald-600 transition-all-300">{{ __('messages.service_devices_title') }}</h3>
                <p class="text-slate-500 text-xs leading-relaxed font-medium">{{ __('messages.service_devices_desc') }}</p>
            </div>

            <!-- Card 2: Calibration & Maintenance -->
            <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-xs space-y-3 group hover:border-emerald-200/80 hover:-translate-y-1 transition-all-300">
                <div class="w-12 h-12 bg-sky-50 text-sky-600 rounded-full flex items-center justify-center mx-auto text-lg group-hover:bg-sky-500 group-hover:text-white transition-all-300 shadow-xxs">
                    <i class="fa-solid fa-screwdriver-wrench"></i>
                </div>
                <h3 class="font-bold text-slate-900 text-sm group-hover:text-sky-600 transition-all-300">{{ __('messages.service_maintenance_title') }}</h3>
                <p class="text-slate-500 text-xs leading-relaxed font-medium">{{ __('messages.service_maintenance_desc') }}</p>
            </div>

            <!-- Card 3: Shipping & Delivery -->
            <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-xs space-y-3 group hover:border-emerald-200/80 hover:-translate-y-1 transition-all-300">
                <div class="w-12 h-12 bg-violet-50 text-violet-600 rounded-full flex items-center justify-center mx-auto text-lg group-hover:bg-violet-500 group-hover:text-white transition-all-300 shadow-xxs">
                    <i class="fa-solid fa-truck-fast"></i>
                </div>
                <h3 class="font-bold text-slate-900 text-sm group-hover:text-violet-600 transition-all-300">{{ __('messages.service_shipping_title') }}</h3>
                <p class="text-slate-500 text-xs leading-relaxed font-medium">{{ __('messages.service_shipping_desc') }}</p>
            </div>

            <!-- Card 4: Support & Consultation -->
            <div class="bg-white border border-slate-200/80 rounded-3xl p-6 shadow-xs space-y-3 group hover:border-emerald-200/80 hover:-translate-y-1 transition-all-300">
                <div class="w-12 h-12 bg-amber-50 text-amber-600 rounded-full flex items-center justify-center mx-auto text-lg group-hover:bg-amber-500 group-hover:text-white transition-all-300 shadow-xxs">
                    <i class="fa-solid fa-headset"></i>
                </div>
                <h3 class="font-bold text-slate-900 text-sm group-hover:text-amber-600 transition-all-300">{{ __('messages.service_support_title') }}</h3>
                <p class="text-slate-500 text-xs leading-relaxed font-medium">{{ __('messages.service_support_desc') }}</p>
            </div>
        </div>

    </div>
@endsection
