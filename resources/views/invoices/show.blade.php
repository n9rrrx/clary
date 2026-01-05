<x-app-layout>
    <div class="max-w-4xl mx-auto py-10 px-4 sm:px-6 lg:px-8 pb-20">

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8 print:hidden">
            <a href="{{ route('invoices.index') }}" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 text-sm font-medium flex items-center gap-2">
                &larr; Back to Invoices
            </a>
            <div class="flex items-center gap-3">
                <!-- Send to Client Button -->
                <form action="{{ route('invoices.send', $invoice->id) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white font-medium rounded-md hover:bg-green-700 shadow-lg shadow-green-500/30 transition-all flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        {{ $invoice->status === 'sent' ? 'Resend' : 'Send' }} to Client
                    </button>
                </form>


                <a href="{{ route('invoices.edit', $invoice->id) }}" class="px-4 py-2 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700 shadow-lg shadow-blue-500/30 transition-all">
                    Edit Invoice
                </a>
            </div>
        </div>

        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-100 dark:bg-green-900/30 border border-green-200 dark:border-green-800 rounded-lg text-green-800 dark:text-green-300">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mb-6 p-4 bg-red-100 dark:bg-red-900/30 border border-red-200 dark:border-red-800 rounded-lg text-red-800 dark:text-red-300">
                {{ session('error') }}
            </div>
        @endif

        <div id="invoice-container" class="bg-white dark:bg-midnight-800 shadow-lg rounded-lg border border-gray-200 dark:border-gray-800 overflow-hidden">

            <!-- Header with Logo -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-8 py-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <!-- Clary Spider Logo -->
                        <img src="/logos/logo-clary-spider.svg" alt="Clary" class="w-10 h-10">
                        <span class="text-white text-2xl font-bold">Clary</span>
                    </div>
                    <span class="px-4 py-2 rounded-full text-sm font-bold uppercase tracking-wide
                        {{ match($invoice->status) {
                            'paid' => 'bg-green-400 text-green-900',
                            'overdue' => 'bg-red-400 text-red-900',
                            'sent' => 'bg-white/90 text-blue-700',
                            default => 'bg-gray-300 text-gray-700',
                        } }}">
                        {{ ucfirst($invoice->status) }}
                    </span>
                </div>
            </div>

            <div class="p-8 md:p-10">
                <!-- Invoice Title & Number -->
                <div class="flex justify-between items-start border-b border-gray-100 dark:border-gray-700 pb-8 mb-8">
                    <div>
                        <h1 class="text-4xl font-bold text-gray-900 dark:text-white tracking-tight">INVOICE</h1>
                    </div>
                    <div class="text-right">
                        <p class="text-gray-500 dark:text-gray-400 text-xs uppercase tracking-wider mb-1">Invoice #</p>
                        <p class="text-xl font-bold text-gray-900 dark:text-white mb-4">{{ $invoice->invoice_number }}</p>

                        <p class="text-gray-500 dark:text-gray-400 text-xs uppercase tracking-wider mb-1">Date Issued</p>
                        <p class="text-gray-900 dark:text-white font-medium mb-4">{{ $invoice->issue_date->format('M d, Y') }}</p>

                        <p class="text-gray-500 dark:text-gray-400 text-xs uppercase tracking-wider mb-1">Due Date</p>
                        <p class="text-gray-900 dark:text-white font-medium">{{ $invoice->due_date->format('M d, Y') }}</p>
                    </div>
                </div>

                <!-- Bill To / Payable To -->
                <div class="grid grid-cols-2 gap-12 mb-12">
                    <div>
                        <h3 class="text-xs uppercase tracking-wider text-gray-500 dark:text-gray-400 font-bold mb-3">Bill To</h3>
                        <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $invoice->client->name }}</p>
                        <p class="text-gray-600 dark:text-gray-400">{{ $invoice->client->email }}</p>
                    </div>
                    <div class="text-right md:text-left">
                        <h3 class="text-xs uppercase tracking-wider text-gray-500 dark:text-gray-400 font-bold mb-3">Payable To</h3>
                        <p class="text-lg font-bold text-gray-900 dark:text-white">{{ Auth::user()->name }}</p>
                        <p class="text-gray-600 dark:text-gray-400">{{ Auth::user()->email }}</p>
                    </div>
                </div>

                <!-- Project -->
                @if($invoice->project)
                    <div class="mb-8 p-4 bg-gray-50 dark:bg-midnight-900 rounded-lg border border-gray-100 dark:border-gray-700">
                        <span class="text-xs uppercase tracking-wider text-gray-500 dark:text-gray-400 font-bold mr-2">Project:</span>
                        <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $invoice->project->name }}</span>
                    </div>
                @endif

                <!-- Description / Amount Table -->
                <div class="mb-8">
                    <table class="w-full text-left border-collapse">
                        <thead>
                        <tr>
                            <th class="w-3/4 py-3 border-b-2 border-gray-200 dark:border-gray-700 text-xs uppercase tracking-wider text-gray-500 dark:text-gray-400 font-bold">Description</th>
                            <th class="w-1/4 py-3 border-b-2 border-gray-200 dark:border-gray-700 text-xs uppercase tracking-wider text-gray-500 dark:text-gray-400 font-bold text-right">Amount</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="py-6 pr-10 border-b border-gray-100 dark:border-gray-700 text-gray-900 dark:text-white align-top text-sm leading-relaxed">
                                @if($invoice->notes)
                                    {!! nl2br(e($invoice->notes)) !!}
                                @else
                                    <span class="text-gray-400 italic">No description provided.</span>
                                @endif
                            </td>
                            <td class="py-6 border-b border-gray-100 dark:border-gray-700 text-gray-900 dark:text-white font-medium text-right align-top text-sm">
                                ${{ number_format($invoice->subtotal, 2) }}
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Totals -->
                <div class="flex justify-end">
                    <div class="w-72 space-y-3 bg-gray-50 dark:bg-midnight-900 p-6 rounded-lg">
                        <div class="flex justify-between text-sm text-gray-600 dark:text-gray-400">
                            <span>Subtotal</span>
                            <span class="font-medium text-gray-900 dark:text-white">${{ number_format($invoice->subtotal, 2) }}</span>
                        </div>
                        @if($invoice->tax > 0)
                            <div class="flex justify-between text-sm text-gray-600 dark:text-gray-400">
                                <span>Tax</span>
                                <span class="font-medium text-gray-900 dark:text-white">${{ number_format($invoice->tax, 2) }}</span>
                            </div>
                        @endif
                        <div class="flex justify-between text-xl font-bold text-gray-900 dark:text-white border-t border-gray-200 dark:border-gray-600 pt-3">
                            <span>Total Due</span>
                            <span class="text-blue-600 dark:text-blue-400">${{ number_format($invoice->total, 2) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="mt-12 pt-8 border-t border-gray-100 dark:border-gray-700 text-center">
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Thank you for your business!</p>
                    <p class="text-gray-400 dark:text-gray-500 text-xs mt-2">Generated by Clary</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
