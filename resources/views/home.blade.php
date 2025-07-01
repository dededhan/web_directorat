<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Universitas Negeri Jakarta - Direktorat Pemeringkatan</title>
    <link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" type="image/png">

    {{-- Tailwind CSS via CDN for demonstration. For production, use the Vite setup. --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Font Awesome for Icons --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />

    {{-- SwiperJS for Carousel --}}
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

    {{-- Vite directives for your project's assets --}}
    @vite([
        // 'resources/css/app.css', // Assuming Tailwind is processed here
        'resources/js/home.js',
        'resources/js/mobile.js',
        'resources/js/instagram-api-feed.js',
    ])

    {{-- Custom Font and preserved scripts --}}
    <script>
        // Critical fix for sidebar and overlay from original file
        (function() {
            document.addEventListener('DOMContentLoaded', function() {
                const mobileSidebar = document.getElementById('mobile-sidebar');
                const sidebarOverlay = document.getElementById('sidebar-overlay');
                if (mobileSidebar) mobileSidebar.style.transform = 'translateX(100%)';
                if (sidebarOverlay) {
                    sidebarOverlay.style.opacity = '0';
                    sidebarOverlay.style.visibility = 'hidden';
                    sidebarOverlay.style.pointerEvents = 'none';
                    sidebarOverlay.addEventListener('click', function() {
                        if (mobileSidebar) mobileSidebar.style.transform = 'translateX(100%)';
                        sidebarOverlay.style.opacity = '0';
                        sidebarOverlay.style.visibility = 'hidden';
                        sidebarOverlay.style.pointerEvents = 'none';
                        document.body.classList.remove('sidebar-open');
                    });
                }
            });
        })();
    </script>
    <style>
        /* Minimal custom styles for elements not easily handled by Tailwind alone */
        body {
            font-family: Arial, sans-serif;
        }

        /* Preserve Font Awesome icons from being overridden by body font */
        .fas, .fab, .far, .fa, [class^="fa-"], [class*=" fa-"] {
            font-family: "Font Awesome 5 Free", "Font Awesome 5 Brands", "FontAwesome" !important;
        }

        .news-marquee a { color: #facc15; text-decoration: underline; }
        .news-marquee * { color: white; }
        .news-marquee .text-yellow-400 { color: #facc15 !important; }

        /* Styles for SwiperJS carousel */
        .swiper-slide { height: auto; }
        .swiper-wrapper { align-items: stretch; } /* Ensures all slides have same height */
        .swiper-button-next, .swiper-button-prev {
            color: #0d9488; /* teal-700 */
            background-color: white;
            width: 2.75rem; /* w-11 */
            height: 2.75rem; /* h-11 */
            border-radius: 9999px; /* rounded-full */
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
        }
        .swiper-button-next::after, .swiper-button-prev::after { font-size: 1.25rem; }
        .swiper-pagination-bullet-active { background: #0d9488; }
    </style>
</head>

<body class="bg-gray-50 font-sans">
    {{-- The included navbar should also be converted to Tailwind CSS for consistency --}}
    @include('layout.navbar')

    <header class="relative h-[60vh] md:h-screen">
        {{-- The header carousel JS will populate this section. This is a fallback image. --}}
        <img alt="Universitas Negeri Jakarta building" class="w-full h-full object-cover"
            src="https://media.quipper.com/media/W1siZiIsIjIwMTgvMDEvMjMvMDkvNDMvMjcvYWVjNTQ1OTctOTJiNi00Y2EyLWEzZDctMGZiNTg1ZTU1MDEzLyJdLFsicCIsInRodW1iIiwiMTIwMHhcdTAwM2UiLHt9XSxbInAiLCJjb252ZXJ0IiwiLWNvbG9yc3BhY2Ugc1JHQiAtc3RyaXAiLHsiZm9ybWF0IjoianBnIn1dXQ?sha=9c61a35270604434" />
        <div class="absolute inset-0 bg-teal-900/60"></div>
    </header>

    {{-- Announcement Marquee --}}
    <div class="bg-gradient-to-r from-teal-700 to-teal-800 shadow-lg">
        <div class="container mx-auto flex items-center space-x-4 px-6 py-3">
            <div class="bg-yellow-400 p-2 rounded-full flex-shrink-0">
                <i class="fas fa-bullhorn text-teal-800 text-lg"></i>
            </div>
            <marquee class="flex-1 text-white font-medium news-marquee">
                @if (isset($announcements) && count($announcements) > 0)
                    {!! $announcements[0]->icon !!} <span class="text-yellow-400 font-bold">{{ $announcements[0]->judul_pengumuman }}</span>
                    {{ strip_tags($announcements[0]->isi_pengumuman) }}
                @else
                    <span class="text-yellow-400 font-bold">Belum ada pengumuman</span>
                @endif
            </marquee>
        </div>
    </div>

    <main class="container mx-auto py-12 px-6">
        {{-- Latest News Section --}}
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-teal-800">Berita Terbaru</h2>
            <p class="text-gray-600 mt-2">Informasi terkini dari Universitas Negeri Jakarta</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16">
            @forelse ($regularNews as $news)
                <div class="bg-white rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 flex flex-col">
                    <div class="relative">
                        <img alt="{{ $news->judul }}" class="w-full h-56 object-cover" src="{{ asset('storage/' . $news->gambar) }}" />
                        <div class="absolute top-3 right-3 bg-yellow-400 text-teal-800 px-3 py-1 rounded-full text-sm font-semibold">
                            {{ ucfirst($news->kategori) }}
                        </div>
                    </div>
                    <div class="p-5 flex flex-col flex-grow">
                        <div class="flex items-center justify-between mb-3 text-sm text-gray-500">
                            <span class="flex items-center"><i class="fas fa-user-circle mr-2"></i>Admin</span>
                            <span class="flex items-center"><i class="fas fa-calendar-alt mr-1"></i>{{ date('d M Y', strtotime($news->tanggal)) }}</span>
                        </div>
                        <a href="{{ route('Berita.show', ['slug' => $news->slug]) }}" class="block">
                            <h2 class="font-bold text-xl mb-3 text-teal-800 hover:text-yellow-600 transition-colors line-clamp-2">{{ $news->judul }}</h2>
                        </a>
                        <p class="text-gray-600 mb-4 flex-grow line-clamp-3">{{ Str::limit(strip_tags($news->isi), 100) }}</p>
                        <a href="{{ route('Berita.show', ['slug' => $news->slug]) }}" class="mt-auto inline-block text-teal-700 hover:text-yellow-500 font-medium">
                            Baca selengkapnya <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
            @empty
                <p class="col-span-full text-center text-gray-500">Tidak ada berita reguler untuk ditampilkan.</p>
            @endforelse
        </div>

        {{-- Featured News Carousel --}}
        <div class="enhanced-carousel relative mt-12 mb-20">
            <div class="absolute -top-6 left-1/2 -translate-x-1/2 bg-teal-700 text-white px-8 py-3 rounded-full font-bold z-10 shadow-md">Berita Unggulan</div>
            <div class="carousel rounded-lg shadow-lg overflow-hidden bg-white pt-10">
                <div class="carousel-inner">
                    {{-- Carousel items are populated by home.js and Blade --}}
                    @forelse ($featuredNews as $featured)
                        <div class="carousel-item-enhanced">
                            <div class="news-card-enhanced h-full flex flex-col bg-white rounded-lg overflow-hidden shadow-md transition-transform duration-300 hover:-translate-y-1.5">
                                <div class="news-image-container relative overflow-hidden">
                                    <img alt="{{ $featured->judul }}" class="news-image w-full h-52 object-cover transition-transform duration-500 hover:scale-105" src="{{ asset('storage/' . $featured->gambar) }}" />
                                    <div class="news-tag-enhanced absolute top-3 right-3 bg-yellow-400 text-teal-800 px-3 py-1 rounded-full font-semibold text-sm z-10">{{ ucfirst($featured->kategori) }}</div>
                                </div>
                                <div class="news-content p-5 flex-grow flex flex-col">
                                    <div class="news-meta flex items-center mb-3 text-sm text-gray-500">
                                        <i class="fas fa-user-circle mr-2"></i>Admin
                                        <span class="mx-2">|</span>
                                        <i class="fas fa-calendar-alt mr-2"></i>{{ date('d M Y', strtotime($featured->tanggal)) }}
                                    </div>
                                    <a href="{{ route('Berita.show', ['slug' => $featured->slug]) }}">
                                        <h3 class="news-title font-bold text-lg mb-3 text-teal-700 hover:text-yellow-500 transition-colors line-clamp-2">{{ $featured->judul }}</h3>
                                    </a>
                                    <p class="news-excerpt text-gray-600 mb-4 flex-grow line-clamp-3">{{ Str::limit(strip_tags($featured->isi), 150) }}</p>
                                    <a href="{{ route('Berita.show', ['slug' => $featured->slug]) }}" class="news-link mt-auto inline-flex items-center text-teal-700 font-medium hover:text-yellow-500">
                                        Baca selengkapnya <i class="fas fa-arrow-right ml-2 transition-transform duration-300 group-hover:translate-x-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="w-full text-center text-gray-500 p-4">Tidak ada berita unggulan untuk ditampilkan.</div>
                    @endforelse
                </div>
                {{-- Carousel controls will be added by home.js --}}
            </div>
        </div>
    </main>

    {{-- Programs & Services Section --}}
    <section class="program-section bg-gray-50 py-16">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-teal-700">Program & Layanan</h2>
                <p class="text-gray-600 mt-2 max-w-2xl mx-auto">Jelajahi program dan layanan unggulan dari Direktorat Inovasi, Sistem Informasi dan Pemeringkatan.</p>
            </div>

            <div class="relative px-12">
                <div class="swiper program-layanan-swiper">
                    <div class="swiper-wrapper py-4">
                        @forelse($programLayanan as $program)
                            <div class="swiper-slide h-auto">
                                <div class="program-card bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 flex flex-col h-full">
                                    <div class="relative h-48 w-full">
                                        @if ($program->image)
                                            <img src="{{ asset('storage/' . $program->image) }}" alt="{{ $program->judul }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full bg-teal-600 flex items-center justify-center">
                                                <i class="{{ $program->icon ?? 'fas fa-cogs' }} text-5xl text-white"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="p-6 flex flex-col flex-grow">
                                        <h3 class="font-bold text-teal-800 text-xl mb-3 h-14 line-clamp-2">{{ $program->judul }}</h3>
                                        <div class="text-gray-600 mb-4 flex-grow line-clamp-3">{!! Str::limit(strip_tags($program->deskripsi), 100) !!}</div>
                                        <div class="mt-auto pt-4 border-t border-gray-100 flex flex-col space-y-3">
                                            <button type="button" class="program-details-btn inline-flex items-center justify-center text-teal-700 hover:text-yellow-500 font-medium" data-program-id="{{ $program->id }}" data-title="{{ $program->judul }}" data-full-description="{!! htmlspecialchars($program->deskripsi_lengkap ?? $program->deskripsi) !!}">
                                                Lihat Detail <i class="fas fa-arrow-right ml-2"></i>
                                            </button>
                                            @if (!empty($program->url))
                                                <a href="{{ $program->url }}" target="_blank" rel="noopener noreferrer" class="w-full text-center bg-gradient-to-r from-teal-600 to-teal-500 text-white py-3 px-6 rounded-lg font-semibold inline-block hover:from-teal-700 hover:to-teal-600 transition-all">
                                                    Akses Program
                                                </a>
                                            @else
                                                <button type="button" class="login w-full text-center bg-gradient-to-r from-gray-500 to-gray-400 text-white py-3 px-6 rounded-lg font-semibold cursor-not-allowed">
                                                    Akses Internal
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="swiper-slide">
                                 <div class="col-span-full bg-white rounded-xl p-8 text-center shadow-lg">
                                    <i class="fas fa-exclamation-circle text-5xl text-teal-600 mb-4"></i>
                                    <h3 class="font-bold text-teal-800 text-xl mb-3">Belum Ada Program</h3>
                                    <p class="text-gray-600">Maaf, saat ini belum ada program layanan yang tersedia.</p>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
                
                <div class="swiper-pagination mt-8 relative"></div>
            </div>
        </div>
    </section>

    {{-- Social Media Feed Sections --}}
    <section class="py-16 bg-white">
        <div class="container mx-auto px-6">
            {{-- Instagram Feed --}}
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-teal-700">Terhubung dengan Kami</h2>
                <p class="text-gray-600 mt-2">Ikuti kami di media sosial untuk mendapatkan pembaruan terbaru.</p>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <div>
                    <div class="flex justify-center items-center gap-3 mb-6">
                        <i class="fab fa-instagram text-3xl text-pink-600"></i>
                        <h3 class="text-2xl font-semibold text-gray-800">Postingan Instagram</h3>
                    </div>
                    <div id="instagram-api-feed-container" class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        {{-- Instagram posts will be loaded here by instagram-api-feed.js --}}
                        @for ($i = 0; $i < 2; $i++)
                            <div class="bg-gray-200 rounded-xl p-4 animate-pulse">
                                <div class="h-40 bg-gray-300 rounded-lg mb-4"></div>
                                <div class="h-4 bg-gray-300 rounded w-3/4 mb-2"></div>
                                <div class="h-4 bg-gray-300 rounded w-1/2"></div>
                            </div>
                        @endfor
                    </div>
                     <div class="text-center mt-8">
                        <a href="https://www.instagram.com/dit.isipunj/" target="_blank" class="inline-flex items-center justify-center px-6 py-3 bg-teal-700 hover:bg-teal-600 text-white font-medium rounded-lg transition-colors">
                            <span>Lihat Semua Postingan</span><i class="fas fa-external-link-alt ml-2"></i>
                        </a>
                    </div>
                </div>
                {{-- YouTube Feed --}}
                <div>
                    <div class="flex justify-center items-center gap-3 mb-6">
                        <i class="fab fa-youtube text-3xl text-red-600"></i>
                        <h3 class="text-2xl font-semibold text-gray-800">Galeri Video</h3>
                    </div>
                    <div id="dynamic-videos-container" class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        {{-- YouTube videos will be loaded here by an inline script --}}
                        @for ($i = 0; $i < 2; $i++)
                            <div class="bg-gray-200 rounded-xl p-4 animate-pulse">
                                <div class="h-40 bg-gray-300 rounded-lg mb-4"></div>
                                <div class="h-4 bg-gray-300 rounded w-3/4 mb-2"></div>
                                <div class="h-4 bg-gray-300 rounded w-1/2"></div>
                            </div>
                        @endfor
                    </div>
                     <div class="text-center mt-8">
                        <a href="https://www.youtube.com/@unj_official" target="_blank" class="inline-flex items-center justify-center px-6 py-3 bg-teal-700 hover:bg-teal-600 text-white font-medium rounded-lg transition-colors">
                           <span>Lihat Semua Video</span><i class="fas fa-external-link-alt ml-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- UNJ in Numbers / Achievements Section --}}
    <section class="unj-prestasi-container py-16 bg-slate-100">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-slate-800">UNJ dalam <span class="text-emerald-600">Prestasi</span></h2>
                <div class="mt-4 h-1.5 w-28 bg-emerald-600 mx-auto rounded-full"></div>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6">
                {{-- Data items are hardcoded as in the original file --}}
                <div class="prestasi-card bg-white rounded-lg border border-slate-200 p-6 flex flex-col items-center text-center transition-all duration-300 hover:shadow-xl hover:border-emerald-500 hover:-translate-y-1">
                    <div class="text-emerald-500 text-5xl mb-4"><i class="fa fa-user-graduate"></i></div>
                    <div class="text-3xl font-bold text-slate-700 mb-1">30.673</div>
                    <div class="text-base text-slate-500 font-medium">Mahasiswa</div>
                </div>
                <div class="prestasi-card bg-white rounded-lg border border-slate-200 p-6 flex flex-col items-center text-center transition-all duration-300 hover:shadow-xl hover:border-sky-500 hover:-translate-y-1">
                    <div class="text-sky-500 text-5xl mb-4"><i class="fa fa-globe"></i></div>
                    <div class="text-3xl font-bold text-slate-700 mb-1">125</div>
                    <div class="text-base text-slate-500 font-medium">Mahasiswa Internasional</div>
                </div>
                <div class="prestasi-card bg-white rounded-lg border border-slate-200 p-6 flex flex-col items-center text-center transition-all duration-300 hover:shadow-xl hover:border-purple-500 hover:-translate-y-1">
                    <div class="text-purple-500 text-5xl mb-4"><i class="fa fa-chalkboard-teacher"></i></div>
                    <div class="text-3xl font-bold text-slate-700 mb-1">131</div>
                    <div class="text-base text-slate-500 font-medium">Guru Besar</div>
                </div>
                <div class="prestasi-card bg-white rounded-lg border border-slate-200 p-6 flex flex-col items-center text-center transition-all duration-300 hover:shadow-xl hover:border-indigo-500 hover:-translate-y-1">
                    <div class="text-indigo-500 text-5xl mb-4"><i class="fa fa-user-tie"></i></div>
                    <div class="text-3xl font-bold text-slate-700 mb-1">1.132</div>
                    <div class="text-base text-slate-500 font-medium">Dosen</div>
                </div>
                <a href="{{ route('Pemeringkatan.program.international-faculty-staff') }}" class="prestasi-card block bg-white rounded-lg border border-slate-200 p-6 flex flex-col items-center text-center transition-all duration-300 hover:shadow-xl hover:border-red-500 hover:-translate-y-1">
                    <div class="text-red-500 text-5xl mb-4"><i class="fa fa-users"></i></div>
                    <div class="text-3xl font-bold text-slate-700 mb-1">4</div>
                    <div class="text-base text-slate-500 font-medium">Dosen Internasional</div>
                </a>
                <div class="prestasi-card bg-white rounded-lg border border-slate-200 p-6 flex flex-col items-center text-center transition-all duration-300 hover:shadow-xl hover:border-orange-500 hover:-translate-y-1">
                    <div class="text-orange-500 text-5xl mb-4"><i class="fa fa-user-cog"></i></div>
                    <div class="text-3xl font-bold text-slate-700 mb-1">774</div>
                    <div class="text-base text-slate-500 font-medium">Tendik</div>
                </div>
                <div class="prestasi-card bg-white rounded-lg border border-slate-200 p-6 flex flex-col items-center text-center transition-all duration-300 hover:shadow-xl hover:border-lime-500 hover:-translate-y-1">
                    <div class="text-lime-500 text-5xl mb-4"><i class="fa fa-university"></i></div>
                    <div class="text-3xl font-bold text-slate-700 mb-1">8</div>
                    <div class="text-base text-slate-500 font-medium">Fakultas</div>
                </div>
                <div class="prestasi-card bg-white rounded-lg border border-slate-200 p-6 flex flex-col items-center text-center transition-all duration-300 hover:shadow-xl hover:border-cyan-500 hover:-translate-y-1">
                    <div class="text-cyan-500 text-5xl mb-4"><i class="fa fa-graduation-cap"></i></div>
                    <div class="text-3xl font-bold text-slate-700 mb-1">1</div>
                    <div class="text-base text-slate-500 font-medium">Sekolah Pascasarjana</div>
                </div>
                <div class="prestasi-card bg-white rounded-lg border border-slate-200 p-6 flex flex-col items-center text-center transition-all duration-300 hover:shadow-xl hover:border-pink-500 hover:-translate-y-1">
                    <div class="text-pink-500 text-5xl mb-4"><i class="fa fa-th-large"></i></div>
                    <div class="text-3xl font-bold text-slate-700 mb-1">116</div>
                    <div class="text-base text-slate-500 font-medium">Program Studi</div>
                </div>
                <div class="prestasi-card bg-white rounded-lg border border-slate-200 p-6 flex flex-col items-center text-center transition-all duration-300 hover:shadow-xl hover:border-green-500 hover:-translate-y-1">
                    <div class="text-green-500 text-5xl mb-4"><i class="fa fa-book"></i></div>
                    <div class="text-3xl font-bold text-slate-700 mb-1">3.681</div>
                    <div class="text-base text-slate-500 font-medium">terindeks Scopus</div>
                </div>
                 <div class="prestasi-card bg-white rounded-lg border border-slate-200 p-6 flex flex-col items-center text-center transition-all duration-300 hover:shadow-xl hover:border-amber-500 hover:-translate-y-1">
                    <div class="text-amber-500 text-5xl mb-4"><i class="fa fa-file-alt"></i></div>
                    <div class="text-3xl font-bold text-slate-700 mb-1">2.459</div>
                    <div class="text-base text-slate-500 font-medium">HKI</div>
                </div>
                <div class="prestasi-card bg-white rounded-lg border border-slate-200 p-6 flex flex-col items-center text-center transition-all duration-300 hover:shadow-xl hover:border-rose-500 hover:-translate-y-1">
                    <div class="text-rose-500 text-5xl mb-4"><i class="fa fa-certificate"></i></div>
                    <div class="text-3xl font-bold text-slate-700 mb-1">123</div>
                    <div class="text-base text-slate-500 font-medium">Hak Paten</div>
                </div>
            </div>
        </div>
    </section>

    {{-- Program Details Modal --}}
    <div id="programDetailsModal" class="fixed inset-0 bg-black/60 z-[1100] hidden items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-2xl max-w-3xl w-full max-h-[90vh] flex flex-col">
            <div class="relative">
                <div id="modalImageContainer" class="w-full h-56 bg-teal-600 rounded-t-xl flex items-center justify-center overflow-hidden">
                    <i id="modalFallbackIcon" class="text-6xl text-white"></i>
                </div>
                <button id="closeModalBtn" class="absolute top-4 right-4 bg-white/80 rounded-full w-10 h-10 flex items-center justify-center shadow-md hover:bg-white">
                    <i class="fas fa-times text-teal-700 text-xl"></i>
                </button>
            </div>
            <div class="p-8 overflow-y-auto">
                <h2 id="programModalTitle" class="text-3xl font-bold text-gray-800 mb-4"></h2>
                <div id="programModalDescription" class="prose max-w-none text-gray-700"></div>
            </div>
        </div>
    </div>


    {{-- The included footer should also be converted to Tailwind CSS for consistency --}}
    @include('layout.footer')

    {{-- All original scripts are preserved below --}}
    <script>
        // Script to initialize the new Program & Layanan carousel
        document.addEventListener('DOMContentLoaded', function () {
            const programSwiper = new Swiper('.program-layanan-swiper', {
                loop: false,
                slidesPerView: 1,
                spaceBetween: 16,
                
                // Responsive settings
                breakpoints: {
                    640: {
                        slidesPerView: 2,
                        spaceBetween: 24,
                    },
                    1024: {
                        slidesPerView: 3,
                        spaceBetween: 32,
                    }
                },
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
            });
        });

        // Scripts from the original file are preserved to maintain functionality
        // Mobile sidebar enhancement script
        document.addEventListener('DOMContentLoaded', function() {
            // This script handles the mobile sidebar functionality.
            // It is preserved from the original file.
            console.log('Mobile sidebar script loaded.');
            const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
            const mobileSidebar = document.getElementById('mobile-sidebar');
            const sidebarOverlay = document.getElementById('sidebar-overlay');
            const closeSidebar = document.getElementById('close-sidebar');

            function showSidebar() {
                if (!mobileSidebar || !sidebarOverlay) return;
                document.body.classList.add('sidebar-open');
                mobileSidebar.style.transform = 'translateX(0)';
                sidebarOverlay.style.opacity = '1';
                sidebarOverlay.style.visibility = 'visible';
                sidebarOverlay.style.pointerEvents = 'auto';
            }

            function hideSidebar() {
                if (!mobileSidebar || !sidebarOverlay) return;
                document.body.classList.remove('sidebar-open');
                mobileSidebar.style.transform = 'translateX(100%)';
                sidebarOverlay.style.opacity = '0';
                sidebarOverlay.style.visibility = 'hidden';
                sidebarOverlay.style.pointerEvents = 'none';
            }

            if (mobileMenuToggle) mobileMenuToggle.addEventListener('click', (e) => { e.stopPropagation(); showSidebar(); });
            if (closeSidebar) closeSidebar.addEventListener('click', (e) => { e.stopPropagation(); hideSidebar(); });
            if (sidebarOverlay) sidebarOverlay.addEventListener('click', hideSidebar);
            document.addEventListener('keydown', (e) => { if (e.key === 'Escape') hideSidebar(); });
        });

        // Dynamic YouTube Video Loader
        document.addEventListener('DOMContentLoaded', function() {
            fetch('/api/youtube-videos')
                .then(response => response.json())
                .then(videos => {
                    const container = document.getElementById('dynamic-videos-container');
                    if (!container) return;
                    container.innerHTML = '';
                    if (videos.length === 0) {
                        container.innerHTML = `<p class="col-span-full text-center text-gray-500">Belum ada video tersedia.</p>`;
                        return;
                    }
                    videos.slice(0, 2).forEach(video => { // Limit to 2 for the new layout
                        let videoId = video.link.split('v=')[1]?.split('&')[0] || video.link.split('/').pop();
                        const embedUrl = `https://www.youtube.com/embed/${videoId}?rel=0`;
                        container.innerHTML += `
                            <div class="bg-white rounded-xl overflow-hidden shadow-lg group flex flex-col">
                                <div class="relative pb-[56.25%] h-0">
                                    <iframe class="absolute top-0 left-0 w-full h-full" src="${embedUrl}" title="${video.judul}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                </div>
                                <div class="p-4 flex-grow flex flex-col">
                                    <h3 class="font-bold text-teal-800 group-hover:text-yellow-500 transition-colors line-clamp-2">${video.judul}</h3>
                                    <a href="${video.link}" target="_blank" class="mt-auto text-sm inline-flex items-center text-red-600 hover:underline">
                                        Tonton di YouTube <i class="fas fa-external-link-alt ml-2"></i>
                                    </a>
                                </div>
                            </div>
                        `;
                    });
                })
                .catch(error => {
                    console.error('Error fetching YouTube videos:', error);
                    const container = document.getElementById('dynamic-videos-container');
                    if (container) container.innerHTML = `<p class="col-span-full text-center text-gray-500">Gagal memuat video.</p>`;
                });
        });

        // Program Details Modal Script
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('programDetailsModal');
            if (!modal) return;
            const modalTitle = document.getElementById('programModalTitle');
            const modalDescription = document.getElementById('programModalDescription');
            const modalImageContainer = document.getElementById('modalImageContainer');
            const modalFallbackIcon = document.getElementById('modalFallbackIcon');
            const closeModalBtn = document.getElementById('closeModalBtn');
            const programDetailsBtns = document.querySelectorAll('.program-details-btn');

            function openProgramModal(btn) {
                const title = btn.getAttribute('data-title');
                const fullDescription = btn.getAttribute('data-full-description');
                const card = btn.closest('.program-card, .swiper-slide'); // Works for both grid and carousel
                const cardImage = card.querySelector('img');
                modalTitle.textContent = title;
                modalDescription.innerHTML = fullDescription;
                if (cardImage) {
                    modalImageContainer.innerHTML = `<img src="${cardImage.src}" alt="${title}" class="w-full h-full object-cover">`;
                } else {
                    const cardIcon = card.querySelector('.bg-teal-600 i');
                    modalImageContainer.innerHTML = '';
                    modalFallbackIcon.className = cardIcon ? cardIcon.className : 'fas fa-cogs text-6xl text-white';
                    modalImageContainer.appendChild(modalFallbackIcon);
                }
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }

            programDetailsBtns.forEach(btn => btn.addEventListener('click', (e) => { e.preventDefault(); openProgramModal(e.currentTarget); }));
            closeModalBtn.addEventListener('click', () => modal.classList.add('hidden'));
            modal.addEventListener('click', (e) => { if (e.target === modal) modal.classList.add('hidden'); });
            document.addEventListener('keydown', (e) => { if (e.key === 'Escape') modal.classList.add('hidden'); });
        });

        // Instagram Feed Loader with Fallback
        document.addEventListener('DOMContentLoaded', function() {
            const feedContainer = document.getElementById('instagram-api-feed-container');
            if (!feedContainer) return;

            window.handleImageError = function(img, postTitle) {
                img.src = 'https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png'; // Fallback image
            };

            fetch('/api/instagram-posts') // Assuming this is the correct API endpoint
                .then(response => response.ok ? response.json() : Promise.reject('Failed to load'))
                .then(posts => {
                    feedContainer.innerHTML = '';
                    if (!posts || posts.length === 0) {
                        feedContainer.innerHTML = `<p class="col-span-full text-center text-gray-500">Postingan Instagram tidak tersedia.</p>`;
                        return;
                    }
                    posts.slice(0, 2).forEach(post => { // Limit to 2 for the new layout
                        if (post && post.media_url) {
                            feedContainer.innerHTML += `
                                <div class="bg-white rounded-xl overflow-hidden shadow-lg group flex flex-col">
                                    <div class="relative pb-[100%] h-0">
                                        <img src="${post.media_url}" alt="${post.title || 'Instagram Post'}" class="absolute top-0 left-0 w-full h-full object-cover transition-transform duration-300 group-hover:scale-105" onerror="handleImageError(this, '${post.title?.replace(/'/g, "\\'")}')">
                                    </div>
                                    <div class="p-4 flex-grow flex flex-col">
                                        <p class="text-gray-600 line-clamp-2 flex-grow">${post.caption ? (post.caption.length > 80 ? post.caption.substring(0, 80) + '...' : post.caption) : ''}</p>
                                        <a href="${post.permalink}" target="_blank" class="mt-auto text-sm inline-flex items-center text-pink-600 hover:underline">
                                            Lihat di Instagram <i class="fas fa-external-link-alt ml-2"></i>
                                        </a>
                                    </div>
                                </div>
                            `;
                        }
                    });
                })
                .catch(error => {
                    console.error('Error fetching Instagram posts:', error);
                    feedContainer.innerHTML = `<p class="col-span-full text-center text-gray-500">Gagal memuat postingan Instagram.</p>`;
                });
        });
    </script>
</body>

</html>