@extends('admin.admin')

@section('contentadmin')
<!-- CSS Files -->
<link href="{{ asset('aspect-analysis.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('inovasi/dashboard/form_katsinov/css/form.css') }}">

<!-- Alpine.js x-cloak style -->
<style>
    [x-cloak] { display: none !important; }
</style>

<!-- Scripts -->
<script src="{{ asset('aspect-legend.js') }}"></script>
<script src="{{ asset('aspect-analysis-integrated.js') }}"></script>
<script src="{{ asset('spiderweb-chart-script.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

<div x-data="aspectLegend()" x-init="init()">
    <div class="head-title">
        <div class="left">
            <h1>KATSINOV Measurement</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="#">Dashboard</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a class="active" href="#">Innovation Readiness Level</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="table-data">
        <div class="order">
            <div class="head">
                <h3>PENGUKURAN TINGKAT KESIAPAN INOVASI (KATSINOV)</h3>
            </div>

            <form id="katsinovForm" method="POST" action="{{ route('katsinov.store') }}" class="mb-4">
                @csrf
                
                <!-- Explanation Card -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h4>Penjelasan KATSINOV</h4>
                    </div>
                    <div class="card-body">
                        <p>
                            <strong>IRL-Meter (Innovation Readiness Level - Meter)</strong> atau
                            <strong>KATSINOV-Meter (Tingkat Kesiapan Inovasi - Meter)</strong>
                            adalah sebuah alat ukur yang digunakan untuk mengukur tingkat kesiapan atau kematangan
                            inovasi yang dilakukan oleh suatu perusahaan dan/atau proyek/program/kegiatan.
                            KATSINOV-Meter menggunakan pendekatan siklus hidup inovasi, dimana dapat menggambarkan
                            perkembangan inovasi.
                        </p>

                        <p>
                            Kerangka konseptual IRL adalah model <strong>6"C" (Concept, Component,
                            Completion, Chasin, Competition, Changeover/ Closedown)</strong>, yang memisahkan secara
                            komprehensif siklus hidup inovasi ke dalam 6 fase (tingkat kesiapan), dan memberikan
                            arah bagi manajemen dalam melaksanakan proses inovasi dengan memperhatikan 7 aspek
                            kunci (teknologi, pasar, organisasi, manufaktur, investment, kemitraan dan risiko).
                        </p>

                        <p>Pengukuran IRL sangat penting untuk:</p>
                        <ul class="list-group mb-3">
                            <li class="list-group-item">Menggambarkan perkembangan inovasi</li>
                            <li class="list-group-item">Membantu mengimplementasikan inovasi diatas siklus-hidup yang lebih efektif</li>
                            <li class="list-group-item">Mengantisipasi persaingan pasar yang semakin sengit</li>
                            <li class="list-group-item">Mengantisipasi tingkat inovasi atau siklus hidup teknologi yang lebih cepat</li>
                        </ul>
                    </div>
                </div>

                <!-- Basic Information Form -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h4>Informasi Dasar</h4>
                    </div>
                    <div class="card-body">
                        <div class="mb-3 text-center">
                            <span class="badge bg-secondary">No: 20190802-001</span>
                        </div>

                        <div class="row mb-3">
                            <label class="col-md-3 form-label">Nama/Judul</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="title" placeholder="Masukkan nama/judul" value="{{ $katsinov['title'] ?? '' }}">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-md-3 form-label">Fokus Bidang</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="focus_area" placeholder="Masukkan fokus bidang" value="{{ $katsinov['focus_area'] ?? '' }}">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-md-3 form-label">Nama Proyek</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="project_name" placeholder="Masukkan nama proyek" value="{{ $katsinov['project_name'] ?? '' }}">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-md-3 form-label">Nama Lembaga/Perusahaan</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="institution" placeholder="Masukkan nama lembaga/perusahaan" value="{{ $katsinov['institution'] ?? '' }}">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-md-3 form-label">Alamat</label>
                            <div class="col-md-9">
                                <textarea class="form-control" name="address" placeholder="Masukkan alamat lengkap" rows="2">{{ $katsinov['address'] ?? '' }}</textarea>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-md-3 form-label">Kontak</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="contact" placeholder="Telp / Fax / email" value="{{ $katsinov['contact'] ?? '' }}">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-md-3 form-label">Tanggal</label>
                            <div class="col-md-9">
                                <input type="date" id="assessment_date" name="assessment_date"
                                    class="form-control @error('assessment_date') border-red-500 @enderror"
                                    value="{{ old('assessment_date', isset($katsinov['assessment_date']) ? $katsinov['assessment_date'] : date('Y-m-d')) }}" required>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Capaian Criteria -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h4>Kriteria Capaian</h4>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="d-flex justify-content-between p-3 bg-light rounded">
                                    <span class="fw-bold">Batas Minimum Capaian</span>
                                    <span class="badge bg-primary px-3 py-2">80.0%</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex justify-content-between p-3 bg-light rounded">
                                    <span class="fw-bold">Batas Maksimum Capaian</span>
                                    <span class="badge bg-success px-3 py-2">100.0%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Aspect Legend -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h4>Keterangan Aspek</h4>
                    </div>
                    <div class="card-body">
                        <!-- Aspect Cards -->
                        <div class="row">
                            <!-- Teknologi -->
                            <div class="col-md-4 col-sm-6 mb-3">
                                <div class="aspect-dropdown" x-data="{ isOpen: false, aspectCode: 'T' }">
                                    <div class="card h-100 cursor-pointer" @click="isOpen = !isOpen; if(isOpen) initializeAspectChart(aspectCode)">
                                        <div class="card-body d-flex align-items-center justify-content-between">
                                            <div class="d-flex align-items-center">
                                                <div class="legend-box me-2" style="background: linear-gradient(135deg, #fad961 0%, #f76b1c 100%);"></div>
                                                <span>Aspek Teknologi (T)</span>
                                            </div>
                                            <i class="bx" :class="isOpen ? 'bx-chevron-up' : 'bx-chevron-down'"></i>
                                        </div>
                                    </div>
                                    <div x-show="isOpen" x-transition class="mt-2">
                                        <div class="chart-container" style="height: 300px;">
                                            <canvas id="aspectChart-T"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Organisasi -->
                            <div class="col-md-4 col-sm-6 mb-3">
                                <div class="aspect-dropdown" x-data="{ isOpen: false, aspectCode: 'O' }">
                                    <div class="card h-100 cursor-pointer" @click="isOpen = !isOpen; if(isOpen) initializeAspectChart(aspectCode)">
                                        <div class="card-body d-flex align-items-center justify-content-between">
                                            <div class="d-flex align-items-center">
                                                <div class="legend-box me-2" style="background: linear-gradient(135deg, #84fab0 0%, #8fd3f4 100%);"></div>
                                                <span>Aspek Organisasi (O)</span>
                                            </div>
                                            <i class="bx" :class="isOpen ? 'bx-chevron-up' : 'bx-chevron-down'"></i>
                                        </div>
                                    </div>
                                    <div x-show="isOpen" x-transition class="mt-2">
                                        <div class="chart-container" style="height: 300px;">
                                            <canvas id="aspectChart-O"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Risiko -->
                            <div class="col-md-4 col-sm-6 mb-3">
                                <div class="aspect-dropdown" x-data="{ isOpen: false, aspectCode: 'R' }">
                                    <div class="card h-100 cursor-pointer" @click="isOpen = !isOpen; if(isOpen) initializeAspectChart(aspectCode)">
                                        <div class="card-body d-flex align-items-center justify-content-between">
                                            <div class="d-flex align-items-center">
                                                <div class="legend-box me-2" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);"></div>
                                                <span>Aspek Risiko (R)</span>
                                            </div>
                                            <i class="bx" :class="isOpen ? 'bx-chevron-up' : 'bx-chevron-down'"></i>
                                        </div>
                                    </div>
                                    <div x-show="isOpen" x-transition class="mt-2">
                                        <div class="chart-container" style="height: 300px;">
                                            <canvas id="aspectChart-R"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Pasar -->
                            <div class="col-md-4 col-sm-6 mb-3">
                                <div class="aspect-dropdown" x-data="{ isOpen: false, aspectCode: 'M' }">
                                    <div class="card h-100 cursor-pointer" @click="isOpen = !isOpen; if(isOpen) initializeAspectChart(aspectCode)">
                                        <div class="card-body d-flex align-items-center justify-content-between">
                                            <div class="d-flex align-items-center">
                                                <div class="legend-box me-2" style="background: linear-gradient(135deg, #ff9a9e 0%, #fad0c4 100%);"></div>
                                                <span>Aspek Pasar (M)</span>
                                            </div>
                                            <i class="bx" :class="isOpen ? 'bx-chevron-up' : 'bx-chevron-down'"></i>
                                        </div>
                                    </div>
                                    <div x-show="isOpen" x-transition class="mt-2">
                                        <div class="chart-container" style="height: 300px;">
                                            <canvas id="aspectChart-M"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Kemitraan -->
                            <div class="col-md-4 col-sm-6 mb-3">
                                <div class="aspect-dropdown" x-data="{ isOpen: false, aspectCode: 'P' }">
                                    <div class="card h-100 cursor-pointer" @click="isOpen = !isOpen; if(isOpen) initializeAspectChart(aspectCode)">
                                        <div class="card-body d-flex align-items-center justify-content-between">
                                            <div class="d-flex align-items-center">
                                                <div class="legend-box me-2" style="background: linear-gradient(135deg, #ffd1ff 0%, #fab2ff 100%);"></div>
                                                <span>Aspek Kemitraan (P)</span>
                                            </div>
                                            <i class="bx" :class="isOpen ? 'bx-chevron-up' : 'bx-chevron-down'"></i>
                                        </div>
                                    </div>
                                    <div x-show="isOpen" x-transition class="mt-2">
                                        <div class="chart-container" style="height: 300px;">
                                            <canvas id="aspectChart-P"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Manufaktur -->
                            <div class="col-md-4 col-sm-6 mb-3">
                                <div class="aspect-dropdown" x-data="{ isOpen: false, aspectCode: 'Mf' }">
                                    <div class="card h-100 cursor-pointer" @click="isOpen = !isOpen; if(isOpen) initializeAspectChart(aspectCode)">
                                        <div class="card-body d-flex align-items-center justify-content-between">
                                            <div class="d-flex align-items-center">
                                                <div class="legend-box me-2" style="background: linear-gradient(135deg, #f6d365 0%, #fda085 100%);"></div>
                                                <span>Aspek Manufaktur (Mf)</span>
                                            </div>
                                            <i class="bx" :class="isOpen ? 'bx-chevron-up' : 'bx-chevron-down'"></i>
                                        </div>
                                    </div>
                                    <div x-show="isOpen" x-transition class="mt-2">
                                        <div class="chart-container" style="height: 300px;">
                                            <canvas id="aspectChart-Mf"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Investasi -->
                            <div class="col-md-4 col-sm-6 mb-3">
                                <div class="aspect-dropdown" x-data="{ isOpen: false, aspectCode: 'I' }">
                                    <div class="card h-100 cursor-pointer" @click="isOpen = !isOpen; if(isOpen) initializeAspectChart(aspectCode)">
                                        <div class="card-body d-flex align-items-center justify-content-between">
                                            <div class="d-flex align-items-center">
                                                <div class="legend-box me-2" style="background: linear-gradient(135deg, #96fbc4 0%, #f9f586 100%);"></div>
                                                <span>Aspek Investasi (I)</span>
                                            </div>
                                            <i class="bx" :class="isOpen ? 'bx-chevron-up' : 'bx-chevron-down'"></i>
                                        </div>
                                    </div>
                                    <div x-show="isOpen" x-transition class="mt-2">
                                        <div class="chart-container" style="height: 300px;">
                                            <canvas id="aspectChart-I"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Spiderweb Analysis Button & Content -->
                        <div class="text-center mt-4" x-data="{ showSpiderwebContent: false }">
                            <button type="button" @click="showSpiderwebContent = !showSpiderwebContent" class="btn btn-primary px-4 py-2">
                                <i class="bx" :class="showSpiderwebContent ? 'bx-chevron-up' : 'bx-chevron-down'"></i>
                                Lihat Analisis Spiderweb
                            </button>
                            
                            <div x-show="showSpiderwebContent" x-transition class="mt-4">
                                <div class="chart-container" style="height: 400px;">
                                    <canvas id="spiderwebChart"></canvas>
                                </div>
                                
                                <div class="spiderweb-summary mt-4">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <strong>Rata-rata Pencapaian:</strong>
                                            <span class="rata-rata-pencapaian">0.0%</span>
                                        </div>
                                        <div class="col-md-4">
                                            <strong>Aspek Terpenuhi:</strong>
                                            <span class="aspek-terpenuhi">0 dari 7</span>
                                        </div>
                                        <div class="col-md-4">
                                            <strong>Status Keseluruhan:</strong>
                                            <span class="status-keseluruhan">Belum Terpenuhi</span>
                                        </div>
                                    </div>
                                    
                                    <div class="katsinov-indicator mt-3">
                                        <strong>Level KATSINOV:</strong>
                                        <span class="value">0</span>
                                        <p class="description text-muted">KATSINOV yang dicapai adalah = KATSINOV 0 (belum ada yang terpenuhi)</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>   
                        
                <!-- KATSINOV Indicators Section -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h4>Indikator KATSINOV</h4>
                    </div>
                    <div class="card-body">
                        <div class="indicators-wrapper">
                            <!-- Indikator 1 -->
                            <div class="indicator-card" data-indicator="1">
                                <h4 class="indicator-header"></h4>
                                <div class="mt-3">
                                    @include('admin.katsinov.indikator1')
                                </div>
                            </div>

                            <!-- Indikator 2 -->
                            <div class="indicator-card" data-indicator="2">
                                <h4 class="indicator-header"></h4>
                                <div class="mt-3">
                                    @include('admin.katsinov.indikator2')
                                </div>
                            </div>

                            <!-- Indikator 3 -->
                            <div class="indicator-card" data-indicator="3">
                                <h4 class="indicator-header"></h4>
                                <div class="mt-3">
                                    @include('admin.katsinov.indikator3')
                                </div>
                            </div>

                            <!-- Indikator 4 -->
                            <div class="indicator-card" data-indicator="4">
                                <h4 class="indicator-header"></h4>
                                <div class="mt-3">
                                    @include('admin.katsinov.indikator4')
                                </div>
                            </div>

                            <!-- Indikator 5 -->
                            <div class="indicator-card" data-indicator="5">
                                <h4 class="indicator-header"></h4>
                                <div class="mt-3">
                                    @include('admin.katsinov.indikator5')
                                </div>
                            </div>

                            <!-- Indikator 6 -->
                            <div class="indicator-card" data-indicator="6">
                                <h4 class="indicator-header"></h4>
                                <div class="mt-3">
                                    @include('admin.katsinov.indikator6')
                                </div>
                            </div>
                        </div>

                        <!-- KATSINOV Summary -->
                        <div class="card mb-4 mt-4">
                            <div class="card-header bg-primary text-white">
                                <h5 class="m-0">KATSINOV Summary</h5>
                            </div>
                            <div class="card-body">
                                @include('admin.katsinov.jumlahindikator')
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit All Button -->
                <div class="submit-all-container" style="display: flex;justify-content: center;margin-top: 2rem;margin-bottom: 2rem;">
                    <button type="button" id="submitAllBtn" class="submit-all-btn"
                        style="
                            background-color: #176369;
                            color: white;
                            padding: 12px 24px;
                            border: none;
                            border-radius: 8px;
                            font-size: 1rem;
                            font-weight: 600;
                            cursor: pointer;
                            transition: all 0.3s ease;
                            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
                        "
                        onclick="submitAllIndicators(event)">
                        @if (!isset($katsinov) || empty($katsinov))
                        Submit Semua Indikator KATSINOV
                        @else
                        Update Indikator KATSINOV
                        @endif
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="{{ asset('inovasi/dashboard/form_katsinov/js/form.js') }}"></script>

@endsection