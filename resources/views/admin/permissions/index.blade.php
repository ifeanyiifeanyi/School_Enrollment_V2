@extends('admin.layouts.adminLayout')

@section('title', 'Create and Manage Permissions')

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
                    <div class="col-md-8 mx-auto">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Permissions</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('admin.permissions.store') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="name">New Permission</label>
                                        <input type="text" name="name" id="name"
                                            class="form-control @error('name') border-danger @enderror" value="{{ old('name') }}">
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-primary">Create Permission</button>
                                </form>
                            </div>
                        </div>

                        <div class="card mt-4">
                            <div class="card-header">
                                <h4 class="card-title">Existing Permissions</h4>
                            </div>
                            <div class="card-body">
                                <ul>
                                    @foreach ($permissions as $permission)
                                        <li class="list-item badge badge-info mb-3 mr-3" style="text-align: justify">
                                            {{ ucfirst(str_replace('-', ' ', $permission->name)) }}</li>
                                    @endforeach
                                </ul>
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
