@extends('layouts.admin')

@section('content')
<div class="space-y-6 text-sm">
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 rounded-2xl bg-emerald-500 text-white flex items-center justify-center text-3xl font-bold shadow-xl shadow-emerald-500/20 italic">
                $
            </div>
            <div>
                <h2 class="text-3xl font-bold text-gray-900 tracking-tight italic">Transaction Details</h2>
                <div class="mt-1 flex items-center gap-2">
                    <span class="text-xs font-bold text-gray-400 uppercase tracking-widest italic decoration-brand-500/50 underline">Ref: {{ $payment->transaction_id ?? 'N/A' }}</span>
                     @php
                        $statusClasses = [
                            'pending' => 'bg-amber-50 text-amber-600 border-amber-100',
                            'completed' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                            'cancelled' => 'bg-rose-50 text-rose-600 border-rose-100',
                        ];
                        $class = $statusClasses[$payment->status] ?? 'bg-gray-50 text-gray-600 border-gray-100';
                    @endphp
                    <span class="inline-flex items-center px-2 py-0.5 rounded-lg text-[10px] font-bold uppercase tracking-widest border {{ $class }} italic">
                        {{ $payment->status }}
                    </span>
                </div>
            </div>
        </div>
        <div class="flex gap-3">
             <a href="{{ route('payments.edit', [$company->slug, $payment->id]) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 text-gray-700 text-sm font-bold rounded-xl hover:bg-gray-50 transition-all">
                Edit Payment
            </a>
            <a href="{{ route('payments.index', $company->slug) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 text-gray-700 text-sm font-bold rounded-xl hover:bg-gray-50 transition-all">
                Back to History
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8 space-y-8">
            <div class="space-y-6">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest italic decoration-emerald-500/30 underline">Payment Information</h3>
                <div class="grid grid-cols-2 gap-y-4">
                    <div class="text-gray-500 font-bold italic">Date</div>
                    <div class="text-gray-900 font-bold text-right italic">{{ \Carbon\Carbon::parse($payment->payment_date)->format('F d, Y') }}</div>
                    
                    <div class="text-gray-500 font-bold italic">Method</div>
                    <div class="text-gray-900 font-bold text-right italic">{{ $payment->payment_method ?? 'Unknown' }}</div>
                    
                    <div class="text-gray-500 font-bold italic">Reference</div>
                    <div class="text-gray-900 font-mono text-xs text-right italic uppercase">{{ $payment->transaction_id ?? '---' }}</div>
                </div>
            </div>

            <div class="pt-8 border-t border-gray-50">
                <div class="flex justify-between items-center px-6 py-4 bg-emerald-50 rounded-2xl border border-emerald-100 italic">
                    <span class="text-emerald-700 font-bold uppercase tracking-widest text-xs">Final Amount</span>
                    <span class="text-3xl font-bold text-emerald-600 italic tracking-tighter">${{ number_format($payment->amount, 2) }}</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8 flex flex-col justify-between">
            <div class="space-y-6">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest italic decoration-indigo-500/30 underline">Linked Financials</h3>
                <div class="space-y-4">
                    <div class="p-4 rounded-xl border border-gray-50 hover:bg-gray-50/50 transition-colors">
                        <div class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-2 italic">Invoice Reference</div>
                        @if($payment->invoice)
                            <a href="{{ route('invoices.show', [$company->slug, $payment->invoice_id]) }}" class="flex justify-between items-center text-brand-500 font-bold italic">
                                {{ $payment->invoice->invoice_number }}
                                <span>View Invoice →</span>
                            </a>
                        @else
                            <span class="text-gray-400 italic">Standalone Payment</span>
                        @endif
                    </div>
                    <div class="p-4 rounded-xl border border-gray-50 hover:bg-gray-50/50 transition-colors">
                        <div class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-2 italic">Customer / Client</div>
                        @if($payment->invoice && $payment->invoice->client)
                            <a href="{{ route('clients.show', [$company->slug, $payment->invoice->client_id]) }}" class="flex justify-between items-center text-gray-900 font-bold italic">
                                {{ $payment->invoice->client->name }}
                                <span>View Profile →</span>
                            </a>
                        @else
                            <span class="text-gray-400 italic">No Client Data</span>
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="mt-8 p-4 rounded-xl bg-indigo-50 italic text-indigo-700 font-medium text-xs border border-indigo-100">
                This transaction has been successfully recorded in the audit logs{{ $payment->invoice ? ' and matched against invoice #' . $payment->invoice->invoice_number : '' }}.
            </div>
        </div>
    </div>
</div>
@endsection
