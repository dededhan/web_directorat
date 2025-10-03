@extends('subdirektorat-inovasi.dosen.index')

@php
if (!function_exists('getStatusInfoDosen')) {
    function getStatusInfoDosen($status) {
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
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Breadcrumb and Header --}}
        <header class="mb-8">
            <nav class="text-sm text-gray-500 mb-3" aria-label="Breadcrumb">
                <ol class="list-none p-0 inline-flex items-center space-x-2">
                    <li><a href="{{ route('subdirektorat-inovasi.dosen.dashboard') }}" class="hover:text-teal-600 transition-colors duration-200">Home</a></li>
                    <li><i class='bx bx-chevron-right text-base text-gray-400'></i></li>
                    <li><a href="{{ route('subdirektorat-inovasi.dosen.presenting.manajemen') }}" class="hover:text-teal-600 transition-colors duration-200">Manajemen Laporan</a></li>
                    <li><i class='bx bx-chevron-right text-base text-gray-400'></i></li>
                    <li class="font-medium text-gray-800">Detail Laporan</li>
                </ol>
            </nav>
            <div class="flex items-center justify-between">
                <h1 class="text-2xl lg:text-3xl font-bold text-gray-800 flex items-center">
                    <i class='bx bx-slideshow text-teal-500 mr-3 text-3xl'></i>
                    Detail Laporan Presenting
                </h1>
                <a href="{{ route('subdirektorat-inovasi.dosen.presenting.manajemen') }}" class="inline-flex items-center px-4 py-2 bg-white border-2 border-gray-200 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition-all shadow-sm">
                    <i class='bx bx-arrow-back mr-2'></i>
                    Kembali
                </a>
            </div>
        </header>

        {{-- Alert for Approved Status --}}
        @if($report->status === 'disetujui' && !$report->submission)
        <div class="mb-6 bg-green-50 border-l-4 border-green-400 p-4 rounded-lg shadow-sm" role="alert">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <i class='bx bx-check-circle text-green-400 text-2xl'></i>
                </div>
                <div class="ml-3 flex-1">
                    <h3 class="text-sm font-bold text-green-800">Pengajuan Anda Telah Disetujui!</h3>
                    <p class="text-sm text-green-700 mt-1">Silakan lengkapi laporan akhir untuk menyelesaikan proses pelaporan.</p>
                    <a href="{{ route('subdirektorat-inovasi.dosen.presenting.submission.form', $report->id) }}" 
                       class="mt-3 inline-flex items-center px-4 py-2 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition-all">
                        <i class='bx bx-file-plus mr-2'></i>
                        Lengkapi Laporan Akhir
                    </a>
                </div>
            </div>
        </div>
        @endif

        @if($report->status === 'disetujui' && $report->submission)
        <div class="mb-6 bg-blue-50 border-l-4 border-blue-400 p-4 rounded-lg shadow-sm" role="alert">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <i class='bx bx-info-circle text-blue-400 text-2xl'></i>
                </div>
                <div class="ml-3 flex-1">
                    <h3 class="text-sm font-bold text-blue-800">Laporan Akhir Sudah Disubmit</h3>
                    <p class="text-sm text-blue-700 mt-1">Anda dapat mengupdate laporan akhir jika diperlukan.</p>
                    <a href="{{ route('subdirektorat-inovasi.dosen.presenting.submission.form', $report->id) }}" 
                       class="mt-3 inline-flex items-center px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-all">
                        <i class='bx bx-edit mr-2'></i>
                        Update Laporan Akhir
                    </a>
                </div>
            </div>
        </div>
        @endif

        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 lg:px-8 py-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 text-white">
                    <div>
                        <h2 class="text-xl font-bold">Informasi Pengajuan</h2>
                        <p class="text-sm text-teal-100 mt-1">{{ $report->session->nama_sesi }}</p>
                    </div>
                    <div class="flex-shrink-0">
                        @php $statusInfo = getStatusInfoDosen($report->status); @endphp
                        <span class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-semibold bg-{{ $statusInfo['color'] }}-100 text-{{ $statusInfo['color'] }}-800 border-2 border-{{ $statusInfo['color'] }}-200">
                            <i class='bx {{ $statusInfo['icon'] }} mr-2'></i>
                            {{ $statusInfo['text'] }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="p-6 lg:p-8 space-y-8">
                
                {{-- Conference Information --}}
                <div>
                    <h4 class="text-lg font-bold text-gray-800 mb-4 flex items-center border-b-2 border-gray-200 pb-2">
                        <i class='bx bx-calendar-event text-teal-500 mr-2'></i>
                        Informasi Conference
                    </h4>
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 text-sm">
                        <div class="lg:col-span-2">
                            <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Nama Conference</label>
                            <p class="text-gray-800 font-semibold">{{ $report->nama_conference }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Penyelenggaraan Ke-</label>
                            <p class="text-gray-800">{{ $report->penyelenggaraan_ke }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Lembaga Penyelenggara</label>
                            <p class="text-gray-800">{{ $report->lembaga_penyelenggara }}</p>
                        </div>
                        <div class="lg:col-span-2">
                            <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Link Website</label>
                            <a href="{{ $report->link_website }}" target="_blank" class="text-teal-600 hover:underline break-all">{{ $report->link_website }}</a>
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Tempat Pelaksanaan</label>
                            <p class="text-gray-800">{{ $report->tempat_pelaksanaan }}, {{ $report->negara_pelaksanaan }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Waktu Pelaksanaan</label>
                            <p class="text-gray-800">
                                {{ \Carbon\Carbon::parse($report->waktu_pelaksanaan_awal)->format('d M Y') }} - 
                                {{ \Carbon\Carbon::parse($report->waktu_pelaksanaan_akhir)->format('d M Y') }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Article & SDG Information --}}
                <div class="border-t-2 border-gray-100 pt-6">
                    <h4 class="text-lg font-bold text-gray-800 mb-4 flex items-center border-b-2 border-gray-200 pb-2">
                        <i class='bx bx-book-open text-purple-500 mr-2'></i>
                        Informasi Artikel & SDG
                    </h4>
                    <div class="space-y-4 text-sm">
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
                            <div class="flex flex-wrap gap-2">
                                @php
                                    $keywords = is_string($report->keywords_sdg) ? json_decode($report->keywords_sdg, true) : $report->keywords_sdg;
                                @endphp
                                @foreach($keywords as $keyword)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs bg-orange-100 text-orange-800 border border-orange-200">
                                        {{ $keyword }}
                                    </span>
                                @endforeach
                            </div>
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
                        <a href="{{ asset('storage/' . $report->bukti_pendaftaran_path) }}" target="_blank" class="flex items-center p-4 bg-gradient-to-br from-blue-50 to-blue-100 border-2 border-blue-200 rounded-xl hover:from-blue-100 hover:to-blue-200 transition-all duration-200 group">
                            <i class='bx bx-file-blank text-blue-500 text-2xl mr-3 group-hover:scale-110 transition-transform'></i>
                            <div>
                                <p class="font-semibold text-gray-800 text-sm">Bukti Pendaftaran</p>
                                <p class="text-xs text-gray-500">File PDF</p>
                            </div>
                        </a>
                        <a href="{{ asset('storage/' . $report->bukti_loa_path) }}" target="_blank" class="flex items-center p-4 bg-gradient-to-br from-purple-50 to-purple-100 border-2 border-purple-200 rounded-xl hover:from-purple-100 hover:to-purple-200 transition-all duration-200 group">
                            <i class='bx bx-envelope text-purple-500 text-2xl mr-3 group-hover:scale-110 transition-transform'></i>
                            <div>
                                <p class="font-semibold text-gray-800 text-sm">Bukti LoA</p>
                                <p class="text-xs text-gray-500">Letter of Acceptance</p>
                            </div>
                        </a>
                        <a href="{{ asset('storage/' . $report->rencana_anggaran) }}" target="_blank" class="flex items-center p-4 bg-gradient-to-br from-green-50 to-green-100 border-2 border-green-200 rounded-xl hover:from-green-100 hover:to-green-200 transition-all duration-200 group">
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
                        <a href="{{ asset('storage/' . $report->submission->bukti_perjalanan_path) }}" target="_blank" class="flex items-center p-4 bg-gradient-to-br from-blue-50 to-blue-100 border-2 border-blue-200 rounded-xl hover:from-blue-100 hover:to-blue-200 transition-all duration-200 group">
                            <i class='bx bx-trip text-blue-500 text-2xl mr-3 group-hover:scale-110 transition-transform'></i>
                            <div>
                                <p class="font-semibold text-gray-800 text-sm">Bukti Perjalanan</p>
                                <p class="text-xs text-gray-500">File PDF</p>
                            </div>
                        </a>
                        @endif
                        
                        @if($report->submission->sertifikat_presenter_path)
                        <a href="{{ asset('storage/' . $report->submission->sertifikat_presenter_path) }}" target="_blank" class="flex items-center p-4 bg-gradient-to-br from-yellow-50 to-yellow-100 border-2 border-yellow-200 rounded-xl hover:from-yellow-100 hover:to-yellow-200 transition-all duration-200 group">
                            <i class='bx bx-award text-yellow-600 text-2xl mr-3 group-hover:scale-110 transition-transform'></i>
                            <div>
                                <p class="font-semibold text-gray-800 text-sm">Sertifikat Presenter</p>
                                <p class="text-xs text-gray-500">File PDF</p>
                            </div>
                        </a>
                        @endif

                        @if($report->submission->ppt_path)
                        <a href="{{ asset('storage/' . $report->submission->ppt_path) }}" target="_blank" class="flex items-center p-4 bg-gradient-to-br from-orange-50 to-orange-100 border-2 border-orange-200 rounded-xl hover:from-orange-100 hover:to-orange-200 transition-all duration-200 group">
                            <i class='bx bx-slideshow text-orange-500 text-2xl mr-3 group-hover:scale-110 transition-transform'></i>
                            <div>
                                <p class="font-semibold text-gray-800 text-sm">PPT Presentasi</p>
                                <p class="text-xs text-gray-500">File Presentasi</p>
                            </div>
                        </a>
                        @endif

                        @if($report->submission->bukti_partner_riset_path)
                        <a href="{{ asset('storage/' . $report->submission->bukti_partner_riset_path) }}" target="_blank" class="flex items-center p-4 bg-gradient-to-br from-purple-50 to-purple-100 border-2 border-purple-200 rounded-xl hover:from-purple-100 hover:to-purple-200 transition-all duration-200 group">
                            <i class='bx bx-group text-purple-500 text-2xl mr-3 group-hover:scale-110 transition-transform'></i>
                            <div>
                                <p class="font-semibold text-gray-800 text-sm">Partner Riset</p>
                                <p class="text-xs text-gray-500">Opsional</p>
                            </div>
                        </a>
                        @endif

                        @if($report->submission->sp_setneg_path)
                        <a href="{{ asset('storage/' . $report->submission->sp_setneg_path) }}" target="_blank" class="flex items-center p-4 bg-gradient-to-br from-red-50 to-red-100 border-2 border-red-200 rounded-xl hover:from-red-100 hover:to-red-200 transition-all duration-200 group">
                            <i class='bx bx-file-blank text-red-500 text-2xl mr-3 group-hover:scale-110 transition-transform'></i>
                            <div>
                                <p class="font-semibold text-gray-800 text-sm">SP Setneg</p>
                                <p class="text-xs text-gray-500">Untuk LN</p>
                            </div>
                        </a>
                        @endif

                        @if($report->submission->responden_internasional_qs_path)
                        <a href="{{ asset('storage/' . $report->submission->responden_internasional_qs_path) }}" target="_blank" class="flex items-center p-4 bg-gradient-to-br from-indigo-50 to-indigo-100 border-2 border-indigo-200 rounded-xl hover:from-indigo-100 hover:to-indigo-200 transition-all duration-200 group">
                            <i class='bx bx-world text-indigo-500 text-2xl mr-3 group-hover:scale-110 transition-transform'></i>
                            <div>
                                <p class="font-semibold text-gray-800 text-sm">Responden QS</p>
                                <p class="text-xs text-gray-500">Internasional</p>
                            </div>
                        </a>
                        @endif
                    </div>
                </div>
                @endif

                {{-- Action Buttons --}}
                @if($report->status === 'diajukan' || $report->status === 'ditolak')
                <div class="border-t-2 border-gray-100 pt-6 flex justify-end space-x-3">
                    <a href="{{ route('subdirektorat-inovasi.dosen.presenting.edit', $report->id) }}" 
                       class="inline-flex items-center px-4 py-2 bg-yellow-500 text-white font-semibold rounded-xl hover:bg-yellow-600 transition-all">
                        <i class='bx bx-edit mr-2'></i>
                        Edit Pengajuan
                    </a>
                    <form action="{{ route('subdirektorat-inovasi.dosen.presenting.destroy', $report->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus laporan ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-500 text-white font-semibold rounded-xl hover:bg-red-600 transition-all">
                            <i class='bx bx-trash mr-2'></i>
                            Hapus
                        </button>
                    </form>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
