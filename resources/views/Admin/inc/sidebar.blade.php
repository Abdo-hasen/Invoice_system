<aside class="main-sidebar sidebar-dark-primary elevation-4">

    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <img src="{{ asset('AdminAssets') }}/dist/img/AdminLTELogo.png" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Invoices</span>
    </a>
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('AdminAssets') }}/dist/img/user2-160x160.jpg" class="img-circle elevation-2"
                    alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ auth()->user()->name }}</a>
            </div>
        </div>

        {{-- logout --}}
        {{-- <div>
            <form action="{{ route('admin.logout') }}" method="post">
                @csrf
                <button type="submit" class="btn btn-danger">Logout</button>
            </form>
        </div> --}}

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">

                {{-- first module --}}

                @can('invoices')
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-copy"></i>
                            <p>
                                Invoices
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">

                            @can('invoices list')
                                <li class="nav-item">
                                    <a href="{{ route('admin.invoices.index') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Invoices</p>
                                    </a>
                                </li>
                            @endcan

                            @can('paid invoices')
                                <li class="nav-item">
                                    <a href="{{ route('admin.details.paid') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Paid Invoices</p>
                                    </a>
                                </li>
                            @endcan

                            @can('unpaid invoices')
                                <li class="nav-item">
                                    <a href="{{ route('admin.details.unpaid') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Unpaid Invoices</p>
                                    </a>
                                </li>
                            @endcan

                            @can('partial paid invoices')
                                <li class="nav-item">
                                    <a href="{{ route('admin.details.partial_paid') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Partial Paid Invoices</p>
                                    </a>
                                </li>
                            @endcan

                            @can('archived invoices')
                                <li class="nav-item">
                                    <a href="{{ route('admin.archives.index') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Archived Invoices</p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan

                {{-- second module --}}

               
                @can('reports')
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-copy"></i>
                            <p>
                                Reports
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">

                            @can('invoices reports')
                                <li class="nav-item">
                                    <a href="{{ route("admin.invoices_reports.index") }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Invoices Reports</p>
                                    </a>
                                </li>
                            @endcan

                            @can('customers reports')
                                <li class="nav-item">
                                    <a href="{{ route("admin.customers_reports.index") }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Customers Reports</p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                {{-- end second module --}}

                {{-- third module --}}

                @can('users')
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-copy"></i>
                            <p>
                                Users
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">

                            @can('users list')
                                <li class="nav-item">
                                    <a href="{{ route('admin.users.index') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Users</p>
                                    </a>
                                </li>
                            @endcan

                            @can('users roles')
                                <li class="nav-item">
                                    <a href="{{ route('admin.roles.index') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Users Roles</p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan

                {{-- end third module --}}

                {{-- fourth module --}}
                @can('settings')
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-copy"></i>
                            <p>
                                Settings
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">

                            @can('sections')
                                <li class="nav-item">
                                    <a href="{{ route('admin.sections.index') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>sections</p>
                                    </a>
                                </li>
                            @endcan

                            @can('products')
                                <li class="nav-item">
                                    <a href="{{ route('admin.products.index') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Products</p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                {{-- fourth module --}}

            </ul>
        </nav>

        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
