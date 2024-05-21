@extends('admin.layouts.adminLayout')

@section('title', 'Set Password')

@section('css')

@endsection

@section('admin')

<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>@yield('title')</h1>
    </div>

    <div class="section-body">

      <div class="row">

        <div class="col-12 col-md-6 col-lg-6 mx-auto">
          <div class="card">
            <form method="POST" action="{{ route('admin.profile.updatePassword') }}">
              @method('patch')
              @csrf
              <div class="card-body">
                <div class="form-group">
                  <label>Current Password</label>
                  <input type="password" name="current_password"
                    class="form-control @error('current_password') is-invalid @enderror" >
                  @error('current_password')
                  <div class="text-danger">
                    {{ $message }}
                  </div>
                  @enderror
                </div>
                <div class="form-group">
                  <label>New Password</label>
                  <input type="password" name="password"
                    class="form-control @error('password') is-invalid @enderror" >
                    @error('password')
                    <div class="text-danger">
                      {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                  <label>Confirm New Password</label>
                  <input type="password" name="password_confirmation" class="form-control">
                </div>
              </div>
              <div class="card-footer text-right">
                <button class="btn btn-primary">Submit</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
@endsection



@section('js')

@endsection