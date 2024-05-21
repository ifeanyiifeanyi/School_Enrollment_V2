@extends('admin.layouts.adminLayout')

@section('title', 'Edit Basic Student Details')

@section('css')

@endsection

@section('admin')

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>@yield('title')</h1>
        </div>

        <div class="section-body">
            <form method="POST" action="{{ route('admin.update.student', $user->nameSlug) }}"
                enctype="multipart/form-data">
                @csrf
                @method('patch')
                <div class="row">

                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <p><b class="text-danger">NOTE!!</b> The purpose of this page is to update student's
                                    details that might affect their access to entrance exam</p>
                            </div>
                            <div class="section ml-2 mr-2 mt-3">
                                <div class="row">
                                    @if($user->applications->first())
                                    {{-- @dd($user->applications->first()->admission_status) --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Exam Score</label>
                                            <input name="exam_score" type="number"
                                                class="form-control @error('exam_score') is-invalid @enderror"
                                                value="{{ old('exam_score', $user->student->exam_score ?? '') }}">
                                            @error('exam_score')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    {{-- @dd($user->applications) --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Admission Status</label>
                                            <select name="admission_status"
                                                class="form-control @error('admission_status') is-invalid @enderror">
                                                <option value="" selected disabled>Change Admission Status</option>
                                                <option {{ $user->applications->first()->admission_status == 'denied' ? 'selected' : '' }} value="denied">Denied</option>
                                                <option  {{ $user->applications->first()->admission_status == 'pending' ? 'selected' : '' }} value="pending">Pending</option>
                                                <option {{ $user->applications->first()->admission_status == 'approved' ? 'selected' : '' }} value="approved">Approved</option>
                                            </select>
                                            @error('admission_status')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <hr>
                            <div class="card-body">
                                <div class="form-group">
                                    <label>First Name</label>
                                    <input name="first_name" type="text"
                                        class="form-control @error('first_name') is-invalid @enderror"
                                        value="{{ old('first_name', $user->first_name) }}">
                                    @error('first_name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input name="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        value="{{ old('email', $user->email) }}">
                                    @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Phone Number</label>
                                    <input name="phone" type="tel"
                                        class="form-control @error('phone') is-invalid @enderror"
                                        value="{{ old('email', $user->student->phone) }}">
                                    @error('phone')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Religion</label>
                                    <input name="religion" type="text"
                                        class="form-control @error('religion') is-invalid @enderror"
                                        value="{{ old('religion', $user->student->religion ?? '') }}">
                                    @error('religion')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Date of Birth</label>
                                    <input name="dob" type="date"
                                        class="form-control @error('dob') is-invalid @enderror"
                                        value="{{ old('dob', $user->student->dob ?? '') }}">
                                    @error('dob')
                                    <div class="invalid-feedback">
                                       {{ $message}}
                                    </div>
                                    @enderror
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Blood Group</label>
                                            <select name="blood_group"
                                                class="form-control @error('religion') is-invalid @enderror">
                                                <option disabled selected value="">Select Blood Group</option>
                                                <option {{ $user->student->blood_group == "A+" ? 'selected' : '' }}
                                                    value="A+">A Positive</option>
                                                <option {{ $user->student->blood_group == "A-" ? 'selected' : '' }}
                                                    value="A-">A Negative</option>
                                                <option {{ $user->student->blood_group == "A" ? 'selected' : '' }}
                                                    value="A">A Unknown</option>
                                                <option {{ $user->student->blood_group == "B+" ? 'selected' : '' }}
                                                    value="B+">B Positive</option>
                                                <option {{ $user->student->blood_group == "B-" ? 'selected' : '' }}
                                                    value="B-">B Negative</option>

                                                <option {{ $user->student->blood_group == "B" ? 'selected' : '' }}
                                                    value="B">B Unknown</option>

                                                <option {{ $user->student->blood_group == "AB+" ? 'selected' : '' }}
                                                    value="AB+">AB Positive</option>
                                                <option {{ $user->student->blood_group == "AB-" ? 'selected' : '' }}
                                                    value="AB-">AB Negative</option>
                                                <option {{ $user->student->blood_group == "AB" ? 'selected' : '' }}
                                                    value="AB">AB Unknown</option>
                                                <option {{ $user->student->blood_group == "O+" ? 'selected' : '' }}
                                                    value="O+">O Positive</option>
                                                <option {{ $user->student->blood_group == "O-" ? 'selected' : '' }}
                                                    value="O-">O Negative</option>
                                                <option {{ $user->student->blood_group == "O" ? 'selected' : '' }}
                                                    value="O">O Unknown</option>
                                                <option value="Uknown">Unknown</option>
                                            </select>
                                            @error('blood_group')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Genotype</label>
                                            <select name="genotype"
                                                class="form-control @error('genotype') is-invalid @enderror">
                                                <option value="" selected disabled>Select Genotype</option>
                                                <option {{ $user->student->genotype == "AA" ? 'selected' : '' }}
                                                    value="AA">AA</option>
                                                <option {{ $user->student->genotype == "AS" ? 'selected' : '' }}
                                                    value="AS">AS</option>
                                                <option {{ $user->student->genotype == "AC" ? 'selected' : '' }}
                                                    value="AC">AC</option>
                                                <option {{ $user->student->genotype == "SS" ? 'selected' : '' }}
                                                    value="SS">SS</option>
                                                <option {{ $user->student->genotype == "SC" ? 'selected' : '' }}
                                                    value="SC">SC</option>
                                            </select>
                                            @error('genotype')
                                            <div class="invalid-feedback">
                                               {{ $message}}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Gender</label>
                                            <select name="gender"
                                                class="form-control @error('gender') is-invalid @enderror">
                                                <option value="" selected disabled>Select gender</option>
                                                <option {{ $user->student->gender == "male" ? 'selected' : '' }}
                                                    value="Male">Male</option>
                                                <option {{ $user->student->gender == "female" ? 'selected' : '' }}
                                                    value="Female">Female</option>
                                            </select>
                                            @error('gender')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="card">

                            <div class="card-header">
                                <p><b class="text-danger">NOTE!!</b> The purpose of this page is to update student's
                                    details that might affect their access to entrance exam</p>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Last Name</label>
                                    <input name="last_name" type="text"
                                        class="form-control @error('last_name') is-invalid @enderror"
                                        value="{{ old('last_name', $user->last_name) }}">
                                    @error('last_name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Other Names</label>
                                    <input name="other_names" type="text"
                                        class="form-control @error('other_names') is-invalid @enderror"
                                        value="{{ old('other_names', $user->other_names) }}">
                                    @error('other_names')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Jamb Registration Number</label>
                                    <input name="jamb_reg_no" type="text"
                                        class="form-control @error('jamb_reg_no') is-invalid @enderror"
                                        value="{{ old('jamb_reg_no', $user->student->jamb_reg_no ?? '') }}">
                                    @error('jamb_reg_no')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Jamb Score</label>
                                    <input name="jamb_score" type="number"
                                        class="form-control @error('jamb_score') is-invalid @enderror"
                                        value="{{ old('jamb_score', $user->student->jamb_score ?? '') }}">
                                    @error('jamb_score')
                                    <div class="invalid-feedback">
                                       {{ $message}}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>NIN</label>
                                    <input name="nin" type="text"
                                        class="form-control @error('nin') is-invalid @enderror"
                                        value="{{ old('nin', $user->student->nin ?? '') }}">
                                    @error('nin')
                                    <div class="invalid-feedback">
                                     {{   $message}}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Address</label>
                                    <input name="current_residence_address" type="text"
                                        class="form-control @error('current_residence_address') is-invalid @enderror"
                                        value="{{ old('current_residence_address', $user->student->current_residence_address ?? '') }}">
                                    @error('current_residence_address')
                                    <div class="invalid-feedback">
                                       {{ $message}}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Country of Origin</label>
                                    <select name="country_of_origin"
                                        class="form-control @error('country_of_origin') is-invalid @enderror">
                                        <option value="" selected disabled>Select country of origin</option>
                                       @foreach ($countries as $country)
                                       <option {{ $user->student->country_of_origin == $country['name'] ? 'selected' : '' }}
                                        value="{{ $country['name'] }}">{{ $country['name'] }}</option>                                           
                                       @endforeach

                                    </select>
                                    @error('country_of_origin')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label>Passort Photo</label>
                                            <input onChange="changeImg(this)" capture accept="image/*"
                                                name="passport_photo" type="file"
                                                class="form-control @error('passport_photo') is-invalid @enderror"
                                                value="{{ old('passport_photo', $user->student->passport_photo ?? '') }}">
                                            @error('passport_photo')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <img id="previewImage" src="{{ empty($user->student->passport_photo) ? "
                                            https://placehold.it/150x100" : Storage::url($user->student->passport_photo)
                                        }}" class="elevation-2" width="120px" alt="User Image">
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <button class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>

            </form>


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