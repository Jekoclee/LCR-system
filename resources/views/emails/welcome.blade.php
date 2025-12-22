<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Welcome</title>
</head>

<body style="font-family: Arial, sans-serif; color: #111; line-height: 1.6;">
    <div style="max-width: 640px; margin: 0 auto; padding: 24px;">
        <h2 style="margin: 0 0 12px;">Welcome to LCR Booking</h2>
        <p style="margin: 0 0 16px;">Hi {{ $user->name }},</p>
        <p style="margin: 0 0 16px;">
            Your account has been created successfully using {{ $user->email }}.
        </p>
        <p style="margin: 0 0 16px;">
            You can now sign in and start booking hotels on our platform.
        </p>
        <div style="margin: 20px 0; padding: 16px; border: 1px solid #ddd; border-radius: 8px; background: #f8f8f8;">
            <p style="margin: 0 0 8px;">Your verification code:</p>
            <div style="font-size: 24px; font-weight: bold; letter-spacing: 2px; color: #222;">
                {{ $code }}
            </div>
            <p style="margin: 8px 0 0; font-size: 13px; color: #555;">Use this code to verify your email.</p>
        </div>
        <p style="margin: 0 0 16px;">
            If you didn’t create this account, please ignore this email.
        </p>
        <p style="margin: 24px 0 0; font-size: 13px; color: #555;">
            &mdash; LCR Booking Team
        </p>
    </div>
</body>

</html>