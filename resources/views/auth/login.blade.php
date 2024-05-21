@extends('layouts.guest')

@section('title', 'Sign in')
@section('css')

@endsection

@section('guest')
<section class="section">
    <div class="container mt-5">
        <div class="row">
            <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
               @include('layouts.logo')
                <div class="card card-danger">
                    <div class="card-header">
                        <h4>Login</h4>
                    </div>
                    @if(session('status'))
                    <div class="m-3 alert alert-danger">
                        <ul>
                            @foreach(session('status') as $error)
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
                                <input id="password" type="password" class="form-control" name="password" tabindex="2"
                                    >
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
                                <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                                    Login
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
                <div class="mt-5 text-muted text-center">
                    Don't have an account? <a href="{{ route('register') }}">Create One</a>
                </div>
                @include('layouts.footer')
            </div>
        </div>
    </div>
</section>
@endsection


@section('js')

@endsection