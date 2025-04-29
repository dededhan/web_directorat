@extends('admin.admin')

@section('contentadmin')
<div class="container-fluid">
    <div class="head-title">
        <div class="left">
            <h1>Jumlah Aspek KATSINOV</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="#">Dashboard</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a class="active" href="#">Jumlah Aspek</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Perbandingan Aspek per Indikator</h4>
                </div>
                <div class="card-body">
                    <div class="aspect-chart-container">
                        @php
                        $aspects = [
                            'technology' => 'Teknologi (T)', 
                            'market' => 'Pasar (M)', 
                            'organization' => 'Organisasi (O)', 
                            'manufacturing' => 'Manufaktur (Mf)', 
                            'partnership' => 'Kemitraan (P)', 
                            'investment' => 'Investasi (I)', 
                            'risk' => 'Risiko (R)'
                        ];

                        $aspectColors = [
                            'technology' => 'rgb(255, 99, 132)',
                            'market' => 'rgb(54, 162, 235)',
                            'organization' => 'rgb(255, 206, 86)',
                            'manufacturing' => 'rgb(75, 192, 192)',
                            'partnership' => 'rgb(153, 102, 255)',
                            'investment' => 'rgb(255, 159, 64)',
                            'risk' => 'rgb(70, 150, 130)'
                        ];
                        @endphp

                        @foreach ($aspects as $key => $label)
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h5 class="card-title">{{ $label }}</h5>
                                </div>
                                <div class="card-body">
                                    <canvas id="chart-{{ $key }}" height="300"></canvas>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const aspects = [
        'technology', 'market', 'organization', 
        'manufacturing', 'partnership', 'investment', 'risk'
    ];

    const aspectColors = @json($aspectColors);
    const aspectData = {!! json_encode($aspectData) !!};

    aspects.forEach(aspect => {
        const ctx = document.getElementById(`chart-${aspect}`).getContext('2d');
        
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Indikator 1', 'Indikator 2', 'Indikator 3', 'Indikator 4', 'Indikator 5', 'Indikator 6'],
                datasets: [{
                    label: aspect.charAt(0).toUpperCase() + aspect.slice(1),
                    data: aspectData[aspect].data,
                    borderColor: aspectColors[aspect],
                    backgroundColor: aspectColors[aspect] + '33', // Adding transparency
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,
                        title: {
                            display: true,
                            text: 'Skor (%)'
                        }
                    }
                }
            }
        });
    });
});
</script>
@endpush

<style>
.aspect-chart-container {
    background-color: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
}

.card-header {
    background-color: #f1f3f9 !important;
    border-bottom: 1px solid #e3e6f0;
}

canvas {
    width: 100% !important;
    height: 300px !important;
}
</style>