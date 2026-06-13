<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = [
            'store_name_ar' => Setting::getValue('store_name_ar', Setting::getValue('store_name')),
            'store_name_en' => Setting::getValue('store_name_en', 'Vision Medical Store'),
            'store_email' => Setting::getValue('store_email'),
            'store_phone' => Setting::getValue('store_phone'),
            'whatsapp' => Setting::getValue('whatsapp'),
            'maintenance_phone' => Setting::getValue('maintenance_phone', '+966 50 765 4321'),
            'maintenance_whatsapp' => Setting::getValue('maintenance_whatsapp', '966507654321'),
            'about_us_title_ar' => Setting::getValue('about_us_title_ar', Setting::getValue('about_us_title')),
            'about_us_title_en' => Setting::getValue('about_us_title_en', 'About Us - Vision Medical'),
            'about_us_content_ar' => Setting::getValue('about_us_content_ar', Setting::getValue('about_us_content')),
            'about_us_content_en' => Setting::getValue('about_us_content_en', 'We provide the best medical supplies.'),
            'footer_text_ar' => Setting::getValue('footer_text_ar', Setting::getValue('footer_text')),
            'footer_text_en' => Setting::getValue('footer_text_en', 'All rights reserved © Vision Medical 2026.'),
            'company_map_link' => Setting::getValue('company_map_link', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3624.471946808796!2d46.6713917!3d24.7135517!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3e2f03890d48939b%3A0xf64f7dfd3d4b68db!2sRiyadh%20Saudi%20Arabia!5e0!3m2!1sen!2ssa!4v1717540000000!5m2!1sen!2ssa'),
        ];
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
            'maintenance_phone' => 'required|string|max:50',
            'maintenance_whatsapp' => 'required|string|max:50',
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

        Setting::setValue('maintenance_phone', $request->maintenance_phone);
        $maintenance_whatsapp = preg_replace('/[^0-9]/', '', $request->maintenance_whatsapp);
        Setting::setValue('maintenance_whatsapp', $maintenance_whatsapp);
        
        Setting::setValue('about_us_title_ar', $request->about_us_title_ar);
        Setting::setValue('about_us_title_en', $request->about_us_title_en);
        Setting::setValue('about_us_content_ar', $request->about_us_content_ar);
        Setting::setValue('about_us_content_en', $request->about_us_content_en);
        Setting::setValue('footer_text_ar', $request->footer_text_ar);
        Setting::setValue('footer_text_en', $request->footer_text_en);
        Setting::setValue('company_map_link', $request->company_map_link);

        ActivityLog::log('قام بتحديث إعدادات الموقع ثنائية اللغة وصفحة من نحن');

        return back()->with('success', __('messages.settings_updated'));
    }
}
