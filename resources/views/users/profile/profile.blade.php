<x-client-layout>

    <div class="mb-10">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Client Portal</h1>
        <p class="mt-2 text-gray-600 dark:text-gray-400">Track your projects, download invoices, and manage your account.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        <div class="bg-white dark:bg-midnight-800 p-6 rounded-xl border border-gray-200 dark:border-line shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-gray-500 dark:text-gray-400 text-sm font-medium uppercase">Active Projects</h3>
                <div class="p-2 bg-blue-100 dark:bg-blue-900/20 text-blue-600 rounded-lg">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                </div>
            </div>
            <p class="text-3xl font-bold text-gray-900 dark:text-white">0</p>
            <p class="text-xs text-gray-500 mt-1">Projects currently in progress</p>
        </div>

        <div class="bg-white dark:bg-midnight-800 p-6 rounded-xl border border-gray-200 dark:border-line shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-gray-500 dark:text-gray-400 text-sm font-medium uppercase">Pending Invoices</h3>
                <div class="p-2 bg-green-100 dark:bg-green-900/20 text-green-600 rounded-lg">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                </div>
            </div>
            <p class="text-3xl font-bold text-gray-900 dark:text-white">$0.00</p>
            <p class="text-xs text-gray-500 mt-1">Amount due</p>
        </div>

        <div class="bg-white dark:bg-midnight-800 p-6 rounded-xl border border-gray-200 dark:border-line shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-gray-500 dark:text-gray-400 text-sm font-medium uppercase">Support Tickets</h3>
                <div class="p-2 bg-purple-100 dark:bg-purple-900/20 text-purple-600 rounded-lg">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" /></svg>
                </div>
            </div>
            <p class="text-3xl font-bold text-gray-900 dark:text-white">0</p>
            <p class="text-xs text-gray-500 mt-1">Open support requests</p>
        </div>
    </div>

    <div class="bg-white dark:bg-midnight-800 rounded-xl border border-gray-200 dark:border-line p-10 text-center">
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 dark:bg-midnight-700 mb-4">
            <svg class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
            </svg>
        </div>
        <h3 class="text-lg font-medium text-gray-900 dark:text-white">No active projects</h3>
        <p class="mt-1 text-gray-500 dark:text-gray-400 max-w-md mx-auto">
            You don't have any projects assigned to you yet. Once the admin creates a project for you, it will appear here.
        </p>
    </div>

</x-client-layout>
