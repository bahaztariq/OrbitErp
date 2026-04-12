@extends('layouts.admin')

@section('content')
<div class="h-[calc(100vh-120px)] flex overflow-hidden bg-white rounded-3xl border border-gray-100 shadow-sm">
    <!-- Sidebar -->
    <div class="hidden md:flex w-80 lg:w-96 border-r border-gray-100 flex-col bg-gray-50/30">
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
            @foreach($conversations as $item)
                <a href="{{ route('conversations.show', [$company->slug, $item->id]) }}" 
                   class="flex items-center gap-4 p-4 hover:bg-white transition-all border-b border-gray-50/50 group {{ $item->id === $conversation->id ? 'bg-white' : '' }}">
                    <div class="relative shrink-0">
                        <div class="w-12 h-12 rounded-2xl {{ $item->id === $conversation->id ? 'bg-brand-500 text-white' : 'bg-brand-100 text-brand-600' }} flex items-center justify-center text-lg font-bold shadow-sm group-hover:bg-brand-500 group-hover:text-white transition-all">
                            {{ substr($item->display_title, 0, 1) }}
                        </div>
                        <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-500 border-2 border-white rounded-full"></div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between mb-0.5">
                            <h3 class="text-sm font-bold text-gray-900 truncate">{{ $item->display_title }}</h3>
                            <span class="text-[10px] text-gray-400 font-medium">{{ $item->updated_at->diffForHumans(null, true) }}</span>
                        </div>
                        <p class="text-xs {{ $item->id === $conversation->id ? 'text-gray-600' : 'text-gray-500' }} truncate">{{ $item->messages->first()?->message ?? 'No messages yet' }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>

    <!-- Chat Area -->
    <div class="flex-1 flex flex-col min-w-0 bg-white">
        <!-- Chat Header -->
        <div class="p-6 border-b border-gray-100 flex items-center justify-between shrink-0">
            <div class="flex items-center gap-4">
                <a href="{{ route('conversations.index', $company->slug) }}" class="md:hidden p-2 text-gray-400 hover:text-brand-500 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <div class="w-10 h-10 rounded-xl bg-brand-50 text-brand-500 flex items-center justify-center text-md font-bold shadow-sm border border-brand-100/50">
                    {{ substr($conversation->display_title, 0, 1) }}
                </div>
                <div>
                    <h2 class="text-lg font-bold text-gray-900 tracking-tight leading-tight">{{ $conversation->display_title }}</h2>
                    <div class="flex items-center gap-1.5 mt-0.5">
                        <span class="w-1.5 h-1.5 bg-green-500 rounded-full animate-pulse"></span>
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest leading-none">Active now</p>
                    </div>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <div class="flex -space-x-2 mr-4">
                    @foreach($conversation->users?->take(3) ?? [] as $user)
                        <div class="h-8 w-8 rounded-full ring-2 ring-white bg-gray-100 flex items-center justify-center text-[10px] text-gray-400 font-bold border border-gray-200" title="{{ $user->name }}">
                            {{ substr($user->name, 0, 1) }}
                        </div>
                    @endforeach
                </div>
                <button class="p-2 text-gray-400 hover:text-brand-500 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Messages Area -->
        <div class="flex-1 overflow-y-auto p-6 space-y-6 bg-gray-50/20 custom-scrollbar" id="messages-container">
            @forelse($conversation->messages as $message)
                <div class="flex {{ $message->sender_id === auth()->id() ? 'justify-end' : 'justify-start' }} group">
                    <div class="max-w-[70%] lg:max-w-[60%] space-y-1">
                        @if($message->sender_id !== auth()->id())
                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest ml-2">{{ $message->sender->name }}</span>
                        @endif
                        <div class="flex items-end gap-2 {{ $message->sender_id === auth()->id() ? 'flex-row-reverse' : '' }}">
                            <div class="px-4 py-3 rounded-2xl shadow-sm {{ $message->sender_id === auth()->id() ? 'bg-brand-500 text-white border-brand-400 rounded-tr-none' : 'bg-white text-gray-700 border border-gray-100 rounded-tl-none' }}">
                                <p class="text-sm leading-relaxed whitespace-pre-wrap">{{ $message->message }}</p>
                            </div>
                            <span class="text-[9px] text-gray-400 font-medium mb-1 shrink-0 opacity-0 group-hover:opacity-100 transition-opacity">
                                {{ $message->created_at->format('h:i A') }}
                            </span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="h-full flex flex-col items-center justify-center text-gray-400">
                    <div class="w-16 h-16 bg-gray-50 rounded-2xl flex items-center justify-center mb-4 border border-gray-100/50">
                        <svg class="w-8 h-8 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                    </div>
                    <p class="uppercase tracking-widest text-[10px] font-bold opacity-30">Archive empty. Start the discussion.</p>
                </div>
            @endforelse
        </div>

        <!-- Input Area -->
        <div class="p-6 bg-white border-t border-gray-100 shrink-0">
            <form id="message-form" action="{{ route('messages.store', $company->slug) }}" method="POST" class="flex gap-4 items-end max-w-5xl mx-auto">
                @csrf
                <input type="hidden" name="conversation_id" value="{{ $conversation->id }}">
                <div class="flex-1 relative">
                    <textarea id="message" name="message" rows="1" 
                        class="block w-full border-gray-100 bg-gray-50 focus:bg-white focus:border-brand-500 focus:ring-brand-500 rounded-2xl shadow-sm transition-all text-sm font-medium py-3.5 px-5 resize-none custom-scrollbar" 
                        placeholder="Type your message..." required
                        oninput="this.style.height = ''; this.style.height = this.scrollHeight + 'px'; if(this.scrollHeight > 200) this.style.overflowY = 'auto'; else this.style.overflowY = 'hidden';"></textarea>
                </div>
                <button type="submit" class="p-3.5 bg-brand-500 hover:bg-brand-600 text-white rounded-2xl transition-all shadow-lg shadow-brand-500/20 shrink-0">
                    <svg class="w-5 h-5 transform rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                    </svg>
                </button>
            </form>
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

@push('scripts')
<script>
    const container = document.getElementById('messages-container');
    const messageForm = document.getElementById('message-form');
    const messageInput = document.getElementById('message');
    const currentUserId = {{ auth()->id() }};
    const conversationId = {{ $conversation->id }};

    const scrollToBottom = () => {
        container.scrollTop = container.scrollHeight;
    };

    scrollToBottom();

    // Reusable function to render a message
    const renderMessage = (message) => {
        const isMe = message.sender_id === currentUserId;
        const msgHtml = `
            <div class="flex ${isMe ? 'justify-end' : 'justify-start'} group animate-in slide-in-from-${isMe ? 'right' : 'left'}-4 duration-300">
                <div class="max-w-[70%] lg:max-w-[60%] space-y-1">
                    ${!isMe ? `<span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest ml-2">${message.sender.name}</span>` : ''}
                    <div class="flex items-end gap-2 ${isMe ? 'flex-row-reverse' : ''}">
                        <div class="px-4 py-3 rounded-2xl shadow-sm ${isMe ? 'bg-brand-500 text-white border-brand-400 rounded-tr-none' : 'bg-white text-gray-700 border border-gray-100 rounded-tl-none'}">
                            <p class="text-sm leading-relaxed whitespace-pre-wrap">${message.message}</p>
                        </div>
                        <span class="text-[9px] text-gray-400 font-medium mb-1 shrink-0 opacity-0 group-hover:opacity-100 transition-opacity">
                            ${new Date(message.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}
                        </span>
                    </div>
                </div>
            </div>
        `;
        
        // Remove empty state if it exists
        const emptyState = container.querySelector('.h-full.flex.flex-col');
        if (emptyState) emptyState.remove();
        
        container.insertAdjacentHTML('beforeend', msgHtml);
        scrollToBottom();
    };

    // Handle AJAX Submission
    messageForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const content = messageInput.value.trim();
        if (!content) return;

        const formData = new FormData(messageForm);
        messageInput.value = '';
        messageInput.style.height = '';

        try {
            const response = await fetch(messageForm.action, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: formData
            });

            const result = await response.json();
            if (result.status === 'success') {
                renderMessage(result.data);
            }
        } catch (error) {
            console.error('Error sending message:', error);
            messageInput.value = content; // Restore content on error
        }
    });

    // Echo Listeners
    if (window.Echo) {
        window.Echo.private(`conversations.${conversationId}`)
            .listen('.message.sent', (event) => {
                if (event.message.sender_id !== currentUserId) {
                    renderMessage(event.message);
                }
            })
            .listen('.message.updated', (event) => {
                // Handle update
            });
    }
</script>
@endpush
@endsection
