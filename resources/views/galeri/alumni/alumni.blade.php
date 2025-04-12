<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ALUMNI IMPACT</title>
    <link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" type="image/png">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        :root {
            --primary-color: #186666;
            --secondary-color: #2A8D8D;
            --accent-color: #3AA6A6;
            --text-color: #1f2937;
            --light-text: #6b7280;
            --border-color: #e5e7eb;
            --background-color: #f9fafb;
            --card-bg: #ffffff;
            --shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --hover-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            --transition: all 0.3s ease;
        }

        body {
            background-color: var(--background-color);
            color: var(--text-color);
            line-height: 1.6;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        /* Navbar Styles */
        .main-navbar-wrapper {
            width: 100%;
            position: relative;
            z-index: 100;
        }

        .main-navbar-wrapper > * {
            width: 100% !important;
            max-width: none !important;
            margin: 0 !important;
            padding: 0.5rem 5% !important;
        }

        .alumni-navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 5%;
            background-color: var(--card-bg);
            box-shadow: var(--shadow);
            position: sticky;
            top: 0;
            z-index: 99;
        }

        .navbar-logo {
            display: flex;
            align-items: center;
            text-decoration: none;
        }

        .navbar-logo img {
            height: 45px;
            margin-right: 1rem;
        }

        .navbar-logo-text {
            font-size: 1.25rem;
            font-weight: 700;
            color: #186666;
            letter-spacing: 0.5px;
        }

        .navbar-menu {
            display: flex;
            align-items: center;
            list-style: none;
            gap: 2rem;
        }

        .menu-link {
            color: var(--text-color);
            text-decoration: none;
            font-weight: 500;
            font-size: 1rem;
            padding: 0.5rem 0;
            transition: var(--transition);
            position: relative;
        }

        .menu-link:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background-color: #186666;
            transition: var(--transition);
        }

        .menu-link:hover:after,
        .menu-link.active:after {
            width: 100%;
        }

        .menu-link:hover,
        .menu-link.active {
            color: #186666;
        }

        /* Hero Section */
        .hero-section {
           
            background-color: #D1E7DD;
            padding: 5rem 2rem;
            color: white;
            text-align: center;
            clip-path: polygon(0 0, 100% 0, 100% 85%, 0 100%);
        }

        .hero-content {
            max-width: 800px;
            margin: 0 auto;
        }

        .hero-content h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .hero-content p {
            font-size: 1.2rem;
            font-weight: 300;
            opacity: 0.9;
        }

        /* Container */
        .container {
            max-width: 1280px;
            margin: 3rem auto;
            padding: 0 1.5rem;
        }

        /* Section Header */
        .section-header {
            text-align: center;
            margin-bottom: 3rem;
        }

        .section-header h2 {
            font-size: 2rem;
            font-weight: 700;
            color: #186666;
            margin-bottom: 1rem;
        }

        .section-divider {
            height: 4px;
            width: 60px;
            background: #186666;
            margin: 0 auto;
            border-radius: 2px;
        }

        /* Alumni Grid */
        .alumni-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 2rem;
        }

        .alumni-card {
            background-color: var(--card-bg);
            border-radius: 1rem;
            overflow: hidden;
            transition: var(--transition);
            box-shadow: var(--shadow);
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .alumni-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--hover-shadow);
        }

        .card-image {
            height: 220px;
            position: relative;
            overflow: hidden;
        }

        .card-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.7s ease;
        }

        .alumni-card:hover .card-image img {
            transform: scale(1.05);
        }

        .faculty-badge {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background-color: #186666;
            color: white;
            padding: 0.3rem 0.7rem;
            border-radius: 99px;
            font-size: 0.8rem;
            font-weight: 500;
            letter-spacing: 0.5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        .card-content {
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            flex: 1;
        }

        .card-title {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: #186666;
            line-height: 1.4;
        }

        .card-meta {
            margin-bottom: 1.5rem;
            display: flex;
            flex-direction: column;
            gap: 0.7rem;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--light-text);
            font-size: 0.9rem;
        }

        .meta-item i {
            color: #3AA6A6;
            font-size: 1rem;
            width: 16px;
        }

        .read-more {
            margin-top: auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.7rem 1.2rem;
            background-color: rgba(24, 102, 102, 0.1);
            color: #186666;
            text-decoration: none;
            border-radius: 0.5rem;
            font-weight: 500;
            transition: var(--transition);
        }

        .read-more:hover {
            background-color: #186666;
            color: white;
        }

        .read-more i {
            transition: transform 0.3s ease;
        }

        .read-more:hover i {
            transform: translateX(3px);
        }

        /* Empty State */
        .empty-state {
            grid-column: 1 / -1;
            background-color: var(--card-bg);
            padding: 3rem;
            border-radius: 1rem;
            text-align: center;
            box-shadow: var(--shadow);
        }

        .empty-icon {
            background-color: rgba(24, 102, 102, 0.1);
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
        }

        .empty-icon i {
            font-size: 2rem;
            color: #186666;
        }

        .empty-state h3 {
            font-size: 1.5rem;
            color: #186666;
            margin-bottom: 0.5rem;
        }

        .empty-state p {
            color: var(--light-text);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .alumni-navbar {
                flex-direction: column;
                padding: 1rem;
            }
            
            .navbar-logo {
                margin-bottom: 1rem;
            }
            
            .navbar-menu {
                width: 100%;
                justify-content: center;
                gap: 1.5rem;
            }
            
            .hero-section {
                padding: 3rem 1rem;
            }
            
            .hero-content h1 {
                font-size: 2rem;
            }
            
            .hero-content p {
                font-size: 1rem;
            }
            
            .container {
                padding: 0 1rem;
            }
        }
    </style>
</head>

<body>
    <!-- Include the Navbar -->
    @include('galeri.alumni.navbaralumni')
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