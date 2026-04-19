<div class="relative" x-data="{ open: false }" @click.away="open = false">
    @php
        // Get company from variable, or from route parameter, or null
        $currentCompany = $company ?? request()->route('company');
        $currentCompanyId = is_object($currentCompany) ? $currentCompany->id : (is_scalar($currentCompany) ? $currentCompany : null);

        $allUnread = auth()->user()->unreadNotifications;
        
        $notifications = $allUnread->filter(function($n) use ($currentCompanyId) {
            $notifCompanyId = $n->data['company_id'] ?? null;
            
            // 1. Show global notifications (company_id is null)
            if ($notifCompanyId === null) return true;
            
            // 2. If we have a current company context, show matching notifications 
            if ($currentCompanyId !== null) {
                return (string)$notifCompanyId === (string)$currentCompanyId;
            }
            
            // 3. Otherwise, if no company context, only show global
            return false;
        })->take(5);
        
        $unreadCount = $notifications->count();
    @endphp

    <button
        @click="open = !open"
        class="relative inline-flex h-10 w-10 items-center justify-center text-gray-500 rounded-lg hover:bg-gray-100 transition-all duration-200">
        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
        </svg>
        
        @if($unreadCount > 0)
            <span class="absolute top-2 right-2.5 flex h-2 w-2">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-red-500"></span>
            </span>
        @endif
    </button>

    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95 translate-y-2"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
        x-transition:leave-end="opacity-0 scale-95 translate-y-2"
        class="absolute right-0 mt-2 w-80 origin-top-right rounded-2xl bg-white p-2 shadow-2xl ring-1 ring-black ring-opacity-5 focus:outline-none z-50 overflow-hidden"
        style="display: none;">
        
        <div class="px-4 py-3 border-b border-gray-50 flex items-center justify-between">
            <h3 class="text-xs font-bold text-gray-900 uppercase tracking-widest">Notifications</h3>
            @if($unreadCount > 0)
                <span class="text-[10px] bg-red-50 text-red-500 px-2 py-0.5 rounded-full font-bold">{{ $unreadCount }} New</span>
            @endif
        </div>

        <div class="max-h-96 overflow-y-auto">
            @forelse($notifications as $notification)
                <a href="{{ $notification->data['url'] ?? '#' }}" class="block p-4 hover:bg-gray-50 transition-colors rounded-xl group mt-1">
                    <div class="flex gap-3">
                        <div @class([
                            'flex-shrink-0 w-8 h-8 rounded-full flex items-center justify-center',
                            'bg-green-50 text-green-500' => ($notification->data['type'] ?? '') === 'success',
                            'bg-blue-50 text-blue-500' => ($notification->data['type'] ?? '') === 'info',
                            'bg-amber-50 text-amber-500' => ($notification->data['type'] ?? '') === 'warning',
                            'bg-red-50 text-red-500' => ($notification->data['type'] ?? '') === 'error',
                            'bg-gray-50 text-gray-500' => !in_array($notification->data['type'] ?? '', ['success', 'info', 'warning', 'error']),
                        ])>
                            @switch($notification->data['type'] ?? '')
                                @case('success')
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    @break
                                @case('warning')
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.268 17c-.77 1.333.192 3 1.732 3z"/></svg>
                                    @break
                                @case('error')
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                    @break
                                @default
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            @endswitch
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-bold text-gray-900 group-hover:text-brand-500 transition-colors uppercase tracking-tight">{{ $notification->data['title'] }}</p>
                            <p class="text-[10px] text-gray-500 mt-0.5 line-clamp-2">{{ $notification->data['message'] }}</p>
                            <p class="text-[9px] text-gray-300 mt-1 uppercase font-medium">{{ $notification->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                </a>
            @empty
                <div class="p-8 text-center">
                    <div class="mb-3 flex justify-center text-gray-200">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                    </div>
                    <p class="text-xs text-gray-400 italic">No new notifications</p>
                </div>
            @endforelse
        </div>

        @if($unreadCount > 5)
            <a href="#" class="block text-center py-3 bg-gray-50 text-[10px] font-bold text-gray-500 uppercase tracking-widest hover:text-brand-500 transition-colors">
                View all notifications
            </a>
        @endif
    </div>
</div>
