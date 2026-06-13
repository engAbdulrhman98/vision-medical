<!DOCTYPE html>
<html lang="{{ \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale() }}" dir="{{ \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocaleDirection() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('page_title', __('messages.admin_dashboard_title')) | {{ __('messages.vision_medical') }}</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    
    <!-- Google Fonts: Tajawal -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    
    <!-- FontAwesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Tailwind CSS (Vite) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body {
            font-family: 'Tajawal', sans-serif;
            background-color: #f1f5f9;
        }
        .transition-all-300 {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
    </style>
    @yield('styles')
</head>
<body class="flex min-h-screen text-slate-800 antialiased">

    <!-- Sidebar Navigation -->
    <aside class="w-64 bg-slate-900 text-slate-300 flex flex-col justify-between shrink-0 shadow-xl border-slate-800 {{ app()->getLocale() == 'ar' ? 'border-l' : 'border-r' }}">
        
        <!-- Sidebar Top / Brand -->
        <div>
            <div class="p-6 border-b border-slate-800 flex items-center gap-3 bg-slate-950">
                <div class="w-10 h-10 bg-emerald-600 rounded-lg flex items-center justify-center text-white text-lg">
                    <i class="fa-solid fa-user-shield"></i>
                </div>
                <div>
                    <span class="text-sm font-bold text-white block leading-tight">{{ __('messages.admin_portal') }}</span>
                    <span class="text-xxs font-semibold text-emerald-500 uppercase block tracking-wider mt-0.5">Admin Panel</span>
                </div>
            </div>

            <!-- Navigation Links -->
            @php
                $pendingReviewsCount = \App\Models\Review::where('is_approved', false)->count();
                $unreadMessagesCount = \App\Models\ContactMessage::where('is_read', false)->count();
            @endphp
            <nav class="p-4 space-y-1">
                <!-- Dashboard -->
                <a href="{{ route('admin.dashboard') }}" class="flex items-center justify-between px-4 py-3 rounded-xl text-sm font-medium transition-all-300 {{ Request::routeIs('admin.dashboard') ? 'bg-emerald-600 text-white font-bold' : 'hover:bg-slate-800 hover:text-white' }}">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-gauge-high text-base"></i>
                        <span>{{ __('messages.admin_home') }}</span>
                    </div>
                </a>

                <!-- Categories -->
                <a href="{{ route('admin.categories.index') }}" class="flex items-center justify-between px-4 py-3 rounded-xl text-sm font-medium transition-all-300 {{ Request::routeIs('admin.categories.*') ? 'bg-emerald-600 text-white font-bold' : 'hover:bg-slate-800 hover:text-white' }}">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-list-ul text-base"></i>
                        <span>{{ __('messages.admin_categories') }}</span>
                    </div>
                </a>

                <!-- Brands -->
                <a href="{{ route('admin.brands.index') }}" class="flex items-center justify-between px-4 py-3 rounded-xl text-sm font-medium transition-all-300 {{ Request::routeIs('admin.brands.*') ? 'bg-emerald-600 text-white font-bold' : 'hover:bg-slate-800 hover:text-white' }}">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-copyright text-base"></i>
                        <span>{{ __('messages.admin_brands') }}</span>
                    </div>
                </a>

                <!-- Products -->
                <a href="{{ route('admin.products.index') }}" class="flex items-center justify-between px-4 py-3 rounded-xl text-sm font-medium transition-all-300 {{ Request::routeIs('admin.products.*') ? 'bg-emerald-600 text-white font-bold' : 'hover:bg-slate-800 hover:text-white' }}">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-boxes-stacked text-base"></i>
                        <span>{{ __('messages.admin_products') }}</span>
                    </div>
                </a>

                <!-- Reviews moderation -->
                <a href="{{ route('admin.reviews.index') }}" class="flex items-center justify-between px-4 py-3 rounded-xl text-sm font-medium transition-all-300 {{ Request::routeIs('admin.reviews.*') ? 'bg-emerald-600 text-white font-bold' : 'hover:bg-slate-800 hover:text-white' }}">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-comments text-base"></i>
                        <span>{{ __('messages.admin_reviews') }}</span>
                    </div>
                    @if($pendingReviewsCount > 0)
                        <span class="bg-rose-600 text-white text-xxs font-black px-2 py-0.5 rounded-full shadow-xs">{{ $pendingReviewsCount }}</span>
                    @endif
                </a>

                <!-- Contact messages -->
                <a href="{{ route('admin.contacts.index') }}" class="flex items-center justify-between px-4 py-3 rounded-xl text-sm font-medium transition-all-300 {{ Request::routeIs('admin.contacts.*') ? 'bg-emerald-600 text-white font-bold' : 'hover:bg-slate-800 hover:text-white' }}">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-envelope text-base"></i>
                        <span>{{ __('messages.admin_messages') }}</span>
                    </div>
                    @if($unreadMessagesCount > 0)
                        <span class="bg-rose-600 text-white text-xxs font-black px-2 py-0.5 rounded-full shadow-xs">{{ $unreadMessagesCount }}</span>
                    @endif
                </a>

                <!-- Site Settings -->
                <a href="{{ route('admin.settings.index') }}" class="flex items-center justify-between px-4 py-3 rounded-xl text-sm font-medium transition-all-300 {{ Request::routeIs('admin.settings.*') ? 'bg-emerald-600 text-white font-bold' : 'hover:bg-slate-800 hover:text-white' }}">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-gears text-base"></i>
                        <span>{{ __('messages.admin_settings') }}</span>
                    </div>
                </a>
            </nav>
        </div>

        <!-- Sidebar Bottom / User & Logout -->
        <div class="p-4 border-t border-slate-800 bg-slate-950/50 space-y-3">
            <div class="flex items-center gap-3 px-2">
                <div class="w-9 h-9 bg-slate-800 rounded-full flex items-center justify-center text-slate-300">
                    <i class="fa-solid fa-user-tie"></i>
                </div>
                <div class="overflow-hidden">
                    <span class="text-xs font-bold text-white block truncate">{{ Auth::user()->name }}</span>
                    <span class="text-xxs text-slate-500 block truncate">{{ __('messages.admin_role') }}</span>
                </div>
            </div>
            
            <a href="{{ route('home') }}" class="flex items-center justify-center gap-2 bg-slate-800 hover:bg-slate-700 text-slate-200 text-xs font-semibold py-2.5 rounded-lg transition-all-300">
                <i class="fa-solid fa-globe text-slate-400"></i>
                <span>{{ __('messages.view_store') }}</span>
            </a>

            <form action="{{ route('logout') }}" method="POST" class="block w-full">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-2 bg-rose-950/30 hover:bg-rose-900/40 text-rose-400 text-xs font-semibold py-2.5 rounded-lg border border-rose-950/50 hover:border-rose-900/50 transition-all-300">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i>
                    <span>{{ __('messages.logout') }}</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-grow flex flex-col min-h-screen overflow-y-auto">
        
        <!-- Header -->
        <header class="bg-white border-b border-slate-100 px-8 py-5 flex items-center justify-between shadow-xs">
            <div class="flex items-center gap-6">
                <h1 class="text-xl font-black text-slate-900">@yield('page_title', __('messages.admin_dashboard_title'))</h1>
                
                <!-- Language Switcher Button -->
                <div class="border-l border-slate-100 pl-4 flex items-center gap-2">
                    @foreach(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                        @if($localeCode !== \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale())
                            <a href="{{ \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}" 
                               class="flex items-center gap-1.5 text-xs font-bold text-slate-700 hover:text-emerald-600 transition-all-300 px-3 py-2 bg-slate-50 hover:bg-slate-100 rounded-lg border border-slate-100/50">
                                <i class="fa-solid fa-language text-emerald-600 text-sm"></i>
                                <span>{{ $properties['native'] }}</span>
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>
            
            <!-- Quick Notification Alert for Pending actions -->
            @if($pendingReviewsCount > 0 || $unreadMessagesCount > 0)
                <div class="flex items-center gap-4 text-xs font-medium">
                    @if($pendingReviewsCount > 0)
                        <a href="{{ route('admin.reviews.index', ['status' => 'pending']) }}" class="flex items-center gap-2 bg-amber-50 text-amber-800 border border-amber-200/50 px-3.5 py-1.5 rounded-full hover:bg-amber-100 transition-all-300">
                            <span class="w-2.5 h-2.5 bg-amber-500 rounded-full animate-ping"></span>
                            <span>{{ __('messages.pending_reviews_alert', ['count' => $pendingReviewsCount]) }}</span>
                        </a>
                    @endif

                    @if($unreadMessagesCount > 0)
                        <a href="{{ route('admin.contacts.index') }}" class="flex items-center gap-2 bg-rose-50 text-rose-800 border border-rose-200/50 px-3.5 py-1.5 rounded-full hover:bg-rose-100 transition-all-300">
                            <span class="w-2.5 h-2.5 bg-rose-500 rounded-full animate-ping"></span>
                            <span>{{ __('messages.unread_messages_alert', ['count' => $unreadMessagesCount]) }}</span>
                        </a>
                    @endif
                </div>
            @endif
        </header>

        <!-- Main Body -->
        <main class="p-8 flex-grow">
            <!-- Flash Messages -->
            @if(session('success'))
                <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3.5 rounded-xl shadow-xs flex items-center gap-3 animate-fade-in">
                    <i class="fa-solid fa-circle-check text-emerald-600 text-lg"></i>
                    <div class="text-sm font-semibold">{{ session('success') }}</div>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 bg-rose-50 border border-rose-200 text-rose-800 px-4 py-3.5 rounded-xl shadow-xs flex items-center gap-3 animate-fade-in">
                    <i class="fa-solid fa-circle-exclamation text-rose-600 text-lg"></i>
                    <div class="text-sm font-semibold">{{ session('error') }}</div>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    @yield('scripts')
</body>
</html>
