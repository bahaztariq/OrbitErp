@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Clients</h2>
            <p class="text-sm text-gray-500 mt-1">Manage your customer relationships for {{ $company->name }}.</p>
        </div>
        @can('create-clients', App\Models\Client::class)
        <a href="{{ route('clients.create', $company->slug) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-brand-500 hover:bg-brand-600 text-white text-sm font-bold rounded-xl transition-all shadow-lg shadow-brand-500/20">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Add Client
        </a>
        @endcan
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="bg-gray-50/50 border-b border-gray-100 italic">
                        <th class="py-4 px-6 text-xs font-bold text-gray-400 uppercase tracking-widest whitespce-nowrap">Client</th>
                        <th class="py-4 px-6 text-xs font-bold text-gray-400 uppercase tracking-widest whitespce-nowrap">Contact</th>
                        <th class="py-4 px-6 text-xs font-bold text-gray-400 uppercase tracking-widest whitespce-nowrap">Location</th>
                        <th class="py-4 px-6 text-xs font-bold text-gray-400 uppercase tracking-widest whitespce-nowrap text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($clients as $client)
                    <tr class="group hover:bg-gray-50/50 transition-colors">
                        <td class="py-4 px-6">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-brand-50 text-brand-500 flex items-center justify-center font-bold">
                                    {{ substr($client->name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="font-bold text-gray-900">{{ $client->name }}</div>
                                    <div class="text-xs text-gray-400 font-medium">Joined {{ $client->created_at->format('M Y') }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <div class="space-y-1">
                                <div class="flex items-center gap-2 text-gray-600">
                                    <svg class="w-3.5 h-3.5 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    {{ $client->email }}
                                </div>
                                @if($client->phone)
                                <div class="flex items-center gap-2 text-gray-600">
                                    <svg class="w-3.5 h-3.5 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                    {{ $client->phone }}
                                </div>
                                @endif
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <div class="text-gray-500 font-medium italic">
                                {{ $client->city ?? 'N/A' }}{{ $client->country ? ', ' . $client->country : '' }}
                            </div>
                        </td>
                        <td class="py-4 px-6 text-right">
                            <x-table.actions-dropdown>
                                <x-table.dropdown-item :href="route('clients.show', [$company->slug, $client->id])">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    View Details
                                </x-table.dropdown-item>
                                
                                @can('update-clients', $client)
                                <x-table.dropdown-item :href="route('clients.edit', [$company->slug, $client->id])">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    Edit Client
                                </x-table.dropdown-item>
                                @endcan

                                <div class="my-1 border-t border-gray-100"></div>

                                @can('delete-clients', $client)
                                <form action="{{ route('clients.destroy', [$company->slug, $client->id]) }}" method="POST" onsubmit="return confirm('Move this client to trash?')">
                                    @csrf
                                    @method('DELETE')
                                    <x-table.dropdown-item type="submit" danger>
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        Move to Trash
                                    </x-table.dropdown-item>
                                </form>
                                @endcan
                            </x-table.actions-dropdown>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="py-16 text-center text-gray-500 italic">
                            No clients found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
