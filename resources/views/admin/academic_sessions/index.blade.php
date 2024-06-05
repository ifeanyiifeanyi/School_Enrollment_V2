@extends('admin.layouts.adminLayout')

@section('title', 'Academic Session Manager')

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
                                    <div class="float-left">
                                        <a href="{{ route('admin.academicSession.create') }}" class="btn btn-primary mb-3">Create
                                            Session</a>
                                    </div>

                                    <div class="table-responsive">
                                        <table class="table table-striped" id="table-1">
                                            <thead>
                                                    <th>sn</th>
                                                    <th>Name</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($academicSessions as $ads)
                                                    {{-- @dd($student->id) --}}
                                                    <tr>

                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>
                                                            {{ Str::title($ads->session) }}
                                                        </td>
                                                        <td>
                                                            <p class="text-muted">{{ Str::title($ads->status) }}</p>
                                                        </td>
                                                        <td>
                                                            <a href="#" data-toggle="modal"
                                                                data-target="#exampleModal"
                                                                data-session-id="{{ $ads->id }}"
                                                                class="btn btn-danger btn-sm">
                                                                <i class="fas fa-trash"></i>
                                                            </a>
                                                            <a href="{{ route('admin.academicSession.edit', $ads) }}"
                                                                class="btn btn-info btn-sm"><i
                                                                    class="fas fa-edit"></i>
                                                            </a>

                                                            <a href="{{ route('admin.academicSession.applications', $ads) }}"
                                                            class="btn btn-primary btn-sm"><i
                                                                class="fas fa-user-tag"></i>
                                                        </a>
                                                        </td>
                                                    </tr>
                                                @empty
                                                <div class="alert alert-danger">No Sessions yet ... </div>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>

                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">
                        {{-- {{ $academicSessions->links() }} --}}
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
                    <a href="#" class="btn btn-danger" id="deleteSingleSession">Delete</a>
                </div>
            </div>
        </div>
    </div>
@endsection



@section('js')
    <script>
        $('#exampleModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var sessionId = button.data('session-id');
            var modal = $(this);
            modal.find('#deleteSingleSession').attr('href', '/admin/delete-session/' + sessionId);
        });
    </script>

@endsection
