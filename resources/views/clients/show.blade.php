@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 rounded-2xl bg-brand-500 text-white flex items-center justify-center text-3xl font-bold shadow-xl shadow-brand-500/20">
                {{ substr($client->name, 0, 1) }}
            </div>
            <div>
                <h2 class="text-3xl font-bold text-gray-900 tracking-tight">{{ $client->name }}</h2>
                <div class="mt-1 flex items-center gap-2">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg bg-emerald-50 text-xs font-bold text-emerald-600 uppercase tracking-wider border border-emerald-100 italic">Active Client</span>
                    <span class="text-sm text-gray-400 font-medium">Customer for {{ $company->name }}</span>
                </div>
            </div>
        </div>
        <div class="flex gap-3">
             <a href="{{ route('clients.edit', [$company->slug, $client->id]) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 text-gray-700 text-sm font-bold rounded-xl hover:bg-gray-50 transition-all">
                Edit Profile
            </a>
            <a href="{{ route('clients.index', $company->slug) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 text-gray-700 text-sm font-bold rounded-xl hover:bg-gray-50 transition-all">
                Back to Clients
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Contact Information -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 space-y-6 text-sm">
            <h3 class="text-lg font-bold text-gray-900 tracking-tight">Contact Information</h3>
            
            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1 italic">Email Address</label>
                    <p class="text-gray-900 font-bold">{{ $client->email }}</p>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1 italic">Phone Number</label>
                    <p class="text-gray-900 font-bold">{{ $client->phone ?? 'Not provided' }}</p>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1 italic">Full Address</label>
                    <p class="text-gray-900 font-bold leading-relaxed whitespace-pre-line">
                        {{ $client->address }}
                        {{ $client->city }}{{ $client->state ? ', ' . $client->state : '' }} {{ $client->zip }}
                        {{ $client->country }}
                        @if(!$client->address && !$client->city && !$client->country)
                            No address provided
                        @endif
                    </p>
                </div>
            </div>

            @if($client->notes)
            <div class="pt-6 border-t border-gray-50">
                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2 italic">Special Notes</label>
                <div class="p-4 rounded-xl bg-orange-50 border border-orange-100 text-orange-900 italic leading-relaxed">
                    {{ $client->notes }}
                </div>
            </div>
            @endif
        </div>

        <!-- Order Statistics / History Placeholder -->
        <div class="lg:col-span-2 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Stats -->
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                    <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4 italic">Total Orders</h4>
                    <div class="text-3xl font-bold text-gray-900">{{ $client->orders()->count() }}</div>
                </div>
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                    <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4 italic">Total Spent</h4>
                    <div class="text-3xl font-bold text-brand-500">$0.00</div>
                </div>
            </div>

            <!-- Recent Orders Table -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden text-sm">
                <div class="px-6 py-5 border-b border-gray-50">
                    <h3 class="text-lg font-bold text-gray-900 tracking-tight">Recent Orders</h3>
                </div>
                <div class="p-12 text-center text-gray-400 italic">
                    <svg class="w-12 h-12 mx-auto mb-4 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    No orders recorded for this client yet.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
