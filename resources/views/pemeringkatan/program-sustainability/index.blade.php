<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Program Sustainability UNJ</title>

    <!-- External CSS Libraries -->
    <link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" type="image/png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <!-- <link rel="stylesheet" href="{{ asset('home.css') }}"> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
    @vite([
        'resources/css/fitur/programsustainability.css',
        'resources/css/home.css',
        'resources/js/fitur/programsustainability.js' {{-- Path disesuaikan untuk Vite dan typo diperbaiki --}}
    ])
</head>

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

 

</body>

</html>