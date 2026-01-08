@extends('sulitest.index')

@section('content')
    <header class="bg-white shadow-sm">
        <div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
            <h1 class="text-lg font-semibold leading-6 text-gray-900">Pengaturan Akun</h1>
            <p class="mt-1 text-sm text-gray-600">Kelola informasi profil dan keamanan akun Anda</p>
        </div>
    </header>

    <main class="py-10">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-6 rounded-md bg-green-50 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-check-circle text-green-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="bg-white shadow sm:rounded-lg">
                <form action="{{ route('sulitest.pengaturan-akun.update') }}" method="POST" class="space-y-6 p-6">
                    @csrf
                    @method('PUT')

                    <div class="border-b border-gray-200 pb-6">
                        <h3 class="text-base font-semibold leading-6 text-gray-900">Informasi Pribadi</h3>
                        <p class="mt-1 text-sm text-gray-600">Update informasi dasar profil Anda</p>
                    </div>

                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div class="sm:col-span-2">
                            <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap *</label>
                            <input type="text" name="name" id="name" required value="{{ old('name', $user->name) }}" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm @error('name') border-red-300 @enderror">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email *</label>
                            <input type="email" name="email" id="email" required value="{{ old('email', $user->email) }}" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm @error('email') border-red-300 @enderror">
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="nim" class="block text-sm font-medium text-gray-700">NIM</label>
                            <input type="text" name="nim" id="nim" value="{{ old('nim', $user->sulitestProfile?->nim) }}" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm @error('nim') border-red-300 @enderror">
                            @error('nim')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="fakultas_id" class="block text-sm font-medium text-gray-700">Fakultas *</label>
                            <select name="fakultas_id" id="fakultas_id" required 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm @error('fakultas_id') border-red-300 @enderror">
                                <option value="">-- Pilih Fakultas --</option>
                                @foreach($fakultas as $f)
                                    <option value="{{ $f->id }}" {{ old('fakultas_id', $user->sulitestProfile?->fakultas_id) == $f->id ? 'selected' : '' }}>
                                        {{ $f->name }} ({{ $f->abbreviation }})
                                    </option>
                                @endforeach
                            </select>
                            @error('fakultas_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="prodi_id" class="block text-sm font-medium text-gray-700">Program Studi *</label>
                            <select name="prodi_id" id="prodi_id" required 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm @error('prodi_id') border-red-300 @enderror">
                                @foreach($prodis as $prodi)
                                    <option value="{{ $prodi->id }}" {{ old('prodi_id', $user->sulitestProfile?->prodi_id) == $prodi->id ? 'selected' : '' }}>
                                        {{ $prodi->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('prodi_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="border-t border-gray-200 pt-6">
                        <h3 class="text-base font-semibold leading-6 text-gray-900">Keamanan</h3>
                        <p class="mt-1 text-sm text-gray-600">Update password Anda untuk keamanan akun</p>
                    </div>

                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div class="sm:col-span-2">
                            <div class="bg-blue-50 border-l-4 border-blue-400 p-4">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-info-circle text-blue-400"></i>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm text-blue-700">
                                            Kosongkan field password jika tidak ingin mengubah password.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700">Password Baru (Opsional)</label>
                            <input type="password" name="password" id="password" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm @error('password') border-red-300 @enderror">
                            @error('password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm">
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                        <a href="{{ route('sulitest.dashboard') }}" 
                           class="rounded-md bg-white px-4 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                            Batal
                        </a>
                        <button type="submit" 
                                class="rounded-md bg-teal-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-teal-700">
                            <i class="fas fa-save mr-2"></i>Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>
@endsection

@push('scripts')
<script>
    const savedProdiId = {{ old('prodi_id', $user->sulitestProfile?->prodi_id ?? 'null') }};
    
    function loadProdi(fakultasId, selectProdiId = null) {
        const prodiSelect = document.getElementById('prodi_id');
        
        prodiSelect.innerHTML = '<option value="">Loading...</option>';
        prodiSelect.disabled = true;

        if (fakultasId) {
            fetch(`/pemeringkatan/sulitest/pengaturan-akun/get-prodi/${fakultasId}`)
                .then(response => response.json())
                .then(data => {
                    prodiSelect.innerHTML = '<option value="">-- Pilih Program Studi --</option>';
                    data.forEach(prodi => {
                        const selected = prodi.id == selectProdiId ? 'selected' : '';
                        prodiSelect.innerHTML += `<option value="${prodi.id}" ${selected}>${prodi.name}</option>`;
                    });
                    prodiSelect.disabled = false;
                })
                .catch(error => {
                    console.error('Error:', error);
                    prodiSelect.innerHTML = '<option value="">Error loading prodi</option>';
                    prodiSelect.disabled = false;
                });
        } else {
            prodiSelect.innerHTML = '<option value="">-- Pilih Fakultas Terlebih Dahulu --</option>';
            prodiSelect.disabled = false;
        }
    }

    // Event listener untuk perubahan fakultas
    document.getElementById('fakultas_id').addEventListener('change', function() {
        loadProdi(this.value);
    });

    // Load prodi saat page load jika sudah ada fakultas terpilih
    document.addEventListener('DOMContentLoaded', function() {
        const fakultasId = document.getElementById('fakultas_id').value;
        if (fakultasId) {
            loadProdi(fakultasId, savedProdiId);
        }
    });
</script>
@endpush
