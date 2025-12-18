@extends('admin_inovasi.index')

@section('title', 'Laporan Lengkap Penilaian Validator')

@section('contentadmin_inovasi')
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

<div class="container-fluid p-6">
    {{-- Header --}}
    <div class="mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="h3 mb-2">📋 Laporan Lengkap Penilaian Validator</h1>
                <p class="text-muted">{{ $form->title }}</p>
            </div>
            <div>
                <button onclick="window.print()" class="btn btn-primary me-2">
                    <i class='bx bx-printer'></i> Print Report
                </button>
                <a href="{{ route('admin_inovasi.katsinov-v2.index') }}" class="btn btn-secondary">
                    <i class='bx bx-arrow-back'></i> Kembali
                </a>
            </div>
        </div>
    </div>

    {{-- Project Info Card --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="m-0">📌 Informasi Proyek</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-sm table-borderless">
                        <tr>
                            <th width="40%">Judul Proyek:</th>
                            <td>{{ $form->title }}</td>
                        </tr>
                        <tr>
                            <th>Focus Area:</th>
                            <td>{{ $form->focus_area }}</td>
                        </tr>
                        <tr>
                            <th>Institution:</th>
                            <td>{{ $form->institution ?? 'Universitas Negeri Jakarta' }}</td>
                        </tr>
                        <tr>
                            <th>Pengusul (Dosen):</th>
                            <td>{{ $form->user->name ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-sm table-borderless">
                        <tr>
                            <th width="40%">Status:</th>
                            <td>
                                @php
                                    $statusBadge = match($form->status) {
                                        'draft' => 'bg-secondary',
                                        'submitted' => 'bg-info',
                                        'assigned' => 'bg-warning',
                                        'under_review' => 'bg-primary',
                                        'completed' => 'bg-success',
                                        default => 'bg-secondary'
                                    };
                                @endphp
                                <span class="badge {{ $statusBadge }}">{{ ucfirst($form->status) }}</span>
                            </td>
                        </tr>
                        <tr>
                            <th>Validator:</th>
                            <td>{{ $form->reviewer->name ?? 'Belum ditugaskan' }}</td>
                        </tr>
                        <tr>
                            <th>Dibuat:</th>
                            <td>{{ \Carbon\Carbon::parse($form->created_at)->format('d M Y, H:i') }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Penilaian:</th>
                            <td>
                                @if($validatorRecord && $validatorRecord->tanggal_penilaian)
                                    {{ \Carbon\Carbon::parse($validatorRecord->tanggal_penilaian)->format('d M Y') }}
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Persetujuan Validator --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-success text-white">
            <h4 class="m-0">✅ Persetujuan Validator</h4>
        </div>
        <div class="card-body">
            @if($form->validator_agreement_signature)
                <div class="alert alert-success mb-3">
                    <i class='bx bx-check-circle'></i>
                    <strong>Persetujuan sudah ditandatangani</strong> pada
                    {{ $form->validator_agreement_date ? \Carbon\Carbon::parse($form->validator_agreement_date)->format('d/m/Y H:i') : '-' }}
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Pernyataan Persetujuan:</label>
                    <div class="p-3 bg-light border rounded">
                        <p class="mb-0">
                            <i class='bx bx-info-circle text-info'></i>
                            Saya setuju untuk melakukan penilaian secara objektif dan sesuai dengan kriteria yang telah ditetapkan
                        </p>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Tanda Tangan Digital:</label>
                    <div class="border rounded p-3 bg-light">
                        <img src="{{ $form->validator_agreement_signature }}" alt="Signature"
                            style="max-width: 400px; height: auto; border: 1px solid #ddd;">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Nama Validator:</label>
                        <p>{{ $form->reviewer->name ?? '-' }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Tanggal Persetujuan:</label>
                        <p>{{ $form->validator_agreement_date ? \Carbon\Carbon::parse($form->validator_agreement_date)->format('d F Y, H:i') : '-' }}</p>
                    </div>
                </div>
            @else
                <div class="alert alert-warning">
                    <i class='bx bx-info-circle'></i> Persetujuan belum ditandatangani oleh validator.
                </div>
            @endif
        </div>
    </div>

    {{-- Penilaian KATSINOV --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-info text-white">
            <h4 class="m-0">⭐ Penilaian KATSINOV</h4>
        </div>
        <div class="card-body">
            @php
                $indicatorTitles = [
                    1 => 'KATSINOV 1: Basic Research & Technology Development',
                    2 => 'KATSINOV 2: Technology Demonstration',
                    3 => 'KATSINOV 3: Technology Refinement & Implementation',
                    4 => 'KATSINOV 4: Market Introduction & Commercialization',
                    5 => 'KATSINOV 5: Market Expansion & Support',
                    6 => 'KATSINOV 6: Sustainable Market & Future Planning',
                ];
            @endphp

            @forelse($categories as $index => $category)
                @php
                    $irlNumber = (int) str_replace(['IRL', 'K'], '', $category->code);
                    $categoryResponses = $assessments->get($irlNumber, collect());
                    $categoryComment = $categoryComments[$irlNumber]->notes ?? '';
                @endphp

                @if($categoryResponses->count() > 0)
                <div class="mb-5 border rounded p-4 bg-light">
                    <h5 class="text-primary mb-3 pb-2 border-bottom">
                        <i class='bx bx-check-circle'></i> 
                        {{ $category->code }}: {{ $category->name }}
                    </h5>
                    <p class="text-muted mb-3">{{ $category->description }}</p>
                    
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover bg-white">
                            <thead class="table-secondary">
                                <tr>
                                    <th width="5%" class="text-center">No</th>
                                    <th width="8%" class="text-center">Aspek</th>
                                    <th width="50%">Deskripsi Indikator</th>
                                    <th width="12%" class="text-center">Nilai Dosen</th>
                                    <th width="12%" class="text-center">Rating Validator</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($categoryResponses as $response)
                                    @php
                                        $question = collect($allQuestions[$irlNumber] ?? [])->firstWhere('no', $response->row_number);
                                        $questionText = $question['desc'] ?? 'Pertanyaan tidak ditemukan';
                                        $aspectColors = [
                                            'T' => 'bg-warning',
                                            'M' => 'bg-danger',
                                            'O' => 'bg-primary',
                                            'Mf' => 'bg-secondary',
                                            'P' => 'bg-info',
                                            'I' => 'bg-success',
                                            'R' => 'bg-dark',
                                        ];
                                        $badgeClass = $aspectColors[$response->aspect] ?? 'bg-secondary';
                                        
                                        // Convert dropdown value to score
                                        $dropdownMap = [
                                            'A' => 0,
                                            'B' => 1,
                                            'C' => 2,
                                            'D' => 3,
                                            'E' => 4,
                                            'F' => 5,
                                        ];
                                        $validatorScore = $response->dropdown_value ? ($dropdownMap[$response->dropdown_value] ?? '-') : '-';
                                    @endphp
                                    <tr>
                                        <td class="text-center align-middle">{{ $response->row_number }}</td>
                                        <td class="text-center align-middle">
                                            <span class="badge {{ $badgeClass }}">{{ $response->aspect }}</span>
                                        </td>
                                        <td class="align-middle">{{ $questionText }}</td>
                                        <td class="text-center align-middle">
                                            <span class="badge bg-primary" style="font-size: 16px;">{{ $response->score }}</span>
                                        </td>
                                        <td class="text-center align-middle">
                                            @if($validatorScore !== '-')
                                                <span class="badge bg-success" style="font-size: 16px;">{{ $validatorScore }}</span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if($categoryComment)
                    <div class="mt-3 p-3 bg-warning bg-opacity-10 border-start border-warning border-4">
                        <h6 class="fw-bold mb-2"><i class='bx bx-comment-detail'></i> Komentar Validator:</h6>
                        <p class="mb-0">{{ $categoryComment }}</p>
                    </div>
                    @endif
                </div>
                @endif
            @empty
                <div class="alert alert-warning">
                    <i class='bx bx-info-circle'></i> Belum ada data penilaian validator.
                </div>
            @endforelse
        </div>
    </div>

    {{-- Berita Acara --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-warning text-dark">
            <h4 class="m-0">📝 Berita Acara Pengukuran Tingkat Kesiapan Inovasi (KATSINOV)</h4>
        </div>
        <div class="card-body">
            @if($beritaAcara)
                {{-- Konteks Berita Acara --}}
                <div class="mb-4 p-4 bg-light border rounded">
                    <h5 class="mb-3 text-primary"><strong>Konteks Berita Acara</strong></h5>
                    <p class="mb-2">
                        Pada hari <strong>{{ $beritaAcara->day ?? '-' }}</strong>, 
                        tanggal <strong>{{ $beritaAcara->date ?? '-' }}</strong>, 
                        bulan <strong>{{ $beritaAcara->month ?? '-' }}</strong>, 
                        tahun <strong>{{ $beritaAcara->year ?? '-' }}</strong> (<strong>{{ $beritaAcara->yearfull ?? '-' }}</strong>),
                    </p>
                    <p class="mb-2">
                        bertempat di <strong>{{ $beritaAcara->place ?? '-' }}</strong>,
                    </p>
                    <p class="mb-0">
                        dari hasil pengukuran Tingkat Kesiapan Inovasi (KATSINOV) yang dilakukan oleh Tim yang dibentuk
                        berdasarkan Surat Keputusan <strong>{{ $beritaAcara->decree ?? '-' }}</strong> menyatakan:
                    </p>
                </div>

                {{-- Informasi Inovasi --}}
                <div class="mb-4">
                    <h5 class="mb-3 text-primary border-bottom pb-2"><strong>Informasi Inovasi</strong></h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Judul Inovasi:</label>
                            <p class="mb-0">{{ $beritaAcara->title ?? '-' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Jenis Inovasi:</label>
                            <p class="mb-0">{{ $beritaAcara->type ?? '-' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Nilai TKI (Tingkat Kesiapan Inovasi):</label>
                            <p class="mb-0">
                                <span class="badge bg-success" style="font-size: 16px;">{{ $beritaAcara->tki ?? '-' }}</span>
                            </p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Tanggal Ditandatangani:</label>
                            <p class="mb-0">
                                {{ $beritaAcara->sign_date ? \Carbon\Carbon::parse($beritaAcara->sign_date)->format('d F Y') : '-' }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Opini Penilai --}}
                <div class="mb-4 p-3 bg-info bg-opacity-10 border-start border-info border-4">
                    <h6 class="fw-bold mb-2"><i class='bx bx-comment-dots'></i> Opini Penilai:</h6>
                    <p class="mb-0" style="white-space: pre-wrap;">{{ $beritaAcara->opinion ?? '-' }}</p>
                </div>

                {{-- Penutup --}}
                <div class="mb-4 p-3 bg-light border rounded">
                    <p class="mb-0 fst-italic">
                        Demikian Berita Acara Pengukuran Tingkat Kesiapan Inovasi (KATSINOV) ini dibuat dengan sebenar-benarnya,
                        kemudian ditutup dan ditandatangani pada 
                        <strong>{{ $beritaAcara->sign_date ? \Carbon\Carbon::parse($beritaAcara->sign_date)->format('d F Y') : '-' }}</strong>
                        pada hari dan tanggal, bulan, tahun tersebut di atas.
                    </p>
                </div>

                {{-- Tanda Tangan --}}
                <h5 class="mb-3 mt-4 text-primary border-bottom pb-2"><strong>Tanda Tangan</strong></h5>
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card border-primary">
                            <div class="card-header bg-primary text-white">
                                <h6 class="mb-0"><strong>Penanggungjawab Inovasi</strong></h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Nama:</label>
                                    <p class="mb-0">{{ $beritaAcara->penanggungjawab ?? '-' }}</p>
                                </div>
                                @if($beritaAcara->penanggungjawab_pdf)
                                    <div class="mb-2">
                                        <label class="form-label fw-bold">Tanda Tangan (PDF):</label>
                                        <div>
                                            <a href="{{ route('validator.berita-acara.signature.view', ['formId' => $form->id, 'type' => 'penanggungjawab']) }}"
                                               target="_blank" class="btn btn-sm btn-success">
                                                <i class='bx bx-file-pdf'></i> Lihat PDF Tanda Tangan
                                            </a>
                                        </div>
                                    </div>
                                @else
                                    <p class="text-muted"><small>Tanda tangan belum diunggah</small></p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card border-success">
                            <div class="card-header bg-success text-white">
                                <h6 class="mb-0"><strong>Tim Penilai</strong></h6>
                            </div>
                            <div class="card-body">
                                {{-- Ketua --}}
                                <div class="mb-3 pb-3 border-bottom">
                                    <label class="form-label fw-bold text-success">Ketua Tim Penilai:</label>
                                    <p class="mb-1">{{ $beritaAcara->ketua ?? '-' }}</p>
                                    @if($beritaAcara->ketua_pdf)
                                        <a href="{{ route('validator.berita-acara.signature.view', ['formId' => $form->id, 'type' => 'ketua']) }}"
                                           target="_blank" class="btn btn-sm btn-outline-success">
                                            <i class='bx bx-file-pdf'></i> Lihat PDF
                                        </a>
                                    @else
                                        <p class="text-muted mb-0"><small>Tanda tangan belum diunggah</small></p>
                                    @endif
                                </div>

                                {{-- Anggota 1 --}}
                                <div class="mb-3 pb-3 border-bottom">
                                    <label class="form-label fw-bold text-success">Anggota 1:</label>
                                    <p class="mb-1">{{ $beritaAcara->anggota1 ?? '-' }}</p>
                                    @if($beritaAcara->anggota1_pdf)
                                        <a href="{{ route('validator.berita-acara.signature.view', ['formId' => $form->id, 'type' => 'anggota1']) }}"
                                           target="_blank" class="btn btn-sm btn-outline-success">
                                            <i class='bx bx-file-pdf'></i> Lihat PDF
                                        </a>
                                    @else
                                        <p class="text-muted mb-0"><small>Tanda tangan belum diunggah</small></p>
                                    @endif
                                </div>

                                {{-- Anggota 2 --}}
                                <div class="mb-3">
                                    <label class="form-label fw-bold text-success">Anggota 2:</label>
                                    <p class="mb-1">{{ $beritaAcara->anggota2 ?? '-' }}</p>
                                    @if($beritaAcara->anggota2_pdf)
                                        <a href="{{ route('validator.berita-acara.signature.view', ['formId' => $form->id, 'type' => 'anggota2']) }}"
                                           target="_blank" class="btn btn-sm btn-outline-success">
                                            <i class='bx bx-file-pdf'></i> Lihat PDF
                                        </a>
                                    @else
                                        <p class="text-muted mb-0"><small>Tanda tangan belum diunggah</small></p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="alert alert-info">
                    <i class='bx bx-info-circle'></i> Berita Acara belum diisi oleh validator.
                </div>
            @endif
        </div>
    </div>

    {{-- Record Hasil Pengukuran --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-secondary text-white">
            <h4 class="m-0">📊 Record Hasil Pengukuran</h4>
        </div>
        <div class="card-body">
            @if($validatorRecord)
                {{-- Header Information --}}
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Penanggung Jawab:</label>
                            <p class="mb-0">{{ $validatorRecord->nama_penanggung_jawab ?? '-' }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Institusi:</label>
                            <p class="mb-0">{{ $validatorRecord->institusi ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Judul Inovasi:</label>
                            <p class="mb-0">{{ $validatorRecord->judul_inovasi ?? '-' }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Jenis Inovasi:</label>
                            <p class="mb-0">{{ $validatorRecord->jenis_inovasi ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Alamat Kontak:</label>
                            <p class="mb-0">{{ $validatorRecord->alamat_kontak ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Telepon:</label>
                            <p class="mb-0">{{ $validatorRecord->phone ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Fax:</label>
                            <p class="mb-0">{{ $validatorRecord->fax ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Tanggal Penilaian:</label>
                            <p class="mb-0">
                                {{ $validatorRecord->tanggal_penilaian ? \Carbon\Carbon::parse($validatorRecord->tanggal_penilaian)->format('d F Y') : '-' }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Detail Penilaian Table --}}
                <h5 class="mb-3 mt-4 border-bottom pb-2">Detail Penilaian</h5>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th width="5%" class="text-center">No</th>
                                <th width="20%">Aspek</th>
                                <th width="25%">Aktivitas</th>
                                <th width="10%" class="text-center">Capaian</th>
                                <th width="20%">Keterangan</th>
                                <th width="20%">Catatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $hasData = false;
                                for ($i = 1; $i <= 5; $i++) {
                                    if (!empty($validatorRecord->{"aspek_$i"})) {
                                        $hasData = true;
                                        break;
                                    }
                                }
                            @endphp
                            
                            @if($hasData)
                                @for ($i = 1; $i <= 5; $i++)
                                    @if (!empty($validatorRecord->{"aspek_$i"}))
                                        <tr>
                                            <td class="text-center align-middle">{{ $i }}</td>
                                            <td class="align-middle">{{ $validatorRecord->{"aspek_$i"} ?? '-' }}</td>
                                            <td class="align-middle">{{ $validatorRecord->{"aktivitas_$i"} ?? '-' }}</td>
                                            <td class="text-center align-middle">
                                                <span class="badge bg-primary" style="font-size: 14px;">
                                                    {{ $validatorRecord->{"capaian_$i"} ?? '-' }}
                                                </span>
                                            </td>
                                            <td class="align-middle">{{ $validatorRecord->{"keterangan_$i"} ?? '-' }}</td>
                                            <td class="align-middle">{{ $validatorRecord->{"catatan_$i"} ?? '-' }}</td>
                                        </tr>
                                    @endif
                                @endfor
                            @else
                                <tr>
                                    <td colspan="6" class="text-center text-muted">Tidak ada data detail penilaian</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-info">
                    <i class='bx bx-info-circle'></i> Record Hasil Pengukuran belum diisi oleh validator.
                </div>
            @endif
        </div>
    </div>

    {{-- Action Buttons --}}
    <div class="card shadow-sm">
        <div class="card-body text-center">
            <button onclick="window.print()" class="btn btn-primary btn-lg me-2">
                <i class='bx bx-printer'></i> Print Laporan Validator
            </button>
            <a href="{{ route('admin_inovasi.katsinov-v2.index') }}" class="btn btn-secondary btn-lg">
                <i class='bx bx-arrow-back'></i> Kembali ke Daftar
            </a>
        </div>
    </div>
</div>

{{-- Print Styles --}}
<style>
    @media print {
        /* Hide navigation and buttons */
        .btn, 
        button,
        .breadcrumb, 
        nav.navbar,
        .sidebar,
        aside,
        header,
        footer,
        .fixed,
        [class*="fixed-"],
        [class*="sticky-"],
        .phpdebugbar,
        .phpdebugbar-openhandler,
        .phpdebugbar-body,
        div[class*="phpdebugbar"],
        .navbar,
        .navbar-brand,
        .nav,
        .navigation,
        [class*="sidebar"],
        [class*="menu"],
        .dropdown,
        .dropdown-menu,
        time,
        [datetime],
        .date-display,
        .timestamp {
            display: none !important;
        }
        
        /* Show main content */
        body {
            margin: 0 !important;
            padding: 0 !important;
            background: white !important;
            color: black !important;
            font-size: 11pt;
        }
        
        .container-fluid {
            margin: 0 !important;
            padding: 15px !important;
            max-width: 100% !important;
            width: 100% !important;
        }
        
        /* Ensure cards are visible */
        .card {
            page-break-inside: avoid;
            border: 1px solid #ddd !important;
            box-shadow: none !important;
            margin-bottom: 1rem !important;
            background: white !important;
            display: block !important;
            visibility: visible !important;
        }
        
        .card-body {
            padding: 15px !important;
            display: block !important;
            visibility: visible !important;
        }
        
        /* Header colors for print */
        .card-header {
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
            padding: 10px 15px !important;
            display: block !important;
            visibility: visible !important;
        }
        
        .card-header.bg-primary {
            background-color: #0d6efd !important;
            color: white !important;
        }
        
        .card-header.bg-success {
            background-color: #198754 !important;
            color: white !important;
        }
        
        .card-header.bg-warning {
            background-color: #ffc107 !important;
            color: black !important;
        }
        
        .card-header.bg-info {
            background-color: #0dcaf0 !important;
            color: white !important;
        }
        
        .card-header.bg-secondary {
            background-color: #6c757d !important;
            color: white !important;
        }
        
        /* Badge colors for print */
        .badge {
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
            display: inline-block !important;
            padding: 0.25em 0.6em !important;
            border: 1px solid #ddd !important;
        }
        
        .badge.bg-primary {
            background-color: #0d6efd !important;
            color: white !important;
        }
        
        .badge.bg-success {
            background-color: #198754 !important;
            color: white !important;
        }
        
        .badge.bg-warning {
            background-color: #ffc107 !important;
            color: black !important;
        }
        
        .badge.bg-danger {
            background-color: #dc3545 !important;
            color: white !important;
        }
        
        .badge.bg-info {
            background-color: #0dcaf0 !important;
            color: black !important;
        }
        
        .badge.bg-secondary {
            background-color: #6c757d !important;
            color: white !important;
        }
        
        .badge.bg-dark {
            background-color: #212529 !important;
            color: white !important;
        }
        
        /* Table styling */
        table {
            width: 100% !important;
            font-size: 9pt;
            border-collapse: collapse !important;
            display: table !important;
            visibility: visible !important;
        }
        
        th, td {
            padding: 0.4rem !important;
            border: 1px solid #dee2e6 !important;
            display: table-cell !important;
            visibility: visible !important;
        }
        
        thead {
            display: table-header-group !important;
        }
        
        tbody {
            display: table-row-group !important;
        }
        
        tr {
            display: table-row !important;
            page-break-inside: avoid;
        }
        
        /* Text and content */
        p, div, span, h1, h2, h3, h4, h5, h6, label {
            display: block !important;
            visibility: visible !important;
            color: black !important;
        }
        
        span {
            display: inline !important;
        }
        
        /* Background colors */
        .bg-light {
            background-color: #f8f9fa !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
        
        .bg-info.bg-opacity-10 {
            background-color: rgba(13, 202, 240, 0.1) !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
        
        .bg-warning.bg-opacity-10 {
            background-color: rgba(255, 193, 7, 0.1) !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
        
        /* Borders */
        .border,
        .border-start,
        .border-bottom,
        .border-primary,
        .border-success,
        .border-warning,
        .border-info {
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
        
        .border-start.border-info.border-4 {
            border-left: 4px solid #0dcaf0 !important;
        }
        
        .border-start.border-warning.border-4 {
            border-left: 4px solid #ffc107 !important;
        }
        
        /* Images */
        img {
            max-width: 100% !important;
            height: auto !important;
            display: block !important;
            visibility: visible !important;
        }
        
        /* Page breaks */
        h1, h2, h3, h4, h5 {
            page-break-after: avoid;
        }
        
        /* Alert boxes */
        .alert {
            display: block !important;
            visibility: visible !important;
            padding: 10px !important;
            border: 1px solid #ddd !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
        
        .alert-success {
            background-color: #d1e7dd !important;
            border-color: #badbcc !important;
            color: #0f5132 !important;
        }
        
        .alert-info {
            background-color: #cff4fc !important;
            border-color: #b6effb !important;
            color: #055160 !important;
        }
        
        .alert-warning {
            background-color: #fff3cd !important;
            border-color: #ffecb5 !important;
            color: #664d03 !important;
        }
        
        /* Row and column layout */
        .row {
            display: flex !important;
            flex-wrap: wrap !important;
            visibility: visible !important;
        }
        
        .col-md-6,
        .col-md-4,
        .col-md-12 {
            display: block !important;
            visibility: visible !important;
            flex: 0 0 auto !important;
        }
        
        .col-md-6 {
            width: 50% !important;
        }
        
        .col-md-4 {
            width: 33.333% !important;
        }
        
        .col-md-12 {
            width: 100% !important;
        }
        
        /* Page settings */
        @page {
            margin: 1.5cm;
            size: A4;
        }
        
        /* Remove browser-generated headers and footers */
        @page {
            margin-top: 1.5cm;
            margin-bottom: 1.5cm;
            margin-left: 1.5cm;
            margin-right: 1.5cm;
        }
    }
</style>
@endsection
