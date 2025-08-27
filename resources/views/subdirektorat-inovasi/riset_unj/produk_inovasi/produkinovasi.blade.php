<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk Inovasi UNJ</title>
    <link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" type="image/png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="{{ asset('home.css') }}">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            DEFAULT: '#186569',
                            light: '#2a7a7e',
                            dark: '#0d4b4f',
                        },
                        accent: '#ffb74d',
                        textColor: '#333333',
                        textSecondary: '#555555',
                        backgroundColor: '#f8f9fa',
                        cardColor: '#ffffff',
                    },
                    boxShadow: {
                        card: '0 4px 12px rgba(0, 0, 0, 0.08)',
                        hover: '0 12px 20px rgba(0, 0, 0, 0.1)',
                        search: '0 5px 15px rgba(0, 0, 0, 0.1)',
                    },
                    borderRadius: {
                        card: '12px',
                    },
                    transitionDuration: {
                        DEFAULT: '300ms',
                    },
                },
            },
        }
    </script>
    <style>
        .filter-btn.active {
            background-color: #186569; /* primary color */
            color: white;
            font-weight: 600;
        }
    </style>
</head>
<body class="bg-backgroundColor text-textColor leading-relaxed text-base font-['Segoe_UI',Tahoma,Geneva,Verdana,sans-serif]">
@include('layout.navbar_hilirisasi')
    
    <section class="bg-gradient-to-br from-primary to-primary-dark py-20 mb-8 relative overflow-hidden">
        <div class="absolute inset-0 opacity-30" style="background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100"><rect width="100" height="100" fill="none"/><path d="M0,0 L100,100" stroke="rgba(255,255,255,0.05)" stroke-width="2"/></svg>');"></div>
        <div class="relative text-center text-white max-w-3xl mx-auto px-4">
            <h1 class="text-4xl font-bold mb-4 drop-shadow-md">Produk Inovasi UNJ</h1>
            <p class="text-xl opacity-90">Temukan berbagai inovasi dan karya terbaik dari civitas akademika Universitas Negeri Jakarta</p>
        </div>
    </section>

    <div class="pt-12 md:pt-16 overflow-x-hidden">
        <main class="w-[90%] max-w-6xl mx-auto">
            
            <section class="mb-16">
                <div class="text-center mb-8">
                    <h2 class="text-3xl md:text-4xl font-bold text-primary mb-4">Sambutan Pimpinan</h2>
                    <p class="text-textSecondary text-lg max-w-2xl mx-auto">Sambutan dari Ibu Prof. Dr. Komarudin, M.Si. selaku Rektor Universitas Negeri Jakarta mengenai pentingnya inovasi dalam dunia pendidikan</p>
                </div>
                <div class="bg-cardColor rounded-card shadow-card overflow-hidden">
                    <div class="aspect-video relative">
                        <div class="w-full h-full bg-gradient-to-br from-primary to-primary-light flex items-center justify-center">
                            <div class="text-center text-white">
                                <i class="fas fa-play-circle text-6xl mb-4 opacity-80"></i>
                                <p class="text-xl">Video Sambutan Pimpinan UNJ</p>
                                <p class="text-sm opacity-80 mt-2">Tentang Visi dan Misi Inovasi UNJ</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="mb-16">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-primary mb-4">Tentang Inovasi UNJ</h2>
                    <p class="text-textSecondary text-lg max-w-2xl mx-auto">Membangun ekosistem inovasi yang berkelanjutan untuk kemajuan bangsa</p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
                    <div class="bg-cardColor rounded-card p-8 shadow-card hover:shadow-hover transition-all duration-300">
                        <div class="flex items-center mb-6">
                            <div class="w-12 h-12 bg-primary/10 rounded-full flex items-center justify-center mr-4">
                                <i class="fas fa-lightbulb text-primary text-xl"></i>
                            </div>
                            <h3 class="text-xl font-bold">Mengapa Inovasi UNJ?</h3>
                        </div>
                        <p class="text-textSecondary leading-relaxed">
                            Unit Inovasi UNJ dibentuk untuk menjembatani hasil penelitian dan pengembangan civitas akademika menuju produk yang berdampak nyata bagi masyarakat. Kami berkomitmen menghasilkan solusi inovatif untuk tantangan masa depan.
                        </p>
                    </div>

                    <div class="bg-cardColor rounded-card p-8 shadow-card hover:shadow-hover transition-all duration-300">
                        <div class="flex items-center mb-6">
                            <div class="w-12 h-12 bg-accent/20 rounded-full flex items-center justify-center mr-4">
                                <i class="fas fa-rocket text-accent text-xl"></i>
                            </div>
                            <h3 class="text-xl font-bold">Inovasi yang Dihasilkan</h3>
                        </div>
                        <p class="text-textSecondary leading-relaxed">
                            Hingga kini UNJ telah menghasilkan lebih dari 150 produk inovasi di berbagai bidang, mulai dari pendidikan, teknologi, kesehatan, hingga industri kreatif yang telah memberikan kontribusi positif bagi masyarakat.
                        </p>
                    </div>

                    <div class="bg-cardColor rounded-card p-8 shadow-card hover:shadow-hover transition-all duration-300">
                        <div class="flex items-center mb-6">
                            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mr-4">
                                <i class="fas fa-seedling text-green-600 text-xl"></i>
                            </div>
                            <h3 class="text-xl font-bold">Harapan ke Depan</h3>
                        </div>
                        <p class="text-textSecondary leading-relaxed">
                            Menjadi pusat inovasi terdepan di Asia Tenggara yang menghasilkan solusi berkelanjutan untuk permasalahan global, dengan target 500 produk inovasi yang berdampak pada tahun 2030.
                        </p>
                    </div>

                    <div class="bg-cardColor rounded-card p-8 shadow-card hover:shadow-hover transition-all duration-300">
                        <div class="flex items-center mb-6">
                            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mr-4">
                                <i class="fas fa-users text-blue-600 text-xl"></i>
                            </div>
                            <h3 class="text-xl font-bold">Dampak untuk Masyarakat</h3>
                        </div>
                        <p class="text-textSecondary leading-relaxed">
                            Produk inovasi UNJ telah menjangkau lebih dari 1 juta masyarakat Indonesia, meningkatkan kualitas hidup, menciptakan lapangan kerja baru, dan mendorong pertumbuhan ekonomi berkelanjutan.
                        </p>
                    </div>
                </div>

                <div class="bg-gradient-to-r from-primary/5 to-accent/5 rounded-card p-8">
                    <div class="text-center mb-8">
                        <h3 class="text-2xl font-bold text-primary mb-4">Mitra Kolaborasi</h3>
                        <p class="text-textSecondary">Bersama membangun ekosistem inovasi yang berkelanjutan</p>
                    </div>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
                        <div class="flex flex-col items-center">
                            <div class="w-16 h-16 bg-white rounded-full shadow-md flex items-center justify-center mb-3">
                                <i class="fas fa-industry text-primary text-2xl"></i>
                            </div>
                            <span class="text-sm font-medium">Industri</span>
                        </div>
                        <div class="flex flex-col items-center">
                            <div class="w-16 h-16 bg-white rounded-full shadow-md flex items-center justify-center mb-3">
                                <i class="fas fa-university text-primary text-2xl"></i>
                            </div>
                            <span class="text-sm font-medium">Perguruan Tinggi</span>
                        </div>
                        <div class="flex flex-col items-center">
                            <div class="w-16 h-16 bg-white rounded-full shadow-md flex items-center justify-center mb-3">
                                <i class="fas fa-building text-primary text-2xl"></i>
                            </div>
                            <span class="text-sm font-medium">Pemerintah</span>
                        </div>
                        <div class="flex flex-col items-center">
                            <div class="w-16 h-16 bg-white rounded-full shadow-md flex items-center justify-center mb-3">
                                <i class="fas fa-handshake text-primary text-2xl"></i>
                            </div>
                            <span class="text-sm font-medium">Komunitas</span>
                        </div>
                    </div>
                </div>
            </section>

            <section id="katalog" class="mb-16">
                <div class="text-center mb-8">
                    <h2 class="text-3xl md:text-4xl font-bold text-primary mb-4">Katalog Produk Inovasi UNJ</h2>
                    <p class="text-textSecondary text-lg max-w-2xl mx-auto">Temukan berbagai inovasi dan karya terbaik dari civitas akademika Universitas Negeri Jakarta.</p>
                </div>
                
                <div class="flex w-full max-w-xl mx-auto relative shadow-search rounded-full mb-10">
                    <input type="text" id="searchInput" class="flex-grow py-4 px-6 border-none rounded-l-full outline-none text-base bg-white/95 transition duration-300 text-textColor placeholder-textSecondary placeholder-opacity-70 focus:ring-2 focus:ring-accent" placeholder="Cari produk inovasi, inovator, atau kata kunci...">
                    <button id="searchButton" class="bg-accent text-textColor border-none px-7 rounded-r-full cursor-pointer transition duration-300 flex items-center justify-center font-semibold hover:bg-[#ffa726] hover:-translate-y-px">
                        <i class="fa-solid fa-search"></i>
                        <span class="ml-2 md:inline hidden">Cari</span>
                    </button>
                </div>

                <div class="flex justify-center items-center gap-2 sm:gap-4 mb-10 p-2 bg-primary/5 rounded-full max-w-sm mx-auto">
                    <button class="filter-btn active flex-1 text-center px-4 py-2 rounded-full transition-colors duration-300" data-filter="all">Semua</button>
                    <button class="filter-btn flex-1 text-center px-4 py-2 rounded-full transition-colors duration-300" data-filter="paten">Paten</button>
                    <button class="filter-btn flex-1 text-center px-4 py-2 rounded-full transition-colors duration-300" data-filter="hki">HKI</button>
                </div>
                
                <div id="productsGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 my-5">
                    @if($produkInovasi->count() > 0)
                        @foreach($produkInovasi as $produk)
                        {{-- Menambahkan data-category untuk filtering --}}
                        <div class="product-card bg-cardColor rounded-card overflow-hidden shadow-card h-full flex flex-col transition duration-300 border border-black/5 hover:transform hover:-translate-y-2 hover:shadow-hover" 
                             data-category="{{ $produk->nomor_paten ? 'paten' : 'hki' }}">
                            
                            @if($produk->gambar)
                            <div class="h-[200px] bg-cover bg-center relative" style="background-image: url('{{ asset('storage/'. $produk->gambar) }}')"></div>
                            @else
                            <div class="h-[200px] bg-gradient-to-br from-primary to-primary-light flex items-center justify-center">
                                <i class="fas fa-lightbulb text-5xl text-white opacity-70"></i>
                            </div>
                            @endif
                            
                            <div class="p-5 flex flex-col flex-grow relative">
                                <span class="innovator-info inline-flex items-center text-xs font-medium text-primary bg-primary/10 px-2.5 py-1 rounded-full mb-3">
                                    <i class="fas fa-user-alt mr-1.5"></i>
                                    {{ $produk->inovator }}
                                </span>
                                
                                <h3 class="product-name text-xl font-bold mb-3">{{ $produk->nama_produk }}</h3>
                                
                                <p class="product-description text-textSecondary text-sm mb-4 line-clamp-3">
                                    {!! Str::limit(strip_tags($produk->deskripsi), 120) !!}
                                </p>
                                
                                <div class="flex justify-between items-center mt-auto mb-3 md:flex-row flex-col md:items-center items-start">
                                    <div class="flex items-center text-textSecondary text-sm">
                                        <i class="fas fa-calendar-alt mr-1.5"></i>
                                        <span>{{ $produk->created_at->format('d M Y') }}</span>
                                    </div>
                                    
                                    @if($produk->nomor_paten)
                                    <div class="bg-accent/20 text-accent rounded-full px-3 py-1 text-xs font-semibold flex items-center mt-2 md:mt-0">
                                        <i class="fas fa-certificate mr-1"></i>
                                        Paten
                                    </div>
                                    @endif
                                </div>
                                
                                <button onclick="openProductModal({{ $produk->id }})" class="w-full mt-2 bg-primary hover:bg-primary-dark text-white transition duration-300 flex items-center justify-center text-sm font-medium py-2.5 px-3 rounded">
                                    Baca Selengkapnya
                                </button>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="col-span-full flex flex-col items-center justify-center py-16 text-center text-textSecondary">
                            <i class="fas fa-lightbulb text-5xl mb-4 opacity-50"></i>
                            <p class="text-lg">Belum ada produk inovasi yang tersedia.</p>
                        </div>
                    @endif
                     <div id="noResultsMessage" class="hidden col-span-full flex-col items-center justify-center py-16 text-center text-textSecondary">
                        <i class="fas fa-search text-5xl mb-4 opacity-50"></i>
                        <p class="text-lg">Produk inovasi tidak ditemukan.</p>
                    </div>
                </div>
            </section>

            <section class="mb-16">
                <div class="text-center mb-8">
                    <h2 class="text-3xl md:text-4xl font-bold text-primary mb-4">Berita Inovasi Terkini</h2>
                    <p class="text-textSecondary text-lg">Update terbaru seputar perkembangan inovasi di UNJ</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div class="md:col-span-2 lg:col-span-3 bg-cardColor rounded-card overflow-hidden shadow-card hover:shadow-hover transition-all duration-300">
                        <div class="md:flex">
                            <div class="md:w-2/3">
                                <div class="h-64 md:h-full bg-gradient-to-br from-primary to-primary-light flex items-center justify-center">
                                    <div class="text-center text-white p-6">
                                        <i class="fas fa-newspaper text-4xl mb-4 opacity-80"></i>
                                        <h3 class="text-xl font-bold">Berita Utama Inovasi UNJ</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="md:w-1/3 p-6 md:p-8">
                                <div class="flex items-center text-xs text-textSecondary mb-3">
                                    <i class="fas fa-calendar mr-2"></i>
                                    <span>15 Januari 2025</span>
                                </div>
                                <h3 class="text-xl font-bold mb-4">UNJ Raih Penghargaan Inovasi Terbaik Nasional 2025</h3>
                                <p class="text-textSecondary text-sm leading-relaxed mb-4">
                                    Universitas Negeri Jakarta berhasil meraih penghargaan sebagai perguruan tinggi dengan inovasi terbaik di Indonesia untuk kategori teknologi pendidikan.
                                </p>
                                <button class="text-primary font-semibold hover:text-primary-dark transition-colors duration-300">
                                    Baca Selengkapnya <i class="fas fa-arrow-right ml-1"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="bg-cardColor rounded-card overflow-hidden shadow-card hover:shadow-hover transition-all duration-300">
                        <div class="h-48 bg-gradient-to-br from-accent/80 to-accent flex items-center justify-center">
                            <i class="fas fa-trophy text-3xl text-white opacity-80"></i>
                        </div>
                        <div class="p-6">
                            <div class="flex items-center text-xs text-textSecondary mb-3">
                                <i class="fas fa-calendar mr-2"></i>
                                <span>12 Januari 2025</span>
                            </div>
                            <h3 class="font-bold mb-3">Mahasiswa UNJ Ciptakan Aplikasi Pembelajaran AI</h3>
                            <p class="text-textSecondary text-sm mb-4">
                                Tim mahasiswa Teknik Informatika berhasil mengembangkan aplikasi pembelajaran berbasis kecerdasan buatan...
                            </p>
                            <button class="text-primary font-semibold hover:text-primary-dark transition-colors duration-300 text-sm">
                                Baca Selengkapnya <i class="fas fa-arrow-right ml-1"></i>
                            </button>
                        </div>
                    </div>

                    <div class="bg-cardColor rounded-card overflow-hidden shadow-card hover:shadow-hover transition-all duration-300">
                        <div class="h-48 bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center">
                            <i class="fas fa-leaf text-3xl text-white opacity-80"></i>
                        </div>
                        <div class="p-6">
                            <div class="flex items-center text-xs text-textSecondary mb-3">
                                <i class="fas fa-calendar mr-2"></i>
                                <span>10 Januari 2025</span>
                            </div>
                            <h3 class="font-bold mb-3">Inovasi Ramah Lingkungan untuk Pertanian</h3>
                            <p class="text-textSecondary text-sm mb-4">
                                Dosen Fakultas Pertanian mengembangkan pupuk organik inovatif yang ramah lingkungan...
                            </p>
                            <button class="text-primary font-semibold hover:text-primary-dark transition-colors duration-300 text-sm">
                                Baca Selengkapnya <i class="fas fa-arrow-right ml-1"></i>
                            </button>
                        </div>
                    </div>

                    <div class="bg-cardColor rounded-card overflow-hidden shadow-card hover:shadow-hover transition-all duration-300">
                        <div class="h-48 bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center">
                            <i class="fas fa-microscope text-3xl text-white opacity-80"></i>
                        </div>
                        <div class="p-6">
                            <div class="flex items-center text-xs text-textSecondary mb-3">
                                <i class="fas fa-calendar mr-2"></i>
                                <span>8 Januari 2025</span>
                            </div>
                            <h3 class="font-bold mb-3">Penelitian Breakthrough di Bidang Kesehatan</h3>
                            <p class="text-textSecondary text-sm mb-4">
                                Tim peneliti UNJ menemukan metode baru untuk diagnosis dini penyakit kronis...
                            </p>
                            <button class="text-primary font-semibold hover:text-primary-dark transition-colors duration-300 text-sm">
                                Baca Selengkapnya <i class="fas fa-arrow-right ml-1"></i>
                            </button>
                        </div>
                    </div>
                </div>
                
                <div class="text-center mt-8">
                    <button class="bg-primary hover:bg-primary-dark text-white px-8 py-3 rounded-full font-semibold transition-all duration-300 hover:transform hover:scale-105">
                        Lihat Semua Berita
                    </button>
                </div>
            </section>
        </main>
    </div>

    <div id="productModal" class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4 opacity-0 pointer-events-none transition-opacity duration-300 overflow-y-auto">
        <div class="bg-white w-full max-w-3xl rounded-card overflow-hidden shadow-lg max-h-[90vh] flex flex-col">
            <div class="h-[300px] md:h-[350px] relative bg-primary">
                <img id="modalImg" src="" alt="" class="w-full h-full object-cover">
                <button onclick="closeProductModal()" class="absolute top-4 right-4 w-10 h-10 rounded-full bg-black/30 text-white flex items-center justify-center hover:bg-black/50 transition duration-300">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div id="modalBody" class="p-6 md:p-8 overflow-y-auto -webkit-overflow-scrolling-touch max-h-[calc(90vh-350px)]">
            </div>
        </div>
    </div>
    
    @include('layout.footer')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const searchButton = document.getElementById('searchButton');
            const filterButtons = document.querySelectorAll('.filter-btn');
            const productCards = document.querySelectorAll('.product-card');
            const noResultsMessage = document.getElementById('noResultsMessage');

            let currentFilter = 'all';

            function filterAndSearch() {
                const searchTerm = searchInput.value.trim().toLowerCase();
                let hasResults = false;

                productCards.forEach(card => {
                    const title = card.querySelector('.product-name').textContent.toLowerCase();
                    const innovator = card.querySelector('.innovator-info').textContent.toLowerCase();
                    const description = card.querySelector('.product-description').textContent.toLowerCase();
                    const category = card.dataset.category;

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

            // Event listener untuk tombol filter
            filterButtons.forEach(button => {
                button.addEventListener('click', () => {
                    filterButtons.forEach(btn => btn.classList.remove('active'));
                    button.classList.add('active');
                    currentFilter = button.dataset.filter;
                    filterAndSearch();
                });
            });
            
            // Event listener untuk tombol search
            searchButton.addEventListener('click', filterAndSearch);
            
            // Event listener untuk menekan Enter di input search
            searchInput.addEventListener('keyup', function(event) {
                if (event.key === 'Enter') {
                    filterAndSearch();
                }
            });

            // Optional: Pencarian real-time saat mengetik
            searchInput.addEventListener('input', filterAndSearch);
        });

        // --- Logika Modal (tetap sama) ---
        function openProductModal(productId) {
            const produkData = @json($produkInovasi->keyBy('id'));
            const produk = produkData[productId];
            
            if (!produk) return;
            
            const modal = document.getElementById('productModal');
            const modalImg = document.getElementById('modalImg');
            const modalBody = document.getElementById('modalBody');
            
            if (produk.gambar) {
                modalImg.src = `/storage/${produk.gambar}`;
                modalImg.alt = produk.nama_produk;
                modalImg.style.display = 'block';
            } else {
                modalImg.style.display = 'none';
            }
            
            let patentInfo = '';
            if (produk.nomor_paten) {
                patentInfo = `
                    <div class="flex items-center text-textSecondary text-sm">
                        <i class="fas fa-certificate mr-1.5"></i>
                        <span>No. Paten: ${produk.nomor_paten}</span>
                    </div>
                `;
            }
            
            const content = `
                <span class="inline-flex items-center text-xs font-medium text-primary bg-primary/10 px-2.5 py-1 rounded-full mb-3">
                    <i class="fas fa-user-alt mr-1.5"></i>
                    ${produk.inovator}
                </span>
                <h2 class="text-2xl md:text-3xl font-bold mb-4">${produk.nama_produk}</h2>
                <div class="flex flex-col md:flex-row gap-3 mb-6 pb-4 border-b border-black/10">
                    <div class="flex items-center text-textSecondary text-sm">
                        <i class="fas fa-calendar-alt mr-1.5"></i>
                        <span>Ditambahkan: ${formatDate(produk.created_at)}</span>
                    </div>
                    ${patentInfo}
                </div>
                <div class="leading-7 text-textColor text-base">
                    <h3 class="font-semibold mb-4 text-primary">Deskripsi Produk:</h3>
                    ${produk.deskripsi}
                </div>
            `;
            
            modalBody.innerHTML = content;
            modal.classList.add('opacity-100');
            modal.classList.remove('pointer-events-none');
            document.body.style.overflow = 'hidden';
        }

        function closeProductModal() {
            const modal = document.getElementById('productModal');
            modal.classList.remove('opacity-100');
            modal.classList.add('pointer-events-none');
            document.body.style.overflow = 'auto';
        }

        function formatDate(dateString) {
            const options = { year: 'numeric', month: 'long', day: 'numeric' };
            return new Date(dateString).toLocaleDateDateString('id-ID', options);
        }

        document.getElementById('productModal').addEventListener('click', function(event) {
            if (event.target === this) {
                closeProductModal();
            }
        });

        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeProductModal();
            }
        });

        // --- Script Tambahan (tetap sama) ---
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

        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-fade-in');
                }
            });
        }, observerOptions);

        document.querySelectorAll('section').forEach(section => {
            observer.observe(section);
        });

        const style = document.createElement('style');
        style.textContent = `
            .animate-fade-in {
                animation: fadeInUp 0.6s ease-out forwards;
            }
            @keyframes fadeInUp {
                from { opacity: 0; transform: translateY(30px); }
                to { opacity: 1; transform: translateY(0); }
            }
            .line-clamp-3 {
                overflow: hidden;
                display: -webkit-box;
                -webkit-box-orient: vertical;
                -webkit-line-clamp: 3;
            }
        `;
        document.head.appendChild(style);
    </script>
</body>
</html>