@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="rounded-2xl border border-gray-100 bg-white shadow-sm overflow-hidden">
        <div class="px-5 py-5 border-b border-gray-100 flex justify-between items-center">
            <h3 class="text-lg font-bold text-gray-900">
                Products for <span class="text-brand-500">{{ $company->name }}</span>
            </h3>
            <a href="{{ route('products.create', $company->slug) }}" class="inline-flex items-center px-4 py-2 bg-brand-500 hover:bg-brand-600 text-white text-sm font-bold rounded-xl transition-all shadow-lg shadow-brand-500/20">
                Add Product
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50 border-b border-gray-100">
                        <th class="py-4 px-6 text-xs font-bold text-gray-400 uppercase tracking-wider">Product</th>
                        <th class="py-4 px-6 text-xs font-bold text-gray-400 uppercase tracking-wider">SKU</th>
                        <th class="py-4 px-6 text-xs font-bold text-gray-400 uppercase tracking-wider text-right">Price</th>
                        <th class="py-4 px-6 text-xs font-bold text-gray-400 uppercase tracking-wider text-center">Stock</th>
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
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="py-16 text-center text-gray-500">
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

