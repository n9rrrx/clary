<x-app-layout>
    <div class="flex h-full w-full bg-gray-50 dark:bg-midnight-900 text-gray-900 dark:text-gray-300 transition-colors duration-300">

        <aside class="w-80 flex flex-col border-r border-gray-200 dark:border-line bg-white dark:bg-[#0f111a] transition-colors duration-300">
            <div class="h-14 flex items-center justify-between px-4 border-b border-gray-200 dark:border-line shrink-0">
                <h2 class="font-semibold text-gray-900 dark:text-white">Updates</h2>

                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center text-xs border border-gray-300 dark:border-line px-2 py-1 rounded text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors">
                        <svg class="w-3 h-3 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" /></svg>
                        Display
                    </button>
                    <div x-show="open" @click.away="open = false"
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="transform opacity-0 scale-95"
                         x-transition:enter-end="transform opacity-100 scale-100"
                         class="absolute right-0 mt-2 w-32 bg-white dark:bg-midnight-800 rounded-md shadow-lg py-1 z-50 border border-gray-200 dark:border-line origin-top-right">
                        <a href="{{ route('dashboard', ['sort' => 'desc']) }}" class="block px-4 py-2 text-xs text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-midnight-700">Newest First</a>
                        <a href="{{ route('dashboard', ['sort' => 'asc']) }}" class="block px-4 py-2 text-xs text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-midnight-700">Oldest First</a>
                    </div>
                </div>
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
                    <a href="{{ route('dashboard', ['client_id' => $selectedClient->id, 'tab' => 'activity']) }}"
                       class="flex items-center text-sm font-medium h-full px-1 transition-colors
                       {{ $tab === 'activity'
                          ? 'text-gray-900 dark:text-gray-100 border-b-2 border-accent-500'
                          : 'text-gray-500 hover:text-gray-900 dark:hover:text-white border-b-2 border-transparent'
                       }}">
                        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                        Activity
                    </a>

                    <a href="{{ route('dashboard', ['client_id' => $selectedClient->id, 'tab' => 'tasks']) }}"
                       class="flex items-center text-sm font-medium h-full px-1 transition-colors
                       {{ $tab === 'tasks'
                          ? 'text-gray-900 dark:text-gray-100 border-b-2 border-accent-500'
                          : 'text-gray-500 hover:text-gray-900 dark:hover:text-white border-b-2 border-transparent'
                       }}">
                        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                        Tasks
                    </a>
                </div>

                <div class="flex-1 overflow-y-auto p-8">
                    <div class="max-w-3xl mx-auto">

                        @if($tab === 'activity')
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
                                    <form action="{{ route('dashboard.activity.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="client_id" value="{{ $selectedClient->id }}">

                                        <textarea name="body" required
                                                  class="w-full bg-transparent border-none text-gray-800 dark:text-gray-300 text-sm focus:ring-0 placeholder-gray-400 dark:placeholder-gray-600 resize-none h-20"
                                                  placeholder="Write your comment..."></textarea>

                                        <div class="flex justify-between items-center mt-2 pt-2 border-t border-gray-100 dark:border-line/50">
                                            <button type="button" class="text-gray-400 hover:text-gray-600 dark:hover:text-white">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" /></svg>
                                            </button>
                                            <button type="submit" class="bg-accent-600 hover:bg-accent-500 text-white text-xs font-medium px-4 py-1.5 rounded transition-colors">
                                                Comment
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                        @elseif($tab === 'tasks')
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="text-sm font-bold text-gray-900 dark:text-white">Tasks for {{ $selectedClient->name }}</h3>
                                <a href="{{ route('tasks.create') }}" class="text-xs bg-blue-600 hover:bg-blue-500 text-white px-3 py-1.5 rounded font-medium transition-colors">
                                    + New Task
                                </a>
                            </div>

                            <div class="space-y-3">
                                @forelse($clientTasks as $task)
                                    <div class="flex items-center justify-between bg-white dark:bg-[#161b22] border border-gray-200 dark:border-line p-3 rounded-lg shadow-sm hover:border-blue-400 transition-colors group">
                                        <div class="flex items-center gap-3">
                                            <div class="w-4 h-4 rounded-full border-2
                                                {{ match($task->status) {
                                                    'completed' => 'bg-green-500 border-green-500',
                                                    'in_progress' => 'bg-blue-500 border-blue-500',
                                                    default => 'border-gray-400',
                                                } }}"></div>
                                            <div>
                                                <a href="{{ route('tasks.edit', $task->id) }}" class="text-sm font-medium text-gray-900 dark:text-white hover:text-blue-500 {{ $task->status == 'completed' ? 'line-through text-gray-500' : '' }}">
                                                    {{ $task->title }}
                                                </a>
                                                <div class="text-xs text-gray-500 dark:text-gray-500">
                                                    Project: {{ $task->project->name }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <span class="text-[10px] uppercase font-bold text-gray-400">{{ $task->priority }}</span>
                                            <span class="text-xs text-gray-500">{{ $task->due_date ? $task->due_date->format('M d') : '' }}</span>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-10 border-2 border-dashed border-gray-200 dark:border-gray-700 rounded-lg">
                                        <p class="text-sm text-gray-500">No tasks found for this client's projects.</p>
                                    </div>
                                @endforelse
                            </div>
                        @endif

                    </div>
                </div>
            @else
                {{-- Show assigned projects for members --}}
                @if(isset($assignedProjects) && $assignedProjects->count() > 0)
                    <div class="flex-1 overflow-y-auto p-8">
                        <div class="max-w-5xl mx-auto">
                            <div class="mb-6">
                                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">My Assigned Projects</h2>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Projects you're assigned to work on</p>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                @foreach($assignedProjects as $project)
                                    <a href="{{ route('projects.show', $project->id) }}" 
                                       class="block bg-white dark:bg-midnight-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 p-6 hover:shadow-lg hover:border-blue-300 dark:hover:border-blue-700 transition-all group">
                                        <div class="flex items-start justify-between mb-4">
                                            <div class="flex-1">
                                                <h3 class="font-bold text-lg text-gray-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors mb-2">
                                                    {{ $project->name }}
                                                </h3>
                                                @php
                                                    $statusColors = [
                                                        'planning' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
                                                        'in_progress' => 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-300',
                                                        'completed' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300',
                                                        'on_hold' => 'bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-300',
                                                        'cancelled' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300',
                                                    ];
                                                    $statusLabels = [
                                                        'planning' => 'Not Started',
                                                        'in_progress' => 'In Progress',
                                                        'completed' => 'Completed',
                                                        'on_hold' => 'On Hold',
                                                        'cancelled' => 'Cancelled',
                                                    ];
                                                    $statusColor = $statusColors[$project->status] ?? 'bg-gray-100 text-gray-800';
                                                    $statusLabel = $statusLabels[$project->status] ?? ucwords(str_replace('_', ' ', $project->status));
                                                @endphp
                                                <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full {{ $statusColor }}">
                                                    {{ $statusLabel }}
                                                </span>
                                            </div>
                                        </div>

                                        @if($project->description)
                                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4 line-clamp-2">
                                                {{ $project->description }}
                                            </p>
                                        @endif

                                        <div class="space-y-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                                            @if($project->budget)
                                                <div class="flex items-center justify-between text-sm">
                                                    <span class="text-gray-500 dark:text-gray-400">Budget</span>
                                                    <span class="font-bold text-green-600 dark:text-green-400">
                                                        ${{ number_format($project->budget, 2) }}
                                                    </span>
                                                </div>
                                            @endif

                                            @if($project->start_date)
                                                <div class="flex items-center justify-between text-sm">
                                                    <span class="text-gray-500 dark:text-gray-400">Start Date</span>
                                                    <span class="font-medium text-gray-900 dark:text-white">
                                                        {{ $project->start_date->format('M d, Y') }}
                                                    </span>
                                                </div>
                                            @endif

                                            @if($project->end_date)
                                                <div class="flex items-center justify-between text-sm">
                                                    <span class="text-gray-500 dark:text-gray-400">End Date</span>
                                                    <span class="font-medium text-gray-900 dark:text-white">
                                                        {{ $project->end_date->format('M d, Y') }}
                                                    </span>
                                                </div>
                                            @endif

                                            @if($project->client)
                                                <div class="flex items-center justify-between text-sm">
                                                    <span class="text-gray-500 dark:text-gray-400">Client</span>
                                                    <span class="font-medium text-gray-900 dark:text-white">
                                                        {{ $project->client->name }}
                                                    </span>
                                                </div>
                                            @endif
                                        </div>

                                        <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                                            <span class="text-blue-600 dark:text-blue-400 text-sm font-medium group-hover:underline">
                                                View Project Details →
                                            </span>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @else
                    <div class="flex-1 flex items-center justify-center">
                        <div class="text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <p class="text-gray-500 dark:text-gray-400 mb-2">No projects assigned yet</p>
                            <p class="text-sm text-gray-400 dark:text-gray-500">Contact your team admin to get assigned to projects.</p>
                        </div>
                    </div>
                @endif
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

                <div class="p-6" x-data="{ open: true }">
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
                        <div @click="open = !open" class="flex items-center justify-between cursor-pointer group select-none">
                            <span class="text-xs font-medium text-gray-500 group-hover:text-gray-900 dark:group-hover:text-gray-300">Details</span>
                            <svg class="w-3 h-3 text-gray-500 transition-transform duration-200"
                                 :class="{ 'rotate-180': !open }"
                                 fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>

                        <div x-show="open" x-collapse class="grid grid-cols-3 gap-y-4 text-xs">
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


                        </div>
                    </div>
                </div>
            @endif
        </aside>

    </div>
</x-app-layout>
