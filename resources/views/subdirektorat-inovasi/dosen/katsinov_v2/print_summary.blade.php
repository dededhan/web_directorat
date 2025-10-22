<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Summary Report - {{ $katsinov->title }}</title>
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Arial', sans-serif;
            font-size: 11pt;
            line-height: 1.4;
            color: #333;
            background: white;
        }
        
        .container {
            max-width: 210mm;
            margin: 0 auto;
            padding: 15mm;
        }
        
        /* Header */
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 3px solid #277177;
            padding-bottom: 15px;
        }
        
        .header h1 {
            font-size: 20pt;
            color: #277177;
            margin-bottom: 5px;
        }
        
        .header h2 {
            font-size: 14pt;
            color: #555;
            font-weight: normal;
        }
        
        /* Innovation Details */
        .innovation-details {
            background: #f8f9fa;
            border: 2px solid #277177;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
        }
        
        .innovation-details h3 {
            color: #277177;
            margin-bottom: 10px;
            font-size: 14pt;
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }
        
        .info-item {
            margin-bottom: 8px;
        }
        
        .info-item strong {
            color: #277177;
            display: block;
            margin-bottom: 2px;
        }
        
        /* Overall Score */
        .overall-score {
            background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
            border: 2px solid #2196F3;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            margin-bottom: 20px;
        }
        
        .overall-score h3 {
            font-size: 12pt;
            color: #555;
            margin-bottom: 10px;
        }
        
        .score-display {
            font-size: 36pt;
            font-weight: bold;
            margin: 10px 0;
        }
        
        .score-display.excellent {
            color: #4caf50;
        }
        
        .score-display.good {
            color: #ff9800;
        }
        
        .score-display.poor {
            color: #f44336;
        }
        
        .status-badge {
            display: inline-block;
            padding: 8px 20px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 11pt;
        }
        
        .status-badge.excellent {
            background: #4caf50;
            color: white;
        }
        
        .status-badge.good {
            background: #ff9800;
            color: white;
        }
        
        .status-badge.poor {
            background: #f44336;
            color: white;
        }
        
        /* Tables */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        table th {
            background: #277177;
            color: white;
            padding: 10px;
            text-align: left;
            font-size: 10pt;
        }
        
        table td {
            padding: 8px 10px;
            border-bottom: 1px solid #ddd;
            font-size: 10pt;
        }
        
        table tr:nth-child(even) {
            background: #f8f9fa;
        }
        
        /* Indicator Section */
        .indicator-section {
            margin-bottom: 25px;
            page-break-inside: avoid;
        }
        
        .indicator-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 12px 15px;
            border-radius: 8px 8px 0 0;
            font-size: 12pt;
            font-weight: bold;
        }
        
        .indicator-body {
            border: 2px solid #667eea;
            border-top: none;
            border-radius: 0 0 8px 8px;
            padding: 15px;
        }
        
        /* Aspect Cards */
        .aspect-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-top: 15px;
        }
        
        .aspect-card {
            border: 1px solid #ddd;
            border-radius: 6px;
            padding: 10px;
            page-break-inside: avoid;
        }
        
        .aspect-card-header {
            border-left: 4px solid;
            padding-left: 10px;
            margin-bottom: 8px;
        }
        
        .aspect-card-header h4 {
            font-size: 11pt;
            margin-bottom: 3px;
        }
        
        .aspect-card-header .score {
            font-weight: bold;
            font-size: 10pt;
        }
        
        .question-list {
            list-style: none;
            margin-top: 8px;
        }
        
        .question-item {
            margin-bottom: 6px;
            font-size: 9pt;
        }
        
        .progress-bar {
            height: 6px;
            background: #e0e0e0;
            border-radius: 3px;
            overflow: hidden;
            margin: 3px 0;
        }
        
        .progress-fill {
            height: 100%;
            border-radius: 3px;
        }
        
        /* Colors */
        .text-success { color: #4caf50; }
        .text-warning { color: #ff9800; }
        .text-danger { color: #f44336; }
        
        .bg-success { background: #4caf50; }
        .bg-warning { background: #ff9800; }
        .bg-danger { background: #f44336; }
        
        /* Chart Container */
        .chart-container {
            position: relative;
            margin: 15px auto;
            page-break-inside: avoid;
        }
        
        .chart-wrapper {
            background: white;
            padding: 15px;
            border-radius: 8px;
            border: 1px solid #ddd;
        }
        
        .chart-title {
            text-align: center;
            font-size: 11pt;
            font-weight: bold;
            color: #277177;
            margin-bottom: 10px;
        }
        
        /* Print Styles */
        @media print {
            body {
                margin: 0;
                padding: 0;
            }
            
            .container {
                max-width: 100%;
                padding: 10mm;
            }
            
            .page-break {
                page-break-before: always;
            }
            
            .no-print {
                display: none;
            }
            
            .indicator-section {
                page-break-inside: avoid;
            }
            
            .chart-container {
                page-break-inside: avoid;
            }
        }
        
        /* Footer */
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 15px;
            border-top: 2px solid #277177;
            font-size: 9pt;
            color: #666;
        }
    </style>
</head>
<body>
    {{-- Print Control Buttons - Hidden when printing --}}
    <div class="print-controls no-print" style="position: fixed; top: 20px; right: 20px; z-index: 1000; display: flex; gap: 10px;">
        <button onclick="window.print()" style="padding: 10px 20px; background: #0d6efd; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 14px; font-weight: 600; box-shadow: 0 2px 4px rgba(0,0,0,0.2);">
            <i style="margin-right: 5px;">🖨️</i> Print / Download PDF
        </button>
        <button onclick="window.close()" style="padding: 10px 20px; background: #6c757d; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 14px; font-weight: 600; box-shadow: 0 2px 4px rgba(0,0,0,0.2);">
            <i style="margin-right: 5px;">✖️</i> Close
        </button>
    </div>
    
    <div class="container">
        {{-- Header --}}
        <div class="header">
            <h1>LAPORAN SUMMARY PENILAIAN KATSINOV</h1>
            <h2>Universitas Negeri Jakarta</h2>
        </div>
        
        {{-- Innovation Details --}}
        <div class="innovation-details">
            <h3>Detail Inovasi</h3>
            <div class="info-grid">
                <div>
                    <div class="info-item">
                        <strong>Judul Inovasi:</strong>
                        {{ $katsinov->title }}
                    </div>
                    <div class="info-item">
                        <strong>Fokus Area:</strong>
                        {{ $katsinov->focus_area }}
                    </div>
                    <div class="info-item">
                        <strong>Institusi:</strong>
                        {{ $katsinov->institution ?? 'Universitas Negeri Jakarta' }}
                    </div>
                </div>
                <div>
                    <div class="info-item">
                        <strong>Tanggal Penilaian:</strong>
                        {{ \Carbon\Carbon::parse($katsinov->created_at)->format('d F Y') }}
                    </div>
                    <div class="info-item">
                        <strong>Status:</strong>
                        {{ ucfirst($katsinov->status) }}
                    </div>
                    @if($katsinov->reviewer)
                    <div class="info-item">
                        <strong>Reviewer:</strong>
                        {{ $katsinov->reviewer->name }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
        
        {{-- Overall Score --}}
        @php
            $avgScore = $overallAverage;
            $statusClass = $avgScore >= 80 ? 'excellent' : ($avgScore >= 60 ? 'good' : 'poor');
            $statusText = $avgScore >= 80 ? 'LAYAK UNTUK DIKEMBANGKAN' : ($avgScore >= 60 ? 'CUKUP LAYAK - PERLU PERBAIKAN' : 'TIDAK LAYAK - PERLU REVISI BESAR');
        @endphp
        
        
        
        {{-- Overall Aspect Charts --}}
        <div class="page-break"></div>
        
        <h3 style="color: #277177; margin-bottom: 15px; text-align: center;">Visualisasi Skor Aspek</h3>
        
        {{-- Bar Chart --}}
        <div class="chart-wrapper" style="margin-bottom: 20px;">
            <div class="chart-title">Skor Keseluruhan Per Aspek (Bar Chart)</div>
            <div class="chart-container" style="height: 400px;">
                <canvas id="overallBarChart"></canvas>
            </div>
        </div>
        
        {{-- Radar Chart --}}
        <div class="chart-wrapper" style="margin-bottom: 20px;">
            <div class="chart-title">Skor Keseluruhan Per Aspek (Radar Chart)</div>
            <div class="chart-container" style="height: 400px;">
                <canvas id="overallRadarChart"></canvas>
            </div>
        </div>
        
        {{-- Overall Aspect Scores --}}
        <h3 style="color: #277177; margin-bottom: 10px;">Skor Per Aspek (Keseluruhan)</h3>
        <table>
            <thead>
                <tr>
                    <th>Aspek</th>
                    <th width="20%" style="text-align: center;">Skor</th>
                    <th width="20%" style="text-align: center;">Status</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $aspectNames = [
                        'technology' => ['label' => 'Technology (T)', 'icon' => '⚙️'],
                        'market' => ['label' => 'Market (M)', 'icon' => '📊'],
                        'organization' => ['label' => 'Organization (O)', 'icon' => '🏢'],
                        'manufacturing' => ['label' => 'Manufacturing (Mf)', 'icon' => '🏭'],
                        'partnership' => ['label' => 'Partnership (P)', 'icon' => '🤝'],
                        'investment' => ['label' => 'Investment (I)', 'icon' => '💰'],
                        'risk' => ['label' => 'Risk (R)', 'icon' => '⚠️'],
                    ];
                @endphp
                @foreach($aspectNames as $key => $info)
                    @php
                        $score = $overallAspectScores[$key] ?? 0;
                        $statusClass = $score >= 80 ? 'text-success' : ($score >= 60 ? 'text-warning' : 'text-danger');
                        $statusText = $score >= 80 ? 'Ready' : ($score >= 60 ? 'Developing' : 'Needs Review');
                    @endphp
                    <tr>
                        <td>{{ $info['icon'] }} <strong>{{ $info['label'] }}</strong></td>
                        <td style="text-align: center;"><strong class="{{ $statusClass }}">{{ number_format($score, 1) }}%</strong></td>
                        <td style="text-align: center;">{{ $statusText }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
        {{-- Page Break --}}
        <div class="page-break"></div>
        
        {{-- Detailed Indicators --}}
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
        
        @foreach($indicatorScores as $index => $data)
            <div class="indicator-section">
                <div class="indicator-header">
                    KATSINOV {{ $index }}: {{ $indicatorTitles[$index] }}
                </div>
                <div class="indicator-body">
                    {{-- Charts Row: Spider Chart + Bar Chart --}}
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                        <div class="chart-wrapper">
                            <div class="chart-title">Spider Chart - KATSINOV {{ $index }}</div>
                            <div class="chart-container" style="height: 350px;">
                                <canvas id="indicator{{ $index }}SpiderChart"></canvas>
                            </div>
                        </div>
                        <div class="chart-wrapper">
                            <div class="chart-title">Bar Chart - KATSINOV {{ $index }}</div>
                            <div class="chart-container" style="height: 350px;">
                                <canvas id="indicator{{ $index }}BarChart"></canvas>
                            </div>
                        </div>
                    </div>
                    
                    {{-- Aspect Summary Table --}}
                    <h4 style="margin-bottom: 10px;">Ringkasan Aspek</h4>
                    <table>
                        <thead>
                            <tr>
                                <th>Aspek</th>
                                <th width="20%" style="text-align: center;">Skor</th>
                                <th width="20%" style="text-align: center;">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($aspectNames as $key => $info)
                                @php
                                    $score = $indicatorAspectScores[$index][$key] ?? 0;
                                    $statusClass = $score >= 80 ? 'text-success' : ($score >= 60 ? 'text-warning' : 'text-danger');
                                    $statusText = $score >= 80 ? 'Ready' : ($score >= 60 ? 'Developing' : 'Needs Review');
                                @endphp
                                <tr>
                                    <td>{{ $info['icon'] }} <strong>{{ $info['label'] }}</strong></td>
                                    <td style="text-align: center;"><strong class="{{ $statusClass }}">{{ number_format($score, 1) }}%</strong></td>
                                    <td style="text-align: center;">{{ $statusText }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    
                    {{-- Detailed Aspects with Questions --}}
                    <h4 style="margin-top: 15px; margin-bottom: 10px;">Detail Per Aspek</h4>
                    <div class="aspect-grid">
                        @foreach($aspectNames as $aspectKey => $aspectInfo)
                            @php
                                $aspectQuestions = $questionScores[$index][$aspectKey] ?? [];
                                if (empty($aspectQuestions)) continue;
                                
                                $aspectScore = $indicatorAspectScores[$index][$aspectKey] ?? 0;
                                $statusClass = $aspectScore >= 80 ? 'text-success' : ($aspectScore >= 60 ? 'text-warning' : 'text-danger');
                                $borderColor = $aspectScore >= 80 ? '#4caf50' : ($aspectScore >= 60 ? '#ff9800' : '#f44336');
                            @endphp
                            
                            <div class="aspect-card">
                                <div class="aspect-card-header" style="border-color: {{ $borderColor }};">
                                    <h4>{{ $aspectInfo['icon'] }} {{ $aspectInfo['label'] }}</h4>
                                    <div class="score {{ $statusClass }}">
                                        Overall: {{ number_format($aspectScore, 1) }}% 
                                        ({{ $aspectScore >= 80 ? 'Ready' : ($aspectScore >= 60 ? 'Developing' : 'Needs Review') }})
                                    </div>
                                </div>
                                
                                {{-- Mini Line Chart for Questions --}}
                                <div class="chart-container" style="height: 120px; margin: 10px 0;">
                                    <canvas id="chart_{{ $index }}_{{ $aspectKey }}"></canvas>
                                </div>
                                
                                <ul class="question-list">
                                    @foreach($aspectQuestions as $qIndex => $questionScore)
                                        @php
                                            $scorePercent = $questionScore * 20;
                                            $barClass = $scorePercent >= 80 ? 'bg-success' : ($scorePercent >= 60 ? 'bg-warning' : 'bg-danger');
                                            $questionText = $questionTexts[$index][$aspectKey][$qIndex] ?? 'Pertanyaan ' . ($qIndex + 1);
                                        @endphp
                                        <li class="question-item" style="margin-bottom: 10px;">
                                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 3px;">
                                                <span><strong>Q{{ $qIndex + 1 }}</strong></span>
                                                <span><strong>{{ $questionScore }}/5 ({{ $scorePercent }}%)</strong></span>
                                            </div>
                                            <div style="margin-bottom: 3px; font-size: 9pt; color: #444;">
                                                {{ $questionText }}
                                            </div>
                                            <div class="progress-bar">
                                                <div class="progress-fill {{ $barClass }}" style="width: {{ $scorePercent }}%;"></div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            
            @if($index < count($indicatorScores))
                <div class="page-break"></div>
            @endif
        @endforeach
        
        {{-- Footer --}}
        <div class="footer">
            <p>Dokumen ini digenerate secara otomatis oleh Sistem Katsinov V2</p>
            <p>Universitas Negeri Jakarta - Direktorat Riset, Teknologi, dan Inovasi</p>
            <p>Tanggal Cetak: {{ \Carbon\Carbon::now()->format('d F Y, H:i') }} WIB</p>
        </div>
    </div>
    
    {{-- Chart.js Scripts --}}
    <script>
        // Chart Colors
        const aspectColors = [
            'rgb(255, 99, 132)',   // Technology
            'rgb(54, 162, 235)',   // Market
            'rgb(255, 206, 86)',   // Organization
            'rgb(75, 192, 192)',   // Manufacturing
            'rgb(153, 102, 255)',  // Partnership
            'rgb(255, 159, 64)',   // Investment
            'rgb(70, 150, 130)'    // Risk
        ];
        
        const aspectLabels = ['Technology', 'Market', 'Organization', 'Manufacturing', 'Partnership', 'Investment', 'Risk'];
        
        // Parse data from PHP
        const overallAspectScores = {!! json_encode($overallAspectScores) !!};
        const indicatorAspectScores = {!! json_encode($indicatorAspectScores) !!};
        
        // Prepare overall aspect data
        const aspectData = [
            overallAspectScores.technology || 0,
            overallAspectScores.market || 0,
            overallAspectScores.organization || 0,
            overallAspectScores.manufacturing || 0,
            overallAspectScores.partnership || 0,
            overallAspectScores.investment || 0,
            overallAspectScores.risk || 0
        ];
        
        // Wait for DOM and Chart.js to be ready
        document.addEventListener('DOMContentLoaded', function() {
            // 1. Overall Bar Chart
            const barCtx = document.getElementById('overallBarChart');
            if (barCtx) {
                new Chart(barCtx.getContext('2d'), {
                    type: 'bar',
                    data: {
                        labels: aspectLabels,
                        datasets: [{
                            label: 'Skor Aspek (%)',
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
            }
            
            // 2. Overall Radar Chart
            const radarCtx = document.getElementById('overallRadarChart');
            if (radarCtx) {
                new Chart(radarCtx.getContext('2d'), {
                    type: 'radar',
                    data: {
                        labels: aspectLabels,
                        datasets: [{
                            label: 'Skor Aspek (%)',
                            data: aspectData,
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            borderColor: 'rgb(54, 162, 235)',
                            borderWidth: 2,
                            pointBackgroundColor: 'rgb(54, 162, 235)',
                            pointBorderColor: '#fff',
                            pointHoverBackgroundColor: '#fff',
                            pointHoverBorderColor: 'rgb(54, 162, 235)',
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
                                    }
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
                                        return context.dataset.label + ': ' + context.parsed.r.toFixed(1) + '%';
                                    }
                                }
                            }
                        }
                    }
                });
            }
            
            // 3. Spider Charts for Each Indicator
            for (let i = 1; i <= 6; i++) {
                const indicatorData = [
                    indicatorAspectScores[i].technology || 0,
                    indicatorAspectScores[i].market || 0,
                    indicatorAspectScores[i].organization || 0,
                    indicatorAspectScores[i].manufacturing || 0,
                    indicatorAspectScores[i].partnership || 0,
                    indicatorAspectScores[i].investment || 0,
                    indicatorAspectScores[i].risk || 0
                ];
                
                const ctx = document.getElementById('indicator' + i + 'SpiderChart');
                if (ctx) {
                    new Chart(ctx.getContext('2d'), {
                        type: 'radar',
                        data: {
                            labels: aspectLabels,
                            datasets: [{
                                label: 'Indikator ' + i + ' (%)',
                                data: indicatorData,
                                backgroundColor: 'rgba(102, 126, 234, 0.2)',
                                borderColor: 'rgb(102, 126, 234)',
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
                                        }
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
                }
                
                // Create Bar Chart for this indicator
                const barCtx = document.getElementById('indicator' + i + 'BarChart');
                if (barCtx) {
                    new Chart(barCtx.getContext('2d'), {
                        type: 'bar',
                        data: {
                            labels: aspectLabels,
                            datasets: [{
                                label: 'Indikator ' + i + ' (%)',
                                data: indicatorData,
                                backgroundColor: aspectColors.map(color => color.replace('rgb', 'rgba').replace(')', ', 0.7)')),
                                borderColor: aspectColors,
                                borderWidth: 2,
                                borderRadius: 5
                            }]
                        },
                        options: {
                            indexAxis: 'y',
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
            
            // 4. Mini Line Charts for Each Aspect per Indicator (Question Performance)
            const questionScores = {!! $questionScoresJson !!};
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
            
            for (let i = 1; i <= 6; i++) {
                aspects.forEach(aspect => {
                    const scores = questionScores[i][aspect] || [];
                    if (scores.length === 0) return;
                    
                    const labels = scores.map((_, index) => 'Q' + (index + 1));
                    const percentages = scores.map(score => score * 20);
                    
                    const canvasId = 'chart_' + i + '_' + aspect;
                    const canvas = document.getElementById(canvasId);
                    if (!canvas) return;
                    
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
                                pointRadius: 3,
                                pointHoverRadius: 5,
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
                                        stepSize: 25
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
                                    display: false
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            return 'Score: ' + context.parsed.y.toFixed(1) + '%';
                                        }
                                    }
                                }
                            }
                        }
                    });
                });
            }
            
            // Charts rendered - ready for printing
            // Auto-print removed - user can click Print button manually
        });
    </script>
</body>
</html>

