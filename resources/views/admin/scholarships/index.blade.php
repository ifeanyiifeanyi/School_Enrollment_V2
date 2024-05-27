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
                                    @if(isset($scholarship))
                                        @method('PUT')
                                    @endif
                                    <div class="form-group mb-3">
                                        <label for="name">Scholarship Name</label>
                                        <input type="text" class="form-control @error('name') border-danger @enderror"
                                            name="name" placeholder="Scholarship Name" value="{{ isset($scholarship) ? $scholarship->name : old('name') }}">
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="description">Scholarship Description</label>
                                        <textarea placeholder="Scholarship description" name="description" id="" cols="30" rows="10"
                                            class="form-control @error('description') border-danger @enderror">{{ isset($scholarship) ? $scholarship->description : old('description') }}</textarea>
                                        @error('description')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <input type="submit" value="{{ isset($scholarship) ? 'Update' : 'Submit' }}" class="btn btn-info">
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="card">

                            <div class="card-body">
                                {{-- <a width="20px" href="{{ route('admin.create.scholarship') }}"
                                    class="mb-4 btn btn-primary">Create
                                    Scholarship</a> --}}
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
                                                        <a href="{{ route('admin.edit.scholarship', $ship->slug) }}"
                                                            class="btn btn-info">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <a href="" class="btn btn-info"></a>
                                                        <a href="" class="btn btn-info"></a>
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
    </div>
@endsection



@section('js')

@endsection
