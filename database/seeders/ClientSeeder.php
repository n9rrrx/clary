<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clients = [
            [
                'name' => 'Acme Corporation',
                'email' => 'contact@acme.com',
                'phone' => '+1-555-0100',
                'company' => 'Acme Corp',
                'address' => '123 Business St, New York, NY 10001',
                'status' => 'active',
                'notes' => 'Premium client since 2020',
            ],
            [
                'name' => 'Tech Innovators Ltd',
                'email' => 'info@techinnovators.com',
                'phone' => '+1-555-0200',
                'company' => 'Tech Innovators',
                'address' => '456 Tech Ave, San Francisco, CA 94102',
                'status' => 'active',
                'notes' => 'Focused on software development projects',
            ],
            [
                'name' => 'Green Energy Solutions',
                'email' => 'hello@greenenergy.com',
                'phone' => '+1-555-0300',
                'company' => 'Green Energy Solutions',
                'address' => '789 Eco Blvd, Portland, OR 97204',
                'status' => 'active',
                'notes' => 'Sustainability-focused client',
            ],
        ];

        foreach ($clients as $client) {
            Client::create($client);
        }
    }
}
