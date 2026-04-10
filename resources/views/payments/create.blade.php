@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto space-y-6 text-sm">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight italic">Record Payment</h2>
            <p class="text-xs text-gray-500 mt-1 italic font-medium uppercase tracking-widest decoration-emerald-500/50 underline">Register incoming funds for {{ $company->name }}.</p>
        </div>
        <a href="{{ route('payments.index', $company->slug) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 text-gray-700 text-sm font-bold rounded-xl hover:bg-gray-50 transition-all shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back to Payments
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <form action="{{ route('payments.store', $company->slug) }}" method="POST" class="p-6 md:p-8 space-y-8">
            @csrf
            <input type="hidden" name="company_id" value="{{ $company->id }}">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Invoice -->
                <div>
                    <x-input-label for="invoice_id" value="Select Invoice" />
                    <select id="invoice_id" name="invoice_id" class="mt-1 block w-full border-gray-200 focus:border-brand-500 focus:ring-brand-500 rounded-xl shadow-sm transition-all text-sm font-medium italic" required>
                        <option value="">Select an invoice</option>
                        @foreach($invoices as $invoice)
                            <option value="{{ $invoice->id }}" {{ (old('invoice_id') ?? request('invoice_id')) == $invoice->id ? 'selected' : '' }}>
                                {{ $invoice->invoice_number }} - {{ $invoice->client->name }} (${{ number_format($invoice->total_amount, 2) }})
                            </option>
                        @endforeach
                    </select>
                    <x-input-error class="mt-2" :messages="$errors->get('invoice_id')" />
                </div>

                <!-- Status -->
                <div>
                    <x-input-label for="status" value="Payment Status" />
                    <select id="status" name="status" class="mt-1 block w-full border-gray-200 focus:border-brand-500 focus:ring-brand-500 rounded-xl shadow-sm transition-all text-sm font-medium italic">
                        <option value="completed" {{ old('status', 'completed') == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                    <x-input-error class="mt-2" :messages="$errors->get('status')" />
                </div>

                <!-- Amount -->
                <div>
                    <x-input-label for="amount" value="Amount Paid ($)" />
                    <x-text-input id="amount" name="amount" type="number" step="0.01" class="mt-1 block w-full border-emerald-500/20 focus:border-emerald-500 focus:ring-emerald-500 font-bold text-emerald-600" :value="old('amount', '0.00')" required />
                    <x-input-error class="mt-2" :messages="$errors->get('amount')" />
                </div>

                <!-- Payment Date -->
                <div>
                    <x-input-label for="payment_date" value="Payment Date" />
                    <x-text-input id="payment_date" name="payment_date" type="date" class="mt-1 block w-full" :value="old('payment_date', date('Y-m-d'))" required />
                    <x-input-error class="mt-2" :messages="$errors->get('payment_date')" />
                </div>

                <!-- Payment Method -->
                <div>
                    <x-input-label for="payment_method" value="Payment Method" />
                    <x-text-input id="payment_method" name="payment_method" type="text" class="mt-1 block w-full" :value="old('payment_method')" placeholder="e.g. Bank Transfer, Stripe, Cash" />
                    <x-input-error class="mt-2" :messages="$errors->get('payment_method')" />
                </div>

                <!-- Transaction ID -->
                <div>
                    <x-input-label for="transaction_id" value="Transaction / Ref #" />
                    <x-text-input id="transaction_id" name="transaction_id" type="text" class="mt-1 block w-full font-mono text-xs italic" :value="old('transaction_id')" placeholder="e.g. TXN-998877" />
                    <x-input-error class="mt-2" :messages="$errors->get('transaction_id')" />
                </div>
            </div>

            <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-50 italic uppercase tracking-widest font-bold">
                <a href="{{ route('payments.index', $company->slug) }}" class="text-xs text-gray-400 hover:text-gray-600 transition-colors">
                    Discard
                </a>
                <button type="submit" class="inline-flex items-center px-6 py-3 bg-emerald-500 hover:bg-emerald-600 text-white text-xs font-bold rounded-xl transition-all shadow-lg shadow-emerald-500/20">
                    Submit Payment
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
