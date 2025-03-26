@extends('admin.admin')

@section('contentadmin')
<link rel="stylesheet" href="{{ asset('program_layanan.css') }}">
    <div class="head-title">
        <div class="left">
            <h1>Program Layanan</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="#">Dashboard</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a class="active" href="#">Kelola Program Layanan</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="table-data">
        <div class="order">
            <div class="head">
                <h3>Input Program Layanan</h3>
            </div> 

            <form id="layanan-form">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="icon" class="form-label">Icon</label>
                        <select class="form-select" name="icon" id="icon">
                            <option value="">Pilih Icon</option>
                            <option value="fas fa-graduation-cap">🎓 Pendidikan</option>
                            <option value="fas fa-book">📚 Buku</option>
                            <option value="fas fa-money-bill-wave">💰 Keuangan</option>
                            <option value="fas fa-certificate">🏆 Sertifikasi</option>
                            <option value="fas fa-hands-helping">🤝 Bantuan</option>
                            <option value="fas fa-handshake">👥 Kerjasama</option>
                            <option value="fas fa-users">👨‍👩‍👧‍👦 Komunitas</option>
                            <option value="fas fa-building">🏢 Institusi</option>
                            <option value="fas fa-university">🏛️ Universitas</option>
                            <option value="fas fa-chart-line">📈 Pengembangan</option>
                        </select>
                        <div class="form-text text-muted">Pilih icon yang mewakili program layanan</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="judul" class="form-label">Judul Program</label>
                        <input type="text" class="form-control" name="judul" id="judul">
                        <div class="form-text text-muted">Masukkan judul program layanan (maksimal 50 karakter)</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control" name="deskripsi" id="deskripsi" rows="3"></textarea>
                        <div class="form-text text-muted">Tuliskan deskripsi singkat tentang program layanan (maksimal 200 karakter)</div>
                    </div>
                </div>


                <div class="mb-3 d-flex justify-content-end">
                    <button type="button" class="btn btn-primary" id="simpan-btn">Simpan Program</button>
                </div>
            </form>
        </div>

        <div class="table-data mt-4">
            <div class="order">
                <div class="head">
                    <h3>Daftar Program Layanan</h3>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-striped" id="layanan-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Icon</th>
                                <th>Judul</th>
                                <th>Deskripsi</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td><i class="fas fa-graduation-cap"></i></td>
                                <td>Beasiswa</td>
                                <td>Program beasiswa untuk mahasiswa berprestasi dan kurang mampu, membantu meringankan biaya pendidikan.</td>
                                <td>
                                    <span class="badge bg-success">Aktif</span>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <button class="btn btn-sm btn-warning edit-layanan" data-id="1">
                                            <i class='bx bx-edit'></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger delete-layanan" data-id="1">
                                            <i class='bx bx-trash'></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td><i class="fas fa-hands-helping"></i></td>
                                <td>Bantuan Pendidikan</td>
                                <td>Memberikan bantuan pendidikan berupa subsidi biaya kuliah dan bantuan buku kepada mahasiswa dari keluarga prasejahtera.</td>
                                <td>
                                    <span class="badge bg-success">Aktif</span>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <button class="btn btn-sm btn-warning edit-layanan" data-id="2">
                                            <i class='bx bx-edit'></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger delete-layanan" data-id="2">
                                            <i class='bx bx-trash'></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td><i class="fas fa-certificate"></i></td>
                                <td>Sertifikasi Keahlian</td>
                                <td>Program sertifikasi keahlian profesional bagi mahasiswa dan alumni untuk meningkatkan kompetensi di dunia kerja.</td>
                                <td>
                                    <span class="badge bg-secondary">Non-Aktif</span>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <button class="btn btn-sm btn-warning edit-layanan" data-id="3">
                                            <i class='bx bx-edit'></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger delete-layanan" data-id="3">
                                            <i class='bx bx-trash'></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>                        
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection