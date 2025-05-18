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
                <h2 class="section-title text-3xl">Aktivitas Dosen Asing</h2>
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

            <section>
                @php
                    // Get unique years from the data
                    $years = $facultyStaffs->pluck('tahun')->unique()->sort()->values();

                    // Set default year to display (current year if available, otherwise the latest year in data)
                    $currentYear = request(
                        'year',
                        $years->contains(date('Y')) ? date('Y') : ($years->count() > 0 ? $years->last() : date('Y')),
                    );
                @endphp

                <!-- Title with dropdown -->
                <div class="flex items-center justify-between mb-6">
                    <h2 class="section-title text-3xl">Dosen Asing UNJ Tahun
                        <select id="year-dropdown"
                            class="text-3xl font-bold bg-transparent border-none focus:outline-none text-teal-700">
                            @foreach ($years as $year)
                                <option value="{{ $year }}" {{ $year == $currentYear ? 'selected' : '' }}>
                                    {{ $year }}
                                </option>
                            @endforeach
                        </select>
                    </h2>
                </div>
                <div class="mb-8 flex flex-wrap gap-3">
                    <button class="filter-btn active" data-filter="all">Semua</button>
                    @php
                        $faculties = $facultyStaffs->pluck('fakultas')->unique();
                        $fakultasNames = [
                            'pascasarjana' => 'Pascasarjana',
                            'fip' => 'FIP',
                            'fmipa' => 'FMIPA',
                            'fppsi' => 'FPsi',
                            'fbs' => 'FBS',
                            'ft' => 'FT',
                            'fik' => 'FIKK',
                            'fis' => 'FISH',
                            'fe' => 'FEB',
                            'profesi' => 'PROFESI',
                        ];
                    @endphp
                    @foreach ($faculties as $faculty)
                        @if (isset($fakultasNames[$faculty]))
                            <button class="filter-btn"
                                data-filter="{{ $faculty }}">{{ $fakultasNames[$faculty] }}</button>
                        @endif
                    @endforeach
                </div>

                <div class="relative mb-8">
                    <input type="text" placeholder="Cari profesor berdasarkan nama atau bidang keahlian..."
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                    <i class="fas fa-search absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="faculty-grid">
                    @foreach ($facultyStaffs as $staff)
                        <div class="faculty-profile bg-white rounded-xl overflow-hidden shadow-sm"
                            data-faculty="{{ $staff->fakultas }}" data-year="{{ $staff->tahun }}">
                            <div class="p-6 border-b border-gray-100">
                                <div class="flex items-center">
                                    <div class="faculty-profile-avatar">
                                        @if ($staff->foto_path)
                                            <img src="{{ Storage::url($staff->foto_path) }}" alt="{{ $staff->nama }}"
                                                class="w-full h-full object-cover rounded-full">
                                        @else
                                            <i class="fas fa-user-tie"></i>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <h3 class="font-semibold text-lg text-teal-700">{{ $staff->nama }}</h3>
                                        <div class="text-sm text-gray-600 mt-1">
                                            @php
                                                $fakultasNames = [
                                                    'pascasarjana' => 'Pascasarjana',
                                                    'fip' => 'Fakultas Ilmu Pendidikan (FIP)',
                                                    'fmipa' => 'Fakultas Matematika dan Ilmu Pengetahuan Alam (FMIPA)',
                                                    'fppsi' => 'Fakultas Psikologi (FPsi)',
                                                    'fbs' => 'Fakultas Bahasa dan Seni (FBS)',
                                                    'ft' => 'Fakultas Teknik (FT)',
                                                    'fik' => 'Fakultas Ilmu Keolahragaan (FIKK)',
                                                    'fis' => 'Fakultas Ilmu Sosial dan Humaniora (FISH)',
                                                    'fe' => 'Fakultas Ekonomi dan Bisnis (FEB)',
                                                    'profesi' => 'PROFESI',
                                                ];
                                            @endphp
                                            {{ $fakultasNames[$staff->fakultas] ?? ucfirst($staff->fakultas) }}
                                        </div>
                                        <div class="flex items-center mt-2">
                                            <span class="text-sm text-gray-600">{{ $staff->universitas_asal }}</span>
                                        </div>
                                        <div class="flex items-center mt-2">
                                            <span class="text-sm text-gray-600">{{ $staff->tahun }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="p-6">
                                <div class="mb-3">
                                    <h4 class="text-sm font-semibold text-gray-700">Bidang Keahlian</h4>
                                    <p class="text-gray-600">{{ $staff->bidang_keahlian }}</p>
                                </div>
                                <div class="flex flex-wrap mt-3">
                                    @if ($staff->qs_wur)
                                        <span class="faculty-tag">QS WUR: {{ $staff->qs_wur }}</span>
                                    @endif

                                    @if ($staff->qs_subject)
                                        <span class="faculty-tag">QS Subject: {{ $staff->qs_subject }}</span>
                                    @endif

                                    @if ($staff->scopus)
                                        <span class="faculty-tag">Scopus: {{ $staff->scopus }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <!-- Load More button -->
                    <div class="col-span-1 md:col-span-2 lg:col-span-3 flex justify-center my-8">
                        <button class="btn-secondary flex items-center" id="load-more-btn">
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

                <div class="grid md:grid-cols-3 gap-6 mb-10">
                    <!-- Stat 1: Adjunct Professors -->
                    <div class="stat-card">
                        <div class="text-4xl font-bold text-teal-700 mb-2">{{ $stats['adjunctProfessors'] }}</div>
                        <div class="text-teal-800 font-medium">Adjunct Professors</div>
                    </div>

                    <!-- Stat 2: Full-time Professors -->
                    <div class="stat-card">
                        <div class="text-4xl font-bold text-teal-700 mb-2">{{ $stats['fullTimeProfessors'] }}</div>
                        <div class="text-teal-800 font-medium">Full-time Int'l Lecturers</div>
                    </div>

                    <!-- Stat 3: Unique Universities -->
                    <div class="stat-card">
                        <div class="text-4xl font-bold text-teal-700 mb-2">{{ $stats['uniqueUniversities'] }}</div>
                        <div class="text-teal-800 font-medium">Universitas Asal</div>
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

        </div>
        @include('layout.footer')

    </div>

    <script>
        // Filter functionality
        document.addEventListener('DOMContentLoaded', function() {
            const filterButtons = document.querySelectorAll('.filter-btn');
            const facultyProfiles = document.querySelectorAll('.faculty-profile');
            const loadMoreBtn = document.getElementById('load-more-btn');
            const facultyGrid = document.getElementById('faculty-grid');
            const searchInput = document.getElementById('faculty-search');
            const yearButtons = document.querySelectorAll('.year-btn');
            const yearDropdown = document.getElementById('year-dropdown');

            // Get all the faculty profiles from the grid
            const facultyProfilesInGrid = Array.from(facultyGrid.querySelectorAll('.faculty-profile'));

            // Initially, display a limited number of faculty profiles
            const initialDisplayCount = 9; // Show first 9 items
            let displayCount = initialDisplayCount;


            yearDropdown.addEventListener('change', function() {
                const selectedYear = this.value;

                // Filter profiles by year
                facultyProfilesInGrid.forEach(profile => {
                    const profileYear = profile.getAttribute('data-year');

                    if (profileYear === selectedYear) {
                        profile.classList.remove('year-hidden');
                    } else {
                        profile.classList.add('year-hidden');
                    }
                });

                // Reset display count and update display
                displayCount = initialDisplayCount;
                updateDisplayedItems();
            });

            // Function to update the displayed items
            function updateDisplayedItems() {
                let visibleCount = 0;
                facultyProfilesInGrid.forEach((profile, index) => {
                    const isFilterHidden = profile.classList.contains('filter-hidden');
                    const isSearchHidden = profile.classList.contains('search-hidden');
                    const isYearHidden = profile.classList.contains('year-hidden');

                    if (!isFilterHidden && !isSearchHidden && !isYearHidden && visibleCount <
                        displayCount) {
                        profile.style.display = 'block';
                        visibleCount++;
                    } else {
                        profile.style.display = 'none';
                    }
                });

                // Hide load more button if all visible items are displayed
                const totalVisible = facultyProfilesInGrid.filter(profile =>
                    !profile.classList.contains('filter-hidden') &&
                    !profile.classList.contains('search-hidden') &&
                    !profile.classList.contains('year-hidden')).length;

                if (totalVisible <= visibleCount) {
                    loadMoreBtn.style.display = 'none';
                } else {
                    loadMoreBtn.style.display = 'flex';
                }
            }

            // Apply initial display
            facultyProfilesInGrid.forEach((profile) => {
                profile.classList.remove('filter-hidden', 'search-hidden');
            });
            updateDisplayedItems();

            // Load more button functionality
            loadMoreBtn.addEventListener('click', function() {
                displayCount += 6; // Load 6 more items
                updateDisplayedItems();
            });

            // Filter buttons functionality
            filterButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Reset display count to initial
                    displayCount = initialDisplayCount;

                    // Remove active class from all buttons
                    filterButtons.forEach(btn => btn.classList.remove('active'));

                    // Add active class to clicked button
                    this.classList.add('active');

                    const filterValue = this.getAttribute('data-filter');

                    // Show/hide faculty profiles based on filter
                    facultyProfilesInGrid.forEach(profile => {
                        if (filterValue === 'all' || profile.getAttribute(
                                'data-faculty') === filterValue) {
                            profile.classList.remove('filter-hidden');
                        } else {
                            profile.classList.add('filter-hidden');
                        }
                    });

                    // Update displayed items
                    updateDisplayedItems();
                });
            });

            // Search functionality
            searchInput.addEventListener('input', function() {
                // Reset display count to initial
                displayCount = initialDisplayCount;

                const searchTerm = this.value.toLowerCase();

                facultyProfilesInGrid.forEach(profile => {
                    const name = profile.querySelector('h3').textContent.toLowerCase();
                    const expertise = profile.querySelector('p').textContent.toLowerCase();

                    if (name.includes(searchTerm) || expertise.includes(searchTerm)) {
                        profile.classList.remove('search-hidden');
                    } else {
                        profile.classList.add('search-hidden');
                    }
                });

                updateDisplayedItems();
            });
        });
    </script>
</body>

</html>
