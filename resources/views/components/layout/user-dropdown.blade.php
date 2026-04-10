<div x-data="{ open: false }" @click.away="open = false" class="relative">
    <button @click="open = !open" 
            class="flex items-center gap-3 rounded-xl border border-gray-100 p-1 pr-3 transition-colors hover:bg-gray-50 focus:outline-none focus:ring-4 focus:ring-brand-500/10">
        <div class="h-9 w-9 overflow-hidden rounded-lg bg-gray-100 flex items-center justify-center text-brand-500 font-bold border border-gray-200">
            {{ substr(Auth::user()->name, 0, 1) }}
        </div>
        <div class="hidden text-left sm:block">
            <p class="text-sm font-semibold text-gray-900 leading-none">{{ Auth::user()->name }}</p>
            <p class="mt-1 text-xs font-medium text-gray-500 leading-none">{{ Auth::user()->email }}</p>
        </div>
        <svg class="h-4 w-4 text-gray-400 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    </button>

    <div x-show="open" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="transform opacity-0 scale-95"
         x-transition:enter-end="transform opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="transform opacity-100 scale-100"
         x-transition:leave-end="transform opacity-0 scale-95"
         class="absolute right-0 mt-2 w-56 origin-top-right rounded-2xl border border-gray-100 bg-white p-2 shadow-xl focus:outline-none z-50">
        
        <div class="px-3 py-2 border-b border-gray-50 mb-1">
            <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">Account Management</p>
        </div>

        <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            My Profile
        </a>

        <hr class="my-1 border-gray-50">

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="flex w-full items-center gap-2 rounded-lg px-3 py-2 text-sm font-medium text-red-600 hover:bg-red-50 transition-colors">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                Sign Out
            </button>
        </form>
    </div>
</div>
