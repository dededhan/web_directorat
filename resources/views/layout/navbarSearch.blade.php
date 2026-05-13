@include('layout.loginpopup')

<nav class="navbar hidden md:block fixed top-0 w-full z-50 bg-[#186862] shadow-lg transition-all duration-300">
    <div class="container mx-auto flex justify-between items-center py-4 px-6">
        <div class="flex items-center">
            <a href="{{ route('home') }}" class="flex items-center">
                <img alt="University logo" class="h-12 w-12" 
                    src="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png"/>
                <img alt="DITISIP Logo" class="h-12 w-auto mx-2" 
                    src="{{ asset('images/logoditisip.png') }}"/>
                <div>
                    <h1 class="text-white text-lg font-bold uppercase leading-tight">
                        Direktorat Inovasi dan Hilirisasi,
                        <span class="block">Sistem Informasi dan Pemeringkatan</span>
                    </h1>
                </div>
            </a>
        </div>
        <ul class="flex items-center space-x-6 text-sm font-medium">
            <li><a href="{{ route('home') }}" class="text-white hover:text-yellow-400 transition-colors">Beranda</a></li>
            
            <li class="relative">
                <a href="#" class="desktop-dropdown-toggle text-white hover:text-yellow-400 transition-colors flex items-center">Profil <i class="fas fa-chevron-down ml-1 text-xs"></i></a>
                <ul class="desktop-dropdown-menu absolute hidden bg-white text-gray-800 py-2 mt-2 rounded-lg shadow-xl w-60 z-10">
                    <li><a href="{{ route('pimpinan.pimpinan') }}" class="block px-4 py-2 hover:bg-gray-100">Pimpinan Dit. ISIP</a></li>
                    <li><a href="{{ route('profile.profile') }}" class="block px-4 py-2 hover:bg-gray-100">Tugas Pokok dan Fungsi</a></li>
                    <li><a href="{{ route('strukturorganisasi') }}" class="block px-4 py-2 hover:bg-gray-100">Struktur Organisasi</a></li>
                </ul>
            </li>
            <li class="relative">
                <a href="#" class="desktop-dropdown-toggle text-white hover:text-yellow-400 transition-colors flex items-center">Sub Direktorat <i class="fas fa-chevron-down ml-1 text-xs"></i></a>
                <ul class="desktop-dropdown-menu absolute hidden bg-white text-gray-800 py-2 mt-2 rounded-lg shadow-xl w-72 z-10">
                    <li><a href="{{ route('subdirektorat-inovasi.landingpage') }}" class="block px-4 py-2 hover:bg-gray-100">Subdirektorat Inovasi dan Hilirisasi</a></li>
                    <li><a href="{{ route('pemeringkatan.landing') }}" class="block px-4 py-2 hover:bg-gray-100">Subdirektorat Sistem Informasi dan Pemeringkatan</a></li>
                </ul>
            </li>
            <li><a href="{{ route('Berita.beritahome') }}" class="text-white hover:text-yellow-400 transition-colors">Berita</a></li>
            
            <li class="relative">
                <a href="#" class="desktop-dropdown-toggle text-white hover:text-yellow-400 transition-colors flex items-center">Galeri <i class="fas fa-chevron-down ml-1 text-xs"></i></a>
                <ul class="desktop-dropdown-menu absolute hidden bg-white text-gray-800 py-2 mt-2 rounded-lg shadow-xl w-60 z-10">
                    <li><a href="{{ route('alumni') }}" class="block px-4 py-2 hover:bg-gray-100">Alumni Berdampak</a></li>
                    <li><a href="{{ route('galeri.sustainability') }}" class="block px-4 py-2 hover:bg-gray-100">Sustainability</a></li>
                </ul>
            </li>
            <li><a href="{{ route('documents.public.index') }}" class="text-white hover:text-yellow-400 transition-colors">Dokumen</a></li>
            <li><a href="{{ route('equity') }}" class="text-white hover:text-yellow-400 transition-colors">EQUITY</a></li>
            <li><a href="https://sso.unj.ac.id/login" class="text-white hover:text-yellow-400 transition-colors">SSO</a></li>
            
            {{-- Language Switcher --}}
            <li class="relative">
                <div class="flex items-center space-x-2">
                    <a href="{{ route('language.switch', 'id') }}" 
                       class="text-white hover:text-yellow-400 transition-colors px-2 py-1 rounded {{ app()->getLocale() === 'id' ? 'bg-yellow-400 text-gray-800' : '' }}">
                        ID
                    </a>
                    <span class="text-white">|</span>
                    <a href="{{ route('language.switch', 'en') }}" 
                       class="text-white hover:text-yellow-400 transition-colors px-2 py-1 rounded {{ app()->getLocale() === 'en' ? 'bg-yellow-400 text-gray-800' : '' }}">
                        EN
                    </a>
                </div>
            </li>
            
            {{-- Login --}}
            <li>
                <a class="login text-white bg-yellow-400 hover:bg-yellow-500 px-4 py-2 rounded-full transition-colors" href="#" data-bs-toggle="modal" data-bs-target="#loginModal">
                    Masuk
                </a>
            </li>

            {{-- Search Icon --}}
            <li>
                <button type="button" id="open-search" class="text-white hover:text-yellow-400 transition-colors text-lg">
                    <i class="fas fa-search"></i>
                </button>
            </li>
        </ul>
    </div>
</nav>

{{-- Search Bar --}}
<div id="navbar-search-overlay" class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/80 opacity-0 pointer-events-none transition-opacity duration-300">
    <div id="navbar-search-panel" class="relative w-full max-w-4xl p-6 opacity-0 scale-95 transition-all duration-300 ease-out">
        <button id="close-search" type="button" class="absolute top-[-55px] right-4 md:top-[-18px] md:right-[-60px] flex items-center justify-center w-12 h-12 rounded-full border border-white/70 text-white text-xl hover:border-white hover:bg-white/10 transition duration-300 focus:outline-none">
            <i class="fas fa-times"></i>
        </button>
        <form action="{{ route('search.index') }}" method="GET" class="w-full flex justify-center">
            <div class="relative w-full max-w-3xl">
                <input type="search" name="q" id="navbar-search-input" placeholder="Search..." autofocus class="w-full bg-transparent border-2 border-white/80 rounded-full px-8 py-5 pr-16 text-white placeholder:text-white text-lg outline-none backdrop-blur-sm focus:border-white focus:ring-2 focus:ring-white/20"/>
                <button type="submit" class="absolute right-6 top-1/2 -translate-y-1/2 text-white text-xl hover:text-yellow-400 transition">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </form>
    </div>
</div>

<nav class="navbar block md:hidden fixed top-0 w-full z-50" id="mobile-navbar">
    <div class="bg-[#186862] shadow-lg">
        <div class="container mx-auto flex justify-between items-center py-3 px-4 h-16">
            <a href="{{ route('home') }}" class="flex items-center">
                <img alt="UNJ Logo" class="h-10 w-10" 
                    src="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png"/>
                <img alt="DITISIP Logo" class="h-10 w-auto mx-2" 
                    src="{{ asset('images/logoditisip.png') }}"/>
                <div class="text-white">
                    <h1 class="text-base font-bold leading-tight">DITISIP UNJ</h1>
                </div>
            </a>
            <div class="flex items-center gap-2">
                {{-- Search Icon Mobile --}}
                <button id="open-search-mobile" class="text-white p-2 hover:bg-white/10 rounded-lg transition-colors focus:outline-none">
                    <i class="fas fa-search text-lg"></i>
                </button>

                {{-- Hamburger --}}
                <button id="mobile-menu-toggle" class="text-white p-2 hover:bg-white/10 rounded-lg transition-colors focus:outline-none">
                    <i id="menu-icon" class="fas fa-bars text-xl"></i>
                </button>
            </div>
        </div>
    </div>
</nav>

{{-- The sidebar menu for mobile, toggled by the hamburger icon. --}}
<div id="mobile-sidebar" class="fixed top-0 right-0 w-72 h-full bg-[#186862] z-[100] transform translate-x-full transition-transform duration-300 ease-in-out shadow-lg overflow-y-auto block md:hidden">
    <div class="flex items-center justify-between p-4 border-b border-white/10 h-16">
        <span class="text-white font-bold text-lg">Menu</span>
        <button id="close-sidebar" class="p-2 text-white hover:bg-white/10 rounded-full transition-colors focus:outline-none">
            <i class="fas fa-times text-xl"></i>
        </button>
    </div>
    
    <div class="py-2">
        <ul class="flex flex-col space-y-1">
            <li><a href="{{ route('home') }}" class="flex items-center text-white py-3 px-4 hover:bg-white/10 rounded-md mx-2"><i class="fas fa-home w-6 mr-2"></i><span>Beranda</span></a></li>
            
            <li class="sidebar-dropdown px-2">
                <button class="flex items-center justify-between w-full text-white py-3 px-2 hover:bg-white/10 rounded-md">
                    <div class="flex items-center"><i class="fas fa-user-tie w-6 mr-2"></i><span>Profil</span></div>
                    <i class="fas fa-chevron-down text-sm transition-transform duration-200"></i>
                </button>
                <ul class="hidden bg-white/5 mt-1 rounded-md overflow-hidden">
                    <li><a href="{{ route('pimpinan.pimpinan') }}" class="block text-white py-2.5 px-4 pl-12 hover:bg-white/10">Pimpinan DITISIP</a></li>
                    <li><a href="{{ route('profile.profile') }}" class="block text-white py-2.5 px-4 pl-12 hover:bg-white/10">Tugas Pokok dan Fungsi</a></li>
                    <li><a href="{{ route('strukturorganisasi') }}" class="block text-white py-2.5 px-4 pl-12 hover:bg-white/10">Struktur Organisasi</a></li>
                </ul>
            </li>

            <li class="sidebar-dropdown px-2">
                <button class="flex items-center justify-between w-full text-white py-3 px-2 hover:bg-white/10 rounded-md">
                    <div class="flex items-center"><i class="fas fa-sitemap w-6 mr-2"></i><span>Sub Direktorat</span></div>
                    <i class="fas fa-chevron-down text-sm transition-transform duration-200"></i>
                </button>
                <ul class="hidden bg-white/5 mt-1 rounded-md overflow-hidden">
                    <li><a href="{{ route('subdirektorat-inovasi.landingpage') }}" class="block text-white py-2.5 px-4 pl-12 hover:bg-white/10">Inovasi dan Hilirisasi</a></li>
                    <li><a href="{{ route('pemeringkatan.landing') }}" class="block text-white py-2.5 px-4 pl-12 hover:bg-white/10">Pemeringkatan dan SI</a></li>
                </ul>
            </li>

            <li><a href="{{ route('Berita.beritahome') }}" class="flex items-center text-white py-3 px-4 hover:bg-white/10 rounded-md mx-2"><i class="fas fa-newspaper w-6 mr-2"></i><span>Berita</span></a></li>

            <li class="sidebar-dropdown px-2">
                <button class="flex items-center justify-between w-full text-white py-3 px-2 hover:bg-white/10 rounded-md">
                    <div class="flex items-center"><i class="fas fa-images w-6 mr-2"></i><span>Galeri</span></div>
                    <i class="fas fa-chevron-down text-sm transition-transform duration-200"></i>
                </button>
                <ul class="hidden bg-white/5 mt-1 rounded-md overflow-hidden">
                    <li><a href="{{ route('alumni') }}" class="block text-white py-2.5 px-4 pl-12 hover:bg-white/10">Alumni Berdampak</a></li>
                    <li><a href="{{ route('galeri.sustainability') }}" class="block text-white py-2.5 px-4 pl-12 hover:bg-white/10">Sustainability</a></li>
                </ul>
            </li>

            <li><a href="{{ route('documents.public.index') }}" class="flex items-center text-white py-3 px-4 hover:bg-white/10 rounded-md mx-2"><i class="fas fa-file-alt w-6 mr-2"></i><span>Dokumen</span></a></li>
            <li><a href="https://sso.unj.ac.id/login" class="flex items-center text-white py-3 px-4 hover:bg-white/10 rounded-md mx-2"><i class="fas fa-key w-6 mr-2"></i><span>SSO</span></a></li>
            
            {{-- Mobile Language Switcher --}}
            <li class="px-2">
                <div class="flex items-center justify-center space-x-3 py-3">
                    <span class="text-white text-sm"><i class="fas fa-globe w-6 mr-2"></i>Bahasa:</span>
                    <a href="{{ route('language.switch', 'id') }}" 
                       class="text-white hover:bg-white/10 px-3 py-1 rounded {{ app()->getLocale() === 'id' ? 'bg-yellow-400 text-gray-800' : '' }}">
                        ID
                    </a>
                    <a href="{{ route('language.switch', 'en') }}" 
                       class="text-white hover:bg-white/10 px-3 py-1 rounded {{ app()->getLocale() === 'en' ? 'bg-yellow-400 text-gray-800' : '' }}">
                        EN
                    </a>
                </div>
            </li>
            
            <li><a href="#" class="flex items-center text-white py-3 px-4 hover:bg-white/10 rounded-md mx-2 login" data-bs-toggle="modal" data-bs-target="#loginModal"><i class="fas fa-sign-in-alt w-6 mr-2"></i><span>Masuk</span></a></li>
        </ul>
    </div>
</div>

<div id="sidebar-overlay" class="fixed inset-0 bg-black/60 z-40 opacity-0 pointer-events-none transition-opacity duration-300 ease-in-out block md:hidden"></div>

<style>
    input[type="search"]::-webkit-search-cancel-button {
        -webkit-appearance: none;
        appearance: none;
        display: none;
    }

    #navbar-search-input::placeholder {
        color: rgba(255, 255, 255, 0.6);
        opacity: 1;
        transition: opacity 0.3s ease;
    }

    #navbar-search-input.placeholder-fade::placeholder {
        opacity: 0.3;
    }
</style>

<script>
(function () {
    if (window.navbarScriptInitialized) {
        console.log('Navbar script sudah diinisialisasi');
        return;
    }

    window.navbarScriptInitialized = true;

    document.addEventListener('DOMContentLoaded', function () {
        console.log('Menginisialisasi navbar script');

        // =========================
        // Element References
        // =========================
        const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
        const menuIcon = document.getElementById('menu-icon');
        const mobileSidebar = document.getElementById('mobile-sidebar');
        const sidebarOverlay = document.getElementById('sidebar-overlay');
        const mobileNavbar = document.getElementById('mobile-navbar');
        const closeSidebarBtn = document.getElementById('close-sidebar');

        const searchOverlay = document.getElementById('navbar-search-overlay');
        const searchPanel = document.getElementById('navbar-search-panel');
        const openSearchButton = document.getElementById('open-search');
        const openSearchMobileButton = document.getElementById('open-search-mobile');
        const closeSearchButton = document.getElementById('close-search');
        const searchInput = document.getElementById('navbar-search-input');

        let dropdownButtons = document.querySelectorAll('.sidebar-dropdown button');

        // =========================
        // Desktop Dropdown
        // =========================
        const desktopDropdownToggles = document.querySelectorAll('.desktop-dropdown-toggle');

        desktopDropdownToggles.forEach(toggle => {
            toggle.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();

                const menu = this.nextElementSibling;

                document.querySelectorAll('.desktop-dropdown-menu').forEach(otherMenu => {
                    if (otherMenu !== menu) {
                        otherMenu.classList.add('hidden');
                    }
                });

                menu.classList.toggle('hidden');
            });
        });

        // Close desktop dropdowns when clicking outside
        window.addEventListener('click', function(e) {
            if (!e.target.closest('.desktop-dropdown-toggle')) {
                document.querySelectorAll('.desktop-dropdown-menu').forEach(menu => {
                    menu.classList.add('hidden');
                });
            }
        });

        // =========================
        // Animated Search Placeholder
        // =========================
        const placeholders = [
            'Cari Berita...',
            'Cari Produk Inovasi...',
            'Cari Program / Layanan...',
            'Cari Dokumen...'
        ];

        let placeholderIndex = 0;

        if (searchInput) {
            searchInput.setAttribute('placeholder', placeholders[0]);

            setInterval(() => {
                searchInput.classList.add('placeholder-fade');

                setTimeout(() => {
                    placeholderIndex =
                        (placeholderIndex + 1) % placeholders.length;

                    searchInput.setAttribute(
                        'placeholder',
                        placeholders[placeholderIndex]
                    );

                    searchInput.classList.remove('placeholder-fade');
                }, 300);

            }, 4000);
        }

        // =========================
        // Validation
        // =========================
        if (!mobileSidebar || !sidebarOverlay || !mobileNavbar) {
            console.warn('Navbar element tidak lengkap');
            return;
        }

        // =========================
        // Helper Functions
        // =========================
        function handleScroll() {
            if (window.scrollY > 10) {
                mobileNavbar.classList.remove('bg-transparent');
                mobileNavbar.classList.add('bg-[#186862]');
            } else {
                mobileNavbar.classList.remove('bg-[#186862]');
                mobileNavbar.classList.add('bg-transparent');
            }
        }

        function showSidebar() {
            mobileSidebar.classList.remove('translate-x-full');
            sidebarOverlay.classList.remove('opacity-0', 'pointer-events-none');
            sidebarOverlay.classList.add('opacity-50');

            if (menuIcon) {
                menuIcon.classList.remove('fa-bars');
                menuIcon.classList.add('fa-times');
            }
        }

        function hideSidebar() {
            mobileSidebar.classList.add('translate-x-full');
            sidebarOverlay.classList.add('opacity-0', 'pointer-events-none');
            sidebarOverlay.classList.remove('opacity-50');

            if (menuIcon) {
                menuIcon.classList.remove('fa-times');
                menuIcon.classList.add('fa-bars');
            }
        }

        function closeAllDropdowns() {
            dropdownButtons.forEach(button => {
                const menu = button.nextElementSibling;
                const icon = button.querySelector('i');

                if (menu) {
                    menu.classList.add('hidden');
                }

                if (icon) {
                    icon.style.transform = 'rotate(0deg)';
                }
            });
        }

        function toggleNavbarDropdown(button) {
            const dropdownMenu = button.nextElementSibling;
            const icon = button.querySelector('i, .fa-chevron-down');

            if (!dropdownMenu) return;

            const isHidden = dropdownMenu.classList.contains('hidden');

            closeAllDropdowns();

            if (isHidden) {
                dropdownMenu.classList.remove('hidden');

                if (icon) {
                    icon.style.transform = 'rotate(180deg)';
                }
            }
        }

        function openSearchOverlay() {
            if (!searchOverlay || !searchPanel) return;

            searchOverlay.classList.remove('pointer-events-none', 'opacity-0');
            searchOverlay.classList.add('opacity-100');

            searchPanel.classList.remove('opacity-0', 'scale-95');
            searchPanel.classList.add('opacity-100', 'scale-100');

            document.body.classList.add('overflow-hidden');

            if (searchInput) {
                setTimeout(() => searchInput.focus(), 150);
            }
        }

        function closeSearchOverlay() {
            if (!searchOverlay || !searchPanel) return;

            searchOverlay.classList.remove('opacity-100');
            searchOverlay.classList.add('opacity-0');

            searchPanel.classList.remove('opacity-100', 'scale-100');
            searchPanel.classList.add('opacity-0', 'scale-95');

            document.body.classList.remove('overflow-hidden');

            setTimeout(() => {
                searchOverlay.classList.add('pointer-events-none');
            }, 300);
        }

        // =========================
        // Dropdown Initialization
        // =========================
        function initDropdowns() {
            dropdownButtons.forEach(button => {
                const dropdownMenu = button.nextElementSibling;
                const icon = button.querySelector('i');

                if (dropdownMenu) {
                    dropdownMenu.classList.add('hidden');
                }

                if (icon) {
                    icon.style.transform = 'rotate(0deg)';
                }
            });
        }

        initDropdowns();

        // =========================
        // Event Listeners
        // =========================

        window.addEventListener('scroll', handleScroll);

        if (mobileMenuToggle) {
            mobileMenuToggle.addEventListener('click', function () {
                if (mobileSidebar.classList.contains('translate-x-full')) {
                    showSidebar();
                } else {
                    hideSidebar();
                }
            });
        }

        if (closeSidebarBtn) {
            closeSidebarBtn.addEventListener('click', hideSidebar);
        }

        sidebarOverlay.addEventListener('click', hideSidebar);

        dropdownButtons.forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                toggleNavbarDropdown(this);
            });
        });

        document.addEventListener('click', function (e) {
            if (!e.target.closest('.sidebar-dropdown')) {
                closeAllDropdowns();
            }
        });

        document.querySelectorAll('.sidebar-dropdown ul').forEach(menu => {
            menu.addEventListener('click', function (e) {
                e.stopPropagation();
            });
        });

        window.addEventListener('resize', function () {
            if (window.innerWidth >= 768) {
                hideSidebar();
            } else {
                handleScroll();
            }
        });

        document.querySelectorAll('#mobile-sidebar a[href]:not([data-bs-toggle])').forEach(link => {
            link.addEventListener('click', () => {
                setTimeout(hideSidebar, 100);
            });
        });

        document.querySelectorAll('#mobile-sidebar .login').forEach(loginBtn => {
            loginBtn.addEventListener('click', () => {
                setTimeout(hideSidebar, 100);
            });
        });

        if (openSearchButton) {
            openSearchButton.addEventListener('click', function (event) {
                event.preventDefault();
                openSearchOverlay();
            });
        }

        if (openSearchMobileButton) {
            openSearchMobileButton.addEventListener('click', function (event) {
                event.preventDefault();
                openSearchOverlay();
            });
        }

        if (closeSearchButton) {
            closeSearchButton.addEventListener('click', function (event) {
                event.preventDefault();
                closeSearchOverlay();
            });
        }

        if (searchOverlay) {
            searchOverlay.addEventListener('click', function (event) {
                if (event.target === searchOverlay) {
                    closeSearchOverlay();
                }
            });
        }

        // =========================
        // Initial State
        // =========================
        handleScroll();

        if (window.innerWidth < 768) {
            hideSidebar();
        }

        // Expose global function jika diperlukan
        window.showNavbarSidebar = showSidebar;
        window.hideNavbarSidebar = hideSidebar;
        window.toggleNavbarDropdown = toggleNavbarDropdown;
    });
})();
</script>