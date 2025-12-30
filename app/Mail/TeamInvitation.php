<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TeamInvitation extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $password;
    public $clientName;
    public $budget;
    public $assignedRole;

    /**
     * Build the invitation with Role and Budget details
     */
    public function __construct(User $user, $password, $clientName, $budget = 0, $assignedRole = 'Member')
    {
        $this->user = $user;
        $this->password = $password;
        $this->clientName = $clientName;
        $this->budget = $budget;
        $this->assignedRole = $assignedRole;
    }

    public function build()
    {
        return $this->subject("Assignment Details: You've been added to {$this->clientName}")
            ->view('emails.team-invitation');
    }
}
