<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0, user-scalable=yes" name="viewport"/>
    <title>Universitas Negeri Jakarta - Direktorat Pemeringkatan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="{{ asset('home.css') }}">
</head>
<body class="font-sans bg-gray-100">
    @include('navbar')
    
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
            </div>
            
           
        </div>
        <!-- Regular News Grid with improved styling -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16">
            <!-- News card 1 -->
            <div class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="relative">
                    <img alt="Coffee Morning Event" class="w-full h-56 object-cover" src="https://storage.googleapis.com/a1aa/image/tL-ajsZBsORGzMsGCvwmOU7pkXmsD0JsdwlLM-jMV_8.jpg"/>
                    <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black to-transparent h-24"></div>
                    <div class="absolute top-3 right-3 bg-yellow-400 text-teal-800 px-3 py-1 rounded-full text-sm font-semibold">
                        Berita
                    </div>
                </div>
                <div class="p-5">
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center text-gray-500 text-sm">
                            <i class="fas fa-user-circle mr-2"></i>azisf
                        </div>
                        <div class="text-gray-500 text-sm">
                            <i class="fas fa-calendar-alt mr-1"></i>28 Feb 2025
                        </div>
                    </div>
                    <h2 class="font-bold text-xl mb-3 text-teal-800 hover:text-yellow-600 transition-colors">
                        Perkuat Silaturahmi dan Sinergi dengan Ormawa, UNJ Gelar Dialog "Coffee Morning"
                    </h2>
                    <p class="text-gray-600 mb-4">
                        Dialog "Coffee Morning" yang diselenggarakan UNJ bertujuan untuk memperkuat silaturahmi dan membangun sinergi dengan organisasi mahasiswa kampus.
                    </p>
                    <a href="{{ route('Berita.beritahome') }}" class="inline-block text-teal-700 hover:text-yellow-500 font-medium">
                        Baca selengkapnya <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
            
            <!-- News card 2 -->
            <div class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="relative">
                    <img alt="Mawapres UNJ Event" class="w-full h-56 object-cover" src="https://storage.googleapis.com/a1aa/image/tL-ajsZBsORGzMsGCvwmOU7pkXmsD0JsdwlLM-jMV_8.jpg"/>
                    <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black to-transparent h-24"></div>
                    <div class="absolute top-3 right-3 bg-yellow-400 text-teal-800 px-3 py-1 rounded-full text-sm font-semibold">
                        Berita
                    </div>
                </div>
                <div class="p-5">
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center text-gray-500 text-sm">
                            <i class="fas fa-user-circle mr-2"></i>Admin
                        </div>
                        <div class="text-gray-500 text-sm">
                            <i class="fas fa-calendar-alt mr-1"></i>27 Feb 2025
                        </div>
                    </div>
                    <h2 class="font-bold text-xl mb-3 text-teal-800 hover:text-yellow-600 transition-colors">
                        Rayhan dan Adelio Raih Gelar Mawapres Utama UNJ 2025
                    </h2>
                    <p class="text-gray-600 mb-4">
                        Kebanggaan Kampus Menuju Prestasi Nasional melalui Mahasiswa Berprestasi terbaik Universitas Negeri Jakarta tahun ini.
                    </p>
                    <a href="{{ route('Berita.beritahome') }}" class="inline-block text-teal-700 hover:text-yellow-500 font-medium">
                        Baca selengkapnya <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
            
            <!-- News card 3 -->
            <div class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="relative">
                    <img alt="Rektor UNJ Event" class="w-full h-56 object-cover" src="https://storage.googleapis.com/a1aa/image/tL-ajsZBsORGzMsGCvwmOU7pkXmsD0JsdwlLM-jMV_8.jpg"/>
                    <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black to-transparent h-24"></div>
                    <div class="absolute top-3 right-3 bg-yellow-400 text-teal-800 px-3 py-1 rounded-full text-sm font-semibold">
                        Berita, Feature
                    </div>
                </div>
                <div class="p-5">
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center text-gray-500 text-sm">
                            <i class="fas fa-user-circle mr-2"></i>Admin
                        </div>
                        <div class="text-gray-500 text-sm">
                            <i class="fas fa-calendar-alt mr-1"></i>27 Feb 2025
                        </div>
                    </div>
                    <h2 class="font-bold text-xl mb-3 text-teal-800 hover:text-yellow-600 transition-colors">
                        Rektor UNJ Dikukuhkan KONI Pusat Jadi Ketua Umum PB IPF
                    </h2>
                    <p class="text-gray-600 mb-4">
                        Pengukuhan Rektor UNJ sebagai Ketua Umum PB IPF oleh KONI Pusat untuk masa bakti 2022-2026 menunjukkan kepercayaan tinggi terhadap kepemimpinannya.
                    </p>
                    <a href="{{ route('Berita.beritahome') }}" class="inline-block text-teal-700 hover:text-yellow-500 font-medium">
                        Baca selengkapnya <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Enhanced Featured News Carousel - Moved to the bottom part -->
        <div class="enhanced-carousel">
            <div class="enhanced-carousel-title">Berita Unggulan</div>
            <div class="carousel">
                <div class="carousel-inner">
                    <!-- Carousel Item 1 -->
                    <div class="carousel-item-enhanced">
                        <div class="news-card-enhanced">
                            <div class="news-image-container">
                                <img alt="Coffee Morning Event" class="news-image" src="https://storage.googleapis.com/a1aa/image/tL-ajsZBsORGzMsGCvwmOU7pkXmsD0JsdwlLM-jMV_8.jpg"/>
                                <div class="news-tag-enhanced">Berita</div>
                            </div>
                            <div class="news-content">
                                <div class="news-meta">
                                    <i class="fas fa-user-circle mr-2"></i>azisf
                                    <span class="mx-2">|</span>
                                    <i class="fas fa-calendar-alt mr-2"></i>28 Feb 2025
                                </div>
                                <h3 class="news-title">Perkuat Silaturahmi dan Sinergi dengan Ormawa, UNJ Gelar Dialog "Coffee Morning"</h3>
                                <p class="news-excerpt">
                                    Universitas Negeri Jakarta menggelar dialog "Coffee Morning" untuk memperkuat silaturahmi dan sinergi dengan organisasi mahasiswa kampus. Kegiatan ini diharapkan dapat meningkatkan kolaborasi dalam berbagai program kampus.
                                </p>
                                <a href="#" class="news-link">
                                    Baca selengkapnya <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Carousel Item 2 -->
                    <div class="carousel-item-enhanced">
                        <div class="news-card-enhanced">
                            <div class="news-image-container">
                                <img alt="Mawapres UNJ Event" class="news-image" src="https://storage.googleapis.com/a1aa/image/tL-ajsZBsORGzMsGCvwmOU7pkXmsD0JsdwlLM-jMV_8.jpg"/>
                                <div class="news-tag-enhanced">Berita</div>
                            </div>
                            <div class="news-content">
                                <div class="news-meta">
                                    <i class="fas fa-user-circle mr-2"></i>Admin
                                    <span class="mx-2">|</span>
                                    <i class="fas fa-calendar-alt mr-2"></i>27 Feb 2025
                                </div>
                                <h3 class="news-title">Rayhan dan Adelio Raih Gelar Mawapres Utama UNJ 2025</h3>
                                <p class="news-excerpt">
                                    Kebanggaan Kampus Menuju Prestasi Nasional melalui Mahasiswa Berprestasi terbaik Universitas Negeri Jakarta tahun ini. Prestasi ini menjadi motivasi bagi mahasiswa lainnya untuk terus berprestasi.
                                </p>
                                <a href="#" class="news-link">
                                    Baca selengkapnya <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Carousel Item 3 -->
                    <div class="carousel-item-enhanced">
                        <div class="news-card-enhanced">
                            <div class="news-image-container">
                                <img alt="Rektor UNJ Event" class="news-image" src="https://storage.googleapis.com/a1aa/image/tL-ajsZBsORGzMsGCvwmOU7pkXmsD0JsdwlLM-jMV_8.jpg"/>
                                <div class="news-tag-enhanced">Berita, Feature</div>
                            </div>
                            <div class="news-content">
                                <div class="news-meta">
                                    <i class="fas fa-user-circle mr-2"></i>Admin
                                    <span class="mx-2">|</span>
                                    <i class="fas fa-calendar-alt mr-2"></i>27 Feb 2025
                                </div>
                                <h3 class="news-title">Rektor UNJ Dikukuhkan KONI Pusat Jadi Ketua Umum PB IPF Masa Bakti 2022-2026</h3>
                                <p class="news-excerpt">
                                    Prestasi pimpinan kampus yang juga berkontribusi dalam pengembangan olahraga nasional. Pengukuhan ini menunjukkan peran aktif UNJ dalam berbagai bidang termasuk olahraga.
                                </p>
                                <a href="#" class="news-link">
                                    Baca selengkapnya <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Carousel Item 4 -->
                    <div class="carousel-item-enhanced">
                        <div class="news-card-enhanced">
                            <div class="news-image-container">
                                <img alt="Maryam Qonita" class="news-image" src="https://storage.googleapis.com/a1aa/image/tL-ajsZBsORGzMsGCvwmOU7pkXmsD0JsdwlLM-jMV_8.jpg"/>
                                <div class="news-tag-enhanced">Feature</div>
                            </div>
                            <div class="news-content">
                                <div class="news-meta">
                                    <i class="fas fa-user-circle mr-2"></i>Admin
                                    <span class="mx-2">|</span>
                                    <i class="fas fa-calendar-alt mr-2"></i>25 Feb 2025
                                </div>
                                <h3 class="news-title">Maryam Qonita: Dari Mahasiswa Berprestasi Hingga Peneliti Muda</h3>
                                <p class="news-excerpt">
                                    Kisah inspiratif perjalanan akademik dan prestasi Maryam Qonita sebagai mahasiswa berprestasi UNJ yang kini menjadi peneliti muda dengan berbagai penghargaan.
                                </p>
                                <a href="#" class="news-link">
                                    Baca selengkapnya <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Carousel Item 5 -->
                    <div class="carousel-item-enhanced">
                        <div class="news-card-enhanced">
                            <div class="news-image-container">
                                <img alt="Prof. Mohamed Event" class="news-image" src="https://storage.googleapis.com/a1aa/image/tL-ajsZBsORGzMsGCvwmOU7pkXmsD0JsdwlLM-jMV_8.jpg"/>
                                <div class="news-tag-enhanced">Akademik</div>
                            </div>
                            <div class="news-content">
                                <div class="news-meta">
                                    <i class="fas fa-user-circle mr-2"></i>Admin
                                    <span class="mx-2">|</span>
                                    <i class="fas fa-calendar-alt mr-2"></i>25 Feb 2025
                                </div>
                                <h3 class="news-title">Maryam Qonita: Dari Mahasiswa Berprestasi Hingga Peneliti Muda</h3>
                                <p class="news-excerpt">
                                    Kisah inspiratif perjalanan akademik dan prestasi Maryam Qonita sebagai mahasiswa berprestasi UNJ yang kini menjadi peneliti muda dengan berbagai penghargaan.
                                </p>
                                <a href="#" class="news-link">
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
                <h2 class="section-title">Layanan </h2>
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
</html>
@include('footerlp')


