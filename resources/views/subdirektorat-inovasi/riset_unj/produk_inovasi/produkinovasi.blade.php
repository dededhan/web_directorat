<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk Inovasi UNJ</title>
    <link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" type="image/png">
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet" />
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            DEFAULT: '#186569',
                            light: '#2a7a7e',
                            dark: '#0d4b4f',
                        },
                        secondary: '#F1F8F8',
                        accent: '#ffb74d',
                        textColor: '#1A202C',
                        textSecondary: '#4A5568',
                        backgroundColor: '#FFFFFF',
                        cardColor: '#FFFFFF',
                    },
                    boxShadow: {
                        card: '0 4px 12px rgba(0, 0, 0, 0.05)',
                        'card-hover': '0 10px 25px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -4px rgba(0, 0, 0, 0.1)',
                        'search': '0 5px 20px rgba(24, 101, 105, 0.1)',
                    },
                    borderRadius: {
                        card: '1rem',
                        'button': '0.5rem',
                    },
                    transitionTimingFunction: {
                        'out-expo': 'cubic-bezier(0.19, 1, 0.22, 1)',
                    },
                },
            },
        }
    </script>

    <style>
        /* Ensure FontAwesome icons load properly */
        .fa, .fas, .far, .fal, .fab {
            font-family: "Font Awesome 6 Free", "Font Awesome 6 Pro", "Font Awesome 6 Brands" !important;
        }
        
        .filter-btn.active {
            background-color: #186569;
            color: white;
            font-weight: 700;
            box-shadow: 0 4px 14px rgba(24, 101, 105, 0.25);
        }
        
        .hero-gradient {
            background: linear-gradient(135deg, #F1F8F8 0%, #FFFFFF 100%);
        }
        
        .section-bg {
            background-color: #F7FAFC;
        }
        
        .hero-bg-pattern {
            background-image: radial-gradient(#1865691a 1px, transparent 1px);
            background-size: 20px 20px;
        }
        
        .line-clamp-3 {
            overflow: hidden;
            display: -webkit-box;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 3;
        }
        
        /* Fallback for icons if FontAwesome fails to load */
        .icon-fallback::before {
            content: "•";
            margin-right: 0.5rem;
        }
    </style>
</head>
<body class="bg-backgroundColor text-textColor font-sans antialiased">
    
    <header class="fixed top-0 left-0 w-full z-50">
        @include('layout.navbar_hilirisasi')
    </header>

    <div class="pt-12 md:pt-16 overflow-x-hidden">
        <main>
            <section class="hero-gradient pt-20 md:pt-28 pb-24 relative">
                <div class="absolute inset-0 hero-bg-pattern -z-10"></div>
                <div class="container mx-auto px-6 lg:px-8 max-w-screen-2xl">
                    <div class="flex flex-col lg:flex-row items-center gap-12">
                        <div class="w-full lg:w-6/12 text-center lg:text-left">
                            <h1 class="text-4xl sm:text-5xl md:text-6xl font-extrabold text-primary leading-tight mb-6">
                                Portal Inovasi Universitas Negeri Jakarta
                            </h1>
                            <p class="text-lg text-textSecondary mb-10 max-w-xl mx-auto lg:mx-0">
                                Jelajahi berbagai karya, riset, dan produk inovatif dari civitas akademika UNJ yang berkontribusi untuk kemajuan bangsa.
                            </p>
                            <a href="#katalog" class="inline-block bg-primary hover:bg-primary-dark text-white font-bold text-lg py-4 px-10 rounded-button transition-all duration-300 ease-out-expo hover:shadow-lg transform hover:-translate-y-1">
                                Jelajahi Katalog
                            </a>
                        </div>
                        <div class="w-full lg:w-6/12">
                            <div class="relative mx-auto max-w-lg lg:max-w-none">
                                <div class="absolute inset-0 bg-primary/10 rounded-full blur-3xl -z-10 -translate-x-10 translate-y-10 scale-125"></div>
                                <img 
                                    src="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" 
                                    alt="Mahasiswa UNJ berinovasi" 
                                    class="w-full rounded-card shadow-card"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </section>
             
            @if($video)
            <section class="py-20 md:py-28 section-bg">
                <div class="container mx-auto px-6 lg:px-8 max-w-screen-2xl">
                    <div class="text-center mb-12">
                        <h2 class="text-3xl md:text-4xl font-bold text-primary mb-4">Sambutan Pimpinan</h2>
                        <p class="text-textSecondary text-lg max-w-3xl mx-auto">Sambutan dari Ibu Dr. RA Murti Kusuma W.S.IP, M.Si. selaku Direktur Inovasi, Sistem Informasi dan Pemeringkatan Universitas Negeri Jakarta.</p>
                    </div>
                    
                    <div id="video-container" class="max-w-5xl mx-auto bg-black rounded-card shadow-card overflow-hidden aspect-video relative">
                        @if($video->type == 'youtube')
                            <div id="video-placeholder" class="w-full h-full bg-cover bg-center cursor-pointer relative group"
                                style="background-image: url('https://img.youtube.com/vi/{{ $video->path }}/maxresdefault.jpg');"
                                data-video-type="{{ $video->type }}" data-video-path="{{ $video->path }}">
                                <div class="absolute inset-0 bg-black/40 flex flex-col items-center justify-center text-center text-white p-4 transition-colors duration-300 group-hover:bg-black/20">
                                    <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center transform group-hover:scale-110 transition-transform duration-300 ease-out-expo">
                                        <i class="fa-solid fa-play text-white text-3xl ml-1"></i>
                                    </div>
                                    <h3 class="text-xl md:text-2xl font-bold tracking-wide mt-6">{{ $video->title }}</h3>
                                </div>
                            </div>
                        @elseif($video->type == 'mp4')
                            <div id="video-placeholder" class="w-full h-full bg-gradient-to-br from-primary to-primary-light flex items-center justify-center cursor-pointer group"
                                data-video-type="{{ $video->type }}" data-video-path="{{ asset('storage/' . $video->path) }}">
                                <div class="text-center text-white">
                                    <i class="fas fa-play-circle text-6xl mb-4 opacity-80 transform group-hover:scale-110 transition-transform duration-300 ease-out-expo"></i>
                                    <p class="text-xl">{{ $video->title }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </section>
            @endif
            
            <section class="py-20 md:py-28">
                <div class="container mx-auto px-6 lg:px-8 max-w-screen-2xl">
                    <div class="text-center mb-16">
                        <h2 class="text-3xl md:text-4xl font-bold text-primary mb-4">Tentang Inovasi UNJ</h2>
                        <p class="text-textSecondary text-lg max-w-3xl mx-auto">Kami berkomitmen untuk menjembatani hasil riset dan pengembangan menjadi produk yang berdampak nyata bagi masyarakat dan industri.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                        @php
                            $infoCards = [
                                ['icon' => 'fa-lightbulb', 'color' => 'accent', 'title' => 'Mengapa Inovasi UNJ?', 'text' => 'Unit Inovasi UNJ dibentuk untuk menjembatani hasil penelitian dan pengembangan civitas akademika menuju produk yang berdampak nyata bagi masyarakat.'],
                                ['icon' => 'fa-rocket', 'color' => 'primary', 'title' => 'Inovasi Dihasilkan', 'text' => 'Hingga kini UNJ telah menghasilkan lebih dari 150 produk inovasi di berbagai bidang, mulai dari pendidikan, teknologi, kesehatan, hingga industri kreatif.'],
                                ['icon' => 'fa-seedling', 'color' => 'green', 'title' => 'Harapan ke Depan', 'text' => 'Menjadi pusat inovasi terdepan di Asia Tenggara yang menghasilkan solusi berkelanjutan, dengan target 500 produk inovasi berdampak pada tahun 2030.'],
                                ['icon' => 'fa-users', 'color' => 'blue', 'title' => 'Dampak Masyarakat', 'text' => 'Produk inovasi UNJ telah menjangkau lebih dari 1 juta masyarakat, meningkatkan kualitas hidup, dan mendorong pertumbuhan ekonomi berkelanjutan.']
                            ];
                        @endphp
                        @foreach ($infoCards as $card)
                        <div class="bg-cardColor rounded-card p-8 shadow-card hover:shadow-card-hover transition-all duration-300 transform hover:-translate-y-2 group">
                            @php
                                $iconBgClass = '';
                                $iconTextClass = '';
                                switch ($card['color']) {
                                    case 'accent':
                                        $iconBgClass = 'bg-yellow-500/10';
                                        $iconTextClass = 'text-yellow-600';
                                        break;
                                    case 'primary':
                                        $iconBgClass = 'bg-primary/10';
                                        $iconTextClass = 'text-primary';
                                        break;
                                    case 'green':
                                        $iconBgClass = 'bg-green-500/10';
                                        $iconTextClass = 'text-green-600';
                                        break;
                                    case 'blue':
                                        $iconBgClass = 'bg-blue-500/10';
                                        $iconTextClass = 'text-blue-600';
                                        break;
                                }
                            @endphp
                            <div class="w-16 h-16 {{ $iconBgClass }} {{ $iconTextClass }} rounded-xl flex items-center justify-center mb-6 transition-transform duration-300 group-hover:scale-110">
                                <i class="fas {{ $card['icon'] }} text-3xl"></i>
                            </div>
                            <h3 class="text-xl font-bold mb-3">{{ $card['title'] }}</h3>
                            <p class="text-textSecondary leading-relaxed">{{ $card['text'] }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
            </section>
            
            <section class="py-20 md:py-28 section-bg">
                <div class="container mx-auto px-6 lg:px-8 max-w-screen-2xl">
                    <div class="text-center mb-16">
                        <h2 class="text-3xl md:text-4xl font-bold text-primary mb-4">Mitra Kolaborasi</h2>
                        <p class="text-textSecondary text-lg max-w-3xl mx-auto">Bersama membangun ekosistem inovasi yang berkelanjutan.</p>
                    </div>

                    @php
                        $mitraList = [
                            ['icon' => 'fa-school', 'title' => 'Pendidikan', 'description' => 'Kolaborasi dengan institusi pendidikan untuk meningkatkan mutu pembelajaran dan teknologi edukasi.'],
                            ['icon' => 'fa-flask', 'title' => 'Sains & Teknologi', 'description' => 'Bermitra dengan industri teknologi dan lembaga riset untuk menciptakan solusi masa depan.'],
                            ['icon' => 'fa-palette', 'title' => 'Sosial Humaniora & Seni', 'description' => 'Mengembangkan inovasi sosial dan budaya yang memperkaya kehidupan masyarakat.'],
                            ['icon' => 'fa-heart-pulse', 'title' => 'Kesehatan & Psikologi', 'description' => 'Bekerja sama untuk meningkatkan kesejahteraan fisik dan mental melalui inovasi terapan.']
                        ];
                    @endphp

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                        @foreach($mitraList as $mitra)
                        <div class="group bg-cardColor rounded-card p-8 text-center shadow-card transition-all duration-300 ease-out-expo transform hover:-translate-y-2 hover:shadow-card-hover hover:bg-primary">
                            <div class="w-20 h-20 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-6 transition-all duration-300 group-hover:bg-white/20 group-hover:scale-110">
                                <i class="fas {{ $mitra['icon'] }} text-4xl text-primary transition-colors duration-300 group-hover:text-white"></i>
                            </div>
                            <h3 class="text-xl font-bold text-textColor mb-3 transition-colors duration-300 group-hover:text-white">{{ $mitra['title'] }}</h3>
                            <p class="text-textSecondary leading-relaxed transition-colors duration-300 group-hover:text-gray-200">{{ $mitra['description'] }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
            </section>

            <section id="katalog" class="py-20 md:py-28">
                <div class="container mx-auto px-6 lg:px-8 max-w-screen-2xl">
                    <div class="text-center mb-12">
                        <h2 class="text-3xl md:text-4xl font-bold text-primary mb-4">Katalog Produk Inovasi</h2>
                        <p class="text-textSecondary text-lg max-w-3xl mx-auto">Temukan berbagai inovasi dan karya terbaik dari civitas akademika Universitas Negeri Jakarta.</p>
                    </div>
                
                    <div class="w-full max-w-2xl mx-auto mb-12">
                        <div class="relative shadow-search rounded-full">
                            <div class="absolute inset-y-0 left-0 pl-6 flex items-center pointer-events-none">
                                <i class="fa-solid fa-search text-gray-400"></i>
                            </div>
                            <input type="text" id="searchInput" class="w-full py-4 pl-14 pr-6 border-transparent rounded-full outline-none text-base bg-white transition duration-300 text-textColor placeholder-textSecondary placeholder-opacity-70 focus:ring-2 focus:ring-primary/50" placeholder="Cari produk, inovator, atau kata kunci...">
                        </div>

                        <div class="flex justify-center items-center gap-2 sm:gap-4 mt-8 p-1.5 bg-primary/5 rounded-full max-w-sm mx-auto">
                            <button class="filter-btn active flex-1 text-center px-4 py-2.5 rounded-full transition-all duration-300 ease-out-expo text-sm font-semibold" data-filter="all">Semua</button>
                            <button class="filter-btn flex-1 text-center px-4 py-2.5 rounded-full transition-all duration-300 ease-out-expo text-sm font-semibold" data-filter="paten">Paten</button>
                            <button class="filter-btn flex-1 text-center px-4 py-2.5 rounded-full transition-all duration-300 ease-out-expo text-sm font-semibold" data-filter="hki">HKI</button>
                        </div>
                    </div>
                
                    <div id="productsGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                        @forelse($produkInovasi as $produk)
                        <div class="product-card bg-cardColor rounded-card overflow-hidden h-full flex flex-col transition-all duration-300 group border border-gray-200/50 hover:shadow-card-hover hover:-translate-y-2" data-category="{{ strtolower($produk->kategori) }}">
                            
                            <a href="{{ route('subdirektorat-inovasi.riset_unj.produk_inovasi.show', $produk->id) }}" class="block overflow-hidden">
                                @if($produk->gambar)
                                <div class="h-52 bg-cover bg-center transition-transform duration-300 ease-out-expo group-hover:scale-105" style="background-image: url('{{ asset('storage/'. $produk->gambar) }}')"></div>
                                @else
                                <div class="h-52 bg-gradient-to-br from-gray-200 to-gray-300 flex items-center justify-center transition-transform duration-300 ease-out-expo group-hover:scale-105">
                                    <i class="fas fa-lightbulb text-5xl text-white"></i>
                                </div>
                                @endif
                            </a>
                            
                            <div class="p-6 flex flex-col flex-grow">
                                <div class="flex justify-between items-start mb-3">
                                    <span class="innovator-info inline-flex items-center text-xs font-medium text-primary bg-primary/10 px-2.5 py-1 rounded-full">
                                        <i class="fas fa-user-alt mr-1.5"></i>
                                        {{ $produk->inovator }}
                                    </span>
                                    <div class="bg-accent/20 text-accent rounded-full px-3 py-1 text-xs font-semibold">
                                        {{ $produk->kategori }}
                                    </div>
                                </div>
                                
                                <h3 class="product-name text-xl font-bold mb-2 text-textColor group-hover:text-primary transition-colors duration-300">
                                    <a href="{{ route('subdirektorat-inovasi.riset_unj.produk_inovasi.show', $produk->id) }}">
                                        {{ $produk->nama_produk }}
                                    </a>
                                </h3>
                                
                                <p class="product-description text-textSecondary text-sm mb-5 line-clamp-3">
                                    {!! Str::limit(strip_tags($produk->deskripsi), 120) !!}
                                </p>
                                
                                <div class="mt-auto pt-4 border-t border-gray-200/80">
                                    <a href="{{ route('subdirektorat-inovasi.riset_unj.produk_inovasi.show', $produk->id) }}" class="w-full bg-primary/5 text-primary hover:bg-primary hover:text-white transition-all duration-300 flex items-center justify-center text-sm font-semibold py-3 px-4 rounded-button">
                                        <span>Lihat Detail</span>
                                        <i class="fas fa-arrow-right ml-2 transform group-hover:translate-x-1 transition-transform duration-300"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-span-full flex flex-col items-center justify-center py-16 text-center text-textSecondary">
                            <i class="fas fa-box-open text-6xl mb-4 text-gray-300"></i>
                            <p class="text-xl font-semibold">Produk Inovasi Belum Tersedia</p>
                            <p>Silakan kembali lagi nanti untuk melihat karya-karya terbaru.</p>
                        </div>
                        @endforelse
                        
                        <div id="noResultsMessage" class="hidden col-span-full flex-col items-center justify-center py-16 text-center text-textSecondary">
                            <i class="fas fa-search-minus text-6xl mb-4 text-gray-300"></i>
                            <p class="text-xl font-semibold">Hasil Tidak Ditemukan</p>
                            <p>Coba gunakan kata kunci atau filter yang berbeda.</p>
                        </div>
                    </div>
                </div>
            </section>

            <section class="py-20 md:py-28 section-bg">
                <div class="container mx-auto px-6 lg:px-8 max-w-screen-2xl">
                    <div class="text-center mb-16">
                        <h2 class="text-3xl md:text-4xl font-bold text-primary mb-4">Berita Inovasi Terkini</h2>
                        <p class="text-textSecondary text-lg max-w-3xl mx-auto">Ikuti perkembangan terbaru seputar inovasi, riset, dan prestasi di lingkungan Universitas Negeri Jakarta.</p>
                    </div>
                
                    @if(isset($beritaInovasi) && $beritaInovasi->count() > 0)
                        @php $beritaUtama = $beritaInovasi->first(); @endphp
                        @php $beritaLainnya = $beritaInovasi->slice(1, 2); @endphp

                        <div class="grid grid-cols-1 lg:grid-cols-5 gap-8 mb-8">
                            <a href="{{ route('Berita.show', ['slug' => $beritaUtama->slug]) }}" class="group block lg:col-span-3 bg-cardColor rounded-card overflow-hidden shadow-card hover:shadow-card-hover transition-all duration-300 transform hover:-translate-y-2">
                                <div class="flex flex-col md:flex-row h-full">
                                    <div class="w-full md:w-6/12 h-64 md:h-full bg-cover bg-center transition-transform duration-300 ease-out-expo group-hover:scale-105" style="background-image: url('{{ asset('storage/' . $beritaUtama->gambar) }}')"></div>
                                    <div class="w-full md:w-6/12 p-6 md:p-8 flex flex-col justify-center">
                                        <p class="text-sm text-textSecondary mb-2">{{ $beritaUtama->created_at->format('d F Y') }}</p>
                                        <h3 class="text-2xl font-bold mb-3 text-textColor group-hover:text-primary transition-colors duration-300">{{ $beritaUtama->judul }}</h3>
                                        <p class="text-textSecondary text-sm leading-relaxed mb-4 line-clamp-3">
                                            {{ Str::limit(strip_tags($beritaUtama->isi), 150) }}
                                        </p>
                                        <span class="text-primary font-bold mt-auto self-start">
                                            Baca Selengkapnya <i class="fas fa-arrow-right ml-1 transform group-hover:translate-x-1 transition-transform duration-300"></i>
                                        </span>
                                    </div>
                                </div>
                            </a>
                            <div class="lg:col-span-2 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-1 gap-8">
                                @foreach($beritaLainnya as $berita)
                                <a href="{{ route('Berita.show', ['slug' => $berita->slug]) }}" class="group block bg-cardColor rounded-card overflow-hidden shadow-card hover:shadow-card-hover transition-all duration-300 transform hover:-translate-y-2 flex flex-col">
                                    <div class="h-40 bg-cover bg-center transition-transform duration-300 ease-out-expo group-hover:scale-105" style="background-image: url('{{ asset('storage/' . $berita->gambar) }}')"></div>
                                    <div class="p-5 flex flex-col flex-grow">
                                        <p class="text-xs text-textSecondary mb-2">{{ $berita->created_at->format('d F Y') }}</p>
                                        <h3 class="font-bold text-textColor group-hover:text-primary transition-colors duration-300 mb-2 flex-grow">{{ $berita->judul }}</h3>
                                        <span class="text-primary font-semibold text-sm mt-auto self-start">
                                            Baca Selengkapnya <i class="fas fa-arrow-right ml-1 transform group-hover:translate-x-1 transition-transform duration-300"></i>
                                        </span>
                                    </div>
                                </a>
                                @endforeach
                            </div>
                        </div>

                        <div class="text-center mt-12">
                            <a href="{{ route('berita.kategori', 'inovasi') }}" class="inline-block bg-primary hover:bg-primary-dark text-white font-bold text-base py-3 px-8 rounded-button transition-all duration-300 ease-out-expo hover:shadow-lg transform hover:-translate-y-1">
                                Lihat Semua Berita
                            </a>
                        </div>
                    @else
                        <div class="col-span-full flex flex-col items-center justify-center py-16 text-center text-textSecondary bg-gray-50 rounded-card">
                            <i class="fas fa-newspaper text-6xl mb-4 text-gray-300"></i>
                            <p class="text-xl font-semibold">Belum Ada Berita Inovasi</p>
                            <p>Nantikan update terbaru dari kami segera.</p>
                        </div>
                    @endif
                </div>
            </section>
        </main>
    </div>
    
    @include('layout.footer')

   <script>
    // Script untuk memutar video saat placeholder diklik
    document.addEventListener('DOMContentLoaded', function () {
        const placeholder = document.getElementById('video-placeholder');
        const videoContainer = document.getElementById('video-container');

        if (placeholder) {
            placeholder.addEventListener('click', function () {
                const type = this.dataset.videoType;
                const path = this.dataset.videoPath;
                let playerHtml = '';

                if (type === 'youtube') {
                    playerHtml = `<iframe class="w-full h-full" src="https://www.youtube.com/embed/${path}?autoplay=1&mute=1&rel=0" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>`;
                } else if (type === 'mp4') {
                    playerHtml = `<video class="w-full h-full" controls autoplay muted><source src="${path}" type="video/mp4">Browser Anda tidak mendukung tag video.</video>`;
                }

                if (playerHtml) {
                    videoContainer.innerHTML = playerHtml;
                }
            });
        }
    });

    // Script untuk filter dan search
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const filterButtons = document.querySelectorAll('.filter-btn');
        const productCards = document.querySelectorAll('.product-card');
        const noResultsMessage = document.getElementById('noResultsMessage');
        let currentFilter = 'all';

        function filterAndSearch() {
            const searchTerm = searchInput.value.trim().toLowerCase();
            let hasResults = false;

            productCards.forEach(card => {
                const title = card.querySelector('.product-name')?.textContent.toLowerCase() || '';
                const innovator = card.querySelector('.innovator-info')?.textContent.toLowerCase() || '';
                const description = card.querySelector('.product-description')?.textContent.toLowerCase() || '';
                const category = card.dataset.category || '';

                const matchesSearch = title.includes(searchTerm) || innovator.includes(searchTerm) || description.includes(searchTerm);
                const matchesFilter = (currentFilter === 'all') || (category === currentFilter);

                if (matchesSearch && matchesFilter) {
                    card.style.display = 'flex';
                    hasResults = true;
                } else {
                    card.style.display = 'none';
                }
            });

            if (hasResults) {
                noResultsMessage.classList.add('hidden');
                noResultsMessage.classList.remove('flex');
            } else {
                noResultsMessage.classList.remove('hidden');
                noResultsMessage.classList.add('flex');
            }
        }

        filterButtons.forEach(button => {
            button.addEventListener('click', () => {
                filterButtons.forEach(btn => btn.classList.remove('active'));
                button.classList.add('active');
                currentFilter = button.dataset.filter;
                filterAndSearch();
            });
        });
        
        searchInput.addEventListener('keyup', filterAndSearch);
    });

    // Script untuk smooth scroll
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
   </script>
</body>
</html>