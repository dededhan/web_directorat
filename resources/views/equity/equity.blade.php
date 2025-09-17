<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Membangun Ekosistem Riset Berkeadilan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Lora:wght@500;600;700&display=swap" rel="stylesheet">

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
                            'accent': '#B8860B', // DarkGoldenRod
                            'accent-light': '#D4AC0D',
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-white font-sans text-brand-dark antialiased">
 @include('layout.navbar')
    <main>
        <section class="relative bg-gradient-to-b from-white to-gray-100 overflow-hidden min-h-screen flex items-center">
            <div class="container mx-auto px-6 lg:px-8">
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2">
                    <i class="fas fa-balance-scale text-gray-200/50" style="font-size: 30rem;"></i>
                </div>

                <div class="relative max-w-4xl mx-auto text-center">
                    <p class="text-brand-accent font-semibold">Program Equity Kami</p>
                    <h1 class="mt-4 text-5xl md:text-7xl font-serif font-bold tracking-tight text-brand-dark">
                        Menciptakan Ekosistem Riset yang Adil & Berdampak.
                    </h1>
                    <p class="mt-8 text-lg text-gray-600">
                        Sebuah inisiatif untuk meruntuhkan hambatan, membuka akses, dan membangun jembatan pengetahuan bagi para peneliti di seluruh dunia.
                    </p>
                    <div class="mt-10">
                        <a href="#program" class="bg-brand-accent hover:bg-brand-accent-light text-white font-bold py-3 px-8 rounded-full transition-transform duration-300 ease-in-out hover:scale-105 shadow-lg">
                            Jelajahi Program Kami
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <section id="tentang" class="bg-brand-light py-24 sm:py-32">
            <div class="container mx-auto px-6 lg:px-8">
                <div class="grid md:grid-cols-2 gap-16 items-center">
                    <div>
                        <p class="font-semibold text-brand-accent">Prinsip Utama Kami</p>
                        <h2 class="mt-2 text-4xl font-serif font-bold text-brand-dark">Memahami Konsep <span class="text-brand-accent">Equity</span> dalam Riset</h2>
                        <p class="mt-6 text-lg text-gray-600">
                            <strong>Equity (keadilan)</strong> bukan hanya tentang memberi kesempatan yang sama, tetapi juga menyediakan dukungan yang diperlukan agar setiap peneliti, dari latar belakang apa pun, dapat mencapai potensi terbaiknya.
                        </p>
                        
                        <div class="mt-10 space-y-8">
                            <div class="flex items-start gap-4">
                                <div class="flex-shrink-0 bg-brand-accent/10 p-3 rounded-full">
                                    <i class="fas fa-key text-brand-accent text-xl fa-fw"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-lg text-brand-dark">Akses Terbuka</h4>
                                    <p class="mt-1 text-gray-600">Menghilangkan hambatan finansial dan geografis terhadap publikasi dan data riset.</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-4">
                                <div class="flex-shrink-0 bg-brand-accent/10 p-3 rounded-full">
                                    <i class="fas fa-users-gear text-brand-accent text-xl fa-fw"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-lg text-brand-dark">Representasi Inklusif</h4>
                                    <p class="mt-1 text-gray-600">Mendorong partisipasi dari peneliti dengan beragam perspektif untuk memperkaya inovasi.</p>
                                </div>
                            </div>
                             <div class="flex items-start gap-4">
                                <div class="flex-shrink-0 bg-brand-accent/10 p-3 rounded-full">
                                    <i class="fas fa-hand-holding-dollar text-brand-accent text-xl fa-fw"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-lg text-brand-dark">Sumber Daya Berkeadilan</h4>
                                    <p class="mt-1 text-gray-600">Mengalokasikan pendanaan dan mentorship untuk mendukung mereka yang paling membutuhkan.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="hidden md:block">
                        <img src="https://www.discovery.org/m/sites/71/2021/07/equity-stockpack-adobe-stock-scaled.jpg" alt="Kolaborasi tim yang beragam" class="rounded-xl shadow-2xl w-full h-full object-cover">
                    </div>
                </div>
            </div>
        </section>


        <section id="galeri" class="bg-white py-24 sm:py-32">
            <div class="container mx-auto px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-4xl font-serif font-bold text-brand-dark">Galeri Kegiatan</h2>
                    <p class="mt-3 text-gray-500 max-w-2xl mx-auto">Momen kolaborasi, inovasi, dan pemberdayaan dalam ekosistem riset kami.</p>
                </div>
                
                <div class="grid grid-cols-4 grid-rows-3 sm:grid-rows-2 gap-4 h-[400px] sm:h-[600px]">
                    
                    <div class="col-span-2 sm:col-span-1 sm:row-span-2 relative group overflow-hidden rounded-lg shadow-lg">
                        <img src="https://images.unsplash.com/photo-1542744173-8e7e53415bb0?q=80&w=2070&auto=format&fit=crop" alt="Diskusi Kelompok" class="w-full h-full object-cover transition-transform duration-500 ease-in-out group-hover:scale-110">
                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/40 transition-opacity duration-300"></div>
                        <i class="fas fa-search-plus absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text-white text-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></i>
                    </div>
                    
                    <div class="col-span-2 sm:col-span-2 sm:row-span-2 relative group overflow-hidden rounded-lg shadow-lg">
                        <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?q=80&w=2071&auto=format&fit=crop" alt="Kegiatan Workshop" class="w-full h-full object-cover transition-transform duration-500 ease-in-out group-hover:scale-110">
                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/40 transition-opacity duration-300"></div>
                        <i class="fas fa-search-plus absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text-white text-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></i>
                    </div>
                    
                    <div class="col-span-2 sm:col-span-1 relative group overflow-hidden rounded-lg shadow-lg">
                        <img src="https://images.unsplash.com/photo-1556761175-5973dc0f32e7?q=80&w=1932&auto=format&fit=crop" alt="Kolaborasi Internasional" class="w-full h-full object-cover transition-transform duration-500 ease-in-out group-hover:scale-110">
                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/40 transition-opacity duration-300"></div>
                        <i class="fas fa-search-plus absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text-white text-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></i>
                    </div>
                    
                    <div class="col-span-2 sm:col-span-1 relative group overflow-hidden rounded-lg shadow-lg">
                        <img src="https://images.unsplash.com/photo-1505373877841-8d25f7d46678?q=80&w=2012&auto=format&fit=crop" alt="Seminar Internasional" class="w-full h-full object-cover transition-transform duration-500 ease-in-out group-hover:scale-110">
                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/40 transition-opacity duration-300"></div>
                        <i class="fas fa-search-plus absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text-white text-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></i>
                    </div>
                </div>
            </div>
        </section>

        <section id="program" class="py-24 sm:py-32">
            <div class="container mx-auto px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-4xl font-serif font-bold text-brand-dark">Program Unggulan Kami</h2>
                    <p class="mt-3 text-gray-500 max-w-2xl mx-auto">Tiga pilar utama yang menopang visi kami untuk riset berkeadilan.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                    
                    <div class="space-y-6">
                        <div class="flex items-center space-x-4 border-b-2 border-brand-accent pb-3">
                            <i class="fas fa-users text-3xl text-brand-accent"></i>
                            <h3 class="text-2xl font-serif font-bold text-brand-dark">Dampak Komunitas</h3>
                        </div>
                        <div class="group cursor-pointer p-4 rounded-lg transition-all duration-300 hover:bg-brand-accent hover:shadow-lg">
                            <h4 class="font-bold group-hover:text-white">Community Development</h4>
                            <p class="text-gray-600 text-sm group-hover:text-gray-100">Program pemberdayaan masyarakat terkait target SDGs, berkolaborasi dengan universitas luar negeri.</p>
                        </div>
                    </div>
                    
                    <div class="space-y-6">
                        <div class="flex items-center space-x-4 border-b-2 border-brand-accent pb-3">
                            <i class="fas fa-book-open text-3xl text-brand-accent"></i>
                            <h3 class="text-2xl font-serif font-bold text-brand-dark">Akses Pengetahuan</h3>
                        </div>
                        <div class="space-y-4">
                            <div class="group cursor-pointer p-4 rounded-lg transition-all duration-300 hover:bg-brand-accent hover:shadow-lg">
                                <h4 class="font-bold group-hover:text-white">Article Processing Cost (APC)</h4>
                                <p class="text-gray-600 text-sm group-hover:text-gray-100">Dukungan pendanaan hingga 50jt untuk publikasi di Jurnal Q1 (Scopus).</p>
                            </div>
                            <div class="group cursor-pointer p-4 rounded-lg transition-all duration-300 hover:bg-brand-accent hover:shadow-lg">
                                <h4 class="font-bold group-hover:text-white">Presentasi Konferensi SDGs</h4>
                                <p class="text-gray-600 text-sm group-hover:text-gray-100">Mendukung presentasi paper dalam konferensi internasional yang fokus pada SDGs.</p>
                            </div>
                             <div class="group cursor-pointer p-4 rounded-lg transition-all duration-300 hover:bg-brand-accent hover:shadow-lg">
                                <h4 class="font-bold group-hover:text-white">Insentif Reviewer & Board</h4>
                                <p class="text-gray-600 text-sm group-hover:text-gray-100">Insentif bagi dewan editorial di jurnal terindeks Scopus/WOS.</p>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div class="flex items-center space-x-4 border-b-2 border-brand-accent pb-3">
                            <i class="fas fa-handshake-angle text-3xl text-brand-accent"></i>
                            <h3 class="text-2xl font-serif font-bold text-brand-dark">Kolaborasi & Kapasitas</h3>
                        </div>
                        <div class="space-y-4">
                            <div class="group cursor-pointer p-4 rounded-lg transition-all duration-300 hover:bg-brand-accent hover:shadow-lg">
                                <h4 class="font-bold group-hover:text-white">Matchmaking Riset Global</h4>
                                <p class="text-gray-600 text-sm group-hover:text-gray-100">Menyusun proposal riset bersama peneliti internasional bereputasi tinggi.</p>
                            </div>
                            <div class="group cursor-pointer p-4 rounded-lg transition-all duration-300 hover:bg-brand-accent hover:shadow-lg">
                                <h4 class="font-bold group-hover:text-white">Mengundang Profesor Ahli</h4>
                                <p class="text-gray-600 text-sm group-hover:text-gray-100">Workshop riset dengan target luaran Jurnal Q1.</p>
                            </div>
                            <div class="group cursor-pointer p-4 rounded-lg transition-all duration-300 hover:bg-brand-accent hover:shadow-lg">
                                <h4 class="font-bold group-hover:text-white">Joint Supervision</h4>
                                <p class="text-gray-600 text-sm group-hover:text-gray-100">Bimbingan bersama mahasiswa pascasarjana dengan ahli global.</p>
                            </div>
                            <div class="group cursor-pointer p-4 rounded-lg transition-all duration-300 hover:bg-brand-accent hover:shadow-lg">
                                <h4 class="font-bold group-hover:text-white">Hibah Modul Inovatif</h4>
                                <p class="text-gray-600 text-sm group-hover:text-gray-100">Pengembangan modul untuk program internasional seperti Summer Course.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    @include('layout.footer')
</body>
</html>