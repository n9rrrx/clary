<x-app-layout>
    <div class="h-full w-full overflow-y-auto p-4 sm:p-8">

        <div class="max-w-2xl mx-auto">

            <div class="mb-8 flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Edit Client</h1>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Update client details.</p>
                </div>
                <a href="{{ route('clients.index') }}" class="text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                    &larr; Back
                </a>
            </div>

            <form action="{{ route('clients.update', $client->id) }}" method="POST" class="bg-white dark:bg-midnight-800 p-8 rounded-xl border border-gray-200 dark:border-line shadow-sm space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Client Name *</label>
                        <input type="text" name="name" required value="{{ old('name', $client->name) }}"
                               class="w-full rounded-lg bg-gray-50 dark:bg-midnight-900 border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-accent-500 focus:border-accent-500">
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email *</label>
                        <input type="email" name="email" required value="{{ old('email', $client->email) }}"
                               class="w-full rounded-lg bg-gray-50 dark:bg-midnight-900 border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-accent-500 focus:border-accent-500">
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Type</label>
                        <select name="type" class="w-full rounded-lg bg-gray-50 dark:bg-midnight-900 border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-accent-500 focus:border-accent-500">
                            <option value="customer" {{ $client->type == 'customer' ? 'selected' : '' }}>Customer - Active paying client</option>
                            <option value="prospect" {{ $client->type == 'prospect' ? 'selected' : '' }}>Prospect - Potential client</option>
                            <option value="lead" {{ $client->type == 'lead' ? 'selected' : '' }}>Lead - Interested contact</option>
                            <option value="partner" {{ $client->type == 'partner' ? 'selected' : '' }}>Partner - Business partner</option>
                        </select>
                    </div>

                    @php
                        $currentTags = is_array($client->tags) ? $client->tags : (is_string($client->tags) ? json_decode($client->tags, true) : []);
                        $firstTag = $currentTags[0] ?? 'Developer';
                    @endphp
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tag</label>
                        <select name="tag" class="w-full rounded-lg bg-gray-50 dark:bg-midnight-900 border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-accent-500 focus:border-accent-500">
                            <option value="Developer" {{ $firstTag == 'Developer' ? 'selected' : '' }}>Developer</option>
                            <option value="Designer" {{ $firstTag == 'Designer' ? 'selected' : '' }}>Designer</option>
                            <option value="Partner" {{ $firstTag == 'Partner' ? 'selected' : '' }}>Partner</option>
                            <option value="Prospect" {{ $firstTag == 'Prospect' ? 'selected' : '' }}>Prospect</option>
                        </select>
                    </div>
                </div>

                <div class="flex items-center justify-between pt-4 border-t border-gray-200 dark:border-gray-700">
                    <form action="{{ route('clients.destroy', $client->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this client?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-sm text-red-600 hover:text-red-500">Delete Client</button>
                    </form>

                    <button type="submit" class="px-6 py-2 text-sm font-medium text-white bg-accent-600 rounded-lg hover:bg-accent-500 focus:ring-2 focus:ring-offset-2 focus:ring-accent-500 transition-colors shadow-lg shadow-accent-500/30">
                        Update Client
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
                    </button>
                </div>
            </form>

            <div class="mt-8 bg-red-50 dark:bg-red-900/10 p-6 rounded-xl border border-red-200 dark:border-red-900/30">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-sm font-bold text-red-800 dark:text-red-400">Delete Client</h3>
                        <p class="text-xs text-red-600 dark:text-red-500 mt-1">Once deleted, all data including invoices and tasks will be lost.</p>
                    </div>

                    <form action="{{ route('clients.destroy', $client->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this client?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                            Delete
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
