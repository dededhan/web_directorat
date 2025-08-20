@extends('admin.admin')

@section('contentadmin')
    <div class="head-title">
        <div class="left">
            <h1>Laporan Responden</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a class="active" href="#">Laporan Responden</a>
                </li>
            </ul>
        </div>
        <button id="print-button" class="btn btn-primary">
            <i class='bx bxs-printer'></i>
            <span class="text">Cetak Laporan</span>
        </button>
    </div>

    <div class="report-container">
        <div class="table-data">
            <div class="order">
                <div class="head">
                    <h3>Jumlah Responden per Fakultas</h3>
                </div>
                <canvas id="facultyChart" style="max-height: 400px;"></canvas>
            </div>
        </div>
        <div class="table-data">
            <div class="order">
                <div class="head">
                    <h3>Jumlah Responden per Kategori</h3>
                </div>
                <canvas id="categoryChart" style="max-height: 400px;"></canvas>
            </div>
        </div>
        <div class="table-data">
            <div class="order">
                <div class="head">
                    <h3>Status Pengisian Responden</h3>
                </div>
                <canvas id="statusChart" style="max-height: 400px;"></canvas>
            </div>
        </div>
    </div>

    <style>
        .report-container {
            display: grid;
            grid-template-columns: 1fr;
            gap: 24px;
        }

        @media print {

            #sidebar,
            #content nav,
            .head-title .breadcrumb,
            #print-button {
                display: none !important;
            }

            #content {
                width: 100%;
                padding: 0;
                margin: 0;
            }

            .head-title h1 {
                font-size: 24pt;
                text-align: center;
                width: 100%;
                margin-bottom: 30px;
            }

            .table-data {
                page-break-inside: avoid;
                margin-bottom: 20px;
                border: none !important;
                box-shadow: none !important;
            }

            .order {
                padding: 10px;
            }
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const getRandomColor = () =>
                `rgba(${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, 0.7)`;
            const apiUrl = '{{ route('api.responden.chartSummary') }}';
            axios.get(apiUrl)
                .then(response => {
                    const data = response.data;
                    const facultyCtx = document.getElementById('facultyChart').getContext('2d');
                    const facultyLabels = Object.keys(data.byFaculty);
                    const facultyData = Object.values(data.byFaculty);
                    new Chart(facultyCtx, {
                        type: 'bar',
                        data: {
                            labels: facultyLabels.map(label => label.toUpperCase()),
                            datasets: [{
                                label: 'Jumlah Responden',
                                data: facultyData,
                                backgroundColor: facultyLabels.map(() => getRandomColor()),
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            },
                            responsive: true,
                            maintainAspectRatio: false
                        }
                    });

                    const categoryCtx = document.getElementById('categoryChart').getContext('2d');
                    const categoryLabels = Object.keys(data.byCategory);
                    const categoryData = Object.values(data.byCategory);
                    new Chart(categoryCtx, {
                        type: 'pie',
                        data: {
                            labels: categoryLabels.map(label => label.charAt(0).toUpperCase() + label
                                .slice(1)),
                            datasets: [{
                                data: categoryData,
                                backgroundColor: ['rgba(255, 99, 132, 0.7)',
                                    'rgba(54, 162, 235, 0.7)', 'rgba(255, 206, 86, 0.7)',
                                    'rgba(75, 192, 192, 0.7)'
                                ]
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false
                        }
                    });

                    const statusCtx = document.getElementById('statusChart').getContext('2d');
                    const statusLabels = Object.keys(data.byStatus);
                    const statusData = Object.values(data.byStatus);
                    new Chart(statusCtx, {
                        type: 'doughnut',
                        data: {
                            labels: statusLabels.map(label => label.replace(/_/g, ' ').replace(/\b\w/g,
                                l => l.toUpperCase())),
                            datasets: [{
                                data: statusData,
                                backgroundColor: statusLabels.map(() => getRandomColor())
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false
                        }
                    });
                })
                .catch(error => {
                    console.error("Gagal mengambil data chart:", error);
                    const reportContainer = document.querySelector('.report-container');
                    reportContainer.innerHTML =
                        '<p class="text-center text-danger">Gagal memuat data laporan. Silakan cek console untuk detailnya.</p>';
                });

            document.getElementById('print-button').addEventListener('click', function() {
                window.print();
            });
        });
    </script>
@endsection
