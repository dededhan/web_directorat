@extends('admin.admin')
<link rel="stylesheet" href="{{ asset('dashboard_main/dashboard/alumniberdampak_dashboard.css') }}">
@section('contentadmin')
    <div class="head-title">
        <div class="left">
            <h1>Alumni Berdampak</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a class="active" href="#">Input Berita Alumni Berdampak</a>
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
                <h3>Input Berita Alumni Berdampak</h3>
            </div> 

            <form id="alumni-form" action="{{ route('admin.alumniberdampak.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="judul_berita" class="form-label">Judul Berita/Artikel</label>
                        <input type="text" class="form-control" name="judul_berita" id="judul_berita">
                        <div class="form-text text-muted">Masukkan judul berita/artikel sesuai dengan sumber aslinya. Pastikan judul mencerminkan dampak alumni terhadap sustainability</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="tanggal_berita" class="form-label">Tanggal Berita/Artikel</label>
                        <input type="date" class="form-control" name="tanggal_berita" id="tanggal_berita">
                        <div class="form-text text-muted">Pilih tanggal publikasi berita/artikel asli</div>
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
                        <div class="form-text text-muted">Pilih fakultas asal alumni yang bersangkutan</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="prodi" class="form-label">Program Studi</label>
                        <select class="form-select" name="prodi" id="prodi" disabled>
                            <option value="">Pilih Program Studi</option>
                        </select>
                        <div class="form-text text-muted">Pilih program studi asal alumni yang bersangkutan</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="link_berita" class="form-label">Link Berita/Artikel</label>
                        <input type="url" class="form-control" name="link_berita" id="link_berita">
                        <div class="form-text text-muted">Masukkan link berita/artikel dari sumber terpercaya (media massa online, website resmi institusi, atau publikasi resmi lainnya)</div>
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
                    <h3>Daftar Berita Alumni Berdampak</h3>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-striped" id="alumni-table">
                        <thead>
                            <tr>
                                <th>Judul Berita/Artikel</th>
                                <th>Tanggal</th>
                                <th>Fakultas</th>
                                <th>Program Studi</th>
                                <th>Link</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="alumni-list">
                            @foreach($alumniBerdampak as $alumni)
                            <tr>
                                <td>{{ $alumni->judul_berita }}</td>
                                <td>{{ $alumni->tanggal_berita }}</td>
                                <td>{{ strtoupper($alumni->fakultas) }}</td>
                                <td>{{ $alumni->prodi }}</td>
                                <td>
                                    <a href="{{ $alumni->link_berita }}" target="_blank" class="btn btn-sm btn-info">
                                        View Link
                                    </a>
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
    </div>

    <!-- Include jQuery if not already included -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Include Bootstrap JS and SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('dashboard_main/dashboard/alumniberdampak_dashboard.js') }}"></script>

    <script>
        // Program studi for each fakultas based on the sustainability_dashboard.js data
        

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