@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="flex flex-col gap-6 md:flex-row md:items-center md:justify-between">
        <div class="flex items-center gap-5">
            <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-brand-500 text-white shadow-xl shadow-brand-500/20 text-3xl font-bold">
                {{ substr($company->name, 0, 1) }}
            </div>
            <div>
                <h2 class="text-3xl font-bold text-gray-900 tracking-tight">{{ $company->name }}</h2>
                <div class="mt-1 flex items-center gap-2">
                    <!-- <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg bg-gray-100 text-xs font-bold text-gray-600 uppercase tracking-wider">/c/{{ $company->slug }}</span> -->
                    @if($company->is_active)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg bg-emerald-50 text-xs font-bold text-emerald-600 uppercase tracking-wider border border-emerald-100 italic">Active</span>
                    @else
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg bg-red-50 text-xs font-bold text-red-600 uppercase tracking-wider border border-red-100 italic">Inactive</span>
                    @endif
                </div>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('companies.edit', $company->slug) }}" class="inline-flex items-center px-5 py-2.5 bg-white hover:bg-gray-50 text-gray-700 text-sm font-bold rounded-xl border border-gray-200 transition-all shadow-sm">
                <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Edit Details
            </a>
            <form action="{{ route('companies.destroy', $company->slug) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this company? All data will be archived.')">
                @csrf
                @method('DELETE')
                <button type="submit" class="inline-flex items-center px-5 py-2.5 bg-red-50 hover:bg-red-500 hover:text-white text-red-600 text-sm font-bold rounded-xl border border-red-100 transition-all shadow-sm">
                    <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Delete Company
                </button>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Info -->
        <div class="lg:col-span-2 space-y-8">
            <div class="rounded-2xl border border-gray-100 bg-white shadow-sm overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100">
                    <h3 class="font-bold text-gray-900">About Company</h3>
                </div>
                <div class="p-6">
                    <div class="prose prose-sm text-gray-600 max-w-none">
                        {{ $company->description ?? 'No description provided for this company.' }}
                    </div>
                </div>
            </div>

            <!-- Quick Stats/Links -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <a href="{{ route('clients.index', $company->slug) }}" class="group rounded-2xl border border-gray-100 bg-white p-6 hover:border-brand-500 hover:shadow-xl hover:shadow-brand-500/5 transition-all duration-300">
                    <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 text-blue-500 group-hover:bg-brand-500 group-hover:text-white transition-colors">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <h4 class="font-bold text-gray-900">Clients</h4>
                    <p class="mt-1 text-sm text-gray-500 leading-tight">View and manage your customer database.</p>
                </a>

                <a href="{{ route('products.index', $company->slug) }}" class="group rounded-2xl border border-gray-100 bg-white p-6 hover:border-brand-500 hover:shadow-xl hover:shadow-brand-500/5 transition-all duration-300">
                    <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-amber-50 text-amber-500 group-hover:bg-brand-500 group-hover:text-white transition-colors">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                    <h4 class="font-bold text-gray-900">Products</h4>
                    <p class="mt-1 text-sm text-gray-500 leading-tight">Track inventory and service offerings.</p>
                </a>

                <a href="{{ route('invoices.index', $company->slug) }}" class="group rounded-2xl border border-gray-100 bg-white p-6 hover:border-brand-500 hover:shadow-xl hover:shadow-brand-500/5 transition-all duration-300">
                    <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-purple-50 text-purple-500 group-hover:bg-brand-500 group-hover:text-white transition-colors">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <h4 class="font-bold text-gray-900">Invoices</h4>
                    <p class="mt-1 text-sm text-gray-500 leading-tight">Billing and revenue management.</p>
                </a>
            </div>
        </div>

        <!-- Sidebar Info -->
        <div class="space-y-8">
            <div class="rounded-2xl border border-gray-100 bg-white shadow-sm overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100">
                    <h3 class="font-bold text-gray-900">System Info</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">Created At</span>
                        <p class="mt-1 text-sm font-medium text-gray-900">{{ $company->created_at->format('M d, Y') }}</p>
                    </div>
                    <div>
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">Last Updated</span>
                        <p class="mt-1 text-sm font-medium text-gray-900">{{ $company->updated_at->diffForHumans() }}</p>
                    </div>
                    <div>
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">Members</span>
                        <p class="mt-1 text-sm font-medium text-gray-900">{{ $company->users_count ?? $company->users()->count() }} team members</p>
                    </div>
                </div>
            </div>

            <!-- Danger Zone -->
            <!-- <div class="rounded-2xl border border-red-50 bg-white p-6">
                <h3 class="font-bold text-red-600 mb-2">Danger Zone</h3>
                <p class="text-sm text-gray-500 mb-4 italic">Deleting this company will disable all access for its members.</p>
            </div> -->
        </div>
    </div>
</div>
@endsection
