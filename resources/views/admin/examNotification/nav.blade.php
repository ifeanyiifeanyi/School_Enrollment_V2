<ul class="nav nav-pills flex-column">
    <li class="nav-item mb-4"><a href="{{ route('admin.exam.notification') }}"
            class="nav-link {{ request()->routeIs('admin.exam.notification') ? 'active' : '' }}">Send
            Notifications</a>
    </li>
    <li class="nav-item"><a href="{{ route('admin.listNotifications') }}"
            class="nav-link {{ request()->routeIs('admin.listNotifications') ? 'active' : '' }}">Sent
            Notifications</a></li>

    <li class="nav-item"><a href="{{ route('admin.repliedNotifications') }}" class="nav-link {{ request()->routeIs('admin.repliedNotifications') ? 'active' : '' }}">Repied Notifications</a></li>
</ul>
