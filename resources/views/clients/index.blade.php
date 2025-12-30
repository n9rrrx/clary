<x-app-layout>
    <div class="flex flex-col h-full w-full bg-white dark:bg-midnight-900 transition-colors duration-300">

        <div class="h-16 flex items-center justify-between px-6 border-b border-gray-200 dark:border-line shrink-0 bg-white dark:bg-midnight-900 transition-colors duration-300">
            <div class="flex items-center space-x-4">
                <h1 class="text-lg font-semibold text-gray-900 dark:text-white">Site Profiles</h1>
                <span class="px-2 py-0.5 rounded-full bg-gray-100 dark:bg-midnight-800 text-xs text-gray-500 dark:text-gray-400 border border-gray-200 dark:border-line">
                    {{ $clients->count() ?? 0 }} Total
                </span>
            </div>

            <div class="flex items-center space-x-3">
                <a href="{{ route('clients.create') }}" class="flex items-center px-4 py-2 bg-accent-600 hover:bg-accent-500 text-white rounded text-sm font-medium transition-colors shadow-lg shadow-accent-500/20">
                    <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                    New Site Profile
                </a>
            </div>
        </div>

        <div class="flex-1 overflow-auto bg-white dark:bg-midnight-900">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50 dark:bg-midnight-800 sticky top-0 z-10 shadow-sm">
                <tr>
                    <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider border-b border-gray-200 dark:border-line text-left">Site Name</th>

                    <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider border-b border-gray-200 dark:border-line text-left">Budget</th>

                    <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider border-b border-gray-200 dark:border-line text-left">Site Admin</th>

                    <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider border-b border-gray-200 dark:border-line text-left">Status</th>
                    <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider border-b border-gray-200 dark:border-line text-left">Type</th>
                    <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider border-b border-gray-200 dark:border-line text-left">Tags</th>
                    <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider border-b border-gray-200 dark:border-line text-right">Last Updated</th>
                    <th class="px-6 py-3 border-b border-gray-200 dark:border-line"></th>
                </tr>
                </thead>

                <tbody class="divide-y divide-gray-100 dark:divide-line">
                @php $lastOwnerId = null; @endphp

                @forelse ($clients ?? [] as $client)

                    {{-- SUPER ADMIN / ADMIN GROUPING HEADER --}}
                    @if((Auth::user()->role === 'super_admin' || Auth::user()->role === 'admin') && $client->user_id !== $lastOwnerId)
                        <tr class="bg-gray-50 dark:bg-midnight-800/50 border-b border-gray-200 dark:border-line">
                            <td colspan="8" class="px-6 py-2 text-xs font-bold uppercase tracking-wider text-accent-600 dark:text-accent-400">
                                Agency: {{ $client->user->name ?? 'Unknown Agency' }}
                                <span class="text-gray-400 dark:text-gray-500 font-normal ml-1">({{ $client->user->email ?? '' }})</span>
                            </td>
                        </tr>
                        @php $lastOwnerId = $client->user_id; @endphp
                    @endif

                    <tr onclick="window.location='{{ route('clients.edit', $client->id) }}'" class="hover:bg-gray-50 dark:hover:bg-midnight-800/50 transition-colors group cursor-pointer">

                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="h-8 w-8 rounded-full bg-gradient-to-br from-blue-500 to-accent-600 flex items-center justify-center text-xs font-bold text-white mr-3">
                                    {{ substr($client->name, 0, 2) }}
                                </div>
                                <div class="text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $client->name }}
                                    <div class="text-xs text-gray-500 dark:text-gray-500 font-normal">{{ $client->email }}</div>
                                </div>
                            </div>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-semibold text-gray-900 dark:text-gray-200">
                                ${{ number_format($client->budget ?? 0, 2) }}
                            </div>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900 dark:text-gray-300">
                                {{ $client->linkedUser->name ?? 'Unassigned' }}
                            </div>
                            <div class="text-[10px] text-gray-500 dark:text-gray-500 uppercase tracking-tighter">
                                {{ $client->linkedUser->designation ?? 'No Role' }}
                            </div>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs rounded-full font-medium inline-flex items-center
                                {{ $client->status === 'active'
                                    ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400 border border-transparent dark:border-green-800'
                                    : 'bg-gray-100 text-gray-600 dark:bg-gray-700/30 dark:text-gray-400 border border-transparent dark:border-gray-600'
                                }}">
                                {{ ucfirst($client->status) }}
                            </span>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
                             <span class="px-2 py-1 text-[10px] uppercase tracking-wide rounded font-semibold
                                {{ $client->type === 'customer' ? 'bg-blue-50 text-blue-600 dark:bg-blue-900/20 dark:text-blue-400' : '' }}
                                {{ $client->type === 'partner' ? 'bg-purple-50 text-purple-600 dark:bg-purple-900/20 dark:text-purple-400' : '' }}
                                {{ $client->type === 'lead' ? 'bg-yellow-50 text-yellow-600 dark:bg-yellow-900/20 dark:text-yellow-400' : '' }}
                                {{ $client->type === 'prospect' ? 'bg-orange-50 text-orange-600 dark:bg-orange-900/20 dark:text-orange-400' : '' }}">
                                {{ ucfirst($client->type) }}
                            </span>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex gap-1">
                                @foreach(is_string($client->tags) ? json_decode($client->tags, true) : ($client->tags ?? []) as $tag)
                                    <span class="px-2 py-0.5 text-[10px] rounded border border-gray-200 dark:border-gray-700 text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-midnight-800">
                                        {{ $tag }}
                                    </span>
                                @endforeach
                            </div>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-500 text-right">
                            {{ $client->updated_at->diffForHumans() }}
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('clients.edit', $client->id) }}" class="text-gray-400 hover:text-accent-600 dark:hover:text-white transition-colors group-hover:text-accent-500">
                                Edit
                            </a>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-6 py-12 text-center text-gray-500">
                            No site profiles found.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
