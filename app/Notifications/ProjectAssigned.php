<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\Project;

class ProjectAssigned extends Notification
{
    use Queueable;

    protected Project $project;
    protected string $assignedBy;

    /**
     * Create a new notification instance.
     */
    public function __construct(Project $project, string $assignedBy)
    {
        $this->project = $project;
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
            'title' => 'New Project Assignment',
            'message' => "You've been assigned to \"{$this->project->name}\" by {$this->assignedBy}",
            'icon' => 'folder',
            'url' => route('projects.show', $this->project->id),
            'project_id' => $this->project->id,
        ];
    }
}
