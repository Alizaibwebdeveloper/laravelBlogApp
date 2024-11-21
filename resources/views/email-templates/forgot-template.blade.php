<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <style>
        /* General email styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .header {
            background-color: #4CAF50;
            color: #ffffff;
            text-align: center;
            padding: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 20px;
        }
        .content p {
            line-height: 1.6;
            margin: 10px 0;
        }
        .button {
            display: block;
            width: fit-content;
            margin: 20px auto;
            background-color: #4CAF50;
            color: #ffffff;
            text-decoration: none;
            padding: 12px 24px;
            border-radius: 5px;
            text-align: center;
            font-size: 16px;
        }
        .button:hover {
            background-color: #45a049;
        }
        .footer {
            text-align: center;
            padding: 10px;
            font-size: 14px;
            color: #777;
            background-color: #f4f4f4;
        }
        .footer a {
            color: #4CAF50;
            text-decoration: none;
        }
        /* Responsive styles */
        @media (max-width: 600px) {
            .content {
                padding: 10px;
            }
            .header h1 {
                font-size: 20px;
            }
            .button {
                width: 90%;
                padding: 10px;
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Email Header -->
        <div class="header">
            <h1>Password Reset Request</h1>
        </div>
        
        <!-- Email Content -->
        <div class="content">
            <h4>Hi {{ $user->name }},</h4>
            <p>We received a request to reset your password. Click the button below to reset it:</p>
            <a href="{{$actionlink  }}"  target="_blank" class="button">Reset Password</a>
            <p>This link is valid for 15 minuts</p>
            <p>If you didn't request a password reset, please ignore this email or contact support if you have concerns.</p>
            <p>Thank you,</p>
            <p>The {{ config('app.name') }} Team</p>
        </div>

        <!-- Email Footer -->
        <div class="footer">

            <p>&copy;{{date('Y')}} LaraBlogApp All Right Reserved.</p>
        </div>
    </div>
</body>
</html>
