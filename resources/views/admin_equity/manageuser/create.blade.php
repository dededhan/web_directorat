@extends('admin_equity.index')

@section('content')
<div x-data="userForm({ fakultas: {{ json_encode($fakultas) }} })">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Header --}}
        <header class="mb-8">
             <nav class="text-sm text-gray-500 mb-3" aria-label="Breadcrumb">
                <ol class="list-none p-0 inline-flex items-center space-x-2">
                    <li><a href="{{ route('admin_equity.dashboard') }}" class="hover:text-teal-600">Dashboard</a></li>
                    <li><i class='bx bx-chevron-right text-base'></i></li>
                    <li><a href="{{ route('admin_equity.manageuser.index') }}" class="hover:text-teal-600">Manajemen Pengguna</a></li>
                    <li><i class='bx bx-chevron-right text-base'></i></li>
                    <li class="font-medium text-gray-800">Tambah Pengguna Baru</li>
                </ol>
            </nav>
            <div>
                <h1 class="text-2xl lg:text-3xl font-bold text-gray-800">Tambah Pengguna Baru</h1>
                <p class="mt-2 text-gray-600">Isi formulir untuk menambahkan akun Dosen atau Reviewer.</p>
            </div>
        </header>

        {{-- Form Container --}}
        <div class="bg-white rounded-2xl shadow-lg border">
            <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 py-5">
                <h2 class="text-xl font-bold text-white flex items-center">
                    <i class='bx bxs-user-plus text-2xl mr-3'></i>
                    Formulir Pengguna Baru
                </h2>
            </div>
            
            <form method="POST" action="{{ route('admin_equity.manageuser.store') }}">
                @csrf
                <div class="p-8 space-y-6">
                    
                    {{-- Basic Info --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                            <input type="text" name="name" id="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500" value="{{ old('name') }}" required>
                            @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Alamat Email</label>
                            <input type="email" name="email" id="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500" value="{{ old('email') }}" required>
                            @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                            <input type="password" name="password" id="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500" required>
                             @error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500" required>
                        </div>
                    </div>

                     {{-- Role Selection --}}
                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                        <select id="role" name="role" x-model="selectedRole" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500" required>
                            <option value="">Pilih Role</option>
                            <option value="dosen">Dosen</option>
                            <option value="reviewer_equity">Reviewer Equity</option>
                        </select>
                         @error('role')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    {{-- Dosen Specific Fields --}}
                    <div x-show="selectedRole === 'dosen'" x-transition class="pt-6 border-t space-y-6">
                        <h3 class="text-lg font-medium text-gray-900">Detail Profil Dosen</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="identifier_number" class="block text-sm font-medium text-gray-700">NIP / NIDN</label>
                                <input type="text" name="identifier_number" id="identifier_number" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500" value="{{ old('identifier_number') }}">
                                 @error('identifier_number')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="fakultas_id" class="block text-sm font-medium text-gray-700">Fakultas</label>
                                <select id="fakultas_id" x-model="selectedFakultas" @change="fetchProdi" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">
                                    <option value="">Pilih Fakultas</option>
                                    <template x-for="fak in fakultas" :key="fak.id">
                                        <option :value="fak.id" x-text="fak.name"></option>
                                    </template>
                                </select>
                            </div>
                            <div>
                                <label for="prodi_id" class="block text-sm font-medium text-gray-700">Program Studi</label>
                                <select id="prodi_id" name="prodi_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500" :disabled="loadingProdi">
                                    <template x-if="loadingProdi">
                                        <option>Memuat...</option>
                                    </template>
                                    <template x-if="!loadingProdi">
                                        <option value="">Pilih Program Studi</option>
                                    </template>
                                    <template x-for="prod in prodi" :key="prod.id">
                                        <option :value="prod.id" x-text="prod.name"></option>
                                    </template>
                                </select>
                                @error('prodi_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Form Actions --}}
                <div class="flex items-center justify-end p-6 bg-gray-50 rounded-b-2xl space-x-3">
                    <a href="{{ route('admin_equity.manageuser.index') }}" class="px-6 py-2.5 bg-gray-200 text-gray-800 font-semibold rounded-xl hover:bg-gray-300">Batal</a>
                    <button type="submit" class="inline-flex items-center px-6 py-2.5 bg-gradient-to-r from-teal-500 to-teal-600 text-white font-semibold rounded-xl hover:from-teal-600 hover:to-teal-700 shadow-md">
                        <i class='bx bx-save text-lg mr-2'></i> Simpan Pengguna
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('userForm', (initialData) => ({
        fakultas: initialData.fakultas || [],
        prodi: [],
        selectedRole: '{{ old("role") }}' || '',
        selectedFakultas: '{{ old("fakultas_id") }}' || '',
        loadingProdi: false,
        
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
                });
        },
        
        init() {
            if (this.selectedFakultas) {
                this.fetchProdi();
            }
        }
    }));
});
</script>
@endsection

