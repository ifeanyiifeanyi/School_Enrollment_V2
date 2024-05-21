<div class="navbar-bg"></div>
<nav class="navbar navbar-expand-lg main-navbar">
    <form class="form-inline mr-auto">
        <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
        </ul>
    </form>
    <ul class="navbar-nav navbar-right">

        <li class="dropdown">
            <a href="{{ route('admin.profile') }}" data-toggle="dropdown"
                class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                <img alt="image"
                    src="{{ empty(auth()->user()->admin->photo) ? asset('admin/assets/img/avatar/avatar-1.png') :  asset(auth()->user()->admin->photo) }}"
                    class="rounded-circle mr-1">
                <div class="d-sm-none d-lg-inline-block">Hi, {{ Str::title(auth()->user()->first_name) }} {{
                    Str::title(auth()->user()->first_name) }}</div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <div class="dropdown-title">Last seen <br>
                    <code class="text-primary">
                    {{ auth()->user()->previous_login_at?->diffForHumans() ?? 'N/A' }}
                    </code>
                </div>
                <a wire:navigate href="{{ route('admin.profile') }}" class="dropdown-item has-icon">
                    <i class="far fa-user"></i> Profile
                </a>
                <a wire:navigate href="{{ route('admin.profile.setPassword') }}" class="dropdown-item has-icon">
                    <i class="fas fa-user-lock"></i> Manage Password
                </a>
                <a wire:navigate href="{{ route('admin.dashboard') }}" class="dropdown-item has-icon">
                    <i class="fas fa-cog"></i> Settings
                </a>
                <div class="dropdown-divider"></div>
                <a href="{{ route('admin.logout') }}" class="dropdown-item has-icon text-danger">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </li>
    </ul>
</nav>