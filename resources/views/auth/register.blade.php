@extends('layouts.guest')


@section('title', 'Sign Up')

@section('css')

@endsection

@section('guest')
<section class="section">
    <div class="container mt-5">
        <div class="row">
            <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-8 offset-lg-2 col-xl-8 offset-xl-2">
                @include('layouts.logo')

                <div class="card card-danger shadow">
                    <div class="card-header">
                        <h4>Sign up here</h4>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="row">
                                <div class="form-group col-6">
                                    <label for="first_name">First Name</label>
                                    <input id="first_name" type="text" name="first_name" class="form-control @error('first_name') border-danger @enderror" autofocus value="{{ old('first_name') }}">
                                    @error('first_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-6">
                                    <label for="last_name">Last Name</label>
                                    <input id="last_name" type="text" class="form-control @error('last_name') border-danger @enderror" name="last_name" value="{{ old('last_name') }}">
                                    @error('last_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-6">
                                    <label for="other_names" class="d-block">Other Names</label>
                                    <input id="other_names" type="text" class="form-control @error('other_names') border-danger @enderror" name="other_names" value="{{ old('other_names') }}">
                                    @error('other_names')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    
                                </div>
                                <div class="form-group col-6">
                                    <label for="phone" class="d-block">Phone Number</label>
                                    <input id="phone" type="tel" class="form-control @error('last_name') border-danger @enderror" name="phone" value="{{ old('phone') }}">
                                    @error('phone')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-group">
                                <label for="email">Email</label>
                                <input id="email" type="email" class="form-control @error('email') border-danger @enderror"  name="email" value="{{ old('email') }}">
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="form-group col-6">
                                    <label for="password" class="d-block">Password</label>
                                    <input id="password" type="password" class="form-control pwstrength @error('password') border-danger @enderror"
                                        data-indicator="pwindicator" name="password">
                                    <div id="pwindicator" class="pwindicator">
                                        <div class="bar"></div>
                                        <div class="label"></div>
                                    </div>
                                    @error('password')
                                        <span class="mt-3 text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-6">
                                    <label for="password_confirmation" class="d-block">Password Confirmation</label>
                                    <input id="password_confirmation" type="password" class="form-control" name="password_confirmation">
                                </div>
                            </div>


                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="agree" class="custom-control-input" id="agree">
                                    <label class="custom-control-label" for="agree">I agree with the terms and
                                        conditions</label>
                                </div>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-lg btn-block">
                                    Register
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