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

    <style>
        .glassmorphism-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .fade-in-up {
            animation: fadeInUp 0.8s ease-out forwards;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .counter-animation {
            transition: --num 3s;
        }

        .animate-blob {
            animation: blob 7s infinite;
        }

        .animation-delay-2000 {
            animation-delay: 2s;
        }

        .animation-delay-4000 {
            animation-delay: 4s;
        }

        @keyframes blob {
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

        .fas, .fab, .fa-solid, .fa-brands {
            font-family: "Font Awesome 6 Free", "Font Awesome 6 Brands" !important;
            font-weight: 900 !important;
        }

        .navbar .fas,
        .navbar .fab,
        nav .fas,
        nav .fab {
            font-family: "Font Awesome 6 Free", "Font Awesome 6 Brands" !important;
            font-weight: 900 !important;
        }

        #mobile-navbar .fas,
        #mobile-navbar .fab,
        #mobile-sidebar .fas,
        #mobile-sidebar .fab {
            font-family: "Font Awesome 6 Free", "Font Awesome 6 Brands" !important;
            font-weight: 900 !important;
        }

        .navbar {
            z-index: 9999 !important;
        }

        .desktop-dropdown-menu {
            z-index: 10000 !important;
        }

        @media (max-width: 768px) {
            .mobile-hidden {
                display: none;
            }
            
            .mobile-text-sm {
                font-size: 0.875rem;
            }
            
            .mobile-p-4 {
                padding: 1rem;
            }
            
            .mobile-gap-4 {
                gap: 1rem;
            }
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

@include('layout.loginpopup')
<body class="bg-white font-sans text-brand-dark antialiased">
    @include('layout.navbar')

    <main class="pt-16 md:pt-20">
        <section class="relative flex items-center justify-center text-white overflow-hidden px-4 sm:px-6 min-h-screen">
            <img src="https://media.istockphoto.com/id/508544168/id/foto/latar-belakang-langit-biru-jernih.jpg?s=170667a&w=0&k=20&c=GHzqHdsJE_sIPV_I4v2vcfGjwBV0Y_gYBC1NTVBkbTQ=" alt="Equity in Education" class="absolute inset-0 w-full h-full object-cover">
            <div class="absolute inset-0 bg-black/40"></div>

            <div class="relative w-full max-w-7xl mx-auto">
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 sm:gap-8 items-center justify-items-center">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/9c/Logo_of_Ministry_of_Education_and_Culture_of_Republic_of_Indonesia.svg/250px-Logo_of_Ministry_of_Education_and_Culture_of_Republic_of_Indonesia.svg.png" alt="Logo Tut Wuri Handayani" class="h-20 sm:h-32 lg:h-48 object-contain">
                    <img src="https://pnn.ac.id/media/2025/05/Logo-Tersier-Diktisaintek-Berdampak-1-1024x1024.png" alt="Logo Kemendiksaintek" class="h-20 sm:h-32 lg:h-48 object-contain">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" alt="Logo UNJ" class="h-20 sm:h-32 lg:h-48 object-contain">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/2/27/Logo_resmi_LPDP.png" alt="Logo LPDP" class="h-20 sm:h-32 lg:h-48 object-contain">
                </div>
            </div>
        </section>

        <section id="tentang" class="min-h-screen flex items-center bg-brand-light py-12 sm:py-16">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid lg:grid-cols-2 gap-8 lg:gap-12 items-center">
                    <div class="order-2 lg:order-1">
                        <img src="https://www.discovery.org/m/sites/71/2021/07/equity-stockpack-adobe-stock-scaled.jpg" 
                             alt="Program EQUITY" 
                             class="rounded-xl shadow-2xl w-full h-64 sm:h-80 lg:h-[500px] object-cover">
                    </div>
                    <div class="order-1 lg:order-2 content-icons">
                        <p class="text-brand-accent-light font-semibold tracking-widest uppercase text-sm">Program EQUITY UNJ</p>
                        <h1 class="mt-4 text-2xl sm:text-3xl lg:text-4xl xl:text-5xl font-serif font-bold tracking-tight text-brand-dark">
                            Enhancing Quality Education for International University Impacts and Recognition
                        </h1>
                        <p class="mt-4 sm:mt-6 text-base sm:text-lg text-gray-700">
                            Program strategis untuk mendorong UNJ meraih pengakuan global melalui THE Impact Ranking dengan fokus pencapaian Sustainable Development Goals (SDGs).
                        </p>
                        <div class="mt-6 sm:mt-8">
                            <a href="#" class="login bg-brand-accent text-white font-bold py-3 px-6 sm:px-8 rounded-full shadow-lg transition-all duration-300 ease-in-out hover:scale-105 hover:brightness-90 active:scale-100 active:brightness-75 text-sm sm:text-base" data-bs-toggle="modal" data-bs-target="#loginModal">
                                Jelajahi Program EQUITY
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="min-h-screen flex items-center bg-white py-12 sm:py-16">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid lg:grid-cols-2 gap-8 lg:gap-12 items-center">
                    <div class="space-y-4 sm:space-y-6 content-icons">
                        <div>
                            <p class="font-semibold text-brand-accent tracking-wide uppercase text-sm">Latar Belakang Program</p>
                            <h2 class="mt-2 text-2xl sm:text-3xl font-serif font-bold text-brand-dark leading-tight">
                                Program <span class="text-brand-accent">EQUITY</span> THE Impact Ranking
                            </h2>
                        </div>

                        <div class="space-y-3 sm:space-y-4">
                            <p class="text-gray-700 leading-relaxed text-sm sm:text-base">
                                Program <strong>EQUITY (Enhancing Quality Education for International University Impacts and Recognition)</strong> 
                                merupakan program strategis Kementerian Pendidikan Tinggi, Sains, dan Teknologi yang dimulai sejak 2023, 
                                khusus dirancang untuk memfasilitasi 16 PTNBH dalam meningkatkan kualitas dan mencapai pengakuan global 
                                melalui THE Impact Ranking.
                            </p>
                            <p class="text-gray-700 leading-relaxed text-sm sm:text-base">
                                UNJ sebagai salah satu dari 16 PTNBH sasaran program ini berkomitmen untuk mencapai target peringkat 
                                <strong>Top 600</strong> THE Impact Ranking tahun 2030.
                            </p>
                        </div>
                        
                        <div class="grid sm:grid-cols-2 gap-4 sm:gap-6">
                            <div class="flex items-start gap-3 group">
                                <div class="flex-shrink-0 bg-brand-accent/10 p-2 rounded-xl group-hover:bg-brand-accent/20 transition-colors">
                                    <i class="fas fa-graduation-cap text-lg text-brand-accent"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-brand-dark text-sm sm:text-base">Pendanaan DAPT</h4>
                                    <p class="text-xs sm:text-sm text-gray-600">Program didanai melalui Dana Abadi Perguruan Tinggi (DAPT) dari LPDP.</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3 group">
                                <div class="flex-shrink-0 bg-brand-accent/10 p-2 rounded-xl group-hover:bg-brand-accent/20 transition-colors">
                                    <i class="fas fa-globe text-lg text-brand-accent"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-brand-dark text-sm sm:text-base">Pencapaian SDGs</h4>
                                    <p class="text-xs sm:text-sm text-gray-600">Berkontribusi dalam pencapaian 17 tujuan pembangunan berkelanjutan.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <img src="https://ditisip.unj.ac.id/storage/ranking-images/1746516869_6819bb859000b.png" 
                             alt="Latar Belakang Program EQUITY" 
                             class="rounded-2xl shadow-2xl w-full h-64 sm:h-80 lg:h-[400px] object-cover hover:scale-[1.02] transition-transform duration-300">
                    </div>
                </div>
            </div>
        </section>

        <section id="program" class="min-h-screen relative overflow-hidden bg-gray-100 py-12 sm:py-16">
            <div class="absolute top-0 left-0 w-48 sm:w-72 lg:w-96 h-48 sm:h-72 lg:h-96 bg-yellow-300 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob"></div>
            <div class="absolute top-0 right-0 w-48 sm:w-72 lg:w-96 h-48 sm:h-72 lg:h-96 bg-amber-300 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob animation-delay-2000"></div>
            <div class="absolute bottom-0 left-1/2 w-48 sm:w-72 lg:w-96 h-48 sm:h-72 lg:h-96 bg-orange-300 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob animation-delay-4000"></div>

            <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="text-center mb-8 sm:mb-12">
                    <h2 class="text-2xl sm:text-3xl font-serif font-bold text-brand-dark">Komponen Program EQUITY UNJ</h2>
                    <p class="mt-2 text-sm sm:text-base text-gray-600 max-w-2xl mx-auto">Enam pilar strategis yang menopang pencapaian THE Impact Ranking melalui kontribusi nyata terhadap SDGs.</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4 sm:gap-6 content-icons">
                    <div class="glassmorphism-card p-4 sm:p-6 rounded-2xl space-y-3 sm:space-y-4">
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-building text-xl sm:text-2xl text-brand-dark"></i>
                            <h3 class="text-base sm:text-lg font-serif font-bold text-brand-dark">Penguatan Kelembagaan</h3>
                        </div>
                        <div class="space-y-2 sm:space-y-3">
                            <div>
                                <h4 class="text-sm sm:text-base font-bold text-brand-dark mb-1">Pengelolaan Jurnal Terindeks Scopus/WOS</h4>
                                <p class="text-xs sm:text-sm text-gray-700">Peningkatan kuartil jurnal dan persiapan indeksasi Scopus.</p>
                            </div>
                            <div>
                                <h4 class="text-sm sm:text-base font-bold text-brand-dark mb-1">SDGs Center</h4>
                                <p class="text-xs sm:text-sm text-gray-700">Penguatan pusat koordinasi dan pengelolaan program SDGs.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="glassmorphism-card p-4 sm:p-6 rounded-2xl space-y-3 sm:space-y-4">
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-microscope text-xl sm:text-2xl text-brand-dark"></i>
                            <h3 class="text-base sm:text-lg font-serif font-bold text-brand-dark">Penelitian & Inovasi</h3>
                        </div>
                        <div class="space-y-2 sm:space-y-3">
                            <div>
                                <h4 class="text-sm sm:text-base font-bold text-brand-dark mb-1">Research Grants</h4>
                                <p class="text-xs sm:text-sm text-gray-700">Hibah penelitian dengan target publikasi Q1 melibatkan mahasiswa pascasarjana.</p>
                            </div>
                            <div>
                                <h4 class="text-sm sm:text-base font-bold text-brand-dark mb-1">Kolaborasi Penelitian</h4>
                                <p class="text-xs sm:text-sm text-gray-700">Kerjasama dengan PTNBH lain dan negara berpenghasilan rendah-menengah.</p>
                            </div>
                            <div>
                                <h4 class="text-sm sm:text-base font-bold text-brand-dark mb-1">Article Processing Cost (APC)</h4>
                                <p class="text-xs sm:text-sm text-gray-700">Dukungan biaya publikasi jurnal Q1 terindeks Scopus hingga 50 juta.</p>
                            </div>
                        </div>
                    </div>

                    <div class="glassmorphism-card p-4 sm:p-6 rounded-2xl space-y-3 sm:space-y-4">
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-user-graduate text-xl sm:text-2xl text-brand-dark"></i>
                            <h3 class="text-base sm:text-lg font-serif font-bold text-brand-dark">Pengembangan SDM</h3>
                        </div>
                        <div class="space-y-2 sm:space-y-3">
                            <div>
                                <h4 class="text-sm sm:text-base font-bold text-brand-dark mb-1">Sabbatical Leave</h4>
                                <p class="text-xs sm:text-sm text-gray-700">Program pengembangan dosen di perguruan tinggi Top 500 dunia.</p>
                            </div>
                            <div>
                                <h4 class="text-sm sm:text-base font-bold text-brand-dark mb-1">Konferensi Internasional SDGs</h4>
                                <p class="text-xs sm:text-sm text-gray-700">Presentasi paper dalam konferensi internasional bertema SDGs.</p>
                            </div>
                            <div>
                                <h4 class="text-sm sm:text-base font-bold text-brand-dark mb-1">Visiting Professors</h4>
                                <p class="text-xs sm:text-sm text-gray-700">Mengundang profesor ahli untuk workshop dan joint supervision.</p>
                            </div>
                        </div>
                    </div>

                    <div class="glassmorphism-card p-4 sm:p-6 rounded-2xl space-y-3 sm:space-y-4">
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-globe-americas text-xl sm:text-2xl text-brand-dark"></i>
                            <h3 class="text-base sm:text-lg font-serif font-bold text-brand-dark">Kerjasama Internasional</h3>
                        </div>
                        <div class="space-y-2 sm:space-y-3">
                            <div>
                                <h4 class="text-sm sm:text-base font-bold text-brand-dark mb-1">Student Exchange</h4>
                                <p class="text-xs sm:text-sm text-gray-700">Pertukaran mahasiswa inbound dan outbound dengan mitra global.</p>
                            </div>
                            <div>
                                <h4 class="text-sm sm:text-base font-bold text-brand-dark mb-1">Summer Course SDGs</h4>
                                <p class="text-xs sm:text-sm text-gray-700">Penyelenggaraan kursus musim panas dengan fokus SDGs.</p>
                            </div>
                            <div>
                                <h4 class="text-sm sm:text-base font-bold text-brand-dark mb-1">Community Development</h4>
                                <p class="text-xs sm:text-sm text-gray-700">Program pemberdayaan masyarakat bersama universitas luar negeri.</p>
                            </div>
                        </div>
                    </div>

                    <div class="glassmorphism-card p-4 sm:p-6 rounded-2xl space-y-3 sm:space-y-4">
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-bullhorn text-xl sm:text-2xl text-brand-dark"></i>
                            <h3 class="text-base sm:text-lg font-serif font-bold text-brand-dark">Promosi Global</h3>
                        </div>
                        <div class="space-y-2 sm:space-y-3">
                            <div>
                                <h4 class="text-sm sm:text-base font-bold text-brand-dark mb-1">Education Exhibitions</h4>
                                <p class="text-xs sm:text-sm text-gray-700">Partisipasi dalam pameran pendidikan internasional QS dan THE.</p>
                            </div>
                            <div>
                                <h4 class="text-sm sm:text-base font-bold text-brand-dark mb-1">Konferensi Internasional</h4>
                                <p class="text-xs sm:text-sm text-gray-700">Penyelenggaraan konferensi/workshop dengan prosiding terindeks Scopus.</p>
                            </div>
                            <div>
                                <h4 class="text-sm sm:text-base font-bold text-brand-dark mb-1">Employer Meeting</h4>
                                <p class="text-xs sm:text-sm text-gray-700">Workshop dengan pengguna lulusan untuk meningkatkan reputasi.</p>
                            </div>
                        </div>
                    </div>

                    <div class="glassmorphism-card p-4 sm:p-6 rounded-2xl space-y-3 sm:space-y-4">
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-cogs text-xl sm:text-2xl text-brand-dark"></i>
                            <h3 class="text-base sm:text-lg font-serif font-bold text-brand-dark">Pengelolaan Program</h3>
                        </div>
                        <div class="space-y-2 sm:space-y-3">
                            <div>
                                <h4 class="text-sm sm:text-base font-bold text-brand-dark mb-1">Tim Pengelola EQUITY</h4>
                                <p class="text-xs sm:text-sm text-gray-700">Manajemen profesional program dengan maksimal 3% dari total anggaran.</p>
                            </div>
                            <div>
                                <h4 class="text-sm sm:text-base font-bold text-brand-dark mb-1">Monitoring & Evaluasi</h4>
                                <p class="text-xs sm:text-sm text-gray-700">Sistem pemantauan berkelanjutan untuk memastikan pencapaian target.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="dampak" class="min-h-screen bg-brand-dark text-white py-12 sm:py-16 flex items-center">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-8 sm:mb-12">
                    <h2 class="text-2xl sm:text-3xl font-serif font-bold">Target Pencapaian Program EQUITY</h2>
                    <p class="mt-2 text-sm sm:text-base text-gray-400 max-w-2xl mx-auto">Target strategis UNJ dalam Program EQUITY THE Impact Ranking 2025-2030.</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 sm:gap-8 text-center mb-8 sm:mb-12 content-icons" x-data="equityCounter()" x-intersect="start()">
                    <div class="fade-in-up p-4 sm:p-6">
                        <i class="fas fa-trophy text-3xl sm:text-4xl text-brand-accent mb-3"></i>
                        <h3 class="text-3xl sm:text-4xl font-bold counter-animation" style="--num: 600">
                            <span x-text="Math.round(num1)">0</span>
                        </h3>
                        <p class="mt-1 text-gray-300 text-sm sm:text-base">Target Peringkat THE Impact 2030</p>
                        <p class="text-xs text-gray-400">Top 600 Global Ranking</p>
                    </div>
                    <div class="fade-in-up p-4 sm:p-6" style="animation-delay: 200ms;">
                        <i class="fas fa-calendar-alt text-3xl sm:text-4xl text-brand-accent mb-3"></i>
                        <h3 class="text-3xl sm:text-4xl font-bold counter-animation" style="--num: 5">
                            <span x-text="Math.round(num2)">0</span>
                        </h3>
                        <p class="mt-1 text-gray-300 text-sm sm:text-base">Tahun Program</p>
                        <p class="text-xs text-gray-400">2025-2030</p>
                    </div>
                    <div class="fade-in-up p-4 sm:p-6" style="animation-delay: 400ms;">
                        <i class="fas fa-bullseye text-3xl sm:text-4xl text-brand-accent mb-3"></i>
                        <h3 class="text-3xl sm:text-4xl font-bold counter-animation" style="--num: 17">
                             <span x-text="Math.round(num3)">0</span>
                        </h3>
                        <p class="mt-1 text-gray-300 text-sm sm:text-base">Sustainable Development Goals</p>
                        <p class="text-xs text-gray-400">Kontribusi pada semua SDGs</p>
                    </div>
                </div>
                
                <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-4 sm:p-6">
                    <h3 class="text-lg sm:text-xl font-bold text-center mb-4 sm:mb-6">Roadmap Pencapaian UNJ</h3>
                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-2 sm:gap-3 text-center">
                        <div class="bg-white/5 rounded-lg p-2 sm:p-3">
                            <div class="text-lg sm:text-xl font-bold text-brand-accent">2026</div>
                            <div class="text-xs sm:text-sm">601-700</div>
                        </div>
                        <div class="bg-white/5 rounded-lg p-2 sm:p-3">
                            <div class="text-lg sm:text-xl font-bold text-brand-accent">2027</div>
                            <div class="text-xs sm:text-sm">601-700</div>
                        </div>
                        <div class="bg-white/5 rounded-lg p-2 sm:p-3">
                            <div class="text-lg sm:text-xl font-bold text-brand-accent">2028</div>
                            <div class="text-xs sm:text-sm">501-600</div>
                        </div>
                        <div class="bg-white/5 rounded-lg p-2 sm:p-3">
                            <div class="text-lg sm:text-xl font-bold text-brand-accent">2029</div>
                            <div class="text-xs sm:text-sm">501-600</div>
                        </div>
                        <div class="bg-white/10 rounded-lg p-2 sm:p-3 border-2 border-brand-accent col-span-2 sm:col-span-1">
                            <div class="text-lg sm:text-xl font-bold text-brand-accent">2030</div>
                            <div class="text-xs sm:text-sm font-bold">501-600</div>
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
            const contentIcons = document.querySelectorAll('.content-icons .fas, .content-icons .fab');
            contentIcons.forEach(icon => {
                icon.style.fontFamily = '"Font Awesome 6 Free", "Font Awesome 6 Brands"';
                icon.style.fontWeight = '900';
            });

            const navbarIcons = document.querySelectorAll('.navbar .fas, .navbar .fab, nav .fas, nav .fab, #mobile-navbar .fas, #mobile-navbar .fab, #mobile-sidebar .fas, #mobile-sidebar .fab');
            navbarIcons.forEach(icon => {
                icon.style.fontFamily = '"Font Awesome 6 Free", "Font Awesome 6 Brands"';
                icon.style.fontWeight = '900';
            });

            if (!window.equityDesktopDropdownInitialized) {
                window.equityDesktopDropdownInitialized = true;
                
                const desktopDropdownToggles = document.querySelectorAll('.desktop-dropdown-toggle');
                const desktopDropdownMenus = document.querySelectorAll('.desktop-dropdown-menu');

                desktopDropdownToggles.forEach((toggle, index) => {
                    const menu = desktopDropdownMenus[index];
                    if (!menu) return;
                    
                    toggle.addEventListener('click', function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        
                        desktopDropdownMenus.forEach((otherMenu, otherIndex) => {
                            if (otherIndex !== index && otherMenu) {
                                otherMenu.classList.add('hidden');
                            }
                        });
                        
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