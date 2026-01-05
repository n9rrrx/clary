<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\Task;

class TaskAssigned extends Notification
{
    use Queueable;

    protected Task $task;
    protected string $assignedBy;

    /**
     * Create a new notification instance.
     */
    public function __construct(Task $task, string $assignedBy)
    {
        $this->task = $task;
        $this->assignedBy = $assignedBy;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'New Task Assignment',
            'message' => "You've been assigned to \"{$this->task->title}\" by {$this->assignedBy}",
            'icon' => 'clock',
            'url' => route('tasks.show', $this->task->id),
            'task_id' => $this->task->id,
        ];
    }
}
