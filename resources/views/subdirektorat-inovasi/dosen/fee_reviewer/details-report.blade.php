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
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Breadcrumb and Header --}}
        <header class="mb-8">
            <nav class="text-sm text-gray-500 mb-3" aria-label="Breadcrumb">
                <ol class="list-none p-0 inline-flex items-center space-x-2">
                    <li><a href="{{ route('subdirektorat-inovasi.dosen.dashboard') }}" class="hover:text-teal-600 transition-colors duration-200">Home</a></li>
                    <li><i class='bx bx-chevron-right text-base text-gray-400'></i></li>
                    <li><a href="{{ route('subdirektorat-inovasi.dosen.fee_reviewer.manajemen') }}" class="hover:text-teal-600 transition-colors duration-200">Manajemen Laporan</a></li>
                    <li><i class='bx bx-chevron-right text-base text-gray-400'></i></li>
                    <li class="font-medium text-gray-800">Detail Laporan</li>
                </ol>
            </nav>
            <div class="flex items-center justify-between">
                <h1 class="text-2xl lg:text-3xl font-bold text-gray-800 flex items-center">
                    <i class='bx bx-file-blank text-teal-500 mr-3 text-3xl'></i>
                    Detail Laporan Insentif Reviewer
                </h1>
                <a href="{{ route('subdirektorat-inovasi.dosen.fee_reviewer.manajemen') }}" class="inline-flex items-center px-4 py-2 bg-white border-2 border-gray-200 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition-all shadow-sm">
                    <i class='bx bx-arrow-back mr-2'></i>
                    Kembali
                </a>
            </div>
        </header>

        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="p-6 lg:p-8 space-y-8">
                {{-- Basic Info --}}
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 text-sm">
                    <div class="lg:col-span-2">
                        <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Judul Artikel</label>
                        <p class="text-gray-800 font-semibold leading-relaxed">{{ $report->judul_artikel }}</p>
                    </div>
                    <div class="lg:col-span-2">
                        <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Nama Jurnal</label>
                        <p class="text-gray-800 font-medium">{{ $report->nama_jurnal }}</p>
                    </div>
                    <div class="lg:col-span-2">
                        <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Link ScimagoJR</label>
                        <a href="{{ $report->link_scimagojr }}" target="_blank" class="text-teal-600 hover:text-teal-800 hover:underline break-all text-sm">{{ $report->link_scimagojr }}</a>
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Tanggal Review</label>
                        <p class="text-gray-800">{{ \Carbon\Carbon::parse($report->tanggal_review)->format('d F Y') }}</p>
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Status</label>
                        @php
                            $statusInfo = getStatusInfoDosen($report->status);
                        @endphp
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-{{ $statusInfo['color'] }}-100 text-{{ $statusInfo['color'] }}-800 border-2 border-{{ $statusInfo['color'] }}-200">
                            <i class='bx {{ $statusInfo['icon'] }} mr-1'></i>
                            {{ $statusInfo['text'] }}
                        </span>
                    </div>
                </div>

                {{-- Catatan Admin --}}
                @if(!empty($report->catatan_admin))
                <div class="border-t-2 border-gray-100 pt-6">
                    <h4 class="text-base font-bold text-gray-800 mb-4 flex items-center">
                        <i class='bx bx-message-detail text-blue-500 mr-2 text-xl'></i>
                        Catatan dari Admin
                    </h4>
                    <div class="bg-blue-50 rounded-xl p-4 border border-blue-200">
                        <p class="text-sm text-blue-800 whitespace-pre-wrap">{{ $report->catatan_admin }}</p>
                    </div>
                </div>
                @endif

                {{-- Documents Section --}}
                <div class="border-t-2 border-gray-100 pt-6">
                    <h4 class="text-base font-bold text-gray-800 mb-4 flex items-center">
                        <i class='bx bx-cloud-download text-blue-500 mr-2 text-xl'></i>
                        Dokumen Pendukung
                    </h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        <a href="{{ asset('storage/' . $report->bukti_undangan_path) }}" target="_blank" class="flex items-center p-4 bg-gradient-to-br from-blue-50 to-blue-100 border-2 border-blue-200 rounded-xl hover:from-blue-100 hover:to-blue-200 transition-all duration-200 group">
                            <i class='bx bx-envelope text-blue-500 text-2xl mr-3 group-hover:scale-110 transition-transform'></i>
                            <div>
                                <p class="font-semibold text-gray-800 text-sm">Bukti Undangan</p>
                                <p class="text-xs text-gray-500">Email Editor</p>
                            </div>
                        </a>
                        <a href="{{ asset('storage/' . $report->bukti_hasil_review_path) }}" target="_blank" class="flex items-center p-4 bg-gradient-to-br from-purple-50 to-purple-100 border-2 border-purple-200 rounded-xl hover:from-purple-100 hover:to-purple-200 transition-all duration-200 group">
                            <i class='bx bx-file-find text-purple-500 text-2xl mr-3 group-hover:scale-110 transition-transform'></i>
                            <div>
                                <p class="font-semibold text-gray-800 text-sm">Hasil Review</p>
                                <p class="text-xs text-gray-500">File Review</p>
                            </div>
                        </a>
                        <a href="{{ asset('storage/' . $report->bukti_pengiriman_tepat_waktu_path) }}" target="_blank" class="flex items-center p-4 bg-gradient-to-br from-green-50 to-green-100 border-2 border-green-200 rounded-xl hover:from-green-100 hover:to-green-200 transition-all duration-200 group">
                            <i class='bx bx-time text-green-500 text-2xl mr-3 group-hover:scale-110 transition-transform'></i>
                            <div>
                                <p class="font-semibold text-gray-800 text-sm">Pengiriman Tepat Waktu</p>
                                <p class="text-xs text-gray-500">Bukti Deadline</p>
                            </div>
                        </a>
                        @if($report->bukti_lain_path)
                        <a href="{{ asset('storage/' . $report->bukti_lain_path) }}" target="_blank" class="flex items-center p-4 bg-gradient-to-br from-yellow-50 to-yellow-100 border-2 border-yellow-200 rounded-xl hover:from-yellow-100 hover:to-yellow-200 transition-all duration-200 group">
                            <i class='bx bx-folder-plus text-yellow-600 text-2xl mr-3 group-hover:scale-110 transition-transform'></i>
                            <div>
                                <p class="font-semibold text-gray-800 text-sm">Bukti Lain</p>
                                <p class="text-xs text-gray-500">Dokumen Pendukung</p>
                            </div>
                        </a>
                        @endif
                        <a href="{{ asset('storage/' . $report->surat_pernyataan_path) }}" target="_blank" class="flex items-center p-4 bg-gradient-to-br from-red-50 to-red-100 border-2 border-red-200 rounded-xl hover:from-red-100 hover:to-red-200 transition-all duration-200 group">
                            <i class='bx bx-file-doc text-red-500 text-2xl mr-3 group-hover:scale-110 transition-transform'></i>
                            <div>
                                <p class="font-semibold text-gray-800 text-sm">Surat Pernyataan</p>
                                <p class="text-xs text-gray-500">Dokumen Resmi</p>
                            </div>
                        </a>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>
@endsection
