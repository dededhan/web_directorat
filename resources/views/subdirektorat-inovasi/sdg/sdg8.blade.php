<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SDG 8: Pekerjaan Layak dan Pertumbuhan Ekonomi - Universitas Negeri Jakarta</title>
    
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
              'sdg-maroon': '#A21942',
              'sdg-maroon-dark': '#841435',
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

    <header class="bg-sdg-maroon text-white">
        <div class="container mx-auto px-6 pt-24 pb-20 flex flex-col md:flex-row items-center gap-8">
            <div class="bg-white p-4 rounded-xl shadow-2xl w-40 h-40 md:w-48 md:h-48 flex-shrink-0">
                <img src="https://sdgs.un.org/sites/default/files/goals/E_SDG_Icons-08.jpg" alt="Icon SDG 8" class="w-full h-full object-contain">
            </div>
            <div class="text-center md:text-left mt-6 md:mt-0">
                <h1 class="text-4xl lg:text-5xl font-extrabold tracking-tight">SDG 8: Pekerjaan Layak dan Pertumbuhan Ekonomi</h1>
                <p class="mt-3 text-lg lg:text-xl font-medium opacity-90 max-w-2xl">Mempromosikan pertumbuhan ekonomi inklusif dan berkelanjutan, kesempatan kerja penuh dan produktif, serta pekerjaan yang layak untuk semua.</p>
            </div>
        </div>
    </header>

    <main>
        <section id="penjelasan-sdg" class="py-16 lg:py-24 bg-gray-50">
            <div class="container mx-auto px-6">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Tentang Tujuan Ini</h2>
                    <p class="mt-3 text-lg text-gray-600">Pertumbuhan ekonomi harus bersifat inklusif untuk menyediakan pekerjaan yang layak dan meningkatkan standar hidup.</p>
                    <div class="mt-4 inline-block h-1.5 w-24 bg-sdg-maroon rounded-full"></div>
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">
                        <h3 class="font-bold text-xl text-gray-900 mb-4">Komitmen Global</h3>
                        <p class="text-gray-700 leading-relaxed">
                            SDG 8 bertujuan untuk mencapai **tingkat produktivitas ekonomi yang lebih tinggi** melalui diversifikasi, peningkatan teknologi dan inovasi, termasuk melalui fokus pada sektor bernilai tambah tinggi dan padat karya.
                        </p>
                    </div>
                    <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">
                         <h3 class="font-bold text-xl text-gray-900 mb-4">Target Utama</h3>
                        <p class="text-gray-700 leading-relaxed">
                           Mencapai pekerjaan penuh dan produktif serta pekerjaan yang layak untuk semua perempuan dan laki-laki, termasuk untuk kaum muda dan penyandang disabilitas, dan upah yang sama untuk pekerjaan yang sama nilainya.
                        </p>
                    </div>
                    <div class="bg-red-50 border-l-4 border-sdg-maroon p-8 rounded-xl shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">
                         <h3 class="font-bold text-xl text-gray-900 mb-4">Peran Kami di UNJ</h3>
                         <p class="font-semibold text-gray-800 leading-relaxed">
                            Kami berkontribusi melalui inkubator bisnis, program kewirausahaan, studi pasar tenaga kerja, dan pengembangan kurikulum yang relevan dengan kebutuhan industri untuk mencetak lulusan yang siap kerja dan mampu menciptakan lapangan kerja.
                        </p>
                    </div>
                </div>
            </div>
        </section>
        
        <section id="target-sdg" class="py-16 lg:py-24 bg-white">
            <div class="container mx-auto px-6">
                 <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Target Global SDG 8</h2>
                    <p class="mt-3 text-lg text-gray-600">Indikator spesifik yang menjadi fokus bersama hingga tahun 2030.</p>
                    <div class="mt-4 inline-block h-1.5 w-24 bg-sdg-maroon rounded-full"></div>
                </div>
                <div class="max-w-4xl mx-auto space-y-6">
                    <div class="flex items-start gap-5 bg-gray-50 p-6 rounded-xl shadow-md hover:shadow-xl hover:border-sdg-maroon border-2 border-transparent transition-all duration-300">
                        <div class="flex-shrink-0 bg-sdg-maroon text-white w-14 h-14 rounded-full flex items-center justify-center font-extrabold text-xl">8.2</div>
                        <div>
                            <h3 class="font-bold text-lg text-gray-900">Meningkatkan Produktivitas Ekonomi</h3>
                            <p class="text-gray-600 mt-1">Mencapai tingkat produktivitas ekonomi yang lebih tinggi melalui diversifikasi, peningkatan teknologi dan inovasi.</p>
                        </div>
                    </div>
                     <div class="flex items-start gap-5 bg-gray-50 p-6 rounded-xl shadow-md hover:shadow-xl hover:border-sdg-maroon border-2 border-transparent transition-all duration-300">
                        <div class="flex-shrink-0 bg-sdg-maroon text-white w-14 h-14 rounded-full flex items-center justify-center font-extrabold text-xl">8.5</div>
                        <div>
                            <h3 class="font-bold text-lg text-gray-900">Pekerjaan Penuh dan Layak untuk Semua</h3>
                            <p class="text-gray-600 mt-1">Mencapai pekerjaan penuh dan produktif dan pekerjaan yang layak untuk semua perempuan dan laki-laki, termasuk untuk orang muda dan penyandang disabilitas.</p>
                        </div>
                    </div>
                     <div class="flex items-start gap-5 bg-gray-50 p-6 rounded-xl shadow-md hover:shadow-xl hover:border-sdg-maroon border-2 border-transparent transition-all duration-300">
                        <div class="flex-shrink-0 bg-sdg-maroon text-white w-14 h-14 rounded-full flex items-center justify-center font-extrabold text-xl">8.7</div>
                        <div>
                            <h3 class="font-bold text-lg text-gray-900">Menghapus Kerja Paksa dan Pekerja Anak</h3>
                            <p class="text-gray-600 mt-1">Mengambil langkah-langkah segera dan efektif untuk memberantas kerja paksa, mengakhiri perbudakan modern dan perdagangan manusia, dan mengakhiri pekerja anak dalam segala bentuknya.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="berita-terkait" class="py-16 lg:py-24 bg-gray-50">
            <div class="container mx-auto px-6">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Aksi & Inovasi UNJ</h2>
                    <p class="mt-3 text-lg text-gray-600">Berita, kegiatan, dan program yang kami lakukan untuk mendukung SDG 8.</p>
                     <div class="mt-4 inline-block h-1.5 w-24 bg-sdg-maroon rounded-full"></div>
                </div>
                
                <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">
                    <div class="lg:col-span-3 bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 flex flex-col">
                        <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?q=80&w=2070&auto=format&fit=crop" alt="Workshop Kewirausahaan" class="w-full h-64 object-cover">
                        <div class="p-8 flex-grow flex flex-col">
                            <h3 class="font-bold text-2xl mb-3 text-gray-900">FEB UNJ Luncurkan Inkubator Bisnis "UNJPreneur" untuk Cetak Wirausahawan Muda</h3>
                            <p class="text-gray-600 mb-6 flex-grow">Fakultas Ekonomi dan Bisnis (FEB) UNJ meresmikan pusat inkubasi bisnis yang memberikan pendampingan, akses permodalan, dan jejaring bagi mahasiswa dan alumni yang ingin memulai usaha. Program ini bertujuan untuk meningkatkan jumlah wirausahawan baru yang inovatif.</p>
                            <a href="#" class="mt-auto self-start inline-block bg-sdg-maroon text-white font-semibold px-6 py-3 rounded-lg hover:bg-sdg-maroon-dark transition-colors duration-300">
                                Baca Selengkapnya <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                        </div>
                    </div>
                    <div class="lg:col-span-2 flex flex-col gap-8">
                        <div class="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 flex flex-col sm:flex-row lg:flex-col">
                            <img src="https://images.unsplash.com/photo-1542744173-8e7e53415bb0?q=80&w=2070&auto=format&fit=crop" alt="Pelatihan UMKM" class="w-full sm:w-1/3 lg:w-full h-48 sm:h-auto lg:h-40 object-cover">
                            <div class="p-6 flex-grow flex flex-col">
                                <h3 class="font-bold text-xl mb-2 text-gray-900">UNJ Adakan Pelatihan Pemasaran Digital untuk UMKM Binaan</h3>
                                <p class="text-gray-600 mb-4 text-sm flex-grow">Program pengabdian masyarakat memberikan pelatihan gratis kepada puluhan UMKM di sekitar kampus untuk meningkatkan daya saing mereka di era digital.</p>
                                <a href="#" class="mt-auto self-start text-sdg-maroon font-semibold hover:text-sdg-maroon-dark transition-colors">
                                    Baca Selengkapnya <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        </div>
                        <div class="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 flex flex-col sm:flex-row lg:flex-col">
                            <img src="https://images.unsplash.com/photo-1517048676732-d65bc937f952?q=80&w=2070&auto=format&fit=crop" alt="Job Fair" class="w-full sm:w-1/3 lg:w-full h-48 sm:h-auto lg:h-40 object-cover">
                            <div class="p-6 flex-grow flex flex-col">
                                <h3 class="font-bold text-xl mb-2 text-gray-900">Pusat Karir UNJ Sukses Gelar Job Fair Tahunan</h3>
                                <p class="text-gray-600 mb-4 text-sm flex-grow">Menjembatani lulusan dengan dunia industri, UNJ Job Fair menghadirkan puluhan perusahaan ternama dan ribuan lowongan pekerjaan.</p>
                                <a href="#" class="mt-auto self-start text-sdg-maroon font-semibold hover:text-sdg-maroon-dark transition-colors">
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
                    <p class="mt-3 text-lg text-gray-600">Kajian dan penelitian dari civitas academica UNJ tentang ekonomi dan pekerjaan.</p>
                    <div class="mt-4 inline-block h-1.5 w-24 bg-sdg-maroon rounded-full"></div>
                </div>
                <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-lg">
                    <ul class="divide-y divide-gray-200">
                        <li class="p-6">
                            <a href="#" class="flex items-center gap-5 group">
                                <i class="fas fa-file-alt text-3xl text-sdg-maroon flex-shrink-0"></i>
                                <div class="flex-grow">
                                    <h3 class="font-semibold text-lg text-gray-900 group-hover:text-sdg-maroon transition-colors">Peran Ekonomi Kreatif dalam Penyerapan Tenaga Kerja di DKI Jakarta</h3>
                                    <p class="text-sm text-gray-500 mt-1">Dr. Dewi Sartika, S.E., M.Si. | Jurnal Ekonomi Pembangunan Vol. 23, No. 1, 2024</p>
                                </div>
                                <i class="fas fa-download ml-auto text-xl text-gray-400 group-hover:text-sdg-maroon transition-transform group-hover:scale-110"></i>
                            </a>
                        </li>
                        <li class="p-6">
                             <a href="#" class="flex items-center gap-5 group">
                                <i class="fas fa-file-alt text-3xl text-sdg-maroon flex-shrink-0"></i>
                                <div class="flex-grow">
                                    <h3 class="font-semibold text-lg text-gray-900 group-hover:text-sdg-maroon transition-colors">Studi Kesiapan Kerja Lulusan Pendidikan Vokasi: Analisis Link and Match dengan Industri</h3>
                                    <p class="text-sm text-gray-500 mt-1">Prof. Dr. Agus Wibowo, M.T. | Jurnal Pendidikan Teknologi dan Kejuruan Vol. 20, No. 2, 2023</p>
                                </div>
                                <i class="fas fa-download ml-auto text-xl text-gray-400 group-hover:text-sdg-maroon transition-transform group-hover:scale-110"></i>
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