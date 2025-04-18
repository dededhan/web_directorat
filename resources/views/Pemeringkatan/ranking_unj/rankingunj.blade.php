<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reputation Center Universitas Brawijaya</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
    <link rel="stylesheet" href="{{ asset('home.css') }}">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }
        
        body {
            background-color: #f5f5f5;
        }
        
        .hero-section {
            position: relative;
            width: 100%;
            height: 300px;
            background-image: url('https://img.jakpost.net/c/2019/08/06/2019_08_06_77550_1565061483._large.jpg');
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.4);
        }
        
        .hero-content {
            position: relative;
            text-align: center;
            color: white;
            z-index: 1;
        }
        
        .hero-content h1 {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .hero-content p {
            font-size: 1rem;
            margin-bottom: 20px;
        }
        
        .hero-button {
            background-color: #00a8cc;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 3px;
            cursor: pointer;
            text-transform: uppercase;
            font-size: 0.8rem;
        }
        
        .ranking-section {
            padding: 30px 0 60px;
            text-align: center;
            background-color: #f5f5f5;
        }
        
        .ranking-title {
            font-size: 1.8rem;
            color: #333;
            margin-bottom: 40px;
            font-weight: 600;
        }
        
        .ranking-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        .ranking-card {
            background-color: white;
            border-radius: 30px;
            padding: 30px 20px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 200px;
            position: relative;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            margin: 5px;
            text-decoration: none;
            color: inherit;
        }
        
        .ranking-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.12);
        }
        
        .ranking-card img {
            height: 80px;
            width: auto;
            max-width: 100%;
            margin-bottom: 20px;
            object-fit: contain;
        }
        
        .ranking-card p {
            font-size: 0.9rem;
            text-align: center;
            color: #333;
            line-height: 1.4;
        }
        
        @media (max-width: 1024px) {
            .ranking-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }
        
        @media (max-width: 768px) {
            .ranking-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .ranking-card {
                height: 180px;
            }
        }
        
        @media (max-width: 480px) {
            .ranking-grid {
                grid-template-columns: 1fr;
            }
            
            .hero-content h1 {
                font-size: 1.8rem;
            }
            
            .ranking-card {
                height: 170px;
            }
        }
        
        .logo-container {
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }
    </style>
</head>
@include('Pemeringkatan.ranking_unj.navbarpemeringkatan')
<body>
    <div class="hero-section">
        <div class="hero-content">
            <h1>Reputation Center<br>Universitas Negeri Jakarta</h1>
            <p>Shaping Global Excellence, Empowering Future Leaders</p>
            <button class="hero-button">Selengkapnya</button> 
        </div>
    </div>
    
    <div class="ranking-section">
        <h2 class="ranking-title">Ranking Universitas Negeri Jakarta</h2>
        
        <div class="ranking-grid">
            <!-- All 7 cards with corresponding logos -->
            <a href="{{ route('Pemeringkatan.ranking_unj.Webometrics World University Ranking.Webometrics World University Ranking') }}" class="ranking-card"> 
                <div class="logo-container">
                    <img src="/images/logos/Webometrics-Logo.jpeg" alt="Webometrics Logo">
                </div>
                <p>Webometrics World University Ranking</p>
            </a>
            
            <a href="{{ route('Pemeringkatan.ranking_unj.Times Higher Education Impact Rankings.Times Higher Education Impact Rankings') }}" class="ranking-card"> 
                <div class="logo-container">
                    <img src="/images/logos/Times_Higher_Education_logo.png" alt="Times Higher Education Logo">
                </div>
                <p>Times Higher Education Impact Rankings</p>
            </a>
            
            <a href="{{ route('Pemeringkatan.ranking_unj.QS World University Ranking.QS World University Ranking') }}" class="ranking-card">
                <div class="logo-container">
                    <img src="/images/logos/QS world ranking.png"alt="QS World Ranking Logo">
                </div>
                <p>QS World University Ranking</p>
            </a>
            
            <a href="{{ route('Pemeringkatan.ranking_unj.QS Asian University Rankings.QS Asian University Rankings') }}" class="ranking-card">
                <div class="logo-container">
                    <img src="/images/logos/QS asian ranking.jpg" alt="QS Asian Ranking Logo">
                </div>
                <p>QS Asian University Rankings</p>
            </a>
            
            <a href="{{ route('Pemeringkatan.ranking_unj.UI Greenmetric World University Ranking.UI Greenmetric World University Ranking') }}" class="ranking-card">
                <div class="logo-container">
                    <img src="/images/logos/logo_uigm.png" alt="UI GreenMetric Logo">
                </div>
                <p>UI Greenmetric World University Ranking</p>
            </a>
            
            <a href="{{ route('Pemeringkatan.ranking_unj.Pemeringkatan Klaster Pendidikan Tinggi.Pemeringkatan Klaster Pendidikan Tinggi') }}" class="ranking-card">
                <div class="logo-container">
                    <img src="/images/logos/Logo_of_Ministry_of_Education_and_Culture_of_Republic_of_Indonesia.png" alt="Kementerian Pendidikan Logo"> 
                </div>
                <p>Pemeringkatan Klaster Pendidikan Tinggi</p> 
            </a>
            
            <a href="{{ route('Pemeringkatan.ranking_unj.AD Scientific Index.AD Scientific Index') }}" class="ranking-card">
                <div class="logo-container">
                    <img src="/images/logos/AD scientific index.jpeg" alt="AD Scientific Index Logo">
                </div>
                <p>AD Scientific Index</p>
            </a>
        </div>
    </div>
</body>
@include('Pemeringkatan.ranking_unj.footerpemeringkatan')
</html>