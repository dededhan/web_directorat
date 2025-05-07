<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Innovator Award | Direktorat Inovasi</title>
    <link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" type="image/png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
    <link rel="stylesheet" href="{{ asset('home.css') }}">
    <style>
        /* Custom variables */
        .award-page {
            --primary-color: #277177;
            --secondary-color: #1d5559;
            --accent-color: #f39c12;
            --light-color: #ecf0f1;
            --dark-color: #34495e;
            --success-color: #2ecc71;
        }


        /* Scoped styles to avoid conflicts */
        .award-page {
            background-color: #f5f5f5;
            color: #333;
            line-height: 1.6;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }


        .award-container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
        }


        .award-hero {
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('/api/placeholder/1200/600') center/cover no-repeat;
            height: 500px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-align: center;
            position: relative;
            margin-bottom: 3rem;
            border-radius: 10px;
            overflow: hidden;
        }


        .award-hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(39, 113, 119, 0.8), rgba(29, 85, 89, 0.8));
            mix-blend-mode: multiply;
        }


        .award-hero-content {
            position: relative;
            z-index: 1;
            padding: 2rem;
            max-width: 800px;
        }


        .award-hero h2 {
            font-size: 3.2rem;
            margin-bottom: 1rem;
            font-weight: 700;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }


        .award-hero p {
            font-size: 1.3rem;
            max-width: 800px;
            margin: 0 auto 1.5rem auto;
            line-height: 1.7;
        }


        .award-tagline {
            font-size: 1.5rem;
            font-weight: 500;
            margin-bottom: 1.5rem;
            color: var(--accent-color);
        }


        .award-btn {
            display: inline-block;
            background-color: var(--primary-color);
            color: white;
            padding: 0.8rem 1.8rem;
            margin-top: 1.5rem;
            text-decoration: none;
            border-radius: 5px;
            font-weight: 500;
            transition: all 0.3s ease;
            border: 2px solid transparent;
            font-size: 1.1rem;
        }


        .award-btn:hover {
            background-color: transparent;
            border: 2px solid white;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }


        .award-section {
            background-color: white;
            padding: 3rem;
            margin-bottom: 2.5rem;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }


        .award-section-title {
            color: var(--secondary-color);
            margin-bottom: 1.5rem;
            padding-bottom: 0.8rem;
            border-bottom: 3px solid var(--primary-color);
            font-size: 2rem;
            font-weight: 700;
            position: relative;
        }


        .award-intro {
            font-size: 1.1rem;
            line-height: 1.8;
            margin-bottom: 2rem;
            color: #555;
        }


        .award-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-top: 2.5rem;
        }


        .award-card {
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: 1px solid #eee;
        }


        .award-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        }


        .award-card-img {
            height: 200px;
            background: linear-gradient(rgba(39, 113, 119, 0.3), rgba(29, 85, 89, 0.5)), url('/api/placeholder/400/200') center/cover no-repeat;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }


        .award-card-icon {
            font-size: 3rem;
            color: white;
            text-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
        }


        .award-card-content {
            padding: 1.8rem;
        }


        .award-card h3 {
            color: var(--secondary-color);
            margin-bottom: 1rem;
            font-size: 1.5rem;
            font-weight: 600;
        }


        .award-card p {
            margin-bottom: 1.5rem;
            color: #666;
            line-height: 1.7;
        }


        .award-features {
            margin-top: 2.5rem;
        }


        .award-feature {
            display: flex;
            margin-bottom: 2rem;
            align-items: flex-start;
            background-color: #f9f9f9;
            padding: 1.5rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }


        .award-feature:hover {
            transform: translateX(5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }


        .award-feature-icon {
            background-color: var(--primary-color);
            color: white;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1.5rem;
            flex-shrink: 0;
            font-weight: bold;
            font-size: 1.2rem;
            box-shadow: 0 3px 8px rgba(39, 113, 119, 0.3);
        }


        .award-feature-content {
            flex: 1;
        }


        .award-feature h3 {
            margin-bottom: 0.8rem;
            color: var(--secondary-color);
            font-size: 1.3rem;
            font-weight: 600;
        }


        .award-purpose-list {
            margin: 2rem 0;
            list-style-type: none;
        }


        .award-purpose-item {
            padding: 1rem 0 1rem 2.5rem;
            position: relative;
            margin-bottom: 0.5rem;
            font-size: 1.1rem;
            color: #555;
        }


        .award-purpose-item:before {
            content: '\f00c';
            font-family: 'Font Awesome 5 Free';
            font-weight: 900;
            position: absolute;
            left: 0;
            top: 1rem;
            color: var(--primary-color);
            font-size: 1.2rem;
        }


        .award-winners {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }


        .award-winner {
            background-color: #f9f9f9;
            padding: 2rem;
            border-radius: 10px;
            text-align: center;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }


        .award-winner:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }


        .award-winner-img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            margin: 0 auto 1.5rem auto;
            background: url('/api/placeholder/200/200') center/cover no-repeat;
            border: 5px solid var(--primary-color);
            box-shadow: 0 5px 15px rgba(39, 113, 119, 0.3);
        }


        .award-winner h3 {
            color: var(--secondary-color);
            margin-bottom: 0.8rem;
            font-size: 1.5rem;
            font-weight: 600;
        }


        .award-winner-title {
            color: var(--accent-color);
            font-weight: 600;
            margin-bottom: 1rem;
            font-size: 1.1rem;
        }


        .award-winner p {
            color: #666;
            font-style: italic;
            line-height: 1.6;
        }


        .award-timeline {
            position: relative;
            max-width: 800px;
            margin: 3rem auto;
            padding: 1rem 0;
        }


        .award-timeline::before {
            content: '';
            position: absolute;
            width: 4px;
            background-color: var(--primary-color);
            top: 0;
            bottom: 0;
            left: 50%;
            margin-left: -2px;
            border-radius: 2px;
        }


        .award-timeline-item {
            padding: 1rem 2rem;
            position: relative;
            width: 50%;
            box-sizing: border-box;
        }


        .award-timeline-item:nth-child(odd) {
            left: 0;
            text-align: right;
        }


        .award-timeline-item:nth-child(even) {
            left: 50%;
        }


        .award-timeline-item::after {
            content: '';
            position: absolute;
            width: 24px;
            height: 24px;
            right: -12px;
            background-color: white;
            border: 4px solid var(--accent-color);
            top: 1.5rem;
            border-radius: 50%;
            z-index: 1;
            box-shadow: 0 3px 8px rgba(243, 156, 18, 0.3);
        }


        .award-timeline-item:nth-child(even)::after {
            left: -12px;
        }


        .award-timeline-content {
            padding: 1.5rem;
            background-color: white;
            position: relative;
            border-radius: 8px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }


        .award-timeline-content:hover {
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            transform: translateY(-3px);
        }


        .award-timeline-date {
            color: var(--accent-color);
            font-weight: bold;
            font-size: 1.3rem;
            margin-bottom: 0.5rem;
        }


        .award-cta {
            background: linear-gradient(135deg, #277177, #1d5559);
            color: white;
            text-align: center;
            padding: 4rem 2rem;
            border-radius: 15px;
            margin: 4rem 0;
            box-shadow: 0 10px 30px rgba(39, 113, 119, 0.3);
        }


        .award-cta h2 {
            font-size: 2.5rem;
            margin-bottom: 1.5rem;
            font-weight: 700;
        }


        .award-cta p {
            max-width: 800px;
            margin: 0 auto 2rem auto;
            font-size: 1.2rem;
            line-height: 1.8;
        }


        .award-btn-cta {
            background-color: white;
            color: var(--primary-color);
            padding: 1rem 2.5rem;
            font-size: 1.2rem;
            font-weight: 600;
            border: 2px solid white;
        }


        .award-btn-cta:hover {
            background-color: transparent;
            color: white;
        }


        .award-categories {
            margin: 2.5rem 0;
        }


        .award-category {
            background-color: #f9f9f9;
            border-left: 4px solid var(--primary-color);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            border-radius: 0 8px 8px 0;
            transition: all 0.3s ease;
        }


        .award-category:hover {
            transform: translateX(5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }


        .award-category h3 {
            color: var(--secondary-color);
            margin-bottom: 0.5rem;
            font-size: 1.3rem;
            font-weight: 600;
        }


        .award-category p {
            color: #666;
            margin-bottom: 0;
        }


        .award-benefits {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin: 2.5rem 0;
        }


        .award-benefit {
            text-align: center;
            padding: 2rem;
            background-color: #f9f9f9;
            border-radius: 10px;
            transition: all 0.3s ease;
        }


        .award-benefit:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }


        .award-benefit-icon {
            background-color: #ecf7f8;
            color: var(--primary-color);
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem auto;
            font-size: 2rem;
            box-shadow: 0 5px 15px rgba(39, 113, 119, 0.2);
        }


        .award-benefit h3 {
            color: var(--secondary-color);
            margin-bottom: 1rem;
            font-size: 1.3rem;
            font-weight: 600;
        }


        .award-benefit p {
            color: #666;
        }


        .award-stats {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            margin: 3rem 0;
            text-align: center;
        }


        .award-stat {
            padding: 1.5rem;
            margin: 1rem;
        }


        .award-stat-number {
            font-size: 3rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }


        .award-stat-label {
            font-size: 1.1rem;
            color: #666;
        }


        @media (max-width: 768px) {
            .award-hero {
                height: auto;
                min-height: 400px;
                padding: 3rem 1rem;
            }


            .award-hero h2 {
                font-size: 2.3rem;
            }


            .award-hero p {
                font-size: 1.1rem;
            }


            .award-section {
                padding: 2rem;
            }


            .award-timeline::before {
                left: 31px;
            }


            .award-timeline-item {
                width: 100%;
                padding-left: 70px;
                padding-right: 0;
            }


            .award-timeline-item:nth-child(odd) {
                text-align: left;
            }


            .award-timeline-item:nth-child(even) {
                left: 0;
            }


            .award-timeline-item::after {
                left: 21px;
                right: auto;
            }


            .award-timeline-item:nth-child(even)::after {
                left: 21px;
            }


            .award-cards,
            .award-winners,
            .award-benefits {
                grid-template-columns: 1fr;
            }


            .award-stats {
                flex-direction: column;
            }
        }
    </style>
</head>
@include('layout.navbar_hilirisasi')
<body>


    <div class="award-page">
        <div class="award-container">
            <div class="award-hero">
                <div class="award-hero-content">
                    <h2>Innovator Award</h2>
                    <div class="award-tagline">Menginspirasi Inovasi, Mewujudkan Perubahan</div>
                    {{-- <p>Penghargaan prestisius yang mengakui dan merayakan pencapaian luar biasa sivitas akademik dalam bidang inovasi, kreativitas, dan kontribusi nyata bagi masyarakat, industri, dan kemajuan ilmu pengetahuan dan teknologi.</p>
                    <a href="#nominate" class="award-btn">Nominasikan Sekarang</a> --}}
                </div>
            </div>


            <section class="award-section">
                <h2 class="award-section-title">Tentang Innovator Award</h2>
                <p class="award-intro"><strong>Innovator Award</strong> merupakan bentuk apresiasi dan penghargaan yang diberikan kepada sivitas akademik yang berhasil menciptakan inovasi berdampak di bidang pendidikan, teknologi, sosial, lingkungan, atau ekonomi kreatif. Penghargaan ini menjadi bagian dari strategi perguruan tinggi dalam membangun <strong>ekosistem inovasi yang produktif, kompetitif, dan berkelanjutan</strong>.</p>
               
                <h3 class="text-xl font-bold text-gray-700 mb-3">Tujuan Innovator Award</h3>
                <ul class="award-purpose-list">
                    <li class="award-purpose-item">Mendorong semangat kreativitas, penelitian terapan, dan pemecahan masalah nyata di lingkungan kampus.</li>
                    <li class="award-purpose-item">Mengapresiasi karya inovatif yang memberi kontribusi nyata bagi masyarakat, industri, atau pengembangan ilmu pengetahuan.</li>
                    <li class="award-purpose-item">Meningkatkan visibilitas dan motivasi sivitas akademika untuk terlibat aktif dalam kegiatan inovasi dan kewirausahaan.</li>
                    <li class="award-purpose-item">Menjadi insentif non-finansial yang mendukung hilirisasi hasil riset.</li>
                </ul>
               
                {{-- <div class="award-stats">
                    <div class="award-stat">
                        <div class="award-stat-number">100+</div>
                        <div class="award-stat-label">Innovator Terdaftar</div>
                    </div>
                    <div class="award-stat">
                        <div class="award-stat-number">25+</div>
                        <div class="award-stat-label">Inovasi Berdampak</div>
                    </div>
                    <div class="award-stat">
                        <div class="award-stat-number">5</div>
                        <div class="award-stat-label">Kategori Inovasi</div>
                    </div>
                    <div class="award-stat">
                        <div class="award-stat-number">10+</div>
                        <div class="award-stat-label">Mitra Industri</div>
                    </div>
                </div> --}}
               
                {{-- <div class="award-cards">
                    <div class="award-card">
                        <div class="award-card-img">
                            <div class="award-card-icon"><i class="fas fa-lightbulb"></i></div>
                        </div>
                        <div class="award-card-content">
                            <h3>Inovasi Teknologi</h3>
                            <p>Penghargaan untuk terobosan teknologi yang inovatif dan memiliki potensi untuk mengubah paradigma atau menciptakan solusi baru terhadap tantangan yang ada.</p>
                            <a href="#" class="award-btn">Detail Kategori</a>
                        </div>
                    </div>
                    <div class="award-card">
                        <div class="award-card-img">
                            <div class="award-card-icon"><i class="fas fa-graduation-cap"></i></div>
                        </div>
                        <div class="award-card-content">
                            <h3>Inovasi Pendidikan</h3>
                            <p>Menghargai inovasi dalam metode pembelajaran, kurikulum, atau teknologi pendidikan yang meningkatkan kualitas dan aksesibilitas pendidikan.</p>
                            <a href="#" class="award-btn">Detail Kategori</a>
                        </div>
                    </div>
                    <div class="award-card">
                        <div class="award-card-img">
                            <div class="award-card-icon"><i class="fas fa-hands-helping"></i></div>
                        </div>
                        <div class="award-card-content">
                            <h3>Inovasi Sosial</h3>
                            <p>Penghargaan untuk solusi inovatif yang mengatasi tantangan sosial, lingkungan, atau ekonomi dan berkontribusi pada kesejahteraan masyarakat.</p>
                            <a href="#" class="award-btn">Detail Kategori</a>
                        </div>
                    </div>
                </div> --}}
            </section>


            <section class="award-section">
                <h2 class="award-section-title">Kategori Penghargaan</h2>
                <p class="award-intro">Kami mengakui berbagai bentuk inovasi yang muncul dari berbagai disiplin ilmu dan latar belakang. Berikut adalah kategori-kategori penghargaan yang tersedia:</p>
               
                <div class="award-categories">
                    <div class="award-category">
                        <h3><i class="fas fa-microchip mr-2"></i> Inovasi Teknologi</h3>
                        <p>Produk digital, alat, sistem, atau proses berbasis teknologi baru yang menawarkan solusi inovatif.</p>
                    </div>
                    <div class="award-category">
                        <h3><i class="fas fa-chalkboard-teacher mr-2"></i> Inovasi Pendidikan</h3>
                        <p>Model pembelajaran, media ajar, atau pendekatan edukatif yang berdampak signifikan pada proses pembelajaran.</p>
                    </div>
                    <div class="award-category">
                        <h3><i class="fas fa-users mr-2"></i> Inovasi Sosial</h3>
                        <p>Solusi kreatif untuk tantangan sosial, budaya, atau lingkungan yang berkontribusi pada kesejahteraan masyarakat.</p>
                    </div>
                    <div class="award-category">
                        <h3><i class="fas fa-user-graduate mr-2"></i> Inovasi Mahasiswa</h3>
                        <p>Inovasi yang dikembangkan oleh individu atau tim mahasiswa yang menunjukkan kreativitas dan potensial tinggi.</p>
                    </div>
                    <div class="award-category">
                        <h3><i class="fas fa-rocket mr-2"></i> Startup Inovatif</h3>
                        <p>Usaha rintisan yang berbasis hasil riset atau temuan baru dari kampus dengan model bisnis yang menjanjikan.</p>
                    </div>
                </div>
            </section>


            <section class="award-section">
                <h2 class="award-section-title">Kriteria Penilaian</h2>
                <div class="award-features">
                    <div class="award-feature">
                        <div class="award-feature-icon">1</div>
                        <div class="award-feature-content">
                            <h3>Kebaruan & Orisinalitas</h3>
                            <p>Sejauh mana inovasi menawarkan pendekatan, konsep, atau solusi baru yang belum pernah ada sebelumnya, atau merupakan adaptasi kreatif dari solusi yang sudah ada.</p>
                        </div>
                    </div>
                    <div class="award-feature">
                        <div class="award-feature-icon">2</div>
                        <div class="award-feature-content">
                            <h3>Dampak & Kebermanfaatan</h3>
                            <p>Besarnya dampak positif yang dihasilkan oleh inovasi, termasuk manfaat ekonomi, sosial, lingkungan, atau pendidikan, serta potensi keberlanjutannya.</p>
                        </div>
                    </div>
                    <div class="award-feature">
                        <div class="award-feature-icon">3</div>
                        <div class="award-feature-content">
                            <h3>Potensi Pengembangan</h3>
                            <p>Kemampuan inovasi untuk ditingkatkan skala dan diterapkan dalam konteks yang lebih luas atau berbeda dari yang semula dirancang.</p>
                        </div>
                    </div>
                    <div class="award-feature">
                        <div class="award-feature-icon">4</div>
                        <div class="award-feature-content">
                            <h3>Kolaborasi & Multidisiplin</h3>
                            <p>Tingkat kolaborasi antara berbagai disiplin ilmu, fakultas, atau bahkan dengan pihak eksternal dalam pengembangan inovasi.</p>
                        </div>
                    </div>
                    <div class="award-feature">
                        <div class="award-feature-icon">5</div>
                        <div class="award-feature-content">
                            <h3>Kesesuaian dengan Nilai Perguruan Tinggi</h3>
                            <p>Sejauh mana inovasi mencerminkan dan mendukung nilai-nilai inti dan misi strategis perguruan tinggi.</p>
                        </div>
                    </div>
                </div>
            </section>


            {{-- <section class="award-section">
                <h2 class="award-section-title">Pemenang Sebelumnya</h2>
                <div class="award-winners">
                    <div class="award-winner">
                        <div class="award-winner-img"></div>
                        <h3>Dr. Adi Wijaya</h3>
                        <p class="award-winner-title">Inovasi Teknologi</p>
                        <p>"Pengembangan Sistem Kecerdasan Buatan untuk Deteksi Dini Penyakit Tropis"</p>
                    </div>
                    <div class="award-winner">
                        <div class="award-winner-img"></div>
                        <h3>Tim Edukasi Digital</h3>
                        <p class="award-winner-title">Inovasi Pendidikan</p>
                        <p>"Platform Pembelajaran Adaptif untuk Daerah Terpencil"</p>
                    </div>
                    <div class="award-winner">
                        <div class="award-winner-img"></div>
                        <h3>Siti Nurhaliza</h3>
                        <p class="award-winner-title">Inovasi Sosial</p>
                        <p>"Sistem Pengelolaan Sampah Berbasis Komunitas"</p>
                    </div>
                </div>
            </section> --}}


            <section class="award-section">
                <h2 class="award-section-title">Manfaat dan Penghargaan</h2>
                <p class="award-intro">Para pemenang Innovator Award akan menerima berbagai manfaat yang dirancang untuk mendukung pengembangan inovasi mereka lebih lanjut dan meningkatkan visibilitas karya mereka:</p>
               
                <div class="award-benefits">
                    <div class="award-benefit">
                        <div class="award-benefit-icon"><i class="fas fa-trophy"></i></div>
                        <h3>Piagam & Trofi</h3>
                        <p>Penghargaan fisik berupa piagam penghargaan dan trofi sebagai bukti pengakuan atas prestasi inovatif.</p>
                    </div>
                    <div class="award-benefit">
                        <div class="award-benefit-icon"><i class="fas fa-bullhorn"></i></div>
                        <h3>Publikasi Media</h3>
                        <p>Publikasi karya di platform kampus atau media mitra untuk meningkatkan visibilitas dan pengakuan.</p>
                    </div>
                    <div class="award-benefit">
                        <div class="award-benefit-icon"><i class="fas fa-seedling"></i></div>
                        <h3>Program Inkubasi</h3>
                        <p>Akses ke program inkubasi untuk mengembangkan inovasi menjadi produk atau layanan yang siap pasar.</p>
                    </div>
                    <div class="award-benefit">
                        <div class="award-benefit-icon"><i class="fas fa-handshake"></i></div>
                        <h3>Jaringan Mitra</h3>
                        <p>Kesempatan untuk terhubung dengan jaringan mentor, investor, dan mitra industri potensial.</p>
                    </div>
                </div>
            </section>


            {{-- <section class="award-section">
                <h2 class="award-section-title">Timeline Pendaftaran</h2>
                <div class="award-timeline">
                    <div class="award-timeline-item">
                        <div class="award-timeline-content">
                            <h3 class="award-timeline-date">Tahap 1</h3>
                            <p>Periode Pendaftaran dan Pengajuan Nominasi</p>
                            <p class="text-sm text-gray-500 mt-2">1 Juni - 31 Juli 2025</p>
                        </div>
                    </div>
                    <div class="award-timeline-item">
                        <div class="award-timeline-content">
                            <h3 class="award-timeline-date">Tahap 2</h3>
                            <p>Penilaian dan Seleksi oleh Dewan Juri</p>
                            <p class="text-sm text-gray-500 mt-2">1 - 31 Agustus 2025</p>
                        </div>
                    </div>
                    <div class="award-timeline-item">
                        <div class="award-timeline-content">
                            <h3 class="award-timeline-date">Tahap 3</h3>
                            <p>Pengumuman Finalis</p>
                            <p class="text-sm text-gray-500 mt-2">15 September 2025</p>
                        </div>
                    </div>
                    <div class="award-timeline-item">
                        <div class="award-timeline-content">
                            <h3 class="award-timeline-date">Tahap 4</h3>
                            <p>Presentasi Finalis di Hadapan Dewan Juri</p>
                            <p class="text-sm text-gray-500 mt-2">1 - 15 Oktober 2025</p>
                        </div>
                    </div>
                    <div class="award-timeline-item">
                        <div class="award-timeline-content">
                            <h3 class="award-timeline-date">Tahap 5</h3>
                            <p>Malam Penganugerahan Innovator Award</p>
                            <p class="text-sm text-gray-500 mt-2">10 November 2025</p>
                        </div>
                    </div>
                </div>
            </section>


            <section class="award-section" id="nominate">
                <h2 class="award-section-title">Proses Nominasi</h2>
                <p class="award-intro">Nominasi untuk Innovator Award dapat diajukan baik melalui nominasi diri sendiri maupun direkomendasikan oleh pihak lain. Berikut adalah tahapan proses nominasi:</p>
               
                <div class="award-features">
                    <div class="award-feature">
                        <div class="award-feature-icon"><i class="fas fa-file-alt"></i></div>
                        <div class="award-feature-content">
                            <h3>Penyiapan Dokumen</h3>
                            <p>Siapkan deskripsi inovasi, bukti implementasi, dan dokumentasi dampak. Formulir nominasi dapat diunduh melalui tautan di bawah.</p>
                        </div>
                    </div>
                    <div class="award-feature">
                        <div class="award-feature-icon"><i class="fas fa-upload"></i></div>
                        <div class="award-feature-content">
                            <h3>Pengajuan Nominasi</h3>
                            <p>Kirimkan formulir nominasi beserta dokumen pendukung melalui sistem elektronik atau email ke alamat yang tersedia.</p>
                        </div>
                    </div>
                    <div class="award-feature">
                        <div class="award-feature-icon"><i class="fas fa-clipboard-check"></i></div>
                        <div class="award-feature-content">
                            <h3>Verifikasi Eligibilitas</h3>
                            <p>Tim kami akan memverifikasi kelengkapan dokumen dan eligibilitas nominasi sesuai dengan kategori yang dipilih.</p>
                        </div>
                    </div>
                    <div class="award-feature">
                        <div class="award-feature-icon"><i class="fas fa-comment-dots"></i></div>
                        <div class="award-feature-content">
                            <h3>Wawancara (Jika Diperlukan)</h3>
                            <p>Beberapa nominator mungkin akan dihubungi untuk wawancara atau diminta menyediakan informasi tambahan.</p>
                        </div>
                    </div>
                </div>
               
                <div class="flex justify-center mt-8">
                    <a href="#" class="award-btn px-8 py-3 text-lg"><i class="fas fa-download mr-2"></i> Unduh Formulir Nominasi</a>
                </div>
            </section> --}}


            <div class="award-cta">
                <h2>Jadilah Bagian dari Gerakan Inovasi</h2>
                <p>Apakah Anda memiliki inovasi yang berpotensi mengubah dunia? Atau mengenal seseorang yang layak mendapatkan pengakuan atas kontribusi inovatifnya? Innovator Award adalah kesempatan untuk merayakan karya kreatif yang berdampak dan menginspirasi generasi innovator berikutnya.</p>
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="#" class="award-btn award-btn-cta"><i class="fas fa-paper-plane mr-2"></i> Ajukan Nominasi</a>
                    <a href="#" class="award-btn"><i class="fas fa-info-circle mr-2"></i> Informasi Lebih Lanjut</a>
                </div>
            </div>
{{--            
            <section class="award-section">
                <h2 class="award-section-title">Pertanyaan Umum</h2>
               
                <div class="space-y-6 mt-6">
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Siapa yang dapat dinominasikan untuk Innovator Award?</h3>
                        <p class="text-gray-600">Semua sivitas akademika termasuk dosen, peneliti, mahasiswa, dan staf yang telah mengembangkan inovasi dengan dampak nyata dapat dinominasikan.</p>
                    </div>
                   
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Apakah saya bisa menominasikan diri sendiri?</h3>
                        <p class="text-gray-600">Ya, nominasi diri sendiri diterima dan didorong. Kami percaya bahwa para innovator perlu kesempatan untuk mempresentasikan karya mereka sendiri.</p>
                    </div>
                   
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Apa saja dokumen yang perlu disiapkan?</h3>
                        <p class="text-gray-600">Dokumen nominasi termasuk formulir aplikasi, deskripsi inovasi, bukti implementasi dan dampak, serta dokumentasi pendukung seperti gambar, video, atau testimoni.</p>
                    </div>
                   
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Bagaimana proses seleksi dilakukan?</h3>
                        <p class="text-gray-600">Seleksi dilakukan oleh panel juri yang terdiri dari akademisi, praktisi industri, dan pakar inovasi, berdasarkan kriteria penilaian yang telah ditetapkan.</p>
                    </div>
                </div>
            </section> --}}
        </div>
    </div>


</body>
@include('layout.footer')
