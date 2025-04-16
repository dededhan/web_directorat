@extends('admin.admin')

<script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@section('contentadmin')
    <div class="head-title">
        <div class="left">
            <h1>Produk Inovasi</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="#">Dashboard</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a href="#">Katsinov</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a class="active" href="#">Produk Inovasi</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="table-data">
        <div class="order">
            <div class="head">
                <h3>Input Produk Inovasi</h3>
            </div>

            <form method="POST" action="{{ route('admin.Katsinov.produk_inovasi.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nama_produk" class="form-label">Nama Produk</label>
                        <input type="text" class="form-control @error('nama_produk') is-invalid @enderror"
                            name="nama_produk" id="nama_produk" value="{{ old('nama_produk') }}">
                        @error('nama_produk')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text text-muted">Masukkan nama produk inovasi</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="inovator" class="form-label">Inovator</label>
                        <input type="text" class="form-control @error('inovator') is-invalid @enderror" 
                            name="inovator" id="inovator" value="{{ old('inovator') }}">
                        @error('inovator')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text text-muted">Masukkan nama inovator/penemu</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="nomor_paten" class="form-label">Nomor Paten</label>
                        <input type="text" class="form-control @error('nomor_paten') is-invalid @enderror"
                            name="nomor_paten" id="nomor_paten" value="{{ old('nomor_paten') }}">
                        @error('nomor_paten')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text text-muted">Masukkan nomor paten (opsional)</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi Produk</label>
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" name="deskripsi" id="deskripsi"
                            rows="8">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text text-muted">Tuliskan deskripsi produk secara lengkap dan detail</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="gambar" class="form-label">Gambar Produk</label>
                        <input type="file" class="form-control @error('gambar') is-invalid @enderror" name="gambar"
                            id="gambar" accept="image/*">
                        @error('gambar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text text-muted">Upload gambar produk (format: JPG, PNG, atau JPEG, max 2MB)
                        </div>
                    </div>
                </div>

                <div class="mb-3 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Simpan Produk</button>
                </div>
            </form>
        </div>

        <div class="table-data mt-4">
            <div class="order">
                <div class="head">
                    <h3>Daftar Produk Inovasi</h3>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped" id="produk-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Produk</th>
                                <th>Inovator</th>
                                <th>Nomor Paten</th>
                                <th>Deskripsi</th>
                                <th>Gambar</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($produkInovasi as $index => $produk)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $produk->nama_produk }}</td>
                                    <td>{{ $produk->inovator }}</td>
                                    <td>{{ $produk->nomor_paten ?? '-' }}</td>
                                    <td>{{ Str::limit(strip_tags($produk->deskripsi), 50) }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-info view-image"
                                            data-image="{{ asset('storage/' . $produk->gambar) }}"
                                            data-title="{{ $produk->nama_produk }}">
                                            Lihat Gambar
                                        </button>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-sm btn-warning edit-produk"
                                                data-id="{{ $produk->id }}">
                                                Edit
                                            </button>
                                            <form method="POST" action="{{ route('admin.Katsinov.produk_inovasi.destroy', $produk->id) }}"
                                                class="delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button"
                                                    class="btn btn-sm btn-danger delete-btn">Delete</button>
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
                    <h5 class="modal-title" id="imageModalLabel">Gambar Produk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalImage" src="" class="img-fluid" alt="Gambar Produk">
                </div>
            </div>
        </div>
    </div>

    <!-- Modal untuk mengedit produk -->
    <div class="modal fade" id="editProdukModal" tabindex="-1" aria-labelledby="editProdukModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProdukModalLabel">Edit Produk Inovasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editProdukForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit_nama_produk" class="form-label">Nama Produk</label>
                                <input type="text" class="form-control" name="nama_produk" id="edit_nama_produk">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_inovator" class="form-label">Inovator</label>
                                <input type="text" class="form-control" name="inovator" id="edit_inovator">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="edit_nomor_paten" class="form-label">Nomor Paten</label>
                                <input type="text" class="form-control" name="nomor_paten" id="edit_nomor_paten">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="edit_deskripsi" class="form-label">Deskripsi Produk</label>
                                <textarea class="form-control" name="deskripsi" id="edit_deskripsi" rows="8"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="edit_gambar" class="form-label">Gambar Baru (opsional)</label>
                                <input type="file" class="form-control" name="gambar" id="edit_gambar"
                                    accept="image/*">
                                <div class="mt-2">
                                    <p>Gambar saat ini:</p>
                                    <img id="current_image" src="" class="img-fluid mt-2"
                                        style="max-height: 200px;" alt="Current Image">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="saveEditProduk">Simpan Perubahan</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>
    <script>
        // Custom upload adapter
        class MyUploadAdapter {
            constructor(loader) {
                this.loader = loader;
            }
    
            upload() {
                return this.loader.file.then(file => new Promise((resolve, reject) => {
                    const data = new FormData();
                    data.append('upload', file);
                    data.append('_token', '{{ csrf_token() }}');
    
                    fetch('{{ route("admin.Katsinov.produk_inovasi.upload") }}', {
                        method: 'POST',
                        body: data
                    })
                    .then(response => response.json())
                    .then(result => {
                        if (result.error) {
                            return reject(result.error.message);
                        }
                        resolve({
                            default: result.url
                        });
                    })
                    .catch(error => {
                        reject('Upload failed: ' + error.message);
                    });
                }));
            }
    
            abort() {
                return Promise.reject();
            }
        }
    
        function MyCustomUploadAdapterPlugin(editor) {
            editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
                return new MyUploadAdapter(loader);
            };
        }
    
        // Initialize CKEditor for new produk
        ClassicEditor
            .create(document.querySelector('#deskripsi'), {
                extraPlugins: [MyCustomUploadAdapterPlugin],
                toolbar: {
                    items: [
                        'heading', '|',
                        'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|',
                        'imageUpload', 'blockQuote', 'undo', 'redo'
                    ]
                },
                image: {
                    toolbar: ['imageTextAlternative', 'imageStyle:inline', 'imageStyle:block', 'imageStyle:side']
                }
            })
            .catch(error => {
                console.error(error);
            });
    
        // Initialize CKEditor for edit form
        let editDeskripsiEditor;
        ClassicEditor
            .create(document.querySelector('#edit_deskripsi'), {
                extraPlugins: [MyCustomUploadAdapterPlugin],
                toolbar: {
                    items: [
                        'heading', '|',
                        'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|',
                        'imageUpload', 'blockQuote', 'undo', 'redo'
                    ]
                },
                image: {
                    toolbar: ['imageTextAlternative', 'imageStyle:inline', 'imageStyle:block', 'imageStyle:side']
                }
            })
            .then(editor => {
                editDeskripsiEditor = editor;
            })
            .catch(error => {
                console.error(error);
            });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // SweetAlert helper functions
            function showSuccessAlert(message) {
                Swal.fire({
                    title: 'Berhasil!',
                    text: message,
                    icon: 'success',
                    confirmButtonColor: '#3498db',
                    confirmButtonText: 'OK'
                });
            }
        
            function showErrorAlert(message) {
                Swal.fire({
                    title: 'Gagal!',
                    text: message,
                    icon: 'error',
                    confirmButtonColor: '#3498db',
                    confirmButtonText: 'OK'
                });
            }
        
            function showConfirmationDialog(message, callback) {
                Swal.fire({
                    title: 'Konfirmasi',
                    text: message,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3498db',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Tidak'
                }).then((result) => {
                    if (result.isConfirmed) {
                        callback();
                    }
                });
            }
        
            // Handle view image
            document.querySelectorAll('.view-image').forEach(button => {
                button.addEventListener('click', function() {
                    const imageUrl = this.dataset.image;
                    const title = this.dataset.title;
        
                    document.getElementById('imageModalLabel').textContent = title;
                    document.getElementById('modalImage').src = imageUrl;
        
                    const imageModal = new bootstrap.Modal(document.getElementById('imageModal'));
                    imageModal.show();
                });
            });
                
            // Handle delete button clicks
            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const form = this.closest('form');
                    
                    showConfirmationDialog('Apakah Anda yakin ingin menghapus produk ini?', () => {
                        form.submit();
                    });
                });
            });
                
            // Handle edit button clicks
            document.querySelectorAll('.edit-produk').forEach(button => {
                button.addEventListener('click', function() {
                    const produkId = this.dataset.id;
        
                    // Fetch produk details via AJAX
                    fetch(`/admin/Katsinov/produk_inovasi/${produkId}/detail`)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            // Populate the edit form
                            document.getElementById('edit_nama_produk').value = data.nama_produk;
                            document.getElementById('edit_inovator').value = data.inovator;
                            document.getElementById('edit_nomor_paten').value = data.nomor_paten || '';
        
                            // Set content to the CKEditor
                            if (editDeskripsiEditor) {
                                editDeskripsiEditor.setData(data.deskripsi);
                            }
        
                            // Set the current image
                            const currentImage = document.getElementById('current_image');
                            if (data.gambar) {
                                currentImage.src = `/storage/${data.gambar}`;
                                currentImage.style.display = 'block';
                            } else {
                                currentImage.style.display = 'none';
                            }
        
                            // Set the form action
                            const form = document.getElementById('editProdukForm');
                            form.action = `/admin/Katsinov/produk_inovasi/${produkId}`;
        
                            // Show the modal
                            const editModal = new bootstrap.Modal(document.getElementById('editProdukModal'));
                            editModal.show();
                        })
                        .catch(error => {
                            console.error('Error fetching produk details:', error);
                            showErrorAlert('Gagal mengambil data produk.');
                        });
                });
            });
        
            // Handle save button click
            document.getElementById('saveEditProduk').addEventListener('click', function() {
                // Get the data from CKEditor and set it to the textarea
                const editorData = editDeskripsiEditor.getData();
                
                // This is the critical fix - we need to update the textarea with the editor content
                // before submitting the form since the textarea is what gets submitted, not the CKEditor directly
                document.getElementById('edit_deskripsi').value = editorData;
                
                const form = document.getElementById('editProdukForm');
                const formData = new FormData(form);
        
                fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Close the modal
                        const modalElement = document.getElementById('editProdukModal');
                        const modal = bootstrap.Modal.getInstance(modalElement);
                        modal.hide();
        
                        // Show success message
                        showSuccessAlert(data.message || 'Produk berhasil diperbarui!');
                        
                        // Refresh the page after a short delay
                        setTimeout(() => {
                            window.location.reload();
                        }, 1500);
                    } else {
                        showErrorAlert(data.message || 'Gagal menyimpan perubahan.');
                    }
                })
                .catch(error => {
                    console.error('Error saving produk:', error);
                    showErrorAlert('Gagal menyimpan perubahan.');
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

        .form-control:focus,
        .form-select:focus {
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

        /* Custom styles for the product management */
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