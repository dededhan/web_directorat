<style>
    /* Clean dropdown styling from navbarpemeringkatan */
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
    
    /* Responsive sidebar styles */
    #mobile-sidebar {
        overscroll-behavior: contain;
    }

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
        max-height: 500px; /* Adjust as needed */
        opacity: 1;
    }

    /* Navbar scroll fix to maintain background color */
    .navbar.scrolled {
        background-color: rgba(24, 104, 98, 0.95) !important;
        backdrop-filter: blur(10px);
        transition: background-color 0.3s ease;
        padding-top: 0.75rem;
        padding-bottom: 0.75rem;
    }
    
    /* Ensure desktop and mobile navbars have the correct color */
    .navbar.hidden.md\\:block {
        background-color: #186862 !important;
    }
    #mobile-navbar {
        background-color: #186862 !important;
    }
    .navbar:not(.scrolled) {
        background-color: #186862 !important;
    }
</style>


@include('layout.loginpopup')

<nav class="navbar hidden md:block fixed top-0 w-full z-50 bg-[#186862] shadow-l">
    <div class="container mx-auto flex justify-between items-center py-4 px-6">
       <div class="flex items-center">
            <a href="{{ route('home') }}" class="flex items-center">
            <img alt="University logo" class="h-12 w-12" src="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png"/>
            <img alt="DITISIP Logo" class="h-12 w-auto mx-2"
                src="{{ asset('images/logoditisip.png') }}"/>
            <h1 class="text-white text-2xl font-bold">Subdirektorat Inovasi dan Hilirisasi</h1>
            </a>
        </div>
        <ul class="flex space-x-6">
            <li><a href="{{ route('home') }}" class="text-white hover:text-yellow-400">Beranda</a></li>
            
            <li class="relative group">
                <a href="#" class="text-white hover:text-yellow-400">Tentang</a>
                <ul class="absolute hidden group-hover:block bg-white text-black py-2 px-4 space-y-2 rounded-lg shadow-lg">
                     <li><a href="{{ route('pimpinan.pimpinan') }}" class="hover:text-yellow-400">Pimpinan Direktorat</a></li>
                     <li><a href="{{ route('strukturorganisasi') }}" class="hover:text-yellow-400">Struktur Organisasi</a></li>
                     <li><a href="{{ route('tupoksi.tupoksi') }}" class="hover:text-yellow-400">Tugas Pokok dan Fungsi</a></li>
                     <li><a href="{{ route('subdirektorat-inovasi.sejarah.sejarah') }}" class="hover:text-yellow-400">Profil</a></li>
                 </ul>
            </li>
            
            <li class="relative group">
                <a href="#" class="text-white hover:text-yellow-400">Program</a>
                <ul class="absolute hidden group-hover:block bg-white text-black py-2 px-4 space-y-2 rounded-lg shadow-lg">
                <li><a class="hover:text-yellow-400" href="{{ route('sdgscenter') }}">SDGs Activity</a></li>
                    <li><a class="hover:text-yellow-400" href="{{ route('subdirektorat-inovasi.inkubator.inkubator_bisnis_pendidikan') }}">Inkubator Bisnis dan Pendidikan</a></li>
                    <li><a class="hover:text-yellow-400" href="{{ route('subdirektorat-inovasi.inkubator.ekosisteminovasi') }}">Ekosistem Inovasi UNJ</a></li>
                    <li><a class="hover:text-yellow-400" href="{{ route('subdirektorat-inovasi.inkubator.inovasiaward') }}">Innovator Award</a></li>
                </ul>
            </li>
            
            <li class="relative group">
                <a href="#" class="text-white hover:text-yellow-400">Layanan</a>
                <ul class="absolute hidden group-hover:block bg-white text-black py-2 px-4 space-y-2 rounded-lg shadow-lg">
                    <li><a href="#" class="login hover:text-yellow-400" data-bs-toggle="modal" data-bs-target="#loginModal">Pengujian Katsinov</a></li>
                    <li><a href="#" class="login hover:text-yellow-400" data-bs-toggle="modal" data-bs-target="#loginModal">Pendaftaran Inkubator Bisnis</a></li>
                    <li><a href="#" class="login hover:text-yellow-400" data-bs-toggle="modal" data-bs-target="#loginModal">Pengujian/Sertifikasi Produk Inovasi</a></li>
                    <li><a href="#" class="login hover:text-yellow-400" data-bs-toggle="modal" data-bs-target="#loginModal">Join Mitra Inovasi UNJ</a></li>
                </ul>
            </li>
            <li class="relative group">
                <a href="{{ route('Berita.beritahome') }}" class="text-white hover:text-yellow-400">Berita</a>
            </li>
            
            <li class="relative group">
                <a href="#" class="text-white hover:text-yellow-400">Inovasi UNJ</a>
                <ul class="absolute hidden group-hover:block bg-white text-black py-2 px-4 space-y-2 rounded-lg shadow-lg">
                    <a href="{{ route('subdirektorat-inovasi.riset.unj') }}" class="hover:text-yellow-400">Riset UNJ</a>
                    <a href="{{ route('subdirektorat-inovasi.riset_unj.produk_inovasi.produkinovasi') }}" class="hover:text-yellow-400">Produk Inovasi UNJ</a>                </ul>
            </li>
            
            <li class="relative group">
                <a href="{{ route('document.document') }}" class="text-white hover:text-yellow-400">Dokumen</a>
            </li>
            
            <li><a href="https://sso.unj.ac.id/login" class="text-white hover:text-yellow-400">SSO</a></li>
            <li><a class="login text-white" href="#" data-bs-toggle="modal" data-bs-target="#loginModal">Masuk</a></li>
        </ul>
    </div>
</nav>

<nav class="navbar bg-[#186862] md:hidden fixed top-0 w-full z-50 transition-colors duration-300" id="mobile-navbar">
    <div class="flex justify-between items-center py-4 px-4">
        <a href="{{ route('home') }}" class="flex items-center">
            <img alt="University logo" class="h-10 w-10" src="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" />
            <img alt="DITISIP Logo" class="h-10 w-auto mx-2"
                src="{{ asset('images/logoditisip.png') }}"/>
            <h1 class="text-white text-xs sm:text-sm font-bold leading-tight">Subdirektorat Inovasi dan Hilirisasi</h1>
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
                    <li><a href="{{ route('strukturorganisasi') }}" class="block text-white py-3 px-8 hover:bg-[#0e4c46] transition-colors duration-200 border-l-2 border-transparent hover:border-yellow-400">Struktur Organisasi</a></li>
                    <li><a href="{{ route('tupoksi.tupoksi') }}" class="block text-white py-3 px-8 hover:bg-[#0e4c46] transition-colors duration-200 border-l-2 border-transparent hover:border-yellow-400">Tugas Pokok dan Fungsi</a></li>
                    <li><a href="{{ route('subdirektorat-inovasi.sejarah.sejarah') }}" class="block text-white py-3 px-8 hover:bg-[#0e4c46] transition-colors duration-200 border-l-2 border-transparent hover:border-yellow-400">Profil</a></li>
                </ul>
            </li>

            <li class="sidebar-dropdown">
                <button class="sidebar-dropdown-toggle flex justify-between items-center w-full text-white py-3 px-6 text-lg hover:bg-[#125a54] transition-colors duration-200">
                    <span>Program</span>
                    <i class="fas fa-chevron-down transition-transform duration-300"></i>
                </button>
                <ul class="dropdown-content hidden bg-[#135a54] overflow-hidden">
                    <li><a href="{{ route('sdgscenter') }}" class="block text-white py-3 px-8 hover:bg-[#0e4c46] transition-colors duration-200 border-l-2 border-transparent hover:border-yellow-400">SDGs Activity</a></li>
                    <li><a href="{{ route('subdirektorat-inovasi.inkubator.inkubator_bisnis_pendidikan') }}" class="block text-white py-3 px-8 hover:bg-[#0e4c46] transition-colors duration-200 border-l-2 border-transparent hover:border-yellow-400">Inkubator Bisnis dan Pendidikan</a></li>
                    <li><a href="{{ route('subdirektorat-inovasi.inkubator.ekosisteminovasi') }}" class="block text-white py-3 px-8 hover:bg-[#0e4c46] transition-colors duration-200 border-l-2 border-transparent hover:border-yellow-400">Ekosistem Inovasi UNJ</a></li>
                    <li><a href="{{ route('subdirektorat-inovasi.inkubator.inovasiaward') }}" class="block text-white py-3 px-8 hover:bg-[#0e4c46] transition-colors duration-200 border-l-2 border-transparent hover:border-yellow-400">Innovator Award</a></li>
                </ul>
            </li>

            <li class="sidebar-dropdown">
                <button class="sidebar-dropdown-toggle flex justify-between items-center w-full text-white py-3 px-6 text-lg hover:bg-[#125a54] transition-colors duration-200">
                    <span>Layanan</span>
                    <i class="fas fa-chevron-down transition-transform duration-300"></i>
                </button>
                <ul class="dropdown-content hidden bg-[#135a54] overflow-hidden">
                    <li><a href="#" class="login block text-white py-3 px-8 hover:bg-[#0e4c46] transition-colors duration-200 border-l-2 border-transparent hover:border-yellow-400" data-bs-toggle="modal" data-bs-target="#loginModal">Pengujian Katsinov</a></li>
                    <li><a href="#" class="login block text-white py-3 px-8 hover:bg-[#0e4c46] transition-colors duration-200 border-l-2 border-transparent hover:border-yellow-400" data-bs-toggle="modal" data-bs-target="#loginModal">Pendaftaran Inkubator Bisnis</a></li>
                    <li><a href="#" class="login block text-white py-3 px-8 hover:bg-[#0e4c46] transition-colors duration-200 border-l-2 border-transparent hover:border-yellow-400" data-bs-toggle="modal" data-bs-target="#loginModal">Pengujian/Sertifikasi Produk Inovasi</a></li>
                    <li><a href="#" class="login block text-white py-3 px-8 hover:bg-[#0e4c46] transition-colors duration-200 border-l-2 border-transparent hover:border-yellow-400" data-bs-toggle="modal" data-bs-target="#loginModal">Join Mitra Inovasi UNJ</a></li>
                </ul>
            </li>

            <li><a href="{{ route('Berita.beritahome') }}" class="block text-white py-3 px-6 text-lg hover:bg-[#125a54] transition-colors duration-200">Berita</a></li>

            <li class="sidebar-dropdown">
                <button class="sidebar-dropdown-toggle flex justify-between items-center w-full text-white py-3 px-6 text-lg hover:bg-[#125a54] transition-colors duration-200">
                    <span>Inovasi UNJ</span>
                    <i class="fas fa-chevron-down transition-transform duration-300"></i>
                </button>
                <ul class="dropdown-content hidden bg-[#135a54] overflow-hidden">
                    <li><a href="https://lppm.unj.ac.id/" target="_blank" rel="noopener noreferrer" class="block text-white py-3 px-8 hover:bg-[#0e4c46] transition-colors duration-200 border-l-2 border-transparent hover:border-yellow-400">Riset UNJ</a></li>
                    <li><a href="{{ route('subdirektorat-inovasi.riset_unj.produk_inovasi.produkinovasi') }}" class="block text-white py-3 px-8 hover:bg-[#0e4c46] transition-colors duration-200 border-l-2 border-transparent hover:border-yellow-400">Produk Inovasi UNJ</a></li>
                </ul>
            </li>
            
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
    // --- Definitive Sidebar and Dropdown Logic ---

    // 1. Select all necessary elements
    const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
    const mobileSidebar = document.getElementById('mobile-sidebar');
    const sidebarOverlay = document.getElementById('sidebar-overlay');
    const closeSidebarBtn = document.getElementById('close-sidebar');
    const menuIcon = document.getElementById('menu-icon');
    const dropdownToggles = document.querySelectorAll('#mobile-sidebar .sidebar-dropdown-toggle');

    // 2. Sidebar open/close functions
    const openSidebar = () => {
        if (!mobileSidebar || !sidebarOverlay || !menuIcon) return;
        mobileSidebar.classList.remove('translate-x-full');
        sidebarOverlay.classList.remove('opacity-0', 'pointer-events-none');
        document.body.classList.add('overflow-y-hidden'); // Prevent background scroll
        menuIcon.classList.replace('fa-bars', 'fa-times');
    };

    const closeSidebar = () => {
        if (!mobileSidebar || !sidebarOverlay || !menuIcon) return;
        mobileSidebar.classList.add('translate-x-full');
        sidebarOverlay.classList.add('opacity-0', 'pointer-events-none');
        document.body.classList.remove('overflow-y-hidden');
        menuIcon.classList.replace('fa-times', 'fa-bars');
    };

    // 3. Attach event listeners for sidebar
    if (mobileMenuToggle) {
        mobileMenuToggle.addEventListener('click', (e) => {
            e.stopPropagation();
            if (mobileSidebar.classList.contains('translate-x-full')) {
                openSidebar();
            } else {
                closeSidebar();
            }
        });
    }

    if (closeSidebarBtn) {
        closeSidebarBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            closeSidebar();
        });
    }

    if (sidebarOverlay) {
        sidebarOverlay.addEventListener('click', (e) => {
            e.stopPropagation();
            closeSidebar();
        });
    }

    // 4. Attach event listeners for dropdowns (Robust Version)
    dropdownToggles.forEach(toggle => {
        toggle.addEventListener('click', function(e) {
            e.preventDefault(); // Prevent default button action
            e.stopPropagation(); // Stop click from bubbling up to other elements

            const dropdownContent = this.nextElementSibling;
            const chevronIcon = this.querySelector('i.fas');

            // Safety check
            if (!dropdownContent || !chevronIcon) {
                return;
            }

            // Get all dropdowns within the sidebar at the same level
            const allDropdownContents = this.closest('ul').querySelectorAll('.dropdown-content');

            // Close other dropdowns
            allDropdownContents.forEach(content => {
                if (content !== dropdownContent && !content.classList.contains('hidden')) {
                    content.classList.add('hidden');
                    const otherToggle = content.previousElementSibling;
                    const otherIcon = otherToggle.querySelector('i.fas');
                    if(otherIcon) otherIcon.classList.remove('rotate-180');
                }
            });

            // Toggle the clicked dropdown
            const isHidden = dropdownContent.classList.contains('hidden');
            if (isHidden) {
                dropdownContent.classList.remove('hidden');
                chevronIcon.classList.add('rotate-180');
            } else {
                dropdownContent.classList.add('hidden');
                chevronIcon.classList.remove('rotate-180');
            }
        });
    });
});
</script>