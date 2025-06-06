@extends('subdirektorat-inovasi.admin_hilirisasi.index')
<link rel="stylesheet" href="{{ asset('dashboard_main/dashboard/program_layanan_dashboard.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
@section('content-admin-hilirisasi')
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
            <form id="layanan-form" action="{{ route($routePrefix . '.program-layanan.store') }}" method="POST">
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
                        <input type="text" class="form-control @error('judul') is-invalid @enderror" name="judul"
                            id="judul" value="{{ old('judul') }}">
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
                        <div class="form-text text-muted">Tuliskan deskripsi singkat tentang program layanan (maksimal 1500
                            karakter)</div>
                    </div>
                </div>

                <div class="mb-3 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary" id="simpan-btn">Simpan Program</button>
                </div>
            </form>
        </div>

        <div class="table-data mt-4">
            <div class="order">
                <div class="head d-flex justify-content-between align-items-center mb-3">
                    <h3>Daftar Program Layanan</h3>
                    <div class="search-container">
                        <div class="input-group">
                            <input type="text" id="searchInput" class="form-control" placeholder="Cari program...">
                            <button class="btn btn-primary" type="button">
                                <i class='bx bx-search'></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped" id="layanan-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Icon</th>
                                <th>Judul</th>
                                <th>Deskripsi</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($programs as $key => $program)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td><i class="{{ $program->icon }} fa-lg"></i></td>
                                    <td>{{ $program->judul }}</td>
                                    <td>{{ Str::limit(strip_tags($program->deskripsi), 50) }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-sm btn-warning edit-program"
                                                data-id="{{ $program->id }}">
                                                <i class='bx bx-edit'></i> Edit
                                            </button>
                                            <form method="POST"
                                                action="{{ route($routePrefix . '.program-layanan.destroy', $program->id) }}"
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
                                <div class="form-text text-muted">Masukkan judul program layanan (maksimal 50 karakter)
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="edit_deskripsi" class="form-label">Deskripsi</label>
                                <textarea class="form-control" name="deskripsi" id="edit_deskripsi" rows="3"></textarea>
                                <div class="form-text text-muted">Tuliskan deskripsi singkat tentang program layanan
                                    (maksimal 1500 karakter)</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="edit_status" class="form-label">Status</label>
                                <select class="form-select" name="status" id="edit_status">
                                    <option value="1">Aktif</option>
                                    <option value="0">Non-Aktif</option>
                                </select>
                                <div class="form-text text-muted">Tentukan status program layanan, hanya program aktif yang
                                    akan ditampilkan</div>
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

    <!-- Script section -->
    <script>
        // Set global variables for use in external JS file
        const appConfig = {
            csrfToken: '{{ csrf_token() }}',
            routePrefix: '{{ $routePrefix }}'
        };
    </script>

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

                    // Character counter for deskripsi textarea (create new program)
                    const deskripsiTextarea = document.getElementById('deskripsi');
                    const charCountContainer = document.createElement('div');
                    charCountContainer.className = 'char-count mt-1';
                    charCountContainer.innerHTML = '<span id="char-count">0</span>/1500 karakter';
                    deskripsiTextarea.parentNode.insertBefore(charCountContainer, document.querySelector(
                        '.form-text.text-muted'));

                    // Update the counter when CKEditor content changes
                    deskripsiEditor.model.document.on('change:data', () => {
                        const data = deskripsiEditor.getData();
                        const plainText = data.replace(/<[^>]*>/g, ''); // Strip HTML tags
                        const charCount = plainText.length;

                        document.getElementById('char-count').textContent = charCount;

                        // Visual feedback when approaching/exceeding limit
                        if (charCount > 1500) {
                            charCountContainer.classList.add('text-danger');
                            document.getElementById('simpan-btn').disabled = true;
                        } else if (charCount > 1450) {
                            charCountContainer.classList.add('text-warning');
                            charCountContainer.classList.remove('text-danger');
                            document.getElementById('simpan-btn').disabled = false;
                        } else {
                            charCountContainer.classList.remove('text-warning', 'text-danger');
                            document.getElementById('simpan-btn').disabled = false;
                        }
                    });
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

                    // Character counter for edit_deskripsi textarea (edit program)
                    const editDeskripsiTextarea = document.getElementById('edit_deskripsi');
                    const editCharCountContainer = document.createElement('div');
                    editCharCountContainer.className = 'char-count mt-1';
                    editCharCountContainer.innerHTML = '<span id="edit-char-count">0</span>/1500 karakter';
                    editDeskripsiTextarea.parentNode.insertBefore(editCharCountContainer, document
                        .querySelector('#editProgramForm .form-text.text-muted'));

                    // Update the counter when CKEditor content changes in edit mode
                    editDeskripsiEditor.model.document.on('change:data', () => {
                        const data = editDeskripsiEditor.getData();
                        const plainText = data.replace(/<[^>]*>/g, ''); // Strip HTML tags
                        const charCount = plainText.length;

                        document.getElementById('edit-char-count').textContent = charCount;

                        // Visual feedback when approaching/exceeding limit
                        if (charCount > 1500) {
                            editCharCountContainer.classList.add('text-danger');
                            document.getElementById('saveEditProgram').disabled = true;
                        } else if (charCount > 1450) {
                            editCharCountContainer.classList.add('text-warning');
                            editCharCountContainer.classList.remove('text-danger');
                            document.getElementById('saveEditProgram').disabled = false;
                        } else {
                            editCharCountContainer.classList.remove('text-warning', 'text-danger');
                            document.getElementById('saveEditProgram').disabled = false;
                        }
                    });
                })
                .catch(error => {
                    console.error(error);
                });

            // Check for PHP flash messages
            @if (session('success'))
                showSuccessAlert("{{ session('success') }}");
            @endif

            @if (session('error'))
                showErrorAlert("{{ session('error') }}");
            @endif

            // Handle delete button clicks
            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const form = this.closest('form');

                    showConfirmationDialog('Apakah Anda yakin ingin menghapus program layanan ini?',
                        () => {
                            form.submit();
                        });
                });
            });

            // Handle edit button clicks
            document.querySelectorAll('.edit-program').forEach(button => {
                button.addEventListener('click', function() {
                    const programId = this.dataset.id;
                    const routePrefix = '{{ $routePrefix }}';

                    // Convert route prefix with dots to path with slashes
                    const routePath = routePrefix.replace(/\./g, '/');

                    // Fetch program details via AJAX
                    fetch(`/${routePath}/program-layanan/${programId}/detail`)
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
                            document.getElementById('edit_status').value = data.status ? '1' :
                                '0';

                            // Set content to the CKEditor
                            if (editDeskripsiEditor) {
                                editDeskripsiEditor.setData(data.deskripsi);

                                // Update character counter after setting data
                                setTimeout(() => {
                                    const editorData = editDeskripsiEditor.getData();
                                    const plainText = editorData.replace(/<[^>]*>/g,
                                        '');
                                    const charCount = plainText.length;
                                    const editCharCountContainer = document
                                        .querySelector('#editProgramModal .char-count');

                                    document.getElementById('edit-char-count')
                                        .textContent = charCount;

                                    if (charCount > 1500) {
                                        editCharCountContainer.classList.add(
                                            'text-danger');
                                        document.getElementById('saveEditProgram')
                                            .disabled = true;
                                    } else if (charCount > 1450) {
                                        editCharCountContainer.classList.add(
                                            'text-warning');
                                        editCharCountContainer.classList.remove(
                                            'text-danger');
                                        document.getElementById('saveEditProgram')
                                            .disabled = false;
                                    } else {
                                        editCharCountContainer.classList.remove(
                                            'text-warning', 'text-danger');
                                        document.getElementById('saveEditProgram')
                                            .disabled = false;
                                    }
                                }, 100); // Short timeout to ensure editor is populated
                            }

                            // Set the form action with correct path structure
                            const form = document.getElementById('editProgramForm');
                            form.action = `/${routePath}/program-layanan/${programId}`;

                            // Show the modal
                            new bootstrap.Modal(document.getElementById('editProgramModal'))
                                .show();
                        })
                        .catch(error => {
                            console.error('Error fetching program details:', error);
                            showErrorAlert('Gagal mengambil data program layanan.');
                        });
                });
            });

            // Handle save button click in edit modal

            document.getElementById('saveEditProgram').addEventListener('click', function() {
                // Get the CKEditor content and update the hidden field
                const editorData = editDeskripsiEditor.getData();
                const plainText = editorData.replace(/<[^>]*>/g, '');

                // Final check before submitting
                if (plainText.length > 1500) {
                    showErrorAlert('Deskripsi tidak boleh lebih dari 1500 karakter.');
                    return;
                }

                // Important: Make sure the CKEditor data is included in the form submission
                // by setting the value of the textarea before creating FormData
                document.getElementById('edit_deskripsi').value = editorData;

                const form = document.getElementById('editProgramForm');
                const formData = new FormData(form);

                // Log the form data to ensure deskripsi is included
                console.log("Form data being sent:");
                for (let pair of formData.entries()) {
                    console.log(pair[0] + ': ' + pair[1]);
                }

                fetch(form.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            return response.json().then(errorData => {
                                throw new Error(JSON.stringify(errorData));
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            // Close the modal
                            const modalElement = document.getElementById('editProgramModal');
                            const modal = bootstrap.Modal.getInstance(modalElement);
                            modal.hide();

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
                        try {
                            const errorData = JSON.parse(error.message);
                            if (errorData.errors && errorData.errors.deskripsi) {
                                showErrorAlert('Error: ' + errorData.errors.deskripsi[0]);
                            } else {
                                showErrorAlert('Gagal menyimpan perubahan: ' + error.message);
                            }
                        } catch (e) {
                            showErrorAlert('Gagal menyimpan perubahan.');
                        }
                    });
            });
            // Add form submit validation for new program form
            document.getElementById('layanan-form').addEventListener('submit', function(e) {
                if (deskripsiEditor) {
                    const editorData = deskripsiEditor.getData();
                    const plainText = editorData.replace(/<[^>]*>/g, '');

                    if (plainText.length > 1500) {
                        e.preventDefault();
                        showErrorAlert('Deskripsi tidak boleh lebih dari 1500 karakter.');
                        return false;
                    }
                }
            });
        });

        //search
        const searchInput = document.getElementById('searchInput');

        searchInput.addEventListener('keyup', function() {
            const searchText = this.value.toLowerCase();
            const table = document.getElementById('layanan-table');
            const rows = table.getElementsByTagName('tr');

            // Start from index 1 to skip the header row
            for (let i = 1; i < rows.length; i++) {
                const rowData = rows[i].textContent.toLowerCase();
                if (rowData.includes(searchText)) {
                    rows[i].style.display = '';
                } else {
                    rows[i].style.display = 'none';
                }
            }
        });
    </script>

    <style>

    </style>
@endsection
