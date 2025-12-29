<x-client-layout>
    <div class="max-w-5xl mx-auto py-10 px-4 sm:px-6 lg:px-8">

        <a href="{{ route('dashboard') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 mb-6 transition-colors">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            Back to Portal
        </a>

        <div class="bg-white dark:bg-midnight-800 shadow-xl rounded-xl border border-gray-200 dark:border-line overflow-hidden mb-8">
            <div class="p-8">
                <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">{{ $project->name }}</h1>
                        <p class="text-gray-500 dark:text-gray-400 max-w-2xl text-lg leading-relaxed">
                            {{ $project->description }}
                        </p>
                    </div>
                    <div class="flex-shrink-0">
                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold uppercase tracking-wide
                            {{ match($project->status) {
                                'completed' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300 border border-green-200 dark:border-green-800',
                                'in_progress' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300 border border-blue-200 dark:border-blue-800',
                                'on_hold' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300 border border-yellow-200 dark:border-yellow-800',
                                default => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-600'
                            } }}">
                            {{ str_replace('_', ' ', $project->status) }}
                        </span>
                    </div>
                </div>

                <div class="mt-8 pt-6 border-t border-gray-100 dark:border-gray-700 grid grid-cols-2 md:grid-cols-4 gap-6">
                    <div>
                        <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Start Date</span>
                        <span class="text-gray-900 dark:text-white font-medium">{{ $project->created_at->format('M d, Y') }}</span>
                    </div>
                    <div>
                        <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Total Tasks</span>
                        <span class="text-gray-900 dark:text-white font-medium">{{ $project->tasks->count() }}</span>
                    </div>
                    <div>
                        <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Pending</span>
                        <span class="text-blue-600 dark:text-blue-400 font-medium">{{ $project->tasks->where('status', '!=', 'completed')->count() }}</span>
                    </div>
                    <div>
                        <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Completed</span>
                        <span class="text-green-600 dark:text-green-400 font-medium">{{ $project->tasks->where('status', 'completed')->count() }}</span>
                    </div>
                </div>
            </div>
        </div>

        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
            Project Tasks
        </h2>

        @if($project->tasks->count() > 0)
            <div class="bg-white dark:bg-midnight-800 shadow-xl rounded-xl border border-gray-200 dark:border-line overflow-hidden mb-12">
                <ul class="divide-y divide-gray-100 dark:divide-gray-700">
                    @foreach($project->tasks as $task)
                        <li class="p-6 hover:bg-gray-50 dark:hover:bg-midnight-700/50 transition-colors group">
                            <div class="flex items-start justify-between">
                                <div class="flex items-start gap-4">
                                    <div class="mt-1 flex-shrink-0">
                                        @if($task->status === 'completed')
                                            <div class="h-6 w-6 rounded-full bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400 flex items-center justify-center">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            </div>
                                        @else
                                            <div class="h-6 w-6 rounded-full border-2 border-gray-300 dark:border-gray-600"></div>
                                        @endif
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-semibold text-gray-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">{{ $task->title }}</h3>
                                        @if($task->description)
                                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400 line-clamp-2">{{ $task->description }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="text-right flex-shrink-0 ml-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-medium {{ match($task->status) { 'completed' => 'bg-green-50 text-green-700 dark:bg-green-900/20 dark:text-green-400', 'in_progress' => 'bg-blue-50 text-blue-700 dark:bg-blue-900/20 dark:text-blue-400', default => 'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400' } }}">
                                        {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                    </span>
                                    @if($task->due_date)
                                        <p class="mt-2 text-xs text-gray-400 dark:text-gray-500">Due {{ \Carbon\Carbon::parse($task->due_date)->format('M d') }}</p>
                                    @endif
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        @else
            <div class="bg-white dark:bg-midnight-800 rounded-xl border border-dashed border-gray-300 dark:border-gray-700 p-12 text-center mb-12">
                <p class="text-gray-500 dark:text-gray-400">No tasks have been created for this project yet.</p>
            </div>
        @endif

        <div>
            <h3 class="text-sm font-bold text-gray-900 dark:text-white mb-6">Activity Feed</h3>

            <div class="bg-white dark:bg-[#0f111a] rounded-lg shadow-sm border border-gray-200 dark:border-line flex flex-col h-[600px]">

                <div class="flex-1 overflow-y-auto p-6 space-y-6 scrollbar-thin scrollbar-thumb-gray-300 dark:scrollbar-thumb-gray-700">
                    <div class="relative pl-8 border-l border-gray-200 dark:border-line space-y-8">

                        @forelse($activities as $activity)
                            @php
                                $isStaff = $activity->user->role === 'admin' || $activity->user->role === 'super_admin';
                                $badgeColor = $isStaff ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300' : 'bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-300';
                                $nameColor = $isStaff ? 'text-blue-600 dark:text-blue-400' : 'text-gray-900 dark:text-gray-200';
                                $avatarBg = $isStaff ? 'bg-blue-600' : 'bg-gray-400';
                            @endphp

                            <div class="relative group">
                                <div class="absolute -left-[43px] w-6 h-6 rounded-full ring-4 ring-gray-50 dark:ring-[#0f111a] flex items-center justify-center text-[10px] font-bold text-white {{ $avatarBg }}">
                                    {{ substr($activity->user->name, 0, 1) }}
                                </div>

                                <div class="text-sm mb-2">
                                    <span class="{{ $nameColor }} font-bold">{{ $activity->user->name }}</span>
                                    @if($isStaff)
                                        <span class="text-[10px] uppercase font-bold px-1.5 py-0.5 rounded {{ $badgeColor }} ml-1">TEAM</span>
                                    @endif
                                    <span class="text-gray-400 dark:text-gray-600 text-xs ml-2">• {{ $activity->created_at->diffForHumans() }}</span>
                                </div>

                                <div class="bg-white dark:bg-[#161b22] border border-gray-200 dark:border-line rounded-lg p-3 text-sm text-gray-700 dark:text-gray-300 shadow-sm">
                                    <p class="whitespace-pre-wrap">{{ $activity->body }}</p>
                                </div>
                            </div>
                        @empty
                            <div class="text-sm text-gray-500 italic pl-2">No comments yet.</div>
                        @endforelse

                    </div>
                </div>

                <div class="p-4 border-t border-gray-200 dark:border-line bg-gray-50 dark:bg-[#161b22]">
                    <form action="{{ route('client.projects.comment', $project->id) }}" method="POST">
                        @csrf
                        <div class="relative">
                            <textarea name="body" required
                                      class="w-full rounded-lg bg-white dark:bg-midnight-900 border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white focus:ring-blue-500 focus:border-blue-500 text-sm p-3 pr-14 resize-none h-20 shadow-sm"
                                      placeholder="Write a comment..."></textarea>

                            <button type="submit" class="absolute bottom-2 right-2 p-1.5 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</x-client-layout>
