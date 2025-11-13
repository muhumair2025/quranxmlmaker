<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
    <style>
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 0;
        }
        .header {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            padding: 40px 20px;
            text-align: center;
        }
        .header h1 {
            color: #ffffff;
            margin: 0;
            font-size: 28px;
            font-weight: 700;
        }
        .content {
            padding: 40px 30px;
        }
        .greeting {
            font-size: 18px;
            color: #1f2937;
            margin-bottom: 20px;
        }
        .message {
            font-size: 16px;
            color: #4b5563;
            margin-bottom: 30px;
            line-height: 1.8;
        }
        .otp-container {
            background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
            border: 2px dashed #10b981;
            border-radius: 12px;
            padding: 30px;
            text-align: center;
            margin: 30px 0;
        }
        .otp-code {
            font-size: 42px;
            font-weight: 700;
            color: #059669;
            letter-spacing: 8px;
            font-family: 'Courier New', monospace;
            margin: 10px 0;
        }
        .otp-label {
            font-size: 14px;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 10px;
        }
        .info-box {
            background-color: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 15px;
            margin: 25px 0;
            border-radius: 4px;
        }
        .info-box p {
            margin: 0;
            font-size: 14px;
            color: #92400e;
        }
        .footer {
            background-color: #f9fafb;
            padding: 30px;
            text-align: center;
            border-top: 1px solid #e5e7eb;
        }
        .footer p {
            margin: 5px 0;
            font-size: 14px;
            color: #6b7280;
        }
        .button {
            display: inline-block;
            padding: 14px 28px;
            background-color: #10b981;
            color: #ffffff;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            margin-top: 20px;
        }
        .divider {
            height: 1px;
            background-color: #e5e7eb;
            margin: 30px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🔐 OTP Verification</h1>
        </div>
        
        <div class="content">
            <div class="greeting">
                Hello {{ $user->name }},
            </div>
            
            <div class="message">
                Thank you for logging in! To complete your authentication, please use the verification code below:
            </div>
            
            <div class="otp-container">
                <div class="otp-label">Your Verification Code</div>
                <div class="otp-code">{{ $otp }}</div>
                <div style="font-size: 12px; color: #6b7280; margin-top: 10px;">
                    This code will expire in 10 minutes
                </div>
            </div>
            
            <div class="info-box">
                <p><strong>⚠️ Security Notice:</strong> Never share this code with anyone. Our team will never ask for your verification code.</p>
            </div>
            
            <div class="divider"></div>
            
            <div style="font-size: 14px; color: #6b7280;">
                <p>If you didn't request this code, please ignore this email or contact our support team if you have concerns.</p>
            </div>
        </div>
        
        <div class="footer">
            <p><strong>Quran XML Generator</strong></p>
            <p>This is an automated message, please do not reply.</p>
            <p style="font-size: 12px; color: #9ca3af;">© {{ date('Y') }} All rights reserved.</p>
        </div>
    </div>
</body>
</html>

