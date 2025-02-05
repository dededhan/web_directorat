<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ALUMNI IMPACT</title>
    <link rel="stylesheet" href="{{ asset('alumni.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <style>
        #navbar, .top-bar {
            max-width: 100% !important;
            width: 100% !important;
            margin: 0 !important;
            left: 0 !important;
            right: 0 !important;
        }
        
        body > div:first-of-type {
            max-width: 100% !important;
            width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
        }
    </style>
</head>


<body>
    <div class="main-navbar-wrapper">
        @include('navbar')
    </div>
    

    <nav class="alumni-navbar">
        <a href="#" class="navbar-logo mt-2">
            <img src="https://spm.unj.ac.id/wp-content/uploads/2024/08/cropped-Logo-UNJ-PTNBH-RGB_Logo_Motto_Transparan.png" alt="Logo" />
            <span class="navbar-logo-text">ALUMNI IMPACT</span>
        </a>
        <ul class="navbar-menu">
            <li><a href="#">Home</a></li>
            <li><a href="#">Alumni Impact</a></li>
        </ul>
    </nav>

    <div class="container">
        <div class="activity-photos">
            <!-- Original cards content remains the same -->
            <!-- Card 1 -->
            <div class="photo-card">
                <div class="card-image">
                    <img src="https://ibb.co.com/pgzvFvm" alt="Alumni Success Story">
                </div>
                <div class="card-content">
                    <h3 class="card-title">Alumni UNJ Kembangkan Startup Pendidikan yang Mendunia</h3>
                    <div class="card-info">
                        <div class="info-item">
                            <i class="fas fa-calendar"></i>
                            <span>15 Februari 2025</span>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-graduation-cap"></i>
                            <span>Teknik Informatika</span>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-university"></i>
                            <span>Fakultas Teknik</span>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-link"></i>
                            <a href="https://news.unj.ac.id/article1" target="_blank">Baca selengkapnya</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="photo-card">
                <div class="card-image">
                    <img src="/api/placeholder/400/300" alt="Alumni Impact Story">
                </div>
                <div class="card-content">
                    <h3 class="card-title">Alumni UNJ Raih Penghargaan Guru Terbaik Nasional</h3>
                    <div class="card-info">
                        <div class="info-item">
                            <i class="fas fa-calendar"></i>
                            <span>20 Maret 2025</span>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-graduation-cap"></i>
                            <span>Pendidikan Matematika</span>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-university"></i>
                            <span>Fakultas MIPA</span>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-link"></i>
                            <a href="https://news.unj.ac.id/article2" target="_blank">Baca selengkapnya</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="photo-card">
                <div class="card-image">
                    <img src="/api/placeholder/400/300" alt="Community Impact">
                </div>
                <div class="card-content">
                    <h3 class="card-title">Alumni UNJ Dirikan Pusat Pemberdayaan Masyarakat</h3>
                    <div class="card-info">
                        <div class="info-item">
                            <i class="fas fa-calendar"></i>
                            <span>5 April 2025</span>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-graduation-cap"></i>
                            <span>Pendidikan Masyarakat</span>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-university"></i>
                            <span>Fakultas Ilmu Pendidikan</span>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-link"></i>
                            <a href="https://news.unj.ac.id/article3" target="_blank">Baca selengkapnya</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 4 -->
            <div class="photo-card">
                <div class="card-image">
                    <img src="/api/placeholder/400/300" alt="Research Impact">
                </div>
                <div class="card-content">
                    <h3 class="card-title">Alumni UNJ Temukan Inovasi Energi Terbarukan</h3>
                    <div class="card-info">
                        <div class="info-item">
                            <i class="fas fa-calendar"></i>
                            <span>12 Mei 2025</span>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-graduation-cap"></i>
                            <span>Teknik Elektro</span>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-university"></i>
                            <span>Fakultas Teknik</span>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-link"></i>
                            <a href="https://news.unj.ac.id/article4" target="_blank">Baca selengkapnya</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 5 -->
            <div class="photo-card">
                <div class="card-image">
                    <img src="/api/placeholder/400/300" alt="Social Impact">
                </div>
                <div class="card-content">
                    <h3 class="card-title">Alumni UNJ Bangun Gerakan Literasi Nasional</h3>
                    <div class="card-info">
                        <div class="info-item">
                            <i class="fas fa-calendar"></i>
                            <span>25 Mei 2025</span>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-graduation-cap"></i>
                            <span>Pendidikan Bahasa Indonesia</span>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-university"></i>
                            <span>Fakultas Bahasa dan Seni</span>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-link"></i>
                            <a href="https://news.unj.ac.id/article5" target="_blank">Baca selengkapnya</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 6 -->
            <div class="photo-card">
                <div class="card-image">
                    <img src="/api/placeholder/400/300" alt="International Achievement">
                </div>
                <div class="card-content">
                    <h3 class="card-title">Alumni UNJ Jadi Peneliti di NASA</h3>
                    <div class="card-info">
                        <div class="info-item">
                            <i class="fas fa-calendar"></i>
                            <span>30 Mei 2025</span>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-graduation-cap"></i>
                            <span>Fisika</span>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-university"></i>
                            <span>Fakultas MIPA</span>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-link"></i>
                            <a href="https://news.unj.ac.id/article6" target="_blank">Baca selengkapnya</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
@include('pemeringkatan.footerpemeringkatan')