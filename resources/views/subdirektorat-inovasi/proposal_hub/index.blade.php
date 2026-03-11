<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Innovation Challenge | Direktorat Inovasi UNJ</title>
    <link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" type="image/png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200"
        rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
    <link rel="stylesheet" href="{{ asset('home.css') }}">
    <style>
        /* Scoped variables */
        .ph-page {
            --ph-primary: #277177;
            --ph-secondary: #1d5559;
            --ph-accent: #f39c12;
            --ph-light: #ecf7f8;
            --ph-dark: #34495e;
        }

        /* Page wrapper */
        .ph-page {
            background-color: #f5f7fa;
            color: #333;
            line-height: 1.6;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .ph-container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        /* Hero */
        .ph-hero {
            background: linear-gradient(135deg, rgba(39, 113, 119, 0.95), rgba(29, 85, 89, 0.95));
            border-radius: 12px;
            padding: 5rem 2rem;
            text-align: center;
            color: white;
            margin-bottom: 3rem;
            position: relative;
            overflow: hidden;
        }

        .ph-hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background: url('https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png') center/300px no-repeat;
            opacity: 0.04;
        }

        .ph-hero-content {
            position: relative;
            z-index: 1;
            max-width: 700px;
            margin: 0 auto;
        }

        .ph-hero h1 {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .ph-hero p {
            font-size: 1.2rem;
            line-height: 1.8;
            opacity: 0.9;
            margin-bottom: 2rem;
        }

        .ph-badge {
            display: inline-block;
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
            padding: 0.4rem 1.2rem;
            border-radius: 999px;
            font-size: 0.85rem;
            font-weight: 600;
            letter-spacing: 0.05em;
            margin-bottom: 1.5rem;
            text-transform: uppercase;
        }

        /* Section */
        .ph-section {
            background-color: white;
            padding: 3rem;
            margin-bottom: 2.5rem;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .ph-section-title {
            color: var(--ph-secondary);
            margin-bottom: 1.5rem;
            padding-bottom: 0.8rem;
            border-bottom: 3px solid var(--ph-primary);
            font-size: 2rem;
            font-weight: 700;
        }

        .ph-intro {
            font-size: 1.05rem;
            line-height: 1.8;
            color: #555;
            margin-bottom: 2rem;
        }

        /* Stats */
        .ph-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin: 2rem 0;
        }

        .ph-stat-card {
            background: var(--ph-light);
            border-radius: 10px;
            padding: 1.8rem;
            text-align: center;
            border-top: 4px solid var(--ph-primary);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .ph-stat-card:nth-child(even) {
            border-top-color: var(--ph-accent);
        }

        .ph-stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .ph-stat-icon {
            font-size: 2rem;
            color: var(--ph-primary);
            margin-bottom: 0.8rem;
        }

        .ph-stat-card:nth-child(even) .ph-stat-icon {
            color: var(--ph-accent);
        }

        .ph-stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--ph-secondary);
            line-height: 1;
            margin-bottom: 0.4rem;
        }

        .ph-stat-label {
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #777;
        }

        /* Service Cards */
        .ph-service-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1.5rem;
            margin-top: 2rem;
        }

        .ph-service-card {
            border: 1px solid #e8e8e8;
            border-radius: 10px;
            padding: 2rem;
            text-align: center;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .ph-service-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            border-color: var(--ph-primary);
        }

        .ph-service-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--ph-primary);
        }

        .ph-service-card:nth-child(even)::before {
            background: var(--ph-accent);
        }

        .ph-service-icon-wrap {
            width: 64px;
            height: 64px;
            background: var(--ph-light);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.2rem auto;
            transition: background 0.3s;
        }

        .ph-service-card:hover .ph-service-icon-wrap {
            background: var(--ph-primary);
        }

        .ph-service-icon-wrap i {
            font-size: 1.6rem;
            color: var(--ph-primary);
            transition: color 0.3s;
        }

        .ph-service-card:hover .ph-service-icon-wrap i {
            color: white;
        }

        .ph-service-card h3 {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--ph-secondary);
            margin-bottom: 0.8rem;
        }

        .ph-service-card p {
            font-size: 0.9rem;
            color: #666;
            line-height: 1.6;
            margin-bottom: 1.2rem;
        }

        .ph-service-link {
            color: var(--ph-primary);
            font-weight: 600;
            font-size: 0.9rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            transition: gap 0.2s;
        }

        .ph-service-link:hover {
            gap: 0.6rem;
        }

        /* Opportunity Cards */
        .ph-opportunity-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-top: 2rem;
        }

        .ph-opp-card {
            border: 1px solid #e8e8e8;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
        }

        .ph-opp-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.12);
        }

        .ph-opp-header {
            padding: 1.2rem 1.5rem;
            border-bottom: 1px solid #f0f0f0;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .ph-opp-badge {
            display: inline-block;
            padding: 0.3rem 0.8rem;
            border-radius: 999px;
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            margin-bottom: 0.6rem;
        }

        .ph-opp-badge.open {
            background: #d1fae5;
            color: #065f46;
        }

        .ph-opp-badge.partner {
            background: #fef3c7;
            color: #92400e;
        }

        .ph-opp-badge.inter {
            background: #dbeafe;
            color: #1e40af;
        }

        .ph-opp-header h3 {
            font-size: 1rem;
            font-weight: 700;
            color: #1f2937;
            line-height: 1.4;
        }

        .ph-opp-icon-wrap {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #f3f4f6;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6b7280;
            flex-shrink: 0;
        }

        .ph-opp-body {
            padding: 1.5rem;
            flex-grow: 1;
        }

        .ph-opp-meta {
            display: flex;
            align-items: flex-start;
            gap: 0.8rem;
            margin-bottom: 1rem;
        }

        .ph-opp-meta i {
            color: #9ca3af;
            font-size: 1rem;
            margin-top: 0.15rem;
        }

        .ph-opp-meta-label {
            font-size: 0.72rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #9ca3af;
        }

        .ph-opp-meta-value {
            font-size: 0.9rem;
            font-weight: 500;
            color: #374151;
        }

        .ph-opp-footer {
            padding: 0.8rem 1.5rem;
            background: #f9fafb;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .ph-opp-footer span {
            font-size: 0.78rem;
            color: #9ca3af;
        }

        .ph-opp-footer button {
            color: var(--ph-primary);
            font-size: 0.85rem;
            font-weight: 700;
            background: none;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.2rem;
            transition: color 0.2s;
        }

        .ph-opp-footer button:hover {
            color: var(--ph-secondary);
        }

        /* Map placeholder */
        .ph-map-wrap {
            margin-top: 2.5rem;
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 1.5rem;
            display: flex;
            gap: 2rem;
            align-items: center;
            flex-wrap: wrap;
        }

        .ph-map-info {
            flex: 1;
            min-width: 200px;
        }

        .ph-map-info h3 {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--ph-secondary);
            margin-bottom: 0.4rem;
        }

        .ph-map-info p {
            font-size: 0.9rem;
            color: #666;
        }

        .ph-map-canvas {
            flex: 2;
            min-width: 280px;
            height: 220px;
            background: #f3f4f6;
            border-radius: 8px;
            border: 2px dashed #d1d5db;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .ph-map-canvas-bg {
            position: absolute;
            inset: 0;
            background: url('https://upload.wikimedia.org/wikipedia/commons/e/ec/World_map_blank_without_borders.svg') center/cover no-repeat;
            opacity: 0.15;
        }

        .ph-map-dot {
            position: absolute;
            width: 10px;
            height: 10px;
            border-radius: 50%;
        }

        .ph-map-label {
            position: relative;
            z-index: 1;
            background: white;
            padding: 0.5rem 1rem;
            border-radius: 999px;
            font-size: 0.85rem;
            font-weight: 500;
            color: #374151;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }

        /* CTA */
        .ph-cta {
            background: linear-gradient(135deg, #1d5559, #277177);
            color: white;
            text-align: center;
            padding: 4rem 2rem;
            border-radius: 15px;
            margin-bottom: 2rem;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(39, 113, 119, 0.3);
        }

        .ph-cta::before {
            content: '';
            position: absolute;
            right: -5rem;
            top: -5rem;
            width: 20rem;
            height: 20rem;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
        }

        .ph-cta::after {
            content: '';
            position: absolute;
            left: -4rem;
            bottom: -4rem;
            width: 15rem;
            height: 15rem;
            background: rgba(255, 255, 255, 0.04);
            border-radius: 50%;
        }

        .ph-cta h2 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .ph-cta p {
            font-size: 1.1rem;
            line-height: 1.8;
            opacity: 0.9;
            max-width: 700px;
            margin: 0 auto 2rem;
        }

        .ph-cta-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
            margin-bottom: 2.5rem;
        }

        .ph-btn-primary {
            background: var(--ph-accent);
            color: #1d5559;
            padding: 0.9rem 2rem;
            border-radius: 8px;
            font-weight: 700;
            font-size: 1rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .ph-btn-primary:hover {
            background: #e5a800;
            transform: translateY(-2px);
        }

        .ph-btn-outline {
            background: transparent;
            color: white;
            padding: 0.9rem 2rem;
            border-radius: 8px;
            font-weight: 700;
            font-size: 1rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            border: 2px solid rgba(255, 255, 255, 0.6);
            transition: all 0.3s;
        }

        .ph-btn-outline:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: white;
        }

        .ph-steps {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
            max-width: 500px;
            margin: 0 auto;
        }

        .ph-step {
            text-align: center;
            color: rgba(255, 255, 255, 0.85);
        }

        .ph-step-num {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 0.5rem;
            font-weight: 700;
            font-size: 1.1rem;
        }

        .ph-step span {
            font-size: 0.85rem;
            font-weight: 500;
        }

        @media (max-width: 768px) {
            .ph-hero h1 {
                font-size: 2.4rem;
            }

            .ph-section {
                padding: 1.8rem;
            }

            .ph-cta h2 {
                font-size: 1.8rem;
            }

            .ph-steps {
                grid-template-columns: 1fr;
            }

            .ph-map-wrap {
                flex-direction: column;
            }
        }
    </style>
</head>
@include('layout.navbar_hilirisasi')

<body>

    <div class="ph-page">
        <div class="ph-container">

            {{-- Hero --}}
            <div class="ph-hero">
                <div class="ph-hero-content">
                    <div class="ph-badge"><i class="fas fa-trophy mr-1"></i> Program Seleksi Proposal Inovasi</div>
                    <h1>UNJ Innovative Challenge</h1>
                    <p>Program seleksi proposal inovasi yang diselenggarakan oleh Direktorat Inovasi dan Hilirisasi UNJ
                        untuk mendukung pengembangan ide inovatif dari civitas akademika menjadi produk nyata berdampak.
                    </p>
                    <div style="margin-top: 1.5rem; display: flex; gap: 0.75rem; flex-wrap: wrap;">
                        <a href="{{ route('inovchalenge.register.form') }}"
                            style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.75rem 1.5rem; background: #f59e0b; color: #fff; font-weight: 700; font-size: 0.95rem; border-radius: 0.75rem; text-decoration: none; box-shadow: 0 4px 14px rgba(245,158,11,0.4); transition: all 0.2s;">
                            <i class="fas fa-user-plus"></i> Daftar
                        </a>
                        <a href="#" class="login"
                            style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.75rem 1.5rem; background: rgba(255,255,255,0.15); color: #fff; font-weight: 700; font-size: 0.95rem; border-radius: 0.75rem; border: 2px solid rgba(255,255,255,0.4); text-decoration: none; backdrop-filter: blur(4px); transition: all 0.2s;">
                            <i class="fas fa-sign-in-alt"></i> Login
                        </a>
                    </div>
                </div>
            </div>

            {{-- Tentang Program --}}
            <section class="ph-section">
                <h2 class="ph-section-title">Tentang Program</h2>
                <p class="ph-intro">UNJ Innovative Challenge adalah program unggulan dari Direktorat Inovasi dan
                    Hilirisasi Universitas Negeri Jakarta yang bertujuan menyeleksi, mendanai, dan mendampingi
                    proposal-proposal inovasi terbaik dari dosen, peneliti, dan alumni UNJ. Program ini dirancang untuk
                    menjembatani ide inovatif menuju produk berdaya guna yang memberikan dampak nyata bagi masyarakat.
                </p>

                <div
                    style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem; margin-top: 1rem;">
                    <div
                        style="display: flex; align-items: flex-start; gap: 1rem; padding: 1.2rem; background: var(--ph-light); border-radius: 10px; border-left: 4px solid var(--ph-primary);">
                        <i class="fas fa-bullseye"
                            style="font-size: 1.4rem; color: var(--ph-primary); margin-top: 0.15rem;"></i>
                        <div>
                            <h4
                                style="font-weight: 700; color: var(--ph-secondary); margin-bottom: 0.3rem; font-size: 1rem;">
                                Tujuan</h4>
                            <p style="font-size: 0.9rem; color: #555; line-height: 1.7; margin: 0;">Mendorong
                                terciptanya inovasi berbasis riset yang dapat dihilirisasi menjadi produk atau layanan
                                berdampak bagi masyarakat.</p>
                        </div>
                    </div>
                    <div
                        style="display: flex; align-items: flex-start; gap: 1rem; padding: 1.2rem; background: var(--ph-light); border-radius: 10px; border-left: 4px solid var(--ph-accent);">
                        <i class="fas fa-hand-holding-heart"
                            style="font-size: 1.4rem; color: var(--ph-accent); margin-top: 0.15rem;"></i>
                        <div>
                            <h4
                                style="font-weight: 700; color: var(--ph-secondary); margin-bottom: 0.3rem; font-size: 1rem;">
                                Manfaat</h4>
                            <p style="font-size: 0.9rem; color: #555; line-height: 1.7; margin: 0;">Pendanaan,
                                pendampingan intensif, serta akses jejaring mitra industri dan dunia usaha untuk
                                pengembangan inovasi.</p>
                        </div>
                    </div>
                    <div
                        style="display: flex; align-items: flex-start; gap: 1rem; padding: 1.2rem; background: var(--ph-light); border-radius: 10px; border-left: 4px solid var(--ph-primary);">
                        <i class="fas fa-users-cog"
                            style="font-size: 1.4rem; color: var(--ph-primary); margin-top: 0.15rem;"></i>
                        <div>
                            <h4
                                style="font-weight: 700; color: var(--ph-secondary); margin-bottom: 0.3rem; font-size: 1rem;">
                                Sasaran</h4>
                            <p style="font-size: 0.9rem; color: #555; line-height: 1.7; margin: 0;">Dosen, peneliti,
                                alumni, mahasiswa, tenaga kependidikan (tendik), dan mitra DUDI di lingkungan Universitas Negeri Jakarta yang memiliki ide inovasi
                                potensial.</p>
                        </div>
                    </div>
                </div>
            </section>

            {{-- Tahapan Seleksi --}}
            <section class="ph-section">
                <h2 class="ph-section-title">Tahapan Seleksi</h2>
                <p class="ph-intro">Proses seleksi terdiri dari 3 tahap utama untuk memastikan kualitas dan kelayakan
                    setiap proposal inovasi.</p>
                <div class="ph-service-grid">
                    <div class="ph-service-card">
                        <div class="ph-service-icon-wrap"><i class="fas fa-clipboard-check"></i></div>
                        <h3>Tahap 1: Seleksi Administrasi</h3>
                        <p>Pemeriksaan kelengkapan dokumen proposal dan kesesuaian format yang diisyaratkan.</p>
                        <span class="ph-service-link"><i class="fas fa-file-word mr-1"></i> Format: DOCX</span>
                    </div>
                    <div class="ph-service-card">
                        <div class="ph-service-icon-wrap"><i class="fas fa-presentation"></i></div>
                        <h3>Tahap 2: Pitching</h3>
                        <p>Presentasi ide inovasi di depan tim reviewer untuk penilaian kelayakan dan potensi dampak.
                        </p>
                        <span class="ph-service-link"><i class="fas fa-file-powerpoint mr-1"></i> Format:
                            PPT/PPTX</span>
                    </div>
                    <div class="ph-service-card">
                        <div class="ph-service-icon-wrap"><i class="fas fa-chart-line"></i></div>
                        <h3>Tahap 3: Monitoring & Evaluasi</h3>
                        <p>Pemantauan progres implementasi inovasi dan evaluasi hasil capaian secara berkala.</p>
                        <span class="ph-service-link"><i class="fas fa-tasks mr-1"></i> Laporan Berkala</span>
                    </div>
                </div>
            </section>

            {{-- Siapa yang Bisa Mendaftar --}}
            <section class="ph-section">
                <h2 class="ph-section-title">Siapa yang Bisa Mendaftar?</h2>
                <p class="ph-intro">Program ini terbuka untuk dosen, mahasiswa, alumni, tenaga kependidikan (tendik), dan mitra dari Dunia Usaha Dunia
                    Industri (DUDI) yang ingin berinovasi bersama Universitas Negeri Jakarta.</p>
                <div class="ph-service-grid">
                    <div class="ph-service-card">
                        <div class="ph-service-icon-wrap"><i class="fas fa-chalkboard-teacher"></i></div>
                        <h3>Dosen</h3>
                        <p>Dosen aktif UNJ dari seluruh fakultas dan program studi yang memiliki ide inovatif dan ingin mengembangkan riset menjadi produk berdampak.</p>
                    </div>
                    <div class="ph-service-card">
                        <div class="ph-service-icon-wrap"><i class="fas fa-building"></i></div>
                        <h3>DUDI</h3>
                        <p>Mitra dari Dunia Usaha Dunia Industri yang ingin berkolaborasi dalam pengembangan inovasi bersama civitas akademika UNJ.
                        </p>
                    </div>
                    <div class="ph-service-card">
                        <div class="ph-service-icon-wrap"><i class="fas fa-user-graduate"></i></div>
                        <h3>Alumni</h3>
                        <p>Alumni UNJ yang memiliki ide inovasi dan ingin berkontribusi nyata bagi almamater dan masyarakat luas.</p>
                    </div>
                    <div class="ph-service-card">
                        <div class="ph-service-icon-wrap"><i class="fas fa-graduation-cap"></i></div>
                        <h3>Mahasiswa</h3>
                        <p>Mahasiswa aktif UNJ yang ingin mengembangkan ide kreatif dan inovatif menjadi solusi nyata bagi masyarakat.</p>
                    </div>
                    <div class="ph-service-card">
                        <div class="ph-service-icon-wrap"><i class="fas fa-user-tie"></i></div>
                        <h3>Tendik</h3>
                        <p>Tenaga Kependidikan UNJ yang memiliki gagasan inovatif dalam mendukung peningkatan layanan dan pengelolaan institusi.</p>
                    </div>
                </div>
            </section>

            {{-- FAQ --}}
            <section class="ph-section" x-data="{ activeIndex: null }">
                <h2 class="ph-section-title">Frequently Asked Questions (FAQ)</h2>
                <p class="ph-intro">Temukan jawaban atas pertanyaan yang sering diajukan tentang UNJ Innovative
                    Challenge.</p>

                <div style="display: flex; flex-direction: column; gap: 1rem;">
                    {{-- FAQ 1 --}}
                    <div style="border: 1px solid #e5e7eb; border-radius: 10px; overflow: hidden; transition: box-shadow 0.3s;"
                        :style="activeIndex === 0 ? 'box-shadow: 0 4px 15px rgba(39,113,119,0.15); border-color: #277177;' : ''">
                        <button @click="activeIndex = activeIndex === 0 ? null : 0"
                            style="width: 100%; display: flex; justify-content: space-between; align-items: center; padding: 1.2rem 1.5rem; background: none; border: none; cursor: pointer; text-align: left;">
                            <span style="font-weight: 600; font-size: 1.05rem; color: #1d5559;">
                                <i class="fas fa-question-circle" style="color: #277177; margin-right: 0.5rem;"></i>
                                Apa itu UNJ Innovative Challenge?
                            </span>
                            <i class="fas fa-chevron-down" style="color: #277177; transition: transform 0.3s;"
                                :style="activeIndex === 0 ? 'transform: rotate(180deg);' : ''"></i>
                        </button>
                        <div x-show="activeIndex === 0" x-collapse
                            style="padding: 0 1.5rem 1.2rem 1.5rem; color: #555; line-height: 1.8; font-size: 0.95rem;">
                            UNJ Innovative Challenge adalah program seleksi proposal inovasi yang diselenggarakan oleh
                            Direktorat Inovasi dan Hilirisasi UNJ. Program ini bertujuan untuk mendukung pengembangan
                            ide inovatif dari civitas akademika menjadi produk nyata yang berdampak bagi masyarakat.
                        </div>
                    </div>

                    {{-- FAQ 2 --}}
                    <div style="border: 1px solid #e5e7eb; border-radius: 10px; overflow: hidden; transition: box-shadow 0.3s;"
                        :style="activeIndex === 1 ? 'box-shadow: 0 4px 15px rgba(39,113,119,0.15); border-color: #277177;' : ''">
                        <button @click="activeIndex = activeIndex === 1 ? null : 1"
                            style="width: 100%; display: flex; justify-content: space-between; align-items: center; padding: 1.2rem 1.5rem; background: none; border: none; cursor: pointer; text-align: left;">
                            <span style="font-weight: 600; font-size: 1.05rem; color: #1d5559;">
                                <i class="fas fa-user-check" style="color: #277177; margin-right: 0.5rem;"></i>
                                Siapa yang bisa mendaftar?
                            </span>
                            <i class="fas fa-chevron-down" style="color: #277177; transition: transform 0.3s;"
                                :style="activeIndex === 1 ? 'transform: rotate(180deg);' : ''"></i>
                        </button>
                        <div x-show="activeIndex === 1" x-collapse
                            style="padding: 0 1.5rem 1.2rem 1.5rem; color: #555; line-height: 1.8; font-size: 0.95rem;">
                            Program ini terbuka untuk <strong>Dosen</strong>, <strong>Mahasiswa</strong>,
                            <strong>Alumni</strong> UNJ, serta mitra dari <strong>Dunia Usaha Dunia Industri
                                (DUDI)</strong> yang ingin berkolaborasi dalam pengembangan inovasi. Setiap tim harus
                            memiliki ketua yang merupakan dosen aktif UNJ.
                        </div>
                    </div>

                    {{-- FAQ 3 --}}
                    <div style="border: 1px solid #e5e7eb; border-radius: 10px; overflow: hidden; transition: box-shadow 0.3s;"
                        :style="activeIndex === 2 ? 'box-shadow: 0 4px 15px rgba(39,113,119,0.15); border-color: #277177;' : ''">
                        <button @click="activeIndex = activeIndex === 2 ? null : 2"
                            style="width: 100%; display: flex; justify-content: space-between; align-items: center; padding: 1.2rem 1.5rem; background: none; border: none; cursor: pointer; text-align: left;">
                            <span style="font-weight: 600; font-size: 1.05rem; color: #1d5559;">
                                <i class="fas fa-list-ol" style="color: #277177; margin-right: 0.5rem;"></i>
                                Apa saja tahapan seleksinya?
                            </span>
                            <i class="fas fa-chevron-down" style="color: #277177; transition: transform 0.3s;"
                                :style="activeIndex === 2 ? 'transform: rotate(180deg);' : ''"></i>
                        </button>
                        <div x-show="activeIndex === 2" x-collapse
                            style="padding: 0 1.5rem 1.2rem 1.5rem; color: #555; line-height: 1.8; font-size: 0.95rem;">
                            Proses seleksi terdiri dari 3 tahap utama:
                            <ol style="margin-top: 0.5rem; padding-left: 1.2rem;">
                                <li><strong>Seleksi Administrasi</strong> — Pemeriksaan kelengkapan dokumen dan
                                    kesesuaian format proposal.</li>
                                <li><strong>Pitching</strong> — Presentasi ide inovasi di depan tim reviewer untuk
                                    penilaian kelayakan.</li>
                                <li><strong>Monitoring & Evaluasi</strong> — Pemantauan progres implementasi dan
                                    evaluasi hasil capaian.</li>
                            </ol>
                        </div>
                    </div>

                    {{-- FAQ 4 --}}
                    <div style="border: 1px solid #e5e7eb; border-radius: 10px; overflow: hidden; transition: box-shadow 0.3s;"
                        :style="activeIndex === 3 ? 'box-shadow: 0 4px 15px rgba(39,113,119,0.15); border-color: #277177;' : ''">
                        <button @click="activeIndex = activeIndex === 3 ? null : 3"
                            style="width: 100%; display: flex; justify-content: space-between; align-items: center; padding: 1.2rem 1.5rem; background: none; border: none; cursor: pointer; text-align: left;">
                            <span style="font-weight: 600; font-size: 1.05rem; color: #1d5559;">
                                <i class="fas fa-file-alt" style="color: #277177; margin-right: 0.5rem;"></i>
                                Format file apa yang diterima?
                            </span>
                            <i class="fas fa-chevron-down" style="color: #277177; transition: transform 0.3s;"
                                :style="activeIndex === 3 ? 'transform: rotate(180deg);' : ''"></i>
                        </button>
                        <div x-show="activeIndex === 3" x-collapse
                            style="padding: 0 1.5rem 1.2rem 1.5rem; color: #555; line-height: 1.8; font-size: 0.95rem;">
                            Untuk tahap <strong>Seleksi Administrasi</strong>, dokumen proposal harus diunggah dalam
                            format <strong>DOCX</strong>. Sedangkan untuk tahap <strong>Pitching</strong>, materi
                            presentasi harus dalam format <strong>PPT atau PPTX</strong>. Pastikan file sesuai dengan
                            template yang telah disediakan.
                        </div>
                    </div>

                    {{-- FAQ 5 --}}
                    <div style="border: 1px solid #e5e7eb; border-radius: 10px; overflow: hidden; transition: box-shadow 0.3s;"
                        :style="activeIndex === 4 ? 'box-shadow: 0 4px 15px rgba(39,113,119,0.15); border-color: #277177;' : ''">
                        <button @click="activeIndex = activeIndex === 4 ? null : 4"
                            style="width: 100%; display: flex; justify-content: space-between; align-items: center; padding: 1.2rem 1.5rem; background: none; border: none; cursor: pointer; text-align: left;">
                            <span style="font-weight: 600; font-size: 1.05rem; color: #1d5559;">
                                <i class="fas fa-bell" style="color: #277177; margin-right: 0.5rem;"></i>
                                Bagaimana cara mengetahui hasil seleksi?
                            </span>
                            <i class="fas fa-chevron-down" style="color: #277177; transition: transform 0.3s;"
                                :style="activeIndex === 4 ? 'transform: rotate(180deg);' : ''"></i>
                        </button>
                        <div x-show="activeIndex === 4" x-collapse
                            style="padding: 0 1.5rem 1.2rem 1.5rem; color: #555; line-height: 1.8; font-size: 0.95rem;">
                            Hasil seleksi dapat dipantau secara <strong>real-time</strong> melalui dashboard dosen.
                            Setiap perubahan status proposal akan diperbarui secara otomatis dan peserta juga akan
                            mendapatkan notifikasi melalui sistem.
                        </div>
                    </div>

                    {{-- FAQ 6 --}}
                    <div style="border: 1px solid #e5e7eb; border-radius: 10px; overflow: hidden; transition: box-shadow 0.3s;"
                        :style="activeIndex === 5 ? 'box-shadow: 0 4px 15px rgba(39,113,119,0.15); border-color: #277177;' : ''">
                        <button @click="activeIndex = activeIndex === 5 ? null : 5"
                            style="width: 100%; display: flex; justify-content: space-between; align-items: center; padding: 1.2rem 1.5rem; background: none; border: none; cursor: pointer; text-align: left;">
                            <span style="font-weight: 600; font-size: 1.05rem; color: #1d5559;">
                                <i class="fas fa-calendar-alt" style="color: #277177; margin-right: 0.5rem;"></i>
                                Apakah ada batas waktu pendaftaran?
                            </span>
                            <i class="fas fa-chevron-down" style="color: #277177; transition: transform 0.3s;"
                                :style="activeIndex === 5 ? 'transform: rotate(180deg);' : ''"></i>
                        </button>
                        <div x-show="activeIndex === 5" x-collapse
                            style="padding: 0 1.5rem 1.2rem 1.5rem; color: #555; line-height: 1.8; font-size: 0.95rem;">
                            Ya, setiap sesi Innovation Challenge memiliki <strong>periode pendaftaran</strong> yang
                            telah ditentukan. Jadwal lengkap akan diumumkan melalui halaman utama Subdirektorat Inovasi
                            dan notifikasi kepada seluruh civitas akademika UNJ. Pastikan untuk memantau informasi
                            terbaru agar tidak melewatkan tenggat waktu.
                        </div>
                    </div>
                </div>
            </section>

            {{-- Panduan Innovation Challenge --}}
            <section class="ph-section" id="panduan">
                <h2 class="ph-section-title"><i class="fas fa-book-open" style="margin-right:0.5rem;color:var(--ph-primary);"></i>Panduan Innovation Challenge</h2>
                <p class="ph-intro">
                    Unduh dan pelajari panduan lengkap UNJ Innovative Challenge sebelum mengajukan proposal Anda.
                    Panduan mencakup persyaratan peserta, format proposal, rubrik penilaian, alur seleksi, serta
                    template dokumen yang wajib digunakan pada setiap tahapan.
                </p>

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
                    
                </div>

                <div style="text-align:center;padding:2rem;background:linear-gradient(135deg,rgba(39,113,119,0.06),rgba(243,156,18,0.06));border-radius:12px;border:1px dashed rgba(39,113,119,0.3);">
                    <i class="fab fa-google-drive" style="font-size:3rem;color:#1a73e8;margin-bottom:1rem;display:block;"></i>
                    <h3 style="font-size:1.3rem;font-weight:700;color:var(--ph-secondary);margin-bottom:0.5rem;">Akses Folder Panduan</h3>
                    <p style="font-size:0.95rem;color:#666;max-width:500px;margin:0 auto 1.5rem;">
                        Semua dokumen panduan, template, dan materi pendukung Innovation Challenge tersedia di Google Drive berikut.
                    </p>
                    <a href="https://drive.google.com/drive/folders/1uq3BRfL4gNd9S0KLv0GxBJVYcmwVlIQx?usp=drive_link"
                       target="_blank"
                       rel="noopener noreferrer"
                       style="display:inline-flex;align-items:center;gap:0.6rem;padding:0.85rem 2rem;background:#1a73e8;color:#fff;font-weight:700;font-size:1rem;border-radius:10px;text-decoration:none;box-shadow:0 4px 16px rgba(26,115,232,0.35);transition:all 0.3s;"
                       onmouseover="this.style.background='#1558b0';this.style.transform='translateY(-2px)';this.style.boxShadow='0 8px 24px rgba(26,115,232,0.45)'"
                       onmouseout="this.style.background='#1a73e8';this.style.transform='translateY(0)';this.style.boxShadow='0 4px 16px rgba(26,115,232,0.35)'">
                        <i class="fab fa-google-drive"></i>
                        Buka Panduan di Google Drive
                        <i class="fas fa-external-link-alt" style="font-size:0.8rem;"></i>
                    </a>
                </div>
            </section>

            {{-- CTA --}}
            <div class="ph-cta">
                <div style="position:relative;z-index:1;">
                    <h2>Siap Berinovasi?</h2>
                    <p>Wujudkan ide inovatif Anda menjadi produk nyata yang berdampak! Daftarkan proposal Anda di UNJ
                        Innovative Challenge dan dapatkan pendanaan serta pendampingan dari Direktorat Inovasi dan
                        Hilirisasi UNJ.</p>
                    <div class="ph-cta-buttons">
                        <button class="ph-btn-primary login" style="border:none;cursor:pointer;"><i
                                class="fas fa-sign-in-alt"></i> Masuk</button>
                        <a href="{{ route('inovchalenge.register.form') }}" class="ph-btn-outline"
                            style="cursor:pointer;"><i class="fas fa-user-plus"></i> Daftar</a>
                    </div>
                    <div class="ph-steps">
                        <div class="ph-step">
                            <div class="ph-step-num">1</div>
                            <span>Login</span>
                        </div>
                        <div class="ph-step">
                            <div class="ph-step-num">2</div>
                            <span>Ajukan Proposal</span>
                        </div>
                        <div class="ph-step">
                            <div class="ph-step-num">3</div>
                            <span>Ikuti Seleksi</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</body>
@include('layout.footer')

</html>
