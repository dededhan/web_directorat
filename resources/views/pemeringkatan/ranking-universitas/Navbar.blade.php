<!-- Navbar.blade.php - Sticky navbar for Pemeringkatan Klaster pages -->


@include('loginpopup')

<!-- Desktop Navbar - Sticky -->
<nav class="navbar hidden md:block sticky top-0 z-50 bg-[#176369] shadow-md">
    <div class="container mx-auto flex justify-between items-center py-4 px-6">
        <div class="flex items-center space-x-4">
        <a href="{{ route('home') }}">
    <img alt="University logo" class="h-12 w-12" src="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png"/>
        </a>
            <h1 class="text-white text-2xl font-bold">Subdirektorat Pemeringkatan dan Sistem Informasi</h1>
        </div>
        <ul class="flex space-x-6">
            <li><a href="{{ route('home') }}" class="text-white hover:text-yellow-400">Beranda</a></li>

            <li class="relative group">
                <a href="#" class="text-white hover:text-yellow-400">Profil</a>
                <ul
                    class="absolute hidden group-hover:block bg-white text-black py-2 px-4 space-y-2 rounded-lg shadow-lg">
                    <li><a href="{{ route('pimpinan.pimpinan') }}" class="hover:text-yellow-400">Pimpinan Direktorat</a></li>
                    <li><a href="{{ route('strukturorganisasipemeringkatan') }}" class="hover:text-yellow-400">Struktur
                            Organisasi</a></li>
                    <li><a href="{{ route('tupoksipemeringkatan') }}" class="hover:text-yellow-400">Tugas Pokok dan
                            Fungsi</a></li>
                </ul>
            </li>

            <li class="relative group">
                <a href="#" class="text-white hover:text-yellow-400">Program</a>
                <ul
                    class="absolute hidden group-hover:block bg-white text-black py-2 px-4 space-y-2 rounded-lg shadow-lg">
                    <li><a href="{{ route('sdgscenter') }}" class="hover:text-yellow-400">Global Engagement</a></li>
                    <li><a href="#" class="hover:text-yellow-400">Lecturer Expose</a></li>
                    <li><a href="#" class="hover:text-yellow-400">International Faculty Staff</a></li>
                    <li><a href="#" class="hover:text-yellow-400">International Student Mobility</a></li>
                </ul>
            </li>

            <li class="relative group">
                <a href="{{ route('document.document') }}" class="text-white hover:text-yellow-400">Dokumen</a>
                <ul class="absolute hidden group-hover:">

                </ul>
            </li>

            <li class="relative group">
                <a href="#" class="text-white hover:text-yellow-400">Ranking Universitas Negeri Jakarta</a>
                <ul
                    class="absolute hidden group-hover:block bg-white text-black py-2 px-4 space-y-2 rounded-lg shadow-lg">
                    <li><a href="{{ route('pemeringkatan.klaster') }}" class="hover:text-yellow-400">IKU</a></li>
                    <li><a href="#" class="hover:text-yellow-400">UI Green Metric</a></li>
                    <li><a href="#" class="hover:text-yellow-400">Webometric</a></li>
                    <li><a href="#" class="hover:text-yellow-400">QS World University Ranking</a></li>
                    <li><a href="#" class="hover:text-yellow-400">Times Higher Education</a></li>
                </ul>
            </li>


            <li><a href="https://sso.unj.ac.id/login" class="text-white hover:text-yellow-400">SSO</a></li>
            <li><a class="login text-white" href="#" data-bs-toggle="modal" data-bs-target="#loginModal">Masuk</a>
            </li>
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
                        Profil
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <ul class="hidden bg-[#135a54]">
                        <li>
                            <a href="{{ route('strukturorganisasi') }}"
                                class="block text-white py-3 px-6 hover:bg-[#0e4c46]">
                                Struktur Organisasi
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('tupoksi.tupoksi') }}"
                                class="block text-white py-3 px-6 hover:bg-[#0e4c46]">
                                Tugas Pokok dan Fungsi
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li>
                <div class="sidebar-dropdown">
                    <button
                        class="flex justify-between items-center w-full text-white py-3 px-6 text-lg hover:bg-[#125a54]">
                        Program
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <ul class="hidden bg-[#135a54]">
                        <li>
                            <a href="#" class="block text-white py-3 px-6 hover:bg-[#0e4c46]">
                                Global Engagement
                            </a>
                        </li>
                        <li>
                            <a href="#" class="block text-white py-3 px-6 hover:bg-[#0e4c46]">
                                Lecturer Expose
                            </a>
                        </li>
                        <li>
                            <a href="#" class="block text-white py-3 px-6 hover:bg-[#0e4c46]">
                                International Faculty Staff
                            </a>
                        </li>
                        <li>
                            <a href="#" class="block text-white py-3 px-6 hover:bg-[#0e4c46]">
                                International Student Mobility
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li>
                <div class="sidebar-dropdown">
                    <button
                        class="flex justify-between items-center w-full text-white py-3 px-6 text-lg hover:bg-[#125a54]">
                        Dokumen
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <ul class="hidden bg-[#135a54]">
                        <li>
                            <a href="#" class="block text-white py-3 px-6 hover:bg-[#0e4c46]">
                                Dokumen 1
                            </a>
                        </li>
                        <li>
                            <a href="#" class="block text-white py-3 px-6 hover:bg-[#0e4c46]">
                                Dokumen 2
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li>
                <div class="sidebar-dropdown">
                    <button
                        class="flex justify-between items-center w-full text-white py-3 px-6 text-lg hover:bg-[#125a54]">
                        Sistem Pemeringkatan
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <ul class="hidden bg-[#135a54]">
                        <li>
                            <a href="{{ route('pemeringkatan.klaster') }}"
                                class="block text-white py-3 px-6 hover:bg-[#0e4c46]">
                                IKU
                            </a>
                        </li>
                        <li>
                            <a href="#" class="block text-white py-3 px-6 hover:bg-[#0e4c46]">
                                UI Green Metric
                            </a>
                        </li>
                        <li>
                            <a href="#" class="block text-white py-3 px-6 hover:bg-[#0e4c46]">
                                Webometric
                            </a>
                        </li>
                        <li>
                            <a href="#" class="block text-white py-3 px-6 hover:bg-[#0e4c46]">
                                QS World University Ranking
                            </a>
                        </li>
                        <li>
                            <a href="#" class="block text-white py-3 px-6 hover:bg-[#0e4c46]">
                                Times Higher Education
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
                if (href && currentPath.includes(
                        'pemeringkatan/ranking-universitas/klaster-perguruan-tinggi') &&
                    link.textContent.trim() === "Pemeringkatan Klaster Perguruan Tinggi") {
                    link.classList.add('text-yellow-400');
                    link.classList.add('font-bold');
                }
            });

            // For mobile menu
            const mobileLinks = document.querySelectorAll('#mobile-sidebar a');
            mobileLinks.forEach(link => {
                const href = link.getAttribute('href');
                if (href && currentPath.includes(
                        'pemeringkatan/ranking-universitas/klaster-perguruan-tinggi') &&
                    link.textContent.trim() === "Pemeringkatan Klaster Perguruan Tinggi") {
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
