<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Boxicons -->
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- My CSS -->
    <link rel="stylesheet" href="{{ asset('admin.css') }}">

    <link rel="stylesheet" href="{{ asset('dashboard_main/sidebar_dashboard.css') }}"> 
    <link rel="stylesheet" href="{{ asset('dashboard_main/navbar_dashboard.css') }}"> 

    <title>Dashboard Direktorat</title>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    @include('admin.sidebaradmin')

    <!-- CONTENT -->
    <section id="content">
        <!-- NAVBAR -->
        @include('admin.navbaradmin')

        <!-- MAIN -->
        <main>
            @yield('contentadmin')
        </main>
    </section>

    <script src="{{ asset('admin.js') }}"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>