@extends('admin.admin')

@section('contentadmin')
<script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="head-title">
    <div class="left">
        <h1>Program Layanan</h1>
        <ul class="breadcrumb">
            <li>
                <a href="#">Dashboard</a>
            </li>
            <li><i class='bx bx-chevron-right'></i></li>
            <li>
                <a class="active" href="#">Kelola Program Layanan</a>
            </li>
        </ul>
    </div>
</div>

<div class="table-data">
    <div class="order">
        <div class="head">
            <h3>Input Program Layanan</h3>
        </div> 
        <form id="layanan-form" action="{{ route('admin.program-layanan.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="icon" class="form-label">Icon</label>
                    <select class="form-select @error('icon') is-invalid @enderror" name="icon" id="icon">
                        <option value="">Pilih Icon</option>
                        <option value="fas fa-graduation-cap">🎓 Pendidikan</option>
                        <option value="fas fa-book">📚 Buku</option>
                        <option value="fas fa-money-bill-wave">💰 Keuangan</option>
                        <option value="fas fa-certificate">🏆 Sertifikasi</option>
                        <option value="fas fa-hands-helping">🤝 Bantuan</option>
                        <option value="fas fa-handshake">👥 Kerjasama</option>
                        <option value="fas fa-users">👨‍👩‍👧‍👦 Komunitas</option>
                        <option value="fas fa-building">🏢 Institusi</option>
                        <option value="fas fa-university">🏛️ Universitas</option>
                        <option value="fas fa-chart-line">📈 Pengembangan</option>
                    </select>
                    @error('icon')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-text text-muted">Pilih icon yang mewakili program layanan</div>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="judul" class="form-label">Judul Program</label>
                    <input type="text" class="form-control @error('judul') is-invalid @enderror" name="judul" id="judul" value="{{ old('judul') }}">
                    @error('judul')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-text text-muted">Masukkan judul program layanan (maksimal 50 karakter)</div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi</label>
                    <textarea class="form-control @error('deskripsi') is-invalid @enderror" name="deskripsi" id="deskripsi" rows="3">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-text text-muted">Tuliskan deskripsi singkat tentang program layanan (maksimal 500 karakter)</div>
                </div>
            </div>

            <div class="mb-3 d-flex justify-content-end">
                <button type="submit" class="btn btn-primary" id="simpan-btn">Simpan Program</button>
            </div>
        </form>
    </div>

    <div class="table-data mt-4">
        <div class="order">
            <div class="head">
                <h3>Daftar Program Layanan</h3>
            </div>
            
            <div class="table-responsive">
                <table class="table table-striped" id="layanan-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Icon</th>
                            <th>Judul</th>
                            <th>Deskripsi</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($programs as $key => $program)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td><i class="{{ $program->icon }}"></i></td>
                            <td>{{ $program->judul }}</td>
                            <td>{{ Str::limit(strip_tags($program->deskripsi), 50) }}</td>
                            <td>
                                <span class="badge bg-{{ $program->status ? 'success' : 'secondary' }}">
                                    {{ $program->status ? 'Aktif' : 'Non-Aktif' }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-warning edit-program" 
                                            data-id="{{ $program->id }}">
                                        <i class='bx bx-edit'></i> Edit
                                    </button>
                                    <form method="POST" action="{{ route('admin.program-layanan.destroy', $program->id) }}" class="delete-form">
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

<!-- Modal untuk mengedit program layanan -->
<div class="modal fade" id="editProgramModal" tabindex="-1" aria-labelledby="editProgramModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProgramModalLabel">Edit Program Layanan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editProgramForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_icon" class="form-label">Icon</label>
                            <select class="form-select" name="icon" id="edit_icon">
                                <option value="">Pilih Icon</option>
                                <option value="fas fa-graduation-cap">🎓 Pendidikan</option>
                                <option value="fas fa-book">📚 Buku</option>
                                <option value="fas fa-money-bill-wave">💰 Keuangan</option>
                                <option value="fas fa-certificate">🏆 Sertifikasi</option>
                                <option value="fas fa-hands-helping">🤝 Bantuan</option>
                                <option value="fas fa-handshake">👥 Kerjasama</option>
                                <option value="fas fa-users">👨‍👩‍👧‍👦 Komunitas</option>
                                <option value="fas fa-building">🏢 Institusi</option>
                                <option value="fas fa-university">🏛️ Universitas</option>
                                <option value="fas fa-chart-line">📈 Pengembangan</option>
                            </select>
                            <div class="form-text text-muted">Pilih icon yang mewakili program layanan</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_judul" class="form-label">Judul Program</label>
                            <input type="text" class="form-control" name="judul" id="edit_judul">
                            <div class="form-text text-muted">Masukkan judul program layanan (maksimal 50 karakter)</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="edit_deskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control" name="deskripsi" id="edit_deskripsi" rows="3"></textarea>
                            <div class="form-text text-muted">Tuliskan deskripsi singkat tentang program layanan (maksimal 200 karakter)</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="edit_status" class="form-label">Status</label>
                            <select class="form-select" name="status" id="edit_status">
                                <option value="1">Aktif</option>
                                <option value="0">Non-Aktif</option>
                            </select>
                            <div class="form-text text-muted">Tentukan status program layanan, hanya program aktif yang akan ditampilkan</div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="saveEditProgram">Simpan Perubahan</button>
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
    
    // Global variable for editor instances
    let deskripsiEditor;
    let editDeskripsiEditor;
    
    // Initialize all functionality when DOM is loaded
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize CKEditor for new program
        ClassicEditor
            .create(document.querySelector('#deskripsi'), {
                toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|',
                    'undo', 'redo'
                ]
            })
            .then(editor => {
                deskripsiEditor = editor;
            })
            .catch(error => {
                console.error(error);
            });

        // Initialize CKEditor for edit form
        ClassicEditor
            .create(document.querySelector('#edit_deskripsi'), {
                toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|',
                    'undo', 'redo'
                ]
            })
            .then(editor => {
                editDeskripsiEditor = editor;
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
                
                showConfirmationDialog('Apakah Anda yakin ingin menghapus program layanan ini?', () => {
                    form.submit();
                });
            });
        });
        
        // Handle edit button clicks
        document.querySelectorAll('.edit-program').forEach(button => {
            button.addEventListener('click', function() {
                const programId = this.dataset.id;

                // Fetch program details via AJAX
                fetch(`/admin/program-layanan/${programId}/detail`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        // Populate the edit form
                        document.getElementById('edit_judul').value = data.judul;
                        document.getElementById('edit_icon').value = data.icon;
                        document.getElementById('edit_status').value = data.status ? '1' : '0';

                        // Set content to the CKEditor
                        if (editDeskripsiEditor) {
                            editDeskripsiEditor.setData(data.deskripsi);
                        }

                        // Set the form action
                        const form = document.getElementById('editProgramForm');
                        form.action = `/admin/program-layanan/${programId}`;

                        // Show the modal
                        new bootstrap.Modal(document.getElementById('editProgramModal')).show();
                    })
                    .catch(error => {
                        console.error('Error fetching program details:', error);
                        showErrorAlert('Gagal mengambil data program layanan.');
                    });
            });
        });

        // Handle save button click in edit modal
        document.getElementById('saveEditProgram').addEventListener('click', function() {
            const editorData = editDeskripsiEditor.getData();
            const form = document.getElementById('editProgramForm');
            const formData = new FormData(form);

            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Close the modal
                    bootstrap.Modal.getInstance(document.getElementById('editProgramModal')).hide();

                    // Show success message
                    showSuccessAlert(data.message || 'Program layanan berhasil diperbarui!');
                    
                    // Refresh the page after a short delay
                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                } else {
                    showErrorAlert(data.message || 'Gagal menyimpan perubahan.');
                }
            })
            .catch(error => {
                console.error('Error saving program:', error);
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

    /* Custom styles for CKEditor */
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