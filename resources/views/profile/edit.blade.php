@extends('layouts.admin')

@php
    $title = __('Profile');
@endphp

@section('content')
    <div class="mx-auto max-w-7xl">
        <!-- Header Section -->
        <div class="mb-8 flex items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white sm:text-3xl">
                    {{ __('Account Settings') }}
                </h2>
                <p class="mt-1 text-sm text-gray-500">
                    {{ __('Manage your profile information, password, and account security.') }}
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-8 lg:grid-cols-12">
            <!-- Sidebar/Overview Column -->
            <div class="lg:col-span-4 lg:sticky lg:top-24 h-fit">
                <div class="overflow-hidden rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-200">
                    <div class="flex flex-col items-center text-center">
                        <div class="relative group">
                            <div class="h-32 w-32 overflow-hidden rounded-full ring-4 ring-primary/10 transition-transform duration-300 group-hover:scale-105">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&color=7F9CF5&background=EBF4FF" 
                                     alt="{{ $user->name }}" 
                                     class="h-full w-full object-cover">
                            </div>
                        </div>
                        <h3 class="mt-4 text-xl font-bold text-gray-900">{{ $user->name }}</h3>
                        <p class="text-sm text-gray-500">{{ $user->email }}</p>
                        <div class="mt-4 flex flex-wrap justify-center gap-2">
                            <span class="inline-flex items-center rounded-full bg-blue-50 px-2.5 py-0.5 text-xs font-medium text-blue-700">
                                {{ __('Active User') }}
                            </span>
                        </div>
                    </div>

                    <div class="mt-8 space-y-4 border-t border-gray-100 pt-6">
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-500 font-medium">{{ __('Member Since') }}</span>
                            <span class="text-gray-900 font-semibold">{{ $user->created_at->format('M d, Y') }}</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-500 font-medium">{{ __('Account ID') }}</span>
                            <span class="text-gray-900 font-semibold">#{{ str_pad($user->id, 5, '0', STR_PAD_LEFT) }}</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-500 font-medium">{{ __('Email Status') }}</span>
                            @if($user->email_verified_at)
                                <span class="inline-flex items-center gap-1 text-emerald-600 font-semibold text-xs">
                                    <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    {{ __('Verified') }}
                                </span>
                            @else
                                <span class="text-amber-600 font-semibold text-xs transition-pulse">{{ __('Pending') }}</span>
                            @endif
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-500 font-medium">{{ __('Companies') }}</span>
                            <span class="text-gray-900 font-semibold">{{ $user->memberships()->count() }}</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-500 font-medium">{{ __('Last Update') }}</span>
                            <span class="text-gray-900 font-semibold">{{ $user->updated_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content Column -->
            <div class="lg:col-span-8 space-y-8">
                <!-- Profile Information -->
                <div id="personal-info" class="scroll-mt-24 overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-gray-200">
                    <div class="p-6 sm:p-8">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <!-- Update Password -->
                <div id="security" class="scroll-mt-24 overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-gray-200">
                    <div class="p-6 sm:p-8">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                <!-- Danger Zone -->
                <div id="danger-zone" class="scroll-mt-24 overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-gray-200">
                    <div class="p-6 sm:p-8">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
