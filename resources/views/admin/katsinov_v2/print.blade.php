<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proposal Katsinov - {{ $katsinov->title }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Arial', sans-serif;
            font-size: 12pt;
            line-height: 1.6;
            color: #333;
            background: white;
            padding: 20mm;
        }
        
        @media print {
            body {
                padding: 15mm;
            }
            .page-break {
                page-break-after: always;
            }
            .no-print {
                display: none;
            }
        }
        
        .header {
            text-align: center;
            border-bottom: 3px solid #2563eb;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        
        .header h1 {
            font-size: 24pt;
            color: #1e40af;
            margin-bottom: 10px;
        }
        
        .header p {
            font-size: 14pt;
            color: #64748b;
        }
        
        .section {
            margin-bottom: 30px;
        }
        
        .section-title {
            font-size: 16pt;
            font-weight: bold;
            color: #1e40af;
            border-bottom: 2px solid #93c5fd;
            padding-bottom: 5px;
            margin-bottom: 15px;
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px 20px;
            margin-bottom: 15px;
        }
        
        .info-item {
            display: flex;
            padding: 8px 0;
        }
        
        .info-label {
            font-weight: bold;
            min-width: 150px;
            color: #475569;
        }
        
        .info-value {
            flex: 1;
            color: #1e293b;
        }
        
        .score-summary {
            background: #f1f5f9;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            border: 2px solid #cbd5e1;
        }
        
        .score-main {
            text-align: center;
            font-size: 48pt;
            font-weight: bold;
            color: #16a34a;
            margin-bottom: 10px;
        }
        
        .score-main.warning { color: #eab308; }
        .score-main.danger { color: #dc2626; }
        
        .score-status {
            text-align: center;
            font-size: 18pt;
            font-weight: bold;
            margin-bottom: 20px;
        }
        
        .indicators-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-bottom: 20px;
        }
        
        .indicator-card {
            border: 1px solid #cbd5e1;
            padding: 15px;
            border-radius: 6px;
            background: white;
        }
        
        .indicator-card h4 {
            font-size: 12pt;
            margin-bottom: 8px;
            color: #1e40af;
        }
        
        .indicator-score {
            font-size: 20pt;
            font-weight: bold;
            color: #16a34a;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 10pt;
        }
        
        table th {
            background: #1e40af;
            color: white;
            padding: 10px;
            text-align: left;
            font-weight: bold;
        }
        
        table td {
            padding: 8px 10px;
            border: 1px solid #cbd5e1;
        }
        
        table tr:nth-child(even) {
            background: #f8fafc;
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
        }
        
        .print-button:hover {
            background: #1d4ed8;
        }
        
        .status-badge {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 11pt;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        .status-draft { background: #fef3c7; color: #92400e; }
        .status-submitted { background: #dbeafe; color: #1e40af; }
        .status-assigned { background: #fce7f3; color: #9f1239; }
        .status-in_review { background: #e0e7ff; color: #3730a3; }
        .status-completed { background: #d1fae5; color: #065f46; }
        
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }
        .mb-10 { margin-bottom: 10px; }
        .mb-20 { margin-bottom: 20px; }
    </style>
</head>
<body>
    {{-- Print Button --}}
    <button class="print-button no-print" onclick="window.print()">🖨️ Print / Save PDF</button>

    {{-- Header --}}
    <div class="header">
        <h1>PROPOSAL PENILAIAN INOVASI</h1>
        <p>Tingkat Kesiapan Inovasi (TKI) - KATSINOV</p>
        <p style="margin-top: 10px;">
            <span class="status-badge status-{{ $katsinov->status }}">{{ ucfirst($katsinov->status) }}</span>
        </p>
    </div>

    {{-- Informasi Dasar --}}
    <div class="section">
        <div class="section-title">I. INFORMASI DASAR</div>
        
        <div class="info-grid">
            <div class="info-item">
                <span class="info-label">Judul Inovasi:</span>
                <span class="info-value">{{ $katsinov->title }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Fokus Bidang:</span>
                <span class="info-value">{{ $katsinov->focus_area }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Nama Proyek:</span>
                <span class="info-value">{{ $katsinov->project_name }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Institusi:</span>
                <span class="info-value">{{ $katsinov->institution }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Alamat:</span>
                <span class="info-value">{{ $katsinov->address }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Kontak:</span>
                <span class="info-value">{{ $katsinov->contact }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Tanggal Penilaian:</span>
                <span class="info-value">{{ $katsinov->assessment_date->format('d F Y') }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Pengusul:</span>
                <span class="info-value">{{ $katsinov->user->name }}</span>
            </div>
        </div>
    </div>

    <div class="page-break"></div>

    {{-- Summary Skor --}}
    <div class="section">
        <div class="section-title">II. RINGKASAN PENILAIAN</div>
        
        <div class="score-summary">
            <div class="score-main {{ $overallAverage >= 80 ? '' : ($overallAverage >= 60 ? 'warning' : 'danger') }}">
                {{ number_format($overallAverage, 2) }}%
            </div>
            <div class="score-status">
                Status Kelayakan: 
                @if($overallAverage >= 80)
                    <span style="color: #16a34a;">✓ LAYAK</span>
                @elseif($overallAverage >= 60)
                    <span style="color: #eab308;">⚠ CUKUP LAYAK</span>
                @else
                    <span style="color: #dc2626;">✗ TIDAK LAYAK</span>
                @endif
            </div>
            
            <div class="indicators-grid">
                @foreach($indicatorScores as $index => $data)
                <div class="indicator-card">
                    <h4>Indikator {{ $index }}</h4>
                    <div class="indicator-score" style="color: {{ $data['percentage'] >= 80 ? '#16a34a' : ($data['percentage'] >= 60 ? '#eab308' : '#dc2626') }}">
                        {{ number_format($data['percentage'], 1) }}%
                    </div>
                    <div style="font-size: 9pt; color: #64748b;">
                        {{ $data['score'] }} / {{ $data['total_rows'] * 5 }} poin
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Detail Informasi Inovasi --}}
    @if($informasi)
    <div class="section">
        <div class="section-title">III. DETAIL INFORMASI INOVASI</div>
        
        <table>
            <tr>
                <th width="30%">Aspek</th>
                <th>Keterangan</th>
            </tr>
            <tr>
                <td class="font-bold">Penanggung Jawab</td>
                <td>{{ $informasi->pic }}</td>
            </tr>
            <tr>
                <td class="font-bold">Nama Inovasi</td>
                <td>{{ $informasi->innovation_name }}</td>
            </tr>
            <tr>
                <td class="font-bold">Jenis Inovasi</td>
                <td>{{ $informasi->innovation_type }}</td>
            </tr>
            <tr>
                <td class="font-bold">Bidang Inovasi</td>
                <td>{{ $informasi->innovation_field }}</td>
            </tr>
            <tr>
                <td class="font-bold">Aplikasi</td>
                <td>{{ $informasi->innovation_application }}</td>
            </tr>
            <tr>
                <td class="font-bold">Durasi Pengembangan</td>
                <td>{{ $informasi->innovation_duration }}</td>
            </tr>
            <tr>
                <td class="font-bold">Tahun</td>
                <td>{{ $informasi->innovation_year }}</td>
            </tr>
            <tr>
                <td class="font-bold">Ringkasan</td>
                <td>{{ $informasi->innovation_summary }}</td>
            </tr>
            <tr>
                <td class="font-bold">Kebaruan</td>
                <td>{{ $informasi->innovation_novelty }}</td>
            </tr>
            <tr>
                <td class="font-bold">Keunggulan</td>
                <td>{{ $informasi->innovation_supremacy }}</td>
            </tr>
        </table>
    </div>
    @endif

    <div class="page-break"></div>

    {{-- Detail Inovasi dari Form Inovasi --}}
    @if($inovasi)
    <div class="section">
        <div class="section-title">IV. PRODUK DAN TEKNOLOGI INOVASI</div>
        
        <table>
            <tr>
                <th width="30%">Aspek</th>
                <th>Keterangan</th>
            </tr>
            <tr>
                <td class="font-bold">Judul</td>
                <td>{{ $inovasi->title }}</td>
            </tr>
            <tr>
                <td class="font-bold">Sub Judul</td>
                <td>{{ $inovasi->sub_title }}</td>
            </tr>
            <tr>
                <td class="font-bold">Pengenalan</td>
                <td>{{ $inovasi->introduction }}</td>
            </tr>
            <tr>
                <td class="font-bold">Produk Teknologi</td>
                <td>{{ $inovasi->tech_product }}</td>
            </tr>
            <tr>
                <td class="font-bold">Keunggulan</td>
                <td>{{ $inovasi->supremacy }}</td>
            </tr>
            <tr>
                <td class="font-bold">Paten</td>
                <td>{{ $inovasi->patent }}</td>
            </tr>
            <tr>
                <td class="font-bold">Kesiapan Teknologi</td>
                <td>{{ $inovasi->tech_preparation }}</td>
            </tr>
            <tr>
                <td class="font-bold">Kesiapan Pasar</td>
                <td>{{ $inovasi->market_preparation }}</td>
            </tr>
        </table>

        <div class="mb-20">
            <div class="font-bold mb-10">Kontak Person:</div>
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">Nama:</span>
                    <span class="info-value">{{ $inovasi->name }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Telepon:</span>
                    <span class="info-value">{{ $inovasi->phone }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Mobile:</span>
                    <span class="info-value">{{ $inovasi->mobile }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Fax:</span>
                    <span class="info-value">{{ $inovasi->fax }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Email:</span>
                    <span class="info-value">{{ $inovasi->email }}</span>
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="page-break"></div>

    {{-- Detail Penilaian Per Indikator --}}
    <div class="section">
        <div class="section-title">V. DETAIL PENILAIAN PER INDIKATOR</div>
        
        @php
            $indicators = [
                1 => ['data' => $indicatorOne, 'title' => 'Indikator 1'],
                2 => ['data' => $indicatorTwo, 'title' => 'Indikator 2'],
                3 => ['data' => $indicatorThree, 'title' => 'Indikator 3'],
                4 => ['data' => $indicatorFour, 'title' => 'Indikator 4'],
                5 => ['data' => $indicatorFive, 'title' => 'Indikator 5'],
                6 => ['data' => $indicatorSix, 'title' => 'Indikator 6'],
            ];
        @endphp
        
        @foreach($indicators as $index => $indicator)
            @if($indicator['data']->count() > 0)
                <h3 style="font-size: 14pt; color: #1e40af; margin: 20px 0 10px 0;">
                    {{ $indicator['title'] }} 
                    <span style="color: {{ $indicatorScores[$index]['percentage'] >= 80 ? '#16a34a' : ($indicatorScores[$index]['percentage'] >= 60 ? '#eab308' : '#dc2626') }}">
                        ({{ number_format($indicatorScores[$index]['percentage'], 1) }}%)
                    </span>
                </h3>
                
                <table>
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="10%">Aspek</th>
                            <th width="10%">Skor</th>
                            <th>Catatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($indicator['data'] as $response)
                        <tr>
                            <td class="text-center">{{ $response->row_number }}</td>
                            <td class="text-center font-bold">{{ $response->aspect }}</td>
                            <td class="text-center font-bold" style="color: {{ $response->score >= 4 ? '#16a34a' : ($response->score >= 3 ? '#eab308' : '#dc2626') }}">
                                {{ $response->score }}
                            </td>
                            <td>-</td>
                        </tr>
                        @endforeach
                    </tbody>
                    
                    {{-- Catatan Indikator (di bawah tabel) --}}
                    @php
                        $indicatorNote = $katsinov->notes()->where('indicator_number', $index)->first();
                    @endphp
                    @if($indicatorNote && $indicatorNote->notes)
                    <tfoot>
                        <tr>
                            <td colspan="4" style="background: #fef3c7; padding: 10px;">
                                <strong>Catatan Indikator {{ $index }}:</strong> {{ $indicatorNote->notes }}
                            </td>
                        </tr>
                    </tfoot>
                    @endif
                </table>
                
                @if($index < 6)
                    <div style="margin-bottom: 30px;"></div>
                @endif
            @endif
        @endforeach
    </div>

    <div class="page-break"></div>

    {{-- Berita Acara --}}
    @if($beritaAcara)
    <div class="section">
        <div class="section-title">VI. BERITA ACARA PENILAIAN</div>
        
        <div class="mb-20">
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">Hari/Tanggal:</span>
                    <span class="info-value">{{ $beritaAcara->hari }}, {{ $beritaAcara->tanggal }} {{ $beritaAcara->bulan }} {{ $beritaAcara->tahun }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Tempat:</span>
                    <span class="info-value">{{ $beritaAcara->tempat }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">No. Surat Keputusan:</span>
                    <span class="info-value">{{ $beritaAcara->surat_keputusan }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Nilai TKI:</span>
                    <span class="info-value font-bold" style="color: #1e40af;">{{ $beritaAcara->nilai_tki }}</span>
                </div>
            </div>
        </div>

        <div class="mb-20">
            <div class="font-bold mb-10">Opini Penilai:</div>
            <div style="padding: 15px; background: #f8fafc; border-left: 4px solid #3b82f6; border-radius: 4px;">
                {{ $beritaAcara->opini_penilai }}
            </div>
        </div>

        <div class="mb-20">
            <div class="font-bold mb-10">Tim Penilai:</div>
            <table>
                <tr>
                    <th>Jabatan</th>
                    <th>Nama</th>
                </tr>
                <tr>
                    <td class="font-bold">Penanggung Jawab</td>
                    <td>{{ $beritaAcara->nama_penanggungjawab }}</td>
                </tr>
                <tr>
                    <td class="font-bold">Ketua Tim</td>
                    <td>{{ $beritaAcara->nama_ketua_tim }}</td>
                </tr>
                <tr>
                    <td class="font-bold">Anggota 1</td>
                    <td>{{ $beritaAcara->nama_anggota1 }}</td>
                </tr>
                <tr>
                    <td class="font-bold">Anggota 2</td>
                    <td>{{ $beritaAcara->nama_anggota2 }}</td>
                </tr>
            </table>
        </div>

        <div class="text-right">
            <p>{{ $beritaAcara->tempat }}, {{ \Carbon\Carbon::parse($beritaAcara->tanggal_penutupan)->format('d F Y') }}</p>
        </div>
    </div>
    @endif

    {{-- Record Hasil --}}
    @if($recordHasil)
    <div class="page-break"></div>
    <div class="section">
        <div class="section-title">VII. RECORD HASIL PENGUKURAN</div>
        
        <table>
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="15%">Aspek</th>
                    <th width="20%">Aktivitas</th>
                    <th width="10%">Capaian</th>
                    <th width="20%">Keterangan</th>
                    <th>Catatan</th>
                </tr>
            </thead>
            <tbody>
                @for($i = 1; $i <= 5; $i++)
                <tr>
                    <td class="text-center">{{ $i }}</td>
                    <td>{{ $recordHasil->{'aspek_'.$i} }}</td>
                    <td>{{ $recordHasil->{'aktivitas_'.$i} }}</td>
                    <td class="text-center font-bold" style="color: {{ $recordHasil->{'capaian_'.$i} >= 80 ? '#16a34a' : ($recordHasil->{'capaian_'.$i} >= 60 ? '#eab308' : '#dc2626') }}">
                        {{ $recordHasil->{'capaian_'.$i} }}%
                    </td>
                    <td>{{ $recordHasil->{'keterangan_'.$i} }}</td>
                    <td>{{ $recordHasil->{'catatan_'.$i} ?? '-' }}</td>
                </tr>
                @endfor
            </tbody>
        </table>
    </div>
    @endif

    {{-- Lampiran --}}
    @if($lampiran->count() > 0)
    <div class="page-break"></div>
    <div class="section">
        <div class="section-title">VIII. DAFTAR LAMPIRAN</div>
        
        <table>
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="20%">Tipe</th>
                    <th width="25%">Kategori</th>
                    <th>Nama File</th>
                </tr>
            </thead>
            <tbody>
                @foreach($lampiran as $index => $file)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ ucfirst(str_replace('_', ' ', $file->type)) }}</td>
                    <td>{{ ucfirst(str_replace('_', ' ', $file->category)) }}</td>
                    <td>{{ $file->file_name }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    {{-- Footer --}}
    <div style="margin-top: 50px; padding-top: 20px; border-top: 2px solid #cbd5e1; text-align: center; color: #64748b; font-size: 10pt;">
        <p>Dokumen ini digenerate secara otomatis dari Sistem KATSINOV</p>
        <p>Tanggal Generate: {{ now()->format('d F Y H:i') }} WIB</p>
        <p>ID Dokumen: KATSINOV-{{ $katsinov->id }}-{{ now()->format('YmdHis') }}</p>
    </div>
</body>
</html>
