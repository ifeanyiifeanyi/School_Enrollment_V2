@extends('admin.layouts.adminLayout')

@section('title', 'Role Manager')

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
    strong{
        color: rgb(238, 18, 198);
        font-family: Verdana, Geneva, Tahoma, sans-serif;
        font-size: 19px;
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
            <div class="mt-4 shadow card">
                <div class="card-header">
                    <h4 class="card-title">Existing Roles</h4>
                </div>
                <div class="card-body">
                    <ul class="role-list">
                        @foreach ($roles as $role)
                            <li>
                                <strong>{{ ucfirst(str_replace('-', ' ', $role->name)) }}</strong>
                                @if ($role->permissions->isNotEmpty())
                                    <br>
                                    <span>Permissions:</span>
                                    <ul class="role-permissions">
                                        @foreach ($role->permissions as $permission)
                                            <li class="list-item badge badge-info">{{ ucfirst(str_replace('-', ' ', $permission->name)) }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                {{-- {{ $roles->links() }} --}}
                {!! $roles->links('pagination::bootstrap-4') !!}
                </div>
            </div>

        </div>
    </section>
</div>
@endsection



@section('js')

@endsection
