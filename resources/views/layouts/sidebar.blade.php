<aside class="main-sidebar sidebar-dark-primary elevation-4">

    <a href="index3.html" class="brand-link">
        <img src="{{ asset('assets/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">E-Kantin</span>
    </a>

    <div class="sidebar">

        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('assets/dist/img/user1-128x128.jpg') }}" class="img-circle elevation-2"
                    alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">Administrator</a>
            </div>
        </div>


        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">

                <li class="nav-item menu-open">
                    <a href="#" class="nav-link ">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Master
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.user') }}" class="nav-link ">
                                <i class="far fa-circle nav-icon"></i>
                                <p>User</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.canteen') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Canteen</p>
                            </a>
                        </li>

                    </ul>
                </li>
                <li class="nav-item menu-open">
                    <a href="#" class="nav-link ">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Saldo
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.user.topup') }}" class="nav-link ">
                                <i class="far fa-circle nav-icon"></i>
                                <p>User Top Up</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.canteen') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Canteen Widrawl</p>
                            </a>
                        </li>

                    </ul>
                </li>


                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-copy"></i>
                        <p>
                            Report
                            <i class="fas fa-angle-left right"></i>
                            <span class="badge badge-info right">6</span>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="pages/layout/top-nav.html" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Top Navigation</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/layout/top-nav-sidebar.html" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Top Navigation + Sidebar</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/layout/boxed.html" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Boxed</p>
                            </a>
                        </li>

                    </ul>
                </li>

        </nav>

    </div>

</aside>
