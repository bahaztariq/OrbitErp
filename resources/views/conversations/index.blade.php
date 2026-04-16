@extends('layouts.admin')

@section('content')
<div class="h-[calc(100vh-120px)] flex overflow-hidden bg-white rounded-3xl border border-gray-100 shadow-sm">
    <!-- Sidebar -->
    <div class="w-full md:w-80 lg:w-96 border-r border-gray-100 flex flex-col bg-gray-50/30">
        <!-- Sidebar Header -->
        <div class="p-6 border-b border-gray-100 bg-white">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold text-gray-900 tracking-tight">Messages</h2>
                <a href="{{ route('conversations.create', $company->slug) }}" class="p-2 bg-brand-50 text-brand-500 hover:bg-brand-500 hover:text-white rounded-xl transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                </a>
            </div>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </span>
                <input type="text" placeholder="Search conversations..." class="block w-full pl-10 pr-4 py-2 bg-gray-50 border-none focus:ring-2 focus:ring-brand-500 text-sm rounded-xl">
            </div>
        </div>

        <!-- Conversation List -->
        <div class="flex-1 overflow-y-auto custom-scrollbar">
            @forelse($conversations as $conversation)
                <a href="{{ route('conversations.show', [$company->slug, $conversation->id]) }}" 
                   class="flex items-center gap-4 p-4 hover:bg-white transition-all border-b border-gray-50/50 group">
                    <div class="relative shrink-0">
                        <div class="w-12 h-12 rounded-2xl bg-brand-100 text-brand-600 flex items-center justify-center text-lg font-bold shadow-sm group-hover:bg-brand-500 group-hover:text-white transition-all">
                            {{ substr($conversation->display_title, 0, 1) }}
                        </div>
                        {{-- Online status indicator if needed --}}
                        <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-500 border-2 border-white rounded-full"></div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between mb-0.5">
                            <h3 class="text-sm font-bold text-gray-900 truncate">{{ $conversation->display_title }}</h3>
                            <span class="text-[10px] text-gray-400 font-medium">{{ $conversation->updated_at->diffForHumans(null, true) }}</span>
                        </div>
                        <p class="text-xs text-gray-500 truncate">{{ $conversation->messages->first()?->message ?? 'No messages yet' }}</p>
                    </div>
                </a>
            @empty
                <div class="p-12 text-center">
                    <div class="w-16 h-16 bg-gray-100 rounded-3xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                    </div>
                    <p class="text-sm text-gray-400 font-medium">No discussions yet</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="flex-1 hidden md:flex flex-col items-center justify-center bg-gray-50/10">
        <div class="max-w-md text-center space-y-4">
            <div class="w-24 h-24 bg-brand-50 rounded-[2.5rem] flex items-center justify-center mx-auto mb-6 shadow-xl shadow-brand-500/5 ring-8 ring-brand-50/50">
                <svg class="w-10 h-10 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Select a conversation</h2>
            <p class="text-gray-500 text-sm">Choose a thread from the sidebar to view messages or start a new group discussion.</p>
            <div class="pt-4">
                <a href="{{ route('conversations.create', $company->slug) }}" class="inline-flex items-center gap-2 px-6 py-3 bg-brand-500 hover:bg-brand-600 text-white text-sm font-bold rounded-2xl transition-all shadow-lg shadow-brand-500/20">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    New Discussion
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    .custom-scrollbar::-webkit-scrollbar {
        width: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #e5e7eb;
        border-radius: 10px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #d1d5db;
    }
</style>
@endsection
