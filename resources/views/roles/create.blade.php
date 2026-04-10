@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto space-y-6 text-sm">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Define Role Blueprint</h2>
            <p class="text-sm text-gray-500 mt-1">Establish a new security group for {{ $company->name }}.</p>
        </div>
        <a href="{{ route('roles.index', $company->slug) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 text-gray-700 text-sm font-bold rounded-xl hover:bg-gray-50 transition-all shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back to Roles
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <form action="{{ route('roles.store', $company->slug) }}" method="POST" class="p-6 md:p-8 space-y-10">
            @csrf
            <input type="hidden" name="company_id" value="{{ $company->id }}">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Name -->
                <div class="md:col-span-1">
                    <x-input-label for="name" value="Role Designation" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full text-lg font-bold tracking-tight" :value="old('name')" required autofocus placeholder="e.g. Senior Manager, Warehouse Lead" />
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>

                <!-- Slug (Automated/Hidden or Visible) -->
                <div>
                    <x-input-label for="slug" value="System Identifier (Slug)" />
                    <x-text-input id="slug" name="slug" type="text" class="mt-1 block w-full" :value="old('slug')" required placeholder="e.g. senior-manager" />
                    <x-input-error class="mt-2" :messages="$errors->get('slug')" />
                </div>

                <!-- Description -->
                <div class="md:col-span-2 space-y-4">
                    <x-input-label for="description" value="Functional Description" />
                    <textarea id="description" name="description" rows="3" class="mt-1 block w-full border-gray-200 focus:border-brand-500 focus:ring-brand-500 rounded-xl shadow-sm transition-all text-sm font-medium" placeholder="Define the primary responsibilities and constraints of this role...">{{ old('description') }}</textarea>
                    <x-input-error class="mt-2" :messages="$errors->get('description')" />
                </div>
            </div>

            <!-- Permissions Mapping -->
            <div class="space-y-6 pt-6 border-t border-gray-50">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest">Authorization Matrix</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($permissions as $permission)
                    <div class="flex items-center gap-3 p-4 rounded-2xl border border-gray-100 hover:bg-gray-50 transition-all cursor-pointer group">
                         <input type="checkbox" name="permission_ids[]" value="{{ $permission->id }}" id="perm_{{ $permission->id }}" class="rounded text-brand-500 focus:ring-brand-500 border-gray-200 transition-all">
                          <div>
                            <label for="perm_{{ $permission->id }}" class="block text-xs font-bold text-gray-900 cursor-pointer group-hover:text-brand-500 transition-colors uppercase tracking-widest">{{ $permission->name }}</label>
                            <span class="text-[9px] text-gray-400 line-clamp-1 lowercase">{{ $permission->description }}</span>
                         </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="flex items-center justify-end gap-4 pt-8 border-t border-gray-50 uppercase tracking-widest font-bold">
                <a href="{{ route('roles.index', $company->slug) }}" class="text-xs text-gray-400 hover:text-gray-600 transition-colors">
                    Cancel Blueprint
                </a>
                <x-primary-button>
                    Seal Role Definition
                </x-primary-button>
            </div>
        </form>
    </div>
</div>
@endsection
