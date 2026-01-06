<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Invoice;
use App\Models\User;
use Illuminate\Mail\Mailables\Envelope;
use Symfony\Component\Mime\Email;

class InvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public Invoice $invoice;
    public User $sender;

    /**
     * Create a new message instance.
     */
    public function __construct(Invoice $invoice, User $sender)
    {
        $this->invoice = $invoice;
        $this->sender = $sender;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Invoice #{$this->invoice->invoice_number} - {$this->sender->name}",
        );
    }

    /**
     * Build the message.
     */
    public function build()
    {
        $logoPath = public_path('logos/logo-clary-spider.png');
        $logoCid = 'logo-clary';

        $mailable = $this->markdown('emails.invoice')
            ->with([
                'invoice' => $this->invoice,
                'sender' => $this->sender,
                'logoCid' => 'cid:' . $logoCid,
            ]);

        // Embed the logo using Symfony's method
        if (file_exists($logoPath)) {
            $mailable->withSymfonyMessage(function (Email $message) use ($logoPath, $logoCid) {
                $message->embedFromPath($logoPath, $logoCid, 'image/png');
            });
        }

        return $mailable;
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
