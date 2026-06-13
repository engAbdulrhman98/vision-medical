@extends('layouts.admin')

@section('page_title', 'تفاصيل رسالة العميل')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.contacts.index') }}" class="text-xs font-bold text-slate-500 hover:text-emerald-600 transition-all-300 flex items-center gap-1.5 w-fit">
            <i class="fa-solid fa-arrow-right"></i>
            <span>العودة لجميع الرسائل</span>
        </a>
    </div>

    <!-- Message Details Card -->
    <div class="bg-white border border-slate-100 rounded-3xl p-6 sm:p-10 shadow-xs max-w-3xl space-y-8">
        
        <!-- Header Info -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between border-b border-slate-50 pb-6 gap-4">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-sky-50 text-sky-600 rounded-2xl flex items-center justify-center text-xl shrink-0">
                    <i class="fa-solid fa-envelope-open-text"></i>
                </div>
                <div>
                    <h2 class="text-lg font-black text-slate-900 leading-tight">{{ $contact->subject ?? 'بلا عنوان' }}</h2>
                    <span class="text-xs text-slate-400 block mt-1">تاريخ الاستلام: {{ $contact->created_at->format('Y-m-d H:i:s') }} ({{ $contact->created_at->diffForHumans() }})</span>
                </div>
            </div>

            <!-- Action buttons -->
            <form action="{{ route('admin.contacts.destroy', $contact->id) }}" method="POST" class="inline" onsubmit="return confirm('هل أنت متأكد من حذف هذه الرسالة نهائياً؟')">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-rose-50 hover:bg-rose-500 hover:text-white border border-rose-100 text-rose-600 font-bold text-xs px-5 py-3 rounded-xl transition-all-300 flex items-center gap-2 shadow-xs">
                    <i class="fa-regular fa-trash-can"></i>
                    <span>حذف هذه الرسالة</span>
                </button>
            </form>
        </div>

        <!-- Sender Profile -->
        <div class="bg-slate-50 border border-slate-50 rounded-2xl p-5 grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm leading-relaxed">
            <div>
                <span class="text-xxs font-bold text-slate-400 block">اسم المرسل</span>
                <span class="font-bold text-slate-800 text-sm mt-0.5 block">{{ $contact->name }}</span>
            </div>
            <div>
                <span class="text-xxs font-bold text-slate-400 block">البريد الإلكتروني للعميل</span>
                <a href="mailto:{{ $contact->email }}" class="font-bold text-sky-600 hover:underline text-sm mt-0.5 block">{{ $contact->email }}</a>
            </div>
        </div>

        <!-- Message Body -->
        <div class="space-y-3">
            <span class="text-xs font-bold text-slate-600 block">نص ومضمون الرسالة:</span>
            <div class="bg-slate-50/30 border border-slate-100/50 rounded-2xl p-6 text-slate-700 text-sm leading-relaxed whitespace-pre-line shadow-inner">
                {{ $contact->message }}
            </div>
        </div>

        <!-- Direct Reply Option -->
        <div class="pt-4 border-t border-slate-50 flex flex-wrap gap-3">
            <a href="mailto:{{ $contact->email }}?subject={{ urlencode('رد على استفسارك: ' . $contact->subject) }}" 
               class="bg-sky-500 hover:bg-sky-600 text-white font-bold text-xs px-6 py-3.5 rounded-xl shadow-md transition-all-300 flex items-center gap-2">
                <i class="fa-solid fa-reply"></i>
                <span>رد سريع عبر البريد الإلكتروني</span>
            </a>
        </div>
    </div>
@endsection
