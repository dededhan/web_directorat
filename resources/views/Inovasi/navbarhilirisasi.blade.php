<head>
    <title>Direktorat Inovasi dan Hilirisasi</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&amp;display=swap" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="{{ asset('inovasi/navbar.css') }}">
</head>
<body>

    {{-- @include('loginpopup') --}}
    
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
        <div class="title">Direktorat Inovasi dan Hilirisasi</div>
        <a href="#">Beranda</a>
       
        <div class="navbar-links">
            <div class="dropdown">
                <a href="#">Profil <i class="fa fa-caret-down"></i></a>
                <div class="dropdown-content">
                    <a href="#">Struktur Organisasi</a>
                    <a href="#">Tugas Pokok dan Fungsi</a>
                </div>
            </div>
    
            <div class="dropdown">
                <a href="#">Program <i class="fa fa-caret-down"></i></a>
                <div class="dropdown-content">
                    <a href="#">Daftar Program</a>
                    <a href="#">Panduan Program</a>
                </div>
            </div>

            <div class="dropdown">
                <a href="#">Layanan <i class="fa fa-caret-down"></i></a>
                <div class="dropdown-content">
                {{-- <a href="{{ route('form') }}">Form Kasinov</a> --}}
                </div>
            </div>
    
            <div class="dropdown">
                <a href="#">Data <i class="fa fa-caret-down"></i></a>
                <div class="dropdown-content">
                    <a href="#">Data Statistik</a>
                    <a href="#">Laporan</a>
                </div>
            </div>
    
            <div class="dropdown">
                <a href="#">Dokumen <i class="fa fa-caret-down"></i></a>
                <div class="dropdown-content">
                    <a href="#">Publikasi</a>
                    <a href="#">Arsip</a>
                </div>
            </div>
    
            <div class="dropdown">
                <a href="#">Inovasi UNJ<i class="fa fa-caret-down"></i></a>
                <div class="dropdown-content">
                    <a href="#">Mercendise UNJ</a>
                    <a href="#">Pangan</a>
                    <a href="#">Energi</a>
                    <a href="#">TIK</a>
                    <a href="#">Biomedis</a>
                    <a href="#">Antropometri digital</a>
                    <a href="#">Smartbed</a>
                    <a href="#">Material Maju</a>
                    <a href="#">Lainnya</a>
                    <a href="#">Pakaian Zavera</a>
                </div>
            </div>
        </div>
    
        <a href="#">Berita</a>
        <a href="#">Galeri</a>
        <a href="#">Portal</a> 
    </div>

    <script src="{{ asset('script.js') }}"></script>
</body>
</html>
