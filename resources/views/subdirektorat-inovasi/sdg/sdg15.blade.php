<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail SDG 15: Ekosistem Daratan - Universitas Negeri Jakarta</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
    <style>
        body { font-family: 'Roboto', sans-serif; background-color: #f8f9fa; }
        .sdg-header { background-color: #56C02B; color: white; padding: 4rem 1.5rem; text-align: center; }
        .sdg-icon-container { max-width: 180px; margin: 0 auto 1.5rem auto; background-color: white; border-radius: 12px; padding: 1rem; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        .sdg-icon-container img { width: 100%; height: auto; object-fit: contain; }
        .sdg-title { font-size: 2.5rem; font-weight: 700; }
        .sdg-subtitle { font-size: 1.25rem; margin-top: 0.5rem; opacity: 0.9; }
        .section-title { font-size: 2rem; font-weight: 700; color: #333; text-align: center; margin-bottom: 2rem; border-bottom: 3px solid #56C02B; display: inline-block; padding-bottom: 0.5rem; }
        .news-card { background-color: #fff; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.08); transition: transform 0.3s, box-shadow 0.3s; }
        .news-card:hover { transform: translateY(-5px); box-shadow: 0 8px 20px rgba(0,0,0,0.12); }
        .news-card img { width: 100%; height: 200px; object-fit: cover; }
        .news-card-content { padding: 1.5rem; }
        .news-card-title { font-size: 1.2rem; font-weight: 700; color: #333; margin-bottom: 0.75rem; }
        .news-card-text { color: #666; margin-bottom: 1rem; line-height: 1.6; }
        .news-card-link { color: #56C02B; font-weight: 700; text-decoration: none; transition: color 0.3s; }
        .news-card-link:hover { color: #469c22; }
        .back-link { display: inline-flex; align-items: center; gap: 0.5rem; margin: 2rem 0; color: #1D796B; font-weight: 700; text-decoration: none; transition: color 0.3s; }
        .back-link:hover { color: #165c52; }
    </style>
    @include('layout.navbar_hilirisasi')
</head>
<body class="bg-gray-50">

    <header class="sdg-header">
        <div class="container mx-auto px-4">
            <div class="sdg-icon-container">
                <img src="https://sdgs.un.org/sites/default/files/goals/E_SDG_Icons-15.jpg" alt="Icon SDG 15">
            </div>
            <h1 class="sdg-title">SDG 15: Ekosistem Daratan</h1>
            <p class="sdg-subtitle">Melindungi, merestorasi, dan mempromosikan pemanfaatan berkelanjutan ekosistem darat, mengelola hutan secara berkelanjutan, memerangi penggurunan, dan menghentikan serta membalikkan degradasi lahan dan menghentikan hilangnya keanekaragaman hayati.</p>
        </div>
    </header>

    <main class="container mx-auto px-4 py-12">
        <section id="penjelasan-sdg" class="mb-16">
            <div class="max-w-4xl mx-auto text-center mb-8"><h2 class="section-title">Tentang Tujuan Ini</h2></div>
            <div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-md">
                <p class="text-gray-700 text-lg leading-relaxed mb-4">SDG 15 berfokus pada perlindungan "kehidupan di darat". Tujuannya adalah memastikan konservasi, restorasi, dan pemanfaatan berkelanjutan ekosistem darat dan perairan tawar darat beserta jasanya. Target utamanya adalah mengelola semua jenis hutan secara berkelanjutan, menghentikan deforestasi, merestorasi hutan yang terdegradasi, dan secara substansial meningkatkan aforestasi dan reboisasi secara global.</p>
                <p class="text-gray-700 text-lg leading-relaxed mb-4">Tujuan ini juga bertujuan untuk memerangi penggurunan, memulihkan lahan dan tanah yang terdegradasi, termasuk lahan yang terkena dampak penggurunan, kekeringan, dan banjir. Selain itu, SDG 15 menyerukan tindakan mendesak untuk mengakhiri perburuan dan perdagangan ilegal spesies flora dan fauna yang dilindungi.</p>
                <p class="text-gray-700 text-lg leading-relaxed">Universitas Negeri Jakarta berkontribusi melalui program "Kampus Hijau" dengan menanam ribuan pohon dan memperluas area resapan biopori. Program studi Biologi melakukan penelitian tentang keanekaragaman hayati dan konservasi spesies, sementara program KKN mahasiswa seringkali melibatkan kegiatan reboisasi dan edukasi lingkungan kepada masyarakat di sekitar kawasan hutan.</p>
            </div>
        </section>

        <section id="berita-terkait">
            <div class="text-center mb-10"><h2 class="section-title">Berita & Kegiatan Terkait</h2></div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="news-card">
                    <img src="https://via.placeholder.com/400x200.png?text=Program+Kampus+Hijau" alt="Berita 1">
                    <div class="news-card-content">
                        <h3 class="news-card-title">Lewat Program Kampus Hijau, UNJ Tanam 5000 Pohon di Area Kampus dan Sekitarnya</h3>
                        <p class="news-card-text">Gerakan ini bertujuan untuk meningkatkan tutupan hijau, mengurangi emisi karbon, dan menciptakan lingkungan belajar yang lebih sejuk dan asri.</p>
                        <a href="#" class="news-card-link">Baca Selengkapnya <i class="fas fa-arrow-right ml-1"></i></a>
                    </div>
                </div>
                <div class="news-card">
                    <img src="https://via.placeholder.com/400x200.png?text=Konservasi+Spesies" alt="Berita 2">
                    <div class="news-card-content">
                        <h3 class="news-card-title">Tim Biologi UNJ Lakukan Ekspedisi Identifikasi Flora Langka di Taman Nasional Gunung Gede Pangrango</h3>
                        <p class="news-card-text">Ekspedisi ini berhasil mendokumentasikan beberapa spesies tumbuhan endemik yang terancam punah dan merumuskan strategi konservasinya.</p>
                        <a href="#" class="news-card-link">Baca Selengkapnya <i class="fas fa-arrow-right ml-1"></i></a>
                    </div>
                </div>
                <div class="news-card">
                    <img src="https://via.placeholder.com/400x200.png?text=Edukasi+Lingkungan" alt="Berita 3">
                    <div class="news-card-content">
                        <h3 class="news-card-title">Mahasiswa KKN UNJ Ajarkan Anak-Anak Desa Pentingnya Menjaga Hutan</h3>
                        <p class="news-card-text">Melalui permainan dan cerita, mahasiswa menanamkan kecintaan dan kesadaran akan pentingnya kelestarian hutan sejak dini.</p>
                        <a href="#" class="news-card-link">Baca Selengkapnya <i class="fas fa-arrow-right ml-1"></i></a>
                    </div>
                </div>
            </div>
        </section>
    </main>
</body>
@include('layout.footer')
</html>