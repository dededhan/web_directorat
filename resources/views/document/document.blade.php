<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dokumen</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" type="image/png">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
    <style>
        body,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        p,
        button,
        input,
        div {
            font-family: Arial, sans-serif !important;
        }
    </style>

    @vite(['resources/css/dokumen/document.css', 'resources/css/home.css', 'resources/js/dokumen/document.js'])
    <link href="https://fonts.googleapis.com/css2?family=Arial&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    @include('layout.navbar_sticky')

    <button class="navbar-toggle" id="navbarToggle">
        <i class="fas fa-bars"></i>
    </button>
    <div class="search-overlay" id="searchOverlay">
        <button class="close-search" id="closeSearch">&times;</button>
        <div class="search-box">
            <input type="text" class="search-input" placeholder="Search...">
            <button class="search-btn">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </div>

    <div class="content-wrapper">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Repositori Dokumen</h2>
                <p class="section-subtitle">Akses dan unduh dokumen resmi Universitas Negeri Jakarta</p>
            </div>

            <div class="document-container">
                <div class="search-bar">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" class="search-input" id="searchInput" placeholder="Search for documents..."
                        oninput="searchDocuments()">
                </div>

                <div class="document-categories grid grid-cols-2 gap-3 sm:flex sm:flex-wrap sm:gap-4">
                    <button class="category-btn active w-full sm:w-auto" data-category="all">
                        <i class="fas fa-folder"></i> Semua Dokumen
                    </button>
                    <button class="category-btn w-full sm:w-auto" data-category="umum">
                        <i class="fas fa-file-pdf"></i> Umum
                    </button>
                    <button class="category-btn w-full sm:w-auto" data-category="pemeringkatan">
                        <i class="fas fa-file-pdf"></i> Pemeringkatan
                    </button>
                    <button class="category-btn w-full sm:w-auto" data-category="inovasi">
                        <i class="fas fa-file-pdf"></i> Inovasi
                    </button>
                </div>

                <div id="documentGrid" class="document-grid">
                    </div>
            </div>
        </div>
    </div>

    <div class="footer-wrapper">
        @include('layout.footer')
    </div>


</body>

</html>
