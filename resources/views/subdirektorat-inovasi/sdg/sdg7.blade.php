<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SDG 7: Energi Bersih dan Terjangkau - Universitas Negeri Jakarta</title>
    
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
              'sdg-yellow': '#FCC30B',
              'sdg-yellow-dark': '#dca900',
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

    <header class="bg-sdg-yellow text-gray-900">
        <div class="container mx-auto px-6 pt-24 pb-20 flex flex-col md:flex-row items-center gap-8">
            <div class="bg-white p-4 rounded-xl shadow-2xl w-40 h-40 md:w-48 md:h-48 flex-shrink-0">
                <img src="https://sdgs.un.org/sites/default/files/goals/E_SDG_Icons-07.jpg" alt="Icon SDG 7" class="w-full h-full object-contain">
            </div>
            <div class="text-center md:text-left mt-6 md:mt-0">
                <h1 class="text-4xl lg:text-5xl font-extrabold tracking-tight">SDG 7: Energi Bersih dan Terjangkau</h1>
                <p class="mt-3 text-lg lg:text-xl font-medium opacity-90 max-w-2xl">Menjamin akses energi yang terjangkau, andal, berkelanjutan, dan modern untuk semua.</p>
            </div>
        </div>
    </header>

    <main>
        <section id="penjelasan-sdg" class="py-16 lg:py-24 bg-gray-50">
            <div class="container mx-auto px-6">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Tentang Tujuan Ini</h2>
                    <p class="mt-3 text-lg text-gray-600">Energi adalah pusat dari hampir setiap tantangan dan peluang besar yang dihadapi dunia saat ini.</p>
                    <div class="mt-4 inline-block h-1.5 w-24 bg-sdg-yellow rounded-full"></div>
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">
                        <h3 class="font-bold text-xl text-gray-900 mb-4">Komitmen Global</h3>
                        <p class="text-gray-700 leading-relaxed">
                            SDG 7 bertujuan untuk **menjamin akses universal ke layanan energi modern**, meningkatkan efisiensi energi secara global, dan meningkatkan pangsa energi terbarukan secara substansial dalam bauran energi global.
                        </p>
                    </div>
                    <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">
                         <h3 class="font-bold text-xl text-gray-900 mb-4">Target Utama</h3>
                        <p class="text-gray-700 leading-relaxed">
                           Menggandakan tingkat peningkatan efisiensi energi global, serta meningkatkan kerja sama internasional untuk memfasilitasi akses ke penelitian dan teknologi energi bersih.
                        </p>
                    </div>
                    <div class="bg-yellow-50 border-l-4 border-sdg-yellow p-8 rounded-xl shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">
                         <h3 class="font-bold text-xl text-gray-900 mb-4">Peran Kami di UNJ</h3>
                         <p class="font-semibold text-gray-800 leading-relaxed">
                            Kami berkontribusi melalui riset dan pengembangan teknologi energi terbarukan seperti sel surya, biomassa, dan efisiensi energi, serta melakukan studi kebijakan untuk mendukung transisi energi nasional.
                        </p>
                    </div>
                </div>
            </div>
        </section>
        
        <section id="target-sdg" class="py-16 lg:py-24 bg-white">
            <div class="container mx-auto px-6">
                 <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Target Global SDG 7</h2>
                    <p class="mt-3 text-lg text-gray-600">Indikator spesifik yang menjadi fokus bersama hingga tahun 2030.</p>
                    <div class="mt-4 inline-block h-1.5 w-24 bg-sdg-yellow rounded-full"></div>
                </div>
                <div class="max-w-4xl mx-auto space-y-6">
                    <div class="flex items-start gap-5 bg-gray-50 p-6 rounded-xl shadow-md hover:shadow-xl hover:border-sdg-yellow border-2 border-transparent transition-all duration-300">
                        <div class="flex-shrink-0 bg-sdg-yellow text-gray-800 w-14 h-14 rounded-full flex items-center justify-center font-extrabold text-xl">7.1</div>
                        <div>
                            <h3 class="font-bold text-lg text-gray-900">Akses Energi Universal</h3>
                            <p class="text-gray-600 mt-1">Menjamin akses universal terhadap layanan energi yang terjangkau, andal, dan modern.</p>
                        </div>
                    </div>
                     <div class="flex items-start gap-5 bg-gray-50 p-6 rounded-xl shadow-md hover:shadow-xl hover:border-sdg-yellow border-2 border-transparent transition-all duration-300">
                        <div class="flex-shrink-0 bg-sdg-yellow text-gray-800 w-14 h-14 rounded-full flex items-center justify-center font-extrabold text-xl">7.2</div>
                        <div>
                            <h3 class="font-bold text-lg text-gray-900">Meningkatkan Porsi Energi Terbarukan</h3>
                            <p class="text-gray-600 mt-1">Meningkatkan secara substansial pangsa energi terbarukan dalam bauran energi global.</p>
                        </div>
                    </div>
                     <div class="flex items-start gap-5 bg-gray-50 p-6 rounded-xl shadow-md hover:shadow-xl hover:border-sdg-yellow border-2 border-transparent transition-all duration-300">
                        <div class="flex-shrink-0 bg-sdg-yellow text-gray-800 w-14 h-14 rounded-full flex items-center justify-center font-extrabold text-xl">7.3</div>
                        <div>
                            <h3 class="font-bold text-lg text-gray-900">Meningkatkan Efisiensi Energi</h3>
                            <p class="text-gray-600 mt-1">Menggandakan tingkat peningkatan efisiensi energi di tingkat global.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="berita-terkait" class="py-16 lg:py-24 bg-gray-50">
            <div class="container mx-auto px-6">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Aksi & Inovasi UNJ</h2>
                    <p class="mt-3 text-lg text-gray-600">Berita, kegiatan, dan program yang kami lakukan untuk mendukung SDG 7.</p>
                     <div class="mt-4 inline-block h-1.5 w-24 bg-sdg-yellow rounded-full"></div>
                </div>
                
                <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">
                    <div class="lg:col-span-3 bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 flex flex-col">
                        <img src="https://images.unsplash.com/photo-1508554792037-77f6544b6248?q=80&w=2070&auto=format&fit=crop" alt="Panel Surya" class="w-full h-64 object-cover">
                        <div class="p-8 flex-grow flex flex-col">
                            <h3 class="font-bold text-2xl mb-3 text-gray-900">UNJ Jadi Percontohan Kampus Hijau dengan Pemasangan Panel Surya Skala Besar</h3>
                            <p class="text-gray-600 mb-6 flex-grow">Bekerja sama dengan BUMN sektor energi, UNJ menginstalasi sistem Pembangkit Listrik Tenaga Surya (PLTS) Atap di beberapa gedung utama kampus. Langkah ini bertujuan untuk mengurangi jejak karbon dan biaya listrik, sekaligus menjadi laboratorium hidup bagi mahasiswa.</p>
                            <a href="#" class="mt-auto self-start inline-block bg-sdg-yellow text-gray-900 font-semibold px-6 py-3 rounded-lg hover:bg-sdg-yellow-dark transition-colors duration-300">
                                Baca Selengkapnya <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                        </div>
                    </div>
                    <div class="lg:col-span-2 flex flex-col gap-8">
                        <div class="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 flex flex-col sm:flex-row lg:flex-col">
                            <img src="https://images.unsplash.com/photo-1621237042598-7517a945037d?q=80&w=2070&auto=format&fit=crop" alt="Riset Energi" class="w-full sm:w-1/3 lg:w-full h-48 sm:h-auto lg:h-40 object-cover">
                            <div class="p-6 flex-grow flex flex-col">
                                <h3 class="font-bold text-xl mb-2 text-gray-900">Riset FT UNJ: Pemanfaatan Limbah Organik Pasar Menjadi Biogas</h3>
                                <p class="text-gray-600 mb-4 text-sm flex-grow">Tim peneliti mengembangkan digester biogas skala kecil untuk mengolah sampah organik dari pasar menjadi energi untuk memasak bagi pedagang.</p>
                                <a href="#" class="mt-auto self-start text-sdg-yellow font-bold hover:text-sdg-yellow-dark transition-colors">
                                    Baca Selengkapnya <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        </div>
                        <div class="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 flex flex-col sm:flex-row lg:flex-col">
                            <img src="https://images.unsplash.com/photo-1542332213-9b5a5a3236a1?q=80&w=1920&auto=format&fit=crop" alt="Hemat Energi" class="w-full sm:w-1/3 lg:w-full h-48 sm:h-auto lg:h-40 object-cover">
                            <div class="p-6 flex-grow flex flex-col">
                                <h3 class="font-bold text-xl mb-2 text-gray-900">UNJ Gelar Lomba Inovasi Efisiensi Energi untuk Mahasiswa</h3>
                                <p class="text-gray-600 mb-4 text-sm flex-grow">Kompetisi tahunan ini menantang mahasiswa untuk menciptakan alat atau sistem yang dapat menghemat penggunaan energi di rumah tangga.</p>
                                <a href="#" class="mt-auto self-start text-sdg-yellow font-bold hover:text-sdg-yellow-dark transition-colors">
                                    Baca Selengkapnya <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <section id="publikasi-terkait" class="py-16 lg:py-24 bg-yellow-50">
            <div class="container mx-auto px-6">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Publikasi Terkait</h2>
                    <p class="mt-3 text-lg text-gray-600">Kajian dan penelitian dari civitas academica UNJ tentang energi bersih.</p>
                    <div class="mt-4 inline-block h-1.5 w-24 bg-sdg-yellow rounded-full"></div>
                </div>
                <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-lg">
                    <ul class="divide-y divide-gray-200">
                        <li class="p-6">
                            <a href="#" class="flex items-center gap-5 group">
                                <i class="fas fa-file-alt text-3xl text-sdg-yellow flex-shrink-0"></i>
                                <div class="flex-grow">
                                    <h3 class="font-semibold text-lg text-gray-900 group-hover:text-sdg-yellow-dark transition-colors">Analisis Kinerja Sel Surya Perovskite dengan Material Lokal sebagai Dye Sensitizer</h3>
                                    <p class="text-sm text-gray-500 mt-1">Dr. Budi Mulyanti, M.Si. | Jurnal Material dan Energi Indonesia Vol. 14, No. 2, 2024</p>
                                </div>
                                <i class="fas fa-download ml-auto text-xl text-gray-400 group-hover:text-sdg-yellow-dark transition-transform group-hover:scale-110"></i>
                            </a>
                        </li>
                        <li class="p-6">
                             <a href="#" class="flex items-center gap-5 group">
                                <i class="fas fa-file-alt text-3xl text-sdg-yellow flex-shrink-0"></i>
                                <div class="flex-grow">
                                    <h3 class="font-semibold text-lg text-gray-900 group-hover:text-sdg-yellow-dark transition-colors">Studi Kelayakan Implementasi Smart Grid di Lingkungan Kampus Universitas Negeri Jakarta</h3>
                                    <p class="text-sm text-gray-500 mt-1">Prof. Dr. Ir. Fachruddin, M.T. | Prosiding Seminar Nasional Teknik Elektro 2023</p>
                                </div>
                                <i class="fas fa-download ml-auto text-xl text-gray-400 group-hover:text-sdg-yellow-dark transition-transform group-hover:scale-110"></i>
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