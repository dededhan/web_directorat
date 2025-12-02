@extends('subdirektorat-inovasi.dosen.index')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100" x-data="laporanAkhirData()">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Breadcrumb dan Header --}}
        <header class="mb-10">
            <nav class="text-sm text-gray-500 mb-3" aria-label="Breadcrumb">
                <ol class="list-none p-0 inline-flex items-center space-x-2">
                    <li><a href="{{ route('subdirektorat-inovasi.dosen.dashboard') }}" class="hover:text-teal-600 transition-colors duration-200">Home</a></li>
                    <li><i class='bx bx-chevron-right text-base text-gray-400'></i></li>
                    <li><a href="{{ route('subdirektorat-inovasi.dosen.student_exchange.manage') }}" class="hover:text-teal-600 transition-colors duration-200">Student Exchange</a></li>
                    <li><i class='bx bx-chevron-right text-base text-gray-400'></i></li>
                    <li><a href="{{ route('subdirektorat-inovasi.dosen.student_exchange.show', $proposal->id) }}" class="hover:text-teal-600 transition-colors duration-200">Detail Proposal</a></li>
                    <li><i class='bx bx-chevron-right text-base text-gray-400'></i></li>
                    <li class="font-medium text-gray-800">Laporan Akhir</li>
                </ol>
            </nav>
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl lg:text-3xl font-bold text-gray-800">Laporan Akhir Student Exchange</h1>
                    <p class="mt-2 text-gray-600 text-base">Proposal: <span class="font-semibold text-teal-600">{{ $proposal->judul_kegiatan }}</span></p>
                </div>
                <a href="{{ route('subdirektorat-inovasi.dosen.student_exchange.show', $proposal->id) }}" class="inline-flex items-center px-4 py-2.5 bg-white border-2 border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 shadow-sm">
                    <i class='bx bx-arrow-back mr-2 text-lg'></i>
                    Kembali
                </a>
            </div>
        </header>

        {{-- Alert Messages --}}
        @if(session('success'))
        <div class="mb-6 bg-green-50 border-l-4 border-green-400 p-4 rounded-lg shadow-sm" role="alert">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <i class='bx bx-check-circle text-green-400 text-xl'></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-bold text-green-800">Sukses</h3>
                    <p class="text-sm text-green-700 mt-1">{{ session('success') }}</p>
                </div>
            </div>
        </div>
        @endif

        @if($errors->any())
        <div class="mb-6 bg-red-50 border-l-4 border-red-400 p-4 rounded-lg shadow-sm" role="alert">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <i class='bx bx-error-circle text-red-400 text-xl'></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-bold text-red-800">Terdapat Kesalahan</h3>
                    <ul class="list-disc list-inside text-sm text-red-700 mt-1">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @endif

        {{-- Info Box --}}
        <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded-lg mb-6">
            <div class="flex items-start">
                <i class='bx bx-info-circle text-blue-500 text-2xl mr-3'></i>
                <div>
                    <h3 class="text-sm font-bold text-blue-800">Petunjuk Pengisian</h3>
                    <p class="text-sm text-blue-700 mt-1">Upload file laporan sesuai dengan sub-bab yang telah ditentukan. File yang ditandai <span class="font-semibold">"Wajib"</span> harus diisi. Anda dapat mengupload file PDF atau menyisipkan link sesuai tipe input yang diminta.</p>
                </div>
            </div>
        </div>

        {{-- Loop Moduls --}}
        @forelse($moduls as $modul)
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden mb-6" x-data="{ open: {{ $loop->first ? 'true' : 'false' }} }">
            <div class="bg-gradient-to-r from-purple-500 to-purple-600 px-6 py-4 cursor-pointer" @click="open = !open">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <h2 class="text-xl font-bold text-white flex items-center">
                            <i class='bx bx-book-alt mr-2 text-2xl'></i>
                            {{ $modul->judul_modul }}
                        </h2>
                        <p class="text-purple-100 text-sm mt-1">{{ $modul->deskripsi }}</p>
                        @if($modul->periode_awal && $modul->periode_akhir)
                        <p class="text-purple-100 text-sm mt-1">
                            <i class='bx bx-calendar mr-1'></i>
                            Periode: {{ $modul->periode_awal->format('d M Y') }} - {{ $modul->periode_akhir->format('d M Y') }}
                        </p>
                        @endif
                    </div>
                    <i class='bx text-white text-3xl transition-transform duration-200' :class="open ? 'bx-chevron-up' : 'bx-chevron-down'"></i>
                </div>
            </div>

            <div x-show="open" x-transition class="p-6">
                <div class="space-y-4">
                    @forelse($modul->subChapters as $subChapter)
                    @php
                        $existingFile = $proposal->submissionFiles->where('student_exchange_sub_chapter_id', $subChapter->id)->first();
                        $review = $proposal->reviews->where('student_exchange_sub_chapter_id', $subChapter->id)->first();
                    @endphp
                    <div class="border rounded-xl p-4 transition-all {{ $existingFile ? 'bg-green-50 border-green-200' : ($subChapter->is_wajib ? 'bg-yellow-50 border-yellow-200' : 'bg-gray-50 border-gray-200') }}">
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex-1">
                                <div class="flex items-center space-x-2 mb-2">
                                    <h3 class="font-semibold text-gray-800">{{ $subChapter->judul_sub_chapter }}</h3>
                                    @if($subChapter->is_wajib)
                                    <span class="px-2 py-1 bg-red-100 text-red-800 text-xs font-semibold rounded-full">Wajib</span>
                                    @else
                                    <span class="px-2 py-1 bg-gray-100 text-gray-600 text-xs rounded-full">Opsional</span>
                                    @endif
                                    @if($existingFile)
                                    <span class="px-2 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full flex items-center">
                                        <i class='bx bx-check-circle mr-1'></i>Sudah Upload
                                    </span>
                                    @endif
                                </div>
                                <p class="text-sm text-gray-600">{{ $subChapter->deskripsi }}</p>
                                <p class="text-sm text-gray-500 mt-2 flex items-center">
                                    <i class='bx bx-info-circle mr-1'></i>
                                    Tipe Input: 
                                    @if($subChapter->tipe_input === 'pdf') <strong class="ml-1">PDF</strong>
                                    @elseif($subChapter->tipe_input === 'link') <strong class="ml-1">Link</strong>
                                    @else <strong class="ml-1">PDF atau Link</strong>
                                    @endif
                                </p>
                            </div>
                            
                            <button @click="openUploadModal({{ $subChapter->id }}, '{{ $subChapter->tipe_input }}')" class="px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 transition-all flex-shrink-0 ml-4">
                                <i class='bx {{ $existingFile ? 'bx-edit' : 'bx-upload' }} mr-1'></i>
                                {{ $existingFile ? 'Update' : 'Upload' }}
                            </button>
                        </div>

                        {{-- Existing File Display --}}
                        @if($existingFile)
                        <div class="mt-3 p-3 bg-white border border-gray-200 rounded-lg">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    @if($existingFile->tipe_file === 'pdf')
                                    <i class='bx bxs-file-pdf text-red-500 text-2xl'></i>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-800">File PDF</p>
                                        <p class="text-xs text-gray-500">{{ basename($existingFile->file_path) }}</p>
                                    </div>
                                    @else
                                    <i class='bx bx-link text-blue-500 text-2xl'></i>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-800">Link URL</p>
                                        <a href="{{ $existingFile->link_url }}" target="_blank" class="text-xs text-blue-600 hover:underline">{{ Str::limit($existingFile->link_url, 50) }}</a>
                                    </div>
                                    @endif
                                </div>
                                @if($existingFile->tipe_file === 'pdf')
                                <a href="{{ Storage::url($existingFile->file_path) }}" target="_blank" class="px-3 py-1.5 bg-blue-500 text-white text-xs font-semibold rounded hover:bg-blue-600 transition-all">
                                    <i class='bx bx-download mr-1'></i>Unduh
                                </a>
                                @endif
                            </div>
                            @if($existingFile->keterangan)
                            <p class="text-xs text-gray-600 mt-2 border-t pt-2">Keterangan: {{ $existingFile->keterangan }}</p>
                            @endif
                        </div>
                        @endif

                        {{-- Review Display --}}
                        @if($review && $review->komentar)
                        <div class="mt-3 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                            <div class="flex items-start">
                                <i class='bx bx-message-square-detail text-blue-500 text-xl mr-2'></i>
                                <div class="flex-1">
                                    <p class="text-xs font-semibold text-blue-800">Komentar Reviewer:</p>
                                    <p class="text-sm text-blue-700 mt-1">{{ $review->komentar }}</p>
                                    @if($review->nilai)
                                    <p class="text-xs text-blue-600 mt-2">Nilai: <span class="font-bold">{{ $review->nilai }}</span></p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    @empty
                    <div class="text-center py-8">
                        <i class='bx bx-folder-open text-4xl text-gray-300 mb-2'></i>
                        <p class="text-gray-500">Belum ada sub-bab untuk modul ini</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
        @empty
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="text-center py-20 px-6">
                <div class="flex flex-col items-center">
                    <div class="w-24 h-24 bg-gradient-to-br from-gray-100 to-gray-200 rounded-2xl flex items-center justify-center mb-6">
                        <i class='bx bx-folder-open text-4xl text-gray-400'></i>
                    </div>
                    <h3 class="font-bold text-xl text-gray-800 mb-2">Belum Ada Modul Tersedia</h3>
                    <p class="text-gray-500 mb-2">Admin belum membuat modul laporan akhir untuk sesi ini.</p>
                    <p class="text-gray-400 text-sm">Silakan hubungi admin jika ada pertanyaan.</p>
                </div>
            </div>
        </div>
        @endforelse
    </div>

    {{-- Upload Modal --}}
    <div x-show="showUploadModal" x-cloak @click.away="closeUploadModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" @click="closeUploadModal"></div>

            <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form :action="'/subdirektorat-inovasi/dosen/student-exchange/' + {{ $proposal->id }} + '/laporan-akhir'" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="subChapterId" :value="currentSubChapterId">
                    
                    <div class="bg-gradient-to-r from-purple-500 to-purple-600 px-6 py-4">
                        <h3 class="text-lg font-bold text-white flex items-center">
                            <i class='bx bx-upload mr-2 text-2xl'></i>
                            Upload Dokumen
                        </h3>
                    </div>

                    <div class="p-6 space-y-4">
                        <div x-show="fileType === 'pdf' || fileType === 'both'">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Upload File PDF</label>
                            <input type="file" name="file" accept=".pdf" class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all" :required="fileType === 'pdf'">
                        </div>

                        <div x-show="fileType === 'link' || fileType === 'both'">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Link URL</label>
                            <input type="url" name="link_url" class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all" placeholder="https://example.com/document" :required="fileType === 'link'">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Keterangan (Opsional)</label>
                            <textarea name="keterangan" rows="3" class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all" placeholder="Tambahkan keterangan jika diperlukan"></textarea>
                        </div>
                    </div>

                    <div class="bg-gray-50 px-6 py-4 flex justify-end space-x-3">
                        <button type="button" @click="closeUploadModal" class="px-4 py-2 bg-gray-200 text-gray-700 font-semibold rounded-xl hover:bg-gray-300 transition-all">
                            Batal
                        </button>
                        <button type="submit" class="px-4 py-2 bg-purple-600 text-white font-semibold rounded-xl hover:bg-purple-700 transition-all">
                            <i class='bx bx-upload mr-1'></i>
                            Upload
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    [x-cloak] { display: none !important; }
</style>
@endpush

@push('scripts')
<script>
    function laporanAkhirData() {
        return {
            showUploadModal: false,
            currentSubChapterId: null,
            fileType: 'pdf',
            
            openUploadModal(subChapterId, fileType) {
                this.currentSubChapterId = subChapterId;
                this.fileType = fileType;
                this.showUploadModal = true;
            },
            
            closeUploadModal() {
                this.showUploadModal = false;
                this.currentSubChapterId = null;
                this.fileType = 'pdf';
            }
        }
    }
</script>
@endpush
@endsection
