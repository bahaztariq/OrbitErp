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
                    <x-text-input id="order_date" name="order_date" type="date" class="mt-1 block w-full" :value="old('order_date', $order->order_date)" required />
                    <x-input-error class="mt-2" :messages="$errors->get('order_date')" />
                </div>

                <!-- Delivery Date -->
                <div>
                    <x-input-label for="delivery_date" value="Expected Delivery" />
                    <x-text-input id="delivery_date" name="delivery_date" type="date" class="mt-1 block w-full" :value="old('delivery_date', $order->delivery_date)" />
                    <x-input-error class="mt-2" :messages="$errors->get('delivery_date')" />
                </div>

                <!-- Total Amount -->
                <div>
                    <x-input-label for="total_amount" value="Total Amount ($)" />
                    <x-text-input id="total_amount" name="total_amount" type="number" step="0.01" class="mt-1 block w-full" :value="old('total_amount', $order->total_amount)" required />
                    <x-input-error class="mt-2" :messages="$errors->get('total_amount')" />
                </div>
            </div>

            <!-- Notes -->
            <div class="space-y-4">
                <x-input-label for="notes" value="Order Notes" />
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
@endsection
