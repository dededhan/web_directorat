@include('layout.loginpopup')

<!-- Original Desktop Navbar (Now Sticky) -->
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
<nav class="navbar md:hidden fixed top-0 w-full z-20 transition-all duration-300" id="mobile-navbar">
    <div class="bg-[#186862]/95 backdrop-blur-sm shadow-lg">
        <div class="flex justify-between items-center py-2 px-3"> <!-- Adjusted padding -->
            <a href="{{ route('home') }}" class="flex items-center space-x-2"> <!-- Reduced spacing -->
                <img alt="UNJ Logo" 
                     class="h-8 w-8" 
                     src="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png"/>
                <div class="text-white">
                    <h1 class="text-xs font-bold leading-tight">Direktorat Inovasi</h1> <!-- Smaller text -->
                    <p class="text-[10px] opacity-90">Universitas Negeri Jakarta</p> <!-- Even smaller subtitle -->
                </div>
            </a>
            
            <button id="mobile-menu-toggle" class="text-white p-1.5 hover:bg-white/10 rounded-lg transition-colors">
                <!-- Smaller menu icon -->
                <i id="menu-icon" class="fas fa-bars text-lg"></i>
            </button>
        </div>
    </div>
</nav>

<!-- Add spacing to prevent content overlap -->
<div class="h-12 md:h-0"></div> 

<!-- Mobile Sidebar -->
<div id="mobile-sidebar" class="fixed top-0 right-0 w-72 h-full bg-[#186862] z-40 transform translate-x-full transition-transform duration-300 ease-in-out shadow-lg overflow-y-auto">
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
    
    <!-- Sidebar Menu -->
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
        </ul>

        <div class="p-4 mt-4">
            <button class="login w-full bg-white text-[#186862] py-2.5 px-4 rounded-lg font-medium hover:bg-white/90 transition-colors flex items-center justify-center space-x-2" data-bs-toggle="modal" data-bs-target="#loginModal">
                <i class="fas fa-sign-in-alt"></i>
                <span>Masuk</span>
            </button>
        </div>
    </div>
</div>

<!-- Overlay -->
<div id="sidebar-overlay" class="fixed inset-0 bg-black opacity-0 md:hidden pointer-events-none transition-opacity duration-300 ease-in-out z-30"></div>

<!-- JavaScript for mobile sidebar -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
        const menuIcon = document.getElementById('menu-icon');
        const mobileSidebar = document.getElementById('mobile-sidebar');
        const sidebarOverlay = document.getElementById('sidebar-overlay');
        const mobileNavbar = document.getElementById('mobile-navbar');
        const dropdownButtons = document.querySelectorAll('.sidebar-dropdown button');
        
        // Function to handle scroll effects
        function handleScroll() {
            if (window.scrollY > 10) {
                // When scrolled, add background color
                mobileNavbar.classList.remove('bg-transparent');
                mobileNavbar.classList.add('bg-[#186862]');
            } else {
                // When at top, make transparent
                mobileNavbar.classList.remove('bg-[#186862]');
                mobileNavbar.classList.add('bg-transparent');
            }
        }
        
        // Add scroll event listener
        window.addEventListener('scroll', handleScroll);
        
        // Set initial state for mobile devices
        function initMobileNav() {
            if (window.innerWidth < 768) {
                // Default state: sidebar hidden, show hamburger icon
                hideSidebar();
                // Check initial scroll position
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
        
        // Toggle dropdowns in sidebar
        dropdownButtons.forEach(button => {
            button.addEventListener('click', function() {
                const dropdownMenu = this.nextElementSibling;
                const icon = this.querySelector('.fa-chevron-down');
                
                // Toggle current dropdown with smooth animation
                if (dropdownMenu.classList.contains('hidden')) {
                    dropdownMenu.classList.remove('hidden');
                    icon.style.transform = 'rotate(180deg)';
                } else {
                    dropdownMenu.classList.add('hidden');
                    icon.style.transform = 'rotate(0deg)';
                }
            });
        });
        
        // Initialize mobile navigation
        initMobileNav();
        
        // Handle window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 768) {
                // Desktop view - hide mobile elements
                hideSidebar();
            } else {
                // Check scroll position on resize
                handleScroll();
            }
        });
    });
</script>

<style>
.fa-chevron-down {
    transition: transform 0.2s ease;
}

#mobile-sidebar {
    scrollbar-width: thin;
    scrollbar-color: rgba(255,255,255,0.2) transparent;
}

#mobile-sidebar::-webkit-scrollbar {
    width: 4px;
}

#mobile-sidebar::-webkit-scrollbar-track {
    background: transparent;
}

#mobile-sidebar::-webkit-scrollbar-thumb {
    background-color: rgba(255,255,255,0.2);
    border-radius: 2px;
}
</style>