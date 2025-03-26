@extends('admin.admin')

@section('contentadmin')
    <link rel="stylesheet" href="{{ asset('news_scroll.css') }}">
    <div class="head-title">
        <div class="left">
            <h1>Pengumuman Berjalan</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="#">Dashboard</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a class="active" href="#">Kelola Pengumuman</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="table-data">
        <div class="order">
            <div class="head">
                <h3>Input Pengumuman</h3>
            </div> 

            <form id="pengumuman-form" action="{{ route('admin.news-scroll.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="judul_pengumuman" class="form-label">Judul Pengumuman</label>
                        <input type="text" class="form-control" name="judul_pengumuman" id="judul_pengumuman">
                        <div class="form-text text-muted">Masukkan judul pengumuman yang akan disorot (maksimal 50 karakter)</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="icon" class="form-label">Icon</label>
                        <select class="form-select" name="icon" id="icon">
                            <option value="">Tanpa Icon</option>
                            <option value="🕌">🕌 Masjid</option>
                            <option value="📚">📚 Buku</option>
                            <option value="🎓">🎓 Wisuda</option>
                            <option value="📣">📣 Pengumuman</option>
                            <option value="🏆">🏆 Prestasi</option>
                            <option value="💰">💰 Beasiswa</option>
                            <option value="🔬">🔬 Penelitian</option>
                            <option value="🎭">🎭 Event</option>
                            <option value="🏫">🏫 Kampus</option>
                            <option value="⚠️">⚠️ Peringatan</option>
                        </select>
                        <div class="form-text text-muted">Pilih icon yang akan ditampilkan di awal pengumuman</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="isi_pengumuman" class="form-label">Isi Pengumuman</label>
                        <textarea class="form-control" name="isi_pengumuman" id="isi_pengumuman" rows="3"></textarea>
                        <div class="form-text text-muted">Tuliskan isi pengumuman yang akan ditampilkan (maksimal 200 karakter)</div>
                    </div>
                </div>

                <div class="mb-3 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary" id="simpan-btn">Simpan Pengumuman</button>
                </div>
            </form>
        </div>

        <div class="table-data mt-4">
            <div class="order">
                <div class="head">
                    <h3>Daftar Pengumuman Berjalan</h3>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-striped" id="pengumuman-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Icon</th>
                                <th>Judul</th>
                                <th>Isi</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pengumumans as $index => $pengumuman)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $pengumuman->icon }}</td>
                                <td>{{ $pengumuman->judul_pengumuman }}</td>
                                <td>{{ $pengumuman->isi_pengumuman }}</td>
                                <td>
                                    <span class="badge bg-{{ $pengumuman->status ? 'success' : 'secondary' }}">
                                        {{ $pengumuman->status ? 'Aktif' : 'Non-Aktif' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.news-scroll.edit', $pengumuman->id) }}" class="btn btn-sm btn-warning">
                                            <i class='bx bx-edit'></i>
                                        </a>
                                        <form action="{{ route('admin.news-scroll.destroy', $pengumuman->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class='bx bx-trash'></i>
                                            </button>
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

    <script src="{{ asset('news_scroll.js') }}"></script>
@endsection