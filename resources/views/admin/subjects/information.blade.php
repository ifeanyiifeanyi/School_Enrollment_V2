@extends('admin.layouts.adminLayout')

@section('title', 'Subjects Information')

@section('css')

@endsection

@section('admin')

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>@yield('title')</h1>
        </div>

        <div class="section-body">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 mx-auto">
                        <div class="card shadow">
                            <div class="card-header text-center">
                                <h2><u>{{ Str::title($exam->department->name) }}</u></h2>
                            </div>
                            <div class="card-body">
                                <h5>Exam Subjects</h5>
                                <ul>
                                    @forelse (json_decode($exam->exam_subject) as $subject)
                                    <li>{{ Str::title($subject) }}</li>
                                    @empty
                                    <li class="alert-alert-danger">No available</li>
                                    @endforelse
                                </ul>
                            </div>
                            <div class="card-footer">
                                <h5>Venue/Location</h5>
                                <p>{{ Str::title($exam->venue) }}</p>
                                <p class="float-right">
                                    <a href="{{ route('admin.exam.details') }}" class="btn btn-outline-info">
                                        <i class="fas fa-arrow-left"></i>
                                    </a>
                                </p>
                            </div>
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