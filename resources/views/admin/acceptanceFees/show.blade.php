@extends('admin.layouts.adminLayout')

@section('title', 'Acceptance Fee Details')

@section('admin')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>@yield('title')</h1>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-img">
                                    <img src="{{ $acceptanceFee->user->student->passport_photo ?
                                    asset($acceptanceFee->user->student->passport_photo) :
                                    asset('logo1.png')
                                     }}" alt="" class="fluid thumbnail" width="80">
                                </div>
                                <h5 class="card-title">Student Information</h5>
                                <p><strong>Student ID:</strong> {{ $acceptanceFee->user->student->application_unique_number }}</p>
                                <p><strong>Name:</strong> {{ Str::title($acceptanceFee->user->full_name) }}</p>
                                <p><strong>Phone Number:</strong> {{ $acceptanceFee->user->student->phone }}</p>
                                <p><strong>Email:</strong> {{ $acceptanceFee->user->email }}</p>
                                <p><strong>Department:</strong> {{ $acceptanceFee->department }}</p>

                                <h5 class="card-title mt-4">Payment Information</h5>
                                <p><strong>Amount:</strong> ₦{{ number_format($acceptanceFee->amount, 2) }}</p>
                                <p><strong>Status:</strong> {{ $acceptanceFee->status }}</p>
                                <p><strong>Transaction ID:</strong> {{ $acceptanceFee->transaction_id }}</p>
                                <p><strong>Paid At:</strong> {{ $acceptanceFee->paid_at ? $acceptanceFee->paid_at->format('F d, Y H:i:s') : 'Not paid' }}</p>
                                <p><strong>Academic Year:</strong> {{ $acceptanceFee->academic_year }}</p>

                                <a href="{{ route('admin.acceptance_fees.index') }}" class="btn btn-primary">Back to List</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
