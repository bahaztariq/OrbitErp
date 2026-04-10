@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <!-- Metrics Grid -->
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4 lg:gap-6">
        <!-- Total Invoices -->
        <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm transition-all hover:shadow-md">
            <div class="flex items-center justify-between mb-4">
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-brand-50 text-brand-500">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <span class="text-xs font-semibold text-success-600 bg-success-50 px-2 py-1 rounded-lg">0%</span>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Total Invoices</p>
                <h4 class="mt-1 text-2xl font-bold text-gray-900">0</h4>
            </div>
        </div>

        <!-- Total Clients -->
        <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm transition-all hover:shadow-md">
            <div class="flex items-center justify-between mb-4">
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-brand-50 text-brand-500">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <span class="text-xs font-semibold text-success-600 bg-success-50 px-2 py-1 rounded-lg">0%</span>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Total Clients</p>
                <h4 class="mt-1 text-2xl font-bold text-gray-900">0</h4>
            </div>
        </div>

        <!-- Total Revenue -->
        <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm transition-all hover:shadow-md">
            <div class="flex items-center justify-between mb-4">
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-brand-50 text-brand-500">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <span class="text-xs font-semibold text-success-600 bg-success-50 px-2 py-1 rounded-lg">$0%</span>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Total Revenue</p>
                <h4 class="mt-1 text-2xl font-bold text-gray-900">$0</h4>
            </div>
        </div>

        <!-- Active Products -->
        <div class="rounded-2xl border border-gray-100 bg-white p-5 shadow-sm transition-all hover:shadow-md">
            <div class="flex items-center justify-between mb-4">
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-brand-50 text-brand-500">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
                <span class="text-xs font-semibold text-success-600 bg-success-50 px-2 py-1 rounded-lg">0%</span>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Active Products</p>
                <h4 class="mt-1 text-2xl font-bold text-gray-900">0</h4>
            </div>
        </div>
    </div>

    <!-- Quick Actions and Featured Card -->
    <div class="grid grid-cols-1 gap-4 lg:grid-cols-3 lg:gap-6">
        <div class="lg:col-span-2 rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Quick Actions</h3>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                @php
                    $actions = $actions ?? [
                        ['label' => 'New Invoice', 'route' => 'invoices.create', 'icon' => 'M12 4v16m8-8H4', 'color' => 'brand'],
                        ['label' => 'New Client', 'route' => 'clients.create', 'icon' => 'M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z', 'color' => 'blue'],
                        ['label' => 'Add Product', 'route' => 'products.create', 'icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4', 'color' => 'success'],
                        ['label' => 'Config', 'route' => 'profile.edit', 'icon' => 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z', 'color' => 'gray'],
                    ];
                @endphp

                @foreach($actions as $action)
                @php
                    $route = Route::has($action['route']) ? route($action['route'], $company->slug ?? 'default') : '#';
                @endphp
                <a href="{{ $route }}" class="group flex flex-col items-center justify-center p-4 rounded-2xl border border-gray-50 bg-gray-50 hover:bg-white hover:border-brand-500 hover:shadow-lg hover:shadow-brand-500/10 transition-all duration-300">
                    <div class="h-12 w-12 rounded-xl bg-white border border-gray-100 flex items-center justify-center text-gray-500 group-hover:text-brand-500 transition-colors">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $action['icon'] }}" />
                        </svg>
                    </div>
                    <span class="mt-3 text-xs font-bold text-gray-700">{{ $action['label'] }}</span>
                </a>
                @endforeach
            </div>
        </div>

        <!-- Promo/Upgrade Card -->
        <div class="rounded-2xl border border-gray-100 bg-brand-500 p-6 shadow-sm relative overflow-hidden group">
            <div class="relative z-10">
                <h3 class="text-lg font-bold text-white mb-2">Upgrade to Pro</h3>
                <p class="text-white/80 text-sm mb-6">Get advanced reporting and more company seats with our Pro plan.</p>
                <button class="w-full bg-white text-brand-500 font-bold py-3 rounded-xl hover:bg-brand-50 transition-colors shadow-lg shadow-black/5">Learn More</button>
            </div>
            <!-- Decorative background element -->
            <div class="absolute -right-12 -bottom-12 h-64 w-64 rounded-full bg-white/10 group-hover:scale-110 transition-transform duration-500"></div>
            <div class="absolute -left-8 -top-8 h-24 w-24 rounded-full bg-white/5 blur-xl"></div>
        </div>
    </div>
</div>
@endsection


