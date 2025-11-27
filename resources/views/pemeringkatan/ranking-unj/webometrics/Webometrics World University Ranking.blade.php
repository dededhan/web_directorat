<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Webometrics World University Ranking</title>
    <link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" type="image/png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
    <link rel="stylesheet" href="{{ asset('home.css') }}">
    <style>
        html, body {
            height: 100%;
            overflow-y: auto;
            scroll-behavior: smooth;
        }
        
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            overflow: auto !important;
        }
        
        .container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
            padding-top: 70px; /* Space for fixed navbar */
        }
        
        h1 {
            color: #2c3e50;
            text-align: center;
            margin-bottom: 30px;
        }
        
        h2 {
            color: #2c3e50;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
            margin-top: 40px;
        }
        
        p {
            margin-bottom: 15px;
            text-align: justify;
        }
        
        /* Modified: Added custom-list class to prevent global styling */
        ul.custom-list {
            list-style-type: none;
            padding-left: 20px;
        }
        
        /* Scoped the bullet styling to custom lists only */
        ul.custom-list li {
            margin-bottom: 15px;
            position: relative;
        }
        
        ul.custom-list li:before {
            content: "•";
            position: absolute;
            left: -15px;
            color: #3498db;
        }
        
        /* Removed default styling from navbar list items */
        .navbar ul li:before {
            content: none;
        }
        
        .indicator {
            margin-bottom: 10px;
            padding-left: 30px;
            position: relative;
        }
        
        .indicator:before {
            content: counter(indicator) ".";
            counter-increment: indicator;
            position: absolute;
            left: 0;
            color: #3498db;
        }
        
        .indicators-list {
            counter-reset: indicator;
            overflow: visible;
        }
        
        a {
            color: #3498db;
            text-decoration: none;
        }
        
        a:hover {
            text-decoration: underline;
        }
    </style>
    @include('layout.navbar_pemeringkatan')
</head>
<body>
    <div class="container">
        <h1>Webometrics World University Ranking</h1>
        
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam in dui mauris. Vivamus hendrerit arcu sed erat molestie vehicula. Sed auctor neque eu tellus rhoncus ut eleifend nibh porttitor. Ut in nulla enim. Phasellus molestie magna non est bibendum non venenatis nisl tempor. Suspendisse dictum feugiat nisl ut dapibus. Mauris iaculis porttitor posuere. Praesent id metus massa, ut blandit odio.</p>
        
        <h2>Indikator Penilaian</h2>
        
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam in dui mauris:</p>
        
        <div class="indicators-list">
            <div class="indicator"><strong>Sumber Daya Manusia (SDM):</strong> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam in dui mauris.</div>
            <div class="indicator"><strong>Kelembagaan:</strong> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam in dui mauris.</div>
            <div class="indicator"><strong>Kegiatan Mahasiswa:</strong> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam in dui mauris.</div>
            <div class="indicator"><strong>Penelitian dan Publikasi Ilmiah:</strong> Lorem ipsum dolor sit amet, consectetur adipiscing elit.</div>
            <div class="indicator"><strong>Pengabdian Masyarakat:</strong> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam in dui mauris.</div>
            <div class="indicator"><strong>Inovasi dan Kemitraan:</strong> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam in dui mauris.</div>
        </div>
        
        <h2>Prestasi Universitas Lorem Ipsum (ULI)</h2>
        
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam in dui mauris. Vivamus hendrerit arcu sed erat molestie vehicula:</p>
        
        <!-- Changed to custom-list class to scope the bullet styling -->
        <ul class="custom-list">
            <li><strong>Peningkatan SDM:</strong> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam in dui mauris.</li>
            <li><strong>Kinerja Penelitian:</strong> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam in dui mauris.</li>
            <li><strong>Kontribusi Pengabdian Masyarakat:</strong> Lorem ipsum dolor sit amet, consectetur adipiscing elit.</li>
            <li><strong>Prestasi Mahasiswa:</strong> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam in dui mauris.</li>
        </ul>
        
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam in dui mauris. Vivamus hendrerit arcu sed erat molestie vehicula:</p>
        
        <!-- Changed to custom-list class to scope the bullet styling -->
        <ul class="custom-list">
            <li><strong>Tahun 2019:</strong> Lorem ipsum dolor sit amet, consectetur adipiscing elit. <a href="#">Lihat Link</a></li>
            <li><strong>Tahun 2020:</strong> Lorem ipsum dolor sit amet, consectetur adipiscing elit. <a href="#">lihatdetail.lorem.id</a></li>
            <li><strong>Tahun 2024:</strong> Lorem ipsum dolor sit amet, consectetur adipiscing elit. <a href="#">LIHAT VI</a></li>
            <li><strong>Tahun 2025:</strong> Lorem ipsum dolor sit amet, consectetur adipiscing elit. <a href="#">Dunia Lorem</a></li>
        </ul>
    </div>
</body>
@include('layout.footer')
</html>