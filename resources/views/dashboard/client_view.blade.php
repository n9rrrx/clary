<x-client-layout>
    <div class="max-w-5xl mx-auto py-10 px-4 sm:px-6 lg:px-8">

        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">My Portal</h1>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Welcome back, {{ Auth::user()->name }}</p>
            </div>
            <div class="h-12 w-12 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold text-xl shadow-lg">
                {{ substr(Auth::user()->name, 0, 1) }}
            </div>
        </div>

        @if(isset($clientProfile) && $clientProfile)

            <div class="bg-white dark:bg-midnight-800 shadow-xl rounded-xl border border-gray-200 dark:border-line overflow-hidden mb-12">
                <div class="px-8 py-6 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center bg-gray-50 dark:bg-midnight-900">
                    <h2 class="font-bold text-gray-900 dark:text-white text-lg">My Invoices</h2>
                    <span class="text-xs font-semibold bg-white dark:bg-gray-700 text-gray-600 dark:text-gray-300 px-4 py-2 rounded-full border border-gray-200 dark:border-gray-600 shadow-sm">
                        {{ $invoices->count() }} Total
                    </span>
                </div>

                @if($invoices->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm">
                            <thead class="bg-gray-50 dark:bg-midnight-900 text-gray-500 dark:text-gray-400 uppercase tracking-wider text-xs">
                            <tr>
                                <th class="px-6 py-4 font-semibold">Invoice #</th>
                                <th class="px-6 py-4 font-semibold">Date</th>
                                <th class="px-6 py-4 font-semibold">Total</th>
                                <th class="px-6 py-4 font-semibold">Status</th>
                                <th class="px-6 py-4 text-right">Action</th>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @foreach($invoices as $invoice)
                                <tr class="hover:bg-gray-50 dark:hover:bg-midnight-700 transition-colors">
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ $invoice->invoice_number }}</td>
                                    <td class="px-6 py-4 text-gray-500">{{ $invoice->issue_date->format('M d, Y') }}</td>
                                    <td class="px-6 py-4 font-bold text-gray-900 dark:text-white">${{ number_format($invoice->total, 2) }}</td>
                                    <td class="px-6 py-4">
                                            <span class="px-2.5 py-0.5 rounded-full text-xs font-bold uppercase tracking-wide
                                                {{ match($invoice->status) {
                                                    'paid' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300',
                                                    'overdue' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300',
                                                    default => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300',
                                                } }}">
                                                {{ $invoice->status }}
                                            </span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('clients.invoices.show', $invoice->id) }}" class="text-blue-600 hover:underline text-xs">View</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="p-8 text-center text-gray-500 dark:text-gray-400">No invoices found.</div>
                @endif
            </div>

            <div>
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-3">
                    My Projects
                    <span class="text-xs font-normal bg-gray-100 dark:bg-gray-800 text-gray-500 dark:text-gray-400 px-2 py-1 rounded-full">{{ $projects->count() }} Active</span>
                </h2>

                @if($projects->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach($projects as $project)
                            <a href="{{ route('client.projects.show', $project->id) }}" class="block bg-white dark:bg-midnight-800 rounded-xl shadow-sm border border-gray-200 dark:border-line p-6 hover:shadow-lg hover:border-blue-300 dark:hover:border-blue-700 transition-all relative overflow-hidden group">
                                <div class="absolute top-0 left-0 right-0 h-1 bg-blue-500"></div>
                                <div class="flex justify-between items-start mb-4">
                                    <h3 class="font-bold text-lg text-gray-900 dark:text-white group-hover:text-blue-600 transition-colors">{{ $project->name }}</h3>
                                    <span class="text-xs px-2 py-1 rounded bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 capitalize">{{ str_replace('_', ' ', $project->status) }}</span>
                                </div>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mb-6 line-clamp-2">
                                    {{ $project->description ?? 'No description.' }}
                                </p>
                                <div class="border-t border-gray-100 dark:border-gray-700 pt-4 flex items-center justify-between text-sm text-gray-500">
                                    <span>{{ $project->tasks->where('status', '!=', 'completed')->count() }} Tasks Pending</span>
                                    <span class="text-blue-600 dark:text-blue-400 font-medium group-hover:underline">Open Project &rarr;</span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @else
                    <div class="bg-white dark:bg-midnight-800 rounded-xl border-2 border-dashed border-gray-200 dark:border-gray-700 p-8 text-center">
                        <p class="text-gray-500 dark:text-gray-400">No active projects found.</p>
                    </div>
                @endif
            </div>

        @else
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                <p class="text-sm text-yellow-700">Account setup incomplete. Please contact the administrator.</p>
            </div>
        @endif
    </div>
</x-client-layout>

