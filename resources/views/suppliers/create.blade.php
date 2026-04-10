@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Add New Supplier</h2>
            <p class="text-sm text-gray-500 mt-1">Create a new vendor profile for {{ $company->name }}.</p>
        </div>
        <a href="{{ route('suppliers.index', $company->slug) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 text-gray-700 text-sm font-bold rounded-xl hover:bg-gray-50 transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back to Suppliers
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden text-sm">
        <form action="{{ route('suppliers.store', $company->slug) }}" method="POST" class="p-6 md:p-8 space-y-8">
            @csrf
            <input type="hidden" name="company_id" value="{{ $company->id }}">

            <!-- Basic Info -->
            <div class="space-y-6">
                <h3 class="text-sm font-bold text-gray-400 uppercase tracking-widest italic border-b border-gray-50 pb-2">Business Profile</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="col-span-2">
                        <x-input-label for="name" value="Supplier Name" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" required autofocus placeholder="e.g. Global Tech Solutions" />
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>
                    <div>
                        <x-input-label for="email" value="Email Address" />
                        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email')" required placeholder="vendor@example.com" />
                        <x-input-error class="mt-2" :messages="$errors->get('email')" />
                    </div>
                    <div>
                        <x-input-label for="phone" value="Phone Number" />
                        <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone')" placeholder="+1 (555) 000-0000" />
                        <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                    </div>
                </div>
            </div>

            <!-- Address Info -->
            <div class="space-y-6 pt-4">
                <h3 class="text-sm font-bold text-gray-400 uppercase tracking-widest italic border-b border-gray-50 pb-2">Operating Address</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="col-span-2">
                        <x-input-label for="address" value="Street Address" />
                        <x-text-input id="address" name="address" type="text" class="mt-1 block w-full" :value="old('address')" placeholder="456 Tech Park" />
                        <x-input-error class="mt-2" :messages="$errors->get('address')" />
                    </div>
                    <div>
                        <x-input-label for="city" value="City" />
                        <x-text-input id="city" name="city" type="text" class="mt-1 block w-full" :value="old('city')" placeholder="Austin" />
                        <x-input-error class="mt-2" :messages="$errors->get('city')" />
                    </div>
                    <div>
                        <x-input-label for="state" value="State / Province" />
                        <x-text-input id="state" name="state" type="text" class="mt-1 block w-full" :value="old('state')" placeholder="TX" />
                        <x-input-error class="mt-2" :messages="$errors->get('state')" />
                    </div>
                    <div>
                        <x-input-label for="zip" value="Zip / Postal Code" />
                        <x-text-input id="zip" name="zip" type="text" class="mt-1 block w-full" :value="old('zip')" placeholder="78701" />
                        <x-input-error class="mt-2" :messages="$errors->get('zip')" />
                    </div>
                    <div>
                        <x-input-label for="country" value="Country" />
                        <x-text-input id="country" name="country" type="text" class="mt-1 block w-full" :value="old('country')" placeholder="United States" />
                        <x-input-error class="mt-2" :messages="$errors->get('country')" />
                    </div>
                </div>
            </div>

            <!-- Notes -->
            <div class="space-y-6 pt-4">
                <h3 class="text-sm font-bold text-gray-400 uppercase tracking-widest italic border-b border-gray-50 pb-2">Business Terms & Notes</h3>
                <div>
                    <x-input-label for="notes" value="Internal Note" />
                    <textarea id="notes" name="notes" rows="4" class="mt-1 block w-full border-gray-200 focus:border-brand-500 focus:ring-brand-500 rounded-xl shadow-sm transition-all text-sm font-medium" placeholder="Payment terms, lead times, or general notes...">{{ old('notes') }}</textarea>
                    <x-input-error class="mt-2" :messages="$errors->get('notes')" />
                </div>
            </div>

            <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-50">
                <a href="{{ route('suppliers.index', $company->slug) }}" class="text-sm font-bold text-gray-500 hover:text-gray-700 transition-colors">
                    Cancel
                </a>
                <x-primary-button>
                    Create Supplier
                </x-primary-button>
            </div>
        </form>
    </div>
</div>
@endsection
