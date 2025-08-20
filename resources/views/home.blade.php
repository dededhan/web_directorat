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
        body, p, h1, h2, h3, h4, h5, h6, span, div, a, button, input, textarea, select, label {
            font-family: 'Inter', Arial, sans-serif !important;
        }
        
        /* Navbar scroll effect */
        .navbar.scrolled {
            background-color: rgba(23, 99, 105, 0.9) !important;
            backdrop-filter: blur(10px);
            padding-top: 0.5rem;
            padding-bottom: 0.5rem;
        }

        /* Prevent body scroll when sidebar is open */
        body.sidebar-open {
            overflow: hidden;
        }
        
        /* Swiper Carousel Customization */
        .program-carousel-container .swiper-button-next,
        .program-carousel-container .swiper-button-prev,
        .news-carousel-container .swiper-button-next,
        .news-carousel-container .swiper-button-prev {
            color: #14B8A6; /* teal-500 */
            background-color: white;
            border-radius: 9999px;
            width: 40px;
            height: 40px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -2px rgba(0, 0, 0, 0.1);
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
        
        /* --- FIX: Carousel Card Height --- */
        .swiper-slide {
            height: auto;
        }
        .swiper-slide > div {
            height: 100%;
        }

        /* Header Carousel Styles */
        .header-carousel {
            position: absolute; top: 0; left: 0; width: 100%; height: 100%; overflow: hidden; z-index: 1;
        }
        .header-carousel-slides { width: 100%; height: 100%; }
        .header-slide { position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; transition: opacity 1.5s ease-in-out; }
        .header-slide.active { opacity: 1; }
        .header-slide img { width: 100%; height: 100%; object-fit: cover; }
        .header-carousel-dots { position: absolute; bottom: 20px; left: 50%; transform: translateX(-50%); display: flex; gap: 12px; z-index: 10; }
        .header-carousel-dot { width: 12px; height: 12px; border-radius: 50%; background-color: rgba(255, 255, 255, 0.5); cursor: pointer; transition: all 0.3s ease; border: 2px solid transparent; }
        .header-carousel-dot.active { background-color: #FBBF24; transform: scale(1.1); border-color: white; }
    </style>
    <style>
        /* CRITICAL MOBILE FIXES */
        @media (max-width: 767px) {
            html, body { width: 100% !important; min-width: 100% !important; max-width: 100vw !important; overflow-x: hidden !important; -webkit-text-size-adjust: 100% !important; }
            #mobile-navbar { display: block !important; visibility: visible !important; position: fixed !important; top: 0 !important; left: 0 !important; width: 100% !important; z-index: 1000 !important; background-color: #186862 !important; }
            .navbar.hidden.md\:block, nav.navbar:not(#mobile-navbar) { display: none !important; }
        }
        * { font-family: Arial, sans-serif !important; }
        html, body, p, h1, h2, h3, h4, h5, h6, span, div:not(.fas):not(.fab):not(.far):not(.fa), a:not(.fas):not(.fab):not(.far):not(.fa), button, input, textarea, select, label { font-family: Arial, sans-serif !important; }
        .fas, .fab, .far, .fa, [class^="fa-"], [class*=" fa-"], i.fas, i.fab, i.far, i.fa { font-family: "Font Awesome 5 Free", "Font Awesome 5 Brands", "FontAwesome" !important; }
    </style>
</head>

<body class="font-sans bg-gray-50">

    @include('layout.navbar')

    <div class="h-16"></div>

    <header class="relative h-[50vh] md:h-[60vh] lg:h-screen bg-gray-800">
        <div class="absolute inset-0 bg-teal-900/60 flex flex-col justify-center items-start p-6 md:p-12 z-[5]"></div>
    </header>

    <div class="bg-gradient-to-r from-teal-700 to-teal-800 py-3 shadow-lg">
        <div class="container mx-auto px-4">
            <div class="flex items-center space-x-4">
                <div class="bg-yellow-400 p-2 rounded-full flex-shrink-0">
                    <i class="fas fa-bullhorn text-teal-800 text-lg"></i>
                </div>
                <marquee class="flex-1 text-white font-medium text-sm md:text-base" behavior="scroll" direction="left">
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

    <main class="container mx-auto py-12 px-6">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-teal-800">Berita Terbaru</h2>
            <p class="text-gray-600 mt-2">Informasi terkini dari Universitas Negeri Jakarta</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 mb-16">
            @if (isset($regularNews) && $regularNews->count() > 0)
                @foreach ($regularNews as $news)
                    <div class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 flex flex-col">
                        <div class="relative">
                            <img alt="{{ $news->judul }}" class="w-full h-56 object-cover" src="{{ asset('storage/' . $news->gambar) }}" />
                            <div class="absolute top-3 right-3 bg-yellow-400 text-teal-800 px-3 py-1 rounded-full text-xs font-semibold">{{ ucfirst($news->kategori) }}</div>
                        </div>
                        <div class="p-5 flex flex-col flex-grow">
                            <div class="flex items-center justify-between mb-3 text-gray-500 text-sm">
                                <span><i class="fas fa-user-circle mr-2"></i>Admin</span>
                                <span><i class="fas fa-calendar-alt mr-1"></i>{{ date('d M Y', strtotime($news->tanggal)) }}</span>
                            </div>
                            <a href="{{ route('Berita.show', ['slug' => $news->slug]) }}" class="block">
                                <h3 class="font-bold text-lg mb-3 text-teal-800 hover:text-yellow-600 transition-colors h-14">{{ Str::limit($news->judul, 60) }}</h3>
                            </a>
                            <p class="text-gray-600 mb-4 text-sm flex-grow">{{ Str::limit(strip_tags($news->isi), 100) }}</p>
                            <a href="{{ route('Berita.show', ['slug' => $news->slug]) }}" class="mt-auto inline-block text-teal-700 hover:text-yellow-500 font-medium text-sm">
                                Baca selengkapnya <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            @else
                <p class="col-span-full text-center text-gray-500">Tidak ada berita untuk ditampilkan.</p>
            @endif
        </div>

        @if (isset($featuredNews) && $featuredNews->count() > 0)
        <section class="news-carousel-section mt-16">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-teal-800">Berita Unggulan</h2>
                <p class="text-gray-600 mt-2">Sorotan berita pilihan dari kami</p>
            </div>
        
            <div class="news-carousel-container relative px-10">
                <div class="swiper-container news-carousel">
                    <div class="swiper-wrapper pb-10">
                        @foreach ($featuredNews->take(3) as $news) {{-- <<< FIX: Limit to 3 cards --}}
                            <div class="swiper-slide">
                                <div class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 flex flex-col">
                                    <div class="relative">
                                        <img alt="{{ $news->judul }}" class="w-full h-56 object-cover" src="{{ asset('storage/' . $news->gambar) }}" />
                                        <div class="absolute top-3 right-3 bg-yellow-400 text-teal-800 px-3 py-1 rounded-full text-xs font-semibold">{{ ucfirst($news->kategori) }}</div>
                                    </div>
                                    <div class="p-5 flex flex-col flex-grow">
                                        <div class="flex items-center justify-between mb-3 text-gray-500 text-sm">
                                            <span><i class="fas fa-user-circle mr-2"></i>Admin</span>
                                            <span><i class="fas fa-calendar-alt mr-1"></i>{{ date('d M Y', strtotime($news->tanggal)) }}</span>
                                        </div>
                                        <a href="{{ route('Berita.show', ['slug' => $news->slug]) }}" class="block">
                                            <h3 class="font-bold text-lg mb-3 text-teal-800 hover:text-yellow-600 transition-colors h-14">{{ Str::limit($news->judul, 60) }}</h3>
                                        </a>
                                        <p class="text-gray-600 mb-4 text-sm flex-grow">{{ Str::limit(strip_tags($news->isi), 100) }}</p>
                                        <a href="{{ route('Berita.show', ['slug' => $news->slug]) }}" class="mt-auto inline-block text-teal-700 hover:text-yellow-500 font-medium text-sm">
                                            Baca selengkapnya <i class="fas fa-arrow-right ml-1"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </section>
        @endif
    </main>

    <section class="program-section py-16 bg-gray-100">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-teal-800">Program & Layanan</h2>
                <p class="text-gray-600 mt-2 max-w-2xl mx-auto">Program dan Layanan Direktorat Inovasi, Sistem Informasi dan Pemeringkatan</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 mb-8">
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
                            <div class="text-gray-600 mb-4 text-sm flex-grow min-h-[80px]">{!! Str::limit(strip_tags($program->deskripsi), 120) !!}</div>
                            <div class="mt-4 pt-4 border-t border-gray-100">
                                @if (!empty($program->url))
                                    <a href="{{ $program->url }}" target="_blank" rel="noopener noreferrer" class="w-full text-center bg-teal-600 hover:bg-teal-700 text-white py-2.5 px-6 rounded-lg font-semibold text-sm transition-colors">Akses Program</a>
                                @else
                                    <button type="button" class="login w-full text-center bg-teal-600 hover:bg-teal-700 text-white py-2.5 px-6 rounded-lg font-semibold text-sm transition-colors">Akses Program</button>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="col-span-full text-center text-gray-500">Belum ada program layanan yang tersedia.</p>
                @endforelse
            </div>

            @if (count($programLayanan) > 3)
                <div class="mt-12">
                    <h3 class="text-2xl font-semibold text-teal-800 mb-6 text-center">Program Lainnya</h3>
                    <div class="program-carousel-container relative px-10">
                        <div class="swiper-container program-carousel">
                            <div class="swiper-wrapper pb-10">
                                @foreach ($programLayanan->skip(3)->take(3) as $program) {{-- <<< FIX: Limit to 3 cards --}}
                                    <div class="swiper-slide">
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
                                                <div class="text-gray-600 mb-4 text-sm flex-grow min-h-[80px]">{!! Str::limit(strip_tags($program->deskripsi), 120) !!}</div>
                                                <div class="mt-4 pt-4 border-t border-gray-100">
                                                    @if (!empty($program->url))
                                                        <a href="{{ $program->url }}" target="_blank" rel="noopener noreferrer" class="w-full text-center bg-teal-600 hover:bg-teal-700 text-white py-2.5 px-6 rounded-lg font-semibold text-sm transition-colors">Akses Program</a>
                                                    @else
                                                        <button type="button" class="login w-full text-center bg-teal-600 hover:bg-teal-700 text-white py-2.5 px-6 rounded-lg font-semibold text-sm transition-colors">Akses Program</button>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                           <div class="swiper-pagination"></div>
                        </div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                    </div>
                </div>
            @endif
        </div>
    </section>
    
    <section class="unj-prestasi-container py-16 bg-slate-100">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-slate-800">UNJ dalam <span class="text-emerald-600">Prestasi</span></h2>
                <div class="mt-4 h-1 w-24 bg-emerald-600 mx-auto rounded-full"></div>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6 md:gap-8">
                <div class="bg-white rounded-lg p-6 flex flex-col items-center text-center transition-all duration-300 hover:shadow-xl hover:border-emerald-500 hover:-translate-y-1 border">
                    <div class="text-emerald-500 text-4xl mb-3"><i class="fa fa-user-graduate"></i></div>
                    <div class="text-3xl font-bold text-slate-700">30.673</div>
                    <div class="text-sm text-slate-500 font-medium">Mahasiswa</div>
                </div>
                <div class="bg-white rounded-lg p-6 flex flex-col items-center text-center transition-all duration-300 hover:shadow-xl hover:border-sky-500 hover:-translate-y-1 border">
                    <div class="text-sky-500 text-4xl mb-3"><i class="fa fa-globe"></i></div>
                    <div class="text-3xl font-bold text-slate-700">125</div>
                    <div class="text-sm text-slate-500 font-medium">Mhs. Internasional</div>
                </div>
                <div class="bg-white rounded-lg p-6 flex flex-col items-center text-center transition-all duration-300 hover:shadow-xl hover:border-purple-500 hover:-translate-y-1 border">
                    <div class="text-purple-500 text-4xl mb-3"><i class="fa fa-chalkboard-teacher"></i></div>
                    <div class="text-3xl font-bold text-slate-700">131</div>
                    <div class="text-sm text-slate-500 font-medium">Guru Besar</div>
                </div>
                <div class="bg-white rounded-lg p-6 flex flex-col items-center text-center transition-all duration-300 hover:shadow-xl hover:border-indigo-500 hover:-translate-y-1 border">
                    <div class="text-indigo-500 text-4xl mb-3"><i class="fa fa-user-tie"></i></div>
                    <div class="text-3xl font-bold text-slate-700">1.132</div>
                    <div class="text-sm text-slate-500 font-medium">Dosen</div>
                </div>
                <div class="bg-white rounded-lg p-6 flex flex-col items-center text-center transition-all duration-300 hover:shadow-xl hover:border-orange-500 hover:-translate-y-1 border">
                    <div class="text-orange-500 text-4xl mb-3"><i class="fa fa-book"></i></div>
                    <div class="text-3xl font-bold text-slate-700">3.681</div>
                    <div class="text-sm text-slate-500 font-medium">Terindeks Scopus</div>
                </div>
                <div class="bg-white rounded-lg p-6 flex flex-col items-center text-center transition-all duration-300 hover:shadow-xl hover:border-pink-500 hover:-translate-y-1 border">
                    <div class="text-pink-500 text-4xl mb-3"><i class="fa fa-th-large"></i></div>
                    <div class="text-3xl font-bold text-slate-700">116</div>
                    <div class="text-sm text-slate-500 font-medium">Program Studi</div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-16">
        <div class="container mx-auto px-6">
            <div class="mb-16">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-teal-800">Instagram DITSIP UNJ</h2>
                    <p class="text-gray-600 mt-2">Ikuti kami di <a href="https://www.instagram.com/dit.isipunj/" target="_blank" class="text-teal-600 hover:text-yellow-500 font-semibold">@dit.isipunj</a> untuk info terbaru.</p>
                </div>
                <div id="instagram-api-feed-container" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    @for ($i = 0; $i < 3; $i++)
                        <div class="bg-gray-200 rounded-lg h-80 animate-pulse"></div>
                    @endfor
                </div>
            </div>
            <div>
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-teal-800">Galeri Video</h2>
                    <p class="text-gray-600 mt-2">Tonton video terbaru dari kanal YouTube kami.</p>
                </div>
                <div id="dynamic-videos-container" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    @for ($i = 0; $i < 3; $i++)
                        <div class="bg-gray-200 rounded-lg h-80 animate-pulse"></div>
                    @endfor
                </div>
            </div>
        </div>
    </section>

    @include('layout.footer')

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const navbar = document.querySelector('.navbar.hidden.md\\:block');
        if (navbar) {
            window.addEventListener('scroll', () => {
                if (window.scrollY > 50) navbar.classList.add('scrolled');
                else navbar.classList.remove('scrolled');
            }, { passive: true });
        }

        const mobileMenuToggle = document.getElementById('mobile-menu-toggle'),
              mobileSidebar = document.getElementById('mobile-sidebar'),
              sidebarOverlay = document.getElementById('sidebar-overlay'),
              closeSidebarBtn = document.getElementById('close-sidebar');

        const openSidebar = () => {
            if (mobileSidebar && sidebarOverlay) {
                mobileSidebar.style.transform = 'translateX(0)';
                sidebarOverlay.style.opacity = '1';
                sidebarOverlay.style.pointerEvents = 'auto';
                document.body.classList.add('sidebar-open');
            }
        };
        const closeSidebar = () => {
            if (mobileSidebar && sidebarOverlay) {
                mobileSidebar.style.transform = 'translateX(100%)';
                sidebarOverlay.style.opacity = '0';
                sidebarOverlay.style.pointerEvents = 'none';
                document.body.classList.remove('sidebar-open');
            }
        };

        if (mobileMenuToggle) mobileMenuToggle.addEventListener('click', openSidebar);
        if (closeSidebarBtn) closeSidebarBtn.addEventListener('click', closeSidebar);
        if (sidebarOverlay) sidebarOverlay.addEventListener('click', closeSidebar);

        // --- Smart Carousel Initializer ---
        const initSwiper = (containerSelector, config) => {
            const container = document.querySelector(containerSelector);
            if (!container) return;
            
            const slides = container.querySelectorAll('.swiper-slide');
            const slideCount = slides.length;

            // If 3 or fewer slides, disable loop and hide navigation
            if (slideCount <= 3) {
                config.loop = false;
                config.autoplay = false; // Also disable autoplay
                const navNext = container.parentElement.querySelector('.swiper-button-next');
                const navPrev = container.parentElement.querySelector('.swiper-button-prev');
                if(navNext) navNext.style.display = 'none';
                if(navPrev) navPrev.style.display = 'none';
            }
            
            new Swiper(container, config);
        };

        // --- Initialize Program Carousel ---
        initSwiper('.program-carousel', {
            loop: true,
            autoplay: { delay: 5000, disableOnInteraction: false },
            pagination: { el: '.program-carousel-container .swiper-pagination', clickable: true },
            navigation: { nextEl: '.program-carousel-container .swiper-button-next', prevEl: '.program-carousel-container .swiper-button-prev' },
            breakpoints: {
                320: { slidesPerView: 1, spaceBetween: 16 },
                768: { slidesPerView: 2, spaceBetween: 24 },
                1024: { slidesPerView: 3, spaceBetween: 32 }
            }
        });

        // --- Initialize News Carousel ---
        initSwiper('.news-carousel', {
            loop: true,
            autoplay: { delay: 5500, disableOnInteraction: false },
            pagination: { el: '.news-carousel-container .swiper-pagination', clickable: true },
            navigation: { nextEl: '.news-carousel-container .swiper-button-next', prevEl: '.news-carousel-container .swiper-button-prev' },
            breakpoints: {
                320: { slidesPerView: 1, spaceBetween: 16 },
                768: { slidesPerView: 2, spaceBetween: 24 },
                1024: { slidesPerView: 3, spaceBetween: 32 }
            }
        });

        const instaContainer = document.getElementById('instagram-api-feed-container');
        if (instaContainer) {
            fetch('/api/instagram-posts')
                .then(response => response.json())
                .then(posts => {
                    instaContainer.innerHTML = '';
                    if (!posts || posts.length === 0) {
                        instaContainer.innerHTML = '<p class="col-span-full text-center text-gray-500">Gagal memuat post Instagram.</p>';
                        return;
                    }
                    posts.slice(0, 3).forEach(post => {
                        const postDate = new Date(post.posted_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' });
                        const card = `
                            <a href="${post.permalink}" target="_blank" class="group block bg-white rounded-lg overflow-hidden shadow-md hover:shadow-xl transition-shadow duration-300">
                                <div class="relative">
                                    <img src="${post.media_url}" alt="${post.title || 'Instagram Post'}" class="w-full h-64 object-cover transition-transform duration-300 group-hover:scale-105">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                                    <div class="absolute bottom-0 left-0 p-4 text-white">
                                        <h3 class="font-bold text-lg">${post.title || 'Postingan Instagram'}</h3>
                                        <p class="text-sm opacity-90">${postDate}</p>
                                    </div>
                                </div>
                            </a>`;
                        instaContainer.innerHTML += card;
                    });
                })
                .catch(error => {
                    console.error('Error fetching Instagram posts:', error);
                    instaContainer.innerHTML = '<p class="col-span-full text-center text-gray-500">Gagal memuat post Instagram.</p>';
                });
        }

        const videoContainer = document.getElementById('dynamic-videos-container');
        if (videoContainer) {
            fetch('/api/youtube-videos')
                .then(response => response.json())
                .then(videos => {
                    videoContainer.innerHTML = '';
                    if (!videos || videos.length === 0) {
                        videoContainer.innerHTML = '<p class="col-span-full text-center text-gray-500">Belum ada video tersedia.</p>';
                        return;
                    }
                    videos.slice(0, 3).forEach(video => {
                        let videoId = '';
                        try {
                            if (video.link.includes('youtu.be/')) videoId = new URL(video.link).pathname.substring(1);
                            else videoId = new URL(video.link).searchParams.get('v');
                        } catch (e) { console.error('Invalid YouTube URL:', video.link); return; }
                        
                        if (!videoId) return;

                        const thumbnailUrl = `https://img.youtube.com/vi/${videoId}/hqdefault.jpg`;
                        const card = `
                            <a href="${video.link}" target="_blank" class="group block bg-white rounded-lg overflow-hidden shadow-md hover:shadow-xl transition-shadow duration-300">
                                <div class="relative">
                                    <img src="${thumbnailUrl}" alt="${video.judul}" class="w-full h-48 object-cover transition-transform duration-300 group-hover:scale-105">
                                    <div class="absolute inset-0 bg-black/40 flex items-center justify-center">
                                        <i class="fab fa-youtube text-white text-5xl opacity-80 group-hover:opacity-100 group-hover:scale-110 transition-all"></i>
                                    </div>
                                </div>
                                <div class="p-4"><h3 class="font-bold text-gray-800 group-hover:text-teal-600 transition-colors">${video.judul}</h3></div>
                            </a>`;
                        videoContainer.innerHTML += card;
                    });
                })
                .catch(error => {
                    console.error('Error fetching YouTube videos:', error);
                    videoContainer.innerHTML = '<p class="col-span-full text-center text-gray-500">Gagal memuat video.</p>';
                });
        }

        function initHeaderCarousel(images) {
            const header = document.querySelector("header");
            if (!header || header.querySelector(".header-carousel")) return;

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
                slide.appendChild(img);
                slidesContainer.appendChild(slide);
            });

            const dotsContainer = document.createElement("div");
            dotsContainer.className = "header-carousel-dots";
            images.forEach((_, index) => {
                const dot = document.createElement("span");
                dot.className = `header-carousel-dot ${index === 0 ? "active" : ""}`;
                dot.dataset.index = index;
                dotsContainer.appendChild(dot);
            });

            carouselContainer.appendChild(slidesContainer);
            carouselContainer.appendChild(dotsContainer);

            const overlay = header.querySelector(".absolute.inset-0");
            if (overlay) header.insertBefore(carouselContainer, overlay);
            else header.appendChild(carouselContainer);

            let currentSlide = 0;
            const totalSlides = images.length;
            let autoplayInterval;

            function showSlide(index) {
                currentSlide = (index + totalSlides) % totalSlides;
                slidesContainer.querySelectorAll(".header-slide").forEach((slide, i) => slide.classList.toggle("active", i === currentSlide));
                dotsContainer.querySelectorAll(".header-carousel-dot").forEach((dot, i) => dot.classList.toggle("active", i === currentSlide));
            }

            function nextSlide() { showSlide(currentSlide + 1); }

            function resetAutoplay() {
                clearInterval(autoplayInterval);
                autoplayInterval = setInterval(nextSlide, 5000);
            }

            dotsContainer.addEventListener("click", (e) => {
                if (e.target.matches(".header-carousel-dot")) {
                    showSlide(parseInt(e.target.dataset.index));
                    resetAutoplay();
                }
            });

            resetAutoplay();
        }

        const defaultImages = [
            "https://media.quipper.com/media/W1siZiIsIjIwMTgvMDEvMjMvMDkvNDMvMjcvYWVjNTQ1OTctOTJiNi00Y2EyLWEzZDctMGZiNTg1ZTU1MDEzLyJdLFsicCIsInRodW1iIiwiMTIwMHhcdTAwM2UiLHt9XSxbInAiLCJjb252ZXJ0IiwiLWNvbG9yc3BhY2Ugc1JHQiAtc3RyaXAiLHsiZm9ybWF0IjoianBnIn1dXQ?sha=9c61a35270604434",
            "https://www.unj.ac.id/wp-content/uploads/2020/02/DJI_0007-1024x576.jpg",
            "https://cdns.klimg.com/merdeka.com/i/w/news/2023/07/20/1578964/670x335/potret-gedung-baru-unj-yang-megah-dan-modern-berkonsep-green-building-dan-smart-building.jpg"
        ];

        fetch("/api/carousel-images")
            .then(response => {
                if (!response.ok) throw new Error('API response not OK');
                return response.json();
            })
            .then(data => {
                const galleryImages = data.map(item => "/storage/" + item.image);
                if (galleryImages.length > 0) initHeaderCarousel(galleryImages);
                else initHeaderCarousel(defaultImages);
            })
            .catch(error => {
                console.error("Error fetching carousel images, using defaults:", error);
                initHeaderCarousel(defaultImages);
            });
    });
    </script>
</body>
</html>