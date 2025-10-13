@extends('admin.admin')

@section('contentadmin')
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: { 500: '#0d6d38', 600: '#095629' }
                    }
                }
            }
        }
    </script>

    <!-- Breadcrumb Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Kelola Dokumen</h1>
                <div class="flex items-center text-sm text-gray-600 space-x-2">
                    <a href="#" class="hover:text-primary-500 transition-colors">Dashboard</a>
                    <i class='bx bx-chevron-right'></i>
                    <span class="text-primary-500 font-semibold">Kelola Dokumen</span>
                </div>
            </div>
        </div>
    </div>
    <!-- Alerts -->
    @if(session('success'))
        <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg shadow-sm">
            <div class="flex items-center">
                <i class="fas fa-check-circle text-green-500 text-xl mr-3"></i>
                <div class="flex-1">
                    <p class="text-green-800 font-semibold">{{ session('success') }}</p>
                </div>
                <button onclick="this.parentElement.parentElement.remove()" class="text-green-500 hover:text-green-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    @endif
    
    @if(session('error'))
        <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg shadow-sm">
            <div class="flex items-center">
                <i class="fas fa-exclamation-circle text-red-500 text-xl mr-3"></i>
                <div class="flex-1">
                    <p class="text-red-800 font-semibold">{{ session('error') }}</p>
                </div>
                <button onclick="this.parentElement.parentElement.remove()" class="text-red-500 hover:text-red-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    @endif
    
    @if ($errors->any())
        <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg shadow-sm">
            <div class="flex items-start">
                <i class="fas fa-exclamation-triangle text-red-500 text-xl mr-3 mt-1"></i>
                <div class="flex-1">
                    <p class="text-red-800 font-semibold mb-2">Terjadi kesalahan:</p>
                    <ul class="list-disc list-inside text-red-700 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <button onclick="this.parentElement.parentElement.remove()" class="text-red-500 hover:text-red-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    @endif

    <!-- Input Form -->
    <div class="bg-white rounded-xl shadow-lg p-6 sm:p-8 mb-8 border border-gray-200">
        <div class="flex items-center mb-6 pb-4 border-b border-gray-200">
            <div class="w-10 h-10 bg-primary-500 rounded-lg flex items-center justify-center mr-3">
                <i class="fas fa-file-upload text-white text-lg"></i>
            </div>
            <h3 class="text-2xl font-bold text-gray-800">Input Dokumen Baru</h3>
        </div> 
            <form method="POST" action="{{ route('admin.document.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="category" class="form-label">Kategori</label>
                        <select class="form-select" name="kategori" id="category">
                            <option value="">Pilih Kategori</option>
                            <option value="umum">Umum</option>
                            <option value="pemeringkatan">Pemeringkatan</option>
                            <option value="inovasi">Inovasi</option>
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
                                    <span class="badge 
                                        @if($dokumen->kategori === 'umum') bg-primary
                                        @elseif($dokumen->kategori === 'pemeringkatan') bg-success
                                        @elseif($dokumen->kategori === 'inovasi') bg-info
                                        @endif">
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
                                         <button class="btn btn-sm btn-warning edit-document" 
                                         data-id="{{ $dokumen->id }}"
                                         data-kategori="{{ $dokumen->kategori }}"
                                         data-tanggal="{{ $dokumen->tanggal_publikasi }}"
                                         data-judul="{{ $dokumen->judul_dokumen }}"
                                         data-deskripsi="{{ $dokumen->deskripsi }}">
                                         <i class="fas fa-edit">edit</i>
                                         </button>
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

    <div class="modal fade" id="editDocumentModal" tabindex="-1" role="dialog" aria-labelledby="editDocumentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editDocumentModalLabel">Edit Dokumen</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="edit-document-form" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit_kategori" class="form-label">Kategori</label>
                                <select class="form-select" name="kategori" id="edit_kategori">
                                    <option value="umum">Umum</option>
                                    <option value="pemeringkatan">Pemeringkatan</option>
                                    <option value="inovasi">Inovasi</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_tanggal" class="form-label">Tanggal Publikasi</label>
                                <input type="date" class="form-control" name="tanggal" id="edit_tanggal">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="edit_judul_dokumen" class="form-label">Judul Dokumen</label>
                                <input type="text" class="form-control" name="judul_dokumen" id="edit_judul_dokumen">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="edit_deskripsi" class="form-label">Deskripsi Dokumen</label>
                                <textarea class="form-control" name="deskripsi" id="edit_deskripsi" rows="3"></textarea>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 mb-3">
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- <script src="{{ asset('resources/movejs/document.js') }}"></script> --}}

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Edit Document Modal
        document.querySelectorAll('.edit-document').forEach(button => {
            button.addEventListener('click', function() {
                const docId = this.dataset.id;
                const modal = new bootstrap.Modal(document.getElementById('editDocumentModal'));
                
                // Mengisi form dengan data dari atribut data
                document.getElementById('edit_kategori').value = this.dataset.kategori;
                document.getElementById('edit_tanggal').value = this.dataset.tanggal;
                document.getElementById('edit_judul_dokumen').value = this.dataset.judul;
                document.getElementById('edit_deskripsi').value = this.dataset.deskripsi;
        
                // Set action form untuk update
                document.getElementById('edit-document-form').action = `/admin/document/${docId}`;
                
                // Tampilkan modal
                modal.show();
            });
        });

        // Handle form submission feedback
        const editForm = document.getElementById('edit-document-form');
        if (editForm) {
            editForm.addEventListener('submit', function(e) {
                const submitButton = this.querySelector('button[type="submit"]');
                submitButton.disabled = true;
                submitButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Menyimpan...';
            });
        }
    });
        // Handle delete confirmation
        document.querySelectorAll('.delete-dokumen').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const form = this.closest('form');
                
                Swal.fire({
                    title: 'Konfirmasi Hapus',
                    text: "Apakah Anda yakin ingin menghapus dokumen ini?",
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
    </script>
@endsection