@extends('layouts.admin')

@section('content')
<div class="space-y-6 text-sm">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Discussions & Channels</h2>
            <p class="text-sm text-gray-500 mt-1">Internal communication archive for {{ $company->name }}.</p>
        </div>
        <a href="{{ route('conversations.create', $company->slug) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-brand-500 hover:bg-brand-600 text-white text-sm font-bold rounded-xl transition-all shadow-lg shadow-brand-500/20">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
            </svg>
            New Group
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($conversations as $conversation)
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all group overflow-hidden flex flex-col">
            <div class="p-6 flex-1 space-y-4">
                <div class="flex items-start justify-between">
                    <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-500 flex items-center justify-center text-xl font-bold shadow-sm">
                        {{ substr($conversation->title ?? 'C', 0, 1) }}
                    </div>
                    <span class="text-[10px] text-gray-400 uppercase tracking-widest">{{ $conversation->messages->count() }} messages</span>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-900 group-hover:text-brand-500 transition-colors">{{ $conversation->title ?? 'Unnamed Thread' }}</h3>
                    <p class="text-gray-500 mt-1 line-clamp-2 text-xs">{{ $conversation->description ?? 'No context provided for this channel.' }}</p>
                </div>
                
                <div class="flex -space-x-2 overflow-hidden">
                    @foreach($conversation->participants?->take(5) ?? [] as $participant)
                        <div class="h-6 w-6 rounded-full ring-2 ring-white bg-gray-100 flex items-center justify-center text-[8px] text-gray-400 font-bold" title="{{ $participant->name }}">
                            {{ substr($participant->name, 0, 1) }}
                        </div>
                    @endforeach
                    @if(($conversation->participants?->count() ?? 0) > 5)
                        <div class="h-6 w-6 rounded-full ring-2 ring-white bg-gray-50 flex items-center justify-center text-[8px] text-gray-400 font-bold">
                            +{{ $conversation->participants->count() - 5 }}
                        </div>
                    @endif
                </div>
            </div>
            
            <div class="bg-gray-50/50 border-t border-gray-100 p-4 flex items-center justify-between text-xs font-bold">
                <span class="text-gray-400">Modified {{ $conversation->updated_at->diffForHumans() }}</span>
                <a href="{{ route('conversations.show', [$company->slug, $conversation->id]) }}" class="text-brand-500 hover:text-brand-600 transition-colors">
                    Join Thread →
                </a>
            </div>
        </div>
        @empty
        <div class="md:col-span-2 lg:col-span-3 py-24 bg-white rounded-3xl border border-dashed border-gray-200 flex flex-col items-center justify-center text-gray-400 italic">
            <svg class="w-12 h-12 mb-4 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
            </svg>
            <p>No active discussions found.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection
