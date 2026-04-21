<x-guest-layout>
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-slate-900">Forgot Password?</h2>
        <p class="mt-2 text-slate-500">No problem. Just let us know your email address and we will email you a password reset link.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-6" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
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
                       placeholder="name@company.com" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <button type="submit" class="w-full flex items-center justify-center py-3.5 px-4 rounded-xl bg-blue-600 text-white font-bold text-sm hover:bg-blue-700 focus:ring-4 focus:ring-blue-500/20 active:bg-blue-800 transition-all duration-200 shadow-lg shadow-blue-500/25">
            Email Password Reset Link
            <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
        </button>
    </form>

    <div class="mt-8 pt-6 border-t border-slate-100 text-center">
        <a href="{{ route('login') }}" class="inline-flex items-center text-sm font-bold text-blue-600 hover:text-blue-700 transition-colors">
            <svg class="mr-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Back to login
        </a>
    </div>
</x-guest-layout>
