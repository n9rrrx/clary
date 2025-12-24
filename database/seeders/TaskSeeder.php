<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $projects = Project::all();
        $users = User::all();

        if ($projects->isEmpty()) {
            return;
        }

        $tasks = [
            [
                'project_id' => $projects->first()->id,
                'assigned_to' => $users->first()->id ?? null,
                'title' => 'Design Homepage Mockups',
                'description' => 'Create high-fidelity mockups for the new homepage design',
                'due_date' => now()->addDays(7),
                'priority' => 'high',
                'status' => 'in_progress',
            ],
            [
                'project_id' => $projects->first()->id,
                'assigned_to' => $users->first()->id ?? null,
                'title' => 'Implement Responsive Navigation',
                'description' => 'Code the responsive navigation menu',
                'due_date' => now()->addDays(14),
                'priority' => 'medium',
                'status' => 'todo',
            ],
            [
                'project_id' => $projects->skip(1)->first()->id ?? $projects->first()->id,
                'assigned_to' => null,
                'title' => 'Setup Development Environment',
                'description' => 'Configure React Native development environment',
                'due_date' => now()->addDays(3),
                'priority' => 'urgent',
                'status' => 'completed',
            ],
            [
                'project_id' => $projects->skip(1)->first()->id ?? $projects->first()->id,
                'assigned_to' => null,
                'title' => 'Design App Interface',
                'description' => 'Create UI designs for all app screens',
                'due_date' => now()->addDays(21),
                'priority' => 'high',
                'status' => 'in_progress',
            ],
        ];

        foreach ($tasks as $task) {
            Task::create($task);
        }
    }
}
