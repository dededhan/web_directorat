@extends('admin_equity.index')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100" x-data="{ 
    showModulForm: false, 
    showSubChapterForm: false, 
    showEditSubChapterForm: false,
    showEditModulForm: false,
    currentModulId: null,
    editingModul: null,
    editSubChapter: null
}">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Header --}}
        <header class="mb-8">
            <nav class="text-sm text-gray-500 mb-3">
                <ol class="list-none p-0 inline-flex items-center space-x-2">
                    <li><a href="{{ route('admin_equity.dashboard') }}" class="hover:text-teal-600">Dashboard</a></li>
                    <li><i class='bx bx-chevron-right'></i></li>
                    <li><a href="{{ route('admin_equity.student_exchange.sesi.index') }}" class="hover:text-teal-600">Student Exchange</a></li>
                    <li><i class='bx bx-chevron-right'></i></li>
                    <li><a href="{{ route('admin_equity.student_exchange.sesi.show', $sesi->id) }}" class="hover:text-teal-600">{{ $sesi->nama_sesi }}</a></li>
                    <li><i class='bx bx-chevron-right'></i></li>
                    <li class="font-medium text-gray-800">Kelola Modul</li>
                </ol>
            </nav>
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Template Laporan Akhir</h1>
                    <p class="mt-2 text-gray-600">{{ $sesi->nama_sesi }}</p>
                </div>
                <button @click="showModulForm = true" class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-teal-500 to-teal-600 text-white font-semibold rounded-xl hover:from-teal-600 hover:to-teal-700 transition-all shadow-md">
                    <i class='bx bx-plus mr-2'></i>
                    Tambah Modul
                </button>
            </div>
        </header>

        {{-- Alert Messages --}}
        @if(session('success'))
        <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg">
            <div class="flex items-center">
                <i class='bx bx-check-circle text-green-500 text-2xl mr-3'></i>
                <p class="text-green-800 font-medium">{{ session('success') }}</p>
            </div>
        </div>
        @endif

        @if($errors->any())
        <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg">
            <div class="flex items-start">
                <i class='bx bx-error-circle text-red-500 text-2xl mr-3'></i>
                <div>
                    <p class="text-red-800 font-medium mb-2">Terdapat kesalahan:</p>
                    <ul class="list-disc list-inside text-red-700">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @endif

        {{-- Module List --}}
        <div class="space-y-6">
            @forelse($moduls as $modul)
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                {{-- Module Header --}}
                <div class="bg-gradient-to-r from-purple-500 to-purple-600 px-6 py-4">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 text-white">
                        <div class="flex-1">
                            <div class="flex items-center space-x-3 mb-2">
                                <h3 class="text-xl font-bold">{{ $modul->judul_modul }}</h3>
                                <span class="px-3 py-1 bg-white/20 rounded-full text-sm">Urutan: {{ $modul->urutan }}</span>
                            </div>
                            @if($modul->deskripsi)
                            <p class="text-sm text-purple-100 mb-2">{{ $modul->deskripsi }}</p>
                            @endif
                            @if($modul->periode_awal && $modul->periode_akhir)
                            <p class="text-sm text-purple-100 flex items-center">
                                <i class='bx bx-calendar mr-2'></i>
                                {{ $modul->periode_awal->format('d M Y') }} - {{ $modul->periode_akhir->format('d M Y') }}
                            </p>
                            @endif
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="px-4 py-2 bg-white/20 rounded-lg text-sm font-semibold">
                                <i class='bx bx-book-content mr-1'></i>
                                {{ $modul->sub_chapters_count }} Sub Bab
                            </span>
                            <button @click="showEditModulForm = true; editingModul = { id: {{ $modul->id }}, judul_modul: '{{ addslashes($modul->judul_modul) }}', deskripsi: '{{ addslashes($modul->deskripsi ?? '') }}', periode_awal: '{{ $modul->periode_awal ? $modul->periode_awal->format('Y-m-d') : '' }}', periode_akhir: '{{ $modul->periode_akhir ? $modul->periode_akhir->format('Y-m-d') : '' }}', urutan: {{ $modul->urutan }} }" class="p-2 bg-white/20 hover:bg-white/30 rounded-lg transition-colors">
                                <i class='bx bx-edit text-xl'></i>
                            </button>
                            <form action="{{ route('admin_equity.student_exchange.moduls.destroyModul', [$sesi->id, $modul->id]) }}" method="POST" onsubmit="return confirm('Yakin hapus modul ini? Semua sub bab juga akan terhapus!')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 bg-red-500/80 hover:bg-red-600 rounded-lg transition-colors">
                                    <i class='bx bx-trash text-xl'></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- Sub Chapters --}}
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="text-lg font-bold text-gray-800 flex items-center">
                            <i class='bx bx-list-ul mr-2 text-xl text-teal-500'></i>
                            Sub Chapter
                        </h4>
                        <button @click="showSubChapterForm = true; currentModulId = {{ $modul->id }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 transition-all">
                            <i class='bx bx-plus mr-2'></i>
                            Tambah Sub Chapter
                        </button>
                    </div>

                    @if($modul->subChapters->count() > 0)
                    <div class="space-y-3">
                        @foreach($modul->subChapters->sortBy('urutan') as $subChapter)
                        <div class="border border-gray-200 rounded-xl p-4 hover:bg-gray-50 transition-colors">
                            <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3">
                                <div class="flex-1">
                                    <div class="flex items-center flex-wrap gap-2 mb-2">
                                        <span class="px-3 py-1 bg-gray-100 text-gray-700 text-sm font-semibold rounded-lg">
                                            {{ $subChapter->urutan }}
                                        </span>
                                        <h5 class="font-semibold text-gray-800 text-lg">{{ $subChapter->judul_sub_chapter }}</h5>
                                        @if($subChapter->is_wajib)
                                        <span class="px-3 py-1 bg-red-100 text-red-800 text-xs font-semibold rounded-full">
                                            <i class='bx bx-star mr-1'></i>Wajib
                                        </span>
                                        @else
                                        <span class="px-3 py-1 bg-gray-100 text-gray-600 text-xs rounded-full">Opsional</span>
                                        @endif
                                    </div>
                                    @if($subChapter->deskripsi)
                                    <p class="text-sm text-gray-600 mb-2">{{ $subChapter->deskripsi }}</p>
                                    @endif
                                    <div class="flex items-center space-x-4 text-sm text-gray-500">
                                        <span class="flex items-center">
                                            <i class='bx bx-file mr-1'></i>
                                            Tipe: 
                                            @if($subChapter->tipe_input === 'pdf')
                                                <span class="font-semibold ml-1">PDF</span>
                                            @elseif($subChapter->tipe_input === 'link')
                                                <span class="font-semibold ml-1">Link</span>
                                            @else
                                                <span class="font-semibold ml-1">PDF atau Link</span>
                                            @endif
                                        </span>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <button @click="showEditSubChapterForm = true; editSubChapter = { id: {{ $subChapter->id }}, student_exchange_modul_id: {{ $modul->id }}, judul_sub_chapter: '{{ addslashes($subChapter->judul_sub_chapter) }}', deskripsi: '{{ addslashes($subChapter->deskripsi ?? '') }}', tipe_input: '{{ $subChapter->tipe_input }}', is_wajib: {{ $subChapter->is_wajib ? 'true' : 'false' }}, urutan: {{ $subChapter->urutan }} }" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                        <i class='bx bx-edit text-xl'></i>
                                    </button>
                                    <form action="{{ url('admin_equity/student-exchange/sesi/' . $sesi->id . '/moduls/subchapter/' . $subChapter->id) }}" method="POST" onsubmit="return confirm('Yakin hapus sub chapter ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                            <i class='bx bx-trash text-xl'></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center py-8 bg-gray-50 rounded-xl border-2 border-dashed border-gray-300">
                        <i class='bx bx-folder-open text-5xl text-gray-300 mb-2'></i>
                        <p class="text-gray-500">Belum ada sub chapter</p>
                    </div>
                    @endif
                </div>
            </div>
            @empty
            <div class="bg-white rounded-2xl shadow-lg p-12 text-center">
                <i class='bx bx-book-open text-6xl text-gray-300 mb-4'></i>
                <h3 class="text-xl font-bold text-gray-700 mb-2">Belum Ada Modul</h3>
                <p class="text-gray-500 mb-6">Mulai buat modul laporan akhir untuk sesi ini</p>
                <button @click="showModulForm = true" class="inline-flex items-center px-6 py-3 bg-teal-600 text-white font-semibold rounded-xl hover:bg-teal-700 transition-all shadow-lg">
                    <i class='bx bx-plus mr-2'></i>
                    Tambah Modul Pertama
                </button>
            </div>
            @endforelse
        </div>

    </div>

    {{-- Modal: Add Module --}}
    <div x-show="showModulForm" x-cloak class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div @click="showModulForm = false" class="fixed inset-0 bg-black bg-opacity-50 transition-opacity"></div>
            <div class="relative bg-white rounded-2xl shadow-2xl max-w-2xl w-full p-8 z-10">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-2xl font-bold text-gray-800">Tambah Modul Baru</h3>
                    <button @click="showModulForm = false" class="text-gray-400 hover:text-gray-600">
                        <i class='bx bx-x text-3xl'></i>
                    </button>
                </div>
                <form action="{{ route('admin_equity.student_exchange.moduls.storeModul', $sesi->id) }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Judul Modul <span class="text-red-500">*</span></label>
                        <input type="text" name="judul_modul" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi</label>
                        <textarea name="deskripsi" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500"></textarea>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Periode Awal</label>
                            <input type="date" name="periode_awal" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Periode Akhir</label>
                            <input type="date" name="periode_akhir" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Urutan <span class="text-red-500">*</span></label>
                        <input type="number" name="urutan" value="1" min="1" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                    </div>
                    <div class="flex justify-end space-x-3 pt-4">
                        <button type="button" @click="showModulForm = false" class="px-6 py-3 bg-gray-200 text-gray-700 font-semibold rounded-xl hover:bg-gray-300 transition-all">
                            Batal
                        </button>
                        <button type="submit" class="px-6 py-3 bg-teal-600 text-white font-semibold rounded-xl hover:bg-teal-700 transition-all">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal: Edit Module --}}
    <div x-show="showEditModulForm" x-cloak class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div @click="showEditModulForm = false" class="fixed inset-0 bg-black bg-opacity-50 transition-opacity"></div>
            <div class="relative bg-white rounded-2xl shadow-2xl max-w-2xl w-full p-8 z-10">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-2xl font-bold text-gray-800">Edit Modul</h3>
                    <button @click="showEditModulForm = false" class="text-gray-400 hover:text-gray-600">
                        <i class='bx bx-x text-3xl'></i>
                    </button>
                </div>
                <form :action="`{{ route('admin_equity.student_exchange.moduls.updateModul', [$sesi->id, '']) }}/${editingModul?.id}`" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Judul Modul <span class="text-red-500">*</span></label>
                        <input type="text" name="judul_modul" x-model="editingModul.judul_modul" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi</label>
                        <textarea name="deskripsi" x-model="editingModul.deskripsi" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500"></textarea>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Periode Awal</label>
                            <input type="date" name="periode_awal" x-model="editingModul.periode_awal" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Periode Akhir</label>
                            <input type="date" name="periode_akhir" x-model="editingModul.periode_akhir" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Urutan <span class="text-red-500">*</span></label>
                        <input type="number" name="urutan" x-model="editingModul.urutan" min="1" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-teal-500 focus:border-teal-500">
                    </div>
                    <div class="flex justify-end space-x-3 pt-4">
                        <button type="button" @click="showEditModulForm = false" class="px-6 py-3 bg-gray-200 text-gray-700 font-semibold rounded-xl hover:bg-gray-300 transition-all">
                            Batal
                        </button>
                        <button type="submit" class="px-6 py-3 bg-teal-600 text-white font-semibold rounded-xl hover:bg-teal-700 transition-all">
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal: Add Sub Chapter --}}
    <div x-show="showSubChapterForm" x-cloak class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div @click="showSubChapterForm = false" class="fixed inset-0 bg-black bg-opacity-50 transition-opacity"></div>
            <div class="relative bg-white rounded-2xl shadow-2xl max-w-2xl w-full p-8 z-10">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-2xl font-bold text-gray-800">Tambah Sub Chapter</h3>
                    <button @click="showSubChapterForm = false" class="text-gray-400 hover:text-gray-600">
                        <i class='bx bx-x text-3xl'></i>
                    </button>
                </div>
                <form :action="`{{ url('admin_equity/student-exchange/sesi/' . $sesi->id . '/moduls/modul') }}/${currentModulId}/subchapter`" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Judul Sub Chapter <span class="text-red-500">*</span></label>
                        <input type="text" name="judul_sub_chapter" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi</label>
                        <textarea name="deskripsi" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Tipe Input <span class="text-red-500">*</span></label>
                        <select name="tipe_input" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="pdf">PDF</option>
                            <option value="link">Link</option>
                            <option value="both">PDF atau Link</option>
                        </select>
                    </div>
                    <div>
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" name="is_wajib" value="1" checked class="w-5 h-5 text-teal-600 border-gray-300 rounded focus:ring-2 focus:ring-teal-500">
                            <span class="text-sm font-semibold text-gray-700">Wajib diisi</span>
                        </label>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Urutan <span class="text-red-500">*</span></label>
                        <input type="number" name="urutan" value="1" min="1" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div class="flex justify-end space-x-3 pt-4">
                        <button type="button" @click="showSubChapterForm = false" class="px-6 py-3 bg-gray-200 text-gray-700 font-semibold rounded-xl hover:bg-gray-300 transition-all">
                            Batal
                        </button>
                        <button type="submit" class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 transition-all">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal: Edit Sub Chapter --}}
    <div x-show="showEditSubChapterForm" x-cloak class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div @click="showEditSubChapterForm = false" class="fixed inset-0 bg-black bg-opacity-50 transition-opacity"></div>
            <div class="relative bg-white rounded-2xl shadow-2xl max-w-2xl w-full p-8 z-10">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-2xl font-bold text-gray-800">Edit Sub Chapter</h3>
                    <button @click="showEditSubChapterForm = false" class="text-gray-400 hover:text-gray-600">
                        <i class='bx bx-x text-3xl'></i>
                    </button>
                </div>
                <form :action="\`{{ url('admin_equity/student-exchange/sesi/' . $sesi->id . '/moduls/subchapter') }}/${editSubChapter?.id}\`" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Judul Sub Chapter <span class="text-red-500">*</span></label>
                        <input type="text" name="judul_sub_chapter" x-model="editSubChapter.judul_sub_chapter" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi</label>
                        <textarea name="deskripsi" x-model="editSubChapter.deskripsi" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Tipe Input <span class="text-red-500">*</span></label>
                        <select name="tipe_input" x-model="editSubChapter.tipe_input" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="pdf">PDF</option>
                            <option value="link">Link</option>
                            <option value="both">PDF atau Link</option>
                        </select>
                    </div>
                    <div>
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" name="is_wajib" value="1" x-bind:checked="editSubChapter.is_wajib" class="w-5 h-5 text-teal-600 border-gray-300 rounded focus:ring-2 focus:ring-teal-500">
                            <span class="text-sm font-semibold text-gray-700">Wajib diisi</span>
                        </label>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Urutan <span class="text-red-500">*</span></label>
                        <input type="number" name="urutan" x-model="editSubChapter.urutan" min="1" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div class="flex justify-end space-x-3 pt-4">
                        <button type="button" @click="showEditSubChapterForm = false" class="px-6 py-3 bg-gray-200 text-gray-700 font-semibold rounded-xl hover:bg-gray-300 transition-all">
                            Batal
                        </button>
                        <button type="submit" class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 transition-all">
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

<style>
[x-cloak] { display: none !important; }
</style>
@endsection
