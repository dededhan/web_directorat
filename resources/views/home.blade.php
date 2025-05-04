<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>Universitas Negeri Jakarta - Direktorat Pemeringkatan</title>
    <link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" type="image/png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('home.css') }}">
    <link rel="stylesheet" href="{{ asset('header-carousel.css') }}">
    <script src="{{ asset('header-carousel.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('mobile.css') }}">
    
    <style>
        * {
            font-family: Arial, sans-serif !important;
        }

        /* main,
        section {
            max-width: 100%;
            overflow-x: hidden;
        }

        .container {
            max-width: 100%;
            overflow-x: hidden;
        } */

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
    @include('layout.navbar')

    <!-- Mobile detection indicator -->
    <div id="mobile-indicator" style="display: none;"></div>

    <!-- Header section with responsive classes -->
    <header class="relative h-screen md:h-screen">
        <img alt="Universitas Negeri Jakarta building with a sculpture in front" 
             class="w-full h-full object-cover"
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
                <marquee class="flex-1 text-white font-medium news-marquee" behavior="scroll" direction="left" scrollamount="5">
                    @if (isset($announcements) && count($announcements) > 0)
                        {{ $announcements[0]->icon }} <span class="text-yellow-400 font-bold">{{ $announcements[0]->judul_pengumuman }}</span>
                        {!! $announcements[0]->isi_pengumuman !!}
                    @else
                        <span class="text-yellow-400 font-bold">Belum ada pengumuman</span>
                    @endif
                </marquee>
            </div>
        </div>
    </div>

    <!-- Main content -->
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
            @php
                // Take the first 3 news items for the regular grid
                $regularNews = $featuredNews->take(3);
            @endphp

            @foreach ($regularNews as $news)
                <div
                    class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="relative">
                        <img alt="{{ $news->judul }}" class="w-full h-56 object-cover"
                            src="{{ asset('storage/' . $news->gambar) }}" />
                        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black to-transparent h-24">
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
                                <i class="fas fa-calendar-alt mr-1"></i>{{ date('d M Y', strtotime($news->tanggal)) }}
                            </div>
                        </div>
                        <a href="{{ route('Berita.show', ['slug' => $news->slug]) }}" class="block">
                            <h2 class="font-bold text-xl mb-3 text-teal-800 hover:text-yellow-600 transition-colors">
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
        </div>

        <!-- Enhanced Featured News Carousel with remaining news items -->
        <div class="enhanced-carousel">
            <div class="enhanced-carousel-title">Berita Terbaru</div>
            <div class="carousel">
                <div class="carousel-inner">
                    @php
                        // Skip the first 3 news items and use the rest for the carousel
                        $carouselNews = $featuredNews->slice(3);
                    @endphp
                    @foreach ($carouselNews as $featured)
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
                                        {!! Str::limit($featured->isi, 150) !!}
                                    </p>
                                    <a href="{{ route('Berita.show', ['slug' => $featured->slug]) }}"
                                        class="news-link">
                                        Baca selengkapnya <i class="fas fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
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
                <p class="text-gray-600 max-w-2xl mx-auto text-sm md:text-base">Program dan Layanan Direktorat Inovasi, Sistem Informasi dan Pemeringkatan</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
                @forelse($programLayanan as $program)
                    <div class="program-card bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300">
                        <div class="relative">
                            @if($program->image)
                                <img src="{{ asset('storage/' . $program->image) }}" alt="{{ $program->judul }}" class="w-full h-48 object-cover">
                            @else
                                <div class="w-full h-48 bg-teal-600 flex items-center justify-center">
                                    <i class="{{ $program->icon ?? 'fas fa-cogs' }} text-4xl md:text-5xl text-white"></i>
                                </div>
                            @endif
                        </div>
                        <div class="p-4 md:p-5">
                            <h3 class="font-bold text-teal-800 text-lg md:text-xl mb-3">{{ $program->judul }}</h3>
                            <div class="text-gray-600 mb-4 program-excerpt text-sm md:text-base" style="min-height: 60px;">
                                {!! Str::limit(strip_tags($program->deskripsi), 100) !!}
                            </div>
                            <a href="#" class="program-details-btn inline-flex items-center text-teal-700 hover:text-yellow-500 font-medium text-sm md:text-base"
                                data-program-id="{{ $program->id }}" 
                                data-title="{{ $program->judul }}"
                                data-full-description="{!! htmlspecialchars($program->deskripsi_lengkap ?? $program->deskripsi) !!}">
                                Selengkapnya <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                            
                            <div class="mt-4 pt-3 border-t border-gray-100">
                                <button type="button" class="login w-full text-center bg-gradient-to-r from-teal-600 to-teal-500 text-white py-2 md:py-3 px-4 md:px-6 rounded-lg font-semibold text-sm md:text-base">
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
        </div>
    </section>

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
                <p class="text-gray-600 max-w-2xl mx-auto text-sm md:text-base">Ikuti akun Instagram kami untuk mendapatkan informasi terbaru</p>
                <a href="https://www.instagram.com/dit.isipunj/" target="_blank"
                    class="inline-flex items-center text-teal-700 hover:text-yellow-500 mt-2 font-medium text-sm md:text-base">
                    <span>@dit.isipunj</span>
                    <i class="fas fa-external-link-alt ml-2"></i>
                </a>
            </div>

            <div id="instagram-api-feed-container" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 md:gap-8">
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
                <h2 class="text-2xl md:text-3xl font-bold text-teal-700 mb-2">Youtube Universitas Negeri Jakarta</h2>
                <div class="flex items-center justify-center mb-4">
                    <div class="h-1 w-16 bg-gray-300"></div>
                    <span class="text-red-500 text-xl md:text-2xl mx-3"><i class="fab fa-youtube"></i></span>
                    <div class="h-1 w-16 bg-gray-300"></div>
                </div>
                <p class="text-gray-600 max-w-2xl mx-auto text-sm md:text-base">Tonton video terbaru dari channel YouTube UNJ</p>
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
    <div id="programDetailsModal" class="fixed inset-0 bg-black bg-opacity-60 z-[1100] hidden items-center justify-center p-4 overflow-y-auto">
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

    @include('layout.footer')

    <!-- Load mobile.js with enhanced detection -->
    <script src="{{ asset('mobile.js') }}"></script>
    <script src="{{ asset('js/instagram-api-feed.js') }}"></script>
    <script src="{{ asset('home.js') }}"></script>

    <!-- Enhanced mobile detection and debugging -->
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
        // Mobile detection
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
                indicator.textContent = `${isMobileDevice() ? 'Mobile' : 'Desktop'}: ${window.innerWidth}x${window.innerHeight}`;
                
                window.addEventListener('resize', function() {
                    indicator.textContent = `${isMobileDevice() ? 'Mobile' : 'Desktop'}: ${window.innerWidth}x${window.innerHeight}`;
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
    document.addEventListener('DOMContentLoaded', function() {
        // Fetch carousel images from gallery

        fetch('/api/carousel-images')
            .then(response => response.json())
            .then(data => {
                // Create the carouselImages array with proper paths
                window.carouselImages = data.map(item => '/storage/' + item.image);

                // If no images are found, use default images
                if (window.carouselImages.length === 0) {
                    window.carouselImages = [
                        "{{ asset('images/logos/image_corousel.jpg') }}",
                    ];
                }
            })
            .catch(error => {
                console.error('Error fetching carousel images:', error);
                // Fallback to default images on error
                window.carouselImages = [
                    "{{ asset('images/logos/image_corousel.jpg') }}",
                ];
            });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
    // Improved mobile detection function
    function detectMobile() {
        // Check for mobile user agent
        const userAgent = navigator.userAgent.toLowerCase();
        const mobileKeywords = /android|webos|iphone|ipad|ipod|blackberry|iemobile|opera mini/i;
        const isMobileUA = mobileKeywords.test(userAgent);
        
        // Check viewport width
        const isMobileWidth = window.innerWidth < 768;
        
        // Check touch capability
        const hasTouch = 'ontouchstart' in window || navigator.maxTouchPoints > 0;
        
        // Combined detection
        const isMobile = (isMobileUA || isMobileWidth) && hasTouch;
        
        console.log('Mobile Detection:', {
            userAgent: userAgent,
            width: window.innerWidth,
            isMobileUA: isMobileUA, 
            isMobileWidth: isMobileWidth,
            hasTouch: hasTouch,
            isMobile: isMobile
        });
        
        return isMobile;
    }
    
    // Apply appropriate classes based on device
    function applyMobileClasses() {
        const isMobile = detectMobile();
        document.body.classList.toggle('is-mobile', isMobile);
        
        // Force correct display of navbar elements
        if (isMobile) {
            // Hide desktop navbar
            document.querySelectorAll('.navbar.hidden.md\\:block').forEach(el => {
                el.style.display = 'none';
            });
            
            // Show mobile navbar and sidebar
            document.querySelectorAll('.navbar.block.md\\:hidden, #mobile-sidebar, #sidebar-overlay').forEach(el => {
                el.style.display = 'block';
            });
            
            console.log('Mobile mode activated');
        } else {
            // Show desktop navbar
            document.querySelectorAll('.navbar.hidden.md\\:block').forEach(el => {
                el.style.display = 'block';
            });
            
            // Hide mobile elements
            document.querySelectorAll('.navbar.block.md\\:hidden').forEach(el => {
                el.style.display = 'none';
            });
            
            console.log('Desktop mode activated');
        }
    }
    
    // Run on page load
    applyMobileClasses();
    
    // Run on window resize
    window.addEventListener('resize', applyMobileClasses);
    
    // Optional debug indicator in corner of screen
    function addDebugIndicator() {
        const indicator = document.createElement('div');
        indicator.id = 'debug-mobile-indicator';
        indicator.style.cssText = `
            position: fixed;
            bottom: 10px;
            left: 10px;
            background: rgba(0,0,0,0.7);
            color: white;
            padding: 5px 10px;
            font-size: 12px;
            z-index: 9999;
            border-radius: 4px;
        `;
        
        const updateIndicator = () => {
            const isMobile = detectMobile();
            indicator.textContent = `${isMobile ? 'Mobile' : 'Desktop'}: ${window.innerWidth}x${window.innerHeight}`;
            indicator.style.background = isMobile ? 'rgba(76,175,80,0.9)' : 'rgba(255,87,34,0.9)';
        };
        
        document.body.appendChild(indicator);
        updateIndicator();
        
        window.addEventListener('resize', updateIndicator);
    }
    
    // Uncomment to add visual debugging (can be removed in production)
    // addDebugIndicator();
});
</script>
</body>
</html>