@extends('admin.admin')

@section('contentadmin')
    <div class="p-4 sm:p-6 bg-gray-50 min-h-full font-sans">

        <div class="head-title">
            <div class="left">
                <h1>Laporan Grafik Responden</h1>
                <ul class="breadcrumb">
                    <li>
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                    </li>
                    <li><i class='bx bx-chevron-right'></i></li>
                    <li>
                        <a class="active" href="#">Grafik Responden</a>
                    </li>
                </ul>
            </div>
        </div>


        {{-- Filter Section --}}
        <div class="bg-white p-4 rounded-xl shadow-lg mb-6">
            <h3 class="text-lg font-bold text-gray-700 mb-4">Filter Data</h3>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
                    <input type="date" id="start_date" name="start_date"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div>
                <div>
                    <label for="end_date" class="block text-sm font-medium text-gray-700">Tanggal Selesai</label>
                    <input type="date" id="end_date" name="end_date"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div>
                <div>
                    <label for="fakultas_filter" class="block text-sm font-medium text-gray-700">Fakultas</label>
                    <select id="fakultas_filter" name="fakultas_filter"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="">Semua Fakultas</option>
                    </select>
                </div>
                <div class="self-end">
                    <button id="filter-btn"
                        class="w-full bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg shadow-md hover:bg-blue-700 transition duration-300">
                        Terapkan Filter
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
                    <div class="h-96">
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
        .head-title {
            display: flex;
            align-items: center;
            justify-content: space-between;
            grid-gap: 16px;
            flex-wrap: wrap;
        }

        .head-title .left h1 {
            font-size: 36px;
            font-weight: 600;
            margin-bottom: 10px;
            color: #342E37;
        }

        .head-title .left .breadcrumb {
            display: flex;
            align-items: center;
            grid-gap: 16px;
        }

        .head-title .left .breadcrumb li {
            color: #342E37;
        }

        .head-title .left .breadcrumb li a {
            color: #A0AEC0;
            pointer-events: none;
        }

        .head-title .left .breadcrumb li a.active {
            color: #3C91E6;
            pointer-events: unset;
        }

        .head-title .btn-download {
            height: 36px;
            padding: 0 16px;
            border-radius: 36px;
            background: #3C91E6;
            color: #F9F9F9;
            display: flex;
            justify-content: center;
            align-items: center;
            grid-gap: 10px;
            font-weight: 500;
        }
    </style>

    {{-- Include Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
      
            Chart.register(ChartDataLabels);

            let sumberDataChart, kategoriChart, trenChart, detailFakultasChart, prodiPerFakultasChart;
            let fullProdiData = {}; 

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
                        throw new Error('Network response was not ok');
                    }
                    const data = await response.json();

                    renderSumberDataChart(data.sumberInput);
                    renderKategoriChart(data.kategori);
                    renderTrenChart(data.tren);
                    renderDetailFakultasChart(data.perFakultas);

                    fullProdiData = data.prodiPerFakultas;
                    populateFakultasDropdown(data.prodiPerFakultas);
                    renderProdiPerFakultasChart(data.prodiPerFakultas);

                } catch (error) {
                    console.error('Error fetching chart data:', error);
                }
            }

            function renderChart(chartInstance, canvasId, config) {
                const ctx = document.getElementById(canvasId).getContext('2d');
                if (chartInstance) {
                    chartInstance.destroy();
                }
                return new Chart(ctx, config);
            }

      
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
                                anchor: 'end',
                                align: 'end',
                                color: '#555',
                                font: {
                                    weight: 'bold'
                                }
                            }
                        }
                    }
                });
            }

            function populateFakultasDropdown(data) {
                const select = document.getElementById('fakultas_filter');
                const currentValue = select.value;
                
       
                select.innerHTML = '<option value="">Semua Fakultas</option>';
                
                const faculties = Object.keys(data).sort();
                faculties.forEach(faculty => {
                    const option = document.createElement('option');
                    option.value = faculty;
                    option.textContent = faculty;
                    select.appendChild(option);
                });
                

                if (currentValue) {
                    select.value = currentValue;
                }
            }

            function renderProdiPerFakultasChart(data) {
                const selectedFakultas = document.getElementById('fakultas_filter').value;
                let filteredData = data;
                
                if (selectedFakultas) {
                    filteredData = {
                        [selectedFakultas]: data[selectedFakultas] || {}
                    };
                }
                
                const faculties = Object.keys(filteredData);
                const allProdis = new Set();
                
                faculties.forEach(faculty => {
                    Object.keys(filteredData[faculty]).forEach(prodi => allProdis.add(prodi));
                });
                
                const prodiList = Array.from(allProdis).sort();
                
                const datasets = prodiList.map((prodi, index) => {
                    return {
                        label: prodi,
                        data: faculties.map(faculty => filteredData[faculty][prodi] || 0),
                        backgroundColor: colorPalette[index % colorPalette.length],
                        borderColor: colorPalette[index % colorPalette.length],
                        borderWidth: 1
                    };
                });
                
                prodiPerFakultasChart = renderChart(prodiPerFakultasChart, 'prodiPerFakultasChart', {
                    type: 'bar',
                    data: {
                        labels: faculties,
                        datasets: datasets
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            x: {
                                stacked: false,
                            },
                            y: {
                                beginAtZero: true,
                                stacked: false
                            }
                        },
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            datalabels: {
                                display: false
                            },
                            title: {
                                display: selectedFakultas ? true : false,
                                text: selectedFakultas ? `Prodi di ${selectedFakultas}` : ''
                            }
                        }
                    }
                });
            }

            document.getElementById('filter-btn').addEventListener('click', fetchDataAndRenderCharts);
            
            document.getElementById('fakultas_filter').addEventListener('change', function() {
                if (Object.keys(fullProdiData).length > 0) {
                    renderProdiPerFakultasChart(fullProdiData);
                }
            });

            fetchDataAndRenderCharts();
        });
    </script>
@endsection

