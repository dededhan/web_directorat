{{-- 
    =================================================================
    File: index.blade.php (Manajemen Modul)
    Deskripsi: Halaman untuk mengelola modul dan sub-bab dalam sesi.
    Versi Desain: Final v2 - Konsisten
    Pembaruan: Menerapkan desain profesional pada kartu, form, 
               dan tombol, sambil mempertahankan semua logika Alpine.js.
    Skema Warna: Dominan #11A697 (Teal).
    =================================================================
--}}

@extends('admin_equity.index')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="{ openModuleForm: false, openSubChapterForm: null }">
    {{-- Header dan Breadcrumbs --}}
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Manajemen Modul: {{ $sesi->nama_sesi }}</h1>
        <nav aria-label="breadcrumb" class="mt-2">
            <ol class="flex items-center text-sm text-gray-500">
                <li><a href="{{ route('admin_equity.dashboard') }}" class="hover:text-[#11A697]">Dashboard</a></li>
                <li class="mx-2"><i class='bx bx-chevron-right text-base'></i></li>
                <li><a href="{{ route('admin_equity.comdev.index') }}" class="hover:text-[#11A697]">Manajemen Sesi Comdev</a></li>
                <li class="mx-2"><i class='bx bx-chevron-right text-base'></i></li>
                <li class="font-semibold text-gray-700" aria-current="page">Manajemen Modul</li>
            </ol>
        </nav>
    </div>

    {{-- Daftar Modul --}}
    <div class="space-y-8">
        @forelse($modules as $module)
            <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
                <div class="p-5 border-b bg-[#11A697] text-white flex justify-between items-center">
                    <h2 class="text-xl font-semibold flex items-center">
                        <i class='bx bxs-collection text-2xl mr-3'></i>
                        {{ $module->urutan }}. {{ $module->nama_modul }}
                    </h2>
                    <div class="flex items-center space-x-2">
                        <form action="{{ route('admin_equity.comdev.modules.destroy', $module->id) }}" method="POST" onsubmit="return confirm('Anda yakin ingin menghapus modul ini beserta semua sub-bab di dalamnya?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-white hover:text-red-200 transition duration-200" title="Hapus Modul"><i class='bx bxs-trash text-xl'></i></button>
                        </form>
                    </div>
                </div>

                {{-- Daftar Sub-Bab --}}
                <div class="p-6">
                    <ul class="space-y-3">
                        @forelse($module->subChapters as $subChapter)
                            <li class="p-4 bg-gray-50 border border-gray-200 rounded-lg flex justify-between items-center">
                                <div>
                                    <p class="font-semibold text-gray-800">{{ $subChapter->urutan }}. {{ $subChapter->nama_sub_bab }}</p>
                                    <p class="text-xs text-gray-500 mt-1">
                                        Periode: 
                                        {{ $subChapter->periode_awal ? \Carbon\Carbon::parse($subChapter->periode_awal)->isoFormat('D MMM YYYY, HH:mm') : 'N/A' }} - 
                                        {{ $subChapter->periode_akhir ? \Carbon\Carbon::parse($subChapter->periode_akhir)->isoFormat('D MMM YYYY, HH:mm') : 'N/A' }}
                                    </p>
                                </div>
                                <form action="{{ route('admin_equity.comdev.subchapters.destroy', $subChapter->id) }}" method="POST" onsubmit="return confirm('Anda yakin ingin menghapus sub-bab ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 transition" title="Hapus Sub-Bab"><i class='bx bx-trash text-lg'></i></button>
                                </form>
                            </li>
                        @empty
                            <p class="text-sm text-center text-gray-500 py-4">Belum ada sub-bab untuk modul ini.</p>
                        @endforelse
                    </ul>

                    {{-- Tombol & Form Tambah Sub-Bab --}}
                    <div class="mt-6 border-t pt-5">
                        <button @click="openSubChapterForm = (openSubChapterForm === {{ $module->id }} ? null : {{ $module->id }})" class="inline-flex items-center text-sm text-[#11A697] hover:text-[#0e8a7c] font-semibold transition">
                            <i class='bx bx-plus-circle mr-2 text-lg'></i> Tambah Sub-Bab
                        </button>
                        <div x-show="openSubChapterForm === {{ $module->id }}" x-cloak x-transition class="mt-4 bg-gray-50/70 p-4 rounded-lg border">
                            <form action="{{ route('admin_equity.comdev.subchapters.store', $module->id) }}" method="POST" class="space-y-4">
                                @csrf
                                <h4 class="font-semibold text-gray-700">Form Sub-Bab Baru</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="sub_urutan_{{ $module->id }}" class="block text-sm font-medium text-gray-700 mb-1">Urutan</label>
                                        <input type="number" id="sub_urutan_{{ $module->id }}" name="urutan" placeholder="Cth: 1" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-[#11A697] focus:ring focus:ring-[#11A697] focus:ring-opacity-50" required>
                                    </div>
                                    <div>
                                        <label for="sub_nama_{{ $module->id }}" class="block text-sm font-medium text-gray-700 mb-1">Nama Sub-Bab</label>
                                        <input type="text" id="sub_nama_{{ $module->id }}" name="nama_sub_bab" placeholder="Masukkan nama sub-bab" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-[#11A697] focus:ring focus:ring-[#11A697] focus:ring-opacity-50" required>
                                    </div>
                                </div>
                                <div>
                                    <label for="sub_deskripsi_{{ $module->id }}" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi/Instruksi (Opsional)</label>
                                    <textarea id="sub_deskripsi_{{ $module->id }}" name="deskripsi_instruksi" placeholder="Jelaskan instruksi singkat untuk sub-bab ini" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-[#11A697] focus:ring focus:ring-[#11A697] focus:ring-opacity-50" rows="3"></textarea>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="sub_periode_awal_{{ $module->id }}" class="block text-sm font-medium text-gray-700 mb-1">Periode Awal</label>
                                        <input type="datetime-local" id="sub_periode_awal_{{ $module->id }}" name="periode_awal" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-[#11A697] focus:ring focus:ring-[#11A697] focus:ring-opacity-50">
                                    </div>
                                    <div>
                                        <label for="sub_periode_akhir_{{ $module->id }}" class="block text-sm font-medium text-gray-700 mb-1">Periode Akhir</label>
                                        <input type="datetime-local" id="sub_periode_akhir_{{ $module->id }}" name="periode_akhir" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-[#11A697] focus:ring focus:ring-[#11A697] focus:ring-opacity-50">
                                    </div>
                                </div>
                                <div class="flex justify-end space-x-2 pt-2">
                                    <button type="button" @click="openSubChapterForm = null" class="px-4 py-2 text-sm bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 transition">Batal</button>
                                    <button type="submit" class="px-4 py-2 text-sm bg-[#11A697] text-white rounded-md hover:bg-[#0e8a7c] transition">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center bg-white border border-dashed rounded-lg py-12">
                <p class="text-gray-500">Belum ada modul yang dibuat untuk sesi ini.</p>
                <p class="text-sm text-gray-400 mt-1">Klik tombol di bawah untuk memulai.</p>
            </div>
        @endforelse
    </div>

    {{-- Tombol & Form Tambah Modul --}}
    <div class="mt-8">
        <button @click="openModuleForm = !openModuleForm" class="inline-flex items-center px-5 py-2.5 bg-[#11A697] text-white rounded-lg font-semibold hover:bg-[#0e8a7c] shadow-sm transition">
            <i class='bx bxs-add-to-queue text-lg mr-2'></i> Buat Modul Baru
        </button>
        <div x-show="openModuleForm" x-cloak x-transition class="mt-4">
             <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
                <div class="p-5 border-b bg-gray-800 text-white">
                    <h3 class="text-xl font-semibold">Form Modul Baru</h3>
                </div>
                <form action="{{ route('admin_equity.comdev.modules.storeModule', $sesi->id) }}" method="POST" class="p-6 space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label for="modul_urutan" class="block text-sm font-medium text-gray-700 mb-1">Urutan</label>
                            <input type="number" id="modul_urutan" name="urutan" placeholder="Cth: 1" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-[#11A697] focus:ring focus:ring-[#11A697] focus:ring-opacity-50" required>
                        </div>
                        <div class="md:col-span-2">
                            <label for="modul_nama" class="block text-sm font-medium text-gray-700 mb-1">Nama Modul</label>
                            <input type="text" id="modul_nama" name="nama_modul" placeholder="Masukkan nama modul" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-[#11A697] focus:ring focus:ring-[#11A697] focus:ring-opacity-50" required>
                        </div>
                    </div>
                    <div>
                        <label for="modul_deskripsi" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi (Opsional)</label>
                        <textarea id="modul_deskripsi" name="deskripsi" placeholder="Jelaskan deskripsi singkat tentang modul ini" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-[#11A697] focus:ring focus:ring-[#11A697] focus:ring-opacity-50" rows="3"></textarea>
                    </div>
                    <div class="flex justify-end space-x-3 border-t pt-4">
                        <button type="button" @click="openModuleForm = false" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 transition">Batal</button>
                        <button type="submit" class="px-4 py-2 bg-[#11A697] text-white rounded-md hover:bg-[#0e8a7c] transition">Simpan Modul</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection