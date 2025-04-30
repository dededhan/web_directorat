<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('admin.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard_main/sidebar_dashboardadmin.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard_main/navbar_dashboard.css') }}">

    <title>Dashboard User</title>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="stylesheet" href="{{ asset('scrollbar-fix.css') }}">
    <style>
        /* Inline emergency fix for double scrollbar */
        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        body {
            overflow-y: auto !important;
        }

        #content {
            overflow: visible !important;
        }

        #content main {
            overflow: visible !important;
        }

        /* Apply this class to main content area */
        .no-double-scroll {
            overflow-y: visible !important;
            height: auto !important;
        }
    </style>
</head>


@php
    $currentRoute = Route::currentRouteName();
@endphp

<body style="{{ $currentRoute === 'subdirektorat-inovasi.registered_user.show' ? 'margin-left: -200px;' : '' }}">

    @php
        $currentRoute = Route::currentRouteName();
    @endphp


    @if (
        $currentRoute !== 'subdirektorat-inovasi.registered_user.show' &&
            $currentRoute !== 'subdirektorat-inovasi.registered_user.summary-all')
        @include('subdirektorat-inovasi.registered_user.sidebar')
    @endif
    <!-- CONTENT -->
    <section id="content">
        <!-- NAVBAR -->
        @if ($currentRoute !== 'subdirektorat-inovasi.registered_user.show' && $currentRoute !== 'subdirektorat-inovasi.registered_user.summary-all')
            @include('subdirektorat-inovasi.registered_user.navbar')
        @endif


        <main>
            @yield('contentregistered_user')
        </main>
    </section>

    <script src="{{ asset('admin.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
