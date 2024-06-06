@extends('admin.layouts.adminLayout')

@section('title', 'Manage Student Application Payment')

@section('css')

@endsection

@section('admin')

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>@yield('title')</h1>
        </div>

        <div class="section-body">
            <div class="p-3 shadow card">
                <div class="table-responsive">
                    <table class="table table-bordered" id="example1" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Student Name</th>
                                <th>Transaction Id</th>
                                <th>Payment Type</th>
                                <th>Invoice No.</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($payments as $payment)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    {{ $payment->user->full_name ?? 'N/A' }}
                                    <p class="text-muted">{{ $payment->user->student->application_unique_number ?? 'N/A' }}</p>
                                </td>
                                <td>{{ $payment->transaction_id ?? 'N/A' }}</td>
                                <td>{{ $payment->payment_method ?? 'N/A' }}</td>
                                <td>{{ $payment->application->invoice_number ?? 'N/A' }}</td>
                                <td>
                                    @if ($payment->payment_status == 'successful')
                                        <p class="badge badge-success">Successful <i class="fas fa-user-check"></i></p>
                                    @else
                                    <p class="badge badge-danger">Error! <i class="fas fa-user-slash"></i></p>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="text-center pagination paginate d-flex justify-content-center">
                {{ $payments->links() }}
            </div>
        </div>
</div>
</section>
</div>
@endsection



@section('js')

@endsection
