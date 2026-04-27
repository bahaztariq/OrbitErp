@extends('layouts.admin')

@section('content')
<div class="space-y-6 text-sm">
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 rounded-2xl bg-brand-500 text-white flex items-center justify-center text-3xl font-bold shadow-xl shadow-brand-500/20">
                {{ substr($role->name, 0, 1) }}
            </div>
            <div>
                <h2 class="text-3xl font-bold text-gray-900 tracking-tight">{{ $role->name }}</h2>
                <div class="mt-1 flex items-center gap-2">
                    <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">ID: {{ $role->slug }}</span>
                    <span class="text-gray-300">|</span>
                    <span class="text-xs font-bold text-brand-500 uppercase tracking-widest">{{ $role->permissions->count() }} active permissions</span>
                </div>
            </div>
        </div>
        <div class="flex gap-3">
             @can('update', $role)
             <a href="{{ route('roles.edit', [$company->slug, $role->id]) }}" class="inline-flex items-center gap-2 px-6 py-2 bg-white border border-gray-200 text-gray-700 text-[10px] font-bold rounded-xl hover:bg-gray-50 transition-all uppercase tracking-widest">
                Edit Matrix
            </a>
            @endcan
            <a href="{{ route('roles.index', $company->slug) }}" class="inline-flex items-center gap-2 px-6 py-2 bg-white border border-gray-200 text-gray-700 text-[10px] font-bold rounded-xl hover:bg-gray-50 transition-all uppercase tracking-widest">
                Back Archive
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8 space-y-10">
                <div class="space-y-4">
                     <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest">Functional Scope</h3>
                     <p class="text-lg text-gray-700 font-medium leading-relaxed border-l-4 border-brand-500 pl-6">
                        {{ $role->description ?? 'No functional scope defined for this security blueprint.' }}
                     </p>
                </div>

                <div class="pt-10 border-t border-gray-50 space-y-6">
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest">Assigned Permissions</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @forelse($role->permissions as $permission)
                        <div class="p-4 rounded-xl bg-gray-50/50 border border-gray-100 flex items-center gap-3">
                             <div class="w-2 h-2 rounded-full bg-emerald-400 shadow-[0_0_8px_rgba(52,211,153,0.5)]"></div>
                             <div>
                                 <span class="block text-[10px] font-bold text-gray-900 uppercase tracking-widest">{{ $permission->name }}</span>
                                 <span class="text-[8px] text-gray-400 lowercase tracking-tighter">{{ $permission->description }}</span>
                             </div>
                        </div>
                        @empty
                        <div class="md:col-span-2 py-8 text-center text-gray-400 text-xs italic">
                            This role blueprint has no active permissions.
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-1 space-y-6">
             <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 space-y-6">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest">Role Metadata</h3>
                <div class="space-y-4">
                    <div>
                        <span class="block text-[10px] text-gray-400 uppercase tracking-widest mb-1">Created At</span>
                        <span class="text-gray-900">{{ $role->created_at->format('M d, Y') }}</span>
                    </div>
                    <div>
                        <span class="block text-[10px] text-gray-400 uppercase tracking-widest mb-1">System Slug</span>
                        <code class="text-brand-500 text-[10px]">{{ $role->slug }}</code>
                    </div>
                </div>
             </div>
             
             @can('delete', $role)
             <form action="{{ route('roles.destroy', [$company->slug, $role->id]) }}" method="POST" onsubmit="return confirm('Archive this role blueprint?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="w-full inline-flex items-center justify-center gap-2 px-6 py-4 bg-white border border-rose-100 text-rose-500 font-bold rounded-2xl hover:bg-rose-50 transition-all uppercase tracking-widest text-[10px]">
                    Delete Blueprint
                </button>
            </form>
            @endcan
        </div>
    </div>
</div>
@endsection
