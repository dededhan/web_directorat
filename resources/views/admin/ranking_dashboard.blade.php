@extends('admin.admin')

<script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="{{ asset('dashboard_main/dashboard/berita_dashboard.css') }}">

@section('contentadmin')
    <div class="head-title">
        <div class="left">
            <h1>Peringkat Universitas</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="#">Dashboard</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a class="active" href="#">Kelola Peringkat</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="table-data">
        <div class="order">
            <div class="head">
                <h3>Input Peringkat</h3>
            </div>

            <form method="POST" action="{{ route($routePrefix . '.ranking.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="judul" class="form-label">Judul Peringkat</label>
                        <input type="text" class="form-control @error('judul') is-invalid @enderror"
                            name="judul" id="judul" value="{{ old('judul') }}">
                        @error('judul')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text text-muted">Masukkan judul peringkat (maksimal 200 karakter)</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi Peringkat</label>
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" name="deskripsi" id="deskripsi"
                            rows="8">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text text-muted">Tuliskan deskripsi peringkat secara lengkap dan detail</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="gambar" class="form-label">Gambar Logo</label>
                        <input type="file" class="form-control @error('gambar') is-invalid @enderror" name="gambar"
                            id="gambar" accept="image/*">
                        @error('gambar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text text-muted">Upload gambar logo peringkat (format: JPG, PNG, atau JPEG, max 2MB)
                        </div>
                    </div>
                </div>

                <div class="mb-3 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Simpan Peringkat</button>
                </div>
            </form>
        </div>

        <div class="table-data mt-4">
            <div class="order">
                <div class="head">
                    <h3>Daftar Peringkat</h3>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped" id="ranking-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul Peringkat</th>
                                <th>Logo</th>
                                <th>Deskripsi</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rankings as $index => $ranking)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $ranking->judul }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-info view-image"
                                            data-image="{{ asset('storage/' . $ranking->gambar) }}"
                                            data-title="{{ $ranking->judul }}">
                                            Lihat Logo
                                        </button>
                                    </td>
                                    <td>{{ Str::limit(strip_tags($ranking->deskripsi), 50) }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-sm btn-warning edit-ranking"
                                                data-id="{{ $ranking->id }}">
                                                Edit
                                            </button>
                                            <form method="POST"
                                                action="{{ route($routePrefix . '.ranking.destroy', $ranking->id) }}"
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
                    <h5 class="modal-title" id="imageModalLabel">Logo Peringkat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalImage" src="" class="img-fluid" alt="Logo Peringkat">
                </div>
            </div>
        </div>
    </div>

    <!-- Modal untuk mengedit peringkat -->
    <div class="modal fade" id="editRankingModal" tabindex="-1" aria-labelledby="editRankingModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editRankingModalLabel">Edit Peringkat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editRankingForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="edit_judul" class="form-label">Judul Peringkat</label>
                                <input type="text" class="form-control" name="judul" id="edit_judul">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="edit_deskripsi" class="form-label">Deskripsi Peringkat</label>
                                <textarea class="form-control" name="deskripsi" id="edit_deskripsi" rows="8"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="edit_gambar" class="form-label">Logo Baru (opsional)</label>
                                <input type="file" class="form-control" name="gambar" id="edit_gambar"
                                    accept="image/*">
                                <div class="mt-2">
                                    <p>Logo saat ini:</p>
                                    <img id="current_image" src="" class="img-fluid mt-2"
                                        style="max-height: 200px;" alt="Current Image">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="saveEditRanking">Simpan Perubahan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Script section -->
    <script>
        // Custom upload adapter for CKEditor
        class MyUploadAdapter {
            constructor(loader) {
                this.loader = loader;
            }

            upload() {
                return this.loader.file.then(file => new Promise((resolve, reject) => {
                    const data = new FormData();
                    data.append('upload', file);
                    data.append('_token', '{{ csrf_token() }}');

                    fetch('{{ route($routePrefix . '.ranking.upload') }}', {
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

        // Initialize CKEditor for new ranking
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
        let editRankingEditor;
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
                editRankingEditor = editor;
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

                    showConfirmationDialog('Apakah Anda yakin ingin menghapus peringkat ini?', () => {
                        form.submit();
                    });
                });
            });

            // Handle edit button clicks
            document.querySelectorAll('.edit-ranking').forEach(button => {
                button.addEventListener('click', function() {
                    const rankingId = this.dataset.id;
                    const routePrefix = '{{ $routePrefix }}';

                    // Convert route prefix with dots to path with slashes
                    const routePath = routePrefix.replace('.', '/');

                    // Fetch ranking details via AJAX
                    fetch(`/${routePath}/ranking/${rankingId}/detail`)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            // Populate the edit form
                            document.getElementById('edit_judul').value = data.judul;

                            // Set content to the CKEditor
                            if (editRankingEditor) {
                                editRankingEditor.setData(data.deskripsi);
                            }

                            // Set the current image
                            const currentImage = document.getElementById('current_image');
                            currentImage.src = `/storage/${data.gambar}`;

                            // Set the form action with correct path structure
                            const form = document.getElementById('editRankingForm');
                            form.action = `/${routePath}/ranking/${rankingId}`;

                            // Show the modal
                            const editModal = new bootstrap.Modal(document.getElementById(
                                'editRankingModal'));
                            editModal.show();
                        })
                        .catch(error => {
                            console.error('Error fetching ranking details:', error);
                            showErrorAlert('Gagal mengambil data peringkat.');
                        });
                });
            });

            // Handle save button click
            document.getElementById('saveEditRanking').addEventListener('click', function() {
                const editorData = editRankingEditor.getData();
                document.getElementById('edit_deskripsi').value = editorData;

                const form = document.getElementById('editRankingForm');
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
                            const modalElement = document.getElementById('editRankingModal');
                            const modal = bootstrap.Modal.getInstance(modalElement);
                            modal.hide();

                            // Show success message
                            showSuccessAlert(data.message || 'Peringkat berhasil diperbarui!');

                            // Refresh the page after a short delay
                            setTimeout(() => {
                                window.location.reload();
                            }, 1500);
                        } else {
                            showErrorAlert(data.message || 'Gagal menyimpan perubahan.');
                        }
                    })
                    .catch(error => {
                        console.error('Error saving ranking:', error);
                        showErrorAlert('Gagal menyimpan perubahan.');
                    });
            });
        });
    </script>
@endsection