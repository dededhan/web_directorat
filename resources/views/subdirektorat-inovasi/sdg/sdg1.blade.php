<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SDG 1: Tanpa Kemiskinan - Universitas Negeri Jakarta</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Favicon -->
    <link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" type="image/png">

    <!-- Your existing Blade includes for Navbar -->
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
              'sdg-red': '#e5243b',
              'sdg-red-dark': '#c41a2c',
            }
          }
        }
      }
    </script>
    <style>
        /* Small style override to apply font globally */
        body {
            font-family: 'Inter', sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">

    <!-- ========= Header Section ========= -->
    <header class="bg-sdg-red text-white">
        <div class="container mx-auto px-6 pt-24 pb-20 flex flex-col md:flex-row items-center gap-8">
            <!-- SDG Icon -->
            <div class="bg-white p-4 rounded-xl shadow-2xl w-40 h-40 md:w-48 md:h-48 flex-shrink-0">
                <img src="https://sdgs.un.org/sites/default/files/goals/E_SDG_Icons-01.jpg" alt="Icon SDG 1" class="w-full h-full object-contain">
            </div>
            <!-- Header Text -->
            <div class="text-center md:text-left mt-6 md:mt-0">
                <h1 class="text-4xl lg:text-5xl font-extrabold tracking-tight">SDG 1: Tanpa Kemiskinan</h1>
                <p class="mt-3 text-lg lg:text-xl font-medium opacity-90 max-w-2xl">Mengakhiri kemiskinan dalam segala bentuk di manapun, memastikan semua orang memiliki kesempatan yang sama untuk hidup sejahtera.</p>
            </div>
        </div>
    </header>

    <!-- ========= Main Content ========= -->
    <main>
        <!-- Section: About This Goal -->
        <section id="penjelasan-sdg" class="py-16 lg:py-24 bg-gray-50">
            <div class="container mx-auto px-6">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Tentang Tujuan Ini</h2>
                    <p class="mt-3 text-lg text-gray-600">Memahami esensi dan urgensi dari Tujuan Pembangunan Berkelanjutan pertama.</p>
                    <div class="mt-4 inline-block h-1.5 w-24 bg-sdg-red rounded-full"></div>
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Card 1: Global Commitment -->
                    <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">
                        <h3 class="font-bold text-xl text-gray-900 mb-4">Komitmen Global</h3>
                        <p class="text-gray-700 leading-relaxed">
                            SDG 1 adalah komitmen untuk **mengakhiri kemiskinan dalam segala manifestasinya**. Ini bukan hanya tentang pendapatan, tetapi juga kelaparan, malnutrisi, diskriminasi, dan terbatasnya akses terhadap layanan dasar.
                        </p>
                    </div>
                    <!-- Card 2: Main Targets -->
                    <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">
                         <h3 class="font-bold text-xl text-gray-900 mb-4">Target Utama</h3>
                        <p class="text-gray-700 leading-relaxed">
                           Memberantas kemiskinan ekstrem (hidup di bawah $2.15/hari) dan mengurangi setidaknya setengah proporsi kemiskinan dalam segala dimensinya menurut definisi nasional.
                        </p>
                    </div>
                    <!-- Card 3: Our Role -->
                    <div class="bg-red-50 border-l-4 border-sdg-red p-8 rounded-xl shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">
                         <h3 class="font-bold text-xl text-gray-900 mb-4">Peran Kami di UNJ</h3>
                         <p class="font-semibold text-gray-800 leading-relaxed">
                            Kami berkontribusi melalui tridarma perguruan tinggi untuk mengembangkan inovasi sosial, mengkaji kebijakan pro-rakyat miskin, dan memberdayakan komunitas.
                        </p>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Section: SDG 1 Targets (New List Layout) -->
        <section id="target-sdg" class="py-16 lg:py-24 bg-white">
            <div class="container mx-auto px-6">
                 <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Target Global SDG 1</h2>
                    <p class="mt-3 text-lg text-gray-600">Indikator spesifik yang menjadi fokus bersama hingga tahun 2030.</p>
                    <div class="mt-4 inline-block h-1.5 w-24 bg-sdg-red rounded-full"></div>
                </div>
                <div class="max-w-4xl mx-auto space-y-6">
                    <!-- Target Item -->
                    <div class="flex items-start gap-5 bg-gray-50 p-6 rounded-xl shadow-md hover:shadow-xl hover:border-sdg-red border-2 border-transparent transition-all duration-300">
                        <div class="flex-shrink-0 bg-sdg-red text-white w-14 h-14 rounded-full flex items-center justify-center font-extrabold text-xl">1.1</div>
                        <div>
                            <h3 class="font-bold text-lg text-gray-900">Pemberantasan Kemiskinan Ekstrem</h3>
                            <p class="text-gray-600 mt-1">Memberantas kemiskinan ekstrem bagi semua orang, yang diukur sebagai orang yang hidup dengan kurang dari $2.15 per hari.</p>
                        </div>
                    </div>
                     <!-- Target Item -->
                    <div class="flex items-start gap-5 bg-gray-50 p-6 rounded-xl shadow-md hover:shadow-xl hover:border-sdg-red border-2 border-transparent transition-all duration-300">
                        <div class="flex-shrink-0 bg-sdg-red text-white w-14 h-14 rounded-full flex items-center justify-center font-extrabold text-xl">1.2</div>
                        <div>
                            <h3 class="font-bold text-lg text-gray-900">Mengurangi Kemiskinan Relatif</h3>
                            <p class="text-gray-600 mt-1">Mengurangi setidaknya setengah dari proporsi laki-laki, perempuan, dan anak-anak dari segala usia yang hidup dalam kemiskinan.</p>
                        </div>
                    </div>
                     <!-- Target Item -->
                    <div class="flex items-start gap-5 bg-gray-50 p-6 rounded-xl shadow-md hover:shadow-xl hover:border-sdg-red border-2 border-transparent transition-all duration-300">
                        <div class="flex-shrink-0 bg-sdg-red text-white w-14 h-14 rounded-full flex items-center justify-center font-extrabold text-xl">1.3</div>
                        <div>
                            <h3 class="font-bold text-lg text-gray-900">Sistem Perlindungan Sosial</h3>
                            <p class="text-gray-600 mt-1">Menerapkan sistem dan ukuran perlindungan sosial yang sesuai secara nasional untuk semua, termasuk dasar, dan mencapai cakupan substansial bagi kaum miskin dan rentan.</p>
                        </div>
                    </div>
                     <!-- Target Item -->
                    <div class="flex items-start gap-5 bg-gray-50 p-6 rounded-xl shadow-md hover:shadow-xl hover:border-sdg-red border-2 border-transparent transition-all duration-300">
                        <div class="flex-shrink-0 bg-sdg-red text-white w-14 h-14 rounded-full flex items-center justify-center font-extrabold text-xl">1.4</div>
                        <div>
                            <h3 class="font-bold text-lg text-gray-900">Hak Setara atas Sumber Daya</h3>
                            <p class="text-gray-600 mt-1">Memastikan bahwa semua laki-laki dan perempuan, khususnya kaum miskin dan rentan, memiliki hak yang sama terhadap sumber daya ekonomi.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Section: Related News & Activities (New Asymmetrical Layout) -->
        <section id="berita-terkait" class="py-16 lg:py-24 bg-gray-50">
            <div class="container mx-auto px-6">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Aksi & Inovasi UNJ</h2>
                    <p class="mt-3 text-lg text-gray-600">Berita, kegiatan, dan program yang kami lakukan untuk mendukung SDG 1.</p>
                     <div class="mt-4 inline-block h-1.5 w-24 bg-sdg-red rounded-full"></div>
                </div>
                
                <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">
                    <!-- Featured News Card -->
                    <div class="lg:col-span-3 bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 flex flex-col">
                        <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?q=80&w=2070&auto=format&fit=crop" alt="Pelatihan Kewirausahaan" class="w-full h-64 object-cover">
                        <div class="p-8 flex-grow flex flex-col">
                            <h3 class="font-bold text-2xl mb-3 text-gray-900">UNJ Gelar Pelatihan Kewirausahaan untuk Masyarakat Rentan</h3>
                            <p class="text-gray-600 mb-6 flex-grow">Program pengabdian masyarakat ini membekali peserta dengan keterampilan wirausaha digital untuk meningkatkan kemandirian ekonomi, menjangkau lebih dari 200 peserta dari berbagai komunitas di sekitar Jakarta.</p>
                            <a href="#" class="mt-auto self-start inline-block bg-sdg-red text-white font-semibold px-6 py-3 rounded-lg hover:bg-sdg-red-dark transition-colors duration-300">
                                Baca Selengkapnya <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                        </div>
                    </div>
                    <!-- Side News -->
                    <div class="lg:col-span-2 flex flex-col gap-8">
                        <!-- Side News Card 1 -->
                        <div class="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 flex flex-col sm:flex-row lg:flex-col">
                            <img src="https://images.unsplash.com/photo-1560493676-04071c5f467b?q=80&w=1974&auto=format&fit=crop" alt="Riset Dampak Iklim" class="w-full sm:w-1/3 lg:w-full h-48 sm:h-auto lg:h-40 object-cover">
                            <div class="p-6 flex-grow flex flex-col">
                                <h3 class="font-bold text-xl mb-2 text-gray-900">Studi FIS UNJ: Krisis Iklim & Kemiskinan Petani</h3>
                                <p class="text-gray-600 mb-4 text-sm flex-grow">Riset menyoroti dampak perubahan iklim pada ekonomi petani di Pantura, mendorong solusi kebijakan adaptif.</p>
                                <a href="#" class="mt-auto self-start text-sdg-red font-semibold hover:text-sdg-red-dark transition-colors">
                                    Baca Selengkapnya <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        </div>
                        <!-- Side News Card 2 -->
                        <div class="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 flex flex-col sm:flex-row lg:flex-col">
                            <img src="https://images.unsplash.com/photo-1582213782179-e0d53f98f2ca?q=80&w=2070&auto=format&fit=crop" alt="Kolaborasi dengan Pemerintah" class="w-full sm:w-1/3 lg:w-full h-48 sm:h-auto lg:h-40 object-cover">
                            <div class="p-6 flex-grow flex flex-col">
                                <h3 class="font-bold text-xl mb-2 text-gray-900">Kolaborasi Program Perlindungan Sosial</h3>
                                <p class="text-gray-600 mb-4 text-sm flex-grow">Pusat Studi SDGs UNJ bekerja sama dengan pemda untuk merancang skema jaminan sosial yang lebih efektif.</p>
                                <a href="#" class="mt-auto self-start text-sdg-red font-semibold hover:text-sdg-red-dark transition-colors">
                                    Baca Selengkapnya <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Section: Related Publications (New Section) -->
        <section id="publikasi-terkait" class="py-16 lg:py-24 bg-red-50">
            <div class="container mx-auto px-6">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Publikasi Terkait</h2>
                    <p class="mt-3 text-lg text-gray-600">Kajian dan penelitian dari civitas academica UNJ tentang pengentasan kemiskinan.</p>
                    <div class="mt-4 inline-block h-1.5 w-24 bg-sdg-red rounded-full"></div>
                </div>
                <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-lg">
                    <ul class="divide-y divide-gray-200">
                        <li class="p-6">
                            <a href="#" class="flex items-center gap-5 group">
                                <i class="fas fa-file-alt text-3xl text-sdg-red flex-shrink-0"></i>
                                <div class="flex-grow">
                                    <h3 class="font-semibold text-lg text-gray-900 group-hover:text-sdg-red transition-colors">Model Pemberdayaan Ekonomi Kreatif untuk Mengurangi Kemiskinan Perkotaan</h3>
                                    <p class="text-sm text-gray-500 mt-1">Dr. A. Budi Santoso, M.Si. | Jurnal Ekonomi Pembangunan Vol. 22, No. 1, 2024</p>
                                </div>
                                <i class="fas fa-download ml-auto text-xl text-gray-400 group-hover:text-sdg-red transition-transform group-hover:scale-110"></i>
                            </a>
                        </li>
                        <li class="p-6">
                             <a href="#" class="flex items-center gap-5 group">
                                <i class="fas fa-file-alt text-3xl text-sdg-red flex-shrink-0"></i>
                                <div class="flex-grow">
                                    <h3 class="font-semibold text-lg text-gray-900 group-hover:text-sdg-red transition-colors">Analisis Efektivitas Program Bantuan Sosial Tunai (BST) di DKI Jakarta</h3>
                                    <p class="text-sm text-gray-500 mt-1">Prof. Dr. Retno Wulandari, M.A. | Prosiding Seminar Nasional Kebijakan Publik 2023</p>
                                </div>
                                <i class="fas fa-download ml-auto text-xl text-gray-400 group-hover:text-sdg-red transition-transform group-hover:scale-110"></i>
                            </a>
                        </li>
                        <li class="p-6">
                             <a href="#" class="flex items-center gap-5 group">
                                <i class="fas fa-file-alt text-3xl text-sdg-red flex-shrink-0"></i>
                                <div class="flex-grow">
                                    <h3 class="font-semibold text-lg text-gray-900 group-hover:text-sdg-red transition-colors">Ketahanan Pangan dan Kerentanan Kemiskinan Rumah Tangga Petani</h3>
                                    <p class="text-sm text-gray-500 mt-1">Dr. Candra Wijaya, S.P., M.Sc. | Jurnal Sosiologi Pedesaan Vol. 18, No. 2, 2023</p>
                                </div>
                                <i class="fas fa-download ml-auto text-xl text-gray-400 group-hover:text-sdg-red transition-transform group-hover:scale-110"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </section>
    </main>

    <!-- Your existing Blade includes for Footer -->
    @include('layout.footer')

</body>
</html>
