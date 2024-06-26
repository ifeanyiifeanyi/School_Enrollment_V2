@extends('admin.layouts.adminLayout')

@section('title', 'Active Applications')

@section('css')
    <style>

        table.dataTable.dtr-inline.collapsed>tbody>tr.parent>td:first-child:before,
        table.dataTable.dtr-inline.collapsed>tbody>tr.parent>th:first-child:before {
            display: inline-block !important;
            content: "+" !important`;
            width: 20px !important`;
            height: 20px !important`;
            line-height: 20px !important`;
            text-align: center !important`;
            border-radius: 50% !important`;
            background-color: #007bff !important`;
            color: #fff !important`;
            font-weight: bold !important`;
            margin-right: 10px !important`;
        }

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

                <div class="card">
                    <div class="card-body">
                        <p class="text-muted">ALLOW APPLICATION STATUS</p>
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
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 20px">s/n</th>
                                        <th style="width: auto !important">Student</th>
                                        <th>Application No.</th>
                                        <th>Department</th>
                                        <th>Session</th>
                                        <th style="width: 20px">Exam Score</th>
                                        <th>Admission</th>
                                        <th style="width: 20px">Payment Status</th>
                                    </tr>
                                    {{-- @dd($applications->academicSession) --}}
                                </thead>
                                <tbody>
                                    @forelse ($applications as $index => $ap)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                {{ $ap->user->full_name ?? 'N/A' }}
                                                <p>
                                                    <a href="{{ route('admin.show.student', $ap->user->nameSlug) }}"
                                                        class="mt-2 link">Details</a>
                                                </p>
                                            </td>
                                            <td>{{ $ap->user->student->application_unique_number ?? 'N/A' }}</td>
                                            <td>{{ Str::title($ap->department->name ?? 'N/A') }}</td>
                                            <td>{{ $ap->academicSession->session ?? 'N/A' }}</td>

                                            <td>{{ $ap->user->student->exam_score ?? 'Loading ...' }}</td>
                                            <td>
                                                @if ($ap->admission_status == 'pending')
                                                    <span class="badge bg-warning text-light">Pending <i
                                                            class="fa fa-spinner fa-spin"></i></span>
                                                @elseif ($ap->admission_status == 'denied')
                                                    <span class="badge bg-danger text-light">Denied <i
                                                            class="fa fa-times"></i></span>
                                                @elseif ($ap->admission_status == 'approved')
                                                    <span class="badge bg-success text-light">Approved <i
                                                            class="fa fa-check"></i></span>
                                                @endif
                                            </td>

                                            <td>
                                                @if (!empty($ap->payment_id))
                                                    <span class="badge bg-success text-light">Paid <i
                                                            class="fa fa-check"></i></span>
                                                @else
                                                    <span class="badge bg-danger text-light">Not Paid <i
                                                            class="fa fa-times"></i></span>
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
                            {{ $applications->links() }}
                        </div>
                    </div>

                    <div class="mt-5 shadow-sm card">
                        <div class="text-white card-header bg-primary">
                            <h4 class="mb-0 card-title">Available Options for Students</h4>
                        </div>
                        <div class="card-body">
                            <p class="text-danger font-weight-bold">JAMB STATUS:</p>
                            <ul class="mb-4 list-group">
                                <li class="flex-wrap list-group-item d-flex align-items-center">
                                    <span class="mr-2 badge badge-info badge-pill">CHANGE_OF_SCHOOL</span>
                                    Students who changed to our school from JAMB after they had already applied to other
                                    universities but later made the switch to us.
                                </li>
                                <li class="flex-wrap list-group-item d-flex align-items-center">
                                    <span class="mr-2 badge badge-info badge-pill">SELECTED_IN_JAMB</span>
                                    Students who selected our university as their choice when writing JAMB.
                                </li>
                                <li class="flex-wrap list-group-item d-flex align-items-center">
                                    <span class="mr-2 badge badge-info badge-pill">DIRECT_ENTRY</span>
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
