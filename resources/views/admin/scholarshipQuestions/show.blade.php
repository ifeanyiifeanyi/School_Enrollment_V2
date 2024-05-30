@extends('admin.layouts.adminLayout')

@section('title', 'Scholarship Questions')

@section('css')
    <!-- Add any custom CSS here -->
@endsection

@section('admin')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>@yield('title')</h1>
            </div>

            <div class="section-body">
                <div class="container">
                    <a href="{{ route('admin.scholarship.question.view') }}" class="btn btn-primary btn-sm mb-4">Back</a>

                    <div class="row mb-4">
                        <div class="col">
                            <h1 class="text-center">Scholarship Questions</h1>
                        </div>
                    </div>

                    @foreach ($scholarships as $scholarship)
                        @if ($scholarship->questions->isNotEmpty())
                            <div class="card mb-4 shadow">

                                <div class="card-header bg-primary text-white">
                                    <p>
                                        <a href="" class="btn btn-warning mb-2"><i class="fas fa-edit"></i> </a> <br>
                                        <a href="" class="btn btn-danger"><i class="fas fa-trash"></i> </a>
                                    </p>
                                    &nbsp;&nbsp;
                                    <h5 class="mb-0">{{ Str::title($scholarship->name) }}</h5>
                                </div>
                                <div class="card-body">
                                    <ul class="list-group">
                                        @foreach ($scholarship->questions as $question)
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                <div>
                                                    <h6 class="mb-1">{{ $question->question_text }}</h6>
                                                    @if ($question->type !== 'text')
                                                        <small>Options:</small>
                                                        <ul class="list-inline mb-0">
                                                            @foreach ($question->options as $option)
                                                                <li class="list-inline-item badge badge-secondary">
                                                                    {{ $option }}</li>
                                                            @endforeach
                                                        </ul>
                                                    @endif
                                                    <div class="m-1">
                                                        <a href="" class="btn btn-warning btn-sm"><i
                                                                class="fas fa-edit"></i></a>

                                                        <a href="" class="btn btn-danger btn-sm"><i
                                                                class="fas fa-trash"></i></a>

                                                    </div>
                                                </div>

                                                <span
                                                    class="badge badge-info">{{ ucfirst(str_replace('-', ' ', $question->type)) }}</span>

                                            </li>
                                        @endforeach

                                    </ul>
                                </div>
                            </div>
                        @else
                            <div class="alert alert-danger">No Questions At The Moment</div>
                        @endif
                    @endforeach

                </div>
            </div>
        </section>
    </div>
@endsection

@section('js')
    <!-- Add any custom JS here -->
@endsection
