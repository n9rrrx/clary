<x-app-layout>
    <div class="flex flex-col h-full w-full bg-white dark:bg-midnight-900 transition-colors duration-300">

        <div class="h-16 flex items-center justify-between px-6 border-b border-gray-200 dark:border-line shrink-0 bg-white dark:bg-midnight-900 transition-colors duration-300">
            <h1 class="text-lg font-semibold text-gray-900 dark:text-white">Invoices</h1>
            <a href="{{ route('invoices.create') }}" class="px-4 py-2 bg-accent-600 hover:bg-accent-500 text-white rounded text-sm font-medium transition-colors">+ New Invoice</a>
        </div>

        <div class="flex-1 overflow-auto bg-white dark:bg-midnight-900">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50 dark:bg-midnight-800 sticky top-0 z-10">
                <tr>
                    <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase border-b border-gray-200 dark:border-line">Number</th>
                    <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase border-b border-gray-200 dark:border-line">Client</th>
                    <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase border-b border-gray-200 dark:border-line text-right">Amount</th>
                    <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase border-b border-gray-200 dark:border-line text-right">Status</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-line">
                @forelse ($invoices as $invoice)
                    <tr class="hover:bg-gray-50 dark:hover:bg-midnight-800/50 transition-colors">
                        <td class="px-6 py-4 font-mono text-sm text-gray-900 dark:text-white">#{{ $invoice->number }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">{{ $invoice->client->name }}</td>
                        <td class="px-6 py-4 text-right font-medium text-gray-900 dark:text-white">${{ number_format($invoice->amount, 2) }}</td>
                        <td class="px-6 py-4 text-right">
                                <span class="px-2 py-1 text-xs rounded-full {{ $invoice->status === 'paid' ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' : 'bg-orange-100 text-orange-700 dark:bg-orange-900/30 dark:text-orange-400' }}">
                                    {{ ucfirst($invoice->status) }}
                                </span>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="px-6 py-24 text-center text-gray-500 dark:text-gray-400">No invoices generated.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
