@extends('admin_inovasi.index')

@section('contentadmin_inovasi')
<div class="bg-gradient-to-br from-gray-50 to-gray-100">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Breadcrumb --}}
        <nav class="mb-6">
            <ol class="flex items-center space-x-2 text-sm text-gray-500">
                <li><a href="{{ route('admin_inovasi.dashboard') }}" class="hover:text-teal-600">Dashboard</a></li>
                <li><i class="fas fa-chevron-right text-xs"></i></li>
                <li><a href="{{ route('admin_inovasi.inovchalenge.sessions.index') }}" class="hover:text-teal-600">Innovation Challenge</a></li>
                <li><i class="fas fa-chevron-right text-xs"></i></li>
                <li class="text-gray-700 font-medium">Buat Sesi</li>
            </ol>
        </nav>

        <div class="bg-white rounded-2xl shadow-lg border border-gray-100">
            <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 py-4 rounded-t-2xl">
                <h2 class="text-white font-semibold text-lg">
                    <i class="fas fa-plus-circle mr-2"></i> Buat Sesi Baru
                </h2>
            </div>

            <form action="{{ route('admin_inovasi.inovchalenge.sessions.store') }}" method="POST" class="p-6 space-y-6">
                @csrf

                {{-- Nama Sesi --}}
                <div>
                    <label for="nama_sesi" class="block text-sm font-medium text-gray-700 mb-1">Nama Sesi <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_sesi" id="nama_sesi" value="{{ old('nama_sesi') }}" required
                           class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-teal-500 focus:border-teal-500 text-sm"
                           placeholder="Contoh: Innovation Challenge 2026">
                    @error('nama_sesi') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                {{-- Deskripsi --}}
                <div>
                    <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi" rows="3"
                              class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-teal-500 focus:border-teal-500 text-sm"
                              placeholder="Deskripsi sesi (opsional)">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                {{-- Dana Minimal & Maksimal --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="dana_minimal" class="block text-sm font-medium text-gray-700 mb-1">Dana Minimal (Rp)</label>
                        <input type="number" name="dana_minimal" id="dana_minimal" value="{{ old('dana_minimal') }}" step="0.01" min="0"
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-teal-500 focus:border-teal-500 text-sm"
                               placeholder="0">
                        @error('dana_minimal') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="dana_maksimal" class="block text-sm font-medium text-gray-700 mb-1">Dana Maksimal (Rp)</label>
                        <input type="number" name="dana_maksimal" id="dana_maksimal" value="{{ old('dana_maksimal') }}" step="0.01" min="0"
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-teal-500 focus:border-teal-500 text-sm"
                               placeholder="0">
                        @error('dana_maksimal') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Periode --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="periode_awal" class="block text-sm font-medium text-gray-700 mb-1">Periode Awal <span class="text-red-500">*</span></label>
                        <input type="date" name="periode_awal" id="periode_awal" value="{{ old('periode_awal') }}" required
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-teal-500 focus:border-teal-500 text-sm">
                        @error('periode_awal') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="periode_akhir" class="block text-sm font-medium text-gray-700 mb-1">Periode Akhir <span class="text-red-500">*</span></label>
                        <input type="date" name="periode_akhir" id="periode_akhir" value="{{ old('periode_akhir') }}" required
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-teal-500 focus:border-teal-500 text-sm">
                        @error('periode_akhir') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Min/Max Anggota --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="min_anggota" class="block text-sm font-medium text-gray-700 mb-1">Min Anggota Tim</label>
                        <input type="number" name="min_anggota" id="min_anggota" value="{{ old('min_anggota') }}" min="1"
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-teal-500 focus:border-teal-500 text-sm">
                        @error('min_anggota') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="max_anggota" class="block text-sm font-medium text-gray-700 mb-1">Max Anggota Tim</label>
                        <input type="number" name="max_anggota" id="max_anggota" value="{{ old('max_anggota') }}" min="1"
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-teal-500 focus:border-teal-500 text-sm">
                        @error('max_anggota') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Actions --}}
                <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-100">
                    <a href="{{ route('admin_inovasi.inovchalenge.sessions.index') }}"
                       class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 rounded-xl hover:bg-gray-200 transition">
                        Batal
                    </a>
                    <button type="submit"
                            class="px-5 py-2.5 text-sm font-medium text-white bg-gradient-to-r from-teal-500 to-teal-600 rounded-xl hover:from-teal-600 hover:to-teal-700 shadow transition">
                        <i class="fas fa-save mr-1"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
