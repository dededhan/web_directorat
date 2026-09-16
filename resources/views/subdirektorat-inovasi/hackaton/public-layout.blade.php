<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Hackaton UNJ')</title>
    <meta name="description" content="Informasi dan pendaftaran Hackaton UNJ.">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" type="image/png">
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
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
        * { box-shadow: none !important; }
        html { scroll-behavior: smooth; }
        body { background: var(--hackaton-wash); color: var(--hackaton-ink); font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif; }
        a, button, input, select { font: inherit; }
        a:focus-visible, button:focus-visible, input:focus-visible, select:focus-visible { outline: 3px solid var(--hackaton-green); outline-offset: 3px; }
    </style>
    @stack('head')
</head>
<body>
    @include('subdirektorat-inovasi.hackaton.public-navbar')

    <main>
        @yield('content_public_hackaton')
    </main>

    @include('subdirektorat-inovasi.hackaton.public-footer')
</body>
</html>
