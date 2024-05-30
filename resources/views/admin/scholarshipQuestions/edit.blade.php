@extends('admin.layouts.adminLayout')

@section('title', 'Edit Scholarship Question')

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
                    <a href="{{ route('admin.scholarship.question.show') }}" class="btn btn-primary btn-sm mb-4">Back</a>

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.scholarshipQuestion.update', $question->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="scholarship_id">Select Scholarship</label>
                            <select class="form-control" id="scholarship_id" name="scholarship_id" required>
                                @foreach ($scholarships as $scholarship)
                                    <option value="{{ $scholarship->id }}" {{ $scholarship->id == $question->scholarship_id ? 'selected' : '' }}>
                                        {{ $scholarship->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="question_text">Question Text</label>
                            <input type="text" class="form-control" id="question_text" name="question_text" value="{{ $question->question_text }}" required>
                        </div>

                        <div class="form-group">
                            <label for="type">Question Type</label>
                            <select class="form-control" id="type" name="type" required>
                                <option value="text" {{ $question->type == 'text' ? 'selected' : '' }}>Text</option>
                                <option value="multiple-choice" {{ $question->type == 'multiple-choice' ? 'selected' : '' }}>Multiple Choice</option>
                                <option value="checkbox" {{ $question->type == 'checkbox' ? 'selected' : '' }}>Checkbox</option>
                            </select>
                        </div>

                        <div id="options-container" style="{{ in_array($question->type, ['multiple-choice', 'checkbox']) ? '' : 'display: none;' }}">
                            <label for="options">Options</label>
                            @foreach ($question->options as $option)
                                <input type="text" class="form-control mb-2" name="options[]" value="{{ $option }}">
                            @endforeach
                            <button type="button" class="btn btn-secondary add-option">Add Option</button>
                        </div>

                        <button type="submit" class="btn btn-primary float-right">Update Question</button>
                    </form>
                </div>
            </div>
        </section>
    </div>

    <script>
        document.getElementById('type').addEventListener('change', function () {
            const optionsContainer = document.getElementById('options-container');
            if (this.value === 'multiple-choice' || this.value === 'checkbox') {
                optionsContainer.style.display = 'block';
            } else {
                optionsContainer.style.display = 'none';
            }
        });

        document.querySelector('.add-option').addEventListener('click', function () {
            const optionsContainer = document.getElementById('options-container');
            const newOption = document.createElement('input');
            newOption.type = 'text';
            newOption.name = 'options[]';
            newOption.className = 'form-control mb-2';
            optionsContainer.insertBefore(newOption, this);
        });
    </script>
@endsection

@section('js')
    <!-- Add any custom JS here -->
@endsection
