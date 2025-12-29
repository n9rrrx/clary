<x-app-layout>
    <div class="max-w-4xl mx-auto py-10 px-4 sm:px-6 lg:px-8">

        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Edit Task</h1>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Update task progress or details.</p>
            </div>
            <a href="{{ route('projects.show', $task->project_id) }}" class="px-4 py-2 bg-gray-100 dark:bg-midnight-800 text-gray-700 dark:text-gray-300 rounded-md hover:bg-gray-200 dark:hover:bg-midnight-700 transition-colors text-sm font-medium">Cancel</a>
        </div>

        <div class="bg-white dark:bg-midnight-800 shadow rounded-lg overflow-hidden border border-gray-200 dark:border-line">
            <form action="{{ route('tasks.update', $task->id) }}" method="POST" class="p-6 space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Task Title</label>
                    <input type="text" name="title" id="title" required
                           value="{{ old('title', $task->title) }}"
                           class="w-full rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-midnight-900 text-gray-900 dark:text-gray-100 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition-colors">
                    @error('title') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="project_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Project</label>
                    <select name="project_id" id="project_id" required
                            class="w-full rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-midnight-900 text-gray-900 dark:text-gray-100 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition-colors">
                        @foreach($projects as $project)
                            <option value="{{ $project->id }}" {{ old('project_id', $task->project_id) == $project->id ? 'selected' : '' }}>
                                {{ $project->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('project_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                        <select name="status" id="status" required
                                class="w-full rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-midnight-900 text-gray-900 dark:text-gray-100 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition-colors">
                            @foreach(['todo', 'in_progress', 'review', 'completed'] as $option)
                                <option value="{{ $option }}" {{ old('status', $task->status) == $option ? 'selected' : '' }}>
                                    {{ ucwords(str_replace('_', ' ', $option)) }}
                                </option>
                            @endforeach
                        </select>
                        @error('status') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="priority" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Priority</label>
                        <select name="priority" id="priority" required
                                class="w-full rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-midnight-900 text-gray-900 dark:text-gray-100 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition-colors">
                            @foreach(['low', 'medium', 'high', 'urgent'] as $option)
                                <option value="{{ $option }}" {{ old('priority', $task->priority) == $option ? 'selected' : '' }}>
                                    {{ ucfirst($option) }}
                                </option>
                            @endforeach
                        </select>
                        @error('priority') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="due_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Due Date</label>
                        <input type="date" name="due_date" id="due_date"
                               value="{{ old('due_date', optional($task->due_date)->format('Y-m-d')) }}"
                               class="w-full rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-midnight-900 text-gray-900 dark:text-gray-100 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition-colors">
                        @error('due_date') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description</label>
                    <textarea name="description" id="description" rows="4"
                              class="w-full rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-midnight-900 text-gray-900 dark:text-gray-100 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition-colors">{{ old('description', $task->description) }}</textarea>
                    @error('description') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <div class="flex items-center justify-end border-t border-gray-200 dark:border-gray-700 pt-6">
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all shadow-lg shadow-blue-500/30">
                        Update Task
                    </button>
                </div>

            </form>
        </div>
    </div>
</x-app-layout>
