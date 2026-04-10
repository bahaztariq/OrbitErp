@extends('layouts.admin')

@section('content')
<div class="h-[calc(100vh-140px)] flex flex-col space-y-4 text-sm">
    <!-- Header -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 flex items-center justify-between shrink-0">
        <div class="flex items-center gap-4">
            <a href="{{ route('conversations.index', $company->slug) }}" class="p-2 text-gray-400 hover:text-brand-500 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <div>
                <h2 class="text-xl font-bold text-gray-900 tracking-tight">{{ $conversation->title ?? 'Discussion Thread' }}</h2>
                <p class="text-[10px] text-gray-400 uppercase tracking-widest">{{ $conversation->description ?? 'Secure internal communication channel.' }}</p>
            </div>
        </div>
        <div class="flex items-center -space-x-2">
            @foreach($conversation->users?->take(5) ?? [] as $user)
                <div class="h-8 w-8 rounded-full ring-2 ring-white bg-gray-100 flex items-center justify-center text-[10px] text-gray-400 font-bold border border-gray-200" title="{{ $user->name }}">
                    {{ substr($user->name, 0, 1) }}
                </div>
            @endforeach
        </div>
    </div>

    <!-- Messages Area -->
    <div class="flex-1 bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden flex flex-col">
        <div class="flex-1 overflow-y-auto p-6 space-y-6" id="messages-container">
            @forelse($conversation->messages as $message)
                <div class="flex {{ $message->sender_id === auth()->id() ? 'justify-end' : 'justify-start' }} group">
                    <div class="max-w-[80%] space-y-1">
                        <div class="flex items-center gap-2 {{ $message->sender_id === auth()->id() ? 'flex-row-reverse' : '' }}">
                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">{{ $message->sender->name }}</span>
                            <span class="text-[8px] text-gray-300">{{ $message->created_at->format('h:i A') }}</span>
                        </div>
                        <div class="p-4 rounded-2xl shadow-sm border {{ $message->sender_id === auth()->id() ? 'bg-brand-500 text-white border-brand-400 rounded-tr-none' : 'bg-gray-50 text-gray-700 border-gray-100 rounded-tl-none' }}">
                            {!! nl2br(e($message->content)) !!}
                        </div>
                    </div>
                </div>
            @empty
                <div class="h-full flex flex-col items-center justify-center text-gray-400 italic">
                    <p class="uppercase tracking-widest text-xs font-bold opacity-30">Archive empty. Start the discussion.</p>
                </div>
            @endforelse
        </div>

        <!-- Input Area -->
        <div class="p-4 border-t border-gray-50 bg-gray-50/30 shrink-0">
            <form action="{{ route('messages.store', $company->slug) }}" method="POST" class="flex gap-4">
                @csrf
                <input type="hidden" name="conversation_id" value="{{ $conversation->id }}">
                <div class="flex-1">
                    <textarea id="content" name="content" rows="1" class="block w-full border-gray-200 focus:border-brand-500 focus:ring-brand-500 rounded-xl shadow-sm transition-all text-sm font-medium py-3 px-4 resize-none" placeholder="Type your secure message..." required></textarea>
                </div>
                <button type="submit" class="inline-flex items-center justify-center px-6 bg-brand-500 hover:bg-brand-600 text-white text-sm font-bold rounded-xl transition-all shadow-lg shadow-brand-500/20">
                    Send
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    const container = document.getElementById('messages-container');
    container.scrollTop = container.scrollHeight;
</script>
@endsection
