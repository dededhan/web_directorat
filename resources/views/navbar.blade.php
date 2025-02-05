<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Direktorat Pemeringkatan</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&amp;display=swap" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="{{ asset('navbar.css') }}">
</head>
<body>

    @include('loginpopup')
    
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
                    <div class="language-selector">
            <label class="switch">
                <input type="checkbox" id="languageToggle">
                <span class="slider round"></span>
                <span class="lang-label">ID/EN</span>
            </label>
        </div>
        </div>
        </div>
        </div>
    </div>


    <div class="navbar" id="navbar">
        <img alt="Logo of Direktorat Pemeringkatan" height="50"
            src="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" width="50" />
        <div class="title">Direktorat Pemeringkatan</div>
        <a href="#">Beranda</a>
       
        <div class="navbar-links">
         
            <div class="dropdown">
                <a href="#">Sub Direktorat <i class="fa fa-caret-down"></i></a>
                <div class="dropdown-content">
                    <a href="#">Subdirektorat Inovasi dan Hilirisasi</a>
                    <a href="{{ route('pemeringkatan.landingpage') }}">Subdirektorat Pemeringkatan dan Sistem Informasi</a>
                </div>
            </div>

            <div class="dropdown">
                <a href="#">Profil <i class="fa fa-caret-down"></i></a>
                <div class="dropdown-content">
                    <a href="#">Struktur Organisasi</a>
                    <a href="{{ route('tupoksi.tupoksi') }}">Tugas Pokok dan Fungsi</a>
                </div>
            </div>
        </div>
        <a href="#">Berita</a>
            <div class="dropdown">
                <a href="#">Program <i class="fa fa-caret-down"></i></a>
                <div class="dropdown-content">
                    <a href="#">Program</a>
                    <a href="#">Program</a>
                </div>
            </div>
            <div class="dropdown">
                <a href="#">Galeri <i class="fa fa-caret-down"></i></a>
                <div class="dropdown-content">
                <a href="{{ route('alumni') }}">Alumni Berdampak</a>
                <a href="{{ route('galeri.sustainability') }}">Sustainability</a>                </div>
            </div>
            <a href="#">Portal</a> 
        <a class="login" href="#" data-bs-toggle="modal" data-bs-target="#loginModal">Masuk</a>
    </div>

    <script src="{{ asset('script.js') }}"></script>
</body>
</html>
