@extends('layouts.admin')

@section('content')
<div class="space-y-6 text-sm">
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 rounded-2xl bg-indigo-500 text-white flex items-center justify-center text-3xl font-bold shadow-xl shadow-indigo-500/20 italic">
                T
            </div>
            <div>
                <h2 class="text-3xl font-bold text-gray-900 tracking-tight">{{ $task->title }}</h2>
                <div class="mt-1 flex items-center gap-2">
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
                    <span class="text-gray-400 font-medium">due {{ \Carbon\Carbon::parse($task->end_date)->diffForHumans() }}</span>
                </div>
            </div>
        </div>
        <div class="flex gap-3">
             <a href="{{ route('tasks.edit', [$company->slug, $task->id]) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 text-gray-700 text-sm font-bold rounded-xl hover:bg-gray-50 transition-all tracking-widest text-[10px] uppercase">
                Edit Update
            </a>
            <a href="{{ route('tasks.index', $company->slug) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 text-gray-700 text-sm font-bold rounded-xl hover:bg-gray-50 transition-all tracking-widest text-[10px] uppercase">
                Back Search
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8 space-y-8">
                <div class="space-y-4">
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest">Description Brief</h3>
                    <div class="text-gray-700 leading-relaxed text-base">
                        @if($task->description)
                            {!! nl2br(e($task->description)) !!}
                        @else
                            <span class="text-gray-400">No descriptive brief provided for this assignment.</span>
                        @endif
                    </div>
                </div>

                @if($task->children->count() > 0)
                <div class="pt-8 border-t border-gray-50 space-y-4">
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest">Sub-tasks Breakdown</h3>
                    <div class="space-y-3 font-medium">
                        @foreach($task->children as $child)
                        <div class="flex items-center justify-between p-4 rounded-xl border border-gray-50 hover:bg-gray-50 transition-colors group">
                            <span class="text-gray-900">{{ $child->title }}</span>
                             <a href="{{ route('tasks.show', [$company->slug, $child->id]) }}" class="text-xs text-indigo-400 opacity-0 group-hover:opacity-100 transition-opacity">examine details →</a>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Sidebar Meta -->
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 space-y-6">
                <div class="space-y-6">
                    <div>
                        <span class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">Workflow Status</span>
                        @php
                            $statusClasses = [
                                'pending' => 'bg-amber-50 text-amber-600 border-amber-100',
                                'processing' => 'bg-indigo-50 text-indigo-600 border-indigo-100',
                                'completed' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                            ];
                            $sClass = $statusClasses[$task->status] ?? 'bg-gray-50 text-gray-400 border-gray-100';
                        @endphp
                        <span class="inline-flex items-center px-4 py-1.5 rounded-xl text-xs font-bold uppercase tracking-widest border {{ $sClass }} italic">
                            {{ $task->status }}
                        </span>
                    </div>

                    <div>
                        <span class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">Assigned Agent</span>
                        @if($task->assignedTo)
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-gray-100 border border-gray-200 flex items-center justify-center text-gray-500 text-[10px] font-bold">
                                    {{ substr($task->assignedTo->name, 0, 1) }}
                                </div>
                                <span class="text-gray-900">{{ $task->assignedTo->name }}</span>
                            </div>
                        @else
                            <span class="text-gray-400 italic">No agent assigned.</span>
                        @endif
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <span class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Start Date</span>
                            <span class="text-gray-900 font-medium">{{ $task->start_date ? \Carbon\Carbon::parse($task->start_date)->format('M d, Y') : '---' }}</span>
                        </div>
                        <div>
                            <span class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">End Date</span>
                            <span class="text-gray-900 font-medium">{{ \Carbon\Carbon::parse($task->end_date)->format('M d, Y') }}</span>
                        </div>
                    </div>

                    @if($task->parent)
                    <div class="pt-6 border-t border-gray-50">
                        <span class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">Parent Authority</span>
                        <a href="{{ route('tasks.show', [$company->slug, $task->parent_id]) }}" class="text-indigo-500 hover:underline decoration-indigo-500/30">
                            {{ $task->parent->title }}
                        </a>
                    </div>
                    @endif
                </div>
            </div>
            
            <form action="{{ route('tasks.destroy', [$company->slug, $task->id]) }}" method="POST" onsubmit="return confirm('Archive this assignment?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="w-full inline-flex items-center justify-center gap-2 px-6 py-4 bg-white border border-rose-100 text-rose-500 font-bold rounded-2xl hover:bg-rose-50 transition-all uppercase tracking-widest text-[10px]">
                    Archive Assignment
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
