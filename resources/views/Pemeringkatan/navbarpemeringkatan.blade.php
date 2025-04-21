<!-- navbar.blade.php with fully click-based dropdown menus -->

<!-- Social Media Bar (Original, unchanged for desktop) -->
<div class="social-media-bar py-2 hidden md:flex">
    <div class="container mx-auto px-6 flex justify-start space-x-4">
        <a href="#" class="hover:text-yellow-500">
            <i class="fab fa-facebook-f"></i>
        </a>
        <a href="#" class="hover:text-yellow-500">
            <i class="fab fa-twitter"></i>
        </a>
        <a href="#" class="hover:text-yellow-500">
            <i class="fab fa-instagram"></i>
        </a>
        <a href="#" class="hover:text-yellow-500">
            <i class="fab fa-youtube"></i>
        </a>
    </div>
</div>

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
</style>

@include('loginpopup')

<!-- Desktop Navbar with Click-Based Dropdown -->
<nav class="navbar hidden md:block">
    <div class="container mx-auto flex justify-between items-center py-4 px-6">
        <div class="flex items-center space-x-4">
            <a href="{{ route('home') }}">
                <img alt="University logo" class="h-12 w-12"
                    src="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" />
            </a>
            <h1 class="text-white text-2xl font-bold">Subdirektorat Pemeringkatan dan Sistem Informasi</h1>
        </div>
        <ul class="flex space-x-6">
            <li><a href="{{ route('home') }}" class="text-white hover:text-yellow-400">Beranda</a></li>

            <li class="relative">
                <a href="#" class="text-white hover:text-yellow-400 primary-dropdown-toggle" data-dropdown="tentang-dropdown">Tentang</a>
                <ul id="tentang-dropdown" class="dropdown-menu primary-dropdown hidden">
                    <li><a href="{{ route('pimpinan.pimpinan') }}">Pimpinan Direktorat</a></li>
                    <li><a href="{{ route('strukturorganisasipemeringkatan') }}">Struktur Organisasi</a></li>
                    <li><a href="{{ route('tupoksipemeringkatan') }}">Tugas Pokok dan Fungsi</a></li>
                    <li><a href="{{ route('Pemeringkatan.sejarah.sejarah') }}">Profil</a></li>
                </ul>
            </li>

            <!-- Program Dropdown with Click-Based Behavior -->
            <li class="relative">
                <a href="#" class="text-white hover:text-yellow-400 primary-dropdown-toggle" data-dropdown="program-dropdown">Program</a>
                <ul id="program-dropdown" class="dropdown-menu primary-dropdown hidden">
                    <li><a href="#">Global Engagement</a></li>
                    <li><a href="#">Lecturer Expose</a></li>
                    <li><a href="#">International Faculty Staff</a></li>
                    <li><a href="#">International Student Mobility</a></li>
                    
                    <li class="relative">
                        <a href="#" class="flex justify-between items-center secondary-dropdown-toggle" data-dropdown="sustainability-dropdown">
                            Sustainability
                            <i class="fas fa-chevron-right ml-2"></i>
                        </a>
                        <ul id="sustainability-dropdown" class="dropdown-menu nested-menu secondary-dropdown hidden">
                            <li><a href="#">Kegiatan Sustainability</a></li>
                            <li><a href="#">Mata Kuliah Sustainability</a></li>
                            
                            <li class="relative">
                                <a href="#" class="flex justify-between items-center tertiary-dropdown-toggle" data-dropdown="program-sustainability-dropdown">
                                    Program Sustainability UNJ
                                    <i class="fas fa-chevron-right ml-2"></i>
                                </a>
                                <ul id="program-sustainability-dropdown" class="dropdown-menu nested-menu tertiary-dropdown hidden">
                                    <li><a href="#">Tagihan Listrik</a></li>
                                    <li><a href="#">BBM</a></li>
                                    <li><a href="#">Sarpras Ramah Lingkungan</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    
                    <li class="relative">
                        <a href="#" class="flex justify-between items-center secondary-dropdown-toggle" data-dropdown="data-responden-dropdown">
                            Data Responden
                            <i class="fas fa-chevron-right ml-2"></i>
                        </a>
                        <ul id="data-responden-dropdown" class="dropdown-menu nested-menu secondary-dropdown hidden">
                            <li><a href="#">Academic</a></li>
                            <li><a href="#">Employee</a></li>
                        </ul>
                    </li>
                </ul>
            </li>

            <li class="relative">
                <a href="{{ route('Pemeringkatan.ranking_unj.rankingunj') }}" class="text-white hover:text-yellow-400">Ranking UNJ</a>
            </li>

            <li class="relative">
                <a href="{{ route('document.document') }}" class="text-white hover:text-yellow-400">Dokumen</a>
            </li>

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

<!-- Mobile Sidebar -->
<div id="mobile-sidebar" class="fixed top-0 right-0 w-64 h-full bg-[#186862] z-40 transform md:translate-x-full transition-transform duration-300 ease-in-out shadow-lg overflow-y-auto">
    <!-- Sidebar Header -->
    <div class="flex justify-between items-center p-4">
        <div class="flex items-center">
            <img alt="University logo" class="h-8 w-8" src="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" />
            <h1 class="text-white text-xl font-bold ml-2">UNJ</h1>
        </div>
        <button id="close-sidebar" class="text-white">
            <i class="fas fa-times text-xl"></i>
        </button>
    </div>

    <!-- Sidebar Menu -->
    <div class="py-4">
        <ul class="space-y-0">
            <li>
                <a href="#" class="block text-white py-3 px-6 text-lg hover:bg-[#125a54]">
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
                            <a href="{{ route('Pemeringkatan.sejarah.sejarah') }}" class="block text-white py-3 px-6 hover:bg-[#0e4c46]">
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
                            <a href="#" class="block text-white py-3 px-6 hover:bg-[#0e4c46]">
                                Global Engagement
                            </a>
                        </li>
                        <li>
                            <a href="#" class="block text-white py-3 px-6 hover:bg-[#0e4c46]">
                                Lecturer Expose
                            </a>
                        </li>
                        <li>
                            <a href="#" class="block text-white py-3 px-6 hover:bg-[#0e4c46]">
                                International Faculty Staff
                            </a>
                        </li>
                        <li>
                            <a href="#" class="block text-white py-3 px-6 hover:bg-[#0e4c46]">
                                International Student Mobility
                            </a>
                        </li>
                        
                        <!-- Sustainability with nested dropdown -->
                        <li>
                            <div class="nested-sidebar-dropdown">
                                <button class="flex justify-between items-center w-full text-white py-3 px-6 hover:bg-[#0e4c46]">
                                    Sustainability
                                    <i class="fas fa-chevron-right"></i>
                                </button>
                                <ul class="hidden bg-[#0d4540]">
                                    <li>
                                        <a href="#" class="block text-white py-3 px-8 hover:bg-[#0a3c38]">
                                            Kegiatan Sustainability
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="block text-white py-3 px-8 hover:bg-[#0a3c38]">
                                            Mata Kuliah Sustainability
                                        </a>
                                    </li>
                                    
                                    <!-- Program Sustainability with deeper nesting -->
                                    <li>
                                        <div class="nested-nested-sidebar-dropdown">
                                            <button class="flex justify-between items-center w-full text-white py-3 px-8 hover:bg-[#0a3c38]">
                                                Program Sustainability UNJ
                                                <i class="fas fa-chevron-right"></i>
                                            </button>
                                            <ul class="hidden bg-[#083633]">
                                                <li>
                                                    <a href="#" class="block text-white py-3 px-10 hover:bg-[#062f2c]">
                                                        Tagihan Listrik
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#" class="block text-white py-3 px-10 hover:bg-[#062f2c]">
                                                        BBM
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#" class="block text-white py-3 px-10 hover:bg-[#062f2c]">
                                                        Sarpras Ramah Lingkungan
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        
                        <!-- Data Responden with nested dropdown -->
                        <li>
                            <div class="nested-sidebar-dropdown">
                                <button class="flex justify-between items-center w-full text-white py-3 px-6 hover:bg-[#0e4c46]">
                                    Data Responden
                                    <i class="fas fa-chevron-right"></i>
                                </button>
                                <ul class="hidden bg-[#0d4540]">
                                    <li>
                                        <a href="#" class="block text-white py-3 px-8 hover:bg-[#0a3c38]">
                                            Academic
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="block text-white py-3 px-8 hover:bg-[#0a3c38]">
                                            Employee
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </li>

            <li>
                <div class="sidebar-dropdown">
                    <button class="flex justify-between items-center w-full text-white py-3 px-6 text-lg hover:bg-[#125a54]">
                        Sistem Pemeringkatan
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <ul class="hidden bg-[#135a54]">
                        <li>
                            <a href="{{ route('pemeringkatan.klaster') }}" class="block text-white py-3 px-6 hover:bg-[#0e4c46]">
                                IKU
                            </a>
                        </li>
                        <li>
                            <a href="#" class="block text-white py-3 px-6 hover:bg-[#0e4c46]">
                                UI Green Metric
                            </a>
                        </li>
                        <li>
                            <a href="#" class="block text-white py-3 px-6 hover:bg-[#0e4c46]">
                                Webometric
                            </a>
                        </li>
                        <li>
                            <a href="#" class="block text-white py-3 px-6 hover:bg-[#0e4c46]">
                                QS World University Ranking
                            </a>
                        </li>
                        <li>
                            <a href="#" class="block text-white py-3 px-6 hover:bg-[#0e4c46]">
                                Times Higher Education
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li>
                <a href="https://sso.unj.ac.id/login" class="block text-white py-3 px-6 text-lg hover:bg-[#125a54]">
                    SSO
                </a>
            </li>

            <li class="px-6 my-6">
                <a href="#" class="block text-center bg-white text-[#186862] py-2 rounded-sm font-medium w-20" data-bs-toggle="modal" data-bs-target="#loginModal">
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
        const nestedDropdownButtons = document.querySelectorAll('.nested-sidebar-dropdown button');
        const nestedNestedDropdownButtons = document.querySelectorAll('.nested-nested-sidebar-dropdown button');

        // Function to handle scroll effects
        function handleScroll() {
            if (window.scrollY > 10) {
                mobileNavbar.classList.remove('bg-transparent');
                mobileNavbar.classList.add('bg-[#186862]');
            } else {
                mobileNavbar.classList.remove('bg-[#186862]');
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
            sidebarOverlay.classList.add('opacity-50');
            menuIcon.classList.remove('fa-bars');
            menuIcon.classList.add('fa-times');
        }

        // Function to hide sidebar
        function hideSidebar() {
            mobileSidebar.classList.add('translate-x-full');
            sidebarOverlay.classList.add('opacity-0', 'pointer-events-none');
            sidebarOverlay.classList.remove('opacity-50');
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
                
                if (dropdownMenu.classList.contains('hidden')) {
                    dropdownMenu.classList.remove('hidden');
                    icon.classList.remove('fa-chevron-down');
                    icon.classList.add('fa-chevron-up');
                } else {
                    dropdownMenu.classList.add('hidden');
                    icon.classList.remove('fa-chevron-up');
                    icon.classList.add('fa-chevron-down');
                }
            });
        });
        
        // Toggle nested mobile dropdowns
        nestedDropdownButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.stopPropagation();
                const dropdownMenu = this.nextElementSibling;
                const icon = this.querySelector('i');
                
                if (dropdownMenu.classList.contains('hidden')) {
                    dropdownMenu.classList.remove('hidden');
                    icon.classList.remove('fa-chevron-right');
                    icon.classList.add('fa-chevron-down');
                } else {
                    dropdownMenu.classList.add('hidden');
                    icon.classList.remove('fa-chevron-down');
                    icon.classList.add('fa-chevron-right');
                }
            });
        });
        
        // Toggle deeper nested mobile dropdowns
        nestedNestedDropdownButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.stopPropagation();
                const dropdownMenu = this.nextElementSibling;
                const icon = this.querySelector('i');
                
                if (dropdownMenu.classList.contains('hidden')) {
                    dropdownMenu.classList.remove('hidden');
                    icon.classList.remove('fa-chevron-right');
                    icon.classList.add('fa-chevron-down');
                } else {
                    dropdownMenu.classList.add('hidden');
                    icon.classList.remove('fa-chevron-down');
                    icon.classList.add('fa-chevron-right');
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
                
                // Close all other primary dropdowns first
                document.querySelectorAll('.primary-dropdown').forEach(dropdown => {
                    if (dropdown.id !== targetId) {
                        dropdown.classList.add('hidden');
                    }
                });
                
                // Toggle this dropdown
                targetDropdown.classList.toggle('hidden');
            });
        });
        
        // Handle secondary dropdown toggle (hover for desktop)
        const secondaryDropdownToggles = document.querySelectorAll('.secondary-dropdown-toggle');
        secondaryDropdownToggles.forEach(toggle => {
            toggle.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                const targetId = this.getAttribute('data-dropdown');
                const targetDropdown = document.getElementById(targetId);
                
                // Close any open sibling secondary dropdowns
                const siblingButtons = Array.from(this.closest('ul').querySelectorAll('.secondary-dropdown-toggle'));
                siblingButtons.forEach(button => {
                    if (button !== this) {
                        const siblingId = button.getAttribute('data-dropdown');
                        const siblingDropdown = document.getElementById(siblingId);
                        if (siblingDropdown) {
                            siblingDropdown.classList.add('hidden');
                        }
                    }
                });
                
                // Toggle this dropdown
                targetDropdown.classList.toggle('hidden');
            });
        });
        
        // Handle tertiary dropdown toggle (hover for desktop)
        const tertiaryDropdownToggles = document.querySelectorAll('.tertiary-dropdown-toggle');
        tertiaryDropdownToggles.forEach(toggle => {
            toggle.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                const targetId = this.getAttribute('data-dropdown');
                const targetDropdown = document.getElementById(targetId);
                
                // Toggle this dropdown
                targetDropdown.classList.toggle('hidden');
            });
        });

        // Prevent click events on dropdown menus from closing the parent dropdown
        document.querySelectorAll('.dropdown-menu').forEach(menu => {
            menu.addEventListener('click', function(e) {
                // Only stop propagation if clicking on a toggle button or non-link item
                if (e.target.classList.contains('secondary-dropdown-toggle') || 
                    e.target.classList.contains('tertiary-dropdown-toggle') ||
                    e.target.tagName !== 'A' || 
                    e.target.getAttribute('href') === '#') {
                    e.stopPropagation();
                }
            });
        });
        
        // Close desktop dropdowns when clicking elsewhere on the page
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.dropdown-menu') && !e.target.classList.contains('primary-dropdown-toggle')) {
                document.querySelectorAll('.primary-dropdown').forEach(dropdown => {
                    dropdown.classList.add('hidden');
                });
                
                document.querySelectorAll('.secondary-dropdown').forEach(dropdown => {
                    dropdown.classList.add('hidden');
                });
                
                document.querySelectorAll('.tertiary-dropdown').forEach(dropdown => {
                    dropdown.classList.add('hidden');
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
    });
</script>