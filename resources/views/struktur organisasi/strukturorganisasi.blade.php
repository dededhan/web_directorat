<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struktur Organisasi</title>
    <style>
        :root {
            --primary-color: #176369; 
            --secondary-color: #1C7A7A; 
            --accent-color: #FFA500; 
            --text-color: #333;
            --background-color: #f5f5f5;
            --card-color: #ffffff;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: var(--background-color);
            color: var(--text-color);
            line-height: 1.6;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 30px 20px;
        }

        header {
            text-align: center;
            margin-bottom: 40px;
            position: relative;
            color: #176369;
        }

        header:after {
            content: "";
            display: block;
            width: 100px;
            height: 4px;
            background-color: var(--accent-color);
            margin: 15px auto 0;
            border-radius: 2px;
        }

        h1 {
            color: var(--primary-color);
            font-size: 36px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin: 0;
        }

        .content-card {
            background-color: var(--card-color);
            border-radius: 8px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
            padding: 50px; /* Diperbesar */
            margin-bottom: 40px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .content-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.1);
        }

        .org-structure-img {
            width: 100%;
            max-width: 1500px; /* Diperbesar */
            height: auto;
            display: block;
            margin: 0 auto;
            border-radius: 6px;
        }

        .img-container {
            position: relative;
            margin-bottom: 25px;
            text-align: center;
        }

        .img-caption {
            text-align: center;
            margin-top: 20px;
            color: var(--secondary-color);
            font-size: 16px;
            font-weight: 500;
        }

        .description {
            text-align: center;
            max-width: 800px;
            margin: 0 auto 30px;
            color: #555;
            font-size: 18px;
        }

        footer {
            text-align: center;
            margin-top: 40px;
            padding: 25px 0;
            border-top: 1px solid #e0e0e0;
            color: #777;
            font-size: 14px;
        }

        .footer-content {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .footer-logo {
            margin-bottom: 15px;
            font-weight: bold;
            color: var(--primary-color);
            font-size: 18px;
        }

        @media (max-width: 768px) {
            h1 {
                font-size: 28px;
            }

            .container {
                padding: 20px 15px;
            }

            .content-card {
                padding: 30px; 
            }

            .org-structure-img {
                max-width: 100%; 
            }

            .description {
                font-size: 16px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>Struktur Organisasi</h1>
        </header>

        <p class="description">
            Struktur organisasi kami dirancang untuk memastikan tata kelola yang efektif dan efisien dalam mencapai visi dan misi institusi.
        </p>

        <div class="content-card">
            <div class="img-container">
                <img src="{{ asset('images/Struktur Organisasi WR3.png') }}" alt="Struktur Organisasi Institusi" class="org-structure-img">
            </div>
            <p class="img-caption">Struktur Organisasi Tahun 2025</p>
        </div>
    </div>
</body>
</html>
@include('pemeringkatan.footerpemeringkatan')
