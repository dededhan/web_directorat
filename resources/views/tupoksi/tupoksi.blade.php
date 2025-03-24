<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Direktorat Inovasi, Sistem Informasi, dan Pemeringkatan</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('tupoksi.css') }}">
    
    <style>
        /* Reset and Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        :root {
            --primary-color: #006666;
            --secondary-color: #004d4d;
            --accent-color: #00a3a3;
            --light-color: #e6f0f0;
            --text-dark: #2c3e50;
            --text-light: #6c7a89;
            --white: #ffffff;
            --transition: all 0.3s ease;
            --shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            --border-radius: 8px;
        }

        body {
            background-color: #f5f7fa;
            color: var(--text-dark);
            line-height: 1.6;
        }

        /* Navbar styling similar to alumni page */
        .tupoksi-navbar {
            background-color: var(--white);
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 5%;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .navbar-logo {
            display: flex;
            align-items: center;
            text-decoration: none;
        }

        .navbar-logo img {
            height: 50px;
            margin-right: 1rem;
        }

        .navbar-logo-text {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--primary-color);
        }

        .navbar-menu {
            display: flex;
            list-style: none;
        }

        .navbar-menu li {
            margin-left: 1.5rem;
        }

        .menu-link {
            color: var(--text-dark);
            text-decoration: none;
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            transition: var(--transition);
        }

        .menu-link:hover, .menu-link.active {
            color: var(--primary-color);
            background-color: var(--light-color);
        }

        /* Hero Section */
        .hero-section {
            background: linear-gradient(rgba(0, 102, 102, 0.8), rgba(0, 102, 102, 0.9)), url('https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png');
            background-size: cover;
            background-position: center;
            color: var(--white);
            text-align: center;
            padding: 5rem 2rem;
            margin-bottom: 3rem;
        }

        .hero-content h1 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            font-weight: 700;
        }

        .hero-content p {
            font-size: 1.2rem;
            max-width: 800px;
            margin: 0 auto;
        }

        /* Container */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        /* Section styling */
        .section-header {
            text-align: center;
            margin-bottom: 3rem;
        }

        .section-header h2 {
            font-size: 2rem;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }

        .section-divider {
            height: 4px;
            width: 60px;
            background-color: var(--accent-color);
            margin: 0 auto;
        }

        /* Cards for TUPOKSI content */
        .tupoksi-card {
            background-color: var(--white);
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--shadow);
            margin-bottom: 2rem;
            transition: var(--transition);
        }

        .tupoksi-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        }

        .card-header {
            background-color: var(--primary-color);
            color: var(--white);
            padding: 1.5rem;
            position: relative;
        }

        .card-header h3 {
            font-size: 1.5rem;
            margin: 0;
            display: flex;
            align-items: center;
        }

        .card-header h3 i {
            margin-right: 0.8rem;
            font-size: 1.2rem;
        }

        .card-body {
            padding: 1.5rem;
        }

        .task-section {
            margin-bottom: 2rem;
        }

        .task-title {
            display: flex;
            align-items: center;
            font-size: 1.2rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }

        .task-title i {
            margin-right: 0.6rem;
            color: var(--accent-color);
        }

        .task-content {
            background-color: var(--light-color);
            padding: 1.2rem;
            border-radius: var(--border-radius);
            border-left: 4px solid var(--accent-color);
        }

        .function-list {
            list-style: none;
        }

        .function-item {
            background-color: var(--white);
            margin-bottom: 0.8rem;
            padding: 1rem;
            border-radius: var(--border-radius);
            border-left: 3px solid var(--accent-color);
            transition: var(--transition);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            display: flex;
        }

        .function-item:hover {
            transform: translateX(5px);
            background-color: var(--light-color);
        }

        .function-item span.letter {
            color: var(--accent-color);
            font-weight: 600;
            margin-right: 0.5rem;
            flex-shrink: 0;
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .tupoksi-navbar {
                flex-direction: column;
                padding: 1rem;
            }

            .navbar-logo {
                margin-bottom: 1rem;
            }

            .navbar-menu {
                width: 100%;
                justify-content: center;
            }

            .navbar-menu li {
                margin: 0 0.5rem;
            }

            .hero-content h1 {
                font-size: 2rem;
            }

            .card-header h3 {
                font-size: 1.3rem;
            }
        }
    </style>
</head>

<body>
    <nav class="tupoksi-navbar">
        <a href="#" class="navbar-logo">
            <img src="https://spm.unj.ac.id/wp-content/uploads/2024/08/cropped-Logo-UNJ-PTNBH-RGB_Logo_Motto_Transparan.png" alt="Logo" />
            <span class="navbar-logo-text">DIREKTORAT INOVASI</span>
        </a>
        <ul class="navbar-menu">
            <li><a href="{{ route('home') }}" class="menu-link">Home</a></li>
            <li><a href="#" class="menu-link active">TUPOKSI</a></li>
        </ul>
    </nav>

    <div class="hero-section">
        <div class="hero-content">
            <h1>Direktorat Inovasi, Sistem Informasi, dan Pemeringkatan</h1>
            <p>Tugas Pokok dan Fungsi untuk Meningkatkan Daya Saing dan Reputasi Universitas</p>
        </div>
    </div>
    
    <div class="container">
        <div class="section-header">
            <h2>Tugas Pokok dan Fungsi</h2>
            <div class="section-divider"></div>
        </div>
        
        <!-- Direktorat Card -->
        <div class="tupoksi-card">
            <div class="card-header">
                <h3><i class="fas fa-building"></i> Direktorat Inovasi, Sistem Informasi, dan Pemeringkatan</h3>
            </div>
            <div class="card-body">
                <div class="task-section">
                    <h4 class="task-title"><i class="fas fa-tasks"></i> Tugas</h4>
                    <div class="task-content">
                        <p>Merencanakan dan melaksanakan pengembangan inovasi dan layanan informasi untuk meningkatkan daya saing dan reputasi universitas baik secara nasional maupun internasional</p>
                    </div>
                </div>
                
                <h4 class="task-title"><i class="fas fa-cogs"></i> Fungsi</h4>
                <ul class="function-list">
                    <li class="function-item">
                        <span class="letter">a.</span>
                        <span>Mengembangkan kebijakan inovasi jangka pendek, menengah dan panjang di universitas agar selaras dengan kebutuhan industri dan masyarakat.</span>
                    </li>
                    <li class="function-item">
                        <span class="letter">b.</span>
                        <span>Merencanakan dan mengelola kegiatan inovasi dan hilirisasi inovasi di seluruh fakultas dan program studi hingga siap digunakan industri atau masyarakat</span>
                    </li>
                    <li class="function-item">
                        <span class="letter">c.</span>
                        <span>Mengelola layanan informasi antar unit secara sistematis yang mudah diakses oleh publik</span>
                    </li>
                    <li class="function-item">
                        <span class="letter">d.</span>
                        <span>Menyusun strategi komprehensif sesuai indikator lembaga pemeringkat perguruan tinggi tingkat nasional maupun internasional</span>
                    </li>
                    <li class="function-item">
                        <span class="letter">e.</span>
                        <span>Mengkoordinasikan pelaksanaan pemosisian universitas sehingga memiliki reputasi tingkat nasional dan internasional</span>
                    </li>
                </ul>
            </div>
        </div>
        
        <!-- Subdit Riset Card -->
        <div class="tupoksi-card">
            <div class="card-header">
                <h3><i class="fas fa-flask"></i> Subdit Riset, Inovasi, dan Hilirisasi</h3>
            </div>
            <div class="card-body">
                <div class="task-section">
                    <h4 class="task-title"><i class="fas fa-tasks"></i> Tugas</h4>
                    <div class="task-content">
                        <p>Melaksanakan pengembangan berbagai inovasi dan proses hilirisasi hingga siap digunakan masyarakat dan industri</p>
                    </div>
                </div>
                
                <h4 class="task-title"><i class="fas fa-cogs"></i> Fungsi</h4>
                <ul class="function-list">
                    <li class="function-item">
                        <span class="letter">a.</span>
                        <span>Mengidentifikasi, melakukan pengukuran kesiapterapan dan mengembangkan hasil riset yang berpotensi menjadi inovasi.</span>
                    </li>
                    <li class="function-item">
                        <span class="letter">b.</span>
                        <span>Melaksanakan pengujian hasil inovasi pada berbagai lembaga sertifikasi sesuai dengan karakteristik produk</span>
                    </li>
                    <li class="function-item">
                        <span class="letter">c.</span>
                        <span>Mengelola program inkubator untuk startup atau usaha rintisan berbasis inovasi.</span>
                    </li>
                    <li class="function-item">
                        <span class="letter">d.</span>
                        <span>Mengembangkan kemitraan dengan industri, pemerintah, dan organisasi lain.</span>
                    </li>
                    <li class="function-item">
                        <span class="letter">e.</span>
                        <span>Penghubung antara pemilik inovasi dan universitas dengan pihak eksternal.</span>
                    </li>
                </ul>
            </div>
        </div>
        
        <!-- Subdit Pemeringkatan Card -->
        <div class="tupoksi-card">
            <div class="card-header">
                <h3><i class="fas fa-chart-line"></i> Subdit Pemeringkatan dan Layanan Informasi</h3>
            </div>
            <div class="card-body">
                <div class="task-section">
                    <h4 class="task-title"><i class="fas fa-tasks"></i> Tugas</h4>
                    <div class="task-content">
                        <p>Merencanakan dan melaksanakan layanan informasi akuntabel bagi terwujudnya universitas bereputasi nasional dan internasional</p>
                    </div>
                </div>
                
                <h4 class="task-title"><i class="fas fa-cogs"></i> Fungsi</h4>
                <ul class="function-list">
                    <li class="function-item">
                        <span class="letter">a.</span>
                        <span>Membangun sistem informasi yang adaptif dan efisien</span>
                    </li>
                    <li class="function-item">
                        <span class="letter">b.</span>
                        <span>Mengimplementasikan strategi untuk meningkatkan posisi universitas</span>
                    </li>
                    <li class="function-item">
                        <span class="letter">c.</span>
                        <span>Mengkoordinasi pengumpulan data yang konsisten di seluruh unit</span>
                    </li>
                    <li class="function-item">
                        <span class="letter">d.</span>
                        <span>Memantau dan menganalisis data kinerja universitas</span>
                    </li>
                    <li class="function-item">
                        <span class="letter">e.</span>
                        <span>Menyusun laporan berkala dan media publikasi</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    @include('tupoksi.tupoksifooter')
</body>
</html>