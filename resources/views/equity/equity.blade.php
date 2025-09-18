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
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        .glassmorphism-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
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
        .fade-in-up {
            animation: fadeInUp 0.8s ease-out forwards;
        }

        @property --num {
          syntax: '<integer>';
          initial-value: 0;
          inherits: false;
        }

        .counter-animation {
            transition: --num 3s;
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
        <section class="relative h-screen flex items-center justify-center text-white overflow-hidden">
            <video autoplay loop muted playsinline class="absolute z-0 w-auto min-w-full min-h-full max-w-none">
                <source src="https://assets.mixkit.co/videos/preview/mixkit-scientists-working-in-a-dark-lab-3272-large.mp4" type="video/mp4">
                Your browser does not support the video tag.
            </video>
            <div class="absolute inset-0 bg-black/60 z-10"></div>
            
            <div class="relative z-20 max-w-4xl mx-auto text-center px-6" x-data="{ visible: false }" x-init="setTimeout(() => { visible = true }, 500)">
                <p class="text-brand-accent-light font-semibold tracking-widest uppercase transition-all duration-700" :class="visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'">Program Equity Kami</p>
                <h1 class="mt-4 text-5xl md:text-7xl font-serif font-bold tracking-tight transition-all duration-1000" :class="visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'">
                    Menciptakan Ekosistem Riset yang Adil & Berdampak.
                </h1>
                <p class="mt-8 text-lg text-gray-300 transition-all duration-1000 delay-300" :class="visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'">
                    Sebuah inisiatif untuk meruntuhkan hambatan, membuka akses, dan membangun jembatan pengetahuan bagi para peneliti di seluruh dunia.
                </p>
                <div class="mt-10 transition-all duration-1000 delay-500" :class="visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'">
                    <a href="#program" class="bg-brand-accent hover:bg-brand-accent-light text-white font-bold py-4 px-10 rounded-full transition-transform duration-300 ease-in-out hover:scale-105 shadow-lg">
                        Jelajahi Program Kami
                    </a>
                </div>
            </div>
        </section>

        <section id="tentang" class="bg-brand-light py-24 sm:py-32">
            <div class="container mx-auto px-6 lg:px-8">
                <div class="grid lg:grid-cols-5 gap-16 items-center">
                    <div class="lg:col-span-3">
                        <p class="font-semibold text-brand-accent">Prinsip Utama Kami</p>
                        <h2 class="mt-2 text-4xl font-serif font-bold text-brand-dark">Memahami Konsep <span class="text-brand-accent">Equity</span> dalam Riset</h2>
                        <p class="mt-6 text-lg text-gray-600">
                            <strong>Equity (keadilan)</strong> bukan hanya tentang memberi kesempatan yang sama, tetapi juga menyediakan dukungan yang diperlukan agar setiap peneliti, dari latar belakang apa pun, dapat mencapai potensi terbaiknya.
                        </p>
                        
                        <div class="mt-10 grid sm:grid-cols-2 gap-8">
                            <div class="flex items-start gap-4">
                                <div class="flex-shrink-0 bg-brand-accent/10 p-3 rounded-full mt-1">
                                    <i class="fas fa-key text-brand-accent text-xl fa-fw"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-lg text-brand-dark">Akses Terbuka</h4>
                                    <p class="mt-1 text-gray-600">Menghilangkan hambatan finansial dan geografis.</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-4">
                                <div class="flex-shrink-0 bg-brand-accent/10 p-3 rounded-full mt-1">
                                    <i class="fas fa-users-gear text-brand-accent text-xl fa-fw"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-lg text-brand-dark">Representasi Inklusif</h4>
                                    <p class="mt-1 text-gray-600">Mendorong partisipasi beragam perspektif.</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-4 col-span-full">
                                <div class="flex-shrink-0 bg-brand-accent/10 p-3 rounded-full mt-1">
                                    <i class="fas fa-hand-holding-dollar text-brand-accent text-xl fa-fw"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-lg text-brand-dark">Sumber Daya Berkeadilan</h4>
                                    <p class="mt-1 text-gray-600">Mengalokasikan pendanaan dan mentorship untuk mendukung mereka yang paling membutuhkan.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="lg:col-span-2 hidden lg:block">
                        <div class="relative h-[500px]">
                            <img src="https://www.discovery.org/m/sites/71/2021/07/equity-stockpack-adobe-stock-scaled.jpg" alt="Kolaborasi tim" class="rounded-xl shadow-2xl w-full h-full object-cover absolute top-0 left-0">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="program" class="py-24 sm:py-32 relative overflow-hidden bg-gray-100">
             <div class="absolute top-0 left-0 w-96 h-96 bg-yellow-300 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob"></div>
            <div class="absolute top-0 right-0 w-96 h-96 bg-amber-300 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob animation-delay-2000"></div>
            <div class="absolute bottom-0 left-1/2 w-96 h-96 bg-orange-300 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob animation-delay-4000"></div>

            <div class="container mx-auto px-6 lg:px-8 relative z-10">
                <div class="text-center mb-16">
                    <h2 class="text-4xl font-serif font-bold text-brand-dark">Program Unggulan Kami</h2>
                    <p class="mt-3 text-gray-600 max-w-2xl mx-auto">Tiga pilar utama yang menopang visi kami untuk riset berkeadilan.</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    
                    <div class="glassmorphism-card p-8 rounded-2xl space-y-6">
                        <div class="flex items-center space-x-4">
                            <i class="fas fa-users text-4xl text-brand-dark"></i>
                            <h3 class="text-2xl font-serif font-bold text-brand-dark">Dampak Komunitas</h3>
                        </div>
                        <div class="space-y-4">
                            <div class="group">
                                <h4 class="font-bold text-brand-dark">Community Development</h4>
                                <p class="text-gray-700 text-sm">Program pemberdayaan masyarakat terkait target SDGs, berkolaborasi dengan universitas luar negeri.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="glassmorphism-card p-8 rounded-2xl space-y-6">
                        <div class="flex items-center space-x-4">
                            <i class="fas fa-book-open text-4xl text-brand-dark"></i>
                            <h3 class="text-2xl font-serif font-bold text-brand-dark">Akses Pengetahuan</h3>
                        </div>
                        <div class="space-y-4">
                            <div class="group">
                                <h4 class="font-bold text-brand-dark">Article Processing Cost (APC)</h4>
                                <p class="text-gray-700 text-sm">Dukungan pendanaan hingga 50jt untuk publikasi di Jurnal Q1 (Scopus).</p>
                            </div>
                             <div class="group">
                                <h4 class="font-bold text-brand-dark">Presentasi Konferensi SDGs</h4>
                                <p class="text-gray-700 text-sm">Mendukung presentasi paper dalam konferensi internasional yang fokus pada SDGs.</p>
                            </div>
                            <div class="group">
                                <h4 class="font-bold text-brand-dark">Insentif Reviewer & Board</h4>
                                <p class="text-gray-700 text-sm">Insentif bagi dewan editorial di jurnal terindeks Scopus/WOS.</p>
                            </div>
                        </div>
                    </div>

                    <div class="glassmorphism-card p-8 rounded-2xl space-y-6">
                        <div class="flex items-center space-x-4">
                            <i class="fas fa-handshake-angle text-4xl text-brand-dark"></i>
                            <h3 class="text-2xl font-serif font-bold text-brand-dark">Kolaborasi & Kapasitas</h3>
                        </div>
                        <div class="space-y-4">
                            <div class="group">
                                <h4 class="font-bold text-brand-dark">Matchmaking Riset Global</h4>
                                <p class="text-gray-700 text-sm">Menyusun proposal riset bersama peneliti internasional bereputasi tinggi.</p>
                            </div>
                             <div class="group">
                                <h4 class="font-bold text-brand-dark">Mengundang Profesor Ahli</h4>
                                <p class="text-gray-700 text-sm">Workshop riset dengan target luaran Jurnal Q1.</p>
                            </div>
                            <div class="group">
                                <h4 class="font-bold text-brand-dark">Joint Supervision</h4>
                                <p class="text-gray-700 text-sm">Bimbingan bersama mahasiswa pascasarjana dengan ahli global.</p>
                            </div>
                             <div class="group">
                                <h4 class="font-bold text-brand-dark">Hibah Modul Inovatif</h4>
                                <p class="text-gray-700 text-sm">Pengembangan modul untuk program internasional.</p>
                            </div>
                        </div>
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
                
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 auto-rows-[250px]">
                    <div class="relative group overflow-hidden rounded-lg shadow-lg md:col-span-2 md:row-span-2">
                        <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?q=80&w=2071&auto=format&fit=crop" alt="Kegiatan Workshop" class="w-full h-full object-cover transition-transform duration-500 ease-in-out group-hover:scale-110">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <p class="absolute bottom-4 left-4 text-white font-bold">Kegiatan Workshop</p>
                        </div>
                    </div>
                    <div class="relative group overflow-hidden rounded-lg shadow-lg">
                        <img src="https://images.unsplash.com/photo-1556761175-5973dc0f32e7?q=80&w=1932&auto=format&fit=crop" alt="Kolaborasi Internasional" class="w-full h-full object-cover transition-transform duration-500 ease-in-out group-hover:scale-110">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <p class="absolute bottom-4 left-4 text-white font-bold">Kolaborasi Internasional</p>
                        </div>
                    </div>
                    <div class="relative group overflow-hidden rounded-lg shadow-lg">
                        <img src="https://images.unsplash.com/photo-1542744173-8e7e53415bb0?q=80&w=2070&auto=format&fit=crop" alt="Diskusi Kelompok" class="w-full h-full object-cover transition-transform duration-500 ease-in-out group-hover:scale-110">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <p class="absolute bottom-4 left-4 text-white font-bold">Diskusi Kelompok</p>
                        </div>
                    </div>
                    <div class="relative group overflow-hidden rounded-lg shadow-lg">
                        <img src="https://images.unsplash.com/photo-1505373877841-8d25f7d46678?q=80&w=2012&auto=format&fit=crop" alt="Seminar Internasional" class="w-full h-full object-cover transition-transform duration-500 ease-in-out group-hover:scale-110">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <p class="absolute bottom-4 left-4 text-white font-bold">Seminar Internasional</p>
                        </div>
                    </div>
                    <div class="relative group overflow-hidden rounded-lg shadow-lg md:col-span-2">
                        <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?q=80&w=2070&auto=format&fit=crop" alt="Presentasi" class="w-full h-full object-cover transition-transform duration-500 ease-in-out group-hover:scale-110">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <p class="absolute bottom-4 left-4 text-white font-bold">Sesi Presentasi</p>
                        </div>
                    </div>
                    <div class="relative group overflow-hidden rounded-lg shadow-lg">
                        <img src="https://images.unsplash.com/photo-1573164713988-8665fc963095?q=80&w=2069&auto=format&fit=crop" alt="Mentoring" class="w-full h-full object-cover transition-transform duration-500 ease-in-out group-hover:scale-110">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <p class="absolute bottom-4 left-4 text-white font-bold">Mentoring</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section id="dampak" class="py-24 sm:py-32 bg-brand-dark text-white">
            <div class="container mx-auto px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-4xl font-serif font-bold">Dampak Nyata Program Kami</h2>
                    <p class="mt-3 text-gray-400 max-w-2xl mx-auto">Angka berbicara. Kami bangga dengan pencapaian komunitas peneliti kami.</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-12 text-center" x-data="counter()" x-intersect="start()">
                    <div class="fade-in-up">
                        <i class="fas fa-globe-asia text-5xl text-brand-accent mb-4"></i>
                        <h3 class="text-6xl font-bold counter-animation" style="--num: 25">
                            <span x-text="Math.round(num1)">0</span>+
                        </h3>
                        <p class="mt-2 text-gray-300 text-lg">Negara Terlibat</p>
                    </div>
                    <div class="fade-in-up" style="animation-delay: 200ms;">
                        <i class="fas fa-file-alt text-5xl text-brand-accent mb-4"></i>
                        <h3 class="text-6xl font-bold counter-animation" style="--num: 150">
                            <span x-text="Math.round(num2)">0</span>+
                        </h3>
                        <p class="mt-2 text-gray-300 text-lg">Publikasi Q1 Terbit</p>
                    </div>
                    <div class="fade-in-up" style="animation-delay: 400ms;">
                        <i class="fas fa-handshake-angle text-5xl text-brand-accent mb-4"></i>
                        <h3 class="text-6xl font-bold counter-animation" style="--num: 50">
                             <span x-text="Math.round(num3)">0</span>+
                        </h3>
                        <p class="mt-2 text-gray-300 text-lg">Kolaborasi Riset Global</p>
                    </div>
                </div>
            </div>
        </section>

        <section id="testimoni" class="bg-brand-light py-24 sm:py-32">
            <div class="container mx-auto px-6 lg:px-8">
                 <div class="text-center mb-16">
                    <h2 class="text-4xl font-serif font-bold text-brand-dark">Apa Kata Mereka</h2>
                    <p class="mt-3 text-gray-500 max-w-2xl mx-auto">Pengalaman nyata dari para peneliti yang telah bergabung dengan program kami.</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div class="bg-white p-8 rounded-lg shadow-lg">
                        <i class="fas fa-quote-left text-brand-accent text-3xl mb-4"></i>
                        <p class="text-gray-600 mb-6">"Program Matchmaking Riset Global membuka pintu kolaborasi yang tidak pernah saya bayangkan sebelumnya. Sangat berdampak bagi karir saya."</p>
                        <div class="flex items-center">
                            <img class="w-12 h-12 rounded-full mr-4" src="https://i.pravatar.cc/150?img=1" alt="Avatar of person">
                            <div>
                                <h4 class="font-bold text-brand-dark">Dr. Anisa Putri</h4>
                                <p class="text-sm text-gray-500">Universitas Gadjah Mada</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white p-8 rounded-lg shadow-lg">
                        <i class="fas fa-quote-left text-brand-accent text-3xl mb-4"></i>
                        <p class="text-gray-600 mb-6">"Dukungan pendanaan APC sangat membantu kami untuk mempublikasikan hasil riset di jurnal internasional bereputasi tinggi. Terima kasih!"</p>
                        <div class="flex items-center">
                            <img class="w-12 h-12 rounded-full mr-4" src="https://i.pravatar.cc/150?img=2" alt="Avatar of person">
                            <div>
                                <h4 class="font-bold text-brand-dark">Budi Santoso, Ph.D.</h4>
                                <p class="text-sm text-gray-500">Institut Teknologi Bandung</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white p-8 rounded-lg shadow-lg">
                        <i class="fas fa-quote-left text-brand-accent text-3xl mb-4"></i>
                        <p class="text-gray-600 mb-6">"Workshop dengan profesor ahli dari luar negeri memberikan wawasan baru dan meningkatkan kualitas riset tim kami secara signifikan."</p>
                        <div class="flex items-center">
                            <img class="w-12 h-12 rounded-full mr-4" src="https://i.pravatar.cc/150?img=3" alt="Avatar of person">
                            <div>
                                <h4 class="font-bold text-brand-dark">Rina Wijaya, M.Sc.</h4>
                                <p class="text-sm text-gray-500">Universitas Indonesia</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>

 
    @include('layout.footer') 
    <script>
        function counter() {
            return {
                num1: 0,
                num2: 0,
                num3: 0,
                start() {
                    const animate = (target, el) => {
                        const observer = new IntersectionObserver((entries) => {
                            if (entries[0].isIntersecting) {
                                let start = 0;
                                const end = parseInt(el.style.getPropertyValue('--num'));
                                const duration = 2000;
                                const step = (timestamp) => {
                                    if (!start) start = timestamp;
                                    const progress = timestamp - start;
                                    target = Math.min(Math.floor(progress / duration * end), end);
                                    if(target === this.num1) this.num1 = target;
                                    if(target === this.num2) this.num2 = target;
                                    if(target === this.num3) this.num3 = target;
                                    if (progress < duration) {
                                        window.requestAnimationFrame(step);
                                    }
                                };
                                window.requestAnimationFrame(step);
                                observer.unobserve(el);
                            }
                        });
                        observer.observe(el);
                    }
                    
                    const el1 = this.$el.children[0].children[1];
                    const el2 = this.$el.children[1].children[1];
                    const el3 = this.$el.children[2].children[1];
                    
                    this.num1 = parseInt(el1.style.getPropertyValue('--num'));
                    this.num2 = parseInt(el2.style.getPropertyValue('--num'));
                    this.num3 = parseInt(el3.style.getPropertyValue('--num'));
                }
            }
        }
    </script>

</body>
</html>