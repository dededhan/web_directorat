<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    {{-- SEO Meta Tags --}}
    <meta name="description" content="@yield('meta_description', 'Subdirektorat Pemeringkatan - Direktorat Inovasi, Sistem Informasi, dan Pemeringkatan Universitas Negeri Jakarta')">
    <meta name="keywords" content="@yield('meta_keywords', 'UNJ, Pemeringkatan, Ranking, Universitas, Jakarta, Sustainability, SDG')">
    <meta name="author" content="Direktorat ISIP UNJ">
    
    {{-- Open Graph / Facebook --}}
    <meta property="og:type" content="website">
    <meta property="og:title" content="@yield('title', 'Pemeringkatan') - Direktorat ISIP UNJ">
    <meta property="og:description" content="@yield('meta_description', 'Subdirektorat Pemeringkatan - Direktorat Inovasi, Sistem Informasi, dan Pemeringkatan Universitas Negeri Jakarta')">
    
    {{-- Page Title --}}
    <title>@yield('title', 'Pemeringkatan') - Subdirektorat Sistem Informasi dan Pemeringkatan</title>
    

  
 <link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" type="image/png">
    
    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    
    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    {{-- Tailwind CSS --}}
    <script src="https://cdn.tailwindcss.com"></script>
    
    {{-- Vite Assets --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    {{-- Page-specific styles --}}
    @stack('styles')
</head>
<body class="font-roboto">
    {{-- Navbar --}}
    @include('pemeringkatan.partials.navbar')
    
    {{-- Main Content --}}
    <main>
        @yield('content')
    </main>
    
    {{-- Footer --}}
    @include('pemeringkatan.partials.footer')
    
    {{-- Login Modal --}}
    @include('pemeringkatan.partials.login-modal')
    
    {{-- Page-specific scripts --}}
    @stack('scripts')
</body>
</html>
