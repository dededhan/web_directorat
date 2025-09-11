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
    </style>
</head>
<body class="bg-gray-100">

    @include('layout.navbar_hilirisasi')

    <main class="py-10 pt-28">
        <div class="container mx-auto px-4 lg:px-8">

            <div class="text-center mb-10">
                <h1 class="text-3xl md:text-4xl font-bold text-gray-800">Tren Riset Unggulan UNJ</h1>
                <p class="mt-2 text-gray-600">Visualisasi jumlah riset per fakultas berdasarkan tahun.</p>
                 <div class="mt-4">
                    <a href="{{ route('subdirektorat-inovasi.riset.unj') }}" class="inline-block bg-gray-600 text-white px-5 py-2 rounded-lg hover:bg-gray-700 transition duration-300 text-sm">
                        <i class="fa-solid fa-arrow-left mr-2"></i>Kembali ke Daftar Riset
                    </a>
                </div>
            </div>
            
            <div class="bg-white p-4 md:p-8 rounded-xl shadow-lg">
                <div id="loading-indicator" class="flex justify-center items-center py-40">
                    <div class="loader"></div>
                </div>

                <div id="chart-container" class="hidden">
                     <div class="relative h-[30rem] md:h-[35rem]">
                        <canvas id="combinedChart"></canvas>
                    </div>
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
        
        async function renderChart() {
            try {
                const response = await fetch("{{ route('api.riset-unj.graph-data') }}");
                const data = await response.json();

                // Sembunyikan loader dan tampilkan container chart
                loadingIndicator.classList.add('hidden');
                chartContainer.classList.remove('hidden');

                const ctx = document.getElementById('combinedChart').getContext('2d');
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: data.labels,
                        datasets: data.datasets
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'top', // Tampilkan legenda (daftar fakultas) di atas
                                labels: {
                                    padding: 20,
                                    font: {
                                        size: 12
                                    }
                                }
                            },
                            title: {
                                display: true,
                                text: 'Jumlah Riset per Fakultas Setiap Tahun',
                                font: {
                                    size: 18,
                                    weight: 'bold'
                                },
                                padding: {
                                    bottom: 20
                                }
                            },
                            tooltip: {
                                mode: 'index',
                                intersect: false,
                                callbacks: {
                                    title: function(context) {
                                        return `Tahun ${context[0].label}`;
                                    }
                                }
                            }
                        },
                        scales: {
                            x: {
                                title: {
                                    display: true,
                                    text: 'Tahun',
                                    font: {
                                        weight: 'bold'
                                    }
                                }
                            },
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Jumlah Riset',
                                    font: {
                                        weight: 'bold'
                                    }
                                }
                            }
                        },
                        interaction: {
                            mode: 'index',
                            intersect: false,
                        },
                    }
                });

            } catch (error) {
                console.error('Gagal memuat data grafik:', error);
                loadingIndicator.innerHTML = '<p class="text-red-500 text-center py-40">Gagal memuat data grafik. Coba lagi nanti.</p>';
            }
        }

        renderChart();
    });
    </script>
</body>
</html>