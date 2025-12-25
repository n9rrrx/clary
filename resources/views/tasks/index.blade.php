<x-app-layout>
    <div class="flex flex-col h-full w-full bg-white dark:bg-midnight-900 transition-colors duration-300">

        <div class="h-16 flex items-center justify-between px-6 border-b border-gray-200 dark:border-line shrink-0 bg-white dark:bg-midnight-900 transition-colors duration-300">
            <h1 class="text-lg font-semibold text-gray-900 dark:text-white">My Tasks</h1>
            <a href="{{ route('tasks.create') }}" class="px-4 py-2 bg-accent-600 hover:bg-accent-500 text-white rounded text-sm font-medium transition-colors">+ Add Task</a>
        </div>

        <div class="flex-1 overflow-auto bg-white dark:bg-midnight-900">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50 dark:bg-midnight-800 sticky top-0 z-10">
                <tr>
                    <th class="pl-8 pr-4 py-3 border-b border-gray-200 dark:border-line w-8">
                    </th>
                    <th class="px-4 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase border-b border-gray-200 dark:border-line">Task</th>
                    <th class="px-4 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase border-b border-gray-200 dark:border-line">Priority</th>
                    <th class="px-4 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase border-b border-gray-200 dark:border-line text-right">Due</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-line">
                @forelse ($tasks as $task)
                    <tr class="hover:bg-gray-50 dark:hover:bg-midnight-800/50 transition-colors group">
                        <td class="pl-8 pr-4 py-4">
                            <input type="checkbox" class="rounded border-gray-300 dark:border-gray-600 dark:bg-midnight-700 text-accent-600 focus:ring-accent-500">
                        </td>
                        <td class="px-4 py-4 font-medium text-gray-900 dark:text-white">{{ $task->title }}</td>
                        <td class="px-4 py-4">
                            @if($task->priority === 'high')
                                <span class="text-xs text-red-500 font-bold bg-red-100 dark:bg-red-900/20 px-2 py-0.5 rounded">High</span>
                            @else
                                <span class="text-xs text-gray-500">Normal</span>
                            @endif
                        </td>
                        <td class="px-4 py-4 text-right text-sm text-gray-500 dark:text-gray-400">
                            {{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('M d') : '' }}
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="px-6 py-24 text-center text-gray-500 dark:text-gray-400">All caught up!</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
