<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SDGs Program - Universitas Negeri Jakarta</title>
    <link rel="stylesheet" href="/inovasi/sdgscenter.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
    <link rel="stylesheet" href="{{ asset('home.css') }}">

    <style>
        /* Additional styles for publication cards */
        .publication-links {
            margin-top: 12px;
        }
        
        .download-link {
            display: inline-flex;
            align-items: center;
            padding: 5px 10px;
            background-color: #3498db;
            color: white;
            border-radius: 4px;
            text-decoration: none;
            font-size: 14px;
            transition: background-color 0.3s;
        }
        
        .download-link:hover {
            background-color: #2980b9;
        }
        
        .download-link i {
            margin-right: 5px;
        }
        
        .no-publications, .error-message {
            grid-column: 1 / -1;
            text-align: center;
            padding: 40px;
            background-color: #f9f9f9;
            border-radius: 10px;
            font-size: 16px;
            color: #555;
        }
        
        .error-message {
            color: #d33;
            background-color: #fee;
        }
        .course-tabs {
            display: flex;
            justify-content: center; /* Ini akan menengahkan item-item di dalamnya secara horizontal */
            align-items: center; /* Opsional: jika Anda juga ingin menengahkan secara vertikal (jika div memiliki tinggi tertentu) */
            gap: 10px; /* Opsional: untuk memberi jarak antar tombol */
            padding: 10px; /* Opsional: untuk memberi sedikit ruang di dalam div */
            }

        .tab-btn {
            padding: 8px 15px;
            border: 1px solid #ddd;
            background-color: #f0f0f0;
            cursor: pointer;
            }

        .tab-btn.active {
            background-color: #277177;
            color: white;
            border-color: #277177;
            }
            
        </style>
</head>

<body>
@include('layout.navbar_hilirisasi')
    <section id="home" class="hero" id="heroSection">
        <div class="hero-content">
            <h2>Sustainable Development Goals Program </h2>
            <p>Membangun masa depan berkelanjutan melalui kolaborasi, inovasi, dan pendidikan untuk mewujudkan tujuan
                pembangunan berkelanjutan di Indonesia.</p>
            <div class="btn-group">
                <a href="#about" class="btn">Pelajari Lebih Lanjut</a>
                <a href="#contact" class="btn">Hubungi Kami</a>
            </div>
        </div>
    </section>
    
    <!-- SDGs Program Section -->
<section id="what-is-sdgs" class="what-is-sdgs">
    <div class="container mx-auto px-4 py-8">
        <!-- Main SDGs Banner Image -->
        <div class="mb-12">
            <img src="/images/sdgs.png", 
                 alt="Sustainable Development Goals" class="w-full max-w-5xl mx-auto">
        </div>
        
        <!-- What is SDGs Section -->
        <div class="flex flex-col md:flex-row mb-10">
            <!-- Left Column - Title -->
            <div class="w-full md:w-1/3 mb-6 md:mb-0">
                <h2 class="text-2xl font-bold text-gray-800">What Is Sustainable Development Goals (SDGs) ?</h2>
            </div>
            
            <!-- Right Column - Description -->
            <div class="w-full md:w-2/3">
                <p class="text-base text-gray-700 leading-relaxed">
                Pendidikan tinggi memiliki peran strategis dalam pencapaian Tujuan Pembangunan Berkelanjutan atau Sustainable Development Goals (SDGs) yang dicanangkan oleh Perserikatan Bangsa-Bangsa (PBB). Dengan 17 tujuan utama yang mencakup isu-isu seperti pengentasan kemiskinan, pendidikan berkualitas, kesetaraan gender, aksi iklim, dan kemitraan global, perguruan tinggi diharapkan menjadi pusat inovasi, penelitian, dan pengabdian yang berorientasi pada keberlanjutan.
                </p>
                <p class="text-base text-gray-700 leading-relaxed">
                Program SDGs di perguruan tinggi merupakan upaya terstruktur untuk mengintegrasikan prinsip-prinsip pembangunan berkelanjutan ke dalam kurikulum, riset, tata kelola, serta kegiatan kemasyarakatan. Melalui pendekatan ini, perguruan tinggi tidak hanya mencetak lulusan yang kompeten, tetapi juga berwawasan lingkungan, sosial, dan ekonomi jangka panjang.
                </p>
            </div>
        </div>
        
        <hr class="border-gray-300 my-8">
    </div>
</section>

<!-- SDGs Program Section -->
<section id="sdgs-program" class="sdgs-program py-8">
    <div class="container mx-auto px-4">
        <div class="flex flex-col md:flex-row">
            <!-- Left Column - Logo -->
            <div class="w-full md:w-1/3 mb-6 md:mb-0 flex justify-center md:justify-start items-start pt-0">
                <img src="/images/unjsdg.png" alt="SDGs Logo" class="w-90 h-auto object-contain -mt-8">
            </div>
            
            <!-- Right Column - Content -->
            <div class="w-full md:w-2/3">
                <!-- Title -->
                <div class="mb-6">
                    <h2 class="text-2xl font-bold text-[#1D796B]">SDG's Program</h2>
                    <div class="w-24 h-1 bg-[#1D796B] mt-2"></div>
                    <p class="text-gray-700 mt-4">
                        Pendidikan tinggi memiliki peran strategis dalam pencapaian Tujuan Pembangunan Berkelanjutan
                    </p>
                </div>
                
                <!-- Implementasi SDGs Section -->
                <div class="mt-8">
                        <h3 class="text-lg font-semibold text-[#1D796B] mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-[#1D796B]" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM14 11a1 1 0 011 1v1h1a1 1 0 110 2h-1v1a1 1 0 11-2 0v-1h-1a1 1 0 110-2h1v-1a1 1 0 011-1z"></path>
                        </svg>
                        Implementasi SDGs di Kampus
                    </h3>
                    
                    <div class="space-y-3 mb-6">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Integrasi topik SDGs dalam mata kuliah dan modul pembelajaran.</span>
                        </div>
                        
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Penelitian interdisipliner yang berkontribusi pada pencapaian target SDGs.</span>
                        </div>
                        
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Pengembangan kampus hijau dan berkelanjutan.</span>
                        </div>
                        
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Pengabdian masyarakat yang fokus pada pemberdayaan lokal.</span>
                        </div>
                        
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Kolaborasi internasional untuk proyek-proyek keberlanjutan.</span>
                        </div>
                    </div>
                    
                    <div class="italic text-gray-700 mt-4">
                        Dengan mengadopsi SDGs sebagai kerangka kerja, perguruan tinggi tidak hanya berperan sebagai <span class="text-[#1D796B]">center of excellence</span>, tetapi juga sebagai <span class="text-[#1D796B]">agent of change</span> dalam pembangunan global yang adil, inklusif, dan berkelanjutan.
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
    <!-- <section id="rankings" class="rankings">
        <div class="container">
            <div class="section-title">
                <h3>Peringkat & Prestasi</h3>
                <p>Pengakuan nasional dan internasional atas kontribusi dan prestasi dalam implementasi SDGs</p>
            </div>
            <div class="rankings-container">
                <div class="ranking-card">
                    <div class="ranking-icon">🏆</div>
                    <h4 class="ranking-title">Peringkat Nasional</h4>
                    <div class="ranking-position">#3</div>
                    <div class="ranking-category">SDGs Research Program</div>
                    <p>Dinobatkan sebagai salah satu pusat penelitian SDGs terbaik di Indonesia oleh Kementerian
                        Pendidikan dan Kebudayaan.</p>
                    <div class="ranking-note">Tahun 2024</div>
                </div>

                <div class="ranking-card">
                    <div class="ranking-icon">🌏</div>
                    <h4 class="ranking-title">Peringkat Internasional</h4>
                    <div class="ranking-position">#27</div>
                    <div class="ranking-category">THE Impact Rankings</div>
                    <p>Diakui dalam Times Higher Education Impact Rankings untuk kontribusi terhadap SDGs di kawasan
                        Asia Tenggara.</p>
                    <div class="ranking-note">Tahun 2024</div>
                </div>

                <div class="ranking-card">
                    <div class="ranking-icon">🥇</div>
                    <h4 class="ranking-title">Penghargaan Khusus</h4>
                    <div class="ranking-position">Top 10</div>
                    <div class="ranking-category">Inovasi SDG 6 & 11</div>
                    <p>Masuk dalam 10 besar inovator untuk SDG 6 (Air Bersih) dan SDG 11 (Kota Berkelanjutan) oleh UN
                        Habitat.</p>
                    <div class="ranking-note">Tahun 2023</div>
                </div>
            </div>
        </div>
    </section> -->
    <!-- SDGs Full-Screen Carousel Section -->
    <section id="goals" class="goals">
        <div class="container">
            <div class="section-title">
                <h3>Tujuan Pembangunan Berkelanjutan</h3>
                <p>Komitmen global untuk mengakhiri kemiskinan, melindungi bumi, dan memastikan kemakmuran bagi semua
                </p>
            </div>

            <div class="sdgs-fullscreen-carousel">
                <!-- Main slide container -->
                <div class="sdgs-slider-container">
                    <!-- SDG 1 -->
                    <div class="sdgs-slide" style="--sdg-color: #e5243b;">
                        <div class="sdgs-slide-content">
                            <div class="sdgs-slide-number">1</div>
                            <div class="sdgs-slide-image">
                                <img src="https://sdgs.un.org/sites/default/files/goals/E_SDG_Icons-01.jpg"
                                    alt="SDG 1">
                            </div>
                            <div class="sdgs-slide-info">
                                <h2>Tanpa Kemiskinan</h2>
                                <p>Mengakhiri kemiskinan dalam segala bentuk di manapun. Tujuan ini berfokus pada
                                    penyediaan layanan dasar, perlindungan sosial, dan memastikan semua orang memiliki
                                    akses yang setara terhadap sumber daya ekonomi.</p>
                                <a href="#" class="sdgs-learn-more">Pelajari Lebih Lanjut</a>
                            </div>
                        </div>
                    </div>

                    <!-- SDG 2 -->
                    <div class="sdgs-slide" style="--sdg-color: #DDA63A;">
                        <div class="sdgs-slide-content">
                            <div class="sdgs-slide-number">2</div>
                            <div class="sdgs-slide-image">
                                <img src="https://sdgs.un.org/sites/default/files/goals/E_SDG_Icons-02.jpg"
                                    alt="SDG 2">
                            </div>
                            <div class="sdgs-slide-info">
                                <h2>Tanpa Kelaparan</h2>
                                <p>Mengakhiri kelaparan, mencapai ketahanan pangan dan gizi yang baik, serta mendorong
                                    pertanian berkelanjutan. Fokus pada akses terhadap makanan, perbaikan nutrisi, dan
                                    meningkatkan produktivitas pertanian secara berkelanjutan.</p>
                                <a href="#" class="sdgs-learn-more">Pelajari Lebih Lanjut</a>
                            </div>
                        </div>
                    </div>

                    <!-- SDG 3 -->
                    <div class="sdgs-slide" style="--sdg-color: #4C9F38;">
                        <div class="sdgs-slide-content">
                            <div class="sdgs-slide-number">3</div>
                            <div class="sdgs-slide-image">
                                <img src="https://sdgs.un.org/sites/default/files/goals/E_SDG_Icons-03.jpg"
                                    alt="SDG 3">
                            </div>
                            <div class="sdgs-slide-info">
                                <h2>Kehidupan Sehat dan Sejahtera</h2>
                                <p>Memastikan kehidupan yang sehat dan mendorong kesejahteraan bagi semua di segala
                                    usia. Berfokus pada pengurangan angka kematian ibu dan anak, mengakhiri epidemi
                                    penyakit menular, dan memastikan akses universal ke layanan kesehatan.</p>
                                <a href="#" class="sdgs-learn-more">Pelajari Lebih Lanjut</a>
                            </div>
                        </div>
                    </div>

                    <!-- SDG 4 -->
                    <div class="sdgs-slide" style="--sdg-color: #C5192D;">
                        <div class="sdgs-slide-content">
                            <div class="sdgs-slide-number">4</div>
                            <div class="sdgs-slide-image">
                                <img src="https://sdgs.un.org/sites/default/files/goals/E_SDG_Icons-04.jpg"
                                    alt="SDG 4">
                            </div>
                            <div class="sdgs-slide-info">
                                <h2>Pendidikan Berkualitas</h2>
                                <p>Memastikan pendidikan yang inklusif dan berkualitas serta mendorong kesempatan
                                    belajar seumur hidup bagi semua. Memastikan semua anak mendapatkan akses pendidikan
                                    dan pelatihan keterampilan yang sesuai.</p>
                                <a href="#" class="sdgs-learn-more">Pelajari Lebih Lanjut</a>
                            </div>
                        </div>
                    </div>

                    <!-- SDG 5 -->
                    <div class="sdgs-slide" style="--sdg-color: #FF3A21;">
                        <div class="sdgs-slide-content">
                            <div class="sdgs-slide-number">5</div>
                            <div class="sdgs-slide-image">
                                <img src="https://sdgs.un.org/sites/default/files/goals/E_SDG_Icons-05.jpg"
                                    alt="SDG 5">
                            </div>
                            <div class="sdgs-slide-info">
                                <h2>Kesetaraan Gender</h2>
                                <p>Mencapai kesetaraan gender dan memberdayakan kaum perempuan dan anak perempuan.
                                    Menghilangkan segala bentuk diskriminasi dan kekerasan terhadap perempuan dan
                                    memastikan partisipasi penuh mereka di semua tingkatan.</p>
                                <a href="#" class="sdgs-learn-more">Pelajari Lebih Lanjut</a>
                            </div>
                        </div>
                    </div>

                    <!-- SDG 6 -->
                    <div class="sdgs-slide" style="--sdg-color: #26BDE2;">
                        <div class="sdgs-slide-content">
                            <div class="sdgs-slide-number">6</div>
                            <div class="sdgs-slide-image">
                                <img src="https://sdgs.un.org/sites/default/files/goals/E_SDG_Icons-06.jpg"
                                    alt="SDG 6">
                            </div>
                            <div class="sdgs-slide-info">
                                <h2>Air Bersih dan Sanitasi Layak</h2>
                                <p>Memastikan ketersediaan dan pengelolaan air bersih dan sanitasi yang berkelanjutan
                                    bagi semua. Meningkatkan kualitas air, mengurangi polusi, dan melindungi ekosistem
                                    yang berkaitan dengan air.</p>
                                <a href="#" class="sdgs-learn-more">Pelajari Lebih Lanjut</a>
                            </div>
                        </div>
                    </div>

                    <!-- SDG 7 -->
                    <div class="sdgs-slide" style="--sdg-color: #FCC30B;">
                        <div class="sdgs-slide-content">
                            <div class="sdgs-slide-number">7</div>
                            <div class="sdgs-slide-image">
                                <img src="https://sdgs.un.org/sites/default/files/goals/E_SDG_Icons-07.jpg"
                                    alt="SDG 7">
                            </div>
                            <div class="sdgs-slide-info">
                                <h2>Energi Bersih dan Terjangkau</h2>
                                <p>Memastikan akses ke energi yang terjangkau, andal, berkelanjutan, dan modern bagi
                                    semua. Meningkatkan penggunaan energi terbarukan dan efisiensi energi dalam sistem
                                    energi global.</p>
                                <a href="#" class="sdgs-learn-more">Pelajari Lebih Lanjut</a>
                            </div>
                        </div>
                    </div>

                    <!-- SDG 8 -->
                    <div class="sdgs-slide" style="--sdg-color: #A21942;">
                        <div class="sdgs-slide-content">
                            <div class="sdgs-slide-number">8</div>
                            <div class="sdgs-slide-image">
                                <img src="https://sdgs.un.org/sites/default/files/goals/E_SDG_Icons-08.jpg"
                                    alt="SDG 8">
                            </div>
                            <div class="sdgs-slide-info">
                                <h2>Pekerjaan Layak dan Pertumbuhan Ekonomi</h2>
                                <p>Mendorong pertumbuhan ekonomi yang inklusif dan berkelanjutan, lapangan kerja penuh
                                    dan produktif, serta pekerjaan yang layak bagi semua. Fokus pada inovasi,
                                    kewirausahaan, dan penciptaan lapangan kerja.</p>
                                <a href="#" class="sdgs-learn-more">Pelajari Lebih Lanjut</a>
                            </div>
                        </div>
                    </div>

                    <!-- SDG 9 -->
                    <div class="sdgs-slide" style="--sdg-color: #FD6925;">
                        <div class="sdgs-slide-content">
                            <div class="sdgs-slide-number">9</div>
                            <div class="sdgs-slide-image">
                                <img src="https://sdgs.un.org/sites/default/files/goals/E_SDG_Icons-09.jpg"
                                    alt="SDG 9">
                            </div>
                            <div class="sdgs-slide-info">
                                <h2>Industri, Inovasi dan Infrastruktur</h2>
                                <p>Membangun infrastruktur yang tangguh, mendorong industrialisasi yang inklusif dan
                                    berkelanjutan, serta memupuk inovasi. Meningkatkan akses ke teknologi informasi dan
                                    komunikasi.</p>
                                <a href="#" class="sdgs-learn-more">Pelajari Lebih Lanjut</a>
                            </div>
                        </div>
                    </div>

                    <!-- SDG 10 -->
                    <div class="sdgs-slide" style="--sdg-color: #DD1367;">
                        <div class="sdgs-slide-content">
                            <div class="sdgs-slide-number">10</div>
                            <div class="sdgs-slide-image">
                                <img src="https://sdgs.un.org/sites/default/files/goals/E_SDG_Icons-10.jpg"
                                    alt="SDG 10">
                            </div>
                            <div class="sdgs-slide-info">
                                <h2>Berkurangnya Kesenjangan</h2>
                                <p>Mengurangi kesenjangan dalam dan antar negara. Mendorong inklusi sosial, ekonomi, dan
                                    politik bagi semua, terlepas dari usia, jenis kelamin, disabilitas, ras, etnis, atau
                                    status lainnya.</p>
                                <a href="#" class="sdgs-learn-more">Pelajari Lebih Lanjut</a>
                            </div>
                        </div>
                    </div>

                    <!-- SDG 11 -->
                    <div class="sdgs-slide" style="--sdg-color: #FD9D24;">
                        <div class="sdgs-slide-content">
                            <div class="sdgs-slide-number">11</div>
                            <div class="sdgs-slide-image">
                                <img src="https://sdgs.un.org/sites/default/files/goals/E_SDG_Icons-11.jpg"
                                    alt="SDG 11">
                            </div>
                            <div class="sdgs-slide-info">
                                <h2>Kota dan Permukiman yang Berkelanjutan</h2>
                                <p>Menjadikan kota dan permukiman inklusif, aman, tangguh, dan berkelanjutan. Memastikan
                                    akses ke perumahan yang layak dan terjangkau, transportasi publik, dan ruang publik
                                    yang aman.</p>
                                <a href="#" class="sdgs-learn-more">Pelajari Lebih Lanjut</a>
                            </div>
                        </div>
                    </div>

                    <!-- SDG 12 -->
                    <div class="sdgs-slide" style="--sdg-color: #BF8B2E;">
                        <div class="sdgs-slide-content">
                            <div class="sdgs-slide-number">12</div>
                            <div class="sdgs-slide-image">
                                <img src="https://sdgs.un.org/sites/default/files/goals/E_SDG_Icons-12.jpg"
                                    alt="SDG 12">
                            </div>
                            <div class="sdgs-slide-info">
                                <h2>Konsumsi dan Produksi yang Bertanggung Jawab</h2>
                                <p>Memastikan pola konsumsi dan produksi yang berkelanjutan. Mengurangi limbah,
                                    mendorong daur ulang, dan mendorong praktik bisnis yang berkelanjutan dan pengadaan
                                    publik yang berkelanjutan.</p>
                                <a href="#" class="sdgs-learn-more">Pelajari Lebih Lanjut</a>
                            </div>
                        </div>
                    </div>

                    <!-- SDG 13 -->
                    <div class="sdgs-slide" style="--sdg-color: #3F7E44;">
                        <div class="sdgs-slide-content">
                            <div class="sdgs-slide-number">13</div>
                            <div class="sdgs-slide-image">
                                <img src="https://sdgs.un.org/sites/default/files/goals/E_SDG_Icons-13.jpg"
                                    alt="SDG 13">
                            </div>
                            <div class="sdgs-slide-info">
                                <h2>Penanganan Perubahan Iklim</h2>
                                <p>Mengambil tindakan segera untuk memerangi perubahan iklim dan dampaknya. Memperkuat
                                    ketahanan dan kapasitas adaptasi terhadap bahaya terkait iklim dan bencana alam di
                                    semua negara.</p>
                                <a href="#" class="sdgs-learn-more">Pelajari Lebih Lanjut</a>
                            </div>
                        </div>
                    </div>

                    <!-- SDG 14 -->
                    <div class="sdgs-slide" style="--sdg-color: #0A97D9;">
                        <div class="sdgs-slide-content">
                            <div class="sdgs-slide-number">14</div>
                            <div class="sdgs-slide-image">
                                <img src="https://sdgs.un.org/sites/default/files/goals/E_SDG_Icons-14.jpg"
                                    alt="SDG 14">
                            </div>
                            <div class="sdgs-slide-info">
                                <h2>Ekosistem Laut</h2>
                                <p>Melestarikan dan memanfaatkan secara berkelanjutan sumber daya laut untuk pembangunan
                                    berkelanjutan. Mengurangi polusi laut, melindungi ekosistem pesisir dan laut, dan
                                    mengakhiri penangkapan ikan berlebihan.</p>
                                <a href="#" class="sdgs-learn-more">Pelajari Lebih Lanjut</a>
                            </div>
                        </div>
                    </div>

                    <!-- SDG 15 -->
                    <div class="sdgs-slide" style="--sdg-color: #56C02B;">
                        <div class="sdgs-slide-content">
                            <div class="sdgs-slide-number">15</div>
                            <div class="sdgs-slide-image">
                                <img src="https://sdgs.un.org/sites/default/files/goals/E_SDG_Icons-15.jpg"
                                    alt="SDG 15">
                            </div>
                            <div class="sdgs-slide-info">
                                <h2>Ekosistem Daratan</h2>
                                <p>Melindungi, memulihkan, dan mendorong pemanfaatan berkelanjutan ekosistem darat,
                                    mengelola hutan secara berkelanjutan, memerangi penggurunan, dan menghentikan dan
                                    membalikkan degradasi lahan dan menghentikan hilangnya keanekaragaman hayati.</p>
                                <a href="#" class="sdgs-learn-more">Pelajari Lebih Lanjut</a>
                            </div>
                        </div>
                    </div>

                    <!-- SDG 16 -->
                    <div class="sdgs-slide" style="--sdg-color: #00689D;">
                        <div class="sdgs-slide-content">
                            <div class="sdgs-slide-number">16</div>
                            <div class="sdgs-slide-image">
                                <img src="https://sdgs.un.org/sites/default/files/goals/E_SDG_Icons-16.jpg"
                                    alt="SDG 16">
                            </div>
                            <div class="sdgs-slide-info">
                                <h2>Perdamaian, Keadilan dan Kelembagaan yang Tangguh</h2>
                                <p>Mendorong masyarakat yang damai dan inklusif untuk pembangunan berkelanjutan,
                                    menyediakan akses keadilan bagi semua dan membangun institusi yang efektif,
                                    akuntabel, dan inklusif di semua tingkatan.</p>
                                <a href="#" class="sdgs-learn-more">Pelajari Lebih Lanjut</a>
                            </div>
                        </div>
                    </div>

                    <!-- SDG 17 -->
                    <div class="sdgs-slide" style="--sdg-color: #19486A;">
                        <div class="sdgs-slide-content">
                            <div class="sdgs-slide-number">17</div>
                            <div class="sdgs-slide-image">
                                <img src="https://sdgs.un.org/sites/default/files/goals/E_SDG_Icons-17.jpg"
                                    alt="SDG 17">
                            </div>
                            <div class="sdgs-slide-info">
                                <h2>Kemitraan untuk Mencapai Tujuan</h2>
                                <p>Memperkuat sarana pelaksanaan dan merevitalisasi kemitraan global untuk pembangunan
                                    berkelanjutan. Memobilisasi sumber daya, berbagi pengetahuan dan teknologi, dan
                                    membangun kapasitas untuk mencapai SDGs.</p>
                                <a href="#" class="sdgs-learn-more">Pelajari Lebih Lanjut</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Numbered navigation elements -->
                <div class="sdgs-slider-nav">
                    <div class="sdgs-pagination">
                        <div class="sdgs-pagination-number" data-index="0" style="background-color: #e5243b;">1</div>
                        <div class="sdgs-pagination-number" data-index="1" style="background-color: #DDA63A;">2</div>
                        <div class="sdgs-pagination-number" data-index="2" style="background-color: #4C9F38;">3</div>
                        <div class="sdgs-pagination-number" data-index="3" style="background-color: #C5192D;">4</div>
                        <div class="sdgs-pagination-number" data-index="4" style="background-color: #FF3A21;">5</div>
                        <div class="sdgs-pagination-number" data-index="5" style="background-color: #26BDE2;">6</div>
                        <div class="sdgs-pagination-number" data-index="6" style="background-color: #FCC30B;">7</div>
                        <div class="sdgs-pagination-number" data-index="7" style="background-color: #A21942;">8</div>
                        <div class="sdgs-pagination-number" data-index="8" style="background-color: #FD6925;">9</div>
                        <div class="sdgs-pagination-number" data-index="9" style="background-color: #DD1367;">10
                        </div>
                        <div class="sdgs-pagination-number" data-index="10" style="background-color: #FD9D24;">11
                        </div>
                        <div class="sdgs-pagination-number" data-index="11" style="background-color: #BF8B2E;">12
                        </div>
                        <div class="sdgs-pagination-number" data-index="12" style="background-color: #3F7E44;">13
                        </div>
                        <div class="sdgs-pagination-number" data-index="13" style="background-color: #0A97D9;">14
                        </div>
                        <div class="sdgs-pagination-number" data-index="14" style="background-color: #56C02B;">15
                        </div>
                        <div class="sdgs-pagination-number" data-index="15" style="background-color: #00689D;">16
                        </div>
                        <div class="sdgs-pagination-number" data-index="16" style="background-color: #19486A;">17
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="programs" class="programs">
        <div class="container">
            <div class="section-title">
                <h3>Program & Kegiatan</h3>
                <p>Berbagai program unggulan yang kami kembangkan untuk mendukung pencapaian SDGs</p>
            </div>
            <div class="program-tabs">
                <button class="tab-btn active">Penelitian</button>
                <button class="tab-btn">Pengabdian Masyarakat</button>
                <button class="tab-btn">Pendidikan</button>
                <button class="tab-btn">Kolaborasi</button>
            </div>
            <div class="program-content">
                <div class="program-card">
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQzcD8s_rx58JooQqXcm41RUL34WM7aN72Hug&s"
                        alt="Program 1">
                    <div class="program-info">
                        <span class="date">Maret 2025</span>
                        <h4>Inovasi Teknologi untuk Air Bersih</h4>
                        <p>Program penelitian untuk mengembangkan teknologi terjangkau bagi masyarakat pedesaan dalam
                            mendapatkan akses air bersih dan sanitasi.</p>
                    </div>
                </div>
                <div class="program-card">
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQzcD8s_rx58JooQqXcm41RUL34WM7aN72Hug&s"
                        alt="Program 2">
                    <div class="program-info">
                        <span class="date">Februari 2025</span>
                        <h4>Keberlanjutan Pangan Masyarakat Pesisir</h4>
                        <p>Studi tentang ketahanan pangan dan adaptasi perubahan iklim bagi masyarakat pesisir dan
                            nelayan tradisional.</p>
                    </div>
                </div>
                <div class="program-card">
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQzcD8s_rx58JooQqXcm41RUL34WM7aN72Hug&s"
                        alt="Program 3">
                    <div class="program-info">
                        <span class="date">Januari 2025</span>
                        <h4>Energi Terbarukan untuk Sekolah</h4>
                        <p>Proyek percontohan pemasangan panel surya dan sistem pengelolaan energi di sekolah-sekolah
                            daerah tertinggal.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="publication" class="publication">
        <div class="container">
            <div class="section-title">
                <h3>Publikasi & Riset</h3>
                <p>Temukan hasil penelitian dan publikasi terbaru kami tentang pembangunan berkelanjutan</p>
            </div>
            <div class="publication-grid">
                <div class="publication-card">
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQzcD8s_rx58JooQqXcm41RUL34WM7aN72Hug&s"
                        alt="Publikasi 1">
                    <div class="publication-info">
                        <h4>Implementasi SDGs di Tingkat Kota: Studi Kasus Jakarta</h4>
                        <span class="authors">Dr. Ahmad Syafii, Dr. Rina Wijaya</span>
                        <p>Penelitian ini menganalisis bagaimana kota Jakarta mengintegrasikan tujuan pembangunan
                            berkelanjutan ke dalam perencanaan kota dan dampaknya terhadap kebijakan publik.</p>
                    </div>
                </div>
                <div class="publication-card">
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQzcD8s_rx58JooQqXcm41RUL34WM7aN72Hug&s"
                        alt="Publikasi 2">
                    <div class="publication-info">
                        <h4>Pendidikan untuk Pembangunan Berkelanjutan: Model Kurikulum Terintegrasi</h4>
                        <span class="authors">Prof. Budi Santoso, Endang Kusuma, M.Pd.</span>
                        <p>Studi ini mengembangkan dan mengevaluasi model kurikulum yang mengintegrasikan prinsip SDGs
                            dalam sistem pendidikan formal di Indonesia.</p>
                    </div>
                </div>
                <div class="publication-card">
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQzcD8s_rx58JooQqXcm41RUL34WM7aN72Hug&s"
                        alt="Publikasi 3">
                    <div class="publication-info">
                        <h4>Ekonomi Sirkular sebagai Solusi Pengelolaan Sampah Perkotaan</h4>
                        <span class="authors">Dr. Dian Pratiwi, Hendri Wijaya, M.Si.</span>
                        <p>Penelitian ini mempelajari penerapan prinsip ekonomi sirkular dalam manajemen sampah
                            perkotaan dan potensinya untuk mengurangi limbah.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="sustainability-courses" class="courses">
        <div class="container">
            <div class="section-title">
                <h3>Mata Kuliah Sustainability</h3>
                <p>Jelajahi berbagai mata kuliah yang dirancang untuk memperdalam pemahaman dan keahlian dalam pembangunan berkelanjutan.</p>
            </div>
            <div class="relative flex items-center justify-center mt-4">
                <button class="course-tab-arrow left-arrow flex items-center justify-center rounded-full shadow bg-white border border-gray-300 hover:bg-[#277177] hover:text-white transition disabled:opacity-50 disabled:cursor-not-allowed" style="width:32px;height:32px;font-size:1.1rem;cursor:pointer;">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <div class="course-tabs-wrapper overflow-hidden flex-1 flex justify-center" style="max-width: 600px;">
                    <div class="course-tabs flex transition-all duration-300 justify-center gap-2" style="width:max-content;">
                        <button class="tab-btn active" data-faculty="FIP">FIP</button>
                        <button class="tab-btn" data-faculty="FEB">FEB</button>
                        <button class="tab-btn" data-faculty="FMIPA">FMIPA</button>
                        <button class="tab-btn" data-faculty="FIS">FIS</button>
                        <button class="tab-btn" data-faculty="FT">FT</button>
                        <button class="tab-btn" data-faculty="FBS">FBS</button>
                        <button class="tab-btn" data-faculty="FP">FP</button>
                        <button class="tab-btn" data-faculty="FIO">FIO</button>
                    </div>
                </div>
                <button class="course-tab-arrow right-arrow flex items-center justify-center rounded-full shadow bg-white border border-gray-300 hover:bg-[#277177] hover:text-white transition disabled:opacity-50 disabled:cursor-not-allowed" style="width:32px;height:32px;font-size:1.1rem;cursor:pointer;">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
            <div class="course-cards-grid grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 mt-8 justify-center"></div>
        </div>
        <style>
            .course-tabs .tab-btn {
                margin: 0 1px;
                padding: 7px 18px;
                border-radius: 20px;
                border: 1.5px solid #277177;
                background: #fff;
                color: #277177;
                font-weight: 500;
                font-size: 15px;
                transition: background 0.2s, color 0.2s, box-shadow 0.2s;
                box-shadow: 0 1px 4px rgba(39,113,119,0.07);
                outline: none;
            }
            .course-tabs .tab-btn.active,
            .course-tabs .tab-btn:hover {
                background: linear-gradient(90deg, #277177 80%, #1D796B 100%);
                color: #fff;
                border-color: #277177;
                box-shadow: 0 2px 8px rgba(39,113,119,0.13);
            }
            .course-tab-arrow {
                box-shadow: 0 1px 4px rgba(39,113,119,0.10);
                border: 1.5px solid #277177;
                color: #277177;
                background: #fff;
                transition: background 0.2s, color 0.2s, border 0.2s;
                margin: 0 2px !important;
            }
            .course-tab-arrow:hover:not(:disabled) {
                background: #277177;
                color: #fff;
                border-color: #277177;
            }
            .course-tab-arrow:disabled {
                opacity: 0.5;
                cursor: not-allowed;
            }
            .course-cards-grid {
                margin-top: 2rem;
                justify-items: center;
                display: grid;
                grid-template-columns: repeat(1, minmax(0, 1fr));
                gap: 10px; /* Ubah gap dari 18px ke 10px agar jarak antar card lebih rapat */
            }
            @media (min-width: 640px) {
                .course-cards-grid {
                    grid-template-columns: repeat(2, minmax(0, 1fr));
                }
            }
            @media (min-width: 1024px) {
                .course-cards-grid {
                    grid-template-columns: repeat(4, minmax(0, 1fr));
                }
            }
            .course-card {
                background: #fff;
                border-radius: 12px;
                box-shadow: 0 2px 12px rgba(39,113,119,0.08);
                overflow: hidden;
                display: flex;
                flex-direction: column;
                transition: box-shadow 0.2s;
                border: 1.5px solid #e5e7eb;
                max-width: 320px;
                width: 100%;
                margin-left: auto;
                margin-right: auto;
            }
            .course-card:hover {
                box-shadow: 0 6px 24px rgba(39,113,119,0.18);
                border-color: #277177;
            }
            .course-card img {
                width: 100%;
                height: 160px;
                object-fit: cover;
            }
            .course-card-body {
                padding: 18px 16px 14px 16px;
                flex: 1;
                display: flex;
                flex-direction: column;
            }
            .course-title {
                font-size: 1.08rem;
                font-weight: 600;
                color: #277177;
                margin-bottom: 6px;
            }
            .course-desc {
                font-size: 0.97rem;
                color: #444;
                margin-bottom: 10px;
                flex: 1;
            }
            .course-meta {
                font-size: 0.89rem;
                color: #888;
            }
        </style>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Dummy data for each faculty
                const courseData = {
                    FIP: [
                        {
                            image: 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=400&q=80',
                            title: 'Pendidikan Lingkungan Hidup',
                            desc: 'Mempelajari konsep, isu, dan strategi pendidikan lingkungan untuk keberlanjutan.',
                            meta: '2 SKS | Semester 4'
                        },
                    ],
                    FEB: [
                        {
                            image: 'https://images.unsplash.com/photo-1465101046530-73398c7f28ca?auto=format&fit=crop&w=400&q=80',
                            title: 'Ekonomi Sirkular',
                            desc: 'Konsep ekonomi sirkular dan penerapannya dalam bisnis modern.',
                            meta: '2 SKS | Semester 5'
                        },
                    ],
                    FMIPA: [
                        {
                            image: 'https://images.unsplash.com/photo-1465101178521-c1a9136a3b99?auto=format&fit=crop&w=400&q=80',
                            title: 'Sains Lingkungan',
                            desc: 'Dasar-dasar sains lingkungan dan aplikasinya dalam kehidupan.',
                            meta: '3 SKS | Semester 3'
                        },
                        
                    ],
                    FIS: [
                        {
                            image: 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=400&q=80',
                            title: 'Sosiologi Lingkungan',
                            desc: 'Analisis hubungan masyarakat dan lingkungan dalam konteks pembangunan.',
                            meta: '2 SKS | Semester 4'
                        }
                    ],
                    FT: [
                        {
                            image: 'https://images.unsplash.com/photo-1504384308090-c894fdcc538d?auto=format&fit=crop&w=400&q=80',
                            title: 'Teknologi Energi Terbarukan',
                            desc: 'Pengenalan teknologi energi terbarukan dan aplikasinya.',
                            meta: '3 SKS | Semester 6'
                        }
                    ],
                    FBS: [
                        {
                            image: 'https://images.unsplash.com/photo-1464983953574-0892a716854b?auto=format&fit=crop&w=400&q=80',
                            title: 'Komunikasi Lingkungan',
                            desc: 'Strategi komunikasi untuk isu-isu lingkungan dan keberlanjutan.',
                            meta: '2 SKS | Semester 5'
                        }
                    ],
                    FP: [
                        {
                            image: 'https://images.unsplash.com/photo-1465101178521-c1a9136a3b99?auto=format&fit=crop&w=400&q=80',
                            title: 'Pertanian Berkelanjutan',
                            desc: 'Teknik pertanian ramah lingkungan dan efisien.',
                            meta: '3 SKS | Semester 4'
                        }
                    ],
                    FIO: [
                        {
                            image: 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=400&q=80',
                            title: 'Olahraga dan Lingkungan',
                            desc: 'Hubungan antara aktivitas olahraga dan pelestarian lingkungan.',
                            meta: '2 SKS | Semester 3'
                        }
                    ]
                };

                const tabsContainer = document.querySelector('.course-tabs');
                const tabButtons = Array.from(document.querySelectorAll('.course-tabs .tab-btn'));
                const leftArrow = document.querySelector('.course-tab-arrow.left-arrow');
                const rightArrow = document.querySelector('.course-tab-arrow.right-arrow');
                const visibleCount = 5;
                let startIdx = 0;

                function updateTabs() {
                    tabButtons.forEach((btn, idx) => {
                        if (idx >= startIdx && idx < startIdx + visibleCount) {
                            btn.style.display = '';
                        } else {
                            btn.style.display = 'none';
                        }
                    });
                    leftArrow.disabled = startIdx === 0;
                    rightArrow.disabled = startIdx + visibleCount >= tabButtons.length;
                }

                leftArrow.addEventListener('click', function() {
                    if (startIdx > 0) {
                        startIdx--;
                        updateTabs();
                    }
                });

                rightArrow.addEventListener('click', function() {
                    if (startIdx + visibleCount < tabButtons.length) {
                        startIdx++;
                        updateTabs();
                    }
                });

                // Card rendering
                const cardsGrid = document.querySelector('.course-cards-grid');
                function renderCards(faculty) {
                    cardsGrid.innerHTML = '';
                    const courses = courseData[faculty] || [];
                    if (courses.length === 0) {
                        cardsGrid.innerHTML = '<div class="col-span-full text-center text-gray-500 py-8">Belum ada mata kuliah untuk fakultas ini.</div>';
                        return;
                    }
                    courses.slice(0, 4).forEach(course => {
                        const card = document.createElement('div');
                        card.className = 'course-card';
                        card.innerHTML = `
                            <img src="${course.image}" alt="${course.title}">
                            <div class="course-card-body">
                                <div class="course-title">${course.title}</div>
                                <div class="course-desc">${course.desc}</div>
                                <div class="course-meta">${course.meta}</div>
                            </div>
                        `;
                        cardsGrid.appendChild(card);
                    });
                }

                // Tab click event
                tabButtons.forEach(btn => {
                    btn.addEventListener('click', function() {
                        tabButtons.forEach(b => b.classList.remove('active'));
                        this.classList.add('active');
                        renderCards(this.dataset.faculty);
                    });
                });

                // Initial state
                updateTabs();
                renderCards('FIP');
            });
        </script>
    </section>
    <section id="about" class="about">
        <div class="container">
            <div class="section-title">
                <h3>Tentang SDGs Program</h3>
                <p>Pusat Studi Pembangunan Berkelanjutan Universitas Negeri Jakarta</p>
            </div>
            <div class="about-content">
                <div class="about-text">
                    <p>SDGs Program Universitas Negeri Jakarta didirikan sebagai pusat keunggulan dalam penelitian,
                        pendidikan, dan implementasi Tujuan Pembangunan Berkelanjutan (Sustainable Development Goals).
                        Kami berkomitmen untuk berkontribusi pada pencapaian 17 tujuan pembangunan berkelanjutan melalui
                        inisiatif akademik dan proyek kolaboratif.</p>
                    <p>Sebagai unit penelitian di bawah Universitas Negeri Jakarta, kami menggabungkan keahlian akademis
                        dengan tindakan praktis untuk mengatasi tantangan pembangunan berkelanjutan di tingkat lokal,
                        nasional, dan global.</p>
                    <p>Kami bekerja erat dengan pemangku kepentingan dari pemerintah, sektor swasta, masyarakat sipil,
                        dan institusi pendidikan lainnya untuk mengidentifikasi solusi inovatif dan praktik terbaik
                        dalam mencapai tujuan SDGs.</p>
                </div>
                <div class="about-image">
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQzcD8s_rx58JooQqXcm41RUL34WM7aN72Hug&s"
                        alt="SDGS Center UNJ">
                </div>
            </div>
        </div>
    </section>
    @include('layout.footer')


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const track = document.querySelector('.carousel-track');
            const slides = Array.from(document.querySelectorAll('.carousel-slide'));
            const nextButton = document.querySelector('.carousel-button.next');
            const prevButton = document.querySelector('.carousel-button.prev');
            const indicatorsContainer = document.querySelector('.carousel-indicators');

            // Configuration
            const slidesToShow = window.innerWidth < 768 ? 1 : 3;
            const slideWidth = slides[0].getBoundingClientRect().width;
            const slideMargin = parseInt(window.getComputedStyle(slides[0]).marginRight) * 2;
            const totalSlideWidth = slideWidth + slideMargin;

            // Set up indicators
            const numOfGroups = Math.ceil(slides.length / slidesToShow);
            for (let i = 0; i < numOfGroups; i++) {
                const indicator = document.createElement('div');
                indicator.classList.add('indicator');
                if (i === 0) indicator.classList.add('active');
                indicator.dataset.index = i;
                indicatorsContainer.appendChild(indicator);
            }

            const indicators = Array.from(document.querySelectorAll('.indicator'));

            // Position slides
            function setSlidePosition() {
                slides.forEach((slide, index) => {
                    slide.style.left = index * totalSlideWidth + 'px';
                });
            }

            setSlidePosition();

            // Move to a specific index
            let currentIndex = 0;

            function moveToIndex(index) {
                if (index < 0) index = 0;
                if (index > slides.length - slidesToShow) index = slides.length - slidesToShow;

                track.style.transform = 'translateX(-' + (index * totalSlideWidth) + 'px)';
                currentIndex = index;

                // Update indicators
                const activeIndicatorIndex = Math.floor(currentIndex / slidesToShow);
                indicators.forEach((indicator, i) => {
                    if (i === activeIndicatorIndex) {
                        indicator.classList.add('active');
                    } else {
                        indicator.classList.remove('active');
                    }
                });
            }

            // Event listeners
            nextButton.addEventListener('click', () => {
                if (currentIndex + slidesToShow >= slides.length) {
                    moveToIndex(0); // Loop back to start
                } else {
                    moveToIndex(currentIndex + slidesToShow);
                }
            });

            prevButton.addEventListener('click', () => {
                if (currentIndex === 0) {
                    // Go to last group
                    const lastGroupIndex = Math.floor((slides.length - 1) / slidesToShow) * slidesToShow;
                    moveToIndex(lastGroupIndex);
                } else {
                    moveToIndex(currentIndex - slidesToShow);
                }
            });

            // Indicator clicks
            indicators.forEach(indicator => {
                indicator.addEventListener('click', () => {
                    const index = parseInt(indicator.dataset.index);
                    moveToIndex(index * slidesToShow);
                });
            });

            // Auto play
            let autoPlayInterval;

            function startAutoPlay() {
                autoPlayInterval = setInterval(() => {
                    if (currentIndex + slidesToShow >= slides.length) {
                        moveToIndex(0);
                    } else {
                        moveToIndex(currentIndex + slidesToShow);
                    }
                }, 5000);
            }

            function stopAutoPlay() {
                clearInterval(autoPlayInterval);
            }

            // Start auto play
            startAutoPlay();

            // Pause on hover
            const carouselContainer = document.querySelector('.carousel-container');
            carouselContainer.addEventListener('mouseenter', stopAutoPlay);
            carouselContainer.addEventListener('mouseleave', startAutoPlay);

            // Responsive behavior
            window.addEventListener('resize', () => {
                const newSlidesToShow = window.innerWidth < 768 ? 1 : 3;
                if (newSlidesToShow !== slidesToShow) {
                    location.reload(); // Simple solution to reset the carousel with new configuration
                }
            });
        });
        document.addEventListener('DOMContentLoaded', function() {
            const programData = {
                'Penelitian': [{
                        image: 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQzcD8s_rx58JooQqXcm41RUL34WM7aN72Hug&s',
                        date: 'Maret 2025',
                        title: 'Inovasi Teknologi untuk Air Bersih',
                        description: 'Program penelitian untuk mengembangkan teknologi terjangkau bagi masyarakat pedesaan dalam mendapatkan akses air bersih dan sanitasi.'
                    },
                    {
                        image: 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQzcD8s_rx58JooQqXcm41RUL34WM7aN72Hug&s',
                        date: 'Februari 2025',
                        title: 'Keberlanjutan Pangan Masyarakat Pesisir',
                        description: 'Studi tentang ketahanan pangan dan adaptasi perubahan iklim bagi masyarakat pesisir dan nelayan tradisional.'
                    },
                    {
                        image: 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQzcD8s_rx58JooQqXcm41RUL34WM7aN72Hug&s',
                        date: 'Januari 2025',
                        title: 'Energi Terbarukan untuk Sekolah',
                        description: 'Proyek percontohan pemasangan panel surya dan sistem pengelolaan energi di sekolah-sekolah daerah tertinggal.'
                    }
                ],
                'Pengabdian Masyarakat': [{
                        image: 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQzcD8s_rx58JooQqXcm41RUL34WM7aN72Hug&s',
                        date: 'Februari 2025',
                        title: 'Bank Sampah Kampung Hijau',
                        description: 'Program pendampingan masyarakat dalam pengelolaan sampah rumah tangga melalui bank sampah di kawasan perkotaan.'
                    },
                    {
                        image: 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQzcD8s_rx58JooQqXcm41RUL34WM7aN72Hug&s',
                        date: 'Desember 2024',
                        title: 'Pelatihan Kewirausahaan Berkelanjutan',
                        description: 'Pemberdayaan ekonomi bagi masyarakat prasejahtera melalui pelatihan kewirausahaan berbasis prinsip pembangunan berkelanjutan.'
                    },
                    {
                        image: 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQzcD8s_rx58JooQqXcm41RUL34WM7aN72Hug&s',
                        date: 'Oktober 2024',
                        title: 'Revitalisasi Ekosistem Pesisir',
                        description: 'Kolaborasi dengan masyarakat pesisir dalam menanam mangrove dan merehabilitasi terumbu karang untuk melindungi ekosistem laut.'
                    }
                ],
                'Pendidikan': [{
                        image: 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQzcD8s_rx58JooQqXcm41RUL34WM7aN72Hug&s',
                        date: 'Maret 2025',
                        title: 'Workshop SDGs untuk Guru',
                        description: 'Pelatihan guru-guru sekolah dalam mengintegrasikan nilai-nilai SDGs ke dalam kurikulum pendidikan dasar dan menengah.'
                    },
                    {
                        image: 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQzcD8s_rx58JooQqXcm41RUL34WM7aN72Hug&s',
                        date: 'Januari 2025',
                        title: 'Lomba Karya Ilmiah SDGs',
                        description: 'Kompetisi nasional untuk mahasiswa dalam mengembangkan solusi inovatif untuk tantangan pembangunan berkelanjutan.'
                    },
                    {
                        image: 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQzcD8s_rx58JooQqXcm41RUL34WM7aN72Hug&s',
                        date: 'Desember 2024',
                        title: 'Pengembangan Modul Pembelajaran SDGs',
                        description: 'Penyusunan modul pembelajaran SDGs untuk berbagai tingkat pendidikan dari SD hingga perguruan tinggi.'
                    }
                ],
                'Kolaborasi': [{
                        image: 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQzcD8s_rx58JooQqXcm41RUL34WM7aN72Hug&s',
                        date: 'Februari 2025',
                        title: 'Forum Multi-Stakeholder SDGs',
                        description: 'Pertemuan tahunan yang mempertemukan pemerintah, swasta, akademisi, dan masyarakat sipil untuk mendiskusikan kemajuan SDGs di Indonesia.'
                    },
                    {
                        image: 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQzcD8s_rx58JooQqXcm41RUL34WM7aN72Hug&s',
                        date: 'Januari 2025',
                        title: 'Kemitraan Lintas Perguruan Tinggi',
                        description: 'Kolaborasi riset dengan pusat kajian SDGs dari berbagai perguruan tinggi di Asia Tenggara untuk studi komparatif implementasi SDGs.'
                    },
                    {
                        image: 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQzcD8s_rx58JooQqXcm41RUL34WM7aN72Hug&s',
                        date: 'November 2024',
                        title: 'Kerja Sama Industri Berkelanjutan',
                        description: 'Kemitraan dengan sektor swasta dalam mengembangkan model bisnis berkelanjutan dan praktik produksi ramah lingkungan.'
                    }
                ]
            };

            const tabButtons = document.querySelectorAll('.tab-btn');
            const programContent = document.querySelector('.program-content');

            function renderProgramCards(category) {
                programContent.innerHTML = '';
                const categoryData = programData[category];

                categoryData.forEach(program => {
                    const programCard = document.createElement('div');
                    programCard.className = 'program-card';

                    programCard.innerHTML = `
                        <img src="${program.image}" alt="${program.title}">
                        <div class="program-info">
                            <span class="date">${program.date}</span>
                            <h4>${program.title}</h4>
                            <p>${program.description}</p>
                        </div>
                    `;

                    programContent.appendChild(programCard);
                });
            }

            tabButtons.forEach(button => {
                button.addEventListener('click', function() {
                    tabButtons.forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');
                    const category = this.textContent;
                    renderProgramCards(category);
                });
            });

            renderProgramCards('Penelitian');
        });
        const backgroundImages = [
            'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQzcD8s_rx58JooQqXcm41RUL34WM7aN72Hug&s',
            'https://cdn-web.ruangguru.com/file-uploader/de9f7350-e693-46f3-8c93-1ccc6550e0ea.jpg',
            'https://images.unsplash.com/photo-1433086966358-54859d0ed716?q=80&w=1000',
            'https://images.unsplash.com/photo-1501785888041-af3ef285b470?q=80&w=1000',
            'https://images.unsplash.com/photo-1470071459604-3b5ec3a7fe05?q=80&w=1000'
        ];

        let currentImageIndex = 0;
        const heroSection = document.getElementById('heroSection');

        // Function to change the background image
        function changeBackgroundImage() {
            currentImageIndex = (currentImageIndex + 1) % backgroundImages.length;
            const newBackgroundImage =
                `linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('${backgroundImages[currentImageIndex]}')`;
            heroSection.style.backgroundImage = newBackgroundImage;
        }

        // Change the background image every 5 seconds (5000 milliseconds)
        setInterval(changeBackgroundImage, 5000);
        document.addEventListener('DOMContentLoaded', function() {
            // Get all necessary elements
            const sliderContainer = document.querySelector('.sdgs-slider-container');
            const slides = Array.from(document.querySelectorAll('.sdgs-slide'));
            const paginationNumbers = Array.from(document.querySelectorAll('.sdgs-pagination-number'));

            // Current slide index
            let currentIndex = 0;
            let isTransitioning = false;

            // Add active class to first pagination number
            paginationNumbers[0].classList.add('active');

            // Add click event listeners to pagination numbers
            paginationNumbers.forEach(numBtn => {
                numBtn.addEventListener('click', () => {
                    const index = parseInt(numBtn.getAttribute('data-index'));
                    if (!isTransitioning && currentIndex !== index) {
                        goToSlide(index);
                    }
                });
            });

            // Function to go to a specific slide
            function goToSlide(index) {
                if (isTransitioning) return;
                isTransitioning = true;

                // Ensure index is within bounds
                if (index < 0) index = slides.length - 1;
                if (index >= slides.length) index = 0;

                // Update current index
                currentIndex = index;

                // Move the slider
                sliderContainer.style.transform = `translateX(-${currentIndex * 100}%)`;

                // Update pagination numbers
                paginationNumbers.forEach((numBtn, i) => {
                    if (i === currentIndex) {
                        numBtn.classList.add('active');
                    } else {
                        numBtn.classList.remove('active');
                    }
                });

                // Reset transition flag after animation completes
                setTimeout(() => {
                    isTransitioning = false;
                }, 800); // This should match the transition duration in CSS
            }

            // Add keyboard navigation (left/right arrows)
            document.addEventListener('keydown', (e) => {
                if (e.key === 'ArrowLeft') {
                    goToSlide(currentIndex - 1);
                    resetAutoPlay();
                } else if (e.key === 'ArrowRight') {
                    goToSlide(currentIndex + 1);
                    resetAutoPlay();
                }
            });

            // Add swipe support for mobile devices

            // Touch swipe functionality
            let touchStartX = 0;
            let touchEndX = 0;

            sliderContainer.addEventListener('touchstart', (e) => {
                touchStartX = e.changedTouches[0].screenX;
                pauseAutoPlay();
            }, {
                passive: true
            });

            sliderContainer.addEventListener('touchend', (e) => {
                touchEndX = e.changedTouches[0].screenX;
                handleSwipe();
                resetAutoPlay();
            }, {
                passive: true
            });

            function handleSwipe() {
                const swipeThreshold = 50; // Minimum distance for a swipe

                if (touchEndX < touchStartX - swipeThreshold) {
                    // Swipe left - go to next slide
                    goToSlide(currentIndex + 1);
                }

                if (touchEndX > touchStartX + swipeThreshold) {
                    // Swipe right - go to previous slide
                    goToSlide(currentIndex - 1);
                }
            }

            // Auto play functionality
            let autoPlayInterval;
            const autoPlayDelay = 6000; // 6 seconds between slides

            function startAutoPlay() {
                autoPlayInterval = setInterval(() => {
                    goToSlide(currentIndex + 1);
                }, autoPlayDelay);
            }

            function pauseAutoPlay() {
                clearInterval(autoPlayInterval);
            }

            function resetAutoPlay() {
                pauseAutoPlay();
                startAutoPlay();
            }

            // Initialize auto play
            startAutoPlay();

            // Pause auto play on hover
            const carousel = document.querySelector('.sdgs-fullscreen-carousel');
            carousel.addEventListener('mouseenter', pauseAutoPlay);
            carousel.addEventListener('mouseleave', startAutoPlay);

            // Update slide colors dynamically
            slides.forEach(slide => {
                const colorStr = slide.style.getPropertyValue('--sdg-color');
                if (colorStr) {
                    let color = colorStr.trim();
                    if (color.startsWith('#')) {
                        // If it's a hex color, use it as is
                        slide.style.setProperty('--sdg-color', color);
                    }
                }
            });

            // Smooth out the slider on window resize
            let resizeTimer;
            window.addEventListener('resize', () => {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(() => {
                    goToSlide(currentIndex);
                }, 250);
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Fetch Program & Kegiatan data from API
            fetch('/api/sdgscenter/programs')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    // Reference to DOM elements
                    const tabButtons = document.querySelectorAll('.program-tabs .tab-btn');
                    const programContent = document.querySelector('.program-content');

                    // Function to render program cards
                    function renderProgramCards(category) {
                        // Clear existing content
                        programContent.innerHTML = '';

                        // Get the correct category key
                        const categoryKey = getCategoryKey(category);
                        const programs = data[categoryKey] || [];

                        // If no programs found for this category
                        if (programs.length === 0) {
                            const noDataMessage = document.createElement('div');
                            noDataMessage.className = 'no-data';
                            noDataMessage.textContent = 'Tidak ada data untuk kategori ini';
                            programContent.appendChild(noDataMessage);
                            return;
                        }

                        // Create and append program cards
                        programs.forEach(program => {
                            const programCard = document.createElement('div');
                            programCard.className = 'program-card';

                            programCard.innerHTML = `
                            <img src="${program.image}" alt="${program.title}">
                            <div class="program-info">
                                <span class="date">${program.date}</span>
                                <h4>${program.title}</h4>
                                <p>${program.description}</p>
                            </div>
                        `;

                            programContent.appendChild(programCard);
                        });
                    }

                    // Helper function to map button text to category key
                    function getCategoryKey(category) {
                        switch (category) {
                            case 'Penelitian':
                                return 'penelitian';
                            case 'Pengabdian Masyarakat':
                                return 'pengabdian_masyarakat';
                            case 'Pendidikan':
                                return 'pendidikan';
                            case 'Kolaborasi':
                                return 'kolaborasi';
                            default:
                                return 'penelitian';
                        }
                    }

                    // Add click event listeners to tab buttons
                    tabButtons.forEach(button => {
                        button.addEventListener('click', function() {
                            // Remove active class from all buttons
                            tabButtons.forEach(btn => btn.classList.remove('active'));
                            // Add active class to clicked button
                            this.classList.add('active');
                            // Render programs for selected category
                            renderProgramCards(this.textContent);
                        });
                    });

                    // Initialize with the first/active category
                    const activeTab = document.querySelector('.tab-btn.active');
                    renderProgramCards(activeTab ? activeTab.textContent : 'Penelitian');
                })
                .catch(error => {
                    console.error('Error fetching program data:', error);
                    const programContent = document.querySelector('.program-content');
                    programContent.innerHTML =
                        '<div class="error-message">Terjadi kesalahan saat memuat data. Silakan coba lagi nanti.</div>';
                });
        });


        document.addEventListener('DOMContentLoaded', function() {
            // Fetch Publications & Riset data from API
            fetch('/api/sdgscenter/publications')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(publicationsData => {
                    const publicationGrid = document.querySelector('.publication-grid');

                    // Clear any existing content
                    publicationGrid.innerHTML = '';

                    if (publicationsData.length === 0) {
                        publicationGrid.innerHTML =
                            '<div class="no-publications">Belum ada publikasi tersedia.</div>';
                        return;
                    }

                    // Create and append publication cards
                    publicationsData.forEach(publication => {
                        const publicationCard = document.createElement('div');
                        publicationCard.className = 'publication-card';

                        // Create the HTML structure for the publication card
                        let publicationHTML = `
                    <img src="${publication.image}" alt="${publication.title}">
                    <div class="publication-info">
                        <h4>${publication.title}</h4>
                        <span class="authors">${publication.authors}</span>
                        <p>${publication.description}</p>
                `;

                        // Add download link if document is available
                        if (publication.has_document && publication.document_url) {
                            publicationHTML += `
                        <div class="publication-links">
                            <a href="${publication.document_url}" class="download-link" target="_blank">
                                <i class="fas fa-download"></i> Download
                            </a>
                        </div>
                    `;
                        }

                        publicationHTML += `</div>`;

                        publicationCard.innerHTML = publicationHTML;
                        publicationGrid.appendChild(publicationCard);
                    });
                })
                .catch(error => {
                    console.error('Error fetching publications data:', error);
                    const publicationGrid = document.querySelector('.publication-grid');
                    publicationGrid.innerHTML =
                        '<div class="error-message">Terjadi kesalahan saat memuat data publikasi. Silakan coba lagi nanti.</div>';
                });
        });
    </script>
</body>

</html>
