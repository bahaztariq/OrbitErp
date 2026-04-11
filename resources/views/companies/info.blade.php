@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="flex flex-col gap-6 md:flex-row md:items-center md:justify-between">
        <div class="flex items-center gap-5">
            <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-brand-500 text-white shadow-xl shadow-brand-500/20 text-3xl font-bold">
                {{ substr($company->name, 0, 1) }}
            </div>
            <div>
                <h2 class="text-3xl font-bold text-gray-900 tracking-tight">Company</h2>
                <div class="mt-1 flex items-center gap-2 text-sm text-gray-500">
                    <span class="font-medium">Details for <span class="text-brand-600">{{ $company->name }}</span></span>
                </div>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('companies.edit', $company->slug) }}" class="inline-flex items-center px-5 py-2.5 bg-white hover:bg-gray-50 text-gray-700 text-sm font-bold rounded-xl border border-gray-200 transition-all shadow-sm">
                Edit company
            </a>
            <form action="{{ route('companies.destroy', $company->slug) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="flex justify-between  items-center px-5 py-2.5 bg-red-500 hover:bg-red-600 text-white text-sm font-bold rounded-xl border border-red-200 transition-all shadow-sm">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    <span>Delete company</span>   
                </button>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Info -->
        <div class="lg:col-span-2 space-y-6">
            <div class="rounded-2xl border border-gray-100 bg-white p-8 shadow-sm">
                <h3 class="font-black text-gray-900 text-lg uppercase tracking-tight mb-6">About the Company</h3>
                <div class="prose prose-sm max-w-none text-gray-600 leading-relaxed font-medium">
                    {{ $company->description ?? 'No description has been provided for this Company. You can update this by editing the company profile.' }}
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Identity Card -->
                <div class="rounded-2xl border border-gray-100 bg-white p-8 shadow-sm">
                    <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-6">Identity</h3>
                    <div class="space-y-6">
                        <div>
                            <span class="block text-[10px] font-bold text-gray-400 uppercase mb-1">Business Name</span>
                            <span class="font-bold text-gray-900">{{ $company->name }}</span>
                        </div>
                        <div>
                            <span class="block text-[10px] font-bold text-gray-400 uppercase mb-1">Company Slug</span>
                            <span class="font-bold text-gray-500">/c/{{ $company->slug }}</span>
                        </div>
                        <div>
                            <span class="block text-[10px] font-bold text-gray-400 uppercase mb-1">Status</span>
                            @if($company->is_active)
                                <span class="inline-flex items-center px-2 py-0.5 rounded-lg bg-emerald-50 text-[10px] font-bold text-emerald-600 uppercase tracking-wider border border-emerald-100">Active</span>
                            @else
                                <span class="inline-flex items-center px-2 py-0.5 rounded-lg bg-gray-50 text-[10px] font-bold text-gray-600 uppercase tracking-wider border border-gray-100">Inactive</span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Workforce Card -->
                <div class="rounded-2xl border border-gray-100 bg-white p-8 shadow-sm">
                    <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-6">Workforce</h3>
                    <div class="space-y-6">
                        <div class="flex items-center gap-4">
                            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-purple-50 text-purple-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            </div>
                            <div>
                                <span class="block text-2xl font-black text-gray-900 leading-none">{{ $company->users_count }}</span>
                                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Active Members</span>
                            </div>
                        </div>
                        <div class="pt-4 border-t border-gray-50">
                            <a href="{{ route('memberships.index', $company->slug) }}" class="text-xs font-bold text-brand-600 hover:text-brand-700 uppercase tracking-wider">
                                Manage Workforce &rarr;
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- System State -->
        <div class="space-y-6">
            <div class="rounded-2xl border border-brand-100 bg-brand-50 p-8 shadow-sm">
                <h3 class="text-[10px] font-black text-brand-900 uppercase tracking-widest mb-6">System Health</h3>
                <div class="space-y-6">
                    <div class="flex items-center gap-3">
                        <div class="h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></div>
                        <span class="font-bold text-gray-900">Operational</span>
                    </div>
                    <p class="text-xs font-medium text-brand-700 leading-relaxed">
                        Your Company profile is correctly configured within OrbitErp. All associated data models are scoped and protected.
                    </p>
                </div>
            </div>

            <div class="rounded-2xl border border-gray-100 bg-white p-8 shadow-sm">
                <h3 class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-6">History</h3>
                <div class="space-y-4">
                    <div class="flex justify-between items-center text-xs">
                        <span class="text-gray-500 font-medium">Joined System</span>
                        <span class="font-bold text-gray-900">{{ $company->created_at->format('M d, Y') }}</span>
                    </div>
                    <div class="flex justify-between items-center text-xs">
                        <span class="text-gray-500 font-medium">Last Updated</span>
                        <span class="font-bold text-gray-900">{{ $company->updated_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
