@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Generate Invoice</h2>
            <p class="text-sm text-gray-500 mt-1">Create a new billing statement for {{ $company->name }}.</p>
        </div>
        <a href="{{ route('invoices.index', $company->slug) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 text-gray-700 text-sm font-bold rounded-xl hover:bg-gray-50 transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back to Invoices
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden text-sm">
        <form action="{{ route('invoices.store', $company->slug) }}" method="POST" class="p-6 md:p-8 space-y-8">
            @csrf
            <input type="hidden" name="company_id" value="{{ $company->id }}">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Invoice Number -->
                <div>
                    <x-input-label for="invoice_number" value="Invoice Number" />
                    <x-text-input id="invoice_number" name="invoice_number" type="text" class="mt-1 block w-full" :value="old('invoice_number', 'INV-' . date('Ymd') . '-' . strtoupper(Str::random(4)))" required autofocus />
                    <x-input-error class="mt-2" :messages="$errors->get('invoice_number')" />
                </div>

                <!-- Status -->
                <div>
                    <x-input-label for="status" value="Status" />
                    <select id="status" name="status" class="mt-1 block w-full border-gray-200 focus:border-brand-500 focus:ring-brand-500 rounded-xl shadow-sm transition-all text-sm font-medium">
                        <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="sent" {{ old('status') == 'sent' ? 'selected' : '' }}>Sent</option>
                        <option value="paid" {{ old('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="overdue" {{ old('status') == 'overdue' ? 'selected' : '' }}>Overdue</option>
                        <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                    <x-input-error class="mt-2" :messages="$errors->get('status')" />
                </div>

                <!-- Order (Optional) -->
                <div>
                    <x-input-label for="order_id" value="Link to Order (Optional)" />
                    <select id="order_id" name="order_id" class="mt-1 block w-full border-gray-200 focus:border-brand-500 focus:ring-brand-500 rounded-xl shadow-sm transition-all text-sm font-medium">
                        <option value="">Select an order</option>
                        @foreach($orders as $order)
                            <option value="{{ $order->id }}" {{ old('order_id') == $order->id ? 'selected' : '' }}>
                                {{ $order->order_number }} (${{ number_format($order->total_amount, 2) }})
                            </option>
                        @endforeach
                    </select>
                    <x-input-error class="mt-2" :messages="$errors->get('order_id')" />
                </div>

                <!-- Client -->
                <div>
                    <x-input-label for="client_id" value="Client" />
                    <select id="client_id" name="client_id" class="mt-1 block w-full border-gray-200 focus:border-brand-500 focus:ring-brand-500 rounded-xl shadow-sm transition-all text-sm font-medium" required>
                        <option value="">Select a client</option>
                        @foreach($clients as $client)
                            <option value="{{ $client->id }}" {{ old('client_id') == $client->id ? 'selected' : '' }}>
                                {{ $client->name }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error class="mt-2" :messages="$errors->get('client_id')" />
                </div>

                <!-- Issue Date -->
                <div>
                    <x-input-label for="issue_date" value="Issue Date" />
                    <x-text-input id="issue_date" name="issue_date" type="date" class="mt-1 block w-full" :value="old('issue_date', date('Y-m-d'))" required />
                    <x-input-error class="mt-2" :messages="$errors->get('issue_date')" />
                </div>

                <!-- Due Date -->
                <div>
                    <x-input-label for="due_date" value="Due Date" />
                    <x-text-input id="due_date" name="due_date" type="date" class="mt-1 block w-full" :value="old('due_date', date('Y-m-d', strtotime('+30 days')))" required />
                    <x-input-error class="mt-2" :messages="$errors->get('due_date')" />
                </div>

                <!-- Total Amount -->
                <div>
                    <x-input-label for="total_amount" value="Total Amount ($)" />
                    <x-text-input id="total_amount" name="total_amount" type="number" step="0.01" class="mt-1 block w-full" :value="old('total_amount', '0.00')" required />
                    <x-input-error class="mt-2" :messages="$errors->get('total_amount')" />
                </div>
            </div>

            <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-50">
                <a href="{{ route('invoices.index', $company->slug) }}" class="text-sm font-bold text-gray-500 hover:text-gray-700 transition-colors">
                    Cancel
                </a>
                <x-primary-button>
                    Generate Invoice
                </x-primary-button>
            </div>
        </form>
    </div>
</div>
@endsection
