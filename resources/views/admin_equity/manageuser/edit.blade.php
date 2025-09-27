@extends('admin_equity.index')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100" x-data="userForm({ 
    fakultas: {{ json_encode($fakultas) }}, 
    prodi: {{ json_encode($prodi) }},
    initial: {
        role: '{{ old('role', $user->role) }}',
        fakultas_id: '{{ old('fakultas_id', $user->profile?->prodi?->fakultas_id) }}',
        prodi_id: '{{ old('prodi_id', $user->profile?->prodi_id) }}'
    } 
})" x-init="init()">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-6 lg:py-8">

        {{-- Enhanced Header Section --}}
        <header class="mb-8">
            <!-- Breadcrumb Navigation -->
            <nav class="mb-4" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-2 text-sm">
                    <li>
                        <a href="{{ route('admin_equity.dashboard') }}" class="flex items-center text-gray-500 hover:text-teal-600 transition-colors duration-200">
                            <i class='bx bx-home text-base mr-1'></i>
                            Dashboard
                        </a>
                    </li>
                    <li class="flex items-center">
                        <i class='bx bx-chevron-right text-gray-400 mx-2'></i>
                        <a href="{{ route('admin_equity.manageuser.index') }}" class="text-gray-500 hover:text-teal-600 transition-colors duration-200">
                            Manajemen Pengguna
                        </a>
                    </li>
                    <li class="flex items-center">
                        <i class='bx bx-chevron-right text-gray-400 mx-2'></i>
                        <span class="font-medium text-gray-800">Edit Pengguna</span>
                    </li>
                </ol>
            </nav>

            <!-- Page Title -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 lg:p-8">
                <div class="flex items-start space-x-4">
                    <div class="flex-shrink-0 p-3 bg-gradient-to-br from-teal-100 to-teal-100 rounded-xl">
                        <i class='bx bxs-edit text-2xl text-teal-600'></i>
                    </div>
                    <div>
                        <h1 class="text-2xl lg:text-3xl font-bold text-gray-900 mb-2">
                            Edit Pengguna: {{ $user->name }}
                        </h1>
                        <p class="text-gray-600 text-base lg:text-lg">
                            Lakukan perubahan pada detail akun pengguna
                        </p>
                        <!-- User Info Badge -->
                        <div class="flex items-center mt-3 space-x-3">
                            @if($user->role == 'dosen')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                    <i class='bx bx-user-voice mr-1'></i>
                                    Dosen
                                </span>
                            @elseif($user->role == 'reviewer_equity')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                    <i class='bx bx-user-check mr-1'></i>
                                    Reviewer
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </header>

        {{-- Enhanced Form Container --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <!-- Form Header -->
            <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 lg:px-8 py-6">
                <div class="flex items-center">
                    <h2 class="text-xl lg:text-2xl font-bold text-white flex items-center">
                        <i class='bx bx-edit text-2xl mr-3'></i>
                        Formulir Edit Pengguna
                    </h2>
                </div>
            </div>
            
            <form method="POST" action="{{ route('admin_equity.manageuser.update', $user->id) }}">
                @csrf
                @method('PUT')
                <div class="p-6 lg:p-8 space-y-8">
                    
                    {{-- Basic Information Section --}}
                    <div class="space-y-6">
                        <div class="flex items-center space-x-3 pb-4 border-b border-gray-200">
                            <div class="p-2 bg-teal-100 rounded-lg">
                                <i class='bx bx-user text-teal-600 text-lg'></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900">Informasi Dasar</h3>
                        </div>
                        
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class='bx bx-user text-teal-600 mr-1'></i>
                                    Nama Lengkap
                                </label>
                                <input type="text" name="name" id="name" 
                                       class="block w-full px-4 py-3 rounded-xl border-2 border-gray-200 shadow-sm focus:border-teal-500 focus:ring-2 focus:ring-teal-500/20 text-base transition-all duration-200 hover:border-gray-300" 
                                       value="{{ old('name', $user->name) }}" 
                                       placeholder="Masukkan nama lengkap"
                                       required>
                                @error('name')
                                    <p class="text-red-500 text-sm mt-2 flex items-center">
                                        <i class='bx bx-error-circle mr-1'></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class='bx bx-envelope text-teal-600 mr-1'></i>
                                    Alamat Email
                                </label>
                                <input type="email" name="email" id="email" 
                                       class="block w-full px-4 py-3 rounded-xl border-2 border-gray-200 shadow-sm focus:border-teal-500 focus:ring-2 focus:ring-teal-500/20 text-base transition-all duration-200 hover:border-gray-300" 
                                       value="{{ old('email', $user->email) }}" 
                                       placeholder="contoh@email.com"
                                       required>
                                @error('email')
                                    <p class="text-red-500 text-sm mt-2 flex items-center">
                                        <i class='bx bx-error-circle mr-1'></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>

                        <!-- Password Change Section -->
                        <div class="bg-amber-50 rounded-xl p-6 border border-amber-200">
                            <div class="flex items-center space-x-2 mb-4">
                                <i class='bx bx-info-circle text-amber-600 text-lg'></i>
                                <h4 class="text-base font-semibold text-amber-800">Ubah Password</h4>
                                <span class="text-xs bg-amber-200 text-amber-700 px-2 py-1 rounded-full">Opsional</span>
                            </div>
                            <p class="text-sm text-amber-700 mb-4">Kosongkan field password jika tidak ingin mengubah password saat ini.</p>
                            
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                <div>
                                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                                        <i class='bx bx-lock text-teal-600 mr-1'></i>
                                        Password Baru
                                    </label>
                                    <input type="password" name="password" id="password" 
                                           class="block w-full px-4 py-3 rounded-xl border-2 border-gray-200 shadow-sm focus:border-teal-500 focus:ring-2 focus:ring-teal-500/20 text-base transition-all duration-200 hover:border-gray-300 bg-white" 
                                           placeholder="Kosongkan jika tidak diubah">
                                    @error('password')
                                        <p class="text-red-500 text-sm mt-2 flex items-center">
                                            <i class='bx bx-error-circle mr-1'></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                                        <i class='bx bx-lock-alt text-teal-600 mr-1'></i>
                                        Konfirmasi Password Baru
                                    </label>
                                    <input type="password" name="password_confirmation" id="password_confirmation" 
                                           class="block w-full px-4 py-3 rounded-xl border-2 border-gray-200 shadow-sm focus:border-teal-500 focus:ring-2 focus:ring-teal-500/20 text-base transition-all duration-200 hover:border-gray-300 bg-white" 
                                           placeholder="Ulangi password baru">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Role Selection Section --}}
                    <div class="space-y-6">
                        <div class="flex items-center space-x-3 pb-4 border-b border-gray-200">
                            <div class="p-2 bg-teal-100 rounded-lg">
                                <i class='bx bx-shield text-teal-600 text-lg'></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900">Role Pengguna</h3>
                        </div>
                        
                        <div>
                            <label for="role" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class='bx bx-user-check text-teal-600 mr-1'></i>
                                Pilih Role
                            </label>
                            <select id="role" name="role" x-model="selectedRole" 
                                    class="block w-full px-4 py-3 rounded-xl border-2 border-gray-200 shadow-sm focus:border-teal-500 focus:ring-2 focus:ring-teal-500/20 text-base transition-all duration-200 hover:border-gray-300 appearance-none bg-white" 
                                    required>
                                <option value="">Pilih Role Pengguna</option>
                                <option value="dosen">Dosen</option>
                                <option value="reviewer_equity">Reviewer Equity</option>
                            </select>
                            @error('role')
                                <p class="text-red-500 text-sm mt-2 flex items-center">
                                    <i class='bx bx-error-circle mr-1'></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>

                    {{-- Dosen Specific Fields Section --}}
                    <div x-show="selectedRole === 'dosen'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform -translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0" class="space-y-6">
                        <div class="flex items-center space-x-3 pb-4 border-b border-gray-200">
                            <div class="p-2 bg-teal-100 rounded-lg">
                                <i class='bx bx-building text-teal-600 text-lg'></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900">Detail Profil Dosen</h3>
                            <span class="bg-teal-100 text-teal-700 text-xs px-2 py-1 rounded-full font-medium">Khusus Dosen</span>
                        </div>
                        
                        <div class="bg-teal-50 rounded-xl p-6 border border-teal-200">
                            <div class="space-y-6">
                                <div>
                                    <label for="identifier_number" class="block text-sm font-semibold text-gray-700 mb-2">
                                        <i class='bx bx-id-card text-teal-600 mr-1'></i>
                                        NIP / NIDN
                                    </label>
                                    <input type="text" name="identifier_number" id="identifier_number" 
                                           class="block w-full px-4 py-3 rounded-xl border-2 border-gray-200 shadow-sm focus:border-teal-500 focus:ring-2 focus:ring-teal-500/20 text-base transition-all duration-200 hover:border-gray-300 bg-white" 
                                           value="{{ old('identifier_number', $user->profile?->identifier_number) }}"
                                           placeholder="Masukkan NIP atau NIDN">
                                    @error('identifier_number')
                                        <p class="text-red-500 text-sm mt-2 flex items-center">
                                            <i class='bx bx-error-circle mr-1'></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                                
                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                    <div>
                                        <label for="fakultas_id" class="block text-sm font-semibold text-gray-700 mb-2">
                                            <i class='bx bx-buildings text-teal-600 mr-1'></i>
                                            Fakultas
                                        </label>
                                        <select id="fakultas_id" x-model="selectedFakultas" 
                                                class="block w-full px-4 py-3 rounded-xl border-2 border-gray-200 shadow-sm focus:border-teal-500 focus:ring-2 focus:ring-teal-500/20 text-base transition-all duration-200 hover:border-gray-300 appearance-none bg-white">
                                            <option value="">Pilih Fakultas</option>
                                            <template x-for="fak in fakultas" :key="fak.id">
                                                <option :value="fak.id" x-text="fak.name"></option>
                                            </template>
                                        </select>
                                    </div>
                                    
                                    <div>
                                        <label for="prodi_id" class="block text-sm font-semibold text-gray-700 mb-2">
                                            <i class='bx bx-book text-teal-600 mr-1'></i>
                                            Program Studi
                                        </label>
                                        <select id="prodi_id" name="prodi_id" x-model="selectedProdi" 
                                                class="block w-full px-4 py-3 rounded-xl border-2 border-gray-200 shadow-sm focus:border-teal-500 focus:ring-2 focus:ring-teal-500/20 text-base transition-all duration-200 hover:border-gray-300 appearance-none bg-white" 
                                                :disabled="loadingProdi || !selectedFakultas"
                                                :class="{'opacity-60 cursor-not-allowed': loadingProdi || !selectedFakultas}">
                                            <template x-if="!selectedFakultas">
                                                <option value="">Pilih Fakultas Terlebih Dahulu</option>
                                            </template>
                                            <template x-if="loadingProdi">
                                                <option>Memuat program studi...</option>
                                            </template>
                                            <template x-if="selectedFakultas && !loadingProdi">
                                                <option value="">Pilih Program Studi</option>
                                            </template>
                                            <template x-for="prod in prodi" :key="prod.id">
                                                <option :value="prod.id" x-text="prod.name"></option>
                                            </template>
                                        </select>
                                        @error('prodi_id')
                                            <p class="text-red-500 text-sm mt-2 flex items-center">
                                                <i class='bx bx-error-circle mr-1'></i>
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Enhanced Form Actions --}}
                <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 lg:px-8 py-6 border-t border-gray-200">
                    <div class="flex flex-col sm:flex-row items-center justify-end space-y-3 sm:space-y-0 sm:space-x-4">
                        <a href="{{ route('admin_equity.manageuser.index') }}" 
                           class="w-full sm:w-auto px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-xl hover:bg-gray-200 transition-all duration-200 text-center border-2 border-transparent hover:border-gray-300">
                            <i class='bx bx-x mr-2'></i>
                            Batal
                        </a>
                        <button type="submit" 
                                class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-teal-500 to-teal-600 text-white font-semibold rounded-xl hover:from-teal-600 hover:to-teal-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105">
                            <i class='bx bx-save text-lg mr-2'></i> 
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('userForm', (initialData) => ({
        fakultas: initialData.fakultas || [],
        prodi: initialData.prodi || [],
        selectedRole: initialData.initial.role || '',
        selectedFakultas: initialData.initial.fakultas_id || '',
        selectedProdi: initialData.initial.prodi_id || '',
        loadingProdi: false,
        
        init() {
            this.$watch('selectedFakultas', (newValue, oldValue) => {
                if (newValue !== oldValue) {
                    this.selectedProdi = '';
                    this.fetchProdi();
                }
            });
        },

        fetchProdi() {
            if (!this.selectedFakultas) {
                this.prodi = [];
                return;
            }
            this.loadingProdi = true;
            fetch(`/api/prodi/${this.selectedFakultas}`)
                .then(response => response.json())
                .then(data => {
                    this.prodi = data;
                    this.loadingProdi = false;
                })
                .catch(() => {
                    this.prodi = [];
                    this.loadingProdi = false;
                    console.error('Gagal mengambil data prodi.');
                });
        },
    }));
});
</script>
@endsection