<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Global Engagement DITISIP</title>
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
        
        .global-page {
            --primary-color: #186862;
            --secondary-color: #125a54;
            --accent-color: #facc15;
            --light-color: #ecf0f1;
            --dark-color: #34495e;
        }

        .global-hero {
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('https://media.quipper.com/media/W1siZiIsIjIwMTgvMDEvMjMvMDkvNDMvMjcvYWVjNTQ1OTctOTJiNi00Y2EyLWEzZDctMGZiNTg1ZTU1MDEzLyJdLFsicCIsInRodW1iIiwiMTIwMHhcdTAwM2UiLHt9XSxbInAiLCJjb252ZXJ0IiwiLWNvbG9yc3BhY2Ugc1JHQiAtc3RyaXAiLHsiZm9ybWF0IjoianBnIn1dXQ?sha=9c61a35270604434') center/cover no-repeat;
            height: 400px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-align: center;
            position: relative;
            margin-bottom: 3rem;
        }

        .global-hero-content {
            max-width: 800px;
            padding: 2rem;
        }

        .global-section {
            background-color: white;
            padding: 2.5rem;
            margin-bottom: 2rem;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .global-section-title {
            color: var(--primary-color);
            margin-bottom: 1.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid var(--primary-color);
        }

        .global-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-top: 2.5rem;
        }

        .global-card {
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .global-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }

        .global-card-img {
            height: 200px;
            position: relative;
            overflow: hidden;
        }

        .global-card-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .global-card:hover .global-card-img img {
            transform: scale(1.05);
        }

        .global-card-content {
            padding: 1.5rem;
        }

        .global-card h3 {
            color: var(--primary-color);
            margin-bottom: 1rem;
        }

        .global-btn {
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

        .global-btn:hover {
            background-color: var(--secondary-color);
        }

        .global-partners {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 2rem;
        }

        .global-partner {
            background-color: white;
            padding: 1.5rem;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease;
        }

        .global-partner:hover {
            transform: translateY(-5px);
        }

        .global-partner-logo {
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
        }

        .global-partner-logo img {
            max-height: 60px;
            max-width: 100%;
        }

        .global-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }

        .global-stat {
            background-color: white;
            padding: 1.5rem;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .global-stat-number {
            font-size: 2.5rem;
            font-weight: bold;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }

        .global-stat-title {
            color: var(--secondary-color);
            font-weight: 500;
        }

        @media (max-width: 768px) {
            .global-hero {
                height: 300px;
            }

            .global-hero h2 {
                font-size: 1.8rem;
            }
            
            .global-section {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>
    @include('layout.navbarpemeringkatan')

    <div class="global-page">
        <div class="global-hero">
            <div class="global-hero-content">
                <h2 class="text-4xl font-bold mb-4">Global Engagement</h2>
                <p class="text-xl">Membangun kemitraan internasional dan meningkatkan kolaborasi global untuk memperkuat reputasi akademik Universitas Negeri Jakarta di kancah dunia.</p>
            </div>
        </div>

        <div class="container mx-auto px-6 py-8">
            <section class="global-section">
                <h2 class="global-section-title text-3xl font-bold">Tentang Global Engagement</h2>
                <p class="mb-4">Program Global Engagement UNJ merupakan inisiatif strategis untuk memperluas jejaring dan kolaborasi internasional universitas, meningkatkan visibilitas global, dan memperkuat posisi UNJ dalam peringkat universitas dunia.</p>
                <p>Melalui program ini, UNJ mengembangkan kemitraan dengan universitas terkemuka di seluruh dunia, mendorong pertukaran akademik, penelitian kolaboratif, dan berbagai bentuk kerja sama yang mendukung internasionalisasi pendidikan tinggi.</p>
            </section>

            <section class="global-section">
                <h2 class="global-section-title text-3xl font-bold">Fokus Utama</h2>
                
                <div class="global-cards">
                    <div class="global-card">
                        <div class="global-card-img">
                            <img src="https://i.pinimg.com/originals/32/b5/51/32b551e34c4af91a73c228bdb7184306.jpg" alt="Mahasiswa UNJ berkolaborasi dengan mahasiswa internasional">
                        </div>
                        <div class="global-card-content">
                            <h3 class="text-xl font-bold">Mobilitas Internasional</h3>
                            <p>Program pertukaran mahasiswa dan dosen dengan universitas mitra di berbagai negara untuk memperluas wawasan global dan pengalaman lintas budaya.</p>
                            <a href="#" class="global-btn">Pelajari Lebih Lanjut</a>
                        </div>
                    </div>
                    <div class="global-card">
                        <div class="global-card-img">
                            <img src="https://media.istockphoto.com/id/1218961153/photo/female-asian-college-student-speaking-at-education-conference.jpg?s=612x612&w=0&k=20&c=7Y0R0-kFiSgRUXXcvLbTBfuSzXRIQEQ5aiVNZF53oK4=" alt="Konferensi internasional di UNJ">
                        </div>
                        <div class="global-card-content">
                            <h3 class="text-xl font-bold">Konferensi & Seminar Internasional</h3>
                            <p>Penyelenggaraan forum ilmiah bertaraf internasional untuk memfasilitasi pertukaran pengetahuan dan membangun jaringan akademik global.</p>
                            <a href="#" class="global-btn">Pelajari Lebih Lanjut</a>
                        </div>
                    </div>
                    <div class="global-card">
                        <div class="global-card-img">
                            <img src="https://i.pinimg.com/736x/18/65/e5/1865e59f7b88116ca41f1469c77fc73b.jpg" alt="Peneliti UNJ berkolaborasi dengan peneliti internasional">
                        </div>
                        <div class="global-card-content">
                            <h3 class="text-xl font-bold">Penelitian Kolaboratif</h3>
                            <p>Kerja sama penelitian dengan mitra internasional untuk menghasilkan publikasi bersama dan inovasi yang memiliki dampak global.</p>
                            <a href="#" class="global-btn">Pelajari Lebih Lanjut</a>
                        </div>
                    </div>
                </div>
            </section>

            <section class="global-section">
                <h2 class="global-section-title text-3xl font-bold">Program Unggulan</h2>
                
                <div class="space-y-8">
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-xl font-bold text-teal-700 mb-3">UNJ International Student Exchange Program</h3>
                        <p class="mb-4">Program pertukaran mahasiswa yang memberikan kesempatan bagi mahasiswa UNJ untuk belajar di universitas mitra di luar negeri selama 1-2 semester, serta menerima mahasiswa internasional untuk belajar di UNJ.</p>
                        <div class="flex flex-wrap gap-2">
                            <span class="bg-teal-100 text-teal-800 px-3 py-1 rounded-full text-sm">Pertukaran Mahasiswa</span>
                            <span class="bg-teal-100 text-teal-800 px-3 py-1 rounded-full text-sm">Credit Transfer</span>
                            <span class="bg-teal-100 text-teal-800 px-3 py-1 rounded-full text-sm">Cultural Immersion</span>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-xl font-bold text-teal-700 mb-3">Global Faculty Development</h3>
                        <p class="mb-4">Program pengembangan kapasitas dosen melalui visiting professor, joint supervision, dan sabbatical leave di universitas mitra internasional untuk meningkatkan kualitas pengajaran dan penelitian.</p>
                        <div class="flex flex-wrap gap-2">
                            <span class="bg-teal-100 text-teal-800 px-3 py-1 rounded-full text-sm">Visiting Professor</span>
                            <span class="bg-teal-100 text-teal-800 px-3 py-1 rounded-full text-sm">Joint Research</span>
                            <span class="bg-teal-100 text-teal-800 px-3 py-1 rounded-full text-sm">Capacity Building</span>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-xl font-bold text-teal-700 mb-3">International Joint Publication Program</h3>
                        <p class="mb-4">Inisiatif untuk mendorong publikasi internasional bersama antara peneliti UNJ dan mitra global di jurnal terindeks Scopus dan Web of Science untuk meningkatkan visibilitas penelitian UNJ.</p>
                        <div class="flex flex-wrap gap-2">
                            <span class="bg-teal-100 text-teal-800 px-3 py-1 rounded-full text-sm">Joint Publication</span>
                            <span class="bg-teal-100 text-teal-800 px-3 py-1 rounded-full text-sm">Scopus/WoS</span>
                            <span class="bg-teal-100 text-teal-800 px-3 py-1 rounded-full text-sm">Citation Impact</span>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-xl font-bold text-teal-700 mb-3">UNJ International Summer School</h3>
                        <p class="mb-4">Program intensif yang menawarkan kursus singkat dengan tema khusus bagi mahasiswa internasional, sekaligus memperkenalkan budaya Indonesia sebagai bagian dari soft diplomacy.</p>
                        <div class="flex flex-wrap gap-2">
                            <span class="bg-teal-100 text-teal-800 px-3 py-1 rounded-full text-sm">Short Course</span>
                            <span class="bg-teal-100 text-teal-800 px-3 py-1 rounded-full text-sm">Cultural Experience</span>
                            <span class="bg-teal-100 text-teal-800 px-3 py-1 rounded-full text-sm">International Networking</span>
                        </div>
                    </div>
                </div>
            </section>

            <section class="global-section">
                <h2 class="global-section-title text-3xl font-bold">Mitra Internasional</h2>
                <p class="mb-6">UNJ telah menjalin kerja sama dengan berbagai universitas dan institusi terkemuka di seluruh dunia:</p>
                
                <div class="global-partners">
                    <div class="global-partner">
                        <div class="global-partner-logo">
                            <i class="fas fa-university text-5xl text-teal-700"></i>
                        </div>
                        <h3 class="font-bold text-teal-700">University of Melbourne</h3>
                        <p class="text-sm text-gray-600">Australia</p>
                    </div>
                    <div class="global-partner">
                        <div class="global-partner-logo">
                            <i class="fas fa-university text-5xl text-teal-700"></i>
                        </div>
                        <h3 class="font-bold text-teal-700">Universiti Malaya</h3>
                        <p class="text-sm text-gray-600">Malaysia</p>
                    </div>
                    <div class="global-partner">
                        <div class="global-partner-logo">
                            <i class="fas fa-university text-5xl text-teal-700"></i>
                        </div>
                        <h3 class="font-bold text-teal-700">Kyoto University</h3>
                        <p class="text-sm text-gray-600">Jepang</p>
                    </div>
                    <div class="global-partner">
                        <div class="global-partner-logo">
                            <i class="fas fa-university text-5xl text-teal-700"></i>
                        </div>
                        <h3 class="font-bold text-teal-700">National Taiwan University</h3>
                        <p class="text-sm text-gray-600">Taiwan</p>
                    </div>
                    <div class="global-partner">
                        <div class="global-partner-logo">
                            <i class="fas fa-university text-5xl text-teal-700"></i>
                        </div>
                        <h3 class="font-bold text-teal-700">King Mongkut's University</h3>
                        <p class="text-sm text-gray-600">Thailand</p>
                    </div>
                    <div class="global-partner">
                        <div class="global-partner-logo">
                            <i class="fas fa-university text-5xl text-teal-700"></i>
                        </div>
                        <h3 class="font-bold text-teal-700">University of Southampton</h3>
                        <p class="text-sm text-gray-600">Inggris</p>
                    </div>
                </div>
            </section>

            <section class="global-section">
                <h2 class="global-section-title text-3xl font-bold">Pencapaian</h2>
                
                <div class="global-stats">
                    <div class="global-stat">
                        <div class="global-stat-number">50+</div>
                        <div class="global-stat-title">Universitas Mitra</div>
                    </div>
                    <div class="global-stat">
                        <div class="global-stat-number">200+</div>
                        <div class="global-stat-title">Mahasiswa Pertukaran</div>
                    </div>
                    <div class="global-stat">
                        <div class="global-stat-number">75+</div>
                        <div class="global-stat-title">Publikasi Internasional</div>
                    </div>
                    <div class="global-stat">
                        <div class="global-stat-number">30+</div>
                        <div class="global-stat-title">Negara Mitra</div>
                    </div>
                </div>
                
                <div class="mt-8">
                    <h3 class="text-xl font-bold text-teal-700 mb-4">Highlight Prestasi</h3>
                    <ul class="space-y-3">
                        <li class="flex items-start">
                            <i class="fas fa-award text-yellow-500 mt-1 mr-3"></i>
                            <p>Peningkatan peringkat UNJ dalam QS World University Rankings berkat penguatan jaringan akademik global</p>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-award text-yellow-500 mt-1 mr-3"></i>
                            <p>Penyelenggaraan 5 konferensi internasional terindeks Scopus dalam 3 tahun terakhir</p>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-award text-yellow-500 mt-1 mr-3"></i>
                            <p>Peningkatan jumlah mahasiswa internasional sebesar 35% dalam 2 tahun terakhir</p>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-award text-yellow-500 mt-1 mr-3"></i>
                            <p>Penandatanganan 15 MoU baru dengan universitas top 500 dunia</p>
                        </li>
                    </ul>
                </div>
            </section>

            <section class="bg-gradient-to-r from-teal-700 to-teal-800 text-white p-8 rounded-xl shadow-lg text-center">
                <h2 class="text-3xl font-bold mb-4">Bergabunglah dengan Program Global Engagement</h2>
                <p class="mb-6 max-w-3xl mx-auto">Jika Anda tertarik untuk berpartisipasi dalam program-program global engagement UNJ, silakan hubungi kami untuk informasi lebih lanjut.</p>
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="#" class="bg-white text-teal-800 px-6 py-3 rounded-lg font-medium transition-all duration-300 hover:bg-yellow-400 hover:text-teal-900">Program Mahasiswa</a>
                    <a href="#" class="bg-white text-teal-800 px-6 py-3 rounded-lg font-medium transition-all duration-300 hover:bg-yellow-400 hover:text-teal-900">Program Dosen</a>
                    <a href="#" class="bg-white text-teal-800 px-6 py-3 rounded-lg font-medium transition-all duration-300 hover:bg-yellow-400 hover:text-teal-900">Kemitraan Institusi</a>
                </div>
            </section>
        </div>
    </div>
    
    @include('layout.footer')
</body>
</html>