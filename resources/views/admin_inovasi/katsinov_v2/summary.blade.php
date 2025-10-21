@extends('admin_inovasi.index')

@section('contentadmin_inovasi')
<!-- Chart.js v3 - Required for summary charts -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>

<div class="container-fluid p-6">
    {{-- Header --}}
    <div class="mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="h3 mb-2">KATSINOV V2 - Overall Summary</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin_inovasi.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin_inovasi.katsinov-v2.index') }}">KATSINOV V2</a></li>
                        <li class="breadcrumb-item active">Summary</li>
                    </ol>
                </nav>
            </div>
            <div>
                <a href="{{ route('admin_inovasi.katsinov-v2.show', $katsinov->id) }}" class="btn btn-secondary">
                    <i class='bx bx-arrow-back'></i> Back to Detail
                </a>
            </div>
        </div>
    </div>

    {{-- Innovation Details Card --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="m-0">📊 Innovation Summary for: {{ $katsinov->title }}</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p class="mb-2"><strong>Project Name:</strong> {{ $katsinov->project_name ?? $katsinov->title }}</p>
                    <p class="mb-2"><strong>Focus Area:</strong> {{ $katsinov->focus_area }}</p>
                    <p class="mb-2"><strong>Institution:</strong> {{ $katsinov->institution ?? 'Universitas Negeri Jakarta' }}</p>
                </div>
                <div class="col-md-6">
                    <p class="mb-2"><strong>Assessment Date:</strong> {{ \Carbon\Carbon::parse($katsinov->created_at)->format('d M Y') }}</p>
                    <p class="mb-2"><strong>Status:</strong>
                        @php
                            $avgScore = $overallAverage;
                        @endphp
                        <span class="badge {{ $avgScore >= 80 ? 'bg-success' : ($avgScore >= 60 ? 'bg-warning' : 'bg-danger') }}">
                            {{ $avgScore >= 80 ? 'Ready' : ($avgScore >= 60 ? 'Developing' : 'Needs Review') }}
                        </span>
                    </p>
                    <p class="mb-2"><strong>Overall Score:</strong> 
                        <span class="fs-4 fw-bold {{ $avgScore >= 80 ? 'text-success' : ($avgScore >= 60 ? 'text-warning' : 'text-danger') }}">
                            {{ number_format($avgScore, 1) }}%
                        </span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- Overall Aspect Performance Card --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="m-0">Overall Aspect Performance</h4>
            <div class="btn-group btn-group-sm">
                <button class="btn btn-light active" id="showBarChart">Bar Chart</button>
                <button class="btn btn-light" id="showRadarChart">Radar Chart</button>
            </div>
        </div>
        <div class="card-body">
            <div class="chart-container position-relative" style="height:400px;">
                <canvas id="overallChart"></canvas>
                <canvas id="radarChart" style="display:none;"></canvas>
            </div>
        </div>
    </div>

    {{-- Performance by Indicator with Tabs --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="m-0">Performance by Indicator</h4>
        </div>
        <div class="card-body">
            {{-- Aspect Tabs --}}
            <ul class="nav nav-tabs mb-4" id="aspectTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="technology-tab" data-bs-toggle="tab" data-bs-target="#technology" type="button" role="tab" aria-controls="technology" aria-selected="true">Technology</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="market-tab" data-bs-toggle="tab" data-bs-target="#market" type="button" role="tab" aria-controls="market" aria-selected="false">Market</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="organization-tab" data-bs-toggle="tab" data-bs-target="#organization" type="button" role="tab" aria-controls="organization" aria-selected="false">Organization</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="manufacturing-tab" data-bs-toggle="tab" data-bs-target="#manufacturing" type="button" role="tab" aria-controls="manufacturing" aria-selected="false">Manufacturing</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="partnership-tab" data-bs-toggle="tab" data-bs-target="#partnership" type="button" role="tab" aria-controls="partnership" aria-selected="false">Partnership</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="investment-tab" data-bs-toggle="tab" data-bs-target="#investment" type="button" role="tab" aria-controls="investment" aria-selected="false">Investment</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="risk-tab" data-bs-toggle="tab" data-bs-target="#risk" type="button" role="tab" aria-controls="risk" aria-selected="false">Risk</button>
                </li>
            </ul>

            {{-- Tab Content --}}
            <div class="tab-content" id="aspectTabContent">
                @php
                    $aspects = ['technology', 'market', 'organization', 'manufacturing', 'partnership', 'investment', 'risk'];
                    $aspectTitles = [
                        'technology' => 'Technology',
                        'market' => 'Market',
                        'organization' => 'Organization',
                        'manufacturing' => 'Manufacturing',
                        'partnership' => 'Partnership',
                        'investment' => 'Investment',
                        'risk' => 'Risk'
                    ];
                @endphp
                
                @foreach($aspects as $aspectIndex => $aspect)
                    <div class="tab-pane fade {{ $aspectIndex === 0 ? 'show active' : '' }}" id="{{ $aspect }}" role="tabpanel" aria-labelledby="{{ $aspect }}-tab">
                        <div class="row">
                            <div class="col-md-12">
                                <h5 class="text-center mb-3">Performance Overview by Indicator - {{ $aspectTitles[$aspect] }} Aspect</h5>
                                <div class="chart-container" style="height: 400px;">
                                    <canvas id="{{ $aspect }}Chart"></canvas>
                                </div>
                            </div>
                        </div>
                        
                        {{-- Aspect Details Card --}}
                        <div class="card bg-light mt-4">
                            <div class="card-header">
                                <h5 class="m-0">{{ $aspectTitles[$aspect] }} Aspect Details</h5>
                            </div>
                            <div class="card-body">
                                <p>
                                    <strong>Overall Score:</strong>
                                    {{ number_format($overallAspectScores[$aspect] ?? 0, 1) }}%
                                    <span class="badge {{ ($overallAspectScores[$aspect] ?? 0) >= 80 ? 'bg-success' : (($overallAspectScores[$aspect] ?? 0) >= 60 ? 'bg-warning' : 'bg-danger') }} ms-2">
                                        {{ ($overallAspectScores[$aspect] ?? 0) >= 80 ? 'Ready' : (($overallAspectScores[$aspect] ?? 0) >= 60 ? 'Developing' : 'Needs Review') }}
                                    </span>
                                </p>
                                
                                <div class="table-responsive">
                                    <table class="table table-sm table-hover">
                                        <thead>
                                            <tr>
                                                <th>Indicator</th>
                                                <th>Score</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $indicatorTitles = [
                                                    1 => 'Basic Research & Technology Development',
                                                    2 => 'Technology Demonstration',
                                                    3 => 'Technology Refinement & Implementation',
                                                    4 => 'Market Introduction & Commercialization',
                                                    5 => 'Market Expansion & Support',
                                                    6 => 'Sustainable Market & Future Planning',
                                                ];
                                            @endphp
                                            @for($i = 1; $i <= 6; $i++)
                                                @php
                                                    $score = $indicatorAspectScores[$i][$aspect] ?? 0;
                                                    $statusClass = $score >= 80 ? 'bg-success' : ($score >= 60 ? 'bg-warning' : 'bg-danger');
                                                    $statusText = $score >= 80 ? 'Ready' : ($score >= 60 ? 'Developing' : 'Needs Review');
                                                @endphp
                                                <tr>
                                                    <td><strong>{{ $indicatorTitles[$i] }}</strong></td>
                                                    <td>{{ number_format($score, 1) }}%</td>
                                                    <td><span class="badge {{ $statusClass }}">{{ $statusText }}</span></td>
                                                </tr>
                                            @endfor
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Detailed Indicator Charts with Aspect Details --}}
    @php
        $indicatorTitles = [
            1 => 'Basic Research & Technology Development',
            2 => 'Technology Demonstration',
            3 => 'Technology Refinement & Implementation',
            4 => 'Market Introduction & Commercialization',
            5 => 'Market Expansion & Support',
            6 => 'Sustainable Market & Future Planning',
        ];
        
        $aspectNames = [
            'technology' => ['label' => 'Technology (T)', 'icon' => '⚙️', 'color' => 'rgb(255, 99, 132)'],
            'market' => ['label' => 'Market (M)', 'icon' => '📊', 'color' => 'rgb(54, 162, 235)'],
            'organization' => ['label' => 'Organization (O)', 'icon' => '🏢', 'color' => 'rgb(255, 206, 86)'],
            'manufacturing' => ['label' => 'Manufacturing (Mf)', 'icon' => '🏭', 'color' => 'rgb(75, 192, 192)'],
            'partnership' => ['label' => 'Partnership (P)', 'icon' => '🤝', 'color' => 'rgb(153, 102, 255)'],
            'investment' => ['label' => 'Investment (I)', 'icon' => '💰', 'color' => 'rgb(255, 159, 64)'],
            'risk' => ['label' => 'Risk (R)', 'icon' => '⚠️', 'color' => 'rgb(70, 150, 130)'],
        ];
    @endphp
    
    @foreach($indicatorScores as $index => $data)
        <div class="card mb-5 shadow-sm">
            <div class="card-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                <h4 class="m-0">Indicator {{ $index }}: {{ $indicatorTitles[$index] }}</h4>
            </div>
            <div class="card-body">
                {{-- Charts Row: Spider Chart + Bar Chart --}}
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h5 class="text-center mb-3">Spider Chart - All Aspects</h5>
                        <div class="chart-container position-relative" style="height:350px;">
                            <canvas id="indicator{{ $index }}Chart"></canvas>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h5 class="text-center mb-3">Bar Chart - All Aspects</h5>
                        <div class="chart-container position-relative" style="height:350px;">
                            <canvas id="indicator{{ $index }}BarChart"></canvas>
                        </div>
                    </div>
                </div>
                
                {{-- Aspect Summary Table --}}
                <div class="row mb-4">
                    <div class="col-md-12">
                        <h5 class="mb-3">Aspect Summary</h5>
                        <table class="table table-sm table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>Aspect</th>
                                    <th width="20%" class="text-center">Score</th>
                                    <th width="20%" class="text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($aspectNames as $key => $info)
                                    @php
                                        $score = $indicatorAspectScores[$index][$key] ?? 0;
                                        $statusClass = $score >= 80 ? 'success' : ($score >= 60 ? 'warning' : 'danger');
                                        $statusText = $score >= 80 ? 'Ready' : ($score >= 60 ? 'Developing' : 'Needs Review');
                                        $statusBg = $score >= 80 ? 'bg-success' : ($score >= 60 ? 'bg-warning' : 'bg-danger');
                                    @endphp
                                    <tr>
                                        <td>
                                            <span style="color: {{ $info['color'] }}; font-size: 1.2em;">{{ $info['icon'] }}</span>
                                            <strong>{{ $info['label'] }}</strong>
                                        </td>
                                        <td class="text-center">
                                            <strong class="text-{{ $statusClass }}">{{ number_format($score, 1) }}%</strong>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge {{ $statusBg }}">{{ $statusText }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                
                {{-- Detailed Aspect Cards with Questions --}}
                <div class="row">
                    @foreach($aspectNames as $aspectKey => $aspectInfo)
                        @php
                            // Get questions for this indicator and aspect
                            $aspectQuestions = $questionScores[$index][$aspectKey] ?? [];
                            $aspectScore = $indicatorAspectScores[$index][$aspectKey] ?? 0;
                            
                            // Skip if no questions
                            if (empty($aspectQuestions)) continue;
                            
                            $statusClass = $aspectScore >= 80 ? 'success' : ($aspectScore >= 60 ? 'warning' : 'danger');
                        @endphp
                        
                        <div class="col-md-6 mb-4">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-header" style="background-color: {{ $aspectInfo['color'] }}20; border-left: 4px solid {{ $aspectInfo['color'] }};">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <span style="font-size: 1.5em;">{{ $aspectInfo['icon'] }}</span>
                                            <strong class="ms-2">{{ $aspectInfo['label'] }}</strong>
                                        </div>
                                        <div class="text-end">
                                            <span class="badge bg-{{ $statusClass }}">{{ $aspectScore >= 80 ? 'Ready' : ($aspectScore >= 60 ? 'Developing' : 'Needs Review') }}</span>
                                            <div class="small mt-1"><strong>Overall: {{ number_format($aspectScore, 1) }}%</strong></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body p-3">
                                    {{-- Mini Line Chart for Questions --}}
                                    <div class="chart-container mb-3" style="height: 150px;">
                                        <canvas id="chart_{{ $index }}_{{ $aspectKey }}"></canvas>
                                    </div>
                                    
                                    {{-- Question List --}}
                                    <div class="aspect-questions">
                                        <strong class="small">Pertanyaan KATSINOV {{ $index }}:</strong>
                                        <ul class="list-unstyled mt-2 mb-0">
                                            @foreach($aspectQuestions as $qIndex => $questionScore)
                                                @php
                                                    $scorePercent = $questionScore * 20; // Convert 0-5 to percentage
                                                    $barColor = $scorePercent >= 80 ? $aspectInfo['color'] : ($scorePercent >= 60 ? 'orange' : 'red');
                                                    $questionText = $questionTexts[$index][$aspectKey][$qIndex] ?? 'Pertanyaan ' . ($qIndex + 1);
                                                @endphp
                                                <li class="mb-3 small">
                                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                                        <span class="text-muted fw-bold">Q{{ $qIndex + 1 }}</span>
                                                        <span class="badge" style="background-color: {{ $barColor }}">{{ $questionScore }}/5</span>
                                                    </div>
                                                    <div class="mb-1">
                                                        <small class="text-dark">{{ $questionText }}</small>
                                                    </div>
                                                    <div class="progress" style="height: 8px;">
                                                        <div class="progress-bar" role="progressbar" 
                                                             style="width: {{ $scorePercent }}%; background-color: {{ $barColor }};"
                                                             aria-valuenow="{{ $scorePercent }}" 
                                                             aria-valuemin="0" 
                                                             aria-valuemax="100">
                                                        </div>
                                                    </div>
                                                    <small class="text-muted">{{ $scorePercent }}%</small>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endforeach

    {{-- Action Buttons --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-body text-center">
            <a href="{{ route('admin_inovasi.katsinov-v2.show', $katsinov->id) }}" class="btn btn-secondary me-2">
                <i class='bx bx-arrow-back'></i> Back to Detail
            </a>
            
            @if(in_array(Auth::user()->role, ['admin_direktorat', 'admin_inovasi', 'validator']))
                <a href="{{ route('admin_inovasi.katsinov-v2.full-report', $katsinov->id) }}" class="btn btn-warning me-2">
                    <i class='bx bx-file-find'></i> Laporan Form Katsinov
                </a>
            @endif
            
            <a href="{{ route('admin_inovasi.katsinov-v2.print-summary', $katsinov->id) }}" target="_blank" class="btn btn-info me-2">
                <i class='bx bx-printer'></i> Print Summary
            </a>
            @if($katsinov->status === 'completed')
                <a href="{{ route('admin_inovasi.katsinov-v2.certificate', $katsinov->id) }}" target="_blank" class="btn btn-success">
                    <i class='bx bx-certification'></i> Download Certificate
                </a>
            @endif
        </div>
    </div>
</div>

{{-- Chart.js Scripts --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Check if Chart.js is loaded
    if (typeof Chart === 'undefined') {
        console.error('Chart.js is not loaded!');
        return;
    }
    console.log('Chart.js version:', Chart.version);
    
    // Parse data from controller
    const overallAspectScores = {!! $overallAspectScoresJson !!};
    const indicatorAspectScores = {!! $indicatorAspectScoresJson !!};
    
    console.log('Overall Aspect Scores:', overallAspectScores);
    console.log('Indicator Aspect Scores:', indicatorAspectScores);
    
    // 1. Overall Aspect Bar Chart
    const aspectLabels = ['Technology', 'Market', 'Organization', 'Manufacturing', 'Partnership', 'Investment', 'Risk'];
    const aspectData = [
        overallAspectScores.technology || 0,
        overallAspectScores.market || 0,
        overallAspectScores.organization || 0,
        overallAspectScores.manufacturing || 0,
        overallAspectScores.partnership || 0,
        overallAspectScores.investment || 0,
        overallAspectScores.risk || 0
    ];
    
    const aspectColors = [
        'rgb(255, 99, 132)',
        'rgb(54, 162, 235)',
        'rgb(255, 206, 86)',
        'rgb(75, 192, 192)',
        'rgb(153, 102, 255)',
        'rgb(255, 159, 64)',
        'rgb(70, 150, 130)'
    ];
    
    const overallCtx = document.getElementById('overallChart').getContext('2d');
    const overallBarChart = new Chart(overallCtx, {
        type: 'bar',
        data: {
            labels: aspectLabels,
            datasets: [{
                label: 'Overall Aspect Score (%)',
                data: aspectData,
                backgroundColor: aspectColors.map(color => color.replace('rgb', 'rgba').replace(')', ', 0.7)')),
                borderColor: aspectColors,
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100,
                    ticks: {
                        callback: function(value) {
                            return value + '%';
                        }
                    }
                }
            },
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.dataset.label + ': ' + context.parsed.y.toFixed(1) + '%';
                        }
                    }
                }
            }
        }
    });
    
    // 2. Overall Aspect Radar Chart
    const radarCtx = document.getElementById('radarChart').getContext('2d');
    const overallRadarChart = new Chart(radarCtx, {
        type: 'radar',
        data: {
            labels: aspectLabels,
            datasets: [{
                label: 'Overall Aspect Score (%)',
                data: aspectData,
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgb(54, 162, 235)',
                borderWidth: 2,
                pointBackgroundColor: 'rgb(54, 162, 235)',
                pointBorderColor: '#fff',
                pointHoverBackgroundColor: '#fff',
                pointHoverBorderColor: 'rgb(54, 162, 235)'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                r: {
                    beginAtZero: true,
                    max: 100,
                    ticks: {
                        stepSize: 20,
                        callback: function(value) {
                            return value + '%';
                        }
                    }
                }
            },
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                }
            }
        }
    });
    
    // Toggle between Bar and Radar Chart
    document.getElementById('showBarChart').addEventListener('click', function() {
        document.getElementById('overallChart').style.display = 'block';
        document.getElementById('radarChart').style.display = 'none';
        this.classList.add('active');
        document.getElementById('showRadarChart').classList.remove('active');
    });
    
    document.getElementById('showRadarChart').addEventListener('click', function() {
        document.getElementById('overallChart').style.display = 'none';
        document.getElementById('radarChart').style.display = 'block';
        this.classList.add('active');
        document.getElementById('showBarChart').classList.remove('active');
    });
    
    // 3. Spider Charts for Each Indicator
    for (let i = 1; i <= 6; i++) {
        // Check if this indicator exists in the data
        if (!indicatorAspectScores[i]) {
            console.log('Skipping indicator ' + i + ' - no data');
            continue;
        }
        
        // Check if canvas element exists
        const canvasElement = document.getElementById('indicator' + i + 'Chart');
        if (!canvasElement) {
            console.log('Skipping indicator ' + i + ' - canvas not found');
            continue;
        }
        
        const indicatorData = [
            indicatorAspectScores[i].technology || 0,
            indicatorAspectScores[i].market || 0,
            indicatorAspectScores[i].organization || 0,
            indicatorAspectScores[i].manufacturing || 0,
            indicatorAspectScores[i].partnership || 0,
            indicatorAspectScores[i].investment || 0,
            indicatorAspectScores[i].risk || 0
        ];
        
        const ctx = canvasElement.getContext('2d');
        new Chart(ctx, {
            type: 'radar',
            data: {
                labels: aspectLabels,
                datasets: [{
                    label: 'Indicator ' + i + ' Score (%)',
                    data: indicatorData,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgb(54, 162, 235)',
                    borderWidth: 2,
                    pointBackgroundColor: aspectColors,
                    pointBorderColor: '#fff',
                    pointHoverBackgroundColor: '#fff',
                    pointHoverBorderColor: aspectColors,
                    pointRadius: 5,
                    pointHoverRadius: 7
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    r: {
                        beginAtZero: true,
                        max: 100,
                        ticks: {
                            stepSize: 20,
                            callback: function(value) {
                                return value + '%';
                            },
                            backdropColor: 'transparent'
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.1)'
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return aspectLabels[context.dataIndex] + ': ' + context.parsed.r.toFixed(1) + '%';
                            }
                        }
                    }
                }
            }
        });
        
        // Create Bar Chart for this indicator
        const barCanvasElement = document.getElementById('indicator' + i + 'BarChart');
        if (barCanvasElement) {
            const barCtx = barCanvasElement.getContext('2d');
            new Chart(barCtx, {
                type: 'bar',
                data: {
                    labels: aspectLabels,
                    datasets: [{
                        label: 'Indicator ' + i + ' Score (%)',
                        data: indicatorData,
                        backgroundColor: aspectColors.map(color => color.replace('rgb', 'rgba').replace(')', ', 0.7)')),
                        borderColor: aspectColors,
                        borderWidth: 2,
                        borderRadius: 5
                    }]
                },
                options: {
                    indexAxis: 'y', // Horizontal bar chart
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            beginAtZero: true,
                            max: 100,
                            ticks: {
                                callback: function(value) {
                                    return value + '%';
                                },
                                stepSize: 20
                            },
                            grid: {
                                color: 'rgba(0, 0, 0, 0.1)'
                            }
                        },
                        y: {
                            grid: {
                                display: false
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.label + ': ' + context.parsed.x.toFixed(1) + '%';
                                }
                            }
                        }
                    }
                }
            });
        }
    }
    
    // 4. Line Charts for Each Aspect (Performance by Indicator)
    const aspects = ['technology', 'market', 'organization', 'manufacturing', 'partnership', 'investment', 'risk'];
    const aspectChartColors = {
        'technology': 'rgb(255, 99, 132)',
        'market': 'rgb(54, 162, 235)',
        'organization': 'rgb(255, 206, 86)',
        'manufacturing': 'rgb(75, 192, 192)',
        'partnership': 'rgb(153, 102, 255)',
        'investment': 'rgb(255, 159, 64)',
        'risk': 'rgb(70, 150, 130)'
    };
    
    aspects.forEach(aspect => {
        // Check if canvas exists for this aspect
        const canvasElement = document.getElementById(aspect + 'Chart');
        if (!canvasElement) {
            console.log('Skipping aspect chart ' + aspect + ' - canvas not found');
            return;
        }
        
        const data = [];
        for (let i = 1; i <= 6; i++) {
            if (indicatorAspectScores[i]) {
                data.push(indicatorAspectScores[i][aspect] || 0);
            }
        }
        
        const ctx = canvasElement.getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['KATSINOV 1', 'KATSINOV 2', 'KATSINOV 3', 'KATSINOV 4', 'KATSINOV 5', 'KATSINOV 6'],
                datasets: [{
                    label: aspect.charAt(0).toUpperCase() + aspect.slice(1) + ' Score (%)',
                    data: data,
                    backgroundColor: aspectChartColors[aspect].replace('rgb', 'rgba').replace(')', ', 0.2)'),
                    borderColor: aspectChartColors[aspect],
                    borderWidth: 3,
                    pointBackgroundColor: aspectChartColors[aspect],
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 6,
                    pointHoverRadius: 8,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,
                        ticks: {
                            callback: function(value) {
                                return value + '%';
                            },
                            stepSize: 20
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.1)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.dataset.label + ': ' + context.parsed.y.toFixed(1) + '%';
                            }
                        }
                    }
                }
            }
        });
    });
    
    // 5. Mini Line Charts for Each Aspect per Indicator (Question Performance)
    const questionScores = {!! $questionScoresJson !!};
    
    for (let i = 1; i <= 6; i++) {
        aspects.forEach(aspect => {
            const scores = questionScores[i][aspect] || [];
            if (scores.length === 0) return; // Skip if no data
            
            const labels = scores.map((_, index) => 'Q' + (index + 1));
            const percentages = scores.map(score => score * 20); // Convert 0-5 to percentage
            
            const canvasId = 'chart_' + i + '_' + aspect;
            const canvas = document.getElementById(canvasId);
            if (!canvas) return; // Skip if canvas doesn't exist
            
            const ctx = canvas.getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Score (%)',
                        data: percentages,
                        backgroundColor: aspectChartColors[aspect].replace('rgb', 'rgba').replace(')', ', 0.3)'),
                        borderColor: aspectChartColors[aspect],
                        borderWidth: 2,
                        pointBackgroundColor: aspectChartColors[aspect],
                        pointBorderColor: '#fff',
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        fill: true,
                        tension: 0.3
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 100,
                            ticks: {
                                callback: function(value) {
                                    return value + '%';
                                },
                                stepSize: 25,
                                font: {
                                    size: 10
                                }
                            },
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)'
                            }
                        },
                        x: {
                            ticks: {
                                font: {
                                    size: 9
                                }
                            },
                            grid: {
                                display: false
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const score = scores[context.dataIndex];
                                    return 'Score: ' + score + '/5 (' + context.parsed.y.toFixed(1) + '%)';
                                }
                            }
                        }
                    }
                }
            });
        });
    }
});
</script>
@endsection
