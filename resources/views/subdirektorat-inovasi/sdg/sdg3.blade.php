<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail SDG 3: Kehidupan Sehat dan Sejahtera - Universitas Negeri Jakarta</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
    <style>
        body { font-family: 'Roboto', sans-serif; background-color: #f8f9fa; }
        .sdg-header { background-color: #4C9F38; color: white; padding: 4rem 1.5rem; text-align: center; }
        .sdg-icon-container { max-width: 180px; margin: 0 auto 1.5rem auto; background-color: white; border-radius: 12px; padding: 1rem; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        .sdg-icon-container img { width: 100%; height: auto; object-fit: contain; }
        .sdg-title { font-size: 2.5rem; font-weight: 700; }
        .sdg-subtitle { font-size: 1.25rem; margin-top: 0.5rem; opacity: 0.9; }
        .section-title { font-size: 2rem; font-weight: 700; color: #333; text-align: center; margin-bottom: 2rem; border-bottom: 3px solid #4C9F38; display: inline-block; padding-bottom: 0.5rem; }
        .news-card { background-color: #fff; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.08); transition: transform 0.3s, box-shadow 0.3s; }
        .news-card:hover { transform: translateY(-5px); box-shadow: 0 8px 20px rgba(0,0,0,0.12); }
        .news-card img { width: 100%; height: 200px; object-fit: cover; }
        .news-card-content { padding: 1.5rem; }
        .news-card-title { font-size: 1.2rem; font-weight: 700; color: #333; margin-bottom: 0.75rem; }
        .news-card-text { color: #666; margin-bottom: 1rem; line-height: 1.6; }
        .news-card-link { color: #4C9F38; font-weight: 700; text-decoration: none; transition: color 0.3s; }
        .news-card-link:hover { color: #3b7a2b; }
        .back-link { display: inline-flex; align-items: center; gap: 0.5rem; margin: 2rem 0; color: #1D796B; font-weight: 700; text-decoration: none; transition: color 0.3s; }
        .back-link:hover { color: #165c52; }
    </style>
</head>
    @include('layout.navbar_hilirisasi')

<body class="bg-gray-50">

    <header class="sdg-header">
        <div class="container mx-auto px-4">
            <div class="sdg-icon-container">
                <img src="https://sdgs.un.org/sites/default/files/goals/E_SDG_Icons-03.jpg" alt="Icon SDG 3">
            </div>
            <h1 class="sdg-title">SDG 3: Kehidupan Sehat dan Sejahtera</h1>
            <p class="sdg-subtitle">Memastikan kehidupan yang sehat dan mendorong kesejahteraan bagi semua di segala usia.</p>
        </div>
    </header>

    <main class="container mx-auto px-4 py-12">
        <section id="penjelasan-sdg" class="mb-16">
            <div class="max-w-4xl mx-auto text-center mb-8"><h2 class="section-title">Tentang Tujuan Ini</h2></div>
            <div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-md">
                <p class="text-gray-700 text-lg leading-relaxed mb-4">SDG 3 bertujuan untuk menjamin kesehatan dan kesejahteraan bagi semua orang pada setiap tahap kehidupan. Fokus utamanya adalah mengurangi angka kematian ibu dan bayi, mengakhiri epidemi penyakit menular seperti AIDS, tuberkulosis, dan malaria, serta memerangi penyakit tidak menular melalui pencegahan dan pengobatan.</p>
                <p class="text-gray-700 text-lg leading-relaxed mb-4">Selain itu, tujuan ini juga mencakup penguatan pencegahan dan pengobatan penyalahgunaan zat, termasuk narkotika dan alkohol. Target lainnya adalah mencapai cakupan kesehatan universal (Universal Health Coverage), memastikan akses terhadap layanan kesehatan esensial yang berkualitas, serta akses terhadap obat-obatan dan vaksin yang aman, efektif, dan terjangkau bagi semua.</p>
                <p class="text-gray-700 text-lg leading-relaxed">Universitas Negeri Jakarta, khususnya melalui Fakultas Ilmu Keolahragaan dan Fakultas Psikologi, berkontribusi dengan mempromosikan gaya hidup sehat, melakukan riset kesehatan mental, serta program pengabdian masyarakat yang berfokus pada edukasi kesehatan preventif untuk berbagai lapisan masyarakat.</p>
            </div>
        </section>

        <section id="berita-terkait">
            <div class="text-center mb-10"><h2 class="section-title">Berita & Kegiatan Terkait</h2></div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="news-card">
                    <img src="https://via.placeholder.com/400x200.png?text=Webinar+Kesehatan+Mental" alt="Berita 1">
                    <div class="news-card-content">
                        <h3 class="news-card-title">Fakultas Psikologi UNJ Adakan Webinar Pentingnya Kesehatan Mental di Kalangan Remaja</h3>
                        <p class="news-card-text">Acara ini bertujuan untuk meningkatkan kesadaran dan memberikan strategi pengelolaan stres bagi remaja di era digital.</p>
                        <a href="#" class="news-card-link">Baca Selengkapnya <i class="fas fa-arrow-right ml-1"></i></a>
                    </div>
                </div>
                <div class="news-card">
                    <img src="https://via.placeholder.com/400x200.png?text=Pemeriksaan+Kesehatan+Gratis" alt="Berita 2">
                    <div class="news-card-content">
                        <h3 class="news-card-title">FIO UNJ Gelar Pemeriksaan Kebugaran dan Kesehatan Gratis untuk Lansia</h3>
                        <p class="news-card-text">Program pengabdian masyarakat ini membantu para lansia untuk tetap aktif dan memantau kondisi kesehatan mereka secara berkala.</p>
                        <a href="#" class="news-card-link">Baca Selengkapnya <i class="fas fa-arrow-right ml-1"></i></a>
                    </div>
                </div>
                <div class="news-card">
                    <img src="https://via.placeholder.com/400x200.png?text=Kampanye+Anti+Narkoba" alt="Berita 3">
                    <div class="news-card-content">
                        <h3 class="news-card-title">Kolaborasi Lintas Fakultas UNJ Luncurkan Kampanye Anti Narkoba di Sekolah</h3>
                        <p class="news-card-text">Mahasiswa dari berbagai fakultas bersatu untuk memberikan penyuluhan tentang bahaya penyalahgunaan narkoba kepada siswa SMA.</p>
                        <a href="#" class="news-card-link">Baca Selengkapnya <i class="fas fa-arrow-right ml-1"></i></a>
                    </div>
                </div>
            </div>
        </section>
    </main>
</body>
    @include('layout.footer')
</html>