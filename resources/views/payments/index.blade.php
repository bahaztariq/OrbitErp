@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Payments & Transactions</h2>
            <p class="text-sm text-gray-500 mt-1">Track incoming payments and revenue for {{ $company->name }}.</p>
        </div>
        @can('create', App\Models\Payment::class)
        <a href="{{ route('payments.create', $company->slug) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-brand-500 hover:bg-brand-600 text-white text-sm font-bold rounded-xl transition-all shadow-lg shadow-brand-500/20">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Record Payment
        </a>
        @endcan
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden text-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50 border-b border-gray-100 italic">
                        <th class="py-4 px-6 text-xs font-bold text-gray-400 uppercase tracking-widest whitespace-nowrap">Date</th>
                        <th class="py-4 px-6 text-xs font-bold text-gray-400 uppercase tracking-widest whitespace-nowrap">Invoice #</th>
                        <th class="py-4 px-6 text-xs font-bold text-gray-400 uppercase tracking-widest whitespace-nowrap">Method</th>
                        <th class="py-4 px-6 text-xs font-bold text-gray-400 uppercase tracking-widest whitespace-nowrap text-right">Amount</th>
                        <th class="py-4 px-6 text-xs font-bold text-gray-400 uppercase tracking-widest whitespace-nowrap">Ref #</th>
                         <th class="py-4 px-6 text-xs font-bold text-gray-400 uppercase tracking-widest whitespace-nowrap">Status</th>
                        <th class="py-4 px-6 text-xs font-bold text-gray-400 uppercase tracking-widest whitespace-nowrap text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 italic">
                    @forelse($payments as $payment)
                    <tr class="group hover:bg-gray-50/50 transition-colors">
                        <td class="py-4 px-6 font-bold text-gray-900">
                            {{ \Carbon\Carbon::parse($payment->payment_date)->format('M d, Y') }}
                        </td>
                        <td class="py-4 px-6">
                            @if($payment->invoice)
                                <a href="{{ route('invoices.show', [$company->slug, $payment->invoice_id]) }}" class="text-brand-500 font-bold hover:underline italic">
                                    {{ $payment->invoice->invoice_number }}
                                </a>
                            @else
                                <span class="text-gray-400 italic">No Invoice</span>
                            @endif
                        </td>
                        <td class="py-4 px-6 text-gray-600 font-medium">
                            {{ $payment->payment_method ?? '---' }}
                        </td>
                        <td class="py-4 px-6 text-right font-bold text-emerald-600 italic">
                            ${{ number_format($payment->amount, 2) }}
                        </td>
                        <td class="py-4 px-6 text-gray-500 font-mono text-xs">
                            {{ $payment->transaction_id ?? '---' }}
                        </td>
                         <td class="py-4 px-6">
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
                        </td>
                        <td class="py-4 px-6 text-right">
                            <x-table.actions-dropdown>
                                <x-table.dropdown-item :href="route('payments.show', [$company->slug, $payment->id])">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    View Receipt
                                </x-table.dropdown-item>
                                
                                @can('update', $payment)
                                <x-table.dropdown-item :href="route('payments.edit', [$company->slug, $payment->id])">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                    Edit Payment
                                </x-table.dropdown-item>
                                @endcan

                                @can('delete', $payment)
                                <form action="{{ route('payments.destroy', [$company->slug, $payment->id]) }}" method="POST" onsubmit="return confirm('Move this payment to trash?')">
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
                        <td colspan="7" class="py-16 text-center text-gray-500 italic">
                            No payments recorded yet.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
