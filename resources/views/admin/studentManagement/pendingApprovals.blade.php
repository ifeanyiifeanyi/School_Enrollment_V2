@extends('admin.layouts.adminLayout')

@section('title', 'Pending Applications')

@section('css')
    <style>
        .table thead th {
            background-color: #f8f9fa;
            text-align: center;
            vertical-align: middle;
        }

        .table tbody td {
            vertical-align: middle;
        }

        .table td,
        .table th {
            white-space: normal;
            word-wrap: break-word;
        }

        .btn {
            margin-right: 5px;
        }

        .btn:last-child {
            margin-right: 0;
        }

        .actions form {
            display: inline-block;
        }
    </style>
@endsection

@section('admin')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>@yield('title')</h1>
            </div>
            <form action="{{ route('admin.search.pending.approvals') }}" method="GET" class="mb-4">
                <div class="input-group">
                    <input type="text" class="form-control" name="search"
                        placeholder="Search by name, email, department, transaction ID, or invoice number"
                        value="{{ request('search') }}">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="submit">Search</button>
                    </div>
                </div>
            </form>

            <div class="section-body">
                <h2 class="mb-4">Pending Approvals</h2>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover w-100" id="example">
                        <thead class="thead-light">
                            <tr>
                                <th>SN</th>
                                <th>Student Name</th>
                                <th>Department</th>
                                <th>Transaction ID</th>
                                <th>Payment Method</th>
                                <th>Invoice Number</th>
                                <th>Amount</th>
                                <th>Payment Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- @dd($pendingApplications) --}}
                            @foreach ($pendingApplications as $application)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <th>{{ $application->user->full_name }}</th>
                                    <td>{{ $application->department->name }}</td>
                                    <td>{{ $application->transaction_id ?? 'N/A' }}</td>
                                    <td>{{ $application->paymentMethod->name ?? 'N/A' }}</td>
                                    <td>{{ $application->invoice_number ?? 'N/A' }}</td>
                                    <td>{{ $application->amount ?? 'N/A' }}</td>
                                    <td>{{ $application->payment->payment_status ?? 'Pending' }}</td>
                                    <td class="actions">
                                        <div class="btn-group">
                                            <form onsubmit="return confirm('are you sure of this action')"
                                                action="{{ route('admin.approve.application', $application->id) }}"
                                                method="POST" style="display: inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm mr-1">Approve</button>
                                            </form>
                                            <form onsubmit="return confirm('are you sure of this action')"
                                                action="{{ route('admin.reject.application', $application->id) }}"
                                                method="POST" style="display: inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-sm">Reject</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('js')
    <!-- Add any additional JS here -->
@endsection
