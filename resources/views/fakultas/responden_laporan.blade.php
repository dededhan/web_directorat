@extends('fakultas.index')

@section('contentfakultas')

    <script src="https://cdn.tailwindcss.com"></script>
    <div class="p-4 sm:p-6 bg-gray-50 min-h-full font-sans">

        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 print:hidden">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Laporan Responden Fakultas</h1>
                <p class="text-sm text-gray-500 mt-1">Grafik ringkasan data responden untuk fakultas Anda.</p>
            </div>
            <button id="print-button"
                class="mt-4 sm:mt-0 flex items-center gap-2 bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg shadow-md hover:bg-blue-700 transition duration-300">
                <i class='bx bxs-printer text-xl'></i>
                <span>Cetak Laporan</span>
            </button>
        </div>

        <div class="bg-white p-4 rounded-xl shadow-lg mb-6 print:hidden">
            <h3 class="text-lg font-bold text-gray-700 mb-4">Filter Laporan</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 items-end">
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
                    <label for="category-filter" class="block text-sm font-medium text-gray-600">Kategori Narahubung</label>
                    <select id="category-filter" name="category"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="">Semua Kategori</option>
                        <option value="academic">Academic</option>
                        <option value="employer">Employer</option>
                    </select>
                </div>
                <div class="flex gap-2">
                    <button id="reset-filter-button"
                        class="w-full flex justify-center items-center gap-2 bg-gray-300 text-gray-800 font-semibold py-2 px-4 rounded-lg shadow-md hover:bg-gray-400 transition duration-300">
                        <i class='bx bx-reset'></i>
                        <span>Reset</span>
                    </button>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">
            <div class="lg:col-span-3 bg-white p-4 sm:p-6 rounded-xl shadow-lg">
                <h3 class="text-lg font-bold text-gray-700 mb-4">Jumlah Data Responden per Program Studi</h3>
                <div id="prodiChartContainer">
                    <canvas id="prodiChart"></canvas>
                    <p id="prodiChartPlaceholder" class="text-center text-gray-500 flex items-center justify-center h-full">
                        Memuat data...</p>
                </div>
            </div>
            <div class="lg:col-span-2 bg-white p-4 sm:p-6 rounded-xl shadow-lg">
                <h3 class="text-lg font-bold text-gray-700 mb-4">Kategori Responden</h3>
                <div id="categoryChartContainer" class="h-80">
                    <canvas id="categoryChart"></canvas>
                    <p id="categoryChartPlaceholder"
                        class="text-center text-gray-500 flex items-center justify-center h-full">Memuat data...</p>
                </div>
            </div>
        </div>
    </div>

    <style>
        @media print {
            body {
                background-color: white !important;
            }

            .p-4,
            .p-6 {
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

            .lg\:col-span-3,
            .lg\:col-span-2 {
                grid-column: span 6 / span 6 !important;
                width: 100%;
            }
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0/dist/chartjs-plugin-datalabels.min.js">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Chart.register(ChartDataLabels);

            let charts = {};

            const destroyChart = (chartKey) => {
                if (charts[chartKey]) {
                    charts[chartKey].destroy();
                    delete charts[chartKey];
                }
            };

            const fetchAndRenderCharts = () => {
                const startDate = document.getElementById('start_date').value;
                const endDate = document.getElementById('end_date').value;
                const category = document.getElementById('category-filter').value;

                document.getElementById('prodiChartPlaceholder').style.display = 'flex';
                document.getElementById('categoryChartPlaceholder').style.display = 'flex';

                const params = new URLSearchParams();
                if (startDate) params.append('start_date', startDate);
                if (endDate) params.append('end_date', endDate);
                if (category) params.append('category', category);

                // Ganti route ke API endpoint yang baru
                axios.get(`{{ route('api.fakultas.reportData') }}?${params.toString()}`)
                    .then(response => {
                        renderProdiChart(response.data.byProdi);
                        renderCategoryChart(response.data.byCategory);
                    })
                    .catch(error => {
                        console.error("Gagal mengambil data chart:", error);
                        document.getElementById('prodiChartPlaceholder').textContent = 'Gagal memuat data.';
                        document.getElementById('categoryChartPlaceholder').textContent =
                            'Gagal memuat data.';
                    });
            };

            const renderProdiChart = (data) => {
                destroyChart('prodi');
                const placeholder = document.getElementById('prodiChartPlaceholder');
                const container = document.getElementById('prodiChartContainer');
                const canvas = document.getElementById('prodiChart');

                if (!data || Object.keys(data).length === 0) {
                    placeholder.textContent = 'Tidak ada data untuk ditampilkan.';
                    placeholder.style.display = 'flex';
                    canvas.style.display = 'none';
                    return;
                }

                placeholder.style.display = 'none';
                canvas.style.display = 'block';

                const labels = Object.keys(data);
                const values = Object.values(data);

                container.style.height = `${Math.max(320, labels.length * 40)}px`;

                const ctx = canvas.getContext('2d');
                charts.prodi = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Jumlah Responden',
                            data: values,
                            backgroundColor: 'rgba(99, 102, 241, 0.7)',
                        }]
                    },
                    options: {
                        indexAxis: 'y',
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            x: {
                                beginAtZero: true,
                                ticks: {
                                    precision: 0
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: false
                            },
                            datalabels: {
                                anchor: 'end',
                                align: 'right',
                                color: '#1f2937',
                                font: {
                                    weight: 'bold'
                                },
                                formatter: (value) => value > 0 ? value : ''
                            }
                        }
                    }
                });
            };

            const renderCategoryChart = (data) => {
                destroyChart('category');
                const placeholder = document.getElementById('categoryChartPlaceholder');
                const canvas = document.getElementById('categoryChart');

                if (!data || Object.keys(data).length === 0) {
                    placeholder.textContent = 'Tidak ada data untuk ditampilkan.';
                    placeholder.style.display = 'flex';
                    canvas.style.display = 'none';
                    return;
                }

                placeholder.style.display = 'none';
                canvas.style.display = 'block';

                const ctx = canvas.getContext('2d');
                charts.category = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: Object.keys(data).map(l => l.charAt(0).toUpperCase() + l.slice(1)),
                        datasets: [{
                            data: Object.values(data),
                            backgroundColor: ['#3B82F6', '#EF4444', '#F59E0B'],
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'top'
                            },
                            datalabels: {
                                formatter: (value, ctx) => {
                                    let sum = ctx.chart.data.datasets[0].data.reduce((a, b) => a +
                                        b, 0);
                                    let percentage = (value * 100 / sum).toFixed(2) + "%";
                                    return `${value} (${percentage})`;
                                },
                                color: '#fff',
                            }
                        }
                    }
                });
            };

            const allFilters = ['start_date', 'end_date', 'category-filter'];
            allFilters.forEach(id => {
                document.getElementById(id).addEventListener('change', fetchAndRenderCharts);
            });

            document.getElementById('reset-filter-button').addEventListener('click', () => {
                document.getElementById('start_date').value = '';
                document.getElementById('end_date').value = '';
                document.getElementById('category-filter').value = '';
                fetchAndRenderCharts();
            });

            document.getElementById('print-button').addEventListener('click', () => window.print());

            fetchAndRenderCharts();
        });
    </script>
@endsection
