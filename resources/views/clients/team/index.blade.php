<x-app-layout>
    <div class="h-full w-full overflow-y-auto p-4 sm:p-8">
        <div class="max-w-5xl mx-auto">

            <div class="mb-8 flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Team Management</h1>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Manage your company's users and their access levels.</p>
                </div>
                <button onclick="document.getElementById('inviteModal').classList.remove('hidden')"
                        class="px-4 py-2 bg-accent-600 text-white rounded-lg hover:bg-accent-500 transition-colors shadow-lg shadow-accent-500/30">
                    + Invite Member
                </button>
            </div>

            <div class="bg-white dark:bg-midnight-800 rounded-xl border border-gray-200 dark:border-line overflow-hidden shadow-sm">
                <table class="w-full text-left border-collapse">
                    <thead>
                    <tr class="bg-gray-50 dark:bg-midnight-900/50 border-b border-gray-200 dark:border-line">
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Name</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Email</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Joined</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-line">
                    @foreach($team as $member)
                        <tr class="hover:bg-gray-50 dark:hover:bg-midnight-700/30 transition-colors">
                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-white font-medium">{{ $member->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $member->email }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-700 dark:bg-green-900/20 dark:text-green-400">Active</span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $member->created_at->format('M d, Y') }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="inviteModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">
        <div class="bg-white dark:bg-midnight-800 w-full max-w-md p-8 rounded-2xl shadow-2xl border border-gray-200 dark:border-line">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Invite Team Member</h2>
            <form action="{{ route('client.team.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Full Name</label>
                    <input type="text" name="name" required class="w-full rounded-lg bg-gray-50 dark:bg-midnight-900 border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email Address</label>
                    <input type="email" name="email" required class="w-full rounded-lg bg-gray-50 dark:bg-midnight-900 border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white">
                </div>
                <div class="flex justify-end gap-3 pt-4">
                    <button type="button" onclick="document.getElementById('inviteModal').classList.add('hidden')" class="px-4 py-2 text-sm text-gray-500 hover:text-gray-700">Cancel</button>
                    <button type="submit" class="px-6 py-2 bg-accent-600 text-white rounded-lg hover:bg-accent-500 transition-colors">Send Invitation</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
