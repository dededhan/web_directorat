<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $pageTitle ?? 'Berita Terkini' }}</title>
    <link rel="stylesheet" href="{{ asset('berita.css') }}">
    <link rel="stylesheet" href="{{ asset('unj-navbar.css') }}">
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
        
        /* Simple and clean cards matching your screenshot */
        .news-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
            margin: 20px 0;
        }
        
        .news-card {
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            height: 100%;
            display: flex;
            flex-direction: column;
            transition: transform 0.2s;
        }
        
        .news-card:hover {
            transform: translateY(-5px);
        }
        
        .card-img {
            height: 180px;
            background-size: cover;
            background-position: center;
        }
        
        .card-content {
            padding: 15px;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }
        
        .card-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin: 0 0 10px;
            color: #333;
        }
        
        .card-excerpt {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 15px;
            flex-grow: 1;
        }
        
        .card-category {
            display: inline-block;
            font-size: 0.75rem;
            padding: 4px 10px;
            border-radius: 15px;
            margin-bottom: 10px;
        }
        
        .card-category.inovasi {
            background-color: #e8f4f4;
            color: var(--primary-color);
        }
        
        .card-category.pemeringkatan {
            background-color: #f0f7ee;
            color: #166534;
        }
        
        .card-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.8rem;
            color: #777;
            margin-top: auto;
            padding-top: 10px;
        }
        
        .card-date {
            color: #777;
        }
        
        .read-more {
            display: block;
            background-color: #f5f5f5;
            color: var(--primary-color);
            text-decoration: none;
            text-align: center;
            padding: 8px;
            border-radius: 4px;
            font-size: 0.9rem;
            font-weight: 500;
            margin-top: 15px;
            transition: background-color 0.2s;
            cursor: pointer;
            border: none;
        }
        
        .read-more:hover {
            background-color: #e0e0e0;
        }
        
        /* Headline banner */
        .headline-banner {
            background-color: var(--primary-color);
            color: white;
            padding: 1.5rem 0;
            margin-bottom: 1rem;
            border-radius: 8px;
            text-align: center;
        }
        
        .headline-banner h2 {
            font-size: 1.8rem;
            margin: 0;
        }
        
        /* Pagination styling */
        .pagination-container {
            margin: 30px 0;
            display: flex;
            justify-content: center;
        }
        
        /* News detail popup styles */
        .news-popup-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.75);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s, visibility 0.3s;
        }
        
        .news-popup-overlay.active {
            opacity: 1;
            visibility: visible;
        }
        
        .news-popup {
            width: 90%;
            max-width: 800px;
            max-height: 90vh;
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            transform: scale(0.9);
            transition: transform 0.3s;
        }
        
        .news-popup-overlay.active .news-popup {
            transform: scale(1);
        }
        
        .popup-header {
            position: relative;
            height: 250px;
        }
        
        .popup-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .popup-close {
            position: absolute;
            top: 15px;
            right: 15px;
            width: 35px;
            height: 35px;
            background-color: rgba(0, 0, 0, 0.5);
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            font-size: 1.2rem;
            cursor: pointer;
            border: none;
            transition: background-color 0.2s;
            z-index: 10;
        }
        
        .popup-close:hover {
            background-color: rgba(0, 0, 0, 0.8);
        }
        
        .popup-content {
            padding: 25px;
            overflow-y: auto;
            max-height: calc(90vh - 250px);
        }
        
        .popup-category {
            font-size: 0.8rem;
            padding: 5px 10px;
            border-radius: 15px;
            display: inline-block;
            margin-bottom: 10px;
        }
        
        .popup-category.inovasi {
            background-color: #e8f4f4;
            color: var(--primary-color);
        }
        
        .popup-category.pemeringkatan {
            background-color: #f0f7ee;
            color: #166534;
        }
        
        .popup-title {
            font-size: 1.8rem;
            margin: 10px 0 15px;
            color: #333;
            line-height: 1.3;
        }
        
        .popup-meta {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            color: #777;
            font-size: 0.9rem;
        }
        
        .popup-date {
            margin-right: 15px;
        }
        
        .popup-body {
            line-height: 1.7;
            color: #444;
            font-size: 1rem;
        }
        
        .popup-body p {
            margin-bottom: 15px;
        }
        
        .popup-body img {
            max-width: 100%;
            height: auto;
            margin: 15px 0;
            border-radius: 5px;
        }
        
        /* Loading state */
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
            margin-bottom: 15px;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        /* Disable body scroll when popup is open */
        body.popup-open {
            overflow: hidden;
        }
        
        /* Error message styling */
        .error-message {
            text-align: center;
            padding: 30px;
            color: #721c24;
            background-color: #f8d7da;
            border-radius: 5px;
        }
        
        /* Mobile adjustments */
        @media (max-width: 768px) {
            .popup-header {
                height: 180px;
            }
            
            .popup-title {
                font-size: 1.5rem;
            }
            
            .popup-content {
                max-height: calc(90vh - 180px);
            }
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
                <a href="{{ route('home') }}" class="logo">
                    <img src="https://spm.unj.ac.id/wp-content/uploads/2024/08/cropped-Logo-UNJ-PTNBH-RGB_Logo_Motto_Transparan.png" alt="Logo UNJ" class="logo-image">
                    Portal Berita
                </a>
                <nav>
                    <ul>
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li><a href="{{ route('berita.all') }}">Berita</a></li>
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
        
        <!-- Category tabs using existing CSS style -->
        <div class="category-tabs">
            <div class="container" style="display: flex; overflow-x: auto;">
                <a href="{{ route('berita.all') }}" class="category-tab {{ !request()->segment(3) ? 'active' : '' }}">Semua</a>
                <a href="{{ route('berita.kategori', 'inovasi') }}" class="category-tab {{ request()->segment(3) == 'inovasi' ? 'active' : '' }}">Inovasi</a>
                <a href="{{ route('berita.kategori', 'pemeringkatan') }}" class="category-tab {{ request()->segment(3) == 'pemeringkatan' ? 'active' : '' }}">Pemeringkatan</a>
            </div>
        </div>
    </header>

    <main class="container">
        <!-- Category headline banner -->
        <div class="headline-banner">
            <h2>{{ $pageTitle ?? 'Berita' }}</h2>
        </div>

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
                            <button class="read-more" data-id="{{ $berita->id }}">Baca Selengkapnya</button>
                        </div>
                    </div>
                @empty
                    <div class="no-results">
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

    <!-- News Detail Popup -->
    <div class="news-popup-overlay" id="newsPopup">
        <div class="news-popup">
            <div class="popup-loading" id="popupLoading">
                <div class="popup-spinner"></div>
                <p>Memuat konten...</p>
            </div>
            <div class="popup-header">
                <img src="" alt="Gambar berita" class="popup-img" id="popupImg">
                <button class="popup-close" id="popupClose">&times;</button>
            </div>
            <div class="popup-content" id="popupContent">
                <!-- Content will be loaded dynamically -->
            </div>
        </div>
    </div>

    @include('Berita.beritafooter')

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
                    noResultsElement.innerHTML = '<p>Tidak ada hasil yang cocok dengan pencarian Anda.</p>';
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
        
        // Check if we have a scrollable category tabs
        const categoryTabs = document.querySelector('.category-tabs .container');
        const activeTab = document.querySelector('.category-tab.active');
        
        if (activeTab && categoryTabs.scrollWidth > categoryTabs.clientWidth) {
            // Scroll to the active tab
            activeTab.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
        }
        
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