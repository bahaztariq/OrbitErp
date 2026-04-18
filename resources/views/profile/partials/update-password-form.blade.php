<section>
    <header class="flex items-center gap-4 border-b border-gray-100 pb-4 mb-6">
        <div class="rounded-lg bg-orange-50 p-2">
            <svg class="h-6 w-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
            </svg>
        </div>
        <div>
            <h2 class="text-xl font-bold text-gray-900">
                {{ __('Update Password') }}
            </h2>
            <p class="text-sm text-gray-500">
                {{ __('Ensure your account is using a long, random password to stay secure.') }}
            </p>
        </div>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="space-y-6">
        @csrf
        @method('put')

        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
            <div class="space-y-2 lg:col-span-2">
                <x-input-label for="update_password_current_password" :value="__('Current Password')" class="text-sm font-semibold text-gray-700" />
                <x-text-input id="update_password_current_password" name="current_password" type="password" 
                    class="block w-full rounded-xl border-gray-200 bg-gray-50/50 shadow-sm transition-all focus:border-primary focus:ring-primary/20" 
                    autocomplete="current-password" />
                <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-1" />
            </div>

            <div class="space-y-2">
                <x-input-label for="update_password_password" :value="__('New Password')" class="text-sm font-semibold text-gray-700" />
                <x-text-input id="update_password_password" name="password" type="password" 
                    class="block w-full rounded-xl border-gray-200 bg-gray-50/50 shadow-sm transition-all focus:border-primary focus:ring-primary/20" 
                    autocomplete="new-password" />
                <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-1" />
            </div>

            <div class="space-y-2">
                <x-input-label for="update_password_password_confirmation" :value="__('Confirm New Password')" class="text-sm font-semibold text-gray-700" />
                <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" 
                    class="block w-full rounded-xl border-gray-200 bg-gray-50/50 shadow-sm transition-all focus:border-primary focus:ring-primary/20" 
                    autocomplete="new-password" />
                <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-1" />
            </div>
        </div>

        <div class="flex items-center gap-4 pt-4">
            <x-primary-button class="rounded-xl px-8 py-3 transition-transform active:scale-95">
                {{ __('Update Password') }}
            </x-primary-button>

            @if (session('status') === 'password-updated')
                <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)"
                    class="flex items-center gap-2 text-sm font-medium text-emerald-600">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    {{ __('Password updated successfully.') }}
                </div>
            @endif
        </div>
    </form>
</section>
