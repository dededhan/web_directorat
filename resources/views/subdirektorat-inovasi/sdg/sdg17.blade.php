<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SDG 17: Kemitraan untuk Mencapai Tujuan - Universitas Negeri Jakarta</title>
    
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
              'sdg-partner-blue': '#19486A',
              'sdg-partner-blue-dark': '#11324a',
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

    <header class="bg-sdg-partner-blue text-white">
        <div class="container mx-auto px-6 pt-24 pb-20 flex flex-col md:flex-row items-center gap-8">
            <div class="bg-white p-4 rounded-xl shadow-2xl w-40 h-40 md:w-48 md:h-48 flex-shrink-0">
                <img src="https://sdgs.un.org/sites/default/files/goals/E_SDG_Icons-17.jpg" alt="Icon SDG 17" class="w-full h-full object-contain">
            </div>
            <div class="text-center md:text-left mt-6 md:mt-0">
                <h1 class="text-4xl lg:text-5xl font-extrabold tracking-tight">SDG 17: Kemitraan untuk Mencapai Tujuan</h1>
                <p class="mt-3 text-lg lg:text-xl font-medium opacity-90 max-w-2xl">Memperkuat sarana pelaksanaan dan merevitalisasi kemitraan global untuk pembangunan berkelanjutan.</p>
            </div>
        </div>
    </header>

    <main>
        <section id="penjelasan-sdg" class="py-16 lg:py-24 bg-gray-50">
            <div class="container mx-auto px-6">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Tentang Tujuan Ini</h2>
                    <p class="mt-3 text-lg text-gray-600">Pencapaian SDGs yang ambisius membutuhkan kemitraan yang kuat antara pemerintah, sektor swasta, dan masyarakat sipil.</p>
                    <div class="mt-4 inline-block h-1.5 w-24 bg-sdg-partner-blue rounded-full"></div>
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">
                        <h3 class="font-bold text-xl text-gray-900 mb-4">Komitmen Global</h3>
                        <p class="text-gray-700 leading-relaxed">
                            SDG 17 menyerukan **kemitraan global yang direvitalisasi** berdasarkan semangat solidaritas yang kuat, berfokus terutama pada kebutuhan kelompok yang paling miskin dan paling rentan.
                        </p>
                    </div>
                    <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">
                         <h3 class="font-bold text-xl text-gray-900 mb-4">Target Utama</h3>
                        <p class="text-gray-700 leading-relaxed">
                           Meningkatkan kerja sama Utara-Selatan dan Selatan-Selatan, mempromosikan sistem perdagangan multilateral yang universal, dan mendorong kemitraan multi-pemangku kepentingan yang efektif.
                        </p>
                    </div>
                    <div class="bg-blue-50 border-l-4 border-sdg-partner-blue p-8 rounded-xl shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">
                         <h3 class="font-bold text-xl text-gray-900 mb-4">Peran Kami di UNJ</h3>
                         <p class="font-semibold text-gray-800 leading-relaxed">
                            Sebagai institusi akademik, kami berperan aktif sebagai hub pengetahuan dan inovasi, menjalin kemitraan strategis dengan pemerintah, industri, komunitas, dan universitas lain di tingkat nasional maupun internasional untuk mengakselerasi pencapaian semua tujuan SDGs.
                        </p>
                    </div>
                </div>
            </div>
        </section>
        
        <section id="target-sdg" class="py-16 lg:py-24 bg-white">
            <div class="container mx-auto px-6">
                 <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Target Global SDG 17</h2>
                    <p class="mt-3 text-lg text-gray-600">Indikator spesifik yang menjadi fokus bersama hingga tahun 2030.</p>
                    <div class="mt-4 inline-block h-1.5 w-24 bg-sdg-partner-blue rounded-full"></div>
                </div>
                <div class="max-w-4xl mx-auto space-y-6">
                    <div class="flex items-start gap-5 bg-gray-50 p-6 rounded-xl shadow-md hover:shadow-xl hover:border-sdg-partner-blue border-2 border-transparent transition-all duration-300">
                        <div class="flex-shrink-0 bg-sdg-partner-blue text-white w-14 h-14 rounded-full flex items-center justify-center font-extrabold text-xl">17.6</div>
                        <div>
                            <h3 class="font-bold text-lg text-gray-900">Kerja Sama Sains, Teknologi, dan Inovasi</h3>
                            <p class="text-gray-600 mt-1">Meningkatkan kerja sama Utara-Selatan, Selatan-Selatan, dan regional segitiga dan internasional mengenai dan akses terhadap sains, teknologi dan inovasi.</p>
                        </div>
                    </div>
                     <div class="flex items-start gap-5 bg-gray-50 p-6 rounded-xl shadow-md hover:shadow-xl hover:border-sdg-partner-blue border-2 border-transparent transition-all duration-300">
                        <div class="flex-shrink-0 bg-sdg-partner-blue text-white w-14 h-14 rounded-full flex items-center justify-center font-extrabold text-xl">17.16</div>
                        <div>
                            <h3 class="font-bold text-lg text-gray-900">Tingkatkan Kemitraan Global</h3>
                            <p class="text-gray-600 mt-1">Meningkatkan kemitraan global untuk pembangunan berkelanjutan, yang dilengkapi oleh kemitraan multi-pemangku kepentingan yang memobilisasi dan berbagi pengetahuan, keahlian, teknologi, dan sumber daya keuangan.</p>
                        </div>
                    </div>
                     <div class="flex items-start gap-5 bg-gray-50 p-6 rounded-xl shadow-md hover:shadow-xl hover:border-sdg-partner-blue border-2 border-transparent transition-all duration-300">
                        <div class="flex-shrink-0 bg-sdg-partner-blue text-white w-14 h-14 rounded-full flex items-center justify-center font-extrabold text-xl">17.17</div>
                        <div>
                            <h3 class="font-bold text-lg text-gray-900">Dorong Kemitraan yang Efektif</h3>
                            <p class="text-gray-600 mt-1">Mendorong dan mempromosikan kemitraan publik, publik-swasta, dan masyarakat sipil yang efektif, yang dibangun dari pengalaman dan strategi sumber daya kemitraan.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="berita-terkait" class="py-16 lg:py-24 bg-gray-50">
            <div class="container mx-auto px-6">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Aksi & Inovasi UNJ</h2>
                    <p class="mt-3 text-lg text-gray-600">Berita, kegiatan, dan program yang kami lakukan untuk mendukung SDG 17.</p>
                     <div class="mt-4 inline-block h-1.5 w-24 bg-sdg-partner-blue rounded-full"></div>
                </div>
                
                <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">
                    <div class="lg:col-span-3 bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 flex flex-col">
                        <img src="https://images.unsplash.com/photo-1543269865-cbf427effbad?q=80&w=2070&auto=format&fit=crop" alt="Forum Internasional" class="w-full h-64 object-cover">
                        <div class="p-8 flex-grow flex flex-col">
                            <h3 class="font-bold text-2xl mb-3 text-gray-900">UNJ Gelar Forum Multi-Pihak, Satukan Pemerintah, Swasta, dan Komunitas untuk Aksi SDGs</h3>
                            <p class="text-gray-600 mb-6 flex-grow">Sebagai wujud nyata kemitraan, UNJ menjadi tuan rumah forum tahunan yang mempertemukan berbagai pemangku kepentingan untuk berdiskusi, berbagi praktik baik, dan merancang proyek kolaboratif guna mempercepat pencapaian Tujuan Pembangunan Berkelanjutan di Indonesia.</p>
                            <a href="#" class="mt-auto self-start inline-block bg-sdg-partner-blue text-white font-semibold px-6 py-3 rounded-lg hover:bg-sdg-partner-blue-dark transition-colors duration-300">
                                Baca Selengkapnya <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                        </div>
                    </div>
                    <div class="lg:col-span-2 flex flex-col gap-8">
                        <div class="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 flex flex-col sm:flex-row lg:flex-col">
                            <img src="https://images.unsplash.com/photo-1521791136064-7986c2920216?q=80&w=2070&auto=format&fit=crop" alt="Kerja Sama Internasional" class="w-full sm:w-1/3 lg:w-full h-48 sm:h-auto lg:h-40 object-cover">
                            <div class="p-6 flex-grow flex flex-col">
                                <h3 class="font-bold text-xl mb-2 text-gray-900">UNJ Jalin Kemitraan Riset dengan Universitas di ASEAN</h3>
                                <p class="text-gray-600 mb-4 text-sm flex-grow">UNJ menandatangani MoU dengan beberapa universitas terkemuka di Asia Tenggara untuk melakukan riset bersama tentang isu-isu pembangunan berkelanjutan lintas negara.</p>
                                <a href="#" class="mt-auto self-start text-sdg-partner-blue font-semibold hover:text-sdg-partner-blue-dark transition-colors">
                                    Baca Selengkapnya <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        </div>
                        <div class="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 flex flex-col sm:flex-row lg:flex-col">
                            <img src="https://images.unsplash.com/photo-1581092921449-41b93f2c3516?q=80&w=2070&auto=format&fit=crop" alt="Kemitraan Industri" class="w-full sm:w-1/3 lg:w-full h-48 sm:h-auto lg:h-40 object-cover">
                            <div class="p-6 flex-grow flex flex-col">
                                <h3 class="font-bold text-xl mb-2 text-gray-900">Kolaborasi UNJ dan Sektor Swasta untuk Program Magang SDGs</h3>
                                <p class="text-gray-600 mb-4 text-sm flex-grow">Program magang baru ini menempatkan mahasiswa di perusahaan-perusahaan yang memiliki komitmen kuat pada praktik bisnis berkelanjutan.</p>
                                <a href="#" class="mt-auto self-start text-sdg-partner-blue font-semibold hover:text-sdg-partner-blue-dark transition-colors">
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
                    <p class="mt-3 text-lg text-gray-600">Kajian dan penelitian dari civitas academica UNJ tentang kemitraan pembangunan.</p>
                    <div class="mt-4 inline-block h-1.5 w-24 bg-sdg-partner-blue rounded-full"></div>
                </div>
                <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-lg">
                    <ul class="divide-y divide-gray-200">
                        <li class="p-6">
                            <a href="#" class="flex items-center gap-5 group">
                                <i class="fas fa-file-alt text-3xl text-sdg-partner-blue flex-shrink-0"></i>
                                <div class="flex-grow">
                                    <h3 class="font-semibold text-lg text-gray-900 group-hover:text-sdg-partner-blue-dark transition-colors">Model Kemitraan Pentahelix (Pemerintah, Akademisi, Bisnis, Komunitas, Media) dalam Akselerasi SDGs di Tingkat Daerah</h3>
                                    <p class="text-sm text-gray-500 mt-1">Dr. Kebijakan Publik. Andrian, M.A. | Jurnal Tata Kelola & Pembangunan Vol. 16, No. 1, 2024</p>
                                </div>
                                <i class="fas fa-download ml-auto text-xl text-gray-400 group-hover:text-sdg-partner-blue-dark transition-transform group-hover:scale-110"></i>
                            </a>
                        </li>
                        <li class="p-6">
                             <a href="#" class="flex items-center gap-5 group">
                                <i class="fas fa-file-alt text-3xl text-sdg-partner-blue flex-shrink-0"></i>
                                <div class="flex-grow">
                                    <h3 class="font-semibold text-lg text-gray-900 group-hover:text-sdg-partner-blue-dark transition-colors">Peran Perguruan Tinggi sebagai Agen Pengetahuan dalam Kemitraan Pembangunan Berkelanjutan</h3>
                                    <p class="text-sm text-gray-500 mt-1">Prof. Dr. Ir. Komarudin, M.Si. | Prosiding Konferensi Internasional Pembangunan Berkelanjutan 2023</p>
                                </div>
                                <i class="fas fa-download ml-auto text-xl text-gray-400 group-hover:text-sdg-partner-blue-dark transition-transform group-hover:scale-110"></i>
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