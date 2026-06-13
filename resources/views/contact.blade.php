@extends('layouts.app')

@section('title', __('messages.contact_us') . ' - ' . __('messages.store_name'))

@section('content')
    <div class="max-w-5xl mx-auto space-y-12 py-6">
        
        <!-- Header banner -->
        <div class="text-center space-y-4 animate-fade-in-up">
            <span class="bg-emerald-50 text-emerald-700 text-xs font-bold px-4 py-2 rounded-full border border-emerald-100/50 uppercase tracking-wider">{{ __('messages.contact_us') }}</span>
            <h1 class="text-3xl sm:text-4xl font-black text-slate-900 leading-tight">
                {{ __('messages.contact_title') }}
            </h1>
            <p class="text-slate-500 text-sm max-w-lg mx-auto leading-relaxed font-medium">
                {{ __('messages.contact_desc') }}
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-5 gap-8 animate-fade-in-up">
            
            <!-- Right: Direct Quick Contact (2 Columns) -->
            <div class="md:col-span-2 space-y-6">
                
                <div class="bg-white border border-slate-200/80 rounded-[2rem] p-6 sm:p-8 shadow-sm space-y-6">
                    <h3 class="font-bold text-slate-900 text-lg border-b border-slate-100 pb-4">{{ __('messages.direct_channels') }}</h3>
                    
                    <div class="space-y-4">
                        <!-- WhatsApp direct button -->
                        <a href="https://wa.me/{{ $whatsapp }}?text={{ urlencode(__('messages.whats_general_text')) }}" 
                           target="_blank"
                           class="flex items-center gap-4 p-4 bg-emerald-50/50 hover:bg-emerald-100/60 text-emerald-800 rounded-2xl border border-emerald-100/50 hover:border-emerald-200 transition-all-300 group shadow-xxs">
                            <div class="w-12 h-12 bg-emerald-500 rounded-xl flex items-center justify-center text-slate-950 text-xl shadow-md shadow-emerald-500/15 group-hover:scale-105 transition-all-300 shrink-0">
                                <i class="fa-brands fa-whatsapp"></i>
                            </div>
                            <div>
                                <span class="text-xs font-bold text-emerald-600 block">{{ __('messages.whatsapp_channel') }}</span>
                                <span class="text-sm font-black text-slate-900 block mt-0.5" dir="ltr">+{{ $whatsapp }}</span>
                            </div>
                        </a>

                        <!-- Phone Call direct button -->
                        <a href="tel:{{ $phone }}" 
                           class="flex items-center gap-4 p-4 bg-sky-50/50 hover:bg-sky-100/60 text-sky-800 rounded-2xl border border-sky-100/50 hover:border-sky-200 transition-all-300 group shadow-xxs">
                            <div class="w-12 h-12 bg-sky-500 rounded-xl flex items-center justify-center text-white text-xl shadow-md shadow-sky-500/15 group-hover:scale-105 transition-all-300 shrink-0">
                                <i class="fa-solid fa-phone"></i>
                            </div>
                            <div>
                                <span class="text-xs font-bold text-sky-600 block">{{ __('messages.call_channel') }}</span>
                                <span class="text-sm font-black text-slate-900 block mt-0.5" dir="ltr">{{ $phone }}</span>
                            </div>
                        </a>

                        <!-- Email direct button -->
                        <a href="mailto:{{ $email }}" 
                           class="flex items-center gap-4 p-4 bg-violet-50/50 hover:bg-violet-100/60 text-violet-800 rounded-2xl border border-violet-100/50 hover:border-violet-200 transition-all-300 group shadow-xxs">
                            <div class="w-12 h-12 bg-violet-500 rounded-xl flex items-center justify-center text-white text-xl shadow-md shadow-violet-500/15 group-hover:scale-105 transition-all-300 shrink-0">
                                <i class="fa-solid fa-envelope"></i>
                            </div>
                            <div>
                                <span class="text-xs font-bold text-violet-600 block">{{ __('messages.email_channel') }}</span>
                                <span class="text-sm font-black text-slate-900 block mt-0.5 break-all">{{ $email }}</span>
                            </div>
                        </a>
                    </div>
                </div>

            </div>

            <!-- Left: Contact Form (3 Columns) -->
            <div class="md:col-span-3 bg-white border border-slate-200/80 rounded-[2rem] p-6 sm:p-8 shadow-sm">
                <h3 class="font-bold text-slate-900 text-lg border-b border-slate-100 pb-4 mb-6">{{ __('messages.send_message_title') }}</h3>
                
                <form action="{{ route('contact.submit') }}" method="POST" class="space-y-4">
                    @csrf
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-xs font-bold text-slate-600 mb-1.5">{{ __('messages.name_label') }}</label>
                            <input type="text" name="name" id="name" required 
                                   placeholder="{{ __('messages.name_placeholder') }}" 
                                   class="w-full bg-slate-50 border border-slate-200 focus:border-emerald-500 focus:bg-white focus:ring-1 focus:ring-emerald-500/20 rounded-xl px-4 py-3.5 text-slate-900 text-sm focus:outline-none transition-all-300 shadow-sm">
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-xs font-bold text-slate-600 mb-1.5">{{ __('messages.email') }}</label>
                            <input type="email" name="email" id="email" required 
                                   placeholder="{{ __('messages.email_placeholder') }}" 
                                   class="w-full bg-slate-50 border border-slate-200 focus:border-emerald-500 focus:bg-white focus:ring-1 focus:ring-emerald-500/20 rounded-xl px-4 py-3.5 text-slate-900 text-sm focus:outline-none transition-all-300 shadow-sm">
                        </div>
                    </div>

                    <!-- Subject -->
                    <div>
                        <label for="subject" class="block text-xs font-bold text-slate-600 mb-1.5">{{ __('messages.subject_label') }}</label>
                        <input type="text" name="subject" id="subject" 
                               placeholder="{{ __('messages.subject_placeholder') }}" 
                               class="w-full bg-slate-50 border border-slate-200 focus:border-emerald-500 focus:bg-white focus:ring-1 focus:ring-emerald-500/20 rounded-xl px-4 py-3.5 text-slate-900 text-sm focus:outline-none transition-all-300 shadow-sm">
                    </div>

                    <!-- Message -->
                    <div>
                        <label for="message" class="block text-xs font-bold text-slate-600 mb-1.5">{{ __('messages.message_label') }}</label>
                        <textarea name="message" id="message" rows="5" required 
                                  placeholder="{{ __('messages.message_placeholder') }}" 
                                  class="w-full bg-slate-50 border border-slate-200 focus:border-emerald-500 focus:bg-white focus:ring-1 focus:ring-emerald-500/20 rounded-xl px-4 py-3.5 text-slate-900 text-sm focus:outline-none transition-all-300 shadow-sm"></textarea>
                    </div>

                    <button type="submit" class="w-full bg-slate-950 hover:bg-emerald-500 hover:text-slate-950 font-black py-4 rounded-xl shadow-md transition-all-300 text-sm">
                        {{ __('messages.submit_message') }}
                    </button>
                </form>
            </div>

        </div>

        <!-- Map Section -->
        @if($mapLink)
            <style>
                #map-container iframe {
                    width: 100% !important;
                    height: 100% !important;
                    border: 0 !important;
                    border-radius: 1rem;
                }
            </style>
            <div id="map" class="bg-white border border-slate-200/80 rounded-[2rem] p-6 sm:p-8 shadow-sm space-y-6 mt-8 animate-fade-in-up">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-slate-100 pb-4">
                    <div class="space-y-1 {{ app()->getLocale() == 'ar' ? 'text-right' : 'text-left' }}">
                        <h3 class="font-bold text-slate-900 text-lg flex items-center gap-2">
                            <i class="fa-solid fa-map-location-dot text-emerald-500 text-xl"></i>
                            <span>{{ __('messages.company_map') }}</span>
                        </h3>
                        <p class="text-slate-500 text-xs font-medium">{{ __('messages.map_description') }}</p>
                    </div>
                    @php
                        $directUrl = $mapLink;
                        if (str_contains($mapLink, 'iframe')) {
                            preg_match('/src="([^"]+)"/', $mapLink, $match);
                            $directUrl = $match[1] ?? 'https://maps.google.com/?q=' . urlencode(__('messages.vision_medical'));
                        }
                    @endphp
                    <a href="{{ $directUrl }}" 
                       target="_blank"
                       class="inline-flex items-center gap-2 bg-slate-50 hover:bg-emerald-500 hover:text-slate-950 border border-slate-200/60 text-slate-700 font-bold text-xs px-5 py-3.5 rounded-xl transition-all-300 shadow-xs">
                        <i class="fa-solid fa-up-right-from-square text-[10px]"></i>
                        <span>{{ __('messages.view_on_map') }}</span>
                    </a>
                </div>
                
                <div id="map-container" class="relative w-full h-[380px] rounded-2xl overflow-hidden border border-slate-200/80 bg-slate-50 shadow-inner">
                    @if(str_contains($mapLink, '<iframe'))
                        {!! $mapLink !!}
                    @elseif(str_contains($mapLink, 'http'))
                        <iframe 
                            src="{{ str_contains($mapLink, 'google.com/maps/embed') ? $mapLink : 'https://maps.google.com/maps?q=' . urlencode($mapLink) . '&t=&z=15&ie=UTF8&iwloc=&output=embed' }}" 
                            class="absolute inset-0 w-full h-full border-0" 
                            allowfullscreen="" 
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    @else
                        <!-- Treat as text query -->
                        <iframe 
                            src="https://maps.google.com/maps?q={{ urlencode($mapLink) }}&t=&z=15&ie=UTF8&iwloc=&output=embed" 
                            class="absolute inset-0 w-full h-full border-0" 
                            allowfullscreen="" 
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    @endif
                </div>
            </div>
        @endif

    </div>
@endsection
