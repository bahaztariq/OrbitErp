@extends('layouts.admin')

@section('content')
<div class="space-y-6 text-sm">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Workforce & Permissions</h2>
            <p class="text-sm text-gray-500 mt-1">Manage company access and memberships for {{ $company->name }}.</p>
        </div>
        @can('create', App\Models\Membership::class)
        <a href="{{ route('memberships.create', $company->slug) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-brand-500 hover:bg-brand-600 text-white text-sm font-bold rounded-xl transition-all shadow-lg shadow-brand-500/20">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Add Member
        </a>
        @endcan
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($memberships as $membership)
        <div class="group bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all p-6 relative overflow-hidden">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-brand-5 flex items-center justify-center text-brand-500 font-bold text-xl transition-all transform duration-500 shadow-sm">
                        {{ substr($membership->user->name, 0, 1) }}
                    </div>
                    <div>
                        <h4 class="text-lg font-bold text-gray-900 group-hover:text-brand-500 transition-colors">{{ $membership->user->name }}</h4>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mt-0.5">Joined {{ $membership->created_at }}</p>
                    </div>
                </div>
                <x-table.actions-dropdown>
                    @can('delete', $membership)
                    <form action="{{ route('memberships.destroy', [$company->slug, $membership->id]) }}" method="POST" onsubmit="return confirm('Revoke this user\'s membership?');">
                        @csrf
                        @method('DELETE')
                        <x-table.dropdown-item type="submit" danger>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7a4 4 0 11-8 0 4 4 0 018 0zM9 14a6 6 0 00-6 6v1h12v-1a6 6 0 00-6-6zM21 12h-6" />
                            </svg>
                            Revoke Access
                        </x-table.dropdown-item>
                    </form>
                    @endcan
                </x-table.actions-dropdown>
            </div>
            
            <div class="space-y-4">
                <div class="p-3 rounded-xl bg-gray-50/50 border border-gray-100/50">
                    <div class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mb-1 italic">Email Address</div>
                    <div class="text-sm font-medium text-gray-700 truncate italic">{{ $membership->user->email }}</div>
                </div>
                
                <div class="flex items-center justify-between pt-4 border-t border-gray-50 mt-4">
                    <span class="inline-flex px-2 py-1 rounded-lg bg-emerald-50 text-emerald-600 text-[10px] font-bold uppercase tracking-widest">{{ $membership->role->name ?? 'No Role' }}</span>
                    <a href="{{ route('conversations.start', [$company->slug, $membership->user->id]) }}" class="text-xs font-bold hover:opacity-80 transition-colors italic bg-brand-500 text-white px-2 py-1 rounded-lg p-2">Message Member</a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full bg-white rounded-3xl border border-dashed border-gray-200 p-16 text-center">
            <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900">No external members</h3>
            <p class="text-gray-500 mt-2 max-w-sm mx-auto">Start building your company workforce by inviting or adding members to this organization.</p>
            <a href="{{ route('memberships.create', $company->slug) }}" class="mt-8 inline-flex items-center gap-2 px-6 py-3 bg-brand-500 text-white font-bold rounded-2xl hover:bg-brand-600 transition-all shadow-lg shadow-brand-500/25">
                Add First Member
            </a>
        </div>
        @endforelse
    </div>
</div>
@endsection
