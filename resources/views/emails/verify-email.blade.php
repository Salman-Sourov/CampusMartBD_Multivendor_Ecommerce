@php
    $name = session('temp_user.name');
    $role = session('temp_user.role');
@endphp
<!DOCTYPE html>
{{-- <html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Verify Your Email - CampusMartBD</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* Reset and basic styles */
        body,
        html {
            margin: 0;
            padding: 0;
            font-family: 'Helvetica', Arial, sans-serif;
            background-color: #f4f6f8;
        }

        a {
            text-decoration: none;
        }

        /* Container */
        .email-container {
            max-width: 650px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        /* Header */
        .email-header {
            background-color: #ff4c3b;
            /* CampusMartBD red */
            text-align: center;
            padding: 30px 20px;
        }

        .email-header img {
            max-height: 60px;
        }

        /* Body */
        .email-body {
            padding: 30px 25px;
            color: #333333;
            font-size: 16px;
            line-height: 1.7;
        }

        .email-body h2 {
            color: #333333;
            font-size: 22px;
            margin-bottom: 15px;
        }

        .email-body p {
            margin: 12px 0;
        }

        /* OTP Code */
        .otp-code {
            display: block;
            text-align: center;
            font-size: 36px;
            font-weight: bold;
            color: #ff4c3b;
            background: #fff2f0;
            padding: 20px 0;
            border-radius: 10px;
            margin: 20px 0;
            letter-spacing: 5px;
        }

        /* Footer */
        .email-footer {
            padding: 25px 20px;
            text-align: center;
            font-size: 14px;
            color: #777777;
            background-color: #f4f6f8;
        }

        .email-footer a {
            color: #ff4c3b;
        }

        /* Buttons (Optional) */
        .btn-primary {
            display: inline-block;
            background-color: #ff4c3b;
            color: #ffffff;
            font-weight: bold;
            padding: 12px 30px;
            border-radius: 8px;
            text-decoration: none;
            margin-top: 15px;
        }

        /* Responsive */
        @media screen and (max-width: 650px) {
            .email-container {
                margin: 10px;
            }

            .email-body,
            .email-header,
            .email-footer {
                padding: 20px 15px;
            }

            .otp-code {
                font-size: 28px;
            }
        }
    </style>
</head>

<body>
    <div class="email-body">
        <h2>Hello {{ $name ?? 'Sir/Mam' }}!</h2>
        <p>Welcome to <strong>CampusMartBD</strong>! You want to register as a
            <strong>{{ Str::upper($role ?? 'user/agent') }}</strong>
        </p>
        <p>CampusMart BD is a student-focused multivendor eCommerce platform, empowering young entrepreneurs to
            showcase and sell their products.</p>

        <p>Your OTP code to verify your email is:</p>
        <span class="otp-code">{{ $code }}</span>

        <p>This code will expire in 10 minutes. Please do not share it with anyone.</p>

        <p>Any Queries? Call us or email:</p>
        <p>
            📞 01521406205 <br>
            ✉ <a href="mailto:support@campusmartbd.com">support@campusmartbd.com</a>
        </p>

        <a href="#" class="btn-primary">Visit CampusMartBD</a>
    </div>
</body>

</html> --}}

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
        <p>Hi {{ $name ?? '' }},</p>
        <p>Thank you for with us. To complete your registration/recovering account, please use the following verification code:</p>

        <h1 style="letter-spacing:5px; color:#03bb77;">{{ $code }}</h1>

        <p>Enter this code on the verification page to activate your account.</p>
        <p>If you did not register on CampusMart BD, please ignore this email.</p>
    </div>
</body>
</html>


