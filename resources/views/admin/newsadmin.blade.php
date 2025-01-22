@extends('admin.admin')

@section('contentadmin')
    <div class="head-title">
        <div class="left">
            <h1>Manajemen Berita</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
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

    <!-- News List -->
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
                    <tr>
                        <td>
                            <p>Workshop Kewirausahaan 2023</p>
                        </td>
                        <td>Event</td>
                        <td>28-09-2023</td>
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
                    <tr>
                        <td>
                            <p>Pengumuman Libur Nasional</p>
                        </td>
                        <td>Pengumuman</td>
                        <td>25-09-2023</td>
                        <td><span class="status pending">Draft</span></td>
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

    <!-- Add News Modal -->
    <div class="modal fade" id="addNewsModal" tabindex="-1" aria-labelledby="addNewsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addNewsModalLabel">Tambah Berita Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="newsTitle" class="form-label">Judul Berita</label>
                            <input type="text" class="form-control" id="newsTitle" required>
                        </div>
                        <div class="mb-3">
                            <label for="newsCategory" class="form-label">Kategori</label>
                            <select class="form-select" id="newsCategory" required>
                                <option value="">Pilih Kategori</option>
                                <option value="akademik">Akademik</option>
                                <option value="event">Event</option>
                                <option value="pengumuman">Pengumuman</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="newsContent" class="form-label">Konten Berita</label>
                            <textarea class="form-control" id="newsContent" rows="6" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="newsThumbnail" class="form-label">Thumbnail</label>
                            <input type="file" class="form-control" id="newsThumbnail">
                        </div>
                        <div class="mb-3">
                            <label for="newsStatus" class="form-label">Status</label>
                            <select class="form-select" id="newsStatus" required>
                                <option value="draft">Draft</option>
                                <option value="published">Published</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary">Simpan Berita</button>
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

        .order table {
            width: 100%;
            margin-top: 16px;
        }

        .order table th {
            padding: 12px 10px;
            text-align: left;
            background: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
        }

        .order table td {
            padding: 12px 10px;
            border-bottom: 1px solid #dee2e6;
        }

        .status {
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: 500;
        }

        .status.completed {
            background: #e6f4ea;
            color: #1e8449;
        }

        .status.pending {
            background: #fff3e0;
            color: #e67e22;
        }

        .action-buttons {
            display: flex;
            gap: 8px;
        }

        .btn-edit, .btn-delete {
            padding: 6px;
            border-radius: 6px;
            color: #fff;
            text-decoration: none;
        }

        .btn-edit {
            background: #3498db;
        }

        .btn-delete {
            background: #e74c3c;
        }

        .btn-edit:hover, .btn-delete:hover {
            opacity: 0.8;
        }

        .modal-content {
            border-radius: 15px;
        }

        .modal-header {
            background: #f8f9fa;
            border-radius: 15px 15px 0 0;
        }

        .form-control:focus, .form-select:focus {
            border-color: #3498db;
            box-shadow: none;
        }
    </style>

    <!-- Make sure you have Bootstrap JavaScript included in your admin.blade.php -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
@endsection