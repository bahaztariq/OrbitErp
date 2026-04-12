@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-500">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Initiate Discussion</h2>
            <p class="text-sm text-gray-500 mt-2">Start a new internal thread for <span class="text-brand-500 font-bold">{{ $company->name }}</span>.</p>
        </div>
        <a href="{{ route('conversations.index', $company->slug) }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white border border-gray-100 text-gray-600 text-sm font-bold rounded-2xl hover:bg-gray-50 hover:border-gray-200 transition-all shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back to Messages
        </a>
    </div>

    <div class="bg-white rounded-[2rem] border border-gray-100 shadow-xl shadow-gray-200/20 overflow-hidden relative">
        <div class="absolute top-0 inset-x-0 h-1.5 bg-gradient-to-r from-brand-400 to-brand-600"></div>
        
        <form action="{{ route('conversations.store', $company->slug) }}" method="POST" class="p-8 md:p-12 space-y-10">
            @csrf
            <input type="hidden" name="company_id" value="{{ $company->id }}">

            <div class="space-y-10">
                <!-- Title -->
                <div class="space-y-4">
                    <label for="title" class="text-xs font-black uppercase tracking-[0.2em] text-gray-400">Thread Subject</label>
                    <input id="title" name="title" type="text" 
                        class="block w-full px-0 py-3 bg-transparent border-0 border-b-2 border-gray-100 focus:border-brand-500 focus:ring-0 text-2xl font-bold tracking-tight text-gray-900 transition-all placeholder-gray-200" 
                        value="{{ old('title') }}" required autofocus placeholder="What are we discussing?" />
                    <x-input-error class="mt-2" :messages="$errors->get('title')" />
                </div>

                <!-- Description -->
                <div class="space-y-4">
                    <label for="description" class="text-xs font-black uppercase tracking-[0.2em] text-gray-400">Context Brief</label>
                    <textarea id="description" name="description" rows="3" 
                        class="block w-full px-5 py-4 bg-gray-50/50 border-gray-100 focus:border-brand-500 focus:ring-brand-500 rounded-2xl transition-all text-sm font-medium placeholder-gray-300" 
                        placeholder="Provide some background context for the members...">{{ old('description') }}</textarea>
                    <x-input-error class="mt-2" :messages="$errors->get('description')" />
                </div>

                <!-- Participants -->
                <div class="space-y-6">
                    <label class="text-xs font-black uppercase tracking-[0.2em] text-gray-400">Add Participants (Members)</label>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($users as $user)
                        @if($user->id !== auth()->id())
                        <label for="user_{{ $user->id }}" class="relative flex items-center gap-4 p-4 rounded-2xl border border-gray-50 bg-gray-50/30 hover:bg-white hover:border-brand-100 hover:shadow-md hover:shadow-brand-500/5 transition-all cursor-pointer group">
                             <input type="checkbox" name="user_ids[]" value="{{ $user->id }}" id="user_{{ $user->id }}" 
                                class="w-5 h-5 rounded-lg text-brand-500 focus:ring-brand-500 border-gray-200 transition-all">
                             <div class="flex flex-col">
                                 <span class="text-sm font-bold text-gray-700 group-hover:text-brand-600 transition-colors">{{ $user->name }}</span>
                                 <span class="text-[10px] text-gray-400 font-medium tracking-tight">Team Member</span>
                             </div>
                        </label>
                        @endif
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-6 pt-10 border-t border-gray-50">
                <a href="{{ route('conversations.index', $company->slug) }}" class="text-sm font-bold text-gray-400 hover:text-gray-600 transition-colors uppercase tracking-widest">
                    Discard
                </a>
                <button type="submit" class="px-10 py-4 bg-brand-500 hover:bg-brand-600 text-white text-sm font-bold rounded-2xl transition-all shadow-xl shadow-brand-500/20 hover:-translate-y-0.5 active:translate-y-0">
                    Open Group Discussion
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
