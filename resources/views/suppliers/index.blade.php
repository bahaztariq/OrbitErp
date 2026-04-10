@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Suppliers</h2>
            <p class="text-sm text-gray-500 mt-1">Manage your supply chain and vendors for {{ $company->name }}.</p>
        </div>
        <a href="{{ route('suppliers.create', $company->slug) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-brand-500 hover:bg-brand-600 text-white text-sm font-bold rounded-xl transition-all shadow-lg shadow-brand-500/20">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Add Supplier
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($suppliers as $supplier)
        <div class="group bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all">
            <div class="p-6">
                <div class="flex items-start justify-between">
                    <div class="w-14 h-14 rounded-2xl bg-brand-50 text-brand-500 flex items-center justify-center font-bold text-2xl group-hover:bg-brand-500 group-hover:text-white transition-all shadow-sm">
                        {{ substr($supplier->name, 0, 1) }}
                    </div>
                    <x-table.actions-dropdown>
                        <x-table.dropdown-item :href="route('suppliers.show', [$company->slug, $supplier->id])">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            View Details
                        </x-table.dropdown-item>
                        
                        <x-table.dropdown-item :href="route('suppliers.edit', [$company->slug, $supplier->id])">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Edit Supplier
                        </x-table.dropdown-item>

                        <div class="my-1 border-t border-gray-100"></div>

                        <form action="{{ route('suppliers.destroy', [$company->slug, $supplier->id]) }}" method="POST" onsubmit="return confirm('Move this supplier to trash?')">
                            @csrf
                            @method('DELETE')
                            <x-table.dropdown-item type="button" danger>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                Move to Trash
                            </x-table.dropdown-item>
                        </form>
                    </x-table.actions-dropdown>
                </div>
                <div class="mt-4">
                    <h4 class="text-lg font-bold text-gray-900 group-hover:text-brand-500 transition-colors">{{ $supplier->name }}</h4>
                    <div class="mt-2 space-y-1.5 text-sm">
                        <div class="flex items-center gap-2 text-gray-500 font-medium italic">
                            <svg class="w-3.5 h-3.5 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            {{ $supplier->email }}
                        </div>
                        <div class="flex items-center gap-2 text-gray-500 font-medium italic">
                            <svg class="w-3.5 h-3.5 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            {{ $supplier->city ?? 'N/A' }}{{ $supplier->country ? ', ' . $supplier->country : '' }}
                        </div>
                    </div>
                </div>
                <div class="mt-6 flex items-center justify-between pt-4 border-t border-gray-50">
                    <span class="text-xs font-bold text-gray-400 uppercase tracking-widest italic">
                        {{ $supplier->products()->count() }} Products Supplied
                    </span>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full bg-white rounded-2xl border border-dashed border-gray-200 p-16 text-center">
            <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
            </div>
            <h3 class="text-lg font-bold text-gray-900">No suppliers found</h3>
            <p class="text-sm text-gray-500 mt-1">Start by adding your first vendor.</p>
            <a href="{{ route('suppliers.create', $company->slug) }}" class="mt-6 inline-flex items-center px-4 py-2 bg-brand-500 text-white text-sm font-bold rounded-xl hover:bg-brand-600 transition-all">
                Add Supplier
            </a>
        </div>
        @endforelse
    </div>
</div>
@endsection
