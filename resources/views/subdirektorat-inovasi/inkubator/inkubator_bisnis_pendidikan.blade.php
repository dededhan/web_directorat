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
                    <h2>Membangun Ekosistem Inovasi</h2>
                    <p>Inkubator Bisnis dan Pendidikan dirancang untuk memfasilitasi pertumbuhan startup, mendukung pengembangan ide-ide kreatif, dan mentransformasi penelitian menjadi solusi bisnis yang berkelanjutan.</p>
                    <a href="#" class="inkubator-btn">Pelajari Lebih Lanjut</a>
                </div>
            </div>

            <section class="inkubator-section">
                <h2 class="inkubator-section-title">Tentang Inkubator Bisnis dan Pendidikan</h2>
                <p>Inkubator Bisnis dan Pendidikan adalah program yang dirancang untuk membantu pertumbuhan dan keberhasilan perusahaan pemula (startup) dan inovasi pendidikan melalui berbagai dukungan sumber daya dan layanan. Program ini menyediakan lingkungan yang kondusif bagi entrepreneur dan inovator untuk mengembangkan ide-ide mereka menjadi bisnis yang berkelanjutan.</p>
                <p>Melalui pendampingan intensif, akses ke jaringan mentor, dan infrastruktur pendukung, inkubator membantu mempercepat pertumbuhan usaha dan mengurangi risiko kegagalan yang sering dihadapi oleh startup pada tahap awal pengembangan.</p>
                
                <div class="inkubator-cards">
                    <div class="inkubator-card">
                        <div class="inkubator-card-img"></div>
                        <div class="inkubator-card-content">
                            <h3>Inkubator Bisnis</h3>
                            <p>Program yang dirancang untuk membantu pengembangan usaha rintisan (startup) melalui pendampingan, akses ke mentor, permodalan, dan jaringan industri.</p>
                            <a href="#" class="inkubator-btn">Detail Program</a>
                        </div>
                    </div>
                    <div class="inkubator-card">
                        <div class="inkubator-card-img"></div>
                        <div class="inkubator-card-content">
                            <h3>Inkubator Pendidikan</h3>
                            <p>Fokus pada pengembangan inovasi di bidang pendidikan, termasuk teknologi pembelajaran, metode pengajaran baru, dan solusi untuk meningkatkan kualitas pendidikan.</p>
                            <a href="#" class="inkubator-btn">Detail Program</a>
                        </div>
                    </div>
                    <div class="inkubator-card">
                        <div class="inkubator-card-img"></div>
                        <div class="inkubator-card-content">
                            <h3>Hubungan Industri</h3>
                            <p>Membangun jembatan antara penelitian akademis dan kebutuhan industri, memfasilitasi kolaborasi yang saling menguntungkan dan transfer pengetahuan.</p>
                            <a href="#" class="inkubator-btn">Detail Program</a>
                        </div>
                    </div>
                </div>
            </section>

            <section class="inkubator-section">
                <h2 class="inkubator-section-title">Layanan Kami</h2>
                <div class="inkubator-features">
                    <div class="inkubator-feature">
                        <div class="inkubator-feature-icon">1</div>
                        <div class="inkubator-feature-content">
                            <h3>Mentoring dan Pendampingan</h3>
                            <p>Akses ke jaringan mentor berpengalaman yang dapat memberikan bimbingan, masukan, dan saran strategis untuk pengembangan bisnis dan inovasi pendidikan.</p>
                        </div>
                    </div>
                    <div class="inkubator-feature">
                        <div class="inkubator-feature-icon">2</div>
                        <div class="inkubator-feature-content">
                            <h3>Akses Pendanaan</h3>
                            <p>Membantu startup dan inovator pendidikan mendapatkan akses ke berbagai sumber pendanaan, termasuk investor, hibah, dan program kemitraan.</p>
                        </div>
                    </div>
                    <div class="inkubator-feature">
                        <div class="inkubator-feature-icon">3</div>
                        <div class="inkubator-feature-content">
                            <h3>Pelatihan dan Workshop</h3>
                            <p>Program pelatihan khusus yang dirancang untuk meningkatkan keterampilan dan pengetahuan dalam berbagai aspek bisnis dan inovasi pendidikan.</p>
                        </div>
                    </div>
                    <div class="inkubator-feature">
                        <div class="inkubator-feature-icon">4</div>
                        <div class="inkubator-feature-content">
                            <h3>Ruang Kerja dan Fasilitas</h3>
                            <p>Menyediakan ruang kerja yang kondusif, akses ke laboratorium, dan infrastruktur pendukung lainnya untuk membantu pengembangan produk dan layanan.</p>
                        </div>
                    </div>
                    <div class="inkubator-feature">
                        <div class="inkubator-feature-icon">5</div>
                        <div class="inkubator-feature-content">
                            <h3>Jaringan dan Kemitraan</h3>
                            <p>Membuka peluang kemitraan dan kolaborasi dengan berbagai pihak, termasuk industri, investor, lembaga penelitian, dan jaringan profesional.</p>
                        </div>
                    </div>
                </div>
            </section>

            <section class="inkubator-section">
                <h2 class="inkubator-section-title">Manfaat Inkubator</h2>
                <div class="inkubator-testimonials">
                    <div class="inkubator-testimonial">
                        <p>Inkubator membantu kami mengembangkan ide bisnis dengan pendampingan intensif dan akses ke jaringan investor. Dalam waktu 6 bulan, kami berhasil meluncurkan produk dan mendapatkan pendanaan awal.</p>
                        <span class="inkubator-testimonial-author">Tim Startup XYZ</span>
                    </div>
                    <div class="inkubator-testimonial">
                        <p>Program pendampingan di inkubator membuat kami lebih fokus dalam pengembangan produk dan strategi bisnis. Mentor-mentor berpengalaman memberi masukan yang sangat berharga untuk kemajuan startup kami.</p>
                        <span class="inkubator-testimonial-author">Inovator Pendidikan ABC</span>
                    </div>
                    <div class="inkubator-testimonial">
                        <p>Fasilitas dan jaringan yang disediakan oleh inkubator membantu kami melakukan riset dan pengembangan produk dengan lebih efisien. Kami juga mendapatkan akses ke pasar potensial melalui program kemitraan.</p>
                        <span class="inkubator-testimonial-author">Pendiri Startup DEF</span>
                    </div>
                </div>
            </section>

            <div class="inkubator-cta">
                <h2>Tertarik Bergabung dengan Program Inkubator?</h2>
                <p>Daftarkan ide atau startup Anda sekarang dan mulailah perjalanan transformasi menuju bisnis yang sukses dan berkelanjutan.</p>
                <a href="#" class="inkubator-btn inkubator-btn-cta">Daftar Sekarang</a>
            </div>
        </div>
    </div>

</body>
@include('layout.footer')
</html>