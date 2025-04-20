@extends('admin.admin')

@section('contentadmin')
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
                <h3>Input Publikasi & Riset</h3>
            </div> 

            <form id="publikasi-riset-form" action="{{ route('admin.SDGs.publikasi-riset.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="kategori" class="form-label">Kategori</label>
                        <select class="form-select" name="kategori" id="kategori">
                            <option value="">Pilih Kategori</option>
                            <option value="jurnal">Jurnal</option>
                            <option value="prosiding">Prosiding</option>
                            <option value="buku">Buku</option>
                            <option value="penelitian">Penelitian</option>
                        </select>
                        <div class="form-text text-muted">Pilih kategori publikasi/riset</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="tanggal_publikasi" class="form-label">Tanggal Publikasi</label>
                        <input type="date" class="form-control" name="tanggal_publikasi" id="tanggal_publikasi">
                        <div class="form-text text-muted">Pilih tanggal publikasi</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="judul" class="form-label">Judul</label>
                        <input type="text" class="form-control" name="judul" id="judul" value="{{ old('judul') }}">
                        <div class="form-text text-muted">Masukkan judul penelitian atau publikasi</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="penulis" class="form-label">Penulis/Author</label>
                        <input type="text" class="form-control" name="penulis" id="penulis" value="{{ old('penulis') }}">
                        <div class="form-text text-muted">Masukkan nama penulis/peneliti dengan format: Dr. Nama Lengkap, Gelar</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control" name="deskripsi" id="deskripsi" rows="4">{{ old('deskripsi') }}</textarea>
                        <div class="form-text text-muted">Ringkasan publikasi/penelitian terkait pembangunan berkelanjutan</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="gambar" class="form-label">Gambar</label>
                        <input type="file" class="form-control" name="gambar" id="gambar" accept="image/*">
                        <div class="form-text text-muted">Upload gambar yang mewakili publikasi (format: JPG, PNG, max 2MB)</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="file_dokumen" class="form-label">File Dokumen</label>
                        <input type="file" class="form-control" name="file_dokumen" id="file_dokumen" accept=".pdf,.docx,.doc">
                        <div class="form-text text-muted">Upload file dokumen (format: PDF, DOC, atau DOCX, maks 10MB)</div>
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
                                <th>No</th>
                                <th>Kategori</th>
                                <th>Judul</th>
                                <th>Penulis</th>
                                <th>Tanggal</th>
                                <th>Gambar</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($publikasiRiset as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <span class="badge 
                                        @if($item->kategori === 'jurnal') bg-primary
                                        @elseif($item->kategori === 'prosiding') bg-success
                                        @elseif($item->kategori === 'buku') bg-info
                                        @elseif($item->kategori === 'penelitian') bg-warning
                                        @endif">
                                        {{ strtoupper($item->kategori) }}
                                    </span>
                                </td>
                                <td>{{ $item->judul }}</td>
                                <td>{{ $item->penulis }}</td>
                                <td>{{ $item->tanggal_publikasi }}</td>
                                <td>
                                    @if($item->gambar_path)
                                        <img src="{{ asset('storage/'.$item->gambar_path) }}" alt="Thumbnail" class="img-thumbnail" width="100">
                                    @else
                                        <span class="text-muted">No Image</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group">
                                        @if($item->file_path)
                                            <a href="{{ route('admin.SDGs.publikasi-riset.download', $item->id) }}" 
                                                class="btn btn-sm btn-info" 
                                                title="Download {{ $item->file_nama }}">
                                                Download
                                            </a>
                                        @endif
                                        <button class="btn btn-sm btn-warning edit-publikasi" 
                                            data-id="{{ $item->id }}"
                                            data-kategori="{{ $item->kategori }}"
                                            data-tanggal="{{ $item->tanggal_publikasi }}"
                                            data-judul="{{ $item->judul }}"
                                            data-penulis="{{ $item->penulis }}"
                                            data-deskripsi="{{ $item->deskripsi }}">
                                            Edit
                                        </button>
                                        <form action="{{ route('admin.SDGs.publikasi-riset.destroy', $item->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger delete-publikasi">
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

    <!-- Edit Modal -->
    <div class="modal fade" id="editPublikasiModal" tabindex="-1" role="dialog" aria-labelledby="editPublikasiModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPublikasiModalLabel">Edit Publikasi & Riset</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="edit-publikasi-form" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit_kategori" class="form-label">Kategori</label>
                                <select class="form-select" name="kategori" id="edit_kategori">
                                    <option value="jurnal">Jurnal</option>
                                    <option value="prosiding">Prosiding</option>
                                    <option value="buku">Buku</option>
                                    <option value="penelitian">Penelitian</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_tanggal_publikasi" class="form-label">Tanggal Publikasi</label>
                                <input type="date" class="form-control" name="tanggal_publikasi" id="edit_tanggal_publikasi">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="edit_judul" class="form-label">Judul</label>
                                <input type="text" class="form-control" name="judul" id="edit_judul">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="edit_penulis" class="form-label">Penulis/Author</label>
                                <input type="text" class="form-control" name="penulis" id="edit_penulis">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="edit_deskripsi" class="form-label">Deskripsi</label>
                                <textarea class="form-control" name="deskripsi" id="edit_deskripsi" rows="4"></textarea>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit_gambar" class="form-label">Gambar (Opsional)</label>
                                <input type="file" class="form-control" name="gambar" id="edit_gambar">
                                <div class="form-text text-muted">Biarkan kosong jika tidak ingin mengubah gambar</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_file_dokumen" class="form-label">File Dokumen (Opsional)</label>
                                <input type="file" class="form-control" name="file_dokumen" id="edit_file_dokumen">
                                <div class="form-text text-muted">Biarkan kosong jika tidak ingin mengubah file</div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Include jQuery if not already included -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Include Bootstrap JS and SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Edit Document Modal
        document.querySelectorAll('.edit-publikasi').forEach(button => {
            button.addEventListener('click', function() {
                const docId = this.dataset.id;
                const modal = new bootstrap.Modal(document.getElementById('editPublikasiModal'));
                
                // Mengisi form dengan data dari atribut data
                document.getElementById('edit_kategori').value = this.dataset.kategori;
                document.getElementById('edit_tanggal_publikasi').value = this.dataset.tanggal;
                document.getElementById('edit_judul').value = this.dataset.judul;
                document.getElementById('edit_penulis').value = this.dataset.penulis;
                document.getElementById('edit_deskripsi').value = this.dataset.deskripsi;
        
                // Set action form untuk update
                document.getElementById('edit-publikasi-form').action = `/admin/SDGs/publikasi-riset/${docId}`;
                
                // Tampilkan modal
                modal.show();
            });
        });

        // Handle form submission feedback
        const editForm = document.getElementById('edit-publikasi-form');
        if (editForm) {
            editForm.addEventListener('submit', function(e) {
                const submitButton = this.querySelector('button[type="submit"]');
                submitButton.disabled = true;
                submitButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Menyimpan...';
            });
        }

        // Handle delete confirmation
        document.querySelectorAll('.delete-publikasi').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const form = this.closest('form');
                
                Swal.fire({
                    title: 'Konfirmasi Hapus',
                    text: "Apakah Anda yakin ingin menghapus publikasi/riset ini?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });

        // Handle flash messages with SweetAlert
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
        
        #deskripsi, #edit_deskripsi {
            resize: vertical;
        }
    </style>
@endsection