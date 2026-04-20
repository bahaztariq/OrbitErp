@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Categories</h2>
            <p class="text-sm text-gray-500 mt-1">Manage product categories for {{ $company->name }}.</p>
        </div>
        @can('create', App\Models\Category::class)
        <a href="{{ route('categories.create', $company->slug) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-brand-500 hover:bg-brand-600 text-white text-sm font-bold rounded-xl transition-all shadow-lg shadow-brand-500/20">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Add Category
        </a>
        @endcan
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($categories as $category)
        <div class="group bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all overflow-hidden">
            <div class="p-6">
                <div class="flex items-start justify-between">
                    <div class="w-12 h-12 rounded-xl bg-brand-50 flex items-center justify-center text-brand-500 font-bold text-xl group-hover:bg-brand-500 group-hover:text-white transition-all">
                        {{ substr($category->name, 0, 1) }}
                    </div>
                    <x-table.actions-dropdown>
                        <x-table.dropdown-item :href="route('categories.show', [$company->slug, $category->id])">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            View Details
                        </x-table.dropdown-item>
                        
                        @can('update', $category)
                        <x-table.dropdown-item :href="route('categories.edit', [$company->slug, $category->id])">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                            Edit Category
                        </x-table.dropdown-item>
                        @endcan

                        @can('delete', $category)
                        <div class="my-1 border-t border-gray-100"></div>

                        <form action="{{ route('categories.destroy', [$company->slug, $category->id]) }}" method="POST" onsubmit="return confirm('Move this category to trash?')">
                            @csrf
                            @method('DELETE')
                            <x-table.dropdown-item type="submit" danger>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                Move to Trash
                            </x-table.dropdown-item>
                        </form>
                        @endcan
                    </x-table.actions-dropdown>
                </div>
                <div class="mt-4">
                    <h4 class="text-lg font-bold text-gray-900 group-hover:text-brand-500 transition-colors">{{ $category->name }}</h4>
                    <p class="text-sm text-gray-500 mt-1 line-clamp-2">{{ $category->description ?? 'No description provided.' }}</p>
                </div>
                <div class="mt-6 flex items-center justify-between pt-4 border-t border-gray-50">
                    <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">{{ $category->products_count ?? $category->products()->count() }} Products</span>
                    <a href="{{ route('categories.show', [$company->slug, $category->id]) }}" class="text-sm font-bold text-brand-500 hover:text-brand-600 transition-colors">
                        View Details →
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full bg-white rounded-2xl border border-dashed border-gray-200 p-12 text-center">
            <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                </svg>
            </div>
            <h3 class="text-lg font-bold text-gray-900">No categories found</h3>
            <p class="text-sm text-gray-500 mt-1">Start by adding your first product category.</p>
            <a href="{{ route('categories.create', $company->slug) }}" class="mt-6 inline-flex items-center px-4 py-2 bg-brand-500 text-white text-sm font-bold rounded-xl hover:bg-brand-600 transition-all">
                Add Category
            </a>
        </div>
        @endforelse
    </div>
</div>
@endsection
