@extends('admin.layouts.adminLayout')

@section('title', 'Manage Roles')

@section('css')
    <style>
        .role-list {
            list-style: none;
            padding-left: 0;
        }

        .role-list>li {
            position: relative;
            padding-left: 30px;
            margin-bottom: 10px;
        }

        .role-list>li::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            width: 20px;
            height: 20px;
            background-image: url({{ asset('permission.png') }});
            /* Update the path to your image */
            background-size: cover;
            background-repeat: no-repeat;
        }

        .role-permissions {
            list-style: none;
            margin-left: 30px;
            padding-left: 0;
        }

        .role-permissions>li {
            position: relative;
            padding-left: 25px;
            margin-bottom: 5px;
        }

        .role-permissions>li::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            width: 15px;
            height: 15px;
            background-image: url({{ asset('icons8.png') }});
            /* Update the path to your image */
            background-size: cover;
            background-repeat: no-repeat;
        }

        .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #e3e6f0;
            padding: 0.75rem 1.25rem;
        }

        .card-title {
            margin-bottom: 0;
            font-size: 1.25rem;
            font-weight: 500;
        }

        .card-body {
            padding: 1.25rem;
        }

        .card {
            border: 1px solid #e3e6f0;
            border-radius: 0.35rem;
        }

        .mt-4 {
            margin-top: 1.5rem !important;
        }
    </style>

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
                                <h4 class="card-title">Create Role</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('admin.store.role') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="name">Role Name</label>
                                        <input type="text" name="name" id="name"
                                            class="form-control @error('name') border-danger @enderror"
                                            value="{{ old('name') }}">
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Permissions</label>
                                        <div class="row">
                                            @foreach ($permissions as $permission)
                                                <div class="col-md-4 m">
                                                    <div class="form-check">
                                                        <input type="checkbox" name="permissions[]"
                                                            id="permission_{{ $permission->id }}"
                                                            value="{{ $permission->id }}" class="form-check-input" value="{{ old('permissions[]') }}">
                                                        <label for="permission_{{ $permission->id }}"
                                                            class="form-check-label">{{ $permission->name }}</label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        @error('permissions')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        @error('permissions.*')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-primary">Create Role</button>
                                </form>
                            </div>
                        </div>

                        <div class="card mt-4">
                            <div class="card-header">
                                <h4 class="card-title">Existing Roles</h4>
                            </div>
                            <div class="card-body">
                                <ul class="role-list">
                                    @foreach ($roles as $role)
                                        <li>
                                            <strong>{{ ucfirst(str_replace('-', ' ', $role->name)) }}</strong>

                                        </li>
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
