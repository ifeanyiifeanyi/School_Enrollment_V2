@extends('layouts.guest')

@section('title', 'Sign Up')

@section('css')
    <style>
        .registration-card {
            border: none;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
        }

        .registration-card .card-header {
            background-color: #9d2236;
            color: #fff;
            text-align: center;
            padding: 1.5rem;
            font-size: 1.2rem;
            font-weight: bold;
        }

        .registration-card .card-body {
            padding: 2rem;
        }

        .registration-card .form-control {
            border-radius: 5px;
        }

        .registration-card .btn-primary {
            background-color: #9d2236;
            border-color: #db1144;
            border-radius: 5px;
            font-weight: bold;
        }

        .registration-card .btn-primary:hover {
            background-color: #dbe0d7;
            border-color: #dbe0d7;
        }

        .registration-card .writeup {
            text-align: justify;
            margin-bottom: 2rem;
        }

        .registration-card .writeup h5 {
            color: #70092b;
            font-weight: bold;
        }

        .registration-card .writeup p {
            color: #444;
        }
    </style>
@endsection

@section('guest')
    <section class="section">
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    @include('layouts.logo')

                    <div class="registration-card card">
                        <div class="card-header">
                            <h4>Sign Up</h4>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="writeup">
                                        <h5>Welcome, Future Student!</h5>
                                        <p>We're excited to have you join our vibrant community.</p>
                                    </div>

                                    <div class="writeup">
                                        <h5>Unlock Your Potential</h5>
                                        <p>Our institution offers a unique blend of academic excellence, real-world
                                            experiences, and a supportive community.
                                            By signing up, you are beginning a journey that will shape your future, open
                                            doors to new opportunities, and equip you with the skills needed to thrive in
                                            today’s world.</p>
                                    </div>

                                    <div class="writeup">
                                        <h5>A Dedicated Community</h5>
                                        <p>Join a diverse and inspiring community where students, faculty, and staff work
                                            together to bring out the best in each individual.
                                            Our campus is a place where your ideas are valued, your voice is heard, and your
                                            goals are supported. We look forward to seeing the unique contributions you will
                                            bring.</p>
                                    </div>



                                    <div class="writeup">
                                        <h5>Stay Connected and Informed</h5>
                                        <p>Once registered, you’ll gain access to our student portal where you can keep up
                                            with important updates, events, and announcements. Stay connected with your
                                            peers, professors,
                                            and the university community as you progress through your academic journey.</p>
                                    </div>

                                </div>

                                <div class="col-lg-6">
                                    <form method="POST" action="{{ route('register') }}">
                                        @csrf
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label for="first_name">First Name</label>
                                                <input id="first_name" type="text" name="first_name"
                                                    class="form-control @error('first_name') border-danger @enderror"
                                                    autofocus value="{{ old('first_name') }}" required>
                                                @error('first_name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="last_name">Surname</label>
                                                <input id="last_name" type="text"
                                                    class="form-control @error('last_name') border-danger @enderror"
                                                    name="last_name" value="{{ old('last_name') }}" required>
                                                @error('last_name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label for="other_names" class="d-block">Other Names</label>
                                                <input id="other_names" type="text"
                                                    class="form-control @error('other_names') border-danger @enderror"
                                                    name="other_names" value="{{ old('other_names') }}" required>
                                                @error('other_names')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="phone" class="d-block">Phone Number</label>
                                                <input id="phone" type="tel"
                                                    class="form-control @error('last_name') border-danger @enderror"
                                                    name="phone" value="{{ old('phone') }}" required>
                                                @error('phone')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input id="email" type="email"
                                                class="form-control @error('email') border-danger @enderror" name="email"
                                                value="{{ old('email') }}" required>
                                            @error('email')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label for="password" class="d-block">Password</label>
                                                <input id="password" type="password"
                                                    class="form-control pwstrength @error('password') border-danger @enderror"
                                                    data-indicator="pwindicator" name="password" required>
                                                <div id="pwindicator" class="pwindicator">
                                                    <div class="bar"></div>
                                                    <div class="label"></div>
                                                </div>
                                                @error('password')
                                                    <span class="mt-3 text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="password_confirmation" class="d-block">Password
                                                    Confirmation</label>
                                                <input id="password_confirmation" type="password" class="form-control"
                                                    name="password_confirmation" required>
                                            </div>
                                        </div>

                                        <div class="form-group">

                                            {{-- <strong>ReCaptcha:</strong> --}}

                                            <div class="g-recaptcha" data-sitekey="{{ env('GOOGLE_RECAPTCHA_KEY') }}">
                                            </div>

                                            @if ($errors->has('g-recaptcha-response'))
                                                <span
                                                    class="text-danger">{{ $errors->first('g-recaptcha-response') }}</span>
                                            @endif

                                        </div>

                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox">
                                                <input required type="checkbox" name="agree" class="custom-control-input"
                                                    id="agree">
                                                <label class="custom-control-label" for="agree">I agree with the terms
                                                    and conditions</label>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <button type="submit" style="color: #fff;font-size:18px"
                                                class="btn btn-primary btn-lg btn-block">
                                                Register
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
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
