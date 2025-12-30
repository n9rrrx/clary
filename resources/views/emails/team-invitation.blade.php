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
        <p style="margin: 0;"><strong>Assigned Role:</strong> <span class="highlight">{{ $assignedRole }}</span></p>
        <p style="margin: 10px 0 0 0;"><strong>Allocated Budget:</strong> <span class="highlight">${{ number_format($budget, 2) }}</span></p>
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
