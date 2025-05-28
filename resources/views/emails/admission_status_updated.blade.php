<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admission Status Updated - {{ config('app.name') }}</title>
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
            background-color: #e6f3ff;
            border: 1px solid #b3d9ff;
            padding: 15px;
            margin-top: 20px;
            border-radius: 5px;
        }

        .jamb-notice {
            background-color: #ffe6e6;
            border: 1px solid #ffb3b3;
            padding: 15px;
            margin-top: 20px;
            border-radius: 5px;
        }

        .whatsapp-link {
            display: inline-block;
            background-color: #d3257c;
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
        strong, h1{
            color: #660000
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.0/css/all.min.css" integrity="sha512-3PN6gfRNZEX4YFyz+sIyTF6pGlQiryJu9NlGhu9LrLMQ7eDjNgudQoFDK3WSNAayeIKc6B8WXXpo4a7HqxjKwg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <div class="container">
        <div class="header">
            <img src="{{ asset('logo1.png') }}" alt="Logo" class="logo">
        </div>

        <h1>Admission Status Updated</h1>

        <div class="content">
            <p>Dear {{ $student->user->first_name ?? '' }} {{ $student->user->last_name ?? '' }},</p>

            <p>We are pleased to inform you that your admission status has been updated to
                <strong>{{ $application->admission_status }}</strong>.</p>

            <p>Congratulations! We are thrilled to welcome you to our academic
                community.</p>

            <div class="jamb-notice">
                <h3><i class="fas fa-exclamation-triangle"></i> IMPORTANT: JAMB CAPS Acceptance Required</h3>
                <p>You <strong>MUST</strong> accept your admission on the JAMB Central Admission Processing System (CAPS) portal to validate your admission. Please:</p>
                <ol>
                    <li>Log in to the JAMB CAPS portal at <a href="https://portal.jamb.gov.ng" target="_blank">https://portal.jamb.gov.ng</a></li>
                    <li>Check your admission status</li>
                    <li>Click on the "Accept Admission" button</li>
                    <li>Print your admission letter after acceptance</li>
                </ol>
                <p><strong>Note:</strong> Failure to accept your admission on JAMB CAPS will render your admission invalid, regardless of payment of acceptance fee.</p>
            </div>

            <div class="important-notice">
                <h3>Next Steps:</h3>
                <ol>
                    <li><strong>Pay Acceptance Fee:</strong> To secure your place, you need to pay the acceptance fee
                        through your student portal. This is a crucial step in confirming your enrollment.
                        <a href="https://apply.shanahanuni.edu.ng" target="_blank" style="color: #d3257c; font-weight: bold;">Click here to pay your acceptance fee</a>
                    </li>
                    <li><strong>Join Our WhatsApp Group:</strong> Stay connected and receive important updates by
                        joining our official WhatsApp group for new students.</li>
                </ol>

                <a href="https://chat.whatsapp.com/BkL4HVYHunW2weT8SvZdWd" class="whatsapp-link" target="_blank">Join
                    <i class="fab fa-whatsapp"></i> WhatsApp Group</a>
            </div>

            <p>Please check your student portal for more details, including the exact amount of the acceptance fee and
                payment instructions.</p>

            <p>If you have any questions or need assistance, please don't hesitate to contact our admissions office.</p>
        </div>

        <p>We look forward to seeing you on campus!</p>

        <p>Best regards,<br>Admissions Office<br>{{ config('app.name') }}</p>
    </div>

    <div class="footer">
        <p>This is an automated message. Please do not reply to this email.</p>
    </div>
    <div class="footer">
        <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.0/js/all.min.js" integrity="sha512-ISfdo0dGmoT6xQiYhsCuBXNy982/TMgk9WnSeFiLoBVffcwXCWMyfYtmobfJuBvSQZVpjPvEJtGEPdTH9XKpvw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>

</html>
