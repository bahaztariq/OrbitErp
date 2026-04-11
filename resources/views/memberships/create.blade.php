@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto space-y-6 text-sm">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Invite Member</h2>
            <p class="text-sm text-gray-500 mt-1">Send a secure invitation to join {{ $company->name }}.</p>
        </div>
        <a href="{{ route('memberships.index', $company->slug) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 text-gray-700 text-sm font-bold rounded-xl hover:bg-gray-50 transition-all shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back to Workforce
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden text-sm">
        <div class="p-6 border-b border-gray-50 bg-gray-50/30">
            <h3 class="font-bold text-gray-900">Email Invitation</h3>
            <p class="text-xs text-gray-500">The recipient will receive a secure registration link valid for 24 hours.</p>
        </div>
        <form action="{{ route('invitations.send', $company->slug) }}" method="POST" class="p-6 md:p-8 space-y-6">
            @csrf
            
            <div>
                <x-input-label for="email" value="Email Address" />
                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full border-gray-200 focus:border-brand-500 focus:ring-brand-500 rounded-xl shadow-sm transition-all text-sm font-medium py-3" :value="old('email')" required placeholder="colleague@example.com" autofocus />
                <x-input-error class="mt-2" :messages="$errors->get('email')" />
            </div>

            <div class="p-4 bg-blue-50/30 rounded-2xl border border-blue-100/50">
                <p class="text-[10px] text-blue-600 uppercase tracking-widest leading-relaxed font-bold">
                    **Security Notification**: Once the user registers via the link, they will be granted immediate "Member" access to this workspace.
                </p>
            </div>

            <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-50 uppercase tracking-widest font-bold">
                <a href="{{ route('memberships.index', $company->slug) }}" class="text-xs text-gray-400 hover:text-gray-600 transition-colors">
                    Discard
                </a>
                <x-primary-button>
                    Send Invitation
                </x-primary-button>
            </div>
        </form>
    </div>
</div>
@endsection
