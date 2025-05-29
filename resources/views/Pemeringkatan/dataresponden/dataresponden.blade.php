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
            padding-top: 40px;
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
            padding: 40px 40px 20px 40px;
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            max-width: 1400px;
            margin: 0 auto;
            position: relative;
        }

        .chart-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .chart {
            display: flex;
            align-items: end;
            justify-content: center;
            height: 400px;
            padding: 20px 0;
            border-bottom: 3px solid #ecf0f1;
            gap: 20px;
            position: relative;
            width: 100%;
        }

        .chart.overview {
            justify-content: center;
            gap: 80px; /* Adjusted gap for potentially 3 bars */
        }

        .chart.faculty {
            justify-content: space-between;
            gap: 15px;
        }

        .bar-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
        }

        .bar {
            border-radius: 8px 8px 0 0;
            position: relative;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            animation: growUp 1.2s ease-out;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .bar.overview-bar {
            width: 100px; /* Adjusted width for potentially 3 bars */
            min-width: 90px;
        }

        .bar.faculty-bar {
            width: 80px;
            min-width: 60px;
        }

        .bar:hover {
            transform: scale(1.08) translateY(-5px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.2);
            z-index: 50;
        }

        .tooltip {
            position: absolute;
            background: rgba(44, 62, 80, 0.95);
            color: white;
            padding: 10px 15px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            white-space: nowrap;
            pointer-events: none;
            z-index: 1000;
            opacity: 0;
            transition: opacity 0.3s ease;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
        }

        .tooltip::after {
            content: '';
            position: absolute;
            top: 100%;
            left: 50%;
            transform: translateX(-50%);
            border: 6px solid transparent;
            border-top-color: rgba(44, 62, 80, 0.95);
        }

        .tooltip.show {
            opacity: 1;
        }

        .chart-labels {
            display: flex;
            justify-content: center;
            margin-top: 20px;
            gap: 20px;
            width: 100%;
        }

        .chart-labels.overview {
            gap: 80px; /* Adjusted gap for potentially 3 labels */
        }

        .chart-labels.faculty {
            justify-content: space-between;
            gap: 15px;
        }

        .label {
            text-align: center;
            font-size: 16px;
            color: #2c3e50;
            font-weight: 600;
            line-height: 1.3;
            padding: 10px 5px;
            transition: color 0.3s ease;
        }

        .label.overview-label {
            width: 100px;  /* Adjusted width for potentially 3 labels */
            font-size: 18px;
            color: #2c3e50;
        }

        .label.faculty-label {
            width: 80px;
            min-width: 60px;
            font-size: 12px;
            word-wrap: break-word;
        }

        .label:hover {
            color: #667eea;
            font-weight: 700;
            transform: translateY(-2px);
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

        .section-divider {
            border-top: 4px solid #ecf0f1;
            padding-top: 50px;
            margin-top: 40px;
        }

        .loading {
            text-align: center;
            padding: 40px;
            color: #7f8c8d;
            font-size: 18px;
        }

        .loading::after {
            content: '';
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid #f3f3f3;
            border-top: 3px solid #667eea;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-left: 10px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Category Colors */
        .total { background: linear-gradient(135deg, #667eea, #764ba2); } /* For total responden bar */
        .employer { background: linear-gradient(135deg, #43e97b, #38f9d7); }
        .academic { background: linear-gradient(135deg, #4facfe, #00f2fe); }

        /* Faculty Colors */
        .faculty-fip { background: linear-gradient(135deg, #e5233c, #c41e3a); }
        .faculty-fbs { background: linear-gradient(135deg, #dda73a, #bf9000); }
        .faculty-fmipa { background: linear-gradient(135deg, #4c9f38, #2d5016); }
        .faculty-ft { background: linear-gradient(135deg, #c5192d, #8b0000); }
        .faculty-fis { background: linear-gradient(135deg, #ff3a21, #e73c7e); }
        .faculty-fe { background: linear-gradient(135deg, #26bde2, #1a8fb8); }
        .faculty-fpp { background: linear-gradient(135deg, #fcc30b, #dd9900); }
        .faculty-fik { background: linear-gradient(135deg, #a21942, #8b1538); }
        
        /* Status Colors (ensure these classes provide distinct backgrounds if not already covered by faculty colors) */
        /* If status colors are to be unique, define them here like .status-belum, .status-done etc. */
        /* For now, re-using some faculty colors for demonstration as per original file */
        .status-belum { background: linear-gradient(135deg, #e5233c, #c41e3a); } /* Example color */
        .status-done { background: linear-gradient(135deg, #43e97b, #38f9d7); } /* Example color */
        .status-dones { background: linear-gradient(135deg, #4facfe, #00f2fe); } /* Example color */
        .status-clear { background: linear-gradient(135deg, #667eea, #764ba2); } /* Example color */


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
                gap: 15px;
                padding: 15px 0;
            }

            .chart.overview {
                gap: 40px; /* Adjusted */
            }

            .chart.faculty {
                gap: 10px;
            }

            .chart-labels.overview {
                gap: 40px; /* Adjusted */
            }

            .chart-labels.faculty {
                gap: 10px;
            }

            .bar.overview-bar {
                width: 80px; /* Adjusted */
                min-width: 70px;
            }

            .bar.faculty-bar {
                width: 60px;
                min-width: 45px;
            }

            .label.overview-label {
                width: 80px; /* Adjusted */
                font-size: 16px;
            }

            .label.faculty-label {
                width: 60px;
                min-width: 45px;
                font-size: 10px;
            }

            .chart-container {
                padding: 30px 20px 15px 20px;
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
                gap: 8px;
                padding: 10px 0;
            }

            .chart.overview {
                gap: 20px; /* Adjusted */
            }

            .chart-labels.overview {
                gap: 20px; /* Adjusted */
            }

            .bar.overview-bar {
                width: 70px; /* Adjusted */
                min-width: 60px;
            }

            .bar.faculty-bar {
                width: 40px;
                min-width: 35px;
            }

            .label.overview-label {
                width: 70px; /* Adjusted */
                font-size: 14px;
            }

            .label.faculty-label {
                width: 40px;
                min-width: 35px;
                font-size: 9px;
            }
        }
    </style>
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

    <script>
        // Configuration
        const facultyMapping = {
            'fip': 'FIP',
            'fbs': 'FBS', 
            'fmipa': 'FMIPA',
            'ft': 'FT',
            'fis': 'FIS',
            'fe': 'FE',
            'fpp': 'FPP',
            'fik': 'FIK'
        };

        const facultyFullNames = {
            'FIP': 'Fakultas Ilmu Pendidikan',
            'FBS': 'Fakultas Bahasa dan Seni',
            'FMIPA': 'Fakultas Matematika dan IPA',
            'FT': 'Fakultas Teknik',
            'FIS': 'Fakultas Ilmu Sosial',
            'FE': 'Fakultas Ekonomi',
            'FPP': 'Fakultas Pendidikan Psikologi',
            'FIK': 'Fakultas Ilmu Keolahragaan'
        };

        // Adjusted overviewColors to match the new three-bar setup
        const overviewColors = ['employer', 'academic', 'total']; // CSS classes for styling
        const facultyColors = ['faculty-fip', 'faculty-fbs', 'faculty-fmipa', 'faculty-ft', 'faculty-fis', 'faculty-fe', 'faculty-fpp', 'faculty-fik'];
        // Define specific CSS classes for status bars for clarity, or use existing ones if appropriate
        const statusColors = ['status-belum', 'status-done', 'status-dones', 'status-clear'];


        // Global data storage (not strictly needed with current fetch-on-update approach)
        // let allRespondenData = []; // To store initially fetched data

        // Custom tooltip functionality
        const tooltip = document.getElementById('custom-tooltip');

        function showTooltip(event, text) {
            tooltip.textContent = text;
            tooltip.style.left = event.pageX + 15 + 'px'; // Offset slightly from cursor
            tooltip.style.top = (event.pageY - 50) + 'px'; // Position above cursor
            tooltip.classList.add('show');
        }

        function hideTooltip() {
            tooltip.classList.remove('show');
        }

        // Fetch data from Laravel backend
        async function fetchRespondenData() {
            try {
                const response = await fetch('/api/responden-chart-data', { // Ensure this route is correct
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });

                if (!response.ok) {
                    console.error('Network response was not ok', response);
                    return null; // Return null on error
                }
                return await response.json();
            } catch (error) {
                console.error('Error fetching data:', error);
                return null; // Return null on error
            }
        }

        // Create overview chart (employer vs Academic vs Total)
        function createOverviewChart(dataCounts, categories, colorClasses) {
            const chartContainer = document.getElementById('overview-chart');
            const labelsContainer = document.getElementById('overview-labels');
            const loadingElement = document.getElementById('overview-loading');
            
            chartContainer.innerHTML = '';
            labelsContainer.innerHTML = '';

            // Check if dataCounts is valid and has values
            if (!dataCounts || dataCounts.length === 0 || dataCounts.every(val => val === 0 && categories.length > 0) ) {
                 // If all counts are zero, we might still want to show 0-height bars
                 // So, only show "Tidak ada data" if there are no categories to even attempt to plot
                if (categories.length === 0) {
                    loadingElement.textContent = 'Tidak ada kategori untuk ditampilkan.';
                    loadingElement.style.display = 'block';
                    chartContainer.style.display = 'none';
                    labelsContainer.style.display = 'none';
                    return;
                }
            }
            
            loadingElement.style.display = 'none';
            chartContainer.style.display = 'flex';
            labelsContainer.style.display = 'flex';

            const maxValue = Math.max(...dataCounts, 1); // Use Math.max(...dataCounts, 1) to avoid division by zero if all are 0
            
            dataCounts.forEach((value, index) => {
                const barContainer = document.createElement('div');
                barContainer.className = 'bar-container';
                
                const bar = document.createElement('div');
                // Use colorClasses to assign CSS classes for bar styling
                bar.className = `bar overview-bar ${colorClasses[index]}`; 
                bar.style.height = `${maxValue > 0 ? (value / maxValue) * 320 : 0}px`;
                bar.style.animationDelay = `${index * 0.2}s`;

                bar.addEventListener('mouseenter', (e) => {
                    showTooltip(e, `${categories[index]}: ${value} orang`);
                });
                bar.addEventListener('mousemove', (e) => { // Keep tooltip position updated
                    tooltip.style.left = e.pageX + 15 + 'px';
                    tooltip.style.top = (e.pageY - 50) + 'px';
                });
                bar.addEventListener('mouseleave', hideTooltip);
                
                barContainer.appendChild(bar);
                chartContainer.appendChild(barContainer);

                const label = document.createElement('div');
                label.className = 'label overview-label';
                label.textContent = categories[index];
                labelsContainer.appendChild(label);
            });
        }
        
        // Create faculty chart
        function createFacultyChart(containerId, labelsId, loadingId, dataCounts, facultyDisplayNames, colorClasses) {
            const chartContainer = document.getElementById(containerId);
            const labelsContainer = document.getElementById(labelsId);
            const loadingElement = document.getElementById(loadingId);
            
            chartContainer.innerHTML = '';
            labelsContainer.innerHTML = '';

            if (!dataCounts || facultyDisplayNames.length === 0) {
                loadingElement.textContent = 'Tidak ada data fakultas untuk ditampilkan.';
                loadingElement.style.display = 'block';
                chartContainer.style.display = 'none';
                labelsContainer.style.display = 'none';
                return;
            }
            // If dataCounts might be all zeros, still proceed to draw 0-height bars.
            // const allZero = dataCounts.every(val => val === 0);
            // if (allZero) {
            //    loadingElement.textContent = 'Tidak ada data untuk filter ini.'; // Or just show 0-height bars
            // }


            loadingElement.style.display = 'none';
            chartContainer.style.display = 'flex';
            labelsContainer.style.display = 'flex';

            const maxValue = Math.max(...dataCounts, 1); // Use Math.max(...dataCounts, 1) to avoid division by zero
            
            dataCounts.forEach((value, index) => {
                const barContainer = document.createElement('div');
                barContainer.className = 'bar-container';
                
                const bar = document.createElement('div');
                bar.className = `bar faculty-bar ${colorClasses[index % colorClasses.length]}`; // Cycle through colors if not enough
                bar.style.height = `${maxValue > 0 ? (value / maxValue) * 280 : 0}px`;
                bar.style.animationDelay = `${index * 0.1}s`;

                bar.addEventListener('mouseenter', (e) => {
                    const fullName = facultyFullNames[facultyDisplayNames[index]] || facultyDisplayNames[index];
                    showTooltip(e, `${fullName}: ${value} orang`);
                });
                bar.addEventListener('mousemove', (e) => { // Keep tooltip position updated
                    tooltip.style.left = e.pageX + 15 + 'px';
                    tooltip.style.top = (e.pageY - 50) + 'px';
                });
                bar.addEventListener('mouseleave', hideTooltip);
                
                barContainer.appendChild(bar);
                chartContainer.appendChild(barContainer);

                const label = document.createElement('div');
                label.className = 'label faculty-label';
                label.textContent = facultyDisplayNames[index]; // Use the display name (e.g., FIP)
                labelsContainer.appendChild(label);
            });
        }

        // Create status distribution chart (reuses createOverviewChart logic)
        function createStatusChart(dataCounts, categories, colorClasses) {
            const chartContainer = document.getElementById('status-chart');
            const labelsContainer = document.getElementById('status-labels');
            const loadingElement = document.getElementById('status-loading');

            chartContainer.innerHTML = '';
            labelsContainer.innerHTML = '';

            if (!dataCounts || dataCounts.length === 0 || dataCounts.every(val => val === 0 && categories.length > 0)) {
                 if (categories.length === 0) {
                    loadingElement.textContent = 'Tidak ada status untuk ditampilkan.';
                    loadingElement.style.display = 'block';
                    chartContainer.style.display = 'none';
                    labelsContainer.style.display = 'none';
                    return;
                }
            }

            loadingElement.style.display = 'none';
            chartContainer.style.display = 'flex';
            labelsContainer.style.display = 'flex';

            const maxValue = Math.max(...dataCounts, 1);

            dataCounts.forEach((value, index) => {
                const barContainer = document.createElement('div');
                barContainer.className = 'bar-container';

                const bar = document.createElement('div');
                bar.className = `bar overview-bar ${colorClasses[index % colorClasses.length]}`;
                bar.style.height = `${maxValue > 0 ? (value / maxValue) * 320 : 0}px`;
                bar.style.animationDelay = `${index * 0.2}s`;

                bar.addEventListener('mouseenter', (e) => {
                    showTooltip(e, `${categories[index]}: ${value} responden`);
                });
                bar.addEventListener('mousemove', (e) => {
                    tooltip.style.left = e.pageX + 15 + 'px';
                    tooltip.style.top = (e.pageY - 50) + 'px';
                });
                bar.addEventListener('mouseleave', hideTooltip);

                barContainer.appendChild(bar);
                chartContainer.appendChild(barContainer);

                const label = document.createElement('div');
                label.className = 'label overview-label';
                label.textContent = categories[index];
                labelsContainer.appendChild(label);
            });
        }


        // Update all charts
        async function updateCharts() {
            const selectedYear = document.getElementById('year-select').value;
            const selectedFacultyCode = document.getElementById('faculty-select').value; // This will be 'fip', 'fbs', etc. or ""
            
            // Show loading states
            document.getElementById('overview-loading').style.display = 'block';
            document.getElementById('employer-loading').style.display = 'block';
            document.getElementById('academic-loading').style.display = 'block';
            document.getElementById('status-loading').style.display = 'block';
            
            document.getElementById('overview-chart').style.display = 'none';
            document.getElementById('overview-labels').style.display = 'none';
            document.getElementById('employer-chart').style.display = 'none';
            document.getElementById('employer-labels').style.display = 'none';
            document.getElementById('academic-chart').style.display = 'none';
            document.getElementById('academic-labels').style.display = 'none';
            document.getElementById('status-chart').style.display = 'none';
            document.getElementById('status-labels').style.display = 'none';

            // Update titles with selected year
            document.getElementById('overview-chart-title').textContent = `Total Responden Tahun ${selectedYear}`;
            document.getElementById('employer-faculty-chart-title').textContent = `Employee Berdasarkan Fakultas Tahun ${selectedYear}`;
            document.getElementById('academic-faculty-chart-title').textContent = `Academic Berdasarkan Fakultas Tahun ${selectedYear}`;
            document.getElementById('status-chart-title').textContent = `Distribusi Status Responden Tahun ${selectedYear}`;

            // Fetch fresh data
            const rawData = await fetchRespondenData();
            
            if (!rawData) {
                ['overview-loading', 'employer-loading', 'academic-loading', 'status-loading'].forEach(id => {
                    document.getElementById(id).textContent = 'Error memuat data. Coba lagi nanti.';
                    document.getElementById(id).style.display = 'block';
                });
                return;
            }

            // Filter data by selected year
            const dataForSelectedYear = rawData.filter(item => item.year == selectedYear);

            if (dataForSelectedYear.length === 0) {
                const noDataMessage = `Tidak ada data responden untuk tahun ${selectedYear}.`;
                ['overview-loading', 'employer-loading', 'academic-loading', 'status-loading'].forEach(id => {
                    document.getElementById(id).textContent = noDataMessage;
                    document.getElementById(id).style.display = 'block';
                });
                // Ensure charts remain hidden
                createOverviewChart([], [], []); // Call with empty to clear if previously drawn
                createFacultyChart('employer-chart', 'employer-labels', 'employer-loading', [], [], []);
                createFacultyChart('academic-chart', 'academic-labels', 'academic-loading', [], [], []);
                createStatusChart([], [], []);
                return;
            }
            
            // Data for Overview and Status charts (filtered by year AND selected faculty if any)
            let filteredDataForOverviewAndStatus = [...dataForSelectedYear];
            if (selectedFacultyCode) { // if a specific faculty is selected
                filteredDataForOverviewAndStatus = filteredDataForOverviewAndStatus.filter(item => item.fakultas && item.fakultas.toLowerCase() === selectedFacultyCode);
            }

            // --- 1. Process Overview Chart Data (employer, Academic, Total) ---
            const employerCount = filteredDataForOverviewAndStatus.filter(item => item.category === 'employer').length;
            const academicCount = filteredDataForOverviewAndStatus.filter(item => item.category === 'academic').length;
            const totalRespondenCount = employerCount + academicCount; 
            
            const overviewDataCounts = [employerCount, academicCount, totalRespondenCount];
            const overviewCategories = ['employer', 'Academic', 'Total Responden'];
            createOverviewChart(overviewDataCounts, overviewCategories, overviewColors);

            // --- 2. Process Faculty Data for employer & Academic (uses dataForSelectedYear - only filtered by year) ---
            const employerFacultyDataCounts = [];
            const academicFacultyDataCounts = [];
            const facultyDisplayNamesForChart = []; // e.g., ['FIP', 'FBS', ...]

            Object.keys(facultyMapping).forEach(facultyKeyLower => { // 'fip', 'fbs', ...
                const facultyDisplayName = facultyMapping[facultyKeyLower]; // 'FIP', 'FBS', ...
                
                const employerInFaculty = dataForSelectedYear.filter(item => 
                    item.fakultas && item.fakultas.toLowerCase() === facultyKeyLower && item.category === 'employer'
                ).length;
                const academicInFaculty = dataForSelectedYear.filter(item => 
                    item.fakultas && item.fakultas.toLowerCase() === facultyKeyLower && item.category === 'academic'
                ).length;

                employerFacultyDataCounts.push(employerInFaculty);
                academicFacultyDataCounts.push(academicInFaculty);
                facultyDisplayNamesForChart.push(facultyDisplayName);
            });

            createFacultyChart('employer-chart', 'employer-labels', 'employer-loading', 
                employerFacultyDataCounts, facultyDisplayNamesForChart, facultyColors);
            
            createFacultyChart('academic-chart', 'academic-labels', 'academic-loading', 
                academicFacultyDataCounts, facultyDisplayNamesForChart, facultyColors);

            const statusCounts = {
                'belum': 0,
                'done': 0,
                'dones': 0, 
                'clear': 0
            };
            const statusLabels = ['Belum', 'Done', 'Dones', 'Clear']; 

            filteredDataForOverviewAndStatus.forEach(item => {
                if (statusCounts.hasOwnProperty(item.status)) {
                    statusCounts[item.status]++;
                } else if (item.status) { // Log unexpected status
                    console.warn(`Unexpected status value: ${item.status}`);
                }
            });
            
            // Ensure the order of statusDataCounts matches statusLabels
            const statusDataCounts = statusLabels.map(label => statusCounts[label.toLowerCase()] || 0);
            // If status values in db are exactly 'belum', 'done', 'dones', 'clear':
            // const statusDataCounts = [statusCounts.belum, statusCounts.done, statusCounts.dones, statusCounts.clear];

            createStatusChart(statusDataCounts, statusLabels, statusColors);
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            updateCharts();
        });

        // Hide tooltip when clicking elsewhere (optional, if it gets stuck)
        // document.addEventListener('click', (event) => {
        //    if (!tooltip.contains(event.target) && !event.target.classList.contains('bar')) {
        //        hideTooltip();
        //    }
        // });
    </script>
</body>
</html>