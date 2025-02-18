@extends('admin.admin')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


@section('contentadmin')
    <div class="head-title">
        <div class="left">
            <h1>KATSINOV Data</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="#">Dashboard</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a class="active" href="#">KATSINOV Data</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="table-data">
        <div class="order">
            <div class="head">
                <h3>KATSINOV Measurement Data</h3>
                <div class="d-flex justify-content-end">
                    <div class="search-box">
                        <input type="text" id="searchInput" class="form-control" placeholder="Search...">
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th></th>
                            <th>ID</th>
                            <th>Nama/Judul</th>
                            <th>Fokus Bidang</th>
                            <th>Nama Proyek</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($katsinovs as $katsinov)
                            <tr data-toggle="row-details" data-target="#details-{{ $katsinov->id }}">
                                <td>
                                    <button class="btn btn-sm btn-outline-secondary toggle-details">
                                        <i class='bx bx-chevron-down'></i>
                                    </button>
                                </td>
                                <td>{{ $katsinov->id }}</td>
                                <td>{{ $katsinov->title }}</td>
                                <td>{{ $katsinov->focus_area }}</td>
                                <td>{{ $katsinov->project_name }}</td>
                                <td>
                                    @php
                                        $aspects = [
                                            'technology' => 'Teknologi (T)',
                                            'organization' => 'Organisasi (O)',
                                            'risk' => 'Risiko (R)',
                                            'market' => 'Pasar (M)',
                                            'partnership' => 'Kemitraan (P)',
                                            'manufacturing' => 'Manufaktur (Mf)',
                                            'investment' => 'Investasi (I)',
                                        ];

                                        $averages = [];
                                        foreach ($aspects as $key => $label) {
                                            $total = $katsinov->scores->avg($key);
                                            $averages[$key] = number_format($total, 2);
                                        }

                                        $overallAvg = number_format(array_sum($averages) / count($averages), 2);
                                        $status =
                                            $overallAvg >= 80 ? 'success' : ($overallAvg >= 60 ? 'warning' : 'danger');
                                        $statusText =
                                            $overallAvg >= 80
                                                ? 'Completed'
                                                : ($overallAvg >= 60
                                                    ? 'Pending'
                                                    : 'Need Review');
                                    @endphp
                                    <span class="badge bg-{{ $status }}">{{ $statusText }}
                                        ({{ $overallAvg }}%)</span>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <button class="btn btn-sm btn-warning">Edit</button>
                                        <button class="btn btn-sm btn-danger">Delete</button>
                                    </div>
                                </td>
                            </tr>
                            <tr id="details-{{ $katsinov->id }}" class="detail-row" style="display: none;">
                                <td colspan="7">
                                    <div class="detail-content">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="card mb-3">
                                                    <div class="card-header">Basic Information</div>
                                                    <div class="card-body">
                                                        <p><strong>Lembaga:</strong> {{ $katsinov->institution }}</p>
                                                        <p><strong>Alamat:</strong> {{ $katsinov->address }}</p>
                                                        <p><strong>Kontak:</strong> {{ $katsinov->contact }}</p>
                                                        <p><strong>Tanggal Input:</strong> {{ $katsinov->assessment_date }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="card mb-3">
                                                    <div
                                                        class="card-header d-flex justify-content-between align-items-center">
                                                        <span>Aspect Analysis</span>
                                                        <div class="btn-group">
                                                            <button class="btn btn-sm btn-outline-primary"
                                                                onclick="showBarChart({{ $katsinov->id }})">Bar
                                                                Chart</button>
                                                            <button class="btn btn-sm btn-outline-primary"
                                                                onclick="showSpiderweb({{ $katsinov->id }})">Spiderweb</button>
                                                        </div>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-5 aspect-summary">
                                                                <div class="aspect-grid">
                                                                    @foreach ($aspects as $key => $label)
                                                                        <div class="aspect-item">
                                                                            <h6>{{ $label }}</h6>
                                                                            <p>{{ $averages[$key] }}%</p>
                                                                        </div>
                                                                    @endforeach
                                                                    <div class="aspect-item overall">
                                                                        <h6>Overall Average</h6>
                                                                        <p>{{ $overallAvg }}%</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-7">
                                                                <div id="barChart-{{ $katsinov->id }}"
                                                                    class="chart-container">
                                                                    <canvas></canvas>
                                                                </div>
                                                                <div id="spiderWeb-{{ $katsinov->id }}"
                                                                    class="chart-container" style="display:none;">
                                                                    <canvas></canvas>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <style>
        .table-data {
            margin-top: 24px;
        }

        .order {
            background: #fff;
            padding: 24px;
            border-radius: 20px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .table-responsive {
            overflow-x: auto;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th {
            white-space: nowrap;
            background-color: #f8fafc;
            font-weight: 600;
        }

        .table th,
        .table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #edf2f7;
        }

        tr[data-toggle="row-details"] {
            cursor: pointer;
        }

        tr[data-toggle="row-details"]:hover {
            background-color: #f1f5f9;
        }

        .detail-row td {
            padding: 0;
            border: none;
        }

        .detail-content {
            padding: 20px;
            background-color: #f8fafc;
            border-bottom: 1px solid #edf2f7;
        }

        .btn-group {
            display: flex;
            gap: 5px;
        }

        .search-box {
            margin-left: auto;
        }

        .search-box input {
            padding: 8px 12px;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            width: 240px;
        }

        .aspect-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
            gap: 0.75rem;
        }

        .aspect-item {
            background-color: #f1f5f9;
            padding: 0.75rem;
            border-radius: 8px;
        }

        .aspect-item.overall {
            background-color: #e0f2fe;
            grid-column: 1 / -1;
        }

        .aspect-item h6 {
            margin: 0 0 0.5rem 0;
            color: #475569;
            font-size: 0.8rem;
        }

        .aspect-item p {
            margin: 0;
            font-size: 1.1rem;
            font-weight: 600;
            color: #0f172a;
        }

        .badge {
            font-size: 0.7em;
            padding: 6px 12px;
            border-radius: 20px;
        }

        .chart-container {
            width: 100%;
            height: 220px;
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Toggle row details
        document.querySelectorAll('.toggle-details').forEach(button => {
            button.addEventListener('click', function(e) {
                e.stopPropagation();
                const row = this.closest('tr');
                const targetId = row.getAttribute('data-target');
                const detailRow = document.querySelector(targetId);

                if (detailRow.style.display === 'none') {
                    detailRow.style.display = '';
                    this.querySelector('i').className = 'bx bx-chevron-up';
                    const katsinovId = targetId.substring(9); // Extract ID from #details-XXX
                    initCharts(katsinovId);
                } else {
                    detailRow.style.display = 'none';
                    this.querySelector('i').className = 'bx bx-chevron-down';
                }
            });
        });

        // Row click to expand
        document.querySelectorAll('tr[data-toggle="row-details"]').forEach(row => {
            row.addEventListener('click', function(e) {
                if (!e.target.closest('button')) {
                    this.querySelector('.toggle-details').click();
                }
            });
        });

        // Search functionality
        document.getElementById('searchInput').addEventListener('keyup', function() {
            const searchText = this.value.toLowerCase();
            const rows = document.querySelectorAll('tr[data-toggle="row-details"]');

            rows.forEach(row => {
                const cells = row.getElementsByTagName('td');
                let found = false;

                for (let i = 1; i < cells.length - 1; i++) {
                    const text = cells[i].textContent.toLowerCase();
                    if (text.includes(searchText)) {
                        found = true;
                        break;
                    }
                }

                const targetId = row.getAttribute('data-target');
                const detailRow = document.querySelector(targetId);

                if (found) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                    if (detailRow.style.display !== 'none') {
                        detailRow.style.display = 'none';
                        row.querySelector('.toggle-details i').className = 'bx bx-chevron-down';
                    }
                }
            });
        });

        function getChartColors() {
            return {
                technology: 'rgba(255, 159, 64, 0.7)',
                organization: 'rgba(75, 192, 192, 0.7)',
                risk: 'rgba(153, 102, 255, 0.7)',
                market: 'rgba(255, 99, 132, 0.7)',
                partnership: 'rgba(255, 205, 86, 0.7)',
                manufacturing: 'rgba(54, 162, 235, 0.7)',
                investment: 'rgba(201, 203, 207, 0.7)'
            };
        }

        window.initCharts = function(katsinovId) {
            console.log("Initializing charts for katsinov ID:", katsinovId); // Debug log
            // Initialize both charts but show only bar chart initially
            initBarChart(katsinovId);
            initSpiderwebChart(katsinovId);
        };

        window.showBarChart = function(katsinovId) {
            document.getElementById(`barChart-${katsinovId}`).style.display = '';
            document.getElementById(`spiderWeb-${katsinovId}`).style.display = 'none';
        };

        window.showSpiderweb = function(katsinovId) {
            document.getElementById(`barChart-${katsinovId}`).style.display = 'none';
            document.getElementById(`spiderWeb-${katsinovId}`).style.display = '';
        };

        window.initBarChart = function(katsinovId) {
            console.log("Initializing bar chart for katsinov ID:", katsinovId); // Debug log
            const chartContainer = document.querySelector(`#barChart-${katsinovId} canvas`);
            if (!chartContainer) {
                console.error(`Bar chart container for ID ${katsinovId} not found`);
                return;
            }

            // Extract data from DOM elements for this specific katsinov
            const aspectItems = document.querySelectorAll(`#details-${katsinovId} .aspect-item:not(.overall)`);
            if (aspectItems.length === 0) {
                console.error(`No aspect items found for katsinov ID ${katsinovId}`);
                return;
            }

            const labels = [];
            const data = [];

            aspectItems.forEach(item => {
                const header = item.querySelector('h6');
                const value = item.querySelector('p');

                if (!header || !value) {
                    console.error("Missing header or value in aspect item", item);
                    return;
                }

                labels.push(header.textContent);
                data.push(parseFloat(value.textContent));
            });

            if (labels.length === 0 || data.length === 0) {
                console.error("No valid data extracted for chart");
                return;
            }

            // Clear any existing chart
            if (chartContainer.chart) {
                chartContainer.chart.destroy();
            }

            const colors = Object.values(getChartColors());

            const chart = new Chart(chartContainer, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Aspect Scores (%)',
                        data: data,
                        backgroundColor: colors,
                        borderColor: colors.map(color => color.replace('0.7', '1')),
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.parsed.y + '%';
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 100,
                            title: {
                                display: true,
                                text: 'Percentage (%)'
                            }
                        }
                    }
                }
            });

            // Store chart instance for cleanup if needed later
            chartContainer.chart = chart;
            console.log("Bar chart initialized successfully");
        };

        window.initSpiderwebChart = function(katsinovId) {
            console.log("Initializing spiderweb chart for katsinov ID:", katsinovId); // Debug log
            const chartContainer = document.querySelector(`#spiderWeb-${katsinovId} canvas`);
            if (!chartContainer) {
                console.error(`Spiderweb chart container for ID ${katsinovId} not found`);
                return;
            }

            // Extract data from DOM elements for this specific katsinov
            const aspectItems = document.querySelectorAll(`#details-${katsinovId} .aspect-item:not(.overall)`);
            if (aspectItems.length === 0) {
                console.error(`No aspect items found for katsinov ID ${katsinovId}`);
                return;
            }

            const labels = [];
            const data = [];

            aspectItems.forEach(item => {
                const header = item.querySelector('h6');
                const value = item.querySelector('p');

                if (!header || !value) {
                    console.error("Missing header or value in aspect item", item);
                    return;
                }

                labels.push(header.textContent);
                data.push(parseFloat(value.textContent));
            });

            if (labels.length === 0 || data.length === 0) {
                console.error("No valid data extracted for chart");
                return;
            }

            // Clear any existing chart
            if (chartContainer.chart) {
                chartContainer.chart.destroy();
            }

            const colorKeys = Object.keys(getChartColors());
            const colors = colorKeys.map(key => getChartColors()[key]);

            const chart = new Chart(chartContainer, {
                type: 'radar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Aspect Scores',
                        data: data,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        pointBackgroundColor: colors,
                        pointBorderColor: '#fff',
                        pointHoverBackgroundColor: '#fff',
                        pointHoverBorderColor: colors
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        r: {
                            angleLines: {
                                display: true
                            },
                            suggestedMin: 0,
                            suggestedMax: 100
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.parsed.r + '%';
                                }
                            }
                        }
                    }
                }
            });

            // Store chart instance for cleanup if needed later
            chartContainer.chart = chart;
            console.log("Spiderweb chart initialized successfully");
        };
    </script>
@endsection
