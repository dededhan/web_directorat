<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grafik Tren Riset per Fakultas - Universitas Negeri Jakarta</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .loader { border: 4px solid #f3f3f3; border-top: 4px solid #186862; border-radius: 50%; width: 50px; height: 50px; animation: spin 1s linear infinite; }
        @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
        
        .custom-select {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 0.5rem center;
            background-repeat: no-repeat;
            background-size: 1.5em 1.5em;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
        }
    </style>
</head>
<body class="bg-gray-100 antialiased">

    @include('layout.navbar_hilirisasi')

    <main class="py-10 pt-28">
        <div class="container mx-auto px-4 lg:px-8">

            <div class="text-center mb-10">
                <h1 class="text-3xl md:text-4xl font-bold text-gray-800">Tren Riset Unggulan UNJ</h1>
                <p class="mt-2 text-lg text-gray-600">Visualisasi jumlah riset per fakultas berdasarkan tahun.</p>
                 <div class="mt-6">
                    <a href="{{ route('subdirektorat-inovasi.riset.unj') }}" class="inline-flex items-center bg-gray-600 text-white px-5 py-2.5 rounded-lg hover:bg-gray-700 transition duration-300 text-sm font-semibold shadow-sm">
                        <i class="fa-solid fa-arrow-left mr-2"></i>
                        Kembali ke Daftar Riset
                    </a>
                </div>
            </div>
            
            <div class="bg-white p-5 md:p-8 rounded-xl shadow-lg border border-gray-200">
                
                <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 mb-6 border-b border-gray-200 pb-6">
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">Visualisasi Data Riset</h2>
                        <p class="text-sm text-gray-500 mt-1">Pilih tahun untuk melihat data yang lebih spesifik.</p>
                    </div>
                    
                    <div class="flex flex-col md:flex-row md:items-center md:justify-end gap-3">
                        <label for="yearFilter" class="text-sm font-medium text-gray-700 whitespace-nowrap">Tampilkan Tahun:</label>
                        <select id="yearFilter" 
                                class="custom-select w-full md:w-auto bg-white border border-gray-300 text-gray-800 py-2 pl-3 pr-10 rounded-lg shadow-sm hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out">
                            <option value="all">Semua Tahun</option>
                            @foreach($years as $year)
                                <option value="{{ $year }}">{{ $year }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div id="loading-indicator" class="flex justify-center items-center py-40">
                    <div class="loader"></div>
                </div>

                <div id="chart-container" class="hidden">
                     <div class="relative w-full">
                        <canvas id="combinedChart"></canvas>
                    </div>
                </div>
                 <div id="no-data-message" class="hidden text-center py-40 text-gray-500">
                    Tidak ada data yang dapat ditampilkan untuk pilihan ini.
                </div>
            </div>

        </div>
    </main>
    
    @include('layout.footer')
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const loadingIndicator = document.getElementById('loading-indicator');
        const chartContainer = document.getElementById('chart-container');
        const noDataMessage = document.getElementById('no-data-message');
        const yearFilter = document.getElementById('yearFilter');
        const canvas = document.getElementById('combinedChart');
        let myChart = null;

        async function renderChart(year = 'all') {
            loadingIndicator.classList.remove('hidden');
            chartContainer.classList.add('hidden');
            noDataMessage.classList.add('hidden');

            if (myChart) {
                myChart.destroy();
            }

            try {
                const url = new URL("{{ route('api.riset-unj.graph-data') }}");
                url.searchParams.append('tahun', year);

                const response = await fetch(url);
                if (!response.ok) throw new Error('Network response was not ok');
                
                const data = await response.json();
                
                if (!data.labels || data.labels.length === 0) {
                    loadingIndicator.classList.add('hidden');
                    noDataMessage.classList.remove('hidden');
                    return;
                }

                loadingIndicator.classList.add('hidden');
                chartContainer.classList.remove('hidden');

                const ctx = canvas.getContext('2d');
                
                const options = getChartOptions(data.type, year);
                
                myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: data.labels,
                        datasets: data.datasets
                    },
                    options: options
                });

            } catch (error) {
                console.error('Gagal memuat data grafik:', error);
                loadingIndicator.classList.add('hidden');
                noDataMessage.innerText = 'Gagal memuat data grafik. Silakan coba lagi nanti.';
                noDataMessage.classList.remove('hidden');
            }
        }
        
        function getChartOptions(type, year) {
            const isYearlyView = type === 'yearly';
            
            return {
                responsive: true,
                maintainAspectRatio: true,
                aspectRatio: 2,
                plugins: {
                    legend: {
                        display: !isYearlyView, 
                        position: 'top',
                        align: 'center',
                        labels: { padding: 20, boxWidth: 15, font: { size: 12 } }
                    },
                    title: {
                        display: false
                    },
                    tooltip: {
                        mode: 'index', intersect: false, backgroundColor: '#1F2937',
                        titleFont: { weight: 'bold' }, bodySpacing: 5, padding: 12,
                        callbacks: {
                            title: function(context) {
                                return isYearlyView ? `Fakultas: ${context[0].label}` : `Tahun ${context[0].label}`;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: isYearlyView ? 'Fakultas' : 'Tahun',
                            font: { weight: '600' }
                        },
                        grid: { display: false }
                    },
                    y: {
                        beginAtZero: true,
                        title: { display: true, text: 'Jumlah Riset', font: { weight: '600' } },
                        grid: { color: '#E5E7EB', borderDash: [3, 3] }
                    }
                },
                interaction: { mode: 'index', intersect: false },
            };
        }

        yearFilter.addEventListener('change', function() {
            renderChart(this.value);
        });

        renderChart();
    });
    </script>
</body>
</html>