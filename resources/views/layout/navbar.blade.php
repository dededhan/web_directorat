@include('layout.loginpopup')

<!-- Desktop Navbar - hidden on mobile, visible on md and above -->
<nav class="navbar hidden md:block fixed top-0 w-full z-50 bg-[#186862] shadow-lg">
    <div class="container mx-auto flex justify-between items-center py-4 px-6">
        <div class="flex items-center space-x-4">
            <a href="{{ route('home') }}">
                <img alt="University logo" class="h-12 w-12" src="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png"/>
            </a>
            <h1 class="text-white text-2xl font-bold">Direktorat Inovasi, Sistem Informasi, dan Pemeringkatan</h1>
        </div>
        <ul class="flex space-x-6">
            <li><a href="#" class="text-white hover:text-yellow-400">Beranda</a></li>
            
            <li class="relative group">
                <a href="#" class="text-white hover:text-yellow-400">Profil</a>
                <ul class="absolute hidden group-hover:block bg-white text-black py-2 px-4 space-y-2 rounded-lg shadow-lg">
                    <li><a href="{{ route('pimpinan.pimpinan') }}" class="hover:text-yellow-400">Pimpinan DITISIP</a></li>
                    <li><a href="{{ route('profile.profile') }}" class="hover:text-yellow-400">Tugas Pokok dan Fungsi</a></li>
                    <li><a href="{{ route('strukturorganisasi') }}" class="hover:text-yellow-400">Struktur Organisasi</a></li>
                </ul>
            </li>
            <li class="relative group">
                <a href="#" class="text-white hover:text-yellow-400">Sub Direktorat</a>
                <ul class="absolute hidden group-hover:block bg-white text-black py-2 px-4 space-y-2 rounded-lg shadow-lg">
                    <li><a href="{{ route('subdirektorat-inovasi.landingpage') }}" class="hover:text-yellow-400">Subdirektorat Inovasi dan Hilirisasi</a></li>
                    <li><a href="{{ route('pemeringkatan.landingpage') }}" class="hover:text-yellow-400">Subdirektorat Pemeringkatan dan Sistem Informasi</a></li>
                </ul>
            </li>
            <li class="relative group">
                <a href="{{ route('Berita.beritahome') }}" class="text-white hover:text-yellow-400">Berita</a>
                <ul class="absolute hidden group-hover">
                    <!-- <li><a href="#" class="hover:text-yellow-400">Program</a></li>
                    <li><a href="#" class="hover:text-yellow-400">Program</a></li> -->
                </ul>
            </li>
            
            <li class="relative group">
                <a href="#" class="text-white hover:text-yellow-400">Galeri</a>
                <ul class="absolute hidden group-hover:block bg-white text-black py-2 px-4 space-y-2 rounded-lg shadow-lg">
                    <li><a href="{{ route('alumni') }}" class="hover:text-yellow-400">Alumni Berdampak</a></li>
                    <li><a href="{{ route('galeri.sustainability') }}" class="hover:text-yellow-400">Sustainability</a></li>
                </ul>
            </li>
            <li><a href="{{ route('document.document') }}" class="text-white hover:text-yellow-400">Dokumen</a></li>
            <li><a href="https://sso.unj.ac.id/login" class="text-white hover:text-yellow-400">SSO</a></li>
            <li><a class="login text-white" href="#" data-bs-toggle="modal" data-bs-target="#loginModal">Masuk</a></li>
        </ul>
    </div>
</nav>

<!-- Mobile Navigation Bar -->
<!-- Mobile Navigation Bar -->
<nav class="navbar block md:hidden fixed top-0 w-full z-20 transition-all duration-300" id="mobile-navbar">
    <div class="bg-[#186862]/95 backdrop-blur-sm shadow-lg">
        <div class="flex justify-between items-center py-2 px-3">
            <a href="{{ route('home') }}" class="flex items-center space-x-2">
                <img alt="UNJ Logo" 
                     class="h-8 w-8" 
                     src="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png"/>
                <div class="text-white">
                    <h1 class="text-xs font-bold leading-tight">DITISIP UNJ</h1>
                    <p class="text-[10px] opacity-90">Direktorat Inovasi, Sistem Informasi, dan Pemeringkatan</p>
                </div>
            </a>
            
            <button id="mobile-menu-toggle" class="text-white p-1.5 hover:bg-white/10 rounded-lg transition-colors">
                <i id="menu-icon" class="fas fa-bars text-lg"></i>
            </button>
        </div>
    </div>
</nav>

<!-- Add spacing to prevent content overlap -->
<div class="h-12 md:h-20"></div> 
<!-- Mobile Sidebar -->
<div id="mobile-sidebar" class="fixed top-0 right-0 w-72 h-full bg-[#186862] z-40 transform translate-x-full transition-transform duration-300 ease-in-out shadow-lg overflow-y-auto block md:hidden">
    <!-- Sidebar Header -->
    <div class="flex items-center justify-between p-4 border-b border-white/10">
        <a href="{{ route('home') }}" class="flex items-center space-x-3">
            <img alt="UNJ Logo" class="h-8 w-8" src="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png"/>
            <span class="text-white font-bold">DITISIP UNJ</span>
        </a>
        <button id="close-sidebar" class="p-2 text-white hover:bg-white/10 rounded-lg transition-colors">
            <i class="fas fa-times text-xl"></i>
        </button>
    </div>
    
    <div class="py-2">
        <ul class="space-y-1">
            <li>
                <a href="{{ route('home') }}" class="flex items-center text-white py-3 px-4 hover:bg-white/10">
                    <i class="fas fa-home w-6"></i>
                    <span>Beranda</span>
                </a>
            </li>
            
            <!-- Profil Dropdown -->
            <li class="sidebar-dropdown">
                <button class="flex items-center justify-between w-full text-white py-3 px-4 hover:bg-white/10">
                    <div class="flex items-center">
                        <i class="fas fa-user-tie w-6"></i>
                        <span>Profil</span>
                    </div>
                    <i class="fas fa-chevron-down text-sm transition-transform"></i>
                </button>
                <ul class="hidden bg-white/5">
                    <li>
                        <a href="{{ route('pimpinan.pimpinan') }}" class="block text-white py-2 px-4 pl-10 hover:bg-white/10">
                            Pimpinan DITISIP
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('profile.profile') }}" class="block text-white py-2 px-4 pl-10 hover:bg-white/10">
                            Tugas Pokok dan Fungsi
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('strukturorganisasi') }}" class="block text-white py-2 px-4 pl-10 hover:bg-white/10">
                            Struktur Organisasi
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Sub Direktorat Dropdown -->
            <li class="sidebar-dropdown">
                <button class="flex items-center justify-between w-full text-white py-3 px-4 hover:bg-white/10">
                    <div class="flex items-center">
                        <i class="fas fa-sitemap w-6"></i>
                        <span>Sub Direktorat</span>
                    </div>
                    <i class="fas fa-chevron-down text-sm transition-transform"></i>
                </button>
                <ul class="hidden bg-white/5">
                    <li>
                        <a href="{{ route('subdirektorat-inovasi.landingpage') }}" class="block text-white py-2 px-4 pl-10 hover:bg-white/10">
                            Inovasi dan Hilirisasi
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('pemeringkatan.landingpage') }}" class="block text-white py-2 px-4 pl-10 hover:bg-white/10">
                            Pemeringkatan dan SI
                        </a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="{{ route('Berita.beritahome') }}" class="flex items-center text-white py-3 px-4 hover:bg-white/10">
                    <i class="fas fa-newspaper w-6"></i>
                    <span>Berita</span>
                </a>
            </li>

            <!-- Galeri Dropdown -->
            <li class="sidebar-dropdown">
                <button class="flex items-center justify-between w-full text-white py-3 px-4 hover:bg-white/10">
                    <div class="flex items-center">
                        <i class="fas fa-images w-6"></i>
                        <span>Galeri</span>
                    </div>
                    <i class="fas fa-chevron-down text-sm transition-transform"></i>
                </button>
                <ul class="hidden bg-white/5">
                    <li>
                        <a href="{{ route('alumni') }}" class="block text-white py-2 px-4 pl-10 hover:bg-white/10">
                            Alumni Berdampak
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('galeri.sustainability') }}" class="block text-white py-2 px-4 pl-10 hover:bg-white/10">
                            Sustainability
                        </a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="{{ route('document.document') }}" class="flex items-center text-white py-3 px-4 hover:bg-white/10">
                    <i class="fas fa-file-alt w-6"></i>
                    <span>Dokumen</span>
                </a>
            </li>

            <li>
                <a href="https://sso.unj.ac.id/login" class="flex items-center text-white py-3 px-4 hover:bg-white/10">
                    <i class="fas fa-key w-6"></i>
                    <span>SSO</span>
                </a>
            </li>
            
            <li>
                <a href="#" class="flex items-center text-white py-3 px-4 hover:bg-white/10 login" data-bs-toggle="modal" data-bs-target="#loginModal">
                    <i class="fas fa-sign-in-alt w-6"></i>
                    <span>Masuk</span>
                </a>
            </li>
        </ul>
    </div>
</div>

<!-- Overlay -->
<div id="sidebar-overlay" class="fixed inset-0 bg-black opacity-0 pointer-events-none transition-opacity duration-300 ease-in-out z-30 block md:hidden"></div>
<!-- JavaScript for mobile sidebar -->
<script>
    // Mobile Navbar JavaScript Fix
document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
    const mobileSidebar = document.getElementById('mobile-sidebar');
    const sidebarOverlay = document.getElementById('sidebar-overlay');
    const closeSidebar = document.getElementById('close-sidebar');
    
    // Show sidebar
    function showSidebar() {
        mobileSidebar.classList.add('active');
        sidebarOverlay.classList.add('active');
        document.body.style.overflow = 'hidden';
    }
    
    // Hide sidebar
    function hideSidebar() {
        mobileSidebar.classList.remove('active');
        sidebarOverlay.classList.remove('active');
        document.body.style.overflow = '';
    }
    
    // Toggle sidebar when menu button is clicked
    if (mobileMenuToggle) {
        mobileMenuToggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            showSidebar();
        });
    }
    
    // Close sidebar when close button is clicked
    if (closeSidebar) {
        closeSidebar.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            hideSidebar();
        });
    }
    
    // Close sidebar when overlay is clicked
    if (sidebarOverlay) {
        sidebarOverlay.addEventListener('click', function() {
            hideSidebar();
        });
    }
    
    // Handle dropdown menus
    const dropdownButtons = document.querySelectorAll('.sidebar-dropdown button');
    
    dropdownButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const dropdown = this.nextElementSibling;
            const icon = this.querySelector('.fa-chevron-down');
            
            dropdown.classList.toggle('show');
            
            if (dropdown.classList.contains('show')) {
                icon.style.transform = 'rotate(180deg)';
            } else {
                icon.style.transform = 'rotate(0)';
            }
        });
    });
    
    // Close sidebar on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            hideSidebar();
        }
    });
});
</script>

<style>
/* Inline style fixes for navbar.blade.php */

/* Mobile Navbar Specific Fixes */
@media (max-width: 767px) {
    /* Fix overflow issues */
    #mobile-navbar,
    #mobile-sidebar {
        -webkit-backface-visibility: hidden;
        backface-visibility: hidden;
        -webkit-transform: translateZ(0);
        transform: translateZ(0);
    }
    
    /* Fix text rendering on mobile */
    #mobile-navbar h1,
    #mobile-navbar p,
    #mobile-sidebar a,
    #mobile-sidebar button {
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        text-rendering: optimizeLegibility;
    }
    
    /* Fix tap highlight on iOS */
    #mobile-menu-toggle,
    #close-sidebar,
    #mobile-sidebar a,
    #mobile-sidebar button {
        -webkit-tap-highlight-color: transparent;
    }
    
    /* Fix sidebar scrolling on iOS */
    #mobile-sidebar {
        -webkit-overflow-scrolling: touch;
        overscroll-behavior: contain;
    }
    
    /* Fix navbar shadow on scroll */
    #mobile-navbar.scrolled {
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.15);
    }
    
    /* Fix button active states */
    #mobile-menu-toggle:active,
    #close-sidebar:active {
        transform: scale(0.95);
    }
    
    /* Better contrast for accessibility */
    #mobile-navbar a,
    #mobile-navbar button,
    #mobile-sidebar a,
    #mobile-sidebar button {
        color: #ffffff;
        text-decoration: none;
    }
    
    /* Fix icon alignment */
    #mobile-navbar .fas,
    #mobile-sidebar .fas,
    #mobile-navbar .fab,
    #mobile-sidebar .fab {
        vertical-align: middle;
        line-height: 1;
    }
}

/* Android-specific fixes */
@media (max-width: 767px) and (-webkit-min-device-pixel-ratio: 2) {
    #mobile-navbar h1 {
        letter-spacing: 0.01em;
    }
}

/* Fix for notched devices (iPhone X and above) */
@supports (padding: max(0px)) {
    @media (max-width: 767px) {
        #mobile-navbar {
            padding-top: max(8px, env(safe-area-inset-top));
        }
        
        #mobile-sidebar {
            padding-top: max(0px, env(safe-area-inset-top));
            padding-bottom: max(20px, env(safe-area-inset-bottom));
        }
        
        .h-12.md\:h-20 {
            height: calc(56px + max(0px, env(safe-area-inset-top))) !important;
        }
    }
}

/* Fix for iOS PWA mode */
@media (display-mode: standalone) {
    #mobile-navbar {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
    }
}

/* Fix for keyboard appearance on mobile */
@media (max-width: 767px) {
    .login-form input:focus,
    .login-form textarea:focus,
    .login-form select:focus {
        font-size: 16px; /* Prevents zoom on iOS */
    }
}

/* Accessibility improvements */
@media (max-width: 767px) {
    #mobile-menu-toggle:focus,
    #close-sidebar:focus,
    #mobile-sidebar a:focus,
    #mobile-sidebar button:focus {
        outline: 2px solid #FBBF24;
        outline-offset: 2px;
    }
    
    /* High contrast mode */
    @media (prefers-contrast: high) {
        #mobile-navbar,
        #mobile-sidebar {
            border: 1px solid white;
        }
    }
    
    /* Reduced motion */
    @media (prefers-reduced-motion: reduce) {
        #mobile-sidebar,
        #sidebar-overlay,
        #mobile-menu-toggle,
        #close-sidebar {
            transition: none !important;
        }
    }
}
</style>