<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Acceptance Fee Payment</title>

    <!-- Internal CSS section retained -->
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
</head>

<body>

    <header>
        <h1>Shanahan University</h1>
    </header>

    <main>
        <section>
            <h2>Acceptance Fee Payment Verification</h2>

            <p>{{ $message }}</p>

            @if ($status === 'verified' || $status === 'pending')
                <div class="payment-details">
                    <p><strong>Student Name:</strong> {{ $user->full_name }}</p>
                    <p><strong>Student ID:</strong> {{ $user->student->application_unique_number }}</p>
                    <p><strong>Amount:</strong> ₦{{ number_format($acceptanceFee->amount, 2) }}</p>
                    <p><strong>Transaction ID:</strong> {{ $acceptanceFee->transaction_id }}</p>
                    <p><strong>Payment Date:</strong>
                        {{ $acceptanceFee->paid_at ? $acceptanceFee->paid_at->format('F d, Y H:i:s') : 'N/A' }}</p>
                    <p><strong>Status:</strong> {{ ucfirst($acceptanceFee->status) }}</p>
                </div>
            @endif

            @if ($status === 'verified')
                <button onclick="window.print()">Print Verification</button>
            @endif
        </section>
    </main>

    <!-- Internal JS section retained if any -->
    <script>
        // Add any internal JavaScript or jQuery here
    </script>

</body>

</html>
