<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0, user-scalable=yes" name="viewport" />
    <title>Structur Organisasi - Universitas Negeri Jakarta</title>
    <link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" type="image/png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('home.css') }}">
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
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: var(--background-color);
            color: var(--text-color);
            line-height: 1.6;
            font-size: 16px !important;
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
            font-size: 40px;
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
            font-size: 16px;
        }

        /* Force all text elements to use the 16px font size */
        p, span, div, a, li {
            font-size: 16px !important;
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
@include('Pemeringkatan.struktur organisasi.navbarprofile')

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
@include('Pemeringkatan.struktur organisasi.footerstrukturorganisasi')
</html>