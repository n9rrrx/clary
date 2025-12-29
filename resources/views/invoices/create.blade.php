<x-app-layout>
    <div class="max-w-4xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">New Invoice</h1>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Create a new invoice for a client.</p>
            </div>
            <a href="{{ route('invoices.index') }}" class="px-4 py-2 bg-gray-100 dark:bg-midnight-800 text-gray-700 dark:text-gray-300 rounded-md hover:bg-gray-200 dark:hover:bg-midnight-700 transition-colors text-sm font-medium">Cancel</a>
        </div>

        <div class="bg-white dark:bg-midnight-800 shadow rounded-lg overflow-hidden border border-gray-200 dark:border-line">
            <form action="{{ route('invoices.store') }}" method="POST" class="p-6 space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Invoice Number</label>
                        <input type="text" name="invoice_number" value="{{ $nextNumber }}" readonly
                               class="w-full rounded-md border-gray-300 dark:border-gray-700 bg-gray-100 dark:bg-midnight-900 text-gray-500 dark:text-gray-400 cursor-not-allowed">
                    </div>
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                        <select name="status" id="status" class="w-full rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-midnight-900 text-gray-900 dark:text-gray-100 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition-colors">
                            <option value="draft">Draft</option>
                            <option value="sent">Sent</option>
                            <option value="paid">Paid</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="client_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Client</label>
                        <select name="client_id" id="client_id" required class="w-full rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-midnight-900 text-gray-900 dark:text-gray-100 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition-colors">
                            <option value="" disabled selected>Select Client...</option>
                            @foreach($clients as $client)
                                <option value="{{ $client->id }}">{{ $client->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="project_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Project (Optional)</label>
                        <select name="project_id" id="project_id" class="w-full rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-midnight-900 text-gray-900 dark:text-gray-100 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition-colors">
                            <option value="">No Project</option>
                            @foreach($projects as $project)
                                <option value="{{ $project->id }}">{{ $project->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div>
                        <label for="issue_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Issue Date</label>
                        <input type="date" name="issue_date" id="issue_date" value="{{ date('Y-m-d') }}" class="w-full rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-midnight-900 text-gray-900 dark:text-gray-100 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition-colors">
                    </div>
                    <div>
                        <label for="due_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Due Date</label>
                        <input type="date" name="due_date" id="due_date" required class="w-full rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-midnight-900 text-gray-900 dark:text-gray-100 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition-colors">
                    </div>
                    <div>
                        <label for="subtotal" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Subtotal ($)</label>
                        <input type="number" step="0.01" name="subtotal" id="subtotal" required placeholder="0.00" class="w-full rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-midnight-900 text-gray-900 dark:text-gray-100 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition-colors" oninput="calculateTotal()">
                    </div>
                    <div>
                        <label for="tax" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tax ($)</label>
                        <input type="number" step="0.01" name="tax" id="tax" placeholder="0.00" class="w-full rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-midnight-900 text-gray-900 dark:text-gray-100 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition-colors" oninput="calculateTotal()">
                    </div>
                </div>

                <div class="flex justify-end">
                    <div class="text-right">
                        <span class="block text-sm text-gray-500 dark:text-gray-400">Total Due</span>
                        <span id="totalDisplay" class="text-2xl font-bold text-gray-900 dark:text-white">$0.00</span>
                    </div>
                </div>

                <div>
                    <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Notes / Description</label>
                    <textarea name="notes" id="notes" rows="3" class="w-full rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-midnight-900 text-gray-900 dark:text-gray-100 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition-colors" placeholder="Services rendered..."></textarea>
                </div>

                <div class="flex items-center justify-end border-t border-gray-200 dark:border-gray-700 pt-6">
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700 transition-all shadow-lg shadow-blue-500/30">Create Invoice</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function calculateTotal() {
            const subtotal = parseFloat(document.getElementById('subtotal').value) || 0;
            const tax = parseFloat(document.getElementById('tax').value) || 0;
            const total = subtotal + tax;
            document.getElementById('totalDisplay').innerText = '$' + total.toFixed(2);
        }
    </script>
</x-app-layout>
