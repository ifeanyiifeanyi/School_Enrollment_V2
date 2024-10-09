@extends('student.layouts.studentLayout')

@section('title', 'Acceptance Fee Receipt')

@section('css')
<style>
    .receipt {
        max-width: 600px;
        margin: 0 auto;
        padding: 20px;
        border: 1px solid #ddd;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
        font-family: Arial, sans-serif;
    }
    .receipt-header {
        text-align: center;
        margin-bottom: 20px;
    }
    .school-logo {
        max-width: 100px;
        margin-bottom: 10px;
    }
    .receipt-body {
        margin-bottom: 20px;
    }
    .receipt-footer {
        text-align: center;
        font-size: 0.9em;
        color: #666;
    }
    .qr-code {
        text-align: center;
        margin-top: 20px;
    }
    table {
        width: 100%;
        border-collapse: collapse;
    }
    th, td {
        padding: 10px;
        border-bottom: 1px solid #ddd;
    }
    th {
        text-align: left;
    }
    .print-button {
        display: block;
        width: 100%;
        padding: 10px;
        background-color: #007bff;
        color: white;
        text-align: center;
        text-decoration: none;
        border: none;
        cursor: pointer;
        font-size: 16px;
        margin-top: 20px;
    }
    @media print {
        .print-button {
            display: none;
        }
        body * {
            visibility: hidden;
        }
        .receipt, .receipt * {
            visibility: visible;
        }
        .receipt {
            position: absolute;
            left: 0;
            top: 0;
        }
    }
</style>
@endsection

@section('student')
<div class="receipt">

    <div class="receipt-header">
        <img src="{{ asset('logo1.png') }}" alt="Shanahan University Logo" class="school-logo">
        <h2>Shanahan University</h2>
        <h3>Acceptance Fee Payment Receipt</h3>
    </div>
    <div class="receipt-body">
        <table>
            <tr>
                <th>Student Name:</th>
                <td>{{ Str::title($user->full_name) }}</td>
            </tr>
            <tr>
                <th>Student ID:</th>
                <td>{{ $user->student->application_unique_number }}</td>
            </tr>
            <tr>
                <th>Amount Paid:</th>
                <td>₦{{ number_format($acceptanceFee->amount, 2) }}</td>
            </tr>
            <tr>
                <th>Transaction ID:</th>
                <td>{{ $acceptanceFee->transaction_id }}</td>
            </tr>
            <tr>
                <th>Payment Date:</th>
                <td>{{ $acceptanceFee->paid_at->format('F d, Y H:i:s') }}</td>
            </tr>
            {{-- <tr>
                <th>Academic Year:</th>
                <td>{{ $acceptanceFee->academic_year }}</td>
            </tr>
            <tr>
                <th>Department:</th>
                <td>{{ $acceptanceFee->department }}</td>
            </tr> --}}
        </table>
    </div>
    <div class="qr-code">
        {!! QrCode::size(200)->generate(route('student.acceptancefee.verify', $acceptanceFee->transaction_id)) !!}
        <p>Scan to verify payment</p>
    </div>
    <div class="receipt-footer">
        <p>Thank you for your payment. Please keep this receipt for your records.</p>
    </div>
    <button onclick="window.print()" class="print-button">Print Receipt</button>
</div>
@endsection

@section('js')
<script>
    // You can add any additional JavaScript here if needed
</script>
@endsection
