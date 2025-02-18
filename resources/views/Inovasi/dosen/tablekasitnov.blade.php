@extends('Inovasi.dosen.index')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<link rel="stylesheet" href="{{ asset('inovasi/dashboard/table_katsinov/css/table_katsinov.css') }}"> 



@section('contentdosen')
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

    {{-- <div class="dashboard-summary">
        <div class="cards">
            <div class="card-stat">
                <div class="card-stat-content">
                    <h3>Total Innovations</h3>
                    <p class="number">{{ $katsinovs->count() }}</p>
                </div>
                <i class='bx bx-bulb icon'></i>
            </div>
            <div class="card-stat">
                <div class="card-stat-content">
                    <h3>Completed</h3>
                    <p class="number">
                        {{ $katsinovs->filter(function ($k) {
                                $averages = [];
                                foreach (
                                    ['technology', 'organization', 'risk', 'market', 'partnership', 'manufacturing', 'investment']
                                    as $key
                                ) {
                                    $total = $k->scores->avg($key);
                                    $averages[$key] = $total;
                                }
                                $overallAvg = array_sum($averages) / count($averages);
                                return $overallAvg >= 80;
                            })->count() }}
                    </p>
                </div>
                <i class='bx bx-check-circle icon success'></i>
            </div>
            <div class="card-stat">
                <div class="card-stat-content">
                    <h3>Pending</h3>
                    <p class="number">
                        {{ $katsinovs->filter(function ($k) {
                                $averages = [];
                                foreach (
                                    ['technology', 'organization', 'risk', 'market', 'partnership', 'manufacturing', 'investment']
                                    as $key
                                ) {
                                    $total = $k->scores->avg($key);
                                    $averages[$key] = $total;
                                }
                                $overallAvg = array_sum($averages) / count($averages);
                                return $overallAvg >= 60 && $overallAvg < 80;
                            })->count() }}
                    </p>
                </div>
                <i class='bx bx-time-five icon warning'></i>
            </div>
            <div class="card-stat">
                <div class="card-stat-content">
                    <h3>Need Review</h3>
                    <p class="number">
                        {{ $katsinovs->filter(function ($k) {
                                $averages = [];
                                foreach (
                                    ['technology', 'organization', 'risk', 'market', 'partnership', 'manufacturing', 'investment']
                                    as $key
                                ) {
                                    $total = $k->scores->avg($key);
                                    $averages[$key] = $total;
                                }
                                $overallAvg = array_sum($averages) / count($averages);
                                return $overallAvg < 60;
                            })->count() }}
                    </p>
                </div>
                <i class='bx bx-error-circle icon danger'></i>
            </div>
        </div>

        <div class="chart-overview">
            <div class="overview-card">
                <div class="overview-header">
                    <h4>Overall Aspect Performance</h4>
                    <div class="btn-group">
                        <button class="btn btn-sm btn-outline-primary active" onclick="showOverallBarChart()">Bar
                            Chart</button>
                        <button class="btn btn-sm btn-outline-primary" onclick="showOverallSpiderweb()">Spiderweb</button>
                    </div>
                </div>
                <div class="overview-body">
                    <div id="overallBarChart" class="chart-container">
                        <canvas></canvas>
                    </div>
                    <div id="overallSpiderWeb" class="chart-container" style="display:none;">
                        <canvas></canvas>
                    </div>
                </div>
            </div>

            <div class="overview-card">
                <div class="overview-header">
                    <h4>Status Distribution</h4>
                </div>
                <div class="overview-body">
                    <div id="statusPieChart" class="chart-container">
                        <canvas></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

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
                                        ({{ $overallAvg }}%)
                                    </span>
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
    <script src="{{ asset('inovasi/dashboard/table_katsinov/js/table_katsinov.js') }}"></script>
    <script src="{{ asset('inovasi/dashboard/table_katsinov/js/table_katsinovoverall.js') }}"></script>
    <style>

    </style>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Toggle row details
    </script>
@endsection
