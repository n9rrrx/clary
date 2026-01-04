<x-app-layout>
    <div class="h-full w-full overflow-y-auto p-4 sm:p-8">

        <div class="max-w-2xl mx-auto">
            <div class="mb-8 flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Add New Client</h1>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Add a company or person you work for.</p>
                </div>
                <a href="{{ route('clients.index') }}" class="text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                    &larr; Back
                </a>
            </div>

            <form action="{{ route('clients.store') }}" method="POST" class="bg-white dark:bg-midnight-800 p-8 rounded-xl border border-gray-200 dark:border-line shadow-sm space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Client Name *</label>
                        <input type="text" name="name" required value="{{ old('name') }}"
                               class="w-full rounded-lg bg-gray-50 dark:bg-midnight-900 border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-accent-500 focus:border-accent-500"
                               placeholder="Acme Corp or John Doe">
                        @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email *</label>
                        <input type="email" name="email" required value="{{ old('email') }}"
                               class="w-full rounded-lg bg-gray-50 dark:bg-midnight-900 border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-accent-500 focus:border-accent-500"
                               placeholder="client@company.com">
                        @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Type</label>
                        <select name="type" class="w-full rounded-lg bg-gray-50 dark:bg-midnight-900 border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white">
                            <option value="customer">Customer - Active paying client</option>
                            <option value="prospect">Prospect - Potential client</option>
                            <option value="lead">Lead - Interested contact</option>
                            <option value="partner">Partner - Business partner</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tag</label>
                        <select name="tag" class="w-full rounded-lg bg-gray-50 dark:bg-midnight-900 border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white">
                            <option value="Developer">Developer</option>
                            <option value="Designer">Designer</option>
                            <option value="Partner">Partner</option>
                            <option value="Prospect">Prospect</option>
                        </select>
                    </div>
                </div>

                <div class="flex justify-end pt-4 border-t border-gray-200 dark:border-gray-700">
                    <button type="submit" class="px-6 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-500 focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors shadow-lg shadow-blue-500/30">
                        Add Client
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
