<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>KATSINOV-MeterO - Innovation Measurement System</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">
    <link href="{{ asset('aspect-analysis.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('.css') }}">
    <link rel="stylesheet" href="{{ asset('inovasi/dashboard/form_katsinov/css/form.css') }}">

    <script src="{{ asset('aspect-legend.js') }}"></script>
    <script src="{{ asset('aspect-analysis-integrated.js') }}"></script>
    <script src="{{ asset('spiderweb-chart-script.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>


@extends('admin.admin')

@section('contentadmin')


<body x-data="aspectLegend()" x-init="init()">
    <!-- Main Content -->
    
    <main class="container">
        <form id="katsinovForm" method="POST" action="{{ route('katsinov.store') }}">
            @csrf
            <!-- Explanation Card -->
            <div class="card" data-aos="fade-up">
                <div class="main-title">
                    PENGUKURAN TINGKAT KESIAPAN INOVASI (KATSINOV)
                </div>
                <div class="content">
                    <div class="content-title">Penjelasan</div>
                    <div class="content-text">
                        <span class="highlight">IRL-Meter (Innovation Readiness Level - Meter)</span> atau
                        <span class="highlight">KATSINOV-Meter (Tingkat Kesiapan Inovasi - Meter)</span>
                        adalah sebuah alat ukur yang digunakan untuk mengukur tingkat kesiapan atau kematangan
                        inovasi yang dilakukan oleh suatu perusahaan dan/ atau proyek/program/kegiatan.
                        KATSINOV-Meter menggunakan pendekatan siklus hidup inovasi, dimana dapat menggambarkan
                        perkembangan inovasi.
                    </div>

                    <div class="content-text">
                        Kerangka konseptual IRL adalah model <span class="highlight">6"C" (Concept, Component,
                            Completion, Chasin, Competition, Changeover/ Closedown)</span>, yang memisahkan secara
                        komprehensif siklus hidup inovasi ke dalam 6 fase (tingkat kesiapan), dan memberikan
                        arah bagi manajemen dalam melaksanakan proses inovasi dengan memperhatikan 7 aspek
                        kunci (teknologi, pasar, organisasi, manufaktur, investment, kemitraan dan risiko).
                    </div>

                    <div class="content-text">
                        Pengukuran IRL sangat penting untuk:
                    </div>
                    <div class="list-container">
                        <div class="list-item" data-aos="fade-right" data-aos-delay="100">
                            Menggambarkan perkembangan inovasi
                        </div>
                        <div class="list-item" data-aos="fade-right" data-aos-delay="200">
                            Membantu mengimplementasikan inovasi diatas siklus-hidup yang lebih efektif
                        </div>
                        <div class="list-item" data-aos="fade-right" data-aos-delay="300">
                            Mengantisipasi persaingan pasar yang semakin sengit
                        </div>
                        <div class="list-item" data-aos="fade-right" data-aos-delay="400">
                            Mengantisipasi tingkat inovasi atau siklus hidup teknologi yang lebih cepat
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Container -->
            <div class="form-container" data-aos="fade-up" data-aos-delay="500">
                <div class="document-number">No: 20190802-001</div>

                <div class="form-group">
                    <div class="form-label">Nama/Judul</div>
                    <input type="text" class="form-input" name="title" placeholder="Masukkan nama/judul" value="{{ $katsinov['title'] ?? '' }}">
                </div>

                <div class="form-group">
                    <div class="form-label">Fokus Bidang</div>
                    <input type="text" class="form-input" name="focus_area" placeholder="Masukkan fokus bidang" value="{{ $katsinov['focus_area'] ?? '' }}">
                </div>

                <div class="form-group">
                    <div class="form-label">Nama Proyek</div>
                    <input type="text" class="form-input" name="project_name" placeholder="Masukkan nama proyek" value="{{ $katsinov['project_name'] ?? '' }}">
                </div>

                <div class="form-group">
                    <div class="form-label">Nama Lembaga/Perusahaan</div>
                    <input type="text" class="form-input" name="institution"
                        placeholder="Masukkan nama lembaga/perusahaan" value="{{ $katsinov['institution'] ?? '' }}">
                </div>

                <div class="form-group">
                    <div class="form-label">Alamat / Kontak</div>
                    <div>
                        <input type="text" class="form-input" name="address" placeholder="Masukkan alamat lengkap" value="{{ $katsinov['address'] ?? '' }}">
                        <div style="margin-top: 0.75rem;">
                            <input type="text" class="form-input" name="contact" placeholder="Telp / Fax / email" value="{{ $katsinov['contact'] ?? '' }}">
                        </div>
                    </div>
                </div>

                <div class="date-section">
                    <div class="form-group">
                        <div class="form-label">Tanggal</div>
                        <input type="date" id="assessment_date" name="assessment_date"
                            class="form-input @error('assessment_date') border-red-500 @enderror"
                            value="{{ old('assessment_date', isset($katsinov['assessment_date']) ? $katsinov['assessment_date'] : date('Y-m-d')) }}" required>
                    </div>
                </div>

                <div class="progress-container">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 1rem;">
                        <span style="font-weight: 500; color: var(--text);">Batas Minimum Capaian</span>
                        <span
                            style="padding: 0.5rem 1rem; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 8px;">80.0%</span>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <span style="font-weight: 500; color: var(--text);">Batas Maksimum Capaian</span>
                        <span
                            style="padding: 0.5rem 1rem; background: linear-gradient(135deg, #84fab0 0%, #8fd3f4 100%); color: var(--text-dark); border-radius: 8px;">100.0%</span>
                    </div>
                </div>

                <div class="legend" x-data="aspectLegend()">
                    <h3 class="text-gray-700 mb-6 text-lg">Keterangan:</h3>
                    <div class="legend-grid">
                        <!-- Teknologi -->
                        <div class="legend-item cursor-pointer" @click="openAspectAnalysis('T')">
                            <div class="legend-box"
                                style="background: linear-gradient(135deg, #fad961 0%, #f76b1c 100%);"></div>
                            <span>Aspek Teknologi (T)</span>
                        </div>

                        <!-- Organisasi -->
                        <div class="legend-item cursor-pointer" @click="openAspectAnalysis('O')">
                            <div class="legend-box"
                                style="background: linear-gradient(135deg, #84fab0 0%, #8fd3f4 100%);"></div>
                            <span>Aspek Organisasi (O)</span>
                        </div>

                        <!-- Risiko -->
                        <div class="legend-item cursor-pointer" @click="openAspectAnalysis('R')">
                            <div class="legend-box"
                                style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);"></div>
                            <span>Aspek Risiko (R)</span>
                        </div>

                        <!-- Pasar -->
                        <div class="legend-item cursor-pointer" @click="openAspectAnalysis('M')">
                            <div class="legend-box"
                                style="background: linear-gradient(135deg, #ff9a9e 0%, #fad0c4 100%);"></div>
                            <span>Aspek Pasar (M)</span>
                        </div>

                        <!-- Kemitraan -->
                        <div class="legend-item cursor-pointer" @click="openAspectAnalysis('P')">
                            <div class="legend-box"
                                style="background: linear-gradient(135deg, #ffd1ff 0%, #fab2ff 100%);"></div>
                            <span>Aspek Kemitraan (P)</span>
                        </div>

                        <!-- Manufaktur -->
                        <div class="legend-item cursor-pointer" @click="openAspectAnalysis('Mf')">
                            <div class="legend-box"
                                style="background: linear-gradient(135deg, #f6d365 0%, #fda085 100%);"></div>
                            <span>Aspek Manufaktur (Mf)</span>
                        </div>

                        <!-- Investasi -->
                        <div class="legend-item cursor-pointer" @click="openAspectAnalysis('I')">
                            <div class="legend-box"
                                style="background: linear-gradient(135deg, #96fbc4 0%, #f9f586 100%);"></div>
                            <span>Aspek Investasi (I)</span>
                        </div>
                    </div>
                    <!-- Aspect Analysis Popup -->
                    <div x-show="showPopup" class="aspect-popup" @click.self="showPopup = false"
                        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
                        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                        <div class="popup-content">
                            <div class="popup-header" :style="{ background: selectedAspect?.gradient }">
                                <h3 class="text-white text-xl font-semibold"
                                    x-text="'Analysis ' + selectedAspect?.name"></h3>
                                <button @click="showPopup = false" class="popup-close">&times;</button>
                            </div>

                            <div class="popup-body">
                                <div class="chart-container">
                                    <canvas id="aspectChart"></canvas>
                                </div>

                                <div class="summary-container">
                                    <div class="summary-item">
                                        <span class="label">Rata-rata Pencapaian:</span>
                                        <span class="value" x-text="calculateAverage() + '%'"></span>
                                    </div>
                                    <div class="summary-item">
                                        <span class="label">Level KATSINOV Tercapai:</span>
                                        <span class="value" x-text="getMaxKatsinovLevel()"></span>
                                    </div>
                                    <div class="summary-item">
                                        <span class="label">Status:</span>
                                        <span class="value" :class="getStatusClass()" x-text="getStatus()"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="spiderweb-trigger" style="position: fixed; bottom: 20px; right: 20px; z-index: 100;">
                    <button 
                    type="button"
                    @click="openSpiderwebAnalysis()"
                        class="bg-primary text-white px-4 py-2 rounded-full shadow-lg hover:bg-primary-dark transition-colors"
                        style="background-color: #176369; color: white; padding: 10px 20px; border-radius: 30px;">
                        Lihat Analisis Aspek
                    </button>
                </div>

                <!-- Spiderweb Analysis Popup -->
                <div x-show="showSpiderwebPopup" class="spiderweb-popup" @click.self="showSpiderwebPopup = false"
                    x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                    style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); display: flex; justify-content: center; align-items: center; z-index: 1000;">
                    <div class="popup-content"
                        style="background: white; border-radius: 10px; width: 90%; max-width: 800px; max-height: 90%; overflow: auto; padding: 20px;">
                        <div class="popup-header"
                            style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                            <h3 class="text-xl font-semibold">Analisis Keseluruhan Aspek KATSINOV</h3>
                            <button @click="showSpiderwebPopup = false" class="popup-close"
                                style="background: none; border: none; font-size: 24px; cursor: pointer;">&times;</button>
                        </div>

                        <div class="popup-body" style="display: flex; flex-direction: column; gap: 20px;">
                            <div class="chart-container" style="width: 100%; height: 400px;">
                                <canvas id="spiderwebChart"></canvas>
                            </div>

                            <div class="summary-container"
                                style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px;">
                                <div class="summary-item"
                                    style="background: #f0f4f8; padding: 15px; border-radius: 8px;">
                                    <span class="label block text-gray-600 mb-2">Rata-rata Pencapaian:</span>
                                    <span class="rata-rata-pencapaian text-xl font-bold text-primary">0.0%</span>
                                </div>
                                <div class="summary-item"
                                    style="background: #f0f4f8; padding: 15px; border-radius: 8px;">
                                    <span class="label block text-gray-600 mb-2">Aspek Terpenuhi:</span>
                                    <span class="aspek-terpenuhi text-xl font-bold text-primary">0 dari 7</span>
                                </div>
                                <div class="summary-item"
                                    style="background: #f0f4f8; padding: 15px; border-radius: 8px;">
                                    <span class="label block text-gray-600 mb-2">Status Keseluruhan:</span>
                                    <span class="status-keseluruhan text-xl font-bold">BELUM TERPENUHI</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <buttom>
            <a href="{{ route('admin.hilirisasi.lampiran') }}">
    <button type="button" style="background-color: #176369; color: white; padding: 10px 20px; border: none; cursor: pointer;">Lampiran</button>
</a>
</buttom>
            </div>
            {{-- @dd($indicator) --}}
            @include('admin.katsinov.indikator1')
            @include('admin.katsinov.indikator2')
            @include('admin.katsinov.indikator3')
            @include('admin.katsinov.indikator4')
            @include('admin.katsinov.indikator5')
            @include('admin.katsinov.indikator6')
            @include('admin.katsinov.jumlahindikator')
            <!-- Submit All Button -->
            @if (!$katsinov)    
            <div class="submit-all-container"
                style="
            display: flex;
            justify-content: center;
            margin-top: 2rem;
            margin-bottom: 2rem;
        ">
                <button type="submit" id="submitAllBtn" class="submit-all-btn"
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
                    onclick="submitAllIndicators()">
                    Submit Semua Indikator KATSINOV
                </button>
            </div>
            @endif
        </form>
    </main>

    <script src="{{ asset('inovasi/dashboard/form_katsinov/js/form.js') }}"></script>
</body>


</html>