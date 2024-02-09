<!-- Navigasi Atas -->
<style>
    .nav-link.active {
        color: #ffffff;
        font-weight: bold;
    }

    .nav-link {
        color: #000000;
        text-align: center;
    }

    .custom-navbar {
        background-color: #00c8ec !important;
        padding: 3px;
    }

    .navbar-brand {
        flex-grow: 1;
        text-align: center;
    }

    .badge-notif {
        position: absolute;
        top: 10px;
        right: 30px;
        color: #f2ff00;
    }
</style>

<nav class="navbar navbar-expand-lg custom-navbar fixed-top">
    <div class="container-fluid">
        <a class="nav-link" href="{{ route('user.index') }}">
            <i class="fas fa-list"></i>
        </a>
        <a class="navbar-brand" href="#">
            <span>@yield('title', 'E-Kantin')</span>
        </a>
        <a class="nav-link" href="{{ route('order.index') }}">
            <i class="fas fa-shopping-cart"></i>
            <span class="badge badge-pill badge-danger badge-notif">@yield('order')</span>
        </a>
    </div>
</nav>

<!-- Navigasi Bawah -->
<div class="navbar custom-navbar fixed-bottom navbar-dark bg-light">
    <div class="container-fluid justify-content-around">
        <a href="{{ route('order.create') }}" class="nav-link {{ Request::is('order*') ? 'active' : '' }}">
            <i class="fas fa-shopping-cart"></i><br>Order
        </a>
        <a href="{{ route('home') }}" class="nav-link {{ Request::is('home') ? 'active' : '' }}">
            <i class="fas fa-home"></i><br>Home
        </a>
        <a href="{{ route('order.report') }}" class="nav-link {{ Request::is('order.report') ? 'active' : '' }}">
            <i class="fas fa-chart-line"></i><br>Report
        </a>
    </div>
</div>

<style>
    .nav-link {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        color: #000000;
        /* Atur sesuai kebutuhan */
    }

    .nav-link span {
        margin-top: 5px;
        font-size: 12px;
    }

    .nav-link.active {
        /* background-color: #007bff; */
        /* Atur warna latar aktif sesuai tema */
        color: #ffffff;
        border-radius: 10px;
    }

    .nav-link i {
        padding-top: 3px;
        margin-bottom: -15px;
    }

    .custom-navbar.bg-light {
        background-color: #00c8ec !important;
        /* Atur warna latar navigasi bawah */
    }
</style>
