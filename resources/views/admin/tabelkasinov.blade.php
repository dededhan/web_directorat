@extends('admin.admin')

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
                            <th>ID</th>
                            <th>Nama/Judul</th>
                            <th>Fokus Bidang</th>
                            <th>Nama Proyek</th>
                            <th>Nama Lembaga</th>
                            <th>Alamat</th>
                            <th>Kontak</th>
                            <th>Tanggal Input</th>
                            <th>Aspek Scores</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($katsinovs as $katsinov)
                        <tr>
                            <td>{{ $katsinov->id }}</td>
                            <td>{{ $katsinov->title }}</td>
                            <td>{{ $katsinov->focus_area }}</td>
                            <td>{{ $katsinov->project_name }}</td>
                            <td>{{ $katsinov->institution }}</td>
                            <td>{{ Str::limit($katsinov->address, 20) }}</td>
                            <td>{{ $katsinov->contact }}</td>
                            <td>{{ $katsinov->assessment_date }}</td>
                            <td>
                                <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#aspectModal{{ $katsinov->id }}">
                                    View Aspects
                                </button>
                                
                                <div class="modal fade" id="aspectModal{{ $katsinov->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Aspect Scores for {{ $katsinov->title }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="aspect-grid">
                                                    @php
                                                        $aspects = [
                                                            'technology' => 'Teknologi (T)',
                                                            'organization' => 'Organisasi (O)',
                                                            'risk' => 'Risiko (R)',
                                                            'market' => 'Pasar (M)',
                                                            'partnership' => 'Kemitraan (P)',
                                                            'manufacturing' => 'Manufaktur (Mf)',
                                                            'investment' => 'Investasi (I)'
                                                        ];
                                                        
                                                        $averages = [];
                                                        foreach ($aspects as $key => $label) {
                                                            $total = $katsinov->scores->avg($key);
                                                            $averages[$key] = number_format($total, 2);
                                                        }
                                                    @endphp
                                                    
                                                    @foreach($aspects as $key => $label)
                                                    <div class="aspect-item">
                                                        <h6>{{ $label }}</h6>
                                                        <p>{{ $averages[$key] }}%</p>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @php
                                    $overallAvg = number_format(array_sum($averages)/count($averages), 2);
                                    $status = $overallAvg >= 80 ? 'success' : ($overallAvg >= 60 ? 'warning' : 'danger');
                                    $statusText = $overallAvg >= 80 ? 'Completed' : ($overallAvg >= 60 ? 'Pending' : 'Need Review');
                                @endphp
                                <span class="badge bg-{{ $status }}">{{ $statusText }}</span>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <button class="btn btn-sm btn-warning">Edit</button>
                                    <button class="btn btn-sm btn-danger">Delete</button>
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
        .table-data {
            margin-top: 24px;
        }

        .order {
            background: #fff;
            padding: 24px;
            border-radius: 20px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .table-responsive {
            overflow-x: auto;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th {
            white-space: nowrap;
            background-color: #f8fafc;
            font-weight: 600;
        }

        .table th, .table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #edf2f7;
        }

        .btn-group {
            display: flex;
            gap: 5px;
        }

        .search-box {
            margin-left: auto;
        }

        .search-box input {
            padding: 8px 12px;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            width: 240px;
        }

        .aspect-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }

        .aspect-item {
            background-color: #f8fafc;
            padding: 1rem;
            border-radius: 8px;
        }

        .aspect-item h6 {
            margin: 0 0 0.5rem 0;
            color: #475569;
        }

        .aspect-item p {
            margin: 0;
            font-size: 1.25rem;
            font-weight: 600;
            color: #0f172a;
        }

        .badge {
            font-size: 0.7em;
            padding: 6px 12px;
            border-radius: 20px;
        }
    </style>

    <script>
        document.getElementById('searchInput').addEventListener('keyup', function() {
            const searchText = this.value.toLowerCase();
            const rows = document.querySelectorAll('tbody tr');
            
            rows.forEach(row => {
                const cells = row.getElementsByTagName('td');
                let found = false;
                
                // Cari di semua kolom kecuali kolom terakhir (actions)
                for(let i = 0; i < cells.length - 1; i++) {
                    const text = cells[i].textContent.toLowerCase();
                    if(text.includes(searchText)) {
                        found = true;
                        break;
                    }
                }
                
                row.style.display = found ? '' : 'none';
            });
        });
    </script>
@endsection