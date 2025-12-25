<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white text-center">Welcome back</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400 text-center mt-1">Sign in to access your dashboard</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email Address</label>
            <input id="email"
                   type="email"
                   name="email"
                   value="{{ old('email') }}"
                   required autofocus
                   autocomplete="username"
                   class="w-full rounded-lg border-gray-300 dark:border-gray-700 bg-white dark:bg-midnight-900 text-gray-900 dark:text-gray-100 focus:border-accent-500 focus:ring-accent-500 shadow-sm transition-colors"
                   placeholder="you@company.com">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <div class="flex items-center justify-between mb-1">
                <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Password</label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-sm font-medium text-accent-600 hover:text-accent-500 dark:text-accent-400 dark:hover:text-accent-300 transition-colors">
                        Forgot password?
                    </a>
                @endif
            </div>
            <input id="password"
                   type="password"
                   name="password"
                   required
                   autocomplete="current-password"
                   class="w-full rounded-lg border-gray-300 dark:border-gray-700 bg-white dark:bg-midnight-900 text-gray-900 dark:text-gray-100 focus:border-accent-500 focus:ring-accent-500 shadow-sm transition-colors"
                   placeholder="••••••••">
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center">
            <input id="remember_me" type="checkbox" name="remember" class="h-4 w-4 rounded border-gray-300 dark:border-gray-600 bg-white dark:bg-midnight-900 text-accent-600 focus:ring-accent-500 dark:focus:ring-offset-midnight-800">
            <label for="remember_me" class="ml-2 block text-sm text-gray-600 dark:text-gray-400">Remember me</label>
        </div>

        <button type="submit" class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-accent-600 hover:bg-accent-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent-500 dark:focus:ring-offset-midnight-800 transition-all duration-200">
            Sign in
        </button>
    </form>

    <div class="mt-6 text-center text-sm">
        <span class="text-gray-500 dark:text-gray-400">Don't have an account?</span>
        <a href="{{ route('register') }}" class="font-medium text-accent-600 hover:text-accent-500 dark:text-accent-400 dark:hover:text-accent-300 ml-1 transition-colors">
            Create account
        </a>
    </div>
</x-guest-layout>
