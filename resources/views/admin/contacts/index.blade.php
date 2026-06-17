@extends('layouts.admin')

@section('page_title', 'رسائل تواصل العملاء')

@section('content')
    <div class="mb-6">
        <div class="text-sm font-medium text-slate-500">
            هنا يمكنك استقبال وقراءة رسائل واستفسارات العملاء الواردة عبر نموذج الاتصال أو الموقع.
        </div>
    </div>

    {{-- ── Filters Block ──────────────────────────────────── --}}
    <div class="bg-white border border-slate-100 rounded-2xl p-4 sm:p-5 mb-6 shadow-sm">
        <form action="{{ route('admin.contacts.index') }}" method="GET"
              class="grid grid-cols-1 sm:grid-cols-12 gap-3 items-end">

            {{-- Search --}}
            <div class="space-y-1 sm:col-span-6 lg:col-span-8">
                <label for="search" class="block text-xs font-bold text-slate-400">البحث في الرسائل</label>
                <div class="relative">
                    <i class="fa-solid fa-magnifying-glass absolute end-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    <input type="text" name="search" id="search" value="{{ request('search') }}"
                           placeholder="الاسم، البريد الإلكتروني، العنوان، نص الرسالة..."
                           class="w-full bg-slate-50 border border-slate-100 focus:border-emerald-500 focus:bg-white rounded-xl ps-3 pe-9 py-2.5 text-slate-900 text-xs focus:outline-none transition-all">
                </div>
            </div>

            {{-- Status Filter --}}
            <div class="space-y-1 sm:col-span-4 lg:col-span-3">
                <label for="status" class="block text-xs font-bold text-slate-400">حالة الرسالة</label>
                <select name="status" id="status"
                        class="w-full bg-slate-50 border border-slate-100 focus:border-emerald-500 focus:bg-white rounded-xl px-3 py-2.5 text-slate-900 text-xs focus:outline-none transition-all">
                    <option value="">جميع الرسائل</option>
                    <option value="unread" {{ request('status') === 'unread' ? 'selected' : '' }}>جديدة غير مقروءة</option>
                    <option value="read"   {{ request('status') === 'read'   ? 'selected' : '' }}>مقروءة</option>
                </select>
            </div>

            {{-- Buttons --}}
            <div class="flex gap-2 sm:col-span-2 lg:col-span-1">
                <button type="submit"
                        class="flex-grow bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs py-3 rounded-xl transition-all flex items-center justify-center gap-1 shadow-sm">
                    <i class="fa-solid fa-filter text-[10px]"></i>
                    <span>تصفية</span>
                </button>
                @if(request('search') || request('status'))
                    <a href="{{ route('admin.contacts.index') }}"
                       class="bg-rose-50 hover:bg-rose-100 text-rose-600 font-bold text-xs px-3.5 py-3 rounded-xl transition-all border border-rose-100 flex items-center justify-center"
                       title="إعادة تعيين">
                        <i class="fa-solid fa-arrows-rotate"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

    {{-- ── Messages List ───────────────────────────────────── --}}
    @if($messages->isEmpty())
        <div class="bg-white border border-slate-100 rounded-2xl shadow-sm p-12 text-center text-slate-400">
            <i class="fa-regular fa-envelope text-4xl mb-3 block text-slate-300"></i>
            <p class="text-sm font-semibold">لا توجد رسائل مطابقة لخيارات التصفية حالياً.</p>
        </div>
    @else

        {{-- ═══ MOBILE VIEW — Cards (hidden on lg+) ═══ --}}
        <div class="space-y-3 lg:hidden">
            @foreach($messages as $msg)
                <div class="bg-white border {{ !$msg->is_read ? 'border-sky-200 bg-sky-50/30' : 'border-slate-100' }} rounded-2xl shadow-sm p-4 space-y-3">

                    {{-- Top row: sender + badge --}}
                    <div class="flex items-start justify-between gap-3">
                        <div class="flex items-center gap-2 min-w-0">
                            @if(!$msg->is_read)
                                <span class="w-2 h-2 bg-sky-500 rounded-full shrink-0"></span>
                            @endif
                            <div class="min-w-0">
                                <p class="text-sm font-bold text-slate-900 truncate">{{ $msg->name }}</p>
                                <p class="text-xs text-slate-500 truncate">{{ $msg->email }}</p>
                            </div>
                        </div>
                        @if($msg->is_read)
                            <span class="inline-flex items-center bg-slate-100 text-slate-500 text-[10px] font-bold px-2.5 py-0.5 rounded-full shrink-0">مقروءة</span>
                        @else
                            <span class="inline-flex items-center bg-sky-50 text-sky-700 text-[10px] font-bold px-2.5 py-0.5 rounded-full border border-sky-100 shrink-0">جديدة</span>
                        @endif
                    </div>

                    {{-- Subject --}}
                    <div>
                        <p class="text-xs font-black text-slate-800 truncate">{{ $msg->subject ?? 'بلا عنوان' }}</p>
                        <p class="text-xs text-slate-500 mt-0.5 line-clamp-2">{{ $msg->message }}</p>
                    </div>

                    {{-- Footer: date + actions --}}
                    <div class="flex items-center justify-between pt-2 border-t border-slate-100 gap-2">
                        <span class="text-[11px] text-slate-400">{{ $msg->created_at->diffForHumans() }}</span>
                        <div class="flex gap-2">
                            <a href="{{ route('admin.contacts.show', $msg->id) }}"
                               class="bg-sky-500 hover:bg-sky-600 text-white font-bold text-xs px-3 py-1.5 rounded-lg transition-all flex items-center gap-1">
                                <i class="fa-regular fa-envelope-open text-[11px]"></i>
                                <span>فتح</span>
                            </a>
                            <form action="{{ route('admin.contacts.destroy', $msg->id) }}" method="POST"
                                  onsubmit="return confirm('هل أنت متأكد من حذف هذه الرسالة؟')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="bg-slate-100 hover:bg-rose-500 hover:text-white text-slate-500 font-bold text-xs px-3 py-1.5 rounded-lg border border-slate-100 hover:border-rose-500 transition-all flex items-center gap-1">
                                    <i class="fa-regular fa-trash-can text-[11px]"></i>
                                    <span>حذف</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- ═══ DESKTOP VIEW — Table (hidden below lg) ═══ --}}
        <div class="hidden lg:block bg-white border border-slate-100 rounded-2xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-right border-collapse">
                    <thead>
                        <tr class="bg-slate-50 text-slate-400 text-[10px] font-bold uppercase tracking-wider border-b border-slate-100">
                            <th class="px-6 py-4">اسم المرسل</th>
                            <th class="px-6 py-4">البريد الإلكتروني</th>
                            <th class="px-6 py-4">موضوع الرسالة</th>
                            <th class="px-6 py-4">نص الرسالة</th>
                            <th class="px-6 py-4">تاريخ الإرسال</th>
                            <th class="px-6 py-4">الحالة</th>
                            <th class="px-6 py-4 text-center">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 text-sm">
                        @foreach($messages as $msg)
                            <tr class="hover:bg-slate-50/50 transition-all {{ !$msg->is_read ? 'bg-sky-50/20 font-semibold' : '' }}">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        @if(!$msg->is_read)
                                            <span class="w-2 h-2 bg-sky-500 rounded-full shrink-0" title="جديدة"></span>
                                        @endif
                                        <span class="text-slate-900">{{ $msg->name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-slate-600 font-medium">{{ $msg->email }}</td>
                                <td class="px-6 py-4 text-slate-900 font-bold max-w-[160px] truncate">{{ $msg->subject ?? 'بلا عنوان' }}</td>
                                <td class="px-6 py-4 text-slate-500 max-w-xs truncate">{{ $msg->message }}</td>
                                <td class="px-6 py-4 text-slate-400 text-xs whitespace-nowrap">{{ $msg->created_at->diffForHumans() }}</td>
                                <td class="px-6 py-4">
                                    @if($msg->is_read)
                                        <span class="inline-flex items-center bg-slate-100 text-slate-600 text-[10px] font-bold px-2.5 py-0.5 rounded-md border border-slate-200/50">مقروءة</span>
                                    @else
                                        <span class="inline-flex items-center bg-sky-50 text-sky-800 text-[10px] font-bold px-2.5 py-0.5 rounded-md border border-sky-100">رسالة جديدة</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('admin.contacts.show', $msg->id) }}"
                                           class="bg-sky-500 hover:bg-sky-600 text-white font-bold text-[10px] px-3 py-2 rounded-lg shadow-sm transition-all flex items-center gap-1">
                                            <i class="fa-regular fa-envelope-open"></i>
                                            <span>فتح وقراءة</span>
                                        </a>
                                        <form action="{{ route('admin.contacts.destroy', $msg->id) }}" method="POST"
                                              class="inline" onsubmit="return confirm('هل أنت متأكد من حذف هذه الرسالة؟')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="bg-slate-100 hover:bg-rose-500 hover:text-white text-slate-500 font-bold text-[10px] px-3 py-2 rounded-lg border border-slate-100/50 hover:border-rose-500 transition-all flex items-center gap-1">
                                                <i class="fa-regular fa-trash-can"></i>
                                                <span>حذف</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($messages->hasPages())
                <div class="p-6 border-t border-slate-50">
                    {{ $messages->appends(request()->query())->links() }}
                </div>
            @endif
        </div>

        {{-- Pagination for mobile --}}
        @if($messages->hasPages())
            <div class="mt-4 lg:hidden">
                {{ $messages->appends(request()->query())->links() }}
            </div>
        @endif

    @endif

@endsection
