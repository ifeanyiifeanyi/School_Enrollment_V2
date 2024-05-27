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
                        <div class="card-body">
                            <form action="" method="POST" id="question-form" class="container my-5">
                                @csrf
                                <div class="mb-3">
                                    <label for="scholarship_id" class="form-label">Select Scholarship</label>
                                    <select id="scholarship_id" name="scholarship_id" class="form-select" required>
                                        @foreach ($scholarships as $scholarship)
                                            <option value="{{ $scholarship->id }}">{{ $scholarship->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div id="questions-container" class="mb-3">
                                    <div class="question card p-3 mb-3">
                                        <div class="mb-3">
                                            <label for="questions[0][question_text]" class="form-label">Question Text</label>
                                            <input type="text" name="questions[0][question_text]" class="form-control" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="questions[0][type]" class="form-label">Question Type</label>
                                            <select name="questions[0][type]" class="question-type form-select" required>
                                                <option value="text">Text</option>
                                                <option value="multiple-choice">Multiple Choice</option>
                                                <option value="checkbox">Checkbox</option>
                                            </select>
                                        </div>
                                        <div class="options-container mb-3" style="display: none;">
                                            <label class="form-label">Options</label>
                                            <div class="input-group mb-2">
                                                <input type="text" name="questions[0][options][]" class="form-control" placeholder="Option 1">
                                                <button type="button" class="btn btn-danger remove-option">Remove</button>
                                            </div>
                                            <div class="input-group mb-2">
                                                <input type="text" name="questions[0][options][]" class="form-control" placeholder="Option 2">
                                                <button type="button" class="btn btn-danger remove-option">Remove</button>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-primary add-option">Add Option</button>
                                    </div>
                                </div>
                                <button type="button" id="add-question" class="btn btn-success mb-3">Add Another Question</button>
                                <button type="submit" class="btn btn-primary">Save Questions</button>
                            </form>
                            
                            <script>
                            document.getElementById('add-question').addEventListener('click', function () {
                                const questionsContainer = document.getElementById('questions-container');
                                const questionCount = questionsContainer.getElementsByClassName('question').length;
                                const newQuestion = document.createElement('div');
                                newQuestion.classList.add('question', 'card', 'p-3', 'mb-3');
                            
                                newQuestion.innerHTML = `
                                    <div class="mb-3">
                                        <label for="questions[${questionCount}][question_text]" class="form-label">Question Text</label>
                                        <input type="text" name="questions[${questionCount}][question_text]" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="questions[${questionCount}][type]" class="form-label">Question Type</label>
                                        <select name="questions[${questionCount}][type]" class="question-type form-select" required>
                                            <option value="text">Text</option>
                                            <option value="multiple-choice">Multiple Choice</option>
                                            <option value="checkbox">Checkbox</option>
                                        </select>
                                    </div>
                                    <div class="options-container mb-3" style="display: none;">
                                        <label class="form-label">Options</label>
                                        <div class="input-group mb-2">
                                            <input type="text" name="questions[${questionCount}][options][]" class="form-control" placeholder="Option 1">
                                            <button type="button" class="btn btn-danger remove-option">Remove</button>
                                        </div>
                                        <div class="input-group mb-2">
                                            <input type="text" name="questions[${questionCount}][options][]" class="form-control" placeholder="Option 2">
                                            <button type="button" class="btn btn-danger remove-option">Remove</button>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-primary add-option">Add Option</button>
                                `;
                            
                                questionsContainer.appendChild(newQuestion);
                            
                                // Reattach the change event listener for the new question type select
                                newQuestion.querySelector('.question-type').addEventListener('change', function () {
                                    const optionsContainer = this.closest('.question').querySelector('.options-container');
                                    if (this.value === 'multiple-choice' || this.value === 'checkbox') {
                                        optionsContainer.style.display = 'block';
                                    } else {
                                        optionsContainer.style.display = 'none';
                                    }
                                });
                            
                                // Attach event listeners for add and remove option buttons
                                newQuestion.querySelectorAll('.add-option').forEach(function(addButton) {
                                    addButton.addEventListener('click', function() {
                                        const optionsContainer = this.closest('.question').querySelector('.options-container');
                                        const inputGroup = document.createElement('div');
                                        inputGroup.classList.add('input-group', 'mb-2');
                                        inputGroup.innerHTML = `
                                            <input type="text" name="questions[${questionCount}][options][]" class="form-control" placeholder="Option">
                                            <button type="button" class="btn btn-danger remove-option">Remove</button>
                                        `;
                                        optionsContainer.appendChild(inputGroup);
                                        attachRemoveOptionListener(inputGroup.querySelector('.remove-option'));
                                    });
                                });
                            
                                newQuestion.querySelectorAll('.remove-option').forEach(function(removeButton) {
                                    attachRemoveOptionListener(removeButton);
                                });
                            });
                            
                            // Attach the change event listener to the initial question type selects
                            document.querySelectorAll('.question-type').forEach(function(select) {
                                select.addEventListener('change', function () {
                                    const optionsContainer = this.closest('.question').querySelector('.options-container');
                                    if (this.value === 'multiple-choice' || this.value === 'checkbox') {
                                        optionsContainer.style.display = 'block';
                                    } else {
                                        optionsContainer.style.display = 'none';
                                    }
                                });
                            });
                            
                            // Attach event listeners for add and remove option buttons
                            document.querySelectorAll('.add-option').forEach(function(addButton) {
                                addButton.addEventListener('click', function() {
                                    const optionsContainer = this.closest('.question').querySelector('.options-container');
                                    const inputGroup = document.createElement('div');
                                    inputGroup.classList.add('input-group', 'mb-2');
                                    inputGroup.innerHTML = `
                                        <input type="text" name="questions[0][options][]" class="form-control" placeholder="Option">
                                        <button type="button" class="btn btn-danger remove-option">Remove</button>
                                    `;
                                    optionsContainer.appendChild(inputGroup);
                                    attachRemoveOptionListener(inputGroup.querySelector('.remove-option'));
                                });
                            });
                            
                            document.querySelectorAll('.remove-option').forEach(function(removeButton) {
                                attachRemoveOptionListener(removeButton);
                            });
                            
                            function attachRemoveOptionListener(button) {
                                button.addEventListener('click', function() {
                                    this.closest('.input-group').remove();
                                });
                            }
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
