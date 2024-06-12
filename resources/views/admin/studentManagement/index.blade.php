@extends('admin.layouts.adminLayout')

@section('title', 'Student Management')

@section('css')
<style>
    table tr {
        border-bottom: 2px solid #ccc
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
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>@yield('title')</h4>
                        </div>
                        <div class="card-body">
                            <div class="float-left pb-1">
                                <a href="{{ route('admin.export.allStudent') }}" class="btn btn-primary shadow" id="exportButton">Export to Excel</a>
                            </div>

                            <form id="bulk-action-form" method="POST"
                                action="{{ route('admin.students.deleteMultiple') }}">
                                @csrf
                                <div class="float-right mb-3">
                                    <select class="form-control selectric"
                                        onchange="if (this.value) { this.form.submit(); }">
                                        <option value="">Action For Selected</option>
                                        <option value="delete">Delete Permanently</option>
                                    </select>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-striped" id="table-1">
                                        <thead>
                                            <tr>
                                                <th class="text-center" style="width: 15px !important">
                                                    <div class="custom-checkbox custom-control">
                                                        <input type="checkbox" data-checkboxes="mygroup"
                                                            data-checkbox-role="dad" class="custom-control-input"
                                                            id="checkbox-all">
                                                        <label for="checkbox-all"
                                                            class="custom-control-label">&nbsp;</label>
                                                    </div>
                                                </th>
                                                <th>sn</th>
                                                <th>Student Name</th>
                                                <th>Phone</th>
                                                <th>Department</th>
                                                <th>Application Date</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($students as $student)
                                            {{-- @dd($student->id) --}}
                                            <tr>
                                                <td>
                                                    <div class="custom-checkbox custom-control">
                                                        <input type="checkbox" name="selected_students[]"
                                                            value="{{ $student->id }}" data-checkboxes="mygroup"
                                                            class="custom-control-input"
                                                            id="checkbox-{{ $student->id }}">
                                                        <label for="checkbox-{{ $student->id }}"
                                                            class="custom-control-label">&nbsp;</label>
                                                    </div>
                                                </td>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    {{ Str::title($student->full_name ?? 'N/A' ) }}
                                                    <p><code>{{ $student->student->application_unique_number ?? 'N/A'  }}</code>
                                                    </p>
                                                    <a title="View Student Details"
                                                        href="{{ route('admin.show.student', $student->nameSlug) }}"><i
                                                            class="fas fa-binoculars"></i>
                                                    </a>
                                                    <div class="bullet"></div>
                                                    <a title="Edit Student Basic Details" href="{{ route('admin.edit.student', $student->nameSlug) }}">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <div class="bullet"></div>
                                                    <a title="Delete Student Account" data-toggle="modal" data-target="#exampleModal"
                                                        data-student-slug="{{ $student->nameSlug }}" href="#"
                                                        class="text-danger"><i class="fas fa-trash"></i></a>

                                                </td>
                                                <td>
                                                    {{ $student->student->phone }}
                                                </td>
                                                <td class="align-middle">
                                                    @if ($student->applications->isNotEmpty())
                                                    @foreach ($student->applications as $application)
                                                    <p>{{ $application->department_name ?? 'N/A' }}</p>
                                                    @endforeach
                                                    @else
                                                    <p>N/A</p>
                                                    @endif
                                                </td>

                                                <td>
                                                    @if ($student->applications->isNotEmpty())
                                                    @foreach ($student->applications as $application)
                                                    <p>
                                                        {{ \Carbon\Carbon::parse($application->created_at)->format('jS F
                                                        Y') }}
                                                    </p>
                                                    @endforeach

                                                    @else

                                                    null
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($student->applications->isNotEmpty())
                                                    @if ($student->applications->contains('payment_id', '!=', null))
                                                    <span class="badge bg-success text-light">Applied</span>
                                                    @else
                                                    <span class="badge bg-secondary text-light">Unknown</span>
                                                    @endif
                                                    @else
                                                    <span class="badge bg-danger text-light">Not Applied</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="#" data-toggle="modal" data-target="#exampleModal"
                                                        data-student-slug="{{ $student->nameSlug }}"
                                                        class="btn btn-danger btn-sm"><i class="fas fa-trash"></i>
                                                    </a>
                                                    <a href="{{ route('admin.show.student', $student->nameSlug) }}" class="btn btn-sm btn-info">
                                                        <i class="fas fa-user"></i>
                                                    </a>
                                                    <a href="{{ route('admin.edit.student', $student->nameSlug) }}" class="btn btn-sm btn-secondary">
                                                        <i class="fas fa-edit"></i>
                                                    </a>

                                                </td>
                                            </tr>
                                            @empty

                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-center">
                    {{ $students->links() }}
                </div>
            </div>
        </div>
    </section>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="exampleModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger"><i class="fas fa-exclamation-triangle fa-3x"></i> Warning</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are You Sure? <br> This action can not be undone. Do you want to continue?</p>
            </div>
            <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <a href="#" class="btn btn-danger" id="deleteSingleStudent">Delete</a>
            </div>
        </div>
    </div>
</div>



@endsection



@section('js')
<script>
    $('#exampleModal').on('show.bs.modal', function (event) {
       var button = $(event.relatedTarget);
       var studentSlug = button.data('student-slug');
       var modal = $(this);
       modal.find('#deleteSingleStudent').attr('href', '/admin/delete-student/' + studentSlug);
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const masterCheckbox = document.getElementById('checkbox-all');
        const checkboxes = document.querySelectorAll('input[name="selected_students[]"]');

        masterCheckbox.addEventListener('change', function () {
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });
    });
</script>

@endsection
