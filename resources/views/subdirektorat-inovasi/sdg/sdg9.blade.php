<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SDG 9: Industri, Inovasi, dan Infrastruktur - Universitas Negeri Jakarta</title>
    
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
              'sdg-orange': '#FD6925',
              'sdg-orange-dark': '#e05819',
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

    <header class="bg-sdg-orange text-white">
        <div class="container mx-auto px-6 pt-24 pb-20 flex flex-col md:flex-row items-center gap-8">
            <div class="bg-white p-4 rounded-xl shadow-2xl w-40 h-40 md:w-48 md:h-48 flex-shrink-0">
                <img src="https://sdgs.un.org/sites/default/files/goals/E_SDG_Icons-09.jpg" alt="Icon SDG 9" class="w-full h-full object-contain">
            </div>
            <div class="text-center md:text-left mt-6 md:mt-0">
                <h1 class="text-4xl lg:text-5xl font-extrabold tracking-tight">SDG 9: Industri, Inovasi, dan Infrastruktur</h1>
                <p class="mt-3 text-lg lg:text-xl font-medium opacity-90 max-w-2xl">Membangun infrastruktur yang tangguh, mempromosikan industrialisasi inklusif dan berkelanjutan, serta mendorong inovasi.</p>
            </div>
        </div>
    </header>

    <main>
        <section id="penjelasan-sdg" class="py-16 lg:py-24 bg-gray-50">
            <div class="container mx-auto px-6">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Tentang Tujuan Ini</h2>
                    <p class="mt-3 text-lg text-gray-600">Inovasi dan infrastruktur adalah pendorong utama pertumbuhan ekonomi dan pembangunan.</p>
                    <div class="mt-4 inline-block h-1.5 w-24 bg-sdg-orange rounded-full"></div>
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">
                        <h3 class="font-bold text-xl text-gray-900 mb-4">Komitmen Global</h3>
                        <p class="text-gray-700 leading-relaxed">
                            SDG 9 bertujuan untuk membangun **infrastruktur yang berkualitas, andal, berkelanjutan dan tangguh**, termasuk infrastruktur regional dan lintas batas, untuk mendukung pembangunan ekonomi dan kesejahteraan manusia.
                        </p>
                    </div>
                    <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">
                         <h3 class="font-bold text-xl text-gray-900 mb-4">Target Utama</h3>
                        <p class="text-gray-700 leading-relaxed">
                           Meningkatkan penelitian ilmiah, meningkatkan kemampuan teknologi sektor industri, dan secara signifikan meningkatkan akses terhadap teknologi informasi dan komunikasi (TIK).
                        </p>
                    </div>
                    <div class="bg-orange-50 border-l-4 border-sdg-orange p-8 rounded-xl shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">
                         <h3 class="font-bold text-xl text-gray-900 mb-4">Peran Kami di UNJ</h3>
                         <p class="font-semibold text-gray-800 leading-relaxed">
                            Kami berkontribusi melalui Fakultas Teknik dan MIPA dalam menghasilkan inovasi teknologi, mengembangkan material baru, dan berkolaborasi dengan industri untuk transfer teknologi serta meningkatkan infrastruktur digital pendidikan.
                        </p>
                    </div>
                </div>
            </div>
        </section>
        
        <section id="target-sdg" class="py-16 lg:py-24 bg-white">
            <div class="container mx-auto px-6">
                 <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Target Global SDG 9</h2>
                    <p class="mt-3 text-lg text-gray-600">Indikator spesifik yang menjadi fokus bersama hingga tahun 2030.</p>
                    <div class="mt-4 inline-block h-1.5 w-24 bg-sdg-orange rounded-full"></div>
                </div>
                <div class="max-w-4xl mx-auto space-y-6">
                    <div class="flex items-start gap-5 bg-gray-50 p-6 rounded-xl shadow-md hover:shadow-xl hover:border-sdg-orange border-2 border-transparent transition-all duration-300">
                        <div class="flex-shrink-0 bg-sdg-orange text-white w-14 h-14 rounded-full flex items-center justify-center font-extrabold text-xl">9.1</div>
                        <div>
                            <h3 class="font-bold text-lg text-gray-900">Membangun Infrastruktur Tangguh</h3>
                            <p class="text-gray-600 mt-1">Mengembangkan infrastruktur yang berkualitas, andal, berkelanjutan dan tangguh untuk mendukung pembangunan ekonomi dan kesejahteraan manusia.</p>
                        </div>
                    </div>
                     <div class="flex items-start gap-5 bg-gray-50 p-6 rounded-xl shadow-md hover:shadow-xl hover:border-sdg-orange border-2 border-transparent transition-all duration-300">
                        <div class="flex-shrink-0 bg-sdg-orange text-white w-14 h-14 rounded-full flex items-center justify-center font-extrabold text-xl">9.4</div>
                        <div>
                            <h3 class="font-bold text-lg text-gray-900">Meningkatkan Industri Bersih dan Berkelanjutan</h3>
                            <p class="text-gray-600 mt-1">Memutakhirkan infrastruktur dan merevitalisasi industri agar berkelanjutan, dengan peningkatan efisiensi penggunaan sumber daya dan adopsi teknologi bersih.</p>
                        </div>
                    </div>
                     <div class="flex items-start gap-5 bg-gray-50 p-6 rounded-xl shadow-md hover:shadow-xl hover:border-sdg-orange border-2 border-transparent transition-all duration-300">
                        <div class="flex-shrink-0 bg-sdg-orange text-white w-14 h-14 rounded-full flex items-center justify-center font-extrabold text-xl">9.5</div>
                        <div>
                            <h3 class="font-bold text-lg text-gray-900">Meningkatkan Riset dan Inovasi</h3>
                            <p class="text-gray-600 mt-1">Meningkatkan penelitian ilmiah, memutakhirkan kapabilitas teknologi sektor industri di semua negara, dan mendorong inovasi.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="berita-terkait" class="py-16 lg:py-24 bg-gray-50">
            <div class="container mx-auto px-6">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Aksi & Inovasi UNJ</h2>
                    <p class="mt-3 text-lg text-gray-600">Berita, kegiatan, dan program yang kami lakukan untuk mendukung SDG 9.</p>
                    <div class="mt-4 inline-block h-1.5 w-24 bg-sdg-orange rounded-full"></div>
                </div>
                
                <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">
                    <div class="lg:col-span-3 bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 flex flex-col">
                        <img src="https://images.unsplash.com/photo-1518314916381-77a37c2a49ae?q=80&w=2071&auto=format&fit=crop" alt="Pameran Teknologi" class="w-full h-64 object-cover">
                        <div class="p-8 flex-grow flex flex-col">
                            <h3 class="font-bold text-2xl mb-3 text-gray-900">Tim Robotika UNJ Raih Juara di Kontes Robot Terbang Indonesia</h3>
                            <p class="text-gray-600 mb-6 flex-grow">Mahasiswa dari Fakultas Teknik UNJ berhasil memenangkan kategori inovasi terbaik dengan mengembangkan drone untuk pemantauan lahan pertanian. Inovasi ini menunjukkan kapasitas UNJ dalam teknologi terapan yang mendukung sektor industri.</p>
                            <a href="{{ route('sdg.berita.show', ['sdg_id' => 9, 'slug' => 'tim-robotika-unj-raih-juara-krsti']) }}" class="mt-auto self-start inline-block bg-sdg-orange text-white font-semibold px-6 py-3 rounded-lg hover:bg-sdg-orange-dark transition-colors duration-300">
                                Baca Selengkapnya <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                        </div>
                    </div>
                    <div class="lg:col-span-2 flex flex-col gap-8">
                        <div class="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 flex flex-col sm:flex-row lg:flex-col">
                            <img src="https://images.unsplash.com/photo-1532187863486-abf9dbad1b69?q=80&w=2070&auto=format&fit=crop" alt="Startup Digital" class="w-full sm:w-1/3 lg:w-full h-48 sm:h-auto lg:h-40 object-cover">
                            <div class="p-6 flex-grow flex flex-col">
                                <h3 class="font-bold text-xl mb-2 text-gray-900">Startup Digital Binaan UNJ Dapatkan Pendanaan Awal</h3>
                                <p class="text-gray-600 mb-4 text-sm flex-grow">Sebuah startup yang berfokus pada platform pembelajaran adaptif, yang didirikan oleh alumni UNJ, berhasil mendapatkan pendanaan dari investor.</p>
                                <a href="{{ route('sdg.berita.show', ['sdg_id' => 9, 'slug' => 'startup-digital-binaan-unj-dapatkan-pendanaan']) }}" class="mt-auto self-start text-sdg-orange font-semibold hover:text-sdg-orange-dark transition-colors">
                                    Baca Selengkapnya <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        </div>
                        <div class="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 flex flex-col sm:flex-row lg:flex-col">
                            <img src="https://images.unsplash.com/photo-1581092921449-41b93f2c3516?q=80&w=2070&auto=format&fit=crop" alt="Kolaborasi Industri" class="w-full sm:w-1/3 lg:w-full h-48 sm:h-auto lg:h-40 object-cover">
                            <div class="p-6 flex-grow flex flex-col">
                                <h3 class="font-bold text-xl mb-2 text-gray-900">Kolaborasi Riset UNJ dan Industri Otomotif</h3>
                                <p class="text-gray-600 mb-4 text-sm flex-grow">Fakultas Teknik menjalin kerja sama riset dengan perusahaan otomotif untuk mengembangkan material komposit ringan untuk bodi kendaraan.</p>
                                <a href="{{ route('sdg.berita.show', ['sdg_id' => 9, 'slug' => 'kolaborasi-riset-unj-dan-industri-otomotif']) }}" class="mt-auto self-start text-sdg-orange font-semibold hover:text-sdg-orange-dark transition-colors">
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
                    <p class="mt-3 text-lg text-gray-600">Kajian dan penelitian dari civitas academica UNJ tentang industri dan inovasi.</p>
                    <div class="mt-4 inline-block h-1.5 w-24 bg-sdg-orange rounded-full"></div>
                </div>
                <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-lg">
                    <ul class="divide-y divide-gray-200">
                        <li class="p-6">
                            <a href="#" class="flex items-center gap-5 group">
                                <i class="fas fa-file-alt text-3xl text-sdg-orange flex-shrink-0"></i>
                                <div class="flex-grow">
                                    <h3 class="font-semibold text-lg text-gray-900 group-hover:text-sdg-orange transition-colors">Pengembangan Beton Ringan Berkelanjutan dengan Pemanfaatan Limbah Plastik PET</h3>
                                    <p class="text-sm text-gray-500 mt-1">Dr. Ir. Widodo, M.T. | Jurnal Teknik Sipil dan Lingkungan Vol. 7, No. 2, 2024</p>
                                </div>
                                <i class="fas fa-download ml-auto text-xl text-gray-400 group-hover:text-sdg-orange transition-transform group-hover:scale-110"></i>
                            </a>
                        </li>
                        <li class="p-6">
                             <a href="#" class="flex items-center gap-5 group">
                                <i class="fas fa-file-alt text-3xl text-sdg-orange flex-shrink-0"></i>
                                <div class="flex-grow">
                                    <h3 class="font-semibold text-lg text-gray-900 group-hover:text-sdg-orange transition-colors">Model Adopsi Inovasi Digital pada Usaha Mikro, Kecil, dan Menengah (UMKM) di Indonesia</h3>
                                    <p class="text-sm text-gray-500 mt-1">Prof. Dr. V. L. G. Sari, M.M. | Jurnal Manajemen dan Inovasi Vol. 11, No. 1, 2023</p>
                                </div>
                                <i class="fas fa-download ml-auto text-xl text-gray-400 group-hover:text-sdg-orange transition-transform group-hover:scale-110"></i>
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