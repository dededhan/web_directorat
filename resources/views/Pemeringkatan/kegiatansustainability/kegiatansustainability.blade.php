<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kegiatan Sustainability</title>
    <link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" type="image/png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }


        .header {
            text-align: center;
            margin-bottom: 40px;
        }

        .header h1 {
            color: #2c3e50;
            font-size: 2.8em;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
            font-weight: 700;
        }

        .header p {
            color: #7f8c8d;
            font-size: 1.2em;
            font-weight: 500;
        }

        .dropdown-container {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 30px;
            margin-bottom: 40px;
            flex-wrap: wrap;
            padding-left: 0;
            box-sizing: border-box;
        }

        .dropdown-wrapper {
            position: relative;
            background: white;
            border-radius: 16px;
            padding: 20px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }

        .dropdown-wrapper:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
        }

        .dropdown-wrapper label {
            display: block;
            margin-bottom: 12px;
            font-weight: 600;
            color: #2c3e50;
            font-size: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .dropdown-wrapper label::before {
            font-size: 20px;
        }

        select {
            padding: 14px 18px;
            border: 2px solid transparent;
            border-radius: 12px;
            background: linear-gradient(white, white) padding-box,
                        linear-gradient(135deg, #667eea 0%, #764ba2 100%) border-box;
            font-size: 16px;
            color: #2c3e50;
            cursor: pointer;
            transition: all 0.3s ease;
            min-width: 220px;
            font-weight: 500;
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 12px center;
            background-repeat: no-repeat;
            background-size: 16px;
            padding-right: 40px;
        }

        select:hover {
            border-color: rgba(102, 126, 234, 0.3);
            box-shadow: 0 4px 16px rgba(102, 126, 234, 0.2);
            transform: translateY(-2px);
        }

        select:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        }

        .chart-section {
            margin-bottom: 60px;
        }

        .chart-title {
            text-align: center;
            font-size: 2em;
            color: #2c3e50;
            margin-bottom: 30px;
            font-weight: 600;
        }

        .chart-container {
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            max-width: 2000px;
            margin: 0 auto;
        }

        .chart {
            display: flex;
            align-items: end;
            justify-content: space-between;
            height: 450px;
            padding: 30px 0;
            border-bottom: 3px solid #ecf0f1;
            gap: 12px;
            overflow-x: auto;
        }

        .bar {
            flex: 1;
            min-width: 50px;
            border-radius: 8px 8px 0 0;
            position: relative;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            animation: growUp 1.2s ease-out;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .bar:hover {
            transform: scale(1.08) translateY(-5px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.2);
            z-index: 10;
        }

        .bar::before {
            content: attr(data-value);
            position: absolute;
            top: -35px;
            left: 50%;
            transform: translateX(-50%);
            font-size: 13px;
            font-weight: 600;
            color: #2c3e50;
            background: white;
            padding: 4px 8px;
            border-radius: 6px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .bar:hover::before {
            opacity: 1;
        }

        .chart-labels {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
            gap: 12px;
            overflow-x: auto;
        }

        .label {
            flex: 1;
            min-width: 50px;
            text-align: center;
            font-size: 13px;
            color: #5a6c7d;
            font-weight: 500;
            line-height: 1.3;
            padding: 8px 4px;
            transition: color 0.3s ease;
        }

        .label:hover {
            color: #2c3e50;
            font-weight: 600;
        }

        @keyframes growUp {
            from {
                height: 0;
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .faculty-section {
            border-top: 4px solid #ecf0f1;
            padding-top: 50px;
            margin-top: 40px;
        }

        /* SDG Colors */
        .sdg-1 { background: linear-gradient(135deg, #e5233c, #c41e3a); }
        .sdg-2 { background: linear-gradient(135deg, #dda73a, #bf9000); }
        .sdg-3 { background: linear-gradient(135deg, #4c9f38, #2d5016); }
        .sdg-4 { background: linear-gradient(135deg, #c5192d, #8b0000); }
        .sdg-5 { background: linear-gradient(135deg, #ff3a21, #e73c7e); }
        .sdg-6 { background: linear-gradient(135deg, #26bde2, #1a8fb8); }
        .sdg-7 { background: linear-gradient(135deg, #fcc30b, #dd9900); }
        .sdg-8 { background: linear-gradient(135deg, #a21942, #8b1538); }
        .sdg-9 { background: linear-gradient(135deg, #fd6925, #e55100); }
        .sdg-10 { background: linear-gradient(135deg, #dd1367, #b8094d); }
        .sdg-11 { background: linear-gradient(135deg, #fd9d24, #e67e00); }
        .sdg-12 { background: linear-gradient(135deg, #bf8b2e, #9d6e00); }
        .sdg-13 { background: linear-gradient(135deg, #3f7e44, #2d5a31); }
        .sdg-14 { background: linear-gradient(135deg, #0a97d9, #0066cc); }
        .sdg-15 { background: linear-gradient(135deg, #56c02b, #3d8b21); }
        .sdg-16 { background: linear-gradient(135deg, #00689d, #004d7a); }
        .sdg-17 { background: linear-gradient(135deg, #19486a, #0f2c3d); }

        @media (max-width: 768px) {
            .header h1 {
                font-size: 2.2em;
            }

            .dropdown-container {
                flex-direction: column;
                gap: 20px;
            }

            .dropdown-wrapper {
                padding: 16px;
            }

            select {
                min-width: 200px;
                font-size: 15px;
            }

            .chart {
                height: 350px;
                gap: 8px;
                padding: 20px 0;
            }

            .label {
                font-size: 11px;
            }

            .bar {
                min-width: 35px;
            }

            .chart-container {
                padding: 25px;
            }
        }

        @media (max-width: 480px) {
            .main-content-wrapper {
                padding: 15px;
            }

            .header h1 {
                font-size: 1.8em;
            }

            .chart {
                height: 300px;
                gap: 6px;
            }

            .bar {
                min-width: 25px;
            }

            .label {
                font-size: 10px;
            }
        }
    </style>
</head>
<body>
     @include('layout.navbar_pemeringkatan')

    <div class="main-content-wrapper">
        <div class="header">
            <h1>Kegiatan Sustainability</h1>
            <p>Sustainable Development Goals Monitoring</p>
        </div>

        <div class="dropdown-container">
            <div class="dropdown-wrapper">
                <label for="year-select">📅 Tahun</label>
                <select id="year-select" onchange="updateCharts()"class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-indigo-400 text-base font-medium bg-white shadow-sm transition">>
                    <option value="2024">2024</option>
                    <option value="2025" selected>2025</option>
                </select>
            </div>
        </div>

        <div class="chart-section">
            <h2 class="chart-title" id="year-chart-title">Progress Kegiatan Sustainability Tahun 2025</h2>
            <div class="chart-container">
                <div class="chart" id="year-chart"></div>
                <div class="chart-labels" id="year-labels"></div>
            </div>
        </div>

        <div class="faculty-section">
            <div class="dropdown-container">
                <div class="dropdown-wrapper">
                    <label for="faculty-select">🏛️ Fakultas</label>
                    <select id="faculty-select" onchange="updateFacultyChart()"  class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-indigo-400 text-base font-medium bg-white shadow-sm transition">
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
                    <div class="chart" id="faculty-chart"></div>
                    <div class="chart-labels" id="faculty-labels"></div>
                </div>
            </div>
        </div>
    </div>

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

    const sdgColors = [
        'sdg-1', 'sdg-2', 'sdg-3', 'sdg-4', 'sdg-5', 'sdg-6', 'sdg-7', 'sdg-8', 'sdg-9',
        'sdg-10', 'sdg-11', 'sdg-12', 'sdg-13', 'sdg-14', 'sdg-15', 'sdg-16', 'sdg-17'
    ];

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

        // Handle case where all values are zero
        const maxValue = Math.max(...data) || 1;
        
        data.forEach((value, index) => {
            const bar = document.createElement('div');
            bar.className = `bar ${sdgColors[index]}`;
            bar.style.height = `${(value / maxValue) * 100}%`;
            bar.setAttribute('data-value', `${value}`);
            bar.title = `${goals[index]}: ${value} Kegiatan`;
            bar.style.animationDelay = `${index * 0.1}s`;
            chartContainer.appendChild(bar);

            const label = document.createElement('div');
            label.className = 'label';
            label.textContent = goals[index];
            labelsContainer.appendChild(label);
        });
    }

    async function updateYearChart() {
        const year = document.getElementById('year-select').value;
        try {
            const response = await fetch(`/Pemeringkatan/kegiatansustainability/yearly?year=${year}`);
            if (!response.ok) throw new Error('Network response was not ok');
            
            const data = await response.json();
            document.getElementById('year-chart-title').textContent = `Progress Kegiatan Sustainability Tahun ${year}`;
            createChart('year-chart', 'year-labels', data, sdgGoals);
        } catch (error) {
            console.error('Error fetching yearly data:', error);
        }
    }

    async function updateFacultyChart() {
        const faculty = document.getElementById('faculty-select').value;
        const year = document.getElementById('year-select').value;
        
        try {
            const response = await fetch(`/Pemeringkatan/kegiatansustainability/faculty?faculty=${faculty.toLowerCase()}&year=${year}`);
            if (!response.ok) throw new Error('Network response was not ok');
            
            const data = await response.json();
            document.getElementById('faculty-chart-title').textContent = 
                `Progress Kegiatan Sustainability ${facultyNames[faculty]} Tahun ${year}`;
            createChart('faculty-chart', 'faculty-labels', data, sdgGoals);
        } catch (error) {
            console.error('Error fetching faculty data:', error);
        }
    }

    function updateCharts() {
        updateYearChart();
        updateFacultyChart();
    }

    document.addEventListener('DOMContentLoaded', function() {
        updateCharts();
    });
</script>
    <!-- Uncomment when you have the footer component -->
     @include('layout.footer') 
</body>
</html>