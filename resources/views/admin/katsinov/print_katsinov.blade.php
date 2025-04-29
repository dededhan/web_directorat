<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KATSINOV Detailed Report</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 20px;
            font-size: 12px;
        }

        .page-break {
            page-break-after: always;
        }

        h1 {
            color: #176369;
            font-size: 24px;
            margin-bottom: 20px;
            text-align: center;
            border-bottom: 2px solid #176369;
            padding-bottom: 10px;
        }

        h2 {
            color: #176369;
            font-size: 18px;
            margin-top: 30px;
            margin-bottom: 15px;
            border-left: 5px solid #176369;
            padding-left: 10px;
        }

        h3 {
            color: #333;
            font-size: 16px;
            margin-top: 20px;
            margin-bottom: 10px;
        }

        .header-info {
            background-color: #f5f5f5;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .info-item {
            margin-bottom: 10px;
        }

        .info-label {
            font-weight: bold;
            min-width: 150px;
            display: inline-block;
        }

        .aspect-summary {
            margin-top: 20px;
            margin-bottom: 30px;
        }

        .aspect-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
        }

        .aspect-item {
            background-color: #f9f9f9;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .aspect-item h4 {
            margin: 0 0 5px 0;
            font-size: 14px;
        }

        .aspect-item p {
            margin: 0;
            font-size: 16px;
            font-weight: bold;
            color: #176369;
        }

        .overall {
            grid-column: span 3;
            background-color: #e6f7f8;
            border: 1px solid #176369;
        }

        .chart-container {
            width: 100%;
            height: 300px;
            margin: 20px auto;
            text-align: center;
        }

        .chart-placeholder {
            width: 100%;
            height: 300px;
            background-color: #f0f0f0;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 5px;
        }

        .indicator-section {
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px dashed #ccc;
        }

        .indicator-title {
            background-color: #176369;
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
            margin-bottom: 15px;
            font-size: 16px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
            padding: 8px;
            text-align: left;
        }

        td {
            padding: 8px;
        }

        .status-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 3px;
            font-weight: bold;
            text-align: center;
            color: white;
        }

        .status-success {
            background-color: #28a745;
        }

        .status-warning {
            background-color: #ffc107;
            color: #333;
        }

        .status-danger {
            background-color: #dc3545;
        }

        .score-progress {
            background-color: #e9ecef;
            border-radius: 5px;
            height: 10px;
            overflow: hidden;
            position: relative;
        }

        .score-bar {
            height: 100%;
            background-color: #176369;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
    </style>
</head>

<body>
    <h1>KATSINOV Assessment Report</h1>

    <div class="header-info">
        <div class="info-grid">
            <div class="info-item">
                <span class="info-label">Title:</span> {{ $katsinov->title }}
            </div>
            <div class="info-item">
                <span class="info-label">Project Name:</span> {{ $katsinov->project_name }}
            </div>
            <div class="info-item">
                <span class="info-label">Focus Area:</span> {{ $katsinov->focus_area }}
            </div>
            <div class="info-item">
                <span class="info-label">Institution:</span> {{ $katsinov->institution }}
            </div>
            <div class="info-item">
                <span class="info-label">Assessment Date:</span>
                {{ \Carbon\Carbon::parse($katsinov->assessment_date)->format('d M Y') }}
            </div>
            <div class="info-item">
                <span class="info-label">Status:</span>
                @php
                    $avgScore = array_sum(array_values($aspectScores)) / count($aspectScores);
                    $statusClass =
                        $avgScore >= 80 ? 'status-success' : ($avgScore >= 60 ? 'status-warning' : 'status-danger');
                    $statusText = $avgScore >= 80 ? 'Completed' : ($avgScore >= 60 ? 'Developing' : 'Needs Review');
                @endphp
                <span class="status-badge {{ $statusClass }}">{{ $statusText }}
                    ({{ number_format($avgScore, 1) }}%)</span>
            </div>
        </div>
    </div>

    <h2>Overall Assessment Summary</h2>

    <div class="aspect-summary">
        <div class="aspect-grid">
            <div class="aspect-item">
                <h4>Technology (T)</h4>
                <p>{{ number_format($aspectScores['technology'], 1) }}%</p>
            </div>
            <div class="aspect-item">
                <h4>Organization (O)</h4>
                <p>{{ number_format($aspectScores['organization'], 1) }}%</p>
            </div>
            <div class="aspect-item">
                <h4>Risk (R)</h4>
                <p>{{ number_format($aspectScores['risk'], 1) }}%</p>
            </div>
            <div class="aspect-item">
                <h4>Market (M)</h4>
                <p>{{ number_format($aspectScores['market'], 1) }}%</p>
            </div>
            <div class="aspect-item">
                <h4>Partnership (P)</h4>
                <p>{{ number_format($aspectScores['partnership'], 1) }}%</p>
            </div>
            <div class="aspect-item">
                <h4>Manufacturing (Mf)</h4>
                <p>{{ number_format($aspectScores['manufacturing'], 1) }}%</p>
            </div>
            <div class="aspect-item overall">
                <h4>Investment (I)</h4>
                <p>{{ number_format($aspectScores['investment'], 1) }}%</p>
            </div>
            <div class="aspect-item overall">
                <h4>Overall Average</h4>
                <p>{{ number_format($avgScore, 1) }}%</p>
            </div>
        </div>
    </div>

    <div class="chart-container">
        @if(isset($chartImages['main']))
            <img src="{{ $chartImages['main'] }}" alt="KATSINOV Radar Chart" style="max-width: 100%; height: auto;">
        @else
            <div class="chart-placeholder">
                <p>KATSINOV Radar Chart (Static Image)</p>
            </div>
        @endif
    </div>

    <!-- Page break after summary -->
    <div class="page-break"></div>

    <!-- Indicator 1 -->
    <h2>Indicator 1: Concept Phase</h2>
    <div class="indicator-section">
        <div class="indicator-title">
            Concept Phase Assessment
        </div>

        <div style="display: flex; justify-content: center; margin: 20px 0;">
            @if(isset($chartImages['indicator_1']))
                <img src="{{ $chartImages['indicator_1'] }}" alt="Indicator 1 Chart" style="max-width: 100%; height: auto; max-height: 300px;">
            @else
                <div class="chart-placeholder" style="width: 100%; height: 200px; background-color: #f5f5f5; display: flex; align-items: center; justify-content: center; border-radius: 5px;">
                    <p style="color: #777;">Chart visualization not available</p>
                </div>
            @endif
        </div>

        <h3>Aspect Performance</h3>
        <table>
            <thead>
                <tr>
                    <th>Aspect</th>
                    <th>Score</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($indicatorData[1]['aspectScores'] as $key => $score)
                    <tr>
                        <td>{{ ucfirst($key) }}</td>
                        <td>
                            {{ number_format($score, 1) }}%
                            <div class="score-progress">
                                <div class="score-bar" style="width: {{ $score }}%"></div>
                            </div>
                        </td>
                        <td>
                            @php
                                $statusClass =
                                    $score >= 80
                                        ? 'status-success'
                                        : ($score >= 60
                                            ? 'status-warning'
                                            : 'status-danger');
                                $statusText = $score >= 80 ? 'Ready' : ($score >= 60 ? 'Developing' : 'Needs Review');
                            @endphp
                            <span class="status-badge {{ $statusClass }}">{{ $statusText }}</span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>

    <!-- Page break after Indicator 1 -->
    <div class="page-break"></div>

    <!-- Indicator 2 -->
    <h2>Indicator 2: Component Phase</h2>
    <div class="indicator-section">
        <div class="indicator-title">
            Component Phase Assessment
        </div>

        <div style="display: flex; justify-content: center; margin: 20px 0;">
            @if(isset($chartImages['indicator_2']))
                <img src="{{ $chartImages['indicator_2'] }}" alt="Indicator 2 Chart" style="max-width: 100%; height: auto; max-height: 300px;">
            @else
                <div class="chart-placeholder" style="width: 100%; height: 200px; background-color: #f5f5f5; display: flex; align-items: center; justify-content: center; border-radius: 5px;">
                    <p style="color: #777;">Chart visualization not available</p>
                </div>
            @endif
        </div>

        <h3>Aspect Performance</h3>
        <table>
            <thead>
                <tr>
                    <th>Aspect</th>
                    <th>Score</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($indicatorData[2]['aspectScores'] as $key => $score)
                    <tr>
                        <td>{{ ucfirst($key) }}</td>
                        <td>
                            {{ number_format($score, 1) }}%
                            <div class="score-progress">
                                <div class="score-bar" style="width: {{ $score }}%"></div>
                            </div>
                        </td>
                        <td>
                            @php
                                $statusClass =
                                    $score >= 80
                                        ? 'status-success'
                                        : ($score >= 60
                                            ? 'status-warning'
                                            : 'status-danger');
                                $statusText = $score >= 80 ? 'Ready' : ($score >= 60 ? 'Developing' : 'Needs Review');
                            @endphp
                            <span class="status-badge {{ $statusClass }}">{{ $statusText }}</span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
    </div>

    <!-- Page break after Indicator 2 -->
    <div class="page-break"></div>

    <!-- Indicator 3 -->
    <h2>Indicator 3: Completion Phase</h2>
    <div class="indicator-section">
        <div class="indicator-title">
            Completion Phase Assessment
        </div>

        <div style="display: flex; justify-content: center; margin: 20px 0;">
            @if(isset($chartImages['indicator_3']))
                <img src="{{ $chartImages['indicator_3'] }}" alt="Indicator 3 Chart" style="max-width: 100%; height: auto; max-height: 300px;">
            @else
                <div class="chart-placeholder" style="width: 100%; height: 200px; background-color: #f5f5f5; display: flex; align-items: center; justify-content: center; border-radius: 5px;">
                    <p style="color: #777;">Chart visualization not available</p>
                </div>
            @endif
        </div>

        <h3>Aspect Performance</h3>
        <table>
            <thead>
                <tr>
                    <th>Aspect</th>
                    <th>Score</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($indicatorData[3]['aspectScores'] as $key => $score)
                    <tr>
                        <td>{{ ucfirst($key) }}</td>
                        <td>
                            {{ number_format($score, 1) }}%
                            <div class="score-progress">
                                <div class="score-bar" style="width: {{ $score }}%"></div>
                            </div>
                        </td>
                        <td>
                            @php
                                $statusClass =
                                    $score >= 80
                                        ? 'status-success'
                                        : ($score >= 60
                                            ? 'status-warning'
                                            : 'status-danger');
                                $statusText = $score >= 80 ? 'Ready' : ($score >= 60 ? 'Developing' : 'Needs Review');
                            @endphp
                            <span class="status-badge {{ $statusClass }}">{{ $statusText }}</span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Page break after Indicator 3 -->
    <div class="page-break"></div>

    <!-- Indicator 4 -->
    <h2>Indicator 4: Chasin Phase</h2>
    <div class="indicator-section">
        <div class="indicator-title">
            Chasin Phase Assessment
        </div>

        <div style="display: flex; justify-content: center; margin: 20px 0;">
            @if(isset($chartImages['indicator_4']))
                <img src="{{ $chartImages['indicator_4'] }}" alt="Indicator 4 Chart" style="max-width: 100%; height: auto; max-height: 300px;">
            @else
                <div class="chart-placeholder" style="width: 100%; height: 200px; background-color: #f5f5f5; display: flex; align-items: center; justify-content: center; border-radius: 5px;">
                    <p style="color: #777;">Chart visualization not available</p>
                </div>
            @endif
        </div>

        <h3>Aspect Performance</h3>
        <table>
            <thead>
                <tr>
                    <th>Aspect</th>
                    <th>Score</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($indicatorData[4]['aspectScores'] as $key => $score)
                    <tr>
                        <td>{{ ucfirst($key) }}</td>
                        <td>
                            {{ number_format($score, 1) }}%
                            <div class="score-progress">
                                <div class="score-bar" style="width: {{ $score }}%"></div>
                            </div>
                        </td>
                        <td>
                            @php
                                $statusClass =
                                    $score >= 80
                                        ? 'status-success'
                                        : ($score >= 60
                                            ? 'status-warning'
                                            : 'status-danger');
                                $statusText = $score >= 80 ? 'Ready' : ($score >= 60 ? 'Developing' : 'Needs Review');
                            @endphp
                            <span class="status-badge {{ $statusClass }}">{{ $statusText }}</span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Page break after Indicator 4 -->
    <div class="page-break"></div>

    <!-- Indicator 5 -->
    <h2>Indicator 5: Competition Phase</h2>
    <div class="indicator-section">
        <div class="indicator-title">
            Competition Phase Assessment
        </div>

        <div style="display: flex; justify-content: center; margin: 20px 0;">
            @if(isset($chartImages['indicator_5']))
                <img src="{{ $chartImages['indicator_5'] }}" alt="Indicator 5 Chart" style="max-width: 100%; height: auto; max-height: 300px;">
            @else
                <div class="chart-placeholder" style="width: 100%; height: 200px; background-color: #f5f5f5; display: flex; align-items: center; justify-content: center; border-radius: 5px;">
                    <p style="color: #777;">Chart visualization not available</p>
                </div>
            @endif
        </div>

        <h3>Aspect Performance</h3>
        <table>
            <thead>
                <tr>
                    <th>Aspect</th>
                    <th>Score</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($indicatorData[5]['aspectScores'] as $key => $score)
                    <tr>
                        <td>{{ ucfirst($key) }}</td>
                        <td>
                            {{ number_format($score, 1) }}%
                            <div class="score-progress">
                                <div class="score-bar" style="width: {{ $score }}%"></div>
                            </div>
                        </td>
                        <td>
                            @php
                                $statusClass =
                                    $score >= 80
                                        ? 'status-success'
                                        : ($score >= 60
                                            ? 'status-warning'
                                            : 'status-danger');
                                $statusText = $score >= 80 ? 'Ready' : ($score >= 60 ? 'Developing' : 'Needs Review');
                            @endphp
                            <span class="status-badge {{ $statusClass }}">{{ $statusText }}</span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Page break after Indicator 5 -->
    <div class="page-break"></div>

    <!-- Indicator 6 -->
    <h2>Indicator 6: Changeover/Closedown Phase</h2>
    <div class="indicator-section">
        <div class="indicator-title">
            Changeover/Closedown Phase Assessment
        </div>

        <div style="display: flex; justify-content: center; margin: 20px 0;">
            @if(isset($chartImages['indicator_6']))
                <img src="{{ $chartImages['indicator_6'] }}" alt="Indicator 6 Chart" style="max-width: 100%; height: auto; max-height: 300px;">
            @else
                <div class="chart-placeholder" style="width: 100%; height: 200px; background-color: #f5f5f5; display: flex; align-items: center; justify-content: center; border-radius: 5px;">
                    <p style="color: #777;">Chart visualization not available</p>
                </div>
            @endif
        </div>

        <h3>Aspect Performance</h3>
        <table>
            <thead>
                <tr>
                    <th>Aspect</th>
                    <th>Score</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($indicatorData[6]['aspectScores'] as $key => $score)
                    <tr>
                        <td>{{ ucfirst($key) }}</td>
                        <td>
                            {{ number_format($score, 1) }}%
                            <div class="score-progress">
                                <div class="score-bar" style="width: {{ $score }}%"></div>
                            </div>
                        </td>
                        <td>
                            @php
                                $statusClass =
                                    $score >= 80
                                        ? 'status-success'
                                        : ($score >= 60
                                            ? 'status-warning'
                                            : 'status-danger');
                                $statusText = $score >= 80 ? 'Ready' : ($score >= 60 ? 'Developing' : 'Needs Review');
                            @endphp
                            <span class="status-badge {{ $statusClass }}">{{ $statusText }}</span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Additional Info Section if applicable -->
    @if (isset($katsinov->katsinovInovasis) && count($katsinov->katsinovInovasis) > 0)
        <div class="page-break"></div>
        <h2>Innovation Details</h2>
        <div class="info-grid">
            @foreach ($katsinov->katsinovInovasis as $inovasi)
                <div class="info-item">
                    <span class="info-label">Title:</span> {{ $inovasi->title }}
                </div>
                <div class="info-item">
                    <span class="info-label">Sub Title:</span> {{ $inovasi->sub_title }}
                </div>
                <div class="info-item">
                    <span class="info-label">Introduction:</span> {{ $inovasi->introduction }}
                </div>
                <div class="info-item">
                    <span class="info-label">Tech Product:</span> {{ $inovasi->tech_product }}
                </div>
                <div class="info-item">
                    <span class="info-label">Supremacy:</span> {{ $inovasi->supremacy }}
                </div>
                <div class="info-item">
                    <span class="info-label">Patent:</span> {{ $inovasi->patent }}
                </div>
                <div class="info-item">
                    <span class="info-label">Tech Preparation:</span> {{ $inovasi->tech_preparation }}
                </div>
                <div class="info-item">
                    <span class="info-label">Market Preparation:</span> {{ $inovasi->market_preparation }}
                </div>
            @endforeach
        </div>
    @endif

    <!-- Notes Section -->
    @if (isset($record) && $record->rekomendasi)
        <div class="page-break"></div>
        <h2>Notes and Recommendations</h2>
        <div style="padding: 15px; background-color: #f9f9f9; border-radius: 5px; border-left: 5px solid #176369;">
            <p>{{ $record->rekomendasi }}</p>
        </div>
    @endif

    <div class="footer">
        <p>KATSINOV Assessment Report - Generated on {{ date('Y-m-d H:i:s') }}</p>
        <p>{{ $katsinov->institution }} - {{ $katsinov->title }}</p>
    </div>
</body>

</html>
