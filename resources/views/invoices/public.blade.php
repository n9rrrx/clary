<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice {{ $invoice->invoice_number }} | {{ config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css'])
    <style>
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; }
            .invoice-card { box-shadow: none !important; border: none !important; }
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen py-8 px-4">

    <!-- Header Actions -->
    <div class="max-w-3xl mx-auto mb-6 flex items-center justify-between no-print">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center">
                <span class="text-white font-bold text-xl">C</span>
            </div>
            <span class="text-lg font-bold text-gray-900">{{ config('app.name') }}</span>
        </div>
        <button onclick="window.print()" class="px-4 py-2 bg-white border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition-colors flex items-center gap-2 shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
            </svg>
            Print Invoice
        </button>
    </div>

    <!-- Invoice Card -->
    <div class="invoice-card max-w-3xl mx-auto bg-white rounded-2xl shadow-xl overflow-hidden">

        <!-- Header Banner -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-8 py-8">
            <div class="flex items-start justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-white mb-1">INVOICE</h1>
                    <p class="text-blue-100 text-lg">{{ $invoice->invoice_number }}</p>
                </div>
                <div class="text-right">
                    <span class="inline-flex px-4 py-2 rounded-full text-sm font-bold uppercase tracking-wide
                        {{ match($invoice->status) {
                            'paid' => 'bg-green-400 text-green-900',
                            'overdue' => 'bg-red-400 text-red-900',
                            'sent' => 'bg-white text-blue-700',
                            'draft' => 'bg-gray-300 text-gray-700',
                            default => 'bg-gray-300 text-gray-700',
                        } }}">
                        {{ ucfirst($invoice->status) }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Invoice Content -->
        <div class="p-8">

            <!-- Dates & Parties -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10 pb-8 border-b border-gray-200">
                <div>
                    <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-3">Bill To</h3>
                    <p class="text-xl font-bold text-gray-900">{{ $invoice->client->name ?? 'N/A' }}</p>
                    <p class="text-gray-600">{{ $invoice->client->email ?? '' }}</p>
                    @if($invoice->client->phone ?? null)
                        <p class="text-gray-600">{{ $invoice->client->phone }}</p>
                    @endif
                    @if($invoice->client->address ?? null)
                        <p class="text-gray-500 mt-2 text-sm">{{ $invoice->client->address }}</p>
                    @endif
                </div>
                <div class="text-left md:text-right">
                    <div class="mb-5">
                        <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Issue Date</h3>
                        <p class="text-gray-900 font-semibold text-lg">{{ $invoice->issue_date->format('F d, Y') }}</p>
                    </div>
                    <div>
                        <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Due Date</h3>
                        <p class="font-semibold text-lg {{ $invoice->due_date->isPast() && $invoice->status !== 'paid' ? 'text-red-600' : 'text-gray-900' }}">
                            {{ $invoice->due_date->format('F d, Y') }}
                            @if($invoice->due_date->isPast() && $invoice->status !== 'paid')
                                <span class="block text-sm text-red-500 font-normal">(Past Due)</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <!-- Project Info -->
            @if($invoice->project)
            <div class="mb-8 p-4 bg-gray-50 rounded-xl">
                <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">Project:</span>
                <span class="ml-2 font-semibold text-gray-900">{{ $invoice->project->name }}</span>
            </div>
            @endif

            <!-- Amount Summary -->
            <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl p-6 mb-8">
                <div class="space-y-4">
                    <div class="flex justify-between text-base">
                        <span class="text-gray-600">Subtotal</span>
                        <span class="text-gray-900 font-medium">${{ number_format($invoice->subtotal, 2) }}</span>
                    </div>
                    @if($invoice->tax > 0)
                    <div class="flex justify-between text-base">
                        <span class="text-gray-600">Tax</span>
                        <span class="text-gray-900 font-medium">${{ number_format($invoice->tax, 2) }}</span>
                    </div>
                    @endif
                    <div class="pt-4 border-t-2 border-gray-200">
                        <div class="flex justify-between items-center">
                            <span class="text-xl font-bold text-gray-900">Total Due</span>
                            <span class="text-3xl font-bold text-blue-600">${{ number_format($invoice->total, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notes -->
            @if($invoice->notes)
            <div class="mb-8">
                <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-3">Notes</h3>
                <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded-r-lg">
                    <p class="text-gray-700 whitespace-pre-wrap">{{ $invoice->notes }}</p>
                </div>
            </div>
            @endif

            <!-- Payment Status -->
            @if($invoice->status === 'paid')
            <div class="bg-green-50 border border-green-200 rounded-xl p-6 text-center">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-green-800 mb-1">Payment Received</h3>
                <p class="text-green-600">Thank you for your payment!</p>
            </div>
            @else
            <div class="bg-blue-50 border border-blue-200 rounded-xl p-6 text-center no-print">
                <p class="text-gray-700 mb-4">Please contact us for payment options.</p>
                <a href="mailto:{{ $invoice->user->email ?? '' }}" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors shadow-lg shadow-blue-500/30">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    Contact for Payment
                </a>
            </div>
            @endif
        </div>

        <!-- Footer -->
        <div class="bg-gray-50 px-8 py-4 text-center text-sm text-gray-500 border-t border-gray-200">
            Invoice generated by <span class="font-semibold text-blue-600">{{ config('app.name') }}</span>
        </div>
    </div>

</body>
</html>

