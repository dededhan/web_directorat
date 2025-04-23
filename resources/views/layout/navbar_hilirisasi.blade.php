<style>
    /* Clean dropdown styling */
    .dropdown-menu {
        background-color: white;
        border-radius: 4px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        position: absolute;
        min-width: 200px;
        z-index: 100;
        padding: 8px 0;
        margin-top: 5px;
    }
    
    .dropdown-menu li {
        display: block;
        width: 100%;
    }
    
    .dropdown-menu a, 
    .dropdown-menu button {
        display: flex;
        justify-content: space-between;
        align-items: center;
        color: #333;
        padding: 10px 15px;
        text-decoration: none;
        font-weight: normal;
        white-space: nowrap;
        border: none;
        background: none;
        width: 100%;
        text-align: left;
        cursor: pointer;
    }
    
    .dropdown-menu a:hover, 
    .dropdown-menu button:hover {
        background-color: rgba(0, 0, 0, 0.05);
    }
    
    .nested-menu {
        position: absolute;
        top: 0;
        left: 100%;
        margin-top: -8px;
    }
    
    /* For active menu items */
    .menu-active {
        background-color: rgba(0, 0, 0, 0.05);
    }
    
    /* Mobile sidebar improvements */
    #mobile-sidebar {
        scrollbar-width: thin;
        scrollbar-color: rgba(255, 255, 255, 0.3) rgba(0, 0, 0, 0.1);
    }
    
    #mobile-sidebar::-webkit-scrollbar {
        width: 5px;
    }
    
    #mobile-sidebar::-webkit-scrollbar-track {
        background: rgba(0, 0, 0, 0.1);
    }
    
    #mobile-sidebar::-webkit-scrollbar-thumb {
        background-color: rgba(255, 255, 255, 0.3);
        border-radius: 10px;
    }
    
    /* Smooth transition for dropdown menus */
    .dropdown-menu, .nested-menu {
        transition: opacity 0.2s ease-in-out;
    }
    
    /* Improve mobile navbar appearance */
    @media (max-width: 768px) {
        #mobile-navbar.solid-bg {
            background-color: #186862 !important;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
    }
</style>

@include('layout.loginpopup')

<!-- Desktop Navbar with Click-Based Dropdown -->
<nav class="navbar hidden md:block sticky top-0 z-50 bg-[#277177] shadow-md">
    <div class="container mx-auto flex justify-between items-center py-4 px-6">
        <div class="flex items-center space-x-4">
            <a href="{{ route('home') }}" class="flex items-center">
                <img alt="University logo" class="h-12 w-12"
                    src="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" />
                <h1 class="text-white text-2xl font-bold ml-3">Subdirektorat Inovasi dan Hilirisasi</h1>
            </a>
        </div>
        <ul class="flex space-x-6">
            <li><a href="{{ route('home') }}" class="text-white hover:text-yellow-400">Beranda</a></li>

            <li class="relative">
                <a href="#" class="text-white hover:text-yellow-400 primary-dropdown-toggle" data-dropdown="tentang-dropdown">
                    Tentang
                </a>
                <ul id="tentang-dropdown" class="dropdown-menu primary-dropdown hidden">
                    <li><a href="{{ route('pimpinan.pimpinan') }}">Pimpinan Direktorat</a></li>
                    <li><a href="{{ route('strukturorganisasi') }}">Struktur Organisasi</a></li>
                    <li><a href="{{ route('tupoksi.tupoksi') }}">Tugas Pokok dan Fungsi</a></li>
                    <li><a href="{{ route('subdirektorat-inovasi.sejarah.sejarah') }}">Profil</a></li>
                </ul>
            </li>

            <!-- Program Dropdown with Click-Based Behavior -->
            <li class="relative">
                <a href="#" class="text-white hover:text-yellow-400 primary-dropdown-toggle" data-dropdown="program-dropdown">
                    Program
                </a>
                <ul id="program-dropdown" class="dropdown-menu primary-dropdown hidden">
                    <li><a href="{{ route('sdgscenter') }}">SDGs Center</a></li>
                    <li><a href="#">Inkubator Bisnis dan Pendidikan</a></li>
                    <li><a href="#">Ekosistem Inovasi UNJ</a></li>
                    <li><a href="#">Innovator Award</a></li>
                </ul>
            </li>
            
            <!-- Layanan Dropdown -->
            <li class="relative">
                <a href="#" class="text-white hover:text-yellow-400 primary-dropdown-toggle" data-dropdown="layanan-dropdown">
                    Layanan
                </a>
                <ul id="layanan-dropdown" class="dropdown-menu primary-dropdown hidden">
                    <li><a href="#">Pengujian Katsinov</a></li>
                    <li><a href="#">Pendaftaran Inkubator Bisnis</a></li>
                    <li><a href="#">Pengujian/Sertifikasi Produk Inovasi</a></li>
                    <li><a href="#">Join Mitra Inovasi UNJ</a></li>
                </ul>
            </li>

            <li><a href="{{ route('Berita.beritahome') }}" class="text-white hover:text-yellow-400">Berita</a></li>

            <!-- Inovasi UNJ Dropdown -->
            <li class="relative">
                <a href="#" class="text-white hover:text-yellow-400 primary-dropdown-toggle" data-dropdown="inovasi-dropdown">
                    Inovasi UNJ
                </a>
                <ul id="inovasi-dropdown" class="dropdown-menu primary-dropdown hidden">
                    <li><a href="{{ route('riset.unj') }}">Riset UNJ</a></li>
                    <li><a href="{{ route('subdirektorat-inovasi.riset_unj.produk_inovasi.produkinovasi') }}">Produk Inovasi UNJ</a></li>
                </ul>
            </li>

            <li><a href="{{ route('document.document') }}" class="text-white hover:text-yellow-400">Dokumen</a></li>

            <li><a href="https://sso.unj.ac.id/login" class="text-white hover:text-yellow-400">SSO</a></li>
            <li><a class="login text-white" href="#" data-bs-toggle="modal" data-bs-target="#loginModal">Masuk</a></li>
        </ul>
    </div>
</nav>

<!-- Mobile Navigation Bar (Android) -->
<nav class="navbar bg-transparent md:hidden fixed top-0 w-full z-20 transition-colors duration-300" id="mobile-navbar">
    <div class="relative">
        <!-- Content -->
        <div class="flex justify-between items-center py-4 px-4">
            <!-- Logo and University Name -->
            <div class="flex items-center">
                <img alt="University logo" class="h-10 w-10" src="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" />
                <h1 class="text-white text-xl font-bold ml-2">UNJ</h1>
            </div>

            <!-- Hamburger Menu Button -->
            <button id="mobile-menu-toggle" class="text-white focus:outline-none">
                <i id="menu-icon" class="fas fa-bars text-2xl"></i>
            </button>
        </div>
    </div>
</nav>

<!-- Mobile Sidebar - Enhanced with Improved Nested Menus -->
<div id="mobile-sidebar" class="fixed top-0 right-0 w-64 h-full bg-[#186862] z-40 transform translate-x-full md:translate-x-full transition-transform duration-300 ease-in-out shadow-lg overflow-y-auto">
    <!-- Sidebar Header -->
    <div class="flex justify-between items-center p-4 border-b border-[#125a54]">
        <div class="flex items-center">
            <img alt="University logo" class="h-8 w-8" src="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" />
            <h1 class="text-white text-xl font-bold ml-2">UNJ</h1>
        </div>
        <button id="close-sidebar" class="text-white p-2 hover:bg-[#125a54] rounded-full">
            <i class="fas fa-times text-xl"></i>
        </button>
    </div>

    <!-- Sidebar Menu -->
    <div class="py-2">
        <ul class="space-y-0">
            <li>
                <a href="{{ route('home') }}" class="block text-white py-3 px-6 text-lg hover:bg-[#125a54]">
                    Beranda
                </a>
            </li>

            <li>
                <div class="sidebar-dropdown">
                    <button class="flex justify-between items-center w-full text-white py-3 px-6 text-lg hover:bg-[#125a54]">
                        Tentang
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <ul class="hidden bg-[#135a54]">
                        <li>
                            <a href="{{ route('pimpinan.pimpinan') }}" class="block text-white py-3 px-6 hover:bg-[#0e4c46]">
                                Pimpinan Direktorat
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('strukturorganisasi') }}" class="block text-white py-3 px-6 hover:bg-[#0e4c46]">
                                Struktur Organisasi
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('tupoksi.tupoksi') }}" class="block text-white py-3 px-6 hover:bg-[#0e4c46]">
                                Tugas Pokok dan Fungsi
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('subdirektorat-inovasi.sejarah.sejarah') }}" class="block text-white py-3 px-6 hover:bg-[#0e4c46]">
                                Profil
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- Program Dropdown for Mobile -->
            <li>
                <div class="sidebar-dropdown">
                    <button class="flex justify-between items-center w-full text-white py-3 px-6 text-lg hover:bg-[#125a54]">
                        Program
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <ul class="hidden bg-[#135a54]">
                        <li>
                            <a href="{{ route('sdgscenter') }}" class="block text-white py-3 px-6 hover:bg-[#0e4c46]">
                                SDGs Center
                            </a>
                        </li>
                        <li>
                            <a href="#" class="block text-white py-3 px-6 hover:bg-[#0e4c46]">
                                Inkubator Bisnis dan Pendidikan
                            </a>
                        </li>
                        <li>
                            <a href="#" class="block text-white py-3 px-6 hover:bg-[#0e4c46]">
                                Ekosistem Inovasi UNJ
                            </a>
                        </li>
                        <li>
                            <a href="#" class="block text-white py-3 px-6 hover:bg-[#0e4c46]">
                                Innovator Award
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            
            <!-- Layanan Dropdown for Mobile -->
            <li>
                <div class="sidebar-dropdown">
                    <button class="flex justify-between items-center w-full text-white py-3 px-6 text-lg hover:bg-[#125a54]">
                        Layanan
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <ul class="hidden bg-[#135a54]">
                        <li>
                            <a href="#" class="block text-white py-3 px-6 hover:bg-[#0e4c46]">
                                Pengujian Katsinov
                            </a>
                        </li>
                        <li>
                            <a href="#" class="block text-white py-3 px-6 hover:bg-[#0e4c46]">
                                Pendaftaran Inkubator Bisnis
                            </a>
                        </li>
                        <li>
                            <a href="#" class="block text-white py-3 px-6 hover:bg-[#0e4c46]">
                                Pengujian/Sertifikasi Produk Inovasi
                            </a>
                        </li>
                        <li>
                            <a href="#" class="block text-white py-3 px-6 hover:bg-[#0e4c46]">
                                Join Mitra Inovasi UNJ
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            
            <li>
                <a href="{{ route('Berita.beritahome') }}" class="block text-white py-3 px-6 text-lg hover:bg-[#125a54]">
                    Berita
                </a>
            </li>
            
            <!-- Inovasi UNJ Dropdown for Mobile -->
            <li>
                <div class="sidebar-dropdown">
                    <button class="flex justify-between items-center w-full text-white py-3 px-6 text-lg hover:bg-[#125a54]">
                        Inovasi UNJ
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <ul class="hidden bg-[#135a54]">
                        <li>
                            <a href="{{ route('riset.unj') }}" class="block text-white py-3 px-6 hover:bg-[#0e4c46]">
                                Riset UNJ
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('subdirektorat-inovasi.riset_unj.produk_inovasi.produkinovasi') }}" class="block text-white py-3 px-6 hover:bg-[#0e4c46]">
                                Produk Inovasi UNJ
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            
            <li>
                <a href="{{ route('document.document') }}" class="block text-white py-3 px-6 text-lg hover:bg-[#125a54]">
                    Dokumen
                </a>
            </li>
            
            <li>
                <a href="https://sso.unj.ac.id/login" class="block text-white py-3 px-6 text-lg hover:bg-[#125a54]">
                    SSO
                </a>
            </li>
            
            <li class="px-6 my-6">
                <a href="#" class="block text-center bg-white text-[#186862] py-2 rounded-md font-medium hover:bg-gray-100" data-bs-toggle="modal" data-bs-target="#loginModal">
                    Masuk
                </a>
            </li>
        </ul>
    </div>
</div>

<!-- Overlay for sidebar - Only on mobile -->
<div id="sidebar-overlay" class="fixed inset-0 bg-black opacity-0 md:hidden pointer-events-none transition-opacity duration-300 ease-in-out z-30"></div>

<!-- JavaScript for mobile sidebar and click-based dropdowns -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Mobile sidebar functionality
        const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
        const menuIcon = document.getElementById('menu-icon');
        const mobileSidebar = document.getElementById('mobile-sidebar');
        const sidebarOverlay = document.getElementById('sidebar-overlay');
        const mobileNavbar = document.getElementById('mobile-navbar');
        const dropdownButtons = document.querySelectorAll('.sidebar-dropdown button');
        
        // Function to handle scroll effects
        function handleScroll() {
            if (window.scrollY > 10) {
                mobileNavbar.classList.remove('bg-transparent');
                mobileNavbar.classList.add('bg-[#186862]', 'solid-bg');
            } else {
                mobileNavbar.classList.remove('bg-[#186862]', 'solid-bg');
                mobileNavbar.classList.add('bg-transparent');
            }
        }

        // Add scroll event listener
        window.addEventListener('scroll', handleScroll);

        // Set initial state for mobile devices
        function initMobileNav() {
            if (window.innerWidth < 768) {
                hideSidebar();
                handleScroll();
            }
        }

        // Function to show sidebar
        function showSidebar() {
            mobileSidebar.classList.remove('translate-x-full');
            sidebarOverlay.classList.remove('opacity-0', 'pointer-events-none');
            sidebarOverlay.classList.add('opacity-50', 'pointer-events-auto');
            menuIcon.classList.remove('fa-bars');
            menuIcon.classList.add('fa-times');
        }

        // Function to hide sidebar
        function hideSidebar() {
            mobileSidebar.classList.add('translate-x-full');
            sidebarOverlay.classList.add('opacity-0', 'pointer-events-none');
            sidebarOverlay.classList.remove('opacity-50', 'pointer-events-auto');
            menuIcon.classList.remove('fa-times');
            menuIcon.classList.add('fa-bars');
        }

        // Toggle sidebar visibility
        mobileMenuToggle.addEventListener('click', function() {
            if (mobileSidebar.classList.contains('translate-x-full')) {
                showSidebar();
            } else {
                hideSidebar();
            }
        });

        // Close sidebar when X button is clicked
        document.getElementById('close-sidebar').addEventListener('click', hideSidebar);

        // Close sidebar when clicking overlay
        sidebarOverlay.addEventListener('click', hideSidebar);

        // Toggle mobile dropdowns
        dropdownButtons.forEach(button => {
            button.addEventListener('click', function() {
                const dropdownMenu = this.nextElementSibling;
                const icon = this.querySelector('i');
                
                // Check if this dropdown is currently hidden
                const isClosed = dropdownMenu.classList.contains('hidden');
                
                // Close all dropdowns first
                dropdownButtons.forEach(otherButton => {
                    const otherMenu = otherButton.nextElementSibling;
                    const otherIcon = otherButton.querySelector('i');
                    
                    otherMenu.classList.add('hidden');
                    otherIcon.classList.remove('fa-chevron-up');
                    otherIcon.classList.add('fa-chevron-down');
                });
                
                // Then open this dropdown if it was closed
                if (isClosed) {
                    dropdownMenu.classList.remove('hidden');
                    icon.classList.remove('fa-chevron-down');
                    icon.classList.add('fa-chevron-up');
                }
            });
        });

        // DESKTOP CLICK-BASED DROPDOWN FUNCTIONALITY
        // Handle primary dropdown toggle
        const primaryDropdowns = document.querySelectorAll('.primary-dropdown-toggle');
        primaryDropdowns.forEach(toggle => {
            toggle.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                const targetId = this.getAttribute('data-dropdown');
                const targetDropdown = document.getElementById(targetId);
                
                // Check if this dropdown is currently hidden
                const isClosed = targetDropdown.classList.contains('hidden');
                
                // Close all other primary dropdowns first
                document.querySelectorAll('.primary-dropdown').forEach(dropdown => {
                    dropdown.classList.add('hidden');
                });
                
                // Then open this dropdown if it was closed
                if (isClosed) {
                    targetDropdown.classList.remove('hidden');
                    
                    // Add active class to the toggle
                    primaryDropdowns.forEach(t => {
                        t.classList.remove('text-yellow-400');
                    });
                    this.classList.add('text-yellow-400');
                } else {
                    // Remove active class if closing
                    this.classList.remove('text-yellow-400');
                }
            });
        });

        // Close desktop dropdowns when clicking elsewhere on the page
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.dropdown-menu') && !e.target.classList.contains('primary-dropdown-toggle')) {
                document.querySelectorAll('.primary-dropdown').forEach(dropdown => {
                    dropdown.classList.add('hidden');
                });
                
                // Remove active classes from all toggles
                primaryDropdowns.forEach(toggle => {
                    toggle.classList.remove('text-yellow-400');
                });
            }
        });

        // Initialize mobile navigation
        initMobileNav();

        // Handle window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 768) {
                hideSidebar();
            } else {
                handleScroll();
            }
        });
        
        // Run handleScroll on initial load
        handleScroll();
    });
</script>