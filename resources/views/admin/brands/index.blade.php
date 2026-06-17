@extends('layouts.admin')

@section('page_title', 'إدارة العلامات التجارية (الماركات)')

@section('content')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div class="text-sm font-medium text-slate-500">
            هنا يمكنك إدارة الشركات المصنعة والعلامات التجارية للأجهزة الطبية.
        </div>
        <a href="{{ route('admin.brands.create') }}"
           class="flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm px-5 py-3 rounded-xl transition-all shadow-md shadow-emerald-600/10 w-full sm:w-auto shrink-0">
            <i class="fa-solid fa-plus text-xs"></i>
            <span>إضافة ماركة جديدة</span>
        </a>
    </div>

    @if($brands->isEmpty())
        <div class="bg-white border border-slate-100 rounded-2xl shadow-sm p-12 text-center text-slate-400">
            <i class="fa-regular fa-copyright text-4xl mb-3 block text-slate-300"></i>
            <p class="text-sm font-semibold">لا توجد علامات تجارية مسجلة حالياً.</p>
        </div>
    @else

        {{-- ═══ MOBILE Cards (below lg) ═══ --}}
        <div class="space-y-3 lg:hidden">
            @foreach($brands as $brand)
                <div class="bg-white border border-slate-100 rounded-2xl shadow-sm p-4 flex items-center gap-4">
                    {{-- Logo --}}
                    <div class="w-14 h-14 rounded-xl bg-slate-50 border border-slate-100 overflow-hidden flex items-center justify-center shrink-0">
                        @if($brand->image)
                            <img src="{{ $brand->image }}" alt="{{ $brand->name }}" class="w-full h-full object-contain p-1" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            <span class="hidden w-full h-full items-center justify-center bg-slate-50">
                                <i class="fa-solid fa-copyright text-slate-300 text-lg"></i>
                            </span>
                        @else
                            <i class="fa-solid fa-copyright text-slate-300 text-lg"></i>
                        @endif
                    </div>
                    {{-- Info --}}
                    <div class="min-w-0 flex-grow">
                        <p class="font-black text-slate-900 text-sm">{{ $brand->name }}</p>
                        <p class="text-[11px] text-slate-400 font-mono mt-0.5 truncate" dir="ltr">{{ $brand->slug }}</p>
                        @if($brand->description)
                            <p class="text-xs text-slate-500 mt-1 line-clamp-1">{{ $brand->description }}</p>
                        @endif
                    </div>
                    {{-- Count + Actions --}}
                    <div class="flex flex-col items-end gap-2 shrink-0">
                        <span class="bg-slate-100 text-slate-700 text-xs font-bold px-2.5 py-1 rounded-full whitespace-nowrap">
                            {{ $brand->products()->count() }} منتج
                        </span>
                        <div class="flex gap-2">
                            <a href="{{ route('admin.brands.edit', $brand->id) }}"
                               class="w-8 h-8 flex items-center justify-center bg-sky-50 text-sky-600 rounded-lg hover:bg-sky-100 border border-sky-100/50 transition-all">
                                <i class="fa-solid fa-pen text-xs"></i>
                            </a>
                            <form action="{{ route('admin.brands.destroy', $brand->id) }}" method="POST"
                                  onsubmit="return confirm('هل أنت متأكد من حذف هذه الماركة؟ سيتم حذف جميع منتجاتها!')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                        class="w-8 h-8 flex items-center justify-center bg-rose-50 text-rose-600 rounded-lg hover:bg-rose-100 border border-rose-100/50 transition-all">
                                    <i class="fa-solid fa-trash-can text-xs"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- ═══ DESKTOP Table (lg+) ═══ --}}
        <div class="hidden lg:block bg-white border border-slate-100 rounded-2xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-right border-collapse">
                    <thead>
                        <tr class="bg-slate-50 text-slate-400 text-[10px] font-bold uppercase tracking-wider border-b border-slate-100">
                            <th class="px-6 py-4">شعار الماركة</th>
                            <th class="px-6 py-4">اسم الماركة</th>
                            <th class="px-6 py-4">الرابط التعريفي (Slug)</th>
                            <th class="px-6 py-4">وصف الماركة</th>
                            <th class="px-6 py-4">عدد المنتجات</th>
                            <th class="px-6 py-4 text-center">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 text-sm">
                        @foreach($brands as $brand)
                            <tr class="hover:bg-slate-50/50 transition-all">
                                <td class="px-6 py-4">
                                    <div class="w-16 h-10 rounded-lg bg-slate-50 border border-slate-100 overflow-hidden flex items-center justify-center">
                                        @if($brand->image)
                                            <img src="{{ $brand->image }}" alt="{{ $brand->name }}" class="w-full h-full object-contain p-1" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                            <span class="hidden w-full h-full items-center justify-center bg-slate-50">
                                                <i class="fa-solid fa-copyright text-slate-300 text-sm"></i>
                                            </span>
                                        @else
                                            <i class="fa-solid fa-copyright text-slate-300 text-sm"></i>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 font-bold text-slate-900">{{ $brand->name }}</td>
                                <td class="px-6 py-4 font-mono text-slate-400 text-xs" dir="ltr">{{ $brand->slug }}</td>
                                <td class="px-6 py-4 text-slate-500 max-w-xs truncate">{{ $brand->description ?? 'بلا وصف' }}</td>
                                <td class="px-6 py-4">
                                    <span class="bg-slate-100 text-slate-700 text-xs font-bold px-2.5 py-1 rounded-full">
                                        {{ $brand->products()->count() }} منتج
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('admin.brands.edit', $brand->id) }}"
                                           class="w-9 h-9 flex items-center justify-center bg-sky-50 text-sky-600 rounded-lg hover:bg-sky-100 border border-sky-100/50 transition-all" title="تعديل">
                                            <i class="fa-solid fa-pen text-xs"></i>
                                        </a>
                                        <form action="{{ route('admin.brands.destroy', $brand->id) }}" method="POST"
                                              class="inline" onsubmit="return confirm('هل أنت متأكد من حذف هذه الماركة؟ سيتم حذف جميع منتجاتها!')">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                    class="w-9 h-9 flex items-center justify-center bg-rose-50 text-rose-600 rounded-lg hover:bg-rose-100 border border-rose-100/50 transition-all" title="حذف">
                                                <i class="fa-solid fa-trash-can text-xs"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if($brands->hasPages())
                <div class="p-6 border-t border-slate-50">
                    {{ $brands->links() }}
                </div>
            @endif
        </div>

        @if($brands->hasPages())
            <div class="mt-4 lg:hidden">{{ $brands->links() }}</div>
        @endif

    @endif
@endsection
