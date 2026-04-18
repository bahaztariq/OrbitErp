<section class="space-y-6">
    <header class="flex items-center gap-4 border-b border-red-50 pb-4 mb-6">
        <div class="rounded-lg bg-red-50 p-2">
            <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
            </svg>
        </div>
        <div>
            <h2 class="text-xl font-bold text-gray-900">
                {{ __('Delete Account') }}
            </h2>
            <p class="text-sm text-gray-500">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted.') }}
            </p>
        </div>
    </header>

    <div class="rounded-xl border border-red-100 bg-red-50/30 p-4">
        <p class="text-sm text-red-700">
            {{ __('Deleting your account is permanent and cannot be undone. Please ensure you have downloaded any data you wish to keep before proceeding.') }}
        </p>
        <x-danger-button
            x-data=""
            class="mt-4 rounded-xl transition-transform active:scale-95"
            x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        >{{ __('Permanently Delete Account') }}</x-danger-button>
    </div>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-8">
            @csrf
            @method('delete')

            <div class="flex items-center gap-3 text-red-600 mb-4">
                <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 14c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <h2 class="text-2xl font-bold text-gray-900 leading-tight">
                    {{ __('Confirm Account Deletion') }}
                </h2>
            </div>

            <p class="text-gray-600">
                {{ __('Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="block w-full rounded-xl border-gray-200 bg-gray-50/50 shadow-sm transition-all focus:border-red-500 focus:ring-red-500/20"
                    placeholder="{{ __('Enter your password') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-8 flex justify-end gap-3">
                <x-secondary-button x-on:click="$dispatch('close')" class="rounded-xl px-6">
                    {{ __('No, Keep My Account') }}
                </x-secondary-button>

                <x-danger-button class="rounded-xl px-6">
                    {{ __('Yes, Delete Everything') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
