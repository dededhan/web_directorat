<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran UNJ Innovation Challenge</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', Arial, sans-serif;
            background-color: #f4f7f6;
            color: #333;
        }

        .wrapper {
            max-width: 620px;
            margin: 30px auto;
            background: #fff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.08);
        }

        .header {
            background: linear-gradient(135deg, #1d5559 0%, #277177 60%, #2d8a8a 100%);
            padding: 40px 40px 32px;
            text-align: center;
        }

        .header .logo-wrap {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 70px;
            height: 70px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 50%;
            border: 2px solid rgba(255, 255, 255, 0.25);
            margin-bottom: 18px;
        }

        .header .logo-wrap img {
            width: 44px;
            height: 44px;
            object-fit: contain;
        }

        .header h1 {
            color: #fff;
            font-size: 22px;
            font-weight: 800;
            letter-spacing: -0.5px;
            line-height: 1.3;
        }

        .header p.sub {
            color: rgba(255, 255, 255, 0.75);
            font-size: 12px;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            margin-top: 4px;
            font-weight: 600;
        }

        .badge {
            display: inline-block;
            margin-top: 18px;
            background: rgba(255, 255, 255, 0.18);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: #fff;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            padding: 5px 16px;
            border-radius: 20px;
        }

        .body {
            padding: 40px 40px 32px;
        }

        .greeting {
            font-size: 16px;
            font-weight: 700;
            color: #1d5559;
            margin-bottom: 12px;
        }

        .body p {
            font-size: 14px;
            color: #555;
            line-height: 1.7;
            margin-bottom: 14px;
        }

        .highlight-box {
            background: linear-gradient(135deg, #f0fafa 0%, #e6f5f5 100%);
            border-left: 4px solid #277177;
            border-radius: 8px;
            padding: 18px 20px;
            margin: 20px 0;
        }

        .highlight-box .label {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #277177;
            margin-bottom: 6px;
        }

        .highlight-box .value {
            font-size: 15px;
            font-weight: 700;
            color: #1d5559;
        }

        .steps {
            margin: 24px 0;
        }

        .steps .step {
            display: flex;
            align-items: flex-start;
            gap: 14px;
            margin-bottom: 16px;
        }

        .steps .step-num {
            flex-shrink: 0;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: #277177;
            color: #fff;
            font-size: 12px;
            font-weight: 800;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 1px;
        }

        .steps .step-text strong {
            display: block;
            font-size: 13px;
            color: #1d5559;
            font-weight: 700;
        }

        .steps .step-text span {
            font-size: 12px;
            color: #777;
            line-height: 1.5;
        }

        .info-card {
            background: #fffbf0;
            border: 1px solid #fde68a;
            border-radius: 10px;
            padding: 14px 18px;
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin: 20px 0;
        }

        .info-card .icon {
            font-size: 20px;
            flex-shrink: 0;
            margin-top: 1px;
        }

        .info-card p {
            font-size: 12px;
            color: #92400e;
            line-height: 1.6;
            margin: 0;
        }

        .info-card strong {
            font-weight: 700;
            display: block;
            margin-bottom: 2px;
            font-size: 13px;
        }

        .divider {
            height: 1px;
            background: linear-gradient(to right, transparent, #e2e8f0, transparent);
            margin: 28px 0;
        }

        .footer {
            background: #f8fafc;
            padding: 24px 40px;
            text-align: center;
            border-top: 1px solid #e2e8f0;
        }

        .footer p {
            font-size: 11px;
            color: #94a3b8;
            line-height: 1.6;
        }

        .footer a {
            color: #277177;
            text-decoration: none;
            font-weight: 600;
        }

        .role-badge {
            display: inline-block;
            background: #e0f2f1;
            color: #1d5559;
            font-size: 12px;
            font-weight: 700;
            padding: 3px 12px;
            border-radius: 20px;
            text-transform: capitalize;
        }

        .cta-section {
            background: linear-gradient(135deg, #f0fafa 0%, #e6f5f5 100%);
            border: 1px solid #b2dfdb;
            border-radius: 12px;
            padding: 24px 24px 20px;
            margin: 24px 0;
            text-align: center;
        }

        .cta-section h3 {
            font-size: 14px;
            font-weight: 800;
            color: #1d5559;
            margin-bottom: 6px;
        }

        .cta-section p {
            font-size: 12px;
            color: #607d8b;
            margin-bottom: 18px;
            line-height: 1.6;
        }

        .btn-primary {
            display: inline-block;
            background: linear-gradient(135deg, #1d5559, #2d8a8a);
            color: #fff !important;
            font-size: 13px;
            font-weight: 700;
            padding: 11px 28px;
            border-radius: 8px;
            text-decoration: none;
            letter-spacing: 0.3px;
            margin: 4px 6px;
        }

        .btn-outline {
            display: inline-block;
            background: #fff;
            color: #277177 !important;
            font-size: 13px;
            font-weight: 700;
            padding: 10px 24px;
            border-radius: 8px;
            text-decoration: none;
            letter-spacing: 0.3px;
            border: 2px solid #277177;
            margin: 4px 6px;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <!-- Header -->
        <div class="header">
            <div class="logo-wrap">
                <img src="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" alt="UNJ Logo">
            </div>
            <h1>UNJ Innovation Challenge</h1>
            <p class="sub">Universitas Negeri Jakarta</p>
            <span class="badge">✓ Pendaftaran Diterima</span>
        </div>

        <!-- Body -->
        <div class="body">
            <p class="greeting">Halo, {{ $registrantName }}! 👋</p>
            <p>
                Selamat! Kami dengan bangga mengonfirmasi bahwa pendaftaran Anda untuk
                <strong>UNJ Innovation Challenge</strong> telah berhasil kami terima.
            </p>

            <!-- Registration info -->
            <div class="highlight-box">
                <div class="label">Peran Terdaftar</div>
                <div class="value"><span class="role-badge">{{ ucfirst($registrantRole) }}</span></div>
            </div>

            <!-- Next steps -->
            <p style="font-size:13px; font-weight:700; color:#1d5559; margin-bottom:12px;">Langkah Selanjutnya:</p>
            <div class="steps">
                <div class="step">
                    <div class="step-num">1</div>
                    <div class="step-text">
                        <strong>kunjungi halaman direktorat inovasi dan hilirisasi</strong>
                        <span>Anda dapat mengakses website direktorat inovasi dan hilirisasi dengan mengunjungi link
                            berikut: <a href="https://ditisip.unj.ac.id/subdirektorat-inovasi/innovation-challange"
                                style="color:#277177; font-weight:600;">dihsip/innovation-challange</a></span>
                    </div>
                </div>
                <div class="step">
                    <div class="step-num">2</div>
                    <div class="step-text">
                        <strong>lakukan login</strong>
                        <span>Anda dapat login menggunakan email dan password yang telah Anda daftarkan.</span>
                    </div>
                </div>
                <div class="step">
                    <div class="step-num">3</div>
                    <div class="step-text">
                        <strong>Isi formulir biodata diri dan Mulai inovation-challange</strong>
                        <span>Setelah login, Anda akan diarahkan untuk mengisi formulir biodata diri dan memulai
                            partisipasi dalam UNJ Innovation Challenge.</span>
                    </div>
                </div>
            </div>

            <!-- Warning note -->
            <div class="info-card">
                <span class="icon">💡</span>
                <p>
                    <strong>Harap Diperhatikan</strong>
                    Pastikan untuk segera melengkapi profil Anda dan mengikuti langkah-langkah selanjutnya agar dapat
                    berpartisipasi dalam UNJ Innovation Challenge dengan lancar.
                </p>
            </div>



            <div class="divider"></div>

            <p style="font-size:12px; color:#94a3b8; text-align:center;">
                Butuh bantuan? Hubungi kami di
                <a href="mailto:dir.inovasi@unj.ac.id" style="color:#277177; font-weight:600;">dir.inovasi@unj.ac.id</a>
            </p>

        </div>

        <!-- Footer -->
        <div class="footer">
            <p>
                Email ini dikirim secara otomatis oleh sistem<br>
                <strong>UNJ Innovation Challenge</strong> — Direktorat IHSIP, Universitas Negeri Jakarta<br>
                <a href="{{ config('app.url') }}">{{ config('app.url') }}</a>
            </p>
            <p style="margin-top:10px;">&copy; {{ date('Y') }} UNJ Innovation Challenge. All rights reserved.</p>
        </div>
    </div>
</body>

</html>
