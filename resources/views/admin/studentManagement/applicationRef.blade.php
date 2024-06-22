@extends('admin.layouts.adminLayout')

@section('title', 'Application Detail Verification Details')

@section('css')
    <style>
        tr {
            border-bottom: 2px solid #dee !important;
        }
    </style>

@endsection

@section('admin')

    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>@yield('title')</h1>
            </div>

            <div class="section-body">

                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-body">

                        <div class="clearfix mb-3"></div>

                        <div class="float-left">
                            <form id="departmentForm" action="{{ route('admin.student.applicationRef') }}" method="GET">
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
                            <a href="{{ route('admin.student.applications.exportPDF') }}" class="btn btn-primary"
                                id="exportButton">Export to PDF <i class="fas fa-file"></i></a>
                        </div>
                        <div class="table-responsive">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 20px">s/n</th>
                                        <th style="width: auto !important">Student</th>
                                        <th>profile</th>
                                        <th style="width: 40px">Invoice</th>
                                        <th>Department</th>
                                        <th>Decision</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($applications as $ap)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td class="align-middle">
                                                {{ Str::title($ap->user->full_name) }} <br>
                                                <code>{{ $ap->user->student->application_unique_number ?? 'N/A' }}</code>

                                            </td>
                                            <td class="align-middle">
                                                <img src="{{ empty($ap->user->student->passport_photo) ? asset('student.png') : asset($ap->user->student->passport_photo) }}"
                                                    alt="" class="img-fluid" width="90">
                                            </td>
                                            <td class="align-middle">
                                                <p>{{ $ap->invoice_number ?? 'N/A' }}</p>

                                            </td>
                                            <td class="align-middle">{{ Str::title($ap->department->name) ?? 'N/A' }}</td>
                                            <td class="align-middle">
                                                <p>{{ Str::upper(str_replace('_', ' ',$ap->user->student->jamb_selection ?? '')) }}</p>
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
            let url = '{{ route('admin.student.applications.exportPDF') }}';
            url += departmentId ? '?department_id=' + departmentId : '';
            exportButton.href = url;
        }
        document.addEventListener('DOMContentLoaded', function() {
            updateExportLink(); // Update on load in case there's an initial department selected
        });
    </script>

@endsection
