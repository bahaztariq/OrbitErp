@extends('layouts.app')

@section('title', 'My Companies')

@section('content')
<div class="bg-white shadow overflow-hidden sm:rounded-md">
    <div class="px-4 py-5 border-b border-gray-200 sm:px-6 flex justify-between items-center">
        <h3 class="text-lg leading-6 font-medium text-gray-900">
            My Companies
        </h3>
        <a href="{{ route('companies.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            Create Company
        </a>
    </div>
    <ul class="divide-y divide-gray-200">
        @forelse($companies as $company)
            <li>
                <a href="{{ route('companies.show', $company->slug) }}" class="block hover:bg-gray-50">
                    <div class="px-4 py-4 sm:px-6">
                        <div class="flex items-center justify-between">
                            <p class="text-sm font-medium text-blue-600 truncate">
                                {{ $company->name }}
                            </p>
                            <div class="ml-2 flex-shrink-0 flex">
                                <p class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    {{ $company->slug }}
                                </p>
                            </div>
                        </div>
                        <div class="mt-2 sm:flex sm:justify-between">
                            <div class="sm:flex">
                                <p class="flex items-center text-sm text-gray-500">
                                    {{ $company->address ?? 'No address provided' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </a>
            </li>
        @empty
            <li class="px-4 py-8 text-center text-gray-500">
                You haven't joined any companies yet.
            </li>
        @endforelse
    </ul>
</div>
@endsection
