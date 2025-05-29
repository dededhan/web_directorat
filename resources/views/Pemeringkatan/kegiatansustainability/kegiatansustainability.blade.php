<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kegiatan Sustainability</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('home.css') }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background: #fff;
            min-height: 100vh;
            /* padding: 20px; */ /* Perhatikan padding ini, mungkin perlu disesuaikan atau dihapus jika navbar/footer Anda full-width */
        }

        /* .container removed */

        .main-content-wrapper { /* Tambahkan wrapper ini jika perlu padding */
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
        }

        .header h1 {
            color: #2c3e50;
            font-size: 2.5em;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
        }

        .dropdown-container {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 20px;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }

        .dropdown-wrapper {
            position: relative;
        }

        .dropdown-wrapper label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #34495e;
            font-size: 14px;
        }

        select {
            padding: 12px 16px;
            border: 2px solid #e1e8ed;
            border-radius: 10px;
            background: white;
            font-size: 16px;
            color: #2c3e50;
            cursor: pointer;
            transition: all 0.3s ease;
            min-width: 180px;
        }

        select:hover {
            border-color: #277177;
            box-shadow: 0 2px 8px rgba(39, 113, 119, 0.2);
        }

        select:focus {
            outline: none;
            border-color: #277177;
            box-shadow: 0 0 0 3px rgba(39, 113, 119, 0.1);
        }

        .chart-section {
            margin-bottom: 50px;
        }

        .chart-title {
            text-align: center;
            font-size: 1.8em;
            color: #2c3e50;
            margin-bottom: 25px;
            font-weight: 600;
        }

        .chart-container {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border: 1px solid #e1e8ed;
            max-width: 2000px;    /* tambahkan ini */
            margin: 0 auto;      /* tambahkan ini */
        }

        .chart {
            display: flex;
            align-items: end;
            justify-content: space-between;
            height: 400px;
            padding: 20px 0;
            border-bottom: 2px solid #ecf0f1;
            gap: 8px;
            overflow-x: auto;
        }

        .bar {
            flex: 1;
            min-width: 40px;
            background: linear-gradient(180deg, #277177, #1a5a5e);
            border-radius: 5px 5px 0 0;
            position: relative;
            transition: all 0.3s ease;
            cursor: pointer;
            animation: growUp 1s ease-out;
        }

        .bar:hover {
            transform: scale(1.05);
            background: linear-gradient(180deg, #3a9ba2, #277177);
            box-shadow: 0 5px 15px rgba(39, 113, 119, 0.3);
        }

        .bar::before {
            content: attr(data-value);
            position: absolute;
            top: -25px;
            left: 50%;
            transform: translateX(-50%);
            font-size: 12px;
            font-weight: bold;
            color: #2c3e50;
        }

        .chart-labels {
            display: flex;
            justify-content: space-between;
            margin-top: 15px;
            gap: 8px;
            overflow-x: auto;
        }

        .label {
            flex: 1;
            min-width: 40px;
            text-align: center;
            font-size: 14px; /* Ubah dari 10px ke 14px */
            color: #7f8c8d;
            font-weight: 500;
            line-height: 1.2;
            padding: 5px 2px;
        }


        @keyframes growUp {
            from {
                height: 0;
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        .faculty-section {
            border-top: 3px solid #ecf0f1;
            padding-top: 40px;
        }

        @media (max-width: 768px) {
            /* .container removed */
            .header h1 {
                font-size: 2em;
            }

            .dropdown-container {
                flex-direction: column;
                gap: 15px;
            }

            .chart {
                height: 300px;
                gap: 4px;
            }

            .label {
                font-size: 8px;
            }

            .bar {
                min-width: 25px;
            }
        }
    </style>
    {{-- Navbar seharusnya di dalam body --}}
</head>
<body>
    @include('layout.navbar_pemeringkatan') {{-- PINDAHKAN KE SINI --}}

    <div class="main-content-wrapper"> {{-- Tambahkan wrapper ini jika konten utama perlu padding, dan hapus padding dari body --}}
        <div class="header">
            <h1>Kegiatan Sustainability</h1>
            <p style="color: #7f8c8d; font-size: 1.1em;">Sustainable Development Goals Monitoring</p>
        </div>

        <div class="dropdown-container">
            <div class="dropdown-wrapper">
                <label for="year-select">📅 Tahun</label>
                <select id="year-select" onchange="updateYearChart()">
                    <option value="2024">2024</option>
                    <option value="2025" selected>2025</option>
                </select>
            </div>
        </div>

        <div class="chart-section">
            <h2 class="chart-title" id="year-chart-title">Progress Kegiatan Sustainability Tahun 2025</h2>
            <div class="chart-container">
                <div class="chart" id="year-chart">
                    </div>
                <div class="chart-labels" id="year-labels">
                    </div>
            </div>
        </div>

        <div class="faculty-section">
            <div class="dropdown-container">
                <div class="dropdown-wrapper">
                    <label for="faculty-select">🏛️ Fakultas</label>
                    <select id="faculty-select" onchange="updateFacultyChart()">
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
                <h2 class="chart-title" id="faculty-chart-title">Progress SDGs Fakultas Ilmu Pendidikan (FIP)</h2>
                <div class="chart-container">
                    <div class="chart" id="faculty-chart">
                        </div>
                    <div class="chart-labels" id="faculty-labels">
                        </div>
                </div>
            </div>
        </div>
    </div> {{-- tutup .main-content-wrapper --}}

    <script>
        const sdgGoals = [
            "No Poverty",
            "Zero Hunger", 
            "Good Health",
            "Quality Education",
            "Gender Equality",
            "Clean Water",
            "Clean Energy",
            "Decent Work",
            "Innovation",
            "Reduced Inequality",
            "Sustainable Cities",
            "Responsible Consumption",
            "Climate Action",
            "Life Below Water",
            "Life on Land",
            "Peace & Justice",
            "Partnerships"
        ];

        // Sample data - you can replace with real data
        const yearData = {
            2024: [65, 72, 58, 84, 69, 77, 63, 71, 56, 68, 74, 62, 59, 51, 67, 73, 81],
            2025: [68, 75, 61, 87, 72, 80, 66, 74, 59, 71, 77, 65, 62, 54, 70, 76, 84]
        };

        const facultyData = {
            FIP: [75, 82, 68, 91, 79, 73, 66, 78, 62, 74, 80, 69, 65, 58, 72, 83, 88],
            FBS: [70, 77, 63, 86, 74, 68, 61, 73, 57, 69, 75, 64, 60, 53, 67, 78, 83],
            FMIPA: [72, 69, 85, 83, 71, 89, 92, 76, 88, 73, 78, 71, 74, 67, 81, 75, 80],
            FT: [68, 64, 79, 80, 67, 85, 89, 91, 85, 70, 82, 78, 76, 63, 77, 72, 77],
            FIS: [78, 74, 66, 88, 83, 71, 63, 75, 59, 81, 84, 67, 71, 56, 69, 86, 89],
            FE: [71, 68, 62, 85, 76, 69, 65, 87, 79, 78, 81, 84, 68, 54, 66, 79, 91],
            FPP: [74, 71, 89, 87, 81, 73, 67, 76, 61, 84, 79, 69, 66, 57, 75, 88, 85],
            FIK: [69, 73, 91, 84, 77, 75, 68, 74, 58, 72, 77, 63, 64, 59, 83, 81, 82]
        };

        const facultyNames = {
            FIP: "Fakultas Ilmu Pendidikan (FIP)",
            FBS: "Fakultas Bahasa dan Seni (FBS)",
            FMIPA: "Fakultas Matematika dan IPA (FMIPA)",
            FT: "Fakultas Teknik",
            FIS: "Fakultas Ilmu Sosial",
            FE: "Fakultas Ekonomi",
            FPP: "Fakultas Pendidikan Psikologi",
            FIK: "Fakultas Ilmu Keolahragaan"
        };

        function createChart(containerId, labelsId, data, goals) {
            const chartContainer = document.getElementById(containerId);
            const labelsContainer = document.getElementById(labelsId);
            
            chartContainer.innerHTML = '';
            labelsContainer.innerHTML = '';

            const maxValue = Math.max(...data);
            
            data.forEach((value, index) => {
                // Create bar
                const bar = document.createElement('div');
                bar.className = 'bar';
                bar.style.height = `${(value / maxValue) * 100}%`;
                bar.setAttribute('data-value', `${value}%`);
                bar.title = `${goals[index]}: ${value}%`;
                chartContainer.appendChild(bar);

                // Create label
                const label = document.createElement('div');
                label.className = 'label';
                label.textContent = goals[index];
                labelsContainer.appendChild(label);
            });
        }

        function updateYearChart() {
            const selectedYear = document.getElementById('year-select').value;
            const data = yearData[selectedYear];
            const titleElement = document.getElementById('year-chart-title');
            titleElement.textContent = `Progress Kegiatan Sustainability Tahun ${selectedYear}`;
            createChart('year-chart', 'year-labels', data, sdgGoals);
        }

        function updateFacultyChart() {
            const selectedFaculty = document.getElementById('faculty-select').value;
            const data = facultyData[selectedFaculty];
            const titleElement = document.getElementById('faculty-chart-title');
            titleElement.textContent = `Progress Kegiatan Sustainability ${facultyNames[selectedFaculty]}`;
            createChart('faculty-chart', 'faculty-labels', data, sdgGoals);
        }

        // Initialize charts
        document.addEventListener('DOMContentLoaded', function() {
            updateYearChart();
            updateFacultyChart();
        });
    </script>

    @include('layout.footer') {{-- PINDAHKAN KE SINI, SEBELUM PENUTUP BODY --}}
</body>
</html>