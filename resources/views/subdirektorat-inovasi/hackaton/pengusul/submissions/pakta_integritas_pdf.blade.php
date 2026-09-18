<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Lembar Pakta Integritas - {{ $judul_inovasi ?? 'Proposal Hackathon' }}</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 20mm 20mm 16mm 20mm;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 10.5pt;
            line-height: 1.35;
            color: #111;
            margin: 0;
            padding: 0;
        }

        .doc-header {
            text-align: center;
            margin-top: 0;
            margin-bottom: 18px;
        }

        .doc-title {
            font-size: 13pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            text-decoration: underline;
            margin: 0 0 4px 0;
        }

        .doc-subtitle {
            font-size: 11pt;
            font-weight: bold;
            margin: 0;
            color: #222;
        }

        .intro-text {
            margin-top: 14px;
            margin-bottom: 6px;
            font-size: 10.5pt;
        }

        /* IDENTITAS TABLE */
        table.identitas-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px;
        }

        table.identitas-table td {
            border: none;
            padding: 2.5px 0;
            vertical-align: top;
            font-size: 10.5pt;
        }

        .col-bullet {
            width: 16px;
            text-align: left;
        }

        .col-label {
            width: 160px;
        }

        .col-colon {
            width: 14px;
            text-align: center;
        }

        .col-val {
            text-align: justify;
        }

        .preamble-text {
            text-align: justify;
            margin-top: 8px;
            margin-bottom: 8px;
            font-size: 10.5pt;
            line-height: 1.35;
        }

        /* POIN-POIN TABLE */
        table.poin-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px;
        }

        table.poin-table td {
            border: none;
            padding: 2.5px 0;
            vertical-align: top;
            font-size: 10pt;
            line-height: 1.32;
        }

        .poin-num {
            width: 22px;
            text-align: left;
        }

        .poin-text {
            text-align: justify;
        }

        .closing-text {
            text-align: justify;
            margin-top: 8px;
            margin-bottom: 12px;
            font-size: 10.5pt;
            line-height: 1.35;
        }

        /* SIGNATURE SECTION (RIGHT POSITION) */
        table.sig-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }

        table.sig-table td {
            border: none;
            padding: 0;
            vertical-align: top;
            font-size: 10.5pt;
            line-height: 1.35;
        }

        .sig-empty {
            width: 55%;
        }

        .sig-right {
            width: 45%;
            text-align: left;
            padding-left: 20px;
        }

        .materai-box {
            width: 76px;
            height: 44px;
            border: 1px dashed #777;
            text-align: center;
            vertical-align: middle;
            margin-top: 6px;
            margin-bottom: 8px;
            padding-top: 6px;
            font-size: 7.5pt;
            color: #666;
            line-height: 1.2;
            background-color: #fafafa;
        }

        .sig-name {
            font-weight: bold;
            text-decoration: underline;
            font-size: 10.5pt;
        }

        .sig-id {
            font-size: 9.5pt;
            color: #222;
        }
    </style>
</head>
<body>

    {{-- TITLE (MIDDLE POSITION) --}}
    <div class="doc-header">
        <h1 class="doc-title">LEMBAR PAKTA INTEGRITAS</h1>
        <div class="doc-subtitle">Peserta HackAthon DeepTech Universitas Negeri Jakarta {{ $tahun ?: date('Y') }}</div>
    </div>

    {{-- INTRO --}}
    <div class="intro-text">
        yang bertanda tangan di bawah ini
    </div>

    {{-- IDENTITAS --}}
    <table class="identitas-table">
        <tr>
            <td class="col-bullet">-</td>
            <td class="col-label">Nama Lengkap</td>
            <td class="col-colon">:</td>
            <td class="col-val"><strong>{{ $nama_lengkap ?: '-' }}</strong></td>
        </tr>
        <tr>
            <td class="col-bullet">-</td>
            <td class="col-label">NIM/NIP/NIK</td>
            <td class="col-colon">:</td>
            <td class="col-val">{{ $nik_nim_nip ?: '-' }}</td>
        </tr>
        <tr>
            <td class="col-bullet">-</td>
            <td class="col-label">Institusi</td>
            <td class="col-colon">:</td>
            <td class="col-val">{{ $institusi ?: '-' }}</td>
        </tr>
        <tr>
            <td class="col-bullet">-</td>
            <td class="col-label">Nama Tim</td>
            <td class="col-colon">:</td>
            <td class="col-val"><strong>{{ $nama_tim ?: '-' }}</strong></td>
        </tr>
        <tr>
            <td class="col-bullet">-</td>
            <td class="col-label">Judul Inovasi</td>
            <td class="col-colon">:</td>
            <td class="col-val"><strong>{{ $judul_inovasi ?: '-' }}</strong></td>
        </tr>
    </table>

    {{-- PREAMBLE --}}
    <div class="preamble-text">
        dalam rangka pengusulan dan pelaksanaan kegiatan Hackathon Deeptech Universitas Negeri Jakarta {{ $tahun ?: date('Y') }}, dengan ini menyatakan dengan sesungguhnya bahwa saya:
    </div>

    {{-- 6 POIN PERNYATAAN --}}
    <table class="poin-table">
        <tr>
            <td class="poin-num">1.</td>
            <td class="poin-text">menjamin bahwa proposal, ide, karya, purwarupa, dan inovasi yang diajukan merupakan karya orisinal, tidak mengandung plagiarisme, serta tidak mengandung fabrikasi data;</td>
        </tr>
        <tr>
            <td class="poin-num">2.</td>
            <td class="poin-text">menjamin bahwa proposal, ide, karya, purwarupa, atau inovasi yang diajukan tidak melanggar hak kekayaan intelektual pihak lain serta tidak sedang diajukan secara ganda pada kegiatan lain;</td>
        </tr>
        <tr>
            <td class="poin-num">3.</td>
            <td class="poin-text">melaksanakan tugas dan tanggung jawab dalam kegiatan Hackathon sesuai dengan proposal yang diajukan dan perjanjian yang disepakati dengan penyelenggara;</td>
        </tr>
        <tr>
            <td class="poin-num">4.</td>
            <td class="poin-text">tidak memiliki dan tidak akan menciptakan konflik kepentingan (conflict of interest) yang dapat memengaruhi objektivitas pelaksanaan kegiatan maupun proses seleksi, pendampingan, penilaian, dan evaluasi;</td>
        </tr>
        <tr>
            <td class="poin-num">5.</td>
            <td class="poin-text">menggunakan fasilitas, dukungan pendanaan, data, perangkat, bahan, serta sumber daya lain yang diberikan oleh penyelenggara sesuai dengan peruntukan dan ketentuan yang berlaku, serta bertanggung jawab penuh atas penggunaan dan pelaporannya;</td>
        </tr>
        <tr>
            <td class="poin-num">6.</td>
            <td class="poin-text">menjaga kerahasiaan data, informasi, dokumen, teknologi, proses bisnis, dan informasi lain yang dinyatakan bersifat rahasia oleh penyelenggara, mitra, dan pihak terkait, serta menggunakan kecerdasan buatan, perangkat lunak, dataset, dan teknologi pihak ketiga secara bertanggung jawab sesuai dengan ketentuan yang berlaku;</td>
        </tr>
    </table>

    {{-- CLOSING PARAGRAPH --}}
    <div class="closing-text">
        Demikian Pakta Integritas ini saya buat dengan sebenar-benarnya, bilamana di kemudian hari ditemukan ketidaksesuaian dengan pernyataan ini, saya bersedia bertanggungjawab dan diproses sesuai dengan ketentuan yang berlaku dan mengembalikan seluruh biaya yang sudah diterima ke kas negara.
    </div>

    {{-- SIGNATURE SECTION (RIGHT POSITION) --}}
    <table class="sig-table">
        <tr>
            <td class="sig-empty"></td>
            <td class="sig-right">
                <div>{{ $tanggal_tempat ?: 'Jakarta, ' . date('d F Y') }}</div>
                <div>Yang membuat pernyataan,</div>
                <div style="font-weight: bold;">Ketua Pengusul</div>

                <div class="materai-box">
                    <span>Materai<br>Rp10.000</span>
                </div>

                <div class="sig-name">{{ $penandatangan_nama ?: '( .................................................... )' }}</div>
                @if(!empty($penandatangan_nik))
                    <div class="sig-id">NIM/NIP/NIK. {{ $penandatangan_nik }}</div>
                @else
                    <div class="sig-id">NIM/NIP/NIK. ........................................</div>
                @endif
            </td>
        </tr>
    </table>

</body>
</html>
