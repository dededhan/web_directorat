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
                    <li><a href="{{ route('admin_equity.fee_reviewer.index') }}"
                            class="hover:text-teal-600 transition-colors duration-200">Manajemen Sesi Fee Reviewer</a></li>
                    <li><i class='bx bx-chevron-right text-base text-gray-400'></i></li>
                    <li><a href="{{ route('admin_equity.fee_reviewer.show', $report->session->id) }}"
                            class="hover:text-teal-600 transition-colors duration-200">Detail Sesi</a></li>
                    <li><i class='bx bx-chevron-right text-base text-gray-400'></i></li>
                    <li class="font-medium text-gray-800">Detail Laporan</li>
                </ol>
            </nav>
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl lg:text-3xl font-bold text-gray-800">Detail Laporan</h1>
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
                            <i class='bx bx-file-blank mr-3 text-2xl'></i>
                            Detail Laporan Fee Reviewer
                        </h2>
                        <p class="mt-2 text-teal-100">Informasi lengkap laporan fee reviewer</p>
                    </div>
                    <div class="flex-shrink-0">
                        @php $statusInfo = getStatusInfoAdmin($report->status); @endphp
                        <div class="bg-{{$statusInfo['color']}}-100 text-{{$statusInfo['color']}}-800 px-4 py-2.5 rounded-xl border-2 border-{{$statusInfo['color']}}-200">
                            <p class="text-xs font-bold uppercase tracking-wide">Status Saat Ini</p>
                            <p class="text-sm font-semibold flex items-center">
                                <i class='bx {{$statusInfo['icon']}} mr-1'></i>
                                {{ $statusInfo['text'] }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Content --}}
            <div class="p-6 lg:p-8 space-y-8">

                {{-- Admin Notes --}}
    @if (!empty($report->catatan_admin))
    <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded-lg shadow-sm" role="alert">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <i class='bx bx-message-detail text-blue-400 text-xl'></i>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-bold text-blue-800">Catatan dari Admin</h3>
                <p class="text-sm text-blue-700 mt-1 whitespace-pre-wrap">{{ $report->catatan_admin }}</p>
            </div>
        </div>
    </div>
    @endif
                
                {{-- Basic Information --}}
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
                        <a href="{{ $report->link_scimagojr }}" 
                           target="_blank"
                           class="text-teal-600 hover:text-teal-800 hover:underline break-all text-sm">{{ $report->link_scimagojr }}</a>
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Tanggal Review</label>
                        <p class="text-gray-800">{{ \Carbon\Carbon::parse($report->tanggal_review)->format('d F Y') }}</p>
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Dosen Pengusul</label>
                        <p class="text-gray-800">{{ $report->user->name }}</p>
                    </div>
                </div>

                {{-- Documents Section --}}
                <div class="border-t-2 border-gray-100 pt-6">
                    <h4 class="text-sm font-bold text-gray-800 mb-4 flex items-center">
                        <i class='bx bx-cloud-download text-blue-500 mr-2'></i>
                        Dokumen Pendukung
                    </h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        <a href="{{ asset('storage/' . $report->bukti_undangan_path) }}" 
                           target="_blank"
                           class="flex items-center p-4 bg-gradient-to-br from-blue-50 to-blue-100 border-2 border-blue-200 rounded-xl hover:from-blue-100 hover:to-blue-200 transition-all duration-200 group">
                            <i class='bx bx-envelope text-blue-500 text-2xl mr-3 group-hover:scale-110 transition-transform'></i>
                            <div>
                                <p class="font-semibold text-gray-800 text-sm">Bukti Undangan</p>
                                <p class="text-xs text-gray-500">Email Editor</p>
                            </div>
                        </a>
                        <a href="{{ asset('storage/' . $report->bukti_hasil_review_path) }}" 
                           target="_blank"
                           class="flex items-center p-4 bg-gradient-to-br from-purple-50 to-purple-100 border-2 border-purple-200 rounded-xl hover:from-purple-100 hover:to-purple-200 transition-all duration-200 group">
                            <i class='bx bx-file-find text-purple-500 text-2xl mr-3 group-hover:scale-110 transition-transform'></i>
                            <div>
                                <p class="font-semibold text-gray-800 text-sm">Hasil Review</p>
                                <p class="text-xs text-gray-500">File Review</p>
                            </div>
                        </a>
                        <a href="{{ asset('storage/' . $report->bukti_pengiriman_tepat_waktu_path) }}" 
                           target="_blank"
                           class="flex items-center p-4 bg-gradient-to-br from-green-50 to-green-100 border-2 border-green-200 rounded-xl hover:from-green-100 hover:to-green-200 transition-all duration-200 group">
                            <i class='bx bx-time text-green-500 text-2xl mr-3 group-hover:scale-110 transition-transform'></i>
                            <div>
                                <p class="font-semibold text-gray-800 text-sm">Pengiriman Tepat Waktu</p>
                                <p class="text-xs text-gray-500">Bukti Deadline</p>
                            </div>
                        </a>
                        @if ($report->bukti_lain_path)
                        <a href="{{ asset('storage/' . $report->bukti_lain_path) }}" 
                           target="_blank"
                           class="flex items-center p-4 bg-gradient-to-br from-yellow-50 to-yellow-100 border-2 border-yellow-200 rounded-xl hover:from-yellow-100 hover:to-yellow-200 transition-all duration-200 group">
                            <i class='bx bx-folder-plus text-yellow-600 text-2xl mr-3 group-hover:scale-110 transition-transform'></i>
                            <div>
                                <p class="font-semibold text-gray-800 text-sm">Bukti Lain</p>
                                <p class="text-xs text-gray-500">Dokumen Pendukung</p>
                            </div>
                        </a>
                        @endif
                        <a href="{{ asset('storage/' . $report->surat_pernyataan_path) }}" 
                           target="_blank"
                           class="flex items-center p-4 bg-gradient-to-br from-red-50 to-red-100 border-2 border-red-200 rounded-xl hover:from-red-100 hover:to-red-200 transition-all duration-200 group">
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

        {{-- Status Update Modal --}}
        <div x-show="showStatusModal" 
             x-cloak 
             @keydown.escape.window="showStatusModal = false"
             class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
            <div @click.away="showStatusModal = false" 
                 x-data="{ selectedStatus: '{{ $report->status }}' }"
                 class="bg-white rounded-2xl shadow-2xl w-full max-w-md border border-gray-200">
                
                {{-- Modal Header --}}
                <div class="bg-gradient-to-r from-teal-500 to-teal-600 px-6 py-4 flex items-center justify-between text-white">
                    <div class="flex items-center">
                        <i class='bx bx-cog text-2xl mr-3'></i>
                        <h3 class="text-xl font-bold">Ubah Status Laporan</h3>
                    </div>
                    <button @click="showStatusModal = false" 
                            class="p-2 hover:bg-white hover:bg-opacity-20 rounded-lg transition-colors">
                        <i class='bx bx-x text-xl'></i>
                    </button>
                </div>
                
                {{-- Modal Content --}}
                <div class="p-6">
                    <form action="{{ route('admin_equity.fee_reviewer.report.updateStatus', $report->id) }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label for="status" class="block text-xs font-bold uppercase text-gray-500 mb-2">Pilih Status Baru</label>
                            <select name="status" id="status" 
                                    @change="selectedStatus = $event.target.value"
                                    class="w-full rounded-xl border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 text-sm">
                                <option value="diajukan" @if($report->status == 'diajukan') selected @endif>Diajukan</option>
                                <option value="diverifikasi" @if($report->status == 'diverifikasi') selected @endif>Diverifikasi</option>
                                <option value="disetujui" @if($report->status == 'disetujui') selected @endif>Disetujui</option>
                                <option value="ditolak" @if($report->status == 'ditolak') selected @endif>Ditolak</option>
                            </select>
                        </div>
                        
                        <div>
                            <label for="catatan_admin" class="block text-xs font-bold uppercase text-gray-500 mb-2">Catatan Admin (Opsional)</label>
                            <textarea name="catatan_admin" id="catatan_admin" rows="4" 
                                      class="w-full rounded-xl border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 text-sm" 
                                      placeholder="Tambahkan catatan atau feedback untuk dosen...">{{ old('catatan_admin', $report->catatan_admin) }}</textarea>
                            @error('catatan_admin')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="bg-yellow-50 border-2 border-yellow-200 rounded-xl p-4">
                            <div class="flex items-start">
                                <i class='bx bx-info-circle text-yellow-600 text-xl mr-3 flex-shrink-0 mt-0.5'></i>
                                <div>
                                    <h4 class="text-sm font-semibold text-yellow-800">Perhatian</h4>
                                    <p class="text-xs text-yellow-700 mt-1">Perubahan status akan mempengaruhi proses laporan dan tidak dapat dibatalkan.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex flex-col sm:flex-row gap-3 pt-2">
                            <button type="button" 
                                    @click="showStatusModal = false"
                                    class="flex-1 px-4 py-2.5 bg-gray-200 text-gray-800 font-medium rounded-xl hover:bg-gray-300 transition-colors">
                                Batal
                            </button>
                            <button type="submit" 
                                    class="flex-1 px-4 py-2.5 bg-teal-600 text-white font-medium rounded-xl hover:bg-teal-700 transition-colors">
                                <i class='bx bx-check mr-2'></i>
                                Simpan Status
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    input:focus,
    select:focus,
    button:focus {
        box-shadow: 0 0 0 3px rgba(20, 184, 166, 0.1);
    }

    button:hover {
        transform: translateY(-1px);
    }

    .bg-white:hover {
        box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 10px 10px -5px rgb(0 0 0 / 0.04);
    }

    [x-cloak] { 
        display: none !important; 
    }

    .group:hover i {
        animation: bounce 0.6s ease-in-out;
    }
    
    .whitespace-pre-wrap {
        white-space: pre-wrap;
    }

    @keyframes bounce {
        0%, 20%, 50%, 80%, 100% {
            transform: translateY(0);
        }
        40% {
            transform: translateY(-5px);
        }
        60% {
            transform: translateY(-2px);
        }
    }

    @media (max-width: 640px) {
        .container {
            padding-left: 1rem;
            padding-right: 1rem;
        }
    }
</style>
@endpush
