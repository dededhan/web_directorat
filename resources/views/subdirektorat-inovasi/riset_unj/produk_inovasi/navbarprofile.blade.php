<!-- Include login popup -->
@include('loginpopup')

<!-- Desktop Navbar -->
<nav class="navbar hidden md:block" style="background-color: rgba(23, 99, 105, 0.9);">
    <div class="container mx-auto flex justify-between items-center py-4 px-6">
        <div class="flex items-center space-x-4">
            <a href="{{ route('home') }}">
                <img alt="University logo" class="h-12 w-12" src="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png"/>
            </a>
            <h1 class="text-white text-2xl font-bold">Subdirektorat Inovasi dan Hilirisasi</h1>
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
                    <li><a href="{{ route('sdgscenter') }}" class="hover:text-yellow-400">SDGs Center</a></li>
                    <li><a href="#" class="hover:text-yellow-400">Inkubator Bisnis dan Pendidikan</a></li>
                    <li><a href="#" class="hover:text-yellow-400">Ekosistem Inovasi UNJ</a></li>
                    <li><a href="#" class="hover:text-yellow-400">Innovator Award</a></li>
                </ul>
            </li>
            
            <li class="relative group">
                <a href="#" class="text-white hover:text-yellow-400">Layanan</a>
                <ul class="absolute hidden group-hover:block bg-white text-black py-2 px-4 space-y-2 rounded-lg shadow-lg">
                    <li><a href="#" class="hover:text-yellow-400">Pengujian Katsinov</a></li>
                    <li><a href="#" class="hover:text-yellow-400">Pendaftaran Inkubator Bisnis</a></li>
                    <li><a href="#" class="hover:text-yellow-400">Pengujian/Sertifikasi Produk Inovasi</a></li>
                    <li><a href="#" class="hover:text-yellow-400">Join Mitra Inovasi UNJ</a></li>
                </ul>
            </li>
            
            <li class="relative group">
                <a href="{{ route('Berita.beritahome') }}" class="text-white hover:text-yellow-400">Berita</a>
            </li>
            
            <li class="relative group">
                <a href="#" class="text-white hover:text-yellow-400">Inovasi UNJ</a>
                <ul class="absolute hidden group-hover:block bg-white text-black py-2 px-4 space-y-2 rounded-lg shadow-lg">
                    <li><a href="{{ route('riset.unj') }}" class="hover:text-yellow-400">Riset UNJ</a></li>
                    <li><a href="{{ route('subdirektorat-inovasi.riset_unj.produk_inovasi.produkinovasi') }}" class="hover:text-yellow-400">Produk Inovasi UNJ</a></li>
                </ul>
            </li>
            
            <li class="relative group">
                <a href="{{ route('document.document') }}" class="text-white hover:text-yellow-400">Dokumen</a>
            </li>
            
            <li><a href="https://sso.unj.ac.id/login" class="text-white hover:text-yellow-400">SSO</a></li>
            <li><a class="login text-white" href="#" data-bs-toggle="modal" data-bs-target="#loginModal">Masuk</a></li>
        </ul>
    </div>
</nav>

<!-- Mobile Navigation Bar -->
<nav class="navbar bg-[#176369] md:hidden fixed top-0 w-full z-20 transition-colors duration-300" id="mobile-navbar">
    <div class="relative">
        <div class="flex justify-between items-center py-4 px-4">
            <div class="flex items-center">
                <img alt="University logo" class="h-10 w-10" src="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png"/>
                <h1 class="text-white text-xl font-bold ml-2">UNJ</h1>
            </div>
            
            <button id="mobile-menu-toggle" class="text-white focus:outline-none">
                <i id="menu-icon" class="fas fa-bars text-2xl"></i>
            </button>
        </div>
    </div>
</nav>

<!-- Mobile Sidebar -->
<div id="mobile-sidebar" class="fixed top-0 right-0 w-64 h-full bg-[#186862] z-40 transform translate-x-full md:translate-x-full transition-transform duration-300 ease-in-out shadow-lg overflow-y-auto">
    <!-- Sidebar Header -->
    <div class="flex justify-between items-center p-4">
        <div class="flex items-center">
            <img alt="University logo" class="h-8 w-8" src="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png"/>
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
                <a href="{{ route('home') }}" class="block text-white py-3 px-6 text-lg hover:bg-[#125a54]">
                    Beranda
                </a>
            </li>
            
            <li>
                <div class="sidebar-dropdown">
                    <button class="flex justify-between items-center w-full text-white py-3 px-6 text-lg hover:bg-[#125a54]">
                        Profil
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <ul class="hidden bg-[#135a54]">
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
                    </ul>
                </div>
            </li>
            
            <li>
                <div class="sidebar-dropdown">
                    <button class="flex justify-between items-center w-full text-white py-3 px-6 text-lg hover:bg-[#125a54]">
                        Program
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <ul class="hidden bg-[#135a54]">
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
            
            <li>
                <div class="sidebar-dropdown">
                    <button class="flex justify-between items-center w-full text-white py-3 px-6 text-lg hover:bg-[#125a54]">
                        Layanan
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <ul class="hidden bg-[#135a54]">
                        <li>
                            <a href="#" class="block text-white py-3 px-6 hover:bg-[#0e4c46]">
                                Pengujian Kasinov
                            </a>
                        </li>
                        <li>
                            <a href="#" class="block text-white py-3 px-6 hover:bg-[#0e4c46]">
                                Pendaftaran Inkubisnis
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
                <div class="sidebar-dropdown">
                    <button class="flex justify-between items-center w-full text-white py-3 px-6 text-lg hover:bg-[#125a54]">
                        Dokumen
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <ul class="hidden bg-[#135a54]">
                        <li>
                            <a href="{{ route('document.document') }}" class="block text-white py-3 px-6 hover:bg-[#0e4c46]">
                                Repository
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

<!-- Overlay for sidebar -->
<div id="sidebar-overlay" class="fixed inset-0 bg-black opacity-0 md:hidden pointer-events-none transition-opacity duration-300 ease-in-out z-30"></div>

<!-- JavaScript for mobile sidebar -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
        const menuIcon = document.getElementById('menu-icon');
        const mobileSidebar = document.getElementById('mobile-sidebar');
        const sidebarOverlay = document.getElementById('sidebar-overlay');
        const mobileNavbar = document.getElementById('mobile-navbar');
        const closeSidebar = document.getElementById('close-sidebar');
        const dropdownButtons = document.querySelectorAll('.sidebar-dropdown button');
        
        // Function to handle scroll effects
        function handleScroll() {
            if (window.scrollY > 10) {
                // When scrolled, add background color
                mobileNavbar.classList.remove('bg-transparent');
                mobileNavbar.classList.add('bg-[#176369]');
            } else {
                // When at top, make transparent
                mobileNavbar.classList.remove('bg-[#176369]');
                mobileNavbar.classList.add('bg-transparent');
            }
        }
        
        // Add scroll event listener
        window.addEventListener('scroll', handleScroll);
        
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
        if (mobileMenuToggle) {
            mobileMenuToggle.addEventListener('click', function() {
                if (mobileSidebar.classList.contains('translate-x-full')) {
                    showSidebar();
                } else {
                    hideSidebar();
                }
            });
        }
        
        // Close sidebar when X button is clicked
        if (closeSidebar) {
            closeSidebar.addEventListener('click', hideSidebar);
        }
        
        // Close sidebar when clicking overlay
        if (sidebarOverlay) {
            sidebarOverlay.addEventListener('click', hideSidebar);
        }
        
        // Toggle dropdowns in sidebar
        dropdownButtons.forEach(button => {
            button.addEventListener('click', function() {
                const dropdownMenu = this.nextElementSibling;
                const icon = this.querySelector('i');
                
                // Close all other dropdowns first
                dropdownButtons.forEach(otherButton => {
                    if (otherButton !== button) {
                        const otherMenu = otherButton.nextElementSibling;
                        const otherIcon = otherButton.querySelector('i');
                        if (!otherMenu.classList.contains('hidden')) {
                            otherMenu.classList.add('hidden');
                            otherIcon.classList.remove('fa-chevron-up');
                            otherIcon.classList.add('fa-chevron-down');
                        }
                    }
                });
                
                // Toggle current dropdown
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
        
        // Initialize mobile navigation
        handleScroll();
    });
</script>