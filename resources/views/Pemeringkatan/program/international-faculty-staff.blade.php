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
   @vite([
        'resources/css/fitur/international-faculty-staff.css'
        'resources/js/fitur/international-faculty-staff.js' {{-- Path disesuaikan untuk Vite dan typo diperbaiki --}}
    ])
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
                    @forelse($activities as $activity)
                        <!-- Program Card -->
                        <div class="card group">
                            <div class="h-48 overflow-hidden relative">
                                <img src="{{ asset('storage/' . $activity->gambar) }}" alt="{{ $activity->judul }}"
                                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end">
                                    <div class="p-4 text-white">
                                        <h4 class="font-bold">{{ $activity->judul }}</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="p-6">
                                <h3 class="text-xl font-bold text-teal-700 mb-3">{{ $activity->judul }}</h3>
                                <p class="mb-4 text-gray-600">{{ Str::limit(strip_tags($activity->isi), 120) }}</p>
                                <button type="button"
                                    data-detail-url="{{ route('api.aktivitas-dosen-asing.show', ['id' => $activity->id]) }}"
                                    class="show-details-btn inline-flex items-center text-teal-700 font-medium hover:text-teal-800 transition-colors">
                                    <span>Pelajari Lebih Lanjut</span>
                                    <i class="fas fa-arrow-right ml-2 text-sm"></i>
                                </button>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-3 text-center py-8">
                            <p class="text-gray-500">Belum ada aktivitas dosen asing yang ditambahkan.</p>
                        </div>
                    @endforelse
                </div>
            </section>

            <div id="detailModal"
                class="fixed inset-0 z-50 hidden overflow-auto bg-black bg-opacity-50 flex items-center justify-center p-4">
                <div class="bg-white rounded-lg shadow-xl max-w-4xl w-full max-h-[90vh] overflow-y-auto">
                    <div class="flex justify-between items-center border-b p-4">
                        <h3 class="text-xl font-bold text-teal-700" id="modalTitle">Detail Aktivitas</h3>
                        <button id="closeModal" class="text-gray-400 hover:text-gray-600">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>
                    <div class="p-6" id="modalContent">
                        <div class="flex flex-col md:flex-row gap-6">
                            <div class="md:w-1/3">
                                <img id="modalImage" src="" alt="Activity Image" class="w-full h-auto rounded">
                                <p class="mt-3 text-sm text-gray-500">
                                    Tanggal: <span id="modalDate" class="font-medium"></span>
                                </p>
                            </div>
                            <div class="md:w-2/3">
                                <h4 id="modalHeading" class="text-2xl font-bold text-teal-700 mb-4"></h4>
                                <div id="modalBody" class="prose max-w-none"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

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
                    <input id="faculty-search" type="text"
                        placeholder="Cari profesor berdasarkan nama atau bidang keahlian..."
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
                                            <img src="{{ Storage::url($staff->foto_path) }}"
                                                alt="{{ $staff->nama }}"
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
</body>

</html>
