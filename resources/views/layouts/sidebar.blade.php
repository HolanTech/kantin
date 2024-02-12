<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="index.html" class="brand-link">
        <img src="{{ asset('assets/dist/img/logo.png') }}" alt="AdminLTE Logo" class="brand-image">
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
                <!-- Master -->
                <li class="nav-item">
                    <a href="/admin" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>Master <i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.user') }}" class="nav-link">
                                <i class="far fa-user nav-icon"></i>
                                <p>User</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.canteen') }}" class="nav-link">
                                <i class="far fa-building nav-icon"></i>
                                <p>Canteen</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- Saldo -->
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-wallet"></i>
                        <p>Saldo <i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.user.topup') }}" class="nav-link">
                                <i class="fas fa-plus-circle nav-icon"></i>
                                <p>User Top Up</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.canteen.wd') }}" class="nav-link">
                                <i class="fas fa-minus-circle nav-icon"></i>
                                <p>Canteen Withdrawal</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- Report -->
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-chart-line"></i>
                        <p>Report <i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('sales.report') }}" class="nav-link">
                                <i class="fas fa-receipt nav-icon"></i>
                                <p>Sales Report</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('topup.index') }}" class="nav-link">
                                <i class="fas fa-money-bill-wave nav-icon"></i>
                                <p>Top Up Report</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('wd.index') }}" class="nav-link">
                                <i class="fas fa-shopping-cart nav-icon"></i>
                                <p>Expenses Report</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</aside>
