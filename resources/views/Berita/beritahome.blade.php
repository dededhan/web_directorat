<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Berita Terkini</title>
    <link rel="stylesheet" href="{{ asset('berita.css') }}">
    <style>
        .no-results {
            grid-column: 1 / -1;
            text-align: center;
            padding: 2rem;
            background-color: var(--card-color);
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            font-size: 1.1rem;
            color: #666;
        }
    </style>
</head>
<body>
    <!-- Loading indicator -->
    <div class="loading">
        <div class="spinner"></div>
    </div>
    
    <header>
        <div class="container">
            <div class="header-content">
                <a href="#" class="logo">
                    <img src="https://spm.unj.ac.id/wp-content/uploads/2024/08/cropped-Logo-UNJ-PTNBH-RGB_Logo_Motto_Transparan.png" alt="Logo UNJ" class="logo-image">
                    Portal Berita
                </a>
                <nav>
                    <ul>
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li><a href="#">Terbaru</a></li>
                    </ul>
                </nav>
            </div>
        </div>
        <div class="container">
            <div class="search-container">
                <input type="text" class="search-input" placeholder="Cari berita...">
                <button class="search-button">🔍</button>
            </div>
        </div>
        <div class="category-tabs">
            <div class="container" style="display: flex; overflow-x: auto;">
                <a href="#" class="category-tab active">Semua</a>
                <a href="#" class="category-tab">Inovasi</a>
                <a href="#" class="category-tab">Pemeringkatan</a>
            </div>
        </div>
    </header>

    <main class="container">
        <section class="headline">
            <div class="headline-grid">
                <div class="main-headline">
                    <div class="headline-content">
                        <h2 class="headline-title">Pemerintah Umumkan Kebijakan Baru untuk Mendorong Ekonomi Kreatif</h2>
                        <p class="headline-desc">Program ini diharapkan dapat meningkatkan kontribusi ekonomi kreatif hingga 10% terhadap PDB nasional dalam lima tahun ke depan.</p>
                        <div class="news-meta">
                            <span class="news-category">Inovasi</span>
                            <span class="news-date">16 Maret 2025</span>
                        </div>
                    </div>
                </div>
                <div class="side-headlines">
                    <div class="side-headline">
                        <div class="side-img"></div>
                        <div class="side-content">
                            <h3 class="side-title">Startup Lokal Kembangkan AI untuk Solusi Pertanian Presisi</h3>
                            <div class="news-meta">
                                <span class="news-category">Inovasi</span>
                            </div>
                        </div>
                    </div>
                    <div class="side-headline">
                        <div class="side-img"></div>
                        <div class="side-content">
                            <h3 class="side-title">Tim Nasional Berhasil Lolos ke Semifinal Turnamen Internasional</h3>
                            <div class="news-meta">
                                <span class="news-category">Pemeringkatan</span>
                            </div>
                        </div>
                    </div>
                    <div class="side-headline">
                        <div class="side-img"></div>
                        <div class="side-content">
                            <h3 class="side-title">Kementerian Pendidikan Luncurkan Program Beasiswa untuk 10,000 Mahasiswa</h3>
                            <div class="news-meta">
                                <span class="news-category">Pemeringkatan</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section>
            <h2 class="section-title">Berita Terbaru</h2>
            <div class="news-grid">
                @forelse($beritas as $berita)
                    <div class="news-card">
                        <div class="card-img" style="background-image: url('{{ asset('storage/'.$berita->gambar) }}')"></div>
                        <div class="card-content">
                            <h3 class="card-title">{{ $berita->judul }}</h3>
                            <p class="card-excerpt">{{ Str::limit(strip_tags($berita->isi), 150) }}</p>
                            <div class="news-meta">
                                <span class="news-category">{{ ucfirst($berita->kategori) }}</span>
                                <span class="news-date">{{ date('d F Y', strtotime($berita->tanggal)) }}</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="no-results">
                        <p>Belum ada berita tersedia.</p>
                    </div>
                @endforelse
            </div>
        </section>
    </main>

    @include('Berita.beritafooter')

    <script> 
    document.addEventListener('DOMContentLoaded', function() {
    // Get all category tabs
    const categoryTabs = document.querySelectorAll('.category-tab');
    
    // Content database for different categories
    const categoryContent = {
        "Inovasi": {
            main: {
                title: "Startup Lokal Kembangkan Robot Penyelamat untuk Bencana Alam",
                desc: "Tim mahasiswa ITB berhasil menciptakan robot yang dapat menjangkau area-area berbahaya dan mendeteksi korban terjebak setelah bencana alam.",
                category: "Inovasi",
                date: "16 Maret 2025"
            },
            side: [
                {
                    title: "Peneliti Indonesia Temukan Bahan Plastik yang Terurai dalam 3 Bulan",
                    category: "Inovasi"
                },
                {
                    title: "Sistem Deteksi Dini Banjir Berbasis IoT Diuji Coba di Jakarta",
                    category: "Inovasi"
                },
                {
                    title: "Dosen UGM Kembangkan Vaksin Kanker Nasofaring Pertama di ASEAN",
                    category: "Inovasi"
                }
            ],
            news: [
                {
                    title: "Aplikasi Pembelajaran Bahasa Daerah Berbasis AI Diluncurkan",
                    excerpt: "Platform digital ini mampu mengenali dan mengajarkan lebih dari 50 bahasa daerah di Indonesia dengan metode interaktif yang menarik.",
                    category: "Inovasi",
                    date: "16 Maret 2025"
                },
                {
                    title: "Tim Mahasiswa ITS Ciptakan Mobil Bertenaga Surya dengan Efisiensi Tinggi",
                    excerpt: "Mobil bernama 'Surya Nusantara' ini mampu menempuh jarak hingga 1.200 km dengan energi matahari dan memenangkan kompetisi internasional.",
                    category: "Inovasi",
                    date: "15 Maret 2025"
                },
                {
                    title: "Teknologi Konversi Sampah Plastik Menjadi Bahan Bakar Dikembangkan",
                    excerpt: "Inovasi dari peneliti UI ini mampu mengolah sampah plastik menjadi bahan bakar berkualitas tinggi dengan emisi karbon yang minimal.",
                    category: "Inovasi",
                    date: "15 Maret 2025"
                },
                {
                    title: "Bioteknologi Baru Mempercepat Pertumbuhan Terumbu Karang 5x Lipat",
                    excerpt: "Metode inovatif ini dikembangkan oleh LIPI dan telah berhasil diimplementasikan untuk rehabilitasi terumbu karang di Raja Ampat.",
                    category: "Inovasi",
                    date: "14 Maret 2025"
                }
            ]
        },
        "Pemeringkatan": {
            main: {
                title: "UI Masuk Top 100 Universitas Terbaik Asia Versi QS Rankings 2025",
                desc: "Universitas Indonesia mencatatkan prestasi membanggakan dengan naik 15 peringkat dari tahun sebelumnya di peringkat universitas terbaik Asia.",
                category: "Pemeringkatan",
                date: "16 Maret 2025"
            },
            side: [
                {
                    title: "Indonesia Naik ke Peringkat 40 Indeks Inovasi Global",
                    category: "Pemeringkatan"
                },
                {
                    title: "Tiga Kota Indonesia Masuk 50 Kota Terbaik untuk Startup",
                    category: "Pemeringkatan"
                },
                {
                    title: "Jurnal Ilmiah UGM Capai Q1 Scopus untuk Kategori Energi Terbarukan",
                    category: "Pemeringkatan"
                }
            ],
            news: [
                {
                    title: "LIPI Raih Ranking Tertinggi di ASEAN untuk Publikasi Ilmiah Bidang Biodiversitas",
                    excerpt: "Lembaga Ilmu Pengetahuan Indonesia mencatat rekor baru dengan jumlah publikasi dan sitasi tertinggi untuk penelitian keanekaragaman hayati.",
                    category: "Pemeringkatan",
                    date: "16 Maret 2025"
                },
                {
                    title: "Startup Fintech Indonesia Puncaki Daftar 100 Most Promising Companies Asia",
                    excerpt: "PayNusantara menjadi startup Indonesia pertama yang menduduki peringkat teratas dalam daftar perusahaan paling menjanjikan versi Forbes Asia.",
                    category: "Pemeringkatan",
                    date: "15 Maret 2025"
                },
                {
                    title: "Indonesia Naik 12 Peringkat dalam Ease of Doing Business Index 2025",
                    excerpt: "Reformasi birokrasi dan digitalisasi layanan publik berhasil mendongkrak peringkat Indonesia dalam indeks kemudahan berbisnis global.",
                    category: "Pemeringkatan",
                    date: "15 Maret 2025"
                },
                {
                    title: "ITB Masuk 200 Besar Global University Rankings untuk Bidang Teknik",
                    excerpt: "Program studi teknik di Institut Teknologi Bandung mendapat pengakuan internasional dengan masuk peringkat 175 terbaik dunia.",
                    category: "Pemeringkatan",
                    date: "14 Maret 2025"
                }
            ]
        }
    };
    
    // Store original content for "Semua" category
    const originalContent = {
        main: {
            title: document.querySelector('.main-headline .headline-title').textContent,
            desc: document.querySelector('.main-headline .headline-desc').textContent,
            category: document.querySelector('.main-headline .news-category').textContent,
            date: document.querySelector('.main-headline .news-date').textContent
        },
        side: Array.from(document.querySelectorAll('.side-headline')).map(headline => {
            return {
                title: headline.querySelector('.side-title').textContent,
                category: headline.querySelector('.news-category').textContent
            };
        }),
        news: Array.from(document.querySelectorAll('.news-card')).map(card => {
            return {
                title: card.querySelector('.card-title').textContent,
                excerpt: card.querySelector('.card-excerpt').textContent,
                category: card.querySelector('.news-category').textContent,
                date: card.querySelector('.news-date').textContent
            };
        })
    };
    
    // Filter content function - shows/hides existing content based on category
    function filterContent(category) {
        // Get all news elements
        const mainHeadline = document.querySelector('.main-headline');
        const sideHeadlines = document.querySelectorAll('.side-headline');
        const newsCards = document.querySelectorAll('.news-card');
        
        // Filter main headline
        const mainCategory = mainHeadline.querySelector('.news-category').textContent;
        mainHeadline.style.display = (category === 'Semua' || mainCategory === category) ? 'block' : 'none';
        
        // Filter side headlines
        let visibleSideHeadlines = 0;
        sideHeadlines.forEach(headline => {
            const headlineCategory = headline.querySelector('.news-category').textContent;
            const shouldDisplay = (category === 'Semua' || headlineCategory === category);
            headline.style.display = shouldDisplay ? 'flex' : 'none';
            if (shouldDisplay) visibleSideHeadlines++;
        });
        
        // Handle side headlines container visibility
        const sideHeadlinesContainer = document.querySelector('.side-headlines');
        sideHeadlinesContainer.style.display = (visibleSideHeadlines > 0) ? 'flex' : 'none';
        
        // Filter news cards
        let visibleNewsCards = 0;
        newsCards.forEach(card => {
            const cardCategory = card.querySelector('.news-category').textContent;
            const shouldDisplay = (category === 'Semua' || cardCategory === category);
            card.style.display = shouldDisplay ? 'block' : 'none';
            if (shouldDisplay) visibleNewsCards++;
        });
        
        // If no visible news cards, display a message
        const newsGrid = document.querySelector('.news-grid');
        if (visibleNewsCards === 0 && newsGrid) {
            // Clear the grid
            newsGrid.innerHTML = '<p class="no-results">Tidak ada artikel dalam kategori ini.</p>';
        }
    }
    
    // Replace content function - replaces content with category-specific content
    function replaceContent(category) {
        // If Semua is selected, restore original content
        if (category === 'Semua') {
            updateMainHeadline(originalContent.main);
            updateSideHeadlines(originalContent.side);
            updateNewsCards(originalContent.news);
            return;
        }
        
        // Get category content
        const content = categoryContent[category];
        if (!content) return;
        
        // Update content
        updateMainHeadline(content.main);
        updateSideHeadlines(content.side);
        updateNewsCards(content.news);
    }
    
    // Update main headline function
    function updateMainHeadline(data) {
        const mainHeadline = document.querySelector('.main-headline');
        if (!mainHeadline) return;
        
        const title = mainHeadline.querySelector('.headline-title');
        const desc = mainHeadline.querySelector('.headline-desc');
        const category = mainHeadline.querySelector('.news-category');
        const date = mainHeadline.querySelector('.news-date');
        
        title.textContent = data.title;
        desc.textContent = data.desc;
        category.textContent = data.category;
        if (date) date.textContent = data.date;
        
        // Make sure the headline is visible
        mainHeadline.style.display = 'block';
    }
    
    // Update side headlines function
    function updateSideHeadlines(dataArray) {
        const sideHeadlinesContainer = document.querySelector('.side-headlines');
        if (!sideHeadlinesContainer) return;
        
        // Clear existing side headlines
        sideHeadlinesContainer.innerHTML = '';
        
        // Create new side headlines
        dataArray.forEach(item => {
            const html = `
                <div class="side-headline">
                    <div class="side-img"></div>
                    <div class="side-content">
                        <h3 class="side-title">${item.title}</h3>
                        <div class="news-meta">
                            <span class="news-category">${item.category}</span>
                        </div>
                    </div>
                </div>
            `;
            sideHeadlinesContainer.insertAdjacentHTML('beforeend', html);
        });
        
        // Make sure the container is visible
        sideHeadlinesContainer.style.display = 'flex';
    }
    
    // Update news cards function
    function updateNewsCards(dataArray) {
        const newsGrid = document.querySelector('.news-grid');
        if (!newsGrid) return;
        
        // Clear existing news cards
        newsGrid.innerHTML = '';
        
        // If no data, show message
        if (dataArray.length === 0) {
            newsGrid.innerHTML = '<p class="no-results">Tidak ada artikel dalam kategori ini.</p>';
            return;
        }
        
        // Create new news cards
        dataArray.forEach(item => {
            const html = `
                <div class="news-card">
                    <div class="card-img"></div>
                    <div class="card-content">
                        <h3 class="card-title">${item.title}</h3>
                        <p class="card-excerpt">${item.excerpt}</p>
                        <div class="news-meta">
                            <span class="news-category">${item.category}</span>
                            <span class="news-date">${item.date}</span>
                        </div>
                    </div>
                </div>
            `;
            newsGrid.insertAdjacentHTML('beforeend', html);
        });
    }
    
    // Add click event listeners to category tabs
    categoryTabs.forEach(tab => {
        tab.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Remove 'active' class from all tabs
            categoryTabs.forEach(t => t.classList.remove('active'));
            
            // Add 'active' class to the clicked tab
            this.classList.add('active');
            
            // Get the selected category
            const selectedCategory = this.textContent.trim();
            
            // Replace content immediately
            replaceContent(selectedCategory);
            
            // Scroll back to top
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    });
});
</script>
</body>
</html>