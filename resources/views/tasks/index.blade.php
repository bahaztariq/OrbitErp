@extends('layouts.admin')

@section('content')
<div class="space-y-8 flex flex-col h-[calc(100vh-140px)]">
    <div class="flex items-center justify-between shrink-0">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Operations Board</h2>
            <p class="text-sm text-gray-500 mt-1 uppercase tracking-widest font-black text-[10px]">Workflow Management for {{ $company->name }}</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('tasks.create', $company->slug) }}" class="inline-flex items-center gap-2 px-6 py-2.5 bg-brand-500 hover:bg-brand-600 text-white text-[11px] font-black uppercase tracking-widest rounded-2xl transition-all shadow-xl shadow-brand-500/20 active:scale-95">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                New Task
            </a>
        </div>
    </div>

    @php
        $columns = [
            'pending' => ['label' => 'Pending', 'bg' => 'bg-amber-500', 'text' => 'text-amber-600'],
            'processing' => ['label' => 'In Progress', 'bg' => 'bg-brand-500', 'text' => 'text-brand-600'],
            'completed' => ['label' => 'Completed', 'bg' => 'bg-emerald-500', 'text' => 'text-emerald-600'],
        ];
    @endphp

    <div class="flex-1 overflow-x-auto pb-4 -mx-4 md:-mx-6 px-4 md:px-6">
        <div class="flex gap-6 h-full min-w-[1000px]">
            @foreach($columns as $status => $meta)
                <div class="flex-1 min-w-[320px] bg-gray-50/50 rounded-[2.5rem] border border-gray-100 p-6 flex flex-col gap-6">
                    <!-- Column Header -->
                    <div class="flex items-center justify-between px-2">
                        <div class="flex items-center gap-2">
                            <div class="w-2 h-2 rounded-full {{ $meta['bg'] }}"></div>
                            <h3 class="text-xs font-black text-gray-900 uppercase tracking-widest">{{ $meta['label'] }}</h3>
                            <span class="text-[10px] bg-white border border-gray-100 text-gray-400 px-2 py-0.5 rounded-full font-bold ml-1">
                                {{ $tasks->where('status', $status)->count() }}
                            </span>
                        </div>
                         <button class="text-gray-300 hover:text-gray-900 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"/></svg>
                        </button>
                    </div>

                    <!-- Task Cards Container -->
                    <div class="flex-1 space-y-4 overflow-y-auto pr-2 custom-scrollbar">
                        @forelse($tasks->where('status', $status) as $task)
                            <div class="group bg-white p-5 rounded-[2rem] border border-gray-100 hover:border-brand-200 hover:shadow-2xl hover:shadow-brand-500/5 transition-all duration-500 cursor-grab active:cursor-grabbing">
                                <div class="space-y-4">
                                    <div class="flex items-start justify-between">
                                         @php
                                            $priorityColors = [
                                                'low' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                                'medium' => 'bg-amber-50 text-amber-600 border-amber-100',
                                                'high' => 'bg-rose-50 text-rose-600 border-rose-100',
                                            ];
                                        @endphp
                                        <span class="px-2 py-0.5 rounded-lg text-[9px] font-black uppercase tracking-widest border {{ $priorityColors[$task->priority] ?? 'bg-gray-50 text-gray-400' }}">
                                            {{ $task->priority }}
                                        </span>
                                        
                                        <x-table.actions-dropdown>
                                            <x-table.dropdown-item :href="route('tasks.show', [$company->slug, $task->id])">View</x-table.dropdown-item>
                                            <x-table.dropdown-item :href="route('tasks.edit', [$company->slug, $task->id])">Edit</x-table.dropdown-item>
                                        </x-table.actions-dropdown>
                                    </div>

                                    <div>
                                        <h4 class="text-xs font-black text-gray-900 group-hover:text-brand-600 transition-colors uppercase tracking-tight line-clamp-2">
                                            {{ $task->title }}
                                        </h4>
                                        <p class="text-[10px] text-gray-400 mt-2 line-clamp-1 lowercase italic leading-relaxed">
                                            {{ $task->description ?: 'No description provided.' }}
                                        </p>
                                    </div>

                                    @if($task->parent)
                                        <div class="flex items-center gap-1.5 px-3 py-1.5 bg-indigo-50/50 rounded-xl border border-indigo-50">
                                            <svg class="w-3 h-3 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                                            <span class="text-[9px] font-bold text-indigo-400 uppercase tracking-tighter truncate">{{ $task->parent->title }}</span>
                                        </div>
                                    @endif

                                    <div class="flex items-center justify-between pt-2 border-t border-gray-50">
                                        <div class="flex items-center gap-2">
                                            <div class="w-6 h-6 rounded-lg bg-gray-100 flex items-center justify-center text-[10px] font-black text-gray-400 uppercase border border-gray-200" title="{{ $task->assignedTo->name ?? 'Unassigned' }}">
                                                @if($task->assignedTo)
                                                    {{ substr($task->assignedTo->name, 0, 1) }}
                                                @else
                                                    ?
                                                @endif
                                            </div>
                                            <span class="text-[9px] font-bold text-gray-400 uppercase tracking-tighter">
                                                {{ $task->assignedTo ? explode(' ', $task->assignedTo->name)[0] : 'Unassigned' }}
                                            </span>
                                        </div>
                                        
                                        <div class="flex items-center gap-1 text-gray-300 group-hover:text-brand-400 transition-colors">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                            <span class="text-[9px] font-black">{{ \Carbon\Carbon::parse($task->end_date)->format('M d') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="py-12 px-6 rounded-[2rem] border-2 border-dashed border-gray-100 flex flex-col items-center justify-center text-center gap-3">
                                <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-gray-100">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.268 17c-.77 1.333.192 3 1.732 3z"/></svg>
                                </div>
                                <p class="text-[10px] font-bold text-gray-300 uppercase tracking-widest italic">Clear Sky</p>
                            </div>
                        @endforelse
                    </div>
                    
                    <!-- Add Card Shortcut -->
                    <a href="{{ route('tasks.create', ['company' => $company->slug, 'status' => $status]) }}" class="group/btn flex items-center justify-center py-4 border-2 border-dashed border-gray-100 rounded-[2rem] hover:border-brand-200 hover:bg-white transition-all">
                        <span class="text-[10px] font-black text-gray-300 group-hover/btn:text-brand-500 uppercase tracking-widest">+ New Item</span>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</div>

<style>
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #f1f1f1; border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #e2e2e2; }
</style>
@endsection
