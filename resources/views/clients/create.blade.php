<x-app-layout>
    <div class="h-full w-full overflow-y-auto p-4 sm:p-8">

        <div class="max-w-3xl mx-auto">
            <div class="mb-8">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Add New Client</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400">Create a profile to manage projects and billing.</p>
            </div>

            <form action="{{ route('clients.store') }}" method="POST" class="bg-white dark:bg-midnight-800 p-8 rounded-xl border border-gray-200 dark:border-line shadow-sm space-y-6">
                @csrf

                @if(Auth::user()->role === 'super_admin')
                    <div class="bg-purple-50 dark:bg-purple-900/20 p-4 rounded-lg border border-purple-200 dark:border-purple-800">
                        <label class="block text-sm font-bold text-purple-800 dark:text-purple-300 mb-1">
                            Assign to Agency (Super Admin Action)
                        </label>
                        <select name="owner_id" class="w-full rounded-lg bg-white dark:bg-midnight-900 border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-accent-500 focus:border-accent-500">
                            <option value="" disabled selected>Select an Agency Admin...</option>
                            @foreach($agencies as $agency)
                                <option value="{{ $agency->id }}">{{ $agency->name }} ({{ $agency->email }})</option>
                            @endforeach
                        </select>
                        <p class="mt-1 text-xs text-purple-600 dark:text-purple-400">
                            This client will only be visible in the selected admin's dashboard.
                        </p>
                    </div>
                @endif

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Client Name</label>
                    <input type="text" name="name" required value="{{ old('name') }}"
                           class="w-full rounded-lg bg-gray-50 dark:bg-midnight-900 border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-accent-500 focus:border-accent-500"
                           placeholder="e.g. Acme Corp">
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email Address</label>
                    <input type="email" name="email" required value="{{ old('email') }}"
                           class="w-full rounded-lg bg-gray-50 dark:bg-midnight-900 border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-accent-500 focus:border-accent-500"
                           placeholder="contact@company.com">
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Client Type</label>
                        <select name="type" class="w-full rounded-lg bg-gray-50 dark:bg-midnight-900 border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-accent-500 focus:border-accent-500">
                            <option value="customer">Customer</option>
                            <option value="lead">Lead</option>
                            <option value="partner">Partner</option>
                            <option value="prospect">Prospect</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                        <select name="status" class="w-full rounded-lg bg-gray-50 dark:bg-midnight-900 border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-accent-500 focus:border-accent-500">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Primary Tag</label>
                    <div class="relative">
                        <select name="tag" class="w-full rounded-lg bg-gray-50 dark:bg-midnight-900 border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-accent-500 focus:border-accent-500 appearance-none">
                            <option value="" disabled selected>Select a tag category...</option>
                            <option value="Developer">Developer</option>
                            <option value="Designer">Designer</option>
                            <option value="Partner">Partner</option>
                            <option value="Prospect">Prospect</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                    <p class="mt-1 text-xs text-gray-500">Categorize this client for your sidebar reports.</p>
                </div>

                <div class="flex justify-end pt-4 space-x-3">
                    <a href="{{ route('clients.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-transparent border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-midnight-700 transition-colors">
                        Cancel
                    </a>
                    <button type="submit" class="px-6 py-2 text-sm font-medium text-white bg-accent-600 rounded-lg hover:bg-accent-500 focus:ring-2 focus:ring-offset-2 focus:ring-accent-500 transition-colors shadow-lg shadow-accent-500/30">
                        Create Client
                    </button>
                </div>

            </form>
        </div>
    </div>
</x-app-layout>
