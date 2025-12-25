<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Client;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clients = Client::all();

        if ($clients->isEmpty()) {
            return;
        }

        $projects = [
            [
                'client_id' => $clients->first()->id,
                'name' => 'Website Redesign',
                'description' => 'Complete redesign of company website with modern UI/UX',
                'start_date' => now()->subDays(30),
                'end_date' => now()->addDays(30),
                'budget' => 15000.00,
                'status' => 'in_progress',
            ],
            [
                'client_id' => $clients->first()->id,
                'name' => 'Mobile App Development',
                'description' => 'Native iOS and Android app for customer engagement',
                'start_date' => now()->subDays(60),
                'end_date' => now()->addDays(60),
                'budget' => 50000.00,
                'status' => 'in_progress',
            ],
            [
                'client_id' => $clients->skip(1)->first()->id ?? $clients->first()->id,
                'name' => 'SEO Optimization',
                'description' => 'Search engine optimization for improved visibility',
                'start_date' => now()->subDays(15),
                'end_date' => now()->addDays(45),
                'budget' => 8000.00,
                'status' => 'planning',
            ],
        ];

        foreach ($projects as $project) {
            Project::create($project);
        }
    }
}
