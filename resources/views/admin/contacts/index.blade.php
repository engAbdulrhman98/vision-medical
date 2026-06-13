@extends('layouts.admin')

@section('page_title', 'رسائل تواصل العملاء')

@section('content')
    <div class="mb-6">
        <div class="text-sm font-medium text-slate-500">
            هنا يمكنك استقبال وقراءة رسائل واستفسارات العملاء الواردة عبر نموذج الاتصال أو الموقع.
        </div>
    </div>

    <!-- Filters Block -->
    <div class="bg-white border border-slate-100 rounded-2xl p-5 mb-6 shadow-xs animate-fade-in">
        <form action="{{ route('admin.contacts.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            
            <!-- Search Text -->
            <div class="space-y-1 sm:col-span-2">
                <label for="search" class="block text-xs font-bold text-slate-400">البحث في الرسائل</label>
                <div class="relative">
                    <i class="fa-solid fa-magnifying-glass absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    <input type="text" name="search" id="search" value="{{ request('search') }}" 
                           placeholder="الاسم، البريد الإلكتروني، العنوان، نص الرسالة..." 
                           class="w-full bg-slate-50 border border-slate-100 focus:border-emerald-500 focus:bg-white rounded-xl pl-3 pr-9 py-2.5 text-slate-900 text-xs focus:outline-hidden transition-all-300">
                </div>
            </div>

            <!-- Status Filter -->
            <div class="space-y-1">
                <label for="status" class="block text-xs font-bold text-slate-400">حالة الرسالة</label>
                <div class="flex gap-2">
                    <select name="status" id="status" 
                            class="w-full bg-slate-50 border border-slate-100 focus:border-emerald-500 focus:bg-white rounded-xl px-3 py-2.5 text-slate-900 text-xs focus:outline-hidden transition-all-300">
                        <option value="">جميع الرسائل</option>
                        <option value="unread" {{ request('status') === 'unread' ? 'selected' : '' }}>جديدة غير مقروءة</option>
                        <option value="read" {{ request('status') === 'read' ? 'selected' : '' }}>مقروءة</option>
                    </select>
                    
                    <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs px-5 rounded-xl transition-all-300 flex items-center justify-center gap-1 shadow-sm">
                        <i class="fa-solid fa-filter text-[10px]"></i>
                        <span>تصفية</span>
                    </button>
                    
                    @if(request('search') || request('status'))
                        <a href="{{ route('admin.contacts.index') }}" class="bg-rose-50 hover:bg-rose-100 text-rose-600 font-bold text-xs px-3.5 rounded-xl transition-all-300 border border-rose-100 flex items-center justify-center" title="إعادة تعيين">
                            <i class="fa-solid fa-arrows-rotate"></i>
                        </a>
                    @endif
                </div>
            </div>

        </form>
    </div>

    <!-- Messages Listing -->
    <div class="bg-white border border-slate-100 rounded-2xl shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-right border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-400 text-xxs font-bold uppercase tracking-wider border-b border-slate-100">
                        <th class="px-6 py-4">اسم المرسل</th>
                        <th class="px-6 py-4">البريد الإلكتروني</th>
                        <th class="px-6 py-4">موضوع الرسالة</th>
                        <th class="px-6 py-4">نص الرسالة (مختصر)</th>
                        <th class="px-6 py-4">تاريخ الإرسال</th>
                        <th class="px-6 py-4">الحالة</th>
                        <th class="px-6 py-4 text-center">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 text-sm">
                    @if($messages->isEmpty())
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-slate-400">
                                <i class="fa-regular fa-envelope text-3xl mb-2 block"></i>
                                لا توجد رسائل مطابقة لخيارات التصفية حالياً.
                            </td>
                        </tr>
                    @else
                        @foreach($messages as $msg)
                            <tr class="hover:bg-slate-50/50 transition-all-300 {{ !$msg->is_read ? 'bg-sky-50/20 font-bold' : '' }}">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        @if(!$msg->is_read)
                                            <span class="w-2 h-2 bg-sky-500 rounded-full" title="جديدة"></span>
                                        @endif
                                        <span class="text-slate-900">{{ $msg->name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-slate-600 font-medium">{{ $msg->email }}</td>
                                <td class="px-6 py-4 text-slate-900 font-bold max-w-[150px] truncate">{{ $msg->subject ?? 'بلا عنوان' }}</td>
                                <td class="px-6 py-4 text-slate-500 max-w-xs truncate">{{ $msg->message }}</td>
                                <td class="px-6 py-4 text-slate-400 text-xs">{{ $msg->created_at->diffForHumans() }}</td>
                                <td class="px-6 py-4">
                                    @if($msg->is_read)
                                        <span class="inline-flex items-center gap-1 bg-slate-100 text-slate-600 text-[10px] font-bold px-2.5 py-0.5 rounded-md border border-slate-200/50">
                                            <span>مقروءة</span>
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 bg-sky-50 text-sky-800 text-[10px] font-bold px-2.5 py-0.5 rounded-md border border-sky-100">
                                            <span>رسالة جديدة</span>
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <!-- Show message -->
                                        <a href="{{ route('admin.contacts.show', $msg->id) }}" class="bg-sky-500 hover:bg-sky-600 text-white font-bold text-xxs px-3 py-2 rounded-lg shadow-sm transition-all-300 flex items-center gap-1">
                                            <i class="fa-regular fa-envelope-open"></i>
                                            <span>فتح وقراءة</span>
                                        </a>
                                        <!-- Delete button -->
                                        <form action="{{ route('admin.contacts.destroy', $msg->id) }}" method="POST" class="inline" onsubmit="return confirm('هل أنت متأكد من حذف هذه الرسالة؟')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-slate-100 hover:bg-rose-500 hover:text-white text-slate-500 font-bold text-xxs px-3 py-2 rounded-lg border border-slate-100/50 hover:border-rose-500 transition-all-300 flex items-center gap-1">
                                                <i class="fa-regular fa-trash-can"></i>
                                                <span>حذف</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($messages->hasPages())
            <div class="p-6 border-t border-slate-50">
                {{ $messages->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
@endsection
