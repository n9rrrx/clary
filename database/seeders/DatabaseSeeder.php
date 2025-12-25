<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create test users
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@clary.com',
        ]);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Seed the database with sample data
        $this->call([
            ClientSeeder::class,
            ProjectSeeder::class,
            TaskSeeder::class,
            InvoiceSeeder::class,
        ]);
    }
}
