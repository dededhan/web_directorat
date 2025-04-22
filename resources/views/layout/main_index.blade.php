<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>Universitas Negeri Jakarta - Direktorat Pemeringkatan</title>
    <link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" type="image/png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('home.css') }}">
    <link rel="stylesheet" href="{{ asset('header-carousel.css') }}">
    <script src="{{ asset('header-carousel.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('mobile.css') }}">
    <script src="{{ asset('mobile.js') }}"></script>
</head>

<body>
    @include('layout.navbar_sticky')
    <main>
        @yield('content_index')
    </main>
    @include('layout.footer')
</body>

</html>
