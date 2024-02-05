<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Include jQuery -->

    <!-- Vite -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <!-- Additional CSS or JS links can be added here -->

    @stack('head')
</head>

<body>
    <div id="app">
        <!-- Main Content -->
        <main class="py-4 mt-5">
            @yield('content')
            <div style="height: 70px;"></div>
        </main>

        <!-- Bottom Navigation Bar -->
        @include('layouts.bottom_nav')
    </div>
    <!-- Include Bootstrap JS and CSS -->

    <!-- Additional Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap JS (and Popper.js if needed) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Additional scripts can be added here -->

    @stack('script')
</body>

</html>
