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
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
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
        

        /* Hero Section */
        .hero-section {
            background-color: #D1E7DD;
            padding: 5rem 2rem;
            color: #186666;
            text-align: center;
            clip-path: polygon(0 0, 100% 0, 100% 90%, 50% 100%, 0 90%);
            margin-bottom: 3rem;
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
            font-weight: 400; /* Increased from 300 */
            opacity: 0.9;
        }

        /* Container */
.container {
    max-width: 1280px;
    margin: 0 auto; /* Remove vertical margin */
    padding: 0 1rem; /* Slightly reduced padding */
}

@media (min-width: 768px) {
    .container {
        padding: 0 2rem; /* More padding on larger screens */
    }
}

/* Section Header */
.section-header {
    text-align: center;
    margin-bottom: 2rem; /* Reduced from 3rem */
    padding: 1rem 0; /* Added some padding */
}

.section-header h2 {
    font-size: 1.8rem; /* Slightly reduced from 2rem */
    font-weight: 700;
    color: #186666;
    margin-bottom: 0.75rem; /* Slightly reduced */
}

.section-divider {
    height: 3px; /* Slightly thinner */
    width: 60px;
    background: #186666;
    margin: 0 auto;
    border-radius: 2px;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .section-header {
        margin-bottom: 1.5rem;
    }

    .section-header h2 {
        font-size: 1.5rem;
    }
}

        /* Alumni Grid */
        .alumni-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem; /* Adjusted for 3-column layout */
            margin-bottom: 3rem; /* Added margin at bottom */
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
            border: 1px solid #e5e7eb; /* Added border for more definition */
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
            padding: 1.8rem; /* Increased from 1.5rem */
            display: flex;
            flex-direction: column;
            flex: 1;
        }

        .card-title {
            font-size: 1.3rem; /* Increased from 1.2rem */
            font-weight: 600;
            margin-bottom: 1rem;
            color: #186666;
            line-height: 1.4;
        }

        .card-meta {
            margin-bottom: 1.8rem; /* Increased from 1.5rem */
            display: flex;
            flex-direction: column;
            gap: 0.8rem; /* Increased from 0.7rem */
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--light-text);
            font-size: 0.95rem; /* Increased from 0.9rem */
        }

        .meta-item i {
            color: #3AA6A6;
            font-size: 1.1rem; /* Increased from 1rem */
            width: 20px; /* Increased from 16px */
            text-align: center;
            display: flex;           /* Added display flex */
            justify-content: center; /* Center horizontally */
            align-items: center;     /* Center vertically */
            min-width: 20px;         /* Ensure minimum width */
        }

        .read-more {
            margin-top: auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.8rem 1.5rem; /* Increased from 0.7rem 1.2rem */
            background-color: rgba(24, 102, 102, 0.1);
            color: #186666;
            text-decoration: none;
            border-radius: 0.5rem;
            font-weight: 600; /* Increased from 500 */
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
            padding: 3.5rem; /* Increased from 3rem */
            border-radius: 1rem;
            text-align: center;
            box-shadow: var(--shadow);
            border: 1px solid #e5e7eb; /* Added border */
        }

        .empty-icon {
            background-color: rgba(24, 102, 102, 0.1);
            width: 90px; /* Increased from 80px */
            height: 90px; /* Increased from 80px */
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.8rem; /* Increased from 1.5rem */
        }

        .empty-icon i {
            font-size: 2.2rem; /* Increased from 2rem */
            color: #186666;
        }

        .empty-state h3 {
            font-size: 1.6rem; /* Increased from 1.5rem */
            color: #186666;
            margin-bottom: 0.7rem; /* Increased from 0.5rem */
        }

        .empty-state p {
            color: var(--light-text);
            font-size: 1.1rem; /* Added font size */
        }
        body {
            padding-top: 70px; /* Adjust based on navbar height */
        }

        @media (max-width: 768px) {
            body {
                padding-top: 60px; /* Different height for mobile */
            }
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
                padding: 0 1.5rem; /* Increased from 1rem */
            }
            
            .alumni-grid {
                grid-template-columns: 1fr; /* Change to single column on mobile */
                gap: 1.5rem;
            }
            
            @media (min-width: 640px) and (max-width: 1023px) {
                .alumni-grid {
                    grid-template-columns: repeat(2, 1fr); /* 2 columns on tablet */
                }
            }
        }
    </style>
</head>

<body>
    <!-- Include the Navbar -->
    @include('layout.navbar_sticky')
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

    @include('layout.footer')
</body>
</html>