@extends('subdirektorat-inovasi.dosen.index')

@section('contentdosen')
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Dashboard</h1>
            <p class="text-gray-500 mt-1">Selamat datang kembali, {{ auth()->user()->name ?? 'Dosen' }}!</p>
        </div>
        <div>
            <a href="#"
               class="inline-flex items-center px-4 py-2 bg-teal-500 text-white rounded-lg shadow hover:bg-teal-600 transition-colors duration-200">
                <i class='bx bxs-cloud-download mr-2'></i>
                <span>Download PDF</span>
            </a>
        </div>
    </div>

    <!-- Summary Boxes -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
        <!-- New Articles Box -->
        <div class="bg-white p-6 rounded-lg shadow-md flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">New Articles</p>
                <h3 class="text-3xl font-bold text-gray-800 mt-1">5</h3>
            </div>
            <div class="bg-blue-100 text-blue-500 p-3 rounded-full">
                <i class='bx bxs-news text-2xl'></i>
            </div>
        </div>

        <!-- Upcoming Events Box -->
        <div class="bg-white p-6 rounded-lg shadow-md flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Upcoming Events</p>
                <h3 class="text-3xl font-bold text-gray-800 mt-1">3</h3>
            </div>
            <div class="bg-green-100 text-green-500 p-3 rounded-full">
                <i class='bx bxs-calendar text-2xl'></i>
            </div>
        </div>

        <!-- Notifications Box -->
        <div class="bg-white p-6 rounded-lg shadow-md flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Notifications</p>
                <h3 class="text-3xl font-bold text-gray-800 mt-1">12</h3>
            </div>
            <div class="bg-yellow-100 text-yellow-500 p-3 rounded-full">
                <i class='bx bxs-bell text-2xl'></i>
            </div>
        </div>
    </div>

    <!-- Main Content Area (Chart) -->
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Statistik Pengunjung</h2>
        <div class="h-96">
            <canvas id="visitorChart"></canvas>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('visitorChart').getContext('2d');
            
            const labels = ["Januari", "Februari", "Maret", "April", "Mei", "Juni"];
            const data = {
                labels: labels,
                datasets: [{
                    label: "Jumlah Pengunjung",
                    data: [120, 150, 180, 200, 250, 300],
                    backgroundColor: 'rgba(13, 148, 136, 0.2)', // Teal-600 with opacity
                    borderColor: 'rgba(13, 148, 136, 1)', // Teal-600
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4 // Membuat garis lebih melengkung
                }]
            };

            const config = {
                type: 'line', // Mengubah chart menjadi line chart yang lebih modern
                data: data,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false
                        }
                    },
                    hover: {
                        mode: 'nearest',
                        intersect: true
                    }
                }
            };

            new Chart(ctx, config);
        });
    </script>
@endsection
