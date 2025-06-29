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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script>
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
    @include('layout.navbar_hilirisasi')

    <style>
        .hero {
            transition: background-image 1s ease-in-out;
        }
        /* Skeleton Pulse Animation */
        @keyframes pulse {
            50% { opacity: .5; }
        }
        .animate-pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        /* === DESAIN BARU: FULLSCREEN SDG CAROUSEL === */
        .sdgs-fullscreen-section {
            width: 100%;
            height: 100vh; /* Mengisi seluruh tinggi layar */
            position: relative;
            overflow: hidden;
            background-color: #f0f0f0; /* Warna fallback */
        }

        .sdgs-slider-container {
            display: flex;
            height: 100%;
            transition: transform 0.7s cubic-bezier(0.68, -0.55, 0.27, 1.55); /* Transisi slide yang unik */
        }

        .sdgs-slide {
            min-width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            background-size: cover;
            background-position: center;
            color: white;
            padding: 2rem;
        }
        
        /* Overlay gelap untuk kontras teks */
        .sdgs-slide::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.1));
            z-index: 1;
        }

        .sdgs-slide-content {
            position: relative;
            z-index: 2;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            max-width: 800px;
            animation: fade-in-up 1s ease-out forwards;
        }

        @keyframes fade-in-up {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .sdgs-slide-image {
            width: 150px;
            height: 150px;
            margin-bottom: 2rem;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 1.5rem;
            padding: 1rem;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }
        .sdgs-slide-image img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .sdgs-slide-info h2 {
            font-size: 3rem;
            font-weight: 900;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 8px rgba(0,0,0,0.5);
        }

        .sdgs-slide-info p {
            font-size: 1.25rem;
            line-height: 1.7;
            max-width: 600px;
            margin-bottom: 2rem;
            opacity: 0.9;
        }

        .sdgs-learn-more {
            background-color: var(--sdg-color, #fff);
            color: white;
            padding: 0.8rem 2rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 700;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }
        .sdgs-learn-more:hover {
            transform: scale(1.05) translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.3);
        }

        /* Navigasi */
        .sdgs-slider-nav {
            position: absolute;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 10;
            display: flex;
            gap: 8px;
            background-color: rgba(0,0,0,0.4);
            padding: 8px 15px;
            border-radius: 50px;
        }
        .sdgs-pagination-number {
            width: 30px;
            height: 30px;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            cursor: pointer;
            font-weight: 700;
            transition: all 0.3s ease;
            opacity: 0.7;
        }
        .sdgs-pagination-number.active, .sdgs-pagination-number:hover {
            opacity: 1;
            transform: scale(1.2);
            box-shadow: 0 0 0 3px rgba(255,255,255,0.7);
        }
    </style>
</head>

<body class="font-sans bg-gray-50 text-gray-800 antialiased">

    <section id="heroSection" class="hero relative h-screen bg-cover bg-center flex items-center text-white"
        style="background-image: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('/images/GEDUNG%20REKTORAT.png');">
        <div class="container mx-auto px-6 text-left z-10">
            <div class="max-w-3xl">
                <h1 class="text-4xl md:text-6xl font-extrabold mb-4 leading-tight">Sustainable Development Goals Program
                    UNJ</h1>
                <p class="text-lg md:text-xl max-w-2xl mb-8 opacity-90">Membangun masa depan berkelanjutan melalui
                    kolaborasi, inovasi, dan pendidikan untuk mewujudkan tujuan pembangunan berkelanjutan di Indonesia.
                </p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="#about"
                        class="bg-unj-green hover:bg-unj-teal text-white font-bold py-3 px-8 rounded-lg transition duration-300 transform hover:scale-105 shadow-lg">Pelajari
                        Lebih Lanjut</a>
                    <a href="#contact"
                        class="bg-white/20 backdrop-blur-sm hover:bg-white/30 text-white font-bold py-3 px-8 rounded-lg transition duration-300">Hubungi
                        Kami</a>
                </div>
            </div>
        </div>
        <div class="absolute bottom-10 left-1/2 -translate-x-1/2 z-10 animate-bounce">
            <a href="#what-is-sdgs"
                class="w-8 h-14 border-2 border-white rounded-full flex items-center justify-center p-2">
                <i class="fa fa-arrow-down"></i>
            </a>
        </div>
    </section>

    {{-- Sections lainnya tetap sama --}}
    <section id="what-is-sdgs" class="py-20 bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center max-w-4xl mx-auto mb-16">
                <h2 class="text-4xl font-bold text-unj-green mb-4">Apa itu Sustainable Development Goals (SDGs)?</h2>
                <p class="text-lg text-gray-600">Sebuah cetak biru global yang disepakati oleh PBB untuk mencapai masa
                    depan yang lebih baik dan lebih berkelanjutan untuk semua.</p>
            </div>
            <div class="flex flex-col md:flex-row items-center gap-12">
                <div class="w-full md:w-1/2">
                    <img src="/images/sdgs.png" alt="Sustainable Development Goals"
                        class="rounded-xl shadow-2xl transform hover:scale-105 transition-transform duration-500">
                </div>
                <div class="w-full md:w-1/2 space-y-4 text-gray-700 leading-relaxed text-base">
                    <p>Pendidikan tinggi memiliki peran strategis dalam pencapaian Tujuan Pembangunan Berkelanjutan.
                        Dengan 17 tujuan utama, perguruan tinggi diharapkan menjadi pusat inovasi, penelitian, dan
                        pengabdian yang berorientasi pada keberlanjutan.</p>
                    <p>Program SDGs di perguruan tinggi merupakan upaya terstruktur untuk mengintegrasikan
                        prinsip-prinsip ini ke dalam kurikulum, riset, tata kelola, dan kegiatan kemasyarakatan,
                        mencetak lulusan yang tidak hanya kompeten, tetapi juga berwawasan lingkungan, sosial, dan
                        ekonomi.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="stats" class="py-20 bg-unj-light-green">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                <div
                    class="bg-white p-8 rounded-xl shadow-lg transform hover:-translate-y-2 transition-transform duration-300">
                    <h3 class="text-5xl font-extrabold text-unj-teal">17</h3>
                    <p class="text-lg font-medium text-gray-700 mt-2">Tujuan Utama</p>
                    <p class="text-gray-500 mt-1">Fokus global untuk masa depan.</p>
                </div>
                <div
                    class="bg-white p-8 rounded-xl shadow-lg transform hover:-translate-y-2 transition-transform duration-300">
                    <h3 class="text-5xl font-extrabold text-unj-teal">169</h3>
                    <p class="text-lg font-medium text-gray-700 mt-2">Target Terukur</p>
                    <p class="text-gray-500 mt-1">Indikator spesifik untuk kemajuan.</p>
                </div>
                <div
                    class="bg-white p-8 rounded-xl shadow-lg transform hover:-translate-y-2 transition-transform duration-300">
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
                    <img src="/images/unjsdg.png" alt="SDGs Logo UNJ"
                        class="w-64 h-auto object-contain mx-auto lg:mx-0">
                    <h2 class="text-4xl font-bold text-gray-800 mt-6">Peran UNJ dalam SDGs</h2>
                    <p class="text-gray-600 mt-4 text-lg leading-relaxed">UNJ berkomitmen untuk menjadi agen perubahan
                        melalui implementasi SDGs di berbagai pilar Tri Dharma Perguruan Tinggi.</p>
                    <div class="italic text-gray-600 mt-6 border-l-4 border-unj-green pl-4">
                        "Menjadi <span class="font-semibold text-unj-green">center of excellence</span> dan <span
                            class="font-semibold text-unj-green">agent of change</span> dalam pembangunan global yang
                        adil, inklusif, dan berkelanjutan."
                    </div>
                </div>
                <div class="w-full lg:w-7/12 grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div
                        class="bg-gray-50 p-6 rounded-lg border border-gray-200 hover:shadow-lg hover:border-unj-green transition-all duration-300">
                        <h3 class="text-xl font-bold text-unj-green mb-3">Pendidikan & Kurikulum</h3>
                        <p class="text-gray-600">Integrasi topik SDGs ke dalam mata kuliah dan modul pembelajaran
                            inovatif.</p>
                    </div>
                    <div
                        class="bg-gray-50 p-6 rounded-lg border border-gray-200 hover:shadow-lg hover:border-unj-green transition-all duration-300">
                        <h3 class="text-xl font-bold text-unj-green mb-3">Riset Interdisipliner</h3>
                        <p class="text-gray-600">Penelitian yang berkontribusi langsung pada pencapaian target-target
                            SDGs.</p>
                    </div>
                    <div
                        class="bg-gray-50 p-6 rounded-lg border border-gray-200 hover:shadow-lg hover:border-unj-green transition-all duration-300">
                        <h3 class="text-xl font-bold text-unj-green mb-3">Kampus Berkelanjutan</h3>
                        <p class="text-gray-600">Pengembangan kampus hijau, efisiensi energi, dan pengelolaan limbah.
                        </p>
                    </div>
                    <div
                        class="bg-gray-50 p-6 rounded-lg border border-gray-200 hover:shadow-lg hover:border-unj-green transition-all duration-300">
                        <h3 class="text-xl font-bold text-unj-green mb-3">Pengabdian Masyarakat</h3>
                        <p class="text-gray-600">Fokus pada pemberdayaan komunitas lokal untuk pembangunan
                            berkelanjutan.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="goals" class="sdgs-fullscreen-section">
        @php
            $sdgData = [
                1 => [
                    'color' => '#e5243b',
                    'title' => 'Tanpa Kemiskinan',
                    'description' =>
                        'Mengakhiri kemiskinan dalam segala bentuk di mana pun. Tujuan ini berfokus pada penyediaan layanan dasar, perlindungan sosial, dan memastikan semua orang memiliki akses yang setara terhadap sumber daya ekonomi.',
                    'bg_image' => 'https://images.unsplash.com/photo-1532629345422-7515f3d16bb6?w=800&q=80',
                ],
                2 => [
                    'color' => '#DDA63A',
                    'title' => 'Tanpa Kelaparan',
                    'description' =>
                        'Mengakhiri kelaparan, mencapai ketahanan pangan dan gizi yang baik, serta mendorong pertanian berkelanjutan. Fokus pada akses terhadap makanan, perbaikan nutrisi, dan meningkatkan produktivitas pertanian secara berkelanjutan.',
                    'bg_image' => 'https://images.unsplash.com/photo-1542838132-92c53300491e?w=800&q=80',
                ],
                3 => [
                    'color' => '#4C9F38',
                    'title' => 'Kehidupan Sehat dan Sejahtera',
                    'description' =>
                        'Memastikan kehidupan yang sehat dan mendorong kesejahteraan bagi semua di segala usia. Berfokus pada pengurangan angka kematian ibu dan anak, mengakhiri epidemi penyakit menular, dan memastikan akses universal ke layanan kesehatan.',
                    'bg_image' => 'https://images.unsplash.com/photo-1535914254981-b5012eebbd15?w=800&q=80',
                ],
                4 => [
                    'color' => '#C5192D',
                    'title' => 'Pendidikan Berkualitas',
                    'description' =>
                        'Memastikan pendidikan yang inklusif dan berkualitas serta mendorong kesempatan belajar seumur hidup bagi semua. Memastikan semua anak mendapatkan akses pendidikan dan pelatihan keterampilan yang sesuai.',
                    'bg_image' => 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=800&q=80',
                ],
                5 => [
                    'color' => '#FF3A21',
                    'title' => 'Kesetaraan Gender',
                    'description' =>
                        'Mencapai kesetaraan gender dan memberdayakan kaum perempuan dan anak perempuan. Menghilangkan segala bentuk diskriminasi dan kekerasan terhadap perempuan dan memastikan partisipasi penuh mereka di semua tingkatan.',
                    'bg_image' => 'https://images.unsplash.com/photo-1556761175-59736c83c2ae?w=800&q=80',
                ],
                6 => [
                    'color' => '#26BDE2',
                    'title' => 'Air Bersih dan Sanitasi Layak',
                    'description' =>
                        'Memastikan ketersediaan dan pengelolaan air bersih dan sanitasi yang berkelanjutan bagi semua. Meningkatkan kualitas air, mengurangi polusi, dan melindungi ekosistem yang berkaitan dengan air.',
                    'bg_image' => 'https://images.unsplash.com/photo-1576053139221-88a2a95a8991?w=800&q=80',
                ],
                7 => [
                    'color' => '#FCC30B',
                    'title' => 'Energi Bersih dan Terjangkau',
                    'description' =>
                        'Memastikan akses ke energi yang terjangkau, andal, berkelanjutan, dan modern bagi semua. Meningkatkan penggunaan energi terbarukan dan efisiensi energi dalam sistem energi global.',
                    'bg_image' => 'https://images.unsplash.com/photo-1509390232535-866b17a33194?w=800&q=80',
                ],
                8 => [
                    'color' => '#A21942',
                    'title' => 'Pekerjaan Layak dan Pertumbuhan Ekonomi',
                    'description' =>
                        'Mendorong pertumbuhan ekonomi yang inklusif dan berkelanjutan, lapangan kerja penuh dan produktif, serta pekerjaan yang layak bagi semua. Fokus pada inovasi, kewirausahaan, dan penciptaan lapangan kerja.',
                    'bg_image' => 'https://images.unsplash.com/photo-1552664730-d307ca884978?w=800&q=80',
                ],
                9 => [
                    'color' => '#FD6925',
                    'title' => 'Industri, Inovasi dan Infrastruktur',
                    'description' =>
                        'Membangun infrastruktur yang tangguh, mendorong industrialisasi yang inklusif dan berkelanjutan, serta memupuk inovasi. Meningkatkan akses ke teknologi informasi dan komunikasi.',
                    'bg_image' => 'https://images.unsplash.com/photo-1581092921449-41b93f2c3516?w=800&q=80',
                ],
                10 => [
                    'color' => '#DD1367',
                    'title' => 'Berkurangnya Kesenjangan',
                    'description' =>
                        'Mengurangi kesenjangan dalam dan antar negara. Mendorong inklusi sosial, ekonomi, dan politik bagi semua, terlepas dari usia, jenis kelamin, disabilitas, ras, etnis, atau status lainnya.',
                    'bg_image' => 'https://images.unsplash.com/photo-1521791136064-7986c2920216?w=800&q=80',
                ],
                11 => [
                    'color' => '#FD9D24',
                    'title' => 'Kota dan Permukiman Berkelanjutan',
                    'description' =>
                        'Menjadikan kota dan permukiman inklusif, aman, tangguh, dan berkelanjutan. Memastikan akses ke perumahan yang layak dan terjangkau, transportasi publik, dan ruang publik yang aman.',
                    'bg_image' => 'https://images.unsplash.com/photo-1477959858617-67f85cf4f1df?w=800&q=80',
                ],
                12 => [
                    'color' => '#BF8B2E',
                    'title' => 'Konsumsi dan Produksi Bertanggung Jawab',
                    'description' =>
                        'Memastikan pola konsumsi dan produksi yang berkelanjutan. Mengurangi limbah, mendorong daur ulang, dan mendorong praktik bisnis yang berkelanjutan.',
                    'bg_image' => 'https://images.unsplash.com/photo-1542601906-823816a75393?w=800&q=80',
                ],
                13 => [
                    'color' => '#3F7E44',
                    'title' => 'Penanganan Perubahan Iklim',
                    'description' =>
                        'Mengambil tindakan segera untuk memerangi perubahan iklim dan dampaknya. Memperkuat ketahanan dan kapasitas adaptasi terhadap bahaya terkait iklim.',
                    'bg_image' => 'https://images.unsplash.com/photo-1444930694458-01babf71870c?w=800&q=80',
                ],
                14 => [
                    'color' => '#0A97D9',
                    'title' => 'Ekosistem Lautan',
                    'description' =>
                        'Melestarikan dan memanfaatkan secara berkelanjutan sumber daya laut untuk pembangunan berkelanjutan. Mengurangi polusi laut dan melindungi ekosistem pesisir.',
                    'bg_image' => 'https://images.unsplash.com/photo-1551918120-9739cb430c6d?w=800&q=80',
                ],
                15 => [
                    'color' => '#56C02B',
                    'title' => 'Ekosistem Daratan',
                    'description' =>
                        'Melindungi, memulihkan, dan mendorong pemanfaatan berkelanjutan ekosistem darat, mengelola hutan secara berkelanjutan, dan menghentikan hilangnya keanekaragaman hayati.',
                    'bg_image' => 'https://images.unsplash.com/photo-1425913397330-cf8af2ff40a1?w=800&q=80',
                ],
                16 => [
                    'color' => '#00689D',
                    'title' => 'Perdamaian, Keadilan, dan Kelembagaan Kuat',
                    'description' =>
                        'Mempromosikan masyarakat yang damai dan inklusif untuk pembangunan berkelanjutan, serta menyediakan akses keadilan bagi semua.',
                    'bg_image' => 'https://images.unsplash.com/photo-1519074002996-a69e7ac46a42?w=800&q=80',
                ],
                17 => [
                    'color' => '#19486A',
                    'title' => 'Kemitraan untuk Mencapai Tujuan',
                    'description' =>
                        'Memperkuat sarana pelaksanaan dan merevitalisasi kemitraan global untuk pembangunan berkelanjutan.',
                    'bg_image' => 'https://images.unsplash.com/photo-1543269865-cbf427effbad?w=800&q=80',
                ],
            ];
        @endphp

        <div class="sdgs-slider-container">
            @foreach ($sdgData as $i => $data)
                <div class="sdgs-slide"
                    style="--sdg-color: {{ $data['color'] }}; background-image: url('{{ $data['bg_image'] }}');">
                    <div class="sdgs-slide-content">
                        <div class="sdgs-slide-image">
                            <img src="https://sdgs.un.org/sites/default/files/goals/E_SDG_Icons-{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}.jpg"
                                alt="SDG {{ $i }}">
                        </div>
                        <div class="sdgs-slide-info">
                            <h2>{{ $data['title'] }}</h2>
                            <p>{{ $data['description'] }}</p>
                            <a href="{{ route('sdg.show', ['id' => $i]) }}" class="sdgs-learn-more">Pelajari Lebih
                                Lanjut</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="sdgs-slider-nav">
            @foreach ($sdgData as $i => $data)
                <div class="sdgs-pagination-number" data-index="{{ $i - 1 }}"
                    style="background-color: {{ $data['color'] }};">
                    {{ $i }}
                </div>
            @endforeach
        </div>
    </section>



    {{-- Sections lainnya tetap sama --}}
    <section id="programs" class="py-20 bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h3 class="text-4xl font-bold text-gray-800">Program & Kegiatan</h3>
                <p class="text-lg text-gray-600 mt-2">Inisiatif unggulan kami dalam mendukung pencapaian SDGs.</p>
            </div>
            <div class="flex justify-center gap-2 mb-8 flex-wrap">
                <button
                    class="tab-btn active bg-unj-green text-white py-2 px-6 rounded-full font-semibold transition-all duration-300 shadow-md">Penelitian</button>
                <button
                    class="tab-btn py-2 px-6 rounded-full font-semibold text-gray-500 hover:text-unj-green hover:bg-gray-100 transition-all duration-300">Pengabdian</button>
                <button
                    class="tab-btn py-2 px-6 rounded-full font-semibold text-gray-500 hover:text-unj-green hover:bg-gray-100 transition-all duration-300">Pendidikan</button>
                <button
                    class="tab-btn py-2 px-6 rounded-full font-semibold text-gray-500 hover:text-unj-green hover:bg-gray-100 transition-all duration-300">Kolaborasi</button>
            </div>
            <div class="program-content grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            </div>
        </div>
    </section>

    <section id="publication" class="py-20 bg-unj-light-green">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h3 class="text-4xl font-bold text-gray-800">Publikasi & Riset</h3>
                <p class="text-lg text-gray-600 mt-2">Temukan hasil riset dan publikasi terbaru kami terkait
                    pembangunan berkelanjutan.</p>
            </div>
            <div class="publication-grid grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            </div>
        </div>
    </section>

    <section id="sustainability-courses" class="py-20 bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h3 class="text-4xl font-bold text-gray-800">Matakuliah Sustainability</h3>
                <p class="text-lg text-gray-600 mt-2">Jelajahi matakuliah yang terintegrasi dengan prinsip-prinsip SDGs
                    di berbagai fakultas.</p>
            </div>
            {{-- Tombol tab fakultas tidak berubah --}}
            <div class="flex justify-center gap-2 mb-8 flex-wrap">
                <button
                    class="course-tab-btn active bg-unj-green text-white py-2 px-6 rounded-full font-semibold transition-all duration-300 shadow-md"
                    data-faculty="FIP">FIP</button>
                <button
                    class="course-tab-btn py-2 px-6 rounded-full font-semibold text-gray-500 hover:text-unj-green hover:bg-gray-100 transition-all duration-300"
                    data-faculty="FBS">FBS</button>
                <button
                    class="course-tab-btn py-2 px-6 rounded-full font-semibold text-gray-500 hover:text-unj-green hover:bg-gray-100 transition-all duration-300"
                    data-faculty="FMIPA">FMIPA</button>
                <button
                    class="course-tab-btn py-2 px-6 rounded-full font-semibold text-gray-500 hover:text-unj-green hover:bg-gray-100 transition-all duration-300"
                    data-faculty="FIS">FIS</button>
                <button
                    class="course-tab-btn py-2 px-6 rounded-full font-semibold text-gray-500 hover:text-unj-green hover:bg-gray-100 transition-all duration-300"
                    data-faculty="FT">FT</button>
                <button
                    class="course-tab-btn py-2 px-6 rounded-full font-semibold text-gray-500 hover:text-unj-green hover:bg-gray-100 transition-all duration-300"
                    data-faculty="FPPSI">FPPSI</button>
                <button
                    class="course-tab-btn py-2 px-6 rounded-full font-semibold text-gray-500 hover:text-unj-green hover:bg-gray-100 transition-all duration-300"
                    data-faculty="FIK">FIK</button>
                <button
                    class="course-tab-btn py-2 px-6 rounded-full font-semibold text-gray-500 hover:text-unj-green hover:bg-gray-100 transition-all duration-300"
                    data-faculty="FE">FE</button>
            </div>
            {{-- Grid untuk menampilkan card mata kuliah --}}
            <div class="courses-grid grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                {{-- Konten akan diisi oleh JavaScript --}}
            </div>
        </div>
    </section>

    <div id="course-modal"
        class="fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center z-50 hidden transition-opacity duration-300"
        aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div id="course-modal-content"
            class="bg-white rounded-lg shadow-xl w-11/12 max-w-2xl transform transition-all duration-300 scale-95 opacity-0">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-xl font-bold text-unj-green" id="modal-title">Detail Mata Kuliah</h3>
                <button id="close-modal-btn" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times fa-lg"></i>
                </button>
            </div>
            <div class="p-6">
                <h4 class="text-2xl font-extrabold text-gray-800 mb-2" id="modal-course-name">Nama Mata Kuliah</h4>
                <div class="flex items-center space-x-4 text-sm text-gray-500 mb-4">
                    <span id="modal-course-code"
                        class="bg-gray-100 text-gray-800 px-2 py-1 rounded font-mono">KODE</span>
                    <span id="modal-course-semester">Semester</span>
                </div>

                <h5 class="font-bold text-gray-700 mt-6 mb-2">Deskripsi Mata Kuliah</h5>
                <p class="text-gray-600 leading-relaxed text-base" id="modal-course-description">
                    Deskripsi akan muncul di sini.
                </p>

                <div class="mt-6" id="modal-rps-section">
                    <a href="#" id="modal-rps-download-btn" target="_blank"
                        class="inline-flex items-center gap-2 bg-unj-green hover:bg-unj-teal text-white font-bold py-2 px-4 rounded-lg transition duration-300 transform hover:scale-105 shadow-lg">
                        <i class="fas fa-download"></i>
                        Download RPS
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // --- HERO SLIDER ---
            const heroSection = document.getElementById('heroSection');
            if (heroSection) {
                const backgroundImages = [
                    "/images/logos/image_corousel.jpg",
                    "/images/TERBUK TAMPAK DEPAN.png",
                    "/images/GEDUNG REKTORAT.png",
                    "/images/om.png",
                ];
                let currentImageIndex = 0;
                setInterval(() => {
                    currentImageIndex = (currentImageIndex + 1) % backgroundImages.length;
                    const newImageUrl = backgroundImages[currentImageIndex] ||
                        '/images/GEDUNG%20REKTORAT.png';
                    heroSection.style.backgroundImage =
                        `linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('${newImageUrl}')`;
                }, 5000);
            }

            // --- NEW SDG CAROUSEL SCRIPT ---
            const sdgsSection = document.getElementById('goals');
        if (sdgsSection) {
            const sliderContainer = sdgsSection.querySelector('.sdgs-slider-container');
            const navDots = sdgsSection.querySelectorAll('.sdgs-pagination-number');
            const totalSlides = navDots.length;
            let currentIndex = 0;
            let autoPlayInterval;

            function goToSlide(index) {
                if (index < 0 || index >= totalSlides) return;
                
                sliderContainer.style.transform = `translateX(-${index * 100}%)`;

                navDots.forEach(dot => dot.classList.remove('active'));
                navDots[index].classList.add('active');

                currentIndex = index;
            }

            function nextSlide() {
                const nextIndex = (currentIndex + 1) % totalSlides;
                goToSlide(nextIndex);
            }

            navDots.forEach(dot => {
                dot.addEventListener('click', () => {
                    goToSlide(parseInt(dot.dataset.index));
                    resetAutoPlay();
                });
            });

            function startAutoPlay() {
                autoPlayInterval = setInterval(nextSlide, 7000); // Ganti slide setiap 7 detik
            }

            function resetAutoPlay() {
                clearInterval(autoPlayInterval);
                startAutoPlay();
            }

            // Inisialisasi slide pertama dan autoplay
            goToSlide(0);
            startAutoPlay();
        }

            // --- DYNAMIC CONTENT LOADER (PROGRAMS & PUBLICATIONS) ---
            function createSkeletonCard(height = '12rem') {
                return `
                <div class="skeleton-card animate-pulse">
                    <div class="skeleton-image" style="height: ${height};"></div>
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

            function getCategoryKey(category) {
                const categories = {
                    'Penelitian': 'penelitian',
                    'Pengabdian': 'pengabdian_masyarakat',
                    'Pendidikan': 'pendidikan',
                    'Kolaborasi': 'kolaborasi'
                };
                return categories[category] || 'penelitian';
            }

            // DUMMY DATA FOR PROGRAMS
            const dummyPrograms = {
                penelitian: [{
                        image: 'https://via.placeholder.com/400x300/1D796B/FFFFFF?text=Riset+Energi',
                        title: 'Riset Energi Terbarukan di Kampus',
                        description: 'Pengembangan panel surya efisiensi tinggi untuk kebutuhan energi UNJ.',
                        date: '15 Juni 2025'
                    },
                    {
                        image: 'https://via.placeholder.com/400x300/4C9F38/FFFFFF?text=Riset+Pangan',
                        title: 'Studi Ketahanan Pangan Lokal',
                        description: 'Analisis potensi pangan lokal untuk mendukung SDG 2 di komunitas sekitar.',
                        date: '10 Juni 2025'
                    },
                ],
                pengabdian_masyarakat: [{
                        image: 'https://via.placeholder.com/400x300/FD6925/FFFFFF?text=Pengabdian',
                        title: 'Literasi Digital untuk UMKM',
                        description: 'Pelatihan pemanfaatan teknologi untuk meningkatkan pemasaran produk UMKM.',
                        date: '20 Mei 2025'
                    },
                    {
                        image: 'https://via.placeholder.com/400x300/0A97D9/FFFFFF?text=Bersih+Sungai',
                        title: 'Gerakan Ciliwung Bersih',
                        description: 'Kolaborasi dengan komunitas lokal dalam program pembersihan dan edukasi sungai.',
                        date: '05 Mei 2025'
                    },
                    {
                        image: 'https://via.placeholder.com/400x300/DD1367/FFFFFF?text=Edukasi+Gender',
                        title: 'Workshop Kesetaraan Gender',
                        description: 'Mengadakan seminar dan workshop di sekolah-sekolah untuk mempromosikan kesetaraan gender.',
                        date: '22 April 2025'
                    },
                ],
                pendidikan: [{
                    image: 'https://via.placeholder.com/400x300/C5192D/FFFFFF?text=Kurikulum',
                    title: 'Integrasi Kurikulum SDGs',
                    description: 'Workshop pengembangan modul ajar berbasis SDGs untuk dosen di lingkungan UNJ.',
                    date: '12 April 2025'
                }, ],
                kolaborasi: [{
                    image: 'https://via.placeholder.com/400x300/19486A/FFFFFF?text=Partnership',
                    title: 'Kemitraan Industri Hijau',
                    description: 'Penandatanganan MoU dengan perusahaan untuk program magang dan riset bersama.',
                    date: '30 Maret 2025'
                }, ],
            };

            function renderProgramCards(category) {
                programContent.innerHTML = '';
                const categoryKey = getCategoryKey(category);
                const programs = dummyPrograms[categoryKey] || [];

                if (programs.length === 0) {
                    programContent.innerHTML =
                        '<div class="col-span-full text-center text-gray-500 py-12">Tidak ada program untuk kategori ini.</div>';
                    return;
                }

                programs.forEach(program => {
                    const card = document.createElement('div');
                    card.className =
                        'group bg-white rounded-xl shadow-md overflow-hidden transform hover:-translate-y-2 transition-transform duration-300 border border-transparent hover:border-unj-green';
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
            }

            if (programTabButtons.length > 0 && programContent) {
                programTabButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        programTabButtons.forEach(btn => btn.classList.remove('active',
                            'bg-unj-green', 'text-white', 'shadow-md'));
                        this.classList.add('active', 'bg-unj-green', 'text-white', 'shadow-md');
                        renderProgramCards(this.textContent);
                    });
                });
                // Initial load
                renderProgramCards('Penelitian');
            }

            // --- PUBLICATIONS & RESEARCH ---
            const publicationGrid = document.querySelector('.publication-grid');
            const dummyPublications = [{
                    image: 'https://via.placeholder.com/400x300/00689D/FFFFFF?text=Publikasi+1',
                    title: 'Model Tata Kelola Perkotaan Berkelanjutan',
                    authors: 'Dr. Budi Santoso, M.Si.',
                    description: 'Jurnal ini membahas kerangka kerja untuk kota yang inklusif dan aman, sejalan dengan SDG 11.',
                    has_document: true,
                    document_url: '#'
                },
                {
                    image: 'https://via.placeholder.com/400x300/BF8B2E/FFFFFF?text=Publikasi+2',
                    title: 'Analisis Rantai Pasok Ekonomi Sirkular',
                    authors: 'Prof. Dr. Siti Aminah, M.E.',
                    description: 'Penelitian mengenai penerapan ekonomi sirkular pada UMKM untuk mendukung SDG 12.',
                    has_document: true,
                    document_url: '#'
                },
                {
                    image: 'https://via.placeholder.com/400x300/3F7E44/FFFFFF?text=Publikasi+3',
                    title: 'Dampak Perubahan Iklim Terhadap Ekosistem Pesisir',
                    authors: 'Dr. Rina Marlina, M.Sc.',
                    description: 'Studi kasus mengenai dampak kenaikan permukaan laut di pesisir utara Jakarta.',
                    has_document: false,
                    document_url: null
                },
            ];

            function renderPublications() {
                if (!publicationGrid) return;
                publicationGrid.innerHTML = '';

                if (dummyPublications.length === 0) {
                    publicationGrid.innerHTML =
                        '<div class="no-publications col-span-full text-center text-gray-500 py-12">Belum ada publikasi tersedia.</div>';
                    return;
                }

                dummyPublications.forEach(pub => {
                    const card = document.createElement('div');
                    card.className =
                        'group bg-white rounded-xl shadow-md overflow-hidden transform hover:-translate-y-2 transition-transform duration-300 flex flex-col';

                    let linkHtml = '';
                    if (pub.has_document && pub.document_url) {
                        linkHtml = `<a href="${pub.document_url}" target="_blank" class="inline-flex items-center gap-2 text-sm font-semibold text-unj-green hover:text-unj-teal transition-colors mt-4 self-start">
                        Download <i class="fas fa-download"></i>
                    </a>`;
                    }

                    card.innerHTML = `
                    <div class="overflow-hidden h-48">
                        <img src="${pub.image}" alt="${pub.title}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    </div>
                    <div class="p-6 flex flex-col flex-grow">
                        <h4 class="text-xl font-bold text-gray-800 mb-2 group-hover:text-unj-green transition-colors">${pub.title}</h4>
                        <p class="text-sm text-gray-500 mb-3">${pub.authors}</p>
                        <p class="text-gray-600 text-sm leading-relaxed flex-grow">${pub.description}</p>
                        ${linkHtml}
                    </div>
                `;
                    publicationGrid.appendChild(card);
                });
            }
            if (publicationGrid) {
                renderPublications();
            }

            // --- SUSTAINABILITY COURSES (LOGIC WITH DUMMY DATA) ---
            const courseTabButtons = document.querySelectorAll('#sustainability-courses .course-tab-btn');
            const coursesGrid = document.querySelector('.courses-grid');
            const courseModal = document.getElementById('course-modal');
            const courseModalContent = document.getElementById('course-modal-content');
            const closeModalBtn = document.getElementById('close-modal-btn');

            // DUMMY DATA FOR COURSES
            const allDummyCourses = [{
                    fakultas: 'FIP',
                    prodi: 'Teknologi Pendidikan',
                    sdgs_group: 'SDG 4: Quality Education',
                    nama_matkul: 'Inovasi Pembelajaran Digital Berkelanjutan',
                    kode_matkul: 'FIP101',
                    semester: 4,
                    deskripsi: 'Mata kuliah ini membahas desain dan pengembangan media pembelajaran digital yang mendukung tujuan pendidikan berkualitas, inklusif, dan merata untuk semua.',
                    rps: '#'
                },
                {
                    fakultas: 'FIP',
                    prodi: 'Manajemen Pendidikan',
                    sdgs_group: 'SDG 4 & 8',
                    nama_matkul: 'Manajemen Sekolah Berwawasan Lingkungan',
                    kode_matkul: 'FIP102',
                    semester: 5,
                    deskripsi: 'Fokus pada pengelolaan institusi pendidikan yang menerapkan prinsip-prinsip keberlanjutan, efisiensi sumber daya, dan pertumbuhan yang bertanggung jawab.',
                    rps: null
                },
                {
                    fakultas: 'FBS',
                    prodi: 'Sastra Indonesia',
                    sdgs_group: 'SDG 10: Reduced Inequalities',
                    nama_matkul: 'Ekokritik dan Sastra Lingkungan',
                    kode_matkul: 'FBS201',
                    semester: 6,
                    deskripsi: 'Menganalisis karya sastra dari perspektif lingkungan, mengeksplorasi isu-isu keadilan sosial dan ekologis yang terkandung di dalamnya.',
                    rps: '#'
                },
                {
                    fakultas: 'FMIPA',
                    prodi: 'Biologi',
                    sdgs_group: 'SDG 15: Life on Land',
                    nama_matkul: 'Konservasi Keanekaragaman Hayati',
                    kode_matkul: 'MIPA301',
                    semester: 5,
                    deskripsi: 'Studi tentang prinsip dan praktik konservasi untuk melindungi, memulihkan, dan mempromosikan pemanfaatan ekosistem darat secara berkelanjutan.',
                    rps: '#'
                },
                {
                    fakultas: 'FMIPA',
                    prodi: 'Kimia',
                    sdgs_group: 'SDG 7 & 12',
                    nama_matkul: 'Kimia Hijau dan Berkelanjutan',
                    kode_matkul: 'MIPA302',
                    semester: 6,
                    deskripsi: 'Mempelajari prinsip-prinsip kimia yang mengurangi atau menghilangkan penggunaan dan pembuatan zat berbahaya untuk produksi dan konsumsi yang bertanggung jawab.',
                    rps: null
                },
                {
                    fakultas: 'FIS',
                    prodi: 'Sosiologi',
                    sdgs_group: 'SDG 11: Sustainable Cities',
                    nama_matkul: 'Sosiologi Perkotaan dan Pembangunan Berkelanjutan',
                    kode_matkul: 'FIS401',
                    semester: 4,
                    deskripsi: 'Mengkaji dinamika sosial dalam pembangunan perkotaan yang inklusif, aman, tangguh, dan berkelanjutan.',
                    rps: '#'
                },
                {
                    fakultas: 'FT',
                    prodi: 'Teknik Sipil',
                    sdgs_group: 'SDG 9: Infrastructure',
                    nama_matkul: 'Konstruksi Hijau dan Infrastruktur Tangguh',
                    kode_matkul: 'FT501',
                    semester: 7,
                    deskripsi: 'Prinsip desain dan konstruksi bangunan serta infrastruktur yang ramah lingkungan, hemat energi, dan tahan terhadap perubahan iklim.',
                    rps: '#'
                },
                {
                    fakultas: 'FE',
                    prodi: 'Akuntansi',
                    sdgs_group: 'SDG 8 & 12',
                    nama_matkul: 'Akuntansi Keberlanjutan dan Pelaporan',
                    kode_matkul: 'FE601',
                    semester: 6,
                    deskripsi: 'Membahas pengukuran, pengungkapan, dan penjaminan informasi dampak lingkungan dan sosial dari kegiatan perusahaan.',
                    rps: null
                },
                {
                    fakultas: 'FE',
                    prodi: 'Manajemen',
                    sdgs_group: 'SDG 8: Decent Work',
                    nama_matkul: 'Bisnis Berkelanjutan dan Etika',
                    kode_matkul: 'FE602',
                    semester: 5,
                    deskripsi: 'Mengintegrasikan tujuan sosial dan lingkungan ke dalam model bisnis untuk menciptakan pertumbuhan ekonomi yang inklusif dan berkelanjutan.',
                    rps: '#'
                },
            ];

            function createCourseSkeletonCard() {
                return `
                <div class="bg-white rounded-lg shadow-md p-5 animate-pulse">
                    <div class="h-4 bg-gray-200 rounded w-3/4 mb-4"></div>
                    <div class="h-8 bg-gray-300 rounded w-full mb-4"></div>
                    <div class="flex justify-between items-center mb-3">
                        <div class="h-4 bg-gray-200 rounded w-1/4"></div>
                        <div class="h-4 bg-gray-200 rounded w-1/4"></div>
                    </div>
                    <div class="h-4 bg-gray-200 rounded w-1/2 mb-5"></div>
                    <div class="h-10 bg-gray-300 rounded w-full"></div>
                </div>
            `;
            }

            function renderCourses(facultyKey) {
                if (!coursesGrid) return;

                coursesGrid.innerHTML = Array(6).fill(createCourseSkeletonCard()).join('');

                setTimeout(() => { // Simulate small delay
                    const filteredCourses = allDummyCourses.filter(course => course.fakultas
                    .toLowerCase() === facultyKey.toLowerCase());
                    coursesGrid.innerHTML = '';

                    if (!filteredCourses || filteredCourses.length === 0) {
                        coursesGrid.innerHTML = `
                        <div class="col-span-full text-center text-gray-500 py-12 bg-gray-50 rounded-lg">
                            <i class="fas fa-folder-open fa-3x mb-4 text-gray-400"></i>
                            <h4 class="text-xl font-semibold">Belum Ada Data</h4>
                            <p>Tidak ada data matakuliah sustainability untuk fakultas ini.</p>
                        </div>`;
                        return;
                    }

                    filteredCourses.forEach(course => {
                        const card = document.createElement('div');
                        card.className =
                            'bg-white rounded-xl shadow-md hover:shadow-xl transition-shadow duration-300 flex flex-col';

                        const prodiDisplay = course.prodi ? course.prodi : 'Lintas Prodi';

                        card.innerHTML = `
                        <div class="p-6 flex-grow">
                            <span class="inline-block bg-unj-light-green text-unj-teal text-xs font-bold px-3 py-1 rounded-full mb-3">${course.sdgs_group}</span>
                            <h4 class="text-lg font-extrabold text-gray-800 mb-2 leading-tight">${course.nama_matkul}</h4>
                            <div class="flex justify-between items-center text-sm text-gray-500 mb-3">
                                <span>Semester: <span class="font-semibold">${course.semester}</span></span>
                                <span class="font-mono text-xs bg-gray-100 px-2 py-1 rounded">${course.kode_matkul}</span>
                            </div>
                            <p class="text-sm text-gray-600"><span class="font-bold">${course.fakultas.toUpperCase()}</span> - ${prodiDisplay}</p>
                        </div>
                        <div class="p-4 bg-gray-50 rounded-b-xl">
                            <button 
                                class="open-modal-btn w-full bg-unj-green hover:bg-unj-teal text-white font-bold py-2 px-4 rounded-lg transition duration-300 transform hover:scale-105"
                                data-nama="${course.nama_matkul}"
                                data-kode="${course.kode_matkul}"
                                data-semester="Semester ${course.semester}"
                                data-deskripsi="${course.deskripsi}"
                                data-rps="${course.rps || ''}">
                                Lihat Detail
                            </button>
                        </div>
                    `;
                        coursesGrid.appendChild(card);
                    });
                }, 300);
            }

            function openModal(button) {
                document.getElementById('modal-course-name').textContent = button.dataset.nama;
                document.getElementById('modal-course-code').textContent = button.dataset.kode;
                document.getElementById('modal-course-semester').textContent = button.dataset.semester;
                document.getElementById('modal-course-description').textContent = button.dataset.deskripsi ||
                    'Tidak ada deskripsi.';

                const rpsUrl = button.dataset.rps;
                const rpsSection = document.getElementById('modal-rps-section');
                const rpsDownloadBtn = document.getElementById('modal-rps-download-btn');

                if (rpsUrl) {
                    rpsDownloadBtn.href = rpsUrl;
                    rpsSection.classList.remove('hidden');
                } else {
                    rpsSection.classList.add('hidden');
                }

                courseModal.classList.remove('hidden');
                setTimeout(() => {
                    courseModal.classList.remove('opacity-0');
                    courseModalContent.classList.remove('scale-95', 'opacity-0');
                }, 10);
            }

            function closeModal() {
                courseModalContent.classList.add('scale-95', 'opacity-0');
                courseModal.classList.add('opacity-0');
                setTimeout(() => courseModal.classList.add('hidden'), 300);
            }

            if (courseTabButtons.length > 0 && coursesGrid) {
                courseTabButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        courseTabButtons.forEach(btn => btn.classList.remove('active',
                            'bg-unj-green', 'text-white', 'shadow-md'));
                        this.classList.add('active', 'bg-unj-green', 'text-white', 'shadow-md');
                        renderCourses(this.dataset.faculty);
                    });
                });

                coursesGrid.addEventListener('click', e => {
                    if (e.target && e.target.classList.contains('open-modal-btn')) {
                        openModal(e.target);
                    }
                });

                closeModalBtn.addEventListener('click', closeModal);
                courseModal.addEventListener('click', e => {
                    if (e.target === courseModal) closeModal();
                });

                const activeTab = document.querySelector('#sustainability-courses .course-tab-btn.active');
                if (activeTab) {
                    renderCourses(activeTab.dataset.faculty);
                }
            }
        });
    </script>
</body>
@include('layout.footer')

</html>
