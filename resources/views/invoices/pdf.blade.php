<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice {{ $invoice->invoice_number }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: DejaVu Sans, Arial, sans-serif; font-size: 12px; color: #1f2937; line-height: 1.4; background: #fff; }

        .header { background: #2563eb; padding: 25px 30px; }
        .logo-text { color: white; font-size: 22px; font-weight: bold; vertical-align: middle; }
        .status-badge { background: white; color: #2563eb; padding: 6px 16px; border-radius: 20px; font-size: 10px; font-weight: bold; text-transform: uppercase; display: inline-block; }
        .status-paid { background: #10b981; color: white; }
        .status-overdue { background: #ef4444; color: white; }

        .content { padding: 30px; }

        .invoice-title { font-size: 28px; font-weight: bold; color: #111827; margin-bottom: 5px; }
        .meta-label { font-size: 9px; text-transform: uppercase; color: #6b7280; margin-bottom: 2px; }
        .meta-value { font-size: 13px; font-weight: 600; color: #111827; margin-bottom: 12px; }

        .section { margin-bottom: 25px; }
        .section-label { font-size: 9px; text-transform: uppercase; color: #6b7280; font-weight: bold; margin-bottom: 5px; }
        .section-name { font-size: 14px; font-weight: bold; color: #111827; }
        .section-email { color: #6b7280; font-size: 11px; }

        .project-box { background: #f3f4f6; padding: 10px 15px; margin-bottom: 20px; }

        .table-header { background: #f9fafb; }
        .table-header td { padding: 10px; font-size: 9px; text-transform: uppercase; color: #6b7280; font-weight: bold; border-bottom: 2px solid #e5e7eb; }
        .table-row td { padding: 15px 10px; border-bottom: 1px solid #f3f4f6; }

        .totals-box { background: #f9fafb; padding: 15px; width: 220px; float: right; }
        .total-row { margin-bottom: 8px; }
        .total-label { color: #6b7280; font-size: 11px; }
        .total-value { font-weight: 600; color: #111827; font-size: 11px; }
        .total-final { border-top: 2px solid #e5e7eb; padding-top: 10px; margin-top: 10px; }
        .total-final-label { font-size: 14px; font-weight: bold; color: #111827; }
        .total-final-value { font-size: 18px; font-weight: bold; color: #2563eb; }

        .footer { clear: both; padding-top: 40px; text-align: center; border-top: 1px solid #e5e7eb; margin-top: 30px; }
        .footer-text { color: #6b7280; font-size: 11px; }
        .footer-brand { color: #9ca3af; font-size: 10px; margin-top: 5px; }
    </style>
</head>
<body>
    <div class="header">
        <table width="100%" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                    <table cellpadding="0" cellspacing="0">
                        <tr>
                            <td style="vertical-align: middle; padding-right: 10px;">
                                <img src="{{ public_path('logos/logo-clary-spider.png') }}" alt="Clary" width="36" height="36">
                            </td>
                            <td style="vertical-align: middle;">
                                <span class="logo-text">Clary</span>
                            </td>
                        </tr>
                    </table>
                </td>
                <td align="right">
                    <span class="status-badge {{ $invoice->status === 'paid' ? 'status-paid' : ($invoice->status === 'overdue' ? 'status-overdue' : '') }}">
                        {{ strtoupper($invoice->status) }}
                    </span>
                </td>
            </tr>
        </table>
    </div>

    <div class="content">
        <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 25px; border-bottom: 2px solid #e5e7eb; padding-bottom: 20px;">
            <tr>
                <td width="50%">
                    <div class="invoice-title">INVOICE</div>
                </td>
                <td width="50%" align="right">
                    <div class="meta-label">Invoice #</div>
                    <div class="meta-value" style="font-size: 16px;">{{ $invoice->invoice_number }}</div>
                    <div class="meta-label">Date Issued</div>
                    <div class="meta-value">{{ $invoice->issue_date->format('M d, Y') }}</div>
                    <div class="meta-label">Due Date</div>
                    <div class="meta-value" style="margin-bottom: 0;">{{ $invoice->due_date->format('M d, Y') }}</div>
                </td>
            </tr>
        </table>

        <table width="100%" cellpadding="0" cellspacing="0" class="section">
            <tr>
                <td width="50%" valign="top">
                    <div class="section-label">Bill To</div>
                    <div class="section-name">{{ $invoice->client->name ?? 'N/A' }}</div>
                    <div class="section-email">{{ $invoice->client->email ?? '' }}</div>
                </td>
                <td width="50%" valign="top">
                    <div class="section-label">Payable To</div>
                    <div class="section-name">{{ $sender->name }}</div>
                    <div class="section-email">{{ $sender->email }}</div>
                </td>
            </tr>
        </table>

        @if($invoice->project)
        <div class="project-box">
            <span class="section-label">Project:</span>
            <span style="font-weight: 600; color: #111827; margin-left: 8px;">{{ $invoice->project->name }}</span>
        </div>
        @endif

        <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 25px;">
            <tr class="table-header">
                <td width="75%">Description</td>
                <td width="25%" align="right">Amount</td>
            </tr>
            <tr class="table-row">
                <td style="color: #374151;">
                    @if($invoice->notes)
                        {!! nl2br(e($invoice->notes)) !!}
                    @else
                        <em style="color: #9ca3af;">No description provided.</em>
                    @endif
                </td>
                <td align="right" style="font-weight: 600;">${{ number_format($invoice->subtotal, 2) }}</td>
            </tr>
        </table>

        <div class="totals-box">
            <div class="total-row">
                <table width="100%"><tr>
                    <td class="total-label">Subtotal</td>
                    <td align="right" class="total-value">${{ number_format($invoice->subtotal, 2) }}</td>
                </tr></table>
            </div>
            @if($invoice->tax > 0)
            <div class="total-row">
                <table width="100%"><tr>
                    <td class="total-label">Tax</td>
                    <td align="right" class="total-value">${{ number_format($invoice->tax, 2) }}</td>
                </tr></table>
            </div>
            @endif
            <div class="total-final">
                <table width="100%"><tr>
                    <td class="total-final-label">Total Due</td>
                    <td align="right" class="total-final-value">${{ number_format($invoice->total, 2) }}</td>
                </tr></table>
            </div>
        </div>

        <div class="footer">
            <div class="footer-text">Thank you for your business!</div>
            <div class="footer-brand">Generated by Clary</div>
        </div>
    </div>
</body>
</html>
