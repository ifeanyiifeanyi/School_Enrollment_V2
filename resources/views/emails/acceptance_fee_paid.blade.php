<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Congratulations on Your Acceptance Fee Payment - {{ config('app.name') }}</title>
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
            color: #660000;
            text-align: center;
        }

        .content {
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 5px;
        }

        .celebration {
            text-align: center;
            font-size: 1.2em;
            color: #660000;
            margin: 20px 0;
            font-weight: bold;
        }

        .next-steps {
            background-color: #e6f3ff;
            border: 1px solid #b3d9ff;
            padding: 15px;
            margin-top: 20px;
            border-radius: 5px;
        }

        .whatsapp-reminder {
            background-color: #e6ffe6;
            border: 1px solid #b3ffb3;
            padding: 15px;
            margin-top: 20px;
            border-radius: 5px;
        }

        .whatsapp-link {
            display: inline-block;
            background-color: #25D366;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 10px;
            font-weight: bold;
        }

        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 0.9em;
            color: #666;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.0/css/all.min.css"
        integrity="sha512-3PN6gfRNZEX4YFyz+sIyTF6pGlQiryJu9NlGhu9LrLMQ7eDjNgudQoFDK3WSNAayeIKc6B8WXXpo4a7HqxjKwg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <div class="header">
        <img src="{{ asset('logo1.png') }}" alt="Logo" class="logo">
    </div>

    <div class="content">
        <h1>CONGRATULATIONS ON YOUR ACCEPTANCE FEE PAYMENT!</h1>

        <div class="celebration">
            <i class="fas fa-graduation-cap"></i> You are now officially part of our university family! <i
                class="fas fa-graduation-cap"></i>
        </div>

        <p>Dear {{ $user->name }},</p>

        <p>We are delighted to confirm that we have received your acceptance fee payment. This important step confirms
            your commitment to joining our academic community, and we couldn't be more thrilled to welcome you!</p>

        <p>Your journey with us has officially begun, and we are excited about the bright future that awaits you at our
            institution. We are committed to providing you with an enriching educational experience that will help you
            achieve your academic and personal goals.</p>

        <div class="whatsapp-reminder">
            <h2><i class="fab fa-whatsapp"></i> Stay Connected!</h2>
            <p>If you haven't already done so, please join our official WhatsApp group for new students. This group is
                essential for receiving important updates about registration, orientation, accommodation, and other
                critical information.</p>

            <p style="text-align: center;">
                <a href="https://chat.whatsapp.com/BkL4HVYHunW2weT8SvZdWd" class="whatsapp-link" target="_blank">
                    <i class="fab fa-whatsapp"></i> Join WhatsApp Group Now
                </a>
            </p>

            <p><strong>Note:</strong> All important announcements and next steps will be shared in this group, so
                joining is crucial to ensure you don't miss any vital information.</p>
        </div>


        <p>If you have any questions or need assistance, please don't hesitate to contact our Student Support Team at
            08136768149 or reply to this email.</p>

        <p class="celebration">Congratulations once again on this significant milestone!</p>

        <p>We look forward to meeting you and embarking on this exciting academic journey together.</p>

        <p>Warm regards,<br>
            Admissions Office<br>
            {{ config('app.name') }}</p>
    </div>

    <div class="footer">
        <p>This email was sent to {{ $user->email }}. If you have any questions, please contact our Admissions Office.
        </p>
        <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.0/js/all.min.js"
        integrity="sha512-ISfdo0dGmoT6xQiYhsCuBXNy982/TMgk9WnSeFiLoBVffcwXCWMyfYtmobfJuBvSQZVpjPvEJtGEPdTH9XKpvw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>

</html>
