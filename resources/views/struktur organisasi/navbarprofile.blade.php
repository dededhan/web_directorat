@include('loginpopup')

<!-- Desktop Navbar - Sticky -->
<nav class="navbar hidden md:block sticky top-0 z-50 bg-[#186862] shadow-md">
    <div class="container mx-auto flex items-center py-2 px-6">
        <!-- Logo and Title Section -->
        <a href="{{ route('home') }}" class="flex items-center">
            <img alt="University logo" class="h-10 w-10"
                src="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" />
            <div class="ml-4">
                <h1 class="text-xl font-bold uppercase tracking-wide text-white">DIREKTORAT INOVASI, SISTEM INFORMASI, DAN PEMERINGKATAN</h1>
            </div>
        </a>
        
        <!-- Navigation Items - Right aligned -->
        <ul class="flex space-x-6 ml-auto">
            <li><a href="{{ route('home') }}" class="text-white hover:text-yellow-400 text-sm">Beranda</a></li>

            <li class="relative group">
                <a href="#" class="text-white hover:text-yellow-400 text-sm">Profil</a>
                <ul
                    class="absolute hidden group-hover:block bg-white text-black py-2 px-4 space-y-2 rounded-lg shadow-lg">
                    <li><a href="{{ route('profile.profile') }}" class="text-black hover:text-yellow-400 text-sm">Tugas Pokok dan Fungsi</a></li>
                    <li><a href="{{ route('strukturorganisasi') }}" class="text-black hover:text-yellow-400 text-sm">Struktur Organisasi</a></li>
                </ul>
            </li>

            <li class="relative group">
                <a href="#" class="text-white hover:text-yellow-400 text-sm">Sub Direktorat</a>
                <ul
                    class="absolute hidden group-hover:block bg-white text-black py-2 px-4 space-y-2 rounded-lg shadow-lg">
                    <li><a href="{{ route('inovasi.landingpage') }}" class="text-black hover:text-yellow-400 text-sm">Subdirektorat Inovasi dan Hilirisasi</a></li>
                    <li><a href="{{ route('pemeringkatan.landingpage') }}" class="text-black hover:text-yellow-400 text-sm">Subdirektorat Pemeringkatan dan Sistem Informasi</a></li>
                </ul>
            </li>

            <li><a href="{{ route('Berita.beritahome') }}" class="text-white hover:text-yellow-400 text-sm">Berita</a></li>

            <li class="relative group">
                <a href="#" class="text-white hover:text-yellow-400 text-sm">Galeri</a>
                <ul
                    class="absolute hidden group-hover:block bg-white text-black py-2 px-4 space-y-2 rounded-lg shadow-lg">
                    <li><a href="{{ route('alumni') }}" class="text-black hover:text-yellow-400 text-sm">Alumni Berdampak</a></li>
                    <li><a href="{{ route('galeri.sustainability') }}" class="text-black hover:text-yellow-400 text-sm">Sustainability</a></li>
                </ul>
            </li>

            <li><a href="{{ route('document.document') }}" class="text-white hover:text-yellow-400 text-sm">Dokumen</a></li>
            <li><a href="https://sso.unj.ac.id/login" class="text-white hover:text-yellow-400 text-sm">SSO</a></li>
            <li><a class="login text-white text-sm" href="#" data-bs-toggle="modal" data-bs-target="#loginModal">Masuk</a></li>
        </ul>
    </div>
</nav>

<!-- Mobile Navigation Bar - Sticky -->
<nav class="navbar md:hidden fixed top-0 w-full z-20 bg-[#186862] shadow-md" id="mobile-navbar">
    <div class="relative">
        <!-- Content -->
        <div class="flex justify-between items-center py-4 px-4">
            <!-- Logo and University Name -->
            <div class="flex items-center">
                <img alt="University logo" class="h-10 w-10"
                    src="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" />
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
<div id="mobile-sidebar"
    class="fixed top-0 right-0 w-64 h-full bg-[#186862] z-40 transform translate-x-full transition-transform duration-300 ease-in-out shadow-lg overflow-y-auto">
    <!-- Sidebar Header -->
    <div class="flex justify-between items-center p-4">
        <div class="flex items-center">
            <img alt="University logo" class="h-8 w-8"
                src="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" />
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
                    <button
                        class="flex justify-between items-center w-full text-white py-3 px-6 text-lg hover:bg-[#125a54]">
                        Sub Direktorat
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <ul class="hidden bg-[#135a54]">
                        <li>
                            <a href="{{ route('inovasi.landingpage') }}" class="block text-white py-3 px-6 hover:bg-[#0e4c46]">
                                Subdirektorat Inovasi dan Hilirisasi
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('pemeringkatan.landingpage') }}" class="block text-white py-3 px-6 hover:bg-[#0e4c46]">
                                Subdirektorat Pemeringkatan dan Sistem Informasi
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li>
                <div class="sidebar-dropdown">
                    <button
                        class="flex justify-between items-center w-full text-white py-3 px-6 text-lg hover:bg-[#125a54]">
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
                            <a href="{{ route('profile.profile') }}" class="block text-white py-3 px-6 hover:bg-[#0e4c46]">
                                Tugas Pokok dan Fungsi
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
                    <button
                        class="flex justify-between items-center w-full text-white py-3 px-6 text-lg hover:bg-[#125a54]">
                        Galeri
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <ul class="hidden bg-[#135a54]">
                        <li>
                            <a href="{{ route('alumni') }}" class="block text-white py-3 px-6 hover:bg-[#0e4c46]">
                                Alumni Berdampak
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('galeri.sustainability') }}" class="block text-white py-3 px-6 hover:bg-[#0e4c46]">
                                Sustainability
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li>
                <a href="{{ route('document.document') }}" class="block text-white py-3 px-6 text-lg hover:bg-[#125a54]">
                    Dokumen
                </a>
            </li>

            <li>
                <a href="https://sso.unj.ac.id/login" class="block text-white py-3 px-6 text-lg hover:bg-[#125a54]">
                    SSO
                </a>
            </li>

            <li class="px-6 my-6">
                <a href="#" class="block text-center bg-white text-[#186862] py-2 rounded-sm font-medium w-20"
                    data-bs-toggle="modal" data-bs-target="#loginModal">
                    Masuk
                </a>
            </li>
        </ul>
    </div>
</div>

<!-- Overlay for sidebar - Only on mobile -->
<div id="sidebar-overlay"
    class="fixed inset-0 bg-black opacity-0 md:hidden pointer-events-none transition-opacity duration-300 ease-in-out z-30">
</div>

<!-- JavaScript for mobile sidebar -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
        const menuIcon = document.getElementById('menu-icon');
        const mobileSidebar = document.getElementById('mobile-sidebar');
        const sidebarOverlay = document.getElementById('sidebar-overlay');
        const dropdownButtons = document.querySelectorAll('.sidebar-dropdown button');

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

        // Set the active menu item based on current URL
        function setActiveMenuItem() {
            // For desktop menu
            const navLinks = document.querySelectorAll('nav ul li a');
            const currentPath = window.location.pathname;

            navLinks.forEach(link => {
                const href = link.getAttribute('href');
                if (href && currentPath.includes(href) && href !== '#') {
                    link.classList.add('text-yellow-400');
                    link.classList.add('font-bold');
                }
            });

            // For mobile menu
            const mobileLinks = document.querySelectorAll('#mobile-sidebar a');
            mobileLinks.forEach(link => {
                const href = link.getAttribute('href');
                if (href && currentPath.includes(href) && href !== '#') {
                    link.classList.add('text-yellow-400');
                    link.classList.add('font-bold');
                }
            });
        }

        // Call functions on page load
        hideSidebar();
        setActiveMenuItem();

        // Handle window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 768) {
                // Desktop view - hide mobile elements
                hideSidebar();
            }
        });
    });
</script>