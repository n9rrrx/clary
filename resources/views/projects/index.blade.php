<x-app-layout>
    <div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        <!-- Member Info Banner (for non-owners) -->
        @if(!Auth::user()->isOwnerOfCurrentTeam() && Auth::user()->currentTeam)
            @php
                $membership = Auth::user()->teams()->where('team_id', Auth::user()->current_team_id)->first();
                $role = $membership?->pivot?->role ?? 'member';
            @endphp
            <div class="mb-6 p-4 bg-gradient-to-r from-blue-50 to-purple-50 dark:from-blue-900/20 dark:to-purple-900/20 border border-blue-200 dark:border-blue-800 rounded-xl">
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-lg bg-gradient-to-br from-blue-500 to-purple-500 flex items-center justify-center text-white font-bold text-lg">
                            {{ strtoupper(substr(Auth::user()->currentTeam->name, 0, 1)) }}
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 dark:text-white">{{ Auth::user()->currentTeam->name }}</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 capitalize">Role: {{ $role }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
            <div class="flex items-center gap-4">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Projects</h1>
                <span class="px-3 py-1 text-xs font-medium rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300">
                    {{ $projects->whereIn('status', ['planning', 'in_progress', 'on_hold'])->count() }} Active
                </span>
            </div>
            @if(Auth::user()->isOwnerOfCurrentTeam())
                <div class="mt-4 md:mt-0">
                    <a href="{{ route('projects.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 transition ease-in-out duration-150">+ New Project</a>
                </div>
            @endif
        </div>

        <div class="bg-white dark:bg-midnight-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-200 dark:border-gray-800">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-800">
                    <thead class="bg-gray-50 dark:bg-midnight-900">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Project Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Start Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Deadline</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Budget</th>
                        @if(Auth::user()->isOwnerOfCurrentTeam())
                            <th class="relative px-6 py-3"><span class="sr-only">Edit</span></th>
                        @endif
                    </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-midnight-800 divide-y divide-gray-200 dark:divide-gray-800">
                    @forelse($projects as $project)
                        <tr class="hover:bg-gray-50 dark:hover:bg-midnight-700/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="{{ route('projects.show', $project->id) }}" class="text-sm font-bold text-gray-900 dark:text-white hover:text-blue-600 dark:hover:text-blue-400 transition-colors">{{ $project->name }}</a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $statusLabels = [
                                        'planning' => 'Not Started',
                                        'in_progress' => 'In Progress',
                                        'on_hold' => 'On Hold',
                                        'completed' => 'Completed',
                                        'cancelled' => 'Cancelled',
                                    ];
                                    $statusColors = [
                                        'planning' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300 border-gray-200 dark:border-gray-600',
                                        'in_progress' => 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-300 border-purple-200 dark:border-purple-800',
                                        'on_hold' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300 border-yellow-200 dark:border-yellow-800',
                                        'completed' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300 border-green-200 dark:border-green-800',
                                        'cancelled' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300 border-red-200 dark:border-red-800',
                                    ];
                                @endphp
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $statusColors[$project->status] ?? $statusColors['planning'] }}">
                                    {{ $statusLabels[$project->status] ?? ucwords(str_replace('_', ' ', $project->status)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $project->start_date ? $project->start_date->format('M d, Y') : '—' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $project->end_date ? $project->end_date->format('M d, Y') : '—' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-green-600 dark:text-green-400">{{ $project->budget ? '$'.number_format($project->budget, 2) : '—' }}</td>

                            @if(Auth::user()->isOwnerOfCurrentTeam())
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('projects.edit', $project->id) }}" class="text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Edit</a>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                                </svg>
                                <p class="text-sm">No projects found. Create your first project!</p>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($projects->hasPages())
            <div class="mt-4">
                {{ $projects->links() }}
            </div>
        @endif
    </div>
</x-app-layout>