<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inkubator Bisnis dan Pendidikan | Direktorat Inovasi</title>
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
        .inkubator-page {
            --primary-color: #277177;
            --secondary-color: #1d5559;
            --accent-color: #e74c3c;
            --light-color: #ecf0f1;
            --dark-color: #34495e;
            --success-color: #2ecc71;
        }

        /* Scoped styles to avoid conflicts */
        .inkubator-page {
            background-color: #f5f5f5;
            color: #333;
            line-height: 1.6;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .inkubator-container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        .inkubator-hero {
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

        .inkubator-hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
        }

        .inkubator-hero-content {
            position: relative;
            z-index: 1;
            padding: 2rem;
        }

        .inkubator-hero h2 {
            font-size: 2.8rem;
            margin-bottom: 1rem;
        }

        .inkubator-hero p {
            font-size: 1.2rem;
            max-width: 700px;
            margin: 0 auto;
        }

        .inkubator-btn {
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

        .inkubator-btn:hover {
            background-color: #1d5559;
        }

        .inkubator-section {
            background-color: white;
            padding: 2.5rem;
            margin-bottom: 2rem;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .inkubator-section-title {
            color: var(--secondary-color);
            margin-bottom: 1.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid var(--primary-color);
        }

        .inkubator-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-top: 2.5rem;
        }

        .inkubator-card {
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .inkubator-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }

        .inkubator-card-img {
            height: 200px;
            background: url('/api/placeholder/400/200') center/cover no-repeat;
        }

        .inkubator-card-content {
            padding: 1.5rem;
        }

        .inkubator-card h3 {
            color: var(--secondary-color);
            margin-bottom: 1rem;
        }

        .inkubator-card p {
            margin-bottom: 1rem;
            color: #666;
        }

        .inkubator-features {
            margin-top: 2rem;
        }

        .inkubator-feature {
            display: flex;
            margin-bottom: 1.5rem;
            align-items: flex-start;
        }

        .inkubator-feature-icon {
            background-color: var(--primary-color);
            color: white;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            flex-shrink: 0;
        }

        .inkubator-feature-content {
            flex: 1;
        }

        .inkubator-feature h3 {
            margin-bottom: 0.5rem;
            color: var(--secondary-color);
        }

        .inkubator-testimonials {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        .inkubator-testimonial {
            background-color: var(--light-color);
            padding: 1.5rem;
            border-radius: 8px;
            position: relative;
        }

        .inkubator-testimonial p {
            font-style: italic;
            margin-bottom: 1rem;
        }

        .inkubator-testimonial-author {
            font-weight: bold;
            color: var(--secondary-color);
        }

        .inkubator-testimonial::before {
            content: '"';
            font-size: 4rem;
            position: absolute;
            top: -20px;
            left: 10px;
            color: var(--primary-color);
            opacity: 0.2;
        }

        .inkubator-cta {
            background: linear-gradient(135deg, #277177, #1d5559);
            color: white;
            text-align: center;
            padding: 3rem 2rem;
            border-radius: 10px;
            margin: 3rem 0;
        }

        .inkubator-cta h2 {
            font-size: 2rem;
            margin-bottom: 1rem;
        }

        .inkubator-cta p {
            max-width: 700px;
            margin: 0 auto 1.5rem auto;
            font-size: 1.1rem;
        }

        .inkubator-btn-cta {
            background-color: white;
            color: var(--primary-color);
            padding: 0.8rem 2rem;
            font-size: 1.1rem;
        }

        .inkubator-btn-cta:hover {
            background-color: var(--light-color);
        }

        /* List styling */
        .inkubator-list {
            margin-left: 20px;
            margin-bottom: 1rem;
        }

        .inkubator-list li {
            margin-bottom: 0.5rem;
            position: relative;
            padding-left: 1.5rem;
        }

        .inkubator-list li::before {
            content: '•';
            color: var(--primary-color);
            font-weight: bold;
            position: absolute;
            left: 0;
        }

        @media (max-width: 768px) {
            .inkubator-hero {
                height: 300px;
            }

            .inkubator-hero h2 {
                font-size: 2rem;
            }
        }
    </style>
</head>
@include('layout.navbar_hilirisasi')
<body>

    <div class="inkubator-page">
        <div class="inkubator-container">
            <div class="inkubator-hero">
                <div class="inkubator-hero-content">
                    <h2>Inkubator Bisnis</h2>
                    <p>Menjembatani Inovasi Akademik dengan Kebutuhan Industri dan Masyarakat</p>
                    <a href="#" class="inkubator-btn">Pelajari Lebih Lanjut</a>
                </div>
            </div>

            <section class="inkubator-section">
                <h2 class="inkubator-section-title">Tentang Inkubator Bisnis</h2>
                <p>Inkubator bisnis adalah unit yang dibentuk untuk mendukung dosen, mahasiswa dan alumni dalam mengembangkan ide bisnis menjadi usaha nyata. Inkubator ini menjadi jembatan antara hasil pendidikan dan riset dengan kebutuhan dunia industri dan masyarakat.</p>
                <p>Melalui program ini, kami membantu mengubah potensi akademik menjadi solusi bisnis yang berkelanjutan dan berdampak positif terhadap masyarakat.</p>
                
                <div class="inkubator-features">
                    <div class="inkubator-feature">
                        <div class="inkubator-feature-icon">1</div>
                        <div class="inkubator-feature-content">
                            <h3>Tujuan Utama</h3>
                            <ul class="inkubator-list">
                                <li>Menumbuhkan jiwa kewirausahaan di kalangan sivitas akademika.</li>
                                <li>Mendorong hilirisasi hasil riset dan inovasi.</li>
                                <li>Menyediakan wadah pengembangan usaha rintisan (startup).</li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="inkubator-feature">
                        <div class="inkubator-feature-icon">2</div>
                        <div class="inkubator-feature-content">
                            <h3>Peran Inkubator Bisnis dalam Pendidikan Tinggi</h3>
                            <ul class="inkubator-list">
                                <li>Wadah Edukasi Praktis</li>
                                <li>Komersialisasi Inovasi</li>
                                <li>Pembinaan dan Pendampingan</li>
                                <li>Peluang Pendanaan</li>
                                <li>Kolaborasi Multi-Pihak</li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="inkubator-feature">
                        <div class="inkubator-feature-icon">3</div>
                        <div class="inkubator-feature-content">
                            <h3>Manfaat Inkubator Bisnis bagi Perguruan Tinggi</h3>
                            <ul class="inkubator-list">
                                <li>Meningkatkan reputasi dan kontribusi kampus dalam pembangunan ekonomi.</li>
                                <li>Menjadi indikator kinerja tridharma perguruan tinggi (terutama dalam pengabdian dan inovasi).</li>
                                <li>Menciptakan lulusan yang lebih siap kerja dan bahkan siap menciptakan lapangan kerja.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>

            <section class="inkubator-section">
                <h2 class="inkubator-section-title">Program Kami</h2>
                <div class="inkubator-cards">
                    <div class="inkubator-card">
                        <div class="inkubator-card-img"></div>
                        <div class="inkubator-card-content">
                            <h3>Program Mentoring</h3>
                            <p>Akses ke jaringan mentor berpengalaman yang memberikan bimbingan strategis untuk pengembangan bisnis inovatif.</p>
                            <a href="#" class="inkubator-btn">Detail Program</a>
                        </div>
                    </div>
                    <div class="inkubator-card">
                        <div class="inkubator-card-img"></div>
                        <div class="inkubator-card-content">
                            <h3>Pendanaan Startup</h3>
                            <p>Membantu usaha rintisan mendapatkan akses ke berbagai sumber pendanaan, termasuk investor dan program kemitraan.</p>
                            <a href="#" class="inkubator-btn">Detail Program</a>
                        </div>
                    </div>
                    <div class="inkubator-card">
                        <div class="inkubator-card-img"></div>
                        <div class="inkubator-card-content">
                            <h3>Akses Pasar</h3>
                            <p>Membangun jembatan antara startup kampus dengan pasar potensial melalui jaringan industri dan mitra strategis.</p>
                            <a href="#" class="inkubator-btn">Detail Program</a>
                        </div>
                    </div>
                </div>
            </section>

            <section class="inkubator-section">
                <h2 class="inkubator-section-title">Layanan Pendampingan</h2>
                <div class="inkubator-features">
                    <div class="inkubator-feature">
                        <div class="inkubator-feature-icon"><i class="fas fa-lightbulb"></i></div>
                        <div class="inkubator-feature-content">
                            <h3>Pengembangan Ide Bisnis</h3>
                            <p>Membantu mengembangkan ide menjadi model bisnis yang layak dan berkelanjutan melalui workshop dan konsultasi.</p>
                        </div>
                    </div>
                    <div class="inkubator-feature">
                        <div class="inkubator-feature-icon"><i class="fas fa-graduation-cap"></i></div>
                        <div class="inkubator-feature-content">
                            <h3>Pelatihan Kewirausahaan</h3>
                            <p>Program pelatihan yang dirancang untuk mengembangkan keterampilan bisnis dan mindset wirausaha.</p>
                        </div>
                    </div>
                    <div class="inkubator-feature">
                        <div class="inkubator-feature-icon"><i class="fas fa-handshake"></i></div>
                        <div class="inkubator-feature-content">
                            <h3>Akses ke Jaringan</h3>
                            <p>Membuka pintu ke jaringan mentor, investor, dan mitra industri yang dapat mendukung perkembangan bisnis.</p>
                        </div>
                    </div>
                    <div class="inkubator-feature">
                        <div class="inkubator-feature-icon"><i class="fas fa-chart-line"></i></div>
                        <div class="inkubator-feature-content">
                            <h3>Riset Pasar</h3>
                            <p>Dukungan dalam melakukan riset pasar dan validasi produk untuk memastikan relevansi bisnis.</p>
                        </div>
                    </div>
                </div>
            </section>

            <section class="inkubator-section">
                <h2 class="inkubator-section-title">Kisah Sukses</h2>
                <div class="inkubator-testimonials">
                    <div class="inkubator-testimonial">
                        <p>Program inkubator membantu kami menerjemahkan hasil riset menjadi produk yang siap pasar. Pendampingan intensif membuat kami dapat berkembang lebih cepat.</p>
                        <span class="inkubator-testimonial-author">Tim Startup EdTech</span>
                    </div>
                    <div class="inkubator-testimonial">
                        <p>Jaringan mentor dan akses ke industri yang diberikan oleh inkubator menjadi kunci keberhasilan kami mendapatkan pendanaan awal.</p>
                        <span class="inkubator-testimonial-author">Alumni Inkubator Bisnis</span>
                    </div>
                    <div class="inkubator-testimonial">
                        <p>Berkat program inkubator, inovasi yang awalnya hanya ide di laboratorium kini telah menjadi bisnis yang melayani ribuan pengguna.</p>
                        <span class="inkubator-testimonial-author">Dosen Pewirausaha</span>
                    </div>
                </div>
            </section>

            <div class="inkubator-cta">
                <h2>Siap Mengembangkan Ide Bisnis Anda?</h2>
                <p>Jadilah bagian dari ekosistem inovasi dan kewirausahaan. Daftarkan diri atau tim Anda sekarang dan mulai perjalanan membangun bisnis yang berdampak.</p>
                <a href="#" class="inkubator-btn inkubator-btn-cta">Daftar Sekarang</a>
            </div>
        </div>
    </div>

</body>
@include('layout.footer')
</html>