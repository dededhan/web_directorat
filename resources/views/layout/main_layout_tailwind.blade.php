<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" type="image/png">
    <title>{{ $title ?? 'Default Title' }}</title>

    {{-- This is the key part for Vite --}}
    @vite(['resources/css/app.css',])

</head>
<body class="font-sans antialiased">
    
    @include('layouts.navbar_tailwind')

    <main>
        @yield('main_content')

    </main>

    @include('layouts.footer_tailwind') 
</body>
</html>