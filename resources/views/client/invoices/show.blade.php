<x-client-layout>
    <div class="max-w-4xl mx-auto py-10 px-4 sm:px-6 lg:px-8">

        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('dashboard') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Dashboard
            </a>
        </div>

        <!-- Invoice Header -->
        <div class="bg-white dark:bg-midnight-800 rounded-xl shadow-xl border border-gray-200 dark:border-line overflow-hidden">

            <!-- Top Banner -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-8 py-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-white">Invoice</h1>
                        <p class="text-blue-100 text-sm mt-1">{{ $invoice->invoice_number }}</p>
                    </div>
                    <div class="text-right">
                        <span class="inline-flex px-4 py-2 rounded-full text-sm font-bold uppercase tracking-wide
                            {{ match($invoice->status) {
                                'paid' => 'bg-green-500 text-white',
                                'overdue' => 'bg-red-500 text-white',
                                'sent' => 'bg-blue-500 text-white',
                                'draft' => 'bg-gray-500 text-white',
                                default => 'bg-gray-500 text-white',
                            } }}">
                            {{ ucfirst($invoice->status) }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Invoice Details -->
            <div class="p-8">

                <!-- Dates & Client Info -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8 pb-8 border-b border-gray-200 dark:border-gray-700">
                    <div>
                        <h3 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3">Bill To</h3>
                        <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $invoice->client->name ?? 'N/A' }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $invoice->client->email ?? '' }}</p>
                        @if($invoice->client->phone ?? null)
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $invoice->client->phone }}</p>
                        @endif
                        @if($invoice->client->address ?? null)
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">{{ $invoice->client->address }}</p>
                        @endif
                    </div>
                    <div class="text-left md:text-right">
                        <div class="mb-4">
                            <h3 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Issue Date</h3>
                            <p class="text-gray-900 dark:text-white font-medium">{{ $invoice->issue_date->format('F d, Y') }}</p>
                        </div>
                        <div>
                            <h3 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Due Date</h3>
                            <p class="text-gray-900 dark:text-white font-medium {{ $invoice->due_date->isPast() && $invoice->status !== 'paid' ? 'text-red-600 dark:text-red-400' : '' }}">
                                {{ $invoice->due_date->format('F d, Y') }}
                                @if($invoice->due_date->isPast() && $invoice->status !== 'paid')
                                    <span class="text-xs text-red-500">(Overdue)</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Project Info (if linked) -->
                @if($invoice->project)
                <div class="mb-8 pb-8 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3">Project</h3>
                    <p class="text-gray-900 dark:text-white font-medium">{{ $invoice->project->name }}</p>
                </div>
                @endif

                <!-- Amount Summary -->
                <div class="bg-gray-50 dark:bg-midnight-900 rounded-xl p-6 mb-8">
                    <div class="space-y-3">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600 dark:text-gray-400">Subtotal</span>
                            <span class="text-gray-900 dark:text-white font-medium">${{ number_format($invoice->subtotal, 2) }}</span>
                        </div>
                        @if($invoice->tax > 0)
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600 dark:text-gray-400">Tax</span>
                            <span class="text-gray-900 dark:text-white font-medium">${{ number_format($invoice->tax, 2) }}</span>
                        </div>
                        @endif
                        <div class="pt-3 border-t border-gray-200 dark:border-gray-700">
                            <div class="flex justify-between">
                                <span class="text-lg font-bold text-gray-900 dark:text-white">Total</span>
                                <span class="text-2xl font-bold text-blue-600 dark:text-blue-400">${{ number_format($invoice->total, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Notes -->
                @if($invoice->notes)
                <div class="mb-8">
                    <h3 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3">Notes</h3>
                    <p class="text-gray-700 dark:text-gray-300 text-sm whitespace-pre-wrap">{{ $invoice->notes }}</p>
                </div>
                @endif

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <button onclick="window.print()" class="flex-1 inline-flex items-center justify-center px-6 py-3 bg-gray-100 dark:bg-midnight-700 text-gray-700 dark:text-gray-200 font-medium rounded-lg hover:bg-gray-200 dark:hover:bg-midnight-600 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                        </svg>
                        Print Invoice
                    </button>
                    @if($invoice->status !== 'paid')
                    <a href="#" class="flex-1 inline-flex items-center justify-center px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors shadow-lg shadow-blue-500/30">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                        </svg>
                        Pay Now
                    </a>
                    @else
                    <div class="flex-1 inline-flex items-center justify-center px-6 py-3 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 font-medium rounded-lg">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Paid - Thank You!
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Print Styles -->
    <style>
        @media print {
            body * { visibility: hidden; }
            .max-w-4xl, .max-w-4xl * { visibility: visible; }
            .max-w-4xl { position: absolute; left: 0; top: 0; width: 100%; }
            button, a { display: none !important; }
        }
    </style>
</x-client-layout>

