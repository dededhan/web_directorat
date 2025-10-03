@extends('subdirektorat-inovasi.dosen.index')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        {{-- Breadcrumb dan Header --}}
        <header class="mb-10">
            <nav class="text-sm text-gray-500 mb-3" aria-label="Breadcrumb">
                <ol class="list-none p-0 inline-flex items-center space-x-2">
                    <li><a href="{{ route('subdirektorat-inovasi.dosen.dashboard') }}"
                            class="hover:text-teal-600 transition-colors duration-200">Home</a></li>
                    <li><i class='bx bx-chevron-right text-base text-gray-400'></i></li>
                    <li><a href="{{ route('subdirektorat-inovasi.dosen.fee_reviewer.list-sesi') }}"
                            class="hover:text-teal-600 transition-colors duration-200">Fee Reviewer</a></li>
                    <li><i class='bx bx-chevron-right text-base text-gray-400'></i></li>
                    <li class="font-medium text-gray-800">Formulir Pelaporan</li>
                </ol>
            </nav>
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl lg:text-3xl font-bold text-gray-800">Formulir Pelaporan Fee Reviewer</h1>
                    <p class="mt-2 text-gray-600 text-base">Anda mengajukan untuk sesi: <strong class="text-teal-700">{{ $session->nama_sesi }}</strong></p>
                </div>
            </div>
        </header>

        {{-- Alert Messages --}}
        @if (session('error'))
            <div class="mb-6 bg-red-50 border-l-4 border-red-400 p-4 rounded-lg shadow-sm" role="alert">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <i class='bx bx-error-circle text-red-400 text-xl'></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-bold text-red-800">Terjadi Kesalahan</h3>
                        <p class="text-sm text-red-700 mt-1">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-6 bg-red-50 border-l-4 border-red-400 p-4 rounded-lg shadow-sm" role="alert">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <i class='bx bx-error-circle text-red-400 text-xl'></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-bold text-red-800">Terjadi Kesalahan</h3>
                        <div class="mt-2 text-sm text-red-700">
                            <ul class="list-disc pl-5 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- Main Form --}}
        <form action="{{ route('subdirektorat-inovasi.dosen.fee_reviewer.store', $session->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            {{-- Informasi Artikel & Jurnal --}}
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden mb-6">
                <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 lg:px-8 py-6">
                    <div class="flex items-center text-white">
                        <i class='bx bx-file-plus text-2xl mr-3'></i>
                        <h2 class="text-xl lg:text-2xl font-bold">Informasi Artikel & Jurnal</h2>
                    </div>
                </div>

                <div class="p-6 lg:p-8 space-y-6">
                    {{-- Judul Artikel --}}
                    <div>
                        <label for="judul_artikel" class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                            <i class='bx bx-file-blank text-blue-500 mr-2'></i>
                            Judul Artikel yang Direview <span class="text-red-500 ml-1">*</span>
                        </label>
                        <input type="text" 
                               name="judul_artikel" 
                               id="judul_artikel" 
                               required 
                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-teal-500 focus:ring-2 focus:ring-teal-200 transition-all duration-200 text-gray-900 placeholder-gray-400 shadow-sm" 
                               placeholder="Masukkan judul artikel yang Anda review"
                               value="{{ old('judul_artikel') }}">
                        @error('judul_artikel')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Nama Jurnal --}}
                    <div>
                        <label for="nama_jurnal" class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                            <i class='bx bx-book-content text-purple-500 mr-2'></i>
                            Nama Jurnal Tempat Review <span class="text-red-500 ml-1">*</span>
                        </label>
                        <input type="text" 
                               name="nama_jurnal" 
                               id="nama_jurnal" 
                               required 
                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-teal-500 focus:ring-2 focus:ring-teal-200 transition-all duration-200 text-gray-900 placeholder-gray-400 shadow-sm" 
                               placeholder="Masukkan nama jurnal"
                               value="{{ old('nama_jurnal') }}">
                        @error('nama_jurnal')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Link ScimagoJR --}}
                    <div>
                        <label for="link_scimagojr" class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                            <i class='bx bx-link text-green-500 mr-2'></i>
                            Link ScimagoJR <span class="text-red-500 ml-1">*</span>
                        </label>
                        <input type="url" 
                               name="link_scimagojr" 
                               id="link_scimagojr" 
                               required 
                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-teal-500 focus:ring-2 focus:ring-teal-200 transition-all duration-200 text-gray-900 placeholder-gray-400 shadow-sm" 
                               placeholder="https://www.scimagojr.com/..."
                               value="{{ old('link_scimagojr') }}">
                        @error('link_scimagojr')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Tanggal Review --}}
                    <div>
                        <label for="tanggal_review" class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                            <i class='bx bx-calendar text-orange-500 mr-2'></i>
                            Tanggal Review <span class="text-red-500 ml-1">*</span>
                        </label>
                        <input type="date" 
                               name="tanggal_review" 
                               id="tanggal_review" 
                               required 
                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-teal-500 focus:ring-2 focus:ring-teal-200 transition-all duration-200 text-gray-900 shadow-sm" 
                               value="{{ old('tanggal_review') }}">
                        @error('tanggal_review')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                </div>
            </div>

            {{-- Dokumen Pendukung --}}
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden mb-6">
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 lg:px-8 py-6">
                    <div class="flex items-center text-white">
                        <i class='bx bx-file text-2xl mr-3'></i>
                        <h2 class="text-xl lg:text-2xl font-bold">Dokumen Pendukung</h2>
                    </div>
                    <p class="text-blue-100 text-sm mt-2">Format file: PDF, maksimal 10MB per file</p>
                </div>

                <div class="p-6 lg:p-8 space-y-6">
                    {{-- Bukti Undangan --}}
                    <div>
                        <label for="bukti_undangan" class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                            <i class='bx bx-envelope text-blue-500 mr-2'></i>
                            Bukti Surat Undangan Reviewer atau Email dari Editor Jurnal <span class="text-red-500 ml-1">*</span>
                        </label>
                        <input type="file" 
                               name="bukti_undangan" 
                               id="bukti_undangan" 
                               required 
                               accept=".pdf"
                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-teal-500 focus:ring-2 focus:ring-teal-200 transition-all duration-200 text-gray-900 shadow-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100">
                        <p class="text-xs text-gray-500 mt-1">Upload bukti undangan dalam format PDF (max 10MB)</p>
                        @error('bukti_undangan')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Bukti Hasil Review --}}
                    <div>
                        <label for="bukti_hasil_review" class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                            <i class='bx bx-file-find text-purple-500 mr-2'></i>
                            Bukti Hasil Review / Laporan Review (File Review) <span class="text-red-500 ml-1">*</span>
                        </label>
                        <input type="file" 
                               name="bukti_hasil_review" 
                               id="bukti_hasil_review" 
                               required 
                               accept=".pdf"
                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-teal-500 focus:ring-2 focus:ring-teal-200 transition-all duration-200 text-gray-900 shadow-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100">
                        <p class="text-xs text-gray-500 mt-1">Upload file hasil review dalam format PDF (max 10MB)</p>
                        @error('bukti_hasil_review')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Bukti Pengiriman Tepat Waktu --}}
                    <div>
                        <label for="bukti_pengiriman_tepat_waktu" class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                            <i class='bx bx-time text-green-500 mr-2'></i>
                            Bukti Reviewer Mengirimkan Review Sesuai Tenggat Waktu <span class="text-red-500 ml-1">*</span>
                        </label>
                        <input type="file" 
                               name="bukti_pengiriman_tepat_waktu" 
                               id="bukti_pengiriman_tepat_waktu" 
                               required 
                               accept=".pdf"
                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-teal-500 focus:ring-2 focus:ring-teal-200 transition-all duration-200 text-gray-900 shadow-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100">
                        <p class="text-xs text-gray-500 mt-1">Upload bukti pengiriman review tepat waktu dalam format PDF (max 10MB)</p>
                        @error('bukti_pengiriman_tepat_waktu')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Bukti Lain-lain (Optional) --}}
                    <div>
                        <label for="bukti_lain" class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                            <i class='bx bx-folder-plus text-yellow-500 mr-2'></i>
                            Bukti Lain-lain yang Mendukung <span class="text-gray-500 text-xs ml-1">(Opsional)</span>
                        </label>
                        <input type="file" 
                               name="bukti_lain" 
                               id="bukti_lain" 
                               accept=".pdf"
                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-teal-500 focus:ring-2 focus:ring-teal-200 transition-all duration-200 text-gray-900 shadow-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100">
                        <p class="text-xs text-gray-500 mt-1">Screenshot sistem jurnal, konfirmasi dari editor, dll. (max 10MB)</p>
                        @error('bukti_lain')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Surat Pernyataan --}}
                    <div>
                        <label for="surat_pernyataan" class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                            <i class='bx bx-file-doc text-red-500 mr-2'></i>
                            Surat Pernyataan <span class="text-red-500 ml-1">*</span>
                        </label>
                        <input type="file" 
                               name="surat_pernyataan" 
                               id="surat_pernyataan" 
                               required 
                               accept=".pdf"
                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-teal-500 focus:ring-2 focus:ring-teal-200 transition-all duration-200 text-gray-900 shadow-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100">
                        <p class="text-xs text-gray-500 mt-1">Upload surat pernyataan dalam format PDF (max 10MB)</p>
                        @error('surat_pernyataan')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Form Actions --}}
            <div class="flex items-center justify-end gap-4 mt-8">
                <a href="{{ route('subdirektorat-inovasi.dosen.fee_reviewer.list-sesi') }}" 
                   class="px-6 py-3 bg-gray-200 text-gray-800 font-semibold rounded-xl hover:bg-gray-300 transition-all duration-200 shadow-sm">
                    <i class='bx bx-arrow-back mr-2'></i>
                    Batal
                </a>
                <button type="submit" 
                        class="px-6 py-3 bg-gradient-to-r from-teal-500 to-teal-600 text-white font-semibold rounded-xl hover:from-teal-600 hover:to-teal-700 transform hover:scale-105 transition-all duration-200 shadow-md hover:shadow-lg">
                    <i class='bx bx-save mr-2'></i>
                    Ajukan Laporan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection


