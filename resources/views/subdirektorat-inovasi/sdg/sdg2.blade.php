<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail SDG 2: Tanpa Kelaparan - Universitas Negeri Jakarta</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
     @include('layout.navbar_hilirisasi')
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
        }
        /* Warna spesifik untuk SDG 2 */
        .sdg-header {
            background-color: #DDA63A; 
            color: white;
            padding: 4rem 1.5rem;
            text-align: center;
        }
        .sdg-icon-container {
            max-width: 180px;
            margin: 0 auto 1.5rem auto;
            background-color: white;
            border-radius: 12px;
            padding: 1rem;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .sdg-icon-container img {
            width: 100%;
            height: auto;
            object-fit: contain;
        }
        .sdg-title {
            font-size: 2.5rem;
            font-weight: 700;
        }
        .sdg-subtitle {
            font-size: 1.25rem;
            margin-top: 0.5rem;
            opacity: 0.9;
        }
        .section-title {
            font-size: 2rem;
            font-weight: 700;
            color: #333;
            text-align: center;
            margin-bottom: 2rem;
            border-bottom: 3px solid #DDA63A; /* Warna spesifik untuk SDG 2 */
            display: inline-block;
            padding-bottom: 0.5rem;
        }
        .news-card {
            background-color: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .news-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.12);
        }
        .news-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .news-card-content {
            padding: 1.5rem;
        }
        .news-card-title {
            font-size: 1.2rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 0.75rem;
        }
        .news-card-text {
            color: #666;
            margin-bottom: 1rem;
            line-height: 1.6;
        }
        .news-card-link {
            color: #DDA63A; /* Warna spesifik untuk SDG 2 */
            font-weight: 700;
            text-decoration: none;
            transition: color 0.3s;
        }
        .news-card-link:hover {
            color: #b38627;
        }
        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            margin: 2rem 0;
            color: #1D796B;
            font-weight: 700;
            text-decoration: none;
            transition: color 0.3s;
        }
        .back-link:hover {
            color: #165c52;
        }
    </style>
</head>
<body class="bg-gray-50">

    <header class="sdg-header">
        <div class="container mx-auto px-4">
            <div class="sdg-icon-container">
                <img src="https://sdgs.un.org/sites/default/files/goals/E_SDG_Icons-02.jpg" alt="Icon SDG 2">
            </div>
            <h1 class="sdg-title">SDG 2: Tanpa Kelaparan</h1>
            <p class="sdg-subtitle">Mengakhiri kelaparan, mencapai ketahanan pangan dan gizi yang baik, serta mendorong pertanian berkelanjutan.</p>
        </div>
    </header>

    <main class="container mx-auto px-4 py-12">
        <section id="penjelasan-sdg" class="mb-16">
            <div class="max-w-4xl mx-auto text-center mb-8">
                <h2 class="section-title">Tentang Tujuan Ini</h2>
            </div>
            <div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-md">
                <p class="text-gray-700 text-lg leading-relaxed mb-4">
                    Tujuan Pembangunan Berkelanjutan (SDG) 2 berupaya mengakhiri kelaparan dan segala bentuk kekurangan gizi pada tahun 2030. Ini mencakup jaminan akses terhadap makanan yang aman, bergizi, dan cukup bagi semua orang, sepanjang tahun. Tujuan ini sangat penting, terutama bagi anak-anak serta masyarakat miskin dan rentan.
                </p>
                <p class="text-gray-700 text-lg leading-relaxed mb-4">
                    Secara spesifik, targetnya meliputi peningkatan produktivitas pertanian dan pendapatan produsen pangan skala kecil, penerapan praktik pertanian berkelanjutan yang mampu beradaptasi dengan perubahan iklim, serta pemeliharaan keragaman genetik benih, tanaman, dan hewan ternak. SDG 2 juga menyerukan adanya investasi dalam infrastruktur pedesaan, riset pertanian, dan pengembangan teknologi.
                </p>
                <p class="text-gray-700 text-lg leading-relaxed">
                    Universitas Negeri Jakarta berkontribusi aktif melalui penelitian inovatif di bidang pangan dan gizi, program pengabdian masyarakat yang berfokus pada edukasi ketahanan pangan dan pertanian urban, serta pengembangan kurikulum yang mendukung terciptanya ahli-ahli di bidang pertanian dan pangan berkelanjutan.
                </p>
            </div>
        </section>

        <section id="berita-terkait">
            <div class="text-center mb-10">
                <h2 class="section-title">Berita & Kegiatan Terkait</h2>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="news-card">
                    <img src="https://via.placeholder.com/400x200.png?text=Pertanian+Urban+UNJ" alt="Berita 1">
                    <div class="news-card-content">
                        <h3 class="news-card-title">Mahasiswa UNJ Edukasi Warga tentang Pertanian Urban di Lahan Sempit</h3>
                        <p class="news-card-text">Melalui program KKN, mahasiswa memberikan pelatihan hidroponik dan vertikultur untuk meningkatkan ketahanan pangan tingkat rumah tangga di perkotaan.</p>
                        <a href="#" class="news-card-link">Baca Selengkapnya <i class="fas fa-arrow-right ml-1"></i></a>
                    </div>
                </div>

                <div class="news-card">
                    <img src="https://via.placeholder.com/400x200.png?text=Riset+Pangan+UNJ" alt="Berita 2">
                    <div class="news-card-content">
                        <h3 class="news-card-title">Riset FMIPA UNJ Kembangkan Pangan Alternatif Berbasis Sorgum</h3>
                        <p class="news-card-text">Tim peneliti dari Fakultas MIPA berhasil mengolah sorgum menjadi tepung bernutrisi tinggi sebagai alternatif pengganti gandum untuk mendukung diversifikasi pangan.</p>
                        <a href="#" class="news-card-link">Baca Selengkapnya <i class="fas fa-arrow-right ml-1"></i></a>
                    </div>
                </div>

                <div class="news-card">
                    <img src="https://via.placeholder.com/400x200.png?text=Seminar+Ketahanan+Pangan" alt="Berita 3">
                    <div class="news-card-content">
                        <h3 class="news-card-title">UNJ Gelar Seminar Nasional Ketahanan Pangan di Era Perubahan Iklim</h3>
                        <p class="news-card-text">Pakar dari berbagai universitas dan lembaga berkumpul untuk membahas strategi dan inovasi dalam menghadapi tantangan ketahanan pangan masa depan.</p>
                        <a href="#" class="news-card-link">Baca Selengkapnya <i class="fas fa-arrow-right ml-1"></i></a>
                    </div>
                </div>
            </div>
        </section>

    </main>

    </body>
        @include('layout.footer')
</html>