<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail SDG 4: Pendidikan Berkualitas - Universitas Negeri Jakarta</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Roboto', sans-serif; background-color: #f8f9fa; }
        .sdg-header { background-color: #C5192D; color: white; padding: 4rem 1.5rem; text-align: center; }
        .sdg-icon-container { max-width: 180px; margin: 0 auto 1.5rem auto; background-color: white; border-radius: 12px; padding: 1rem; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        .sdg-icon-container img { width: 100%; height: auto; object-fit: contain; }
        .sdg-title { font-size: 2.5rem; font-weight: 700; }
        .sdg-subtitle { font-size: 1.25rem; margin-top: 0.5rem; opacity: 0.9; }
        .section-title { font-size: 2rem; font-weight: 700; color: #333; text-align: center; margin-bottom: 2rem; border-bottom: 3px solid #C5192D; display: inline-block; padding-bottom: 0.5rem; }
        .news-card { background-color: #fff; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.08); transition: transform 0.3s, box-shadow 0.3s; }
        .news-card:hover { transform: translateY(-5px); box-shadow: 0 8px 20px rgba(0,0,0,0.12); }
        .news-card img { width: 100%; height: 200px; object-fit: cover; }
        .news-card-content { padding: 1.5rem; }
        .news-card-title { font-size: 1.2rem; font-weight: 700; color: #333; margin-bottom: 0.75rem; }
        .news-card-text { color: #666; margin-bottom: 1rem; line-height: 1.6; }
        .news-card-link { color: #C5192D; font-weight: 700; text-decoration: none; transition: color 0.3s; }
        .news-card-link:hover { color: #a01425; }
        .back-link { display: inline-flex; align-items: center; gap: 0.5rem; margin: 2rem 0; color: #1D796B; font-weight: 700; text-decoration: none; transition: color 0.3s; }
        .back-link:hover { color: #165c52; }
    </style>
</head>
    @include('layout.navbar_hilirisasi')
<body class="bg-gray-50">

    <header class="sdg-header">
        <div class="container mx-auto px-4">
            <div class="sdg-icon-container">
                <img src="https://sdgs.un.org/sites/default/files/goals/E_SDG_Icons-04.jpg" alt="Icon SDG 4">
            </div>
            <h1 class="sdg-title">SDG 4: Pendidikan Berkualitas</h1>
            <p class="sdg-subtitle">Memastikan pendidikan inklusif dan merata serta mempromosikan kesempatan belajar sepanjang hayat bagi semua.</p>
        </div>
    </header>

    <main class="container mx-auto px-4 py-12">
        <section id="penjelasan-sdg" class="mb-16">
            <div class="max-w-4xl mx-auto text-center mb-8"><h2 class="section-title">Tentang Tujuan Ini</h2></div>
            <div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-md">
                <p class="text-gray-700 text-lg leading-relaxed mb-4">SDG 4 adalah inti dari misi pendidikan global, yang bertujuan untuk memastikan semua anak perempuan dan laki-laki menyelesaikan pendidikan dasar dan menengah yang gratis, merata, dan berkualitas. Tujuan ini juga berupaya memberikan akses yang sama bagi semua terhadap pendidikan tinggi, kejuruan, dan teknis yang terjangkau dan berkualitas.</p>
                <p class="text-gray-700 text-lg leading-relaxed mb-4">Targetnya mencakup peningkatan jumlah pemuda dan orang dewasa yang memiliki keterampilan relevan untuk pekerjaan yang layak dan kewirausahaan. Selain itu, SDG 4 menekankan pentingnya menghilangkan disparitas gender dalam pendidikan dan memastikan akses yang sama bagi penyandang disabilitas, masyarakat adat, dan anak-anak dalam situasi rentan.</p>
                <p class="text-gray-700 text-lg leading-relaxed">Sebagai lembaga pendidikan tinggi terkemuka, Universitas Negeri Jakarta secara langsung menjadi garda terdepan dalam pencapaian SDG 4. Kami berkomitmen untuk menyediakan pendidikan berkualitas, mengembangkan kurikulum inovatif, melatih guru-guru profesional, dan melakukan penelitian untuk meningkatkan sistem pendidikan nasional.</p>
            </div>
        </section>

        <section id="berita-terkait">
            <div class="text-center mb-10"><h2 class="section-title">Berita & Kegiatan Terkait</h2></div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="news-card">
                    <img src="https://via.placeholder.com/400x200.png?text=Beasiswa+UNJ" alt="Berita 1">
                    <div class="news-card-content">
                        <h3 class="news-card-title">UNJ Tingkatkan Kuota Beasiswa untuk Mahasiswa Berprestasi dari Keluarga Kurang Mampu</h3>
                        <p class="news-card-text">Langkah ini diambil untuk memastikan akses pendidikan tinggi yang merata bagi semua calon mahasiswa potensial.</p>
                        <a href="#" class="news-card-link">Baca Selengkapnya <i class="fas fa-arrow-right ml-1"></i></a>
                    </div>
                </div>
                <div class="news-card">
                    <img src="https://via.placeholder.com/400x200.png?text=Pelatihan+Guru" alt="Berita 2">
                    <div class="news-card-content">
                        <h3 class="news-card-title">FIP UNJ Selenggarakan Pelatihan Metode Pembelajaran Digital untuk Guru di Daerah 3T</h3>
                        <p class="news-card-text">Program ini bertujuan untuk meningkatkan kompetensi guru dalam memanfaatkan teknologi untuk pembelajaran yang efektif dan menarik.</p>
                        <a href="#" class="news-card-link">Baca Selengkapnya <i class="fas fa-arrow-right ml-1"></i></a>
                    </div>
                </div>
                <div class="news-card">
                    <img src="https://via.placeholder.com/400x200.png?text=Pendidikan+Inklusif" alt="Berita 3">
                    <div class="news-card-content">
                        <h3 class="news-card-title">UNJ Resmikan Pusat Layanan Disabilitas untuk Mendukung Mahasiswa Berkebutuhan Khusus</h3>
                        <p class="news-card-text">Pusat layanan ini menyediakan fasilitas dan pendampingan untuk menciptakan lingkungan belajar yang inklusif dan ramah disabilitas.</p>
                        <a href="#" class="news-card-link">Baca Selengkapnya <i class="fas fa-arrow-right ml-1"></i></a>
                    </div>
                </div>
            </div>
        </section>
    </main>
</body>
    @include('layout.footer')
</html>