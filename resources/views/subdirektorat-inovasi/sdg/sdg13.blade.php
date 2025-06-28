<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SDG 13: Penanganan Perubahan Iklim - Universitas Negeri Jakarta</title>
    
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
              'sdg-climate-green': '#3F7E44',
              'sdg-climate-green-dark': '#2d5a30',
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

    <header class="bg-sdg-climate-green text-white">
        <div class="container mx-auto px-6 pt-24 pb-20 flex flex-col md:flex-row items-center gap-8">
            <div class="bg-white p-4 rounded-xl shadow-2xl w-40 h-40 md:w-48 md:h-48 flex-shrink-0">
                <img src="https://sdgs.un.org/sites/default/files/goals/E_SDG_Icons-13.jpg" alt="Icon SDG 13" class="w-full h-full object-contain">
            </div>
            <div class="text-center md:text-left mt-6 md:mt-0">
                <h1 class="text-4xl lg:text-5xl font-extrabold tracking-tight">SDG 13: Penanganan Perubahan Iklim</h1>
                <p class="mt-3 text-lg lg:text-xl font-medium opacity-90 max-w-2xl">Mengambil tindakan segera untuk memerangi perubahan iklim dan dampaknya.</p>
            </div>
        </div>
    </header>

    <main>
        <section id="penjelasan-sdg" class="py-16 lg:py-24 bg-gray-50">
            <div class="container mx-auto px-6">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Tentang Tujuan Ini</h2>
                    <p class="mt-3 text-lg text-gray-600">Perubahan iklim adalah tantangan global yang tidak mengenal batas negara dan memerlukan aksi kolektif.</p>
                    <div class="mt-4 inline-block h-1.5 w-24 bg-sdg-climate-green rounded-full"></div>
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">
                        <h3 class="font-bold text-xl text-gray-900 mb-4">Komitmen Global</h3>
                        <p class="text-gray-700 leading-relaxed">
                            SDG 13 menargetkan untuk **memperkuat ketahanan dan kapasitas adaptasi** terhadap bahaya terkait iklim dan bencana alam di semua negara. Ini adalah tentang membangun masa depan yang berketahanan iklim.
                        </p>
                    </div>
                    <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">
                         <h3 class="font-bold text-xl text-gray-900 mb-4">Target Utama</h3>
                        <p class="text-gray-700 leading-relaxed">
                           Mengintegrasikan tindakan perubahan iklim ke dalam kebijakan, strategi, dan perencanaan nasional, serta meningkatkan pendidikan, peningkatan kesadaran, dan kapasitas manusia serta kelembagaan mengenai mitigasi dan adaptasi perubahan iklim.
                        </p>
                    </div>
                    <div class="bg-green-50 border-l-4 border-sdg-climate-green p-8 rounded-xl shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">
                         <h3 class="font-bold text-xl text-gray-900 mb-4">Peran Kami di UNJ</h3>
                         <p class="font-semibold text-gray-800 leading-relaxed">
                            Kami berkontribusi melalui Pusat Studi Lingkungan dan Kependudukan, riset klimatologi, studi dampak perubahan iklim, serta program pendidikan lingkungan untuk meningkatkan kesadaran dan kapasitas adaptasi masyarakat.
                        </p>
                    </div>
                </div>
            </div>
        </section>
        
        <section id="target-sdg" class="py-16 lg:py-24 bg-white">
            <div class="container mx-auto px-6">
                 <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Target Global SDG 13</h2>
                    <p class="mt-3 text-lg text-gray-600">Indikator spesifik yang menjadi fokus bersama hingga tahun 2030.</p>
                    <div class="mt-4 inline-block h-1.5 w-24 bg-sdg-climate-green rounded-full"></div>
                </div>
                <div class="max-w-4xl mx-auto space-y-6">
                    <div class="flex items-start gap-5 bg-gray-50 p-6 rounded-xl shadow-md hover:shadow-xl hover:border-sdg-climate-green border-2 border-transparent transition-all duration-300">
                        <div class="flex-shrink-0 bg-sdg-climate-green text-white w-14 h-14 rounded-full flex items-center justify-center font-extrabold text-xl">13.1</div>
                        <div>
                            <h3 class="font-bold text-lg text-gray-900">Memperkuat Ketahanan dan Kapasitas Adaptasi</h3>
                            <p class="text-gray-600 mt-1">Memperkuat ketahanan dan kapasitas adaptasi terhadap bahaya terkait iklim dan bencana alam di semua negara.</p>
                        </div>
                    </div>
                     <div class="flex items-start gap-5 bg-gray-50 p-6 rounded-xl shadow-md hover:shadow-xl hover:border-sdg-climate-green border-2 border-transparent transition-all duration-300">
                        <div class="flex-shrink-0 bg-sdg-climate-green text-white w-14 h-14 rounded-full flex items-center justify-center font-extrabold text-xl">13.2</div>
                        <div>
                            <h3 class="font-bold text-lg text-gray-900">Integrasi Kebijakan Perubahan Iklim</h3>
                            <p class="text-gray-600 mt-1">Mengintegrasikan tindakan perubahan iklim ke dalam kebijakan, strategi, dan perencanaan nasional.</p>
                        </div>
                    </div>
                     <div class="flex items-start gap-5 bg-gray-50 p-6 rounded-xl shadow-md hover:shadow-xl hover:border-sdg-climate-green border-2 border-transparent transition-all duration-300">
                        <div class="flex-shrink-0 bg-sdg-climate-green text-white w-14 h-14 rounded-full flex items-center justify-center font-extrabold text-xl">13.3</div>
                        <div>
                            <h3 class="font-bold text-lg text-gray-900">Meningkatkan Pendidikan dan Kesadaran</h3>
                            <p class="text-gray-600 mt-1">Meningkatkan pendidikan, penyadaran, serta kapasitas manusia dan kelembagaan mengenai mitigasi, adaptasi, pengurangan dampak dan peringatan dini perubahan iklim.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="berita-terkait" class="py-16 lg:py-24 bg-gray-50">
            <div class="container mx-auto px-6">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Aksi & Inovasi UNJ</h2>
                    <p class="mt-3 text-lg text-gray-600">Berita, kegiatan, dan program yang kami lakukan untuk mendukung SDG 13.</p>
                     <div class="mt-4 inline-block h-1.5 w-24 bg-sdg-climate-green rounded-full"></div>
                </div>
                
                <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">
                    <div class="lg:col-span-3 bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 flex flex-col">
                        <img src="https://images.unsplash.com/photo-1611273635951-87a323a65213?q=80&w=1932&auto=format&fit=crop" alt="Peta Kerentanan" class="w-full h-64 object-cover">
                        <div class="p-8 flex-grow flex flex-col">
                            <h3 class="font-bold text-2xl mb-3 text-gray-900">Pusat Studi Lingkungan UNJ Rilis Peta Kerentanan Kenaikan Permukaan Laut di Pesisir Jakarta</h3>
                            <p class="text-gray-600 mb-6 flex-grow">Berdasarkan data multi-tahun, tim peneliti dari UNJ memodelkan dan memetakan area-area di pesisir Jakarta yang paling rentan terhadap dampak kenaikan permukaan laut. Hasil riset ini diserahkan kepada pemerintah sebagai dasar perencanaan adaptasi.</p>
                            <a href="#" class="mt-auto self-start inline-block bg-sdg-climate-green text-white font-semibold px-6 py-3 rounded-lg hover:bg-sdg-climate-green-dark transition-colors duration-300">
                                Baca Selengkapnya <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                        </div>
                    </div>
                    <div class="lg:col-span-2 flex flex-col gap-8">
                        <div class="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 flex flex-col sm:flex-row lg:flex-col">
                            <img src="https://images.unsplash.com/photo-1542601906-823816a75393?q=80&w=2070&auto=format&fit=crop" alt="Tanam Pohon" class="w-full sm:w-1/3 lg:w-full h-48 sm:h-auto lg:h-40 object-cover">
                            <div class="p-6 flex-grow flex flex-col">
                                <h3 class="font-bold text-xl mb-2 text-gray-900">Mahasiswa UNJ Gelar Aksi "Satu Pohon, Satu Harapan"</h3>
                                <p class="text-gray-600 mb-4 text-sm flex-grow">Bekerja sama dengan komunitas lokal, mahasiswa menanam ribuan pohon di area resapan air sebagai aksi nyata mitigasi perubahan iklim.</p>
                                <a href="#" class="mt-auto self-start text-sdg-climate-green font-semibold hover:text-sdg-climate-green-dark transition-colors">
                                    Baca Selengkapnya <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        </div>
                        <div class="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 flex flex-col sm:flex-row lg:flex-col">
                            <img src="https://images.unsplash.com/photo-1491841550275-5b462bf48569?q=80&w=2070&auto=format&fit=crop" alt="Edukasi Iklim" class="w-full sm:w-1/3 lg:w-full h-48 sm:h-auto lg:h-40 object-cover">
                            <div class="p-6 flex-grow flex flex-col">
                                <h3 class="font-bold text-xl mb-2 text-gray-900">UNJ Kembangkan Modul Pendidikan Perubahan Iklim untuk Sekolah</h3>
                                <p class="text-gray-600 mb-4 text-sm flex-grow">Fakultas Ilmu Pendidikan (FIP) menyusun modul ajar interaktif untuk membantu guru menjelaskan isu perubahan iklim kepada siswa.</p>
                                <a href="#" class="mt-auto self-start text-sdg-climate-green font-semibold hover:text-sdg-climate-green-dark transition-colors">
                                    Baca Selengkapnya <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <section id="publikasi-terkait" class="py-16 lg:py-24 bg-green-50">
            <div class="container mx-auto px-6">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Publikasi Terkait</h2>
                    <p class="mt-3 text-lg text-gray-600">Kajian dan penelitian dari civitas academica UNJ tentang perubahan iklim.</p>
                    <div class="mt-4 inline-block h-1.5 w-24 bg-sdg-climate-green rounded-full"></div>
                </div>
                <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-lg">
                    <ul class="divide-y divide-gray-200">
                        <li class="p-6">
                            <a href="#" class="flex items-center gap-5 group">
                                <i class="fas fa-file-alt text-3xl text-sdg-climate-green flex-shrink-0"></i>
                                <div class="flex-grow">
                                    <h3 class="font-semibold text-lg text-gray-900 group-hover:text-sdg-climate-green-dark transition-colors">Model Adaptasi Petani terhadap Pergeseran Pola Curah Hujan di Jawa Barat</h3>
                                    <p class="text-sm text-gray-500 mt-1">Dr. Fisika. Armel, M.Si. | Jurnal Sains Kebumian Vol. 8, No. 2, 2024</p>
                                </div>
                                <i class="fas fa-download ml-auto text-xl text-gray-400 group-hover:text-sdg-climate-green-dark transition-transform group-hover:scale-110"></i>
                            </a>
                        </li>
                        <li class="p-6">
                             <a href="#" class="flex items-center gap-5 group">
                                <i class="fas fa-file-alt text-3xl text-sdg-climate-green flex-shrink-0"></i>
                                <div class="flex-grow">
                                    <h3 class="font-semibold text-lg text-gray-900 group-hover:text-sdg-climate-green-dark transition-colors">Analisis Wacana Kebijakan Perubahan Iklim Indonesia dalam Komitmen Perjanjian Paris</h3>
                                    <p class="text-sm text-gray-500 mt-1">Prof. Dr. Ilmu Politik. Irawan, M.A. | Jurnal Hubungan Internasional Vol. 12, No. 1, 2023</p>
                                </div>
                                <i class="fas fa-download ml-auto text-xl text-gray-400 group-hover:text-sdg-climate-green-dark transition-transform group-hover:scale-110"></i>
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