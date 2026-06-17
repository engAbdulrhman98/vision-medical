@extends('layouts.admin')

@section('page_title', 'إعدادات المتجر وبيانات الاتصال | Store Settings')

@section('styles')
<style>
    .tab-btn {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.65rem 1.1rem;
        border-radius: 0.75rem;
        font-size: 0.8125rem;
        font-weight: 700;
        color: #64748b;
        background: transparent;
        border: 2px solid transparent;
        transition: all 0.2s;
        white-space: nowrap;
        cursor: pointer;
    }
    .tab-btn:hover {
        color: #0f172a;
        background: #f1f5f9;
    }
    .tab-btn.active {
        color: #059669;
        background: #ecfdf5;
        border-color: #a7f3d0;
    }
    .tab-btn .tab-icon {
        width: 1.75rem;
        height: 1.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 0.5rem;
        background: #f1f5f9;
        font-size: 0.75rem;
        flex-shrink: 0;
    }
    .tab-btn.active .tab-icon {
        background: #d1fae5;
        color: #059669;
    }
    .tab-panel { display: none; }
    .tab-panel.active { display: block; }
</style>
@endsection

@section('content')

    <div class="mb-5 text-sm font-medium text-slate-500">
        هنا يمكنك تعديل رقم الواتساب وعناوين التواصل باللغتين العربية والإنجليزية.
    </div>

    {{-- ════════════════════════════════════════════════
         TAB NAV BAR
    ════════════════════════════════════════════════ --}}
    <div class="bg-white border border-slate-100 rounded-2xl p-2 flex items-center gap-1 overflow-x-auto shadow-sm mb-6" role="tablist">

        <button type="button" class="tab-btn active" data-tab="core" role="tab" aria-selected="true">
            <span class="tab-icon"><i class="fa-solid fa-circle-info"></i></span>
            <span>بيانات المتجر</span>
        </button>

        <button type="button" class="tab-btn" data-tab="about" role="tab">
            <span class="tab-icon"><i class="fa-solid fa-hospital-user"></i></span>
            <span>من نحن</span>
        </button>

        <button type="button" class="tab-btn" data-tab="footer" role="tab">
            <span class="tab-icon"><i class="fa-solid fa-window-maximize"></i></span>
            <span>التذييل</span>
        </button>

        <button type="button" class="tab-btn" data-tab="hours" role="tab">
            <span class="tab-icon"><i class="fa-solid fa-clock"></i></span>
            <span>أوقات العمل</span>
        </button>

    </div>

    {{-- ════════════════════════════════════════════════
         SINGLE FORM wrapping all tabs
    ════════════════════════════════════════════════ --}}
    <form action="{{ route('admin.settings.update') }}" method="POST">
        @csrf

        {{-- ─── TAB 1: Core Store Info ─── --}}
        <div id="tab-core" class="tab-panel active">
            <div class="bg-white border border-slate-100 rounded-3xl p-6 sm:p-10 shadow-sm space-y-6 max-w-4xl">

                <h3 class="font-bold text-slate-900 text-base border-b border-slate-100 pb-3 flex items-center gap-2">
                    <i class="fa-solid fa-circle-info text-emerald-600"></i>
                    <span>بيانات المتجر الأساسية / Core Store Details</span>
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

                    {{-- Store name AR --}}
                    <div class="space-y-1.5">
                        <label for="store_name_ar" class="block text-xs font-bold text-slate-600">اسم المتجر بالعربية *</label>
                        <input type="text" name="store_name_ar" id="store_name_ar" required value="{{ old('store_name_ar', $settings['store_name_ar']) }}"
                               placeholder="فيجن ميديكال..."
                               class="w-full bg-slate-50 border border-slate-100 focus:border-emerald-500 focus:bg-white rounded-xl px-4 py-3.5 text-slate-900 text-sm focus:outline-none transition-all">
                        @error('store_name_ar')<span class="text-rose-500 text-xs font-semibold block mt-1">{{ $message }}</span>@enderror
                    </div>

                    {{-- Store name EN --}}
                    <div class="space-y-1.5" dir="ltr">
                        <label for="store_name_en" class="block text-xs font-bold text-slate-600 text-right">Store Name in English *</label>
                        <input type="text" name="store_name_en" id="store_name_en" required value="{{ old('store_name_en', $settings['store_name_en']) }}"
                               placeholder="Vision Medical..."
                               class="w-full bg-slate-50 border border-slate-100 focus:border-emerald-500 focus:bg-white rounded-xl px-4 py-3.5 text-slate-900 text-sm focus:outline-none transition-all text-left">
                        @error('store_name_en')<span class="text-rose-500 text-xs font-semibold block mt-1 text-right">{{ $message }}</span>@enderror
                    </div>

                    {{-- Email --}}
                    <div class="space-y-1.5">
                        <label for="store_email" class="block text-xs font-bold text-slate-600">البريد الإلكتروني للمتجر *</label>
                        <input type="email" name="store_email" id="store_email" required value="{{ old('store_email', $settings['store_email']) }}"
                               placeholder="info@yourstore.com"
                               class="w-full bg-slate-50 border border-slate-100 focus:border-emerald-500 focus:bg-white rounded-xl px-4 py-3.5 text-slate-900 text-sm focus:outline-none transition-all">
                        @error('store_email')<span class="text-rose-500 text-xs font-semibold block mt-1">{{ $message }}</span>@enderror
                    </div>

                    {{-- Phone --}}
                    <div class="space-y-1.5">
                        <label for="store_phone" class="block text-xs font-bold text-slate-600">رقم الهاتف للاتصال المباشر *</label>
                        <input type="text" name="store_phone" id="store_phone" required value="{{ old('store_phone', $settings['store_phone']) }}"
                               placeholder="+20 100 123 4567"
                               class="w-full bg-slate-50 border border-slate-100 focus:border-emerald-500 focus:bg-white rounded-xl px-4 py-3.5 text-slate-900 text-sm focus:outline-none transition-all">
                        @error('store_phone')<span class="text-rose-500 text-xs font-semibold block mt-1">{{ $message }}</span>@enderror
                    </div>

                    {{-- WhatsApp --}}
                    <div class="space-y-1.5">
                        <label for="whatsapp" class="block text-xs font-bold text-slate-600">رقم الواتساب للتواصل (أرقام فقط مع رمز الدولة) *</label>
                        <input type="text" name="whatsapp" id="whatsapp" required value="{{ old('whatsapp', $settings['whatsapp']) }}"
                               placeholder="201001234567"
                               class="w-full bg-slate-50 border border-slate-100 focus:border-emerald-500 focus:bg-white rounded-xl px-4 py-3.5 text-slate-900 text-sm focus:outline-none transition-all">
                        <span class="text-slate-400 text-xs block">مثال: 201001234567 (بدون + أو أصفار)</span>
                        @error('whatsapp')<span class="text-rose-500 text-xs font-semibold block mt-1">{{ $message }}</span>@enderror
                    </div>

                    {{-- Maintenance Phone --}}
                    <div class="space-y-1.5">
                        <label for="maintenance_phone" class="block text-xs font-bold text-slate-600">رقم هاتف الصيانة المباشر *</label>
                        <input type="text" name="maintenance_phone" id="maintenance_phone" required value="{{ old('maintenance_phone', $settings['maintenance_phone']) }}"
                               placeholder="+20 111 765 4321"
                               class="w-full bg-slate-50 border border-slate-100 focus:border-emerald-500 focus:bg-white rounded-xl px-4 py-3.5 text-slate-900 text-sm focus:outline-none transition-all">
                        @error('maintenance_phone')<span class="text-rose-500 text-xs font-semibold block mt-1">{{ $message }}</span>@enderror
                    </div>

                    {{-- Maintenance WhatsApp --}}
                    <div class="space-y-1.5">
                        <label for="maintenance_whatsapp" class="block text-xs font-bold text-slate-600">واتساب الصيانة (أرقام فقط مع رمز الدولة) *</label>
                        <input type="text" name="maintenance_whatsapp" id="maintenance_whatsapp" required value="{{ old('maintenance_whatsapp', $settings['maintenance_whatsapp']) }}"
                               placeholder="201117654321"
                               class="w-full bg-slate-50 border border-slate-100 focus:border-emerald-500 focus:bg-white rounded-xl px-4 py-3.5 text-slate-900 text-sm focus:outline-none transition-all">
                        <span class="text-slate-400 text-xs block">مثال: 201117654321 (بدون + أو أصفار)</span>
                        @error('maintenance_whatsapp')<span class="text-rose-500 text-xs font-semibold block mt-1">{{ $message }}</span>@enderror
                    </div>

                    {{-- Google Map --}}
                    <div class="space-y-1.5 sm:col-span-2">
                        <label for="company_map_link" class="block text-xs font-bold text-slate-600">رابط خريطة موقع الشركة (Google Maps)</label>
                        <input type="text" name="company_map_link" id="company_map_link" value="{{ old('company_map_link', $settings['company_map_link']) }}"
                               placeholder="https://www.google.com/maps/embed?pb=..."
                               class="w-full bg-slate-50 border border-slate-100 focus:border-emerald-500 focus:bg-white rounded-xl px-4 py-3.5 text-slate-900 text-sm focus:outline-none transition-all font-mono text-xs" dir="ltr">
                        <span class="text-slate-400 text-xs block">ضع رابط التضمين (Embed URL) من خرائط جوجل.</span>
                        @error('company_map_link')<span class="text-rose-500 text-xs font-semibold block mt-1">{{ $message }}</span>@enderror
                    </div>
                </div>

                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-8 py-3.5 rounded-xl shadow-md shadow-emerald-600/10 transition-all text-sm">
                    <i class="fa-solid fa-floppy-disk me-2"></i> حفظ الإعدادات
                </button>
            </div>
        </div>

        {{-- ─── TAB 2: About Us ─── --}}
        <div id="tab-about" class="tab-panel">
            <div class="bg-white border border-slate-100 rounded-3xl p-6 sm:p-10 shadow-sm space-y-6 max-w-4xl">

                <h3 class="font-bold text-slate-900 text-base border-b border-slate-100 pb-3 flex items-center gap-2">
                    <i class="fa-solid fa-hospital-user text-emerald-600"></i>
                    <span>محتوى صفحة "من نحن" / About Us Page</span>
                </h3>

                <div class="space-y-4">
                    <div class="space-y-1.5">
                        <label for="about_us_title_ar" class="block text-xs font-bold text-slate-600">عنوان الصفحة بالعربية *</label>
                        <input type="text" name="about_us_title_ar" id="about_us_title_ar" required value="{{ old('about_us_title_ar', $settings['about_us_title_ar']) }}"
                               placeholder="من نحن..."
                               class="w-full bg-slate-50 border border-slate-100 focus:border-emerald-500 focus:bg-white rounded-xl px-4 py-3.5 text-slate-900 text-sm focus:outline-none transition-all">
                        @error('about_us_title_ar')<span class="text-rose-500 text-xs font-semibold block mt-1">{{ $message }}</span>@enderror
                    </div>

                    <div class="space-y-1.5" dir="ltr">
                        <label for="about_us_title_en" class="block text-xs font-bold text-slate-600 text-right">About Page Title in English *</label>
                        <input type="text" name="about_us_title_en" id="about_us_title_en" required value="{{ old('about_us_title_en', $settings['about_us_title_en']) }}"
                               placeholder="About Us..."
                               class="w-full bg-slate-50 border border-slate-100 focus:border-emerald-500 focus:bg-white rounded-xl px-4 py-3.5 text-slate-900 text-sm focus:outline-none transition-all text-left">
                        @error('about_us_title_en')<span class="text-rose-500 text-xs font-semibold block mt-1 text-right">{{ $message }}</span>@enderror
                    </div>

                    <div class="space-y-1.5">
                        <label for="about_us_content_ar" class="block text-xs font-bold text-slate-600">مضمون "من نحن" بالعربية *</label>
                        <textarea name="about_us_content_ar" id="about_us_content_ar" rows="5" required
                                  placeholder="اكتب تاريخ الشركة ورسالتها بالعربية..."
                                  class="w-full bg-slate-50 border border-slate-100 focus:border-emerald-500 focus:bg-white rounded-xl px-4 py-3 text-slate-900 text-sm focus:outline-none transition-all">{{ old('about_us_content_ar', $settings['about_us_content_ar']) }}</textarea>
                        @error('about_us_content_ar')<span class="text-rose-500 text-xs font-semibold block mt-1">{{ $message }}</span>@enderror
                    </div>

                    <div class="space-y-1.5" dir="ltr">
                        <label for="about_us_content_en" class="block text-xs font-bold text-slate-600 text-right">About Us Description in English *</label>
                        <textarea name="about_us_content_en" id="about_us_content_en" rows="5" required
                                  placeholder="Write company history in English..."
                                  class="w-full bg-slate-50 border border-slate-100 focus:border-emerald-500 focus:bg-white rounded-xl px-4 py-3 text-slate-900 text-sm focus:outline-none transition-all text-left">{{ old('about_us_content_en', $settings['about_us_content_en']) }}</textarea>
                        @error('about_us_content_en')<span class="text-rose-500 text-xs font-semibold block mt-1 text-right">{{ $message }}</span>@enderror
                    </div>
                </div>

                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-8 py-3.5 rounded-xl shadow-md shadow-emerald-600/10 transition-all text-sm">
                    <i class="fa-solid fa-floppy-disk me-2"></i> حفظ الإعدادات
                </button>
            </div>
        </div>

        {{-- ─── TAB 3: Footer ─── --}}
        <div id="tab-footer" class="tab-panel">
            <div class="bg-white border border-slate-100 rounded-3xl p-6 sm:p-10 shadow-sm space-y-6 max-w-4xl">

                <h3 class="font-bold text-slate-900 text-base border-b border-slate-100 pb-3 flex items-center gap-2">
                    <i class="fa-solid fa-window-maximize text-emerald-600"></i>
                    <span>تذييل وجوانب الموقع / Footer Info</span>
                </h3>

                <div class="space-y-4">
                    <div class="space-y-1.5">
                        <label for="footer_text_ar" class="block text-xs font-bold text-slate-600">نص حقوق التأليف بالعربية</label>
                        <input type="text" name="footer_text_ar" id="footer_text_ar" value="{{ old('footer_text_ar', $settings['footer_text_ar']) }}"
                               placeholder="جميع الحقوق محفوظة..."
                               class="w-full bg-slate-50 border border-slate-100 focus:border-emerald-500 focus:bg-white rounded-xl px-4 py-3.5 text-slate-900 text-sm focus:outline-none transition-all">
                        @error('footer_text_ar')<span class="text-rose-500 text-xs font-semibold block mt-1">{{ $message }}</span>@enderror
                    </div>

                    <div class="space-y-1.5" dir="ltr">
                        <label for="footer_text_en" class="block text-xs font-bold text-slate-600 text-right">Footer Copyright in English</label>
                        <input type="text" name="footer_text_en" id="footer_text_en" value="{{ old('footer_text_en', $settings['footer_text_en']) }}"
                               placeholder="All rights reserved..."
                               class="w-full bg-slate-50 border border-slate-100 focus:border-emerald-500 focus:bg-white rounded-xl px-4 py-3.5 text-slate-900 text-sm focus:outline-none transition-all text-left">
                        @error('footer_text_en')<span class="text-rose-500 text-xs font-semibold block mt-1 text-right">{{ $message }}</span>@enderror
                    </div>
                </div>

                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-8 py-3.5 rounded-xl shadow-md shadow-emerald-600/10 transition-all text-sm">
                    <i class="fa-solid fa-floppy-disk me-2"></i> حفظ الإعدادات
                </button>
            </div>
        </div>

        {{-- ─── TAB 4: Working Hours ─── --}}
        <div id="tab-hours" class="tab-panel">
            <div class="bg-white border border-slate-100 rounded-3xl p-6 sm:p-10 shadow-sm space-y-6">

                <h3 class="font-bold text-slate-900 text-base border-b border-slate-100 pb-3 flex items-center gap-2">
                    <i class="fa-solid fa-clock text-emerald-600"></i>
                    <span>أيام ومواعيد العمل / Working Days &amp; Hours</span>
                </h3>

                <div class="grid grid-cols-1 min-[400px]:grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3">
                    @php
                        $days = [
                            'saturday'  => ['ar' => 'السبت',    'en' => 'Sat'],
                            'sunday'    => ['ar' => 'الأحد',    'en' => 'Sun'],
                            'monday'    => ['ar' => 'الاثنين',  'en' => 'Mon'],
                            'tuesday'   => ['ar' => 'الثلاثاء', 'en' => 'Tue'],
                            'wednesday' => ['ar' => 'الأربعاء', 'en' => 'Wed'],
                            'thursday'  => ['ar' => 'الخميس',   'en' => 'Thu'],
                            'friday'    => ['ar' => 'الجمعة',   'en' => 'Fri'],
                        ];
                    @endphp

                    @foreach($days as $dayKey => $dayNames)
                        @php
                            $rawVal    = old("day_{$dayKey}_open", $settings["day_{$dayKey}_open"] ?? ($dayKey === 'friday' ? '0' : '1'));
                            $isOpen    = ($rawVal === '1' || $rawVal === 1 || $rawVal === true);
                            $openTime  = old("day_{$dayKey}_from", $settings["day_{$dayKey}_from"] ?? '08:00');
                            $closeTime = old("day_{$dayKey}_to",   $settings["day_{$dayKey}_to"]   ?? '17:00');
                        @endphp
                        <div id="row-{{ $dayKey }}"
                             class="relative rounded-2xl border p-4 transition-all"
                             style="{{ $isOpen ? 'background:#fff;border-color:#6ee7b7;box-shadow:0 1px 4px rgba(16,185,129,.1)' : 'background:#f1f5f9;border-color:#fca5a5;opacity:.85' }}">

                            <input type="hidden" name="day_{{ $dayKey }}_open" value="0">
                            <input type="checkbox" id="chk-{{ $dayKey }}" name="day_{{ $dayKey }}_open"
                                   value="1" class="sr-only day-toggle" data-day="{{ $dayKey }}"
                                   {{ $isOpen ? 'checked' : '' }}>

                            <div class="mb-3">
                                <span class="text-sm font-bold text-slate-800 block">{{ $dayNames['ar'] }}</span>
                                <span style="font-size:10px;color:#94a3b8;font-weight:600">{{ $dayNames['en'] }}</span>
                            </div>

                            <button type="button"
                                    class="day-status-btn w-full rounded-xl py-1.5 text-xs font-bold transition-all mb-3"
                                    data-day="{{ $dayKey }}"
                                    style="{{ $isOpen ? 'background:#d1fae5;color:#059669;border:1px solid #6ee7b7' : 'background:#fee2e2;color:#e11d48;border:1px solid #fca5a5' }}">
                                {{ $isOpen ? '✅ يوم عمل' : '🔴 إجازة' }}
                            </button>

                            <div data-times="{{ $dayKey }}" style="{{ $isOpen ? '' : 'display:none' }}">
                                <div class="flex items-center justify-center gap-1 rounded-xl p-2 border border-slate-100" style="background:#f8fafc">
                                    <input type="time" name="day_{{ $dayKey }}_from" value="{{ $openTime }}"
                                           style="background:transparent;text-align:center;font-size:1rem;font-weight:700;outline:none;width:5rem;color:#0f172a"
                                           {{ $isOpen ? '' : 'disabled' }}>
                                    <span style="color:#10b981;font-weight:900">→</span>
                                    <input type="time" name="day_{{ $dayKey }}_to" value="{{ $closeTime }}"
                                           style="background:transparent;text-align:center;font-size:1rem;font-weight:700;outline:none;width:5rem;color:#0f172a"
                                           {{ $isOpen ? '' : 'disabled' }}>
                                </div>
                            </div>

                            <div data-holiday="{{ $dayKey }}" style="{{ $isOpen ? 'display:none' : '' }}">
                                <div class="flex items-center justify-center gap-2 rounded-xl p-2 border border-rose-100" style="background:#fff1f2">
                                    <i class="fa-solid fa-umbrella-beach" style="color:#fb7185;font-size:.85rem"></i>
                                    <span style="font-size:.75rem;font-weight:700;color:#f43f5e">يوم إجازة</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-8 py-3.5 rounded-xl shadow-md shadow-emerald-600/10 transition-all text-sm">
                    <i class="fa-solid fa-floppy-disk me-2"></i> حفظ الإعدادات
                </button>
            </div>
        </div>

    </form>

@endsection

@section('scripts')
<script>
    // ── Tab switching ──────────────────────────────────────
    const tabBtns   = document.querySelectorAll('.tab-btn');
    const tabPanels = document.querySelectorAll('.tab-panel');

    tabBtns.forEach(function(btn) {
        btn.addEventListener('click', function() {
            const target = this.dataset.tab;

            tabBtns.forEach(function(b) {
                b.classList.remove('active');
                b.setAttribute('aria-selected', 'false');
            });
            tabPanels.forEach(function(p) { p.classList.remove('active'); });

            this.classList.add('active');
            this.setAttribute('aria-selected', 'true');
            document.getElementById('tab-' + target).classList.add('active');
        });
    });

    // ── Working-hours day toggle ───────────────────────────
    function applyDayState(day, isOpen) {
        const row        = document.getElementById('row-' + day);
        const timesEl    = row.querySelector('[data-times="'   + day + '"]');
        const holidayEl  = row.querySelector('[data-holiday="' + day + '"]');
        const badgeBtn   = row.querySelector('.day-status-btn');
        const timeInputs = row.querySelectorAll('input[type="time"]');

        if (isOpen) {
            row.style.background  = '#fff';
            row.style.borderColor = '#6ee7b7';
            row.style.opacity     = '1';
            row.style.boxShadow   = '0 1px 4px rgba(16,185,129,.1)';
            if (timesEl)   timesEl.style.display   = '';
            if (holidayEl) holidayEl.style.display  = 'none';
            if (badgeBtn) {
                badgeBtn.textContent      = '✅ يوم عمل';
                badgeBtn.style.background = '#d1fae5';
                badgeBtn.style.color      = '#059669';
                badgeBtn.style.border     = '1px solid #6ee7b7';
            }
            timeInputs.forEach(function(i) { i.disabled = false; });
        } else {
            row.style.background  = '#f1f5f9';
            row.style.borderColor = '#fca5a5';
            row.style.opacity     = '0.85';
            row.style.boxShadow   = 'none';
            if (timesEl)   timesEl.style.display   = 'none';
            if (holidayEl) holidayEl.style.display  = '';
            if (badgeBtn) {
                badgeBtn.textContent      = '🔴 إجازة';
                badgeBtn.style.background = '#fee2e2';
                badgeBtn.style.color      = '#e11d48';
                badgeBtn.style.border     = '1px solid #fca5a5';
            }
            timeInputs.forEach(function(i) { i.disabled = true; });
        }
    }

    document.querySelectorAll('.day-status-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const day = this.dataset.day;
            const chk = document.getElementById('chk-' + day);
            chk.checked = !chk.checked;
            applyDayState(day, chk.checked);
        });
    });
</script>
@endsection
