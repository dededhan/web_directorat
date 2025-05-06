<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ekosistem Inovasi UNJ | Direktorat Inovasi</title>
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
        .ekosistem-page {
            --primary-color: #277177;
            --secondary-color: #1d5559;
            --accent-color: #e74c3c;
            --light-color: #ecf0f1;
            --dark-color: #34495e;
            --success-color: #2ecc71;
        }

        /* Scoped styles to avoid conflicts */
        .ekosistem-page {
            background-color: #f5f5f5;
            color: #333;
            line-height: 1.6;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .ekosistem-container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        .ekosistem-hero {
            background: url('/api/placeholder/1200/600') center/cover no-repeat;
            height: 400px;
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

        .ekosistem-hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
        }

        .ekosistem-hero-content {
            position: relative;
            z-index: 1;
            padding: 2rem;
        }

        .ekosistem-hero h2 {
            font-size: 2.8rem;
            margin-bottom: 1rem;
        }

        .ekosistem-hero p {
            font-size: 1.2rem;
            max-width: 700px;
            margin: 0 auto;
        }

        .ekosistem-btn {
            display: inline-block;
            background-color: var(--primary-color);
            color: white;
            padding: 0.8rem 1.5rem;
            margin-top: 1rem;
            text-decoration: none;
            border-radius: 5px;
            font-weight: 500;
            transition: background-color 0.3s ease;
        }

        .ekosistem-btn:hover {
            background-color: #1d5559;
        }

        .ekosistem-section {
            background-color: white;
            padding: 2.5rem;
            margin-bottom: 2rem;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .ekosistem-section-title {
            color: var(--secondary-color);
            margin-bottom: 1.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid var(--primary-color);
        }

        .ekosistem-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-top: 2.5rem;
        }

        .ekosistem-card {
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .ekosistem-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }

        .ekosistem-card-img {
            height: 200px;
            background: url('/api/placeholder/400/200') center/cover no-repeat;
        }

        .ekosistem-card-content {
            padding: 1.5rem;
        }

        .ekosistem-card h3 {
            color: var(--secondary-color);
            margin-bottom: 1rem;
        }

        .ekosistem-card p {
            margin-bottom: 1rem;
            color: #666;
        }

        .ekosistem-pillars {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }

        .ekosistem-pillar {
            background-color: white;
            padding: 2rem;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .ekosistem-pillar:hover {
            transform: translateY(-5px);
        }

        .ekosistem-pillar-icon {
            background-color: var(--primary-color);
            color: white;
            width: 70px;
            height: 70px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 1.5rem;
        }

        .ekosistem-pillar h3 {
            color: var(--secondary-color);
            margin-bottom: 1rem;
        }

        .ekosistem-process {
            margin-top: 2rem;
            position: relative;
        }

        .ekosistem-process-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 3rem;
            position: relative;
        }

        .ekosistem-process-number {
            background-color: var(--primary-color);
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-right: 1.5rem;
            flex-shrink: 0;
            z-index: 2;
        }

        .ekosistem-process-content {
            flex: 1;
        }

        .ekosistem-process-title {
            color: var(--secondary-color);
            margin-bottom: 0.5rem;
            font-size: 1.2rem;
            font-weight: bold;
        }

        .ekosistem-process::before {
            content: '';
            position: absolute;
            top: 0;
            left: 20px;
            width: 2px;
            height: 100%;
            background-color: #e0e0e0;
            z-index: 1;
        }

        .ekosistem-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }

        .ekosistem-stat {
            background-color: white;
            padding: 1.5rem;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .ekosistem-stat-number {
            font-size: 2.5rem;
            font-weight: bold;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }

        .ekosistem-stat-title {
            color: var(--secondary-color);
            font-weight: 500;
        }

        .ekosistem-cta {
            background: linear-gradient(135deg, #277177, #1d5559);
            color: white;
            text-align: center;
            padding: 3rem 2rem;
            border-radius: 10px;
            margin: 3rem 0;
        }

        .ekosistem-cta h2 {
            font-size: 2rem;
            margin-bottom: 1rem;
        }

        .ekosistem-cta p {
            max-width: 700px;
            margin: 0 auto 1.5rem auto;
            font-size: 1.1rem;
        }

        .ekosistem-btn-cta {
            background-color: white;
            color: var(--primary-color);
            padding: 0.8rem 2rem;
            font-size: 1.1rem;
        }

        .ekosistem-btn-cta:hover {
            background-color: var(--light-color);
        }

        @media (max-width: 768px) {
            .ekosistem-hero {
                height: 300px;
            }

            .ekosistem-hero h2 {
                font-size: 2rem;
            }
        }
    </style>
</head>
@include('layout.navbar_hilirisasi')
<body>

    <div class="ekosistem-page">
        <div class="ekosistem-container">
            <div class="ekosistem-hero">
                <div class="ekosistem-hero-content">
                    <h2>Ekosistem Inovasi UNJ</h2>
                    {{-- <p>Membangun sinergi antara mahasiswa, peneliti, industri, dan pemerintah untuk menciptakan solusi inovatif yang berdampak pada masyarakat dan lingkungan.</p>
                    <a href="#" class="ekosistem-btn">Pelajari Lebih Lanjut</a> --}}
                </div>
            </div>

            <section class="ekosistem-section">
                <h2 class="ekosistem-section-title">Tentang Ekosistem Inovasi UNJ</h2>
                <p>Ekosistem Inovasi UNJ merupakan sebuah sistem kolaboratif yang menghubungkan berbagai pemangku kepentingan untuk menciptakan, mengembangkan, dan mengimplementasikan inovasi. Ekosistem ini dirancang untuk memfasilitasi transfer pengetahuan, teknologi, dan sumber daya antara mahasiswa, peneliti, industri, dan masyarakat.
                </p>
                {{-- <p>Dengan menggabungkan keunggulan akademik UNJ dan kebutuhan industri serta masyarakat, ekosistem inovasi ini bertujuan untuk menghasilkan solusi yang relevan, berkelanjutan, dan berdampak positif bagi perkembangan ekonomi, sosial, dan lingkungan.</p> --}}
                
                {{-- <div class="ekosistem-cards">
                    <div class="ekosistem-card">
                        <div class="ekosistem-card-img"></div>
                        <div class="ekosistem-card-content">
                            <h3>Kolaborasi Multidisiplin</h3>
                            <p>Membangun jembatan antara berbagai disiplin ilmu untuk menciptakan solusi inovatif yang komprehensif dan holistik.</p>
                            <a href="#" class="ekosistem-btn">Selengkapnya</a>
                        </div>
                    </div>
                    <div class="ekosistem-card">
                        <div class="ekosistem-card-img"></div>
                        <div class="ekosistem-card-content">
                            <h3>Kemitraan Industri</h3>
                            <p>Menghubungkan peneliti dan innovator dengan dunia industri untuk pengembangan produk dan jasa yang relevan dengan kebutuhan pasar.</p>
                            <a href="#" class="ekosistem-btn">Selengkapnya</a>
                        </div>
                    </div>
                    <div class="ekosistem-card">
                        <div class="ekosistem-card-img"></div>
                        <div class="ekosistem-card-content">
                            <h3>Pemberdayaan Masyarakat</h3>
                            <p>Menciptakan dampak sosial melalui inovasi yang diimplementasikan langsung ke masyarakat untuk meningkatkan kualitas hidup.</p>
                            <a href="#" class="ekosistem-btn">Selengkapnya</a>
                        </div>
                    </div>
                </div>
            </section>

            <section class="ekosistem-section">
                <h2 class="ekosistem-section-title">Pilar Ekosistem Inovasi</h2>
                <p>Ekosistem Inovasi UNJ dibangun di atas empat pilar utama yang saling terintegrasi untuk menciptakan lingkungan yang kondusif bagi tumbuhnya inovasi berkelanjutan:</p>
                
                <div class="ekosistem-pillars">
                    <div class="ekosistem-pillar">
                        <div class="ekosistem-pillar-icon">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <h3>Pendidikan</h3>
                        <p>Mengembangkan kurikulum yang mendorong pemikiran inovatif dan keterampilan kewirausahaan bagi mahasiswa dan peneliti.</p>
                    </div>
                    <div class="ekosistem-pillar">
                        <div class="ekosistem-pillar-icon">
                            <i class="fas fa-flask"></i>
                        </div>
                        <h3>Penelitian</h3>
                        <p>Mendukung penelitian yang berorientasi pada solusi dan memiliki potensi untuk dikomersialkan atau diterapkan di masyarakat.</p>
                    </div>
                    <div class="ekosistem-pillar">
                        <div class="ekosistem-pillar-icon">
                            <i class="fas fa-handshake"></i>
                        </div>
                        <h3>Kolaborasi</h3>
                        <p>Membangun jaringan kerjasama dengan berbagai pemangku kepentingan termasuk industri, pemerintah, dan masyarakat.</p>
                    </div>
                    <div class="ekosistem-pillar">
                        <div class="ekosistem-pillar-icon">
                            <i class="fas fa-lightbulb"></i>
                        </div>
                        <h3>Inkubasi</h3>
                        <p>Menyediakan dukungan dan sumber daya untuk mengembangkan ide inovatif menjadi produk atau layanan yang siap dipasarkan.</p>
                    </div>
                </div> --}}
            </section>

            <section class="ekosistem-section">
                <h2 class="ekosistem-section-title">Tujuan Ekosistem Inovasi di Perguruan Tinggi
                </h2>
                {{-- <p>Ekosistem Inovasi UNJ menerapkan pendekatan sistematis dalam proses inovasi, mulai dari tahap identifikasi masalah hingga implementasi dan evaluasi:</p>
                 --}}
                {{-- <div class="ekosistem-process"> --}}
                    <div class="ekosistem-process-item">
                        <div class="ekosistem-process-number">1</div>
                        <div class="ekosistem-process-content">
                            <div class="ekosistem-process-title">Mendorong terciptanya budaya inovasi di lingkungan kampus</div>
                            <p>Menanamkan nilai-nilai kreatif, kolaboratif, dan solutif dalam kegiatan akademik maupun non-akademik.</p>
                        </div>
                    </div>
                    <div class="ekosistem-process-item">
                        <div class="ekosistem-process-number">2</div>
                        <div class="ekosistem-process-content">
                            <div class="ekosistem-process-title">Memfasilitasi pengembangan riset yang aplikatif dan berdampak
                            </div>
                            <p>Meningkatkan kualitas dan relevansi penelitian agar dapat diimplementasikan dalam dunia industri, masyarakat, maupun kebijakan publik.
                            </p>
                        </div>
                    </div>
                    <div class="ekosistem-process-item">
                        <div class="ekosistem-process-number">3</div>
                        <div class="ekosistem-process-content">
                            <div class="ekosistem-process-title">Menjembatani kolaborasi antara kampus, industri, pemerintah, dan masyarakat (quadruple helix)</div>
                            <p>Membangun sinergi antaraktor dalam proses hilirisasi hasil penelitian menjadi produk, layanan, atau kebijakan yang bermanfaat.
                            </p>
                        </div>
                    </div>
                    <div class="ekosistem-process-item">
                        <div class="ekosistem-process-number">4</div>
                        <div class="ekosistem-process-content">
                            <div class="ekosistem-process-title">Mendukung pertumbuhan startup dan kewirausahaan berbasis teknologi pada civitas akademika
                            </div>
                            <p>Menjadi inkubator ide dan bisnis inovatif yang dapat membuka lapangan kerja dan meningkatkan daya saing nasional.
                            </p>
                        </div>
                    </div>
                    <div class="ekosistem-process-item">
                        <div class="ekosistem-process-number">5</div>
                        <div class="ekosistem-process-content">
                            <div class="ekosistem-process-title">Memperkuat sistem perlindungan dan pemanfaatan kekayaan intelektual (HKI)
                            </div>
                            <p>Mendorong dosen dan mahasiswa untuk menghasilkan karya inovatif yang dilindungi secara hukum dan berpotensi dikomersialisasikan.
                            </p>
                        </div>
                    </div>
                    <div class="ekosistem-process-item">
                        <div class="ekosistem-process-number">6</div>
                        <div class="ekosistem-process-content">
                            <div class="ekosistem-process-title">Menyediakan sarana, prasarana, dan kebijakan pendukung inovasi yang terintegrasi
                            </div>
                            <p>Membangun infrastruktur seperti laboratorium inovasi, maker space, pusat inkubasi bisnis, serta regulasi yang mendukung iklim inovatif.
                            </p>
                        </div>
                    </div>
                    <div class="ekosistem-process-item">
                        <div class="ekosistem-process-number">7</div>
                        <div class="ekosistem-process-content">
                            <div class="ekosistem-process-title">Menjadi pusat unggulan dalam pengembangan ilmu pengetahuan dan teknologi yang relevan dengan tantangan lokal dan global
                            </div>
                            <p>Berperan aktif dalam menjawab isu-isu strategis seperti pendidikan, lingkungan, energi, ekonomi kreatif, dan transformasi digital.
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            {{-- <section class="ekosistem-section">
                <h2 class="ekosistem-section-title">Pencapaian Ekosistem Inovasi UNJ</h2>
                
                <div class="ekosistem-stats">
                    <div class="ekosistem-stat">
                        <div class="ekosistem-stat-number">50+</div>
                        <div class="ekosistem-stat-title">Inovasi Terdaftar</div>
                    </div>
                    <div class="ekosistem-stat">
                        <div class="ekosistem-stat-number">25+</div>
                        <div class="ekosistem-stat-title">Kemitraan Industri</div>
                    </div>
                    <div class="ekosistem-stat">
                        <div class="ekosistem-stat-number">100+</div>
                        <div class="ekosistem-stat-title">Mahasiswa Terlibat</div>
                    </div>
                    <div class="ekosistem-stat">
                        <div class="ekosistem-stat-number">30+</div>
                        <div class="ekosistem-stat-title">Penghargaan Inovasi</div>
                    </div>
                </div>
                
                <div class="ekosistem-cards" style="margin-top: 2rem;">
                    <div class="ekosistem-card">
                        <div class="ekosistem-card-img"></div>
                        <div class="ekosistem-card-content">
                            <h3>Inovasi Pendidikan</h3>
                            <p>Mengembangkan teknologi dan metode pembelajaran inovatif yang telah diimplementasikan di berbagai institusi pendidikan.</p>
                            <a href="#" class="ekosistem-btn">Lihat Proyek</a>
                        </div>
                    </div>
                    <div class="ekosistem-card">
                        <div class="ekosistem-card-img"></div>
                        <div class="ekosistem-card-content">
                            <h3>Inovasi Sosial</h3>
                            <p>Menciptakan solusi untuk permasalahan sosial yang berdampak langsung pada peningkatan kualitas hidup masyarakat.</p>
                            <a href="#" class="ekosistem-btn">Lihat Proyek</a>
                        </div>
                    </div>
                    <div class="ekosistem-card">
                        <div class="ekosistem-card-img"></div>
                        <div class="ekosistem-card-content">
                            <h3>Inovasi Teknologi</h3>
                            <p>Mengembangkan teknologi yang membantu meningkatkan efisiensi dan efektivitas dalam berbagai sektor industri.</p>
                            <a href="#" class="ekosistem-btn">Lihat Proyek</a>
                        </div>
                    </div>
                </div>
            </section> --}}

            <div class="ekosistem-cta">
                <h2>Bergabunglah dengan Ekosistem Inovasi UNJ</h2>
                <p>Jadilah bagian dari komunitas inovator yang berdedikasi untuk menciptakan perubahan positif melalui kolaborasi dan pemikiran kreatif.</p>
                <a href="#" class="ekosistem-btn ekosistem-btn-cta">Bergabung Sekarang</a>
            </div>
        </div>
    </div>

</body>
@include('layout.footer')
</html>