<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin HackAthon</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        :root {
            --ink: #000000;
            --paper: #ffffff;
            --wash: #f4f4f2;
            --line: #000000;
            --muted: #666666;
        }

        [x-cloak] { display: none !important; }
        * { border-radius: 0 !important; box-shadow: none !important; }
        body { background: var(--wash); color: var(--ink); font-family: 'Inter', Helvetica, Arial, sans-serif; }
        h1, h2, h3, .editorial-serif { font-family: 'Playfair Display', Georgia, serif; }
        button, a, input, textarea { font-family: inherit; }
        button:focus-visible, a:focus-visible, input:focus-visible, textarea:focus-visible { outline: 2px solid var(--ink); outline-offset: 3px; }
    </style>
</head>
<body>
    <div x-data="{ sidebarOpen: true }" class="flex min-h-screen border-t-4 border-black bg-[#f4f4f2]">
        @include('admin_hackaton.sidebar')

        <div class="flex min-w-0 flex-1 flex-col">
            @include('admin_hackaton.navbar')

            <main class="flex-1 overflow-y-auto px-5 py-8 sm:px-8 lg:px-12">
                <div class="mx-auto max-w-7xl">
                    @yield('contentadmin_hackaton')
                </div>
            </main>
        </div>
    </div>
    @if (session('success'))
        <script>Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: @json(session('success')), showConfirmButton: false, timer: 3500 });</script>
    @endif
    @if (session('error'))
        <script>Swal.fire({ toast: true, position: 'top-end', icon: 'error', title: @json(session('error')), showConfirmButton: false, timer: 3500 });</script>
    @endif
</body>
</html>
