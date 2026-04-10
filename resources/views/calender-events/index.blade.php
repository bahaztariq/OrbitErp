@extends('layouts.admin')

@section('content')
<div class="space-y-6 text-sm">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Agenda & Calendar</h2>
            <p class="text-sm text-gray-500 mt-1">Schedule and track company events for {{ $company->name }}.</p>
        </div>
        <a href="{{ route('calender-events.create', $company->slug) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-brand-500 hover:bg-brand-600 text-white text-sm font-bold rounded-xl transition-all shadow-lg shadow-brand-500/20">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Add Event
        </a>
    </div>

    <!-- Calendar Layout Placeholder -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        <div class="lg:col-span-1 space-y-4">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Upcoming Events</h3>
                <div class="space-y-4">
                    @forelse($events->where('event_date', '>=', now())->take(5) as $event)
                    <div class="flex items-start gap-3 p-3 rounded-xl hover:bg-gray-50 transition-colors border border-transparent hover:border-gray-100 group">
                        <div class="w-10 h-10 shrink-0 rounded-lg bg-indigo-50 text-indigo-500 flex flex-col items-center justify-center text-[10px]">
                            <span class="font-bold">{{ \Carbon\Carbon::parse($event->event_date)->format('d') }}</span>
                            <span class="uppercase tracking-tighter">{{ \Carbon\Carbon::parse($event->event_date)->format('M') }}</span>
                        </div>
                        <div class="min-w-0">
                            <a href="{{ route('calender-events.show', [$company->slug, $event->id]) }}" class="block font-bold text-gray-900 truncate hover:text-brand-500 transition-colors">{{ $event->title }}</a>
                            <span class="text-[10px] text-gray-400 uppercase tracking-tighter">{{ \Carbon\Carbon::parse($event->event_date)->format('h:i A') }}</span>
                        </div>
                    </div>
                    @empty
                    <div class="text-gray-400 italic text-[10px]">No upcoming events.</div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="lg:col-span-3">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50/50 border-b border-gray-100 italic">
                                <th class="py-4 px-6 text-xs font-bold text-gray-400 uppercase tracking-widest whitespace-nowrap">Event Title</th>
                                <th class="py-4 px-6 text-xs font-bold text-gray-400 uppercase tracking-widest whitespace-nowrap">Date & Time</th>
                                <th class="py-4 px-6 text-xs font-bold text-gray-400 uppercase tracking-widest whitespace-nowrap">Brief</th>
                                <th class="py-4 px-6 text-xs font-bold text-gray-400 uppercase tracking-widest whitespace-nowrap text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($events as $event)
                            <tr class="group hover:bg-gray-50/50 transition-colors">
                                <td class="py-4 px-6">
                                    <span class="font-bold text-gray-900 group-hover:text-brand-500 transition-colors">{{ $event->title }}</span>
                                </td>
                                <td class="py-4 px-6 text-gray-600 font-medium whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($event->event_date)->format('M d, Y @ h:i A') }}
                                </td>
                                <td class="py-4 px-6 text-gray-500 truncate max-w-xs">
                                    {{ Str::limit($event->description, 50) }}
                                </td>
                                <td class="py-4 px-6 text-right">
                                    <x-table.actions-dropdown>
                                        <x-table.dropdown-item :href="route('calender-events.show', [$company->slug, $event->id])">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            View Details
                                        </x-table.dropdown-item>
                                        
                                        <x-table.dropdown-item :href="route('calender-events.edit', [$company->slug, $event->id])">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                            Edit Event
                                        </x-table.dropdown-item>

                                        <div class="my-1 border-t border-gray-100"></div>

                                        <form action="{{ route('calender-events.destroy', [$company->slug, $event->id]) }}" method="POST" onsubmit="return confirm('Move this event to trash?')">
                                            @csrf
                                            @method('DELETE')
                                            <x-table.dropdown-item type="button" danger>
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                                Move to Trash
                                            </x-table.dropdown-item>
                                        </form>
                                    </x-table.actions-dropdown>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="py-16 text-center text-gray-400 italic">
                                    The calendar is currently empty.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
