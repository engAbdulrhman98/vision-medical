@extends('layouts.admin')

@section('page_title', 'اعتماد ومراجعة التقييمات')

@section('content')

    {{-- Header + Filter Tabs --}}
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="text-sm font-medium text-slate-500">
            مراجعة تعليقات وتقييمات العملاء قبل نشرها في صفحات المنتجات للعامة.
        </div>

        {{-- Filter Tabs --}}
        <div class="flex flex-wrap bg-white p-1 border border-slate-100 rounded-xl shadow-sm self-start sm:self-center gap-1">
            <a href="{{ route('admin.reviews.index') }}"
               class="px-3 py-2 rounded-lg text-xs font-bold transition-all whitespace-nowrap
                      {{ !request('status') ? 'bg-slate-900 text-white shadow-sm' : 'text-slate-500 hover:text-slate-900' }}">
                الكل
            </a>
            <a href="{{ route('admin.reviews.index', ['status' => 'pending']) }}"
               class="px-3 py-2 rounded-lg text-xs font-bold transition-all whitespace-nowrap
                      {{ request('status') == 'pending' ? 'bg-amber-500 text-white shadow-sm' : 'text-slate-500 hover:text-slate-900' }}">
                <span class="hidden sm:inline">المعلقة بانتظار الاعتماد</span>
                <span class="sm:hidden">معلقة</span>
            </a>
            <a href="{{ route('admin.reviews.index', ['status' => 'approved']) }}"
               class="px-3 py-2 rounded-lg text-xs font-bold transition-all whitespace-nowrap
                      {{ request('status') == 'approved' ? 'bg-emerald-600 text-white shadow-sm' : 'text-slate-500 hover:text-slate-900' }}">
                <span class="hidden sm:inline">المعتمدة المنشورة</span>
                <span class="sm:hidden">معتمدة</span>
            </a>
        </div>
    </div>

    {{-- Empty State --}}
    @if($reviews->isEmpty())
        <div class="bg-white border border-slate-100 rounded-2xl shadow-sm p-12 text-center text-slate-400">
            <i class="fa-regular fa-comment-dots text-4xl mb-3 block text-slate-300"></i>
            <p class="text-sm font-semibold">لا توجد تعليقات أو تقييمات مطابقة للتصفية حالياً.</p>
        </div>

    @else

        {{-- ═══ MOBILE VIEW — Cards (hidden on lg+) ═══ --}}
        <div class="space-y-3 lg:hidden">
            @foreach($reviews as $review)
                <div class="bg-white border border-slate-100 rounded-2xl shadow-sm p-4 space-y-3
                            {{ !$review->is_approved ? 'border-amber-200 bg-amber-50/20' : '' }}">

                    {{-- Product + Status --}}
                    <div class="flex items-start justify-between gap-3">
                        <div class="min-w-0">
                            <a href="{{ route('product.show', $review->product->slug) }}" target="_blank"
                               class="text-sm font-black text-slate-900 hover:text-emerald-600 transition-all line-clamp-1">
                                {{ $review->product->name }}
                            </a>
                            <p class="text-xs text-slate-500 mt-0.5">{{ $review->reviewer_name }}</p>
                        </div>
                        @if($review->is_approved)
                            <span class="inline-flex items-center gap-1 bg-emerald-50 text-emerald-800 text-[10px] font-bold px-2.5 py-1 rounded-full border border-emerald-100 shrink-0">
                                <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>
                                <span>معتمد</span>
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 bg-amber-50 text-amber-800 text-[10px] font-bold px-2.5 py-1 rounded-full border border-amber-100 shrink-0">
                                <span class="w-1.5 h-1.5 bg-amber-500 rounded-full animate-pulse"></span>
                                <span>معلق</span>
                            </span>
                        @endif
                    </div>

                    {{-- Stars + Comment --}}
                    <div class="space-y-1.5">
                        <div class="flex items-center gap-0.5 text-amber-400">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fa-{{ $i <= $review->rating ? 'solid' : 'regular' }} fa-star text-xs"></i>
                            @endfor
                            <span class="text-xs text-slate-400 ms-1">({{ $review->rating }}/5)</span>
                        </div>
                        <p class="text-xs text-slate-600 leading-relaxed line-clamp-3">{{ $review->comment }}</p>
                    </div>

                    {{-- Footer: date + actions --}}
                    <div class="flex items-center justify-between pt-2 border-t border-slate-100 gap-2">
                        <span class="text-[11px] text-slate-400">{{ $review->created_at->format('Y-m-d') }}</span>
                        <div class="flex gap-2">
                            @if(!$review->is_approved)
                                <form action="{{ route('admin.reviews.approve', $review->id) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                            class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs px-3 py-1.5 rounded-lg transition-all flex items-center gap-1">
                                        <i class="fa-solid fa-check text-[10px]"></i>
                                        <span>اعتماد</span>
                                    </button>
                                </form>
                            @endif
                            <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST"
                                  onsubmit="return confirm('هل أنت متأكد من حذف هذا التقييم؟')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="bg-slate-100 hover:bg-rose-500 hover:text-white text-slate-500 font-bold text-xs px-3 py-1.5 rounded-lg border border-slate-100 hover:border-rose-500 transition-all flex items-center gap-1">
                                    <i class="fa-regular fa-trash-can text-[10px]"></i>
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
                            <th class="px-6 py-4">المنتج</th>
                            <th class="px-6 py-4">العميل</th>
                            <th class="px-6 py-4">التقييم</th>
                            <th class="px-6 py-4">التعليق</th>
                            <th class="px-6 py-4">تاريخ الإرسال</th>
                            <th class="px-6 py-4">الحالة</th>
                            <th class="px-6 py-4 text-center">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 text-sm">
                        @foreach($reviews as $review)
                            <tr class="hover:bg-slate-50/50 transition-all">
                                <td class="px-6 py-4">
                                    <div class="font-bold text-slate-900 leading-snug">
                                        <a href="{{ route('product.show', $review->product->slug) }}" target="_blank"
                                           class="hover:text-emerald-600 transition-all">
                                            {{ $review->product->name }}
                                        </a>
                                    </div>
                                </td>
                                <td class="px-6 py-4 font-semibold text-slate-700">{{ $review->reviewer_name }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-0.5 text-amber-400">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fa-{{ $i <= $review->rating ? 'solid' : 'regular' }} fa-star text-[11px]"></i>
                                        @endfor
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-slate-500 max-w-sm leading-relaxed">{{ $review->comment }}</td>
                                <td class="px-6 py-4 text-slate-400 text-xs whitespace-nowrap">{{ $review->created_at->format('Y-m-d H:i') }}</td>
                                <td class="px-6 py-4">
                                    @if($review->is_approved)
                                        <span class="inline-flex items-center gap-1 bg-emerald-50 text-emerald-800 text-[10px] font-bold px-2 py-0.5 rounded-md border border-emerald-100">
                                            <span class="w-1 h-1 bg-emerald-500 rounded-full"></span>
                                            <span>معتمد ومنشور</span>
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 bg-amber-50 text-amber-800 text-[10px] font-bold px-2 py-0.5 rounded-md border border-amber-100">
                                            <span class="w-1.5 h-1.5 bg-amber-500 rounded-full animate-pulse"></span>
                                            <span>معلق للمراجعة</span>
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        @if(!$review->is_approved)
                                            <form action="{{ route('admin.reviews.approve', $review->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit"
                                                        class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-[10px] px-3 py-2 rounded-lg shadow-sm transition-all flex items-center gap-1">
                                                    <i class="fa-solid fa-check"></i>
                                                    <span>اعتماد</span>
                                                </button>
                                            </form>
                                        @endif
                                        <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST"
                                              class="inline" onsubmit="return confirm('هل أنت متأكد من حذف هذا التقييم؟')">
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

            @if($reviews->hasPages())
                <div class="p-6 border-t border-slate-50">
                    {{ $reviews->links() }}
                </div>
            @endif
        </div>

        {{-- Pagination mobile --}}
        @if($reviews->hasPages())
            <div class="mt-4 lg:hidden">
                {{ $reviews->links() }}
            </div>
        @endif

    @endif

@endsection
