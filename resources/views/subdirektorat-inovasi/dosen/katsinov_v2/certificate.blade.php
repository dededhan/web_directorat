<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
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
            width: 29.7cm;
            height: 21cm;
            position: relative;
            color: #000;
            background: white;
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
            top: 2cm;
            left: 1.5cm;
            right: 1.5cm;
            bottom: 1.5cm;
            text-align: center;
            z-index: 2;
            overflow: hidden;
        }

        .sertifikat-title {
            font-size: 52px;
            font-weight: bold;
            margin-top: 0.3cm;
            color: #255946;
            font-family: 'Brush Script MT', 'Lucida Handwriting', cursive;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
            letter-spacing: 2px;
        }

        .nomor-sertifikat {
            font-size: 13px;
            margin-top: 0.2cm;
            color: #666;
            font-style: italic;
            letter-spacing: 0.5px;
        }

        .diberikan-kepada-label {
            font-size: 15px;
            margin-top: 0.6cm;
            color: #444;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .participant-name {
            font-size: 30px;
            font-weight: bold;
            margin-top: 0.3cm;
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
            font-size: 15px;
            margin-top: 0.4cm;
            color: #444;
            font-weight: 500;
            text-transform: capitalize;
        }

        .event-name {
            font-size: 17px;
            font-weight: bold;
            margin-top: 0.2cm;
            line-height: 1.4;
            color: #1a3d2e;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.05);
            max-width: 90%;
            margin-left: auto;
            margin-right: auto;
        }

        .achievement-box {
            margin-top: 0.3cm;
            padding: 0.3cm 0.5cm;
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            border-radius: 8px;
            display: inline-block;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }

        .score-main {
            font-size: 28px;
            font-weight: bold;
            color: #16a34a;
            margin: 0;
        }

        .grade-text {
            font-size: 16px;
            color: #1e40af;
            font-weight: bold;
            margin: 0.05cm 0;
        }

        .predicate-text {
            font-size: 13px;
            color: #475569;
            font-style: italic;
            margin: 0;
        }

        .event-details {
            font-size: 13px;
            margin-top: 0.2cm;
            color: #555;
            font-style: italic;
            line-height: 1.3;
        }

        .signature-section {
            margin-top: 0.5cm;
            width: 100%;
            position: relative;
        }

        .signature-details {
            font-size: 13px;
            line-height: 1.4;
            color: #333;
        }

        .signature-title {
            margin-bottom: 1.8cm;
            position: relative;
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

        .print-button {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 12px 24px;
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14pt;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            z-index: 1000;
        }
        
        .print-button:hover {
            background: #1d4ed8;
        }
        
        @media print {
            body {
                background: white;
            }
            
            .print-button {
                display: none;
            }
        }
    </style>
</head>
<body>
    {{-- Print Button --}}
    <button class="print-button" onclick="window.print()">🖨️ Print / Save PDF</button>

    <div class="content-wrapper">
        <div class="sertifikat-title">Sertifikat</div>
        <div class="nomor-sertifikat">Nomor : B/{{ str_pad($katsinov->id, 3, '0', STR_PAD_LEFT) }}/UN39.15/DL.17/{{ now()->format('Y') }}</div>

        <div class="diberikan-kepada-label">diberikan kepada</div>
        <div class="participant-name">{{ $katsinov->user->name }}</div>

        <div class="sebagai-peserta-label">Telah menyelesaikan</div>
        <div class="event-name">
            PENGUKURAN KESIAPAN INOVASI (KATSINOV)
            <br>
            {{ strtoupper($katsinov->title) }}
        </div>

        <div class="achievement-box">
            <div class="score-main">{{ number_format($overallScore, 2) }}%</div>
            <div class="grade-text">{{ $grade }}</div>
            <div class="predicate-text">{{ $predicate }}</div>
        </div>

        <div class="event-details">
            @if($informasi)
                {{ $informasi->innovation_type ?? 'Inovasi' }} - {{ $informasi->innovation_field ?? $katsinov->focus_area }}
                <br>
            @endif
            Institusi: {{ $katsinov->institution }}
            <br>
            Tanggal Penilaian: {{ $katsinov->assessment_date->format('d F Y') }}
        </div>

        <div class="signature-section">
            <div class="signature-details">
                Jakarta, {{ $katsinov->reviewed_at ? $katsinov->reviewed_at->format('d F Y') : now()->format('d F Y') }}
                <br>
                Kepala Badan Pengembangan Pendidikan dan Pembelajaran
                <br>
                Universitas Negeri Jakarta
                <div class="signature-title">
                    {{-- Placeholder for signature image if you have one --}}
                </div>
                <span class="signature-name">Prof. Dr. Johansyah Lubis, M.Pd.</span>
                <br>
                NIP. 196705081993031001
            </div>
        </div>

        @if($katsinov->reviewer)
        <div style="position: absolute; bottom: 0.5cm; left: 0; right: 0; font-size: 11px; color: #888;">
            Reviewer: {{ $katsinov->reviewer->name }}
        </div>
        @endif
    </div>

    <div style="position: absolute; bottom: 0.3cm; right: 1cm; font-size: 9px; color: #aaa;">
        Certificate ID: KATSINOV-{{ str_pad($katsinov->id, 6, '0', STR_PAD_LEFT) }}-{{ now()->format('Y') }}
    </div>
</body>
</html>

