<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UNJ Navbar</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #186862;
            --secondary-color: #125a54;
            --text-color: #ffffff;
            --hover-color: #f59e0b;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'arial', sans-serif;
        }

        body {
            line-height: 1.6;
            overflow-x: hidden;
            padding-top: 80px !important; /* Ensure space for fixed navbar */
        }

        /* Desktop Navbar */
        .navbar {
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            width: 100% !important;
            background-color: var(--primary-color);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            z-index: 1000 !important;
            transition: box-shadow 0.3s ease;
        }

        .navbar.scrolled {
            box-shadow: 0 4px 6px rgba(0,0,0,0.2);
        }

        .navbar .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1600px;
            width: 100%;
            margin: 0 auto;
            padding: 0.5rem 2rem;
        }

        .navbar-logo {
            display: flex;
            align-items: center;
        }

        .navbar-logo img {
            height: 50px;
            margin-right: 1rem;
        }

        /* Updated title positioning - next to logo */
        .directorate-title {
            color: var(--text-color);
            font-size: 0.9rem;
            font-weight: 600;
            text-transform: uppercase;
            line-height: 1.2;
            margin-left: 0.5rem;
            white-space: nowrap;
        }

        /* Updated menu styles - positioned on right side */
        .navbar-menu {
            display: flex;
            list-style: none;
            gap: 0rem;
            align-items: center;
            justify-content: flex-end;
            margin-left: auto;
        }

        .navbar-menu li {
            position: relative;
        }

        .navbar-menu a {
            color: var(--text-color);
            text-decoration: none;
            transition: color 0.3s ease;
            white-space: nowrap;
            padding: 0.5rem 0.25rem;
            font-size: 0.9rem;
        }

        .navbar-menu a:hover {
            color: var(--hover-color);
        }

        /* Dropdown Styles */
        .navbar-menu .group {
            position: relative;
        }

        .navbar-menu .group-hover\:block {
            display: none;
        }

        .navbar-menu .group:hover .group-hover\:block {
            display: block;
        }

        .dropdown-menu {
            position: absolute;
            top: 100%;
            left: 0;
            background-color: white;
            color: black;
            min-width: 200px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            border-radius: 0.5rem;
            padding: 0.5rem 0;
            z-index: 50;
        }

        .dropdown-menu a {
            color: var(--primary-color);
            display: block;
            padding: 0.5rem 1rem;
        }

        .dropdown-menu a:hover {
            background-color: #f4f4f4;
            color: var(--hover-color);
        }

        /* Mobile Navbar */
        .mobile-navbar {
            display: none;
        }

        .mobile-sidebar {
            display: none;
        }

        @media (max-width: 768px) {
            body {
                padding-top: 60px !important; /* Adjusted for mobile */
            }

            .navbar {
                display: none;
            }
            
            .directorate-title {
                display: none;
            }

            .mobile-navbar {
                display: block;
                background-color: var(--primary-color);
                position: fixed !important;
                top: 0 !important;
                left: 0 !important;
                width: 100% !important;
                z-index: 1000 !important;
                padding: 1rem;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .mobile-navbar img {
                height: 40px;
            }

            .mobile-menu-toggle {
                background: none;
                border: none;
                color: var(--text-color);
                font-size: 1.5rem;
                cursor: pointer;
            }

            .mobile-sidebar {
                display: block;
                position: fixed;
                top: 0;
                right: -300px;
                width: 300px;
                height: 100%;
                background-color: var(--primary-color);
                transition: right 0.3s ease;
                z-index: 200;
                padding: 1rem;
                overflow-y: auto;
            }

            .mobile-sidebar.open {
                right: 0;
            }

            .mobile-sidebar-menu {
                list-style: none;
            }

            .mobile-sidebar-menu a {
                color: var(--text-color);
                display: block;
                padding: 1rem;
                text-decoration: none;
                border-bottom: 1px solid var(--secondary-color);
            }

            .sidebar-overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0,0,0,0.5);
                z-index: 150;
            }

            .sidebar-overlay.open {
                display: block;
            }

            .sidebar-dropdown button {
                display: flex;
                justify-content: space-between;
                width: 100%;
                color: var(--text-color);
                padding: 1rem;
                background: none;
                border: none;
                text-align: left;
                border-bottom: 1px solid var(--secondary-color);
            }

            .sidebar-dropdown ul {
                background-color: var(--secondary-color);
            }

            .sidebar-dropdown ul a {
                padding-left: 2rem;
            }
        }
    </style>
</head>
<body>
    <!-- Desktop Navbar -->
    <nav class="navbar hidden md:block">
        <div class="container">
            <!-- Logo on the left with title -->
            <div class="navbar-logo">
                <img alt="University logo" 
                     src="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" />
                <h1 class="directorate-title">DIREKTORAT INOVASI, SISTEM INFORMASI, DAN PEMERINGKATAN</h1>
            </div>
            
            <!-- Menu on the right -->
            <ul class="navbar-menu">
                <li><a href="{{ route('home') }}">Beranda</a></li>
                
                <li class="group">
                    <a href="#">Profil</a>
                    <ul class="dropdown-menu group-hover:block">
                        <li><a href="{{ route('profile.profile') }}">Tugas Pokok dan Fungsi</a></li>
                        <li><a href="{{ route('strukturorganisasi') }}">Struktur Organisasi</a></li>
                    </ul>
                </li>
                
                <li class="group">
                    <a href="#">Sub Direktorat</a>
                    <ul class="dropdown-menu group-hover:block">
                        <li><a href="{{ route('subdirektorat-inovasi.landingpage') }}">Subdirektorat Inovasi dan Hilirisasi</a></li>
                        <li><a href="{{ route('pemeringkatan.landingpage') }}">Subdirektorat Pemeringkatan dan Sistem Informasi</a></li>
                    </ul>
                </li>
                
                <li><a href="{{ route('Berita.beritahome') }}">Berita</a></li>
                
                <li class="group">
                    <a href="#">Galeri</a>
                    <ul class="dropdown-menu group-hover:block">
                        <li><a href="{{ route('alumni') }}">Alumni Berdampak</a></li>
                        <li><a href="{{ route('galeri.sustainability') }}">Sustainability</a></li>
                    </ul>
                </li>
                
                <li><a href="{{ route('document.document') }}">Dokumen</a></li>
                <li><a href="https://sso.unj.ac.id/login">SSO</a></li>
            </ul>
        </div>
    </nav>

    <!-- Mobile Navbar -->
    <nav class="mobile-navbar md:hidden">
        <div class="flex items-center">
            <img alt="University logo" 
                 src="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" />
            <h1 class="text-white ml-2">UNJ</h1>
        </div>
        <button id="mobile-menu-toggle" class="mobile-menu-toggle">
            <i class="fas fa-bars"></i>
        </button>
    </nav>

    <!-- Mobile Sidebar -->
    <div id="mobile-sidebar" class="mobile-sidebar">
        <div class="flex justify-between items-center mb-4">
            <div class="flex items-center">
                <img alt="University logo" 
                     src="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" 
                     class="h-10 mr-2"/>
                <h1 class="text-white">UNJ</h1>
            </div>
            <button id="close-sidebar" class="text-white text-2xl">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <ul class="mobile-sidebar-menu">
            <li><a href="{{ route('home') }}">Beranda</a></li>
            
            <li class="sidebar-dropdown">
                <button>
                    Profil
                    <i class="fas fa-chevron-down"></i>
                </button>
                <ul class="hidden">
                    <li><a href="{{ route('profile.profile') }}">Tugas Pokok dan Fungsi</a></li>
                    <li><a href="{{ route('strukturorganisasi') }}">Struktur Organisasi</a></li>
                </ul>
            </li>
            
            <li class="sidebar-dropdown">
                <button>
                    Sub Direktorat
                    <i class="fas fa-chevron-down"></i>
                </button>
                <ul class="hidden">
                    <li><a href="{{ route('subdirektorat-inovasi.landingpage') }}">Subdirektorat Inovasi dan Hilirisasi</a></li>
                    <li><a href="{{ route('pemeringkatan.landingpage') }}">Subdirektorat Pemeringkatan dan Sistem Informasi</a></li>
                </ul>
            </li>
            
            <li><a href="{{ route('Berita.beritahome') }}">Berita</a></li>
            
            <li class="sidebar-dropdown">
                <button>
                    Galeri
                    <i class="fas fa-chevron-down"></i>
                </button>
                <ul class="hidden">
                    <li><a href="{{ route('alumni') }}">Alumni Berdampak</a></li>
                    <li><a href="{{ route('galeri.sustainability') }}">Sustainability</a></li>
                </ul>
            </li>
            
            <li><a href="{{ route('document.document') }}">Dokumen</a></li>
            <li><a href="https://sso.unj.ac.id/login">SSO</a></li>
            <li><a href="#" data-bs-toggle="modal" data-bs-target="#loginModal">Masuk</a></li>
        </ul>
    </div>

    <!-- Sidebar Overlay -->
    <div id="sidebar-overlay" class="sidebar-overlay"></div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
            const closeSidebarBtn = document.getElementById('close-sidebar');
            const mobileSidebar = document.getElementById('mobile-sidebar');
            const sidebarOverlay = document.getElementById('sidebar-overlay');
            const dropdownButtons = document.querySelectorAll('.sidebar-dropdown button');
            const navbar = document.querySelector('.navbar');
            const mobileNavbar = document.querySelector('.mobile-navbar');

            // Ensure navbars are fixed
            if (navbar) {
                navbar.classList.add('fixed');
            }

            if (mobileNavbar) {
                mobileNavbar.classList.add('fixed');
            }

            // Scroll event (optional: add shadow on scroll)
            window.addEventListener('scroll', function() {
                if (navbar) {
                    if (window.scrollY > 50) {
                        navbar.classList.add('scrolled');
                    } else {
                        navbar.classList.remove('scrolled');
                    }
                }
            });

            function showSidebar() {
                mobileSidebar.classList.add('open');
                sidebarOverlay.classList.add('open');
            }

            function hideSidebar() {
                mobileSidebar.classList.remove('open');
                sidebarOverlay.classList.remove('open');
            }

            mobileMenuToggle.addEventListener('click', showSidebar);
            closeSidebarBtn.addEventListener('click', hideSidebar);
            sidebarOverlay.addEventListener('click', hideSidebar);

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

            // Set active menu item
            function setActiveMenuItem() {
                const currentPath = window.location.pathname;
                
                // Desktop menu
                const desktopLinks = document.querySelectorAll('.navbar-menu a');
                desktopLinks.forEach(link => {
                    const href = link.getAttribute('href');
                    if (href && currentPath.includes(href) && href !== '#') {
                        link.classList.add('text-yellow-500');
                        link.classList.add('font-bold');
                    }
                });

                // Mobile menu
                const mobileLinks = document.querySelectorAll('.mobile-sidebar-menu a');
                mobileLinks.forEach(link => {
                    const href = link.getAttribute('href');
                    if (href && currentPath.includes(href) && href !== '#') {
                        link.classList.add('text-yellow-500');
                        link.classList.add('font-bold');
                    }
                });
            }

            // Call active menu item function
            setActiveMenuItem();
        });
    </script>
</body>
</html>