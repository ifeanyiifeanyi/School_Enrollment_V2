@php
    $userHasApplication = DB::table('applications')
        ->where('user_id', auth()->user()->id)
        ->exists();
@endphp

<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('student.dashboard') }}" class="brand-link" wire:navigate>
        <img src="{{ asset($siteSetting->site_icon ?? '') }}" alt="Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">Manager</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="pb-3 mt-3 mb-3 user-panel d-flex">
            <div class="image">
                <img src="{{ empty(auth()->user()->student->passport_photo)
                    ? 'https://placehold.it/150x100'
                    : Storage::url(auth()->user()->student->passport_photo) }}"
                    class="elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a wire:navigate href="{{ route('student.profile') }}"
                    class="d-block">{{ Str::title(auth()->user()->fullName) }} </a>
            </div>
        </div>


        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <li class="nav-item">
                    <a wire:navigate href="{{ route('student.dashboard') }}" class="nav-link">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                @if ($userHasApplication)
                    <li class="nav-item">
                        <a wire:navigate href="{{ route('student.scholarship.view') }}" class="nav-link">
                            <i class="nav-icon fas fa-graduation-cap" aria-hidden="true"></i>
                            <p>Scholarships</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a wire:navigate href="{{ route('student.scholarships.status') }}" class="nav-link">
                            <i class="nav-icon fas fa-graduation-cap" aria-hidden="true"></i>
                            <p>Scholarships status</p>
                        </a>
                    </li>
                @endif


                <li class="nav-item menu-close">
                    <a href="{{ route('student.profile') }}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Account Management
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a wire:navigate href="{{ route('student.profile') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Profile</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a wire:navigate href="{{ route('student.application.process') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Application</p>
                            </a>
                        </li>
                        {{-- <li class="nav-item">
                            <a href="./index3.html" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Account Setting</p>
                            </a>
                        </li> --}}
                    </ul>
                </li>

                <li class="nav-item bg-danger">
                    <a href="{{ route('student.logout') }}" class="nav-link">
                        <i class="nav-icon fas fa-user-lock"></i>
                        <p>Logout</p>
                    </a>
                </li>

                <li class="nav-item bg-info">
                    <a href="{{ route('student.admission.application') }}" class="nav-link">
                        <i class="nav-icon fas fa-user-lock"></i>
                        <p>Start Application</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
