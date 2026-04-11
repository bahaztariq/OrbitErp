@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
        <!-- Revenue Card -->
        <div class="group relative overflow-hidden rounded-2xl border border-gray-100 bg-white p-6 shadow-sm transition-all hover:shadow-md">
            <div class="flex items-center justify-between mb-4">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 transition-colors group-hover:bg-emerald-500 group-hover:text-white">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <span class="text-[10px] font-bold text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-full uppercase tracking-widest">Revenue</span>
            </div>
            <p class="text-sm font-medium text-gray-500">Total Revenue</p>
            <h4 class="mt-1 text-2xl font-black text-gray-900">${{ number_format($stats['total_revenue'], 2) }}</h4>
        </div>

        <!-- Clients Card -->
        <div class="group relative overflow-hidden rounded-2xl border border-gray-100 bg-white p-6 shadow-sm transition-all hover:shadow-md">
            <div class="flex items-center justify-between mb-4">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 text-blue-600 transition-colors group-hover:bg-blue-500 group-hover:text-white">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <span class="text-[10px] font-bold text-blue-600 bg-blue-50 px-2.5 py-1 rounded-full uppercase tracking-widest">Active</span>
            </div>
            <p class="text-sm font-medium text-gray-500">Total Clients</p>
            <h4 class="mt-1 text-2xl font-black text-gray-900">{{ $stats['clients_count'] }}</h4>
        </div>

        <!-- Invoices Card -->
        <div class="group relative overflow-hidden rounded-2xl border border-gray-100 bg-white p-6 shadow-sm transition-all hover:shadow-md">
            <div class="flex items-center justify-between mb-4">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-purple-50 text-purple-600 transition-colors group-hover:bg-purple-500 group-hover:text-white">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <span class="text-[10px] font-bold text-purple-600 bg-purple-50 px-2.5 py-1 rounded-full uppercase tracking-widest">Billing</span>
            </div>
            <p class="text-sm font-medium text-gray-500">Total Invoices</p>
            <h4 class="mt-1 text-2xl font-black text-gray-900">{{ $stats['invoices_count'] }}</h4>
        </div>

        <!-- Products Card -->
        <div class="group relative overflow-hidden rounded-2xl border border-gray-100 bg-white p-6 shadow-sm transition-all hover:shadow-md">
            <div class="flex items-center justify-between mb-4">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-amber-50 text-amber-600 transition-colors group-hover:bg-amber-500 group-hover:text-white">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
                <span class="text-[10px] font-bold text-amber-600 bg-amber-50 px-2.5 py-1 rounded-full uppercase tracking-widest">Inventory</span>
            </div>
            <p class="text-sm font-medium text-gray-500">Active Products</p>
            <h4 class="mt-1 text-2xl font-black text-gray-900">{{ $stats['products_count'] }}</h4>
        </div>
    </div>

    <!-- Charts and Secondary Info -->
    <!-- Charts Row 1: Revenue -->
    <div class="grid grid-cols-1 gap-8">
        <!-- Revenue Chart -->
        <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
            <div class="flex items-center justify-between mb-8">
                <h3 class="font-black text-gray-900 text-lg uppercase tracking-tight">Financial Overview</h3>
                <span class="flex items-center gap-1.5 text-[10px] font-bold text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-lg uppercase tracking-wider">
                    Revenue
                </span>
            </div>
            <div class="relative h-[300px]">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Charts Row 2: Analytics -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Client Growth -->
        <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
            <h3 class="font-black text-gray-900 text-sm uppercase tracking-tight mb-8">Client Acquisition</h3>
            <div class="relative h-[250px]">
                <canvas id="clientGrowthChart"></canvas>
            </div>
        </div>

        <!-- Order Distribution -->
        <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
            <h3 class="font-black text-gray-900 text-sm uppercase tracking-tight mb-8">Order Fulfillment</h3>
            <div class="relative h-[250px]">
                <canvas id="orderStatusChart"></canvas>
            </div>
        </div>

        <!-- Invoice Status -->
        <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
            <h3 class="font-black text-gray-900 text-sm uppercase tracking-tight mb-8">Payment Health</h3>
            <div class="relative h-[250px]">
                <canvas id="invoiceStatusChart"></canvas>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const defaultLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

        // --- Revenue Chart (Line) ---
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        const revData = @json($monthlyRevenue);
        const revLabels = revData.length ? revData.map(item => {
            const date = new Date(item.month + '-01');
            return date.toLocaleString('default', { month: 'short' });
        }) : defaultLabels;
        const revTotals = revData.length ? revData.map(item => item.total) : [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

        new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: revLabels,
                datasets: [{
                    label: 'Revenue',
                    data: revTotals,
                    borderColor: '#465fff',
                    backgroundColor: 'rgba(70, 95, 255, 0.05)',
                    borderWidth: 4,
                    tension: 0.4,
                    fill: true,
                    pointRadius: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, grid: { color: '#f3f4f6', drawBorder: false } },
                    x: { grid: { display: false } }
                }
            }
        });

        // --- Client Growth (Bar) ---
        const clientCtx = document.getElementById('clientGrowthChart').getContext('2d');
        const cgData = @json($clientGrowth);
        const cgLabels = cgData.length ? cgData.map(item => {
            const date = new Date(item.month + '-01');
            return date.toLocaleString('default', { month: 'short' });
        }) : defaultLabels;
        const cgTotals = cgData.length ? cgData.map(item => item.count) : [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

        new Chart(clientCtx, {
            type: 'bar',
            data: {
                labels: cgLabels,
                datasets: [{
                    label: 'New Clients',
                    data: cgTotals,
                    backgroundColor: '#3b82f6',
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, grid: { color: '#f3f4f6', drawBorder: false } },
                    x: { grid: { display: false } }
                }
            }
        });

        // --- Order Status (Pie) ---
        const orderCtx = document.getElementById('orderStatusChart').getContext('2d');
        const osData = @json($orderStatusDist);
        const osLabels = osData.length ? osData.map(item => item.status) : ['No Data'];
        const osTotals = osData.length ? osData.map(item => item.count) : [1];

        new Chart(orderCtx, {
            type: 'pie',
            data: {
                labels: osLabels,
                datasets: [{
                    data: osTotals,
                    backgroundColor: ['#f59e0b', '#10b981', '#ef4444', '#6366f1', '#8b5cf6']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom', labels: { usePointStyle: true, font: { size: 10, weight: 'bold' } } }
                }
            }
        });

        // --- Invoice Status (Doughnut) ---
        const invoiceCtx = document.getElementById('invoiceStatusChart').getContext('2d');
        const isData = @json($invoiceStatusDist);
        const isLabels = isData.length ? isData.map(item => item.status) : ['No Data'];
        const isTotals = isData.length ? isData.map(item => item.count) : [1];

        new Chart(invoiceCtx, {
            type: 'doughnut',
            data: {
                labels: isLabels,
                datasets: [{
                    data: isTotals,
                    backgroundColor: ['#10b981', '#fbbf24', '#f87171', '#9333ea'],
                    borderWidth: 0,
                    cutout: '70%'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom', labels: { usePointStyle: true, font: { size: 10, weight: 'bold' } } }
                }
            }
        });
    });
</script>
@endpush
@endsection
