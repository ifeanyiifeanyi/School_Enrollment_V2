@extends('student.layouts.studentLayout')

@section('title', 'Scholarship Status')
@section('css')
    <style>
        .print-button {
            margin-top: 20px;
        }

        @media print {
            .no-print {
                display: none;
            }
            .document{
                border: none !important;
                box-shadow: none !important;
            }
            .notice{
                display: none !important;
            }
        }

        .container {
            margin-top: 50px;
            margin-bottom: 50px;
        }

        .document {
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 40px;
            position: relative;
            overflow: hidden;
            position: relative;
            overflow: hidden;

        }

        .document::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 10px;
            background: linear-gradient(to right, #3498db, #2980b9);
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo {
            max-width: 150px;
            margin-bottom: 20px;
        }

        .student-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }

        .passport-photo {
            width: 150px;
            height: 200px;
            object-fit: cover;
            border: 1px solid #ddd;
        }

        .status {
            font-size: 1.2em;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .notice {
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            border-radius: 5px;
            padding: 15px;
            margin-top: 20px;
            opacity: none;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 0.9em;
            color: #6c757d;
        }

        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            opacity: 0.1;
            z-index: 0;
            pointer-events: none;
            width: 60%;
            height: auto;

        }
    </style>
@endsection


@section('student')
    <section class="content">
        <div class="container mt-5">
            @if (session('success'))
                <div class="alert alert-success no-print">
                    {{ session('success') }}
                </div>
            @endif
            <div class="container">
                <div class="row">
                    <div class="mx-auto col-md-7">
                        <div class="document">
                            <img src="{{ asset('logo1.png') }}" alt="Watermark" class="mt-5 watermark">

                            <div class="header">
                                <img src="{{ asset('logo1.png') }}" alt="University Logo" class="logo">
                                <h2>Scholarship Application Details</h2>
                            </div>

                            <div class="student-info">
                                <div>
                                    <h4>Student Information</h4>
                                    <p><strong>Name:</strong> {{ Str::title(auth()->user()->full_name) }}</p>
                                    <p><strong>Student ID:</strong>
                                        {{ auth()->user()->student->application_unique_number ?? 'N/A' }}</p>
                                    {{-- <p><strong>Department:</strong>
                                        {{ auth()->user()->applications->first()->department->name ?? 'N/A' }}</p> --}}
                                    <p><strong>Email:</strong> {{ Str::lower(auth()->user()->email ?? 'N/A') }}</p>
                                    <p><strong>Phone:</strong> {{ auth()->user()->student->phone ?? 'N/A' }}</p>
                                </div>
                                <img src="{{ asset(auth()->user()->student->passport_photo) }}" alt="Passport Photo"
                                    class="passport-photo">
                            </div>

                            <div class="status">
                                Application Status:
                                @if ($application->status == 'pending')
                                    <span class="text-primary">Under Review</span>
                                @elseif($application->status == 'approved')
                                    <span class="text-success">Approved</span>
                                @elseif($application->status == 'denied')
                                    <span class="text-danger">Denied</span>
                                @else
                                    <span class="text-warning">Pending</span>
                                @endif
                            </div>

                            <p>Dear {{ Str::title(auth()->user()->full_name) }},</p>

                            @if ($application == 'under_review' || $application == 'pending')
                                <p>We have received your scholarship application for the academic year 2024-2025. Our team
                                    is
                                    currently reviewing your application and supporting documents.</p>
                            @elseif($application == 'approved')
                                <p>Congratulations! We are pleased to inform you that your scholarship application for the
                                    academic
                                    year 2024-2025 has been approved.</p>
                            @elseif($application == 'denied')
                                <p>Thank you for your scholarship application for the academic year 2024-2025. After careful
                                    consideration, we regret to inform you that your application has not been approved at
                                    this time.
                                </p>
                            @endif
                            @if ($application->status == 'pending')
                                <div class="mb-3 notice">
                                    <h5><i class="fas fa-exclamation-triangle"></i> Important Notice</h5>
                                    <p>Please be aware that the scholarship only covers tuition fees. Other expenses such as
                                        accommodation, books, and living costs are not included.</p>
                                </div>
                            @endif
                            @if ($application->status == 'under_review' || $application->status == 'pending')
                                <p>The status of your application will be communicated via your registered email address. We
                                    strongly recommend that you regularly log in to your student dashboard to check for any
                                    updates
                                    or additional requirements.</p>
                            @elseif($application->status == 'approved')
                                <p style="color: rgb(3, 165, 165)">Congratulations on your outstanding achievement! We are
                                    thrilled
                                    to inform you that your scholarship application has been successfully received. This
                                    scholarship
                                    covers your tuition fees, ensuring that you can focus entirely on your studies without
                                    financial
                                    concerns. </p>

                                <p> We highly recommend printing a copy of this acceptance offer for your records. We are
                                    proud of
                                    your accomplishments and look forward to supporting your academic journey. Keep up the
                                    excellent
                                    work and continue striving for excellence. Congratulations once again on this remarkable
                                    milestone!</p>
                            @elseif($application->status == 'denied')
                                <p>If you have any questions about the decision or would like feedback on your application,
                                    please
                                    don't hesitate to contact the Scholarship Office. We encourage you to explore other
                                    financial
                                    aid options and wish you the best in your academic pursuits.</p>
                            @endif

                            <p>If you have any questions or need to provide additional information, please don't hesitate to
                                contact
                                the Scholarship Office at <b>{{ Str::lower($siteSetting->email) }}</b>.</p>

                            <div class="footer">
                                <p>{{ config('app.name') }} | {{ Str::lower($siteSetting->email ?? '') }} |
                                    {{ $siteSetting->phone ?? '' }}</p>
                            </div>

                            @if ($application->status == 'approved')
                                <div class="text-center print-button no-print">
                                    <button onclick="window.print()" class="btn btn-primary">Print Scholarship
                                        Approval</button>
                                </div>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


@section('js')

@endsection
