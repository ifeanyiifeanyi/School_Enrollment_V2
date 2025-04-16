@extends('student.layouts.studentLayout')

@section('title', 'Basic student layout')
@section('css')

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Merriweather:wght@300;400;700&family=Open+Sans:wght@300;400;600&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            background-color: #f0f4f8;
            color: #2c3e50;
        }

        .offer-document {
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            padding: 40px;
            margin-top: 50px;
            position: relative;
            overflow: hidden;

        }

        .offer-document::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 10px;
            background: linear-gradient(to right, #3498db, #2980b9);
        }

        .logo-placeholder {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 30px;
        }

        h1 {
            font-family: 'Merriweather', serif;
            color: #2c3e50;
            font-weight: 700;
            margin-bottom: 30px;
        }

        .lead {
            font-size: 1.1rem;
            font-weight: 400;
            margin-bottom: 25px;
        }

        .highlight {
            background-color: #f1c40f;
            padding: 2px 5px;
            border-radius: 3px;
            font-weight: 600;
        }

        .btn-accept {
            background: linear-gradient(to right, #27ae60, #2ecc71);
            border: none;
            color: white;
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-accept:hover {
            background: linear-gradient(to right, #2ecc71, #27ae60);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(46, 204, 113, 0.4);
        }

        .btn-decline {
            background: linear-gradient(to right, #e74c3c, #c0392b);
            border: none;
            color: white;
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-decline:hover {
            background: linear-gradient(to right, #c0392b, #e74c3c);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(231, 76, 60, 0.4);
        }

        .deadline-notice {
            background-color: #ecf0f1;
            border-left: 5px solid #3498db;
            padding: 15px;
            margin-top: 30px;
            border-radius: 5px;
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

        <div class="container mb-5">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="offer-document">
                        <img src="{{ asset('logo1.png') }}" alt="Watermark" class="pt-5 watermark">

                        <div class="mt-3 mb-5 logo-placeholder">
                            <img src="{{ asset('logo1.png') }}" width="120px" alt="">
                        </div>
                        <h1 class="text-center">Admission Offer</h1>
                        <p class="lead">
                            Dear <br><b>{{ $student->user->full_name }}</b>,
                        </p>
                        <p>
                            We are pleased to inform you that your application (Application Number:
                            <code>{{ $student->user->student->application_unique_number }}</code>) for admission to the
                            <span class="highlight">{{ $student->department->name }}</span> at our institution has been
                            successful.
                        </p>
                        <p>
                            Your academic achievements and personal qualities have impressed our admissions committee. We
                            believe that you will make valuable contributions to our academic community and look forward to
                            welcoming you to our campus.
                        </p>
                        <p>
                            This offer of admission is for the academic year commencing
                            {{ $student->academicSession->session }}. Please review all enclosed documents carefully for
                            important information regarding your program, enrollment procedures, and other relevant details.
                        </p>
                        <div class="deadline-notice">
                            <p class="mb-0"><strong>Important:</strong> You have <strong>20 days</strong> from the date of
                                this offer to accept or decline the admission. Failure to respond within this period will
                                result in the automatic cancellation of this offer.</p>
                        </div>
                        <div class="mt-5 text-center">
                            <form action="{{ route('student.admission.response') }}" method="POST">
                                @csrf
                                <input type="hidden" name="student_id" value="{{ $student->user_id }}">
                                <button type="submit" name="decision" value="accept"
                                    class="mb-3 btn btn-accept btn-lg me-3">Accept Offer</button>
                                <button type="button"  name="decision" value="decline"
                                    class="mb-3 btn btn-decline btn-lg">Decline Offer</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>



    </section>
@endsection


@section('js')

@endsection
