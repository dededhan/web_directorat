@extends('admin.admin')

<script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


@section('contentadmin')
 @vite([
        'resources/css/admin/produk_inovasi.css'
    ])
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

            <form method="POST" action="{{ route($routePrefix . '.produk_inovasi.store') }}" enctype="multipart/form-data">
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
                        <input type="text" class="form-control @error('inovator') is-invalid @enderror" name="inovator"
                            id="inovator" value="{{ old('inovator') }}">
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
                    <div class="col-md-6 mb-3">
                        <label for="kategori" class="form-label">Kategori</label>
                        <select class="form-control @error('kategori') is-invalid @enderror" name="kategori" id="kategori">
                            <option value="HKI" {{ old('kategori') == 'HKI' ? 'selected' : '' }}>HKI</option>
                            <option value="PATEN" {{ old('kategori') == 'PATEN' ? 'selected' : '' }}>PATEN</option>
                        </select>
                        @error('kategori')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text text-muted">Pilih kategori produk</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="link_ebook" class="form-label">Link E-Book</label>
                        <input type="url" class="form-control @error('link_ebook') is-invalid @enderror"
                            name="link_ebook" id="link_ebook" value="{{ old('link_ebook') }}">
                        @error('link_ebook')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text text-muted">Masukkan URL e-book (opsional)</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi Produk</label>
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" name="deskripsi" id="deskripsi" rows="8">{{ old('deskripsi') }}</textarea>
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
                                <th>Kategori</th>   
                                <th>Link E-Book</th>
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
                                    <td>{{ $produk->kategori ?? '-' }}</td>
                                    <td>
                                        @if ($produk->link_ebook)
                                            <a href="{{ $produk->link_ebook }}" target="_blank" class="btn btn-sm btn-primary">Lihat E-Book</a>
                                        @else
                                            -
                                        @endif
                                    </td>
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
                                            <form method="POST"
                                                action="{{ route($routePrefix . '.produk_inovasi.destroy', $produk->id) }}"
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
                            <div class="col-md-6 mb-3">
                                <label for="edit_kategori" class="form-label">Kategori</label>
                                <select class="form-control" name="kategori" id="edit_kategori">
                                    <option value="HKI">HKI</option>
                                    <option value="PATEN">PATEN</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_link_ebook" class="form-label">Link E-Book</label>
                                <input type="url" class="form-control" name="link_ebook" id="edit_link_ebook">
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Set global variables for use in external JS file
        const appConfig = {
            csrfToken: '{{ csrf_token() }}',
            uploadUrl: '{{ route($routePrefix . '.produk_inovasi.upload') }}',
            routePrefix: '{{ $routePrefix }}'
        };

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

                    fetch('{{ route($routePrefix . '.produk_inovasi.upload') }}', {
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
            // Create Form Submission with SweetAlert
            const createForm = document.querySelector('form[action*="produk_inovasi.store"]');
            if (createForm) {
                createForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    Swal.fire({
                        title: 'Konfirmasi',
                        text: 'Apakah Anda yakin ingin menyimpan produk inovasi ini?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#3498db',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, Simpan!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Show loading state
                            Swal.fire({
                                title: 'Menyimpan...',
                                text: 'Mohon tunggu sebentar',
                                allowOutsideClick: false,
                                didOpen: () => {
                                    Swal.showLoading();
                                }
                            });

                            // Submit the form
                            this.submit();
                        }
                    });
                });
            }

            // Handle delete button clicks
            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const form = this.closest('form');

                    Swal.fire({
                        title: 'Konfirmasi Penghapusan',
                        text: 'Apakah Anda yakin ingin menghapus produk ini? Tindakan ini tidak dapat dibatalkan.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3498db',
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Show loading state
                            Swal.fire({
                                title: 'Menghapus...',
                                text: 'Mohon tunggu sebentar',
                                allowOutsideClick: false,
                                didOpen: () => {
                                    Swal.showLoading();
                                }
                            });

                            form.submit();
                        }
                    });
                });
            });

            // Handle edit button clicks
            document.querySelectorAll('.edit-produk').forEach(button => {
                button.addEventListener('click', function() {
                    const produkId = this.dataset.id;
                    const routePrefix = '{{ $routePrefix }}';

                    // Convert route prefix with dots to path with slashes
                    const routePath = routePrefix.replace(/\./g, '/');

                    // Show loading state
                    Swal.fire({
                        title: 'Memuat Data...',
                        text: 'Mohon tunggu sebentar',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // Fetch produk details via AJAX
                    fetch(`/${routePath}/produk_inovasi/${produkId}/detail`)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            Swal.close(); // Close loading dialog

                            // Populate the edit form
                            document.getElementById('edit_nama_produk').value = data
                            .nama_produk;
                            document.getElementById('edit_inovator').value = data.inovator;
                            document.getElementById('edit_nomor_paten').value = data
                                .nomor_paten || '';
                            document.getElementById('edit_kategori').value = data.kategori || 'HKI';
                            document.getElementById('edit_link_ebook').value = data.link_ebook || '';

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
                            form.action = `/${routePath}/produk_inovasi/${produkId}`;

                            // Show the modal
                            const editModal = new bootstrap.Modal(document.getElementById(
                                'editProdukModal'));
                            editModal.show();
                        })
                        .catch(error => {
                            console.error('Error fetching produk details:', error);
                            Swal.fire({
                                title: 'Error!',
                                text: 'Gagal mengambil data produk.',
                                icon: 'error',
                                confirmButtonColor: '#3498db'
                            });
                        });
                });
            });

            // Handle save button click for edit form
            document.getElementById('saveEditProduk').addEventListener('click', function() {
                Swal.fire({
                    title: 'Konfirmasi',
                    text: 'Apakah Anda yakin ingin menyimpan perubahan?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3498db',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Simpan Perubahan!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Get the data from CKEditor and set it to the textarea
                        const editorData = editDeskripsiEditor.getData();

                        // Update textarea with editor content
                        document.getElementById('edit_deskripsi').value = editorData;

                        const form = document.getElementById('editProdukForm');
                        const formData = new FormData(form);

                        // Show loading state
                        Swal.fire({
                            title: 'Menyimpan Perubahan...',
                            text: 'Mohon tunggu sebentar',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        fetch(form.action, {
                                method: 'POST',
                                body: formData,
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest',
                                    'X-CSRF-TOKEN': document.querySelector(
                                        'meta[name="csrf-token"]').getAttribute('content')
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    // Close the modal
                                    const modalElement = document.getElementById(
                                        'editProdukModal');
                                    const modal = bootstrap.Modal.getInstance(modalElement);
                                    modal.hide();

                                    // Show success message
                                    Swal.fire({
                                        title: 'Berhasil!',
                                        text: data.message ||
                                            'Produk berhasil diperbarui!',
                                        icon: 'success',
                                        confirmButtonColor: '#3498db'
                                    }).then(() => {
                                        // Reload the page
                                        window.location.reload();
                                    });
                                } else {
                                    Swal.fire({
                                        title: 'Gagal!',
                                        text: data.message ||
                                            'Gagal menyimpan perubahan.',
                                        icon: 'error',
                                        confirmButtonColor: '#3498db'
                                    });
                                }
                            })
                            .catch(error => {
                                console.error('Error saving produk:', error);
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Gagal menyimpan perubahan.',
                                    icon: 'error',
                                    confirmButtonColor: '#3498db'
                                });
                            });
                    }
                });
            });

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

            // Flash message handling
            const flashSuccess = "{{ session('success') }}";
            const flashError = "{{ session('error') }}";

            if (flashSuccess) {
                Swal.fire({
                    title: 'Berhasil!',
                    text: flashSuccess,
                    icon: 'success',
                    confirmButtonColor: '#3498db'
                });
            }

            if (flashError) {
                Swal.fire({
                    title: 'Error!',
                    text: flashError,
                    icon: 'error',
                    confirmButtonColor: '#3498db'
                });
            }
        });
    </script>
@endsection
