@extends('admin_pemeringkatan.index')

@section('contentadmin_pemeringkatan')
<!-- Responsive padding with zoom-out support -->
<div class="min-h-screen bg-gray-50 p-4 sm:p-6 lg:p-8 xl:p-10 2xl:p-12">
    <div class="max-w-[1920px] mx-auto space-y-6">
        
        {{-- Header Section --}}
        <div class="bg-white rounded-xl shadow-md p-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Tambah User Baru</h1>
                    <p class="text-sm text-gray-600 mt-1">Buat akun baru untuk Fakultas, Prodi, atau Admin Pemeringkatan</p>
                </div>
                <div class="flex items-center gap-2 text-sm text-gray-600">
                    <i class="fas fa-home"></i>
                    <a href="{{ route('admin_pemeringkatan.dashboard') }}" class="hover:text-teal-600 transition-colors">Dashboard</a>
                    <i class="fas fa-chevron-right text-xs"></i>
                    <a href="{{ route('admin_pemeringkatan.manageuser.index') }}" class="hover:text-teal-600 transition-colors">Manajemen User</a>
                    <i class="fas fa-chevron-right text-xs"></i>
                    <span class="font-semibold text-teal-600">Tambah User</span>
                </div>
            </div>
        </div>

        {{-- Data for JavaScript --}}
        <script>
            const facultiesAndProgramsData = @json($facultiesAndProgramsData ?? []);
        </script>

        {{-- Add New User Form --}}
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="bg-gradient-to-r from-teal-600 to-teal-700 px-6 py-4 flex items-center justify-between">
                <h3 class="text-lg font-semibold text-white flex items-center gap-2">
                    <i class="fas fa-user-plus"></i>
                    Form Tambah User
                </h3>
                <a href="{{ route('admin_pemeringkatan.manageuser.index') }}" 
                   class="px-4 py-2 bg-white text-teal-700 rounded-lg hover:bg-gray-100 transition-colors text-sm font-medium">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
            </div>
            <div class="p-6 lg:p-8">
                <form method="POST" action="{{ route('admin_pemeringkatan.manageuser.store') }}" id="addUserForm">
                    @csrf
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        {{-- Role Selection --}}
                        <div class="form-group">
                            <label for="role" class="block text-sm font-medium text-gray-700 mb-2">
                                Role <span class="text-red-500">*</span>
                            </label>
                            <select name="role" id="role" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all" required>
                                <option value="">Pilih Role</option>
                                <option value="admin_pemeringkatan">Admin Pemeringkatan</option>
                                <option value="fakultas">Fakultas</option>
                                <option value="prodi">Prodi</option>
                            </select>
                            <p class="text-xs text-gray-500 mt-1">Pilih role untuk menentukan hak akses pengguna</p>
                        </div>

                        {{-- Email --}}
                        <div class="form-group">
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input type="email" name="email" id="email" 
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all" 
                                placeholder="user@example.com" required>
                            <p class="text-xs text-gray-500 mt-1">Email akan digunakan untuk login</p>
                        </div>

                        {{-- Name (Standard - for admin_pemeringkatan) --}}
                        <div id="name_standard_div" class="form-group" style="display: none;">
                            <label for="name_standard" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="name_standard" 
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all" 
                                placeholder="Nama Lengkap">
                            <p class="text-xs text-gray-500 mt-1">Masukkan nama lengkap admin</p>
                        </div>

                        {{-- Fakultas Selection (for fakultas role) --}}
                        <div id="fakultas_selection_div" class="form-group lg:col-span-2" style="display: none;">
                            <label for="fakultas_name_fakultas" class="block text-sm font-medium text-gray-700 mb-2">
                                Pilih Fakultas <span class="text-red-500">*</span>
                            </label>
                            <select id="fakultas_name_fakultas" 
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all">
                                <option value="">Pilih Fakultas</option>
                                @foreach($facultiesAndProgramsData as $abbr => $data)
                                    <option value="{{ $abbr }}">{{ $data['name'] }}</option>
                                @endforeach
                            </select>
                            <p class="text-xs text-gray-500 mt-1">Pilih fakultas yang akan dikelola</p>
                        </div>

                        {{-- Prodi Selection (for prodi role) --}}
                        <div id="prodi_selection_div" class="form-group lg:col-span-2" style="display: none;">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="prodi_faculty_abbr" class="block text-sm font-medium text-gray-700 mb-2">
                                        Pilih Fakultas <span class="text-red-500">*</span>
                                    </label>
                                    <select id="prodi_faculty_abbr" 
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all">
                                        <option value="">Pilih Fakultas</option>
                                        @foreach($facultiesAndProgramsData as $abbr => $data)
                                            <option value="{{ $abbr }}">{{ $data['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label for="prodi_program_study" class="block text-sm font-medium text-gray-700 mb-2">
                                        Pilih Program Studi <span class="text-red-500">*</span>
                                    </label>
                                    <select id="prodi_program_study" 
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all">
                                        <option value="">Pilih Program Studi</option>
                                        <option value="_OTHER_">Lainnya (Ketik Manual)...</option>
                                    </select>
                                </div>
                            </div>
                            <div id="prodi_program_study_other_div" style="display: none;" class="mt-4">
                                <label for="prodi_program_study_other" class="block text-sm font-medium text-gray-700 mb-2">
                                    Ketik Nama Program Studi <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="prodi_program_study_other" 
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all" 
                                    placeholder="Contoh: S1 Teknik Informatika">
                                <p class="text-xs text-gray-500 mt-1">Masukkan nama program studi jika tidak ada dalam daftar</p>
                            </div>
                        </div>

                        {{-- Hidden Name Field --}}
                        <input type="hidden" name="name" id="name">

                        {{-- Password --}}
                        <div class="form-group">
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                Password <span class="text-red-500">*</span>
                            </label>
                            <input type="password" name="password" id="password" 
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all" 
                                placeholder="Min. 8 karakter" required>
                            <p class="text-xs text-gray-500 mt-1">Password minimal 8 karakter</p>
                        </div>
                    </div>

                    <div class="mt-8 flex flex-col sm:flex-row justify-end gap-3">
                        <a href="{{ route('admin_pemeringkatan.manageuser.index') }}" 
                           class="px-6 py-2.5 bg-gray-200 text-gray-700 font-medium rounded-lg hover:bg-gray-300 transition-all duration-200 flex items-center justify-center gap-2">
                            <i class="fas fa-times"></i>
                            Batal
                        </a>
                        <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-teal-600 to-teal-700 text-white font-medium rounded-lg hover:from-teal-700 hover:to-teal-800 transition-all duration-200 flex items-center justify-center gap-2">
                            <i class="fas fa-save"></i>
                            Simpan User
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
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
                program = prodiProgramStudyOtherInput.value;
                prodiProgramStudyOtherDiv.style.display = faculty ? 'block' : 'none';
            } else {
                prodiProgramStudyOtherDiv.style.display = 'none';
            }
            if (faculty && program) {
                finalName = `${faculty}-${program}`;
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

    updateAddFormVisibility();

    // SweetAlert for validation errors
    @if($errors->any())
        Swal.fire({
            icon: 'error',
            title: 'Validasi Gagal',
            html: '<ul class="text-left">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>',
            confirmButtonColor: '#0d9488'
        });
    @endif
});
</script>
@endsection
