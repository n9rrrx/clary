<x-app-layout>
    <div class="p-6 lg:p-8">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">User Management</h1>
                <p class="text-gray-500 dark:text-gray-400 mt-1">Manage your team members for {{ $team->name }}</p>
            </div>
            @if($isOwner)
            <button onclick="document.getElementById('inviteModal').classList.remove('hidden')" 
                    class="mt-4 sm:mt-0 inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-semibold rounded-lg hover:shadow-lg hover:shadow-blue-500/30 transition-all">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                Invite Member
            </button>
            @endif
        </div>

        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 rounded-lg text-green-700 dark:text-green-300">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 rounded-lg text-red-700 dark:text-red-300">
                {{ session('error') }}
            </div>
        @endif

        <!-- Team Members Table (Simplified) -->
        <div class="bg-white dark:bg-midnight-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50 dark:bg-midnight-900">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Member</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Role</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Joined</th>
                        @if($isOwner)
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
                        @endif
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
                                <div>
                                    <div class="font-medium text-gray-900 dark:text-white">{{ $member->name }}</div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">{{ $member->email }}</div>
                                </div>
                                @if($member->id === $team->owner_id)
                                <span class="px-2 py-1 text-xs font-semibold bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400 rounded-full">Owner</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $role = $member->pivot->role ?? 'member';
                                $roleColors = [
                                    'admin' => 'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-400',
                                    'member' => 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400',
                                    'viewer' => 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300',
                                    'owner' => 'bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400',
                                ];
                            @endphp
                            <span class="px-3 py-1 text-sm font-medium {{ $roleColors[$role] ?? $roleColors['member'] }} rounded-full capitalize">
                                {{ $role }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-500 dark:text-gray-400 text-sm">
                            {{ $member->created_at->diffForHumans() }}
                        </td>
                        @if($isOwner)
                        <td class="px-6 py-4 text-right">
                            @if($member->id !== $team->owner_id)
                            <form action="{{ route('team.remove', $member) }}" method="POST" class="inline" onsubmit="return confirm('Remove this member from the team?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 transition-colors">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                            @endif
                        </td>
                        @endif
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                            <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <p class="font-medium">No team members yet</p>
                            <p class="text-sm">Invite your first team member to get started.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Simplified Invite Modal (Atlassian Style) -->
    <div id="inviteModal" class="hidden fixed inset-0 z-50 overflow-y-auto">
        <div class="flex min-h-full items-center justify-center p-4">
            <div class="fixed inset-0 bg-black/50" onclick="document.getElementById('inviteModal').classList.add('hidden')"></div>
            
            <div class="relative bg-white dark:bg-midnight-800 rounded-xl shadow-xl w-full max-w-md p-6">
                <button onclick="document.getElementById('inviteModal').classList.add('hidden')" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>

                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Invite Team Member</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">They'll get an email with login credentials.</p>

                <form action="{{ route('team.invite') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Name</label>
                        <input type="text" name="name" required
                               class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-midnight-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="John Doe">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email</label>
                        <input type="email" name="email" required
                               class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-midnight-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="john@example.com">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Role & Permissions</label>
                        <select name="role" required
                                class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-midnight-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="admin">
                                Admin - Full access: Create projects, assign tasks, manage team members, view all projects & invoices
                            </option>
                            <option value="member">
                                Member - Work on assigned projects & tasks: View assigned projects (budget, dates, status), complete tasks, update task status
                            </option>
                            <option value="viewer">
                                Viewer - Read-only access: View assigned projects & tasks, cannot edit or create
                            </option>
                        </select>
                        <div class="mt-2 p-3 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
                            <p class="text-xs font-medium text-blue-900 dark:text-blue-200 mb-1">Selected Role Access:</p>
                            <ul class="text-xs text-blue-800 dark:text-blue-300 space-y-1" id="roleDescription">
                                <li id="admin-desc" class="hidden">• Create & manage projects</li>
                                <li id="admin-desc-2" class="hidden">• Assign tasks to team members</li>
                                <li id="admin-desc-3" class="hidden">• View all projects & invoices</li>
                                <li id="admin-desc-4" class="hidden">• Manage team members</li>
                                <li id="member-desc" class="hidden">• View assigned projects (budget, dates, status)</li>
                                <li id="member-desc-2" class="hidden">• Work on assigned tasks</li>
                                <li id="member-desc-3" class="hidden">• Update task status & progress</li>
                                <li id="member-desc-4" class="hidden">• View project details</li>
                                <li id="viewer-desc" class="hidden">• View assigned projects (read-only)</li>
                                <li id="viewer-desc-2" class="hidden">• View tasks (cannot edit)</li>
                                <li id="viewer-desc-3" class="hidden">• No creation or editing permissions</li>
                            </ul>
                        </div>
                    </div>
                    
                    <script>
                        document.querySelector('select[name="role"]').addEventListener('change', function() {
                            // Hide all descriptions
                            document.querySelectorAll('[id$="-desc"], [id$="-desc-2"], [id$="-desc-3"], [id$="-desc-4"]').forEach(el => el.classList.add('hidden'));
                            
                            // Show selected role descriptions
                            const role = this.value;
                            if (role === 'admin') {
                                ['admin-desc', 'admin-desc-2', 'admin-desc-3', 'admin-desc-4'].forEach(id => {
                                    document.getElementById(id).classList.remove('hidden');
                                });
                            } else if (role === 'member') {
                                ['member-desc', 'member-desc-2', 'member-desc-3', 'member-desc-4'].forEach(id => {
                                    document.getElementById(id).classList.remove('hidden');
                                });
                            } else if (role === 'viewer') {
                                ['viewer-desc', 'viewer-desc-2', 'viewer-desc-3'].forEach(id => {
                                    document.getElementById(id).classList.remove('hidden');
                                });
                            }
                        });
                        // Trigger on page load to show default
                        document.querySelector('select[name="role"]').dispatchEvent(new Event('change'));
                    </script>

                    @if(isset($projects) && $projects->count() > 0)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Assign to Project <span class="text-gray-400 font-normal">(Optional)</span>
                        </label>
                        <select name="project_id"
                                class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-midnight-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">No project assignment</option>
                            @foreach($projects as $project)
                                <option value="{{ $project->id }}">{{ $project->name }}</option>
                            @endforeach
                        </select>
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">You can assign them to a project now, or do it later from the project page.</p>
                    </div>
                    @endif

                    <div class="pt-4">
                        <button type="submit" class="w-full py-3 px-4 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-semibold rounded-lg hover:shadow-lg hover:shadow-blue-500/30 transition-all">
                            Send Invitation
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
