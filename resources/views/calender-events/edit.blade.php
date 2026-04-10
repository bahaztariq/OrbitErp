@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto space-y-6 text-sm">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Reschedule Event</h2>
            <p class="text-sm text-gray-500 mt-1">Modifying: {{ $calenderEvent->title }}</p>
        </div>
        <a href="{{ route('calender-events.show', [$company->slug, $calenderEvent->id]) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 text-gray-700 text-sm font-bold rounded-xl hover:bg-gray-50 transition-all shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back to Event
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <form action="{{ route('calender-events.update', [$company->slug, $calenderEvent->id]) }}" method="POST" class="p-6 md:p-8 space-y-8">
            @csrf
            @method('PUT')
            <input type="hidden" name="company_id" value="{{ $company->id }}">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Title -->
                <div class="md:col-span-2">
                    <x-input-label for="title" value="Event Title" />
                    <x-text-input id="title" name="title" type="text" class="mt-1 block w-full text-lg font-bold tracking-tight" :value="old('title', $calenderEvent->title)" required />
                    <x-input-error class="mt-2" :messages="$errors->get('title')" />
                </div>

                <!-- Event Date/Time -->
                <div>
                    <x-input-label for="event_date" value="Scheduled Date & Time" />
                    <x-text-input id="event_date" name="event_date" type="datetime-local" class="mt-1 block w-full" :value="old('event_date', \Carbon\Carbon::parse($calenderEvent->event_date)->format('Y-m-d\TH:i'))" required />
                    <x-input-error class="mt-2" :messages="$errors->get('event_date')" />
                </div>
            </div>

            <!-- Description -->
            <div class="space-y-4">
                <x-input-label for="description" value="Event Brief / Agenda" />
                <textarea id="description" name="description" rows="5" class="mt-1 block w-full border-gray-200 focus:border-brand-500 focus:ring-brand-500 rounded-xl shadow-sm transition-all text-sm font-medium">{{ old('description', $calenderEvent->description) }}</textarea>
                <x-input-error class="mt-2" :messages="$errors->get('description')" />
            </div>

            <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-50 uppercase tracking-widest font-bold">
                <a href="{{ route('calender-events.show', [$company->slug, $calenderEvent->id]) }}" class="text-xs text-gray-400 hover:text-gray-600 transition-colors">
                    Cancel
                </a>
                <x-primary-button>
                    Update Event
                </x-primary-button>
            </div>
        </form>
    </div>
</div>
@endsection
