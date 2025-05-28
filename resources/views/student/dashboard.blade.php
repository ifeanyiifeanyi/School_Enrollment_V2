@extends('student.layouts.studentLayout')

@section('title', 'Dashboard')

@section('student')
    <section class="content">
        <div class="container mt-5 mb-5">
            {{-- Payment Alert for Current Session --}}
            @if ($showPaymentAlert)
                <div class="alert alert-warning">
                    <h5>Your application for {{ $currentSession->session ?? 'current session' }} has been submitted but payment is <b class="text-danger">PENDING</b>.</h5>
                    <p class="lead">
                        Please <a class="btn btn-primary"
                            href="{{ route('payment.view.finalStep', ['userSlug' => auth()->user()->nameSlug]) }}">complete your payment</a> to finalize your application.
                    </p>
                </div>
            @endif

            {{-- Completed Application Alert for Current Session --}}
            @if ($hasCompletedApplication)
                <div class="alert alert-success">
                    <h5><i class="fas fa-check-circle"></i> Application Complete for {{ $currentSession->session ?? 'current session' }}</h5>
                    <p>Your application has been submitted and payment received for the current academic session.</p>
                    <a href="{{ route('student.payment.slip') }}" class="btn btn-primary">
                        <i class="fas fa-receipt"></i> View/Print Payment Slip
                    </a>
                </div>
            @endif

            {{-- Previously Admitted Student Alert --}}
            @if ($hasBeenAdmitted && !$application)
                <div class="alert alert-info">
                    <h5><i class="fas fa-graduation-cap"></i> Welcome Back!</h5>
                    <p>You have been admitted in a previous academic session. If you wish to apply for the {{ $currentSession->session ?? 'current session' }}, please contact the admissions office for guidance on re-application procedures.</p>
                </div>
            @endif
        </div>

        {{-- Show Application Section only if allowed --}}
        @if ($showApplicationForm)
            <div class="row">
                <div class="mx-auto col-md-4 col-sm-12">
                    <div class="container">
                        <div class="card greeting-card">
                            <div class="card-body d-flex justify-content-center align-items-center flex-column">
                                <div class="mb-3 greeting-icon"></div>
                                <h4 class="mb-0 greeting-text"></h4>
                                <p class="text-muted">{{ Str::title(auth()->user()->first_name) }}</p>
                                @if($currentSession)
                                    <small class="text-primary">Academic Session: {{ $currentSession->session }}</small>
                                @endif
                            </div>

                            <a wire:navigate href="{{ route('student.admission.application') }}"
                                class="btn btn-outline-primary">
                                <i class="fas fa-bookmark"></i> Start Your Application
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Show Faculties and Departments --}}
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-md-10">
                        <div class="shadow-lg card">
                            <div class="text-white card-header bg-primary">
                                <h3 class="card-title">
                                    Faculties and Associated Departments
                                    @if($currentSession)
                                        <small class="badge badge-light ml-2">{{ $currentSession->session }}</small>
                                    @endif
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="mb-4 alert alert-danger">
                                    <strong>IMPORTANT!!!</strong> Before selecting a department to apply to, carefully
                                    review the list below. It outlines each faculty's departments and the programs available
                                    for application. Take your time to explore the diverse academic disciplines within each
                                    faculty, considering the programs' offerings and alignment with your career aspirations.
                                    This comprehensive guide ensures you're well-informed when making this crucial decision.
                                    Delve into the details, assess your interests, and make the choice that best suits your
                                    academic journey and future goals.
                                </div>
                                <div class="row">
                                    @forelse ($faculties as $faculty)
                                        <div class="mb-4 col-md-4">
                                            <div class="card h-100">
                                                <div class="text-white card-header bg-secondary">
                                                    <h5 class="card-title">{{ Str::title($faculty->name) }}</h5>
                                                </div>
                                                <div class="card-body">
                                                    <ul class="list-group list-group-flush">
                                                        @forelse ($faculty->departments as $department)
                                                            <li class="list-group-item">
                                                                <a data-toggle="modal" data-target="#departmentModal"
                                                                    data-department-id="{{ $department->id }}"
                                                                    title="Click to view details" class="text-primary"
                                                                    href="#!">
                                                                    {{ Str::title($department->name) }}
                                                                </a>
                                                            </li>
                                                        @empty
                                                            <li class="list-group-item text-danger">
                                                                Coming soon <i class="fas fa-spinner fa-spin"></i>
                                                            </li>
                                                        @endforelse
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="col-md-12">
                                            <div class="alert alert-danger">Try again later</div>
                                        </div>
                                    @endforelse
                                </div>
                                <div class="mt-4 d-flex justify-content-center">
                                    {!! $faculties->links('pagination::bootstrap-4') !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            {{-- Show message when application form is not available --}}
            @if (!$hasCompletedApplication && !$showPaymentAlert)
                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-body text-center">
                                    <i class="fas fa-info-circle fa-3x text-info mb-3"></i>
                                    <h4>Application Status</h4>
                                    @if($hasBeenAdmitted)
                                        <p class="lead">You have been previously admitted. For new applications, please contact the admissions office.</p>
                                    @else
                                        <p class="lead">No active application session or you have already applied for the current session.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endif

        <!-- Department Modal -->
        <div class="modal fade" id="departmentModal" tabindex="-1" role="dialog" aria-labelledby="departmentModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="departmentModalLabel">Department Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Department details will be loaded here -->
                    </div>
                    <div class="float-right modal-footer">
                        <a href="{{ route('student.admission.application') }}" class="btn btn-primary">Start Application</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
    <script>
        function updateGreeting() {
            const currentHour = new Date().getHours();
            const greetingText = document.querySelector('.greeting-text');
            const greetingIcon = document.querySelector('.greeting-icon');

            if (greetingText && greetingIcon) {
                // Remove any existing icon classes
                greetingIcon.classList.remove('fas', 'fa-sun', 'fa-cloud-sun', 'fa-moon');

                if (currentHour >= 5 && currentHour < 12) {
                    greetingText.textContent = 'Good Morning';
                    greetingIcon.classList.add('fas', 'fa-sun');
                } else if (currentHour >= 12 && currentHour < 17) {
                    greetingText.textContent = 'Good Afternoon';
                    greetingIcon.classList.add('fas', 'fa-cloud-sun');
                } else if (currentHour >= 17 && currentHour < 20) {
                    greetingText.textContent = 'Good Evening';
                    greetingIcon.classList.add('fas', 'fa-moon');
                } else {
                    greetingText.textContent = 'Good Night';
                    greetingIcon.classList.add('fas', 'fa-moon');
                }
            }
        }

        updateGreeting();
    </script>

    <script>
        $(document).ready(function() {
            $('#departmentModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var departmentId = button.data('department-id');

                $.ajax({
                    url: '/student/department-user/' + departmentId,
                    method: 'GET',
                    success: function(data) {
                        var modalBody = $('#departmentModal .modal-body');
                        console.log(data)
                        var html = `
                        <h3>${data.name}</h3>
                        <p>${data.description}</p>
                    `;

                        if (data.exam_manager) {
                            html += `<h4>Exam Schedule:</h4>`;

                            var subjects = [];
                            try {
                                subjects = JSON.parse('[' + data.exam_manager.exam_subjects + ']');
                                console.log(subjects)
                            } catch (error) {
                                console.error('Error parsing exam subjects:', error);
                            }

                            if (Array.isArray(subjects)) {
                                html += '<p>Exam Subjects: <br>';
                                subjects.forEach(subject => {
                                    html += `<li>${subject}</li>, `;
                                });
                                html = html.slice(0, -2) + '</p>';
                            } else {
                                html += '<p>No exam subjects provided.</p>';
                            }

                            html += `
                            <p>Date & Time: ${data.exam_manager.date_time}</p>
                            <p>Venue: ${data.exam_manager.venue}</p>
                        `;
                        } else {
                            html += '<p>No exam manager assigned to this department.</p>';
                        }

                        modalBody.html(html);
                    },
                    error: function() {
                        alert('Error fetching department details.');
                    }
                });
            });
        });
    </script>
@endsection
