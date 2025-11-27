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
    @vite([
        'resources/css/fitur/lecturer-expose.css'
    ])
</head>

<body>
    @include('layout.navbarpemeringkatan')

    <div class="lecturer-page pt-16">
        <div class="lecturer-hero">
            <div class="lecturer-hero-content">
                <h2 class="text-4xl font-bold mb-4">Lecturer Expose</h2>
                <p class="text-xl">Program peningkatan kompetensi dan visibilitas global dosen Universitas Negeri
                    Jakarta dalam publikasi internasional, pengajaran, dan penelitian.</p>
            </div>
        </div>

        <div class="container mx-auto px-6 py-8">
            <section class="lecturer-section">
                <h2 class="lecturer-section-title text-3xl font-bold">Tentang Lecturer Expose</h2>
                <p class="mb-4">Program Lecturer Expose merupakan inisiatif strategis UNJ untuk meningkatkan kualitas
                    dan pengakuan global terhadap dosen-dosen UNJ melalui berbagai program eksposur internasional,
                    pengembangan kapasitas, dan kolaborasi dengan institusi pendidikan tinggi terkemuka dunia.</p>
                <p>Melalui program ini, dosen UNJ berkesempatan untuk mengembangkan keahlian, memperluas jaringan
                    internasional, dan meningkatkan kualitas publikasi ilmiah mereka, yang pada akhirnya akan
                    berkontribusi pada peningkatan reputasi akademik Universitas Negeri Jakarta di tingkat global.</p>
            </section>

            <!-- Add after "Tentang Lecturer Expose" section -->
            <section class="lecturer-section">
                <h2 class="lecturer-section-title text-3xl font-bold">Signifikansi Strategis</h2>
                <p class="mb-4">Publikasi aktivitas dosen secara rutin setiap bulan merupakan strategi penting dalam
                    meningkatkan visibilitas dan reputasi akademik Universitas Negeri Jakarta (UNJ) di tingkat nasional
                    dan internasional. Aktivitas ini mencakup publikasi berita, artikel, atau laporan mengenai
                    keterlibatan dosen dalam penelitian, pengabdian kepada masyarakat, seminar, konferensi, kolaborasi
                    internasional, hingga prestasi akademik.</p>
                <p class="mb-4">Dalam konteks pemeringkatan nasional, indikator kinerja dosen menjadi salah satu aspek
                    penilaian penting. Informasi yang dipublikasikan secara konsisten terkait aktivitas dosen dapat
                    menjadi bukti nyata dari capaian kinerja tridharma perguruan tinggi. Hal ini tidak hanya mendukung
                    pengakuan institusi dalam akreditasi dan evaluasi internal, tetapi juga dapat memperkuat posisi UNJ
                    dalam klasterisasi perguruan tinggi nasional.</p>
                <p>Secara internasional, pemeringkatan seperti QS World University Rankings atau Times Higher Education
                    (THE) menilai universitas berdasarkan indikator reputasi akademik, jumlah publikasi, dan dampak
                    riset global. Dengan meningkatkan lecturer exposure, UNJ dapat memperluas jejaring internasional,
                    meningkatkan sitasi publikasi, dan memperlihatkan kualitas dosennya di panggung global.</p>
            </section>

            <!-- Add to "Program-Program Pendukung" section -->
            <div class="bg-gray-50 p-6 rounded-lg">
                <h3 class="text-xl font-bold text-teal-700 mb-3">Penguatan Kehadiran Digital Akademik</h3>
                <p class="mb-4">Program strategis untuk meningkatkan visibilitas digital dosen melalui optimalisasi
                    platform akademik modern dan pengelolaan reputasi profesional.</p>
                <div class="flex flex-wrap gap-2">
                    <span class="bg-teal-100 text-teal-800 px-3 py-1 rounded-full text-sm">Pelatihan Wikipedia</span>
                    <span class="bg-teal-100 text-teal-800 px-3 py-1 rounded-full text-sm">Optimasi LinkedIn</span>
                    <span class="bg-teal-100 text-teal-800 px-3 py-1 rounded-full text-sm">ResearchGate</span>
                    <span class="bg-teal-100 text-teal-800 px-3 py-1 rounded-full text-sm">Google Scholar</span>
                    <span class="bg-teal-100 text-teal-800 px-3 py-1 rounded-full text-sm">Manajemen ORCID</span>
                </div>
            </div>

            <div class="bg-gray-50 p-6 rounded-lg">
                <h3 class="text-xl font-bold text-teal-700 mb-3">Strategi Kolaborasi &amp; Sitasi</h3>
                <p class="mb-4">Program pendampingan intensif untuk meningkatkan dampak penelitian melalui strategi
                    kolaborasi internasional dan peningkatan sitasi karya ilmiah.</p>
                <div class="flex flex-wrap gap-2">
                    <span class="bg-teal-100 text-teal-800 px-3 py-1 rounded-full text-sm">Analisis Sitasi</span>
                    <span class="bg-teal-100 text-teal-800 px-3 py-1 rounded-full text-sm">Jejarin Riset</span>
                    <span class="bg-teal-100 text-teal-800 px-3 py-1 rounded-full text-sm">Publikasi Strategis</span>
                    <span class="bg-teal-100 text-teal-800 px-3 py-1 rounded-full text-sm">Co-authoring</span>
                </div>
            </div>

            <section class="lecturer-section">
                <h2 class="lecturer-section-title text-3xl font-bold">Program Utama</h2>

                <div class="lecturer-cards">
                    <div class="lecturer-card">
                        <div class="lecturer-card-img">
                            <img src="https://i.ibb.co/mGjsXQX/international-conference.jpg"
                                alt="Dosen UNJ berbicara di konferensi internasional">
                        </div>
                        <div class="lecturer-card-content">
                            <h3 class="text-xl font-bold">Konferensi Internasional</h3>
                            <p>Dukungan partisipasi dosen UNJ sebagai pembicara atau pemakalah di konferensi
                                internasional untuk mempresentasikan hasil riset dan membentuk jaringan global.</p>
                            <a href="#" class="lecturer-btn">Pelajari Lebih Lanjut</a>
                        </div>
                    </div>
                    <div class="lecturer-card">
                        <div class="lecturer-card-img">
                            <img src="https://i.ibb.co/JtSDrQR/research-collaboration.jpg"
                                alt="Kolaborasi penelitian antar dosen">
                        </div>
                        <div class="lecturer-card-content">
                            <h3 class="text-xl font-bold">Research Fellowship</h3>
                            <p>Program fellowship penelitian di universitas mitra internasional, memberikan kesempatan
                                bagi dosen UNJ untuk melakukan riset kolaboratif bersama pakar global.</p>
                            <a href="#" class="lecturer-btn">Pelajari Lebih Lanjut</a>
                        </div>
                    </div>
                    <div class="lecturer-card">
                        <div class="lecturer-card-img">
                            <img src="https://i.ibb.co/QNpZtJF/academic-writing.jpg" alt="Pelatihan penulisan akademik">
                        </div>
                        <div class="lecturer-card-content">
                            <h3 class="text-xl font-bold">Academic Writing Support</h3>
                            <p>Program pendampingan penulisan artikel ilmiah dalam bahasa Inggris untuk publikasi di
                                jurnal terindeks Scopus dan Web of Science, termasuk pelatihan dan layanan proofreading.
                            </p>
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
                            <p>Workshop dan pelatihan untuk meningkatkan kompetensi dosen dalam academic writing,
                                research methodology, dan English for Academic Purposes.</p>
                        </div>
                    </div>
                    <div class="lecturer-timeline-item lecturer-timeline-right">
                        <div class="lecturer-timeline-content">
                            <h3 class="font-bold text-teal-700 mb-2">Fase 2: Kolaborasi Penelitian</h3>
                            <p>Membangun kolaborasi penelitian dengan universitas mitra internasional, termasuk joint
                                supervision dan research exchange.</p>
                        </div>
                    </div>
                    <div class="lecturer-timeline-item lecturer-timeline-left">
                        <div class="lecturer-timeline-content">
                            <h3 class="font-bold text-teal-700 mb-2">Fase 3: Publikasi Internasional</h3>
                            <p>Pendampingan publikasi di jurnal terindeks Scopus dan Web of Science, termasuk mentoring
                                oleh profesor dari universitas mitra.</p>
                        </div>
                    </div>
                    <div class="lecturer-timeline-item lecturer-timeline-right">
                        <div class="lecturer-timeline-content">
                            <h3 class="font-bold text-teal-700 mb-2">Fase 4: Diseminasi Ilmiah</h3>
                            <p>Partisipasi aktif di konferensi internasional sebagai presenter, pembicara utama, atau
                                moderator panel diskusi.</p>
                        </div>
                    </div>
                    <div class="lecturer-timeline-item lecturer-timeline-left">
                        <div class="lecturer-timeline-content">
                            <h3 class="font-bold text-teal-700 mb-2">Fase 5: Mobilitas Global</h3>
                            <p>Program visiting professor dan academic exchange dengan universitas mitra di berbagai
                                negara untuk transfer knowledge dan pengalaman.</p>
                        </div>
                    </div>
                </div>
            </section>

            <section class="lecturer-section">
                <h2 class="lecturer-section-title text-3xl font-bold">Program-Program Pendukung</h2>

                <div class="space-y-8 mt-6">
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-xl font-bold text-teal-700 mb-3">English Academic Writing Lab</h3>
                        <p class="mb-4">Laboratorium penulisan ilmiah dalam bahasa Inggris yang menyediakan dukungan
                            teknis dan konsultasi bagi dosen dalam proses penulisan artikel untuk jurnal internasional.
                        </p>
                        <div class="flex flex-wrap gap-2">
                            <span class="bg-teal-100 text-teal-800 px-3 py-1 rounded-full text-sm">Grammar Check</span>
                            <span class="bg-teal-100 text-teal-800 px-3 py-1 rounded-full text-sm">Proof-reading</span>
                            <span class="bg-teal-100 text-teal-800 px-3 py-1 rounded-full text-sm">Journal
                                Selection</span>
                        </div>
                    </div>

                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-xl font-bold text-teal-700 mb-3">International Research Grant</h3>
                        <p class="mb-4">Bantuan pendanaan penelitian kolaboratif dengan mitra internasional untuk
                            menghasilkan publikasi berkualitas tinggi dan memiliki dampak global.</p>
                        <div class="flex flex-wrap gap-2">
                            <span class="bg-teal-100 text-teal-800 px-3 py-1 rounded-full text-sm">Research
                                Funding</span>
                            <span class="bg-teal-100 text-teal-800 px-3 py-1 rounded-full text-sm">International
                                Collaboration</span>
                            <span class="bg-teal-100 text-teal-800 px-3 py-1 rounded-full text-sm">Impact
                                Assessment</span>
                        </div>
                    </div>

                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-xl font-bold text-teal-700 mb-3">Scholarly Publication Incentive</h3>
                        <p class="mb-4">Program insentif untuk memotivasi dan menghargai dosen yang berhasil
                            mempublikasikan karya ilmiah di jurnal internasional bereputasi tinggi.</p>
                        <div class="flex flex-wrap gap-2">
                            <span class="bg-teal-100 text-teal-800 px-3 py-1 rounded-full text-sm">Financial
                                Reward</span>
                            <span class="bg-teal-100 text-teal-800 px-3 py-1 rounded-full text-sm">Academic
                                Recognition</span>
                            <span class="bg-teal-100 text-teal-800 px-3 py-1 rounded-full text-sm">Career
                                Advancement</span>
                        </div>
                    </div>

                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-xl font-bold text-teal-700 mb-3">Global Academic Networks</h3>
                        <p class="mb-4">Pengembangan jaringan akademik global melalui keanggotaan dalam asosiasi
                            profesional internasional dan forum kolaborasi penelitian lintas negara.</p>
                        <div class="flex flex-wrap gap-2">
                            <span class="bg-teal-100 text-teal-800 px-3 py-1 rounded-full text-sm">Professional
                                Memberships</span>
                            <span class="bg-teal-100 text-teal-800 px-3 py-1 rounded-full text-sm">Research
                                Consortiums</span>
                            <span class="bg-teal-100 text-teal-800 px-3 py-1 rounded-full text-sm">Academic
                                Collaborations</span>
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
                                <p class="italic text-gray-700">Program Lecturer Expose sangat membantu saya dalam
                                    mengembangkan keterampilan penulisan akademik dan memperluas jaringan penelitian
                                    internasional. Berkat program ini, artikel saya berhasil diterbitkan di jurnal Q1.
                                </p>
                                <div class="lecturer-testimonial-author">
                                    <div class="lecturer-testimonial-avatar"
                                        style="background-image: url('https://i.ibb.co/WPFpxWk/lecturer-1.jpg');">
                                    </div>
                                    <div>
                                        <p class="font-bold">Dr. Anita Wijaya</p>
                                        <p class="text-sm text-gray-600">Fakultas Matematika dan IPA</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="lecturer-testimonial">
                            <div class="lecturer-testimonial-content">
                                <p class="italic text-gray-700">Kesempatan sebagai visiting researcher di National
                                    University of Singapore membuka wawasan baru dalam metodologi penelitian dan
                                    memungkinkan saya berkolaborasi dengan peneliti terkemuka di bidang saya.</p>
                                <div class="lecturer-testimonial-author">
                                    <div class="lecturer-testimonial-avatar"
                                        style="background-image: url('https://i.ibb.co/zRJThp3/lecturer-2.jpg');">
                                    </div>
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

            <section
                class="bg-gradient-to-r from-teal-700 to-teal-800 text-white p-8 rounded-xl shadow-lg text-center">
                <h2 class="text-3xl font-bold mb-4">Bergabung dengan Program Lecturer Expose</h2>
                <p class="mb-6 max-w-3xl mx-auto">Kembangkan potensi akademik Anda dan berkontribusi dalam peningkatan
                    reputasi global UNJ melalui program Lecturer Expose yang komprehensif.</p>
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="#"
                        class="bg-white text-teal-800 px-6 py-3 rounded-lg font-medium transition-all duration-300 hover:bg-yellow-400 hover:text-teal-900">Daftar
                        Program</a>
                    <a href="#"
                        class="bg-white text-teal-800 px-6 py-3 rounded-lg font-medium transition-all duration-300 hover:bg-yellow-400 hover:text-teal-900">Jadwal
                        Pelatihan</a>
                    <a href="#"
                        class="bg-white text-teal-800 px-6 py-3 rounded-lg font-medium transition-all duration-300 hover:bg-yellow-400 hover:text-teal-900">FAQ</a>
                </div>
            </section>
        </div>
    </div>

    @include('layout.footer')
</body>

</html>
