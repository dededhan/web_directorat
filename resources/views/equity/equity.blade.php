<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Program EQUITY THE Impact Ranking - UNJ</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Lora:wght@500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" type="image/png">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
            <link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" type="image/png">

    <style>
        .equity-page .glassmorphism-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .equity-page .fade-in-up {
            animation: equityFadeInUp 0.8s ease-out forwards;
        }

        @keyframes equityFadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @property --num {
          syntax: '<integer>';
          initial-value: 0;
          inherits: false;
        }

        .equity-page .counter-animation {
            transition: --num 3s;
        }

        .equity-page .animate-blob {
            animation: equityBlob 7s infinite;
        }

        .equity-page .animation-delay-2000 {
            animation-delay: 2s;
        }

        .equity-page .animation-delay-4000 {
            animation-delay: 4s;
        }

        @keyframes equityBlob {
            0% {
                transform: translate(0px, 0px) scale(1);
            }
            33% {
                transform: translate(30px, -50px) scale(1.1);
            }
            66% {
                transform: translate(-20px, 20px) scale(0.9);
            }
            100% {
                transform: translate(0px, 0px) scale(1);
            }
        }

        .equity-page .fas:not(.navbar .fas),
        .equity-page .fab:not(.navbar .fab) {
            font-family: "Font Awesome 6 Free", "Font Awesome 6 Brands" !important;
            font-weight: 900 !important;
        }

        .navbar .fas,
        .navbar .fab {
            font-family: "Font Awesome 6 Free", "Font Awesome 6 Brands" !important;
            font-weight: 900 !important;
        }

        .section-fullscreen {
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        .section-content {
            width: 100%;
            padding: 2rem 0;
        }

        .compact-grid {
            gap: 1rem;
        }

        .compact-card {
            padding: 1rem;
        }

        .compact-text {
            font-size: 0.875rem;
            line-height: 1.4;
        }

        .compact-heading {
            font-size: 1.125rem;
            margin-bottom: 0.5rem;
        }

        .gallery-compact {
            grid-template-rows: repeat(2, 1fr);
            max-height: 60vh;
        }

        .targets-compact {
            gap: 2rem;
        }

        .target-item {
            padding: 1rem;
        }

        .testimonial-compact {
            padding: 1.5rem;
        }

        .navbar {
            position: relative;
            z-index: 9999 !important;
        }

        .desktop-dropdown-menu {
            z-index: 10000 !important;
        }
    </style>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'sans': ['Inter', 'sans-serif'],
                        'serif': ['Lora', 'serif'],
                    },
                    colors: {
                        'brand': {
                            'dark': '#1A1A1A',
                            'light': '#F9F9F9',
                            'accent': '#B8860B',
                            'accent-light': '#D4AC0D',
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="equity-page bg-white font-sans text-brand-dark antialiased">
    @include('layout.navbar')
    
    <main class="pt-16">
        <section class="relative h-screen flex items-center justify-center text-white overflow-hidden">
            <img src="https://images.shiksha.com/mediadata/ugcDocuments/images/wordpressImages/2022_07_What-is-Equity-2.jpg" alt="Equity in Education" class="absolute z-0 w-full h-full object-cover">
            <div class="absolute inset-0 bg-black/60 z-10"></div>
            
            <div class="relative z-20 max-w-4xl mx-auto text-center px-6" x-data="{ visible: false }" x-init="setTimeout(() => { visible = true }, 500)">
                <p class="text-brand-accent-light font-semibold tracking-widest uppercase transition-all duration-700" :class="visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'">Program EQUITY UNJ</p>
                <h1 class="mt-4 text-4xl md:text-6xl font-serif font-bold tracking-tight transition-all duration-1000" :class="visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'">
                    Enhancing Quality Education for International University Impacts and Recognition
                </h1>
                <p class="mt-6 text-lg text-gray-300 transition-all duration-1000 delay-300" :class="visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'">
                    Program strategis untuk mendorong UNJ meraih pengakuan global melalui THE Impact Ranking dengan fokus pencapaian Sustainable Development Goals (SDGs).
                </p>
                <div class="mt-8 transition-all duration-1000 delay-500" :class="visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'">
                    <a href="#program" class="bg-brand-accent hover:bg-brand-accent-light text-white font-bold py-3 px-8 rounded-full transition-transform duration-300 ease-in-out hover:scale-105 shadow-lg">
                        Jelajahi Program EQUITY
                    </a>
                </div>
            </div>
        </section>

        <section id="tentang" class="section-fullscreen bg-brand-light">
            <div class="section-content container mx-auto px-6 lg:px-8">
                <div class="grid lg:grid-cols-5 gap-8 items-center h-full">
                    <div class="lg:col-span-3">
                        <p class="font-semibold text-brand-accent">Latar Belakang Program</p>
                        <h2 class="mt-2 text-3xl font-serif font-bold text-brand-dark">Program <span class="text-brand-accent">EQUITY</span> THE Impact Ranking</h2>
                        <p class="mt-4 text-base text-gray-600">
                            Program <strong>EQUITY (Enhancing Quality Education for International University Impacts and Recognition)</strong> merupakan program strategis Kementerian Pendidikan Tinggi, Sains, dan Teknologi yang dimulai sejak 2023, khusus dirancang untuk memfasilitasi 16 PTNBH dalam meningkatkan kualitas dan mencapai pengakuan global melalui THE Impact Ranking.
                        </p>
                        <p class="mt-3 text-base text-gray-600">
                            UNJ sebagai salah satu dari 16 PTNBH sasaran program ini berkomitmen untuk mencapai target peringkat <strong>Top 600</strong> THE Impact Ranking tahun 2030 melalui implementasi program-program berkelanjutan yang berfokus pada pencapaian Sustainable Development Goals (SDGs).
                        </p>
                        
                        <div class="mt-6 grid sm:grid-cols-2 gap-4">
                            <div class="flex items-start gap-3">
                                <div class="flex-shrink-0 bg-brand-accent/10 p-2 rounded-full mt-1">
                                    <i class="fas fa-graduation-cap text-brand-accent text-lg fa-fw"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-base text-brand-dark">Pendanaan DAPT</h4>
                                    <p class="mt-1 text-sm text-gray-600">Program didanai melalui Dana Abadi Perguruan Tinggi (DAPT) dari LPDP.</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="flex-shrink-0 bg-brand-accent/10 p-2 rounded-full mt-1">
                                    <i class="fas fa-globe text-brand-accent text-lg fa-fw"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-base text-brand-dark">Pencapaian SDGs</h4>
                                    <p class="mt-1 text-sm text-gray-600">Berkontribusi dalam pencapaian 17 tujuan pembangunan berkelanjutan.</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3 col-span-full">
                                <div class="flex-shrink-0 bg-brand-accent/10 p-2 rounded-full mt-1">
                                    <i class="fas fa-chart-line text-brand-accent text-lg fa-fw"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-base text-brand-dark">Target 2025-2030</h4>
                                    <p class="mt-1 text-sm text-gray-600">Program multi-years dengan target UNJ masuk Top 600 THE Impact Ranking 2030.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="lg:col-span-2 hidden lg:block">
                        <div class="relative h-80">
                            <img src="https://www.discovery.org/m/sites/71/2021/07/equity-stockpack-adobe-stock-scaled.jpg" alt="Program EQUITY" class="rounded-xl shadow-2xl w-full h-full object-cover absolute top-0 left-0">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="program" class="section-fullscreen relative overflow-hidden bg-gray-100">
            <div class="absolute top-0 left-0 w-96 h-96 bg-yellow-300 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob"></div>
            <div class="absolute top-0 right-0 w-96 h-96 bg-amber-300 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob animation-delay-2000"></div>
            <div class="absolute bottom-0 left-1/2 w-96 h-96 bg-orange-300 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob animation-delay-4000"></div>

            <div class="section-content container mx-auto px-6 lg:px-8 relative z-10">
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-serif font-bold text-brand-dark">Komponen Program EQUITY UNJ</h2>
                    <p class="mt-2 text-gray-600 max-w-2xl mx-auto">Enam pilar strategis yang menopang pencapaian THE Impact Ranking melalui kontribusi nyata terhadap SDGs.</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 compact-grid max-h-[70vh] overflow-hidden">
                    <!-- Penguatan Kelembagaan -->
                    <div class="glassmorphism-card compact-card rounded-2xl space-y-3">
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-building text-2xl text-brand-dark"></i>
                            <h3 class="text-lg font-serif font-bold text-brand-dark">Penguatan Kelembagaan</h3>
                        </div>
                        <div class="space-y-2">
                            <div class="group">
                                <h4 class="compact-heading font-bold text-brand-dark">Pengelolaan Jurnal Terindeks Scopus/WOS</h4>
                                <p class="text-gray-700 compact-text">Peningkatan kuartil jurnal dan persiapan indeksasi Scopus.</p>
                            </div>
                            <div class="group">
                                <h4 class="compact-heading font-bold text-brand-dark">SDGs Center</h4>
                                <p class="text-gray-700 compact-text">Penguatan pusat koordinasi dan pengelolaan program SDGs.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="glassmorphism-card compact-card rounded-2xl space-y-3">
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-microscope text-2xl text-brand-dark"></i>
                            <h3 class="text-lg font-serif font-bold text-brand-dark">Penelitian & Inovasi</h3>
                        </div>
                        <div class="space-y-2">
                            <div class="group">
                                <h4 class="compact-heading font-bold text-brand-dark">Research Grants</h4>
                                <p class="text-gray-700 compact-text">Hibah penelitian dengan target publikasi Q1 melibatkan mahasiswa pascasarjana.</p>
                            </div>
                            <div class="group">
                                <h4 class="compact-heading font-bold text-brand-dark">Kolaborasi Penelitian</h4>
                                <p class="text-gray-700 compact-text">Kerjasama dengan PTNBH lain dan negara berpenghasilan rendah-menengah.</p>
                            </div>
                            <div class="group">
                                <h4 class="compact-heading font-bold text-brand-dark">Article Processing Cost (APC)</h4>
                                <p class="text-gray-700 compact-text">Dukungan biaya publikasi jurnal Q1 terindeks Scopus hingga 50 juta.</p>
                            </div>
                        </div>
                    </div>

                    <div class="glassmorphism-card compact-card rounded-2xl space-y-3">
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-user-graduate text-2xl text-brand-dark"></i>
                            <h3 class="text-lg font-serif font-bold text-brand-dark">Pengembangan SDM</h3>
                        </div>
                        <div class="space-y-2">
                            <div class="group">
                                <h4 class="compact-heading font-bold text-brand-dark">Sabbatical Leave</h4>
                                <p class="text-gray-700 compact-text">Program pengembangan dosen di perguruan tinggi Top 500 dunia.</p>
                            </div>
                            <div class="group">
                                <h4 class="compact-heading font-bold text-brand-dark">Konferensi Internasional SDGs</h4>
                                <p class="text-gray-700 compact-text">Presentasi paper dalam konferensi internasional bertema SDGs.</p>
                            </div>
                            <div class="group">
                                <h4 class="compact-heading font-bold text-brand-dark">Visiting Professors</h4>
                                <p class="text-gray-700 compact-text">Mengundang profesor ahli untuk workshop dan joint supervision.</p>
                            </div>
                        </div>
                    </div>

                    <div class="glassmorphism-card compact-card rounded-2xl space-y-3">
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-globe-americas text-2xl text-brand-dark"></i>
                            <h3 class="text-lg font-serif font-bold text-brand-dark">Kerjasama Internasional</h3>
                        </div>
                        <div class="space-y-2">
                            <div class="group">
                                <h4 class="compact-heading font-bold text-brand-dark">Student Exchange</h4>
                                <p class="text-gray-700 compact-text">Pertukaran mahasiswa inbound dan outbound dengan mitra global.</p>
                            </div>
                            <div class="group">
                                <h4 class="compact-heading font-bold text-brand-dark">Summer Course SDGs</h4>
                                <p class="text-gray-700 compact-text">Penyelenggaraan kursus musim panas dengan fokus SDGs.</p>
                            </div>
                            <div class="group">
                                <h4 class="compact-heading font-bold text-brand-dark">Community Development</h4>
                                <p class="text-gray-700 compact-text">Program pemberdayaan masyarakat bersama universitas luar negeri.</p>
                            </div>
                        </div>
                    </div>

                    <div class="glassmorphism-card compact-card rounded-2xl space-y-3">
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-bullhorn text-2xl text-brand-dark"></i>
                            <h3 class="text-lg font-serif font-bold text-brand-dark">Promosi Global</h3>
                        </div>
                        <div class="space-y-2">
                            <div class="group">
                                <h4 class="compact-heading font-bold text-brand-dark">Education Exhibitions</h4>
                                <p class="text-gray-700 compact-text">Partisipasi dalam pameran pendidikan internasional QS dan THE.</p>
                            </div>
                            <div class="group">
                                <h4 class="compact-heading font-bold text-brand-dark">Konferensi Internasional</h4>
                                <p class="text-gray-700 compact-text">Penyelenggaraan konferensi/workshop dengan prosiding terindeks Scopus.</p>
                            </div>
                            <div class="group">
                                <h4 class="compact-heading font-bold text-brand-dark">Employer Meeting</h4>
                                <p class="text-gray-700 compact-text">Workshop dengan pengguna lulusan untuk meningkatkan reputasi.</p>
                            </div>
                        </div>
                    </div>

                    <div class="glassmorphism-card compact-card rounded-2xl space-y-3">
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-cogs text-2xl text-brand-dark"></i>
                            <h3 class="text-lg font-serif font-bold text-brand-dark">Pengelolaan Program</h3>
                        </div>
                        <div class="space-y-2">
                            <div class="group">
                                <h4 class="compact-heading font-bold text-brand-dark">Tim Pengelola EQUITY</h4>
                                <p class="text-gray-700 compact-text">Manajemen profesional program dengan maksimal 3% dari total anggaran.</p>
                            </div>
                            <div class="group">
                                <h4 class="compact-heading font-bold text-brand-dark">Monitoring & Evaluasi</h4>
                                <p class="text-gray-700 compact-text">Sistem pemantauan berkelanjutan untuk memastikan pencapaian target.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="galeri" class="section-fullscreen bg-white">
            <div class="section-content container mx-auto px-6 lg:px-8">
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-serif font-bold text-brand-dark">Galeri Kegiatan Program EQUITY</h2>
                    <p class="mt-2 text-gray-500 max-w-2xl mx-auto">Dokumentasi implementasi program EQUITY UNJ dalam mendukung pencapaian SDGs dan peningkatan reputasi global.</p>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3 gallery-compact auto-rows-fr">
                    <div class="relative group overflow-hidden rounded-lg shadow-lg md:col-span-2 md:row-span-2">
                        <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?q=80&w=2071&auto=format&fit=crop" alt="Penelitian Kolaboratif" class="w-full h-full object-cover transition-transform duration-500 ease-in-out group-hover:scale-110">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <p class="absolute bottom-4 left-4 text-white font-bold">Penelitian Kolaboratif</p>
                        </div>
                    </div>
                    <div class="relative group overflow-hidden rounded-lg shadow-lg">
                        <img src="https://images.unsplash.com/photo-1556761175-5973dc0f32e7?q=80&w=1932&auto=format&fit=crop" alt="Kerjasama Internasional" class="w-full h-full object-cover transition-transform duration-500 ease-in-out group-hover:scale-110">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <p class="absolute bottom-4 left-4 text-white font-bold">Kerjasama Internasional</p>
                        </div>
                    </div>
                    <div class="relative group overflow-hidden rounded-lg shadow-lg">
                        <img src="https://images.unsplash.com/photo-1542744173-8e7e53415bb0?q=80&w=2070&auto=format&fit=crop" alt="SDGs Workshop" class="w-full h-full object-cover transition-transform duration-500 ease-in-out group-hover:scale-110">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <p class="absolute bottom-4 left-4 text-white font-bold">SDGs Workshop</p>
                        </div>
                    </div>
                    <div class="relative group overflow-hidden rounded-lg shadow-lg">
                        <img src="https://images.unsplash.com/photo-1505373877841-8d25f7d46678?q=80&w=2012&auto=format&fit=crop" alt="Konferensi Internasional" class="w-full h-full object-cover transition-transform duration-500 ease-in-out group-hover:scale-110">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <p class="absolute bottom-4 left-4 text-white font-bold">Konferensi Internasional</p>
                        </div>
                    </div>
                    <div class="relative group overflow-hidden rounded-lg shadow-lg md:col-span-2">
                        <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?q=80&w=2070&auto=format&fit=crop" alt="Community Development" class="w-full h-full object-cover transition-transform duration-500 ease-in-out group-hover:scale-110">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <p class="absolute bottom-4 left-4 text-white font-bold">Community Development</p>
                        </div>
                    </div>
                    <div class="relative group overflow-hidden rounded-lg shadow-lg">
                        <img src="https://images.unsplash.com/photo-1573164713988-8665fc963095?q=80&w=2069&auto=format&fit=crop" alt="Visiting Professor" class="w-full h-full object-cover transition-transform duration-500 ease-in-out group-hover:scale-110">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <p class="absolute bottom-4 left-4 text-white font-bold">Visiting Professor</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="dampak" class="section-fullscreen bg-brand-dark text-white">
            <div class="section-content container mx-auto px-6 lg:px-8">
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-serif font-bold">Target Pencapaian Program EQUITY</h2>
                    <p class="mt-2 text-gray-400 max-w-2xl mx-auto">Target strategis UNJ dalam Program EQUITY THE Impact Ranking 2025-2030.</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 targets-compact text-center mb-8" x-data="equityCounter()" x-intersect="start()">
                    <div class="fade-in-up target-item">
                        <i class="fas fa-trophy text-4xl text-brand-accent mb-3"></i>
                        <h3 class="text-4xl font-bold counter-animation" style="--num: 600">
                            <span x-text="Math.round(num1)">0</span>
                        </h3>
                        <p class="mt-1 text-gray-300 text-base">Target Peringkat THE Impact 2030</p>
                        <p class="text-xs text-gray-400">Top 600 Global Ranking</p>
                    </div>
                    <div class="fade-in-up target-item" style="animation-delay: 200ms;">
                        <i class="fas fa-calendar-alt text-4xl text-brand-accent mb-3"></i>
                        <h3 class="text-4xl font-bold counter-animation" style="--num: 5">
                            <span x-text="Math.round(num2)">0</span>
                        </h3>
                        <p class="mt-1 text-gray-300 text-base">Tahun Program</p>
                        <p class="text-xs text-gray-400">2025-2030</p>
                    </div>
                    <div class="fade-in-up target-item" style="animation-delay: 400ms;">
                        <i class="fas fa-bullseye text-4xl text-brand-accent mb-3"></i>
                        <h3 class="text-4xl font-bold counter-animation" style="--num: 17">
                             <span x-text="Math.round(num3)">0</span>
                        </h3>
                        <p class="mt-1 text-gray-300 text-base">Sustainable Development Goals</p>
                        <p class="text-xs text-gray-400">Kontribusi pada semua SDGs</p>
                    </div>
                </div>
                
                <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6">
                    <h3 class="text-xl font-bold text-center mb-6">Roadmap Pencapaian UNJ</h3>
                    <div class="grid grid-cols-1 md:grid-cols-5 gap-3 text-center">
                        <div class="bg-white/5 rounded-lg p-3">
                            <div class="text-xl font-bold text-brand-accent">2026</div>
                            <div class="text-sm">601-700</div>
                        </div>
                        <div class="bg-white/5 rounded-lg p-3">
                            <div class="text-xl font-bold text-brand-accent">2027</div>
                            <div class="text-sm">601-700</div>
                        </div>
                        <div class="bg-white/5 rounded-lg p-3">
                            <div class="text-xl font-bold text-brand-accent">2028</div>
                            <div class="text-sm">501-600</div>
                        </div>
                        <div class="bg-white/5 rounded-lg p-3">
                            <div class="text-xl font-bold text-brand-accent">2029</div>
                            <div class="text-sm">501-600</div>
                        </div>
                        <div class="bg-white/10 rounded-lg p-3 border-2 border-brand-accent">
                            <div class="text-xl font-bold text-brand-accent">2030</div>
                            <div class="text-sm font-bold">501-600</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="testimoni" class="section-fullscreen bg-brand-light">
            <div class="section-content container mx-auto px-6 lg:px-8">
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-serif font-bold text-brand-dark">Komitmen UNJ untuk Program EQUITY</h2>
                    <p class="mt-2 text-gray-500 max-w-2xl mx-auto">Dukungan penuh sivitas akademika UNJ dalam mencapai target THE Impact Ranking melalui kontribusi nyata pada SDGs.</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 compact-grid">
                    <div class="bg-white testimonial-compact rounded-lg shadow-lg">
                        <i class="fas fa-quote-left text-brand-accent text-2xl mb-3"></i>
                        <p class="text-gray-600 mb-4 compact-text">"Program EQUITY memberikan kesempatan luar biasa bagi UNJ untuk berkontribusi langsung pada pencapaian SDGs sekaligus meningkatkan reputasi global universitas."</p>
                        <div class="flex items-center">
                            <img class="w-10 h-10 rounded-full mr-3" src="https://i.pravatar.cc/150?img=1" alt="Avatar of person">
                            <div>
                                <h4 class="font-bold text-brand-dark text-sm">Prof. Dr.</h4>
                                <p class="text-xs text-gray-500">Universitas Negeri Jakarta</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white testimonial-compact rounded-lg shadow-lg">
                        <i class="fas fa-quote-left text-brand-accent text-2xl mb-3"></i>
                        <p class="text-gray-600 mb-4 compact-text">"Melalui pendanaan DAPT dari LPDP, kami dapat mengimplementasikan program-program berkelanjutan yang berdampak nyata bagi masyarakat dan lingkungan."</p>
                        <div class="flex items-center">
                            <img class="w-10 h-10 rounded-full mr-3" src="https://i.pravatar.cc/150?img=2" alt="Avatar of person">
                            <div>
                                <h4 class="font-bold text-brand-dark text-sm">Dr. M.Si.</h4>
                                <p class="text-xs text-gray-500">Direktur Program</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white testimonial-compact rounded-lg shadow-lg">
                        <i class="fas fa-quote-left text-brand-accent text-2xl mb-3"></i>
                        <p class="text-gray-600 mb-4 compact-text">"Kolaborasi riset internasional dalam Program EQUITY membuka peluang kerjasama dengan negara berkembang untuk saling memperkuat kapasitas penelitian."</p>
                        <div class="flex items-center">
                            <img class="w-10 h-10 rounded-full mr-3" src="https://i.pravatar.cc/150?img=3" alt="Avatar of person">
                            <div>
                                <h4 class="font-bold text-brand-dark text-sm">Prof. Dr. M.Pd.</h4>
                                <p class="text-xs text-gray-500">Wakil Rektor</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    
    @include('layout.footer')

    <script>
        function equityCounter() {
            return {
                num1: 0,
                num2: 0,
                num3: 0,
                start() {
                    const animate = (targetNum, propName) => {
                        const el = document.querySelector(`[style*="--num: ${targetNum}"]`);
                        if (!el) return;
                        
                        const observer = new IntersectionObserver((entries) => {
                            if (entries[0].isIntersecting) {
                                let start = 0;
                                const end = targetNum;
                                const duration = 2000;
                                
                                const step = (timestamp) => {
                                    if (!start) start = timestamp;
                                    const progress = timestamp - start;
                                    const current = Math.min(Math.floor(progress / duration * end), end);
                                    this[propName] = current;
                                    
                                    if (progress < duration) {
                                        window.requestAnimationFrame(step);
                                    }
                                };
                                window.requestAnimationFrame(step);
                                observer.unobserve(el);
                            }
                        }, { threshold: 0.1 });
                        
                        observer.observe(el);
                    };
                    
                    animate(600, 'num1');
                    animate(5, 'num2');
                    animate(17, 'num3');
                }
            }
        }

        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            // Add body class untuk styling scoped
            document.body.classList.add('has-navbar');
            
            // FIXED: Only apply Font Awesome styling to page icons, not navbar icons
            const equityPageIcons = document.querySelectorAll('.equity-page .fas:not(.navbar .fas), .equity-page .fab:not(.navbar .fab)');
            equityPageIcons.forEach(icon => {
                if (!icon.closest('.navbar')) {
                    icon.style.fontFamily = '"Font Awesome 6 Free", "Font Awesome 6 Brands"';
                    icon.style.fontWeight = '900';
                }
            });
            if (!window.desktopDropdownInitialized) {
                window.desktopDropdownInitialized = true;
                
                const desktopDropdownToggles = document.querySelectorAll('.desktop-dropdown-toggle');
                const desktopDropdownMenus = document.querySelectorAll('.desktop-dropdown-menu');

                desktopDropdownToggles.forEach((toggle, index) => {
                    const menu = desktopDropdownMenus[index];
                    if (!menu) return;
                    
                    toggle.addEventListener('click', function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        
                        // Close other dropdowns
                        desktopDropdownMenus.forEach((otherMenu, otherIndex) => {
                            if (otherIndex !== index && otherMenu) {
                                otherMenu.classList.add('hidden');
                            }
                        });
                        
                        // Toggle current dropdown
                        menu.classList.toggle('hidden');
                    });
                });

                document.addEventListener('click', function(e) {
                    if (!e.target.closest('.desktop-dropdown-toggle') && !e.target.closest('.desktop-dropdown-menu')) {
                        desktopDropdownMenus.forEach(menu => {
                            if (menu) menu.classList.add('hidden');
                        });
                    }
                });

                desktopDropdownMenus.forEach(menu => {
                    if (menu) {
                        menu.addEventListener('click', function(e) {
                            e.stopPropagation();
                        });
                    }
                });
            }
        });
    </script>
</body>
</html>