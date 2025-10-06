@extends('admin_equity.index')

@php
if (!function_exists('getStatusInfoAdmin')) {
    function getStatusInfoAdmin($status) {
        switch ($status) {
            case 'diajukan': return ['color' => 'blue', 'icon' => 'bx-info-circle', 'text' => 'Diajukan'];
            case 'diverifikasi': return ['color' => 'yellow', 'icon' => 'bx-search-alt', 'text' => 'Diverifikasi'];
            case 'disetujui': return ['color' => 'green', 'icon' => 'bx-check-circle', 'text' => 'Disetujui'];
            case 'ditolak': return ['color' => 'red', 'icon' => 'bx-x-circle', 'text' => 'Ditolak'];
            default: return ['color' => 'gray', 'icon' => 'bx-question-mark', 'text' => 'Unknown'];
        }
    }
}
@endphp

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100" 
     x-data="{ showStatusModal: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        {{-- Breadcrumb dan Header --}}
        <header class="mb-10">
            <nav class="text-sm text-gray-500 mb-3" aria-label="Breadcrumb">
                <ol class="list-none p-0 inline-flex items-center space-x-2">
                    <li><a href="{{ route('admin_equity.dashboard') }}"
                            class="hover:text-teal-600 transition-colors duration-200">Dashboard</a></li>
                    <li><i class='bx bx-chevron-right text-base text-gray-400'></i></li>
                    <li><a href="{{ route('admin_equity.presenting.index') }}"
                            class="hover:text-teal-600 transition-colors duration-200">Manajemen Sesi Presenting</a></li>
                    <li><i class='bx bx-chevron-right text-base text-gray-400'></i></li>
                    <li><a href="{{ route('admin_equity.presenting.show', $report->session->id) }}"
                            class="hover:text-teal-600 transition-colors duration-200">Detail Sesi</a></li>
                    <li><i class='bx bx-chevron-right text-base text-gray-400'></i></li>
                    <li class="font-medium text-gray-800">Detail Laporan</li>
                </ol>
            </nav>
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl lg:text-3xl font-bold text-gray-800">Detail Laporan Presenting</h1>
                    <p class="mt-2 text-gray-600 text-base">Verifikasi kelengkapan data dan dokumen laporan dari <strong class="text-gray-800">{{ $report->user->name }}</strong>.</p>
                </div>
                <div class="flex-shrink-0">
                    <button @click="showStatusModal = true"
                        class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-teal-500 to-teal-600 text-white font-semibold rounded-xl hover:from-teal-600 hover:to-teal-700 transform hover:scale-105 transition-all duration-200 shadow-md hover:shadow-lg">
                        <i class='bx bx-cog mr-2 text-lg'></i>
                        Ubah Status
                    </button>
                </div>
            </div>
        </header>

        {{-- Alert Messages --}}
        @if (session('success'))
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
        
        @if (session('error'))
            <div class="mb-6 bg-red-50 border-l-4 border-red-400 p-4 rounded-lg shadow-sm" role="alert">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <i class='bx bx-error-circle text-red-400 text-xl'></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-bold text-red-800">Gagal</h3>
                        <p class="text-sm text-red-700 mt-1">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
        @endif

        {{-- Main Content Card --}}
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            
            {{-- Header Card --}}
            <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 lg:px-8 py-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 text-white">
                    <div>
                        <h2 class="text-xl lg:text-2xl font-bold flex items-center">
                            <i class='bx bx-slideshow mr-3 text-2xl'></i>
                            Detail Laporan Presenting
                        </h2>
                        <p class="mt-2 text-teal-100">Informasi lengkap laporan presenting conference</p>
                    </div>
                    <div class="flex-shrink-0">
                        @php $statusInfo = getStatusInfoAdmin($report->status); @endphp
                        <div class="bg-{{$statusInfo['color']}}-100 text-{{$statusInfo['color']}}-800 px-4 py-2.5 rounded-xl border-2 border-{{$statusInfo['color']}}-200">
                            <p class="text-xs font-bold uppercase tracking-wide">Status Saat Ini</p>
                            <p class="text-sm font-semibold flex items-center">
                                <i class='bx {{$statusInfo['icon']}} mr-1'></i>
                                {{ $statusInfo['text'] }}
                            </p>
                            @if(!empty($report->status_note))
                                <p class="mt-3 text-xs text-gray-700 bg-white bg-opacity-80 border border-{{$statusInfo['color']}}-200 rounded-lg px-3 py-2">
                                    {{ $report->status_note }}
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Content --}}
            <div class="p-6 lg:p-8 space-y-8">
                
                {{-- Basic Information --}}
                <div>
                    <h4 class="text-lg font-bold text-gray-800 mb-4 flex items-center border-b-2 border-gray-200 pb-2">
                        <i class='bx bx-info-circle text-teal-500 mr-2'></i>
                        Informasi Conference
                    </h4>
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 text-sm">
                        <div class="lg:col-span-2">
                            <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Nama Conference</label>
                            <p class="text-gray-800 font-semibold leading-relaxed">{{ $report->nama_conference }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Penyelenggaraan Ke-</label>
                            <p class="text-gray-800 font-medium">{{ $report->penyelenggaraan_ke }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Lembaga Penyelenggara</label>
                            <p class="text-gray-800 font-medium">{{ $report->lembaga_penyelenggara }}</p>
                        </div>
                        <div class="lg:col-span-2">
                            <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Link Website Conference</label>
                            <a href="{{ $report->link_website }}" 
                               target="_blank"
                               class="text-teal-600 hover:text-teal-800 hover:underline break-all text-sm">{{ $report->link_website }}</a>
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Tempat Pelaksanaan</label>
                            <p class="text-gray-800">{{ $report->tempat_pelaksanaan }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Negara</label>
                            <p class="text-gray-800">{{ $report->negara_pelaksanaan }}</p>
                        </div>
                        <div class="lg:col-span-2">
                            <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Waktu Pelaksanaan</label>
                            <p class="text-gray-800">
                                {{ \Carbon\Carbon::parse($report->waktu_pelaksanaan_awal)->format('d F Y') }} 
                                s/d 
                                {{ \Carbon\Carbon::parse($report->waktu_pelaksanaan_akhir)->format('d F Y') }}
                            </p>
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Dosen Pengusul</label>
                            <p class="text-gray-800">{{ $report->user->name }}</p>
                        </div>
                    </div>
                </div>

                {{-- Article Information --}}
                <div class="border-t-2 border-gray-100 pt-6">
                    <h4 class="text-lg font-bold text-gray-800 mb-4 flex items-center border-b-2 border-gray-200 pb-2">
                        <i class='bx bx-book-open text-purple-500 mr-2'></i>
                        Informasi Artikel & SDG
                    </h4>
                    <div class="grid grid-cols-1 gap-6 text-sm">
                        <div>
                            <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Judul Artikel</label>
                            <p class="text-gray-800 leading-relaxed">{{ $report->judul_artikel }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase text-gray-500 mb-2">SDG Terkait</label>
                            <div class="flex flex-wrap gap-2">
                                @php
                                    $sdgs = is_string($report->sdg_terkait) ? json_decode($report->sdg_terkait, true) : $report->sdg_terkait;
                                @endphp
                                @foreach($sdgs as $sdg)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800 border border-green-200">
                                        {{ $sdg }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Keywords SDG</label>
                            @php
                                $keywordsRaw = is_string($report->keywords_sdg) ? json_decode($report->keywords_sdg, true) : $report->keywords_sdg;
                                $sdgKeywordConfig = config('sdg.keywords', []);
                                $groupedKeywords = [];

                                if (is_array($keywordsRaw)) {
                                    foreach ($keywordsRaw as $keyword) {
                                        $assigned = false;
                                        foreach ($sdgKeywordConfig as $sdg => $keywordList) {
                                            if (in_array($keyword, $keywordList, true)) {
                                                $groupedKeywords[$sdg][] = $keyword;
                                                $assigned = true;
                                                break;
                                            }
                                        }
                                        if (! $assigned) {
                                            $groupedKeywords['Lainnya'][] = $keyword;
                                        }
                                    }
                                }
                            @endphp

                            @if(empty($groupedKeywords))
                                <p class="text-sm text-gray-500">-</p>
                            @else
                                <div class="space-y-3">
                                    @foreach($groupedKeywords as $sdg => $sdgKeywords)
                                        <div>
                                            <h5 class="text-xs font-semibold text-teal-700 mb-2">{{ $sdg }}</h5>
                                            <div class="flex flex-wrap gap-2">
                                                @foreach($sdgKeywords as $keyword)
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs bg-orange-100 text-orange-800 border border-orange-200">
                                                        {{ $keyword }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Documents Section --}}
                <div class="border-t-2 border-gray-100 pt-6">
                    <h4 class="text-lg font-bold text-gray-800 mb-4 flex items-center border-b-2 border-gray-200 pb-2">
                        <i class='bx bx-cloud-download text-blue-500 mr-2'></i>
                        Dokumen Pendukung
                    </h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        <a href="{{ asset('storage/' . $report->bukti_pendaftaran_path) }}" 
                           target="_blank"
                           class="flex items-center p-4 bg-gradient-to-br from-blue-50 to-blue-100 border-2 border-blue-200 rounded-xl hover:from-blue-100 hover:to-blue-200 transition-all duration-200 group">
                            <i class='bx bx-file-blank text-blue-500 text-2xl mr-3 group-hover:scale-110 transition-transform'></i>
                            <div>
                                <p class="font-semibold text-gray-800 text-sm">Bukti Pendaftaran</p>
                                <p class="text-xs text-gray-500">File PDF</p>
                            </div>
                        </a>
                        <a href="{{ asset('storage/' . $report->bukti_loa_path) }}" 
                           target="_blank"
                           class="flex items-center p-4 bg-gradient-to-br from-purple-50 to-purple-100 border-2 border-purple-200 rounded-xl hover:from-purple-100 hover:to-purple-200 transition-all duration-200 group">
                            <i class='bx bx-envelope text-purple-500 text-2xl mr-3 group-hover:scale-110 transition-transform'></i>
                            <div>
                                <p class="font-semibold text-gray-800 text-sm">Bukti LoA</p>
                                <p class="text-xs text-gray-500">Letter of Acceptance</p>
                            </div>
                        </a>
                        <a href="{{ asset('storage/' . $report->rencana_anggaran) }}" 
                           target="_blank"
                           class="flex items-center p-4 bg-gradient-to-br from-green-50 to-green-100 border-2 border-green-200 rounded-xl hover:from-green-100 hover:to-green-200 transition-all duration-200 group">
                            <i class='bx bx-dollar-circle text-green-500 text-2xl mr-3 group-hover:scale-110 transition-transform'></i>
                            <div>
                                <p class="font-semibold text-gray-800 text-sm">Rencana Anggaran</p>
                                <p class="text-xs text-gray-500">Mengacu SBM</p>
                            </div>
                        </a>
                    </div>
                </div>

                {{-- Final Report Section (if approved and submitted) --}}
                @if($report->status === 'disetujui' && $report->submission)
                <div class="border-t-2 border-gray-100 pt-6">
                    <h4 class="text-lg font-bold text-gray-800 mb-4 flex items-center border-b-2 border-gray-200 pb-2">
                        <i class='bx bx-file-check text-green-500 mr-2'></i>
                        Dokumen Laporan Akhir
                    </h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        @if($report->submission->bukti_perjalanan_path)
                        <a href="{{ asset('storage/' . $report->submission->bukti_perjalanan_path) }}" 
                           target="_blank"
                           class="flex items-center p-4 bg-gradient-to-br from-blue-50 to-blue-100 border-2 border-blue-200 rounded-xl hover:from-blue-100 hover:to-blue-200 transition-all duration-200 group">
                            <i class='bx bx-trip text-blue-500 text-2xl mr-3 group-hover:scale-110 transition-transform'></i>
                            <div>
                                <p class="font-semibold text-gray-800 text-sm">Bukti Perjalanan</p>
                                <p class="text-xs text-gray-500">File PDF</p>
                            </div>
                        </a>
                        @endif
                        
                        @if($report->submission->sertifikat_presenter_path)
                        <a href="{{ asset('storage/' . $report->submission->sertifikat_presenter_path) }}" 
                           target="_blank"
                           class="flex items-center p-4 bg-gradient-to-br from-yellow-50 to-yellow-100 border-2 border-yellow-200 rounded-xl hover:from-yellow-100 hover:to-yellow-200 transition-all duration-200 group">
                            <i class='bx bx-award text-yellow-600 text-2xl mr-3 group-hover:scale-110 transition-transform'></i>
                            <div>
                                <p class="font-semibold text-gray-800 text-sm">Sertifikat Presenter</p>
                                <p class="text-xs text-gray-500">File PDF</p>
                            </div>
                        </a>
                        @endif

                        @if($report->submission->ppt_path)
                        <a href="{{ asset('storage/' . $report->submission->ppt_path) }}" 
                           target="_blank"
                           class="flex items-center p-4 bg-gradient-to-br from-orange-50 to-orange-100 border-2 border-orange-200 rounded-xl hover:from-orange-100 hover:to-orange-200 transition-all duration-200 group">
                            <i class='bx bx-slideshow text-orange-500 text-2xl mr-3 group-hover:scale-110 transition-transform'></i>
                            <div>
                                <p class="font-semibold text-gray-800 text-sm">PPT Presentasi</p>
                                <p class="text-xs text-gray-500">File Presentasi</p>
                            </div>
                        </a>
                        @endif

                        @if($report->submission->bukti_partner_riset_path)
                        <a href="{{ asset('storage/' . $report->submission->bukti_partner_riset_path) }}" 
                           target="_blank"
                           class="flex items-center p-4 bg-gradient-to-br from-purple-50 to-purple-100 border-2 border-purple-200 rounded-xl hover:from-purple-100 hover:to-purple-200 transition-all duration-200 group">
                            <i class='bx bx-group text-purple-500 text-2xl mr-3 group-hover:scale-110 transition-transform'></i>
                            <div>
                                <p class="font-semibold text-gray-800 text-sm">Partner Riset</p>
                                <p class="text-xs text-gray-500">Opsional</p>
                            </div>
                        </a>
                        @endif

                        @if($report->submission->sp_setneg_path)
                        <a href="{{ asset('storage/' . $report->submission->sp_setneg_path) }}" 
                           target="_blank"
                           class="flex items-center p-4 bg-gradient-to-br from-red-50 to-red-100 border-2 border-red-200 rounded-xl hover:from-red-100 hover:to-red-200 transition-all duration-200 group">
                            <i class='bx bx-file-blank text-red-500 text-2xl mr-3 group-hover:scale-110 transition-transform'></i>
                            <div>
                                <p class="font-semibold text-gray-800 text-sm">SP Setneg</p>
                                <p class="text-xs text-gray-500">Untuk LN</p>
                            </div>
                        </a>
                        @endif

                        @if(!empty($report->submission->responden_internasional_qs))
                        <div class="p-4 bg-gradient-to-br from-indigo-50 to-indigo-100 border-2 border-indigo-200 rounded-xl">
                            <div class="flex items-center mb-3">
                                <i class='bx bx-world text-indigo-500 text-2xl mr-3'></i>
                                <div>
                                    <p class="font-semibold text-gray-800 text-sm">Responden QS</p>
                                    <p class="text-xs text-gray-500">Internasional</p>
                                </div>
                            </div>
                            <ul class="space-y-2">
                                @foreach($report->submission->responden_internasional_qs as $respondent)
                                    <li class="flex items-center text-sm text-gray-700 bg-white border border-indigo-100 rounded-lg px-3 py-2">
                                        <i class='bx bx-user mr-3 text-indigo-400'></i>
                                        <span class="flex-1">{{ $respondent }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                    </div>
                </div>
                @endif
            </div>
        </div>

        {{-- Back Button --}}
        <div class="mt-6">
            <a href="{{ route('admin_equity.presenting.show', $report->session->id) }}" 
               class="inline-flex items-center px-6 py-3 bg-gray-200 text-gray-800 font-semibold rounded-xl hover:bg-gray-300 transition-all duration-200">
                <i class='bx bx-arrow-back mr-2 text-lg'></i>
                Kembali ke Daftar Laporan
            </a>
        </div>
    </div>

    {{-- Modal Update Status --}}
    <div x-show="showStatusModal" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 overflow-y-auto" 
         style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" @click="showStatusModal = false"></div>

            <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form method="POST" action="{{ route('admin_equity.presenting.report.updateStatus', $report->id) }}">
                    @csrf
                    <div class="bg-white px-6 pt-6 pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                                <h3 class="text-xl font-bold text-gray-900 mb-4">
                                    Ubah Status Laporan
                                </h3>
                                <div class="mt-4">
                                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status Baru</label>
                                    <select name="status" id="status" required
                                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-teal-500 focus:ring-2 focus:ring-teal-200 transition-all">
                                        <option value="diajukan" {{ $report->status === 'diajukan' ? 'selected' : '' }}>Diajukan</option>
                                        <option value="disetujui" {{ $report->status === 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                                        <option value="ditolak" {{ $report->status === 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                    </select>
                                </div>
                                <div class="mt-4">
                                    <label for="catatan" class="block text-sm font-medium text-gray-700 mb-2">Catatan (Opsional)</label>
                                    <textarea name="catatan" id="catatan" rows="3"
                                              class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-teal-500 focus:ring-2 focus:ring-teal-200 transition-all"
                                              placeholder="Tambahkan catatan jika diperlukan...">{{ old('catatan', $report->status_note) }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-6 py-4 sm:flex sm:flex-row-reverse gap-3">
                        <button type="submit"
                                class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-6 py-3 bg-teal-600 text-base font-medium text-white hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 sm:w-auto sm:text-sm">
                            Simpan Perubahan
                        </button>
                        <button type="button" @click="showStatusModal = false"
                                class="mt-3 w-full inline-flex justify-center rounded-xl border-2 border-gray-300 shadow-sm px-6 py-3 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:mt-0 sm:w-auto sm:text-sm">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
