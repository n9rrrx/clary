<x-guest-layout>

    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white text-center">Create Account</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400 text-center mt-1">Join Clary to manage your projects</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Full Name</label>
            <input id="name"
                   type="text"
                   name="name"
                   value="{{ old('name') }}"
                   required autofocus
                   autocomplete="name"
                   class="w-full rounded-lg border-gray-300 dark:border-gray-700 bg-white dark:bg-midnight-900 text-gray-900 dark:text-gray-100 focus:border-accent-500 focus:ring-accent-500 shadow-sm transition-colors"
                   placeholder="John Doe">
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email Address</label>
            <input id="email"
                   type="email"
                   name="email"
                   value="{{ old('email') }}"
                   required
                   autocomplete="username"
                   class="w-full rounded-lg border-gray-300 dark:border-gray-700 bg-white dark:bg-midnight-900 text-gray-900 dark:text-gray-100 focus:border-accent-500 focus:ring-accent-500 shadow-sm transition-colors"
                   placeholder="you@company.com">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Password</label>
            <input id="password"
                   type="password"
                   name="password"
                   required
                   autocomplete="new-password"
                   class="w-full rounded-lg border-gray-300 dark:border-gray-700 bg-white dark:bg-midnight-900 text-gray-900 dark:text-gray-100 focus:border-accent-500 focus:ring-accent-500 shadow-sm transition-colors"
                   placeholder="••••••••">
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Confirm Password</label>
            <input id="password_confirmation"
                   type="password"
                   name="password_confirmation"
                   required
                   autocomplete="new-password"
                   class="w-full rounded-lg border-gray-300 dark:border-gray-700 bg-white dark:bg-midnight-900 text-gray-900 dark:text-gray-100 focus:border-accent-500 focus:ring-accent-500 shadow-sm transition-colors"
                   placeholder="••••••••">
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <button type="submit" class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-accent-600 hover:bg-accent-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent-500 dark:focus:ring-offset-midnight-800 transition-all duration-200">
            Get Started
        </button>
    </form>

    <div class="mt-6 text-center text-sm">
        <span class="text-gray-500 dark:text-gray-400">Already have an account?</span>
        <a href="{{ route('login') }}" class="font-medium text-accent-600 hover:text-accent-500 dark:text-accent-400 dark:hover:text-accent-300 ml-1 transition-colors">
            Sign in
        </a>
    </div>
</x-guest-layout>
