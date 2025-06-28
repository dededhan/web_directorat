<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SDGs Program - Universitas Negeri Jakarta</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" type="image/png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    {{-- <link rel="stylesheet" href="{{ asset('home.css') }}"> --}}
    
    <script>
        // Konfigurasi Tailwind untuk warna kustom dan font
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'sans': ['Inter', 'sans-serif'],
                    },
                    colors: {
                        'unj-green': '#1D796B',
                        'unj-teal': '#277177',
                        'unj-light-green': 'rgba(29, 121, 107, 0.05)',
                    }
                }
            }
        }
    </script>

    <style>
        /* CSS Tambahan untuk efek dan komponen kustom */
        .hero {
            transition: background-image 1s ease-in-out;
        }
        
        /*
         * Style untuk carousel SDGs dikembalikan ke versi semula.
         * Ini memastikan fungsionalitas dan tampilan carousel tidak berubah.
        */
        .sdgs-slider-container {
            display: flex;
            transition: transform 0.8s cubic-bezier(0.68, -0.55, 0.27, 1.55);
        }

        .sdgs-slide::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background-color: var(--sdg-color, #333);
            opacity: 0.9;
            z-index: 1;
            transition: background-color 0.5s ease;
        }

        /* Styling untuk skeleton loader */
        .skeleton-card {
            background-color: #f3f4f6;
            border-radius: 0.5rem;
            overflow: hidden;
        }
        .skeleton-image {
            height: 12rem;
            background-color: #e5e7eb;
        }
        .skeleton-text {
            height: 1rem;
            background-color: #e5e7eb;
            border-radius: 0.25rem;
            margin-bottom: 0.5rem;
        }
        
        /* Animasi untuk skeleton loader */
        @keyframes pulse {
            50% { opacity: .5; }
        }
        .animate-pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
    </style>
</head>

<body class="font-sans bg-gray-50 text-gray-800 antialiased">
    
    @include('layout.navbar_hilirisasi')

    <section id="heroSection" class="hero relative h-screen bg-cover bg-center flex items-center text-white" style="background-image: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQzcD8s_rx58JooQqXcm41RUL34WM7aN72Hug&s');">
        <div class="container mx-auto px-6 text-left z-10">
            <div class="max-w-3xl">
                <h1 class="text-4xl md:text-6xl font-extrabold mb-4 leading-tight">Sustainable Development Goals Program UNJ</h1>
                <p class="text-lg md:text-xl max-w-2xl mb-8 opacity-90">Membangun masa depan berkelanjutan melalui kolaborasi, inovasi, dan pendidikan untuk mewujudkan tujuan pembangunan berkelanjutan di Indonesia.</p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="#about" class="bg-unj-green hover:bg-unj-teal text-white font-bold py-3 px-8 rounded-lg transition duration-300 transform hover:scale-105 shadow-lg">Pelajari Lebih Lanjut</a>
                    <a href="#contact" class="bg-white/20 backdrop-blur-sm hover:bg-white/30 text-white font-bold py-3 px-8 rounded-lg transition duration-300">Hubungi Kami</a>
                </div>
            </div>
        </div>
        <div class="absolute bottom-10 left-1/2 -translate-x-1/2 z-10 animate-bounce">
             <a href="#what-is-sdgs" class="w-8 h-14 border-2 border-white rounded-full flex items-center justify-center p-2">
                <i class="fa fa-arrow-down"></i>
             </a>
        </div>
    </section>

    <section id="what-is-sdgs" class="py-20 bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center max-w-4xl mx-auto mb-16">
                <h2 class="text-4xl font-bold text-unj-green mb-4">Apa itu Sustainable Development Goals (SDGs)?</h2>
                <p class="text-lg text-gray-600">Sebuah cetak biru global yang disepakati oleh PBB untuk mencapai masa depan yang lebih baik dan lebih berkelanjutan untuk semua.</p>
            </div>
            <div class="flex flex-col md:flex-row items-center gap-12">
                <div class="w-full md:w-1/2">
                    <img src="/images/sdgs.png" alt="Sustainable Development Goals" class="rounded-xl shadow-2xl transform hover:scale-105 transition-transform duration-500">
                </div>
                <div class="w-full md:w-1/2 space-y-4 text-gray-700 leading-relaxed text-base">
                    <p>Pendidikan tinggi memiliki peran strategis dalam pencapaian Tujuan Pembangunan Berkelanjutan. Dengan 17 tujuan utama, perguruan tinggi diharapkan menjadi pusat inovasi, penelitian, dan pengabdian yang berorientasi pada keberlanjutan.</p>
                    <p>Program SDGs di perguruan tinggi merupakan upaya terstruktur untuk mengintegrasikan prinsip-prinsip ini ke dalam kurikulum, riset, tata kelola, dan kegiatan kemasyarakatan, mencetak lulusan yang tidak hanya kompeten, tetapi juga berwawasan lingkungan, sosial, dan ekonomi.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="stats" class="py-20 bg-unj-light-green">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                <div class="bg-white p-8 rounded-xl shadow-lg transform hover:-translate-y-2 transition-transform duration-300">
                    <h3 class="text-5xl font-extrabold text-unj-teal">17</h3>
                    <p class="text-lg font-medium text-gray-700 mt-2">Tujuan Utama</p>
                    <p class="text-gray-500 mt-1">Fokus global untuk masa depan.</p>
                </div>
                <div class="bg-white p-8 rounded-xl shadow-lg transform hover:-translate-y-2 transition-transform duration-300">
                    <h3 class="text-5xl font-extrabold text-unj-teal">169</h3>
                    <p class="text-lg font-medium text-gray-700 mt-2">Target Terukur</p>
                    <p class="text-gray-500 mt-1">Indikator spesifik untuk kemajuan.</p>
                </div>
                <div class="bg-white p-8 rounded-xl shadow-lg transform hover:-translate-y-2 transition-transform duration-300">
                    <h3 class="text-5xl font-extrabold text-unj-teal">2030</h3>
                    <p class="text-lg font-medium text-gray-700 mt-2">Agenda Global</p>
                    <p class="text-gray-500 mt-1">Tenggat waktu untuk pencapaian.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="sdgs-program" class="py-20 bg-white">
        <div class="container mx-auto px-6">
            <div class="flex flex-col lg:flex-row items-center gap-12">
                <div class="w-full lg:w-5/12">
                    <img src="/images/unjsdg.png" alt="SDGs Logo UNJ" class="w-64 h-auto object-contain mx-auto lg:mx-0">
                    <h2 class="text-4xl font-bold text-gray-800 mt-6">Peran UNJ dalam SDGs</h2>
                    <p class="text-gray-600 mt-4 text-lg leading-relaxed">UNJ berkomitmen untuk menjadi agen perubahan melalui implementasi SDGs di berbagai pilar Tri Dharma Perguruan Tinggi.</p>
                     <div class="italic text-gray-600 mt-6 border-l-4 border-unj-green pl-4">
                        "Menjadi <span class="font-semibold text-unj-green">center of excellence</span> dan <span class="font-semibold text-unj-green">agent of change</span> dalam pembangunan global yang adil, inklusif, dan berkelanjutan."
                    </div>
                </div>
                <div class="w-full lg:w-7/12 grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div class="bg-gray-50 p-6 rounded-lg border border-gray-200 hover:shadow-lg hover:border-unj-green transition-all duration-300">
                        <h3 class="text-xl font-bold text-unj-green mb-3">Pendidikan & Kurikulum</h3>
                        <p class="text-gray-600">Integrasi topik SDGs ke dalam mata kuliah dan modul pembelajaran inovatif.</p>
                    </div>
                     <div class="bg-gray-50 p-6 rounded-lg border border-gray-200 hover:shadow-lg hover:border-unj-green transition-all duration-300">
                        <h3 class="text-xl font-bold text-unj-green mb-3">Riset Interdisipliner</h3>
                        <p class="text-gray-600">Penelitian yang berkontribusi langsung pada pencapaian target-target SDGs.</p>
                    </div>
                     <div class="bg-gray-50 p-6 rounded-lg border border-gray-200 hover:shadow-lg hover:border-unj-green transition-all duration-300">
                        <h3 class="text-xl font-bold text-unj-green mb-3">Kampus Berkelanjutan</h3>
                        <p class="text-gray-600">Pengembangan kampus hijau, efisiensi energi, dan pengelolaan limbah.</p>
                    </div>
                     <div class="bg-gray-50 p-6 rounded-lg border border-gray-200 hover:shadow-lg hover:border-unj-green transition-all duration-300">
                        <h3 class="text-xl font-bold text-unj-green mb-3">Pengabdian Masyarakat</h3>
                        <p class="text-gray-600">Fokus pada pemberdayaan komunitas lokal untuk pembangunan berkelanjutan.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="goals" class="py-20 bg-gray-50">
    <div class="container mx-auto px-6 text-center mb-12">
        <h3 class="text-4xl font-bold text-gray-800">17 Tujuan Pembangunan Berkelanjutan</h3>
        <p class="text-lg text-gray-600 mt-2 max-w-3xl mx-auto">Komitmen global untuk mengakhiri kemiskinan, melindungi bumi, dan memastikan kemakmuran bagi semua.</p>
    </div>
    <div class="relative w-full h-[70vh] overflow-hidden rounded-xl shadow-2xl mx-auto max-w-7xl">
        <div class="sdgs-slider-container w-[1700%] h-full">
            @for ($i = 1; $i <= 17; $i++)
                @php
                    // Data SDGs dengan penambahan deskripsi singkat
                    $sdgData = [
                        1 => ['color' => '#e5243b', 'title' => 'Tanpa Kemiskinan', 'description' => 'Mengakhiri kemiskinan dalam segala bentuk di mana pun.'],
                        2 => ['color' => '#DDA63A', 'title' => 'Tanpa Kelaparan', 'description' => 'Mengakhiri kelaparan, mencapai ketahanan pangan dan gizi yang baik, serta meningkatkan pertanian berkelanjutan.'],
                        3 => ['color' => '#4C9F38', 'title' => 'Kehidupan Sehat dan Sejahtera', 'description' => 'Menjamin kehidupan yang sehat dan mendorong kesejahteraan bagi semua orang di segala usia.'],
                        4 => ['color' => '#C5192D', 'title' => 'Pendidikan Berkualitas', 'description' => 'Menjamin pendidikan berkualitas yang inklusif dan adil serta mempromosikan kesempatan belajar seumur hidup untuk semua.'],
                        5 => ['color' => '#FF3A21', 'title' => 'Kesetaraan Gender', 'description' => 'Mencapai kesetaraan gender dan memberdayakan semua perempuan dan anak perempuan.'],
                        6 => ['color' => '#26BDE2', 'title' => 'Air Bersih dan Sanitasi Layak', 'description' => 'Menjamin ketersediaan dan pengelolaan air dan sanitasi yang berkelanjutan untuk semua.'],
                        7 => ['color' => '#FCC30B', 'title' => 'Energi Bersih dan Terjangkau', 'description' => 'Menjamin akses energi yang terjangkau, andal, berkelanjutan, dan modern untuk semua.'],
                        8 => ['color' => '#A21942', 'title' => 'Pekerjaan Layak dan Pertumbuhan Ekonomi', 'description' => 'Mempromosikan pertumbuhan ekonomi berkelanjutan dan inklusif, kesempatan kerja penuh dan produktif, serta pekerjaan yang layak untuk semua.'],
                        9 => ['color' => '#FD6925', 'title' => 'Industri, Inovasi dan Infrastruktur', 'description' => 'Membangun infrastruktur yang tangguh, mempromosikan industrialisasi yang inklusif dan berkelanjutan, serta mendorong inovasi.'],
                        10 => ['color' => '#DD1367', 'title' => 'Berkurangnya Kesenjangan', 'description' => 'Mengurangi ketimpangan di dalam dan antar negara.'],
                        11 => ['color' => '#FD9D24', 'title' => 'Kota dan Permukiman Berkelanjutan', 'description' => 'Menjadikan kota dan pemukiman manusia inklusif, aman, tangguh, dan berkelanjutan.'],
                        12 => ['color' => '#BF8B2E', 'title' => 'Konsumsi dan Produksi Bertanggung Jawab', 'description' => 'Menjamin pola konsumsi dan produksi yang berkelanjutan.'],
                        13 => ['color' => '#3F7E44', 'title' => 'Penanganan Perubahan Iklim', 'description' => 'Mengambil tindakan segera untuk memerangi perubahan iklim dan dampaknya.'],
                        14 => ['color' => '#0A97D9', 'title' => 'Ekosistem Lautan', 'description' => 'Melestarikan dan memanfaatkan samudra, laut, dan sumber daya laut secara berkelanjutan untuk pembangunan berkelanjutan.'],
                        15 => ['color' => '#56C02B', 'title' => 'Ekosistem Daratan', 'description' => 'Melindungi, memulihkan, dan mempromosikan pemanfaatan ekosistem darat secara berkelanjutan.'],
                        16 => ['color' => '#00689D', 'title' => 'Perdamaian, Keadilan, dan Kelembagaan Kuat', 'description' => 'Mempromosikan masyarakat yang damai dan inklusif untuk pembangunan berkelanjutan.'],
                        17 => ['color' => '#19486A', 'title' => 'Kemitraan untuk Mencapai Tujuan', 'description' => 'Memperkuat sarana pelaksanaan dan merevitalisasi kemitraan global untuk pembangunan berkelanjutan.'],
                    ];
                    $currentSdg = $sdgData[$i];
                @endphp
                <div class="sdgs-slide w-[calc(100%/17)] h-full flex-shrink-0 relative text-white" style="--sdg-color: {{ $currentSdg['color'] }};">
                    <div class="relative z-10 h-full flex items-end p-8 md:p-12 bg-gradient-to-t from-black/70 via-black/20 to-transparent">
                        <div class="w-full">
                            <div class="flex items-start md:items-center gap-4 mb-4">
                                <img src="https://sdgs.un.org/sites/default/files/goals/E_SDG_Icons-{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}.jpg" alt="SDG {{ $i }}" class="w-16 h-16 rounded-md shadow-lg flex-shrink-0">
                                <div>
                                    <p class="font-bold text-lg">Tujuan {{ $i }}</p>
                                    <h2 class="text-3xl md:text-4xl font-extrabold">{{ $currentSdg['title'] }}</h2>
                                </div>
                            </div>
                            {{-- PENAMBAHAN DESKRIPSI --}}
                            <p class="mt-2 text-white/90 text-base md:text-lg max-w-3xl leading-relaxed">{{ $currentSdg['description'] }}</p>

                            <a href="{{ route('sdg.show', ['id' => $i]) }}" class="inline-block mt-4 bg-white text-gray-800 font-bold py-2 px-5 rounded-full hover:bg-opacity-90 transition-transform transform hover:scale-105">
                                Lihat Detail <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endfor
        </div>
        <div class="absolute bottom-4 left-1/2 -translate-x-1/2 z-20 flex flex-wrap justify-center gap-1.5 p-2 bg-black/30 backdrop-blur-sm rounded-full">
            @for ($i = 1; $i <= 17; $i++)
                <div class="sdgs-pagination-number w-7 h-7 flex items-center justify-center font-bold text-white rounded-full cursor-pointer transition-all duration-300" data-index="{{ $i-1 }}" style="background-color: {{ $sdgData[$i]['color'] }};">
                    {{ $i }}
                </div>
            @endfor
        </div>
    </div>
</section>

    <section id="programs" class="py-20 bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h3 class="text-4xl font-bold text-gray-800">Program & Kegiatan</h3>
                <p class="text-lg text-gray-600 mt-2">Inisiatif unggulan kami dalam mendukung pencapaian SDGs.</p>
            </div>
            <div class="flex justify-center gap-2 mb-8 flex-wrap">
                <button class="tab-btn active bg-unj-green text-white py-2 px-6 rounded-full font-semibold transition-all duration-300 shadow-md">Penelitian</button>
                <button class="tab-btn py-2 px-6 rounded-full font-semibold text-gray-500 hover:text-unj-green hover:bg-gray-100 transition-all duration-300">Pengabdian</button>
                <button class="tab-btn py-2 px-6 rounded-full font-semibold text-gray-500 hover:text-unj-green hover:bg-gray-100 transition-all duration-300">Pendidikan</button>
                <button class="tab-btn py-2 px-6 rounded-full font-semibold text-gray-500 hover:text-unj-green hover:bg-gray-100 transition-all duration-300">Kolaborasi</button>
            </div>
            <div class="program-content grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                </div>
        </div>
    </section>

    <section id="publication" class="py-20 bg-unj-light-green">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h3 class="text-4xl font-bold text-gray-800">Publikasi & Riset</h3>
                <p class="text-lg text-gray-600 mt-2">Temukan hasil riset dan publikasi terbaru kami terkait pembangunan berkelanjutan.</p>
            </div>
            <div class="publication-grid grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                </div>
        </div>
    </section>

    <section id="sustainability-courses" class="py-20 bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h3 class="text-4xl font-bold text-gray-800">Matakuliah Sustainability</h3>
                <p class="text-lg text-gray-600 mt-2">Jelajahi matakuliah yang terintegrasi dengan prinsip-prinsip SDGs di berbagai fakultas.</p>
            </div>
            <div class="flex justify-center gap-2 mb-8 flex-wrap">
                <button class="course-tab-btn active bg-unj-green text-white py-2 px-6 rounded-full font-semibold transition-all duration-300 shadow-md">FIP</button>
                <button class="course-tab-btn py-2 px-6 rounded-full font-semibold text-gray-500 hover:text-unj-green hover:bg-gray-100 transition-all duration-300">FBS</button>
                <button class="course-tab-btn py-2 px-6 rounded-full font-semibold text-gray-500 hover:text-unj-green hover:bg-gray-100 transition-all duration-300">FMIPA</button>
                <button class="course-tab-btn py-2 px-6 rounded-full font-semibold text-gray-500 hover:text-unj-green hover:bg-gray-100 transition-all duration-300">FIS</button>
                <button class="course-tab-btn py-2 px-6 rounded-full font-semibold text-gray-500 hover:text-unj-green hover:bg-gray-100 transition-all duration-300">FT</button>
                <button class="course-tab-btn py-2 px-6 rounded-full font-semibold text-gray-500 hover:text-unj-green hover:bg-gray-100 transition-all duration-300">FPPsi</button>
            </div>
            <div class="courses-grid grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                </div>
        </div>
    </section>
    
    @include('layout.footer')

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- HERO SLIDER ---
        const heroSection = document.getElementById('heroSection');
        if (heroSection) {
            const backgroundImages = [
                'https://cdn-web.ruangguru.com/file-uploader/de9f7350-e693-46f3-8c93-1ccc6550e0ea.jpg',
                'https://images.unsplash.com/photo-1433086966358-54859d0ed716?q=80&w=1000',
                'https://images.unsplash.com/photo-1501785888041-af3ef285b470?q=80&w=1000',
                'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQzcD8s_rx58JooQqXcm41RUL34WM7aN72Hug&s'
            ];
            let currentImageIndex = 0;
            setInterval(() => {
                currentImageIndex = (currentImageIndex + 1) % backgroundImages.length;
                heroSection.style.backgroundImage = `linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('${backgroundImages[currentImageIndex]}')`;
            }, 5000);
        }

        // --- SDGs CAROUSEL (JavaScript for original design) ---
        const sliderContainer = document.querySelector('.sdgs-slider-container');
        if (sliderContainer) {
            const slides = sliderContainer.querySelectorAll('.sdgs-slide');
            const paginationNumbers = document.querySelectorAll('.sdgs-pagination-number');
            let currentIndex = 0;
            let autoPlayInterval;

            function goToSlide(index, manual = false) {
                if (index < 0) index = slides.length - 1;
                if (index >= slides.length) index = 0;
                
                sliderContainer.style.transform = `translateX(-${index * (100 / slides.length)}%)`;
                
                paginationNumbers.forEach((btn, i) => {
                    btn.classList.toggle('scale-125', i === index);
                    btn.classList.toggle('ring-2', i === index);
                    btn.classList.toggle('ring-white', i === index);
                    btn.classList.toggle('shadow-lg', i === index);
                });
                
                currentIndex = index;
                if(manual) resetAutoPlay();
            }

            paginationNumbers.forEach(btn => {
                btn.addEventListener('click', () => goToSlide(parseInt(btn.dataset.index), true));
            });
            
            function startAutoPlay() {
                autoPlayInterval = setInterval(() => goToSlide(currentIndex + 1), 6000);
            }

            function resetAutoPlay() {
                clearInterval(autoPlayInterval);
                startAutoPlay();
            }
            
            const carouselWrapper = sliderContainer.parentElement;
            carouselWrapper.addEventListener('mouseenter', () => clearInterval(autoPlayInterval));
            carouselWrapper.addEventListener('mouseleave', startAutoPlay);

            goToSlide(0);
            startAutoPlay();
        }

        // --- DYNAMIC CONTENT LOADER (PROGRAMS & PUBLICATIONS) ---
        function createSkeletonCard() {
            return `
                <div class="skeleton-card animate-pulse">
                    <div class="skeleton-image"></div>
                    <div class="p-6">
                        <div class="skeleton-text w-1/3 mb-4"></div>
                        <div class="skeleton-text w-full"></div>
                        <div class="skeleton-text w-2/3"></div>
                    </div>
                </div>
            `;
        }
        
        // --- PROGRAMS & ACTIVITIES ---
        const programTabButtons = document.querySelectorAll('#programs .tab-btn');
        const programContent = document.querySelector('.program-content');
        
        function fetchAndRenderPrograms(category) {
            programContent.innerHTML = Array(3).fill(createSkeletonCard()).join('');
            
            // Simulasi fetch data
            setTimeout(() => {
                const dummyData = {
                    penelitian: [
                        { image: 'https://images.unsplash.com/photo-1521791136064-7986c2920216?w=500', date: 'Juni 2025', title: 'Riset Energi Terbarukan di Pedesaan', description: 'Studi kelayakan implementasi panel surya untuk komunitas terpencil.' },
                        { image: 'https://images.unsplash.com/photo-1579532582937-16c141df3087?w=500', date: 'Mei 2025', title: 'Analisis Ekonomi Sirkular UKM', description: 'Menganalisis potensi penerapan model ekonomi sirkular pada Usaha Kecil Menengah.' },
                    ],
                    pengabdian: [
                         { image: 'https://images.unsplash.com/photo-1599059813005-11265ba4b4ce?w=500', date: 'Juli 2025', title: 'Workshop Pengelolaan Sampah', description: 'Edukasi dan pelatihan pengelolaan sampah organik dan anorganik untuk warga.' },
                    ],
                    pendidikan: [],
                    kolaborasi: [
                        { image: 'https://images.unsplash.com/photo-1542744173-8e7e53415bb0?w=500', date: 'Agustus 2025', title: 'Kemitraan dengan Industri Hijau', description: 'Kolaborasi riset dan magang dengan perusahaan yang berfokus pada sustainability.' },
                    ]
                };

                const categoryKey = category.toLowerCase().replace(' ', '_');
                const programs = dummyData[categoryKey] || [];
                programContent.innerHTML = '';

                if (programs.length === 0) {
                    programContent.innerHTML = '<div class="col-span-full text-center text-gray-500 py-12">Tidak ada program untuk kategori ini.</div>';
                    return;
                }

                programs.forEach(program => {
                    const card = document.createElement('div');
                    card.className = 'group bg-white rounded-xl shadow-md overflow-hidden transform hover:-translate-y-2 transition-transform duration-300 border border-transparent hover:border-unj-green';
                    card.innerHTML = `
                        <div class="overflow-hidden h-48">
                            <img src="${program.image}" alt="${program.title}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        </div>
                        <div class="p-6">
                            <span class="text-sm text-gray-500">${program.date}</span>
                            <h4 class="text-xl font-bold text-gray-800 mt-2 mb-2 group-hover:text-unj-green transition-colors">${program.title}</h4>
                            <p class="text-gray-600">${program.description}</p>
                        </div>`;
                    programContent.appendChild(card);
                });

            }, 1000);
        }

        if (programTabButtons.length > 0 && programContent) {
            programTabButtons.forEach(button => {
                button.addEventListener('click', function() {
                    programTabButtons.forEach(btn => {
                        btn.classList.remove('active', 'bg-unj-green', 'text-white', 'shadow-md');
                        btn.classList.add('text-gray-500', 'hover:bg-gray-100', 'hover:text-unj-green');
                    });
                    this.classList.add('active', 'bg-unj-green', 'text-white', 'shadow-md');
                    this.classList.remove('text-gray-500', 'hover:bg-gray-100');
                    fetchAndRenderPrograms(this.textContent);
                });
            });
            fetchAndRenderPrograms('Penelitian'); // Load awal
        }
        
        // --- PUBLICATIONS & RESEARCH ---
        const publicationGrid = document.querySelector('.publication-grid');
        function fetchAndRenderPublications() {
            publicationGrid.innerHTML = Array(3).fill(createSkeletonCard()).join('');
            
            // Simulasi fetch data
            setTimeout(() => {
                const publications = [
                    { image: 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?w=500', title: 'Implementasi SDGs di Tingkat Kota: Studi Kasus Jakarta', authors: 'Dr. Ahmad Syafii, Dr. Rina Wijaya', description: 'Penelitian ini menganalisis bagaimana kota Jakarta mengintegrasikan tujuan pembangunan berkelanjutan ke dalam perencanaan kota dan dampaknya terhadap kebijakan publik.', url: '#' },
                    { image: 'https://images.unsplash.com/photo-1518152006812-edab29b069ac?w=500', title: 'Pendidikan untuk Pembangunan Berkelanjutan', authors: 'Prof. Budi Santoso, M.Pd.', description: 'Studi ini mengembangkan dan mengevaluasi model kurikulum yang mengintegrasikan prinsip SDGs dalam sistem pendidikan formal di Indonesia.', url: '#' },
                    { image: 'https://images.unsplash.com/photo-1611284446314-60a58ac0deb9?w=500', title: 'Ekonomi Sirkular sebagai Solusi Sampah', authors: 'Dr. Dian Pratiwi, M.Si.', description: 'Mempelajari penerapan prinsip ekonomi sirkular dalam manajemen sampah perkotaan dan potensinya untuk mengurangi limbah.', url: '#' },
                ];
                
                publicationGrid.innerHTML = '';
                
                publications.forEach(pub => {
                    const card = document.createElement('div');
                    card.className = 'group bg-white rounded-xl shadow-md overflow-hidden transform hover:-translate-y-2 transition-transform duration-300 flex flex-col';
                    card.innerHTML = `
                        <div class="overflow-hidden h-48">
                            <img src="${pub.image}" alt="${pub.title}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        </div>
                        <div class="p-6 flex flex-col flex-grow">
                            <h4 class="text-xl font-bold text-gray-800 mb-2 group-hover:text-unj-green transition-colors">${pub.title}</h4>
                            <p class="text-sm text-gray-500 mb-3">${pub.authors}</p>
                            <p class="text-gray-600 text-sm leading-relaxed flex-grow">${pub.description}</p>
                             <a href="${pub.url}" class="inline-flex items-center gap-2 text-sm font-semibold text-unj-green hover:text-unj-teal transition-colors mt-4 self-start">
                                Baca lebih lanjut <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    `;
                    publicationGrid.appendChild(card);
                });
            }, 1200);
        }
        if (publicationGrid) {
            fetchAndRenderPublications();
        }

        // --- SUSTAINABILITY COURSES ---
        const courseTabButtons = document.querySelectorAll('#sustainability-courses .course-tab-btn');
        const coursesGrid = document.querySelector('.courses-grid');

        function fetchAndRenderCourses(faculty) {
            if (!coursesGrid) return;
            coursesGrid.innerHTML = Array(3).fill(createSkeletonCard()).join('');

            // Simulasi fetch data
            setTimeout(() => {
                const dummyCourses = {
                    fip: [
                        { code: 'FIP101', title: 'Pendidikan Lingkungan Hidup', description: 'Mengkaji isu-isu lingkungan global dan lokal serta peran pendidikan dalam menciptakan kesadaran ekologis.', image: 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?w=500&auto=format&fit=crop' },
                        { code: 'FIP203', title: 'Inovasi Pembelajaran untuk SDGs', description: 'Mengembangkan model-model pembelajaran yang mengintegrasikan tujuan pembangunan berkelanjutan.', image: 'https://images.unsplash.com/photo-1542744173-8e7e53415bb0?w=500&auto=format&fit=crop' },
                        { code: 'FIP305', title: 'Psikologi Pendidikan Inklusif', description: 'Fokus pada penciptaan lingkungan belajar yang adil dan merata untuk semua siswa, sesuai SDG 4 dan 10.', image: 'https://images.unsplash.com/photo-1573165392262-c412b43b3b55?w=500&auto=format&fit=crop' },
                    ],
                    fbs: [
                        { code: 'FBS210', title: 'Sastra Hijau (Ekokritik)', description: 'Menganalisis karya sastra dari perspektif lingkungan untuk memahami hubungan manusia dan alam.', image: 'https://images.unsplash.com/photo-1455884946397-909c9535eb3d?w=500&auto=format&fit=crop' },
                        { code: 'FBS315', title: 'Seni Rupa dan Aktivisme Sosial', description: 'Mengeksplorasi bagaimana seni dapat digunakan sebagai media untuk menyuarakan isu-isu sosial dan keberlanjutan.', image: 'https://images.unsplash.com/photo-1501426026826-31c667bdf23d?w=500&auto=format&fit=crop' },
                    ],
                    fmipa: [
                        { code: 'MIPA401', title: 'Energi Terbarukan & Konservasi', description: 'Studi tentang sumber energi alternatif seperti surya, angin, dan air, serta metode konservasi energi.', image: 'https://images.unsplash.com/photo-1509391366360-2e959784a276?w=500&auto=format&fit=crop' },
                        { code: 'MIPA302', title: 'Manajemen Limbah dan Toksikologi', description: 'Mempelajari pengelolaan limbah yang aman dan dampaknya terhadap ekosistem dan kesehatan manusia.', image: 'https://images.unsplash.com/photo-1611284446314-60a58ac0deb9?w=500&auto=format&fit=crop' },
                        { code: 'MIPA211', title: 'Kimia Hijau', description: 'Penerapan prinsip kimia untuk mengurangi atau menghilangkan penggunaan zat berbahaya dalam desain produk.', image: 'https://images.unsplash.com/photo-1567427018141-0584cfcbf1b8?w=500&auto=format&fit=crop' },
                    ],
                    fis: [
                        { code: 'FIS208', title: 'Sosiologi Pembangunan Berkelanjutan', description: 'Menganalisis dimensi sosial dari pembangunan, termasuk kemiskinan, ketidaksetaraan, dan pemberdayaan masyarakat.', image: 'https://images.unsplash.com/photo-1521791136064-7986c2920216?w=500&auto=format&fit=crop' },
                        { code: 'FIS310', title: 'Politik Perubahan Iklim Global', description: 'Mengkaji kebijakan internasional dan dinamika politik dalam penanganan perubahan iklim.', image: 'https://images.unsplash.com/photo-1451187580459-43490279c0fa?w=500&auto=format&fit=crop' },
                    ],
                    ft: [
                        { code: 'FT501', title: 'Arsitektur Berkelanjutan', description: 'Desain bangunan yang ramah lingkungan dengan memperhatikan efisiensi energi, material, dan siklus hidup bangunan.', image: 'https://images.unsplash.com/photo-1487958449943-2429e8be8625?w=500&auto=format&fit=crop' },
                        { code: 'FT408', title: 'Transportasi Perkotaan Berkelanjutan', description: 'Perencanaan sistem transportasi yang efisien, rendah emisi, dan dapat diakses oleh semua lapisan masyarakat.', image: 'https://images.unsplash.com/photo-1570129477492-45c003edd2be?w=500&auto=format&fit=crop' },
                    ],
                    fppsi: [
                        { code: 'PSI333', title: 'Psikologi Lingkungan', description: 'Mempelajari interaksi timbal balik antara manusia dan lingkungannya, baik lingkungan fisik maupun sosial.', image: 'https://images.unsplash.com/photo-1591702954343-a25b8a034265?w=500&auto=format&fit=crop' },
                    ]
                };

                const facultyKey = faculty.toLowerCase();
                const courses = dummyCourses[facultyKey] || [];
                coursesGrid.innerHTML = '';

                if (courses.length === 0) {
                    coursesGrid.innerHTML = '<div class="col-span-full text-center text-gray-500 py-12">Tidak ada matakuliah untuk fakultas ini.</div>';
                    return;
                }

                courses.forEach(course => {
                    const card = document.createElement('div');
                    card.className = 'group bg-white rounded-xl shadow-md overflow-hidden transform hover:-translate-y-2 transition-transform duration-300 border border-gray-200 hover:border-unj-green flex flex-col';
                    card.innerHTML = `
                        <div class="overflow-hidden h-48">
                            <img src="${course.image}" alt="${course.title}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        </div>
                        <div class="p-6 flex flex-col flex-grow">
                            <div class="flex justify-between items-start mb-3">
                                <span class="text-sm font-semibold text-unj-green bg-unj-green/10 py-1 px-3 rounded-full">${course.code}</span>
                                <span class="text-sm font-bold text-gray-600">${faculty.toUpperCase()}</span>
                            </div>
                            <h4 class="text-xl font-bold text-gray-800 mb-2 group-hover:text-unj-green transition-colors">${course.title}</h4>
                            <p class="text-gray-600 text-sm leading-relaxed flex-grow">${course.description}</p>
                        </div>`;
                    coursesGrid.appendChild(card);
                });

            }, 800);
        }

        if (courseTabButtons.length > 0 && coursesGrid) {
            courseTabButtons.forEach(button => {
                button.addEventListener('click', function() {
                    courseTabButtons.forEach(btn => {
                        btn.classList.remove('active', 'bg-unj-green', 'text-white', 'shadow-md');
                        btn.classList.add('text-gray-500', 'hover:bg-gray-100', 'hover:text-unj-green');
                    });
                    this.classList.add('active', 'bg-unj-green', 'text-white', 'shadow-md');
                    this.classList.remove('text-gray-500', 'hover:bg-gray-100');
                    fetchAndRenderCourses(this.textContent);
                });
            });
            // Load initial courses for the active tab
            fetchAndRenderCourses('FIP');
        }
        
    });
    </script>
</body>
</html>