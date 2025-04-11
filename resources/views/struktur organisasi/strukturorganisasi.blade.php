<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struktur Organisasi - Universitas Negeri Jakarta</title>
    <link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #176369; 
            --secondary-color: #1C7A7A; 
            --accent-color: #FFA500; 
            --text-color: #333;
            --background-color: #f5f5f5;
            --card-color: #ffffff;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: var(--background-color);
            color: var(--text-color);
            line-height: 1.6;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 30px 20px;
        }

        header {
            text-align: center;
            margin-bottom: 40px;
            position: relative;
            color: #176369;
        }

        header:after {
            content: "";
            display: block;
            width: 100px;
            height: 4px;
            background-color: var(--accent-color);
            margin: 15px auto 0;
            border-radius: 2px;
        }

        h1 {
            color: var(--primary-color);
            font-size: 36px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin: 0;
        }

        .content-card {
            background-color: var(--card-color);
            border-radius: 8px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
            padding: 50px; /* Diperbesar */
            margin-bottom: 40px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .content-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.1);
        }

        .org-structure-img {
            width: 100%;
            max-width: 1500px; /* Diperbesar */
            height: auto;
            display: block;
            margin: 0 auto;
            border-radius: 6px;
        }

        .img-container {
            position: relative;
            margin-bottom: 25px;
            text-align: center;
        }

        .img-caption {
            text-align: center;
            margin-top: 20px;
            color: var(--secondary-color);
            font-size: 16px;
            font-weight: 500;
        }

        .description {
            text-align: center;
            max-width: 800px;
            margin: 0 auto 30px;
            color: #555;
            font-size: 18px;
        }

        /* Navbar Styles */
        .navbar {
            background-color: #176369;
            padding: 15px 0;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .navbar-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar-logo {
            display: flex;
            align-items: center;
        }

        .navbar-logo img {
            height: 50px;
            margin-right: 15px;
        }

        .navbar-logo-text {
            color: #ffffff;
            font-size: 18px;
            font-weight: 600;
            text-decoration: none;
        }

        .navbar-menu {
            display: flex;
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .navbar-item {
            margin: 0 15px;
            position: relative;
        }

        .navbar-link {
            color: #ffffff;
            text-decoration: none;
            font-size: 16px;
            font-weight: 500;
            transition: color 0.3s ease;
            padding: 10px 0;
            display: block;
        }

        .navbar-link:hover {
            color: #FFA500;
        }

        .navbar-link.active {
            color: #FFA500;
        }

        .navbar-link.active:after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background-color: #FFA500;
            border-radius: 2px;
        }

        .dropdown {
            position: relative;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #ffffff;
            min-width: 200px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            border-radius: 4px;
            z-index: 1001;
            margin-top: 10px;
        }

        .dropdown-link {
            color: #333;
            padding: 12px 15px;
            text-decoration: none;
            display: block;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .dropdown-link:hover {
            background-color: #f5f5f5;
            color: #176369;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .menu-toggle {
            display: none;
            font-size: 24px;
            color: #ffffff;
            cursor: pointer;
            background: none;
            border: none;
        }

        @media (max-width: 992px) {
            .menu-toggle {
                display: block;
            }

            .navbar-menu {
                position: fixed;
                top: 80px;
                left: -100%;
                width: 80%;
                height: 100vh;
                background-color: #176369;
                flex-direction: column;
                padding: 20px;
                transition: left 0.3s ease;
                z-index: 999;
            }

            .navbar-menu.active {
                left: 0;
            }

            .navbar-item {
                margin: 10px 0;
            }

            .dropdown-content {
                position: static;
                box-shadow: none;
                min-width: 100%;
                background-color: rgba(255, 255, 255, 0.1);
                border-radius: 0;
                margin-top: 5px;
                display: none;
            }

            .dropdown.active .dropdown-content {
                display: block;
            }

            .dropdown-link {
                color: #ffffff;
                padding: 10px 20px;
            }

            .dropdown-link:hover {
                background-color: rgba(255, 255, 255, 0.2);
                color: #FFA500;
            }
        }

        @media (max-width: 768px) {
            h1 {
                font-size: 28px;
            }

            .container {
                padding: 20px 15px;
            }

            .content-card {
                padding: 30px; 
            }

            .org-structure-img {
                max-width: 100%; 
            }

            .description {
                font-size: 16px;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="navbar-container">
            <div class="navbar-logo">
                <img src="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" alt="UNJ Logo">
                <a href="#" class="navbar-logo-text">Universitas Negeri Jakarta</a>
            </div>
            
            <button class="menu-toggle" id="menu-toggle">
                <i class="fas fa-bars"></i>
            </button>
            
            <ul class="navbar-menu" id="navbar-menu">
                <li class="navbar-item">
                    <a href="{{ route('home') }}" class="navbar-link">Beranda</a>
                </li>
                <li class="navbar-item dropdown">
                    <a href="#" class="navbar-link">Profil</a>
                    <div class="dropdown-content">
                        <a href="#" class="dropdown-link">Tentang Kami</a>
                        <a href="#" class="dropdown-link">Visi & Misi</a>
                        <a href="#" class="dropdown-link active">Struktur Organisasi</a>
                        <a href="#" class="dropdown-link">Sejarah</a>
                    </div>
                </li>
                <li class="navbar-item dropdown">
                    <a href="#" class="navbar-link">Akademik</a>
                    <div class="dropdown-content">
                        <a href="#" class="dropdown-link">Program Studi</a>
                        <a href="#" class="dropdown-link">Fakultas</a>
                        <a href="#" class="dropdown-link">Kalender Akademik</a>
                        <a href="#" class="dropdown-link">Perpustakaan</a>
                    </div>
                </li>
                <li class="navbar-item">
                    <a href="#" class="navbar-link">Berita</a>
                </li>
                <li class="navbar-item">
                    <a href="#" class="navbar-link">Galeri</a>
                </li>
                <li class="navbar-item">
                    <a href="#" class="navbar-link">Kontak</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container">
        <header>
            <h1>Struktur Organisasi</h1>
        </header>

        <p class="description">
            Struktur organisasi kami dirancang untuk memastikan tata kelola yang efektif dan efisien dalam mencapai visi dan misi institusi.
        </p>

        <div class="content-card">
            <div class="img-container">
                <img src="{{ asset('images/Struktur Organisasi WR3.png') }}" alt="Struktur Organisasi Institusi" class="org-structure-img">
            </div>
            <p class="img-caption">Struktur Organisasi Tahun 2025</p>
        </div>
    </div>

    <!-- JavaScript for Mobile Menu -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menuToggle = document.getElementById('menu-toggle');
            const navbarMenu = document.getElementById('navbar-menu');
            
            menuToggle.addEventListener('click', function() {
                navbarMenu.classList.toggle('active');
            });
            
            // For dropdown menus on mobile
            const dropdowns = document.querySelectorAll('.dropdown');
            
            dropdowns.forEach(dropdown => {
                if (window.innerWidth <= 992) {
                    dropdown.addEventListener('click', function(e) {
                        e.preventDefault();
                        this.classList.toggle('active');
                    });
                }
            });
        });
    </script>
</body>
@include('struktur organisasi.footerstrukturorganisasi')
</html>