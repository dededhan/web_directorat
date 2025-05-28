@extends('admin.admin')

@section('contentadmin')
<div class="head-title">
    <div class="left">
        <h1>Manage Users</h1>
        <ul class="breadcrumb">
            <li>
                <a href="#">Dashboard</a>
            </li>
            <li><i class='bx bx-chevron-right'></i></li>
            <li>
                <a class="active" href="#">Manage Users</a>
            </li>
        </ul>
    </div>
</div>

{{-- Data for JavaScript --}}
<script>
    const facultiesAndProgramsData = @json($facultiesAndProgramsData ?? []);
</script>

<div class="table-data">
    <div class="order">
        <div class="head">
            <h3>Add New User</h3>
        </div>
        <div class="form-container p-4">
            <form method="POST" action="{{ route('admin.manageuser.store') }}" id="addUserForm">
                @csrf
                <div class="row">
                    {{-- Role Dropdown (Existing) --}}
                    <div class="col-md-6 mb-3">
                        <label for="role" class="form-label">Role</label>
                        <select class="form-select" id="role" name="role" required>
                            <option value="">Select Role</option>
                            <option value="admin_direktorat">Admin Direktorat</option>
                            <option value="kepala_direktorat">Kepala Direktorat</option>
                            <option value="admin_pemeringkatan">Admin Pemeringkatan</option>
                            <option value="fakultas">Fakultas</option>
                            <option value="prodi">Prodi</option>
                            <option value="admin_hilirisasi">Admin Hilirisasi</option>
                            <option value="kepala_sub_direktorat">Kepala Sub Direktorat</option>
                            <option value="wr3">Wakil Rektor 3</option>
                            <option value="dosen">Dosen</option>
                            <option value="mahasiswa">Mahasiswa</option>
                            <option value="validator">Penilai</option>
                            <option value="registered_user">Pengguna Terdaftar</option>
                        </select>
                    </div>

                    {{-- Standard Name Input (Hidden by default if role is fakultas/prodi) --}}
                    <div class="col-md-6 mb-3" id="name_standard_div">
                        <label for="name_standard" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name_standard" name="name_standard">
                    </div>

                    {{-- Hidden Name Input (to be populated by JS for fakultas/prodi) --}}
                    <input type="hidden" id="name" name="name" required>


                    {{-- Conditional Inputs for Fakultas --}}
                    <div class="col-md-6 mb-3" id="fakultas_selection_div" style="display: none;">
                        <label for="fakultas_name_fakultas" class="form-label">Nama Fakultas (Singkatan)</label>
                        <select class="form-select" id="fakultas_name_fakultas">
                            <option value="">Pilih Fakultas</option>
                            @if(!empty($facultiesAndProgramsData))
                                @foreach(array_keys($facultiesAndProgramsData) as $facultyAbbr)
                                    <option value="{{ $facultyAbbr }}">{{ $facultiesAndProgramsData[$facultyAbbr]['name'] ?? $facultyAbbr }}</option>
                                @endforeach
                            @endif
                        </select>
                        <small class="form-text text-muted">Singkatan fakultas yang dipilih akan digunakan sebagai nama pengguna.</small>
                    </div>

                    {{-- Conditional Inputs for Prodi --}}
                    <div class="col-md-12" id="prodi_selection_div" style="display: none;">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="prodi_faculty_abbr" class="form-label">Fakultas</label>
                                <select class="form-select" id="prodi_faculty_abbr">
                                    <option value="">Pilih Fakultas</option>
                                     @if(!empty($facultiesAndProgramsData))
                                        @foreach(array_keys($facultiesAndProgramsData) as $facultyAbbr)
                                            <option value="{{ $facultyAbbr }}">{{ $facultiesAndProgramsData[$facultyAbbr]['name'] ?? $facultyAbbr }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="prodi_program_study" class="form-label">Program Studi</label>
                                <select class="form-select" id="prodi_program_study">
                                    <option value="">Pilih Program Studi</option>
                                    {{-- Options will be populated by JS --}}
                                    <option value="_OTHER_">Lainnya (Ketik Manual)...</option>
                                </select>
                            </div>
                            <div class="col-md-12 mb-3" id="prodi_program_study_other_div" style="display: none;">
                                <label for="prodi_program_study_other" class="form-label">Nama Program Studi Lainnya</label>
                                <input type="text" class="form-control" id="prodi_program_study_other">
                            </div>
                        </div>
                         <small class="form-text text-muted">Nama akan diformat sebagai: SingkatanFakultas-NamaProgramStudi.</small>
                    </div>


                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>

<div class="table-data mt-4">
    <div class="order">
        <div class="head">
            <h3>Akun Pemeringkatan</h3>
            <div class="search-box">
                <input type="text" id="searchPemeringkatanInput" class="form-control" placeholder="Cari akun pemeringkatan...">
            </div>
        </div>
        <div class="table-responsive">
            <table class="table" id="pemeringkatan-users-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $pemeringkatanRoles = ['admin_pemeringkatan', 'fakultas', 'prodi'];
                    @endphp
                    @foreach ($users->whereIn('role', $pemeringkatanRoles) as $user)
                    <tr>
                         <td>{{ $loop->iteration }}</td>
                        <td>
                            @if($user->avatar)
                                <div class="d-flex align-items-center">
                                    <img src="{{ $user->avatar }}" alt="Avatar" class="rounded-circle me-2" width="30" onerror="this.style.display='none'">
                                    {{ $user->name }}
                                </div>
                            @else
                                {{ $user->name }}
                            @endif
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->role }}</td>
                        <td>
                             @if($user->status === 'active')
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-danger">Tidak Aktif</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group">
                                <button class="btn btn-sm btn-primary edit-user"
                                        data-id="{{ $user->id }}"
                                        data-name="{{ $user->name }}"
                                        data-email="{{ $user->email }}"
                                        data-role="{{ $user->role }}"
                                        data-status="{{ $user->status }}">
                                    <i class='bx bx-edit-alt'></i>
                                </button>
                                <button class="btn btn-sm btn-danger delete-user"
                                    data-id="{{ $user->id }}">
                                   <i class='bx bx-trash'></i>
                                </button>
                                <form action="{{ route('admin.manageuser.toggleStatus', $user->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-sm btn-{{ $user->status === 'active' ? 'warning' : 'success' }}">
                                        {{ $user->status === 'active' ? 'Nonaktifkan' : 'Aktifkan' }}
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

{{-- NEW: Inovasi Accounts Table --}}
<div class="table-data mt-4">
    <div class="order">
        <div class="head">
            <h3>Akun Inovasi</h3>
            <div class="search-box">
                <input type="text" id="searchInovasiInput" class="form-control" placeholder="Cari akun inovasi...">
            </div>
        </div>
        <div class="table-responsive">
            <table class="table" id="inovasi-users-table">
                 <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $excludedRoles = ['admin_pemeringkatan', 'fakultas', 'prodi', 'registered_user'];
                    @endphp
                    @foreach ($users->whereNotIn('role', $excludedRoles) as $user)
                    <tr>
                       <td>{{ $loop->iteration }}</td>
                        <td>
                            @if($user->avatar)
                                <div class="d-flex align-items-center">
                                    <img src="{{ $user->avatar }}" alt="Avatar" class="rounded-circle me-2" width="30" onerror="this.style.display='none'">
                                    {{ $user->name }}
                                </div>
                            @else
                                {{ $user->name }}
                            @endif
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->role }}</td>
                        <td>
                             @if($user->status === 'active')
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-danger">Tidak Aktif</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group">
                                <button class="btn btn-sm btn-primary edit-user"
                                        data-id="{{ $user->id }}"
                                        data-name="{{ $user->name }}"
                                        data-email="{{ $user->email }}"
                                        data-role="{{ $user->role }}"
                                        data-status="{{ $user->status }}">
                                    <i class='bx bx-edit-alt'></i>
                                </button>
                                <button class="btn btn-sm btn-danger delete-user"
                                    data-id="{{ $user->id }}">
                                   <i class='bx bx-trash'></i>
                                </button>
                                <form action="{{ route('admin.manageuser.toggleStatus', $user->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-sm btn-{{ $user->status === 'active' ? 'warning' : 'success' }}">
                                        {{ $user->status === 'active' ? 'Nonaktifkan' : 'Aktifkan' }}
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

{{-- Registered Users Table (Unchanged) --}}
<div class="table-data mt-4">
    <div class="order">
        <div class="head">
            <h3>Registered Users</h3>
            <div class="d-flex align-items-center">
                <span class="badge bg-info me-3">Total: {{ $users->where('role', 'registered_user')->count() }}</span>
                <div class="search-box">
                    <input type="text" id="searchRegisteredInput" class="form-control" placeholder="Cari pengguna terdaftar...">
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table" id="registered-users-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Registrasi</th>
                        <th>Bergabung</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users->where('role', 'registered_user') as $user)
                    <tr>
                       <td>{{ $loop->iteration }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                @if($user->avatar)
                                    <img src="{{ $user->avatar }}" alt="Avatar" class="rounded-circle me-2" width="30" onerror="this.style.display='none'">
                                @else
                                    <div class="rounded-circle me-2 bg-secondary d-flex align-items-center justify-content-center text-white" style="width: 30px; height: 30px;">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                @endif
                                {{ $user->name }}
                            </div>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if($user->google_id)
                                <span class="badge bg-primary">
                                    <i class="bx bxl-google me-1"></i> Google
                                </span>
                            @else
                                <span class="badge bg-secondary">Standar</span>
                            @endif
                        </td>
                        <td>{{ $user->created_at->format('d M Y') }}</td>
                        <td>
                            @if($user->status === 'active')
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-danger">Tidak Aktif</span>
                            @endif
                        </td>
                        <td>
                            <form action="{{ route('admin.manageuser.toggleStatus', $user->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-sm btn-{{ $user->status === 'active' ? 'danger' : 'success' }}">
                                    {{ $user->status === 'active' ? 'Nonaktifkan' : 'Aktifkan' }}
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Modals (Edit and Delete) - Unchanged --}}
<div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="edit-user-form" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" id="edit_original_name" name="edit_original_name">

                        <div class="col-md-12 mb-3">
                            <label for="edit_role" class="form-label">Role</label>
                            <select class="form-select" id="edit_role" name="role" required>
                                <option value="admin_direktorat">Admin Direktorat</option>
                                <option value="kepala_direktorat">Kepala Direktorat</option>
                                <option value="admin_pemeringkatan">Admin Pemeringkatan</option>
                                <option value="fakultas">Fakultas</option>
                                <option value="prodi">Prodi</option>
                                <option value="admin_hilirisasi">Admin Hilirisasi</option>
                                <option value="kepala_sub_direktorat">Kepala Sub Direktorat</option>
                                <option value="wr3">Wakil Rektor 3</option>
                                <option value="dosen">Dosen</option>
                                <option value="mahasiswa">Mahasiswa</option>
                                <option value="validator">Penilai</option>
                                <option value="registered_user">Pengguna Terdaftar</option>
                            </select>
                        </div>

                        <div class="col-md-12 mb-3" id="edit_name_standard_div">
                            <label for="edit_name_standard" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="edit_name_standard" name="name_standard_edit">
                        </div>
                        <input type="hidden" id="edit_name" name="name">

                        <div class="col-md-12 mb-3" id="edit_fakultas_selection_div" style="display: none;">
                            <label for="edit_fakultas_name_fakultas" class="form-label">Nama Fakultas (Singkatan)</label>
                            <select class="form-select" id="edit_fakultas_name_fakultas">
                                <option value="">Pilih Fakultas</option>
                                @if(!empty($facultiesAndProgramsData))
                                    @foreach(array_keys($facultiesAndProgramsData) as $facultyAbbr)
                                        <option value="{{ $facultyAbbr }}">{{ $facultiesAndProgramsData[$facultyAbbr]['name'] ?? $facultyAbbr }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="col-md-12" id="edit_prodi_selection_div" style="display: none;">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="edit_prodi_faculty_abbr" class="form-label">Fakultas</label>
                                    <select class="form-select" id="edit_prodi_faculty_abbr">
                                        <option value="">Pilih Fakultas</option>
                                        @if(!empty($facultiesAndProgramsData))
                                            @foreach(array_keys($facultiesAndProgramsData) as $facultyAbbr)
                                                <option value="{{ $facultyAbbr }}">{{ $facultiesAndProgramsData[$facultyAbbr]['name'] ?? $facultyAbbr }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="edit_prodi_program_study" class="form-label">Program Studi</label>
                                    <select class="form-select" id="edit_prodi_program_study">
                                        <option value="">Pilih Program Studi</option>
                                        {{-- Options will be populated by JS --}}
                                        <option value="_OTHER_">Lainnya (Ketik Manual)...</option>
                                    </select>
                                </div>
                                <div class="col-md-12 mb-3" id="edit_prodi_program_study_other_div" style="display: none;">
                                    <label for="edit_prodi_program_study_other" class="form-label">Nama Program Studi Lainnya</label>
                                    <input type="text" class="form-control" id="edit_prodi_program_study_other">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="edit_email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="edit_email" name="email" required>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="edit_password" class="form-label">Password (Kosongkan jika tidak ingin mengubah)</label>
                            <input type="password" class="form-control" id="edit_password" name="password">
                        </div>
                         <div class="col-md-12 mb-3">
                            <label for="edit_status" class="form-label">Status</label>
                            <select class="form-select" id="edit_status" name="status" required>
                                <option value="active">Aktif</option>
                                <option value="unactive">Tidak Aktif</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteUserModal" tabindex="-1" role="dialog" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteUserModalLabel">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus pengguna ini? Tindakan ini tidak dapat dibatalkan.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form id="delete-user-form" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus Pengguna</button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    /* Existing Styles - No changes needed here */
    .table-data { margin-top: 24px; }
    .order { background: #fff; padding: 24px; border-radius: 20px; box-shadow: 0 0 20px rgba(0, 0, 0, 0.1); }
    .head { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
    .form-control:focus, .form-select:focus { border-color: #3498db; box-shadow: none; }
    .btn-primary { background-color: #3498db; border-color: #3498db; }
    .btn-primary:hover { background-color: #2980b9; }
    .search-box { width: 300px; }
    .table th { background-color: #f8f9fa; font-weight: 600; }
    .table td { vertical-align: middle; }
    .btn-group { display: flex; gap: 5px; }
    .badge { padding: 6px 12px; border-radius: 20px; }
    @media (max-width: 768px) {
        .search-box { width: 100%; margin-top: 10px; }
        .head { flex-direction: column; align-items: stretch; }
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

{{-- UPDATED SCRIPT --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    // --- Add User Form Logic (No changes needed here) ---
    const addUserForm = document.getElementById('addUserForm');
    const roleSelect = document.getElementById('role');
    const nameStandardDiv = document.getElementById('name_standard_div');
    const nameStandardInput = document.getElementById('name_standard');
    const hiddenNameInput = document.getElementById('name'); 

    const fakultasSelectionDiv = document.getElementById('fakultas_selection_div');
    const fakultasNameFakultasSelect = document.getElementById('fakultas_name_fakultas');

    const prodiSelectionDiv = document.getElementById('prodi_selection_div');
    const prodiFacultyAbbrSelect = document.getElementById('prodi_faculty_abbr');
    const prodiProgramStudySelect = document.getElementById('prodi_program_study');
    const prodiProgramStudyOtherDiv = document.getElementById('prodi_program_study_other_div');
    const prodiProgramStudyOtherInput = document.getElementById('prodi_program_study_other');

    function updateAddFormVisibility() {
        const selectedRole = roleSelect.value;
        fakultasSelectionDiv.style.display = 'none';
        prodiSelectionDiv.style.display = 'none';
        prodiProgramStudyOtherDiv.style.display = 'none';
        nameStandardDiv.style.display = 'block'; 
        hiddenNameInput.value = ''; 
        nameStandardInput.value = ''; 
        nameStandardInput.required = true; 
        hiddenNameInput.required = false;

        if (selectedRole === 'fakultas') {
            fakultasSelectionDiv.style.display = 'block';
            nameStandardDiv.style.display = 'none';
            nameStandardInput.required = false;
            hiddenNameInput.required = true;
            fakultasNameFakultasSelect.value = ''; 
        } else if (selectedRole === 'prodi') {
            prodiSelectionDiv.style.display = 'block';
            nameStandardDiv.style.display = 'none';
            nameStandardInput.required = false;
            hiddenNameInput.required = true;
            prodiFacultyAbbrSelect.value = ''; 
            prodiProgramStudySelect.innerHTML = '<option value="">Pilih Program Studi</option><option value="_OTHER_">Lainnya (Ketik Manual)...</option>'; 
            prodiProgramStudyOtherInput.value = '';
        }
        updateHiddenName();
    }

    function updateProgramStudiesDropdown(facultyAbbr, targetProgramDropdown, targetOtherDiv, targetOtherInput) {
        targetProgramDropdown.innerHTML = '<option value="">Memuat...</option>';
        targetOtherDiv.style.display = 'none';
        targetOtherInput.value = '';

        let options = '<option value="">Pilih Program Studi</option>';
        if (facultyAbbr && facultiesAndProgramsData[facultyAbbr] && facultiesAndProgramsData[facultyAbbr].programs) {
            facultiesAndProgramsData[facultyAbbr].programs.forEach(program => {
                options += `<option value="${program}">${program}</option>`;
            });
        }
        options += '<option value="_OTHER_">Lainnya (Ketik Manual)...</option>';
        targetProgramDropdown.innerHTML = options;
    }

    function updateHiddenName() {
        const selectedRole = roleSelect.value;
        let finalName = '';
        if (selectedRole === 'fakultas') {
            finalName = fakultasNameFakultasSelect.value;
        } else if (selectedRole === 'prodi') {
            const faculty = prodiFacultyAbbrSelect.value;
            let program = prodiProgramStudySelect.value;
            if (program === '_OTHER_') {
                program = prodiProgramStudyOtherInput.value.trim();
                prodiProgramStudyOtherDiv.style.display = faculty ? 'block' : 'none';
            } else {
                prodiProgramStudyOtherDiv.style.display = 'none';
            }
            if (faculty && program) {
                finalName = `${faculty}-${program}`;
            } else {
                finalName = '';
            }
        } else {
            finalName = nameStandardInput.value; 
        }
        hiddenNameInput.value = finalName;
    }
    
    roleSelect.addEventListener('change', updateAddFormVisibility);
    fakultasNameFakultasSelect.addEventListener('change', updateHiddenName);
    prodiFacultyAbbrSelect.addEventListener('change', function() {
        updateProgramStudiesDropdown(this.value, prodiProgramStudySelect, prodiProgramStudyOtherDiv, prodiProgramStudyOtherInput);
        updateHiddenName();
    });
    prodiProgramStudySelect.addEventListener('change', function() {
        if (this.value === '_OTHER_') {
            prodiProgramStudyOtherDiv.style.display = 'block';
            prodiProgramStudyOtherInput.focus();
        } else {
            prodiProgramStudyOtherDiv.style.display = 'none';
            prodiProgramStudyOtherInput.value = '';
        }
        updateHiddenName();
    });
    prodiProgramStudyOtherInput.addEventListener('input', updateHiddenName);
    nameStandardInput.addEventListener('input', updateHiddenName); 

    // --- Edit User Modal Logic (No changes needed here) ---
    const editUserModalElement = document.getElementById('editUserModal');
    const editUserModal = new bootstrap.Modal(editUserModalElement);
    const editUserForm = document.getElementById('edit-user-form');
    const editRoleSelect = document.getElementById('edit_role');
    const editOriginalNameInput = document.getElementById('edit_original_name');
    const editNameStandardDiv = document.getElementById('edit_name_standard_div');
    const editNameStandardInput = document.getElementById('edit_name_standard');
    const editHiddenNameInput = document.getElementById('edit_name'); 
    const editFakultasSelectionDiv = document.getElementById('edit_fakultas_selection_div');
    const editFakultasNameFakultasSelect = document.getElementById('edit_fakultas_name_fakultas');
    const editProdiSelectionDiv = document.getElementById('edit_prodi_selection_div');
    const editProdiFacultyAbbrSelect = document.getElementById('edit_prodi_faculty_abbr');
    const editProdiProgramStudySelect = document.getElementById('edit_prodi_program_study');
    const editProdiProgramStudyOtherDiv = document.getElementById('edit_prodi_program_study_other_div');
    const editProdiProgramStudyOtherInput = document.getElementById('edit_prodi_program_study_other');
    const editStatusSelect = document.getElementById('edit_status');

    function parseName(name, role) {
        let faculty = '';
        let program = '';
        let isOtherProdi = false;

        if (role === 'fakultas') {
            faculty = name;
        } else if (role === 'prodi' && name && name.includes('-')) {
            const parts = name.split('-', 2);
            faculty = parts[0];
            program = parts[1] || '';
            if (facultiesAndProgramsData[faculty] && facultiesAndProgramsData[faculty].programs) {
                if (!facultiesAndProgramsData[faculty].programs.includes(program)) {
                    isOtherProdi = true;
                }
            } else {
                isOtherProdi = true;
            }
        }
        return { faculty, program, isOtherProdi };
    }

    function updateEditFormVisibility() {
        const selectedRole = editRoleSelect.value;
        editFakultasSelectionDiv.style.display = 'none';
        editProdiSelectionDiv.style.display = 'none';
        editProdiProgramStudyOtherDiv.style.display = 'none';
        editNameStandardDiv.style.display = 'block';
        editNameStandardInput.required = true;
        editHiddenNameInput.required = false;

        if (selectedRole === 'fakultas') {
            editFakultasSelectionDiv.style.display = 'block';
            editNameStandardDiv.style.display = 'none';
            editNameStandardInput.required = false;
            editHiddenNameInput.required = true;
        } else if (selectedRole === 'prodi') {
            editProdiSelectionDiv.style.display = 'block';
            editNameStandardDiv.style.display = 'none';
            editNameStandardInput.required = false;
            editHiddenNameInput.required = true;
        }
        updateEditHiddenName(); 
    }
    
    function updateEditHiddenName() {
        const selectedRole = editRoleSelect.value;
        let finalName = '';

        if (selectedRole === 'fakultas') {
            finalName = editFakultasNameFakultasSelect.value;
        } else if (selectedRole === 'prodi') {
            const faculty = editProdiFacultyAbbrSelect.value;
            let program = editProdiProgramStudySelect.value;

            if (program === '_OTHER_') {
                program = editProdiProgramStudyOtherInput.value.trim();
                editProdiProgramStudyOtherDiv.style.display = faculty ? 'block' : 'none';
            } else {
                editProdiProgramStudyOtherDiv.style.display = 'none';
            }
            if (faculty && program) {
                finalName = `${faculty}-${program}`;
            } else {
                finalName = '';
            }
        } else {
            finalName = editNameStandardInput.value; 
        }
        editHiddenNameInput.value = finalName;
    }

    document.querySelectorAll('.edit-user').forEach(button => {
        button.addEventListener('click', function() {
            const userId = this.dataset.id;
            const currentName = this.dataset.name;
            const currentEmail = this.dataset.email;
            const currentRole = this.dataset.role;
            const currentStatus = this.dataset.status;

            editUserForm.action = `/admin/manageuser/${userId}`;
            editOriginalNameInput.value = currentName;
            editRoleSelect.value = currentRole;
            editStatusSelect.value = currentStatus;
            
            updateEditFormVisibility(); 

            const { faculty, program, isOtherProdi } = parseName(currentName, currentRole);

            if (currentRole === 'fakultas') {
                editFakultasNameFakultasSelect.value = faculty;
                editNameStandardInput.value = '';
            } else if (currentRole === 'prodi') {
                editProdiFacultyAbbrSelect.value = faculty;
                updateProgramStudiesDropdown(faculty, editProdiProgramStudySelect, editProdiProgramStudyOtherDiv, editProdiProgramStudyOtherInput);
                
                setTimeout(() => {
                    if (isOtherProdi) {
                        editProdiProgramStudySelect.value = '_OTHER_';
                        editProdiProgramStudyOtherInput.value = program;
                        editProdiProgramStudyOtherDiv.style.display = 'block';
                    } else {
                        editProdiProgramStudySelect.value = program;
                        editProdiProgramStudyOtherDiv.style.display = 'none';
                        editProdiProgramStudyOtherInput.value = '';
                    }
                    updateEditHiddenName(); 
                }, 150); 
                editNameStandardInput.value = '';
            } else {
                editNameStandardInput.value = currentName;
            }
            
            document.getElementById('edit_email').value = currentEmail;
            document.getElementById('edit_password').value = ''; 

            updateEditHiddenName(); 
            editUserModal.show();
        });
    });

    editRoleSelect.addEventListener('change', function() {
        updateEditFormVisibility();
        if (this.value !== 'fakultas') editFakultasNameFakultasSelect.value = '';
        if (this.value !== 'prodi') {
            editProdiFacultyAbbrSelect.value = '';
            editProdiProgramStudySelect.innerHTML = '<option value="">Pilih Program Studi</option><option value="_OTHER_">Lainnya (Ketik Manual)...</option>';
            editProdiProgramStudyOtherDiv.style.display = 'none';
            editProdiProgramStudyOtherInput.value = '';
        }
    });

    editFakultasNameFakultasSelect.addEventListener('change', updateEditHiddenName);
    editProdiFacultyAbbrSelect.addEventListener('change', function() {
        updateProgramStudiesDropdown(this.value, editProdiProgramStudySelect, editProdiProgramStudyOtherDiv, editProdiProgramStudyOtherInput);
        updateEditHiddenName();
    });
    editProdiProgramStudySelect.addEventListener('change', function() {
        if (this.value === '_OTHER_') {
            editProdiProgramStudyOtherDiv.style.display = 'block';
            editProdiProgramStudyOtherInput.focus();
        } else {
            editProdiProgramStudyOtherDiv.style.display = 'none';
            editProdiProgramStudyOtherInput.value = '';
        }
        updateEditHiddenName();
    });
    editProdiProgramStudyOtherInput.addEventListener('input', updateEditHiddenName);
    editNameStandardInput.addEventListener('input', updateEditHiddenName);

    updateAddFormVisibility();

    // --- Delete User Modal ---
    const deleteUserModalElement = document.getElementById('deleteUserModal');
    const deleteUserModal = new bootstrap.Modal(deleteUserModalElement);
    document.querySelectorAll('.delete-user').forEach(button => {
        button.addEventListener('click', function() {
            const userId = this.dataset.id;
            const form = document.getElementById('delete-user-form');
            form.action = `/admin/manageuser/${userId}`;
            deleteUserModal.show();
        });
    });

    // --- SweetAlert for success/error messages ---
    @if(session('success'))
        Swal.fire({ icon: 'success', title: 'Sukses!', text: '{{ session('success') }}', timer: 3000, showConfirmButton: false });
    @endif
    @if(session('error'))
        Swal.fire({ icon: 'error', title: 'Gagal!', text: '{{ session('error') }}', timer: 3000, showConfirmButton: false });
    @endif

    // --- UPDATED Search functionality ---
    function setupSearch(inputId, tableId) {
        const searchInput = document.getElementById(inputId);
        if (!searchInput) return;
        searchInput.addEventListener('keyup', function() {
            const searchText = this.value.toLowerCase();
            const table = document.getElementById(tableId);
            const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
            for (let row of rows) {
                row.style.display = row.textContent.toLowerCase().includes(searchText) ? '' : 'none';
            }
        });
    }
    // Setup search for all three tables
    setupSearch('searchPemeringkatanInput', 'pemeringkatan-users-table');
    setupSearch('searchInovasiInput', 'inovasi-users-table');
    setupSearch('searchRegisteredInput', 'registered-users-table');
});
</script>
@endsection