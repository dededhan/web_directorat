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
                        <li><a href="#">Beranda</a></li>
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
                <a href="#" class="category-tab">Berita</a>
                <a href="#" class="category-tab">Feature</a>
                <a href="#" class="category-tab">Akademik</a>
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
                            <span class="news-category">Feature</span>
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
                                <span class="news-category">Feature</span>
                            </div>
                        </div>
                    </div>
                    <div class="side-headline">
                        <div class="side-img"></div>
                        <div class="side-content">
                            <h3 class="side-title">Tim Nasional Berhasil Lolos ke Semifinal Turnamen Internasional</h3>
                            <div class="news-meta">
                                <span class="news-category">Berita</span>
                            </div>
                        </div>
                    </div>
                    <div class="side-headline">
                        <div class="side-img"></div>
                        <div class="side-content">
                            <h3 class="side-title">Kementerian Pendidikan Luncurkan Program Beasiswa untuk 10,000 Mahasiswa</h3>
                            <div class="news-meta">
                                <span class="news-category">Akademik</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section>
            <h2 class="section-title">Berita Terbaru</h2>
            <div class="news-grid">
                <div class="news-card">
                    <div class="card-img"></div>
                    <div class="card-content">
                        <h3 class="card-title">Peneliti Temukan Manfaat Baru Kunyit untuk Kesehatan Jantung</h3>
                        <p class="card-excerpt">Studi terbaru menunjukkan bahwa kurkumin dalam kunyit dapat membantu mengurangi peradangan dan meningkatkan fungsi pembuluh darah.</p>
                        <div class="news-meta">
                            <span class="news-category">Feature</span>
                            <span class="news-date">16 Maret 2025</span>
                        </div>
                    </div>
                </div>
                <div class="news-card">
                    <div class="card-img"></div>
                    <div class="card-content">
                        <h3 class="card-title">Festival Film Internasional Digelar di Jakarta Bulan Depan</h3>
                        <p class="card-excerpt">Lebih dari 100 film dari 30 negara akan diputar dalam festival bergengsi yang akan berlangsung selama satu minggu.</p>
                        <div class="news-meta">
                            <span class="news-category">Berita</span>
                            <span class="news-date">16 Maret 2025</span>
                        </div>
                    </div>
                </div>
                <div class="news-card">
                    <div class="card-img"></div>
                    <div class="card-content">
                        <h3 class="card-title">Pemerintah Daerah Resmikan Taman Kota Ramah Lingkungan</h3>
                        <p class="card-excerpt">Taman seluas 5 hektar ini dilengkapi dengan panel surya, sistem pengolahan air hujan, dan berbagai fasilitas ramah lingkungan lainnya.</p>
                        <div class="news-meta">
                            <span class="news-category">Akademik</span>
                            <span class="news-date">15 Maret 2025</span>
                        </div>
                    </div>
                </div>
                <div class="news-card">
                    <div class="card-img"></div>
                    <div class="card-content">
                        <h3 class="card-title">Bank Sentral Pertahankan Suku Bunga Acuan</h3>
                        <p class="card-excerpt">Keputusan ini diambil setelah melihat stabilitas inflasi dan pertumbuhan ekonomi yang terjaga dalam tiga bulan terakhir.</p>
                        <div class="news-meta">
                            <span class="news-category">Berita</span>
                            <span class="news-date">15 Maret 2025</span>
                        </div>
                    </div>
                </div>
                <div class="news-card">
                    <div class="card-img"></div>
                    <div class="card-content">
                        <h3 class="card-title">Peluncuran Ponsel Pintar Terbaru dengan Fitur Kamera 200MP</h3>
                        <p class="card-excerpt">Perusahaan teknologi terkemuka mengklaim ponsel ini memiliki kemampuan fotografi terbaik di kelasnya dengan dukungan AI.</p>
                        <div class="news-meta">
                            <span class="news-category">Feature</span>
                            <span class="news-date">14 Maret 2025</span>
                        </div>
                    </div>
                </div>
                <div class="news-card">
                    <div class="card-img"></div>
                    <div class="card-content">
                        <h3 class="card-title">Menteri Luar Negeri Kunjungi Tiga Negara Asia Tenggara</h3>
                        <p class="card-excerpt">Kunjungan diplomatik ini bertujuan untuk memperkuat kerja sama bilateral dalam bidang ekonomi dan keamanan.</p>
                        <div class="news-meta">
                            <span class="news-category">Akademik</span>
                            <span class="news-date">14 Maret 2025</span>
                        </div>
                    </div>
                </div>
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
        "Berita": {
            main: {
                title: "Presiden Resmikan Proyek Infrastruktur Senilai 50 Triliun Rupiah",
                desc: "Paket proyek infrastruktur ini mencakup jalan tol, pelabuhan, dan bandara di lima provinsi yang diharapkan mempercepat pertumbuhan ekonomi daerah.",
                category: "Berita",
                date: "16 Maret 2025"
            },
            side: [
                {
                    title: "Kasus Covid-19 Menurun 20% dalam Sebulan Terakhir",
                    category: "Berita"
                },
                {
                    title: "Pemerintah Perketat Pengawasan Impor Bahan Pangan",
                    category: "Berita"
                },
                {
                    title: "Partai Politik Mulai Persiapkan Diri Menjelang Pemilu 2026",
                    category: "Berita"
                }
            ],
            news: [
                {
                    title: "Menteri Keuangan: Inflasi Terkendali di Bawah 3%",
                    excerpt: "Data BPS menunjukkan inflasi tahunan berada pada level 2.8%, lebih rendah dari perkiraan yang membuat pemerintah optimis pertumbuhan ekonomi mencapai target.",
                    category: "Berita",
                    date: "16 Maret 2025"
                },
                {
                    title: "Badan Meteorologi Ingatkan Cuaca Ekstrem di Beberapa Wilayah",
                    excerpt: "Peringatan dini dikeluarkan untuk wilayah pesisir barat Sumatra dan selatan Jawa terkait potensi cuaca ekstrem dalam tiga hari ke depan.",
                    category: "Berita",
                    date: "15 Maret 2025"
                },
                {
                    title: "Polisi Ungkap Sindikat Penipuan Online Lintas Negara",
                    excerpt: "Operasi gabungan berhasil menangkap 12 tersangka yang telah menipu ribuan korban dengan total kerugian mencapai ratusan miliar rupiah.",
                    category: "Berita",
                    date: "15 Maret 2025"
                },
                {
                    title: "ASEAN Sepakati Kerjasama Bidang Keamanan Siber",
                    excerpt: "Para pemimpin negara ASEAN menandatangani kesepakatan untuk memperkuat kerja sama dalam menghadapi ancaman keamanan siber yang semakin meningkat.",
                    category: "Berita",
                    date: "14 Maret 2025"
                }
            ]
        },
        "Feature": {
            main: {
                title: "Buku dan Film: Seni Adaptasi Karya Sastra ke Layar Lebar",
                desc: "Mengulas fenomena adaptasi buku ke film dan bagaimana sutradara menafsirkan karya sastra menjadi bahasa visual yang menarik bagi penonton.",
                category: "Feature",
                date: "16 Maret 2025"
            },
            side: [
                {
                    title: "Menjelajahi Wisata Kuliner Tersembunyi di Sudut-sudut Jakarta",
                    category: "Feature"
                },
                {
                    title: "Tren Fashion Berkelanjutan: Ketika Mode Bertemu Kesadaran Lingkungan",
                    category: "Feature"
                },
                {
                    title: "Seni Kaligrafi Modern: Perpaduan Tradisi dan Inovasi",
                    category: "Feature"
                }
            ],
            news: [
                {
                    title: "Taman Bacaan Masyarakat: Oase Literasi di Tengah Himpitan Digital",
                    excerpt: "Menelusuri peran taman bacaan masyarakat yang masih bertahan dan menjadi pusat kegiatan literasi di berbagai daerah.",
                    category: "Feature",
                    date: "16 Maret 2025"
                },
                {
                    title: "Generasi Sandwich: Tantangan Merawat Orang Tua dan Membesarkan Anak Sekaligus",
                    excerpt: "Kisah para individu yang berada dalam dilema merawat orang tua lanjut usia sekaligus membesarkan anak-anak mereka sendiri.",
                    category: "Feature",
                    date: "15 Maret 2025"
                },
                {
                    title: "Seni Menyeduh Kopi: Dari Ritual Pagi Hingga Profesi Barista",
                    excerpt: "Mengupas tuntas perkembangan budaya kopi dari kebiasaan sederhana menjadi tren gaya hidup dan profesi yang dihormati.",
                    category: "Feature",
                    date: "15 Maret 2025"
                },
                {
                    title: "Tiny House Movement: Gaya Hidup Minimalis di Rumah Mini",
                    excerpt: "Mengenal gerakan hidup sederhana dengan tinggal di rumah berukuran kecil yang kian populer di kalangan urban.",
                    category: "Feature",
                    date: "14 Maret 2025"
                }
            ]
        },
        "Akademik": {
            main: {
                title: "Universitas Indonesia Raih Peringkat Tertinggi dalam QS World University Rankings 2025",
                desc: "Pencapaian ini menandai kemajuan signifikan pendidikan tinggi Indonesia di kancah global dengan peningkatan kualitas penelitian dan pengajaran.",
                category: "Akademik",
                date: "16 Maret 2025"
            },
            side: [
                {
                    title: "Program Doktor Saintek Hasilkan Inovasi Baru dalam Pengolahan Limbah Plastik",
                    category: "Akademik"
                },
                {
                    title: "Mahasiswa Teknik Sipil Ciptakan Beton Ramah Lingkungan dari Limbah Pertanian",
                    category: "Akademik"
                },
                {
                    title: "Fakultas Kedokteran Luncurkan Penelitian Vaksin Kanker Pertama di Indonesia",
                    category: "Akademik"
                }
            ],
            news: [
                {
                    title: "Dosen Muda Raih Penghargaan Internasional untuk Penelitian Energi Terbarukan",
                    excerpt: "Dr. Rina Wijaya berhasil mengembangkan metode baru konversi energi matahari yang lebih efisien dan terjangkau untuk masyarakat pedesaan.",
                    category: "Akademik",
                    date: "16 Maret 2025"
                },
                {
                    title: "Kolaborasi Riset Antar Perguruan Tinggi Hasilkan Terobosan di Bidang Kecerdasan Buatan",
                    excerpt: "Kerja sama lima universitas negeri berhasil mengembangkan sistem AI yang dapat memprediksi bencana alam dengan tingkat akurasi tinggi.",
                    category: "Akademik",
                    date: "15 Maret 2025"
                },
                {
                    title: "Fakultas Hukum Gelar Konferensi Internasional Tentang Hak Cipta di Era Digital",
                    excerpt: "Acara yang dihadiri pakar hukum dari 15 negara ini membahas tantangan perlindungan hak cipta dalam perkembangan teknologi terkini.",
                    category: "Akademik",
                    date: "15 Maret 2025"
                },
                {
                    title: "Perpustakaan Kampus Digitalisasi Koleksi Naskah Kuno Nusantara",
                    excerpt: "Sebanyak 5.000 manuskrip langka berhasil didigitalisasi dan dapat diakses secara online oleh peneliti dari seluruh dunia.",
                    category: "Akademik",
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
    
    // Functions removed as requested
    
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