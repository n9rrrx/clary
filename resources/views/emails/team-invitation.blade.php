<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif; color: #374151; line-height: 1.6; background: #f3f4f6; margin: 0; padding: 20px; }
        .wrapper { max-width: 600px; margin: 0 auto; }
        .logo-header { text-align: center; padding: 30px 0; }
        .logo { width: 48px; height: 48px; }
        .logo-text { font-size: 24px; font-weight: 700; color: #0066FF; margin-top: 8px; }
        .container { background: #ffffff; padding: 32px; border-radius: 16px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05); }
        .header { font-size: 24px; font-weight: bold; color: #111827; margin-bottom: 20px; }
        .assignment-box { background-color: #eff6ff; padding: 20px; border-radius: 12px; margin: 20px 0; border: 1px solid #dbeafe; }
        .cred-box { background-color: #f9fafb; padding: 20px; border-radius: 12px; margin: 20px 0; border: 1px solid #e5e7eb; }
        .button { background: linear-gradient(135deg, #0066FF, #6B4CE6); color: #ffffff !important; padding: 14px 28px; border-radius: 10px; text-decoration: none; display: inline-block; font-weight: 600; }
        .footer { font-size: 12px; color: #9ca3af; margin-top: 30px; text-align: center; padding-top: 20px; border-top: 1px solid #e5e7eb; }
        .highlight { color: #0066FF; font-weight: 600; }
        .sender-badge { display: inline-block; background: #f0f9ff; border: 1px solid #bae6fd; padding: 4px 12px; border-radius: 20px; font-size: 13px; color: #0369a1; margin-bottom: 16px; }
    </style>
</head>
<body>
<div class="wrapper">
    <!-- Logo Header -->
    <div class="logo-header">
        <div class="logo-text" style="font-size: 28px; font-weight: 800; color: #0066FF;">Clary</div>
    </div>

    <div class="container">
        <div class="header">Welcome to {{ $clientName }}</div>

        <p>Hello {{ $user->name }},</p>

        @if(isset($sender) && $sender)
            <div class="sender-badge">📧 Invited by {{ $sender->name }}</div>
            <p>You've been invited to join <strong>{{ $clientName }}</strong>. Below are your role and project details:</p>
        @else
            <p>You have been assigned to <strong>{{ $clientName }}</strong>. Below are your specific role and budget details:</p>
        @endif

        <div class="assignment-box">
            <p style="margin: 0;"><strong>Assigned Role:</strong> <span class="highlight">{{ ucfirst($assignedRole) }}</span></p>

            @if($assignedProject)
                <div style="margin-top: 15px; padding-top: 15px; border-top: 1px solid #dbeafe;">
                    <p style="margin: 0 0 10px 0; font-weight: 600; color: #0066FF;">📁 Assigned Project:</p>
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
            <p style="margin: 0; font-weight: 600;">🔐 Your Login Credentials:</p>
            <p style="margin: 10px 0 5px 0;"><strong>Email:</strong> {{ $user->email }}</p>
            <p style="margin: 0;"><strong>Temporary Password:</strong> <code style="background: #fff; padding: 4px 8px; border-radius: 6px; font-family: monospace; border: 1px solid #e5e7eb;">{{ $password }}</code></p>
        </div>

        <p style="color: #6b7280; font-size: 14px;">⚠️ For security, please change your password after logging in for the first time.</p>

        <p style="margin-top: 30px; text-align: center;">
            <a href="{{ url('/login') }}" class="button">Access Your Dashboard →</a>
        </p>

        <div class="footer">
            <p style="margin: 0;">This is an automated message from Clary.</p>
            <p style="margin: 5px 0 0 0; color: #d1d5db;">© {{ date('Y') }} Clary. All rights reserved.</p>
        </div>
    </div>
</div>
</body>
</html>
