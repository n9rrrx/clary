<x-app-layout>
    <div class="max-w-4xl mx-auto py-10 px-4 sm:px-6 lg:px-8">

        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Create New Project</h1>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Fill in the details to kick off a new project.</p>
            </div>
            <a href="{{ route('projects.index') }}" class="px-4 py-2 bg-gray-100 dark:bg-midnight-800 text-gray-700 dark:text-gray-300 rounded-md hover:bg-gray-200 dark:hover:bg-midnight-700 transition-colors text-sm font-medium">
                Cancel
            </a>
        </div>

        <div class="bg-white dark:bg-midnight-800 shadow rounded-lg overflow-hidden border border-gray-200 dark:border-line">
            <form action="{{ route('projects.store') }}" method="POST" class="p-6 space-y-6">
                @csrf

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Project Name</label>
                    <input type="text" name="name" id="name" required
                           class="w-full rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-midnight-900 text-gray-900 dark:text-gray-100 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition-colors"
                           placeholder="e.g. Website Redesign">
                    @error('name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="client_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Client</label>
                    <select name="client_id" id="client_id"
                            class="w-full rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-midnight-900 text-gray-900 dark:text-gray-100 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition-colors">
                        <option value="">No Client (Internal Project)</option>
                        @foreach($clients as $client)
                            <option value="{{ $client->id }}">{{ $client->name }} - {{ ucfirst($client->type) }}</option>
                        @endforeach
                    </select>
                    @error('client_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                        <select name="status" id="status" required
                                class="w-full rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-midnight-900 text-gray-900 dark:text-gray-100 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition-colors">
                            <option value="planning">Not Started</option>
                            <option value="in_progress">In Progress</option>
                            <option value="on_hold">On Hold</option>
                            <option value="completed">Completed</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                        @error('status') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="budget" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Budget ($)</label>
                        <input type="number" step="0.01" name="budget" id="budget" class="w-full rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-midnight-900 text-gray-900 dark:text-gray-100 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition-colors" placeholder="0.00">
                    </div>

                    <div>
                        <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Start Date</label>
                        <input type="date" name="start_date" id="start_date"
                               class="w-full rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-midnight-900 text-gray-900 dark:text-gray-100 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition-colors">
                        @error('start_date') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="end_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Deadline</label>
                        <input type="date" name="end_date" id="end_date"
                               class="w-full rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-midnight-900 text-gray-900 dark:text-gray-100 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition-colors">
                        @error('end_date') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description</label>
                    <textarea name="description" id="description" rows="4"
                              class="w-full rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-midnight-900 text-gray-900 dark:text-gray-100 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition-colors"
                              placeholder="Project details, requirements, and notes..."></textarea>
                    @error('description') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <div class="flex items-center justify-end border-t border-gray-200 dark:border-gray-700 pt-6">
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all shadow-lg shadow-blue-500/30">
                        Create Project
                    </button>
                </div>

            </form>
        </div>
    </div>
</x-app-layout>
