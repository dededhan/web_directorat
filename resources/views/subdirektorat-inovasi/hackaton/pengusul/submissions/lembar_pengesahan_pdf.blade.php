<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Lembar Pengesahan - {{ $judul_inovasi ?? 'Proposal Hackathon' }}</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 20mm 20mm 20mm 20mm;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 11pt;
            line-height: 1.45;
            color: #111;
            margin: 0;
            padding: 0;
        }

        .header-kop {
            width: 100%;
            border-bottom: 2px solid #000;
            padding-bottom: 8px;
            margin-bottom: 18px;
        }

        .kop-table {
            width: 100%;
            border-collapse: collapse;
        }

        .kop-table td {
            border: none;
            padding: 0;
            vertical-align: middle;
        }

        .kop-logo {
            width: 75px;
            text-align: center;
        }

        .kop-logo img {
            width: 70px;
            height: auto;
        }

        .kop-text {
            text-align: center;
            padding-left: 10px;
        }

        .kop-text .instansi-kemdikbud {
            font-size: 12pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #1a4d2e;
            margin-bottom: 2px;
        }

        .kop-text .instansi-univ {
            font-size: 14pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 2px;
        }

        .kop-text .instansi-unit {
            font-size: 10.5pt;
            font-weight: bold;
            text-transform: uppercase;
            color: #222;
            margin-bottom: 2px;
        }

        .kop-text .instansi-alamat {
            font-size: 8.5pt;
            color: #444;
        }

        .doc-title-container {
            text-align: center;
            margin-top: 10px;
            margin-bottom: 20px;
        }

        .doc-title {
            font-size: 14pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            text-decoration: underline;
            margin: 0 0 4px 0;
        }

        .doc-subtitle {
            font-size: 10.5pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin: 0;
            color: #333;
        }

        /* TABLE FORMAT */
        table.content-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table.content-table,
        table.content-table th,
        table.content-table td {
            border: 1px solid #222;
        }

        table.content-table td {
            padding: 7px 10px;
            vertical-align: top;
            font-size: 10.5pt;
        }

        .col-num {
            width: 28px;
            text-align: center;
            font-weight: bold;
        }

        .col-label {
            width: 190px;
            font-weight: bold;
        }

        .col-colon {
            width: 12px;
            text-align: center;
            font-weight: bold;
        }

        .col-val {
            text-align: justify;
        }

        .row-section-header {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .sub-item-label {
            padding-left: 18px !important;
        }

        .sub-bullet {
            width: 16px;
            text-align: center;
        }

        /* SIGNATURES SECTION */
        .date-container {
            text-align: right;
            margin-top: 15px;
            margin-bottom: 12px;
            font-size: 11pt;
        }

        table.sig-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
        }

        table.sig-table td {
            border: none;
            padding: 0;
            vertical-align: top;
            font-size: 11pt;
            line-height: 1.4;
        }

        .sig-col-left {
            width: 50%;
            text-align: left;
            padding-right: 15px;
        }

        .sig-col-right {
            width: 50%;
            text-align: left;
            padding-left: 25px;
        }

        .sig-space {
            height: 68px;
        }

        .sig-name {
            font-weight: bold;
            text-decoration: underline;
        }

        .sig-id {
            font-size: 10pt;
            color: #222;
        }
    </style>
</head>
<body>

    {{-- KOP SURAT RESMI UNJ --}}
    <div class="header-kop">
        <table class="kop-table">
            <tr>
                <td class="kop-logo">
                    @if(!empty($logoBase64))
                        <img src="{{ $logoBase64 }}" alt="Logo UNJ">
                    @endif
                </td>
                <td class="kop-text">
                    <div class="instansi-kemdikbud">KEMENTERIAN PENDIDIKAN TINGGI, SAINS, DAN TEKNOLOGI</div>
                    <div class="instansi-univ">UNIVERSITAS NEGERI JAKARTA</div>
                    <div class="instansi-unit">DIREKTORAT INOVASI, SISTEM INFORMASI, DAN PEMERINGKATAN</div>
                    <div class="instansi-alamat">Gedung Rektorat UNJ Lantai 3, Jl. Rawamangun Muka, Jakarta Timur 13220</div>
                </td>
            </tr>
        </table>
    </div>

    {{-- TITLE --}}
    <div class="doc-title-container">
        <h1 class="doc-title">LEMBAR PENGESAHAN</h1>
        <p class="doc-subtitle">PROGRAM HACKATHON INOVASI UNIVERSITAS NEGERI JAKARTA</p>
    </div>

    {{-- TABLE CONTENT --}}
    <table class="content-table">
        <tbody>
            {{-- 1. Judul Inovasi --}}
            <tr>
                <td class="col-num">1.</td>
                <td class="col-label">Judul Inovasi</td>
                <td class="col-colon">:</td>
                <td class="col-val"><strong>{{ $judul_inovasi ?: '-' }}</strong></td>
            </tr>

            {{-- 2. Kategori Focus Challenge --}}
            <tr>
                <td class="col-num">2.</td>
                <td class="col-label">Kategori Focus Challenge</td>
                <td class="col-colon">:</td>
                <td class="col-val">{{ $kategori_focus_challenge ?: '-' }}</td>
            </tr>

            {{-- 3. Ketua Tim --}}
            <tr>
                <td class="col-num" rowspan="7">3.</td>
                <td colspan="3" class="row-section-header">Ketua Tim</td>
            </tr>
            <tr>
                <td class="sub-item-label">- Nama Lengkap</td>
                <td class="col-colon">:</td>
                <td class="col-val"><strong>{{ $ketua_nama ?: '-' }}</strong></td>
            </tr>
            <tr>
                <td class="sub-item-label">- NIM / NIP / NIK</td>
                <td class="col-colon">:</td>
                <td class="col-val">{{ $ketua_nik_nim_nip ?: '-' }}</td>
            </tr>
            <tr>
                <td class="sub-item-label">- Prodi / Fakultas / Instansi</td>
                <td class="col-colon">:</td>
                <td class="col-val">{{ $ketua_instansi ?: '-' }}</td>
            </tr>
            <tr>
                <td class="sub-item-label">- Pekerjaan</td>
                <td class="col-colon">:</td>
                <td class="col-val">{{ $ketua_pekerjaan ?: '-' }}</td>
            </tr>
            <tr>
                <td class="sub-item-label">- No. HP / WA</td>
                <td class="col-colon">:</td>
                <td class="col-val">{{ $ketua_no_hp ?: '-' }}</td>
            </tr>
            <tr>
                <td class="sub-item-label">- Email</td>
                <td class="col-colon">:</td>
                <td class="col-val">{{ $ketua_email ?: '-' }}</td>
            </tr>

            {{-- 4. Anggota Tim --}}
            @php
                $memberCount = !empty($anggota_tim) && is_array($anggota_tim) ? count($anggota_tim) : 0;
            @endphp
            <tr>
                <td class="col-num" rowspan="{{ max(2, $memberCount + 1) }}">4.</td>
                <td colspan="3" class="row-section-header">Anggota Tim</td>
            </tr>
            @if($memberCount > 0)
                @foreach($anggota_tim as $index => $anggota)
                    <tr>
                        <td class="sub-item-label">- Anggota Tim {{ $index + 1 }} / Pekerjaan</td>
                        <td class="col-colon">:</td>
                        <td class="col-val">{{ $anggota }}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td class="sub-item-label" colspan="3" style="font-style: italic; color: #666;">
                        - Tidak ada anggota tambahan -
                    </td>
                </tr>
            @endif
        </tbody>
    </table>

    {{-- TANGGAL & TEMPAT (POSITION IN RIGHT) --}}
    <div class="date-container">
        {{ $tanggal_tempat ?: 'Jakarta, ' . date('d F Y') }}
    </div>

    {{-- TANDA TANGAN (MENGETAHUI LEFT, KETUA TIM RIGHT) --}}
    <table class="sig-table">
        <tr>
            <td class="sig-col-left">
                Mengetahui,<br>
                <span>{{ $mengetahui_jabatan ?: 'Dekan / Pimpinan Instansi' }}</span>
                <div class="sig-space"></div>
                <div class="sig-name">{{ $mengetahui_nama ?: '( .................................................... )' }}</div>
                @if(!empty($mengetahui_nip))
                    <div class="sig-id">NIP/NIK. {{ $mengetahui_nip }}</div>
                @else
                    <div class="sig-id">NIP/NIK. ........................................</div>
                @endif
            </td>
            <td class="sig-col-right">
                Ketua Tim,
                <br>
                <span>&nbsp;</span>
                <div class="sig-space"></div>
                <div class="sig-name">{{ $ketua_ttd_nama ?: ($ketua_nama ?: '( .................................................... )') }}</div>
                @if(!empty($ketua_ttd_nip ?: $ketua_nik_nim_nip))
                    <div class="sig-id">NIM/NIP/NIK. {{ $ketua_ttd_nip ?: $ketua_nik_nim_nip }}</div>
                @else
                    <div class="sig-id">NIM/NIP/NIK. ........................................</div>
                @endif
            </td>
        </tr>
    </table>

</body>
</html>
