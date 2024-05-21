@extends('admin.layouts.adminLayout')

@section('title', 'Update Department Details ..')

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
                            <h4>Update Department</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.update.department', $department->slug) }}" method="post">
                                @csrf
                                @method('patch')
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Select Associated Faculty For Department</label>
                                    <div class="col-sm-12 col-md-7">
                                        <select class="form-control" name="faculty_id">
                                            <option value="" disabled selected>Select Faculty</option>
                                            @forelse ($faculties as $faculty)
                                                <option {{ $department->faculty_id == $faculty->id ? 'selected' : '' }} value="{{ $faculty->id }}">{{ Str::title($faculty->name) }}</option>
                                            @empty
                                                <option value="" disabled>Not Available</option>
                                            @endforelse
                                        </select>
                                        @error('faculty_id')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Department Name</label>
                                    <div class="col-sm-12 col-md-7">
                                        <input type="text" class="form-control" name="name" value="{{ old('name', $department->name) }}">
                                        @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">department
                                        Description</label>
                                    <div class="col-sm-12 col-md-7">
                                        <textarea class="summernote-simple" name="description">{{ $department->description ?? '' }}</textarea>
                                        @error('description')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                                    <div class="col-sm-12 col-md-7">
                                        <button type="submit" class="btn btn-primary">Publish</button>
                                    </div>
                                </div>
                            </form>
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