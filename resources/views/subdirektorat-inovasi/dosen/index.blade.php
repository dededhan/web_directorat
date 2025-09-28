<!DOCTYPE html>
{{-- PERBAIKAN 1: Tambahkan class h-full di sini --}}
<html lang="en" class="h-full bg-gray-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard Dosen</title>
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.store('appState', {
            isSubmitting: false
        });
    });
</script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
        <link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" type="image/png">

    <style>
        body { font-family: 'Inter', sans-serif; }
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #a8a8a8; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #555; }
    </style>

    @stack('styles')
</head>
{{-- PERBAIKAN 2: Tambahkan class h-full di sini --}}
<body class="h-full">

    {{-- PERBAIKAN 3: Ganti h-screen menjadi h-full agar mewarisi tinggi dari body --}}
    <div class="flex h-full bg-gray-100">
        @include('subdirektorat-inovasi.dosen.sidebar')

        <div class="flex-1 flex flex-col overflow-hidden">
            @include('subdirektorat-inovasi.dosen.navbar')

            <main class="flex-1 overflow-x-hidden overflow-y-auto">
                {{-- PERBAIKAN 4: Tambahkan div container di sini agar padding konsisten --}}
                <div class="container mx-auto px-6 py-8">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    @stack('scripts')
</body>
</html>