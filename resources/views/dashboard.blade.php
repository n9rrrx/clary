<x-app-layout>
    <div class="h-full w-full overflow-y-auto bg-gray-50 dark:bg-midnight-900 transition-colors duration-300">

        {{-- Check if user is owner or member --}}
        @php
            $isOwner = Auth::user()->isOwnerOfCurrentTeam();
        @endphp

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            {{-- Header --}}
            <div class="mb-8">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                    @if($isOwner)
                        Welcome back, {{ Auth::user()->name }}
                    @else
                        My Dashboard
                    @endif
                </h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    @if($isOwner)
                        Here's what's happening with your team today.
                    @else
                        Your assigned projects and tasks at a glance.
                    @endif
                </p>
            </div>

            @if($isOwner)
                {{-- OWNER DASHBOARD --}}

                {{-- Quick Stats --}}
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                    <div class="bg-white dark:bg-midnight-800 rounded-xl p-6 border border-gray-200 dark:border-gray-800 shadow-sm">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Total Clients</p>
                                <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $updates->count() }}</p>
                            </div>
                            <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-midnight-800 rounded-xl p-6 border border-gray-200 dark:border-gray-800 shadow-sm">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Active Projects</p>
                                <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $team ? \App\Models\Project::where('team_id', $team->id)->where('status', 'in_progress')->count() : 0 }}</p>
                            </div>
                            <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/30 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-midnight-800 rounded-xl p-6 border border-gray-200 dark:border-gray-800 shadow-sm">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Team Members</p>
                                <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $team ? $team->members()->wherePivot('role', '!=', 'owner')->count() : 0 }}</p>
                            </div>
                            <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-midnight-800 rounded-xl p-6 border border-gray-200 dark:border-gray-800 shadow-sm">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Pending Tasks</p>
                                <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $team ? \App\Models\Task::whereHas('project', fn($q) => $q->where('team_id', $team->id))->where('status', '!=', 'completed')->count() : 0 }}</p>
                            </div>
                            <div class="w-12 h-12 bg-orange-100 dark:bg-orange-900/30 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-orange-600 dark:text-orange-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Recent Clients & Projects --}}
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

                    {{-- Recent Clients --}}
                    <div class="bg-white dark:bg-midnight-800 rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm">
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                            <h2 class="font-semibold text-gray-900 dark:text-white">Recent Clients</h2>
                            <a href="{{ route('clients.index') }}" class="text-sm text-blue-600 dark:text-blue-400 hover:underline">View all →</a>
                        </div>
                        <div class="divide-y divide-gray-100 dark:divide-gray-700">
                            @forelse($updates->take(5) as $client)
                                <a href="{{ route('clients.edit', $client->id) }}" class="flex items-center px-6 py-4 hover:bg-gray-50 dark:hover:bg-midnight-700 transition-colors">
                                    <div class="h-10 w-10 rounded-full bg-gradient-to-br from-blue-500 to-accent-600 flex items-center justify-center text-sm font-bold text-white mr-4">
                                        {{ strtoupper(substr($client->name, 0, 2)) }}
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ $client->name }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $client->email }}</p>
                                    </div>
                                    <span class="px-2 py-1 text-xs rounded-full capitalize
                                        {{ $client->type === 'customer' ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' : '' }}
                                        {{ $client->type === 'prospect' ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400' : '' }}
                                        {{ $client->type === 'lead' ? 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400' : '' }}
                                        {{ $client->type === 'partner' ? 'bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-400' : '' }}">
                                        {{ $client->type }}
                                    </span>
                                </a>
                            @empty
                                <div class="px-6 py-8 text-center text-sm text-gray-500 dark:text-gray-400">
                                    No clients yet. <a href="{{ route('clients.create') }}" class="text-blue-600 hover:underline">Add your first client</a>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    {{-- Recent Projects --}}
                    <div class="bg-white dark:bg-midnight-800 rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm">
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                            <h2 class="font-semibold text-gray-900 dark:text-white">Recent Projects</h2>
                            <a href="{{ route('projects.index') }}" class="text-sm text-blue-600 dark:text-blue-400 hover:underline">View all →</a>
                        </div>
                        <div class="divide-y divide-gray-100 dark:divide-gray-700">
                            @php
                                $recentProjects = $team ? \App\Models\Project::where('team_id', $team->id)->with('client')->orderByDesc('updated_at')->take(5)->get() : collect();
                            @endphp
                            @forelse($recentProjects as $project)
                                <a href="{{ route('projects.show', $project->id) }}" class="flex items-center px-6 py-4 hover:bg-gray-50 dark:hover:bg-midnight-700 transition-colors">
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ $project->name }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $project->client?->name ?? 'No client' }}</p>
                                    </div>
                                    @php
                                        $statusColors = [
                                            'planning' => 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300',
                                            'in_progress' => 'bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-400',
                                            'completed' => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400',
                                            'on_hold' => 'bg-orange-100 text-orange-700 dark:bg-orange-900/30 dark:text-orange-400',
                                            'cancelled' => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400',
                                        ];
                                        $statusLabels = ['planning' => 'Not Started', 'in_progress' => 'In Progress', 'completed' => 'Completed', 'on_hold' => 'On Hold', 'cancelled' => 'Cancelled'];
                                    @endphp
                                    <span class="px-2 py-1 text-xs rounded-full {{ $statusColors[$project->status] ?? 'bg-gray-100 text-gray-700' }}">
                                        {{ $statusLabels[$project->status] ?? ucwords(str_replace('_', ' ', $project->status)) }}
                                    </span>
                                </a>
                            @empty
                                <div class="px-6 py-8 text-center text-sm text-gray-500 dark:text-gray-400">
                                    No projects yet. <a href="{{ route('projects.create') }}" class="text-blue-600 hover:underline">Create your first project</a>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

            @else
                {{-- MEMBER DASHBOARD --}}

                {{-- My Stats --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-white dark:bg-midnight-800 rounded-xl p-6 border border-gray-200 dark:border-gray-800 shadow-sm">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">My Projects</p>
                                <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $assignedProjects->count() }}</p>
                            </div>
                            <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/30 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    @php
                        $myTasks = \App\Models\Task::where('assigned_to_user_id', Auth::id())->get();
                        $pendingTasks = $myTasks->where('status', '!=', 'completed')->count();
                        $completedTasks = $myTasks->where('status', 'completed')->count();
                    @endphp

                    <div class="bg-white dark:bg-midnight-800 rounded-xl p-6 border border-gray-200 dark:border-gray-800 shadow-sm">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Pending Tasks</p>
                                <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $pendingTasks }}</p>
                            </div>
                            <div class="w-12 h-12 bg-orange-100 dark:bg-orange-900/30 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-orange-600 dark:text-orange-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-midnight-800 rounded-xl p-6 border border-gray-200 dark:border-gray-800 shadow-sm">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Completed Tasks</p>
                                <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $completedTasks }}</p>
                            </div>
                            <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- My Assigned Projects --}}
                @if($assignedProjects->count() > 0)
                    <div class="mb-8">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">My Projects</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($assignedProjects as $project)
                                <a href="{{ route('projects.show', $project->id) }}"
                                   class="block bg-white dark:bg-midnight-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 p-6 hover:shadow-lg hover:border-blue-300 dark:hover:border-blue-700 transition-all group">
                                    <div class="flex items-start justify-between mb-3">
                                        <h3 class="font-bold text-gray-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
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
                                            $statusLabels = ['planning' => 'Not Started', 'in_progress' => 'In Progress', 'completed' => 'Completed', 'on_hold' => 'On Hold', 'cancelled' => 'Cancelled'];
                                        @endphp
                                        <span class="px-2 py-1 text-xs font-medium rounded-full {{ $statusColors[$project->status] ?? 'bg-gray-100' }}">
                                            {{ $statusLabels[$project->status] ?? $project->status }}
                                        </span>
                                    </div>

                                    @if($project->client)
                                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-3">Client: {{ $project->client->name }}</p>
                                    @endif

                                    @if($project->end_date)
                                        <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                                            <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            Due: {{ $project->end_date->format('M d, Y') }}
                                        </div>
                                    @endif
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- My Tasks --}}
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">My Tasks</h2>
                        <a href="{{ route('tasks.index') }}" class="text-sm text-blue-600 dark:text-blue-400 hover:underline">View all →</a>
                    </div>

                    <div class="bg-white dark:bg-midnight-800 rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm divide-y divide-gray-100 dark:divide-gray-700">
                        @forelse($myTasks->where('status', '!=', 'completed')->take(5) as $task)
                            <a href="{{ route('tasks.edit', $task->id) }}" class="flex items-center px-6 py-4 hover:bg-gray-50 dark:hover:bg-midnight-700 transition-colors">
                                <div class="w-4 h-4 rounded-full border-2 mr-4
                                    {{ $task->status === 'in_progress' ? 'bg-blue-500 border-blue-500' : 'border-gray-400' }}"></div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ $task->title }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $task->project?->name ?? 'No project' }}</p>
                                </div>
                                <div class="flex items-center gap-3">
                                    <span class="text-xs uppercase font-bold px-2 py-1 rounded
                                        {{ $task->priority === 'high' ? 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400' : '' }}
                                        {{ $task->priority === 'medium' ? 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400' : '' }}
                                        {{ $task->priority === 'low' ? 'bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-400' : '' }}">
                                        {{ $task->priority }}
                                    </span>
                                    @if($task->due_date)
                                        <span class="text-xs text-gray-500">{{ $task->due_date->format('M d') }}</span>
                                    @endif
                                </div>
                            </a>
                        @empty
                            <div class="px-6 py-8 text-center text-sm text-gray-500 dark:text-gray-400">
                                No pending tasks. You're all caught up! 🎉
                            </div>
                        @endforelse
                    </div>
                </div>

            @endif
        </div>
    </div>
</x-app-layout>
