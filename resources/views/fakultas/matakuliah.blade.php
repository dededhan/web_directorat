@extends('fakultas.index')

<link rel="stylesheet" href="{{ asset('dashboard_main/dashboard/matakuliah_dashboard.css') }}">

@section('contentfakultas')
    <div class="head-title">
        <div class="left">
            <h1>Mata Kuliah Sustainability</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="{{ route('fakultas.dashboard') }}">Dashboard</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a class="active" href="{{ route('fakultas.matakuliah.index') }}">Input Mata Kuliah</a>
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

            <form id="matakuliah-form" action="{{ route('fakultas.matakuliah.store') }}" method="POST" enctype="multipart/form-data">
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
                        <label for="fakultas_display" class="form-label">Fakultas</label>
                        {{-- Fakultas field is pre-filled and disabled for fakultas users --}}
                        <input type="text" class="form-control" id="fakultas_display" value="{{ strtoupper(Auth::user()->name) }}" disabled>
                        <input type="hidden" name="fakultas" id="fakultas" value="{{ $user_info['faculty_code'] ?? '' }}">
                        @error('fakultas') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        <div class="form-text text-muted">Fakultas (otomatis terisi).</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="prodi" class="form-label">Program Studi</label>
                        <select class="form-select @error('prodi') is-invalid @enderror" name="prodi" id="prodi">
                            <option value="">-- Level Fakultas (Tanpa Prodi) --</option>
                            @if(isset($prodi_list_for_fakultas) && !empty($prodi_list_for_fakultas))
                                @foreach($prodi_list_for_fakultas as $prodi_item)
                                    <option value="{{ $prodi_item }}" {{ old('prodi') == $prodi_item ? 'selected' : '' }}>{{ $prodi_item }}</option>
                                @endforeach
                            @else
                                {{-- This case should ideally not happen if controller passes data correctly based on user's faculty --}}
                                <option value="" disabled>Tidak ada program studi untuk fakultas Anda.</option>
                            @endif
                        </select>
                        @error('prodi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        <div class="form-text text-muted">Pilih program studi (opsional).</div>
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
                                {{-- Fakultas column might be redundant if all entries are from user's faculty --}}
                                {{-- <th>Fakultas</th>  --}}
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
                                    {{-- <td>{{ strtoupper($matakuliah->fakultas) }}</td> --}}
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
                                    <td colspan="7" class="text-center">Belum ada data mata kuliah.</td>
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
                                <label for="edit_fakultas_display" class="form-label">Fakultas</label>
                                <input type="text" class="form-control" id="edit_fakultas_display" value="{{ strtoupper(Auth::user()->name) }}" disabled>
                                <input type="hidden" name="fakultas" id="edit_fakultas" value="{{ $user_info['faculty_code'] ?? '' }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_prodi" class="form-label">Program Studi</label>
                                <select class="form-select" name="prodi" id="edit_prodi">
                                    <option value="">-- Level Fakultas (Tanpa Prodi) --</option>
                                    @if(isset($prodi_list_for_fakultas) && !empty($prodi_list_for_fakultas))
                                        @foreach($prodi_list_for_fakultas as $prodi_item)
                                            <option value="{{ $prodi_item }}">{{ $prodi_item }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="edit_rps" class="form-label">RPS Mata Kuliah (Opsional)</label>
                                <input type="file" class="form-control" name="rps" id="edit_rps" accept=".pdf,.doc,.docx">
                                <div class="form-text text-muted">Biarkan kosong jika tidak ingin mengubah file RPS. <span id="current_rps_info_edit"></span></div>
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

    {{-- Assuming jQuery, Bootstrap JS, SweetAlert2 are loaded in fakultas.index layout --}}
    {{-- The matakuliah_dashboard.js might not be needed if prodi list is static for this view --}}
    {{-- <script src="{{ asset('dashboard_main/dashboard/matakuliah_dashboard.js') }}"></script> --}}
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        // const prodiListForFakultas = @json($prodi_list_for_fakultas ?? []); // Already available in Blade for dropdown

        // Handle Edit button clicks
        document.querySelectorAll('.edit-matakuliah').forEach(button => {
            button.addEventListener('click', function() {
                const matkulId = this.dataset.id;
                const editForm = document.getElementById('edit-matakuliah-form');
                editForm.action = `{{ url('fakultas/matakuliah') }}/${matkulId}`; // Correct route for fakultas
                document.getElementById('edit_matakuliah_id').value = matkulId;

                // Fetch matakuliah details via AJAX
                fetch(`{{ url('fakultas/matakuliah') }}/${matkulId}/edit`, { // Correct route for fakultas
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
                    
                    // Fakultas is pre-filled and disabled
                    // document.getElementById('edit_fakultas_display').value = data.fakultas.toUpperCase();
                    // document.getElementById('edit_fakultas').value = data.fakultas;
                    
                    // Pre-select prodi in edit modal
                    const editProdiSelect = document.getElementById('edit_prodi');
                    if (data.prodi) {
                        editProdiSelect.value = data.prodi;
                    } else {
                        editProdiSelect.value = ""; // For "Level Fakultas (Tanpa Prodi)"
                    }

                    document.getElementById('edit_deskripsi').value = data.deskripsi;
                    
                    const currentRpsInfoEdit = document.getElementById('current_rps_info_edit');
                    if(data.rps_path){
                        currentRpsInfoEdit.innerHTML = `File saat ini: <a href="/storage/${data.rps_path}" target="_blank">${data.rps_path.split('/').pop()}</a>`;
                    } else {
                        currentRpsInfoEdit.innerHTML = '<em>Tidak ada file RPS terunggah.</em>';
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
                e.preventDefault(); 
                const matkulId = this.dataset.id;
                const matkulNama = this.dataset.nama;
                const deleteForm = document.getElementById('delete-matakuliah-form');
                deleteForm.action = `{{ url('fakultas/matakuliah') }}/${matkulId}`; // Correct route for fakultas

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
