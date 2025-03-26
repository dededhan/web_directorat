@extends('admin.admin')
<link rel="stylesheet" href="{{ asset('dashboard_main/document_dashboard.css') }}">
@section('contentadmin')
    <div class="head-title">
        <div class="left">
            <h1>Dokumen</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="#">Dashboard</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a class="active" href="#">Kelola Dokumen</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="table-data">
        <div class="order">
            <div class="head">
                <h3>Input Dokumen</h3>
            </div> 

            <form method="POST" action="#" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="category" class="form-label">Kategori</label>
                        <select class="form-select" name="kategori" id="category">
                            <option value="">Pilih Kategori</option>
                            <option value="pdf">PDF Document</option>
                            <option value="docx">Word Document</option>
                        </select>
                        <div class="form-text text-muted">Pilih kategori dokumen yang sesuai</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="tanggal" class="form-label">Tanggal Publikasi</label>
                        <input type="date" class="form-control" name="tanggal" id="tanggal">
                        <div class="form-text text-muted">Pilih tanggal publikasi dokumen</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="judul_dokumen" class="form-label">Judul Dokumen</label>
                        <input type="text" class="form-control" name="judul_dokumen" id="judul_dokumen">
                        <div class="form-text text-muted">Masukkan judul dokumen (maksimal 200 karakter)</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi Dokumen</label>
                        <textarea class="form-control" name="deskripsi" id="deskripsi" rows="3"></textarea>
                        <div class="form-text text-muted">Tuliskan deskripsi singkat tentang dokumen (opsional)</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="file_dokumen" class="form-label">File Dokumen</label>
                        <input type="file" class="form-control" name="file_dokumen" id="file_dokumen" accept=".pdf,.docx,.doc">
                        <div class="form-text text-muted">Upload file dokumen (format: PDF, DOC, atau DOCX, maks 10MB)</div>
                    </div>
                </div>

                <div class="mb-3 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Simpan Dokumen</button>
                </div>
            </form>
        </div>

        <div class="table-data mt-4">
            <div class="order">
                <div class="head">
                    <h3>Daftar Dokumen</h3>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-striped" id="dokumen-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kategori</th>
                                <th>Tanggal</th>
                                <th>Judul Dokumen</th>
                                <th>Ukuran</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Contoh data statis untuk tampilan -->
                            <tr>
                                <td>1</td>
                                <td>
                                    <span class="badge bg-danger">
                                        PDF
                                    </span>
                                </td>
                                <td>2025-03-15</td>
                                <td>Peraturan Rektor No. 5 Tahun 2025</td>
                                <td>2.4 MB</td>
                                <td>
                                    <div class="btn-group">
                                        <button class="btn btn-sm btn-info">Download</button>
                                        <button class="btn btn-sm btn-danger delete-dokumen">Delete</button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>
                                    <span class="badge bg-primary">
                                        Word
                                    </span>
                                </td>
                                <td>2025-03-20</td>
                                <td>Pedoman Green Campus Initiative</td>
                                <td>856 KB</td>
                                <td>
                                    <div class="btn-group">
                                        <button class="btn btn-sm btn-info">Download</button>
                                        <button class="btn btn-sm btn-danger delete-dokumen">Delete</button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>                        
                    </table>
                </div>
            </div>
        </div>
    </div>


    <script src="{{ asset('admin/document.js') }}"></script>
@endsection