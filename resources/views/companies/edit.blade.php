@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="flex items-center gap-4">
        <a href="{{ route('companies.show', $company->slug) }}" class="inline-flex items-center justify-center h-10 w-10 rounded-xl bg-white border border-gray-200 text-gray-500 hover:text-brand-500 hover:border-brand-500 transition-all shadow-sm">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <h2 class="text-2xl font-bold text-gray-900">Edit Company: {{ $company->name }}</h2>
    </div>

    <div class="rounded-2xl border border-gray-100 bg-white shadow-sm overflow-hidden">
        <div class="p-6 md:p-8">
            <form action="{{ route('companies.update', $company->slug) }}" method="POST" class="space-y-6 max-w-2xl">
                @csrf
                @method('PUT')

                <!-- Name -->
                <div>
                    <x-input-label for="name" :value="__('Company Name')" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $company->name)" required autofocus placeholder="e.g. Acme Corp" />
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>

                <!-- Slug -->
                <div>
                    <x-input-label for="slug" :value="__('Slug (URL Identifier)')" />
                    <div class="mt-1 flex rounded-xl shadow-sm">
                        <span class="inline-flex items-center px-4 rounded-l-xl border border-r-0 border-gray-200 bg-gray-50 text-gray-500 text-sm">
                            /c/
                        </span>
                        <x-text-input id="slug" name="slug" type="text" class="block w-full rounded-l-none" :value="old('slug', $company->slug)" required placeholder="acme-corp" />
                    </div>
                    <p class="mt-1 text-xs text-gray-500 italic">Changing the slug will change all links to this company.</p>
                    <x-input-error class="mt-2" :messages="$errors->get('slug')" />
                </div>

                <!-- Description -->
                <div>
                    <x-input-label for="description" :value="__('Description')" />
                    <textarea id="description" name="description" rows="4" class="mt-1 block w-full rounded-xl border-gray-200 focus:border-brand-500 focus:ring-brand-500/10 placeholder:text-gray-400" placeholder="A brief description of your company...">{{ old('description', $company->description) }}</textarea>
                    <x-input-error class="mt-2" :messages="$errors->get('description')" />
                </div>

                <!-- Active Status -->
                <div class="flex items-center gap-3 p-4 rounded-xl bg-gray-50 border border-gray-100">
                    <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $company->is_active) ? 'checked' : '' }} class="h-5 w-5 rounded-lg border-gray-300 text-brand-500 focus:ring-brand-500/10">
                    <div>
                        <x-input-label for="is_active" class="!mb-0" :value="__('Is Active')" />
                        <p class="text-xs text-gray-500">Active companies are visible to members.</p>
                    </div>
                    <x-input-error class="mt-2" :messages="$errors->get('is_active')" />
                </div>

                <div class="flex items-center gap-4 pt-4">
                    <x-primary-button class="px-8 !py-3">
                        {{ __('Update Company') }}
                    </x-primary-button>
                    <a href="{{ route('companies.show', $company->slug) }}" class="text-sm font-bold text-gray-500 hover:text-gray-700 transition-colors">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
