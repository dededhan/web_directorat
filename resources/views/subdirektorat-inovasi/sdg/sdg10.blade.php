<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SDG 10: Berkurangnya Kesenjangan - Universitas Negeri Jakarta</title>
    
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
              'sdg-pink': '#DD1367',
              'sdg-pink-dark': '#b81055',
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

    <header class="bg-sdg-pink text-white">
        <div class="container mx-auto px-6 pt-24 pb-20 flex flex-col md:flex-row items-center gap-8">
            <div class="bg-white p-4 rounded-xl shadow-2xl w-40 h-40 md:w-48 md:h-48 flex-shrink-0">
                <img src="https://sdgs.un.org/sites/default/files/goals/E_SDG_Icons-10.jpg" alt="Icon SDG 10" class="w-full h-full object-contain">
            </div>
            <div class="text-center md:text-left mt-6 md:mt-0">
                <h1 class="text-4xl lg:text-5xl font-extrabold tracking-tight">SDG 10: Berkurangnya Kesenjangan</h1>
                <p class="mt-3 text-lg lg:text-xl font-medium opacity-90 max-w-2xl">Mengurangi kesenjangan pendapatan dan kesempatan di dalam dan antar negara.</p>
            </div>
        </div>
    </header>

    <main>
        <section id="penjelasan-sdg" class="py-16 lg:py-24 bg-gray-50">
            <div class="container mx-auto px-6">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Tentang Tujuan Ini</h2>
                    <p class="mt-3 text-lg text-gray-600">Pembangunan berkelanjutan tidak akan tercapai tanpa adanya pemerataan kesempatan untuk semua.</p>
                    <div class="mt-4 inline-block h-1.5 w-24 bg-sdg-pink rounded-full"></div>
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">
                        <h3 class="font-bold text-xl text-gray-900 mb-4">Komitmen Global</h3>
                        <p class="text-gray-700 leading-relaxed">
                            SDG 10 menyerukan untuk **memberdayakan dan mempromosikan inklusi sosial, ekonomi, dan politik bagi semua**, tanpa memandang usia, jenis kelamin, disabilitas, ras, etnis, asal, agama, atau status ekonomi lainnya.
                        </p>
                    </div>
                    <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">
                         <h3 class="font-bold text-xl text-gray-900 mb-4">Target Utama</h3>
                        <p class="text-gray-700 leading-relaxed">
                           Menjamin kesempatan yang sama dan mengurangi ketidaksetaraan hasil, termasuk dengan menghapuskan hukum, kebijakan, dan praktik yang diskriminatif dan mempromosikan legislasi yang sesuai.
                        </p>
                    </div>
                    <div class="bg-pink-50 border-l-4 border-sdg-pink p-8 rounded-xl shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">
                         <h3 class="font-bold text-xl text-gray-900 mb-4">Peran Kami di UNJ</h3>
                         <p class="font-semibold text-gray-800 leading-relaxed">
                            Kami berkontribusi melalui riset tentang ketimpangan sosial, pengembangan program pendidikan inklusif, advokasi kebijakan publik, dan menyediakan akses pendidikan tinggi yang lebih merata melalui jalur afirmasi dan beasiswa.
                        </p>
                    </div>
                </div>
            </div>
        </section>
        
        <section id="target-sdg" class="py-16 lg:py-24 bg-white">
            <div class="container mx-auto px-6">
                 <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Target Global SDG 10</h2>
                    <p class="mt-3 text-lg text-gray-600">Indikator spesifik yang menjadi fokus bersama hingga tahun 2030.</p>
                    <div class="mt-4 inline-block h-1.5 w-24 bg-sdg-pink rounded-full"></div>
                </div>
                <div class="max-w-4xl mx-auto space-y-6">
                    <div class="flex items-start gap-5 bg-gray-50 p-6 rounded-xl shadow-md hover:shadow-xl hover:border-sdg-pink border-2 border-transparent transition-all duration-300">
                        <div class="flex-shrink-0 bg-sdg-pink text-white w-14 h-14 rounded-full flex items-center justify-center font-extrabold text-xl">10.2</div>
                        <div>
                            <h3 class="font-bold text-lg text-gray-900">Mendorong Inklusi Sosial, Ekonomi, dan Politik</h3>
                            <p class="text-gray-600 mt-1">Memberdayakan dan mempromosikan inklusi sosial, ekonomi dan politik bagi semua, tanpa memandang usia, jenis kelamin, disabilitas, ras, suku, asal, agama, atau status lainnya.</p>
                        </div>
                    </div>
                     <div class="flex items-start gap-5 bg-gray-50 p-6 rounded-xl shadow-md hover:shadow-xl hover:border-sdg-pink border-2 border-transparent transition-all duration-300">
                        <div class="flex-shrink-0 bg-sdg-pink text-white w-14 h-14 rounded-full flex items-center justify-center font-extrabold text-xl">10.3</div>
                        <div>
                            <h3 class="font-bold text-lg text-gray-900">Menjamin Kesempatan yang Sama</h3>
                            <p class="text-gray-600 mt-1">Menjamin kesempatan yang sama dan mengurangi ketidaksetaraan hasil, termasuk dengan menghapuskan hukum, kebijakan dan praktik yang diskriminatif.</p>
                        </div>
                    </div>
                     <div class="flex items-start gap-5 bg-gray-50 p-6 rounded-xl shadow-md hover:shadow-xl hover:border-sdg-pink border-2 border-transparent transition-all duration-300">
                        <div class="flex-shrink-0 bg-sdg-pink text-white w-14 h-14 rounded-full flex items-center justify-center font-extrabold text-xl">10.4</div>
                        <div>
                            <h3 class="font-bold text-lg text-gray-900">Mengadopsi Kebijakan Fiskal dan Sosial</h3>
                            <p class="text-gray-600 mt-1">Mengadopsi kebijakan, terutama kebijakan fiskal, upah, dan perlindungan sosial, dan secara progresif mencapai kesetaraan yang lebih besar.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="berita-terkait" class="py-16 lg:py-24 bg-gray-50">
            <div class="container mx-auto px-6">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Aksi & Inovasi UNJ</h2>
                    <p class="mt-3 text-lg text-gray-600">Berita, kegiatan, dan program yang kami lakukan untuk mendukung SDG 10.</p>
                    <div class="mt-4 inline-block h-1.5 w-24 bg-sdg-pink rounded-full"></div>
                </div>
                
                <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">
                    <div class="lg:col-span-3 bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 flex flex-col">
                        <img src="https://images.unsplash.com/photo-1605648916319-487652792d29?q=80&w=2070&auto=format&fit=crop" alt="Pendidikan Inklusif" class="w-full h-64 object-cover">
                        <div class="p-8 flex-grow flex flex-col">
                            <h3 class="font-bold text-2xl mb-3 text-gray-900">UNJ Perkuat Komitmen Pendidikan Inklusif Melalui Pusat Layanan Disabilitas</h3>
                            <p class="text-gray-600 mb-6 flex-grow">Untuk mengurangi hambatan akses pendidikan bagi penyandang disabilitas, UNJ meresmikan Pusat Layanan Disabilitas (PLD) yang menyediakan pendampingan akademik, fasilitas aksesibel, dan teknologi asistif bagi mahasiswa berkebutuhan khusus.</p>
                            <a href="{{ route('sdg.berita.show', ['sdg_id' => 10, 'slug' => 'unj-perkuat-komitmen-pendidikan-inklusif-pld']) }}" class="mt-auto self-start inline-block bg-sdg-pink text-white font-semibold px-6 py-3 rounded-lg hover:bg-sdg-pink-dark transition-colors duration-300">
                                Baca Selengkapnya <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                        </div>
                    </div>
                    <div class="lg:col-span-2 flex flex-col gap-8">
                        <div class="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 flex flex-col sm:flex-row lg:flex-col">
                            <img src="https://images.unsplash.com/photo-1543269865-cbf427effbad?q=80&w=2070&auto=format&fit=crop" alt="Riset Sosial" class="w-full sm:w-1/3 lg:w-full h-48 sm:h-auto lg:h-40 object-cover">
                            <div class="p-6 flex-grow flex flex-col">
                                <h3 class="font-bold text-xl mb-2 text-gray-900">Riset FIS UNJ: Kesenjangan Akses Digital di Kalangan Pelajar Jakarta</h3>
                                <p class="text-gray-600 mb-4 text-sm flex-grow">Studi dari Fakultas Ilmu Sosial memetakan disparitas akses internet dan perangkat digital yang berdampak pada ketimpangan pembelajaran.</p>
                                <a href="{{ route('sdg.berita.show', ['sdg_id' => 10, 'slug' => 'riset-fis-unj-kesenjangan-akses-digital-pelajar']) }}" class="mt-auto self-start text-sdg-pink font-semibold hover:text-sdg-pink-dark transition-colors">
                                    Baca Selengkapnya <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        </div>
                        <div class="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 flex flex-col sm:flex-row lg:flex-col">
                            <img src="https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?q=80&w=1974&auto=format&fit=crop" alt="Beasiswa" class="w-full sm:w-1/3 lg:w-full h-48 sm:h-auto lg:h-40 object-cover">
                            <div class="p-6 flex-grow flex flex-col">
                                <h3 class="font-bold text-xl mb-2 text-gray-900">Perluas Jangkauan, UNJ Tingkatkan Kuota Beasiswa Afirmasi</h3>
                                <p class="text-gray-600 mb-4 text-sm flex-grow">UNJ menambah alokasi beasiswa dan jalur penerimaan khusus bagi calon mahasiswa dari daerah 3T dan keluarga prasejahtera.</p>
                                <a href="{{ route('sdg.berita.show', ['sdg_id' => 10, 'slug' => 'unj-tingkatkan-kuota-beasiswa-afirmasi']) }}" class="mt-auto self-start text-sdg-pink font-semibold hover:text-sdg-pink-dark transition-colors">
                                    Baca Selengkapnya <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
                
        <section id="publikasi-terkait" class="py-16 lg:py-24 bg-pink-50">
            <div class="container mx-auto px-6">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Publikasi Terkait</h2>
                    <p class="mt-3 text-lg text-gray-600">Kajian dan penelitian dari civitas academica UNJ tentang kesenjangan sosial.</p>
                    <div class="mt-4 inline-block h-1.5 w-24 bg-sdg-pink rounded-full"></div>
                </div>
                <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-lg">
                    <ul class="divide-y divide-gray-200">
                        <li class="p-6">
                            <a href="#" class="flex items-center gap-5 group">
                                <i class="fas fa-file-alt text-3xl text-sdg-pink flex-shrink-0"></i>
                                <div class="flex-grow">
                                    <h3 class="font-semibold text-lg text-gray-900 group-hover:text-sdg-pink transition-colors">Dampak Ketimpangan Pendapatan Terhadap Akses Layanan Kesehatan di Perkotaan</h3>
                                    <p class="text-sm text-gray-500 mt-1">Dr. Sosiologi. Aminah, M.A. | Jurnal Sosiologi Perkotaan Vol. 11, No. 2, 2024</p>
                                </div>
                                <i class="fas fa-download ml-auto text-xl text-gray-400 group-hover:text-sdg-pink transition-transform group-hover:scale-110"></i>
                            </a>
                        </li>
                        <li class="p-6">
                             <a href="#" class="flex items-center gap-5 group">
                                <i class="fas fa-file-alt text-3xl text-sdg-pink flex-shrink-0"></i>
                                <div class="flex-grow">
                                    <h3 class="font-semibold text-lg text-gray-900 group-hover:text-sdg-pink transition-colors">Model Kebijakan Pendidikan Inklusif untuk Mengurangi Kesenjangan Belajar</h3>
                                    <p class="text-sm text-gray-500 mt-1">Prof. Dr. H. M. Jufri, M.Pd. | Prosiding Seminar Nasional Kebijakan Pendidikan 2023</p>
                                </div>
                                <i class="fas fa-download ml-auto text-xl text-gray-400 group-hover:text-sdg-pink transition-transform group-hover:scale-110"></i>
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