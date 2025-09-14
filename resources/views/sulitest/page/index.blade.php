<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UNJ Sustainability Literacy Test (SULITEST)</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" type="image/png">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-50">

    {{-- Memanggil Navbar Khusus Sulitest --}}
    @include('layout.sulitest.navbar')

    <main>
        <!-- Hero Section -->
        <section class="relative bg-teal-700 text-white py-24 sm:py-32">
            <div class="absolute inset-0 bg-cover bg-center opacity-10" style="background-image: url('https://images.unsplash.com/photo-1593113598332-cd288d6494a4?q=80&w=2070&auto=format&fit=crop');"></div>
            <div class="container mx-auto px-6 text-center relative z-10">
                <h1 class="text-4xl sm:text-5xl md:text-6xl font-extrabold leading-tight mb-4 tracking-tight">Ukur Pemahaman Anda tentang Keberlanjutan</h1>
                <p class="text-lg md:text-xl max-w-3xl mx-auto mb-10 text-teal-100">
                    UNJ Sustainability Literacy Test (Sulitest) adalah alat untuk meningkatkan kesadaran dan pengetahuan mengenai Tujuan Pembangunan Berkelanjutan (SDGs).
                </p>
                <a href="{{ route('sulitest.login') }}" class="bg-yellow-400 text-teal-800 font-bold text-lg px-8 py-4 rounded-lg hover:bg-yellow-500 transition-transform transform hover:scale-105 shadow-xl inline-block">
                    Mulai Tes Sekarang <i class="fas fa-arrow-right ml-2 transition-transform group-hover:translate-x-1"></i>
                </a>
            </div>
        </section>

        <!-- About Section -->
        <section id="about" class="py-20 bg-white">
            <div class="container mx-auto px-6 grid md:grid-cols-2 gap-12 items-center">
                <div class="text-center md:text-left">
                    <span class="text-teal-600 font-semibold uppercase tracking-wider">Tentang Sulitest</span>
                    <h2 class="text-3xl font-bold text-gray-800 my-3">Apa itu UNJ Sulitest?</h2>
                    <p class="text-gray-600 leading-relaxed mb-4">
                        Sulitest adalah sebuah inisiatif global yang bertujuan untuk mengukur dan meningkatkan literasi keberlanjutan. Di UNJ, tes ini menjadi sarana penting untuk memetakan pemahaman sivitas akademika terhadap isu-isu keberlanjutan global dan lokal sesuai kerangka Tujuan Pembangunan Berkelanjutan (SDGs).
                    </p>
                    <p class="text-gray-600 leading-relaxed">
                        Dengan mengikuti tes ini, Anda turut berkontribusi pada upaya UNJ dalam menciptakan kampus yang lebih sadar lingkungan dan bertanggung jawab secara sosial.
                    </p>
                </div>
                <div>
                    <img src="https://plus.unsplash.com/premium_photo-1683140622299-a8f254425a7a?q=80&w=1974&auto=format&fit=crop" alt="Sustainability illustration" class="rounded-xl shadow-xl w-full h-auto">
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="py-20 bg-gray-50">
            <div class="container mx-auto px-6">
                <div class="text-center mb-16">
                    <span class="text-teal-600 font-semibold uppercase tracking-wider">Pilar Utama</span>
                    <h2 class="text-3xl font-bold text-gray-800 my-3">Mengapa Tes Ini Penting?</h2>
                    <p class="text-gray-600 max-w-2xl mx-auto mt-4">Fokus utama yang mendorong implementasi UNJ Sulitest untuk masa depan yang lebih baik.</p>
                </div>
                <div class="grid md:grid-cols-3 gap-8">
                    <!-- Card 1 -->
                    <div class="bg-white p-8 rounded-xl shadow-lg text-center hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">
                        <div class="bg-teal-100 text-teal-600 rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-lightbulb text-4xl"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-3">Meningkatkan Kesadaran</h3>
                        <p class="text-gray-600">Mengidentifikasi tingkat pemahaman Anda terhadap 17 Tujuan Pembangunan Berkelanjutan (SDGs).</p>
                    </div>
                    <!-- Card 2 -->
                    <div class="bg-white p-8 rounded-xl shadow-lg text-center hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">
                        <div class="bg-teal-100 text-teal-600 rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-chart-line text-4xl"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-3">Mendukung Kebijakan</h3>
                        <p class="text-gray-600">Hasil tes menjadi data berharga bagi UNJ untuk merancang program dan kebijakan yang lebih efektif.</p>
                    </div>
                    <!-- Card 3 -->
                    <div class="bg-white p-8 rounded-xl shadow-lg text-center hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">
                        <div class="bg-teal-100 text-teal-600 rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-globe-asia text-4xl"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-3">Kontribusi Global</h3>
                        <p class="text-gray-600">Menjadi bagian dari gerakan global untuk pendidikan keberlanjutan dan pencapaian target SDGs.</p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    {{-- Memanggil Footer Khusus Sulitest --}}
    @include('layout.sulitest.footer')

</body>
</html>
