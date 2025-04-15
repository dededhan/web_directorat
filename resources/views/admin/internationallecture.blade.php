@extends('admin.admin')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="{{ asset('dashboard_main/dashboard/internationallecture_dashboard.css') }}">

@section('contentadmin')
    <div class="head-title">
        <div class="left">
            <h1>Dosen Internasional</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="#">Dashboard</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a class="active" href="#">Input Dosen Internasional</a>
                </li>
            </ul>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="table-data">
        <div class="order">
            <div class="head">
                <h3>Input Data Dosen Internasional</h3>
            </div>

            <form id="lecture-form" action="{{ route('admin.internationallecture.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="fakultas" class="form-label">Fakultas</label>
                        <select class="form-select" name="fakultas" id="fakultas">
                            <option value="">Pilih Fakultas</option>
                            <option value="pascasarjana">PASCASARJANA</option>
                            <option value="fip">FIP</option>
                            <option value="fmipa">FMIPA</option>
                            <option value="fppsi">FPPsi</option>
                            <option value="fbs">FBS</option>
                            <option value="ft">FT</option>
                            <option value="fik">FIK</option>
                            <option value="fis">FIS</option>
                            <option value="fe">FE</option>
                            <option value="profesi">PROFESI</option>
                        </select>
                        <div class="form-text text-muted">Pilih fakultas tempat dosen mengajar</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="prodi" class="form-label">Program Studi</label>
                        <select class="form-select" name="prodi" id="prodi" disabled>
                            <option value="">Pilih Program Studi</option>
                        </select>
                        <div class="form-text text-muted">Pilih program studi tempat dosen mengajar</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="nama" class="form-label">Nama Dosen</label>
                        <input type="text" class="form-control" name="nama" id="nama" required>
                        <div class="form-text text-muted">Masukkan nama lengkap dosen</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="negara" class="form-label">Negara Asal</label>
                        <input type="text" class="form-control" name="negara" id="negara" required>
                        <div class="form-text text-muted">Masukkan negara asal dosen</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="universitas_asal" class="form-label">Universitas Asal</label>
                        <input type="text" class="form-control" name="universitas_asal" id="universitas_asal" required>
                        <div class="form-text text-muted">Masukkan universitas asal dosen</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" name="status" id="status" required>
                            <option value="">Pilih Status</option>
                            <option value="fulltime">Full Time</option>
                            <option value="parttime">Part Time</option>
                        </select>
                        <div class="form-text text-muted">Pilih status kepegawaian dosen</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="bidang_keahlian" class="form-label">Bidang Keahlian</label>
                        <input type="text" class="form-control" name="bidang_keahlian" id="bidang_keahlian" required>
                        <div class="form-text text-muted">Masukkan bidang keahlian dosen</div>
                    </div>
                </div>

                <div class="mb-3 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>

        <div class="table-data mt-4">
            <div class="order">
                <div class="head">
                    <h3>Daftar Dosen Internasional</h3>
                    <div class="d-flex justify-content-end">
                        <div class="search-box">
                            <input type="text" id="searchInput" class="form-control" placeholder="Search...">
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped" id="lecture-table">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Fakultas</th>
                                <th>Program Studi</th>
                                <th>Negara Asal</th>
                                <th>Universitas Asal</th>
                                <th>Status</th>
                                <th>Bidang Keahlian</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dosen as $item)
                                <tr>
                                    <td>{{ $item->nama }}</td>
                                    <td>{{ strtoupper($item->fakultas) }}</td>
                                    <td>{{ $item->prodi }}</td>
                                    <td>{{ $item->negara }}</td>
                                    <td>{{ $item->universitas_asal }}</td>
                                    <td>{{ ucfirst($item->status) }}</td>
                                    <td>{{ $item->bidang_keahlian }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-sm btn-warning edit-dosen"
                                                data-id="{{ $item->id }}">Edit</button>
                                            <form method="POST"
                                                action="{{ route('admin.internationallecture.destroy', $item->id) }}"
                                                class="delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button"
                                                    class="btn btn-sm btn-danger delete-btn">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal untuk mengedit dosen -->
    <div class="modal fade" id="editDosenModal" tabindex="-1" aria-labelledby="editDosenModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editDosenModalLabel">Edit Dosen Internasional</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editDosenForm" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit_fakultas" class="form-label">Fakultas</label>
                                <select class="form-select" name="fakultas" id="edit_fakultas">
                                    <option value="">Pilih Fakultas</option>
                                    <option value="pascasarjana">PASCASARJANA</option>
                                    <option value="fip">FIP</option>
                                    <option value="fmipa">FMIPA</option>
                                    <option value="fppsi">FPPsi</option>
                                    <option value="fbs">FBS</option>
                                    <option value="ft">FT</option>
                                    <option value="fik">FIK</option>
                                    <option value="fis">FIS</option>
                                    <option value="fe">FE</option>
                                    <option value="profesi">PROFESI</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_prodi" class="form-label">Program Studi</label>
                                <select class="form-select" name="prodi" id="edit_prodi">
                                    <option value="">Pilih Program Studi</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="edit_nama" class="form-label">Nama Dosen</label>
                                <input type="text" class="form-control" name="nama" id="edit_nama" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit_negara" class="form-label">Negara Asal</label>
                                <input type="text" class="form-control" name="negara" id="edit_negara" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_universitas_asal" class="form-label">Universitas Asal</label>
                                <input type="text" class="form-control" name="universitas_asal"
                                    id="edit_universitas_asal" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit_status" class="form-label">Status</label>
                                <select class="form-select" name="status" id="edit_status" required>
                                    <option value="">Pilih Status</option>
                                    <option value="fulltime">Full Time</option>
                                    <option value="parttime">Part Time</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_bidang_keahlian" class="form-label">Bidang Keahlian</label>
                                <input type="text" class="form-control" name="bidang_keahlian"
                                    id="edit_bidang_keahlian" required>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="saveEditDosen">Simpan Perubahan</button>
                </div>
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

        .form-control:focus,
        .form-select:focus {
            border-color: #3498db;
            box-shadow: none;
        }

        .btn-primary {
            background-color: #3498db;
            border-color: #3498db;
        }

        .btn-primary:hover {
            background-color: #2980b9;
            border-color: #2980b9;
        }

        .table-responsive {
            overflow-x: auto;
        }

        .btn-group {
            display: flex;
            gap: 5px;
        }

        .badge {
            font-size: 0.7em;
        }
    </style>

    <!-- Include internationallecture_dashboard.js for fakultas & prodi dropdown logic and other functionality -->
    <script src="{{ asset('dashboard_main/dashboard/internationallecture_dashboard.js') }}"></script>
@endsection
