<x-mail::message :logoCid="$logoCid ?? ''">
# You've received an invoice

Hi {{ $invoice->client->name }},

**{{ $sender->name }}** has sent you an invoice.

---

<x-mail::panel>
<div style="text-align: center;">
<p style="font-size: 14px; color: #6b7280; margin-bottom: 5px;">Invoice Number</p>
<p style="font-size: 24px; font-weight: bold; color: #111827; margin: 0;">{{ $invoice->invoice_number }}</p>
</div>
</x-mail::panel>

<x-mail::table>
| | |
|:--|--:|
| **Amount Due** | **${{ number_format($invoice->total, 2) }}** |
| Due Date | {{ $invoice->due_date->format('F d, Y') }} |
@if($invoice->project)
| Project | {{ $invoice->project->name }} |
@endif
</x-mail::table>

@if($invoice->notes)
> **Note from {{ $sender->name }}:** {{ $invoice->notes }}
@endif

---

Please find the invoice details below. For payment, please contact {{ $sender->name }} directly.

**Contact:** {{ $sender->email }}

<x-mail::subcopy>
This invoice was sent via {{ config('app.name') }}. If you have any questions, please reply to this email or contact the sender directly.
</x-mail::subcopy>
</x-mail::message>
