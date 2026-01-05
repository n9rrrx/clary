<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\Invoice;

class InvoiceCreated extends Notification
{
    use Queueable;

    protected Invoice $invoice;

    /**
     * Create a new notification instance.
     */
    public function __construct(Invoice $invoice)
    {
        $this->invoice = $invoice;
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
        $amount = number_format($this->invoice->total_amount ?? 0, 2);

        return [
            'title' => 'New Invoice Created',
            'message' => "Invoice #{$this->invoice->invoice_number} for \${$amount} has been created",
            'icon' => 'invoice',
            'url' => route('invoices.show', $this->invoice->id),
            'invoice_id' => $this->invoice->id,
        ];
    }
}
