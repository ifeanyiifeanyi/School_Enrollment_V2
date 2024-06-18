<!DOCTYPE html>
<html>

<head>
    <title>Registration Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            line-height: 1.5;
            color: #333333;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #cccccc;
            border-radius: 5px;
        }

        .button {
            display: inline-block;
            background-color: #007bff;
            color: #ffffff;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <div class="container">
        <p style="text-align: center">
            <img src="{{ asset('logo1.png') }}" width="150" height="150" alt="">
        </p>
        <h1>Registration Confirmation</h1>
        <p>Hello, {{ $user->first_name }} {{ $user->last_name }},</p>
        <p>Thank you for registering with us. Your application has been received, and we're excited to have you on
            board.</p>

        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <th style="text-align: left; padding: 8px; background-color: #f2f2f2; border: 1px solid #dddddd;">
                    Application Details:</th>
                <td style="padding: 8px; border: 1px solid #dddddd;">
                    <p>Department: {{ $application->department->name }}</p>
                    <p>Application ID: <code>{{ $user->student->application_unique_number }}</code></p>
                </td>
            </tr>
        </table>
        @if ($examDetails)
        <h2>Exam Details:</h2>
        <p>Exam Venue: {{ $examDetails->venue }}</p>
        <p>Exam Subjects:</p>
        <ul>
            @foreach (json_decode($examDetails->exam_subject) as $subject)
            <li>{{ $subject }}</li>
            @endforeach
        </ul>
        <p>Exam Date and Time: {{ $examDetails->date_time }}</p>
        @endif


        <p>Please proceed with the payment to finalize your registration:</p>
        {{-- <p><a href="{{ route('payment.view') }}" class="button">Proceed to Payment</a></p> --}}

        <p>Thanks,<br>{{ config('app.name') }}</p>
    </div>
</body>

</html>
