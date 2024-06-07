<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Default Title')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="shortcut icon" href="{{ asset('logo1.png') }}" type="image/x-icon">
    <style>
        body {
            background-color: #f8f8f8;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .user-not-found-container {
            text-align: center;
        }

        .user-icon {
            position: relative;
            display: inline-block;
        }

        .user-icon img {
            width: 150px;
            height: 150px;
        }

        .lightning {
            position: absolute;
            top: -38px;
            left: 70px;
            animation: shockAnimation 1s infinite;
        }

        .lightning img {
            width: 50px;
            height: 50px;
        }

        @keyframes shockAnimation {
            0% {
                transform: rotate(0deg);
            }

            25% {
                transform: rotate(10deg);
            }

            75% {
                transform: rotate(-10deg);
            }

            100% {
                transform: rotate(0deg);
            }
        }
    </style>
    @yield('styles')
</head>

<body>
    @yield('content')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.user-icon').addClass('animate__animated animate__shakeX');
            $('.lightning').addClass('animate__animated animate__shakeX');
        });
    </script>
    @yield('scripts')
</body>

</html>
