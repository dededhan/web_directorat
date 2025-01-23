@extends('admin.admin')

@section('contentadmin')
    <div class="head-title">
        <div class="left">
            <h1>Dashboard Direktorat</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="#">Dashboard</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a class="active" href="#">Home</a>
                </li>
            </ul>
        </div>
        <a href="#" class="btn-download">
            <i class='bx bxs-cloud-download'></i>
            <span class="text">Download PDF</span>
        </a>
    </div>

    <!-- Summary Boxes -->
    <ul class="box-info">
        <li>
            <i class='bx bxs-news'></i>
            <span class="text">
                <h3>5</h3>
                <p>New Articles</p>
            </span>
        </li>
        <li>
            <i class='bx bxs-calendar'></i>
            <span class="text">
                <h3>3</h3>
                <p>Upcoming Events</p>
            </span>
        </li>
        <li>
            <i class='bx bxs-bell'></i>
            <span class="text">
                <h3>12</h3>
                <p>Notifications</p>
            </span>
        </li>
    </ul>

    <style>
    .container {
        background-color: white; /* Menetapkan warna latar belakang putih */
        padding: 20px; /* Menambahkan padding di dalam container */
        border-radius: 8px; /* Menambahkan sudut melengkung jika diinginkan */
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Menambahkan bayangan ringan */
    }
</style>
<style>
    .container {
        background-color: white; /* Menetapkan warna latar belakang putih */
        padding: 20px; /* Menambahkan padding di dalam container */
        border-radius: 8px; /* Menambahkan sudut melengkung */
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Menambahkan bayangan ringan */
        min-height: 500px; /* Menetapkan tinggi minimal container */
    }
</style>
<style>
    .container {
        background-color: white; /* Menetapkan warna latar belakang putih */
        padding: 20px; /* Menambahkan padding di dalam container */
        border-radius: 8px; /* Menambahkan sudut melengkung */
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Menambahkan bayangan ringan */
        min-height: 500px; /* Menetapkan tinggi minimal container */
        display: flex; /* Menjadikan container sebagai flex container */
        flex-direction: column; /* Agar chart mengisi container secara vertikal */
    }

    .chart-container {
        flex-grow: 1; /* Agar canvas mengisi seluruh ruang yang tersedia */
        height: 100%; /* Menyesuaikan tinggi container */
    }

    #visitorChart {
        width: 100% !important; /* Membuat chart memenuhi lebar container */
        height: 100% !important; /* Membuat chart memenuhi tinggi container */
    }
</style>

<div class="container">
    <!-- Content Section -->
    <div class="content-data">
        <div class="chart-container">
            <canvas id="visitorChart"></canvas>
        </div>
    </div>

    <script>
        // Data jumlah pengunjung per bulan
        const labels = ["Januari", "Februari", "Maret", "April", "Mei", "Juni"];
        const data = {
            labels: labels,
            datasets: [{
                label: "Jumlah Pengunjung",
                data: [120, 150, 180, 200, 250, 300], // Data pengunjung
                backgroundColor: "rgba(75, 192, 192, 0.2)",
                borderColor: "rgba(75, 192, 192, 1)",
                borderWidth: 1
            }]
        };

        // Konfigurasi chart
        const config = {
            type: "bar", // Jenis chart: bar, line, pie, dll.
            data: data,
            options: {
                responsive: true,
                maintainAspectRatio: false, // Mengatur rasio chart agar bisa menyesuaikan container
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        };

        // Render chart
        const visitorChart = new Chart(
            document.getElementById("visitorChart"),
            config
        );
    </script>
</div>
@endsection