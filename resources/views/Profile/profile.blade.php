<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Direktorat</title>
    <style>
        :root {
            --primary-color: #186666;
            --primary-light: #2a8787;
            --primary-dark: #0d4545;
            --text-light: #ffffff;
            --text-dark: #333333;
            --accent: #f0c75e;
            --accent-light: #f8e4ad;
            --bg-light: #f8f8f8;
            --border-color: #e0e0e0;
            --link-color: #186666;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: white;
            color: var(--text-dark);
            line-height: 1.6;
            overflow-x: hidden; /* Prevent horizontal scrolling */
            width: 100%;
            position: relative;
        }
        
        /* New Navigation Design */
        nav {
            position: sticky;
            top: 0;
            width: 100%;
            z-index: 1000;
            background-color: #006463; /* Changed to match image background */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 0;
        }
        
        .nav-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            max-width: 2100px;
            margin: 0 auto;
            padding: 0.8rem 2rem;
            width: 100%;
        }
        
        .logo {
            display: flex;
            align-items: center;
        }
        
        .unj-logo {
            width: 40px;
            height: 40px;
            object-fit: contain; /* Ensures logo fits properly */
            margin-right: 0.8rem;
        }
        
        .logo-text {
            color: var(--text-light);
            font-weight: bold;
            font-size: 1.2rem;
            letter-spacing: 1px;
            text-transform: uppercase;
        }
        
        .nav-menu {
            display: flex;
            gap: 1rem;
            list-style: none;
        }
        
        nav a {
            color: var(--text-light);
            text-decoration: none;
            font-size: 1rem;
            padding: 0.5rem 1rem;
            position: relative;
            transition: all 0.3s ease;
            border-radius: 4px;
        }
        
        nav a:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }
        
        nav a.active {
            color: var(--accent);
            font-weight: 500;
            background-color: rgba(255, 255, 255, 0.1);
        }
        
        main {
            width: 100%;
            padding: 0;
            margin-top: 2rem;
        }
        
        section {
            padding: 2.5rem 8%;
        }
        
        h2.section-title {
            color: var(--primary-color);
            font-size: 1.8rem;
            margin-bottom: 1.5rem;
            position: relative;
            padding-bottom: 0.75rem;
            display: inline-block;
        }
        
        h2.section-title:after {
            content: '';
            position: absolute;
            width: 100%;
            height: 3px;
            background-color: var(--primary-color);
            bottom: 0;
            left: 0;
        }
        
        section.functions, 
        section.organization {
            margin-bottom: 2rem;
            margin-top: -4rem;
        }
        
        ul.function-list {
            list-style-type: none;
            margin: 1.5rem 0;
        }
        
        ul.function-list li {
            margin-bottom: 1rem;
            padding-left: 1.8rem;
            position: relative;
            line-height: 1.5;
        }
        
        ul.function-list li:before {
            content: "•";
            color: var(--primary-color);
            font-weight: bold;
            font-size: 1.3rem;
            position: absolute;
            left: 0;
            top: -0.1rem;
        }
        
        .subdir-wrapper {
            margin-top: 2rem;
        }
        
        article {
            margin-bottom: 2.5rem;
        }
        
        article h3 {
            color: var(--primary-dark);
            font-size: 1.4rem;
            margin-bottom: 1rem;
            border-left: 4px solid var(--accent);
            padding-left: 0.8rem;
        }
        
        article p {
            margin-bottom: 1rem;
        }
        
        footer {
            background-color: var(--primary-dark);
            color: var(--text-light);
            text-align: center;
            padding: 2rem;
        }
        
        footer p {
            margin-bottom: 0.5rem;
        }
        
        @media (max-width: 768px) {
            section {
                padding: 2rem 5%;
            }
            
            nav {
                padding: 0.5rem 2%;
            }
        }
    </style>
</head>
<body>
    <nav>
        <div class="nav-container">
            <div class="logo">
                <img src="https://spm.unj.ac.id/wp-content/uploads/2024/08/Logo-UNJ-PTNBH-RGB_Logo_Motto_Transparan-875x1024.png" alt="UNJ Logo" class="unj-logo">
                <span class="logo-text">Profile Direktorat</span>
            </div>
            <ul class="nav-menu">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="#" class="active">Profile</a></li>
            </ul>
        </div>
    </nav>
    
    <main>
        <section class="functions" id="functions">
            <h2 class="section-title">Fungsi Utama</h2>
            <p>Berdasarkan Pasal 111, Direktorat Inovasi dan Hilirisasi, Sistem Informasi dan Pemeringkatan menyelenggarakan fungsi:</p>
            <ul class="function-list">
                <li>penyusunan dan pengembangan kebijakan inovasi;</li>
                <li>pengembangan dan pengelolaan kegiatan inovasi dan hilirisasi di seluruh Fakultas dan Program Studi;</li>
                <li>pemberian dukungan proses hilirisasi produk inovasi dari hasil riset untuk dapat dimanfaatkan masyarakat atau dikomersialisasikan;</li>
                <li>perumusan langkah strategis dalam peningkatan peringkat UNJ di tingkat nasional maupun internasional;</li>
                <li>pembuatan panduan untuk Fakultas dan Program Studi tentang peningkatan indikator pemeringkatan; dan</li>
                <li>pengembangan kemitraan di tingkat nasional dan internasional untuk mendukung kegiatan inovasi dan hilirisasi.</li>
            </ul>
        </section>
        
        <section class="organization" id="organization">
            <h2 class="section-title">Struktur Organisasi</h2>
            <p>Berdasarkan Pasal 112, Direktorat Inovasi dan Hilirisasi, Sistem Informasi dan Pemeringkatan didukung oleh:</p>
            
            <ul class="function-list">
                <li>Subdirektorat Inovasi dan Hilirisasi;</li>
                <li>Subdirektorat Sistem Informasi dan Pemeringkatan; dan</li>
                <li>Kelompok Jabatan Fungsional.</li>
            </ul>
            <div class="subdir-wrapper">
                <article>
                    <h3>Subdirektorat Inovasi dan Hilirisasi</h3>
                    <p>Mempunyai tugas melakukan pengembangan inovasi dan hilirisasi hasil riset. Berdasarkan Pasal 114, Subdirektorat Inovasi dan Hilirisasi menyelenggarakan fungsi:</p>
                    <ul class="function-list">
                        <li>pengelolaan program inkubasi untuk mendukung usaha rintisan berbasis inovasi;</li>
                        <li>pengelolaan dana riset yang diperoleh dari hibah atau kerja sama dengan mitra untuk mendukung pengembangan inovasi;</li>
                        <li>pelaksana pelatihan dalam pengembangan inovasi dan hilirisasi hasil penelitian;</li>
                        <li>pemantauan dan evaluasi terhadap proyek inovasi dan hilirisasi; dan</li>
                        <li>penyusunan laporan perkembangan inovasi dan hilirisasi.</li>
                    </ul>
                </article>
                
                <article>
                    <h3>Subdirektorat Sistem Informasi dan Pemeringkatan</h3>
                    <p>Mempunyai tugas melakukan peningkatan sistem informasi dan pemeringkatan. Berdasarkan Pasal 114, Subdirektorat Sistem Informasi dan Pemeringkatan menyelenggarakan fungsi:</p>
                    <ul class="function-list">
                        <li>pengumpulan, pengelolaan, dan analisis data yang dibutuhkan untuk pemeringkatan universitas;</li>
                        <li>penyusunan dan pelaksanaan strategi untuk meningkatkan posisi universitas dalam pemeringkatan nasional dan internasional;</li>
                        <li>pengordinasian dengan Fakultas, Program Studi, dan unit terkait untuk memastikan data yang diperlukan pemeringkatan terkumpul dengan baik dan valid;</li>
                        <li>penyusunan laporan pemeringkatan universitas;</li>
                        <li>penyusunan laporan berkala terkait pencapaian indikator pemeringkatan yang diperlukan.</li>
                    </ul>
                </article>
                
                <article>
                    <h3>Kelompok Jabatan Fungsional</h3>
                    <p>Mendukung pelaksanaan tugas dan fungsi Direktorat sesuai dengan keahlian dan kebutuhan.</p>
                </article>
            </div>
        </section>
    </main>
    @include('Profile.profilefooter')
   
    <script>
        // JavaScript for enhancing the user experience
        document.addEventListener('DOMContentLoaded', function() {
            // Add smooth scrolling for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();
                    const targetId = this.getAttribute('href');
                    if (targetId !== '#') {
                        document.querySelector(targetId).scrollIntoView({
                            behavior: 'smooth'
                        });
                    }
                });
            });
            
            // Add navbar scroll effect
            const nav = document.querySelector('nav');
            window.addEventListener('scroll', function() {
                if (window.scrollY > 50) {
                    nav.style.padding = '0.5rem 2rem';
                    nav.style.boxShadow = '0 4px 15px rgba(0, 0, 0, 0.1)';
                } else {
                    nav.style.padding = '0.8rem 2rem';
                    nav.style.boxShadow = '0 2px 10px rgba(0, 0, 0, 0.1)';
                }
            });
            
            // Add active class to current section in viewport
            const sections = document.querySelectorAll('section');
            const navLinks = document.querySelectorAll('.nav-menu a');
            
            window.addEventListener('scroll', function() {
                let current = '';
                
                sections.forEach(section => {
                    const sectionTop = section.offsetTop;
                    const sectionHeight = section.clientHeight;
                    
                    if (window.scrollY >= (sectionTop - 100)) {
                        current = section.getAttribute('id');
                    }
                });
                
                navLinks.forEach(link => {
                    link.classList.remove('active');
                    if (link.getAttribute('href') === `#${current}`) {
                        link.classList.add('active');
                    }
                });
            });
        });
    </script>
</body>
</html>