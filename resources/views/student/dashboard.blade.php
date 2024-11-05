@extends('student.layouts.studentLayout')

@section('title', 'Dashboard')
@section('css')
    <style>
        .greeting-card {
            background-color: #fff;
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            padding: 2rem;
        }

        .greeting-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        .greeting-icon {
            font-size: 4rem;
            color: #007bff;
            animation: fadeInDown 1s;
        }

        .greeting-text {
            font-size: 1.8rem;
            font-weight: 600;
            color: #343a40;
            animation: fadeInUp 1s;
        }

        @keyframes fadeInDown {
            0% {
                opacity: 0;
                transform: translateY(-20px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
    <style>
        .notice {
            background: linear-gradient(135deg, #6a82fb, #fc5c7d);
            border-radius: 10px;
            color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        h2 {
            font-weight: bold;
            margin-bottom: 20px;
        }

        p {
            margin-bottom: 15px;
            font-size: 1rem;
        }

        @media (max-width: 768px) {
            .notice {
                padding: 20px;
            }

            p {
                font-size: 0.9rem;
            }
        }
    </style>

@endsection
@section('student')
    <section class="content">
        <div class="container mt-5 mb-5">
            @if ($showPaymentAlert)
                <div class="alert alert-success">
                    <h5>Your application has been submitted but payment is <b class="text-warning"> PENDING </b>.</h5>
                    <p class="lead">
                        Please <a class="btn btn-primary"
                            href="{{ route('payment.view.finalStep', ['userSlug' => auth()->user()->nameSlug]) }}"
                            class="alert-link">complete your payment</a> to finalize your application.
                    </p>
                </div>
            @endif
            @if (auth()->user()->applications && auth()->user()->applications->payment_id)
                <div class="card mt-4">
                    <div class="card-header">Completed Application</div>
                    <div class="card-body">
                        <p>Your application has been submitted and payment received.</p>
                        <a href="{{ route('student.payment.slip') }}" class="btn btn-primary">View/Print Payment Slip</a>
                    </div>
                </div>

            @endif
            {{-- <div class="p-4 notice">
                <h2 class="text-center">Scholarship Eligibility and Conditions</h2>
                <p><strong>1.</strong> The scholarship fund covers <strong>ONLY</strong> 50% of the tuition cost for the University.</p>
                <p><strong>2.</strong> The scholarship does not cover accommodation, feeding, or other study-related expenses. The beneficiary must cover all additional costs independently.</p>
                <p><strong>4.</strong> The scholarship applies <strong>ONLY</strong> to regular courses within the standard course schedule and does not cover courses for carry-overs or repeats. Any such courses must be funded by the student.</p>
                <p><strong>5.</strong> The scholarship is not transferable to other programs or courses unless approved in writing by SEF Management.</p>
                <p><strong>6.</strong> The beneficiary must maintain good behavior and avoid any major sanctions or censure by the University. In the event of such issues, the scholarship will be revoked.</p>
                <p><strong>7.</strong> SEF reserves the right to use information provided by applicants for internal purposes and will not share personal information with third parties without permission.</p>
                <p><strong>8.</strong> SEF reserves the right to request additional information from applicants to ensure compliance with these conditions.</p>
            </div> --}}

        </div>
        <div class="row">
            <div class="mx-auto col-md-4 col-sm-12">
                <div class="container">
                    <div class="card greeting-card">
                        <div class="card-body d-flex justify-content-center align-items-center flex-column">
                            <div class="mb-3 greeting-icon"></div>
                            <h4 class="mb-0 greeting-text"></h4>
                            <p class="text-muted">{{ Str::title(auth()->user()->first_name) }}</p>
                        </div>

                        <a wire:navigate href="{{ route('student.admission.application') }}"
                            class="btn btn-outline-primary"><i class="fas fa-bookmark"></i> Start Your Application</a>
                    </div>
                </div>
            </div>
        </div>


        {{-- @if ($application) --}}

        {{-- @include('student.payment.applicationStatus') --}}
        {{-- @else --}}
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="shadow-lg card">
                        <div class="text-white card-header bg-primary">
                            <h3 class="card-title">Faculties and Associated Departments</h3>
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
                                {{-- {{ $faculties->links() }} --}}
                                {!! $faculties->links('pagination::bootstrap-4') !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- @endif --}}



        <!-- /.container-fluid -->
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

        updateGreeting();
    </script>


    <script>
        $(document).ready(function() {
            $('#departmentModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
                var departmentId = button.data(
                    'department-id'); // Get the department ID from the data attribute

                // Fetch department details using AJAX
                $.ajax({
                    url: '/student/department-user/' +
                        departmentId, // Replace with your route to fetch department details
                    method: 'GET',
                    success: function(data) {
                        var modalBody = $('#departmentModal .modal-body');
                        console.log(data)
                        var html = `
                        <h3>${data.name}</h3>
                        <p>${data.description}</p>
                    `;

                        if (data.exam_manager) {
                            html += `
                            <h4>Exam Schedule:</h4>
                        `;

                            var subjects = [];
                            try {
                                subjects = JSON.parse('[' + data.exam_manager.exam_subjects +
                                    ']');
                                console.log(subjects)
                            } catch (error) {
                                console.error('Error parsing exam subjects:', error);
                            }

                            if (Array.isArray(subjects)) {
                                html += '<p>Exam Subjects: <br>';
                                subjects.forEach(subject => {
                                    html += `<li>${subject}</li>, `;
                                });
                                // Remove the last comma and add closing tag
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
