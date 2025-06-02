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

{{-- <script src="{{ asset('aspect-legend.js') }}"></script>
<script src="{{ asset('aspect-analysis-integrated.js') }}"></script> --}}
{{-- <script src="{{ asset('spiderweb-chart-script.js') }}"></script> --}}
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
{{-- buat print --}}
    {{-- <div class="d-flex justify-content-end mb-3">
        <button type="button" onclick="window.print()" class="btn btn-info">
            <i class='bx bx-printer'></i> Print Form
        </button>
    </div> --}}

    <div class="table-data">
        <div class="order">
            <div class="head">
                <h3>PENGUKURAN TINGKAT KESIAPAN INOVASI (KATSINOV)</h3>
            </div>

            <form id="katsinovForm" method="POST" action="{{ route('katsinov.store') }}" class="mb-4">
                @csrf
                @if(isset($katsinov) && !empty($katsinov->id))
                    <input type="hidden" name="id" value="{{ $katsinov->id }}">
                @endif
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
                        <!-- <div class="mb-3 text-center">
                            <span class="badge bg-secondary">No: 20190802-001</span>
                        </div> -->

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
                                    value="{{ old('assessment_date', isset($katsinov['assessment_date']) ? \Carbon\Carbon::parse($katsinov['assessment_date'])->format('Y-m-d') : date('Y-m-d')) }}" required>
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
                
                        <!-- Aspect Cards -->
                        <div class="row">
                            <!-- Teknologi -->
                            <div class="col-md-6 col-sm-6 mb-3">
                                <div class="aspect-dropdown" x-data="{ isOpen: false, aspectCode: 'T' }">
                                    <div class="card h-100 cursor-pointer">
                                        <div class="card-body d-flex align-items-center justify-content-between">
                                            <div class="d-flex align-items-center">
                                                <div class="legend-box me-2" style="background: linear-gradient(135deg, #fad961 0%, #f76b1c 100%);"></div>
                                                <span>Aspek Teknologi (T)</span>
                                            </div>
                                            
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
                            <div class="col-md-6 col-sm-6 mb-3">
                                <div class="aspect-dropdown" x-data="{ isOpen: false, aspectCode: 'O' }">
                                    <div class="card h-100 cursor-pointer">
                                        <div class="card-body d-flex align-items-center justify-content-between">
                                            <div class="d-flex align-items-center">
                                                <div class="legend-box me-2" style="background: linear-gradient(135deg, #84fab0 0%, #8fd3f4 100%);"></div>
                                                <span>Aspek Organisasi (O)</span>
                                            </div>
                                            
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
                            <div class="col-md-6 col-sm-6 mb-3">
                                <div class="aspect-dropdown" x-data="{ isOpen: false, aspectCode: 'R' }">
                                    <div class="card h-100 cursor-pointer">
                                        <div class="card-body d-flex align-items-center justify-content-between">
                                            <div class="d-flex align-items-center">
                                                <div class="legend-box me-2" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);"></div>
                                                <span>Aspek Risiko (R)</span>
                                            </div>
                                            
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
                            <div class="col-md-6 col-sm-6 mb-3">
                                <div class="aspect-dropdown" x-data="{ isOpen: false, aspectCode: 'M' }">
                                    <div class="card h-100 cursor-pointer">
                                        <div class="card-body d-flex align-items-center justify-content-between">
                                            <div class="d-flex align-items-center">
                                                <div class="legend-box me-2" style="background: linear-gradient(135deg, #ff9a9e 0%, #fad0c4 100%);"></div>
                                                <span>Aspek Pasar (M)</span>
                                            </div>
                                            
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
                            <div class="col-md-6 col-sm-6 mb-3">
                                <div class="aspect-dropdown" x-data="{ isOpen: false, aspectCode: 'P' }">
                                    <div class="card h-100 cursor-pointer">
                                        <div class="card-body d-flex align-items-center justify-content-between">
                                            <div class="d-flex align-items-center">
                                                <div class="legend-box me-2" style="background: linear-gradient(135deg, #ffd1ff 0%, #fab2ff 100%);"></div>
                                                <span>Aspek Kemitraan (P)</span>
                                            </div>
                                            
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
                            <div class="col-md-6 col-sm-6 mb-3">
                                <div class="aspect-dropdown" x-data="{ isOpen: false, aspectCode: 'Mf' }">
                                    <div class="card h-100 cursor-pointer">
                                        <div class="card-body d-flex align-items-center justify-content-between">
                                            <div class="d-flex align-items-center">
                                                <div class="legend-box me-2" style="background: linear-gradient(135deg, #f6d365 0%, #fda085 100%);"></div>
                                                <span>Aspek Manufaktur (Mf)</span>
                                            </div>
                                            
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
                            <div class="col-md-6 col-sm-6 mb-3">
                                <div class="aspect-dropdown" x-data="{ isOpen: false, aspectCode: 'I' }">
                                    <div class="card h-100 cursor-pointer">
                                        <div class="card-body d-flex align-items-center justify-content-between">
                                            <div class="d-flex align-items-center">
                                                <div class="legend-box me-2" style="background: linear-gradient(135deg, #96fbc4 0%, #f9f586 100%);"></div>
                                                <span>Aspek Investasi (I)</span>
                                            </div>
                                            
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

                        {{-- <!-- Spiderweb Analysis Button & Content -->
                        <div class="text-center mt-5" x-data="{ showSpiderwebContent: false }">
                            <button type="button" 
                                    @click="showSpiderwebContent = !showSpiderwebContent" 
                                    class="btn btn-primary rounded-pill px-5 py-2 shadow-sm d-flex align-items-center justify-content-center mx-auto">
                                <i class="bx me-2" :class="showSpiderwebContent ? 'bx-chart' : 'bx-chart'"></i>
                                <span>Lihat Analisis Spiderweb</span>
                                <i class="bx ms-2" :class="showSpiderwebContent ? 'bx-chevron-up' : 'bx-chevron-down'"></i>
                            </button>
                            
                            <div x-show="showSpiderwebContent" 
                                x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="opacity-0 transform -translate-y-4"
                                x-transition:enter-end="opacity-100 transform translate-y-0"
                                x-transition:leave="transition ease-in duration-300"
                                x-transition:leave-start="opacity-100 transform translate-y-0"
                                x-transition:leave-end="opacity-0 transform -translate-y-4"
                                class="mt-4 bg-gradient p-4 rounded-lg shadow-sm" style="background: linear-gradient(to bottom right, #f8f9fa, #e9ecef);">
                                
                                <div class="chart-container position-relative mx-auto bg-white p-3 rounded shadow-sm" style="height: 400px; max-width: 800px;">
                                    <canvas id="spiderwebChart"></canvas>
                                </div>
                                
                                <div class="spiderweb-summary mt-4 px-2">
                                    <div class="row g-4 justify-content-center">
                                        <div class="col-md-4">
                                            <div class="card h-100 border-0 shadow-sm" style="background-color: #f0f8ff;">
                                                <div class="card-body">
                                                    <div class="d-flex flex-column">
                                                        <strong class="text-primary mb-2">Rata-rata Pencapaian:</strong>
                                                        <span class="rata-rata-pencapaian fs-4">0.0%</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-4">
                                            <div class="card h-100 border-0 shadow-sm" style="background-color: #f0fff0;">
                                                <div class="card-body">
                                                    <div class="d-flex flex-column">
                                                        <strong class="text-success mb-2">Katsinov Terpenuhi:</strong>
                                                        <span class="aspek-terpenuhi fs-4">0 dari 7</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-4">
                                            <div class="card h-100 border-0 shadow-sm" style="background-color: #fff0f5;">
                                                <div class="card-body">
                                                    <div class="d-flex flex-column">
                                                        <strong class="text-danger mb-2">Status Keseluruhan:</strong>
                                                        <span class="status-keseluruhan fs-4">Belum Terpenuhi</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="katsinov-indicator mt-4">
                                        <div class="card border-0 shadow-sm" style="background: linear-gradient(to right, #f5f7fa, #e6f0ff);">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <strong class="text-primary fs-5">Level KATSINOV:</strong>
                                                    <span class="value bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; font-size: 1.5rem; font-weight: bold;">0</span>
                                                </div>
                                                <p class="description text-muted mt-3 mb-0">KATSINOV yang dicapai adalah = KATSINOV 0 (belum ada yang terpenuhi)</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                
                </div>   
                        
                <!-- KATSINOV Indicators Section -->
                <div class="card mb-4">

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
{{-- <script>
    // Check if the URL contains a print parameter and trigger printing if it does
    document.addEventListener('DOMContentLoaded', function() {
        if (window.location.search.includes('print=true')) {
            // Wait for all content and charts to load
            setTimeout(function() {
                // Force expand all collapsed elements before printing
                // document.querySelectorAll('.aspect-dropdown').forEach(function(dropdown) {
                //     var isOpen = dropdown.querySelector('[x-data]').__x.$data.isOpen;
                //     if (!isOpen) {
                //         dropdown.querySelector('.card-body').click();
                //     }
                // });

                // Force show the spiderweb analysis
                if (document.querySelector('[x-data="{ showSpiderwebContent: false }"]')) {
                    document.querySelector('[x-data="{ showSpiderwebContent: false }"]').__x.$data
                        .showSpiderwebContent = true;
                }

                // Trigger printing after a delay to ensure content is expanded and rendered
                setTimeout(function() {
                    window.print();
                }, 1000);
            }, 1500);
        }
    });
</script> --}}
{{-- <script>
    // Function to force all Alpine.js components to expand
    function forceExpandAllContent() {
        console.log('Forcibly expanding all content for printing...');

        // 1. Manually add 'show' class to all potential Bootstrap collapse elements 
        document.querySelectorAll('.collapse').forEach(function(el) {
            el.classList.add('show');
        });

        // 2. Force Alpine.js states to expanded state
        if (typeof window.Alpine !== 'undefined') {
            // Wait for Alpine to be fully initialized
            setTimeout(() => {
                document.querySelectorAll('[x-data]').forEach(function(el) {
                    if (el.__x && el.__x.$data) {
                        // Force common toggle properties to be open
                        if ('isOpen' in el.__x.$data) el.__x.$data.isOpen = true;
                        if ('showSpiderwebContent' in el.__x.$data) el.__x.$data.showSpiderwebContent =
                            true;
                        if ('show' in el.__x.$data) el.__x.$data.show = true;
                        if ('open' in el.__x.$data) el.__x.$data.open = true;
                        if ('expanded' in el.__x.$data) el.__x.$data.expanded = true;
                        if ('visible' in el.__x.$data) el.__x.$data.visible = true;
                    }
                });

                console.log('Alpine.js components expanded');
            }, 500);
        }

        // 3. Initialize all aspect charts
        if (typeof initializeAspectChart === 'function') {
            ['T', 'O', 'R', 'M', 'P', 'Mf', 'I'].forEach(function(aspect) {
                try {
                    initializeAspectChart(aspect);
                    console.log('Initialized chart for aspect:', aspect);
                } catch (e) {
                    console.error('Error initializing aspect chart:', aspect, e);
                }
            });
        }

        // 4. Initialize spiderweb chart if exists
        if (document.getElementById('spiderwebChart') && typeof initSpiderwebChart === 'function') {
            try {
                initSpiderwebChart();
                console.log('Initialized spiderweb chart');
            } catch (e) {
                console.error('Error initializing spiderweb chart:', e);
            }
        }

        // 5. Make sure all indicator cards are fully visible
        document.querySelectorAll('.indicator-card').forEach(function(card, index) {
            card.style.display = 'block';
            card.style.visibility = 'visible';
            card.style.height = 'auto';
            card.style.overflow = 'visible';
            console.log('Expanded indicator card:', index + 1);
        });

        // 6. Force aspect dropdowns open
        // document.querySelectorAll('.aspect-dropdown').forEach(function(dropdown) {
        //     const contentDiv = dropdown.querySelector('.mt-2');
        //     if (contentDiv) {
        //         contentDiv.style.display = 'block';
        //         contentDiv.style.visibility = 'visible';
        //         contentDiv.style.height = 'auto';
        //         contentDiv.style.overflow = 'visible';
        //     }
        // });

        // 7. Make sure chart containers are visible
        document.querySelectorAll('.chart-container').forEach(function(container) {
            container.style.display = 'block';
            container.style.visibility = 'visible';
            container.style.height = '300px';
        });
    }

    // Auto-print when page loads with print parameter
    document.addEventListener('DOMContentLoaded', function() {
        if (window.location.search.includes('print=true')) {
            console.log('Print mode detected, preparing full content display...');

            // Give time for the page to fully load, then expand content
            setTimeout(function() {
                forceExpandAllContent();

                // Allow time for charts to render completely
                setTimeout(function() {
                    console.log('Printing page with all content expanded...');
                    window.print();
                }, 2500);
            }, 1000);
        }
    });

    // Add click handler to print button for manual printing
    document.addEventListener('DOMContentLoaded', function() {
        const printButton = document.querySelector('button[onclick="window.print()"]');
        if (printButton) {
            // Override the default print behavior
            printButton.onclick = function(e) {
                e.preventDefault();
                forceExpandAllContent();

                // Allow time for content to expand
                setTimeout(function() {
                    window.print();
                }, 1500);
            };
        }
    });
</script> --}}

{{-- <script>
    function aspectLegend() {
        return {
            init() {
                // Your existing init code...

                // Add this additional function to initialize all charts at once
                this.initAllCharts = function() {
                    console.log('Initializing all aspect charts for printing...');
                    const aspectCodes = ['T', 'O', 'R', 'M', 'P', 'Mf', 'I'];

                    aspectCodes.forEach(code => {
                        const chartId = `aspectChart-${code}`;
                        const canvas = document.getElementById(chartId);

                        if (canvas) {
                            // Make sure canvas is visible
                            const container = canvas.closest('.chart-container');
                            if (container) {
                                container.style.display = 'block';
                                container.style.visibility = 'visible';
                                container.style.height = '300px';
                            }

                            // Initialize chart if not already done
                            if (!canvas.chart) {
                                try {
                                    initializeAspectChart(code);
                                    console.log(`Initialized chart for aspect: ${code}`);
                                } catch (e) {
                                    console.error(`Error initializing aspect chart ${code}:`, e);
                                }
                            }
                        }
                    });

                    // Initialize spiderweb chart
                    const spiderwebCanvas = document.getElementById('spiderwebChart');
                    if (spiderwebCanvas) {
                        // Make sure canvas container is visible
                        const container = spiderwebCanvas.closest('.chart-container');
                        if (container) {
                            container.style.display = 'block';
                            container.style.visibility = 'visible';
                            container.style.height = '400px';
                        }

                        // Show parent containers
                        const spiderwebContent = document.querySelector('div[x-show="showSpiderwebContent"]');
                        if (spiderwebContent) {
                            spiderwebContent.style.display = 'block';
                            spiderwebContent.style.visibility = 'visible';
                        }

                        // Initialize chart if not already done
                        if (!spiderwebCanvas.chart) {
                            try {
                                initSpiderwebChart();
                                console.log('Initialized spiderweb chart');
                            } catch (e) {
                                console.error('Error initializing spiderweb chart:', e);
                            }
                        }
                    }
                };

                // Check if we're in print mode and initialize all charts
                if (window.location.search.includes('print=true')) {
                    console.log('Print mode detected, initializing all charts...');
                    setTimeout(() => {
                        this.initAllCharts();
                    }, 500);
                }
            }
        };
    }

    // Additional print preparation helpers
    function prepareForPrinting() {
        // Force all Alpine.js components to show content
        if (typeof window.Alpine !== 'undefined') {
            document.querySelectorAll('[x-data]').forEach(function(el) {
                if (el.__x && el.__x.$data) {
                    if ('isOpen' in el.__x.$data) el.__x.$data.isOpen = true;
                    if ('showSpiderwebContent' in el.__x.$data) el.__x.$data.showSpiderwebContent = true;
                }
            });
        }

        // Force CSS display for certain elements
        // document.querySelectorAll('.aspect-dropdown .mt-2, .chart-container').forEach(el => {
        //     el.style.display = 'block';
        //     el.style.visibility = 'visible';
        // });

        // If aspectLegend is available, initialize all charts
        if (typeof window.aspectLegend === 'function') {
            const aspectLegendInstance = window.aspectLegend();
            if (typeof aspectLegendInstance.initAllCharts === 'function') {
                aspectLegendInstance.initAllCharts();
            }
        }
    }

    // Add to your print trigger script
    document.addEventListener('DOMContentLoaded', function() {
        if (window.location.search.includes('print=true')) {
            setTimeout(function() {
                prepareForPrinting();

                // Allow time for charts to render
                setTimeout(function() {
                    window.print();
                }, 2000);
            }, 1000);
        }
    });
</script> --}}

<script>
    function preparePrintContent() {
console.log('Preparing content for printing...');

// 1. Force all Alpine.js dropdowns and content to expand


// 7. Force spiderweb content to be visible
const spiderwebContent = document.querySelector('div[x-show="showSpiderwebContent"]');
if (spiderwebContent) {
    spiderwebContent.style.display = 'block';
    spiderwebContent.style.visibility = 'visible';
    spiderwebContent.style.height = 'auto';
    spiderwebContent.style.overflow = 'visible';
}

// 8. Add space for proper rendering of charts
setTimeout(function() {
    window.scrollTo(0, 0);
}, 500);

console.log('Content preparation complete. Ready for printing...');
}

// Initialize all charts at once
function initializeAllCharts() {
console.log('Initializing all charts...');

// Initialize aspect charts
const aspectCodes = ['T', 'O', 'R', 'M', 'P', 'Mf', 'I'];
aspectCodes.forEach(function(code) {
    const chartId = `aspectChart-${code}`;
    const canvas = document.getElementById(chartId);
    
    if (canvas) {
        try {
            // Make sure we have a clean canvas (destroy existing chart if any)
            if (canvas.chart) {
                canvas.chart.destroy();
            }
            // Call the aspect chart initialization function
            if (typeof initializeAspectChart === 'function') {
                initializeAspectChart(code);
                console.log(`Initialized chart for aspect: ${code}`);
            } else {
                console.warn(`initializeAspectChart function not found for aspect: ${code}`);
            }
        } catch (e) {
            console.error(`Error initializing aspect chart ${code}:`, e);
        }
    }
});

// Initialize spiderweb chart
const spiderwebCanvas = document.getElementById('spiderwebChart');
if (spiderwebCanvas) {
    try {
        // Clean up existing chart if any
        if (spiderwebCanvas.chart) {
            spiderwebCanvas.chart.destroy();
        }
        // Call the spiderweb initialization function
        if (typeof initSpiderwebChart === 'function') {
            initSpiderwebChart();
            console.log('Initialized spiderweb chart');
        } else {
            console.warn('initSpiderwebChart function not found');
        }
    } catch (e) {
        console.error('Error initializing spiderweb chart:', e);
    }
}
}

// Enhanced print function
function enhancedPrint() {
// 1. Prepare the content
preparePrintContent();

// 2. Create a print-specific stylesheet
const printStyle = document.createElement('style');
printStyle.id = 'print-specific-styles';
printStyle.innerHTML = `
    @media print {
        * {
            overflow: visible !important;
           
        }

        html, body, #app, .main-content {
        width: 100% !important;
        height: auto !important;
        overflow: visible !important;
        }
            
        #content {
            height: auto !important;
            overflow: visible !important;
            margin-left: -80px !important;
            width: 100% !important;
            padding: 10px !important;
        }
        
        /* Hide non-essential elements */
        #header, .breadcrumb, .submit-all-btn, 
        button:not(.indicator-tab), .head-title .left ul,
        .toggle-details, .btn:not(.indicator-tab), .no-print, .d-flex.justify-content-end,
        #submitAllBtn, .submit-all-container, footer, .head-title {
            display: none !important;
        }
        
        /* Reset all collapsible elements */
        [x-show], [x-cloak], [x-transition], [x-collapse] {
            display: block !important;
            visibility: visible !important;
            height: auto !important;
            overflow: visible !important;
            opacity: 1 !important;
        }
        
        /* Ensure charts are visible */
        .chart-container {
            display: block !important;
            height: 3px !important;
            min-height: 300px !important;
            page-break-inside: avoid !important;
            visibility: none !important;
            margin-bottom: 20px !important;
        }

        .katsinov-table {
                width: 100% !important;
                margin-top: 0 !important;
                padding: 0 !important;
            }
        
        /* Improve card appearance */
        .container, .card, .content {
            padding: 0 !important;
            margin: 0 !important;
            page-break-inside: avoid !important;
            border: 1px solid #ddd !important;
            box-shadow: none !important;
            margin-bottom: 15px !important;
        }
        
        /* Add page breaks between indicators */
        .indicator-card {
            page-break-before: always !important;
            margin-top: 20px !important;
            padding-top: 20px !important;
        }
        
        .indicator-card:first-child {
            page-break-before: auto !important;
        }
        
        /* Support background colors and images */
        * {
            -webkit-print-color-adjust: exact !important;
            color-adjust: exact !important;
            print-color-adjust: exact !important;
        }
        
        /* Improve table rendering */
        table {
            width: 100% !important;
            border-collapse: collapse !important;
            border-spacing: 0;
            page-break-inside: auto !important;
        }
            
        
        tr {
            page-break-inside: avoid !important;
            page-break-after: auto !important;
        }
        
        th, td {
            padding: 5px !important;
            border: 1px solid #ddd !important;
            font-size: 11pt !important;
        }
        
        /* Fix spiderweb content */
        .spiderweb-summary {
            display: block !important;
            visibility: visible !important;
            height: auto !important;
            margin-top: 20px !important;
        }
        
        /* Set page properties */
        @page {
            size: A3 portrait;
            margin: 0.1cm;
        }
    }
`;
document.head.appendChild(printStyle);

// 3. Wait a bit for the charts to render and styles to apply
setTimeout(function() {
    console.log('Triggering print dialog...');
    window.print();
    
    // 4. Clean up the temporary style element after printing
    setTimeout(function() {
        const tempStyle = document.getElementById('print-specific-styles');
        if (tempStyle) {
            tempStyle.remove();
        }
    }, 1000);
}, 1500);
}

// Handle print button clicks and URL print parameter
document.addEventListener('DOMContentLoaded', function() {
// Set up the print button to use our enhanced print function
const printButton = document.querySelector('button[onclick="window.print()"]');
if (printButton) {
    printButton.onclick = function(e) {
        e.preventDefault();
        enhancedPrint();
    };
}

// Check if the URL contains a print parameter
if (window.location.search.includes('print=true')) {
    console.log('Print parameter detected, preparing print view...');
    setTimeout(function() {
        enhancedPrint();
    }, 1000);
}
});
    </script>
@endsection