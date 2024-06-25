<!DOCTYPE html>
<html>
<head>
    <title>Hello {{ Str::title($name) }}</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            line-height: 1.5;
            color: #333333;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #ffffff;
            border: 1px solid #cccccc;
            border-radius: 5px;
        }

        h4 {
            font-size: 20px;
            /* color: #007bff; */
        }

        p {
            margin-bottom: 10px;
        }

        .button {
            display: inline-block;
            color: #ffffff;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <div class="container shadow mb-3">
        <p style="text-align: center">
            <img src="{{ asset('logo1.png') }}" width="150" height="150" alt="">
        </p>
        <hr>
        <h4 class="mt-3 mb-3 heading">{{ Str::title($subject) }}</h4>
        <p class="text-muted">Hello <span class="text-primary">{{ Str::title($name) }}</span>,</p>
        <p class="text-muted ">{!! $content !!}</p>
        <hr>
        <p class="lead">Best regards,<br>{{ config('app.name') }}</p>
    </div>


</body>
</html>
