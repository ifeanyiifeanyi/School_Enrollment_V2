<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admission Status Updated</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="text-center mb-4">
            <img src="{{ asset('images/university_logo.png') }}" alt="University Logo" class="img-fluid" style="max-height: 80px;">
        </div>
        <h1 class="text-center mb-4">Admission Status Updated</h1>
        <p>Dear {{ $student->user->first_name ?? '' }} {{ $student->user->last_name ?? ''}},</p>
        <p>Your admission status  has been updated to <strong>{{ $application->admission_status }}</strong>.</p>
        <p>Please check your student portal for more details and further instructions.</p>
        <p>If you have any questions or concerns, please feel free to contact our admissions office.</p>
        <p class="lead">Best regards,<br>{{ config('app.name') }}</p>
    </div>
</body>
</html>
