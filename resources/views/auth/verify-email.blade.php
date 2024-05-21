@extends('layouts.guest')

@section('title', 'Verification Email')
@section('css')

@endsection

@section('guest')
<section class="section">
    <div class="container mt-5">
        <div class="row mt-5">
            <div class="col-md-5 col-lg-6 col-sm-8 col-xs-8 mx-auto">
                <div class="card card-primary shadow">
                    <div class="card-header">
                        <h4>Thanks for signing up!</h4>
                    </div>

                    <div class="card-body">
                        <p class="text-muted text-success">
                            Before getting started, could you verify your email address by clicking on the link we
                            just emailed to you? If you didn't receive the email, we will gladly send you another.
                        </p>

                        @if (session('status') == 'verification-link-sent')
                        <div class="mb-4 text-sm font-medium" style="color: rgb(22 163 74 / 1);">
                            A new verification link has been sent to the email address you provided during registration.
                        </div>
                        @endif

                        <form method="POST" action="{{ route('verification.send') }}">
                            @csrf
                            <div>
                                <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                                    {{ __('Resend Verification Email') }}
                                </button>
                            </div>
                        </form>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <button type="submit" class="btn btn-danger btn-lg btn-block mt-5">
                                {{ __('Log Out') }}
                            </button>
                        </form>

                    </div>
@include('layouts.footer')
                </div>
            </div>
        </div>
    </div>
</section>


@endsection


@section('js')

@endsection