<x-app-layout>
    <div class="flex h-screen bg-gray-900 text-white items-center justify-center">
        <div class="text-center">
            <h1 class="text-4xl font-bold text-accent-500 mb-4">Super Admin Dashboard</h1>
            <p class="text-gray-400">Welcome, Boss. You have full control here.</p>

            <div class="mt-8 p-6 bg-gray-800 rounded-lg border border-gray-700">
                <p>Global System Stats</p>
                <div class="flex gap-4 mt-4">
                    <div class="p-4 bg-gray-700 rounded">Total Users: {{ \App\Models\User::count() }}</div>
                    <div class="p-4 bg-gray-700 rounded">Total Clients: {{ \App\Models\Client::count() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
