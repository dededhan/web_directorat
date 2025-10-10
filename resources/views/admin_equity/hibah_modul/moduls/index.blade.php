@extends('admin_equity.index')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100" x-data="{ 
    showModulForm: false, 
    showSubChapterForm: false, 
    showEditSubChapterForm: false,
    currentModulId: null,
    editingModul: null,
    editSubChapter: null
}">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <header class="mb-8">
            <nav class="text-sm text-gray-500 mb-3">
                <ol class="list-none p-0 inline-flex items-center space-x-2">
                    <li><a href="{{ route('admin_equity.dashboard') }}" class="hover:text-teal-600">Dashboard</a></li>
                    <li><i class='bx bx-chevron-right'></i></li>
                    <li><a href="{{ route('admin_equity.hibah_modul.sesi.index') }}" class="hover:text-teal-600">Hibah Modul</a></li>
                    <li><i class='bx bx-chevron-right'></i></li>
                    <li class="font-medium text-gray-800">Template Modul Akhir</li>
                </ol>
            </nav>
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Template Laporan Akhir</h1>
                    <p class="mt-2 text-gray-600">{{ $sesi->nama_sesi }}</p>
                </div>
                <button @click="showModulForm = true" class="px-4 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700">
                    <i class='bx bx-plus mr-2'></i>Tambah Modul
                </button>
            </div>
        </header>

        @if(session('success'))
        <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg">
            <p class="text-green-800 font-medium">{{ session('success') }}</p>
        </div>
        @endif

        <!-- List Moduls -->
        <div class="space-y-6">
            @forelse($moduls as $modul)
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="bg-gradient-to-r from-purple-500 to-purple-600 px-6 py-4">
                    <div class="flex items-center justify-between text-white">
                        <div>
                            <h3 class="text-lg font-bold">{{ $modul->judul_modul }}</h3>
                            <p class="text-sm text-purple-100">{{ $modul->deskripsi }}</p>
                            @if($modul->periode_awal && $modul->periode_akhir)
                            <p class="text-sm text-purple-100 mt-1">Periode: {{ $modul->periode_awal->format('d M Y') }} - {{ $modul->periode_akhir->format('d M Y') }}</p>
                            @endif
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="px-3 py-1 bg-white/20 rounded-full text-sm">Urutan: {{ $modul->urutan }}</span>
                            <span class="px-3 py-1 bg-white/20 rounded-full text-sm">{{ $modul->sub_chapters_count }} Sub Bab</span>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="text-md font-bold text-gray-800">Sub Chapter</h4>
                        <button @click="showSubChapterForm = true; currentModulId = {{ $modul->id }}" class="px-3 py-1 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700">
                            <i class='bx bx-plus mr-1'></i>Tambah Sub Chapter
                        </button>
                    </div>

                    @if($modul->subChapters->count() > 0)
                    <div class="space-y-3">
                        @foreach($modul->subChapters as $subChapter)
                        <div class="border rounded-lg p-4 flex items-start justify-between hover:bg-gray-50">
                            <div class="flex-1">
                                <div class="flex items-center space-x-2 mb-2">
                                    <span class="px-2 py-1 bg-gray-100 text-gray-600 text-xs rounded">{{ $subChapter->urutan }}</span>
                                    <h5 class="font-semibold text-gray-800">{{ $subChapter->judul_sub_chapter }}</h5>
                                    @if($subChapter->is_wajib)
                                    <span class="px-2 py-1 bg-red-100 text-red-800 text-xs font-semibold rounded-full">Wajib</span>
                                    @else
                                    <span class="px-2 py-1 bg-gray-100 text-gray-600 text-xs rounded-full">Opsional</span>
                                    @endif
                                </div>
                                <p class="text-sm text-gray-600">{{ $subChapter->deskripsi }}</p>
                                <p class="text-sm text-gray-500 mt-1">
                                    Tipe Input: 
                                    @if($subChapter->tipe_input === 'pdf') PDF
                                    @elseif($subChapter->tipe_input === 'link') Link
                                    @else PDF atau Link
                                    @endif
                                </p>
                            </div>
                            <div class="flex items-center space-x-2 ml-4">
                                <button @click="showEditSubChapterForm = true; editSubChapter = { id: {{ $subChapter->id }}, modul_akhir_id: {{ $modul->id }}, judul_sub_chapter: '{{ $subChapter->judul_sub_chapter }}', deskripsi: '{{ $subChapter->deskripsi }}', tipe_input: '{{ $subChapter->tipe_input }}', is_wajib: {{ $subChapter->is_wajib ? 'true' : 'false' }}, urutan: {{ $subChapter->urutan }} }" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg">
                                    <i class='bx bx-edit text-xl'></i>
                                </button>
                                <form action="{{ route('admin_equity.hibah_modul.moduls.destroySubChapter', [$sesi->id, $subChapter->id]) }}" method="POST" onsubmit="return confirm('Yakin hapus sub chapter ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg">
                                        <i class='bx bx-trash text-xl'></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <p class="text-center text-gray-500 py-6">Belum ada sub chapter</p>
                    @endif
                </div>

                <div class="px-6 py-4 bg-gray-50 border-t flex justify-end space-x-2">
                    <form action="{{ route('admin_equity.hibah_modul.moduls.destroyModul', [$sesi->id, $modul->id]) }}" method="POST" onsubmit="return confirm('Yakin hapus modul ini beserta semua sub chapter?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                            <i class='bx bx-trash mr-2'></i>Hapus Modul
                        </button>
                    </form>
                </div>
            </div>
            @empty
            <div class="bg-white rounded-xl shadow-md p-12 text-center">
                <i class='bx bx-inbox text-6xl text-gray-300 mb-4'></i>
                <p class="text-gray-500 text-lg">Belum ada modul template. Klik "Tambah Modul" untuk membuat.</p>
            </div>
            @endforelse
        </div>

        <!-- Modal Tambah Modul -->
        <div x-show="showModulForm" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="flex items-center justify-center min-h-screen px-4">
                <div @click="showModulForm = false" class="fixed inset-0 bg-black opacity-50"></div>
                <div class="relative bg-white rounded-xl shadow-2xl max-w-2xl w-full p-6 z-10">
                    <h3 class="text-2xl font-bold mb-4">Tambah Modul Baru</h3>
                    <form action="{{ route('admin_equity.hibah_modul.moduls.storeModul', $sesi->id) }}" method="POST">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Judul Modul</label>
                                <input type="text" name="judul_modul" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-teal-500">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi</label>
                                <textarea name="deskripsi" rows="3" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-teal-500"></textarea>
                            </div>
                            <div class="grid grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Urutan</label>
                                    <input type="number" name="urutan" value="{{ $moduls->count() + 1 }}" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-teal-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Periode Awal</label>
                                    <input type="date" name="periode_awal" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-teal-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Periode Akhir</label>
                                    <input type="date" name="periode_akhir" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-teal-500">
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-end space-x-3 mt-6">
                            <button type="button" @click="showModulForm = false" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">Batal</button>
                            <button type="submit" class="px-4 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700">Simpan Modul</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Tambah Sub Chapter -->
        <div x-show="showSubChapterForm" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="flex items-center justify-center min-h-screen px-4">
                <div @click="showSubChapterForm = false; currentModulId = null" class="fixed inset-0 bg-black opacity-50"></div>
                <div class="relative bg-white rounded-xl shadow-2xl max-w-2xl w-full p-6 z-10">
                    <h3 class="text-2xl font-bold mb-4">Tambah Sub Chapter</h3>
                    <form :action="`{{ url('admin_equity/hibah-modul/sesi/' . $sesi->id . '/moduls/modul') }}/${currentModulId}/subchapter`" method="POST">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Judul Sub Chapter</label>
                                <input type="text" name="judul_sub_chapter" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-teal-500">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi</label>
                                <textarea name="deskripsi" rows="3" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-teal-500"></textarea>
                            </div>
                            <div class="grid grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Tipe Input</label>
                                    <select name="tipe_input" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-teal-500">
                                        <option value="pdf">PDF</option>
                                        <option value="link">Link</option>
                                        <option value="pdf_atau_link">PDF atau Link</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Urutan</label>
                                    <input type="number" name="urutan" value="1" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-teal-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
                                    <select name="is_wajib" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-teal-500">
                                        <option value="1">Wajib</option>
                                        <option value="0">Opsional</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-end space-x-3 mt-6">
                            <button type="button" @click="showSubChapterForm = false; currentModulId = null" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">Batal</button>
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Simpan Sub Chapter</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Edit Sub Chapter -->
        <div x-show="showEditSubChapterForm" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="flex items-center justify-center min-h-screen px-4">
                <div @click="showEditSubChapterForm = false; editSubChapter = null" class="fixed inset-0 bg-black opacity-50"></div>
                <div class="relative bg-white rounded-xl shadow-2xl max-w-2xl w-full p-6 z-10">
                    <h3 class="text-2xl font-bold mb-4">Edit Sub Chapter</h3>
                    <form :action="`{{ url('admin_equity/hibah-modul/sesi/' . $sesi->id . '/moduls/subchapter') }}/${editSubChapter?.id}`" method="POST" x-show="editSubChapter">
                        @csrf
                        @method('PUT')
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Judul Sub Chapter</label>
                                <input type="text" name="judul_sub_chapter" :value="editSubChapter?.judul_sub_chapter" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-teal-500">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi</label>
                                <textarea name="deskripsi" rows="3" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-teal-500" x-text="editSubChapter?.deskripsi"></textarea>
                            </div>
                            <div class="grid grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Tipe Input</label>
                                    <select name="tipe_input" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-teal-500" x-model="editSubChapter.tipe_input">
                                        <option value="pdf">PDF</option>
                                        <option value="link">Link</option>
                                        <option value="pdf_atau_link">PDF atau Link</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Urutan</label>
                                    <input type="number" name="urutan" :value="editSubChapter?.urutan" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-teal-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
                                    <select name="is_wajib" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-teal-500" x-model="editSubChapter.is_wajib">
                                        <option :value="true">Wajib</option>
                                        <option :value="false">Opsional</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-end space-x-3 mt-6">
                            <button type="button" @click="showEditSubChapterForm = false; editSubChapter = null" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">Batal</button>
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Update Sub Chapter</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
