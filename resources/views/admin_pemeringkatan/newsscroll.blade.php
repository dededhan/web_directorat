@extends('admin.admin')

<script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@section('contentadmin')
    <div class="head-title">
        <div class="left">
            <h1>Pengumuman Berjalan</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="#">Dashboard</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a class="active" href="#">Kelola Pengumuman</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="table-data">
        <div class="order">
            <div class="head">
                <h3>Input Pengumuman</h3>
            </div> 

            <form id="pengumuman-form" action="{{ route($routePrefix . '.news-scroll.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="judul_pengumuman" class="form-label">Judul Pengumuman</label>
                        <input type="text" class="form-control @error('judul_pengumuman') is-invalid @enderror" 
                            name="judul_pengumuman" id="judul_pengumuman" value="{{ old('judul_pengumuman') }}">
                        @error('judul_pengumuman')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text text-muted">Masukkan judul pengumuman yang akan disorot (maksimal 50 karakter)</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="icon" class="form-label">Icon</label>
                        <select class="form-select @error('icon') is-invalid @enderror" name="icon" id="icon">
                            <option value="">Tanpa Icon</option>
                            <option value="🕌">🕌 Masjid</option>
                            <option value="📚">📚 Buku</option>
                            <option value="🎓">🎓 Wisuda</option>
                            <option value="📣">📣 Pengumuman</option>
                            <option value="🏆">🏆 Prestasi</option>
                            <option value="💰">💰 Beasiswa</option>
                            <option value="🔬">🔬 Penelitian</option>
                            <option value="🎭">🎭 Event</option>
                            <option value="🏫">🏫 Kampus</option>
                            <option value="⚠️">⚠️ Peringatan</option>
                        </select>
                        @error('icon')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text text-muted">Pilih icon yang akan ditampilkan di awal pengumuman</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="isi_pengumuman" class="form-label">Isi Pengumuman</label>
                        <textarea class="form-control @error('isi_pengumuman') is-invalid @enderror" 
                            name="isi_pengumuman" id="isi_pengumuman" rows="3">{{ old('isi_pengumuman') }}</textarea>
                        @error('isi_pengumuman')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text text-muted">Tuliskan isi pengumuman yang akan ditampilkan (maksimal 200 karakter)</div>
                    </div>
                </div>

                <div class="mb-3 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary" id="simpan-btn">Simpan Pengumuman</button>
                </div>
            </form>
        </div>

        <div class="table-data mt-4">
            <div class="order">
                <div class="head">
                    <h3>Daftar Pengumuman Berjalan</h3>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-striped" id="pengumuman-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Icon</th>
                                <th>Judul</th>
                                <th>Isi</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pengumumans as $index => $pengumuman)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $pengumuman->icon }}</td>
                                <td>{{ $pengumuman->judul_pengumuman }}</td>
                                <td>{{ Str::limit(strip_tags($pengumuman->isi_pengumuman), 50) }}</td>
                                <td>
                                    <span class="badge bg-{{ $pengumuman->status ? 'success' : 'secondary' }}">
                                        {{ $pengumuman->status ? 'Aktif' : 'Non-Aktif' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-warning edit-pengumuman" 
                                            data-id="{{ $pengumuman->id }}">
                                            <i class='bx bx-edit'></i> Edit
                                        </button>
                                        <form method="POST" action="{{ route($routePrefix . '.news-scroll.destroy', $pengumuman->id) }}" 
                                            class="delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-danger delete-btn">
                                                <i class='bx bx-trash'></i> Delete
                                            </button>
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

    <!-- Modal untuk mengedit pengumuman -->
    <div class="modal fade" id="editPengumumanModal" tabindex="-1" aria-labelledby="editPengumumanModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPengumumanModalLabel">Edit Pengumuman</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editPengumumanForm" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit_judul_pengumuman" class="form-label">Judul Pengumuman</label>
                                <input type="text" class="form-control" name="judul_pengumuman" id="edit_judul_pengumuman">
                                <div class="form-text text-muted">Masukkan judul pengumuman yang akan disorot (maksimal 50 karakter)</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_icon" class="form-label">Icon</label>
                                <select class="form-select" name="icon" id="edit_icon">
                                    <option value="">Tanpa Icon</option>
                                    <option value="🕌">🕌 Masjid</option>
                                    <option value="📚">📚 Buku</option>
                                    <option value="🎓">🎓 Wisuda</option>
                                    <option value="📣">📣 Pengumuman</option>
                                    <option value="🏆">🏆 Prestasi</option>
                                    <option value="💰">💰 Beasiswa</option>
                                    <option value="🔬">🔬 Penelitian</option>
                                    <option value="🎭">🎭 Event</option>
                                    <option value="🏫">🏫 Kampus</option>
                                    <option value="⚠️">⚠️ Peringatan</option>
                                </select>
                                <div class="form-text text-muted">Pilih icon yang akan ditampilkan di awal pengumuman</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="edit_isi_pengumuman" class="form-label">Isi Pengumuman</label>
                                <textarea class="form-control" name="isi_pengumuman" id="edit_isi_pengumuman" rows="3"></textarea>
                                <div class="form-text text-muted">Tuliskan isi pengumuman yang akan ditampilkan (maksimal 200 karakter)</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="edit_status" class="form-label">Status</label>
                                <select class="form-select" name="status" id="edit_status">
                                    <option value="1">Aktif</option>
                                    <option value="0">Non-Aktif</option>
                                </select>
                                <div class="form-text text-muted">Tentukan status pengumuman, hanya pengumuman aktif yang akan ditampilkan</div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="saveEditPengumuman">Simpan Perubahan</button>
                </div>
            </div>
        </div>
    </div>

    <script>
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
        
        // Global variable for editor instance
        let editPengumumanEditor;
        
        // Initialize all functionality when DOM is loaded
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize CKEditor for new pengumuman
            ClassicEditor
                .create(document.querySelector('#isi_pengumuman'), {
                    toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|',
                        'undo', 'redo'
                    ]
                })
                .catch(error => {
                    console.error(error);
                });

            // Initialize CKEditor for edit form
            ClassicEditor
                .create(document.querySelector('#edit_isi_pengumuman'), {
                    toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|',
                        'undo', 'redo'
                    ]
                })
                .then(editor => {
                    editPengumumanEditor = editor;
                })
                .catch(error => {
                    console.error(error);
                });

            // Check for PHP flash messages
            @if(session('success'))
                showSuccessAlert("{{ session('success') }}");
            @endif
            
            @if(session('error'))
                showErrorAlert("{{ session('error') }}");
            @endif

            // Handle delete button clicks
            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const form = this.closest('form');
                    
                    showConfirmationDialog('Apakah Anda yakin ingin menghapus pengumuman ini?', () => {
                        form.submit();
                    });
                });
            });
            
            // Handle edit button clicks
            document.querySelectorAll('.edit-pengumuman').forEach(button => {
                button.addEventListener('click', function() {
                    const pengumumanId = this.dataset.id;
                    const routePrefix = '{{ $routePrefix }}';
                    
                    // Convert route prefix with dots to path with slashes
                    const routePath = routePrefix.replace(/\./g, '/');

                    // Fetch pengumuman details via AJAX
                    fetch(`/${routePath}/pengumuman/${pengumumanId}/detail`)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            // Populate the edit form
                            document.getElementById('edit_judul_pengumuman').value = data.judul_pengumuman;
                            document.getElementById('edit_icon').value = data.icon;
                            document.getElementById('edit_status').value = data.status ? '1' : '0';

                            // Set content to the CKEditor
                            if (editPengumumanEditor) {
                                editPengumumanEditor.setData(data.isi_pengumuman);
                            }

                            // Set the form action
                            const form = document.getElementById('editPengumumanForm');
                            form.action = `/${routePath}/news-scroll/${pengumumanId}`;

                            // Show the modal
                            new bootstrap.Modal(document.getElementById('editPengumumanModal')).show();
                        })
                        .catch(error => {
                            console.error('Error fetching pengumuman details:', error);
                            showErrorAlert('Gagal mengambil data pengumuman.');
                        });
                });
            });

            // Handle save button click
            document.getElementById('saveEditPengumuman').addEventListener('click', function() {
                const editorData = editPengumumanEditor.getData();
                document.getElementById('edit_isi_pengumuman').value = editorData;

                const form = document.getElementById('editPengumumanForm');
                const formData = new FormData(form);

                fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Close the modal
                        bootstrap.Modal.getInstance(document.getElementById('editPengumumanModal'))
                            .hide();

                        // Show success message
                        showSuccessAlert(data.message || 'Pengumuman berhasil diperbarui!');
                        
                        // Refresh the page after a short delay
                        setTimeout(() => {
                            window.location.reload();
                        }, 1500);
                    } else {
                        showErrorAlert(data.message || 'Gagal menyimpan perubahan.');
                    }
                })
                .catch(error => {
                    console.error('Error saving pengumuman:', error);
                    showErrorAlert('Gagal menyimpan perubahan.');
                });
            });
        });
    </script>

    <style>
        .table-data {
            margin-top: 24px;
        }

        .order {
            background: #fff;
            padding: 24px;
            border-radius: 20px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #3498db;
            box-shadow: none;
        }

        .btn-primary {
            background-color: #3498db;
            border-color: #3498db;
        }

        .btn-primary:hover {
            background-color: #2980b9;
            border-color: #2980b9;
        }

        .table-responsive {
            overflow-x: auto;
        }

        .badge {
            font-size: 0.7em;
        }

        .btn-group {
            display: flex;
            gap: 5px;
        }

        textarea {
            resize: vertical;
        }

        .table th {
            white-space: nowrap;
        }

        /* Custom styles for the news management */
        .ck-editor__editable {
            min-height: 150px;
        }

        /* Alert styling */
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 10px;
        }

        .alert-success {
            background-color: #d4edda;
            border-color: #c3e6cb;
            color: #155724;
        }

        .alert-danger {
            background-color: #f8d7da;
            border-color: #f5c6cb;
            color: #721c24;
        }
    </style>
@endsection