@extends('layouts.guest')

@section('title', 'Forgot Password')
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
                            <h4>Forgot Password</h4>
                        </div>
                        @if (session('status'))
                            <div class="text-sm text-info text-center px-2 py-2">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div class="card-body">
                            <p class="text-dark">Forgot your password? No problem. Just let us know your email address and we
                                will email you a password reset link that will allow you to choose a new one.</p>
                            <form method="POST" action="{{ route('password.email') }}">
                                @csrf
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input id="email" type="email" class="form-control" name="email" tabindex="1"
                                        autofocus value="{{ old('email') }}">
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn text-light text-bold btn-lg btn-block" tabindex="4"
                                        style="background: #961f31">
                                        Email Password Reset Link
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    @include('layouts.footer')
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')

@endsection
