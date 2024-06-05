@extends('admin.layouts.adminLayout')

@section('title', 'Applications for ' . $academicSession->session)

@section('admin')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>@yield('title')</h1>
            </div>

            <div class="section-body">
                <div class="card">
                    <div class="card-body">
                        <a href="{{ route('admin.academicSession.view') }}" class="btn btn-info mb-2">Back</a>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Student</th>
                                        <th>Application No.</th>
                                        <th>Department</th>
                                        <th>Status</th>
                                        <!-- Add more columns as needed -->
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($applications as $application)
                                        <tr>
                                            <td>{{ $application->user->full_name }}</td>
                                            <td>{{ $application->user->student->application_unique_number }}</td>
                                            <td>{{ Str::title($application->department->name) }}</td>
                                            <td>{{ $application->admission_status}}</td>
                                            <!-- Add more columns as needed -->
                                        </tr>
                                    @empty
                                    <div class="alert alert-danger">No Applications for this Session</div>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
