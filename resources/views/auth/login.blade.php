<x-guest-layout>
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-slate-900">Welcome Back</h2>
        <p class="mt-2 text-slate-500">Please enter your details to sign in to your account.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-6" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

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
                       value="{{ old('email') }}" 
                       required 
                       autofocus 
                       autocomplete="username"
                       placeholder="name@company.com" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex items-center justify-between mb-1.5">
                <label for="password" class="block text-sm font-semibold text-slate-700">Password</label>
                @if (Route::has('password.request'))
                    <a class="text-sm font-medium text-blue-600 hover:text-blue-700 transition-colors" href="{{ route('password.request') }}">
                        Forgot password?
                    </a>
                @endif
            </div>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 00-2 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                </div>
                <input id="password" 
                       class="block w-full pl-11 pr-4 py-3 rounded-xl border bg-slate-50 text-slate-900 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 {{ $errors->has('password') ? 'border-red-500' : 'border-slate-200' }}"
                       type="password"
                       name="password"
                       required 
                       autocomplete="current-password"
                       placeholder="••••••••" />
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <input id="remember_me" type="checkbox" class="w-4 h-4 rounded border-slate-300 text-blue-600 shadow-sm focus:ring-blue-500 transition-all duration-200" name="remember">
            <label for="remember_me" class="ml-2 text-sm text-slate-600 font-medium cursor-pointer">Remember this device</label>
        </div>

        <button type="submit" class="w-full flex items-center justify-center py-3.5 px-4 rounded-xl bg-blue-600 text-white font-bold text-sm hover:bg-blue-700 focus:ring-4 focus:ring-blue-500/20 active:bg-blue-800 transition-all duration-200 shadow-lg shadow-blue-500/25">
            Sign In
            <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
        </button>
    </form>

    <div class="mt-8 pt-6 border-t border-slate-100 text-center">
        <p class="text-sm text-slate-500">
            Don't have an account? 
            <a href="{{ route('register') }}" class="font-bold text-blue-600 hover:text-blue-700 transition-colors">Create an account</a>
        </p>
    </div>
</x-guest-layout>
