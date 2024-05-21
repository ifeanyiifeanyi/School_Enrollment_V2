@extends('layouts.guest')

@section('title', 'Confirm Password')
@section('css')

@endsection

@section('guest')

<section class="section">
    <div class="container mt-5">
        <div class="row">
            <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
               @include('layouts.logo')

                <div class="card card-primary">
                    <div class="card-header">
                        <h4>Confirm Password</h4>
                    </div>

                    <div class="card-body">
                        <p class="text-muted">This is a secure area of the application. Please confirm your password before continuing.</p>

                        <form method="POST" action="{{ route('password.confirm') }}">
                            @csrf

                            <div class="form-group">
                                <label for="password">Enter Password</label>
                                <input id="password" type="password" class="form-control pwstrength"
                                    data-indicator="pwindicator" name="password" tabindex="2" required>
                                <div id="pwindicator" class="pwindicator">
                                    <div class="bar"></div>
                                    <div class="label"></div>
                                </div>
                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                                    Confirm
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