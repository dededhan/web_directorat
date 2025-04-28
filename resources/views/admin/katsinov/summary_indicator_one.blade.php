@extends('admin.admin')

@section('contentadmin')
<!-- CSS Files -->
<link href="{{ asset('aspect-analysis.css') }}" rel="stylesheet">

<!-- Charts JS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="head-title">
    <div class="left">
        <h1>KATSINOV Indicator 1 Summary</h1>
        <ul class="breadcrumb">
            <li>
                <a href="#">Dashboard</a>
            </li>
            <li><i class='bx bx-chevron-right'></i></li>
            <li>
                <a href="{{ route('admin.katsinov.TableKatsinov') }}">KATSINOV Data</a>
            </li>
            <li><i class='bx bx-chevron-right'></i></li>
            <li>
                <a class="active" href="#">Indicator 1 Summary</a>
            </li>
        </ul>
    </div>
</div>

<div class="table-data">
    <div class="order">
        <div class="head">
            <h3>Innovation Summary for: {{ $katsinov->title }}</h3>
        </div>

        <!-- Basic Information Card -->
        <div class="card mb-4">
            <div class="card-header" style="background-color: #277177; color: white;">
                <h4 class="m-0">Innovation Details</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Project Name:</strong> {{ $katsinov->project_name }}</p>
                        <p><strong>Focus Area:</strong> {{ $katsinov->focus_area }}</p>
                        <p><strong>Institution:</strong> {{ $katsinov->institution }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Assessment Date:</strong> {{ \Carbon\Carbon::parse($katsinov->assessment_date)->format('d M Y') }}</p>
                        <p><strong>Status:</strong> 
                            @php
                                $avgScore = array_sum(array_values($aspectScores)) / count($aspectScores);
                            @endphp
                            <span class="badge {{ $avgScore >= 80 ? 'bg-success' : ($avgScore >= 60 ? 'bg-warning' : 'bg-danger') }}">
                                {{ $avgScore >= 80 ? 'Ready' : ($avgScore >= 60 ? 'Developing' : 'Needs Review') }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Overall Aspect Performance Card -->
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center" style="background-color: #277177; color: white;">
                <h4 class="m-0">Indicator 1 - Overall Aspect Performance</h4>
                <div class="btn-group">
                    <button class="btn btn-sm btn-light active" id="showBarChart">Bar Chart</button>
                    <button class="btn btn-sm btn-light" id="showRadarChart">Radar Chart</button>
                </div>
            </div>
            <div class="card-body">
                <div class="chart-container position-relative" style="height:400px;">
                    <canvas id="overallChart"></canvas>
                    <canvas id="radarChart" style="display:none;"></canvas>
                </div>
            </div>
        </div>

        <!-- Aspect Details Grid -->
        <div class="card mb-4">
            <div class="card-header" style="background-color: #277177; color: white;">
                <h4 class="m-0">Aspect Details</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    @php
                        $aspectDetails = [
                            'technology' => [
                                'name' => 'Technology (T)',
                                'color' => 'rgb(255, 99, 132)',
                                'icon' => 'bx-chip',
                                'questions' => [
                                    'Ide baru yang memberi solusi permasalahan masyarakat.',
                                    'Telah dilakukan pengamatan prinsip-prinsip ilmiah dasar dan publikasi ilmiah.',
                                    'Faktor yang membedakan temuan dengan temuan lain dan unsur kebaruan dari sebuah ide atau gagasan telah diidentifikasi.',
                                    'Mengidentifikasi tahapan riset dan targetnya.',
                                    'Teknologi yang akan dikembangkan telah layak secara ilmiah (scientific feasibility).'
                                ]
                            ],
                            'market' => [
                                'name' => 'Market (M)',
                                'color' => 'rgb(54, 162, 235)',
                                'icon' => 'bx-store',
                                'questions' => [
                                    'Inovasi dilakukan berdasarkan permintaan dan/atau kebutuhan pelanggan.',
                                    'Permintaan dan kebutuhan pelanggan telah diidentifikasi.',
                                    'Telah mengidentifikasikan lokasi pasar yang akan dituju.'
                                ]
                            ],
                            'organization' => [
                                'name' => 'Organization (O)',
                                'color' => 'rgb(255, 206, 86)',
                                'icon' => 'bx-building',
                                'questions' => [
                                    'Telah memiliki strategi inovasi.',
                                    'Lingkup proyek dan tugas telah diidentifikasi.',
                                    'Kebutuhan akan sumber daya, dana dan fasilitas penelitian telah dikonfirmasi.',
                                    'Tersedia saluran komunikasi tanpa hambatan.'
                                ]
                            ],
                            'manufacturing' => [
                                'name' => 'Manufacturing (Mf)',
                                'color' => 'rgb(75, 192, 192)',
                                'icon' => 'bx-factory',
                                'questions' => [
                                    'Konsekuensi hasil temuan telah diidentifikasi melalui dasar manufaktur ekonomis.',
                                    'Tersedia bukti konsep manufaktur melalui analitik atau eksperimen laboratorium.',
                                    'Ide yang dikembangkan memiliki konsep model bisnis.'
                                ]
                            ],
                            'partnership' => [
                                'name' => 'Partnership (P)',
                                'color' => 'rgb(153, 102, 255)',
                                'icon' => 'bx-handshake',
                                'questions' => [
                                    'Mitra potensial telah diidentifikasi.',
                                    'Kajian risiko teknologi telah menjadi pertimbangan dalam setiap langkah penelitian.'
                                ]
                            ],
                            'investment' => [
                                'name' => 'Investment (I)',
                                'color' => 'rgb(255, 159, 64)',
                                'icon' => 'bx-money',
                                'questions' => [
                                    'Ide yang dikembangkan memiliki hasil analisis pelanggan, pasar, dan pesaing.',
                                    'Ide yang dikembangkan telah terbukti memberi solusi bagi pelanggan.',
                                    'Telah tersusun strategi membangun jaringan kerja dan kemitraan.'
                                ]
                            ],
                            'risk' => [
                                'name' => 'Risk (R)',
                                'color' => 'rgb(70, 150, 130)', // Emerald green
                                'icon' => 'bx-error-circle',
                                'questions' => [
                                    'Pada tahap penelitian dilakukan penyusunan rencana pengendalian risiko teknologi.'
                                ]
                            ]
                        ];
                    @endphp

                    @foreach($aspectDetails as $key => $aspect)
                    <div class="col-md-6 mb-4">
                        <div class="card h-100 border-0 shadow-sm aspect-card">
                            <div class="card-header" style="background-color: {{ $aspect['color'] }}40; border-left: 5px solid {{ $aspect['color'] }};">
                                <div class="d-flex align-items-center">
                                    <i class='bx {{ $aspect['icon'] }} fs-3 me-2'></i>
                                    <h5 class="m-0">{{ $aspect['name'] }}</h5>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-5">
                                        <!-- Line chart for per-question scores -->
                                        <div class="aspect-score-chart mb-3">
                                            <canvas id="lineChart_{{ $key }}"></canvas>
                                        </div>
                                        <div class="aspect-status text-center">
                                            <h6>Status:</h6>
                                            <span class="badge {{ $aspectScores[$key] >= 80 ? 'bg-success' : ($aspectScores[$key] >= 60 ? 'bg-warning' : 'bg-danger') }} px-3 py-2">
                                                {{ $categories[$key] }}
                                            </span>
                                            <!-- Tambahkan overall score -->
                                            <div class="mt-1">
                                                <small>Overall: {{ number_format($aspectScores[$key], 1) }}%</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-7">
                                        <div class="aspect-questions">
                                            <strong>Pertanyaan Indikator 1:</strong>
                                            <ul class="ps-3 mt-2">
                                                @foreach($aspect['questions'] as $index => $question)
                                                    @php
                                                        // Map the view index to the actual response index based on aspect
                                                        $questionNumber = match($key) {
                                                            'technology' => $index,
                                                            'market' => $index + 5,
                                                            'organization' => $index + 8,
                                                            'manufacturing' => $index + 12,
                                                            'investment' => $index + 15,
                                                            'partnership' => $index + 18,
                                                            'risk' => $index + 20,
                                                            default => $index
                                                        };
                                                        $score = $questionScores[$key][$questionNumber] ?? 0;
                                                        $scorePercent = $score * 20; // Convert 0-5 to percentage
                                                    @endphp
                                                    <li class="mb-1 small">
                                                        {{ $question }}
                                                        <div class="mt-1">
                                                            <div class="progress" style="height: 8px;">
                                                                <div class="progress-bar" role="progressbar" 
                                                                    style="width: {{ $scorePercent }}%; background-color: {{ $aspect['color'] }};" 
                                                                    aria-valuenow="{{ $scorePercent }}" aria-valuemin="0" aria-valuemax="100">
                                                                </div>
                                                            </div>
                                                            <div class="d-flex justify-content-between mt-1">
                                                                <small class="text-muted">Score: {{ $score }}/5</small>
                                                                <small class="text-muted">{{ $scorePercent }}%</small>
                                                            </div>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Catatan Section -->
        <div class="card mb-4">
            <div class="card-header" style="background-color: #277177; color: white;">
                <h4 class="m-0">Catatan</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <h5>Indicator 1 Analysis</h5>
                        <p>The assessment of <strong>{{ $katsinov->title }}</strong> for Indicator 1 reveals the following insights:</p>
                        
                        <ul>
                            @php
                                $strengths = [];
                                $weaknesses = [];
                                
                                foreach($aspectScores as $key => $score) {
                                    if($score >= 80) {
                                        $strengths[] = $aspectDetails[$key]['name'];
                                    }
                                    if($score < 60) {
                                        $weaknesses[] = $aspectDetails[$key]['name'];
                                    }
                                }
                            @endphp
                            
                            @if(count($strengths) > 0)
                            <li>
                                <strong>Strengths:</strong> 
                                {{ implode(', ', $strengths) }} 
                                {{ count($strengths) > 1 ? 'are showing excellent readiness' : 'is showing excellent readiness' }}
                            </li>
                            @endif
                            
                            @if(count($weaknesses) > 0)
                            <li>
                                <strong>Areas for improvement:</strong> 
                                {{ implode(', ', $weaknesses) }}
                                {{ count($weaknesses) > 1 ? 'need' : 'needs' }} further development
                            </li>
                            @endif
                            
                            <li>
                                <strong>Overall readiness:</strong> 
                                @if($avgScore >= 80)
                                    This innovation shows strong overall readiness in Indicator 1, suggesting it has a solid foundation.
                                @elseif($avgScore >= 60)
                                    This innovation shows moderate readiness in Indicator 1, with some aspects requiring improvement.
                                @else
                                    This innovation requires significant development in Indicator 1 fundamentals before proceeding.
                                @endif
                            </li>
                        </ul>
                        
                        <h5 class="mt-4">Additional Notes</h5>
                        <div class="recommendations">
                            <div class="form-group">
                                <textarea id="notesText" class="form-control" rows="5">Based on the Indicator 1 assessment, focus on improving the following aspects: {{ implode(', ', $weaknesses) }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Style for line charts */
    .aspect-score-chart {
        width: 100%;
        height: 120px;
        display: block;
        position: relative;
        background: white;
        border-radius: 4px;
        box-shadow: 0 2px 4px rgba(0, 253, 240, 0.05);
    }
    
    .aspect-card {
        transition: transform 0.3s ease;
    }
    
    .aspect-card:hover {
        transform: translateY(-5px);
    }
    
    .card-header {
        padding: 0.75rem 1.25rem;
    }
    
    .badge {
        font-size: 0.9rem;
    }
    
    /* Progress bars for individual questions */
    .progress {
        height: 8px;
        border-radius: 4px;
        background-color: #f1f1f1;
    }
    
    .progress-bar {
        border-radius: 4px;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .aspect-score-chart {
            height: 100px;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Chart.js setup for main charts
    const ctx = document.getElementById('overallChart').getContext('2d');
    const radarCtx = document.getElementById('radarChart').getContext('2d');
    
    // Data preparation
    const aspectLabels = [
        'Technology (T)', 'Market (M)', 'Organization (O)', 
        'Manufacturing (Mf)', 'Partnership (P)', 'Investment (I)', 'Risk (R)'
    ];
    
    const aspectColors = [
        'rgb(255, 99, 132)', 'rgb(54, 162, 235)', 'rgb(255, 206, 86)',
        'rgb(75, 192, 192)', 'rgb(153, 102, 255)', 'rgb(255, 159, 64)', 
        'rgb(70, 150, 130)' // Emerald green for Risk
    ];
    
    const aspectData = [
        {{ $aspectScores['technology'] }}, 
        {{ $aspectScores['market'] }}, 
        {{ $aspectScores['organization'] }},
        {{ $aspectScores['manufacturing'] }}, 
        {{ $aspectScores['partnership'] }}, 
        {{ $aspectScores['investment'] }}, 
        {{ $aspectScores['risk'] }}
    ];
    
    // Create bar chart
    const barChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: aspectLabels,
            datasets: [{
                label: 'Aspect Score (%)',
                data: aspectData,
                backgroundColor: aspectColors.map(color => color + '80'),
                borderColor: aspectColors,
                borderWidth: 1
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
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.parsed.y.toFixed(1) + '%';
                        }
                    }
                }
            }
        }
    });
    
    // Create radar chart
    const radarChart = new Chart(radarCtx, {
        type: 'radar',
        data: {
            labels: aspectLabels,
            datasets: [{
                label: 'Aspect Score (%)',
                data: aspectData,
                backgroundColor: 'rgba(39, 113, 119, 0.2)',
                borderColor: 'rgb(39, 113, 119)',
                pointBackgroundColor: aspectColors,
                pointBorderColor: '#fff',
                pointHoverBackgroundColor: '#fff',
                pointHoverBorderColor: aspectColors
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
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.raw.toFixed(1) + '%';
                        }
                    }
                }
            }
        }
    });
    
    // Chart toggle functionality
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
    
    // Define mapping for per-question scores with correct indices
    const aspectQuestionMapping = {
        'technology': {
            indices: [0, 1, 2, 3, 4],
            color: 'rgb(255, 99, 132)'
        },
        'market': {
            indices: [5, 6, 7],
            color: 'rgb(54, 162, 235)'
        },
        'organization': {
            indices: [8, 9, 10, 11],
            color: 'rgb(255, 206, 86)'
        },
        'manufacturing': {
            indices: [12, 13, 14],
            color: 'rgb(75, 192, 192)'
        },
        'partnership': {
            indices: [18, 19],
            color: 'rgb(153, 102, 255)'
        },
        'investment': {
            indices: [15, 16, 17],
            color: 'rgb(255, 159, 64)'
        },
        'risk': {
            indices: [20],
            color: 'rgb(70, 150, 130)' // Emerald green for Risk
        }
    };
    
    // Get question scores from PHP
    const questionScores = {
        @foreach($aspectDetails as $key => $aspect)
        '{{ $key }}': {
            @foreach($aspect['questions'] as $index => $question)
                @php
                    // Map the view index to the actual response index based on aspect
                    $questionNumber = match($key) {
                        'technology' => $index,
                        'market' => $index + 5,
                        'organization' => $index + 8,
                        'manufacturing' => $index + 12,
                        'investment' => $index + 15,
                        'partnership' => $index + 18,
                        'risk' => $index + 20,
                        default => $index
                    };
                @endphp
                {{ $questionNumber }}: {{ $questionScores[$key][$questionNumber] ?? 0 }}{{ !$loop->last ? ',' : '' }}
            @endforeach
        }{{ !$loop->last ? ',' : '' }}
        @endforeach
    };
    
    // Create individual line charts for each aspect
    Object.keys(aspectQuestionMapping).forEach(key => {
        const chartElement = document.getElementById(`lineChart_${key}`);
        if (!chartElement) return;
        
        const ctx = chartElement.getContext('2d');
        const mapping = aspectQuestionMapping[key];
        
        // Penanganan khusus untuk aspek risk yang hanya memiliki 1 pertanyaan
        if (key === 'risk') {
            // Untuk aspek dengan 1 pertanyaan, gunakan bar chart
            const riskScore = questionScores['risk'][20] || 0;
            const riskScorePercent = riskScore * 20;
            
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Risk Assessment'],
                    datasets: [{
                        label: 'Risk Score',
                        data: [riskScorePercent],
                        backgroundColor: 'rgba(70, 150, 130, 0.7)', // Emerald green dengan transparansi
                        borderColor: 'rgb(70, 150, 130)', // Emerald green solid
                        borderWidth: 1
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
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const value = context.parsed.y;
                                    const rawScore = value / 20; // Convert percentage back to 0-5 score
                                    return `Score: ${rawScore}/5 (${value.toFixed(0)}%)`;
                                }
                            }
                        }
                    }
                }
            });
        } else {
            // Untuk aspek dengan multiple pertanyaan, gunakan line chart seperti biasa
            // Prepare data for the chart
            const labels = mapping.indices.map(index => `Q${index + 1}`);
            const data = mapping.indices.map(index => {
                // Convert scores (0-5) to percentages (0-100%)
                return (questionScores[key][index] || 0) * 20;
            });
            
            // Create the chart
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Question Scores',
                        data: data,
                        borderColor: mapping.color,
                        backgroundColor: mapping.color + '20',
                        borderWidth: 2,
                        pointBackgroundColor: mapping.color,
                        pointRadius: 5,
                        pointHoverRadius: 7,
                        fill: true,
                        tension: 0.1
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
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                title: function(context) {
                                    const index = context[0].dataIndex;
                                    const questionIndex = mapping.indices[index];
                                    return `Question ${questionIndex + 1}`;
                                },
                                label: function(context) {
                                    const value = context.parsed.y;
                                    const rawScore = value / 20; // Convert percentage back to 0-5 score
                                    return `Score: ${rawScore}/5 (${value.toFixed(0)}%)`;
                                }
                            }
                        }
                    }
                }
            });
        }
    });
});
</script>
@endsection