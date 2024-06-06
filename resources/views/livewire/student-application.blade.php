<form wire:submit.prevent='register'>
    {{-- step on starts --}}
    @if ($currentStep == 1)
        <div class="step-one">
            <div class="shadow card">
                <div class="text-white card-header bg-secondary">
                    <p> STEP <b>{{ $currentStep }}</b> OF {{ $totalSteps }}, PERSONAL DETAILS </p>
                    <div class="text-warning">Please ensure that all information provided is accurate and up-to-date.
                        Inaccurate information may lead to delays or rejection of your admission application.</div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="first_name">First Name <span class="text-danger">*</span></label>
                                <input wire:model.lazy="first_name" type="text" class="form-control" id="first_name"
                                    placeholder="Enter First Name" required>
                                @error('first_name')
                                    <div class="text-danger">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="last_name">Last Name <span class="text-danger">*</span></label>
                                <input wire:model.lazy="last_name" type="text" class="form-control" id="last_name"
                                    placeholder="Enter Last Name" required>
                                @error('last_name')
                                    <div class="text-danger">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="other_names">Other Names <span class="text-danger">*</span></label>
                                <input wire:model.lazy="other_names" type="text" class="form-control"
                                    id="other_names" placeholder="Other Names .." required>
                                @error('other_names')
                                    <div class="text-danger">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="email">Email <span class="text-danger">*</span></label>
                                <input wire:model.lazy="email" type="email" class="form-control" id="email"
                                    placeholder="Enter Email Address" required>
                                @error('email')
                                    <div class="text-danger">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="phone">Phone Number <span class="text-danger">*</span></label>
                                <input wire:model.lazy="phone" type="tel" class="form-control" id="phone"
                                    placeholder="Enter Phone Number" required>
                                @error('phone')
                                    <div class="text-danger">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="gender">Gender: <span class="text-danger">*</span></label>
                                <select wire:model.lazy="gender" id="gender" class="form-control">
                                    <option value="" disabled>Select Gender</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                                @error('gender')
                                    <div class="text-danger">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="religion">Religion <span class="text-danger">*</span></label>
                                <select wire:model.lazy="religion" class="form-control" id="religion">
                                    <option value="" disabled selected>Select Religion</option>
                                    @foreach ($religions as $religion)
                                        <option value="{{ $religion }}">{{ $religion }}</option>
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
                                <input wire:model.lazy="dob" type="date" class="form-control" id="dob"
                                    required>
                                @error('dob')
                                    <div class="text-danger">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="nin">NIN <span class="text-danger">*</span></label>
                                <input wire:model.lazy="nin" type="text" class="form-control" id="nin"
                                    placeholder="National Identification Number" required>
                                @error('nin')
                                    <div class="text-danger">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="country">Country of Origin <span class="text-danger">*</span></label>
                                <select id="country" class="form-control" wire:model="country"
                                    wire:change="countrySelected">
                                    <option value="">Select Country</option>
                                    @foreach ($countries as $countryName)
                                        <option value="{{ $countryName }}">{{ $countryName }}</option>
                                    @endforeach
                                </select>
                                @error('country')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>

                        @if ($country == 'Nigeria')
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="state">State <span class="text-danger">*</span></label>
                                    <select id="state" class="form-control" wire:model.lazy="state"
                                        wire:change="stateSelected">
                                        <option {{ !empty($state) ? 'selected' : '' }} value="{{ $state }}">
                                            {{ $state }}
                                        </option>
                                        <option value="">Select State</option>
                                        @foreach ($states as $state)
                                            <option value="{{ $state }}">{{ $state }}</option>
                                        @endforeach
                                    </select>
                                    @error('state')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="localGovernment">Local Government <span
                                            class="text-danger">*</span></label>
                                    <select id="localGovernment" class="form-control"
                                        wire:model.lazy="localGovernment">
                                        <option {{ !empty($localGovernment) ? 'selected' : '' }}
                                            value="{{ $localGovernment }}">
                                            {{ $localGovernment }}</option>
                                        <option value="">Select Local Government</option>
                                        @foreach ($localGovernments as $localGovernment)
                                            <option value="{{ $localGovernment }}">{{ $localGovernment }}</option>
                                        @endforeach
                                    </select>
                                    @error('localGovernment')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        @else
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="state">State/Province <span class="text-danger">*</span></label>
                                    <input type="text" placeholder="State/Province" id="state"
                                        class="form-control" wire:model.lazy="state">
                                    @error('state')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="localGovernment">City/Local Government <span
                                            class="text-danger">*</span></label>
                                    <input type="text" placeholder="City/Local Government" id="localGovernment"
                                        class="form-control" wire:model.lazy="localGovernment">
                                    @error('localGovernment')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        @endif

                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="current_residence_address">Current Residence Address <span
                                        class="text-danger">*</span></label>
                                <input wire:model.lazy="current_residence_address" type="text"
                                    class="form-control" id="current_residence_address"
                                    placeholder="Enter current_residence_address" required>
                                @error('current_residence_address')
                                    <div class="text-danger">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="permanent_residence_address">Permanent Residence Address <span
                                        class="text-danger">*</span></label>
                                <input wire:model.lazy="permanent_residence_address" type="text"
                                    class="form-control" id="permanent_residence_address"
                                    placeholder="Enter permanent_residence_address" required>
                                @error('permanent_residence_address')
                                    <div class="text-danger">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="guardian_name">Guardian/Parent <span class="text-danger">*</span></label>
                                <input wire:model.lazy="guardian_name" type="text" class="form-control"
                                    id="guardian_name" placeholder="Guardian / Parent Name" />
                                @error('guardian_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="guardian_phone_number">Guardian/Parent Phone number <span
                                        class="text-danger">*</span></label>
                                <input wire:model.lazy="guardian_phone_number" type="text" class="form-control"
                                    id="guardian_phone_number" placeholder="Parent or Guardian Phone Number" />
                                @error('guardian_phone_number')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="guardian_address">Guardian/Parent Address <span
                                        class="text-danger">*</span></label>
                                <input wire:model.lazy="guardian_address" type="text" class="form-control"
                                    id="guardian_address" placeholder="Parent or Guardian Home Address" />
                                @error('guardian_address')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="genotype">Genotype</label>
                                <select wire:model.lazy="genotype" class="form-control" id="genotype">
                                    <option value=""> Select Genotype</option>
                                    <option value="AA">AA</option>
                                    <option value="AS">AS</option>
                                    <option value="AC">AC</option>
                                    <option value="SS">SS</option>
                                    <option value="SC">SC</option>
                                </select>
                                @error('genotype')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="blood_group">Blood Group</label>
                                <select wire:model.lazy="blood_group" class="form-control" id="blood_group"
                                    placeholder="Blood Group">
                                    <option selected value="">Select Blood Group</option>
                                    <option value="A+">A Positive</option>
                                    <option value="A-">A Negative</option>
                                    <option value="A">A Unknown</option>
                                    <option value="B+">B Positive</option>
                                    <option value="B-">B Negative</option>

                                    <option value="B">B Unknown</option>

                                    <option value="AB+">AB Positive</option>
                                    <option value="AB-">AB Negative</option>
                                    <option value="AB">AB Unknown</option>
                                    <option value="O+">O Positive</option>
                                    <option value="O-">O Negative</option>
                                    <option value="O">O Unknown</option>
                                </select>
                                @error('blood_group')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="marital_status">Marital Status <span class="text-danger">*</span></label>
                                <select wire:model.lazy="marital_status" id="marital_status" class="form-control">
                                    <option value="" disabled selected>Select Marital Status</option>
                                    <option value="single">Single</option>
                                    <option value="married">Married</option>
                                    <option value="divorced">Divorced</option>
                                    <option value="widowed">Widowed</option>
                                </select>
                                @error('marital_status')
                                    <div class="text-danger">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    {{-- step one ends --}}

    {{-- step two starts --}}
    @if ($currentStep == 2)
        <div class="step-two">
            <div class="shadow card">
                <div class="text-white card-header bg-secondary">
                    <p>STEP <b>{{ $currentStep }}</b> OF {{ $totalSteps }}, ACADEMIC DETAILS</p>
                    <div class="text-warning">Please ensure that all academic records provided are accurate and
                        verifiable.
                        Inaccurate or falsified academic information may result in disqualification from the admission
                        process.</div>

                </div>
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="secondary_school_attended">Secondary School Attended <span
                                        class="text-danger">*</span></label>
                                <input wire:model.lazy="secondary_school_attended" type="text"
                                    class="form-control" id="secondary_school_attended"
                                    placeholder="Secondary School Attended" />
                                @error('secondary_school_attended')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="secondary_school_graduation_year">Graduation Year <span
                                        class="text-danger">*</span></label>
                                <input wire:model.lazy="secondary_school_graduation_year" type="date"
                                    class="form-control" id="secondary_school_graduation_year"
                                    placeholder="Secondary School Graduation Year" />
                                @error('secondary_school_graduation_year')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="secondary_school_certificate_type">Certificate Obtained </label>
                                <input wire:model.lazy="secondary_school_certificate_type" type="text"
                                    class="form-control" id="secondary_school_certificate_type"
                                    placeholder="Secondary School Certificate obtained" />
                                @error('secondary_school_certificate_type')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="jamb_reg_no">Jamb Registration Number <span
                                        class="text-danger">*</span></label>
                                <input wire:model.lazy="jamb_reg_no" type="text" class="form-control"
                                    id="jamb_reg_no" placeholder="Jamb registration Number" />
                                @error('jamb_reg_no')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="jamb_score">Jamb Score <span class="text-danger">*</span></label>
                                <input wire:model.lazy="jamb_score" type="number" class="form-control"
                                    id="jamb_score" placeholder="Jamb Score" />
                                @error('jamb_score')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-7 mx-auto">
                            <div class="form-group">
                                <label for="jamb_selection">Did you select our university in JAMB, or when you did
                                    a change of school, or are you coming for direct entry? <span
                                        class="text-danger">*</span></label>
                                <select wire:model="jamb_selection" id="jamb_selection" class="form-control">
                                    <option value="" disabled selected>Select an option</option>
                                    <option value="selected_in_jamb">Selected in JAMB</option>
                                    <option value="change_of_school">Change of School</option>
                                    <option value="direct_entry">Direct Entry</option>
                                </select>
                                @error('jamb_selection')
                                    <div class="text-danger">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    {{-- step two ends --}}

    {{-- step three starts --}}
    @if ($currentStep == 3)
        <div class="step-three">

            <div class="shadow card">
                <div class="text-white card-header bg-info">
                    STEP <b>{{ $currentStep }}</b> OF {{ $totalSteps }}, SELECT DEPARTMENT(PROGRAM OF CHOICE)
                </div>
                <div class="card-body">

                    <div class="row">
                        <div class="mx-auto mt-5 col-md-6">
                            <div class="mb-5 text-info">Before selecting a department, please ensure that you have
                                thoroughly researched the department's requirements and qualifications. Applying for the
                                right department increases your chances of successful admission and aligns with your
                                academic and career goals.</div>

                            <div class="form-group">
                                <label for="academic_session">Academic Session</label>
                                <select wire:model.lazy="academic_session_id" id="academic_session"
                                    class="form-control">
                                    {{-- <option value="">Select Academic Session</option> --}}
                                    <option selected value="{{ $academicSessions->id }}">
                                        {{ $academicSessions->session }}</option>
                                </select>
                                @error('academic_session_id')
                                    <div class="text-danger">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="department_id">Select Department <span
                                        class="text-danger">*</span></label>
                                <select wire:model.lazy="department_id" class="form-control" id="department_id">
                                    <option selected>Select Department(Program of choice)</option>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}">{{ Str::title($department->name) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('department_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                @if ($department_description)
                                    <label for="department_description">Department Description:</label>
                                    <p>{!! $department_description !!}</p>
                                @endif

                            </div>
                        </div>
                    </div>
                    <hr>
                </div>
            </div>
        </div>
    @endif
    {{-- step three ends --}}

    {{-- step four starts --}}

    @if ($currentStep == 4)
        <div class="step-four">
            <div class="shadow card">
                <div class="text-white card-header bg-info">
                    STEP <b>{{ $currentStep }}</b> OF {{ $totalSteps }}, ENTER OLEVEL EXAM SUBJECTS AND SCORE
                    <small>Not less than 4 subjects for any sitting (maximum of 2 sittings)</small>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Number of Sittings: <span class="text-danger">*</span></label>
                        <div>
                            <div class="form-check form-check-inline">
                                <div><input class="form-check-input" type="radio" wire:model="sittings"
                                        value="1" wire:click="$set('subjects2', [])">
                                    <label class="form-check-label">One Sitting</label>
                                </div>
                                @error('subjects1')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-check form-check-inline">
                                <div><input class="form-check-input" type="radio" wire:model="sittings"
                                        value="2" wire:click="$set('subjects1', [])">
                                    <label class="form-check-label">Two Sittings</label>
                                </div>
                                @error('subjects2')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    @if ($sittings === 1)
                        <div class="form-group">
                            <label>Exam Board: <span class="text-danger">*</span></label>
                            <select wire:model="examBoard1" class="form-control">
                                <option disabled selected>Select Exam Board</option>
                                <option value="waec">WAEC</option>
                                <option value="neco">NECO</option>
                                <option value="gce">GCE</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Exam Year: <span class="text-danger">*</span></label>
                            <input type="text" wire:model="examYear1" class="form-control"
                                placeholder="Enter Exam Year">
                            @error('examYear1')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    @else
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Exam Board 1: <span class="text-danger">*</span></label>
                                    <select wire:model="examBoard1" class="form-control">
                                        <option value="waec">WAEC</option>
                                        <option value="neco">NECO</option>
                                        <option value="gce">GCE</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Exam Year 1: <span class="text-danger">*</span></label>
                                    <input type="text" wire:model="examYear1" class="form-control"
                                        placeholder="Enter Exam Year">
                                    @error('examYear1')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Exam Board 2: <span class="text-danger">*</span></label>
                                    <select wire:model="examBoard2" class="form-control">
                                        <option value="waec">WAEC</option>
                                        <option value="neco">NECO</option>
                                        <option value="gce">GCE</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Exam Year 2: <span class="text-danger">*</span></label>
                                    <input type="text" wire:model="examYear2" class="form-control"
                                        placeholder="Enter Exam Year">
                                    @error('examYear2')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-6">
                            <h3>Sitting 1</h3>
                            @foreach ($subjects1 as $index => $subject)
                                <div class="row form-group">
                                    <div class="col-md-6">
                                        <select wire:model="subjects1.{{ $index }}.subject"
                                            class="form-control @error('subjects1.' . $index . '.subject') is-invalid @enderror">
                                            <option value="">Select Subject</option>
                                            @foreach ($examSubjects as $name => $displayName)
                                                <option value="{{ $name }}">{{ $displayName }}</option>
                                            @endforeach
                                        </select>
                                        @error('subjects1.' . $index . '.subject')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" wire:model="subjects1.{{ $index }}.score"
                                            placeholder="Score, Eg A1"
                                            class="form-control @error('subjects1.' . $index . '.score') is-invalid @enderror">
                                        @error('subjects1.' . $index . '.score')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" wire:click="removeSubject(1, {{ $index }})"
                                            class="btn btn-danger"><i class="fas fa-minus"></i></button>
                                    </div>
                                </div>
                            @endforeach

                            <button type="button" wire:click="addSubject(1)" class="btn btn-primary">Add Subject <i
                                    class="fas fa-plus"></i></button>
                        </div>

                        <div class="col-md-6">
                            @if ($sittings == 2)
                                <h3>Sitting 2</h3>
                                @foreach ($subjects2 as $index => $subject)
                                    <div class="row form-group">
                                        <div class="col-md-6">
                                            <select wire:model="subjects2.{{ $index }}.subject"
                                                class="form-control @error('subjects2.' . $index . '.subject') is-invalid @enderror">
                                                <option value="">Select Subject</option>
                                                @foreach ($examSubjects as $name => $displayName)
                                                    <option value="{{ $name }}">{{ $displayName }}</option>
                                                @endforeach
                                            </select>
                                            @error('subjects2.' . $index . '.subject')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" wire:model="subjects2.{{ $index }}.score"
                                                placeholder="Score, Eg A1"
                                                class="form-control @error('subjects2.' . $index . '.score') is-invalid @enderror">
                                            @error('subjects2.' . $index . '.score')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-md-2">
                                            <button type="button" wire:click="removeSubject(2, {{ $index }})"
                                                class="btn btn-danger"><i class="fas fa-minus"></i></button>
                                        </div>
                                    </div>
                                @endforeach
                                <button type="button" wire:click="addSubject(2)" class="btn btn-primary">Add Subject
                                    <i class="fas fa-plus"></i></button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <!-- step four ends -->

    {{-- step four ends --}}

    {{-- step five starts --}}
    @if ($currentStep == 5)
        <div class="step-five">
            <div class="shadow card">
                <div class="text-white card-header bg-primary">
                    STEP <b>{{ $currentStep }}</b> OF {{ $totalSteps }}, SUBMIT COPIES OF ALL REQUIRED DOCUMENTS
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="document_medical_report">Submit Medical Report <span
                                        class="text-danger">*</span></label>
                                <input type="file" wire:model="document_medical_report"
                                    id="document_medical_report" class="form-control">
                                @error('document_medical_report')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="document_birth_certificate">Birth Certificate <span
                                        class="text-danger">*</span></label>
                                <input type="file" wire:model="document_birth_certificate"
                                    id="document_birth_certificate" class="form-control">
                                @error('document_birth_certificate')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="document_local_government_identification">LGA Identification <span
                                        class="text-danger">*</span></label>
                                <input type="file" wire:model="document_local_government_identification"
                                    id="document_local_government_identification" class="form-control">
                                @error('document_local_government_identification')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="document_secondary_school_certificate_type">FSLC</label>
                                <input type="file" wire:model="document_secondary_school_certificate_type"
                                    id="document_secondary_school_certificate_type" class="form-control">
                                @error('document_secondary_school_certificate_type')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <hr>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="passport_photo">Passport Photo <span
                                                class="text-danger">*</span></label>
                                        <input type="file" wire:model="passport_photo" id="passport_photo"
                                            class="form-control" accept="image/*">
                                        @error('passport_photo')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    @if ($passport_photo)
                                        <img src="{{ $passport_photo->temporaryUrl() }}" alt="Passport Photo Preview"
                                            class="img-thumbnail mt-2" width="150">
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="mt-5 form-group form-check">
                        <label for="terms" class="d-block">
                            <input type="checkbox" class="form-check-input" wire:model="terms" id="terms"> You
                            must agree to our
                            <a href="#termsModal" data-toggle="modal" class="link">terms and conditions.</a>
                        </label>
                        @error('terms')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <!-- Terms Modal -->
                    <!-- Terms Modal -->
                    <div class="modal fade" id="termsModal" tabindex="-1" role="dialog"
                        aria-labelledby="termsModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="termsModalLabel">Terms and Conditions</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <h5>Terms and Conditions</h5>
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
                                        I agree to submit all required documents in the specified format (PDF or image
                                        format, max 2MB each) as part of my application. I understand that failure to
                                        submit the required documents may result in delays or rejection of my
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
                                        I acknowledge that if offered admission, I will be required to pay the necessary
                                        tuition and fees as per the university's fee structure. I understand that
                                        failure to pay the required fees within the specified time frame may result in
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
                                        of my application, including submitting a medical report if required. I
                                        understand that the university may use this information to ensure my health and
                                        safety on campus.
                                    </p>
                                    <p>
                                        By submitting this application, I confirm that I have read, understood, and
                                        agreed to the above terms and conditions.
                                    </p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    @endif

    {{-- step five ends --}}


    <div class="p-2 mb-5 bg-white action-buttons d-flex justify-content-between">
        @if ($currentStep == 1)
            <div></div>
        @endif
        @if ($currentStep == 2 || $currentStep == 3 || $currentStep == 4 || $currentStep == 5)
            <button wire:click="decreaseStep()" type="button" class="btn btn-secondary"><i
                    class="fa fa-angle-double-left" aria-hidden="true"></i>
                Back</button>
        @endif
        @if ($currentStep == 1 || $currentStep == 2 || $currentStep == 3 || $currentStep == 4)
            <button wire:click='increaseStep()' type="button" class="btn btn-primary">Next <i
                    class="fa fa-angle-double-right" aria-hidden="true"></i>
            </button>
        @endif
        @if ($currentStep == 5)
            <button type="submit" class="btn btn-success">
                Submit Application <i wire:loading class="fa fa-spinner fa-spin" aria-hidden="true"></i>
            </button>
        @endif
    </div>


</form>
