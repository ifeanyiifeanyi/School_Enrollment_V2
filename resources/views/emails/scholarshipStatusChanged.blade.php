<!DOCTYPE html>
<html>
<head>
    <title>Scholarship Application Status Updated</title>
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
            <img src="{{ asset('logo1.png') }}" width="150" height="150" alt="">
        </p>
        <hr>
        <h1 class="mb-4 text-center">Scholarship Application Status Updated</h1>
        <p>Dear {{ Str::title($application->user->full_name) }},</p>
        <p>The status of your application for the <strong>{{ Str::title($application->scholarship->name) }}</strong> scholarship has been updated to <strong>{{ Str::upper($application->status) }}</strong>.</p>
        <p>Thank you for applying.</p>
        <p class="lead">Best regards,<br>{{ config('app.name') }}</p>
    </div>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
