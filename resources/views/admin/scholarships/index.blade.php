@extends('admin.layouts.adminLayout')

@section('title', 'Scholarship Manager')

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
                    <div class="col-md-5">
                        <div class="card">
                            <div class="card-header">
                                Create scholarship
                            </div>
                            <div class="card-body">
                                <form method="POST"
                                    action="{{ isset($scholarship) ? route('admin.update.scholarship', $scholarship->slug) : route('admin.store.scholarship') }}">

                                    @csrf
                                    @if (isset($scholarship))
                                        @method('PUT')
                                    @endif
                                    <div class="form-group mb-3">
                                        <label for="name">Scholarship Name</label>
                                        <input type="text" class="form-control @error('name') border-danger @enderror"
                                            name="name" placeholder="Scholarship Name"
                                            value="{{ isset($scholarship) ? $scholarship->name : old('name') }}">
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="description">Scholarship Description</label>
                                        <textarea class="summernote-simple" placeholder="Scholarship description" name="description" id="" cols="30" rows="10"
                                            class="form-control @error('description') border-danger @enderror">{{ isset($scholarship) ? $scholarship->description : old('description') }}</textarea>
                                        @error('description')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <input type="submit" value="{{ isset($scholarship) ? 'Update' : 'Submit' }}"
                                        class="btn btn-info">
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-7">
                        <div class="card">

                            <div class="card-body">
                                <div class="table-responsive">

                                    <table class="table table-hover">
                                        <tr>
                                            <th>sn</th>
                                            <th>Name</th>
                                            <th>Action</th>
                                        </tr>

                                        @forelse ($scholarships as $ship)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ Str::title($ship->name) }}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a title="edit scholarship" href="{{ route('admin.edit.scholarship', $ship->slug) }}"
                                                            class="btn btn-info">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <a title="view details" href="{{ route('admin.view.scholarship', $ship->slug) }}" class="btn btn-primary">
                                                            <i class="fas fa-user"></i>
                                                        </a>
                                                        <a title="delete scolarship" href="#!" data-toggle="modal" data-target="#exampleModal"
                                                            data-scholarship-slug="{{ $ship->slug }}"
                                                            class="btn btn-danger">
                                                            <i class="fas fa-trash"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <div class="alert alert-danger">Not Available !!!</div>
                                        @endforelse
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
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
                        <a href="#" class="btn btn-danger" id="deleteScholarship">Delete</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection



@section('js')
    <script>
        $('#exampleModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var slug = button.data('scholarship-slug');
            var modal = $(this);
            modal.find('#deleteScholarship').attr('href', '/admin/scholarships/delete/' + slug);
        });
    </script>
@endsection
