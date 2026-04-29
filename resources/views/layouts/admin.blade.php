<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Dashboard' }} | OrbitErp</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Alpine.js Store -->
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('sidebar', {
                isExpanded: localStorage.getItem('sidebarExpanded') !== null 
                    ? localStorage.getItem('sidebarExpanded') === 'true' 
                    : window.innerWidth >= 1280,
                isMobileOpen: false,

                toggleExpanded() {
                    this.isExpanded = !this.isExpanded;
                    localStorage.setItem('sidebarExpanded', this.isExpanded);
                    this.isMobileOpen = false;
                },

                toggleMobileOpen() {
                    this.isMobileOpen = !this.isMobileOpen;
                },

                setMobileOpen(val) {
                    this.isMobileOpen = val;
                }
            });
        });
    </script>
</head>

<body class="bg-white font-sans text-gray-900 antialiased"
    x-data
    x-init="
        const checkMobile = () => {
            if (window.innerWidth < 1280) {
                $store.sidebar.setMobileOpen(false);
                $store.sidebar.isExpanded = false;
            } else {
                $store.sidebar.isMobileOpen = false;
                const saved = localStorage.getItem('sidebarExpanded');
                if (saved !== null) {
                    $store.sidebar.isExpanded = saved === 'true';
                } else {
                    $store.sidebar.isExpanded = true;
                }
            }
        };
        window.addEventListener('resize', checkMobile);
    ">

    <div class="min-h-screen xl:flex">
        <!-- Backdrop for mobile -->
        <div x-show="$store.sidebar.isMobileOpen" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="$store.sidebar.setMobileOpen(false)"
             class="fixed inset-0 z-40 bg-gray-900/50 xl:hidden">
        </div>

        <x-layout.sidebar />

        <div class="flex-1"
            :class="{
                'xl:ml-[290px]': $store.sidebar.isExpanded,
                'xl:ml-[90px]': !$store.sidebar.isExpanded,
                'ml-0': $store.sidebar.isMobileOpen
            }">
            
            <x-layout.header />

            <main class="p-4 mx-auto max-w-screen-2xl md:p-6">
                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>

</html>
