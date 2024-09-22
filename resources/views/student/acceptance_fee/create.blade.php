@extends('student.layouts.studentLayout')

@section('title', 'Pay Acceptance Fee')

@section('css')
    <style>
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            font-size: 16px;
            line-height: 24px;
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color: #555;
        }

        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
        }

        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }

        .invoice-box table tr td:nth-child(2) {
            text-align: right;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }

        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }

        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }
    </style>
@endsection

@section('student')
    <section class="content">
        <div class="row">
            <div class="col-md-8 mx-auto">
                @include('student.alert')
                <div class="invoice-box">
                    <table cellpadding="0" cellspacing="0">
                        <tr class="top">
                            <td colspan="">
                                <table>
                                    <tr>
                                        <td>
                                            <h2>Shanahan University</h2>
                                            <strong>Acceptance Fee Invoice</strong><br>
                                            Invoice #: {{ date('YmdHis') }}<br>
                                            Created: {{ date('F d, Y') }}<br>
                                        </td>
                                        <td>
                                            <img src="{{ asset('logo1.png') }}" alt="Logo" class="w-25 img-responsive img-fluid">
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>

                        <tr class="information">
                            <td colspan="2">

                                <table>
                                    <tr>
                                        <td>
                                            Student Name: {{ auth()->user()->full_name }}<br>
                                            Student ID: {{ auth()->user()->student->application_unique_number }}<br>
                                            Email: {{ auth()->user()->email }}
                                        </td>
                                        <td>
                                            Shanahan University<br>
                                            Basilica Of The Holy Trinity, Onitsha<br>
                                            Anambra State, NG
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>

                        <tr class="heading">
                            <td>Item</td>
                            <td>Price</td>
                        </tr>

                        <tr class="details">
                            <td>Acceptance Fee</td>
                            <td>₦40,000.00</td>
                        </tr>
                        <tr class="details">
                            <td>Payment service charge</td>
                            <td>₦450</td>
                        </tr>

                        <tr class="total">

                            <td colspan="2">Total: ₦40, 450.00</td>
                        </tr>
                    </table>

                    <form action="{{ route('student.pay.acceptance.fee') }}" method="post" class="mt-4">
                        @csrf
                        <input type="hidden" value="{{ auth()->user()->applications->first()->department_id }}" name="department_id">
                        <div class="form-group">
                            <button onclick="return confirm('Click yes to proceed with payment')" type="submit" class="btn btn-primary btn-block">Pay Now</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
    <script>
        // Add any necessary JavaScript here
    </script>
@endsection
