@php
    $countapp = \App\Models\Application::whereNotNull('payment_id')->count();
@endphp
<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a navigate:wire href="{{ route('admin.dashboard') }}" class="">
                <img src="{{ asset('logo1.png') }}" width="40" alt=""></a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a navigate:wire href="{{ route('admin.dashboard') }}"
                class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">ADM</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>

            <li>
                <a navigate:wire
                    class="bg-primary text-light nav-link {{ request()->routeIs('admin.student.application') ? 'active' : '' }}"
                    href="{{ route('admin.student.application') }}"><i class="fas fa-graduation-cap"></i>
                    <span>Applications
                        <span style="border-radius: 50px !important;color: white !important"
                            class="p-1 shadow bg-danger text-light">{{ $countapp ?? '0' }}</span>
                    </span>
                </a>
            </li>

            <li
                class="dropdown {{ request()->routeIs('admin.manage.faculty') || request()->routeIs('admin.manage.department') ? 'parent' : '' }}">
                <a href="#" class="nav-link has-dropdown"><i class="fab fa-steam-symbol"></i><span>Manage
                        School</span></a>
                <ul class="dropdown-menu">
                    <li><a navigate:wire
                            class="nav-link {{ request()->routeIs('admin.manage.faculty') ? 'active' : '' }}"
                            href="{{ route('admin.manage.faculty') }}">Manage Faculty</a></li>
                    <li><a navigate:wire
                            class="nav-link {{ request()->routeIs('admin.manage.department') ? 'active' : '' }}"
                            href="{{ route('admin.manage.department') }}">Manage Department</a></li>
                </ul>
            </li>

            <li class="dropdown {{ request()->routeIs('admin.academicSession.view') ? 'parent' : '' }}">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-award"></i><span>Academic
                        Sessions</span></a>
                <ul class="dropdown-menu">
                    <li><a navigate:wire
                            class="nav-link {{ request()->routeIs('admin.academicSession.view') ? 'active' : '' }}"
                            href="{{ route('admin.academicSession.view') }}">Manage Session</a></li>
                </ul>
            </li>

            <li
                class="dropdown {{ request()->routeIs('admin.exam.manager') || request()->routeIs('admin.exam.details') || request()->routeIs('admin.subject') ? 'parent' : '' }}">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-columns"></i> <span>Exam/Subject
                        Manager</span></a>
                <ul class="dropdown-menu">
                    <li><a navigate:wire
                            class="nav-link {{ request()->routeIs('admin.exam.manager') ? 'active' : '' }}"
                            href="{{ route('admin.exam.manager') }}">Exam Manager</a></li>
                    <li><a navigate:wire
                            class="nav-link {{ request()->routeIs('admin.exam.details') ? 'active' : '' }}"
                            href="{{ route('admin.exam.details') }}">Exam Details</a></li>
                    <li><a navigate:wire class="nav-link {{ request()->routeIs('admin.subject') ? 'active' : '' }}"
                            href="{{ route('admin.subject') }}">Exam Subject Creater</a></li>
                </ul>
            </li>

            <li
                class="dropdown {{ request()->routeIs('admin.unverified.student') || request()->routeIs('admin.student.management') || request()->routeIs('admin.student.application') || request()->routeIs('admin.student.applicationRef') ? 'parent' : '' }}">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-users"></i><span>Students
                        Application</span></a>
                <ul class="dropdown-menu">
                    {{-- <li>
                        <a navigate:wire
                            class="nav-link {{ request()->routeIs('admin.student.management') ? 'active' : '' }}"
                            href="{{ route('admin.student.management') }}">All Students</a>
                    </li> --}}
                    <li>
                        <a navigate:wire
                            class="nav-link {{ request()->routeIs('admin.student.application') ? 'active' : '' }}"
                            href="{{ route('admin.student.application') }}">Active Applications
                        </a>
                    </li>

                    <li>
                        <a navigate:wire
                            class="nav-link {{ request()->routeIs('admin.student.applicationRef') ? 'active' : '' }}"
                            href="{{ route('admin.student.applicationRef') }}">Application REF
                        </a>
                    </li>



                </ul>
            </li>

            <li class="dropdown">
                <a href="#" class="nav-link has-dropdown"><i class="far fa-money-bill-alt"></i><span>Payment
                        Details</span></a>
                <ul class="dropdown-menu">

                    <li>
                        <a navigate:wire
                            class="nav-link {{ request()->routeIs('admin.acceptance_fees.index') ? 'active' : '' }}"
                            href="{{ route('admin.acceptance_fees.index') }}">Acceptance Fee Manager
                        </a>
                    </li>
                    <li>
                        <a navigate:wire
                            class="nav-link {{ request()->routeIs('admin.application.fee.index') ? 'active' : '' }}"
                            href="{{ route('admin.application.fee.index') }}">Application Fee Manager</a>
                    </li>
                </ul>
            </li>


            {{-- <li
                class="dropdown {{ request()->routeIs('admin.payment.manage') || request()->routeIs('admin.studentApplication.payment') ? 'parent' : '' }}">
                <a href="#" class="nav-link has-dropdown"><i class="far fa-money-bill-alt"></i><span>Payment
                        Management</span></a>
                <ul class="dropdown-menu">
                    <li>
                        <a navigate:wire
                            class="nav-link {{ request()->routeIs('admin.payment.manage') ? 'active' : '' }}"
                            href="{{ route('admin.payment.manage') }}">Create Payment</a>
                    </li>
                    <li>
                        <a navigate:wire
                            class="nav-link {{ request()->routeIs('admin.studentApplication.payment') ? 'active' : '' }}"
                            href="{{ route('admin.studentApplication.payment') }}">Payments</a>
                    </li>
                </ul>
            </li> --}}

            <li class="dropdown {{ request()->routeIs('admin.manage.admin') ? 'parent' : '' }}">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-cogs"></i><span>Admin
                        Management</span></a>
                <ul class="dropdown-menu">
                    <li><a navigate:wire
                            class="nav-link {{ request()->routeIs('admin.manage.admin') ? 'active' : '' }}"
                            href="{{ route('admin.manage.admin') }}">Admin Manager</a></li>
                </ul>
            </li>

            <li class="dropdown {{ request()->routeIs('admin.exam.notification') ? 'parent' : '' }}">
                <a href="#" class="nav-link has-dropdown"><i
                        class="fas fa-bell"></i><span>Notifications</span></a>
                <ul class="dropdown-menu">
                    <li><a navigate:wire
                            class="nav-link {{ request()->routeIs('admin.exam.notification') ? 'active' : '' }}"
                            href="{{ route('admin.exam.notification') }}">Notice Manager</a></li>
                </ul>
            </li>

            <li
                class="dropdown {{ request()->routeIs('admin.manage.scholarship') || request()->routeIs('admin.scholarship.question.view') || request()->routeIs('admin.scholarship.applicants') ? 'parent' : '' }}">
                <a href="#" class="nav-link has-dropdown"><i
                        class="fas fa-school"></i><span>Scholarship</span></a>
                <ul class="dropdown-menu">
                    <li>
                        <a navigate:wire
                            class="nav-link {{ request()->routeIs('admin.manage.scholarship') ? 'active' : '' }}"
                            href="{{ route('admin.manage.scholarship') }}">
                            Create Scholarships
                        </a>
                    </li>
                    <li>
                        <a navigate:wire
                            class="nav-link {{ request()->routeIs('admin.scholarship.question.view') ? 'active' : '' }}"
                            href="{{ route('admin.scholarship.question.view') }}">
                            Create Questions
                        </a>
                    </li>
                    <li>
                        <a navigate:wire
                            class="nav-link {{ request()->routeIs('admin.scholarship.applicants') ? 'active' : '' }}"
                            href="{{ route('admin.scholarship.applicants') }}">
                            Active Applications
                        </a>
                    </li>
                </ul>
            </li>

            <li>
                <a navigate:wire class="nav-link {{ request()->routeIs('site.settings') ? 'active' : '' }}"
                    href="{{ route('site.settings') }}"><i class="fas fa-pencil-ruler"></i>
                    <span>Site Settings</span>
                </a>
            </li>



            <li>
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-arhive"></i><span>Archive
                        Manager</span></a>
                <ul class="dropdown-menu">

                    <li>
                        <a navigate:wire
                            class="nav-link {{ request()->routeIs('admin.pendingAdmissions.manual') ? 'active' : '' }}"
                            href="{{ route('admin.pendingAdmissions.manual') }}">Appliction Pending
                        </a>
                    </li>
                    <li>
                        <a navigate:wire
                            class="nav-link {{ request()->routeIs('admin.pending.approvals') ? 'active' : '' }}"
                            href="{{ route('admin.pending.approvals') }}">Applicant Errors
                        </a>
                    </li>
                    <li>
                        <a navigate:wire
                            class="nav-link {{ request()->routeIs('admin.unverified.student') ? 'active' : '' }}"
                            href="{{ route('admin.unverified.student') }}">Unverified Student Emails
                        </a>
                    </li>

                </ul>
            </li>




            <li
                class="dropdown {{ request()->routeIs('admin.create.permission') || request()->routeIs('admin.create.role') || request()->routeIs('admin.view.role') || request()->routeIs('admin.permissions.view') ? 'parent' : '' }}">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-cog fa-spin"></i><span>Permission &
                        Roles</span></a>
                <ul class="dropdown-menu">
                    <li><a navigate:wire
                            class="nav-link {{ request()->routeIs('admin.create.permission') ? 'active' : '' }}"
                            href="{{ route('admin.create.permission') }}">Create Permission</a></li>
                    <li><a navigate:wire
                            class="nav-link {{ request()->routeIs('admin.create.role') ? 'active' : '' }}"
                            href="{{ route('admin.create.role') }}">Create Roles</a></li>
                    <li><a navigate:wire class="nav-link {{ request()->routeIs('admin.view.role') ? 'active' : '' }}"
                            href="{{ route('admin.view.role') }}">View Roles</a></li>
                    <li><a navigate:wire
                            class="nav-link {{ request()->routeIs('admin.permissions.view') ? 'active' : '' }}"
                            href="{{ route('admin.permissions.view') }}">View Permission</a></li>
                </ul>
            </li>

        </ul>
    </aside>
</div>
