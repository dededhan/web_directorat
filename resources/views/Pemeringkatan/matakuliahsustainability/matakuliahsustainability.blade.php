<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mata Kuliah Sustainability</title>
    <link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" type="image/png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
   
       @vite([
        'resources/css/fitur/matakuliahsustainability.css'
        'resources/js/fitur/matakuliahsustainability.js' {{-- Path disesuaikan untuk Vite dan typo diperbaiki --}}
    ])
    
</head>

<body>
    @include('layout.navbar_pemeringkatan')

    <div class="main-content-wrapper">
        <div class="header">
            <h1>Mata Kuliah Sustainability</h1>
            <p>Sustainable Development Goals Monitoring</p>
        </div>

        <div class="dropdown-container">
            <div class="dropdown-wrapper">
                <label for="year-select">📅 Tahun</label>
                <select id="year-select"
                    onchange="updateYearChart()"class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-indigo-400 text-base font-medium bg-white shadow-sm transition">>
                    <option value="2024">2024</option>
                    <option value="2025" selected>2025</option>
                </select>
            </div>
        </div>

        <div class="chart-section">
            <h2 class="chart-title" id="year-chart-title">Progress Mata Kuliah Sustainability Tahun 2025</h2>
            <div class="chart-container">
                <div class="chart" id="year-chart"></div>
                <div class="chart-labels" id="year-labels"></div>
            </div>
        </div>

        <div class="faculty-section">
            <div class="dropdown-container">
                <div class="dropdown-wrapper">
                    <label for="faculty-select">🏛️ Fakultas</label>
                    <select id="faculty-select" onchange="updateFacultyChart()"
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-indigo-400 text-base font-medium bg-white shadow-sm transition">
                        <option value="FIP">Fakultas Ilmu Pendidikan (FIP)</option>
                        <option value="FBS">Fakultas Bahasa dan Seni (FBS)</option>
                        <option value="FMIPA">Fakultas Matematika dan IPA (FMIPA)</option>
                        <option value="FT">Fakultas Teknik</option>
                        <option value="FIS">Fakultas Ilmu Sosial</option>
                        <option value="FE">Fakultas Ekonomi</option>
                        <option value="FPP">Fakultas Pendidikan Psikologi</option>
                        <option value="FIK">Fakultas Ilmu Keolahragaan</option>
                    </select>
                </div>
            </div>

            <div class="chart-section">
                <h2 class="chart-title" id="faculty-chart-title">Progress Mata Kuliah Sustainability Fakultas Ilmu
                    Pendidikan (FIP)</h2>
                <div class="chart-container">
                    <div class="chart" id="faculty-chart"></div>
                    <div class="chart-labels" id="faculty-labels"></div>
                </div>
            </div>
        </div>
    </div>


    <!-- Uncomment when you have the footer component -->
    @include('layout.footer')
</body>

</html>
