<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Laporan Pengukuran Tingkat Kesiapan Inovasi - {{ $judul_inovasi ?? '' }}</title>
    <style>
        @page { margin: 20mm 25mm; } /* Adjust margins as needed */
        body {
            font-family: 'DejaVu Sans', sans-serif; /* Ensure Dejavu Sans for wider character support */
            font-size: 10pt;
            line-height: 1.4;
        }
        .header-logo {
            display: block;
            margin-left: auto;
            margin-right: auto;
            width: 150px; /* Adjust as needed */
            margin-bottom: 10px;
        }
        .report-title { text-align: center; font-weight: bold; margin-top: 5px; font-size: 12pt; text-transform: uppercase;}
        .sub-title { text-align: center; font-weight: bold; font-size: 11pt; margin-bottom: 2px; }
        .innovation-details-table, .recommendation-table, .aspect-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            margin-bottom:15px;
        }
        .innovation-details-table td, .recommendation-table td, .aspect-table td {
            border: 1px solid black;
            padding: 6px 8px;
            vertical-align: top;
        }
        .innovation-details-table td:nth-child(1) { width: 25%; font-weight: bold; }
        .innovation-details-table td:nth-child(2) { width: 2%; text-align:center; }
        .innovation-details-table td:nth-child(3) { width: 73%; }

        .section-heading { font-weight: bold; margin-top: 20px; margin-bottom: 10px; font-size: 11pt; }
        .level-summary { margin-bottom: 8px; text-align: justify; }
        .signatures-table { width:100%; border:none; margin-top: 30px; }
        .signatures-table td { border: none; text-align: center; padding: 10px; vertical-align: top; }
        .nip-space { margin-top: 60px; display:block; } /* Space for signature */
        .page-break { page-break-after: always; }

        .image-placeholder {
            width: 90%;
            height: 150px; /* Adjust as needed */
            background-color: #eeeeee;
            display:flex;
            align-items:center;
            justify-content:center;
            border:1px solid #cccccc;
            margin: 15px auto;
            text-align: center;
            font-style: italic;
            color: #555555;
        }
        .table-caption { text-align:left; font-size:10pt; margin-bottom: 5px; font-weight:normal; }
        .text-right { text-align: right; font-size: 9pt; margin-bottom:10px; }
        ol, ul { padding-left: 20px; margin-top: 5px; margin-bottom: 10px;}
        li { margin-bottom: 3px; }
        p { margin-top: 5px; margin-bottom: 10px; }
        .bold { font-weight: bold; }
    </style>
</head>
<body>
    <img src="data:image/png;base64,{{ $logo_base64 }}" alt="RISTEKDIKTI Logo" class="header-logo">
    <div class="report-title">LAPORAN</div>
    <div class="report-title">PENGUKURAN TINGKAT KESIAPAN INOVASI</div>

    <table class="innovation-details-table" style="margin-top: 25px;">
        <tr>
            <td>JUDUL INOVASI</td>
            <td>:</td>
            <td>{{ $judul_inovasi }}</td>
        </tr>
        <tr>
            <td>BIDANG INOVASI</td>
            <td>:</td>
            <td>{{ $bidang_inovasi }}</td>
        </tr>
        <tr>
            <td>LEMBAGA/ INSTANSI</td>
            <td>:</td>
            <td>{{ $lembaga_instansi }}</td>
        </tr>
        <tr>
            <td>ALAMAT/ KONTAK</td>
            <td>:</td>
            <td>{{ $alamat_kontak }}</td>
        </tr>
    </table>

    <div style="margin-top: 30px;">
        <div class="sub-title">Direktorat Jenderal Penguatan Inovasi</div>
        <div class="sub-title">Kementerian Riset Teknologi dan Pendidikan Tinggi</div>
        <div class="sub-title">TAHUN {{ $tahun_laporan }}</div>
    </div>

    <div style="text-align:center; margin-top: 25px;">
        <div class="section-heading">LEMBAR PENGESAHAN</div>
        <div class="section-heading" style="margin-top:2px;">LAPORAN</div>
        <div class="section-heading" style="margin-top:2px;">PENGUKURAN TINGKAT KESIAPAN INOVASI</div>
    </div>

    <table class="signatures-table" style="margin-top:20px;">
        <tr>
            <td style="width:40%;"></td>
            <td style="width:60%; text-align:left;">{{ $pengesahan_tempat_tanggal ?? '(Tempat, D-M-Y)' }}</td>
        </tr>
        <tr>
            <td style="text-align:left;">Penanggung Jawab pengukuran,</td>
            <td style="text-align:left; padding-left:50px;">Ketua Tim Pelaksana Pengukuran,</td>
        </tr>
        <tr>
            <td style="text-align:left;"><span class="nip-space"></span><br>{{ $penanggung_jawab_pengukuran ?? '(Nama)' }}<br>{{ $penanggung_jawab_nip ?? 'NIP. (NIP)' }}</td>
            <td style="text-align:left; padding-left:50px;"><span class="nip-space"></span><br>{{ $ketua_tim_pelaksana ?? '(Nama)' }}<br>{{ $ketua_tim_pelaksana_nip ?? 'NIP. (NIP)' }}</td>
        </tr>
         <tr>
            <td colspan="2" style="text-align:center; padding-top: 20px;">Tim Pengendali Pengukuran,</td>
        </tr>
         <tr>
            <td colspan="2" style="text-align:center;"><span class="nip-space"></span><br>{{ $tim_pengendali_pengukuran ?? '(Nama)' }}<br>{{ $tim_pengendali_nip ?? 'NIP. (NIP)' }}</td>
        </tr>
    </table>

    <div class="page-break"></div>
    <div class="text-right">2</div>

    <div class="section-heading">1. PROFIL PRODUK INOVASI</div>
    {{-- Placeholder for Profil Produk Inovasi content --}}
    <p style="min-height: 50px;"><i>(Bagian ini untuk deskripsi profil produk inovasi)</i></p>


    <div class="section-heading">2. HASIL PENGUKURAN</div>
    <p>Untuk melihat secara detail hasil pengukuran Katsinov dilakukan dengan melihat tingkat capaian atribut atau indikator dan tingkat capaian setiap aspek per Level Katsinov.</p>
    <p>Berikut ini hasil pengukuran secara detail untuk setiap Level Katsinov:</p>

    @foreach ($katsinov_levels_data as $level_num => $level_data)
        <div class="section-heading" style="font-size:10.5pt; margin-left:10px;">{{ chr(64 + $level_num) }}. Level Katsinov {{ $level_num }}</div>
        <p class="level-summary" style="margin-left:10px;">{{ $level_data['level_deskripsi'] }}</p>
        <p class="level-summary" style="margin-left:10px;">
            Dari hasil pengukuran pada Katsinov {{ $level_num }} diperoleh tingkat kesiapan sebesar <span class="bold">{{ number_format($level_data['total_kesiapan_level'], 2) }}%</span>, artinya
            <span class="bold">@if ($level_data['memenuhi_kesiapan']) memenuhi @else tidak memenuhi @endif</span>
            tingkat kesiapan inovasi atau Katsinov {{ $level_num }} karena
            @if ($level_data['memenuhi_kesiapan']) diatas @else dibawah @endif
            batas tingkat kesiapan yang ditetapkan, yaitu ≥ {{ $level_data['batas_kesiapan'] }}%.
        </p>

        @if ($level_num == 1)
            <p style="margin-left:10px;">Penjelasan rinci terkait dengan atribut atau indikator untuk setiap aspek disajikan dalam Tabel 1.</p>
            <div class="text-right" style="margin-top:30px;">4</div>
            <div class="table-caption">Tabel 1. Pendetailan tingkat capaian atribut atau indikator untuk setiap aspek pada Level Katsinov 1.</div>
        @elseif ($level_num == 2)
            @if(isset($level_data['penjelasan_capaian_level_2_manufaktur_investment']))
                <p style="margin-left:10px;">{{ $level_data['penjelasan_capaian_level_2_manufaktur_investment'] }}</p>
            @endif
            @if(isset($level_data['penjelasan_capaian_level_2_lainnya']))
                <p style="margin-left:10px;">{{ $level_data['penjelasan_capaian_level_2_lainnya'] }}</p>
            @endif
            <div class="image-placeholder">Gambar 7. Ringkasan hasil pengukuran Katsinov 2.</div>
            <p style="margin-left:10px;">Penjelasan rinci terkait dengan atribut atau indikator untuk setiap aspek disajikan dalam Tabel 2.</p>
            <div class="text-right" style="margin-top:30px;">15</div>
            <div class="table-caption">Tabel 2. Pendetailan tingkat capaian atribut atau indikator untuk setiap aspek pada Level Katsinov 2.</div>
        @elseif ($level_num == 3)
            @if(isset($level_data['penjelasan_capaian_level_3']['above_80']) && !empty($level_data['penjelasan_capaian_level_3']['above_80']))
                <p style="margin-left:10px;">{{ $level_data['penjelasan_capaian_level_3']['above_80'] }}</p>
            @endif
            @if(isset($level_data['penjelasan_capaian_level_3']['below_80']) && !empty($level_data['penjelasan_capaian_level_3']['below_80']))
                <p style="margin-left:10px;">{{ $level_data['penjelasan_capaian_level_3']['below_80'] }}</p>
            @endif
            <div class="image-placeholder">Gambar 10. Ringkasan hasil pengukuran Katsinov 3.</div>
            <p style="margin-left:10px;">Penjelasan rinci terkait dengan atribut atau indikator untuk setiap aspek disajikan dalam Tabel 3.</p>
            <div class="text-right" style="margin-top:30px;">23</div>
            <div class="table-caption">Tabel 3. Pendetailan tingkat capaian atribut atau indikator untuk setiap aspek pada Level Katsinov 3.</div>
        @endif

        @php
            // Page numbers corresponding to the end of certain aspect tables in the source doc
            // This is a rough estimation for layout.
            $aspect_table_page_markers = [
                1 => ['Teknologi' => '', 'Pasar' => 5, 'Organisasi' => 6, 'Manufaktur' => 7, 'Partnership' => 8, 'Investment' => '', 'Risiko' => 9],
                2 => ['Teknologi' => '', 'Pasar' => 16, 'Organisasi' => '', 'Manufaktur' => '', 'Partnership' => 17, 'Investment' => '', 'Risiko' => 18],
                3 => ['Teknologi' => '', 'Pasar' => '', 'Organisasi' => '', 'Manufaktur' => 24, 'Partnership' => '', 'Investment' => 25, 'Risiko' => ''],
            ];
        @endphp

        @foreach ($level_data['aspek_scores'] as $aspek_nama => $aspek_skor)
            <table class="aspect-table">
                <tr><td colspan="2"><span class="bold">Aspek {{ $aspek_nama }}:</span></td></tr>
                <tr>
                    <td style="width:70%;">Capaian Atribut/ Indikator</td>
                    <td>Keterangan</td>
                </tr>
                {{-- These rows remain empty as per the "Empty" template --}}
                {{-- In a real scenario, you might loop through katsinov->responses for this level and aspect --}}
                <tr><td style="height: 20px;">&nbsp;</td><td>&nbsp;</td></tr>
                <tr><td style="height: 20px;">&nbsp;</td><td>&nbsp;</td></tr>
            </table>
            @if (!empty($aspect_table_page_markers[$level_num][$aspek_nama]))
                <div class="text-right">{{ $aspect_table_page_markers[$level_num][$aspek_nama] }}</div>
            @endif
        @endforeach

        {{-- Summary section for each level --}}
        @if ($level_num == 1)
            <div class="text-right" style="margin-top:20px;">13</div>
        @endif
         <div class="section-heading" style="font-size:10.5pt; margin-left:10px;">Summary Level Katsinov {{ $level_num }}:</div>
         @if ($level_num != 2) {{-- Level 2 summary doesn't repeat the description in the doc --}}
            <p class="level-summary" style="margin-left:10px;">{{ $level_data['level_deskripsi'] }}</p>
         @endif
         <p style="margin-left:10px;">Berikut ini summary terkait capaian dari 7 (tujuh) aspek:</p>
            <ol style="margin-left:10px;">
                <li>Aspek Teknologi</li>
                <li>Aspek Pasar</li>
                <li>Aspek Organisasi</li>
                <li>Aspek Investment</li>
                <li>Aspek Manufaktur</li>
                <li>Aspek Partnership</li>
                <li>Aspek Risiko</li>
            </ol>
        @if ($level_num == 1)
            <div class="text-right">14</div>
        @elseif ($level_num == 3)
            <div class="text-right">28</div>
            <div class="page-break"></div>
        @endif
    @endforeach


    <div class="section-heading">3. REKOMENDASI</div>
    <div class="section-heading" style="font-weight:normal; font-size:10.5pt; margin-left:10px;">A. Kesimpulan</div>
    <p style="min-height: 50px; margin-left:10px;"><i>(Bagian ini untuk kesimpulan hasil pengukuran)</i></p>

    <div class="section-heading" style="font-weight:normal; font-size:10.5pt; margin-left:10px;">B. Rekomendasi</div>
    <div class="text-right" style="margin-top:30px;">30</div>
    <div class="table-caption">Tabel 4. Rekomendasi teknis.</div>
    <table class="recommendation-table">
        <thead>
            <tr>
                <td style="width:5%; text-align:center;">No.</td>
                <td style="width:20%;">Aspek</td>
                <td colspan="3">Pihak Yang Diberikan Rekomendasi</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td style="border-right:none; width:2%"></td>
                <td style="border-left:none; border-right:none; font-weight:normal;"></td>
                <td style="border-left:none; width:50%; font-weight:bold;">PT. New Armada</td>
            </tr>
        </thead>
        <tbody>
            @foreach ($rekomendasi_teknis as $idx => $rek)
            <tr>
                <td style="text-align:center;">{{ $loop->iteration }}</td>
                <td>{{ $rek['aspek'] }}</td>
                <td style="border-right:none; text-align:center;">▪</td>
                <td style="border-left:none; border-right:none;">
                    @if (($rek['aspek'] == 'Organisasi' && $loop->iteration == 4) || ($rek['aspek'] == 'Organisasi' && $loop->iteration == 5))
                        {{-- No extra bullet for combined org recommendations --}}
                    @elseif (in_array($rek['aspek'], ['Teknologi','Pasar','Manufaktur','Partnership','Investment','Risiko']))
                        {{-- Default recommendations for these aspects might be single lines in the doc --}}
                    @endif
                </td>
                <td style="border-left:none;">{{ $rek['rekomendasi_new_armada'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="text-right">31</div>
    <div class="text-right">32</div>
    <div class="text-right">33</div>

    <div class="table-caption" style="margin-top:20px;">Tabel 5. Rekomendasi kebijakan.</div>
     <table class="recommendation-table">
        <thead>
            <tr>
                <td style="width:5%; text-align:center;">No.</td>
                <td style="width:50%;">Bentuk Rekomendasi Kebijakan/ Peraturan</td>
                <td>Lembaga Yang Bertanggung Jawab</td>
            </tr>
        </thead>
        <tbody>
            @foreach($rekomendasi_kebijakan as $idx => $keb)
            <tr>
                <td style="text-align:center;">{{ $loop->iteration }}.</td>
                <td>{{ $keb['bentuk_rekomendasi'] }}</td> {{-- This is empty in source doc --}}
                <td>{{ $keb['lembaga_bertanggung_jawab'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="text-right">34</div>
    <div class="text-right">35</div>

</body>
</html>