<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SDG 16: Perdamaian, Keadilan, dan Kelembagaan Tangguh - Universitas Negeri Jakarta</title>
    
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
              'sdg-peace-blue': '#00689D',
              'sdg-peace-blue-dark': '#004c73',
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

    <header class="bg-sdg-peace-blue text-white">
        <div class="container mx-auto px-6 pt-24 pb-20 flex flex-col md:flex-row items-center gap-8">
            <div class="bg-white p-4 rounded-xl shadow-2xl w-40 h-40 md:w-48 md:h-48 flex-shrink-0">
                <img src="https://sdgs.un.org/sites/default/files/goals/E_SDG_Icons-16.jpg" alt="Icon SDG 16" class="w-full h-full object-contain">
            </div>
            <div class="text-center md:text-left mt-6 md:mt-0">
                <h1 class="text-4xl lg:text-5xl font-extrabold tracking-tight">SDG 16: Perdamaian, Keadilan, dan Kelembagaan Tangguh</h1>
                <p class="mt-3 text-lg lg:text-xl font-medium opacity-90 max-w-2xl">Mendorong masyarakat damai dan inklusif, menyediakan akses keadilan, dan membangun institusi yang efektif dan akuntabel.</p>
            </div>
        </div>
    </header>

    <main>
        <section id="penjelasan-sdg" class="py-16 lg:py-24 bg-gray-50">
            <div class="container mx-auto px-6">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Tentang Tujuan Ini</h2>
                    <p class="mt-3 text-lg text-gray-600">Pembangunan berkelanjutan tidak mungkin terwujud tanpa perdamaian, stabilitas, hak asasi manusia, dan tata kelola pemerintahan yang efektif.</p>
                    <div class="mt-4 inline-block h-1.5 w-24 bg-sdg-peace-blue rounded-full"></div>
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">
                        <h3 class="font-bold text-xl text-gray-900 mb-4">Komitmen Global</h3>
                        <p class="text-gray-700 leading-relaxed">
                            SDG 16 bertujuan untuk **mengurangi secara signifikan segala bentuk kekerasan** dan angka kematian terkait di mana pun, serta mengakhiri perlakuan kejam, eksploitasi, dan penyiksaan anak.
                        </p>
                    </div>
                    <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">
                         <h3 class="font-bold text-xl text-gray-900 mb-4">Target Utama</h3>
                        <p class="text-gray-700 leading-relaxed">
                           Mempromosikan supremasi hukum di tingkat nasional dan internasional dan memastikan akses yang sama terhadap keadilan bagi semua, serta secara substansial mengurangi korupsi dan penyuapan dalam segala bentuknya.
                        </p>
                    </div>
                    <div class="bg-blue-50 border-l-4 border-sdg-peace-blue p-8 rounded-xl shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">
                         <h3 class="font-bold text-xl text-gray-900 mb-4">Peran Kami di UNJ</h3>
                         <p class="font-semibold text-gray-800 leading-relaxed">
                            Kami berkontribusi melalui pendidikan kewarganegaraan, studi hukum dan kebijakan publik, riset sosiologi konflik, dan promosi nilai-nilai demokrasi, transparansi, serta anti-korupsi di dalam dan di luar kampus.
                        </p>
                    </div>
                </div>
            </div>
        </section>
        
        <section id="target-sdg" class="py-16 lg:py-24 bg-white">
            <div class="container mx-auto px-6">
                 <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Target Global SDG 16</h2>
                    <p class="mt-3 text-lg text-gray-600">Indikator spesifik yang menjadi fokus bersama hingga tahun 2030.</p>
                    <div class="mt-4 inline-block h-1.5 w-24 bg-sdg-peace-blue rounded-full"></div>
                </div>
                <div class="max-w-4xl mx-auto space-y-6">
                    <div class="flex items-start gap-5 bg-gray-50 p-6 rounded-xl shadow-md hover:shadow-xl hover:border-sdg-peace-blue border-2 border-transparent transition-all duration-300">
                        <div class="flex-shrink-0 bg-sdg-peace-blue text-white w-14 h-14 rounded-full flex items-center justify-center font-extrabold text-xl">16.3</div>
                        <div>
                            <h3 class="font-bold text-lg text-gray-900">Mempromosikan Supremasi Hukum</h3>
                            <p class="text-gray-600 mt-1">Mempromosikan supremasi hukum di tingkat nasional dan internasional dan memastikan akses yang sama terhadap keadilan bagi semua.</p>
                        </div>
                    </div>
                     <div class="flex items-start gap-5 bg-gray-50 p-6 rounded-xl shadow-md hover:shadow-xl hover:border-sdg-peace-blue border-2 border-transparent transition-all duration-300">
                        <div class="flex-shrink-0 bg-sdg-peace-blue text-white w-14 h-14 rounded-full flex items-center justify-center font-extrabold text-xl">16.5</div>
                        <div>
                            <h3 class="font-bold text-lg text-gray-900">Mengurangi Korupsi</h3>
                            <p class="text-gray-600 mt-1">Mengurangi secara substansial korupsi dan penyuapan dalam segala bentuknya.</p>
                        </div>
                    </div>
                     <div class="flex items-start gap-5 bg-gray-50 p-6 rounded-xl shadow-md hover:shadow-xl hover:border-sdg-peace-blue border-2 border-transparent transition-all duration-300">
                        <div class="flex-shrink-0 bg-sdg-peace-blue text-white w-14 h-14 rounded-full flex items-center justify-center font-extrabold text-xl">16.6</div>
                        <div>
                            <h3 class="font-bold text-lg text-gray-900">Membangun Institusi yang Akuntabel</h3>
                            <p class="text-gray-600 mt-1">Mengembangkan institusi yang efektif, akuntabel dan transparan di semua tingkatan.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="berita-terkait" class="py-16 lg:py-24 bg-gray-50">
            <div class="container mx-auto px-6">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Aksi & Inovasi UNJ</h2>
                    <p class="mt-3 text-lg text-gray-600">Berita, kegiatan, dan program yang kami lakukan untuk mendukung SDG 16.</p>
                     <div class="mt-4 inline-block h-1.5 w-24 bg-sdg-peace-blue rounded-full"></div>
                </div>
                
                <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">
                    <div class="lg:col-span-3 bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 flex flex-col">
                        <img src="https://images.unsplash.com/photo-1542744173-8e7e53415bb0?q=80&w=2070&auto=format&fit=crop" alt="Penyuluhan Hukum" class="w-full h-64 object-cover">
                        <div class="p-8 flex-grow flex flex-col">
                            <h3 class="font-bold text-2xl mb-3 text-gray-900">Pusat Studi Hukum UNJ Gelar Penyuluhan Hukum Gratis dan Bantuan Hukum bagi Masyarakat</h3>
                            <p class="text-gray-600 mb-6 flex-grow">Dalam rangka meningkatkan akses terhadap keadilan, UNJ menyediakan layanan konsultasi dan bantuan hukum cuma-cuma bagi masyarakat kurang mampu. Program ini melibatkan dosen dan mahasiswa sebagai paralegal untuk memberikan pendampingan.</p>
                            <a href="{{ route('sdg.berita.show', ['sdg_id' => 16, 'slug' => 'pusat-studi-hukum-gelar-penyuluhan-hukum-gratis']) }}" class="mt-auto self-start inline-block bg-sdg-peace-blue text-white font-semibold px-6 py-3 rounded-lg hover:bg-sdg-peace-blue-dark transition-colors duration-300">
                                Baca Selengkapnya <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                        </div>
                    </div>
                    <div class="lg:col-span-2 flex flex-col gap-8">
                        <div class="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 flex flex-col sm:flex-row lg:flex-col">
                            <img src="https://images.unsplash.com/photo-1600880292210-2ad6a4a13433?q=80&w=2070&auto=format&fit=crop" alt="Anti Korupsi" class="w-full sm:w-1/3 lg:w-full h-48 sm:h-auto lg:h-40 object-cover">
                            <div class="p-6 flex-grow flex flex-col">
                                <h3 class="font-bold text-xl mb-2 text-gray-900">UNJ Deklarasikan Zona Integritas Menuju Wilayah Bebas Korupsi</h3>
                                <p class="text-gray-600 mb-4 text-sm flex-grow">Sebagai komitmen institusional, UNJ mencanangkan pembangunan zona integritas untuk menciptakan tata kelola yang bersih dan transparan.</p>
                                <a href="{{ route('sdg.berita.show', ['sdg_id' => 16, 'slug' => 'unj-deklarasikan-zona-integritas']) }}" class="mt-auto self-start text-sdg-peace-blue font-semibold hover:text-sdg-peace-blue-dark transition-colors">
                                    Baca Selengkapnya <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        </div>
                        <div class="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 flex flex-col sm:flex-row lg:flex-col">
                            <img src="https://images.unsplash.com/photo-1529070538774-1843cb3265df?q=80&w=2070&auto=format&fit=crop" alt="Pendidikan Kewarganegaraan" class="w-full sm:w-1/3 lg:w-full h-48 sm:h-auto lg:h-40 object-cover">
                            <div class="p-6 flex-grow flex flex-col">
                                <h3 class="font-bold text-xl mb-2 text-gray-900">Prodi PKn UNJ Inisiasi "Sekolah Demokrasi" untuk Pelajar SMA</h3>
                                <p class="text-gray-600 mb-4 text-sm flex-grow">Program ini bertujuan untuk menanamkan nilai-nilai demokrasi, toleransi, dan partisipasi aktif kepada generasi muda sejak dini.</p>
                                <a href="{{ route('sdg.berita.show', ['sdg_id' => 16, 'slug' => 'prodi-pkn-inisiasi-sekolah-demokrasi']) }}" class="mt-auto self-start text-sdg-peace-blue font-semibold hover:text-sdg-peace-blue-dark transition-colors">
                                    Baca Selengkapnya <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <section id="publikasi-terkait" class="py-16 lg:py-24 bg-blue-50">
            <div class="container mx-auto px-6">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Publikasi Terkait</h2>
                    <p class="mt-3 text-lg text-gray-600">Kajian dan penelitian dari civitas academica UNJ tentang keadilan dan kelembagaan.</p>
                    <div class="mt-4 inline-block h-1.5 w-24 bg-sdg-peace-blue rounded-full"></div>
                </div>
                <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-lg">
                    <ul class="divide-y divide-gray-200">
                        <li class="p-6">
                            <a href="#" class="flex items-center gap-5 group">
                                <i class="fas fa-file-alt text-3xl text-sdg-peace-blue flex-shrink-0"></i>
                                <div class="flex-grow">
                                    <h3 class="font-semibold text-lg text-gray-900 group-hover:text-sdg-peace-blue-dark transition-colors">Efektivitas Mediasi sebagai Alternatif Penyelesaian Sengketa di Luar Pengadilan</h3>
                                    <p class="text-sm text-gray-500 mt-1">Dr. Hukum. Retno Saraswati, S.H., M.H. | Jurnal Hukum dan Pembangunan Vol. 54, No. 2, 2024</p>
                                </div>
                                <i class="fas fa-download ml-auto text-xl text-gray-400 group-hover:text-sdg-peace-blue-dark transition-transform group-hover:scale-110"></i>
                            </a>
                        </li>
                        <li class="p-6">
                             <a href="#" class="flex items-center gap-5 group">
                                <i class="fas fa-file-alt text-3xl text-sdg-peace-blue flex-shrink-0"></i>
                                <div class="flex-grow">
                                    <h3 class="font-semibold text-lg text-gray-900 group-hover:text-sdg-peace-blue-dark transition-colors">Studi tentang Persepsi Publik terhadap Akuntabilitas Lembaga Pemerintahan Daerah</h3>
                                    <p class="text-sm text-gray-500 mt-1">Prof. Dr. Ilmu Pemerintahan. Bintoro, M.Si. | Jurnal Administrasi Publik Vol. 13, No. 1, 2023</p>
                                </div>
                                <i class="fas fa-download ml-auto text-xl text-gray-400 group-hover:text-sdg-peace-blue-dark transition-transform group-hover:scale-110"></i>
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