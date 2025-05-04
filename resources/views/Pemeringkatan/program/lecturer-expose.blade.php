<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lecturer Expose DITISIP</title>
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
        
        .lecturer-page {
            --primary-color: #186862;
            --secondary-color: #125a54;
            --accent-color: #facc15;
            --light-color: #ecf0f1;
            --dark-color: #34495e;
        }

        .lecturer-hero {
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('https://i.ibb.co/MgYKzDF/campus-lecture.jpg') center/cover no-repeat;
            height: 400px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-align: center;
            position: relative;
            margin-bottom: 3rem;
        }

        .lecturer-hero-content {
            max-width: 800px;
            padding: 2rem;
        }

        .lecturer-section {
            background-color: white;
            padding: 2.5rem;
            margin-bottom: 2rem;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .lecturer-section-title {
            color: var(--primary-color);
            margin-bottom: 1.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid var(--primary-color);
        }

        .lecturer-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-top: 2.5rem;
        }

        .lecturer-card {
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .lecturer-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }

        .lecturer-card-img {
            height: 200px;
            position: relative;
            overflow: hidden;
        }

        .lecturer-card-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .lecturer-card:hover .lecturer-card-img img {
            transform: scale(1.05);
        }

        .lecturer-card-content {
            padding: 1.5rem;
        }

        .lecturer-card h3 {
            color: var(--primary-color);
            margin-bottom: 1rem;
        }

        .lecturer-btn {
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

        .lecturer-btn:hover {
            background-color: var(--secondary-color);
        }

        .lecturer-timeline {
            position: relative;
            max-width: 1200px;
            margin: 0 auto;
            padding-top: 2rem;
        }

        .lecturer-timeline::after {
            content: '';
            position: absolute;
            width: 6px;
            background-color: #e2e8f0;
            top: 0;
            bottom: 0;
            left: 50%;
            margin-left: -3px;
        }

        .lecturer-timeline-item {
            padding: 10px 40px;
            position: relative;
            background-color: inherit;
            width: 50%;
        }

        .lecturer-timeline-item::after {
            content: '';
            position: absolute;
            width: 25px;
            height: 25px;
            right: -12px;
            background-color: white;
            border: 4px solid var(--primary-color);
            top: 15px;
            border-radius: 50%;
            z-index: 1;
        }

        .lecturer-timeline-left {
            left: 0;
        }

        .lecturer-timeline-right {
            left: 50%;
        }

        .lecturer-timeline-right::after {
            left: -12px;
        }

        .lecturer-timeline-content {
            padding: 20px 30px;
            background-color: white;
            position: relative;
            border-radius: 6px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .lecturer-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }

        .lecturer-stat {
            background-color: white;
            padding: 1.5rem;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .lecturer-stat-number {
            font-size: 2.5rem;
            font-weight: bold;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }

        .lecturer-stat-title {
            color: var(--secondary-color);
            font-weight: 500;
        }

        .lecturer-testimonials {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }

        .lecturer-testimonial {
            background-color: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        .lecturer-testimonial::before {
            content: '\201C';
            font-family: Arial, sans-serif;
            position: absolute;
            top: 10px;
            left: 20px;
            font-size: 4rem;
            color: #e2e8f0;
            z-index: 0;
        }

        .lecturer-testimonial-content {
            position: relative;
            z-index: 1;
        }

        .lecturer-testimonial-author {
            display: flex;
            align-items: center;
            margin-top: 1.5rem;
        }

        .lecturer-testimonial-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 1rem;
            background-position: center;
            background-size: cover;
        }

        @media (max-width: 768px) {
            .lecturer-hero {
                height: 300px;
            }

            .lecturer-hero h2 {
                font-size: 1.8rem;
            }
            
            .lecturer-section {
                padding: 1.5rem;
            }

            .lecturer-timeline::after {
                left: 31px;
            }

            .lecturer-timeline-item {
                width: 100%;
                padding-left: 70px;
                padding-right: 25px;
            }

            .lecturer-timeline-right {
                left: 0;
            }

            .lecturer-timeline-left::after, 
            .lecturer-timeline-right::after {
                left: 18px;
            }
        }
    </style>
</head>
<body>
    @include('layout.navbarpemeringkatan')

    <div class="lecturer-page pt-16">
        <div class="lecturer-hero">
            <div class="lecturer-hero-content">
                <h2 class="text-4xl font-bold mb-4">Lecturer Expose</h2>
                <p class="text-xl">Program peningkatan kompetensi dan visibilitas global dosen Universitas Negeri Jakarta dalam publikasi internasional, pengajaran, dan penelitian.</p>
            </div>
        </div>

        <div class="container mx-auto px-6 py-8">
            <section class="lecturer-section">
                <h2 class="lecturer-section-title text-3xl font-bold">Tentang Lecturer Expose</h2>
                <p class="mb-4">Program Lecturer Expose merupakan inisiatif strategis UNJ untuk meningkatkan kualitas dan pengakuan global terhadap dosen-dosen UNJ melalui berbagai program eksposur internasional, pengembangan kapasitas, dan kolaborasi dengan institusi pendidikan tinggi terkemuka dunia.</p>
                <p>Melalui program ini, dosen UNJ berkesempatan untuk mengembangkan keahlian, memperluas jaringan internasional, dan meningkatkan kualitas publikasi ilmiah mereka, yang pada akhirnya akan berkontribusi pada peningkatan reputasi akademik Universitas Negeri Jakarta di tingkat global.</p>
            </section>

            <section class="lecturer-section">
                <h2 class="lecturer-section-title text-3xl font-bold">Program Utama</h2>
                
                <div class="lecturer-cards">
                    <div class="lecturer-card">
                        <div class="lecturer-card-img">
                            <img src="https://i.ibb.co/mGjsXQX/international-conference.jpg" alt="Dosen UNJ berbicara di konferensi internasional">
                        </div>
                        <div class="lecturer-card-content">
                            <h3 class="text-xl font-bold">Konferensi Internasional</h3>
                            <p>Dukungan partisipasi dosen UNJ sebagai pembicara atau pemakalah di konferensi internasional untuk mempresentasikan hasil riset dan membentuk jaringan global.</p>
                            <a href="#" class="lecturer-btn">Pelajari Lebih Lanjut</a>
                        </div>
                    </div>
                    <div class="lecturer-card">
                        <div class="lecturer-card-img">
                            <img src="https://i.ibb.co/JtSDrQR/research-collaboration.jpg" alt="Kolaborasi penelitian antar dosen">
                        </div>
                        <div class="lecturer-card-content">
                            <h3 class="text-xl font-bold">Research Fellowship</h3>
                            <p>Program fellowship penelitian di universitas mitra internasional, memberikan kesempatan bagi dosen UNJ untuk melakukan riset kolaboratif bersama pakar global.</p>
                            <a href="#" class="lecturer-btn">Pelajari Lebih Lanjut</a>
                        </div>
                    </div>
                    <div class="lecturer-card">
                        <div class="lecturer-card-img">
                            <img src="https://i.ibb.co/QNpZtJF/academic-writing.jpg" alt="Pelatihan penulisan akademik">
                        </div>
                        <div class="lecturer-card-content">
                            <h3 class="text-xl font-bold">Academic Writing Support</h3>
                            <p>Program pendampingan penulisan artikel ilmiah dalam bahasa Inggris untuk publikasi di jurnal terindeks Scopus dan Web of Science, termasuk pelatihan dan layanan proofreading.</p>
                            <a href="#" class="lecturer-btn">Pelajari Lebih Lanjut</a>
                        </div>
                    </div>
                </div>
            </section>

            <section class="lecturer-section">
                <h2 class="lecturer-section-title text-3xl font-bold">Rangkaian Program Lecturer Expose</h2>
                
                <div class="lecturer-timeline">
                    <div class="lecturer-timeline-item lecturer-timeline-left">
                        <div class="lecturer-timeline-content">
                            <h3 class="font-bold text-teal-700 mb-2">Fase 1: Peningkatan Kapasitas</h3>
                            <p>Workshop dan pelatihan untuk meningkatkan kompetensi dosen dalam academic writing, research methodology, dan English for Academic Purposes.</p>
                        </div>
                    </div>
                    <div class="lecturer-timeline-item lecturer-timeline-right">
                        <div class="lecturer-timeline-content">
                            <h3 class="font-bold text-teal-700 mb-2">Fase 2: Kolaborasi Penelitian</h3>
                            <p>Membangun kolaborasi penelitian dengan universitas mitra internasional, termasuk joint supervision dan research exchange.</p>
                        </div>
                    </div>
                    <div class="lecturer-timeline-item lecturer-timeline-left">
                        <div class="lecturer-timeline-content">
                            <h3 class="font-bold text-teal-700 mb-2">Fase 3: Publikasi Internasional</h3>
                            <p>Pendampingan publikasi di jurnal terindeks Scopus dan Web of Science, termasuk mentoring oleh profesor dari universitas mitra.</p>
                        </div>
                    </div>
                    <div class="lecturer-timeline-item lecturer-timeline-right">
                        <div class="lecturer-timeline-content">
                            <h3 class="font-bold text-teal-700 mb-2">Fase 4: Diseminasi Ilmiah</h3>
                            <p>Partisipasi aktif di konferensi internasional sebagai presenter, pembicara utama, atau moderator panel diskusi.</p>
                        </div>
                    </div>
                    <div class="lecturer-timeline-item lecturer-timeline-left">
                        <div class="lecturer-timeline-content">
                            <h3 class="font-bold text-teal-700 mb-2">Fase 5: Mobilitas Global</h3>
                            <p>Program visiting professor dan academic exchange dengan universitas mitra di berbagai negara untuk transfer knowledge dan pengalaman.</p>
                        </div>
                    </div>
                </div>
            </section>

            <section class="lecturer-section">
                <h2 class="lecturer-section-title text-3xl font-bold">Program-Program Pendukung</h2>
                
                <div class="space-y-8 mt-6">
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-xl font-bold text-teal-700 mb-3">English Academic Writing Lab</h3>
                        <p class="mb-4">Laboratorium penulisan ilmiah dalam bahasa Inggris yang menyediakan dukungan teknis dan konsultasi bagi dosen dalam proses penulisan artikel untuk jurnal internasional.</p>
                        <div class="flex flex-wrap gap-2">
                            <span class="bg-teal-100 text-teal-800 px-3 py-1 rounded-full text-sm">Grammar Check</span>
                            <span class="bg-teal-100 text-teal-800 px-3 py-1 rounded-full text-sm">Proof-reading</span>
                            <span class="bg-teal-100 text-teal-800 px-3 py-1 rounded-full text-sm">Journal Selection</span>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-xl font-bold text-teal-700 mb-3">International Research Grant</h3>
                        <p class="mb-4">Bantuan pendanaan penelitian kolaboratif dengan mitra internasional untuk menghasilkan publikasi berkualitas tinggi dan memiliki dampak global.</p>
                        <div class="flex flex-wrap gap-2">
                            <span class="bg-teal-100 text-teal-800 px-3 py-1 rounded-full text-sm">Research Funding</span>
                            <span class="bg-teal-100 text-teal-800 px-3 py-1 rounded-full text-sm">International Collaboration</span>
                            <span class="bg-teal-100 text-teal-800 px-3 py-1 rounded-full text-sm">Impact Assessment</span>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-xl font-bold text-teal-700 mb-3">Scholarly Publication Incentive</h3>
                        <p class="mb-4">Program insentif untuk memotivasi dan menghargai dosen yang berhasil mempublikasikan karya ilmiah di jurnal internasional bereputasi tinggi.</p>
                        <div class="flex flex-wrap gap-2">
                            <span class="bg-teal-100 text-teal-800 px-3 py-1 rounded-full text-sm">Financial Reward</span>
                            <span class="bg-teal-100 text-teal-800 px-3 py-1 rounded-full text-sm">Academic Recognition</span>
                            <span class="bg-teal-100 text-teal-800 px-3 py-1 rounded-full text-sm">Career Advancement</span>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-xl font-bold text-teal-700 mb-3">Global Academic Networks</h3>
                        <p class="mb-4">Pengembangan jaringan akademik global melalui keanggotaan dalam asosiasi profesional internasional dan forum kolaborasi penelitian lintas negara.</p>
                        <div class="flex flex-wrap gap-2">
                            <span class="bg-teal-100 text-teal-800 px-3 py-1 rounded-full text-sm">Professional Memberships</span>
                            <span class="bg-teal-100 text-teal-800 px-3 py-1 rounded-full text-sm">Research Consortiums</span>
                            <span class="bg-teal-100 text-teal-800 px-3 py-1 rounded-full text-sm">Academic Collaborations</span>
                        </div>
                    </div>
                </div>
            </section>

            <section class="lecturer-section">
                <h2 class="lecturer-section-title text-3xl font-bold">Pencapaian Program</h2>
                
                <div class="lecturer-stats">
                    <div class="lecturer-stat">
                        <div class="lecturer-stat-number">120+</div>
                        <div class="lecturer-stat-title">Dosen Terlatih</div>
                    </div>
                    <div class="lecturer-stat">
                        <div class="lecturer-stat-number">85+</div>
                        <div class="lecturer-stat-title">Publikasi Scopus</div>
                    </div>
                    <div class="lecturer-stat">
                        <div class="lecturer-stat-number">45+</div>
                        <div class="lecturer-stat-title">Konferensi Internasional</div>
                    </div>
                    <div class="lecturer-stat">
                        <div class="lecturer-stat-number">30+</div>
                        <div class="lecturer-stat-title">Kolaborasi Penelitian</div>
                    </div>
                </div>
                
                <div class="mt-10">
                    <h3 class="text-xl font-bold text-teal-700 mb-4">Testimoni Peserta</h3>
                    
                    <div class="lecturer-testimonials">
                        <div class="lecturer-testimonial">
                            <div class="lecturer-testimonial-content">
                                <p class="italic text-gray-700">Program Lecturer Expose sangat membantu saya dalam mengembangkan keterampilan penulisan akademik dan memperluas jaringan penelitian internasional. Berkat program ini, artikel saya berhasil diterbitkan di jurnal Q1.</p>
                                <div class="lecturer-testimonial-author">
                                    <div class="lecturer-testimonial-avatar" style="background-image: url('https://i.ibb.co/WPFpxWk/lecturer-1.jpg');"></div>
                                    <div>
                                        <p class="font-bold">Dr. Anita Wijaya</p>
                                        <p class="text-sm text-gray-600">Fakultas Matematika dan IPA</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="lecturer-testimonial">
                            <div class="lecturer-testimonial-content">
                                <p class="italic text-gray-700">Kesempatan sebagai visiting researcher di National University of Singapore membuka wawasan baru dalam metodologi penelitian dan memungkinkan saya berkolaborasi dengan peneliti terkemuka di bidang saya.</p>
                                <div class="lecturer-testimonial-author">
                                    <div class="lecturer-testimonial-avatar" style="background-image: url('https://i.ibb.co/zRJThp3/lecturer-2.jpg');"></div>
                                    <div>
                                        <p class="font-bold">Prof. Dr. Budi Santoso</p>
                                        <p class="text-sm text-gray-600">Fakultas Teknik</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="bg-gradient-to-r from-teal-700 to-teal-800 text-white p-8 rounded-xl shadow-lg text-center">
                <h2 class="text-3xl font-bold mb-4">Bergabung dengan Program Lecturer Expose</h2>
                <p class="mb-6 max-w-3xl mx-auto">Kembangkan potensi akademik Anda dan berkontribusi dalam peningkatan reputasi global UNJ melalui program Lecturer Expose yang komprehensif.</p>
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="#" class="bg-white text-teal-800 px-6 py-3 rounded-lg font-medium transition-all duration-300 hover:bg-yellow-400 hover:text-teal-900">Daftar Program</a>
                    <a href="#" class="bg-white text-teal-800 px-6 py-3 rounded-lg font-medium transition-all duration-300 hover:bg-yellow-400 hover:text-teal-900">Jadwal Pelatihan</a>
                    <a href="#" class="bg-white text-teal-800 px-6 py-3 rounded-lg font-medium transition-all duration-300 hover:bg-yellow-400 hover:text-teal-900">FAQ</a>
                </div>
            </section>
        </div>
    </div>
    
    @include('layout.footer')
</body>
</html>