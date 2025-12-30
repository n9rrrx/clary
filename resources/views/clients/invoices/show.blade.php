<x-client-layout>
    <div class="max-w-4xl mx-auto">

        {{-- TOP CONTROLS --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8 print:hidden">

            {{-- 1. Back Button (Goes to Client Portal, not Admin) --}}
            <a href="{{ route('client.portal') }}" class="group flex items-center text-sm font-medium text-gray-500 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400 transition-colors">
                <div class="mr-2 p-1.5 rounded-full bg-white dark:bg-midnight-800 border border-gray-200 dark:border-gray-700 group-hover:border-blue-500 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </div>
                Back to Dashboard
            </a>

            {{-- 2. Download Button --}}
            <button id="downloadPdfBtn" class="inline-flex items-center px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg shadow-md hover:shadow-lg transition-all">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                Download PDF
            </button>
        </div>

        {{-- INVOICE PAPER --}}
        <div id="invoice-container" class="bg-white dark:bg-midnight-800 shadow-2xl rounded-xl border border-gray-200 dark:border-gray-800 p-10 md:p-14 relative overflow-hidden">

            {{-- Decorative Stripe --}}
            <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-blue-600 to-indigo-600"></div>

            {{-- Header Section --}}
            <div class="flex justify-between items-start border-b border-gray-100 dark:border-gray-700 pb-10 mb-10">
                <div>
                    <h1 class="text-4xl font-extrabold text-gray-900 dark:text-white tracking-tight">INVOICE</h1>
                    <div class="mt-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide border
                            {{ match($invoice->status) {
                                'paid' => 'bg-green-50 text-green-700 border-green-200 dark:bg-green-900/20 dark:text-green-400 dark:border-green-900',
                                'overdue' => 'bg-red-50 text-red-700 border-red-200 dark:bg-red-900/20 dark:text-red-400 dark:border-red-900',
                                default => 'bg-blue-50 text-blue-700 border-blue-200 dark:bg-blue-900/20 dark:text-blue-400 dark:border-blue-900',
                            } }}">
                            {{ $invoice->status }}
                        </span>
                    </div>
                </div>
                <div class="text-right">
                    <div class="mb-4">
                        <p class="text-xs uppercase tracking-wider text-gray-500 dark:text-gray-400 font-bold">Invoice Number</p>
                        <p class="text-xl font-bold text-gray-900 dark:text-white font-mono">{{ $invoice->invoice_number }}</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-sm text-gray-600 dark:text-gray-400">Date Issued: <span class="font-semibold text-gray-900 dark:text-white">{{ $invoice->issue_date->format('M d, Y') }}</span></p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Due Date: <span class="font-semibold text-gray-900 dark:text-white">{{ $invoice->due_date->format('M d, Y') }}</span></p>
                    </div>
                </div>
            </div>

            {{-- Addresses --}}
            <div class="grid grid-cols-2 gap-12 mb-12">
                <div>
                    <h3 class="text-xs uppercase tracking-wider text-gray-400 dark:text-gray-500 font-bold mb-3">Billed To</h3>
                    <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $invoice->client->name }}</p>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">{{ $invoice->client->email }}</p>
                    {{-- Add address here if available --}}
                </div>
                <div class="text-right md:text-left">
                    <h3 class="text-xs uppercase tracking-wider text-gray-400 dark:text-gray-500 font-bold mb-3">Payable To</h3>
                    <p class="text-lg font-bold text-gray-900 dark:text-white">Clary Agency</p>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">accounts@clary.com</p>
                </div>
            </div>

            {{-- Items Table --}}
            <div class="mb-10">
                <table class="w-full text-left">
                    <thead>
                    <tr>
                        <th class="py-3 border-b-2 border-gray-100 dark:border-gray-700 text-xs uppercase tracking-wider text-gray-500 dark:text-gray-400 font-bold">Description</th>
                        <th class="py-3 border-b-2 border-gray-100 dark:border-gray-700 text-xs uppercase tracking-wider text-gray-500 dark:text-gray-400 font-bold text-right">Amount</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    <tr>
                        <td class="py-6 text-gray-900 dark:text-white text-sm leading-relaxed">
                            @if($invoice->notes)
                                {!! nl2br(e($invoice->notes)) !!}
                            @else
                                <span class="text-gray-400 italic">No description provided.</span>
                            @endif
                        </td>
                        <td class="py-6 text-gray-900 dark:text-white font-bold text-right text-sm">
                            ${{ number_format($invoice->subtotal, 2) }}
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            {{-- Totals --}}
            <div class="flex justify-end border-t border-gray-100 dark:border-gray-700 pt-8">
                <div class="w-full md:w-1/3 space-y-3">
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
                    <div class="flex justify-between text-xl font-bold text-gray-900 dark:text-white pt-4">
                        <span>Total</span>
                        <span class="text-blue-600 dark:text-blue-400">${{ number_format($invoice->total, 2) }}</span>
                    </div>
                </div>
            </div>

            {{-- Footer Note --}}
            <div class="mt-16 text-center">
                <p class="text-xs text-gray-400 dark:text-gray-500">Thank you for your business!</p>
            </div>
        </div>
    </div>

    {{-- Script for PDF Download --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script>
        document.getElementById('downloadPdfBtn').addEventListener('click', function () {
            const element = document.getElementById('invoice-container');
            const opt = {
                margin:       0.4,
                filename:     'Invoice-{{ $invoice->invoice_number }}.pdf',
                image:        { type: 'jpeg', quality: 0.98 },
                html2canvas:  { scale: 2, useCORS: true, scrollY: 0 },
                jsPDF:        { unit: 'in', format: 'letter', orientation: 'portrait' }
            };
            html2pdf().set(opt).from(element).save();
        });
    </script>
</x-client-layout>
