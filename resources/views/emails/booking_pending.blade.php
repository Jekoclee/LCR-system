<!DOCTYPE html>
<html>

<head>
    <title>Booking Request Received</title>
</head>

<body
    style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
    <div
        style="background-color: #0c4a6e; color: white; padding: 20px; text-align: center; border-radius: 8px 8px 0 0;">
        <h1 style="margin: 0; font-size: 24px;">Booking Request Received</h1>
    </div>

    <div style="border: 1px solid #ddd; border-top: none; padding: 20px; border-radius: 0 0 8px 8px;">
        <p>Hello <strong>{{ $data['name'] }}</strong>,</p>

        <p>Thank you for choosing LCR Booking. We have received your booking request and our team is currently reviewing
            your payment proof.</p>

        <div style="background-color: #f0f9ff; border-left: 4px solid #0ea5e9; padding: 15px; margin: 20px 0;">
            <p style="margin: 0; font-weight: bold;">Reference Number: <span
                    style="color: #0284c7;">{{ $data['ref'] }}</span></p>
        </div>

        <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
            <tr style="border-bottom: 1px solid #eee;">
                <td style="padding: 10px 0; font-weight: bold; width: 40%;">Check-in Date:</td>
                <td style="padding: 10px 0;">{{ $data['check_in'] }}</td>
            </tr>
            <tr style="border-bottom: 1px solid #eee;">
                <td style="padding: 10px 0; font-weight: bold;">Check-out Date:</td>
                <td style="padding: 10px 0;">{{ $data['check_out'] }}</td>
            </tr>
            <tr style="border-bottom: 1px solid #eee;">
                <td style="padding: 10px 0; font-weight: bold;">Guests:</td>
                <td style="padding: 10px 0;">{{ $data['guests'] }}</td>
            </tr>
        </table>

        <p>You will receive another email once your booking is successfully confirmed.</p>

        <p style="margin-top: 30px; font-size: 14px; color: #666;">
            Best regards,<br>
            <strong>LCR Booking Team</strong>
        </p>
    </div>
</body>

</html>