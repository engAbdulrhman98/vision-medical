@extends('layouts.admin')

@section('page_title', __('messages.admin_dashboard'))

@section('content')
    <!-- Statistics Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        
        <!-- Visitors Card -->
        <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-xs flex items-center justify-between">
            <div class="space-y-2">
                <span class="text-xs font-semibold text-slate-400 uppercase">{{ __('messages.total_visitors') }}</span>
                <div class="text-2xl font-black text-slate-900">{{ number_format($stats['total_visits']) }}</div>
                <div class="text-xxs text-emerald-600 font-bold flex items-center gap-1">
                    <i class="fa-solid fa-users text-xxs"></i>
                    <span>{{ __('messages.today_visitors', ['count' => number_format($stats['today_visits'])]) }}</span>
                </div>
            </div>
            <div class="w-12 h-12 bg-sky-50 text-sky-600 rounded-xl flex items-center justify-center text-xl">
                <i class="fa-solid fa-chart-line"></i>
            </div>
        </div>

        <!-- Products Card -->
        <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-xs flex items-center justify-between">
            <div class="space-y-2">
                <span class="text-xs font-semibold text-slate-400 uppercase">{{ __('messages.total_products') }}</span>
                <div class="text-2xl font-black text-slate-900">{{ number_format($stats['products']) }}</div>
                <span class="text-xxs text-slate-400 block">{{ __('messages.displayed_in_catalog') }}</span>
            </div>
            <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center text-xl">
                <i class="fa-solid fa-boxes-stacked"></i>
            </div>
        </div>

        <!-- Categories & Brands Card -->
        <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-xs flex items-center justify-between">
            <div class="space-y-2">
                <span class="text-xs font-semibold text-slate-400 uppercase">{{ __('messages.categories_and_brands') }}</span>
                <div class="text-2xl font-black text-slate-900">
                    {{ $stats['categories'] }} <span class="text-xs font-semibold text-slate-400">/</span> {{ $stats['brands'] }}
                </div>
                <span class="text-xxs text-slate-400 block">{{ __('messages.categories_slash_brands') }}</span>
            </div>
            <div class="w-12 h-12 bg-violet-50 text-violet-600 rounded-xl flex items-center justify-center text-xl">
                <i class="fa-solid fa-folder-tree"></i>
            </div>
        </div>

        <!-- Pending reviews & messages Card -->
        <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-xs flex items-center justify-between">
            <div class="space-y-2">
                <span class="text-xs font-semibold text-slate-400 uppercase">{{ __('messages.pending_actions') }}</span>
                <div class="text-2xl font-black text-slate-900">
                    {{ $stats['pending_reviews'] + $stats['unread_messages'] }}
                </div>
                <div class="text-xxs text-rose-600 font-bold flex items-center gap-1.5">
                    <span>{{ __('messages.reviews_count', ['count' => $stats['pending_reviews']]) }}</span>
                    <span>•</span>
                    <span>{{ __('messages.messages_count', ['count' => $stats['unread_messages']]) }}</span>
                </div>
            </div>
            <div class="w-12 h-12 bg-rose-50 text-rose-600 rounded-xl flex items-center justify-center text-xl">
                <i class="fa-solid fa-bell"></i>
            </div>
        </div>
    </div>

    <!-- Chart & Activity Log Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
        
        <!-- Visitors Chart (2 Columns) -->
        <div class="lg:col-span-2 bg-white border border-slate-100 rounded-2xl p-6 shadow-xs flex flex-col justify-between">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-bold text-slate-950 text-base flex items-center gap-2">
                    <i class="fa-solid fa-users-viewfinder text-emerald-600"></i>
                    <span>{{ __('messages.visitors_stats') }}</span>
                </h3>
                <span class="text-xxs font-semibold text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-full">{{ __('messages.live_update') }}</span>
            </div>
            
            <!-- Chart Container -->
            <div class="relative w-full h-72">
                <canvas id="visitorsChart"></canvas>
            </div>
        </div>

        <!-- Activity Log Timeline (1 Column) — sticky on scroll -->
        <div id="activity-log-sticky" class="sticky self-start bg-white border border-slate-100 rounded-2xl p-6 shadow-xs flex flex-col overflow-hidden z-[1]" style="top: 73px; max-height: calc(100vh - 90px);">
            <h3 class="font-bold text-slate-950 text-base mb-5 flex items-center gap-2 pb-3 border-b border-slate-50 shrink-0">
                <i class="fa-solid fa-history text-emerald-600"></i>
                <span>{{ __('messages.activity_log') }}</span>
            </h3>

            @if($activities->isEmpty())
                <div class="flex-grow flex flex-col items-center justify-center text-center py-8">
                    <i class="fa-solid fa-clock-rotate-left text-slate-300 text-3xl mb-3"></i>
                    <p class="text-slate-400 text-xs">{{ __('messages.no_activities') }}</p>
                </div>
            @else
                <div class="flex-grow overflow-y-auto space-y-4 pe-1">
                    @foreach($activities as $act)
                        <div class="flex gap-3 relative before:absolute {{ app()->getLocale() == 'ar' ? 'before:right-[15px]' : 'before:left-[15px]' }} before:top-8 before:bottom-[-20px] before:w-[2px] before:bg-slate-100 last:before:hidden">
                            <!-- Icon -->
                            <div class="w-8 h-8 rounded-full bg-slate-50 border border-slate-100 flex items-center justify-center text-xs text-slate-600 shrink-0 z-10">
                                <i class="fa-solid fa-circle-check text-emerald-500"></i>
                            </div>
                            <div class="space-y-1">
                                <p class="text-xs text-slate-800 font-medium leading-relaxed">
                                    {{ $act->action }}
                                </p>
                                <span class="text-slate-400 text-xxs block" dir="{{ \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocaleDirection() }}">
                                    {{ __('messages.by_user', ['name' => $act->user ? $act->user->name : (app()->getLocale() == 'ar' ? 'النظام' : 'System')]) }} • {{ $act->created_at->diffForHumans() }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <!-- Quick Action / Moderation Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        <!-- Recent Pending Reviews -->
        <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-xs">
            <div class="flex items-center justify-between mb-5 border-b border-slate-50 pb-3">
                <h3 class="font-bold text-slate-950 text-base flex items-center gap-2">
                    <i class="fa-solid fa-star-half-stroke text-amber-500"></i>
                    <span>{{ __('messages.new_pending_reviews') }}</span>
                </h3>
                <a href="{{ route('admin.reviews.index', ['status' => 'pending']) }}" class="text-xxs font-bold text-emerald-600 hover:underline">{{ __('messages.view_all') }}</a>
            </div>

            @if($recentReviews->isEmpty())
                <div class="text-center py-12 text-slate-400 text-xs">
                    <i class="fa-regular fa-comment-dots text-3xl mb-2 block"></i>
                    {{ __('messages.no_pending_reviews') }}
                </div>
            @else
                <div class="space-y-4">
                    @foreach($recentReviews as $rev)
                        <div class="bg-slate-50 border border-slate-100 p-4 rounded-xl space-y-3">
                            <div class="flex items-center justify-between">
                                <div>
                                    <span class="font-bold text-slate-900 text-xs block">{{ $rev->reviewer_name }}</span>
                                    <span class="text-xxs text-slate-400 block">{!! __('messages.on_product', ['name' => '<span class="font-semibold text-emerald-600">' . $rev->product->name . '</span>']) !!}</span>
                                </div>
                                <div class="flex items-center gap-0.5 text-amber-400">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fa-{{ $i <= $rev->rating ? 'solid' : 'regular' }} fa-star text-[10px]"></i>
                                    @endfor
                                </div>
                            </div>
                            <p class="text-xs text-slate-600 leading-relaxed">{{ $rev->comment }}</p>
                            
                            <!-- Action buttons -->
                            <div class="flex items-center gap-2 pt-2 border-t border-slate-100/50">
                                <form action="{{ route('admin.reviews.approve', $rev->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xxs px-3 py-1.5 rounded-md shadow-sm transition-all-300">
                                        {{ __('messages.approve_and_publish') }}
                                    </button>
                                </form>
                                <form action="{{ route('admin.reviews.destroy', $rev->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-slate-200 hover:bg-rose-500 hover:text-white text-slate-600 font-bold text-xxs px-3 py-1.5 rounded-md transition-all-300">
                                        {{ __('messages.delete') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Recent Unread Contact Messages -->
        <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-xs">
            <div class="flex items-center justify-between mb-5 border-b border-slate-50 pb-3">
                <h3 class="font-bold text-slate-950 text-base flex items-center gap-2">
                    <i class="fa-solid fa-envelope-open-text text-sky-500"></i>
                    <span>{{ __('messages.unread_messages') }}</span>
                </h3>
                <a href="{{ route('admin.contacts.index') }}" class="text-xxs font-bold text-emerald-600 hover:underline">{{ __('messages.view_all') }}</a>
            </div>

            @if($recentMessages->isEmpty())
                <div class="text-center py-12 text-slate-400 text-xs">
                    <i class="fa-regular fa-envelope text-3xl mb-2 block"></i>
                    {{ __('messages.no_unread_messages') }}
                </div>
            @else
                <div class="space-y-4">
                    @foreach($recentMessages as $msg)
                        <div class="bg-slate-50 border border-slate-100 p-4 rounded-xl space-y-3">
                            <div class="flex items-center justify-between">
                                <div>
                                    <span class="font-bold text-slate-900 text-xs block">{{ $msg->name }}</span>
                                    <span class="text-xxs text-slate-400 block">{{ $msg->created_at->diffForHumans() }}</span>
                                </div>
                                <span class="bg-sky-100/70 border border-sky-200/50 text-sky-800 text-[10px] px-2.5 py-1 rounded-md font-bold max-w-[150px] truncate">{{ $msg->subject ?? __('messages.no_subject') }}</span>
                            </div>
                            <p class="text-xs text-slate-600 leading-relaxed line-clamp-2">{{ $msg->message }}</p>
                            
                            <!-- Action buttons -->
                            <div class="flex items-center gap-2 pt-2 border-t border-slate-100/50">
                                <a href="{{ route('admin.contacts.show', $msg->id) }}" class="bg-sky-500 hover:bg-sky-600 text-white font-bold text-xxs px-3 py-1.5 rounded-md shadow-sm transition-all-300">
                                    {{ __('messages.read_message') }}
                                </a>
                                <form action="{{ route('admin.contacts.destroy', $msg->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-slate-200 hover:bg-rose-500 hover:text-white text-slate-600 font-bold text-xxs px-3 py-1.5 rounded-md transition-all-300">
                                        {{ __('messages.delete') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection

@section('scripts')
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('visitorsChart').getContext('2d');
            
            // Labels and values injected from PHP
            const labels = {!! json_encode($chartLabels) !!};
            const dataValues = {!! json_encode($chartValues) !!};
            
            // Emerald gradient fill
            const gradient = ctx.createLinearGradient(0, 0, 0, 300);
            gradient.addColorStop(0, 'rgba(16, 185, 129, 0.4)');
            gradient.addColorStop(1, 'rgba(16, 185, 129, 0.0)');

            const chart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: '{{ __('messages.chart_label') }}',
                        data: dataValues,
                        borderColor: '#10b981', // Emerald 500
                        borderWidth: 3,
                        backgroundColor: gradient,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#10b981',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        pointHoverRadius: 7
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            titleFont: { family: 'Tajawal', size: 12 },
                            bodyFont: { family: 'Tajawal', size: 12 },
                            rtl: {{ app()->getLocale() == 'ar' ? 'true' : 'false' }},
                            backgroundColor: '#0f172a',
                            padding: 12,
                            cornerRadius: 12
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(241, 245, 249, 1)'
                            },
                            ticks: {
                                stepSize: 1,
                                font: { family: 'Tajawal', size: 10 }
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: { family: 'Tajawal', size: 10 }
                            }
                        }
                    }
                }
            });
        });
    </script>
@endsection
