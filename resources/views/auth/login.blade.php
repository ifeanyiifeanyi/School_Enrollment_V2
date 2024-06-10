@extends('layouts.guest')

@section('title', 'Shanahan University Admission Portal')

@section('css')
    <style>
        .instruction-section {
            background-color: #f8f9fa;
            padding: 2rem;
            border-radius: 0.5rem;
        }

        .instruction-section h2 {
            color: #961f31;
            font-weight: bold;
        }

        .instruction-section ol {
            font-size: 1.1rem;
        }
    </style>
@endsection

@section('guest')
    <section class="section">
        <div class="container mt-5">
            <div class="row">
                <div class="col-lg-6">
                    <div class="instruction-section">
                        <h2 class="mb-4">Welcome to Shanahan University Admission Portal</h2>
                        <img src="{{ asset('st001.webp') }}" alt="University Image" class="mb-4 img-fluid">
                        <p>To apply for admission at Shanahan University, please follow these steps:</p>
                        <ol>
                            <li>If you already have an account, log in using the form on the right.</li>
                            <li>If you don't have an account yet, click the "Create One" link below the form to register.
                            </li>
                            <li>After logging in or creating an account, you will be able to access the admission
                                application form.</li>
                            <li>Fill out the admission application form completely and accurately.</li>
                            <li>Submit the application along with the required documents and fees.</li>
                        </ol>
                        <p>Please note that incomplete or inaccurate applications may be rejected. If you have any questions
                            or need assistance, please contact our admissions office.</p>
                    </div>
                </div>
                <div class="col-lg-6">
                    @include('layouts.logo')
                    <div class="card" style="border-top: 4px solid #961f31;">
                        <div class="card-header" style="background-color: #961f31; color: #fff;">
                            <h4>Login</h4>
                        </div>
                        @if (session('status'))
                            <div class="m-3 alert alert-danger">
                                <ul>
                                    @foreach (session('status') as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="card-body">
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="form-group">
                                    <label for="email">Email or Username</label>
                                    <input id="login" type="text" class="form-control" name="login" tabindex="1"
                                        autofocus value="{{ old('login') }}">
                                    @error('login')
                                        <div class="text-danger">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <div class="d-block">
                                        <label for="password" class="control-label">Password</label>
                                        @if (Route::has('password.request'))
                                            <div class="float-right">
                                                <a href="{{ route('password.request') }}" class="text-small">
                                                    Forgot Password?
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                    <input id="password" type="password" class="form-control" name="password"
                                        tabindex="2">
                                    @error('password')
                                        <div class="text-danger">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" name="remember" class="custom-control-input" tabindex="3"
                                            id="remember-me">
                                        <label class="custom-control-label" for="remember-me">Remember Me</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-danger btn-lg btn-block" style="background: #ef2e4b" tabindex="4">
                                        Login
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="mt-5 text-center text-muted">
                        Don't have an account? <a href="{{ route('register') }}">Register Now</a>
                    </div>
                    @include('layouts.footer')
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
@endsection
