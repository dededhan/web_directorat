<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>International Faculty Staff DITISIP</title>
    <link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" type="image/png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <style>
        :root {
            --primary-color: #186862;
            --secondary-color: #125a54;
            --accent-color: #facc15;
            --light-color: #f8fafc;
            --dark-color: #1e293b;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f9f8;
            color: #334155;
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: var(--secondary-color);
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .btn-secondary {
            background-color: white;
            color: var(--primary-color);
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 500;
            transition: all 0.3s ease;
            border: 2px solid var(--primary-color);
        }

        .btn-secondary:hover {
            background-color: var(--light-color);
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .section-title {
            position: relative;
            color: var(--primary-color);
            font-weight: 700;
            margin-bottom: 2rem;
            padding-bottom: 0.75rem;
        }

        .section-title::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            height: 3px;
            width: 60px;
            background-color: var(--accent-color);
        }

        .card {
            background-color: white;
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -2px rgba(0, 0, 0, 0.025);
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .faculty-hero {
            background: linear-gradient(rgba(24, 104, 98, 0.85), rgba(18, 90, 84, 0.9)), url('https://i.ibb.co/5rvZ2Lr/international-faculty.jpg') center/cover no-repeat;
            min-height: 500px;
        }

        .faculty-profile {
            transition: all 0.3s ease;
        }

        .faculty-profile:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .faculty-profile-avatar {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            width: 70px;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            color: white;
            font-size: 1.5rem;
        }

        .faculty-tag {
            background-color: #e6f7f5;
            color: var(--primary-color);
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            display: inline-block;
            margin-right: 0.5rem;
            margin-bottom: 0.5rem;
            font-weight: 500;
        }

        .stat-card {
            background-color: white;
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            text-align: center;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
        }

        .process-card {
            position: relative;
            background-color: white;
            border-radius: 1rem;
            padding: 2rem 1.5rem 1.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            margin-top: 1.5rem;
        }

        .process-number {
            position: absolute;
            top: -20px;
            left: 20px;
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .benefit-card {
            display: flex;
            background-color: white;
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            margin-bottom: 1.5rem;
            transition: all 0.3s ease;
        }

        .benefit-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
        }

        .benefit-icon {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            margin-right: 1rem;
            flex-shrink: 0;
        }

        .country-flag {
            width: 24px;
            height: 18px;
            border-radius: 3px;
            margin-right: 0.5rem;
            object-fit: cover;
        }

        .filter-btn {
            background-color: white;
            border: 1px solid #e2e8f0;
            color: #64748b;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            font-size: 0.9rem;
            transition: all 0.2s ease;
        }

        .filter-btn:hover,
        .filter-btn.active {
            background-color: var(--primary-color);
            color: white;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .faculty-hero {
                min-height: 400px;
            }

            .benefit-card {
                flex-direction: column;
            }

            .benefit-icon {
                margin-right: 0;
                margin-bottom: 1rem;
            }
        }
    </style>
    @include('layout.navbarpemeringkatan')
</head>

<body class="min-h-screen">
    <!-- Navigation placeholder -->


    <div class="pt-16"> <!-- Padding for fixed navbar -->
        <!-- Hero Section -->
        <section class="faculty-hero flex items-center justify-center text-center text-white">
            <div class="container mx-auto px-6 py-20">
                <div>
                    <h1 class="text-4xl md:text-5xl font-bold mb-6">International Faculty Staff</h1>
                    <p class="text-xl max-w-3xl mx-auto opacity-90">Program pertukaran dan kolaborasi staf pengajar
                        internasional untuk meningkatkan kualitas pendidikan dan memperkuat budaya internasional di
                        lingkungan Universitas Negeri Jakarta.</p>
                    <div class="mt-8 flex flex-wrap justify-center gap-4">
                        <a href="#about" class="btn-primary flex items-center">
                            <span>Pelajari Lebih Lanjut</span>
                            <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                        <a href="#professors" class="btn-secondary flex items-center">
                            <span>Lihat Profesor</span>
                            <i class="fas fa-users ml-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main Content -->
        <div class="container mx-auto px-6 py-16">
            <div class="container mx-auto">
                <section class="faculty-section">
                    <img src="{{ asset('images/Lecturer.png') }}" alt="International Faculty Staff" class="w-full">
                </section>
            </div>

            <!-- Program Types -->
            <section id="programs" class="mt-10 mb-20">
                <h2 class="section-title text-3xl">Jenis Program</h2>
                <div class="grid md:grid-cols-3 gap-8">
                    <!-- Program Card 1 -->
                    <div class="card group">
                        <div class="h-48 overflow-hidden relative">
                            <img src="https://i.ibb.co/TqLnQZp/visiting-professor.jpg"
                                alt="Visiting Professor mengajar di kelas"
                                class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end">
                                <div class="p-4 text-white">
                                    <h4 class="font-bold">Visiting Professor Program</h4>
                                </div>
                            </div>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-teal-700 mb-3">Visiting Professor Program</h3>
                            <p class="mb-4 text-gray-600">Program yang mendatangkan profesor dari universitas mitra luar
                                negeri untuk memberikan kuliah, melakukan penelitian bersama, dan membangun kerja sama
                                akademik selama 1-3 bulan.</p>
                            <a href="#"
                                class="inline-flex items-center text-teal-700 font-medium hover:text-teal-800 transition-colors">
                                <span>Pelajari Lebih Lanjut</span>
                                <i class="fas fa-arrow-right ml-2 text-sm"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Program Card 2 -->
                    <div class="card group">
                        <div class="h-48 overflow-hidden relative">
                            <img src="https://i.ibb.co/hFw71Sp/international-lecturer.jpg"
                                alt="International Lecturer berdiskusi dengan mahasiswa"
                                class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end">
                                <div class="p-4 text-white">
                                    <h4 class="font-bold">Full-time International Lecturer</h4>
                                </div>
                            </div>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-teal-700 mb-3">Full-time International Lecturer</h3>
                            <p class="mb-4 text-gray-600">Rekrutmen dosen tetap dari berbagai negara untuk memperkuat
                                kurikulum internasional dan menciptakan lingkungan pembelajaran multikultural di kampus
                                UNJ.</p>
                            <a href="#"
                                class="inline-flex items-center text-teal-700 font-medium hover:text-teal-800 transition-colors">
                                <span>Pelajari Lebih Lanjut</span>
                                <i class="fas fa-arrow-right ml-2 text-sm"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Program Card 3 -->
                    <div class="card group">
                        <div class="h-48 overflow-hidden relative">
                            <img src="https://i.ibb.co/3YHdggL/expert-exchange.jpg"
                                alt="Expert Exchange Program dengan dosen luar negeri"
                                class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end">
                                <div class="p-4 text-white">
                                    <h4 class="font-bold">Expert Exchange Program</h4>
                                </div>
                            </div>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-teal-700 mb-3">Expert Exchange Program</h3>
                            <p class="mb-4 text-gray-600">Program pertukaran staf akademik dengan universitas mitra luar
                                negeri, memberikan kesempatan bagi dosen UNJ untuk mengajar di luar negeri dan menerima
                                dosen dari universitas mitra.</p>
                            <a href="#"
                                class="inline-flex items-center text-teal-700 font-medium hover:text-teal-800 transition-colors">
                                <span>Pelajari Lebih Lanjut</span>
                                <i class="fas fa-arrow-right ml-2 text-sm"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Professors Section -->

            <h2 class="section-title text-3xl">Adjunct Professor UNJ Tahun 2025</h2>

            <!-- Filters -->
            <div class="mb-8 flex flex-wrap gap-3">
                <button class="filter-btn active" data-filter="all">Semua</button>
                <button class="filter-btn" data-filter="FT">FT</button>
                <button class="filter-btn" data-filter="FMIPA">FMIPA</button>
                <button class="filter-btn" data-filter="FPsi">FPsi</button>
                <button class="filter-btn" data-filter="FEB">FEB</button>
                <button class="filter-btn" data-filter="FISH">FISH</button>
                <button class="filter-btn" data-filter="Pascasarjana">Pascasarjana</button>
            </div>

            <!-- Search -->
            <div class="relative mb-8">
                <input type="text" placeholder="Cari profesor berdasarkan nama atau bidang keahlian..."
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                <i class="fas fa-search absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
            </div>

            <!-- Faculty Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Faculty Profile 1 -->
                <div class="faculty-profile bg-white rounded-xl overflow-hidden shadow-sm" data-faculty="FPsi">
                    <div class="p-6 border-b border-gray-100">
                        <div class="flex items-center">
                            <div class="faculty-profile-avatar">
                                <i class="fas fa-user-tie"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="font-semibold text-lg text-teal-700">Prof. Madya Dr. Norba'yah binti Abdul
                                    Kadir</h3>
                                <div class="text-sm text-gray-600 mt-1">Fakultas Psikologi (FPsi)</div>
                                <div class="flex items-center mt-2">
                                    <img src="https://cdn.countryflags.com/thumbs/malaysia/flag-400.png"
                                        alt="Malaysia Flag" class="country-flag">
                                    <span class="text-sm text-gray-600">Universiti Kebangsaan Malaysia</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="mb-3">
                            <h4 class="text-sm font-semibold text-gray-700">Bidang Keahlian</h4>
                            <p class="text-gray-600">Health Psychology dan Kesehatan Mental</p>
                        </div>
                        <div class="flex flex-wrap mt-3">
                            <span class="faculty-tag">QS WUR: 138</span>
                            <span class="faculty-tag">QS Subject: 301-350 (Psychology)</span>
                            <span class="faculty-tag">Scopus: 8</span>
                        </div>
                    </div>
                </div>

                <!-- Faculty Profile 2 -->
                <div class="faculty-profile bg-white rounded-xl overflow-hidden shadow-sm" data-faculty="FT">
                    <div class="p-6 border-b border-gray-100">
                        <div class="flex items-center">
                            <div class="faculty-profile-avatar">
                                <i class="fas fa-user-tie"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="font-semibold text-lg text-teal-700">Prof. Ir. Dr. Sitti Asmah Binti Hassan
                                </h3>
                                <div class="text-sm text-gray-600 mt-1">Fakultas Teknik (FT)</div>
                                <div class="flex items-center mt-2">
                                    <img src="https://cdn.countryflags.com/thumbs/malaysia/flag-400.png"
                                        alt="Malaysia Flag" class="country-flag">
                                    <span class="text-sm text-gray-600">Universiti Teknologi Malaysia</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="mb-3">
                            <h4 class="text-sm font-semibold text-gray-700">Bidang Keahlian</h4>
                            <p class="text-gray-600">Transportation & Traffic Engineering</p>
                        </div>
                        <div class="flex flex-wrap mt-3">
                            <span class="faculty-tag">QS WUR: 181</span>
                            <span class="faculty-tag">QS Subject: 102 (Engineering)</span>
                            <span class="faculty-tag">Scopus: 12</span>
                        </div>
                    </div>
                </div>

                <!-- Faculty Profile 3 -->
                <div class="faculty-profile bg-white rounded-xl overflow-hidden shadow-sm" data-faculty="FISH">
                    <div class="p-6 border-b border-gray-100">
                        <div class="flex items-center">
                            <div class="faculty-profile-avatar">
                                <i class="fas fa-user-tie"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="font-semibold text-lg text-teal-700">Prof. Dr. Zainudin bin Hassan</h3>
                                <div class="text-sm text-gray-600 mt-1">Fakultas Ilmu Sosial dan Humaniora (FISH)</div>
                                <div class="flex items-center mt-2">
                                    <img src="https://cdn.countryflags.com/thumbs/malaysia/flag-400.png"
                                        alt="Malaysia Flag" class="country-flag">
                                    <span class="text-sm text-gray-600">Universiti Teknologi Malaysia</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="mb-3">
                            <h4 class="text-sm font-semibold text-gray-700">Bidang Keahlian</h4>
                            <p class="text-gray-600">Sosiologi Pendidikan & Pembangunan</p>
                        </div>
                        <div class="flex flex-wrap mt-3">
                            <span class="faculty-tag">QS WUR: 181</span>
                            <span class="faculty-tag">QS Subject: 249 (Social Sciences)</span>
                            <span class="faculty-tag">Scopus: 9</span>
                        </div>
                    </div>
                </div>

                <!-- Faculty Profile 4 -->
                <div class="faculty-profile bg-white rounded-xl overflow-hidden shadow-sm" data-faculty="FEB">
                    <div class="p-6 border-b border-gray-100">
                        <div class="flex items-center">
                            <div class="faculty-profile-avatar">
                                <i class="fas fa-user-tie"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="font-semibold text-lg text-teal-700">Dr. Aslam Mia</h3>
                                <div class="text-sm text-gray-600 mt-1">Fakultas Ekonomi dan Bisnis (FEB)</div>
                                <div class="flex items-center mt-2">
                                    <img src="https://cdn.countryflags.com/thumbs/bangladesh/flag-400.png"
                                        alt="Bangladesh Flag" class="country-flag">
                                    <span class="text-sm text-gray-600">Universiti Sains Malaysia</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="mb-3">
                            <h4 class="text-sm font-semibold text-gray-700">Bidang Keahlian</h4>
                            <p class="text-gray-600">Finance</p>
                        </div>
                        <div class="flex flex-wrap mt-3">
                            <span class="faculty-tag">QS WUR: 146</span>
                            <span class="faculty-tag">QS Subject: 201-250 (Business)</span>
                            <span class="faculty-tag">Scopus: 13</span>
                        </div>
                    </div>
                </div>

                <!-- Faculty Profile 5 -->
                <div class="faculty-profile bg-white rounded-xl overflow-hidden shadow-sm" data-faculty="FEB">
                    <div class="p-6 border-b border-gray-100">
                        <div class="flex items-center">
                            <div class="faculty-profile-avatar">
                                <i class="fas fa-user-tie"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="font-semibold text-lg text-teal-700">Assoc. Prof. Dr. Abdul Rahim bin Zumrah
                                </h3>
                                <div class="text-sm text-gray-600 mt-1">Fakultas Ekonomi dan Bisnis (FEB)</div>
                                <div class="flex items-center mt-2">
                                    <img src="https://cdn.countryflags.com/thumbs/malaysia/flag-400.png"
                                        alt="Malaysia Flag" class="country-flag">
                                    <span class="text-sm text-gray-600">Universiti Sains Islam Malaysia (USIM)</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="mb-3">
                            <h4 class="text-sm font-semibold text-gray-700">Bidang Keahlian</h4>
                            <p class="text-gray-600">Human Resource Management</p>
                        </div>
                        <div class="flex flex-wrap mt-3">
                            <span class="faculty-tag">QS WUR: 1401+</span>
                            <span class="faculty-tag">Scopus: 19</span>
                        </div>
                    </div>
                </div>

                <!-- Faculty Profile 6 -->
                <div class="faculty-profile bg-white rounded-xl overflow-hidden shadow-sm" data-faculty="FEB">
                    <div class="p-6 border-b border-gray-100">
                        <div class="flex items-center">
                            <div class="faculty-profile-avatar">
                                <i class="fas fa-user-tie"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="font-semibold text-lg text-teal-700">Dr. Ammar Salamh Alrawahna</h3>
                                <div class="text-sm text-gray-600 mt-1">Fakultas Ekonomi dan Bisnis (FEB)</div>
                                <div class="flex items-center mt-2">
                                    <img src="https://cdn.countryflags.com/thumbs/jordan/flag-400.png"
                                        alt="Jordan Flag" class="country-flag">
                                    <span class="text-sm text-gray-600">Amman Arab University</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="mb-3">
                            <h4 class="text-sm font-semibold text-gray-700">Bidang Keahlian</h4>
                            <p class="text-gray-600">Business Analysis and Development</p>
                        </div>
                        <div class="flex flex-wrap mt-3">
                            <span class="faculty-tag">QS Arab Region: 110</span>
                            <span class="faculty-tag">Scopus: 2</span>
                        </div>
                    </div>
                </div>

                <!-- Faculty Profile 7 -->
                <div class="faculty-profile bg-white rounded-xl overflow-hidden shadow-sm" data-faculty="FEB">
                    <div class="p-6 border-b border-gray-100">
                        <div class="flex items-center">
                            <div class="faculty-profile-avatar">
                                <i class="fas fa-user-tie"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="font-semibold text-lg text-teal-700">Dr. Ainul Azreen Adam</h3>
                                <div class="text-sm text-gray-600 mt-1">Fakultas Ekonomi dan Bisnis (FEB)</div>
                                <div class="flex items-center mt-2">
                                    <img src="https://cdn.countryflags.com/thumbs/malaysia/flag-400.png"
                                        alt="Malaysia Flag" class="country-flag">
                                    <span class="text-sm text-gray-600">Graduate Business School, Universiti Teknologi
                                        Mara (UiTM)</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="mb-3">
                            <h4 class="text-sm font-semibold text-gray-700">Bidang Keahlian</h4>
                            <p class="text-gray-600">Business Administration</p>
                        </div>
                        <div class="flex flex-wrap mt-3">
                            <span class="faculty-tag">QS WUR: 587</span>
                            <span class="faculty-tag">QS Subject: 401-450 (Business and Management)</span>
                            <span class="faculty-tag">Scopus: 3</span>
                        </div>
                    </div>
                </div>

                <!-- Faculty Profile 8 -->
                <div class="faculty-profile bg-white rounded-xl overflow-hidden shadow-sm" data-faculty="FMIPA">
                    <div class="p-6 border-b border-gray-100">
                        <div class="flex items-center">
                            <div class="faculty-profile-avatar">
                                <i class="fas fa-user-tie"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="font-semibold text-lg text-teal-700">Prof. Dr. Jungshan Chang</h3>
                                <div class="text-sm text-gray-600 mt-1">Fakultas Matematika dan Ilmu Pengetahuan Alam
                                    (FMIPA)</div>
                                <div class="flex items-center mt-2">
                                    <img src="https://cdn.countryflags.com/thumbs/taiwan/flag-400.png"
                                        alt="Taiwan Flag" class="country-flag">
                                    <span class="text-sm text-gray-600">Taipei Medical University</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="mb-3">
                            <h4 class="text-sm font-semibold text-gray-700">Bidang Keahlian</h4>
                            <p class="text-gray-600">Biomedis</p>
                        </div>
                        <div class="flex flex-wrap mt-3">
                            <span class="faculty-tag">QS WUR: 611-620</span>
                            <span class="faculty-tag">QS Subject: 201-250 (Medicine)</span>
                            <span class="faculty-tag">Scopus: 19</span>
                        </div>
                    </div>
                </div>

                <!-- Faculty Profile 9 -->
                <div class="faculty-profile bg-white rounded-xl overflow-hidden shadow-sm" data-faculty="FMIPA">
                    <div class="p-6 border-b border-gray-100">
                        <div class="flex items-center">
                            <div class="faculty-profile-avatar">
                                <img src="{{ asset('images/irfan.jpg') }}"
                                    alt="Assoc. Prof. Dr. Muhammad Irfan Ashraf"
                                    class="w-24 h-24 object-cover rounded-full border border-gray-300 shadow">
                            </div>
                            <div class="ml-4">
                                <h3 class="font-semibold text-lg text-teal-700">Assoc. Prof. Dr. Muhammad Irfan Ashraf
                                </h3>
                                <div class="text-sm text-gray-600 mt-1">Fakultas Matematika dan Ilmu Pengetahuan Alam
                                    (FMIPA)</div>
                                <div class="flex items-center mt-2">
                                    <img src="https://cdn.countryflags.com/thumbs/pakistan/flag-400.png"
                                        alt="Pakistan Flag" class="country-flag">
                                    <span class="text-sm text-gray-600">Sarghoda University</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="mb-3">
                            <h4 class="text-sm font-semibold text-gray-700">Bidang Keahlian</h4>
                            <p class="text-gray-600">Biotechnology</p>
                        </div>
                        <div class="flex flex-wrap mt-3">
                            <span class="faculty-tag">Scopus: 25</span>
                        </div>
                    </div>
                </div>

                <!-- Faculty Profile 10 -->
                <div class="faculty-profile bg-white rounded-xl overflow-hidden shadow-sm" data-faculty="FISH">
                    <div class="p-6 border-b border-gray-100">
                        <div class="flex items-center">
                            <div class="faculty-profile-avatar">
                                <i class="fas fa-user-tie"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="font-semibold text-lg text-teal-700">Sunny Owen</h3>
                                <div class="text-sm text-gray-600 mt-1">Fakultas Ilmu Sosial dan Humaniora (FISH)</div>
                                <div class="flex items-center mt-2">
                                    <img src="https://cdn.countryflags.com/thumbs/united-states/flag-400.png"
                                        alt="USA Flag" class="country-flag">
                                    <span class="text-sm text-gray-600">California State Polytechnic University</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="mb-3">
                            <h4 class="text-sm font-semibold text-gray-700">Bidang Keahlian</h4>
                            <p class="text-gray-600">Komunikasi Internasional</p>
                        </div>
                        <div class="flex flex-wrap mt-3">
                            <span class="faculty-tag">QS WUR: 1401+</span>
                        </div>
                    </div>
                </div>

                <!-- Faculty Profile 11 -->
                <div class="faculty-profile bg-white rounded-xl overflow-hidden shadow-sm"
                    data-faculty="Pascasarjana">
                    <div class="p-6 border-b border-gray-100">
                        <div class="flex items-center">
                            <div class="faculty-profile-avatar">
                                <i class="fas fa-user-tie"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="font-semibold text-lg text-teal-700">Wang Yung Hui</h3>
                                <div class="text-sm text-gray-600 mt-1">Pascasarjana</div>
                                <div class="flex items-center mt-2">
                                    <img src="https://cdn.countryflags.com/thumbs/china/flag-400.png" alt="China Flag"
                                        class="country-flag">
                                    <span class="text-sm text-gray-600">CCNU</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="mb-3">
                            <h4 class="text-sm font-semibold text-gray-700">Bidang Keahlian</h4>
                            <p class="text-gray-600">Political Science</p>
                        </div>
                        <div class="flex flex-wrap mt-3">
                            <!-- No rankings available -->
                        </div>
                    </div>
                </div>

                <!-- Faculty Profile 12 -->
                <div class="faculty-profile bg-white rounded-xl overflow-hidden shadow-sm" data-faculty="UNJ">
                    <div class="p-6 border-b border-gray-100">
                        <div class="flex items-center">
                            <div class="faculty-profile-avatar">
                                <i class="fas fa-user-tie"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="font-semibold text-lg text-teal-700">Prof. Dr. rer. Nat. Hesham A. El
                                    Enshasy</h3>
                                <div class="text-sm text-gray-600 mt-1">Universitas Negeri Jakarta (UNJ)</div>
                                <div class="flex items-center mt-2">
                                    <img src="https://cdn.countryflags.com/thumbs/egypt/flag-400.png" alt="Egypt Flag"
                                        class="country-flag">
                                    <span class="text-sm text-gray-600">Universiti Teknologi Malaysia</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="mb-3">
                            <h4 class="text-sm font-semibold text-gray-700">Bidang Keahlian</h4>
                            <p class="text-gray-600">Management and Industrial Biotechnology</p>
                        </div>
                        <div class="flex flex-wrap mt-3">
                            <span class="faculty-tag">QS WUR: 181</span>
                            <span class="faculty-tag">QS Subject: 88 (Chemical Engineering)</span>
                            <span class="faculty-tag">Scopus: 40</span>
                        </div>
                    </div>
                </div>

                <!-- Load More button -->
                <div class="col-span-1 md:col-span-2 lg:col-span-3 flex justify-center my-8">
                    <button class="btn-secondary flex items-center">
                        <span>Lihat Lebih Banyak</span>
                        <i class="fas fa-chevron-down ml-2"></i>
                    </button>
                </div>
            </div>
            </section>

            <!-- Benefits Section -->
            <section id="benefits" class="mb-20">
                <h2 class="section-title text-3xl">Manfaat Program</h2>

                <div class="grid md:grid-cols-2 gap-6">
                    <!-- Benefit 1 -->
                    <div class="benefit-card">
                        <div class="benefit-icon">
                            <i class="fas fa-globe-asia"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-lg text-teal-700 mb-2">Lingkungan Akademik Internasional</h3>
                            <p class="text-gray-600">Menciptakan suasana belajar multikultural yang memperluas wawasan
                                dan perspektif mahasiswa serta dosen UNJ dalam memahami isu-isu global.</p>
                        </div>
                    </div>

                    <!-- Benefit 2 -->
                    <div class="benefit-card">
                        <div class="benefit-icon">
                            <i class="fas fa-language"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-lg text-teal-700 mb-2">Peningkatan Kemampuan Bahasa</h3>
                            <p class="text-gray-600">Memberikan kesempatan praktik komunikasi dalam bahasa asing
                                (terutama Bahasa Inggris) secara langsung dalam konteks akademik.</p>
                        </div>
                    </div>

                    <!-- Benefit 3 -->
                    <div class="benefit-card">
                        <div class="benefit-icon">
                            <i class="fas fa-handshake"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-lg text-teal-700 mb-2">Kolaborasi Penelitian Internasional
                            </h3>
                            <p class="text-gray-600">Membuka akses untuk melakukan penelitian bersama dengan institusi
                                bergengsi dunia, meningkatkan kualitas dan visibilitas publikasi ilmiah UNJ.</p>
                        </div>
                    </div>

                    <!-- Benefit 4 -->
                    <div class="benefit-card">
                        <div class="benefit-icon">
                            <i class="fas fa-chalkboard-teacher"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-lg text-teal-700 mb-2">Transfer Pengetahuan & Metodologi</h3>
                            <p class="text-gray-600">Memfasilitasi pertukaran metode pengajaran, pendekatan penelitian,
                                dan pengetahuan terkini dari universitas terkemuka dunia.</p>
                        </div>
                    </div>

                    <!-- Benefit 5 -->
                    <div class="benefit-card md:col-span-2">
                        <div class="benefit-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-lg text-teal-700 mb-2">Peningkatan Reputasi & Peringkat UNJ
                            </h3>
                            <p class="text-gray-600">Meningkatkan parameter internasionalisasi yang menjadi indikator
                                penting dalam pemeringkatan universitas global.</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Syarat Pengusulan Section -->
            <section id="requirements" class="mb-20">
                <h2 class="section-title text-3xl">Syarat Pengusulan Adjunct Professor</h2>

                <div class="bg-white p-8 rounded-2xl shadow-sm mb-6">
                    <p class="text-gray-700 mb-6">Untuk memperluas upaya perwujudan WCU, pada tahun 2024 Kantor Wakil
                        Rektor Bidang Perencanaan dan Bisnis UNJ melalui Pusat Layanan Internasional menawarkan
                        kesempatan kepada fakultas untuk dapat mengusulkan Adjunct Professor yang akan dikontrak dalam
                        jangka waktu satu tahun. Adapun persyaratan:</p>

                    <div class="grid md:grid-cols-2 gap-6">
                        <!-- Requirement 1 -->
                        <div class="process-card">
                            <div class="process-number">1</div>
                            <h3 class="font-semibold text-lg text-teal-700 mb-2">Kualifikasi Akademik</h3>
                            <p class="text-gray-600">
                                Dosen perguruan tinggi luar negeri (PTLN) di Universitas <strong>QS 200 (by
                                    Subject)</strong>,
                                berkewarganegaraan asing, bergelar professor atau minimal associate professor,
                                berpendidikan S3.
                            </p>
                        </div>

                        <!-- Requirement 2 -->
                        <div class="process-card">
                            <div class="process-number">2</div>
                            <h3 class="font-semibold text-lg text-teal-700 mb-2">Pengalaman Profesional</h3>
                            <p class="text-gray-600">
                                Memiliki pengalaman pengajaran, penelitian, dan pelayanan/kemitraan
                                paling singkat <strong>5 tahun</strong>.
                            </p>
                        </div>

                        <!-- Requirement 3 -->
                        <div class="process-card">
                            <div class="process-number">3</div>
                            <h3 class="font-semibold text-lg text-teal-700 mb-2">Pengalaman Kolaborasi</h3>
                            <p class="text-gray-600">
                                Memiliki pengalaman menjadi anggota tim kerjasama dalam kegiatan penelitian
                                dan pengembangan ilmu pengetahuan/teknologi di perguruan tinggi.
                            </p>
                        </div>

                        <!-- Requirement 4 -->
                        <div class="process-card">
                            <div class="process-number">4</div>
                            <h3 class="font-semibold text-lg text-teal-700 mb-2">Publikasi Ilmiah</h3>
                            <p class="text-gray-600">
                                Memiliki publikasi ilmiah minimal <strong>3 artikel</strong> pada jurnal internasional
                                bereputasi dengan:<br>
                                - SCImago JR ≥ 0.3 <em>atau</em><br>
                                - JIF WoS ≥ 0.02<br>
                                (Minimal 2 artikel sebagai penulis pertama/korespondensi)
                            </p>
                        </div>

                        <!-- Requirement 5 -->
                        <div class="process-card">
                            <div class="process-number">5</div>
                            <h3 class="font-semibold text-lg text-teal-700 mb-2">Reputasi Akademik</h3>
                            <p class="text-gray-600">
                                Memiliki karya ilmiah yang diakui secara internasional dengan
                                <strong>H-index Scopus ≥ 6</strong>.
                            </p>
                        </div>

                        <!-- Requirement 6 & 7 -->
                        <div class="process-card md:col-span-2">
                            <div class="process-number">6/7</div>
                            <h3 class="font-semibold text-lg text-teal-700 mb-2">Kontribusi Wajib</h3>
                            <p class="text-gray-600">
                                Harus memenuhi salah satu:<br>
                                <strong>Opsi Pengajaran:</strong><br>
                                - Mengajar minimal 3x/semester<br>
                                - Membimbing/menguji minimal 2 tugas akhir<br><br>

                                <strong>Opsi Penelitian:</strong><br>
                                - Mendampingi penulisan artikel<br>
                                - Menghasilkan minimal 2 artikel Q3 bersama per tahun
                            </p>
                        </div>
                        <div class="bg-teal-50 p-6 rounded-xl border border-teal-200">
                            <h4 class="font-semibold text-teal-800 mb-3 flex items-center">
                                <i class="fas fa-info-circle mr-2"></i>
                                Catatan Penting:
                            </h4>
                            <ul class="list-disc list-inside text-gray-700 space-y-2">
                                <li>Pengusulan melalui fakultas masing-masing</li>
                                <li>Dokumen pendukung harus diverifikasi</li>
                                <li>Masa kontrak 1 tahun dengan evaluasi berkala</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Luaran Program Section -->
            <section id="outputs" class="mb-20">
                <h2 class="section-title text-3xl">Luaran Program Adjunct Professor</h2>

                <div class="grid md:grid-cols-3 gap-6">
                    <!-- Output 1 -->
                    <div class="process-card">
                        <div class="process-number">1</div>
                        <h3 class="font-semibold text-lg text-teal-700 mb-2">Publikasi Ilmiah</h3>
                        <p class="text-gray-600">
                            <strong>Minimal 2 Artikel</strong> penelitian bersama pada
                            <span class="font-semibold text-teal-600">jurnal terindeks Scopus Q2</span>.
                            Publikasi harus menunjukkan kolaborasi aktif antara adjunct professor dan dosen UNJ.
                        </p>
                    </div>

                    <!-- Output 2 -->
                    <div class="process-card">
                        <div class="process-number">2</div>
                        <h3 class="font-semibold text-lg text-teal-700 mb-2">Pembelajaran Kolaboratif</h3>
                        <p class="text-gray-600">
                            <strong>Minimal 2 RPS</strong> (Rencana Pembelajaran Semester) bersama atau
                            <strong>2 naskah bimbingan</strong> tugas akhir mahasiswa.
                            Dokumen harus menunjukkan kontribusi langsung adjunct professor.
                        </p>
                    </div>

                    <!-- Output 3 -->
                    <div class="process-card">
                        <div class="process-number">3</div>
                        <h3 class="font-semibold text-lg text-teal-700 mb-2">Kerjasama Institusional</h3>
                        <p class="text-gray-600">
                            <strong>Minimal 1 dokumen kerjasama</strong> dalam bentuk:
                            <br>- MOU (Memorandum of Understanding)
                            <br>- IA (Implementation Agreement)
                            <br>Khusus untuk universitas yang belum memiliki perjanjian kerja sama.
                        </p>
                    </div>
                </div>

                <div class="bg-teal-50 p-6 rounded-xl border border-teal-200 mt-8">
                    <h4 class="font-semibold text-teal-800 mb-3 flex items-center">
                        <i class="fas fa-clipboard-check mr-2"></i>
                        Mekanisme Pelaporan:
                    </h4>
                    <ul class="list-disc list-inside text-gray-700 space-y-2">
                        <li>Laporan progres triwulanan ke Pusat Layanan Internasional</li>
                        <li>Dokumen luaran harus diserahkan maksimal 1 bulan sebelum akhir kontrak</li>
                        <li>Verifikasi akhir oleh tim penjaminan mutu UNJ</li>
                    </ul>
                </div>
            </section>

            <!-- Achievements Section -->
            <section id="achievements" class="mb-20">
                <h2 class="section-title text-3xl">Pencapaian Program</h2>

                <div class="grid md:grid-cols-4 gap-6 mb-10">
                    <!-- Stat 1 -->
                    <div class="stat-card">
                        <div class="text-4xl font-bold text-teal-700 mb-2">25+</div>
                        <div class="text-teal-800 font-medium">Visiting Professors</div>
                    </div>

                    <!-- Stat 2 -->
                    <div class="stat-card">
                        <div class="text-4xl font-bold text-teal-700 mb-2">12</div>
                        <div class="text-teal-800 font-medium">Full-time Int'l Lecturers</div>
                    </div>

                    <!-- Stat 3 -->
                    <div class="stat-card">
                        <div class="text-4xl font-bold text-teal-700 mb-2">18</div>
                        <div class="text-teal-800 font-medium">Negara Asal</div>
                    </div>

                    <!-- Stat 4 -->
                    <div class="stat-card">
                        <div class="text-4xl font-bold text-teal-700 mb-2">40+</div>
                        <div class="text-teal-800 font-medium">Publikasi Kolaboratif</div>
                    </div>
                </div>

                <div class="bg-white p-8 rounded-2xl shadow-sm">
                    <h3 class="text-xl font-bold text-teal-700 mb-6">Dampak pada UNJ</h3>
                    <div class="grid md:grid-cols-2 gap-6">
                        <div class="flex items-start">
                            <div
                                class="h-10 w-10 rounded-full bg-teal-100 flex items-center justify-center flex-shrink-0 mr-4">
                                <i class="fas fa-chart-bar text-teal-600"></i>
                            </div>
                            <p class="text-gray-700">Peningkatan parameter internasionalisasi dalam pemeringkatan QS
                                World University Rankings</p>
                        </div>
                        <div class="flex items-start">
                            <div
                                class="h-10 w-10 rounded-full bg-teal-100 flex items-center justify-center flex-shrink-0 mr-4">
                                <i class="fas fa-language text-teal-600"></i>
                            </div>
                            <p class="text-gray-700">Peningkatan jumlah matakuliah yang disampaikan dalam Bahasa
                                Inggris dari 15 menjadi 47 matakuliah</p>
                        </div>
                        <div class="flex items-start">
                            <div
                                class="h-10 w-10 rounded-full bg-teal-100 flex items-center justify-center flex-shrink-0 mr-4">
                                <i class="fas fa-users text-teal-600"></i>
                            </div>
                            <p class="text-gray-700">Bertambahnya jumlah mahasiswa internasional sebesar 35% berkat
                                ketersediaan program dengan pengajar internasional</p>
                        </div>
                        <div class="flex items-start">
                            <div
                                class="h-10 w-10 rounded-full bg-teal-100 flex items-center justify-center flex-shrink-0 mr-4">
                                <i class="fas fa-handshake text-teal-600"></i>
                            </div>
                            <p class="text-gray-700">Pengembangan 8 program kerja sama double degree dan joint degree
                                dengan universitas mitra</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- CTA Section -->
            <section
                class="relative overflow-hidden bg-gradient-to-r from-teal-700 to-teal-800 text-white p-10 rounded-3xl shadow-lg text-center mb-10">
                <div class="absolute top-0 right-0 w-64 h-64 opacity-10">
                    <i class="fas fa-globe-asia text-9xl"></i>
                </div>
                <div class="relative z-10">
                    <h2 class="text-3xl font-bold mb-4">Tertarik untuk Berkolaborasi?</h2>
                    <p class="mb-8 max-w-3xl mx-auto">UNJ selalu terbuka untuk menjalin kerja sama dengan akademisi dan
                        institusi pendidikan tinggi dari seluruh dunia. Bergabunglah dengan komunitas akademik kami dan
                        jadilah bagian dari perjalanan UNJ menuju world-class university.</p>
                    <div class="flex flex-wrap justify-center gap-4">
                        <a href="#"
                            class="bg-white text-teal-800 px-6 py-3 rounded-lg font-medium transition-all duration-300 hover:bg-yellow-400 hover:text-teal-900 shadow-lg hover:shadow-xl flex items-center">
                            <i class="fas fa-file-alt mr-2"></i>
                            <span>Informasi Rekrutmen</span>
                        </a>
                        <a href="#"
                            class="bg-white text-teal-800 px-6 py-3 rounded-lg font-medium transition-all duration-300 hover:bg-yellow-400 hover:text-teal-900 shadow-lg hover:shadow-xl flex items-center">
                            <i class="fas fa-handshake mr-2"></i>
                            <span>Institutional Partnership</span>
                        </a>
                        <a href="#"
                            class="bg-white text-teal-800 px-6 py-3 rounded-lg font-medium transition-all duration-300 hover:bg-yellow-400 hover:text-teal-900 shadow-lg hover:shadow-xl flex items-center">
                            <i class="fas fa-envelope mr-2"></i>
                            <span>Hubungi Kami</span>
                        </a>
                    </div>
                </div>
            </section>
        </div>
        @include('layout.footer')

    </div>

    <script>
        // Filter functionality
        document.addEventListener('DOMContentLoaded', function() {
            const filterButtons = document.querySelectorAll('.filter-btn');
            const facultyProfiles = document.querySelectorAll('.faculty-profile');

            filterButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Remove active class from all buttons
                    filterButtons.forEach(btn => btn.classList.remove('active'));

                    // Add active class to clicked button
                    this.classList.add('active');

                    const filterValue = this.getAttribute('data-filter');

                    // Show/hide faculty profiles based on filter
                    facultyProfiles.forEach(profile => {
                        if (filterValue === 'all' || profile.getAttribute(
                                'data-faculty') === filterValue) {
                            profile.style.display = 'block';
                        } else {
                            profile.style.display = 'none';
                        }
                    });
                });
            });

            // Search functionality
            const searchInput = document.querySelector('input[type="text"]');

            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();

                facultyProfiles.forEach(profile => {
                    const name = profile.querySelector('h3').textContent.toLowerCase();
                    const expertise = profile.querySelector('p').textContent.toLowerCase();

                    if (name.includes(searchTerm) || expertise.includes(searchTerm)) {
                        profile.style.display = 'block';
                    } else {
                        profile.style.display = 'none';
                    }
                });
            });

            // Smooth scroll for navigation
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();

                    const targetId = this.getAttribute('href');
                    const targetElement = document.querySelector(targetId);

                    if (targetElement) {
                        window.scrollTo({
                            top: targetElement.offsetTop - 80,
                            behavior: 'smooth'
                        });
                    }
                });
            });

            // Sticky header effect
            const header = document.querySelector('.fixed');

            window.addEventListener('scroll', function() {
                if (window.scrollY > 100) {
                    header.classList.add('bg-white/95', 'backdrop-blur-sm', 'shadow-md');
                    header.classList.remove('bg-white');
                } else {
                    header.classList.remove('bg-white/95', 'backdrop-blur-sm', 'shadow-md');
                    header.classList.add('bg-white');
                }
            });
        });
    </script>
</body>

</html>
