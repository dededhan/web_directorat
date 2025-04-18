<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0, user-scalable=yes" name="viewport"/>
    <title>Universitas Negeri Jakarta - Direktorat Pemeringkatan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
    <link rel="stylesheet" href="{{ asset('home.css') }}">
    <script src="{{ asset('home.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('mobile.css') }}">
    <script src="{{ asset('mobile.js') }}"></script>
</head>
<body class="font-sans bg-gray-100">
    @include('subdirektorat-inovasi.navbarhilirisasi')
    
    <!-- Header section -->
    <header class="relative">
        <img alt="Universitas Negeri Jakarta building with a sculpture in front" class="w-full h-screen object-cover" src="https://media.quipper.com/media/W1siZiIsIjIwMTgvMDEvMjMvMDkvNDMvMjcvYWVjNTQ1OTctOTJiNi00Y2EyLWEzZDctMGZiNTg1ZTU1MDEzLyJdLFsicCIsInRodW1iIiwiMTIwMHhcdTAwM2UiLHt9XSxbInAiLCJjb252ZXJ0IiwiLWNvbG9yc3BhY2Ugc1JHQiAtc3RyaXAiLHsiZm9ybWF0IjoianBnIn1dXQ?sha=9c61a35270604434"/>
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
                <!-- Teks Berjalan -->
                <marquee class="flex-1 text-white font-medium" behavior="scroll" direction="left" scrollamount="5">
                    🕌 <span class="text-yellow-400 font-bold">Masjid Nurul Irfan UNJ</span> Menerima dan Menyalurkan Hewan Qurban. Segera hubungi panitia untuk informasi lebih lanjut. 🐑
                </marquee>
            </div>
        </div>
    </div>
    
    <!-- Main content -->
    <main class="container mx-auto py-12 px-6">
        <!-- Section Header with better styling -->
        <div class="mb-8 border-l-4 border-yellow-400 pl-4">
            <h2 class="text-teal-700 text-2xl font-bold">Berita Terbaru</h2>
            <p class="text-gray-600">Informasi terkini dari Universitas Negeri Jakarta</p>
        </div>
        
        <!-- Filter and View Options -->
        <div>
            <!-- Filter controls would go here -->
        </div>
        
        <!-- Regular News Grid with improved styling -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16">
            <div class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="relative">
                    <img alt="" class="w-full h-56 object-cover" src=""/>
                    <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black to-transparent h-24"></div>
                    <div class="absolute top-3 right-3 bg-yellow-400 text-teal-800 px-3 py-1 rounded-full text-sm font-semibold">
                    </div>
                </div>
                <div class="p-5">
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center text-gray-500 text-sm">
                            <i class="fas fa-user-circle mr-2"></i>Admin
                        </div>
                        <div class="text-gray-500 text-sm">
                            <i class="fas fa-calendar-alt mr-1"></i>
                        </div>
                    </div>
                    <h2 class="font-bold text-xl mb-3 text-teal-800 hover:text-yellow-600 transition-colors">
                    </h2>
                    <p class="text-gray-600 mb-4">
                    </p>
                    <a href="" class="inline-block text-teal-700 hover:text-yellow-500 font-medium">
                        Baca selengkapnya <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Enhanced Featured News Carousel -->
        <div class="enhanced-carousel">
            <div class="enhanced-carousel-title">Berita Unggulan</div>
            <div class="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item-enhanced">
                        <div class="news-card-enhanced">
                            <div class="news-image-container">
                                <img alt="" class="news-image" src=""/>
                                <div class="news-tag-enhanced"></div>
                            </div>
                            <div class="news-content">
                                <div class="news-meta">
                                    <i class="fas fa-user-circle mr-2"></i>Admin
                                    <span class="mx-2">|</span>
                                    <i class="fas fa-calendar-alt mr-2"></i>
                                </div>
                                <h3 class="news-title"></h3>
                                <p class="news-excerpt">
                                    
                                </p>
                                <a href="" class="news-link">
                                    Baca selengkapnya <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    
    <!-- Program dan Layanan Section -->
    <section class="program-section">
        <div class="container">
            <!-- Section Header -->
            <div class="section-header">
                <span class="section-subtitle">Program & Layanan</span>
                <h2 class="section-title">Layanan</h2>
                <p class="section-description">
                    Universitas Negeri Jakarta menyediakan berbagai program dan layanan unggulan untuk mendukung perkembangan akademik dan karir mahasiswa.
                </p>
            </div>

            <!-- Program Cards Grid -->
            <div class="program-grid">
                <!-- Program 1 -->
                <div class="program-card">
                    <div class="card-content">
                        <div class="icon-container">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <h3 class="card-title">Beasiswa</h3>
                        <p class="card-description">
                            Program beasiswa untuk mahasiswa berprestasi dan kurang mampu, membantu meringankan biaya pendidikan.
                        </p>
                        <a href="#" class="card-link">
                            Selengkapnya
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>

                <!-- Program 2 -->
                <div class="program-card">
                    <div class="card-content">
                        <div class="icon-container">
                            <i class="fas fa-book-open"></i>
                        </div>
                        <h3 class="card-title">Perpustakaan Digital</h3>
                        <p class="card-description">
                            Akses ke ribuan buku, jurnal, dan sumber belajar digital untuk mendukung studi dan penelitian.
                        </p>
                        <a href="#" class="card-link">
                            Selengkapnya
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>

                <!-- Program 3 -->
                <div class="program-card">
                    <div class="card-content">
                        <div class="icon-container">
                            <i class="fas fa-briefcase"></i>
                        </div>
                        <h3 class="card-title">Karir & Magang</h3>
                        <p class="card-description">
                            Layanan informasi karir, magang, dan pelatihan untuk mempersiapkan mahasiswa memasuki dunia kerja.
                        </p>
                        <a href="#" class="card-link">
                            Selengkapnya
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>

                <!-- Program 4 -->
                <div class="program-card">
                    <div class="card-content">
                        <div class="icon-container">
                            <i class="fas fa-globe"></i>
                        </div>
                        <h3 class="card-title">Program Internasional</h3>
                        <p class="card-description">
                            Program pertukaran pelajar dan kerjasama internasional untuk memperluas wawasan global.
                        </p>
                        <a href="#" class="card-link">
                            Selengkapnya
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Instagram Section with Updated Card Styling -->
<section class="media-section py-16 bg-gradient-to-b from-white to-gray-50">
    <div class="container mx-auto px-6">
        <!-- Instagram Section Header -->
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-teal-700 mb-2">Instagram DISIP UNJ</h2>
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
            <!-- Instagram Post 1 -->
            <div class="media-card bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 group">
                <div class="relative pb-[56.25%]">
                    <!-- Empty placeholder with gradient background -->
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
            
            <!-- Instagram Post 2 -->
            <div class="media-card bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 group">
                <div class="relative pb-[56.25%]">
                    <!-- Empty placeholder with gradient background -->
                    <div class="absolute inset-0 bg-gradient-to-br from-yellow-100 to-yellow-200 flex items-center justify-center">
                        <i class="fab fa-instagram text-yellow-500 text-5xl opacity-30"></i>
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
                    <h3 class="font-bold text-teal-800 text-xl mb-2 group-hover:text-yellow-500 transition-colors duration-300">Informasi Terupdate</h3>
                    <p class="text-gray-600 mb-4">
                        Dapatkan informasi terupdate di Instagram kami
                    </p>
                    <div class="mt-4 pt-4 border-t border-gray-100">
                        <a href="https://www.instagram.com/dir.isipunj/" target="_blank" class="inline-flex items-center text-teal-600 hover:text-yellow-500 transition-colors duration-300">
                            <span>Lihat di Instagram</span>
                            <i class="fas fa-external-link-alt ml-2 text-sm"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Instagram Post 3 -->
            <div class="media-card bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 group">
                <div class="relative pb-[56.25%]">
                    <!-- Empty placeholder with gradient background -->
                    <div class="absolute inset-0 bg-gradient-to-br from-teal-100 to-blue-200 flex items-center justify-center">
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
                    <h3 class="font-bold text-teal-800 text-xl mb-2 group-hover:text-yellow-500 transition-colors duration-300">Aktivitas Terbaru</h3>
                    <p class="text-gray-600 mb-4">
                        Ikuti aktivitas dan pengumuman terbaru kami
                    </p>
                    <div class="mt-4 pt-4 border-t border-gray-100">
                        <a href="https://www.instagram.com/dir.isipunj/" target="_blank" class="inline-flex items-center text-teal-600 hover:text-yellow-500 transition-colors duration-300">
                            <span>Lihat di Instagram</span>
                            <i class="fas fa-external-link-alt ml-2 text-sm"></i>
                        </a>
                    </div>
                </div>
            </div>
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
        
        <!-- YouTube Videos Grid with Consistent Card Styling -->
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

        <!-- View More Button -->
        <div class="text-center mt-8">
            <a href="https://www.youtube.com/channel/UCjQ4lIzs8Zm3zVD3wiL-KMw" target="_blank" class="inline-flex items-center justify-center px-6 py-3 bg-teal-700 hover:bg-teal-600 text-white font-medium rounded-lg transition-colors duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-1">
                <span>Lihat Semua Video</span>
                <i class="fas fa-external-link-alt ml-2 text-sm"></i>
            </a>
        </div>
    </div>
</section>

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
</style>
    
    <!-- UNJ dalam Angka Section (commented out) -->
    
    @include('subdirektorat-inovasi.footerHilirisasi')
    
    <script src="{{ asset('/inovasi/homeinovasi.js') }}"></script>
</body>
</html>