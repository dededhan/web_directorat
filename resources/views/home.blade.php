<!-- resources/views/home.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Direktorat Pemeringkatan</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }
        .navbar {
            background-color: #006666;
            display: flex;
            align-items: center;
            padding: 10px 20px;
        }
        .navbar img {
            height: 50px;
            margin-right: 20px;
        }
        .navbar .title {
            color: #ffcc00;
            font-size: 20px;
            font-weight: bold;
            margin-right: auto;
        }
        .navbar a {
            color: white;
            text-decoration: none;
            margin: 0 15px;
            font-size: 16px;
        }
        .navbar .dropdown {
            position: relative;
            display: inline-block;
        }
        .navbar .dropdown-content {
            display: none;
            position: absolute;
            background-color: #006666;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
        }
        .navbar .dropdown-content a {
            color: white;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }
        .navbar .dropdown:hover .dropdown-content {
            display: block;
        }
        .navbar .login {
            border: 2px solid white;
            padding: 5px 15px;
            border-radius: 5px;
        }
        .main-image {
                width: 100vw; /* Lebar penuh layar */
                height: 100vh; /* Tinggi penuh layar */
                object-fit: cover; /* Menjaga proporsi gambar */
            }
        @media (max-width: 768px) {
            .navbar {
                flex-direction: column;
                align-items: flex-start;
            }
            .navbar a {
                margin: 5px 0;
            }
            .navbar .login {
                margin-top: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="navbar">
        <img alt="Logo of Direktorat Pemeringkatan" height="50" src="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" width="50"/>
        <div class="title">Direktorat Pemeringkatan</div>
        <a href="#">Beranda</a>
        <div class="dropdown">
            <a href="#">Sub Direktorat <i class="fa fa-caret-down"></i></a>
            <div class="dropdown-content">
                <a href="#">Sub Direktorat 1</a>
                <a href="#">Sub Direktorat 2</a>
                <a href="#">Sub Direktorat 3</a>
            </div>
        </div>
        <a href="#">Berita</a>
        <a href="#">Program</a>
        <a href="#">Galeri</a>
        <a class="login" href="#">Masuk</a>
    </div>
    <img alt="Image of Universitas Negeri Jakarta" class="main-image" height="1080" src="https://maukuliah.ap-south-1.linodeobjects.com/gallery/001037/Gedung%203%20UNJ-thumbnail.jpg" width="1920" />
</body>
</html>

<html>
 <head>
  <title>
   Berita Terkini
  </title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&amp;display=swap" rel="stylesheet"/>
  <style>
   body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }
        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px 0;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            font-size: 2em;
            margin: 0;
        }
        .header hr {
            width: 50px;
            border: 2px solid #00695c;
            margin: 10px auto;
        }
        .content {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }
        .main-news {
            flex: 2;
        }
        .side-news {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        .news-item {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .news-item img {
            width: 100%;
            height: auto;
        }
        .news-content {
            padding: 15px;
        }
        .news-content .date {
            font-size: 0.8em;
            color: #757575;
            margin-bottom: 10px;
        }
        .news-content .title {
            font-size: 1em;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .news-content .description {
            font-size: 0.8em;
            color: #333;
        }
        .news-content .read-more {
            display: inline-block;
            margin-top: 10px;
            padding: 10px 15px;
            background-color: #00695c;
            color: #fff;
            border-radius: 5px;
            text-decoration: none;
            font-size: 0.9em;
        }
        .news-content .read-more:hover {
            background-color: #004d40;
        }
        @media (max-width: 768px) {
            .content {
                flex-direction: column;
            }
        }
  </style>
 </head>
 <body>
  <div class="container">
   <div class="header">
    <h1>
     BERITA TERKINI
    </h1>
    <hr/>
   </div>
   <div class="content">
    <div class="main-news">
     <div class="news-item">
      <img alt="Group of people in a conference room" height="400" src="https://storage.googleapis.com/a1aa/image/JjO5t7syL3U5ZJlH2vyBVvIX5HBeoEKqFAnkU-kYj0w.jpg" width="800"/>
      <div class="news-content">
       <div class="date">
        <i class="far fa-calendar-alt">
        </i>
        2025-01-10 06:27:01
       </div>
       <div class="title">
        UNJ-UiTM: Sinergi Dua Negara untuk Kepemimpinan Global
       </div>
       <div class="description">
        Jakarta, Humas UNJ – Universitas Negeri Jakarta (UNJ) sukses menggelar diskusi kolaborasi bertajuk “The Leadership Literacy Program LEAD 2024: Malaysia-Indonesia Nextgen Leadership Vanguard” bersama Universiti Teknologi MARA (UiTM) Malaysia. Acara yang berlangsung di Gedung M. Syafe’i, lantai 6 pada 10 Januari 2025 ini dihadiri oleh Direktur Kemahasiswaan dan Alumni, Sekretaris Kantor Urusan Internasional, Kepala Bidang […]
       </div>
       <a class="read-more" href="#">
        Baca Selengkapnya
       </a>
      </div>
     </div>
    </div>
    <div class="side-news">
     <div class="news-item">
      <img alt="Group of people in a seminar" height="150" src="https://storage.googleapis.com/a1aa/image/Jhnk7RHoGh4oarnMcOBo9-HJRQzbksghoT14tvBbaW8.jpg" width="300"/>
      <div class="news-content">
       <div class="date">
        <i class="far fa-calendar-alt">
        </i>
        2025-01-07 13:39:08
       </div>
       <div class="title">
        UNJ Gelar Seminar Penguatan Ekosistem Moderasi Beragama Serta Luncurkan Griya Moderasi Beragama dan Bela Negara
       </div>
       <div class="description">
        Jakarta – Universitas Negeri Jakarta (UNJ) mengadakan seminar bertajuk “Penguatan Ekosistem Moderasi Beragama”...
       </div>
      </div>
     </div>
     <div class="news-item">
      <img alt="Group of people in a conference room" height="150" src="https://storage.googleapis.com/a1aa/image/JjO5t7syL3U5ZJlH2vyBVvIX5HBeoEKqFAnkU-kYj0w.jpg" width="300"/>
      <div class="news-content">
       <div class="date">
        <i class="far fa-calendar-alt">
        </i>
        2025-01-07 13:39:08
       </div>
       <div class="title">
        Sebanyak 108 Pejabat di Lingkungan UNJ Dilantik, Rektor Beri 5 Pesan Penting
       </div>
       <div class="description">
        Humas UNJ, Jakarta – Sebanyak 108 pejabat di lingkungan Universitas Negeri Jakarta (UNJ) dilantik untuk periode 2024-2029...
       </div>
      </div>
     </div>
     <div class="news-item">
      <img alt="Group of people in a seminar" height="150" src="https://storage.googleapis.com/a1aa/image/Jhnk7RHoGh4oarnMcOBo9-HJRQzbksghoT14tvBbaW8.jpg" width="300"/>
      <div class="news-content">
       <div class="date">
        <i class="far fa-calendar-alt">
        </i>
        2025-01-07 13:39:08
       </div>
       <div class="title">
        UNJ Gelar Seminar Penguatan Ekosistem Moderasi Beragama Serta Luncurkan Griya Moderasi Beragama dan Bela Negara
       </div>
       <div class="description">
        Jakarta – Universitas Negeri Jakarta (UNJ) mengadakan seminar bertajuk “Penguatan Ekosistem Moderasi Beragama”...
       </div>
      </div>
     </div>
    </div>
   </div>
  </div>
 </body>
</html>
