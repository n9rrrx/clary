<x-app-layout>
    <div class="flex h-full w-full bg-gray-50 dark:bg-midnight-900 text-gray-900 dark:text-gray-300 transition-colors duration-300">

        <aside class="w-80 flex flex-col border-r border-gray-200 dark:border-line bg-white dark:bg-[#0f111a] transition-colors duration-300">
            <div class="h-14 flex items-center justify-between px-4 border-b border-gray-200 dark:border-line shrink-0">
                <h2 class="font-semibold text-gray-900 dark:text-white">Updates</h2>
                <button class="flex items-center text-xs border border-gray-300 dark:border-line px-2 py-1 rounded text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors">
                    <svg class="w-3 h-3 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" /></svg>
                    Display
                </button>
            </div>

            <div class="flex-1 overflow-y-auto">
                @forelse($updates as $client)
                    @php
                        $isActive = (isset($selectedClient) && $selectedClient->id === $client->id);
                    @endphp

                    <a href="{{ route('dashboard', ['client_id' => $client->id]) }}"
                       class="block group px-4 py-3 border-l-2 cursor-pointer transition-colors
                       {{ $isActive
                           ? 'border-accent-500 bg-gray-100 dark:bg-midnight-800'
                           : 'border-transparent hover:bg-gray-50 dark:hover:bg-midnight-800/50'
                       }}">

                        <div class="flex justify-between items-start mb-1">
                            <div class="flex items-center">
                                <div class="w-2 h-2 rounded-full mr-2 {{ $client->status === 'active' ? 'bg-green-500' : 'bg-gray-400' }}"></div>
                                <span class="text-sm font-semibold {{ $isActive ? 'text-gray-900 dark:text-white' : 'text-gray-700 dark:text-gray-300 group-hover:text-gray-900 dark:group-hover:text-white' }}">
                                    {{ $client->name }}
                                </span>
                            </div>
                            <span class="text-[10px] text-gray-400 dark:text-gray-500">{{ $client->updated_at->diffForHumans(null, true) }}</span>
                        </div>

                        <p class="text-xs text-gray-500 dark:text-gray-500 pl-4 truncate group-hover:text-gray-600 dark:group-hover:text-gray-400">
                            @if($client->latestActivity)
                                <span class="font-medium text-gray-600 dark:text-gray-400">{{ $client->latestActivity->user->name }}:</span>
                                {{ Str::limit($client->latestActivity->description, 30) }}
                            @else
                                No recent activity
                            @endif
                        </p>
                    </a>
                @empty
                    <div class="p-4 text-center text-xs text-gray-500">
                        No clients found.
                    </div>
                @endforelse
            </div>
        </aside>

        <main class="flex-1 flex flex-col min-w-0 bg-gray-50 dark:bg-[#0f111a] transition-colors duration-300">
            @if($selectedClient)
                <div class="h-14 flex items-center px-6 border-b border-gray-200 dark:border-line shrink-0 bg-white dark:bg-[#0f111a] transition-colors duration-300">
                    <div class="text-sm text-gray-500">
                        Contacts <span class="mx-2 text-gray-400 dark:text-gray-600">›</span> <span class="text-gray-900 dark:text-gray-200">{{ $selectedClient->name }}</span>
                    </div>
                </div>

                <div class="h-12 border-b border-gray-200 dark:border-line flex items-center px-6 space-x-4 shrink-0 bg-white dark:bg-[#0f111a] transition-colors duration-300">
                    <button class="flex items-center text-sm text-gray-900 dark:text-gray-100 font-medium border-b-2 border-accent-500 h-full px-1">
                        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                        Activity
                    </button>
                    <button class="flex items-center text-sm text-gray-500 hover:text-gray-900 dark:hover:text-white h-full px-1 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                        Tasks
                    </button>
                </div>

                <div class="flex-1 overflow-y-auto p-8">
                    <div class="max-w-3xl mx-auto">
                        <h3 class="text-sm font-bold text-gray-900 dark:text-white mb-6">Activity</h3>

                        <div class="relative pl-8 border-l border-gray-200 dark:border-line space-y-8">

                            @forelse($feed as $activity)
                                <div class="relative group">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($activity->user->name) }}&background=random&color=fff"
                                         class="absolute -left-[43px] w-6 h-6 rounded-full ring-4 ring-gray-50 dark:ring-[#0f111a]">

                                    <div class="text-sm {{ $activity->type === 'comment' ? 'mb-2' : '' }}">
                                        <span class="text-gray-900 dark:text-gray-200 font-medium">{{ $activity->user->name }}</span>
                                        <span class="text-gray-600 dark:text-gray-500 ml-1">{{ $activity->description }}</span>
                                        <span class="text-gray-400 dark:text-gray-600 text-xs ml-2">• {{ $activity->created_at->diffForHumans() }}</span>
                                    </div>

                                    @if($activity->type === 'comment' && $activity->body)
                                        <div class="bg-white dark:bg-[#161b22] border border-gray-200 dark:border-line rounded-lg p-3 text-sm text-gray-700 dark:text-gray-300 shadow-sm">
                                            {{ $activity->body }}
                                        </div>
                                    @endif
                                </div>
                            @empty
                                <div class="text-sm text-gray-500 italic">No activity recorded yet.</div>
                            @endforelse

                        </div>

                        <div class="mt-8 pl-8">
                            <div class="bg-white dark:bg-[#161b22] border border-gray-200 dark:border-line rounded-lg p-3 shadow-sm">
                                <textarea class="w-full bg-transparent border-none text-gray-800 dark:text-gray-300 text-sm focus:ring-0 placeholder-gray-400 dark:placeholder-gray-600 resize-none h-20" placeholder="Write your comment..."></textarea>
                                <div class="flex justify-between items-center mt-2 pt-2 border-t border-gray-100 dark:border-line/50">
                                    <button class="text-gray-400 hover:text-gray-600 dark:hover:text-white">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" /></svg>
                                    </button>
                                    <button class="bg-accent-600 hover:bg-accent-500 text-white text-xs font-medium px-4 py-1.5 rounded transition-colors">
                                        Comment
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="flex-1 flex items-center justify-center text-gray-500">
                    Select a client to view activity.
                </div>
            @endif
        </main>

        <aside class="w-80 border-l border-gray-200 dark:border-line bg-white dark:bg-[#0f111a] hidden xl:flex flex-col transition-colors duration-300">
            @if($selectedClient)
                <div class="h-14 flex items-center justify-end px-4 border-b border-gray-200 dark:border-line shrink-0 space-x-2">
                    <button class="text-xs font-medium text-gray-500 dark:text-gray-400 border border-gray-200 dark:border-line px-2 py-1 rounded hover:text-gray-900 dark:hover:text-white transition-colors">Delete notification</button>
                    <button class="text-xs font-medium text-gray-500 dark:text-gray-400 border border-gray-200 dark:border-line px-2 py-1 rounded hover:text-gray-900 dark:hover:text-white transition-colors flex items-center">
                        <svg class="w-3 h-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        Snooze
                    </button>
                </div>

                <div class="p-6">
                    <div class="flex items-center mb-6">
                        <div class="h-10 w-10 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-gray-600 dark:text-gray-300 font-bold text-sm mr-3">
                            {{ substr($selectedClient->name, 0, 2) }}
                        </div>
                        <div>
                            <h3 class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $selectedClient->name }}</h3>
                            <p class="text-xs text-gray-500">{{ $selectedClient->email }}</p>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div class="flex items-center justify-between cursor-pointer group">
                            <span class="text-xs font-medium text-gray-500 group-hover:text-gray-900 dark:group-hover:text-gray-300">Details</span>
                            <svg class="w-3 h-3 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        </div>

                        <div class="grid grid-cols-3 gap-y-4 text-xs">
                            <div class="text-gray-500">Type</div>
                            <div class="col-span-2 flex items-center">
                                <span class="w-2 h-2 rounded-full {{ $selectedClient->type === 'customer' ? 'bg-purple-500' : 'bg-blue-500' }} mr-2"></span>
                                <span class="text-gray-700 dark:text-gray-300 capitalize">{{ $selectedClient->type }}</span>
                            </div>

                            <div class="text-gray-500">Status</div>
                            <div class="col-span-2 flex items-center">
                                <span class="w-2 h-2 rounded-full {{ $selectedClient->status === 'active' ? 'bg-green-500' : 'bg-orange-500' }} mr-2"></span>
                                <span class="text-gray-700 dark:text-gray-300 capitalize">{{ $selectedClient->status }}</span>
                            </div>

                            <div class="text-gray-500">Signed up</div>
                            <div class="col-span-2 text-gray-700 dark:text-gray-300">{{ $selectedClient->created_at->format('F j, Y') }}</div>

                            <div class="text-gray-500 mt-1">Tags</div>
                            <div class="col-span-2">
                                <button class="text-gray-500 hover:text-gray-900 dark:hover:text-white flex items-center">
                                    <span class="mr-1 text-lg leading-none">+</span> Add tag
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </aside>

    </div>
</x-app-layout>
