@extends('subdirektorat-inovasi.tendik.index')
@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6 lg:py-8">

        {{-- Breadcrumb --}}
        <nav class="flex mb-6" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3 text-sm">
                <li class="inline-flex items-center">
                    <a href="{{ route('subdirektorat-inovasi.tendik.inovchalenge.sessions.index') }}"
                       class="inline-flex items-center text-gray-500 hover:text-teal-600 transition-colors duration-200">
                        <i class='bx bx-home mr-2 text-lg'></i>
                        <span class="hidden sm:inline">Home</span>
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class='bx bx-chevron-right text-gray-400 mx-1'></i>
                        <span class="font-medium text-gray-700">Manajemen Profil</span>
                    </div>
                </li>
            </ol>
        </nav>

        {{-- Header --}}
        <div class="mb-8 text-center lg:text-left">
            <h1 class="text-3xl lg:text-4xl font-bold text-gray-800 mb-3">Pengaturan Akun</h1>
            <p class="text-gray-600 text-lg max-w-2xl mx-auto lg:mx-0">Perbarui informasi profil dan detail akun Anda</p>
        </div>

        {{-- Info Box --}}
        <div class="mb-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex items-start">
                <i class='bx bx-info-circle text-blue-500 text-xl mr-3 mt-0.5'></i>
                <div>
                    <p class="text-blue-700 font-medium text-sm">Informasi Penting</p>
                    <p class="text-blue-600 text-sm"><span class="text-red-500 font-bold">*</span> menunjukkan kolom yang wajib diisi</p>
                </div>
            </div>
        </div>

        {{-- Main Content Box --}}
        <div class="bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden">
            <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 py-8">
                <h2 class="text-2xl font-bold text-white mb-2">Informasi Profil</h2>
                <p class="text-teal-100 text-sm">Lengkapi dan perbarui informasi profil Anda</p>
            </div>

            <div class="p-6 lg:p-8">
                <form @submit="$store.appState.isSubmitting = true"
                      action="{{ route('subdirektorat-inovasi.tendik.manageprofile.update') }}"
                      method="POST" class="space-y-8">
                    @csrf
                    @method('PUT')

                    {{-- Informasi Pribadi --}}
                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl border border-blue-200 overflow-hidden">
                        <div class="bg-gradient-to-r from-blue-500 to-indigo-600 px-6 py-4">
                            <h3 class="text-xl font-bold text-white flex items-center">
                                <i class='bx bx-user text-2xl mr-3'></i>Informasi Pribadi
                            </h3>
                        </div>
                        <div class="p-6 grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="flex items-center text-sm font-semibold text-gray-700 mb-3">
                                    Nama Lengkap <span class="text-red-500 ml-1">*</span>
                                </label>
                                <input type="text" id="name" name="name"
                                       value="{{ old('name', $user->name) }}"
                                       class="block w-full py-4 border-gray-300 rounded-xl shadow-sm @error('name') border-red-500 @enderror"
                                       required>
                                @error('name')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="flex items-center text-sm font-semibold text-gray-700 mb-3">Alamat Email</label>
                                <div class="relative">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                                        <i class='bx bxs-lock-alt text-gray-400 text-lg'></i>
                                    </div>
                                    <input type="email" value="{{ $user->email }}"
                                           class="block w-full py-4 pl-12 border-gray-300 rounded-xl shadow-sm bg-gray-100 cursor-not-allowed"
                                           readonly>
                                </div>
                                <p class="mt-2 text-xs text-gray-500">Email tidak dapat diubah.</p>
                            </div>
                        </div>
                    </div>

                    {{-- Profil Tendik --}}
                    <div class="bg-gradient-to-r from-violet-50 to-purple-50 rounded-2xl border border-violet-200 overflow-hidden">
                        <div class="bg-gradient-to-r from-violet-500 to-purple-600 px-6 py-4">
                            <h3 class="text-xl font-bold text-white flex items-center">
                                <i class='bx bx-id-card text-2xl mr-3'></i>Profil Tendik
                            </h3>
                        </div>
                        <div class="p-6 grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <div>
                                <label for="identifier_number" class="flex items-center text-sm font-semibold text-gray-700 mb-3">
                                    NIP / NIK
                                </label>
                                <input type="text" id="identifier_number" name="identifier_number"
                                       value="{{ old('identifier_number', $user->profile?->identifier_number) }}"
                                       class="block w-full py-4 border-gray-300 rounded-xl shadow-sm @error('identifier_number') border-red-500 @enderror"
                                       placeholder="Masukkan NIP atau NIK Anda">
                                @error('identifier_number')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="institusi" class="flex items-center text-sm font-semibold text-gray-700 mb-3">
                                    Unit Kerja / Direktorat
                                </label>
                                <input type="text" id="institusi" name="institusi"
                                       value="{{ old('institusi', $user->profile?->institusi) }}"
                                       class="block w-full py-4 border-gray-300 rounded-xl shadow-sm @error('institusi') border-red-500 @enderror"
                                       placeholder="Contoh: Direktorat Inovasi dan Kewirausahaan">
                                @error('institusi')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>
                        </div>
                    </div>

                    {{-- Ubah Password --}}
                    <div class="bg-gradient-to-r from-orange-50 to-red-50 rounded-2xl border border-orange-200 overflow-hidden">
                        <div class="bg-gradient-to-r from-orange-500 to-red-600 px-6 py-4">
                            <h3 class="text-xl font-bold text-white flex items-center">
                                <i class='bx bx-lock text-2xl mr-3'></i>Ubah Password
                            </h3>
                        </div>
                        <div class="p-6 grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <div>
                                <label for="password" class="flex items-center text-sm font-semibold text-gray-700 mb-3">Password Baru</label>
                                <input type="password" id="password" name="password"
                                       class="block w-full py-4 border-gray-300 rounded-xl shadow-sm @error('password') border-red-500 @enderror"
                                       placeholder="Kosongkan jika tidak diubah">
                                @error('password')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="password_confirmation" class="flex items-center text-sm font-semibold text-gray-700 mb-3">Konfirmasi Password Baru</label>
                                <input type="password" id="password_confirmation" name="password_confirmation"
                                       class="block w-full py-4 border-gray-300 rounded-xl shadow-sm"
                                       placeholder="Ketik ulang password baru">
                            </div>
                        </div>
                    </div>

                    {{-- Tombol Simpan --}}
                    <div class="bg-gray-50 rounded-2xl border p-6 text-right">
                        <button type="submit"
                                class="inline-flex justify-center items-center py-4 px-8 border border-transparent shadow-lg text-sm font-semibold rounded-xl text-white bg-teal-600 hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                            <i class='bx bx-save mr-2 text-lg'></i>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                confirmButtonColor: '#0d9488',
                timer: 3000,
                timerProgressBar: true,
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '{{ session('error') }}',
                confirmButtonColor: '#ef4444',
            });
        @endif
    });
</script>
@endpush
