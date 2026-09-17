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
        :root {
            --hackaton-ink: #111827;
            --hackaton-muted: #4b5563;
            --hackaton-paper: #ffffff;
            --hackaton-wash: #f8f9fa;
            --hackaton-green: #047857;
            --hackaton-green-dark: #065f46;
        }
        * { box-shadow: none !important; border-radius: 0 !important; }
        body { background: var(--hackaton-wash); color: var(--hackaton-ink); font-family: Inter, ui-sans-serif, system-ui, -apple-system, "Segoe UI", sans-serif; }
        a, button, input, select, textarea { font: inherit; }
        a:focus-visible, button:focus-visible, input:focus-visible, select:focus-visible, textarea:focus-visible { outline: 3px solid var(--hackaton-green); outline-offset: 2px; }

        /* Accent remap: amber/orange -> UNJ green (single accent) */
        .text-amber-300, .text-amber-400, .text-amber-500, .text-amber-600, .text-amber-700, .text-amber-800, .text-amber-900, .text-amber-950 { color: var(--hackaton-green) !important; }
        .bg-amber-50 { background-color: #ecfdf5 !important; }
        .bg-amber-100 { background-color: #d1fae5 !important; }
        .bg-amber-200 { background-color: #a7f3d0 !important; }
        .bg-amber-300 { background-color: #6ee7b7 !important; }
        .bg-amber-400 { background-color: #34d399 !important; }
        .bg-amber-500 { background-color: var(--hackaton-green) !important; }
        .bg-amber-600 { background-color: var(--hackaton-green-dark) !important; }
        .border-amber-200, .border-amber-300, .border-amber-400, .border-amber-500 { border-color: #6ee7b7 !important; }
        .hover\:bg-amber-600:hover { background-color: var(--hackaton-green-dark) !important; }
        .hover\:bg-amber-100:hover { background-color: #d1fae5 !important; }
        .hover\:border-amber-300:hover { border-color: #6ee7b7 !important; }
        .focus\:border-amber-500:focus { border-color: var(--hackaton-green) !important; }
        .focus\:ring-amber-500:focus { --tw-ring-color: var(--hackaton-green) !important; }
        .ring-amber-400 { --tw-ring-color: #34d399 !important; }
        a.bg-amber-500, button.bg-amber-500 { background-color: var(--hackaton-green) !important; color: #fff !important; }

        /* Light body gradients -> solid off-white */
        [class*="bg-gradient"][class*="from-gray-50"] { background-image: none !important; background-color: var(--hackaton-wash) !important; }

        /* Zero gradients: flatten decorative gradients to solid */
        [class*="bg-gradient"][class*="from-amber"],
        [class*="bg-gradient"][class*="from-orange"] { background-image: none !important; background-color: var(--hackaton-green) !important; }
        [class*="bg-gradient"][class*="from-rose"],
        [class*="bg-gradient"][class*="from-red"] { background-image: none !important; background-color: #e11d48 !important; }
        [class*="bg-gradient"][class*="from-gray-900"],
        [class*="bg-gradient"][class*="via-gray-800"] { background-image: none !important; background-color: #111827 !important; }
    </style>
</head>
<body class="bg-[#f8f9fa] font-sans">
    <div x-data="{ sidebarOpen: true }" class="flex min-h-screen bg-[#f8f9fa]">
        @include('subdirektorat-inovasi.hackaton.sidebar')

        <div class="flex-1 flex flex-col min-w-0">
            @include('subdirektorat-inovasi.hackaton.navbar')

            <main class="flex-1 overflow-y-auto p-6">
                <div class="max-w-7xl mx-auto">
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
