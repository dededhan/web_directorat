@extends('admin.admin')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="{{ asset('dashboard_main/dashboard/berita_dashboard.css') }}">
<link rel="stylesheet" href="{{ asset('css/ckeditor-content.css') }}">

<style>

</style>

@section('contentadmin')
    <div class="head-title">
        <div class="left">
            <h1>Pimpinan</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="#">Dashboard</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a class="active" href="#">Kelola Pimpinan</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="table-data">
        <div class="order">
            <div class="head">
                <h3>Input Data Pimpinan</h3>
            </div>

            <form method="POST" action="{{ route($routePrefix . '.pimpinan.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama"
                            id="nama" value="{{ old('nama') }}">
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text text-muted">Masukkan nama pimpinan</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="jabatan" class="form-label">Jabatan</label>
                        <select class="form-select @error('jabatan') is-invalid @enderror" name="jabatan" id="jabatan">
                            <option value="">Pilih Jabatan</option>
                            <option value="Direktur Inovasi Sistem Informasi dan Pemeringkatan"
                                {{ old('jabatan') == 'Direktur Inovasi Sistem Informasi dan Pemeringkatan' ? 'selected' : '' }}>
                                Direktur Inovasi Sistem Informasi dan Pemeringkatan</option>
                            <option value="Kepala Subdirektorat Inovasi dan Hilirisai"
                                {{ old('jabatan') == 'Kepala Subdirektorat Inovasi dan Hilirisai' ? 'selected' : '' }}>
                                Kepala Subdirektorat Inovasi dan Hilirisai</option>
                            <option value="Kepala Subdirektorat Sistem Informasi dan Pemeringkatan"
                                {{ old('jabatan') == 'Kepala Subdirektorat Sistem Informasi dan Pemeringkatan' ? 'selected' : '' }}>
                                Kepala Subdirektorat Sistem Informasi dan Pemeringkatan</option>
                        </select>
                        @error('jabatan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text text-muted">Pilih jabatan pimpinan</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" name="deskripsi" id="deskripsi" rows="8">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text text-muted">Tuliskan deskripsi/biografi pimpinan</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="gambar" class="form-label">Foto Pimpinan</label>
                        <input type="file" class="form-control @error('gambar') is-invalid @enderror" name="gambar"
                            id="gambar" accept="image/*">
                        @error('gambar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text text-muted">Upload foto pimpinan (format: JPG, PNG, atau JPEG, max 8MB)</div>
                    </div>
                </div>

                <div class="mb-3 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Simpan Data</button>
                </div>
            </form>
        </div>

        <div class="table-data mt-4">
            <div class="order">
                <div class="head">
                    <h3>Daftar Pimpinan</h3>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped" id="pimpinan-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Jabatan</th>
                                <th>Deskripsi</th>
                                <th>Foto</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pimpinans as $index => $pimpinan)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $pimpinan->nama }}</td>
                                    <td>
                                        <span class="badge bg-info">
                                            {{ $pimpinan->jabatan }}
                                        </span>
                                    </td>
                                    <td>{{ Str::limit(strip_tags($pimpinan->deskripsi), 50) }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-info view-image"
                                            data-image="{{ asset('storage/' . $pimpinan->gambar) }}"
                                            data-title="{{ $pimpinan->nama }}">
                                            Lihat Foto
                                        </button>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-sm btn-warning edit-pimpinan"
                                                data-id="{{ $pimpinan->id }}">
                                                Edit
                                            </button>
                                            <form method="POST"
                                                action="{{ route($routePrefix . '.pimpinan.destroy', $pimpinan->id) }}"
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
                    <h5 class="modal-title" id="imageModalLabel">Foto Pimpinan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalImage" src="" class="img-fluid" alt="Foto Pimpinan">
                </div>
            </div>
        </div>
    </div>

    <!-- Modal untuk mengedit pimpinan -->
    <div class="modal fade" id="editPimpinanModal" tabindex="-1" aria-labelledby="editPimpinanModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPimpinanModalLabel">Edit Data Pimpinan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editPimpinanForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit_nama" class="form-label">Nama</label>
                                <input type="text" class="form-control" name="nama" id="edit_nama">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_jabatan" class="form-label">Jabatan</label>
                                <select class="form-select" name="jabatan" id="edit_jabatan">
                                    <option value="Direktur Inovasi Sistem Informasi dan Pemeringkatan">Direktur Inovasi
                                        Sistem Informasi dan Pemeringkatan</option>
                                    <option value="Kepala Subdirektorat Inovasi dan Hilirisai">Kepala Subdirektorat Inovasi
                                        dan Hilirisai</option>
                                    <option value="Kepala Subdirektorat Sistem Informasi dan Pemeringkatan">Kepala
                                        Subdirektorat Sistem Informasi dan Pemeringkatan</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="edit_deskripsi" class="form-label">Deskripsi</label>
                                <textarea class="form-control" name="deskripsi" id="edit_deskripsi" rows="8"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="edit_gambar" class="form-label">Foto Baru (opsional)</label>
                                <input type="file" class="form-control" name="gambar" id="edit_gambar"
                                    accept="image/*">
                                <div class="mt-2">
                                    <p>Foto saat ini:</p>
                                    <img id="current_image" src="" class="img-fluid mt-2"
                                        style="max-height: 200px;" alt="Current Image">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="saveEditPimpinan">Simpan Perubahan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Script section -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            ClassicEditor
                .create(document.querySelector('#deskripsi'), {
                    toolbar: {
                        items: [
                            'heading', '|',
                            'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|',
                            'blockQuote', 'undo', 'redo'
                        ]
                    }
                })
                .catch(error => {
                    console.error(error);
                });

            // Initialize CKEditor for the edit form
            let editDeskripsiEditor;
            ClassicEditor
                .create(document.querySelector('#edit_deskripsi'), {
                    toolbar: {
                        items: [
                            'heading', '|',
                            'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|',
                            'blockQuote', 'undo', 'redo'
                        ]
                    }
                })
                .then(editor => {
                    editDeskripsiEditor = editor;
                })
                .catch(error => {
                    console.error(error);
                });

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

                    showConfirmationDialog('Apakah Anda yakin ingin menghapus data pimpinan ini?',
                        () => {
                            form.submit();
                        });
                });
            });

            // Handle edit button clicks
            document.querySelectorAll('.edit-pimpinan').forEach(button => {
                button.addEventListener('click', function() {
                    const pimpinanId = this.dataset.id;
                    const routePrefix = '{{ $routePrefix }}';

                    // Convert route prefix with dots to path with slashes
                    const routePath = routePrefix.replace(/\./g, '/');

                    // Fetch pimpinan details via AJAX
                    fetch(`/${routePath}/pimpinan/${pimpinanId}/detail`)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            // Populate the edit form
                            document.getElementById('edit_nama').value = data.nama;
                            document.getElementById('edit_jabatan').value = data.jabatan;

                            // Set content to the CKEditor
                            if (editDeskripsiEditor) {
                                editDeskripsiEditor.setData(data.deskripsi);
                            }

                            // Set the current image
                            const currentImage = document.getElementById('current_image');
                            currentImage.src = `/storage/${data.gambar}`;

                            // Set the form action with correct path structure
                            const form = document.getElementById('editPimpinanForm');
                            form.action = `/${routePath}/pimpinan/${pimpinanId}`;

                            // Show the modal
                            const editModal = new bootstrap.Modal(document.getElementById(
                                'editPimpinanModal'));
                            editModal.show();
                        })
                        .catch(error => {
                            console.error('Error fetching pimpinan details:', error);
                            showErrorAlert('Gagal mengambil data pimpinan.');
                        });
                });
            });

            // Handle save button click
            document.getElementById('saveEditPimpinan').addEventListener('click', function() {
                const editorData = editDeskripsiEditor.getData();
                document.getElementById('edit_deskripsi').value = editorData;

                const form = document.getElementById('editPimpinanForm');
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
                            const modalElement = document.getElementById('editPimpinanModal');
                            const modal = bootstrap.Modal.getInstance(modalElement);
                            modal.hide();

                            // Show success message
                            showSuccessAlert(data.message || 'Data pimpinan berhasil diperbarui!');

                            // Refresh the page after a short delay
                            setTimeout(() => {
                                window.location.reload();
                            }, 1500);
                        } else {
                            showErrorAlert(data.message || 'Gagal menyimpan perubahan.');
                        }
                    })
                    .catch(error => {
                        console.error('Error saving pimpinan:', error);
                        showErrorAlert('Gagal menyimpan perubahan.');
                    });
            });

            // Flash messages for form submission results
            @if (session('success'))
                showSuccessAlert("{{ session('success') }}");
            @endif

            @if (session('error'))
                showErrorAlert("{{ session('error') }}");
            @endif
        });
    </script>
@endsection
