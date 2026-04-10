@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto space-y-6 text-sm">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Onboard Member</h2>
            <p class="text-sm text-gray-500 mt-1">Assign an existing platform user to {{ $company->name }}.</p>
        </div>
        <a href="{{ route('memberships.index', $company->slug) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 text-gray-700 text-sm font-bold rounded-xl hover:bg-gray-50 transition-all shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back to Workforce
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <form action="{{ route('memberships.store', $company->slug) }}" method="POST" class="p-6 md:p-8 space-y-8">
            @csrf
            <input type="hidden" name="company_id" value="{{ $company->id }}">

            <div class="space-y-6">
                <div>
                    <x-input-label for="user_id" value="Select Platform User" />
                    <select id="user_id" name="user_id" class="mt-1 block w-full border-gray-200 focus:border-brand-500 focus:ring-brand-500 rounded-xl shadow-sm transition-all text-sm font-medium py-3" required>
                        <option value="">Choose a user to onboard...</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }} ({{ $user->email }})
                            </option>
                        @endforeach
                    </select>
                    <x-input-error class="mt-2" :messages="$errors->get('user_id')" />
                </div>
                
                <div class="p-4 bg-brand-50/30 rounded-2xl border border-brand-100/50">
                    <p class="text-[10px] text-brand-600 uppercase tracking-widest leading-relaxed">
                        **Security Note**: Onboarding a user grants them access to this workspace. By default, they will have limited permissions until assigned a specific role.
                    </p>
                </div>
            </div>

            <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-50 uppercase tracking-widest font-bold">
                <a href="{{ route('memberships.index', $company->slug) }}" class="text-xs text-gray-400 hover:text-gray-600 transition-colors">
                    Discard
                </a>
                <x-primary-button>
                    Grant Access
                </x-primary-button>
            </div>
        </form>
    </div>
</div>
@endsection
