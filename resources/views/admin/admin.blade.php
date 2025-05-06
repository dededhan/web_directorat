<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
    <!-- Boxicons -->
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.7.12/sweetalert2.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.7.12/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@2.0.7/css/boxicons.min.css">
    <link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" type="image/png">
    {{-- Editor --}}
    <script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>
    <!-- My CSS -->
    <link rel="stylesheet" href="{{ asset('admin.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard_main/sidebar_dashboardadmin.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard_main/navbar_dashboard.css') }}">

    <title>Dashboard Direktorat</title>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Add these two lines to your admin.blade.php file, right before the closing </head> tag -->
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

<body style="{{ $currentRoute === 'admin.katsinov.show' ? 'margin-left: -200px;' : '' }}">

    
    @php
        $currentRoute = Route::currentRouteName();
    @endphp

    @if ($currentRoute !== 'admin.katsinov.show' && $currentRoute !== 'admin.katsinov.summary-all')
        @include('admin.sidebaradmin')
    @endif

    <!-- CONTENT -->
    <section id="content">
        <!-- NAVBAR -->
        @if ($currentRoute !== 'admin.katsinov.show' && $currentRoute !== 'admin.katsinov.summary-all')
            @include('admin.navbaradmin')
        @endif
        

        <!-- MAIN -->
        <main class="content-wrapper">
            <div class="content-container">
                @yield('contentadmin')
            </div>
        </main>
    </section>

    <script src="{{ asset('admin.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
     <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Add this at the bottom of your layout file, right before the closing </body> tag -->
</body>

</html>
