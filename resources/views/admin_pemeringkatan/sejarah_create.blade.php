@extends('admin_pemeringkatan.index')
<link rel="stylesheet" href="{{ asset('dashboard_main/dashboard/sejarah_dashboard.css') }}">
@section('contentadmin_pemeringkatan')
    <div class="head-title">
        <div class="left">
            <h1>Edit Konten Halaman Sejarah</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="#">Dashboard</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a href="{{ route($routePrefix . '.sejarah.index') }}">Kelola Konten Sejarah</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a class="active" href="#">Edit Konten</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="table-data">
        <div class="order">
            <div class="head">
                <h3>Edit Konten</h3>
            </div>

            <form method="POST" action="{{ route($routePrefix . '.sejarah.update', $content->id) }}">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="category" class="form-label">Kategori</label>
                        <select class="form-select @error('category') is-invalid @enderror" name="category" id="category" {{ count($categories) === 1 ? 'disabled' : '' }}>
                            @foreach($categories as $value => $label)
                                <option value="{{ $value }}" {{ (old('category', $content->category) == $value) ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @if(count($categories) === 1)
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
                            @foreach($sections as $value => $label)
                                <option value="{{ $value }}" {{ (old('section', $content->section) == $value) ? 'selected' : '' }}>
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
                        <label for="content_edit" class="form-label">Konten</label>
                        <textarea class="form-control @error('content') is-invalid @enderror" name="content" id="content_edit" rows="8">{{ old('content', $content->content) }}</textarea>
                        @error('content')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text text-muted">Masukkan konten halaman</div>
                    </div>
                </div>

                <div class="mb-3 d-flex justify-content-between">
                    <a href="{{ route($routePrefix . '.sejarah.index') }}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
@endsection




<script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

        // Initialize CKEditor for editing
        ClassicEditor
            .create(document.querySelector('#content_edit'), {
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
    });
</script>
