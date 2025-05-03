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

        .award-hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
        }

        .award-hero-content {
            position: relative;
            z-index: 1;
            padding: 2rem;
        }

        .award-hero h2 {
            font-size: 2.8rem;
            margin-bottom: 1rem;
        }

        .award-hero p {
            font-size: 1.2rem;
            max-width: 700px;
            margin: 0 auto;
        }

        .award-btn {
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

        .award-btn:hover {
            background-color: #1d5559;
        }

        .award-section {
            background-color: white;
            padding: 2.5rem;
            margin-bottom: 2rem;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .award-section-title {
            color: var(--secondary-color);
            margin-bottom: 1.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid var(--primary-color);
        }

        .award-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-top: 2.5rem;
        }

        .award-card {
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .award-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }

        .award-card-img {
            height: 200px;
            background: url('/api/placeholder/400/200') center/cover no-repeat;
        }

        .award-card-content {
            padding: 1.5rem;
        }

        .award-card h3 {
            color: var(--secondary-color);
            margin-bottom: 1rem;
        }

        .award-card p {
            margin-bottom: 1rem;
            color: #666;
        }

        .award-features {
            margin-top: 2rem;
        }

        .award-feature {
            display: flex;
            margin-bottom: 1.5rem;
            align-items: flex-start;
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
            margin-right: 1rem;
            flex-shrink: 0;
        }

        .award-feature-content {
            flex: 1;
        }

        .award-feature h3 {
            margin-bottom: 0.5rem;
            color: var(--secondary-color);
        }

        .award-winners {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        .award-winner {
            background-color: var(--light-color);
            padding: 1.5rem;
            border-radius: 8px;
            text-align: center;
        }

        .award-winner-img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            margin: 0 auto 1rem auto;
            background: url('/api/placeholder/200/200') center/cover no-repeat;
            border: 4px solid var(--primary-color);
        }

        .award-winner h3 {
            color: var(--secondary-color);
            margin-bottom: 0.5rem;
        }

        .award-winner p {
            color: #666;
            font-style: italic;
        }

        .award-timeline {
            position: relative;
            max-width: 800px;
            margin: 2rem auto;
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
            width: 20px;
            height: 20px;
            right: -10px;
            background-color: white;
            border: 4px solid var(--accent-color);
            top: 1.5rem;
            border-radius: 50%;
            z-index: 1;
        }

        .award-timeline-item:nth-child(even)::after {
            left: -10px;
        }

        .award-timeline-content {
            padding: 1rem;
            background-color: white;
            position: relative;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .award-timeline-date {
            color: var(--accent-color);
            font-weight: bold;
        }

        .award-cta {
            background: linear-gradient(135deg, #277177, #1d5559);
            color: white;
            text-align: center;
            padding: 3rem 2rem;
            border-radius: 10px;
            margin: 3rem 0;
        }

        .award-cta h2 {
            font-size: 2rem;
            margin-bottom: 1rem;
        }

        .award-cta p {
            max-width: 700px;
            margin: 0 auto 1.5rem auto;
            font-size: 1.1rem;
        }

        .award-btn-cta {
            background-color: white;
            color: var(--primary-color);
            padding: 0.8rem 2rem;
            font-size: 1.1rem;
        }

        .award-btn-cta:hover {
            background-color: var(--light-color);
        }

        @media (max-width: 768px) {
            .award-hero {
                height: 300px;
            }

            .award-hero h2 {
                font-size: 2rem;
            }

            .award-timeline::before {
                left: 31px;
            }

            .award-timeline-item {
                width: 100%;
                padding-left: 60px;
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
                    <p>Penghargaan prestisius yang mengakui dan merayakan pencapaian luar biasa dalam bidang inovasi, kreativitas, dan kontribusi terhadap kemajuan ilmu pengetahuan dan teknologi.</p>
                    <a href="#" class="award-btn">Nominasikan Sekarang</a>
                </div>
            </div>

            <section class="award-section">
                <h2 class="award-section-title">Tentang Innovator Award</h2>
                <p>Innovator Award adalah program penghargaan yang dirancang untuk mengenali dan merayakan individu, tim, dan organisasi yang telah menunjukkan inovasi luar biasa dalam berbagai bidang. Penghargaan ini bertujuan untuk mendorong budaya inovasi, mendukung pengembangan ide-ide baru, dan menginspirasi generasi mendatang untuk terus berinovasi.</p>
                <p>Setiap tahun, Innovator Award mengidentifikasi dan menghargai kontribusi signifikan dalam penelitian, pengembangan teknologi, pendidikan, dan bidang-bidang lain yang memiliki dampak positif pada masyarakat dan lingkungan.</p>
                
                <div class="award-cards">
                    <div class="award-card">
                        <div class="award-card-img"></div>
                        <div class="award-card-content">
                            <h3>Inovasi Teknologi</h3>
                            <p>Penghargaan untuk terobosan teknologi yang inovatif dan memiliki potensi untuk mengubah paradigma atau menciptakan solusi baru terhadap tantangan yang ada.</p>
                            <a href="#" class="award-btn">Detail Kategori</a>
                        </div>
                    </div>
                    <div class="award-card">
                        <div class="award-card-img"></div>
                        <div class="award-card-content">
                            <h3>Inovasi Pendidikan</h3>
                            <p>Menghargai inovasi dalam metode pembelajaran, kurikulum, atau teknologi pendidikan yang meningkatkan kualitas dan aksesibilitas pendidikan.</p>
                            <a href="#" class="award-btn">Detail Kategori</a>
                        </div>
                    </div>
                    <div class="award-card">
                        <div class="award-card-img"></div>
                        <div class="award-card-content">
                            <h3>Inovasi Sosial</h3>
                            <p>Penghargaan untuk solusi inovatif yang mengatasi tantangan sosial, lingkungan, atau ekonomi dan berkontribusi pada kesejahteraan masyarakat.</p>
                            <a href="#" class="award-btn">Detail Kategori</a>
                        </div>
                    </div>
                </div>
            </section>

            <section class="award-section">
                <h2 class="award-section-title">Kriteria Penilaian</h2>
                <div class="award-features">
                    <div class="award-feature">
                        <div class="award-feature-icon">1</div>
                        <div class="award-feature-content">
                            <h3>Originalitas & Kreativitas</h3>
                            <p>Sejauh mana inovasi menawarkan pendekatan, konsep, atau solusi baru yang belum pernah ada sebelumnya, atau merupakan adaptasi kreatif dari solusi yang sudah ada.</p>
                        </div>
                    </div>
                    <div class="award-feature">
                        <div class="award-feature-icon">2</div>
                        <div class="award-feature-content">
                            <h3>Dampak & Manfaat</h3>
                            <p>Besarnya dampak positif yang dihasilkan oleh inovasi, termasuk manfaat ekonomi, sosial, lingkungan, atau pendidikan, serta potensi keberlanjutannya.</p>
                        </div>
                    </div>
                    <div class="award-feature">
                        <div class="award-feature-icon">3</div>
                        <div class="award-feature-content">
                            <h3>Aplikasi Praktis</h3>
                            <p>Kemudahan implementasi dan adopsi inovasi dalam praktik nyata, serta kemampuannya untuk mengatasi tantangan yang ada secara efektif dan efisien.</p>
                        </div>
                    </div>
                    <div class="award-feature">
                        <div class="award-feature-icon">4</div>
                        <div class="award-feature-content">
                            <h3>Keberlanjutan</h3>
                            <p>Potensi inovasi untuk terus berkembang dan berkelanjutan dalam jangka panjang, baik secara ekonomi, sosial, maupun lingkungan.</p>
                        </div>
                    </div>
                    <div class="award-feature">
                        <div class="award-feature-icon">5</div>
                        <div class="award-feature-content">
                            <h3>Potensi Skalabilitas</h3>
                            <p>Kemampuan inovasi untuk ditingkatkan skala dan diterapkan dalam konteks yang lebih luas atau berbeda dari yang semula dirancang.</p>
                        </div>
                    </div>
                </div>
            </section>

            <section class="award-section">
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
            </section>

            <section class="award-section">
                <h2 class="award-section-title">Timeline Pendaftaran</h2>
                <div class="award-timeline">
                    <div class="award-timeline-item">
                        <div class="award-timeline-content">
                            <h3 class="award-timeline-date">Tahap 1</h3>
                            <p>Periode Pendaftaran dan Pengajuan Nominasi</p>
                        </div>
                    </div>
                    <div class="award-timeline-item">
                        <div class="award-timeline-content">
                            <h3 class="award-timeline-date">Tahap 2</h3>
                            <p>Penilaian dan Seleksi oleh Dewan Juri</p>
                        </div>
                    </div>
                    <div class="award-timeline-item">
                        <div class="award-timeline-content">
                            <h3 class="award-timeline-date">Tahap 3</h3>
                            <p>Pengumuman Finalis</p>
                        </div>
                    </div>
                    <div class="award-timeline-item">
                        <div class="award-timeline-content">
                            <h3 class="award-timeline-date">Tahap 4</h3>
                            <p>Presentasi Finalis di Hadapan Dewan Juri</p>
                        </div>
                    </div>
                    <div class="award-timeline-item">
                        <div class="award-timeline-content">
                            <h3 class="award-timeline-date">Tahap 5</h3>
                            <p>Malam Penganugerahan Innovator Award</p>
                        </div>
                    </div>
                </div>
            </section>

            <section class="award-section">
                <h2 class="award-section-title">Manfaat Pemenang</h2>
                <div class="award-features">
                    <div class="award-feature">
                        <div class="award-feature-icon"><i class="fas fa-trophy"></i></div>
                        <div class="award-feature-content">
                            <h3>Penghargaan Prestisius</h3>
                            <p>Trofi dan sertifikat pengakuan yang meningkatkan kredibilitas dan reputasi pemenang di bidangnya.</p>
                        </div>
                    </div>
                    <div class="award-feature">
                        <div class="award-feature-icon"><i class="fas fa-coins"></i></div>
                        <div class="award-feature-content">
                            <h3>Hibah Pengembangan</h3>
                            <p>Dana hibah untuk mendukung pengembangan lebih lanjut dari inovasi yang dihasilkan.</p>
                        </div>
                    </div>
                    <div class="award-feature">
                        <div class="award-feature-icon"><i class="fas fa-handshake"></i></div>
                        <div class="award-feature-content">
                            <h3>Jaringan dan Kemitraan</h3>
                            <p>Akses ke jaringan inovator, investor, dan mitra industri potensial untuk pengembangan kolaborasi.</p>
                        </div>
                    </div>
                    <div class="award-feature">
                        <div class="award-feature-icon"><i class="fas fa-bullhorn"></i></div>
                        <div class="award-feature-content">
                            <h3>Publikasi dan Eksposur</h3>
                            <p>Peluang untuk mempublikasikan inovasi di berbagai media dan platform, meningkatkan visibilitas dan pengakuan.</p>
                        </div>
                    </div>
                </div>
            </section>

            <div class="award-cta">
                <h2>Jadilah Bagian dari Gerakan Inovasi</h2>
                <p>Apakah Anda memiliki inovasi yang berpotensi mengubah dunia? Atau mengenal seseorang yang layak mendapatkan pengakuan atas kontribusi inovatifnya? Nominasikan sekarang dan jadilah bagian dari perubahan!</p>
                <a href="#" class="award-btn award-btn-cta">Ajukan Nominasi</a>
            </div>
        </div>
    </div>

</body>
@include('layout.footer')