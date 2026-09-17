<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'HackAthon UNJ')</title>
    <meta name="description" content="Informasi dan pendaftaran HackAthon UNJ.">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" type="image/png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] { display: none !important; }
        :root {
            --ink: #000000;
            --paper: #ffffff;
            --wash: #f4f4f2;
            --line: #000000;
            --muted: #666666;
            --hackaton-green: #047857;
            --hackaton-green-dark: #065f46;
        }
        * { box-shadow: none !important; border-radius: 0 !important; }
        html { scroll-behavior: smooth; }
        body { background: var(--wash); color: var(--ink); font-family: 'Inter', Helvetica, Arial, sans-serif; }
        h1, h2, h3, .editorial-serif { font-family: 'Playfair Display', Georgia, serif; }
        a, button, input, select { font: inherit; }
        a:focus-visible, button:focus-visible, input:focus-visible, select:focus-visible { outline: 2px solid var(--ink); outline-offset: 3px; }
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
