<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Universitas Negeri Jakarta - Direktorat Pemeringkatan</title>
    <link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" type="image/png">
    
    {{-- Tailwind CSS --}}
    <script src="https://cdn.tailwindcss.com"></script>
    
    {{-- Font Awesome --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet" />

    {{-- Swiper JS for Carousel --}}
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

    {{-- Consolidated and Responsive CSS --}}
    <style>
        /* Global Font */
        * {
            font-family: 'Inter', Arial, sans-serif !important;
        }
        
        /* Preserve Font Awesome icons */
        .fas, .fab, .far, .fa, [class^="fa-"], [class*=" fa-"], i.fas, i.fab, i.far, i.fa {
            font-family: "Font Awesome 5 Free", "Font Awesome 5 Brands", "FontAwesome" !important;
        }
        
        /* CRITICAL: Prevent navbar conflicts */
        body {
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }
        
        /* Mobile spacing fix - account for fixed navbar */
        @media (max-width: 767px) {
            body {
                padding-top: 0 !important; /* Let navbar script handle this */
            }
            
            .mobile-content-spacer {
                height: 70px; /* Account for mobile navbar height */
                width: 100%;
                display: block;
            }
        }
        
        @media (min-width: 768px) {
            .mobile-content-spacer {
                display: none;
            }
        }
        
        /* Header styling improvements */
        .hero-header {
            position: relative;
            min-height: 50vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        @media (min-width: 768px) {
            .hero-header {
                min-height: 60vh;
            }
        }
        
        @media (min-width: 1024px) {
            .hero-header {
                min-height: 100vh;
            }
        }

        /* Navbar scroll effect for desktop */
        .navbar.scrolled {
            background-color: rgba(23, 99, 105, 0.9) !important;
            backdrop-filter: blur(10px);
            padding-top: 0.5rem;
            padding-bottom: 0.5rem;
        }
        
        /* Swiper Carousel Customization */
        .program-carousel-container .swiper-button-next,
        .program-carousel-container .swiper-button-prev,
        .news-carousel-container .swiper-button-next,
        .news-carousel-container .swiper-button-prev {
            color: #14B8A6;
            background-color: white;
            border-radius: 50%;
            width: 44px;
            height: 44px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            z-index: 10;
        }
        
        .program-carousel-container .swiper-button-next::after,
        .program-carousel-container .swiper-button-prev::after,
        .news-carousel-container .swiper-button-next::after,
        .news-carousel-container .swiper-button-prev::after {
            font-size: 18px;
            font-weight: bold;
        }
        
        .program-carousel-container .swiper-pagination-bullet-active,
        .news-carousel-container .swiper-pagination-bullet-active {
            background-color: #14B8A6;
        }

        /* Carousel container improvements */
        .program-carousel-container,
        .news-carousel-container {
            position: relative;
            overflow: hidden;
            padding: 0 60px;
            margin: 0 auto;
        }

        .program-carousel,
        .news-carousel {
            overflow: hidden !important;
            position: relative;
            width: 100%;
        }

        /* Navigation positioning */
        .program-carousel-container .swiper-button-prev,
        .news-carousel-container .swiper-button-prev {
            left: 10px !important;
        }

        .program-carousel-container .swiper-button-next,
        .news-carousel-container .swiper-button-next {
            right: 10px !important;
        }

        /* Mobile carousel adjustments */
        @media (max-width: 767px) {
            .program-carousel-container,
            .news-carousel-container {
                padding: 0 20px;
            }
            
            .program-carousel-container .swiper-button-next,
            .program-carousel-container .swiper-button-prev,
            .news-carousel-container .swiper-button-next,
            .news-carousel-container .swiper-button-prev {
                display: none;
            }
        }

        /* Header Carousel Styles */
        .header-carousel {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 1;
        }
        
        .header-carousel-slides {
            width: 100%;
            height: 100%;
        }
        
        .header-slide {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            transition: opacity 1.5s ease-in-out;
        }
        
        .header-slide.active {
            opacity: 1;
        }
        
        .header-slide img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .header-carousel-dots {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 12px;
            z-index: 10;
        }
        
        .header-carousel-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.5);
            cursor: pointer;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }
        
        .header-carousel-dot.active {
            background-color: #FBBF24;
            transform: scale(1.1);
            border-color: white;
        }

        /* Card styling improvements */
        .media-card, .program-card {
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .media-card .p-6, .program-card .p-6 {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .media-card .mt-4, .program-card .mt-4 {
            margin-top: auto;
        }

        /* Enhanced responsive grid */
        .responsive-grid {
            display: grid;
            gap: 2rem;
            grid-template-columns: 1fr;
        }

        @media (min-width: 640px) {
            .responsive-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (min-width: 1024px) {
            .responsive-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        /* News and program section spacing */
        .content-section {
            padding: 4rem 0;
        }

        @media (max-width: 767px) {
            .content-section {
                padding: 2rem 0;
            }
        }

        /* Hyperlink styling */
        .news-excerpt a {
            color: #0D9488;
            text-decoration: underline;
            transition: color 0.2s ease;
        }

        .news-excerpt a:hover {
            color: #F59E0B;
        }

        /* Marquee styling */
        .news-marquee a {
            color: #facc15;
            text-decoration: underline;
        }

        .news-marquee * {
            color: white;
        }

        .news-marquee .text-yellow-400 {
            color: #facc15 !important;
        }
    </style>
</head>

<body class="font-sans bg-gray-50">
    {{-- Include the fixed responsive navbar --}}
    @include('layout.navbarhilirisasi')

    {{-- Mobile content spacer --}}
    <div class="mobile-content-spacer md:hidden"></div>

    {{-- Desktop content spacer --}}
    <div class="hidden md:block h-16"></div>

    <header class="relative h-[50vh] md:h-[60vh] lg:h-screen bg-gray-800">
        {{-- The carousel will be injected here by JavaScript --}}
        <div class="absolute inset-0 bg-teal-900/60 flex flex-col justify-center items-start p-6 md:p-12 z-[5]">
        </div>
    </header>

    {{-- Announcement Marquee --}}
    <div class="bg-gradient-to-r from-teal-700 to-teal-800 py-3 shadow-lg">
        <div class="container mx-auto px-4">
            <div class="flex items-center space-x-4">
                <div class="bg-yellow-400 p-2 rounded-full flex-shrink-0">
                    <i class="fas fa-bullhorn text-teal-800 text-lg"></i>
                </div>
                <marquee class="news-marquee flex-1 text-white font-medium text-sm md:text-base" behavior="scroll" direction="left">
                    @if (isset($announcements) && count($announcements) > 0)
                        {!! $announcements[0]->icon !!} <span class="text-yellow-300 font-bold">{{ $announcements[0]->judul_pengumuman }}:</span>
                        {{ strip_tags($announcements[0]->isi_pengumuman) }}
                    @else
                        <span class="text-yellow-300 font-bold">Selamat datang di website DITISIP UNJ.</span>
                    @endif
                </marquee>
            </div>
        </div>
    </div>

    {{-- Main Content --}}
    <main class="container mx-auto content-section px-4 md:px-6">
        {{-- Latest News Section --}}
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-teal-800">Berita Terbaru</h2>
            <p class="text-gray-600 mt-2">Informasi terkini dari Universitas Negeri Jakarta</p>
        </div>

        <div class="responsive-grid mb-16">
            @if ($regularNews && $regularNews->count() > 0)
                @foreach ($regularNews as $news)
                    <div class="media-card bg-white rounded-lg overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                        <div class="relative">
                            <img alt="{{ $news->judul }}" class="w-full h-56 object-cover" src="{{ asset('storage/' . $news->gambar) }}" />
                            <div class="absolute top-3 right-3 bg-yellow-400 text-teal-800 px-3 py-1 rounded-full text-xs font-semibold">
                                {{ ucfirst($news->kategori) }}
                            </div>
                        </div>
                        <div class="p-6 flex flex-col flex-grow">
                            <div class="flex items-center justify-between mb-3 text-gray-500 text-sm">
                                <span><i class="fas fa-user-circle mr-2"></i>Admin</span>
                                <span><i class="fas fa-calendar-alt mr-1"></i>{{ date('d M Y', strtotime($news->tanggal)) }}</span>
                            </div>
                            <a href="{{ route('Berita.show', ['slug' => $news->slug]) }}" class="block">
                                <h3 class="font-bold text-lg mb-3 text-teal-800 hover:text-yellow-600 transition-colors min-h-[3.5rem]">
                                    {{ Str::limit($news->judul, 60) }}
                                </h3>
                            </a>
                            <div class="news-excerpt text-gray-600 mb-4 text-sm flex-grow">
                                {!! Str::limit(strip_tags($news->isi), 100) !!}
                            </div>
                            <a href="{{ route('Berita.show', ['slug' => $news->slug]) }}" class="mt-4 inline-block text-teal-700 hover:text-yellow-500 font-medium text-sm">
                                Baca selengkapnya <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            @else
                <p class="col-span-full text-center text-gray-500 py-8">Tidak ada berita untuk ditampilkan.</p>
            @endif
        </div>

        {{-- Featured News Carousel Section --}}
        @if (isset($featuredNews) && $featuredNews->count() > 0)
        <section class="content-section">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-teal-800">Berita Unggulan</h2>
                <p class="text-gray-600 mt-2">Sorotan berita pilihan dari kami</p>
            </div>

            <div class="news-carousel-container">
                <div class="swiper-container news-carousel">
                    <div class="swiper-wrapper">
                        @foreach ($featuredNews as $news)
                            <div class="swiper-slide">
                                <div class="media-card bg-white rounded-lg overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 h-full">
                                    <div class="relative">
                                        <img alt="{{ $news->judul }}" class="w-full h-56 object-cover" src="{{ asset('storage/' . $news->gambar) }}" />
                                        <div class="absolute top-3 right-3 bg-yellow-400 text-teal-800 px-3 py-1 rounded-full text-xs font-semibold">
                                            {{ ucfirst($news->kategori) }}
                                        </div>
                                    </div>
                                    <div class="p-6 flex flex-col flex-grow">
                                        <div class="flex items-center justify-between mb-3 text-gray-500 text-sm">
                                            <span><i class="fas fa-user-circle mr-2"></i>Admin</span>
                                            <span><i class="fas fa-calendar-alt mr-1"></i>{{ date('d M Y', strtotime($news->tanggal)) }}</span>
                                        </div>
                                        <a href="{{ route('Berita.show', ['slug' => $news->slug]) }}" class="block">
                                            <h3 class="font-bold text-lg mb-3 text-teal-800 hover:text-yellow-600 transition-colors min-h-[3.5rem]">
                                                {{ Str::limit($news->judul, 60) }}
                                            </h3>
                                        </a>
                                        <div class="news-excerpt text-gray-600 mb-4 text-sm flex-grow">
                                            {!! Str::limit(strip_tags($news->isi), 100) !!}
                                        </div>
                                        <a href="{{ route('Berita.show', ['slug' => $news->slug]) }}" class="mt-auto inline-block text-teal-700 hover:text-yellow-500 font-medium text-sm">
                                            Baca selengkapnya <i class="fas fa-arrow-right ml-1"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-pagination mt-8"></div>
            </div>
        </section>
        @endif
    </main>

    {{-- Programs & Services Section --}}
    <section class="content-section bg-gray-100">
        <div class="container mx-auto px-4 md:px-6">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-teal-800">Program & Layanan</h2>
                <p class="text-gray-600 mt-2 max-w-2xl mx-auto">Program dan Layanan Direktorat Inovasi, Sistem Informasi dan Pemeringkatan</p>
            </div>

            {{-- First 3 programs in regular grid --}}
            <div class="responsive-grid mb-12">
                @forelse($programLayanan->take(3) as $program)
                    <div class="program-card bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300">
                        <div class="relative h-48 bg-teal-600 flex items-center justify-center">
                            @if ($program->image)
                                <img src="{{ asset('storage/' . $program->image) }}" alt="{{ $program->judul }}" class="w-full h-full object-cover">
                            @else
                                <i class="{{ $program->icon ?? 'fas fa-cogs' }} text-5xl text-white"></i>
                            @endif
                        </div>
                        <div class="p-6 flex flex-col flex-grow">
                            <h3 class="font-bold text-teal-800 text-xl mb-3">{{ $program->judul }}</h3>
                            <div class="text-gray-600 mb-4 text-sm flex-grow min-h-[80px] flex items-start">
                                <p>{!! Str::limit(strip_tags($program->deskripsi), 120) !!}</p>
                            </div>
                            <div class="mt-auto pt-4 border-t border-gray-100">
                                @if (!empty($program->url))
                                    <a href="{{ $program->url }}" target="_blank" rel="noopener noreferrer" 
                                       class="block w-full text-center bg-teal-600 hover:bg-teal-700 text-white py-2.5 px-6 rounded-lg font-semibold text-sm transition-colors">
                                        Akses Program
                                    </a>
                                @else
                                    <button type="button" class="login w-full text-center bg-teal-600 hover:bg-teal-700 text-white py-2.5 px-6 rounded-lg font-semibold text-sm transition-colors" data-bs-toggle="modal" data-bs-target="#loginModal">
                                        Akses Program
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="col-span-full text-center text-gray-500 py-8">Belum ada program layanan yang tersedia.</p>
                @endforelse
            </div>

            {{-- Additional programs in carousel --}}
            @if (count($programLayanan) > 3)
            <div class="program-carousel-container">
                <div class="swiper-container program-carousel">
                    <div class="swiper-wrapper">
                        @foreach ($programLayanan->skip(3) as $program)
                            <div class="swiper-slide">
                                <div class="program-card bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 h-full">
                                    <div class="relative h-48 bg-teal-600 flex items-center justify-center">
                                        @if ($program->image)
                                            <img src="{{ asset('storage/' . $program->image) }}" alt="{{ $program->judul }}" class="w-full h-full object-cover">
                                        @else
                                            <i class="{{ $program->icon ?? 'fas fa-cogs' }} text-5xl text-white"></i>
                                        @endif
                                    </div>
                                    <div class="p-6 flex flex-col flex-grow">
                                        <h3 class="font-bold text-teal-800 text-xl mb-3">{{ $program->judul }}</h3>
                                        <div class="text-gray-600 mb-4 text-sm flex-grow min-h-[80px] flex items-start">
                                            <p>{!! Str::limit(strip_tags($program->deskripsi), 120) !!}</p>
                                        </div>
                                        <div class="mt-auto pt-4 border-t border-gray-100">
                                            @if (!empty($program->url))
                                                <a href="{{ $program->url }}" target="_blank" rel="noopener noreferrer" 
                                                   class="block w-full text-center bg-teal-600 hover:bg-teal-700 text-white py-2.5 px-6 rounded-lg font-semibold text-sm transition-colors">
                                                    Akses Program
                                                </a>
                                            @else
                                                <button type="button" class="login w-full text-center bg-teal-600 hover:bg-teal-700 text-white py-2.5 px-6 rounded-lg font-semibold text-sm transition-colors" data-bs-toggle="modal" data-bs-target="#loginModal">
                                                    Akses Program
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-pagination mt-8"></div>
            </div>
            @endif
        </div>
    </section>
    
    {{-- UNJ in Numbers Section --}}
    <section class="content-section bg-slate-100">
        <div class="container mx-auto px-4 md:px-6">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-slate-800">UNJ dalam <span class="text-emerald-600">Prestasi</span></h2>
                <div class="mt-4 h-1 w-24 bg-emerald-600 mx-auto rounded-full"></div>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4 md:gap-6">
                <div class="prestasi-card bg-white rounded-lg p-6 flex flex-col items-center text-center transition-all duration-300 hover:shadow-xl hover:border-emerald-500 hover:-translate-y-1 border">
                    <div class="text-emerald-500 text-4xl mb-3"><i class="fa fa-user-graduate"></i></div>
                    <div class="text-3xl font-bold text-slate-700">30.673</div>
                    <div class="text-sm text-slate-500 font-medium">Mahasiswa</div>
                </div>
                <div class="bg-white rounded-lg p-4 md:p-6 flex flex-col items-center text-center transition-all duration-300 hover:shadow-xl hover:border-sky-500 hover:-translate-y-1 border">
                    <div class="text-sky-500 text-3xl md:text-4xl mb-3"><i class="fa fa-globe"></i></div>
                    <div class="text-2xl md:text-3xl font-bold text-slate-700">125</div>
                    <div class="text-xs md:text-sm text-slate-500 font-medium">Mhs. Internasional</div>
                </div>
                <div class="bg-white rounded-lg p-4 md:p-6 flex flex-col items-center text-center transition-all duration-300 hover:shadow-xl hover:border-purple-500 hover:-translate-y-1 border">
                    <div class="text-purple-500 text-3xl md:text-4xl mb-3"><i class="fa fa-chalkboard-teacher"></i></div>
                    <div class="text-2xl md:text-3xl font-bold text-slate-700">131</div>
                    <div class="text-xs md:text-sm text-slate-500 font-medium">Guru Besar</div>
                </div>
                <div class="bg-white rounded-lg p-4 md:p-6 flex flex-col items-center text-center transition-all duration-300 hover:shadow-xl hover:border-indigo-500 hover:-translate-y-1 border">
                    <div class="text-indigo-500 text-3xl md:text-4xl mb-3"><i class="fa fa-user-tie"></i></div>
                    <div class="text-2xl md:text-3xl font-bold text-slate-700">1.132</div>
                    <div class="text-xs md:text-sm text-slate-500 font-medium">Dosen</div>
                </div>
                <div class="bg-white rounded-lg p-4 md:p-6 flex flex-col items-center text-center transition-all duration-300 hover:shadow-xl hover:border-orange-500 hover:-translate-y-1 border">
                    <div class="text-orange-500 text-3xl md:text-4xl mb-3"><i class="fa fa-book"></i></div>
                    <div class="text-2xl md:text-3xl font-bold text-slate-700">3.681</div>
                    <div class="text-xs md:text-sm text-slate-500 font-medium">Terindeks Scopus</div>
                </div>
                <div class="bg-white rounded-lg p-4 md:p-6 flex flex-col items-center text-center transition-all duration-300 hover:shadow-xl hover:border-pink-500 hover:-translate-y-1 border">
                    <div class="text-pink-500 text-3xl md:text-4xl mb-3"><i class="fa fa-th-large"></i></div>
                    <div class="text-2xl md:text-3xl font-bold text-slate-700">116</div>
                    <div class="text-xs md:text-sm text-slate-500 font-medium">Program Studi</div>
                </div>
            </div>
        </div>
    </section>

    {{-- Social Media Feeds Section --}}
    <section class="content-section">
        <div class="container mx-auto px-4 md:px-6">
            {{-- Instagram Feed --}}
            <div class="mb-16">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-teal-800">Instagram DITSIP UNJ</h2>
                    <p class="text-gray-600 mt-2">Ikuti kami di <a href="https://www.instagram.com/dit.isipunj/" target="_blank" class="text-teal-600 hover:text-yellow-500 font-semibold">@dit.isipunj</a> untuk info terbaru.</p>
                </div>
                <div id="instagram-api-feed-container" class="responsive-grid">
                    {{-- Placeholders for Instagram feed --}}
                    @for ($i = 0; $i < 3; $i++)
                        <div class="bg-gray-200 rounded-lg h-80 animate-pulse flex items-center justify-center">
                            <i class="fab fa-instagram text-4xl text-gray-400"></i>
                        </div>
                    @endfor
                </div>
            </div>

            {{-- YouTube Feed --}}
            <div>
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-teal-800">Galeri Video</h2>
                    <p class="text-gray-600 mt-2">Tonton video terbaru dari kanal YouTube kami.</p>
                </div>
                <div id="dynamic-videos-container" class="responsive-grid">
                    {{-- Placeholders for YouTube videos --}}
                    @for ($i = 0; $i < 3; $i++)
                        <div class="bg-gray-200 rounded-lg h-80 animate-pulse flex items-center justify-center">
                            <i class="fab fa-youtube text-4xl text-gray-400"></i>
                        </div>
                    @endfor
                </div>
            </div>
        </div>
    </section>

    {{-- Include the responsive footer --}}
    @include('layout.footer')

    {{-- Fixed and Improved JavaScript --}}
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        console.log('Landing page script initialized');

        // --- NAVBAR COMPATIBILITY CHECK ---
        // Wait for navbar script to load, then initialize landing page features
        const initLandingPage = () => {
            console.log('Initializing landing page features');

            // --- DESKTOP NAVBAR SCROLL EFFECT ---
            const desktopNavbar = document.querySelector('.navbar.hidden.md\\:block');
            if (desktopNavbar) {
                let ticking = false;
                
                const updateNavbar = () => {
                    if (window.scrollY > 50) {
                        desktopNavbar.classList.add('scrolled');
                    } else {
                        desktopNavbar.classList.remove('scrolled');
                    }
                    ticking = false;
                };

                window.addEventListener('scroll', () => {
                    if (!ticking) {
                        requestAnimationFrame(updateNavbar);
                        ticking = true;
                    }
                }, { passive: true });
            }

            // --- SWIPER CAROUSEL INITIALIZATION ---
            // Initialize Program Carousel
            const programCarouselElement = document.querySelector('.program-carousel');
            if (programCarouselElement) {
                try {
                    const programSwiper = new Swiper('.program-carousel', {
                        loop: true,
                        autoplay: {
                            delay: 4000,
                            disableOnInteraction: false,
                            pauseOnMouseEnter: true,
                        },
                        pagination: {
                            el: '.program-carousel-container .swiper-pagination',
                            clickable: true,
                            dynamicBullets: true,
                        },
                        navigation: {
                            nextEl: '.program-carousel-container .swiper-button-next',
                            prevEl: '.program-carousel-container .swiper-button-prev',
                        },
                        breakpoints: {
                            320: {
                                slidesPerView: 1,
                                spaceBetween: 16,
                            },
                            768: {
                                slidesPerView: 2,
                                spaceBetween: 20,
                            },
                            1024: {
                                slidesPerView: 3,
                                spaceBetween: 24,
                            },
                        },
                        observer: true,
                        observeParents: true,
                        watchOverflow: true,
                    });
                    console.log('Program carousel initialized successfully');
                } catch (error) {
                    console.error('Error initializing program carousel:', error);
                }
            }

            // Initialize News Carousel
            const newsCarouselElement = document.querySelector('.news-carousel');
            if (newsCarouselElement) {
                try {
                    const newsSwiper = new Swiper('.news-carousel', {
                        loop: true,
                        autoplay: {
                            delay: 5000,
                            disableOnInteraction: false,
                            pauseOnMouseEnter: true,
                        },
                        pagination: {
                            el: '.news-carousel-container .swiper-pagination',
                            clickable: true,
                            dynamicBullets: true,
                        },
                        navigation: {
                            nextEl: '.news-carousel-container .swiper-button-next',
                            prevEl: '.news-carousel-container .swiper-button-prev',
                        },
                        breakpoints: {
                            320: {
                                slidesPerView: 1,
                                spaceBetween: 16,
                            },
                            768: {
                                slidesPerView: 2,
                                spaceBetween: 20,
                            },
                            1024: {
                                slidesPerView: 3,
                                spaceBetween: 24,
                            },
                        },
                        observer: true,
                        observeParents: true,
                        watchOverflow: true,
                    });
                    console.log('News carousel initialized successfully');
                } catch (error) {
                    console.error('Error initializing news carousel:', error);
                }
            }

            // --- SOCIAL MEDIA FEEDS ---
            initializeInstagramFeed();
            initializeYouTubeFeed();
            initializeHeaderCarousel();
        };

        // Small delay to ensure navbar script has loaded
        setTimeout(initLandingPage, 100);

        // --- INSTAGRAM FEED FUNCTION ---
        function initializeInstagramFeed() {
            const instaContainer = document.getElementById('instagram-api-feed-container');
            if (!instaContainer) return;

            fetch('/api/instagram-posts')
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.json();
                })
                .then(posts => {
                    instaContainer.innerHTML = '';
                    
                    if (!posts || posts.length === 0) {
                        instaContainer.innerHTML = `
                            <div class="col-span-full text-center py-12">
                                <i class="fab fa-instagram text-6xl text-gray-300 mb-4"></i>
                                <p class="text-gray-500">Belum ada post Instagram yang tersedia.</p>
                            </div>`;
                        return;
                    }

                    posts.slice(0, 3).forEach(post => {
                        const postDate = new Date(post.posted_at).toLocaleDateString('id-ID', { 
                            day: 'numeric', 
                            month: 'short', 
                            year: 'numeric' 
                        });
                        
                        const card = `
                            <a href="${post.permalink}" target="_blank" rel="noopener noreferrer" 
                               class="group block bg-white rounded-lg overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                                <div class="relative">
                                    <img src="${post.media_url}" alt="${post.title || 'Instagram Post'}" 
                                         class="w-full h-64 object-cover transition-transform duration-300 group-hover:scale-105">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                                    <div class="absolute bottom-0 left-0 p-4 text-white">
                                        <h3 class="font-bold text-lg leading-tight">${post.title || 'Postingan Instagram'}</h3>
                                        <p class="text-sm opacity-90 mt-1">${postDate}</p>
                                    </div>
                                    <div class="absolute top-3 right-3">
                                        <i class="fab fa-instagram text-white text-xl opacity-80"></i>
                                    </div>
                                </div>
                            </a>`;
                        instaContainer.innerHTML += card;
                    });
                })
                .catch(error => {
                    console.error('Error fetching Instagram posts:', error);
                    instaContainer.innerHTML = `
                        <div class="col-span-full text-center py-12">
                            <i class="fas fa-exclamation-triangle text-4xl text-red-400 mb-4"></i>
                            <p class="text-gray-500">Gagal memuat post Instagram.</p>
                        </div>`;
                });
        }

        // --- YOUTUBE FEED FUNCTION ---
        function initializeYouTubeFeed() {
            const videoContainer = document.getElementById('dynamic-videos-container');
            if (!videoContainer) return;

            fetch('/api/youtube-videos')
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.json();
                })
                .then(videos => {
                    videoContainer.innerHTML = '';
                    
                    if (!videos || videos.length === 0) {
                        videoContainer.innerHTML = `
                            <div class="col-span-full text-center py-12">
                                <i class="fab fa-youtube text-6xl text-gray-300 mb-4"></i>
                                <p class="text-gray-500">Belum ada video yang tersedia.</p>
                            </div>`;
                        return;
                    }

                    videos.slice(0, 3).forEach(video => {
                        let videoId = '';
                        try {
                            if (video.link.includes('youtu.be/')) {
                                videoId = new URL(video.link).pathname.substring(1);
                            } else {
                                videoId = new URL(video.link).searchParams.get('v');
                            }
                        } catch (e) {
                            console.error('Invalid YouTube URL:', video.link);
                            return;
                        }
                        
                        if (!videoId) return;

                        const thumbnailUrl = `https://img.youtube.com/vi/${videoId}/hqdefault.jpg`;

                        const card = `
                            <a href="${video.link}" target="_blank" rel="noopener noreferrer"
                               class="group block bg-white rounded-lg overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                                <div class="relative">
                                    <img src="${thumbnailUrl}" alt="${video.judul}" 
                                         class="w-full h-48 object-cover transition-transform duration-300 group-hover:scale-105">
                                    <div class="absolute inset-0 bg-black/40 flex items-center justify-center">
                                        <i class="fab fa-youtube text-white text-5xl opacity-80 group-hover:opacity-100 group-hover:scale-110 transition-all duration-300"></i>
                                    </div>
                                </div>
                                <div class="p-4">
                                    <h3 class="font-bold text-gray-800 group-hover:text-teal-600 transition-colors line-clamp-2">
                                        ${video.judul}
                                    </h3>
                                </div>
                            </a>`;
                        videoContainer.innerHTML += card;
                    });
                })
                .catch(error => {
                    console.error('Error fetching YouTube videos:', error);
                    videoContainer.innerHTML = `
                        <div class="col-span-full text-center py-12">
                            <i class="fas fa-exclamation-triangle text-4xl text-red-400 mb-4"></i>
                            <p class="text-gray-500">Gagal memuat video YouTube.</p>
                        </div>`;
                });
        }

        // --- HEADER CAROUSEL FUNCTION ---
        function initializeHeaderCarousel() {
            const defaultImages = [
                "https://media.quipper.com/media/W1siZiIsIjIwMTgvMDEvMjMvMDkvNDMvMjcvYWVjNTQ1OTctOTJiNi00Y2EyLWEzZDctMGZiNTg1ZTU1MDEzLyJdLFsicCIsInRodW1iIiwiMTIwMHhcdTAwM2UiLHt9XSxbInAiLCJjb252ZXJ0IiwiLWNvbG9yc3BhY2Ugc1JHQiAtc3RyaXAiLHsiZm9ybWF0IjoianBnIn1dXQ?sha=9c61a35270604434",
                "https://www.unj.ac.id/wp-content/uploads/2020/02/DJI_0007-1024x576.jpg",
                "https://cdns.klimg.com/merdeka.com/i/w/news/2023/07/20/1578964/670x335/potret-gedung-baru-unj-yang-megah-dan-modern-berkonsep-green-building-dan-smart-building.jpg"
            ];

            // Fetch carousel images from API
            fetch("/api/carousel-images")
                .then(response => {
                    if (!response.ok) throw new Error('API response not OK');
                    return response.json();
                })
                .then(data => {
                    const galleryImages = data.map(item => "/storage/" + item.image);
                    if (galleryImages.length > 0) {
                        createHeaderCarousel(galleryImages);
                    } else {
                        createHeaderCarousel(defaultImages);
                    }
                })
                .catch(error => {
                    console.error("Error fetching carousel images, using defaults:", error);
                    createHeaderCarousel(defaultImages);
                });
        }

        function createHeaderCarousel(images) {
            const header = document.querySelector("header.hero-header");
            if (!header || header.querySelector(".header-carousel") || images.length === 0) return;

            const carouselContainer = document.createElement("div");
            carouselContainer.className = "header-carousel";

            const slidesContainer = document.createElement("div");
            slidesContainer.className = "header-carousel-slides";

            images.forEach((imgSrc, index) => {
                const slide = document.createElement("div");
                slide.className = `header-slide ${index === 0 ? "active" : ""}`;
                
                const img = document.createElement("img");
                img.src = imgSrc;
                img.alt = `UNJ Campus View ${index + 1}`;
                img.loading = index === 0 ? "eager" : "lazy";
                
                slide.appendChild(img);
                slidesContainer.appendChild(slide);
            });

            // Only create dots if there are multiple images
            let dotsContainer = null;
            if (images.length > 1) {
                dotsContainer = document.createElement("div");
                dotsContainer.className = "header-carousel-dots";
                
                images.forEach((_, index) => {
                    const dot = document.createElement("span");
                    dot.className = `header-carousel-dot ${index === 0 ? "active" : ""}`;
                    dot.dataset.index = index;
                    dot.setAttribute('role', 'button');
                    dot.setAttribute('aria-label', `Go to slide ${index + 1}`);
                    dotsContainer.appendChild(dot);
                });
            }

            carouselContainer.appendChild(slidesContainer);
            if (dotsContainer) {
                carouselContainer.appendChild(dotsContainer);
            }

            // Insert carousel before the overlay
            const overlay = header.querySelector(".absolute.inset-0");
            if (overlay) {
                header.insertBefore(carouselContainer, overlay);
            } else {
                header.appendChild(carouselContainer);
            }

            // Initialize carousel functionality only if multiple images
            if (images.length > 1) {
                let currentSlide = 0;
                const totalSlides = images.length;
                let autoplayInterval;

                function showSlide(index) {
                    currentSlide = (index + totalSlides) % totalSlides;
                    
                    slidesContainer.querySelectorAll(".header-slide").forEach((slide, i) => {
                        slide.classList.toggle("active", i === currentSlide);
                    });
                    
                    if (dotsContainer) {
                        dotsContainer.querySelectorAll(".header-carousel-dot").forEach((dot, i) => {
                            dot.classList.toggle("active", i === currentSlide);
                        });
                    }
                }

                function nextSlide() {
                    showSlide(currentSlide + 1);
                }

                function resetAutoplay() {
                    if (autoplayInterval) clearInterval(autoplayInterval);
                    autoplayInterval = setInterval(nextSlide, 6000);
                }

                // Dot click handler
                if (dotsContainer) {
                    dotsContainer.addEventListener("click", (e) => {
                        if (e.target.matches(".header-carousel-dot")) {
                            showSlide(parseInt(e.target.dataset.index));
                            resetAutoplay();
                        }
                    });
                }

                // Pause autoplay on hover
                carouselContainer.addEventListener('mouseenter', () => {
                    if (autoplayInterval) clearInterval(autoplayInterval);
                });

                carouselContainer.addEventListener('mouseleave', resetAutoplay);

                // Start autoplay
                resetAutoplay();

                console.log('Header carousel initialized with', images.length, 'images');
            }
        }

        // --- RESPONSIVE UTILITIES ---
        const handlePageResize = () => {
            // Ensure proper spacing on resize
            const mobileNavbar = document.getElementById('mobile-navbar');
            if (mobileNavbar && window.innerWidth < 768) {
                document.body.style.paddingTop = mobileNavbar.offsetHeight + 'px';
            } else if (window.innerWidth >= 768) {
                document.body.style.paddingTop = '0';
            }
        };

        window.addEventListener('resize', handlePageResize);
        handlePageResize(); // Initial call

        // --- INTERSECTION OBSERVER FOR ANIMATIONS ---
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-fade-in-up');
                }
            });
        }, observerOptions);

        // Observe sections for scroll animations
        document.querySelectorAll('.content-section').forEach(section => {
            observer.observe(section);
        });

        // --- ERROR HANDLING ---
        window.addEventListener('error', function(e) {
            if (e.message.includes('Swiper') || e.message.includes('carousel')) {
                console.error('Carousel error:', e.message);
                // Try to reinitialize carousels after a delay
                setTimeout(() => {
                    if (typeof Swiper !== 'undefined') {
                        initLandingPage();
                    }
                }, 1000);
            }
        });

        // --- PERFORMANCE OPTIMIZATION ---
        // Lazy load images that are not immediately visible
        const lazyImages = document.querySelectorAll('img[loading="lazy"]');
        const imageObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.classList.add('opacity-0', 'transition-opacity', 'duration-300');
                    img.onload = () => img.classList.remove('opacity-0');
                    imageObserver.unobserve(img);
                }
            });
        });

        lazyImages.forEach(img => imageObserver.observe(img));
    });

    // --- GLOBAL UTILITIES ---
    // Utility function to refresh carousels (can be called externally)
    window.refreshCarousels = function() {
        console.log('Refreshing carousels...');
        setTimeout(() => {
            document.querySelectorAll('.swiper-container').forEach(container => {
                if (container.swiper) {
                    container.swiper.update();
                }
            });
        }, 100);
    };

    // Utility to check if landing page is fully loaded
    window.isLandingPageReady = function() {
        const requiredElements = [
            document.querySelector('.hero-header'),
            document.querySelector('#instagram-api-feed-container'),
            document.querySelector('#dynamic-videos-container')
        ];
        return requiredElements.every(el => el !== null);
    };
    </script>

    {{-- Additional CSS for animations --}}
    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.6s ease-out forwards;
        }

        /* Improved mobile responsiveness */
        @media (max-width: 640px) {
            .hero-header .absolute h1 {
                font-size: 2rem;
                line-height: 2.5rem;
            }
            
            .hero-header .absolute p {
                font-size: 1rem;
                line-height: 1.5rem;
            }
            
            .hero-header .flex.flex-col.sm\\:flex-row {
                flex-direction: column;
            }
            
            .hero-header .flex.flex-col.sm\\:flex-row a {
                text-align: center;
                padding: 0.75rem 1.5rem;
            }
        }

        /* Line clamp utility for better text overflow handling */
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</body>
</html>