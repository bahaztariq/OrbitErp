@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Edit Order</h2>
            <p class="text-sm text-gray-500 mt-1">Updating order #{{ $order->order_number }}.</p>
        </div>
        <a href="{{ route('orders.show', [$company->slug, $order->id]) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 text-gray-700 text-sm font-bold rounded-xl hover:bg-gray-50 transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back to Order
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden text-sm">
        <form action="{{ route('orders.update', [$company->slug, $order->id]) }}" method="POST" class="p-6 md:p-8 space-y-8">
            @csrf
            @method('PUT')
            <input type="hidden" name="company_id" value="{{ $company->id }}">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Order Number -->
                <div>
                    <x-input-label for="order_number" value="Order Number" />
                    <x-text-input id="order_number" name="order_number" type="text" class="mt-1 block w-full bg-gray-50" :value="old('order_number', $order->order_number)" readonly />
                    <x-input-error class="mt-2" :messages="$errors->get('order_number')" />
                </div>

                <!-- Status -->
                <div>
                    <x-input-label for="status" value="Status" />
                    <select id="status" name="status" class="mt-1 block w-full border-gray-200 focus:border-brand-500 focus:ring-brand-500 rounded-xl shadow-sm transition-all text-sm font-medium">
                        <option value="pending" {{ old('status', $order->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="processing" {{ old('status', $order->status) == 'processing' ? 'selected' : '' }}>Processing</option>
                        <option value="shipped" {{ old('status', $order->status) == 'shipped' ? 'selected' : '' }}>Shipped</option>
                        <option value="delivered" {{ old('status', $order->status) == 'delivered' ? 'selected' : '' }}>Delivered</option>
                        <option value="cancelled" {{ old('status', $order->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                    <x-input-error class="mt-2" :messages="$errors->get('status')" />
                </div>

                <!-- Client -->
                <div>
                    <x-input-label for="client_id" value="Client" />
                    <select id="client_id" name="client_id" class="mt-1 block w-full border-gray-200 focus:border-brand-500 focus:ring-brand-500 rounded-xl shadow-sm transition-all text-sm font-medium" required>
                        @foreach($clients as $client)
                            <option value="{{ $client->id }}" {{ old('client_id', $order->client_id) == $client->id ? 'selected' : '' }}>
                                {{ $client->name }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error class="mt-2" :messages="$errors->get('client_id')" />
                </div>

                <!-- Supplier -->
                <div>
                    <x-input-label for="supplier_id" value="Supplier" />
                    <select id="supplier_id" name="supplier_id" class="mt-1 block w-full border-gray-200 focus:border-brand-500 focus:ring-brand-500 rounded-xl shadow-sm transition-all text-sm font-medium">
                        <option value="">Select a supplier</option>
                        @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->id }}" {{ old('supplier_id', $order->supplier_id) == $supplier->id ? 'selected' : '' }}>
                                {{ $supplier->name }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error class="mt-2" :messages="$errors->get('supplier_id')" />
                </div>

                <!-- Order Date -->
                <div>
                    <x-input-label for="order_date" value="Order Date" />
                    <x-text-input id="order_date" name="order_date" type="date" class="mt-1 block w-full" :value="old('order_date', \Illuminate\Support\Carbon::parse($order->order_date)->format('Y-m-d'))" required />
                    <x-input-error class="mt-2" :messages="$errors->get('order_date')" />
                </div>

                <!-- Delivery Date -->
                <div>
                    <x-input-label for="delivery_date" value="Delivery Date" />
                    <x-text-input id="delivery_date" name="delivery_date" type="date" class="mt-1 block w-full" :value="old('delivery_date', $order->delivery_date ? \Illuminate\Support\Carbon::parse($order->delivery_date)->format('Y-m-d') : '')" />
                    <x-input-error class="mt-2" :messages="$errors->get('delivery_date')" />
                </div>

                <!-- Total Amount -->
                <div>
                    <x-input-label for="total_amount" value="Total Amount" />
                    <x-text-input id="total_amount" name="total_amount" type="number" step="0.01" class="mt-1 block w-full bg-gray-50" :value="old('total_amount', $order->total_amount)" readonly required />
                    <x-input-error class="mt-2" :messages="$errors->get('total_amount')" />
                </div>
            </div>

            <!-- Order Items Section -->
            <div class="space-y-4 pt-6 border-t border-gray-50">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-bold text-gray-900 tracking-tight">Order Items</h3>
                    <button type="button" id="add-item" class="inline-flex items-center gap-2 px-3 py-1.5 bg-brand-50 text-brand-600 text-xs font-bold rounded-lg hover:bg-brand-100 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Add Item
                    </button>
                </div>
                
                <div class="border border-gray-100 rounded-2xl overflow-hidden">
                    <table class="w-full text-left border-collapse" id="items-table">
                        <thead>
                            <tr class="bg-gray-50/50 border-b border-gray-100 italic">
                                <th class="py-3 px-4 text-xs font-bold text-gray-400 uppercase tracking-widest whitespace-nowrap">Product</th>
                                <th class="py-3 px-4 text-xs font-bold text-gray-400 uppercase tracking-widest whitespace-nowrap w-24 text-center">Qty</th>
                                <th class="py-3 px-4 text-xs font-bold text-gray-400 uppercase tracking-widest whitespace-nowrap w-32 text-right">Unit Price</th>
                                <th class="py-3 px-4 text-xs font-bold text-gray-400 uppercase tracking-widest whitespace-nowrap w-32 text-right">Total</th>
                                <th class="py-3 px-4 w-10"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 italic font-medium">
                            @foreach($order->orderItems as $index => $item)
                            <tr class="group hover:bg-gray-50/50 transition-colors item-row">
                                <td class="py-3 px-4">
                                    <select name="items[{{ $index }}][product_id]" class="product-select block w-full border-0 focus:ring-0 bg-transparent text-sm font-medium p-0" required>
                                        <option value="">Select product</option>
                                        @foreach($products as $product)
                                            <option value="{{ $product->id }}" data-price="{{ $product->price }}" {{ $item->product_id == $product->id ? 'selected' : '' }}>
                                                {{ $product->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="py-3 px-4">
                                    <input type="number" name="items[{{ $index }}][quantity]" value="{{ $item->quantity }}" min="1" class="quantity-input block w-full border-0 focus:ring-0 bg-transparent text-sm font-medium text-center p-0" required>
                                </td>
                                <td class="py-3 px-4 text-right">
                                    <div class="flex items-center justify-end">
                                        <span class="text-gray-400 text-xs mr-1">$</span>
                                        <input type="number" name="items[{{ $index }}][price]" value="{{ number_format($item->price, 2, '.', '') }}" step="0.01" min="0" class="price-input block w-32 border-0 focus:ring-0 bg-transparent text-sm font-medium text-right p-0" required>
                                    </div>
                                </td>
                                <td class="py-3 px-4 text-right font-bold text-gray-900">
                                    $<span class="line-total">{{ number_format($item->quantity * $item->price, 2, '.', '') }}</span>
                                </td>
                                <td class="py-3 px-4 text-center">
                                    <button type="button" class="remove-item text-gray-400 hover:text-rose-500 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <x-input-error class="mt-2" :messages="$errors->get('items')" />
            </div>

            <!-- Notes -->
            <div class="space-y-4">
                <x-input-label for="notes" value="Notes" />
                <textarea id="notes" name="notes" rows="4" class="mt-1 block w-full border-gray-200 focus:border-brand-500 focus:ring-brand-500 rounded-xl shadow-sm transition-all text-sm font-medium">{{ old('notes', $order->notes) }}</textarea>
                <x-input-error class="mt-2" :messages="$errors->get('notes')" />
            </div>

            <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-50">
                <a href="{{ route('orders.show', [$company->slug, $order->id]) }}" class="text-sm font-bold text-gray-500 hover:text-gray-700 transition-colors">
                    Cancel
                </a>
                <x-primary-button>
                    Update Order
                </x-primary-button>
            </div>
        </form>
    </div>
</div>

<template id="item-row-template">
    <tr class="group hover:bg-gray-50/50 transition-colors item-row">
        <td class="py-3 px-4">
            <select name="items[{index}][product_id]" class="product-select block w-full border-0 focus:ring-0 bg-transparent text-sm font-medium p-0" required>
                <option value="">Select product</option>
                @foreach($products as $product)
                    <option value="{{ $product->id }}" data-price="{{ $product->price }}">{{ $product->name }}</option>
                @endforeach
            </select>
        </td>
        <td class="py-3 px-4">
            <input type="number" name="items[{index}][quantity]" value="1" min="1" class="quantity-input block w-full border-0 focus:ring-0 bg-transparent text-sm font-medium text-center p-0" required>
        </td>
        <td class="py-3 px-4 text-right">
            <div class="flex items-center justify-end">
                <span class="text-gray-400 text-xs mr-1">$</span>
                <input type="number" name="items[{index}][price]" value="0.00" step="0.01" min="0" class="price-input block w-32 border-0 focus:ring-0 bg-transparent text-sm font-medium text-right p-0" required>
            </div>
        </td>
        <td class="py-3 px-4 text-right font-bold text-gray-900">
            $<span class="line-total">0.00</span>
        </td>
        <td class="py-3 px-4 text-center">
            <button type="button" class="remove-item text-gray-400 hover:text-rose-500 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
            </button>
        </td>
    </tr>
</template>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tableBody = document.querySelector('#items-table tbody');
        const addItemBtn = document.getElementById('add-item');
        const template = document.getElementById('item-row-template').innerHTML;
        const totalAmountInput = document.getElementById('total_amount');
        let index = {{ $order->orderItems->count() }};

        function updateGrandTotal() {
            let total = 0;
            document.querySelectorAll('.line-total').forEach(span => {
                total += parseFloat(span.textContent) || 0;
            });
            totalAmountInput.value = total.toFixed(2);
        }

        function updateLineTotal(row) {
            const qty = parseFloat(row.querySelector('.quantity-input').value) || 0;
            const price = parseFloat(row.querySelector('.price-input').value) || 0;
            const total = qty * price;
            row.querySelector('.line-total').textContent = total.toFixed(2);
            updateGrandTotal();
        }

        function setupRowListeners(row) {
            row.querySelector('.product-select').addEventListener('change', function() {
                const price = this.options[this.selectedIndex].dataset.price || 0;
                row.querySelector('.price-input').value = parseFloat(price).toFixed(2);
                updateLineTotal(row);
            });

            row.querySelector('.quantity-input').addEventListener('input', () => updateLineTotal(row));
            row.querySelector('.price-input').addEventListener('input', () => updateLineTotal(row));
            
            row.querySelector('.remove-item').addEventListener('click', function() {
                row.remove();
                updateGrandTotal();
            });
        }

        function addItem() {
            const newRowHtml = template.replace(/{index}/g, index++);
            tableBody.insertAdjacentHTML('beforeend', newRowHtml);
            const addedRow = tableBody.lastElementChild;
            setupRowListeners(addedRow);
        }

        addItemBtn.addEventListener('click', addItem);

        // Setup listeners for existing rows
        document.querySelectorAll('.item-row').forEach(row => {
            setupRowListeners(row);
        });
    });
</script>
@endsection
