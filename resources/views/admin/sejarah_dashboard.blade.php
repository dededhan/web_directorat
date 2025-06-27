@extends('admin.admin')
<!-- <link rel="stylesheet" href="{{ asset('dashboard_main/dashboard/sejarah_dashboard.css') }}"> -->
@vite([
        'resources/css/admin/sejarah_dashboard.css'
    ])
@section('contentadmin')
    <div class="head-title">
        <div class="left">
            <h1>Manajemen Halaman Sejarah</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="#">Dashboard</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a class="active" href="#">Kelola Konten Sejarah</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="table-data">
        <div class="order">
            <div class="head">
                <h3>Input Konten</h3>
            </div>

            <form method="POST" action="{{ route($routePrefix . '.sejarah.store') }}">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="category" class="form-label">Kategori</label>
                        <select class="form-select @error('category') is-invalid @enderror" name="category" id="category"
                            {{ count($categories) === 1 ? 'disabled' : '' }}>
                            @foreach ($categories as $value => $label)
                                <option value="{{ $value }}" {{ old('category') == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @if (count($categories) === 1)
                            <input type="hidden" name="category" value="{{ key($categories) }}">
                        @endif
                        @error('category')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text text-muted">Pilih kategori konten</div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="section" class="form-label">Bagian</label>
                        <select class="form-select @error('section') is-invalid @enderror" name="section" id="section">
                            <option value="">Pilih Bagian</option>
                            @foreach ($sections as $value => $label)
                                <option value="{{ $value }}" {{ old('section') == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @error('section')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text text-muted">Pilih bagian konten</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="content_field" class="form-label">Konten</label>
                        <textarea class="form-control @error('content') is-invalid @enderror" name="content" id="content_field" rows="8">{{ old('content') }}</textarea>
                        @error('content')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text text-muted">Masukkan konten halaman</div>
                    </div>
                </div>

                <div class="mb-3 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Simpan Konten</button>
                </div>
            </form>
        </div>
    </div>

    <div class="table-data mt-4">
        <div class="order">
            <div class="head">
                <h3>Daftar Konten</h3>
            </div>

            <div class="table-responsive">
                <table class="table table-striped" id="sejarah-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kategori</th>
                            <th>Bagian</th>
                            <th>Konten</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($contents as $index => $content)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <span
                                        class="badge bg-{{ $content->category == 'pemeringkatan' ? 'success' : 'primary' }}">
                                        {{ ucfirst($content->category) }}
                                    </span>
                                </td>
                                <td>{{ $sections[$content->section] }}</td>
                                <td>{{ Str::limit(strip_tags($content->content), 100) }}</td>
                                <td>
                                    <span class="badge bg-{{ $content->status ? 'success' : 'warning' }}">
                                        {{ $content->status ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-info view-content"
                                            data-id="{{ $content->id }}">
                                            Lihat
                                        </button>
                                        <a href="{{ route($routePrefix . '.sejarah.edit', $content->id) }}"
                                            class="btn btn-sm btn-warning">
                                            Edit
                                        </a>
                                        <form method="POST"
                                            action="{{ route($routePrefix . '.sejarah.destroy', $content->id) }}"
                                            class="delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-danger delete-btn">Hapus</button>
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

    <!-- Modal untuk menampilkan konten -->
    <div class="modal fade" id="contentModal" tabindex="-1" aria-labelledby="contentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="contentModalLabel">Detail Konten</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <strong>Kategori:</strong>
                        <p id="modalCategory"></p>
                    </div>
                    <div class="mb-3">
                        <strong>Bagian:</strong>
                        <p id="modalSection"></p>
                    </div>
                    <div class="mb-3">
                        <strong>Konten:</strong>
                        <div id="modalContent" class="p-3 border rounded bg-light"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
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
    
                        fetch('{{ route($routePrefix . ".news.upload") }}', {
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
    
            // Initialize CKEditor for the content field
            ClassicEditor
                .create(document.querySelector('#content_field'), {
                    extraPlugins: [MyCustomUploadAdapterPlugin],
                    toolbar: {
                        items: [
                            'heading', '|',
                            'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|',
                            'imageUpload', 'blockQuote', 'insertTable', '|',
                            'undo', 'redo'
                        ]
                    },
                    image: {
                        toolbar: ['imageTextAlternative', 'imageStyle:inline', 'imageStyle:block', 'imageStyle:side']
                    },
                    table: {
                        contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells']
                    },
                })
                .catch(error => {
                    console.error('CKEditor initialization error:', error);
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
    
            // Show success message if present in session
            @if(session('success'))
                showSuccessAlert("{{ session('success') }}");
            @endif
    
            // Show error message if present in session
            @if(session('error'))
                showErrorAlert("{{ session('error') }}");
            @endif
    
            // Handle view content
            document.querySelectorAll('.view-content').forEach(button => {
                button.addEventListener('click', function() {
                    const contentId = this.dataset.id;
                    const routePrefix = '{{ $routePrefix }}';
                    
                    // Convert route prefix with dots to path with slashes for the API
                    const routePath = routePrefix.replace(/\./g, '/');
                    
                    // Fetch content details via AJAX
                    fetch(`/${routePath}/sejarah/${contentId}`)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            // Populate the modal
                            document.getElementById('modalCategory').textContent = 
                                data.category === 'pemeringkatan' ? 'Pemeringkatan' : 'Inovasi';
                                
                            document.getElementById('modalSection').textContent = 
                                data.section === 'sejarah' ? 'Sejarah' :
                                data.section === 'visi-misi' ? 'Visi Misi' :
                                data.section === 'tujuan' ? 'Tujuan' : 'Rencana Strategis';
                                
                            document.getElementById('modalContent').innerHTML = data.content;
                            
                            // Show the modal
                            const contentModal = new bootstrap.Modal(document.getElementById('contentModal'));
                            contentModal.show();
                        })
                        .catch(error => {
                            console.error('Error fetching content details:', error);
                            showErrorAlert('Gagal mengambil detail konten.');
                        });
                });
            });
    
            // FIXED: Handle delete button clicks
            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const form = this.closest('form');
                    
                    Swal.fire({
                        title: 'Konfirmasi',
                        text: 'Apakah Anda yakin ingin menghapus konten ini?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#3498db',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya',
                        cancelButtonText: 'Tidak'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Submit the form directly
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>

<script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- <link rel="stylesheet" href="{{ asset('dashboard_main/dashboard/sejarah_dashboard.css') }}"> -->
@endsection



