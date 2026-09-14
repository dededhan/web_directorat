<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Peserta | Hackaton UNJ')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-100 font-sans">
    <div x-data="{ sidebarOpen: true }" class="flex min-h-screen bg-gray-100">
        @include('subdirektorat-inovasi.hackaton.sidebar')

        <div class="flex-1 flex flex-col min-w-0">
            @include('subdirektorat-inovasi.hackaton.navbar')

            <main class="flex-1 overflow-y-auto p-6">
                <div class="max-w-6xl mx-auto">
                    @yield('content_hackaton')
                </div>
            </main>
        </div>
    </div>

    @if (session('success'))
        <script>
            Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: @json(session('success')), showConfirmButton: false, timer: 3500 });
        </script>
    @endif
    @if (session('error'))
        <script>
            Swal.fire({ toast: true, position: 'top-end', icon: 'error', title: @json(session('error')), showConfirmButton: false, timer: 3500 });
        </script>
    @endif
</body>
</html>
