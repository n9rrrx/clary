<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Task;
use App\Models\User;
use App\Notifications\TaskDueSoon;
use Carbon\Carbon;

class SendTaskDueNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tasks:send-due-notifications';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send notifications for tasks due within the next 24 hours';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tomorrow = Carbon::now()->addDay();
        $today = Carbon::now();

        // Find tasks due within the next 24 hours that haven't been notified
        $tasks = Task::whereBetween('due_date', [$today, $tomorrow])
            ->whereNotNull('assigned_to_user_id')
            ->where('status', '!=', 'completed')
            ->get();

        $count = 0;
        foreach ($tasks as $task) {
            $user = User::find($task->assigned_to_user_id);
            if ($user) {
                // Check if we've already sent a notification for this task today
                $alreadyNotified = $user->notifications()
                    ->where('type', TaskDueSoon::class)
                    ->whereDate('created_at', $today)
                    ->whereJsonContains('data->task_id', $task->id)
                    ->exists();

                if (!$alreadyNotified) {
                    $user->notify(new TaskDueSoon($task));
                    $count++;
                }
            }
        }

        $this->info("Sent {$count} task due notifications.");
        return Command::SUCCESS;
    }
}
