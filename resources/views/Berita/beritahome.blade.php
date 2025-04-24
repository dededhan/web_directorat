<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $pageTitle ?? 'Berita Terkini' }}</title>
    <link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" type="image/png">
    <link rel="stylesheet" href="{{ asset('berita.css') }}">
    <link rel="stylesheet" href="{{ asset('unj-navbar.css') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- FONT AWESOME - SINGLE VERSION -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('home.css') }}">
    <style>
        /* ===== Root Variables ===== */
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

/* ===== Hero Section with Search ===== */
.hero-section {
    background: #D1E7DD;
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

/* ===== Category Tabs ===== */
.categories-section {
    margin: 2rem 0;
    position: relative;
}

.categories-container {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-wrap: wrap;
    gap: 0.75rem;
}

.category-tab {
    padding: 0.8rem 1.5rem;
    background-color: white;
    color: var(--text-color);
    border-radius: 50px;
    text-decoration: none;
    transition: all var(--transition-speed);
    font-weight: 500;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    display: flex;
    align-items: center;
}

.category-tab:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
    background-color: #f9f9f9;
}

.category-tab.active {
    background: var(--primary-color);
    color: white;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.tab-icon {
    margin-right: 8px;
    font-size: 0.9em;
}

/* ===== Enhanced Headline Banner ===== */
.headline-banner {
    background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
    color: white;
    padding: 2rem;
    margin-bottom: 2rem;
    border-radius: var(--border-radius);
    text-align: center;
    box-shadow: var(--card-shadow);
    position: relative;
    overflow: hidden;
}

.headline-banner::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100"><rect width="100" height="100" fill="none"/><path d="M0,0 L100,100" stroke="rgba(255,255,255,0.05)" stroke-width="2"/></svg>');
    opacity: 0.3;
}

.headline-banner h2 {
    font-size: 2.2rem;
    margin: 0;
    position: relative;
    font-weight: 700;
    letter-spacing: 1px;
}

/* ===== Enhanced News Cards ===== */
.news-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 25px;
    margin: 20px 0;
}

.news-card {
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

.news-card:hover {
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

.news-card:hover .card-img {
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

/* ===== Enhanced Category Indicators ===== */
.card-category {
    display: inline-block;
    font-size: 0.8rem;
    padding: 6px 12px;
    border-radius: 30px;
    margin-bottom: 15px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.card-category.inovasi {
    background-color: rgba(22, 97, 101, 0.1);
    color: var(--primary-color);
}

.card-category.pemeringkatan {
    background-color: rgba(22, 101, 52, 0.1);
    color: #166534;
}
.card-category.umum {
    background-color: rgba(22, 101, 52, 0.1);
    color: #555555;
}

.card-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 0.85rem;
    color: #777;
    margin-top: auto;
    padding-top: 15px;
    border-top: 1px solid rgba(0, 0, 0, 0.05);
}

.card-date {
    color: var(--text-secondary);
    display: flex;
    align-items: center;
}

.card-date::before {
    font-family: "Font Awesome 6 Free";
    content: "\f073";
    font-weight: 900;
    margin-right: 5px;
    font-size: 0.9rem;
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

/* ===== Enhanced No Results Style ===== */
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

/* ===== Enhanced Pagination ===== */
.pagination-container {
    margin: 40px 0;
    display: flex;
    justify-content: center;
}

/* ===== News Popup Styles ===== */
.news-popup-overlay {
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
}

.news-popup-overlay.active {
    display: flex;
    opacity: 1;
}

.news-popup {
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

.news-popup-overlay.active .news-popup {
    transform: scale(1);
}

.popup-header {
    position: relative;
    height: 300px;
}

.popup-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.popup-close {
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

.popup-close:hover {
    background-color: rgba(0, 0, 0, 0.8);
    transform: scale(1.1);
}

.popup-content {
    padding: 30px;
    overflow-y: auto;
    max-height: calc(90vh - 300px);
}

.popup-category {
    font-size: 0.85rem;
    padding: 6px 12px;
    border-radius: 30px;
    display: inline-block;
    margin-bottom: 15px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.popup-category.inovasi {
    background-color: rgba(22, 97, 101, 0.1);
    color: var(--primary-color);
}

.popup-category.pemeringkatan {
    background-color: rgba(22, 101, 52, 0.1);
    color: #166534;
}

.popup-title {
    font-size: 2rem;
    margin: 10px 0 15px;
    color: var(--text-color);
    line-height: 1.3;
    font-weight: 700;
}

.popup-meta {
    display: flex;
    align-items: center;
    margin-bottom: 25px;
    color: var(--text-secondary);
    font-size: 0.95rem;
    padding-bottom: 15px;
    border-bottom: 1px solid rgba(0, 0, 0, 0.1);
}

.popup-date {
    margin-right: 15px;
    display: flex;
    align-items: center;
}

.popup-date::before {
    font-family: "Font Awesome 6 Free";
    content: "\f073";
    font-weight: 900;
    margin-right: 8px;
}

.popup-body {
    line-height: 1.8;
    color: var(--text-color);
    font-size: 1.05rem;
}

.popup-body p {
    margin-bottom: 20px;
}

.popup-body img {
    max-width: 100%;
    height: auto;
    margin: 20px 0;
    border-radius: 8px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

/* Enhanced Loading State */
.popup-loading {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    height: 300px;
}

.popup-spinner {
    width: 50px;
    height: 50px;
    border: 5px solid #f3f3f3;
    border-top: 5px solid var(--primary-color);
    border-radius: 50%;
    animation: spin 1s linear infinite;
    margin-bottom: 20px;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Error message styling */
.error-message {
    text-align: center;
    padding: 40px;
    color: #721c24;
    background-color: #f8d7da;
    border-radius: 8px;
    border: 1px solid #f5c6cb;
}

.error-message h3 {
    margin-bottom: 10px;
    font-size: 1.5rem;
}

/* Loading Indicator */
.loading {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(255, 255, 255, 0.9);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
}

.spinner {
    width: 60px;
    height: 60px;
    border: 6px solid #f3f3f3;
    border-top: 6px solid var(--primary-color);
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

/* Mobile adjustments */
@media (max-width: 992px) {
    .news-grid {
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    }
    
    .hero-title {
        font-size: 2rem;
    }
    
    .hero-subtitle {
        font-size: 1.1rem;
    }
}

@media (max-width: 768px) {
    .popup-header {
        height: 220px;
    }
    
    .popup-title {
        font-size: 1.6rem;
    }
    
    .popup-content {
        padding: 20px;
        max-height: calc(90vh - 220px);
    }
    
    .headline-banner h2 {
        font-size: 1.8rem;
    }
    
    .search-container {
        max-width: 100%;
    }
    
    .hero-title {
        font-size: 1.8rem;
    }
    
    .hero-subtitle {
        font-size: 1rem;
        margin-bottom: 1.5rem;
    }
    
    .hero-section {
        padding: 2rem 0;
    }
}

@media (max-width: 576px) {
    .category-tab {
        padding: 0.6rem 1rem;
        font-size: 0.85rem;
    }
    
    .tab-icon {
        margin-right: 5px;
    }
    
    .search-text {
        display: none;
    }
}
I'll help you solve the layout jittering issue. Let's add some CSS and JavaScript optimizations directly to the existing code.
Add the following CSS to the existing <style> block in the <head> section:
css/* Layout Stability Enhancements */
html {
    scroll-behavior: smooth;
    overflow-y: scroll;
    scrollbar-gutter: stable;
}

body {
    overscroll-behavior-y: contain;
    position: relative;
    min-height: 100vh;
    overflow-x: hidden;
}

/* Prevent content reflow */
img, iframe, .card-img {
    max-width: 100%;
    height: auto;
    aspect-ratio: 16 / 9;
    object-fit: cover;
    transition: height 0.3s ease;
}

/* Smooth transitions for sticky elements */
.navbar {
    will-change: transform, position;
    transition: 
        transform 0.2s ease-in-out, 
        position 0.2s ease-in-out;
    backface-visibility: hidden;
    perspective: 1000px;
}

/* Reduce layout shifts during loading */
.loading-placeholder {
    background-color: #f0f0f0;
    opacity: 0.5;
}
    </style>
</head>
<body>
@include('layout.navbar_sticky')


    <!-- Loading indicator -->
    <div class="loading">
        <div class="spinner"></div>
    </div>
    
    <!-- New Hero Section with Search -->
    <section class="hero-section">
        <div class="container hero-content">
            <h1 class="hero-title">Portal Berita & Informasi UNJ</h1>
            <p class="hero-subtitle">Temukan berita terkini dan informasi seputar Universitas Negeri Jakarta</p>
            
            <div class="search-container">
                <input type="text" class="search-input" placeholder="Cari berita, artikel, atau informasi...">
                <button class="search-button">
                    <i class="fa-solid fa-search"></i>
                    <span class="search-text">Cari</span>
                </button>
            </div>
        </div>
    </section>
    
    <!-- FIXED Category Tabs Section -->
    <section class="categories-section">
        <div class="container categories-container">
            <a href="{{ route('berita.all') }}" class="category-tab {{ !request()->segment(3) ? 'active' : '' }}">
                <i class="fa-solid fa-layer-group tab-icon"></i>
                <span>Semua</span>
            </a>
            <a href="{{ route('berita.kategori', 'inovasi') }}" class="category-tab {{ request()->segment(3) == 'inovasi' ? 'active' : '' }}">
                <i class="fa-solid fa-lightbulb tab-icon"></i>
                <span>Inovasi</span>
            </a>
            <a href="{{ route('berita.kategori', 'pemeringkatan') }}" class="category-tab {{ request()->segment(3) == 'pemeringkatan' ? 'active' : '' }}">
                <i class="fa-solid fa-trophy tab-icon"></i>
                <span>Pemeringkatan</span>
            </a>
        </div>
    </section>

    <main class="container">
        <!-- Category headline banner -->
        

        <section>
            <div class="news-grid">
                @forelse($beritas as $berita)
                    <div class="news-card">
                        <div class="card-img" style="background-image: url('{{ asset('storage/'.$berita->gambar) }}')"></div>
                        <div class="card-content">
                            <span class="card-category {{ strtolower($berita->kategori) }}">{{ strtoupper($berita->kategori) }}</span>
                            <h3 class="card-title">{{ $berita->judul }}</h3>
                            <p class="card-excerpt">{{ Str::limit(strip_tags($berita->isi), 100) }}</p>
                            <div class="card-meta">
                                <span class="card-date">{{ date('d F Y', strtotime($berita->tanggal)) }}</span>
                            </div>
                            {{-- <a href="{{ route('Berita.show', ['slug' => Str::slug($berita->judul)]) }}" class="read-more">Baca Selengkapnya</a> --}}
                            <a href="{{ route('Berita.show', ['slug' => $berita->slug]) }}" class="read-more">Baca Selengkapnya</a>                        </div>
                    </div>
                @empty
                    <div class="no-results">
                        <i class="fa-solid fa-newspaper"></i>
                        <p>Belum ada berita tersedia dalam kategori ini.</p>
                    </div>
                @endforelse
            </div>
            
            <!-- Pagination -->
            <div class="pagination-container">
                {{ $beritas->links() }}
            </div>
        </section>
    </main>
    @include('layout.footer')


    <!-- Add Font Awesome JS for better icon support -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js" integrity="sha512-fD9DI5bZwQxOi7MhYWnnNPlvXdp/2Pj3XSTRrFs5FQa4mizyGLnJcN6tuvUS6LbmgN1ut+XGSABKvjN0H6Aoow==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Hide loading indicator when page loads
        document.querySelector('.loading').style.display = 'none';
    
        // Search functionality
        const searchInput = document.querySelector('.search-input');
        const searchButton = document.querySelector('.search-button');
        
        function performSearch() {
            const searchTerm = searchInput.value.trim().toLowerCase();
            const newsCards = document.querySelectorAll('.news-card');
            let hasResults = false;
            
            newsCards.forEach(card => {
                const title = card.querySelector('.card-title').textContent.toLowerCase();
                const excerpt = card.querySelector('.card-excerpt').textContent.toLowerCase();
                
                if (title.includes(searchTerm) || excerpt.includes(searchTerm)) {
                    card.style.display = 'flex';
                    hasResults = true;
                } else {
                    card.style.display = 'none';
                }
            });
            
            // Show/hide no results message
            const newsGrid = document.querySelector('.news-grid');
            let noResultsElement = document.querySelector('.no-search-results');
            
            if (!hasResults) {
                if (!noResultsElement) {
                    noResultsElement = document.createElement('div');
                    noResultsElement.className = 'no-results no-search-results';
                    noResultsElement.innerHTML = '<i class="fa-solid fa-search"></i><p>Tidak ada hasil yang cocok dengan pencarian Anda.</p>';
                    newsGrid.appendChild(noResultsElement);
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
        
        // News popup functionality
        const popup = document.getElementById('newsPopup');
        const popupClose = document.getElementById('popupClose');
        const popupContent = document.getElementById('popupContent');
        const popupImg = document.getElementById('popupImg');
        const popupLoading = document.getElementById('popupLoading');
        const readMoreButtons = document.querySelectorAll('.read-more');
        
        // Function to open popup with AJAX request
        function openPopup(beritaId) {
            // Show loading spinner
            popupLoading.style.display = 'flex';
            popupContent.style.display = 'none';
            popupImg.style.display = 'none';
            
            // Show popup
            popup.classList.add('active');
            document.body.classList.add('popup-open');
            
            // Get CSRF token for secure requests
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            // Fetch news data
            fetch(`/api/berita/${beritaId}`, {
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                console.log('API Response Status:', response.status);
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                console.log('Berita data received:', data);
                
                // Update popup content
                popupImg.src = `/storage/${data.gambar}`;
                popupImg.alt = data.judul;
                
                let content = `
                    <span class="popup-category ${data.kategori.toLowerCase()}">${data.kategori.toUpperCase()}</span>
                    <h2 class="popup-title">${data.judul}</h2>
                    <div class="popup-meta">
                        <span class="popup-date">${formatDate(data.tanggal)}</span>
                    </div>
                    <div class="popup-body">
                        ${data.isi}
                    </div>
                `;
                
                popupContent.innerHTML = content;
                
                // Hide loading spinner and show content
                popupLoading.style.display = 'none';
                popupContent.style.display = 'block';
                popupImg.style.display = 'block';
            })
            .catch(error => {
                console.error('Error fetching news:', error);
                popupContent.innerHTML = `
                    <div class="error-message">
                        <h3>Terjadi kesalahan</h3>
                        <p>Maaf, konten berita tidak dapat dimuat. Silakan coba lagi nanti.</p>
                        <p>Detail error: ${error.message}</p>
                    </div>
                `;
                popupLoading.style.display = 'none';
                popupContent.style.display = 'block';
            });
        }
        
        // Function to close popup
        function closePopup() {
            popup.classList.remove('active');
            document.body.classList.remove('popup-open');
            // Clear content after transition
            setTimeout(() => {
                popupContent.innerHTML = '';
                popupImg.src = '';
            }, 300);
        }
        
        // Format date helper function
        function formatDate(dateString) {
            const options = { year: 'numeric', month: 'long', day: 'numeric' };
            return new Date(dateString).toLocaleDateString('id-ID', options);
        }
        
        // Add event listeners
        readMoreButtons.forEach(button => {
            button.addEventListener('click', function() {
                const beritaId = this.getAttribute('data-id');
                openPopup(beritaId);
            });
        });
        
        popupClose.addEventListener('click', closePopup);
        
        // Close popup when clicking outside the content
        popup.addEventListener('click', function(event) {
            if (event.target === popup) {
                closePopup();
            }
        });
        
        // Close popup when pressing Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape' && popup.classList.contains('active')) {
                closePopup();
            }
        });
    });
    </script>
</body>
</html>