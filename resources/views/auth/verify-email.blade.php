@extends('layouts.guest')

@section('title', 'Verification Email')
@section('css')

@endsection

@section('guest')
<section class="section">
    <div class="container mt-5">
        <div class="mt-5 row">
            <div class="mx-auto col-md-5 col-lg-6 col-sm-8 col-xs-8">
                <div class="shadow card card-danger">
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
                                <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4" style="background: #ef2e4b">
                                    {{ __('Resend Verification Email') }}
                                </button>
                            </div>
                        </form>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <button type="submit" class="mt-5 btn btn-danger btn-lg btn-block" style="background: #961f31" >
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
