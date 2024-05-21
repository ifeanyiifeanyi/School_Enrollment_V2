@extends('admin.layouts.adminLayout')

@section('title', 'Profile')

@section('css')

@endsection

@section('admin')

<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>@yield('title')</h1>
    </div>
    <div class="section-body">
      <h2 class="section-title">Hi, {{ Str::title($adminDetails->first_name) }}</h2>
      <p class="section-lead">
        Change information about yourself on this page.
      </p>

      <div class="row mt-sm-4">
        <div class="col-12 col-md-12 col-lg-5">
          <div class="card profile-widget">
            <div class="profile-widget-header">
              <img alt="image" src="{{ empty($adminDetails->admin->photo) ? asset('admin/assets/img/avatar/avatar-1.png') :  asset($adminDetails->admin->photo) }}" class="rounded-circle profile-widget-picture">

            </div>
            <div class="profile-widget-description">
              <div class="profile-widget-name">
                {{ Str::title($adminDetails->last_name) }} {{ Str::title($adminDetails->first_name) }}
                <div class="text-muted d-inline font-weight-normal">
                  <div class="slash"></div> {{ Str::lower($adminDetails->email) }}
                </div>
              </div>
              <div class="profile-widget-name">
                <b>Phone Number</b>
                <div class="text-muted d-inline font-weight-normal">
                   {{ $adminDetails->admin->phone ?? 'N/A' }}
                </div>
              </div>
                <p>
                  <b>Address</b>
                  <div class="text-muted d-inline font-weight-normal">
                    {{ $adminDetails->admin->address?? 'N/A' }}
                  </div>
                </p>
            </div>
          </div>
        </div>
        <div class="col-12 col-md-12 col-lg-7">
          <div class="card">
            <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data">
              @csrf
              <div class="card-header">
                <h4>Edit Profile</h4>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="form-group col-md-6 col-12">
                    <label>First Name</label>
                    <input type="text" name="first_name" class="form-control" value="{{ old('first_name', $adminDetails->first_name) }}" >
                    @error('first_name')
                    <div class="text-danger">
                      {{ $message }}
                    </div>
                    @enderror
                  </div>
                  <div class="form-group col-md-6 col-12">
                    <label>Last Name</label>
                    <input type="text" name="last_name" class="form-control" value="{{ old('last_name', $adminDetails->last_name) }}" >
                    @error('last_name')
                    <div class="text-danger">
                      {{ $message }}
                    </div>
                    @enderror
                  </div>
                </div>
                <div class="row">
                  <div class="form-group col-md-12 col-12">
                    <label>Other Names</label>
                    <input type="text" name="other_names" class="form-control" value="{{ old('other_names', $adminDetails->other_names) }}" >
                    @error('other_names')
                    <div class="text-danger">
                      {{ $message }}
                    </div>
                    @enderror
                  </div>
                </div>
                <div class="row">
                  <div class="form-group col-md-7 col-12">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $adminDetails->email) }}" >
                    @error('email')
                    <div class="text-danger">
                      {{ $message }}
                    </div>
                    @enderror
                  </div>
                  <div class="form-group col-md-5 col-12">
                    <label>Phone</label>
                    <input type="tel" class="form-control" name="phone" value="{{ old('phone', $adminDetails->admin->phone) }}">
                    @error('phone')
                    <div class="text-danger">
                      {{ $message }}
                    </div>
                    @enderror
                  </div>
                </div>

                <div class="row">
                  <div class="form-group col-md-7 col-12">
                    <label>Profile Photo</label>
                    <input type="file" onChange="changeImg(this)" capture accept="image/*" name="photo" class="form-control">
                    @error('photo')
                    <div class="text-danger">
                      {{ $message }}
                    </div>
                    @enderror
                  </div>
                  <div class="form-group col-md-5 col-12">
                    <img id="previewImage" src="{{ empty($adminDetails->admin->photo) ? asset('admin/assets/img/avatar/avatar-1.png') :  asset($adminDetails->admin->photo) }}" alt="" class="img-fluid img-thumbnail w-50">
                  </div>
                </div>
                <div class="row">
                  <div class="form-group col-12">
                    <label>Address</label>
                    <textarea name="address"
                      class="form-control summernote-simple">{{ $adminDetails->admin->address }}</textarea>
                      @error('address')
                    <div class="text-danger">
                      {{ $message }}
                    </div>
                    @enderror
                  </div>
                </div>
              </div>
              <div class="card-footer text-right">
                <button type="submit" class="btn btn-primary">Save Changes</button>
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
<script>
  function changeImg(input) {
      let preview = document.getElementById('previewImage');
      if (input.files && input.files[0]) {
          var reader = new FileReader();
          reader.onload = function (e) {
              preview.src = e.target.result;
          }
          reader.readAsDataURL(input.files[0]);
      }
  }
</script>
@endsection