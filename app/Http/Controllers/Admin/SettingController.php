<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    private $dayKeys = ['saturday', 'sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday'];

    public function index()
    {
        $settings = [
            'store_name_ar' => Setting::getValue('store_name_ar', Setting::getValue('store_name')),
            'store_name_en' => Setting::getValue('store_name_en', 'Vision Medical Store'),
            'store_email' => Setting::getValue('store_email'),
            'store_phone' => Setting::getValue('store_phone'),
            'whatsapp' => Setting::getValue('whatsapp'),
            'maintenance_phone' => Setting::getValue('maintenance_phone', '+20 100 123 4567'),
            'maintenance_whatsapp' => Setting::getValue('maintenance_whatsapp', '201001234567'),
            'about_us_title_ar' => Setting::getValue('about_us_title_ar', Setting::getValue('about_us_title')),
            'about_us_title_en' => Setting::getValue('about_us_title_en', 'About Us - Vision Medical'),
            'about_us_content_ar' => Setting::getValue('about_us_content_ar', Setting::getValue('about_us_content')),
            'about_us_content_en' => Setting::getValue('about_us_content_en', 'We provide the best medical supplies.'),
            'footer_text_ar' => Setting::getValue('footer_text_ar', Setting::getValue('footer_text')),
            'footer_text_en' => Setting::getValue('footer_text_en', 'All rights reserved © Vision Medical 2026.'),
            'company_map_link' => Setting::getValue('company_map_link', ''),
        ];

        // Load per-day working hours
        foreach ($this->dayKeys as $day) {
            $defaultOpen = $day === 'friday' ? '0' : '1';
            $settings["day_{$day}_open"] = Setting::getValue("day_{$day}_open", $defaultOpen);
            $settings["day_{$day}_from"] = Setting::getValue("day_{$day}_from", '08:00');
            $settings["day_{$day}_to"]   = Setting::getValue("day_{$day}_to", '17:00');
        }

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'store_name_ar' => 'required|string|max:255',
            'store_name_en' => 'required|string|max:255',
            'store_email' => 'required|email|max:255',
            'store_phone' => 'required|string|max:50',
            'whatsapp' => 'required|string|max:50',
            'about_us_title_ar' => 'required|string|max:255',
            'about_us_title_en' => 'required|string|max:255',
            'about_us_content_ar' => 'required|string',
            'about_us_content_en' => 'required|string',
            'footer_text_ar' => 'nullable|string|max:255',
            'footer_text_en' => 'nullable|string|max:255',
            'company_map_link' => 'nullable|string|max:1000',
        ]);

        Setting::setValue('store_name_ar', $request->store_name_ar);
        Setting::setValue('store_name_en', $request->store_name_en);
        Setting::setValue('store_email', $request->store_email);
        Setting::setValue('store_phone', $request->store_phone);
        
        $whatsapp = preg_replace('/[^0-9]/', '', $request->whatsapp);
        Setting::setValue('whatsapp', $whatsapp);

        // Save per-day working hours
        foreach ($this->dayKeys as $day) {
            Setting::setValue("day_{$day}_open", $request->input("day_{$day}_open", '0'));
            Setting::setValue("day_{$day}_from", $request->input("day_{$day}_from", '08:00'));
            Setting::setValue("day_{$day}_to", $request->input("day_{$day}_to", '17:00'));
        }

        // Preserve maintenance contact fields
        Setting::setValue('maintenance_phone', $request->maintenance_phone ?? Setting::getValue('maintenance_phone'));
        $maintenance_whatsapp = preg_replace('/[^0-9]/', '', $request->maintenance_whatsapp ?? '');
        Setting::setValue('maintenance_whatsapp', $maintenance_whatsapp);
        
        Setting::setValue('about_us_title_ar', $request->about_us_title_ar);
        Setting::setValue('about_us_title_en', $request->about_us_title_en);
        Setting::setValue('about_us_content_ar', $request->about_us_content_ar);
        Setting::setValue('about_us_content_en', $request->about_us_content_en);
        Setting::setValue('footer_text_ar', $request->footer_text_ar);
        Setting::setValue('footer_text_en', $request->footer_text_en);
        Setting::setValue('company_map_link', $request->company_map_link);

        ActivityLog::log('قام بتحديث إعدادات الموقع ومواعيد العمل');

        return back()->with('success', __('messages.settings_updated'));
    }
}
