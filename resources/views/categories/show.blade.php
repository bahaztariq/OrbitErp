@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 rounded-2xl bg-brand-500 text-white flex items-center justify-center text-3xl font-bold shadow-xl shadow-brand-500/20">
                {{ substr($category->name, 0, 1) }}
            </div>
            <div>
                <h2 class="text-3xl font-bold text-gray-900 tracking-tight">{{ $category->name }}</h2>
                <p class="text-sm text-gray-500 mt-1">Category overview for {{ $company->name }}.</p>
            </div>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('categories.edit', [$company->slug, $category->id]) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 text-gray-700 text-sm font-bold rounded-xl hover:bg-gray-50 transition-all">
                Edit Category
            </a>
            <a href="{{ route('categories.index', $company->slug) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 text-gray-700 text-sm font-bold rounded-xl hover:bg-gray-50 transition-all">
                Back to Categories
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Details Card -->
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">About This Category</h3>
                <p class="text-gray-600 text-sm leading-relaxed">
                    {{ $category->description ?? 'No description available for this category.' }}
                </p>
                <div class="mt-6 pt-6 border-t border-gray-50 space-y-4">
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-400 font-medium tracking-tight">Total Products</span>
                        <span class="font-bold text-gray-900">{{ $category->products()->count() }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Products List Card -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden text-sm">
                <div class="px-6 py-5 border-b border-gray-50 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-900 tracking-tight">Products in this Category</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50/50 border-b border-gray-100 italic">
                                <th class="py-4 px-6 text-xs font-bold text-gray-400 uppercase tracking-widest whitespace-nowrap">Product</th>
                                <th class="py-4 px-6 text-xs font-bold text-gray-400 uppercase tracking-widest whitespace-nowrap">SKU</th>
                                <th class="py-4 px-6 text-xs font-bold text-gray-400 uppercase tracking-widest whitespace-nowrap text-right">Price</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($category->products as $product)
                            <tr class="group hover:bg-gray-50/50 transition-colors">
                                <td class="py-4 px-6">
                                    <span class="font-bold text-gray-900 group-hover:text-brand-500 transition-colors">
                                        <a href="{{ route('products.show', [$company->slug, $product->id]) }}">
                                            {{ $product->name }}
                                        </a>
                                    </span>
                                </td>
                                <td class="py-4 px-6 text-gray-500 font-medium">
                                    {{ $product->sku }}
                                </td>
                                <td class="py-4 px-6 text-right font-bold text-gray-900">
                                    ${{ number_format($product->price, 2) }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="py-12 text-center text-gray-500 italic">
                                    No products found in this category.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
