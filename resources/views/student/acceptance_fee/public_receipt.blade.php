@extends('student.layouts.studentLayout')

@section('title', 'Verify Acceptance Fee Payment')

@section('css')
    <style>
        .verification-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            font-family: Arial, sans-serif;
        }

        .verification-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .school-logo {
            max-width: 100px;
            margin-bottom: 10px;
        }

        .verification-details {
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        th {
            text-align: left;
        }

        .verification-status {
            text-align: center;
            font-size: 1.2em;
            font-weight: bold;
            margin-top: 20px;
        }

        .status-verified {
            color: #28a745;
        }

        .status-pending {
            color: #ffc107;
        }

        .status-not-found {
            color: #dc3545;
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
        }
    </style>
@endsection

@section('student')
    <div class="verification-container">
        <div class="verification-header">
            <img src="{{ asset('logo1.png') }}" alt="Shanahan University Logo" class="school-logo">
            <h2>Shanahan University</h2>
            <h3>Acceptance Fee Payment Verification</h3>
        </div>

        <div class="verification-status status-{{ $status }}">
            {{ $message }}
        </div>

        @if ($status === 'verified' || $status === 'pending')
            <div class="verification-details">
                <table>
                    <tr>
                        <th>Student Name:</th>
                        <td>{{ $user->full_name }}</td>
                    </tr>
                    <tr>
                        <th>Student ID:</th>
                        <td>{{ $user->student->application_unique_number }}</td>
                    </tr>
                    <tr>
                        <th>Amount:</th>
                        <td>₦{{ number_format($acceptanceFee->amount, 2) }}</td>
                    </tr>
                    <tr>
                        <th>Transaction ID:</th>
                        <td>{{ $acceptanceFee->transaction_id }}</td>
                    </tr>
                    <tr>
                        <th>Payment Date:</th>
                        <td>{{ $acceptanceFee->paid_at ? $acceptanceFee->paid_at->format('F d, Y H:i:s') : 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Status:</th>
                        <td>{{ ucfirst($acceptanceFee->status) }}</td>
                    </tr>
                </table>
            </div>

            @if ($status === 'verified')
                <button onclick="window.print()" class="print-button">Print Verification</button>
            @endif
        @endif
    </div>
@endsection

@section('js')
    <script>
        // You can add any additional JavaScript here if needed
    </script>
@endsection
