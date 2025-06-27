@extends('admin.admin')

@section('contentadmin')
@vite([
        'resources/css/admin/berita_dashboard.css',
        'resources/css/admin/ckeditor-content.css',
    ])

{{-- Keep these if they are not pushed from the main layout or used by other elements on this page --}}
{{-- <script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script> --}}
{{-- Not needed here anymore for edit, but keep for add form --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- <link rel="stylesheet" href="{{ asset('dashboard_main/dashboard/berita_dashboard.css') }}">
<link rel="stylesheet" href="{{ asset('css/ckeditor-content.css') }}"> {{-- Keep if add form uses it --}} -->

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
                        <input type="text" class="form-control @error('judul') is-invalid @enderror" name="judul"
                            id="judul" value="{{ old('judul') }}">
                        @error('judul')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text text-muted">Masukkan judul peringkat (maksimal 200 karakter)</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="score_ranking" class="form-label">Skor Peringkat(Optional)</label>
                        <input type="text" class="form-control @error('score_ranking') is-invalid @enderror"
                            name="score_ranking" id="score_ranking" value="{{ old('score_ranking') }}">
                        @error('score_ranking')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text text-muted">Masukkan skor peringkat (contoh: 100.0)</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="deskripsi_create" class="form-label">Deskripsi Peringkat</label> {{-- Changed ID to avoid conflict if another editor was on page --}}
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" name="deskripsi" id="deskripsi_create" rows="8">{{ old('deskripsi') }}</textarea>
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
                        <div class="form-text text-muted">Upload gambar logo peringkat (format: JPG, PNG, atau JPEG, max
                            2MB)
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
                                <th>Skor</th>
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
                                    <td>{{ $ranking->score_ranking }}</td>
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
                                            {{-- MODIFIED: Changed button to a link --}}
                                            <a href="{{ route($routePrefix . '.ranking.edit', $ranking->id) }}"
                                               class="btn btn-sm btn-warning">
                                                Edit
                                            </a>
                                            <form method="POST"
                                                action="{{ route($routePrefix . '.ranking.destroy', $ranking->id) }}"
                                                class="delete-form" style="display:inline;"> {{-- Added style for better layout --}}
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

    {{-- REMOVED: Edit Ranking Modal --}}
    {{-- <div class="modal fade" id="editRankingModal" ...> ... </div> --}}


    <script>
        // Custom upload adapter for CKEditor (for CREATE form)
        class MyUploadAdapterCreate { // Renamed to avoid conflict if you had one for edit modal before
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

        function MyCustomUploadAdapterPluginCreate(editor) { // Renamed
            editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
                return new MyUploadAdapterCreate(loader); // Use renamed adapter
            };
        }

        // Initialize CKEditor for new ranking (CREATE form)
        const createFormConfig = { // Renamed config object
            extraPlugins: [MyCustomUploadAdapterPluginCreate], // Use renamed plugin
            toolbar: {
                items: [
                    'heading', '|',
                    'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|',
                    'alignment', 'fontColor', 'fontBackgroundColor', '|',
                    'imageUpload', 'imageResize', 'blockQuote', '|',
                    'insertTable', 'undo', 'redo'
                ]
            },
            image: {
                toolbar: [
                    'imageTextAlternative', 'imageStyle:inline', 'imageStyle:block', 'imageStyle:side',
                    'toggleImageCaption', 'imageResize:25', 'imageResize:50', 'imageResize:75', 'imageResize:Original'
                ],
                resizeOptions: [
                    { name: 'resizeImage:original', label: 'Original', value: null },
                    { name: 'resizeImage:50', label: '50%', value: '50' },
                    { name: 'resizeImage:75', label: '75%', value: '75' }
                ]
            },
            table: {
                contentToolbar: [ 'tableColumn', 'tableRow', 'mergeTableCells', 'tableProperties', 'tableCellProperties' ]
            },
            alignment: { options: ['left', 'right', 'center', 'justify'] },
            caption: { colorPicker: true }
        };

        // Initialize CKEditor for the CREATE form
        ClassicEditor.create(document.querySelector('#deskripsi_create'), createFormConfig) // Use new ID
            .catch(console.error);

        // REMOVED: CKEditor for edit_deskripsi as it's on a new page now.
        // let editRankingEditor;
        // ClassicEditor.create(document.querySelector('#edit_deskripsi'), commonConfig)...

        document.addEventListener('DOMContentLoaded', function() {
            // SweetAlert helper functions (can be kept if used elsewhere or for create form feedback)
            function showSuccessAlert(message) { /* ... */ }
            function showErrorAlert(message) { /* ... */ }
            function showConfirmationDialog(message, callback) { /* ... */ }

            // Handle view image (keep this)
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

            // Handle delete button clicks (keep this)
            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const form = this.closest('form');
                    showConfirmationDialog('Apakah Anda yakin ingin menghapus peringkat ini?', () => {
                        form.submit();
                    });
                });
            });

            // REMOVED: JavaScript for handling edit button clicks and edit modal submission.

            // Display flashed session messages from server-side redirects (e.g., after create, delete)
            @if (session('success'))
                Swal.fire({
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    icon: 'success',
                    confirmButtonColor: '#3498db',
                    confirmButtonText: 'OK'
                });
            @endif

            @if (session('error'))
                Swal.fire({
                    title: 'Gagal!',
                    text: '{{ session('error') }}',
                    icon: 'error',
                    confirmButtonColor: '#3498db',
                    confirmButtonText: 'OK'
                });
            @endif
        });
    </script>
@endsection