<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SDG 6: Air Bersih dan Sanitasi Layak - Universitas Negeri Jakarta</title>
    
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
              'sdg-blue': '#26BDE2',
              'sdg-blue-dark': '#1e9cb8',
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

    <header class="bg-sdg-blue text-white">
        <div class="container mx-auto px-6 pt-24 pb-20 flex flex-col md:flex-row items-center gap-8">
            <div class="bg-white p-4 rounded-xl shadow-2xl w-40 h-40 md:w-48 md:h-48 flex-shrink-0">
                <img src="https://sdgs.un.org/sites/default/files/goals/E_SDG_Icons-06.jpg" alt="Icon SDG 6" class="w-full h-full object-contain">
            </div>
            <div class="text-center md:text-left mt-6 md:mt-0">
                <h1 class="text-4xl lg:text-5xl font-extrabold tracking-tight">SDG 6: Air Bersih dan Sanitasi Layak</h1>
                <p class="mt-3 text-lg lg:text-xl font-medium opacity-90 max-w-2xl">Menjamin ketersediaan serta pengelolaan air bersih dan sanitasi yang berkelanjutan untuk semua.</p>
            </div>
        </div>
    </header>

    <main>
        <section id="penjelasan-sdg" class="py-16 lg:py-24 bg-gray-50">
            <div class="container mx-auto px-6">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Tentang Tujuan Ini</h2>
                    <p class="mt-3 text-lg text-gray-600">Air adalah sumber kehidupan, dan akses terhadap air bersih adalah hak asasi manusia.</p>
                    <div class="mt-4 inline-block h-1.5 w-24 bg-sdg-blue rounded-full"></div>
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">
                        <h3 class="font-bold text-xl text-gray-900 mb-4">Komitmen Global</h3>
                        <p class="text-gray-700 leading-relaxed">
                            SDG 6 berupaya untuk mencapai **akses universal dan merata terhadap air minum yang aman dan terjangkau**, serta akses terhadap sanitasi dan kebersihan yang memadai dan merata bagi semua.
                        </p>
                    </div>
                    <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">
                         <h3 class="font-bold text-xl text-gray-900 mb-4">Target Utama</h3>
                        <p class="text-gray-700 leading-relaxed">
                           Meningkatkan kualitas air dengan mengurangi polusi, meningkatkan efisiensi penggunaan air, dan melindungi serta memulihkan ekosistem terkait air, termasuk pegunungan, hutan, dan sungai.
                        </p>
                    </div>
                    <div class="bg-blue-50 border-l-4 border-sdg-blue p-8 rounded-xl shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">
                         <h3 class="font-bold text-xl text-gray-900 mb-4">Peran Kami di UNJ</h3>
                         <p class="font-semibold text-gray-800 leading-relaxed">
                            Kami berkontribusi melalui riset teknologi pengolahan air, studi kualitas air, dan program pengabdian masyarakat untuk membangun infrastruktur air bersih dan sanitasi di komunitas yang membutuhkan.
                        </p>
                    </div>
                </div>
            </div>
        </section>
        
        <section id="target-sdg" class="py-16 lg:py-24 bg-white">
            <div class="container mx-auto px-6">
                 <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Target Global SDG 6</h2>
                    <p class="mt-3 text-lg text-gray-600">Indikator spesifik yang menjadi fokus bersama hingga tahun 2030.</p>
                    <div class="mt-4 inline-block h-1.5 w-24 bg-sdg-blue rounded-full"></div>
                </div>
                <div class="max-w-4xl mx-auto space-y-6">
                    <div class="flex items-start gap-5 bg-gray-50 p-6 rounded-xl shadow-md hover:shadow-xl hover:border-sdg-blue border-2 border-transparent transition-all duration-300">
                        <div class="flex-shrink-0 bg-sdg-blue text-white w-14 h-14 rounded-full flex items-center justify-center font-extrabold text-xl">6.1</div>
                        <div>
                            <h3 class="font-bold text-lg text-gray-900">Akses Air Minum Universal</h3>
                            <p class="text-gray-600 mt-1">Mencapai akses universal dan merata terhadap air minum yang aman dan terjangkau bagi semua.</p>
                        </div>
                    </div>
                     <div class="flex items-start gap-5 bg-gray-50 p-6 rounded-xl shadow-md hover:shadow-xl hover:border-sdg-blue border-2 border-transparent transition-all duration-300">
                        <div class="flex-shrink-0 bg-sdg-blue text-white w-14 h-14 rounded-full flex items-center justify-center font-extrabold text-xl">6.2</div>
                        <div>
                            <h3 class="font-bold text-lg text-gray-900">Akses Sanitasi dan Kebersihan</h3>
                            <p class="text-gray-600 mt-1">Mencapai akses terhadap sanitasi dan kebersihan yang memadai dan merata bagi semua, dan menghentikan buang air besar di tempat terbuka.</p>
                        </div>
                    </div>
                     <div class="flex items-start gap-5 bg-gray-50 p-6 rounded-xl shadow-md hover:shadow-xl hover:border-sdg-blue border-2 border-transparent transition-all duration-300">
                        <div class="flex-shrink-0 bg-sdg-blue text-white w-14 h-14 rounded-full flex items-center justify-center font-extrabold text-xl">6.3</div>
                        <div>
                            <h3 class="font-bold text-lg text-gray-900">Meningkatkan Kualitas Air</h3>
                            <p class="text-gray-600 mt-1">Meningkatkan kualitas air dengan mengurangi polusi, menghilangkan pembuangan, dan meminimalkan pelepasan bahan kimia dan material berbahaya.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="berita-terkait" class="py-16 lg:py-24 bg-gray-50">
            <div class="container mx-auto px-6">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Aksi & Inovasi UNJ</h2>
                    <p class="mt-3 text-lg text-gray-600">Berita, kegiatan, dan program yang kami lakukan untuk mendukung SDG 6.</p>
                     <div class="mt-4 inline-block h-1.5 w-24 bg-sdg-blue rounded-full"></div>
                </div>
                
                <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">
                    <div class="lg:col-span-3 bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 flex flex-col">
                        <img src="https://images.unsplash.com/photo-1576053139221-88a2a95a8991?q=80&w=2070&auto=format&fit=crop" alt="Filter Air" class="w-full h-64 object-cover">
                        <div class="p-8 flex-grow flex flex-col">
                            <h3 class="font-bold text-2xl mb-3 text-gray-900">FT UNJ Kembangkan Teknologi Filtrasi Air Sederhana untuk Komunitas Pesisir</h3>
                            <p class="text-gray-600 mb-6 flex-grow">Tim peneliti dan mahasiswa dari Fakultas Teknik (FT) merancang dan mengimplementasikan sistem penyaringan air berbasis bahan lokal yang murah dan efektif untuk menyediakan air bersih bagi masyarakat di Marunda, Jakarta Utara.</p>
                            <a href="#" class="mt-auto self-start inline-block bg-sdg-blue text-white font-semibold px-6 py-3 rounded-lg hover:bg-sdg-blue-dark transition-colors duration-300">
                                Baca Selengkapnya <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                        </div>
                    </div>
                    <div class="lg:col-span-2 flex flex-col gap-8">
                        <div class="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 flex flex-col sm:flex-row lg:flex-col">
                            <img src="https://images.unsplash.com/photo-1628186981116-281896dd6297?q=80&w=1964&auto=format&fit=crop" alt="Kampanye Kebersihan" class="w-full sm:w-1/3 lg:w-full h-48 sm:h-auto lg:h-40 object-cover">
                            <div class="p-6 flex-grow flex flex-col">
                                <h3 class="font-bold text-xl mb-2 text-gray-900">Kampanye "Tangan Bersih, Generasi Sehat" oleh Mahasiswa UNJ</h3>
                                <p class="text-gray-600 mb-4 text-sm flex-grow">Mahasiswa KKN UNJ melakukan edukasi tentang pentingnya Cuci Tangan Pakai Sabun (CTPS) di puluhan sekolah dasar di sekitar Depok.</p>
                                <a href="#" class="mt-auto self-start text-sdg-blue font-semibold hover:text-sdg-blue-dark transition-colors">
                                    Baca Selengkapnya <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        </div>
                        <div class="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 flex flex-col sm:flex-row lg:flex-col">
                            <img src="https://images.unsplash.com/photo-1543086494-3cb439543328?q=80&w=2070&auto=format&fit=crop" alt="Penelitian Sungai" class="w-full sm:w-1/3 lg:w-full h-48 sm:h-auto lg:h-40 object-cover">
                            <div class="p-6 flex-grow flex flex-col">
                                <h3 class="font-bold text-xl mb-2 text-gray-900">Riset FMIPA UNJ: Pemetaan Sumber Polusi Mikroplastik di Sungai Ciliwung</h3>
                                <p class="text-gray-600 mb-4 text-sm flex-grow">Penelitian jangka panjang ini memberikan data krusial bagi pemerintah untuk menyusun kebijakan pengendalian polusi plastik.</p>
                                <a href="#" class="mt-auto self-start text-sdg-blue font-semibold hover:text-sdg-blue-dark transition-colors">
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
                    <p class="mt-3 text-lg text-gray-600">Kajian dan penelitian dari civitas academica UNJ tentang air dan sanitasi.</p>
                    <div class="mt-4 inline-block h-1.5 w-24 bg-sdg-blue rounded-full"></div>
                </div>
                <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-lg">
                    <ul class="divide-y divide-gray-200">
                        <li class="p-6">
                            <a href="#" class="flex items-center gap-5 group">
                                <i class="fas fa-file-alt text-3xl text-sdg-blue flex-shrink-0"></i>
                                <div class="flex-grow">
                                    <h3 class="font-semibold text-lg text-gray-900 group-hover:text-sdg-blue transition-colors">Pengembangan Membran Keramik dari Bahan Lokal untuk Pengolahan Air Limbah Industri Tahu</h3>
                                    <p class="text-sm text-gray-500 mt-1">Dr. Eng. Ahmad Zarkasih, M.T. | Jurnal Teknik Lingkungan Vol. 12, No. 1, 2024</p>
                                </div>
                                <i class="fas fa-download ml-auto text-xl text-gray-400 group-hover:text-sdg-blue transition-transform group-hover:scale-110"></i>
                            </a>
                        </li>
                        <li class="p-6">
                             <a href="#" class="flex items-center gap-5 group">
                                <i class="fas fa-file-alt text-3xl text-sdg-blue flex-shrink-0"></i>
                                <div class="flex-grow">
                                    <h3 class="font-semibold text-lg text-gray-900 group-hover:text-sdg-blue transition-colors">Evaluasi Program Sanitasi Total Berbasis Masyarakat (STBM) di Kabupaten Bogor</h3>
                                    <p class="text-sm text-gray-500 mt-1">Prof. Dr. Siti Nurjanah, M.Kes. | Jurnal Kesehatan Masyarakat Vol. 15, No. 2, 2023</p>
                                </div>
                                <i class="fas fa-download ml-auto text-xl text-gray-400 group-hover:text-sdg-blue transition-transform group-hover:scale-110"></i>
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