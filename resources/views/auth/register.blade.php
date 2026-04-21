<x-guest-layout>
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-slate-900">Create Account</h2>
        <p class="mt-2 text-slate-500">Join OrbitErp today and start managing your enterprise efficiently.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="block text-sm font-semibold text-slate-700 mb-1.5">Full Name</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                </div>
                <input id="name" 
                       class="block w-full pl-11 pr-4 py-3 rounded-xl border bg-slate-50 text-slate-900 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 {{ $errors->has('name') ? 'border-red-500' : 'border-slate-200' }}" 
                       type="text" 
                       name="name" 
                       value="{{ old('name') }}" 
                       required 
                       autofocus 
                       autocomplete="name"
                       placeholder="John Doe" />
            </div>
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-semibold text-slate-700 mb-1.5">Email Address</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path></svg>
                </div>
                <input id="email" 
                       class="block w-full pl-11 pr-4 py-3 rounded-xl border bg-slate-50 text-slate-900 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 {{ $errors->has('email') ? 'border-red-500' : 'border-slate-200' }}" 
                       type="email" 
                       name="email" 
                       value="{{ old('email', request()->email) }}" 
                       required 
                       autocomplete="username"
                       placeholder="name@company.com" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-semibold text-slate-700 mb-1.5">Password</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 00-2 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                </div>
                <input id="password" 
                       class="block w-full pl-11 pr-4 py-3 rounded-xl border bg-slate-50 text-slate-900 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 {{ $errors->has('password') ? 'border-red-500' : 'border-slate-200' }}"
                       type="password"
                       name="password"
                       required 
                       autocomplete="new-password"
                       placeholder="••••••••" />
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-sm font-semibold text-slate-700 mb-1.5">Confirm Password</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                </div>
                <input id="password_confirmation" 
                       class="block w-full pl-11 pr-4 py-3 rounded-xl border bg-slate-50 text-slate-900 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 {{ $errors->has('password_confirmation') ? 'border-red-500' : 'border-slate-200' }}"
                       type="password"
                       name="password_confirmation" 
                       required 
                       autocomplete="new-password"
                       placeholder="••••••••" />
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <button type="submit" class="w-full flex items-center justify-center py-3.5 px-4 rounded-xl bg-blue-600 text-white font-bold text-sm hover:bg-blue-700 focus:ring-4 focus:ring-blue-500/20 active:bg-blue-800 transition-all duration-200 shadow-lg shadow-blue-500/25">
            Create Account
            <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
        </button>
    </form>

    <div class="mt-8 pt-6 border-t border-slate-100 text-center">
        <p class="text-sm text-slate-500">
            Already have an account? 
            <a href="{{ route('login') }}" class="font-bold text-blue-600 hover:text-blue-700 transition-colors">Sign in here</a>
        </p>
    </div>
</x-guest-layout>
