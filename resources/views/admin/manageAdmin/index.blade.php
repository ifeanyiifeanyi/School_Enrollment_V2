@extends('admin.layouts.adminLayout')

@section('title', 'Admin Manager')

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
                                    <div class="float-left">
                                        <a href="{{ route('admin.manage.create') }}" class="btn btn-primary">Create
                                            Admin</a>
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
                                                    <th>Name</th>
                                                    <th>Role</th>
                                                    <th>photo</th>
                                                    <th>Last Login</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($admins as $admin)
                                                    {{-- @dd($student->id) --}}
                                                    <tr>
                                                        <td>
                                                            <div class="custom-checkbox custom-control">
                                                                <input type="checkbox" name="selected_admins[]"
                                                                    value="{{ $admin->id }}" data-checkboxes="mygroup"
                                                                    class="custom-control-input"
                                                                    id="checkbox-{{ $admin->id }}">
                                                                <label for="checkbox-{{ $admin->id }}"
                                                                    class="custom-control-label">&nbsp;</label>
                                                            </div>
                                                        </td>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>
                                                            {{ Str::title($admin->full_name) }}
                                                            <br>
                                                            <a title="View Student Details"
                                                                href="{{ route('admin.manage.show', $admin->nameSlug) }}"><i
                                                                    class="fas fa-binoculars"></i>
                                                            </a>
                                                            <div class="bullet"></div>
                                                            <a title="Edit Student Basic Details"
                                                                href="{{ route('admin.manage.edit', $admin->nameSlug) }}">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                            <div class="bullet"></div>
                                                            <a title="Delete Student Account" data-toggle="modal"
                                                                data-target="#exampleModal"
                                                                data-user-slug="{{ $admin->nameSlug }}" href="#"
                                                                class="text-danger"><i class="fas fa-trash"></i></a>

                                                        </td>
                                                        <td>
                                                            <p class="text-muted">{{ Str::title($admin->role) }}</p>
                                                        </td>
                                                        <td>
                                                            <img alt="image"
                                                                src="{{ empty($admin->admin->photo) ? asset('admin/assets/img/avatar/avatar-5.png') : asset($admin->admin->photo) }}"
                                                                class="img-responsive -img-thumbnail" width="90"
                                                                data-toggle="title" title="{{ $admin->last_name }}">
                                                        </td>
                                                        <td>{{ $admin->previous_login_at?->diffForHumans() ?? 'N/A' }}</td>
                                                        <td>
                                                            <a href="#" data-toggle="modal"
                                                                data-target="#exampleModal"
                                                                data-user-slug="{{ $admin->nameSlug }}"
                                                                class="btn btn-danger btn-sm">
                                                                <i class="fas fa-trash"></i>
                                                            </a>
                                                            <a href="{{ route('admin.assign.role',['user_id' => $admin->id]) }}"
                                                                class="btn btn-info btn-sm"><i
                                                                    class="fas fa-user-tag"></i></a>
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
                        {{-- {{ $admins->links() }} --}}
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
                    <a href="#" class="btn btn-danger" id="deleteSingleUser">Delete</a>
                </div>
            </div>
        </div>
    </div>
@endsection



@section('js')
    <script>
        $('#exampleModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var studentSlug = button.data('user-slug');
            var modal = $(this);
            modal.find('#deleteSingleUser').attr('href', '/admin/delete-user/' + studentSlug);
        });
    </script>

@endsection
