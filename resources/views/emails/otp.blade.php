<!DOCTYPE html>
<html>
<head>
    <title>Kode OTP Reset Password</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; margin: 0; padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto; background: #fff; border-radius: 10px; padding: 20px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
        <h2 style="color: #333; text-align: center; margin-bottom: 20px;">Reset Password LAPOR PAL</h2>
        
        <p style="color: #666; margin-bottom: 20px;">Berikut adalah kode OTP Anda untuk reset password:</p>
        
        <div style="background: #f8f9fa; padding: 15px; border-radius: 5px; text-align: center; margin-bottom: 20px;">
            <h1 style="color: #333; letter-spacing: 5px; margin: 0;">{{ $otp }}</h1>
        </div>
        
        <p style="color: #666; margin-bottom: 10px;">Kode OTP ini akan kedaluwarsa dalam 5 menit.</p>
        
        <p style="color: #666; margin-bottom: 20px;">Jika Anda tidak meminta reset password, abaikan email ini.</p>
        
        <div style="text-align: center; color: #999; font-size: 12px; margin-top: 30px;">
            <p>Email ini dikirim secara otomatis, mohon tidak membalas email ini.</p>
            <p>&copy; 2024 LAPOR PAL. All rights reserved.</p>
        </div>
    </div>
</body>
</html>