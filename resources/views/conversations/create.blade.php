@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto space-y-6 text-sm">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Initiate Discussion</h2>
            <p class="text-sm text-gray-500 mt-1">Start a new internal thread for {{ $company->name }}.</p>
        </div>
        <a href="{{ route('conversations.index', $company->slug) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 text-gray-700 text-sm font-bold rounded-xl hover:bg-gray-50 transition-all shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back to Messages
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <form action="{{ route('conversations.store', $company->slug) }}" method="POST" class="p-6 md:p-8 space-y-8">
            @csrf
            <input type="hidden" name="company_id" value="{{ $company->id }}">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Title -->
                <div class="md:col-span-2">
                    <x-input-label for="title" value="Thread Subject" />
                    <x-text-input id="title" name="title" type="text" class="mt-1 block w-full text-lg font-bold tracking-tight" :value="old('title')" required autofocus placeholder="e.g. Project Apollo Logistics, General Feedback" />
                    <x-input-error class="mt-2" :messages="$errors->get('title')" />
                </div>

                <!-- Description -->
                <div class="md:col-span-2 space-y-4">
                    <x-input-label for="description" value="Context Brief" />
                    <textarea id="description" name="description" rows="3" class="mt-1 block w-full border-gray-200 focus:border-brand-500 focus:ring-brand-500 rounded-xl shadow-sm transition-all text-sm font-medium" placeholder="What is this discussion about?">{{ old('description') }}</textarea>
                    <x-input-error class="mt-2" :messages="$errors->get('description')" />
                </div>

                <!-- Participants (Simple list) -->
                <div class="md:col-span-2">
                    <x-input-label value="Add Participants (Members)" />
                    <div class="mt-3 grid grid-cols-2 md:grid-cols-3 gap-4">
                        @foreach($users as $user)
                        @if($user->id !== auth()->id())
                        <div class="flex items-center gap-3 p-3 rounded-xl border border-gray-100 hover:bg-gray-50 transition-colors cursor-pointer group">
                             <input type="checkbox" name="user_ids[]" value="{{ $user->id }}" id="user_{{ $user->id }}" class="rounded text-brand-500 focus:ring-brand-500 border-gray-200 transition-all">
                             <label for="user_{{ $user->id }}" class="text-xs font-bold text-gray-700 cursor-pointer group-hover:text-brand-500 transition-colors">{{ $user->name }}</label>
                        </div>
                        @endif
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-50 uppercase tracking-widest font-bold">
                <a href="{{ route('conversations.index', $company->slug) }}" class="text-xs text-gray-400 hover:text-gray-600 transition-colors">
                    Discard
                </a>
                <x-primary-button>
                    Open Group
                </x-primary-button>
            </div>
        </form>
    </div>
</div>
@endsection
