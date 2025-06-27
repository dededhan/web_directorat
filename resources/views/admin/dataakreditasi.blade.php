@extends('admin.admin')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="{{ asset('dashboard_main/dashboard/akreditasi_dashboard.css') }}">

@section('contentadmin')
    <div class="head-title">
        <div class="left">
            <h1>Data Akreditasi</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="#">Dashboard</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a class="active" href="#">Input Data Akreditasi</a>
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
                <h3>Input Data Akreditasi</h3>
            </div> 

            <form action="{{ route('admin.dataakreditasi.store') }}" method="POST" id="akreditasi-form">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="fakultas" class="form-label">Fakultas</label>
                        <select class="form-select" name="fakultas" id="fakultas">
                            <option value="">Pilih Fakultas</option>
                            <option value="pascasarjana">PASCASARJANA</option>
                            <option value="fip">FIP</option>
                            <option value="fmipa">FMIPA</option>
                            <option value="fppsi">FPsi</option>
                            <option value="fbs">FBS</option>
                            <option value="ft">FT</option>
                            <option value="fik">FIKK</option>
                            <option value="fis">FISH</option>
                            <option value="fe">FE</option>
                            <option value="profesi">PROFESI</option>
                        </select>
                        @error('fakultas')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                        <div class="form-text text-muted">Pilih fakultas yang akan diinput data akreditasinya</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="prodi" class="form-label">Program Studi</label>
                        <select class="form-select" name="prodi" id="prodi" disabled>
                            <option value="">Pilih Program Studi</option>
                        </select>
                        @error('prodi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                        <div class="form-text text-muted">Pilih program studi yang akan diinput data akreditasinya</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="lembaga_akreditasi" class="form-label">Lembaga Akreditasi</label>
                        <select class="form-select" name="lembaga_akreditasi" id="lembaga_akreditasi">
                            <option value="">Pilih Lembaga Akreditasi</option>
                            <option value="ban-pt">BAN-PT</option>
                            <option value="lam-infokom">LAM INFOKOM</option>
                            <option value="lam-teknik">LAM TEKNIK</option>
                            <option value="lam-ekonomi">LAMEMBA</option>
                            <option value="lam-pendidikan">LAMDIK</option>
                            <option value="lam-sains">LAMSAMA</option>
                        </select>
                        <div class="form-text text-muted">Pilih lembaga yang mengeluarkan akreditasi</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="peringkat" class="form-label">Peringkat Akreditasi</label>
                        <select class="form-select" name="peringkat" id="peringkat">
                            <option value="">Pilih Peringkat</option>
                            <option value="unggul">Unggul</option>
                            <option value="baik_sekali">Baik Sekali</option>
                            <option value="baik">Baik</option>
                            <option value="a">A</option>
                            <option value="b">B</option>
                            <option value="c">C</option>
                        </select>
                        <div class="form-text text-muted">Pilih peringkat akreditasi yang diperoleh</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="nomor_sk" class="form-label">Nomor SK</label>
                        <input type="text" class="form-control" name="nomor_sk" id="nomor_sk">
                        <div class="form-text text-muted">Masukkan nomor SK akreditasi (contoh: 1234/SK/BAN-PT/2024)</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="periode_awal" class="form-label">Periode Awal Berlaku</label>
                        <input type="date" class="form-control" name="periode_awal" id="periode_awal">
                        <div class="form-text text-muted">Pilih tanggal mulai berlakunya akreditasi</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="periode_akhir" class="form-label">Periode Akhir Berlaku</label>
                        <input type="date" class="form-control" name="periode_akhir" id="periode_akhir">
                        <div class="form-text text-muted">Pilih tanggal berakhirnya akreditasi</div>
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
                    <h3>Daftar Data Akreditasi</h3>
                    <div class="d-flex justify-content-end">
                        <div class="search-box">
                            <input type="text" id="searchInput" class="form-control" placeholder="Search...">
                        </div>
                    </div>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-striped" id="akreditasi-table">
                        <thead>
                            <tr>
                                <th>Fakultas</th>
                                <th>Program Studi</th>
                                <th>Lembaga Akreditasi</th>
                                <th>Peringkat</th>
                                <th>Nomor SK</th>
                                <th>Periode Berlaku</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="akreditasi-list">
                            @forelse ($akreditasis as $akreditasi)
                            <tr>
                                <td>{{ strtoupper($akreditasi->fakultas) }}</td>
                                <td>{{ $akreditasi->prodi }}</td>
                                @php
                                // Tambahkan mapping untuk lembaga akreditasi
                                $lembagaMapping = [
                                    'ban-pt' => 'BAN-PT',
                                    'lam-infokom' => 'LAM INFOKOM',
                                    'lam-teknik' => 'LAM TEKNIK',
                                    'lam-ekonomi' => 'LAMEMBA',
                                    'lam-pendidikan' => 'LAM PENDIDIKAN',
                                    'lam-sains' => 'LAMSAMA'
                                ];
                            @endphp
                            
                            <td>{{ $lembagaMapping[$akreditasi->lembaga_akreditasi] ?? $akreditasi->lembaga_akreditasi }}</td>
                                <td>
                                    @php
                                        $peringkatLabels = [
                                            'unggul' => 'Unggul',
                                            'baik_sekali' => 'Baik Sekali',
                                            'baik' => 'Baik',
                                            'a' => 'A',
                                            'b' => 'B',
                                            'c' => 'C'
                                        ];
                                    @endphp
                                    {{ $peringkatLabels[$akreditasi->peringkat] ?? $akreditasi->peringkat }}
                                </td>
                                <td>{{ $akreditasi->nomor_sk }}</td>
                                <td>
                                    {{ \Carbon\Carbon::parse($akreditasi->periode_awal)->format('d/m/Y') }} - 
                                    {{ \Carbon\Carbon::parse($akreditasi->periode_akhir)->format('d/m/Y') }}
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-warning edit-akreditasi"
                                            data-id="{{ $akreditasi->id }}">Edit</button>
                                        <form method="POST"
                                            action="{{ route('admin.dataakreditasi.destroy', $akreditasi->id) }}"
                                            class="delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button"
                                                class="btn btn-sm btn-danger delete-btn">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">Tidak ada data akreditasi</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal untuk mengedit akreditasi -->
    <div class="modal fade" id="editAkreditasiModal" tabindex="-1" aria-labelledby="editAkreditasiModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editAkreditasiModalLabel">Edit Data Akreditasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editAkreditasiForm" method="POST">
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
                            <div class="col-md-6 mb-3">
                                <label for="edit_lembaga_akreditasi" class="form-label">Lembaga Akreditasi</label>
                                <select class="form-select" name="lembaga_akreditasi" id="edit_lembaga_akreditasi">
                                    <option value="">Pilih Lembaga Akreditasi</option>
                                    <option value="ban-pt">BAN-PT</option>
                                    <option value="lam-infokom">LAM INFOKOM</option>
                                    <option value="lam-teknik">LAM TEKNIK</option>
                                    <option value="lam-ekonomi">LAM EKONOMI</option>
                                    <option value="lam-pendidikan">LAM PENDIDIKAN</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_peringkat" class="form-label">Peringkat Akreditasi</label>
                                <select class="form-select" name="peringkat" id="edit_peringkat">
                                    <option value="">Pilih Peringkat</option>
                                    <option value="unggul">Unggul</option>
                                    <option value="baik_sekali">Baik Sekali</option>
                                    <option value="baik">Baik</option>
                                    <option value="a">A</option>
                                    <option value="b">B</option>
                                    <option value="c">C</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="edit_nomor_sk" class="form-label">Nomor SK</label>
                                <input type="text" class="form-control" name="nomor_sk" id="edit_nomor_sk">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit_periode_awal" class="form-label">Periode Awal Berlaku</label>
                                <input type="date" class="form-control" name="periode_awal" id="edit_periode_awal">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_periode_akhir" class="form-label">Periode Akhir Berlaku</label>
                                <input type="date" class="form-control" name="periode_akhir" id="edit_periode_akhir">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="saveEditAkreditasi">Simpan Perubahan</button>
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

        .form-control:focus, .form-select:focus {
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

    <!-- Include jQuery and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Include akreditasi_dashboard.js for fakultas & prodi dropdown logic and other functionality -->
    <script src="{{ asset('resources/movejs/akreditasi_dashboard.js') }}"></script>

 @endsection   