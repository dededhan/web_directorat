<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail SDG 12: Konsumsi dan Produksi yang Bertanggung Jawab - Universitas Negeri Jakarta</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Roboto', sans-serif; background-color: #f8f9fa; }
        .sdg-header { background-color: #BF8B2E; color: white; padding: 4rem 1.5rem; text-align: center; }
        .sdg-icon-container { max-width: 180px; margin: 0 auto 1.5rem auto; background-color: white; border-radius: 12px; padding: 1rem; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        .sdg-icon-container img { width: 100%; height: auto; object-fit: contain; }
        .sdg-title { font-size: 2.5rem; font-weight: 700; }
        .sdg-subtitle { font-size: 1.25rem; margin-top: 0.5rem; opacity: 0.9; }
        .section-title { font-size: 2rem; font-weight: 700; color: #333; text-align: center; margin-bottom: 2rem; border-bottom: 3px solid #BF8B2E; display: inline-block; padding-bottom: 0.5rem; }
        .news-card { background-color: #fff; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.08); transition: transform 0.3s, box-shadow 0.3s; }
        .news-card:hover { transform: translateY(-5px); box-shadow: 0 8px 20px rgba(0,0,0,0.12); }
        .news-card img { width: 100%; height: 200px; object-fit: cover; }
        .news-card-content { padding: 1.5rem; }
        .news-card-title { font-size: 1.2rem; font-weight: 700; color: #333; margin-bottom: 0.75rem; }
        .news-card-text { color: #666; margin-bottom: 1rem; line-height: 1.6; }
        .news-card-link { color: #BF8B2E; font-weight: 700; text-decoration: none; transition: color 0.3s; }
        .news-card-link:hover { color: #a07426; }
        .back-link { display: inline-flex; align-items: center; gap: 0.5rem; margin: 2rem 0; color: #1D796B; font-weight: 700; text-decoration: none; transition: color 0.3s; }
        .back-link:hover { color: #165c52; }
    </style>
    @include('layout.navbar_hilirisasi')
</head>
<body class="bg-gray-50">

    <header class="sdg-header">
        <div class="container mx-auto px-4">
            <div class="sdg-icon-container">
                <img src="https://sdgs.un.org/sites/default/files/goals/E_SDG_Icons-12.jpg" alt="Icon SDG 12">
            </div>
            <h1 class="sdg-title">SDG 12: Konsumsi dan Produksi yang Bertanggung Jawab</h1>
            <p class="sdg-subtitle">Memastikan pola konsumsi dan produksi yang berkelanjutan.</p>
        </div>
    </header>

    <main class="container mx-auto px-4 py-12">
        <section id="penjelasan-sdg" class="mb-16">
            <div class="max-w-4xl mx-auto text-center mb-8"><h2 class="section-title">Tentang Tujuan Ini</h2></div>
            <div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-md">
                <p class="text-gray-700 text-lg leading-relaxed mb-4">SDG 12 bertujuan untuk mengubah cara kita memproduksi dan mengonsumsi barang dan jasa. Tujuannya adalah untuk mencapai pengelolaan sumber daya alam yang berkelanjutan dan efisien. Ini mencakup target untuk mengurangi separuh limbah pangan global per kapita di tingkat ritel dan konsumen, serta mengurangi kerugian makanan di sepanjang rantai produksi dan pasokan.</p>
                <p class="text-gray-700 text-lg leading-relaxed mb-4">Target lainnya adalah mencapai pengelolaan bahan kimia dan semua jenis limbah yang ramah lingkungan di sepanjang siklus hidupnya, serta secara signifikan mengurangi pelepasan limbah ke udara, air, dan tanah. SDG 12 juga mendorong perusahaan, terutama perusahaan besar dan transnasional, untuk mengadopsi praktik-praktik berkelanjutan dan mengintegrasikan informasi keberlanjutan ke dalam siklus pelaporan mereka.</p>
                <p class="text-gray-700 text-lg leading-relaxed">Universitas Negeri Jakarta menerapkan prinsip SDG 12 melalui kebijakan "Green Campus", seperti mengurangi penggunaan plastik sekali pakai, mengelola sampah secara terpadu (Reduce, Reuse, Recycle), dan mengadakan pengadaan barang yang ramah lingkungan. Kami juga melakukan penelitian dan edukasi mengenai ekonomi sirkular dan gaya hidup berkelanjutan.</p>
            </div>
        </section>

        <section id="berita-terkait">
            <div class="text-center mb-10"><h2 class="section-title">Berita & Kegiatan Terkait</h2></div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="news-card">
                    <img src="https://via.placeholder.com/400x200.png?text=Kampus+Bebas+Plastik" alt="Berita 1">
                    <div class="news-card-content">
                        <h3 class="news-card-title">UNJ Deklarasikan Gerakan Kampus Bebas Plastik Sekali Pakai</h3>
                        <p class="news-card-text">Kebijakan ini mewajibkan seluruh sivitas akademika untuk menggunakan botol minum dan tas belanja yang dapat digunakan kembali.</p>
                        <a href="#" class="news-card-link">Baca Selengkapnya <i class="fas fa-arrow-right ml-1"></i></a>
                    </div>
                </div>
                <div class="news-card">
                    <img src="https://via.placeholder.com/400x200.png?text=Bank+Sampah+UNJ" alt="Berita 2">
                    <div class="news-card-content">
                        <h3 class="news-card-title">Bank Sampah UNJ Berhasil Olah Ratusan Kilogram Sampah Anorganik Menjadi Produk Bernilai</h3>
                        <p class="news-card-text">Inisiatif yang dikelola mahasiswa ini tidak hanya mengurangi sampah, tetapi juga menghasilkan pendapatan dari penjualan produk daur ulang.</p>
                        <a href="#" class="news-card-link">Baca Selengkapnya <i class="fas fa-arrow-right ml-1"></i></a>
                    </div>
                </div>
                <div class="news-card">
                    <img src="https://via.placeholder.com/400x200.png?text=Workshop+Ekonomi+Sirkular" alt="Berita 3">
                    <div class="news-card-content">
                        <h3 class="news-card-title">Fakultas Ekonomi Gelar Workshop tentang Peluang Ekonomi Sirkular bagi UMKM</h3>
                        <p class="news-card-text">Workshop ini memberikan wawasan kepada pelaku UMKM tentang cara menerapkan model bisnis sirkular untuk meningkatkan efisiensi dan keuntungan.</p>
                        <a href="#" class="news-card-link">Baca Selengkapnya <i class="fas fa-arrow-right ml-1"></i></a>
                    </div>
                </div>
            </div>
        </section>
    </main>
</body>
@include('layout.footer')
</html>