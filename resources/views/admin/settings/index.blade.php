@extends('layouts.admin')

@section('page_title', 'إعدادات المتجر وبيانات الاتصال | Store Settings')

@section('content')
    <div class="mb-6">
        <div class="text-sm font-medium text-slate-500">
            هنا يمكنك تعديل رقم الواتساب وعناوين التواصل باللغتين العربية والإنجليزية.
        </div>
    </div>

    <!-- Form Container -->
    <div class="bg-white border border-slate-100 rounded-3xl p-6 sm:p-10 shadow-xs max-w-4xl">
        <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-8">
            @csrf

            <!-- Section 1: Store info -->
            <div class="space-y-5">
                <h3 class="font-bold text-slate-900 text-base border-b border-slate-50 pb-3 flex items-center gap-2">
                    <i class="fa-solid fa-circle-info text-emerald-600"></i>
                    <span>بيانات المتجر الأساسية / Core Store Details</span>
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <!-- Store name Arabic -->
                    <div class="space-y-1.5">
                        <label for="store_name_ar" class="block text-xs font-bold text-slate-600">اسم المتجر بالعربية *</label>
                        <input type="text" name="store_name_ar" id="store_name_ar" required value="{{ old('store_name_ar', $settings['store_name_ar']) }}"
                               placeholder="فيجن ميديكال..." 
                               class="w-full bg-slate-50 border border-slate-100 focus:border-emerald-500 focus:bg-white rounded-xl px-4 py-3.5 text-slate-900 text-sm focus:outline-hidden transition-all-300">
                        @error('store_name_ar')
                            <span class="text-rose-500 text-xxs font-semibold block mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Store name English -->
                    <div class="space-y-1.5" dir="ltr">
                        <label for="store_name_en" class="block text-xs font-bold text-slate-600 text-right">Store Name in English *</label>
                        <input type="text" name="store_name_en" id="store_name_en" required value="{{ old('store_name_en', $settings['store_name_en']) }}"
                               placeholder="Vision Medical..." 
                               class="w-full bg-slate-50 border border-slate-100 focus:border-emerald-500 focus:bg-white rounded-xl px-4 py-3.5 text-slate-900 text-sm focus:outline-hidden transition-all-300 text-left">
                        @error('store_name_en')
                            <span class="text-rose-500 text-xxs font-semibold block mt-1 text-right">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Store email -->
                    <div class="space-y-1.5">
                        <label for="store_email" class="block text-xs font-bold text-slate-600">البريد الإلكتروني للمتجر *</label>
                        <input type="email" name="store_email" id="store_email" required value="{{ old('store_email', $settings['store_email']) }}"
                               placeholder="info@yourstore.com" 
                               class="w-full bg-slate-50 border border-slate-100 focus:border-emerald-500 focus:bg-white rounded-xl px-4 py-3.5 text-slate-900 text-sm focus:outline-hidden transition-all-300">
                        @error('store_email')
                            <span class="text-rose-500 text-xxs font-semibold block mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Store phone -->
                    <div class="space-y-1.5">
                        <label for="store_phone" class="block text-xs font-bold text-slate-600">رقم الهاتف للاتصال المباشر *</label>
                        <input type="text" name="store_phone" id="store_phone" required value="{{ old('store_phone', $settings['store_phone']) }}"
                               placeholder="+966 50 123 4567" 
                               class="w-full bg-slate-50 border border-slate-100 focus:border-emerald-500 focus:bg-white rounded-xl px-4 py-3.5 text-slate-900 text-sm focus:outline-hidden transition-all-300">
                        @error('store_phone')
                            <span class="text-rose-500 text-xxs font-semibold block mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- WhatsApp -->
                    <div class="space-y-1.5">
                        <label for="whatsapp" class="block text-xs font-bold text-slate-600">رقم الواتساب للتواصل والطلب (أرقام فقط مع رمز الدولة) *</label>
                        <input type="text" name="whatsapp" id="whatsapp" required value="{{ old('whatsapp', $settings['whatsapp']) }}"
                               placeholder="966501234567" 
                               class="w-full bg-slate-50 border border-slate-100 focus:border-emerald-500 focus:bg-white rounded-xl px-4 py-3.5 text-slate-900 text-sm focus:outline-hidden transition-all-300">
                        <span class="text-slate-400 text-xxs block leading-relaxed">تنبيه: يجب إدخال الأرقام فقط بدون رمز + أو أصفار في البداية (مثل: 966501234567).</span>
                        @error('whatsapp')
                            <span class="text-rose-500 text-xxs font-semibold block mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Maintenance Phone -->
                    <div class="space-y-1.5">
                        <label for="maintenance_phone" class="block text-xs font-bold text-slate-600">رقم هاتف الصيانة المباشر *</label>
                        <input type="text" name="maintenance_phone" id="maintenance_phone" required value="{{ old('maintenance_phone', $settings['maintenance_phone']) }}"
                               placeholder="+966 50 765 4321" 
                               class="w-full bg-slate-50 border border-slate-100 focus:border-emerald-500 focus:bg-white rounded-xl px-4 py-3.5 text-slate-900 text-sm focus:outline-hidden transition-all-300">
                        @error('maintenance_phone')
                            <span class="text-rose-500 text-xxs font-semibold block mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Maintenance WhatsApp -->
                    <div class="space-y-1.5">
                        <label for="maintenance_whatsapp" class="block text-xs font-bold text-slate-600">رقم واتساب الصيانة المباشر (أرقام فقط مع رمز الدولة) *</label>
                        <input type="text" name="maintenance_whatsapp" id="maintenance_whatsapp" required value="{{ old('maintenance_whatsapp', $settings['maintenance_whatsapp']) }}"
                               placeholder="966507654321" 
                               class="w-full bg-slate-50 border border-slate-100 focus:border-emerald-500 focus:bg-white rounded-xl px-4 py-3.5 text-slate-900 text-sm focus:outline-hidden transition-all-300">
                        <span class="text-slate-400 text-xxs block leading-relaxed">تنبيه: أدخل الأرقام فقط بدون رمز + أو أصفار في البداية (مثل: 966507654321).</span>
                        @error('maintenance_whatsapp')
                            <span class="text-rose-500 text-xxs font-semibold block mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Company Map Link -->
                    <div class="space-y-1.5 sm:col-span-2">
                        <label for="company_map_link" class="block text-xs font-bold text-slate-600">رابط خريطة موقع الشركة (جوجل ماب) / Google Maps Link</label>
                        <input type="text" name="company_map_link" id="company_map_link" value="{{ old('company_map_link', $settings['company_map_link']) }}"
                               placeholder="https://www.google.com/maps/embed?pb=..." 
                               class="w-full bg-slate-50 border border-slate-100 focus:border-emerald-500 focus:bg-white rounded-xl px-4 py-3.5 text-slate-900 text-sm focus:outline-hidden transition-all-300 font-mono text-xs" dir="ltr">
                        <span class="text-slate-400 text-xxs block leading-relaxed">تنبيه: يمكنك وضع رابط التضمين (Embed URL) أو رابط مشاركة الموقع العادي من خرائط جوجل.</span>
                        @error('company_map_link')
                            <span class="text-rose-500 text-xxs font-semibold block mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Section 2: About Us content -->
            <div class="space-y-5">
                <h3 class="font-bold text-slate-900 text-base border-b border-slate-50 pb-3 flex items-center gap-2">
                    <i class="fa-solid fa-hospital-user text-emerald-600"></i>
                    <span>محتوى صفحة "من نحن" / About Us Page Contents</span>
                </h3>

                <div class="space-y-4">
                    <!-- About title Arabic -->
                    <div class="space-y-1.5">
                        <label for="about_us_title_ar" class="block text-xs font-bold text-slate-600">عنوان الصفحة بالعربية *</label>
                        <input type="text" name="about_us_title_ar" id="about_us_title_ar" required value="{{ old('about_us_title_ar', $settings['about_us_title_ar']) }}"
                               placeholder="من نحن..." 
                               class="w-full bg-slate-50 border border-slate-100 focus:border-emerald-500 focus:bg-white rounded-xl px-4 py-3.5 text-slate-900 text-sm focus:outline-hidden transition-all-300">
                        @error('about_us_title_ar')
                            <span class="text-rose-500 text-xxs font-semibold block mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- About title English -->
                    <div class="space-y-1.5" dir="ltr">
                        <label for="about_us_title_en" class="block text-xs font-bold text-slate-600 text-right">About Page Title in English *</label>
                        <input type="text" name="about_us_title_en" id="about_us_title_en" required value="{{ old('about_us_title_en', $settings['about_us_title_en']) }}"
                               placeholder="About Us..." 
                               class="w-full bg-slate-50 border border-slate-100 focus:border-emerald-500 focus:bg-white rounded-xl px-4 py-3.5 text-slate-900 text-sm focus:outline-hidden transition-all-300 text-left">
                        @error('about_us_title_en')
                            <span class="text-rose-500 text-xxs font-semibold block mt-1 text-right">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- About content Arabic -->
                    <div class="space-y-1.5">
                        <label for="about_us_content_ar" class="block text-xs font-bold text-slate-600">مضمون وقصة "من نحن" بالعربية *</label>
                        <textarea name="about_us_content_ar" id="about_us_content_ar" rows="4" required
                                  placeholder="اكتب تاريخ الشركة ورسالتها بالعربية..." 
                                  class="w-full bg-slate-50 border border-slate-100 focus:border-emerald-500 focus:bg-white rounded-xl px-4 py-3 text-slate-900 text-sm focus:outline-hidden transition-all-300">{{ old('about_us_content_ar', $settings['about_us_content_ar']) }}</textarea>
                        @error('about_us_content_ar')
                            <span class="text-rose-500 text-xxs font-semibold block mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- About content English -->
                    <div class="space-y-1.5" dir="ltr">
                        <label for="about_us_content_en" class="block text-xs font-bold text-slate-600 text-right">About Us Description in English *</label>
                        <textarea name="about_us_content_en" id="about_us_content_en" rows="4" required
                                  placeholder="Write company history in English..." 
                                  class="w-full bg-slate-50 border border-slate-100 focus:border-emerald-500 focus:bg-white rounded-xl px-4 py-3 text-slate-900 text-sm focus:outline-hidden transition-all-300 text-left">{{ old('about_us_content_en', $settings['about_us_content_en']) }}</textarea>
                        @error('about_us_content_en')
                            <span class="text-rose-500 text-xxs font-semibold block mt-1 text-right">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Section 3: Footer and details -->
            <div class="space-y-5">
                <h3 class="font-bold text-slate-900 text-base border-b border-slate-50 pb-3 flex items-center gap-2">
                    <i class="fa-solid fa-window-maximize text-emerald-600"></i>
                    <span>تذييل وجوانب الموقع / Footer Info</span>
                </h3>

                <!-- Footer text Arabic -->
                <div class="space-y-1.5">
                    <label for="footer_text_ar" class="block text-xs font-bold text-slate-600">نص حقوق الحفظ والتذييل بالعربية</label>
                    <input type="text" name="footer_text_ar" id="footer_text_ar" value="{{ old('footer_text_ar', $settings['footer_text_ar']) }}"
                           placeholder="جميع الحقوق محفوظة..." 
                           class="w-full bg-slate-50 border border-slate-100 focus:border-emerald-500 focus:bg-white rounded-xl px-4 py-3.5 text-slate-900 text-sm focus:outline-hidden transition-all-300">
                    @error('footer_text_ar')
                        <span class="text-rose-500 text-xxs font-semibold block mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Footer text English -->
                <div class="space-y-1.5" dir="ltr">
                    <label for="footer_text_en" class="block text-xs font-bold text-slate-600 text-right">Footer Copyright in English</label>
                    <input type="text" name="footer_text_en" id="footer_text_en" value="{{ old('footer_text_en', $settings['footer_text_en']) }}"
                           placeholder="All rights reserved..." 
                           class="w-full bg-slate-50 border border-slate-100 focus:border-emerald-500 focus:bg-white rounded-xl px-4 py-3.5 text-slate-900 text-sm focus:outline-hidden transition-all-300 text-left">
                    @error('footer_text_en')
                        <span class="text-rose-500 text-xxs font-semibold block mt-1 text-right">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full sm:w-auto bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-8 py-3.5 rounded-xl shadow-md shadow-emerald-600/10 transition-all-300 text-sm">
                حفظ وتحديث الإعدادات / Save Settings
            </button>
        </form>
    </div>
@endsection
