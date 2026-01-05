<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\Task;

class TaskCompleted extends Notification
{
    use Queueable;

    protected Task $task;
    protected string $completedBy;

    /**
     * Create a new notification instance.
     */
    public function __construct(Task $task, string $completedBy)
    {
        $this->task = $task;
        $this->completedBy = $completedBy;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Task Completed',
            'message' => "\"{$this->task->title}\" has been marked as completed by {$this->completedBy}",
            'icon' => 'check',
            'url' => route('tasks.show', $this->task->id),
            'task_id' => $this->task->id,
        ];
    }
}
