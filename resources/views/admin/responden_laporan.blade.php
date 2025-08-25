@extends('admin.admin')

@section('contentadmin')
    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}

    <div class="p-4 sm:p-6 bg-gray-50 min-h-full font-sans">

        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 print:hidden">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Laporan Responden</h1>
            </div>
            <button id="print-button"
                class="mt-4 sm:mt-0 flex items-center gap-2 bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg shadow-md hover:bg-blue-700 transition duration-300">
                <i class='bx bxs-printer text-xl'></i>
                <span>Cetak Laporan</span>
            </button>
        </div>

        <!-- Filter Section -->
        <div class="bg-white p-4 rounded-xl shadow-lg mb-6 print:hidden">
            <h3 class="text-lg font-bold text-gray-700 mb-4">Filter Laporan</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 items-end">
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
                <div class="flex gap-2">
                    <button id="filter-button"
                        class="w-full flex justify-center items-center gap-2 bg-indigo-600 text-white font-semibold py-2 px-4 rounded-lg shadow-md hover:bg-indigo-700 transition duration-300">
                        <i class='bx bx-filter-alt'></i>
                        <span>Terapkan Filter</span>
                    </button>
                    <button id="reset-filter-button"
                        class="w-full flex justify-center items-center gap-2 bg-gray-300 text-gray-800 font-semibold py-2 px-4 rounded-lg shadow-md hover:bg-gray-400 transition duration-300">
                        <i class='bx bx-reset'></i>
                        <span>Reset</span>
                    </button>
                </div>
            </div>
        </div>


        <div class="grid grid-cols-1 gap-6">

            <div class="bg-white p-4 sm:p-6 rounded-xl shadow-lg">
                <h3 class="text-lg font-bold text-gray-700 mb-4">Jumlah Data Responden per Fakultas</h3>
                <div class="h-80">
                    <canvas id="facultyChart"></canvas>
                </div>
            </div>

            <!-- Prodi Chart Section -->
            <div class="bg-white p-4 sm:p-6 rounded-xl shadow-lg">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4">
                    <h3 class="text-lg font-bold text-gray-700">Jumlah Data Responden per Prodi</h3>
                    <div class="mt-2 sm:mt-0">
                        <select id="faculty-selector" name="fakultas"
                            class="block w-full sm:w-64 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="">Pilih Fakultas</option>
                            @foreach ($faculties as $faculty)
                                <option value="{{ $faculty }}">{{ strtoupper($faculty) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div id="prodiChartContainer" class="h-80">
                    <canvas id="prodiChart"></canvas>
                    <p id="prodiChartPlaceholder" class="text-center text-gray-500 flex items-center justify-center h-full">
                        Pilih fakultas untuk melihat data prodi.</p>
                </div>
            </div>


            <div class="bg-white p-4 sm:p-6 rounded-xl shadow-lg">
                <h3 class="text-lg font-bold text-gray-700 mb-4">Jumlah Penginput (User) per Fakultas</h3>
                <div class="h-80">
                    <canvas id="inputterFacultyChart"></canvas>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white p-4 sm:p-6 rounded-xl shadow-lg">
                    <h3 class="text-lg font-bold text-gray-700 mb-4">Kategori Responden</h3>
                    <div class="h-72">
                        <canvas id="categoryChart"></canvas>
                    </div>
                </div>

                <div class="bg-white p-4 sm:p-6 rounded-xl shadow-lg">
                    <h3 class="text-lg font-bold text-gray-700 mb-4">Status Pengisian</h3>
                    <div class="h-72">
                        <canvas id="statusChart"></canvas>
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
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const getRandomColor = () =>
                `rgba(${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, 0.7)`;

            let charts = {};
            const destroyCharts = () => {
                Object.values(charts).forEach(chart => chart.destroy());
                charts = {};
            };


            const fetchAndRenderSummaryCharts = (startDate = null, endDate = null) => {

                let apiUrl = '{{ route('api.responden.chartSummary') }}';
                const params = new URLSearchParams();
                if (startDate) params.append('start_date', startDate);
                if (endDate) params.append('end_date', endDate);

                const queryString = params.toString();
                if (queryString) {
                    apiUrl += `?${queryString}`;
                }

                axios.get(apiUrl)
                    .then(response => {
                        const data = response.data;
                        destroyCharts();

                        const getSortedData = (dataObject) => {
                        const sortedLabels = Object.keys(dataObject).sort((a, b) => a.localeCompare(b));
                        const sortedData = sortedLabels.map(label => dataObject[label]);
                        return { sortedLabels, sortedData };
                        };

                    // Faculty Chart
                    const facultyData = getSortedData(data.byFaculty);
                        // Faculty Chart
                        const facultyCtx = document.getElementById('facultyChart').getContext('2d');
                        charts.faculty = new Chart(facultyCtx, {
                            type: 'bar',
                            data: {
                                labels: Object.keys(data.byFaculty).map(l => l.toUpperCase()),
                                datasets: [{
                                    label: 'Jumlah Responden',
                                    data: Object.values(data.byFaculty),
                                    backgroundColor: 'rgba(59, 130, 246, 0.7)',
                                }]
                            },
                            options: {
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        ticks: {
                                            precision: 0
                                        }
                                    }
                                },
                                responsive: true,
                                maintainAspectRatio: false
                            }
                        });

                        // Inputter Faculty Chart
                        const inputterFacultyData = getSortedData(data.byInputterFaculty);
                        const inputterFacultyCtx = document.getElementById('inputterFacultyChart')
                            .getContext('2d');
                        charts.inputter = new Chart(inputterFacultyCtx, {
                            type: 'bar',
                            data: {
                                labels: Object.keys(data.byInputterFaculty).map(l => l
                                .toUpperCase()),
                                datasets: [{
                                    label: 'Jumlah User Penginput',
                                    data: Object.values(data.byInputterFaculty),
                                    backgroundColor: 'rgba(16, 185, 129, 0.7)',
                                }]
                            },
                            options: {
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        ticks: {
                                            precision: 0
                                        }
                                    }
                                },
                                responsive: true,
                                maintainAspectRatio: false
                            }
                        });

                        // Category Chart
                        const categoryData = getSortedData(data.byCategory);
                        const categoryCtx = document.getElementById('categoryChart').getContext('2d');
                        charts.category = new Chart(categoryCtx, {
                            type: 'pie',
                            data: {
                                labels: Object.keys(data.byCategory).map(l => l.charAt(0)
                                    .toUpperCase() + l.slice(1)),
                                datasets: [{
                                    data: Object.values(data.byCategory),
                                    backgroundColor: ['rgba(239, 68, 68, 0.7)',
                                        'rgba(37, 99, 235, 0.7)',
                                        'rgba(245, 158, 11, 0.7)'
                                    ],
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false
                            }
                        });

                        // Status Chart
                        const statusData = getSortedData(data.byStatus);
                        const statusCtx = document.getElementById('statusChart').getContext('2d');
                        charts.status = new Chart(statusCtx, {
                            type: 'doughnut',
                            data: {
                                labels: Object.keys(data.byStatus).map(l => l.replace(/_/g, ' ')
                                    .replace(/\b\w/g, c => c.toUpperCase())),
                                datasets: [{
                                    data: Object.values(data.byStatus),
                                    backgroundColor: Object.keys(data.byStatus).map(() =>
                                        getRandomColor()),
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false
                            }
                        });
                    })
                    .catch(handleChartError);
            };

            const fetchAndRenderProdiChart = (faculty, startDate = null, endDate = null) => {
                if (!faculty) {
                    document.getElementById('prodiChart').style.display = 'none';
                    document.getElementById('prodiChartPlaceholder').style.display = 'flex';
                    if (charts.prodi) charts.prodi.destroy();
                    return;
                }

                document.getElementById('prodiChart').style.display = 'block';
                document.getElementById('prodiChartPlaceholder').style.display = 'none';

                let apiUrl = '{{ route('api.responden.chartProdi') }}';
                const params = new URLSearchParams();
                params.append('fakultas', faculty);
                if (startDate) params.append('start_date', startDate);
                if (endDate) params.append('end_date', endDate);

                apiUrl += `?${params.toString()}`;

                axios.get(apiUrl)
                    .then(response => {
                        const data = response.data;
                        if (charts.prodi) charts.prodi.destroy();

                    const prodiDataObject = response.data;
                    const sortedProdiLabels = Object.keys(prodiDataObject).sort((a, b) => a.localeCompare(b));
                    const sortedProdiData = sortedProdiLabels.map(label => prodiDataObject[label]);
                        const prodiCtx = document.getElementById('prodiChart').getContext('2d');
                        charts.prodi = new Chart(prodiCtx, {
                            type: 'bar',
                            data: {
                                labels: Object.keys(data),
                                datasets: [{
                                    label: `Responden Prodi di ${faculty.toUpperCase()}`,
                                    data: Object.values(data),
                                    backgroundColor: 'rgba(217, 119, 6, 0.7)',
                                }]
                            },
                            options: {
                                indexAxis: 'y',
                                scales: {
                                    x: {
                                        beginAtZero: true,
                                        ticks: {
                                            precision: 0
                                        }
                                    }
                                },
                                responsive: true,
                                maintainAspectRatio: false
                            }
                        });
                    })
                    .catch(handleChartError);
            };

            const handleChartError = (error) => {
                console.error("Gagal mengambil data chart:", error);

                let errorMessage = 'Gagal memuat data laporan. ';
                if (error.response && error.response.data && error.response.data.error) {
                    errorMessage += error.response.data.error;
                } else if (error.response) {
                    errorMessage += `Status: ${error.response.status}`;
                } else {
                    errorMessage += 'Cek console untuk detail.';
                }

                alert(errorMessage);
            };

            document.getElementById('filter-button').addEventListener('click', () => {
                const startDate = document.getElementById('start_date').value;
                const endDate = document.getElementById('end_date').value;
                const selectedFaculty = document.getElementById('faculty-selector').value;

                if (startDate && endDate && new Date(startDate) > new Date(endDate)) {
                    alert('Tanggal mulai tidak boleh lebih besar dari tanggal selesai.');
                    return;
                }

                fetchAndRenderSummaryCharts(startDate, endDate);
                fetchAndRenderProdiChart(selectedFaculty, startDate, endDate);
            });

            document.getElementById('reset-filter-button').addEventListener('click', () => {
                document.getElementById('start_date').value = '';
                document.getElementById('end_date').value = '';
                document.getElementById('faculty-selector').value = '';

                fetchAndRenderSummaryCharts();
                fetchAndRenderProdiChart(null);
            });

            document.getElementById('faculty-selector').addEventListener('change', (e) => {
                const startDate = document.getElementById('start_date').value;
                const endDate = document.getElementById('end_date').value;
                fetchAndRenderProdiChart(e.target.value, startDate, endDate);
            });

            document.getElementById('print-button').addEventListener('click', () => window.print());

            fetchAndRenderSummaryCharts();
            fetchAndRenderProdiChart(null);
        });
    </script>
@endsection
