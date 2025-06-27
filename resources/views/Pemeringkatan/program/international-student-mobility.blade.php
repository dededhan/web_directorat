<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>International Student Mobility DITISIP</title>
    <link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" type="image/png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
    <link rel="stylesheet" href="{{ asset('home.css') }}">
    @vite([
        'resources/css/fitur/international-student-mobility.css',
        'resources/js/fitur/international-student-mobility.js' {{-- Path disesuaikan untuk Vite dan typo diperbaiki --}}
    ])
</head>
<body>
    @include('layout.navbarpemeringkatan')

    <div class="mobility-page pt-16">
        <div class="mobility-hero">
            <div class="mobility-hero-content">
                <h2 class="text-4xl font-bold mb-4">International Student Mobility</h2>
                <p class="text-xl">Program pertukaran dan mobilitas mahasiswa internasional untuk memperluas wawasan global, memperkaya pengalaman akademik, dan membangun jaringan internasional.</p>
            </div>
        </div>

        <div class="container mx-auto px-6 py-8">
            <section class="mobility-section">
                <h2 class="mobility-section-title text-3xl font-bold">Tentang International Student Mobility</h2>
                <p class="mb-4">Program International Student Mobility merupakan inisiatif strategis UNJ untuk memfasilitasi pertukaran mahasiswa dengan universitas mitra di berbagai negara. Program ini dirancang untuk memberikan kesempatan kepada mahasiswa UNJ untuk belajar di luar negeri serta menerima mahasiswa internasional untuk belajar di UNJ.</p>
                <p>Melalui program ini, UNJ bertujuan untuk memperkaya pengalaman akademik dan budaya mahasiswa, meningkatkan kompetensi global, dan membangun jaringan internasional yang mendukung pengembangan karir di masa depan.</p>
            </section>

            <section class="mobility-section">
                <h2 class="mobility-section-title text-3xl font-bold">Program Mobilitas Mahasiswa</h2>
                
                <div class="mobility-cards">
                    <div class="mobility-card">
                        <div class="mobility-testimonial-author">
                            <img src="https://i.ibb.co/njwMXSS/student-2.jpg" alt="Foto Budi Santoso" class="mobility-testimonial-avatar">
                            <div class="mobility-testimonial-info">
                                <div class="mobility-testimonial-name">Budi Santoso</div>
                                <div class="mobility-testimonial-program">Fakultas Teknologi Pendidikan | Summer School Program 2023</div>
                            </div>
                        </div>
                    </div>
                    <div class="mobility-testimonial">
                        <div class="mobility-testimonial-content">
                            <p class="italic text-gray-700">Program internship internasional di Singapura memberikan saya pengalaman kerja nyata dalam perusahaan multinasional. Keterampilan profesional dan jaringan yang saya dapatkan sangat membantu dalam persiapan karir saya setelah lulus dari UNJ.</p>
                        </div>
                        <div class="mobility-testimonial-author">
                            <img src="https://i.ibb.co/n8rNvpK/student-3.jpg" alt="Foto Dian Permata" class="mobility-testimonial-avatar">
                            <div class="mobility-testimonial-info">
                                <div class="mobility-testimonial-name">Dian Permata</div>
                                <div class="mobility-testimonial-program">Fakultas Ekonomi | International Internship Program 2023</div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="mobility-section">
                <h2 class="mobility-section-title text-3xl font-bold">Pencapaian Program</h2>
                
                <div class="mobility-stats">
                    <div class="mobility-stat">
                        <div class="mobility-stat-number">350+</div>
                        <div class="mobility-stat-title">Mahasiswa Outbound</div>
                    </div>
                    <div class="mobility-stat">
                        <div class="mobility-stat-number">250+</div>
                        <div class="mobility-stat-title">Mahasiswa Inbound</div>
                    </div>
                    <div class="mobility-stat">
                        <div class="mobility-stat-number">45+</div>
                        <div class="mobility-stat-title">Universitas Mitra</div>
                    </div>
                    <div class="mobility-stat">
                        <div class="mobility-stat-number">25+</div>
                        <div class="mobility-stat-title">Negara Tujuan</div>
                    </div>
                </div>
                
                <div class="mt-8">
                    <h3 class="text-xl font-bold text-teal-700 mb-4">Impact & Manfaat</h3>
                    <ul class="space-y-3">
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-teal-600 mt-1 mr-3"></i>
                            <p>Peningkatan kemampuan bahasa asing dan kompetensi interkultural mahasiswa UNJ</p>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-teal-600 mt-1 mr-3"></i>
                            <p>Meningkatnya daya saing lulusan UNJ di pasar kerja global</p>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-teal-600 mt-1 mr-3"></i>
                            <p>Penguatan parameter internasionalisasi dalam pemeringkatan universitas</p>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-teal-600 mt-1 mr-3"></i>
                            <p>Memperkuat jaringan akademik UNJ dengan universitas terkemuka dunia</p>
                        </li>
                    </ul>
                </div>
            </section>

            <section class="mobility-section">
                <h2 class="mobility-section-title text-3xl font-bold">FAQ</h2>
                
                <div class="mobility-faq">
                    <div class="mobility-faq-item">
                        <div class="mobility-faq-question" onclick="toggleFAQ(this)">
                            <span>Apakah program mobilitas mahasiswa akan memperpanjang masa studi saya?</span>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        <div class="mobility-faq-answer">
                            <p>Tidak, program mobilitas mahasiswa dirancang dengan sistem credit transfer sehingga mata kuliah yang diambil di universitas mitra dapat diakui sebagai bagian dari kurikulum UNJ. Dengan perencanaan yang baik, program mobilitas tidak akan memperpanjang masa studi Anda.</p>
                        </div>
                    </div>
                    <div class="mobility-faq-item">
                        <div class="mobility-faq-question" onclick="toggleFAQ(this)">
                            <span>Bagaimana persyaratan kemampuan bahasa untuk program mobilitas?</span>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        <div class="mobility-faq-answer">
                            <p>Persyaratan kemampuan bahasa bervariasi tergantung pada universitas tujuan dan bahasa pengantar yang digunakan. Umumnya, untuk program berbahasa Inggris diperlukan skor TOEFL iBT minimal 80 atau IELTS 6.0, sementara untuk program berbahasa lain mungkin memerlukan sertifikat kompetensi seperti JLPT, HSK, atau DELF.</p>
                        </div>
                    </div>
                    <div class="mobility-faq-item">
                        <div class="mobility-faq-question" onclick="toggleFAQ(this)">
                            <span>Berapa estimasi biaya untuk program mobilitas mahasiswa?</span>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        <div class="mobility-faq-answer">
                            <p>Biaya program bervariasi tergantung pada jenis program, negara tujuan, dan durasi. Estimasi biaya untuk program pertukaran 1 semester berkisar antara Rp 50-150 juta, mencakup biaya kuliah, akomodasi, transportasi, asuransi, dan biaya hidup. Namun, tersedia berbagai skema beasiswa dan bantuan pendanaan yang dapat mengurangi atau menanggung seluruh biaya program.</p>
                        </div>
                    </div>
                    <div class="mobility-faq-item">
                        <div class="mobility-faq-question" onclick="toggleFAQ(this)">
                            <span>Kapan waktu yang tepat untuk mendaftar program mobilitas?</span>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        <div class="mobility-faq-answer">
                            <p>Pendaftaran program mobilitas umumnya dibuka 6-12 bulan sebelum masa keberangkatan. Untuk program pertukaran semester genap (mulai Januari/Februari), pendaftaran biasanya dibuka pada Maret-Mei tahun sebelumnya. Untuk program semester ganjil (mulai Agustus/September), pendaftaran dibuka pada Oktober-Desember tahun sebelumnya.</p>
                        </div>
                    </div>
                    <div class="mobility-faq-item">
                        <div class="mobility-faq-question" onclick="toggleFAQ(this)">
                            <span>Apakah mahasiswa dari semua program studi dapat mengikuti program mobilitas?</span>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        <div class="mobility-faq-answer">
                            <p>Ya, program mobilitas terbuka untuk mahasiswa dari semua program studi, namun ketersediaan program spesifik untuk suatu bidang studi bergantung pada kerja sama yang telah dijalin dengan universitas mitra. Silakan berkonsultasi dengan Kantor Urusan Internasional UNJ untuk informasi lengkap tentang program yang tersedia untuk program studi Anda.</p>
                        </div>
                    </div>
                </div>
            </section>

            <section class="bg-gradient-to-r from-teal-700 to-teal-800 text-white p-8 rounded-xl shadow-lg text-center">
                <h2 class="text-3xl font-bold mb-4">Siap untuk Pengalaman Global?</h2>
                <p class="mb-6 max-w-3xl mx-auto">Jelajahi dunia, perluas wawasan, dan kembangkan potensi Anda melalui program mobilitas mahasiswa internasional UNJ.</p>
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="#" class="bg-white text-teal-800 px-6 py-3 rounded-lg font-medium transition-all duration-300 hover:bg-yellow-400 hover:text-teal-900">Program yang Tersedia</a>
                    <a href="#" class="bg-white text-teal-800 px-6 py-3 rounded-lg font-medium transition-all duration-300 hover:bg-yellow-400 hover:text-teal-900">Jadwal Pendaftaran</a>
                    <a href="#" class="bg-white text-teal-800 px-6 py-3 rounded-lg font-medium transition-all duration-300 hover:bg-yellow-400 hover:text-teal-900">Konsultasi Online</a>
                </div>
            </section>
        </div>
    </div>
 
    
    @include('layout.footer')
</body>