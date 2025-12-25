<x-app-layout>
    <div class="flex flex-col h-full w-full bg-white dark:bg-midnight-900 transition-colors duration-300">

        <div class="h-16 flex items-center justify-between px-6 border-b border-gray-200 dark:border-line shrink-0 bg-white dark:bg-midnight-900 transition-colors duration-300">
            <div class="flex items-center space-x-4">
                <h1 class="text-lg font-semibold text-gray-900 dark:text-white">Projects</h1>
                <span class="px-2 py-0.5 rounded-full bg-gray-100 dark:bg-midnight-800 text-xs text-gray-500 dark:text-gray-400 border border-gray-200 dark:border-line">
                    {{ $projects->count() ?? 0 }} Active
                </span>
            </div>
            <a href="{{ route('projects.create') }}" class="flex items-center px-4 py-2 bg-accent-600 hover:bg-accent-500 text-white rounded text-sm font-medium transition-colors">
                + New Project
            </a>
        </div>

        <div class="flex-1 overflow-auto bg-white dark:bg-midnight-900">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50 dark:bg-midnight-800 sticky top-0 z-10">
                <tr>
                    <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider border-b border-gray-200 dark:border-line">Project Name</th>
                    <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider border-b border-gray-200 dark:border-line">Client</th>
                    <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider border-b border-gray-200 dark:border-line">Status</th>
                    <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider border-b border-gray-200 dark:border-line text-right">Deadline</th>
                    <th class="px-6 py-3 border-b border-gray-200 dark:border-line"></th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-line">
                @forelse ($projects as $project)
                    <tr class="hover:bg-gray-50 dark:hover:bg-midnight-800/50 transition-colors group">
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ $project->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                            {{ $project->client->name ?? 'Internal' }}
                        </td>
                        <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 border border-transparent dark:border-blue-800">
                                    {{ ucfirst($project->status) }}
                                </span>
                        </td>
                        <td class="px-6 py-4 text-right text-sm text-gray-500 dark:text-gray-400">
                            {{ $project->deadline ? \Carbon\Carbon::parse($project->deadline)->format('M d') : '—' }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="#" class="text-gray-400 hover:text-white opacity-0 group-hover:opacity-100 transition-opacity">Edit</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-24 text-center text-gray-500 dark:text-gray-400">
                            No projects yet. Start building!
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
