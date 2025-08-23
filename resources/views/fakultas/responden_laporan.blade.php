@extends('fakultas.index')

@section('contentfakultas')
    <script src="https://cdn.tailwindcss.com"></script>

    <div class="p-4 sm:p-6 bg-gray-50 min-h-full font-sans">
        
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 print:hidden">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Laporan Responden Prodi</h1>
                <p class="text-sm text-gray-500 mt-1">Laporan jumlah responden yang diinput oleh setiap program studi di bawah fakultas Anda.</p>
            </div>
            <button id="print-button" class="mt-4 sm:mt-0 flex items-center gap-2 bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg shadow-md hover:bg-blue-700 transition duration-300">
                <i class='bx bxs-printer text-xl'></i>
                <span>Cetak Laporan</span>
            </button>
        </div>

        <div class="bg-white p-4 rounded-xl shadow-lg mb-6 print:hidden">
            <h3 class="text-lg font-bold text-gray-700 mb-4">Filter Laporan</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 items-end">
                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-600">Tanggal Mulai</label>
                    <input type="date" id="start_date" name="start_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div>
                <div>
                    <label for="end_date" class="block text-sm font-medium text-gray-600">Tanggal Selesai</label>
                    <input type="date" id="end_date" name="end_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div>
                <div class="flex gap-2">
                     <button id="filter-button" class="w-full flex justify-center items-center gap-2 bg-indigo-600 text-white font-semibold py-2 px-4 rounded-lg shadow-md hover:bg-indigo-700 transition duration-300">
                        <i class='bx bx-filter-alt'></i>
                        <span>Terapkan Filter</span>
                    </button>
                    <button id="reset-filter-button" class="w-full flex justify-center items-center gap-2 bg-gray-300 text-gray-800 font-semibold py-2 px-4 rounded-lg shadow-md hover:bg-gray-400 transition duration-300">
                        <i class='bx bx-reset'></i>
                        <span>Reset</span>
                    </button>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6">
            <div class="bg-white p-4 sm:p-6 rounded-xl shadow-lg">
                <h3 class="text-lg font-bold text-gray-700 mb-4">Jumlah Data Responden per Program Studi</h3>
                <div id="prodiChartContainer" class="h-96">
                    <canvas id="prodiChart"></canvas>
                    <p id="prodiChartPlaceholder" class="text-center text-gray-500 flex items-center justify-center h-full">Memuat data chart...</p>
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
        let prodiChartInstance;

        const fetchAndRenderProdiChart = (startDate = null, endDate = null) => {
            document.getElementById('prodiChart').style.display = 'none';
            document.getElementById('prodiChartPlaceholder').style.display = 'flex';
            document.getElementById('prodiChartPlaceholder').textContent = 'Memuat data chart...';
            let apiUrl = '{{ route("api.responden.chartProdi") }}';
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
                    
                    if (prodiChartInstance) {
                        prodiChartInstance.destroy();
                    }

                    if (Object.keys(data).length === 0) {
                        document.getElementById('prodiChartPlaceholder').textContent = 'Tidak ada data untuk ditampilkan pada rentang tanggal ini.';
                        return;
                    }

                    document.getElementById('prodiChart').style.display = 'block';
                    document.getElementById('prodiChartPlaceholder').style.display = 'none';

                    const prodiCtx = document.getElementById('prodiChart').getContext('2d');
                    prodiChartInstance = new Chart(prodiCtx, {
                        type: 'bar',
                        data: {
                            labels: Object.keys(data),
                            datasets: [{
                                label: `Jumlah Responden per Prodi`,
                                data: Object.values(data),
                                backgroundColor: 'rgba(217, 119, 6, 0.7)',
                                borderColor: 'rgba(217, 119, 6, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            indexAxis: 'y',
                            scales: { x: { beginAtZero: true, ticks: { precision: 0 } } },
                            responsive: true,
                            maintainAspectRatio: false
                        }
                    });
                })
                .catch(error => {
                    console.error("Gagal mengambil data chart:", error);
                    document.getElementById('prodiChartPlaceholder').textContent = 'Gagal memuat data chart. Silakan coba lagi.';
                });
        };

        document.getElementById('filter-button').addEventListener('click', () => {
            const startDate = document.getElementById('start_date').value;
            const endDate = document.getElementById('end_date').value;

            if (startDate && endDate && new Date(startDate) > new Date(endDate)) {
                alert('Tanggal mulai tidak boleh lebih besar dari tanggal selesai.');
                return;
            }
            
            fetchAndRenderProdiChart(startDate, endDate);
        });

        document.getElementById('reset-filter-button').addEventListener('click', () => {
            document.getElementById('start_date').value = '';
            document.getElementById('end_date').value = '';
            fetchAndRenderProdiChart();
        });

        document.getElementById('print-button').addEventListener('click', () => window.print());
        fetchAndRenderProdiChart();
    });
    </script>
@endsection
