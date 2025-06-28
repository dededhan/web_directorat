<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SDG 3: Kehidupan Sehat dan Sejahtera - Universitas Negeri Jakarta</title>
    
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
              'sdg-green': '#4C9F38',
              'sdg-green-dark': '#3b7e2b',
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

    <header class="bg-sdg-green text-white">
        <div class="container mx-auto px-6 pt-24 pb-20 flex flex-col md:flex-row items-center gap-8">
            <div class="bg-white p-4 rounded-xl shadow-2xl w-40 h-40 md:w-48 md:h-48 flex-shrink-0">
                <img src="https://sdgs.un.org/sites/default/files/goals/E_SDG_Icons-03.jpg" alt="Icon SDG 3" class="w-full h-full object-contain">
            </div>
            <div class="text-center md:text-left mt-6 md:mt-0">
                <h1 class="text-4xl lg:text-5xl font-extrabold tracking-tight">SDG 3: Kehidupan Sehat dan Sejahtera</h1>
                <p class="mt-3 text-lg lg:text-xl font-medium opacity-90 max-w-2xl">Memastikan kehidupan yang sehat dan mendukung kesejahteraan bagi semua pada semua usia.</p>
            </div>
        </div>
    </header>

    <main>
        <section id="penjelasan-sdg" class="py-16 lg:py-24 bg-gray-50">
            <div class="container mx-auto px-6">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Tentang Tujuan Ini</h2>
                    <p class="mt-3 text-lg text-gray-600">Memahami pilar kesehatan sebagai fondasi masyarakat yang produktif dan sejahtera.</p>
                    <div class="mt-4 inline-block h-1.5 w-24 bg-sdg-green rounded-full"></div>
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">
                        <h3 class="font-bold text-xl text-gray-900 mb-4">Komitmen Global</h3>
                        <p class="text-gray-700 leading-relaxed">
                            SDG 3 berfokus pada **peningkatan harapan hidup dan pengurangan angka kematian ibu dan anak**. Ini juga mencakup upaya memerangi penyakit menular seperti AIDS, tuberkulosis, dan malaria.
                        </p>
                    </div>
                    <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">
                         <h3 class="font-bold text-xl text-gray-900 mb-4">Target Utama</h3>
                        <p class="text-gray-700 leading-relaxed">
                           Mencapai cakupan kesehatan universal, memastikan akses terhadap layanan kesehatan esensial yang berkualitas, dan akses terhadap obat-obatan dan vaksin yang aman, efektif, dan terjangkau.
                        </p>
                    </div>
                    <div class="bg-green-50 border-l-4 border-sdg-green p-8 rounded-xl shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">
                         <h3 class="font-bold text-xl text-gray-900 mb-4">Peran Kami di UNJ</h3>
                         <p class="font-semibold text-gray-800 leading-relaxed">
                            Kami berkontribusi melalui Fakultas Ilmu Olahraga (FIO) dalam promosi gaya hidup sehat, riset kesehatan masyarakat, dan layanan psikologi untuk mendukung kesehatan mental.
                        </p>
                    </div>
                </div>
            </div>
        </section>
        
        <section id="target-sdg" class="py-16 lg:py-24 bg-white">
            <div class="container mx-auto px-6">
                 <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Target Global SDG 3</h2>
                    <p class="mt-3 text-lg text-gray-600">Indikator spesifik yang menjadi fokus bersama hingga tahun 2030.</p>
                    <div class="mt-4 inline-block h-1.5 w-24 bg-sdg-green rounded-full"></div>
                </div>
                <div class="max-w-4xl mx-auto space-y-6">
                    <div class="flex items-start gap-5 bg-gray-50 p-6 rounded-xl shadow-md hover:shadow-xl hover:border-sdg-green border-2 border-transparent transition-all duration-300">
                        <div class="flex-shrink-0 bg-sdg-green text-white w-14 h-14 rounded-full flex items-center justify-center font-extrabold text-xl">3.1</div>
                        <div>
                            <h3 class="font-bold text-lg text-gray-900">Mengurangi Angka Kematian Ibu</h3>
                            <p class="text-gray-600 mt-1">Mengurangi rasio angka kematian ibu hingga di bawah 70 per 100.000 kelahiran hidup.</p>
                        </div>
                    </div>
                     <div class="flex items-start gap-5 bg-gray-50 p-6 rounded-xl shadow-md hover:shadow-xl hover:border-sdg-green border-2 border-transparent transition-all duration-300">
                        <div class="flex-shrink-0 bg-sdg-green text-white w-14 h-14 rounded-full flex items-center justify-center font-extrabold text-xl">3.4</div>
                        <div>
                            <h3 class="font-bold text-lg text-gray-900">Mengurangi Kematian Akibat Penyakit Tidak Menular</h3>
                            <p class="text-gray-600 mt-1">Mengurangi sepertiga kematian prematur akibat penyakit tidak menular melalui pencegahan dan pengobatan, serta meningkatkan kesehatan mental dan kesejahteraan.</p>
                        </div>
                    </div>
                     <div class="flex items-start gap-5 bg-gray-50 p-6 rounded-xl shadow-md hover:shadow-xl hover:border-sdg-green border-2 border-transparent transition-all duration-300">
                        <div class="flex-shrink-0 bg-sdg-green text-white w-14 h-14 rounded-full flex items-center justify-center font-extrabold text-xl">3.8</div>
                        <div>
                            <h3 class="font-bold text-lg text-gray-900">Cakupan Kesehatan Universal</h3>
                            <p class="text-gray-600 mt-1">Mencapai cakupan kesehatan universal, termasuk proteksi risiko finansial, akses terhadap layanan kesehatan dasar yang berkualitas, dan akses terhadap obat-obatan esensial.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="berita-terkait" class="py-16 lg:py-24 bg-gray-50">
            <div class="container mx-auto px-6">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Aksi & Inovasi UNJ</h2>
                    <p class="mt-3 text-lg text-gray-600">Berita, kegiatan, dan program yang kami lakukan untuk mendukung SDG 3.</p>
                     <div class="mt-4 inline-block h-1.5 w-24 bg-sdg-green rounded-full"></div>
                </div>
                
                <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">
                    <div class="lg:col-span-3 bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 flex flex-col">
                        <img src="https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?q=80&w=2070&auto=format&fit=crop" alt="Kegiatan Olahraga" class="w-full h-64 object-cover">
                        <div class="p-8 flex-grow flex flex-col">
                            <h3 class="font-bold text-2xl mb-3 text-gray-900">FIO UNJ Gelar "Gerak Sehat Jakarta" untuk Promosikan Gaya Hidup Aktif</h3>
                            <p class="text-gray-600 mb-6 flex-grow">Fakultas Ilmu Olahraga UNJ menginisiasi kampanye besar yang melibatkan ribuan warga dalam kegiatan senam bersama, jalan sehat, dan seminar kesehatan untuk memerangi penyakit tidak menular dan meningkatkan kebugaran masyarakat.</p>
                            <a href="#" class="mt-auto self-start inline-block bg-sdg-green text-white font-semibold px-6 py-3 rounded-lg hover:bg-sdg-green-dark transition-colors duration-300">
                                Baca Selengkapnya <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                        </div>
                    </div>
                    <div class="lg:col-span-2 flex flex-col gap-8">
                        <div class="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 flex flex-col sm:flex-row lg:flex-col">
                            <img src="https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?q=80&w=2070&auto=format&fit=crop" alt="Riset Kesehatan" class="w-full sm:w-1/3 lg:w-full h-48 sm:h-auto lg:h-40 object-cover">
                            <div class="p-6 flex-grow flex flex-col">
                                <h3 class="font-bold text-xl mb-2 text-gray-900">Riset UNJ: Hubungan Polusi Udara dan Penyakit Pernapasan</h3>
                                <p class="text-gray-600 mb-4 text-sm flex-grow">Tim peneliti dari FMIPA UNJ mempublikasikan studi mengenai korelasi antara tingkat polusi udara di Jakarta dengan peningkatan kasus ISPA.</p>
                                <a href="#" class="mt-auto self-start text-sdg-green font-semibold hover:text-sdg-green-dark transition-colors">
                                    Baca Selengkapnya <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        </div>
                        <div class="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 flex flex-col sm:flex-row lg:flex-col">
                            <img src="https://plus.unsplash.com/premium_photo-1661281397737-926d71b9f712?q=80&w=2070&auto=format&fit=crop" alt="Kesehatan Mental" class="w-full sm:w-1/3 lg:w-full h-48 sm:h-auto lg:h-40 object-cover">
                            <div class="p-6 flex-grow flex flex-col">
                                <h3 class="font-bold text-xl mb-2 text-gray-900">UNJ Luncurkan Layanan Konseling Psikologis Gratis</h3>
                                <p class="text-gray-600 mb-4 text-sm flex-grow">Fakultas Pendidikan Psikologi membuka pusat layanan konseling yang dapat diakses gratis oleh mahasiswa dan masyarakat umum.</p>
                                <a href="#" class="mt-auto self-start text-sdg-green font-semibold hover:text-sdg-green-dark transition-colors">
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
                    <p class="mt-3 text-lg text-gray-600">Kajian dan penelitian dari civitas academica UNJ tentang kesehatan dan kesejahteraan.</p>
                    <div class="mt-4 inline-block h-1.5 w-24 bg-sdg-green rounded-full"></div>
                </div>
                <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-lg">
                    <ul class="divide-y divide-gray-200">
                        <li class="p-6">
                            <a href="#" class="flex items-center gap-5 group">
                                <i class="fas fa-file-alt text-3xl text-sdg-green flex-shrink-0"></i>
                                <div class="flex-grow">
                                    <h3 class="font-semibold text-lg text-gray-900 group-hover:text-sdg-green transition-colors">Pola Aktivitas Fisik dan Pengaruhnya terhadap Kesehatan Kognitif pada Lansia</h3>
                                    <p class="text-sm text-gray-500 mt-1">Prof. Dr. Firmansyah Dlis, M.Pd. | Jurnal Keolahragaan Vol. 10, No. 1, 2024</p>
                                </div>
                                <i class="fas fa-download ml-auto text-xl text-gray-400 group-hover:text-sdg-green transition-transform group-hover:scale-110"></i>
                            </a>
                        </li>
                        <li class="p-6">
                             <a href="#" class="flex items-center gap-5 group">
                                <i class="fas fa-file-alt text-3xl text-sdg-green flex-shrink-0"></i>
                                <div class="flex-grow">
                                    <h3 class="font-semibold text-lg text-gray-900 group-hover:text-sdg-green transition-colors">Stres Akademik dan Kesejahteraan Mental Mahasiswa di Era Digital</h3>
                                    <p class="text-sm text-gray-500 mt-1">Dr. Rina Astuti, M.Psi. | Jurnal Psikologi Pendidikan Vol. 12, No. 2, 2023</p>
                                </div>
                                <i class="fas fa-download ml-auto text-xl text-gray-400 group-hover:text-sdg-green transition-transform group-hover:scale-110"></i>
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