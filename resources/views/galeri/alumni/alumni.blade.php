<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ALUMNI IMPACT</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" type="image/png">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
    <link rel="stylesheet" href="{{ asset('home.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
        }

        :root {
            --primary-color: #0B5563;
            --secondary-color: #147D8E;
            --accent-color: #1E9DAF;
            --light-accent: #D1E7DD;
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
            padding-top: 70px;
        }

        /* Hero Section */
        .hero-section {
            position: relative;
            background: linear-gradient(135deg, #0B5563, #1E9DAF);
            padding: 7rem 2rem 9rem;
            color: white;
            text-align: center;
            clip-path: polygon(0 0, 100% 0, 100% 85%, 50% 100%, 0 85%);
            margin-bottom: 3rem;
            overflow: hidden;
        }

        .hero-section::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('data:image/svg+xml;utf8,<svg width="100" height="100" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"><path d="M50 25L75 50L50 75L25 50Z" fill="%231E9DAF" fill-opacity="0.1"/></svg>');
            background-size: 100px 100px;
            opacity: 0.3;
        }

        .hero-content {
            max-width: 900px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }

        .hero-content h1 {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
            letter-spacing: -0.5px;
        }

        .hero-content p {
            font-size: 1.4rem;
            font-weight: 400;
            opacity: 0.95;
            max-width: 80%;
            margin: 0 auto;
            text-shadow: 0 1px 2px rgba(0,0,0,0.1);
        }
        
        /* Stats Bar */
        .stats-container {
            max-width: 1000px;
            margin: -4rem auto 4rem;
            background: white;
            border-radius: 1rem;
            box-shadow: var(--shadow);
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            overflow: hidden;
            position: relative;
            z-index: 10;
        }

        .stat-item {
            padding: 2rem 1.5rem;
            text-align: center;
            border-right: 1px solid #f0f0f0;
            transition: var(--transition);
        }

        .stat-item:last-child {
            border-right: none;
        }

        .stat-item:hover {
            background-color: #f9fafb;
        }

        .stat-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 50px;
            height: 50px;
            margin: 0 auto 1rem;
            background-color: rgba(30, 157, 175, 0.1);
            border-radius: 50%;
            color: var(--accent-color);
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 0.3rem;
        }

        .stat-label {
            color: var(--light-text);
            font-size: 1rem;
            font-weight: 500;
        }

        /* Container */
        .container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 1.5rem;
        }

        /* Section Header */
        .section-header {
            text-align: center;
            margin-bottom: 3rem;
            padding: 1rem 0;
        }

        .section-header h2 {
            font-size: 2.2rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 1rem;
            position: relative;
            display: inline-block;
        }

        .section-header h2::after {
            content: "";
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 70px;
            height: 4px;
            background: var(--accent-color);
            border-radius: 2px;
        }

        .section-description {
            max-width: 700px;
            margin: 1.5rem auto 0;
            color: var(--light-text);
            font-size: 1.1rem;
        }

        /* Alumni Grid */
        .alumni-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2.5rem;
            margin-bottom: 4rem;
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
            position: relative;
            border: 1px solid #e5e7eb;
        }

        .alumni-card:hover {
            transform: translateY(-7px);
            box-shadow: var(--hover-shadow);
        }

        .card-image {
            height: 180px;
            position: relative;
            overflow: hidden;
            background: linear-gradient(135deg, #0B5563, #1E9DAF);
        }

        .card-image::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('data:image/svg+xml;utf8,<svg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"><path d="M30 15L45 30L30 45L15 30Z" fill="%231E9DAF" fill-opacity="0.15"/></svg>');
            background-size: 60px 60px;
            opacity: 0.5;
        }

        .card-content {
            padding: 2rem;
            display: flex;
            flex-direction: column;
            flex: 1;
            position: relative;
            z-index: 2;
        }

        .card-decoration {
            position: absolute;
            top: 0;
            right: 0;
            width: 120px;
            height: 120px;
            background: var(--light-accent);
            border-radius: 0 0 0 100%;
            opacity: 0.3;
            z-index: 1;
        }

        .card-title {
            font-size: 1.4rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            color: var(--primary-color);
            line-height: 1.4;
            position: relative;
            z-index: 2;
        }

        .card-meta {
            margin-bottom: 2rem;
            display: flex;
            flex-direction: column;
            gap: 0.9rem;
            position: relative;
            z-index: 2;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 0.7rem;
            color: var(--light-text);
            font-size: 1rem;
        }

        .meta-item i {
            color: var(--accent-color);
            font-size: 1.1rem;
            width: 24px;
            text-align: center;
            display: flex;
            justify-content: center;
            align-items: center;
            min-width: 24px;
        }

        .read-more {
            margin-top: auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem 1.8rem;
            background-color: rgba(30, 157, 175, 0.08);
            color: var(--primary-color);
            text-decoration: none;
            border-radius: 0.5rem;
            font-weight: 600;
            transition: var(--transition);
            border: 1px solid transparent;
            position: relative;
            z-index: 2;
        }

        .read-more:hover {
            background-color: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }

        .read-more i {
            transition: transform 0.3s ease;
        }

        .read-more:hover i {
            transform: translateX(5px);
        }

        /* Empty State */
        .empty-state {
            grid-column: 1 / -1;
            background-color: var(--card-bg);
            padding: 4rem;
            border-radius: 1rem;
            text-align: center;
            box-shadow: var(--shadow);
            border: 1px solid #e5e7eb;
        }

        .empty-icon {
            background: linear-gradient(135deg, rgba(30, 157, 175, 0.1), rgba(11, 85, 99, 0.1));
            width: 100px;
            height: 100px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        .empty-icon i {
            font-size: 2.4rem;
            color: var(--primary-color);
        }

        .empty-state h3 {
            font-size: 1.8rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }

        .empty-state p {
            color: var(--light-text);
            font-size: 1.2rem;
            max-width: 500px;
            margin: 0 auto;
        }

        /* Featured Alumni */
        .featured-alumni {
            margin-bottom: 5rem;
            padding: 3rem 0;
            background-color: rgba(30, 157, 175, 0.05);
            position: relative;
            overflow: hidden;
        }

        .featured-alumni::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('data:image/svg+xml;utf8,<svg width="200" height="200" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg"><path d="M100 50L150 100L100 150L50 100Z" fill="%231E9DAF" fill-opacity="0.03"/></svg>');
            background-size: 200px 200px;
        }

        .featured-container {
            position: relative;
            z-index: 2;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .alumni-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 2rem;
            }
            
            .stats-container {
                margin-top: -3rem;
            }
        }

        @media (max-width: 768px) {
            body {
                padding-top: 60px;
            }
            
            .hero-section {
                padding: 5rem 1.5rem 7rem;
            }
            
            .hero-content h1 {
                font-size: 2.5rem;
            }
            
            .hero-content p {
                font-size: 1.1rem;
                max-width: 100%;
            }
            
            .stats-container {
                grid-template-columns: 1fr;
                margin-top: -2rem;
            }
            
            .stat-item {
                border-right: none;
                border-bottom: 1px solid #f0f0f0;
            }
            
            .stat-item:last-child {
                border-bottom: none;
            }
            
            .container {
                padding: 0 1.5rem;
            }
            
            .section-header h2 {
                font-size: 1.8rem;
            }
            
            .alumni-grid {
                grid-template-columns: 1fr;
                gap: 1.8rem;
            }
        }

        @media (min-width: 640px) and (max-width: 1023px) {
            .alumni-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
</head>

<body>
    <!-- Include the Navbar -->
    @include('layout.navbar_sticky')
    
    <div class="hero-section" style="background: none; overflow: visible; position: relative; clip-path: none; padding-bottom: 6rem;">
        <!-- Hero image with overlay -->
        <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; z-index: 0; overflow: hidden;">
            <img src="https://asset.kompas.com/crops/3ObZCQJoEGDX_DegAY47y7sfoWg=/25x0:1177x768/1200x800/data/photo/2024/10/29/67203cebeb82e.jpeg" 
                style="width: 100%; height: 100%; object-fit: cover; filter: brightness(0.4);" alt="UNJ Campus">
            <div style="position: absolute; bottom: 0; left: 0; right: 0; height: 150px; 
                background: linear-gradient(to bottom, rgba(0,0,0,0), rgba(0,0,0,0.7));"></div>
        </div>
        
        <!-- Decorative shape at bottom -->
        <div style="position: absolute; bottom: -1px; left: 0; right: 0; z-index: 1;">
            <svg viewBox="0 0 1440 100" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
                <path d="M0 50L80 43.3C160 36.7 320 23.3 480 26.7C640 30 800 50 960 56.7C1120 63.3 1280 56.7 1360 53.3L1440 50V100H1360C1280 100 1120 100 960 100C800 100 640 100 480 100C320 100 160 100 80 100H0V50Z" 
                    fill="#f9fafb"/>
            </svg>
        </div>
        
        <div class="hero-content" data-aos="fade-up" data-aos-duration="800" style="position: relative; z-index: 2; max-width: 1000px; padding: 8rem 2rem 4rem;">
            <h1 style="font-size: 4rem; text-shadow: 0 2px 15px rgba(0,0,0,0.5); margin-bottom: 1.5rem;">Our Alumni Making an Impact</h1>
            <p style="font-size: 1.5rem; max-width: 800px; margin: 0 auto; text-shadow: 0 2px 10px rgba(0,0,0,0.5);">
                Discover how UNJ graduates are creating positive change and achieving excellence across Indonesia and beyond
            </p>
        </div>
    </div>
    
    <div class="stats-container" data-aos="fade-up" data-aos-delay="200">
        <div class="stat-item">
            <div class="stat-icon">
                <i class="fas fa-user-graduate fa-lg"></i>
            </div>
            <div class="stat-number">3.000.000+</div>
            <div class="stat-label">Alumni</div>
        </div>
        <div class="stat-item">
            <div class="stat-icon">
                <i class="fas fa-globe-asia fa-lg"></i>
            </div>
            <div class="stat-number">50+</div>
            <div class="stat-label">Negara</div>
        </div>
        <div class="stat-item">
            <div class="stat-icon">
                <i class="fas fa-users fa-lg"></i>
            </div>
            <div class="stat-number">10+</div>
            <div class="stat-label">Ikatan Alumni</div>
        </div>
    </div>
    
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <h2>Alumni Success Stories</h2>
            <p class="section-description">Kisah-kisah inspiratif alumni UNJ yang telah membuat dampak positif di berbagai bidang dan menjadi kebanggaan almamater</p>
        </div>
        
        <div class="alumni-grid">
            @forelse($alumniBerdampak as $alumni)
                <div class="alumni-card" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                    <div class="card-image">
                        <!-- Decorative background only -->
                    </div>
                    <div class="card-content">
                        <div class="card-decoration"></div>
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
                <div class="empty-state" data-aos="fade-up">
                    <div class="empty-icon">
                        <i class="fas fa-newspaper"></i>
                    </div>
                    <h3>No Alumni Stories Yet</h3>
                    <p>Belum ada berita alumni yang tersedia saat ini. Silakan kembali lagi nanti untuk melihat kisah-kisah inspiratif dari para alumni UNJ.</p>
                </div>
            @endforelse
        </div>
    </div>
    
    
    @include('layout.footer')
    
    <script>
        // Initialize AOS animation library
        document.addEventListener('DOMContentLoaded', function() {
            AOS.init({
                once: true,
                duration: 800,
                easing: 'ease-out-cubic'
            });
        });
    </script>
</body>
</html>