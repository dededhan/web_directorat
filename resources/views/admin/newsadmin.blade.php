@extends('admin.admin')

@section('contentadmin')
    <div class="head-title">
        <div class="left">
            <h1>Berita</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="#">Dashboard</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a class="active" href="#">Kelola Berita</a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Flash Messages -->
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

    <div class="table-data">
        <div class="order">
            <div class="head">
                <h3>Input Berita</h3>
            </div> 

            <form method="POST" action="{{ route('admin.news.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="category" class="form-label">Kategori</label>
                        <select class="form-select @error('kategori') is-invalid @enderror" name="kategori" id="category">
                            <option value="">Pilih Kategori</option>
                            <option value="inovasi" {{ old('kategori') == 'inovasi' ? 'selected' : '' }}>Inovasi</option>
                            <option value="pemeringkatan" {{ old('kategori') == 'pemeringkatan' ? 'selected' : '' }}>Pemeringkatan</option>
                        </select>
                        @error('kategori')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text text-muted">Pilih kategori berita yang sesuai</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="tanggal" class="form-label">Tanggal</label>
                        <input type="date" class="form-control @error('tanggal') is-invalid @enderror" name="tanggal" id="tanggal" value="{{ old('tanggal') }}">
                        @error('tanggal')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text text-muted">Pilih tanggal publikasi berita</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="judul_berita" class="form-label">Judul Berita</label>
                        <input type="text" class="form-control @error('judul_berita') is-invalid @enderror" name="judul_berita" id="judul_berita" value="{{ old('judul_berita') }}">
                        @error('judul_berita')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text text-muted">Masukkan judul berita (maksimal 200 karakter)</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="isi_berita" class="form-label">Isi Berita</label>
                        <textarea class="form-control @error('isi_berita') is-invalid @enderror" name="isi_berita" id="isi_berita" rows="8">{{ old('isi_berita') }}</textarea>
                        @error('isi_berita')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text text-muted">Tuliskan isi berita secara lengkap dan detail</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="gambar" class="form-label">Gambar</label>
                        <input type="file" class="form-control @error('gambar') is-invalid @enderror" name="gambar" id="gambar" accept="image/*">
                        @error('gambar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text text-muted">Upload gambar utama berita (format: JPG, PNG, atau JPEG, max 2MB)</div>
                    </div>
                </div>

                <div class="mb-3 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Simpan Berita</button>
                </div>
            </form>
        </div>

        <div class="table-data mt-4">
            <div class="order">
                <div class="head">
                    <h3>Daftar Berita</h3>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-striped" id="berita-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kategori</th>
                                <th>Tanggal</th>
                                <th>Judul Berita</th>
                                <th>Isi</th>
                                <th>Gambar</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($beritas as $index => $berita)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <span class="badge bg-{{ [
                                        'inovasi' => 'primary',
                                        'pemeringkatan' => 'success'
                                    ][$berita->kategori] }}">
                                        {{ ucfirst($berita->kategori) }}
                                    </span>
                                </td>
                                <td>{{ $berita->tanggal}}</td>
                                <td>{{ $berita->judul }}</td>
                                <td>{{ Str::limit(strip_tags($berita->isi), 50) }}</td>
                                <td>
                                    <button class="btn btn-sm btn-info view-image" 
                                        data-image="{{ asset('storage/'.$berita->gambar) }}"
                                        data-title="{{ $berita->judul }}">
                                        Lihat Gambar
                                    </button>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <form method="POST" action="{{ route('admin.news.destroy', $berita->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus berita ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
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

    <!-- Modal untuk menampilkan gambar -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel">Gambar Berita</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalImage" src="" class="img-fluid" alt="Gambar Berita">
                </div>
            </div>
        </div>
    </div>

    <script>
        // Inisialisasi text editor untuk isi berita
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof ClassicEditor !== 'undefined') {
                ClassicEditor
                    .create(document.querySelector('#isi_berita'))
                    .catch(error => {
                        console.error(error);
                    });
            }
            
            // Auto-hide alerts after 5 seconds
            setTimeout(function() {
                document.querySelectorAll('.alert').forEach(function(alert) {
                    var bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                });
            }, 5000);

            // Handle view image
            document.querySelectorAll('.view-image').forEach(button => {
                button.addEventListener('click', function() {
                    const imageUrl = this.dataset.image;
                    const title = this.dataset.title;
                    
                    document.getElementById('imageModalLabel').textContent = title;
                    document.getElementById('modalImage').src = imageUrl;
                    
                    new bootstrap.Modal(document.getElementById('imageModal')).show();
                });
            });
        });
    </script>

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
        
        .badge {
            font-size: 0.7em;
        }

        .btn-group {
            display: flex;
            gap: 5px;
        }

        textarea {
            resize: vertical;
        }
        
        .table th {
            white-space: nowrap;
        }
        
        /* Custom styles for the news management */
        .ck-editor__editable {
            min-height: 300px;
        }
        
        #modalImage {
            max-height: 70vh;
        }
        
        /* Alert styling */
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 10px;
        }
        
        .alert-success {
            background-color: #d4edda;
            border-color: #c3e6cb;
            color: #155724;
        }
        
        .alert-danger {
            background-color: #f8d7da;
            border-color: #f5c6cb;
            color: #721c24;
        }
    </style>
@endsection