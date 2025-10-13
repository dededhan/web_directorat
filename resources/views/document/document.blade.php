<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dokumen - Universitas Negeri Jakarta</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" type="image/png">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#e8f5e9',
                            100: '#c8e6c9',
                            500: '#0d6d38',
                            600: '#095629',
                            700: '#064520',
                        },
                        secondary: {
                            500: '#f8b739',
                        }
                    }
                }
            }
        }
    </script>
    @vite(['resources/js/dokumen/document.js'])
</head>

<body class="bg-gray-50 font-sans antialiased min-h-screen flex flex-col">
    @include('layout.navbar_sticky')

    <!-- Mobile Menu Toggle -->
    <button class="fixed bottom-6 right-6 z-50 lg:hidden bg-primary-500 text-white p-4 rounded-full shadow-lg hover:bg-primary-600 transition-all duration-300 hover:scale-110" id="navbarToggle">
        <i class="fas fa-bars text-xl"></i>
    </button>

    <!-- Search Overlay -->
    <div class="fixed inset-0 bg-black bg-opacity-80 hidden items-center justify-center z-50 backdrop-blur-sm transition-all duration-300" id="searchOverlay">
        <button class="absolute top-8 right-8 text-white text-4xl hover:text-gray-300 transition-colors" id="closeSearch">&times;</button>
        <div class="w-11/12 max-w-2xl px-4">
            <div class="relative">
                <input type="text" class="w-full px-6 py-5 text-lg rounded-2xl shadow-2xl focus:outline-none focus:ring-4 focus:ring-primary-500 transition-all" placeholder="Cari dokumen...">
                <button class="absolute right-4 top-1/2 -translate-y-1/2 text-primary-500 text-2xl hover:text-primary-600 transition-colors">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Hero Section -->
    <div class="bg-gradient-to-br from-primary-500 via-primary-600 to-primary-700 text-white py-16 sm:py-20 lg:py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center space-y-4 sm:space-y-6">
                <div class="inline-flex items-center justify-center w-16 h-16 sm:w-20 sm:h-20 bg-white bg-opacity-20 rounded-full backdrop-blur-sm mb-4">
                    <i class="fas fa-folder-open text-3xl sm:text-4xl"></i>
                </div>
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold tracking-tight">
                    Repositori Dokumen
                </h1>
                <p class="text-base sm:text-lg lg:text-xl text-green-50 max-w-2xl mx-auto px-4">
                    Akses dan unduh dokumen resmi Universitas Negeri Jakarta dengan mudah dan cepat
                </p>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main class="flex-1 py-8 sm:py-12 lg:py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Search Bar -->
            <div class="mb-8 sm:mb-10">
                <div class="relative max-w-2xl mx-auto">
                    <i class="fas fa-search absolute left-5 top-1/2 -translate-y-1/2 text-gray-400 text-lg"></i>
                    <input 
                        type="text" 
                        id="searchInput" 
                        placeholder="Cari dokumen berdasarkan judul..." 
                        oninput="searchDocuments()"
                        class="w-full pl-14 pr-6 py-4 text-base border-2 border-gray-200 rounded-xl shadow-sm focus:outline-none focus:border-primary-500 focus:ring-4 focus:ring-primary-500 focus:ring-opacity-20 transition-all duration-300 hover:border-gray-300"
                    >
                </div>
            </div>

            <!-- Category Filters -->
            <div class="mb-8 sm:mb-12">
                <div class="flex flex-wrap gap-3 sm:gap-4 justify-center">
                    <button class="category-btn group flex items-center gap-2 px-5 sm:px-6 py-3 rounded-xl font-semibold text-sm sm:text-base transition-all duration-300 bg-primary-500 text-white shadow-lg hover:shadow-xl transform hover:-translate-y-0.5" data-category="all">
                        <i class="fas fa-folder text-base sm:text-lg"></i>
                        <span>Semua Dokumen</span>
                    </button>
                    <button class="category-btn group flex items-center gap-2 px-5 sm:px-6 py-3 rounded-xl font-semibold text-sm sm:text-base transition-all duration-300 bg-white text-gray-700 shadow-md hover:shadow-lg hover:bg-gray-50 transform hover:-translate-y-0.5" data-category="umum">
                        <i class="fas fa-file-alt text-blue-500 text-base sm:text-lg"></i>
                        <span>Umum</span>
                    </button>
                    <button class="category-btn group flex items-center gap-2 px-5 sm:px-6 py-3 rounded-xl font-semibold text-sm sm:text-base transition-all duration-300 bg-white text-gray-700 shadow-md hover:shadow-lg hover:bg-gray-50 transform hover:-translate-y-0.5" data-category="pemeringkatan">
                        <i class="fas fa-trophy text-green-500 text-base sm:text-lg"></i>
                        <span>Pemeringkatan</span>
                    </button>
                    <button class="category-btn group flex items-center gap-2 px-5 sm:px-6 py-3 rounded-xl font-semibold text-sm sm:text-base transition-all duration-300 bg-white text-gray-700 shadow-md hover:shadow-lg hover:bg-gray-50 transform hover:-translate-y-0.5" data-category="inovasi">
                        <i class="fas fa-lightbulb text-orange-500 text-base sm:text-lg"></i>
                        <span>Inovasi</span>
                    </button>
                </div>
            </div>

            <!-- Documents Grid -->
            <div id="documentGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8 min-h-[400px]">
                <!-- Loading State -->
                <div class="col-span-full flex flex-col items-center justify-center py-20">
                    <div class="animate-spin rounded-full h-16 w-16 border-4 border-primary-500 border-t-transparent mb-4"></div>
                    <p class="text-gray-500 text-lg">Memuat dokumen...</p>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <div class="mt-auto">
        @include('layout.footer')
    </div>

    <style>
        /* Custom styles for category buttons active state */
        .category-btn.active {
            @apply bg-primary-500 text-white shadow-xl scale-105;
        }
        
        .category-btn.active i {
            @apply text-white;
        }

        /* Smooth transitions for grid updates */
        #documentGrid {
            transition: opacity 0.3s ease-in-out;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 10px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #0d6d38;
            border-radius: 5px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #095629;
        }
    </style>
</body>

</html>
