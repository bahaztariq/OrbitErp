@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto space-y-6 text-sm">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Update Access Token</h2>
            <p class="text-sm text-gray-500 mt-1">Modifying token pivot: {{ $permission->name }}</p>
        </div>
        <a href="{{ route('permissions.index', $company->slug) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 text-gray-700 text-sm font-bold rounded-xl hover:bg-gray-50 transition-all shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back to Registry
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden text-sm">
        <form action="{{ route('permissions.update', [$company->slug, $permission->id]) }}" method="POST" class="p-6 md:p-8 space-y-10">
            @csrf
            @method('PUT')
            
            <div class="space-y-8">
                <div>
                    <x-input-label for="name" value="Token Designation" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full text-lg font-bold tracking-tight" :value="old('name', $permission->name)" required />
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>

                <div class="space-y-4">
                    <x-input-label for="description" value="Registry Brief" />
                    <textarea id="description" name="description" rows="3" class="mt-1 block w-full border-gray-200 focus:border-brand-500 focus:ring-brand-500 rounded-xl shadow-sm transition-all text-sm font-medium">{{ old('description', $permission->description) }}</textarea>
                    <x-input-error class="mt-2" :messages="$errors->get('description')" />
                </div>
            </div>

            <div class="flex items-center justify-end gap-4 pt-8 border-t border-gray-50 uppercase tracking-widest font-bold">
                <a href="{{ route('permissions.index', $company->slug) }}" class="text-xs text-gray-400 hover:text-gray-600 transition-colors">
                    Discard Changes
                </a>
                <x-primary-button>
                    Update Token
                </x-primary-button>
            </div>
        </form>
    </div>
</div>
@endsection
