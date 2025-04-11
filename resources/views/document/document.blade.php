<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dokumen</title>
    <link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" type="image/png">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('document.css') }}">        
</head>
<body>
     <!-- Main Navbar -->
     <div class="navbar-wrapper">
        <div class="container main-navbar">
            <a href="#" class="navbar-logo">
                <img src="https://spm.unj.ac.id/wp-content/uploads/2024/08/cropped-Logo-UNJ-PTNBH-RGB_Logo_Motto_Transparan.png" alt="Logo UNJ">
                <div class="navbar-logo-text">
                    <span class="logo-title">DOKUMEN</span>
                    <span class="logo-subtitle">Universitas Negeri Jakarta</span>
                </div>
            </a>
            
            <button class="navbar-toggle" id="navbarToggle">
                <i class="fas fa-bars"></i>
            </button>
            
            <ul class="navbar-menu" id="navbarMenu">
                <li><a href="{{ route('home') }}" class="menu-link">Home</a></li>
                <li><a href="#" class="menu-link active">Dokumen</a></li>
            </ul>
            
            <!-- Navbar right section removed -->
        </div>
    </div>

   <!-- Search Overlay -->
   <div class="search-overlay" id="searchOverlay">
        <button class="close-search" id="closeSearch">&times;</button>
        <div class="search-box">
            <input type="text" class="search-input" placeholder="Search...">
            <button class="search-btn">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </div>
    
    <!-- Content Wrapper -->
    <div class="content-wrapper">
        <!-- Document Repository Section -->
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Repositori Dokumen</h2>
                <p class="section-subtitle">Akses dan unduh dokumen resmi Universitas Negeri Jakarta</p>
            </div>
            
            <div class="document-container">
                <div class="search-bar">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" class="search-input" id="searchInput" placeholder="Search for documents..." oninput="searchDocuments()">
                </div>

                <div class="document-categories">
                    <button class="category-btn" data-type="pdf" onclick="filterDocuments('pdf', this)">
                        <i class="fas fa-file-pdf"></i> PDF Documents
                    </button>
                </div>

                <div id="documentGrid" class="document-grid">
                    <!-- Documents will be dynamically populated here -->
                </div>
            </div>
        </div>
    </div>

    <div class="footer-wrapper">
        @include('document.documentfooter')
    </div>

    <script src="{{ asset('document.js') }}"></script>
</body>
</html>