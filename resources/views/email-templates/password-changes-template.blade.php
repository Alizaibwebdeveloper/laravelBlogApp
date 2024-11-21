<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }
        table {
            border-spacing: 0;
            width: 100%;
        }
        td {
            padding: 10px;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 5px;
            overflow: hidden;
        }
        .header {
            background-color: #007bff;
            color: #ffffff;
            text-align: center;
            padding: 15px 10px;
        }
        .content {
            padding: 20px;
            text-align: left;
            color: #333;
        }
        .footer {
            background-color: #f4f4f4;
            text-align: center;
            padding: 10px;
            font-size: 12px;
            color: #666;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
        @media only screen and (max-width: 600px) {
            .content {
                padding: 15px;
            }
        }
    </style>
</head>
<body>
    <table>
        <tr>
            <td align="center">
                <div class="container">
                    <div class="header">
                        <h1>Password Changed</h1>
                    </div>
                    <div class="content">
                        <p>Hello <strong>{{$user->name}}</strong>,</p>
                        <p>Your password has been successfully updated. Below are your updated credentials:</p>
                        <p><strong>Username/Email:</strong> {{$user->email}}</p>
                        <p><strong>Password:</strong>{{$new_password}}</p>
                        <p>If you did not make this change, please contact our support team immediately.</p>
                    </div>
                    <div class="footer">
                        <p>© 2024 Your Company. All rights reserved.</p>
                    </div>
                </div>
            </td>
        </tr>
    </table>
</body>
</html>
