<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Laporan KATSINOV Self-Assessment - {{ $assessment->judul_inovasi }}</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 20mm 20mm 20mm 20mm;
        }

        body {
            font-family: 'DejaVu Sans', 'Helvetica', Arial, sans-serif;
            font-size: 10pt;
            line-height: 1.4;
            color: #111;
            margin: 0;
            padding: 0;
        }

        .header-title {
            text-align: center;
            font-weight: bold;
            font-size: 13pt;
            text-transform: uppercase;
            margin-bottom: 2px;
        }

        .header-subtitle {
            text-align: center;
            font-weight: bold;
            font-size: 11pt;
            color: #333;
            margin-bottom: 20px;
        }

        .divider {
            border-bottom: 2px solid #111;
            margin-bottom: 20px;
        }

        /* TABLES */
        table.info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table.info-table td {
            padding: 5px 8px;
            font-size: 10pt;
            vertical-align: top;
            border: 1px solid #ddd;
        }

        table.info-table td.label-col {
            width: 25%;
            font-weight: bold;
            background-color: #f9f9f9;
        }

        table.info-table td.colon-col {
            width: 3%;
            text-align: center;
        }

        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            margin-bottom: 20px;
        }

        table.data-table th,
        table.data-table td {
            border: 1px solid #333;
            padding: 6px 8px;
            font-size: 9.5pt;
        }

        table.data-table th {
            background-color: #f2f2f2;
            text-transform: uppercase;
            font-weight: bold;
            text-align: center;
        }

        .section-header {
            font-size: 11pt;
            font-weight: bold;
            text-transform: uppercase;
            margin-top: 20px;
            margin-bottom: 8px;
            padding-bottom: 3px;
            border-bottom: 1px solid #333;
        }

        .badge-level {
            display: inline-block;
            padding: 6px 14px;
            background-color: #10b981;
            color: white;
            font-weight: bold;
            font-size: 12pt;
            border-radius: 4px;
        }

        .result-box {
            background-color: #f8fafc;
            border: 1px solid #cbd5e1;
            padding: 12px 16px;
            margin-bottom: 20px;
            border-radius: 4px;
        }

        .score-bar-container {
            width: 100%;
            background-color: #e2e8f0;
            height: 12px;
            border-radius: 3px;
            overflow: hidden;
            display: inline-block;
        }

        .score-bar {
            height: 12px;
            background-color: #10b981;
        }

        /* SIGNATURES SECTION */
        table.sig-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
            page-break-inside: avoid;
        }

        table.sig-table td {
            border: none;
            vertical-align: top;
            font-size: 10.5pt;
            line-height: 1.4;
        }

        .sig-space {
            height: 70px;
        }

        .sig-name {
            font-weight: bold;
            text-decoration: underline;
        }

        .page-break {
            page-break-after: always;
        }

        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .bold { font-weight: bold; }
    </style>
</head>
<body>

    {{-- KOP / TITLE --}}
    <div class="header-title">LAPORAN PENGUKURAN TINGKAT KESIAPAN INOVASI</div>
    <div class="header-title">(KATSINOV - METER)</div>
    <div class="header-subtitle">PENILAIAN MANDIRI (SELF-ASSESSMENT) HACKATHON UNJ {{ date('Y') }}</div>
    <div class="divider"></div>

    {{-- INFORMASI INOVASI --}}
    <div class="section-header">I. IDENTITAS INOVASI & PENGUSUL</div>
    <table class="info-table">
        <tr>
            <td class="label-col">Nama / Judul Inovasi</td>
            <td class="colon-col">:</td>
            <td><strong>{{ $assessment->judul_inovasi }}</strong></td>
        </tr>
        <tr>
            <td class="label-col">Fokus Bidang Inovasi</td>
            <td class="colon-col">:</td>
            <td>{{ $assessment->fokus_bidang ?: '-' }}</td>
        </tr>
        <tr>
            <td class="label-col">Nama Tim Pengusul</td>
            <td class="colon-col">:</td>
            <td><strong>{{ $assessment->nama_tim ?: ($submission ? $submission->user->name . ' Team' : '-') }}</strong></td>
        </tr>
        <tr>
            <td class="label-col">Ketua Tim Pengusul</td>
            <td class="colon-col">:</td>
            <td>{{ $ketua ? $ketua->name : '-' }}</td>
        </tr>
        @if($members && $members->count() > 0)
            <tr>
                <td class="label-col">Anggota Tim</td>
                <td class="colon-col">:</td>
                <td>
                    <ol style="margin: 0; padding-left: 18px;">
                        @foreach($members as $m)
                            <li>{{ $m->user?->name ?: $m->nama_lengkap }} ({{ $m->peran_ic ?: $m->peran }})</li>
                        @endforeach
                    </ol>
                </td>
            </tr>
        @endif
        <tr>
            <td class="label-col">Lembaga / Institusi</td>
            <td class="colon-col">:</td>
            <td>{{ $assessment->institusi ?: 'Universitas Negeri Jakarta' }}</td>
        </tr>
        <tr>
            <td class="label-col">Alamat / Kontak</td>
            <td class="colon-col">:</td>
            <td>{{ $assessment->alamat ?: '-' }} &bull; {{ $assessment->kontak ?: '-' }}</td>
        </tr>
        <tr>
            <td class="label-col">Tanggal Pengukuran</td>
            <td class="colon-col">:</td>
            <td>{{ $dateFormatted }}</td>
        </tr>
    </table>

    {{-- HASIL PENGUKURAN --}}
    <div class="section-header">II. RINGKASAN HASIL PENGUKURAN KATSINOV</div>
    <div class="result-box">
        <table style="width: 100%; border: none;">
            <tr>
                <td style="width: 60%; vertical-align: middle;">
                    <div style="font-size: 11pt; color: #475569; margin-bottom: 4px;">Tingkat Capaian Kesiapan Inovasi:</div>
                    <div style="font-size: 18pt; font-weight: bold; color: #0f172a;">
                        KATSINOV LEVEL {{ $achieved_level }}
                    </div>
                    <div style="font-size: 10pt; color: #64748b; margin-top: 4px;">
                        Rata-rata Kesiapan Keseluruhan: <strong>{{ number_format($overall_percentage, 1) }}%</strong>
                    </div>
                </td>
                <td style="width: 40%; text-align: right; vertical-align: middle;">
                    @if($achieved_level >= 1)
                        <div class="badge-level">LEVEL {{ $achieved_level }} TERPENUHI</div>
                    @else
                        <div class="badge-level" style="background-color: #64748b;">LEVEL 0 (BELUM TERPENUHI)</div>
                    @endif
                </td>
            </tr>
        </table>
    </div>

    {{-- TABEL CAPAIAN PER LEVEL INDIKATOR 1 - 6 --}}
    <div class="bold" style="font-size: 10pt; margin-top: 15px; margin-bottom: 5px;">Rangkuman Capaian per Level (Passing Grade Standar: ≥ 80.0%)</div>
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 8%;">Level</th>
                <th>Fase Kesiapan Inovasi</th>
                <th style="width: 18%;">Skor Tercapai</th>
                <th style="width: 16%;">Persentase</th>
                <th style="width: 22%;">Status Capaian</th>
            </tr>
        </thead>
        <tbody>
            @php
                $levelNames = [
                    1 => 'Fase 1: Idea Generation & Concept Exploration',
                    2 => 'Fase 2: Component & Laboratory Validation',
                    3 => 'Fase 3: Completion & Actual System Demonstration',
                    4 => 'Fase 4: Chasin / Early Market Introduction',
                    5 => 'Fase 5: Competition & Market Penetration',
                    6 => 'Fase 6: Changeover / Continuous Innovation'
                ];
            @endphp
            @for($lvl = 1; $lvl <= 6; $lvl++)
                @php
                    $stat = $indicator_scores[$lvl] ?? ['earned' => 0, 'max' => 0, 'percentage' => 0, 'passed' => false];
                    $pct = $stat['percentage'] ?? 0;
                    $passed = $stat['passed'] ?? false;
                @endphp
                <tr>
                    <td class="text-center bold">{{ $lvl }}</td>
                    <td>{{ $levelNames[$lvl] }}</td>
                    <td class="text-center">{{ $stat['earned'] ?? 0 }} / {{ $stat['max'] ?? 0 }}</td>
                    <td class="text-center bold">{{ number_format($pct, 1) }}%</td>
                    <td class="text-center">
                        @if($passed)
                            <span style="color: #059669; font-weight: bold;">MEMENUHI (≥80%)</span>
                        @else
                            <span style="color: #dc2626; font-weight: bold;">BELUM MEMENUHI</span>
                        @endif
                    </td>
                </tr>
            @endfor
        </tbody>
    </table>

    {{-- TABEL 7 ASPEK KUNCI --}}
    <div class="bold" style="font-size: 10pt; margin-top: 15px; margin-bottom: 5px;">Capaian Berdasarkan 7 Aspek Kunci Inovasi</div>
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 10%;">Kode</th>
                <th>Aspek Inovasi</th>
                <th style="width: 20%;">Tingkat Kesiapan</th>
                <th style="width: 25%;">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($aspects as $code => $asp)
                @php
                    $pct = $aspect_scores[$code] ?? 0;
                    $status = $pct >= 80 ? 'Sangat Siap' : ($pct >= 60 ? 'Berkembang' : 'Perlu Peningkatan');
                    $color = $pct >= 80 ? '#059669' : ($pct >= 60 ? '#d97706' : '#dc2626');
                @endphp
                <tr>
                    <td class="text-center bold">{{ $code }}</td>
                    <td>{{ $asp['name'] }}</td>
                    <td class="text-center bold" style="color: {{ $color }};">{{ number_format($pct, 1) }}%</td>
                    <td class="text-center">{{ $status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- LEMBAR PENGESAHAN (HANYA DARI PESERTA / TIM PENGUSUL - HAPUS REVIEWER) --}}
    <div style="margin-top: 25px;">
        <p style="text-align: justify; font-size: 9.5pt; color: #333;">
            Demikian Laporan Pengukuran Tingkat Kesiapan Inovasi (KATSINOV) ini dilakukan dan dinyatakan secara mandiri (Self-Assessment) oleh Tim Pengusul dengan sebenar-benarnya untuk dipergunakan sebagai dokumen kelengkapan proposal Hackathon UNJ {{ date('Y') }}.
        </p>

        <table class="sig-table">
            <tr>
                <td style="width: 50%;"></td>
                <td style="width: 50%; text-align: left; padding-left: 30px;">
                    <div>{{ $assessment->alamat ? 'Jakarta' : 'Jakarta' }}, {{ $dateFormatted }}</div>
                    <div style="margin-top: 4px;">Yang Menyatakan (Ketua Tim Pengusul),</div>
                    @if($assessment->signature_image)
                        <div style="margin: 6px 0; height: 65px;">
                            <img src="{{ $assessment->signature_image }}" alt="Tanda Tangan" style="max-height: 60px; max-width: 180px;">
                        </div>
                    @else
                        <div class="sig-space"></div>
                    @endif
                    <div class="sig-name">{{ $ketua ? $ketua->name : ($assessment->nama_tim ?: 'Ketua Pengusul') }}</div>
                    @if($ketua && !empty($ketua->nip_nim))
                        <div>NIM/NIP. {{ $ketua->nip_nim }}</div>
                    @else
                        <div>Peserta / Pengusul Inovasi</div>
                    @endif
                </td>
            </tr>
        </table>
    </div>

</body>
</html>
