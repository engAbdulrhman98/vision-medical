<!DOCTYPE html>
<html lang="{{ \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale() }}" dir="{{ \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocaleDirection() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('page_title', __('messages.admin_dashboard_title')) | {{ __('messages.vision_medical') }}</title>
    
    <!-- Favicon -->
    <link class="favicon" rel="icon" type="image/png" href="{{ asset('favicon.png') }}?v=3">
    <link class="favicon" rel="shortcut icon" href="{{ asset('favicon.ico') }}?v=3">
    
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

        /* Sidebar drawer for mobile */
        #admin-sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            z-index: 50;
            width: 17rem; /* 272px */
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* RTL: sidebar comes from the right */
        html[dir="rtl"] #admin-sidebar {
            right: 0;
            left: auto;
            transform: translateX(100%);
        }

        /* LTR: sidebar comes from the left */
        html[dir="ltr"] #admin-sidebar {
            left: 0;
            right: auto;
            transform: translateX(-100%);
        }

        /* Open state (mobile) */
        html[dir="rtl"] #admin-sidebar.sidebar-open,
        html[dir="ltr"] #admin-sidebar.sidebar-open {
            transform: translateX(0) !important;
        }

        /* On md+ screens, sidebar is always visible */
        @media (min-width: 768px) {
            html[dir="rtl"] #admin-sidebar,
            html[dir="ltr"] #admin-sidebar {
                position: sticky;
                top: 0;
                height: 100vh;
                transform: translateX(0) !important;
                flex-shrink: 0;
            }
        }

        .nav-link-transition {
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-8px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in { animation: fadeIn 0.4s ease forwards; }
    </style>
    @yield('styles')
</head>
<body class="flex min-h-screen text-slate-800 antialiased bg-slate-100 overflow-x-hidden">

    <!-- Mobile Sidebar Overlay -->
    <div id="sidebar-overlay"
         class="fixed inset-0 bg-black/50 z-40 md:hidden transition-opacity duration-300 opacity-0 pointer-events-none"
         onclick="closeSidebar()"></div>

    <!-- Sidebar Navigation -->
    <aside id="admin-sidebar"
           class="bg-slate-900 text-slate-300 flex flex-col justify-between shadow-2xl border-slate-800"
           style="{{ app()->getLocale() == 'ar' ? 'border-left: 1px solid #1e293b;' : 'border-right: 1px solid #1e293b;' }}">
        
        <!-- Sidebar Top / Brand -->
        <div class="overflow-y-auto flex-grow">
            <div class="p-5 border-b border-slate-800 flex items-center justify-between bg-slate-950 sticky top-0 z-10">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-emerald-600 rounded-lg flex items-center justify-center text-white text-lg shrink-0">
                        <i class="fa-solid fa-user-shield"></i>
                    </div>
                    <div>
                        <span class="text-sm font-bold text-white block leading-tight">{{ __('messages.admin_portal') }}</span>
                        <span class="text-[10px] font-semibold text-emerald-500 uppercase block tracking-wider mt-0.5">Admin Panel</span>
                    </div>
                </div>
                <!-- Close button (mobile only) -->
                <button onclick="closeSidebar()" class="md:hidden w-8 h-8 flex items-center justify-center text-slate-400 hover:text-white rounded-lg hover:bg-slate-800 transition-all">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <!-- Navigation Links -->
            @php
                $pendingReviewsCount = \App\Models\Review::where('is_approved', false)->count();
                $unreadMessagesCount = \App\Models\ContactMessage::where('is_read', false)->count();
            @endphp
            <nav class="p-4 space-y-1">
                <!-- Dashboard -->
                <a href="{{ route('admin.dashboard') }}" onclick="closeSidebar()"
                   class="flex items-center justify-between px-4 py-3 rounded-xl text-sm font-medium nav-link-transition
                          {{ Request::routeIs('admin.dashboard') ? 'bg-emerald-600 text-white font-bold' : 'hover:bg-slate-800 hover:text-white' }}">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-gauge-high text-base w-5 text-center"></i>
                        <span>{{ __('messages.admin_home') }}</span>
                    </div>
                </a>

                <!-- Categories -->
                <a href="{{ route('admin.categories.index') }}" onclick="closeSidebar()"
                   class="flex items-center justify-between px-4 py-3 rounded-xl text-sm font-medium nav-link-transition
                          {{ Request::routeIs('admin.categories.*') ? 'bg-emerald-600 text-white font-bold' : 'hover:bg-slate-800 hover:text-white' }}">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-list-ul text-base w-5 text-center"></i>
                        <span>{{ __('messages.admin_categories') }}</span>
                    </div>
                </a>

                <!-- Brands -->
                <a href="{{ route('admin.brands.index') }}" onclick="closeSidebar()"
                   class="flex items-center justify-between px-4 py-3 rounded-xl text-sm font-medium nav-link-transition
                          {{ Request::routeIs('admin.brands.*') ? 'bg-emerald-600 text-white font-bold' : 'hover:bg-slate-800 hover:text-white' }}">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-copyright text-base w-5 text-center"></i>
                        <span>{{ __('messages.admin_brands') }}</span>
                    </div>
                </a>

                <!-- Products -->
                <a href="{{ route('admin.products.index') }}" onclick="closeSidebar()"
                   class="flex items-center justify-between px-4 py-3 rounded-xl text-sm font-medium nav-link-transition
                          {{ Request::routeIs('admin.products.*') ? 'bg-emerald-600 text-white font-bold' : 'hover:bg-slate-800 hover:text-white' }}">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-boxes-stacked text-base w-5 text-center"></i>
                        <span>{{ __('messages.admin_products') }}</span>
                    </div>
                </a>

                <!-- Reviews -->
                <a href="{{ route('admin.reviews.index') }}" onclick="closeSidebar()"
                   class="flex items-center justify-between px-4 py-3 rounded-xl text-sm font-medium nav-link-transition
                          {{ Request::routeIs('admin.reviews.*') ? 'bg-emerald-600 text-white font-bold' : 'hover:bg-slate-800 hover:text-white' }}">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-comments text-base w-5 text-center"></i>
                        <span>{{ __('messages.admin_reviews') }}</span>
                    </div>
                    @if($pendingReviewsCount > 0)
                        <span class="bg-rose-600 text-white text-[10px] font-black px-2 py-0.5 rounded-full">{{ $pendingReviewsCount }}</span>
                    @endif
                </a>

                <!-- Contact Messages -->
                <a href="{{ route('admin.contacts.index') }}" onclick="closeSidebar()"
                   class="flex items-center justify-between px-4 py-3 rounded-xl text-sm font-medium nav-link-transition
                          {{ Request::routeIs('admin.contacts.*') ? 'bg-emerald-600 text-white font-bold' : 'hover:bg-slate-800 hover:text-white' }}">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-envelope text-base w-5 text-center"></i>
                        <span>{{ __('messages.admin_messages') }}</span>
                    </div>
                    @if($unreadMessagesCount > 0)
                        <span class="bg-rose-600 text-white text-[10px] font-black px-2 py-0.5 rounded-full">{{ $unreadMessagesCount }}</span>
                    @endif
                </a>

                <!-- Site Settings -->
                <a href="{{ route('admin.settings.index') }}" onclick="closeSidebar()"
                   class="flex items-center justify-between px-4 py-3 rounded-xl text-sm font-medium nav-link-transition
                          {{ Request::routeIs('admin.settings.*') ? 'bg-emerald-600 text-white font-bold' : 'hover:bg-slate-800 hover:text-white' }}">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-gears text-base w-5 text-center"></i>
                        <span>{{ __('messages.admin_settings') }}</span>
                    </div>
                </a>

            </nav>
        </div>

        <!-- Sidebar Bottom / User & Logout -->
        <div class="p-4 border-t border-slate-800 bg-slate-950/50 space-y-3 shrink-0">
            <div class="flex items-center gap-3 px-2">
                <div class="w-9 h-9 bg-slate-800 rounded-full flex items-center justify-center text-slate-300 shrink-0">
                    <i class="fa-solid fa-user-tie"></i>
                </div>
                <div class="overflow-hidden">
                    <span class="text-xs font-bold text-white block truncate">{{ Auth::user()->name }}</span>
                    <span class="text-[10px] text-slate-500 block truncate">{{ __('messages.admin_role') }}</span>
                </div>
            </div>
            
            <a href="{{ route('home') }}" class="flex items-center justify-center gap-2 bg-slate-800 hover:bg-slate-700 text-slate-200 text-xs font-semibold py-2.5 rounded-lg nav-link-transition">
                <i class="fa-solid fa-globe text-slate-400"></i>
                <span>{{ __('messages.view_store') }}</span>
            </a>

            <form action="{{ route('logout') }}" method="POST" class="block w-full">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-2 bg-rose-950/30 hover:bg-rose-900/40 text-rose-400 text-xs font-semibold py-2.5 rounded-lg border border-rose-950/50 hover:border-rose-900/50 nav-link-transition">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i>
                    <span>{{ __('messages.logout') }}</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-grow flex flex-col min-h-screen min-w-0">
        
        <!-- Top Header -->
        <header id="admin-top-header" class="bg-white border-b border-slate-100 px-4 sm:px-6 lg:px-8 py-4 flex items-center justify-between shadow-sm sticky top-0 z-30">
            <div class="flex items-center gap-3 sm:gap-6 min-w-0">
                <!-- Hamburger (mobile only) -->
                <button onclick="openSidebar()" class="md:hidden w-9 h-9 flex items-center justify-center bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-lg transition-all shrink-0">
                    <i class="fa-solid fa-bars"></i>
                </button>

                <h1 class="text-base sm:text-xl font-black text-slate-900 truncate">@yield('page_title', __('messages.admin_dashboard_title'))</h1>
                
                <!-- Language Switcher -->
                <div class="border-s border-slate-100 ps-3 sm:ps-4 flex items-center gap-2 shrink-0">
                    @foreach(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                        @if($localeCode !== \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale())
                            <a href="{{ \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}" 
                               class="flex items-center gap-1.5 text-xs font-bold text-slate-700 hover:text-emerald-600 nav-link-transition px-3 py-2 bg-slate-50 hover:bg-slate-100 rounded-lg border border-slate-100/50">
                                <i class="fa-solid fa-language text-emerald-600 text-sm"></i>
                                <span>{{ $properties['native'] }}</span>
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>
            
            <!-- Notification Alerts -->
            @if($pendingReviewsCount > 0 || $unreadMessagesCount > 0)
                <div class="flex items-center gap-2 shrink-0">
                    @if($pendingReviewsCount > 0)
                        <a href="{{ route('admin.reviews.index', ['status' => 'pending']) }}"
                           class="flex items-center gap-2 bg-amber-50 text-amber-800 border border-amber-200 px-3 py-1.5 rounded-full hover:bg-amber-100 nav-link-transition text-xs font-semibold whitespace-nowrap">
                            <span class="relative flex h-2 w-2 shrink-0">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-amber-500"></span>
                            </span>
                            <i class="fa-solid fa-comments text-amber-600"></i>
                            <span>{{ trans_choice('messages.pending_reviews_alert', $pendingReviewsCount, ['count' => $pendingReviewsCount]) }}</span>
                        </a>
                    @endif

                    @if($unreadMessagesCount > 0)
                        <a href="{{ route('admin.contacts.index') }}"
                           class="flex items-center gap-2 bg-rose-50 text-rose-800 border border-rose-200 px-3 py-1.5 rounded-full hover:bg-rose-100 nav-link-transition text-xs font-semibold whitespace-nowrap">
                            <span class="relative flex h-2 w-2 shrink-0">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-rose-500"></span>
                            </span>
                            <i class="fa-solid fa-envelope text-rose-600"></i>
                            <span>{{ trans_choice('messages.unread_messages_alert', $unreadMessagesCount, ['count' => $unreadMessagesCount]) }}</span>
                        </a>
                    @endif
                </div>
            @endif
        </header>

        <!-- Main Body -->
        <main class="p-4 sm:p-6 lg:p-8 flex-grow">
            <!-- Flash Messages -->
            @if(session('success'))
                <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3.5 rounded-xl shadow-sm flex items-center gap-3 animate-fade-in">
                    <i class="fa-solid fa-circle-check text-emerald-600 text-lg shrink-0"></i>
                    <div class="text-sm font-semibold">{{ session('success') }}</div>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 bg-rose-50 border border-rose-200 text-rose-800 px-4 py-3.5 rounded-xl shadow-sm flex items-center gap-3 animate-fade-in">
                    <i class="fa-solid fa-circle-exclamation text-rose-600 text-lg shrink-0"></i>
                    <div class="text-sm font-semibold">{{ session('error') }}</div>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <script>
        function openSidebar() {
            const sidebar = document.getElementById('admin-sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            sidebar.classList.add('sidebar-open');
            overlay.classList.remove('opacity-0', 'pointer-events-none');
            overlay.classList.add('opacity-100');
        }

        function closeSidebar() {
            const sidebar = document.getElementById('admin-sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            sidebar.classList.remove('sidebar-open');
            overlay.classList.add('opacity-0', 'pointer-events-none');
            overlay.classList.remove('opacity-100');
        }
    </script>

    @yield('scripts')
</body>
</html>
