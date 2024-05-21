@extends('admin.layouts.adminLayout')

@section('title', 'Assign Role(s) To Administrators')

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
                    <div class="col-md-7 mx-auto">
                        <a href="{{ route('admin.manage.admin') }}" class="btn-info btn mb-4">Back</a>
                        <div class="container card p-4 shadow">
                            <form action="{{ route('admin.attach.roleStore') }}" method="POST">
                                @csrf

                                @if ($selectedAdmin)
                                    <div class="card-header">
                                        <div class="card-title">
                                            <center>
                                                <h3>{{ Str::title($selectedAdmin->full_name) }}</h3>
                                            </center>
                                        </div>
                                    </div>
                                    <input type="hidden" name="user_id" value="{{ $selectedAdmin->id }}">
                                @else
                                    <div class="mb-3">
                                        <label for="user" class="form-label">Select Admin</label>
                                        <select class="form-select form-control @error('user_id') border-danger @enderror"
                                            id="user" name="user_id" >
                                            <option value="" selected>Select Admin</option>
                                            @foreach ($admins as $admin)
                                                <option value="{{ $admin->id }}">{{ $admin->email }}</option>
                                            @endforeach
                                        </select>
                                        @error('user_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <hr>
                                @endif

                                <div class="mb-3">
                                    <label class="form-label">Assign Roles</label>
                                    <div class="row">

                                        @foreach ($roles as $role)
                                            <div class="col-md-3 mb-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="role_{{ $role->id }}" name="roles[]"
                                                        value="{{ $role->id }}"
                                                        @if ($selectedAdmin && $selectedAdmin->roles->contains($role->id)) checked @endif>
                                                    <label class="form-check-label" for="role_{{ $role->id }}">
                                                        @if ($role->name == 'admin')
                                                        {{ Str::title('All Access') }}
                                                        @else
                                                        {{ ucfirst(str_replace('-', ' ', $role->name)) }}

                                                        @endif
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    @error('roles')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                    @error('roles.*')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary">Assign Roles</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

@endsection



@section('js')


@endsection
