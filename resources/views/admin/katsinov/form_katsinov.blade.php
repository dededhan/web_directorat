@extends('admin.admin')

@section('contentadmin')
    <!-- Add necessary stylesheets -->
    <link rel="stylesheet" href="{{ asset('inovasi/formjudul.css') }}">
    <link rel="stylesheet" href="{{ asset('aspect-analysis.css') }}">
    <link rel="stylesheet" href="{{ asset('inovasi/dashboard/form_katsinov/css/form.css') }}">

    <div class="head-title">
        <div class="left">
            <h1>KATSINOV-MeterO</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="#">Dashboard</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a class="active" href="#">Form KATSINOV</a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Keep the original content, just wrapped in the admin section -->
    <div class="no-double-scroll">
        <form id="katsinovForm" method="POST" action="{{ route('katsinov.store') }}">
            @csrf
            <!-- Explanation Card -->
            <div class="card">
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
                        <div class="list-item">
                            Menggambarkan perkembangan inovasi
                        </div>
                        <div class="list-item">
                            Membantu mengimplementasikan inovasi diatas siklus-hidup yang lebih efektif
                        </div>
                        <div class="list-item">
                            Mengantisipasi persaingan pasar yang semakin sengit
                        </div>
                        <div class="list-item">
                            Mengantisipasi tingkat inovasi atau siklus hidup teknologi yang lebih cepat
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Container -->
            <div class="form-container">
                <div class="document-number">No: 20190802-001</div>

                <div class="form-group">
                    <div class="form-label">Nama/Judul</div>
                    <input type="text" class="form-input" name="title" placeholder="Masukkan nama/judul"
                        value="{{ $katsinov['title'] ?? '' }}">
                </div>

                <div class="form-group">
                    <div class="form-label">Fokus Bidang</div>
                    <input type="text" class="form-input" name="focus_area" placeholder="Masukkan fokus bidang"
                        value="{{ $katsinov['focus_area'] ?? '' }}">
                </div>

                <div class="form-group">
                    <div class="form-label">Nama Proyek</div>
                    <input type="text" class="form-input" name="project_name" placeholder="Masukkan nama proyek"
                        value="{{ $katsinov['project_name'] ?? '' }}">
                </div>

                <div class="form-group">
                    <div class="form-label">Nama Lembaga/Perusahaan</div>
                    <input type="text" class="form-input" name="institution"
                        placeholder="Masukkan nama lembaga/perusahaan" value="{{ $katsinov['institution'] ?? '' }}">
                </div>

                <div class="form-group">
                    <div class="form-label">Alamat / Kontak</div>
                    <div>
                        <input type="text" class="form-input" name="address" placeholder="Masukkan alamat lengkap"
                            value="{{ $katsinov['address'] ?? '' }}">
                        <div style="margin-top: 0.75rem;">
                            <input type="text" class="form-input" name="contact" placeholder="Telp / Fax / email"
                                value="{{ $katsinov['contact'] ?? '' }}">
                        </div>
                    </div>
                </div>

                <div class="date-section">
                    <div class="form-group">
                        <div class="form-label">Tanggal</div>
                        <input type="date" id="assessment_date" name="assessment_date"
                            class="form-input @error('assessment_date') border-red-500 @enderror"
                            value="{{ old('assessment_date', isset($katsinov['assessment_date']) ? $katsinov['assessment_date'] : date('Y-m-d')) }}"
                            required>
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

                <div class="legend">
                    <h3 class="text-gray-700 mb-6 text-lg">Keterangan:</h3>
                    <div class="legend-grid">
                        <!-- Teknologi -->
                        <div class="legend-item cursor-pointer" data-aspect="T" id="aspect-T">
                            <div class="legend-box" style="background: linear-gradient(135deg, #fad961 0%, #f76b1c 100%);">
                            </div>
                            <span>Aspek Teknologi (T)</span>
                        </div>

                        <!-- Organisasi -->
                        <div class="legend-item cursor-pointer" data-aspect="O" id="aspect-O">
                            <div class="legend-box"
                                style="background: linear-gradient(135deg, #84fab0 0%, #8fd3f4 100%);"></div>
                            <span>Aspek Organisasi (O)</span>
                        </div>

                        <!-- Risiko -->
                        <div class="legend-item cursor-pointer" data-aspect="R" id="aspect-R">
                            <div class="legend-box"
                                style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);"></div>
                            <span>Aspek Risiko (R)</span>
                        </div>

                        <!-- Pasar -->
                        <div class="legend-item cursor-pointer" data-aspect="M" id="aspect-M">
                            <div class="legend-box"
                                style="background: linear-gradient(135deg, #ff9a9e 0%, #fad0c4 100%);"></div>
                            <span>Aspek Pasar (M)</span>
                        </div>

                        <!-- Kemitraan -->
                        <div class="legend-item cursor-pointer" data-aspect="P" id="aspect-P">
                            <div class="legend-box"
                                style="background: linear-gradient(135deg, #ffd1ff 0%, #fab2ff 100%);"></div>
                            <span>Aspek Kemitraan (P)</span>
                        </div>

                        <!-- Manufaktur -->
                        <div class="legend-item cursor-pointer" data-aspect="Mf" id="aspect-Mf">
                            <div class="legend-box"
                                style="background: linear-gradient(135deg, #f6d365 0%, #fda085 100%);"></div>
                            <span>Aspek Manufaktur (Mf)</span>
                        </div>

                        <!-- Investasi -->
                        <div class="legend-item cursor-pointer" data-aspect="I" id="aspect-I">
                            <div class="legend-box"
                                style="background: linear-gradient(135deg, #96fbc4 0%, #f9f586 100%);"></div>
                            <span>Aspek Investasi (I)</span>
                        </div>
                    </div>
                </div>
                
                <!-- Aspect Analysis Popup -->
                <div id="aspectPopup" class="aspect-popup" style="display: none;">
                    <div class="popup-content">
                        <div id="aspectPopupHeader" class="popup-header"
                            style="background: linear-gradient(135deg, #fad961 0%, #f76b1c 100%);">
                            <h3 class="text-white text-xl font-semibold" id="aspectPopupTitle">Analysis</h3>
                            <button id="closeAspectBtn" class="popup-close">&times;</button>
                        </div>

                        <div class="popup-body">
                            <div class="chart-container">
                                <canvas id="aspectChart"></canvas>
                            </div>

                            <div class="summary-container">
                                <div class="summary-item">
                                    <span class="label">Rata-rata Pencapaian:</span>
                                    <span class="value" id="aspectAverage">0.0%</span>
                                </div>
                                <div class="summary-item">
                                    <span class="label">Level KATSINOV Tercapai:</span>
                                    <span class="value" id="aspectKatsinovLevel">0</span>
                                </div>
                                <div class="summary-item">
                                    <span class="label">Status:</span>
                                    <span class="value" id="aspectStatus">BELUM TERPENUHI</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="spiderweb-trigger" style="display: flex; justify-content: center; margin: 20px 0;">
                    <button type="button" id="openSpiderwebBtn"
                        class="bg-primary text-white px-4 py-2 rounded-full shadow-lg hover:bg-primary-dark transition-colors"
                        style="background-color: #176369; color: white; padding: 10px 20px; border-radius: 30px;">
                        Lihat Analisis Aspek
                    </button>
                </div>

                <!-- Spiderweb Analysis Popup -->
                <div id="spiderwebPopup" class="spiderweb-popup" style="display: none;">
                    <div class="popup-content"
                        style="background: white; border-radius: 10px; width: 90%; max-width: 800px; max-height: 90%; overflow: auto; padding: 20px;">
                        <div class="popup-header"
                            style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                            <h3 class="text-xl font-semibold">Analisis Keseluruhan Aspek KATSINOV</h3>
                            <button id="closeSpiderwebBtn" class="popup-close"
                                style="background: none; border: none; font-size: 24px; cursor: pointer;">&times;</button>
                        </div>

                        <div class="popup-body" style="display: flex; flex-direction: column; gap: 20px;">
                            <div class="chart-container" style="width: 100%; height: 400px;">
                                <canvas id="spiderwebChart"></canvas>
                            </div>

                            <div class="summary-container"
                                style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px;">
                                <div class="summary-item" style="background: #f0f4f8; padding: 15px; border-radius: 8px;">
                                    <span class="label block text-gray-600 mb-2">Rata-rata Pencapaian:</span>
                                    <span class="rata-rata-pencapaian text-xl font-bold text-primary">0.0%</span>
                                </div>
                                <div class="summary-item" style="background: #f0f4f8; padding: 15px; border-radius: 8px;">
                                    <span class="label block text-gray-600 mb-2">Aspek Terpenuhi:</span>
                                    <span class="aspek-terpenuhi text-xl font-bold text-primary">0 dari 7</span>
                                </div>
                                <div class="summary-item" style="background: #f0f4f8; padding: 15px; border-radius: 8px;">
                                    <span class="label block text-gray-600 mb-2">Status Keseluruhan:</span>
                                    <span class="status-keseluruhan text-xl font-bold">BELUM TERPENUHI</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div style="margin: 20px 0;">
                <a href="{{ route('admin.hilirisasi.lampiran') }}">
                    <button type="button"
                        style="background-color: #176369; color: white; padding: 10px 20px; border: none; cursor: pointer; border-radius: 5px;">Lampiran</button>
                </a>
            </div>

            <!-- Include Indicators -->
            <div class="form-katsinov-indicators">
                @include('admin.katsinov.indikator1')
                @include('admin.katsinov.indikator2')
                @include('admin.katsinov.indikator3')
                @include('admin.katsinov.indikator4')
                @include('admin.katsinov.indikator5')
                @include('admin.katsinov.indikator6')
                @include('admin.katsinov.jumlahindikator')
            </div>

            <!-- Submit All Button -->
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
                    @if (!isset($katsinov) || empty($katsinov))
                        Submit Semua Indikator KATSINOV
                    @else
                        Update Indikator KATSINOV
                    @endif
                </button>
            </div>
        </form>
    </div>

    <style>
        /* Reset container styles to match form.css and make it fill available width */
        #content .container {
            max-width: 100%;
            width: 100%;
            margin: 0 auto;
            padding: 10px 15px;
            margin-top: 20px;
        }

        /* Make sure the indicators table takes full width */
        .form-katsinov-indicators .container {
            max-width: 100% !important;
            width: 100% !important;
            padding: 10px !important;
            margin-top: 0 !important;
        }

        /* Override some admin.css styles that might conflict */
        .card {
            background: var(--white);
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(26, 115, 232, 0.1);
            margin: 2rem 0;
            overflow: visible;
            transition: transform 0.3s ease;
        }

        /* Fix any other conflicting styles */
        .form-container {
            background: var(--white);
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            padding: 2.5rem;
            margin: 2rem 0;
        }

        /* Fix radio buttons that might be affected by admin styles */
        .radio-input {
            appearance: none;
            width: 1.2rem;
            height: 1.2rem;
            border: 2px solid #cbd5e1;
            border-radius: 50%;
            cursor: pointer;
            position: relative;
            transition: all 0.2s ease;
        }

        .radio-input:checked {
            border-color: #2563eb;
            background: #2563eb;
        }

        .radio-input:checked::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 0.5rem;
            height: 0.5rem;
            background: white;
            border-radius: 50%;
        }

        /* Fix the table width */
        .katsinov-table {
            width: 100%;
            table-layout: fixed;
        }

        /* Fix table cell width for consistency */
        .katsinov-table th,
        .katsinov-table td {
            padding: 1rem;
            border: 1px solid #e5e7eb;
            font-size: 0.95rem;
            word-wrap: break-word;
        }

        /* Make description cells have appropriate width */
        .description-cell {
            width: 40%;
        }

        /* Ensure the notes section is positioned correctly */
        .notes-section {
            right: -300px;
        }
    </style>

    <!-- JavaScript for KATSINOV functionality -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Setup the spiderweb popup functionality
            const openSpiderwebBtn = document.getElementById('openSpiderwebBtn');
            const spiderwebPopup = document.getElementById('spiderwebPopup');
            const closeSpiderwebBtn = document.getElementById('closeSpiderwebBtn');

            if (openSpiderwebBtn && spiderwebPopup) {
                openSpiderwebBtn.addEventListener('click', function() {
                    spiderwebPopup.style.display = 'flex';
                });
            }

            if (closeSpiderwebBtn && spiderwebPopup) {
                closeSpiderwebBtn.addEventListener('click', function() {
                    spiderwebPopup.style.display = 'none';
                });
            }

            if (spiderwebPopup) {
                spiderwebPopup.addEventListener('click', function(e) {
                    if (e.target === spiderwebPopup) {
                        spiderwebPopup.style.display = 'none';
                    }
                });
            }

            // Setup the aspect analysis functionality
            const aspectItems = document.querySelectorAll('.legend-item[data-aspect]');
            const aspectPopup = document.getElementById('aspectPopup');
            const aspectPopupHeader = document.getElementById('aspectPopupHeader');
            const aspectPopupTitle = document.getElementById('aspectPopupTitle');
            const closeAspectBtn = document.getElementById('closeAspectBtn');
            const aspectAverage = document.getElementById('aspectAverage');
            const aspectKatsinovLevel = document.getElementById('aspectKatsinovLevel');
            const aspectStatus = document.getElementById('aspectStatus');

            const aspectNames = {
                'T': 'Teknologi',
                'M': 'Pasar',
                'O': 'Organisasi',
                'Mf': 'Manufaktur',
                'I': 'Investasi',
                'P': 'Kemitraan',
                'R': 'Risiko'
            };

            const aspectGradients = {
                'T': 'linear-gradient(135deg, #fad961 0%, #f76b1c 100%)',
                'O': 'linear-gradient(135deg, #84fab0 0%, #8fd3f4 100%)',
                'R': 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
                'M': 'linear-gradient(135deg, #ff9a9e 0%, #fad0c4 100%)',
                'P': 'linear-gradient(135deg, #ffd1ff 0%, #fab2ff 100%)',
                'Mf': 'linear-gradient(135deg, #f6d365 0%, #fda085 100%)',
                'I': 'linear-gradient(135deg, #96fbc4 0%, #f9f586 100%)'
            };

            // Check if aspect cells have the exact text content
            function calculateAspectValues(aspectCode) {
                let total = 0;
                let count = 0;

                // Get all aspect cells in the table
                const allAspectCells = document.querySelectorAll('.aspect-cell');
                
                // Filter to only those with the matching aspect code
                allAspectCells.forEach(cell => {
                    if (cell.textContent.trim() === aspectCode) {
                        const row = cell.closest('tr');
                        const checkedRadio = row.querySelector('input[type="radio"]:checked');
                        
                        if (checkedRadio) {
                            const value = parseInt(checkedRadio.value);
                            if (!isNaN(value)) {
                                total += value;
                                count++;
                            }
                        }
                    }
                });

                return {
                    total: total,
                    count: count,
                    average: count > 0 ? (total / (count * 5)) * 100 : 0
                };
            }

            function getKatsinovLevel() {
                // Get the highest level that meets the minimum requirement
                const valueElement = document.querySelector('.katsinov-indicator .value');
                return valueElement ? parseInt(valueElement.textContent) || 0 : 0;
            }

            function getStatusForPercentage(percentage) {
                if (percentage >= 80) {
                    return {
                        text: 'TERPENUHI',
                        class: 'text-success'
                    };
                } else {
                    return {
                        text: 'BELUM TERPENUHI',
                        class: 'text-danger'
                    };
                }
            }

            // Initialize Chart.js for aspect analysis
            let aspectChart = null;
            
            function initAspectChart() {
                const ctx = document.getElementById('aspectChart').getContext('2d');
                aspectChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ['Level 1', 'Level 2', 'Level 3', 'Level 4', 'Level 5', 'Level 6'],
                        datasets: [{
                            label: 'Pencapaian (%)',
                            data: [0, 0, 0, 0, 0, 0],
                            backgroundColor: 'rgba(23, 99, 105, 0.6)',
                            borderColor: 'rgb(23, 99, 105)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true,
                                max: 100,
                                title: {
                                    display: true,
                                    text: 'Pencapaian (%)'
                                }
                            },
                            x: {
                                title: {
                                    display: true,
                                    text: 'Level KATSINOV'
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: true,
                                position: 'top'
                            },
                            title: {
                                display: true,
                                text: 'Analisis Aspek KATSINOV'
                            }
                        },
                        responsive: true,
                        maintainAspectRatio: false
                    }
                });
            }

            // Initialize the chart when the document loads
            initAspectChart();

            // Add click handlers to aspect items
            aspectItems.forEach(item => {
                item.addEventListener('click', function() {
                    const aspect = this.getAttribute('data-aspect');
                    
                    // Set the title and header style
                    aspectPopupTitle.textContent = `Analysis ${aspectNames[aspect]}`;
                    aspectPopupHeader.style.background = aspectGradients[aspect];
                    
                    // Calculate aspect values
                    const aspectData = calculateAspectValues(aspect);
                    aspectAverage.textContent = aspectData.average.toFixed(1) + '%';
                    
                    // Get KATSINOV level
                    const level = getKatsinovLevel();
                    aspectKatsinovLevel.textContent = level.toString();
                    
                    // Set status
                    const status = getStatusForPercentage(aspectData.average);
                    aspectStatus.textContent = status.text;
                    aspectStatus.className = 'value ' + status.class;
                    
                    // Update chart data (you would have actual data here)
                    const chartData = [
                        Math.min(100, Math.random() * 100), 
                        Math.min(100, Math.random() * 80), 
                        Math.min(100, Math.random() * 60), 
                        Math.min(100, Math.random() * 40), 
                        Math.min(100, Math.random() * 20), 
                        Math.min(100, Math.random() * 10)
                    ];
                    
                    aspectChart.data.datasets[0].data = chartData;
                    aspectChart.update();
                    
                    // Show the popup
                    aspectPopup.style.display = 'flex';
                });
            });

            // Close button for aspect popup
            if (closeAspectBtn && aspectPopup) {
                closeAspectBtn.addEventListener('click', function() {
                    aspectPopup.style.display = 'none';
                });
            }

            // Close aspect popup when clicking outside
            if (aspectPopup) {
                aspectPopup.addEventListener('click', function(e) {
                    if (e.target === aspectPopup) {
                        aspectPopup.style.display = 'none';
                    }
                });
            }

            // Initialize spiderweb chart
            const spiderwebCtx = document.getElementById('spiderwebChart').getContext('2d');
            const spiderwebChart = new Chart(spiderwebCtx, {
                type: 'radar',
                data: {
                    labels: ['Teknologi (T)', 'Pasar (M)', 'Organisasi (O)', 'Manufaktur (Mf)', 'Investasi (I)', 'Kemitraan (P)', 'Risiko (R)'],
                    datasets: [{
                        label: 'Pencapaian Aspek (%)',
                        data: [
                            calculateAspectValues('T').average,
                            calculateAspectValues('M').average,
                            calculateAspectValues('O').average,
                            calculateAspectValues('Mf').average,
                            calculateAspectValues('I').average,
                            calculateAspectValues('P').average,
                            calculateAspectValues('R').average
                        ],
                        backgroundColor: 'rgba(23, 99, 105, 0.2)',
                        borderColor: 'rgb(23, 99, 105)',
                        pointBackgroundColor: 'rgb(23, 99, 105)',
                        pointBorderColor: '#fff',
                        pointHoverBackgroundColor: '#fff',
                        pointHoverBorderColor: 'rgb(23, 99, 105)'
                    }]
                },
                options: {
                    elements: {
                        line: {
                            borderWidth: 3
                        }
                    },
                    scales: {
                        r: {
                            angleLines: {
                                display: true
                            },
                            suggestedMin: 0,
                            suggestedMax: 100
                        }
                    }
                }
            });
        });
    </script>

    <!-- Import original scripts last to ensure they don't interfere with our custom code -->
    <script src="{{ asset('indikator.js') }}"></script>
    <script src="{{ asset('inovasi/dashboard/form_katsinov/js/form.js') }}"></script>
@endsection