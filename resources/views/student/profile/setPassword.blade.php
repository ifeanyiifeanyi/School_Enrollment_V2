@extends('student.layouts.studentLayout')

@section('title', "Update Account Password")
@section('css')

@endsection

@section('student')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-7 mx-auto">
                
                <!-- general form elements -->
                <div class="card card-primary">
                    <!-- form start -->
                    <form method="POST" action="{{ route('student.profile.updatePassword') }}">
                        @csrf
                        @method('patch')
                        <div class="card-body">


                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="current_password">Current Password</label>
                                        <input name="current_password" type="password" class="form-control"
                                            id="current_password" value="{{ old('current_password') }}"
                                            placeholder="Current Password">
                                        @error('current_password')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="password">New Password</label>
                                        <input name="password" type="password" class="form-control"
                                            id="password" placeholder="New Password">
                                        @error('password')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="password_confirmation">Confirm New password_confirmation</label>
                                        <input name="password_confirmation" type="password" class="form-control"
                                            id="password_confirmation" placeholder="New password_confirmation">
                                        @error('password')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-info">Update</button>
                        </div>
                    </form>
                </div>
                    
            </div>
        </div>
    </div>
    <!--/. container-fluid -->
</section>
@endsection


@section('js')

@endsection