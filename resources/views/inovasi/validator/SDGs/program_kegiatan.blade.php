@extends('inovasi.validator.index')

@section('contentvalidator')
    <div class="head-title">
        <div class="left">
            <h1>Program & Kegiatan</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a class="active" href="#">Input Program & Kegiatan</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="table-data">
        <div class="order">
            <div class="head">
                <h3>Input Program & Kegiatan</h3>
            </div> 

            <form id="program-kegiatan-form" action="#" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="judul" class="form-label">Judul</label>
                        <input type="text" class="form-control" name="judul" id="judul">
                        <div class="form-text text-muted">Masukkan judul program/kegiatan</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="tanggal" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" name="tanggal" id="tanggal">
                        <div class="form-text text-muted">Pilih tanggal program/kegiatan</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="kategori" class="form-label">Kategori</label>
                        <select class="form-select" name="kategori" id="kategori">
                            <option value="">Pilih Kategori</option>
                            <option value="penelitian">Penelitian</option>
                            <option value="pengabdian_masyarakat">Pengabdian Masyarakat</option>
                            <option value="pendidikan">Pendidikan</option>
                            <option value="kolaborasi">Kolaborasi</option>
                        </select>
                        <div class="form-text text-muted">Pilih kategori program/kegiatan</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control" name="deskripsi" id="deskripsi" rows="4"></textarea>
                        <div class="form-text text-muted">Berikan deskripsi program/kegiatan yang mendukung pencapaian SDGs</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="gambar" class="form-label">Gambar</label>
                        <input type="file" class="form-control" name="gambar" id="gambar" accept="image/*">
                        <div class="form-text text-muted">Upload gambar program/kegiatan (format: JPG, PNG, max 2MB)</div>
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
                    <h3>Daftar Program & Kegiatan</h3>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-striped" id="program-kegiatan-table">
                        <thead>
                            <tr>
                                <th>Judul</th>
                                <th>Tanggal</th>
                                <th>Kategori</th>
                                <th>Deskripsi</th>
                                <th>Gambar</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="program-kegiatan-list">
                            <!-- Example data, will be replaced with actual data from database -->
                            <tr>
                                <td>Inovasi Teknologi untuk Air Bersih</td>
                                <td>2025-03-01</td>
                                <td>Penelitian</td>
                                <td>Program penelitian untuk mengembangkan teknologi terjangkau bagi masyarakat pedesaan...</td>
                                <td>
                                    <img src="#" alt="Thumbnail" class="img-thumbnail" width="100">
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <button class="btn btn-sm btn-warning">Edit</button>
                                        <button class="btn btn-sm btn-danger">Delete</button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Keberlanjutan Pangan Masyarakat Pesisir</td>
                                <td>2025-02-15</td>
                                <td>Pengabdian Masyarakat</td>
                                <td>Studi tentang ketahanan pangan dan adaptasi perubahan iklim bagi masyarakat pesisir...</td>
                                <td>
                                    <img src="#" alt="Thumbnail" class="img-thumbnail" width="100">
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <button class="btn btn-sm btn-warning">Edit</button>
                                        <button class="btn btn-sm btn-danger">Delete</button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Energi Terbarukan untuk Sekolah</td>
                                <td>2025-01-20</td>
                                <td>Pendidikan</td>
                                <td>Proyek percontohan pemasangan panel surya dan sistem pengelolaan energi di sekolah-sekolah...</td>
                                <td>
                                    <img src="#" alt="Thumbnail" class="img-thumbnail" width="100">
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
        
        .img-thumbnail {
            object-fit: cover;
            height: 60px;
        }

        .btn-group {
            display: flex;
            gap: 5px;
        }

        .table th {
            white-space: nowrap;
        }
        
        #deskripsi {
            resize: vertical;
        }
    </style>
@endsection