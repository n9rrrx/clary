<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Symfony\Component\Mime\Email;

class TeamInvitation extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $password;
    public $clientName;
    public $budget;
    public $assignedRole;
    public $assignedProject;
    public $sender;
    public $logoCid;

    /**
     * Build the invitation with Role and Budget details
     */
    public function __construct(User $user, $password, $clientName, $budget = 0, $assignedRole = 'Member', $assignedProject = null, $sender = null)
    {
        $this->user = $user;
        $this->password = $password;
        $this->clientName = $clientName;
        $this->budget = $budget;
        $this->assignedRole = $assignedRole;
        $this->assignedProject = $assignedProject;
        $this->sender = $sender;
        $this->logoCid = 'cid:logo-clary';
    }

    public function build()
    {
        $logoPath = public_path('logos/logo-clary-spider.png');
        $logoCid = 'logo-clary';

        $mail = $this->subject("Assignment Details: You've been added to {$this->clientName}")
            ->view('emails.team-invitation')
            ->with([
                'logoCid' => 'cid:' . $logoCid,
            ]);

        // Embed the logo using Symfony's method
        if (file_exists($logoPath)) {
            $mail->withSymfonyMessage(function (Email $message) use ($logoPath, $logoCid) {
                $message->embedFromPath($logoPath, $logoCid, 'image/png');
            });
        }

        // Use consistent "Clary" branding for all emails
        // The actual sender's info is shown in the email body
        // Reply-To is set to sender's email so replies go to them
        if ($this->sender) {
            $mail->replyTo($this->sender->email, $this->sender->name);
        }

        return $mail;
    }
}
