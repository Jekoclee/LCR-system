<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Admin Access Granted</title>
</head>
<body style="font-family: Arial, sans-serif; color: #111; line-height: 1.6;">
    <div style="max-width: 640px; margin: 0 auto; padding: 24px;">
        <h2 style="margin: 0 0 12px;">You are now an Admin</h2>
        <p style="margin: 0 0 16px;">Hi {{ $user->name }},</p>
        <p style="margin: 0 0 16px;">
            Your account ({{ $user->email }}) has been granted admin access by the Super Admin.
        </p>
        <p style="margin: 0 0 16px;">
            You can sign in to the Admin Panel and start managing bookings, rooms, and users assigned to you.
        </p>
        <div style="margin: 20px 0; padding: 16px; border: 1px solid #ddd; border-radius: 8px; background: #f8f8f8;">
            <a href="{{ route('admin.login') }}" style="display:inline-block; background:#2563eb; color:#fff; text-decoration:none; padding:12px 18px; border-radius:8px; font-weight:bold;">
                Go to Admin Login
            </a>
        </div>
        <p style="margin: 24px 0 0; font-size: 13px; color: #555;">
            &mdash; LCR Booking Team
        </p>
    </div>
    </body>
</html>
