@extends('admin.layouts.adminLayout')

@section('title', 'Manage Roles and Permissions')

@section('css')
<style>
    .card-body ul {
        list-style-type: none;
        padding: 0;
    }
    .card-body ul ul {
        list-style-type: circle;
        padding-left: 20px;
    }
    .card-body .permission-card {
        margin-bottom: 20px;
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
                <div class="col-md-12">
                    <div class="shadow card permission-card">
                        <div class="card-header">
                            <h4 class="card-title">Permissions and Their Roles</h4>
                        </div>
                        <div class="card-body">
                            @foreach ($permissions as $permission)
                                <div class="mb-3">
                                    <h5>{{ ucfirst(str_replace('-', ' ', $permission->name)) }}</h5>
                                    @if ($permission->roles->isNotEmpty())
                                        <ul>
                                            @foreach ($permission->roles as $role)
                                                <li class="badge badge-info">{{ ucfirst(str_replace('-', ' ', $role->name)) }}</li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <p>No roles assigned</p>
                                    @endif
                                </div>
                                <hr>
                            @endforeach
                            {{-- {{ $permissions->links() }} --}}
                            {!! $permissions->links('pagination::bootstrap-4') !!}
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
