<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            background-color: #ffffff;
            border-radius: 10px;
            padding: 40px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .logo {
            text-align: center;
            margin-bottom: 30px;
        }
        .logo img {
            max-width: 180px;
        }
        h1 {
            color: #FF4400;
            font-size: 28px;
            margin-bottom: 20px;
            text-align: center;
            font-weight: bold;
        }
        .content {
            padding: 20px 0;
            color: #1D1D1D;
        }
        .content p {
            margin-bottom: 15px;
            font-size: 15px;
        }
        .button {
            display: inline-block;
            padding: 15px 40px;
            background-color: #FF4400;
            color: white !important;
            text-decoration: none;
            border-radius: 25px;
            font-weight: bold;
            text-align: center;
            margin: 25px 0;
            font-size: 16px;
        }
        .button:hover {
            background-color: #DE3B00;
        }
        .button-container {
            text-align: center;
        }
        .footer {
            text-align: center;
            color: #626262;
            font-size: 13px;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e0e0e0;
        }
        .warning {
            background-color: #FFF3E0;
            border-left: 4px solid #FF4400;
            padding: 15px;
            border-radius: 5px;
            margin-top: 25px;
            font-size: 13px;
        }
        .warning strong {
            color: #FF4400;
        }
        .link-box {
            background-color: #f9f9f9;
            padding: 10px;
            border-radius: 5px;
            word-break: break-all;
            font-size: 12px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">
            <img src="{{ asset('images/logo-titiphanhati-lightmode.svg') }}" alt="TitipanHati Logo">
        </div>
        
        <h1>Reset Password</h1>
        
        <div class="content">
            <p><strong>Halo,</strong></p>
            <p>Anda menerima email ini karena kami menerima permintaan reset password untuk akun Anda.</p>
            
            <div class="button-container">
                <a href="{{ $resetUrl }}" class="button">Reset Password Sekarang</a>
            </div>
            
            <p style="text-align: center; color: #626262; font-size: 14px;">
                <strong>Link reset password ini akan kedaluwarsa dalam 30 menit.</strong>
            </p>
            
            <p>Jika Anda tidak meminta reset password, abaikan email ini dan akun Anda akan tetap aman.</p>
            
            <div class="warning">
                <strong>Catatan Keamanan:</strong><br>
                Jika Anda kesulitan mengklik tombol "Reset Password", salin dan tempel URL berikut ke browser Anda:
                <div class="link-box">
                    {{ $resetUrl }}
                </div>
            </div>
        </div>
        
        <div class="footer">
            <p><strong>&copy; {{ date('Y') }} TitipanHati</strong></p>
            <p>Email ini dikirim secara otomatis, mohon tidak membalas email ini.</p>
        </div>
    </div>
</body>
</html>