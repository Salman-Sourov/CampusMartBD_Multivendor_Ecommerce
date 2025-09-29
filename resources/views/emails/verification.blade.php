<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>CampusMart Email Verification</title>
    <style>
        body { font-family: Arial, sans-serif; background:#f4f4f4; padding:20px; }
        .mail-box { background:#fff; padding:20px; border-radius:10px; max-width:500px; margin:auto; }
        .btn { display:inline-block; padding:10px 20px; background:#0d6efd; color:#fff; text-decoration:none; border-radius:5px; }
    </style>
</head>
<body>
    <div class="mail-box">
        <h2>Welcome to CampusMart BD 🎉</h2>
        <p>Hi {{ $user->name ?? 'User' }},</p>
        <p>Thank you for registering with us. To complete your registration, please use the following verification code:</p>

        <h1 style="letter-spacing:5px; color:#0d6efd;">{{ $code }}</h1>

        <p>Enter this code on the verification page to activate your account.</p>
        <br>
        <p>If you did not register on CampusMart BD, please ignore this email.</p>
    </div>
</body>
</html>
