<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reputation Center Universitas Brawijaya</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" type="image/png">
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

        html {
            scroll-behavior: smooth;
            /* Add smooth scrolling to the entire page */
        }

        body {
            background-color: #f5f5f5;
        }

        .hero-section {
            position: relative;
            width: 100%;
            height: 300px;
            background-image: url("/images/GEDUNG REKTORAT.png");
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
            background-color: #277177;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 3px;
            cursor: pointer;
            text-transform: uppercase;
            font-size: 0.8rem;
            transition: background-color 0.3s ease;
            /* Add smooth transition for button hover */
            margin: 0 5px;
            /* Add margin for spacing between buttons */
        }

        .hero-button:hover {
            background-color: #277177;
            /* Darker shade for hover state */
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
            gap: 30px;
            /* Increased from 20px */
            max-width: 1500px;
            /* Increased from 1200px */
            margin: 0 auto;
            padding: 0 20px;
        }

        .ranking-card {
            background-color: white;
            border-radius: 30px;
            padding: 50px 35px;
            /* Increased from 30px 20px */
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 250px;
            /* Increased from 200px */
            position: relative;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            margin: 8px;
            /* Increased from 5px */
            text-decoration: none;
            color: inherit;
        }

        .ranking-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.12);
        }

        .ranking-card img {
            height: 100px;
            /* Increased from 80px */
            width: auto;
            max-width: 100%;
            margin-bottom: 25px;
            /* Increased from 20px */
            object-fit: contain;
        }

        .ranking-card p {
            font-size: 1.1rem;
            /* Increased from 0.9rem */
            text-align: center;
            color: #333;
            line-height: 1.5;
            /* Increased from 1.4 */
        }

        /* Indikator Pemeringkatan section */
        .indikator-section {
            background-color: #277177;
            padding: 15px 0;
            margin-bottom: 0;
            /* No margin at bottom since it will be directly above info-section */
        }

        .indikator-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .indikator-title {
            color: white;
            font-size: 1.4rem;
            font-weight: 600;
            margin: 0;
        }

        .indikator-search {
            width: 300px;
        }

        .indikator-search input {
            width: 100%;
            padding: 8px 12px;
            border-radius: 4px;
            border: 1px solid #164044;
            background-color: #edf2f7;
            font-size: 0.9rem;
        }

        .indikator-search input:focus {
            outline: none;
            border-color: #277177;
            box-shadow: 0 0 0 2px rgba(0, 168, 204, 0.2);
        }

        @media (max-width: 1024px) {
            .ranking-grid {
                grid-template-columns: repeat(3, 1fr);
            }

            .ranking-card {
                height: 230px;
                /* Adjusted for tablet */
            }
        }

        @media (max-width: 768px) {
            .ranking-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 20px;
                /* Reduced gap for smaller screens */
            }

            .ranking-card {
                height: 220px;
                /* Adjusted for mobile */
            }

            .indikator-container {
                flex-direction: column;
                align-items: flex-start;
            }

            .indikator-title {
                margin-bottom: 10px;
            }

            .indikator-search {
                width: 100%;
            }

            .hero-buttons {
                display: flex;
                flex-direction: column;
                align-items: center;
            }

            .hero-button {
                margin: 5px 0;
                width: 80%;
            }
        }

        @media (max-width: 480px) {
            .ranking-grid {
                grid-template-columns: 1fr;
            }

            .ranking-card {
                height: 200px;
                /* Slightly smaller for very small screens */
            }

            .hero-content h1 {
                font-size: 1.8rem;
            }

            .ranking-card {
                height: 170px;
            }
        }

        .logo-container {
            height: 100px;
            /* Increased from 80px */
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 25px;
            /* Increased from 20px */
        }

        /* Additional styles for the information section */
        .info-section {
            display: flex;
            max-width: 100%;
            margin: 0 auto 20px;
            /* Added bottom margin to create space before footer */
            padding: 0;
            background-color: #fff;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
        }

        .info-sidebar {
            width: 180px;
            min-width: 180px;
            background-color: #277177;
            border-right: 1px solid #eaeaea;
        }

        .info-sidebar ul {
            list-style: none;
        }

        .info-sidebar li {
            border-bottom: 1px solid #1e575b;
        }

        .info-sidebar a {
            display: block;
            padding: 12px 15px;
            color: white;
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 0.9rem;
            background-color: #277177;
        }

        .info-sidebar a:hover,
        .info-sidebar a.active {
            background-color: white;
            color: #277177;
        }

        .info-content {
            flex: 1;
            padding: 25px;
        }

        .info-content h2 {
            font-size: 1.4rem;
            color: #333;
            margin-bottom: 15px;
            font-weight: 600;
        }

        .info-content p {
            color: #666;
            line-height: 1.5;
            margin-bottom: 15px;
            font-size: 0.95rem;
        }

        /* Create space for footer */
        .footer-spacer {
            height: 10px;
            /* Additional space before footer */
        }

        .indikator-banner {
            background-color: #207177;
            padding: 15px 0;
            text-align: center;
            width: 100%;
        }

        .indikator-banner h2 {
            color: white;
            font-size: 1.8rem;
            /* Match the font size of ranking-title */
            font-weight: 600;
            margin: 0;
        }

        /* Style for the button container */
        .hero-buttons {
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        @media (max-width: 768px) {
            .info-section {
                flex-direction: column;
                margin-bottom: 10px;
                /* Slightly less space on mobile */
            }

            .info-sidebar {
                width: 100%;
                border-right: none;
                border-bottom: 1px solid #eaeaea;
            }

            .footer-spacer {
                height: 10px;
                /* Slightly less space on mobile */
            }
        }
    </style>
</head>
@include('layout.navbar_pemeringkatan')

<body>
    <div class="hero-section">
        <div class="hero-content">
            <h1>PUSAT PEMERINGKATAN<br>Universitas Negeri Jakarta</h1>
            <p>Shaping Global Excellence, Empowering Future Leaders</p>
            <div class="hero-buttons">
                <button class="hero-button"
                    onclick="document.querySelector('.ranking-section').scrollIntoView({behavior: 'smooth'})">Selengkapnya</button>
            </div>
        </div>
    </div>

    <div class="ranking-section" id="rankings">
        <h2 class="ranking-title">Ranking Universitas Negeri Jakarta</h2>

        <div class="ranking-grid">
            <!-- Pemeringkatan Klaster Pendidikan Tinggi (SINTA) -->
            <a href="https://sinta.kemdikbud.go.id/affiliations/profile/435" class="ranking-card" target="_blank"
                rel="noopener noreferrer">
                <div class="logo-container">
                    <img src="/images/logos/Logo_of_Ministry_of_Education_and_Culture_of_Republic_of_Indonesia.png"
                        alt="Kementerian Pendidikan Logo">
                </div>
                <p>Pemeringkatan Klaster Pendidikan Tinggi</p>
            </a>

            <!-- QS World University Ranking -->
            <a href="https://www.topuniversities.com/universities/universitas-negeri-jakarta" class="ranking-card"
                target="_blank" rel="noopener noreferrer">
                <div class="logo-container">
                    <img src="/images/logos/QS world ranking.png" alt="QS World Ranking Logo">
                </div>
                <p>QS World University Ranking</p>
            </a>

            <!-- QS Asian University Rankings -->
            <a href="https://www.topuniversities.com/universities/universitas-negeri-jakarta" class="ranking-card"
                target="_blank" rel="noopener noreferrer">
                <div class="logo-container">
                    <img src="/images/logos/QS asian ranking.jpg" alt="QS Asian Ranking Logo">
                </div>
                <p>QS Asian University Rankings</p>
            </a>
            <!-- Times Higher Education Impact Rankings -->
            <a href="https://www.timeshighereducation.com/world-university-rankings/universitas-negeri-jakarta"
                class="ranking-card" target="_blank" rel="noopener noreferrer">
                <div class="logo-container">
                    <img src="/images/logos/Times_Higher_Education_logo.png" alt="Times Higher Education Logo">
                </div>
                <p>Times Higher Education Impact Rankings</p>
            </a>
            <!-- Webometrics World University Ranking -->
            <a href="https://www.webometrics.info/en/Asia/Indonesia%20" class="ranking-card" target="_blank"
                rel="noopener noreferrer">
                <div class="logo-container">
                    <img src="/images/logos/Webometrics-Logo.jpeg" alt="Webometrics Logo">
                </div>
                <p>Webometrics World University Ranking</p>
            </a>

            <!-- UI Greenmetric World University Ranking -->
            <a href="https://greenmetric.ui.ac.id/" class="ranking-card" target="_blank" rel="noopener noreferrer">
                <div class="logo-container">
                    <img src="/images/logos/logo_uigm.png" alt="UI GreenMetric Logo">
                </div>
                <p>UI Greenmetric World University Ranking</p>
            </a>

            <!-- Scimago Institutions Rankings -->
            <a href="https://www.scimagoir.com/institution.php?idp=3796" class="ranking-card" target="_blank"
                rel="noopener noreferrer">
                <div class="logo-container">
                    <img src="/images/logos/scimago.png" alt="Scimago Logo">
                </div>
                <p>Scimago Institutions Rankings</p>
            </a>
        </div>

    </div>

    {{-- <div class="ranking-section" id="rankings">
        <h2 class="ranking-title">Ranking Universitas Negeri Jakarta</h2>
        
        <div class="ranking-grid">
            <!-- Dynamic ranking cards from database -->
            @foreach ($rankings as $ranking)
            <a href="{{ route('ranking.show', $ranking->slug) }}" class="ranking-card"> 
                <div class="logo-container">
                    <img src="{{ asset('storage/' . $ranking->gambar) }}" alt="{{ $ranking->judul }}">
                </div>
                <p>{{ $ranking->judul }}</p>
            </a>
            @endforeach
        </div>
    </div> --}}

    <!-- Replaced banner with a centered button -->
    <div style="text-align: center; padding: 20px 0; background-color: #f5f5f5;">
        <a href="{{ route('Pemeringkatan.indikator.indikator') }}" class="hero-button"
            style="font-size: 1rem; padding: 12px 25px;">Indikator Pemeringkatan</a>
    </div>

    <!-- Added padding/margin to prevent footer overlap -->
    <div class="footer-spacer" style="height: 50px;"></div>

</body>
@include('layout.footer')

</html>
