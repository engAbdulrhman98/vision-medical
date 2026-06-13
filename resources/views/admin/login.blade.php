<!DOCTYPE html>
<html lang="{{ \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale() }}" dir="{{ \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocaleDirection() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.login') }} | {{ __('messages.vision_medical') }}</title>
    
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
            background-color: #0f172a; /* Slate 900 */
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen p-4 antialiased">
    
    <!-- Decorative background blobs -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none z-0">
        <div class="absolute -top-40 -left-40 w-96 h-96 bg-emerald-500/10 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-40 -right-40 w-96 h-96 bg-teal-500/10 rounded-full blur-3xl"></div>
    </div>

    <!-- Login Container -->
    <div class="relative w-full max-w-md bg-slate-900/60 backdrop-blur-md border border-slate-800 p-8 rounded-3xl shadow-2xl z-10 space-y-8">
        
        <!-- Logo / Title -->
        <div class="text-center space-y-3">
            <div class="inline-flex w-16 h-16 bg-emerald-600 rounded-2xl items-center justify-center text-white text-3xl shadow-lg shadow-emerald-600/30">
                <i class="fa-solid fa-user-shield"></i>
            </div>
            <div>
                <h1 class="text-2xl font-black text-white">{{ __('messages.login_title') }}</h1>
                <p class="text-slate-400 text-xs mt-1">{{ __('messages.login_sub') }}</p>
            </div>
        </div>

        <!-- Validation Errors -->
        @if ($errors->any())
            <div class="bg-rose-500/10 border border-rose-500/30 text-rose-300 p-4 rounded-xl text-xs leading-relaxed space-y-1">
                @foreach ($errors->all() as $error)
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-circle-exclamation text-rose-500"></i>
                        <span>{{ $error }}</span>
                    </div>
                @endforeach
            </div>
        @endif

        <!-- Login Form -->
        <form action="{{ route('login') }}" method="POST" class="space-y-5">
            @csrf

            <!-- Email -->
            <div class="space-y-1.5">
                <label for="email" class="block text-xs font-semibold text-slate-300">{{ __('messages.email') }}</label>
                <div class="relative">
                    <i class="fa-solid fa-envelope absolute {{ app()->getLocale() == 'ar' ? 'right-4' : 'left-4' }} top-1/2 -translate-y-1/2 text-slate-500 text-sm"></i>
                    <input type="email" name="email" id="email" required value="{{ old('email') }}"
                           placeholder="admin@vision-medical.com" 
                           class="w-full bg-slate-950 border border-slate-800 focus:border-emerald-500 focus:bg-slate-950/80 rounded-xl {{ app()->getLocale() == 'ar' ? 'pl-4 pr-11 text-right' : 'pl-11 pr-4 text-left' }} py-3.5 text-white placeholder-slate-600 text-sm focus:outline-hidden transition-all-300">
                </div>
            </div>

            <!-- Password -->
            <div class="space-y-1.5">
                <label for="password" class="block text-xs font-semibold text-slate-300">{{ __('messages.password') }}</label>
                <div class="relative">
                    <i class="fa-solid fa-lock absolute {{ app()->getLocale() == 'ar' ? 'right-4' : 'left-4' }} top-1/2 -translate-y-1/2 text-slate-500 text-sm"></i>
                    <input type="password" name="password" id="password" required
                           placeholder="••••••••" 
                           class="w-full bg-slate-950 border border-slate-800 focus:border-emerald-500 focus:bg-slate-950/80 rounded-xl {{ app()->getLocale() == 'ar' ? 'pl-4 pr-11 text-right' : 'pl-11 pr-4 text-left' }} py-3.5 text-white placeholder-slate-600 text-sm focus:outline-hidden transition-all-300">
                </div>
            </div>

            <!-- Remember me & Forgot password (optional) -->
            <div class="flex items-center justify-between text-xs">
                <label class="flex items-center gap-2 text-slate-400 cursor-pointer select-none">
                    <input type="checkbox" name="remember" class="accent-emerald-500 bg-slate-950 border-slate-800 rounded">
                    <span>{{ __('messages.remember_me') }}</span>
                </label>
                
                <a href="{{ route('home') }}" class="text-emerald-500 hover:underline">{{ __('messages.back_to_store') }}</a>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-4 rounded-xl shadow-lg shadow-emerald-600/10 transition-all-300 text-sm flex items-center justify-center gap-2">
                <span>{{ __('messages.login_btn') }}</span>
                <i class="fa-solid fa-shield-halved"></i>
            </button>
        </form>
    </div>
</body>
</html>
