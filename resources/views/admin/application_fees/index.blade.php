@extends('admin.layouts.adminLayout')

@section('title', 'Applications Fee Manager')

@section('css')

    <style>
        .admin-actions-container {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .import-section,
        .filter-section {
            padding: 1rem;
        }

        .action-buttons .btn {
            transition: all 0.3s ease;
        }

        .action-buttons .btn:hover {
            transform: translateY(-1px);
        }

        .input-group {
            display: flex;
            gap: 0.5rem;
        }

        .input-group .form-control {
            border-radius: 4px;
        }

        @media (max-width: 768px) {
            .action-buttons {
                flex-direction: column;
            }

            .action-buttons .btn {
                width: 100%;
                margin-bottom: 0.5rem;
            }
        }

        /* Print styles */
        @media print {
            .admin-actions-container {
                display: none;
            }
        }
    </style>
    <style>
        /* Summary Cards Styles */
        .stats-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            border-radius: 8px;
            padding: 1.5rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-2px);
        }

        .stat-card__title {
            color: #6c757d;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.5rem;
        }

        .stat-card__value {
            font-size: 1.5rem;
            font-weight: 600;
            color: #2d3748;
        }

        /* Action Buttons Container */
        .action-buttons-container {
            display: flex;
            justify-content: flex-end;
            gap: 0.5rem;
            margin-bottom: 1rem;
            clear: both;
        }

        /* Search and Filter Container */
        .search-filter-container {
            display: flex;
            gap: 1rem;
            margin-bottom: 1rem;
            align-items: center;
        }

        .search-container {
            flex: 1;
            position: relative;
            margin: 0;
        }

        .search-input {
            width: 100%;
            padding: 15px 20px 15px 45px;
            border-radius: 30px;
            border: 2px solid #e9ecef;
        }

        /* Department Filter */
        .department-filter {
            width: 300px;
        }

        /* Import Form */
        .import-form-container {
            margin-bottom: 1rem;
        }

        /* Print Styles */
        @media print {

            /* Hide sidebar and other non-printable elements */
            .main-sidebar,
            .navbar,
            .section-header,
            .non-printable,
            .search-container,
            .paginate {
                display: none !important;
            }

            /* Adjust main content for printing */
            .main-content {
                margin-left: 0 !important;
                padding: 0 !important;
            }

            /* Ensure full width for content */
            .card,
            .card-body,
            .table-responsive {
                width: 100% !important;
                margin: 0 !important;
                padding: 0.5rem !important;
                border: none !important;
                box-shadow: none !important;
            }

            /* Optimize stats cards for printing */
            .stats-cards {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                gap: 0.5rem;
                margin-bottom: 1rem;
                page-break-inside: avoid;
            }

            .stat-card {
                border: 1px solid #ddd;
                padding: 0.5rem;
                margin: 0;
                box-shadow: none;
            }

            /* Table styles for print */
            .table {
                font-size: 10pt;
                border-collapse: collapse;
                width: 100% !important;
            }

            .table th,
            .table td {
                border: 1px solid #ddd;
                padding: 4px;
            }

            /* Status badges */
            .badge {
                border: 1px solid #000;
                padding: 2px 5px;
                font-weight: normal;
            }

            /* Ensure page breaks don't split rows */
            tr {
                page-break-inside: avoid;
            }
        }


        .action-buttons {
            display: flex;
            justify-content: space-around;
        }

        .card {
            width: 100%;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
        }

        .loader-overlay {
            display: none;
            position: fixed;
            z-index: 9999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.8);
        }

        .search-container {
            position: relative;
            width: 100%;
            margin: 20px 0;
            text-align: center;
        }

        .search-input {
            width: 80%;
            padding: 15px 20px 15px 45px;
            border-radius: 30px;
            border: 2px solid #e9ecef;
        }

        /* Print Styles */
        @media print {
            .stats-cards {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                gap: 1rem;
                margin-bottom: 2rem;
                page-break-inside: avoid;
            }

            .stat-card {
                border: 1px solid #ddd;
                break-inside: avoid;
            }

            .non-printable {
                display: none !important;
            }

            .table {
                font-size: 10pt;
                width: 100% !important;
            }

            .badge {
                border: 1px solid #000;
                padding: 2px 5px;
            }
        }

        */
    </style>
@endsection

@section('admin')
    <div class="loader-overlay" id="loader-overlay">
        <div class="loader"></div>
    </div>

    <div class="main-content">
        <!-- Import Errors -->
        @if (session('import_errors'))
            <div class="alert alert-danger non-printable">
                <h4>Import Errors:</h4>
                <ul>
                    @foreach (session('import_errors') as $error)
                        <li>{{ $error }}</li>
                    @endforeach <!-- Import Errors -->
                    @if (session('import_errors'))
                        <div class="alert alert-danger non-printable">
                            <h4>Import Errors:</h4>
                            <ul>
                                @foreach (session('import_errors') as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Success Message -->
                    @if (session('success'))
                        <div class="alert alert-success non-printable">
                            {{ session('success') }}
                        </div>
                    @endif

                </ul>
            </div>
        @endif

        <!-- Success Message -->
        @if (session('success'))
            <div class="alert alert-success non-printable">
                {{ session('success') }}
            </div>
        @endif

        <!-- Summary Statistics -->
        <div class="stats-cards">
            <div class="stat-card">
                <div class="stat-card__title">Total Applications</div>
                <div class="stat-card__value">{{ number_format($totalStudents) }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-card__title">Total Amount</div>
                <div class="stat-card__value">₦{{ number_format($totalStudents * 10000, 2) }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-card__title">Approved Applications</div>
                <div class="stat-card__value">
                    {{ number_format($applications->where('admission_status', 'approved')->count()) }}
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-card__title">Pending Applications</div>
                <div class="stat-card__value">
                    {{ number_format($applications->where('admission_status', 'pending')->count()) }}
                </div>
            </div>
          
        </div>

        @include('student.alert')


        <section class="section">
           
           

            <div class="section-body">
                <div class="card">
                   
                    <!-- Main Content -->
                    <div class="card-body">
                        <div class="search-container non-printable">
                            <input type="search" id="search" class="search-input" placeholder="Search Students...">
                            <i class="search-icon fas fa-search"></i>
                        </div>
                        <!-- Admin Actions Section -->
                        <div class="row mt-3 mb-4 p-4 rounded-lg shadow-sm admin-actions-container">
                            <div class="col-md-6">
                              
                                    <form id="departmentForm" action="{{ route('admin.student.application') }}"
                                        method="GET" class="mb-3">
                                        <label class="mb-2 form-label fw-bold">Filter by Department</label>
                                        <select class="form-control" name="department_id"
                                            onchange="updateExportLink(); this.form.submit();">
                                            <option value="">All Departments</option>
                                            @foreach ($departments as $department)
                                                <option value="{{ $department->id }}"
                                                    {{ request('department_id') == $department->id ? 'selected' : '' }}>
                                                    {{ Str::title($department->name) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </form>
                                
                            </div>

                            <!-- Bottom Action Buttons -->
                            <div class="col-md-6 mt-4">
                                <button onclick="printApplications()" class="btn btn-secondary">
                                    <i class="fas fa-print"></i> Print
                                </button>

                               
                               

                                <a href="{{ route('admin.student.applications.export') }}" class="btn btn-info"
                                    id="exportButton">
                                    <i class="fas fa-file-export"></i> Export to Excel
                                </a>
                            </div>
                        </div>




                        <!-- Applications Table -->
                        <div class="table-responsive">
                            <table class="table table-striped" id="datatable">
                                <thead>
                                    <tr>
                                        <th style="width: 20px">S/N</th>
                                        <th>Student</th>
                                        <th>Phone Number</th>
                                        <th>Jamb Reg. Number</th>
                                        <th>Guardian No.</th>
                                        <th>Amount</th>
                                        <th>Department</th>
                                    </tr>
                                </thead>
                                <tbody id="applicationTableBody">
                                    @forelse ($applications as $ap)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                {{ Str::title($ap->user->full_name) ?? 'N/A' }}
                                                <p class="non-printable">
                                                    <a href="{{ route('admin.show.student', $ap->user->nameSlug) }}"
                                                        class="mt-2 link">Details</a>
                                                </p>
                                            </td>
                                            <td>{{ $ap->user->student->phone }}</td>
                                            <td>{{ $ap->user?->student->jamb_reg_no ?? 'N/A' }}</td>
                                            <td>{{ $ap->user?->student->guardian_phone_number ?? 'N/A' }}</td>
                                            <td>₦{{ number_format(10000, 2) }}</td>
                                            <td>{{ Str::title($ap->department?->name ?? 'N/A') }}</td>
                                           
                                            
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">No applications available</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="text-center paginate non-printable">
                            {!! $applications->links('pagination::bootstrap-4') !!}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('js')
    <script>
        // Search functionality
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

        // Department filter
        document.addEventListener('DOMContentLoaded', function() {
            const selectElement = document.querySelector('.selectric');
            selectElement.addEventListener('change', function(event) {
                const form = document.getElementById('departmentForm');
                form.submit();
            });
        });

        // Export link update
        function updateExportLink() {
            const departmentId = document.querySelector('[name="department_id"]').value;
            const exportButton = document.getElementById('exportButton');
            let url = '{{ route('admin.student.applications.export') }}';
            url += departmentId ? '?department_id=' + departmentId : '';
            exportButton.href = url;
        }

        // Import loader
        document.addEventListener('DOMContentLoaded', function() {
            const importForm = document.getElementById('import-form');
            const loaderOverlay = document.getElementById('loader-overlay');

            importForm.addEventListener('submit', function() {
                loaderOverlay.style.display = 'block';
            });
        });

        // Print function
        function printApplications() {
            window.print();
        }
    </script>
@endsection
