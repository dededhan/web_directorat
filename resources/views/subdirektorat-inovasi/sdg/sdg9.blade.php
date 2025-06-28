<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail SDG 9: Industri, Inovasi, dan Infrastruktur - Universitas Negeri Jakarta</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
    <style>
        body { font-family: 'Roboto', sans-serif; background-color: #f8f9fa; }
        .sdg-header { background-color: #FD6925; color: white; padding: 4rem 1.5rem; text-align: center; }
        .sdg-icon-container { max-width: 180px; margin: 0 auto 1.5rem auto; background-color: white; border-radius: 12px; padding: 1rem; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        .sdg-icon-container img { width: 100%; height: auto; object-fit: contain; }
        .sdg-title { font-size: 2.5rem; font-weight: 700; }
        .sdg-subtitle { font-size: 1.25rem; margin-top: 0.5rem; opacity: 0.9; }
        .section-title { font-size: 2rem; font-weight: 700; color: #333; text-align: center; margin-bottom: 2rem; border-bottom: 3px solid #FD6925; display: inline-block; padding-bottom: 0.5rem; }
        .news-card { background-color: #fff; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.08); transition: transform 0.3s, box-shadow 0.3s; }
        .news-card:hover { transform: translateY(-5px); box-shadow: 0 8px 20px rgba(0,0,0,0.12); }
        .news-card img { width: 100%; height: 200px; object-fit: cover; }
        .news-card-content { padding: 1.5rem; }
        .news-card-title { font-size: 1.2rem; font-weight: 700; color: #333; margin-bottom: 0.75rem; }
        .news-card-text { color: #666; margin-bottom: 1rem; line-height: 1.6; }
        .news-card-link { color: #FD6925; font-weight: 700; text-decoration: none; transition: color 0.3s; }
        .news-card-link:hover { color: #e45a1c; }
        .back-link { display: inline-flex; align-items: center; gap: 0.5rem; margin: 2rem 0; color: #1D796B; font-weight: 700; text-decoration: none; transition: color 0.3s; }
        .back-link:hover { color: #165c52; }
    </style>
    @include('layout.navbar_hilirisasi')
</head>
<body class="bg-gray-50">

    <header class="sdg-header">
        <div class="container mx-auto px-4">
            <div class="sdg-icon-container">
                <img src="https://sdgs.un.org/sites/default/files/goals/E_SDG_Icons-09.jpg" alt="Icon SDG 9">
            </div>
            <h1 class="sdg-title">SDG 9: Industri, Inovasi, dan Infrastruktur</h1>
            <p class="sdg-subtitle">Membangun infrastruktur yang tangguh, mempromosikan industrialisasi inklusif dan berkelanjutan, serta mendorong inovasi.</p>
        </div>
    </header>

    <main class="container mx-auto px-4 py-12">
        <section id="penjelasan-sdg" class="mb-16">
            <div class="max-w-4xl mx-auto text-center mb-8"><h2 class="section-title">Tentang Tujuan Ini</h2></div>
            <div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-md">
                <p class="text-gray-700 text-lg leading-relaxed mb-4">SDG 9 bertujuan membangun infrastruktur berkualitas, andal, berkelanjutan, dan tangguh, termasuk infrastruktur regional dan lintas batas, untuk mendukung pembangunan ekonomi dan kesejahteraan manusia. Tujuannya adalah mempromosikan industrialisasi yang inklusif dan berkelanjutan serta meningkatkan pangsa industri dalam lapangan kerja dan PDB.</p>
                <p class="text-gray-700 text-lg leading-relaxed mb-4">Target penting dari SDG 9 adalah meningkatkan penelitian ilmiah, meningkatkan kemampuan teknologi sektor industri, dan mendorong inovasi. Ini juga mencakup peningkatan akses industri skala kecil terhadap jasa keuangan, termasuk kredit yang terjangkau, dan integrasi mereka ke dalam rantai nilai dan pasar.</p>
                <p class="text-gray-700 text-lg leading-relaxed">Fakultas Teknik Universitas Negeri Jakarta adalah motor penggerak utama dalam pencapaian SDG 9. Kami fokus pada riset terapan, pengembangan inovasi teknologi, dan penciptaan purwarupa yang siap dihilirisasi ke industri. Kami juga membina mahasiswa untuk menjadi inovator dan teknopreneur masa depan.</p>
            </div>
        </section>

        <section id="berita-terkait">
            <div class="text-center mb-10"><h2 class="section-title">Berita & Kegiatan Terkait</h2></div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="news-card">
                    <img src="https://via.placeholder.com/400x200.png?text=Lomba+Robotik" alt="Berita 1">
                    <div class="news-card-content">
                        <h3 class="news-card-title">Tim Robotik FT UNJ Raih Juara Umum di Kontes Robot Indonesia (KRI)</h3>
                        <p class="news-card-text">Prestasi ini menunjukkan keunggulan UNJ dalam bidang rekayasa dan inovasi teknologi robotika.</p>
                        <a href="#" class="news-card-link">Baca Selengkapnya <i class="fas fa-arrow-right ml-1"></i></a>
                    </div>
                </div>
                <div class="news-card">
                    <img src="https://via.placeholder.com/400x200.png?text=Kerja+Sama+Industri" alt="Berita 2">
                    <div class="news-card-content">
                        <h3 class="news-card-title">UNJ Jalin Kerja Sama Riset dengan Industri Otomotif untuk Pengembangan Komponen Lokal</h3>
                        <p class="news-card-text">Kolaborasi ini bertujuan untuk meningkatkan TKDN (Tingkat Komponen Dalam Negeri) dan mendorong kemandirian industri nasional.</p>
                        <a href="#" class="news-card-link">Baca Selengkapnya <i class="fas fa-arrow-right ml-1"></i></a>
                    </div>
                </div>
                <div class="news-card">
                    <img src="https://via.placeholder.com/400x200.png?text=Pameran+Inovasi" alt="Berita 3">
                    <div class="news-card-content">
                        <h3 class="news-card-title">Pameran Inovasi Tahunan UNJ Tampilkan Puluhan Karya Mahasiswa yang Siap Dipasarkan</h3>
                        <p class="news-card-text">Acara ini menjadi ajang untuk mempertemukan para inovator muda dengan investor dan mitra industri potensial.</p>
                        <a href="#" class="news-card-link">Baca Selengkapnya <i class="fas fa-arrow-right ml-1"></i></a>
                    </div>
                </div>
            </div>
        </section>
    </main>
</body>
@include('layout.footer')
</html>