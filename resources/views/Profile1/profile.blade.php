<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0, user-scalable=yes" name="viewport" />
    <title>Universitas Negeri Jakarta - Direktorat Pemeringkatan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
    <link rel="stylesheet" href="{{ asset('home.css') }}">
    <script src="{{ asset('home.js') }}"></script>
    
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
            overflow-x: hidden;
            width: 100%;
            position: relative;
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
        }
    </style>
</head>
@include('layout.navbar_sticky')
<body>
    <main>
        <section class="functions" id="functions">
            <h2 class="section-title">Fungsi Utama</h2>
            <p>Direktorat Inovasi dan Hilirisasi, Sistem Informasi dan Pemeringkatan menyelenggarakan fungsi:</p>
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
            <p>Direktorat Inovasi dan Hilirisasi, Sistem Informasi dan Pemeringkatan didukung oleh:</p>
            
            <ul class="function-list">
                <li>Subdirektorat Inovasi dan Hilirisasi;</li>
                <li>Subdirektorat Sistem Informasi dan Pemeringkatan; dan</li>
                <li>Kelompok Jabatan Fungsional.</li>
            </ul>
            <div class="subdir-wrapper">
                <article>
                    <h3>Subdirektorat Inovasi dan Hilirisasi</h3>
                    <p>Mempunyai tugas melakukan pengembangan inovasi dan hilirisasi hasil riset. Subdirektorat Inovasi dan Hilirisasi menyelenggarakan fungsi:</p>
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
                    <p>Mempunyai tugas melakukan peningkatan sistem informasi dan pemeringkatan. Subdirektorat Sistem Informasi dan Pemeringkatan menyelenggarakan fungsi:</p>
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
    @include('layout.footer')
    <script>
        // Removed navbar-related JavaScript
        document.addEventListener('DOMContentLoaded', function() {
            // Optional: You can add other non-navbar related scripts here if needed
        });
    </script>
</body>
</html>