<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Direktorat Pemeringkatan</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&amp;display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('style.css') }}">
</head>
<body>
    <!-- Top Bar -->
    <div class="top-bar" id="topBar">
        <div class="social-icons">
            <a href="https://facebook.com" target="_blank" aria-label="Facebook">
                <i class="fab fa-facebook-f"></i>
            </a>
            <a href="https://twitter.com" target="_blank" aria-label="Twitter">
                <i class="fab fa-twitter"></i>
            </a>
            <a href="https://instagram.com" target="_blank" aria-label="Instagram">
                <i class="fab fa-instagram"></i>
            </a>
            <a href="https://linkedin.com" target="_blank" aria-label="LinkedIn">
                <i class="fab fa-linkedin-in"></i>
            </a>
        </div>
    </div>

    <!-- Navbar -->
    <div class="navbar" id="navbar">
        <img alt="Logo of Direktorat Pemeringkatan" height="50"
            src="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" width="50" />
        <div class="title">Direktorat Pemeringkatan</div>
        <a href="#">Beranda</a>
        <div class="dropdown">
            <a href="#">Sub Direktorat <i class="fa fa-caret-down"></i></a>
            <div class="dropdown-content">
                <a href="#">Sub Direktorat 1</a>
                <a href="#">Sub Direktorat 2</a>
                <a href="#">Sub Direktorat 3</a>
            </div>
        </div>
        <a href="#">Berita</a>
        <a href="#">Program</a>
        <a href="#">Galeri</a>
        <a class="login" href="#">Masuk</a>
    </div>

    <script src="{{ asset('script.js') }}"></script>
</body>
</html>
