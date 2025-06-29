<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SDG 12: Konsumsi dan Produksi Bertanggung Jawab - Universitas Negeri Jakarta</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" type="image/png">

    @include('layout.navbar_hilirisasi')

    <script>
      // Custom Tailwind configuration
      tailwind.config = {
        theme: {
          extend: {
            fontFamily: {
              inter: ['Inter', 'sans-serif'],
            },
            colors: {
              'sdg-brown': '#BF8B2E',
              'sdg-brown-dark': '#9e7122',
            }
          }
        }
      }
    </script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">

    <header class="bg-sdg-brown text-white">
        <div class="container mx-auto px-6 pt-24 pb-20 flex flex-col md:flex-row items-center gap-8">
            <div class="bg-white p-4 rounded-xl shadow-2xl w-40 h-40 md:w-48 md:h-48 flex-shrink-0">
                <img src="https://sdgs.un.org/sites/default/files/goals/E_SDG_Icons-12.jpg" alt="Icon SDG 12" class="w-full h-full object-contain">
            </div>
            <div class="text-center md:text-left mt-6 md:mt-0">
                <h1 class="text-4xl lg:text-5xl font-extrabold tracking-tight">SDG 12: Konsumsi dan Produksi Bertanggung Jawab</h1>
                <p class="mt-3 text-lg lg:text-xl font-medium opacity-90 max-w-2xl">Memastikan pola konsumsi dan produksi yang berkelanjutan untuk masa depan bumi.</p>
            </div>
        </div>
    </header>

    <main>
        <section id="penjelasan-sdg" class="py-16 lg:py-24 bg-gray-50">
            <div class="container mx-auto px-6">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Tentang Tujuan Ini</h2>
                    <p class="mt-3 text-lg text-gray-600">Mengubah cara kita memproduksi dan mengonsumsi barang adalah kunci untuk mengurangi jejak ekologis kita.</p>
                    <div class="mt-4 inline-block h-1.5 w-24 bg-sdg-brown rounded-full"></div>
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">
                        <h3 class="font-bold text-xl text-gray-900 mb-4">Komitmen Global</h3>
                        <p class="text-gray-700 leading-relaxed">
                            SDG 12 mendorong **pengelolaan yang efisien atas sumber daya alam** dan cara kita membuang limbah beracun dan polutan, serta mempromosikan ekonomi sirkular.
                        </p>
                    </div>
                    <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">
                         <h3 class="font-bold text-xl text-gray-900 mb-4">Target Utama</h3>
                        <p class="text-gray-700 leading-relaxed">
                           Mengurangi separuh limbah pangan per kapita global, mengurangi secara substansial timbulan limbah melalui pencegahan, pengurangan, daur ulang, dan penggunaan kembali (4R), serta mendorong perusahaan untuk mengadopsi praktik berkelanjutan.
                        </p>
                    </div>
                    <div class="bg-yellow-50 border-l-4 border-sdg-brown p-8 rounded-xl shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">
                         <h3 class="font-bold text-xl text-gray-900 mb-4">Peran Kami di UNJ</h3>
                         <p class="font-semibold text-gray-800 leading-relaxed">
                            Kami berkontribusi melalui kebijakan kampus 'Zero Waste', riset ekonomi sirkular, dan pendidikan konsumen di berbagai fakultas seperti Ekonomi, Teknik, dan Pariwisata (Tata Boga & Busana) untuk mempromosikan gaya hidup berkelanjutan.
                        </p>
                    </div>
                </div>
            </div>
        </section>
        
        <section id="target-sdg" class="py-16 lg:py-24 bg-white">
            <div class="container mx-auto px-6">
                 <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Target Global SDG 12</h2>
                    <p class="mt-3 text-lg text-gray-600">Indikator spesifik yang menjadi fokus bersama hingga tahun 2030.</p>
                    <div class="mt-4 inline-block h-1.5 w-24 bg-sdg-brown rounded-full"></div>
                </div>
                <div class="max-w-4xl mx-auto space-y-6">
                    <div class="flex items-start gap-5 bg-gray-50 p-6 rounded-xl shadow-md hover:shadow-xl hover:border-sdg-brown border-2 border-transparent transition-all duration-300">
                        <div class="flex-shrink-0 bg-sdg-brown text-white w-14 h-14 rounded-full flex items-center justify-center font-extrabold text-xl">12.3</div>
                        <div>
                            <h3 class="font-bold text-lg text-gray-900">Mengurangi Limbah Pangan</h3>
                            <p class="text-gray-600 mt-1">Mengurangi separuh dari limbah pangan per kapita global di tingkat ritel dan konsumen dan mengurangi kehilangan makanan di sepanjang rantai produksi dan pasokan.</p>
                        </div>
                    </div>
                     <div class="flex items-start gap-5 bg-gray-50 p-6 rounded-xl shadow-md hover:shadow-xl hover:border-sdg-brown border-2 border-transparent transition-all duration-300">
                        <div class="flex-shrink-0 bg-sdg-brown text-white w-14 h-14 rounded-full flex items-center justify-center font-extrabold text-xl">12.5</div>
                        <div>
                            <h3 class="font-bold text-lg text-gray-900">Mengurangi Timbulan Sampah</h3>
                            <p class="text-gray-600 mt-1">Secara substansial mengurangi timbulan sampah melalui pencegahan, pengurangan, daur ulang, dan penggunaan kembali (4R).</p>
                        </div>
                    </div>
                     <div class="flex items-start gap-5 bg-gray-50 p-6 rounded-xl shadow-md hover:shadow-xl hover:border-sdg-brown border-2 border-transparent transition-all duration-300">
                        <div class="flex-shrink-0 bg-sdg-brown text-white w-14 h-14 rounded-full flex items-center justify-center font-extrabold text-xl">12.8</div>
                        <div>
                            <h3 class="font-bold text-lg text-gray-900">Promosi Gaya Hidup Berkelanjutan</h3>
                            <p class="text-gray-600 mt-1">Memastikan bahwa orang di mana pun memiliki informasi dan kesadaran yang relevan untuk pembangunan dan gaya hidup yang berkelanjutan selaras dengan alam.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="berita-terkait" class="py-16 lg:py-24 bg-gray-50">
            <div class="container mx-auto px-6">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Aksi & Inovasi UNJ</h2>
                    <p class="mt-3 text-lg text-gray-600">Berita, kegiatan, dan program yang kami lakukan untuk mendukung SDG 12.</p>
                     <div class="mt-4 inline-block h-1.5 w-24 bg-sdg-brown rounded-full"></div>
                </div>
                
                <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">
                    <div class="lg:col-span-3 bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 flex flex-col">
                        <img src="https://images.unsplash.com/photo-1604187351543-04114775c87a?q=80&w=2070&auto=format&fit=crop" alt="Zero Waste" class="w-full h-64 object-cover">
                        <div class="p-8 flex-grow flex flex-col">
                            <h3 class="font-bold text-2xl mb-3 text-gray-900">UNJ Luncurkan Gerakan "Zero Waste Campus" dengan Pengelolaan Sampah Terpadu</h3>
                            <p class="text-gray-600 mb-6 flex-grow">UNJ mengimplementasikan sistem pengelolaan sampah terpadu yang mewajibkan pemilahan sampah di seluruh area kampus. Sampah organik diolah menjadi kompos, sementara sampah anorganik disalurkan ke bank sampah untuk didaur ulang.</p>
                            <a href="{{ route('sdg.berita.show', ['sdg_id' => 12, 'slug' => 'unj-luncurkan-gerakan-zero-waste-campus']) }}" class="mt-auto self-start inline-block bg-sdg-brown text-white font-semibold px-6 py-3 rounded-lg hover:bg-sdg-brown-dark transition-colors duration-300">
                                Baca Selengkapnya <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                        </div>
                    </div>
                    <div class="lg:col-span-2 flex flex-col gap-8">
                        <div class="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 flex flex-col sm:flex-row lg:flex-col">
                            <img src="https://images.unsplash.com/photo-1593105544959-28c64c931a37?q=80&w=2070&auto=format&fit=crop" alt="Food Waste" class="w-full sm:w-1/3 lg:w-full h-48 sm:h-auto lg:h-40 object-cover">
                            <div class="p-6 flex-grow flex flex-col">
                                <h3 class="font-bold text-xl mb-2 text-gray-900">Prodi Tata Boga UNJ Ciptakan Produk dari Sisa Pangan (Food Loss)</h3>
                                <p class="text-gray-600 mb-4 text-sm flex-grow">Mahasiswa mengembangkan produk pangan inovatif seperti keripik dari kulit sayuran dan kaldu dari tulang sisa untuk mengurangi limbah makanan.</p>
                                <a href="{{ route('sdg.berita.show', ['sdg_id' => 12, 'slug' => 'prodi-tata-boga-ciptakan-produk-dari-sisa-pangan']) }}" class="mt-auto self-start text-sdg-brown font-semibold hover:text-sdg-brown-dark transition-colors">
                                    Baca Selengkapnya <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        </div>
                        <div class="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 flex flex-col sm:flex-row lg:flex-col">
                            <img src="https://images.unsplash.com/photo-1611212879685-53535957dc5a?q=80&w=2070&auto=format&fit=crop" alt="Fashion Berkelanjutan" class="w-full sm:w-1/3 lg:w-full h-48 sm:h-auto lg:h-40 object-cover">
                            <div class="p-6 flex-grow flex flex-col">
                                <h3 class="font-bold text-xl mb-2 text-gray-900">Peragaan Busana Berkelanjutan oleh Mahasiswa Tata Busana UNJ</h3>
                                <p class="text-gray-600 mb-4 text-sm flex-grow">Mahasiswa menampilkan koleksi busana yang dibuat dari bahan daur ulang dan limbah kain perca sebagai kampanye melawan fast fashion.</p>
                                <a href="{{ route('sdg.berita.show', ['sdg_id' => 12, 'slug' => 'peragaan-busana-berkelanjutan-tata-busana-unj']) }}" class="mt-auto self-start text-sdg-brown font-semibold hover:text-sdg-brown-dark transition-colors">
                                    Baca Selengkapnya <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <section id="publikasi-terkait" class="py-16 lg:py-24 bg-yellow-50">
            <div class="container mx-auto px-6">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Publikasi Terkait</h2>
                    <p class="mt-3 text-lg text-gray-600">Kajian dan penelitian dari civitas academica UNJ tentang konsumsi dan produksi.</p>
                    <div class="mt-4 inline-block h-1.5 w-24 bg-sdg-brown rounded-full"></div>
                </div>
                <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-lg">
                    <ul class="divide-y divide-gray-200">
                        <li class="p-6">
                            <a href="#" class="flex items-center gap-5 group">
                                <i class="fas fa-file-alt text-3xl text-sdg-brown flex-shrink-0"></i>
                                <div class="flex-grow">
                                    <h3 class="font-semibold text-lg text-gray-900 group-hover:text-sdg-brown-dark transition-colors">Penerapan Model Ekonomi Sirkular pada Industri Kecil dan Menengah (IKM) Fesyen di Jakarta</h3>
                                    <p class="text-sm text-gray-500 mt-1">Dr. Ratnawati, M.M. | Jurnal Ekonomi dan Bisnis Vol. 10, No. 2, 2024</p>
                                </div>
                                <i class="fas fa-download ml-auto text-xl text-gray-400 group-hover:text-sdg-brown-dark transition-transform group-hover:scale-110"></i>
                            </a>
                        </li>
                        <li class="p-6">
                             <a href="#" class="flex items-center gap-5 group">
                                <i class="fas fa-file-alt text-3xl text-sdg-brown flex-shrink-0"></i>
                                <div class="flex-grow">
                                    <h3 class="font-semibold text-lg text-gray-900 group-hover:text-sdg-brown-dark transition-colors">Analisis Faktor-Faktor yang Mempengaruhi Niat Beli Konsumen terhadap Produk Ramah Lingkungan</h3>
                                    <p class="text-sm text-gray-500 mt-1">Prof. Dr. Umiyati, M.Si. | Jurnal Manajemen Pemasaran Vol. 18, No. 1, 2023</p>
                                </div>
                                <i class="fas fa-download ml-auto text-xl text-gray-400 group-hover:text-sdg-brown-dark transition-transform group-hover:scale-110"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </section>
    </main>

    @include('layout.footer')

</body>
</html>