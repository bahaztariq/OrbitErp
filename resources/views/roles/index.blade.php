@extends('layouts.admin')

@section('content')
<div class="space-y-6 text-sm">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Authorization Roles</h2>
            <p class="text-sm text-gray-500 mt-1">Define security groups and permission sets for {{ $company->name }}.</p>
        </div>
        @can('create', App\Models\Role::class)
        <a href="{{ route('roles.create', $company->slug) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-brand-500 hover:bg-brand-600 text-white text-sm font-bold rounded-xl transition-all shadow-lg shadow-brand-500/20">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
            </svg>
            Define Role
        </a>
        @endcan
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($roles as $role)
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all group p-6 space-y-4">
            <div class="flex items-start justify-between">
                <div class="w-12 h-12 rounded-2xl bg-brand-50 text-brand-500 flex items-center justify-center text-xl font-bold shadow-sm transition-transform group-hover:scale-110">
                    {{ substr($role->name, 0, 1) }}
                </div>
                <span class="text-[10px] text-gray-400 uppercase tracking-widest">{{ $role->permissions->count() }} Perms</span>
            </div>
            <div>
                <h3 class="text-xl font-bold text-gray-900 group-hover:text-brand-500 transition-colors tracking-tight">{{ $role->name }}</h3>
                <p class="text-xs text-gray-500 mt-1 line-clamp-2 leading-relaxed">{{ $role->description ?? 'No functional description provided for this role.' }}</p>
            </div>
            
            <div class="pt-4 border-t border-gray-50 flex items-center justify-between text-[10px] uppercase tracking-widest font-bold">
                <a href="{{ route('roles.show', [$company->slug, $role->id]) }}" class="text-brand-500 hover:text-brand-600 transition-colors">View Full Specs</a>
                <div class="flex gap-2">
                    @can('update', $role)
                    <a href="{{ route('roles.edit', [$company->slug, $role->id]) }}" class="text-gray-400 hover:text-brand-500 transition-colors">Edit</a>
                    @endcan
                    @can('delete', $role)
                    <span class="text-gray-200">|</span>
                    <form action="{{ route('roles.destroy', [$company->slug, $role->id]) }}" method="POST" onsubmit="return confirm('Archive this role blueprint?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-rose-400 hover:text-rose-600 transition-colors">Erase</button>
                    </form>
                    @endcan
                </div>
            </div>
        </div>
        @empty
        <div class="md:col-span-2 lg:col-span-3 py-24 bg-white rounded-3xl border border-dashed border-gray-200 flex flex-col items-center justify-center text-gray-400 italic">
             <p class="uppercase tracking-widest text-[10px] font-bold">No custom roles defined.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection
