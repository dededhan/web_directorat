<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Summary Report - {{ $katsinov->title }}</title>
    
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
        
        <div class="overall-score">
            <h3>Skor Keseluruhan</h3>
            <div class="score-display {{ $statusClass }}">
                {{ number_format($avgScore, 1) }}%
            </div>
            <span class="status-badge {{ $statusClass }}">
                @if($avgScore >= 80)
                    ✓ {{ $statusText }}
                @elseif($avgScore >= 60)
                    ⚠ {{ $statusText }}
                @else
                    ✗ {{ $statusText }}
                @endif
            </span>
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
                    Indikator {{ $index }}: {{ $indicatorTitles[$index] }}
                </div>
                <div class="indicator-body">
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
                                
                                <ul class="question-list">
                                    @foreach($aspectQuestions as $qIndex => $questionScore)
                                        @php
                                            $scorePercent = $questionScore * 20;
                                            $barClass = $scorePercent >= 80 ? 'bg-success' : ($scorePercent >= 60 ? 'bg-warning' : 'bg-danger');
                                        @endphp
                                        <li class="question-item">
                                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2px;">
                                                <span><strong>Q{{ $qIndex + 1 }}:</strong></span>
                                                <span><strong>{{ $questionScore }}/5 ({{ $scorePercent }}%)</strong></span>
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
    
    {{-- Auto Print --}}
    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>
