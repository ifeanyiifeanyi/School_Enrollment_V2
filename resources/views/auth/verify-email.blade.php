@extends('layouts.guest')

@section('title', 'Verify Your Email')

@section('css')
<style>
    :root {
        --primary-color: #961f31;
        --secondary-color: #f8f9fa;
        --accent-color: #3498db;
        --text-color: #333;
        --card-background: #ffffff;
    }

    body {
        background-color: var(--secondary-color);
        color: var(--text-color);
        font-family: 'Poppins', sans-serif;
        overflow-x: hidden;
    }

    .verification-container {
        max-width: 450px;
        margin: 30px auto;
        position: relative;
    }

    .verification-card {
        background-color: var(--card-background);
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        padding: 2rem;
        position: relative;
        overflow: hidden;
        border: 1px solid #e0e0e0;
    }

    .logo-container {
        text-align: center;
        margin-bottom: 1.5rem;
    }

    .school-logo {
        max-width: 100px;
        max-height: 100px;
    }

    .card-title {
        color: #305544;
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 1rem;
        text-align: center;
    }

    .btn {
        border: none;
        border-radius: 25px;
        cursor: pointer;
        font-size: 0.9rem;
        font-weight: 600;
        padding: 0.75rem 1.5rem;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .btn-primary {
        background-color: var(--accent-color);
        color: white;
    }

    .btn-primary:hover {
        background-color: #305544;
        transform: translateY(-2px);
        box-shadow: 0 3px 10px #305544c5;
    }

    .btn-secondary {
        background-color: var(--secondary-color);
        color: var(--accent-color);
        border: 1px solid var(--accent-color);
    }

    .btn-secondary:hover {
        background-color: var(--accent-color);
        color: var(--secondary-color);
        transform: translateY(-2px);
        box-shadow: 0 3px 10px #305544bb;
    }

    .success-message {
        background-color: rgba(52, 152, 219, 0.1);
        border-left: 4px solid var(--accent-color);
        border-radius: 5px;
        color: var(--accent-color);
        margin-bottom: 1rem;
        padding: 0.75rem;
        font-size: 0.9rem;
    }

    .animated-background {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: -1;
        background: linear-gradient(-45deg, #f8f9fa, #e0e0e0, #f8f9fa, #d0d0d0);
        background-size: 400% 400%;
        animation: gradientBG 15s ease infinite;
    }

    @keyframes gradientBG {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }
</style>
@endsection

@section('guest')
<div class="animated-background"></div>
<div class="verification-container">
    <div class="verification-card">
        <div class="logo-container">
            <img src="{{ asset('nursinglogo.webp') }}" alt="School Logo" class="school-logo">
        </div>

        <h2 class="card-title">Verify Your Email</h2>

        <p style="text-align: center; margin-bottom: 1.5rem; color: var(--text-color); font-size: 0.9rem;">
            We've sent a verification link to your email.
            Click it to activate your account and get started!
        </p>

        @if (session('status') == 'verification-link-sent')
        <div class="success-message">
            <span>A new verification link has been sent to your email address.</span>
        </div>
        @endif

        <form method="POST" action="{{ route('verification.send') }}" class="mb-3">
            @csrf
            <button type="submit" class="btn btn-primary btn-block">
                Resend Verification Email
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-secondary btn-block">
                Log Out
            </button>
        </form>
    </div>
</div>

@include('layouts.footer')
@endsection

@section('js')
<script>
    // Add any necessary JavaScript here
</script>
@endsection
