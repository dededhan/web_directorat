@extends('subdirektorat-inovasi.dosen.index')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100" x-data="{ currentFile: null, currentSubChapterId: null, showUploadModal: false, fileType: 'pdf' }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <header class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Laporan Akhir</h1>
            <p class="mt-2 text-gray-600">{{ $proposal->judul_modul }}</p>
        </header>

        @if(session('success'))
        <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg">
            <p class="text-green-800 font-medium">{{ session('success') }}</p>
        </div>
        @endif

        @if($errors->any())
        <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg">
            <p class="text-red-800 font-semibold mb-2">Error:</p>
            <ul class="list-disc list-inside text-red-700">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Loop Moduls -->
        @foreach($moduls as $modul)
        <div class="bg-white rounded-xl shadow-md overflow-hidden mb-6">
            <div class="bg-gradient-to-r from-purple-500 to-purple-600 px-6 py-4">
                <h2 class="text-xl font-bold text-white">{{ $modul->judul_modul }}</h2>
                <p class="text-purple-100 text-sm">{{ $modul->deskripsi }}</p>
                @if($modul->periode_awal && $modul->periode_akhir)
                <p class="text-purple-100 text-sm mt-1">Periode: {{ $modul->periode_awal->format('d M Y') }} - {{ $modul->periode_akhir->format('d M Y') }}</p>
                @endif
            </div>

            <div class="p-6">
                <div class="space-y-4">
                    @foreach($modul->subChapters as $subChapter)
                    @php
                        $existingFile = $proposal->files->where('modul_sub_chapter_id', $subChapter->id)->first();
                        $review = $proposal->reviews->where('modul_sub_chapter_id', $subChapter->id)->first();
                    @endphp
                    <div class="border rounded-lg p-4 {{ $existingFile ? 'bg-green-50 border-green-200' : ($subChapter->is_wajib ? 'bg-yellow-50 border-yellow-200' : '') }}">
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex-1">
                                <div class="flex items-center space-x-2 mb-2">
                                    <h3 class="font-semibold text-gray-800">{{ $subChapter->judul_sub_chapter }}</h3>
                                    @if($subChapter->is_wajib)
                                    <span class="px-2 py-1 bg-red-100 text-red-800 text-xs font-semibold rounded-full">Wajib</span>
                                    @else
                                    <span class="px-2 py-1 bg-gray-100 text-gray-600 text-xs rounded-full">Opsional</span>
                                    @endif
                                </div>
                                <p class="text-sm text-gray-600">{{ $subChapter->deskripsi }}</p>
                                <p class="text-sm text-gray-500 mt-1">
                                    Tipe Input: 
                                    @if($subChapter->tipe_input === 'pdf') <strong>PDF</strong>
                                    @elseif($subChapter->tipe_input === 'link') <strong>Link</strong>
                                    @else <strong>PDF atau Link</strong>
                                    @endif
                                </p>
                            </div>
                            
                            @if(!$existingFile)
                            <button @click="currentSubChapterId = {{ $subChapter->id }}; fileType = '{{ $subChapter->tipe_input }}'; showUploadModal = true" class="px-4 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 flex-shrink-0">
                                <i class='bx bx-upload mr-1'></i>Upload
                            </button>
                            @endif
                        </div>

                        @if($existingFile)
                        <div class="border-t pt-3 mt-3">
                            <div class="flex items-center justify-between bg-white p-3 rounded-lg">
                                <div>
                                    <p class="text-sm font-semibold text-gray-800">
                                        @if($existingFile->tipe_file === 'pdf')
                                            <i class='bx bxs-file-pdf text-red-600 mr-1'></i>File PDF
                                        @else
                                            <i class='bx bx-link text-blue-600 mr-1'></i>Link URL
                                        @endif
                                    </p>
                                    @if($existingFile->keterangan)
                                    <p class="text-xs text-gray-600">{{ $existingFile->keterangan }}</p>
                                    @endif
                                </div>
                                <div class="flex items-center space-x-2">
                                    @if($existingFile->tipe_file === 'pdf')
                                    <a href="{{ route('subdirektorat-inovasi.dosen.hibah_modul.downloadFile', $existingFile->id) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg">
                                        <i class='bx bx-download text-xl'></i>
                                    </a>
                                    @else
                                    <a href="{{ $existingFile->link_url }}" target="_blank" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg">
                                        <i class='bx bx-link-external text-xl'></i>
                                    </a>
                                    @endif
                                    <form action="{{ route('subdirektorat-inovasi.dosen.hibah_modul.deleteFile', $existingFile->id) }}" method="POST" onsubmit="return confirm('Yakin hapus file ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg">
                                            <i class='bx bx-trash text-xl'></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endif

                        @if($review)
                        <div class="border-t pt-3 mt-3">
                            <div class="bg-purple-50 p-3 rounded-lg">
                                <p class="text-sm font-semibold text-purple-800 mb-1">Review dari Reviewer:</p>
                                <p class="text-sm text-purple-900">{{ $review->komentar }}</p>
                                @if($review->nilai)
                                <p class="text-sm text-purple-600 mt-2 font-semibold">Nilai: {{ $review->nilai }}/100</p>
                                @endif
                            </div>
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endforeach

        <!-- Modal Upload -->
        <div x-show="showUploadModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;" x-data="{ selectedType: 'pdf' }">
            <div class="flex items-center justify-center min-h-screen px-4">
                <div @click="showUploadModal = false" class="fixed inset-0 bg-black opacity-50"></div>
                <div class="relative bg-white rounded-xl shadow-2xl max-w-lg w-full p-6 z-10">
                    <h3 class="text-2xl font-bold mb-4">Upload File</h3>
                    <form :action="`{{ url('subdirektorat-inovasi/dosen/hibah-modul/proposal/' . $proposal->id . '/subchapter') }}/${currentSubChapterId}/upload`" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-4" x-show="fileType === 'pdf_atau_link'">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Pilih Tipe Input</label>
                            <select name="input_type_selector" class="w-full px-4 py-2 border rounded-lg" x-model="selectedType">
                                <option value="pdf">Upload PDF</option>
                                <option value="link">Link URL</option>
                            </select>
                        </div>

                        <input type="hidden" name="tipe_file" :value="fileType === 'pdf_atau_link' ? selectedType : fileType">

                        <div class="mb-4" x-show="(fileType === 'pdf_atau_link' && selectedType === 'pdf') || fileType === 'pdf'">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Upload File PDF <span class="text-red-500">*</span></label>
                            <input type="file" name="file_path" accept=".pdf" class="w-full px-4 py-2 border rounded-lg" 
                                :required="(fileType === 'pdf_atau_link' && selectedType === 'pdf') || fileType === 'pdf'"
                                :disabled="(fileType === 'pdf_atau_link' && selectedType !== 'pdf') && fileType !== 'pdf'">
                        </div>

                        <div class="mb-4" x-show="(fileType === 'pdf_atau_link' && selectedType === 'link') || fileType === 'link'">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">URL Link <span class="text-red-500">*</span></label>
                            <input type="url" name="link_url" placeholder="https://..." class="w-full px-4 py-2 border rounded-lg" 
                                :required="(fileType === 'pdf_atau_link' && selectedType === 'link') || fileType === 'link'"
                                :disabled="(fileType === 'pdf_atau_link' && selectedType !== 'link') && fileType !== 'link'">
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Keterangan (opsional)</label>
                            <textarea name="keterangan" rows="3" class="w-full px-4 py-2 border rounded-lg"></textarea>
                        </div>

                        <div class="flex justify-end space-x-3">
                            <button type="button" @click="showUploadModal = false" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">Batal</button>
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                <i class='bx bx-upload mr-2'></i>Upload
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
