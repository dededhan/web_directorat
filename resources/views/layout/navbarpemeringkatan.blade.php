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
</style>

@include('layout.loginpopup')

<nav class="navbar hidden md:block sticky top-0 z-50 bg-[#277177] shadow-md">
    <div class="container mx-auto flex justify-between items-center py-4 px-6">
        <div class="flex items-center">
            <a href="{{ route('home') }}" class="flex items-center">
            <img alt="University logo" class="h-12 w-12"
                src="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" />
            <img alt="DITISIP Logo" class="h-12 w-auto mx-2"
                src="{{ asset('images/logoditisip.png') }}"/>
            <h1 class="text-white text-xl lg:text-2xl font-bold">Subdirektorat Pemeringkatan dan Sistem Informasi</h1>
        </a>
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
                            <li><a href="{{ route('Pemeringkatan.sulitest.index') }}">UNJ Sustainability Literacy Test</a></li>
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

<nav class="navbar bg-[#186862] md:hidden fixed top-0 w-full z-50 transition-colors duration-300" id="mobile-navbar">
    <div class="flex justify-between items-center py-4 px-4">
        <a href="{{ route('home') }}" class="flex items-center">
            <img alt="University logo" class="h-10 w-10" src="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" />
            <img alt="DITISIP Logo" class="h-10 w-auto mx-2"
                src="{{ asset('images/logoditisip.png') }}"/>
            <h1 class="text-white text-xs sm:text-sm font-bold leading-tight">Subdirektorat Sistem Informasi dan Pemeringkatan</h1>
        </a>
        <button id="mobile-menu-toggle" class="text-white focus:outline-none z-50">
            <i id="menu-icon" class="fas fa-bars text-2xl"></i>
        </button>
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
                    <li><a href="{{ route('strukturorganisasipemeringkatan') }}" class="block text-white py-3 px-8 hover:bg-[#0e4c46] transition-colors duration-200 border-l-2 border-transparent hover:border-yellow-400">Struktur Organisasi</a></li>
                    <li><a href="{{ route('tupoksipemeringkatan') }}" class="block text-white py-3 px-8 hover:bg-[#0e4c46] transition-colors duration-200 border-l-2 border-transparent hover:border-yellow-400">Tugas Pokok dan Fungsi</a></li>
                    <li><a href="{{ route('Pemeringkatan.sejarah.sejarah') }}" class="block text-white py-3 px-8 hover:bg-[#0e4c46] transition-colors duration-200 border-l-2 border-transparent hover:border-yellow-400">Profil</a></li>
                </ul>
            </li>

            <li class="sidebar-dropdown">
                <button class="sidebar-dropdown-toggle flex justify-between items-center w-full text-white py-3 px-6 text-lg hover:bg-[#125a54] transition-colors duration-200">
                    <span>Program</span>
                    <i class="fas fa-chevron-down transition-transform duration-300"></i>
                </button>
                <ul class="dropdown-content hidden bg-[#135a54] overflow-hidden">
                    <li><a href="{{ route('Pemeringkatan.program.global-engagement') }}" class="block text-white py-3 px-8 hover:bg-[#0e4c46] transition-colors duration-200 border-l-2 border-transparent hover:border-yellow-400">Global Engagement</a></li>
                    <li><a href="{{ route('Pemeringkatan.program.lecturer-expose') }}" class="block text-white py-3 px-8 hover:bg-[#0e4c46] transition-colors duration-200 border-l-2 border-transparent hover:border-yellow-400">Lecturer Expose</a></li>
                    <li><a href="{{ route('Pemeringkatan.program.international-faculty-staff') }}" class="block text-white py-3 px-8 hover:bg-[#0e4c46] transition-colors duration-200 border-l-2 border-transparent hover:border-yellow-400">International Faculty Staff</a></li>
                    <li><a href="{{ route('Pemeringkatan.program.international-student-mobility') }}" class="block text-white py-3 px-8 hover:bg-[#0e4c46] transition-colors duration-200 border-l-2 border-transparent hover:border-yellow-400">International Student Mobility</a></li>
                    
                    <li class="sidebar-dropdown nested-dropdown">
                        <button class="sidebar-dropdown-toggle flex justify-between items-center w-full text-white py-3 px-8 hover:bg-[#0e4c46] transition-colors duration-200 border-l-2 border-transparent hover:border-yellow-400">
                            <span>Sustainability</span>
                            <i class="fas fa-chevron-down transition-transform duration-300"></i>
                        </button>
                        <ul class="dropdown-content hidden bg-[#0d4540] overflow-hidden">
                            <li><a href="{{ route('Pemeringkatan.kegiatansustainability.kegiatansustainability') }}" class="block text-white py-3 px-10 hover:bg-[#0a3c38] transition-colors duration-200 border-l-2 border-transparent hover:border-yellow-400">Kegiatan Sustainability</a></li>
                            <li><a href="{{ route('Pemeringkatan.matakuliahsustainability.matakuliahsustainability') }}" class="block text-white py-3 px-10 hover:bg-[#0a3c38] transition-colors duration-200 border-l-2 border-transparent hover:border-yellow-400">Mata Kuliah Sustainability</a></li>
                            <li><a href="{{ route('Pemeringkatan.programsustainability.programsustainability') }}" class="block text-white py-3 px-10 hover:bg-[#0a3c38] transition-colors duration-200 border-l-2 border-transparent hover:border-yellow-400">Program Sustainability UNJ</a></li>
                            <li><a href="{{ route('Pemeringkatan.sulitest.index') }}" class="block text-white py-3 px-10 hover:bg-[#0a3c38] transition-colors duration-200 border-l-2 border-transparent hover:border-yellow-400">Sulitest</a></li>
                        </ul>
                    </li>
                    
                    <li><a href="{{ route('Pemeringkatan.dataresponden.dataresponden') }}" class="block text-white py-3 px-8 hover:bg-[#0e4c46] transition-colors duration-200 border-l-2 border-transparent hover:border-yellow-400">Data Responden</a></li>
                </ul>
            </li>
            
            <li><a href="{{ route('Pemeringkatan.ranking_unj.rankingunj') }}" class="block text-white py-3 px-6 text-lg hover:bg-[#125a54] transition-colors duration-200">Ranking UNJ</a></li>
            <li><a href="{{ route('document.document') }}" class="block text-white py-3 px-6 text-lg hover:bg-[#125a54] transition-colors duration-200">Dokumen</a></li>
            <li><a href="https://sso.unj.ac.id/login" target="_blank" class="block text-white py-3 px-6 text-lg hover:bg-[#125a54] transition-colors duration-200">SSO</a></li>

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
});
</script>