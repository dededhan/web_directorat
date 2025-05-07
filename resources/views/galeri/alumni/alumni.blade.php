<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ALUMNI IMPACT - UNJ</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" type="image/png">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">
    
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
            --header-bg: #166270;
            --dark-overlay: rgba(0, 0, 0, 0.6);
            --shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --hover-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            --transition: all 0.3s ease;
        }

        body {
            color: var(--text-color);
            line-height: 1.6;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        /* Hero Section */
        .hero-section {
            position: relative;
            height: 70vh;
            min-height: 500px;
            color: white;
            overflow: hidden;
        }

        .hero-background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
        }

        .hero-background img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            filter: brightness(0.3);
            aspect-ratio: 1/1;
        }

        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 2;
        }

        .hero-content {
            position: relative;
            z-index: 3;
            max-width: 1000px;
            margin: 0 auto;
            padding: 8rem 2rem 0;
            text-align: center;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 1rem;
            text-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }

        .hero-subtitle {
            font-size: 1.3rem;
            max-width: 700px;
            margin: 0 auto;
            font-weight: 400;
            text-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }

        /* Stats Bar */
        .stats-container {
            max-width: 900px;
            margin: -4rem auto 4rem;
            background: white;
            border-radius: 0.75rem;
            box-shadow: var(--shadow);
            position: relative;
            z-index: 10;
            overflow: hidden;
        }

        .stats-wrapper {
            display: flex;
            justify-content: space-between;
        }

        .stat-item {
            flex: 1;
            padding: 2rem 1rem;
            text-align: center;
            border-right: 1px solid #eee;
        }

        .stat-item:last-child {
            border-right: none;
        }

        .stat-icon {
            width: 40px;
            height: 40px;
            margin: 0 auto 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            color: var(--primary-color);
            font-size: 1.2rem;
        }

        .stat-number {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 0.3rem;
        }

        .stat-label {
            color: var(--light-text);
            font-size: 1rem;
        }

        /* Container */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        /* Alumni Philosophy Section */
        .alumni-philosophy {
            background-color: white;
            padding: 4rem 2rem;
            margin-bottom: 3rem;
            text-align: center;
            border-radius: 0.75rem;
            box-shadow: var(--shadow);
        }

        .philosophy-content {
            max-width: 900px;
            margin: 0 auto;
        }

        .philosophy-title {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 2rem;
            position: relative;
            display: inline-block;
        }

        .philosophy-title::after {
            content: "";
            position: absolute;
            bottom: -15px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background-color: var(--accent-color);
            border-radius: 2px;
        }

        .philosophy-text {
            font-size: 1.1rem;
            line-height: 1.8;
            color: var(--text-color);
            max-width: 800px;
            margin: 0 auto;
        }

        /* Section Header */
        .section-header {
            text-align: center;
            margin-bottom: 3rem;
            padding-top: 2rem;
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

        /* Responsive */
        @media (max-width: 1024px) {
            .alumni-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 2rem;
            }
            
            .stats-wrapper {
                flex-direction: column;
            }
            
            .stat-item {
                border-right: none;
                border-bottom: 1px solid #eee;
            }
            
            .stat-item:last-child {
                border-bottom: none;
            }
            
            .hero-title {
                font-size: 2.8rem;
            }
        }

        @media (max-width: 768px) {
            .hero-section {
                height: 60vh;
                min-height: 400px;
            }
            
            .hero-title {
                font-size: 2.2rem;
            }
            
            .hero-subtitle {
                font-size: 1.1rem;
            }
            
            .philosophy-title {
                font-size: 1.7rem;
            }
            
            .container {
                padding: 0 1.5rem;
            }
            
            .alumni-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
@include('layout.navbar')

<body>
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-background">
            <img src="https://asset.kompas.com/crops/3ObZCQJoEGDX_DegAY47y7sfoWg=/25x0:1177x768/1200x800/data/photo/2024/10/29/67203cebeb82e.jpeg" alt="Alumni Background">
        </div>
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <h1 class="hero-title">Alumni Impact</h1>
            <p class="hero-subtitle">Discover how our graduates are creating positive change and achieving excellence across Indonesia and beyond</p>
        </div>
    </section>

    <!-- Stats Bar -->
    <div class="stats-container">
        <div class="stats-wrapper">
            <div class="stat-item">
                <div class="stat-icon">
                    <i class="fas fa-user-graduate"></i>
                </div>
                <div class="stat-number">3.000.000+</div>
                <div class="stat-label">Alumni</div>
            </div>
            <div class="stat-item">
                <div class="stat-icon">
                    <i class="fas fa-globe-asia"></i>
                </div>
                <div class="stat-number">50+</div>
                <div class="stat-label">Negara</div>
            </div>
            <div class="stat-item">
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-number">10+</div>
                <div class="stat-label">Ikatan Alumni</div>
            </div>
        </div>
    </div>

    <!-- Main Content with Laravel Logic -->
    <div class="container">
        <!-- Added new Alumni Philosophy section -->
        <div class="alumni-philosophy" data-aos="fade-up">
            <div class="philosophy-content">
                <h2 class="philosophy-title">Alumni Berdampak: Pilar Kekuatan dan Sumber Inspirasi UNJ</h2>
                <p class="philosophy-text">
                    Alumni berdampak adalah pilar kekuatan, sumber inspirasi, dan duta terbaik bagi sebuah institusi pendidikan. Mereka adalah manifestasi dari investasi pendidikan yang berhasil, dan kontribusi mereka adalah tolok ukur sejati dari keberhasilan sebuah lembaga dalam mencetak pemimpin masa depan dan agen perubahan yang positif.
                </p>
            </div>
        </div>
        
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