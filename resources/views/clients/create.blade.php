<x-app-layout>
    <div class="h-full w-full overflow-y-auto p-4 sm:p-8">

        <div class="max-w-3xl mx-auto">
            <div class="mb-8">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Create New Client</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Add a new client to your team.
                </p>
            </div>

            <form action="{{ route('clients.store') }}" method="POST" class="bg-white dark:bg-midnight-800 p-8 rounded-xl border border-gray-200 dark:border-line shadow-sm space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Client Name</label>
                        <input type="text" name="name" required value="{{ old('name') }}"
                               class="w-full rounded-lg bg-gray-50 dark:bg-midnight-900 border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-accent-500 focus:border-accent-500"
                               placeholder="John Doe or Company Inc.">
                        @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email</label>
                        <input type="email" name="email" required value="{{ old('email') }}"
                               class="w-full rounded-lg bg-gray-50 dark:bg-midnight-900 border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-accent-500 focus:border-accent-500"
                               placeholder="client@example.com">
                        @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Type</label>
                        <select name="type" class="w-full rounded-lg bg-gray-50 dark:bg-midnight-900 border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white">
                            <option value="customer">Customer</option>
                            <option value="lead">Lead</option>
                            <option value="partner">Partner</option>
                            <option value="prospect">Prospect</option>
                        </select>
                        @error('type') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                        <select name="status" class="w-full rounded-lg bg-gray-50 dark:bg-midnight-900 border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                        @error('status') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tag</label>
                        <select name="tag" class="w-full rounded-lg bg-gray-50 dark:bg-midnight-900 border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white">
                            <option value="Developer">Developer</option>
                            <option value="Designer">Designer</option>
                            <option value="Partner">Partner</option>
                            <option value="Prospect">Prospect</option>
                        </select>
                        @error('tag') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Budget ($)</label>
                        <input type="number" name="budget" step="0.01" value="{{ old('budget', 0) }}"
                               class="w-full rounded-lg bg-gray-50 dark:bg-midnight-900 border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-accent-500 focus:border-accent-500"
                               placeholder="0.00">
                        @error('budget') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="flex justify-end pt-4 space-x-3">
                    <a href="{{ route('clients.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-transparent border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-midnight-700 transition-colors">
                        Cancel
                    </a>
                    <button type="submit" class="px-6 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-500 focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors shadow-lg shadow-blue-500/30">
                        Create Client
                    </button>
                </div>

            </form>
        </div>
    </div>
</x-app-layout>
