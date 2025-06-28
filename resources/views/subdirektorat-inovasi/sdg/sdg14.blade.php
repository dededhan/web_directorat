<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SDG 14: Ekosistem Lautan - Universitas Negeri Jakarta</title>
    
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
              'sdg-ocean-blue': '#0A97D9',
              'sdg-ocean-blue-dark': '#0879b0',
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

    <header class="bg-sdg-ocean-blue text-white">
        <div class="container mx-auto px-6 pt-24 pb-20 flex flex-col md:flex-row items-center gap-8">
            <div class="bg-white p-4 rounded-xl shadow-2xl w-40 h-40 md:w-48 md:h-48 flex-shrink-0">
                <img src="https://sdgs.un.org/sites/default/files/goals/E_SDG_Icons-14.jpg" alt="Icon SDG 14" class="w-full h-full object-contain">
            </div>
            <div class="text-center md:text-left mt-6 md:mt-0">
                <h1 class="text-4xl lg:text-5xl font-extrabold tracking-tight">SDG 14: Ekosistem Lautan</h1>
                <p class="mt-3 text-lg lg:text-xl font-medium opacity-90 max-w-2xl">Melestarikan dan memanfaatkan secara berkelanjutan samudra, laut, dan sumber daya kelautan untuk pembangunan berkelanjutan.</p>
            </div>
        </div>
    </header>

    <main>
        <section id="penjelasan-sdg" class="py-16 lg:py-24 bg-gray-50">
            <div class="container mx-auto px-6">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Tentang Tujuan Ini</h2>
                    <p class="mt-3 text-lg text-gray-600">Lautan mengatur sistem global yang membuat Bumi layak huni bagi umat manusia. Kesehatan laut sangat penting bagi kesehatan planet.</p>
                    <div class="mt-4 inline-block h-1.5 w-24 bg-sdg-ocean-blue rounded-full"></div>
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">
                        <h3 class="font-bold text-xl text-gray-900 mb-4">Komitmen Global</h3>
                        <p class="text-gray-700 leading-relaxed">
                            SDG 14 berkomitmen untuk **mencegah dan secara signifikan mengurangi semua jenis polusi laut**, khususnya dari aktivitas berbasis darat, termasuk sampah laut dan polusi nutrien.
                        </p>
                    </div>
                    <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">
                         <h3 class="font-bold text-xl text-gray-900 mb-4">Target Utama</h3>
                        <p class="text-gray-700 leading-relaxed">
                           Mengelola dan melindungi ekosistem laut dan pesisir secara berkelanjutan, mengatasi dampak pengasaman laut, serta secara efektif meregulasi penangkapan ikan dan mengakhiri penangkapan ikan berlebihan (overfishing).
                        </p>
                    </div>
                    <div class="bg-blue-50 border-l-4 border-sdg-ocean-blue p-8 rounded-xl shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">
                         <h3 class="font-bold text-xl text-gray-900 mb-4">Peran Kami di UNJ</h3>
                         <p class="font-semibold text-gray-800 leading-relaxed">
                            Kami berkontribusi melalui riset biologi dan kimia kelautan, studi dampak polusi plastik, dan program konservasi ekosistem pesisir seperti restorasi mangrove dan terumbu karang bekerja sama dengan komunitas lokal.
                        </p>
                    </div>
                </div>
            </div>
        </section>
        
        <section id="target-sdg" class="py-16 lg:py-24 bg-white">
            <div class="container mx-auto px-6">
                 <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Target Global SDG 14</h2>
                    <p class="mt-3 text-lg text-gray-600">Indikator spesifik yang menjadi fokus bersama hingga tahun 2030.</p>
                    <div class="mt-4 inline-block h-1.5 w-24 bg-sdg-ocean-blue rounded-full"></div>
                </div>
                <div class="max-w-4xl mx-auto space-y-6">
                    <div class="flex items-start gap-5 bg-gray-50 p-6 rounded-xl shadow-md hover:shadow-xl hover:border-sdg-ocean-blue border-2 border-transparent transition-all duration-300">
                        <div class="flex-shrink-0 bg-sdg-ocean-blue text-white w-14 h-14 rounded-full flex items-center justify-center font-extrabold text-xl">14.1</div>
                        <div>
                            <h3 class="font-bold text-lg text-gray-900">Mengurangi Polusi Laut</h3>
                            <p class="text-gray-600 mt-1">Mencegah dan secara signifikan mengurangi semua jenis polusi laut, khususnya dari kegiatan berbasis darat, termasuk sampah laut dan polusi nutrien.</p>
                        </div>
                    </div>
                     <div class="flex items-start gap-5 bg-gray-50 p-6 rounded-xl shadow-md hover:shadow-xl hover:border-sdg-ocean-blue border-2 border-transparent transition-all duration-300">
                        <div class="flex-shrink-0 bg-sdg-ocean-blue text-white w-14 h-14 rounded-full flex items-center justify-center font-extrabold text-xl">14.2</div>
                        <div>
                            <h3 class="font-bold text-lg text-gray-900">Melindungi Ekosistem Laut dan Pesisir</h3>
                            <p class="text-gray-600 mt-1">Mengelola dan melindungi ekosistem laut dan pesisir secara berkelanjutan untuk menghindari dampak buruk yang signifikan, termasuk dengan memperkuat ketahanannya.</p>
                        </div>
                    </div>
                     <div class="flex items-start gap-5 bg-gray-50 p-6 rounded-xl shadow-md hover:shadow-xl hover:border-sdg-ocean-blue border-2 border-transparent transition-all duration-300">
                        <div class="flex-shrink-0 bg-sdg-ocean-blue text-white w-14 h-14 rounded-full flex items-center justify-center font-extrabold text-xl">14.4</div>
                        <div>
                            <h3 class="font-bold text-lg text-gray-900">Mengatur Penangkapan Ikan Berkelanjutan</h3>
                            <p class="text-gray-600 mt-1">Secara efektif mengatur pemanenan dan menghentikan penangkapan ikan yang berlebihan, ilegal, tidak dilaporkan dan tidak diatur (IUU Fishing).</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="berita-terkait" class="py-16 lg:py-24 bg-gray-50">
            <div class="container mx-auto px-6">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Aksi & Inovasi UNJ</h2>
                    <p class="mt-3 text-lg text-gray-600">Berita, kegiatan, dan program yang kami lakukan untuk mendukung SDG 14.</p>
                     <div class="mt-4 inline-block h-1.5 w-24 bg-sdg-ocean-blue rounded-full"></div>
                </div>
                
                <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">
                    <div class="lg:col-span-3 bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 flex flex-col">
                        <img src="https://images.unsplash.com/photo-1582202242940-27a363b7b51e?q=80&w=2070&auto=format&fit=crop" alt="Konservasi Mangrove" class="w-full h-64 object-cover">
                        <div class="p-8 flex-grow flex flex-col">
                            <h3 class="font-bold text-2xl mb-3 text-gray-900">Mahasiswa Biologi UNJ dan Komunitas Lokal Tanam Ribuan Mangrove di Pesisir Muara Gembong</h3>
                            <p class="text-gray-600 mb-6 flex-grow">Sebagai bagian dari program pengabdian masyarakat, tim dari UNJ berkolaborasi dengan kelompok pemuda dan nelayan lokal untuk merehabilitasi ekosistem mangrove yang rusak akibat abrasi. Kegiatan ini bertujuan untuk melindungi garis pantai dan mengembalikan habitat biota laut.</p>
                            <a href="#" class="mt-auto self-start inline-block bg-sdg-ocean-blue text-white font-semibold px-6 py-3 rounded-lg hover:bg-sdg-ocean-blue-dark transition-colors duration-300">
                                Baca Selengkapnya <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                        </div>
                    </div>
                    <div class="lg:col-span-2 flex flex-col gap-8">
                        <div class="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 flex flex-col sm:flex-row lg:flex-col">
                            <img src="https://images.unsplash.com/photo-1597931333425-11b6a2431713?q=80&w=2070&auto=format&fit=crop" alt="Sampah Plastik" class="w-full sm:w-1/3 lg:w-full h-48 sm:h-auto lg:h-40 object-cover">
                            <div class="p-6 flex-grow flex flex-col">
                                <h3 class="font-bold text-xl mb-2 text-gray-900">Riset Kimia UNJ: Deteksi Mikroplastik pada Ikan Konsumsi</h3>
                                <p class="text-gray-600 mb-4 text-sm flex-grow">Penelitian yang dipublikasikan di jurnal internasional ini mengungkap tingkat kontaminasi mikroplastik pada ikan yang dijual di pasar-pasar Jakarta.</p>
                                <a href="#" class="mt-auto self-start text-sdg-ocean-blue font-semibold hover:text-sdg-ocean-blue-dark transition-colors">
                                    Baca Selengkapnya <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        </div>
                        <div class="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 flex flex-col sm:flex-row lg:flex-col">
                            <img src="https://images.unsplash.com/photo-1564993356612-9da288b53580?q=80&w=2070&auto=format&fit=crop" alt="Terumbu Karang" class="w-full sm:w-1/3 lg:w-full h-48 sm:h-auto lg:h-40 object-cover">
                            <div class="p-6 flex-grow flex flex-col">
                                <h3 class="font-bold text-xl mb-2 text-gray-900">UNJ Adakan Pelatihan Transplantasi Terumbu Karang</h3>
                                <p class="text-gray-600 mb-4 text-sm flex-grow">Bekerja sama dengan Balai Taman Nasional Kepulauan Seribu, UNJ melatih pemandu wisata selam menjadi kader konservasi terumbu karang.</p>
                                <a href="#" class="mt-auto self-start text-sdg-ocean-blue font-semibold hover:text-sdg-ocean-blue-dark transition-colors">
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
                    <p class="mt-3 text-lg text-gray-600">Kajian dan penelitian dari civitas academica UNJ tentang ekosistem lautan.</p>
                    <div class="mt-4 inline-block h-1.5 w-24 bg-sdg-ocean-blue rounded-full"></div>
                </div>
                <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-lg">
                    <ul class="divide-y divide-gray-200">
                        <li class="p-6">
                            <a href="#" class="flex items-center gap-5 group">
                                <i class="fas fa-file-alt text-3xl text-sdg-ocean-blue flex-shrink-0"></i>
                                <div class="flex-grow">
                                    <h3 class="font-semibold text-lg text-gray-900 group-hover:text-sdg-ocean-blue-dark transition-colors">Karakterisasi dan Kuantifikasi Sampah Laut di Estuari Jakarta: Sumber dan Jalur Transportasi</h3>
                                    <p class="text-sm text-gray-500 mt-1">Dr. Biologi. Rina Wulandari, M.Si. | Jurnal Ilmu Kelautan dan Perikanan Vol. 25, No. 1, 2024</p>
                                </div>
                                <i class="fas fa-download ml-auto text-xl text-gray-400 group-hover:text-sdg-ocean-blue-dark transition-transform group-hover:scale-110"></i>
                            </a>
                        </li>
                        <li class="p-6">
                             <a href="#" class="flex items-center gap-5 group">
                                <i class="fas fa-file-alt text-3xl text-sdg-ocean-blue flex-shrink-0"></i>
                                <div class="flex-grow">
                                    <h3 class="font-semibold text-lg text-gray-900 group-hover:text-sdg-ocean-blue-dark transition-colors">Studi Dampak Pengasaman Laut terhadap Pertumbuhan Karang Acropora di Kepulauan Seribu</h3>
                                    <p class="text-sm text-gray-500 mt-1">Prof. Dr. Kimia. Haryanto, M.Sc. | Oseanologi dan Limnologi di Indonesia Vol. 49, No. 2, 2023</p>
                                </div>
                                <i class="fas fa-download ml-auto text-xl text-gray-400 group-hover:text-sdg-ocean-blue-dark transition-transform group-hover:scale-110"></i>
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