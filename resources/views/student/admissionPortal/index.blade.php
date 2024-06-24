@extends('student.layouts.studentLayout')

@section('title', 'Admission Center')

@section('student')
    <style>
        /* Loader styles */
        .loader-overlay {
            display: none;
            position: fixed;
            z-index: 9999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.8);
        }

        .loader {
            border: 16px solid #f3f3f3;
            border-top: 16px solid #3498db;
            border-radius: 50%;
            width: 120px;
            height: 120px;
            animation: spin 2s linear infinite;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Page styles */
        body {
            font-family: 'Montserrat', sans-serif;
            background: linear-gradient(135deg, #667eea, #764ba2);
        }

        .content {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
        }

        .card-header {
            background: linear-gradient(45deg, #764ba2, #667eea);
            color: #fff;
            font-weight: bold;
            padding: 20px 30px;
            border-top-left-radius: 20px;
            border-top-right-radius: 20px;
            text-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        .card-footer {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 20px 30px;
            border-bottom-left-radius: 20px;
            border-bottom-right-radius: 20px;
        }

        .form-group label {
            font-weight: bold;
            color: #333;
        }

        .form-step {
            margin-bottom: 30px;
        }

        .btn-primary {
            background: linear-gradient(45deg, #764ba2, #667eea) !important;
            border: none !important;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2) !important;
        }

        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        .text-danger {
            color: #dc3545 !important;
            font-weight: bold !important;
        }
    </style>

    <div class="loader-overlay" id="loader-overlay">
        <div class="loader"></div>
    </div>

    <!-- Button to open the modal with animation class -->
    <button type="button" class="m-3 btn btn-primary animate-btn" data-toggle="modal" data-target="#instructionsModal">
        View Application Instructions
    </button>

    @if ($errors->has('error'))
        <div class="alert alert-danger m-3">
            {{ $errors->first('error') }}
        </div>
    @endif

    <section class="mx-auto content">
        <form method="POST" action="{{ route('student.admission.application.apply') }}" enctype="multipart/form-data"
            id="multiStepForm">
            @csrf

            {{-- Step 1: Personal Details --}}
            <div id="step1" class="form-step">
                <div class="">
                    <div class="text-white card-header bg-secondary">
                        <p>STEP 1 OF 4, PERSONAL DETAILS</p>
                        <div class="text-warning">Please ensure that all information provided is accurate and
                            up-to-date. Inaccurate information may lead to delays or rejection of your admission
                            application.</div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="first_name">First Name <span class="text-danger">*</span></label>
                                    <input name="first_name" type="text"
                                        class="form-control @error('first_name') border-danger @enderror" id="first_name"
                                        placeholder="Enter First Name"
                                        value="{{ old('first_name', auth()->user()->first_name ?? '') }}">
                                    @error('first_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="last_name">Surname <span class="text-danger">*</span></label>
                                    <input name="last_name" type="text"
                                        class="form-control @error('last_name') border-danger @enderror" id="last_name"
                                        placeholder="Enter Surname"
                                        value="{{ old('last_name', auth()->user()->last_name ?? '') }}">
                                    @error('last_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="other_names">Other Names <span class="text-danger">*</span></label>
                                    <input name="other_names" type="text"
                                        class="form-control @error('other_names') border-danger @enderror" id="other_names"
                                        placeholder="Enter Other Names"
                                        value="{{ old('other_names', auth()->user()->other_names ?? '') }}">
                                    @error('other_names')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="email">Email <span class="text-danger">*</span></label>
                                    <input name="email" type="email"
                                        class="form-control @error('email') border-danger @enderror" id="email"
                                        placeholder="Enter Email Address"
                                        value="{{ old('email', auth()->user()->email ?? '') }}">
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="phone">Phone Number <span class="text-danger">*</span></label>
                                    <input name="phone" type="tel"
                                        class="form-control @error('phone') border-danger @enderror" id="phone"
                                        placeholder="Enter Phone Number"
                                        value="{{ old('phone', auth()->user()->student->phone ?? '') }}">
                                    @error('phone')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="gender">Gender <span class="text-danger">*</span></label>
                                    <select name="gender" id="gender"
                                        class="form-control @error('gender') border-danger @enderror">
                                        <option value="" selected disabled>Select Gender</option>
                                        <option value="male"
                                            {{ old('gender', auth()->user()->student->gender) == 'male' ? 'selected' : '' }}>
                                            Male</option>
                                        <option value="female"
                                            {{ old('gender', auth()->user()->student->gender) == 'female' ? 'selected' : '' }}>
                                            Female</option>
                                    </select>
                                    @error('gender')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="religion">Religion <span class="text-danger">*</span></label>
                                    <select name="religion" class="form-control @error('religion') border-danger @enderror"
                                        id="religion">
                                        <option value="" disabled selected>Select Religion</option>
                                        @foreach ($religions as $religion)
                                            <option value="{{ $religion }}"
                                                {{ old('religion', auth()->user()->student->religion) == $religion ? 'selected' : '' }}>
                                                {{ $religion }}</option>
                                        @endforeach
                                    </select>
                                    @error('religion')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="dob">Date of Birth <span class="text-danger">*</span></label>
                                    <input name="dob" type="date"
                                        class="form-control @error('dob') border-danger @enderror" id="dob"
                                        value="{{ old('dob', auth()->user()->student->dob ?? '') }}">
                                    @error('dob')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="nin">NIN <span class="text-danger">*</span></label>
                                    <input name="nin" type="number"
                                        class="form-control @error('nin') border-danger @enderror" id="nin"
                                        placeholder="National Identification Number"
                                        value="{{ old('nin', auth()->user()->student->nin ?? '') }}">
                                    @error('nin')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="country">Country of Origin <span class="text-danger">*</span></label>
                                    <select name="country" id="country"
                                        class="form-control @error('country') border-danger @enderror"
                                        onchange="handleCountryChange(this.value)">
                                        <option value="" selected>Select Country</option>
                                        @foreach ($countries as $countryName)
                                            <option value="{{ $countryName }}"
                                                {{ old('country', auth()->user()->student->country_of_origin) == $countryName ? 'selected' : '' }}>
                                                {{ $countryName }}</option>
                                        @endforeach
                                    </select>
                                    @error('country')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4" id="nigeriaStateField" style="display: none;">
                                <div class="form-group">
                                    <label for="state_of_origin_nigeria">State <span class="text-danger">*</span></label> <br>
                                    <select style="width: 100% !important" name="state_of_origin_nigeria"
                                        id="state_of_origin_nigeria"
                                        class="form-control @error('state_of_origin_nigeria') border-danger @enderror"
                                        onchange="handleStateChange(this.value)">
                                        <option value="" disabled selected>Select State</option>

                                        @foreach ($nigerianStates as $state)
                                            <option value="{{ $state }}"
                                                {{ old('state_of_origin_nigeria', auth()->user()->student->state_of_origin) == $state ? 'selected' : '' }}>
                                                {{ $state }}</option>
                                        @endforeach
                                    </select>
                                    @error('state_of_origin_nigeria')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4" id="nigeriaLgaField" style="display: none;">
                                <div class="form-group">
                                    <label for="localGovernment">Local Government <span
                                            class="text-danger">*</span></label> <br>
                                    <select style="width: 100% !important" name="localGovernment" id="localGovernment"
                                        class="form-control custom-select @error('localGovernment') border-danger @enderror">
                                        <option value="" disabled selected>Select Local Government</option>
                                        <!-- Local governments will be populated based on the selected state -->
                                    </select>
                                    @error('lga_origin')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4" id="otherCountryStateField" style="display: none;">
                                <div class="form-group">
                                    <label for="state_of_origin">State/Province <span class="text-danger">*</span></label>
                                    <input type="text" name="state_of_origin" id="state_of_origin"
                                        class="form-control @error('state_of_origin') border-danger @enderror"
                                        placeholder="State/Province"
                                        value="{{ old('state_of_origin', auth()->user()->student->state_of_origin ?? '') }}">
                                    @error('state_of_origin')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4" id="otherCountryCityField" style="display: none;">
                                <div class="form-group">
                                    <label for="lga_origin">City/Local Government <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="lga_origin" id="lga_origin"
                                        class="form-control @error('lga_origin') border-danger @enderror"
                                        placeholder="City/Local Government"
                                        value="{{ old('lga_origin', auth()->user()->student->lga_origin ?? '') }}">
                                    @error('lga_origin')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="current_residence_address">Current Residence Address <span
                                            class="text-danger">*</span></label>
                                    <input name="current_residence_address" type="text"
                                        class="form-control @error('current_residence_address') border-danger @enderror"
                                        id="current_residence_address" placeholder="Enter current residence address"
                                        value="{{ old('current_residence_address', auth()->user()->student->current_residence_address ?? '') }}">
                                    @error('current_residence_address')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="permanent_residence_address">Permanent Residence Address <span
                                            class="text-danger">*</span></label>
                                    <input name="permanent_residence_address" type="text"
                                        class="form-control @error('permanent_residence_address') border-danger @enderror"
                                        id="permanent_residence_address" placeholder="Enter permanent residence address"
                                        value="{{ old('permanent_residence_address', auth()->user()->student->permanent_residence_address ?? '') }}">
                                    @error('permanent_residence_address')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="guardian_name">Guardian/Parent <span class="text-danger">*</span></label>
                                    <input name="guardian_name" type="text"
                                        class="form-control @error('guardian_name') border-danger @enderror"
                                        id="guardian_name" placeholder="Guardian / Parent Name"
                                        value="{{ old('guardian_name', auth()->user()->student->guardian_name ?? '') }}">
                                    @error('guardian_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="guardian_phone_number">Guardian/Parent Phone number <span
                                            class="text-danger">*</span></label>
                                    <input name="guardian_phone_number" type="text"
                                        class="form-control @error('guardian_phone_number') border-danger @enderror"
                                        id="guardian_phone_number" placeholder="Parent or Guardian Phone Number"
                                        value="{{ old('guardian_phone_number', auth()->user()->student->guardian_phone_number ?? '') }}">
                                    @error('guardian_phone_number')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="guardian_address">Guardian/Parent Address <span
                                            class="text-danger">*</span></label>
                                    <input name="guardian_address" type="text"
                                        class="form-control @error('guardian_address') border-danger @enderror"
                                        id="guardian_address" placeholder="Parent or Guardian Home Address"
                                        value="{{ old('guardian_address', auth()->user()->student->guardian_address ?? '') }}">
                                    @error('guardian_address')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="blood_group">Blood Group <span class="text-danger">*</span></label>
                                    <select name="blood_group" id="blood_group"
                                        class="form-control custom-select @error('blood_group') border-danger @enderror">
                                        <option value="" disabled selected>Select Blood Group</option>
                                        @foreach (['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'] as $bloodGroup)
                                            <option value="{{ $bloodGroup }}"
                                                {{ old('blood_group', auth()->user()->student->blood_group) == $bloodGroup ? 'selected' : '' }}>
                                                {{ $bloodGroup }}</option>
                                        @endforeach
                                    </select>
                                    @error('blood_group')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="genotype">Genotype <span class="text-danger">*</span></label>
                                    <select name="genotype" id="genotype"
                                        class="form-control custom-select @error('genotype') border-danger @enderror">
                                        <option value="" disabled selected>Select Genotype</option>
                                        @foreach (['AA', 'AS', 'SS', 'AC', 'SC'] as $genotype)
                                            <option value="{{ $genotype }}"
                                                {{ old('genotype', auth()->user()->student->genotype) == $genotype ? 'selected' : '' }}>
                                                {{ $genotype }}</option>
                                        @endforeach
                                    </select>
                                    @error('genotype')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="marital_status">Marital Status <span class="text-danger">*</span></label>
                                    <select name="marital_status" id="marital_status"
                                        class="form-control custom-select @error('marital_status') border-danger @enderror">
                                        <option value="" disabled selected>Select Marital Status</option>
                                        @foreach (['single', 'married', 'divorced', 'widowed'] as $status)
                                            <option value="{{ $status }}"
                                                {{ old('marital_status', auth()->user()->student->marital_status) == $status ? 'selected' : '' }}>
                                                {{ ucfirst($status) }}</option>
                                        @endforeach
                                    </select>
                                    @error('marital_status')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <hr>
                    </div>
                    <div class="card-footer">
                        <button type="button" class="btn btn-primary" onclick="nextStep(1)">Next</button>
                    </div>
                </div>
            </div>

            {{-- Step 2: Academic Details --}}
            <div id="step2" class="form-step" style="display:none;">
                <div class="shadow card">
                    <div class="text-white card-header bg-secondary">
                        <p>STEP 2 OF 4, ACADEMIC DETAILS</p>
                        <div class="text-warning">Please ensure that all academic records provided are accurate and
                            verifiable. Inaccurate or falsified academic information may result in disqualification from
                            the admission process.</div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="secondary_school_attended">Secondary School Attended <span
                                            class="text-danger">*</span></label>
                                    <input name="secondary_school_attended" type="text"
                                        class="form-control @error('secondary_school_attended') border-danger @enderror"
                                        id="secondary_school_attended" placeholder="Secondary School Attended"
                                        value="{{ old('secondary_school_attended', auth()->user()->student->secondary_school_attended ?? '') }}">
                                    @error('secondary_school_attended')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="secondary_school_graduation_year">Graduation Year <span
                                            class="text-danger">*</span></label>
                                    <input name="secondary_school_graduation_year" type="date"
                                        class="form-control @error('secondary_school_graduation_year') border-danger @enderror"
                                        id="secondary_school_graduation_year"
                                        value="{{ old('secondary_school_graduation_year', auth()->user()->student->secondary_school_graduation_year ?? '') }}">
                                    @error('secondary_school_graduation_year')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="secondary_school_certificate_type">Certificate Obtained <span
                                            class="text-danger">*</span></label>
                                    <input name="secondary_school_certificate_type" type="text"
                                        class="form-control @error('secondary_school_certificate_type') border-danger @enderror"
                                        id="secondary_school_certificate_type" placeholder="Certificate Obtained"
                                        value="{{ old('secondary_school_certificate_type', auth()->user()->student->secondary_school_certificate_type ?? '') }}">
                                    @error('secondary_school_certificate_type')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="jamb_reg_no">JAMB Registration Number <span
                                            class="text-danger">*</span></label>
                                    <input name="jamb_reg_no" type="text"
                                        class="form-control @error('jamb_reg_no') border-danger @enderror"
                                        id="jamb_reg_no" placeholder="JAMB Registration Number"
                                        value="{{ old('jamb_reg_no', auth()->user()->student->jamb_reg_no ?? '') }}">
                                    @error('jamb_reg_no')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="jamb_score">JAMB Score <span class="text-danger">*</span></label>
                                    <input name="jamb_score" type="number"
                                        class="form-control @error('jamb_score') border-danger @enderror" id="jamb_score"
                                        placeholder="JAMB Score"
                                        value="{{ old('jamb_score', auth()->user()->student->jamb_score ?? '') }}">
                                    @error('jamb_score')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="button" class="btn btn-secondary" onclick="prevStep(0)">Previous</button>
                        <button type="button" class="btn btn-primary" onclick="nextStep(2)">Next</button>
                    </div>
                </div>
            </div>

            {{-- Step 3: Department Selection --}}
            <div id="step3" class="form-step" style="display:none;">
                <div class="shadow card">
                    <div class="text-white card-header bg-secondary">
                        <p>STEP 3 OF 4, DEPARTMENT SELECTION</p>
                        <div class="text-warning">Please choose your preferred department of study. Make sure to review
                            the department requirements and prerequisites before making your selection.</div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-7">
                                <div class="form-group">
                                    <label for="jamb_selection" class="text-info">Did you choose our university as your JAMB selection, change your institution to ours, or are you applying for direct entry?
                                        <span
                                            class="text-danger">*</span></label>
                                    <select name="jamb_selection" id="jamb_selection"
                                        class="form-control @error('jamb_selection') border-danger @enderror">
                                        <option value="" disabled selected>Select an option</option>
                                        <option value="selected_in_jamb"
                                            {{ old('jamb_selection', auth()->user()->student->jamb_selection) == 'selected_in_jamb' ? 'selected' : '' }}>
                                            Selected in JAMB</option>
                                        <option value="change_of_school"
                                            {{ old('jamb_selection', auth()->user()->student->jamb_selection) == 'change_of_school' ? 'selected' : '' }}>
                                            Change of School</option>
                                        <option value="direct_entry"
                                            {{ old('jamb_selection', auth()->user()->student->jamb_selection) == 'direct_entry' ? 'selected' : '' }}>
                                            Direct Entry</option>
                                    </select>
                                    @error('jamb_selection')
                                        <div class="text-danger">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="mt-4 form-group">
                                    <label for="academic_session_id">Current Academic Session</label>
                                    <select name="academic_session_id" id="academic_session_id" class="form-control">
                                        <option selected value="{{ $academicSession->id }}">
                                            {{ $academicSession->session ?? '' }}</option>
                                    </select>
                                </div>
                                @error('academic_session_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="department_id">Select Department <span
                                            class="text-danger">*</span></label><br>
                                    <select style="width: 100% !important" name="department_id" id="department_id"
                                        class="form-control @error('department_id') border-danger @enderror"
                                        onchange="updateDepartmentDescription()">
                                        <option value="" disabled selected>Select Department</option>
                                        @foreach ($departments as $department)
                                            <option value="{{ $department->id }}"
                                                {{ old('department_id', auth()->user()->student->department_id) == $department->id ? 'selected' : '' }}>
                                                {{ $department->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('department_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Department Description</label>
                                    <p id="department_description"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="button" class="btn btn-secondary" onclick="prevStep(1)">Previous</button>
                        <button type="button" class="btn btn-primary" onclick="nextStep(3)">Next</button>
                    </div>
                </div>
            </div>

            {{-- Step 4: File Uploads and Agreement --}}
            <div id="step4" class="form-step" style="display:none;">
                <div class="shadow card">
                    <div class="text-white card-header bg-secondary">
                        <p>STEP 4 OF 4, DOCUMENT UPLOADS</p>
                    </div>
                    <div class="card-body">
                        <p>
                            For admission form submission at Shanahan University, please note that the upload file size should not exceed 2MB. This applies to all required documents, ensure your files are properly compressed to meet the size limit. Adhering to this guideline will enable smooth processing of your application.
                        </p>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="passport_photo">Passport Photo <span class="text-danger">*</span></label>
                                    <input type="file" name="passport_photo" id="passport_photo" class="form-control"
                                        accept="image/*" onchange="previewImage(event)">
                                    <img id="imagePreview" src="#" alt="Passport Photo"
                                        style="display: none; margin-top: 10px; max-width: 100px; max-height: 100px;">
                                    @error('passport_photo')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="document_ssce">SSCE Document <span class="text-danger">*</span></label>
                                    <input type="file" name="document_ssce" id="document_ssce" class="form-control"
                                        accept="image/*">
                                    @error('document_ssce')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            {{-- <div class="col-md-4">
                                <div class="form-group">
                                    <label for="document_jamb">JAMB Document <span class="text-danger">*</span></label>
                                    <input type="file" name="document_jamb" id="document_jamb" class="form-control"
                                        accept="image/*">
                                    @error('document_jamb')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div> --}}
                        </div>
                        <div class="mt-3 form-group form-check">
                            <input type="checkbox" name="terms" class="form-check-input" id="agreement">
                            <label class="form-check-label" for="agreement">I have read and agree to the <a
                                    href="#" data-toggle="modal" data-target="#termsModal">terms and
                                    conditions</a>.</label>
                            @error('terms')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="button" class="btn btn-secondary" onclick="prevStep(2)">Previous</button>
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </div>
            </div>
        </form>

        <!-- Terms and Conditions Modal -->
        <div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="termsModalLabel">Terms and Conditions</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>
                            <strong>1. Accuracy of Information:</strong><br>
                            I hereby declare that all information provided in this application is accurate
                            and true to the best of my knowledge. I understand that providing false
                            information or withholding material information may result in the rejection of
                            my application, withdrawal of an offer of admission, or dismissal from the
                            university if discovered at a later date.
                        </p>
                        <p>
                            <strong>2. Document Submission:</strong><br>
                            I agree to submit all documents in the specified format (PDF or image
                            format, max 2MB each) as part of my application. I understand that failure to
                            submit the documents may result in delays or rejection of my
                            application.
                        </p>
                        <p>
                            <strong>3. Compliance with University Policies:</strong><br>
                            I agree to abide by all policies, rules, and regulations of the university if
                            admitted. I understand that non-compliance with university policies may result
                            in disciplinary action, including suspension or expulsion.
                        </p>
                        <p>
                            <strong>4. Admission Process:</strong><br>
                            I understand that the university reserves the right to request additional
                            information or documentation to verify the information provided in my
                            application. I acknowledge that meeting the minimum admission requirements does
                            not guarantee admission to the university. I agree to comply with any additional
                            requirements specified by the university during the admission process.
                        </p>
                        <p>
                            <strong>5. Use of Personal Data:</strong><br>
                            I consent to the collection, processing, and use of my personal data for the
                            purposes of admission and enrollment at the university. I understand that my
                            personal data will be handled in accordance with the university's privacy
                            policy.
                        </p>
                        <p>
                            <strong>6. Fee Payment:</strong><br>
                            I acknowledge that if offered admission, I will be to pay the necessary
                            tuition and fees as per the university's fee structure. I understand that
                            failure to pay the fees within the specified time frame may result in
                            the cancellation of my admission offer.
                        </p>
                        <p>
                            <strong>7. Communication:</strong><br>
                            I agree to receive communication from the university regarding my application,
                            admission status, and other related matters through the contact details provided
                            in this application.
                        </p>
                        <p>
                            <strong>8. Withdrawal and Refund Policy:</strong><br>
                            I understand that if I decide to withdraw my application or admission, I must
                            follow the university's withdrawal and refund policy as outlined on the
                            university website.
                        </p>
                        <p>
                            <strong>9. Medical and Health Information:</strong><br>
                            I agree to provide accurate and complete medical and health information as part
                            of my application, including submitting a medical report if . I
                            understand that the university may use this information to ensure my health and
                            safety on campus.
                        </p>
                        <p>
                            By submitting this application, I confirm that I have read, understood, and
                            agreed to the above terms and conditions.
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Instructions Modal -->
        <div class="modal fade" id="instructionsModal" tabindex="-1" role="dialog"
            aria-labelledby="instructionsModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="instructionsModalLabel">Application Instructions</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <ul>
                            <li class="text-danger">All fields marked with <q><span class="text-danger">*</span></q> are
                                .</li>
                            <li class="text-danger">Ensure you write your names correctly as you have it on <b>JAMB</b>.
                            </li>
                            <li>Please provide accurate and up-to-date information to avoid delays or rejection of your
                                application.</li>
                            <li>Have all necessary documents ready for upload in PDF or image format (max 2MB each).</li>
                            <li>Make sure to review your application thoroughly before submission.</li>
                            <li>Recent photograph (taken within the last 6 months)</li>
                            <li>Colored photograph with a white background</li>
                            <li>Full face, front view, with a neutral expression and both eyes open</li>
                            <li>Head covering is accepted for religious reasons, but the face must be clearly visible</li>
                            <li>Printed on high-quality photo paper</li>
                        </ul>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            let currentStep = 0;
            const formSteps = document.getElementsByClassName('form-step');
            const departmentDescriptions = @json($departmentDescriptions);

            document.addEventListener('DOMContentLoaded', function() {
                showStep(currentStep);

                const country = document.getElementById('country').value;
                handleCountryChange(country);

                const state = document.getElementById('state').value;
                handleStateChange(state);
            });

            function showStep(step) {
                for (let i = 0; i < formSteps.length; i++) {
                    formSteps[i].style.display = 'none';
                }
                formSteps[step].style.display = 'block';
            }

            function nextStep(step) {
                currentStep = step;
                showStep(currentStep);
            }

            function prevStep(step) {
                currentStep = step;
                showStep(currentStep);
            }

            function handleCountryChange(country) {
                const nigeriaStateField = document.getElementById('nigeriaStateField');
                const nigeriaLgaField = document.getElementById('nigeriaLgaField');
                const otherCountryStateField = document.getElementById('otherCountryStateField');
                const otherCountryCityField = document.getElementById('otherCountryCityField');

                if (country === 'Nigeria') {
                    nigeriaStateField.style.display = 'block';
                    nigeriaLgaField.style.display = 'block';
                    otherCountryStateField.style.display = 'none';
                    otherCountryCityField.style.display = 'none';
                } else {
                    nigeriaStateField.style.display = 'none';
                    nigeriaLgaField.style.display = 'none';
                    otherCountryStateField.style.display = 'block';
                    otherCountryCityField.style.display = 'block';
                }
            }

            const localGovernments = @json($localGovernments);

            function handleStateChange(state) {
                const localGovernmentSelect = document.getElementById('localGovernment');
                localGovernmentSelect.innerHTML = '<option value="" disabled selected>Select Local Government</option>';

                if (localGovernments[state]) {
                    localGovernments[state].forEach(lga => {
                        const option = document.createElement('option');
                        option.value = lga;
                        option.textContent = lga;
                        localGovernmentSelect.appendChild(option);
                    });

                    localGovernmentSelect.value =
                        "{{ old('localGovernment', auth()->user()->student->lga_origin ?? '') }}";
                }
            }

            function previewImage(event) {
                const reader = new FileReader();
                reader.onload = function() {
                    const output = document.getElementById('imagePreview');
                    output.src = reader.result;
                    output.style.display = 'block';
                }
                reader.readAsDataURL(event.target.files[0]);
            }

            function updateDepartmentDescription() {
                const departmentId = document.getElementById('department_id').value;
                const description = departmentDescriptions[departmentId] || 'No description available.';
                document.getElementById('department_description').innerHTML = description;
            }

            document.addEventListener('DOMContentLoaded', function() {
                const importForm = document.getElementById('multiStepForm');
                const loaderOverlay = document.getElementById('loader-overlay');

                importForm.addEventListener('submit', function() {
                    loaderOverlay.style.display = 'block';
                });
            });
        </script>
    </section>
@endsection
