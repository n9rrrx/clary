<x-app-layout>
    <div class="flex h-full">
        <!-- Left Sidebar - Tags -->
        <aside class="w-64 flex-shrink-0 border-r border-gray-200 dark:border-gray-800 bg-white dark:bg-midnight-800 overflow-y-auto">
            <div class="p-4">
                <h3 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-4">Tags</h3>
                
                @php
                    $tagColors = [
                        'Developer' => 'bg-blue-500',
                        'Designer' => 'bg-purple-500',
                        'Project Manager' => 'bg-orange-500',
                        'Viewer Only' => 'bg-gray-500',
                        'HR Only' => 'bg-green-500',
                    ];
                @endphp
                
                <div class="space-y-1">
                    <a href="{{ route('people.index') }}" 
                       class="flex items-center justify-between px-3 py-2 rounded-lg transition-colors {{ !$tagFilter ? 'bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-midnight-700' }}">
                        <span class="text-sm font-medium">All People</span>
                        <span class="text-xs text-gray-500">{{ $members->count() }}</span>
                    </a>
                    
                    @foreach($tagCounts as $tag => $count)
                        @if($count > 0)
                        <a href="{{ route('people.index', ['tag' => $tag]) }}" 
                           class="flex items-center justify-between px-3 py-2 rounded-lg transition-colors {{ $tagFilter === $tag ? 'bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-midnight-700' }}">
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full {{ $tagColors[$tag] ?? 'bg-gray-500' }}"></span>
                                <span class="text-sm">{{ $tag }}</span>
                            </div>
                            <span class="text-xs text-gray-500">{{ $count }}</span>
                        </a>
                        @endif
                    @endforeach
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto">
            <div class="p-6 lg:p-8">
                <!-- Header -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">People</h1>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                            @if($tagFilter)
                                Showing: <span class="font-medium text-blue-600 dark:text-blue-400">{{ $tagFilter }}</span>
                            @else
                                All team members
                            @endif
                        </p>
                    </div>
                    
                    <div class="flex items-center gap-3 mt-4 sm:mt-0">
                        <!-- Filter/Sort Dropdown -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center gap-2 px-4 py-2 bg-white dark:bg-midnight-800 border border-gray-300 dark:border-gray-600 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-midnight-700 transition-colors">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                                </svg>
                                {{ $sortBy === 'by_team' ? 'By Team' : 'All' }}
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            
                            <div x-show="open" @click.away="open = false" 
                                 class="absolute right-0 mt-2 w-40 bg-white dark:bg-midnight-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 py-1 z-50">
                                <a href="{{ route('people.index', array_merge(request()->query(), ['sort' => 'all'])) }}" 
                                   class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-midnight-700 {{ $sortBy === 'all' ? 'bg-blue-50 dark:bg-blue-900/20' : '' }}">
                                    All
                                </a>
                                <a href="{{ route('people.index', array_merge(request()->query(), ['sort' => 'by_team'])) }}" 
                                   class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-midnight-700 {{ $sortBy === 'by_team' ? 'bg-blue-50 dark:bg-blue-900/20' : '' }}">
                                    By Team
                                </a>
                            </div>
                        </div>
                        
                        <!-- Display Button -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center gap-2 px-4 py-2 bg-white dark:bg-midnight-800 border border-gray-300 dark:border-gray-600 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-midnight-700 transition-colors">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                                </svg>
                                Display
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Active Tag Filter Pill -->
                @if($tagFilter)
                    <div class="mb-4 flex items-center gap-2">
                        <span class="text-sm text-gray-500 dark:text-gray-400">Tags contains</span>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 rounded-full text-sm font-medium">
                            {{ $tagFilter }}
                            <a href="{{ route('people.index', ['sort' => $sortBy]) }}" class="hover:text-blue-900 dark:hover:text-blue-200">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </a>
                        </span>
                    </div>
                @endif

                <!-- People Table -->
                <div class="bg-white dark:bg-midnight-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <table class="w-full">
                        <thead class="bg-gray-50 dark:bg-midnight-900">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Name</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Created At</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Updated At</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Role</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tags</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($members as $member)
                                <tr class="hover:bg-gray-50 dark:hover:bg-midnight-700 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-purple-500 flex items-center justify-center text-white font-bold">
                                                {{ strtoupper(substr($member->name, 0, 1)) }}
                                            </div>
                                            <span class="font-medium text-gray-900 dark:text-white">{{ $member->name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-blue-600 dark:text-blue-400">
                                        <a href="mailto:{{ $member->email }}">{{ $member->email }}</a>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                        {{ $member->created_at->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                        {{ $member->updated_at->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @php
                                            $role = $member->pivot->role ?? 'member';
                                            $roleColors = [
                                                'admin' => 'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-400',
                                                'member' => 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400',
                                                'viewer' => 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300',
                                            ];
                                        @endphp
                                        <span class="px-2 py-1 text-xs font-medium {{ $roleColors[$role] ?? $roleColors['member'] }} rounded-full capitalize">
                                            {{ $role }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        @php
                                            $memberTags = is_string($member->tags) ? json_decode($member->tags, true) : ($member->tags ?? []);
                                            $tagColors = [
                                                'Backend Developer' => 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400',
                                                'Frontend Developer' => 'bg-cyan-100 dark:bg-cyan-900/30 text-cyan-700 dark:text-cyan-400',
                                                'UI/UX Designer' => 'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-400',
                                                'Project Manager' => 'bg-orange-100 dark:bg-orange-900/30 text-orange-700 dark:text-orange-400',
                                                'Viewer Only' => 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300',
                                                'HR Only' => 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400',
                                            ];
                                        @endphp
                                        <div class="flex flex-wrap gap-1">
                                            @forelse($memberTags as $tag)
                                                <span class="px-2 py-0.5 text-xs font-medium {{ $tagColors[$tag] ?? 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300' }} rounded-full">
                                                    {{ $tag }}
                                                </span>
                                            @empty
                                                <span class="text-xs text-gray-400">—</span>
                                            @endforelse
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center gap-1.5 px-2 py-1 text-xs font-medium bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 rounded-full">
                                            <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                            Active
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <button class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"/>
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-12 text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        <p class="text-gray-500 dark:text-gray-400">
                                            @if($tagFilter)
                                                No team members found with tag "{{ $tagFilter }}"
                                            @else
                                                No team members found
                                            @endif
                                        </p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination Info -->
                <div class="mt-4 flex items-center justify-between text-sm text-gray-500 dark:text-gray-400">
                    <span>Page 1 of 1</span>
                    <span>{{ $members->count() }} {{ Str::plural('person', $members->count()) }}</span>
                </div>
            </div>
        </main>
    </div>
</x-app-layout>
