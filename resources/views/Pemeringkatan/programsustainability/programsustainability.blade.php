<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Program Sustainability UNJ</title>

    <!-- External CSS Libraries -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('home.css') }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>


</head>
<style>
    /* Global Styles */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Roboto', sans-serif;
    }

    body {
        background-color: #f5f5f5;
        color: #333;
        line-height: 1.6;
    }

    /* Back Button Styles */
    .back-button {
        display: inline-flex;
        align-items: center;
        padding: 8px 15px;
        background-color: #277177;
        color: white;
        text-decoration: none;
        border-radius: 4px;
        font-weight: 500;
        transition: all 0.3s ease;
        margin: 20px 0 0 20px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .back-button:hover {
        background-color: #1c5a5f;
        transform: translateY(-2px);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.15);
    }

    .back-button i {
        margin-right: 8px;
    }

    /* Main Title Section */
    .page-title {
        color: #277177;
        padding: 15px 20px;
        text-align: center;
        font-size: 28px;
        font-weight: 600;
        letter-spacing: 0.5px;
        margin-top: 10px;
        margin-bottom: 0;
    }

    /* Banner Styles */
    .indikator-banner {
        background-color: #277177;
        color: #fff;
        padding: 40px 20px;
        text-align: center;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .indikator-banner h2 {
        font-size: 32px;
        font-weight: 700;
        margin: 0;
    }

    /* Info Section Layout */
    .info-section {
        display: flex;
        max-width: 1200px;
        margin: 30px auto;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }

    /* Sidebar Navigation */
    .info-sidebar {
        flex: 0 0 250px;
        background-color: #f0f4f8;
        padding: 20px 0;
    }

    .info-sidebar ul {
        list-style: none;
    }

    .info-sidebar li {
        margin-bottom: 2px;
    }

    .info-sidebar a {
        display: block;
        padding: 12px 20px;
        color: #555;
        text-decoration: none;
        transition: all 0.3s ease;
        border-left: 4px solid transparent;
    }

    .info-sidebar a:hover {
        background-color: #e3e8f0;
        color: #277177;
    }

    .info-sidebar a.active {
        background-color: #e6f3f3;
        color: #277177;
        border-left: 4px solid #277177;
        font-weight: 700;
    }

    /* Content Area */
    .info-content {
        flex: 1;
        padding: 30px;
    }

    .info-content h2 {
        color: #277177;
        margin-bottom: 20px;
        font-size: 24px;
        padding-bottom: 10px;
        border-bottom: 2px solid #e6f3f3;
    }

    .info-content p {
        margin-bottom: 20px;
        color: #555;
    }

    .info-content ul {
        margin-bottom: 20px;
        padding-left: 20px;
    }

    .info-content li {
        margin-bottom: 10px;
        color: #555;
    }

    /* Footer Spacer */
    .footer-spacer {
        height: 60px;
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .back-button {
            margin: 15px 0 0 15px;
            font-size: 14px;
            padding: 6px 12px;
        }

        .info-section {
            flex-direction: column;
            margin: 20px 15px;
        }

        .info-sidebar {
            flex: auto;
            width: 100%;
        }

        .info-sidebar ul {
            display: flex;
            flex-wrap: wrap;
            padding: 0 10px;
        }

        .info-sidebar li {
            margin: 5px;
        }

        .info-sidebar a {
            padding: 8px 15px;
            border-left: none;
            border-bottom: 2px solid transparent;
            font-size: 14px;
            text-align: center;
            border-radius: 4px;
        }

        .info-sidebar a.active {
            border-left: none;
            border-bottom: 2px solid #277177;
        }

        .info-content {
            padding: 20px;
        }
    }

    /* Smooth Scrolling */
    html {
        scroll-behavior: smooth;
    }

    /* Animation effects */
    .info-content {
        animation: fadeIn 0.5s ease-in-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Tables within content */
    .info-content table {
        width: 100%;
        border-collapse: collapse;
        margin: 20px 0;
    }

    .info-content table th,
    .info-content table td {
        border: 1px solid #e0e0e0;
        padding: 12px;
        text-align: left;
    }

    .info-content table th {
        background-color: #f0f4f8;
        color: #277177;
    }

    .info-content table tr:nth-child(even) {
        background-color: #f9f9f9;
    }
</style>
    @include('layout.navbar_pemeringkatan')
<body>
   
    <div class="page-title">
        Program Sustainability UNJ
    </div>

    <div class="info-section">
        <div class="info-sidebar">
            <ul>
                <li>
                    <a href="#tagihan-listrik" class="active">
                        Tagihan Listrik
                    </a>
                </li>
                <li>
                    <a href="#bbm">
                        BBM
                    </a>
                </li>
                <li>
                    <a href="#sarpas-ramah-lingkungan">
                        Sarpas Ramah Lingkungan
                    </a>
                </li>
            </ul>
        </div>

        <!-- Content Area -->
        <div class="info-content" id="tagihan-listrik">
            <h2>Tagihan Listrik</h2>
            <p>Program pengelolaan tagihan listrik di Universitas Negeri Jakarta merupakan bagian integral dari upaya sustainability kampus. Program ini bertujuan untuk mengoptimalkan penggunaan energi listrik dan mengurangi dampak lingkungan.</p>
            
            <h3 style="color: #277177; margin: 20px 0 15px 0;">Strategi Penghematan Energi</h3>
            <ul>
                <li>Implementasi sistem monitoring konsumsi listrik real-time</li>
                <li>Penggunaan lampu LED di seluruh area kampus</li>
                <li>Sistem otomatisasi pencahayaan berbasis sensor</li>
                <li>Program edukasi hemat energi untuk civitas akademika</li>
            </ul>

            <h3 style="color: #277177; margin: 20px 0 15px 0;">Target dan Pencapaian</h3>
            <p>UNJ menargetkan pengurangan konsumsi listrik sebesar 20% dalam 5 tahun ke depan melalui berbagai inovasi teknologi hijau dan perubahan perilaku penggunaan energi di lingkungan kampus.</p>
        </div>
    </div>
        @include('layout.footer')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const links = document.querySelectorAll('.info-sidebar a');
            const contentArea = document.querySelector('.info-content');

            const contentData = {
                'tagihan-listrik': {
                    title: 'Tagihan Listrik',
                    content: `
                        <p>Program pengelolaan tagihan listrik di Universitas Negeri Jakarta merupakan bagian integral dari upaya sustainability kampus. Program ini bertujuan untuk mengoptimalkan penggunaan energi listrik dan mengurangi dampak lingkungan.</p>
                        
                        <h3 style="color: #277177; margin: 20px 0 15px 0;">Strategi Penghematan Energi</h3>
                        <ul>
                            <li>Implementasi sistem monitoring konsumsi listrik real-time</li>
                            <li>Penggunaan lampu LED di seluruh area kampus</li>
                            <li>Sistem otomatisasi pencahayaan berbasis sensor</li>
                            <li>Program edukasi hemat energi untuk civitas akademika</li>
                        </ul>

                        <h3 style="color: #277177; margin: 20px 0 15px 0;">Target dan Pencapaian</h3>
                        <p>UNJ menargetkan pengurangan konsumsi listrik sebesar 20% dalam 5 tahun ke depan melalui berbagai inovasi teknologi hijau dan perubahan perilaku penggunaan energi di lingkungan kampus.</p>
                    `
                },
                'bbm': {
                    title: 'BBM (Bahan Bakar Minyak)',
                    content: `
                        <p>Program pengelolaan BBM di UNJ fokus pada pengurangan konsumsi bahan bakar fosil dan transisi menuju energi yang lebih berkelanjutan untuk operasional transportasi dan fasilitas kampus.</p>
                        
                        <h3 style="color: #277177; margin: 20px 0 15px 0;">Inisiatif Penghematan BBM</h3>
                        <ul>
                            <li>Program car-free day setiap hari Jumat</li>
                            <li>Penyediaan shuttle bus kampus dengan jadwal teratur</li>
                            <li>Pengembangan jalur sepeda di area kampus</li>
                            <li>Optimalisasi rute dan jadwal kendaraan operasional</li>
                        </ul>

                        <h3 style="color: #277177; margin: 20px 0 15px 0;">Teknologi Ramah Lingkungan</h3>
                        <p>UNJ sedang mengeksplorasi penggunaan kendaraan listrik untuk operasional kampus dan mendorong civitas akademika untuk menggunakan transportasi berkelanjutan.</p>
                        
                        <p>Program ini juga mencakup edukasi tentang pentingnya mengurangi jejak karbon melalui pilihan transportasi yang lebih ramah lingkungan.</p>
                    `
                },
                'sarpas-ramah-lingkungan': {
                    title: 'Sarana Prasarana Ramah Lingkungan',
                    content: `
                        <p>UNJ berkomitmen mengembangkan sarana dan prasarana yang ramah lingkungan sebagai wujud kepedulian terhadap kelestarian lingkungan dan pembangunan berkelanjutan.</p>
                        
                        <h3 style="color: #277177; margin: 20px 0 15px 0;">Fasilitas Hijau</h3>
                        <ul>
                            <li>Green building dengan sertifikasi ramah lingkungan</li>
                            <li>Sistem pengolahan air limbah terpusat</li>
                            <li>Taman vertikal dan ruang terbuka hijau</li>
                            <li>Sistem pemanenan air hujan (rainwater harvesting)</li>
                            <li>Tempat sampah terpilah dan sistem pengelolaan sampah berkelanjutan</li>
                        </ul>

                        <h3 style="color: #277177; margin: 20px 0 15px 0;">Inovasi Berkelanjutan</h3>
                        

                        <h3 style="color: #277177; margin: 20px 0 15px 0;">Rencana Pengembangan</h3>
                        <p>UNJ terus berkomitmen untuk mengembangkan infrastruktur yang lebih berkelanjutan dengan target menjadi eco-campus pada tahun 2030. Berbagai penelitian dan inovasi terus dilakukan untuk mendukung visi ini.</p>
                    `
                }
            };

            links.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    // Remove active class from all links
                    links.forEach(l => l.classList.remove('active'));
                    
                    // Add active class to clicked link
                    this.classList.add('active');
                    
                    // Get target content
                    const targetId = this.getAttribute('href').substring(1);
                    const content = contentData[targetId];
                    
                    if (content) {
                        contentArea.innerHTML = `
                            <h2>${content.title}</h2>
                            ${content.content}
                        `;
                        contentArea.id = targetId;
                    }
                });
            });
        });
    </script>

</body>

</html>