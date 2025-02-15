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
                        <!-- Static Data Row 1 -->
                        <tr>
                            <td>1</td>
                            <td>Project Innovation A</td>
                            <td>Technology</td>
                            <td>Smart City</td>
                            <td>Tech Institute A</td>
                            <td>Jakarta Pusat</td>
                            <td>contact1@example.com</td>
                            <td>15 Feb 2025</td>
                            <td>
                                <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#aspectModal1">
                                    View Aspects
                                </button>
                                
                                <div class="modal fade" id="aspectModal1" tabindex="-1">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Aspect Scores for Project Innovation A</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="aspect-grid">
                                                    <div class="aspect-item">
                                                        <h6>Teknologi (T)</h6>
                                                        <p>85%</p>
                                                    </div>
                                                    <div class="aspect-item">
                                                        <h6>Pasar (M)</h6>
                                                        <p>75%</p>
                                                    </div>
                                                    <div class="aspect-item">
                                                        <h6>Organisasi (O)</h6>
                                                        <p>80%</p>
                                                    </div>
                                                    <div class="aspect-item">
                                                        <h6>Manufaktur (Mf)</h6>
                                                        <p>70%</p>
                                                    </div>
                                                    <div class="aspect-item">
                                                        <h6>Investasi (I)</h6>
                                                        <p>65%</p>
                                                    </div>
                                                    <div class="aspect-item">
                                                        <h6>Kemitraan (P)</h6>
                                                        <p>90%</p>
                                                    </div>
                                                    <div class="aspect-item">
                                                        <h6>Risiko (R)</h6>
                                                        <p>60%</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-success">Completed</span>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <button class="btn btn-sm btn-warning">Edit</button>
                                    <button class="btn btn-sm btn-danger">Delete</button>
                                </div>
                            </td>
                        </tr>

                        <!-- Static Data Row 2 -->
                        <tr>
                            <td>2</td>
                            <td>Project Innovation B</td>
                            <td>Healthcare</td>
                            <td>Health Tech</td>
                            <td>Medical Institute</td>
                            <td>Jakarta Selatan</td>
                            <td>contact2@example.com</td>
                            <td>14 Feb 2025</td>
                            <td>
                                <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#aspectModal2">
                                    View Aspects
                                </button>
                                
                                <div class="modal fade" id="aspectModal2" tabindex="-1">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Aspect Scores for Project Innovation B</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="aspect-grid">
                                                    <div class="aspect-item">
                                                        <h6>Teknologi (T)</h6>
                                                        <p>90%</p>
                                                    </div>
                                                    <div class="aspect-item">
                                                        <h6>Pasar (M)</h6>
                                                        <p>85%</p>
                                                    </div>
                                                    <div class="aspect-item">
                                                        <h6>Organisasi (O)</h6>
                                                        <p>75%</p>
                                                    </div>
                                                    <div class="aspect-item">
                                                        <h6>Manufaktur (Mf)</h6>
                                                        <p>80%</p>
                                                    </div>
                                                    <div class="aspect-item">
                                                        <h6>Investasi (I)</h6>
                                                        <p>70%</p>
                                                    </div>
                                                    <div class="aspect-item">
                                                        <h6>Kemitraan (P)</h6>
                                                        <p>85%</p>
                                                    </div>
                                                    <div class="aspect-item">
                                                        <h6>Risiko (R)</h6>
                                                        <p>65%</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-warning">Pending</span>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <button class="btn btn-sm btn-warning">Edit</button>
                                    <button class="btn btn-sm btn-danger">Delete</button>
                                </div>
                            </td>
                        </tr>
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
            const rows = document.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
            
            Array.from(rows).forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchText) ? '' : 'none';
            });
        });
    </script>
@endsection