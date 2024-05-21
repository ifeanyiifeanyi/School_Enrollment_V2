<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Not Found</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
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
</head>

<body>
    <div class="user-not-found-container">
        <div class="user-icon animate__animated animate__shakeX">
            <img src="{{ asset('user.png') }}" alt="User Icon">
            <div class="lightning">
                <img src="{{ asset('lighting.png') }}" alt="Lightning Icon">
            </div>
        </div>
        <h1 class="animate__animated animate__bounceIn">User Not Found</h1>
        <p class="animate__animated animate__fadeIn">The requested user does not exist.</p>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.user-icon').addClass('animate__animated animate__shakeX');
            $('.lightning').addClass('animate__animated animate__shakeX');
        });
    </script>
</body>

</html>