<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail SDG 5: Kesetaraan Gender - Universitas Negeri Jakarta</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Roboto', sans-serif; background-color: #f8f9fa; }
        .sdg-header { background-color: #FF3A21; color: white; padding: 4rem 1.5rem; text-align: center; }
        .sdg-icon-container { max-width: 180px; margin: 0 auto 1.5rem auto; background-color: white; border-radius: 12px; padding: 1rem; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        .sdg-icon-container img { width: 100%; height: auto; object-fit: contain; }
        .sdg-title { font-size: 2.5rem; font-weight: 700; }
        .sdg-subtitle { font-size: 1.25rem; margin-top: 0.5rem; opacity: 0.9; }
        .section-title { font-size: 2rem; font-weight: 700; color: #333; text-align: center; margin-bottom: 2rem; border-bottom: 3px solid #FF3A21; display: inline-block; padding-bottom: 0.5rem; }
        .news-card { background-color: #fff; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.08); transition: transform 0.3s, box-shadow 0.3s; }
        .news-card:hover { transform: translateY(-5px); box-shadow: 0 8px 20px rgba(0,0,0,0.12); }
        .news-card img { width: 100%; height: 200px; object-fit: cover; }
        .news-card-content { padding: 1.5rem; }
        .news-card-title { font-size: 1.2rem; font-weight: 700; color: #333; margin-bottom: 0.75rem; }
        .news-card-text { color: #666; margin-bottom: 1rem; line-height: 1.6; }
        .news-card-link { color: #FF3A21; font-weight: 700; text-decoration: none; transition: color 0.3s; }
        .news-card-link:hover { color: #e02d18; }
        .back-link { display: inline-flex; align-items: center; gap: 0.5rem; margin: 2rem 0; color: #1D796B; font-weight: 700; text-decoration: none; transition: color 0.3s; }
        .back-link:hover { color: #165c52; }
    </style>
</head>
    @include('layout.navbar_hilirisasi')
<body class="bg-gray-50">

    <header class="sdg-header">
        <div class="container mx-auto px-4">
            <div class="sdg-icon-container">
                <img src="https://sdgs.un.org/sites/default/files/goals/E_SDG_Icons-05.jpg" alt="Icon SDG 5">
            </div>
            <h1 class="sdg-title">SDG 5: Kesetaraan Gender</h1>
            <p class="sdg-subtitle">Mencapai kesetaraan gender dan memberdayakan semua perempuan dan anak perempuan.</p>
        </div>
    </header>

    <main class="container mx-auto px-4 py-12">
        <section id="penjelasan-sdg" class="mb-16">
            <div class="max-w-4xl mx-auto text-center mb-8"><h2 class="section-title">Tentang Tujuan Ini</h2></div>
            <div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-md">
                <p class="text-gray-700 text-lg leading-relaxed mb-4">SDG 5 bertujuan untuk mengakhiri segala bentuk diskriminasi dan kekerasan terhadap perempuan dan anak perempuan di seluruh dunia. Ini termasuk praktik-praktik berbahaya seperti pernikahan anak dan sunat perempuan. Tujuan ini juga menyerukan pengakuan dan penghargaan terhadap pekerjaan rumah tangga dan pengasuhan yang tidak dibayar.</p>
                <p class="text-gray-700 text-lg leading-relaxed mb-4">Target utamanya adalah memastikan partisipasi penuh dan efektif perempuan serta kesempatan yang sama untuk kepemimpinan di semua tingkat pengambilan keputusan dalam kehidupan politik, ekonomi, dan publik. Selain itu, SDG 5 mendorong adanya akses universal terhadap kesehatan seksual dan reproduksi serta hak-hak reproduksi.</p>
                <p class="text-gray-700 text-lg leading-relaxed">Universitas Negeri Jakarta berkomitmen pada kesetaraan gender dengan menciptakan lingkungan kampus yang aman dan inklusif, mendirikan Pusat Studi Wanita dan Gender, serta mendorong penelitian yang berfokus pada isu-isu gender dan pemberdayaan perempuan. Kami juga aktif dalam kampanye anti-kekerasan seksual dan kesetaraan hak.</p>
            </div>
        </section>

        <section id="berita-terkait">
            <div class="text-center mb-10"><h2 class="section-title">Berita & Kegiatan Terkait</h2></div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="news-card">
                    <img src="https://via.placeholder.com/400x200.png?text=Riset+Gender" alt="Berita 1">
                    <div class="news-card-content">
                        <h3 class="news-card-title">Pusat Studi Wanita UNJ Publikasikan Riset Mengenai Peran Perempuan di Ekonomi Digital</h3>
                        <p class="news-card-text">Riset ini menyoroti peluang dan tantangan yang dihadapi perempuan dalam beradaptasi dengan ekonomi digital di Indonesia.</p>
                        <a href="#" class="news-card-link">Baca Selengkapnya <i class="fas fa-arrow-right ml-1"></i></a>
                    </div>
                </div>
                <div class="news-card">
                    <img src="https://via.placeholder.com/400x200.png?text=Kampanye+Anti+Kekerasan" alt="Berita 2">
                    <div class="news-card-content">
                        <h3 class="news-card-title">UNJ Bentuk Satgas PPKS untuk Wujudkan Kampus Bebas Kekerasan Seksual</h3>
                        <p class="news-card-text">Satuan Tugas Pencegahan dan Penanganan Kekerasan Seksual (Satgas PPKS) ini menjadi garda terdepan dalam menciptakan ruang aman bagi seluruh sivitas akademika.</p>
                        <a href="#" class="news-card-link">Baca Selengkapnya <i class="fas fa-arrow-right ml-1"></i></a>
                    </div>
                </div>
                <div class="news-card">
                    <img src="https://via.placeholder.com/400x200.png?text=Kepemimpinan+Perempuan" alt="Berita 3">
                    <div class="news-card-content">
                        <h3 class="news-card-title">Program Mentoring Kepemimpinan untuk Mahasiswi UNJ Resmi Diluncurkan</h3>
                        <p class="news-card-text">Program ini bertujuan untuk mempersiapkan generasi pemimpin perempuan masa depan yang kompeten dan berintegritas.</p>
                        <a href="#" class="news-card-link">Baca Selengkapnya <i class="fas fa-arrow-right ml-1"></i></a>
                    </div>
                </div>
            </div>
        </section>
    </main>
</body>
    @include('layout.footer')
</html>