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
        overscroll-behavior: contain;
        position: fixed;
        top: 0;
        right: 0;
        width: 280px;
        height: 100vh;
        background-color: #186862;
        z-index: 9999;
        transform: translateX(100%);
        transition: transform 0.3s ease-in-out;
        overflow-y: auto;
        box-shadow: -5px 0 15px rgba(0, 0, 0, 0.1);
    }

    #mobile-sidebar.open {
        transform: translateX(0);
    }

    #sidebar-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 9998;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.3s ease-in-out, visibility 0.3s ease-in-out;
    }

    #sidebar-overlay.show {
        opacity: 1;
        visibility: visible;
    }

    /* Perbaikan untuk dropdown sidebar mobile */
    .sidebar-dropdown > button {
        width: 100%;
        text-align: left;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: transparent;
        border: none;
        cursor: pointer;
        color: white;
        padding: 12px 24px;
        font-size: 1.125rem;
        transition: background-color 0.2s ease;
    }

    .sidebar-dropdown > button:hover {
        background-color: #125a54;
    }

    .sidebar-dropdown .dropdown-content {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease-in-out;
        background-color: #135a54;
    }

    .sidebar-dropdown .dropdown-content.open {
        max-height: 500px;
    }

    .sidebar-dropdown .dropdown-content a {
        display: block;
        color: white;
        padding: 12px 32px;
        text-decoration: none;
        border-left: 2px solid transparent;
        transition: all 0.2s ease;
    }

    .sidebar-dropdown .dropdown-content a:hover {
        background-color: #0e4c46;
        border-left-color: #fbbf24;
    }

    /* Nested dropdown styling */
    .nested-dropdown .dropdown-content {
        background-color: #0d4540;
    }

    .nested-dropdown .dropdown-content a {
        padding-left: 40px;
    }

    .nested-dropdown .dropdown-content a:hover {
        background-color: #0a3c38;
    }

    /* Icon rotation for chevrons */
    .chevron-icon {
        transition: transform 0.3s ease;
    }

    .chevron-icon.rotated {
        transform: rotate(180deg);
    }

    /* Navbar scroll effects */
    .navbar.scrolled {
        background-color: rgba(39, 113, 119, 0.95) !important;
        backdrop-filter: blur(10px);
        transition: background-color 0.3s ease;
        padding-top: 0.75rem;
        padding-bottom: 0.75rem;
    }

    /* Desktop navbar styling */
    .navbar.hidden.md\:block {
        background-color: #277177 !important;
    }

    /* Mobile navbar styling */
    #mobile-navbar {
        background-color: #186862 !important;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        z-index: 1000;
    }

    /* Prevent body scroll when sidebar is open */
    body.sidebar-open {
        overflow: hidden;
    }

    /* Responsive fixes */
    @media (max-width: 767px) {
        .navbar.hidden.md\:block {
            display: none !important;
        }
        
        #mobile-navbar {
            display: block !important;
        }
        
        #mobile-sidebar {
            width: 90%;
            max-width: 320px;
        }
    }

    @media (min-width: 768px) {
        #mobile-navbar,
        #mobile-sidebar,
        #sidebar-overlay {
            display: none !important;
        }
    }
</style>

@include('layout.loginpopup')

{{-- Desktop Navbar --}}
<nav class="navbar hidden md:block sticky top-0 z-50 bg-[#277177] shadow-md">
    <div class="container mx-auto flex justify-between items-center py-4 px-6">
        <div class="flex items-center space-x-4">
            <a href="{{ route('home') }}">
                <img alt="University logo" class="h-12 w-12"
                    src="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" />
            </a>
            <h1 class="text-white text-xl lg:text-2xl font-bold">Subdirektorat Pemeringkatan dan Sistem Informasi</h1>
        </div>
        <ul class="flex space-x-6 items-center">
            <li><a href="{{ route('home') }}" class="text-white hover:text-yellow-400 transition-colors duration-200">Beranda</a></li>

            <li class="relative">
                <a href="#" class="text-white hover:text-yellow-400 transition-colors duration-200 primary-dropdown-toggle" data-dropdown="tentang-dropdown">Tentang</a>
                <ul id="tentang-dropdown" class="dropdown-menu primary-dropdown hidden">
                    <li><a href="{{ route('pimpinan.pimpinan') }}">Pimpinan Direktorat</a></li>
                    <li><a href="{{ route('strukturorganisasipemeringkatan') }}">Struktur Organisasi</a></li>
                    <li><a href="{{ route('tupoksipemeringkatan') }}">Tugas Pokok dan Fungsi</a></li>
                    <li><a href="{{ route('Pemeringkatan.sejarah.sejarah') }}">Profil</a></li>
                </ul>
            </li>

            <li class="relative">
                <a href="#" class="text-white hover:text-yellow-400 transition-colors duration-200 primary-dropdown-toggle" data-dropdown="program-dropdown">Program</a>
                <ul id="program-dropdown" class="dropdown-menu primary-dropdown hidden">
                    <li><a href="{{ route('Pemeringkatan.program.global-engagement') }}">Global Engagement</a></li>
                    <li><a href="{{ route('Pemeringkatan.program.lecturer-expose') }}">Lecturer Expose</a></li>
                    <li><a href="{{ route('Pemeringkatan.program.international-faculty-staff') }}">International Faculty Staff</a></li>
                    <li><a href="{{ route('Pemeringkatan.program.international-student-mobility') }}">International Student Mobility</a></li>
                    
                    <li class="relative">
                        <a href="#" class="flex justify-between items-center secondary-dropdown-toggle" data-dropdown="sustainability-dropdown">
                            Sustainability
                            <i class="fas fa-chevron-right ml-2"></i>
                        </a>
                        <ul id="sustainability-dropdown" class="dropdown-menu nested-menu secondary-dropdown hidden">
                            <li><a href="{{ route('Pemeringkatan.kegiatansustainability.kegiatansustainability') }}">Kegiatan Sustainability</a></li>
                            <li><a href="{{ route('Pemeringkatan.matakuliahsustainability.matakuliahsustainability') }}">Mata Kuliah Sustainability</a></li>
                            <li><a href="{{ route('Pemeringkatan.programsustainability.programsustainability') }}">Program Sustainability UNJ</a></li>
                        </ul>
                    </li>
                    
                    <li><a href="{{ route('Pemeringkatan.dataresponden.dataresponden') }}">Data Responden</a></li>
                </ul>
            </li>

            <li><a href="{{ route('Pemeringkatan.ranking_unj.rankingunj') }}" class="text-white hover:text-yellow-400 transition-colors duration-200">Ranking UNJ</a></li>
            <li><a href="{{ route('document.document') }}" class="text-white hover:text-yellow-400 transition-colors duration-200">Dokumen</a></li>
            <li><a href="https://sso.unj.ac.id/login" target="_blank" class="text-white hover:text-yellow-400 transition-colors duration-200">SSO</a></li>
            <li><a class="login text-white cursor-pointer hover:text-yellow-400 transition-colors duration-200" data-bs-toggle="modal" data-bs-target="#loginModal">Masuk</a></li>
        </ul>
    </div>
</nav>

{{-- Mobile Navbar --}}
<nav class="md:hidden fixed top-0 w-full z-50 bg-[#186862] shadow-lg" id="mobile-navbar">
    <div class="flex justify-between items-center py-3 px-4">
        <div class="flex items-center space-x-3">
            <a href="{{ route('home') }}">
                <img alt="University logo" class="h-10 w-10" 
                     src="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" />
            </a>
            <div>
                <h1 class="text-white text-sm font-bold leading-tight">Subdirektorat</h1>
                <p class="text-white text-xs opacity-90">Sistem Informasi dan Pemeringkatan</p>
            </div>
        </div>
        <button id="mobile-menu-toggle" class="text-white focus:outline-none">
            <i id="menu-icon" class="fas fa-bars text-2xl"></i>
        </button>
    </div>
</nav>

{{-- Mobile Sidebar --}}
<div id="mobile-sidebar" class="fixed top-0 right-0 w-80 max-w-[90vw] h-full bg-[#186862] z-[9999] transform translate-x-full transition-transform duration-300 ease-in-out shadow-xl overflow-y-auto">
    {{-- Sidebar Header --}}
    <div class="flex justify-between items-center p-4 border-b border-white/20 bg-[#0f4c47]">
        <h1 class="text-white text-lg font-bold">Menu Navigasi</h1>
        <button id="close-sidebar" class="text-white hover:text-yellow-400 transition-colors">
            <i class="fas fa-times text-2xl"></i>
        </button>
    </div>
    
    {{-- Sidebar Content --}}
    <div class="py-2">
        <ul class="flex flex-col">
            {{-- Beranda --}}
            <li>
                <a href="{{ route('home') }}" class="block text-white py-3 px-6 text-base hover:bg-[#125a54] transition-colors duration-200">
                    <i class="fas fa-home mr-3"></i>Beranda
                </a>
            </li>
            
            {{-- Tentang Dropdown --}}
            <li class="sidebar-dropdown">
                <button class="sidebar-dropdown-toggle w-full text-white py-3 px-6 text-base hover:bg-[#125a54] transition-colors duration-200 flex justify-between items-center">
                    <span><i class="fas fa-info-circle mr-3"></i>Tentang</span>
                    <i class="fas fa-chevron-down chevron-icon transition-transform duration-300"></i>
                </button>
                <ul class="dropdown-content bg-[#135a54] overflow-hidden">
                    <li><a href="{{ route('pimpinan.pimpinan') }}" class="block text-white py-3 px-8 hover:bg-[#0e4c46] transition-colors duration-200 border-l-2 border-transparent hover:border-yellow-400">Pimpinan Direktorat</a></li>
                    <li><a href="{{ route('strukturorganisasipemeringkatan') }}" class="block text-white py-3 px-8 hover:bg-[#0e4c46] transition-colors duration-200 border-l-2 border-transparent hover:border-yellow-400">Struktur Organisasi</a></li>
                    <li><a href="{{ route('tupoksipemeringkatan') }}" class="block text-white py-3 px-8 hover:bg-[#0e4c46] transition-colors duration-200 border-l-2 border-transparent hover:border-yellow-400">Tugas Pokok dan Fungsi</a></li>
                    <li><a href="{{ route('Pemeringkatan.sejarah.sejarah') }}" class="block text-white py-3 px-8 hover:bg-[#0e4c46] transition-colors duration-200 border-l-2 border-transparent hover:border-yellow-400">Profil</a></li>
                </ul>
            </li>

            {{-- Program Dropdown --}}
            <li class="sidebar-dropdown">
                <button class="sidebar-dropdown-toggle w-full text-white py-3 px-6 text-base hover:bg-[#125a54] transition-colors duration-200 flex justify-between items-center">
                    <span><i class="fas fa-rocket mr-3"></i>Program</span>
                    <i class="fas fa-chevron-down chevron-icon transition-transform duration-300"></i>
                </button>
                <ul class="dropdown-content bg-[#135a54] overflow-hidden">
                    <li><a href="{{ route('Pemeringkatan.program.global-engagement') }}" class="block text-white py-3 px-8 hover:bg-[#0e4c46] transition-colors duration-200 border-l-2 border-transparent hover:border-yellow-400">Global Engagement</a></li>
                    <li><a href="{{ route('Pemeringkatan.program.lecturer-expose') }}" class="block text-white py-3 px-8 hover:bg-[#0e4c46] transition-colors duration-200 border-l-2 border-transparent hover:border-yellow-400">Lecturer Expose</a></li>
                    <li><a href="{{ route('Pemeringkatan.program.international-faculty-staff') }}" class="block text-white py-3 px-8 hover:bg-[#0e4c46] transition-colors duration-200 border-l-2 border-transparent hover:border-yellow-400">International Faculty Staff</a></li>
                    <li><a href="{{ route('Pemeringkatan.program.international-student-mobility') }}" class="block text-white py-3 px-8 hover:bg-[#0e4c46] transition-colors duration-200 border-l-2 border-transparent hover:border-yellow-400">International Student Mobility</a></li>
                    
                    {{-- Nested Sustainability Dropdown --}}
                    <li class="sidebar-dropdown nested-dropdown">
                        <button class="sidebar-dropdown-toggle w-full text-white py-3 px-8 hover:bg-[#0e4c46] transition-colors duration-200 border-l-2 border-transparent hover:border-yellow-400 flex justify-between items-center">
                            <span>Sustainability</span>
                            <i class="fas fa-chevron-down chevron-icon transition-transform duration-300"></i>
                        </button>
                        <ul class="dropdown-content bg-[#0d4540] overflow-hidden">
                            <li><a href="{{ route('Pemeringkatan.kegiatansustainability.kegiatansustainability') }}" class="block text-white py-3 px-10 hover:bg-[#0a3c38] transition-colors duration-200 border-l-2 border-transparent hover:border-yellow-400">Kegiatan Sustainability</a></li>
                            <li><a href="{{ route('Pemeringkatan.matakuliahsustainability.matakuliahsustainability') }}" class="block text-white py-3 px-10 hover:bg-[#0a3c38] transition-colors duration-200 border-l-2 border-transparent hover:border-yellow-400">Mata Kuliah Sustainability</a></li>
                            <li><a href="{{ route('Pemeringkatan.programsustainability.programsustainability') }}" class="block text-white py-3 px-10 hover:bg-[#0a3c38] transition-colors duration-200 border-l-2 border-transparent hover:border-yellow-400">Program Sustainability UNJ</a></li>
                        </ul>
                    </li>
                    
                    <li><a href="{{ route('Pemeringkatan.dataresponden.dataresponden') }}" class="block text-white py-3 px-8 hover:bg-[#0e4c46] transition-colors duration-200 border-l-2 border-transparent hover:border-yellow-400">Data Responden</a></li>
                </ul>
            </li>
            
            {{-- Direct Menu Items --}}
            <li>
                <a href="{{ route('Pemeringkatan.ranking_unj.rankingunj') }}" class="block text-white py-3 px-6 text-base hover:bg-[#125a54] transition-colors duration-200">
                    <i class="fas fa-trophy mr-3"></i>Ranking UNJ
                </a>
            </li>
            <li>
                <a href="{{ route('document.document') }}" class="block text-white py-3 px-6 text-base hover:bg-[#125a54] transition-colors duration-200">
                    <i class="fas fa-file-alt mr-3"></i>Dokumen
                </a>
            </li>
            <li>
                <a href="https://sso.unj.ac.id/login" target="_blank" class="block text-white py-3 px-6 text-base hover:bg-[#125a54] transition-colors duration-200">
                    <i class="fas fa-sign-in-alt mr-3"></i>SSO
                </a>
            </li>

            {{-- Login Button --}}
            <li class="px-6 my-4">
                <button class="login w-full text-center bg-white text-[#186862] py-3 rounded-lg font-semibold hover:bg-yellow-400 hover:text-[#186862] transition-colors duration-200 shadow-md" data-bs-toggle="modal" data-bs-target="#loginModal">
                    <i class="fas fa-user mr-2"></i>Masuk
                </button>
            </li>
        </ul>
    </div>
</div>

{{-- Sidebar Overlay --}}
<div id="sidebar-overlay" class="fixed inset-0 bg-black/50 z-[9998] opacity-0 pointer-events-none transition-all duration-300 ease-in-out"></div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('Navbar script loaded'); // Debug log

    // --- MOBILE SIDEBAR LOGIC (IMPROVED) ---
    const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
    const mobileSidebar = document.getElementById('mobile-sidebar');
    const sidebarOverlay = document.getElementById('sidebar-overlay');
    const closeSidebarBtn = document.getElementById('close-sidebar');
    const menuIcon = document.getElementById('menu-icon');

    console.log('Elements found:', {
        mobileMenuToggle: !!mobileMenuToggle,
        mobileSidebar: !!mobileSidebar,
        sidebarOverlay: !!sidebarOverlay,
        closeSidebarBtn: !!closeSidebarBtn,
        menuIcon: !!menuIcon
    }); // Debug log

    const openSidebar = () => {
        console.log('Opening sidebar'); // Debug log
        if (mobileSidebar && sidebarOverlay) {
            mobileSidebar.classList.add('open');
            mobileSidebar.classList.remove('translate-x-full');
            sidebarOverlay.classList.add('show');
            sidebarOverlay.classList.remove('pointer-events-none');
            document.body.classList.add('sidebar-open');
            if (menuIcon) {
                menuIcon.classList.remove('fa-bars');
                menuIcon.classList.add('fa-times');
            }
        }
    };

    const closeSidebar = () => {
        console.log('Closing sidebar'); // Debug log
        if (mobileSidebar && sidebarOverlay) {
            mobileSidebar.classList.remove('open');
            mobileSidebar.classList.add('translate-x-full');
            sidebarOverlay.classList.remove('show');
            sidebarOverlay.classList.add('pointer-events-none');
            document.body.classList.remove('sidebar-open');
            if (menuIcon) {
                menuIcon.classList.remove('fa-times');
                menuIcon.classList.add('fa-bars');
            }
            
            // Close all dropdowns when sidebar closes
            document.querySelectorAll('.sidebar-dropdown .dropdown-content').forEach(dropdown => {
                dropdown.classList.remove('open');
            });
            document.querySelectorAll('.sidebar-dropdown .chevron-icon').forEach(icon => {
                icon.classList.remove('rotated');
            });
        }
    };

    // Event listeners for sidebar
    if (mobileMenuToggle) {
        mobileMenuToggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            console.log('Menu toggle clicked'); // Debug log
            
            if (mobileSidebar.classList.contains('open')) {
                closeSidebar();
            } else {
                openSidebar();
            }
        });
    }

    if (closeSidebarBtn) {
        closeSidebarBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            closeSidebar();
        });
    }

    if (sidebarOverlay) {
        sidebarOverlay.addEventListener('click', function(e) {
            e.preventDefault();
            closeSidebar();
        });
    }

    // --- MOBILE DROPDOWN LOGIC (COMPLETELY REWRITTEN) ---
    const sidebarDropdowns = document.querySelectorAll('.sidebar-dropdown');
    
    sidebarDropdowns.forEach(dropdown => {
        const toggle = dropdown.querySelector('.sidebar-dropdown-toggle');
        const content = dropdown.querySelector('.dropdown-content');
        const chevron = toggle.querySelector('.chevron-icon');
        
        if (toggle && content && chevron) {
            toggle.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                console.log('Dropdown toggle clicked'); // Debug log
                
                const isOpen = content.classList.contains('open');
                
                // Close all other dropdowns at the same level
                const parentUl = this.closest('ul');
                const siblingDropdowns = parentUl.querySelectorAll(':scope > .sidebar-dropdown');
                
                siblingDropdowns.forEach(siblingDropdown => {
                    if (siblingDropdown !== dropdown) {
                        const siblingContent = siblingDropdown.querySelector('.dropdown-content');
                        const siblingChevron = siblingDropdown.querySelector('.chevron-icon');
                        if (siblingContent && siblingChevron) {
                            siblingContent.classList.remove('open');
                            siblingChevron.classList.remove('rotated');
                        }
                    }
                });
                
                // Toggle current dropdown
                if (isOpen) {
                    content.classList.remove('open');
                    chevron.classList.remove('rotated');
                    
                    // Close nested dropdowns if any
                    const nestedDropdowns = content.querySelectorAll('.dropdown-content');
                    const nestedChevrons = content.querySelectorAll('.chevron-icon');
                    nestedDropdowns.forEach(nested => nested.classList.remove('open'));
                    nestedChevrons.forEach(icon => icon.classList.remove('rotated'));
                } else {
                    content.classList.add('open');
                    chevron.classList.add('rotated');
                }
            });
        }
    });

    // --- DESKTOP DROPDOWN LOGIC (UNCHANGED) ---
    const primaryToggles = document.querySelectorAll('.primary-dropdown-toggle');
    primaryToggles.forEach(toggle => {
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const targetId = this.getAttribute('data-dropdown');
            const targetDropdown = document.getElementById(targetId);
            
            // Close other primary dropdowns
            document.querySelectorAll('.primary-dropdown').forEach(dropdown => {
                if (dropdown.id !== targetId) dropdown.classList.add('hidden');
            });
            
            targetDropdown.classList.toggle('hidden');
        });
    });

    const secondaryToggles = document.querySelectorAll('.secondary-dropdown-toggle');
    secondaryToggles.forEach(toggle => {
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const targetId = this.getAttribute('data-dropdown');
            const targetDropdown = document.getElementById(targetId);
            
            // Close other secondary dropdowns in the same parent
            this.closest('.primary-dropdown').querySelectorAll('.secondary-dropdown').forEach(dropdown => {
                if (dropdown.id !== targetId) dropdown.classList.add('hidden');
            });
            
            targetDropdown.classList.toggle('hidden');
        });
    });

    // Close desktop dropdowns when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.relative')) {
            document.querySelectorAll('.primary-dropdown, .secondary-dropdown').forEach(dropdown => {
                dropdown.classList.add('hidden');
            });
        }
    });

    // Prevent dropdown menus from closing when clicked inside
    document.querySelectorAll('.dropdown-menu').forEach(menu => {
        menu.addEventListener('click', e => e.stopPropagation());
    });

    // --- AUTO-CLOSE SIDEBAR ON LINK CLICK ---
    const sidebarLinks = document.querySelectorAll('#mobile-sidebar a[href]:not([data-bs-toggle])');
    sidebarLinks.forEach(link => {
        link.addEventListener('click', () => {
            // Small delay for smooth transition
            setTimeout(() => {
                closeSidebar();
            }, 150);
        });
    });

    // Auto-close sidebar when login button is clicked
    const mobileLoginBtns = document.querySelectorAll('#mobile-sidebar .login');
    mobileLoginBtns.forEach(loginBtn => {
        loginBtn.addEventListener('click', () => {
            setTimeout(() => {
                closeSidebar();
            }, 150);
        });
    });

    // --- NAVBAR SCROLL EFFECT ---
    const desktopNavbar = document.querySelector('.navbar.hidden.md\\:block');
    if (desktopNavbar) {
        let scrollTimeout;
        window.addEventListener('scroll', () => {
            clearTimeout(scrollTimeout);
            scrollTimeout = setTimeout(() => {
                if (window.scrollY > 50) {
                    desktopNavbar.classList.add('scrolled');
                } else {
                    desktopNavbar.classList.remove('scrolled');
                }
            }, 10);
        }, { passive: true });
    }

    // --- PREVENT CONFLICTS WITH LANDING PAGE ---
    // Ensure mobile navbar doesn't interfere with page content
    const mobileNavbar = document.getElementById('mobile-navbar');
    if (mobileNavbar) {
        // Add top padding to body to account for fixed navbar
        document.body.style.paddingTop = mobileNavbar.offsetHeight + 'px';
        
        // Update padding on resize
        window.addEventListener('resize', () => {
            if (window.innerWidth < 768) {
                document.body.style.paddingTop = mobileNavbar.offsetHeight + 'px';
            } else {
                document.body.style.paddingTop = '0';
            }
        });
    }

    // --- RESPONSIVE BREAKPOINT HANDLER ---
    const handleResize = () => {
        if (window.innerWidth >= 768) {
            // Desktop view - ensure sidebar is closed and reset mobile states
            closeSidebar();
            document.body.style.paddingTop = '0';
        } else {
            // Mobile view - ensure proper padding
            if (mobileNavbar) {
                document.body.style.paddingTop = mobileNavbar.offsetHeight + 'px';
            }
        }
    };

    // Initial resize check
    handleResize();
    
    // Listen for resize events
    window.addEventListener('resize', handleResize);

    // --- KEYBOARD ACCESSIBILITY ---
    document.addEventListener('keydown', function(e) {
        // Close sidebar with Escape key
        if (e.key === 'Escape' && mobileSidebar && mobileSidebar.classList.contains('open')) {
            closeSidebar();
        }
    });

    // --- TOUCH GESTURE SUPPORT ---
    let touchStartX = 0;
    let touchEndX = 0;
    
    if (mobileSidebar) {
        mobileSidebar.addEventListener('touchstart', function(e) {
            touchStartX = e.changedTouches[0].screenX;
        }, { passive: true });

        mobileSidebar.addEventListener('touchend', function(e) {
            touchEndX = e.changedTouches[0].screenX;
            
            // Swipe right to close (swipe distance > 100px)
            if (touchEndX - touchStartX > 100) {
                closeSidebar();
            }
        }, { passive: true });
    }

    // --- FIX CONFLICTS WITH LANDING PAGE ---
    // Ensure no interference with landing page carousel or other scripts
    const landingPageElements = document.querySelectorAll('.header-carousel, .swiper-container');
    if (landingPageElements.length > 0) {
        console.log('Landing page elements detected, ensuring navbar compatibility');
        
        // Prevent navbar from blocking carousel interactions
        if (mobileNavbar) {
            mobileNavbar.style.pointerEvents = 'auto';
            mobileNavbar.querySelector('.container, .flex').style.pointerEvents = 'auto';
        }
    }

    // --- ERROR HANDLING ---
    window.addEventListener('error', function(e) {
        if (e.message.includes('sidebar') || e.message.includes('navbar')) {
            console.error('Navbar error:', e.message);
            // Reset sidebar state on error
            if (mobileSidebar) {
                mobileSidebar.classList.remove('open');
                mobileSidebar.classList.add('translate-x-full');
            }
            if (sidebarOverlay) {
                sidebarOverlay.classList.remove('show');
                sidebarOverlay.classList.add('pointer-events-none');
            }
            document.body.classList.remove('sidebar-open');
        }
    });
});

// --- ADDITIONAL UTILITY FUNCTIONS ---
// Function to programmatically close sidebar (can be called from other scripts)
window.closeMobileSidebar = function() {
    const mobileSidebar = document.getElementById('mobile-sidebar');
    const sidebarOverlay = document.getElementById('sidebar-overlay');
    const menuIcon = document.getElementById('menu-icon');
    
    if (mobileSidebar && sidebarOverlay) {
        mobileSidebar.classList.remove('open');
        mobileSidebar.classList.add('translate-x-full');
        sidebarOverlay.classList.remove('show');
        sidebarOverlay.classList.add('pointer-events-none');
        document.body.classList.remove('sidebar-open');
        
        if (menuIcon) {
            menuIcon.classList.remove('fa-times');
            menuIcon.classList.add('fa-bars');
        }
    }
};

// Function to check if sidebar is open
window.isMobileSidebarOpen = function() {
    const mobileSidebar = document.getElementById('mobile-sidebar');
    return mobileSidebar ? mobileSidebar.classList.contains('open') : false;
};
</script>