@extends('admin_pemeringkatan.index')

@section('contentadmin_pemeringkatan')
<div class="px-4 sm:px-6 lg:px-8 py-8">
    <div>
        <nav class="hidden sm:flex" aria-label="Breadcrumb">
            <ol role="list" class="flex items-center space-x-4">
                <li>
                    <div class="flex">
                        <a href="{{ route('admin_pemeringkatan.dashboard') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700">Dashboard</a>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right flex-shrink-0 h-5 w-5 text-gray-400"></i>
                        <a href="{{ route('admin_pemeringkatan.peserta.index') }}" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700">Manajemen Peserta</a>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right flex-shrink-0 h-5 w-5 text-gray-400"></i>
                        <span class="ml-4 text-sm font-medium text-gray-700">Tambah Peserta</span>
                    </div>
                </li>
            </ol>
        </nav>
        <div class="mt-2">
            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">Tambah Peserta Baru</h2>
        </div>
    </div>

    <div class="mt-8">
        <div class="bg-white shadow sm:rounded-lg">
            <form action="{{ route('admin_pemeringkatan.peserta.store') }}" method="POST" class="space-y-6 p-6">
                @csrf

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div class="sm:col-span-2">
                        <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap *</label>
                        <input type="text" name="name" id="name" required value="{{ old('name') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm @error('name') border-red-300 @enderror">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email *</label>
                        <input type="email" name="email" id="email" required value="{{ old('email') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm @error('email') border-red-300 @enderror">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="nim" class="block text-sm font-medium text-gray-700">NIM</label>
                        <input type="text" name="nim" id="nim" value="{{ old('nim') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm @error('nim') border-red-300 @enderror">
                        @error('nim')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="fakultas_id" class="block text-sm font-medium text-gray-700">Fakultas *</label>
                        <select name="fakultas_id" id="fakultas_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm @error('fakultas_id') border-red-300 @enderror">
                            <option value="">-- Pilih Fakultas --</option>
                            @foreach($fakultas as $f)
                                <option value="{{ $f->id }}" {{ old('fakultas_id') == $f->id ? 'selected' : '' }}>
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
                        <select name="prodi_id" id="prodi_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm @error('prodi_id') border-red-300 @enderror" disabled>
                            <option value="">-- Pilih Fakultas Terlebih Dahulu --</option>
                        </select>
                        @error('prodi_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Password *</label>
                        <input type="password" name="password" id="password" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm @error('password') border-red-300 @enderror">
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password *</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm">
                    </div>
                </div>

                <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                    <a href="{{ route('admin_pemeringkatan.peserta.index') }}" class="rounded-md bg-white px-4 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                        Batal
                    </a>
                    <button type="submit" class="rounded-md bg-teal-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-teal-700">
                        <i class="fas fa-save mr-2"></i>Simpan Peserta
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('fakultas_id').addEventListener('change', function() {
        const fakultasId = this.value;
        const prodiSelect = document.getElementById('prodi_id');
        
        prodiSelect.innerHTML = '<option value="">Loading...</option>';
        prodiSelect.disabled = true;

        if (fakultasId) {
            fetch(`/admin_pemeringkatan/peserta/get-prodi/${fakultasId}`)
                .then(response => response.json())
                .then(data => {
                    prodiSelect.innerHTML = '<option value="">-- Pilih Program Studi --</option>';
                    data.forEach(prodi => {
                        prodiSelect.innerHTML += `<option value="${prodi.id}">${prodi.name}</option>`;
                    });
                    prodiSelect.disabled = false;
                })
                .catch(error => {
                    console.error('Error:', error);
                    prodiSelect.innerHTML = '<option value="">Error loading prodi</option>';
                });
        } else {
            prodiSelect.innerHTML = '<option value="">-- Pilih Fakultas Terlebih Dahulu --</option>';
        }
    });

    @if(old('fakultas_id'))
        document.getElementById('fakultas_id').dispatchEvent(new Event('change'));
        setTimeout(() => {
            document.getElementById('prodi_id').value = "{{ old('prodi_id') }}";
        }, 500);
    @endif
</script>
@endpush
@endsection
