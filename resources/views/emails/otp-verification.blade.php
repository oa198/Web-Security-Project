<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            background-color: #6c5ce7;
            padding: 20px;
            color: white;
            text-align: center;
        }
        .content {
            padding: 20px;
        }
        .otp-box {
            background-color: #f3f4f6;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
            text-align: center;
            font-size: 28px;
            letter-spacing: 5px;
            font-weight: bold;
            color: #4c4c4c;
        }
        .footer {
            text-align: center;
            padding: 20px;
            font-size: 12px;
            color: #666;
            border-top: 1px solid #eee;
        }
        .btn {
            display: inline-block;
            background-color: #6c5ce7;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }
        .note {
            margin-top: 15px;
            padding: 10px;
            background-color: #fff8e1;
            border-left: 4px solid #ffc107;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Email Verification</h1>
        </div>
        <div class="content">
            <h2>Hello {{ $verification->user->name }},</h2>
            <p>Thank you for registering with our University Student Information System. To complete your registration, please verify your email address using the One-Time Password (OTP) below:</p>
            
            <div class="otp-box">
                {{ $verification->otp }}
            </div>
            
            <p>This code will expire in 10 minutes. Please enter this code in the verification window to complete your email verification.</p>
            
            <div class="note">
                <strong>Note:</strong> If you did not request this verification, please ignore this email or contact our support team if you have concerns.
            </div>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} University SIS. All rights reserved.</p>
            <p>This is an automated email. Please do not reply.</p>
        </div>
    </div>
</body>
</html>
