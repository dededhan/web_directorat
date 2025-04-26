@extends('subdirektorat-inovasi.validator.index')

@section('contentvalidator')
    <div class="head-title">
        <div class="left">
            <h1>Dashboard Validator</h1>
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

    <div class="container">
        <!-- Content Section -->
        <div class="content-data">
            <div class="chart-container">
                <canvas id="visitorChart"></canvas>
            </div>
        </div>
    </div>

    <style>
        .container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            min-height: 500px;
            display: flex;
            flex-direction: column;
        }

        .chart-container {
            flex-grow: 1;
            height: 100%;
        }

        #visitorChart {
            width: 100% !important;
            height: 100% !important;
        }
    </style>

    <script>
        // Data jumlah pengunjung per bulan
        const labels = ["Januari", "Februari", "Maret", "April", "Mei", "Juni"];
        const data = {
            labels: labels,
            datasets: [{
                label: "Jumlah Pengunjung",
                data: [120, 150, 180, 200, 250, 300],
                backgroundColor: "rgba(75, 192, 192, 0.2)",
                borderColor: "rgba(75, 192, 192, 1)",
                borderWidth: 1
            }]
        };

        const config = {
            type: "bar",
            data: data,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        };

        const visitorChart = new Chart(
            document.getElementById("visitorChart"),
            config
        );
    </script>
@endsection