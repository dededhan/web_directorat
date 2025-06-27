<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <!-- UPDATED VIEWPORT META TAG - Critical for mobile display -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Universitas Negeri Jakarta - Direktorat Pemeringkatan</title>
    <link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" type="image/png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    {{-- <link rel="stylesheet" href="{{ asset('home.css') }}">
    <link rel="stylesheet" href="{{ asset('header-carousel.css') }}">
    <!-- Load mobile.css first to ensure its styles take precedence -->
    <link rel="stylesheet" href="{{ asset('mobile.css') }}">
    <script src="{{ asset('header-carousel.js') }}"></script> --}}

    @vite([
        'resources/css/home.css',
        'resources/css/header-carousel.css',
        'resources/css/mobile.css',
        'resources/js/home.js',
        'resources/js/header-carousel.js',
        'resources/js/mobile.js',
        'resources/js/instagram-api-feed.js',
    ])
    <!-- CRITICAL MOBILE DETECTION SCRIPT - Add right after stylesheets -->
    <script>
        // Critical fix for sidebar and overlay
        (function() {
            // Run after DOM is fully loaded
            document.addEventListener('DOMContentLoaded', function() {
                // Get key elements
                const mobileSidebar = document.getElementById('mobile-sidebar');
                const sidebarOverlay = document.getElementById('sidebar-overlay');

                // Fix sidebar initial state
                if (mobileSidebar) {
                    mobileSidebar.style.transform = 'translateX(100%)';
                }

                // Fix overlay initial state
                if (sidebarOverlay) {
                    sidebarOverlay.style.opacity = '0';
                    sidebarOverlay.style.visibility = 'hidden';
                    sidebarOverlay.style.pointerEvents = 'none';
                }

                // Fix overlay click handling
                if (sidebarOverlay) {
                    sidebarOverlay.addEventListener('click', function() {
                        // Hide sidebar when overlay is clicked
                        if (mobileSidebar) {
                            mobileSidebar.style.transform = 'translateX(100%)';
                        }
                        // Hide overlay
                        sidebarOverlay.style.opacity = '0';
                        sidebarOverlay.style.visibility = 'hidden';
                        sidebarOverlay.style.pointerEvents = 'none';
                        // Allow body scrolling again
                        document.body.classList.remove('sidebar-open');
                    });
                }
            });
        })();
    </script>

    <style>
        /* CRITICAL MOBILE FIXES - Directly in the head for priority loading */
        @media (max-width: 767px) {

            /* Force mobile layout */
            html,
            body {
                width: 100% !important;
                min-width: 100% !important;
                max-width: 100vw !important;
                overflow-x: hidden !important;
                -webkit-text-size-adjust: 100% !important;
            }

            /* Fixed navbar styles */
            #mobile-navbar {
                display: block !important;
                visibility: visible !important;
                position: fixed !important;
                top: 0 !important;
                left: 0 !important;
                width: 100% !important;
                z-index: 1000 !important;
                background-color: #186862 !important;
            }

            /* Hide desktop navbar forcefully */
            .navbar.hidden.md\:block,
            nav.navbar:not(#mobile-navbar) {
                display: none !important;
                visibility: hidden !important;
                height: 0 !important;
                overflow: hidden !important;
                opacity: 0 !important;
                pointer-events: none !important;
            }

            /* Ensure proper spacing for mobile content */
            .container {
                padding-left: 1rem !important;
                padding-right: 1rem !important;
                width: 100% !important;
                max-width: 100% !important;
            }

            /* Mobile optimization for grid layouts */
            .grid {
                display: grid !important;
                grid-template-columns: 1fr !important;
            }

            @media (min-width: 480px) {
                .grid {
                    grid-template-columns: repeat(2, 1fr) !important;
                }
            }
        }

        * {
            font-family: Arial, sans-serif !important;
        }

        .media-card {
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .media-card .p-6 {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .media-card .mt-4 {
            margin-top: auto;
        }

        /* Make all cards the same height */
        .grid {
            align-items: stretch;
        }

        /* Enhanced responsive design for mobile devices */
        @media (max-width: 768px) {
            .media-section {
                padding: 3rem 0;
            }

            .media-section .grid {
                gap: 2rem;
            }

            .media-card {
                min-height: 360px;
            }

            .media-card h3 {
                font-size: 1.125rem;
            }

            .media-card p {
                font-size: 0.875rem;
            }
        }

        /* Hyperlink Color */
        .news-excerpt a {
            color: #0D9488;
            text-decoration: underline;
            transition: color 0.2s ease;
        }

        .news-excerpt a:hover {
            color: #F59E0B;
        }

        .news-marquee a {
            color: #facc15;
            text-decoration: underline;
        }

        .news-marquee strong,
        .news-marquee b {
            font-weight: bold;
            color: white;
        }

        .news-marquee em,
        .news-marquee i {
            font-style: italic;
        }

        .news-marquee * {
            color: white;
        }

        .news-marquee .text-yellow-400 {
            color: #facc15 !important;
        }

        .program-card {
            margin-bottom: 25px;
        }

        .card-content {
            padding: 20px;
            text-align: center;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .icon-container {
            margin-bottom: 15px;
        }

        .card-title {
            margin-bottom: 15px;
        }

        .card-description {
            margin-bottom: 20px;
            min-height: 100px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card-description p {
            margin: 0;
            padding: 0 10px;
        }

        .card-link {
            margin-top: auto;
            padding: 8px 15px;
            border-radius: 5px;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .card-link:hover {
            background-color: rgba(0, 0, 0, 0.05);
        }

        html,
        body,
        p,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        span,
        div:not(.fas):not(.fab):not(.far):not(.fa),
        a:not(.fas):not(.fab):not(.far):not(.fa),
        button,
        input,
        textarea,
        select,
        label {
            font-family: Arial, sans-serif !important;
        }

        /* Preserve Font Awesome icons */
        .fas,
        .fab,
        .far,
        .fa,
        [class^="fa-"],
        [class*=" fa-"],
        i.fas,
        i.fab,
        i.far,
        i.fa {
            font-family: "Font Awesome 5 Free", "Font Awesome 5 Brands", "FontAwesome" !important;
        }
    </style>
</head>

<body class="font-sans bg-gray-100">
    <!-- EARLY INIT SCRIPT - Forces mobile detection before content loads -->
    <script>
        (function() {
            // Immediately check if we're on mobile and set appropriate classes
            if (window.innerWidth <= 767) {
                document.body.classList.add('mobile-view');
                // Set a flag in localStorage so other scripts can detect mobile mode
                localStorage.setItem('isMobileView', 'true');
            } else {
                localStorage.setItem('isMobileView', 'false');
            }
        })();
    </script>

    @include('layout.navbar')

    <!-- Mobile detection indicator -->
    <div id="mobile-indicator" class="hidden"></div>

    <!-- Header section with responsive classes -->
    <header class="relative h-screen md:h-screen">
        <img alt="Universitas Negeri Jakarta building with a sculpture in front" class="w-full h-full object-cover"
            src="https://media.quipper.com/media/W1siZiIsIjIwMTgvMDEvMjMvMDkvNDMvMjcvYWVjNTQ1OTctOTJiNi00Y2EyLWEzZDctMGZiNTg1ZTU1MDEzLyJdLFsicCIsInRodW1iIiwiMTIwMHhcdTAwM2UiLHt9XSxbInAiLCJjb252ZXJ0IiwiLWNvbG9yc3BhY2Ugc1JHQiAtc3RyaXAiLHsiZm9ybWF0IjoianBnIn1dXQ?sha=9c61a35270604434" />
        <div class="absolute inset-0 bg-teal-900 bg-opacity-50 flex flex-col justify-center items-start p-4 md:p-8">
            <div class="flex items-center space-x-4">
            </div>
            <div class="mt-16">
            </div>
        </div>
    </header>

    <!-- Announcement bar -->
    <div class="bg-gradient-to-r from-teal-700 to-teal-800 py-3 shadow-lg">
        <div class="container mx-auto px-4 md:px-6">
            <div class="flex items-center space-x-4">
                <div class="bg-yellow-400 p-2 rounded-full flex-shrink-0">
                    <i class="fas fa-bullhorn text-teal-800 text-lg"></i>
                </div>
                <marquee class="flex-1 text-white font-medium news-marquee" ...>
                    @if (isset($announcements) && count($announcements) > 0)
                        {{ $announcements[0]->icon }} <span
                            class="text-yellow-400 font-bold">{{ $announcements[0]->judul_pengumuman }}</span>
                        {{ strip_tags($announcements[0]->isi_pengumuman) }}
                    @else
                        <span class="text-yellow-400 font-bold">Belum ada pengumuman</span>
                    @endif
                </marquee>
            </div>
        </div>
    </div>

    <!-- Berita -->
    <main class="container mx-auto py-12 px-6">
        <!-- Section Header with better styling -->
        <div class="unj-content-section-header">
            <h2 class="unj-section-title">Berita Terbaru</h2>
            <p class="unj-section-subtitle">Informasi terkini dari Universitas Negeri Jakarta</p>
        </div>
        <!-- Filter and View Options -->
        <div>
        </div>


        <!-- Regular News Grid with first 3 news items -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16">
            @if ($regularNews && $regularNews->count() > 0)
                @foreach ($regularNews as $news)
                    <div
                        class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                        <div class="relative">
                            <img alt="{{ $news->judul }}" class="w-full h-56 object-cover"
                                src="{{ asset('storage/' . $news->gambar) }}" />
                            <div
                                class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black to-transparent h-24">
                            </div>
                            <div
                                class="absolute top-3 right-3 bg-yellow-400 text-teal-800 px-3 py-1 rounded-full text-sm font-semibold">
                                {{ ucfirst($news->kategori) }}
                            </div>
                        </div>
                        <div class="p-5">
                            <div class="flex items-center justify-between mb-3">
                                <div class="flex items-center text-gray-500 text-sm">
                                    <i class="fas fa-user-circle mr-2"></i>Admin
                                </div>
                                <div class="text-gray-500 text-sm">
                                    <i
                                        class="fas fa-calendar-alt mr-1"></i>{{ date('d M Y', strtotime($news->tanggal)) }}
                                </div>
                            </div>
                            <a href="{{ route('Berita.show', ['slug' => $news->slug]) }}" class="block">
                                <h2
                                    class="font-bold text-xl mb-3 text-teal-800 hover:text-yellow-600 transition-colors">
                                    {{ $news->judul }}
                                </h2>
                            </a>
                            <p class="text-gray-600 mb-4">
                                {{ Str::limit(strip_tags($news->isi), 100) }}
                            </p>
                            <a href="{{ route('Berita.show', ['slug' => $news->slug]) }}"
                                class="inline-block text-teal-700 hover:text-yellow-500 font-medium">
                                Baca selengkapnya <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            @else
                <p class="col-span-full text-center text-gray-500">Tidak ada berita reguler untuk ditampilkan.</p>
            @endif
        </div>

        <!-- Enhanced Featured News Carousel with remaining news items -->
        <div class="enhanced-carousel">
            <div class="enhanced-carousel-title">Berita Terbaru</div>
            <div class="carousel">
                <div class="carousel-inner">
                    @if ($featuredNews && $featuredNews->count() > 0)
                        @foreach ($featuredNews as $featured)
                            {{-- Changed variable to $featuredItem for clarity --}}
                            <div class="carousel-item-enhanced">
                                <div class="news-card-enhanced">
                                    <div class="news-image-container">
                                        <img alt="{{ $featured->judul }}" class="news-image"
                                            src="{{ asset('storage/' . $featured->gambar) }}" />
                                        <div class="news-tag-enhanced">{{ ucfirst($featured->kategori) }}</div>
                                    </div>
                                    <div class="news-content">
                                        <div class="news-meta">
                                            <i class="fas fa-user-circle mr-2"></i>Admin
                                            <span class="mx-2">|</span>
                                            <i
                                                class="fas fa-calendar-alt mr-2"></i>{{ date('d M Y', strtotime($featured->tanggal)) }}
                                        </div>
                                        <a href="{{ route('Berita.show', ['slug' => $featured->slug]) }}">
                                            <h3 class="news-title">{{ $featured->judul }}</h3>
                                        </a>
                                        <p class="news-excerpt">
                                            {{ Str::limit(strip_tags($featured->isi), 150) }}
                                        </p>
                                        <a href="{{ route('Berita.show', ['slug' => $featured->slug]) }}"
                                            class="news-link">
                                            Baca selengkapnya <i class="fas fa-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center text-gray-500 p-4">Tidak ada berita lainnya untuk ditampilkan di
                            carousel.</div>
                    @endif
                </div>
            </div>
        </div>
    </main>

    <!-- Program Section - mobile optimized -->
    <section class="program-section py-8 md:py-16 bg-gray-50">
        <div class="container mx-auto px-4 md:px-6">
            <div class="text-center mb-8 md:mb-12">
                <h2 class="text-2xl md:text-3xl font-bold text-teal-700 mb-2">Program & Layanan</h2>
                <div class="flex items-center justify-center mb-4">
                    <div class="h-1 w-16 bg-gray-300"></div>
                    <span class="text-yellow-400 text-xl md:text-2xl mx-3"><i class="fas fa-cogs"></i></span>
                    <div class="h-1 w-16 bg-gray-300"></div>
                </div>
                <p class="text-gray-600 max-w-2xl mx-auto text-sm md:text-base">Program dan Layanan Direktorat Inovasi,
                    Sistem Informasi dan Pemeringkatan</p>
            </div>

            <!-- First 3 items in grid - ADDING specific classes for matching -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 md:gap-6 mb-8 program-main-grid">
                @forelse($programLayanan->take(3) as $program)
                    <div
                        class="program-card bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300">
                        <div class="relative">
                            @if ($program->image)
                                <img src="{{ asset('storage/' . $program->image) }}" alt="{{ $program->judul }}"
                                    class="w-full h-48 object-cover">
                            @else
                                <div class="w-full h-48 bg-teal-600 flex items-center justify-center">
                                    <i
                                        class="{{ $program->icon ?? 'fas fa-cogs' }} text-4xl md:text-5xl text-white"></i>
                                </div>
                            @endif
                        </div>
                        <div class="p-4 md:p-5">
                            <h3 class="font-bold text-teal-800 text-lg md:text-xl mb-3">{{ $program->judul }}</h3>
                            <div class="text-gray-600 mb-4 program-excerpt text-sm md:text-base"
                                style="min-height: 60px;">
                                {!! Str::limit(strip_tags($program->deskripsi), 100) !!}
                            </div>
                            <a href="#"
                                class="program-details-btn inline-flex items-center text-teal-700 hover:text-yellow-500 font-medium text-sm md:text-base"
                                data-program-id="{{ $program->id }}" data-title="{{ $program->judul }}"
                                data-full-description="{!! htmlspecialchars($program->deskripsi_lengkap ?? $program->deskripsi) !!}">
                                Selengkapnya <i class="fas fa-arrow-right ml-2"></i>
                            </a>

                            <div class="mt-4 pt-3 border-t border-gray-100">
                                <button type="button"
                                    class="login w-full text-center bg-gradient-to-r from-teal-600 to-teal-500 text-white py-2 md:py-3 px-4 md:px-6 rounded-lg font-semibold text-sm md:text-base">
                                    Akses Program
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="program-card bg-white rounded-xl overflow-hidden shadow-lg col-span-full">
                        <div class="p-8 text-center">
                            <i class="fas fa-exclamation-circle text-5xl text-teal-600 mb-4"></i>
                            <h3 class="font-bold text-teal-800 text-xl mb-3">Belum Ada Program</h3>
                            <p class="text-gray-600">Maaf, saat ini belum ada program layanan yang tersedia.</p>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Carousel for additional items (if more than 3) -->
            @if (count($programLayanan) > 3)
                <div class="mt-8">
                    <h3 class="text-xl font-semibold text-teal-700 mb-4 text-center">Program Lainnya</h3>
                    <!-- Container with exact same width as top grid -->
                    <div class="program-carousel-container mx-auto">
                        <!-- Use exact same padding as the top container -->
                        <div class="program-carousel relative">
                            <!-- Critical: set exact width to parent container -->
                            <div class="swiper-container">
                                <div class="swiper-wrapper">
                                    @foreach ($programLayanan->skip(3) as $program)
                                        <div class="swiper-slide">
                                            <div
                                                class="program-card bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 h-full">
                                                <div class="relative">
                                                    @if ($program->image)
                                                        <img src="{{ asset('storage/' . $program->image) }}"
                                                            alt="{{ $program->judul }}"
                                                            class="w-full h-48 object-cover">
                                                    @else
                                                        <div
                                                            class="w-full h-48 bg-teal-600 flex items-center justify-center">
                                                            <i
                                                                class="{{ $program->icon ?? 'fas fa-cogs' }} text-4xl md:text-5xl text-white"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="p-4 md:p-5">
                                                    <h3 class="font-bold text-teal-800 text-lg md:text-xl mb-3">
                                                        {{ $program->judul }}</h3>
                                                    <div class="text-gray-600 mb-4 program-excerpt text-sm md:text-base"
                                                        style="min-height: 60px;">
                                                        {{ Str::limit(strip_tags($program->deskripsi), 100) }}
                                                    </div>
                                                    <a href="#"
                                                        class="program-details-btn inline-flex items-center text-teal-700 hover:text-yellow-500 font-medium text-sm md:text-base"
                                                        data-program-id="{{ $program->id }}"
                                                        data-title="{{ $program->judul }}"
                                                        data-full-description="{!! htmlspecialchars($program->deskripsi_lengkap ?? $program->deskripsi) !!}">
                                                        Selengkapnya <i class="fas fa-arrow-right ml-2"></i>
                                                    </a>

                                                    <div class="mt-4 pt-3 border-t border-gray-100">
                                                        <button type="button"
                                                            class="login w-full text-center bg-gradient-to-r from-teal-600 to-teal-500 text-white py-2 md:py-3 px-4 md:px-6 rounded-lg font-semibold text-sm md:text-base">
                                                            Akses Program
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <!-- Position buttons outside the container but within view -->
                            <div class="swiper-button-next hidden md:flex"></div>
                            <div class="swiper-button-prev hidden md:flex"></div>
                            <div class="swiper-pagination"></div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>

    <!-- Initialize Swiper JS -->
    @if (count($programLayanan) > 3)
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Wait for layout to fully render
                setTimeout(() => {
                    // Configure swiper with exact measurements and prevent overscroll
                    const swiper = new Swiper('.swiper-container', {
                        slidesPerView: 1,
                        spaceBetween: 16, // gap-4 equivalent
                        loop: false,
                        preventInteractionOnTransition: true,
                        navigation: {
                            nextEl: '.swiper-button-next',
                            prevEl: '.swiper-button-prev',
                        },
                        pagination: {
                            el: '.swiper-pagination',
                            clickable: true,
                        },
                        breakpoints: {
                            640: {
                                slidesPerView: 2,
                                spaceBetween: 16, // Exact gap-4 measurement
                            },
                            768: {
                                slidesPerView: 3,
                                spaceBetween: 24, // Match gap-6
                                // Critical fix - prevent partial showing of next slide
                                slidesOffsetAfter: 0,
                                slidesOffsetBefore: 0
                            }
                        },
                        on: {
                            init: function() {
                                // Force full layout recalculation
                                this.update();
                            },
                            resize: function() {
                                // Update on any window resize
                                this.update();
                            }
                        }
                    });
                }, 200);
            });
        </script>
    @endif

    <!-- Add Swiper CSS and JS -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

    <style>
        /* Match carousel container to the top grid width exactly */
        .program-carousel-container {
            width: 100%;
            padding-left: 16px;
            padding-right: 16px;
            overflow: hidden;
            /* Prevent horizontal scroll */
        }

        @media (min-width: 768px) {
            .program-carousel-container {
                padding-left: 24px;
                padding-right: 24px;
            }
        }

        /* Make the carousel structure match the grid */
        .program-carousel {
            padding-bottom: 30px;
            width: 100%;
            position: relative;
        }

        /* Match width for swiper with the grid container */
        .swiper-container {
            overflow: hidden;
            padding-bottom: 30px;
            width: 100%;
            box-sizing: border-box;
        }

        .swiper-wrapper {
            align-items: stretch;
            /* Fix to prevent partial view of 4th slide */
            width: auto !important;
        }

        /* Position navigation buttons exactly at container edges */
        .swiper-button-next,
        .swiper-button-prev {
            color: #0d9488;
            background: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: -20px;
            z-index: 10;
            top: 50%;
        }

        .swiper-button-next {
            right: 0;
        }

        .swiper-button-prev {
            left: 0;
        }

        .swiper-button-next::after,
        .swiper-button-prev::after {
            font-size: 20px;
        }

        .swiper-pagination-bullet-active {
            background: #0d9488;
        }

        /* Fix to prevent partial view of 4th slide */
        .swiper-slide {
            height: auto;
            box-sizing: border-box;
            width: 100% !important;
            /* Force exactly 3 slides on desktop */
        }

        /* Make slides match the grid cell width exactly */
        @media (min-width: 640px) {
            .swiper-slide {
                width: calc((100% - 16px) / 2) !important;
                /* 2 slides on tablet */
            }
        }

        @media (min-width: 768px) {
            .swiper-slide {
                width: calc((100% - 48px) / 3) !important;
                /* 3 slides on desktop */
            }
        }

        /* Prevent swiper from showing partial slides */
        .swiper-container-horizontal>.swiper-wrapper {
            display: flex;
            flex-wrap: nowrap;
        }
    </style>

    <!-- Instagram Section -->
    <section class="media-section py-8 md:py-16 bg-gradient-to-b from-white to-gray-50">
        <div class="container mx-auto px-4 md:px-6">
            <div class="text-center mb-8 md:mb-12">
                <h2 class="text-2xl md:text-3xl font-bold text-teal-700 mb-2">Instagram DITSIP UNJ</h2>
                <div class="flex items-center justify-center mb-4">
                    <div class="h-1 w-16 bg-gray-300"></div>
                    <span class="text-yellow-400 text-xl md:text-2xl mx-3"><i class="fab fa-instagram"></i></span>
                    <div class="h-1 w-16 bg-gray-300"></div>
                </div>
                <p class="text-gray-600 max-w-2xl mx-auto text-sm md:text-base">Ikuti akun Instagram kami untuk
                    mendapatkan informasi terbaru</p>
                <a href="https://www.instagram.com/dit.isipunj/" target="_blank"
                    class="inline-flex items-center text-teal-700 hover:text-yellow-500 mt-2 font-medium text-sm md:text-base">
                    <span>@dit.isipunj</span>
                    <i class="fas fa-external-link-alt ml-2"></i>
                </a>
            </div>

            <div id="instagram-api-feed-container"
                class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 md:gap-8">
                <!-- Loading placeholders -->
                @for ($i = 0; $i < 3; $i++)
                    <div class="media-card bg-white rounded-xl overflow-hidden shadow-lg animate-pulse">
                        <div class="relative pb-[56.25%] h-0 overflow-hidden bg-gray-200"></div>
                        <div class="p-4 md:p-6">
                            <div class="h-4 bg-gray-200 rounded w-3/4 mb-3"></div>
                            <div class="h-6 bg-gray-200 rounded w-full mb-2"></div>
                            <div class="h-4 bg-gray-200 rounded w-full mb-4"></div>
                        </div>
                    </div>
                @endfor
            </div>

            <div class="text-center mt-8">
                <a href="https://www.instagram.com/dit.isipunj/" target="_blank"
                    class="inline-flex items-center justify-center px-4 md:px-6 py-2 md:py-3 bg-teal-700 hover:bg-teal-600 text-white font-medium rounded-lg text-sm md:text-base">
                    <span>Lihat Semua Postingan</span>
                    <i class="fas fa-external-link-alt ml-2"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- YouTube Section -->
    <section class="media-section py-8 md:py-16">
        <div class="container mx-auto px-4 md:px-6">
            <div class="text-center mb-8 md:mb-12">
                <h2 class="text-2xl md:text-3xl font-bold text-teal-700 mb-2">Galeri Video</h2>
                <div class="flex items-center justify-center mb-4">
                    <div class="h-1 w-16 bg-gray-300"></div>
                    <span class="text-red-500 text-xl md:text-2xl mx-3"><i class="fab fa-youtube"></i></span>
                    <div class="h-1 w-16 bg-gray-300"></div>
                </div>

            </div>

            <div id="dynamic-videos-container" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 md:gap-8">
                <!-- Loading placeholders -->
                @for ($i = 0; $i < 3; $i++)
                    <div class="media-card bg-white rounded-xl overflow-hidden shadow-lg animate-pulse">
                        <div class="relative pb-[56.25%] h-0 overflow-hidden bg-gray-200"></div>
                        <div class="p-4 md:p-6">
                            <div class="h-4 bg-gray-200 rounded w-3/4 mb-3"></div>
                            <div class="h-6 bg-gray-200 rounded w-full mb-2"></div>
                            <div class="h-4 bg-gray-200 rounded w-full mb-4"></div>
                        </div>
                    </div>
                @endfor
            </div>

            <div class="text-center mt-8">
                <a href="https://www.youtube.com/channel/UCjQ4lIzs8Zm3zVD3wiL-KMw" target="_blank"
                    class="inline-flex items-center justify-center px-4 md:px-6 py-2 md:py-3 bg-teal-700 hover:bg-teal-600 text-white font-medium rounded-lg text-sm md:text-base">
                    <span>Lihat Semua Video</span>
                    <i class="fas fa-external-link-alt ml-2"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Program Details Modal -->
    <div id="programDetailsModal"
        class="fixed inset-0 bg-black bg-opacity-60 z-[1100] hidden items-center justify-center p-4 overflow-y-auto">
        <div class="bg-white rounded-xl shadow-2xl max-w-3xl w-full max-h-[90vh] overflow-y-auto relative">
            <div class="relative h-48 md:h-56">
                <div id="modalImageContainer" class="w-full h-full bg-teal-600 flex items-center justify-center">
                    <i id="modalFallbackIcon" class="fas fa-cogs text-6xl text-white"></i>
                </div>
                <div class="absolute top-0 right-0 m-4">
                    <button id="closeModalBtn" class="bg-white rounded-full p-2 shadow-md hover:bg-teal-50">
                        <i class="fas fa-times text-teal-700 text-xl"></i>
                    </button>
                </div>
                <div class="absolute bottom-0 left-0 w-full p-4 md:p-6">
                    <h2 id="programModalTitle" class="text-2xl md:text-3xl font-bold text-white shadow-text"></h2>
                </div>
            </div>
            <div class="p-4 md:p-8">
                <div id="programModalDescription" class="prose max-w-none text-gray-700 text-sm md:text-base">
                    <!-- Dynamic content -->
                </div>
            </div>
        </div>
    </div>

    <section class="unj-prestasi-container py-12 md:py-16 bg-slate-100">
        <div class="container mx-auto px-4">
            <div class="section-title text-center mb-10 md:mb-16">
                <h2 class="text-3xl sm:text-4xl font-bold text-slate-800">
                    <span class="text-emerald-600">UNJ dalam Prestasi</span>
                </h2>
                <div class="mt-4 h-1.5 w-28 bg-emerald-600 mx-auto rounded-full"></div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6 md:gap-8">

                <div
                    class="prestasi-card bg-white rounded-lg border border-slate-200 p-6 flex flex-col items-center text-center transition-all duration-300 ease-in-out hover:shadow-xl hover:border-emerald-500 hover:-translate-y-1">
                    <div class="text-emerald-500 text-5xl mb-4">
                        <i class="fa fa-user-graduate"></i>
                    </div>
                    <div class="text-4xl font-bold text-slate-700 mb-1">30.673</div>
                    <div class="text-base text-slate-500 font-medium">Mahasiswa</div>
                </div>

                <div
                    class="prestasi-card bg-white rounded-lg border border-slate-200 p-6 flex flex-col items-center text-center transition-all duration-300 ease-in-out hover:shadow-xl hover:border-sky-500 hover:-translate-y-1">
                    <div class="text-sky-500 text-5xl mb-4">
                        <i class="fa fa-globe"></i>
                    </div>
                    <div class="text-4xl font-bold text-slate-700 mb-1">125</div>
                    <div class="text-base text-slate-500 font-medium">Mahasiswa Internasional</div>
                </div>

                <div
                    class="prestasi-card bg-white rounded-lg border border-slate-200 p-6 flex flex-col items-center text-center transition-all duration-300 ease-in-out hover:shadow-xl hover:border-purple-500 hover:-translate-y-1">
                    <div class="text-purple-500 text-5xl mb-4">
                        <i class="fa fa-chalkboard-teacher"></i>
                    </div>
                    <div class="text-4xl font-bold text-slate-700 mb-1">131</div>
                    <div class="text-base text-slate-500 font-medium">Guru Besar</div>
                </div>

                <div
                    class="prestasi-card bg-white rounded-lg border border-slate-200 p-6 flex flex-col items-center text-center transition-all duration-300 ease-in-out hover:shadow-xl hover:border-indigo-500 hover:-translate-y-1">
                    <div class="text-indigo-500 text-5xl mb-4">
                        <i class="fa fa-user-tie"></i>
                    </div>
                    <div class="text-4xl font-bold text-slate-700 mb-1">1.132</div>
                    <div class="text-base text-slate-500 font-medium">Dosen</div>
                </div>

                <a href="{{ route('Pemeringkatan.program.international-faculty-staff') }}"
                    class="prestasi-card block bg-white rounded-lg border border-slate-200 p-6 flex flex-col items-center text-center transition-all duration-300 ease-in-out hover:shadow-xl hover:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50 hover:-translate-y-1">
                    <div class="text-red-500 text-5xl mb-4">
                        <i class="fa fa-users"></i>
                    </div>
                    <div class="text-4xl font-bold text-slate-700 mb-1">4</div>
                    <div class="text-base text-slate-500 font-medium">Dosen Internasional</div>
                </a>

                <div
                    class="prestasi-card bg-white rounded-lg border border-slate-200 p-6 flex flex-col items-center text-center transition-all duration-300 ease-in-out hover:shadow-xl hover:border-orange-500 hover:-translate-y-1">
                    <div class="text-orange-500 text-5xl mb-4">
                        <i class="fa fa-user-cog"></i>
                    </div>
                    <div class="text-4xl font-bold text-slate-700 mb-1">774</div>
                    <div class="text-base text-slate-500 font-medium">Tendik</div>
                </div>

                <div
                    class="prestasi-card bg-white rounded-lg border border-slate-200 p-6 flex flex-col items-center text-center transition-all duration-300 ease-in-out hover:shadow-xl hover:border-lime-500 hover:-translate-y-1">
                    <div class="text-lime-500 text-5xl mb-4">
                        <i class="fa fa-university"></i>
                    </div>
                    <div class="text-4xl font-bold text-slate-700 mb-1">8</div>
                    <div class="text-base text-slate-500 font-medium">Fakultas</div>
                </div>

                <div
                    class="prestasi-card bg-white rounded-lg border border-slate-200 p-6 flex flex-col items-center text-center transition-all duration-300 ease-in-out hover:shadow-xl hover:border-cyan-500 hover:-translate-y-1">
                    <div class="text-cyan-500 text-5xl mb-4">
                        <i class="fa fa-graduation-cap"></i>
                    </div>
                    <div class="text-4xl font-bold text-slate-700 mb-1">1</div>
                    <div class="text-base text-slate-500 font-medium">Sekolah Pascasarjana</div>
                </div>

                <div
                    class="prestasi-card bg-white rounded-lg border border-slate-200 p-6 flex flex-col items-center text-center transition-all duration-300 ease-in-out hover:shadow-xl hover:border-pink-500 hover:-translate-y-1">
                    <div class="text-pink-500 text-5xl mb-4">
                        <i class="fa fa-th-large"></i>
                    </div>
                    <div class="text-4xl font-bold text-slate-700 mb-1">116</div>
                    <div class="text-base text-slate-500 font-medium">Program Studi</div>
                </div>

                <div
                    class="prestasi-card bg-white rounded-lg border border-slate-200 p-6 flex flex-col items-center text-center transition-all duration-300 ease-in-out hover:shadow-xl hover:border-green-500 hover:-translate-y-1">
                    <div class="text-green-500 text-5xl mb-4">
                        <i class="fa fa-book"></i>
                    </div>
                    <div class="text-4xl font-bold text-slate-700 mb-1">3.681</div>
                    <div class="text-base text-slate-500 font-medium">terindeks Scopus</div>
                </div>

                <div
                    class="prestasi-card bg-white rounded-lg border border-slate-200 p-6 flex flex-col items-center text-center transition-all duration-300 ease-in-out hover:shadow-xl hover:border-amber-500 hover:-translate-y-1">
                    <div class="text-amber-500 text-5xl mb-4">
                        <i class="fa fa-file-alt"></i>
                    </div>
                    <div class="text-4xl font-bold text-slate-700 mb-1">2.459</div>
                    <div class="text-base text-slate-500 font-medium">HKI</div>
                </div>

                <div
                    class="prestasi-card bg-white rounded-lg border border-slate-200 p-6 flex flex-col items-center text-center transition-all duration-300 ease-in-out hover:shadow-xl hover:border-rose-500 hover:-translate-y-1">
                    <div class="text-rose-500 text-5xl mb-4">
                        <i class="fa fa-certificate"></i>
                    </div>
                    <div class="text-4xl font-bold text-slate-700 mb-1">123</div>
                    <div class="text-base text-slate-500 font-medium">Hak Paten</div>
                </div>
            </div>
        </div>
    </section>

    @include('layout.footer')

    {{-- <!-- Load mobile.js EARLIER to ensure it runs before other scripts -->
    <script src="{{ asset('resources/movejs/mobile.js') }}"></script>
    <script src="{{ asset('resources/movejs/instagram-api-feed.js') }}"></script>
    <script src="{{ asset('resources/movejs/home.js') }}"></script> --}}

    <script>
        // Enhanced mobile.js - Complete implementation
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Mobile script initialized - enhanced version');

            // Fix viewport settings
            const viewport = document.querySelector('meta[name="viewport"]');
            if (viewport) {
                viewport.setAttribute('content',
                    'width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no');
                console.log('Viewport meta tag updated');
            }

            // Mobile elements
            const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
            const menuIcon = document.getElementById('menu-icon');
            const mobileSidebar = document.getElementById('mobile-sidebar');
            const sidebarOverlay = document.getElementById('sidebar-overlay');
            const closeSidebar = document.getElementById('close-sidebar');
            const dropdownButtons = document.querySelectorAll('.sidebar-dropdown button');

            // Force mobile navbar for mobile devices
            function forceMobileLayout() {
                if (window.innerWidth <= 767) {
                    // Get navbar elements
                    const mobileNavbar = document.getElementById('mobile-navbar');
                    const desktopNavbar = document.querySelector('.navbar.hidden.md\\:block');

                    if (mobileNavbar) {
                        mobileNavbar.style.display = 'block';
                        mobileNavbar.style.visibility = 'visible';
                        console.log('Mobile navbar displayed');
                    }

                    if (desktopNavbar) {
                        desktopNavbar.style.display = 'none';
                        desktopNavbar.style.visibility = 'hidden';
                        console.log('Desktop navbar hidden');
                    }

                    // Add mobile class to body
                    document.body.classList.add('mobile-view');
                }
            }

            // Run immediately
            forceMobileLayout();

            // Run after short delays to override any other scripts
            setTimeout(forceMobileLayout, 100);
            setTimeout(forceMobileLayout, 500);

            // Show sidebar function with direct style manipulation
            function showSidebar() {
                console.log('Opening sidebar');

                // Apply styles directly
                if (mobileSidebar) {
                    mobileSidebar.style.transform = 'translateX(0)';
                    mobileSidebar.style.display = 'block';
                    console.log('Sidebar transform applied');
                }

                if (sidebarOverlay) {
                    sidebarOverlay.style.opacity = '1';
                    sidebarOverlay.style.visibility = 'visible';
                    sidebarOverlay.style.pointerEvents = 'auto';
                    console.log('Overlay styles applied');
                }

                document.body.classList.add('sidebar-open');

                if (menuIcon) {
                    menuIcon.classList.remove('fa-bars');
                    menuIcon.classList.add('fa-times');
                }
            }

            // Hide sidebar function with direct style manipulation
            function hideSidebar() {
                console.log('Closing sidebar');

                // Apply styles directly
                if (mobileSidebar) {
                    mobileSidebar.style.transform = 'translateX(100%)';
                    console.log('Sidebar transform reset');
                }

                if (sidebarOverlay) {
                    sidebarOverlay.style.opacity = '0';
                    sidebarOverlay.style.visibility = 'hidden';
                    sidebarOverlay.style.pointerEvents = 'none';
                    console.log('Overlay styles reset');
                }

                document.body.classList.remove('sidebar-open');

                if (menuIcon) {
                    menuIcon.classList.remove('fa-times');
                    menuIcon.classList.add('fa-bars');
                }
            }

            // Toggle sidebar with click handler
            if (mobileMenuToggle) {
                console.log('Menu toggle button found');
                mobileMenuToggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    console.log('Menu toggle clicked');
                    showSidebar();
                });
            } else {
                console.log('ERROR: Menu toggle button not found!');
            }

            // Close sidebar handlers
            if (closeSidebar) {
                console.log('Close button found');
                closeSidebar.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    console.log('Close button clicked');
                    hideSidebar();
                });
            } else {
                console.log('ERROR: Close sidebar button not found!');
            }

            if (sidebarOverlay) {
                console.log('Overlay found');
                sidebarOverlay.addEventListener('click', function(e) {
                    console.log('Overlay clicked');
                    hideSidebar();
                });
            } else {
                console.log('ERROR: Sidebar overlay not found!');
            }

            // Handle dropdown menus in sidebar
            if (dropdownButtons && dropdownButtons.length > 0) {
                console.log('Found ' + dropdownButtons.length + ' dropdown buttons');
                dropdownButtons.forEach(function(button, index) {
                    button.addEventListener('click', function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        console.log('Dropdown button ' + (index + 1) + ' clicked');

                        const dropdown = this.nextElementSibling;
                        const icon = this.querySelector('.fa-chevron-down');

                        if (dropdown) {
                            dropdown.classList.toggle('hidden');
                            const isHidden = dropdown.classList.contains('hidden');
                            console.log('Dropdown ' + (index + 1) + ' is now ' + (isHidden ?
                                'hidden' : 'visible'));

                            if (icon) {
                                icon.style.transform = isHidden ? 'rotate(0)' : 'rotate(180deg)';
                            }
                        } else {
                            console.log('ERROR: No dropdown found for button ' + (index + 1));
                        }
                    });
                });
            } else {
                console.log('No dropdown buttons found');
            }

            // Close sidebar on escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    console.log('Escape key pressed');
                    hideSidebar();
                }
            });

            // Run on resize to maintain correct display
            window.addEventListener('resize', forceMobileLayout);

            // Run after page load
            window.addEventListener('load', forceMobileLayout);

            // Add debug function
            window.debugMobileSidebar = function() {
                const elements = {
                    viewport: viewport ? viewport.getAttribute('content') : 'Not found',
                    mobileMenuToggle: mobileMenuToggle ? 'Found' : 'Not found',
                    mobileSidebar: mobileSidebar ? 'Found' : 'Not found',
                    sidebarOverlay: sidebarOverlay ? 'Found' : 'Not found',
                    closeSidebar: closeSidebar ? 'Found' : 'Not found',
                    dropdownButtons: dropdownButtons ? dropdownButtons.length + ' found' : 'None found'
                };

                const styles = {
                    sidebarTransform: mobileSidebar ? mobileSidebar.style.transform : 'N/A',
                    sidebarDisplay: mobileSidebar ? getComputedStyle(mobileSidebar).display : 'N/A',
                    overlayOpacity: sidebarOverlay ? sidebarOverlay.style.opacity : 'N/A',
                    overlayVisibility: sidebarOverlay ? sidebarOverlay.style.visibility : 'N/A',
                    bodyHasClass: document.body.classList.contains('sidebar-open')
                };

                console.log('Mobile Debug Info:');
                console.log('Elements:', elements);
                console.log('Styles:', styles);
                console.log('Window width:', window.innerWidth);

                return {
                    elements,
                    styles
                };
            };

            // Override any existing force desktop layout functions
            if (window.forceDesktopLayout) {
                console.log('Overriding forceDesktopLayout function');
                const originalFn = window.forceDesktopLayout;
                window.forceDesktopLayout = function() {
                    // Call original function
                    originalFn.apply(this, arguments);

                    // Then forcefully apply our mobile layout if needed
                    if (window.innerWidth <= 767) {
                        forceMobileLayout();
                    }
                };
            }

            // Initial styles setup
            if (mobileSidebar) {
                console.log('Setting initial sidebar style');
                mobileSidebar.style.transform = 'translateX(100%)';
            }

            if (sidebarOverlay) {
                console.log('Setting initial overlay style');
                sidebarOverlay.style.opacity = '0';
                sidebarOverlay.style.visibility = 'hidden';
                sidebarOverlay.style.pointerEvents = 'none';
            }

            console.log('Mobile initialization complete');
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Fetch YouTube videos from the API
            fetch('/api/youtube-videos')
                .then(response => response.json())
                .then(videos => {
                    const container = document.getElementById('dynamic-videos-container');

                    // Clear loading placeholders
                    container.innerHTML = '';

                    if (videos.length === 0) {
                        // Display a message if no videos are found
                        container.innerHTML = `
                        <div class="col-span-3 text-center py-8">
                            <p class="text-gray-500">Belum ada video tersedia.</p>
                        </div>
                    `;
                        return;
                    }

                    // Generate HTML for each video
                    videos.forEach(video => {
                        // Extract YouTube video ID from the link
                        let videoId = '';

                        // Handle different YouTube URL formats
                        if (video.link.includes('youtu.be/')) {
                            // Short URL format: https://youtu.be/VIDEO_ID
                            videoId = video.link.split('youtu.be/')[1].split('?')[0];
                        } else if (video.link.includes('watch?v=')) {
                            // Standard URL format: https://www.youtube.com/watch?v=VIDEO_ID
                            const urlParams = new URLSearchParams(video.link.split('?')[1]);
                            videoId = urlParams.get('v');
                        } else if (video.link.includes('/embed/')) {
                            // Already in embed format
                            videoId = video.link.split('/embed/')[1];
                        } else {
                            // Fallback
                            videoId = video.link.replace('watch?v=', 'embed/').split('/').pop();
                        }

                        const embedUrl = `https://www.youtube.com/embed/${videoId}?rel=0`;

                        // Create video card
                        const videoCard = `
                        <div class="media-card bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 group">
                            <div class="relative pb-[56.25%] h-0 overflow-hidden">
                                <iframe class="absolute top-0 left-0 w-full h-full" 
                                    src="${embedUrl}" 
                                    title="${video.judul}" 
                                    frameborder="0" 
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                                    referrerpolicy="strict-origin-when-cross-origin" 
                                    allowfullscreen>
                                </iframe>
                            </div>
                            <div class="p-6">
                                <div class="flex items-center mb-3">
                                    <div class="flex items-center text-gray-500 text-sm">
                                        <i class="fab fa-youtube mr-2"></i>
                                        <span>UNJ Official</span>
                                    </div>
                                </div>
                                <h3 class="font-bold text-teal-800 text-xl mb-2 group-hover:text-yellow-500 transition-colors duration-300">${video.judul}</h3>
                                <p class="text-gray-600 mb-4">${video.deskripsi.length > 100 ? video.deskripsi.substring(0, 100) + '...' : video.deskripsi}</p>
                                <div class="mt-4 pt-4 border-t border-gray-100">
                                    <a href="${video.link}" target="_blank" class="inline-flex items-center text-teal-600 hover:text-yellow-500 transition-colors duration-300">
                                        <span>Tonton di YouTube</span>
                                        <i class="fas fa-external-link-alt ml-2 text-sm"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    `;

                        // Add video card to container
                        container.innerHTML += videoCard;
                    });
                })
                .catch(error => {
                    console.error('Error fetching YouTube videos:', error);
                    const container = document.getElementById('dynamic-videos-container');
                    container.innerHTML = `
                    <div class="col-span-3 text-center py-8">
                        <p class="text-gray-500">Gagal memuat video. Silakan coba lagi nanti.</p>
                    </div>
                `;
                });
        });
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('programDetailsModal');
            const modalTitle = document.getElementById('programModalTitle');
            const modalDescription = document.getElementById('programModalDescription');
            const modalImageContainer = document.getElementById('modalImageContainer');
            const modalFallbackIcon = document.getElementById('modalFallbackIcon');
            const closeModalBtn = document.getElementById('closeModalBtn');
            const programDetailsBtns = document.querySelectorAll('.program-details-btn');

            // Function to open modal
            function openProgramModal(btn) {
                // Get data from button's data attributes
                const programId = btn.getAttribute('data-program-id');
                const title = btn.getAttribute('data-title');
                const fullDescription = btn.getAttribute('data-full-description');

                // Get card for image reference
                const card = btn.closest('.program-card');
                const cardImage = card.querySelector('img');

                // Set modal content
                modalTitle.textContent = title;
                modalDescription.innerHTML = fullDescription;

                // Handle image
                if (cardImage) {
                    modalImageContainer.innerHTML = ''; // Clear previous content
                    const modalImage = document.createElement('img');
                    modalImage.src = cardImage.src;
                    modalImage.alt = title;
                    modalImage.className = 'w-full h-full object-cover';
                    modalImageContainer.appendChild(modalImage);
                    modalFallbackIcon.style.display = 'none';
                } else {
                    // If no image, show the fallback icon
                    modalFallbackIcon.style.display = 'block';
                    // Try to get the icon class from the card
                    const cardIcon = card.querySelector('.bg-teal-600 i');
                    if (cardIcon) {
                        modalFallbackIcon.className = cardIcon.className;
                    } else {
                        modalFallbackIcon.className = 'fas fa-cogs text-6xl text-white';
                    }
                }

                // Show modal
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }

            // Add click event to all "Selengkapnya" buttons
            programDetailsBtns.forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    openProgramModal(this);
                });
            });

            // Close modal when close button is clicked
            closeModalBtn.addEventListener('click', function() {
                modal.classList.remove('flex');
                modal.classList.add('hidden');
            });

            // Close modal when clicking outside of the modal content
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    modal.classList.remove('flex');
                    modal.classList.add('hidden');
                }
            });

            // Close modal with Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
                    modal.classList.remove('flex');
                    modal.classList.add('hidden');
                }
            });
        });

        function isMobileDevice() {
            const userAgent = navigator.userAgent.toLowerCase();
            const mobileKeywords = /android|webos|iphone|ipad|ipod|blackberry|iemobile|opera mini/i;
            const isMobileUA = mobileKeywords.test(userAgent);
            const isMobileWidth = window.innerWidth <= 768;
            const hasTouch = 'ontouchstart' in window || navigator.maxTouchPoints > 0;

            return (isMobileUA && hasTouch) || (isMobileWidth && hasTouch) || (isMobileUA && isMobileWidth);
        }

        // Add mobile indicator
        document.addEventListener('DOMContentLoaded', function() {
            const indicator = document.getElementById('mobile-indicator');
            if (indicator) {
                indicator.style.display = 'block';
                indicator.style.cssText = `
                    position: fixed;
                    top: 10px;
                    left: 10px;
                    background: ${isMobileDevice() ? '#4CAF50' : '#ff5722'};
                    color: white;
                    padding: 5px 10px;
                    font-size: 12px;
                    z-index: 9999;
                    border-radius: 4px;
                `;
                indicator.textContent =
                    `${isMobileDevice() ? 'Mobile' : 'Desktop'}: ${window.innerWidth}x${window.innerHeight}`;

                window.addEventListener('resize', function() {
                    indicator.textContent =
                        `${isMobileDevice() ? 'Mobile' : 'Desktop'}: ${window.innerWidth}x${window.innerHeight}`;
                    indicator.style.background = isMobileDevice() ? '#4CAF50' : '#ff5722';
                });
            }

            // Apply mobile class if needed
            if (isMobileDevice()) {
                document.body.classList.add('mobile-mode');
                console.log('Mobile mode activated');
            }

            // Check media query
            const mq = window.matchMedia('(max-width: 768px)');
            console.log('Media query (max-width: 768px) matches:', mq.matches);

            mq.addListener(function(e) {
                console.log('Media query changed:', e.matches);
            });
        });
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('programDetailsModal');
            const modalTitle = document.getElementById('programModalTitle');
            const modalDescription = document.getElementById('programModalDescription');
            const modalImageContainer = document.getElementById('modalImageContainer');
            const modalFallbackIcon = document.getElementById('modalFallbackIcon');
            const closeModalBtn = document.getElementById('closeModalBtn');
            const programDetailsBtns = document.querySelectorAll('.program-details-btn');

            // Function to open modal
            function openProgramModal(btn) {
                // Get data from button's data attributes
                const programId = btn.getAttribute('data-program-id');
                const title = btn.getAttribute('data-title');
                const fullDescription = btn.getAttribute('data-full-description');

                // Get card for image reference
                const card = btn.closest('.program-card');
                const cardImage = card.querySelector('img');

                // Set modal content
                modalTitle.textContent = title;
                modalDescription.innerHTML = fullDescription;

                // Handle image
                if (cardImage) {
                    modalImageContainer.innerHTML = ''; // Clear previous content
                    const modalImage = document.createElement('img');
                    modalImage.src = cardImage.src;
                    modalImage.alt = title;
                    modalImage.className = 'w-full h-full object-cover';
                    modalImageContainer.appendChild(modalImage);
                    modalFallbackIcon.style.display = 'none';
                } else {
                    // If no image, show the fallback icon
                    modalFallbackIcon.style.display = 'block';
                    // Try to get the icon class from the card
                    const cardIcon = card.querySelector('.bg-teal-600 i');
                    if (cardIcon) {
                        modalFallbackIcon.className = cardIcon.className;
                    } else {
                        modalFallbackIcon.className = 'fas fa-cogs text-6xl text-white';
                    }
                }

                // Show modal
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }

            // Add click event to all "Selengkapnya" buttons
            programDetailsBtns.forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    openProgramModal(this);
                });
            });

            // Close modal when close button is clicked
            closeModalBtn.addEventListener('click', function() {
                modal.classList.remove('flex');
                modal.classList.add('hidden');
            });

            // Close modal when clicking outside of the modal content
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    modal.classList.remove('flex');
                    modal.classList.add('hidden');
                }
            });

            // Close modal with Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
                    modal.classList.remove('flex');
                    modal.classList.add('hidden');
                }
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const feedContainer = document.getElementById('instagram-api-feed-container');
            if (!feedContainer) return;

            // Function to handle image loading errors with fallback
            function handleImageError(img, postTitle) {
                // Try using a default UNJ image as fallback
                img.src = 'https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png';
                img.alt = `${postTitle} (Image unavailable)`;
                // Add overlay to indicate original image couldn't be loaded
                const parent = img.parentElement;
                const overlay = document.createElement('div');
                overlay.className = 'absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center';
                overlay.innerHTML = '<p class="text-white text-center px-4">Original image unavailable</p>';
                parent.appendChild(overlay);
            }

            // Function to create Instagram card with error handling
            function createInstagramCard(post) {
                const postDate = new Date(post.posted_at);
                const formattedDate = postDate.toLocaleDateString('id-ID', {
                    day: 'numeric',
                    month: 'short',
                    year: 'numeric'
                });

                const card = document.createElement('div');
                card.className =
                    'media-card bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 group';

                // Create HTML structure with error handling for image
                card.innerHTML = `
            <div class="relative">
                <div class="relative pb-[56.25%] h-0 overflow-hidden">
                    <img src="${post.media_url}" alt="${post.title}" 
                         class="absolute top-0 left-0 w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                         onerror="this.onerror=null; handleImageError(this, '${post.title.replace(/'/g, "\\'")}');">
                </div>
                <div class="absolute bottom-0 left-0 w-full bg-gradient-to-t from-black to-transparent h-16 opacity-70"></div>
            </div>
            <div class="p-6">
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center text-gray-500 text-sm">
                        <i class="fab fa-instagram mr-2"></i>
                        <span>@dit.isipunj</span>
                    </div>
                    <div class="text-gray-500 text-sm">
                        <i class="fas fa-calendar-alt mr-1"></i>${formattedDate}
                    </div>
                </div>
                <h3 class="font-bold text-teal-800 text-xl mb-2 group-hover:text-yellow-500 transition-colors">
                    ${post.title || 'Instagram Post'}
                </h3>
                <p class="text-gray-600 mb-4 news-excerpt">
                    ${post.caption ? (post.caption.length > 150 ? post.caption.substring(0, 150) + '...' : post.caption) : ''}
                </p>
                <a href="${post.permalink}" target="_blank" class="inline-flex items-center text-teal-600 hover:text-yellow-500 transition-colors">
                    <span>View on Instagram</span>
                    <i class="fas fa-external-link-alt ml-2 text-sm"></i>
                </a>
            </div>
        `;

                return card;
            }

            // Define handleImageError function in global scope
            window.handleImageError = handleImageError;

            // Fetch Instagram posts with error handling
            fetch('/api/instagram-posts')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(posts => {
                    // Clear loading placeholders
                    feedContainer.innerHTML = '';

                    if (posts.length === 0) {
                        feedContainer.innerHTML = `
                    <div class="col-span-3 text-center py-8">
                        <p class="text-gray-500">No Instagram posts available at this time.</p>
                    </div>
                `;
                        return;
                    }

                    // Create and append cards for each post
                    posts.forEach(post => {
                        if (post && post.media_url) {
                            const card = createInstagramCard(post);
                            feedContainer.appendChild(card);
                        }
                    });
                })
                .catch(error => {
                    console.error('Error fetching Instagram posts:', error);
                    feedContainer.innerHTML = `
                <div class="col-span-3 text-center py-8">
                    <p class="text-gray-500">Unable to load Instagram posts. Please try again later.</p>
                </div>
            `;
                });
        });
    </script>
    <script>
        window.carouselImages = [
            "{{ asset('images/logos/image_corousel.jpg') }}",
            "/images/TERBUK TAMPAK DEPAN.png",
            "/images/GEDUNG REKTORAT.png",
            "/images/om.png",
        ];
    </script>

</html>
