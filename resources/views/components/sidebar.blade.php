
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link" href="{{ auth()->user()->hasRole('admin') ? url('/admin') : url('/dashboard') }}">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-layout-text-window-reverse"></i><span>Tables</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="tables-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                @if(auth()->user()->hasRole('admin'))
                    <li>
                        <a href="{{route('user.details')}}">
                            <i class="bi bi-circle"></i><span>User Table</span>
                        </a>
                    </li>
                <li>
                    <a href="{{route('category.store')}}">
                        <i class="bi bi-circle"></i><span>Categories Table</span>
                    </a>
                </li>
                @endif

                @if(auth()->user()->hasRole('user'))
                <li>
                    <a href="{{route('user.expenses')}}">
                        <i class="bi bi-circle"></i><span>Expense Table</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('user.budget')}}">
                        <i class="bi bi-circle"></i><span>Budget Table</span>
                    </a>
                </li>
                    @endif
            </ul>
        </li>
        @if(auth()->user()->hasRole('admin'))
        <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#charts-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-gear"></i><span>Setting</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="charts-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{route('permission')}}">
                            <i class="bi bi-circle"></i><span>Roles and Permissions</span>
                        </a>
                    </li>
                </ul>
            </li>
    @endif


</aside>
