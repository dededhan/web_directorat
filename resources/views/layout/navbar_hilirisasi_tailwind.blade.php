@include('layout.loginpopup')

<!-- Desktop Navbar -->
<nav class="hidden md:flex sticky top-0 z-50 bg-[#277177] shadow-md justify-between items-center">
    <div class="container mx-auto flex justify-between items-center py-4 px-6">
        <div class="flex-shrink-0">
            <a href="{{ route('home') }}" class="flex items-center">
                <img alt="Logo Universitas" class="h-12 w-12" src="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" />
                <h1 class="text-white text-xl lg:text-2xl font-bold ml-3">Subdirektorat Inovasi dan Hilirisasi</h1>
            </a>
        </div>
        <ul class="flex items-center space-x-4 lg:space-x-6 text-white text-base">
            <li><a href="{{ route('home') }}" class="py-2 px-3 rounded-md hover:bg-white/10 transition-colors">Beranda</a></li>

            <!-- Dropdown Tentang -->
            <li class="relative">
                <button class="primary-dropdown-toggle py-2 px-3 rounded-md hover:bg-white/10 transition-colors flex items-center gap-1" data-dropdown="tentang-dropdown">
                    Tentang <i class="fas fa-chevron-down fa-xs"></i>
                </button>
                <ul id="tentang-dropdown" class="absolute left-0 mt-2 w-56 bg-white text-gray-700 rounded-md shadow-lg py-2 hidden transition-all duration-300">
                    <li><a href="{{ route('pimpinan.pimpinan') }}" class="block px-4 py-2 text-sm hover:bg-gray-100">Pimpinan Direktorat</a></li>
                    <li><a href="{{ route('strukturorganisasi') }}" class="block px-4 py-2 text-sm hover:bg-gray-100">Struktur Organisasi</a></li>
                    <li><a href="{{ route('tupoksi.tupoksi') }}" class="block px-4 py-2 text-sm hover:bg-gray-100">Tugas Pokok dan Fungsi</a></li>
                    <li><a href="{{ route('subdirektorat-inovasi.sejarah.sejarah') }}" class="block px-4 py-2 text-sm hover:bg-gray-100">Profil</a></li>
                </ul>
            </li>

            <!-- Dropdown Program -->
            <li class="relative">
                <button class="primary-dropdown-toggle py-2 px-3 rounded-md hover:bg-white/10 transition-colors flex items-center gap-1" data-dropdown="program-dropdown">
                    Program <i class="fas fa-chevron-down fa-xs"></i>
                </button>
                <ul id="program-dropdown" class="absolute left-0 mt-2 w-60 bg-white text-gray-700 rounded-md shadow-lg py-2 hidden">
                    <li><a href="{{ route('sdgscenter') }}" class="block px-4 py-2 text-sm hover:bg-gray-100">SDGs Activity</a></li>
                    <li><a href="{{ route('subdirektorat-inovasi.inkubator.inkubator_bisnis_pendidikan') }}" class="block px-4 py-2 text-sm hover:bg-gray-100">Inkubator Bisnis dan Pendidikan</a></li>
                    <li><a href="{{ route('subdirektorat-inovasi.inkubator.ekosisteminovasi') }}" class="block px-4 py-2 text-sm hover:bg-gray-100">Ekosistem Inovasi UNJ</a></li>
                    <li><a href="{{ route('subdirektorat-inovasi.inkubator.inovasiaward') }}" class="block px-4 py-2 text-sm hover:bg-gray-100">Innovator Award</a></li>
                </ul>
            </li>

            <!-- Dropdown Layanan -->
            <li class="relative">
                 <button class="primary-dropdown-toggle py-2 px-3 rounded-md hover:bg-white/10 transition-colors flex items-center gap-1" data-dropdown="layanan-dropdown">
                    Layanan <i class="fas fa-chevron-down fa-xs"></i>
                </button>
                <ul id="layanan-dropdown" class="absolute left-0 mt-2 w-64 bg-white text-gray-700 rounded-md shadow-lg py-2 hidden">
                    <li><button class="open-login-modal-btn w-full text-left block px-4 py-2 text-sm hover:bg-gray-100">Pengujian Katsinov</button></li>
                    <li><button class="open-login-modal-btn w-full text-left block px-4 py-2 text-sm hover:bg-gray-100">Pendaftaran Inkubator Bisnis</button></li>
                    <li><button class="open-login-modal-btn w-full text-left block px-4 py-2 text-sm hover:bg-gray-100">Pengujian/Sertifikasi Produk Inovasi</button></li>
                    <li><button class="open-login-modal-btn w-full text-left block px-4 py-2 text-sm hover:bg-gray-100">Join Mitra Inovasi UNJ</button></li>
                </ul>
            </li>

            <li><a href="{{ route('Berita.beritahome') }}" class="py-2 px-3 rounded-md hover:bg-white/10 transition-colors">Berita</a></li>

            <!-- Dropdown Inovasi UNJ -->
            <li class="relative">
                <button class="primary-dropdown-toggle py-2 px-3 rounded-md hover:bg-white/10 transition-colors flex items-center gap-1" data-dropdown="inovasi-dropdown">
                    Inovasi UNJ <i class="fas fa-chevron-down fa-xs"></i>
                </button>
                <ul id="inovasi-dropdown" class="absolute right-0 mt-2 w-56 bg-white text-gray-700 rounded-md shadow-lg py-2 hidden">
                    <li><a href="https://lppm.unj.ac.id/" target="_blank" rel="noopener noreferrer" class="block px-4 py-2 text-sm hover:bg-gray-100">Riset UNJ</a></li>
                    <li><a href="{{ route('subdirektorat-inovasi.riset_unj.produk_inovasi.produkinovasi') }}" class="block px-4 py-2 text-sm hover:bg-gray-100">Produk Inovasi UNJ</a></li>
                </ul>
            </li>

            <li><a href="{{ route('document.document') }}" class="py-2 px-3 rounded-md hover:bg-white/10 transition-colors">Dokumen</a></li>
            <li><a href="https://sso.unj.ac.id/login" target="_blank" rel="noopener noreferrer" class="py-2 px-3 rounded-md hover:bg-white/10 transition-colors">SSO</a></li>
            <li><button class="open-login-modal-btn py-2 px-4 rounded-md bg-yellow-400 text-gray-800 font-semibold hover:bg-yellow-500 transition-colors">Masuk</button></li>
        </ul>
    </div>
</nav>

<!-- Mobile Navbar -->
<nav id="mobile-navbar" class="md:hidden fixed top-0 w-full z-40 bg-transparent transition-colors duration-300">
    <div class="flex justify-between items-center py-4 px-4">
        <a href="{{ route('home') }}" class="flex items-center">
            <img alt="Logo Universitas" class="h-10 w-10" src="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" />
            <h1 class="text-white text-xl font-bold ml-2">UNJ</h1>
        </a>
        <button id="mobile-menu-toggle" class="text-white focus:outline-none p-2">
            <i id="menu-icon" class="fas fa-bars text-2xl"></i>
        </button>
    </div>
</nav>

<!-- Mobile Sidebar -->
<div id="mobile-sidebar" class="md:hidden fixed top-0 right-0 w-72 h-full bg-[#186862] z-50 transform translate-x-full transition-transform duration-300 ease-in-out shadow-lg overflow-y-auto">
    <div class="flex justify-between items-center p-4 border-b border-white/20">
        <h1 class="text-white text-xl font-bold">Menu</h1>
        <button id="close-sidebar" class="text-white p-2 rounded-full hover:bg-white/10">
            <i class="fas fa-times text-xl"></i>
        </button>
    </div>
    <ul class="flex flex-col py-2">
        <li><a href="{{ route('home') }}" class="block text-white py-3 px-6 text-lg hover:bg-white/10">Beranda</a></li>
        
        <!-- Dropdown Tentang -->
        <li>
            <button class="sidebar-dropdown-toggle flex justify-between items-center w-full text-white py-3 px-6 text-lg hover:bg-white/10">
                <span>Tentang</span>
                <i class="fas fa-chevron-down fa-xs transition-transform"></i>
            </button>
            <ul class="hidden bg-black/20 pl-6">
                <li><a href="{{ route('pimpinan.pimpinan') }}" class="block text-white py-3 px-6 hover:bg-white/10">Pimpinan Direktorat</a></li>
                <li><a href="{{ route('strukturorganisasi') }}" class="block text-white py-3 px-6 hover:bg-white/10">Struktur Organisasi</a></li>
                <li><a href="{{ route('tupoksi.tupoksi') }}" class="block text-white py-3 px-6 hover:bg-white/10">Tugas Pokok dan Fungsi</a></li>
                <li><a href="{{ route('subdirektorat-inovasi.sejarah.sejarah') }}" class="block text-white py-3 px-6 hover:bg-white/10">Profil</a></li>
            </ul>
        </li>

        <!-- Dropdown Program -->
         <li>
            <button class="sidebar-dropdown-toggle flex justify-between items-center w-full text-white py-3 px-6 text-lg hover:bg-white/10">
                <span>Program</span>
                <i class="fas fa-chevron-down fa-xs transition-transform"></i>
            </button>
            <ul class="hidden bg-black/20 pl-6">
                <li><a href="{{ route('sdgscenter') }}" class="block text-white py-3 px-6 hover:bg-white/10">SDGs Activity</a></li>
                <li><a href="{{ route('subdirektorat-inovasi.inkubator.inkubator_bisnis_pendidikan') }}" class="block text-white py-3 px-6 hover:bg-white/10">Inkubator Bisnis dan Pendidikan</a></li>
                <li><a href="{{ route('subdirektorat-inovasi.inkubator.ekosisteminovasi') }}" class="block text-white py-3 px-6 hover:bg-white/10">Ekosistem Inovasi UNJ</a></li>
                <li><a href="{{ route('subdirektorat-inovasi.inkubator.inovasiaward') }}" class="block text-white py-3 px-6 hover:bg-white/10">Innovator Award</a></li>
            </ul>
        </li>
        
        <!-- Dropdown Layanan -->
         <li>
            <button class="sidebar-dropdown-toggle flex justify-between items-center w-full text-white py-3 px-6 text-lg hover:bg-white/10">
                <span>Layanan</span>
                <i class="fas fa-chevron-down fa-xs transition-transform"></i>
            </button>
            <ul class="hidden bg-black/20 pl-6">
                 <li><button class="open-login-modal-btn w-full text-left block text-white py-3 px-6 hover:bg-white/10">Pengujian Katsinov</button></li>
                 <li><button class="open-login-modal-btn w-full text-left block text-white py-3 px-6 hover:bg-white/10">Pendaftaran Inkubator Bisnis</button></li>
                 <li><button class="open-login-modal-btn w-full text-left block text-white py-3 px-6 hover:bg-white/10">Pengujian/Sertifikasi Produk Inovasi</button></li>
                 <li><button class="open-login-modal-btn w-full text-left block text-white py-3 px-6 hover:bg-white/10">Join Mitra Inovasi UNJ</button></li>
            </ul>
        </li>

        <li><a href="{{ route('Berita.beritahome') }}" class="block text-white py-3 px-6 text-lg hover:bg-white/10">Berita</a></li>

        <!-- Dropdown Inovasi -->
        <li>
            <button class="sidebar-dropdown-toggle flex justify-between items-center w-full text-white py-3 px-6 text-lg hover:bg-white/10">
                <span>Inovasi UNJ</span>
                <i class="fas fa-chevron-down fa-xs transition-transform"></i>
            </button>
            <ul class="hidden bg-black/20 pl-6">
                <li><a href="https://lppm.unj.ac.id/" target="_blank" rel="noopener noreferrer" class="block text-white py-3 px-6 hover:bg-white/10">Riset UNJ</a></li>
                <li><a href="{{ route('subdirektorat-inovasi.riset_unj.produk_inovasi.produkinovasi') }}" class="block text-white py-3 px-6 hover:bg-white/10">Produk Inovasi UNJ</a></li>
            </ul>
        </li>
        
        <li><a href="{{ route('document.document') }}" class="block text-white py-3 px-6 text-lg hover:bg-white/10">Dokumen</a></li>
        <li><a href="https://sso.unj.ac.id/login" target="_blank" rel="noopener noreferrer" class="block text-white py-3 px-6 text-lg hover:bg-white/10">SSO</a></li>
        
        <li class="px-6 pt-4">
            <button class="open-login-modal-btn w-full bg-yellow-400 text-gray-800 py-2 rounded-md font-semibold hover:bg-yellow-500">
                Masuk
            </button>
        </li>
    </ul>
</div>
<div id="sidebar-overlay" class="md:hidden fixed inset-0 bg-black bg-opacity-0 pointer-events-none z-40 transition-opacity duration-300"></div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // --- Mobile Navbar Scroll Effect ---
    const mobileNavbar = document.getElementById('mobile-navbar');
    const handleScroll = () => {
        if (window.scrollY > 10) {
            mobileNavbar.classList.add('bg-[#186862]', 'shadow-md');
        } else {
            mobileNavbar.classList.remove('bg-[#186862]', 'shadow-md');
        }
    };
    window.addEventListener('scroll', handleScroll, { passive: true });
    
    // --- Mobile Sidebar Toggle ---
    const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
    const mobileSidebar = document.getElementById('mobile-sidebar');
    const sidebarOverlay = document.getElementById('sidebar-overlay');
    const closeSidebarBtn = document.getElementById('close-sidebar');
    const menuIcon = document.getElementById('menu-icon');

    const showSidebar = () => {
        mobileSidebar.classList.remove('translate-x-full');
        sidebarOverlay.classList.remove('bg-opacity-0', 'pointer-events-none');
        sidebarOverlay.classList.add('bg-opacity-50');
        menuIcon.classList.replace('fa-bars', 'fa-times');
    };

    const hideSidebar = () => {
        mobileSidebar.classList.add('translate-x-full');
        sidebarOverlay.classList.add('bg-opacity-0', 'pointer-events-none');
        sidebarOverlay.classList.remove('bg-opacity-50');
        menuIcon.classList.replace('fa-times', 'fa-bars');
    };

    mobileMenuToggle.addEventListener('click', () => {
        if (mobileSidebar.classList.contains('translate-x-full')) {
            showSidebar();
        } else {
            hideSidebar();
        }
    });
    closeSidebarBtn.addEventListener('click', hideSidebar);
    sidebarOverlay.addEventListener('click', hideSidebar);

    // --- Mobile Sidebar Dropdown (Accordion) ---
    document.querySelectorAll('.sidebar-dropdown-toggle').forEach(button => {
        button.addEventListener('click', function () {
            const dropdownMenu = this.nextElementSibling;
            const icon = this.querySelector('i');
            
            // Toggle current dropdown
            dropdownMenu.classList.toggle('hidden');
            icon.classList.toggle('rotate-180');
        });
    });

    // --- Desktop Dropdown Toggle ---
    const primaryDropdownToggles = document.querySelectorAll('.primary-dropdown-toggle');
    primaryDropdownToggles.forEach(toggle => {
        toggle.addEventListener('click', function (event) {
            event.preventDefault();
            event.stopPropagation();
            const targetId = this.dataset.dropdown;
            const targetDropdown = document.getElementById(targetId);

            const isHidden = targetDropdown.classList.contains('hidden');

            // Close all dropdowns
            document.querySelectorAll('.primary-dropdown-toggle').forEach(t => {
                document.getElementById(t.dataset.dropdown).classList.add('hidden');
                t.classList.remove('bg-white/20');
            });
            
            // If it was hidden, show it
            if (isHidden) {
                targetDropdown.classList.remove('hidden');
                this.classList.add('bg-white/20');
            }
        });
    });

    // Close desktop dropdowns when clicking outside
    document.addEventListener('click', function () {
        document.querySelectorAll('.primary-dropdown-toggle').forEach(toggle => {
            document.getElementById(toggle.dataset.dropdown).classList.add('hidden');
            toggle.classList.remove('bg-white/20');
        });
    });

    // --- Login Modal Functionality ---
    const loginModal = document.getElementById('loginModal');
    const openLoginModalButtons = document.querySelectorAll('.open-login-modal-btn');
    const closeLoginModalButtons = document.querySelectorAll('.close-login-modal-btn');

    const openModal = () => {
        if(loginModal) {
            loginModal.classList.remove('hidden');
            setTimeout(() => loginModal.classList.remove('opacity-0'), 10);
        }
    };

    const closeModal = () => {
        if(loginModal) {
            loginModal.classList.add('opacity-0');
            setTimeout(() => loginModal.classList.add('hidden'), 300);
        }
    };

    openLoginModalButtons.forEach(btn => btn.addEventListener('click', openModal));
    closeLoginModalButtons.forEach(btn => btn.addEventListener('click', closeModal));
});
</script>
