<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UI News Portal</title>
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        
        body {
            background-color: #f5f5f5;
            line-height: 1.6;
            color: #333;
            font-size: 14px;
        }
        
        .content-container {
            display: flex;
            flex-wrap: wrap;
            max-width: 1200px;
            margin: 0 auto;
            background-color: #fff;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        
        .featured-image-container {
            width: 100%;
            position: relative;
            margin-bottom: 20px;
        }
        
        .featured-image {
            width: 100%;
            height: auto;
            display: block;
            max-height: 400px;
            object-fit: cover;
        }
        
        .image-overlay {
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            background-color: rgba(0, 0, 0, 0.9);
            color: white;
            padding: 15px 30px;
            text-align: center;
            max-width: 500px;
        }
        
        .image-overlay h1 {
            font-size: 1.2rem;
            margin: 5px 0;
            color: white;
            line-height: 1.4;
        }
        
        .date-badge {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 20px;
            color: white;
            font-size: 0.9rem;
            margin-bottom: 5px;
        }
        
        .main-content {
            flex: 1;
            min-width: 0;
            padding: 0 20px 20px 20px;
            max-width: 70%;
        }
        
        .sidebar {
            width: 30%;
            padding: 0 20px 20px 0;
        }
        
        .article-meta {
            margin-bottom: 15px;
            line-height: 1.6;
        }
        
        .article-content p {
            margin-bottom: 15px;
            text-align: justify;
            line-height: 1.6;
        }
        
        .article-content p:first-of-type::first-letter {
            font-size: 2.5em;
            font-weight: bold;
            float: left;
            line-height: 1;
            margin-right: 6px;
            color: rgba(23, 99, 105, 1);
        }
        
        .article-share {
            display: flex;
            align-items: center;
            margin: 20px 0;
            padding: 10px 0;
            border-top: 1px solid #eee;
            border-bottom: 1px solid #eee;
        }
        
        .article-share span {
            margin-right: 15px;
            font-weight: bold;
        }
        
        .article-share a {
            margin-right: 10px;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background-color: #f0f0f0;
            color: #333;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }
        
        .article-share a:hover {
            background-color: rgba(23, 99, 105, 0.9);
            color: white;
            text-decoration: none;
        }
        
        .article-tags {
            margin: 20px 0;
        }
        
        .article-tags span {
            display: inline-block;
            background-color: #f0f0f0;
            color: #333;
            padding: 3px 10px;
            margin-right: 5px;
            border-radius: 3px;
            font-size: 12px;
        }
        
        sup {
            vertical-align: super;
            font-size: smaller;
        }
        
        .section-header {
            background-color: rgba(23, 99, 105, 0.9);
            color: white;
            display: inline-block;
            padding: 5px 15px;
            font-size: 0.9rem;
            font-weight: bold;
            margin-bottom: 15px;
        }
        
        .news-item {
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
            transition: all 0.3s ease;
        }
        
        .news-item:hover {
            background-color: #f9f9f9;
            padding-left: 5px;
        }
        
        .news-item h3 {
            font-size: 14px;
            font-weight: normal;
            margin-bottom: 5px;
        }
        
        .news-item h3 a {
            color: #333;
            text-decoration: none;
        }
        
        .news-item h3 a:hover {
            color: rgba(23, 99, 105,.9);
            text-decoration: none;
        }
        
        .news-item .date {
            font-size: 12px;
            color: #888;
        }
        
        .popular-item {
            margin-bottom: 10px;
            padding: 5px 0;
            transition: all 0.3s ease;
        }
        
        .popular-item:hover {
            background-color: #f9f9f9;
            padding-left: 5px;
        }
        
        .post-date {
            color: #888;
            font-size: 12px;
            display: block;
            margin-bottom: 3px;
        }
        
        .post-title {
            font-size: 14px;
            color: #333;
            text-decoration: none;
            display: block;
        }
        
        .post-title:hover {
            color: rgba(23, 99, 105, .9);
            text-decoration: none;
        }
        
        .related-posts {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px solid #eee;
        }
        
        .related-post-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-top: 15px;
        }
        
        .related-post-item {
            border: 1px solid #eee;
            border-radius: 4px;
            overflow: hidden;
            transition: transform 0.3s ease;
        }
        
        .related-post-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .related-post-image {
            width: 100%;
            height: 120px;
            object-fit: cover;
            background-color: #f0f0f0;
        }
        
        .related-post-content {
            padding: 10px;
        }
        
        .related-post-title {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .related-post-date {
            font-size: 12px;
            color: #888;
        }
        
        strong, b {
            font-weight: bold;
        }
        
        a {
            color: #333;
            text-decoration: none;
        }
        
        a:hover {
            color: rgba(23, 99, 105, .9);
        }
        
        .section-title-wrapper {
            margin-bottom: 10px;
        }
        
        .section-content {
            margin-bottom: 30px;
        }
        
        .newsletter {
            background-color: #f9f9f9;
            padding: 20px;
            margin-top: 20px;
            border-radius: 4px;
        }
        
        .newsletter h4 {
            font-size: 16px;
            margin-bottom: 10px;
        }
        
        .newsletter p {
            margin-bottom: 15px;
            font-size: 13px;
        }
        
        .newsletter-form {
            display: flex;
        }
        
        .newsletter-form input {
            flex: 1;
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px 0 0 4px;
            outline: none;
        }
        
        .newsletter-form button {
            background-color: rgba(23, 99, 105, 0.9);
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 0 4px 4px 0;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        
        .newsletter-form button:hover {
            background-color: rgba(23, 99, 105, 1);
        }
        
        /* Mobile-specific styles */
        @media (max-width: 768px) {
            .main-content, .sidebar {
                width: 100%;
                max-width: 100%;
                padding: 0 15px;
            }
            
            .content-container {
                flex-direction: column;
            }
            
            .image-overlay {
                max-width: 90%;
            }
            
            .related-post-grid {
                grid-template-columns: 1fr;
            }
            
            .article-content p:first-of-type::first-letter {
                font-size: 2em;
            }
        }
    </style>
</head>
@include('Berita.navbarberita')
<body>
    <!-- Main Content -->
    <div class="content-container">
        <div class="featured-image-container">
            <img class="featured-image" src="https://lh3.googleusercontent.com/gps-cs-s/AB5caB_cqHu1oll93NUg188d3JD6vNMAldMk0b-luMyiBxxHIb2JRi0lysmBTp0mk3IRvc4CE68t6wEkYKw01Zqtb31SRTKX3Y0LIWpHcvH9r6OvXLghY8rJO_bhXa2WGsNBdwOyKB71=s680-w680-h510" alt="UI Jadi Tuan Rumah Indonesia-China" onerror="this.src='data:image/svg+xml;charset=UTF-8,%3Csvg width=\'680\' height=\'400\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Crect width=\'100%25\' height=\'100%25\' fill=\'%23f0f0f0\'/%3E%3Ctext x=\'50%25\' y=\'50%25\' font-size=\'18\' text-anchor=\'middle\' alignment-baseline=\'middle\' font-family=\'Arial, sans-serif\' fill=\'%23888888\'%3EUniversitas Indonesia%3C/text%3E%3C/svg%3E'">
            <div class="image-overlay">
                <div class="date-badge">
                    <span>📅 March 24, 2025</span>
                    <span>⌚ 3:32 pm</span>
                </div>
                <h1>UI Jadi Tuan Rumah 11th Indonesia-China Innovation & Technology Collaboration di Sektor Industri Kimia</h1>
            </div>
        </div>
        
        <div class="main-content">
            <div class="article-meta">
                <strong>Depok, 18 Maret 2025</strong> - Universitas Indonesia (UI) menjadi tuan rumah acara bertajuk <strong>11<sup>th</sup> Indonesia-China Innovation & Technology Collaboration (Chemical Industry)</strong>. Acara ini diselenggarakan di UI Depok, 18 Maret 2025, di Ruang Serbaguna Gedung Science Techno Park UI. Acara ini merupakan langkah penting untuk mendorong inovasi dan memperkuat hubungan inkubasi antara Indonesia dan China di sektor industri kimia, yang sangat penting untuk pembangunan ekonomi berkelanjutan.
            </div>
            
            <div class="article-content">
                <p>Acara ini diinisiasi oleh Forum Sinergi Inovasi Industri (FSII) yang telah menghadirkan Advisor FSII UI, Prof. Dr. Ir. Muhammad Anis, M.Met, Prof. Dr. Ir. Heri Hermansyah, IPU, Dekan Fakultas Teknik UI dari Riset Berdampak Tinggi Universitas Indonesia (DRBT UI), Chairul Hudaya, Ph.D., menyajikan usaha pemerintah dari para partisipasi industria dan kalitbang Bammer, Ir.M.S., S.Sos., M.Si., Kasubdit Operasional DRBT UI, turut menghadiri acara ini. Presentasi dan informasi yang disampaikan mencakup topik-topik penting seperti inovasi industri, kebijakan pemerintah, dan studi kasus dari perusahaan-perusahaan terkemuka. Acara ini bertujuan untuk mengidentifikasi peluang kerjasama, mempercepat pertukaran, dan membuka peluang kolaborasi potensial antara para pemangku kepentingan dari Indonesia dan Cina.</p>
                
                <p>Turut hadir dalam acara adalah perwakilan dari Direktorat Jenderal Industri Kimia, Farmasi, dan Tekstil, Kementerian Perindustrian Republik Indonesia, Anggota Dewan Energi Nasional Republik Indonesia, PT Kilang Pertamina International, PT Ecolab Manufacturing Indonesia, PT Autochem Industry Indonesia, IPSOS, Sinopharma Investment International, and Axiomatic International, Rihua International Co., Ltd., Weihai Chemical Machinery Co., Ltd., serta Jiangsu GONGTECK Automation Technology Co., Ltd. Para tamu ini berbagi wawasan tentang tren terbaru, inovasi, dan peluang investasi di industri kimia, serta membahas strategi untuk meningkatkan kerja sama bilateral dalam bidang ini. Para delegasi juga memberikan tinjauan tentang industri kimia dalam lanskap global dan investasi proyek teknologi, serta memberikan perspektif berharga tentang industri global.</p>
                
                <p>Kolaborasi Inovasi dan Teknologi Indonesia-Cina ke-11 ini diharapkan dapat menghasilkan kemitraan yang lebih kuat dan menciptakan ekosistem yang akan mendorong inovasi dan pertumbuhan di industri kimia. Acara ini juga berperan sebagai platform untuk berbagi praktik terbaik, mendiskusikan tantangan, dan merancang solusi untuk masa depan industri kimia yang berkelanjutan.</p>
                
                <div class="article-share">
                    <span>Bagikan:</span>
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    <a href="#"><i class="fab fa-whatsapp"></i></a>
                    <a href="#"><i class="far fa-envelope"></i></a>
                </div>
                
                <div class="article-tags">
                    <span>Inovasi</span>
                    <span>Teknologi</span>
                    <span>Kerjasama Internasional</span>
                    <span>Indonesia-China</span>
                    <span>Industri Kimia</span>
                </div>
                
                <div class="related-posts">
                    <h3>Berita Terkait</h3>
                    <div class="related-post-grid">
                        <div class="related-post-item">
                            <img src="/api/placeholder/300/150" alt="Related News" class="related-post-image" onerror="this.src='data:image/svg+xml;charset=UTF-8,%3Csvg width=\'300\' height=\'150\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Crect width=\'100%25\' height=\'100%25\' fill=\'%23f0f0f0\'/%3E%3Ctext x=\'50%25\' y=\'50%25\' font-size=\'14\' text-anchor=\'middle\' alignment-baseline=\'middle\' font-family=\'Arial, sans-serif\' fill=\'%23888888\'%3EBerita Terkait%3C/text%3E%3C/svg%3E'">
                            <div class="related-post-content">
                                <div class="related-post-title">
                                    <a href="#">Kolaborasi Industri dan Perguruan Tinggi Kunci Inovasi Berkelanjutan</a>
                                </div>
                                <div class="related-post-date">Maret 12, 2025</div>
                            </div>
                        </div>
                        <div class="related-post-item">
                            <img src="/api/placeholder/300/150" alt="Related News" class="related-post-image" onerror="this.src='data:image/svg+xml;charset=UTF-8,%3Csvg width=\'300\' height=\'150\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Crect width=\'100%25\' height=\'100%25\' fill=\'%23f0f0f0\'/%3E%3Ctext x=\'50%25\' y=\'50%25\' font-size=\'14\' text-anchor=\'middle\' alignment-baseline=\'middle\' font-family=\'Arial, sans-serif\' fill=\'%23888888\'%3EBerita Terkait%3C/text%3E%3C/svg%3E'">
                            <div class="related-post-content">
                                <div class="related-post-title">
                                    <a href="#">UI Raih Penghargaan Excellence in Innovation Award 2025</a>
                                </div>
                                <div class="related-post-date">Maret 05, 2025</div>
                            </div>
                        </div>
                        <div class="related-post-item">
                            <img src="/api/placeholder/300/150" alt="Related News" class="related-post-image" onerror="this.src='data:image/svg+xml;charset=UTF-8,%3Csvg width=\'300\' height=\'150\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Crect width=\'100%25\' height=\'100%25\' fill=\'%23f0f0f0\'/%3E%3Ctext x=\'50%25\' y=\'50%25\' font-size=\'14\' text-anchor=\'middle\' alignment-baseline=\'middle\' font-family=\'Arial, sans-serif\' fill=\'%23888888\'%3EBerita Terkait%3C/text%3E%3C/svg%3E'">
                            <div class="related-post-content">
                                <div class="related-post-title">
                                    <a href="#">Implementasi Teknologi Hijau dalam Industri Kimia Modern</a>
                                </div>
                                <div class="related-post-date">Februari 28, 2025</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="sidebar">
            <div class="section-title-wrapper">
                <div class="section-header">Latest News</div>
            </div>
            <div class="section-content">
                <div class="news-item">
                    <h3><a href="#">UI Jadi Tuan Rumah 11th Indonesia-China Innovation & Technology Collaboration di Sektor Industri Kimia</a></h3>
                    <div class="date">Maret 18, 2025 • Kemahasiswaan</div>
                </div>
                
                <div class="news-item">
                    <h3><a href="#">Sebanyak 19 Perguruan Tinggi UI Diterbitkan Paten dari DJKI Kemenkumham</a></h3>
                    <div class="date">Maret 15, 2025 • Akademik</div>
                </div>
                
                <div class="news-item">
                    <h3><a href="#">UI Gelar Sosialisasi Penormalisasi dan Penyesuaian Kebijakan Penelitian untuk Prestasi Para Inventor</a></h3>
                    <div class="date">Maret 10, 2025 • Riset</div>
                </div>
                
                <div class="news-item">
                    <h3><a href="#">UI Dalam Menyongsong Mitra Industri: Kolaborasi Strategis dengan Paper Group</a></h3>
                    <div class="date">Maret 8, 2025 • Industri</div>
                </div>
            </div>
            
            <div class="section-title-wrapper">
                <div class="section-header">Popular Post</div>
            </div>
            <div class="section-content">
                <div class="popular-item">
                    <span class="post-date">🗓 Mar 1, 2025</span>
                    <a href="#" class="post-title">UI MERAIH KEKAYAAN INTELEKTUAL NASIONAL 2025</a>
                </div>
                
                <div class="popular-item">
                    <span class="post-date">🗓 Feb 15, 2025</span>
                    <a href="#" class="post-title">UI Incubate - Pengumuman Penerima Mahasiswa Gelombang 2 TA 2025</a>
                </div>
                
                <div class="popular-item">
                    <span class="post-date">🗓 Feb 1, 2025</span>
                    <a href="#" class="post-title">Pelatihan Strategi Pemasaran: Branding dan Packaging Produk Usaha</a>
                </div>
                
                <div class="popular-item">
                    <span class="post-date">🗓 Jan 20, 2025</span>
                    <a href="#" class="post-title">Meet up & Startup Pitching Day</a>
                </div>
                
                <div class="popular-item">
                    <span class="post-date">🗓 Jan 10, 2025</span>
                    <a href="#" class="post-title">UI Incubate Program 2026</a>
                </div>
            </div>

            
        </div>
    </div>
</body>
@include('Berita.beritafooter')

</html>