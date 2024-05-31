@extends('admin.layouts.adminLayout')

@section('title', 'Application Details')

@section('css')
    <style>
        .application-details {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
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
                <div class="application-details card shadow">
                    <h2>User Details</h2>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Name:</strong> {{ $application->user->full_name }}</p>
                            <p><strong>Email:</strong> {{ $application->user->email }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Scholarship:</strong> {{ $application->scholarship->name }}</p>
                            <p><strong>Status:</strong> {{ $application->status }}</p>
                        </div>
                    </div>

                    <hr>

                    <h2>Application Answers</h2>
                    @forelse ($application->answers as $answer)
                        <div class="row">
                            <div class="col-md-6">
                                <p>  <strong>{{ $loop->iteration }}.
                                    <span class="text-danger">Questions: </span> <br>
                                     {{ $answer->question->question_text }}</strong></p>
                            </div>
                            <div class="col-md-6">
                                <p><span class="text-info">Answer: </span> <br> {{ $answer->answer_text }}</p>
                            </div>
                        </div>
                        <hr>

                    @empty
                        <p>No answers provided.</p>
                    @endforelse
                </div>
            </div>
        </section>
    </div>
@endsection

@section('js')
@endsection