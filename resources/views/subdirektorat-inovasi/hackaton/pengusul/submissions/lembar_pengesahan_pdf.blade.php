<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Lembar Pengesahan - {{ $judul_inovasi ?? 'Proposal Hackathon' }}</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 25mm 20mm 20mm 20mm;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 11pt;
            line-height: 1.45;
            color: #111;
            margin: 0;
            padding: 0;
        }

        .doc-title-container {
            text-align: center;
            margin-top: 0;
            margin-bottom: 25px;
        }

        .doc-title {
            font-size: 14pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            text-decoration: underline;
            margin: 0;
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

        /* SIGNATURES SECTION */
        table.sig-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table.sig-table td {
            border: none;
            padding: 0;
            vertical-align: top;
            font-size: 11pt;
            line-height: 1.4;
        }

        .sig-col-left {
            width: 58%;
            text-align: left;
            padding-right: 15px;
        }

        .sig-col-right {
            width: 42%;
            text-align: left;
            padding-left: 15px;
        }

        .sig-space {
            height: 65px;
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

    {{-- TITLE --}}
    <div class="doc-title-container">
        <h1 class="doc-title">LEMBAR PENGESAHAN</h1>
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

    {{-- TANDA TANGAN (MENGETAHUI LEFT, KETUA TIM & TANGGAL RIGHT) --}}
    <table class="sig-table">
        <tr>
            <td class="sig-col-left"></td>
            <td class="sig-col-right" style="padding-bottom: 12px;">
                {{ $tanggal_tempat ?: 'Jakarta, ' . date('d F Y') }}
            </td>
        </tr>
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
