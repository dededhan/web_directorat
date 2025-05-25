@extends('admin.admin')

<link rel="stylesheet" href="{{ asset('dashboard_main/dashboard/matakuliah_dashboard.css') }}">

@section('contentadmin')
    <div class="head-title">
        <div class="left">
            <h1>Mata Kuliah Sustainability</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a class="active" href="{{ route('admin.matakuliah.index') }}">Input Mata Kuliah</a>
                </li>
            </ul>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Whoops!</strong> Ada beberapa masalah dengan input Anda.<br><br>
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
                <h3>Input Mata Kuliah Sustainability</h3>
            </div> 

            <form id="matakuliah-form" action="{{ route('admin.matakuliah.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="nama_matkul" class="form-label">Nama Mata Kuliah</label>
                        <input type="text" class="form-control @error('nama_matkul') is-invalid @enderror" name="nama_matkul" id="nama_matkul" value="{{ old('nama_matkul') }}">
                        @error('nama_matkul') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        <div class="form-text text-muted">Masukkan nama lengkap mata kuliah.</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="semester" class="form-label">Semester</label>
                        <input type="text" class="form-control @error('semester') is-invalid @enderror" name="semester" id="semester" value="{{ old('semester') }}">
                        @error('semester') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        <div class="form-text text-muted">Contoh: 1, 2, 3, dst.</div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="kode_matkul" class="form-label">Kode Mata Kuliah</label>
                        <input type="text" class="form-control @error('kode_matkul') is-invalid @enderror" name="kode_matkul" id="kode_matkul" value="{{ old('kode_matkul') }}">
                        @error('kode_matkul') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        <div class="form-text text-muted">Contoh: MK001. Harus unik.</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="fakultas" class="form-label">Fakultas</label>
                        <select class="form-select @error('fakultas') is-invalid @enderror" name="fakultas" id="fakultas">
                            <option value="">Pilih Fakultas</option>
                            {{-- Loop through faculties_data if passed from controller, or use static options --}}
                            @php
                                $faculties = $faculties_data ?? [ // Fallback if not passed
                                    'PASCASARJANA' => ['name' => 'Pascasarjana'], 'FIP' => ['name' => 'FIP'],
                                    'FMIPA' => ['name' => 'FMIPA'], 'FPPSI' => ['name' => 'FPsi'],
                                    'FBS' => ['name' => 'FBS'], 'FT' => ['name' => 'FT'],
                                    'FIK' => ['name' => 'FIKK'], 'FIS' => ['name' => 'FISH'], // Assuming FIKK is correct, adjust if FIK
                                    'FE' => ['name' => 'FEB'], 'PROFESI' => ['name' => 'Profesi']
                                ];
                            @endphp
                            @foreach ($faculties as $key => $faculty)
                                <option value="{{ strtolower($key) }}" {{ old('fakultas') == strtolower($key) ? 'selected' : '' }}>{{ $faculty['name'] }}</option>
                            @endforeach
                        </select>
                        @error('fakultas') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        <div class="form-text text-muted">Pilih fakultas penyelenggara.</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="prodi" class="form-label">Program Studi</label>
                        <select class="form-select @error('prodi') is-invalid @enderror" name="prodi" id="prodi" {{ old('fakultas') ? '' : 'disabled' }}>
                            <option value="">Pilih Program Studi</option>
                            {{-- Options will be populated by matakuliah_dashboard.js --}}
                            {{-- If old('prodi') exists, it means there was a validation error, try to reselect --}}
                        </select>
                        @error('prodi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        <div class="form-text text-muted">Pilih program studi (opsional jika mata kuliah level fakultas).</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="rps" class="form-label">RPS Mata Kuliah</label>
                        <input type="file" class="form-control @error('rps') is-invalid @enderror" name="rps" id="rps" accept=".pdf,.doc,.docx">
                        @error('rps') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        <div class="form-text text-muted">Upload RPS (PDF, DOC, DOCX, max 10MB).</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi Mata Kuliah</label>
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" name="deskripsi" id="deskripsi" rows="4">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        <div class="form-text text-muted">Deskripsi lengkap (minimal 50 karakter).</div>
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
                    <h3>Daftar Mata Kuliah Sustainability</h3>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-striped" id="matakuliah-table">
                        <thead>
                            <tr>
                                <th>Nama Mata Kuliah</th>
                                <th>Kode</th>
                                <th>Semester</th>
                                <th>Fakultas</th>
                                <th>Program Studi</th>
                                <th>RPS</th>
                                <th>Deskripsi</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="matakuliah-list">
                            @forelse($matakuliahs as $matakuliah)
                                <tr>
                                    <td>{{ $matakuliah->nama_matkul }}</td>
                                    <td>{{ $matakuliah->kode_matkul }}</td>
                                    <td>{{ $matakuliah->semester }}</td>
                                    <td>{{ strtoupper($matakuliah->fakultas) }}</td>
                                    <td>{{ $matakuliah->prodi ?? 'N/A (Fakultas)' }}</td>
                                    <td>
                                        @if($matakuliah->rps_path)
                                        <a href="{{ Storage::url($matakuliah->rps_path) }}" target="_blank" class="btn btn-sm btn-info">
                                            View RPS
                                        </a>
                                        @else
                                        No RPS
                                        @endif
                                    </td>
                                    <td>{{ Str::limit($matakuliah->deskripsi, 50) }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <button class="btn btn-sm btn-warning edit-matakuliah" 
                                                    data-id="{{ $matakuliah->id }}"
                                                    data-bs-toggle="modal" data-bs-target="#editMatakuliahModal">
                                                Edit
                                            </button>
                                            <button class="btn btn-sm btn-danger delete-matakuliah" data-id="{{ $matakuliah->id }}" data-nama="{{ $matakuliah->nama_matkul }}">
                                                Delete
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">Belum ada data mata kuliah.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($matakuliahs->hasPages())
                    <div class="mt-3">
                        {{ $matakuliahs->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="modal fade" id="editMatakuliahModal" tabindex="-1" role="dialog" aria-labelledby="editMatakuliahModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editMatakuliahModalLabel">Edit Mata Kuliah</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="edit-matakuliah-form" method="POST" enctype="multipart/form-data"> {{-- Action will be set by JS --}}
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="matakuliah_id" id="edit_matakuliah_id">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="edit_nama_matkul" class="form-label">Nama Mata Kuliah</label>
                                <input type="text" class="form-control" name="nama_matkul" id="edit_nama_matkul">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit_semester" class="form-label">Semester</label>
                                <input type="text" class="form-control" name="semester" id="edit_semester">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="edit_kode_matkul" class="form-label">Kode Mata Kuliah</label>
                                <input type="text" class="form-control" name="kode_matkul" id="edit_kode_matkul">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit_fakultas" class="form-label">Fakultas</label>
                                <select class="form-select" name="fakultas" id="edit_fakultas">
                                    <option value="">Pilih Fakultas</option>
                                     @foreach ($faculties as $key => $faculty)
                                        <option value="{{ strtolower($key) }}">{{ $faculty['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_prodi" class="form-label">Program Studi</label>
                                <select class="form-select" name="prodi" id="edit_prodi" disabled>
                                    <option value="">Pilih Program Studi</option>
                                    {{-- Populated by JS --}}
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="edit_rps" class="form-label">RPS Mata Kuliah (Opsional)</label>
                                <input type="file" class="form-control" name="rps" id="edit_rps" accept=".pdf,.doc,.docx">
                                <div class="form-text text-muted">Biarkan kosong jika tidak ingin mengubah file RPS. <span id="current_rps_info"></span></div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="edit_deskripsi" class="form-label">Deskripsi Mata Kuliah</label>
                                <textarea class="form-control" name="deskripsi" id="edit_deskripsi" rows="4"></textarea>
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
    
    {{-- Delete Form (action set by JavaScript) --}}
    <form id="delete-matakuliah-form" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

    {{-- Assuming jQuery, Bootstrap JS, SweetAlert2 are loaded in admin.admin layout --}}
    {{-- matakuliah_dashboard.js should handle the dynamic prodi dropdown --}}
    <script src="{{ asset('dashboard_main/dashboard/matakuliah_dashboard.js') }}"></script>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        const facultiesData = @json($faculties_data ?? []); // Ensure this is passed from controller

        // Function to populate prodi dropdown (reusable for edit modal)
        function populateProdiDropdown(fakultasValue, prodiSelectElement, selectedProdi = null) {
            prodiSelectElement.innerHTML = '<option value="">Pilih Program Studi</option>';
            prodiSelectElement.disabled = true;

            if (fakultasValue && facultiesData[fakultasValue.toUpperCase()] && facultiesData[fakultasValue.toUpperCase()].programs) {
                prodiSelectElement.disabled = false;
                facultiesData[fakultasValue.toUpperCase()].programs.forEach(prodi => {
                    const option = document.createElement('option');
                    option.value = prodi; // Assuming prodi names are stored as is
                    option.textContent = prodi;
                    if (selectedProdi && prodi === selectedProdi) {
                        option.selected = true;
                    }
                    prodiSelectElement.appendChild(option);
                });
            }
             // Add an option for "Fakultas Level" or "No Prodi" if prodi is nullable
            const noProdiOption = document.createElement('option');
            noProdiOption.value = ""; 
            noProdiOption.textContent = "-- Level Fakultas (Tanpa Prodi) --";
            if (selectedProdi === null || selectedProdi === "") {
                noProdiOption.selected = true;
            }
            prodiSelectElement.insertBefore(noProdiOption, prodiSelectElement.firstChild.nextSibling); // Insert after "Pilih Program Studi"
        }

        // Handle fakultas change for the main form
        const mainFakultasSelect = document.getElementById('fakultas');
        const mainProdiSelect = document.getElementById('prodi');
        if (mainFakultasSelect) {
            mainFakultasSelect.addEventListener('change', function() {
                populateProdiDropdown(this.value, mainProdiSelect);
            });
            // Trigger change if old fakultas value exists (e.g., after validation error)
            if (mainFakultasSelect.value) {
                populateProdiDropdown(mainFakultasSelect.value, mainProdiSelect, "{{ old('prodi') }}");
            }
        }

        // Handle fakultas change for the edit modal form
        const editFakultasSelect = document.getElementById('edit_fakultas');
        const editProdiSelect = document.getElementById('edit_prodi');
        if (editFakultasSelect) {
            editFakultasSelect.addEventListener('change', function() {
                populateProdiDropdown(this.value, editProdiSelect);
            });
        }
        
        // Handle Edit button clicks
        document.querySelectorAll('.edit-matakuliah').forEach(button => {
            button.addEventListener('click', function() {
                const matkulId = this.dataset.id;
                const editForm = document.getElementById('edit-matakuliah-form');
                editForm.action = `{{ url('admin/matakuliah') }}/${matkulId}`;
                document.getElementById('edit_matakuliah_id').value = matkulId;

                // Fetch matakuliah details via AJAX
                // The AdminMataKuliahController@edit method returns JSON
                fetch(`{{ url('admin/matakuliah') }}/${matkulId}/edit`, { 
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': csrfToken 
                    }
                })
                .then(response => {
                    if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
                    return response.json();
                })
                .then(data => {
                    document.getElementById('edit_nama_matkul').value = data.nama_matkul;
                    document.getElementById('edit_semester').value = data.semester;
                    document.getElementById('edit_kode_matkul').value = data.kode_matkul;
                    
                    const currentFakultas = data.fakultas ? data.fakultas.toLowerCase() : '';
                    editFakultasSelect.value = currentFakultas;
                    populateProdiDropdown(currentFakultas, editProdiSelect, data.prodi);

                    document.getElementById('edit_deskripsi').value = data.deskripsi;
                    
                    const currentRpsInfo = document.getElementById('current_rps_info');
                    if(data.rps_path){
                        currentRpsInfo.innerHTML = `File saat ini: <a href="/storage/${data.rps_path}" target="_blank">${data.rps_path.split('/').pop()}</a>`;
                    } else {
                        currentRpsInfo.innerHTML = '<em>Tidak ada file RPS terunggah.</em>';
                    }
                    document.getElementById('edit_rps').value = ''; // Clear file input
                })
                .catch(error => {
                    console.error('Error fetching matakuliah details:', error);
                    Swal.fire('Error', 'Gagal mengambil detail mata kuliah. ' + error.message, 'error');
                });
            });
        });

        // Handle Delete button clicks
        document.querySelectorAll('.delete-matakuliah').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault(); // Prevent direct form submission if it's wrapped in a form
                const matkulId = this.dataset.id;
                const matkulNama = this.dataset.nama;
                const deleteForm = document.getElementById('delete-matakuliah-form');
                deleteForm.action = `{{ url('admin/matakuliah') }}/${matkulId}`;

                Swal.fire({
                    title: 'Anda Yakin?',
                    text: `Apakah Anda ingin menghapus mata kuliah "${matkulNama}"? Tindakan ini tidak dapat dibatalkan.`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        deleteForm.submit();
                    }
                });
            });
        });
        
        // Display SweetAlert for flash messages
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                timer: 3000,
                showConfirmButton: false
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '{{ session('error') }}',
                timer: 3000,
                showConfirmButton: false
            });
        @endif
    });
    </script>
@endsection
