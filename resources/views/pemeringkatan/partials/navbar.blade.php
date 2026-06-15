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
    
    /* Tambahan untuk responsivitas sidebar */
    #mobile-sidebar {
        overscroll-behavior: contain; /* Mencegah body ikut scroll saat menu sidebar di-scroll sampai ujung */
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
    }

    .sidebar-dropdown .dropdown-content {
        transition: max-height 0.3s ease-in-out, opacity 0.3s ease-in-out;
        overflow: hidden;
    }

    .sidebar-dropdown .dropdown-content.hidden {
        max-height: 0;
        opacity: 0;
    }

    .sidebar-dropdown .dropdown-content:not(.hidden) {
        max-height: 500px;
        opacity: 1;
    }

    /* Fix untuk navbar scroll - memastikan background tetap teal */
    .navbar.scrolled {
        background-color: rgba(39, 113, 119, 0.95) !important; /* Menggunakan warna teal dengan opacity */
        backdrop-filter: blur(10px);
        transition: background-color 0.3s ease;
        padding-top: 0.75rem;
        padding-bottom: 0.75rem;
    }

    /* Memastikan navbar desktop tetap teal */
    .navbar.hidden.md\\:block {
        background-color: #277177 !important;
    }

    /* Memastikan navbar mobile tetap teal */
    #mobile-navbar {
        background-color: #186862 !important;
    }

    /* Override untuk memastikan tidak ada background putih */
    .navbar:not(.scrolled) {
        background-color: #277177 !important;
    }

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

<nav class="navbar hidden md:block sticky top-0 z-50 bg-[#277177] shadow-md">
    <div class="container mx-auto flex justify-between items-center py-4 px-6">
        <div class="flex items-center">
            <a href="{{ route('home') }}" class="flex items-center">
            <img alt="University logo" class="h-12 w-12"
                src="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" />
            <img alt="DITISIP Logo" class="h-12 w-auto mx-2"
                src="{{ asset('images/logoditisip.png') }}"/>
            <h1 class="text-white text-lg lg:text-xl font-bold">Subdirektorat Pemeringkatan dan Sistem Informasi</h1>
        </a>
    </div>
        <ul class="flex space-x-6 items-center">
            <li><a href="{{ route('home') }}" class="text-white hover:text-yellow-400 transition-colors duration-200">Beranda</a></li>

            <li class="relative">
                <a href="#" class="text-white hover:text-yellow-400 transition-colors duration-200 primary-dropdown-toggle" data-dropdown="tentang-dropdown">Tentang</a>
                <ul id="tentang-dropdown" class="dropdown-menu primary-dropdown hidden">
                    <li><a href="{{ route('pimpinan.pimpinan') }}">Pimpinan Direktorat</a></li>
                    <li><a href="{{ route('pemeringkatan.struktur-organisasi') }}">Struktur Organisasi</a></li>
                    <li><a href="{{ route('pemeringkatan.tupoksi') }}">Tugas Pokok dan Fungsi</a></li>
                    <li><a href="{{ route('pemeringkatan.sejarah') }}">Profil</a></li>
                </ul>
            </li>

            <li class="relative">
                <a href="#" class="text-white hover:text-yellow-400 transition-colors duration-200 primary-dropdown-toggle" data-dropdown="program-dropdown">Program</a>
                <ul id="program-dropdown" class="dropdown-menu primary-dropdown hidden">
                    <li><a href="{{ route('pemeringkatan.program.global-engagement') }}">Global Engagement</a></li>
                    <li><a href="{{ route('pemeringkatan.program.lecturer-expose') }}">Lecturer Expose</a></li>
                    <li><a href="{{ route('pemeringkatan.program.international-faculty-staff') }}">International Faculty Staff</a></li>
                    <li><a href="{{ route('pemeringkatan.program.international-student-mobility') }}">International Student Mobility</a></li>
                    
                    <li class="relative">
                        <a href="#" class="flex justify-between items-center secondary-dropdown-toggle" data-dropdown="sustainability-dropdown">
                            Sustainability
                            <i class="fas fa-chevron-right ml-2"></i>
                        </a>
                        <ul id="sustainability-dropdown" class="dropdown-menu nested-menu secondary-dropdown hidden">
                            <li><a href="{{ route('pemeringkatan.sustainability.kegiatan') }}">Kegiatan Sustainability</a></li>
                            {{-- <li><a href="{{ route('pemeringkatan.sustainability.mata-kuliah') }}">Mata Kuliah Sustainability</a></li> --}}
                            <li><a href="{{ route('pemeringkatan.sustainability.program') }}">Program Sustainability UNJ</a></li>
                            <li><a href="{{ route('pemeringkatan.sulitest.index') }}">UNJ Sustainability Literacy Test</a></li>
                        </ul>
                    </li>
                    
                    <li><a href="{{ route('pemeringkatan.data-responden.index') }}">Data Responden</a></li>
                </ul>
            </li>

            <li><a href="{{ route('pemeringkatan.ranking-unj.index') }}" class="text-white hover:text-yellow-400 transition-colors duration-200">Ranking UNJ</a></li>
            <li><a href="{{ route('the-ir.index') }}" class="text-white hover:text-yellow-400 transition-colors duration-200">THE IR</a></li>
            <li><a href="{{ route('documents.public.index') }}" class="text-white hover:text-yellow-400 transition-colors duration-200">Dokumen</a></li>
            <li><a href="https://sso.unj.ac.id/login" target="_blank" class="text-white hover:text-yellow-400 transition-colors duration-200">SSO</a></li>
            
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
            
            <li><a class="login text-white cursor-pointer hover:text-yellow-400 transition-colors duration-200" data-bs-toggle="modal" data-bs-target="#loginModal">Masuk</a></li>

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

<nav class="navbar bg-[#186862] md:hidden fixed top-0 w-full z-50 transition-colors duration-300" id="mobile-navbar">
    <div class="flex justify-between items-center py-4 px-4">
        <a href="{{ route('home') }}" class="flex items-center">
            <img alt="University logo" class="h-10 w-10" src="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" />
            <img alt="DITISIP Logo" class="h-10 w-auto mx-2"
                src="{{ asset('images/logoditisip.png') }}"/>
            <h1 class="text-white text-xs sm:text-sm font-bold leading-tight">Subdirektorat Sistem Informasi dan Pemeringkatan</h1>
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
</nav>

<div id="mobile-sidebar" class="fixed top-0 right-0 w-80 h-full bg-[#186862] z-50 transform translate-x-full transition-transform duration-300 ease-in-out shadow-lg overflow-y-auto">
    <div class="flex justify-between items-center p-4 border-b border-white/10">
        <h1 class="text-white text-xl font-bold">Menu Navigasi</h1>
        <button id="close-sidebar" class="text-white">
            <i class="fas fa-times text-2xl"></i>
        </button>
    </div>
    <div class="py-4">
        <ul class="flex flex-col">
            <li><a href="{{ route('home') }}" class="block text-white py-3 px-6 text-lg hover:bg-[#125a54] transition-colors duration-200">Beranda</a></li>
            
            <li class="sidebar-dropdown">
                <button class="sidebar-dropdown-toggle flex justify-between items-center w-full text-white py-3 px-6 text-lg hover:bg-[#125a54] transition-colors duration-200">
                    <span>Tentang</span>
                    <i class="fas fa-chevron-down transition-transform duration-300"></i>
                </button>
                <ul class="dropdown-content hidden bg-[#135a54] overflow-hidden">
                    <li><a href="{{ route('pimpinan.pimpinan') }}" class="block text-white py-3 px-8 hover:bg-[#0e4c46] transition-colors duration-200 border-l-2 border-transparent hover:border-yellow-400">Pimpinan Direktorat</a></li>
                    <li><a href="{{ route('pemeringkatan.struktur-organisasi') }}" class="block text-white py-3 px-8 hover:bg-[#0e4c46] transition-colors duration-200 border-l-2 border-transparent hover:border-yellow-400">Struktur Organisasi</a></li>
                    <li><a href="{{ route('pemeringkatan.tupoksi') }}" class="block text-white py-3 px-8 hover:bg-[#0e4c46] transition-colors duration-200 border-l-2 border-transparent hover:border-yellow-400">Tugas Pokok dan Fungsi</a></li>
                    <li><a href="{{ route('pemeringkatan.sejarah') }}" class="block text-white py-3 px-8 hover:bg-[#0e4c46] transition-colors duration-200 border-l-2 border-transparent hover:border-yellow-400">Profil</a></li>
                </ul>
            </li>

            <li class="sidebar-dropdown">
                <button class="sidebar-dropdown-toggle flex justify-between items-center w-full text-white py-3 px-6 text-lg hover:bg-[#125a54] transition-colors duration-200">
                    <span>Program</span>
                    <i class="fas fa-chevron-down transition-transform duration-300"></i>
                </button>
                <ul class="dropdown-content hidden bg-[#135a54] overflow-hidden">
                    <li><a href="{{ route('pemeringkatan.program.global-engagement') }}" class="block text-white py-3 px-8 hover:bg-[#0e4c46] transition-colors duration-200 border-l-2 border-transparent hover:border-yellow-400">Global Engagement</a></li>
                    <li><a href="{{ route('pemeringkatan.program.lecturer-expose') }}" class="block text-white py-3 px-8 hover:bg-[#0e4c46] transition-colors duration-200 border-l-2 border-transparent hover:border-yellow-400">Lecturer Expose</a></li>
                    <li><a href="{{ route('pemeringkatan.program.international-faculty-staff') }}" class="block text-white py-3 px-8 hover:bg-[#0e4c46] transition-colors duration-200 border-l-2 border-transparent hover:border-yellow-400">International Faculty Staff</a></li>
                    <li><a href="{{ route('pemeringkatan.program.international-student-mobility') }}" class="block text-white py-3 px-8 hover:bg-[#0e4c46] transition-colors duration-200 border-l-2 border-transparent hover:border-yellow-400">International Student Mobility</a></li>
                    
                    <li class="sidebar-dropdown nested-dropdown">
                        <button class="sidebar-dropdown-toggle flex justify-between items-center w-full text-white py-3 px-8 hover:bg-[#0e4c46] transition-colors duration-200 border-l-2 border-transparent hover:border-yellow-400">
                            <span>Sustainability</span>
                            <i class="fas fa-chevron-down transition-transform duration-300"></i>
                        </button>
                        <ul class="dropdown-content hidden bg-[#0d4540] overflow-hidden">
                            <li><a href="{{ route('pemeringkatan.sustainability.kegiatan') }}" class="block text-white py-3 px-10 hover:bg-[#0a3c38] transition-colors duration-200 border-l-2 border-transparent hover:border-yellow-400">Kegiatan Sustainability</a></li>
                            {{-- <li><a href="{{ route('pemeringkatan.sustainability.mata-kuliah') }}" class="block text-white py-3 px-10 hover:bg-[#0a3c38] transition-colors duration-200 border-l-2 border-transparent hover:border-yellow-400">Mata Kuliah Sustainability</a></li> --}}
                            <li><a href="{{ route('pemeringkatan.sustainability.program') }}" class="block text-white py-3 px-10 hover:bg-[#0a3c38] transition-colors duration-200 border-l-2 border-transparent hover:border-yellow-400">Program Sustainability UNJ</a></li>
                            <li><a href="{{ route('pemeringkatan.sulitest.index') }}" class="block text-white py-3 px-10 hover:bg-[#0a3c38] transition-colors duration-200 border-l-2 border-transparent hover:border-yellow-400">Sulitest</a></li>
                        </ul>
                    </li>
                    
                    <li><a href="{{ route('pemeringkatan.data-responden.index') }}" class="block text-white py-3 px-8 hover:bg-[#0e4c46] transition-colors duration-200 border-l-2 border-transparent hover:border-yellow-400">Data Responden</a></li>
                </ul>
            </li>

            <li><a href="{{ route('pemeringkatan.ranking-unj.index') }}" class="block text-white py-3 px-6 text-lg hover:bg-[#125a54] transition-colors duration-200">Ranking UNJ</a></li>
            <li><a href="{{ route('the-ir.index') }}" class="block text-white py-3 px-6 text-lg hover:bg-[#125a54] transition-colors duration-200">THE IR</a></li>
            <li><a href="{{ route('documents.public.index') }}" class="block text-white py-3 px-6 text-lg hover:bg-[#125a54] transition-colors duration-200">Dokumen</a></li>
            
            <li><a href="https://sso.unj.ac.id/login" target="_blank" class="block text-white py-3 px-6 text-lg hover:bg-[#125a54] transition-colors duration-200">SSO</a></li>

            {{-- Mobile Language Switcher --}}
            <li class="px-6">
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

            <li class="px-6 my-4">
                <button class="login block w-full text-center bg-white text-[#186862] py-2 rounded-md font-medium hover:bg-yellow-400 hover:text-[#186862] transition-colors duration-200" data-bs-toggle="modal" data-bs-target="#loginModal">
                    Masuk
                </button>
            </li>
        </ul>
    </div>
</div>

<div id="sidebar-overlay" class="fixed inset-0 bg-black/50 z-40 opacity-0 pointer-events-none transition-opacity duration-300 ease-in-out"></div>


<script>
document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
    const mobileSidebar = document.getElementById('mobile-sidebar');
    const sidebarOverlay = document.getElementById('sidebar-overlay');
    const closeSidebarBtn = document.getElementById('close-sidebar');
    const menuIcon = document.getElementById('menu-icon');
    const searchOverlay = document.getElementById('navbar-search-overlay');
    const searchPanel = document.getElementById('navbar-search-panel');
    const openSearchButton = document.getElementById('open-search');
    const openSearchMobileButton = document.getElementById('open-search-mobile');
    const closeSearchButton = document.getElementById('close-search');
    const searchInput = document.getElementById('navbar-search-input');

    const openSidebar = () => {
        if (mobileSidebar && sidebarOverlay) {
            mobileSidebar.classList.remove('translate-x-full');
            sidebarOverlay.classList.add('opacity-100');
            sidebarOverlay.classList.remove('pointer-events-none');
            document.body.classList.add('overflow-y-hidden');
            menuIcon.classList.replace('fa-bars', 'fa-times');
        }
    };

    const closeSidebar = () => {
        if (mobileSidebar && sidebarOverlay) {
            mobileSidebar.classList.add('translate-x-full');
            sidebarOverlay.classList.remove('opacity-100');
            sidebarOverlay.classList.add('pointer-events-none');
            document.body.classList.remove('overflow-y-hidden');
            menuIcon.classList.replace('fa-times', 'fa-bars');
        }
    };

    if (mobileMenuToggle) {
        mobileMenuToggle.addEventListener('click', () => {
            if (mobileSidebar.classList.contains('translate-x-full')) {
                openSidebar();
            } else {
                closeSidebar();
            }
        });
    }

    if (closeSidebarBtn) {
        closeSidebarBtn.addEventListener('click', closeSidebar);
    }

    if (sidebarOverlay) {
        sidebarOverlay.addEventListener('click', closeSidebar);
    }

    function initSidebarDropdowns() {
        const dropdownToggles = document.querySelectorAll('.sidebar-dropdown-toggle');
        
        dropdownToggles.forEach(toggle => {
            toggle.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                const dropdownContent = this.nextElementSibling;
                const chevronIcon = this.querySelector('i.fa-chevron-down');
                const isCurrentlyOpen = !dropdownContent.classList.contains('hidden');
                
                const parentLevel = this.closest('ul');
                const siblingDropdowns = parentLevel.querySelectorAll(':scope > .sidebar-dropdown > .dropdown-content');
                const siblingIcons = parentLevel.querySelectorAll(':scope > .sidebar-dropdown > .sidebar-dropdown-toggle > i.fa-chevron-down');
                
                siblingDropdowns.forEach(dropdown => {
                    if (dropdown !== dropdownContent) {
                        dropdown.classList.add('hidden');
                    }
                });
                
                siblingIcons.forEach(icon => {
                    if (icon !== chevronIcon) {
                        icon.classList.remove('rotate-180');
                    }
                });
                
                if (isCurrentlyOpen) {
                    dropdownContent.classList.add('hidden');
                    chevronIcon.classList.remove('rotate-180');
                    
                    const nestedDropdowns = dropdownContent.querySelectorAll('.dropdown-content');
                    const nestedIcons = dropdownContent.querySelectorAll('.sidebar-dropdown-toggle > i.fa-chevron-down');
                    
                    nestedDropdowns.forEach(nested => nested.classList.add('hidden'));
                    nestedIcons.forEach(icon => icon.classList.remove('rotate-180'));
                } else {
                    dropdownContent.classList.remove('hidden');
                    chevronIcon.classList.add('rotate-180');
                }
            });
        });
    }

    initSidebarDropdowns();

    const primaryToggles = document.querySelectorAll('.primary-dropdown-toggle');
    primaryToggles.forEach(toggle => {
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const targetId = this.getAttribute('data-dropdown');
            const targetDropdown = document.getElementById(targetId);
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
            this.closest('.primary-dropdown').querySelectorAll('.secondary-dropdown').forEach(dropdown => {
                if (dropdown.id !== targetId) dropdown.classList.add('hidden');
            });
            targetDropdown.classList.toggle('hidden');
        });
    });

    document.addEventListener('click', function(e) {
        if (!e.target.closest('.relative')) {
            document.querySelectorAll('.primary-dropdown, .secondary-dropdown').forEach(dropdown => {
                dropdown.classList.add('hidden');
            });
        }
    });

    document.querySelectorAll('.dropdown-menu').forEach(menu => {
        menu.addEventListener('click', e => e.stopPropagation());
    });

    document.querySelectorAll('#mobile-sidebar a[href]:not([data-bs-toggle])').forEach(link => {
        link.addEventListener('click', () => {
            setTimeout(closeSidebar, 100);
        });
    });

    document.querySelectorAll('#mobile-sidebar .login').forEach(loginBtn => {
        loginBtn.addEventListener('click', () => {
            setTimeout(closeSidebar, 100);
        });
    });

    function openSearchOverlay() {
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
        searchOverlay.classList.remove('opacity-100');
        searchOverlay.classList.add('opacity-0');

        searchPanel.classList.remove('opacity-100', 'scale-100');
        searchPanel.classList.add('opacity-0', 'scale-95');

        document.body.classList.remove('overflow-hidden');

        setTimeout(() => {
            searchOverlay.classList.add('pointer-events-none');
        }, 300);
    }

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

    if (openSearchButton) {
        openSearchButton.addEventListener('click', function(e) {
            e.preventDefault();
            openSearchOverlay();
        });
    }

    if (openSearchMobileButton) {
        openSearchMobileButton.addEventListener('click', function(e) {
            e.preventDefault();
            openSearchOverlay();
        });
    }

    if (closeSearchButton) {
        closeSearchButton.addEventListener('click', function(e) {
            e.preventDefault();
            closeSearchOverlay();
        });
    }

    if (searchOverlay) {
        searchOverlay.addEventListener('click', function(e) {
            if (e.target === searchOverlay) {
                closeSearchOverlay();
            }
        });
    }
});
</script>
