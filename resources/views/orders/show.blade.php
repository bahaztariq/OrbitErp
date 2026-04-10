@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 rounded-2xl bg-brand-500 text-white flex items-center justify-center text-3xl font-bold shadow-xl shadow-brand-500/20">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
            </div>
            <div>
                <h2 class="text-3xl font-bold text-gray-900 tracking-tight">Order #{{ $order->order_number }}</h2>
                <div class="mt-1 flex items-center gap-2">
                    @php
                        $statusClasses = [
                            'pending' => 'bg-amber-50 text-amber-600 border-amber-100',
                            'processing' => 'bg-indigo-50 text-indigo-600 border-indigo-100',
                            'shipped' => 'bg-blue-50 text-blue-600 border-blue-100',
                            'delivered' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                            'cancelled' => 'bg-rose-50 text-rose-600 border-rose-100',
                        ];
                        $class = $statusClasses[$order->status] ?? 'bg-gray-50 text-gray-600 border-gray-100';
                    @endphp
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-xs font-bold uppercase tracking-wider border {{ $class }} italic">
                        {{ $order->status }}
                    </span>
                    <span class="text-sm text-gray-400 font-medium whitespace-nowrap">Placed on {{ \Carbon\Carbon::parse($order->order_date)->format('M d, Y') }}</span>
                </div>
            </div>
        </div>
        <div class="flex gap-3">
             <a href="{{ route('orders.edit', [$company->slug, $order->id]) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 text-gray-700 text-sm font-bold rounded-xl hover:bg-gray-50 transition-all">
                Edit Order
            </a>
            <a href="{{ route('orders.index', $company->slug) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 text-gray-700 text-sm font-bold rounded-xl hover:bg-gray-50 transition-all">
                Back to Orders
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Order Details -->
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 space-y-6 text-sm">
                <h3 class="text-lg font-bold text-gray-900 tracking-tight">Order Summary</h3>
                
                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-400 font-bold uppercase tracking-widest text-xs italic">Client</span>
                        <span class="text-gray-900 font-bold"><a href="{{ route('clients.show', [$company->slug, $order->client_id]) }}" class="text-brand-500 hover:underline">{{ $order->client->name }}</a></span>
                    </div>
                    @if($order->supplier)
                    <div class="flex justify-between items-center">
                        <span class="text-gray-400 font-bold uppercase tracking-widest text-xs italic">Supplier</span>
                        <span class="text-gray-900 font-bold">{{ $order->supplier->name }}</span>
                    </div>
                    @endif
                    <div class="flex justify-between items-center">
                        <span class="text-gray-400 font-bold uppercase tracking-widest text-xs italic">Expected Delivery</span>
                        <span class="text-gray-900 font-bold">{{ $order->delivery_date ? \Carbon\Carbon::parse($order->delivery_date)->format('M d, Y') : 'N/A' }}</span>
                    </div>
                    <div class="pt-4 border-t border-gray-50 flex justify-between items-center">
                        <span class="text-gray-400 font-bold uppercase tracking-widest text-xs italic">Total Amount</span>
                        <span class="text-xl font-bold text-gray-900">${{ number_format($order->total_amount, 2) }}</span>
                    </div>
                </div>

                @if($order->notes)
                <div class="pt-6 border-t border-gray-50">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2 italic">Notes</label>
                    <div class="p-4 rounded-xl bg-gray-50 border border-gray-100 text-gray-700 italic leading-relaxed">
                        {{ $order->notes }}
                    </div>
                </div>
                @endif
            </div>

            <!-- Related Tasks / Invoices Placeholder -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4 italic">Linked Invoice</h4>
                @if($order->invoice)
                    <div class="flex items-center justify-between">
                        <span class="font-bold text-gray-900">{{ $order->invoice->invoice_number }}</span>
                        <a href="{{ route('invoices.show', [$company->slug, $order->invoice->id]) }}" class="text-brand-500 font-bold hover:underline italic">Go to Invoice →</a>
                    </div>
                @else
                    <div class="text-gray-400 italic">No invoice generated.</div>
                @endif
            </div>
        </div>

        <!-- Order Items -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden text-sm">
                <div class="px-6 py-5 border-b border-gray-50 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-900 tracking-tight">Line Items</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50/50 border-b border-gray-100 italic">
                                <th class="py-4 px-6 text-xs font-bold text-gray-400 uppercase tracking-widest whitespace-nowrap">Product</th>
                                <th class="py-4 px-6 text-xs font-bold text-gray-400 uppercase tracking-widest whitespace-nowrap text-center">Qty</th>
                                <th class="py-4 px-6 text-xs font-bold text-gray-400 uppercase tracking-widest whitespace-nowrap text-right">Unit Price</th>
                                <th class="py-4 px-6 text-xs font-bold text-gray-400 uppercase tracking-widest whitespace-nowrap text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 italic font-medium">
                            @forelse($order->orderItems as $item)
                            <tr class="group hover:bg-gray-50/50 transition-colors">
                                <td class="py-4 px-6">
                                    <span class="font-bold text-gray-900 group-hover:text-brand-500 transition-colors">
                                        {{ $item->product->name }}
                                    </span>
                                </td>
                                <td class="py-4 px-6 text-center text-gray-700">
                                    {{ $item->quantity }}
                                </td>
                                <td class="py-4 px-6 text-right text-gray-700">
                                    ${{ number_format($item->price, 2) }}
                                </td>
                                <td class="py-4 px-6 text-right font-bold text-gray-900">
                                    ${{ number_format($item->quantity * $item->price, 2) }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="py-12 text-center text-gray-400 italic">
                                    No items found in this order.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                        <tfoot class="bg-gray-50/50">
                            <tr>
                                <td colspan="3" class="py-4 px-6 text-right text-xs font-bold text-gray-400 uppercase tracking-widest italic">Grand Total</td>
                                <td class="py-4 px-6 text-right font-bold text-gray-900 text-lg">${{ number_format($order->total_amount, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
