@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="rounded-2xl border border-gray-100 bg-white shadow-sm overflow-hidden">
        <div class="px-5 py-5 border-b border-gray-100 flex justify-between items-center">
            <h3 class="text-lg font-bold text-gray-900">
                Products for <span class="text-brand-500">{{ $company->name }}</span>
            </h3>
            @can('create', App\Models\Product::class)
            <a href="{{ route('products.create', $company->slug) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-brand-500 hover:bg-brand-600 text-white text-sm font-bold rounded-xl transition-all shadow-lg shadow-brand-500/20">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Add Product
            </a>
            @endcan
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50 border-b border-gray-100">
                        <th class="py-4 px-6 text-xs font-bold text-gray-400 uppercase tracking-wider">Product</th>
                        <th class="py-4 px-6 text-xs font-bold text-gray-400 uppercase tracking-wider">SKU</th>
                        <th class="py-4 px-6 text-xs font-bold text-gray-400 uppercase tracking-wider text-right">Price</th>
                        <th class="py-4 px-6 text-xs font-bold text-gray-400 uppercase tracking-wider text-center">Stock</th>
                        <th class="py-4 px-6 text-xs font-bold text-gray-400 uppercase tracking-wider text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($products as $product)
                    <tr class="group hover:bg-gray-50/50 transition-colors">
                        <td class="py-4 px-6">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-lg border border-gray-100 bg-white flex items-center justify-center text-brand-500 font-bold group-hover:border-brand-200 transition-colors">
                                    {{ substr($product->name, 0, 1) }}
                                </div>
                                <span class="text-sm font-bold text-gray-900">{{ $product->name }}</span>
                            </div>
                        </td>
                        <td class="py-4 px-6 text-sm text-gray-500 font-medium">
                            {{ $product->sku ?? 'No SKU' }}
                        </td>
                        <td class="py-4 px-6 text-sm font-bold text-gray-900 text-right">
                            ${{ number_format($product->price, 2) }}
                        </td>
                        <td class="py-4 px-6 text-center">
                            @php $stock = $product->stock ?? 0; @endphp
                            <span class="inline-flex px-2.5 py-1 rounded-lg text-xs font-bold {{ $stock > 10 ? 'bg-success-50 text-success-600' : 'bg-error-50 text-error-600' }}">
                                {{ $stock }} in stock
                            </span>
                        </td>
                        <td class="py-4 px-6 text-right">
                            <x-table.actions-dropdown>
                                <x-table.dropdown-item :href="route('products.show', [$company->slug, $product->id])">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    View Details
                                </x-table.dropdown-item>
                                
                                @can('update', $product)
                                <x-table.dropdown-item :href="route('products.edit', [$company->slug, $product->id])">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                    Edit Product
                                </x-table.dropdown-item>
                                @endcan

                                @can('delete', $product)
                                <form action="{{ route('products.destroy', [$company->slug, $product->id]) }}" method="POST" onsubmit="return confirm('Move this product to trash?')">
                                    @csrf
                                    @method('DELETE')
                                    <x-table.dropdown-item type="submit" danger>
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        Move to Trash
                                    </x-table.dropdown-item>
                                </form>
                                @endcan
                            </x-table.actions-dropdown>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-16 text-center text-gray-500">
                            No products found for this company.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

