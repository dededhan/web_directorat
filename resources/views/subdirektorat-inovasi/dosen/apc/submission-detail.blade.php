@extends('admin_equity.index')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        {{-- Breadcrumb dan Header --}}
        <header class="mb-10">
            <nav class="text-sm text-gray-500 mb-3" aria-label="Breadcrumb">
                <ol class="list-none p-0 inline-flex items-center space-x-2">
                    <li><a href="{{ route('admin_equity.dashboard') }}" 
                           class="hover:text-slate-600 transition-colors duration-200">Dashboard</a></li>
                    <li><i class='bx bx-chevron-right text-base text-gray-400'></i></li>
                    <li><a href="{{ route('admin_equity.apc.index') }}" 
                           class="hover:text-slate-600 transition-colors duration-200">Manajemen Sesi APC</a></li>
                    <li><i class='bx bx-chevron-right text-base text-gray-400'></i></li>
                    <li><a href="{{ route('admin_equity.apc.show', $submission->session_id) }}" 
                           class="hover:text-slate-600 transition-colors duration-200">Detail Sesi</a></li>
                    <li><i class='bx bx-chevron-right text-base text-gray-400'></i></li>
                    <li class="font-medium text-gray-800">Detail Pengajuan</li>
                </ol>
            </nav>
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl lg:text-3xl font-semibold text-gray-800">Detail Pengajuan Jurnal</h1>
                    <p class="mt-2 text-gray-600 text-base">Verifikasi kelengkapan data dan dokumen pengajuan.</p>
                </div>
                <div class="flex-shrink-0">
                    <div class="bg-slate-100 px-4 py-2 rounded-lg border border-slate-200">
                        <p class="text-xs font-medium text-slate-600 uppercase tracking-wide">Status Saat Ini</p>
                        <p class="text-sm font-medium text-slate-700 capitalize">{{ $submission->status ?? 'Diajukan' }}</p>
                    </div>
                </div>
            </div>
        </header>

        {{-- Main Content --}}
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            
            {{-- Header Card --}}
            <div class="bg-slate-100 px-6 lg:px-8 py-6 border-b border-slate-200">
                <div class="flex items-center">
                    <i class='bx bx-file-blank text-2xl mr-3 text-slate-600'></i>
                    <h2 class="text-xl lg:text-2xl font-semibold text-slate-800">Informasi Pengajuan</h2>
                </div>
            </div>

            <div class="p-6 lg:p-8 space-y-8">
                
                {{-- Basic Information --}}
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div class="lg:col-span-2">
                        <label class="block text-xs font-medium uppercase text-gray-500 mb-2 flex items-center">
                            <i class='bx bx-file-blank text-green-500 mr-2'></i>
                            Judul Artikel
                        </label>
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                            <p class="text-gray-800 font-medium leading-relaxed">{{ $submission->judul_artikel }}</p>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-medium uppercase text-gray-500 mb-2 flex items-center">
                            <i class='bx bx-book-content text-blue-500 mr-2'></i>
                            Nama Jurnal (Q1)
                        </label>
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                            <p class="text-gray-800 font-medium">{{ $submission->nama_jurnal }}</p>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-medium uppercase text-gray-500 mb-2 flex items-center">
                            <i class='bx bx-user text-indigo-500 mr-2'></i>
                            Penulis
                        </label>
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                            <p class="text-gray-800 font-medium">{{ $submission->nama_penulis }}</p>
                        </div>
                    </div>

                    <div class="lg:col-span-2">
                        <label class="block text-xs font-medium uppercase text-gray-500 mb-2 flex items-center">
                            <i class='bx bx-link text-purple-500 mr-2'></i>
                            Link ScimagoJR
                        </label>
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                            <a href="{{ $submission->link_scimagojr }}" 
                               target="_blank" 
                               class="text-blue-600 hover:text-blue-800 hover:underline break-all font-medium">
                                {{ $submission->link_scimagojr }}
                            </a>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-medium uppercase text-gray-500 mb-2 flex items-center">
                            <i class='bx bx-bookmark text-orange-500 mr-2'></i>
                            Volume & Issue
                        </label>
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                            <p class="text-gray-800 font-medium">Volume {{ $submission->volume }}, Issue {{ $submission->issue }}</p>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-medium uppercase text-gray-500 mb-2 flex items-center">
                            <i class='bx bx-money text-green-500 mr-2'></i>
                            Biaya Publikasi Diajukan
                        </label>
                        <div class="bg-emerald-50 border border-emerald-200 rounded-lg p-4">
                            <p class="text-lg font-semibold text-emerald-700">
                                Rp {{ number_format($submission->biaya_publikasi, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Documents Section --}}
                <div class="border-t border-gray-200 pt-8">
                    <h3 class="text-lg font-semibold text-gray-800 mb-6 flex items-center">
                        <i class='bx bx-cloud-download text-blue-500 mr-3 text-xl'></i>
                        Dokumen Pendukung
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <a href="#" 
                           class="flex items-center p-4 bg-red-50 border border-red-200 rounded-lg hover:bg-red-100 transition-colors group">
                            <div class="flex-shrink-0 mr-3">
                                <i class='bx bx-file-pdf text-red-500 text-2xl group-hover:scale-110 transition-transform'></i>
                            </div>
                            <div class="min-w-0">
                                <p class="font-medium text-gray-800 text-sm">Artikel</p>
                                <p class="text-xs text-gray-500 truncate">Artikel.pdf</p>
                            </div>
                        </a>
                        
                        <a href="#" 
                           class="flex items-center p-4 bg-yellow-50 border border-yellow-200 rounded-lg hover:bg-yellow-100 transition-colors group">
                            <div class="flex-shrink-0 mr-3">
                                <i class='bx bx-receipt text-yellow-600 text-2xl group-hover:scale-110 transition-transform'></i>
                            </div>
                            <div class="min-w-0">
                                <p class="font-medium text-gray-800 text-sm">Bukti Invoice</p>
                                <p class="text-xs text-gray-500 truncate">Bukti_Invoice.jpg</p>
                            </div>
                        </a>
                        
                        <a href="#" 
                           class="flex items-center p-4 bg-blue-50 border border-blue-200 rounded-lg hover:bg-blue-100 transition-colors group">
                            <div class="flex-shrink-0 mr-3">
                                <i class='bx bx-check-shield text-blue-500 text-2xl group-hover:scale-110 transition-transform'></i>
                            </div>
                            <div class="min-w-0">
                                <p class="font-medium text-gray-800 text-sm">Bukti Proses</p>
                                <p class="text-xs text-gray-500 truncate">Submission_Proses.pdf</p>
                            </div>
                        </a>
                    </div>
                </div>

                {{-- Additional Info Section --}}
                <div class="border-t border-gray-200 pt-8">
                    <h3 class="text-lg font-semibold text-gray-800 mb-6 flex items-center">
                        <i class='bx bx-info-circle text-slate-500 mr-3 text-xl'></i>
                        Informasi Tambahan
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-2">Tanggal Pengajuan</p>
                            <p class="text-gray-800 font-medium">{{ $submission->created_at ? $submission->created_at->format('d M Y, H:i') : 'Tidak tersedia' }}</p>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-2">Terakhir Diubah</p>
                            <p class="text-gray-800 font-medium">{{ $submission->updated_at ? $submission->updated_at->format('d M Y, H:i') : 'Tidak tersedia' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="bg-gray-50 px-6 lg:px-8 py-6 border-t border-gray-200">
                <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                    <div class="text-sm text-gray-600">
                        <i class='bx bx-info-circle mr-1'></i>
                        Pilih aksi yang sesuai berdasarkan verifikasi dokumen dan data pengajuan
                    </div>
                    <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
                        <form action="#" method="POST" class="flex-1 sm:flex-none">
                            @csrf
                            <input type="hidden" name="status" value="verifikasi">
                            <button type="submit" 
                                    class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 bg-amber-500 text-white font-medium rounded-lg hover:bg-amber-600 focus:ring-2 focus:ring-amber-300 transition-all duration-200">
                                <i class='bx bx-search-alt mr-2'></i>
                                Ubah ke Verifikasi
                            </button>
                        </form>
                        <form action="#" method="POST" class="flex-1 sm:flex-none">
                            @csrf
                            <input type="hidden" name="status" value="disetujui">
                            <button type="submit" 
                                    class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 bg-emerald-600 text-white font-medium rounded-lg hover:bg-emerald-700 focus:ring-2 focus:ring-emerald-300 transition-all duration-200">
                                <i class='bx bx-check-circle mr-2'></i>
                                Setujui Pengajuan
                            </button>
                        </form>
                    </div>
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
        box-shadow: 0 0 0 3px rgba(148, 163, 184, 0.1);
    }

    .bg-white:hover {
        box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -1px rgb(0 0 0 / 0.06);
    }

    * {
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    }

    .group:hover i {
        animation: gentle-bounce 0.6s ease-in-out;
    }

    @keyframes gentle-bounce {
        0%, 20%, 50%, 80%, 100% {
            transform: translateY(0) scale(1);
        }
        40% {
            transform: translateY(-3px) scale(1.05);
        }
        60% {
            transform: translateY(-1px) scale(1.02);
        }
    }

    @media (max-width: 640px) {
        .container {
            padding-left: 1rem;
            padding-right: 1rem;
        }
        
        .grid-cols-1.sm\\:grid-cols-3 {
            grid-template-columns: 1fr;
        }
        
        .grid-cols-1.sm\\:grid-cols-2 {
            grid-template-columns: 1fr;
        }
    }

    .break-all {
        word-break: break-all;
        overflow-wrap: anywhere;
    }
</style>
@endpush