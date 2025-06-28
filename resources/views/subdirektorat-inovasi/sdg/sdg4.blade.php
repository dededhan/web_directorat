<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SDG 4: Pendidikan Berkualitas - Universitas Negeri Jakarta</title>
    
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
              'sdg-red-edu': '#C5192D',
              'sdg-red-edu-dark': '#a11425',
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

    <header class="bg-sdg-red-edu text-white">
        <div class="container mx-auto px-6 pt-24 pb-20 flex flex-col md:flex-row items-center gap-8">
            <div class="bg-white p-4 rounded-xl shadow-2xl w-40 h-40 md:w-48 md:h-48 flex-shrink-0">
                <img src="https://sdgs.un.org/sites/default/files/goals/E_SDG_Icons-04.jpg" alt="Icon SDG 4" class="w-full h-full object-contain">
            </div>
            <div class="text-center md:text-left mt-6 md:mt-0">
                <h1 class="text-4xl lg:text-5xl font-extrabold tracking-tight">SDG 4: Pendidikan Berkualitas</h1>
                <p class="mt-3 text-lg lg:text-xl font-medium opacity-90 max-w-2xl">Menjamin kualitas pendidikan yang inklusif dan merata serta mempromosikan kesempatan belajar sepanjang hayat untuk semua.</p>
            </div>
        </div>
    </header>

    <main>
        <section id="penjelasan-sdg" class="py-16 lg:py-24 bg-gray-50">
            <div class="container mx-auto px-6">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Tentang Tujuan Ini</h2>
                    <p class="mt-3 text-lg text-gray-600">Pendidikan adalah kunci untuk membuka potensi individu dan membangun masyarakat berkelanjutan.</p>
                    <div class="mt-4 inline-block h-1.5 w-24 bg-sdg-red-edu rounded-full"></div>
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">
                        <h3 class="font-bold text-xl text-gray-900 mb-4">Komitmen Global</h3>
                        <p class="text-gray-700 leading-relaxed">
                            SDG 4 bertujuan untuk memastikan bahwa **semua anak perempuan dan laki-laki menyelesaikan pendidikan dasar dan menengah yang gratis, setara, dan berkualitas**. Ini adalah fondasi untuk perbaikan kehidupan.
                        </p>
                    </div>
                    <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">
                         <h3 class="font-bold text-xl text-gray-900 mb-4">Target Utama</h3>
                        <p class="text-gray-700 leading-relaxed">
                           Memberikan akses setara ke pendidikan tinggi, vokasi, dan kejuruan yang terjangkau dan berkualitas, serta meningkatkan jumlah guru yang berkualitas secara substansial.
                        </p>
                    </div>
                    <div class="bg-red-50 border-l-4 border-sdg-red-edu p-8 rounded-xl shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">
                         <h3 class="font-bold text-xl text-gray-900 mb-4">Peran Kami di UNJ</h3>
                         <p class="font-semibold text-gray-800 leading-relaxed">
                            Sebagai Lembaga Pendidikan Tenaga Kependidikan (LPTK) terkemuka, misi utama kami adalah mencetak pendidik profesional, mengembangkan kurikulum inovatif, dan melakukan riset pendidikan terdepan.
                        </p>
                    </div>
                </div>
            </div>
        </section>
        
        <section id="target-sdg" class="py-16 lg:py-24 bg-white">
            <div class="container mx-auto px-6">
                 <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Target Global SDG 4</h2>
                    <p class="mt-3 text-lg text-gray-600">Indikator spesifik yang menjadi fokus bersama hingga tahun 2030.</p>
                    <div class="mt-4 inline-block h-1.5 w-24 bg-sdg-red-edu rounded-full"></div>
                </div>
                <div class="max-w-4xl mx-auto space-y-6">
                    <div class="flex items-start gap-5 bg-gray-50 p-6 rounded-xl shadow-md hover:shadow-xl hover:border-sdg-red-edu border-2 border-transparent transition-all duration-300">
                        <div class="flex-shrink-0 bg-sdg-red-edu text-white w-14 h-14 rounded-full flex items-center justify-center font-extrabold text-xl">4.1</div>
                        <div>
                            <h3 class="font-bold text-lg text-gray-900">Pendidikan Dasar dan Menengah Universal</h3>
                            <p class="text-gray-600 mt-1">Memastikan semua anak perempuan dan laki-laki menyelesaikan pendidikan dasar dan menengah yang gratis, setara, dan berkualitas.</p>
                        </div>
                    </div>
                     <div class="flex items-start gap-5 bg-gray-50 p-6 rounded-xl shadow-md hover:shadow-xl hover:border-sdg-red-edu border-2 border-transparent transition-all duration-300">
                        <div class="flex-shrink-0 bg-sdg-red-edu text-white w-14 h-14 rounded-full flex items-center justify-center font-extrabold text-xl">4.3</div>
                        <div>
                            <h3 class="font-bold text-lg text-gray-900">Akses Setara ke Pendidikan Tinggi dan Vokasi</h3>
                            <p class="text-gray-600 mt-1">Memastikan akses yang sama bagi semua perempuan dan laki-laki terhadap pendidikan teknis, kejuruan dan pendidikan tinggi yang terjangkau dan berkualitas, termasuk universitas.</p>
                        </div>
                    </div>
                     <div class="flex items-start gap-5 bg-gray-50 p-6 rounded-xl shadow-md hover:shadow-xl hover:border-sdg-red-edu border-2 border-transparent transition-all duration-300">
                        <div class="flex-shrink-0 bg-sdg-red-edu text-white w-14 h-14 rounded-full flex items-center justify-center font-extrabold text-xl">4.C</div>
                        <div>
                            <h3 class="font-bold text-lg text-gray-900">Meningkatkan Jumlah Guru Berkualitas</h3>
                            <p class="text-gray-600 mt-1">Secara substansial meningkatkan pasokan guru yang berkualitas, termasuk melalui kerja sama internasional untuk pelatihan guru di negara berkembang.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="berita-terkait" class="py-16 lg:py-24 bg-gray-50">
            <div class="container mx-auto px-6">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Aksi & Inovasi UNJ</h2>
                    <p class="mt-3 text-lg text-gray-600">Berita, kegiatan, dan program yang kami lakukan untuk mendukung SDG 4.</p>
                     <div class="mt-4 inline-block h-1.5 w-24 bg-sdg-red-edu rounded-full"></div>
                </div>
                
                <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">
                    <div class="lg:col-span-3 bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 flex flex-col">
                        <img src="https://images.unsplash.com/photo-1541339907198-e08756dedf3f?q=80&w=2070&auto=format&fit=crop" alt="Kegiatan Mengajar" class="w-full h-64 object-cover">
                        <div class="p-8 flex-grow flex flex-col">
                            <h3 class="font-bold text-2xl mb-3 text-gray-900">UNJ Kirim Ratusan Mahasiswa Program Kampus Mengajar ke Daerah 3T</h3>
                            <p class="text-gray-600 mb-6 flex-grow">Sebagai bagian dari komitmen tridarma perguruan tinggi, UNJ secara aktif berpartisipasi dalam program Kampus Mengajar, mengirimkan mahasiswa terbaiknya untuk membantu meningkatkan kualitas literasi dan numerasi di sekolah-sekolah di daerah terdepan, terluar, dan tertinggal.</p>
                            <a href="#" class="mt-auto self-start inline-block bg-sdg-red-edu text-white font-semibold px-6 py-3 rounded-lg hover:bg-sdg-red-edu-dark transition-colors duration-300">
                                Baca Selengkapnya <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                        </div>
                    </div>
                    <div class="lg:col-span-2 flex flex-col gap-8">
                        <div class="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 flex flex-col sm:flex-row lg:flex-col">
                            <img src="https://images.unsplash.com/photo-1580582932707-520aed937b7b?q=80&w=1932&auto=format&fit=crop" alt="Pelatihan Guru" class="w-full sm:w-1/3 lg:w-full h-48 sm:h-auto lg:h-40 object-cover">
                            <div class="p-6 flex-grow flex flex-col">
                                <h3 class="font-bold text-xl mb-2 text-gray-900">FIP UNJ Gelar Workshop Pengembangan Kurikulum Adaptif</h3>
                                <p class="text-gray-600 mb-4 text-sm flex-grow">Pelatihan bagi para guru untuk merancang kurikulum yang relevan dengan tantangan abad ke-21 dan kebutuhan siswa yang beragam.</p>
                                <a href="#" class="mt-auto self-start text-sdg-red-edu font-semibold hover:text-sdg-red-edu-dark transition-colors">
                                    Baca Selengkapnya <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        </div>
                        <div class="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 flex flex-col sm:flex-row lg:flex-col">
                            <img src="https://images.unsplash.com/photo-1524178232363-1fb2b075b655?q=80&w=2070&auto=format&fit=crop" alt="Pendidikan Inklusif" class="w-full sm:w-1/3 lg:w-full h-48 sm:h-auto lg:h-40 object-cover">
                            <div class="p-6 flex-grow flex flex-col">
                                <h3 class="font-bold text-xl mb-2 text-gray-900">UNJ Fasilitasi Beasiswa Bagi Mahasiswa Disabilitas</h3>
                                <p class="text-gray-600 mb-4 text-sm flex-grow">UNJ berkomitmen menciptakan lingkungan belajar yang inklusif dengan menyediakan beasiswa dan fasilitas pendukung bagi mahasiswa disabilitas.</p>
                                <a href="#" class="mt-auto self-start text-sdg-red-edu font-semibold hover:text-sdg-red-edu-dark transition-colors">
                                    Baca Selengkapnya <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <section id="publikasi-terkait" class="py-16 lg:py-24 bg-red-50">
            <div class="container mx-auto px-6">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Publikasi Terkait</h2>
                    <p class="mt-3 text-lg text-gray-600">Kajian dan penelitian dari civitas academica UNJ tentang inovasi pendidikan.</p>
                    <div class="mt-4 inline-block h-1.5 w-24 bg-sdg-red-edu rounded-full"></div>
                </div>
                <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-lg">
                    <ul class="divide-y divide-gray-200">
                        <li class="p-6">
                            <a href="#" class="flex items-center gap-5 group">
                                <i class="fas fa-file-alt text-3xl text-sdg-red-edu flex-shrink-0"></i>
                                <div class="flex-grow">
                                    <h3 class="font-semibold text-lg text-gray-900 group-hover:text-sdg-red-edu transition-colors">Model Pembelajaran Berbasis Proyek untuk Meningkatkan Keterampilan Berpikir Kritis Siswa</h3>
                                    <p class="text-sm text-gray-500 mt-1">Prof. Dr. A. Suparman, M.Pd. | Jurnal Inovasi Pendidikan Vol. 25, No. 1, 2024</p>
                                </div>
                                <i class="fas fa-download ml-auto text-xl text-gray-400 group-hover:text-sdg-red-edu transition-transform group-hover:scale-110"></i>
                            </a>
                        </li>
                         <li class="p-6">
                            <a href="#" class="flex items-center gap-5 group">
                                <i class="fas fa-file-alt text-3xl text-sdg-red-edu flex-shrink-0"></i>
                                <div class="flex-grow">
                                    <h3 class="font-semibold text-lg text-gray-900 group-hover:text-sdg-red-edu transition-colors">Tantangan dan Peluang Pendidikan Inklusif di Sekolah Dasar Negeri Jakarta</h3>
                                    <p class="text-sm text-gray-500 mt-1">Dr. Tita Rosita, M.Pd. | Prosiding Seminar Nasional Pendidikan Khusus 2023</p>
                                </div>
                                <i class="fas fa-download ml-auto text-xl text-gray-400 group-hover:text-sdg-red-edu transition-transform group-hover:scale-110"></i>
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