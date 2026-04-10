@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto space-y-6 text-sm">
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 rounded-2xl bg-brand-50 text-brand-500 flex flex-col items-center justify-center font-bold shadow-sm">
                <span class="text-2xl">{{ \Carbon\Carbon::parse($calenderEvent->event_date)->format('d') }}</span>
                <span class="text-[10px] uppercase tracking-widest">{{ \Carbon\Carbon::parse($calenderEvent->event_date)->format('M') }}</span>
            </div>
            <div>
                <h2 class="text-3xl font-bold text-gray-900 tracking-tight">{{ $calenderEvent->title }}</h2>
                <div class="mt-1 flex items-center gap-2">
                    <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">{{ \Carbon\Carbon::parse($calenderEvent->event_date)->format('h:i A') }}</span>
                    <span class="text-gray-300">|</span>
                    <span class="text-xs font-bold text-indigo-400 uppercase tracking-widest">{{ \Carbon\Carbon::parse($calenderEvent->event_date)->format('F d, Y') }}</span>
                </div>
            </div>
        </div>
        <div class="flex gap-3">
             <a href="{{ route('calender-events.edit', [$company->slug, $calenderEvent->id]) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 text-gray-700 text-sm font-bold rounded-xl hover:bg-gray-50 transition-all uppercase tracking-widest text-[10px]">
                Modify Detail
            </a>
            <a href="{{ route('calender-events.index', $company->slug) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 text-gray-700 text-sm font-bold rounded-xl hover:bg-gray-50 transition-all uppercase tracking-widest text-[10px]">
                Back Archive
            </a>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8 space-y-12">
        <div class="space-y-6">
            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest">Event Agenda & Notes</h3>
            <div class="text-lg text-gray-700 font-medium leading-relaxed border-l-4 border-brand-500 pl-6">
                @if($calenderEvent->description)
                    {!! nl2br(e($calenderEvent->description)) !!}
                @else
                    <span class="text-gray-400">No agenda details provided for this event.</span>
                @endif
            </div>
        </div>

        <div class="pt-12 border-t border-gray-50 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 rounded-full bg-gray-50 border border-gray-100 flex items-center justify-center text-gray-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002-2z" />
                    </svg>
                </div>
                <div>
                    <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest">Added To Archive</span>
                    <span class="font-bold text-gray-900 tracking-tight">{{ $calenderEvent->created_at->format('M d, Y') }}</span>
                </div>
            </div>

            <form action="{{ route('calender-events.destroy', [$company->slug, $calenderEvent->id]) }}" method="POST" onsubmit="return confirm('Cancel this event?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 bg-white border border-rose-100 text-rose-500 text-xs font-bold rounded-xl hover:bg-rose-50 transition-all uppercase tracking-widest">
                    Cancel Event
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
