<?php

?>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Direktorat Pemeringkatan</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&amp;display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('style.css') }}">
</head>

<body>
    @include('navbar')
    <img alt="Image of Universitas Negeri Jakarta" class="main-image" height="1080"
        src="https://maukuliah.ap-south-1.linodeobjects.com/gallery/001037/Gedung%203%20UNJ-thumbnail.jpg"
        width="1920" />
    <div class="content section-animation">
        <h2 style="border-bottom: 2px solid #000; display: inline-block;">BERITA TERKINI</h2>
    </div>
    <div class="news">
        <div class="news-item section-animation">
            <img alt="News Image 1" height="400"
                src="https://storage.googleapis.com/a1aa/image/DpPYZVf7AExXa6MH6uVzDQInKn2EkYFy8kLWafEU27ze7JNoA.jpg"
                width="600" />
            <div class="news-item-content">
                <p>2023-01-10 08:27:01</p>
                <h3>UNJ-UiTM: Sinergi Dua Negara untuk Kepemimpinan Global</h3>
                <p>Jakarta, Humas UNJ – Universitas Negeri Jakarta (UNJ) sukses menggelar diskusi kolaborasi bertajuk
                    "The Leadership Literacy Program LEAD 2024: Malaysia-Indonesia Nextgen Leadership Vanguard" bersama
                    Universiti Teknologi MARA (UiTM) Malaysia. Acara yang berlangsung di Gedung M. Syafei, lantai 4 pada
                    10 Januari 2025 ini dihadiri oleh Direktur Kemahasiswaan dan Alumni, Sekretaris Kantor Urusan
                    Internasional, Kepala Bidang [...]</p>
                <a class="read-more" href="#">Baca Selengkapnya</a>
            </div>
        </div>
        <div class="news-sidebar">
            <div class="news-item section-animation">
                <img alt="News Image 2" height="400"
                    src="https://storage.googleapis.com/a1aa/image/jdOUqj0qYey5N6DodX1hhb398f2xXSj11L7kHc3gUVGCeJNoA.jpg"
                    width="600" />
                <div class="news-item-content">
                    <p>2023-01-07 13:39:08</p>
                    <h3>UNJ Gelar Seminar Penguatan Ekosistem Moderasi Beragama Serta Luncurkan Griya Moderasi Beragama
                        dan Bela Negara</h3>
                    <p>Jakarta – Universitas Negeri Jakarta (UNJ) mengadakan seminar bertajuk "Penguatan Ekosistem
                        Moderasi Beragama"...</p>
                    <a class="read-more" href="#">Baca Selengkapnya</a>
                </div>
            </div>
            <div class="news-item section-animation">
                <img alt="News Image 3" height="400"
                    src="https://storage.googleapis.com/a1aa/image/nC9H1CxRnNa5IhTZoocDnV4m3pmWP2OfuiYeoXeIfbZE4TaQB.jpg"
                    width="600" />
                <div class="news-item-content">
                    <p>2023-01-07 13:39:08</p>
                    <h3>Sebanyak 108 Pejabat di Lingkungan UNJ Dilantik, Rektor Beri 5 Pesan Penting</h3>
                    <p>Humas UNJ, Jakarta – Sebanyak 108 pejabat di lingkungan Universitas Negeri Jakarta (UNJ) dilantik
                        untuk periode 2024-2029...</p>
                    <a class="read-more" href="#">Baca Selengkapnya</a>
                </div>
            </div>
            <div class="news-item">
                <img alt="News Image 4" height="400"
                    src="https://storage.googleapis.com/a1aa/image/MK0fRdgo4cyaLK2zEThybR9kWIP1Ms2wHlQPeCWUGMaAeJNoA.jpg"
                    width="600" />
                <div class="news-item-content">
                    <p>2023-01-07 13:39:08</p>
                    <h3>UNJ Gelar Seminar Penguatan Ekosistem Moderasi Beragama Serta Luncurkan Griya Moderasi Beragama
                        dan Bela Negara</h3>
                    <p>Jakarta – Universitas Negeri Jakarta (UNJ) mengadakan seminar bertajuk "Penguatan Ekosistem
                        Moderasi Beragama"...</p>
                    <a class="read-more" href="#">Baca Selengkapnya</a>
                </div>
            </div>
        </div>
    </div>
    </div>
    <div class="card" style="max-width: 190%; background-color: #2C6D71;">
        <div class="card-body">
            <div class="container">
                <div class="header">
                    <h1>PENGUMUMAN</h1>
                    <div class="underline"></div>
                </div>
                <div class="column">
                    <div class="cards">
                        <div class="card">
                            <h2>Pengumuman Lelang</h2>
                            <p>25-10-2024</p>
                        </div>
                        <div class="card">
                            <h2>Pengumuman Lelang</h2>
                            <p>25-10-2024</p>
                        </div>
                    </div>
                    <div class="small-underline"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="program-container">
        <div class="left-section">
            <div class="header">
                <img alt="Program Dan Layanan Icon" height="30"
                    src="https://storage.googleapis.com/a1aa/image/bUjsvzHgLYKqIlWzBurjLPFj9iDpEZmkYvc5h0Vlz01eekGUA.jpg"
                    width="30" />
                <div class="title">Program Dan Layanan</div>
            </div>
            <div class="description">Program dan Layanan Universitas Negeri Jakarta</div>
            <div class="link">Program dan layanan Lainnya</div>
        </div>
        <div class="program-card"></div>
        <div class="program-card"></div>
        <div class="program-card"></div>
    </div>
    <div class="card" style="max-width: 80%; margin: 20px auto; border-radius: 8px; overflow: hidden;">
        <div class="header-section">Panduan Program</div>
        <div class="data-container">
            <div class="data-message">Data Belum Tersedia</div>
            <button class="data-button">Lihat Panduan Lainnya</button>
        </div>
    </div>

    @include('footerlp')
    <!-- <footer class="footer">
    <div class="footer-left">
      <img alt="University Logo" height="50" src="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" width="50"/>
      <p>Universitas Negeri Jakarta</p>
      <p>Jl. Rawamangun Muka, RT.11/RW.14, Rawamangun, Pulo Gadung, East Jakarta City, Special Capital Region of Jakarta 13220</p>
      <p>+123123123</p>
      <p>info@yourmail.com</p>
      <p>Whatsapp</p>
    </div>
    <div class="footer-right">
      <img alt="Map" height="200" src="https://storage.googleapis.com/a1aa/image/lemWxTmjJbyuRinTcdVzKqB2CPO6XXMFWmL56jXQ11xe -->
