@extends('admin.admin')

<script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="{{ asset('dashboard_main/dashboard/berita_dashboard.css') }}">
<link rel="stylesheet" href="{{ asset('css/ckeditor-content.css') }}">
@section('contentadmin')
    <div class="head-title">
        <div class="left">
            <h1>Indikator Pemeringkatan</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="#">Dashboard</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a class="active" href="#">Kelola Indikator</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="table-data">
        <div class="order">
            <div class="head">
                <h3>Input Indikator</h3>
            </div>

            <form method="POST" action="{{ route($routePrefix . '.indikator.store') }}">
                @csrf
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="judul" class="form-label">Judul Indikator</label>
                        <input type="text" class="form-control @error('judul') is-invalid @enderror" name="judul"
                            id="judul" value="{{ old('judul') }}">
                        @error('judul')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text text-muted">Masukkan judul indikator yang akan ditampilkan di sidebar (maksimal 200 karakter)</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi Indikator</label>
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" name="deskripsi" id="deskripsi" rows="8">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text text-muted">Tuliskan deskripsi indikator secara lengkap dan detail</div>
                    </div>
                </div>

                <div class="mb-3 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Simpan Indikator</button>
                </div>
            </form>
        </div>

        <div class="table-data mt-4">
            <div class="order">
                <div class="head">
                    <h3>Daftar Indikator</h3>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped" id="indikator-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul Indikator</th>
                                <th>Deskripsi</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($indikators as $index => $indikator)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $indikator->judul }}</td>
                                    <td>{{ Str::limit(strip_tags($indikator->deskripsi), 50) }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-sm btn-warning edit-indikator"
                                                data-id="{{ $indikator->id }}">
                                                Edit
                                            </button>
                                            <form method="POST"
                                                action="{{ route($routePrefix . '.indikator.destroy', $indikator->id) }}"
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

    <!-- Modal untuk mengedit indikator -->
    <div class="modal fade" id="editIndikatorModal" tabindex="-1" aria-labelledby="editIndikatorModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editIndikatorModalLabel">Edit Indikator</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editIndikatorForm" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="edit_judul" class="form-label">Judul Indikator</label>
                                <input type="text" class="form-control" name="judul" id="edit_judul">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="edit_deskripsi" class="form-label">Deskripsi Indikator</label>
                                <textarea class="form-control" name="deskripsi" id="edit_deskripsi" rows="8"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="saveEditIndikator">Simpan Perubahan</button>
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

        // Initialize CKEditor for new indikator
        const commonConfig = {
            extraPlugins: [MyCustomUploadAdapterPlugin],
            toolbar: {
                items: [
                    'heading', '|',
                    'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|',
                    'alignment', 'fontColor', 'fontBackgroundColor', '|',
                    'blockQuote', '|',
                    'insertTable', 'undo', 'redo'
                ]
            },
            table: {
                contentToolbar: [
                    'tableColumn', 'tableRow', 'mergeTableCells',
                    'tableProperties', 'tableCellProperties'
                ]
            },
            alignment: {
                options: ['left', 'right', 'center', 'justify']
            }
        };

        // Initialize both editors with this config
        ClassicEditor.create(document.querySelector('#deskripsi'), commonConfig)
            .catch(console.error);

        let editIndikatorEditor;
        ClassicEditor.create(document.querySelector('#edit_deskripsi'), commonConfig)
            .then(editor => {
                editIndikatorEditor = editor;
            })
            .catch(console.error);


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

            // Handle delete button clicks
            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const form = this.closest('form');

                    showConfirmationDialog('Apakah Anda yakin ingin menghapus indikator ini?',
                        () => {
                            form.submit();
                        });
                });
            });

            // Handle edit button clicks
            document.querySelectorAll('.edit-indikator').forEach(button => {
                button.addEventListener('click', function() {
                    const indikatorId = this.dataset.id;
                    const routePrefix = '{{ $routePrefix }}';

                    // Convert route prefix with dots to path with slashes
                    const routePath = routePrefix.replace('.', '/');

                    // Fetch indikator details via AJAX
                    fetch(`/${routePath}/indikator/${indikatorId}/detail`)
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
                            if (editIndikatorEditor) {
                                editIndikatorEditor.setData(data.deskripsi);
                            }

                            // Set the form action with correct path structure
                            const form = document.getElementById('editIndikatorForm');
                            form.action = `/${routePath}/indikator/${indikatorId}`;

                            // Show the modal
                            const editModal = new bootstrap.Modal(document.getElementById(
                                'editIndikatorModal'));
                            editModal.show();
                        })
                        .catch(error => {
                            console.error('Error fetching indikator details:', error);
                            showErrorAlert('Gagal mengambil data indikator.');
                        });
                });
            });

            // Handle save button click
            document.getElementById('saveEditIndikator').addEventListener('click', function() {
                const editorData = editIndikatorEditor.getData();
                document.getElementById('edit_deskripsi').value = editorData;

                const form = document.getElementById('editIndikatorForm');
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
                            const modalElement = document.getElementById('editIndikatorModal');
                            const modal = bootstrap.Modal.getInstance(modalElement);
                            modal.hide();

                            // Show success message
                            showSuccessAlert(data.message || 'Indikator berhasil diperbarui!');

                            // Refresh the page after a short delay
                            setTimeout(() => {
                                window.location.reload();
                            }, 1500);
                        } else {
                            showErrorAlert(data.message || 'Gagal menyimpan perubahan.');
                        }
                    })
                    .catch(error => {
                        console.error('Error saving indikator:', error);
                        showErrorAlert('Gagal menyimpan perubahan.');
                    });
            });
        });
    </script>
@endsection