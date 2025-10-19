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

    @include('layout.navbar_pemeringkatan')

    <main>
        <!-- HERO -->
        <section class="relative bg-gradient-to-br from-teal-700 to-teal-600 text-white pt-28 pb-24">
            <div class="container mx-auto px-6">
                <div class="max-w-4xl mx-auto text-center">
                    <h1 class="text-4xl sm:text-5xl font-extrabold leading-tight tracking-tight">UNJ Sustainability Literacy Test (SULITEST)</h1>
                    <p class="mt-4 text-teal-100 text-lg">Ukur literasi keberlanjutan Anda dan dukung inisiatif UNJ menuju kampus berkelanjutan.</p>
                    <div class="mt-8 flex items-center justify-center gap-4">
                        <a href="{{ route('sulitest.login') }}" class="bg-yellow-400 text-teal-900 font-semibold px-6 py-3 rounded-md hover:bg-yellow-500">Coba Sulitest</a>
                        <a href="#about" class="border border-white/40 px-6 py-3 rounded-md hover:bg-white/10">Pelajari lebih lanjut</a>
                    </div>
                </div>
            </div>
        </section>

        <!-- TRUST/LOGOS STRIP -->
        <section class="py-10 bg-white">
            <div class="container mx-auto px-6">
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-6 items-center opacity-70">
                    <div class="h-10 bg-gray-200 rounded animate-pulse"></div>
                    <div class="h-10 bg-gray-200 rounded animate-pulse"></div>
                    <div class="h-10 bg-gray-200 rounded animate-pulse"></div>
                    <div class="h-10 bg-gray-200 rounded animate-pulse"></div>
                    <div class="h-10 bg-gray-200 rounded animate-pulse"></div>
                    <div class="h-10 bg-gray-200 rounded animate-pulse"></div>
                </div>
            </div>
        </section>

        <!-- ABOUT -->
        <section id="about" class="py-20 bg-gray-50">
            <div class="container mx-auto px-6 grid md:grid-cols-2 gap-10 items-center">
                <div>
                    <span class="text-teal-600 font-semibold uppercase tracking-wider">Tentang</span>
                    <h2 class="text-3xl font-bold text-gray-800 my-3">Apa itu Sulitest UNJ?</h2>
                    <p class="text-gray-700 leading-relaxed mb-4">Sulitest UNJ adalah asesmen untuk mengukur pemahaman sivitas akademika tentang isu-isu keberlanjutan, selaras dengan 17 Tujuan Pembangunan Berkelanjutan (SDGs). Hasilnya membantu UNJ merancang program dan kebijakan yang berdampak.</p>
                    <ul class="space-y-2 text-gray-700">
                        <li class="flex gap-3"><i class="fas fa-check text-teal-600 mt-1"></i><span>Selaras dengan kerangka SDGs dan praktik global Sulitest.</span></li>
                        <li class="flex gap-3"><i class="fas fa-check text-teal-600 mt-1"></i><span>Memuat konteks lokal UNJ agar lebih relevan.</span></li>
                        <li class="flex gap-3"><i class="fas fa-check text-teal-600 mt-1"></i><span>Memberikan wawasan untuk peningkatan kurikulum dan kegiatan kampus.</span></li>
                    </ul>
                </div>
                <div class="w-full h-72 md:h-96 bg-gray-200 rounded-xl flex items-center justify-center">
                    <i class="fas fa-leaf text-6xl text-teal-500 opacity-60"></i>
                </div>
            </div>
        </section>

        <!-- FITUR -->
        <section class="py-20 bg-white">
            <div class="container mx-auto px-6">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-800">Fitur Utama</h2>
                    <p class="text-gray-600 mt-2">Komponen yang membantu tes berjalan efektif dan informatif.</p>
                </div>
                <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="p-6 border border-gray-200 rounded-xl bg-white">
                        <div class="h-12 w-12 bg-teal-100 text-teal-700 rounded flex items-center justify-center mb-4"><i class="fas fa-globe"></i></div>
                        <h3 class="font-semibold mb-2">Modul Global & Lokal</h3>
                        <p class="text-gray-600 text-sm">Pertanyaan berbasis standar global Sulitest dan konteks UNJ.</p>
                    </div>
                    <div class="p-6 border border-gray-200 rounded-xl bg-white">
                        <div class="h-12 w-12 bg-teal-100 text-teal-700 rounded flex items-center justify-center mb-4"><i class="fas fa-chart-pie"></i></div>
                        <h3 class="font-semibold mb-2">Umpan Balik Instan</h3>
                        <p class="text-gray-600 text-sm">Gambaran kekuatan dan area yang perlu ditingkatkan.</p>
                    </div>
                    <div class="p-6 border border-gray-200 rounded-xl bg-white">
                        <div class="h-12 w-12 bg-teal-100 text-teal-700 rounded flex items-center justify-center mb-4"><i class="fas fa-user-check"></i></div>
                        <h3 class="font-semibold mb-2">Akun Peserta</h3>
                        <p class="text-gray-600 text-sm">Akses riwayat tes dan progres pembelajaran.</p>
                    </div>
                    <div class="p-6 border border-gray-200 rounded-xl bg-white">
                        <div class="h-12 w-12 bg-teal-100 text-teal-700 rounded flex items-center justify-center mb-4"><i class="fas fa-file-export"></i></div>
                        <h3 class="font-semibold mb-2">Pelaporan UNJ</h3>
                        <p class="text-gray-600 text-sm">Agregasi data untuk kebijakan dan pelaporan institusi.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- CARA KERJA -->
        <section class="py-20 bg-gray-50">
            <div class="container mx-auto px-6">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-800">Cara Kerja</h2>
                    <p class="text-gray-600 mt-2">Empat langkah sederhana untuk mengikuti Sulitest UNJ.</p>
                </div>
                <div class="grid md:grid-cols-4 gap-8">
                    <div class="bg-white rounded-xl border border-gray-200 p-6">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="h-10 w-10 rounded-full bg-teal-600 text-white flex items-center justify-center font-bold">1</div>
                            <h3 class="font-semibold">Daftar / Login</h3>
                        </div>
                        <p class="text-gray-600 text-sm">Masuk dengan akun Anda untuk mulai mengikuti tes.</p>
                    </div>
                    <div class="bg-white rounded-xl border border-gray-200 p-6">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="h-10 w-10 rounded-full bg-teal-600 text-white flex items-center justify-center font-bold">2</div>
                            <h3 class="font-semibold">Pilih Tes</h3>
                        </div>
                        <p class="text-gray-600 text-sm">Pilih modul yang tersedia sesuai kebutuhan.</p>
                    </div>
                    <div class="bg-white rounded-xl border border-gray-200 p-6">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="h-10 w-10 rounded-full bg-teal-600 text-white flex items-center justify-center font-bold">3</div>
                            <h3 class="font-semibold">Kerjakan Soal</h3>
                        </div>
                        <p class="text-gray-600 text-sm">Jawab pertanyaan yang disajikan dalam batas waktu.</p>
                    </div>
                    <div class="bg-white rounded-xl border border-gray-200 p-6">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="h-10 w-10 rounded-full bg-teal-600 text-white flex items-center justify-center font-bold">4</div>
                            <h3 class="font-semibold">Lihat Hasil</h3>
                        </div>
                        <p class="text-gray-600 text-sm">Tinjau skor dan rekomendasi peningkatan.</p>
                    </div>
                </div>
                <div class="text-center mt-10">
                    <a href="{{ route('sulitest.login') }}" class="inline-block bg-yellow-400 text-teal-900 font-semibold px-6 py-3 rounded-md hover:bg-yellow-500">Masuk untuk Mulai</a>
                </div>
            </div>
        </section>

        <!-- STATISTIK (dummy) -->
        <section class="py-16 bg-white">
            <div class="container mx-auto px-6">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
                    <div class="p-6 rounded-xl border border-gray-200">
                        <div class="text-3xl font-extrabold text-teal-700">1.2K+</div>
                        <div class="text-gray-600 text-sm mt-1">Peserta</div>
                    </div>
                    <div class="p-6 rounded-xl border border-gray-200">
                        <div class="text-3xl font-extrabold text-teal-700">35+</div>
                        <div class="text-gray-600 text-sm mt-1">Program Studi</div>
                    </div>
                    <div class="p-6 rounded-xl border border-gray-200">
                        <div class="text-3xl font-extrabold text-teal-700">80%</div>
                        <div class="text-gray-600 text-sm mt-1">Kepuasan</div>
                    </div>
                    <div class="p-6 rounded-xl border border-gray-200">
                        <div class="text-3xl font-extrabold text-teal-700">100%</div>
                        <div class="text-gray-600 text-sm mt-1">Selaras SDGs</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- FINAL CTA -->
        {{-- <section class="py-20 bg-teal-700 text-white">
            <div class="container mx-auto px-6 text-center">
                <h2 class="text-3xl font-bold">Siap Mulai?</h2>
                <p class="text-teal-100 mt-2">Ikuti Sulitest UNJ sekarang dan ketahui tingkat literasi keberlanjutan Anda.</p>
                <a href="{{ route('sulitest.login') }}" class="inline-block mt-6 bg-yellow-400 text-teal-900 font-semibold px-6 py-3 rounded-md hover:bg-yellow-500">Login / Coba Sekarang</a>
            </div>
        </section> --}}
    </main>

    @include('layout.footer')

</body>
</html>
