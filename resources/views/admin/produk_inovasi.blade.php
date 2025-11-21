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
            {{-- Nama Produk --}}
            <div class="mb-3">
                <label for="nama_produk" class="form-label">Nama Produk</label>
                <input type="text" class="form-control @error('nama_produk') is-invalid @enderror" name="nama_produk" id="nama_produk" value="{{ old('nama_produk') }}" required>
                @error('nama_produk')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            {{-- Inovator (Multiple) --}}
            <div id="inovator-container" class="mb-3">
                <label class="form-label">Inovator</label>
                <div class="input-group mb-2">
                    <input type="text" class="form-control @error('inovator.0') is-invalid @enderror" name="inovator[]" required>
                    <button type="button" class="btn btn-success" id="add-inovator-btn">+</button>
                </div>
                @error('inovator.*')<div class="text-danger mt-1">{{ $message }}</div>@enderror
            </div>
            
            <div class="row">
                {{-- Nomor Paten --}}
                <div class="col-md-6 mb-3">
                    <label for="nomor_paten" class="form-label">Nomor Sertifikasi (Opsional)</label>
                    <input type="text" class="form-control @error('nomor_paten') is-invalid @enderror" name="nomor_paten" id="nomor_paten" value="{{ old('nomor_paten') }}">
                    @error('nomor_paten')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                {{-- Kategori --}}
                <div class="col-md-6 mb-3">
                    <label for="kategori" class="form-label">Kategori</label>
                    <select class="form-control @error('kategori') is-invalid @enderror" name="kategori" id="kategori" required>
                        <option value="HKI" {{ old('kategori') == 'HKI' ? 'selected' : '' }}>HKI</option>
                        <option value="PATEN" {{ old('kategori') == 'PATEN' ? 'selected' : '' }}>PATEN</option>
                    </select>
                    @error('kategori')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            {{-- Deskripsi --}}
            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi Produk</label>
                <textarea class="form-control @error('deskripsi') is-invalid @enderror" name="deskripsi" id="deskripsi" rows="8">{{ old('deskripsi') }}</textarea>
                @error('deskripsi')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="row">
                {{-- Gambar Produk --}}
                <div class="col-md-6 mb-3">
                    <label for="gambar" class="form-label">Gambar Produk (Thumbnail)</label>
                    <input type="file" class="form-control @error('gambar') is-invalid @enderror" name="gambar" id="gambar" accept="image/*" required>
                    @error('gambar')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                {{-- Foto Poster --}}
                <div class="col-md-6 mb-3">
                    <label for="foto_poster" class="form-label">Foto Poster (Opsional)</label>
                    <input type="file" class="form-control @error('foto_poster') is-invalid @enderror" name="foto_poster" id="foto_poster" accept="image/*">
                    @error('foto_poster')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
             <div class="row">
                {{-- Link Ebook --}}
                 <div class="col-md-12 mb-3">
                    <label for="link_ebook" class="form-label">Link E-Book (Opsional)</label>
                    <input type="url" class="form-control @error('link_ebook') is-invalid @enderror" name="link_ebook" id="link_ebook" value="{{ old('link_ebook') }}">
                    @error('link_ebook')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            {{-- Video Section --}}
            <div class="mb-3">
                <label class="form-label">Video (Opsional)</label>
                <div id="create-video-container">
                    {{-- Video inputs will be added here by JS --}}
                </div>
                <button type="button" class="btn btn-sm btn-success mt-2" id="add-video-btn">Tambah Video</button>
            </div>


            <div class="mb-3 d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Simpan Produk</button>
            </div>
        </form>
    </div>
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
                        <th>Kategori</th>
                        <th>Gambar</th>
                        <th>Poster</th>
                        <th>Video</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($produkInovasi as $index => $produk)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $produk->nama_produk }}</td>
                       <td>{{ $produk->inovator }}</td> 
                        <td>{{ $produk->kategori }}</td>
                        <td><button class="btn btn-sm btn-info view-image" data-image="{{ asset('storage/' . $produk->gambar) }}">Lihat</button></td>
                        <td>
                            @if($produk->foto_poster)
                            <button class="btn btn-sm btn-info view-image" data-image="{{ asset('storage/' . $produk->foto_poster) }}">Lihat</button>
                            @else - @endif
                        </td>
                         <td>
                            @if($produk->videos->count() > 0)
                                <button class="btn btn-sm btn-info view-videos" data-id="{{ $produk->id }}">Lihat ({{ $produk->videos->count() }})</button>
                            @else - @endif
                        </td>
                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-warning edit-produk" data-id="{{ $produk->id }}">Edit</button>
                                <form method="POST" action="{{ route($routePrefix . '.produk_inovasi.destroy', $produk->id) }}" class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-danger delete-btn">Delete</button>
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
                    <h5 class="modal-title" id="imageModalLabel">Gambar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalImage" src="" class="img-fluid" alt="Gambar">
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal untuk menampilkan video -->
    <div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="videoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="videoModalLabel">Video</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center" id="view-video-container">
                    {{-- Video will be inserted here by JS --}}
                </div>
            </div>
        </div>
    </div>


    <!-- Modal untuk mengedit produk -->
    <div class="modal fade" id="editProdukModal" tabindex="-1" aria-labelledby="editProdukModalLabel" aria-hidden="true">
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
                        {{-- Nama Produk --}}
                        <div class="mb-3">
                            <label for="edit_nama_produk" class="form-label">Nama Produk</label>
                            <input type="text" class="form-control" name="nama_produk" id="edit_nama_produk" required>
                        </div>
    
                        {{-- Inovator (Multiple) --}}
                        <div id="edit-inovator-container" class="mb-3">
                            <label class="form-label">Inovator</label>
                            {{-- Inovator fields will be added here by JS --}}
                        </div>
                        <button type="button" class="btn btn-sm btn-success mb-3" id="edit-add-inovator-btn">+</button>
    
                        <div class="row">
                            {{-- Nomor Paten --}}
                            <div class="col-md-6 mb-3">
                                <label for="edit_nomor_paten" class="form-label">Nomor Sertifikasi (Opsional)</label>
                                <input type="text" class="form-control" name="nomor_paten" id="edit_nomor_paten">
                            </div>
                            {{-- Kategori --}}
                            <div class="col-md-6 mb-3">
                                <label for="edit_kategori" class="form-label">Kategori</label>
                                <select class="form-control" name="kategori" id="edit_kategori" required>
                                    <option value="HKI">HKI</option>
                                    <option value="PATEN">PATEN</option>
                                </select>
                            </div>
                        </div>
    
                        {{-- Deskripsi --}}
                        <div class="mb-3">
                            <label for="edit_deskripsi" class="form-label">Deskripsi Produk</label>
                            <textarea class="form-control" name="deskripsi" id="edit_deskripsi" rows="8"></textarea>
                        </div>
    
                        <div class="row">
                            {{-- Gambar Produk --}}
                            <div class="col-md-6 mb-3">
                                <label for="edit_gambar" class="form-label">Gambar Baru (Opsional)</label>
                                <input type="file" class="form-control" name="gambar" id="edit_gambar" accept="image/*">
                                <div class="mt-2">
                                    <p>Gambar saat ini:</p>
                                    <img id="current_gambar" src="" class="img-fluid mt-2" style="max-height: 150px; display: none;" alt="Current Gambar">
                                </div>
                            </div>
                            {{-- Foto Poster --}}
                            <div class="col-md-6 mb-3">
                                <label for="edit_foto_poster" class="form-label">Foto Poster Baru (Opsional)</label>
                                <input type="file" class="form-control" name="foto_poster" id="edit_foto_poster" accept="image/*">
                                <div class="mt-2">
                                    <p>Poster saat ini:</p>
                                    <img id="current_foto_poster" src="" class="img-fluid mt-2" style="max-height: 150px; display: none;" alt="Current Poster">
                                </div>
                            </div>
                        </div>
    
                         {{-- Link Ebook --}}
                        <div class="mb-3">
                            <label for="edit_link_ebook" class="form-label">Link E-Book (Opsional)</label>
                            <input type="url" class="form-control" name="link_ebook" id="edit_link_ebook">
                        </div>
    
                        {{-- Video Section --}}
                        <div class="mb-3">
                            <label class="form-label">Video (Opsional)</label>
                            <div id="edit-video-container">
                                {{-- Edit video inputs will be added here by JS --}}
                            </div>
                            <button type="button" class="btn btn-sm btn-success mt-2" id="edit-add-video-btn">Tambah Video</button>
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
            // =================================================================
            // SCRIPTS FOR CREATE FORM
            // =================================================================

            // Add Inovator in Create Form
            document.getElementById('add-inovator-btn').addEventListener('click', function() {
                const container = document.getElementById('inovator-container');
                const newInputGroup = document.createElement('div');
                newInputGroup.className = 'input-group mb-2';
                newInputGroup.innerHTML = `
                    <input type="text" class="form-control" name="inovator[]" required>
                    <button type="button" class="btn btn-danger remove-inovator-btn">-</button>
                `;
                container.appendChild(newInputGroup);
            });

            // Remove Inovator in Create Form
            document.getElementById('inovator-container').addEventListener('click', function(e) {
                if (e.target && e.target.classList.contains('remove-inovator-btn')) {
                    e.target.closest('.input-group').remove();
                }
            });

            // =================================================================
            // SCRIPTS FOR MULTIPLE VIDEOS (CREATE FORM)
            // =================================================================
            let createVideoIndex = 0;

            function addCreateVideoField() {
                const container = document.getElementById('create-video-container');
                const newVideoGroup = document.createElement('div');
                newVideoGroup.className = 'video-group border rounded p-3 mb-3';
                const videoKey = 'videos[' + createVideoIndex + ']';

                newVideoGroup.innerHTML = `
                    <div class="d-flex justify-content-between mb-2">
                        <strong>Video ${createVideoIndex + 1}</strong>
                        <button type="button" class="btn btn-sm btn-danger remove-video-btn">Hapus</button>
                    </div>
                    <div class="mb-2">
                        <select class="form-control video-type-select" name="${videoKey}[type]">
                            <option value="youtube" selected>YouTube</option>
                            <option value="mp4">Upload MP4</option>
                        </select>
                    </div>
                    <div class="youtube-input-group">
                        <label class="form-label">Link Video YouTube</label>
                        <input type="url" class="form-control" name="${videoKey}[path_youtube]">
                    </div>
                    <div class="mp4-input-group" style="display:none;">
                        <label class="form-label">Upload File MP4</label>
                        <input type="file" class="form-control" name="${videoKey}[path_mp4]" accept="video/mp4">
                    </div>
                `;
                container.appendChild(newVideoGroup);
                createVideoIndex++;
            }

            document.getElementById('add-video-btn').addEventListener('click', addCreateVideoField);

            document.getElementById('create-video-container').addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-video-btn')) {
                    e.target.closest('.video-group').remove();
                }
            });

            document.getElementById('create-video-container').addEventListener('change', function(e) {
                if (e.target.classList.contains('video-type-select')) {
                    const group = e.target.closest('.video-group');
                    const youtubeInput = group.querySelector('.youtube-input-group');
                    const mp4Input = group.querySelector('.mp4-input-group');
                    const youtubeField = youtubeInput.querySelector('input');
                    const mp4Field = mp4Input.querySelector('input');
                    
                    if (e.target.value === 'youtube') {
                        youtubeInput.style.display = 'block';
                        mp4Input.style.display = 'none';
                        mp4Field.value = '';
                    } else {
                        youtubeInput.style.display = 'none';
                        mp4Input.style.display = 'block';
                        youtubeField.value = '';
                    }
                }
            });

            // =================================================================
            // SCRIPTS FOR EDIT MODAL
            // =================================================================
            let editVideoIndex = 0;

            function addEditInovatorField(value = '') {
                const container = document.getElementById('edit-inovator-container');
                const newInputGroup = document.createElement('div');
                newInputGroup.className = 'input-group mb-2';
                newInputGroup.innerHTML = `
                    <input type="text" class="form-control" name="inovator[]" value="${value}" required>
                    <button type="button" class="btn btn-danger remove-inovator-btn">-</button>
                `;
                container.appendChild(newInputGroup);
            }

             document.getElementById('edit-inovator-container').addEventListener('click', function(e) {
                if (e.target && e.target.classList.contains('remove-inovator-btn')) {
                    e.target.closest('.input-group').remove();
                }
            });

            document.getElementById('edit-add-inovator-btn').addEventListener('click', function() {
                addEditInovatorField();
            });

            function addEditVideoField(video = {}) {
                const container = document.getElementById('edit-video-container');
                const videoId = video.id || null;
                const type = video.type || 'youtube';
                const path = video.path || '';
                const newVideoGroup = document.createElement('div');
                newVideoGroup.className = 'video-group border rounded p-3 mb-3';
                const videoKey = 'videos[' + editVideoIndex + ']';
                const pathYoutube = (type === 'youtube') ? path : '';

                newVideoGroup.innerHTML = `
                    <div class="d-flex justify-content-between mb-2">
                        <strong>Video ${editVideoIndex + 1}</strong>
                        <button type="button" class="btn btn-sm btn-danger remove-video-btn">Hapus</button>
                    </div>
                    <input type="hidden" name="${videoKey}[id]" value="${videoId || ''}">
                    <div class="mb-2">
                        <select class="form-control video-type-select" name="${videoKey}[type]">
                            <option value="youtube" ${type === 'youtube' ? 'selected' : ''}>YouTube</option>
                            <option value="mp4" ${type === 'mp4' ? 'selected' : ''}>Upload MP4</option>
                        </select>
                    </div>
                    <div class="youtube-input-group" style="display:${type === 'youtube' ? 'block' : 'none'};">
                        <label class="form-label">Link Video YouTube</label>
                        <input type="url" class="form-control" name="${videoKey}[path_youtube]" value="${pathYoutube}">
                    </div>
                    <div class="mp4-input-group" style="display:${type === 'mp4' ? 'block' : 'none'};">
                        <label class="form-label">Upload File MP4 Baru (Opsional)</label>
                        <input type="file" class="form-control" name="${videoKey}[path_mp4]" accept="video/mp4">
                        ${(type === 'mp4' && path) ? `<div class="mt-2">Video saat ini: <a href="/storage/${path}" target="_blank" rel="noopener noreferrer">Lihat Video</a></div>` : ''}
                    </div>
                `;
                container.appendChild(newVideoGroup);
                editVideoIndex++;
            }

            document.getElementById('edit-add-video-btn').addEventListener('click', function() {
                addEditVideoField();
            });

            document.getElementById('edit-video-container').addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-video-btn')) {
                    e.target.closest('.video-group').remove();
                }
            });

            document.getElementById('edit-video-container').addEventListener('change', function(e) {
                if (e.target.classList.contains('video-type-select')) {
                    const group = e.target.closest('.video-group');
                    const youtubeInput = group.querySelector('.youtube-input-group');
                    const mp4Input = group.querySelector('.mp4-input-group');
                    const youtubeField = youtubeInput.querySelector('input');
                    const mp4Field = mp4Input.querySelector('input');

                    if (e.target.value === 'youtube') {
                        youtubeInput.style.display = 'block';
                        mp4Input.style.display = 'none';
                        mp4Field.value = '';
                    } else {
                        youtubeInput.style.display = 'none';
                        mp4Input.style.display = 'block';
                        youtubeField.value = '';
                    }
                }
            });

            // =================================================================
            // GENERAL & EVENT LISTENERS
            // =================================================================

            // Handle edit button clicks
            document.querySelectorAll('.edit-produk').forEach(button => {
                button.addEventListener('click', function() {
                    const produkId = this.dataset.id;
                    const routePrefix = '{{ $routePrefix }}';
                    const routePath = routePrefix.replace(/\./g, '/');

                    Swal.fire({ title: 'Memuat Data...', text: 'Mohon tunggu', allowOutsideClick: false, didOpen: () => Swal.showLoading() });

                    fetch(`/${routePath}/produk_inovasi/${produkId}/detail`)
                        .then(response => response.ok ? response.json() : Promise.reject('Network response was not ok'))
                        .then(data => {
                            Swal.close();
                            const form = document.getElementById('editProdukForm');
                            form.action = `/${routePath}/produk_inovasi/${produkId}`;

                            // Populate fields
                            document.getElementById('edit_nama_produk').value = data.nama_produk;
                            document.getElementById('edit_nomor_paten').value = data.nomor_paten || '';
                            document.getElementById('edit_kategori').value = data.kategori || 'HKI';
                            document.getElementById('edit_link_ebook').value = data.link_ebook || '';

                            // Populate Inovators
                            const inovatorContainer = document.getElementById('edit-inovator-container');
                            inovatorContainer.innerHTML = ''; // Clear previous
                            const inovators = data.inovator ? data.inovator.split(', ') : [''];
                            inovators.forEach(inovator => addEditInovatorField(inovator));

                            // Set CKEditor content
                            editDeskripsiEditor?.setData(data.deskripsi || '');

                            // Handle images
                            const currentGambar = document.getElementById('current_gambar');
                            if (data.gambar) {
                                currentGambar.src = `/storage/${data.gambar}`;
                                currentGambar.style.display = 'block';
                            } else {
                                currentGambar.style.display = 'none';
                            }
                            
                            const currentPoster = document.getElementById('current_foto_poster');
                            if (data.foto_poster) {
                                currentPoster.src = `/storage/${data.foto_poster}`;
                                currentPoster.style.display = 'block';
                            } else {
                                currentPoster.style.display = 'none';
                            }

                            // Handle video
                            const videoContainer = document.getElementById('edit-video-container');
                            videoContainer.innerHTML = ''; // Clear previous videos
                            editVideoIndex = 0; // Reset index
                            if (data.videos && data.videos.length > 0) {
                                data.videos.forEach(video => {
                                    addEditVideoField(video);
                                });
                            }
                            
                            new bootstrap.Modal(document.getElementById('editProdukModal')).show();
                        })
                        .catch(error => {
                            console.error('Error fetching produk details:', error);
                            Swal.fire('Error!', 'Gagal mengambil data produk.', 'error');
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
                    confirmButtonText: 'Ya, Simpan!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('edit_deskripsi').value = editDeskripsiEditor.getData();
                        const form = document.getElementById('editProdukForm');
                        const formData = new FormData(form);

                        Swal.fire({ title: 'Menyimpan...', allowOutsideClick: false, didOpen: () => Swal.showLoading() });

                        fetch(form.action, {
                                method: 'POST',
                                body: formData,
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                }
                            })
                            .then(response => {
                                if (!response.ok) {
                                    return response.json().then(errorData => {
                                        let errorMessage = errorData.message || 'Terjadi kesalahan saat menyimpan.';
                                        if (errorData.errors) {
                                            errorMessage += '<br><ul>';
                                            for (const key in errorData.errors) {
                                                errorMessage += `<li>${errorData.errors[key][0]}</li>`;
                                            }
                                            errorMessage += '</ul>';
                                        }
                                        throw new Error(errorMessage);
                                    });
                                }
                                return response.json();
                            })
                            .then(data => {
                                if (data.success) {
                                    bootstrap.Modal.getInstance(document.getElementById('editProdukModal')).hide();
                                    Swal.fire('Berhasil!', data.message || 'Produk berhasil diperbarui!', 'success')
                                    .then(() => window.location.reload());
                                } else {
                                    Swal.fire('Gagal!', data.message || 'Gagal menyimpan perubahan.', 'error');
                                }
                            })
                            .catch(error => {
                                console.error('Error saving produk:', error);
                                Swal.fire('Error!', error.message || 'Terjadi kesalahan saat menyimpan.', 'error');
                            });
                    }
                });
            });

             // Shared SweetAlert for form submission (Create and Delete)
            function setupFormSubmission(formSelector, confirmation) {
                 document.querySelectorAll(formSelector).forEach(form => {
                    form.addEventListener('submit', function (e) {
                         e.preventDefault();
                        Swal.fire(confirmation).then((result) => {
                            if (result.isConfirmed) {
                                Swal.fire({ title: 'Memproses...', allowOutsideClick: false, didOpen: () => Swal.showLoading() });
                                this.submit();
                            }
                        });
                    });
                });
                 // Special handling for delete button
                document.querySelectorAll('.delete-btn').forEach(button => {
                    button.addEventListener('click', function() {
                        const form = this.closest('form');
                         Swal.fire(confirmation).then((result) => {
                            if (result.isConfirmed) {
                                Swal.fire({ title: 'Memproses...', allowOutsideClick: false, didOpen: () => Swal.showLoading() });
                                form.submit();
                            }
                        });
                    });
                });
            }

            setupFormSubmission('form[action*="produk_inovasi.store"]', {
                title: 'Konfirmasi', text: 'Simpan produk inovasi baru?', icon: 'question', showCancelButton: true, confirmButtonText: 'Ya, Simpan!', cancelButtonText: 'Batal'
            });
            setupFormSubmission('.delete-form', {
                title: 'Konfirmasi Hapus', text: 'Anda yakin ingin menghapus produk ini?', icon: 'warning', showCancelButton: true, confirmButtonText: 'Ya, Hapus!', cancelButtonText: 'Batal', confirmButtonColor: '#d33'
            });


            // Handle view image & ALL videos
            document.querySelectorAll('.view-image').forEach(button => {
                button.addEventListener('click', function() {
                    document.getElementById('modalImage').src = this.dataset.image;
                    new bootstrap.Modal(document.getElementById('imageModal')).show();
                });
            });

            document.querySelectorAll('.view-videos').forEach(button => {
                button.addEventListener('click', function() {
                    const produkId = this.dataset.id;
                    const routePrefix = appConfig.routePrefix; // Use appConfig for routePrefix
                    const routePath = routePrefix.replace(/\./g, '/');

                    Swal.fire({ title: 'Memuat Video...', text: 'Mohon tunggu', allowOutsideClick: false, didOpen: () => Swal.showLoading() });

                    fetch(`/${routePath}/produk_inovasi/${produkId}/detail`)
                        .then(response => response.ok ? response.json() : Promise.reject('Network response was not ok'))
                        .then(data => {
                            Swal.close();
                            const container = document.getElementById('view-video-container');
                            container.innerHTML = ''; // Clear previous content

                            if (data.videos && data.videos.length > 0) {
                                data.videos.forEach(video => {
                                    let videoHtml = '';
                                    if (video.type === 'youtube') {
                                        const videoId = new URL(video.path).searchParams.get('v');
                                        if (videoId) {
                                            videoHtml = `<div class="mb-4"><iframe width="100%" height="315" src="https://www.youtube.com/embed/${videoId}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe></div>`;
                                        }
                                    } else if (video.type === 'mp4') {
                                        videoHtml = `<div class="mb-4"><video width="100%" height="315" controls><source src="/storage/${video.path}" type="video/mp4">Your browser does not support the video tag.</video></div>`;
                                    }
                                    container.innerHTML += videoHtml;
                                });
                            } else {
                                container.innerHTML = '<p>Tidak ada video untuk produk ini.</p>';
                            }
                            const videoModal = new bootstrap.Modal(document.getElementById('videoModal'));
                            videoModal.show();

                            // Stop video when modal is closed
                            document.getElementById('videoModal').addEventListener('hidden.bs.modal', function () {
                                container.innerHTML = '';
                            });
                        })
                        .catch(error => {
                            console.error('Error fetching videos:', error);
                            Swal.fire('Error!', 'Gagal mengambil data video.', 'error');
                        });
                });
            });


            // Flash message handling
            @if(session('success'))
                Swal.fire('Berhasil!', "{{ session('success') }}", 'success');
            @endif
            @if(session('error'))
                Swal.fire('Error!', "{{ session('error') }}", 'error');
            @endif
        });
    </script>
@endsection
