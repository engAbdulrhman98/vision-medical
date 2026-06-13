@extends('layouts.admin')

@section('page_title', 'اعتماد ومراجعة التقييمات')

@section('content')
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="text-sm font-medium text-slate-500">
            مراجعة تعليقات وتقييمات العملاء قبل نشرها في صفحات المنتجات للعامة.
        </div>
        
        <!-- Filter Tabs -->
        <div class="flex bg-white p-1 border border-slate-100 rounded-xl shadow-xs self-start sm:self-center">
            <a href="{{ route('admin.reviews.index') }}" 
               class="px-4 py-2 rounded-lg text-xs font-bold transition-all-300 {{ !request('status') ? 'bg-slate-900 text-white shadow-xs' : 'text-slate-500 hover:text-slate-900' }}">
                الكل
            </a>
            <a href="{{ route('admin.reviews.index', ['status' => 'pending']) }}" 
               class="px-4 py-2 rounded-lg text-xs font-bold transition-all-300 {{ request('status') == 'pending' ? 'bg-amber-500 text-white shadow-xs' : 'text-slate-500 hover:text-slate-900' }}">
                المعلقة بانتظار الاعتماد
            </a>
            <a href="{{ route('admin.reviews.index', ['status' => 'approved']) }}" 
               class="px-4 py-2 rounded-lg text-xs font-bold transition-all-300 {{ request('status') == 'approved' ? 'bg-emerald-600 text-white shadow-xs' : 'text-slate-500 hover:text-slate-900' }}">
                المعتمدة المنشورة
            </a>
        </div>
    </div>

    <!-- Reviews Listing -->
    <div class="bg-white border border-slate-100 rounded-2xl shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-right border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-400 text-xxs font-bold uppercase tracking-wider border-b border-slate-100">
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
                    @if($reviews->isEmpty())
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-slate-400">
                                <i class="fa-regular fa-comment-dots text-3xl mb-2 block"></i>
                                لا توجد تعليقات أو تقييمات مطابقة للتصفية حالياً.
                            </td>
                        </tr>
                    @else
                        @foreach($reviews as $review)
                            <tr class="hover:bg-slate-50/50 transition-all-300">
                                <td class="px-6 py-4">
                                    <div class="font-bold text-slate-900 leading-snug">
                                        <a href="{{ route('product.show', $review->product->slug) }}" target="_blank" class="hover:text-emerald-600 transition-all-300">
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
                                <td class="px-6 py-4 text-slate-400 text-xs">{{ $review->created_at->format('Y-m-d H:i') }}</td>
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
                                            <!-- Approve button -->
                                            <form action="{{ route('admin.reviews.approve', $review->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xxs px-3 py-2 rounded-lg shadow-sm transition-all-300 flex items-center gap-1">
                                                    <i class="fa-solid fa-check"></i>
                                                    <span>اعتماد</span>
                                                </button>
                                            </form>
                                        @endif
                                        <!-- Delete button -->
                                        <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST" class="inline" onsubmit="return confirm('هل أنت متأكد من حذف هذا التقييم؟')">
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
        @if($reviews->hasPages())
            <div class="p-6 border-t border-slate-50">
                {{ $reviews->links() }}
            </div>
        @endif
    </div>
@endsection
