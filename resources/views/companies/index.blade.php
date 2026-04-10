@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="rounded-2xl border border-gray-100 bg-white shadow-sm">
        <div class="px-5 py-5 border-b border-gray-100 flex justify-between items-center">
            <h3 class="text-lg font-bold text-gray-900">
                My Companies
            </h3>
            <a href="{{ route('companies.create') }}" class="inline-flex items-center px-4 py-2 bg-brand-500 hover:bg-brand-600 text-white text-sm font-bold rounded-xl transition-all shadow-lg shadow-brand-500/20">
                Create Company
            </a>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($companies as $company)
                <div class="group relative rounded-2xl border border-gray-50 p-6 hover:border-brand-500 hover:bg-brand-50/10 hover:shadow-xl hover:shadow-brand-500/5 transition-all duration-300">
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14 rounded-xl bg-gray-100 flex items-center justify-center text-brand-500 font-bold text-2xl group-hover:bg-brand-500 group-hover:text-white transition-colors duration-300">
                                {{ substr($company->name, 0, 1) }}
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 group-hover:text-brand-500 transition-colors">
                                    {{ $company->name }}
                                </h4>
                                <span class="inline-flex mt-1 px-2 py-0.5 rounded-lg bg-gray-100 text-[10px] font-bold text-gray-500 uppercase tracking-tight">{{ $company->slug }}</span>
                            </div>
                        </div>
                    </div>
                    <p class="text-sm text-gray-500 mb-6 line-clamp-2 min-h-[2.5rem]">
                        {{ $company->address ?? 'No address provided' }}
                    </p>
                    <a href="{{ route('companies.show', $company->slug) }}" class="inline-flex w-full items-center justify-center px-4 py-2.5 bg-gray-50 hover:bg-brand-500 hover:text-white border border-transparent rounded-xl text-sm font-bold text-gray-700 transition-all duration-300">
                        Manage Company
                    </a>
                </div>
                @empty
                <div class="col-span-full py-16 text-center text-gray-500 bg-gray-50/50 border-2 border-dashed border-gray-100 rounded-3xl">
                    <div class="mb-4 flex justify-center">
                        <svg class="h-12 w-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <p class="font-medium">You haven't joined any companies yet.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

