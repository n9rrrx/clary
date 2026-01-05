<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Notification;

class TestNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notifications:test {email? : The email of the user to notify}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a test notification to a user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');

        if ($email) {
            $user = User::where('email', $email)->first();
        } else {
            $user = User::first();
        }

        if (!$user) {
            $this->error('No user found.');
            return Command::FAILURE;
        }

        // Create a simple test notification
        $user->notify(new \App\Notifications\TestNotification());

        $this->info("Test notification sent to {$user->email}");
        return Command::SUCCESS;
    }
}
