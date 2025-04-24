@extends('admin.admin')

<script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="{{ asset('dashboard_main/dashboard/berita_dashboard.css') }}">
<link rel="stylesheet" href="{{ asset('css/ckeditor-content.css') }}">

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

    <div class="table-data">
        <div class="order">
            <div class="head">
                <h3>Input Berita</h3>
            </div>

            <form method="POST" action="{{ route($routePrefix . '.news.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="category" class="form-label">Kategori</label>
                        <select class="form-select @error('kategori') is-invalid @enderror" name="kategori" id="category">
                            <option value="">Pilih Kategori</option>
                            <option value="inovasi" {{ old('kategori') == 'inovasi' ? 'selected' : '' }}>Inovasi</option>
                            <option value="pemeringkatan" {{ old('kategori') == 'pemeringkatan' ? 'selected' : '' }}>
                                Pemeringkatan</option>
                            <option value="umum" {{ old('kategori') == 'umum' ? 'selected' : '' }}>
                                umum</option>
                        </select>
                        @error('kategori')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text text-muted">Pilih kategori berita yang sesuai</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="tanggal" class="form-label">Tanggal</label>
                        <input type="date" class="form-control @error('tanggal') is-invalid @enderror" name="tanggal"
                            id="tanggal" value="{{ old('tanggal') }}">
                        @error('tanggal')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text text-muted">Pilih tanggal publikasi berita</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="judul_berita" class="form-label">Judul Berita</label>
                        <input type="text" class="form-control @error('judul_berita') is-invalid @enderror"
                            name="judul_berita" id="judul_berita" value="{{ old('judul_berita') }}">
                        @error('judul_berita')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text text-muted">Masukkan judul berita (maksimal 200 karakter)</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="isi_berita" class="form-label">Isi Berita</label>
                        <textarea class="form-control @error('isi_berita') is-invalid @enderror" name="isi_berita" id="isi_berita"
                            rows="8">{{ old('isi_berita') }}</textarea>
                        @error('isi_berita')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text text-muted">Tuliskan isi berita secara lengkap dan detail</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="gambar" class="form-label">Cover Gambar</label>
                        <input type="file" class="form-control @error('gambar') is-invalid @enderror" name="gambar"
                            id="gambar" accept="image/*">
                        @error('gambar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text text-muted">Upload gambar cover berita (format: JPG, PNG, atau JPEG, max 2MB)
                        </div>
                    </div>
                </div>
                <!-- Tambahkan input multiple files setelah input cover image -->
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="additional_images" class="form-label">Isi Gambar Berita</label>
                        <input type="file" class="form-control @error('additional_images') is-invalid @enderror"
                            name="additional_images[]" id="additional_images" multiple accept="image/*">
                        @error('additional_images.*')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text text-muted">
                            Upload isi gambar Berita (format: JPG, PNG, atau JPEG, max 2MB per file)
                        </div>
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
                                <th>Cover Gambar</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($beritas as $index => $berita)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <span
                                            class="badge bg-{{ [
                                                'inovasi' => 'primary',
                                                'pemeringkatan' => 'success',
                                                'umum' => 'info',
                                            ][$berita->kategori] }}">
                                            {{ ucfirst($berita->kategori) }}
                                        </span>
                                    </td>
                                    <td>{{ $berita->tanggal }}</td>
                                    <td>{{ $berita->judul }}</td>
                                    <td>{{ Str::limit(strip_tags($berita->isi), 50) }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-info view-image"
                                            data-image="{{ asset('storage/' . $berita->gambar) }}"
                                            data-title="{{ $berita->judul }}">
                                            Lihat Gambar
                                        </button>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-sm btn-warning edit-berita"
                                                data-id="{{ $berita->id }}">
                                                Edit
                                            </button>
                                            <form method="POST"
                                                action="{{ route($routePrefix . '.news.destroy', $berita->id) }}"
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
                    <h5 class="modal-title" id="imageModalLabel">Gambar Berita</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalImage" src="" class="img-fluid" alt="Gambar Berita">
                </div>
            </div>
        </div>
    </div>

    <!-- Modal untuk mengedit berita -->
    <div class="modal fade" id="editBeritaModal" tabindex="-1" aria-labelledby="editBeritaModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editBeritaModalLabel">Edit Berita</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editBeritaForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit_kategori" class="form-label">Kategori</label>
                                <select class="form-select" name="kategori" id="edit_kategori">
                                    <option value="inovasi">Inovasi</option>
                                    <option value="pemeringkatan">Pemeringkatan</option>
                                    <option value="umum">umum</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_tanggal" class="form-label">Tanggal</label>
                                <input type="date" class="form-control" name="tanggal" id="edit_tanggal">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="edit_judul_berita" class="form-label">Judul Berita</label>
                                <input type="text" class="form-control" name="judul_berita" id="edit_judul_berita">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="edit_isi_berita" class="form-label">Isi Berita</label>
                                <textarea class="form-control" name="isi_berita" id="edit_isi_berita" rows="8"></textarea>
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
                    <button type="button" class="btn btn-primary" id="saveEditBerita">Simpan Perubahan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Script section -->
    <script>
        // Set global variables for use in external JS file
        const appConfig = {
            csrfToken: '{{ csrf_token() }}',
            uploadUrl: '{{ route($routePrefix . '.news.upload') }}',
            routePrefix: '{{ $routePrefix }}'
        };
    </script>

    {{-- <script src="{{ asset('dashboard_main/dashboard/berita_dashboard.js') }}"></script> --}}

    <script>
        // Custom upload adapter needs to be defined inline to access Blade variables
        class MyUploadAdapter {
            constructor(loader) {
                this.loader = loader;
            }

            upload() {
                return this.loader.file.then(file => new Promise((resolve, reject) => {
                    const data = new FormData();
                    data.append('upload', file);
                    data.append('_token', '{{ csrf_token() }}');

                    fetch('{{ route($routePrefix . '.news.upload') }}', {
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

        // Initialize CKEditor for new berita
        ClassicEditor
            .create(document.querySelector('#isi_berita'), {
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
        let editBeritaEditor;
        ClassicEditor
            .create(document.querySelector('#edit_isi_berita'), {
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
                editBeritaEditor = editor;
            })
            .catch(error => {
                console.error(error);
            });

            

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

                    showConfirmationDialog('Apakah Anda yakin ingin menghapus berita ini?', () => {
                        form.submit();
                    });
                });
            });

            // Handle edit button clicks
            // Handle edit button clicks
            document.querySelectorAll('.edit-berita').forEach(button => {
                button.addEventListener('click', function() {
                    const beritaId = this.dataset.id;
                    const routePrefix = '{{ $routePrefix }}';

                    // Convert route prefix with dots to path with slashes
                    const routePath = routePrefix.replace('.', '/');

                    // Fetch berita details via AJAX
                    fetch(`/${routePath}/berita/${beritaId}/detail`)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            // Populate the edit form
                            document.getElementById('edit_kategori').value = data.kategori;
                            document.getElementById('edit_tanggal').value = data.tanggal;
                            document.getElementById('edit_judul_berita').value = data.judul;

                            // Set content to the CKEditor
                            if (editBeritaEditor) {
                                editBeritaEditor.setData(data.isi);
                            }

                            // Set the current image
                            const currentImage = document.getElementById('current_image');
                            currentImage.src = `/storage/${data.gambar}`;

                            // Set the form action with correct path structure
                            const form = document.getElementById('editBeritaForm');
                            form.action = `/${routePath}/berita/${beritaId}`;

                            // Show the modal
                            const editModal = new bootstrap.Modal(document.getElementById(
                                'editBeritaModal'));
                            editModal.show();
                        })
                        .catch(error => {
                            console.error('Error fetching berita details:', error);
                            showErrorAlert('Gagal mengambil data berita.');
                        });
                });
            });
            // Handle save button click
            document.getElementById('saveEditBerita').addEventListener('click', function() {
                const editorData = editBeritaEditor.getData();
                document.getElementById('edit_isi_berita').value = editorData;

                const form = document.getElementById('editBeritaForm');
                const formData = new FormData(form);

                fetch(form.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Close the modal
                            const modalElement = document.getElementById('editBeritaModal');
                            const modal = bootstrap.Modal.getInstance(modalElement);
                            modal.hide();

                            // Show success message
                            showSuccessAlert(data.message || 'Berita berhasil diperbarui!');

                            // Refresh the page after a short delay
                            setTimeout(() => {
                                window.location.reload();
                            }, 1500);
                        } else {
                            showErrorAlert(data.message || 'Gagal menyimpan perubahan.');
                        }
                    })
                    .catch(error => {
                        console.error('Error saving berita:', error);
                        showErrorAlert('Gagal menyimpan perubahan.');
                    });
            });
        });


    </script>
@endsection
