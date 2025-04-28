@extends('admin.admin')

@section('contentadmin')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h3>Ringkasan Hasil Pengukuran Tingkat Kesiapan Inovasi</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <h4 class="text-center mb-4">Peta Tingkat Kesiapan Setiap Aspek</h4>
                    <div class="chart-container" style="height:500px; position:relative;">
                        <canvas id="spiderwebChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-teal text-white">
                            <h4 class="mb-0">Catatan</h4>
                        </div>
                        <div class="card-body">
                            <textarea class="form-control" rows="6" placeholder="Tambahkan catatan di sini...">{{ $record->rekomendasi ?? '' }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Directly embed Chart.js in the page -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Hardcoded data directly from controller
    const aspectData = [
        {{ $aspectScores['technology'] ?? 0 }},
        {{ $aspectScores['organization'] ?? 0 }},
        {{ $aspectScores['risk'] ?? 0 }},
        {{ $aspectScores['market'] ?? 0 }},
        {{ $aspectScores['partnership'] ?? 0 }},
        {{ $aspectScores['manufacturing'] ?? 0 }},
        {{ $aspectScores['investment'] ?? 0 }}
    ];
    
    // Make sure the canvas element exists
    const canvas = document.getElementById('spiderwebChart');
    if (!canvas) {
        console.error('Canvas element not found!');
        return;
    }
    
    // Create the chart
    const ctx = canvas.getContext('2d');
    const spiderwebChart = new Chart(ctx, {
        type: 'radar',
        data: {
            labels: [
                'Pengembangan Teknologi (T)',
                'Organisasi (O)', 
                'Penanggung Risiko (R)', 
                'Pasar (M)', 
                'Partnership (P)', 
                'Manufaktur (Mf)', 
                'Investasi (I)'
            ],
            datasets: [{
                label: 'Tingkat Kesiapan Inovasi',
                data: aspectData,
                fill: true,
                backgroundColor: 'rgba(23, 99, 105, 0.2)',
                borderColor: 'rgb(23, 99, 105)',
                pointBackgroundColor: 'rgb(23, 99, 105)',
                pointBorderColor: '#fff',
                pointHoverBackgroundColor: '#fff',
                pointHoverBorderColor: 'rgb(23, 99, 105)'
            }]
        },
        options: {
            scales: {
                r: {
                    beginAtZero: true,
                    max: 100,
                    ticks: {
                        stepSize: 20
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
                            return context.raw.toFixed(1) + '%';
                        }
                    }
                }
            },
            responsive: true,
            maintainAspectRatio: false
        }
    });
});
</script>

<style>
.bg-teal {
    background-color: #176369;
}
</style>
@endsection