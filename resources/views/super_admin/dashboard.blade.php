<x-app-layout>
    <div class="flex h-full w-full items-center justify-center bg-gray-50 dark:bg-midnight-900 transition-colors duration-300">
        <div class="text-center max-w-2xl w-full px-4">

            <h1 class="text-4xl font-bold text-accent-600 dark:text-accent-500 mb-2">Super Admin Dashboard</h1>
            <p class="text-gray-600 dark:text-gray-400 text-lg">Welcome, Boss. You have full control here.</p>

            <div class="mt-10 p-8 bg-white dark:bg-midnight-800 rounded-2xl border border-gray-200 dark:border-line shadow-sm transition-colors duration-300">
                <h2 class="text-gray-900 dark:text-white font-semibold text-xl mb-6">Global System Stats</h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div class="p-6 bg-gray-50 dark:bg-midnight-700/50 rounded-xl border border-gray-100 dark:border-gray-700 flex flex-col items-center justify-center">
                        <span class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-1">Total Users</span>
                        <span class="text-3xl font-extrabold text-gray-900 dark:text-white">{{ \App\Models\User::count() }}</span>
                    </div>

                    <div class="p-6 bg-gray-50 dark:bg-midnight-700/50 rounded-xl border border-gray-100 dark:border-gray-700 flex flex-col items-center justify-center">
                        <span class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-1">Total Clients</span>
                        <span class="text-3xl font-extrabold text-gray-900 dark:text-white">{{ \App\Models\Client::count() }}</span>
                    </div>
                </div>
            </div>

            <div class="mt-6 text-sm text-gray-400 dark:text-gray-600">
                System is running smoothly.
            </div>

        </div>
    </div>
</x-app-layout>
