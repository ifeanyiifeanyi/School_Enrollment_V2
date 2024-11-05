<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Congratulations on Your Admission to COLLEGE OF NURSING SCIENCES, ST CHARLES BORROMEO SPECIALIST HOSPITAL, ONITSHA.</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .logo {
            max-width: 200px;
            height: auto;
        }
        h1 {
            color: #003366;
            text-align: center;
        }
        .content {
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 5px;
        }
        .next-steps {
            background-color: #e6f3ff;
            border: 1px solid #b3d9ff;
            padding: 15px;
            margin-top: 20px;
            border-radius: 5px;
        }
        .next-steps h2 {
            color: #003366;
            margin-top: 0;
        }
        .whatsapp-link {
            display: inline-block;
            background-color: #25D366;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 10px;
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
    <div class="header">
        <img src="{{ asset('nursinglogo.webp') }}" alt="Logo" class="logo">
    </div>

    <div class="content">
        <h1>CONGRATULATIONS ON YOUR ADMISSION TO OUR COLLEGE</h1>

        <p>Dear {{ $user->name }},</p>

        <p>We are thrilled to inform you that your acceptance of our admission offer has been confirmed. We extend our warmest congratulations and look forward to welcoming you as part of our incoming class.</p>

        <p>We are committed to providing an environment that nurtures academic excellence and personal growth. Your decision to join us marks the beginning of an exciting journey, and we are here to support you every step of the way.</p>

        <div class="next-steps">
            <h2>Next Steps:</h2>
            <p>To ensure a smooth transition into university life, please take note of the following important details:</p>

            <ol>
                <li><strong>Online Registration:</strong><br>
                Online registration for newly admitted students will commence on 30th September 2024. Detailed guidelines on how to complete the registration process will be shared with you via our official platforms.</li>

                <li><strong>WhatsApp Group for Real-Time Updates:</strong><br>
                To keep you informed and updated on the registration process and other important matters, we have created a dedicated WhatsApp group for all admitted students. You can join the group by clicking the link below:</li>
            </ol>

            <a href="" class="whatsapp-link" target="_blank">Join WhatsApp Group</a>

            <p>This group will be an essential resource where you will receive real-time updates and further instructions regarding registration, accommodation, and orientation programs.</p>

            <li><strong>Required Documents for Registration:</strong><br>
            Please ensure that you have all necessary documents ready for the online registration. A detailed list of required documents will be provided in the WhatsApp group.</li>
        </div>

        <p>If you have any questions or require further assistance, feel free to contact our Admissions Office or call 08136768149. We are here to assist you.</p>

        <p>Once again, congratulations on your admission, and we are excited to see you soon!</p>

        {{-- <p>Sincerely,<br>
        Rev. Fr. Dr. Emmanuel Emenu<br>
        Registrar<br>
        </p> --}}
    </div>

    <div class="footer">
        <p>This email was sent to {{ $user->email }}. If you have any questions, please contact our Admissions Office.</p>
    </div>
</body>
</html>
