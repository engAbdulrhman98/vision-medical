@extends('layouts.app')

@section('title', __('messages.vision_medical') . ' - ' . __('messages.service_maintenance_title'))

@section('content')
    <!-- Hero Maintenance Section -->
    <div class="relative bg-slate-950 rounded-[2rem] overflow-hidden mb-20 shadow-2xl border border-slate-900 group">
        <!-- Ambient Background Light Effects -->
        <div class="absolute inset-0 opacity-10 bg-[radial-gradient(ellipse_at_center,_var(--tw-gradient-stops))] from-emerald-500 via-transparent to-transparent"></div>
        <div class="absolute -top-40 -left-40 w-96 h-96 bg-emerald-500/10 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-40 -right-40 w-96 h-96 bg-emerald-500/10 rounded-full blur-3xl text-emerald-400"></div>
        
        <!-- Subtle Grid Pattern Overlay -->
        <div class="absolute inset-0 bg-[linear-gradient(to_right,#022c22_1px,transparent_1px),linear-gradient(to_bottom,#022c22_1px,transparent_1px)] bg-[size:4rem_4rem] [mask-image:radial-gradient(ellipse_60%_50%_at_50%_50%,#000_70%,transparent_100%)] opacity-30"></div>

        <div class="relative max-w-7xl mx-auto px-6 py-20 lg:py-24 sm:px-12 grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            
            <!-- Left: Hero Text (8 cols on lg) -->
            <div class="lg:col-span-7 space-y-8 text-center lg:text-start animate-fade-in-up">
                <span class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-500/10 text-emerald-400 text-xs font-bold rounded-full border border-emerald-500/20 uppercase tracking-widest">
                    <i class="fa-solid fa-screwdriver-wrench animate-pulse"></i>
                    <span>{{ __('messages.service_maintenance_title') }}</span>
                </span>
                
                <h1 class="text-4xl sm:text-6xl font-black text-white tracking-tight leading-tight">
                    {{ app()->getLocale() == 'ar' ? 'صيانة ومعايرة الأجهزة الطبية بمعايير هندسية دقيقة' : 'Medical Equipment Maintenance & Calibration with Precision Engineering' }}
                </h1>
                
                <p class="text-base sm:text-lg text-slate-300 leading-relaxed max-w-2xl mx-auto lg:mx-0">
                    {{ app()->getLocale() == 'ar' 
                        ? 'في فيجن ميديكال، نقدم حلول صيانة متكاملة وعقود صيانة دورية وقائية للمجمعات الطبية والمستشفيات، بقطع غيار أصلية ومعتمدة محلياً وعالمياً.' 
                        : 'At Vision Medical, we offer integrated maintenance solutions and preventive contract services for medical complexes and hospitals, utilizing certified original spare parts.' }}
                </p>
                
                <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start items-center pt-4">
                    <a href="#request-maintenance" class="w-full sm:w-auto bg-emerald-500 hover:bg-emerald-600 text-slate-950 font-extrabold text-sm px-8 py-4 rounded-xl transition-all-300 shadow-lg shadow-emerald-500/10 hover:shadow-emerald-500/20 flex items-center justify-center gap-2">
                        <i class="fa-solid fa-file-invoice"></i>
                        <span>{{ app()->getLocale() == 'ar' ? 'طلب صيانة جهاز الآن' : 'Request Maintenance Now' }}</span>
                    </a>
                    
                    @php
                        $mWhatsapp = \App\Models\Setting::getValue('maintenance_whatsapp', \App\Models\Setting::getValue('whatsapp', '966507654321'));
                        $mPhone = \App\Models\Setting::getValue('maintenance_phone', \App\Models\Setting::getValue('store_phone', '+966 50 765 4321'));
                    @endphp
                    <a href="https://wa.me/{{ $mWhatsapp }}?text={{ urlencode(app()->getLocale() == 'ar' ? 'مرحباً فيجن ميديكال، أرغب في الاستفسار عن خدمات صيانة الأجهزة الطبية.' : 'Hello Vision Medical, I would like to inquire about medical maintenance services.') }}" 
                       target="_blank"
                       class="w-full sm:w-auto bg-white/5 hover:bg-white/10 border border-white/10 text-white font-bold text-sm px-8 py-4 rounded-xl transition-all-300 flex items-center justify-center gap-2">
                        <i class="fa-brands fa-whatsapp text-lg text-emerald-400"></i>
                        <span>{{ __('messages.maintenance_whatsapp') }}</span>
                    </a>
                </div>
            </div>

            <!-- Right: Glowing Gear Graphics (5 cols on lg) -->
            <div class="lg:col-span-5 flex justify-center items-center relative select-none animate-float">
                <!-- Outer Radial Glow -->
                <div class="absolute w-72 h-72 rounded-full bg-emerald-500/20 filter blur-2xl"></div>
                
                <!-- SVG Vector Gear -->
                <div class="relative w-80 h-80 flex items-center justify-center">
                    <!-- Rotating Gear -->
                    <svg class="w-full h-full text-slate-700/40 animate-spin-slow" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M 84.00 50.00 A 34 34 0 0 1 82.84 58.80 L 90.65 66.84 A 44 44 0 0 1 84.91 76.79 L 74.04 74.04 A 34 34 0 0 1 67.00 79.44 L 66.84 90.65 A 44 44 0 0 1 55.74 93.62 L 50.00 84.00 A 34 34 0 0 1 41.20 82.84 L 33.16 90.65 A 44 44 0 0 1 23.21 84.91 L 25.96 74.04 A 34 34 0 0 1 20.56 67.00 L 9.35 66.84 A 44 44 0 0 1 6.38 55.74 L 16.00 50.00 A 34 34 0 0 1 17.16 41.20 L 9.35 33.16 A 44 44 0 0 1 15.09 23.21 L 25.96 25.96 A 34 34 0 0 1 33.00 20.56 L 33.16 9.35 A 44 44 0 0 1 44.26 6.38 L 50.00 16.00 A 34 34 0 0 1 58.80 17.16 L 66.84 9.35 A 44 44 0 0 1 76.79 15.09 L 74.04 25.96 A 34 34 0 0 1 79.44 33.00 L 90.65 33.16 A 44 44 0 0 1 93.62 44.26 L 84.00 50.00 Z" 
                              stroke="url(#gearLightGrad)" stroke-width="4" stroke-linejoin="round" fill="none" />
                        <defs>
                            <linearGradient id="gearLightGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" stop-color="#10b981" stop-opacity="0.8" />
                                <stop offset="100%" stop-color="#059669" stop-opacity="0.1" />
                            </linearGradient>
                        </defs>
                    </svg>
                    
                    <!-- Floating Calibration Status Card inside Hero -->
                    <div class="absolute bg-slate-900/95 backdrop-blur-md border border-slate-800 rounded-2xl p-5 shadow-2xl flex items-center gap-4 text-start scale-95 sm:scale-100 hover:border-emerald-500/50 transition-colors duration-300">
                        <div class="w-12 h-12 rounded-xl bg-emerald-500/10 text-emerald-400 flex items-center justify-center text-xl shrink-0">
                            <i class="fa-solid fa-gauge-high"></i>
                        </div>
                        <div>
                            <span class="text-[10px] text-slate-500 font-bold uppercase tracking-wider">{{ app()->getLocale() == 'ar' ? 'معايرة الأجهزة الطبية' : 'DEVICE CALIBRATION' }}</span>
                            <div class="text-sm font-black text-white mt-0.5 flex items-center gap-2">
                                <span>ISO 17025 Certified</span>
                                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-ping"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Core Services Grid -->
    <div class="mb-24">
        <div class="text-center max-w-3xl mx-auto space-y-4 mb-16">
            <h2 class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight">
                {{ app()->getLocale() == 'ar' ? 'خدماتنا الفنية المتخصصة' : 'Our Specialized Technical Services' }}
            </h2>
            <p class="text-slate-500 text-sm sm:text-base leading-relaxed">
                {{ app()->getLocale() == 'ar' 
                    ? 'نضمن لك استمرارية عمل منشأتك الطبية بأعلى كفاءة وأمان من خلال فريقنا الهندسي المؤهل.' 
                    : 'We guarantee continuous and highly efficient operation of your medical facility through our qualified engineering team.' }}
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Preventive Maintenance -->
            <div class="bg-white border border-slate-200/80 rounded-3xl p-8 shadow-xs hover:shadow-xl hover:border-emerald-200/80 hover:-translate-y-1.5 transition-all-300 flex flex-col justify-between items-start space-y-6 group">
                <div class="w-14 h-14 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center text-2xl group-hover:bg-emerald-500 group-hover:text-white transition-all-300 shadow-md shadow-emerald-100/30">
                    <i class="fa-solid fa-clock-rotate-left"></i>
                </div>
                <div class="space-y-2">
                    <h3 class="font-bold text-slate-900 text-lg leading-snug">
                        {{ app()->getLocale() == 'ar' ? 'الصيانة الوقائية' : 'Preventive Maintenance' }}
                    </h3>
                    <p class="text-slate-500 text-xs sm:text-sm leading-relaxed">
                        {{ app()->getLocale() == 'ar' 
                            ? 'معايرة دورية للأجهزة الطبية وفحص دوري لتجنب الأعطال المفاجئة وضمان دقة النتائج.' 
                            : 'Periodic calibration of medical equipment and routine checkups to avoid sudden failures.' }}
                    </p>
                </div>
            </div>

            <!-- Emergency Repair -->
            <div class="bg-white border border-slate-200/80 rounded-3xl p-8 shadow-xs hover:shadow-xl hover:border-emerald-200/80 hover:-translate-y-1.5 transition-all-300 flex flex-col justify-between items-start space-y-6 group">
                <div class="w-14 h-14 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center text-2xl group-hover:bg-emerald-500 group-hover:text-white transition-all-300 shadow-md shadow-emerald-100/30">
                    <i class="fa-solid fa-bolt"></i>
                </div>
                <div class="space-y-2">
                    <h3 class="font-bold text-slate-900 text-lg leading-snug">
                        {{ app()->getLocale() == 'ar' ? 'إصلاح الأعطال الطارئة' : 'Emergency Repairs' }}
                    </h3>
                    <p class="text-slate-500 text-xs sm:text-sm leading-relaxed">
                        {{ app()->getLocale() == 'ar' 
                            ? 'سرعة الاستجابة والتدخل الفوري لإصلاح الأجهزة الطبية المعطلة لتقليل وقت التوقف.' 
                            : 'Quick response and immediate on-site intervention to repair faulty medical units.' }}
                    </p>
                </div>
            </div>

            <!-- Original Spare Parts -->
            <div class="bg-white border border-slate-200/80 rounded-3xl p-8 shadow-xs hover:shadow-xl hover:border-emerald-200/80 hover:-translate-y-1.5 transition-all-300 flex flex-col justify-between items-start space-y-6 group">
                <div class="w-14 h-14 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center text-2xl group-hover:bg-emerald-500 group-hover:text-white transition-all-300 shadow-md shadow-emerald-100/30">
                    <i class="fa-solid fa-gears"></i>
                </div>
                <div class="space-y-2">
                    <h3 class="font-bold text-slate-900 text-lg leading-snug">
                        {{ app()->getLocale() == 'ar' ? 'قطع الغيار الأصلية' : 'Original Spare Parts' }}
                    </h3>
                    <p class="text-slate-500 text-xs sm:text-sm leading-relaxed">
                        {{ app()->getLocale() == 'ar' 
                            ? 'توفير وتأمين قطع الغيار والملحقات الأصلية بضمان شامل ومطابقة تامة.' 
                            : 'Supplying and installing genuine spare parts and accessories with comprehensive warranty.' }}
                    </p>
                </div>
            </div>

            <!-- Annual Maintenance Contracts -->
            <div class="bg-white border border-slate-200/80 rounded-3xl p-8 shadow-xs hover:shadow-xl hover:border-emerald-200/80 hover:-translate-y-1.5 transition-all-300 flex flex-col justify-between items-start space-y-6 group">
                <div class="w-14 h-14 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center text-2xl group-hover:bg-emerald-500 group-hover:text-white transition-all-300 shadow-md shadow-emerald-100/30">
                    <i class="fa-solid fa-file-contract"></i>
                </div>
                <div class="space-y-2">
                    <h3 class="font-bold text-slate-900 text-lg leading-snug">
                        {{ app()->getLocale() == 'ar' ? 'عقود الصيانة السنوية' : 'Annual Contracts' }}
                    </h3>
                    <p class="text-slate-500 text-xs sm:text-sm leading-relaxed">
                        {{ app()->getLocale() == 'ar' 
                            ? 'عقود صيانة سنوية مرنة للمستشفيات، المراكز الطبية، وعيادات الأسنان والمختبرات.' 
                            : 'Flexible annual service agreements for clinics, dental centers, and labs.' }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Interactive Maintenance Process Timeline -->
    <div class="mb-24 py-16 bg-slate-900 rounded-[2rem] border border-slate-800 text-white relative overflow-hidden">
        <div class="absolute inset-0 opacity-5 bg-[radial-gradient(circle_at_top,_var(--tw-gradient-stops))] from-emerald-500 via-transparent to-transparent"></div>
        <div class="relative max-w-7xl mx-auto px-6 sm:px-12">
            
            <div class="text-center max-w-2xl mx-auto space-y-3 mb-16">
                <span class="text-emerald-400 font-bold text-xs uppercase tracking-widest block">{{ app()->getLocale() == 'ar' ? 'دورة الخدمة' : 'SERVICE WORKFLOW' }}</span>
                <h2 class="text-3xl font-black tracking-tight">
                    {{ app()->getLocale() == 'ar' ? 'كيف نقوم بصيانة جهازك الطبي؟' : 'How We Service Your Equipment' }}
                </h2>
                <p class="text-slate-400 text-xs sm:text-sm">
                    {{ app()->getLocale() == 'ar' 
                        ? 'خطوات عمل دقيقة وموثقة نتبعها لضمان معايرة وإصلاح جهازك بأمان.'
                        : 'Structured steps we follow to ensure proper diagnostic, repair, and calibration.' }}
                </p>
            </div>

            <!-- Steps Grid -->
            <div class="grid grid-cols-1 md:grid-cols-5 gap-8 relative">
                <!-- Step 1 -->
                <div class="space-y-4 text-center md:text-start relative">
                    <div class="w-12 h-12 rounded-xl bg-emerald-500 text-slate-950 flex items-center justify-center font-black text-lg shadow-lg shadow-emerald-500/20">1</div>
                    <h3 class="font-bold text-lg text-white">{{ app()->getLocale() == 'ar' ? 'تقديم الطلب' : 'Request Submit' }}</h3>
                    <p class="text-slate-400 text-xs leading-relaxed">
                        {{ app()->getLocale() == 'ar' ? 'تعبئة النموذج بالاسم ونوع الجهاز ووصف المشكلة بالتفصيل.' : 'Submit your request details, device model, and defect description.' }}
                    </p>
                </div>

                <!-- Step 2 -->
                <div class="space-y-4 text-center md:text-start relative">
                    <div class="w-12 h-12 rounded-xl bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 flex items-center justify-center font-black text-lg">2</div>
                    <h3 class="font-bold text-lg text-white">{{ app()->getLocale() == 'ar' ? 'التشخيص والفحص' : 'Diagnostic Check' }}</h3>
                    <p class="text-slate-400 text-xs leading-relaxed">
                        {{ app()->getLocale() == 'ar' ? 'يقوم مهندسونا بفحص الجهاز وتحديد العطل بدقة متناهية.' : 'Our engineers inspect the unit to locate and diagnose faults.' }}
                    </p>
                </div>

                <!-- Step 3 -->
                <div class="space-y-4 text-center md:text-start relative">
                    <div class="w-12 h-12 rounded-xl bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 flex items-center justify-center font-black text-lg">3</div>
                    <h3 class="font-bold text-lg text-white">{{ app()->getLocale() == 'ar' ? 'إصلاح العطل' : 'Technical Repair' }}</h3>
                    <p class="text-slate-400 text-xs leading-relaxed">
                        {{ app()->getLocale() == 'ar' ? 'استبدال قطع الغيار التالفة بقطع غيار أصلية بضمان شامل.' : 'Replacing faulty elements with original certified spare parts.' }}
                    </p>
                </div>

                <!-- Step 4 -->
                <div class="space-y-4 text-center md:text-start relative">
                    <div class="w-12 h-12 rounded-xl bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 flex items-center justify-center font-black text-lg">4</div>
                    <h3 class="font-bold text-lg text-white">{{ app()->getLocale() == 'ar' ? 'المعايرة والاختبار' : 'Precision Calibration' }}</h3>
                    <p class="text-slate-400 text-xs leading-relaxed">
                        {{ app()->getLocale() == 'ar' ? 'معايرة الجهاز بأحدث أدوات القياس لضمان دقة القراءات الطبية.' : 'Calibrating indicators to match precision medical standards.' }}
                    </p>
                </div>

                <!-- Step 5 -->
                <div class="space-y-4 text-center md:text-start relative">
                    <div class="w-12 h-12 rounded-xl bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 flex items-center justify-center font-black text-lg">5</div>
                    <h3 class="font-bold text-lg text-white">{{ app()->getLocale() == 'ar' ? 'التسليم والضمان' : 'Safe Handover' }}</h3>
                    <p class="text-slate-400 text-xs leading-relaxed">
                        {{ app()->getLocale() == 'ar' ? 'تسليم الجهاز مع تقرير المعايرة والفاتورة بضمان كامل.' : 'Delivering back with test calibration certificate & warranty.' }}
                    </p>
                </div>
            </div>

        </div>
    </div>

    <!-- Request Maintenance Form Section -->
    <div id="request-maintenance" class="bg-white border border-slate-200/80 rounded-[2rem] overflow-hidden shadow-sm grid grid-cols-1 lg:grid-cols-5 mb-24 scroll-mt-24">
        <!-- Info Column -->
        <div class="lg:col-span-2 bg-slate-950 p-8 sm:p-12 text-white flex flex-col justify-between space-y-12 relative">
            <div class="absolute inset-0 opacity-5 bg-[radial-gradient(ellipse_at_center,_var(--tw-gradient-stops))] from-emerald-500 via-transparent to-transparent pointer-events-none"></div>
            
            <div class="space-y-4 relative">
                <h3 class="text-2xl sm:text-3xl font-black tracking-tight">{{ __('messages.maintenance_request') }}</h3>
                <p class="text-slate-400 text-sm leading-relaxed">
                    {{ app()->getLocale() == 'ar' 
                        ? 'فريق المهندسين لدينا جاهز لتلقي طلبك فوراً وفحص جهازك بأحدث معدات المعايرة المعتمدة.' 
                        : 'Our engineering team is ready to process your request and calibrate your devices with certified tools.' }}
                </p>
            </div>

            <!-- Direct Contact List -->
            <div class="space-y-6 relative">
                <div class="flex items-center gap-4">
                    <div class="w-11 h-11 bg-white/5 rounded-xl flex items-center justify-center text-lg text-emerald-400 border border-white/5">
                        <i class="fa-solid fa-phone"></i>
                    </div>
                    <div>
                        <span class="text-slate-500 text-[10px] block font-bold uppercase tracking-wider">{{ __('messages.maintenance_phone') }}</span>
                        <a href="tel:{{ $mPhone }}" class="text-base sm:text-lg font-black hover:text-emerald-400 transition-all-300" dir="ltr">{{ $mPhone }}</a>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <div class="w-11 h-11 bg-white/5 rounded-xl flex items-center justify-center text-lg text-emerald-400 border border-white/5">
                        <i class="fa-brands fa-whatsapp"></i>
                    </div>
                    <div>
                        <span class="text-slate-500 text-[10px] block font-bold uppercase tracking-wider">{{ __('messages.maintenance_whatsapp') }}</span>
                        <a href="https://wa.me/{{ $mWhatsapp }}" class="text-base sm:text-lg font-black hover:text-emerald-400 transition-all-300" dir="ltr">+{{ $mWhatsapp }}</a>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <div class="w-11 h-11 bg-white/5 rounded-xl flex items-center justify-center text-lg text-emerald-400 border border-white/5">
                        <i class="fa-solid fa-business-time"></i>
                    </div>
                    <div>
                        <span class="text-slate-500 text-[10px] block font-bold uppercase tracking-wider">{{ app()->getLocale() == 'ar' ? 'ساعات العمل' : 'Working Hours' }}</span>
                        <span class="text-sm font-bold">{{ app()->getLocale() == 'ar' ? 'السبت - الخميس: 9:00 ص - 6:00 م' : 'Sat - Thu: 9:00 AM - 6:00 PM' }}</span>
                    </div>
                </div>
            </div>

            <!-- Accent Brand Quote -->
            <div class="text-xs text-slate-500 pt-6 border-t border-slate-900 relative">
                {{ app()->getLocale() == 'ar' ? 'فيجن ميديكال | شريككم الموثوق في الصيانة الطبية المعتمدة.' : 'Vision Medical | Your trusted partner in certified medical maintenance.' }}
            </div>
        </div>

        <!-- Form Column -->
        <div class="lg:col-span-3 p-8 sm:p-12 bg-slate-50/20">
            <form id="maintenance-form" action="{{ route('contact.submit') }}" method="POST" class="space-y-6">
                @csrf
                <!-- Set subject default hidden -->
                <input type="hidden" name="subject" value="[طلب صيانة أجهزة طبية]">
                <input type="hidden" name="message" id="hidden-message-input">
                {{-- Hidden email placeholder so the controller accepts the form --}}
                <input type="hidden" name="email" value="maintenance@visionmedical.local">

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <!-- Client Name -->
                    <div class="space-y-1.5">
                        <label for="name" class="block text-xs font-bold text-slate-600">{{ __('messages.name_label') }} *</label>
                        <input type="text" name="name" id="name" required value="{{ old('name') }}"
                               placeholder="{{ __('messages.name_placeholder') }}" 
                               class="w-full bg-white border border-slate-200 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500/20 rounded-xl px-4 py-3.5 text-slate-900 text-sm focus:outline-none transition-all-300 shadow-sm">
                        @error('name')
                            <span class="text-rose-500 text-[10px] font-bold block mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Phone Number (replaces email) -->
                    <div class="space-y-1.5">
                        <label for="phone_input" class="block text-xs font-bold text-slate-600">{{ __('messages.phone_label') }} *</label>
                        <input type="tel" id="phone_input" required
                               placeholder="{{ __('messages.phone_placeholder') }}" 
                               class="w-full bg-white border border-slate-200 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500/20 rounded-xl px-4 py-3.5 text-slate-900 text-sm focus:outline-none transition-all-300 shadow-sm" dir="ltr">
                    </div>

                    <!-- Governorate -->
                    <div class="space-y-1.5">
                        <label for="governorate_input" class="block text-xs font-bold text-slate-600">{{ __('messages.governorate_label') }} *</label>
                        <select id="governorate_input" required
                                class="w-full bg-white border border-slate-200 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500/20 rounded-xl px-4 py-3.5 text-slate-900 text-sm focus:outline-none transition-all-300 shadow-sm appearance-none cursor-pointer">
                            <option value="" disabled selected>{{ __('messages.governorate_placeholder') }}</option>
                            @if(app()->getLocale() == 'ar')
                                <option value="القاهرة">القاهرة</option>
                                <option value="الجيزة">الجيزة</option>
                                <option value="الإسكندرية">الإسكندرية</option>
                                <option value="الدقهلية">الدقهلية</option>
                                <option value="البحر الأحمر">البحر الأحمر</option>
                                <option value="البحيرة">البحيرة</option>
                                <option value="الفيوم">الفيوم</option>
                                <option value="الغربية">الغربية</option>
                                <option value="الإسماعيلية">الإسماعيلية</option>
                                <option value="المنوفية">المنوفية</option>
                                <option value="المنيا">المنيا</option>
                                <option value="القليوبية">القليوبية</option>
                                <option value="الوادي الجديد">الوادي الجديد</option>
                                <option value="السويس">السويس</option>
                                <option value="اسوان">اسوان</option>
                                <option value="اسيوط">اسيوط</option>
                                <option value="بني سويف">بني سويف</option>
                                <option value="بورسعيد">بورسعيد</option>
                                <option value="دمياط">دمياط</option>
                                <option value="جنوب سيناء">جنوب سيناء</option>
                                <option value="شمال سيناء">شمال سيناء</option>
                                <option value="سوهاج">سوهاج</option>
                                <option value="قنا">قنا</option>
                                <option value="كفر الشيخ">كفر الشيخ</option>
                                <option value="مطروح">مطروح</option>
                                <option value="الأقصر">الأقصر</option>
                                <option value="الشرقية">الشرقية</option>
                            @else
                                <option value="Cairo">Cairo</option>
                                <option value="Giza">Giza</option>
                                <option value="Alexandria">Alexandria</option>
                                <option value="Dakahlia">Dakahlia</option>
                                <option value="Red Sea">Red Sea</option>
                                <option value="Beheira">Beheira</option>
                                <option value="Fayoum">Fayoum</option>
                                <option value="Gharbia">Gharbia</option>
                                <option value="Ismailia">Ismailia</option>
                                <option value="Monufia">Monufia</option>
                                <option value="Minya">Minya</option>
                                <option value="Qalyubia">Qalyubia</option>
                                <option value="New Valley">New Valley</option>
                                <option value="Suez">Suez</option>
                                <option value="Aswan">Aswan</option>
                                <option value="Asyut">Asyut</option>
                                <option value="Beni Suef">Beni Suef</option>
                                <option value="Port Said">Port Said</option>
                                <option value="Damietta">Damietta</option>
                                <option value="South Sinai">South Sinai</option>
                                <option value="North Sinai">North Sinai</option>
                                <option value="Sohag">Sohag</option>
                                <option value="Qena">Qena</option>
                                <option value="Kafr el-Sheikh">Kafr el-Sheikh</option>
                                <option value="Matruh">Matruh</option>
                                <option value="Luxor">Luxor</option>
                                <option value="Sharqia">Sharqia</option>
                            @endif
                        </select>
                    </div>

                    <!-- Device Name -->
                    <div class="space-y-1.5">
                        <label for="device_name" class="block text-xs font-bold text-slate-600">{{ __('messages.device_name') }} *</label>
                        <input type="text" id="device_name" required
                               placeholder="{{ __('messages.device_name_placeholder') }}" 
                               class="w-full bg-white border border-slate-200 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500/20 rounded-xl px-4 py-3.5 text-slate-900 text-sm focus:outline-none transition-all-300 shadow-sm">
                    </div>
                </div>

                <!-- Place Name -->
                <div class="space-y-1.5">
                    <label for="place_name_input" class="block text-xs font-bold text-slate-600">{{ __('messages.place_name_label') }} *</label>
                    <input type="text" id="place_name_input" required
                           placeholder="{{ __('messages.place_name_placeholder') }}" 
                           class="w-full bg-white border border-slate-200 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500/20 rounded-xl px-4 py-3.5 text-slate-900 text-sm focus:outline-none transition-all-300 shadow-sm">
                </div>

                <!-- Address Description -->
                <div class="space-y-1.5">
                    <label for="address_input" class="block text-xs font-bold text-slate-600">{{ __('messages.address_label') }} *</label>
                    <input type="text" id="address_input" required
                           placeholder="{{ __('messages.address_placeholder') }}" 
                           class="w-full bg-white border border-slate-200 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500/20 rounded-xl px-4 py-3.5 text-slate-900 text-sm focus:outline-none transition-all-300 shadow-sm">
                </div>

                <!-- Device Model -->
                <div class="space-y-1.5">
                    <label for="device_model" class="block text-xs font-bold text-slate-600">{{ __('messages.device_model') }}</label>
                    <input type="text" id="device_model"
                           placeholder="{{ __('messages.device_model_placeholder') }}" 
                           class="w-full bg-white border border-slate-200 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500/20 rounded-xl px-4 py-3.5 text-slate-900 text-sm focus:outline-none transition-all-300 shadow-sm">
                </div>

                <!-- Problem Description -->
                <div class="space-y-1.5">
                    <label for="problem_desc_input" class="block text-xs font-bold text-slate-600">{{ __('messages.problem_desc') }} *</label>
                    <textarea id="problem_desc_input" rows="4" required
                              placeholder="{{ __('messages.problem_desc_placeholder') }}" 
                              class="w-full bg-white border border-slate-200 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500/20 rounded-xl px-4 py-3 text-slate-900 text-sm focus:outline-none transition-all-300 shadow-sm"></textarea>
                    <span class="text-slate-400 text-[10px] block leading-relaxed">{{ __('messages.review_moderation_note') }}</span>
                </div>

                <button type="submit" class="w-full bg-emerald-500 hover:bg-emerald-600 text-slate-950 font-black px-8 py-4 rounded-xl shadow-lg shadow-emerald-500/10 transition-all-300 text-sm">
                    {{ __('messages.request_maintenance_btn') }}
                </button>
            </form>
        </div>
    </div>

    <!-- Featured Store Preview Section -->
    <div class="border-t border-slate-200/80 pt-16 mb-16">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6 mb-12">
            <div class="space-y-2 max-w-2xl">
                <h2 class="text-3xl font-black text-slate-900 tracking-tight">
                    {{ __('messages.store_preview_title') }}
                </h2>
                <p class="text-slate-500 text-sm leading-relaxed">
                    {{ __('messages.store_preview_subtitle') }}
                </p>
            </div>
            
            <a href="{{ route('store') }}" class="inline-flex items-center gap-2 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 font-bold text-sm px-6 py-3.5 rounded-xl transition-all-300 border border-emerald-100/50">
                <span>{{ __('messages.browse_store') }}</span>
                <i class="fa-solid {{ app()->getLocale() == 'ar' ? 'fa-arrow-left' : 'fa-arrow-right' }}"></i>
            </a>
        </div>

        <!-- Products Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($featuredProducts as $product)
                <div class="group bg-white border border-slate-200/80 rounded-3xl overflow-hidden shadow-xs hover:shadow-xl hover:border-emerald-200/80 transition-all-300 flex flex-col justify-between">
                    
                    <!-- Product Image -->
                    <div class="relative bg-slate-50/50 aspect-video overflow-hidden">
                        @if($product->image)
                            @if($product->isVideo())
                                <video src="{{ $product->image }}" class="w-full h-full object-cover" autoplay loop muted playsinline></video>
                            @else
                                <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-all-300">
                            @endif
                        @else
                            <div class="w-full h-full flex flex-col items-center justify-center text-slate-300">
                                <i class="fa-solid fa-briefcase-medical text-4xl"></i>
                            </div>
                        @endif
                        
                        <span class="absolute top-4 {{ app()->getLocale() == 'ar' ? 'right-4' : 'left-4' }} bg-white/95 backdrop-blur-xs border border-slate-100 text-slate-700 text-xxs font-bold px-3 py-1.5 rounded-xl shadow-xs">
                            {{ $product->brand->name }}
                        </span>
                    </div>

                    <!-- Product Content -->
                    <div class="p-6 flex-grow flex flex-col justify-between">
                        <div class="space-y-2">
                            <span class="text-xs font-bold text-emerald-600 block">
                                {{ $product->category->name }}
                            </span>
                            
                            <h3 class="font-bold text-slate-900 text-base leading-snug group-hover:text-emerald-600 transition-all-300">
                                <a href="{{ route('product.show', $product->slug) }}">{{ $product->name }}</a>
                            </h3>
                            
                            <p class="text-slate-500 text-xs line-clamp-2">
                                {{ $product->description }}
                            </p>
                        </div>

                        <!-- Price & Stars -->
                        <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between">
                            <div>
                                <div class="text-emerald-600 font-extrabold text-lg">
                                    {{ number_format($product->price, 2) }} <span class="text-xs font-semibold text-slate-500">{{ __('messages.currency') }}</span>
                                </div>
                            </div>

                            <div class="flex items-center gap-1.5">
                                <div class="flex items-center gap-0.5 text-amber-400">
                                    @php $avgRating = $product->averageRating(); @endphp
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fa-{{ $i <= $avgRating ? 'solid' : 'regular' }} fa-star text-xs"></i>
                                    @endfor
                                </div>
                                <span class="text-slate-400 text-xxs font-semibold">({{ $product->approvedReviews->count() }})</span>
                            </div>
                        </div>

                        <!-- CTA -->
                        <div class="mt-6">
                            <a href="{{ route('product.show', $product->slug) }}" class="w-full flex items-center justify-center gap-2 bg-slate-50 hover:bg-emerald-500 hover:text-slate-950 border border-slate-200/60 hover:border-emerald-500 text-slate-700 font-bold text-xs py-3.5 rounded-xl transition-all-300">
                                <span>{{ __('messages.view_details') }}</span>
                                <i class="fa-solid {{ app()->getLocale() == 'ar' ? 'fa-arrow-left' : 'fa-arrow-right' }} text-xxs"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.getElementById('maintenance-form').addEventListener('submit', function(e) {
            const phone      = document.getElementById('phone_input').value;
            const gov        = document.getElementById('governorate_input').value;
            const placeName  = document.getElementById('place_name_input').value;
            const address    = document.getElementById('address_input').value;
            const deviceName = document.getElementById('device_name').value;
            const deviceModel = document.getElementById('device_model').value || '{{ app()->getLocale() == 'ar' ? 'غير محدد' : 'Not Specified' }}';
            const problemDesc = document.getElementById('problem_desc_input').value;
            
            const isAr = {{ app()->getLocale() == 'ar' ? 'true' : 'false' }};

            const message = (isAr
                ? `📞 رقم الهاتف: ${phone}\n` +
                  `📍 المحافظة: ${gov}\n` +
                  `🏥 اسم المكان: ${placeName}\n` +
                  `🏠 العنوان: ${address}\n` +
                  `🔬 اسم الجهاز الطبي: ${deviceName}\n` +
                  `📋 الموديل: ${deviceModel}\n` +
                  `❗ وصف المشكلة:\n${problemDesc}`
                : `📞 Phone: ${phone}\n` +
                  `📍 Governorate: ${gov}\n` +
                  `🏥 Place Name: ${placeName}\n` +
                  `🏠 Address: ${address}\n` +
                  `🔬 Medical Device: ${deviceName}\n` +
                  `📋 Model: ${deviceModel}\n` +
                  `❗ Problem Description:\n${problemDesc}`);
            
            document.getElementById('hidden-message-input').value = message;
        });
    </script>
@endsection
