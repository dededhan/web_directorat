<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ALUMNI IMPACT</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('alumni.css') }}">
    <link rel="stylesheet" href="{{ asset('unj-navbar.css') }}">
    
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
    <!-- Include standardized navbar component -->
    @include('components.main-navbar', [
        'pageTitle' => 'ALUMNI IMPACT',
        'currentPage' => 'Alumni Impact'
    ])

    <div class="hero-section">
        <div class="hero-content">
            <h1>Our Alumni Making an Impact</h1>
            <p>Discover how UNJ graduates are making a difference in the world</p>
        </div>
    </div>
    
    <div class="container">
        <div class="section-header">
            <h2>Alumni Success Stories</h2>
            <div class="section-divider"></div>
        </div>
        
        <div class="alumni-grid">
            @forelse($alumniBerdampak as $alumni)
                <div class="alumni-card">
                    <div class="card-content">
                        <h3 class="card-title">{{ $alumni->judul_berita }}</h3>
                        <div class="card-meta">
                            <div class="meta-item">
                                <i class="fas fa-calendar-alt"></i>
                                <span>{{ \Carbon\Carbon::parse($alumni->tanggal_berita)->format('d F Y') }}</span>
                            </div>
                            <div class="meta-item">
                                <i class="fas fa-graduation-cap"></i>
                                <span>{{ $alumni->prodi }}</span>
                            </div>
                        </div>
                        <a href="{{ $alumni->link_berita }}" target="_blank" class="read-more">
                            <span>Read Full Story</span>
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-newspaper"></i>
                    </div>
                    <h3>No Alumni Stories Yet</h3>
                    <p>Belum ada berita alumni yang tersedia</p>
                </div>
            @endforelse
        </div>
    </div>

    @include('galeri.alumni.footeralumni')
</body>
</html>