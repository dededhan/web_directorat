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

            <form method="POST" action="{{ route('admin.document.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="category" class="form-label">Kategori</label>
                        <select class="form-select" name="kategori" id="category">
                            <option value="">Pilih Kategori</option>
                            <option value="pdf">PDF Document</option>
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
                            @foreach($dokumens as $dokumen)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <span class="badge {{ $dokumen->kategori === 'pdf' ? 'bg-danger' : 'bg-primary' }}">
                                        {{ strtoupper($dokumen->kategori) }}
                                    </span>
                                </td>
                                <td>{{ $dokumen->tanggal_publikasi }}</td>
                                <td>{{ $dokumen->judul_dokumen }}</td>
                                <td>
                                    @if($dokumen->ukuran > 1000000)
                                        {{ number_format($dokumen->ukuran / 1048576, 1) }} MB
                                    @else
                                        {{ number_format($dokumen->ukuran / 1024, 0) }} KB
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.document.download', $dokumen->id) }}" 
                                            class="btn btn-sm btn-info" 
                                            title="Download {{ $dokumen->nama_file }}">
                                             Download
                                         </a>
                                         <form action="{{ route('admin.document.destroy', $dokumen) }}" method="POST" >
                                         @csrf
                                         @method('DELETE')
                                         <button type="submit" class="btn btn-sm btn-danger delete-dokumen">
                                             Delete
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


    <script src="{{ asset('admin/document.js') }}"></script>
@endsection