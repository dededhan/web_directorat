<html>
 <head>
  <title>
   Galeri - Subdirektorat Pemeringkatan
  </title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&amp;display=swap" rel="stylesheet"/>
  <style>
   body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            overflow-x: hidden;
        }
        header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 20px;
            background-color: #fff;
            border-bottom: 1px solid #ddd;
        }
        header img {
            height: 50px;
        }
        header nav a {
            margin: 0 10px;
            text-decoration: none;
            color: #000;
            font-weight: 700;
        }
        header .language {
            display: flex;
            align-items: center;
        }
        header .language i {
            margin-left: 5px;
        }
        .hero {
        position: relative;
        text-align: center;
        color: white;
        max-height: 300px; 
        overflow: hidden; 
          }

        .hero img {
            width: 100%;
            height: 300px; 
            object-fit: cover; 
        }

        .hero .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        .hero .overlay h1 {
            margin: 0;
            font-size: 2.5em;
        }
        .hero .overlay p {
            margin: 5px 0;
        }
        .content {
            padding: 10px;
            text-align: center;
        }
        .content h2 {
            margin: 10px 0;
            font-size: 1.5em;
        }
        .gallery {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
        }
        .gallery-item {
            margin: 5px;
            border: 1px solid #ddd;
            padding: 5px;
            width: calc(45% - 20px);
            max-width: 520px;
            box-sizing: border-box;
        }
        .gallery-item img {
            width: 100%;
            height: auto;
        }
        .gallery-item .more {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 5px;
            text-decoration: none;
            color: #000;
        }
        .gallery-item .more i {
            margin-left: 5px;
        }
        @media (max-width: 768px) {
            .gallery-item {
                width: calc(100% - 20px);
            }
        }
  </style>
 </head>
 <body>
  <header>
   <img alt="Logo Subdirektorat Pemeringkatan" src="https://spm.unj.ac.id/wp-content/uploads/2024/08/cropped-Logo-UNJ-PTNBH-RGB_Logo_Motto_Transparan.png"/>
   <nav>
    <a href="#">
     Beranda
    </a>
    <a href="#">
     Galeri
    </a>
   </nav>
   <div class="language">
    <span>
     ID
    </span>
    <i class="fas fa-globe">
    </i>
   </div>
  </header>
  <div class="hero">
   <img alt="Universitas Negeri Jakarta" src="https://lh3.googleusercontent.com/p/AF1QipMn8OaEgUx7UfdcNKcNr1eEzwd-LJj-4rNfzSsn=s680-w680-h510"/>
   <div class="overlay">
    <h1>Galeri</h1>
    <p>Home / Galeri</p>
   </div>
</div>
  </div>
  <div class="content">
   <h2>
    Prestasi Mahasiswa
   </h2>
   <div class="gallery">
    <div class="gallery-item">
     <img alt="Mahasiswa berprestasi di podium" src="https://placehold.co/300x200"/>
     <a class="more" href="#">
      Selengkapnya
      <i class="fas fa-arrow-circle-right">
      </i>
     </a>
    </div>
    <div class="gallery-item">
     <img alt="Mahasiswa berprestasi dalam seni bela diri" src="https://placehold.co/300x200"/>
     <a class="more" href="#">
      Selengkapnya
      <i class="fas fa-arrow-circle-right">
      </i>
     </a>
    </div>
   </div>
   <h2>
    Lorem Ipsum
   </h2>
   <div class="gallery">
    <div class="gallery-item">
     <img alt="Placeholder image" src="https://placehold.co/300x200"/>
     <a class="more" href="#">
      Selengkapnya
      <i class="fas fa-arrow-circle-right">
      </i>
     </a>
    </div>
    <div class="gallery-item">
     <img alt="Placeholder image" src="https://placehold.co/300x200"/>
     <a class="more" href="#">
      Selengkapnya
      <i class="fas fa-arrow-circle-right">
      </i>
     </a>
    </div>
   </div>
  </div>
 </body>
</html>
@include('pemeringkatan.footerpemeringkatan')
