<div x-data="{ open: false }" class="relative px-3 py-4">
    <button 
        @click="open = !open"
        class="flex items-center gap-3 w-full p-2 rounded-xl transition-all duration-200 hover:bg-gray-100 group"
        :class="{ 'bg-gray-100': open, 'justify-center': !$store.sidebar.isExpanded && !$store.sidebar.isHovered }"
    >
        <!-- Company Icon/Initials -->
        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white border-2 border-gray-100 text-gray-900 shadow-sm group-hover:border-brand-200 transition-all duration-300">
            <span class="text-sm font-black tracking-tighter uppercase whitespace-nowrap">
                {{ substr($company->name ?? 'Orbit', 0, 2) }}
            </span>
        </div>

        <!-- Company Info (Visible when expanded) -->
        <div x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered" 
             class="flex flex-col flex-1 items-start min-w-0"
             x-transition:enter="transition-opacity duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100">
            <div class="flex flex-col items-start gap-1 w-full justify-between">
                <span class="text-sm font-bold text-gray-900 truncate">{{ $company->name ?? 'OrbitErp' }}</span>
                <span class="text-[10px] font-medium text-gray-500 truncate w-full text-left">{{ auth()->user()->email }}</span>
            </div>
        </div>
        <div x-show="$store.sidebar.isExpanded || $store.sidebar.isHovered" class="flex items-center gap-1.5">
            <svg class="h-4 w-4 text-gray-400 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </div>
    </button>

    <!-- Notion-style Dropdown -->
    <div
        x-show="open"
        @click.away="open = false"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 translate-y-2 scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
        x-transition:leave-end="opacity-0 translate-y-2 scale-95"
        class="absolute left-3 top-full -mt-3 w-[calc(100%-24px)] rounded-2xl border border-gray-200 bg-white p-2 shadow-2xl z-[60] origin-top-left"
        style="display: none;">

        <!-- Current User Section -->
        <div class="px-3 py-2 border-b border-gray-100 mb-2">
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Current Account</p>
            <div class="flex items-center gap-2">
                <div class="h-5 w-5 rounded-full bg-brand-500 flex items-center justify-center text-[10px] font-bold text-white uppercase">
                   <p class="text-xs font-bold text-white uppercase">{{ substr(auth()->user()->name, 0, 1) }}</p>
                </div>
                <span class="text-xs font-bold text-gray-700 truncate">{{ auth()->user()->email }}</span>
            </div>
        </div>

        <!-- Workspaces List -->
        <div class="space-y-0.5 max-h-72 overflow-y-auto custom-scrollbar pr-1">
            <p class="px-3 py-1.5 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Companies</p>
            
            @foreach(auth()->user()->companies as $userCompany)
                <a href="{{ route('companies.show', $userCompany->slug) }}" 
                   class="flex items-center gap-3 p-2 rounded-xl transition-all hover:bg-gray-50 group {{ (isset($company) && $company->id === $userCompany->id) ? 'bg-gray-50' : '' }}">
                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-white border border-gray-100 font-bold text-gray-400 group-hover:text-brand-500 group-hover:border-brand-200 transition-all shadow-sm">
                        <span class="text-xs uppercase">{{ substr($userCompany->name, 0, 1) }}</span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2">
                            <p class="text-sm font-bold text-gray-900 truncate">{{ $userCompany->name }}</p>
                            @if(isset($company) && $company->id === $userCompany->id)
                                <svg class="h-4 w-4 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            @endif
                        </div>
                        <p class="text-[10px] text-gray-500 truncate">company</p>
                    </div>
                </a>
            @endforeach
        </div>

        <!-- Actions -->
        <div class="mt-2 pt-2 border-t border-gray-100">
            <a href="{{ route('companies.create') }}" class="flex items-center gap-2 px-3 py-2 rounded-xl text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-colors">
                <div class="h-6 w-6 flex items-center justify-center rounded-md border border-gray-200 text-gray-400">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                </div>
                <span class="text-xs font-bold">Add a company</span>
            </a>
            <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-3 py-2 rounded-xl text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-colors">
                <div class="h-6 w-6 flex items-center justify-center rounded-md border border-gray-200 text-gray-400">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    </svg>
                </div>
                <span class="text-xs font-bold">Settings</span>
            </a>
        </div>
    </div>
</div>


