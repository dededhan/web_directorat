@extends('layouts.pemeringkatan')

@section('title', 'Direktorat Pemeringkatan')

@push('styles')
    {{-- Swiper JS for Carousel --}}
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    
    {{-- Landing Page Styles --}}
    @vite('resources/css/pemeringkatan/landing.css')
    
    <style>
        /* Global Font */
        body, p, h1, h2, h3, h4, h5, h6, span, div, a, button, input, textarea, select, label {
            font-family: 'Inter', Arial, sans-serif !important;
        }
        
        /* Navbar scroll effect - FIXED untuk mempertahankan warna teal */
        .navbar.scrolled {
            background-color: rgba(39, 113, 119, 0.95) !important;
            backdrop-filter: blur(10px);
            padding-top: 0.75rem;
            padding-bottom: 0.75rem;
            transition: all 0.3s ease;
        }

        /* Memastikan navbar tetap teal */
        .navbar.hidden.md\\:block {
            background-color: #277177 !important;
        }

        .navbar:not(.scrolled) {
            background-color: #277177 !important;
        }

        /* Prevent body scroll when sidebar is open */
        body.sidebar-open {
            overflow: hidden;
        }

        /* Custom styles for program cards to ensure equal height */
        .program-card {
            display: flex;
            flex-direction: column;
            height: 100%;
        }
        .program-card > div:last-child {
            margin-top: auto;
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
        .program-carousel .swiper-button-next::after,
        .program-carousel .swiper-button-prev::after,
        .news-carousel-container .swiper-button-next::after,
        .news-carousel-container .swiper-button-prev::after {
            font-size: 18px;
            font-weight: bold;
        }
        .program-carousel .swiper-pagination-bullet-active,
        .news-carousel-container .swiper-pagination-bullet-active {
            background-color: #14B8A6;
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
            background-color: #FBBF24; /* Yellow-400 */
            transform: scale(1.1);
            border-color: white;
        }
    </style>
    <style>
        /* General Styles from home.blade.php */
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
        .grid {
            align-items: stretch;
        }
        .news-marquee a {
            color: #facc15;
            text-decoration: underline;
        }
        .news-marquee strong, .news-marquee b {
            font-weight: bold;
            color: white;
        }
        .news-marquee em, .news-marquee i {
            font-style: italic;
        }
        .news-marquee * {
            color: white;
        }
        .news-marquee .text-yellow-400 {
            color: #facc15 !important;
        }
        html, body, p, h1, h2, h3, h4, h5, h6, span, div:not(.fas):not(.fab):not(.far):not(.fa), a:not(.fas):not(.fab):not(.far):not(.fa), button, input, textarea, select, label {
            font-family: Arial, sans-serif !important;
        }
        .fas, .fab, .far, .fa, [class^="fa-"], [class*=" fa-"], i.fas, i.fab, i.far, i.fa {
            font-family: "Font Awesome 5 Free", "Font Awesome 5 Brands", "FontAwesome" !important;
        }
    </style>
    <style>
        /* Carousel Styling from home.blade.php */
        .program-carousel-container,
        .news-carousel-container {
            position: relative;
            overflow: hidden;
            padding: 0 60px;
        }
        .program-carousel,
        .news-carousel {
            overflow: hidden !important;
        }
        .program-carousel .swiper-wrapper,
        .news-carousel .swiper-wrapper {
            align-items: stretch;
        }
        .program-carousel .swiper-slide,
        .news-carousel .swiper-slide {
            height: auto;
            display: flex;
        }
        .program-carousel-container .swiper-button-prev,
        .news-carousel-container .swiper-button-prev {
            left: 10px !important;
            z-index: 20;
        }
        .program-carousel-container .swiper-button-next,
        .news-carousel-container .swiper-button-next {
            right: 10px !important;
            z-index: 20;
        }
        .program-carousel-container .swiper-pagination,
        .news-carousel-container .swiper-pagination {
            position: relative;
            margin-top: 2rem;
            text-align: center;
        }
        @media (max-width: 767px) {
            .program-carousel-container,
            .news-carousel-container {
                padding: 0 15px;
            }
            .program-carousel-container .swiper-button-next,
            .program-carousel-container .swiper-button-prev,
            .news-carousel-container .swiper-button-next,
            .news-carousel-container .swiper-button-prev {
                display: none;
            }
        }
    </style>
@endpush

@section('content')
    <div class="h-16 md:hidden"></div>
    <header class="relative h-[50vh] md:h-[60vh] lg:h-screen bg-gray-800">
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
                <marquee class="flex-1 text-white font-medium text-sm md:text-base news-marquee" behavior="scroll" direction="left">
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
        {{-- Latest News Section (Regular News) --}}
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-teal-800">Berita Terbaru</h2>
            <p class="text-gray-600 mt-2">Informasi terkini dari Universitas Negeri Jakarta</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 mb-16">
            @if ($regularNews && $regularNews->count() > 0)
                @foreach ($regularNews as $news)
                    <div class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 flex flex-col">
                        <div class="relative">
                            <img alt="{{ $news->getTranslatedTitle() }}" class="w-full h-56 object-cover" src="{{ asset('storage/' . $news->gambar) }}" />
                            <div class="absolute top-3 right-3 bg-yellow-400 text-teal-800 px-3 py-1 rounded-full text-xs font-semibold">
                                {{ ucfirst($news->kategori) }}
                            </div>
                        </div>
                        <div class="p-5 flex flex-col flex-grow">
                            <div class="flex items-center justify-between mb-3 text-gray-500 text-sm">
                                <span><i class="fas fa-user-circle mr-2"></i>Admin</span>
                                <span><i class="fas fa-calendar-alt mr-1"></i>{{ date('d M Y', strtotime($news->tanggal)) }}</span>
                            </div>
                            <a href="{{ route('Berita.show', ['slug' => $news->slug]) }}" class="block">
                                <h3 class="font-bold text-lg mb-3 text-teal-800 hover:text-yellow-600 transition-colors h-14">
                                    {{ Str::limit($news->getTranslatedTitle(), 60) }}
                                </h3>
                            </a>
                            <p class="text-gray-600 mb-4 text-sm flex-grow">
                                {{ Str::limit(strip_tags($news->getTranslatedContent()), 100) }}
                            </p>
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

        {{-- Featured News Carousel Section --}}
        @if (isset($featuredNews) && $featuredNews->count() > 0)
        <section class="news-carousel-section mt-16">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-teal-800">Berita Unggulan</h2>
                <p class="text-gray-600 mt-2">Sorotan berita pilihan dari kami</p>
            </div>

            <div class="news-carousel-container relative px-10">
                <div class="swiper-container news-carousel">
                    <div class="swiper-wrapper">
                        @foreach ($featuredNews as $news)
                            <div class="swiper-slide h-auto">
                                <div class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 flex flex-col h-full">
                                    <div class="relative">
                                        <img alt="{{ $news->getTranslatedTitle() }}" class="w-full h-56 object-cover" src="{{ asset('storage/' . $news->gambar) }}" />
                                        <div class="absolute top-3 right-3 bg-yellow-400 text-teal-800 px-3 py-1 rounded-full text-xs font-semibold">
                                            {{ ucfirst($news->kategori) }}
                                        </div>
                                    </div>
                                    <div class="p-5 flex flex-col flex-grow">
                                        <div class="flex items-center justify-between mb-3 text-gray-500 text-sm">
                                            <span><i class="fas fa-user-circle mr-2"></i>Admin</span>
                                            <span><i class="fas fa-calendar-alt mr-1"></i>{{ date('d M Y', strtotime($news->tanggal)) }}</span>
                                        </div>
                                        <a href="{{ route('Berita.show', ['slug' => $news->slug]) }}" class="block">
                                            <h3 class="font-bold text-lg mb-3 text-teal-800 hover:text-yellow-600 transition-colors h-14">
                                                {{ Str::limit($news->getTranslatedTitle(), 60) }}
                                            </h3>
                                        </a>
                                        <p class="text-gray-600 mb-4 text-sm flex-grow">
                                            {{ Str::limit(strip_tags($news->getTranslatedContent()), 100) }}
                                        </p>
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
                <div class="swiper-pagination mt-8 relative"></div>
            </div>
        </section>
        @endif
    </main>

    {{-- Kegiatan Sustainability Section --}}
    <section class="sustainability-section py-16 bg-gray-50">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-teal-800">Kegiatan Sustainability</h2>
                <p class="text-gray-600 mt-2 max-w-2xl mx-auto">Program keberlanjutan untuk lingkungan dan masyarakat yang lebih baik</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($sustainabilities as $activity)
                    <a href="{{ $activity->link_kegiatan ?: '#' }}" 
                       target="{{ $activity->link_kegiatan ? '_blank' : '_self' }}"
                       class="sustainability-card bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1 flex flex-col">
                        @if($activity->photos->isNotEmpty())
                            <div class="relative h-56 overflow-hidden">
                                <img src="{{ Storage::url($activity->photos->first()->path) }}" 
                                     alt="{{ $activity->judul_kegiatan }}" 
                                     class="w-full h-full object-cover transition-transform duration-300 hover:scale-110">
                                <div class="absolute top-4 right-4 bg-teal-600 text-white px-3 py-1 rounded-full text-xs font-semibold">
                                    {{ \Carbon\Carbon::parse($activity->tanggal_kegiatan)->format('d M Y') }}
                                </div>
                            </div>
                        @else
                            <div class="relative h-56 bg-gradient-to-br from-teal-100 to-teal-200 flex items-center justify-center">
                                <i class='bx bx-leaf text-6xl text-teal-600 opacity-50'></i>
                            </div>
                        @endif
                        <div class="p-6 flex flex-col flex-1">
                            <h3 class="text-xl font-bold text-gray-800 mb-3 line-clamp-2">{{ $activity->judul_kegiatan }}</h3>
                            <p class="text-sm text-gray-600 mb-4 line-clamp-3">{{ Str::limit(strip_tags($activity->deskripsi_kegiatan), 120) }}</p>
                            <div class="mt-auto space-y-2">
                                <div class="flex items-center text-sm text-gray-600">
                                    <i class='bx bx-buildings text-teal-600 mr-2'></i>
                                    <span class="font-medium">{{ strtoupper($activity->fakultas) }}</span>
                                </div>
                                @if($activity->prodi)
                                    <div class="flex items-center text-sm text-gray-600">
                                        <i class='bx bx-book-alt text-teal-600 mr-2'></i>
                                        <span>{{ $activity->prodi }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </a>
                @empty
                    <p class="col-span-full text-center text-gray-500">Belum ada kegiatan sustainability yang tersedia.</p>
                @endforelse
            </div>
        </div>
    </section>

    {{-- Alumni Berdampak Section --}}
    <section class="alumni-section py-16 bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-teal-800">Alumni Berdampak</h2>
                <p class="text-gray-600 mt-2 max-w-2xl mx-auto">Prestasi dan kontribusi alumni UNJ untuk Indonesia dan dunia</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($alumniBerdampak as $alumni)
                    <a href="{{ route('alumni') }}"
                       class="alumni-card bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1 flex flex-col group">
                        @if($alumni->image)
                            <div class="relative h-56 overflow-hidden">
                                <img src="{{ Storage::url(str_replace('public/', '', $alumni->image)) }}" 
                                     alt="{{ $alumni->judul_berita }}" 
                                     class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110">
                                <div class="absolute top-4 right-4 bg-yellow-400 text-teal-800 px-3 py-1 rounded-full text-xs font-semibold shadow-md z-10">
                                    {{ \Carbon\Carbon::parse($alumni->tanggal_berita)->format('d M Y') }}
                                </div>
                            </div>
                        @else
                            <div class="relative h-56 bg-gradient-to-br from-yellow-100 to-yellow-200 flex items-center justify-center">
                                <i class='bx bx-user-check text-6xl text-yellow-600 opacity-50'></i>
                                <div class="absolute top-4 right-4 bg-white/80 text-teal-800 px-3 py-1 rounded-full text-xs font-semibold shadow-md">
                                    {{ \Carbon\Carbon::parse($alumni->tanggal_berita)->format('d M Y') }}
                                </div>
                            </div>
                        @endif
                        <div class="p-6 flex flex-col flex-1">
                            <div class="mb-3">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-teal-100 text-teal-800">
                                    <i class='bx bx-buildings mr-1'></i>
                                    {{ strtoupper($alumni->fakultas) }}
                                </span>
                            </div>

                            <h3 class="text-xl font-bold text-gray-800 mb-2 line-clamp-2 group-hover:text-teal-700 transition-colors">{{ $alumni->judul_berita }}</h3>
                            
                            <p class="text-sm text-gray-600 mb-4 line-clamp-3">
                                {{ Str::limit(strip_tags($alumni->deskripsi), 100) }}
                            </p>

                            <div class="mt-auto">
                                <div class="flex items-center text-sm text-teal-600 font-medium group-hover:text-yellow-600 transition-colors">
                                    <i class='bx bx-link-external mr-2'></i>
                                    <span>Baca Selengkapnya</span>
                                </div>
                            </div>
                        </div>
                    </a>
                @empty
                    <p class="col-span-full text-center text-gray-500">Belum ada data alumni berdampak yang tersedia.</p>
                @endforelse
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    

    @vite('resources/js/pemeringkatan/landing.js')
@endpush