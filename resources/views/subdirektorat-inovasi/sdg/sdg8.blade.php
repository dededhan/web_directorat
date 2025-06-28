<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail SDG 8: Pekerjaan Layak dan Pertumbuhan Ekonomi - Universitas Negeri Jakarta</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
    <style>
        body { font-family: 'Roboto', sans-serif; background-color: #f8f9fa; }
        .sdg-header { background-color: #A21942; color: white; padding: 4rem 1.5rem; text-align: center; }
        .sdg-icon-container { max-width: 180px; margin: 0 auto 1.5rem auto; background-color: white; border-radius: 12px; padding: 1rem; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        .sdg-icon-container img { width: 100%; height: auto; object-fit: contain; }
        .sdg-title { font-size: 2.5rem; font-weight: 700; }
        .sdg-subtitle { font-size: 1.25rem; margin-top: 0.5rem; opacity: 0.9; }
        .section-title { font-size: 2rem; font-weight: 700; color: #333; text-align: center; margin-bottom: 2rem; border-bottom: 3px solid #A21942; display: inline-block; padding-bottom: 0.5rem; }
        .news-card { background-color: #fff; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.08); transition: transform 0.3s, box-shadow 0.3s; }
        .news-card:hover { transform: translateY(-5px); box-shadow: 0 8px 20px rgba(0,0,0,0.12); }
        .news-card img { width: 100%; height: 200px; object-fit: cover; }
        .news-card-content { padding: 1.5rem; }
        .news-card-title { font-size: 1.2rem; font-weight: 700; color: #333; margin-bottom: 0.75rem; }
        .news-card-text { color: #666; margin-bottom: 1rem; line-height: 1.6; }
        .news-card-link { color: #A21942; font-weight: 700; text-decoration: none; transition: color 0.3s; }
        .news-card-link:hover { color: #801433; }
        .back-link { display: inline-flex; align-items: center; gap: 0.5rem; margin: 2rem 0; color: #1D796B; font-weight: 700; text-decoration: none; transition: color 0.3s; }
        .back-link:hover { color: #165c52; }
    </style>
    @include('layout.navbar_hilirisasi')
</head>
<body class="bg-gray-50">

    <header class="sdg-header">
        <div class="container mx-auto px-4">
            <div class="sdg-icon-container">
                <img src="https://sdgs.un.org/sites/default/files/goals/E_SDG_Icons-08.jpg" alt="Icon SDG 8">
            </div>
            <h1 class="sdg-title">SDG 8: Pekerjaan Layak dan Pertumbuhan Ekonomi</h1>
            <p class="sdg-subtitle">Mempromosikan pertumbuhan ekonomi inklusif dan berkelanjutan, kesempatan kerja penuh dan produktif, serta pekerjaan yang layak untuk semua.</p>
        </div>
    </header>

    <main class="container mx-auto px-4 py-12">
        <section id="penjelasan-sdg" class="mb-16">
            <div class="max-w-4xl mx-auto text-center mb-8"><h2 class="section-title">Tentang Tujuan Ini</h2></div>
            <div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-md">
                <p class="text-gray-700 text-lg leading-relaxed mb-4">SDG 8 bertujuan untuk mencapai pertumbuhan ekonomi yang berkelanjutan, dengan fokus pada sektor-sektor yang memiliki produktivitas tinggi dan padat karya. Tujuan ini mendorong kebijakan yang mendukung penciptaan lapangan kerja yang layak, kewirausahaan, kreativitas, dan inovasi.</p>
                <p class="text-gray-700 text-lg leading-relaxed mb-4">Targetnya adalah mencapai pekerjaan penuh dan produktif serta pekerjaan yang layak bagi semua perempuan dan laki-laki, termasuk bagi kaum muda dan penyandang disabilitas, dengan upah yang sama untuk pekerjaan yang sama nilainya. SDG 8 juga berkomitmen untuk memberantas kerja paksa, perbudakan modern, dan pekerja anak, serta melindungi hak-hak tenaga kerja dan mempromosikan lingkungan kerja yang aman.</p>
                <p class="text-gray-700 text-lg leading-relaxed">Fakultas Ekonomi Universitas Negeri Jakarta menjadi ujung tombak dalam mencapai SDG 8. Melalui program studi ekonomi, manajemen, dan akuntansi, kami mencetak lulusan yang siap kerja, mengembangkan program kewirausahaan mahasiswa, dan melakukan riset tentang kebijakan ekonomi yang berpihak pada pertumbuhan inklusif.</p>
            </div>
        </section>

        <section id="berita-terkait">
            <div class="text-center mb-10"><h2 class="section-title">Berita & Kegiatan Terkait</h2></div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="news-card">
                    <img src="https://via.placeholder.com/400x200.png?text=Job+Fair+UNJ" alt="Berita 1">
                    <div class="news-card-content">
                        <h3 class="news-card-title">UNJ Career Center Sukses Gelar Job Fair, Hubungkan Ribuan Lulusan dengan Industri</h3>
                        <p class="news-card-text">Acara tahunan ini menjadi jembatan bagi para lulusan UNJ untuk mendapatkan pekerjaan yang layak di berbagai perusahaan ternama.</p>
                        <a href="#" class="news-card-link">Baca Selengkapnya <i class="fas fa-arrow-right ml-1"></i></a>
                    </div>
                </div>
                <div class="news-card">
                    <img src="https://via.placeholder.com/400x200.png?text=Inkubator+Bisnis" alt="Berita 2">
                    <div class="news-card-content">
                        <h3 class="news-card-title">Inkubator Bisnis FE UNJ Bantu Mahasiswa Kembangkan Startup Inovatif</h3>
                        <p class="news-card-text">Melalui program inkubasi, mahasiswa mendapatkan bimbingan, pendanaan awal, dan jaringan untuk mewujudkan ide bisnis mereka.</p>
                        <a href="#" class="news-card-link">Baca Selengkapnya <i class="fas fa-arrow-right ml-1"></i></a>
                    </div>
                </div>
                <div class="news-card">
                    <img src="https://via.placeholder.com/400x200.png?text=Pelatihan+UMKM" alt="Berita 3">
                    <div class="news-card-content">
                        <h3 class="news-card-title">Dosen FE UNJ Berikan Pelatihan Manajemen Keuangan bagi Pelaku UMKM Lokal</h3>
                        <p class="news-card-text">Program pengabdian masyarakat ini bertujuan untuk meningkatkan kapasitas dan daya saing Usaha Mikro, Kecil, dan Menengah (UMKM).</p>
                        <a href="#" class="news-card-link">Baca Selengkapnya <i class="fas fa-arrow-right ml-1"></i></a>
                    </div>
                </div>
            </div>
        </section>
    </main>
</body>
    @include('layout.footer')
</html>