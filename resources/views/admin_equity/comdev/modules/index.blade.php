@extends('admin_equity.index')

@section('content')
<div class="container mx-auto px-4 py-6" x-data="{ openModuleForm: false, openSubChapterForm: null }">
    {{-- Header dan Breadcrumbs --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Manajemen Modul: {{ $sesi->nama_sesi }}</h1>
        <nav aria-label="breadcrumb">
            <ol class="flex items-center text-sm text-gray-500">
                <li><a href="{{ route('admin_equity.dashboard') }}" class="hover:text-sky-600">Dashboard</a></li>
                <li class="mx-2"><i class='bx bx-chevron-right text-base'></i></li>
                <li><a href="{{ route('admin_equity.comdev.index') }}" class="hover:text-sky-600">Manajemen Sesi Comdev</a></li>
                <li class="mx-2"><i class='bx bx-chevron-right text-base'></i></li>
                <li class="font-semibold text-gray-700" aria-current="page">Manajemen Modul</li>
            </ol>
        </nav>
    </div>

    {{-- Daftar Modul --}}
    <div class="space-y-6">
        @forelse($modules as $module)
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="p-4 border-b bg-gray-50 flex justify-between items-center">
                    <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                        <i class='bx bxs-collection text-xl mr-2 text-sky-600'></i>
                        {{ $module->urutan }}. {{ $module->nama_modul }}
                    </h2>
                    <div class="flex items-center space-x-2">
                        {{-- Edit Module (optional) --}}
                        {{-- <button class="text-yellow-500 hover:text-yellow-700"><i class='bx bxs-edit'></i></button> --}}
                        <form action="{{ route('admin_equity.comdev.modules.destroy', $module->id) }}" method="POST" onsubmit="return confirm('Anda yakin ingin menghapus modul ini beserta semua sub-bab di dalamnya?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700"><i class='bx bxs-trash'></i></button>
                        </form>
                    </div>
                </div>

                {{-- Daftar Sub-Bab --}}
                <div class="p-6">
                    <ul class="space-y-4">
                        @forelse($module->subChapters as $subChapter)
                            <li class="p-3 border rounded-md flex justify-between items-center">
                                <div>
                                    <p class="font-semibold">{{ $subChapter->urutan }}. {{ $subChapter->nama_sub_bab }}</p>
                                    <p class="text-xs text-gray-500">
                                        Periode: 
                                        {{ $subChapter->periode_awal ? $subChapter->periode_awal->format('d M Y') : 'N/A' }} - 
                                        {{ $subChapter->periode_akhir ? $subChapter->periode_akhir->format('d M Y') : 'N/A' }}
                                    </p>
                                </div>
                                <form action="{{ route('admin_equity.comdev.subchapters.destroy', $subChapter->id) }}" method="POST" onsubmit="return confirm('Anda yakin ingin menghapus sub-bab ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700"><i class='bx bx-trash'></i></button>
                                </form>
                            </li>
                        @empty
                            <p class="text-sm text-center text-gray-500 py-4">Belum ada sub-bab untuk modul ini.</p>
                        @endforelse
                    </ul>

                    {{-- Tombol & Form Tambah Sub-Bab --}}
                    <div class="mt-4 border-t pt-4">
                        <button @click="openSubChapterForm = {{ $module->id }}" class="text-sm text-sky-600 hover:text-sky-800 font-semibold"><i class='bx bx-plus-circle'></i> Tambah Sub-Bab</button>
                        <div x-show="openSubChapterForm === {{ $module->id }}" x-cloak class="mt-3 bg-gray-50 p-4 rounded-md">
                            <form action="{{ route('admin_equity.comdev.subchapters.store', $module->id) }}" method="POST">
                                @csrf
                                <h4 class="font-semibold mb-2">Sub-Bab Baru</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <input type="number" name="urutan" placeholder="Urutan" class="form-input rounded-md" required>
                                    <input type="text" name="nama_sub_bab" placeholder="Nama Sub-Bab" class="form-input rounded-md" required>
                                </div>
                                <textarea name="deskripsi_instruksi" placeholder="Deskripsi/Instruksi (opsional)" class="form-textarea w-full rounded-md mt-3"></textarea>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-3">
                                    <div><label class="text-xs">Periode Awal</label><input type="datetime-local" name="periode_awal" class="form-input w-full rounded-md"></div>
                                    <div><label class="text-xs">Periode Akhir</label><input type="datetime-local" name="periode_akhir" class="form-input w-full rounded-md"></div>
                                </div>
                                <div class="flex justify-end space-x-2 mt-3">
                                    <button type="button" @click="openSubChapterForm = null" class="px-3 py-1 text-sm bg-gray-200 rounded-md">Batal</button>
                                    <button type="submit" class="px-3 py-1 text-sm bg-sky-600 text-white rounded-md">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center text-gray-500 py-10">Belum ada modul yang dibuat untuk sesi ini.</p>
        @endforelse
    </div>

    {{-- Tombol & Form Tambah Modul --}}
    <div class="mt-6">
        <button @click="openModuleForm = true" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-md font-semibold hover:bg-green-700">
            <i class='bx bxs-add-to-queue text-lg mr-2'></i> Buat Modul Baru
        </button>
        <div x-show="openModuleForm" x-cloak class="mt-4 bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-lg font-semibold mb-3">Form Modul Baru</h3>
            <form action="{{ route('admin_equity.comdev.modules.storeModule', $sesi->id) }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <input type="number" name="urutan" placeholder="Urutan (cth: 1)" class="form-input rounded-md" required>
                    <input type="text" name="nama_modul" placeholder="Nama Modul" class="md:col-span-2 form-input rounded-md" required>
                </div>
                <textarea name="deskripsi" placeholder="Deskripsi singkat modul (opsional)" class="form-textarea w-full rounded-md mt-4"></textarea>
                <div class="flex justify-end space-x-3 mt-4">
                    <button type="button" @click="openModuleForm = false" class="px-4 py-2 bg-gray-200 rounded-md">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-sky-600 text-white rounded-md">Simpan Modul</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
