<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\Team;

class TeamInviteReceived extends Notification
{
    use Queueable;

    protected Team $team;
    protected string $invitedBy;

    /**
     * Create a new notification instance.
     */
    public function __construct(Team $team, string $invitedBy)
    {
        $this->team = $team;
        $this->invitedBy = $invitedBy;
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
            'title' => 'Team Invitation',
            'message' => "You've been invited to join \"{$this->team->name}\" by {$this->invitedBy}",
            'icon' => 'users',
            'url' => route('team.index'),
            'team_id' => $this->team->id,
        ];
    }
}
