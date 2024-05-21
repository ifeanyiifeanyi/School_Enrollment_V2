@extends('admin.layouts.adminLayout')

@section('title', 'Edit Admin Manager')

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
                <div class="col-md-7 mx-auto">
                    <div class="card text-left">
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.manage.update', $admin->nameSlug) }}" class="form" enctype="multipart/form-data">
                                @csrf
                                @method('PATCH')
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="first_name">First Name</label>
                                            <input type="text" name="first_name" id="first_name"
                                                class="form-control @error('first_name') border-danger @enderror"
                                                value="{{ old('first_name', $admin->first_name) }}">
                                            @error('first_name')
                                            <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="last_name">Last Name</label>
                                            <input type="text" name="last_name" id="last_name"
                                                class="form-control @error('last_name') border-danger @enderror"
                                                value="{{ old('last_name', $admin->last_name) }}">
                                            @error('last_name')
                                            <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="other_names">Other Names</label>
                                            <input type="text" name="other_names" id="other_names"
                                                class="form-control @error('other_names') border-danger @enderror"
                                                value="{{ old('other_names', $admin->other_names) }}">
                                            @error('other_names')
                                            <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="email" name="email" id="email"
                                                class="form-control @error('email') border-danger @enderror"
                                                value="{{ old('email', $admin->email) }}">
                                            @error('email')
                                            <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="photo">Profile Image</label>
                                            <input type="file" capture accept="images/*" name="photo" id="photo"
                                                class="form-control @error('photo') border-danger @enderror"
                                                value="{{ old('photo') }}">
                                            @error('photo')
                                            <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">
                                                <img src="{{ empty($admin->admin->photo) ? 'not' : asset($admin->admin->photo) }}" alt="" class="img-fluid">
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="address">Address</label>
                                            <input type="text" name="address" id="address" class="form-control @error('address') border-danger @enderror" value="{{ old('address', $admin->admin->address) }}">
                                            @error('address')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="phone">Phone</label>
                                            <input type="tel" name="phone" id="phone" class="form-control @error('phone') border-danger @enderror" value="{{ old('phone', $admin->admin->phone) }}">
                                            @error('phone')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                <input type="submit" value="Update" class="btn btn-primary">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection



@section('js')


@endsection