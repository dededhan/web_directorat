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
    <style>
        /* ===== Root Variables - Same as Berita ===== */
        :root {
            --primary-color: #186569;
            --primary-light: #2a7a7e;
            --primary-dark: #0d4b4f;
            --accent-color: #ffb74d;
            --text-color: #333333;
            --text-secondary: #555555;
            --background-color: #f8f9fa;
            --card-color: #ffffff;
            --card-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            --transition-speed: 0.3s;
            --border-radius: 12px;
        }

        /* ===== Base Styles ===== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: var(--background-color);
            color: var(--text-color);
            line-height: 1.6;
            font-size: 16px;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
        }

        /* ===== Hero Section ===== */
        .hero-section {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            padding: 3rem 0;
            margin-bottom: 2rem;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100"><rect width="100" height="100" fill="none"/><path d="M0,0 L100,100" stroke="rgba(255,255,255,0.05)" stroke-width="2"/></svg>');
            opacity: 0.3;
        }

        .hero-content {
            position: relative;
            text-align: center;
            color: white;
            max-width: 800px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        .hero-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .hero-subtitle {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }

        /* ===== Search Container ===== */
        .search-container {
            display: flex;
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            position: relative;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            border-radius: 50px;
        }

        .search-input {
            flex-grow: 1;
            padding: 1rem 1.5rem;
            border: none;
            border-radius: 50px 0 0 50px;
            outline: none;
            font-size: 1rem;
            background: rgba(255, 255, 255, 0.95);
            transition: all var(--transition-speed);
        }

        .search-input:focus {
            box-shadow: 0 0 0 2px var(--accent-color);
        }

        .search-button {
            background: var(--accent-color);
            color: var(--text-color);
            border: none;
            padding: 0 1.8rem;
            border-radius: 0 50px 50px 0;
            cursor: pointer;
            transition: all var(--transition-speed);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }

        .search-button:hover {
            background: #ffa726;
            transform: translateY(-1px);
        }

        .search-text {
            margin-left: 8px;
        }

        /* ===== Products Grid - Same as News Grid ===== */
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 25px;
            margin: 20px 0;
        }

        .product-card {
            background-color: var(--card-color);
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--card-shadow);
            height: 100%;
            display: flex;
            flex-direction: column;
            transition: transform var(--transition-speed), box-shadow var(--transition-speed);
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 20px rgba(0, 0, 0, 0.1);
        }

        .card-img {
            height: 200px;
            background-size: cover;
            background-position: center;
            position: relative;
            transition: all var(--transition-speed);
        }

        .product-card:hover .card-img {
            height: 210px;
        }

        .card-content {
            padding: 20px;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
            position: relative;
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: 700;
            margin: 0 0 12px;
            color: var(--text-color);
            line-height: 1.4;
        }

        .card-excerpt {
            color: var(--text-secondary);
            font-size: 0.95rem;
            margin-bottom: 20px;
            flex-grow: 1;
            line-height: 1.6;
        }

        /* ===== Product Meta Information ===== */
        .card-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.85rem;
            color: #777;
            margin-top: auto;
            padding-top: 15px;
            border-top: 1px solid rgba(0, 0, 0, 0.05);
            flex-wrap: wrap;
            gap: 10px;
        }

        .meta-item {
            display: flex;
            align-items: center;
            color: var(--text-secondary);
        }

        .meta-item i {
            margin-right: 5px;
            color: var(--primary-color);
            font-size: 0.9rem;
        }

        .innovator-tag {
            display: inline-block;
            background-color: rgba(22, 97, 101, 0.1);
            color: var(--primary-color);
            font-size: 0.8rem;
            padding: 6px 12px;
            border-radius: 30px;
            margin-bottom: 15px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .patent-badge {
            background-color: rgba(255, 183, 77, 0.1);
            color: #e65100;
            font-size: 0.75rem;
            padding: 4px 8px;
            border-radius: 20px;
            font-weight: 600;
            margin-left: auto;
        }

        .read-more {
            display: block;
            background-color: var(--primary-color);
            color: white;
            text-decoration: none;
            text-align: center;
            padding: 10px;
            border-radius: var(--border-radius);
            font-size: 0.95rem;
            font-weight: 600;
            margin-top: 20px;
            transition: all var(--transition-speed);
            cursor: pointer;
            border: none;
            letter-spacing: 0.5px;
        }

        .read-more:hover {
            background-color: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }

        /* ===== No Results Style ===== */
        .no-results {
            grid-column: 1 / -1;
            text-align: center;
            padding: 3rem;
            background-color: var(--card-color);
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
            font-size: 1.1rem;
            color: var(--text-secondary);
            border: 1px dashed rgba(0, 0, 0, 0.1);
        }

        .no-results i {
            font-size: 3rem;
            color: var(--primary-light);
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        /* ===== Modal Styles ===== */
        .product-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.85);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            transition: opacity var(--transition-speed);
            backdrop-filter: blur(5px);
            overflow-y: auto;
        }

        .product-modal.active {
            display: flex;
            opacity: 1;
        }

        .modal-content {
            width: 90%;
            max-width: 900px;
            max-height: 90vh;
            background-color: white;
            border-radius: var(--border-radius);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            transform: scale(0.9);
            transition: transform var(--transition-speed);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
        }

        .product-modal.active .modal-content {
            transform: scale(1);
        }

        .modal-header {
            position: relative;
            height: 300px;
        }

        .modal-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .modal-close {
            position: absolute;
            top: 20px;
            right: 20px;
            width: 40px;
            height: 40px;
            background-color: rgba(0, 0, 0, 0.5);
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
            border: none;
            transition: background-color var(--transition-speed);
            z-index: 10;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        .modal-close:hover {
            background-color: rgba(0, 0, 0, 0.8);
            transform: scale(1.1);
        }

        .modal-body {
            padding: 30px;
            overflow-y: auto;
            max-height: calc(90vh - 300px);
            -webkit-overflow-scrolling: touch;
        }

        .modal-title {
            font-size: 2rem;
            margin: 10px 0 15px;
            color: var(--text-color);
            line-height: 1.3;
            font-weight: 700;
        }

        .modal-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-bottom: 25px;
            color: var(--text-secondary);
            font-size: 0.95rem;
            padding-bottom: 15px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        }

        .modal-description {
            line-height: 1.8;
            color: var(--text-color);
            font-size: 1.05rem;
        }

        .modal-description p {
            margin-bottom: 20px;
        }

        /* Important: Add proper spacing for fixed navbar */
        .content-wrapper {
            padding-top: 7rem;
            overflow-x: hidden;
        }

        @media (max-width: 768px) {
            .content-wrapper {
                padding-top: 6rem;
            }
            
            .products-grid {
                grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            }
            
            .hero-title {
                font-size: 2rem;
            }
            
            .hero-subtitle {
                font-size: 1.1rem;
            }
            
            .modal-header {
                height: 220px;
            }
            
            .modal-title {
                font-size: 1.6rem;
            }
            
            .modal-body {
                padding: 20px;
                max-height: calc(90vh - 220px);
            }
            
            .search-container {
                max-width: 100%;
            }
            
            .hero-section {
                padding: 2rem 0;
            }

            .card-meta {
                flex-direction: column;
                align-items: flex-start;
            }
        }

        @media (max-width: 576px) {
            .search-text {
                display: none;
            }

            .hero-title {
                font-size: 1.8rem;
            }
            
            .hero-subtitle {
                font-size: 1rem;
                margin-bottom: 1.5rem;
            }
        }
    </style>
</head>
<body class="bg-gray-100">
@include('layout.navbar_hilirisasi')
    
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container hero-content">
            <h1 class="hero-title">Produk Inovasi UNJ</h1>
            <p class="hero-subtitle">Temukan berbagai inovasi dan karya terbaik dari civitas akademika Universitas Negeri Jakarta</p>
            
            <div class="search-container">
                <input type="text" class="search-input" placeholder="Cari produk inovasi, inovator, atau kata kunci...">
                <button class="search-button">
                    <i class="fa-solid fa-search"></i>
                    <span class="search-text">Cari</span>
                </button>
            </div>
        </div>
    </section>

    <!-- Main Content with increased spacing -->
    <div class="content-wrapper">
        <main class="container">
            <section>
                <div class="products-grid">
                    @if($produkInovasi->count() > 0)
                        @foreach($produkInovasi as $produk)
                        <div class="product-card">
                            @if($produk->gambar)
                            <div class="card-img" style="background-image: url('{{ asset('storage/' . $produk->gambar) }}')"></div>
                            @else
                            <div class="card-img" style="background: linear-gradient(135deg, var(--primary-color), var(--primary-light)); display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-lightbulb" style="font-size: 3rem; color: white; opacity: 0.7;"></i>
                            </div>
                            @endif
                            
                            <div class="card-content">
                                <span class="innovator-tag">
                                    <i class="fas fa-user-alt"></i>
                                    {{ $produk->inovator }}
                                </span>
                                
                                <h3 class="card-title">{{ $produk->nama_produk }}</h3>
                                
                                <p class="card-excerpt">
                                    {!! Str::limit(strip_tags($produk->deskripsi), 120) !!}
                                </p>
                                
                                <div class="card-meta">
                                    <div class="meta-item">
                                        <i class="fas fa-calendar-alt"></i>
                                        <span>{{ $produk->created_at->format('d M Y') }}</span>
                                    </div>
                                    
                                    @if($produk->nomor_paten)
                                    <div class="patent-badge">
                                        <i class="fas fa-certificate"></i>
                                        Paten
                                    </div>
                                    @endif
                                </div>
                                
                                <button class="read-more" onclick="openProductModal({{ $produk->id }})">
                                    <i class="fas fa-eye"></i> Lihat Detail
                                </button>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="no-results">
                            <i class="fas fa-lightbulb"></i>
                            <p>Belum ada produk inovasi yang tersedia.</p>
                        </div>
                    @endif
                </div>
            </section>
        </main>
    </div>

    <!-- Product Detail Modal -->
    <div class="product-modal" id="productModal">
        <div class="modal-content">
            <div class="modal-header">
                <img class="modal-img" id="modalImg" src="" alt="">
                <button class="modal-close" onclick="closeProductModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body" id="modalBody">
                <!-- Content will be loaded here -->
            </div>
        </div>
    </div>
    
    @include('layout.footer')

    <script>
        // Search functionality
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.querySelector('.search-input');
            const searchButton = document.querySelector('.search-button');
            
            function performSearch() {
                const searchTerm = searchInput.value.trim().toLowerCase();
                const productCards = document.querySelectorAll('.product-card');
                let hasResults = false;
                
                productCards.forEach(card => {
                    const title = card.querySelector('.card-title').textContent.toLowerCase();
                    const excerpt = card.querySelector('.card-excerpt').textContent.toLowerCase();
                    const innovator = card.querySelector('.innovator-tag').textContent.toLowerCase();
                    
                    if (title.includes(searchTerm) || excerpt.includes(searchTerm) || innovator.includes(searchTerm)) {
                        card.style.display = 'flex';
                        hasResults = true;
                    } else {
                        card.style.display = 'none';
                    }
                });
                
                // Show/hide no results message
                const productsGrid = document.querySelector('.products-grid');
                let noResultsElement = document.querySelector('.no-search-results');
                
                if (!hasResults && searchTerm) {
                    if (!noResultsElement) {
                        noResultsElement = document.createElement('div');
                        noResultsElement.className = 'no-results no-search-results';
                        noResultsElement.innerHTML = '<i class="fas fa-search"></i><p>Tidak ada produk inovasi yang cocok dengan pencarian Anda.</p>';
                        productsGrid.appendChild(noResultsElement);
                    }
                } else if (noResultsElement) {
                    noResultsElement.remove();
                }
            }
            
            searchButton.addEventListener('click', performSearch);
            
            searchInput.addEventListener('keyup', function(event) {
                if (event.key === 'Enter') {
                    performSearch();
                }
            });

            // Clear search when input is empty
            searchInput.addEventListener('input', function() {
                if (this.value.trim() === '') {
                    document.querySelectorAll('.product-card').forEach(card => {
                        card.style.display = 'flex';
                    });
                    const noResultsElement = document.querySelector('.no-search-results');
                    if (noResultsElement) {
                        noResultsElement.remove();
                    }
                }
            });
        });

        // Modal functionality
        function openProductModal(productId) {
            const produkData = @json($produkInovasi->keyBy('id'));
            const produk = produkData[productId];
            
            if (!produk) return;
            
            const modal = document.getElementById('productModal');
            const modalImg = document.getElementById('modalImg');
            const modalBody = document.getElementById('modalBody');
            
            // Set image
            if (produk.gambar) {
                modalImg.src = `/storage/${produk.gambar}`;
                modalImg.alt = produk.nama_produk;
                modalImg.style.display = 'block';
            } else {
                modalImg.style.display = 'none';
            }
            
            // Create modal content
            let patentInfo = '';
            if (produk.nomor_paten) {
                patentInfo = `
                    <div class="meta-item">
                        <i class="fas fa-certificate"></i>
                        <span>No. Paten: ${produk.nomor_paten}</span>
                    </div>
                `;
            }
            
            const content = `
                <span class="innovator-tag">
                    <i class="fas fa-user-alt"></i>
                    ${produk.inovator}
                </span>
                <h2 class="modal-title">${produk.nama_produk}</h2>
                <div class="modal-meta">
                    <div class="meta-item">
                        <i class="fas fa-calendar-alt"></i>
                        <span>Ditambahkan: ${formatDate(produk.created_at)}</span>
                    </div>
                    ${patentInfo}
                </div>
                <div class="modal-description">
                    <h3 style="font-weight: 600; margin-bottom: 15px; color: var(--primary-color);">Deskripsi Produk:</h3>
                    ${produk.deskripsi}
                </div>
            `;
            
            modalBody.innerHTML = content;
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeProductModal() {
            const modal = document.getElementById('productModal');
            modal.classList.remove('active');
            document.body.style.overflow = 'auto';
        }

        function formatDate(dateString) {
            const options = { year: 'numeric', month: 'long', day: 'numeric' };
            return new Date(dateString).toLocaleDateString('id-ID', options);
        }

        // Close modal when clicking outside content
        document.getElementById('productModal').addEventListener('click', function(event) {
            if (event.target === this) {
                closeProductModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeProductModal();
            }
        });
    </script>
</body>
</html>