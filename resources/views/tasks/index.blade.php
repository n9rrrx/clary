<x-app-layout>
    <div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">

        <!-- Member Info Banner (for non-owners) -->
        @if(!Auth::user()->isOwnerOfCurrentTeam() && Auth::user()->currentTeam)
            @php
                $membership = Auth::user()->teams()->where('team_id', Auth::user()->current_team_id)->first();
                $budget = $membership?->pivot?->budget_limit ?? 0;
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
                    <div class="flex items-center gap-6">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">${{ number_format($budget, 2) }}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">Your Budget</div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="flex items-center justify-between mb-8">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">My Tasks</h1>
            @if(Auth::user()->isOwnerOfCurrentTeam())
                <a href="{{ route('tasks.create') }}" class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 shadow-lg shadow-blue-500/30 transition-all">
                    + Add Task
                </a>
            @endif
        </div>

        <div class="bg-white dark:bg-midnight-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-200 dark:border-gray-800">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-800">
                    <thead class="bg-gray-50 dark:bg-midnight-900">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Task</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Project</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Assigned To</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Priority</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Due Date</th>
                        <th class="relative px-6 py-3"><span class="sr-only">Actions</span></th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                    @forelse($tasks as $task)
                        <tr class="hover:bg-gray-50 dark:hover:bg-midnight-700/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="{{ route('tasks.show', $task->id) }}" class="text-sm font-bold text-gray-900 dark:text-white hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                                    {{ $task->title }}
                                </a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="{{ route('projects.show', $task->project->id) }}" class="text-sm text-blue-600 dark:text-blue-400 hover:underline">
                                    {{ $task->project->name }}
                                </a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($task->assignedTo)
                                    <div class="flex items-center gap-2">
                                        <div class="w-7 h-7 rounded-full bg-gradient-to-br from-blue-500 to-purple-500 flex items-center justify-center text-white text-xs font-bold">
                                            {{ strtoupper(substr($task->assignedTo->name, 0, 1)) }}
                                        </div>
                                        <span class="text-sm text-gray-700 dark:text-gray-300">{{ $task->assignedTo->name }}</span>
                                    </div>
                                @else
                                    <span class="text-sm text-gray-400">Unassigned</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-medium border
                                    {{ match($task->status) {
                                        'completed' => 'bg-green-100 text-green-800 border-green-200 dark:bg-green-900/30 dark:text-green-300 dark:border-green-800',
                                        'in_progress' => 'bg-blue-100 text-blue-800 border-blue-200 dark:bg-blue-900/30 dark:text-blue-300 dark:border-blue-800',
                                        'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-200 dark:bg-yellow-900/30 dark:text-yellow-300 dark:border-yellow-800',
                                        default => 'bg-gray-100 text-gray-800 border-gray-200 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600',
                                    } }}">
                                    {{ ucwords(str_replace('_', ' ', $task->status)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-0.5 rounded text-xs font-bold
                                    {{ match($task->priority) {
                                        'urgent' => 'text-red-600 bg-red-100 dark:bg-red-900/30 dark:text-red-400',
                                        'high' => 'text-orange-600 bg-orange-100 dark:bg-orange-900/30 dark:text-orange-400',
                                        'medium' => 'text-blue-600 bg-blue-100 dark:bg-blue-900/30 dark:text-blue-400',
                                        default => 'text-gray-600 bg-gray-100 dark:bg-gray-800 dark:text-gray-400',
                                    } }}">
                                    {{ ucfirst($task->priority) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                {{ $task->due_date ? $task->due_date->format('M d') : '—' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                @if(Auth::user()->isOwnerOfCurrentTeam() || $task->assigned_to_user_id === Auth::id())
                                    <a href="{{ route('tasks.edit', $task->id) }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 transition-colors">
                                        {{ Auth::user()->isOwnerOfCurrentTeam() ? 'Edit' : 'Update Status' }}
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-10 text-center text-gray-500 dark:text-gray-400">
                                No tasks found.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
