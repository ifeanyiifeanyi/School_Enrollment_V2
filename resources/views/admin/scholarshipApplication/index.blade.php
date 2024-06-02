@extends('admin.layouts.adminLayout')

@section('title', 'Scholarship Applicants')

@section('css')
<style>
    .loader-overlay {
        display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index: 9999; /* Sit on top */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        overflow: hidden; /* Disable scroll */
        background-color: rgba(255, 255, 255, 0.8); /* White background with opacity */
    }

    .loader {
        border: 16px solid #f3f3f3; /* Light grey */
        border-top: 16px solid #3498db; /* Blue */
        border-radius: 50%;
        width: 120px;
        height: 120px;
        animation: spin 2s linear infinite;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>
@endsection

@section('admin')
<div class="main-content">
    <div class="loader-overlay" id="loader-overlay">
        <div class="loader"></div>
    </div>
    <section class="section">
        <div class="section-header">
            <h1>@yield('title')</h1>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>@yield('title')</h4>
                        </div>
                        <div class="card-body">
                            <div class="mb-3 d-flex justify-content-between">
                                {{-- Export Button --}}
                                <div>
                                    <a href="{{ route('admin.scholarship.applications.export') }}" class="btn btn-success">Export to Excel</a>
                                </div>

                                {{-- Import Form --}}
                                <div>
                                    <form id="import-form" action="{{ route('admin.scholarship.applications.import') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" name="file" class="custom-file-input" id="inputFile">
                                                <label class="custom-file-label" for="inputFile">Choose file</label>
                                            </div>
                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-primary">Import from Excel</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            {{-- Scholarship Applications Table --}}
                            <div class="table-responsive">
                                <table class="table table-striped" id="table-1">
                                    <thead>
                                        <tr>
                                            <th>SN</th>
                                            <th>Student</th>
                                            <th>Scholarship</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($applications as $application)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ Str::title($application->user->full_name) }}</td>
                                                <td>{{ Str::title($application->scholarship->name) }}</td>
                                                <td>{{ Str::title($application->status) }}</td>
                                                <td>
                                                    <a href="#" data-toggle="modal" data-target="#exampleModal" data-student-slug="" class="btn btn-danger">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                    <a title="Applicant Details" href="{{ route('admin.scholarship.applicantShow', $application->id) }}" class="btn btn-info">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <div class="alert alert-danger">No Application At The Moment</div>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-center">
                    {{ $applications->links() }}
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const importForm = document.getElementById('import-form');
        const loaderOverlay = document.getElementById('loader-overlay');

        importForm.addEventListener('submit', function() {
            loaderOverlay.style.display = 'block';
        });
    });
</script>
@endsection
