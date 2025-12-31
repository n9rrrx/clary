<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Inter', sans-serif; color: #374151; line-height: 1.6; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #e5e7eb; border-radius: 12px; }
        .header { font-size: 24px; font-weight: bold; color: #111827; margin-bottom: 20px; }
        .assignment-box { background-color: #eff6ff; padding: 20px; border-radius: 8px; margin: 20px 0; border: 1px solid #dbeafe; }
        .cred-box { background-color: #f3f4f6; padding: 20px; border-radius: 8px; margin: 20px 0; border: 1px solid #e5e7eb; }
        .button { background-color: #4f46e5; color: #ffffff !important; padding: 12px 24px; border-radius: 8px; text-decoration: none; display: inline-block; font-weight: 600; }
        .footer { font-size: 12px; color: #6b7280; margin-top: 40px; }
        .highlight { color: #1e40af; font-weight: 600; }
    </style>
</head>
<body>
<div class="container">
    <div class="header">Welcome to {{ $clientName }}</div>

    <p>Hello {{ $user->name }},</p>
    <p>You have been assigned to <strong>{{ $clientName }}</strong>. Below are your specific role and budget details as assigned by the administrator:</p>

    <div class="assignment-box">
        <p style="margin: 0;"><strong>Assigned Role:</strong> <span class="highlight">{{ ucfirst($assignedRole) }}</span></p>

        @if($assignedProject)
            <div style="margin-top: 15px; padding-top: 15px; border-top: 1px solid #dbeafe;">
                <p style="margin: 0 0 10px 0; font-weight: 600; color: #1e40af;">Assigned Project:</p>
                <p style="margin: 5px 0;"><strong>Project Name:</strong> <span class="highlight">{{ $assignedProject->name }}</span></p>
                @if($assignedProject->budget)
                    <p style="margin: 5px 0;"><strong>Project Budget:</strong> <span class="highlight">${{ number_format($assignedProject->budget, 2) }}</span></p>
                @endif
                @if($assignedProject->start_date)
                    <p style="margin: 5px 0;"><strong>Start Date:</strong> {{ $assignedProject->start_date->format('M d, Y') }}</p>
                @endif
                @if($assignedProject->end_date)
                    <p style="margin: 5px 0;"><strong>End Date:</strong> {{ $assignedProject->end_date->format('M d, Y') }}</p>
                @endif
                @php
                    $statusLabels = [
                        'planning' => 'Not Started',
                        'in_progress' => 'In Progress',
                        'on_hold' => 'On Hold',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ];
                @endphp
                <p style="margin: 5px 0;"><strong>Status:</strong> <span class="highlight">{{ $statusLabels[$assignedProject->status] ?? ucwords(str_replace('_', ' ', $assignedProject->status)) }}</span></p>
            </div>
        @endif
    </div>

    <div class="cred-box">
        <p style="margin: 0; font-weight: 600;">Your Login Credentials:</p>
        <p style="margin: 10px 0 5px 0;"><strong>Email:</strong> {{ $user->email }}</p>
        <p style="margin: 0;"><strong>Temporary Password:</strong> <code style="background: #fff; padding: 2px 4px; border-radius: 4px;">{{ $password }}</code></p>
    </div>

    <p>For security, please change your password after logging in for the first time.</p>

    <p style="margin-top: 30px;">
        <a href="{{ url('/login') }}" class="button">Access Your Dashboard</a>
    </p>

    <div class="footer">
        This invitation was sent by the administrator of {{ $clientName }}. You have been assigned this company in this money for this role.
    </div>
</div>
</body>
</html>
