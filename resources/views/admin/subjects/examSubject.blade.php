@extends('admin.layouts.adminLayout')

@section('title', 'Exam Subjects')

@section('css')

@endsection

@section('admin')

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>@yield('title')</h1>
        </div>

        <div class="section-body">
            <div class="container">
                <div class="row">
                    <div class="mx-auto shadow col-md-6">
                        <div class="mb-3 section">
                            <form action="{{ route('admin.subject.store') }}" method="post">
                                @csrf
                                <div class="mb-3 mt-3form-group">
                                    <label for="subject">Exam Subject</label>
                                    <input type="text" name="name" id="name" placeholder="Eg. Mathematics"
                                        class="form-control @error('name') border-danger  @enderror"
                                        value="{{ old('name') }}">
                                    @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary"><i class="fas fa-sd-card"></i>
                                    save</button>
                            </form>
                        </div>
                        <div class="text-center d-flex justify-content-center">
                            <div class="table-responsive">
                                <table class="table table-striped table-inverse" style="width: 100%">
                                    <thead class="thead-inverse">
                                        <tr>
                                            <th>sn</th>
                                            <th>Subject</th>
                                            <th>Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($subjects as $subject)
                                        <tr>
                                            <td scope="row">{{ $loop->iteration }}</td>
                                            <td>{{ Str::title($subject->name) }}</td>
                                            <td>
                                                <a onclick="return confirm('Are You Sure ?')" href="{{ route('admin.subject.del', $subject) }}" class="btn btn-sm btn-danger"><i class="fas fa-times"></i></a>
                                            </td>
                                        </tr>
                                        @empty
                                            <div class="alert alert-danger">Try Again Later <i class="fas fa-spinner fa-spin"></i></div>
                                        @endforelse
                                        

                                    </tbody>
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