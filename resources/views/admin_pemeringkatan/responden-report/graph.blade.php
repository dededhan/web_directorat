@extends('admin_pemeringkatan.index')

@section('contentadmin_pemeringkatan')
    <div class="p-4 sm:p-6 lg:p-8 xl:p-10 2xl:p-12 bg-gray-50 min-h-full font-sans">
        <div class="max-w-[1920px] mx-auto">

        {{-- Header with Print Button --}}
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 print:hidden">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Laporan Grafik Responden</h1>
            </div>
            <button id="print-button"
                class="mt-4 sm:mt-0 flex items-center gap-2 bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg shadow-md hover:bg-blue-700 transition duration-300">
                <i class='bx bxs-printer text-xl'></i>
                <span>Cetak Laporan</span>
            </button>
        </div>


        {{-- Filter Section --}}
        <div class="bg-white p-4 rounded-xl shadow-lg mb-6 print:hidden">
            <h3 class="text-lg font-bold text-gray-700 mb-4">Filter Laporan</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 items-end">
                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-600">Tanggal Mulai</label>
                    <input type="date" id="start_date" name="start_date"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div>
                <div>
                    <label for="end_date" class="block text-sm font-medium text-gray-600">Tanggal Selesai</label>
                    <input type="date" id="end_date" name="end_date"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div>
                <div>
                    <label for="fakultas_filter" class="block text-sm font-medium text-gray-600">Fakultas</label>
                    <select id="fakultas_filter" name="fakultas_filter"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="">Semua Fakultas</option>
                    </select>
                </div>
                <div class="col-span-1 flex gap-2">
                    <button id="reset-filter-button"
                        class="w-full sm:w-auto flex items-center justify-center gap-2 bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg shadow hover:bg-blue-700 transition duration-300">
                        <i class='bx bx-refresh text-lg'></i>
                        <span>Reset Filter</span>
                    </button>
                </div>
            </div>
        </div>

        {{-- Chart Section --}}
        <div id="report-content">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                {{-- Grafik Sumber Input --}}
                <div class="bg-white p-4 sm:p-6 rounded-xl shadow-lg">
                    <h3 class="text-lg font-bold text-gray-700 mb-4 text-center">Jumlah Responden Berdasarkan Sumber Input
                    </h3>
                    <div class="h-80 w-full flex justify-center items-center">
                        <canvas id="sumberDataChart"></canvas>
                    </div>
                </div>

                {{-- Grafik Kategori --}}
                <div class="bg-white p-4 sm:p-6 rounded-xl shadow-lg">
                    <h3 class="text-lg font-bold text-gray-700 mb-4 text-center">Jumlah Responden Berdasarkan Kategori
                    </h3>
                    <div class="h-80 w-full flex justify-center items-center">
                        <canvas id="kategoriChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-6">
                {{-- Grafik Detail Per Fakultas --}}
                <div class="bg-white p-4 sm:p-6 rounded-xl shadow-lg">
                    <h3 class="text-lg font-bold text-gray-700 mb-4">Total Input per Fakultas & Prodi</h3>
                    <div class="h-96">
                        <canvas id="detailFakultasChart"></canvas>
                    </div>
                </div>
                {{-- Grafik Input Prodi per Fakultas --}}
                <div class="bg-white p-4 sm:p-6 rounded-xl shadow-lg">
                    <h3 class="text-lg font-bold text-gray-700 mb-4">Input Prodi per Fakultas</h3>
                    <div id="prodiChartContainer" style="min-height: 400px; height: 600px;">
                        <canvas id="prodiPerFakultasChart"></canvas>
                    </div>
                </div>
                {{-- Grafik Tren Bulanan --}}
                <div class="bg-white p-4 sm:p-6 rounded-xl shadow-lg">
                    <h3 class="text-lg font-bold text-gray-700 mb-4">Tren Pengisian Responden per Bulan</h3>
                    <div class="h-96">
                        <canvas id="trenChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        @media print {
            body {
                background-color: white !important;
            }

            .p-4, .p-6, .p-8, .p-10, .p-12 {
                padding: 0 !important;
            }

            .shadow-lg {
                box-shadow: none !important;
                border: 1px solid #e2e8f0;
            }

            .print\:hidden {
                display: none !important;
            }

            .bg-white {
                page-break-inside: avoid;
            }

            .grid {
                display: block !important;
            }

            .grid > div {
                margin-bottom: 2rem;
                page-break-inside: avoid;
            }

            h1, h3 {
                color: #000 !important;
            }
        }
    </style>

    {{-- Include Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Daftarkan plugin datalabels secara global
            Chart.register(ChartDataLabels);

            // Total Labels Plugin untuk horizontal bar chart
            const totalLabelsPlugin = {
                id: 'totalLabels',
                afterDatasetsDraw(chart) {
                    const { ctx, chartArea: { top, bottom, left, right }, scales: { x, y } } = chart;
                    ctx.save();
                    
                    chart.data.datasets.forEach((dataset, datasetIndex) => {
                        const meta = chart.getDatasetMeta(datasetIndex);
                        
                        meta.data.forEach((bar, index) => {
                            const value = dataset.data[index];
                            if (value > 0) {
                                ctx.fillStyle = '#374151'; // text-gray-700
                                ctx.font = 'bold 12px sans-serif';
                                ctx.textAlign = 'left';
                                ctx.textBaseline = 'middle';
                                
                                // Position at end of horizontal bar
                                const xPos = bar.x + 5;
                                const yPos = bar.y;
                                
                                ctx.fillText(value, xPos, yPos);
                            }
                        });
                    });
                    ctx.restore();
                }
            };

            let sumberDataChart, kategoriChart, trenChart, detailFakultasChart, prodiPerFakultasChart;
            let fullProdiData = {}; // Store full prodi data for filtering

            // Loading State Management
            function showLoading() {
                document.querySelectorAll('#start_date, #end_date, #fakultas_filter, #reset-filter-button, #print-button').forEach(el => {
                    el.disabled = true;
                });
                document.querySelectorAll('canvas').forEach(canvas => {
                    canvas.style.opacity = '0.5';
                });
            }

            function hideLoading() {
                document.querySelectorAll('#start_date, #end_date, #fakultas_filter, #reset-filter-button, #print-button').forEach(el => {
                    el.disabled = false;
                });
                document.querySelectorAll('canvas').forEach(canvas => {
                    canvas.style.opacity = '1';
                });
            }

            // Error Handling
            function showErrorMessage(message) {
                const existingError = document.getElementById('error-message');
                if (existingError) existingError.remove();
                
                const errorDiv = document.createElement('div');
                errorDiv.id = 'error-message';
                errorDiv.className = 'bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-lg mb-4';
                errorDiv.innerHTML = `
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <i class='bx bx-error-circle text-2xl mr-3'></i>
                            <div>
                                <p class="font-bold">Terjadi Kesalahan</p>
                                <p class="text-sm">${message}</p>
                            </div>
                        </div>
                        <button onclick="this.parentElement.parentElement.remove()" class="text-red-700 hover:text-red-900">
                            <i class='bx bx-x text-2xl'></i>
                        </button>
                    </div>
                `;
                
                const mainContent = document.querySelector('.max-w-\\[1920px\\]');
                mainContent.insertBefore(errorDiv, mainContent.firstChild);
                
                setTimeout(() => {
                    if (document.getElementById('error-message')) {
                        document.getElementById('error-message').remove();
                    }
                }, 5000);
            }

            // Filter Persistence
            function saveFilters() {
                const filters = {
                    start_date: document.getElementById('start_date').value,
                    end_date: document.getElementById('end_date').value,
                    fakultas_filter: document.getElementById('fakultas_filter').value
                };
                sessionStorage.setItem('respondenGraphFilters', JSON.stringify(filters));
            }

            function restoreFilters() {
                const saved = sessionStorage.getItem('respondenGraphFilters');
                if (saved) {
                    try {
                        const filters = JSON.parse(saved);
                        if (filters.start_date) document.getElementById('start_date').value = filters.start_date;
                        if (filters.end_date) document.getElementById('end_date').value = filters.end_date;
                        if (filters.fakultas_filter) document.getElementById('fakultas_filter').value = filters.fakultas_filter;
                    } catch (e) {
                        console.error('Failed to restore filters:', e);
                    }
                }
            }

            function clearFilters() {
                document.getElementById('start_date').value = '';
                document.getElementById('end_date').value = '';
                document.getElementById('fakultas_filter').value = '';
                sessionStorage.removeItem('respondenGraphFilters');
            }

            // Debounce Helper
            function debounce(func, wait) {
                let timeout;
                return function executedFunction(...args) {
                    const later = () => {
                        clearTimeout(timeout);
                        func(...args);
                    };
                    clearTimeout(timeout);
                    timeout = setTimeout(later, wait);
                };
            }

            const chartColors = {
                blue: 'rgba(54, 162, 235, 0.8)',
                red: 'rgba(255, 99, 132, 0.8)',
                yellow: 'rgba(255, 206, 86, 0.8)',
                green: 'rgba(75, 192, 192, 0.8)',
                purple: 'rgba(153, 102, 255, 0.8)',
                orange: 'rgba(255, 159, 64, 0.8)',
                teal: 'rgba(0, 128, 128, 0.8)',
                pink: 'rgba(255, 192, 203, 0.8)',
                grey: 'rgba(201, 203, 207, 0.8)'
            };

            const colorPalette = Object.values(chartColors);

            async function fetchDataAndRenderCharts() {
                showLoading();
                saveFilters();

                const startDate = document.getElementById('start_date').value;
                const endDate = document.getElementById('end_date').value;
                let url = `{{ route('api.responden.graph-data') }}`;

                const params = new URLSearchParams();
                if (startDate) params.append('start_date', startDate);
                if (endDate) params.append('end_date', endDate);

                if (params.toString()) {
                    url += `?${params.toString()}`;
                }

                try {
                    const response = await fetch(url);
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    const data = await response.json();

                    renderSumberDataChart(data.sumberInput);
                    renderKategoriChart(data.kategori);
                    renderTrenChart(data.tren);
                    renderDetailFakultasChart(data.perFakultas);
                    
                    // Store full data and populate fakultas dropdown
                    fullProdiData = data.prodiPerFakultas;
                    populateFakultasDropdown(data.prodiPerFakultas);
                    renderProdiPerFakultasChart(data.prodiPerFakultas);

                } catch (error) {
                    console.error('Error fetching chart data:', error);
                    showErrorMessage('Gagal memuat data grafik. Silakan coba lagi atau hubungi administrator.');
                } finally {
                    hideLoading();
                }
            }

            function renderChart(chartInstance, canvasId, config) {
                const ctx = document.getElementById(canvasId).getContext('2d');
                if (chartInstance) {
                    chartInstance.destroy();
                }
                return new Chart(ctx, config);
            }

            // 1. Render Sumber Data Chart
            function renderSumberDataChart(data) {
                const labels = Object.keys(data);
                const values = Object.values(data);
                sumberDataChart = renderChart(sumberDataChart, 'sumberDataChart', {
                    type: 'doughnut',
                    data: {
                        labels: labels,
                        datasets: [{
                            data: values,
                            backgroundColor: [chartColors.blue, chartColors.green],
                            borderColor: '#ffffff',
                            borderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            datalabels: {
                                color: '#fff',
                                font: {
                                    weight: 'bold'
                                },
                                formatter: (value, ctx) => {
                                    let sum = 0;
                                    let dataArr = ctx.chart.data.datasets[0].data;
                                    dataArr.map(d => sum += d);
                                    if (sum === 0) return '0 (0.0%)';
                                    let percentage = (value * 100 / sum).toFixed(1) + '%';
                                    return `${value}\n(${percentage})`;
                                },
                            }
                        }
                    }
                });
            }

            // 2. Render Kategori Chart
            function renderKategoriChart(data) {
                const labels = Object.keys(data);
                const values = Object.values(data);
                kategoriChart = renderChart(kategoriChart, 'kategoriChart', {
                    type: 'pie',
                    data: {
                        labels: labels,
                        datasets: [{
                            data: values,
                            backgroundColor: [chartColors.purple, chartColors.orange],
                             borderColor: '#ffffff',
                            borderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                           datalabels: {
                                color: '#fff',
                                font: {
                                    weight: 'bold'
                                },
                                formatter: (value, ctx) => {
                                    let sum = 0;
                                    let dataArr = ctx.chart.data.datasets[0].data;
                                    dataArr.map(d => sum += d);
                                     if (sum === 0) return '0 (0.0%)';
                                    let percentage = (value * 100 / sum).toFixed(1) + '%';
                                    return `${value}\n(${percentage})`;
                                },
                            }
                        }
                    }
                });
            }

            // 3. Render Tren Chart
            function renderTrenChart(data) {
                const labels = Object.keys(data);
                const values = Object.values(data);
                trenChart = renderChart(trenChart, 'trenChart', {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Jumlah Responden',
                            data: values,
                            fill: true,
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            borderColor: chartColors.blue,
                            tension: 0.1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        },
                        plugins: {
                            datalabels: {
                               display: false
                            }
                        }
                    }
                });
            }

            // 4. Render Detail Fakultas Chart
            function renderDetailFakultasChart(data) {
                const labels = Object.keys(data);
                const values = Object.values(data);
                detailFakultasChart = renderChart(detailFakultasChart, 'detailFakultasChart', {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Total Input',
                            data: values,
                            backgroundColor: colorPalette,
                            borderColor: colorPalette,
                            borderWidth: 1
                        }]
                    },
                    options: {
                        indexAxis: 'y',
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            x: {
                                beginAtZero: true
                            }
                        },
                        plugins: {
                            legend: {
                                display: false
                            },
                            datalabels: {
                                display: false // Disable datalabels, use totalLabelsPlugin instead
                            }
                        }
                    },
                    plugins: [totalLabelsPlugin] // Apply custom total labels plugin
                });
            }

            // Populate Fakultas Dropdown
            function populateFakultasDropdown(data) {
                const select = document.getElementById('fakultas_filter');
                const currentValue = select.value;
                
                // Clear existing options except the first one
                select.innerHTML = '<option value="">Semua Fakultas</option>';
                
                const faculties = Object.keys(data).sort();
                faculties.forEach(faculty => {
                    const option = document.createElement('option');
                    option.value = faculty;
                    option.textContent = faculty;
                    select.appendChild(option);
                });
                
                // Restore previous selection if exists
                if (currentValue) {
                    select.value = currentValue;
                }
            }

            // 5. Render Prodi per Fakultas Chart
            function renderProdiPerFakultasChart(data) {
                const selectedFakultas = document.getElementById('fakultas_filter').value;
                let filteredData = data;
                
                // Filter by selected fakultas
                if (selectedFakultas) {
                    filteredData = {
                        [selectedFakultas]: data[selectedFakultas] || {}
                    };
                }
                
                // ⭐ TRANSPOSED DATA STRUCTURE: Prodi becomes Y-axis, Faculties become datasets
                const faculties = Object.keys(filteredData).sort();
                const allProdis = new Set();
                
                // Collect all unique prodi names
                faculties.forEach(faculty => {
                    Object.keys(filteredData[faculty]).forEach(prodi => allProdis.add(prodi));
                });
                
                // Sort prodi by total count (descending) for better visual hierarchy
                const prodiTotals = {};
                Array.from(allProdis).forEach(prodi => {
                    prodiTotals[prodi] = faculties.reduce((sum, faculty) => {
                        return sum + (filteredData[faculty][prodi] || 0);
                    }, 0);
                });
                
                const prodiList = Object.entries(prodiTotals)
                    .sort(([,a], [,b]) => b - a)
                    .map(([prodi]) => prodi);
                
                // ⭐ DYNAMIC HEIGHT CALCULATION
                const container = document.getElementById('prodiChartContainer');
                const minHeight = 400;
                const pixelsPerProdi = 30; // Comfortable bar height
                const padding = 120; // Top/bottom padding + legend space
                const calculatedHeight = Math.max(minHeight, (prodiList.length * pixelsPerProdi) + padding);
                container.style.height = `${calculatedHeight}px`;
                
                // ⭐ Generate distinct colors for faculties (only 8-10 items, not 50+)
                const facultyColors = generateFacultyColors(faculties.length);
                
                // ⭐ NEW: Faculties become datasets (much fewer legend items!)
                const datasets = faculties.map((faculty, index) => {
                    return {
                        label: faculty,
                        data: prodiList.map(prodi => filteredData[faculty][prodi] || 0),
                        backgroundColor: facultyColors[index],
                        borderWidth: 0,
                        maxBarThickness: 30,
                        barPercentage: 0.85,
                        categoryPercentage: 0.9
                    };
                });
                
                prodiPerFakultasChart = renderChart(prodiPerFakultasChart, 'prodiPerFakultasChart', {
                    type: 'bar',
                    data: {
                        labels: prodiList, // ⭐ Prodi on Y-axis
                        datasets: datasets  // ⭐ Faculties as datasets
                    },
                    options: {
                        indexAxis: 'y', // ⭐ HORIZONTAL BARS
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            x: {
                                beginAtZero: true,
                                stacked: false,
                                ticks: {
                                    precision: 0,
                                    font: {
                                        size: 10
                                    }
                                },
                                grid: {
                                    display: true,
                                    color: 'rgba(0, 0, 0, 0.05)'
                                },
                                title: {
                                    display: true,
                                    text: 'Jumlah Responden',
                                    font: {
                                        size: 11,
                                        weight: 'bold'
                                    }
                                }
                            },
                            y: {
                                stacked: false,
                                ticks: {
                                    autoSkip: false,
                                    font: {
                                        size: 9
                                    },
                                    callback: function(value, index) {
                                        // Truncate long prodi names
                                        const label = this.getLabelForValue(value);
                                        return label.length > 40 ? label.substring(0, 37) + '...' : label;
                                    }
                                },
                                grid: {
                                    display: false
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: true,
                                position: 'right', // ⭐ RIGHT-SIDE LEGEND (only 8-10 items now!)
                                align: 'start',
                                maxHeight: calculatedHeight - 100,
                                maxWidth: 160,
                                labels: {
                                    boxWidth: 12,
                                    font: {
                                        size: 10,
                                        family: "'Inter', sans-serif"
                                    },
                                    padding: 8,
                                    usePointStyle: true,
                                    generateLabels: (chart) => {
                                        const labels = Chart.defaults.plugins.legend.labels.generateLabels(chart);
                                        // Sort alphabetically
                                        return labels.sort((a, b) => a.text.localeCompare(b.text));
                                    }
                                }
                            },
                            datalabels: {
                                display: function(context) {
                                    // Only show labels for values > 3 to avoid clutter
                                    return context.dataset.data[context.dataIndex] > 3;
                                },
                                anchor: 'end',
                                align: 'right',
                                color: '#374151',
                                font: {
                                    size: 8,
                                    weight: 'bold'
                                },
                                formatter: function(value) {
                                    return value > 0 ? value : '';
                                },
                                clamp: true
                            },
                            tooltip: {
                                enabled: true,
                                mode: 'point',
                                intersect: true,
                                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                padding: 12,
                                titleFont: {
                                    size: 12,
                                    weight: 'bold'
                                },
                                bodyFont: {
                                    size: 11
                                },
                                callbacks: {
                                    title: function(items) {
                                        return `Prodi: ${items[0].label}`;
                                    },
                                    label: function(context) {
                                        return `${context.dataset.label}: ${context.formattedValue} responden`;
                                    },
                                    afterLabel: function(context) {
                                        // Calculate percentage within this prodi
                                        const dataIndex = context.dataIndex;
                                        const total = context.chart.data.datasets.reduce((sum, dataset) => {
                                            return sum + (dataset.data[dataIndex] || 0);
                                        }, 0);
                                        const percentage = total > 0 ? ((context.parsed.x / total) * 100).toFixed(1) : 0;
                                        return `${percentage}% dari total prodi ini`;
                                    }
                                }
                            },
                            title: {
                                display: selectedFakultas ? true : false,
                                text: selectedFakultas ? `Prodi di ${selectedFakultas}` : '',
                                font: {
                                    size: 13,
                                    weight: 'bold'
                                },
                                padding: {
                                    bottom: 15
                                }
                            }
                        },
                        interaction: {
                            mode: 'nearest',
                            axis: 'y',
                            intersect: false
                        }
                    }
                });
            }
            
            // ⭐ NEW: Generate distinct colors for faculty datasets
            function generateFacultyColors(count) {
                // Predefined colors for known faculties
                const knownFacultyColors = {
                    'FIP': '#F59E0B',    // Amber - Fakultas Ilmu Pendidikan
                    'FBS': '#3B82F6',    // Blue - Fakultas Bahasa dan Seni
                    'FEB': '#10B981',    // Green - Fakultas Ekonomi dan Bisnis  
                    'FISH': '#8B5CF6',   // Violet - Fakultas Ilmu Sosial dan Humaniora
                    'FIK': '#EF4444',    // Red - Fakultas Ilmu Keolahragaan
                    'FMIPA': '#14B8A6',  // Teal - Fakultas MIPA
                    'FPSI': '#EC4899',   // Pink - Fakultas Psikologi
                    'FT': '#6366F1',     // Indigo - Fakultas Teknik
                    'PASCASARJANA': '#6B7280',  // Gray
                    'FPPSI': '#A855F7'   // Purple
                };
                
                const colors = [];
                const faculties = Object.keys(fullProdiData || {}).sort();
                
                // Use predefined colors first
                faculties.slice(0, count).forEach(faculty => {
                    if (knownFacultyColors[faculty]) {
                        colors.push(knownFacultyColors[faculty]);
                    } else {
                        // Generate color using HSL for unknown faculties
                        const hue = (colors.length * 137.5) % 360; // Golden angle
                        colors.push(`hsl(${hue}, 65%, 55%)`);
                    }
                });
                
                return colors;
            }

            // Event Listeners
            const debouncedFetch = debounce(fetchDataAndRenderCharts, 300);

            // Auto-refresh on date filter changes
            ['start_date', 'end_date'].forEach(id => {
                document.getElementById(id).addEventListener('change', debouncedFetch);
            });
            
            // Fakultas filter change - re-render only prodi chart and save state
            document.getElementById('fakultas_filter').addEventListener('change', function() {
                saveFilters();
                if (Object.keys(fullProdiData).length > 0) {
                    renderProdiPerFakultasChart(fullProdiData);
                }
            });

            // Reset filter button
            document.getElementById('reset-filter-button').addEventListener('click', () => {
                clearFilters();
                fetchDataAndRenderCharts();
            });

            // Print button
            document.getElementById('print-button').addEventListener('click', () => window.print());

            // Initial setup
            restoreFilters();
            fetchDataAndRenderCharts();
        });
    </script>
        </div>
    </div>
@endsection


