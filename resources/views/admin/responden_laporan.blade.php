@extends('admin.admin')

@section('contentadmin')
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

        <div class="bg-white p-4 rounded-xl shadow-lg mb-6 print:hidden">
            <h3 class="text-lg font-bold text-gray-700 mb-4">Filter Laporan</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4 items-end">
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
                    <label for="category-filter" class="block text-sm font-medium text-gray-600">Kategori</label>
                    <select id="category-filter" name="category" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="">Semua Kategori</option>
                        <option value="academic">Academic</option>
                        <option value="employer">Employer</option>
                    </select>
                </div>
                <div>
                    <label for="faculty-selector" class="block text-sm font-medium text-gray-600">Fakultas</label>
                    <select id="faculty-selector" name="fakultas" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="semua">Semua Fakultas</option>
                        @foreach ($faculties as $faculty)
                            <option value="{{ $faculty }}">{{ strtoupper($faculty) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-span-1 flex gap-2">
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
                <h3 class="text-lg font-bold text-gray-700 mb-4">Jumlah Data Responden per Fakultas (Narahubung)</h3>
                <div class="h-80">
                    <canvas id="facultyChart"></canvas>
                </div>
            </div>

            <div class="bg-white p-4 sm:p-6 rounded-xl shadow-lg">
                <h3 id="prodi-chart-title" class="text-lg font-bold text-gray-700 mb-4">Jumlah Data per Akun Fakultas</h3>
                <div id="prodiChartContainer" class="h-80">
                    <canvas id="prodiChart"></canvas>
                    <p id="prodiChartPlaceholder" class="text-center text-gray-500 flex items-center justify-center h-full">
                        Memuat data...
                    </p>
                </div>
            </div>

            <div class="bg-white p-4 sm:p-6 rounded-xl shadow-lg">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4">
                    <h3 class="text-lg font-bold text-gray-700">Aktivitas Penginput Data</h3>
                    <div class="flex items-center mt-2 sm:mt-0">
                        <input type="checkbox" id="include-admin-checkbox" class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                        <label for="include-admin-checkbox" class="ml-2 block text-sm text-gray-900">Sertakan Admin Direktorat</label>
                    </div>
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <div>
                        <h4 class="text-md font-semibold text-gray-600 mb-2 text-center">Grafik Jumlah Input per Fakultas</h4>
                        <div class="h-80">
                            <canvas id="inputterFacultyChart"></canvas>
                        </div>
                    </div>
                    <div>
                        <h4 class="text-md font-semibold text-gray-600 mb-2 text-center">Detail Penginput per User</h4>
                        <div class="overflow-y-auto max-h-80 border rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50 sticky top-0">
                                    <tr>
                                        <th scope="col" class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama User</th>
                                        <th scope="col" class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                                        <th scope="col" class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody id="inputter-details-table-body" class="bg-white divide-y divide-gray-200">
                                    <tr><td colspan="3" class="px-6 py-4 text-center text-gray-500">Memuat data...</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white p-4 sm:p-6 rounded-xl shadow-lg">
                    <h3 class="text-lg font-bold text-gray-700 mb-4">Kategori Responden (Keseluruhan)</h3>
                    <div class="h-72">
                        <canvas id="categoryChart"></canvas>
                    </div>
                </div>

                <div class="bg-white p-4 sm:p-6 rounded-xl shadow-lg">
                    <h3 class="text-lg font-bold text-gray-700 mb-4">Status Pengisian (Keseluruhan)</h3>
                    <div class="h-72">
                        <canvas id="statusChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <style>
        @media print {
            body { background-color: white !important; }
            .p-4, .p-6 { padding: 0 !important; }
            .shadow-lg { box-shadow: none !important; border: 1px solid #e2e8f0; }
            .print\:hidden { display: none !important; }
            .bg-white { page-break-inside: avoid; }
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let charts = {};
            const destroyCharts = (chartKeys = []) => {
                const keysToDestroy = chartKeys.length > 0 ? chartKeys : Object.keys(charts);
                keysToDestroy.forEach(key => {
                    if (charts[key]) {
                        charts[key].destroy();
                        delete charts[key];
                    }
                });
            };

            const getCurrentFilters = () => ({
                startDate: document.getElementById('start_date').value,
                endDate: document.getElementById('end_date').value,
                category: document.getElementById('category-filter').value,
                selectedFaculty: document.getElementById('faculty-selector').value,
                includeAdmin: document.getElementById('include-admin-checkbox').checked,
            });
            
            const fetchAndRenderCharts = () => {
                const filters = getCurrentFilters();
                fetchSummaryData(filters);
                fetchProdiData(filters);
            };

            const fetchSummaryData = (filters) => {
                const params = new URLSearchParams();
                if (filters.startDate) params.append('start_date', filters.startDate);
                if (filters.endDate) params.append('end_date', filters.endDate);
                if (filters.category) params.append('category', filters.category);
                params.append('include_admin', filters.includeAdmin);
                
                axios.get(`{{ route('api.responden.chartSummary') }}?${params.toString()}`)
                    .then(response => {
                        const data = response.data;
                        renderFacultyChart(data);
                        renderInputterSection(data);
                        renderSummaryPies(data);
                    })
                    .catch(handleChartError);
            };
            
            const renderFacultyChart = (data) => {
                destroyCharts(['faculty']);
                const facultyCtx = document.getElementById('facultyChart').getContext('2d');
                const facultyColors = data.facultyColors || {};
                const labels = Object.keys(data.byFaculty);
                
                charts.faculty = new Chart(facultyCtx, {
                    type: 'bar',
                    data: {
                        labels: labels.map(l => l.toUpperCase()),
                        datasets: [{
                            label: 'Jumlah Responden',
                            data: Object.values(data.byFaculty),
                            backgroundColor: labels.map(label => facultyColors[label] || '#A5B4FC'),
                        }]
                    },
                    options: { scales: { y: { beginAtZero: true, ticks: { precision: 0 } } }, responsive: true, maintainAspectRatio: false }
                });
            };

            const renderInputterSection = (data) => {
                destroyCharts(['inputter']);
                const tableBody = document.getElementById('inputter-details-table-body');
                tableBody.innerHTML = '';
                if (data.detailedInputters && data.detailedInputters.length > 0) {
                    data.detailedInputters.forEach(user => {
                        tableBody.innerHTML += `
                            <tr>
                                <td class="px-4 py-2 text-sm font-medium text-gray-900">${user.name}</td>
                                <td class="px-4 py-2 text-sm text-gray-500">${user.role}</td>
                                <td class="px-4 py-2 text-sm text-gray-500 font-semibold text-center">${user.count}</td>
                            </tr>`;
                    });
                } else {
                    tableBody.innerHTML = '<tr><td colspan="3" class="px-4 py-2 text-center text-gray-500">Tidak ada data penginput.</td></tr>';
                }

                const inputterFacultyCtx = document.getElementById('inputterFacultyChart').getContext('2d');
                charts.inputter = new Chart(inputterFacultyCtx, {
                    type: 'bar',
                    data: {
                        labels: Object.keys(data.byInputterFaculty),
                        datasets: [{
                            label: 'Jumlah Input Data',
                            data: Object.values(data.byInputterFaculty),
                            backgroundColor: 'rgba(16, 185, 129, 0.7)',
                        }]
                    },
                    options: { scales: { y: { beginAtZero: true, ticks: { precision: 0 } } }, responsive: true, maintainAspectRatio: false }
                });
            };

            const renderSummaryPies = (data) => {
                destroyCharts(['category', 'status']);
                const categoryCtx = document.getElementById('categoryChart').getContext('2d');
                charts.category = new Chart(categoryCtx, {
                    type: 'pie',
                    data: {
                        labels: Object.keys(data.byCategory).map(l => l.charAt(0).toUpperCase() + l.slice(1)),
                        datasets: [{
                            data: Object.values(data.byCategory),
                            backgroundColor: ['rgba(37, 99, 235, 0.7)', 'rgba(239, 68, 68, 0.7)', 'rgba(245, 158, 11, 0.7)'],
                        }]
                    },
                    options: { responsive: true, maintainAspectRatio: false }
                });

                const statusCtx = document.getElementById('statusChart').getContext('2d');
                charts.status = new Chart(statusCtx, {
                    type: 'doughnut',
                    data: {
                        labels: Object.keys(data.byStatus).map(l => l.replace(/_/g, ' ').replace(/\b\w/g, c => c.toUpperCase())),
                        datasets: [{
                            data: Object.values(data.byStatus),
                            backgroundColor: ['#3B82F6', '#10B981', '#F59E0B', '#EF4444'],
                        }]
                    },
                    options: { responsive: true, maintainAspectRatio: false }
                });
            };
            
            const fetchProdiData = (filters) => {
                document.getElementById('prodiChart').style.display = 'block';
                document.getElementById('prodiChartPlaceholder').style.display = 'none';

                const params = new URLSearchParams();
                params.append('fakultas', filters.selectedFaculty);
                if (filters.startDate) params.append('start_date', filters.startDate);
                if (filters.endDate) params.append('end_date', filters.endDate);
                if (filters.category) params.append('category', filters.category);

                axios.get(`{{ route('api.responden.chartProdi') }}?${params.toString()}`)
                    .then(response => {
                        destroyCharts(['prodi']);
                        const prodiCtx = document.getElementById('prodiChart').getContext('2d');
                        
                        const prodiChartTitle = document.getElementById('prodi-chart-title');
                        let chartLabel = '';
                        if(filters.selectedFaculty === 'semua' || filters.selectedFaculty === ''){
                             prodiChartTitle.textContent = 'Jumlah Data per Akun Fakultas';
                             chartLabel = 'Jumlah Input Fakultas';
                        } else {
                             prodiChartTitle.textContent = `Jumlah Data Responden Fakultas per Prodi`;
                             chartLabel = `Responden di ${filters.selectedFaculty.toUpperCase()}`;
                        }

                        charts.prodi = new Chart(prodiCtx, {
                            type: 'bar',
                            data: {
                                labels: Object.keys(response.data),
                                datasets: [{
                                    label: chartLabel,
                                    data: Object.values(response.data),
                                    backgroundColor: 'rgba(217, 119, 6, 0.7)',
                                }]
                            },
                            options: { indexAxis: 'y', scales: { x: { beginAtZero: true, ticks: { precision: 0 } } }, responsive: true, maintainAspectRatio: false }
                        });
                    })
                    .catch(handleChartError);
            };

            const handleChartError = (error) => {
                console.error("Gagal mengambil data chart:", error);
                alert('Gagal memuat data laporan. Cek console untuk detail.');
            };

            const allFilters = ['start_date', 'end_date', 'category-filter', 'faculty-selector'];
            allFilters.forEach(id => {
                document.getElementById(id).addEventListener('change', fetchAndRenderCharts);
            });
            
            document.getElementById('reset-filter-button').addEventListener('click', () => {
                document.getElementById('start_date').value = '';
                document.getElementById('end_date').value = '';
                document.getElementById('category-filter').value = '';
                document.getElementById('faculty-selector').value = 'semua';
                document.getElementById('include-admin-checkbox').checked = false;
                fetchAndRenderCharts();
            });
            
            document.getElementById('include-admin-checkbox').addEventListener('change', () => fetchSummaryData(getCurrentFilters()));
            document.getElementById('print-button').addEventListener('click', () => window.print());

            fetchAndRenderCharts();
        });
    </script>
@endsection
