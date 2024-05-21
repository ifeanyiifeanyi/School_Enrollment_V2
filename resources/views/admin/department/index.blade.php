@extends('admin.layouts.adminLayout')

@section('title', 'Department Management')

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
                            <a href="{{ route('admin.create.department') }}" class="btn btn-outline-primary">Create new
                                <i class="fas fa-plus"></i></a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="table-2">
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
                                            <th style="width: 15px !important">s/n</th>
                                            <th>Name</th>
                                            <th>Faculty Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($departments as $department)
                                        <tr>
                                            <td>
                                                <div class="custom-checkbox custom-control">
                                                    <input type="checkbox" data-checkboxes="mygroup"
                                                        class="custom-control-input" id="checkbox-1">
                                                    <label for="checkbox-1" class="custom-control-label">&nbsp;</label>
                                                </div>
                                            </td>
                                            <td>{{ $loop->iteration }}</td>

                                            <td>
                                                <p class="text-muted">{{ Str::title($department->name) }}</p>
                                                
                                            </td>
                                            <td>
                                                <p class="text-muted">{{ Str::title($department->faculty->name) }}</p>
                                            </td>
                                            <td class="btn-group">
                                                {{-- <a href="{{ route('admin.show.department', $department->slug) }}"
                                                    class="btn btn-secondary"><i class="fas fa-user"></i></a> --}}

                                                <a href="{{ route('admin.edit.department', $department->slug) }}"
                                                    class="btn btn-primary"><i class="fas fa-edit"></i></a>

                                                <a data-toggle="modal" data-target="#exampleModal"
                                                    data-department-slug="{{ $department->slug }}" href="#"
                                                    class="btn btn-danger"><i class="fas fa-trash"></i></a>

                                            </td>
                                        </tr>

                                        @empty
                                        <div class="alert alert-danger">Not Availabe ....</div>
                                        @endforelse
                                    </tbody>
                                </table>
                                {{ $departments->links() }}
                            </div>
                        </div>
                    </div>
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
                <a href="#" class="btn btn-danger" id="deleteDepartment">Delete</a>
            </div>
        </div>
    </div>
</div>
@endsection



@section('js')
<script>
    $('#exampleModal').on('show.bs.modal', function (event) {
       var button = $(event.relatedTarget);
       var departmentSlug = button.data('department-slug');
       var modal = $(this);
       modal.find('#deleteDepartment').attr('href', '/admin/delete-department/' + departmentSlug);
    });
  </script>
@endsection