@extends('student.layouts.studentLayout')

@section('title', 'Payment Success')

@section('css')
<style>
    @media print {

        .callout,
        .btn-primary,
        card-header,
        .print-hide {
            display: none !important;
        }
    }
</style>
@endsection

@section('student')
<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">

                <div class="card-body">

                    <div class="row">
                        <div class="col-md-4 text-center mb-4">
                            <div class="mb-3">
                                <img width="200" src="{{ Storage::url($user->student->passport_photo) }}"
                                    class="img-fluid" alt="Passport Photo">
                            </div>
                            <!-- Barcode Image -->
                            <div class="text-center mb-4">
                                <img src="data:image/png;base64,{{ \DNS2D::getBarcodePNG($barcodeUrl, 'QRCODE',6,6) }}"
                                    alt="barcode" />
                            </div>

                        </div>
                        <div class="col-md-8">
                            <ul class="list-group">
                                <li class="list-group-item">Invoice Number: {{ $application->invoice_number }}</li>
                                <li class="list-group-item">Application Number: {{
                                    $user->student->application_unique_number }}</li>
                                <li class="list-group-item">Full Name: {{ $user->fullName }}</li>
                                <li class="list-group-item">Application Date: {{ $application->created_at->format('jS F,
                                    Y') }}</li>
                                <li class="list-group-item">Department: {{ $application->department->name }}</li>
                                <li class="list-group-item">Faculty: {{ $application->department->faculty->name }}</li>
                                <li class="list-group-item">
                                    Admission Status:
                                    @if ($application->admission_status == 'pending')
                                    <span class="badge rounded-pill"
                                        style="background: linear-gradient(to right, #ffa500, #ff6f00); color: #ffffff;">{{
                                        $application->admission_status }}</span>
                                    @elseif ($application->admission_status == 'denied')
                                    <span class="badge rounded-pill"
                                        style="background: linear-gradient(to right, #ff5f6d, #ffc371); color: #ffffff;">{{
                                        $application->admission_status }}</span>
                                    @elseif ($application->admission_status == 'approved')
                                    <span class="badge rounded-pill"
                                        style="background: linear-gradient(to right, #00b09b, #96c93d); color: #ffffff;">{{
                                        $application->admission_status }}</span>
                                    @endif
                                </li>
                                <li class="list-group-item"><b>Exam Score: </b>
                                    @if (empty($user->student->exam_score) || $user->student->exam_score == null)
                                    &nbsp;<i class="print-hide fa fa-spinner fa-spin text-primary"></i>
                                    @else
                                    <code>{{ $user->student->exam_score }}</code>
                                    @endif
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="mt-3">
                        <button onclick="window.print()" class="btn btn-primary">Print Details</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection