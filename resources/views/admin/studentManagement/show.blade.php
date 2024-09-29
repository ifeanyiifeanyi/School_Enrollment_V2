@extends('admin.layouts.adminLayout')

@section('title', 'Student Information')

@section('css')
    <style>


        .card {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin-bottom: 20px;
        }

        .card-header {
            background: linear-gradient(to right, #FF512F, #DD2476);
            color: white;
            padding: 15px;
            font-size: 20px;
            font-weight: bold;
            border-radius: 10px 10px 0 0;
        }

        .card-body {
            padding: 20px;
        }

        .img-thumbnail {
            border-radius: 50%;
            border: 3px solid #FF512F;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
            max-width: 100%;
            height: auto;
        }

        .badge {
            font-weight: normal;
            background-color: #FF512F;
            color: white;
            border-radius: 20px;
            padding: 5px 15px;
        }

        h1 {
            font-size: 28px;
            font-weight: bold;
            color: #DD2476;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
        }

        h4 {
            color: #FF512F;
            font-weight: bold;
            font-size: 18px;
        }

        .list-group-item {
            border: none;
            padding: 10px 15px;
            background-color: #f8f9fa;
            border-radius: 5px;
            margin-bottom: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .list-group-item:last-child {
            margin-bottom: 0;
        }

        .list-group-item .badge {
            font-size: 14px;
        }

        blockquote {
            background: linear-gradient(to right, rgba(255, 81, 47, 0.1), rgba(221, 36, 118, 0.1));
            border-left: 5px solid #FF512F;
            margin: 1em 0;
            padding: 0.5em 10px;
            border-radius: 5px;
            font-style: italic;
            color: #666;
        }

        blockquote p {
            display: inline;
        }

        .btn-primary,
        .btn-success {
            background: linear-gradient(to right, #FF512F, #DD2476);
            border: none;
            border-radius: 20px;
            padding: 8px 16px;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .btn-primary:hover,
        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
        }

        #imageModal img {
            border-radius: 5px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
        }

        /* Responsive styles */
        @media (max-width: 767px) {
            .card-header {
                font-size: 18px;
            }

            .card-body {
                padding: 15px;
            }

            .img-thumbnail {
                max-width: 150px;
            }

            h1 {
                font-size: 24px;
            }

            h4 {
                font-size: 16px;
            }
        }
    </style>
@endsection

@section('admin')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ Str::title($student->full_name) }}</h1>
                <br>
            </div>
            <div class="container">
                <h4>Application No: <code>{{ $student->student->application_unique_number ?? 'Yet To Apply!!' }}</code></h4>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                Personal Information
                            </div>
                            <div class="card-body">
                                <div class="text-center">
                                    <img alt="image"
                                        src="{{ empty($student->student->passport_photo) ? asset('admin/assets/img/avatar/avatar-5.png') : asset($student->student->passport_photo) }}"
                                        class="img-thumbnail" style="width: 200px; height:200px;" data-toggle="title"
                                        title="{{ $student->full_name }}">
                                </div>
                                <div class="mt-3 text-center">
                                    <p class="text-muted">{{ Str::title($student->student->nationality ?? 'N/A') }}</p>
                                    <p class="text-muted">
                                        @if ($student->student->nationality == 'Nigeria')
                                            <b>NIN: </b> {{ $student->student->nin ?? 'N/A' }}
                                        @endif
                                        @if ($student->applications)
                                            <p><strong>Department <br></strong> <span class="badge badge-pill" style="font-weight: bolder;text-transform:uppercase;font-size:20px">{{ $student->applications->department->name ?? 'INACTIVE APPLICATION' }}</span></p>
                                        @endif
                                    </p>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6">
                                        <ul class="list-group">
                                            <li class="list-group-item">
                                                <strong>Jamb Selection Choice:</strong>
                                                <span class="badge badge-pill">{{ Str::upper(str_replace('_', ' ', $student->student->jamb_selection ?? 'N/A')) }}</span>

                                            </li>
                                            <li class="list-group-item">
                                                <strong>Email Address:</strong>
                                                {{ Str::lower($student->email ?? 'N/A') }}
                                            </li>
                                            <li class="list-group-item">
                                                <strong>Phone Number:</strong>
                                                {{ $student->student->phone ?? 'N/A' }}
                                            </li>
                                            <li class="list-group-item">
                                                <strong>Gender:</strong>
                                                {{ Str::upper($student->student->gender ?? 'N/A') }}
                                            </li>
                                            <li class="list-group-item">
                                                <strong>Martial Status:</strong>
                                                {{ Str::upper($student->student->marital_status ?? 'N/A') }}
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6">
                                        <ul class="list-group">
                                            <li class="list-group-item">
                                                <strong>Religion:</strong>
                                                {{ $student->student->religion ?? 'N/A' }}
                                            </li>
                                            <li class="list-group-item">
                                                <strong>Date of Birth:</strong>
                                                {{ $student->student->dob ?? 'N/A' }}
                                            </li>
                                            <li class="list-group-item">
                                                <strong>Genotype:</strong>
                                                {{ $student->student->genotype ?? 'N/A' }}
                                            </li>
                                            <li class="list-group-item">
                                                <strong>Blood Group:</strong>
                                                {{ $student->student->blood_group ?? 'N/A' }}
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                Secondary Education
                            </div>
                            <div class="card-body">
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        <strong>Secondary School:</strong>
                                        {{ Str::title($student->student->secondary_school_attended ?? 'N/A') }}
                                    </li>
                                    <li class="list-group-item">
                                        <strong>Graduation Year:</strong>
                                        {{ $student->student->secondary_school_graduation_year ?? 'N/A' }}
                                    </li>
                                    <li class="list-group-item">
                                        <strong>Certificate Type:</strong>
                                        {{ Str::upper($student->student->secondary_school_certificate_type ?? 'N/A') }}
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                JAMB Information
                            </div>
                            <div class="card-body">
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        <strong>JAMB Reg No:</strong>
                                        {{ $student->student->jamb_reg_no ?? 'N/A' }}
                                    </li>
                                    <li class="list-group-item">
                                        <strong>JAMB Score:</strong>
                                        {{ $student->student->jamb_score ?? 'N/A' }}
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                Address Information
                            </div>
                            <div class="card-body">
                                <p><strong>Permanent Address:</strong></p>
                                <blockquote>{{ Str::title($student->student->permanent_residence_address ?? 'N/A') }}</blockquote>
                                <p><strong>Current Address:</strong></p>
                                <blockquote>{{ Str::title($student->student->current_residence_address ?? 'N/A') }}</blockquote>
                                <p><strong>COUNTRY:</strong></p>
                                <blockquote>{{ Str::upper($student->student->country_of_origin ?? 'N/A') }}</blockquote>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                Guardian Information
                            </div>
                            <div class="card-body">
                                <p><strong>Guardian Name:</strong></p>
                                <blockquote>{{ Str::title($student->student->guardian_name ?? 'N/A') }}</blockquote>
                                <p><strong>Guardian Phone Number:</strong></p>
                                <blockquote>{{ Str::title($student->student->guardian_phone_number ?? 'N/A') }}</blockquote>
                                <p><strong>Guardian Address:</strong></p>
                                <blockquote>{{ Str::title($student->student->guardian_address ?? 'N/A') }}</blockquote>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                Student Documents
                            </div>
                            <div class="card-body">
                                @foreach ($documents as $label => $doc)
                                    <div class="mb-3">
                                        @if (Str::title(str_replace('_', ' ', $label)) == 'Local Government Identification')
                                            <strong>Jamb Result</strong>
                                        @else
                                            {{ Str::title(str_replace('_', ' ', $label)) }}:
                                        @endif
                                        @if ($doc['exists'])
                                            @if ($doc['isPdf'])
                                                <a href="{{ $doc['filePath'] }}" class="mt-2 btn btn-primary"
                                                    target="_blank">Open PDF in New Tab</a>
                                            @else
                                                <button class="mt-2 btn btn-success"
                                                    onclick="showImage('{{ $doc['filePath'] }}')">View Image</button>
                                            @endif
                                        @else
                                            <span class="text-danger">Not Available</span>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Document Image</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <img src="" alt="Document Image" class="img-fluid">
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
    <script>
        function showImage(src) {
            const modal = $('#imageModal');
            modal.find('img').attr('src', src);
            modal.modal('show');
        }
    </script>
@endsection

