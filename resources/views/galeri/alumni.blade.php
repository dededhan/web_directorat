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
            @forelse($alumniBerdampak as $alumni)
                <div class="photo-card">
                    <div class="card-image">
                        <!-- You might want to add a default image if none provided -->
                        <img src="{{ asset('images/default-news.jpg') }}" alt="{{ $alumni->judul_berita }}">
                    </div>
                    <div class="card-content">
                        <h3 class="card-title">{{ $alumni->judul_berita }}</h3>
                        <div class="card-info">
                            <div class="info-item">
                                <i class="fas fa-calendar"></i>
                                <span>{{ \Carbon\Carbon::parse($alumni->tanggal_berita)->format('d F Y') }}</span>
                            </div>
                            <div class="info-item">
                                <i class="fas fa-graduation-cap"></i>
                                <span>{{ $alumni->prodi }}</span>
                            </div>
                            <div class="info-item">
                                <i class="fas fa-university"></i>
                                <span>{{ strtoupper($alumni->fakultas) }}</span>
                            </div>
                            <div class="info-item">
                                <i class="fas fa-link"></i>
                                <a href="{{ $alumni->link_berita }}" target="_blank">Baca selengkapnya</a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="no-data">
                    <i class="fas fa-newspaper"></i>
                    <p>Belum ada berita alumni yang tersedia</p>
                </div>
            @endforelse
        </div>
    </div>
    
</body>
</html>

<style>
    .no-data {
        width: 100%;
        text-align: center;
        padding: 40px;
        background: #f8f9fa;
        border-radius: 10px;
        margin: 20px 0;
    }
    
    .no-data i {
        font-size: 48px;
        color: #ccc;
        margin-bottom: 15px;
    }
    
    .no-data p {
        color: #666;
        font-size: 18px;
    }
    
    .photo-card {
        transition: transform 0.3s ease;
    }
    
    .photo-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .card-info {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }
    
    .info-item {
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: 0.9em;
        color: #666;
    }
    
    .info-item i {
        color: #3498db;
    }
    
    .info-item a {
        color: #3498db;
        text-decoration: none;
    }
    
    .info-item a:hover {
        text-decoration: underline;
    }
    </style>
@include('pemeringkatan.footerpemeringkatan')