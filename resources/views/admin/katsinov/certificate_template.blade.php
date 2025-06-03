<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Sertifikat {{ $katsinov->user->name }}</title>
    <style>
        @page {
            margin: 0;
            size: A4 landscape;
        }
        body {
            font-family: 'Times New Roman', Times, serif;
            margin: 0;
            padding: 0;
            background-image: url('data:image/jpeg;base64,{{ $certificateBackgroundBase64 }}');
            background-size: 100% 100%;
            background-repeat: no-repeat;
            width: 29.7cm;
            height: 21cm;
            position: relative;
            color: #000;
        }

        /* Add elegant border overlay */
        body::before {
            content: '';
            position: absolute;
            top: 0.5cm;
            left: 0.5cm;
            right: 0.5cm;
            bottom: 0.5cm;
            border: 3px solid #255946;
            border-radius: 15px;
            box-shadow: inset 0 0 0 3px #fff, inset 0 0 0 6px #255946;
            pointer-events: none;
            z-index: 1;
        }

        .content-wrapper {
            position: absolute;
            top: 2.5cm;
            left: 1.5cm;
            right: 1.5cm;
            bottom: 2cm;
            text-align: center;
            z-index: 2;
        }

        .logo-tutwuri {
            position: absolute;
            top: 0.8cm;
            left: 2.2cm;
            width: 1.8cm;
            height: auto;
            z-index: 3;
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));
        }

        .logo-unj {
            position: absolute;
            top: 0.8cm;
            right: 2.2cm;
            width: 1.8cm;
            height: auto;
            z-index: 3;
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));
        }

        .sertifikat-title {
            font-size: 56px;
            font-weight: bold;
            margin-top: 1.2cm;
            color: #255946;
            font-family: 'Brush Script MT', 'Lucida Handwriting', cursive;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
            letter-spacing: 2px;
            background: linear-gradient(45deg, #255946, #2d6b4f);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .nomor-sertifikat {
            font-size: 14px;
            margin-top: 0.3cm;
            color: #666;
            font-style: italic;
            letter-spacing: 0.5px;
        }

        .diberikan-kepada-label {
            font-size: 16px;
            margin-top: 1.4cm;
            color: #444;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .participant-name {
            font-size: 32px;
            font-weight: bold;
            margin-top: 0.4cm;
            color: #1a3d2e;
            text-decoration: underline;
            text-decoration-thickness: 2px;
            text-underline-offset: 8px;
            text-decoration-color: #255946;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
            letter-spacing: 1px;
            line-height: 1.2;
        }

        .sebagai-peserta-label {
            font-size: 16px;
            margin-top: 0.6cm;
            color: #444;
            font-weight: 500;
            text-transform: capitalize;
        }

        .event-name {
            font-size: 18px;
            font-weight: bold;
            margin-top: 0.4cm;
            line-height: 1.5;
            color: #1a3d2e;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.05);
            max-width: 80%;
            margin-left: auto;
            margin-right: auto;
        }

        .event-details {
            font-size: 14px;
            margin-top: 0.3cm;
            color: #555;
            font-style: italic;
            line-height: 1.4;
        }

        .signature-section {
            margin-top: 1.8cm;
            width: 100%;
            position: relative;
        }

        .signature-details {
            font-size: 14px;
            line-height: 1.5;
            color: #333;
        }

        .signature-title {
            margin-bottom: 2.8cm;
            position: relative;
        }

        /* Add decorative signature area */
        .signature-title::after {
            content: '';
            position: absolute;
            bottom: -0.3cm;
            left: 50%;
            transform: translateX(-50%);
            width: 6cm;
            height: 1px;
            background: linear-gradient(to right, transparent, #255946, transparent);
        }

        .signature-name {
            font-weight: bold;
            text-decoration: underline;
            text-decoration-color: #255946;
            text-decoration-thickness: 1px;
            text-underline-offset: 3px;
            color: #1a3d2e;
            font-size: 15px;
        }

        /* Add subtle decorative elements */
        .content-wrapper::before {
            content: '';
            position: absolute;
            top: -0.5cm;
            left: 50%;
            transform: translateX(-50%);
            width: 24px;
            height: 24px;
            background-image: url('https://spm.unj.ac.id/wp-content/uploads/2024/08/cropped-Logo-UNJ-PTNBH-RGB_Logo_Motto_Transparan-300x300.png');
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
            opacity: 0.6;
        }

        .content-wrapper::after {
            content: '';
            position: absolute;
            bottom: -0.5cm;
            left: 50%;
            transform: translateX(-50%);
            width: 24px;
            height: 24px;
            background-image: url('https://spm.unj.ac.id/wp-content/uploads/2024/08/cropped-Logo-UNJ-PTNBH-RGB_Logo_Motto_Transparan-300x300.png');
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
            opacity: 0.6;
        }

        /* Enhance text readability */
        .diberikan-kepada-label,
        .sebagai-peserta-label {
            position: relative;
        }

        .diberikan-kepada-label::after,
        .sebagai-peserta-label::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 50%;
            transform: translateX(-50%);
            width: 3cm;
            height: 1px;
            background: linear-gradient(to right, transparent, #255946, transparent);
            opacity: 0.5;
        }
    </style>
</head>
<body>
    <div class="pattern-overlay"></div>
    
    <div class="content-wrapper">
        <div class="sertifikat-title">Sertifikat</div>
        <div class="nomor-sertifikat">Nomor : B/169/UN39.15/DL.17/2025</div>

        <div class="diberikan-kepada-label">diberikan kepada</div>
        <div class="participant-name">{{ $katsinov->user->name }}</div>

        <div class="sebagai-peserta-label">Sebagai Peserta</div>
        <div class="event-name">
            PELATIHAN CALON REVIEWER PENGUKURAN KESIAPAN INOVASI (KATSINOV)
            <br>
            UNIVERSITAS NEGERI JAKARTA
        </div>
        <div class="event-details">
            Yang diselenggarakan oleh Universitas Negeri Jakarta pada tanggal 28 s.d. 30 April 2025
        </div>

        <div class="signature-section" style="margin-top: 1cm;">
            <div class="signature-details">
            Jakarta, 30 April 2025
            <br>
            Kepala Badan Pengembangan Pendidikan dan Pembelajaran
            <br>
            Universitas Negeri Jakarta
            <div class="signature-title" style="margin-bottom: 2.2cm;">
            {{-- Placeholder for signature image if you have one --}}
            {{-- <img src="path/to/signature.png" alt="Signature" style="height: 1.5cm; margin-top: 0.2cm; margin-bottom: 0.2cm;"> --}}
            </div>
            <span class="signature-name">Prof. Dr. Johansyah Lubis, M.Pd.</span>
            <br>
            NIP. 196705081993031001
            </div>
        </div>
    </div>
</body>
</html>