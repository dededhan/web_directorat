@extends('subdirektorat-inovasi.dosen.index')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Breadcrumb and Header --}}
        <header class="mb-8">
            <nav class="text-sm text-gray-500 mb-3" aria-label="Breadcrumb">
                <ol class="list-none p-0 inline-flex items-center space-x-2">
                    <li><a href="{{ route('subdirektorat-inovasi.dosen.dashboard') }}" class="hover:text-teal-600 transition-colors duration-200">Home</a></li>
                    <li><i class='bx bx-chevron-right text-base text-gray-400'></i></li>
                    <li><a href="{{ route('subdirektorat-inovasi.dosen.apc.manajemen') }}" class="hover:text-teal-600 transition-colors duration-200">Manajemen Proposal</a></li>
                    <li><i class='bx bx-chevron-right text-base text-gray-400'></i></li>
                    <li class="font-medium text-gray-800">Detail Proposal</li>
                </ol>
            </nav>
            <div class="flex items-center justify-between">
                <h1 class="text-2xl lg:text-3xl font-bold text-gray-800 flex items-center">
                    <i class='bx bx-file-blank text-teal-500 mr-3 text-3xl'></i>
                    Detail Proposal APC
                </h1>
                <a href="{{ route('subdirektorat-inovasi.dosen.apc.manajemen') }}" class="inline-flex items-center px-4 py-2 bg-white border-2 border-gray-200 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition-all shadow-sm">
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
                        <p class="text-gray-800 font-semibold leading-relaxed">{{ $submission->judul_artikel }}</p>
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Nama Jurnal (Q1)</label>
                        <p class="text-gray-800 font-medium">{{ $submission->nama_jurnal_q1 }}</p>
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Biaya Publikasi</label>
                        <p class="text-lg font-bold text-green-600">Rp {{ number_format($submission->biaya_publikasi, 0, ',', '.') }}</p>
                    </div>
                    <div class="lg:col-span-2">
                        <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Link ScimagoJR</label>
                        <a href="{{ $submission->link_scimagojr }}" target="_blank" class="text-teal-600 hover:text-teal-800 hover:underline break-all text-sm">{{ $submission->link_scimagojr }}</a>
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Volume</label>
                        <p class="text-gray-800">{{ $submission->volume ?: '-' }}</p>
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Issue</label>
                        <p class="text-gray-800">{{ $submission->issue ?: '-' }}</p>
                    </div>
                </div>

                {{-- Authors Section --}}
                <div class="border-t-2 border-gray-100 pt-6">
                    <h4 class="text-base font-bold text-gray-800 mb-4 flex items-center">
                        <i class='bx bx-group text-indigo-500 mr-2 text-xl'></i>
                        Daftar Penulis
                    </h4>
                    <div class="bg-gray-50 rounded-xl p-4">
                        @if ($submission->authors && $submission->authors->count() > 0)
                            <div class="space-y-3">
                                @foreach ($submission->authors->sortBy('urutan') as $author)
                                    <div class="flex items-start bg-white p-3 rounded-lg border border-gray-200">
                                        <div class="flex-shrink-0 w-8 h-8 bg-gradient-to-br from-indigo-100 to-indigo-200 rounded-lg flex items-center justify-center mr-3">
                                            <span class="text-indigo-600 font-bold text-sm">{{ $author->urutan }}</span>
                                        </div>
                                        <div class="flex-1">
                                            <p class="font-semibold text-gray-800 text-sm">{{ $author->nama }}</p>
                                            <p class="text-xs text-gray-500">{{ $author->afiliasi }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-sm text-gray-500 text-center py-4">Tidak ada data penulis</p>
                        @endif
                    </div>
                </div>

                {{-- Documents Section --}}
                <div class="border-t-2 border-gray-100 pt-6">
                    <h4 class="text-base font-bold text-gray-800 mb-4 flex items-center">
                        <i class='bx bx-cloud-download text-blue-500 mr-2 text-xl'></i>
                        Dokumen Pendukung
                    </h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        <a href="{{ asset('storage/' . $submission->artikel_path) }}" target="_blank" class="flex items-center p-4 bg-gradient-to-br from-red-50 to-red-100 border-2 border-red-200 rounded-xl hover:from-red-100 hover:to-red-200 transition-all duration-200 group">
                            <i class='bx bx-file-pdf text-red-500 text-2xl mr-3 group-hover:scale-110 transition-transform'></i>
                            <div>
                                <p class="font-semibold text-gray-800 text-sm">Artikel</p>
                                <p class="text-xs text-gray-500">Dokumen PDF</p>
                            </div>
                        </a>
                        <a href="{{ asset('storage/' . $submission->invoice_path) }}" target="_blank" class="flex items-center p-4 bg-gradient-to-br from-yellow-50 to-yellow-100 border-2 border-yellow-200 rounded-xl hover:from-yellow-100 hover:to-yellow-200 transition-all duration-200 group">
                            <i class='bx bx-receipt text-yellow-600 text-2xl mr-3 group-hover:scale-110 transition-transform'></i>
                            <div>
                                <p class="font-semibold text-gray-800 text-sm">Invoice</p>
                                <p class="text-xs text-gray-500">Bukti Tagihan</p>
                            </div>
                        </a>
                        <a href="{{ asset('storage/' . $submission->submission_process_path) }}" target="_blank" class="flex items-center p-4 bg-gradient-to-br from-blue-50 to-blue-100 border-2 border-blue-200 rounded-xl hover:from-blue-100 hover:to-blue-200 transition-all duration-200 group">
                            <i class='bx bx-check-shield text-blue-500 text-2xl mr-3 group-hover:scale-110 transition-transform'></i>
                            <div>
                                <p class="font-semibold text-gray-800 text-sm">Bukti Proses</p>
                                <p class="text-xs text-gray-500">Submission</p>
                            </div>
                        </a>
                    </div>
                </div>

                {{-- Status History --}}
                <div class="border-t-2 border-gray-100 pt-6">
                    <h4 class="text-base font-bold text-gray-800 mb-4 flex items-center">
                        <i class='bx bx-history text-purple-500 mr-2 text-xl'></i>
                        Riwayat Status
                    </h4>
                    <div class="bg-gray-50 rounded-xl p-4">
                         @if ($submission->status_history && count($submission->status_history) > 0)
                            <div class="space-y-4">
                                @foreach (array_reverse($submission->status_history) as $log)
                                    <div class="flex items-start space-x-3">
                                        <div class="flex-shrink-0">
                                            <div class="w-8 h-8 bg-gradient-to-br from-purple-100 to-purple-200 rounded-full flex items-center justify-center">
                                                <i class='bx bx-time text-purple-500 text-sm'></i>
                                            </div>
                                        </div>
                                        <div class="flex-1 bg-white p-3 rounded-lg border border-gray-200">
                                            <p class="font-semibold text-gray-800 text-sm">
                                                Status berubah menjadi '{{ $log['status'] }}'
                                            </p>
                                            <p class="text-xs text-gray-500 mt-1">
                                                {{ \Carbon\Carbon::parse($log['timestamp'])->locale('id')->isoFormat('dddd, D MMMM YYYY, HH:mm') }}
                                            </p>
                                            @if (!empty($log['notes']))
                                                <p class="text-xs text-gray-600 italic mt-1">{{ $log['notes'] }}</p>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                         @else
                            <p class="text-sm text-gray-500 text-center py-4">Tidak ada riwayat status</p>
                         @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
