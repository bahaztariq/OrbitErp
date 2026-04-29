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
            <div class="space-y-12 pt-10 border-t border-gray-50">
                <div class="flex items-center justify-between">
                    <h3 class="text-sm font-bold text-gray-900 uppercase tracking-widest">Authorization Matrix</h3>
                    <span class="text-[10px] font-bold text-gray-400 px-3 py-1 bg-gray-50 rounded-full">Grouped by Resource</span>
                </div>

                <div class="space-y-10">
                    @foreach($permissions as $resource => $group)
                    <div class="space-y-4">
                        <div class="flex items-center gap-4">
                            <h4 class="text-xs font-black text-brand-600 uppercase tracking-widest whitespace-nowrap">{{ str_replace('-', ' ', $resource) }}</h4>
                            <div class="h-px w-full bg-gray-100"></div>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                            @foreach($group as $permission)
                            <div class="relative flex items-start p-4 rounded-xl border border-gray-100 bg-white hover:border-brand-200 hover:shadow-sm transition-all group cursor-pointer">
                                <div class="flex items-center h-5">
                                    <input type="checkbox" name="permission_ids[]" value="{{ $permission->id }}" id="perm_{{ $permission->id }}" 
                                           class="h-4 w-4 rounded text-brand-600 border-gray-300 focus:ring-brand-500 transition-all cursor-pointer">
                                </div>
                                <div class="ml-3 text-xs">
                                    <label for="perm_{{ $permission->id }}" class="font-bold text-gray-700 cursor-pointer group-hover:text-brand-700 transition-colors uppercase tracking-tight">
                                        {{ explode(' ', $permission->name)[0] }}
                                    </label>
                                    <p class="text-gray-400 mt-0.5 line-clamp-1 italic font-medium">{{ $permission->description }}</p>
                                </div>
                            </div>
                            @endforeach
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
