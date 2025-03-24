<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Direktorat Inovasi, Sistem Informasi, dan Pemeringkatan</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        /* Reset and Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

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
            --white: #ffffff;
            --border-radius: 4px;
        }

        body {
            background-color: var(--white);
            color: var(--text-dark);
            line-height: 1.6;
        }

        /* Navbar styling */
        nav {
            position: sticky;
            top: 0;
            width: 100%;
            z-index: 1000;
            background-color: #006463; /* Match the example */
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
        
        /* Mobile menu toggle */
        .menu-toggle {
            display: none;
            margin-top: 20px;
            flex-direction: column;
            justify-content: space-between;
            width: 30px;
            height: 21px;
            cursor: pointer;
        }

        .menu-toggle span {
            display: block;
            height: 3px;
            width: 100%;
            background-color: var(--white);
            border-radius: 3px;
            transition: all 0.3s ease;
        }

        /* Container */
        .container {
            max-width: 1100px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        /* Section styling */
        .section-header {
            text-align: center;
            margin-top: 4rem; /* Added more top margin to create space between navbar and h2 */
            margin-bottom: 3.5rem;
        }

        .section-header h2 {
            font-size: 2.2rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
            position: relative;
            display: inline-block;
        }

        .section-header h2:after {
            content: '';
            position: absolute;
            width: 60px;
            height: 4px;
            background-color: var(--accent);
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
        }
        
        /* Tupoksi sections styling */
        .tupoksi-section {
            margin-bottom: 4rem;
            border-bottom: 1px solid #e0e6e6;
            padding-bottom: 3rem;
        }
        
        .tupoksi-section:last-child {
            border-bottom: none;
            margin-bottom: 2rem;
        }
        
        .tupoksi-header {
            margin-bottom: 2rem;
            position: relative;
            padding-left: 2.5rem;
        }
        
        .tupoksi-header h3 {
            font-size: 1.6rem;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }
        
        .tupoksi-header i {
            position: absolute;
            left: 0;
            top: 0.3rem;
            font-size: 1.8rem;
            color: var(--accent);
        }
        
        .task-content-wrapper {
            margin-bottom: 2rem;
        }
        
        .task-title {
            font-size: 1.3rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
        }
        
        .task-title i {
            margin-right: 0.8rem;
            color: var(--accent);
        }
        
        .task-content {
            padding: 1.5rem 0;
            font-size: 1.05rem;
        }
        
        .function-list {
            list-style-position: inside;
            margin-left: 1rem;
            padding-left: 0;
        }
        
        .function-item {
            padding: 0.5rem 0;
            font-size: 1.05rem;
            margin-bottom: 0.5rem;
        }

        /* Footer */
        .footer {
            background-color: var(--primary-color);
            color: var(--white);
            padding: 3rem 2rem;
            text-align: center;
            margin-top: 4rem;
        }

        .footer-content {
            max-width: 800px;
            margin: 0 auto;
        }

        .footer-logo {
            margin-bottom: 1.5rem;
        }

        .footer-logo img {
            height: 60px;
            filter: brightness(0) invert(1);
        }

        .footer-text {
            margin-bottom: 1.5rem;
            opacity: 0.9;
        }

        .footer-links {
            display: flex;
            justify-content: center;
            margin-bottom: 1.5rem;
        }

        .footer-link {
            color: var(--white);
            margin: 0 1rem;
            text-decoration: none;
            opacity: 0.8;
            transition: opacity 0.2s;
        }

        .footer-link:hover {
            opacity: 1;
        }

        .copyright {
            font-size: 0.9rem;
            opacity: 0.7;
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            section {
                padding: 2rem 5%;
            }
            
            .menu-toggle {
                display: flex;
            }
            
            .nav-container {
                padding: 0.8rem 5%;
            }
            
            .nav-menu {
                position: absolute;
                top: 100%;
                left: 0;
                width: 100%;
                background-color: #006463;
                flex-direction: column;
                align-items: center;
                padding: 1rem 0;
                transform: translateY(-100%);
                opacity: 0;
                transition: all 0.3s ease;
                z-index: 99;
            }
            
            .nav-menu.active {
                transform: translateY(0);
                opacity: 1;
            }
            
            .nav-menu li {
                width: 100%;
                text-align: center;
            }
            
            nav a {
                display: block;
                padding: 0.8rem 1rem;
                width: 100%;
            }

            .tupoksi-header h3 {
                font-size: 1.4rem;
            }
            
            .function-item span.letter {
                margin-bottom: 0.3rem;
            }
        }
    </style>
</head>

<body>
    <!-- Updated Navbar -->
    <nav>
        <div class="nav-container">
            <div class="logo">
                <img src="https://spm.unj.ac.id/wp-content/uploads/2024/08/Logo-UNJ-PTNBH-RGB_Logo_Motto_Transparan-875x1024.png" alt="UNJ Logo" class="unj-logo">
                <span class="logo-text">Direktorat Inovasi</span>
            </div>
            <div class="menu-toggle">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <ul class="nav-menu">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="#" class="active">TUPOKSI</a></li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <div class="section-header">
            <h2>Tugas Pokok dan Fungsi</h2>
        </div>
        
        <!-- Direktorat Section -->
        <div class="tupoksi-section">
            <div class="tupoksi-header">
                <i class="fas fa-building"></i>
                <h3>Direktorat Inovasi, Sistem Informasi, dan Pemeringkatan</h3>
            </div>
            
            <div class="task-content-wrapper">
                <h4 class="task-title"><i class="fas fa-tasks"></i> Tugas</h4>
                <div class="task-content">
                    <p>Merencanakan dan melaksanakan pengembangan inovasi dan layanan informasi untuk meningkatkan daya saing dan reputasi universitas baik secara nasional maupun internasional</p>
                </div>
            </div>
            
            <h4 class="task-title"><i class="fas fa-cogs"></i> Fungsi</h4>
            <ol class="function-list">
                <li class="function-item">
                    <span>Mengembangkan kebijakan inovasi jangka pendek, menengah dan panjang di universitas agar selaras dengan kebutuhan industri dan masyarakat.</span>
                </li>
                <li class="function-item">
                    <span>Merencanakan dan mengelola kegiatan inovasi dan hilirisasi inovasi di seluruh fakultas dan program studi hingga siap digunakan industri atau masyarakat</span>
                </li>
                <li class="function-item">
                    <span>Mengelola layanan informasi antar unit secara sistematis yang mudah diakses oleh publik</span>
                </li>
                <li class="function-item">
                    <span>Menyusun strategi komprehensif sesuai indikator lembaga pemeringkat perguruan tinggi tingkat nasional maupun internasional</span>
                </li>
                <li class="function-item">
                    <span>Mengkoordinasikan pelaksanaan pemosisian universitas sehingga memiliki reputasi tingkat nasional dan internasional</span>
                </li>
            </ol>
        </div>
        
        <!-- Subdit Riset Section -->
        <div class="tupoksi-section">
            <div class="tupoksi-header">
                <i class="fas fa-flask"></i>
                <h3>Subdit Riset, Inovasi, dan Hilirisasi</h3>
            </div>
            
            <div class="task-content-wrapper">
                <h4 class="task-title"><i class="fas fa-tasks"></i> Tugas</h4>
                <div class="task-content">
                    <p>Melaksanakan pengembangan berbagai inovasi dan proses hilirisasi hingga siap digunakan masyarakat dan industri</p>
                </div>
            </div>
            
            <h4 class="task-title"><i class="fas fa-cogs"></i> Fungsi</h4>
            <ol class="function-list">
                <li class="function-item">
                    <span>Mengidentifikasi, melakukan pengukuran kesiapterapan dan mengembangkan hasil riset yang berpotensi menjadi inovasi.</span>
                </li>
                <li class="function-item">
                    <span>Melaksanakan pengujian hasil inovasi pada berbagai lembaga sertifikasi sesuai dengan karakteristik produk</span>
                </li>
                <li class="function-item">
                    <span>Mengelola program inkubator untuk startup atau usaha rintisan berbasis inovasi.</span>
                </li>
                <li class="function-item">
                    <span>Mengembangkan kemitraan dengan industri, pemerintah, dan organisasi lain.</span>
                </li>
                <li class="function-item">
                    <span>Penghubung antara pemilik inovasi dan universitas dengan pihak eksternal.</span>
                </li>
            </ol>
        </div>
        
        <!-- Subdit Pemeringkatan Section -->
        <div class="tupoksi-section">
            <div class="tupoksi-header">
                <i class="fas fa-chart-line"></i>
                <h3>Subdit Pemeringkatan dan Layanan Informasi</h3>
            </div>
            
            <div class="task-content-wrapper">
                <h4 class="task-title"><i class="fas fa-tasks"></i> Tugas</h4>
                <div class="task-content">
                    <p>Merencanakan dan melaksanakan layanan informasi akuntabel bagi terwujudnya universitas bereputasi nasional dan internasional</p>
                </div>
            </div>
            
            <h4 class="task-title"><i class="fas fa-cogs"></i> Fungsi</h4>
            <ol class="function-list">
                <li class="function-item">
                    <span>Membangun sistem informasi yang adaptif dan efisien</span>
                </li>
                <li class="function-item">
                    <span>Mengimplementasikan strategi untuk meningkatkan posisi universitas</span>
                </li>
                <li class="function-item">
                    <span>Mengkoordinasi pengumpulan data yang konsisten di seluruh unit</span>
                </li>
                <li class="function-item">
                    <span>Memantau dan menganalisis data kinerja universitas</span>
                </li>
                <li class="function-item">
                    <span>Menyusun laporan berkala dan media publikasi</span>
                </li>
            </ol>
        </div>
    </div>

    <footer>
    @include('tupoksi.tupoksifooter')

    </footer>

    <script>
        // Mobile menu toggle
        const menuToggle = document.querySelector('.menu-toggle');
        const navMenu = document.querySelector('.nav-menu');
        
        menuToggle.addEventListener('click', function() {
            navMenu.classList.toggle('active');
        });
    </script>
</body>
</html>