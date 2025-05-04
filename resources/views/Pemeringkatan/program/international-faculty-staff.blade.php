<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>International Faculty Staff DITISIP</title>
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
        
        .faculty-page {
            --primary-color: #186862;
            --secondary-color: #125a54;
            --accent-color: #facc15;
            --light-color: #ecf0f1;
            --dark-color: #34495e;
        }

        .faculty-hero {
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('https://i.ibb.co/5rvZ2Lr/international-faculty.jpg') center/cover no-repeat;
            height: 400px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-align: center;
            position: relative;
            margin-bottom: 3rem;
        }

        .faculty-hero-content {
            max-width: 800px;
            padding: 2rem;
        }

        .faculty-section {
            background-color: white;
            padding: 2.5rem;
            margin-bottom: 2rem;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .faculty-section-title {
            color: var(--primary-color);
            margin-bottom: 1.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid var(--primary-color);
        }

        .faculty-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-top: 2.5rem;
        }

        .faculty-card {
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .faculty-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }

        .faculty-card-img {
            height: 200px;
            position: relative;
            overflow: hidden;
        }

        .faculty-card-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .faculty-card:hover .faculty-card-img img {
            transform: scale(1.05);
        }

        .faculty-card-content {
            padding: 1.5rem;
        }

        .faculty-card h3 {
            color: var(--primary-color);
            margin-bottom: 1rem;
        }

        .faculty-btn {
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

        .faculty-btn:hover {
            background-color: var(--secondary-color);
        }

        .faculty-profile {
            display: flex;
            flex-direction: column;
            margin-bottom: 2rem;
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .faculty-profile-header {
            display: flex;
            align-items: center;
            padding: 1.5rem;
            border-bottom: 1px solid #e2e8f0;
        }

        .faculty-profile-avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            overflow: hidden;
            margin-right: 1.5rem;
            flex-shrink: 0;
        }

        .faculty-profile-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .faculty-profile-info {
            flex: 1;
        }

        .faculty-profile-name {
            font-size: 1.5rem;
            font-weight: bold;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }

        .faculty-profile-position {
            color: #4a5568;
            margin-bottom: 0.5rem;
        }

        .faculty-profile-origin {
            display: flex;
            align-items: center;
            color: #4a5568;
        }

        .faculty-profile-origin img {
            width: 20px;
            height: 15px;
            margin-right: 0.5rem;
        }

        .faculty-profile-body {
            padding: 1.5rem;
        }

        .faculty-profile-section {
            margin-bottom: 1.5rem;
        }

        .faculty-profile-section-title {
            font-weight: bold;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }

        .faculty-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }

        .faculty-stat {
            background-color: white;
            padding: 1.5rem;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .faculty-stat-number {
            font-size: 2.5rem;
            font-weight: bold;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }

        .faculty-stat-title {
            color: var(--secondary-color);
            font-weight: 500;
        }

        .faculty-benefits {
            margin-top: 2rem;
        }

        .faculty-benefit {
            display: flex;
            align-items: flex-start;
            margin-bottom: 1.5rem;
        }

        .faculty-benefit-icon {
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: var(--primary-color);
            color: white;
            border-radius: 50%;
            margin-right: 1rem;
            flex-shrink: 0;
        }

        .faculty-benefit-content {
            flex: 1;
        }

        .faculty-benefit-title {
            font-weight: bold;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }

        .faculty-process {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            margin-top: 2rem;
        }

        .faculty-process-step {
            flex: 1;
            min-width: 250px;
            margin: 1rem;
            padding: 1.5rem;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        .faculty-process-step-number {
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

        .faculty-process-step-title {
            font-weight: bold;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }

        @media (max-width: 768px) {
            .faculty-hero {
                height: 300px;
            }

            .faculty-hero h2 {
                font-size: 1.8rem;
            }
            
            .faculty-section {
                padding: 1.5rem;
            }

            .faculty-profile-header {
                flex-direction: column;
                text-align: center;
            }

            .faculty-profile-avatar {
                margin-right: 0;
                margin-bottom: 1rem;
            }
        }
    </style>
</head>
<body>
    @include('layout.navbarpemeringkatan')

    <div class="faculty-page pt-16">
        <div class="faculty-hero">
            <div class="faculty-hero-content">
                <h2 class="text-4xl font-bold mb-4">International Faculty Staff</h2>
                <p class="text-xl">Program pertukaran dan kolaborasi staf pengajar internasional untuk meningkatkan kualitas pendidikan dan memperkuat budaya internasional di lingkungan Universitas Negeri Jakarta.</p>
            </div>
        </div>

        <div class="container mx-auto px-6 py-8">
            <section class="faculty-section">
                <h2 class="faculty-section-title text-3xl font-bold">Tentang International Faculty Staff</h2>
                <p class="mb-4">Program International Faculty Staff merupakan inisiatif strategis UNJ untuk memperkaya lingkungan akademik melalui kehadiran tenaga pengajar internasional. Program ini memberikan kesempatan bagi UNJ untuk mendatangkan pengajar berkualitas dari berbagai negara sekaligus mengembangkan kapasitas staf pengajar lokal melalui pertukaran pengetahuan dan budaya.</p>
                <p>Melalui program ini, UNJ berupaya menciptakan lingkungan akademik yang lebih global, meningkatkan kemampuan bahasa asing civitas akademika, dan memperkenalkan perspektif internasional dalam proses pembelajaran dan penelitian.</p>
            </section>

            <section class="faculty-section">
                <h2 class="faculty-section-title text-3xl font-bold">Jenis Program</h2>
                
                <div class="faculty-cards">
                    <div class="faculty-card">
                        <div class="faculty-card-img">
                            <img src="https://i.ibb.co/TqLnQZp/visiting-professor.jpg" alt="Visiting Professor mengajar di kelas">
                        </div>
                        <div class="faculty-card-content">
                            <h3 class="text-xl font-bold">Visiting Professor Program</h3>
                            <p>Program yang mendatangkan profesor dari universitas mitra luar negeri untuk memberikan kuliah, melakukan penelitian bersama, dan membangun kerja sama akademik selama 1-3 bulan.</p>
                            <a href="#" class="faculty-btn">Pelajari Lebih Lanjut</a>
                        </div>
                    </div>
                    <div class="faculty-card">
                        <div class="faculty-card-img">
                            <img src="https://i.ibb.co/hFw71Sp/international-lecturer.jpg" alt="International Lecturer berdiskusi dengan mahasiswa">
                        </div>
                        <div class="faculty-card-content">
                            <h3 class="text-xl font-bold">Full-time International Lecturer</h3>
                            <p>Rekrutmen dosen tetap dari berbagai negara untuk memperkuat kurikulum internasional dan menciptakan lingkungan pembelajaran multikultural di kampus UNJ.</p>
                            <a href="#" class="faculty-btn">Pelajari Lebih Lanjut</a>
                        </div>
                    </div>
                    <div class="faculty-card">
                        <div class="faculty-card-img">
                            <img src="https://i.ibb.co/3YHdggL/expert-exchange.jpg" alt="Expert Exchange Program dengan dosen luar negeri">
                        </div>
                        <div class="faculty-card-content">
                            <h3 class="text-xl font-bold">Expert Exchange Program</h3>
                            <p>Program pertukaran staf akademik dengan universitas mitra luar negeri, memberikan kesempatan bagi dosen UNJ untuk mengajar di luar negeri dan menerima dosen dari universitas mitra.</p>
                            <a href="#" class="faculty-btn">Pelajari Lebih Lanjut</a>
                        </div>
                    </div>
                </div>
            </section>

            <section class="faculty-section">
                <h2 class="faculty-section-title text-3xl font-bold">Staf Pengajar Internasional</h2>
                <p class="mb-6">UNJ dengan bangga telah menjalin kerja sama dengan berbagai tenaga pengajar internasional yang berkontribusi pada pengembangan kualitas pendidikan:</p>
                
                <div class="space-y-6">
                    <div class="faculty-profile">
                        <div class="faculty-profile-header">
                            <div class="faculty-profile-avatar">
                                <img src="https://i.ibb.co/0QF0KBw/prof-sarah.jpg" alt="Prof. Sarah Johnson">
                            </div>
                            <div class="faculty-profile-info">
                                <div class="faculty-profile-name">Prof. Sarah Johnson, Ph.D</div>
                                <div class="faculty-profile-position">Visiting Professor - Educational Technology</div>
                                <div class="faculty-profile-origin">
                                    <img src="https://cdn.countryflags.com/thumbs/united-states-of-america/flag-400.png" alt="USA Flag">
                                    <span>Massachusetts Institute of Technology (MIT), USA</span>
                                </div>
                            </div>
                        </div>
                        <div class="faculty-profile-body">
                            <div class="faculty-profile-section">
                                <div class="faculty-profile-section-title">Bidang Keahlian</div>
                                <p>Instructional Design, Learning Analytics, Artificial Intelligence in Education</p>
                            </div>
                            <div class="faculty-profile-section">
                                <div class="faculty-profile-section-title">Kegiatan di UNJ</div>
                                <p>Mengajar mata kuliah Educational Technology Innovation, memberikan workshop untuk dosen UNJ, dan memimpin proyek penelitian tentang adaptif learning.</p>
                            </div>
                            <div class="faculty-profile-section">
                                <div class="faculty-profile-section-title">Testimonial</div>
                                <p class="italic">"Pengalaman mengajar di UNJ sangat berharga. Para mahasiswa sangat antusias dan ingin belajar. Saya melihat potensi besar untuk mengembangkan kolaborasi riset jangka panjang antara MIT dan UNJ."</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="faculty-profile">
                        <div class="faculty-profile-header">
                            <div class="faculty-profile-avatar">
                                <img src="https://i.ibb.co/0MzvbgF/dr-takashi.jpg" alt="Dr. Takashi Yamamoto">
                            </div>
                            <div class="faculty-profile-info">
                                <div class="faculty-profile-name">Dr. Takashi Yamamoto</div>
                                <div class="faculty-profile-position">Full-time International Lecturer - Environmental Science</div>
                                <div class="faculty-profile-origin">
                                    <img src="https://cdn.countryflags.com/thumbs/japan/flag-400.png" alt="Japan Flag">
                                    <span>Kyoto University, Japan</span>
                                </div>
                            </div>
                        </div>
                        <div class="faculty-profile-body">
                            <div class="faculty-profile-section">
                                <div class="faculty-profile-section-title">Bidang Keahlian</div>
                                <p>Climate Change Adaptation, Sustainable Urban Development, Environmental Impact Assessment</p>
                            </div>
                            <div class="faculty-profile-section">
                                <div class="faculty-profile-section-title">Kegiatan di UNJ</div>
                                <p>Mengajar mata kuliah Environmental Science, membimbing penelitian mahasiswa S2 dan S3, serta memimpin proyek penelitian kolaboratif UNJ-Kyoto University tentang urban sustainability.</p>
                            </div>
                            <div class="faculty-profile-section">
                                <div class="faculty-profile-section-title">Testimonial</div>
                                <p class="italic">"Jakarta adalah laboratorium yang sempurna untuk studi kasus adaptasi perubahan iklim perkotaan. Kolaborasi dengan akademisi UNJ telah membuka wawasan baru dan pendekatan lokal yang sangat berharga bagi penelitian saya."</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="faculty-section">
                <h2 class="faculty-section-title text-3xl font-bold">Manfaat Program</h2>
                
                <div class="faculty-benefits">
                    <div class="faculty-benefit">
                        <div class="faculty-benefit-icon">
                            <i class="fas fa-globe-asia"></i>
                        </div>
                        <div class="faculty-benefit-content">
                            <div class="faculty-benefit-title">Lingkungan Akademik Internasional</div>
                            <p>Menciptakan suasana belajar multikultural yang memperluas wawasan dan perspektif mahasiswa serta dosen UNJ dalam memahami isu-isu global.</p>
                        </div>
                    </div>
                    <div class="faculty-benefit">
                        <div class="faculty-benefit-icon">
                            <i class="fas fa-language"></i>
                        </div>
                        <div class="faculty-benefit-content">
                            <div class="faculty-benefit-title">Peningkatan Kemampuan Bahasa</div>
                            <p>Memberikan kesempatan praktik komunikasi dalam bahasa asing (terutama Bahasa Inggris) secara langsung dalam konteks akademik.</p>
                        </div>
                    </div>
                    <div class="faculty-benefit">
                        <div class="faculty-benefit-icon">
                            <i class="fas fa-handshake"></i>
                        </div>
                        <div class="faculty-benefit-content">
                            <div class="faculty-benefit-title">Kolaborasi Penelitian Internasional</div>
                            <p>Membuka akses untuk melakukan penelitian bersama dengan institusi bergengsi dunia, meningkatkan kualitas dan visibilitas publikasi ilmiah UNJ.</p>
                        </div>
                    </div>
                    <div class="faculty-benefit">
                        <div class="faculty-benefit-icon">
                            <i class="fas fa-chalkboard-teacher"></i>
                        </div>
                        <div class="faculty-benefit-content">
                            <div class="faculty-benefit-title">Transfer Pengetahuan & Metodologi</div>
                            <p>Memfasilitasi pertukaran metode pengajaran, pendekatan penelitian, dan pengetahuan terkini dari universitas terkemuka dunia.</p>
                        </div>
                    </div>
                    <div class="faculty-benefit">
                        <div class="faculty-benefit-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="faculty-benefit-content">
                            <div class="faculty-benefit-title">Peningkatan Reputasi & Peringkat UNJ</div>
                            <p>Meningkatkan parameter internasionalisasi yang menjadi indikator penting dalam pemeringkatan universitas global.</p>
                        </div>
                    </div>
                </div>
            </section>

            <section class="faculty-section">
                <h2 class="faculty-section-title text-3xl font-bold">Proses Rekrutmen & Seleksi</h2>
                
                <div class="faculty-process">
                    <div class="faculty-process-step">
                        <div class="faculty-process-step-number">1</div>
                        <div class="faculty-process-step-title">Identifikasi Kebutuhan</div>
                        <p>Analisis kebutuhan pengajar internasional berdasarkan program studi, kurikulum, dan rencana strategis pengembangan UNJ.</p>
                    </div>
                    <div class="faculty-process-step">
                        <div class="faculty-process-step-number">2</div>
                        <div class="faculty-process-step-title">Publikasi Lowongan</div>
                        <p>Pengumuman rekrutmen melalui jaringan universitas mitra, portal akademik internasional, dan asosiasi profesional global.</p>
                    </div>
                    <div class="faculty-process-step">
                        <div class="faculty-process-step-number">3</div>
                        <div class="faculty-process-step-title">Seleksi Kandidat</div>
                        <p>Proses evaluasi kandidat berdasarkan kualifikasi akademik, pengalaman mengajar, publikasi ilmiah, dan profil penelitian.</p>
                    </div>
                    <div class="faculty-process-step">
                        <div class="faculty-process-step-number">4</div>
                        <div class="faculty-process-step-title">Wawancara & Demo Mengajar</div>
                        <p>Asesmen kemampuan pengajaran dan komunikasi kandidat melalui wawancara dan demonstrasi mengajar virtual/tatap muka.</p>
                    </div>
                    <div class="faculty-process-step">
                        <div class="faculty-process-step-number">5</div>
                        <div class="faculty-process-step-title">Onboarding & Orientasi</div>
                        <p>Program pengenalan UNJ, sistem akademik, budaya Indonesia, dan dukungan adaptasi kehidupan di Jakarta.</p>
                    </div>
                </div>
            </section>

            <section class="faculty-section">
                <h2 class="faculty-section-title text-3xl font-bold">Pencapaian Program</h2>
                
                <div class="faculty-stats">
                    <div class="faculty-stat">
                        <div class="faculty-stat-number">25+</div>
                        <div class="faculty-stat-title">Visiting Professors</div>
                    </div>
                    <div class="faculty-stat">
                        <div class="faculty-stat-number">12</div>
                        <div class="faculty-stat-title">Full-time Int'l Lecturers</div>
                    </div>
                    <div class="faculty-stat">
                        <div class="faculty-stat-number">18</div>
                        <div class="faculty-stat-title">Negara Asal</div>
                    </div>
                    <div class="faculty-stat">
                        <div class="faculty-stat-number">40+</div>
                        <div class="faculty-stat-title">Publikasi Kolaboratif</div>
                    </div>
                </div>
                
                <div class="mt-8">
                    <h3 class="text-xl font-bold text-teal-700 mb-4">Dampak pada UNJ</h3>
                    <ul class="space-y-3">
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-teal-600 mt-1 mr-3"></i>
                            <p>Peningkatan parameter internasionalisasi dalam pemeringkatan QS World University Rankings</p>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-teal-600 mt-1 mr-3"></i>
                            <p>Peningkatan jumlah matakuliah yang disampaikan dalam Bahasa Inggris dari 15 menjadi 47 matakuliah</p>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-teal-600 mt-1 mr-3"></i>
                            <p>Bertambahnya jumlah mahasiswa internasional sebesar 35% berkat ketersediaan program dengan pengajar internasional</p>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-teal-600 mt-1 mr-3"></i>
                            <p>Pengembangan 8 program kerja sama double degree dan joint degree dengan universitas mitra</p>
                        </li>
                    </ul>
                </div>
            </section>

            <section class="bg-gradient-to-r from-teal-700 to-teal-800 text-white p-8 rounded-xl shadow-lg text-center">
                <h2 class="text-3xl font-bold mb-4">Tertarik untuk Berkolaborasi?</h2>
                <p class="mb-6 max-w-3xl mx-auto">UNJ selalu terbuka untuk menjalin kerja sama dengan akademisi dan institusi pendidikan tinggi dari seluruh dunia. Bergabunglah dengan komunitas akademik kami dan jadilah bagian dari perjalanan UNJ menuju world-class university.</p>
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="#" class="bg-white text-teal-800 px-6 py-3 rounded-lg font-medium transition-all duration-300 hover:bg-yellow-400 hover:text-teal-900">Informasi Rekrutmen</a>
                    <a href="#" class="bg-white text-teal-800 px-6 py-3 rounded-lg font-medium transition-all duration-300 hover:bg-yellow-400 hover:text-teal-900">Institutional Partnership</a>
                    <a href="#" class="bg-white text-teal-800 px-6 py-3 rounded-lg font-medium transition-all duration-300 hover:bg-yellow-400 hover:text-teal-900">Hubungi Kami</a>
                </div>
            </section>
        </div>
    </div>
    
    @include('layout.footer')
</body>
</html>