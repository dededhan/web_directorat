@extends('admin.admin')

@section('contentadmin')

{{-- <script src="https://cdn.tailwindcss.com"></script> --}}

<div class="p-4 sm:p-6 bg-gray-50 min-h-full font-sans">
    
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Laporan Responden</h1>
        </div>
        <button id="print-button" class="mt-4 sm:mt-0 flex items-center gap-2 bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg shadow-md hover:bg-blue-700 transition duration-300 print:hidden">
            <i class='bx bxs-printer text-xl'></i>
            <span>Cetak Laporan</span>
        </button>
    </div>

    <div class="grid grid-cols-1 gap-6">
        
        <div class="bg-white p-4 sm:p-6 rounded-xl shadow-lg">
            <h3 class="text-lg font-bold text-gray-700 mb-4">Jumlah Data Responden per Fakultas</h3>
            <div class="h-80">
                <canvas id="facultyChart"></canvas>
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
        .p-4, .p-6 {
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
    const getRandomColor = () => `rgba(${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, 0.7)`;
const apiUrl = '{{ route("api.responden.chartSummary") }}';

    axios.get(apiUrl)
        .then(response => {
            const data = response.data;

            const facultyCtx = document.getElementById('facultyChart').getContext('2d');
            new Chart(facultyCtx, {
                type: 'bar',
                data: {
                    labels: Object.keys(data.byFaculty).map(l => l.toUpperCase()),
                    datasets: [{
                        label: 'Jumlah Responden',
                        data: Object.values(data.byFaculty),
                        backgroundColor: 'rgba(59, 130, 246, 0.7)',
                        borderColor: 'rgba(59, 130, 246, 1)',
                        borderWidth: 1
                    }]
                },
                options: { scales: { y: { beginAtZero: true, ticks: { precision: 0 } } }, responsive: true, maintainAspectRatio: false }
            });

            const inputterFacultyCtx = document.getElementById('inputterFacultyChart').getContext('2d');
            new Chart(inputterFacultyCtx, {
                type: 'bar',
                data: {
                    labels: Object.keys(data.byInputterFaculty).map(l => l.toUpperCase()),
                    datasets: [{
                        label: 'Jumlah User Penginput',
                        data: Object.values(data.byInputterFaculty),
                        backgroundColor: 'rgba(16, 185, 129, 0.7)',
                        borderColor: 'rgba(16, 185, 129, 1)',
                        borderWidth: 1
                    }]
                },
                options: { scales: { y: { beginAtZero: true, ticks: { precision: 0 } } }, responsive: true, maintainAspectRatio: false }
            });

            const categoryCtx = document.getElementById('categoryChart').getContext('2d');
            new Chart(categoryCtx, {
                type: 'pie',
                data: {
                    labels: Object.keys(data.byCategory).map(l => l.charAt(0).toUpperCase() + l.slice(1)),
                    datasets: [{
                        data: Object.values(data.byCategory),
                        backgroundColor: ['rgba(239, 68, 68, 0.7)', 'rgba(37, 99, 235, 0.7)', 'rgba(245, 158, 11, 0.7)'],
                    }]
                },
                options: { responsive: true, maintainAspectRatio: false }
            });


            const statusCtx = document.getElementById('statusChart').getContext('2d');
            new Chart(statusCtx, {
                type: 'doughnut',
                data: {
                    labels: Object.keys(data.byStatus).map(l => l.replace(/_/g, ' ').replace(/\b\w/g, c => c.toUpperCase())),
                    datasets: [{
                        data: Object.values(data.byStatus),
                        backgroundColor: Object.keys(data.byStatus).map(() => getRandomColor()),
                    }]
                },
                options: { responsive: true, maintainAspectRatio: false }
            });

        })
        .catch(error => {
            console.error("Gagal mengambil data chart:", error);
            const reportContainer = document.querySelector('.grid');
            let errorMessage = 'Gagal memuat data laporan. Cek console untuk detail.';
            if (error.response) {
                errorMessage += ` (Status: ${error.response.status})`;
            }
            reportContainer.innerHTML = `<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg" role="alert">${errorMessage}</div>`;
        });

    document.getElementById('print-button').addEventListener('click', () => window.print());
});
</script>
@endsection
