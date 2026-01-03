<div style="font-family: Arial, sans-serif; line-height: 1.6; color: #222">
    <p>Hi {{ $inquiry['name'] ?? 'there' }},</p>
    <p>Thank you for reaching out to us. Here's our response to your inquiry:</p>
    <div style="background:#f7f7f7;border:1px solid #e5e5e5;border-radius:8px;padding:16px;margin:16px 0">
        <p>{{ nl2br(e($body)) }}</p>
    </div>
    @if(!empty($inquiry['subject']))
        <p><strong>Your original subject:</strong> {{ $inquiry['subject'] }}</p>
    @endif
    <p style="margin-top: 24px;">
        Best regards,<br>
        {{ $admin?->name ?? config('app.name') }} Team
    </p>
</div>
