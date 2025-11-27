<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Organizational Chart with Photos</title>
   <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
    <link rel="stylesheet" href="{{ asset('home.css') }}">
    <script src="{{ asset('home.js') }}"></script>
  <style>
      * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: Arial, sans-serif;
    }
    
    /* Update padding-top sesuai dengan tinggi navbar */
    body {
      padding-top: 60px; /* Sesuaikan dengan height navbar */
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      margin: 0;
      overflow-x: hidden;
    }

    /* Pastikan z-index container lebih rendah dari navbar */
    
    .org-chart-wrapper {
      transform-origin: top center;
      position: relative;
      width: 1800px;
      height: auto; 
      min-height: auto; /* Increased min-height */
      overflow: visible;
      margin-bottom: 50px; /* Increased margin */
    }
    
    .org-chart {
      position: relative; /* Changed from absolute to relative */
      width: 1800px;
      height: auto;
      min-height: 1300px;
      transform-origin: top left;
    }
    
    .box {
      position: absolute;
      background-color: white;
      border: 1px solid #ccc;
      border-radius: 8px;
      text-align: center;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      z-index: 2;
      overflow: hidden;
      transition: all 0.3s ease;
      display: flex;
      flex-direction: column;
      align-items: center;
      padding-bottom: 10px;
    }
    
    .box:hover {
      box-shadow: 0 8px 16px rgba(0,0,0,0.2);
      transform: translateY(-5px);
      z-index: 3;
    }
    
    .photo {
      width: 80px;
      height: 80px;
      border-radius: 50%;
      margin: 10px auto 5px;
      background-color: #e0e0e0;
      background-size: cover;
      background-position: center;
      border: 3px solid #f0f0f0;
    }
    
    .info {
      padding: 0 10px;
      width: 100%;
    }
    
    .name {
    font-weight: bold;
    font-size: 14px;
    margin-bottom: 4px;
    white-space: normal; /* Ubah dari nowrap ke normal */
    word-wrap: break-word; /* Tambahkan ini */
    overflow: hidden;
    text-overflow: ellipsis;
  }

  .position {
    font-size: 12px;
    color: #555;
    white-space: normal; /* Ubah dari nowrap ke normal */
    word-wrap: break-word; /* Tambahkan ini */
    overflow: hidden;
    text-overflow: ellipsis;
  }
    
    /* Lines */
    .line {
      position: absolute;
      background-color: #666;
      z-index: 1;
    }
    
    .vertical {
      width: 2px;
    }
    
    .horizontal {
      height: 2px;
    }
    
    
    /* Auto-scaling - improved to prevent overlap */
    @media (max-width: 1850px) {
      .org-chart-wrapper {
        transform: scale(calc(100vw / 1850));
        transform-origin: top center;
        margin-bottom: calc(100vw / 1850 * 200px);
      }
    }
    
    @media (max-width: 1850px) and (max-height: 1350px) {
      .org-chart-wrapper {
        transform: scale(min(calc(100vw / 1850), calc(100vh / 1350)));
      }
    }
    
    @media print {
      body {
        overflow: visible;
        padding: 0;
      }
      .container {
        min-width: auto;
        min-height: auto;
      }
      .org-chart-wrapper {
        transform: none;
        width: 100%;
        height: auto;
      }
      .org-chart {
        position: relative;
        transform: none;
      }
    }
    .navabr {
      text; align: center;
    }
    
    /* Ubah style untuk footer */
    .footer {
      width: 100%;
      background-color: #f8f9fa;
      text-align: center;
      padding: 10px 0; /* Sesuaikan padding */
      margin-top: auto; /* Tambahkan ini */
    }
  </style>
</head>
@include('layout.navbar')
<body>
  <h1 style="text-align: center; font-size: 36px; font-weight: bold; margin-bottom: 40px; margin-top: 20px; color: #1A535C; font-family: 'Roboto', sans-serif; text-transform: uppercase; letter-spacing: 2px;">
    Struktur Organisasi
  </h1>
  <div class="container" style="margin-right: auto; margin-left: auto; display: flex; justify-content: 300px; align-items: 100px;">
    <div class="org-chart-wrapper">
      <div class="org-chart">
        <!-- Level 1: Rektor -->
        <div class="box" style="left: 30px; top: 60px; width: 200px; height: 180px;">
          <div class="photo" style="background-image: url('https://cdn-1.timesmedia.co.id/images/2025/02/23/UNJ-Prof-Komarudin.jpg');"></div>
          <div class="info">
            <div class="name">Prof. Dr. Komarudin, M.Si</div>
            <div class="position">REKTOR</div>
          </div>
        </div>
        
        <!-- Vertical line from Rektor to WR III -->
        <div class="line vertical" style="left: 129.5px; top: 240px; height: 40px;"></div>
        
        <!-- Level 2: Wakil Rektor -->
        <div class="box" style="left: 10px; top: 280px; width: 240px; height: 180px;">
          <div class="photo" style="background-image: url('https://fip.unj.ac.id/wp-content/uploads/2022/10/Prof-Fahrurrozi.jpg');"></div>
          <div class="info">
            <div class="name">Prof. Dr. Fahrurrozi, M.Pd</div>
            <div class="position">WAKIL REKTOR BID. RISET, INOVASI DAN SISTEM INFORMASI</div>
          </div>
        </div>
        
        <!-- Vertical line from WR III to Direktur -->
        <div class="line vertical" style="left: 129.5px; top: 460px; height: 651px;"></div>
        
        <!-- Level 3: Direktur -->
        <div class="box" style="left: 0px; top: 500px; width: 260px; height: 180px;">
          <div class="photo" style="background-image: url('images/murti.jpg');"></div>
          <div class="info">
            <div class="name">Dr.R.A. Murti Kusuma W. S.IP. M.Si.</div>
            <div class="position">DIREKTOR INOVASI, SISTEM INFORMASI DAN PEMERINGKATAN</div>
          </div>
        </div>
        
        <!-- Horizontal line from Direktur -->
        <div class="line horizontal" style="left: 130px; top: 480px; width: 1007px;"></div>
        
        <!-- Vertical lines to different branches -->
        <div class="line vertical" style="left: 620px; top: 483px; height: 80px;"></div>
        <div class="line vertical" style="left: 1135px; top: 483px; height: 110px;"></div>
        
        <!-- Horizontal line for Staf Ahli WR III -->
        <div class="line horizontal" style="left: 420px; top: 563px; width: 400px;"></div>
        
        <!-- Vertical lines to each Staf Ahli -->
        <div class="line vertical" style="left: 420px; top: 563px; height: 30px;"></div>
        <div class="line vertical" style="left: 620px; top: 563px; height: 30px;"></div>
        <div class="line vertical" style="left: 820px; top: 563px; height: 30px;"></div>
        
        <!-- Level 4: Staf Ahli WR III -->
        <div class="box" style="left: 320px; top: 593px; width: 200px; height: 200px;">
          <div class="photo" style="background-image: url('images/vera.jpg');"></div>
          <div class="info">
            <div class="name">Dr. Vera Utami Gede Putri, M.Ds</div>
            <div class="position">Staf Ahli WR III</div>
            <div class="position">Bid. Inovasi dan Hilirisasi</div>
          </div>
        </div>
        
        <div class="box" style="left: 520px; top: 593px; width: 200px; height: 200px;">
          <div class="photo" style="background-image: url('https://ft.unj.ac.id/wp-content/uploads/2021/10/Massus-Subekti-S.Pd_.-M.T..png');"></div>
          <div class="info">
            <div class="name">Massus Subekti, S.Pd, M.T.</div>
            <div class="position">Staf Ahli WR III</div>
            <div class="position">Bid. Sistem Informasi</div>
          </div>
        </div>
        
        <div class="box" style="left: 720px; top: 593px; width: 200px; height: 200px;">
          <div class="photo" style="background-image: url('https://fip.unj.ac.id/wp-content/uploads/2022/06/Uswatun-Hasanah.jpg');"></div>
          <div class="info">
            <div class="name">Dr. Uswatun Hasanah, M.Pd.</div>
            <div class="position">Staf Ahli WR III</div>
            <div class="position">Bid. Pemeringkatan</div>
          </div>
        </div>
        
        <!-- Level 4: Hubungan Masyarakat -->
        <div class="box" style="left: 1020px; top: 560px; width: 220px; height: 180px;">
          <div class="photo" style="background-image: url('https://fis.unj.ac.id/bose/wp-content/uploads/2023/12/Syaifudin-M.-Kesos.png');"></div>
          <div class="info">
            <div class="name">Syaifudin, S.Pd, M.Kesos.</div>
            <div class="position">Kepala Kantor Hubungan Masyarakat dan Informasi Publik</div>
          </div>
        </div>
        
        <!-- Lines for Sekretaris -->
        <div class="line horizontal" style="left: 1240px; top: 650px; width: 262px;"></div>
        <div class="line vertical" style="left: 1500px; top: 650px; height: 50px;"></div>
        
        <!-- Level 5: Sekretaris -->
        <div class="box" style="left: 1400px; top: 700px; width: 200px; height: 200px;">
          <div class="photo" style="background-image: url('/api/placeholder/150/150');"></div>
          <div class="info">
            <div class="name">Nada Arina Romli, S.I.Kom, M.I.kom.</div>
            <div class="position">Seketaris Kantor Hubungan Masyarakat dan Informasi Publik</div>
          </div>
        </div>
        
        <!-- Vertical line from Kepala to Divisi -->
        <div class="line vertical" style="left: 1130px; top: 740px; height: 90px;"></div>
        
        <!-- Horizontal line for Divisi -->
        <div class="line horizontal" style="left: 1000px; top: 830px; width: 260px;"></div>
        
        <!-- Vertical lines to each Divisi -->
        <div class="line vertical" style="left: 1000px; top: 830px; height: 30px;"></div>
        <div class="line vertical" style="left: 1257px; top: 830px; height: 30px;"></div>
        
        <!-- Level 5: Divisi Hubmas -->
        <div class="box" style="left: 906px; top: 860px; width: 200px; height: 220px;">
          <div class="photo" style="background-image: url('https://fis.unj.ac.id/bose/wp-content/uploads/2024/01/2-Prima-Yustitia-Nurul-Islami-S.KPm_.-M.Si_.png');"></div>
          <div class="info">
            <div class="name">Prima Yustitia Nurul Islami, S.KPm, M,Si</div>
            <div class="position">Kepala Divisi Layanan Informasi Kantor Hubungan Masyarakat dan Informasi Publik</div>
          </div>
        </div>
        
        <div class="box" style="left: 1160px; top: 860px; width: 200px; height: 220px;">
          <div class="photo" style="background-image: url('https://fis.unj.ac.id/wp-content/uploads/2024/03/Foto-Dosen-FIS-22-Wina-Puspita-Sari.jpg');"></div>
          <div class="info">
            <div class="name">Wina Puspita Sari, M.Si</div>
            <div class="position">Kepala Divisi Peliputan dan Pemberitaan Kantor Hubungan Masyarakat dan Informasi Publik</div>
          </div>
        </div>
        
        <!-- Vertical line from Direktur to bawah -->
        <div class="line vertical" style="left: 129px; top: 680px; height: 260px;"></div>
        
        <!-- Horizontal line untuk Kepala Subdit -->
        <div class="line horizontal" style="left: -10px; top: 800px; width: 280px;"></div>
        
        <!-- Vertical lines to each Subdit -->
        <div class="line vertical" style="left: -10px; top: 800px; height: 30px;"></div>
        <div class="line vertical" style="left: 270px; top: 800px; height: 30px;"></div>
        
        <!-- Level 4: Kepala Subdit -->
        <div class="box" style="left: -110px; top: 830px; width: 200px; height: 200px;">
          <div class="photo" style="background-image: url('data:image/jpeg;base64,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');"></div>
          <div class="info">
            <div class="name">Taryudi, ST, MT, Ph.D.</div>
            <div class="position">Kepala Subdit Inovasi dan Hilirisasi</div>
          </div>
        </div>
        
        <div class="box" style="left: 170px; top: 830px; width: 200px; height: 200px;">
          <div class="photo" style="background-image: url('https://fmipa.unj.ac.id/s2pmath/wp-content/uploads/2023/08/Pak-Tian-2.jpeg');"></div>
          <div class="info">
            <div class="name">Tian Abdul Azis, S.Pd, Ph.D.</div>
            <div class="position">Kepala Subdit Pemeringkatan dan Sistem Informasi</div>
          </div>
        </div>
        
        <!-- Horizontal line untuk Staff -->
        <div class="line horizontal" style="left: -270px; right: 10px; top: 1110px; width: 1400px;"></div>
        
        <!-- Vertical lines to each Staff -->
        <div class="line vertical" style="left: -270px; top: 1110px; height: 30px;"></div>
        <div class="line vertical" style="left: -70px; top: 1110px; height: 30px;"></div>
        <div class="line vertical" style="left: 130px; top: 1110px; height: 30px;"></div>
        <div class="line vertical" style="left: 330px; top: 1110px; height: 30px;"></div>
        <div class="line vertical" style="left: 530px; top: 1110px; height: 30px;"></div>
        <div class="line vertical" style="left: 730px; top: 1110px; height: 30px;"></div>
        <div class="line vertical" style="left: 930px; top: 1110px; height: 30px;"></div>
        <div class="line vertical" style="left: 1130px; top: 1110px; height: 30px;"></div>
        
        <!-- Level 5: Staff -->
        <div class="box" style="left: -360px; top: 1140px; width: 180px; height: 200px;">
          <div class="photo" style="background-image: url('/api/placeholder/150/150');"></div>
          <div class="info">
            <div class="name">Irna Khaerunnisa Azzahra, S.S.</div>
            <div class="position">Staf</div>
          </div>
        </div>
        
        <div class="box" style="left: -160px; top: 1140px; width: 180px; height: 200px;">
          <div class="photo" style="background-image: url('/api/placeholder/150/150');"></div>
          <div class="info">
            <div class="name">Nungky Ratna Anggraini, S.E.</div>
            <div class="position">Staf</div>
          </div>
        </div>
        
        <div class="box" style="left: 40px; top: 1140px; width: 180px; height: 200px;">
          <div class="photo" style="background-image: url('images/hana.jpg');"></div>
          <div class="info">
            <div class="name">Hana Nurina, S.Sos</div>
            <div class="position">Staf</div>
          </div>
        </div>
        
        <div class="box" style="left: 240px; top: 1140px; width: 180px; height: 200px;">
          <div class="photo" style="background-image: url('images/yusi.jpg');"></div>
          <div class="info">
            <div class="name">Yusi Rahmaniar, S.E, M.M</div>
            <div class="position">Staf</div>
          </div>
        </div>
        
        <div class="box" style="left: 440px; top: 1140px; width: 180px; height: 200px;">
          <div class="photo" style="background-image: url('/api/placeholder/150/150');"></div>
          <div class="info">
            <div class="name">Ririn Listiana</div>
            <div class="position">Staf</div>
          </div>
        </div>
        
        <div class="box" style="left: 640px; top: 1140px; width: 180px; height: 200px;">
          <div class="photo" style="background-image: url('/api/placeholder/150/150');"></div>
          <div class="info">
            <div class="name">Maulana Irfan, S.E.</div>
            <div class="position">Staf</div>
          </div>
        </div>
        
        <div class="box" style="left: 840px; top: 1140px; width: 180px; height: 200px;">
          <div class="photo" style="background-image: url('/api/placeholder/150/150');"></div>
          <div class="info">
            <div class="name">Edi Supriadi</div>
            <div class="position">Driver</div>
          </div>
        </div>
        
        <div class="box" style="left: 1040px; top: 1140px; width: 180px; height: 200px;">
          <div class="photo" style="background-image: url('/api/placeholder/150/150');"></div>
          <div class="info">
            <div class="name">Abdullah Ferry</div>
            <div class="position">Driver</div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <footer class="footer">
    @include('layout.footer')
  </footer>
</body>
</html>