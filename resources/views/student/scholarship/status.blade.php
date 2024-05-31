@extends('student.layouts.studentLayout')

@section('title', 'Scholarship Status')
@section('css')

@endsection


@section('student')
    <section class="content">
        <div class="container mt-5">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <h1 class="text-center">Application Status</h1>


            <div class="row">
                <div class="col-md-5 mx-auto">
                    <div class="card">
                        <center>
                            <i class="fas fa-spinner fa-spin fa-5x mt-3 mb-3 text-success"></i>
                        </center>
                        <h4 class="mb-0 text-center">Scholarship</h4>
                        <p class="text-muted text-center">{{ $application->scholarship->name }}</p>
                        {{-- <p class="p-3 text-muted">
                            {{ $application->scholarship->description ?? 'N/A' }}
                        </p> --}}
                        <div class="card-body">
                            <p style="font-size: 20px; text-align:center">Status: <span
                                    class="badge badge-{{ $application->status == 'approved' ? 'success' : ($application->status == 'pending' ? 'warning' : 'danger') }}">{{ ucfirst($application->status) }}</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>


        </div>

    </section>
@endsection


@section('js')

@endsection
