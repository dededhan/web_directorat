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
    <style>
        * {
            font-family: Arial, sans-serif !important;
        }
        
        .mobility-page {
            --primary-color: #186862;
            --secondary-color: #125a54;
            --accent-color: #facc15;
            --light-color: #ecf0f1;
            --dark-color: #34495e;
        }

        .mobility-hero {
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('https://i.ibb.co/ZMVN9jx/international-students.jpg') center/cover no-repeat;
            height: 400px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-align: center;
            position: relative;
            margin-bottom: 3rem;
        }

        .mobility-hero-content {
            max-width: 800px;
            padding: 2rem;
        }

        .mobility-section {
            background-color: white;
            padding: 2.5rem;
            margin-bottom: 2rem;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .mobility-section-title {
            color: var(--primary-color);
            margin-bottom: 1.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid var(--primary-color);
        }

        .mobility-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-top: 2.5rem;
        }

        .mobility-card {
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .mobility-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }

        .mobility-card-img {
            height: 200px;
            position: relative;
            overflow: hidden;
        }

        .mobility-card-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .mobility-card:hover .mobility-card-img img {
            transform: scale(1.05);
        }

        .mobility-card-content {
            padding: 1.5rem;
        }

        .mobility-card h3 {
            color: var(--primary-color);
            margin-bottom: 1rem;
        }

        .mobility-btn {
            display: inline-block;
            background-color: var(--primary-color);
            color: white;
            padding: 0.8rem 1.5rem;
            margin-top: 1rem;
            text-decoration: none;
            border-radius: 5px;
            font-weight: 500;
            transition: background-color 0.3s ease;
        }

        .mobility-btn:hover {
            background-color: var(--secondary-color);
        }

        .mobility-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }

        .mobility-stat {
            background-color: white;
            padding: 1.5rem;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .mobility-stat-number {
            font-size: 2.5rem;
            font-weight: bold;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }

        .mobility-stat-title {
            color: var(--secondary-color);
            font-weight: 500;
        }

        .mobility-partners {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }

        .mobility-partner {
            display: flex;
            flex-direction: column;
            align-items: center;
            background-color: white;
            padding: 1.5rem;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .mobility-partner:hover {
            transform: translateY(-5px);
        }

        .mobility-partner-logo {
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
        }

        .mobility-partner-country {
            display: flex;
            align-items: center;
            margin-top: 0.5rem;
            color: #718096;
        }

        .mobility-partner-country img {
            width: 20px;
            height: 15px;
            margin-right: 0.5rem;
        }

        .mobility-testimonials {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }

        .mobility-testimonial {
            display: flex;
            flex-direction: column;
            background-color: white;
            padding: 1.5rem;
            border-radius: 8px;
            position: relative;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .mobility-testimonial::before {
            content: '\201C';
            font-family: Arial, sans-serif;
            position: absolute;
            top: 10px;
            left: 20px;
            font-size: 4rem;
            color: #e2e8f0;
            z-index: 0;
        }

        .mobility-testimonial-content {
            position: relative;
            z-index: 1;
            flex: 1;
            margin-bottom: 1.5rem;
        }

        .mobility-testimonial-author {
            display: flex;
            align-items: center;
            margin-top: auto;
        }

        .mobility-testimonial-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 1rem;
        }

        .mobility-testimonial-info {
            flex: 1;
        }

        .mobility-testimonial-name {
            font-weight: bold;
            color: var(--primary-color);
        }

        .mobility-testimonial-program {
            color: #718096;
            font-size: 0.875rem;
        }

        .mobility-steps {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            margin-top: 2rem;
            position: relative;
        }

        .mobility-step {
            flex: 1;
            min-width: 250px;
            max-width: 300px;
            margin: 1rem;
            padding: 1.5rem;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            position: relative;
            z-index: 1;
        }

        .mobility-step-number {
            position: absolute;
            top: -15px;
            left: -15px;
            width: 40px;
            height: 40px;
            background-color: var(--primary-color);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 1.25rem;
        }

        .mobility-step-title {
            font-weight: bold;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }

        .mobility-step-connector {
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 4px;
            background-color: #e2e8f0;
            z-index: 0;
        }

        .mobility-faq {
            margin-top: 2rem;
        }

        .mobility-faq-item {
            border-bottom: 1px solid #e2e8f0;
            padding: 1.5rem 0;
        }

        .mobility-faq-question {
            font-weight: bold;
            color: var(--primary-color);
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .mobility-faq-answer {
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px dashed #e2e8f0;
            display: none;
        }

        .mobility-faq-answer.show {
            display: block;
        }

        @media (max-width: 768px) {
            .mobility-hero {
                height: 300px;
            }

            .mobility-hero h2 {
                font-size: 1.8rem;
            }
            
            .mobility-section {
                padding: 1.5rem;
            }

            .mobility-step {
                margin: 1.5rem 0;
            }

            .mobility-step-connector {
                display: none;
            }
        }
    </style>
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
    
    <script>
        function toggleFAQ(element) {
            const answer = element.nextElementSibling;
            const icon = element.querySelector('i');
            
            if (answer.classList.contains('show')) {
                answer.classList.remove('show');
                icon.classList.remove('fa-chevron-up');
                icon.classList.add('fa-chevron-down');
            } else {
                answer.classList.add('show');
                icon.classList.remove('fa-chevron-down');
                icon.classList.add('fa-chevron-up');
            }
        }
    </script>
    
    @include('layout.footer')
</body>