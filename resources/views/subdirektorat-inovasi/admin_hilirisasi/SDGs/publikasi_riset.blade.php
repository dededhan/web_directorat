@extends('subdirektorat-inovasi.admin_hilirisasi.index')

@section('content-admin-hilirisasi')
    <div class="head-title">
        <div class="left">
            <h1>Publikasi & Riset</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a class="active" href="#">Input Publikasi & Riset</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="table-data">
        <div class="order">
            <div class="head">
                <h3>Input Publikasi & Riset</h3>
            </div> 

            <form id="publikasi-riset-form" action="#" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="judul" class="form-label">Judul</label>
                        <input type="text" class="form-control" name="judul" id="judul">
                        <div class="form-text text-muted">Masukkan judul penelitian atau publikasi</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="penulis" class="form-label">Penulis/Author</label>
                        <input type="text" class="form-control" name="penulis" id="penulis">
                        <div class="form-text text-muted">Masukkan nama penulis/peneliti dengan format: Dr. Nama Lengkap, Gelar</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control" name="deskripsi" id="deskripsi" rows="4"></textarea>
                        <div class="form-text text-muted">Ringkasan publikasi/penelitian terkait pembangunan berkelanjutan</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="gambar" class="form-label">Gambar</label>
                        <input type="file" class="form-control" name="gambar" id="gambar" accept="image/*">
                        <div class="form-text text-muted">Upload gambar yang mewakili publikasi (format: JPG, PNG, max 2MB)</div>
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
                    <h3>Daftar Publikasi & Riset</h3>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-striped" id="publikasi-riset-table">
                        <thead>
                            <tr>
                                <th>Judul</th>
                                <th>Penulis/Author</th>
                                <th>Deskripsi</th>
                                <th>Gambar</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="publikasi-riset-list">
                            <!-- Example data, will be replaced with actual data from database -->
                            <tr>
                                <td>Implementasi SDGs di Tingkat Kota: Studi Kasus Jakarta</td>
                                <td>Dr. Ahmad Syafii, Dr. Rina Wijaya</td>
                                <td>Penelitian ini menganalisis bagaimana kota Jakarta mengintegrasikan tujuan pembangunan berkelanjutan ke dalam perencanaan kota dan dampaknya terhadap kebijakan publik.</td>
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
                                <td>Pendidikan untuk Pembangunan Berkelanjutan: Model Kurikulum Terintegrasi</td>
                                <td>Prof. Budi Santoso, Endang Kusuma, M.Pd.</td>
                                <td>Studi ini mengembangkan dan mengevaluasi model kurikulum yang mengintegrasikan prinsip SDGs dalam sistem pendidikan formal di Indonesia.</td>
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
                                <td>Ekonomi Sirkular sebagai Solusi Pengelolaan Sampah Perkotaan</td>
                                <td>Dr. Dian Pratiwi, Hendri Wijaya, M.Si.</td>
                                <td>Penelitian ini mempelajari penerapan prinsip ekonomi sirkular dalam manajemen sampah perkotaan dan potensinya untuk mengurangi limbah.</td>
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