<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Application Status Update</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f4f4f4;">
    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin: auto;">
        <tr>
            <td style="background: #f5adb1; padding: 10px 20px;">
                <h1 style="color: #1c0202; text-align: center;">Admission Application Update</h1>
                <p style="text-align: center">
                    <img src="{{ asset('logo.png') }}" width="150" height="150" alt="">
                </p>
            </td>
        </tr>
        <tr>
            <td style="background: #ffffff; padding: 20px;">
                <p style="color: #333333; font-size: 16px; line-height: 1.5; text-align: center;">
                    Hello <strong>{{ $userName }}</strong>,
                </p>
                <p style="color: #333333; font-size: 16px; line-height: 1.5; text-align: center;">
                    Thank you for completing the payment process. This confirms the successful processing of your admission application.
                </p>
                <p style="color: #333333; font-size: 16px; line-height: 1.5; text-align: center;">
                    <strong>Note:</strong> This does not imply that you have been granted admission. Please regularly check your dashboard to view your admission status.
                </p>
                <p style="color: #333333; font-size: 16px; line-height: 1.5; text-align: center;">
                    Application ID: <strong>{{ $applicationId }}</strong>
                </p>
                <p style="color: #333333; font-size: 16px; line-height: 1.5; text-align: center;">
                    Payment Status: <strong>{{ $paymentStatus }}</strong>
                </p>
            </td>
        </tr>
        <tr>
            <td style="padding: 20px; text-align: center;">
                <p style="color: #4444; font-size: 14px; line-height: 1.5;">
                    Best Regards,
                </p>
                <p style="color: #4444; font-size: 14px; line-height: 1.5;">
                    Your Admission Team
                </p>
            </td>
        </tr>
    </table>
</body>
</html>
