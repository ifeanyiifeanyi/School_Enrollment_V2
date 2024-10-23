@extends('admin.layouts.adminLayout')

@section('title', 'Acceptance Fee Manager')

@section('css')
    @include('admin.acceptanceFees.print_style')
@endsection

@section('admin')
    <div class="main-content">
        <section class="section">
            <!-- Regular view header -->
            <div class="section-header no-print">
                <h1>@yield('title')</h1>
                <div class="section-header-button">
                    <button onclick="window.print()" class="btn btn-primary">
                        <i class="fas fa-print"></i> Print Report
                    </button>
                </div>
            </div>

            <!-- Print-specific header -->
            <div class="print-header print-only" style="display: none;">
                <div class="text-center">
                    <img src="{{ asset('logo1.png') }}" alt="School Logo" style="height: 80px;">
                    <h2>YOUR INSTITUTION NAME</h2>
                    <h3>Acceptance Fee Payment Report</h3>
                    <p>Generated on: {{ now()->format('F d, Y h:i A') }}</p>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-md-12">
                        <!-- Statistics Cards -->
                        <div class="stats-cards">
                            <div class="stats-card">
                                <h4>Summary</h4>
                                <div class="row">
                                    <div class="col-md-6">
                                        <h5>Total Students Paid</h5>
                                        <h2>{{ $acceptanceFeeCount }}</h2>
                                    </div>
                                    <div class="col-md-6">
                                        <h5>Total Amount Collected</h5>
                                        <h2>₦{{ number_format($totalAmount, 2) }}</h2>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Search and Export forms (no-print) -->
                        <!-- [Previous search and export forms code remains the same] -->

                        <!-- Main Table -->

                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>SN</th>
                                        <th>Student</th>
                                        <th>Jamb</th>
                                        {{-- <th>Department</th> --}}
                                        <th>Amount</th>
                                        {{-- <th>Transaction ID</th> --}}
                                        <th>Date</th>
                                        <th>Status</th>
                                        {{-- <th class="no-print">Action</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($acceptanceFees as $acceptance)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ Str::title($acceptance->user->full_name) }}</td>
                                            <td>{{ Str::title($acceptance->user->student->jamb_reg_no) }}</td>
                                            {{-- <td>{{ $acceptance->department }}</td> --}}
                                            <td>₦{{ number_format($acceptance->amount, 2) }}</td>
                                            {{-- <td>{{ $acceptance->transaction_id }}</td> --}}
                                            <td>{{ $acceptance->paid_at ? $acceptance->paid_at->format('M d, Y H:i') : 'Not paid' }}
                                            </td>
                                            <td>
                                                @if ($acceptance->status == 'paid')
                                                    <span class="badge badge-success">PAID</span>
                                                @elseif($acceptance->status == 'pending')
                                                    <span class="badge badge-warning">PENDING</span>
                                                @elseif($acceptance->status == 'expired')
                                                    <span class="badge badge-danger">EXPIRED</span>
                                                @endif
                                            </td>
                                            {{-- <td class="no-print">
                                                        <!-- [Previous action buttons code remains the same] -->
                                                    </td> --}}
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9">
                                                <div class="alert alert-danger">No acceptance fees found</div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="4" class="text-right"><strong>Total:</strong></td>
                                        <td colspan="5"><strong>₦{{ number_format($totalAmount, 2) }}</strong></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>



                        <!-- Print footer -->
                        <div class="print-footer print-only" style="display: none;">
                            <p>Page <span class="page-number"></span></p>
                            <p>Report generated by: {{ auth()->user()->name }}</p>
                            <p>{{ now()->format('F d, Y h:i A') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
