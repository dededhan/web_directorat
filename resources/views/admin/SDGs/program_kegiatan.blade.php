@extends('admin.admin')

@section('contentadmin')
    <div class="head-title">
        <div class="left">
            <h1>Program & Kegiatan</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a class="active" href="#">Input Program & Kegiatan</a>
                </li>
            </ul>
        </div>
    </div>


    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="table-data">
        <div class="order">
            <div class="head">
                <h3>Input Program & Kegiatan</h3>
            </div>

            <form id="program-kegiatan-form" action="{{ route('admin.SDGs.program-kegiatan.store') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="judul" class="form-label">Judul</label>
                        <input type="text" class="form-control" name="judul" id="judul"
                            value="{{ old('judul') }}">
                        <div class="form-text text-muted">Masukkan judul program/kegiatan</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="tanggal" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" name="tanggal" id="tanggal"
                            value="{{ old('tanggal') }}">
                        <div class="form-text text-muted">Pilih tanggal program/kegiatan</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="kategori" class="form-label">Kategori</label>
                        <select class="form-select" name="kategori" id="kategori">
                            <option value="">Pilih Kategori</option>
                            <option value="penelitian" {{ old('kategori') == 'penelitian' ? 'selected' : '' }}>Penelitian
                            </option>
                            <option value="pengabdian_masyarakat"
                                {{ old('kategori') == 'pengabdian_masyarakat' ? 'selected' : '' }}>Pengabdian Masyarakat
                            </option>
                            <option value="pendidikan" {{ old('kategori') == 'pendidikan' ? 'selected' : '' }}>Pendidikan
                            </option>
                            <option value="kolaborasi" {{ old('kategori') == 'kolaborasi' ? 'selected' : '' }}>Kolaborasi
                            </option>
                        </select>
                        <div class="form-text text-muted">Pilih kategori program/kegiatan</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control ckeditor" name="deskripsi" id="deskripsi" rows="4">{{ old('deskripsi') }}</textarea>
                        <div class="form-text text-muted">Berikan deskripsi program/kegiatan yang mendukung pencapaian SDGs
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="gambar" class="form-label">Gambar</label>
                        <input type="file" class="form-control" name="gambar" id="gambar" accept="image/*">
                        <div class="form-text text-muted">Upload gambar program/kegiatan (format: JPG, PNG, max 2MB)</div>
                    </div>
                </div>

                <div class="mb-3 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>

        <div class="table-data mt-4">
            <div class="order">
                <div class="head">
                    <h3>Daftar Program & Kegiatan</h3>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped" id="program-kegiatan-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul</th>
                                <th>Tanggal</th>
                                <th>Kategori</th>
                                <th>Gambar</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="program-kegiatan-list">
                            @foreach ($programKegiatans as $index => $program)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $program->judul }}</td>
                                    <td>{{ $program->tanggal->format('Y-m-d') }}</td>
                                    <td>
                                        <span
                                            class="badge 
                                        @if ($program->kategori === 'penelitian') bg-primary
                                        @elseif($program->kategori === 'pengabdian_masyarakat') bg-success
                                        @elseif($program->kategori === 'pendidikan') bg-info
                                        @elseif($program->kategori === 'kolaborasi') bg-warning @endif">
                                            {{ $program->kategori_label }}
                                        </span>
                                    </td>
                                    <td>
                                        @if ($program->path_gambar)
                                            <img src="{{ asset('storage/' . $program->path_gambar) }}" alt="Thumbnail"
                                                class="img-thumbnail" width="100">
                                        @else
                                            No Image
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <button class="btn btn-sm btn-warning edit-program"
                                                data-id="{{ $program->id }}" data-judul="{{ $program->judul }}"
                                                data-tanggal="{{ $program->tanggal->format('Y-m-d') }}"
                                                data-kategori="{{ $program->kategori }}"
                                                data-deskripsi="{{ $program->deskripsi }}">
                                                Edit
                                            </button>
                                            <form
                                                action="{{ route('admin.SDGs.program-kegiatan.destroy', $program->id) }}"
                                                method="POST" class="delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-sm btn-danger delete-program">
                                                    Delete
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

    <!-- Edit Modal -->
    <div class="modal fade" id="editProgramModal" tabindex="-1" role="dialog" aria-labelledby="editProgramModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProgramModalLabel">Edit Program & Kegiatan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="edit-program-form" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="edit_judul" class="form-label">Judul</label>
                                <input type="text" class="form-control" name="judul" id="edit_judul">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit_tanggal" class="form-label">Tanggal</label>
                                <input type="date" class="form-control" name="tanggal" id="edit_tanggal">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_kategori" class="form-label">Kategori</label>
                                <select class="form-select" name="kategori" id="edit_kategori">
                                    <option value="penelitian">Penelitian</option>
                                    <option value="pengabdian_masyarakat">Pengabdian Masyarakat</option>
                                    <option value="pendidikan">Pendidikan</option>
                                    <option value="kolaborasi">Kolaborasi</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="edit_deskripsi" class="form-label">Deskripsi</label>
                                <textarea class="form-control ckeditor" name="deskripsi" id="edit_deskripsi" rows="4"></textarea>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="edit_gambar" class="form-label">Gambar (Opsional)</label>
                                <input type="file" class="form-control" name="gambar" id="edit_gambar"
                                    accept="image/*">
                                <div class="form-text text-muted">Biarkan kosong jika tidak ingin mengubah gambar</div>
                                <div class="mt-2">
                                    <p>Gambar saat ini:</p>
                                    <img id="current_image" src="" class="img-thumbnail mt-2"
                                        style="max-height: 200px;" alt="Current Image">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Include jQuery if not already included -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Include Bootstrap JS and SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Include CKEditor -->
    <script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize CKEditor for input form
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
                    console.error('Error initializing CKEditor:', error);
                });

            // Initialize CKEditor for edit form
            let editDeskripsiEditor;

            // Edit Program Modal
            document.querySelectorAll('.edit-program').forEach(button => {
                button.addEventListener('click', function() {
                    const programId = this.dataset.id;
                    const judul = this.dataset.judul;
                    const tanggal = this.dataset.tanggal;
                    const kategori = this.dataset.kategori;
                    const deskripsi = this.dataset.deskripsi;
                    const modal = new bootstrap.Modal(document.getElementById('editProgramModal'));

                    // Populate form fields
                    document.getElementById('edit_judul').value = judul;
                    document.getElementById('edit_tanggal').value = tanggal;
                    document.getElementById('edit_kategori').value = kategori;

                    // Set action form for update
                    document.getElementById('edit-program-form').action =
                        `/admin/SDGs/program-kegiatan/${programId}`;

                    // Get image
                    fetch(`/admin/SDGs/program-kegiatan/${programId}/detail`)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            // Set the current image if it exists
                            const currentImage = document.getElementById('current_image');
                            if (data.path_gambar) {
                                currentImage.src = `/storage/${data.path_gambar}`;
                                currentImage.style.display = 'block';
                            } else {
                                currentImage.style.display = 'none';
                            }

                            // Initialize CKEditor in the modal
                            if (editDeskripsiEditor) {
                                editDeskripsiEditor.setData(deskripsi);
                            } else {
                                ClassicEditor
                                    .create(document.querySelector('#edit_deskripsi'), {
                                        toolbar: {
                                            items: [
                                                'heading', '|',
                                                'bold', 'italic', 'link',
                                                'bulletedList', 'numberedList', '|',
                                                'blockQuote', 'undo', 'redo'
                                            ]
                                        }
                                    })
                                    .then(editor => {
                                        editDeskripsiEditor = editor;
                                        editDeskripsiEditor.setData(deskripsi);
                                    })
                                    .catch(error => {
                                        console.error(
                                            'Error initializing CKEditor for edit:',
                                            error);
                                    });
                            }

                            // Show modal
                            modal.show();
                        })
                        .catch(error => {
                            console.error('Error fetching program details:', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Failed to fetch program details',
                                timer: 3000
                            });
                        });
                });
            });

            // Handle form submission feedback
            const editForm = document.getElementById('edit-program-form');
            if (editForm) {
                editForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    // Get CKEditor content and update form data
                    if (editDeskripsiEditor) {
                        const editorData = editDeskripsiEditor.getData();
                        document.querySelector('#edit-program-form [name="deskripsi"]').value = editorData;
                    }

                    const formData = new FormData(this);
                    const submitButton = this.querySelector('button[type="submit"]');

                    // Disable button and show loading spinner
                    submitButton.disabled = true;
                    submitButton.innerHTML =
                        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Menyimpan...';

                    // Submit form via AJAX
                    fetch(this.action, {
                            method: 'POST',
                            body: formData
                        })
                        .then(response => response.json())
                        .then(data => {
                            // Reset button
                            submitButton.disabled = false;
                            submitButton.innerHTML = 'Simpan Perubahan';

                            if (data.success) {
                                // Close modal
                                const modal = bootstrap.Modal.getInstance(document.getElementById(
                                    'editProgramModal'));
                                modal.hide();

                                // Show success message
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: 'Program & Kegiatan berhasil diperbarui',
                                    timer: 2000,
                                    showConfirmButton: false
                                }).then(() => {
                                    window.location.reload(); // Reload page to see updated data
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal!',
                                    text: data.message ||
                                        'Terjadi kesalahan saat memperbarui data',
                                    timer: 3000
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            submitButton.disabled = false;
                            submitButton.innerHTML = 'Simpan Perubahan';

                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: 'Terjadi kesalahan saat mengirim data',
                                timer: 3000
                            });
                        });
                });
            }

            // Handle new program form submission with SweetAlert
            const newProgramForm = document.getElementById('program-kegiatan-form');
            if (newProgramForm) {
                newProgramForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    // Show loading indicator
                    Swal.fire({
                        title: 'Menyimpan...',
                        text: 'Mohon tunggu sebentar',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // Submit the form
                    this.submit();
                });
            }

            // Handle delete confirmation
            document.querySelectorAll('.delete-program').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const form = this.closest('form');

                    Swal.fire({
                        title: 'Konfirmasi Hapus',
                        text: "Apakah Anda yakin ingin menghapus program/kegiatan ini?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Show loading indicator
                            Swal.fire({
                                title: 'Menghapus...',
                                text: 'Mohon tunggu sebentar',
                                allowOutsideClick: false,
                                didOpen: () => {
                                    Swal.showLoading();
                                }
                            });

                            // Submit delete form
                            form.submit();
                        }
                    });
                });
            });

            // Handle flash messages with SweetAlert
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    timer: 2000,
                    showConfirmButton: false
                });
            @endif

            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: '{{ session('error') }}',
                    timer: 2000,
                    showConfirmButton: false
                });
            @endif
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

        .img-thumbnail {
            object-fit: cover;
            height: 60px;
        }

        .btn-group {
            display: flex;
            gap: 5px;
        }

        .table th {
            white-space: nowrap;
        }

        #deskripsi {
            resize: vertical;
        }

        /* CKEditor styles */
        .ck-editor__editable {
            min-height: 200px;
        }


        /* :modal  */
        .modal-backdrop {
            z-index: 2001 !important;
        }

        .modal {
            z-index: 2002 !important;
        }

        .table-data {
            margin-top: 24px;
        }

        .order {
            background: #fff;
            padding: 24px;
            border-radius: 20px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }
    </style>
@endsection
