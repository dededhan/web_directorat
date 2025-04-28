@extends('admin.admin')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<link rel="stylesheet" href="{{ asset('inovasi/dashboard/table_katsinov/css/table_katsinov.css') }}">

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

    <div class="dashboard-summary">
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
                            <th>User</th>
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
                                <td>{{ $loop->iteration }}</td>
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
                                        
                                        <button class="btn btn-sm btn-danger">Delete</button>
                                    </div>
                                    <div class="btn-group-vertical mt-2">
                                        <a href="{{ route('admin.katsinov.show', $katsinov->id) }}" class="btn btn-success btn-sm mb-1">
                                            <i class='bx bx-refresh'></i> Penilaian
                                        </a>
                                        <button class="btn btn-info btn-sm mb-1" type="button" data-bs-toggle="collapse" 
                                                data-bs-target="#subforms-{{ $katsinov->id }}" aria-expanded="false">
                                            <i class='bx bx-folder-open'></i> Formulir Pendukung
                                        </button>
                                    </div>
                                </td>
                                <td>
                                    <select class="form-select user-dropdown" data-katsinov-id="{{ $katsinov->id }}">
                                        <option value="">Pilih User</option>
                                        @foreach ($users->sortBy('name') as $user)
                                            <option value="{{ $user->id }}" 
                                                {{ $katsinov->user_id == $user->id ? 'selected' : '' }}
                                                data-role="{{ $user->role }}">
                                                {{ $user->name }} ({{ $user->role }})
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <!-- Collapsible Sub-forms Section -->
                            <tr class="subforms-row">
                                <td colspan="7" class="p-0">
                                    <div class="collapse" id="subforms-{{ $katsinov->id }}">
                                        <div class="card card-body subform-container">
                                            <h5 class="subform-title">Form pendukung untuk "{{ $katsinov->title }}"</h5>
                                            <div class="subform-buttons">
                                                <a href="{{ route('admin.katsinov.inovasi.index', ['katsinov_id' => $katsinov->id]) }}" class="btn btn-primary btn-sm">
                                                    <i class='bx bx-file'></i> Form Judul
                                                </a>
                                                <a href="{{ route('admin.katsinov.informasi.index', ['katsinov_id' => $katsinov->id]) }}" class="btn btn-primary btn-sm">
                                                    <i class='bx bx-info-circle'></i> Form Informasi Dasar
                                                </a>
                                                <a href="{{ route('admin.katsinov.berita.index', ['katsinov_id' => $katsinov->id]) }}" class="btn btn-primary btn-sm">
                                                    <i class='bx bx-news'></i> Form Berita Acara
                                                </a>
                                                <a href="{{ route('admin.katsinov.record.index', ['katsinov_id' => $katsinov->id]) }}" class="btn btn-primary btn-sm">
                                                    <i class='bx bx-bar-chart-alt-2'></i> Form Record Hasil
                                                </a>
                                                <a href="{{ route('admin.katsinov.lampiran.index', ['katsinov_id' => $katsinov->id]) }}" class="btn btn-primary btn-sm">
                                                    <i class='bx bx-paperclip'></i> Lampiran
                                                </a>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <!-- Main details row -->
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
        /* Style for sub-forms section */
        .subform-container {
            background-color: #f8f9fa;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            padding: 15px;
        }
        
        .subform-title {
            font-size: 1.1rem;
            margin-bottom: 15px;
            color: #333;
            border-bottom: 1px solid #dee2e6;
            padding-bottom: 8px;
        }
        
        .subform-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }
        
        .subform-buttons .btn {
            display: flex;
            align-items: center;
            gap: 5px;
            padding: 6px 12px;
            transition: all 0.2s;
        }
        
        .subform-buttons .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        
        .subforms-row {
            background-color: transparent !important;
        }
    </style>

    <script src="{{ asset('inovasi/dashboard/table_katsinov/js/table_katsinov.js') }}"></script>
    <script src="{{ asset('inovasi/dashboard/table_katsinov/js/table_katsinovoverall.js') }}"></script>
    <script src="{{ asset('inovasi/dashboard/form_katsinov/js/form.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        async function loadRecord() {
            try {
                const response = await fetch('/katsinov/latest');
                if (!response.ok) throw new Error('Data tidak ditemukan');
                const data = await response.json();

                // Isi data dasar
                document.querySelector('input[name="title"]').value = data.title || '';
                document.querySelector('input[name="focus_area"]').value = data.focus_area || '';
                document.querySelector('input[name="project_name"]').value = data.project_name || '';
                document.querySelector('input[name="institution"]').value = data.institution || '';
                document.querySelector('input[name="address"]').value = data.address || '';
                document.querySelector('input[name="contact"]').value = data.contact || '';
                document.querySelector('input[name="assessment_date"]').value = data.assessment_date || '';

                // Isi skor per indikator dan aspek
                data.scores.forEach(score => {
                    const indicator = score.indicator_number;

                    // Mapping aspek database ke class di form
                    const aspectMap = {
                        'technology': 't',
                        'organization': 'o',
                        'risk': 'r',
                        'market': 'm',
                        'partnership': 'p',
                        'manufacturing': 'mf',
                        'investment': 'i'
                    };

                    // Loop semua aspek
                    Object.entries(aspectMap).forEach(([dbAspect, formAspect]) => {
                        const percentage = score[dbAspect];
                        const value = Math.round(percentage / 20); // Konversi ke 0-5

                        // Cari semua radio button di indikator dan aspek terkait
                        const selector =
                            `div[data-indicator="${indicator}"] tr.row-${formAspect} input[value="${value}"]`;
                        const radios = document.querySelectorAll(selector);

                        // Set radio yang sesuai
                        radios.forEach(radio => radio.checked = true);
                    });
                });

                Swal.fire({
                    icon: 'success',
                    title: 'Data berhasil dimuat!',
                    text: 'Data terakhir telah diisi ke form',
                });
            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal memuat data',
                    text: error.message,
                });
            }
        }
    </script>
  <script>
document.querySelectorAll('.user-dropdown').forEach(select => {
    select.addEventListener('change', function() {
        const katsinovId = this.dataset.katsinovId;
        const userId = this.value;

        fetch("{{ route('admin.katsinov.update-user') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                katsinov_id: katsinovId,
                user_id: userId
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Toastify({
                    text: "User berhasil diperbarui!",
                    duration: 3000,
                    close: true,
                    gravity: "top",
                    position: "right",
                    backgroundColor: "#4CAF50",
                }).showToast();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Toastify({
                text: "Gagal memperbarui user!",
                duration: 3000,
                close: true,
                gravity: "top",
                position: "right",
                backgroundColor: "#ff0000",
            }).showToast();
        });
    });
});
</script>
@endsection