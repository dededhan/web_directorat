<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Global Engagement UNJ</title>
    <link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" type="image/png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <style>
        * {
            font-family: 'Poppins', sans-serif !important;
        }
        
        :root {
            --primary-color: #186862;
            --secondary-color: #125a54;
            --accent-color: #facc15;
            --light-color: #ecf0f1;
            --dark-color: #34495e;
        }

        .bg-primary { background-color: var(--primary-color); }
        .text-primary { color: var(--primary-color); }
        .border-primary { border-color: var(--primary-color); }
        .bg-accent { background-color: var(--accent-color); }
        .text-accent { color: var(--accent-color); }

        .global-hero {
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('https://media.quipper.com/media/W1siZiIsIjIwMTgvMDEvMjMvMDkvNDMvMjcvYWVjNTQ1OTctOTJiNi00Y2EyLWEzZDctMGZiNTg1ZTU1MDEzLyJdLFsicCIsInRodW1iIiwiMTIwMHhcdTAwM2UiLHt9XSxbInAiLCJjb252ZXJ0IiwiLWNvbG9yc3BhY2Ugc1JHQiAtc3RyaXAiLHsiZm9ybWF0IjoianBnIn1dXQ?sha=9c61a35270604434') center/cover no-repeat;
            height: 500px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-align: center;
            position: relative;
            margin-bottom: 0;
        }

        .global-hero::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 5rem;
            background: linear-gradient(to top, white, transparent);
        }

        .global-hero-content {
            max-width: 900px;
            padding: 2rem;
            z-index: 10;
        }

        .global-intro {
            background-color: white;
            margin-top: -4rem;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            position: relative;
            z-index: 20;
            padding: 3rem;
        }

        .global-program {
            margin-bottom: 2.5rem;
            padding: 2rem;
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            border-left: 5px solid var(--primary-color);
            position: relative;
            overflow: hidden;
        }
        
        .global-program:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }
        
        .global-program::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(24, 104, 98, 0.05) 0%, rgba(255, 255, 255, 0) 100%);
            z-index: 0;
        }

        .global-program-content {
            position: relative;
            z-index: 1;
        }

        .global-program h3 {
            color: var(--primary-color);
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            font-weight: 600;
        }
        
        .program-number {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background-color: var(--primary-color);
            color: white;
            border-radius: 50%;
            margin-right: 12px;
            font-size: 1.1rem;
            font-weight: 600;
        }
        
        .section-heading {
            position: relative;
            display: inline-block;
            padding-bottom: 1rem;
            margin-bottom: 2rem;
        }
        
        .section-heading::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 80px;
            height: 4px;
            background-color: var(--accent-color);
        }
        
        .highlight {
            position: relative;
            display: inline-block;
        }
        
        .highlight::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 4px;
            width: 100%;
            height: 8px;
            background-color: rgba(250, 204, 21, 0.3);
            z-index: -1;
        }
        
        .list-icon {
            color: var(--primary-color);
            margin-right: 8px;
        }
        
        .back-to-top {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            background-color: var(--primary-color);
            color: white;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
            z-index: 100;
        }
        
        .back-to-top:hover {
            background-color: var(--accent-color);
            color: var(--primary-color);
            transform: translateY(-5px);
        }

        @media (max-width: 768px) {
            .global-hero {
                height: 400px;
            }

            .global-hero h2 {
                font-size: 1.8rem;
            }
            
            .global-intro {
                padding: 2rem;
                margin-top: -3rem;
            }
            
            .global-program {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body class="bg-gray-50">
    @include('layout.navbarpemeringkatan')

    <div x-data="{ showBackToTop: false }" @scroll.window="showBackToTop = window.pageYOffset > 500">
        <div class="global-hero">
            <div class="global-hero-content">
                <h2 class="text-5xl font-bold mb-6">Global <span class="text-accent">Engagement</span></h2>
                <p class="text-xl font-light mb-8">Program strategis untuk memperluas jejaring internasional dan meningkatkan reputasi Universitas Negeri Jakarta di kancah global</p>
                <a href="#programs" class="inline-flex items-center justify-center bg-primary hover:bg-accent hover:text-primary px-8 py-3 rounded-full text-white font-medium transition-all duration-300 transform hover:scale-105">
                    <span>Jelajahi Program</span>
                    <i class="fas fa-arrow-down ml-2"></i>
                </a>
            </div>
        </div>

        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="global-intro">
                <h2 class="section-heading text-3xl font-bold text-primary">Tentang Global Engagement</h2>
                <div class="space-y-6">
                    <p class="text-gray-700 leading-relaxed">
                        <strong class="highlight">Global Engagement Universitas Negeri Jakarta (UNJ)</strong> merupakan salah
                        satu pilar strategis dalam mendorong internasionalisasi institusi
                        pendidikan tinggi. Melalui berbagai program unggulan, UNJ berkomitmen
                        untuk memperluas jejaring global, meningkatkan daya saing akademik,
                        serta memperkuat posisi institusi di kancah internasional. Global
                        engagement bukan hanya sebatas kolaborasi luar negeri, tetapi juga
                        mencakup transformasi internal yang mendukung kualitas pendidikan,
                        penelitian, dan pengabdian pada masyarakat dengan perspektif global.
                    </p>
                    
                    <p class="text-gray-700 leading-relaxed">
                        Tujuh program utama dalam Global Engagement UNJ dirancang secara
                        komprehensif untuk menjawab tantangan internasionalisasi kampus.
                        Program-program ini mencakup pemantauan profil institusi dan SDM,
                        pengelolaan staf akademik internasional, mobilitas mahasiswa,
                        optimalisasi visibilitas digital melalui SEO, serta peningkatan
                        kapasitas dosen dalam membranding karya akademik. Selain itu, UNJ juga
                        memberikan dukungan publikasi open access dan aktif mendaftarkan diri
                        dalam sistem pemeringkatan internasional sebagai upaya strategis untuk
                        menampilkan kualitas akademik dan institusionalnya secara global.
                    </p>
                    
                    <p class="text-gray-700 leading-relaxed">
                        Melalui pendekatan yang terintegrasi ini, UNJ berupaya mewujudkan visi
                        menjadi universitas bereputasi internasional yang unggul dalam bidang
                        pendidikan dan keguruan. Global Engagement tidak hanya menjadi sarana
                        promosi institusi, tetapi juga menciptakan ekosistem akademik yang
                        inklusif, kolaboratif, dan relevan dengan perkembangan ilmu pengetahuan
                        dan teknologi di tingkat global. Dengan sinergi seluruh elemen kampus,
                        UNJ siap bersaing dan berkontribusi dalam komunitas pendidikan
                        internasional.
                    </p>
                </div>
            </div>

            <section id="programs" class="mt-16 mb-20">
                <div class="flex items-center justify-center mb-12">
                    <div class="h-1 bg-primary rounded-full w-12 mr-3"></div>
                    <h2 class="text-4xl font-bold text-primary">Program Global Engagement</h2>
                    <div class="h-1 bg-primary rounded-full w-12 ml-3"></div>
                </div>
                
                <div class="space-y-8">
                    <div class="global-program">
                        <div class="global-program-content">
                            <h3 class="text-2xl">
                                <span class="program-number">1</span>
                                Monitoring Profil UNJ, Fakultas, Prodi, Dosen
                            </h3>
                            <p class="mb-4 text-gray-700">Program ini bertujuan untuk melakukan pemantauan dan pembaruan secara
                            berkala terhadap profil institusi, baik di tingkat universitas,
                            fakultas, program studi, maupun dosen.</p>
                            
                            <div class="bg-gray-50 p-5 rounded-lg mb-4">
                                <p class="font-semibold mb-2 text-primary">Tujuan utama:</p>
                                <ul class="space-y-2">
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle list-icon mt-1"></i>
                                        <span>Menjaga akurasi dan keterkinian data profil akademik.</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle list-icon mt-1"></i>
                                        <span>Menyediakan informasi strategis untuk keperluan akreditasi dan
                                        pemeringkatan internasional.</span>
                                    </li>
                                </ul>
                            </div>
                            
                            <div class="bg-gray-50 p-5 rounded-lg">
                                <p class="font-semibold mb-2 text-primary">Kegiatan:</p>
                                <ul class="space-y-2">
                                    <li class="flex items-start">
                                        <i class="fas fa-arrow-right list-icon mt-1"></i>
                                        <span>Sinkronisasi data profil di website resmi dan sistem internal.</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-arrow-right list-icon mt-1"></i>
                                        <span>Audit konten digital fakultas dan prodi.</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-arrow-right list-icon mt-1"></i>
                                        <span>Pemutakhiran CV dan profil dosen pada platform akademik (SINTA,
                                        Scopus, ORCID).</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <div class="global-program">
                        <div class="global-program-content">
                            <h3 class="text-2xl">
                                <span class="program-number">2</span>
                                Pengelolaan International Academic Staff
                            </h3>
                            <p class="mb-4 text-gray-700">Program ini mendukung perekrutan dan pengelolaan dosen atau peneliti
                            dari luar negeri untuk memperkuat kolaborasi akademik internasional.</p>
                            
                            <div class="bg-gray-50 p-5 rounded-lg mb-4">
                                <p class="font-semibold mb-2 text-primary">Tujuan:</p>
                                <ul class="space-y-2">
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle list-icon mt-1"></i>
                                        <span>Meningkatkan internasionalisasi pembelajaran dan riset.</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle list-icon mt-1"></i>
                                        <span>Memperkaya atmosfer akademik dengan perspektif global.</span>
                                    </li>
                                </ul>
                            </div>
                            
                            <div class="bg-gray-50 p-5 rounded-lg">
                                <p class="font-semibold mb-2 text-primary">Aktivitas:</p>
                                <ul class="space-y-2">
                                    <li class="flex items-start">
                                        <i class="fas fa-arrow-right list-icon mt-1"></i>
                                        <span>Rekrutmen dosen asing, visiting professor, co-teaching, atau adjunct
                                        professor.</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-arrow-right list-icon mt-1"></i>
                                        <span>Pengurusan visa, kontrak kerja, dan administrasi.</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-arrow-right list-icon mt-1"></i>
                                        <span>Fasilitasi adaptasi budaya dan integrasi akademik di UNJ.</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <div class="global-program">
                        <div class="global-program-content">
                            <h3 class="text-2xl">
                                <span class="program-number">3</span>
                                Pengelolaan International Student's Mobility
                            </h3>
                            <p class="mb-4 text-gray-700">Program ini berfokus pada fasilitasi mobilitas mahasiswa asing ke UNJ
                            maupun mahasiswa UNJ ke luar negeri.</p>
                            
                            <div class="bg-gray-50 p-5 rounded-lg mb-4">
                                <p class="font-semibold mb-2 text-primary">Tujuan:</p>
                                <ul class="space-y-2">
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle list-icon mt-1"></i>
                                        <span>Meningkatkan pengalaman internasional mahasiswa.</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle list-icon mt-1"></i>
                                        <span>Membangun jejaring global antar institusi pendidikan.</span>
                                    </li>
                                </ul>
                            </div>
                            
                            <div class="bg-gray-50 p-5 rounded-lg">
                                <p class="font-semibold mb-2 text-primary">Kegiatan:</p>
                                <ul class="space-y-2">
                                    <li class="flex items-start">
                                        <i class="fas fa-arrow-right list-icon mt-1"></i>
                                        <span>Koordinasi program pertukaran pelajar, transfer kredit, dan summer
                                        school.</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-arrow-right list-icon mt-1"></i>
                                        <span>Penerimaan inbound students dan pengiriman outbound students.</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-arrow-right list-icon mt-1"></i>
                                        <span>Peningkatan layanan informasi, akademik, dan kebudayaan untuk
                                        mahasiswa internasional.</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <div class="global-program">
                        <div class="global-program-content">
                            <h3 class="text-2xl">
                                <span class="program-number">4</span>
                                Pengelolaan SEO Tools
                            </h3>
                            <p class="mb-4 text-gray-700">Program ini bertujuan untuk mengoptimalkan visibilitas digital UNJ di
                            mesin pencari melalui penerapan SEO (Search Engine Optimization).</p>
                            
                            <div class="bg-gray-50 p-5 rounded-lg mb-4">
                                <p class="font-semibold mb-2 text-primary">Tujuan:</p>
                                <ul class="space-y-2">
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle list-icon mt-1"></i>
                                        <span>Meningkatkan eksistensi UNJ secara global.</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle list-icon mt-1"></i>
                                        <span>Memperkuat posisi UNJ di dunia maya sebagai institusi akademik
                                        berkualitas.</span>
                                    </li>
                                </ul>
                            </div>
                            
                            <div class="bg-gray-50 p-5 rounded-lg">
                                <p class="font-semibold mb-2 text-primary">Kegiatan:</p>
                                <ul class="space-y-2">
                                    <li class="flex items-start">
                                        <i class="fas fa-arrow-right list-icon mt-1"></i>
                                        <span>Audit dan optimasi konten website.</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-arrow-right list-icon mt-1"></i>
                                        <span>Penggunaan kata kunci strategis terkait pendidikan dan riset.</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-arrow-right list-icon mt-1"></i>
                                        <span>Integrasi data website dengan Google Analytics dan alat SEO lainnya.</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <div class="global-program">
                        <div class="global-program-content">
                            <h3 class="text-2xl">
                                <span class="program-number">5</span>
                                Upgrading Dosen dalam Membranding Karya Akademik
                            </h3>
                            <p class="mb-4 text-gray-700">Program ini membantu dosen dalam mempromosikan karya ilmiah dan
                            portofolio akademik melalui platform digital global.</p>
                            
                            <div class="bg-gray-50 p-5 rounded-lg mb-4">
                                <p class="font-semibold mb-2 text-primary">Tujuan:</p>
                                <ul class="space-y-2">
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle list-icon mt-1"></i>
                                        <span>Meningkatkan personal branding akademik dosen.</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle list-icon mt-1"></i>
                                        <span>Memperluas jangkauan dampak ilmiah karya dosen.</span>
                                    </li>
                                </ul>
                            </div>
                            
                            <div class="bg-gray-50 p-5 rounded-lg">
                                <p class="font-semibold mb-2 text-primary">Kegiatan:</p>
                                <ul class="space-y-2">
                                    <li class="flex items-start">
                                        <i class="fas fa-arrow-right list-icon mt-1"></i>
                                        <span>Pelatihan penggunaan Wikipedia, LinkedIn, ResearchGate, Google
                                        Scholar, dan ORCID.</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-arrow-right list-icon mt-1"></i>
                                        <span>Pendampingan dalam mengelola profil profesional dan publikasi.</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-arrow-right list-icon mt-1"></i>
                                        <span>Strategi meningkatkan kutipan dan kolaborasi riset.</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <div class="global-program">
                        <div class="global-program-content">
                            <h3 class="text-2xl">
                                <span class="program-number">6</span>
                                Publication Support Services (Open Access)
                            </h3>
                            <p class="mb-4 text-gray-700">Program ini menyediakan layanan dukungan publikasi untuk dosen dan
                            peneliti UNJ dalam menerbitkan karya ilmiah di jurnal bereputasi dan
                            open access.</p>
                            
                            <div class="bg-gray-50 p-5 rounded-lg mb-4">
                                <p class="font-semibold mb-2 text-primary">Tujuan:</p>
                                <ul class="space-y-2">
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle list-icon mt-1"></i>
                                        <span>Mendorong budaya publikasi internasional.</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle list-icon mt-1"></i>
                                        <span>Meningkatkan jumlah dan kualitas publikasi UNJ.</span>
                                    </li>
                                </ul>
                            </div>
                            
                            <div class="bg-gray-50 p-5 rounded-lg">
                                <p class="font-semibold mb-2 text-primary">Kegiatan:</p>
                                <ul class="space-y-2">
                                    <li class="flex items-start">
                                        <i class="fas fa-arrow-right list-icon mt-1"></i>
                                        <span>Bantuan biaya APC (Article Processing Charges) untuk jurnal open
                                        access.</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-arrow-right list-icon mt-1"></i>
                                        <span>Pendampingan penulisan dan proofreading.</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-arrow-right list-icon mt-1"></i>
                                        <span>Penyediaan klinik artikel dan konsultasi jurnal target.</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <div class="global-program">
                        <div class="global-program-content">
                            <h3 class="text-2xl">
                                <span class="program-number">7</span>
                                Pendaftaran UNJ dalam Sistem Pemeringkatan Internasional
                            </h3>
                            <p class="mb-4 text-gray-700">Program ini berupaya mendaftarkan dan mengikutsertakan UNJ dalam
                            berbagai sistem pemeringkatan internasional, seperti QS, THE,
                            Webometrics, dan UI Green Metrics.</p>
                            
                            <div class="bg-gray-50 p-5 rounded-lg mb-4">
                                <p class="font-semibold mb-2 text-primary">Tujuan:</p>
                                <ul class="space-y-2">
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle list-icon mt-1"></i>
                                        <span>Meningkatkan daya saing dan reputasi UNJ secara global.</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle list-icon mt-1"></i>
                                        <span>Mengukur performa institusi dalam skala internasional.</span>
                                    </li>
                                </ul>
                            </div>
                            
                            <div class="bg-gray-50 p-5 rounded-lg">
                                <p class="font-semibold mb-2 text-primary">Kegiatan:</p>
                                <ul class="space-y-2">
                                    <li class="flex items-start">
                                        <i class="fas fa-arrow-right list-icon mt-1"></i>
                                        <span>Pengumpulan dan validasi data indikator pemeringkatan.</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-arrow-right list-icon mt-1"></i>
                                        <span>Kolaborasi lintas unit untuk pengisian data.</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-arrow-right list-icon mt-1"></i>
                                        <span>Evaluasi dan strategi peningkatan posisi dalam pemeringkatan
                                        global.</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            
            <section class="bg-gradient-to-r from-teal-700 to-teal-800 text-white p-8 rounded-xl shadow-xl text-center mb-12">
                <h2 class="text-3xl font-bold mb-6">Mari Bergabung dalam Program Global Engagement UNJ</h2>
                <p class="mb-8 max-w-3xl mx-auto">Tingkatkan pengalaman akademik dan perluas jejaring internasional melalui berbagai program global engagement yang ditawarkan oleh Universitas Negeri Jakarta.</p>
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="#" class="bg-white text-teal-800 px-6 py-3 rounded-lg font-medium transition-all duration-300 hover:bg-yellow-400 hover:text-teal-900 hover:scale-105 transform">
                        <i class="fas fa-envelope mr-2"></i>
                        Hubungi Kami
                    </a>
                    <a href="#" class="bg-accent text-teal-900 px-6 py-3 rounded-lg font-medium transition-all duration-300 hover:bg-white hover:text-teal-800 hover:scale-105 transform">
                        <i class="fas fa-globe mr-2"></i>
                        Program Internasional
                    </a>
                    <a href="#" class="border-2 border-white text-white px-6 py-3 rounded-lg font-medium transition-all duration-300 hover:bg-white hover:text-teal-800 hover:scale-105 transform">
                        <i class="fas fa-users mr-2"></i>
                        Menjadi Mitra
                    </a>
                </div>
            </section>
        </div>
        
        <a href="#" 
           class="back-to-top"
           x-show="showBackToTop"
           x-transition:enter="transition ease-out duration-300"
           x-transition:enter-start="opacity-0 transform translate-y-10"
           x-transition:enter-end="opacity-100 transform translate-y-0"
           x-transition:leave="transition ease-in duration-300"
           x-transition:leave-start="opacity-100 transform translate-y-0"
           x-transition:leave-end="opacity-0 transform translate-y-10">
            <i class="fas fa-arrow-up"></i>
        </a>
    </div>
    
    @include('layout.footer')
    
    <script>
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                
                const targetId = this.getAttribute('href');
                if (targetId === '#') return;
                
                const targetElement = document.querySelector(targetId);
                if (targetElement) {
                    window.scrollTo({
                        top: targetElement.offsetTop - 100,
                        behavior: 'smooth'
                    });
                }
            });
        });
    </script>
</body>
</html>