@extends('student.layouts.studentLayout')

@section('title', 'Scholarships')
@section('css')

@endsection


@section('student')
    <section class="content">
        <div class="container mt-5">
            <h3 class="pl-3 text-header">Available Scholarship</h3>

            <div class="row">
                <div class="col-md-6">
                    <div class="pl-3 pr-3">
                        @forelse ($scholarships as $scholarship)
                            <div class=" shadow card">
                                <div class="card-body">

                                    <h4>{{ Str::title($scholarship->name) }}</h4>
                                    <p>
                                        {{ Str::limit($scholarship->description, 200) }}
                                        <br>
                                        <a href="" class="btn btn-sm btn-outline-info mt-3mt-3 show-scholarship-modal"
                                            data-id="{{ $scholarship->id }}">Read more</a>
                                    </p>
                                </div>
                            </div>
                        @empty
                            <p class="alert alert-danger">Try again later ...</p>
                        @endforelse
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 shadow card">
                        <div class="mb-4 row">
                            <div class="col">
                                <h3 class="text-center">Apply for Scholarships</h3>
                            </div>
                        </div>
                        <form action="" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="scholarship_id">Select Scholarship</label>
                                <select class="form-control" id="scholarship_id" name="scholarship_id" required>
                                    <option value="" disabled selected>Select a scholarship</option>
                                    @foreach ($scholarships as $scholarship)
                                        <option value="{{ $scholarship->id }}">{{ $scholarship->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div id="questions-container"></div>

                            <button type="submit" class="btn btn-primary">Submit Application</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>

        {{-- modal for scholarship details  --}}
        <!-- Modal -->
        <div class="modal fade" id="scholarshipModal" tabindex="-1" role="dialog" aria-labelledby="scholarshipModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="scholarshipModalLabel"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Scholarship details will be loaded here -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        {{-- modal for scholarship details  --}}





















        <script>
            document.getElementById('scholarship_id').addEventListener('change', function() {
                const scholarshipId = this.value;
                const questionsContainer = document.getElementById('questions-container');

                // Clear previous questions
                questionsContainer.innerHTML = '';

                // Fetch questions for the selected scholarship
                fetch(`/student/scholarships/${scholarshipId}/questions`)
                    .then(response => response.json())
                    .then(data => {
                        data.questions.forEach((question, index) => {
                            let questionHtml = `
                            <div class="form-group">
                                <label for="question-${index}">${question.question_text}</label>
                        `;

                            if (question.type === 'text') {
                                questionHtml +=
                                    `<input type="text" class="form-control" id="question-${index}" name="answers[${question.id}]" required>`;
                            } else if (question.type === 'multiple-choice') {
                                question.options.forEach((option, optIndex) => {
                                    questionHtml += `
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" id="option-${index}-${optIndex}" name="answers[${question.id}]" value="${option}" required>
                                        <label class="form-check-label" for="option-${index}-${optIndex}">${option}</label>
                                    </div>
                                `;
                                });
                            } else if (question.type === 'checkbox') {
                                question.options.forEach((option, optIndex) => {
                                    questionHtml += `
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="option-${index}-${optIndex}" name="answers[${question.id}][]" value="${option}">
                                        <label class="form-check-label" for="option-${index}-${optIndex}">${option}</label>
                                    </div>
                                `;
                                });
                            }

                            questionHtml += `</div>`;
                            questionsContainer.insertAdjacentHTML('beforeend', questionHtml);
                        });
                    })
                    .catch(error => console.error('Error fetching questions:', error));
            });
        </script>

    </section>
@endsection


@section('js')
<script>
    $(document).ready(function() {
        // Show scholarship modal
        $('.show-scholarship-modal').click(function(e) {
            e.preventDefault();
            var scholarshipId = $(this).data('id');
            var modal = $('#scholarshipModal');
            var modalTitle = modal.find('.modal-title');
            var modalBody = modal.find('.modal-body');

            // Make AJAX request to fetch scholarship details
            $.ajax({
                url: '{{ route('scholarships.show.detail', ['id' => '__ID__']) }}'.replace('__ID__', scholarshipId),
                type: 'GET',
                success: function(data) {
                    modalTitle.text(data.name);
                    modalBody.html('<p>' + data.description + '</p>');
                    modal.modal('show');
                },
                error: function() {
                    alert('Error fetching scholarship details');
                }
            });
        });
    });
 </script>
@endsection
