@extends('admin.layouts.adminLayout')

@section('title', 'Scholarship Applicants')

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
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>@yield('title')</h4>
                        </div>
                        <div class="card-body">
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
                                                <th>Student</th>
                                                <th>Scholarship</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($applications as $application)
                                            <tr>
                                                <td>
                                                    <div class="custom-checkbox custom-control">
                                                        <input type="checkbox" name="selected_application[]"
                                                            value="{{ $application->id }}" data-checkboxes="mygroup"
                                                            class="custom-control-input"
                                                            id="checkbox-{{ $application->id }}">
                                                        <label for="checkbox-{{ $application->id }}"
                                                            class="custom-control-label">&nbsp;</label>
                                                    </div>
                                                </td>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    {{ Str::title($application->user->full_name) }}

                                                </td>
                                                <td>
                                                    {{ Str::title($application->scholarship->name) }}
                                                </td>
                                                <td>
                                                    {{ Str::title($application->status) }}
                                                </td>
                                                <td>
                                                    <a href="#" data-toggle="modal" data-target="#exampleModal"
                                                        data-student-slug=""
                                                        class="btn btn-danger">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                    <a title="Applicant Details" href="{{ route('admin.scholarship.applicantShow', $application->id) }}" class="btn btn-info"><i class="fas fa-eye"></i></a>

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
                    {{ $applications->links() }}
                </div>
            </div>
        </div>
    </section>
</div>
@endsection



@section('js')

@endsection
