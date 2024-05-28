@extends('admin.layouts.adminLayout')

@section('title', 'Scholarship Application Questions')

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
                    <div class="col-md-8 mx-auto">
                        <div class="card">
                            @if (session('message'))
                                <div class="alert alert-info mb-3">{{ session('message') }}</div>
                            @endif
                            @if ($errors->any())
                                <div class="alert alert-danger mb-3">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="card-body">
                                <a href="" class="btn btn-primary float-right">View All Questions</a>

                                <form action="{{ route('admin.scholarship.question.store') }}" method="POST"
                                    id="question-form" class="container my-5">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="scholarship_id" class="form-label">Select Scholarship</label>
                                        <select id="scholarship_id" name="scholarship_id" class="form-select form-control"
                                            required>
                                            <option value="" selected disabled>Select Scholarship</option>
                                            @foreach ($scholarships as $scholarship)
                                                <option value="{{ $scholarship->id }}">{{ $scholarship->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('scholarship_id')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <hr>
                                    <div id="questions-container" class="mb-3">
                                        <div class="question card p-3 mb-3">
                                            <div class="mb-3">
                                                <label for="questions[0][question_text]" class="form-label">Question
                                                    Text</label>
                                                <input type="text" name="questions[0][question_text]"
                                                    class="form-control" placeholder="Enter Question Here ...">
                                                @error('questions.0.question_text')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label for="questions[0][type]" class="form-label">Question Type</label>
                                                <select name="questions[0][type]"
                                                    class="question-type form-select form-control" required>
                                                    <option value="" disabled selected>Select Question Type</option>
                                                    <option value="text">Text</option>
                                                    <option value="multiple-choice">Multiple Choice</option>
                                                    <option value="checkbox">Checkbox</option>
                                                </select>
                                                @error('questions.0.type.*')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="options-container mb-3" style="display: none;">
                                                <label class="form-label">Options</label>
                                                <div class="input-group mb-2">
                                                    <input type="text" name="questions[0][options][]"
                                                        class="form-control" placeholder="Option 1">
                                                    @error('questions.0.options.*')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                    <button type="button"
                                                        class="btn btn-danger remove-option">Remove</button>
                                                </div>
                                                <div class="input-group mb-2">
                                                    <input type="text" name="questions[0][options][]"
                                                        class="form-control" placeholder="Option 2">
                                                    @error('questions.0.options.*')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                    <button type="button"
                                                        class="btn btn-danger remove-option">Remove</button>
                                                </div>
                                            </div>
                                            <button type="button" class="btn btn-primary add-option">Add Option</button>
                                        </div>
                                        <button type="button" class="btn btn-danger remove-question">Remove
                                            Question</button>

                                    </div>
                                    <button type="button" id="add-question" class="btn btn-success">Add Another
                                        Question</button>
                                    <button type="submit" class="btn btn-primary">Save Questions</button>
                                </form>

                                <script>
                                    document.getElementById('add-question').addEventListener('click', function() {
                                        const questionsContainer = document.getElementById('questions-container');
                                        const questionCount = questionsContainer.getElementsByClassName('question').length;
                                        const newQuestion = document.createElement('div');
                                        newQuestion.classList.add('question', 'mb-3');

                                        newQuestion.innerHTML = `
                                            <div class="form-group">
                                                <label for="questions[${questionCount}][question_text]">Question Text</label>
                                                <input type="text" class="form-control" name="questions[${questionCount}][question_text]" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="questions[${questionCount}][type]">Question Type</label>
                                                <select class="form-control question-type" name="questions[${questionCount}][type]" required>
                                                    <option value="text">Text</option>
                                                    <option value="multiple-choice">Multiple Choice</option>
                                                    <option value="checkbox">Checkbox</option>
                                                </select>
                                            </div>
                                            <div class="options-container" style="display: none;">
                                                <div class="form-group">
                                                    <label>Options</label>
                                                    <div class="options">
                                                        <input type="text" class="form-control mb-2" name="questions[${questionCount}][options][]" placeholder="Option 1">
                                                        <input type="text" class="form-control mb-2" name="questions[${questionCount}][options][]" placeholder="Option 2">
                                                    </div>
                                                    <button type="button" class="btn btn-secondary add-option">Add Option</button>
                                                </div>
                                            </div>
                                            <button type="button" class="btn btn-danger remove-question">Remove Question</button>
                                        `;

                                        questionsContainer.appendChild(newQuestion);

                                        // Reattach the change event listener for the new question type select
                                        newQuestion.querySelector('.question-type').addEventListener('change', function() {
                                            const optionsContainer = this.closest('.question').querySelector('.options-container');
                                            if (this.value === 'multiple-choice' || this.value === 'checkbox') {
                                                optionsContainer.style.display = 'block';
                                            } else {
                                                optionsContainer.style.display = 'none';
                                            }
                                        });

                                        // Attach event listener for the new add-option button
                                        newQuestion.querySelector('.add-option').addEventListener('click', function() {
                                            const optionsDiv = this.previousElementSibling;
                                            const optionCount = optionsDiv.getElementsByTagName('input').length;
                                            const newOption = document.createElement('input');
                                            newOption.type = 'text';
                                            newOption.className = 'form-control mb-2';
                                            newOption.name = `questions[${questionCount}][options][]`;
                                            newOption.placeholder = `Option ${optionCount + 1}`;
                                            optionsDiv.appendChild(newOption);
                                        });

                                        // Attach event listener for the new remove-question button
                                        newQuestion.querySelector('.remove-question').addEventListener('click', function() {
                                            newQuestion.remove();
                                        });
                                    });

                                    // Attach the change event listener to the initial question type select
                                    document.querySelectorAll('.question-type').forEach(function(select) {
                                        select.addEventListener('change', function() {
                                            const optionsContainer = this.closest('.question').querySelector('.options-container');
                                            if (this.value === 'multiple-choice' || this.value === 'checkbox') {
                                                optionsContainer.style.display = 'block';
                                            } else {
                                                optionsContainer.style.display = 'none';
                                            }
                                        });
                                    });

                                    // Attach event listener to the initial add-option button
                                    document.querySelector('.add-option').addEventListener('click', function() {
                                        const optionsDiv = this.previousElementSibling;
                                        const optionCount = optionsDiv.getElementsByTagName('input').length;
                                        const newOption = document.createElement('input');
                                        newOption.type = 'text';
                                        newOption.className = 'form-control mb-2';
                                        newOption.name = `questions[0][options][]`;
                                        newOption.placeholder = `Option ${optionCount + 1}`;
                                        optionsDiv.appendChild(newOption);
                                    });

                                    // Attach event listener to the initial remove-question button
                                    document.querySelector('.remove-question').addEventListener('click', function() {
                                        this.closest('.question').remove();
                                    });
                                </script>

                            </div>
                        </div>
                    </div>
                </div>
        </section>
    </div>
@endsection



@section('js')

@endsection
