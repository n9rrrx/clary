<x-app-layout>
    <div class="flex flex-col h-full w-full bg-white dark:bg-midnight-900 transition-colors duration-300">

        <div class="h-16 flex items-center justify-between px-6 border-b border-gray-200 dark:border-line shrink-0 bg-white dark:bg-midnight-900 transition-colors duration-300">
            <div class="flex items-center space-x-4">
                <h1 class="text-lg font-semibold text-gray-900 dark:text-white">Clients</h1>
                <span class="px-2 py-0.5 rounded-full bg-gray-100 dark:bg-midnight-800 text-xs text-gray-500 dark:text-gray-400 border border-gray-200 dark:border-line">
                    {{ $clients->count() ?? 0 }} Total
                </span>
                <x-plan-usage resource="clients" />
            </div>

            <div class="flex items-center space-x-3">
                <a href="{{ route('clients.create') }}" class="flex items-center px-4 py-2 bg-accent-600 hover:bg-accent-500 text-white rounded text-sm font-medium transition-colors shadow-lg shadow-accent-500/20">
                    <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                    Add Client
                </a>
            </div>
        </div>

        <div class="flex-1 overflow-auto bg-white dark:bg-midnight-900">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50 dark:bg-midnight-800 sticky top-0 z-10 shadow-sm">
                <tr>
                    <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider border-b border-gray-200 dark:border-line text-left">Client</th>
                    <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider border-b border-gray-200 dark:border-line text-left">Type</th>
                    <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider border-b border-gray-200 dark:border-line text-left">Tag</th>
                    <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider border-b border-gray-200 dark:border-line text-right">Last Updated</th>
                    <th class="px-6 py-3 border-b border-gray-200 dark:border-line"></th>
                </tr>
                </thead>

                <tbody class="divide-y divide-gray-100 dark:divide-line">
                @forelse ($clients ?? [] as $client)
                    <tr onclick="window.location='{{ route('clients.edit', $client->id) }}'" class="hover:bg-gray-50 dark:hover:bg-midnight-800/50 transition-colors group cursor-pointer">

                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="h-10 w-10 rounded-full bg-gradient-to-br from-blue-500 to-accent-600 flex items-center justify-center text-sm font-bold text-white mr-3">
                                    {{ strtoupper(substr($client->name, 0, 2)) }}
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $client->name }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-500">{{ $client->email }}</div>
                                </div>
                            </div>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
                             <span class="px-2.5 py-1 text-xs uppercase tracking-wide rounded-full font-medium
                                {{ $client->type === 'customer' ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' : '' }}
                                {{ $client->type === 'partner' ? 'bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-400' : '' }}
                                {{ $client->type === 'lead' ? 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400' : '' }}
                                {{ $client->type === 'prospect' ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400' : '' }}">
                                {{ ucfirst($client->type) }}
                            </span>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $tags = is_array($client->tags) ? $client->tags : (is_string($client->tags) ? json_decode($client->tags, true) : []);
                            @endphp
                            @foreach($tags ?? [] as $tag)
                                <span class="px-2 py-0.5 text-xs rounded border border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-400 bg-gray-50 dark:bg-midnight-800">
                                    {{ $tag }}
                                </span>
                            @endforeach
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-500 text-right">
                            {{ $client->updated_at->diffForHumans() }}
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('clients.edit', $client->id) }}" class="text-accent-600 hover:text-accent-500 dark:text-accent-400 dark:hover:text-accent-300 transition-colors">
                                Edit
                            </a>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                            <div class="flex flex-col items-center">
                                <svg class="w-12 h-12 text-gray-300 dark:text-gray-600 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                                <p class="text-sm">No clients found.</p>
                                <a href="{{ route('clients.create') }}" class="mt-3 text-sm text-accent-600 hover:text-accent-500">Add your first client →</a>
                            </div>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
