<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProposalHub | Direktorat Inovasi UNJ</title>
    <link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" type="image/png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet" />
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
            text-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }

        .ph-hero p {
            font-size: 1.2rem;
            line-height: 1.8;
            opacity: 0.9;
            margin-bottom: 2rem;
        }

        .ph-badge {
            display: inline-block;
            background: rgba(255,255,255,0.15);
            border: 1px solid rgba(255,255,255,0.3);
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
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
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
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
            border-color: var(--ph-primary);
        }

        .ph-service-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
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
            box-shadow: 0 4px 12px rgba(0,0,0,0.06);
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
        }

        .ph-opp-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 25px rgba(0,0,0,0.12);
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

        .ph-opp-badge.open    { background: #d1fae5; color: #065f46; }
        .ph-opp-badge.partner { background: #fef3c7; color: #92400e; }
        .ph-opp-badge.inter   { background: #dbeafe; color: #1e40af; }

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

        .ph-map-info { flex: 1; min-width: 200px; }
        .ph-map-info h3 { font-size: 1.1rem; font-weight: 700; color: var(--ph-secondary); margin-bottom: 0.4rem; }
        .ph-map-info p { font-size: 0.9rem; color: #666; }

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
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
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
            right: -5rem; top: -5rem;
            width: 20rem; height: 20rem;
            background: rgba(255,255,255,0.05);
            border-radius: 50%;
        }

        .ph-cta::after {
            content: '';
            position: absolute;
            left: -4rem; bottom: -4rem;
            width: 15rem; height: 15rem;
            background: rgba(255,255,255,0.04);
            border-radius: 50%;
        }

        .ph-cta h2 { font-size: 2.5rem; font-weight: 700; margin-bottom: 1rem; }
        .ph-cta p  { font-size: 1.1rem; line-height: 1.8; opacity: 0.9; max-width: 700px; margin: 0 auto 2rem; }

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
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        .ph-btn-primary:hover { background: #e5a800; transform: translateY(-2px); }

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
            border: 2px solid rgba(255,255,255,0.6);
            transition: all 0.3s;
        }

        .ph-btn-outline:hover { background: rgba(255,255,255,0.1); border-color: white; }

        .ph-steps {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
            max-width: 500px;
            margin: 0 auto;
        }

        .ph-step {
            text-align: center;
            color: rgba(255,255,255,0.85);
        }

        .ph-step-num {
            width: 40px; height: 40px;
            background: rgba(255,255,255,0.15);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 0.5rem;
            font-weight: 700;
            font-size: 1.1rem;
        }

        .ph-step span { font-size: 0.85rem; font-weight: 500; }

        @media (max-width: 768px) {
            .ph-hero h1 { font-size: 2.4rem; }
            .ph-section { padding: 1.8rem; }
            .ph-cta h2 { font-size: 1.8rem; }
            .ph-steps { grid-template-columns: 1fr; }
            .ph-map-wrap { flex-direction: column; }
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
                <div class="ph-badge"><i class="fas fa-lightbulb mr-1"></i> Sistem Manajemen Proposal Terintegrasi</div>
                <h1>ProposalHub</h1>
                <p>Platform terpusat untuk pengelolaan proposal penelitian dan pengabdian masyarakat Universitas Negeri Jakarta. Mempermudah proses pengajuan, pemantauan, dan pelaporan riset secara efisien.</p>
            </div>
        </div>

        {{-- Statistics --}}
        <section class="ph-section">
            <h2 class="ph-section-title">Statistik Proposal</h2>
            <p class="ph-intro">Gambaran real-time ekosistem penelitian dan inovasi UNJ.</p>
            <div class="ph-stats">
                <div class="ph-stat-card">
                    <div class="ph-stat-icon"><i class="fas fa-file-alt"></i></div>
                    <div class="ph-stat-number">1.248</div>
                    <div class="ph-stat-label">Proposal Aktif</div>
                </div>
                <div class="ph-stat-card">
                    <div class="ph-stat-icon"><i class="fas fa-graduation-cap"></i></div>
                    <div class="ph-stat-number">856</div>
                    <div class="ph-stat-label">Hibah Penelitian</div>
                </div>
                <div class="ph-stat-card">
                    <div class="ph-stat-icon"><i class="fas fa-university"></i></div>
                    <div class="ph-stat-number">131</div>
                    <div class="ph-stat-label">Institusi Mitra</div>
                </div>
                <div class="ph-stat-card">
                    <div class="ph-stat-icon"><i class="fas fa-users"></i></div>
                    <div class="ph-stat-number">3.681</div>
                    <div class="ph-stat-label">Peneliti Aktif</div>
                </div>
            </div>
        </section>

        {{-- Administrative Services --}}
        <section class="ph-section">
            <h2 class="ph-section-title">Layanan Administratif</h2>
            <p class="ph-intro">Alat-alat terpusat untuk mengelola siklus penelitian Anda secara efisien.</p>
            <div class="ph-service-grid">
                <div class="ph-service-card">
                    <div class="ph-service-icon-wrap"><i class="fas fa-file-upload"></i></div>
                    <h3>Pengajuan Proposal</h3>
                    <p>Portal terintegrasi untuk mengajukan proposal penelitian dan pengabdian masyarakat baru.</p>
                    <a href="#" class="ph-service-link">Akses Portal <i class="fas fa-arrow-right"></i></a>
                </div>
                <div class="ph-service-card">
                    <div class="ph-service-icon-wrap"><i class="fas fa-wallet"></i></div>
                    <h3>Pemantauan Anggaran</h3>
                    <p>Pelacakan real-time penggunaan hibah, pengeluaran, dan kepatuhan keuangan.</p>
                    <a href="#" class="ph-service-link">Lihat Dashboard <i class="fas fa-arrow-right"></i></a>
                </div>
                <div class="ph-service-card">
                    <div class="ph-service-icon-wrap"><i class="fas fa-clipboard-check"></i></div>
                    <h3>Laporan Pertanggungjawaban</h3>
                    <p>Alat untuk membuat dan menyerahkan laporan kemajuan dan LPJ penelitian.</p>
                    <a href="#" class="ph-service-link">Kirim Laporan <i class="fas fa-arrow-right"></i></a>
                </div>
                <div class="ph-service-card">
                    <div class="ph-service-icon-wrap"><i class="fas fa-gavel"></i></div>
                    <h3>Klirens Etik</h3>
                    <p>Proses pengajuan persetujuan etik untuk penelitian yang melibatkan subjek manusia atau hewan.</p>
                    <a href="#" class="ph-service-link">Ajukan Sekarang <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
        </section>

        {{-- Research Opportunities --}}
        <section class="ph-section">
            <h2 class="ph-section-title">Peluang Penelitian</h2>
            <p class="ph-intro">Temukan proyek yang sedang berjalan dan cari mitra kolaborasi.</p>
            <div class="ph-opportunity-grid">
                <div class="ph-opp-card">
                    <div class="ph-opp-header">
                        <div>
                            <span class="ph-opp-badge open">Terbuka untuk Kolaborasi</span>
                            <h3>AI dalam Teknologi Pendidikan</h3>
                        </div>
                        <div class="ph-opp-icon-wrap"><i class="fas fa-brain"></i></div>
                    </div>
                    <div class="ph-opp-body">
                        <div class="ph-opp-meta">
                            <i class="fas fa-school"></i>
                            <div>
                                <div class="ph-opp-meta-label">Fakultas Pemimpin</div>
                                <div class="ph-opp-meta-value">Fakultas Teknik</div>
                            </div>
                        </div>
                        <div class="ph-opp-meta">
                            <i class="fas fa-handshake"></i>
                            <div>
                                <div class="ph-opp-meta-label">Institusi Mitra</div>
                                <div class="ph-opp-meta-value">Menunggu</div>
                            </div>
                        </div>
                        <div class="ph-opp-meta">
                            <i class="fas fa-user-plus"></i>
                            <div>
                                <div class="ph-opp-meta-label">Slot Tersedia</div>
                                <div class="ph-opp-meta-value">2 Peneliti (Data Science)</div>
                            </div>
                        </div>
                    </div>
                    <div class="ph-opp-footer">
                        <span>Diposting 2 hari lalu</span>
                        <button>Lihat Detail <i class="fas fa-chevron-right"></i></button>
                    </div>
                </div>

                <div class="ph-opp-card">
                    <div class="ph-opp-header">
                        <div>
                            <span class="ph-opp-badge partner">Mencari Mitra</span>
                            <h3>Perencanaan Kota Berkelanjutan</h3>
                        </div>
                        <div class="ph-opp-icon-wrap"><i class="fas fa-city"></i></div>
                    </div>
                    <div class="ph-opp-body">
                        <div class="ph-opp-meta">
                            <i class="fas fa-school"></i>
                            <div>
                                <div class="ph-opp-meta-label">Fakultas Pemimpin</div>
                                <div class="ph-opp-meta-value">Ilmu Sosial</div>
                            </div>
                        </div>
                        <div class="ph-opp-meta">
                            <i class="fas fa-handshake"></i>
                            <div>
                                <div class="ph-opp-meta-label">Institusi Mitra</div>
                                <div class="ph-opp-meta-value">Pemprov DKI Jakarta</div>
                            </div>
                        </div>
                        <div class="ph-opp-meta">
                            <i class="fas fa-user-plus"></i>
                            <div>
                                <div class="ph-opp-meta-label">Slot Tersedia</div>
                                <div class="ph-opp-meta-value">1 Urban Ekologis</div>
                            </div>
                        </div>
                    </div>
                    <div class="ph-opp-footer">
                        <span>Diposting 5 hari lalu</span>
                        <button>Lihat Detail <i class="fas fa-chevron-right"></i></button>
                    </div>
                </div>

                <div class="ph-opp-card">
                    <div class="ph-opp-header">
                        <div>
                            <span class="ph-opp-badge inter">Lintas Departemen</span>
                            <h3>Biomekanika Ilmu Olahraga</h3>
                        </div>
                        <div class="ph-opp-icon-wrap"><i class="fas fa-running"></i></div>
                    </div>
                    <div class="ph-opp-body">
                        <div class="ph-opp-meta">
                            <i class="fas fa-school"></i>
                            <div>
                                <div class="ph-opp-meta-label">Fakultas Pemimpin</div>
                                <div class="ph-opp-meta-value">Ilmu Olahraga</div>
                            </div>
                        </div>
                        <div class="ph-opp-meta">
                            <i class="fas fa-handshake"></i>
                            <div>
                                <div class="ph-opp-meta-label">Institusi Mitra</div>
                                <div class="ph-opp-meta-value">KONI Pusat</div>
                            </div>
                        </div>
                        <div class="ph-opp-meta">
                            <i class="fas fa-user-plus"></i>
                            <div>
                                <div class="ph-opp-meta-label">Slot Tersedia</div>
                                <div class="ph-opp-meta-value">3 Asisten Pascasarjana</div>
                            </div>
                        </div>
                    </div>
                    <div class="ph-opp-footer">
                        <span>Diposting 1 minggu lalu</span>
                        <button>Lihat Detail <i class="fas fa-chevron-right"></i></button>
                    </div>
                </div>
            </div>

            {{-- Collaborative Map --}}
            <div class="ph-map-wrap">
                <div class="ph-map-info">
                    <h3>Peta Kolaborasi Penelitian</h3>
                    <p>Eksplorasi jaringan global mitra penelitian dan studi lapangan yang sedang berjalan.</p>
                </div>
                <div class="ph-map-canvas">
                    <div class="ph-map-canvas-bg"></div>
                    <div class="ph-map-dot" style="top:30%;left:27%;background:#ef4444;box-shadow:0 0 0 4px rgba(239,68,68,0.2);"></div>
                    <div class="ph-map-dot" style="top:50%;left:53%;background:#277177;box-shadow:0 0 0 4px rgba(39,113,119,0.2);"></div>
                    <div class="ph-map-dot" style="bottom:30%;right:25%;background:#f39c12;box-shadow:0 0 0 4px rgba(243,156,18,0.2);"></div>
                    <div class="ph-map-label">
                        <i class="fas fa-globe" style="color:#277177;"></i> Peta Interaktif Sedang Dimuat...
                    </div>
                </div>
            </div>
        </section>

        {{-- CTA --}}
        <div class="ph-cta">
            <div style="position:relative;z-index:1;">
                <h2>Ajukan Inovasi Anda</h2>
                <p>Siap mewujudkan ide Anda menjadi kenyataan? Mulai perjalanan proposal Anda hari ini bersama ProposalHub. Proses kami yang efisien memudahkan Anda mendapatkan pendanaan dan mengelola proyek penelitian.</p>
                <div class="ph-cta-buttons">
                    <a href="#" class="ph-btn-primary"><i class="fas fa-plus-circle"></i> Buat Proposal Baru</a>
                    <a href="#" class="ph-btn-outline"><i class="fas fa-question-circle"></i> Lihat Panduan</a>
                </div>
                <div class="ph-steps">
                    <div class="ph-step">
                        <div class="ph-step-num">1</div>
                        <span>Buat Akun</span>
                    </div>
                    <div class="ph-step">
                        <div class="ph-step-num">2</div>
                        <span>Tulis Proposal</span>
                    </div>
                    <div class="ph-step">
                        <div class="ph-step-num">3</div>
                        <span>Kirim untuk Review</span>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

</body>
@include('layout.footer')
</html>