@extends('errors::minimal')
@section('title', 'Payment Required')
@section('content')
    <style>
        body {
            background: linear-gradient(135deg, #4caf50, #388e3c);
            font-family: 'Roboto', sans-serif;
            color: #fff;
        }

        .error-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            text-align: center;
        }

        .error-icon {
            width: 150px;
            height: 150px;
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 30px;
            animation: pulse 2s infinite;
        }

        .error-icon img {
            max-width: 80px;
            max-height: 80px;
        }

        h1 {
            font-size: 48px;
            font-weight: bold;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        p {
            font-size: 20px;
            margin-bottom: 30px;
        }

        .btn {
            display: inline-block;
            background-color: #fff;
            color: #388e3c;
            text-decoration: none;
            padding: 12px 24px;
            border-radius: 4px;
            font-size: 16px;
            transition: background-color 0.3s ease, color 0.3s ease;
            animation: bounce 1s infinite;
        }

        .btn:hover {
            background-color: #388e3c;
            color: #fff;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }

            100% {
                transform: scale(1);
            }
        }

        @keyframes bounce {
            0% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }

            100% {
                transform: translateY(0);
            }
        }
    </style>
    <div class="error-container">
        <div class="error-icon">
            <img src="{{ asset('lighting.png') }}" alt="Payment Required Icon">
        </div>
        <h1>Payment Required</h1>
        <p>You need to make a payment to access this page.</p>
        <a href="{{ url('/') }}" class="btn">Make Payment</a>
    </div>
@endsection
