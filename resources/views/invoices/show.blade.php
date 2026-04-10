@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 rounded-2xl bg-brand-500 text-white flex items-center justify-center text-3xl font-bold shadow-xl shadow-brand-500/20">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
            <div>
                <h2 class="text-3xl font-bold text-gray-900 tracking-tight">Invoice #{{ $invoice->invoice_number }}</h2>
                <div class="mt-1 flex items-center gap-2">
                    @php
                        $statusClasses = [
                            'draft' => 'bg-gray-50 text-gray-500 border-gray-100',
                            'sent' => 'bg-blue-50 text-blue-600 border-blue-100',
                            'paid' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                            'overdue' => 'bg-rose-50 text-rose-600 border-rose-100',
                            'cancelled' => 'bg-gray-100 text-gray-400 border-gray-200',
                        ];
                        $class = $statusClasses[$invoice->status] ?? 'bg-gray-50 text-gray-600 border-gray-100';
                    @endphp
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-xs font-bold uppercase tracking-wider border {{ $class }} italic">
                        {{ $invoice->status }}
                    </span>
                    <span class="text-sm text-gray-400 font-medium italic underline decoration-brand-500/30">Issued on {{ \Carbon\Carbon::parse($invoice->issue_date)->format('M d, Y') }}</span>
                </div>
            </div>
        </div>
        <div class="flex gap-3">
             <a href="{{ route('invoices.edit', [$company->slug, $invoice->id]) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 text-gray-700 text-sm font-bold rounded-xl hover:bg-gray-50 transition-all">
                Edit Invoice
            </a>
            <a href="{{ route('invoices.index', $company->slug) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 text-gray-700 text-sm font-bold rounded-xl hover:bg-gray-50 transition-all">
                Back to Invoices
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 text-sm">
        <!-- Sidebar Info -->
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 space-y-6">
                <h3 class="text-lg font-bold text-gray-900 tracking-tight">Payment Details</h3>
                
                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-400 font-bold uppercase tracking-widest text-xs italic">Client</span>
                        <span class="text-gray-900 font-bolditalic tracking-tight underline"><a href="{{ route('clients.show', [$company->slug, $invoice->client_id]) }}">{{ $invoice->client->name }}</a></span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-400 font-bold uppercase tracking-widest text-xs italic decoration-error-500">Due Date</span>
                        <span class="text-gray-900 font-bold italic">{{ \Carbon\Carbon::parse($invoice->due_date)->format('M d, Y') }}</span>
                    </div>
                    <div class="pt-4 border-t border-gray-50 flex justify-between items-center">
                        <span class="text-gray-400 font-bold uppercase tracking-widest text-xs italic">Balance Due</span>
                        <span class="text-2xl font-bold text-gray-900">${{ number_format($invoice->total_amount - $invoice->payments()->sum('amount'), 2) }}</span>
                    </div>
                </div>

                @if($invoice->order)
                <div class="pt-6 border-t border-gray-50">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2 italic underline decoration-indigo-500/50">Linked Order</label>
                    <a href="{{ route('orders.show', [$company->slug, $invoice->order_id]) }}" class="flex items-center justify-between text-brand-500 font-bold hover:bg-brand-50 p-2 rounded-lg transition-colors">
                        {{ $invoice->order->order_number }}
                        <span>→</span>
                    </a>
                </div>
                @endif
            </div>

            <!-- Record Payment Button -->
            @if($invoice->status !== 'paid')
            <a href="{{ route('payments.create', [$company->slug, 'invoice_id' => $invoice->id]) }}" class="w-full inline-flex items-center justify-center gap-2 px-6 py-4 bg-emerald-500 hover:bg-emerald-600 text-white font-bold rounded-2xl transition-all shadow-lg shadow-emerald-500/20 italic tracking-widest uppercase text-xs">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Record Payment
            </a>
            @endif
        </div>

        <!-- Payments History -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-50 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-900 tracking-tight italic">Transaction History</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50/50 border-b border-gray-100 italic">
                                <th class="py-4 px-6 text-xs font-bold text-gray-400 uppercase tracking-widest whitespace-nowrap">Date</th>
                                <th class="py-4 px-6 text-xs font-bold text-gray-400 uppercase tracking-widest whitespace-nowrap">Method</th>
                                <th class="py-4 px-6 text-xs font-bold text-gray-400 uppercase tracking-widest whitespace-nowrap">Ref #</th>
                                <th class="py-4 px-6 text-xs font-bold text-gray-400 uppercase tracking-widest whitespace-nowrap text-right">Amount</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 font-medium">
                            @forelse($invoice->payments as $payment)
                            <tr class="group hover:bg-gray-50/50 transition-colors">
                                <td class="py-4 px-6 text-gray-900 font-bold">
                                    {{ \Carbon\Carbon::parse($payment->payment_date)->format('M d, Y') }}
                                </td>
                                <td class="py-4 px-6 text-gray-600 italic">
                                    {{ $payment->payment_method ?? 'Cash/Other' }}
                                </td>
                                <td class="py-4 px-6 text-gray-500 font-mono text-xs">
                                    {{ $payment->transaction_id ?? '---' }}
                                </td>
                                <td class="py-4 px-6 text-right font-bold text-emerald-600 italic">
                                    +${{ number_format($payment->amount, 2) }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="py-12 text-center text-gray-400 italic">
                                    No payments recorded yet.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                        <tfoot class="bg-gray-50/50">
                            <tr>
                                <td colspan="3" class="py-4 px-6 text-right text-xs font-bold text-gray-400 uppercase tracking-widest italic">Total Paid</td>
                                <td class="py-4 px-6 text-right font-bold text-emerald-600 text-lg">${{ number_format($invoice->payments()->sum('amount'), 2) }}</td>
                            </tr>
                            <tr class="border-t border-gray-100">
                                <td colspan="3" class="py-4 px-6 text-right text-xs font-bold text-gray-400 uppercase tracking-widest italic">Original Total</td>
                                <td class="py-4 px-6 text-right font-bold text-gray-900">${{ number_format($invoice->total_amount, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
