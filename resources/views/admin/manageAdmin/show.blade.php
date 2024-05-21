@extends('admin.layouts.adminLayout')

@section('title', 'View Admin Manager Details')

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
                    <div class="col-md-7">
                        <div class="card text-left shadow">
                            <div class="card-body">
                                <a href="{{ route('admin.manage.admin') }}" class="btn btn-outline-primary mb-2">Back</a>
                                <div class="table-responsive">
                                    <p>
                                        <img src="{{ empty($user->admin->photo) ? 'null' : asset($user->admin->photo) }}"
                                            alt="" class="img-thumbnail" width="200px" height="200px">
                                    </p>
                                    <table class="table table-striped">
                                        <tr>
                                            <th>Name: </th>
                                            <td>{{ Str::title($user->full_name) }}</td>
                                        </tr>
                                        <tr>
                                            <th>Email</th>
                                            <td>{{ $user->email }}</td>
                                        </tr>
                                        <tr>
                                            <th>Phone</th>
                                            <td>{{ $user->admin->phone }}</td>
                                        </tr>
                                        <tr>
                                            <th>Address</th>
                                            <td>{{ $user->admin->address }}</td>
                                        </tr>
                                        <tr>
                                            <th>Last Login</th>
                                            <td>{{ $user->previous_login_at?->diffForHumans() ?? 'N/A' }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="card shadow p-3">
                            <p>Current Roles</p>
                            <ul class="list-item">
                                @foreach ($user->roles as $role)
                                    @if ($role->name == 'admin')
                                    <li class="list-item badge badge-success">All Access</li>
                                    @else
                                    <li class="list-item badge badge-primary mb-3 mr-3">{{ ucfirst(str_replace('-', ' ', $role->name)) }}</li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

@endsection



@section('js')


@endsection
