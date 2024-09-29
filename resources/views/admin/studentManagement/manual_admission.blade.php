@extends('admin.layouts.adminLayout')

@section('title', 'Admission Manual Manager')

@section('css')

@endsection

@section('admin')

    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>@yield('title')</h1>
            </div>

            <div class="section-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>sn</th>
                                <th>Student Name</th>
                                <th>Department</th>
                                <th>Payment Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pendingApplications as $application)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $application->user->full_name }}</td>
                                <td>{{ $application->department->name }}</td>
                                <td>{{ $application->payment ? $application->payment->payment_status : 'No Payment Record' }}</td>
                                <td>
                                    <form action="{{ route('admin.approve.admission', $application->id) }}" method="POST">
                                        @csrf
                                        <button onclick="return confirm('Are you sure of this action ?')" type="submit" class="btn btn-success">Approve Admission</button>
                                    </form>
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

@endsection
