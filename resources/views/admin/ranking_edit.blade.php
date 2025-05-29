@extends('admin.admin')

    <link rel="stylesheet" href="{{ asset('dashboard_main/dashboard/berita_dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/ckeditor-content.css') }}">

    <script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@section('contentadmin')
    <div class="head-title">
        <div class="left">
            <h1>Edit Peringkat Universitas</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="{{ route($routePrefix . '.dashboard') }}">Dashboard</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a href="{{ route($routePrefix . '.ranking.index') }}">Kelola Peringkat</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a class="active" href="#">Edit Peringkat</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="table-data">
        <div class="order">
            <div class="head">
                <h3>Form Edit Peringkat</h3>
            </div>

            <form method="POST" action="{{ route($routePrefix . '.ranking.update', $ranking->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="judul" class="form-label">Judul Peringkat</label>
                        <input type="text" class="form-control @error('judul') is-invalid @enderror" name="judul"
                            id="judul" value="{{ old('judul', $ranking->judul) }}" required>
                        @error('judul')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text text-muted">Masukkan judul peringkat (maksimal 200 karakter)</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="score_ranking" class="form-label">Skor Peringkat (Optional)</label>
                        <input type="text" class="form-control @error('score_ranking') is-invalid @enderror"
                            name="score_ranking" id="score_ranking" value="{{ old('score_ranking', $ranking->score_ranking) }}">
                        @error('score_ranking')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text text-muted">Masukkan skor peringkat (contoh: 100.0)</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi Peringkat</label>
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" name="deskripsi" id="deskripsi" rows="8" required>{{ old('deskripsi', $ranking->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text text-muted">Tuliskan deskripsi peringkat secara lengkap dan detail</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="gambar" class="form-label">Logo Baru (Opsional)</label>
                        <input type="file" class="form-control @error('gambar') is-invalid @enderror" name="gambar"
                            id="gambar" accept="image/*">
                        @error('gambar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text text-muted">Upload gambar logo peringkat baru jika ingin mengganti (format: JPG, PNG, atau JPEG, max 2MB)</div>
                        @if ($ranking->gambar)
                            <div class="mt-2">
                                <p>Logo saat ini:</p>
                                <img src="{{ asset('storage/' . $ranking->gambar) }}" alt="Logo Peringkat {{ $ranking->judul }}"
                                    class="img-fluid mt-2" style="max-height: 150px;">
                            </div>
                        @endif
                    </div>
                </div>

                <div class="mb-3 d-flex justify-content-end">
                    <a href="{{ route($routePrefix . '.ranking.index') }}" class="btn btn-secondary me-2">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

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
                    data.append('_token', '{{ csrf_token() }}'); // CSRF token for Laravel

                    // Ensure this route is correctly defined in your web.php or admin.php
                    fetch('{{ route($routePrefix . ".ranking.upload") }}', {
                        method: 'POST',
                        body: data,
                    })
                    .then(response => response.json())
                    .then(result => {
                        if (result.error) {
                            // CKEditor 5 expects an object with a message property
                            return reject(result.error.message || 'Upload failed');
                        }
                        resolve({
                            default: result.url
                        });
                    })
                    .catch(error => {
                        console.error('Upload failed:', error);
                        // CKEditor 5 expects an object with a message property or just a string
                        reject(error.message || 'Upload failed due to a network error.');
                    });
                }));
            }

            abort() {
                // This method is called when the upload is aborted.
                return Promise.reject();
            }
        }

        function MyCustomUploadAdapterPlugin(editor) {
            editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
                return new MyUploadAdapter(loader);
            };
        }

        const commonConfig = {
            extraPlugins: [MyCustomUploadAdapterPlugin],
            toolbar: {
                items: [
                    'heading', '|',
                    'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|',
                    'alignment', 'fontColor', 'fontBackgroundColor', '|',
                    'imageUpload', 'imageResize', 'blockQuote', '|', // Ensure 'imageUpload' is here
                    'insertTable', 'undo', 'redo'
                ]
            },
            image: {
                toolbar: [
                    'imageTextAlternative',
                    'imageStyle:inline', 'imageStyle:block', 'imageStyle:side',
                    'toggleImageCaption',
                    'imageResize:25', 'imageResize:50', 'imageResize:75', 'imageResize:original'
                ],
                resizeOptions: [
                    { name: 'imageResize:original', value: null, label: 'Original' },
                    { name: 'imageResize:25', value: '25', label: '25%' },
                    { name: 'imageResize:50', value: '50', label: '50%' },
                    { name: 'imageResize:75', value: '75', label: '75%' }
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
            },
             // Ensure the CSRF token is available if your upload endpoint needs it via headers
            // However, MyUploadAdapter sends it in FormData, so this might not be strictly needed for that plugin
            // but good practice if other CKEditor features make AJAX calls.
            // It's better to have the CSRF token in a meta tag and fetch it in JS if needed elsewhere.
        };

        ClassicEditor
            .create(document.querySelector('#deskripsi'), commonConfig)
            .catch(error => {
                console.error('Error initializing CKEditor:', error);
            });

        // Display success/error messages if redirected with flash data
        document.addEventListener('DOMContentLoaded', function() {
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