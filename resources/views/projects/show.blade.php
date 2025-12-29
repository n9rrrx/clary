<x-app-layout>
    <div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <div class="flex items-center gap-3">
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $project->name }}</h1>
                    @php
                        $statusColors = [
                            'planning' => 'bg-blue-100 text-blue-800 border-blue-200 dark:bg-blue-900/30 dark:text-blue-300 dark:border-blue-800',
                            'in_progress' => 'bg-purple-100 text-purple-800 border-purple-200 dark:bg-purple-900/30 dark:text-purple-300 dark:border-purple-800',
                            'completed' => 'bg-green-100 text-green-800 border-green-200 dark:bg-green-900/30 dark:text-green-300 dark:border-green-800',
                            'on_hold' => 'bg-orange-100 text-orange-800 border-orange-200 dark:bg-orange-900/30 dark:text-orange-300 dark:border-orange-800',
                            'cancelled' => 'bg-red-100 text-red-800 border-red-200 dark:bg-red-900/30 dark:text-red-300 dark:border-red-800',
                        ];
                        $color = $statusColors[$project->status] ?? 'bg-gray-100 text-gray-800';
                    @endphp
                    <span class="px-3 py-1 text-sm font-semibold rounded-full border {{ $color }}">
                        {{ ucwords(str_replace('_', ' ', $project->status)) }}
                    </span>
                </div>
                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                    Project ID: #{{ $project->id }} &bull; Created {{ $project->created_at->format('M d, Y') }}
                </p>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('projects.edit', $project->id) }}" class="px-4 py-2 bg-white dark:bg-midnight-800 border border-gray-300 dark:border-gray-700 text-gray-700 dark:text-gray-300 font-medium rounded-md hover:bg-gray-50 dark:hover:bg-midnight-700 transition-colors shadow-sm">
                    Edit Project
                </a>
                <a href="{{ route('tasks.create', ['project_id' => $project->id]) }}"
                   class="px-4 py-2 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700 shadow-lg shadow-blue-500/30 transition-all">
                    + Add Task
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-8">

                <div class="bg-white dark:bg-midnight-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-800 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Overview</h3>
                    <div class="prose dark:prose-invert max-w-none text-gray-600 dark:text-gray-400 text-sm leading-relaxed">
                        @if($project->description)
                            {!! nl2br(e($project->description)) !!}
                        @else
                            <p class="italic text-gray-400">No description provided.</p>
                        @endif
                    </div>
                </div>

                <div class="bg-white dark:bg-midnight-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-800 p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Active Tasks</h3>
                        <span class="text-xs font-medium text-gray-500 bg-gray-100 dark:bg-midnight-900 px-2 py-1 rounded">
                            {{ $project->tasks->count() }} Tasks
                        </span>
                    </div>

                    @if($project->tasks->count() > 0)
                        <div class="space-y-3">
                            @foreach($project->tasks as $task)
                                <div class="group flex items-center justify-between p-3 rounded-md bg-gray-50 dark:bg-midnight-900 border border-gray-100 dark:border-gray-700 hover:border-blue-300 dark:hover:border-blue-700 transition-all">

                                    <div class="flex items-center gap-3">
                                        @php
                                            $statusColor = match($task->status) {
                                                'completed' => 'bg-green-500 border-green-500',
                                                'in_progress' => 'bg-blue-500 border-blue-500',
                                                'review' => 'bg-purple-500 border-purple-500',
                                                default => 'border-gray-300 dark:border-gray-600', // todo
                                            };
                                        @endphp

                                        <div class="w-4 h-4 rounded-full border-2 {{ $statusColor }}"></div>

                                        <a href="{{ route('tasks.show', $task->id) }}" class="text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors {{ $task->status === 'completed' ? 'line-through text-gray-400' : '' }}">
                                            {{ $task->title }}
                                        </a>
                                    </div>

                                    <div class="flex items-center gap-3">

                                        <span class="hidden sm:inline-block text-[10px] font-bold uppercase tracking-wider text-gray-400 dark:text-gray-500 mr-2">
                                            {{ $task->priority }}
                                        </span>

                                        <span class="text-xs font-medium px-2 py-1 rounded-full
                                            {{ match($task->status) {
                                                'completed' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300',
                                                'in_progress' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300',
                                                'review' => 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-300',
                                                default => 'bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-400',
                                            } }}">
                                            {{ ucwords(str_replace('_', ' ', $task->status)) }}
                                        </span>

                                        <a href="{{ route('tasks.edit', $task->id) }}" class="text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors p-1" title="Edit Task">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8 border-2 border-dashed border-gray-200 dark:border-gray-700 rounded-lg">
                            <p class="text-sm text-gray-500 dark:text-gray-400">No tasks created yet.</p>
                            <a href="{{ route('tasks.create', ['project_id' => $project->id]) }}" class="mt-2 inline-block text-blue-600 hover:text-blue-500 text-sm font-medium transition-colors">
                                Create your first task
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <div class="space-y-6">

                <div class="bg-white dark:bg-midnight-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-800 p-6">
                    <h3 class="text-xs uppercase tracking-wider text-gray-500 dark:text-gray-400 font-bold mb-4">Client</h3>
                    <div class="flex items-center gap-3">
                        <div class="h-10 w-10 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center text-blue-700 dark:text-blue-300 font-bold">
                            {{ substr($project->client->name ?? '?', 0, 1) }}
                        </div>
                        <div>
                            <p class="text-sm font-bold text-gray-900 dark:text-white">{{ $project->client->name ?? 'Unknown' }}</p>
                            @if($project->client->email)
                                <p class="text-xs text-gray-500 hover:text-blue-500 transition-colors">
                                    <a href="mailto:{{ $project->client->email }}">{{ $project->client->email }}</a>
                                </p>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-midnight-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-800 p-6">
                    <h3 class="text-xs uppercase tracking-wider text-gray-500 dark:text-gray-400 font-bold mb-4">Project Details</h3>

                    <div class="space-y-4">

                        <div class="flex justify-between text-sm border-b border-gray-100 dark:border-gray-700 pb-2">
                            <span class="text-gray-500 dark:text-gray-400">Start Date</span>
                            <span class="font-medium text-gray-900 dark:text-white">
                                {{ $project->start_date ? $project->start_date->format('M d, Y') : 'Not set' }}
                            </span>
                        </div>

                        <div class="flex justify-between text-sm border-b border-gray-100 dark:border-gray-700 pb-2">
                            <span class="text-gray-500 dark:text-gray-400">Deadline</span>
                            <span class="font-medium text-gray-900 dark:text-white">
                                {{ $project->end_date ? $project->end_date->format('M d, Y') : 'No Deadline' }}
                            </span>
                        </div>

                        <div class="flex justify-between text-sm border-b border-gray-100 dark:border-gray-700 pb-2">
                            <span class="text-gray-500 dark:text-gray-400">Budget</span>
                            <span class="font-bold text-green-600 dark:text-green-400">
                                {{ $project->budget ? '$'.number_format($project->budget, 2) : '—' }}
                            </span>
                        </div>

                        @php
                            $percentage = match($project->status) {
                                'completed' => 100,
                                'in_progress' => 50,
                                'on_hold' => 50,
                                default => 0,     // planning, cancelled
                            };

                            $barColor = match($project->status) {
                                'completed' => 'bg-green-500',
                                'in_progress' => 'bg-blue-600',
                                default => 'bg-gray-400',
                            };
                        @endphp

                        <div class="pt-2">
                            <div class="flex justify-between text-xs mb-1">
                                <span class="text-gray-500">Progress</span>
                                <span class="text-blue-600 dark:text-blue-400 font-bold">{{ $percentage }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                <div class="{{ $barColor }} h-2 rounded-full transition-all duration-500" style="width: {{ $percentage }}%"></div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
