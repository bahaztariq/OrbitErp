<section>
    <header class="flex items-center gap-4 border-b border-gray-100 pb-4 mb-6">
        <div class="rounded-lg bg-primary/10 p-2">
            <svg class="h-6 w-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
        </div>
        <div>
            <h2 class="text-xl font-bold text-gray-900">
                {{ __('Profile Information') }}
            </h2>
            <p class="text-sm text-gray-500">
                {{ __("Update your account's profile information and email address.") }}
            </p>
        </div>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
        @csrf
        @method('patch')

        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
            <div class="space-y-2">
                <x-input-label for="name" :value="__('Full Name')" class="text-sm font-semibold text-gray-700" />
                <x-text-input id="name" name="name" type="text" 
                    class="block w-full rounded-xl border-gray-200 bg-gray-50/50 shadow-sm transition-all focus:border-primary focus:ring-primary/20" 
                    :value="old('name', $user->name)" required autofocus autocomplete="name" />
                <x-input-error class="mt-1" :messages="$errors->get('name')" />
            </div>

            <div class="space-y-2">
                <x-input-label for="email" :value="__('Email Address')" class="text-sm font-semibold text-gray-700" />
                <x-text-input id="email" name="email" type="email" 
                    class="block w-full rounded-xl border-gray-200 bg-gray-50/50 shadow-sm transition-all focus:border-primary focus:ring-primary/20" 
                    :value="old('email', $user->email)" required autocomplete="username" />
                <x-input-error class="mt-1" :messages="$errors->get('email')" />

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <div class="mt-2 rounded-lg bg-amber-50 p-3">
                        <p class="flex items-center gap-2 text-sm text-amber-700">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 14c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            {{ __('Your email address is unverified.') }}
                        </p>
                        <button form="send-verification" class="mt-1 text-xs font-semibold text-amber-800 underline transition-colors hover:text-amber-900">
                            {{ __('Click here to re-send verification email') }}
                        </button>
                    </div>
                @endif
            </div>
        </div>

        <div class="flex items-center gap-4 pt-4">
            <x-primary-button class="rounded-xl px-8 py-3 transition-transform active:scale-95">
                {{ __('Save Changes') }}
            </x-primary-button>

            @if (session('status') === 'profile-updated')
                <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)"
                    class="flex items-center gap-2 text-sm font-medium text-emerald-600">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    {{ __('Saved successfully.') }}
                </div>
            @endif
        </div>
    </form>
</section>
