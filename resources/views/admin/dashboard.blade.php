@extends('admin.layouts.adminLayout')

@section('title', 'Admin Dashboard')

@section('css')
<style>
    .view-applications-btn {
    position: relative;
    padding: 12px 30px;
    font-size: 18px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    border-radius: 30px;
    overflow: hidden;
    transition: all 0.3s ease;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.view-applications-btn:before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(to right, #007bff, #6610f2);
    z-index: -1;
    opacity: 0;
    transform: scale(0.5, 0.5);
    transition: all 0.3s ease;
}

.view-applications-btn:hover:before {
    opacity: 1;
    transform: scale(1, 1);
}

.view-applications-btn:hover {
    color: #fff;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    transform: translateY(-2px);
}

.view-applications-btn i {
    margin-right: 8px;
    animation: spin 2s infinite linear;
}

@keyframes spin {
    0% {
        transform: rotate(0deg);
    }
    100% {
        transform: rotate(360deg);
    }
}
</style>
@endsection

@section('admin')

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>@yield('title')</h1>
        </div>

        <div class="section-body">
            <div class="text-center">
                <a href="" class="btn btn-primary btn-lg view-applications-btn mb-3">
                    <i class="fas fa-hourglass fa-spin"></i> View Active Applications
                </a>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                            <i class="fas fa-university"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Faculties</h4>
                            </div>
                            <div class="card-body">
                                {{ $facultyCount }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-danger">
                            <i class="fas fa-school"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Departments</h4>
                            </div>
                            <div class="card-body">
                                {{ $departmentCount }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-warning">
                            <i class="fas fa-users-cog"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>All Registered Students</h4>
                            </div>
                            <div class="card-body">
                                {{ $studentCount }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-success">
                            <i class="fas fa-hourglass fa-spin"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Active Application</h4>
                            </div>
                            <div class="card-body">
                                {{ $activeApplication }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Department Applications</h4>
                        </div>
                        <div class="card-body">
                            @forelse($departmentData as $data)
                            <div class="mb-4">
                                <div class="text-small float-right font-weight-bold text-muted">{{ $data->total }}</div>
                                <div class="font-weight-bold mb-1">{{ Str::title($data->department->name) }}</div>
                                <div class="progress" data-height="3">
                                    <div class="progress-bar" role="progressbar" data-width="{{ $data->percentage }}%"
                                        aria-valuenow="{{ $data->percentage }}" aria-valuemin="0" aria-valuemax="100">
                                    </div>
                                </div>
                            </div>
                            @empty

                            @endforelse
                        </div>

                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Faculty Applications</h4>
                        </div>
                        <div class="card-body">
                            @foreach($facultyData as $data)
                            <div class="mb-4">
                                <div class="text-small float-right font-weight-bold text-muted">{{ $data->total }}</div>
                                <div class="font-weight-bold mb-1">{{ $data->faculty_name }}</div>
                                <div class="progress" data-height="3">
                                    <div class="progress-bar bg-warning" role="progressbar" data-width="{{ $data->percentage }}%"
                                        aria-valuenow="{{ $data->percentage }}" aria-valuemin="0" aria-valuemax="100">
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Payment Methods Usage</h4>
                        </div>
                        <div class="card-body">
                            @foreach($paymentData as $data)
                            <div class="mb-4">
                                <div class="text-small float-right font-weight-bold text-muted">{{ $data->total }}</div>
                                <div class="font-weight-bold mb-1">{{ $data->payment_method }}</div>
                                <div class="progress" data-height="3">
                                    <div class="progress-bar bg-success" role="progressbar" data-width="{{ $data->percentage }}%"
                                        aria-valuenow="{{ $data->percentage }}" aria-valuemin="0" aria-valuemax="100">
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection



@section('js')

@endsection
