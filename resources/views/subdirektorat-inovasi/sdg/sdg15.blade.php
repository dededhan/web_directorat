<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SDG 15: Ekosistem Daratan - Universitas Negeri Jakarta</title>
    
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
              'sdg-land-green': '#56C02B',
              'sdg-land-green-dark': '#449922',
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

    <header class="bg-sdg-land-green text-white">
        <div class="container mx-auto px-6 pt-24 pb-20 flex flex-col md:flex-row items-center gap-8">
            <div class="bg-white p-4 rounded-xl shadow-2xl w-40 h-40 md:w-48 md:h-48 flex-shrink-0">
                <img src="https://sdgs.un.org/sites/default/files/goals/E_SDG_Icons-15.jpg" alt="Icon SDG 15" class="w-full h-full object-contain">
            </div>
            <div class="text-center md:text-left mt-6 md:mt-0">
                <h1 class="text-4xl lg:text-5xl font-extrabold tracking-tight">SDG 15: Ekosistem Daratan</h1>
                <p class="mt-3 text-lg lg:text-xl font-medium opacity-90 max-w-2xl">Melindungi, memulihkan, dan mendorong pemanfaatan berkelanjutan ekosistem darat, serta menghentikan hilangnya keanekaragaman hayati.</p>
            </div>
        </div>
    </header>

    <main>
        <section id="penjelasan-sdg" class="py-16 lg:py-24 bg-gray-50">
            <div class="container mx-auto px-6">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Tentang Tujuan Ini</h2>
                    <p class="mt-3 text-lg text-gray-600">Hutan adalah paru-paru planet kita, menyediakan oksigen, dan merupakan rumah bagi jutaan spesies.</p>
                    <div class="mt-4 inline-block h-1.5 w-24 bg-sdg-land-green rounded-full"></div>
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">
                        <h3 class="font-bold text-xl text-gray-900 mb-4">Komitmen Global</h3>
                        <p class="text-gray-700 leading-relaxed">
                            SDG 15 berkomitmen untuk **memastikan konservasi, restorasi, dan pemanfaatan berkelanjutan ekosistem darat dan air tawar**, sejalan dengan kewajiban berdasarkan perjanjian internasional.
                        </p>
                    </div>
                    <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">
                         <h3 class="font-bold text-xl text-gray-900 mb-4">Target Utama</h3>
                        <p class="text-gray-700 leading-relaxed">
                           Mempromosikan pengelolaan semua jenis hutan secara berkelanjutan, menghentikan deforestasi, memulihkan hutan yang terdegradasi, serta menghentikan hilangnya keanekaragaman hayati dan melindungi spesies yang terancam punah.
                        </p>
                    </div>
                    <div class="bg-green-50 border-l-4 border-sdg-land-green p-8 rounded-xl shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">
                         <h3 class="font-bold text-xl text-gray-900 mb-4">Peran Kami di UNJ</h3>
                         <p class="font-semibold text-gray-800 leading-relaxed">
                            Kami berkontribusi melalui riset biologi dan geografi tentang konservasi keanekaragaman hayati, program reboisasi, dan pendidikan lingkungan untuk meningkatkan kesadaran tentang pentingnya menjaga ekosistem darat.
                        </p>
                    </div>
                </div>
            </div>
        </section>
        
        <section id="target-sdg" class="py-16 lg:py-24 bg-white">
            <div class="container mx-auto px-6">
                 <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Target Global SDG 15</h2>
                    <p class="mt-3 text-lg text-gray-600">Indikator spesifik yang menjadi fokus bersama hingga tahun 2030.</p>
                    <div class="mt-4 inline-block h-1.5 w-24 bg-sdg-land-green rounded-full"></div>
                </div>
                <div class="max-w-4xl mx-auto space-y-6">
                    <div class="flex items-start gap-5 bg-gray-50 p-6 rounded-xl shadow-md hover:shadow-xl hover:border-sdg-land-green border-2 border-transparent transition-all duration-300">
                        <div class="flex-shrink-0 bg-sdg-land-green text-white w-14 h-14 rounded-full flex items-center justify-center font-extrabold text-xl">15.1</div>
                        <div>
                            <h3 class="font-bold text-lg text-gray-900">Konservasi dan Restorasi Ekosistem Darat</h3>
                            <p class="text-gray-600 mt-1">Memastikan konservasi, restorasi dan pemanfaatan berkelanjutan ekosistem darat dan air tawar pedalaman serta jasa lingkungannya.</p>
                        </div>
                    </div>
                     <div class="flex items-start gap-5 bg-gray-50 p-6 rounded-xl shadow-md hover:shadow-xl hover:border-sdg-land-green border-2 border-transparent transition-all duration-300">
                        <div class="flex-shrink-0 bg-sdg-land-green text-white w-14 h-14 rounded-full flex items-center justify-center font-extrabold text-xl">15.2</div>
                        <div>
                            <h3 class="font-bold text-lg text-gray-900">Menghentikan Deforestasi</h3>
                            <p class="text-gray-600 mt-1">Mempromosikan pelaksanaan pengelolaan semua jenis hutan secara berkelanjutan, menghentikan deforestasi, merestorasi hutan yang terdegradasi, dan meningkatkan aforestasi dan reboisasi secara substansial.</p>
                        </div>
                    </div>
                     <div class="flex items-start gap-5 bg-gray-50 p-6 rounded-xl shadow-md hover:shadow-xl hover:border-sdg-land-green border-2 border-transparent transition-all duration-300">
                        <div class="flex-shrink-0 bg-sdg-land-green text-white w-14 h-14 rounded-full flex items-center justify-center font-extrabold text-xl">15.5</div>
                        <div>
                            <h3 class="font-bold text-lg text-gray-900">Menghentikan Kehilangan Keanekaragaman Hayati</h3>
                            <p class="text-gray-600 mt-1">Mengambil tindakan yang mendesak dan signifikan untuk mengurangi degradasi habitat alami, menghentikan hilangnya keanekaragaman hayati dan melindungi serta mencegah kepunahan spesies yang terancam.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="berita-terkait" class="py-16 lg:py-24 bg-gray-50">
            <div class="container mx-auto px-6">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Aksi & Inovasi UNJ</h2>
                    <p class="mt-3 text-lg text-gray-600">Berita, kegiatan, dan program yang kami lakukan untuk mendukung SDG 15.</p>
                     <div class="mt-4 inline-block h-1.5 w-24 bg-sdg-land-green rounded-full"></div>
                </div>
                
                <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">
                    <div class="lg:col-span-3 bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 flex flex-col">
                        <img src="https://images.unsplash.com/photo-1441974231531-c6227db76b6e?q=80&w=2071&auto=format&fit=crop" alt="Hutan Kampus" class="w-full h-64 object-cover">
                        <div class="p-8 flex-grow flex flex-col">
                            <h3 class="font-bold text-2xl mb-3 text-gray-900">UNJ Resmikan Arboretum sebagai Laboratorium Hidup dan Paru-paru Kampus</h3>
                            <p class="text-gray-600 mb-6 flex-grow">UNJ mendedikasikan sebagian lahan kampusnya sebagai arboretum yang menampung berbagai jenis tanaman lokal dan langka. Area ini berfungsi sebagai pusat penelitian botani, sarana edukasi lingkungan, sekaligus area resapan air untuk kampus.</p>
                            <a href="{{ route('sdg.berita.show', ['sdg_id' => 15, 'slug' => 'unj-resmikan-arboretum-laboratorium-hidup']) }}" class="mt-auto self-start inline-block bg-sdg-land-green text-white font-semibold px-6 py-3 rounded-lg hover:bg-sdg-land-green-dark transition-colors duration-300">
                                Baca Selengkapnya <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                        </div>
                    </div>
                    <div class="lg:col-span-2 flex flex-col gap-8">
                        <div class="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 flex flex-col sm:flex-row lg:flex-col">
                            <img src="https://images.unsplash.com/photo-1594723453368-47253856868a?q=80&w=1964&auto=format&fit=crop" alt="Satwa Liar" class="w-full sm:w-1/3 lg:w-full h-48 sm:h-auto lg:h-40 object-cover">
                            <div class="p-6 flex-grow flex flex-col">
                                <h3 class="font-bold text-xl mb-2 text-gray-900">Riset UNJ: Pemetaan Koridor Satwa Liar di Lanskap Perkotaan</h3>
                                <p class="text-gray-600 mb-4 text-sm flex-grow">Tim Biologi menggunakan kamera jebak dan GPS tracking untuk memetakan pergerakan satwa liar di area hijau sekitar Jakarta sebagai dasar kebijakan konservasi.</p>
                                <a href="{{ route('sdg.berita.show', ['sdg_id' => 15, 'slug' => 'riset-unj-pemetaan-koridor-satwa-liar']) }}" class="mt-auto self-start text-sdg-land-green font-semibold hover:text-sdg-land-green-dark transition-colors">
                                    Baca Selengkapnya <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        </div>
                        <div class="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 flex flex-col sm:flex-row lg:flex-col">
                            <img src="https://images.unsplash.com/photo-1599399008985-e0b82b9846a8?q=80&w=2070&auto=format&fit=crop" alt="Reboisasi" class="w-full sm:w-1/3 lg:w-full h-48 sm:h-auto lg:h-40 object-cover">
                            <div class="p-6 flex-grow flex flex-col">
                                <h3 class="font-bold text-xl mb-2 text-gray-900">KKN Tematik UNJ Fokus pada Reboisasi Lahan Kritis di Hulu Sungai</h3>
                                <p class="text-gray-600 mb-4 text-sm flex-grow">Mahasiswa melakukan penanaman pohon di lahan kritis di kawasan hulu sungai untuk mencegah erosi dan menjaga ketersediaan air tanah.</p>
                                <a href="{{ route('sdg.berita.show', ['sdg_id' => 15, 'slug' => 'kkn-tematik-unj-fokus-reboisasi-lahan-kritis']) }}" class="mt-auto self-start text-sdg-land-green font-semibold hover:text-sdg-land-green-dark transition-colors">
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
                    <p class="mt-3 text-lg text-gray-600">Kajian dan penelitian dari civitas academica UNJ tentang ekosistem daratan.</p>
                    <div class="mt-4 inline-block h-1.5 w-24 bg-sdg-land-green rounded-full"></div>
                </div>
                <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-lg">
                    <ul class="divide-y divide-gray-200">
                        <li class="p-6">
                            <a href="#" class="flex items-center gap-5 group">
                                <i class="fas fa-file-alt text-3xl text-sdg-land-green flex-shrink-0"></i>
                                <div class="flex-grow">
                                    <h3 class="font-semibold text-lg text-gray-900 group-hover:text-sdg-land-green-dark transition-colors">Keanekaragaman Jenis Tumbuhan Bawah pada Berbagai Tingkat Suksesi Hutan di Taman Nasional Gede Pangrango</h3>
                                    <p class="text-sm text-gray-500 mt-1">Dr. Biologi. Endah Sulistyawati, M.Si. | Jurnal Biologi Indonesia Vol. 20, No. 1, 2024</p>
                                </div>
                                <i class="fas fa-download ml-auto text-xl text-gray-400 group-hover:text-sdg-land-green-dark transition-transform group-hover:scale-110"></i>
                            </a>
                        </li>
                        <li class="p-6">
                             <a href="#" class="flex items-center gap-5 group">
                                <i class="fas fa-file-alt text-3xl text-sdg-land-green flex-shrink-0"></i>
                                <div class="flex-grow">
                                    <h3 class="font-semibold text-lg text-gray-900 group-hover:text-sdg-land-green-dark transition-colors">Analisis Perubahan Penutupan Lahan dan Dampaknya terhadap Laju Erosi di DAS Ciliwung Hulu</h3>
                                    <p class="text-sm text-gray-500 mt-1">Prof. Dr. Geografi. Nandi, M.Sc. | Jurnal Geografi dan Konservasi Vol. 15, No. 2, 2023</p>
                                </div>
                                <i class="fas fa-download ml-auto text-xl text-gray-400 group-hover:text-sdg-land-green-dark transition-transform group-hover:scale-110"></i>
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