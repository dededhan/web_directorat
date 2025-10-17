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
                            200: '#a5d6a7',
                            300: '#81c784',
                            400: '#66bb6a',
                            500: '#0d6d38',
                            600: '#095629',
                            700: '#064520',
                            800: '#043318',
                            900: '#022210',
                        },
                        secondary: {
                            50: '#fef7e6',
                            100: '#fdefc0',
                            200: '#fce699',
                            300: '#fbdd73',
                            400: '#fad556',
                            500: '#f8b739',
                            600: '#f7a322',
                            700: '#f68f0b',
                            800: '#e57d00',
                            900: '#cc6f00',
                        },
                        accent: {
                            blue: '#3b82f6',
                            green: '#10b981',
                            orange: '#f59e0b',
                            red: '#ef4444',
                            purple: '#8b5cf6',
                        }
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.5s ease-in-out',
                        'slide-up': 'slideUp 0.5s ease-out',
                        'scale-in': 'scaleIn 0.3s ease-out',
                        'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' },
                        },
                        slideUp: {
                            '0%': { transform: 'translateY(20px)', opacity: '0' },
                            '100%': { transform: 'translateY(0)', opacity: '1' },
                        },
                        scaleIn: {
                            '0%': { transform: 'scale(0.95)', opacity: '0' },
                            '100%': { transform: 'scale(1)', opacity: '1' },
                        },
                    }
                }
            }
        }
    </script>
    @vite(['resources/js/dokumen/document.js'])
    <style>
        /* Custom scrollbar untuk browser modern */
        ::-webkit-scrollbar {
            width: 10px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        ::-webkit-scrollbar-thumb {
            background: #0d6d38;
            border-radius: 5px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #095629;
        }
    </style>
</head>

<body class="bg-gradient-to-br from-gray-50 via-white to-gray-50 font-sans antialiased min-h-screen flex flex-col">
    @include('layout.navbar_sticky')

    <!-- Hero Section dengan Gradient Modern -->
    <section class="relative bg-gradient-to-br from-primary-600 via-primary-500 to-green-600 text-white overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 left-0 w-96 h-96 bg-white rounded-full mix-blend-overlay filter blur-3xl animate-pulse-slow"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-secondary-500 rounded-full mix-blend-overlay filter blur-3xl animate-pulse-slow" style="animation-delay: 1s;"></div>
        </div>
        
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-20 lg:py-28">
            <div class="text-center space-y-6 animate-fade-in">
                <!-- Icon dengan Animasi -->
                <div class="inline-flex items-center justify-center">
                    <div class="relative">
                        <div class="absolute inset-0 bg-white opacity-20 rounded-full blur-xl animate-pulse"></div>
                        <div class="relative w-20 h-20 sm:w-24 sm:h-24 bg-white bg-opacity-20 rounded-2xl backdrop-blur-sm flex items-center justify-center transform hover:rotate-6 transition-transform duration-300">
                            <i class="fas fa-folder-open text-4xl sm:text-5xl drop-shadow-lg"></i>
                        </div>
                    </div>
                </div>
                
                <!-- Title dengan Typography Modern -->
                <div class="space-y-4">
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight drop-shadow-md">
                        Repositori Dokumen
                    </h1>
                    <p class="text-lg sm:text-xl lg:text-2xl text-green-50 max-w-3xl mx-auto font-light leading-relaxed px-4">
                        Akses dan kelola dokumen resmi Universitas Negeri Jakarta dengan sistem yang modern, aman, dan efisien
                    </p>
                </div>

                <!-- Statistics Cards -->
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 max-w-5xl mx-auto mt-12">
                    <div class="bg-white bg-opacity-10 backdrop-blur-md rounded-2xl p-4 sm:p-6 border border-white border-opacity-20 hover:bg-opacity-20 transition-all duration-300 transform hover:scale-105">
                        <div class="text-3xl sm:text-4xl font-bold mb-2" id="totalDocs">0</div>
                        <div class="text-sm sm:text-base text-green-100 font-medium">Total Dokumen</div>
                    </div>
                    <div class="bg-white bg-opacity-10 backdrop-blur-md rounded-2xl p-4 sm:p-6 border border-white border-opacity-20 hover:bg-opacity-20 transition-all duration-300 transform hover:scale-105">
                        <div class="text-3xl sm:text-4xl font-bold mb-2">
                            <i class="fas fa-file-alt text-2xl sm:text-3xl"></i>
                        </div>
                        <div class="text-sm sm:text-base text-green-100 font-medium">Dokumen Umum</div>
                    </div>
                    <div class="bg-white bg-opacity-10 backdrop-blur-md rounded-2xl p-4 sm:p-6 border border-white border-opacity-20 hover:bg-opacity-20 transition-all duration-300 transform hover:scale-105">
                        <div class="text-3xl sm:text-4xl font-bold mb-2">
                            <i class="fas fa-trophy text-2xl sm:text-3xl"></i>
                        </div>
                        <div class="text-sm sm:text-base text-green-100 font-medium">Pemeringkatan</div>
                    </div>
                    <div class="bg-white bg-opacity-10 backdrop-blur-md rounded-2xl p-4 sm:p-6 border border-white border-opacity-20 hover:bg-opacity-20 transition-all duration-300 transform hover:scale-105">
                        <div class="text-3xl sm:text-4xl font-bold mb-2">
                            <i class="fas fa-lightbulb text-2xl sm:text-3xl"></i>
                        </div>
                        <div class="text-sm sm:text-base text-green-100 font-medium">Inovasi</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Wave Divider -->
        <div class="absolute bottom-0 left-0 w-full overflow-hidden leading-none">
            <svg class="relative block w-full h-12 sm:h-16" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z" class="fill-current text-gray-50"></path>
            </svg>
        </div>
    </section>

    <!-- Main Content -->
    <main class="flex-1 -mt-8 relative z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
            
            <!-- Search Bar dengan Design Modern -->
            <div class="mb-8 sm:mb-12 animate-slide-up">
                <div class="relative max-w-3xl mx-auto">
                    <div class="absolute inset-y-0 left-0 pl-6 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400 text-xl"></i>
                    </div>
                    <input 
                        type="text" 
                        id="searchInput" 
                        placeholder="Ketik untuk mencari dokumen berdasarkan judul..." 
                        oninput="searchDocuments()"
                        class="w-full pl-16 pr-6 py-5 text-base sm:text-lg bg-white border-2 border-gray-200 rounded-2xl shadow-lg focus:outline-none focus:border-primary-500 focus:ring-4 focus:ring-primary-100 transition-all duration-300 hover:shadow-xl hover:border-gray-300 placeholder:text-gray-400"
                    >
                    <div class="absolute inset-y-0 right-0 pr-6 flex items-center">
                        <kbd class="hidden sm:inline-flex items-center px-3 py-1.5 bg-gray-100 border border-gray-300 rounded-lg text-xs font-semibold text-gray-600">
                            <i class="fas fa-keyboard mr-1.5 text-gray-500"></i>
                            Ctrl+K
                        </kbd>
                    </div>
                </div>
            </div>

            <!-- Category Filters dengan Animasi -->
            <div class="mb-10 sm:mb-14 animate-slide-up" style="animation-delay: 0.1s;">
                <div class="flex flex-wrap gap-3 sm:gap-4 justify-center">
                    <button 
                        class="category-btn group relative flex items-center gap-2.5 px-6 sm:px-7 py-3.5 rounded-xl font-semibold text-sm sm:text-base transition-all duration-300 bg-primary-600 text-white shadow-lg hover:shadow-2xl hover:bg-primary-700 transform hover:-translate-y-1 hover:scale-105 active" 
                        data-category="all"
                    >
                        <i class="fas fa-folder text-lg transition-transform group-hover:rotate-12"></i>
                        <span>Semua Dokumen</span>
                        <div class="absolute inset-0 bg-white opacity-0 group-hover:opacity-10 rounded-xl transition-opacity"></div>
                    </button>
                    
                    <button 
                        class="category-btn group relative flex items-center gap-2.5 px-6 sm:px-7 py-3.5 rounded-xl font-semibold text-sm sm:text-base transition-all duration-300 bg-white text-gray-700 shadow-md hover:shadow-xl hover:bg-gradient-to-r hover:from-blue-50 hover:to-blue-100 border-2 border-transparent hover:border-blue-200 transform hover:-translate-y-1" 
                        data-category="umum"
                    >
                        <i class="fas fa-file-alt text-accent-blue text-lg transition-transform group-hover:scale-110"></i>
                        <span class="group-hover:text-accent-blue transition-colors">Umum</span>
                    </button>
                    
                    <button 
                        class="category-btn group relative flex items-center gap-2.5 px-6 sm:px-7 py-3.5 rounded-xl font-semibold text-sm sm:text-base transition-all duration-300 bg-white text-gray-700 shadow-md hover:shadow-xl hover:bg-gradient-to-r hover:from-green-50 hover:to-green-100 border-2 border-transparent hover:border-green-200 transform hover:-translate-y-1" 
                        data-category="pemeringkatan"
                    >
                        <i class="fas fa-trophy text-accent-green text-lg transition-transform group-hover:scale-110"></i>
                        <span class="group-hover:text-accent-green transition-colors">Pemeringkatan</span>
                    </button>
                    
                    <button 
                        class="category-btn group relative flex items-center gap-2.5 px-6 sm:px-7 py-3.5 rounded-xl font-semibold text-sm sm:text-base transition-all duration-300 bg-white text-gray-700 shadow-md hover:shadow-xl hover:bg-gradient-to-r hover:from-orange-50 hover:to-orange-100 border-2 border-transparent hover:border-orange-200 transform hover:-translate-y-1" 
                        data-category="inovasi"
                    >
                        <i class="fas fa-lightbulb text-accent-orange text-lg transition-transform group-hover:scale-110"></i>
                        <span class="group-hover:text-accent-orange transition-colors">Inovasi</span>
                    </button>
                </div>
            </div>

            <!-- Documents Grid dengan Layout Modern -->
            <div id="documentGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 sm:gap-7 min-h-[500px]">
                <!-- Loading State dengan Animasi Modern -->
                <div class="col-span-full flex flex-col items-center justify-center py-24">
                    <div class="relative">
                        <div class="absolute inset-0 rounded-full bg-primary-500 opacity-20 blur-xl animate-pulse"></div>
                        <div class="relative animate-spin rounded-full h-20 w-20 border-4 border-primary-200 border-t-primary-600"></div>
                    </div>
                    <p class="text-gray-600 text-lg font-medium mt-6 animate-pulse">Memuat dokumen...</p>
                    <p class="text-gray-400 text-sm mt-2">Mohon tunggu sebentar</p>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="mt-auto">
        @include('layout.footer')
    </footer>

    <!-- Keyboard Shortcut Handler -->
    <script>
        // Keyboard shortcut untuk search (Ctrl+K)
        document.addEventListener('keydown', function(e) {
            if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                e.preventDefault();
                document.getElementById('searchInput')?.focus();
            }
        });
    </script>
</body>

</html>
