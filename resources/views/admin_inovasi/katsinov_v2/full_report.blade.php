@extends('admin_inovasi.index')

@section('contentadmin_inovasi')
<div class="container-fluid p-6">
    {{-- Header --}}
    <div class="mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="h3 mb-2">📋 Laporan Form Katsinov - {{ $katsinov->title }}</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin_inovasi.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin_inovasi.katsinov-v2.index') }}">KATSINOV V2</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin_inovasi.katsinov-v2.show', $katsinov->id) }}">Detail</a></li>
                        <li class="breadcrumb-item active">Laporan Form Katsinov</li>
                    </ol>
                </nav>
            </div>
            <div>
                <button onclick="window.print()" class="btn btn-primary me-2">
                    <i class='bx bx-printer'></i> Print Report
                </button>
                <a href="{{ route('admin_inovasi.katsinov-v2.show', $katsinov->id) }}" class="btn btn-secondary">
                    <i class='bx bx-arrow-back'></i> Back
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
                            <td>{{ $katsinov->title }}</td>
                        </tr>
                        <tr>
                            <th>Focus Area:</th>
                            <td>{{ $katsinov->focus_area }}</td>
                        </tr>
                        <tr>
                            <th>Institution:</th>
                            <td>{{ $katsinov->institution ?? 'Universitas Negeri Jakarta' }}</td>
                        </tr>
                        <tr>
                            <th>Pengusul:</th>
                            <td>{{ $katsinov->user->name ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-sm table-borderless">
                        <tr>
                            <th width="40%">Status:</th>
                            <td>
                                @php
                                    $statusBadge = match($katsinov->status) {
                                        'draft' => 'bg-secondary',
                                        'submitted' => 'bg-info',
                                        'assigned' => 'bg-warning',
                                        'in_review' => 'bg-primary',
                                        'completed' => 'bg-success',
                                        default => 'bg-secondary'
                                    };
                                @endphp
                                <span class="badge {{ $statusBadge }}">{{ ucfirst($katsinov->status) }}</span>
                            </td>
                        </tr>
                        <tr>
                            <th>Reviewer:</th>
                            <td>{{ $katsinov->reviewer->name ?? 'Belum ditugaskan' }}</td>
                        </tr>
                        <tr>
                            <th>Dibuat:</th>
                            <td>{{ \Carbon\Carbon::parse($katsinov->created_at)->format('d M Y, H:i') }}</td>
                        </tr>
                        <tr>
                            <th>Terakhir Update:</th>
                            <td>{{ \Carbon\Carbon::parse($katsinov->updated_at)->format('d M Y, H:i') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Form Utama: Main Assessment Responses --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-success text-white">
            <h4 class="m-0">📝 Form Utama: Penilaian KATSINOV</h4>
        </div>
        <div class="card-body">
            @php
                $indicatorTitles = [
                    1 => 'Basic Research & Technology Development',
                    2 => 'Technology Demonstration',
                    3 => 'Technology Refinement & Implementation',
                    4 => 'Market Introduction & Commercialization',
                    5 => 'Market Expansion & Support',
                    6 => 'Sustainable Market & Future Planning',
                ];
            @endphp

            @forelse($responsesByIndicator as $indicatorNum => $responses)
                <div class="mb-5 border rounded p-4 bg-light">
                    <h5 class="text-primary mb-3 pb-2 border-bottom">
                        <i class='bx bx-check-circle'></i> 
                        KATSINOV {{ $indicatorNum }}: {{ $indicatorTitles[$indicatorNum] }}
                    </h5>
                    
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover bg-white">
                            <thead class="table-secondary">
                                <tr>
                                    <th width="5%" class="text-center">No</th>
                                    <th width="8%" class="text-center">Aspek</th>
                                    <th width="10%" class="text-center">0</th>
                                    <th width="10%" class="text-center">1</th>
                                    <th width="10%" class="text-center">2</th>
                                    <th width="10%" class="text-center">3</th>
                                    <th width="10%" class="text-center">4</th>
                                    <th width="10%" class="text-center">5</th>
                                    <th width="27%">Deskripsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($responses as $response)
                                    @php
                                        $question = collect($allQuestions[$indicatorNum] ?? [])->firstWhere('no', $response->row_number);
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
                                    @endphp
                                    <tr>
                                        <td class="text-center align-middle">{{ $response->row_number }}</td>
                                        <td class="text-center align-middle">
                                            <span class="badge {{ $badgeClass }}">{{ $response->aspect }}</span>
                                        </td>
                                        @for($score = 0; $score <= 5; $score++)
                                            <td class="text-center align-middle">
                                                @if($response->score == $score)
                                                    <i class='bx bxs-circle text-success' style="font-size: 20px;"></i>
                                                @else
                                                    <i class='bx bx-circle text-muted' style="font-size: 20px;"></i>
                                                @endif
                                            </td>
                                        @endfor
                                        <td class="align-middle">{{ $questionText }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Note untuk Indikator --}}
                    @php
                        $note = $katsinov->notes->firstWhere('indicator_number', $indicatorNum);
                    @endphp
                    @if($note && $note->notes)
                        <div class="mt-3 p-3 bg-warning bg-opacity-10 border-start border-warning border-4 rounded">
                            <h6 class="text-warning mb-2">
                                <i class='bx bx-note'></i> Catatan KATSINOV {{ $indicatorNum }}
                            </h6>
                            <p class="mb-0 text-dark">{{ $note->notes }}</p>
                        </div>
                    @endif
                </div>
            @empty
                <div class="alert alert-warning">
                    <i class='bx bx-info-circle'></i> Belum ada data penilaian yang tersimpan.
                </div>
            @endforelse
        </div>
    </div>

    {{-- Form Judul Inovasi --}}
    @if($inovasiInfo)
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-info text-white">
            <h4 class="m-0">💡 Form Judul Inovasi</h4>
        </div>
        <div class="card-body">
            {{-- Title & Sub Title --}}
            <div class="mb-4">
                <h5 class="text-primary border-bottom pb-2">Judul & Sub Judul</h5>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <strong>Judul Inovasi:</strong>
                        <p class="mt-1 text-muted">{{ $inovasiInfo->title ?? '-' }}</p>
                    </div>
                    <div class="col-md-12 mb-3">
                        <strong>Sub Judul:</strong>
                        <p class="mt-1 text-muted">{{ $inovasiInfo->sub_title ?? '-' }}</p>
                    </div>
                </div>
            </div>

            {{-- Introduction --}}
            @if($inovasiInfo->introduction)
            <div class="mb-4">
                <h5 class="text-primary border-bottom pb-2">Pengantar / Latar Belakang</h5>
                <p class="text-justify">{{ $inovasiInfo->introduction }}</p>
            </div>
            @endif

            {{-- Tech Product --}}
            @if($inovasiInfo->tech_product)
            <div class="mb-4">
                <h5 class="text-primary border-bottom pb-2">Produk Teknologi</h5>
                <p class="text-justify">{{ $inovasiInfo->tech_product }}</p>
            </div>
            @endif

            {{-- Supremacy --}}
            @if($inovasiInfo->supremacy)
            <div class="mb-4">
                <h5 class="text-primary border-bottom pb-2">Keunggulan</h5>
                <p class="text-justify">{{ $inovasiInfo->supremacy }}</p>
            </div>
            @endif

            {{-- Patent --}}
            @if($inovasiInfo->patent)
            <div class="mb-4">
                <h5 class="text-primary border-bottom pb-2">Paten / Hak Kekayaan Intelektual</h5>
                <p class="text-justify">{{ $inovasiInfo->patent }}</p>
            </div>
            @endif

            {{-- Tech Preparation --}}
            @if($inovasiInfo->tech_preparation)
            <div class="mb-4">
                <h5 class="text-primary border-bottom pb-2">Kesiapan Teknologi</h5>
                <p class="text-justify">{{ $inovasiInfo->tech_preparation }}</p>
            </div>
            @endif

            {{-- Market Preparation --}}
            @if($inovasiInfo->market_preparation)
            <div class="mb-4">
                <h5 class="text-primary border-bottom pb-2">Kesiapan Pasar</h5>
                <p class="text-justify">{{ $inovasiInfo->market_preparation }}</p>
            </div>
            @endif

            {{-- Contact Information --}}
            <div class="mb-4">
                <h5 class="text-primary border-bottom pb-2">Informasi Kontak</h5>
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <th width="40%">Nama:</th>
                                <td>{{ $inovasiInfo->name ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Telepon:</th>
                                <td>{{ $inovasiInfo->phone ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Mobile:</th>
                                <td>{{ $inovasiInfo->mobile ?? '-' }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <th width="40%">Fax:</th>
                                <td>{{ $inovasiInfo->fax ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Email:</th>
                                <td>{{ $inovasiInfo->email ?? '-' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- Informasi Dasar --}}
    @if($informasi)
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-warning text-dark">
            <h4 class="m-0">📄 Informasi Dasar</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-sm table-borderless">
                        <tr>
                            <th width="40%">PIC:</th>
                            <td>{{ $informasi->pic ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Institusi:</th>
                            <td>{{ $informasi->institution ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Alamat:</th>
                            <td>{{ $informasi->address ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Telepon:</th>
                            <td>{{ $informasi->phone ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Fax:</th>
                            <td>{{ $informasi->fax ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-sm table-borderless">
                        <tr>
                            <th width="40%">Judul Inovasi:</th>
                            <td>{{ $informasi->innovation_title ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Nama Inovasi:</th>
                            <td>{{ $informasi->innovation_name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Jenis:</th>
                            <td>{{ $informasi->innovation_type ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Bidang:</th>
                            <td>{{ $informasi->innovation_field ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Durasi:</th>
                            <td>{{ $informasi->innovation_duration ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            
            @if($informasi->innovation_summary)
            <hr>
            <div class="mb-3">
                <strong>Ringkasan:</strong>
                <p class="mt-2">{{ $informasi->innovation_summary }}</p>
            </div>
            @endif
            
            @if($informasi->innovation_novelty)
            <div class="mb-3">
                <strong>Kebaruan:</strong>
                <p class="mt-2">{{ $informasi->innovation_novelty }}</p>
            </div>
            @endif
            
            @if($informasi->innovation_supremacy)
            <div class="mb-3">
                <strong>Keunggulan:</strong>
                <p class="mt-2">{{ $informasi->innovation_supremacy }}</p>
            </div>
            @endif
        </div>
    </div>
    @endif

    {{-- Lampiran --}}
    @if($lampiran && $lampiran->count() > 0)
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-secondary text-white">
            <h4 class="m-0">📎 Lampiran</h4>
        </div>
        <div class="card-body">
            @php
                $lampiranByAspek = $lampiran->groupBy('type');
                $aspekLabels = [
                    'aspek_teknologi' => '🔧 Aspek Teknologi',
                    'aspek_pasar' => '📊 Aspek Pasar',
                    'aspek_organisasi' => '👥 Aspek Organisasi',
                    'aspek_mitra' => '🤝 Aspek Kemitraan',
                    'aspek_manufaktur' => '🏭 Aspek Manufaktur',
                    'aspek_investasi' => '💰 Aspek Investasi',
                    'aspek_risiko' => '⚠️ Aspek Risiko',
                ];
                
                $categoryLabels = [
                    // Aspek Teknologi
                    'dokumen_perencanaan' => 'Dokumen Perencanaan',
                    'dokumen_pelaksanaan' => 'Dokumen Pelaksanaan',
                    'dokumen_publikasi' => 'Dokumen Publikasi',
                    
                    // Aspek Pasar
                    'penelitian_pasar' => 'Hasil Penelitian Pasar',
                    'identifkasi_segmen' => 'Identifikasi Segmen',
                    'perhitungan_kebutuhan' => 'Perhitungan Kebutuhan Investasi',
                    'estimasi_harga' => 'Estimasi Harga',
                    'identifikasi_kompetitor' => 'Identifikasi Kompetitor',
                    'model_bisnis' => 'Model Bisnis',
                    'posisioning_pasar' => 'Posisioning Pasar',
                    
                    // Aspek Organisasi
                    'strategi_inovasi' => 'Strategi Inovasi',
                    'sdm' => 'Sumber Daya Manusia',
                    'analisis_bisnis' => 'Analisis dan Rencana Bisnis',
                    'struktur_bisnis' => 'Struktur Bisnis',
                    
                    // Aspek Kemitraan
                    'mitra_potensial' => 'Daftar Mitra Potensial',
                    'kerjasama' => 'Kerjasama',
                    'pengelolaan_kerjasama' => 'Pengelolaan Kerjasama',
                    
                    // Aspek Manufaktur
                    'analisis_materil' => 'Analisis Awal Solusi Material',
                    'material_prototipe' => 'Material, Perkakas dan Alat Uji',
                    'analisis_biaya' => 'Analisis Rincian Biaya',
                    'proses_prosedur' => 'Proses dan Prosedur Manufaktur',
                    'jaminan_mutu' => 'Jaminan Mutu',
                    'lean_manufaktur' => 'Penerapan Lean Manufacturing',
                    
                    // Aspek Investasi
                    'pelanggan_pasar' => 'Analisis Pelanggan, Pasar dan Pesaing',
                    'mvp' => 'Market Value Proposition',
                    'kondisi_produk' => 'Estimasi Kondisi Akhir Produk',
                    'potensi_pasar' => 'Estimasi Potensi Pasar',
                    'ekspansi_pasar' => 'Estimasi Ekspansi Pasar',
                    
                    // Aspek Risiko
                    'kajian_teknologi' => 'Kajian Risiko Teknologi',
                    'kajian_pasar' => 'Kajian Risiko Pasar',
                    'kajian_organisasi' => 'Kajian Risiko Organisasi',
                ];
            @endphp
            
            @foreach($aspekLabels as $aspekKey => $aspekLabel)
                @if(isset($lampiranByAspek[$aspekKey]) && $lampiranByAspek[$aspekKey]->count() > 0)
                    <div class="mb-4">
                        <h5 class="text-primary border-bottom pb-2 mb-3">{{ $aspekLabel }}</h5>
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="35%">Kategori</th>
                                        <th width="40%">File</th>
                                        <th width="20%">Tanggal Upload</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($lampiranByAspek[$aspekKey] as $index => $item)
                                    <tr>
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td>{{ $categoryLabels[$item->category] ?? ucwords(str_replace('_', ' ', $item->category)) }}</td>
                                        <td>
                                            <a href="{{ url('admin_inovasi/katsinov-v2/' . $katsinov->id . '/lampiran/' . $item->id . '/preview') }}" 
                                               class="btn btn-sm btn-info me-1">
                                                <i class='bx bx-show'></i> Lihat
                                            </a>
                                            <a href="{{ Storage::url($item->path) }}" 
                                               download 
                                               class="btn btn-sm btn-primary">
                                                <i class='bx bx-download'></i> Unduh
                                            </a>
                                            <small class="text-muted ms-2">{{ basename($item->path) }}</small>
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y, H:i') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            @endforeach
            
            @if($lampiranByAspek->isEmpty())
                <div class="alert alert-info">
                    <i class='bx bx-info-circle'></i> Belum ada lampiran yang diupload.
                </div>
            @endif
        </div>
    </div>
    @endif

    {{-- Form Berita Acara --}}
    @if($beritaAcara)
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-dark text-white">
            <h4 class="m-0">📜 Form Berita Acara Penilaian</h4>
        </div>
        <div class="card-body">
            {{-- Date and Place Information --}}
            <div class="mb-4">
                <h5 class="text-primary border-bottom pb-2">Waktu & Tempat</h5>
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <th width="40%">Hari:</th>
                                <td>{{ $beritaAcara->day ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal:</th>
                                <td>{{ $beritaAcara->date ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Bulan:</th>
                                <td>{{ $beritaAcara->month ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Tahun:</th>
                                <td>{{ $beritaAcara->year ?? ($beritaAcara->yearfull ?? '-') }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <th width="40%">Tempat:</th>
                                <td>{{ $beritaAcara->place ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Surat Keputusan:</th>
                                <td>{{ $beritaAcara->decree ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal Pengesahan:</th>
                                <td>{{ $beritaAcara->sign_date ? \Carbon\Carbon::parse($beritaAcara->sign_date)->format('d M Y') : '-' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Innovation Details --}}
            <div class="mb-4">
                <h5 class="text-primary border-bottom pb-2">Detail Inovasi</h5>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <th width="20%">Judul Inovasi:</th>
                                <td>{{ $beritaAcara->title ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Jenis Inovasi:</th>
                                <td>{{ $beritaAcara->type ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Nilai TKI (Tingkat Kesiapan Inovasi):</th>
                                <td>
                                    <span class="badge bg-primary fs-6">{{ $beritaAcara->tki ?? '-' }}</span>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Assessment Team --}}
            <div class="mb-4">
                <h5 class="text-primary border-bottom pb-2">Tim Penilai</h5>
                <div class="table-responsive">
                    <table class="table table-sm table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th width="25%">Posisi</th>
                                <th width="25%">Nama</th>
                                <th width="25%">Tanda Tangan</th>
                                <th width="25%">PDF/Dokumen</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>Penanggung Jawab</strong></td>
                                <td>{{ $beritaAcara->penanggungjawab ?? '-' }}</td>
                                <td class="text-center">
                                    @if($beritaAcara->penanggungjawab_signature)
                                        <img src="{{ asset('storage/' . $beritaAcara->penanggungjawab_signature) }}" 
                                             alt="Signature" 
                                             style="max-width: 150px; max-height: 60px; border: 1px solid #ddd; padding: 5px;">
                                    @else
                                        <span class="text-muted">Belum TTD</span>
                                    @endif
                                </td>
                                <td>
                                    @if($beritaAcara->penanggungjawab_pdf)
                                        <a href="{{ asset('storage/' . $beritaAcara->penanggungjawab_pdf) }}" target="_blank" class="btn btn-sm btn-info">
                                            <i class='bx bx-file-pdf'></i> PDF
                                        </a>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Ketua Tim</strong></td>
                                <td>{{ $beritaAcara->ketua ?? '-' }}</td>
                                <td class="text-center">
                                    @if($beritaAcara->ketua_signature)
                                        <img src="{{ asset('storage/' . $beritaAcara->ketua_signature) }}" 
                                             alt="Signature" 
                                             style="max-width: 150px; max-height: 60px; border: 1px solid #ddd; padding: 5px;">
                                    @else
                                        <span class="text-muted">Belum TTD</span>
                                    @endif
                                </td>
                                <td>
                                    @if($beritaAcara->ketua_pdf)
                                        <a href="{{ asset('storage/' . $beritaAcara->ketua_pdf) }}" target="_blank" class="btn btn-sm btn-info">
                                            <i class='bx bx-file-pdf'></i> PDF
                                        </a>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Anggota 1</strong></td>
                                <td>{{ $beritaAcara->anggota1 ?? '-' }}</td>
                                <td class="text-center">
                                    @if($beritaAcara->anggota1_signature)
                                        <img src="{{ asset('storage/' . $beritaAcara->anggota1_signature) }}" 
                                             alt="Signature" 
                                             style="max-width: 150px; max-height: 60px; border: 1px solid #ddd; padding: 5px;">
                                    @else
                                        <span class="text-muted">Belum TTD</span>
                                    @endif
                                </td>
                                <td>
                                    @if($beritaAcara->anggota1_pdf)
                                        <a href="{{ asset('storage/' . $beritaAcara->anggota1_pdf) }}" target="_blank" class="btn btn-sm btn-info">
                                            <i class='bx bx-file-pdf'></i> PDF
                                        </a>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Anggota 2</strong></td>
                                <td>{{ $beritaAcara->anggota2 ?? '-' }}</td>
                                <td class="text-center">
                                    @if($beritaAcara->anggota2_signature)
                                        <img src="{{ asset('storage/' . $beritaAcara->anggota2_signature) }}" 
                                             alt="Signature" 
                                             style="max-width: 150px; max-height: 60px; border: 1px solid #ddd; padding: 5px;">
                                    @else
                                        <span class="text-muted">Belum TTD</span>
                                    @endif
                                </td>
                                <td>
                                    @if($beritaAcara->anggota2_pdf)
                                        <a href="{{ asset('storage/' . $beritaAcara->anggota2_pdf) }}" target="_blank" class="btn btn-sm btn-info">
                                            <i class='bx bx-file-pdf'></i> PDF
                                        </a>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            
            {{-- Opinion --}}
            @if($beritaAcara->opinion)
            <div class="mb-4">
                <h5 class="text-primary border-bottom pb-2">Opini Penilai</h5>
                <div class="alert alert-info">
                    <p class="mb-0 text-justify">{{ $beritaAcara->opinion }}</p>
                </div>
            </div>
            @endif
        </div>
    </div>
    @endif

    {{-- Record Hasil Pengukuran --}}
    @if($recordHasil)
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="m-0">📊 Record Hasil Pengukuran</h4>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <table class="table table-sm table-borderless">
                        <tr>
                            <th width="40%">Penanggung Jawab:</th>
                            <td>{{ $recordHasil->nama_penanggung_jawab ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Institusi:</th>
                            <td>{{ $recordHasil->institusi ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-sm table-borderless">
                        <tr>
                            <th width="40%">Tanggal Penilaian:</th>
                            <td>{{ $recordHasil->tanggal_penilaian ? \Carbon\Carbon::parse($recordHasil->tanggal_penilaian)->format('d M Y') : '-' }}</td>
                        </tr>
                        <tr>
                            <th>Kontak:</th>
                            <td>{{ $recordHasil->phone ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            
            <div class="table-responsive">
                <table class="table table-sm table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">No</th>
                            <th width="20%">Aspek</th>
                            <th width="25%">Aktivitas</th>
                            <th width="10%" class="text-center">Capaian</th>
                            <th width="20%">Keterangan</th>
                            <th width="20%">Catatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @for($i = 1; $i <= 5; $i++)
                        <tr>
                            <td class="text-center">{{ $i }}</td>
                            <td>{{ $recordHasil->{"aspek_$i"} ?? '-' }}</td>
                            <td>{{ $recordHasil->{"aktivitas_$i"} ?? '-' }}</td>
                            <td class="text-center">
                                <span class="badge bg-primary">{{ $recordHasil->{"capaian_$i"} ?? 0 }}</span>
                            </td>
                            <td>{{ $recordHasil->{"keterangan_$i"} ?? '-' }}</td>
                            <td>{{ $recordHasil->{"catatan_$i"} ?? '-' }}</td>
                        </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

    {{-- Notes from Reviewer --}}
    @if($katsinov->notes && $katsinov->notes->count() > 0)
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-danger text-white">
            <h4 class="m-0">💬 Catatan Reviewer</h4>
        </div>
        <div class="card-body">
            @foreach($katsinov->notes as $note)
            <div class="card mb-3 border-start border-danger border-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <strong>{{ $note->reviewer->name ?? 'Reviewer' }}</strong>
                            <small class="text-muted ms-2">{{ \Carbon\Carbon::parse($note->created_at)->format('d M Y, H:i') }}</small>
                        </div>
                        <span class="badge bg-info">Indicator {{ $note->indicator_number }}</span>
                    </div>
                    <p class="mb-0">{{ $note->note }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Action Buttons --}}
    <div class="card shadow-sm">
        <div class="card-body text-center">
            <button onclick="window.print()" class="btn btn-primary btn-lg me-2">
                <i class='bx bx-printer'></i> Print Laporan Form Katsinov
            </button>
            <a href="{{ route('admin_inovasi.katsinov-v2.show', $katsinov->id) }}" class="btn btn-secondary btn-lg">
                <i class='bx bx-arrow-back'></i> Back to Detail
            </a>
        </div>
    </div>
</div>

{{-- Print Styles --}}
<style>
    @media print {
        /* Hide UI elements */
        .btn, .breadcrumb, nav, .sidebar, .navbar, .d-flex.justify-content-between,
        aside, [x-data], .bg-gray-800, .fixed.inset-y-0, button, .sr-only {
            display: none !important;
        }
        
        /* Show only main content */
        .container-fluid {
            margin: 0 !important;
            padding: 0 !important;
            max-width: 100% !important;
        }
        
        /* Full width for print */
        body, html {
            width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
        }
        
        /* Adjust flex layout for print */
        .flex.h-screen, .flex-1.flex.flex-col {
            display: block !important;
            width: 100% !important;
        }
        
        /* Card styling for print */
        .card {
            page-break-inside: avoid;
            border: 1px solid #ddd !important;
            box-shadow: none !important;
            margin-bottom: 1rem !important;
        }
        
        /* Header colors for print */
        .card-header {
            background-color: #0d6efd !important;
            color: white !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
        
        .card-header.bg-primary {
            background-color: #0d6efd !important;
        }
        
        /* Badge colors for print */
        .badge {
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
        
        /* Table styling */
        table {
            width: 100% !important;
            font-size: 10pt;
        }
        
        th, td {
            padding: 0.4rem !important;
            border: 1px solid #dee2e6 !important;
        }
        
        /* Circle icons for radio buttons */
        .bx-circle, .bxs-circle {
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
        
        /* Note section */
        .border-warning {
            border-color: #ffc107 !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
        
        .bg-warning {
            background-color: #fff3cd !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
        
        /* Body font size */
        body {
            font-size: 11pt;
        }
        
        /* Page breaks */
        .card {
            page-break-after: auto;
        }
        
        h1, h2, h3, h4, h5 {
            page-break-after: avoid;
        }
        
        /* Print header */
        @page {
            margin: 1.5cm;
        }
    }
</style>
@endsection
