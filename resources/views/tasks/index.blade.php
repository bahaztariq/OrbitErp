@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Operations & Tasks</h2>
            <p class="text-sm text-gray-500 mt-1">Manage internal workflows and assignments for {{ $company->name }}.</p>
        </div>
        <a href="{{ route('tasks.create', $company->slug) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-brand-500 hover:bg-brand-600 text-white text-sm font-bold rounded-xl transition-all shadow-lg shadow-brand-500/20">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            New Task
        </a>
    </div>

    <!-- Stats or Filters Placeholder -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 flex flex-col justify-between">
            <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">Pending</span>
            <span class="text-3xl font-bold text-gray-900 mt-2">{{ $tasks->where('status', 'pending')->count() }}</span>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 flex flex-col justify-between">
            <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">In Progress</span>
            <span class="text-3xl font-bold text-gray-900 mt-2">{{ $tasks->where('status', 'processing')->count() }}</span>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 flex flex-col justify-between">
            <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">Completed</span>
            <span class="text-3xl font-bold text-gray-900 mt-2">{{ $tasks->where('status', 'completed')->count() }}</span>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden text-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50 border-b border-gray-100 italic">
                        <th class="py-4 px-6 text-xs font-bold text-gray-400 uppercase tracking-widest whitespace-nowrap">Task Title</th>
                        <th class="py-4 px-6 text-xs font-bold text-gray-400 uppercase tracking-widest whitespace-nowrap">Priority</th>
                        <th class="py-4 px-6 text-xs font-bold text-gray-400 uppercase tracking-widest whitespace-nowrap">Assigned To</th>
                        <th class="py-4 px-6 text-xs font-bold text-gray-400 uppercase tracking-widest whitespace-nowrap">Due Date</th>
                        <th class="py-4 px-6 text-xs font-bold text-gray-400 uppercase tracking-widest whitespace-nowrap">Status</th>
                        <th class="py-4 px-6 text-xs font-bold text-gray-400 uppercase tracking-widest whitespace-nowrap text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($tasks as $task)
                    <tr class="group hover:bg-gray-50/50 transition-colors">
                        <td class="py-4 px-6">
                            <div class="font-bold text-gray-900">{{ $task->title }}</div>
                            @if($task->parent)
                                <div class="text-[10px] text-indigo-400 mt-0.5 uppercase tracking-tighter">Sub-task of: {{ $task->parent->title }}</div>
                            @endif
                        </td>
                        <td class="py-4 px-6">
                            @php
                                $priorityClasses = [
                                    'low' => 'text-emerald-500 bg-emerald-50 border-emerald-100',
                                    'medium' => 'text-amber-500 bg-amber-50 border-amber-100',
                                    'high' => 'text-rose-500 bg-rose-50 border-rose-100',
                                ];
                                $pClass = $priorityClasses[$task->priority] ?? 'bg-gray-50 text-gray-400 border-gray-100';
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-xs font-bold uppercase tracking-wider border {{ $pClass }} italic">
                                {{ $task->priority }}
                            </span>
                        </td>
                        <td class="py-4 px-6 text-gray-600">
                            {{ $task->assignedTo ? $task->assignedTo->name : 'Unassigned' }}
                        </td>
                        <td class="py-4 px-6 text-gray-500">
                            {{ \Carbon\Carbon::parse($task->end_date)->format('M d, Y') }}
                        </td>
                        <td class="py-4 px-6">
                            @php
                                $statusClasses = [
                                    'pending' => 'bg-amber-50 text-amber-600 border-amber-100',
                                    'processing' => 'bg-indigo-50 text-indigo-600 border-indigo-100',
                                    'completed' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                ];
                                $sClass = $statusClasses[$task->status] ?? 'bg-gray-50 text-gray-400 border-gray-100';
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-xs font-bold uppercase tracking-wider border {{ $sClass }} italic">
                                {{ $task->status }}
                            </span>
                        </td>
                        <td class="py-4 px-6 text-right">
                            <x-table.actions-dropdown>
                                <x-table.dropdown-item :href="route('tasks.show', [$company->slug, $task->id])">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    View Details
                                </x-table.dropdown-item>
                                
                                <x-table.dropdown-item :href="route('tasks.edit', [$company->slug, $task->id])">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    Edit Task
                                </x-table.dropdown-item>

                                <div class="my-1 border-t border-gray-100"></div>

                                <form action="{{ route('tasks.destroy', [$company->slug, $task->id]) }}" method="POST" onsubmit="return confirm('Move this task to trash?')">
                                    @csrf
                                    @method('DELETE')
                                    <x-table.dropdown-item type="button" danger>
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        Move to Trash
                                    </x-table.dropdown-item>
                                </form>
                            </x-table.actions-dropdown>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-16 text-center text-gray-400 italic">
                            No tasks found for this workspace.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
