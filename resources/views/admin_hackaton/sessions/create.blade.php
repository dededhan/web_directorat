@extends('admin_hackaton.index')

@section('contentadmin_hackaton')
    <div class="max-w-3xl space-y-8">
        {{-- Breadcrumb & Header --}}
        <div class="border-b-4 border-gray-950 pb-6">
            <p class="mb-2 text-sm font-bold uppercase tracking-[0.18em] text-gray-600">
                <a href="{{ route('admin_hackaton.sessions.index') }}" class="hover:underline">Admin Hackaton / Sesi</a> / Buat Baru
            </p>
            <h1 class="text-3xl font-black text-gray-950 sm:text-4xl">Buat Sesi Hackaton Baru</h1>
            <p class="mt-2 text-base text-gray-700">Sistem akan secara otomatis membuat 3 tahap (Tahap 1, 2, 3) yang dapat Anda atur form buildernya.</p>
        </div>

        <form action="{{ route('admin_hackaton.sessions.store') }}" method="POST" class="border-2 border-gray-950 bg-white p-6 sm:p-8 space-y-6">
            @csrf

            {{-- Nama Sesi --}}
            <div>
                <label for="nama_sesi" class="block text-xs font-bold uppercase tracking-wider text-gray-900 mb-1">
                    Nama Sesi <span class="text-rose-600">*</span>
                </label>
                <input type="text" name="nama_sesi" id="nama_sesi" value="{{ old('nama_sesi') }}" required
                    class="w-full border-2 border-gray-950 px-4 py-2.5 text-sm focus:bg-amber-50 focus:outline-none"
                    placeholder="Contoh: Hackaton Inovasi Digital UNJ 2026">
                @error('nama_sesi') <p class="text-xs text-rose-600 mt-1 font-semibold">{{ $message }}</p> @enderror
            </div>

            {{-- Deskripsi --}}
            <div>
                <label for="deskripsi" class="block text-xs font-bold uppercase tracking-wider text-gray-900 mb-1">
                    Deskripsi / Petunjuk Sesi
                </label>
                <textarea name="deskripsi" id="deskripsi" rows="4"
                    class="w-full border-2 border-gray-950 px-4 py-2.5 text-sm focus:bg-amber-50 focus:outline-none"
                    placeholder="Tuliskan latar belakang, tujuan, dan informasi penting untuk pengusul...">{{ old('deskripsi') }}</textarea>
                @error('deskripsi') <p class="text-xs text-rose-600 mt-1 font-semibold">{{ $message }}</p> @enderror
            </div>

            {{-- Periode Pelaksanaan --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="periode_awal" class="block text-xs font-bold uppercase tracking-wider text-gray-900 mb-1">
                        Tanggal Mulai <span class="text-rose-600">*</span>
                    </label>
                    <input type="date" name="periode_awal" id="periode_awal" value="{{ old('periode_awal') }}" required
                        class="w-full border-2 border-gray-950 px-4 py-2.5 text-sm focus:bg-amber-50 focus:outline-none">
                    @error('periode_awal') <p class="text-xs text-rose-600 mt-1 font-semibold">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="periode_akhir" class="block text-xs font-bold uppercase tracking-wider text-gray-900 mb-1">
                        Tanggal Berakhir <span class="text-rose-600">*</span>
                    </label>
                    <input type="date" name="periode_akhir" id="periode_akhir" value="{{ old('periode_akhir') }}" required
                        class="w-full border-2 border-gray-950 px-4 py-2.5 text-sm focus:bg-amber-50 focus:outline-none">
                    @error('periode_akhir') <p class="text-xs text-rose-600 mt-1 font-semibold">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Batasan Anggota --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="min_anggota" class="block text-xs font-bold uppercase tracking-wider text-gray-900 mb-1">
                        Minimal Anggota Tim (Termasuk Ketua)
                    </label>
                    <input type="number" name="min_anggota" id="min_anggota" value="{{ old('min_anggota', 1) }}" min="1"
                        class="w-full border-2 border-gray-950 px-4 py-2.5 text-sm focus:bg-amber-50 focus:outline-none">
                    @error('min_anggota') <p class="text-xs text-rose-600 mt-1 font-semibold">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="max_anggota" class="block text-xs font-bold uppercase tracking-wider text-gray-900 mb-1">
                        Maksimal Anggota Tim
                    </label>
                    <input type="number" name="max_anggota" id="max_anggota" value="{{ old('max_anggota', 4) }}" min="1"
                        class="w-full border-2 border-gray-950 px-4 py-2.5 text-sm focus:bg-amber-50 focus:outline-none">
                    @error('max_anggota') <p class="text-xs text-rose-600 mt-1 font-semibold">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Dana Min & Max (Opsional) --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="dana_minimal" class="block text-xs font-bold uppercase tracking-wider text-gray-900 mb-1">
                        Plafon Dana Minimal (Rp)
                    </label>
                    <input type="number" name="dana_minimal" id="dana_minimal" value="{{ old('dana_minimal') }}" min="0" step="1000"
                        class="w-full border-2 border-gray-950 px-4 py-2.5 text-sm focus:bg-amber-50 focus:outline-none"
                        placeholder="Contoh: 10000000">
                    @error('dana_minimal') <p class="text-xs text-rose-600 mt-1 font-semibold">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="dana_maksimal" class="block text-xs font-bold uppercase tracking-wider text-gray-900 mb-1">
                        Plafon Dana Maksimal (Rp)
                    </label>
                    <input type="number" name="dana_maksimal" id="dana_maksimal" value="{{ old('dana_maksimal') }}" min="0" step="1000"
                        class="w-full border-2 border-gray-950 px-4 py-2.5 text-sm focus:bg-amber-50 focus:outline-none"
                        placeholder="Contoh: 25000000">
                    @error('dana_maksimal') <p class="text-xs text-rose-600 mt-1 font-semibold">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="border-t-2 border-gray-950 pt-6 flex items-center justify-between">
                <a href="{{ route('admin_hackaton.sessions.index') }}" class="text-xs font-bold uppercase tracking-wider text-gray-600 hover:text-black">
                    Batal
                </a>
                <button type="submit" class="bg-gray-950 px-6 py-3 text-sm font-bold uppercase tracking-wider text-white hover:bg-gray-800 transition">
                    Simpan Sesi & Buat 3 Tahap
                </button>
            </div>
        </form>
    </div>
@endsection
