<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Dashboard Direktorat</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.7.12/sweetalert2.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.7.12/sweetalert2.min.js"></script>
    <link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" type="image/png">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @vite([
        'resources/js/app.js',  
        'resources/js/admin/admin.js',
        'resources/js/indikator.js'
    ])
    
    @stack('styles')
    
    <style>
        body { 
            font-family: 'Inter', sans-serif; 
        }
    </style>
</head>

@php
    $currentRoute = Route::currentRouteName();
@endphp

<body class="bg-gray-100">
    @if ($currentRoute !== 'admin.katsinov.show' && $currentRoute !== 'admin.katsinov.summary-all')
        <div x-data="{ sidebarOpen: true }" class="flex h-screen bg-gray-100">
            @include('admin.sidebaradmin')

            <div class="flex-1 flex flex-col overflow-hidden w-full">
                @include('admin.navbaradmin')

                <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100">
                    @yield('contentadmin')
                </main>
            </div>
        </div>
    @else
        @yield('contentadmin')
    @endif

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</body>

</html>