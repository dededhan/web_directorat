<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0, user-scalable=yes" name="viewport" />
    <title>Universitas Negeri Jakarta - Direktorat Pemeringkatan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('home.css') }}">
    <link rel="stylesheet" href="{{ asset('header-carousel.css') }}">
    <script src="{{ asset('header-carousel.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('mobile.css') }}">
    <script src="{{ asset('mobile.js') }}"></script>


    <!-- Shared CSS for both sections -->
<style>
    /* Common styling for both Instagram and YouTube cards */
 
    
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
     color: #0D9488; /* Teal color to match your theme */
     text-decoration: underline;
     transition: color 0.2s ease;
 }
 
 .news-excerpt a:hover {
     color: #F59E0B; /* Yellow color on hover to match your theme */
 }
 </style>
</head>

<body class="font-sans bg-gray-100">
    @include('navbar')

    <!-- Header section -->
    <header class="relative">
    <!-- The carousel will be dynamically inserted here by JavaScript -->
    <img alt="Universitas Negeri Jakarta building with a sculpture in front" class="w-full h-screen object-cover"
        src="https://media.quipper.com/media/W1siZiIsIjIwMTgvMDEvMjMvMDkvNDMvMjcvYWVjNTQ1OTctOTJiNi00Y2EyLWEzZDctMGZiNTg1ZTU1MDEzLyJdLFsicCIsInRodW1iIiwiMTIwMHhcdTAwM2UiLHt9XSxbInAiLCJjb252ZXJ0IiwiLWNvbG9yc3BhY2Ugc1JHQiAtc3RyaXAiLHsiZm9ybWF0IjoianBnIn1dXQ?sha=9c61a35270604434" />
    <div class="absolute inset-0 bg-teal-900 bg-opacity-50 flex flex-col justify-center items-start p-8">
        <div class="flex items-center space-x-4">
        </div>
        <div class="mt-16">
        </div>
    </div>
</header>
    <div class="bg-gradient-to-r from-teal-700 to-teal-800 py-3 shadow-lg">
        <div class="container mx-auto px-6">
            <div class="flex items-center space-x-4">
                <!-- Icon Pengumuman -->
                <div class="bg-yellow-400 p-2 rounded-full">
                    <i class="fas fa-bullhorn text-teal-800 text-lg"></i>
                </div>
                <!-- Teks Berjalan - Dynamic from database -->
                <marquee class="flex-1 text-white font-medium news-marquee" behavior="scroll" direction="left"
                    scrollamount="5">
                    @if (isset($announcements) && count($announcements) > 0)
                        {{ $announcements[0]->icon }} <span
                            class="text-yellow-400 font-bold">{{ $announcements[0]->judul_pengumuman }}</span>
                        {{ $announcements[0]->isi_pengumuman }}
                    @else
                        <span class="text-yellow-400 font-bold">Belum ada pengumuman</span>
                    @endif
                </marquee>
            </div>
        </div>
        <!-- Hidden data for JavaScript -->
        @if (isset($announcements))
        <script type="application/json" id="announcements-data">
        {!! json_encode($announcements) !!}
        </script>
        @endif

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


        </div>
        <!-- Regular News Grid with improved styling -->
        {{-- <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16">
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
                        <h2 class="font-bold text-xl mb-3 text-teal-800 hover:text-yellow-600 transition-colors">
                            {{ $news->judul }}
                        </h2>
                        <p class="text-gray-600 mb-4">
                            {{ Str::limit(strip_tags($news->isi), 100) }}
                        </p>
                        <a href="{{ route('Berita.beritahome') }}"
                            class="inline-block text-teal-700 hover:text-yellow-500 font-medium">
                            Baca selengkapnya <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
            @endforeach
        </div> --}}

        <!-- Enhanced Featured News Carousel -->
        <div class="enhanced-carousel">
            <div class="enhanced-carousel-title">Berita Unggulan</div>
            <div class="carousel">
                <div class="carousel-inner">
                    @foreach ($featuredNews as $featured)
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
                                    <h3 class="news-title">{{ $featured->judul }}</h3>
                                    <p class="news-excerpt">
                                        {!! Str::limit($featured->isi, 150) !!}
                                    </p>
                                    <a href="{{ route('Berita.beritahome') }}" class="news-link">
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
    <!-- Program dan Layanan Section -->
    <section class="program-section">
        <div class="container">
            <!-- Section Header -->
            <div class="unj-content-section-header">
    <h2 class="unj-section-title">Program & Layanan</h2>
    <p class="unj-section-subtitle">Program dan Layanan Direktorat Inovasi, Sistem Informasi dan Pemeringkatan</p>
</div>
    
            <!-- Program Cards Grid -->
            <div class="program-grid">
                @forelse($programLayanan as $program)
                    <div class="program-card">
                        <div class="card-content">
                            <div class="icon-container">
                                <i class="{{ $program->icon }}"></i>
                            </div>
                            <h3 class="card-title">{{ $program->judul }}</h3>
                            <p class="card-description">
                                {{ $program->deskripsi }}
                            </p>
                            <a href="#" class="card-link">
                                Selengkapnya
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                @empty
                    <!-- Fallback content if no programs are found -->
                    <div class="program-card">
                        <div class="card-content">
                            <div class="icon-container">
                                <i class="fas fa-graduation-cap"></i>
                            </div>
                            <h3 class="card-title">Beasiswa</h3>
                            <p class="card-description">
                                Program beasiswa untuk mahasiswa berprestasi dan kurang mampu, membantu meringankan biaya
                                pendidikan.
                            </p>
                            <a href="#" class="card-link">
                                Selengkapnya
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
    
                @endforelse
            </div>
        </div>
    </section>

    <!-- UNJ dalam Angka Section -->
    {{-- <section class="unj-dalam-angka">
        <div class="container">
            <h1>UNJ dalam <span>Angka</span></h1>
            <div class="grid-container">
                <div class="grid-item">
                    <i class="fas fa-users"></i>
                    <p class="number">30,673</p>
                    <p class="label">Mahasiswa</p>
                </div>
                <div class="grid-item">
                    <i class="fas fa-globe"></i>
                    <p class="number">125</p>
                    <p class="label">Mahasiswa Internasional</p>
                </div>
                <div class="grid-item">
                    <i class="fas fa-lightbulb"></i>
                    <p class="number">130</p>
                    <p class="label">Guru Besar</p>
                </div>
                <div class="grid-item">
                    <i class="fas fa-user-tie"></i>
                    <p class="number">1,132</p>
                    <p class="label">Dosen</p>
                </div>
                <div class="grid-item">
                    <i class="fas fa-user-tie"></i>
                    <p class="number">4</p>
                    <p class="label">Dosen Internasional</p>
                </div>
                <div class="grid-item">
                    <i class="fas fa-user"></i>
                    <p class="number">774</p>
                    <p class="label">Tendik</p>
                </div>
                <div class="grid-item">
                    <i class="fas fa-university"></i>
                    <p class="number">8</p>
                    <p class="label">Fakultas</p>
            </div>
            <div class="grid-item">
                <i class="fas fa-school"></i>
                <p class="number">1</p>
                <p class="label">Sekolah</p>
            </div>
            <div class="grid-item">
                <i class="fas fa-th"></i>
                <p class="number">116</p>
                <p class="label">Program Studi</p>
            </div>
            <div class="grid-item">
                <i class="fas fa-graduation-cap"></i>
                <p class="number">3,681</p>
                <p class="label">terindeks Scopus</p>
            </div>
            <div class="grid-item">
                <i class="fas fa-file-alt"></i>
                <p class="number">2,459</p>
                <p class="label">HKI</p>
            </div>
            <div class="grid-item">
                <i class="fas fa-certificate"></i>
                <p class="number">123</p>
                <p class="label">Hak Paten</p>
            </div>
        </div>
        <div class="badges">
            <div class="badge">116 Prodi Terakreditasi Nasional</div>
            <div class="badge">60 Prodi Terakreditasi Internasional</div>
        </div>
    </div> --}}
    </section>
    <script src="{{ asset('home.js') }}"></script>
</body>
<!-- Instagram Section with Updated Card Styling -->
<section class="media-section py-16 bg-gradient-to-b from-white to-gray-50">
    <div class="container mx-auto px-6">
        <!-- Instagram Section Header -->
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-teal-700 mb-2">Instagram DITSIP UNJ</h2>
            <div class="flex items-center justify-center mb-4">
                <div class="h-1 w-16 bg-gray-300"></div>
                <span class="text-yellow-400 text-2xl mx-3"><i class="fab fa-instagram"></i></span>
                <div class="h-1 w-16 bg-gray-300"></div>
            </div>
            <p class="text-gray-600 max-w-2xl mx-auto">Ikuti akun Instagram kami untuk mendapatkan informasi terbaru</p>
            <a href="https://www.instagram.com/dir.isipunj/" target="_blank" class="inline-flex items-center text-teal-700 hover:text-yellow-500 mt-2 font-medium">
                <span>@dir.isipunj</span>
                <i class="fas fa-external-link-alt ml-2"></i>
            </a>
        </div>        
        <!-- Instagram Feed Grid with Consistent Card Styling -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @forelse($instagramPosts ?? [] as $index => $post)
            <!-- Instagram Post -->
            <div class="media-card bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 group">
                <div class="relative pb-[56.25%]">
                    <!-- Empty placeholder with gradient background -->
                    <div class="absolute inset-0 bg-gradient-to-br {{ $index % 3 === 0 ? 'from-teal-100 to-teal-200' : ($index % 3 === 1 ? 'from-yellow-100 to-yellow-200' : 'from-teal-100 to-blue-200') }} flex items-center justify-center">
                        <i class="fab fa-instagram text-teal-500 text-5xl opacity-30"></i>
                    </div>
                    <div class="absolute top-3 right-3 bg-yellow-400 text-teal-800 px-3 py-1 rounded-full text-sm font-semibold">
                        Instagram
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center text-gray-500 text-sm">
                            <i class="fab fa-instagram mr-2"></i>
                            <span>@dir.isipunj</span>
                        </div>
                    </div>
                    <h3 class="font-bold text-teal-800 text-xl mb-2 group-hover:text-yellow-500 transition-colors duration-300">{{ $post->judul }}</h3>
                    <p class="text-gray-600 mb-4">
                        {{ Str::limit($post->deskripsi, 100) }}
                    </p>
                    <div class="mt-4 pt-4 border-t border-gray-100">
                        <a href="{{ $post->link }}" target="_blank" class="inline-flex items-center text-teal-600 hover:text-yellow-500 transition-colors duration-300">
                            <span>Lihat di Instagram</span>
                            <i class="fas fa-external-link-alt ml-2 text-sm"></i>
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <!-- Fallback content if no posts are found -->
            <!-- Instagram Post 1 -->
            <div class="media-card bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 group">
                <div class="relative pb-[56.25%]">
                    <div class="absolute inset-0 bg-gradient-to-br from-teal-100 to-teal-200 flex items-center justify-center">
                        <i class="fab fa-instagram text-teal-500 text-5xl opacity-30"></i>
                    </div>
                    <div class="absolute top-3 right-3 bg-yellow-400 text-teal-800 px-3 py-1 rounded-full text-sm font-semibold">
                        Instagram
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center text-gray-500 text-sm">
                            <i class="fab fa-instagram mr-2"></i>
                            <span>@dir.isipunj</span>
                        </div>
                    </div>
                    <h3 class="font-bold text-teal-800 text-xl mb-2 group-hover:text-yellow-500 transition-colors duration-300">Instagram DISIP UNJ</h3>
                    <p class="text-gray-600 mb-4">
                        Kunjungi Instagram kami untuk melihat konten terbaru
                    </p>
                    <div class="mt-4 pt-4 border-t border-gray-100">
                        <a href="https://www.instagram.com/dir.isipunj/" target="_blank" class="inline-flex items-center text-teal-600 hover:text-yellow-500 transition-colors duration-300">
                            <span>Lihat di Instagram</span>
                            <i class="fas fa-external-link-alt ml-2 text-sm"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforelse
        </div>
        
        <!-- View More Button -->
        <div class="text-center mt-8">
            <a href="https://www.instagram.com/dir.isipunj/" target="_blank" class="inline-flex items-center justify-center px-6 py-3 bg-teal-700 hover:bg-teal-600 text-white font-medium rounded-lg transition-colors duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-1">
                <span>Lihat Semua Postingan</span>
                <i class="fas fa-external-link-alt ml-2 text-sm"></i>
            </a>
        </div>
    </div>
</section>

<!-- YouTube Section with Consistent Card Styling -->
<!-- YouTube Section with Consistent Card Styling -->
<section class="media-section py-16 relative bg-gradient-to-b from-white to-gray-50">
    <!-- Decorative Elements -->
    <div class="absolute bottom-0 right-0 w-32 h-32 bg-yellow-400 rounded-full -mr-16 -mb-16 opacity-10"></div>
    <div class="absolute top-40 left-0 w-24 h-24 bg-teal-600 rounded-full -ml-12 opacity-10"></div>
    
    <div class="container mx-auto px-6 relative z-10">
        <!-- Section Header with Enhanced Styling -->
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-teal-700 mb-2">Youtube Universitas Negeri Jakarta</h2>
            <div class="flex items-center justify-center mb-4">
                <div class="h-1 w-16 bg-gray-300"></div>
                <span class="text-red-500 text-2xl mx-3"><i class="fab fa-youtube"></i></span>
                <div class="h-1 w-16 bg-gray-300"></div>
            </div>
            <p class="text-gray-600 max-w-2xl mx-auto">Tonton video terbaru dari channel YouTube UNJ</p>
        </div>
        
        <!-- Featured YouTube Videos - Hardcoded -->
        <div class="mb-12">
            <h3 class="text-xl font-bold text-teal-700 mb-6 text-center">Video Unggulan</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Video 1 -->
                <div class="media-card bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 group">
                    <div class="relative pb-[56.25%] h-0 overflow-hidden">
                        <iframe class="absolute top-0 left-0 w-full h-full" src="https://www.youtube.com/embed/JJ0pP0kzLxQ?rel=0" title="Profil Universitas Negeri Jakarta Tahun 2020" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen>
                        </iframe>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center mb-3">
                            <div class="flex items-center text-gray-500 text-sm">
                                <i class="fab fa-youtube mr-2"></i>
                                <span>UNJ Official</span>
                            </div>
                        </div>
                        <h3 class="font-bold text-teal-800 text-xl mb-2 group-hover:text-yellow-500 transition-colors duration-300">Profil Universitas Negeri Jakarta</h3>
                        <p class="text-gray-600 mb-4">Mengenal lebih dalam tentang UNJ, fasilitas, dan program unggulan yang ditawarkan.</p>
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <a href="https://www.youtube.com/watch?v=JJ0pP0kzLxQ" target="_blank" class="inline-flex items-center text-teal-600 hover:text-yellow-500 transition-colors duration-300">
                                <span>Tonton di YouTube</span>
                                <i class="fas fa-external-link-alt ml-2 text-sm"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Video 2 -->
                <div class="media-card bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 group">
                    <div class="relative pb-[56.25%] h-0 overflow-hidden">
                        <iframe class="absolute top-0 left-0 w-full h-full" src="https://www.youtube.com/embed/XtmrlOGaAcE?rel=0" title="Muda dan Berkarya : Inspirasi Wirausahawan Alumni UNJ" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen>
                        </iframe>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center mb-3">
                            <div class="flex items-center text-gray-500 text-sm">
                                <i class="fab fa-youtube mr-2"></i>
                                <span>UNJ Official</span>
                            </div>
                        </div>
                        <h3 class="font-bold text-teal-800 text-xl mb-2 group-hover:text-yellow-500 transition-colors duration-300">Muda dan Berkarya</h3>
                        <p class="text-gray-600 mb-4">Inspirasi dari wirausahawan alumni UNJ yang sukses membangun karir.</p>
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <a href="https://www.youtube.com/watch?v=XtmrlOGaAcE" target="_blank" class="inline-flex items-center text-teal-600 hover:text-yellow-500 transition-colors duration-300">
                                <span>Tonton di YouTube</span>
                                <i class="fas fa-external-link-alt ml-2 text-sm"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Video 3 -->
                <div class="media-card bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 group">
                    <div class="relative pb-[56.25%] h-0 overflow-hidden">
                        <iframe class="absolute top-0 left-0 w-full h-full" src="https://www.youtube.com/embed/LeF0xnWIPYU?rel=0" title="Mengenal Lebih Jauh UNJ! with Wakil Rektor III UNJ" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen>
                        </iframe>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center mb-3">
                            <div class="flex items-center text-gray-500 text-sm">
                                <i class="fab fa-youtube mr-2"></i>
                                <span>UNJ Official</span>
                            </div>
                        </div>
                        <h3 class="font-bold text-teal-800 text-xl mb-2 group-hover:text-yellow-500 transition-colors duration-300">Mengenal Lebih Jauh UNJ</h3>
                        <p class="text-gray-600 mb-4">Wawancara eksklusif bersama Wakil Rektor III Universitas Negeri Jakarta.</p>
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <a href="https://www.youtube.com/watch?v=LeF0xnWIPYU" target="_blank" class="inline-flex items-center text-teal-600 hover:text-yellow-500 transition-colors duration-300">
                                <span>Tonton di YouTube</span>
                                <i class="fas fa-external-link-alt ml-2 text-sm"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Dynamic YouTube Videos from Database -->
        <div>
            <h3 class="text-xl font-bold text-teal-700 mb-6 text-center">Video Terbaru</h3>
            <div id="dynamic-videos-container" class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Dynamic content will be loaded here via JavaScript -->
                <div class="media-card bg-white rounded-xl overflow-hidden shadow-lg animate-pulse">
                    <div class="relative pb-[56.25%] h-0 overflow-hidden bg-gray-200"></div>
                    <div class="p-6">
                        <div class="h-4 bg-gray-200 rounded w-3/4 mb-3"></div>
                        <div class="h-6 bg-gray-200 rounded w-full mb-2"></div>
                        <div class="h-4 bg-gray-200 rounded w-full mb-4"></div>
                        <div class="h-4 bg-gray-200 rounded w-full mb-2"></div>
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <div class="h-4 bg-gray-200 rounded w-2/4"></div>
                        </div>
                    </div>
                </div>
                <div class="media-card bg-white rounded-xl overflow-hidden shadow-lg animate-pulse">
                    <div class="relative pb-[56.25%] h-0 overflow-hidden bg-gray-200"></div>
                    <div class="p-6">
                        <div class="h-4 bg-gray-200 rounded w-3/4 mb-3"></div>
                        <div class="h-6 bg-gray-200 rounded w-full mb-2"></div>
                        <div class="h-4 bg-gray-200 rounded w-full mb-4"></div>
                        <div class="h-4 bg-gray-200 rounded w-full mb-2"></div>
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <div class="h-4 bg-gray-200 rounded w-2/4"></div>
                        </div>
                    </div>
                </div>
                <div class="media-card bg-white rounded-xl overflow-hidden shadow-lg animate-pulse">
                    <div class="relative pb-[56.25%] h-0 overflow-hidden bg-gray-200"></div>
                    <div class="p-6">
                        <div class="h-4 bg-gray-200 rounded w-3/4 mb-3"></div>
                        <div class="h-6 bg-gray-200 rounded w-full mb-2"></div>
                        <div class="h-4 bg-gray-200 rounded w-full mb-4"></div>
                        <div class="h-4 bg-gray-200 rounded w-full mb-2"></div>
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <div class="h-4 bg-gray-200 rounded w-2/4"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- View More Button -->
        <div class="text-center mt-8">
            <a href="https://www.youtube.com/channel/UCjQ4lIzs8Zm3zVD3wiL-KMw" target="_blank" class="inline-flex items-center justify-center px-6 py-3 bg-teal-700 hover:bg-teal-600 text-white font-medium rounded-lg transition-colors duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-1">
                <span>Lihat Semua Video</span>
                <i class="fas fa-external-link-alt ml-2 text-sm"></i>
            </a>
        </div>
    </div>
</section>



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
</script>
</html>
@include('footerlp')
