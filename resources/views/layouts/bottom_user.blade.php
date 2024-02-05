<!-- resources/views/components/bottom_nav.blade.php -->
<style>
    .nav-link.active {
        color: #007bff;
        /* Warna biru, atau pilih warna sesuai tema Anda */
        font-weight: bold;
    }

    .nav-link {
        color: white;
        text-align: center;
    }

    .custom-navbar {
        background-color: rgb(11, 212, 247) !important;
    }

    .navbar-brand {
        flex-grow: 1;
        text-align: center;
    }

    .badge-notif {
        position: relative;
        top: -10px;
        right: 10px;
        color: rgb(239, 246, 47);
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
        <a class="nav-link" href="">
            <i class="fas fa-shopping-cart"></i>
            <span class="badge badge-pill badge-danger badge-notif">3</span> <!-- Contoh badge -->
        </a>
    </div>
</nav>
<div class="navbar custom-navbar fixed-bottom navbar-dark bg-light">
    <div class="container-fluid justify-content-around">

        <a href="#" class="nav-link {{ Request::is('order') ? 'active' : '' }}">
            <i class="fas fa-shopping-cart"></i><br>Order
        </a>
        <a href="{{ url('/home') }}" class="nav-link {{ Request::is('home') ? 'active' : '' }}">
            <i class="fas fa-home"></i><br>Home
        </a>
        <a href="#" class="nav-link {{ Request::is('report') ? 'active' : '' }}">
            <i class="fas fa-chart-line"></i><br>Report
        </a>
    </div>
</div>
