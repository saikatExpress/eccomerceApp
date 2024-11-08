<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your OTP Code</title>
    <style>
        /* Basic styling for the email */
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; color: #333; }
        .container { max-width: 600px; margin: auto; background: #ffffff; padding: 20px; border-radius: 8px; }
        .header { background-color: #4CAF50; color: white; padding: 15px; text-align: center; border-top-left-radius: 8px; border-top-right-radius: 8px; }
        .otp-code { font-size: 32px; font-weight: bold; color: #4CAF50; margin: 20px 0; text-align: center; }
        .content { padding: 20px; }
        .footer { text-align: center; font-size: 0.8em; color: #777; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Your OTP Code</h2>
        </div>
        <div class="content">
            <p>Hello {{ $user->name }},</p>
            <p>Use the OTP code below to verify your account:</p>
            <div class="otp-code">{{ $otpCode }}</div>
            <p>This code will expire in 10 minutes.</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Your Company Name. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
