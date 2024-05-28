@extends('admin.layouts.adminLayout')

@section('title', 'View Scholarship Details')

@section('css')

@endsection

@section('admin')

    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>@yield('title')</h1>
            </div>

            <div class="section-body">
                <div class="col-md-8 mx-auto">
                    <div class="card">
                        <div class="card-body shadow p-3">
                            <h3>{{ Str::title($scholarship->name) }}</h3>
                            <hr>
                            <p>{!! e($scholarship->description ?? 'N/A') !!}</p>
                        </div>
                    </div>
                    @if ($scholarship->questions->isNotEmpty())
                        <div class="card">
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
                                            </div>
                                            <span
                                                class="badge badge-info">{{ ucfirst(str_replace('-', ' ', $question->type)) }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                </div>
            @else
                <div class="alert alert-danger">No Questions At The Moment</div>
                @endif
            </div>
    </div>
    </section>
    </div>
@endsection



@section('js')

@endsection
