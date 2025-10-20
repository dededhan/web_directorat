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
        .fas, .fab, .fa-solid, .fa-brands {
            font-family: "Font Awesome 6 Free", "Font Awesome 6 Brands" !important;
            font-weight: 900 !important;
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
                    },
                    keyframes: {
                        fadeInUp: {
                            '0%': { opacity: '0', transform: 'translateY(30px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        },
                        blob: {
                            '0%': { transform: 'translate(0px, 0px) scale(1)' },
                            '33%': { transform: 'translate(30px, -50px) scale(1.1)' },
                            '66%': { transform: 'translate(-20px, 20px) scale(0.9)' },
                            '100%': { transform: 'translate(0px, 0px) scale(1)' },
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
        {{-- New Hero Cards Section --}}
        <section class="relative min-h-screen flex items-start justify-center bg-white pt-20 pb-8">
            <div class="w-full">
                <div class="text-center mb-6 sm:mb-8 px-4 sm:px-6 lg:px-8">
                    <h2 class="text-2xl sm:text-3xl lg:text-4xl font-serif font-bold text-brand-dark">Berita & Informasi Terkini</h2>
                    <p class="mt-2 text-base text-gray-600 max-w-2xl mx-auto">Update terbaru seputar Program EQUITY dan informasi penting Universitas Negeri Jakarta</p>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 lg:gap-8 p-4 sm:p-6 lg:p-8">
                    @foreach($equityNews as $newsItem)
                    <a href="{{ route('equity.news.show', $newsItem->slug) }}" class="group relative h-[450px] sm:h-[520px] lg:h-[580px] overflow-hidden transition-all duration-300 hover:brightness-110 shadow-lg rounded-xl">
                        <img src="{{ asset('storage/' . $newsItem->image) }}" alt="{{ $newsItem->title }}" class="absolute inset-0 w-full h-full object-cover rounded-xl">
                        <div class="absolute inset-0 bg-gradient-to-t from-{{ $newsItem->gradient_color }}-900/85 via-{{ $newsItem->gradient_color }}-900/50 to-transparent rounded-xl"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-5 text-white">
                            <p class="text-xs uppercase tracking-wider mb-2 font-semibold">{{ $newsItem->category }}</p>
                            <h3 class="text-lg lg:text-xl font-bold mb-3">{{ $newsItem->title }}</h3>
                            <div class="flex items-center mt-2">
                                <div class="w-9 h-9 border-2 border-white rounded-full flex items-center justify-center group-hover:bg-white group-hover:text-{{ $newsItem->gradient_color }}-900 transition-all">
                                    <i class="fas fa-arrow-right text-sm group-hover:translate-x-1 transition-transform"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- Supported By Section --}}
        <section class="bg-gray-50 py-12 sm:py-16">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-6">
                    <h2 class="text-2xl sm:text-3xl font-serif font-bold text-brand-dark">Didukung oleh</h2>
                    <p class="mt-2 text-base text-gray-600">Institusi dan lembaga yang mendukung Program EQUITY UNJ</p>
                </div>
                <div class="flex flex-wrap justify-center items-center gap-8 sm:gap-12 lg:gap-16">
                    <div class="group">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/9c/Logo_of_Ministry_of_Education_and_Culture_of_Republic_of_Indonesia.svg/250px-Logo_of_Ministry_of_Education_and_Culture_of_Republic_of_Indonesia.svg.png" 
                             alt="Logo Tut Wuri Handayani" 
                             class="h-28 w-28 sm:h-32 sm:w-32 lg:h-36 lg:w-36 object-contain transition-all duration-300 hover:scale-110">
                    </div>
                    <div class="group">
                        <img src="https://pnn.ac.id/media/2025/05/Logo-Tersier-Diktisaintek-Berdampak-1-1024x1024.png" 
                             alt="Logo Kemendiksaintek" 
                             class="h-28 w-28 sm:h-32 sm:w-32 lg:h-36 lg:w-36 object-contain transition-all duration-300 hover:scale-110">
                    </div>
                    <div class="group">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" 
                             alt="Logo UNJ" 
                             class="h-28 w-28 sm:h-32 sm:w-32 lg:h-36 lg:w-36 object-contain transition-all duration-300 hover:scale-110">
                    </div>
                    <div class="group">
                        <img src="https://lpdp.kemenkeu.go.id/storage/tentang/selayang-pandang/logo/logo_image_1631632938.png" 
                             alt="Logo LPDP" 
                             class="h-28 w-28 sm:h-32 sm:w-32 lg:h-36 lg:w-36 object-contain transition-all duration-300 hover:scale-110">
                    </div>
                </div>
            </div>
        </section>

        <section id="tentang" class="min-h-screen flex items-center bg-brand-light py-12"> <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid lg:grid-cols-2 gap-6 lg:gap-8 items-center mb-4"> <div class="order-2 lg:order-1">
                        <img src="https://www.discovery.org/m/sites/71/2021/07/equity-stockpack-adobe-stock-scaled.jpg" 
                             alt="Program EQUITY" 
                             class="rounded-xl shadow-2xl w-full h-56 sm:h-72 lg:h-96 object-cover"> </div>
                    <div class="order-1 lg:order-2">
                        <p class="text-brand-accent-light font-semibold tracking-widest uppercase text-sm">Program EQUITY UNJ</p> <h1 class="mt-2 text-2xl sm:text-3xl lg:text-4xl font-serif font-bold tracking-tight text-brand-dark leading-snug"> Enhancing Quality Education for International University Impacts and Recognition
                        </h1>
                        <p class="mt-3 text-base text-gray-700 leading-relaxed"> Program strategis untuk mendorong UNJ meraih pengakuan global melalui THE Impact Ranking dengan fokus pencapaian Sustainable Development Goals (SDGs).
                        </p>
                        <div class="mt-4">
                            <a href="#" class="login bg-brand-accent text-white font-bold py-2.5 px-6 rounded-full shadow-lg transition-all duration-300 ease-in-out hover:scale-105 hover:brightness-90 active:scale-100 active:brightness-75 text-sm inline-block" data-bs-toggle="modal" data-bs-target="#loginModal">
                                Pengajuan EQUITY
                            </a>
                        </div>
                    </div>
                </div>

        </section>

        <section class="min-h-screen flex items-center bg-white py-12"> 
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid lg:grid-cols-2 gap-6 lg:gap-10 items-center mb-8"> 
                    <div class="space-y-6 lg:space-y-8">
                        <div class="space-y-3">
                            <p class="font-semibold text-brand-accent tracking-wide uppercase text-sm">Latar Belakang Program</p> 
                            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-serif font-bold text-brand-dark leading-tight"> 
                                Program <span class="text-brand-accent">EQUITY</span> THE Impact Ranking
                            </h2>
                        </div>

                        <div class="space-y-4 lg:space-y-5">
                            <p class="text-gray-700 leading-relaxed text-base"> 
                                Program <strong>EQUITY (Enhancing Quality Education for International University Impacts and Recognition)</strong> 
                                merupakan program strategis Kementerian Pendidikan Tinggi, Sains, dan Teknologi yang dimulai sejak 2023, 
                                khusus dirancang untuk memfasilitasi 16 PTNBH dalam meningkatkan kualitas dan mencapai pengakuan global 
                                melalui THE Impact Ranking.
                            </p>
                            <p class="text-gray-700 leading-relaxed text-base"> 
                                UNJ sebagai salah satu dari 16 PTNBH sasaran program ini berkomitmen untuk mencapai target peringkat 
                                <strong>Top 600</strong> THE Impact Ranking tahun 2030.
                            </p>
                        </div>
                        
                        <div class="grid sm:grid-cols-2 gap-4 lg:gap-5 pt-2">
                            <div class="flex items-start gap-3 group bg-gray-50 p-4 rounded-xl hover:bg-gray-100 transition-all duration-300">
                                <div class="flex-shrink-0 bg-brand-accent/10 p-3 rounded-xl group-hover:bg-brand-accent/20 transition-colors">
                                    <i class="fas fa-graduation-cap text-xl text-brand-accent"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-brand-dark text-base mb-0.5">Pendanaan DAPT</h4> 
                                    <p class="text-sm text-gray-600 leading-relaxed">Program didanai melalui Dana Abadi Perguruan Tinggi (DAPT) dari LPDP.</p> 
                                </div>
                            </div>
                            <div class="flex items-start gap-3 group bg-gray-50 p-4 rounded-xl hover:bg-gray-100 transition-all duration-300">
                                <div class="flex-shrink-0 bg-brand-accent/10 p-3 rounded-xl group-hover:bg-brand-accent/20 transition-colors">
                                    <i class="fas fa-globe text-xl text-brand-accent"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-brand-dark text-base mb-0.5">Pencapaian SDGs</h4> 
                                    <p class="text-sm text-gray-600 leading-relaxed">Berkontribusi dalam pencapaian 17 tujuan pembangunan berkelanjutan.</p> 
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="lg:pl-8">
                        <img src="https://ditisip.unj.ac.id/storage/ranking-images/1746516869_6819bb859000b.png" 
                            alt="Latar Belakang Program EQUITY" 
                            class="rounded-2xl shadow-2xl w-full h-auto aspect-[4/3] lg:aspect-auto lg:h-full object-cover hover:scale-[1.02] transition-transform duration-300"> 
                    </div>
                </div>

                <div id="dokumen" class="max-w-6xl mx-auto">
                    <div class="bg-gradient-to-br from-brand-accent/5 to-brand-accent-light/10 rounded-2xl shadow-xl p-6 sm:p-8 lg:p-10 border-2 border-brand-accent/20 hover:border-brand-accent/40 transition-all duration-300 hover:shadow-2xl">
                        <div class="flex flex-col sm:flex-row items-center gap-6 sm:gap-8">
                            <div class="flex-shrink-0 bg-brand-accent/20 p-5 sm:p-6 rounded-2xl">
                                <i class="fas fa-file-alt text-4xl sm:text-5xl text-brand-accent"></i>
                            </div>
                            <div class="flex-1 text-center sm:text-left">
                                <h3 class="text-xl sm:text-2xl font-serif font-bold text-brand-dark mb-2">Dokumen Pendukung EQUITY</h3> 
                                <p class="text-base text-gray-600">Akses dokumen resmi, panduan, dan referensi Program EQUITY UNJ</p> 
                            </div>
                            <div class="flex-shrink-0">
                                <a href="https://s.id/DokumenPendukungEQUITY" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 bg-brand-accent text-white font-bold py-3 px-7 sm:px-8 rounded-full shadow-lg transition-all duration-300 ease-in-out hover:scale-105 hover:brightness-90 active:scale-100 active:brightness-75 text-base">
                                    <span>Lihat Dokumen</span>
                                    <i class="fas fa-external-link-alt text-sm"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="program" class="min-h-screen relative overflow-hidden bg-gray-100 py-12 flex items-center"> <div class="absolute top-0 left-0 w-48 sm:w-64 lg:w-80 h-48 sm:h-64 lg:h-80 bg-yellow-300 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-[blob_7s_ease-in-out_infinite]"></div>
            <div class="absolute top-0 right-0 w-48 sm:w-64 lg:w-80 h-48 sm:h-64 lg:h-80 bg-amber-300 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-[blob_7s_ease-in-out_infinite] [animation-delay:2s]"></div>
            <div class="absolute bottom-0 left-1/2 w-48 sm:w-64 lg:w-80 h-48 sm:h-64 lg:h-80 bg-orange-300 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-[blob_7s_ease-in-out_infinite] [animation-delay:4s]"></div>

            <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full">
                <div class="text-center mb-6"> <h2 class="text-2xl sm:text-3xl font-serif font-bold text-brand-dark">Komponen Program EQUITY UNJ</h2> <p class="mt-2 text-base text-gray-600 max-w-2xl mx-auto">Enam pilar strategis yang menopang pencapaian THE Impact Ranking melalui kontribusi nyata terhadap SDGs.</p> </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4 sm:gap-6"> <div class="bg-white/10 backdrop-blur-lg border border-white/20 p-5 sm:p-6 rounded-2xl space-y-3 sm:space-y-4"> <div class="flex items-center space-x-3">
                            <i class="fas fa-building text-xl text-brand-dark"></i> <h3 class="text-lg font-serif font-bold text-brand-dark">Penguatan Kelembagaan</h3> </div>
                        <div class="space-y-3">
                            <div>
                                <h4 class="text-base font-bold text-brand-dark mb-0.5">Pengelolaan Jurnal Terindeks Scopus/WOS</h4> <p class="text-sm text-gray-700">Peningkatan kuartil jurnal dan persiapan indeksasi Scopus.</p> </div>
                            <div>
                                <h4 class="text-base font-bold text-brand-dark mb-0.5">SDGs Center</h4> <p class="text-sm text-gray-700">Penguatan pusat koordinasi dan pengelolaan program SDGs.</p> </div>
                        </div>
                    </div>
                    
                    <div class="bg-white/10 backdrop-blur-lg border border-white/20 p-5 sm:p-6 rounded-2xl space-y-3 sm:space-y-4"> <div class="flex items-center space-x-3">
                            <i class="fas fa-microscope text-xl text-brand-dark"></i> <h3 class="text-lg font-serif font-bold text-brand-dark">Penelitian & Inovasi</h3> </div>
                        <div class="space-y-3">
                            <div>
                                <h4 class="text-base font-bold text-brand-dark mb-0.5">Research Grants</h4> <p class="text-sm text-gray-700">Hibah penelitian dengan target publikasi Q1 melibatkan mahasiswa pascasarjana.</p> </div>
                            <div>
                                <h4 class="text-base font-bold text-brand-dark mb-0.5">Kolaborasi Penelitian</h4> <p class="text-sm text-gray-700">Kerjasama dengan PTNBH lain dan negara berpenghasilan rendah-menengah.</p> </div>
                            <div>
                                <h4 class="text-base font-bold text-brand-dark mb-0.5">Article Processing Cost (APC)</h4> <p class="text-sm text-gray-700">Dukungan biaya publikasi jurnal Q1 terindeks Scopus hingga 50 juta.</p> </div>
                        </div>
                    </div>

                    <div class="bg-white/10 backdrop-blur-lg border border-white/20 p-5 sm:p-6 rounded-2xl space-y-3 sm:space-y-4"> <div class="flex items-center space-x-3">
                            <i class="fas fa-user-graduate text-xl text-brand-dark"></i> <h3 class="text-lg font-serif font-bold text-brand-dark">Pengembangan SDM</h3> </div>
                        <div class="space-y-3">
                            <div>
                                <h4 class="text-base font-bold text-brand-dark mb-0.5">Sabbatical Leave</h4> <p class="text-sm text-gray-700">Program pengembangan dosen di perguruan tinggi Top 500 dunia.</p> </div>
                            <div>
                                <h4 class="text-base font-bold text-brand-dark mb-0.5">Konferensi Internasional SDGs</h4> <p class="text-sm text-gray-700">Presentasi paper dalam konferensi internasional bertema SDGs.</p> </div>
                            <div>
                                <h4 class="text-base font-bold text-brand-dark mb-0.5">Visiting Professors</h4> <p class="text-sm text-gray-700">Mengundang profesor ahli untuk workshop dan joint supervision.</p> </div>
                        </div>
                    </div>

                    <div class="bg-white/10 backdrop-blur-lg border border-white/20 p-5 sm:p-6 rounded-2xl space-y-3 sm:space-y-4"> <div class="flex items-center space-x-3">
                            <i class="fas fa-globe-americas text-xl text-brand-dark"></i> <h3 class="text-lg font-serif font-bold text-brand-dark">Kerjasama Internasional</h3> </div>
                        <div class="space-y-3">
                            <div>
                                <h4 class="text-base font-bold text-brand-dark mb-0.5">Student Exchange</h4> <p class="text-sm text-gray-700">Pertukaran mahasiswa inbound dan outbound dengan mitra global.</p> </div>
                            <div>
                                <h4 class="text-base font-bold text-brand-dark mb-0.5">Summer Course SDGs</h4> <p class="text-sm text-gray-700">Penyelenggaraan kursus musim panas dengan fokus SDGs.</p> </div>
                            <div>
                                <h4 class="text-base font-bold text-brand-dark mb-0.5">Community Development</h4> <p class="text-sm text-gray-700">Program pemberdayaan masyarakat bersama universitas luar negeri.</p> </div>
                        </div>
                    </div>

                    <div class="bg-white/10 backdrop-blur-lg border border-white/20 p-5 sm:p-6 rounded-2xl space-y-3 sm:space-y-4"> <div class="flex items-center space-x-3">
                            <i class="fas fa-bullhorn text-xl text-brand-dark"></i> <h3 class="text-lg font-serif font-bold text-brand-dark">Promosi Global</h3> </div>
                        <div class="space-y-3">
                            <div>
                                <h4 class="text-base font-bold text-brand-dark mb-0.5">Education Exhibitions</h4> <p class="text-sm text-gray-700">Partisipasi dalam pameran pendidikan internasional QS dan THE.</p> </div>
                            <div>
                                <h4 class="text-base font-bold text-brand-dark mb-0.5">Konferensi Internasional</h4> <p class="text-sm text-gray-700">Penyelenggaraan konferensi/workshop dengan prosiding terindeks Scopus.</p> </div>
                            <div>
                                <h4 class="text-base font-bold text-brand-dark mb-0.5">Employer Meeting</h4> <p class="text-sm text-gray-700">Workshop dengan pengguna lulusan untuk meningkatkan reputasi.</p> </div>
                        </div>
                    </div>

                    <div class="bg-white/10 backdrop-blur-lg border border-white/20 p-5 sm:p-6 rounded-2xl space-y-3 sm:space-y-4"> <div class="flex items-center space-x-3">
                            <i class="fas fa-cogs text-xl text-brand-dark"></i> <h3 class="text-lg font-serif font-bold text-brand-dark">Pengelolaan Program</h3> </div>
                        <div class="space-y-3">
                            <div>
                                <h4 class="text-base font-bold text-brand-dark mb-0.5">Tim Pengelola EQUITY</h4> <p class="text-sm text-gray-700">Manajemen profesional program dengan maksimal 3% dari total anggaran.</p> </div>
                            <div>
                                <h4 class="text-base font-bold text-brand-dark mb-0.5">Monitoring & Evaluasi</h4> <p class="text-sm text-gray-700">Sistem pemantauan berkelanjutan untuk memastikan pencapaian target.</p> </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="dampak" class="min-h-screen bg-brand-dark text-white py-12 flex items-center"> <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-6">
                    <h2 class="text-2xl sm:text-3xl font-serif font-bold">Target Pencapaian Program EQUITY</h2> <p class="mt-2 text-base text-gray-400 max-w-2xl mx-auto">Target strategis UNJ dalam Program EQUITY THE Impact Ranking 2025-2030.</p> </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 sm:gap-6 text-center mb-6"> <div class="p-5 sm:p-6 opacity-0 animate-[fadeInUp_0.8s_ease-out_forwards]">
                        <i class="fas fa-trophy text-3xl sm:text-4xl text-brand-accent mb-2"></i> <h3 class="text-4xl sm:text-5xl font-bold">
                            <span>600</span>
                        </h3>
                        <p class="mt-1 text-gray-300 text-base">Target Peringkat THE Impact 2030</p> <p class="text-sm text-gray-400">Top 600 Global Ranking</p> </div>
                    <div class="p-5 sm:p-6 opacity-0 animate-[fadeInUp_0.8s_ease-out_0.2s_forwards]">
                        <i class="fas fa-calendar-alt text-3xl sm:text-4xl text-brand-accent mb-2"></i> <h3 class="text-4xl sm:text-5xl font-bold">
                            <span>5</span>
                        </h3>
                        <p class="mt-1 text-gray-300 text-base">Tahun Program</p> <p class="text-sm text-gray-400">2025-2030</p> </div>
                    <div class="p-5 sm:p-6 opacity-0 animate-[fadeInUp_0.8s_ease-out_0.4s_forwards]">
                        <i class="fas fa-bullseye text-3xl sm:text-4xl text-brand-accent mb-2"></i> <h3 class="text-4xl sm:text-5xl font-bold">
                             <span>17</span>
                        </h3>
                        <p class="mt-1 text-gray-300 text-base">Sustainable Development Goals</p> <p class="text-sm text-gray-400">Kontribusi pada semua SDGs</p> </div>
                </div>
                
                <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-5 sm:p-7">
                    <h3 class="text-lg sm:text-xl font-bold text-center mb-4 sm:mb-5">Roadmap Pencapaian UNJ</h3> <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3 text-center"> <div class="bg-white/5 rounded-lg p-3 sm:p-4">
                            <div class="text-base sm:text-lg font-bold text-brand-accent">2026</div>
                            <div class="text-sm">601-700</div>
                        </div>
                        <div class="bg-white/5 rounded-lg p-3 sm:p-4">
                            <div class="text-base sm:text-lg font-bold text-brand-accent">2027</div>
                            <div class="text-sm">601-700</div>
                        </div>
                        <div class="bg-white/5 rounded-lg p-3 sm:p-4">
                            <div class="text-base sm:text-lg font-bold text-brand-accent">2028</div>
                            <div class="text-sm">501-600</div>
                        </div>
                        <div class="bg-white/5 rounded-lg p-3 sm:p-4">
                            <div class="text-base sm:text-lg font-bold text-brand-accent">2029</div>
                            <div class="text-sm">501-600</div>
                        </div>
                        <div class="bg-white/10 rounded-lg p-3 sm:p-4 border-2 border-brand-accent col-span-2 sm:col-span-1">
                            <div class="text-base sm:text-lg font-bold text-brand-accent">2030</div>
                            <div class="text-sm font-bold">501-600</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    
    @include('layout.footer')


</body>
</html>