<?php

namespace Database\Seeders;

use App\Models\Invoice;
use App\Models\Client;
use App\Models\Project;
use Illuminate\Database\Seeder;

class InvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clients = Client::all();
        $projects = Project::all();

        if ($clients->isEmpty()) {
            return;
        }

        $invoices = [
            [
                'client_id' => $clients->first()->id,
                'project_id' => $projects->first()->id ?? null,
                'invoice_number' => 'INV-2024-001',
                'issue_date' => now()->subDays(30),
                'due_date' => now()->subDays(15),
                'subtotal' => 5000.00,
                'tax' => 500.00,
                'total' => 5500.00,
                'status' => 'paid',
                'notes' => 'Payment for initial project milestone',
            ],
            [
                'client_id' => $clients->first()->id,
                'project_id' => $projects->first()->id ?? null,
                'invoice_number' => 'INV-2024-002',
                'issue_date' => now()->subDays(15),
                'due_date' => now()->addDays(15),
                'subtotal' => 7500.00,
                'tax' => 750.00,
                'total' => 8250.00,
                'status' => 'sent',
                'notes' => 'Second milestone payment',
            ],
            [
                'client_id' => $clients->skip(1)->first()->id ?? $clients->first()->id,
                'project_id' => $projects->skip(1)->first()->id ?? null,
                'invoice_number' => 'INV-2024-003',
                'issue_date' => now(),
                'due_date' => now()->addDays(30),
                'subtotal' => 3000.00,
                'tax' => 300.00,
                'total' => 3300.00,
                'status' => 'draft',
                'notes' => 'Draft invoice for upcoming work',
            ],
        ];

        foreach ($invoices as $invoice) {
            Invoice::create($invoice);
        }
    }
}
