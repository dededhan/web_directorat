@extends('subdirektorat-inovasi.dosen.index')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <header class="mb-10">
            <nav class="text-sm text-gray-500 mb-3" aria-label="Breadcrumb">
                <ol class="list-none p-0 inline-flex items-center space-x-2">
                    <li><a href="{{ route('subdirektorat-inovasi.dosen.dashboard') }}"
                            class="hover:text-teal-600 transition-colors duration-200">Home</a></li>
                    <li><i class='bx bx-chevron-right text-base text-gray-400'></i></li>
                    <li><a href="{{ route('subdirektorat-inovasi.dosen.presenting.manajemen') }}"
                            class="hover:text-teal-600 transition-colors duration-200">Presenting</a></li>
                    <li><i class='bx bx-chevron-right text-base text-gray-400'></i></li>
                    <li class="font-medium text-gray-800">Formulir Laporan Akhir</li>
                </ol>
            </nav>
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl lg:text-3xl font-bold text-gray-800">Formulir Laporan Akhir</h1>
                    <p class="mt-2 text-gray-600 text-base">Lengkapi dokumen laporan akhir untuk pengajuan yang telah disetujui</p>
                </div>
            </div>
        </header>

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

        <form action="{{ $submission ? route('subdirektorat-inovasi.dosen.presenting.submission.update', $report->id) : route('subdirektorat-inovasi.dosen.presenting.submission.store', $report->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if($submission)
                @method('PUT')
            @endif
            
            {{-- Informasi Pengajuan --}}
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden mb-6">
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 lg:px-8 py-6">
                    <div class="flex items-center text-white">
                        <i class='bx bx-info-circle text-2xl mr-3'></i>
                        <h2 class="text-xl lg:text-2xl font-bold">Informasi Pengajuan</h2>
                    </div>
                </div>

                <div class="p-6 lg:p-8 space-y-4 bg-blue-50">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-1">Nama Conference</label>
                            <p class="text-gray-800 font-medium">{{ $report->nama_conference }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-1">Judul Artikel</label>
                            <p class="text-gray-800 font-medium">{{ $report->judul_artikel }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Dokumen Laporan Akhir --}}
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden mb-6">
                <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 lg:px-8 py-6">
                    <div class="flex items-center text-white">
                        <i class='bx bx-file text-2xl mr-3'></i>
                        <h2 class="text-xl lg:text-2xl font-bold">Dokumen Laporan Akhir</h2>
                    </div>
                </div>

                <div class="p-6 lg:p-8 space-y-6">
                    <div>
                        <label for="bukti_perjalanan" class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                            <i class='bx bx-trip text-blue-500 mr-2'></i>
                            Bukti Perjalanan <span class="text-red-500 ml-1">*</span>
                        </label>
                        @if($submission && $submission->bukti_perjalanan_path)
                            <div class="mb-2 p-2 bg-green-50 border border-green-200 rounded-lg text-sm">
                                <a href="{{ asset('storage/' . $submission->bukti_perjalanan_path) }}" target="_blank" class="text-green-700 hover:underline flex items-center">
                                    <i class='bx bx-file-blank mr-2'></i>
                                    Lihat file yang sudah diunggah
                                </a>
                            </div>
                        @endif
                        <input type="file" name="bukti_perjalanan" id="bukti_perjalanan" {{ !$submission ? 'required' : '' }} accept=".pdf"
                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-teal-500 focus:ring-2 focus:ring-teal-200 transition-all duration-200 text-gray-900 shadow-sm">
                        <p class="text-xs text-gray-500 mt-1">Format: PDF (Max: 10MB)</p>
                        @error('bukti_perjalanan')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="sertifikat_presenter" class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                            <i class='bx bx-award text-yellow-500 mr-2'></i>
                            Sertifikat Presenter <span class="text-red-500 ml-1">*</span>
                        </label>
                        @if($submission && $submission->sertifikat_presenter_path)
                            <div class="mb-2 p-2 bg-green-50 border border-green-200 rounded-lg text-sm">
                                <a href="{{ asset('storage/' . $submission->sertifikat_presenter_path) }}" target="_blank" class="text-green-700 hover:underline flex items-center">
                                    <i class='bx bx-file-blank mr-2'></i>
                                    Lihat file yang sudah diunggah
                                </a>
                            </div>
                        @endif
                        <input type="file" name="sertifikat_presenter" id="sertifikat_presenter" {{ !$submission ? 'required' : '' }} accept=".pdf"
                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-teal-500 focus:ring-2 focus:ring-teal-200 transition-all duration-200 text-gray-900 shadow-sm">
                        <p class="text-xs text-gray-500 mt-1">Format: PDF (Max: 10MB)</p>
                        @error('sertifikat_presenter')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="ppt" class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                            <i class='bx bx-slideshow text-orange-500 mr-2'></i>
                            PPT Presentasi <span class="text-red-500 ml-1">*</span>
                        </label>
                        @if($submission && $submission->ppt_path)
                            <div class="mb-2 p-2 bg-green-50 border border-green-200 rounded-lg text-sm">
                                <a href="{{ asset('storage/' . $submission->ppt_path) }}" target="_blank" class="text-green-700 hover:underline flex items-center">
                                    <i class='bx bx-file-blank mr-2'></i>
                                    Lihat file yang sudah diunggah
                                </a>
                            </div>
                        @endif
                        <input type="file" name="ppt" id="ppt" {{ !$submission ? 'required' : '' }} accept=".pdf,.ppt,.pptx"
                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-teal-500 focus:ring-2 focus:ring-teal-200 transition-all duration-200 text-gray-900 shadow-sm">
                        <p class="text-xs text-gray-500 mt-1">Format: PDF, PPT, PPTX (Max: 20MB)</p>
                        @error('ppt')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="bukti_partner_riset" class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                            <i class='bx bx-group text-purple-500 mr-2'></i>
                            Partner untuk Riset Baru <span class="text-xs text-gray-500 ml-1">(Opsional)</span>
                        </label>
                        <p class="text-xs text-gray-600 mb-2">Dibuktikan dengan surat pernyataan atau email kesediaan riset bersama</p>
                        @if($submission && $submission->bukti_partner_riset_path)
                            <div class="mb-2 p-2 bg-green-50 border border-green-200 rounded-lg text-sm">
                                <a href="{{ asset('storage/' . $submission->bukti_partner_riset_path) }}" target="_blank" class="text-green-700 hover:underline flex items-center">
                                    <i class='bx bx-file-blank mr-2'></i>
                                    Lihat file yang sudah diunggah
                                </a>
                            </div>
                        @endif
                        <input type="file" name="bukti_partner_riset" id="bukti_partner_riset" accept=".pdf"
                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-teal-500 focus:ring-2 focus:ring-teal-200 transition-all duration-200 text-gray-900 shadow-sm">
                        <p class="text-xs text-gray-500 mt-1">Format: PDF (Max: 10MB)</p>
                        @error('bukti_partner_riset')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="sp_setneg" class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                            <i class='bx bx-file-blank text-red-500 mr-2'></i>
                            SP Setneg (untuk LN) <span class="text-xs text-gray-500 ml-1">(Opsional)</span>
                        </label>
                        @if($submission && $submission->sp_setneg_path)
                            <div class="mb-2 p-2 bg-green-50 border border-green-200 rounded-lg text-sm">
                                <a href="{{ asset('storage/' . $submission->sp_setneg_path) }}" target="_blank" class="text-green-700 hover:underline flex items-center">
                                    <i class='bx bx-file-blank mr-2'></i>
                                    Lihat file yang sudah diunggah
                                </a>
                            </div>
                        @endif
                        <input type="file" name="sp_setneg" id="sp_setneg" accept=".pdf"
                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-teal-500 focus:ring-2 focus:ring-teal-200 transition-all duration-200 text-gray-900 shadow-sm">
                        <p class="text-xs text-gray-500 mt-1">Format: PDF (Max: 10MB)</p>
                        @error('sp_setneg')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div x-data="qsRespondents()" x-init="init()" class="bg-yellow-50 border border-yellow-200 rounded-2xl p-4 lg:p-6">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-4">
                            <div class="flex items-center text-sm font-bold text-gray-700">
                                <i class='bx bx-world text-indigo-500 mr-2 text-base'></i>
                                Responden Internasional QS
                                <span class="text-xs text-gray-500 ml-2">(Minimal 1)</span>
                            </div>
                            <button type="button" @click="addRespondent()"
                                    class="inline-flex items-center px-4 py-2 bg-amber-500 text-white text-xs font-semibold rounded-xl hover:bg-amber-600 transition-all duration-200 shadow">
                                <i class='bx bx-plus-circle mr-2 text-sm'></i>
                                Tambah Responden
                            </button>
                        </div>

                        <div class="space-y-3">
                            <template x-for="(respondent, index) in respondents" :key="index">
                                <div class="flex items-center gap-3 bg-white border border-yellow-200 rounded-xl px-4 py-3">
                                    <div class="flex items-center text-amber-500">
                                        <i class='bx bx-user-circle text-xl'></i>
                                    </div>
                                    <input type="text" name="responden_internasional_qs[]"
                                           x-model="respondents[index]"
                                           class="flex-1 border-0 focus:ring-0 text-sm text-gray-800 placeholder-gray-400"
                                           placeholder="Nama Lengkap Responden" autocomplete="off">
                                    <button type="button" @click="removeRespondent(index)"
                                            :class="respondents.length > 1 ? 'text-red-500 hover:text-red-600' : 'text-gray-300 cursor-not-allowed'"
                                            :disabled="respondents.length <= 1">
                                        <i class='bx bx-trash text-lg'></i>
                                    </button>
                                </div>
                            </template>
                        </div>

                        <p class="text-xs text-gray-500 mt-3">Masukkan nama lengkap minimal satu responden QS internasional.</p>
                        @error('responden_internasional_qs')<p class="text-red-500 text-xs mt-2">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end space-x-3">
                <a href="{{ route('subdirektorat-inovasi.dosen.presenting.manajemen') }}" 
                   class="px-6 py-2.5 bg-gray-200 text-gray-800 font-semibold rounded-xl hover:bg-gray-300 transition-all duration-200">
                    Batal
                </a>
                <button type="submit" 
                        class="inline-flex items-center px-6 py-2.5 bg-gradient-to-r from-teal-500 to-teal-600 text-white font-semibold rounded-xl hover:from-teal-600 hover:to-teal-700 transform hover:scale-105 transition-all duration-200 shadow-md">
                    <i class='bx bx-save text-lg mr-2'></i> {{ $submission ? 'Update' : 'Simpan' }} Laporan Akhir
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function qsRespondents() {
        return {
            respondents: @json(old('responden_internasional_qs', $submission ? $submission->responden_internasional_qs ?? [] : [])),
            init() {
                if (!Array.isArray(this.respondents)) {
                    this.respondents = [];
                }

                this.respondents = this.respondents.map(value => value ?? '').filter(value => value !== '');

                if (this.respondents.length === 0) {
                    this.respondents = [''];
                }
            },
            addRespondent() {
                this.respondents.push('');
            },
            removeRespondent(index) {
                if (this.respondents.length > 1) {
                    this.respondents.splice(index, 1);
                }
            }
        };
    }
</script>
@endsection
