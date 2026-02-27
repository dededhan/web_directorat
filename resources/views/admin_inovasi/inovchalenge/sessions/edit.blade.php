@extends('admin_inovasi.index')

@section('contentadmin_inovasi')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Breadcrumb --}}
        <nav class="mb-6">
            <ol class="flex items-center space-x-2 text-sm text-gray-500">
                <li><a href="{{ route('admin_inovasi.dashboard') }}" class="hover:text-teal-600">Dashboard</a></li>
                <li><i class="fas fa-chevron-right text-xs"></i></li>
                <li><a href="{{ route('admin_inovasi.inovchalenge.sessions.index') }}" class="hover:text-teal-600">Innovation Challenge</a></li>
                <li><i class="fas fa-chevron-right text-xs"></i></li>
                <li class="text-gray-700 font-medium">Edit Sesi</li>
            </ol>
        </nav>

        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 py-4">
                <h2 class="text-white font-semibold text-lg">
                    <i class="fas fa-edit mr-2"></i> Edit Sesi
                </h2>
            </div>

            <form action="{{ route('admin_inovasi.inovchalenge.sessions.update', $session) }}" method="POST" class="p-6 space-y-6">
                @csrf
                @method('PUT')

                {{-- Nama Sesi --}}
                <div>
                    <label for="nama_sesi" class="block text-sm font-medium text-gray-700 mb-1">Nama Sesi <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_sesi" id="nama_sesi"
                           value="{{ old('nama_sesi', $session->nama_sesi) }}" required
                           class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-teal-500 focus:border-teal-500 text-sm">
                    @error('nama_sesi') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                {{-- Deskripsi --}}
                <div>
                    <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi" rows="3"
                              class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-teal-500 focus:border-teal-500 text-sm">{{ old('deskripsi', $session->deskripsi) }}</textarea>
                    @error('deskripsi') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                {{-- Dana Maksimal --}}
                <div>
                    <label for="dana_maksimal" class="block text-sm font-medium text-gray-700 mb-1">Dana Maksimal (Rp)</label>
                    <input type="number" name="dana_maksimal" id="dana_maksimal"
                           value="{{ old('dana_maksimal', $session->dana_maksimal) }}" step="0.01" min="0"
                           class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-teal-500 focus:border-teal-500 text-sm">
                    @error('dana_maksimal') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                {{-- Periode --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="periode_awal" class="block text-sm font-medium text-gray-700 mb-1">Periode Awal <span class="text-red-500">*</span></label>
                        <input type="date" name="periode_awal" id="periode_awal"
                               value="{{ old('periode_awal', $session->periode_awal->format('Y-m-d')) }}" required
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-teal-500 focus:border-teal-500 text-sm">
                        @error('periode_awal') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="periode_akhir" class="block text-sm font-medium text-gray-700 mb-1">Periode Akhir <span class="text-red-500">*</span></label>
                        <input type="date" name="periode_akhir" id="periode_akhir"
                               value="{{ old('periode_akhir', $session->periode_akhir->format('Y-m-d')) }}" required
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-teal-500 focus:border-teal-500 text-sm">
                        @error('periode_akhir') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Min/Max Anggota --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="min_anggota" class="block text-sm font-medium text-gray-700 mb-1">Min Anggota Tim</label>
                        <input type="number" name="min_anggota" id="min_anggota"
                               value="{{ old('min_anggota', $session->min_anggota) }}" min="1"
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-teal-500 focus:border-teal-500 text-sm">
                        @error('min_anggota') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="max_anggota" class="block text-sm font-medium text-gray-700 mb-1">Max Anggota Tim</label>
                        <input type="number" name="max_anggota" id="max_anggota"
                               value="{{ old('max_anggota', $session->max_anggota) }}" min="1"
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-teal-500 focus:border-teal-500 text-sm">
                        @error('max_anggota') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Status Info --}}
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <span class="text-sm font-medium text-gray-600">Status saat ini:</span>
                            @if($session->status === 'active')
                                <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-800">Active</span>
                            @elseif($session->status === 'closed')
                                <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-red-100 text-red-800">Closed</span>
                            @else
                                <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">Draft</span>
                            @endif
                        </div>
                        <div class="flex space-x-2">
                            @if($session->status === 'draft')
                                <form method="POST" action="{{ route('admin_inovasi.inovchalenge.sessions.activate', $session) }}">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="px-3 py-1.5 text-xs font-medium text-white bg-green-500 rounded-lg hover:bg-green-600 transition">
                                        <i class="fas fa-play mr-1"></i> Aktifkan
                                    </button>
                                </form>
                            @elseif($session->status === 'active')
                                <form method="POST" action="{{ route('admin_inovasi.inovchalenge.sessions.close', $session) }}">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="px-3 py-1.5 text-xs font-medium text-white bg-red-500 rounded-lg hover:bg-red-600 transition">
                                        <i class="fas fa-stop mr-1"></i> Tutup
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-100">
                    <a href="{{ route('admin_inovasi.inovchalenge.sessions.show', $session) }}"
                       class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 rounded-xl hover:bg-gray-200 transition">
                        Batal
                    </a>
                    <button type="submit"
                            class="px-5 py-2.5 text-sm font-medium text-white bg-gradient-to-r from-teal-500 to-teal-600 rounded-xl hover:from-teal-600 hover:to-teal-700 shadow transition">
                        <i class="fas fa-save mr-1"></i> Perbarui
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
