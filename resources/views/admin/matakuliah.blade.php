@extends('admin.admin')

<link rel="stylesheet" href="{{ asset('dashboard_main/dashboard/matakuliah_dashboard.css') }}">

@section('contentadmin')
    <div class="head-title">
        <div class="left">
            <h1>Mata Kuliah Sustainability</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a class="active" href="#">Input Mata Kuliah</a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="table-data">
        <div class="order">
            <div class="head">
                <h3>Input Mata Kuliah Sustainability</h3>
            </div> 

            <form id="matakuliah-form" action="{{ route('admin.matakuliah.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="nama_matkul" class="form-label">Nama Mata Kuliah</label>
                        <input type="text" class="form-control" name="nama_matkul" id="nama_matkul">
                        <div class="form-text text-muted">Masukkan nama lengkap mata kuliah sesuai dengan kurikulum</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="semester" class="form-label">Semester</label>
                        <input type="text" class="form-control" name="semester" id="semester">
                        <div class="form-text text-muted">Masukkan semester berapa mata kuliah ini diajarkan (contoh: 1, 2, 3, dst)</div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="kode_matkul" class="form-label">Kode Mata Kuliah</label>
                        <input type="text" class="form-control" name="kode_matkul" id="kode_matkul">
                        <div class="form-text text-muted">Masukkan kode mata kuliah sesuai dengan kurikulum (contoh: MK001)</div>
                    </div>
                </div>

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
                        <div class="form-text text-muted">Pilih fakultas yang menyelenggarakan mata kuliah ini</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="prodi" class="form-label">Program Studi</label>
                        <select class="form-select" name="prodi" id="prodi" disabled>
                            <option value="">Pilih Program Studi</option>
                        </select>
                        <div class="form-text text-muted">Pilih program studi yang menyelenggarakan mata kuliah ini</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="rps" class="form-label">RPS Mata Kuliah</label>
                        <input type="file" class="form-control" name="rps" id="rps" accept=".pdf,.doc,.docx">
                        <div class="form-text text-muted">Upload dokumen RPS dalam format PDF, DOC, atau DOCX. Pastikan RPS sudah disetujui dan ditandatangani</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi Mata Kuliah</label>
                        <textarea class="form-control" name="deskripsi" id="deskripsi" rows="4"></textarea>
                        <div class="form-text text-muted">Deskripsikan mata kuliah secara lengkap (minimal 100 kata), termasuk tujuan pembelajaran, capaian pembelajaran, dan keterkaitan dengan sustainability</div>
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
                    <h3>Daftar Mata Kuliah Sustainability</h3>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-striped" id="matakuliah-table">
                        <thead>
                            <tr>
                                <th>Nama Mata Kuliah</th>
                                <th>Semester</th>
                                <th>Fakultas</th>
                                <th>Program Studi</th>
                                <th>RPS</th>
                                <th>Deskripsi</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="matakuliah-list">
                            @foreach($matakuliahs as $matakuliah)
                                <tr>
                                    <td>{{ $matakuliah->nama_matkul }}</td>
                                    <td>{{ $matakuliah->semester }}</td>
                                    <td>{{ ucfirst($matakuliah->fakultas) }}</td> {{-- Contoh konversi ke huruf kapital --}}
                                    <td>{{ $matakuliah->prodi }}</td>
                                    <td>
                                        <a href="{{ Storage::url($matakuliah->rps_path) }}" class="btn btn-sm btn-info">
                                            Download RPS
                                        </a>
                                    </td>
                                    <td>{{ Str::limit($matakuliah->deskripsi, 50) }}</td>
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
    </div>

    <!-- Include jQuery if not already included -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <link rel="stylesheet" href="{{ asset('dashboard_main/dashboard/matakuliah_dashboard.css') }}">
    
    <!-- Include Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

    <script src="{{ asset('dashboard_main/dashboard/matakuliah_dashboard.js') }}"></script>
    
    <script>
        // Display SweetAlert for flash messages
document.addEventListener('DOMContentLoaded', function() {
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            timer: 2000
        });
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: '{{ session('error') }}',
            timer: 2000
        });
    @endif
});
    </script>

    <style>
       
    </style>
@endsection