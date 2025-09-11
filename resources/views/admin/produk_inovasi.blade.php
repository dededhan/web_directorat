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
                <select class="form-control" name="video_type" id="video_type">
                    <option value="">-- Pilih Tipe Video --</option>
                    <option value="youtube" {{ old('video_type') == 'youtube' ? 'selected' : '' }}>YouTube</option>
                    <option value="mp4" {{ old('video_type') == 'mp4' ? 'selected' : '' }}>Upload MP4</option>
                </select>
            </div>
            
            {{-- YouTube Input --}}
            <div id="youtube-input" class="mb-3" style="display:{{ old('video_type') == 'youtube' ? 'block' : 'none' }};">
                <label for="video_path_youtube" class="form-label">Link Video YouTube</label>
                <input type="url" class="form-control @error('video_path_youtube') is-invalid @enderror" name="video_path_youtube" value="{{ old('video_path_youtube') }}">
                 @error('video_path_youtube')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            {{-- MP4 Input --}}
            <div id="mp4-input" class="mb-3" style="display:{{ old('video_type') == 'mp4' ? 'block' : 'none' }};">
                <label for="video_path_mp4" class="form-label">Upload File MP4</label>
                <input type="file" class="form-control @error('video_path_mp4') is-invalid @enderror" name="video_path_mp4" accept="video/mp4">
                 @error('video_path_mp4')<div class="invalid-feedback">{{ $message }}</div>@enderror
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
                            @if($produk->video_path)
                            <button class="btn btn-sm btn-info view-video" data-type="{{$produk->video_type}}" data-path="{{ $produk->video_type === 'mp4' ? asset('storage/' . $produk->video_path) : $produk->video_path }}">Lihat</button>
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
                <div class="modal-body text-center" id="video-container">
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
                            <select class="form-control" name="video_type" id="edit_video_type">
                                <option value="">-- Hapus Video --</option>
                                <option value="youtube">YouTube</option>
                                <option value="mp4">Upload MP4</option>
                            </select>
                        </div>
                        
                        {{-- YouTube Input --}}
                        <div id="edit-youtube-input" class="mb-3" style="display:none;">
                            <label for="edit_video_path_youtube" class="form-label">Link Video YouTube</label>
                            <input type="url" class="form-control" name="video_path_youtube" id="edit_video_path_youtube">
                        </div>
    
                        {{-- MP4 Input --}}
                        <div id="edit-mp4-input" class="mb-3" style="display:none;">
                            <label for="edit_video_path_mp4" class="form-label">Upload File MP4 Baru</label>
                            <input type="file" class="form-control" name="video_path_mp4" id="edit_video_path_mp4" accept="video/mp4">
                            <div id="current_video_mp4_info" class="mt-2"></div>
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

            // Toggle Video Input in Create Form
            document.getElementById('video_type').addEventListener('change', function() {
                document.getElementById('youtube-input').style.display = (this.value === 'youtube') ? 'block' : 'none';
                document.getElementById('mp4-input').style.display = (this.value === 'mp4') ? 'block' : 'none';
            });

            // =================================================================
            // SCRIPTS FOR EDIT MODAL
            // =================================================================
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

            // Add Inovator in Edit Modal
            document.getElementById('edit-add-inovator-btn').addEventListener('click', function() {
                addEditInovatorField();
            });

            // Remove Inovator in Edit Modal
            document.getElementById('edit-inovator-container').addEventListener('click', function(e) {
                if (e.target && e.target.classList.contains('remove-inovator-btn')) {
                    // Prevent removing the last innovator
                    if (document.querySelectorAll('#edit-inovator-container .input-group').length > 1) {
                        e.target.closest('.input-group').remove();
                    } else {
                        Swal.fire('Info', 'Minimal harus ada satu inovator.', 'info');
                    }
                }
            });
             
            // Toggle Video Input in Edit Modal
            document.getElementById('edit_video_type').addEventListener('change', function() {
                document.getElementById('edit-youtube-input').style.display = (this.value === 'youtube') ? 'block' : 'none';
                document.getElementById('edit-mp4-input').style.display = (this.value === 'mp4') ? 'block' : 'none';
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
                            const videoTypeSelect = document.getElementById('edit_video_type');
                            const youtubeInput = document.getElementById('edit-youtube-input');
                            const mp4Input = document.getElementById('edit-mp4-input');
                            const youtubePath = document.getElementById('edit_video_path_youtube');
                            const currentMp4Info = document.getElementById('current_video_mp4_info');

                            videoTypeSelect.value = data.video_type || '';
                            youtubeInput.style.display = 'none';
                            mp4Input.style.display = 'none';
                            youtubePath.value = '';
                            currentMp4Info.innerHTML = '';

                            if (data.video_type === 'youtube') {
                                youtubeInput.style.display = 'block';
                                youtubePath.value = data.video_path || '';
                            } else if (data.video_type === 'mp4') {
                                mp4Input.style.display = 'block';
                                if(data.video_path) {
                                    currentMp4Info.innerHTML = `<p>Video saat ini: <a href="/storage/${data.video_path}" target="_blank">Lihat Video</a></p>`;
                                }
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
                            .then(response => response.json())
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
                                Swal.fire('Error!', 'Terjadi kesalahan saat menyimpan.', 'error');
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


            // Handle view image & video
            document.querySelectorAll('.view-image').forEach(button => {
                button.addEventListener('click', function() {
                    document.getElementById('modalImage').src = this.dataset.image;
                    new bootstrap.Modal(document.getElementById('imageModal')).show();
                });
            });
             document.querySelectorAll('.view-video').forEach(button => {
                button.addEventListener('click', function() {
                    const type = this.dataset.type;
                    const path = this.dataset.path;
                    const container = document.getElementById('video-container');
                    
                    if (type === 'youtube') {
                        const videoId = new URL(path).searchParams.get('v');
                        container.innerHTML = `<iframe width="100%" height="400" src="https://www.youtube.com/embed/${videoId}" frameborder="0" allowfullscreen></iframe>`;
                    } else {
                        container.innerHTML = `<video width="100%" controls><source src="${path}" type="video/mp4">Your browser does not support the video tag.</video>`;
                    }
                    const videoModal = new bootstrap.Modal(document.getElementById('videoModal'));
                    videoModal.show();

                    // Stop video when modal is closed
                     document.getElementById('videoModal').addEventListener('hidden.bs.modal', function () {
                        container.innerHTML = '';
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
