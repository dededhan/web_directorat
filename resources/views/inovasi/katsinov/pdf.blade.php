<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; }
        .header { text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .badge { padding: 4px 8px; border-radius: 4px; font-size: 12px; }
        .success { background-color: #d4edda; color: #155724; }
        .warning { background-color: #fff3cd; color: #856404; }
        .danger { background-color: #f8d7da; color: #721c24; }
    </style>
</head>
<body>
    <div class="header">
        <h2>KATSINOV Report</h2>
        <p>Generated at: {{ now()->format('d F Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Judul</th>
                <th>Fokus Bidang</th>
                <th>Proyek</th>
                <th>Status</th>
                <th>Nilai Rata-rata</th>
                <th>Aspek Teknologi</th>
                <th>Aspek Organisasi</th>
                <th>Aspek Risiko</th>
                <th>Aspek Pasar</th>
                <th>Aspek Kemitraan</th>
                <th>Aspek Manufaktur</th>
                <th>Aspek Investasi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($katsinovs as $katsinov)
                @php
                    $averages = [];
                    $aspects = ['technology', 'organization', 'risk', 'market', 'partnership', 'manufacturing', 'investment'];
                    
                    foreach ($aspects as $key) {
                        $averages[$key] = number_format($katsinov->scores->avg($key), 2);
                    }
                    
                    $overallAvg = number_format(array_sum($averages) / count($averages), 2);
                    $status = $overallAvg >= 80 ? 'success' : ($overallAvg >= 60 ? 'warning' : 'danger');
                    $statusText = $overallAvg >= 80 ? 'Completed' : ($overallAvg >= 60 ? 'Pending' : 'Need Review');
                @endphp
                <tr>
                    <td>{{ $katsinov->id }}</td>
                    <td>{{ $katsinov->title }}</td>
                    <td>{{ $katsinov->focus_area }}</td>
                    <td>{{ $katsinov->project_name }}</td>
                    <td><span class="badge {{ $status }}">{{ $statusText }}</span></td>
                    <td>{{ $overallAvg }}%</td>
                    @foreach($aspects as $aspect)
                        <td>{{ $averages[$aspect] }}%</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>