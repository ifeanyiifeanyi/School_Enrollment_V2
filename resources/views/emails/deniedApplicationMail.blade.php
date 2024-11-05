<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Status Update - COLLEGE OF NURSING SCIENCES, ST CHARLES BORROMEO SPECIALIST HOSPITAL, ONITSHA.</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo {
            max-height: 80px;
            width: auto;
        }

        h1 {
            color: #003366;
            text-align: center;
            margin-bottom: 20px;
        }

        .content {
            margin-bottom: 20px;
        }

        .important-notice {
            background-color: #f9f9f9;
            border: 1px solid #e0e0e0;
            padding: 15px;
            margin-top: 20px;
            border-radius: 5px;
        }

        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 0.9em;
            color: #666;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <img src="{{ asset('nursinglogo.webp') }}" alt="Logo" class="logo">
        </div>

        <h1>Application Denied</h1>

        <div class="content">
            <p>Dear {{ $student->user->first_name ?? '' }} {{ $student->user->last_name ?? '' }},</p>

            <p>After careful consideration of your application and all supporting materials, we regret to inform you
                that we are unable to offer you admission at this time.</p>

            <p>Please understand that this decision does not reflect negatively on your abilities or potential. We
                receive many more qualified applicants than we can accommodate, which makes our selection process highly
                competitive.</p>

            <p>Our admissions office is available to provide general feedback on your application if you would find that
                helpful.</p>


            <p>We and wish you the very best in your future
                academic endeavors.</p>

            <p>If you have any questions about this decision or would like to discuss your options, please feel free to
                contact our admissions office.</p>
        </div>

        <p>Best regards,<br>Admissions Office<br>{{ config('app.name') }}</p>
    </div>

    <div class="footer">
        <p>This is an automated message. Please do not reply to this email.</p>
    </div>
</body>

</html>
