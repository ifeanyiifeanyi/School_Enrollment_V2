@extends('admin.layouts.adminLayout')

@section('title', 'Scholarship Questions')

@section('css')
    <style>
        .card-question {
            border-left: 4px solid #6777ef;
        }

        .card-question .card-header {
            background-color: #f6f6f6;
            padding: 0.5rem 1rem;
        }

        .card-question .card-body {
            padding: 0;
        }

        .question-item {
            padding: 1rem;
            border-bottom: 1px solid #e9ecef;
            position: relative;
        }

        .question-item:last-child {
            border-bottom: none;
        }

        .question-text {
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .question-options {
            margin-bottom: 0;
        }

        .question-options .badge {
            margin-right: 0.5rem;
        }

        .question-type {
            position: absolute;
            top: 1rem;
            right: 1rem;
            font-size: 0.9rem;
            font-weight: 600;
            text-transform: uppercase;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
        }

        .question-type .text {
            background-color: #28a745;
            color: #fff;
        }

        .question-type .multiple-choice,
        .question-type .single-choice {
            background-color: #ffc107 !important;
            color: #212529 !important;
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
                <div class="container">
                    <a href="{{ route('admin.scholarship.question.view') }}" class="btn btn-primary btn-sm mb-4">Back</a>

                    <div class="row mb-4">
                        <div class="col">
                            <h1 class="text-center">Scholarship Questions</h1>
                        </div>
                    </div>

                    @forelse ($scholarships as $scholarship)
                        @if ($scholarship->questions->isNotEmpty())
                            <div class="card card-question mb-4">
                                <div class="card-header">
                                    <h5 class="mb-0">{{ Str::title($scholarship->name) }}</h5>

                                </div>
                                <div class="card-body">
                                    @foreach ($scholarship->questions as $question)
                                        <div class="question-item">
                                            <p class="question-text">{{ $question->question_text }}</p>
                                            @if ($question->type !== 'text')
                                                <p class="question-options">
                                                    @foreach ($question->options as $option)
                                                        <span class="badge badge-secondary" mb-3>{{ $option }}</span>
                                                    @endforeach
                                                </p>
                                            @endif
                                            <div class="d-flex justify-content-between align-items-center">

                                                <div class="">
                                                    <a href="{{ route('admin.scholarshipQuestion.edit', $question->id) }}"
                                                        class="btn btn-warning btn-sm mt-2"><i class="fas fa-edit"></i></a>
                                                    <a href="#" data-toggle="modal" data-target="#exampleModal"
                                                        data-scholarship-question="{{ $question->id }}"
                                                        class="btn btn-danger btn-sm mt-2"><i class="fas fa-trash"></i></a>
                                                </div>
                                                <span
                                                    class="badge badge-primary">{{ ucfirst(str_replace('-', ' ', $question->type)) }}</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            {{-- <div class="alert alert-danger">{{ $scholarship->name }} has no questions.</div> --}}
                        @endif
                    @empty
                        <div class="alert alert-danger">No scholarships found.</div>
                    @endforelse
                </div>
            </div>
        </section>
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" id="exampleModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-danger"><i class="fas fa-exclamation-triangle fa-3x"></i> Warning</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are You Sure? <br> This action can not be undone. Do you want to continue?</p>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <a href="#" class="btn btn-danger" id="deleteScholarshipQuestion">Delete</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $('#exampleModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var id = button.data('scholarship-question');
            var modal = $(this);
            modal.find('#deleteScholarshipQuestion').attr('href', '/admin/delete-scholarship-question/' + id);
        });
    </script>
@endsection
