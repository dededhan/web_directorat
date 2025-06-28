<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SDG 2: Tanpa Kelaparan - Universitas Negeri Jakarta</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
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
              'sdg-gold': '#DDA63A',
              'sdg-gold-dark': '#b98b2f',
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

    <header class="bg-sdg-gold text-white">
        <div class="container mx-auto px-6 pt-24 pb-20 flex flex-col md:flex-row items-center gap-8">
            <div class="bg-white p-4 rounded-xl shadow-2xl w-40 h-40 md:w-48 md:h-48 flex-shrink-0">
                <img src="https://sdgs.un.org/sites/default/files/goals/E_SDG_Icons-02.jpg" alt="Icon SDG 2" class="w-full h-full object-contain">
            </div>
            <div class="text-center md:text-left mt-6 md:mt-0">
                <h1 class="text-4xl lg:text-5xl font-extrabold tracking-tight">SDG 2: Tanpa Kelaparan</h1>
                <p class="mt-3 text-lg lg:text-xl font-medium opacity-90 max-w-2xl">Mengakhiri kelaparan, mencapai ketahanan pangan dan perbaikan nutrisi, serta menggalakkan pertanian yang berkelanjutan.</p>
            </div>
        </div>
    </header>

    <main>
        <section id="penjelasan-sdg" class="py-16 lg:py-24 bg-gray-50">
            <div class="container mx-auto px-6">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Tentang Tujuan Ini</h2>
                    <p class="mt-3 text-lg text-gray-600">Memahami pentingnya ketahanan pangan dan pertanian berkelanjutan bagi dunia.</p>
                    <div class="mt-4 inline-block h-1.5 w-24 bg-sdg-gold rounded-full"></div>
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">
                        <h3 class="font-bold text-xl text-gray-900 mb-4">Komitmen Global</h3>
                        <p class="text-gray-700 leading-relaxed">
                            SDG 2 bertujuan untuk **mengakhiri kelaparan dan segala bentuk malnutrisi** pada tahun 2030. Ini mencakup jaminan akses terhadap makanan yang aman, bergizi, dan cukup sepanjang tahun.
                        </p>
                    </div>
                    <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">
                         <h3 class="font-bold text-xl text-gray-900 mb-4">Target Utama</h3>
                        <p class="text-gray-700 leading-relaxed">
                           Meningkatkan produktivitas pertanian dan pendapatan produsen skala kecil, memastikan sistem produksi pangan berkelanjutan, dan menjaga keragaman genetik benih dan tanaman.
                        </p>
                    </div>
                    <div class="bg-yellow-50 border-l-4 border-sdg-gold p-8 rounded-xl shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">
                         <h3 class="font-bold text-xl text-gray-900 mb-4">Peran Kami di UNJ</h3>
                         <p class="font-semibold text-gray-800 leading-relaxed">
                            Kami berkontribusi melalui riset teknologi pangan, pengembangan model pertanian berkelanjutan, serta program gizi masyarakat dan edukasi pangan lokal.
                        </p>
                    </div>
                </div>
            </div>
        </section>
        
        <section id="target-sdg" class="py-16 lg:py-24 bg-white">
            <div class="container mx-auto px-6">
                 <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Target Global SDG 2</h2>
                    <p class="mt-3 text-lg text-gray-600">Indikator spesifik yang menjadi fokus bersama hingga tahun 2030.</p>
                    <div class="mt-4 inline-block h-1.5 w-24 bg-sdg-gold rounded-full"></div>
                </div>
                <div class="max-w-4xl mx-auto space-y-6">
                    <div class="flex items-start gap-5 bg-gray-50 p-6 rounded-xl shadow-md hover:shadow-xl hover:border-sdg-gold border-2 border-transparent transition-all duration-300">
                        <div class="flex-shrink-0 bg-sdg-gold text-white w-14 h-14 rounded-full flex items-center justify-center font-extrabold text-xl">2.1</div>
                        <div>
                            <h3 class="font-bold text-lg text-gray-900">Mengakhiri Kelaparan</h3>
                            <p class="text-gray-600 mt-1">Menjamin akses bagi semua orang, khususnya masyarakat miskin dan rentan, terhadap makanan yang aman, bergizi, dan cukup sepanjang tahun.</p>
                        </div>
                    </div>
                     <div class="flex items-start gap-5 bg-gray-50 p-6 rounded-xl shadow-md hover:shadow-xl hover:border-sdg-gold border-2 border-transparent transition-all duration-300">
                        <div class="flex-shrink-0 bg-sdg-gold text-white w-14 h-14 rounded-full flex items-center justify-center font-extrabold text-xl">2.2</div>
                        <div>
                            <h3 class="font-bold text-lg text-gray-900">Mengakhiri Segala Bentuk Malnutrisi</h3>
                            <p class="text-gray-600 mt-1">Mengakhiri segala bentuk kekurangan gizi, termasuk mencapai target internasional untuk stunting dan wasting pada anak di bawah usia 5 tahun.</p>
                        </div>
                    </div>
                     <div class="flex items-start gap-5 bg-gray-50 p-6 rounded-xl shadow-md hover:shadow-xl hover:border-sdg-gold border-2 border-transparent transition-all duration-300">
                        <div class="flex-shrink-0 bg-sdg-gold text-white w-14 h-14 rounded-full flex items-center justify-center font-extrabold text-xl">2.3</div>
                        <div>
                            <h3 class="font-bold text-lg text-gray-900">Produktivitas Pertanian Skala Kecil</h3>
                            <p class="text-gray-600 mt-1">Menggandakan produktivitas pertanian dan pendapatan produsen makanan skala kecil, termasuk melalui akses yang aman dan setara terhadap lahan.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="berita-terkait" class="py-16 lg:py-24 bg-gray-50">
            <div class="container mx-auto px-6">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Aksi & Inovasi UNJ</h2>
                    <p class="mt-3 text-lg text-gray-600">Berita, kegiatan, dan program yang kami lakukan untuk mendukung SDG 2.</p>
                     <div class="mt-4 inline-block h-1.5 w-24 bg-sdg-gold rounded-full"></div>
                </div>
                
                <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">
                    <div class="lg:col-span-3 bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 flex flex-col">
                        <img src="https://images.unsplash.com/photo-1599599810694-b5b37304c272?q=80&w=2070&auto=format&fit=crop" alt="Pertanian Modern" class="w-full h-64 object-cover">
                        <div class="p-8 flex-grow flex flex-col">
                            <h3 class="font-bold text-2xl mb-3 text-gray-900">UNJ Kembangkan Model Pertanian Urban untuk Ketahanan Pangan Kota</h3>
                            <p class="text-gray-600 mb-6 flex-grow">Melalui program pengabdian masyarakat, tim dari Fakultas Teknik dan MIPA UNJ mengimplementasikan sistem hidroponik dan akuaponik di lahan terbatas di area perkotaan Jakarta untuk meningkatkan ketersediaan pangan segar bagi warga.</p>
                            <a href="#" class="mt-auto self-start inline-block bg-sdg-gold text-white font-semibold px-6 py-3 rounded-lg hover:bg-sdg-gold-dark transition-colors duration-300">
                                Baca Selengkapnya <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                        </div>
                    </div>
                    <div class="lg:col-span-2 flex flex-col gap-8">
                        <div class="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 flex flex-col sm:flex-row lg:flex-col">
                            <img src="https://images.unsplash.com/photo-1627822459390-34907a5144a2?q=80&w=1974&auto=format&fit=crop" alt="Program Gizi Anak" class="w-full sm:w-1/3 lg:w-full h-48 sm:h-auto lg:h-40 object-cover">
                            <div class="p-6 flex-grow flex flex-col">
                                <h3 class="font-bold text-xl mb-2 text-gray-900">Program Gizi Seimbang untuk Anak Usia Dini</h3>
                                <p class="text-gray-600 mb-4 text-sm flex-grow">Mahasiswa UNJ mengadakan penyuluhan dan pembagian makanan bergizi di PAUD sekitar kampus untuk melawan stunting.</p>
                                <a href="#" class="mt-auto self-start text-sdg-gold font-semibold hover:text-sdg-gold-dark transition-colors">
                                    Baca Selengkapnya <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        </div>
                        <div class="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 flex flex-col sm:flex-row lg:flex-col">
                            <img src="https://images.unsplash.com/photo-1579202773197-a72d7f8d601a?q=80&w=2070&auto=format&fit=crop" alt="Pasar Petani" class="w-full sm:w-1/3 lg:w-full h-48 sm:h-auto lg:h-40 object-cover">
                            <div class="p-6 flex-grow flex flex-col">
                                <h3 class="font-bold text-xl mb-2 text-gray-900">Kolaborasi Rantai Pasok dengan Petani Lokal</h3>
                                <p class="text-gray-600 mb-4 text-sm flex-grow">Fakultas Ekonomi UNJ memfasilitasi kemitraan antara petani di daerah penyangga Jakarta dengan koperasi di kampus.</p>
                                <a href="#" class="mt-auto self-start text-sdg-gold font-semibold hover:text-sdg-gold-dark transition-colors">
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
                    <p class="mt-3 text-lg text-gray-600">Kajian dan penelitian dari civitas academica UNJ tentang ketahanan pangan.</p>
                    <div class="mt-4 inline-block h-1.5 w-24 bg-sdg-gold rounded-full"></div>
                </div>
                <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-lg">
                    <ul class="divide-y divide-gray-200">
                        <li class="p-6">
                            <a href="#" class="flex items-center gap-5 group">
                                <i class="fas fa-file-alt text-3xl text-sdg-gold flex-shrink-0"></i>
                                <div class="flex-grow">
                                    <h3 class="font-semibold text-lg text-gray-900 group-hover:text-sdg-gold transition-colors">Inovasi Teknologi Pangan untuk Peningkatan Nilai Gizi Singkong</h3>
                                    <p class="text-sm text-gray-500 mt-1">Dr. Ratna Sari, M.Sc. | Jurnal Teknologi Pertanian Vol. 15, No. 2, 2024</p>
                                </div>
                                <i class="fas fa-download ml-auto text-xl text-gray-400 group-hover:text-sdg-gold transition-transform group-hover:scale-110"></i>
                            </a>
                        </li>
                        <li class="p-6">
                             <a href="#" class="flex items-center gap-5 group">
                                <i class="fas fa-file-alt text-3xl text-sdg-gold flex-shrink-0"></i>
                                <div class="flex-grow">
                                    <h3 class="font-semibold text-lg text-gray-900 group-hover:text-sdg-gold transition-colors">Analisis Rantai Pasok Berkelanjutan untuk Komoditas Hortikultura</h3>
                                    <p class="text-sm text-gray-500 mt-1">Prof. Dr. Hendriawan, S.E., M.M. | Prosiding Seminar Nasional Agribisnis 2023</p>
                                </div>
                                <i class="fas fa-download ml-auto text-xl text-gray-400 group-hover:text-sdg-gold transition-transform group-hover:scale-110"></i>
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