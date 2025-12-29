<x-app-layout>
    <div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">

        <div class="flex items-center justify-between mb-8">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">My Tasks</h1>
            <a href="{{ route('tasks.create') }}" class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 shadow-lg shadow-blue-500/30 transition-all">
                + Add Task
            </a>
        </div>

        <div class="bg-white dark:bg-midnight-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-200 dark:border-gray-800">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-800">
                    <thead class="bg-gray-50 dark:bg-midnight-900">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Task</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Project</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Priority</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Due Date</th>
                        <th class="relative px-6 py-3"><span class="sr-only">Edit</span></th>
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
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-medium border
                                    {{ match($task->status) {
                                        'completed' => 'bg-green-100 text-green-800 border-green-200 dark:bg-green-900/30 dark:text-green-300 dark:border-green-800',
                                        'in_progress' => 'bg-blue-100 text-blue-800 border-blue-200 dark:bg-blue-900/30 dark:text-blue-300 dark:border-blue-800',
                                        'review' => 'bg-purple-100 text-purple-800 border-purple-200 dark:bg-purple-900/30 dark:text-purple-300 dark:border-purple-800',
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
                                <a href="{{ route('tasks.edit', $task->id) }}" class="text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Edit</a>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-gray-500 dark:text-gray-400">
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
