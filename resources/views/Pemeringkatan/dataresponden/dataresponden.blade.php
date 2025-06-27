<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Responden</title>
    <link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" type="image/png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;600;700&display=swap" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite([
        'resources/css/fitur/dataresponden.css',
        'resources/js/fitur/dataresponden.js' {{-- Path disesuaikan untuk Vite dan typo diperbaiki --}}
    ])
</head>
<body>
    @include('layout.navbar_pemeringkatan')
    
    <div class="main-content-wrapper">
        <div class="header">
            <h1>Data Responden</h1>
            <p>Dashboard Analisis Responden Universitas</p>
        </div>

        <div class="dropdown-container">
            <div class="dropdown-wrapper">
                <label for="year-select">📅 Tahun</label>
                <select id="year-select" onchange="updateCharts()" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-indigo-400 text-base font-medium bg-white shadow-sm transition">
                    <option value="2024">2024</option>
                    <option value="2025" selected>2025</option>
                </select>
            </div>
            <div class="dropdown-wrapper">
                <label for="faculty-select">🏛️ Fakultas</label>
                <select id="faculty-select" onchange="updateCharts()" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-indigo-400 text-base font-medium bg-white shadow-sm transition">
                    <option value="">Semua Fakultas</option>
                    <option value="fip">FIP - Fakultas Ilmu Pendidikan</option>
                    <option value="fbs">FBS - Fakultas Bahasa dan Seni</option>
                    <option value="fmipa">FMIPA - Fakultas Matematika dan IPA</option>
                    <option value="ft">FT - Fakultas Teknik</option>
                    <option value="fis">FIS - Fakultas Ilmu Sosial</option>
                    <option value="fe">FE - Fakultas Ekonomi</option>
                    <option value="fpp">FPP - Fakultas Pendidikan Psikologi</option>
                    <option value="fik">FIK - Fakultas Ilmu Keolahragaan</option>
                </select>
            </div>
        </div>

        <div id="custom-tooltip" class="tooltip"></div>

        <div class="chart-section">
            <h2 class="chart-title" id="overview-chart-title">Total Responden Tahun 2025</h2>
            <div class="chart-container">
                <div class="chart-wrapper">
                    <div id="overview-loading" class="loading">Memuat data...</div>
                    <div class="chart overview" id="overview-chart" style="display: none;"></div>
                    <div class="chart-labels overview" id="overview-labels" style="display: none;"></div>
                </div>
            </div>
        </div>

        <div class="chart-section section-divider">
            <h2 class="chart-title" id="employer-faculty-chart-title">Employee Berdasarkan Fakultas Tahun 2025</h2>
            <div class="chart-container">
                <div class="chart-wrapper">
                    <div id="employer-loading" class="loading">Memuat data...</div>
                    <div class="chart faculty" id="employer-chart" style="display: none;"></div>
                    <div class="chart-labels faculty" id="employer-labels" style="display: none;"></div>
                </div>
            </div>
        </div>

        <div class="chart-section section-divider">
            <h2 class="chart-title" id="academic-faculty-chart-title">Academic Berdasarkan Fakultas Tahun 2025</h2>
            <div class="chart-container">
                <div class="chart-wrapper">
                    <div id="academic-loading" class="loading">Memuat data...</div>
                    <div class="chart faculty" id="academic-chart" style="display: none;"></div>
                    <div class="chart-labels faculty" id="academic-labels" style="display: none;"></div>
                </div>
            </div>
        </div>

        <div class="chart-section section-divider">
            <h2 class="chart-title" id="status-chart-title">Distribusi Status Responden Tahun 2025</h2>
            <div class="chart-container">
                <div class="chart-wrapper">
                    <div id="status-loading" class="loading">Memuat data...</div>
                    <div class="chart overview" id="status-chart" style="display: none;"></div>
                    <div class="chart-labels overview" id="status-labels" style="display: none;"></div>
                </div>
            </div>
        </div>
    </div>

    @include('layout.footer')

</body>
</html>