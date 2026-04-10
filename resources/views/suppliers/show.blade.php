@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 rounded-2xl bg-brand-500 text-white flex items-center justify-center text-3xl font-bold shadow-xl shadow-brand-500/20">
                {{ substr($supplier->name, 0, 1) }}
            </div>
            <div>
                <h2 class="text-3xl font-bold text-gray-900 tracking-tight">{{ $supplier->name }}</h2>
                <div class="mt-1 flex items-center gap-2">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg bg-indigo-50 text-xs font-bold text-indigo-600 uppercase tracking-wider border border-indigo-100 italic">Preferred Vendor</span>
                    <span class="text-sm text-gray-400 font-medium">Partner for {{ $company->name }}</span>
                </div>
            </div>
        </div>
        <div class="flex gap-3">
             <a href="{{ route('suppliers.edit', [$company->slug, $supplier->id]) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 text-gray-700 text-sm font-bold rounded-xl hover:bg-gray-50 transition-all">
                Edit Vendor
            </a>
            <a href="{{ route('suppliers.index', $company->slug) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 text-gray-700 text-sm font-bold rounded-xl hover:bg-gray-50 transition-all">
                Back to Suppliers
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Vendor Profile -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 space-y-6 text-sm">
            <h3 class="text-lg font-bold text-gray-900 tracking-tight">Business Profile</h3>
            
            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1 italic">Email Address</label>
                    <p class="text-gray-900 font-bold">{{ $supplier->email }}</p>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1 italic">Phone Number</label>
                    <p class="text-gray-900 font-bold">{{ $supplier->phone ?? 'Not provided' }}</p>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1 italic">Operating Address</label>
                    <p class="text-gray-900 font-bold leading-relaxed whitespace-pre-line">
                        {{ $supplier->address }}
                        {{ $supplier->city }}{{ $supplier->state ? ', ' . $supplier->state : '' }} {{ $supplier->zip }}
                        {{ $supplier->country }}
                        @if(!$supplier->address && !$supplier->city && !$supplier->country)
                            No address provided
                        @endif
                    </p>
                </div>
            </div>

            @if($supplier->notes)
            <div class="pt-6 border-t border-gray-50">
                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2 italic">Partnership Notes</label>
                <div class="p-4 rounded-xl bg-gray-50 border border-gray-100 text-gray-700 italic leading-relaxed">
                    {{ $supplier->notes }}
                </div>
            </div>
            @endif
        </div>

        <!-- Inventory History / Stats -->
        <div class="lg:col-span-2 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Stats -->
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                    <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4 italic">Products Supplied</h4>
                    <div class="text-3xl font-bold text-gray-900">{{ $supplier->products()->count() }}</div>
                </div>
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                    <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4 italic">Total Orders</h4>
                    <div class="text-3xl font-bold text-brand-500">{{ $supplier->orders()->count() }}</div>
                </div>
            </div>

            <!-- Products List -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden text-sm">
                <div class="px-6 py-5 border-b border-gray-50 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-900 tracking-tight">Supplied Products</h3>
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
                            @forelse($supplier->products as $product)
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
                                <td colspan="3" class="py-12 text-center text-gray-400 italic">
                                    No products linked to this supplier.
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
