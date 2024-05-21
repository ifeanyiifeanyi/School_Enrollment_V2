@extends('student.layouts.studentLayout')

@section('title', 'Payment Success')

@section('css')
<style>
    @media print {

        .callout,
        .btn-primary,
        card-header {
            display: none !important;
        }
    }
</style>
@endsection

@section('student')
<div class="container">
    <div class="callout callout-info">
        <h5><i class="fas fa-info"></i> Note:</h5>
        This page is optimized for printing. Please use the print button located at the bottom of the invoice to
        obtain a hard copy for your records and future reference.
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Payment Successful</div>

                <div class="card-body">
                    <p>Thank you, <b>{{ $user->fullName }}</b>. Your payment for the application #{{
                        $application->invoice_number }} has been processed successfully.</p>

                    <div class="row">
                        <div class="col-md-4 text-center mb-4">
                            <p><img width="200" src="{{ Storage::url($user->student->passport_photo) }}"
                                    class="img-fluid" alt="Passport Photo"></p>
                            
                                <!-- Barcode Image -->
                                <div class="text-center mb-4">
                                    <img src="data:image/png;base64,{{ \DNS2D::getBarcodePNG($barcodeUrl, 'QRCODE',6,6) }}" alt="barcode" />
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