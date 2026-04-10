@extends('layouts.admin')

@section('content')
<div class="space-y-6 text-sm">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Recovery Archive (Trash)</h2>
            <p class="text-sm text-gray-500 mt-1">Restore or permanently delete archived resources for {{ $company->name }}.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-8">
        @php
            $sections = [
                'Clients' => ['data' => $trashData['clients'], 'route' => 'clients'],
                'Products' => ['data' => $trashData['products'], 'route' => 'products'],
                'Categories' => ['data' => $trashData['categories'], 'route' => 'categories'],
                'Suppliers' => ['data' => $trashData['suppliers'], 'route' => 'suppliers'],
                'Orders' => ['data' => $trashData['orders'], 'route' => 'orders'],
                'Invoices' => ['data' => $trashData['invoices'], 'route' => 'invoices'],
                'Payments' => ['data' => $trashData['payments'], 'route' => 'payments'],
                'Tasks' => ['data' => $trashData['tasks'] ?? collect(), 'route' => 'tasks'],
                'Conversations' => ['data' => $trashData['conversations'], 'route' => 'conversations'],
                'Calendar Events' => ['data' => $trashData['calenderEvents'], 'route' => 'calender-events'],
            ];
        @endphp

        @foreach($sections as $title => $section)
        @if($section['data']->count() > 0)
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-6 py-4 bg-gray-50/50 border-b border-gray-100 flex items-center justify-between">
                <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">{{ $title }}</span>
                <span class="text-[10px] font-bold text-rose-500 uppercase tracking-widest">{{ $section['data']->count() }} items archived</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <tbody class="divide-y divide-gray-50">
                        @foreach($section['data'] as $item)
                        <tr class="group hover:bg-gray-50/20 transition-colors">
                            <td class="py-4 px-6">
                                <span class="font-bold text-gray-700">{{ $item->title ?? $item->name ?? $item->reference ?? 'Archived Resource' }}</span>
                            </td>
                            <td class="py-4 px-6 text-gray-400 text-xs">
                                Deleted {{ $item->deleted_at->diffForHumans() }}
                            </td>
                            <td class="py-4 px-6 text-right">
                                <x-table.actions-dropdown>
                                    <form action="{{ route($section['route'].'.restore', [$company->slug, $item->id]) }}" method="POST">
                                        @csrf
                                        <x-table.dropdown-item type="button">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                            </svg>
                                            Restore Record
                                        </x-table.dropdown-item>
                                    </form>

                                    <form action="{{ route($section['route'].'.force-delete', [$company->slug, $item->id]) }}" method="POST" onsubmit="return confirm('Permanently erase this record?');">
                                        @csrf
                                        <x-table.dropdown-item type="button" danger>
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            Permanently Erase
                                        </x-table.dropdown-item>
                                    </form>
                                </x-table.actions-dropdown>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
        @endforeach

        @php
            $hasTrash = false;
            foreach($sections as $section) {
                if($section['data']->count() > 0) { $hasTrash = true; break; }
            }
        @endphp

        @if(!$hasTrash)
        <div class="py-32 bg-white rounded-3xl border border-dashed border-gray-200 flex flex-col items-center justify-center text-gray-400 italic">
            <svg class="w-16 h-16 mb-4 opacity-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
            </svg>
            <p class="uppercase tracking-widest text-[10px] font-bold">Trash is completely empty.</p>
        </div>
        @endif
    </div>
</div>
@endsection
