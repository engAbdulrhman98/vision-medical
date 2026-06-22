<!DOCTYPE html>
<html lang="{{ \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale() }}" dir="{{ \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocaleDirection() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', __('messages.store_name'))</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}?v=3">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}?v=3">
    
    <!-- Google Fonts: Tajawal & Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;900&family=Tajawal:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    
    <!-- FontAwesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Tailwind CSS (Vite) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body {
            font-family: 'Tajawal', 'Outfit', sans-serif;
            background-color: #f8fafc;
        }
        .transition-all-300 {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
    </style>
    @yield('styles')
</head>
<body class="flex flex-col min-h-screen text-slate-800 antialiased bg-slate-50/50">

    <!-- Header / Navbar -->
    <header class="sticky top-0 z-50 bg-white/80 backdrop-blur-md border-b border-slate-200/80 shadow-sm transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                
                <!-- Logo & Brand Name -->
                <div class="flex items-center min-w-0">
                    @if(app()->getLocale() == 'ar')
                        <a href="{{ route('home') }}" class="flex items-center gap-2 sm:gap-3 group" style="direction: rtl;">
                            <img src="{{ asset('images/logo.png') }}?v=3" alt="Vision Medical" class="h-10 w-10 sm:h-14 sm:w-14 object-contain group-hover:scale-110 transition-transform duration-300 ease-out flex-shrink-0">
                            <div class="flex flex-col justify-center min-w-0" style="font-family: 'Tajawal', sans-serif; direction: rtl; text-align: right;">
                                <div class="flex flex-row items-baseline leading-none whitespace-nowrap" style="font-size: clamp(18px, 4vw, 28px); font-weight: 900;">
                                    <span style="color: #6D6E71;">فيجن</span>
                                    <span style="color: #00A99D; margin-right: 5px;">ميدكال</span>
                                </div>
                                <span class="hidden sm:block" style="font-family: 'Tajawal', sans-serif; font-size: 12px; font-weight: 500; color: #6D6E71; margin-top: 3px; letter-spacing: 0.02em; white-space: nowrap;">
                                    {{ __('messages.color_maintenance_title') }}
                                </span>
                            </div>
                        </a>
                    @else
                        <a href="{{ route('home') }}" class="flex items-center gap-2 sm:gap-3 group" style="direction: ltr; text-align: left;">
                            <img src="{{ asset('images/logo.png') }}?v=3" alt="Vision Medical" class="h-10 w-10 sm:h-14 sm:w-14 object-contain group-hover:scale-110 transition-transform duration-300 ease-out flex-shrink-0">
                            <div class="flex flex-col justify-center min-w-0" style="font-family: 'Outfit', sans-serif; direction: ltr; text-align: left;">
                                <div class="flex flex-row items-baseline leading-none whitespace-nowrap" style="font-size: clamp(16px, 4vw, 28px); font-weight: 900; letter-spacing: -0.02em;">
                                    <span style="color: #6D6E71;">VISION</span>
                                    <span style="color: #00A99D; margin-left: 6px;">MEDICAL</span>
                                </div>
                                <span class="hidden sm:block" style="font-family: 'Outfit', sans-serif; font-size: 12px; font-weight: 500; color: #6D6E71; margin-top: 3px; letter-spacing: 0.08em; white-space: nowrap; text-transform: uppercase;">
                                    {{ __('messages.color_maintenance_title') }}
                                </span>
                            </div>
                        </a>
                    @endif
                </div>


                <!-- Navigation Links -->
                <nav class="hidden md:flex items-center gap-8">
                    @php
                        $isHomeActive = Request::is('/') || Request::is('ar') || Request::is('en') || Request::is('ar/home') || Request::is('en/home');
                    @endphp
                    <a href="{{ route('home') }}" class="relative text-sm font-semibold transition-all duration-300 py-2 hover:text-emerald-500 {{ $isHomeActive ? 'text-emerald-600' : 'text-slate-600' }}">
                        <span>{{ __('messages.home') }}</span>
                        <span class="absolute bottom-0 left-0 w-full h-0.5 bg-emerald-500 scale-x-0 transition-transform duration-300 origin-center {{ $isHomeActive ? 'scale-x-100' : 'hover:scale-x-100' }}"></span>
                    </a>

                    <!-- Categories Section Anchor Link -->
                    <a href="{{ route('home') }}#categories" class="relative text-sm font-semibold transition-all duration-300 py-2 hover:text-emerald-500 text-slate-600">
                        <span>{{ __('messages.categories_title') }}</span>
                    </a>

                    <!-- Brands Section Anchor Link -->
                    <a href="{{ route('home') }}#brands" class="relative text-sm font-semibold transition-all duration-300 py-2 hover:text-emerald-500 text-slate-600">
                        <span>{{ __('messages.brands_title') }}</span>
                    </a>

                    <a href="{{ route('store') }}" class="relative text-sm font-semibold transition-all duration-300 py-2 hover:text-emerald-500 {{ Request::is('*store') ? 'text-emerald-600' : 'text-slate-600' }}">
                        <span>{{ __('messages.store') }}</span>
                        <span class="absolute bottom-0 left-0 w-full h-0.5 bg-emerald-500 scale-x-0 transition-transform duration-300 origin-center {{ Request::is('*store') ? 'scale-x-100' : 'hover:scale-x-100' }}"></span>
                    </a>
                    <a href="{{ route('about') }}" class="relative text-sm font-semibold transition-all duration-300 py-2 hover:text-emerald-500 {{ Request::is('*about') ? 'text-emerald-600' : 'text-slate-600' }}">
                        <span>{{ __('messages.about_us') }}</span>
                        <span class="absolute bottom-0 left-0 w-full h-0.5 bg-emerald-500 scale-x-0 transition-transform duration-300 origin-center {{ Request::is('*about') ? 'scale-x-100' : 'hover:scale-x-100' }}"></span>
                    </a>
                    <a href="{{ route('contact') }}" class="relative text-sm font-semibold transition-all duration-300 py-2 hover:text-emerald-500 {{ Request::is('*contact') ? 'text-emerald-600' : 'text-slate-600' }}">
                        <span>{{ __('messages.contact_us') }}</span>
                        <span class="absolute bottom-0 left-0 w-full h-0.5 bg-emerald-500 scale-x-0 transition-transform duration-300 origin-center {{ Request::is('*contact') ? 'scale-x-100' : 'hover:scale-x-100' }}"></span>
                    </a>
                </nav>

                <!-- Admin Access / CTAs / Lang Switcher -->
                <div class="flex items-center gap-4">
                    
                    <!-- Language Switcher Button -->
                    <div class="border-s border-slate-200/80 ps-2 sm:ps-4 flex items-center gap-1 sm:gap-2">
                        @foreach(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                            @if($localeCode !== \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale())
                                <a href="{{ \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}" 
                                   class="flex items-center gap-1 text-xs font-bold text-slate-700 hover:text-emerald-600 transition-all-300 px-2.5 sm:px-4 py-2 bg-slate-50 hover:bg-emerald-50 rounded-full border border-slate-200/60 hover:border-emerald-200 shadow-xs">
                                    <i class="fa-solid fa-language text-emerald-600 text-sm"></i>
                                    <span>{{ $properties['native'] }}</span>
                                </a>
                            @endif
                        @endforeach
                    </div>

                    @auth
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 bg-emerald-50 text-emerald-700 px-4 h-11 rounded-full text-sm font-semibold border border-emerald-200/50 hover:bg-emerald-100 transition-all-300">
                            <i class="fa-solid fa-gauge-high"></i>
                            <span>{{ __('messages.admin_dashboard') }}</span>
                        </a>
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="w-11 h-11 flex items-center justify-center bg-rose-50 text-rose-600 rounded-full border border-rose-100 hover:bg-rose-100 hover:text-rose-700 transition-all-300" title="{{ __('messages.logout') }}">
                                <i class="fa-solid fa-arrow-right-from-bracket"></i>
                            </button>
                        </form>
                    @endauth
                    
                    <!-- Mobile Menu Button -->
                    <button id="mobile-menu-btn" class="md:hidden w-11 h-11 flex items-center justify-center bg-slate-50 text-slate-600 rounded-full border border-slate-200/50 hover:bg-slate-100 transition-all-300">
                        <i class="fa-solid fa-bars text-lg"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden border-t border-slate-100 bg-white px-4 py-4 space-y-2 shadow-lg absolute w-full left-0 animate-fade-in-up">
            <a href="{{ route('home') }}" class="block px-4 py-2.5 rounded-xl text-base font-semibold {{ $isHomeActive ? 'bg-emerald-50 text-emerald-700' : 'text-slate-600 hover:bg-slate-50' }}">{{ __('messages.home') }}</a>
            <a href="{{ route('store') }}" class="block px-4 py-2.5 rounded-xl text-base font-semibold {{ Request::is('*store') ? 'bg-emerald-50 text-emerald-700' : 'text-slate-600 hover:bg-slate-50' }}">{{ __('messages.store') }}</a>

            <!-- Mobile Categories & Brands Links -->
            <a href="{{ route('home') }}#categories" class="block px-4 py-2.5 rounded-xl text-base font-semibold text-slate-600 hover:bg-slate-50">{{ __('messages.categories_title') }}</a>
            <a href="{{ route('home') }}#brands" class="block px-4 py-2.5 rounded-xl text-base font-semibold text-slate-600 hover:bg-slate-50">{{ __('messages.brands_title') }}</a>

            <a href="{{ route('about') }}" class="block px-4 py-2.5 rounded-xl text-base font-semibold {{ Request::is('*about') ? 'bg-emerald-50 text-emerald-700' : 'text-slate-600 hover:bg-slate-50' }}">{{ __('messages.about_us') }}</a>
            <a href="{{ route('contact') }}" class="block px-4 py-2.5 rounded-xl text-base font-semibold {{ Request::is('*contact') ? 'bg-emerald-50 text-emerald-700' : 'text-slate-600 hover:bg-slate-50' }}">{{ __('messages.contact_us') }}</a>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow py-12 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
        <!-- Flash Messages -->
        @if(session('success'))
            <div class="mb-8 bg-emerald-50 border border-emerald-200/60 text-emerald-800 px-5 py-4 rounded-2xl shadow-xs flex items-center gap-3 animate-fade-in-up">
                <div class="w-8 h-8 rounded-full bg-emerald-500/15 flex items-center justify-center text-emerald-600">
                    <i class="fa-solid fa-circle-check text-lg animate-pulse"></i>
                </div>
                <div class="text-sm font-bold">{{ session('success') }}</div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-8 bg-rose-50 border border-rose-200/60 text-rose-800 px-5 py-4 rounded-2xl shadow-xs flex items-center gap-3 animate-fade-in-up">
                <div class="w-8 h-8 rounded-full bg-rose-500/15 flex items-center justify-center text-rose-600">
                    <i class="fa-solid fa-circle-exclamation text-lg animate-bounce"></i>
                </div>
                <div class="text-sm font-bold">{{ session('error') }}</div>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-slate-950 text-slate-400 border-t border-slate-900 relative overflow-hidden">
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_bottom,_var(--tw-gradient-stops))] from-emerald-950/20 via-transparent to-transparent pointer-events-none"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 relative">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12">
                
                <!-- Col 1: Store Intro -->
                <div class="space-y-6">
                    <div class="flex items-center">
                        @if(app()->getLocale() == 'ar')
                            <a href="{{ route('home') }}" class="flex items-center gap-2 sm:gap-3 group" style="direction: rtl;">
                                <img src="{{ asset('images/logo.png') }}?v=3" alt="Vision Medical" class="h-10 w-10 sm:h-14 sm:w-14 object-contain group-hover:scale-110 transition-transform duration-300 ease-out flex-shrink-0">
                                <div class="flex flex-col justify-center min-w-0" style="font-family: 'Tajawal', sans-serif; direction: rtl; text-align: right;">
                                    <div class="flex flex-row items-baseline leading-none whitespace-nowrap" style="font-size: clamp(18px, 4vw, 28px); font-weight: 900;">
                                        <span style="color: #6D6E71;">فيجن</span>
                                        <span style="color: #00A99D; margin-right: 5px;">ميدكال</span>
                                    </div>
                                    <span class="hidden sm:block" style="font-family: 'Tajawal', sans-serif; font-size: 12px; font-weight: 500; color: #94a3b8; margin-top: 3px; letter-spacing: 0.02em; white-space: nowrap;">
                                        {{ __('messages.color_maintenance_title') }}
                                    </span>
                                </div>
                            </a>
                        @else
                            <a href="{{ route('home') }}" class="flex items-center gap-2 sm:gap-3 group" style="direction: ltr; text-align: left;">
                                <img src="{{ asset('images/logo.png') }}?v=3" alt="Vision Medical" class="h-10 w-10 sm:h-14 sm:w-14 object-contain group-hover:scale-110 transition-transform duration-300 ease-out flex-shrink-0">
                                <div class="flex flex-col justify-center min-w-0" style="font-family: 'Outfit', sans-serif; direction: ltr; text-align: left;">
                                    <div class="flex flex-row items-baseline leading-none whitespace-nowrap" style="font-size: clamp(16px, 4vw, 28px); font-weight: 900; letter-spacing: -0.02em;">
                                        <span style="color: #6D6E71;">VISION</span>
                                        <span style="color: #00A99D; margin-left: 6px;">MEDICAL</span>
                                    </div>
                                    <span class="hidden sm:block" style="font-family: 'Outfit', sans-serif; font-size: 12px; font-weight: 500; color: #94a3b8; margin-top: 3px; letter-spacing: 0.08em; white-space: nowrap; text-transform: uppercase;">
                                        {{ __('messages.color_maintenance_title') }}
                                    </span>
                                </div>
                            </a>
                        @endif
                    </div>
                    <p class="text-sm text-slate-400 leading-relaxed">
                        {{ app()->getLocale() == 'ar' 
                            ? 'نحن ملتزمون بتوفير أفضل الأجهزة والمعدات الطبية المعتمدة والمستلزمات الطبية عالية الجودة لضمان أقصى حماية ورعاية صحية لعملائنا.'
                            : 'We are committed to providing the best certified medical devices and high quality medical supplies to ensure maximum protection and healthcare for our clients.'
                        }}
                    </p>
                    <div class="flex items-center gap-3 pt-2">
                        <a href="#" class="w-10 h-10 rounded-full bg-slate-900 hover:bg-emerald-600 hover:text-white flex items-center justify-center border border-slate-800 transition-all-300">
                            <i class="fa-brands fa-facebook-f"></i>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-slate-900 hover:bg-emerald-600 hover:text-white flex items-center justify-center border border-slate-800 transition-all-300">
                            <i class="fa-brands fa-twitter"></i>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-slate-900 hover:bg-emerald-600 hover:text-white flex items-center justify-center border border-slate-800 transition-all-300">
                            <i class="fa-brands fa-instagram"></i>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-slate-900 hover:bg-emerald-600 hover:text-white flex items-center justify-center border border-slate-800 transition-all-300">
                            <i class="fa-brands fa-linkedin-in"></i>
                        </a>
                    </div>
                </div>

                <!-- Col 2: Navigation Links -->
                <div class="space-y-6">
                    <h3 class="text-white font-bold text-lg tracking-wide relative after:content-[''] after:absolute after:bottom-0 after:start-0 after:w-8 after:h-0.5 after:bg-emerald-500 pb-2">
                        {{ app()->getLocale() == 'ar' ? 'روابط سريعة' : 'Quick Links' }}
                    </h3>
                    <ul class="space-y-3 text-sm">
                        <li>
                            <a href="{{ route('home') }}" class="hover:text-emerald-400 flex items-center gap-2 transition-all-300">
                                <i class="fa-solid fa-chevron-left text-xxs opacity-50 rtl:block ltr:hidden"></i>
                                <i class="fa-solid fa-chevron-right text-xxs opacity-50 ltr:block rtl:hidden"></i>
                                <span>{{ __('messages.home') }}</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('store') }}" class="hover:text-emerald-400 flex items-center gap-2 transition-all-300">
                                <i class="fa-solid fa-chevron-left text-xxs opacity-50 rtl:block ltr:hidden"></i>
                                <i class="fa-solid fa-chevron-right text-xxs opacity-50 ltr:block rtl:hidden"></i>
                                <span>{{ __('messages.store') }}</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('about') }}" class="hover:text-emerald-400 flex items-center gap-2 transition-all-300">
                                <i class="fa-solid fa-chevron-left text-xxs opacity-50 rtl:block ltr:hidden"></i>
                                <i class="fa-solid fa-chevron-right text-xxs opacity-50 ltr:block rtl:hidden"></i>
                                <span>{{ __('messages.about_us') }}</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('contact') }}" class="hover:text-emerald-400 flex items-center gap-2 transition-all-300">
                                <i class="fa-solid fa-chevron-left text-xxs opacity-50 rtl:block ltr:hidden"></i>
                                <i class="fa-solid fa-chevron-right text-xxs opacity-50 ltr:block rtl:hidden"></i>
                                <span>{{ __('messages.contact_us') }}</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Col 3: Categories Links -->
                <div class="space-y-6">
                    <h3 class="text-white font-bold text-lg tracking-wide relative after:content-[''] after:absolute after:bottom-0 after:start-0 after:w-8 after:h-0.5 after:bg-emerald-500 pb-2">
                        {{ __('messages.categories_title') }}
                    </h3>
                    @if(isset($globalCategories) && !$globalCategories->isEmpty())
                        <ul class="space-y-3 text-sm">
                            @foreach($globalCategories->take(5) as $cat)
                                <li>
                                    <a href="{{ route('store', ['category' => $cat->slug]) }}" class="hover:text-emerald-400 flex items-center gap-2 transition-all-300">
                                        <i class="fa-solid fa-chevron-left text-xxs opacity-50 rtl:block ltr:hidden"></i>
                                        <i class="fa-solid fa-chevron-right text-xxs opacity-50 ltr:block rtl:hidden"></i>
                                        <span>{{ $cat->name }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-xs text-slate-500">--</p>
                    @endif
                </div>

                <!-- Col 4: Contact Info & Working Hours -->
                <div class="space-y-6">
                    <h3 class="text-white font-bold text-lg tracking-wide relative after:content-[''] after:absolute after:bottom-0 after:start-0 after:w-8 after:h-0.5 after:bg-emerald-500 pb-2">{{ __('messages.contact_us') }}</h3>
                    <ul class="space-y-4 text-sm text-slate-400">
                        <li class="flex items-start gap-3.5">
                            <div class="w-8 h-8 rounded-lg bg-emerald-500/10 text-emerald-500 flex items-center justify-center shrink-0 border border-emerald-500/10">
                                <i class="fa-solid fa-phone"></i>
                            </div>
                            <div class="space-y-0.5">
                                <span class="text-xxs text-slate-500 block font-bold uppercase">{{ __('messages.call_channel') }}</span>
                                <a href="tel:{{ \App\Models\Setting::getValue('store_phone', '+20 100 123 4567') }}" class="hover:text-emerald-400 transition-all-300 block font-semibold text-white" dir="ltr">{{ \App\Models\Setting::getValue('store_phone', '+20 100 123 4567') }}</a>
                            </div>
                        </li>
                        <li class="flex items-start gap-3.5">
                            <div class="w-8 h-8 rounded-lg bg-teal-500/10 text-teal-400 flex items-center justify-center shrink-0 border border-teal-500/10">
                                <i class="fa-solid fa-envelope"></i>
                            </div>
                            <div class="space-y-0.5">
                                <span class="text-xxs text-slate-500 block font-bold uppercase">{{ __('messages.email_channel') }}</span>
                                <a href="mailto:{{ \App\Models\Setting::getValue('store_email', 'info@vision-medical.com') }}" class="hover:text-emerald-400 transition-all-300 block font-semibold text-white break-all">{{ \App\Models\Setting::getValue('store_email', 'info@vision-medical.com') }}</a>
                            </div>
                        </li>
                        <li class="flex items-start gap-3.5">
                            <div class="w-8 h-8 rounded-lg bg-emerald-500/10 text-emerald-400 flex items-center justify-center shrink-0 border border-emerald-500/10">
                                <i class="fa-brands fa-whatsapp text-base"></i>
                            </div>
                            <div class="space-y-0.5">
                                <span class="text-xxs text-slate-500 block font-bold uppercase">{{ __('messages.whatsapp_channel') }}</span>
                                <a href="https://wa.me/{{ \App\Models\Setting::getValue('whatsapp', '201001234567') }}" class="hover:text-emerald-400 transition-all-300 block font-semibold text-white" dir="ltr">+{{ \App\Models\Setting::getValue('whatsapp', '201001234567') }}</a>
                            </div>
                        </li>
                        <li class="flex items-start gap-3.5">
                            <div class="w-8 h-8 rounded-lg bg-amber-500/10 text-amber-400 flex items-center justify-center shrink-0 border border-amber-500/10">
                                <i class="fa-solid fa-clock"></i>
                            </div>
                            <div class="space-y-0.5">
                                <span class="text-xxs text-slate-500 block font-bold uppercase">{{ app()->getLocale() == 'ar' ? 'مواعيد العمل' : 'Working Hours' }}</span>
                                <span class="block font-semibold text-white leading-relaxed text-xs">
                                    {{ \App\Models\Setting::getWorkingHoursDisplay(app()->getLocale()) }}
                                </span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            
            <hr class="border-slate-900 my-10">
            
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-500">
                <p>
                    @php
                        $fTextAr = \App\Models\Setting::getValue('footer_text_ar', \App\Models\Setting::getValue('footer_text'));
                        $fTextEn = \App\Models\Setting::getValue('footer_text_en', 'All rights reserved © Vision Medical 2026.');
                    @endphp
                    {{ app()->getLocale() == 'ar' ? $fTextAr : $fTextEn }}
                </p>
                <div class="flex items-center gap-4">
                    <a href="#" class="hover:underline hover:text-slate-400 transition-all-300">Privacy Policy</a>
                    <a href="#" class="hover:underline hover:text-slate-400 transition-all-300">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Floating WhatsApp Button -->
    <a href="https://wa.me/{{ \App\Models\Setting::getValue('whatsapp', '201001234567') }}?text={{ urlencode(__('messages.whats_general_text')) }}" 
       target="_blank" 
       class="fixed bottom-6 right-6 z-50 w-14 h-14 bg-emerald-500 hover:bg-emerald-600 text-white rounded-full flex items-center justify-center shadow-lg hover:shadow-xl hover:scale-110 transition-all-300 group animate-pulse-glow"
       title="{{ __('messages.whatsapp_tooltip') }}">
        <i class="fa-brands fa-whatsapp text-3xl"></i>
        <!-- Tooltip -->
        <span class="absolute right-16 scale-0 group-hover:scale-100 bg-slate-900 text-white text-xs font-semibold px-3 py-1.5 rounded-lg shadow-md whitespace-nowrap transition-all-300">
            {{ __('messages.whatsapp_tooltip') }}
        </span>
    </a>

    <!-- Menu toggle script -->
    <script>
        const btn = document.getElementById('mobile-menu-btn');
        const menu = document.getElementById('mobile-menu');
        if (btn && menu) {
            btn.addEventListener('click', () => {
                menu.classList.toggle('hidden');
            });
        }
    </script>
    @yield('scripts')
</body>
</html>

