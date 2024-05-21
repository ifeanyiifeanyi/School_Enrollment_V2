@extends('admin.layouts.adminLayout')

@section('title', 'Admin Dashboard')

@section('css')

@endsection

@section('admin')

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>@yield('title')</h1>
        </div>

        <div class="section-body">
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