<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\Task;

class TaskDueSoon extends Notification
{
    use Queueable;

    protected Task $task;

    /**
     * Create a new notification instance.
     */
    public function __construct(Task $task)
    {
        $this->task = $task;
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
        $dueDate = $this->task->due_date ? $this->task->due_date->format('M d, Y') : 'soon';

        return [
            'title' => 'Task Due Soon',
            'message' => "\"{$this->task->title}\" is due {$dueDate}",
            'icon' => 'clock',
            'url' => route('tasks.show', $this->task->id),
            'task_id' => $this->task->id,
        ];
    }
}
