<x-app-layout>
    <div class="max-w-4xl mx-auto py-10 px-4 sm:px-6 lg:px-8 pb-20">

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8 print:hidden">
            <a href="{{ route('invoices.index') }}" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 text-sm font-medium flex items-center gap-2">
                &larr; Back to Invoices
            </a>
            <div class="flex items-center gap-3">

                <button id="downloadPdfBtn" class="px-4 py-2 bg-white dark:bg-midnight-800 border border-gray-300 dark:border-gray-700 text-gray-700 dark:text-gray-300 font-medium rounded-md hover:bg-gray-50 dark:hover:bg-midnight-700 transition-colors shadow-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    Download PDF
                </button>

                <a href="{{ route('invoices.edit', $invoice->id) }}" class="px-4 py-2 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700 shadow-lg shadow-blue-500/30 transition-all">
                    Edit Invoice
                </a>
            </div>
        </div>

        <div id="invoice-container" class="bg-white dark:bg-midnight-800 shadow-lg rounded-lg border border-gray-200 dark:border-gray-800 p-8 md:p-12">

            <div class="flex justify-between items-start border-b border-gray-100 dark:border-gray-700 pb-8 mb-8">
                <div>
                    <h1 class="text-4xl font-bold text-gray-900 dark:text-white tracking-tight mb-2">INVOICE</h1>
                    <span class="px-3 py-1 text-sm font-bold uppercase tracking-wide rounded-full
                        {{ match($invoice->status) {
                            'paid' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300',
                            'overdue' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300',
                            'sent' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300',
                            default => 'bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-400',
                        } }}">
                        {{ $invoice->status }}
                    </span>
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

            @if($invoice->project)
                <div class="mb-8 p-4 bg-gray-50 dark:bg-midnight-900 rounded-md border border-gray-100 dark:border-gray-700">
                    <span class="text-xs uppercase tracking-wider text-gray-500 dark:text-gray-400 font-bold mr-2">Project:</span>
                    <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $invoice->project->name }}</span>
                </div>
            @endif

            <div class="mb-8">
                <table class="w-full text-left border-collapse">
                    <thead>
                    <tr>
                        <th class="w-3/4 py-3 border-b-2 border-gray-100 dark:border-gray-700 text-xs uppercase tracking-wider text-gray-500 dark:text-gray-400 font-bold">Description</th>
                        <th class="w-1/4 py-3 border-b-2 border-gray-100 dark:border-gray-700 text-xs uppercase tracking-wider text-gray-500 dark:text-gray-400 font-bold text-right">Amount</th>
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

            <div class="flex justify-end">
                <div class="w-64 space-y-3">
                    <div class="flex justify-between text-sm text-gray-600 dark:text-gray-400">
                        <span>Subtotal</span>
                        <span class="font-medium">${{ number_format($invoice->subtotal, 2) }}</span>
                    </div>
                    @if($invoice->tax > 0)
                        <div class="flex justify-between text-sm text-gray-600 dark:text-gray-400">
                            <span>Tax</span>
                            <span class="font-medium">${{ number_format($invoice->tax, 2) }}</span>
                        </div>
                    @endif
                    <div class="flex justify-between text-lg font-bold text-gray-900 dark:text-white border-t border-gray-200 dark:border-gray-700 pt-3">
                        <span>Total Due</span>
                        <span class="text-blue-600 dark:text-blue-400">${{ number_format($invoice->total, 2) }}</span>
                    </div>
                </div>
            </div>

            <div class="mt-12 pt-8 border-t border-gray-100 dark:border-gray-700 text-center text-xs text-gray-400">
                <p>Thank you for your business!</p>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script>
        document.getElementById('downloadPdfBtn').addEventListener('click', function () {
            // 1. Select the invoice element
            const element = document.getElementById('invoice-container');

            // 2. Configuration for the PDF
            const opt = {
                margin:       [0.2, 0.2], // Small margins so dark background fills more space
                filename:     'Invoice-{{ $invoice->invoice_number }}.pdf',
                image:        { type: 'jpeg', quality: 0.98 },
                html2canvas:  { scale: 2, useCORS: true }, // scale:2 for high res text
                jsPDF:        { unit: 'in', format: 'letter', orientation: 'portrait' }
            };

            // 3. Generate and Save (Now respects your current Theme)
            html2pdf().set(opt).from(element).save();
        });
    </script>
</x-app-layout>
