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