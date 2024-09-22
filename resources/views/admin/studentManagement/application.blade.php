@extends('admin.layouts.adminLayout')

@section('title', 'Active Applications')

@section('css')
    <style>
        card {
            width: 100%;
        }

        .list-group-item {
            flex-direction: column;
            align-items: flex-start;
        }

        .badge {
            margin-bottom: 0.5rem;
        }

        /* Media query for smaller screens */
        @media (max-width: 576px) {
            .list-group-item {
                flex-direction: row;
                align-items: center;
                flex-wrap: wrap;
            }

            .badge {
                margin-bottom: 0;
                margin-right: 0.5rem;
            }
        }

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


        /* Loader Styles */
        .card {
            border-radius: 0.5rem;
            transition: all 0.3s ease;
        }

        .card:hover {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            transform: translateY(-2px);
        }

        .card-header {
            background: linear-gradient(to right, #007bff, #6610f2);
            border-top-left-radius: 0.5rem;
            border-top-right-radius: 0.5rem;
        }

        .card-title {
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .list-group-item {
            border: none;
            background-color: #f8f9fa;
            transition: all 0.3s ease;
        }

        .list-group-item:hover {
            background-color: #e9ecef;
            transform: translateX(5px);
        }

        .badge-pill {
            font-size: 0.875rem;
            font-weight: 600;
            padding: 0.375rem 0.75rem;
        }

        tr {
            border: 2px solid #ddd !important;
        }


        .search-container {
            position: relative;
            width: 100%;
            margin: 20px 0;
            text-align: center
        }

        .search-input {
            width: 80%;
            padding: 15px 20px 15px 45px;
            font-size: 18px;
            line-height: 1.5;
            color: #333;
            background-color: #f8f9fa;
            border: 2px solid #e9ecef;
            border-radius: 30px;
            transition: all 0.3s ease;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .search-input:focus {
            outline: none;
            border-color: #007bff;
            box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.25);
        }

        .search-input::placeholder {
            color: #6c757d;
        }

        .search-icon {
            position: absolute;
            top: 50%;
            left: 12%;
            transform: translateY(-50%);
            color: #6c757d;
            font-size: 18px;
        }
    </style>
@endsection

@section('admin')
    <div class="loader-overlay" id="loader-overlay">
        <div class="loader"></div>
    </div>

    <div class="main-content">
        @include('student.alert')
        <section class="section">
            <div class="section-header">
                <h1>@yield('title')</h1>
            </div>
            <div class="search-container">
                <input type="search" id="search" class="search-input" placeholder="Search Students...">
                <i class="search-icon fas fa-search"></i>
            </div>
            <div class="section-body">

                <div class="card">
                    <div class="card-body">
                        <p class="text-muted">ALLOWED APPLICATION STATUS</p>
                        <ul>
                            <li>Pending</li>
                            <li>Approved</li>
                            <li>Denied</li>
                        </ul>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="float-left">
                            <form id="import-form" action="{{ route('admin.student.applications.import') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="exampleInputFile">Import File</label>
                                    <div class="container">
                                        @error('file')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="custom-file">
                                        <input type="file" name="file" class="form-control w-100"
                                            id="exampleInputFile">
                                        <button type="submit" class="mt-2 btn btn-primary w-100">Import</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="clearfix mb-3"></div>

                        <div class="float-left">
                            <form id="departmentForm" action="{{ route('admin.student.application') }}" method="GET">
                                <select class="form-control selectric" name="department_id"
                                    onchange="updateExportLink(); this.form.submit();">
                                    <option value="">Select by Department (Show All)</option>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}"
                                            {{ request('department_id') == $department->id ? 'selected' : '' }}>
                                            {{ Str::title($department->name) }}
                                        </option>
                                    @endforeach
                                </select>
                            </form>
                        </div>

                        <div class="float-right pb-1">
                            <a href="{{ route('admin.student.applications.export') }}" class="btn btn-success"
                                id="exportButton">Export to Excel</a>
                        </div>
                        <div class="table-responsive">
                            <table id="" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 20px">s/n</th>
                                        <th style="width: auto !important">Student</th>
                                        <th style="width: auto !important">Phone Number</th>
                                        <th>Application No.</th>
                                        <th>Department</th>
                                        <th>Session</th>
                                        <th style="width: 20px">Exam</th>
                                        <th>Admission</th>
                                    </tr>
                                </thead>
                                {{-- @dd($applications) --}}
                                <tbody id="applicationTableBody">
                                    @forelse ($applications as $ap)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                {{ Str::title($ap->user->full_name) ?? 'N/A' }}
                                                <p>
                                                    <a href="{{ route('admin.show.student', $ap->user->nameSlug) }}"
                                                        class="mt-2 link">Details</a>
                                                </p>
                                            </td>
                                            <td>
                                                <p>{{ $ap->user->student->phone }}</p>
                                            </td>
                                            <td>{{ $ap->user->student->application_unique_number ?? 'N/A' }}</td>
                                            <td>{{ Str::title($ap->department->name ?? 'N/A') }}</td>
                                            <td>{{ $ap->academicSession->session ?? 'N/A' }}</td>

                                            <td>{{ $ap->user->student->exam_score ?? 0 }}</td>
                                            <td>
                                                @if ($ap->admission_status == 'pending')
                                                    <span class="badge bg-warning text-light">Pending <i
                                                            class="fa fa-spinner fa-spin"></i></span>
                                                @elseif ($ap->admission_status == 'denied')
                                                    <span class="badge bg-danger text-light">Denied <i
                                                            class="fa fa-times"></i></span>
                                                @elseif ($ap->admission_status == 'approved')
                                                {{-- // deny the admission set to pending --}}
                                                    <form onsubmit="return confirm('Are you sure of this action ?')" action="{{ route('admin.deny.application', $ap->id) }}"
                                                        method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" class="btn btn-danger">Deny</button>
                                                    </form>


                                                    <span class="badge bg-success text-light">Approved <i
                                                            class="fa fa-check"></i></span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <div class="text-center alert alert-danger">Not available</div>
                                    @endforelse
                                </tbody>

                            </table>
                        </div>
                        <div class="text-center paginate">
                            {{-- {{ $applications->links() }} --}}
                            {!! $applications->links('pagination::bootstrap-4') !!}
                        </div>
                    </div>

                    <div class="mt-5 shadow-sm card">
                        <div class="text-white card-header bg-primary">
                            <h4 class="mb-0 card-title">Available Options for Students</h4>
                        </div>
                        <div class="card-body">
                            <p class="text-danger font-weight-bold">JAMB STATUS:</p>
                            <ul class="mb-4 list-group">
                                <span class="mr-2 badge badge-info badge-pill" style="width: 290px">CHANGE_OF_SCHOOL</span>
                                <li class="flex-wrap list-group-item d-flex ">
                                    Students who changed to our school from JAMB after they had already applied to other
                                    universities but later made the switch to us.
                                </li>
                                <span class="float-left mt-5 mr-2 badge badge-info badge-pill"
                                    style="width: 290px">SELECTED_IN_JAMB</span>
                                <li class="flex-wrap list-group-item d-flex ">
                                    Students who selected our university as their choice when writing JAMB.
                                </li>
                                <span class="mt-5 mr-2 badge badge-info badge-pill" style="width: 290px">DIRECT_ENTRY</span>
                                <li class="flex-wrap list-group-item d-flex ">
                                    Students who came to the school to purchase admission but did not add us in JAMB or
                                    change their institution.
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>

            </div>
    </div>
    </section>
    </div>
@endsection



@section('js')
    {{-- <script src="https://code.jquery.com/jquery-3.4.0.min.js"></script> --}}
    <script>
        $(document).ready(function() {
            $('#search').on('keyup', function() {
                var query = $(this).val();
                fetch_students(query);
            });

            function fetch_students(query = '') {
                $.ajax({
                    url: "{{ route('admin.student.applications.search') }}",
                    method: 'GET',
                    data: {
                        query: query
                    },
                    success: function(data) {
                        $('#applicationTableBody').html(data);
                    }
                });
            }
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectElement = document.querySelector('.selectric');
            selectElement.addEventListener('change', function(event) {
                const form = document.getElementById('departmentForm');
                form.submit();
            });
        });
    </script>

    <script>
        function updateExportLink() {
            const departmentId = document.querySelector('[name="department_id"]').value;
            const exportButton = document.getElementById('exportButton');
            let url = '{{ route('admin.student.applications.export') }}';
            url += departmentId ? '?department_id=' + departmentId : '';
            exportButton.href = url;
        }
        document.addEventListener('DOMContentLoaded', function() {
            updateExportLink(); // Update on load in case there's an initial department selected
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const importForm = document.getElementById('import-form');
            const loaderOverlay = document.getElementById('loader-overlay');

            importForm.addEventListener('submit', function() {
                loaderOverlay.style.display = 'block';
            });
        });
    </script>


@endsection
