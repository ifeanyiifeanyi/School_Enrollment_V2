@extends('admin.layouts.adminLayout')

@section('title', 'Academic Session Manager | Create new')

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
                                <div class="row">
                                    <div class="col-md-6 mx-auto">
                                        <form action="{{ route('admin.academicSession.store') }}" method="POST">
                                            @csrf
                                            <div class="form-group mb-3">
                                                <label for="session">Session</label>
                                                <input type="text" name="session" id="session" class="form-control" value="{{ old('session') }}">
                                                @error('session')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="session">Session Status</label>
                                                <select type="text" name="status" id="status" class="form-control">
                                                    <option value="" disabled selected>Select Satus</option>
                                                    <option {{ old('current') }} value="current">Current</option>
                                                    <option {{ old('previous') }} value="previous">Previous</option>
                                                </select>
                                                @error('status')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <button type="submit" class="btn btn-secondary">Create</button>
                                        </form>
                                    </div>
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
