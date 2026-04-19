@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Billing & Invoices</h2>
            <p class="text-sm text-gray-500 mt-1">Manage billing and payment tracking for {{ $company->name }}.</p>
        </div>
        @can('create-invoices', App\Models\Invoice::class)
        <a href="{{ route('invoices.create', $company->slug) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-brand-500 hover:bg-brand-600 text-white text-sm font-bold rounded-xl transition-all shadow-lg shadow-brand-500/20">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Create Invoice
        </a>
        @endcan
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="bg-gray-50/50 border-b border-gray-100 italic">
                        <th class="py-4 px-6 text-xs font-bold text-gray-400 uppercase tracking-widest whitespace-nowrap">Invoice #</th>
                        <th class="py-4 px-6 text-xs font-bold text-gray-400 uppercase tracking-widest whitespace-nowrap">Client</th>
                        <th class="py-4 px-6 text-xs font-bold text-gray-400 uppercase tracking-widest whitespace-nowrap">Issued</th>
                        <th class="py-4 px-6 text-xs font-bold text-gray-400 uppercase tracking-widest whitespace-nowrap">Due</th>
                        <th class="py-4 px-6 text-xs font-bold text-gray-400 uppercase tracking-widest whitespace-nowrap">Status</th>
                        <th class="py-4 px-6 text-xs font-bold text-gray-400 uppercase tracking-widest whitespace-nowrap text-right">Amount</th>
                        <th class="py-4 px-6 text-xs font-bold text-gray-400 uppercase tracking-widest whitespace-nowrap text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($invoices as $invoice)
                    <tr class="group hover:bg-gray-50/50 transition-colors">
                        <td class="py-4 px-6">
                            <span class="font-bold text-gray-900 italic tracking-tighter">{{ $invoice->invoice_number }}</span>
                        </td>
                        <td class="py-4 px-6">
                            <div class="font-medium text-gray-700">{{ $invoice->client->name }}</div>
                        </td>
                        <td class="py-4 px-6 text-gray-500">
                            {{ \Carbon\Carbon::parse($invoice->issue_date)->format('M d, Y') }}
                        </td>
                        <td class="py-4 px-6 text-gray-500">
                             {{ \Carbon\Carbon::parse($invoice->due_date)->format('M d, Y') }}
                        </td>
                        <td class="py-4 px-6">
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
                        </td>
                        <td class="py-4 px-6 text-right font-bold text-gray-900">
                            ${{ number_format($invoice->total_amount, 2) }}
                        </td>
                        <td class="py-4 px-6 text-right">
                            <x-table.actions-dropdown>
                                <x-table.dropdown-item :href="route('invoices.show', [$company->slug, $invoice->id])">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    View Details
                                </x-table.dropdown-item>
                                
                                @can('update-invoices', $invoice)
                                <x-table.dropdown-item :href="route('invoices.edit', [$company->slug, $invoice->id])">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    Edit Invoice
                                </x-table.dropdown-item>
                                @endcan

                                <div class="my-1 border-t border-gray-100"></div>

                                @can('delete-invoices', $invoice)
                                <form action="{{ route('invoices.destroy', [$company->slug, $invoice->id]) }}" method="POST" onsubmit="return confirm('Move this invoice to trash?')">
                                    @csrf
                                    @method('DELETE')
                                    <x-table.dropdown-item type="submit" danger>
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
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
                            No invoices found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
