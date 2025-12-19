@extends('validator.layout')

@section('title', 'Penilaian Validator V2')

@section('contentvalidator')
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        .validator-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
        }

        .header-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            border-radius: 10px;
            margin-bottom: 30px;
        }

        .progress-bar-custom {
            height: 8px;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 10px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background: #4ade80;
            transition: width 0.3s ease;
        }

        .nav-buttons {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-bottom: 30px;
        }

        .nav-btn {
            padding: 12px 24px;
            border: 2px solid #e5e7eb;
            background: white;
            border-radius: 8px;
            cursor: pointer !important;
            transition: all 0.2s;
            font-weight: 500;
            pointer-events: auto !important;
            position: relative;
            z-index: 10;
        }

        .nav-btn:hover {
            border-color: #667eea;
            transform: translateY(-2px);
        }

        .nav-btn.active {
            background: #667eea;
            color: white;
            border-color: #667eea;
        }

        .nav-btn.completed {
            border-color: #4ade80;
            background: #f0fdf4;
            color: #166534;
        }

        .nav-btn.partial {
            border-color: #fbbf24;
            background: #fef3c7;
            color: #92400e;
        }

        .nav-btn.active.completed,
        .nav-btn.active.partial {
            color: white;
        }

        .content-section {
            background: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            display: none;
        }

        .content-section.active {
            display: block;
            animation: fadeIn 0.3s;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .indicator-card {
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 15px;
            transition: all 0.2s;
        }

        .indicator-card:hover {
            border-color: #667eea;
            box-shadow: 0 4px 6px rgba(102, 126, 234, 0.1);
        }

        .score-input {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }

        .score-btn {
            width: 45px;
            height: 45px;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            background: white;
            cursor: pointer;
            transition: all 0.2s;
            font-weight: 600;
        }

        .score-btn:hover {
            border-color: #667eea;
            transform: scale(1.05);
        }

        .score-btn.selected {
            background: #667eea;
            color: white;
            border-color: #667eea;
        }

        .comment-box {
            width: 100%;
            padding: 12px;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            min-height: 100px;
            margin-top: 20px;
        }

        .save-indicator {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: #4ade80;
            color: white;
            padding: 12px 24px;
            border-radius: 8px;
            display: none;
            animation: slideIn 0.3s;
        }

        @keyframes slideIn {
            from {
                transform: translateX(100%);
            }

            to {
                transform: translateX(0);
            }
        }

        .dosen-score-badge {
            display: inline-block;
            padding: 4px 12px;
            background: #f3f4f6;
            border-radius: 4px;
            font-size: 14px;
            color: #6b7280;
        }

        .submit-btn {
            background: linear-gradient(135deg, #f59e0b 0%, #ef4444 100%);
            color: white;
            padding: 15px 40px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(239, 68, 68, 0.3);
        }

        .submit-btn:disabled {
            background: #d1d5db;
            cursor: not-allowed;
            transform: none;
        }
    </style>

@section('contentvalidator')
    <div class="validator-container">
        <!-- Header -->
        <div class="header-section">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <h3 class="mb-2">{{ $form->informasiDasar->judul ?? 'Penilaian Form Inovasi' }}</h3>
                    <p class="mb-0 opacity-75">Dosen: {{ $form->user->name }}</p>
                    @if($validatorRecord && $validatorRecord->tanggal_penilaian)
                        <p class="mb-0 opacity-75">
                            <i class='bx bx-calendar'></i> Tanggal Penilaian: 
                            {{ \Carbon\Carbon::parse($validatorRecord->tanggal_penilaian)->format('d/m/Y') }}
                        </p>
                    @endif
                </div>
                <div class="text-end">
                    <span class="badge bg-light text-dark">{{ $progress->status }}</span>
                </div>
            </div>

            <div class="mt-4">
                <div class="d-flex justify-content-between mb-2">
                    <small>Progress Penilaian</small>
                    <small><span id="progress-percentage">0</span>%</small>
                </div>
                <div class="progress-bar-custom">
                    <div class="progress-fill" id="progress-fill" style="width: 0%"></div>
                </div>
            </div>


        </div>

        <!-- Navigation Tabs -->
        <div class="nav-buttons">
            <button class="nav-btn active completed" data-section="form-dosen" data-order="-1">
                <i class='bx bx-file'></i> Form Dosen
            </button>
            <button class="nav-btn {{ $agreement && $agreement->signature ? 'completed' : '' }}" data-section="agreement"
                data-order="0" onclick="console.log('Agreement button clicked')">
                <i class='bx bx-shield-alt-2'></i> Persetujuan
            </button>
            @foreach ($categories as $index => $category)
                @php
                    // Calculate category completion status
                    $irlNumber = (int) str_replace(['IRL', 'K'], '', $category->code);
                    $categoryResponses = $assessments->get($irlNumber, collect());
                    $totalIndicators = $category->indicators->count();
                    $assessedIndicators = $categoryResponses
                        ->filter(function ($response) {
                            return !empty($response->dropdown_value);
                        })
                        ->count();

                    // Check if comment exists
                    $hasComment = !empty($categoryComments[$irlNumber]->notes ?? '');

                    $categoryStatus = '';
                    if ($assessedIndicators === $totalIndicators && $totalIndicators > 0 && $hasComment) {
                        // Completed: all indicators assessed AND comment exists
                        $categoryStatus = 'completed';
                    } elseif ($assessedIndicators > 0 || $hasComment) {
                        // Partial: some indicators assessed OR comment exists (but not complete)
                        $categoryStatus = 'partial';
                    }
                @endphp
                <button class="nav-btn {{ $categoryStatus }}" data-section="irl{{ $index + 1 }}"
                    data-order="{{ $index + 1 }}">
                    {{ $category->code }}: {{ $category->name }}
                </button>
            @endforeach
            <button class="nav-btn {{ $beritaAcara && $beritaAcara->title ? 'completed' : '' }}" data-section="berita-acara"
                data-order="7">
                <i class='bx bx-file-blank'></i> Berita Acara
            </button>
            <button class="nav-btn {{ $validatorRecord && $validatorRecord->nama_penanggung_jawab ? 'completed' : '' }}"
                data-section="record" data-order="8">
                <i class='bx bx-note'></i> Record Hasil
            </button>
        </div>

        <!-- Form Dosen Section -->
        <div class="content-section active" data-section="form-dosen" id="section-form-dosen">
            <h4 class="mb-4"><i class='bx bx-file'></i> Data Form yang Diisi Dosen</h4>

            {{-- Informasi Proyek --}}
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">📌 Informasi Proyek</h5>
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
                                    <td>{{ $form->focus_area ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Institution:</th>
                                    <td>{{ $form->institution ?? 'Universitas Negeri Jakarta' }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-sm table-borderless">
                                <tr>
                                    <th width="40%">Pengusul:</th>
                                    <td>{{ $form->user->name ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Dibuat:</th>
                                    <td>{{ \Carbon\Carbon::parse($form->created_at)->format('d M Y, H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Status:</th>
                                    <td><span class="badge bg-info">{{ ucfirst($form->status) }}</span></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Form Judul Inovasi --}}
            @if ($form->katsinovInovasis->isNotEmpty())
                @php $inovasiInfo = $form->katsinovInovasis->first(); @endphp
                <div class="card mb-4">
                    <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">💡 Form Judul Inovasi</h5>
                        <button type="button" class="btn btn-sm btn-light" data-bs-toggle="modal"
                            data-bs-target="#modalInovasi">
                            <i class='bx bx-show'></i> Lihat Form Lengkap
                        </button>
                    </div>
                    <div class="card-body">
                        @if ($inovasiInfo->title || $inovasiInfo->sub_title)
                            <div class="mb-3">
                                <h6 class="text-primary">Judul & Sub Judul</h6>
                                <div class="row">
                                    <div class="col-md-12 mb-2">
                                        <strong>Judul Inovasi:</strong>
                                        <p class="text-muted">{{ $inovasiInfo->title ?? '-' }}</p>
                                    </div>
                                    <div class="col-md-12 mb-2">
                                        <strong>Sub Judul:</strong>
                                        <p class="text-muted">{{ $inovasiInfo->sub_title ?? '-' }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if ($inovasiInfo->introduction)
                            <div class="mb-3">
                                <h6 class="text-primary">Pengantar / Latar Belakang</h6>
                                <p>{{ $inovasiInfo->introduction }}</p>
                            </div>
                        @endif

                        @if ($inovasiInfo->tech_product)
                            <div class="mb-3">
                                <h6 class="text-primary">Produk Teknologi</h6>
                                <p>{{ $inovasiInfo->tech_product }}</p>
                            </div>
                        @endif

                        @if ($inovasiInfo->supremacy)
                            <div class="mb-3">
                                <h6 class="text-primary">Keunggulan</h6>
                                <p>{{ $inovasiInfo->supremacy }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            {{-- Informasi Dasar --}}
            @if ($form->katsinovInformasis->isNotEmpty())
                @php $informasi = $form->katsinovInformasis->first(); @endphp
                <div class="card mb-4">
                    <div class="card-header bg-warning text-dark d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">📄 Informasi Dasar</h5>
                        <button type="button" class="btn btn-sm btn-dark" data-bs-toggle="modal"
                            data-bs-target="#modalInformasi">
                            <i class='bx bx-show'></i> Lihat Form Lengkap
                        </button>
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
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-sm table-borderless">
                                    <tr>
                                        <th width="40%">Nama Inovasi:</th>
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
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endif



            {{-- Lampiran --}}
            @if ($form->katsinovLampirans->isNotEmpty())
                <div class="card mb-4">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0">📎 Lampiran Dokumen</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="25%">Kategori</th>
                                        <th width="50%">Nama File</th>
                                        <th width="15%">Tanggal Upload</th>
                                        <th width="5%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($form->katsinovLampirans as $index => $lampiran)
                                        @php
                                            // Map label descriptions
                                            $labelMap = [
                                                // Aspek Teknologi
                                                'proposal' => 'Proposal penelitian dan pengembangan',
                                                'jadwal' => 'Jadwal program (Program Schedule)',
                                                'desain' => 'Desain secara teori dan empiris',
                                                'simulasi_pemodelan' => 'Hasil simulasi dan pemodelan',
                                                'penelitian_analitik' => 'Hasil penelitian analitik',
                                                'eksperimen_laboratorium' => 'Hasil eksperimen laboratorium',
                                                'prototipe_laboratorium' => 'Prototipe skala laboratorium',
                                                'prototipe_pilot' => 'Prototipe skala pilot',
                                                'uji_kelayakan' => 'Hasil uji kelayakan teknis',
                                                'prototipe_sebanding' => 'Prototipe skala 1:1',
                                                'simulasi_lingkungan' => 'Uji pada simulasi lingkungan operasional',
                                                'test_evaluasi' => 'Hasil test dan evaluasi',
                                                'dokumen_ilmiah' => 'Publikasi ilmiah: paper, prosiding, jurnal, dll',
                                                'dokumen_haki' => 'Kekayaan Intelektual: paten, lisensi, desain industri, dll',
                                                // Aspek Pasar
                                                'penelitian_pasar' => 'Hasil Penelitian pasar (marketing research)',
                                                'identifkasi_segmen' => 'Identifikasi segmen, ukuran dan pangsa pasar',
                                                'perhitungan_kebutuhan' => 'Perhitungan kebutuhan investasi',
                                                'estimasi_harga' => 'Estimasi harga produksi dibandingkan kompetitor',
                                                'identifikasi_kompetitor' => 'Identifikasi kompetitor',
                                                'model_bisnis' => 'Model bisnis',
                                                'posisioning_pasar' => 'Posisioning pasar',
                                                // Aspek Organisasi
                                                'strategi_inovasi' => 'Strategi Inovasi',
                                                'sdm' => 'Sumber Daya Manusia',
                                                'analisis_bisnis' => 'Analisis dan Rencana Bisnis',
                                                'struktur_bisnis' => 'Organisasi Formal (Struktur Bisnis dengan Staff dan Kolaborator)',
                                                // Aspek Mitra
                                                'mitra_potensial' => 'Daftar Mitra Potensial',
                                                'kerjasama' => 'Kerjasama',
                                                'pengelolaan_kerjasama' => 'Pengelolaan Kerjasama yang Telah Berjalan',
                                                // Aspek Risiko
                                                'kajian_teknologi' => 'Kajian Risiko Teknologi',
                                                'kajian_pasar' => 'Kajian Risiko Pasar',
                                                'kajian_organisasi' => 'Kajian Risiko Organisasi',
                                                // Aspek Manufaktur
                                                'analisis_materil' => 'Analisis Awal Solusi Material',
                                                'material_prototipe' => 'Material, Perkakas dan Alat Uji Prototipe',
                                                'analisis_biaya' => 'Analisis Rincian Biaya',
                                                'proses_prosedur' => 'Proses dan Prosedur Manufaktur',
                                                'jaminan_mutu' => 'Jaminan Mutu (Quality Assurance)',
                                                'lean_manufaktur' => 'Penerapan Lean Manufacturing',
                                                // Aspek Investasi
                                                'pelanggan_pasar' => 'Analisis Pelanggan, Pasar dan Pesaing',
                                                'mvp' => 'Market Value Proposition (MVP)',
                                                'kondisi_produk' => 'Estimasi Kondisi Akhir Produk',
                                                'potensi_pasar' => 'Estimasi Potensi Pasar',
                                                'ekspansi_pasar' => 'Estimasi Ekspansi Pasar',
                                            ];
                                            
                                            $documentLabel = $labelMap[$lampiran->type] ?? ucwords(str_replace('_', ' ', $lampiran->type ?? 'Dokumen'));
                                        @endphp
                                        <tr>
                                            <td class="text-center">{{ $index + 1 }}</td>
                                            <td>{{ $documentLabel }}</td>
                                            <td>
                                                <i class='bx bx-file'></i>
                                                {{ basename($lampiran->path ?? 'Document-' . ($index + 1)) }}
                                            </td>
                                            <td class="text-center">
                                                {{ $lampiran->created_at ? $lampiran->created_at->format('d/m/Y') : '-' }}
                                            </td>
                                            <td class="text-center">
                                                @if ($lampiran->path)
                                                    <a href="{{ route('validator.lampiran.preview', ['formId' => $form->id, 'lampiranId' => $lampiran->id]) }}"
                                                        target="_blank" class="btn btn-sm btn-info" title="Lihat Dokumen">
                                                        <i class='bx bx-show'></i>
                                                    </a>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">
                            <small class="text-muted">
                                <i class='bx bx-info-circle'></i>
                                Total: <strong>{{ $form->katsinovLampirans->count() }}</strong> dokumen terupload
                            </small>
                        </div>
                    </div>
                </div>
            @endif

            <div class="text-center mt-4 mb-4" style="position: relative; z-index: 100;">
                <button type="button" class="btn btn-primary btn-lg" id="btn-lanjut-persetujuan"
                    style="cursor: pointer; pointer-events: auto;">
                    <i class='bx bx-right-arrow-alt'></i> Lanjut ke Persetujuan
                </button>
            </div>
        </div>

        <!-- Agreement Section -->
        <div class="content-section" data-section="agreement" id="section-agreement">
            <h4 class="mb-4">Persetujuan Validator</h4>
            <div class="alert alert-info">
                <i class='bx bx-info-circle'></i>
                <strong>Perhatian:</strong> Dengan menandatangani formulir ini, Anda menyatakan kesediaan untuk melakukan
                penilaian secara objektif dan profesional terhadap form inovasi ini.
            </div>

            <div class="form-check mb-4">
                <input class="form-check-input" type="checkbox" id="agree-checkbox">
                <label class="form-check-label" for="agree-checkbox">
                    Saya setuju untuk melakukan penilaian secara objektif dan sesuai dengan kriteria yang telah ditetapkan
                </label>
            </div>

            @if ($agreement && $agreement->signature)
                <div class="alert alert-success mb-3">
                    <i class='bx bx-check-circle'></i>
                    <strong>Persetujuan sudah ditandatangani</strong> pada
                    {{ $agreement->signed_at ? \Carbon\Carbon::parse($agreement->signed_at)->format('d/m/Y H:i') : '-' }}
                </div>

                <div class="mb-4">
                    <label class="form-label"><strong>Tanda Tangan Digital (Tersimpan)</strong></label>
                    <div class="border rounded p-3 bg-light">
                        <img src="{{ $agreement->signature }}" alt="Signature"
                            style="max-width: 100%; height: auto; border: 1px solid #ddd;">
                    </div>
                </div>
            @else
                <div class="mb-4">
                    <label class="form-label"><strong>Tanda Tangan Digital</strong></label>
                    <div class="border rounded p-3">
                        <canvas id="signature-pad" width="600" height="200"
                            style="border: 1px solid #ddd; cursor: crosshair;"></canvas>
                    </div>
                    <div class="mt-2">
                        <button type="button" class="btn btn-sm btn-outline-secondary" id="clear-signature">
                            <i class='bx bx-eraser'></i> Hapus
                        </button>
                    </div>
                </div>

                <button type="button" class="btn btn-primary" id="save-agreement">
                    <i class='bx bx-save'></i> Simpan Persetujuan
                </button>
            @endif
        </div>

        <!-- IRL Assessment Sections -->
        @foreach ($categories as $index => $category)
            <div class="content-section" data-section="irl{{ $index + 1 }}" id="section-irl{{ $index + 1 }}">
                <h4 class="mb-4">{{ $category->code }}: {{ $category->name }}</h4>
                <p class="text-muted">{{ $category->description }}</p>

                @php
                    // Get IRL number from category code (IRL1 = 1, IRL2 = 2, etc)
                    $irlNumber = (int) str_replace(['IRL', 'K'], '', $category->code);
                    $categoryResponses = $assessments->get($irlNumber, collect());
                    
                    // Load score descriptions for tooltips
                    $scoreDescriptions = include(resource_path('views/admin/katsinov_v2/includes/indicator_score_descriptions.php'));
                @endphp

                @if ($categoryResponses->count() > 0)
                    <div class="alert alert-info mb-3">
                        <i class='bx bx-info-circle'></i>
                        <strong>Dosen telah mengisi {{ $categoryResponses->count() }} indikator</strong> untuk kategori
                        ini.
                        Berikan penilaian Anda berdasarkan bukti dan dokumen yang ada.
                    </div>
                @else
                    <div class="alert alert-warning mb-3">
                        <i class='bx bx-info-circle'></i>
                        <strong>Dosen belum mengisi indikator</strong> untuk kategori ini.
                        Anda tetap dapat memberikan penilaian.
                    </div>
                @endif

                <div class="indicators-list">
                    @foreach ($category->indicators as $indicatorIndex => $indicator)
                        @php
                            // Find matching response by row_number
                            $dosenAssessment = $categoryResponses->firstWhere('row_number', $indicatorIndex + 1);
                        @endphp
                        <div class="indicator-card" data-indicator-id="{{ $indicator->id }}"
                            data-row-number="{{ $indicatorIndex + 1 }}">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">{{ $indicator->code }}: {{ $indicator->name }}</h6>
                                    <small class="text-muted">{{ $indicator->description }}</small>

                                    @if ($dosenAssessment)
                                        <div class="mt-2 p-2 bg-light rounded border border-info">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="d-flex align-items-center">
                                                        <i class='bx bx-user text-primary fs-5 me-2'></i>
                                                        <div>
                                                            <small class="text-muted d-block">Nilai Dosen:</small>
                                                            <span class="badge bg-primary"
                                                                style="font-size: 16px;">{{ $dosenAssessment->score }}</span>
                                                            <small class="text-muted ms-1">
                                                                @php
                                                                    $score = $dosenAssessment->score;
                                                                    $desc = match (true) {
                                                                        $score == 0 => 'Tidak ada',
                                                                        $score == 1 => 'Tahap awal',
                                                                        $score == 2 => 'Dalam pengembangan',
                                                                        $score == 3 => 'Berjalan parsial',
                                                                        $score == 4 => 'Berjalan baik',
                                                                        $score == 5 => 'Sangat baik',
                                                                        default => '-',
                                                                    };
                                                                @endphp
                                                                ({{ $desc }})
                                                            </small>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    @if ($dosenAssessment->dropdown_value)
                                                        <div class="d-flex align-items-center">
                                                            <i class='bx bx-check-circle text-success fs-5 me-2'></i>
                                                            <div>
                                                                <small class="text-muted d-block">Rating Validator:</small>
                                                                <span class="badge bg-success" style="font-size: 16px;">
                                                                    @php
                                                                        $dropdownMap = [
                                                                            'A' => 0,
                                                                            'B' => 1,
                                                                            'C' => 2,
                                                                            'D' => 3,
                                                                            'E' => 4,
                                                                            'F' => 5,
                                                                        ];
                                                                        $validatorScore =
                                                                            $dropdownMap[
                                                                                $dosenAssessment->dropdown_value
                                                                            ] ?? '-';
                                                                    @endphp
                                                                    {{ $validatorScore }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <small class="text-warning"><i class='bx bx-time'></i> Belum
                                                            dinilai validator</small>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="mt-1">
                                                <small class="text-muted"><strong>Aspek:</strong>
                                                    {{ $dosenAssessment->aspect }}</small>
                                            </div>
                                        </div>
                                    @else
                                        <div class="mt-2 p-2 bg-light rounded border border-warning">
                                            <i class='bx bx-info-circle text-warning'></i>
                                            <small class="text-muted">Dosen belum memberikan nilai untuk indikator
                                                ini</small>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <label class="form-label"><strong>Nilai Validator:</strong></label>
                            <div class="score-input">
                                @php
                                    $savedValidatorScore = null;
                                    if ($dosenAssessment && $dosenAssessment->dropdown_value) {
                                        $dropdownMap = [
                                            'A' => 0,
                                            'B' => 1,
                                            'C' => 2,
                                            'D' => 3,
                                            'E' => 4,
                                            'F' => 5,
                                        ];
                                        $savedValidatorScore = $dropdownMap[$dosenAssessment->dropdown_value] ?? null;
                                    }
                                @endphp
                                @for ($score = 0; $score <= 5; $score++)
                                    <button type="button"
                                        class="score-btn {{ $savedValidatorScore === $score ? 'selected' : '' }}"
                                        data-score="{{ $score }}"
                                        onclick="showValidatorScoreTooltip({{ $irlNumber }}, {{ $indicatorIndex + 1 }}, {{ $score }}, this)">
                                        {{ $score }}
                                    </button>
                                @endfor
                            </div>
                            
                            {{-- Tooltip row for score description --}}
                            <div id="validator-tooltip-{{ $irlNumber }}-{{ $indicatorIndex + 1 }}" class="mt-3 p-3 bg-info bg-opacity-10 border-start border-info border-4 rounded" style="display: none;">
                                <div class="d-flex align-items-start gap-3">
                                    <div class="flex-shrink-0">
                                        <span id="validator-tooltip-score-badge-{{ $irlNumber }}-{{ $indicatorIndex + 1 }}" class="d-inline-flex align-items-center justify-content-center rounded-circle bg-primary text-white fw-bold" style="width: 40px; height: 40px; font-size: 18px;">
                                            0
                                        </span>
                                    </div>
                                    <div class="flex-grow-1">
                                        <p class="fw-semibold text-primary mb-1" style="font-size: 14px;">Deskripsi Nilai:</p>
                                        <p id="validator-tooltip-desc-{{ $irlNumber }}-{{ $indicatorIndex + 1 }}" class="text-dark mb-0" style="font-size: 13px;"></p>
                                    </div>
                                    <button type="button" onclick="hideValidatorScoreTooltip({{ $irlNumber }}, {{ $indicatorIndex + 1 }})" class="btn-close" aria-label="Close"></button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-4">
                    <label class="form-label"><strong>Komentar untuk {{ $category->name }}</strong></label>
                    @php
                        $irlNumber = (int) str_replace(['IRL', 'K'], '', $category->code);
                        $savedComment = $categoryComments[$irlNumber]->notes ?? '';
                    @endphp
                    <textarea class="comment-box" id="comment-{{ $category->id }}"
                        placeholder="Tuliskan komentar Anda untuk kategori ini...">{{ $savedComment }}</textarea>
                </div>

                <div class="mt-4 d-flex justify-content-between">
                    <button type="button" class="btn btn-outline-secondary prev-section">
                        <i class='bx bx-chevron-left'></i> Sebelumnya
                    </button>
                    <button type="button" class="btn btn-primary save-category" data-category-id="{{ $category->id }}">
                        <i class='bx bx-save'></i> Simpan & Lanjut
                    </button>
                </div>
            </div>
        @endforeach

        <!-- Berita Acara Section -->
        <div class="content-section" data-section="berita-acara" id="section-berita-acara">
            <h4 class="mb-4"><i class='bx bx-file-blank'></i> Berita Acara Pengukuran Tingkat Kesiapan Teknologi</h4>

            <form id="form-berita-acara">
                <div class="alert alert-info mb-4">
                    <i class='bx bx-info-circle'></i> Lengkapi informasi berita acara pengukuran sesuai format standar
                </div>

                <p class="mb-3">
                    Pada hari ini,
                    <input type="text" class="form-control d-inline-block" style="width: 150px;" name="text_day"
                        value="{{ $beritaAcara->day ?? '' }}" placeholder="Senin" required>,
                    tanggal
                    <input type="text" class="form-control d-inline-block" style="width: 80px;" name="text_date"
                        value="{{ $beritaAcara->date ?? '' }}" placeholder="01" required>
                    bulan
                    <input type="text" class="form-control d-inline-block" style="width: 150px;" name="text_month"
                        value="{{ $beritaAcara->month ?? '' }}" placeholder="Januari" required>
                    tahun
                    <input type="text" class="form-control d-inline-block" style="width: 80px;" name="text_year"
                        value="{{ $beritaAcara->year ?? '' }}" placeholder="25" required>
                    (<input type="text" class="form-control d-inline-block" style="width: 100px;"
                        name="text_yearfull" value="{{ $beritaAcara->yearfull ?? '' }}" placeholder="2025" required>),
                </p>

                <p class="mb-4">
                    bertempat di
                    <input type="text" class="form-control d-inline-block" style="width: 300px;" name="text_place"
                        value="{{ $beritaAcara->place ?? '' }}" placeholder="Universitas Negeri Jakarta" required>,
                    dari hasil pengukuran Tingkat Kesiapan Inovasi (KATSINOV) yang dilakukan oleh Tim yang dibentuk
                    berdasarkan
                    Surat Keputusan
                    <input type="text" class="form-control d-inline-block" style="width: 300px;" name="text_decree"
                        value="{{ $beritaAcara->decree ?? '' }}" placeholder="Nomor SK" required> menyatakan:
                </p>

                <div class="mb-3">
                    <label class="form-label"><strong>Judul Inovasi</strong></label>
                    <input type="text" class="form-control" name="innovation_title"
                        value="{{ $beritaAcara->title ?? ($form->judul ?? '') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label"><strong>Jenis Inovasi</strong></label>
                    <input type="text" class="form-control" name="innovation_type"
                        value="{{ $beritaAcara->type ?? '' }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label"><strong>Nilai TKI</strong></label>
                    <input type="text" class="form-control" name="innovation_tki"
                        value="{{ $beritaAcara->tki ?? '' }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label"><strong>Opini Penilai</strong></label>
                    <textarea class="form-control" name="innovation_opinion" rows="4" required>{{ $beritaAcara->opinion ?? '' }}</textarea>
                </div>

                <p class="mb-4">
                    Demikian Berita Acara Pengukuran Tingkat Kesiapan Inovasi (KATSINOV) ini dibuat dengan sebenar-benarnya,
                    kemudian ditutup dan ditandatangani pada
                    <input type="date" class="form-control d-inline-block" style="width: 200px;"
                        name="innovation_date" value="{{ $beritaAcara->sign_date ?? date('Y-m-d') }}" required>
                    pada hari dan tanggal, bulan, tahun tersebut di atas.
                </p>

                <h5 class="mt-5 mb-4">Tanda Tangan Digital</h5>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title"><strong>Penanggungjawab Inovasi</strong></h6>
                                <div class="mb-3">
                                    <label class="form-label">Nama Penanggungjawab</label>
                                    <input type="text" class="form-control" name="penanggungjawab"
                                        value="{{ $beritaAcara->penanggungjawab ?? '' }}" required>
                                </div>
                                <div class="mb-3">
                                    @if ($beritaAcara && $beritaAcara->penanggungjawab_signature)
                                        <label class="form-label"><strong>Tanda Tangan (Tersimpan)</strong></label>
                                        <div class="border rounded p-3 bg-light">
                                            <img src="{{ $beritaAcara->penanggungjawab_signature }}" alt="Signature Penanggungjawab"
                                                style="max-width: 100%; height: auto; border: 1px solid #ddd;">
                                        </div>
                                    @else
                                        <label class="form-label"><strong>Tanda Tangan Digital</strong></label>
                                        <div class="border rounded p-3">
                                            <canvas id="signature-penanggungjawab" width="400" height="150"
                                                style="border: 1px solid #ddd; cursor: crosshair;"></canvas>
                                        </div>
                                        <div class="mt-2">
                                            <button type="button" class="btn btn-sm btn-outline-secondary clear-signature"
                                                data-canvas="signature-penanggungjawab">
                                                <i class='bx bx-eraser'></i> Hapus
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title"><strong>Ketua Tim Penilai</strong></h6>
                                <div class="mb-3">
                                    <label class="form-label">Nama Ketua</label>
                                    <input type="text" class="form-control" name="ketua"
                                        value="{{ $beritaAcara->ketua ?? '' }}" placeholder="Nama Ketua" required>
                                </div>
                                <div class="mb-3">
                                    @if ($beritaAcara && $beritaAcara->ketua_signature)
                                        <label class="form-label"><strong>Tanda Tangan (Tersimpan)</strong></label>
                                        <div class="border rounded p-3 bg-light">
                                            <img src="{{ $beritaAcara->ketua_signature }}" alt="Signature Ketua"
                                                style="max-width: 100%; height: auto; border: 1px solid #ddd;">
                                        </div>
                                    @else
                                        <label class="form-label"><strong>Tanda Tangan Digital</strong></label>
                                        <div class="border rounded p-3">
                                            <canvas id="signature-ketua" width="400" height="150"
                                                style="border: 1px solid #ddd; cursor: crosshair;"></canvas>
                                        </div>
                                        <div class="mt-2">
                                            <button type="button" class="btn btn-sm btn-outline-secondary clear-signature"
                                                data-canvas="signature-ketua">
                                                <i class='bx bx-eraser'></i> Hapus
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title"><strong>Anggota 1 Tim Penilai</strong></h6>
                                <div class="mb-3">
                                    <label class="form-label">Nama Anggota 1</label>
                                    <input type="text" class="form-control" name="anggota1"
                                        value="{{ $beritaAcara->anggota1 ?? '' }}" placeholder="Nama Anggota 1" required>
                                </div>
                                <div class="mb-3">
                                    @if ($beritaAcara && $beritaAcara->anggota1_signature)
                                        <label class="form-label"><strong>Tanda Tangan (Tersimpan)</strong></label>
                                        <div class="border rounded p-3 bg-light">
                                            <img src="{{ $beritaAcara->anggota1_signature }}" alt="Signature Anggota 1"
                                                style="max-width: 100%; height: auto; border: 1px solid #ddd;">
                                        </div>
                                    @else
                                        <label class="form-label"><strong>Tanda Tangan Digital</strong></label>
                                        <div class="border rounded p-3">
                                            <canvas id="signature-anggota1" width="400" height="150"
                                                style="border: 1px solid #ddd; cursor: crosshair;"></canvas>
                                        </div>
                                        <div class="mt-2">
                                            <button type="button" class="btn btn-sm btn-outline-secondary clear-signature"
                                                data-canvas="signature-anggota1">
                                                <i class='bx bx-eraser'></i> Hapus
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title"><strong>Anggota 2 Tim Penilai</strong></h6>
                                <div class="mb-3">
                                    <label class="form-label">Nama Anggota 2</label>
                                    <input type="text" class="form-control" name="anggota2"
                                        value="{{ $beritaAcara->anggota2 ?? '' }}" placeholder="Nama Anggota 2" required>
                                </div>
                                <div class="mb-3">
                                    @if ($beritaAcara && $beritaAcara->anggota2_signature)
                                        <label class="form-label"><strong>Tanda Tangan (Tersimpan)</strong></label>
                                        <div class="border rounded p-3 bg-light">
                                            <img src="{{ $beritaAcara->anggota2_signature }}" alt="Signature Anggota 2"
                                                style="max-width: 100%; height: auto; border: 1px solid #ddd;">
                                        </div>
                                    @else
                                        <label class="form-label"><strong>Tanda Tangan Digital</strong></label>
                                        <div class="border rounded p-3">
                                            <canvas id="signature-anggota2" width="400" height="150"
                                                style="border: 1px solid #ddd; cursor: crosshair;"></canvas>
                                        </div>
                                        <div class="mt-2">
                                            <button type="button" class="btn btn-sm btn-outline-secondary clear-signature"
                                                data-canvas="signature-anggota2">
                                                <i class='bx bx-eraser'></i> Hapus
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <button type="button" class="btn btn-outline-secondary prev-section">
                        <i class='bx bx-chevron-left'></i> Sebelumnya
                    </button>
                    <button type="button" class="btn btn-primary" id="save-berita-acara-final">
                        <i class='bx bx-check'></i> Simpan & Lanjut
                    </button>
                </div>
            </form>
        </div>

        <!-- Record Hasil Section -->
        <div class="content-section" data-section="record" id="section-record">
            <h4 class="mb-4"><i class='bx bx-note'></i> Record Hasil Pengukuran</h4>

            <form id="form-validator-record">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label"><strong>Nama Penanggung Jawab</strong></label>
                        <input type="text" class="form-control" name="nama_penanggung_jawab"
                            value="{{ $validatorRecord->nama_penanggung_jawab ?? ($form->user->name ?? '') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label"><strong>Institusi</strong></label>
                        <input type="text" class="form-control" name="institusi"
                            value="{{ $validatorRecord->institusi ?? 'Universitas Negeri Jakarta' }}" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label"><strong>Judul Inovasi</strong></label>
                        <input type="text" class="form-control" name="judul_inovasi"
                            value="{{ $validatorRecord->judul_inovasi ?? ($form->judul ?? '') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label"><strong>Jenis Inovasi</strong></label>
                        <input type="text" class="form-control" name="jenis_inovasi"
                            value="{{ $validatorRecord->jenis_inovasi ?? '' }}" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label"><strong>Alamat Kontak</strong></label>
                    <textarea class="form-control" name="alamat_kontak" rows="2" required>{{ $validatorRecord->alamat_kontak ?? '' }}</textarea>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label"><strong>Telepon</strong></label>
                        <input type="text" class="form-control" name="phone"
                            value="{{ $validatorRecord->phone ?? '' }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label"><strong>Fax</strong></label>
                        <input type="text" class="form-control" name="fax"
                            value="{{ $validatorRecord->fax ?? '-' }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label"><strong>Tanggal Penilaian</strong></label>
                        <input type="date" class="form-control" name="tanggal_penilaian"
                            value="{{ $validatorRecord->tanggal_penilaian ?? date('Y-m-d') }}" required>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
                    <h5 class="mb-0">Detail Penilaian</h5>
                    <button type="button" class="btn btn-sm btn-outline-primary" id="add-detail-row">
                        <i class='bx bx-plus'></i> Tambah Baris
                    </button>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered" id="detail-table">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 20%">Aspek</th>
                                <th style="width: 25%">Aktivitas</th>
                                <th style="width: 10%">Capaian</th>
                                <th style="width: 20%">Keterangan</th>
                                <th style="width: 20%">Catatan</th>
                                <th style="width: 5%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="detail-tbody">
                            @php
                                $hasExistingData = false;
                                if ($validatorRecord) {
                                    for ($i = 1; $i <= 5; $i++) {
                                        if (!empty($validatorRecord->{"aspek_$i"})) {
                                            $hasExistingData = true;
                                            break;
                                        }
                                    }
                                }
                            @endphp
                            @if ($hasExistingData)
                                @for ($i = 1; $i <= 5; $i++)
                                    @if (!empty($validatorRecord->{"aspek_$i"}))
                                        <tr data-row="{{ $i }}">
                                            <td>
                                                <input type="text" class="form-control form-control-sm"
                                                    name="aspek_{{ $i }}"
                                                    value="{{ $validatorRecord->{'aspek_' . $i} }}" required>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control form-control-sm"
                                                    name="aktivitas_{{ $i }}"
                                                    value="{{ $validatorRecord->{'aktivitas_' . $i} }}" required>
                                            </td>
                                            <td>
                                                <input type="number" class="form-control form-control-sm"
                                                    name="capaian_{{ $i }}" min="0" max="5"
                                                    value="{{ $validatorRecord->{'capaian_' . $i} }}" required>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control form-control-sm"
                                                    name="keterangan_{{ $i }}"
                                                    value="{{ $validatorRecord->{'keterangan_' . $i} }}" required>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control form-control-sm"
                                                    name="catatan_{{ $i }}"
                                                    value="{{ $validatorRecord->{'catatan_' . $i} }}" required>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-danger remove-row">
                                                    <i class='bx bx-trash'></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endif
                                @endfor
                            @else
                                <tr data-row="1">
                                    <td>
                                        <input type="text" class="form-control form-control-sm" name="aspek_1"
                                            required>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm" name="aktivitas_1"
                                            required>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control form-control-sm" name="capaian_1"
                                            min="0" max="5" required>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm" name="keterangan_1"
                                            required>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm" name="catatan_1"
                                            required>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-danger remove-row">
                                            <i class='bx bx-trash'></i>
                                        </button>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <button type="button" class="btn btn-outline-secondary prev-section">
                        <i class='bx bx-chevron-left'></i> Sebelumnya
                    </button>
                    <button type="button" class="btn btn-success" id="save-record-final">
                        <i class='bx bx-check'></i> Simpan Final
                    </button>
                </div>
            </form>

            @if ($progress->record_completed)
                <div class="text-center mt-5 pt-4 border-top">
                    <div class="alert alert-success mb-4">
                        <i class='bx bx-check-circle'></i> Semua bagian penilaian telah lengkap
                    </div>
                    <button type="button" class="submit-btn" id="submit-final" {{ $isReadOnly ? 'disabled' : '' }}>
                        <i class='bx bx-send'></i> Submit Final Penilaian
                    </button>
                    <p class="text-muted mt-2">
                        <small>Setelah submit, semua data akan menjadi read-only dan tidak dapat diubah</small>
                    </p>
                </div>
            @endif
        </div>

        <!-- Save Indicator -->
        <div class="save-indicator" id="save-indicator">
            <i class='bx bx-check-circle'></i> Tersimpan
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
    <script>
        const formId = {{ $form->id }};
        const isReadOnly = {{ $isReadOnly ? 'true' : 'false' }};
        let currentSection = 0;
        const totalSections = document.querySelectorAll('.nav-btn').length;

        // Initialize Signature Pad (lazy initialization)
        let signaturePad = null;
        let beritaAcaraSignaturePads = {};

        function initSignaturePad() {
            if (signaturePad) return; // Already initialized

            const canvas = document.getElementById('signature-pad');
            if (!canvas) return; // Canvas not available yet

            signaturePad = new SignaturePad(canvas);

            const clearBtn = document.getElementById('clear-signature');
            if (clearBtn) {
                clearBtn.addEventListener('click', () => {
                    signaturePad.clear();
                });
            }
        }

        function initBeritaAcaraSignaturePads() {
            const canvasIds = ['signature-penanggungjawab', 'signature-ketua', 'signature-anggota1', 'signature-anggota2'];
            
            canvasIds.forEach(canvasId => {
                const canvas = document.getElementById(canvasId);
                if (canvas && !beritaAcaraSignaturePads[canvasId]) {
                    beritaAcaraSignaturePads[canvasId] = new SignaturePad(canvas);
                }
            });

            // Add clear button handlers
            document.querySelectorAll('.clear-signature').forEach(btn => {
                const canvasId = btn.dataset.canvas;
                if (canvasId && beritaAcaraSignaturePads[canvasId]) {
                    btn.addEventListener('click', () => {
                        beritaAcaraSignaturePads[canvasId].clear();
                    });
                }
            });
        }

        // Show section function
        function showSection(sectionName) {
            const targetBtn = document.querySelector(`.nav-btn[data-section="${sectionName}"]`);
            if (targetBtn) {
                targetBtn.click();
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });

                // Initialize signature pad when showing agreement section
                if (sectionName === 'agreement') {
                    setTimeout(() => initSignaturePad(), 100);
                }
            }
        }

        // Button Lanjut ke Persetujuan
        const btnLanjutPersetujuan = document.getElementById('btn-lanjut-persetujuan');
        console.log('Button Lanjut ke Persetujuan element:', btnLanjutPersetujuan);
        if (btnLanjutPersetujuan) {
            btnLanjutPersetujuan.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                console.log('Lanjut ke Persetujuan clicked');
                showSection('agreement');
            });
        } else {
            console.error('Button btn-lanjut-persetujuan not found!');
        }

        // Navigation
        document.querySelectorAll('.nav-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                // if (isReadOnly && this.dataset.section.startsWith('irl')) return;

                const sectionId = 'section-' + this.dataset.section;
                const targetSection = document.getElementById(sectionId);

                if (!targetSection) {
                    console.error('Section not found:', sectionId);
                    return;
                }

                // Update nav buttons
                document.querySelectorAll('.nav-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');

                // Update content sections
                document.querySelectorAll('.content-section').forEach(s => s.classList.remove('active'));
                targetSection.classList.add('active');

                currentSection = parseInt(this.dataset.order);
                updateProgress();

                // Initialize signature pad when showing agreement section
                if (this.dataset.section === 'agreement') {
                    setTimeout(() => initSignaturePad(), 100);
                }
                
                // Initialize berita acara signature pads
                if (this.dataset.section === 'berita-acara') {
                    setTimeout(() => initBeritaAcaraSignaturePads(), 100);
                }
            });
        });

        // Previous/Next buttons
        document.querySelectorAll('.prev-section').forEach(btn => {
            btn.addEventListener('click', () => {
                const navBtns = Array.from(document.querySelectorAll('.nav-btn'));
                if (currentSection > 0) {
                    navBtns[currentSection - 1].click();
                }
            });
        });

        // Score selection
        document.querySelectorAll('.score-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const card = this.closest('.indicator-card');
                card.querySelectorAll('.score-btn').forEach(b => b.classList.remove('selected'));
                this.classList.add('selected');

                showSaveIndicator();
            });
        });

        // Save Agreement
        const saveAgreementBtn = document.getElementById('save-agreement');
        if (saveAgreementBtn) {
            saveAgreementBtn.addEventListener('click', async function() {
                const agreeCheckbox = document.getElementById('agree-checkbox');

                if (!agreeCheckbox.checked) {
                    Swal.fire('Error', 'Anda harus menyetujui persyaratan terlebih dahulu', 'error');
                    return;
                }

                if (!signaturePad || signaturePad.isEmpty()) {
                    Swal.fire('Error', 'Mohon tanda tangani terlebih dahulu', 'error');
                    return;
                }

                const signatureData = signaturePad.toDataURL();

                try {
                    const response = await fetch(`/validator/assess/${formId}/agreement`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            signature: signatureData
                        })
                    });

                    const data = await response.json();

                    if (data.success) {
                        Swal.fire('Berhasil', 'Persetujuan berhasil disimpan', 'success');
                        this.disabled = true;
                        document.querySelector('[data-section="agreement"]').classList.add('completed');

                        // Move to first IRL
                        document.querySelector('[data-section="irl1"]').click();
                    } else {
                        Swal.fire('Error', data.message, 'error');
                    }
                } catch (error) {
                    Swal.fire('Error', 'Terjadi kesalahan', 'error');
                }
            });
        }

        // Save Category Assessment
        document.querySelectorAll('.save-category').forEach(btn => {
            btn.addEventListener('click', async function() {
                const categoryId = this.dataset.categoryId;
                const section = this.closest('.content-section');
                const indicators = [];

                // Collect indicator scores
                section.querySelectorAll('.indicator-card').forEach(card => {
                    const indicatorId = card.dataset.indicatorId;
                    const rowNumber = card.dataset.rowNumber;
                    const selectedScore = card.querySelector('.score-btn.selected');

                    if (selectedScore) {
                        indicators.push({
                            indicator_id: indicatorId,
                            row_number: rowNumber,
                            validator_score: selectedScore.dataset.score
                        });
                    }
                });

                if (indicators.length === 0) {
                    Swal.fire('Error', 'Mohon berikan penilaian untuk setidaknya satu indikator',
                        'error');
                    return;
                }

                const categoryComment = document.getElementById('comment-' + categoryId).value;

                try {
                    const response = await fetch(`/validator/assess/${formId}/assessment`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .content
                        },
                        body: JSON.stringify({
                            category_id: categoryId,
                            indicators: indicators,
                            category_comment: categoryComment
                        })
                    });

                    const data = await response.json();

                    if (data.success) {
                        showSaveIndicator();

                        // Mark as completed
                        const currentNavBtn = document.querySelector('.nav-btn.active');
                        currentNavBtn.classList.add('completed');

                        // Move to next section
                        const navBtns = Array.from(document.querySelectorAll('.nav-btn'));
                        if (currentSection < totalSections - 1) {
                            navBtns[currentSection + 1].click();
                        }
                    } else {
                        Swal.fire('Error', data.message, 'error');
                    }
                } catch (error) {
                    Swal.fire('Error', 'Terjadi kesalahan', 'error');
                }
            });
        });

        // Save Berita Acara
        async function saveBeritaAcara(isFinal = false) {
            const form = document.getElementById('form-berita-acara');
            
            // Validate required fields
            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            // Collect form data
            const formData = new FormData(form);
            const data = {
                is_final: isFinal,
                text_day: formData.get('text_day'),
                text_date: formData.get('text_date'),
                text_month: formData.get('text_month'),
                text_year: formData.get('text_year'),
                text_yearfull: formData.get('text_yearfull'),
                text_place: formData.get('text_place'),
                text_decree: formData.get('text_decree'),
                innovation_title: formData.get('innovation_title'),
                innovation_type: formData.get('innovation_type'),
                innovation_tki: formData.get('innovation_tki'),
                innovation_opinion: formData.get('innovation_opinion'),
                innovation_date: formData.get('innovation_date'),
                penanggungjawab: formData.get('penanggungjawab'),
                ketua: formData.get('ketua'),
                anggota1: formData.get('anggota1'),
                anggota2: formData.get('anggota2')
            };

            // Add signature data if available
            if (beritaAcaraSignaturePads['signature-penanggungjawab'] && !beritaAcaraSignaturePads['signature-penanggungjawab'].isEmpty()) {
                data.penanggungjawab_signature = beritaAcaraSignaturePads['signature-penanggungjawab'].toDataURL();
            }
            if (beritaAcaraSignaturePads['signature-ketua'] && !beritaAcaraSignaturePads['signature-ketua'].isEmpty()) {
                data.ketua_signature = beritaAcaraSignaturePads['signature-ketua'].toDataURL();
            }
            if (beritaAcaraSignaturePads['signature-anggota1'] && !beritaAcaraSignaturePads['signature-anggota1'].isEmpty()) {
                data.anggota1_signature = beritaAcaraSignaturePads['signature-anggota1'].toDataURL();
            }
            if (beritaAcaraSignaturePads['signature-anggota2'] && !beritaAcaraSignaturePads['signature-anggota2'].isEmpty()) {
                data.anggota2_signature = beritaAcaraSignaturePads['signature-anggota2'].toDataURL();
            }

            try {
                const response = await fetch(`/validator/assess/${formId}/berita-acara`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(data)
                });

                const result = await response.json();

                if (result.success) {
                    showSaveIndicator();

                    if (isFinal) {
                        document.querySelector('[data-section="berita-acara"]').classList.add('completed');
                        document.querySelector('[data-section="record"]').click();
                    }
                } else {
                    Swal.fire('Error', result.message, 'error');
                }
            } catch (error) {
                Swal.fire('Error', 'Terjadi kesalahan', 'error');
            }
        }

        document.getElementById('save-berita-acara-final')?.addEventListener('click', () => saveBeritaAcara(true));

        // Add/Remove Detail Rows
        let rowCounter = 1;

        // Initialize row counter based on existing rows
        document.querySelectorAll('#detail-tbody tr').forEach(row => {
            const rowNum = parseInt(row.dataset.row);
            if (rowNum > rowCounter) rowCounter = rowNum;
        });

        document.getElementById('add-detail-row')?.addEventListener('click', function() {
            rowCounter++;
            const tbody = document.getElementById('detail-tbody');
            const newRow = document.createElement('tr');
            newRow.dataset.row = rowCounter;
            newRow.innerHTML = `
                <td>
                    <input type="text" class="form-control form-control-sm" 
                        name="aspek_${rowCounter}" required>
                </td>
                <td>
                    <input type="text" class="form-control form-control-sm" 
                        name="aktivitas_${rowCounter}" required>
                </td>
                <td>
                    <input type="number" class="form-control form-control-sm" 
                        name="capaian_${rowCounter}" min="0" max="5" required>
                </td>
                <td>
                    <input type="text" class="form-control form-control-sm" 
                        name="keterangan_${rowCounter}" required>
                </td>
                <td>
                    <input type="text" class="form-control form-control-sm" 
                        name="catatan_${rowCounter}" required>
                </td>
                <td>
                    <button type="button" class="btn btn-sm btn-danger remove-row">
                        <i class='bx bx-trash'></i>
                    </button>
                </td>
            `;
            tbody.appendChild(newRow);
        });

        // Remove row handler (using event delegation)
        document.getElementById('detail-tbody')?.addEventListener('click', function(e) {
            if (e.target.closest('.remove-row')) {
                const row = e.target.closest('tr');
                const tbody = document.getElementById('detail-tbody');

                // Prevent removing if it's the only row
                if (tbody.children.length > 1) {
                    row.remove();
                } else {
                    Swal.fire('Perhatian', 'Minimal harus ada 1 baris detail penilaian', 'warning');
                }
            }
        });

        // Save Validator Record
        async function saveValidatorRecord(isFinal = false) {
            const form = document.getElementById('form-validator-record');
            const formData = new FormData(form);

            // Validate required fields
            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            // Add is_final flag
            formData.append('is_final', isFinal);

            try {
                const response = await fetch(`/validator/assess/${formId}/validator-record`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: formData
                });

                const result = await response.json();

                if (result.success) {
                    showSaveIndicator();

                    if (isFinal) {
                        document.querySelector('[data-section="record"]').classList.add('completed');

                        // Show submit button if not already visible
                        const submitBtn = document.getElementById('submit-final');
                        if (submitBtn) {
                            submitBtn.disabled = false;
                            submitBtn.scrollIntoView({
                                behavior: 'smooth',
                                block: 'center'
                            });
                        }
                    }
                } else {
                    Swal.fire('Error', result.message, 'error');
                }
            } catch (error) {
                Swal.fire('Error', 'Terjadi kesalahan', 'error');
            }
        }

        document.getElementById('save-record-final')?.addEventListener('click', () => saveValidatorRecord(true));

        // Submit Final
        document.getElementById('submit-final')?.addEventListener('click', async function() {
            const result = await Swal.fire({
                title: 'Submit Penilaian Final?',
                text: 'Setelah submit, Anda tidak dapat mengubah penilaian lagi',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Submit',
                cancelButtonText: 'Batal'
            });

            if (result.isConfirmed) {
                try {
                    const response = await fetch(`/validator/assess/${formId}/submit`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    });

                    const data = await response.json();

                    if (data.success) {
                        Swal.fire('Berhasil', 'Penilaian berhasil disubmit', 'success').then(() => {
                            // Use location.replace to force reload and prevent caching
                            window.location.replace('/validator');
                        });
                    } else {
                        Swal.fire('Error', data.message, 'error');
                    }
                } catch (error) {
                    Swal.fire('Error', 'Terjadi kesalahan', 'error');
                }
            }
        });

        function updateProgress() {
            const completedSections = document.querySelectorAll('.nav-btn.completed').length;
            const percentage = Math.round((completedSections / totalSections) * 100);

            document.getElementById('progress-fill').style.width = percentage + '%';
            document.getElementById('progress-percentage').textContent = percentage;
        }

        function showSaveIndicator() {
            const indicator = document.getElementById('save-indicator');
            indicator.style.display = 'block';
            setTimeout(() => {
                indicator.style.display = 'none';
            }, 2000);
        }

        // Initial progress update
        updateProgress();
    </script>

    {{-- Modal Form Judul Inovasi --}}
    @if ($form->katsinovInovasis->isNotEmpty())
        @php $inovasiInfo = $form->katsinovInovasis->first(); @endphp
        <div class="modal fade" id="modalInovasi" tabindex="-1">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title">💡 Form Judul Inovasi (Read-Only)</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                        {{-- Section 1: Informasi Inovasi --}}
                        <div class="mb-4">
                            <h6 class="text-primary border-bottom pb-2 mb-3">
                                <i class='bx bx-info-circle'></i> 1. Informasi Inovasi
                            </h6>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Judul Inovasi</label>
                                <input type="text" class="form-control" value="{{ $inovasiInfo->title ?? '-' }}"
                                    readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Sub Judul</label>
                                <input type="text" class="form-control" value="{{ $inovasiInfo->sub_title ?? '-' }}"
                                    readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Pendahuluan</label>
                                <textarea class="form-control" rows="5" readonly>{{ $inovasiInfo->introduction ?? '-' }}</textarea>
                                <small class="text-muted">Latar belakang, permasalahan, dan tujuan inovasi</small>
                            </div>
                        </div>

                        {{-- Section 2: Produk & Teknologi --}}
                        <div class="mb-4">
                            <h6 class="text-success border-bottom pb-2 mb-3">
                                <i class='bx bx-chip'></i> 2. Produk & Teknologi
                            </h6>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Produk Teknologi</label>
                                <textarea class="form-control" rows="5" readonly>{{ $inovasiInfo->tech_product ?? '-' }}</textarea>
                                <small class="text-muted">Deskripsi detail produk atau teknologi yang dihasilkan</small>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Keunggulan</label>
                                <textarea class="form-control" rows="4" readonly>{{ $inovasiInfo->supremacy ?? '-' }}</textarea>
                                <small class="text-muted">Keunggulan dan nilai tambah inovasi</small>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Status Paten/HKI</label>
                                <textarea class="form-control" rows="3" readonly>{{ $inovasiInfo->patent ?? '-' }}</textarea>
                                <small class="text-muted">Status paten atau hak kekayaan intelektual</small>
                            </div>
                        </div>

                        {{-- Section 3: Tingkat Kesiapan --}}
                        <div class="mb-4">
                            <h6 class="text-purple border-bottom pb-2 mb-3">
                                <i class='bx bx-check-circle'></i> 3. Tingkat Kesiapan
                            </h6>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Kesiapan Teknologi (TRL)</label>
                                    <textarea class="form-control" rows="4" readonly>{{ $inovasiInfo->tech_preparation ?? '-' }}</textarea>
                                    <small class="text-muted">Level 1-9, tingkat kematangan teknologi</small>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Kesiapan Pasar (MRL)</label>
                                    <textarea class="form-control" rows="4" readonly>{{ $inovasiInfo->market_preparation ?? '-' }}</textarea>
                                    <small class="text-muted">Kesiapan pasar dan calon pengguna</small>
                                </div>
                            </div>
                        </div>

                        {{-- Section 4: Kontak Person --}}
                        <div class="mb-4">
                            <h6 class="text-warning border-bottom pb-2 mb-3">
                                <i class='bx bx-user'></i> 4. Kontak Person
                            </h6>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Nama Lengkap</label>
                                    <input type="text" class="form-control" value="{{ $inovasiInfo->name ?? '-' }}"
                                        readonly>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Email</label>
                                    <input type="email" class="form-control" value="{{ $inovasiInfo->email ?? '-' }}"
                                        readonly>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold">Telepon</label>
                                    <input type="text" class="form-control" value="{{ $inovasiInfo->phone ?? '-' }}"
                                        readonly>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold">Mobile/HP</label>
                                    <input type="text" class="form-control"
                                        value="{{ $inovasiInfo->mobile ?? '-' }}" readonly>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold">Fax</label>
                                    <input type="text" class="form-control" value="{{ $inovasiInfo->fax ?? '-' }}"
                                        readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class='bx bx-x'></i> Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Modal Informasi Dasar --}}
    @if ($form->katsinovInformasis->isNotEmpty())
        @php
            $informasi = $form->katsinovInformasis->first();

            // Get collection data
            $collections = \App\Models\KatsinovInformasiCollection::where(
                'katsinov_informasi_id',
                $informasi->id,
            )->get();

            // Group by field and index
            $informasiTeam = [];
            $informasiProgram = [];
            $informasiPartner = [];
            $informasiTech = [];
            $informasiMarket = [];

            foreach ($collections as $collection) {
                $field = $collection->field;
                $index = $collection->index;
                $attribute = $collection->attribute;
                $value = $collection->value;

                if ($field == 'team') {
                    if (!isset($informasiTeam[$index])) {
                        $informasiTeam[$index] = [];
                    }
                    $informasiTeam[$index][$attribute] = $value;
                } elseif ($field == 'program_implementation') {
                    if (!isset($informasiProgram[$index])) {
                        $informasiProgram[$index] = [];
                    }
                    $informasiProgram[$index][$attribute] = $value;
                } elseif ($field == 'innovation_partner') {
                    if (!isset($informasiPartner[$index])) {
                        $informasiPartner[$index] = [];
                    }
                    $informasiPartner[$index][$attribute] = $value;
                } elseif ($field == 'information_tech') {
                    if (!isset($informasiTech[$index])) {
                        $informasiTech[$index] = [];
                    }
                    $informasiTech[$index][$attribute] = $value;
                } elseif ($field == 'information_market') {
                    if (!isset($informasiMarket[$index])) {
                        $informasiMarket[$index] = [];
                    }
                    $informasiMarket[$index][$attribute] = $value;
                }
            }
        @endphp
        <div class="modal fade" id="modalInformasi" tabindex="-1">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header bg-warning text-dark">
                        <h5 class="modal-title">📄 Form Informasi Dasar (Read-Only)</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">

                        {{-- Section 1: Informasi Inovator --}}
                        <div class="mb-4">
                            <h6 class="text-primary border-bottom pb-2 mb-3">
                                <i class='bx bx-user-circle'></i> 1. Informasi Inovator
                            </h6>

                            {{-- Subsection a --}}
                            <div class="mb-4">
                                <p class="fw-bold mb-3">a) Penanggung jawab / Pusat / Alamat Kontak / Telp / Faks</p>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Nama Penanggungjawab</label>
                                        <input type="text" class="form-control" value="{{ $informasi->pic ?? '-' }}"
                                            readonly>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Institusi</label>
                                        <input type="text" class="form-control"
                                            value="{{ $informasi->institution ?? '-' }}" readonly>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Alamat Kontak</label>
                                    <textarea class="form-control" rows="2" readonly>{{ $informasi->address ?? '-' }}</textarea>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Phone</label>
                                        <input type="text" class="form-control"
                                            value="{{ $informasi->phone ?? '-' }}" readonly>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Fax</label>
                                        <input type="text" class="form-control" value="{{ $informasi->fax ?? '-' }}"
                                            readonly>
                                    </div>
                                </div>
                            </div>

                            {{-- Subsection b --}}
                            <div class="mb-4">
                                <p class="fw-bold mb-3">b) Anggota Tim (Team Member)</p>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-sm">
                                        <thead class="table-light">
                                            <tr>
                                                <th width="50">No.</th>
                                                <th>Nama</th>
                                                <th>Keahlian</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($informasiTeam as $index => $team)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $team['name'] ?? '-' }}</td>
                                                    <td>{{ $team['skill'] ?? '-' }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="3" class="text-center text-muted">Tidak ada data tim
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        {{-- Section 2: Informasi Tentang Inovasi --}}
                        <div class="mb-4">
                            <h6 class="text-success border-bottom pb-2 mb-3">
                                <i class='bx bx-bulb'></i> 2. Informasi Tentang Inovasi Yang Dilaksanakan
                            </h6>

                            <div class="mb-3">
                                <label class="form-label fw-bold">a) Judul Inovasi</label>
                                <input type="text" class="form-control"
                                    value="{{ $informasi->innovation_title ?? '-' }}" readonly>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">b) Nama Program</label>
                                <input type="text" class="form-control"
                                    value="{{ $informasi->innovation_name ?? '-' }}" readonly>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">c) Jenis Inovasi</label>
                                <input type="text" class="form-control"
                                    value="{{ ucfirst($informasi->innovation_type ?? '-') }}" readonly>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">d) Bidang Inovasi</label>
                                <input type="text" class="form-control"
                                    value="{{ ucfirst($informasi->innovation_field ?? '-') }}" readonly>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">e) Aplikasi dan Manfaat Inovasi</label>
                                <textarea class="form-control" rows="3" readonly>{{ $informasi->innovation_application ?? '-' }}</textarea>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold">f) Pelaksanaan Program/Kegiatan</label>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Lama program yang direncanakan (tahun)</label>
                                        <input type="text" class="form-control"
                                            value="{{ $informasi->innovation_duration ?? '-' }}" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Program yang berjalan tahun ke-</label>
                                        <input type="text" class="form-control"
                                            value="{{ $informasi->innovation_year ?? '-' }}" readonly>
                                    </div>
                                </div>

                                <label class="form-label fw-bold mt-3">Sumber Pendanaan</label>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-sm">
                                        <thead class="table-light">
                                            <tr>
                                                <th width="50">No</th>
                                                <th>Tahun ke-</th>
                                                <th>Total Dana</th>
                                                <th>Sumber Dana</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($informasiProgram as $index => $program)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $program['year'] ?? '-' }}</td>
                                                    <td>{{ $program['funds'] ?? '-' }}</td>
                                                    <td>{{ $program['source'] ?? '-' }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="4" class="text-center text-muted">Tidak ada data
                                                        pendanaan</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold">g) Mitra Dalam Inovasi</label>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-sm">
                                        <thead class="table-light">
                                            <tr>
                                                <th width="50">No</th>
                                                <th>Nama Mitra</th>
                                                <th>Alamat Mitra</th>
                                                <th>Peran Mitra</th>
                                                <th>Status Kerjasama</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($informasiPartner as $index => $partner)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $partner['name'] ?? '-' }}</td>
                                                    <td>{{ $partner['address'] ?? '-' }}</td>
                                                    <td>{{ $partner['role'] ?? '-' }}</td>
                                                    <td>{{ $partner['cooperation'] ?? '-' }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center text-muted">Tidak ada data mitra
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">h) Ringkasan Inovasi</label>
                                <textarea class="form-control" rows="3" readonly>{{ $informasi->innovation_summary ?? '-' }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">i) Kebaruan dan Keunggulan Inovasi</label>
                                <div class="mb-2">
                                    <label class="form-label">Kebaruan yang ditawarkan</label>
                                    <textarea class="form-control" rows="2" readonly>{{ $informasi->innovation_novelty ?? '-' }}</textarea>
                                </div>
                                <div>
                                    <label class="form-label">Keunggulan yang membedakan</label>
                                    <textarea class="form-control" rows="2" readonly>{{ $informasi->innovation_supremacy ?? '-' }}</textarea>
                                </div>
                            </div>
                        </div>

                        {{-- Section 3: Informasi Kemajuan Inovasi --}}
                        <div class="mb-4">
                            <h6 class="text-info border-bottom pb-2 mb-3">
                                <i class='bx bx-trending-up'></i> 3. Informasi Tentang Kemajuan Inovasi
                            </h6>

                            {{-- Pengembangan Teknologi --}}
                            <div class="mb-4">
                                <p class="fw-bold mb-3">A) Pengembangan Teknologi</p>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-sm">
                                        <thead class="table-light">
                                            <tr>
                                                <th width="50">No</th>
                                                <th>Uraian</th>
                                                <th width="150">Status</th>
                                                <th>Keterangan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $techDescriptions = [
                                                    'Pengembangan prinsip dasar / Ide teknologi',
                                                    'Formulasi Konsep dan/atau aplikasi teknologi',
                                                    'Pembuatan prototipe',
                                                    'Hasil uji Prototipe dapat berfungsi baik',
                                                    'Percobaan fungsi utama prototipe dalam lingkungan yang relevan (simulasi)',
                                                    'Validasi prototipe pada lingkungan yang relevan (simulasi)',
                                                    'Validasi prototipe pada lingkungan yang sebenarnya',
                                                    'Ujicoba/demonstrasi prototipe pada lingkungan yg relevan',
                                                    'Ujicoba/demonstrasi prototipe pada lingkungan yg sebenarnya',
                                                    'Telah dimanfaatkan sesuai fungsi yang dirancang / telah teruji / proven',
                                                ];
                                            @endphp
                                            @foreach ($techDescriptions as $index => $description)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $description }}</td>
                                                    <td>
                                                        <span
                                                            class="badge bg-{{ isset($informasiTech[$index]) && $informasiTech[$index]['status'] == 'sudah' ? 'success' : 'secondary' }}">
                                                            {{ isset($informasiTech[$index]) ? ucfirst($informasiTech[$index]['status'] ?? '-') : '-' }}
                                                        </span>
                                                    </td>
                                                    <td>{{ isset($informasiTech[$index]) ? $informasiTech[$index]['explanation'] ?? '-' : '-' }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            {{-- Evolusi Pasar --}}
                            <div class="mb-4">
                                <p class="fw-bold mb-3">B) Evolusi Pasar</p>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-sm">
                                        <thead class="table-light">
                                            <tr>
                                                <th width="50">No</th>
                                                <th>Uraian</th>
                                                <th width="150">Status</th>
                                                <th>Keterangan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $marketDescriptions = [
                                                    'Kebutuhan dan permintaan pelanggan teramati',
                                                    'Pelanggan akhir teridentifikasi',
                                                    'Telah dikeluarkan rencana luncuran pasar secara rinci',
                                                    'Kebutuhan khusus dan keperluan pelanggan telah diketahui',
                                                    'Segmen, ukuran dan pangsa pasar telah diprediksi',
                                                    'Telah dikeluarkan harga dan luncuran produk',
                                                    'Posisioning pasar',
                                                    'Model bisnis ditetapkan',
                                                    'Pemasaran ditekankan pada pengenalan dengan baik para pelanggannya',
                                                    'Pesaing diidentifikasi dengan baik',
                                                    'Menggunakan kemitraan untuk memasuki pasar',
                                                    'Diferensiasi produk',
                                                    'Menyediakan pelayanan dan solusi',
                                                    'Dilakukan review secara periodik',
                                                    'Penyempurnaan model bisnis',
                                                    'Menggunakan kemitraan untuk berkompetisi',
                                                    'Penurunan pasar telah dikonfirmasi',
                                                    'Riset pasar untuk persetujuan inovasi ulang atau meninggalkannya',
                                                    'Review permintaan pasar',
                                                    'Identifikasi peluang tumbuhnya pasar atau ekspansi pasar baru',
                                                ];
                                            @endphp
                                            @foreach ($marketDescriptions as $index => $description)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $description }}</td>
                                                    <td>
                                                        <span
                                                            class="badge bg-{{ isset($informasiMarket[$index]) && $informasiMarket[$index]['status'] == 'sudah' ? 'success' : 'secondary' }}">
                                                            {{ isset($informasiMarket[$index]) ? ucfirst($informasiMarket[$index]['status'] ?? '-') : '-' }}
                                                        </span>
                                                    </td>
                                                    <td>{{ isset($informasiMarket[$index]) ? $informasiMarket[$index]['explanation'] ?? '-' : '-' }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class='bx bx-x'></i> Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <script>
    // Load score descriptions for tooltips
    const validatorScoreDescriptions = @json($scoreDescriptions ?? []);
    
    // Track currently open tooltip
    let currentOpenValidatorTooltip = null;
    
    // Function to show validator score tooltip
    function showValidatorScoreTooltip(indicator, rowNum, score, buttonElement) {
        // Close any previously open tooltip (auto-close feature)
        if (currentOpenValidatorTooltip && currentOpenValidatorTooltip !== `${indicator}-${rowNum}`) {
            const prevTooltip = document.getElementById(`validator-tooltip-${currentOpenValidatorTooltip}`);
            if (prevTooltip) {
                prevTooltip.style.display = 'none';
            }
        }
        
        // Get the tooltip elements
        const tooltipDiv = document.getElementById(`validator-tooltip-${indicator}-${rowNum}`);
        const scoreBadge = document.getElementById(`validator-tooltip-score-badge-${indicator}-${rowNum}`);
        const descElement = document.getElementById(`validator-tooltip-desc-${indicator}-${rowNum}`);
        
        if (!tooltipDiv || !scoreBadge || !descElement) {
            console.error('Tooltip elements not found for', indicator, rowNum);
            return;
        }
        
        // Get the description for this score
        const description = validatorScoreDescriptions[indicator]?.[rowNum]?.[score] || 'Deskripsi tidak tersedia';
        
        // Update tooltip content
        scoreBadge.textContent = score;
        descElement.textContent = description;
        
        // Update badge color based on score
        scoreBadge.className = 'd-inline-flex align-items-center justify-content-center rounded-circle text-white fw-bold';
        scoreBadge.style.width = '40px';
        scoreBadge.style.height = '40px';
        scoreBadge.style.fontSize = '18px';
        
        if (score === 0) {
            scoreBadge.classList.add('bg-danger');
        } else if (score === 5) {
            scoreBadge.classList.add('bg-success');
        } else {
            scoreBadge.classList.add('bg-primary');
        }
        
        // Show the tooltip
        tooltipDiv.style.display = 'block';
        
        // Update current open tooltip tracker
        currentOpenValidatorTooltip = `${indicator}-${rowNum}`;
        
        // Scroll to tooltip smoothly
        setTimeout(() => {
            tooltipDiv.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }, 100);
    }
    
    // Function to hide validator score tooltip
    function hideValidatorScoreTooltip(indicator, rowNum) {
        const tooltipDiv = document.getElementById(`validator-tooltip-${indicator}-${rowNum}`);
        if (tooltipDiv) {
            tooltipDiv.style.display = 'none';
        }
        
        // Clear current open tooltip tracker if this was the open one
        if (currentOpenValidatorTooltip === `${indicator}-${rowNum}`) {
            currentOpenValidatorTooltip = null;
        }
    }
    </script>
@endsection
