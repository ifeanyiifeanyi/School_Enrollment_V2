@extends('admin.layouts.adminLayout')

@section('title', 'Exam Notification Manager')

@section('css')
    <!-- select2 css -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .loader-overlay {
            display: none;
            position: fixed;
            z-index: 9999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            background-color: rgba(255, 255, 255, 0.8);
        }

        .loader {
            border: 8px solid #f3f3f3;
            /* Light grey */
            border-top: 8px solid #3498db;
            /* Blue */
            border-radius: 50%;
            width: 10%;
            /* Percentage-based size for responsiveness */
            max-width: 120px;
            /* Max width for larger screens */
            height: 10%;
            /* Percentage-based size for responsiveness */
            max-height: 120px;
            /* Max height for larger screens */
            animation: spin 2s linear infinite;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Responsive styles */
        @media (max-width: 767px) {
            .loader {
                width: 20%;
                /* Adjust size for smaller screens */
                height: 20%;
            }
        }

        @media (max-width: 480px) {
            .loader {
                width: 30%;
                /* Adjust size for very small screens */
                height: 30%;
            }
        }
    </style>
@endsection

@section('admin')
    <div class="loader-overlay" id="loader-overlay">
        <div class="loader"></div>
    </div>
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>@yield('title')</h1>
            </div>

            <div class="section-body">
                <p class="section-lead">
                    Notification Manager
                </p>

                <div id="output-status"></div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                @include('admin.examNotification.nav')
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">

                        <div class="container-fluid">
                                <div class="mx-auto">
                                    <div class="card">
                                        <div class="card-body">
                                            <form action="{{ route('admin.exam.notificationStore') }}" method="POST"
                                                id="exam-notice">
                                                @csrf
                                                <div class="form-group">
                                                    <label for="department">Department</label> <br>
                                                    <select name="department_id" id="department" class="form-control">
                                                        <option value="" selected disabled>Select Department</option>
                                                        @foreach ($departments as $department)
                                                            <option {{ old('department_id') ? 'selected' : '' }}
                                                                value="{{ $department->id }}">{{ $department->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('department_id')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="exam_date">Exam Date</label>
                                                    <input type="date" name="exam_date" id="exam_date"
                                                        class="form-control" value="{{ old('exam_date') }}">
                                                    @error('exam_date')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="venue">Venue</label>
                                                    <input type="text" name="venue" id="venue" class="form-control"
                                                        value="{{ old('venue') }}">
                                                    @error('venue')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="requirements">Requirements</label>
                                                    <textarea class="summernote-simple" name="requirements" id="requirements" class="form-control">{{ old('requirements') }}</textarea>
                                                    @error('requirements')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <button type="submit" class="btn btn-primary">Send Notification</button>
                                            </form>

                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection



@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#department').select2();
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const importForm = document.getElementById('exam-notice');
            const loaderOverlay = document.getElementById('loader-overlay');

            importForm.addEventListener('submit', function() {
                loaderOverlay.style.display = 'block';
            });
        });
    </script>
@endsection
