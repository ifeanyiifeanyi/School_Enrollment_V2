<!DOCTYPE html>
<html>
<head>
    <title>examination Notification</title>
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
        <p style="text-align: center">
            <img src="{{ asset('logo1.png') }}" width="150" height="150" alt="logo">
        </p>
        <hr>

        <h3 class="text-center mb-4">Exams Notification</h3>
        <p>Department: <span style="color: rgb(197, 10, 10)">{{ $department}}</span>,</p>
        <p>Date: {{ $exam_date }}</p>
        <p class="text-muted">Venue: {{ $venue }}</p>
        <p class="text-muted"> {!! $requirements !!}</p>
        <hr>
        <p class="lead">Best regards,<br>{{ config('app.name') }}</p>
    </div>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
