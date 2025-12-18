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
            {{-- Section 1: Informasi Inovasi --}}
            <div class="mb-4">
                <h6 class="text-primary border-bottom pb-2 mb-3">
                    <i class='bx bx-info-circle'></i> 1. Informasi Inovasi
                </h6>
                <div class="mb-3">
                    <label class="form-label fw-bold">Judul Inovasi</label>
                    <input type="text" class="form-control" value="{{ $inovasiInfo->title ?? '-' }}" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Sub Judul</label>
                    <input type="text" class="form-control" value="{{ $inovasiInfo->sub_title ?? '-' }}" readonly>
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
                        <input type="text" class="form-control" value="{{ $inovasiInfo->name ?? '-' }}" readonly>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Email</label>
                        <input type="email" class="form-control" value="{{ $inovasiInfo->email ?? '-' }}" readonly>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Telepon</label>
                        <input type="text" class="form-control" value="{{ $inovasiInfo->phone ?? '-' }}" readonly>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Mobile/HP</label>
                        <input type="text" class="form-control" value="{{ $inovasiInfo->mobile ?? '-' }}" readonly>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Fax</label>
                        <input type="text" class="form-control" value="{{ $inovasiInfo->fax ?? '-' }}" readonly>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- Informasi Dasar --}}
    @if($informasi)
    @php
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

    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-warning text-dark">
            <h4 class="m-0">📄 Form Informasi Dasar</h4>
        </div>
        <div class="card-body">
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
                            <input type="text" class="form-control" value="{{ $informasi->pic ?? '-' }}" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Institusi</label>
                            <input type="text" class="form-control" value="{{ $informasi->institution ?? '-' }}" readonly>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Alamat Kontak</label>
                        <textarea class="form-control" rows="2" readonly>{{ $informasi->address ?? '-' }}</textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Phone</label>
                            <input type="text" class="form-control" value="{{ $informasi->phone ?? '-' }}" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Fax</label>
                            <input type="text" class="form-control" value="{{ $informasi->fax ?? '-' }}" readonly>
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
                                        <td colspan="3" class="text-center text-muted">Tidak ada data tim</td>
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
                    <input type="text" class="form-control" value="{{ $informasi->innovation_title ?? '-' }}" readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">b) Nama Program</label>
                    <input type="text" class="form-control" value="{{ $informasi->innovation_name ?? '-' }}" readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">c) Jenis Inovasi</label>
                    <input type="text" class="form-control" value="{{ ucfirst($informasi->innovation_type ?? '-') }}" readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">d) Bidang Inovasi</label>
                    <input type="text" class="form-control" value="{{ ucfirst($informasi->innovation_field ?? '-') }}" readonly>
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
                            <input type="text" class="form-control" value="{{ $informasi->innovation_duration ?? '-' }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Program yang berjalan tahun ke-</label>
                            <input type="text" class="form-control" value="{{ $informasi->innovation_year ?? '-' }}" readonly>
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
                                        <td colspan="4" class="text-center text-muted">Tidak ada data pendanaan</td>
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
                                        <td colspan="5" class="text-center text-muted">Tidak ada data mitra</td>
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
                                            <span class="badge bg-{{ isset($informasiTech[$index]) && $informasiTech[$index]['status'] == 'sudah' ? 'success' : 'secondary' }}">
                                                {{ isset($informasiTech[$index]) ? ucfirst($informasiTech[$index]['status'] ?? '-') : '-' }}
                                            </span>
                                        </td>
                                        <td>{{ isset($informasiTech[$index]) ? $informasiTech[$index]['explanation'] ?? '-' : '-' }}</td>
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
                                            <span class="badge bg-{{ isset($informasiMarket[$index]) && $informasiMarket[$index]['status'] == 'sudah' ? 'success' : 'secondary' }}">
                                                {{ isset($informasiMarket[$index]) ? ucfirst($informasiMarket[$index]['status'] ?? '-') : '-' }}
                                            </span>
                                        </td>
                                        <td>{{ isset($informasiMarket[$index]) ? $informasiMarket[$index]['explanation'] ?? '-' : '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
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
