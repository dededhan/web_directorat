@extends('admin.admin')

@section('contentadmin')
    <div class="head-title">
        <div class="left">
            <h1>Manajemen Berita</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="#">Dashboard</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a class="active" href="#">Berita</a>
                </li>
            </ul>
        </div>
        <a href="#" class="btn-download" data-bs-toggle="modal" data-bs-target="#addNewsModal">
            <i class='bx bxs-plus-circle'></i>
            <span class="text">Tambah Berita</span>
        </a>
    </div>

    <div class="table-data">
        <div class="order">
            <div class="head">
                <h3>Daftar Berita</h3>
                <i class='bx bx-search'></i>
                <i class='bx bx-filter'></i>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Judul Berita</th>
                        <th>Kategori</th>
                        <th>Tanggal Publikasi</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <p>Pembukaan Pendaftaran Mahasiswa Baru</p>
                        </td>
                        <td>Akademik</td>
                        <td>01-10-2023</td>
                        <td><span class="status completed">Published</span></td>
                        <td>
                            <div class="action-buttons">
                                <a href="#" class="btn-edit" title="Edit">
                                    <i class='bx bxs-edit'></i>
                                </a>
                                <a href="#" class="btn-delete" title="Delete">
                                    <i class='bx bxs-trash'></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="addNewsModal" tabindex="-1" aria-labelledby="addNewsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addNewsModalLabel">Tambah Berita Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/news/store" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="newsTitle" class="form-label">Judul Berita</label>
                            <input type="text" class="form-control" id="newsTitle" name="title" required>
                        </div>
                        <div class="mb-3">
                            <label for="newsCategory" class="form-label">Kategori</label>
                            <select class="form-select" id="newsCategory" name="category" required>
                                <option value="">Pilih Kategori</option>
                                <option value="akademik">Akademik</option>
                                <option value="event">Event</option>
                                <option value="pengumuman">Pengumuman</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="newsContent" class="form-label">Konten Berita</label>
                            <textarea class="form-control" id="newsContent" name="content" rows="6" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="newsThumbnail" class="form-label">Thumbnail</label>
                            <input type="file" class="form-control" id="newsThumbnail" name="thumbnail" accept="image/*" required>
                        </div>
                        <div class="mb-3">
                            <label for="newsStatus" class="form-label">Status</label>
                            <select class="form-select" id="newsStatus" name="status" required>
                                <option value="draft">Draft</option>
                                <option value="published">Published</option>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan Berita</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        .form-label {
            font-weight: bold;
        }
        .table-data {
            margin-top: 24px;
        }
        .btn-download {
            background-color: #3498db;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
        }
        .btn-download:hover {
            background-color: #2980b9;
        }
        .btn-edit {
            background-color: #f39c12;
            padding: 5px 10px;
            border-radius: 3px;
            color: white;
        }
        .btn-delete {
            background-color: #e74c3c;
            padding: 5px 10px;
            border-radius: 3px;
            color: white;
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
@endsection
