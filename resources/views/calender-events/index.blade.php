@extends('layouts.admin')

@section('content')
<div class="space-y-6 flex flex-col h-[calc(100vh-140px)]">
    <!-- Header -->
    <div class="flex items-center justify-between shrink-0">
        <div class="flex items-center gap-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Calendar</h2>
                <p class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mt-1">Resource Planning for {{ $company->name }}</p>
            </div>

            <div class="flex items-center bg-gray-100 p-1 rounded-2xl gap-1">
                <a href="{{ route('calender-events.index', [$company->slug, 'month' => $date->copy()->subMonth()->month, 'year' => $date->copy()->subMonth()->year]) }}" class="p-2 hover:bg-white hover:shadow-sm rounded-xl transition-all text-gray-500 hover:text-gray-900">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </a>
                <span class="px-4 text-xs font-black uppercase tracking-widest text-gray-900 min-w-[140px] text-center">
                    {{ $date->format('F Y') }}
                </span>
                <a href="{{ route('calender-events.index', [$company->slug, 'month' => $date->copy()->addMonth()->month, 'year' => $date->copy()->addMonth()->year]) }}" class="p-2 hover:bg-white hover:shadow-sm rounded-xl transition-all text-gray-500 hover:text-gray-900">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
            
            <a href="{{ route('calender-events.index', [$company->slug]) }}" class="px-4 py-2 bg-white border border-gray-100 rounded-xl text-[10px] font-black uppercase tracking-widest text-gray-400 hover:text-brand-500 hover:border-brand-200 transition-all shadow-sm">Today</a>
        </div>

        <div class="flex items-center gap-3">
            @can('create-calendar-events', App\Models\CalenderEvent::class)
            <a href="{{ route('calender-events.create', $company->slug) }}" class="inline-flex items-center gap-2 px-6 py-2.5 bg-brand-500 hover:bg-brand-600 text-white text-[10px] font-black uppercase tracking-widest rounded-2xl transition-all shadow-xl shadow-brand-500/20 active:scale-95">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                New Event
            </a>
            @endcan
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="flex-1 flex gap-6 min-h-0 overflow-hidden">
        
        <!-- Calendar Board -->
        <div class="flex-1 bg-white rounded-[3rem] border border-gray-100 shadow-sm flex flex-col min-w-0 overflow-hidden">
            <!-- Day Labels -->
            <div class="grid grid-cols-7 border-b border-gray-50 bg-gray-50/30">
                @foreach(['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'] as $day)
                    <div class="py-4 text-center">
                        <span class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">{{ $day }}</span>
                    </div>
                @endforeach
            </div>

            <!-- Grid -->
            <div class="flex-1 grid grid-cols-7 grid-rows-6 min-h-0 overflow-y-auto custom-scrollbar">
                @php
                    $startOfGrid = $date->copy()->startOfMonth()->startOfWeek(\Carbon\Carbon::SUNDAY);
                @endphp
                @for($i = 0; $i < 42; $i++)
                    @php 
                        $currentDate = $startOfGrid->copy()->addDays($i);
                        $dayEvents = $events->filter(function($e) use ($currentDate) {
                            return \Carbon\Carbon::parse($e->event_date)->isSameDay($currentDate);
                        });
                    @endphp
                    <div class="border-b border-r border-gray-50 p-3 flex flex-col gap-2 relative {{ $currentDate->month != $date->month ? 'bg-gray-50/20' : '' }} hover:bg-gray-50/50 transition-colors">
                        <!-- Date Number -->
                        <div class="flex justify-end pr-1">
                            <span class="text-xs font-black {{ $currentDate->isToday() ? 'w-7 h-7 bg-brand-500 text-white rounded-xl' : ($currentDate->month != $date->month ? 'text-gray-200' : 'text-gray-900') }} flex items-center justify-center transition-all">
                                {{ $currentDate->day }}
                            </span>
                        </div>

                        <!-- Events -->
                        <div class="flex-1 space-y-1 overflow-y-auto custom-scrollbar">
                            @foreach($dayEvents as $event)
                                <a href="{{ route('calender-events.show', [$company->slug, $event->id]) }}" 
                                   class="block px-3 py-1.5 bg-brand-50 border border-brand-100 rounded-xl hover:bg-brand-500 hover:text-white transition-all group/chip">
                                    <div class="flex items-center gap-1.5 overflow-hidden">
                                        <div class="w-1.5 h-1.5 rounded-full bg-brand-500 group-hover/chip:bg-white shrink-0"></div>
                                        <span class="text-[9px] font-black truncate uppercase tracking-tighter">{{ $event->title }}</span>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                        
                        <!-- Quick Add -->
                        @can('create-calendar-events', App\Models\CalenderEvent::class)
                        <a href="{{ route('calender-events.create', [$company->slug, 'date' => $currentDate->toDateString()]) }}" 
                           class="absolute inset-0 opacity-0 hover:opacity-100 flex items-center justify-center bg-brand-50/30 cursor-pointer transition-opacity pointer-events-none hover:pointer-events-auto">
                            <span class="bg-white/80 backdrop-blur-md px-3 py-1 rounded-full text-[9px] font-black text-brand-500 uppercase tracking-widest shadow-lg border border-brand-100">+ New Event</span>
                        </a>
                        @endcan
                    </div>
                @endfor
            </div>
        </div>
    </div>
</div>

<style>
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #f1f1f1; border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #e2e2e2; }
    
    /* Perfect Square Logic if needed can be added via JS, but grid-rows-6 works well for fixed layouts */
</style>
@endsection
