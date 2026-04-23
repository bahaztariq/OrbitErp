<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-white">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'OrbitErp') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            body {
                font-family: 'Plus Jakarta Sans', sans-serif;
            }
        </style>
    </head>
    <body class="h-full antialiased text-gray-900">
        <div class="flex flex-col min-h-screen lg:flex-row">
            <!-- Left Pane: Branded Background (Hidden on Mobile) -->
            <!-- <div class="relative hidden w-full lg:flex lg:w-1/2 bg-slate-900">
                <div class="absolute inset-0 opacity-20" style="background-image: url('https://www.transparenttextures.com/patterns/cubes.png');"></div>
                <div class="flex flex-col items-center justify-center w-full p-12 text-center text-white z-10">
                    <div class="mb-10">
                        <a href="/">
                            <x-application-logo class="w-32 h-32 fill-current text-blue-500" />
                        </a>
                    </div>
                    <h1 class="mb-6 text-5xl font-extrabold tracking-tight">OrbitErp</h1>
                    <p class="max-w-md text-xl leading-relaxed text-slate-400">
                        The ultimate enterprise resource planning platform for modern businesses. Streamline your workflow and scale with confidence.
                    </p>
                    
                    <div class="mt-12 space-y-4">
                        <div class="flex items-center space-x-3 text-sm text-slate-300">
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span>Advanced Analytics & Reporting</span>
                        </div>
                        <div class="flex items-center space-x-3 text-sm text-slate-300">
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span>Multi-tenant Isolation</span>
                        </div>
                        <div class="flex items-center space-x-3 text-sm text-slate-300">
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span>Enterprise-grade Security</span>
                        </div>
                    </div>
                </div>
                
                <div class="absolute bottom-0 left-0 right-0 h-1/2 bg-gradient-to-t from-blue-600/10 to-transparent pointer-events-none"></div>
            </div> -->

            <!-- Right Pane: Form Area -->
            <div class="flex flex-col items-center justify-center flex-1 px-6 py-12 lg:px-20 lg:py-24 bg-slate-50">
                <div class="w-full max-w-md">
                    <!-- Mobile Logo -->
                    <div class="flex justify-center mb-10 lg:hidden">
                        <a href="/">
                            <x-application-logo class="w-16 h-16 fill-current text-blue-600" />
                        </a>
                    </div>
                    
                    <div class="p-8 bg-white border border-slate-200 shadow-xl rounded-3xl">
                        {{ $slot }}
                    </div>
                    
                    <p class="mt-10 text-sm text-center text-slate-500">
                        &copy; {{ date('Y') }} OrbitErp. All rights reserved.
                    </p>
                </div>
            </div>
        </div>
    </body>
</html>
