@extends('subdirektorat-inovasi.dosen.index')

@section('content')
<div class="bg-gray-50 min-h-screen p-4 sm:p-6 lg:p-8" 
     x-data="profileForm()">

    {{-- Breadcrumbs --}}
    <nav class="text-sm text-gray-500 mb-6" aria-label="Breadcrumb">
        <ol class="list-none p-0 inline-flex">
            <li class="flex items-center"><a href="{{ route('subdirektorat-inovasi.dosen.dashboard') }}" class="hover:text-teal-600">Home</a><i class='bx bx-chevron-right text-lg mx-2'></i></li>
            <li class="font-medium text-gray-700">Manajemen Profil</li>
        </ol>
    </nav>

    {{-- Success Notification --}}
    @if (session('success'))
        <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 5000)"
             class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg shadow-md mb-6" role="alert">
            <div class="flex">
                <div class="py-1"><i class='bx bxs-check-circle text-2xl mr-3'></i></div>
                <div>
                    <p class="font-bold">Sukses</p>
                    <p class="text-sm">{{ session('success') }}</p>
                </div>
                <div class="ml-auto">
                    <button @click="show = false" class="text-green-600 hover:text-green-800">
                        <i class='bx bx-x text-xl'></i>
                    </button>
                </div>
            </div>
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-xl p-4 sm:p-6 lg:p-8 border border-slate-200">
        <h1 class="text-2xl font-bold text-gray-800 mb-2">Pengaturan Akun</h1>
        <p class="text-gray-500 text-sm mb-8">Perbarui informasi profil dan detail akun Anda.</p>

        <form action="{{ route('subdirektorat-inovasi.dosen.manageprofile.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-3 gap-x-8 gap-y-6">

                {{-- Personal Information Section --}}
                <div class="md:col-span-1">
                    <h2 class="text-lg font-semibold text-gray-700">Informasi Pribadi</h2>
                    <p class="mt-1 text-sm text-gray-500">Detail dasar dan kontak Anda.</p>
                </div>
                <div class="md:col-span-2 space-y-6 bg-gray-50 p-6 rounded-xl border">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}"
                               class="form-input @error('name') border-red-500 @enderror"
                               placeholder="Masukkan nama lengkap Anda">
                        @error('name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Alamat Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}"
                               class="form-input @error('email') border-red-500 @enderror"
                               placeholder="contoh@unj.ac.id">
                        @error('email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <hr class="md:col-span-3 my-4">

                {{-- Profile Information Section --}}
                <div class="md:col-span-1">
                    <h2 class="text-lg font-semibold text-gray-700">Profil Dosen</h2>
                    <p class="mt-1 text-sm text-gray-500">Informasi terkait identitas kedosenan Anda.</p>
                </div>
                <div class="md:col-span-2 space-y-6 bg-gray-50 p-6 rounded-xl border">
                    <div>
                        <label for="identifier_number" class="block text-sm font-medium text-gray-700 mb-1">NIP / NIDN</label>
                        <input type="text" id="identifier_number" name="identifier_number" value="{{ old('identifier_number', $user->profile?->identifier_number) }}"
                               class="form-input @error('identifier_number') border-red-500 @enderror"
                               placeholder="Masukkan NIP atau NIDN">
                        @error('identifier_number')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="fakultas" class="block text-sm font-medium text-gray-700 mb-1">Fakultas</label>
                        <select id="fakultas" name="fakultas_id" class="form-select" @change="fetchProdi($event.target.value)">
                            <option value="">Pilih Fakultas</option>
                            @foreach ($fakultas as $item)
                                <option value="{{ $item->id }}" {{ $selectedFakultasId == $item->id ? 'selected' : '' }}>
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="prodi" class="block text-sm font-medium text-gray-700 mb-1">Program Studi</label>
                        <select id="prodi" name="prodi_id" class="form-select @error('prodi_id') border-red-500 @enderror" :disabled="loading">
                            <option x-text="loading ? 'Memuat...' : (prodiOptions.length === 0 ? 'Pilih fakultas terlebih dahulu' : 'Pilih Program Studi')"></option>
                            <template x-for="p in prodiOptions" :key="p.id">
                                <option :value="p.id" :selected="p.id == selectedProdiId" x-text="p.name"></option>
                            </template>
                        </select>
                         @error('prodi_id')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <hr class="md:col-span-3 my-4">

                {{-- Password Section --}}
                <div class="md:col-span-1">
                    <h2 class="text-lg font-semibold text-gray-700">Ubah Password</h2>
                    <p class="mt-1 text-sm text-gray-500">Kosongkan jika Anda tidak ingin mengubah password.</p>
                </div>
                <div class="md:col-span-2 space-y-6 bg-gray-50 p-6 rounded-xl border">
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
                        <input type="password" id="password" name="password"
                               class="form-input @error('password') border-red-500 @enderror"
                               placeholder="Masukkan password baru">
                        @error('password')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password Baru</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-input"
                               placeholder="Ketik ulang password baru">
                    </div>
                </div>
            </div>

            {{-- Form Actions --}}
            <div class="mt-8 pt-5 border-t border-gray-200 flex justify-end">
                <button type="submit"
                        class="inline-flex justify-center py-2 px-6 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-teal-600 hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 transition-colors">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('styles')
<style>
    .form-input, .form-select {
        @apply block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-teal-500 focus:border-teal-500 sm:text-sm transition-colors;
    }
    .form-select:disabled {
        @apply bg-gray-200 cursor-not-allowed;
    }
</style>
@endpush

@push('scripts')
<script>
    function profileForm() {
        return {
            loading: false,
            prodiOptions: @json($prodi),
            selectedFakultasId: '{{ $selectedFakultasId }}',
            selectedProdiId: '{{ $selectedProdiId }}',
            
            async fetchProdi(fakultasId) {
                this.prodiOptions = [];
                if (!fakultasId) return;

                this.loading = true;
                try {
                    const response = await fetch(`/api/prodi/${fakultasId}`);
                    if (!response.ok) throw new Error('Network response was not ok');
                    const data = await response.json();
                    this.prodiOptions = data;
                } catch (error) {
                    console.error('Error fetching prodi:', error);
                    alert('Gagal memuat data program studi. Silakan coba lagi.');
                } finally {
                    this.loading = false;
                }
            }
        }
    }
</script>
@endpush
