<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SDG 5: Kesetaraan Gender - Universitas Negeri Jakarta</title>
    
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
              'sdg-orange': '#FF3A21',
              'sdg-orange-dark': '#e12d19',
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
                <img src="https://sdgs.un.org/sites/default/files/goals/E_SDG_Icons-05.jpg" alt="Icon SDG 5" class="w-full h-full object-contain">
            </div>
            <div class="text-center md:text-left mt-6 md:mt-0">
                <h1 class="text-4xl lg:text-5xl font-extrabold tracking-tight">SDG 5: Kesetaraan Gender</h1>
                <p class="mt-3 text-lg lg:text-xl font-medium opacity-90 max-w-2xl">Mencapai kesetaraan gender dan memberdayakan semua perempuan dan anak perempuan.</p>
            </div>
        </div>
    </header>

    <main>
        <section id="penjelasan-sdg" class="py-16 lg:py-24 bg-gray-50">
            <div class="container mx-auto px-6">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Tentang Tujuan Ini</h2>
                    <p class="mt-3 text-lg text-gray-600">Kesetaraan gender bukan hanya hak asasi manusia, tetapi juga landasan bagi dunia yang damai dan berkelanjutan.</p>
                    <div class="mt-4 inline-block h-1.5 w-24 bg-sdg-orange rounded-full"></div>
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">
                        <h3 class="font-bold text-xl text-gray-900 mb-4">Komitmen Global</h3>
                        <p class="text-gray-700 leading-relaxed">
                            SDG 5 menyerukan **diakhirinya semua bentuk diskriminasi dan kekerasan** terhadap perempuan dan anak perempuan di ruang publik dan privat, termasuk praktik berbahaya seperti pernikahan anak.
                        </p>
                    </div>
                    <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">
                         <h3 class="font-bold text-xl text-gray-900 mb-4">Target Utama</h3>
                        <p class="text-gray-700 leading-relaxed">
                           Menjamin partisipasi penuh dan efektif perempuan serta kesempatan yang sama untuk kepemimpinan di semua tingkat pengambilan keputusan dalam kehidupan politik, ekonomi, dan publik.
                        </p>
                    </div>
                    <div class="bg-orange-50 border-l-4 border-sdg-orange p-8 rounded-xl shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">
                         <h3 class="font-bold text-xl text-gray-900 mb-4">Peran Kami di UNJ</h3>
                         <p class="font-semibold text-gray-800 leading-relaxed">
                            Kami berkontribusi melalui Pusat Studi Gender, mengadvokasi kebijakan kampus yang adil gender, melakukan riset, dan menciptakan ruang aman bagi seluruh civitas academica.
                        </p>
                    </div>
                </div>
            </div>
        </section>
        
        <section id="target-sdg" class="py-16 lg:py-24 bg-white">
            <div class="container mx-auto px-6">
                 <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Target Global SDG 5</h2>
                    <p class="mt-3 text-lg text-gray-600">Indikator spesifik yang menjadi fokus bersama hingga tahun 2030.</p>
                    <div class="mt-4 inline-block h-1.5 w-24 bg-sdg-orange rounded-full"></div>
                </div>
                <div class="max-w-4xl mx-auto space-y-6">
                    <div class="flex items-start gap-5 bg-gray-50 p-6 rounded-xl shadow-md hover:shadow-xl hover:border-sdg-orange border-2 border-transparent transition-all duration-300">
                        <div class="flex-shrink-0 bg-sdg-orange text-white w-14 h-14 rounded-full flex items-center justify-center font-extrabold text-xl">5.1</div>
                        <div>
                            <h3 class="font-bold text-lg text-gray-900">Mengakhiri Diskriminasi</h3>
                            <p class="text-gray-600 mt-1">Mengakhiri segala bentuk diskriminasi terhadap semua perempuan dan anak perempuan di manapun.</p>
                        </div>
                    </div>
                     <div class="flex items-start gap-5 bg-gray-50 p-6 rounded-xl shadow-md hover:shadow-xl hover:border-sdg-orange border-2 border-transparent transition-all duration-300">
                        <div class="flex-shrink-0 bg-sdg-orange text-white w-14 h-14 rounded-full flex items-center justify-center font-extrabold text-xl">5.2</div>
                        <div>
                            <h3 class="font-bold text-lg text-gray-900">Menghapus Kekerasan terhadap Perempuan</h3>
                            <p class="text-gray-600 mt-1">Menghapuskan segala bentuk kekerasan terhadap semua perempuan dan anak perempuan di ruang publik dan privat, termasuk perdagangan manusia dan eksploitasi seksual.</p>
                        </div>
                    </div>
                     <div class="flex items-start gap-5 bg-gray-50 p-6 rounded-xl shadow-md hover:shadow-xl hover:border-sdg-orange border-2 border-transparent transition-all duration-300">
                        <div class="flex-shrink-0 bg-sdg-orange text-white w-14 h-14 rounded-full flex items-center justify-center font-extrabold text-xl">5.5</div>
                        <div>
                            <h3 class="font-bold text-lg text-gray-900">Menjamin Partisipasi Penuh dalam Kepemimpinan</h3>
                            <p class="text-gray-600 mt-1">Menjamin partisipasi penuh dan efektif perempuan dan kesempatan yang sama untuk kepemimpinan di semua tingkat pengambilan keputusan.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="berita-terkait" class="py-16 lg:py-24 bg-gray-50">
            <div class="container mx-auto px-6">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Aksi & Inovasi UNJ</h2>
                    <p class="mt-3 text-lg text-gray-600">Berita, kegiatan, dan program yang kami lakukan untuk mendukung SDG 5.</p>
                    <div class="mt-4 inline-block h-1.5 w-24 bg-sdg-orange rounded-full"></div>
                </div>
                
                <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">
                    <div class="lg:col-span-3 bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 flex flex-col">
                        <img src="https://images.unsplash.com/photo-1593113598332-cd288d649433?q=80&w=2070&auto=format&fit=crop" alt="Diskusi Gender" class="w-full h-64 object-cover">
                        <div class="p-8 flex-grow flex flex-col">
                            <h3 class="font-bold text-2xl mb-3 text-gray-900">Pusat Studi Gender UNJ Luncurkan Satgas PPKS untuk Ciptakan Kampus Aman</h3>
                            <p class="text-gray-600 mb-6 flex-grow">Dalam upaya menciptakan lingkungan belajar yang aman dan bebas dari kekerasan seksual, UNJ meresmikan Satuan Tugas Pencegahan dan Penanganan Kekerasan Seksual (Satgas PPKS). Inisiatif ini menjadi ujung tombak dalam advokasi, edukasi, dan penanganan kasus.</p>
                            <a href="{{ route('sdg.berita.show', ['sdg_id' => 5, 'slug' => 'pusat-studi-gender-unj-luncurkan-satgas-ppks']) }}" class="mt-auto self-start inline-block bg-sdg-orange text-white font-semibold px-6 py-3 rounded-lg hover:bg-sdg-orange-dark transition-colors duration-300">
                                Baca Selengkapnya <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                        </div>
                    </div>
                    <div class="lg:col-span-2 flex flex-col gap-8">
                        <div class="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 flex flex-col sm:flex-row lg:flex-col">
                            <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?q=80&w=2071&auto=format&fit=crop" alt="Program Kepemimpinan Perempuan" class="w-full sm:w-1/3 lg:w-full h-48 sm:h-auto lg:h-40 object-cover">
                            <div class="p-6 flex-grow flex flex-col">
                                <h3 class="font-bold text-xl mb-2 text-gray-900">Program "Women in Leadership" Bekali Mahasiswi UNJ</h3>
                                <p class="text-gray-600 mb-4 text-sm flex-grow">Serangkaian workshop dan mentoring untuk meningkatkan kapasitas kepemimpinan mahasiswi UNJ di berbagai bidang organisasi.</p>
                                <a href="{{ route('sdg.berita.show', ['sdg_id' => 5, 'slug' => 'program-women-in-leadership-bekali-mahasiswi-unj']) }}" class="mt-auto self-start text-sdg-orange font-semibold hover:text-sdg-orange-dark transition-colors">
                                    Baca Selengkapnya <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        </div>
                        <div class="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 flex flex-col sm:flex-row lg:flex-col">
                            <img src="https://images.unsplash.com/photo-1556761175-b413da4baf72?q=80&w=1974&auto=format&fit=crop" alt="Penelitian Gender" class="w-full sm:w-1/3 lg:w-full h-48 sm:h-auto lg:h-40 object-cover">
                            <div class="p-6 flex-grow flex flex-col">
                                <h3 class="font-bold text-xl mb-2 text-gray-900">FIS UNJ Teliti Kesenjangan Upah Berbasis Gender di Sektor Informal</h3>
                                <p class="text-gray-600 mb-4 text-sm flex-grow">Riset terbaru dari Fakultas Ilmu Sosial menyoroti tantangan yang dihadapi perempuan pekerja di sektor informal Jakarta.</p>
                                <a href="{{ route('sdg.berita.show', ['sdg_id' => 5, 'slug' => 'fis-unj-teliti-kesenjangan-upah-berbasis-gender']) }}" class="mt-auto self-start text-sdg-orange font-semibold hover:text-sdg-orange-dark transition-colors">
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
                    <p class="mt-3 text-lg text-gray-600">Kajian dan penelitian dari civitas academica UNJ tentang kesetaraan gender.</p>
                    <div class="mt-4 inline-block h-1.5 w-24 bg-sdg-orange rounded-full"></div>
                </div>
                <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-lg">
                    <ul class="divide-y divide-gray-200">
                        <li class="p-6">
                            <a href="#" class="flex items-center gap-5 group">
                                <i class="fas fa-file-alt text-3xl text-sdg-orange flex-shrink-0"></i>
                                <div class="flex-grow">
                                    <h3 class="font-semibold text-lg text-gray-900 group-hover:text-sdg-orange transition-colors">Representasi Perempuan dalam Kepemimpinan Politik Lokal di Indonesia</h3>
                                    <p class="text-sm text-gray-500 mt-1">Dr. Sinta Mutiara, M.Si. | Jurnal Studi Wanita Vol. 18, No. 2, 2024</p>
                                </div>
                                <i class="fas fa-download ml-auto text-xl text-gray-400 group-hover:text-sdg-orange transition-transform group-hover:scale-110"></i>
                            </a>
                        </li>
                         <li class="p-6">
                            <a href="#" class="flex items-center gap-5 group">
                                <i class="fas fa-file-alt text-3xl text-sdg-orange flex-shrink-0"></i>
                                <div class="flex-grow">
                                    <h3 class="font-semibold text-lg text-gray-900 group-hover:text-sdg-orange transition-colors">Analisis Wacana Kritis Terhadap Pemberitaan Kekerasan Berbasis Gender di Media Online</h3>
                                    <p class="text-sm text-gray-500 mt-1">Prof. Dr. Nina Karlina, M.Hum. | Jurnal Komunikasi & Masyarakat Vol. 9, No. 1, 2023</p>
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