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
            gap: 80px;
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
            width: 120px;
            min-width: 120px;
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

        .bar::before {
            content: attr(data-value);
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%) translateY(-10px);
            font-size: 14px;
            font-weight: 600;
            color: white;
            background: rgba(44, 62, 80, 0.95);
            padding: 8px 12px;
            border-radius: 8px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.3);
            opacity: 0;
            transition: all 0.3s ease;
            white-space: nowrap;
            z-index: 1000;
            pointer-events: none;
        }

        .bar::after {
            content: '';
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%) translateY(-4px);
            border: 6px solid transparent;
            border-top-color: rgba(44, 62, 80, 0.95);
            opacity: 0;
            transition: opacity 0.3s ease;
            z-index: 1000;
            pointer-events: none;
        }

        .bar:hover::before,
        .bar:hover::after {
            opacity: 1;
        }

        /* Custom tooltip for better visibility */
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
            gap: 80px;
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
            width: 120px;
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

        /* Category Colors */
        .total { background: linear-gradient(135deg, #667eea, #764ba2); }
        .employee { background: linear-gradient(135deg, #43e97b, #38f9d7); }
        .academic { background: linear-gradient(135deg, #4facfe, #00f2fe); }

        /* Faculty Colors */
        .faculty-1 { background: linear-gradient(135deg, #e5233c, #c41e3a); }
        .faculty-2 { background: linear-gradient(135deg, #dda73a, #bf9000); }
        .faculty-3 { background: linear-gradient(135deg, #4c9f38, #2d5016); }
        .faculty-4 { background: linear-gradient(135deg, #c5192d, #8b0000); }
        .faculty-5 { background: linear-gradient(135deg, #ff3a21, #e73c7e); }
        .faculty-6 { background: linear-gradient(135deg, #26bde2, #1a8fb8); }
        .faculty-7 { background: linear-gradient(135deg, #fcc30b, #dd9900); }
        .faculty-8 { background: linear-gradient(135deg, #a21942, #8b1538); }

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
                gap: 40px;
            }

            .chart.faculty {
                gap: 10px;
            }

            .chart-labels.overview {
                gap: 40px;
            }

            .chart-labels.faculty {
                gap: 10px;
            }

            .bar.overview-bar {
                width: 100px;
                min-width: 80px;
            }

            .bar.faculty-bar {
                width: 60px;
                min-width: 45px;
            }

            .label.overview-label {
                width: 100px;
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
                gap: 20px;
            }

            .chart-labels.overview {
                gap: 20px;
            }

            .bar.overview-bar {
                width: 80px;
                min-width: 70px;
            }

            .bar.faculty-bar {
                width: 40px;
                min-width: 35px;
            }

            .label.overview-label {
                width: 80px;
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
     @include('layout.navbar_pemeringkatan')
<body>
    <div class="main-content-wrapper">
        <div class="header">
            <h1>Data Responden</h1>
        </div>

        <div class="dropdown-container">
            <div class="dropdown-wrapper">
                <label for="year-select">📅 Tahun</label>
                <select id="year-select" onchange="updateOverviewChart()" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-indigo-400 text-base font-medium bg-white shadow-sm transition">
                    <option value="2024">2024</option>
                    <option value="2025" selected>2025</option>
                </select>
            </div>
        </div>

        <!-- Custom tooltip element -->
        <div id="custom-tooltip" class="tooltip"></div>

        <!-- Overview Chart: Total Employee & Academic -->
        <div class="chart-section">
            <h2 class="chart-title" id="overview-chart-title">Total Employee dan Academic Tahun 2025</h2>
            <div class="chart-container">
                <div class="chart-wrapper">
                    <div class="chart overview" id="overview-chart"></div>
                    <div class="chart-labels overview" id="overview-labels"></div>
                </div>
            </div>
        </div>

        <!-- Employee by Faculty -->
        <div class="chart-section section-divider">
            <h2 class="chart-title">Employee Berdasarkan Fakultas</h2>
            <div class="chart-container">
                <div class="chart-wrapper">
                    <div class="chart faculty" id="employee-chart"></div>
                    <div class="chart-labels faculty" id="employee-labels"></div>
                </div>
            </div>
        </div>

        <!-- Academic by Faculty -->
        <div class="chart-section section-divider">
            <h2 class="chart-title">Academic Berdasarkan Fakultas</h2>
            <div class="chart-container">
                <div class="chart-wrapper">
                    <div class="chart faculty" id="academic-chart"></div>
                    <div class="chart-labels faculty" id="academic-labels"></div>
                </div>
            </div>
        </div>
    </div>
    @include('layout.footer') 
    <script>
        const overviewCategories = ["Employee", "Academic"];
        const facultyNames = ["FIP", "FBS", "FMIPA", "FT", "FIS", "FE", "FPP", "FIK"];
        const facultyFullNames = {
            FIP: "Fakultas Ilmu Pendidikan",
            FBS: "Fakultas Bahasa dan Seni",
            FMIPA: "Fakultas Matematika dan IPA",
            FT: "Fakultas Teknik",
            FIS: "Fakultas Ilmu Sosial",
            FE: "Fakultas Ekonomi",
            FPP: "Fakultas Pendidikan Psikologi",
            FIK: "Fakultas Ilmu Keolahragaan"
        };
        
        // Colors
        const overviewColors = ['employee', 'academic'];
        const facultyColors = ['faculty-1', 'faculty-2', 'faculty-3', 'faculty-4', 'faculty-5', 'faculty-6', 'faculty-7', 'faculty-8'];

        // Sample data - you can modify these numbers as needed
        const overviewData = {
            2024: [100, 110], // [Employee, Academic] for 2024
            2025: [70, 100]  // [Employee, Academic] for 2025
        };

        // Employee data by faculty
        const employeeData = [55, 58, 48, 68, 60, 52, 42, 45]; // FIP, FBS, FMIPA, FT, FIS, FE, FPP, FIK

        // Academic data by faculty
        const academicData = [30, 34, 30, 42, 35, 36, 23, 27]; // FIP, FBS, FMIPA, FT, FIS, FE, FPP, FIK

        // Custom tooltip functionality
        const tooltip = document.getElementById('custom-tooltip');

        function showTooltip(event, text) {
            tooltip.textContent = text;
            tooltip.style.left = event.pageX + 'px';
            tooltip.style.top = (event.pageY - 60) + 'px';
            tooltip.classList.add('show');
        }

        function hideTooltip() {
            tooltip.classList.remove('show');
        }

        function createOverviewChart(containerId, labelsId, data, categories, colors) {
            const chartContainer = document.getElementById(containerId);
            const labelsContainer = document.getElementById(labelsId);
            
            chartContainer.innerHTML = '';
            labelsContainer.innerHTML = '';

            const maxValue = Math.max(...data);
            
            data.forEach((value, index) => {
                // Create bar container
                const barContainer = document.createElement('div');
                barContainer.className = 'bar-container';
                
                // Create bar
                const bar = document.createElement('div');
                bar.className = `bar overview-bar ${colors[index]}`;
                bar.style.height = `${(value / maxValue) * 320}px`;
                bar.setAttribute('data-value', `${value} orang`);
                bar.title = `${categories[index]}: ${value} orang`;
                
                // Add animation delay for staggered effect
                bar.style.animationDelay = `${index * 0.2}s`;

                // Enhanced tooltip events
                bar.addEventListener('mouseenter', (e) => {
                    showTooltip(e, `${categories[index]}: ${value} orang`);
                });

                bar.addEventListener('mousemove', (e) => {
                    tooltip.style.left = e.pageX + 'px';
                    tooltip.style.top = (e.pageY - 60) + 'px';
                });

                bar.addEventListener('mouseleave', hideTooltip);
                
                barContainer.appendChild(bar);
                chartContainer.appendChild(barContainer);

                // Create label
                const label = document.createElement('div');
                label.className = 'label overview-label';
                label.textContent = categories[index];
                labelsContainer.appendChild(label);
            });
        }

        function createFacultyChart(containerId, labelsId, data, facultyNames, colors) {
            const chartContainer = document.getElementById(containerId);
            const labelsContainer = document.getElementById(labelsId);
            
            chartContainer.innerHTML = '';
            labelsContainer.innerHTML = '';

            const maxValue = Math.max(...data);
            
            data.forEach((value, index) => {
                // Create bar container
                const barContainer = document.createElement('div');
                barContainer.className = 'bar-container';
                
                // Create bar
                const bar = document.createElement('div');
                bar.className = `bar faculty-bar ${colors[index]}`;
                bar.style.height = `${(value / maxValue) * 280}px`;
                bar.setAttribute('data-value', `${value} orang`);
                bar.title = `${facultyNames[index]}: ${value} orang`;
                
                // Add animation delay for staggered effect
                bar.style.animationDelay = `${index * 0.1}s`;

                // Enhanced tooltip events
                bar.addEventListener('mouseenter', (e) => {
                    const fullName = facultyFullNames[facultyNames[index]] || facultyNames[index];
                    showTooltip(e, `${fullName}: ${value} orang`);
                });

                bar.addEventListener('mousemove', (e) => {
                    tooltip.style.left = e.pageX + 'px';
                    tooltip.style.top = (e.pageY - 60) + 'px';
                });

                bar.addEventListener('mouseleave', hideTooltip);
                
                barContainer.appendChild(bar);
                chartContainer.appendChild(barContainer);

                // Create label
                const label = document.createElement('div');
                label.className = 'label faculty-label';
                label.textContent = facultyNames[index];
                labelsContainer.appendChild(label);
            });
        }

        function updateOverviewChart() {
            const selectedYear = document.getElementById('year-select').value;
            const data = overviewData[selectedYear];
            const titleElement = document.getElementById('overview-chart-title');
            titleElement.textContent = `Total Employee dan Academic Tahun ${selectedYear}`;
            createOverviewChart('overview-chart', 'overview-labels', data, overviewCategories, overviewColors);
        }

        function initializeCharts() {
            // Initialize overview chart
            updateOverviewChart();
            
            // Initialize employee by faculty chart
            createFacultyChart('employee-chart', 'employee-labels', employeeData, facultyNames, facultyColors);
            
            // Initialize academic by faculty chart
            createFacultyChart('academic-chart', 'academic-labels', academicData, facultyNames, facultyColors);
        }

        // Initialize all charts when page loads
        document.addEventListener('DOMContentLoaded', function() {
            initializeCharts();
        });

        // Hide tooltip when clicking elsewhere
        document.addEventListener('click', hideTooltip);
    </script>
</body>
</html>