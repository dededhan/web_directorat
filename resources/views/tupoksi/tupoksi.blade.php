<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Direktorat Inovasi, Sistem Informasi, dan Pemeringkatan</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        :root {
            --primary-color: #176369;
            --secondary-color: #0d4b4f;
            --accent-color: #2a8288;
            --light-accent: #e6f0f1;
            --text-color: #2c3e50;
            --white: #ffffff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: #f8fafa;
            color: var(--text-color);
            line-height: 1.7;
            overflow-x: hidden;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
            perspective: 1000px;
        }

        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        @keyframes slideInFromLeft {
            0% {
                transform: translateX(-100%);
                opacity: 0;
            }
            100% {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes rotateIn {
            0% {
                transform: rotateY(-90deg);
                opacity: 0;
            }
            100% {
                transform: rotateY(0);
                opacity: 1;
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .header {
            text-align: center;
            padding: 4rem 2rem;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: var(--white);
            border-radius: 20px;
            margin-bottom: 3rem;
            position: relative;
            overflow: hidden;
            animation: float 6s ease-in-out infinite;
            box-shadow: 0 10px 30px rgba(23, 99, 105, 0.2);
        }

        .header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: repeating-linear-gradient(
                45deg,
                transparent,
                transparent 10px,
                rgba(255, 255, 255, 0.1) 10px,
                rgba(255, 255, 255, 0.1) 20px
            );
            animation: movePattern 20s linear infinite;
        }

        @keyframes movePattern {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .header h1 {
            position: relative;
            z-index: 1;
            font-size: 2.5rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
            animation: pulse 3s ease-in-out infinite;
        }

        .section {
            background: var(--white);
            padding: 2.5rem;
            margin-bottom: 2rem;
            border-radius: 20px;
            box-shadow: 0 5px 20px rgba(23, 99, 105, 0.1);
            transition: all 0.3s ease;
            opacity: 0;
            animation: rotateIn 0.8s ease-out forwards;
            transform-origin: center;
        }

        .section:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 15px 30px rgba(23, 99, 105, 0.2);
        }

        .section-title {
            color: var(--primary-color);
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 3px solid var(--accent-color);
            font-size: 1.8rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 1rem;
            animation: slideInFromLeft 0.8s ease-out;
        }

        .section-title::before {
            content: '🔍';
            font-size: 1.5rem;
            animation: pulse 2s infinite;
        }

        .subsection h3 {
            color: var(--primary-color);
            margin: 1.5rem 0;
            font-size: 1.4rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            opacity: 0;
            animation: fadeInUp 0.6s ease-out forwards;
        }

        .tugas {
            background: linear-gradient(135deg, var(--light-accent), white);
            padding: 2rem;
            border-radius: 15px;
            margin-bottom: 2rem;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
            animation: fadeInUp 0.8s ease-out;
            border-left: 4px solid var(--accent-color);
        }

        .tugas:hover {
            transform: scale(1.02);
            box-shadow: 0 10px 20px rgba(23, 99, 105, 0.15);
        }

        .fungsi-list {
            list-style-type: none;
            display: grid;
            gap: 1rem;
        }

        .fungsi-item {
            padding: 1.2rem 1.5rem;
            background: var(--white);
            border-radius: 12px;
            border-left: 4px solid var(--accent-color);
            transition: all 0.3s ease;
            opacity: 0;
            transform: translateX(-20px);
            animation: slideIn 0.5s ease-out forwards;
            position: relative;
            overflow: hidden;
        }

        @keyframes slideIn {
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .fungsi-item:hover {
            transform: translateX(10px) scale(1.02);
            background: linear-gradient(to right, var(--light-accent), white);
            box-shadow: 0 5px 15px rgba(23, 99, 105, 0.1);
        }

        .fungsi-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(
                120deg,
                transparent,
                rgba(255, 255, 255, 0.6),
                transparent
            );
            transition: 0.5s;
        }

        .fungsi-item:hover::before {
            left: 100%;
        }

        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }
            
            .header {
                padding: 2rem 1rem;
            }

            .header h1 {
                font-size: 1.8rem;
            }
            
            .section {
                padding: 1.5rem;
            }
        }

        /* Adding delay to fungsi-item animations */
        .fungsi-item {
            animation-delay: calc(var(--i) * 0.1s);
        }

        /* Animate sections one by one */
        .section:nth-child(1) { animation-delay: 0.2s; }
        .section:nth-child(2) { animation-delay: 0.4s; }
        .section:nth-child(3) { animation-delay: 0.6s; }

        /* Floating animation for specific elements */
        .section-title:hover::before {
            animation: float 2s ease-in-out infinite;
        }

        /* Shine effect */
        @keyframes shine {
            0% {
                background-position: -100% 0;
            }
            100% {
                background-position: 200% 0;
            }
        }

        .header::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(
                45deg,
                transparent 45%,
                rgba(255, 255, 255, 0.1) 50%,
                transparent 55%
            );
            animation: shine 6s infinite;
        }
    </style>
</head>
<body>
    <div class="container">
        <header class="header">
            <h1>Direktorat Inovasi, Sistem Informasi, dan Pemeringkatan</h1>
        </header>

        <div class="section">
            <h2 class="section-title">Direktorat Inovasi, Sistem Informasi, dan Pemeringkatan</h2>
            <div class="subsection">
                <h3><i class="fas fa-tasks"></i> Tugas</h3>
                <div class="tugas">
                    <p>Merencanakan dan melaksanakan pengembangan inovasi dan layanan informasi untuk meningkatkan daya saing dan reputasi universitas baik secara nasional maupun internasional</p>
                </div>
                
                <h3><i class="fas fa-cogs"></i> Fungsi</h3>
                <ul class="fungsi-list">
                    <li class="fungsi-item" style="--i:1">a. Mengembangkan kebijakan inovasi jangka pendek, menengah dan panjang di universitas agar selaras dengan kebutuhan industri dan masyarakat.</li>
                    <li class="fungsi-item" style="--i:2">b. Merencanakan dan mengelola kegiatan inovasi dan hilirisasi inovasi di seluruh fakultas dan program studi hingga siap digunakan industri atau masyarakat</li>
                    <li class="fungsi-item" style="--i:3">c. Mengelola layanan informasi antar unit secara sistematis yang mudah diakses oleh publik</li>
                    <li class="fungsi-item" style="--i:4">d. Menyusun strategi komprehensif sesuai indikator lembaga pemeringkat perguruan tinggi tingkat nasional maupun internasional</li>
                    <li class="fungsi-item" style="--i:5">e. Mengkoordinasikan pelaksanaan pemosisian universitas sehingga memiliki reputasi tingkat nasional dan internasional</li>
                </ul>
            </div>
        </div>

        <div class="section">
            <h2 class="section-title">Subdit Riset, Inovasi, dan Hilirisasi</h2>
            <div class="subsection">
                <h3><i class="fas fa-flask"></i> Tugas</h3>
                <div class="tugas">
                    <p>Melaksanakan pengembangan berbagai inovasi dan proses hilirisasi hingga siap digunakan masyarakat dan industri</p>
                </div>
                
                <h3><i class="fas fa-list-check"></i> Fungsi</h3>
                <ul class="fungsi-list">
                    <li class="fungsi-item" style="--i:1">a. Mengidentifikasi, melakukan pengukuran kesiapterapan dan mengembangkan hasil riset yang berpotensi menjadi inovasi.</li>
                    <li class="fungsi-item" style="--i:2">b. Melaksanakan pengujian hasil inovasi pada berbagai lembaga sertifikasi sesuai dengan karakteristik produk</li>
                    <li class="fungsi-item" style="--i:3">c. Mengelola program inkubator untuk startup atau usaha rintisan berbasis inovasi.</li>
                    <li class="fungsi-item" style="--i:4">d. Mengembangkan kemitraan dengan industri, pemerintah, dan organisasi lain.</li>
                    <li class="fungsi-item" style="--i:5">e. Penghubung antara pemilik inovasi dan universitas dengan pihak eksternal.</li>
                </ul>
            </div>
        </div>

        <div class="section">
            <h2 class="section-title">Subdit Pemeringkatan dan Layanan Informasi</h2>
            <div class="subsection">
                <h3><i class="fas fa-chart-line"></i> Tugas</h3>
                <div class="tugas">
                    <p>Merencanakan dan melaksanakan layanan informasi akuntabel bagi terwujudnya universitas bereputasi nasional dan internasional</p>
                </div>
                
                <h3><i class="fas fa-list"></i> Fungsi</h3>
                <ul class="fungsi-list">
                    <li class="fungsi-item" style="--i:1">a. Membangun sistem informasi yang adaptif dan efisien</li>
                    <li class="fungsi-item" style="--i:2">b. Mengimplementasikan strategi untuk meningkatkan posisi universitas</li>
                    <li class="fungsi-item" style="--i:3">c. Mengkoordinasi pengumpulan data yang konsisten di seluruh unit</li>
                    <li class="fungsi-item" style="--i:4">d. Memantau dan menganalisis data kinerja universitas</li>
                    <li class="fungsi-item" style="--i:5">e. Menyusun laporan berkala dan media publikasi</li>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>
@include('tupoksi.tupoksifooter')
