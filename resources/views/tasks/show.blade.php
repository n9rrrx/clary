<x-app-layout>
    <div class="max-w-4xl mx-auto py-10 px-4 sm:px-6 lg:px-8">

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <div class="flex items-center gap-3">
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $task->title }}</h1>

                    <span class="px-2.5 py-0.5 rounded-full text-xs font-medium border
                        {{ match($task->status) {
                            'completed' => 'bg-green-100 text-green-800 border-green-200 dark:bg-green-900/30 dark:text-green-300 dark:border-green-800',
                            'in_progress' => 'bg-blue-100 text-blue-800 border-blue-200 dark:bg-blue-900/30 dark:text-blue-300 dark:border-blue-800',
                            'review' => 'bg-purple-100 text-purple-800 border-purple-200 dark:bg-purple-900/30 dark:text-purple-300 dark:border-purple-800',
                            default => 'bg-gray-100 text-gray-800 border-gray-200 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600',
                        } }}">
                        {{ ucwords(str_replace('_', ' ', $task->status)) }}
                    </span>
                </div>
                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                    Task ID: #{{ $task->id }} &bull; Created {{ $task->created_at->format('M d, Y') }}
                </p>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('projects.show', $task->project_id) }}" class="px-4 py-2 bg-white dark:bg-midnight-800 border border-gray-300 dark:border-gray-700 text-gray-700 dark:text-gray-300 font-medium rounded-md hover:bg-gray-50 dark:hover:bg-midnight-700 transition-colors shadow-sm">
                    Back to Project
                </a>
                <a href="{{ route('tasks.edit', $task->id) }}" class="px-4 py-2 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700 shadow-lg shadow-blue-500/30 transition-all">
                    Edit Task
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <div class="md:col-span-2 space-y-6">
                <div class="bg-white dark:bg-midnight-800 shadow rounded-lg border border-gray-200 dark:border-gray-800 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Description</h3>
                    <div class="prose dark:prose-invert max-w-none text-gray-600 dark:text-gray-400 text-sm leading-relaxed">
                        @if($task->description)
                            {!! nl2br(e($task->description)) !!}
                        @else
                            <p class="italic text-gray-400">No description provided.</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="space-y-6">

                <div class="bg-white dark:bg-midnight-800 shadow rounded-lg border border-gray-200 dark:border-gray-800 p-6">
                    <h3 class="text-xs uppercase tracking-wider text-gray-500 dark:text-gray-400 font-bold mb-4">Project</h3>
                    <a href="{{ route('projects.show', $task->project_id) }}" class="block group">
                        <p class="text-sm font-bold text-gray-900 dark:text-white group-hover:text-blue-600 transition-colors">
                            {{ $task->project->name }}
                        </p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            {{ $task->project->client->name ?? 'Unknown Client' }}
                        </p>
                    </a>
                </div>

                <div class="bg-white dark:bg-midnight-800 shadow rounded-lg border border-gray-200 dark:border-gray-800 p-6">
                    <h3 class="text-xs uppercase tracking-wider text-gray-500 dark:text-gray-400 font-bold mb-4">Details</h3>

                    <div class="space-y-4">
                        <div class="flex justify-between text-sm border-b border-gray-100 dark:border-gray-700 pb-2">
                            <span class="text-gray-500 dark:text-gray-400">Priority</span>
                            <span class="font-bold uppercase text-xs
                                {{ match($task->priority) {
                                    'urgent' => 'text-red-600',
                                    'high' => 'text-orange-600',
                                    'medium' => 'text-blue-600',
                                    default => 'text-gray-600',
                                } }}">
                                {{ $task->priority }}
                            </span>
                        </div>

                        <div class="flex justify-between text-sm border-b border-gray-100 dark:border-gray-700 pb-2">
                            <span class="text-gray-500 dark:text-gray-400">Due Date</span>
                            <span class="font-medium text-gray-900 dark:text-white">
                                {{ $task->due_date ? $task->due_date->format('M d, Y') : '—' }}
                            </span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
