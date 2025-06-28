<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SDG 11: Kota dan Permukiman Berkelanjutan - Universitas Negeri Jakarta</title>
    
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
              'sdg-city-orange': '#FD9D24',
              'sdg-city-orange-dark': '#e48915',
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

    <header class="bg-sdg-city-orange text-white">
        <div class="container mx-auto px-6 pt-24 pb-20 flex flex-col md:flex-row items-center gap-8">
            <div class="bg-white p-4 rounded-xl shadow-2xl w-40 h-40 md:w-48 md:h-48 flex-shrink-0">
                <img src="https://sdgs.un.org/sites/default/files/goals/E_SDG_Icons-11.jpg" alt="Icon SDG 11" class="w-full h-full object-contain">
            </div>
            <div class="text-center md:text-left mt-6 md:mt-0">
                <h1 class="text-4xl lg:text-5xl font-extrabold tracking-tight">SDG 11: Kota dan Permukiman Berkelanjutan</h1>
                <p class="mt-3 text-lg lg:text-xl font-medium opacity-90 max-w-2xl">Menjadikan kota dan permukiman manusia inklusif, aman, tangguh, dan berkelanjutan.</p>
            </div>
        </div>
    </header>

    <main>
        <section id="penjelasan-sdg" class="py-16 lg:py-24 bg-gray-50">
            <div class="container mx-auto px-6">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Tentang Tujuan Ini</h2>
                    <p class="mt-3 text-lg text-gray-600">Lebih dari setengah populasi dunia kini tinggal di perkotaan, membuat pembangunan kota yang berkelanjutan menjadi krusial.</p>
                    <div class="mt-4 inline-block h-1.5 w-24 bg-sdg-city-orange rounded-full"></div>
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">
                        <h3 class="font-bold text-xl text-gray-900 mb-4">Komitmen Global</h3>
                        <p class="text-gray-700 leading-relaxed">
                            SDG 11 berkomitmen untuk memastikan **akses bagi semua terhadap perumahan dan pelayanan dasar yang layak, aman dan terjangkau**, serta menata kawasan kumuh.
                        </p>
                    </div>
                    <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">
                         <h3 class="font-bold text-xl text-gray-900 mb-4">Target Utama</h3>
                        <p class="text-gray-700 leading-relaxed">
                           Menyediakan akses terhadap sistem transportasi yang aman, terjangkau, dan berkelanjutan, serta menyediakan akses universal ke ruang publik yang aman, inklusif, dan dapat diakses, terutama bagi perempuan, anak-anak, dan penyandang disabilitas.
                        </p>
                    </div>
                    <div class="bg-orange-50 border-l-4 border-sdg-city-orange p-8 rounded-xl shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">
                         <h3 class="font-bold text-xl text-gray-900 mb-4">Peran Kami di UNJ</h3>
                         <p class="font-semibold text-gray-800 leading-relaxed">
                            Kami berkontribusi melalui riset perkotaan, perencanaan wilayah, rekayasa sipil dan transportasi, serta program sosiologi yang berfokus pada dinamika masyarakat urban dan penataan ruang publik.
                        </p>
                    </div>
                </div>
            </div>
        </section>
        
        <section id="target-sdg" class="py-16 lg:py-24 bg-white">
            <div class="container mx-auto px-6">
                 <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Target Global SDG 11</h2>
                    <p class="mt-3 text-lg text-gray-600">Indikator spesifik yang menjadi fokus bersama hingga tahun 2030.</p>
                    <div class="mt-4 inline-block h-1.5 w-24 bg-sdg-city-orange rounded-full"></div>
                </div>
                <div class="max-w-4xl mx-auto space-y-6">
                    <div class="flex items-start gap-5 bg-gray-50 p-6 rounded-xl shadow-md hover:shadow-xl hover:border-sdg-city-orange border-2 border-transparent transition-all duration-300">
                        <div class="flex-shrink-0 bg-sdg-city-orange text-white w-14 h-14 rounded-full flex items-center justify-center font-extrabold text-xl">11.1</div>
                        <div>
                            <h3 class="font-bold text-lg text-gray-900">Perumahan dan Pelayanan Dasar yang Layak</h3>
                            <p class="text-gray-600 mt-1">Memastikan akses bagi semua terhadap perumahan dan pelayanan dasar yang layak, aman dan terjangkau, dan menata kawasan kumuh.</p>
                        </div>
                    </div>
                     <div class="flex items-start gap-5 bg-gray-50 p-6 rounded-xl shadow-md hover:shadow-xl hover:border-sdg-city-orange border-2 border-transparent transition-all duration-300">
                        <div class="flex-shrink-0 bg-sdg-city-orange text-white w-14 h-14 rounded-full flex items-center justify-center font-extrabold text-xl">11.2</div>
                        <div>
                            <h3 class="font-bold text-lg text-gray-900">Transportasi yang Aman dan Terjangkau</h3>
                            <p class="text-gray-600 mt-1">Menyediakan akses terhadap sistem transportasi yang aman, terjangkau, mudah diakses dan berkelanjutan untuk semua.</p>
                        </div>
                    </div>
                     <div class="flex items-start gap-5 bg-gray-50 p-6 rounded-xl shadow-md hover:shadow-xl hover:border-sdg-city-orange border-2 border-transparent transition-all duration-300">
                        <div class="flex-shrink-0 bg-sdg-city-orange text-white w-14 h-14 rounded-full flex items-center justify-center font-extrabold text-xl">11.7</div>
                        <div>
                            <h3 class="font-bold text-lg text-gray-900">Akses Universal ke Ruang Publik</h3>
                            <p class="text-gray-600 mt-1">Menyediakan akses universal ke ruang publik yang aman, inklusif dan dapat diakses, hijau dan publik, khususnya bagi perempuan dan anak-anak, lansia dan penyandang disabilitas.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="berita-terkait" class="py-16 lg:py-24 bg-gray-50">
            <div class="container mx-auto px-6">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Aksi & Inovasi UNJ</h2>
                    <p class="mt-3 text-lg text-gray-600">Berita, kegiatan, dan program yang kami lakukan untuk mendukung SDG 11.</p>
                     <div class="mt-4 inline-block h-1.5 w-24 bg-sdg-city-orange rounded-full"></div>
                </div>
                
                <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">
                    <div class="lg:col-span-3 bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 flex flex-col">
                        <img src="https://images.unsplash.com/photo-1541888946425-d81bb19240f5?q=80&w=2070&auto=format&fit=crop" alt="Perencanaan Kota" class="w-full h-64 object-cover">
                        <div class="p-8 flex-grow flex flex-col">
                            <h3 class="font-bold text-2xl mb-3 text-gray-900">FIS UNJ Lakukan Pemetaan Partisipatif untuk Revitalisasi Ruang Publik di Jakarta</h3>
                            <p class="text-gray-600 mb-6 flex-grow">Melibatkan warga lokal, mahasiswa dari Fakultas Ilmu Sosial (FIS) memetakan kebutuhan dan potensi ruang-ruang publik yang terbengkalai untuk diusulkan menjadi taman, area bermain, atau ruang interaksi warga yang lebih bermanfaat.</p>
                            <a href="#" class="mt-auto self-start inline-block bg-sdg-city-orange text-white font-semibold px-6 py-3 rounded-lg hover:bg-sdg-city-orange-dark transition-colors duration-300">
                                Baca Selengkapnya <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                        </div>
                    </div>
                    <div class="lg:col-span-2 flex flex-col gap-8">
                        <div class="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 flex flex-col sm:flex-row lg:flex-col">
                            <img src="https://images.unsplash.com/photo-1517488629431-1d5843433a4c?q=80&w=2070&auto=format&fit=crop" alt="Transportasi" class="w-full sm:w-1/3 lg:w-full h-48 sm:h-auto lg:h-40 object-cover">
                            <div class="p-6 flex-grow flex flex-col">
                                <h3 class="font-bold text-xl mb-2 text-gray-900">Riset FT UNJ: Model Integrasi Transportasi Publik Jabodetabek</h3>
                                <p class="text-gray-600 mb-4 text-sm flex-grow">Tim dari Teknik Sipil merancang model untuk meningkatkan konektivitas antara berbagai moda transportasi publik guna mengurangi kemacetan.</p>
                                <a href="#" class="mt-auto self-start text-sdg-city-orange font-semibold hover:text-sdg-city-orange-dark transition-colors">
                                    Baca Selengkapnya <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        </div>
                        <div class="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 flex flex-col sm:flex-row lg:flex-col">
                            <img src="https://images.unsplash.com/photo-1599056262426-521639c43d81?q=80&w=2070&auto=format&fit=crop" alt="Pengelolaan Sampah" class="w-full sm:w-1/3 lg:w-full h-48 sm:h-auto lg:h-40 object-cover">
                            <div class="p-6 flex-grow flex flex-col">
                                <h3 class="font-bold text-xl mb-2 text-gray-900">KKN Tematik UNJ Fokus pada Program Bank Sampah Digital</h3>
                                <p class="text-gray-600 mb-4 text-sm flex-grow">Mahasiswa KKN UNJ mendampingi warga di beberapa RW untuk mengimplementasikan sistem bank sampah berbasis aplikasi mobile.</p>
                                <a href="#" class="mt-auto self-start text-sdg-city-orange font-semibold hover:text-sdg-city-orange-dark transition-colors">
                                    Baca Selengkapnya <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <section id="publikasi-terkait" class="py-16 lg:py-24 bg-orange-50">
            <div class="container mx-auto px-6">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Publikasi Terkait</h2>
                    <p class="mt-3 text-lg text-gray-600">Kajian dan penelitian dari civitas academica UNJ tentang kota berkelanjutan.</p>
                    <div class="mt-4 inline-block h-1.5 w-24 bg-sdg-city-orange rounded-full"></div>
                </div>
                <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-lg">
                    <ul class="divide-y divide-gray-200">
                        <li class="p-6">
                            <a href="#" class="flex items-center gap-5 group">
                                <i class="fas fa-file-alt text-3xl text-sdg-city-orange flex-shrink-0"></i>
                                <div class="flex-grow">
                                    <h3 class="font-semibold text-lg text-gray-900 group-hover:text-sdg-city-orange-dark transition-colors">Analisis Pola Mobilitas Urban dan Implikasinya terhadap Perencanaan Transportasi di Megapolitan Jakarta</h3>
                                    <p class="text-sm text-gray-500 mt-1">Dr. Geografi. Rika Harini, M.Sc. | Jurnal Perencanaan Wilayah dan Kota Vol. 35, No. 1, 2024</p>
                                </div>
                                <i class="fas fa-download ml-auto text-xl text-gray-400 group-hover:text-sdg-city-orange-dark transition-transform group-hover:scale-110"></i>
                            </a>
                        </li>
                        <li class="p-6">
                             <a href="#" class="flex items-center gap-5 group">
                                <i class="fas fa-file-alt text-3xl text-sdg-city-orange flex-shrink-0"></i>
                                <div class="flex-grow">
                                    <h3 class="font-semibold text-lg text-gray-900 group-hover:text-sdg-city-orange-dark transition-colors">Peran Ruang Terbuka Hijau dalam Meningkatkan Kualitas Hidup Masyarakat Perkotaan</h3>
                                    <p class="text-sm text-gray-500 mt-1">Prof. Dr. Sosiologi. Bambang Setiadi, M.Si. | Prosiding Seminar Nasional Sosiologi Lingkungan 2023</p>
                                </div>
                                <i class="fas fa-download ml-auto text-xl text-gray-400 group-hover:text-sdg-city-orange-dark transition-transform group-hover:scale-110"></i>
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