<header class="sticky top-0 z-40 flex w-full bg-white/80 backdrop-blur-lg border-b border-gray-200">
    <div class="flex grow items-center justify-between px-4 py-3 md:px-6 lg:py-3">
        <div class="flex items-center gap-4">
            <!-- Sidebar Toggle Button -->
            <button
                class="inline-flex h-10 w-10 items-center justify-center text-gray-500 rounded-lg hover:bg-gray-100 xl:hidden"
                @click="$store.sidebar.toggleMobileOpen()">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>

            <button
                class="hidden h-10 w-10 items-center justify-center text-gray-500 rounded-lg hover:bg-gray-100 xl:flex"
                @click="$store.sidebar.toggleExpanded()">
                <svg class="h-5 w-5 transition-transform duration-300" 
                     :class="{ 'rotate-180': !$store.sidebar.isExpanded }"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
                </svg>
            </button>

        </div>

        <div class="flex items-center gap-3">
            <!-- notification -->
            <x-layout.notification-dropdown />
            

            <!-- Profile Dropdown -->
            <x-layout.user-dropdown />
        </div>
    </div>
</header>
